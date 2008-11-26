<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: search.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_search
  *
  * @package CMS
  * @subpackage common
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */

class CMS_search extends CMS_grandFather {
	const SEARCH_TYPE_DEFAULT = 'keywords';
	const SEARCH_TYPE_LINKTO = 'linkFrom';
	const SEARCH_TYPE_LINKFROM = 'linkTo';
	const SEARCH_TYPE_TEMPLATE = 'template';
	const SEARCH_TYPE_ROW = 'row';
	
	const MAX_RESULTS_BY_PAGE = "20";
	// Messages
	const MESSAGE_RESULTS_NOTHING = 1408;
	const MESSAGE_RESULTS_LIST = 1409;
	const MESSAGE_RESULTS_RELATIONS = 1411;
	const MESSAGE_RESULTS_LINKS = 1410;
	const MESSAGE_RESULTS_KEYWORDS = 1412;
	const MESSAGE_RESULTS_TEMPLATES = 1435;
	const MESSAGE_RESULTS_TEMPLATE = 1436;
	const MESSAGE_RESULTS_ROW = 1437;
	const MESSAGE_RESULTS_ROWS = 1438;
	const MESSAGE_RESULTS_AND = 1413;
	const MESSAGE_RESULTS_OR = 1415;
	const MESSAGE_RESULTS_IDS = 1416;
	
	/**
	  * Get all search codes
	  *
	  * @return array of CMS_search search codes
	  * @access public
	  */
	function getAllCodes(){
		return array(
			self::SEARCH_TYPE_DEFAULT,
			self::SEARCH_TYPE_LINKTO,
			self::SEARCH_TYPE_LINKFROM,
			self::SEARCH_TYPE_TEMPLATE,
			self::SEARCH_TYPE_ROW
		);
	}
	
