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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+

/**
 * Class CMS_rowsCatalog
 *
 * Represents a collection of rows
 *
 * @package Automne
 * @subpackage standard
 * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
 * @author Julien Breux <julien.breux@gmail.com>
 */
class CMS_rowsCatalog extends CMS_grandFather {

	/**
	 * Return a row by its ID (and tagID)
	 *
	 * @param integer $id The DB ID of the wanted row
	 * @param integer $tagID The tag ID attribute of the wanted row
	 * @return CMS_row
	 * @access public
	 */
	function getByID($id, $tagID = false) {
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
	function getAll($includeInactive = false, $keyword = '', $groups = array(), $rowIds = array(), $user = false, $tplId = false, $csId = false, $start = 0, $limit = 0, $returnObjects = true, &$score = array()) {
		$select = 'id_row';
		$where = '';
		//keywords
		if ($keyword) {
			//clean user keywords (never trust user input, user is evil)
			$keyword = strtr($keyword, ",;", "  ");
			$words = array();
			$words = array_map("trim", array_unique(explode(" ", io::strtolower($keyword))));
			$cleanedWords = array();
			foreach ($words as $aWord) {
				if ($aWord && $aWord != '' && io::strlen($aWord) >= 3) {
					$aWord = str_replace(array('%', '_'), array('\%', '\_'), $aWord);
					$cleanedWords[] = $aWord;
				}
			}
			if (!$cleanedWords) {
				//if no words after cleaning, return
				return array();
			}
			$keywordWhere = '';
			foreach ($cleanedWords as $cleanedWord) {
				$keywordWhere .= ( $keywordWhere) ? ' and ' : '';
				$keywordWhere .= " (
					description_row like '%" . sensitiveIO::sanitizeSQLString($cleanedWord) . "%'
					or label_row like '%" . sensitiveIO::sanitizeSQLString($cleanedWord) . "%'
				)";
			}
			$where .= ( $where) ? ' and ' : '';
			$where .= " ((" . $keywordWhere . ") or MATCH (label_row, description_row) AGAINST ('" . sensitiveIO::sanitizeSQLString($keyword) . "') )";
			$select .= " , MATCH (label_row, description_row) AGAINST ('" . sensitiveIO::sanitizeSQLString($keyword) . "') as m ";
		}
		$sql = "
			select
				" . $select . "
			from
				mod_standard_rows
		";
		//groups
		if ($groups) {
			foreach ($groups as $group) {
				$where .= ( $where) ? ' and ' : '';
				$where .= " (
					groupsStack_row='" . sensitiveIO::sanitizeSQLString($group) . "'
					or groupsStack_row like '%;" . sensitiveIO::sanitizeSQLString($group) . ";%'
					or groupsStack_row like '" . sensitiveIO::sanitizeSQLString($group) . ";%'
					or groupsStack_row like '%;" . sensitiveIO::sanitizeSQLString($group) . "'
				)";
			}
		}

