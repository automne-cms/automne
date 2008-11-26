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

// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: rowscatalog.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_rowsCatalog
  *
  * Represents a collection of rows
  *
  * @package CMS
  * @subpackage module
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_rowsCatalog extends CMS_grandFather
{
	/**
	  * Return a row by its ID (and tagID)
	  *
	  * @param integer $id The DB ID of the wanted row
	  * @param integer $tagID The tag ID attribute of the wanted row
	  * @return CMS_row
	  * @access public
	  */
	function getByID($id, $tagID = false)
	{
		$row = new CMS_row($id, $tagID);
		if (!$row->hasError()) {
			return $row;
		} else {
			return false;
		}
	}

	/**
	  * Return all the rows available
	  *
	  * @param CMS_profile_user $cms_user : restrict to user rights on modules (default : false)
	  * @param integer $tplId : restrict to rows usable in given template (default : false)
	  * @param string $csId : restrict to rows usable in given clientspace (default : false)
	  * @param integer $start : start position
	  * @param integer $limit : limit position
	  * @param integer $count : number of rows founded (passed by reference)
	  * @access public
	  */
	function getAll($includeInactive = false, $keyword = '', $groups = array(), $rowIds = array(), $user = false, $tplId = false, $csId = false, $start = 0, $limit = 0, $returnObjects = true) {
		$sql = "
			select
				id_row
			from
				mod_standard_rows
		";
		$where = '';
		//keywords
		if ($keyword) {
			//clean user keywords (never trust user input, user is evil)
			$keyword = strtr($keyword, ",;", "  ");
			$words=array();
			$words=array_map("trim",array_unique(explode(" ", strtolower($keyword))));
			$cleanedWords = array();
			foreach ($words as $aWord) {
				if ($aWord && $aWord!='' && strlen($aWord) >= 3) {
					$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
					if (htmlentities($aWord) != $aWord) $cleanedWords[] = htmlentities($aWord);
					$cleanedWords[] = $aWord;
				}
			}
			if (!$cleanedWords) {
				//if no words after cleaning, return
				return array();
			}
			foreach ($cleanedWords as $cleanedWord) {
				$where .= ($where) ? ' and ' : '';
				$where .= " (
					description_row like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
					or label_row like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
				)";
			}
		}
		//groups
		if ($groups) {
			foreach ($groups as $group) {
				$where .= ($where) ? ' and ' : '';
				$where .= " (
					groupsStack_row='".sensitiveIO::sanitizeSQLString($group)."'
					or groupsStack_row like '%;".sensitiveIO::sanitizeSQLString($group).";%'
					or groupsStack_row like '".sensitiveIO::sanitizeSQLString($group).";%'
					or groupsStack_row like '%;".sensitiveIO::sanitizeSQLString($group)."'
				)";
			}
		}

		//useable
		if (!$includeInactive) {
			$where .= ($where) ? ' and ' : '';
			$where .= " useable_row=1 ";
		}
		//rowIds
		if ($rowIds) {
			$where .= ($where) ? ' and ' : '';
			$where .= " id_row in (".implode(',',$rowIds).") ";
		}
		if ($tplId) {
			$where .= ($where) ? ' and ' : '';
			$where .= " (
				tplfilter_row=''
				or tplfilter_row='".sensitiveIO::sanitizeSQLString($tplId)."'
				or tplfilter_row like '%;".sensitiveIO::sanitizeSQLString($tplId).";%'
				or tplfilter_row like '".sensitiveIO::sanitizeSQLString($tplId).";%'
				or tplfilter_row like '%;".sensitiveIO::sanitizeSQLString($tplId)."'
			) ";
		}
		//user
		if (is_object($user) && !$user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$groupsDenied = $user->getRowGroupsDenied();
			if ($groupsDenied) {
				$where .= ($where) ? ' and (' : '(';
				foreach ($groupsDenied as $group) {
					$where .= " (
						groupsStack_row != '".sensitiveIO::sanitizeSQLString($group[0])."'
						and groupsStack_row not like '%;".sensitiveIO::sanitizeSQLString($group[0]).";%'
						and groupsStack_row not like '".sensitiveIO::sanitizeSQLString($group[0]).";%'
						and groupsStack_row not like '%;".sensitiveIO::sanitizeSQLString($group[0])."'
					) or";
				}
				//remove last "or" and append )
				$where = substr($where, 0, -2).')';
			}
		}
		$sql = $sql.($where ? ' where '.$where : '');
		//order
		$sql .= " order by label_row ";
		//limit
		if ($start || $limit) {
			$sql .= " limit ".sensitiveIO::sanitizeSQLString($start).",".sensitiveIO::sanitizeSQLString($limit);
		}
		//pr($sql);
		$q = new CMS_query($sql);
		$rows = array();
		while ($id = $q->getValue("id_row")) {
			if ($returnObjects) {
				$row = new CMS_row($id);
				if (!$row->hasError()) {
					$rows[$row->getID()] = $row;
				}
			} else {
				$rows[$id] = $id;
			}
		}
		return $rows;
	}

	/**
	  * Get All Groups
	  * Static function
	  *
	  * @return array(string)
	  * @access public
	  */
	function getAllGroups($returnStack = false, $reset = false) {
		static $rowGroups;
		if (!isset($rowGroups) || $reset) {
			$rowGroups = array();
			$sql ='
				select distinct
					groupsStack_row
				from
					mod_standard_rows
			';
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$groupStackString = $data["groupsStack_row"];
				$groupStack = new CMS_stack();
				$groupStack->setTextDefinition($groupStackString);
				foreach ($groupStack->getElements() as $group) {
					if (!SensitiveIO::isInSet($group[0],$rowGroups) && $group[0]) {
						$rowGroups[] = $group[0];
					}
				}
			}
		}
		if ($returnStack) {
			$stack = new CMS_stack();
			$stack->setValuesByAtom(1);
			foreach ($rowGroups as $rowGroup) {
				$stack->add($rowGroup);
			}
			return $stack;
		} else {
			return $rowGroups;
		}
	}

	/**
	  * Return pages IDs coresponding of a given row ID
	  *
	  * @param integer rowID : the row to get pagesIDs
	  * @param boolean returnObjects : to return pages objects or pages IDs
	  * @param boolean public : targets edited or public clientspaces
	  * @return array : pages IDs or pages objects
	  * @access public
	  */
	function getPagesByRow($rowID, $returnObjects = false, $public = false) {
		$return = array();
		if(!SensitiveIO::isPositiveInteger($rowID)){
			CMS_grandFather::raiseError('rowID must be a positive integer');
			return $return;
		}
		$clientSpacesTable = ($public) ? 'mod_standard_clientSpaces_public' : 'mod_standard_clientSpaces_edited';
		$sql="
			select
				distinct id_pag
			from
				pages,
				".$clientSpacesTable."
			where
				type_cs = '".$rowID."'
				and template_cs = template_pag
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
		return $return;
	}

	/**
	  * Return rows ID used by a given page
	  *
	  * @param integer pageId : the row to get pagesIDs
	  * @param boolean returnObjects : to return rows objects or rows IDs (default : false)
	  * @return array : rows IDs or rows objects
	  * @access public
	  */
	function getRowsByPage($pageId, $returnObjects = false) {
		$rows = array();
		if(!SensitiveIO::isPositiveInteger($pageId)){
			CMS_grandFather::raiseError('pageId must be a positive integer');
			return $rows;
		}
		$clientSpacesTables = array(
			'mod_standard_clientSpaces_public',
			'mod_standard_clientSpaces_edited',
			'mod_standard_clientSpaces_edition'
		);
		foreach ($clientSpacesTables as $clientSpacesTable) {
			$sql="
				select
					type_cs
				from
					pages,
					".$clientSpacesTable."
				where
					id_pag = ".$pageId."
					and template_cs = template_pag
				order by
					type_cs
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while (($id = $q->getValue('type_cs')) !== false) {
					if (!isset($rows[$id])) {
						if($returnObjects){
							if($row = CMS_rowsCatalog::getByID($id)){
								$rows[$id] = $row;
							}
						} else {
							$rows[$id] = $id;
						}
					}
				}
			}
		}
		return $rows;
	}

	/**
	  * Return all rows icons available on the server
	  *
	  * @return array : rows images path (from webroot)
	  * @access public
	  */
	function getAllIcons() {
		//read img dir
		$availableExtensions = array('gif', 'png', 'jpg');
		try{
			foreach ( new DirectoryIterator(PATH_TEMPLATES_ROWS_FS.'/images/') as $file) {
				if ($file->isFile() && in_array(strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION)), $availableExtensions)) {
					$images[] = PATH_TEMPLATES_ROWS_WR.'/images/'.$file->getFilename();
				}
			}
		} catch(Exception $e) {}

		return $images;
	}
}
?>