	/**
	  * Get the search.
	  *
	  * @return array of CMS_page the result pages
	  * @access public
	  * param integer $searchType : the type of the search (see constants)
	  */
	function getSearch($keywords,&$user, $start='0', $max=self::MAX_RESULTS_BY_PAGE,$public=false){
		if(is_a($user,'CMS_profile_user')){
			$cms_language = $user->getLanguage();
		} else {
			$cms_language = new CMS_language('fr');
		}
		$results = array();
		$messages = array();
		$message = '';
		$foundLinkToIDs = $foundLinkFromIDs = $foundPagesFromTemplate = $foundPagesFromRow = array();
		// Clean keywords
		$keywords = SensitiveIO::sanitizeSQLString($keywords);
		$keywords = strtr($keywords, ",;", "  ");
		$blocks=array();
		$blocks=array_map("trim",array_unique(explode(" ", $keywords)));
		$cleanedBlocks = array();
		foreach ($blocks as $block) {
			if ($block !== '' && (strlen($block) >= 3 || sensitiveIO::isPositiveInteger($block))) {
				$block = str_replace(array('%','_'), array('\%','\_'), $block);
				if (htmlentities($block) != $block) {
					$cleanedBlocks[] = htmlentities($block);
				}
				$cleanedBlocks[] = $block;
			}
		}
		// Separate block codes
		if($cleanedBlocks){
			$allDatas = array();
			$allCodes = CMS_search::getAllCodes();
			foreach($allCodes as $code){
				$datas = array();
				foreach (array_keys($cleanedBlocks) as $key){
					if(strstr($cleanedBlocks[$key],$code.':')){
						$datas[]=$cleanedBlocks[$key];
						unset($cleanedBlocks[$key]);
					}
				}
				if($datas){
					$allDatas[$code] = $datas;
				}
			}
			$allDatas[self::SEARCH_TYPE_DEFAULT] = $cleanedBlocks;
			// Get IDs from all specific codes
			$foundIDs = array();
			$allLinksNumber = 0;
			foreach($allCodes as $code){
				switch($code){
					case self::SEARCH_TYPE_LINKTO:
						if(isset($allDatas[self::SEARCH_TYPE_LINKTO])){
							$foundLinkToIDs = array();
							$where='';
							$count = 0;
							$messagesIDs = array();
							foreach ($allDatas[self::SEARCH_TYPE_LINKTO] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$where.= ($count) ? ' or ':'';
									$count++;
									$messagesIDs[] = $tabValues[1];
									$where .= " start_lre = '".$tabValues[1]."' ";
								}
							}
							if($where){
								$select = ' stop_lre ';
								$from = 'linx_real_public';
								$sql ="
									select
										".$select."
									from
										".$from."
									where
										".$where;
								$q = new CMS_query($sql);
								$arr = array();
								while ($arr = $q->getArray()){
									$foundLinkToIDs[]=$arr["stop_lre"];
								}
							}
							if($messagesIDs){
								$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_RELATIONS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}
						}
					break;
					case self::SEARCH_TYPE_LINKFROM:
						if(isset($allDatas[self::SEARCH_TYPE_LINKFROM])){
							$foundLinkFromIDs = array();
							$where='';
							$count = 0;
							$messagesIDs = array();
							foreach ($allDatas[self::SEARCH_TYPE_LINKFROM] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$where.= ($count) ? ' or ':'';
									$count++;
									$messagesIDs[] = $tabValues[1];
									$where .= " stop_lre = '".$tabValues[1]."' ";
								}
							}
							if($where){
								$select = ' start_lre ';
								$from = 'linx_real_public';
								$sql ="
									select
										".$select."
									from
										".$from."
									where
										".$where;
								$q = new CMS_query($sql);
								$arr = array();
								while ($arr = $q->getArray()){
									$foundLinkFromIDs[]=$arr["start_lre"];
								}
								// Count links number
								$allLinksNumber += count($foundLinkFromIDs);
							}
							if($messagesIDs){
								$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_LINKS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}
						}
					break;
					case self::SEARCH_TYPE_TEMPLATE:
						if(isset($allDatas[self::SEARCH_TYPE_TEMPLATE])){
							$foundPagesFromTemplate = array();
							$messagesIDs = array();
							foreach ($allDatas[self::SEARCH_TYPE_TEMPLATE] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$template = new CMS_pageTemplate($tabValues[1]);
									$messagesIDs[] = '"'.$template->getLabel().'"';
									$foundPagesFromTemplate = array_unique(array_merge(CMS_pageTemplatesCatalog::getPagesByTemplate($tabValues[1]),$foundPagesFromTemplate));
								}
							}
							$allLinksNumber += count($foundPagesFromTemplate);
							if($messagesIDs){
								$message = (count($messagesIDs) > 1) ? self::MESSAGE_RESULTS_TEMPLATES : self::MESSAGE_RESULTS_TEMPLATE;
								$messages[] = $cms_language->getMessage($message,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}
						}
					break;
					case self::SEARCH_TYPE_ROW:
						if(isset($allDatas[self::SEARCH_TYPE_ROW])){
							$foundPagesFromRow = array();
							$messagesIDs = array();
							foreach ($allDatas[self::SEARCH_TYPE_ROW] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$row = new CMS_row($tabValues[1]);
									$messagesIDs[] = '"'.$row->getLabel().'"';
									$foundPagesFromRow = array_unique(array_merge(CMS_rowsCatalog::getPagesByRow($tabValues[1]),CMS_rowsCatalog::getPagesByRow($tabValues[1], false, true),$foundPagesFromRow));
								}
							}
							$allLinksNumber += count($foundPagesFromRow);
							if($messagesIDs){
								$message = (count($messagesIDs) > 1) ? self::MESSAGE_RESULTS_ROWS : self::MESSAGE_RESULTS_ROW;
								$messages[] = $cms_language->getMessage($message,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}
						}
					break;
				}
			}
			$foundIDs = array_unique(array_merge($foundLinkToIDs, $foundLinkFromIDs, $foundPagesFromTemplate, $foundPagesFromRow));
			// Main sql request (keywords)
			if($allDatas[self::SEARCH_TYPE_DEFAULT]){
			$count = 0;
			$where='';
				$messagesWords = array();
				$messagesIdentifiers = array();
				foreach ($allDatas[self::SEARCH_TYPE_DEFAULT] as $block) {
					$where.= ($count) ? ' or ':'';
					$count++;
					if (SensitiveIO::isPositiveInteger($block)) {
						$messagesIdentifiers[] = '"'.$block.'"';
						$where .=" (page_pbd like '%".$block."%')";
					} else {
						$messagesWords[] = '"'.$block.'"';
						$where .= " (
							title_pbd like '".$block."%'
							or linkTitle_pbd like '%".$block."%'
							or keywords_pbd like '%".$block."%'
							or description_pbd like '%".$block."%'
							or category_pbd like '%".$block."%'
						)";
					}
				}
				if($messagesWords){
					$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_KEYWORDS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesWords)),MOD_STANDARD_CODENAME);
					$order = " title_pbd ";
				} else {
					$order = " id_pbd ";
				}
				if($messagesIdentifiers){
					$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_IDS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIdentifiers)),MOD_STANDARD_CODENAME);
				}
				if($allDatas[self::SEARCH_TYPE_DEFAULT] && $foundIDs){
					$where .= " and ";
				}
				if($foundIDs){
					$where .= " page_pbd in (".implode($foundIDs,',').") ";
				}
				// Set SQL
				$select = ' page_pbd ';
				$from = ($public) ? 'pagesBaseData_public':'pagesBaseData_edited';
				$sql ="
					select
						".$select."
					from
						".$from."
					where
						".$where."
					order by
						".$order."
				";
				$q = new CMS_query($sql);
				$results = array();
				$count=0;
				while ($arr = $q->getArray()) {
					$id = $arr["page_pbd"];
					if ($user->hasPageClearance($id, CLEARANCE_PAGE_VIEW)) {
						$count++;
						if ($count>$start && sizeof($results)<$max) {
							$results[] = $id;
						}
					}
				}
			}
			// If no main sql request (keywords), but results from other search types
			if(!$allDatas[self::SEARCH_TYPE_DEFAULT] && $foundIDs){
				$count=0;
				$results = array();
				foreach ($foundIDs as $id) {
					$count++;
					if ($count > $start && sizeof($results)<$max) {
						$results[] = $id;
					}
				}
				sort($results);
			}
			// Set message
			if($messages){
				$counter = 0;
				$message = $cms_language->getMessage(self::MESSAGE_RESULTS_LIST).' ';
				foreach($messages as $messageToDisplay){
					$message .= ($counter) ? $cms_language->getMessage(self::MESSAGE_RESULTS_AND) : '';
					$counter++;
					$message .= ($counter <= count($messages)) ? ' ' : '';
					$message .= $messageToDisplay;
					$message .= ($counter == count($messages)) ? '.' : ' ';
				}
			}
		}
		// Create CMS_page tab results
		if($results){
			foreach (array_keys($results) as $key){
				$page = new CMS_page($results[$key]);
				if (!$page->hasError()) {
					$results[$key] = $page;
				}
			}
		} else {
			$message = ($message) ? $message : $cms_language->getMessage(self::MESSAGE_RESULTS_NOTHING);
			// No results
			$count = 0;
			$results = false;
		}
		return array(
			'nbresult'		=>	$count,
			'nblinksresult'	=>	$allLinksNumber,
			'results'		=>	$results,
			'message'		=>	$message
		);
	}
}
?>