		//useable
		if (!$includeInactive) {
			$where .= ( $where) ? ' and ' : '';
			$where .= " useable_row=1 ";
		}
		//rowIds
		if ($rowIds) {
			$where .= ( $where) ? ' and ' : '';
			$where .= " id_row in (" . implode(',', $rowIds) . ") ";
		}
		if ($tplId) {
			$where .= ( $where) ? ' and ' : '';
			$where .= " (
				tplfilter_row=''
				or tplfilter_row='" . sensitiveIO::sanitizeSQLString($tplId) . "'
				or tplfilter_row like '%;" . sensitiveIO::sanitizeSQLString($tplId) . ";%'
				or tplfilter_row like '" . sensitiveIO::sanitizeSQLString($tplId) . ";%'
				or tplfilter_row like '%;" . sensitiveIO::sanitizeSQLString($tplId) . "'
			) ";
		}
		//user
		if (is_object($user) && !$user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$groupsDenied = $user->getRowGroupsDenied();
			$groupsDenied = $groupsDenied->getElements();
			if ($groupsDenied) {
				$where .= ( $where) ? ' and (' : '(';
				foreach ($groupsDenied as $group) {
					$where .= " (
						groupsStack_row != '" . sensitiveIO::sanitizeSQLString($group[0]) . "'
						and groupsStack_row not like '%;" . sensitiveIO::sanitizeSQLString($group[0]) . ";%'
						and groupsStack_row not like '" . sensitiveIO::sanitizeSQLString($group[0]) . ";%'
						and groupsStack_row not like '%;" . sensitiveIO::sanitizeSQLString($group[0]) . "'
					) and";
				}
				//remove last "or" and append )
				$where = io::substr($where, 0, -3) . ')';
			}
		}
		$sql = $sql . ($where ? ' where ' . $where : '');
		//order
		if (io::strpos($sql, 'MATCH') === false) {
			$sql .= " order by label_row ";
		} else {
			$sql .= " order by m desc ";
		}
		//limit
		if ($start || $limit) {
			$sql .= " limit " . sensitiveIO::sanitizeSQLString($start) . "," . sensitiveIO::sanitizeSQLString($limit);
		}
		//pr($sql);
		$q = new CMS_query($sql);
		$rows = array();
		while ($r = $q->getArray()) {
			$id = $r['id_row'];
			//set match score if exists
			if (isset($r['m'])) {
				$score[$id] = $r['m'];
			}
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
			$sql = '
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
					if (!SensitiveIO::isInSet($group[0], $rowGroups) && $group[0]) {
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
	 * public static getCloneFromID
	 *
	 * Clones a Row, changes some attributes
	 * and writes it to persistence (MySQL for now)
	 *
	 * @param anyRowID as the ID of Row to be cloned
	 * @param String label receive a new label for this Row
	 * @param boolean $setPrivate Should the template be set as a private one ?  ALSO determines if the new row should point to the same file
	 * @return a valid new CMS_row
	 */
	function getCloneFromID($rowID = 0, $label = false, $setPrivate = false) {
		$ret = false;
		$model = new CMS_row($rowID);
		if ($model->getID() > 0) {
			//New blank one
			$row = new CMS_row();

			//First write a new object to get it's ID
			$row->writeToPersistence();

			//Setting label
			$label = ($label) ? $label : $model->getLabel();
			$row->setLabel($label);

			//Copying template definition file (if not private template)
			if ($setPrivate) {
				$filename = $model->getDefinitionFileName();
			} else {
				$filename = "r" . $row->getID() . "_" . SensitiveIO::sanitizeAsciiString($row->getLabel()) . ".xml";
			}
			if ($setPrivate || CMS_file::copyTo(PATH_ROWS_FS . "/" . $model->getDefinitionFileName(), PATH_ROWS_FS . "/" . $filename)) {
				$row->setDefinitionFile($filename);

				//Copying groupsStack from database
				foreach ($model->getGroups() as $grp) {
					$row->addGroup($grp);
				}

				//Copying image
				$row->setImage($model->getImage(CMS_file::WEBROOT, true));

				//set private if asked to.
				if ($setPrivate) {
					$row->setPrivate(true);
				}
				//copy description
				$row->setDescription($model->getDescription());

				//add filtered templates
				$row->setFilteredTemplates($model->getFilteredTemplates());

				//Partial update for groups and image
				$row->writeToPersistence();
				$ret = $row;
			}
			unset($model);
		}
		if ($row) {
			//Clean if any error when out
			if (!$ret) {
				$row->destroy();
			}
			unset($row);
		}
		return $ret;
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
		if (!SensitiveIO::isPositiveInteger($rowID)) {
			CMS_grandFather::raiseError('rowID must be a positive integer');
			return $return;
		}
		$clientSpacesTable = ($public) ? 'mod_standard_clientSpaces_public' : 'mod_standard_clientSpaces_edited';
		$sql = "
			select
				distinct id_pag
			from
				pages,
				" . $clientSpacesTable . "
			where
				type_cs = '" . $rowID . "'
				and template_cs = template_pag
			order by
				id_pag
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			while ($id = $q->getValue('id_pag')) {
				if ($returnObjects) {
					if ($page = CMS_tree::getPageByID($id)) {
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
		if (!SensitiveIO::isPositiveInteger($pageId)) {
			CMS_grandFather::raiseError('pageId must be a positive integer');
			return $rows;
		}
		$clientSpacesTables = array(
			'mod_standard_clientSpaces_public',
			'mod_standard_clientSpaces_edited',
			'mod_standard_clientSpaces_edition'
		);
		foreach ($clientSpacesTables as $clientSpacesTable) {
			$sql = "
				select
					type_cs
				from
					pages,
					" . $clientSpacesTable . "
				where
					id_pag = " . $pageId . "
					and template_cs = template_pag
				order by
					type_cs
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while (($id = $q->getValue('type_cs')) !== false) {
					if (!isset($rows[$id])) {
						if ($returnObjects) {
							if ($row = CMS_rowsCatalog::getByID($id)) {
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
		try {
			foreach (new DirectoryIterator(PATH_TEMPLATES_ROWS_FS . '/images/') as $file) {
				if ($file->isFile() && in_array(io::strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION)), $availableExtensions)) {
					$images[] = PATH_TEMPLATES_ROWS_WR . '/images/' . $file->getFilename();
				}
			}
		} catch (Exception $e) {

		}

		return $images;
	}

	/**
	 * Return all rows which uses given modules
	 *
	 * @param array modules : the modules codename to search rows for
	 * @param boolean returnObjects : does the function return array of ids or array of objects (default)
	 * @return array : rows
	 * @access public
	 */
	function getByModules($modules= array(), $returnObjects = true) {
		if (!is_array($modules) && is_string($modules) && $modules) {
			$modules = array($modules);
		}
		if (!is_array($modules) || !$modules) {
			CMS_grandFather::raiseError('No modules set');
			return array();
		}

		$sql = '
			select 
				id_row, modulesStack_row
			from
				mod_standard_rows
		';
		$q = new CMS_query($sql);
		$rows = array();
		while ($r = $q->getArray()) {
			$modulesList = explode(';', $r["modulesStack_row"]);
			$hasModules = true;
			//check if all requested modules exists for row
			foreach ($modules as $module) {
				if (!in_array($module, $modulesList)) {
					$hasModules = false;
				}
			}
			//check if row does not use another module than requested ones
			foreach ($modulesList as $module) {
				if (!in_array($module, $modules)) {
					$hasModules = false;
				}
			}
			if ($hasModules) {
				if ($returnObjects) {
					$row = new CMS_row($r["id_row"]);
					if (!$row->hasError()) {
						$rows[$row->getID()] = $row;
					}
				} else {
					$rows[$r["id_row"]] = $r["id_row"];
				}
			}
		}
		return $rows;
	}

	/**
	 * Import module from given array datas
	 *
	 * @param array $data The module datas to import
	 * @param array $params The import parameters.
	 * 		array(
	 * 				module	=> false|true : the module to create rows (required)
	 * 				create	=> false|true : create missing objects (default : true)
	 * 				update	=> false|true : update existing objects (default : true)
	 * 				files	=> false|true : use files from PATH_TMP_FS (default : true)
	 * 			)
	 * @param CMS_language $cms_language The CMS_langage to use
	 * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	 * @param string $infos : Reference : The import infos returned
	 * @return boolean : true on success, false on failure
	 * @access public
	 */
	function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for rows importation ...' . "\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for rows importation : ' . $params['module'] . "\n";
			return false;
		}
		$return = true;
		foreach ($data as $rowDatas) {
			$importType = '';
			if (isset($rowDatas['uuid'])
					&& ($id = CMS_rowsCatalog::rowExists($params['module'], $rowDatas['uuid']))) {
				//row already exist : load it if we can update it
				if (!isset($params['update']) || $params['update'] == true) {
					$row = CMS_rowsCatalog::getByID($id);
					$importType = ' (Update)';
				}
			} else {
				//create new row if we can
				if (!isset($params['create']) || $params['create'] == true) {
					//create row
					$row = new CMS_row();
					$importType = ' (Creation)';
				}
			}
			if (isset($row)) {
				if ($row->fromArray($rowDatas, $params, $cms_language, $idsRelation, $infos)) {
					$return &= true;
					$infos .= 'Row ' . $row->getLabel() . ' successfully imported' . $importType . "\n";
				} else {
					$return = false;
					$infos .= 'Error during import of row ' . $rowDatas['id'] . $importType . "\n";
				}
			}
		}
		return $return;
	}

	/**
	 * Does a row exists with given parameters
	 * this method is use by fromArray import method to know if an imported row already exist or not
	 *
	 * @param string $module The module codename to check
	 * @param string $uuid The row uuid to check
	 * @return mixed : integer id if exists, false otherwise
	 * @access public
	 */
	function rowExists($module, $uuid) {
		if (!$module) {
			CMS_grandFather::raiseError("module must be set");
			return false;
		}
		if (!$uuid) {
			CMS_grandFather::raiseError("uuid must be set");
			return false;
		}
		$q = new CMS_query("
			select 
				id_row
			from 
				mod_standard_rows 
			where
				uuid_row='" . io::sanitizeSQLString($uuid) . "'
				and (modulesStack_row like '" . io::sanitizeSQLString($module) . ";%'
					or modulesStack_row = '" . io::sanitizeSQLString($module) . "'
					or modulesStack_row like '%;" . io::sanitizeSQLString($module) . "'
					or modulesStack_row like '%;" . io::sanitizeSQLString($module) . ";%'
				)
		");
		if ($q->getNumRows()) {
			return $q->getValue('id_row');
		}
		return false;
	}

	/**
	 * Does given uuid already exists for rows
	 *
	 * @param string $uuid The uuid to check
	 * @return boolean
	 * @access public
	 */
	function uuidExists($uuid) {
		if (!$uuid) {
			CMS_grandFather::raiseError("uuid must be set");
			return false;
		}
		$q = new CMS_query("
			select 
				id_row
			from 
				mod_standard_rows 
			where
				uuid_row='" . io::sanitizeSQLString($uuid) . "'
		");
		return $q->getNumRows() ? true : false;
	}

}

?>