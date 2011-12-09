<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: pagetemplatescatalog.php,v 1.10 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_pageTemplatesCatalog
  *
  *  Manages the collection of page templates.
  *
  * @package Automne
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_pageTemplatesCatalog extends CMS_grandFather
{
	/**
	  * Returns a CMS_pageTemplate when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_pageTemplate
	  * @return CMS_pageTemplate or false on failure to find it
	  * @access public
	  */
	static function getByID($id)
	{
		$pageTemplate = new CMS_pageTemplate($id);
		if ($pageTemplate->hasError()) {
			return false;
		} else {
			return $pageTemplate;
		}
	}

	/**
	  * Returns all the page Templates, sorted by label.
	  * Static function.
	  *
	  * @param boolean $includeInactive If set to true, don't watch inactive templates
	  * @return array(CMS_pageTemplate)
	  * @access public
	  */
	static function getAll($includeInactive = false, $keyword = '', $groups = array(), $website = '', $tplIds = array(), $user = false, $start = 0, $limit = 0, $returnObjects = true, &$score = array()) {
		$where = 'private_pt=0';
		$select = 'id_pt';
		//keywords
		if ($keyword) {
			//clean user keywords (never trust user input, user is evil)
			$keyword = strtr($keyword, ",;", "  ");
			$words=array();
			$words=array_map("trim",array_unique(explode(" ", io::strtolower($keyword))));
			$cleanedWords = array();
			foreach ($words as $aWord) {
				if ($aWord && $aWord!='' && io::strlen($aWord) >= 3) {
					$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
					$cleanedWords[] = $aWord;
				}
			}
			if (!$cleanedWords) {
				//if no words after cleaning, return
				return array();
			}
			//extract row: keywords which are used by general search engine to filter templates by row usage
			$rows = array();
			foreach ($cleanedWords as $key => $word) {
				if (io::strpos($word, 'row:') === 0) {
					unset($cleanedWords[$key]);
					$rows[] = substr($word, 4);
				}
			}
			if ($cleanedWords) {
				$keywordWhere = '';
				foreach ($cleanedWords as $cleanedWord) {
					$keywordWhere .= ($keywordWhere) ? ' and ' : '';
					$keywordWhere .= " (
						description_pt like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
						or label_pt like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
					)";
				}
				$where .= ($where) ? ' and ' : '';
				$where .= " ((".$keywordWhere.") or MATCH (label_pt, description_pt) AGAINST ('".sensitiveIO::sanitizeSQLString($keyword)."') )";
				$select .= " , MATCH (label_pt, description_pt) AGAINST ('".sensitiveIO::sanitizeSQLString($keyword)."') as m ";
			}
			if ($rows) {
				$q = new CMS_query("
					select
						distinct(template_cs)
					from
						mod_standard_clientSpaces_edited
					where
						type_cs in (".io::sanitizeSQLString(implode($rows, ',')).")
				");
				if ($q->getNumRows()) {
					while($r = $q->getArray()) {
						$tplIds[] = $r['template_cs'];
					}
				}
			}
		}
		$sql = "
			select
				".$select."
			from
				pageTemplates
		";
		//groups
		if ($groups) {
			foreach ($groups as $group) {
				$where .= ($where) ? ' and ' : '';
				$where .= " (
					groupsStack_pt='".sensitiveIO::sanitizeSQLString($group)."'
					or groupsStack_pt like '%;".sensitiveIO::sanitizeSQLString($group).";%'
					or groupsStack_pt like '".sensitiveIO::sanitizeSQLString($group).";%'
					or groupsStack_pt like '%;".sensitiveIO::sanitizeSQLString($group)."'
				)";
			}
		}
		//website
		if ($website) {
			$where .= ($where) ? ' and ' : '';
			$where .= " (
				websitesdenied_pt != '".sensitiveIO::sanitizeSQLString($website)."'
				and websitesdenied_pt not like '%;".sensitiveIO::sanitizeSQLString($website).";%'
				and websitesdenied_pt not like '".sensitiveIO::sanitizeSQLString($website).";%'
				and websitesdenied_pt not like '%;".sensitiveIO::sanitizeSQLString($website)."'
			)";
		}
		//useable
		if (!$includeInactive) {
			$where .= ($where) ? ' and ' : '';
			$where .= " inUse_pt=1 ";
			$where .= " and definitionFile_pt!='' ";
		}
		//tplIds
		if ($tplIds) {
			$where .= ($where) ? ' and ' : '';
			$where .= " id_pt in (".implode(',',$tplIds).") ";
		}
		//user
		if (is_object($user) && !$user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$groupsDenied = $user->getTemplateGroupsDenied()->getElements();
			if ($groupsDenied && is_array($groupsDenied) && sizeof($groupsDenied)) {
				$where .= ($where) ? ' and (' : '(';
				foreach ($groupsDenied as $group) {
					$where .= " (
						groupsStack_pt != '".sensitiveIO::sanitizeSQLString($group[0])."'
						and groupsStack_pt not like '%;".sensitiveIO::sanitizeSQLString($group[0]).";%'
						and groupsStack_pt not like '".sensitiveIO::sanitizeSQLString($group[0]).";%'
						and groupsStack_pt not like '%;".sensitiveIO::sanitizeSQLString($group[0])."'
					) and ";
				}
				//remove last "and " and append )
				$where = io::substr($where, 0, -4).')';
			}
		}
		$sql = $sql.($where ? ' where '.$where : '');
		//order
		if (io::strpos($sql, 'MATCH') === false) {
			$sql .= " order by label_pt ";
		} else {
			$sql .= " order by m desc ";
		}
		//limit
		if ($start || $limit) {
			$sql .= " limit ".sensitiveIO::sanitizeSQLString($start).",".sensitiveIO::sanitizeSQLString($limit);
		}
		//pr($sql);
		$q = new CMS_query($sql);
		$pts = array();
		while ($r = $q->getArray()) {
			$id = $r['id_pt'];
			//set match score if exists
			if (isset($r['m'])) {
				$score[$id] = $r['m'];
			}
			if ($returnObjects) {
				$pt = new CMS_pageTemplate($id);
				if (!$pt->hasError()) {
					$pts[$pt->getID()] = $pt;
				}
			} else {
				$pts[$id] = $id;
			}
		}
		return $pts;
	}

	/**
	  * Returns all the page templates within group
	  * Static function
	  *
	  * @param string $group The group the templates belongs to
	  * @return array(CMS_profile_user)
	  * @access public
	  */
	static function getByGroup($group)
	{
		//Hard to shape SQL for that, must instanciate all templates
		$all_templates = CMS_pageTemplatesCatalog::getAll();
		$templates = array();
		foreach ($all_templates as $aTemplate) {
			if ($aTemplate->belongsToGroup($group)) {
				$templates[] = $aTemplate;
			}
		}
		return $templates;
	}


	/**
	  * Get All Groups
	  * Static function
	  *
	  * @return array(string)
	  * @access public
	  */
	static function getAllGroups($returnStack = false)
	{
		static $templateGroups;
		if (!isset($templateGroups)) {
			$templateGroups = array();
			$sql ='
				select distinct
					groupsStack_pt
				from
					pageTemplates
				where 
					private_pt=0
			';
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$groupStackString = $data["groupsStack_pt"];
				$groupStack = new CMS_stack();
				$groupStack->setTextDefinition($groupStackString);
				foreach ($groupStack->getElements() as $group) {
					if (!SensitiveIO::isInSet($group[0],$templateGroups) && $group[0]) {
						$templateGroups[] = $group[0];
					}
				}
			}
		}
		//sort groups
		natcasesort($templateGroups);
		if ($returnStack) {
			$stack = new CMS_stack();
			$stack->setValuesByAtom(1);
			foreach ($templateGroups as $tplGroup) {
				$stack->add($tplGroup);
			}
			return $stack;
		} else {
			return $templateGroups;
		}
	}

	/**
	  * public static getCloneFromID
	  *
	  * Clones a Template, changes some attributes
	  * and writes it to persistence (MySQL for now)
	  *
	  * @param anyTemplateID as the ID of Template to be cloned
	  * @param String label receive a new label for this Template
	  * @param boolean $setPrivate Should the template be set as a private one ?  ALSO determines if the new template should point to the same file
	  * @param boolean $dontCopyClientSpaces Should the clientspaces be copied ?
	  * @param integer $tplFrom the original template ID to get good rows
	  * @return a valid new CMS_pageTemplate
	  */
	static function getCloneFromID($templateID = 0, $label = false, $setPrivate = false, $dontCopyClientSpaces = false, $tplFrom = false)
	{
		$ret = false ;
		$model = new CMS_pageTemplate($templateID);
		if ($model->getID()>0) {
			//New blank one
			$tpl = new CMS_pageTemplate();

			//First write a new object to get it's ID
			$tpl->writeToPersistence();

			//Setting label
			$label = ($label) ? $label : $model->getLabel()  ;
			$tpl->setLabel($label);

			//Copying template definition file (if not private template)
			if ($setPrivate) {
				$filename = $model->getDefinitionFile();
			} else {
				$filename = "pt".$tpl->getID()."_".SensitiveIO::sanitizeAsciiString($tpl->getLabel()).".xml";
			}
			if ($setPrivate || CMS_file::copyTo(PATH_TEMPLATES_FS."/".$model->getDefinitionFile(), PATH_TEMPLATES_FS."/".$filename) ) {
				$tpl->setDefinitionFile($filename);

				//Copying groupsStack from database
				foreach ($model->getGroups() as $grp) {
					$tpl->addGroup($grp);
				}

				//Copying image file from model to a new one
				if ($setPrivate) {
					$tpl->setImage($model->getImage());
				} else {
					if ($model->getImage()) {
						$ext = io::substr($model->getImage(), strrpos($model->getImage(), "."));
						$imagefilename = "pt".$tpl->getID()."_".SensitiveIO::sanitizeAsciiString($tpl->getLabel()).$ext ;
						if (CMS_file::copyTo(PATH_TEMPLATES_IMAGES_FS."/".$model->getImage(), PATH_TEMPLATES_IMAGES_FS."/".$imagefilename) ) {
							$tpl->setImage($imagefilename);
						}
					} else {
						$tpl->setImage();
					}
				}

				//set private if asked to.
				if ($setPrivate) {
					$tpl->setPrivate(true);
				}
				//copy description
				$tpl->setDescription($model->getDescription());

				//websites denied
				$websitesDenied = $model->getWebsitesDenied();
				foreach ($websitesDenied as $websiteId) {
					if (CMS_websitesCatalog::exists($websiteId)) { //to check if website still exists
						$tpl->denyWebsite($websiteId);
					}
				}

				//Copy printing definition
				$tpl->setPrintingClientSpaces($model->getPrintingClientSpaces());

				//Partial update for groups and image
				$tpl->writeToPersistence();

				//Copying template clientspaces rows definitions
				if (!$dontCopyClientSpaces) {
					$suffixes = array('archived', 'deleted', 'edited', 'edition', 'public');
					foreach ($suffixes as $suffix) {
						if ($tplFrom) {
							$sql = "
								select
									*
								from
									`mod_standard_clientSpaces_".$suffix."`
								where
									`template_cs`='".$tplFrom."'
							";
						} else {
							$sql = "
								select
									*
								from
									`mod_standard_clientSpaces_".$suffix."`
								where
									`template_cs`='".$model->getID()."'
							";
						}
						$q = new CMS_query($sql);
						while ($arr = $q->getArray()) {
							$sql1 = "
								insert into
									`mod_standard_clientSpaces_".$suffix."`
								set
									`template_cs`='".$tpl->getID()."',
									`tagID_cs`='".SensitiveIO::sanitizeSQLString($arr["tagID_cs"])."',
									`rowsDefinition_cs`='".SensitiveIO::sanitizeSQLString($arr["rowsDefinition_cs"])."',
									`type_cs`='".$arr["type_cs"]."',
									`order_cs`='".$arr["order_cs"]."'
							";
							$q1 = new CMS_query($sql1);
							unset($q1);
						}
						unset($q);
					}
				}
				//CMS_Template to return
				$ret = $tpl ;
			}
			unset($model);
		}
		if ($tpl) {
			//Clean if any error when out
			if (!$ret) {
				$tpl->destroy();
			}
			unset($tpl);
		}
		return $ret ;
	}

	/**
	  * Return a template ID corresponding of a given clone ID
	  *
	  * @param integer cloneID : the clone ID to get template ID
	  * @return integer : the template ID or false if none founded
	  * @access public
	  */
	static function getTemplateIDForCloneID($cloneID) {
		$sql = "
			select
				definitionFile_pt
			from
				pageTemplates
			where
				id_pt = '".sensitiveIO::sanitizeSQLString($cloneID)."'
		";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			return false;
		} else {
			$definition = $q->getValue('definitionFile_pt');
		}
		if (!$definition) {
			return false;
		}
		$sql="
			select
				id_pt
			from
				pageTemplates
			where
				private_pt='0'
				and definitionFile_pt = '".$definition."'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return $q->getValue('id_pt');
		} else {
			return false;
		}
	}

	/**
	  * Return pages IDs coresponding of a given template ID
	  *
	  * @param integer/CMS_pageTemplate templateID : the template to get pagesIDs
	  * @param boolean returnObjects : to return pages objects or pages IDs
	  * @return array : pages IDs or pages objects
	  * @access public
	  */
	static function getPagesByTemplate($template, $returnObjects = false) {
		$return = array();
		$error = false;
		if(SensitiveIO::isPositiveInteger($template)){
			$template = new CMS_pageTemplate($template);
			if($template->hasError()){
				$error = true;
			}
		} elseif(!is_a($template,'CMS_pageTemplate') || $template->hasError()){
			$error = true;
		}
		if($error){
			CMS_grandFather::raiseError('Template must be a valid CMS_pageTemplate ID or a valid CMS_pageTemplate object (line '.__LINE__.')');
			return $return;
		} elseif($definition = $template->getDefinitionFile()) {
			$sql="
				select
					id_pag
				from
					pages,
					pageTemplates
				where
					definitionFile_pt = '".$definition."'
					and template_pag = id_pt
				order by
					id_pag
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while ($id = $q->getValue('id_pag')) {
					if($returnObjects){
						if($page = CMS_tree::getPageByID($id)){
							$return[$id] = $page;
						}
					} else {
						$return[$id] = $id;
					}
				}
			}
		}
		return $return;
	}

	/**
	  * Get all templates replacement for a given template
	  *
	  * @param CMS_pageTemplate $tplFrom : the template to get replacements
	  * @param CMS_profile_user $cms_user : user to get template replacements (to check rights)
	  * @param integer $pageId : user to get template replacements (to check websites)
	  * @return array : templates replacements array('match' => array(CMS_pageTemplate), 'nomatch' => array(CMS_pageTemplate));
	  * @access public
	  */
	static function getTemplatesReplacement($tplFrom, $user, $pageId = false) {
		if (!is_a($tplFrom, "CMS_pageTemplate")) {
			CMS_grandFather::raiseError('Template must be a valid CMS_pageTemplate object');
			return array('match' => array(), 'nomatch' => array());
		}
		//get website id if page id is provided
		$websiteId = '';
		if (sensitiveIO::isPositiveInteger($pageId)) {
			$page = CMS_tree::getPageByID($pageId);
			if ($page) {
				$website = $page->getWebsite();
				if ($website) {
					$websiteId = $website->getID();
				}
			}
		}
		//All templates avalaibles for this user and page website
		$templatesReplacements = CMS_pageTemplatesCatalog::getAll(false, '', array(), $websiteId, array(), $user);

		$matchTpl = array();
		$notMatchTpl = array();
		//modules called in tplFrom
		$tplFromModules = $tplFrom->getModules();

		//clientSpaces in tplFrom
		$csFrom = $tplFrom->getClientSpacesTags();

		$oldClientSpaces = array();
		foreach ($csFrom as $tag) {
			$id = $tag->getAttribute("id") ? $tag->getAttribute("id") : 'NO ID';
			$oldClientSpaces[$tag->getAttribute("module")][] = $id;
		}
		//then check each templates
		foreach ($templatesReplacements as $tplTo) {
			$match = true;
			//remove templates wich not use same modules
			$tplToModules = $tplTo->getModules();
			if ($tplToModules != $tplFromModules) {
				$match = false;
			}
			//check for template number (must be greater or egual)
			if ($match) {
				$csTo = $tplTo->getClientSpacesTags();
				if (sizeof($csTo) < sizeof($csFrom)) {
					$match = false;
				}
			}
			//search all tpl from in tpl to
			if ($match) {
				$newClientSpaces = array();
				foreach ($csTo as $tag) {
					$id = $tag->getAttribute("id") ? $tag->getAttribute("id") : 'NO ID';
					$newClientSpaces[$tag->getAttribute("module")][] = $id;
				}
				foreach($oldClientSpaces as $module => $moduleCs) {
					foreach ($moduleCs as $csId) {
						//search id in from tpl
						if (!isset($newClientSpaces[$module]) || !in_array($csId, $newClientSpaces[$module])) {
							$match = false;
						}
					}
				}
			}
			if ($match) {
				//here templates match so add it to the array
				$matchTpl[] = $tplTo;
			} else {
				$notMatchTpl[] = $tplTo;
			}
		}
		//sort tables by template labels
		$sortfunc = create_function('$a,$b', 'return strnatcasecmp($a->getLabel(), $b->getLabel());');
		if ($sortfunc) {
			if ($matchTpl) usort($matchTpl, $sortfunc);
			if ($notMatchTpl) usort($notMatchTpl, $sortfunc);
		}
		//then return array of templates
		return array('match' => $matchTpl, 'nomatch' => $notMatchTpl);
	}
}
?>