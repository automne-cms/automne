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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: modulescatalog.php,v 1.6 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_modulesCatalog
  *
  * Represents a collection of modules
  *
  * @package Automne
  * @subpackage modules
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_modulesCatalog extends CMS_grandFather
{
	/**
	  * Get a module by its codename.
	  *
	  * @param string $codename the codename of the module to get
	  * @return CMS_module The module wanted
	  * @access public
	  */
	static function getByCodename($datas)
	{
		static $modules;
		if (is_string($datas)) {
			$codename = $datas;
			if (!$codename) {
				parent::raiseError("Codename is null");
				return false;
			}
			if (isset($modules[$codename])) {
				return $modules[$codename];
			}
			//test the codename to see if it is valid
			if ($codename != SensitiveIO::sanitizeAsciiString($codename)) {
				parent::raiseError("Codename is not valid");
				return false;
			}
			
			//Try to instanciate a module named CMS_module_CODENAME
			$class_name = "CMS_module_".$codename;
			if (class_exists($class_name)) {
				$modules[$codename] = new $class_name($codename);
				return $modules[$codename];
			} elseif (CMS_modulesCatalog::isPolymod($codename)) {
				$modules[$codename] = new CMS_polymod($codename);
				return $modules[$codename];
			} else {
				parent::raiseError("Unknown codename : ".$codename);
				return false;
			}
		} elseif (is_array($datas)) {
			$codename = isset($datas['codename_mod']) ? $datas['codename_mod'] : '';
			if (!$codename) {
				parent::raiseError("Codename is null");
				return false;
			}
			if (isset($modules[$codename])) {
				return $modules[$codename];
			}
			//test the codename to see if it is valid
			if ($codename != SensitiveIO::sanitizeAsciiString($codename)) {
				parent::raiseError("Codename is not valid");
				return false;
			}
			//Try to instanciate a module named CMS_module_CODENAME
			$class_name = "CMS_module_".$codename;
			if (class_exists($class_name)) {
				$modules[$codename] = new $class_name($datas);
				return $modules[$codename];
			} elseif ($datas['isPolymod_mod']) {
				$modules[$codename] = new CMS_polymod($datas);
				return $modules[$codename];
			} else {
				parent::raiseError("Unknown codename : ".$codename);
				return false;
			}
		} else {
			parent::raiseError("Unknown datas type : ".gettype($datas));
			return false;
		}
	}
	
	/**
	  * Get All the available modules
	  *
	  * @return array(CMS_module) All the available modules sorted by label
	  * @access public
	  */
	static function getAll($orderBy="label", $polymodOnly = false, $reset = false)
	{
		static $modules;
		$hash = md5(serialize(func_get_args()));
		if (!$reset && isset($modules[$hash])) {
			return $modules[$hash];
		}
		
		$where = $from = '';
		if ($orderBy == "label") {
			global $cms_language;
			$from = ", messages";
			if (is_a($cms_language, 'CMS_language')) {
				$code = $cms_language->getCode();
			} else {
				$code = APPLICATION_DEFAULT_LANGUAGE;
			}
			$where = " where 
				label_mod = id_mes 
				and  codename_mod = module_mes
				and  language_mes='".$code."'";
			$order = " order by message_mes asc";
		} else {
			$order = ($orderBy) ? "order by ".$orderBy."_mod ":"";
		}
		
		$where .= ($polymodOnly && $where) ? " and isPolymod_mod='1' ":"";
		$where .= ($polymodOnly && !$where) ? " where isPolymod_mod='1' ":"";
		
		$sql = "
			select
				*
			from
				modules
			".$from."
			".$where."
			".$order."
		";
		$q = new CMS_query($sql);
		
		$modules[$hash] = array();
		while ($r = $q->getArray()) {
			$module = CMS_modulesCatalog::getByCodename($r);
			if ($module && !$module->hasError()) {
				$modules[$hash][$r["codename_mod"]] = $module;
			}
		}
		//in case of label ordering, check for missing modules (no labels found for modules for current language)
		if ($orderBy == 'label') {
			$allCodenames = CMS_modulesCatalog::getAllCodenames($reset);
			foreach ($allCodenames as $codename) {
				if (!isset($modules[$hash][$codename])) {
					$module = CMS_modulesCatalog::getByCodename($codename);
					if ($module && !$module->hasError()) {
						$modules[$hash][$codename] = $module;
					}
				}
			}
		}
		return $modules[$hash];
	}
	
	/**
	  * Get all modules codenames
	  *
	  * @return array(codename => codename)
	  * @access public
	  */
	static function getAllCodenames($reset = false) {
		static $codenames;
		if (!$reset && $codenames) {
			return $codenames;
		}
		$sql = "
			select
				codename_mod as codename
			from
				modules
		";
		$q = new CMS_query($sql);
		$codenames = array();
		while($r = $q->getArray()) {
			$codenames[$r['codename']] = $r['codename'];
		}
		return $codenames;
	}
	
	/**
	  * Is given module is a poly module ?
	  *
	  * @param string $codename the codename of the module to check
	  * @return boolean true if yes, false otherwise
	  * @access public
	  */
	static function isPolymod($codename) {
		$sql = "select
					1
				from
					modules
				where
					codename_mod='".sensitiveIO::sanitizeSQLString($codename)."'
					and isPolymod_mod='1'
				";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true:false;
	}
	
	/**
	  * Get All the validations available for the given user
	  *
	  * @param CMS_profile_user The user we want the validations for
	  * @return array(array(string=>CMS_resourceValidation)) All the available validations in an array where each elements are the validations array indexed by the module codename
	  * @access public
	  */
	static function getAllValidations(&$user, $light=false)
	{
		$modules = CMS_modulesCatalog::getAll();
		$all_validations = array();
		if (is_array($modules)) {
			foreach ($modules as $module) {
				if ($light && method_exists($module, "getValidationsInfo")) {
					$validations = $module->getValidationsInfo($user);
				} else {
					$validations = $module->getValidations($user);
				}
				if ($validations) {
					$all_validations[$module->getCodename()] = $validations;
				}
			}
		}
		if (is_array($all_validations) && $all_validations) {
			return $all_validations;
		} else {
			return false;
		}
	}
	
	/**
	  * Get count of validations available for the given user
	  *
	  * @param CMS_profile_user The user we want the validations for
	  * @return integer
	  * @access public
	  */
	static function getValidationsCount(&$user)
	{
		$modules = CMS_modulesCatalog::getAll();
		$validationsCount = 0;
		if (is_array($modules)) {
			foreach ($modules as $module) {
				if (method_exists($module, "getValidationsCount")) {
					$validationsCount += $module->getValidationsCount($user);
				} elseif (method_exists($module, "getValidationsInfo")) {
					$validations = $module->getValidationsInfo($user);
					$validationsCount += ($validations) ? count($validations) : 0;
				} elseif (is_object($module)) {
					$validations = $module->getValidations($user);
					$validationsCount += ($validations) ? count($validations) : 0;
				}
			}
		}
		return $validationsCount;
	}
	
	/**
	  * Move the data of a resource from one data location to another.
	  * May be used by every module, provided it respects the naming rules described in the modules HOWTO
	  *
	  * @param CMS_module $module The module who  want its data moved
	  * @param string $tablesPrefix The prefix of the tables containing the data
	  * @param string $resourceIDFieldName The name of the field containing the resource ID
	  * @param integer $resourceID The DB ID of the resource whose data we want to move
	  * @param string $locationFrom The starting location, among the available RESOURCE_DATA_LOCATION
	  * @param string $locationTo The ending location, among  the available RESOURCE_DATA_LOCATION
	  * @param boolean $copyOnly If set to true, the deletion from the originating tables and dirs won't occur
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	static function moveResourceData(&$module, $tablesPrefix, $resourceIDFieldName, $resourceID, $locationFrom, $locationTo, $copyOnly = false)
	{
		if (!is_a($module, "CMS_module")) {
			CMS_grandFather::raiseError("Module is not a CMS_module");
			return false;
		}
		if (!SensitiveIO::isInSet($locationFrom, CMS_resource::getAllDataLocations())
			|| !SensitiveIO::isInSet($locationTo, CMS_resource::getAllDataLocations())) {
			CMS_grandFather::raiseError("Locations are not in the set");
			return false;
		}
		
		//get the tables : named PREFIXXXXX_public
		$sql = "show tables";
		$q = new CMS_query($sql);
		$tables_prefixes = array();
		while ($data = $q->getArray()) {
			if (preg_match("#".$tablesPrefix."(.*)_public#", $data[0])) {
				$tables_prefixes[] = io::substr($data[0], 0, strrpos($data[0], "_") + 1);
			}
		}
		
		foreach ($tables_prefixes as $table_prefix) {
			//delete all in the destination table just incase and insert
			if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
				$sql = "
					delete from
						".$table_prefix.$locationTo."
					where
						".$resourceIDFieldName."='".$resourceID."'
				";
				$q = new CMS_query($sql);
					
				$sql = "
					insert into
						".$table_prefix.$locationTo."
						select
							*
						from
							".$table_prefix.$locationFrom."
						where
							".$resourceIDFieldName."='".$resourceID."'
				";
				$q = new CMS_query($sql);
			}
			if (!$copyOnly) {
				//delete from the starting table
				$sql = "
					delete from
						".$table_prefix.$locationFrom."
					where
						".$resourceIDFieldName."='".$resourceID."'
				";
				$q = new CMS_query($sql);
			}
		}
		
		//second, move the files
		$locationFromDir = new CMS_file(PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationFrom, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		//cut here if the locationFromDir doesn't exists. That means the module doesn't have files
		if (!$locationFromDir->exists()) {
			return true;
		}
		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
			$locationToDir = new CMS_file(PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationTo, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
			//cut here if the locationToDir doesn't exists.
			if (!$locationToDir->exists()) {
				CMS_grandFather::raiseError("LocationToDir does not exists : ".PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationTo);
				return false;
			}
			//delete all files of the locationToDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationTo.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					if (!CMS_file::deleteFile($file)) {
						CMS_grandFather::raiseError("Can't delete file ".$file);
						return false;
					}
				}
			}
			//then copy or move them to the locationToDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationFrom.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					$to = str_replace('/'.$locationFrom.'/','/'.$locationTo.'/',$file);
					if ($copyOnly) {
						if (!CMS_file::copyTo($file,$to)) {
							CMS_grandFather::raiseError("Can't copy file ".$file." to ".$to);
							return false;
						}
					} else {
						if (!CMS_file::moveTo($file,$to)) {
							CMS_grandFather::raiseError("Can't move file ".$file." to ".$to);
							return false;
						}
					}
					//then chmod new file
					CMS_file::chmodFile(FILES_CHMOD,$to);
				}
			}
		}
		//cleans the initial dir if not a copy
		if (!$copyOnly) {
			//then get all files of the locationFromDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationFrom.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					if (!CMS_file::deleteFile($file)) {
						CMS_grandFather::raiseError("Can't delete file ".$file);
						return false;
					}
				}
			}
		}
		return true;
	}
	
	/**
	  * Import module from given array datas
	  *
	  * @param array $data The module datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				create	=> false|true : create missing objects (default : true)
	  *				update	=> false|true : update existing objects (default : true)
	  *				files	=> false|true : use files from PATH_TMP_FS (default : true)
	  *			)
	  * @param CMS_language $cms_language The CMS_langage to use
	  * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	  * @param string $infos : Reference : The import infos returned
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	static function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		$return = true;
		foreach ($data as $moduleDatas) {
			if (!isset($moduleDatas['codename'])) {
				$infos .= 'Missing codename ...'."\n";
				return false;
			}
			//check if module exists
			$codenames = CMS_modulesCatalog::getAllCodenames();
			//instanciate module
			$importType = '';
			if (isset($codenames[$moduleDatas['codename']])) {
				if (!isset($params['update']) || $params['update'] == true) {
					$module = CMS_modulesCatalog::getByCodename($moduleDatas['codename']);
					$infos .= 'Get Module '.$module->getLabel($cms_language).' for update...'."\n";
					$importType = ' (Update)';
				} else {
					$infos .= 'Module already exists and parameter does not allow to update it ...'."\n";
					return false;
				}
			} else {
				if (!isset($params['create']) || $params['create'] == true) {
					$infos .= 'Create new module for imported datas...'."\n";
					$importType = ' (Creation)';
					if(isset($moduleDatas['polymod']) && $moduleDatas['polymod']) {
						$module = new CMS_polymod();
					} else {
						$module = new CMS_module();
					}
				} else {
					$infos .= 'Module does not exists and parameter does not allow to create it ...'."\n";
					return false;
				}
			}
			if ($module->fromArray($moduleDatas, $params, $cms_language, $idsRelation, $infos)) {
				$return &= true;
				$infos .= 'Module "'.$module->getLabel($cms_language).'" successfully imported'.$importType."\n";
			} else {
				$return = false;
				$infos .= 'Error during import of module '.$moduleDatas['codename'].$importType."\n";
			}
		}
		return $return;
	}
}

?>