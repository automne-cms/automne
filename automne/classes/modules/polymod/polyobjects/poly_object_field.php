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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: poly_object_field.php,v 1.3 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_poly_object_field
  *
  * represent a poly object field
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_object_field extends CMS_poly_object_definition
{
	/**
	  * Integer ID
	  * @var integer
	  * @access private
	  */
	protected $_fieldID;
	
	/**
	  * all values for field object
	  * @var array	("objectID"		=> integer,
	  				 "labelID" 		=> integer,
					 "descriptionID"=> integer,
					 "type" 		=> "",
					 "order" 		=> integer,
					 "system" 		=> boolean,
					 "required" 	=> boolean,
					 "indexable" 	=> boolean,
					 "searchlist" 	=> boolean,
					 "searchable" 	=> boolean,
					 "params" 		=> array());
	  * @access private
	  */
	protected $_objectFieldValues = array	("objectID"		=> 0,
	  								 "labelID" 		=> 0,
					 				 "descriptionID"=> 0,
					 				 "type" 		=> "",
									 "order" 		=> 0,
									 "system" 		=> false,
									 "required" 	=> false,
									 "indexable" 	=> false,
									 "searchlist" 	=> false,
									 "searchable" 	=> false,
									 "params" 		=> array());
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $id DB id
	  * @param array $dbValues DB values
	  * @return void
	  * @access public
	  */
	function __construct($id = 0, $dbValues=array()) {
		$datas = array();
		if ($id && !$dbValues) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer : ".$id);
				return;
			}
			$sql = "
				select
					*
				from
					mod_object_field,
					mod_object_definition
				where
					id_mof='".$id."'
					and object_id_mof = id_mod
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$datas = $q->getArray();
			} else {
				$this->raiseError("Unknown ID :".$id);
				return;
			}
		} elseif (is_array($dbValues) && $dbValues) {
			$datas = $dbValues;
		}
		if (is_array($datas) && $datas) {
			//set parent values
			parent::__construct($datas['object_id_mof'],$datas);
			//set field values
			$this->_fieldID = (int) $datas['id_mof'];
			$this->_objectFieldValues["objectID"] 		= (int) $datas['object_id_mof'];
	  		$this->_objectFieldValues["labelID"] 		= (int) $datas['label_id_mof'];
			$this->_objectFieldValues["descriptionID"]	= (int) $datas['desc_id_mof'];
			$this->_objectFieldValues["type"] 			= $datas['type_mof'];
			$this->_objectFieldValues["order"] 			= (int) $datas['order_mof'];
			$this->_objectFieldValues["system"] 		= ($datas['system_mof']) ? true:false;
			$this->_objectFieldValues["required"] 		= ($datas['required_mof']) ? true:false;
			$this->_objectFieldValues["indexable"] 		= ($datas['indexable_mof']) ? true:false;
			$this->_objectFieldValues["searchlist"] 	= ($datas['searchlist_mof']) ? true:false;
			$this->_objectFieldValues["searchable"] 	= ($datas['searchable_mof']) ? true:false;
			$this->_objectFieldValues["params"] 		= ($datas['params_mof']) ? unserialize($datas['params_mof']):array();
		} else {
			parent::__construct(0,array());
		}
	}
	
	/**
	  * Get field ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getID() {
		return $this->_fieldID;
	}
	
	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getObjectID() {
		return parent::getID();
	}
	
	/**
	  * Sets an object value.
	  *
	  * @param string $valueName the name of the value to set
	  * @param mixed $value the value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($valueName, $value) {
		if (!in_array($valueName,array_keys($this->_objectFieldValues))) {
			$this->raiseError("Unknown valueName to set :".$valueName);
			return false;
		}
		$this->_objectFieldValues[$valueName] = $value;
		return true;
	}
	
	/**
	  * get an object value.
	  *
	  * @param string $valueName the name of the value to get
	  * @return mixed, the value
	  * @access public
	  */
	function getValue($valueName) {
		if (!in_array($valueName,array_keys($this->_objectFieldValues))) {
			$this->raiseError("Unknown valueName to get : ".$valueName);
			return false;
		}
		return $this->_objectFieldValues[$valueName];
	}
	
	/**
	  * get admin field description if any
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label or false if none defined
	  * @access public
	  */
	function getFieldDescription($language) {
		if (!sensitiveIO::isPositiveInteger($this->getValue("descriptionID"))) {
			return false;
		}
		//get label of current field
		$description = new CMS_object_i18nm($this->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			return $description->getValue($language->getCode());
		} else {
			return $description->getValue($language);
		}
	}
	
	/**
	  * get a parameter value for a given parameter internal name.
	  *
	  * @param string $internalName the parameter internal name
	  * @return mixed, the parameter value
	  * @access public
	  */
	function getParameter($internalName) {
		return isset($this->_objectFieldValues["params"][$internalName]) ? $this->_objectFieldValues["params"][$internalName] : null;
	}
	
	/**
	  * get an object instance of the field type
	  *
	  * @param boolean $returnDefinition, return object CMS_poly_object_definition or CMS_poly_object otherwise
	  * @return mixed, the object instance
	  * @access public
	  */
	function getTypeObject($returnDefinition=false, $public = false) {
		if (!$this->_objectFieldValues['type']) {
			return false;
		}
		if (sensitiveIO::isPositiveInteger($this->_objectFieldValues['type'])) {
			if ($returnDefinition) {
				return new CMS_poly_object_definition($this->_objectFieldValues['type']);
			} else {
				$item = new CMS_poly_object($this->_objectFieldValues['type'], 0, array(), $public);
				//object is used as field as another object so set it
				$item->setField($this);
				return $item;
			}
		} elseif(io::strpos($this->_objectFieldValues['type'],'multi|') !== false) {
			return new CMS_multi_poly_object(io::substr($this->_objectFieldValues['type'],6),array(), $this, $public);
		} else {
			return new $this->_objectFieldValues['type'](array(), $this, $public);
		}
	}
	
	/**
	  * Return the next field order for current object ID
	  *
	  * @return array of CMS_object_fields
	  * @access public
	  * @static
	  */
	function getFieldsNextOrder() {
		if (sensitiveIO::isPositiveInteger($this->_objectFieldValues["objectID"])) {
			$sql = "
				select
					max(order_mof) as maxOrder
				from
					mod_object_field
				where
					object_id_mof  = '".$this->_objectFieldValues["objectID"]."'
			";
			$q = new CMS_query($sql);
			return ($q->getValue("maxOrder")+1);
		}
		return 1;
	}
	
	/**
	  * Writes object into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence() {
		//get Order if needed
		if (!$this->_objectFieldValues["order"] && sensitiveIO::isPositiveInteger($this->_objectFieldValues["objectID"])) {
			$this->_objectFieldValues["order"] = $this->getFieldsNextOrder();
		}
		
		$sql_fields = "
			object_id_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["objectID"])."',
			label_id_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["labelID"])."',
			desc_id_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["descriptionID"])."',
			type_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["type"])."',
			order_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["order"])."',
			system_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["system"])."',
			required_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["required"])."',
			indexable_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["indexable"])."',
			searchlist_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["searchlist"])."',
			searchable_mof='".SensitiveIO::sanitizeSQLString($this->_objectFieldValues["searchable"])."',
			params_mof='".SensitiveIO::sanitizeSQLString(serialize($this->_objectFieldValues["params"]))."'
		";
		
		//save data
		if ($this->_fieldID) {
			$sql = "
				update
					mod_object_field
				set
					".$sql_fields."
				where
					id_mof='".$this->_fieldID."'
			";
		} else {
			$sql = "
				insert into
					mod_object_field
				set
					".$sql_fields;
			
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Can't save object");
			return false;
		} elseif (!$this->_fieldID) {
			$this->_fieldID = $q->getLastInsertedID();
		}
		//unset field catalog in session
		unset($_SESSION["polyModule"]["objectFields"][$this->_objectFieldValues["objectID"]]);
		
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('module' => CMS_poly_object_catalog::getModuleCodenameForField($this->_fieldID)));
		return true;
	}
	
	/**
	  * Destroy this object, in DB and filesystem if needed
	  * Destroy title label also
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy() {
		if ($this->_fieldID) {
			//delete all files of objects for this field
			$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_fieldID);
			$filesDir = new CMS_file(PATH_MODULES_FILES_FS.'/'.$module, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
			if ($filesDir->exists()) {
				//search all files of this field
				$filesList = $filesDir->getFileList(PATH_MODULES_FILES_FS.'/'.$module.'/*_f'.$this->_fieldID.'_*');
				//then delete them
				foreach($filesList as $aFile) {
					if (!CMS_file::deleteFile($aFile['name'])) {
						$this->raiseError("Can't delete file ".$aFile['name']." for field : ".$this->_fieldID);
						return false;
					}
				}
			}
			
			//delete all datas of objects for this field
			$tables = array(
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
			foreach ($tables as $aTable) {
				$sql = "
					delete from
						".$aTable."
					where
						objectFieldID = '".$this->_fieldID."'
				";
				$q = new CMS_query($sql);
				if ($q->hasError()) {
					$this->raiseError("Can't delete datas of table ".$aTable." for field : ".$this->_fieldID);
					return false;
				}
			}
			//delete title label object
			if (sensitiveIO::IsPositiveInteger($this->_objectFieldValues["labelID"])) {
				$label = new CMS_object_i18nm($this->_objectFieldValues["labelID"]);
				$label->destroy();
			}
			
			//delete field DB record
			$sql = "
				delete from
					mod_object_field 
				where
					id_mof='".$this->_fieldID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->raiseError("Can't delete datas of table mod_object_field for field : ".$this->_fieldID);
				return false;
			}
			
			//Clear polymod cache
			CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $module));
		}
		//unset field catalog in session
		unset($_SESSION["polyModule"]["objectFields"][$this->_objectFieldValues["objectID"]]);
		//finally destroy object instance
		unset($this);
		return true;
	}
}
?>