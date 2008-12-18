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
// $Id: search.php,v 1.2 2008/12/18 10:39:46 sebastien Exp $

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
	function getSearch($keywords, $user, $public = false, $withPageContent = false){
		if(is_a($user,'CMS_profile_user')){
			$cms_language = $user->getLanguage();
		} else {
			$cms_language = new CMS_language('fr');
		}
		$results = array();
		/*$messages = array();
		$message = '';*/
		$where = $order = '';
		$foundLinkToIDs = $foundLinkFromIDs = $foundPagesFromTemplate = $foundPagesFromRow = $matches = array();
		// Clean keywords
		$keywords = SensitiveIO::sanitizeSQLString($keywords);
		$keywords = strtr($keywords, ",;", "  ");
		$blocks=array();
		$blocks=array_map("trim",array_unique(explode(" ", $keywords)));
		$cleanedBlocks = array();
		foreach ($blocks as $block) {
			if ($block !== '' || sensitiveIO::isPositiveInteger($block)) {
				$block = str_replace(array('%','_'), array('\%','\_'), $block);
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
							/*$messagesIDs = array();*/
							foreach ($allDatas[self::SEARCH_TYPE_LINKTO] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$where.= ($count) ? ' or ':'';
									$count++;
									/*$messagesIDs[] = $tabValues[1];*/
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
							/*if($messagesIDs){
								$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_RELATIONS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}*/
						}
					break;
					case self::SEARCH_TYPE_LINKFROM:
						if(isset($allDatas[self::SEARCH_TYPE_LINKFROM])){
							$foundLinkFromIDs = array();
							$where='';
							$count = 0;
							/*$messagesIDs = array();*/
							foreach ($allDatas[self::SEARCH_TYPE_LINKFROM] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$where.= ($count) ? ' or ':'';
									$count++;
									/*$messagesIDs[] = $tabValues[1];*/
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
							/*if($messagesIDs){
								$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_LINKS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}*/
						}
					break;
					case self::SEARCH_TYPE_TEMPLATE:
						if(isset($allDatas[self::SEARCH_TYPE_TEMPLATE])){
							$foundPagesFromTemplate = array();
							/*$messagesIDs = array();*/
							foreach ($allDatas[self::SEARCH_TYPE_TEMPLATE] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$template = new CMS_pageTemplate($tabValues[1]);
									//$messagesIDs[] = '"'.$template->getLabel().'"';
									$foundPagesFromTemplate = array_unique(array_merge(CMS_pageTemplatesCatalog::getPagesByTemplate($tabValues[1]),$foundPagesFromTemplate));
								}
							}
							$allLinksNumber += count($foundPagesFromTemplate);
							/*if($messagesIDs){
								$message = (count($messagesIDs) > 1) ? self::MESSAGE_RESULTS_TEMPLATES : self::MESSAGE_RESULTS_TEMPLATE;
								$messages[] = $cms_language->getMessage($message,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}*/
						}
					break;
					case self::SEARCH_TYPE_ROW:
						if(isset($allDatas[self::SEARCH_TYPE_ROW])){
							$foundPagesFromRow = array();
							//$messagesIDs = array();
							foreach ($allDatas[self::SEARCH_TYPE_ROW] as $block) {
								$tabValues = explode(':',$block);
								if(SensitiveIO::isPositiveInteger($tabValues[1])){
									$row = new CMS_row($tabValues[1]);
									//$messagesIDs[] = '"'.$row->getLabel().'"';
									$foundPagesFromRow = array_unique(array_merge(CMS_rowsCatalog::getPagesByRow($tabValues[1]),CMS_rowsCatalog::getPagesByRow($tabValues[1], false, true),$foundPagesFromRow));
								}
							}
							$allLinksNumber += count($foundPagesFromRow);
							/*if($messagesIDs){
								$message = (count($messagesIDs) > 1) ? self::MESSAGE_RESULTS_ROWS : self::MESSAGE_RESULTS_ROW;
								$messages[] = $cms_language->getMessage($message,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIDs)),MOD_STANDARD_CODENAME);
							}*/
						}
					break;
				}
			}
			$foundIDs = array_unique(array_merge($foundLinkToIDs, $foundLinkFromIDs, $foundPagesFromTemplate, $foundPagesFromRow));
			// Main sql requests (for pageId and keywords)
			if($allDatas[self::SEARCH_TYPE_DEFAULT]){
				$count = 0;
				$where='';
				/*$messagesWords = array();
				$messagesIdentifiers = array();*/
				foreach ($allDatas[self::SEARCH_TYPE_DEFAULT] as $key => $block) {
					if (SensitiveIO::isPositiveInteger($block)) {
						$where.= ($count) ? ' or ':'';
						$count++;
						//$messagesIdentifiers[] = '"'.$block.'"';
						$where .=" (page_pbd like '%".$block."%')";
						unset($allDatas[self::SEARCH_TYPE_DEFAULT][$key]);
					}
				}
				$order = '';
				if ($allDatas[self::SEARCH_TYPE_DEFAULT]) {
					$suffix = ($public) ? '_public' : '_edited';
					//$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_KEYWORDS,array($keywords),MOD_STANDARD_CODENAME);
					if (!$withPageContent) {
						//Search in page metadatas
						$count = 0;
						foreach ($allDatas[self::SEARCH_TYPE_DEFAULT] as $block) {
							$where.= ($count) ? ' or ':'';
							$count++;
							$where .= " (
								title_pbd like '%".$block."%'
								or linkTitle_pbd like '%".$block."%'
								or keywords_pbd like '%".$block."%'
								or description_pbd like '%".$block."%'
								or category_pbd like '%".$block."%'
							)";
							
						}
						if($foundIDs){
							$where .= " and page_pbd in (".implode($foundIDs,',').") ";
						}
						// Set SQL
						$sql ="
							select
								page_pbd
							from
								pagesBaseData".$suffix."
							where
								".$where."
						";
						$q = new CMS_query($sql);
						//pr($sql);
						$results = array();
						$count=0;
						$foundIDs = array();
						while ($id = $q->getValue('page_pbd')) {
							$foundIDs[] = $id;
						}
						
						$order = "
					 		order by title_pbd asc
						";
					} else {
						//Search in page content (fulltext search)
						$keywords = implode(' ', $allDatas[self::SEARCH_TYPE_DEFAULT]);
						$selects = array(
							'pagesBaseData'.$suffix 	=> array('page' => 'page_pbd', 	'match' => 'title_pbd,linkTitle_pbd,keywords_pbd,description_pbd'),
							'blocksVarchars'.$suffix	=> array('page' => 'page', 		'match' => 'value'),
							'blocksTexts'.$suffix		=> array('page' => 'page', 		'match' => 'value', 'entities' => true),
							'blocksImages'.$suffix		=> array('page' => 'page', 		'match' => 'label'),
							'blocksFiles'.$suffix		=> array('page' => 'page', 		'match' => 'label'),
						);
						$matches = array();
						foreach ($selects as $table => $select) {
							// Set SQL
							$sql ="
								select 
									".$select['page']." as pageId, MATCH (".$select['match'].") AGAINST ('".sensitiveIO::sanitizeSQLString($keywords)."') as m1
									".(isset($select['entities']) && $keywords != htmlentities($keywords) ? " , MATCH (".$select['match'].") AGAINST ('".sensitiveIO::sanitizeSQLString(htmlentities($keywords))."') as m2 ": '')."
								from 
									".$table."
								where 
									MATCH (".$select['match'].") AGAINST ('".sensitiveIO::sanitizeSQLString($keywords)."')
									".(isset($select['entities']) && $keywords != htmlentities($keywords) ? " or MATCH (".$select['match'].") AGAINST ('".sensitiveIO::sanitizeSQLString(htmlentities($keywords))."') ": '')."
								";
							//pr($sql);
							$q = new CMS_query($sql);
							while ($r = $q->getArray()) {
								if (!isset($matches[$r['pageId']]) || (isset($matches[$r['pageId']]) && $r['m1'] > $matches[$r['pageId']])) {
									$matches[$r['pageId']] = $r['m1'];
								}
								if (isset($r['m2']) && (!isset($matches[$r['pageId']]) || (isset($matches[$r['pageId']]) && $r['m2'] > $matches[$r['pageId']]))) {
									$matches[$r['pageId']] = $r['m2'];
								}
							}
						}
						//sort page Ids by relevance
						arsort($matches, SORT_NUMERIC);
						//$matches = array_keys($matches);
						
						$order = "
					 		order by field(page_pbd, ".implode(',',array_reverse(array_keys($matches))).") desc
						";
						
						$foundIDs = ($foundIDs) ? array_intersect(array_keys($matches), $foundIDs) : array_keys($matches);
					}
				} else {
					$order = " order by page_pbd ";
				}
				
				/*if($messagesIdentifiers){
					$messages[] = $cms_language->getMessage(self::MESSAGE_RESULTS_IDS,array(implode(' '.$cms_language->getMessage(self::MESSAGE_RESULTS_OR).' ',$messagesIdentifiers)),MOD_STANDARD_CODENAME);
				}*/
			}
			if ($foundIDs) {
				$select = ' page_pbd ';
				$from = ($public) ? 'pagesBaseData_public':'pagesBaseData_edited';
				$where .= ($where && $foundIDs) ? " and " : '';
				$where .= ($foundIDs) ? " page_pbd in (".implode($foundIDs,',').") " : '';
				if ($where) {
					// Set SQL
					$sql ="
						select
							".$select."
						from
							".$from."
						where
							".$where."
						".$order."
					";
					$q = new CMS_query($sql);
					//pr($sql);
					$results = array();
					$count=0;
					while ($arr = $q->getArray()) {
						$id = $arr["page_pbd"];
						if ($user->hasPageClearance($id, CLEARANCE_PAGE_VIEW)) {
							$count++;
							$results[$id] = $id;
						}
					}
				}
			}
			
			// Set message
			/*if($messages){
				$counter = 0;
				$message = $cms_language->getMessage(self::MESSAGE_RESULTS_LIST).' ';
				foreach($messages as $messageToDisplay){
					$message .= ($counter) ? $cms_language->getMessage(self::MESSAGE_RESULTS_AND) : '';
					$counter++;
					$message .= ($counter <= count($messages)) ? ' ' : '';
					$message .= $messageToDisplay;
					$message .= ($counter == count($messages)) ? '.' : ' ';
				}
			}*/
		} else {
			//$message = ($message) ? $message : $cms_language->getMessage(self::MESSAGE_RESULTS_NOTHING);
			// No results
			$count = 0;
		}
		
		return array(
			'nbresult'		=>	$count,
			'nblinksresult'	=>	$allLinksNumber,
			'results'		=>	$results,
			'score'			=>	$matches,
			/*'message'		=>	$message*/
		);
	}
}
?>