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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: poly_object_catalog.php,v 1.4 2009/04/02 13:58:00 sebastien Exp $

/**
  * static Class CMS_poly_object_catalog
  *
  * catalog of polymorphic objects
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_object_catalog
{
	/**
	  * Gets object by its internal ID (edited object)
	  *
	  * @param integer $itemID The DB ID of the item in the mod_object_polyobjects table(s)
	  * @param boolean $returnDefinition, if true, return item CMS_poly_object_definition instead of CMS_poly_object
	  * @param boolean $public, if true, return public CMS_poly_object
	  * @return CMS_poly_object
	  * @access public
	  */
	function getObjectByID($itemID, $returnDefinition = false, $public = false)
	{
		if (!sensitiveIO::isPositiveInteger($itemID)) {
			CMS_grandFather::raiseError("itemID is not a positive integer : ".$itemID);
			return false;
		}
		if ($objectID = CMS_poly_object_catalog::getObjectDefinitionByID($itemID)) {
			if (!$returnDefinition) {
				$object = new CMS_poly_object($objectID, $itemID, array(), $public);
			} else {
				$object = new CMS_poly_object_definition($objectID);
			}
			return $object;
		}
		return false;
	}
	
	/**
	  * Gets object definition (type) ID for a given item ID
	  *
	  * @param integer $itemID The DB ID of the item in the mod_object_polyobjects table(s)
	  * @param boolean $returnObject, if true, return item CMS_poly_object_definition instead of definition ID
	  * @return object definition (type) ID
	  * @access public
	  */
	function getObjectDefinitionByID($itemID, $returnObject = false) {
		if (!sensitiveIO::isPositiveInteger($itemID)) {
			CMS_grandFather::raiseError("itemID is not a positive integer : ".$itemID);
			return false;
		}
		$sql = "
			select
				object_type_id_moo as objectID
			from
				mod_object_polyobjects
			where
				id_moo = '".sensitiveIO::sanitizeSQLString($itemID)."'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows() == 1) ? (!$returnObject ? $q->getValue('objectID') : new CMS_poly_object_definition($q->getValue('objectID'))) : false;
	}
	
	/**
	  * Gets all poly objects for a given module codename
	  *
	  * @param string $codename the module codename of objects to get
	  * @return array(CMS_poly_object_definition)
	  * @access public
	  * @static
	  */
	function getObjectsForModule($codename) {
		$sql = "select
					*
				from
					mod_object_definition
				where
					module_mod='".sensitiveIO::sanitizeSQLString($codename)."'
		";
		$q = new CMS_query($sql);
		$results = array();
		while ($r = $q->getArray()) {
			$object = new CMS_poly_object_definition($r["id_mod"],$r);
			if ($r["resource_usage_mod"] == 1) {
				//if it is a primary resource, add an underscore to put it on top of objects list
				$results['_'.$object->getLabel()] = $object;
			} else {
				$results[$object->getLabel()] = $object;
			}
		}
		//sort case insentive
		uksort($results, "strcasecmp");
		return $results;
	}
	
	/**
	  * Return a module codename for a given object ID
	  *
	  * @param integer $itemID the item ID to get module
	  * @return string : the module codename
	  * @access public
	  * @static
	  */
	function getModuleCodenameForObject($itemID) {
		static $moduleCodenameForObject;
		if (!sensitiveIO::isPositiveInteger($itemID)) {
			CMS_grandFather::raiseError("itemID is not a positive integer : ".$itemID);
			return false;
		}
		if (!isset($moduleCodenameForObject[$itemID])) {
			$sql = "
				select
					module_mod
				from
					mod_object_polyobjects,
					mod_object_definition
				where
					id_moo = '".$itemID."'
					and object_type_id_moo = id_mod
			";
			$q = new CMS_query($sql);
			$moduleCodenameForObject[$itemID] = ($q->getNumRows()) ? $q->getValue('module_mod') : false;
		}
		return $moduleCodenameForObject[$itemID];
	}
	
	/**
	  * Return a module codename for a given object type ID
	  *
	  * @param integer $objectID the object type ID to get module
	  * @return string : the module codename
	  * @access public
	  * @static
	  */
	function getModuleCodenameForObjectType($objectID) {
		static $moduleCodenameForObjectType;
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("ObjectID is not a positive integer : ".$objectID);
			return false;
		}
		if (!isset($moduleCodenameForObjectType[$objectID])) {
			$sql = "
				select
					module_mod
				from
					mod_object_definition
				where
					id_mod = '".$objectID."'
			";
			$q = new CMS_query($sql);
			$moduleCodenameForObjectType[$objectID] = ($q->getNumRows()) ? $q->getValue('module_mod') : false;
		}
		return $moduleCodenameForObjectType[$objectID];
	}
	
	/**
	  * is a module have a primary resource object set ?
	  *
	  * @param string $codename the module codename of objects to get
	  * @return boolean
	  * @access public
	  * @static
	  */
	function hasPrimaryResource($codename) {
		$sql = "select
					1
				from
					mod_object_definition
				where
					module_mod='".sensitiveIO::sanitizeSQLString($codename)."'
					and resource_usage_mod = '1'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true:false;
	}
	
	/**
	  * is a module have a primary resource object set ?
	  *
	  * @param string $codename the module codename of objects to get
	  * @return boolean
	  * @access public
	  * @static
	  */
	function getPrimaryResourceObjectType($codename) {
		$sql = "select
					id_mod
				from
					mod_object_definition
				where
					module_mod='".sensitiveIO::sanitizeSQLString($codename)."'
					and resource_usage_mod = '1'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return $q->getValue('id_mod');
		} else {
			return false;
		}
	}
	
	/**
	  * is object has language field ?
	  *
	  * @param integer $objectID the object to check
	  * @return false or id of object field which is the language field
	  * @access public
	  * @static
	  */
	function objectHasLanguageField($objectID) {
		static $objectHasLanguageField;
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("ObjectID is not a positive integer : ".$objectID);
			return false;
		}
		if (!isset($objectHasLanguageField[$objectID])) {
			$sql = "select
						id_mof
					from
						mod_object_definition,
						mod_object_field
					where
						id_mod='".$objectID."'
						and object_id_mof = id_mod
						and type_mof = 'CMS_object_language'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$objectHasLanguageField[$objectID] = array();
				while ($id = $q->getValue('id_mof')) {
					$objectHasLanguageField[$objectID][] = $id;
				}
			} else {
				$objectHasLanguageField[$objectID] = false;
			}
		}
		return $objectHasLanguageField[$objectID];
	}
	
	
	/**
	  * is object use categories ?
	  *
	  * @param integer $objectID the object to check
	  * @return empty array or id of object field who uses categories
	  * @access public
	  * @static
	  */
	function objectHasCategories($objectID) {
		static $objectUsesCategories;
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("ObjectID is not a positive integer : ".$objectID);
			return false;
		}
		if (!isset($objectUsesCategories[$objectID])) {
			$sql = "select
						id_mof
					from
						mod_object_definition,
						mod_object_field
					where
						id_mod='".$objectID."'
						and object_id_mof = id_mod
						and type_mof = 'CMS_object_categories'
			";
			$q = new CMS_query($sql);
			$objectUsesCategories[$objectID] = array();
			if ($q->getNumRows()) {
				while ($id = $q->getValue('id_mof')) {
					$objectUsesCategories[$objectID][] = $id;
				}
			}
		}
		return $objectUsesCategories[$objectID];
	}
	
	/**
	  * is module use categories ?
	  *
	  * @param string $codename the module codename to check
	  * @return array or fields ids or false if none found
	  * @access public
	  * @static
	  */
	function moduleHasCategories($codename) {
		static $moduleHasCategories;
		if (!isset($moduleHasCategories[$codename])) {
			$sql = "select
						distinct(id_mod)
					from
						mod_object_definition,
						mod_object_field
					where
						module_mod='".sensitiveIO::sanitizeSQLString($codename)."'
						and object_id_mof = id_mod
						and type_mof = 'CMS_object_categories'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while($id = $q->getValue('id_mod')) {
					$moduleHasCategories[$codename][] = $id;
				}
			} else {
				$moduleHasCategories[$codename] = false;
			}
		}
		return $moduleHasCategories[$codename];
	}
	
	/**
	  * return parents objectID if any for a given object ID
	  *
	  * @param integer $objectID the object to get parent of
	  * @return array(parentID => array(fieldsID)) or false if none found
	  * @access public
	  * @static
	  */
	function getParentsObject($objectID) {
		static $parentObject;
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("objectID is not a positive integer : ".$objectID);
			return false;
		}
		if (!isset($parentObject[$objectID])) {
			$sql = "
				select
					id_mof,
					object_id_mof
				from
					mod_object_field
				where
					type_mof = '".sensitiveIO::sanitizeSQLString($objectID)."' 
					or type_mof = 'multi|".sensitiveIO::sanitizeSQLString($objectID)."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while($r = $q->getArray()) {
					$parentObject[$objectID][$r['object_id_mof']][] = $r['id_mof'];
				}
			} else {
				$parentObject[$objectID] = false;
			}
		}
		return $parentObject[$objectID];
	}
	
	/**
	  * Return all fields for a given object ID
	  *
	  * @param integer $objectID the object ID to get fields
	  * @return array of CMS_object_fields
	  * @access public
	  * @static
	  */
	function getFieldsDefinition($objectID) {
		//$_SESSION["polyModule"]["objectFields"][$objectID] unseted by CMS_poly_object_field writeToPersistence;
		$objectFields = array();
		if (sensitiveIO::isPositiveInteger($objectID)) {
			if (isset($_SESSION["polyModule"]) && isset($_SESSION["polyModule"]["objectFields"][$objectID]) && is_array($_SESSION["polyModule"]["objectFields"][$objectID])) {
				$objectFields = $_SESSION["polyModule"]["objectFields"][$objectID];
			} else {
				$sql = "
					select
						*
					from
						mod_object_field,
						mod_object_definition
					where
						object_id_mof  = '".$objectID."'
						and object_id_mof = id_mod
					order by 
						order_mof
				";
				$q = new CMS_query($sql);
				while ($r = $q->getArray()) {
					$objectFields[$r["id_mof"]] = new CMS_poly_object_field($r["id_mof"],$r);
				}
				$_SESSION["polyModule"]["objectFields"][$objectID] = $objectFields;
			}
		}
		return $objectFields;
	}
	
	/**
	  * Return a list of all objects of given type
	  *
	  * @param mixed $objectID the object ID to get names (integer or 'multi|objectID')
	  * @param boolean $public are the needed datas public ? (default false)
	  * @param array $searchConditions, search conditions to add. Format : array(conditionType => conditionValue)
	  * @param boolean $returnObjects, search return list of objects (default) or list of objects ID
	  * @param constant $searchMethod, search method used (default : false => POLYMOD_SEARCH_RETURN_OBJECTS)
	  
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	function getAllObjects($objectID, $public = false, $searchConditions = array(), $returnObjects = true, $searchMethod = false) {
		$return = array();
		if (strpos($objectID,'multi|') !== false) {
			$objectID = substr($objectID, 6);
		}
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError('objectID is not a positive integer : '.$objectID);
			return array();
		}
		//load current object definition
		$object = new CMS_poly_object_definition($objectID);
		$search = new CMS_object_search($object,$public);
		if (is_array($searchConditions) && $searchConditions) {
			foreach($searchConditions as $conditionType => $conditionValue) {
				$search->addWhereCondition($conditionType, $conditionValue);
			}
		}
		if ($returnObjects) {
			if ($searchMethod !== false) {
				return $search->search($searchMethod);
			} else {
				return $search->search();
			}
		} else {
			//here in some case we can have a strange error if search result is returned directly (using function as a reference should cause this)
			$ids = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_IDS);
			//so we use a variable
			return $ids;
		}
	}
	
	/**
	  * Return a list of all objects names of given type
	  *
	  * @param mixed $objectID the object ID to get names (integer or 'multi|objectID')
	  * @param boolean $public are the needed datas public ? (default false)
	  * @param array $searchConditions, search conditions to add. Format : array(conditionType => conditionValue)
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	function getListOfNamesForObject($objectID, $public = false, $searchConditions = array(), $loadSubObjects = false) {
		static $listNames;
		$paramsHash = md5(serialize(func_get_args()));
		if (isset($listNames[$paramsHash])) {
			return $listNames[$paramsHash];
		}
		$listNames[$paramsHash] = array();
		if ($loadSubObjects) {
			$items = CMS_poly_object_catalog::getAllObjects($objectID, $public, $searchConditions, true);
		} else {
			$items = CMS_poly_object_catalog::getAllObjects($objectID, $public, $searchConditions, true, CMS_object_search::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED);
		}
		foreach ($items as $item) {
			$listNames[$paramsHash][$item->getID()] = $item->getLabel();
		}
		//natsort objects by name case insensitive
		uasort($listNames[$paramsHash], array('CMS_poly_object_catalog','_natecasecomp'));
		return $listNames[$paramsHash];
	}
	//Callback function for natural sorting without care of accentuation
	function _natecasecomp($str1, $str2) {
		$str1 = sensitiveIO::sanitizeAsciiString($str1);
		$str2 = sensitiveIO::sanitizeAsciiString($str2);
		return strnatcasecmp($str1, $str2);
	}
	
	/**
	  * Return a module codename for a given field (use by image and file fields)
	  *
	  * @param integer $fieldID the field ID to get module
	  * @return string : the module codename
	  * @access public
	  * @static
	  */
	function getModuleCodenameForField($fieldID) {
		static $moduleCodenameForField;
		if (sensitiveIO::isPositiveInteger($fieldID)) {
			if (!isset($moduleCodenameForField[$fieldID])) {
				$sql = "
					select
						module_mod
					from
						mod_object_field,
						mod_object_definition
					where
						id_mof = '".$fieldID."'
						and object_id_mof = id_mod
				";
				$q = new CMS_query($sql);
				$moduleCodenameForField[$fieldID] = ($q->getNumRows()) ? $q->getValue('module_mod'):false;
			}
			return $moduleCodenameForField[$fieldID];
		} else {
			CMS_grandFather::raiseError("fieldID is not a positive integer : ".$fieldID);
			return false;
		}
	}
	
	/**
	  * Return object type id for a given field (use by category field)
	  *
	  * @param integer $fieldID the field ID to get module
	  * @return integer : the object type ID
	  * @access public
	  * @static
	  */
	function getObjectIDForField($fieldID) {
		static $objectIDForField;
		if (sensitiveIO::isPositiveInteger($fieldID)) {
			if (!isset($objectIDForField[$fieldID])) {
				$sql = "
					select
						id_mod
					from
						mod_object_field,
						mod_object_definition
					where
						id_mof = '".$fieldID."'
						and object_id_mof = id_mod
				";
				$q = new CMS_query($sql);
				$objectIDForField[$fieldID] = ($q->getNumRows()) ? $q->getValue('id_mod'):false;
			}
			return $objectIDForField[$fieldID];
		} else {
			CMS_grandFather::raiseError("fieldID is not a positive integer : ".$fieldID);
			return false;
		}
	}
	
	/**
	  * Return all objectID who use given objectID as field
	  *
	  * @param integer $objectID the wanted objectID usage
	  * @param boolean $returnObjectsDefinition return array of CMS_poly_object_definition instead of array of object id (default : false)
	  * @return array : objectID which use given objectID as field
	  * @access public
	  * @static
	  */
	function getObjectUsage($objectID, $returnObjectsDefinition = false) {
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("objectID is not a positive integer : ".$objectID);
			return false;
		}
		$sql = "select
					distinct object_id_mof as objectID
				from
					mod_object_field
				where
					type_mof='".$objectID."'
					or type_mof = 'multi|".$objectID."'
		";
		$q = new CMS_query($sql);
		$objectsWhichUseObject = array();
		while($id = $q->getValue('objectID')) {
			if ($returnObjectsDefinition) {
				$objectsWhichUseObject[$id] = new CMS_poly_object_definition($id);
			} else {
				$objectsWhichUseObject[$id] = $id;
			}
		}
		return $objectsWhichUseObject;
	}
	
	/**
	  * Completely destroy a list of objects and associated resources if any. After this, objects will no longer exists at all.
	  * /!\ if objects are primary resources, no validation will be queried to validators, objects will be directly destroyed from all locations. /!\
	  *
	  * @param integer $objectID the object type ID to destroy
	  * @param array $itemIDs array of object ids to completely destroy
	  * @access public
	  * @static
	  */
	function hardDeleteObjects($objectID, $itemIDs) {
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("objectID is not a positive integer : ".$objectID);
			return false;
		}
		if (!is_array($itemIDs)) {
			CMS_grandFather::raiseError("itemIDs is not an array : ".print_r($itemIDs,true));
			return false;
		}
		//get object definition
		$objectDef = new CMS_poly_object_definition($this->_objectID);
		//if object is a primary resource, destroy all resources associated to objects
		if ($objectDef->isPrimaryResource()) {
			//get resources Ids
			$sql = "select 
						value 
					from 
						mod_subobject_integer_edited 
					where 
						objectID in (".implode(',',$itemIDs).")
						and objectFieldID = 0";
			$q = new CMS_query($sql);
			$resourceIDs = array();
			if ($q->getNumRows()) {
				while ($r = $q->getArray()) {
					$resourceIDs[] = $r['value'];
				}
			}
			//get resources statuses Ids
			$sql = "select 
						status_res 
					from 
						resources 
					where 
						id_res in (".implode(',',$resourceIDs).")";
			$q = new CMS_query($sql);
			$resourceStatusesIDs = array();
			if ($q->getNumRows()) {
				while ($r = $q->getArray()) {
					$resourceStatusesIDs[] = $r['status_res'];
				}
			}
			//then delete both of them
			$sql = "delete
					from 
						resources 
					where 
						id_res in (".implode(',',$resourceIDs).")";
			$q = new CMS_query($sql);
			$sql = "delete
					from 
						resourceStatuses 
					where 
						id_rs in (".implode(',',$resourceStatusesIDs).")";
			$q = new CMS_query($sql);
		}
		//delete objects datas from poly_object table
		$sql = "delete
				from 
					mod_object_polyobjects 
				where 
					id_moo in (".implode(',',$itemIDs).")";
		$q = new CMS_query($sql);
		//delete from data tables
		$dataTables = array(
			'mod_subobject_date_deleted',
			'mod_subobject_date_edited',
			'mod_subobject_date_public',
			'mod_subobject_integer_deleted',
			'mod_subobject_integer_edited',
			'mod_subobject_integer_public',
			'mod_subobject_string_deleted',
			'mod_subobject_string_edited',
			'mod_subobject_string_public',
			'mod_subobject_text_deleted',
			'mod_subobject_text_edited',
			'mod_subobject_text_public',
		);
		foreach ($dataTables as $datasTable) {
			$sql = "delete
					from 
						".$datasTable."
					where 
						objectID in (".implode(',',$itemIDs).")";
			$q = new CMS_query($sql);
		}
		//delete associated objects module files if any
		$files = glob(PATH_MODULES_FILES_FS.'/'.$objectDef->getValue('module').'/*/r{'.implode(',',$itemIDs).'}_*', GLOB_BRACE);
		if (is_array($files) && $files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					@unlink($file);
				}
			}
		}
		return true;
	}
	
	/**
	  * Return a list of all plugins for a given object ID
	  *
	  * @param integer $objectID the object ID to get plugins (if none set : all plugins)
	  * @return array(int objectID => CMS_poly_plugin_definitions)
	  * @access public
	  * @static
	  */
	function getAllPluginDefinitionsForObject($objectID = false) {
		if ($objectID && !sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("objectID is not a positive integer : ".$objectID);
			return false;
		}
		$sql = "select
					*
				from
					mod_object_plugin_definition";
		if ($objectID) {
			$sql .= "
				where
					object_id_mowd='".sensitiveIO::sanitizeSQLString($objectID)."'
			";
		}
		$q = new CMS_query($sql);
		$results = array();
		while ($r = $q->getArray()) {
			$object = new CMS_poly_plugin_definitions($r["id_mowd"],$r);
			$results[$object->getID()] = $object;
		}
		return $results;
	}
	
	/**
	  * Return a list of all plugins IDs for a given object ID
	  *
	  * @param string $codename the module codename to get plugins
	  * @return array(int objectID => int objectID)
	  * @access public
	  * @static
	  */
	function getAllPluginDefIDForModule($codename) {
		static $pluginsIDs;
		if (!isset($pluginsIDs[$codename])) {
			$sql = "select
						id_mowd
					from
						mod_object_definition,
						mod_object_plugin_definition
					where
						object_id_mowd = id_mod
						and module_mod = '".sensitiveIO::sanitizeSQLString($codename)."'
			";
			$q = new CMS_query($sql);
			$pluginsIDs[$codename] = array();
			while ($r = $q->getArray()) {
				$pluginsIDs[$codename][$r["id_mowd"]] = $r["id_mowd"];
			}
		}
		return $pluginsIDs[$codename];
	}
	
	/**
	  * Return a list of all RSS for a given object ID
	  *
	  * @param integer $objectID the object ID to get rss (if none set : all rss)
	  * @return array(int objectID => CMS_poly_rss_definitions)
	  * @access public
	  * @static
	  */
	function getAllRSSDefinitionsForObject($objectID = false) {
		if ($objectID && !sensitiveIO::isPositiveInteger($objectID)) {
			CMS_grandFather::raiseError("objectID is not a positive integer : ".$objectID);
			return false;
		}
		$sql = "select
					*
				from
					mod_object_rss_definition";
		if ($objectID) {
			$sql .= "
				where
					object_id_mord='".sensitiveIO::sanitizeSQLString($objectID)."'
			";
		}
		$q = new CMS_query($sql);
		$results = array();
		while ($r = $q->getArray()) {
			$object = new CMS_poly_rss_definitions($r["id_mord"],$r);
			$results[$object->getID()] = $object;
		}
		return $results;
	}
	
	/**
	  * Return a list of all objects ids used by a field
	  *
	  * @param integer $fieldID : the field id
	  * @param boolean $public are the needed datas public ? (default false)
	  * @return array(integer objectID => integer objectID)
	  * @access public
	  */
	function getUsedObjectsID($fieldID, $public = false) {
		$return = array();
		if (sensitiveIO::isPositiveInteger($fieldID)) { 
			$statusSuffix = ($public) ? "_public":"_edited";
			$sql = "
				select
					distinct value as id
				from
					mod_subobject_integer".$statusSuffix."
				where
					objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
					and value != 0";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while($id = $q->getValue('id')) {
					$return[$id] = $id;
				}
			}
		}
		return $return;
	}
}
?>
