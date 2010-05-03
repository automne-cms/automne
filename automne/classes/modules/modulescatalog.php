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
  * @package CMS
  * @subpackage module
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
	function getByCodename($codename)
	{
		if (!$codename) {
			parent::raiseError("Codename is null");
			return false;
		}
		//test the codename to see if it is valid
		if ($codename != SensitiveIO::sanitizeAsciiString($codename)) {
			parent::raiseError("Codename is not valid");
			return false;
		}
		
		//Try to instanciate a module named CMS_module_CODENAME
		$class_name = "CMS_module_".$codename;
		if (class_exists($class_name)) {
			return new $class_name($codename);
		} elseif (CMS_modulesCatalog::isPolymod($codename)) {
			return new CMS_polymod($codename);
		} else {
			parent::raiseError("Unknown codename : ".$codename);
			return false;
		}
	}
	
	/**
	  * Get All the available modules
	  *
	  * @return array(CMS_module) All the available modules sorted by label
	  * @access public
	  */
	function getAll($orderBy="label", $polymodOnly = false)
	{
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
				codename_mod,
				isPolymod_mod
			from
				modules
			".$from."
			".$where."
			".$order."
		";
		$q = new CMS_query($sql);
		
		$modules = array();
		while ($r = $q->getArray()) {
			$module = CMS_modulesCatalog::getByCodename($r["codename_mod"]);
			if ($module && !$module->hasError()) {
				$modules[$r["codename_mod"]] = $module;
			}
		}
		return $modules;
	}
	
	/**
	  * Get all modules codenames
	  *
	  * @return array(codename => codename)
	  * @access public
	  */
	function getAllCodenames() {
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
	function isPolymod($codename) {
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
	function getAllValidations(&$user, $light=false)
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
	function getValidationsCount(&$user)
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
	function moveResourceData(&$module, $tablesPrefix, $resourceIDFieldName, $resourceID, $locationFrom, $locationTo, $copyOnly = false)
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
		
		
		/*
		//move the files
		$initial_path = PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationFrom;
		$initial_dir = @dir($initial_path);
		
		//cut here if the initial dir doesn't exists. That means the module doesn't have files
		if (!$initial_dir) {
			return true;
		}

		$files_prefix = "r".$resourceID."_";

		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {		
			//cleans the destination dir
			$destination_path = PATH_MODULES_FILES_FS."/".$module->getCodename()."/".$locationTo;
			$destination_dir = dir($destination_path);
			while (false !== ($file = $destination_dir->read())) {
				if (is_file($destination_path."/".$file)
					&& io::substr($file, 0, io::strlen($files_prefix)) == $files_prefix) {
					unlink($destination_path."/".$file);
				}
			}
			
			//copy or move the files
			while (false !== ($file = $initial_dir->read())) {
				if (is_file($initial_path."/".$file)
					&& io::substr($file, 0, io::strlen($files_prefix)) == $files_prefix) {
					if ($copyOnly) {
						if (@copy($initial_path."/".$file, $destination_path."/".$file)) {
							@chmod($destination_path."/".$file, octdec(FILES_CHMOD));
						} else {
							CMS_grandFather::raiseError("Can't copy file ".$initial_path."/".$file." to ".$destination_path."/".$file." : permission denied");
						}
					} else {
						if (@rename($initial_path."/".$file, $destination_path."/".$file)) {
							@chmod($destination_path."/".$file, octdec(FILES_CHMOD));
						} else {
							CMS_grandFather::raiseError("Can't move file ".$initial_path."/".$file." to ".$destination_path."/".$file." : permission denied");
						}
					}
				}
			}
		}

		//cleans the initial dir if not a copy
		if (!$copyOnly) {
			$initial_dir->rewind();
			while (false !== ($file = $initial_dir->read())) {
				if (is_file($initial_path."/".$file)
					&& io::substr($file, 0, io::strlen($files_prefix)) == $files_prefix) {
					unlink($initial_path."/".$file);
				}
			}
		}
		*/
		return true;
	}
}

?>