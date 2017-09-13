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

/**
  * Class CMS_poly_object
  *
  * represent a polymorphic object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_object extends CMS_resource
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_POLYMOD_EMPTY_OBJECTS_SET = 265;
	const MESSAGE_POLYMOD_CHOOSE_OBJECT = 1132;

	const MESSAGE_POLYMOD_ACTION_EMAIL_SUBJECT = 31;
	const MESSAGE_POLYMOD_ACTION_EMAIL_BODY = 32;
	const MESSAGE_POLYMOD_ACTION_EMAIL_DELETE_SUBJECT = 53;
	const MESSAGE_POLYMOD_ACTION_EMAIL_DELETE_BODY = 55;

	/**
	  * Polymod Messages
	  */
	const MESSAGE_POLYOBJECT_ID_DESCRIPTION = 141;
	const MESSAGE_POLYOBJECT_LABEL_DESCRIPTION = 142;
	const MESSAGE_POLYOBJECT_FIELDNAME_DESCRIPTION = 118;
	const MESSAGE_POLYOBJECT_OBJECTNAME_DESCRIPTION = 143;
	const MESSAGE_POLYOBJECT_OBJECTDESC_DESCRIPTION = 144;
	const MESSAGE_POLYOBJECT_OBJECTTYPE_DESCRIPTION = 145;
	const MESSAGE_POLYOBJECT_FIELDID_DESCRIPTION = 146;
	const MESSAGE_POLYOBJECT_RESOURCE_DESCRIPTION = 147;
	const MESSAGE_POLYOBJECT_FUNCTION_SELECTOPTIONS_DESCRIPTION = 162;
	const MESSAGE_POLYOBJECT_DATESTART_FORMATEDVALUE_DESCRIPTION = 203;
	const MESSAGE_POLYOBJECT_DATEEND_FORMATEDVALUE_DESCRIPTION = 204;
	const MESSAGE_POLYOBJECT_FUNCTION_RSS_DESCRIPTION = 311;
	const MESSAGE_POLYOBJECT_FUNCTION_LOADOBJECT_DESCRIPTION = 312;
	const MESSAGE_POLYOBJECT_REQUIRED_DESCRIPTION = 366;
	const MESSAGE_OBJECT_VALIDATION_AWAIT_NOTIFICATION = 364;
	const MESSAGE_OBJECT_DELETION_AWAIT_NOTIFICATION = 365;
	const MESSAGE_OBJECT_FIELD_DESC_DESCRIPTION = 402;
	const MESSAGE_POLYOBJECT_DATE_HASVALUE_DESCRIPTION = 411;
	const MESSAGE_POLYOBJECT_DATE_TIMESTAMP_DESCRIPTION = 605;
	const MESSAGE_POLYOBJECT_OBJECT_LIST_ZONE = 633;
	const MESSAGE_PAGE_ACTION_ASSOCIATE = 1267;
	const MESSAGE_POLYOBJECT_OBJECT_CHOOSE_ELEMENT = 518;
	const MESSAGE_PAGE_ACTION_DESASSOCIATE = 1268;
	const MESSAGE_POLYOBJECT_OBJECT_DISASSOCIATE_ELEMENT = 517;
  	const MESSAGE_POLYOBJECT_OBJECT_SELECT_BEFORE = 608;
	const MESSAGE_PAGE_ACTION_DESASSOCIATE_CONFIRM = 607;
	const MESSAGE_PAGE_ACTION_MODIFIY = 261;
	const MESSAGE_POLYOBJECT_OBJECT_EDIT_ELEMENT = 516;
  	const MESSAGE_PAGE_ACTION_NEW = 262;
	const MESSAGE_POLYOBJECT_OBJECT_CREATE_ZONE = 193;

	/**
	  * object id (relative to id in mod_object_polyobjects table)
	  * @var integer
	  * @access private
	  */
	protected $_ID;

	/**
	  * object id in catalog (relative to id in mod_object_def table)
	  * @var array('string dbvarname' => 'string var type')
	  * @access private
	  */
	protected $_objectID;

	/**
	  * object fields definition (from CMS_poly_object_catalog relative to all CMS_object_fields of object)
	  * @var 	array(integer "FieldID" => CMS_object_fields) (sorted)
	  * @access private
	  */
	protected $_objectFieldsDefinition = array();

	/**
	  * This object label (relative to labelID of CMS_object_def)
	  * @var string
	  * @access private
	  */
	protected $_objectName;

	/**
	  * This object description (relative to descriptionID of CMS_object_def)
	  * @var string
	  * @access private
	  */
	protected $_objectDesc;

	/**
	  * CMS_poly_object_field reference (only if this object is used as a field of another object)
	  * @var CMS_object_field
	  * @access private
	  */
	protected $_field;

	/**
	  * This object composed label if any (relative to composedLabel of CMS_object_def)
	  * @var string
	  * @access private
	  */
	protected $_composedLabel = "";

	/**
	  * all sub objects definitions (from CMS_object_{type})
	  * @var array(integer "fieldID" => array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer)))
	  * @access private
	  */
	protected $_subObjectsDefinitions = array();

	/**
	  * all fields values for object
	  * @var array(integer "fieldID" => mixed)
	  * @access private
	  */
	public $_objectValues = array();

	/**
	  * all Fields values for poly object
	  * @var array(integer "fieldID" => CMS_subobject_integer)
	  * @access private
	  */
	protected $_polyObjectValues = array();

	/**
	  * Resource object status (0 : none, 1 : primary resource, 2 : secondary resource)
	  * @var integer
	  * @access private
	  */
	protected $_objectResourceStatus;

	/**
	  * Resource object id if object is a primary resource
	  * @var CMS_subobject_integer
	  * @access private
	  */
	protected $_resource;

	/**
	  * Does subobjects values loaded
	  * @var boolean
	  * @access private
	  */
	protected $_loadSubObjectsValues;

	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $objectID the object type id in catalog (relative to id in mod_object_def table)
	  * @param integer $id the object id (relative to id in mod_object_polyobjects table)
	  * @param array $datas the object and sub objects values
	  * @param boolean $public, object values are public or edited ? (default is edited)
	  * @param boolean $loadObject, load object values from db if not found in params ?
	  * @param boolean $loadSubObjectsValues, /!\ Experimental /!\ Load subobjects datas. Default : true. Only for public objects.
	  *		in case of large objects to manage, we can limit the memory usage by disallow loading of sub objects datas structure.
	  * @return void
	  * @access public
	  */
	function __construct($objectID, $id = 0, $datas = array(), $public = false, $loadObject=true, $loadSubObjectsValues=true)
	{
		//check object type id
		if (sensitiveIO::isPositiveInteger($objectID)) {
			//set $this->_objectID
			$this->_objectID = $objectID;
			//set $this->_objectFieldsDefinition
			$this->_objectFieldsDefinition = CMS_poly_object_catalog::getFieldsDefinition($objectID);
			//get Object definition
			$objectDef = $this->getObjectDefinition();
			//set $this->_objectName
			$this->_objectName = $objectDef->getValue("labelID");
			//set $this->_objectDesc
			$this->_objectDesc = $objectDef->getValue("descriptionID");
			//set $this->_objectResourceStatus
			$this->_objectResourceStatus = $objectDef->getValue("resourceUsage");
		} else {
			$this->setError("ObjectID is not a positive Integer : ".$objectID);
			return;
		}
		//set $this->_public
		$this->_public = $public;

		$this->_loadSubObjectsValues = ($this->_public && !$loadSubObjectsValues) ? false : true;

		//set $this->_ID
		if (sensitiveIO::isPositiveInteger($id)) {
			$this->_ID = $id;
		}

		//set $this->_subObjectsDefinitions
		if ($this->_objectFieldsDefinition) {
			$this->_populateSubObjectsDefinitions();
		}

		//set $this->_objectValues
		if ($this->_ID && $this->_subObjectsDefinitions && $loadObject && !isset($datas[$this->_ID])) {
			//set $this->_objectValues from DB
			if(!$this->_loadObject()){
			    $this->_ID = '';
			} else {
				//set $this->_composedLabel if any (only if object is loaded)
				$this->_composedLabel = $objectDef->getValue("composedLabel");
			}
		} elseif ($this->_ID && is_array($datas) && isset($datas[$this->_ID]) && $datas[$this->_ID]) {
			//set $this->_objectValues from given datas
			$this->_populateSubObjectsValues($datas);
			//set $this->_composedLabel if any (only if object is loaded)
			$this->_composedLabel = $objectDef->getValue("composedLabel");
		} elseif (!$this->_ID) {
			//load clean subObjects and set $this->_objectValues
			$this->_populateSubObjects();
		}
	}

	/**
	  * load all object and subobjects values from DB
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _loadObject() {
		//get object definition
		$objectDef = $this->getObjectDefinition();
		//create new search to get all DB values for this object and all subobjects
		$search = new CMS_object_search($objectDef,$this->_public);
		//limit to this object
		$search->addWhereCondition('item',$this->_ID);
		//launch search
		$datas = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_DATAS);
		unset($search);
		if (!$this->_public && (!$datas || !$datas[$this->_ID])) {
			$this->setError('No datas found for edited item '.$this->_ID.'. Current user should have no rights on this item...');
			return false;
		}
		//then populate object(s) values
		$this->_populateSubObjectsValues($datas);
		return true;
	}

	/**
	  * Sets subobjects Values
	  *
	  * @param array datas : array created by loadObject method
	  * 		array(integer objectID => array(integer objectFieldID => array(integer objectSubFieldID => array(DB values))))
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _populateSubObjectsValues($datas) {
		if (!is_array($datas)) {
			$this->setError("Datas need to be an array : ".print_r($datas,true));
			return false;
		}
		if (isset($datas[$this->_ID]) && $datas[$this->_ID]) {
			foreach(array_keys($this->_subObjectsDefinitions) as $fieldID) {
				$subFieldsValues = isset($datas[$this->_ID][$fieldID]) ? $datas[$this->_ID][$fieldID] : null;
				if (is_object($this->_objectFieldsDefinition[$fieldID])) {
					$field = &$this->_objectFieldsDefinition[$fieldID];
					$type = $field->getValue('type');
					if (sensitiveIO::isPositiveInteger($type)) { //poly object
						//load poly object
						$loadSubObjects = ($field->getParameter('loadSubObjects')) ? true:false;
						if ($this->_loadSubObjectsValues) {
							$this->_objectValues[$fieldID] = new CMS_poly_object($type, $subFieldsValues[0]['value'], $datas, $this->_public, $loadSubObjects);
							//object is used as field as another object so set it
							$this->_objectValues[$fieldID]->setField($field);
						} else {
							$this->_objectValues[$fieldID] = '';
						}
						//load CMS_subobject_integer to store id value of poly object
						$this->_polyObjectValues[$fieldID] = new CMS_subobject_integer($subFieldsValues[0]['id'],array(),$subFieldsValues[0], $this->_public);
					} elseif (io::strpos($type,"multi|") !== false) { //multi objects
						if (!is_array($subFieldsValues)) {
							$subFieldsValues = array();
						}
						if ($this->_loadSubObjectsValues) {
							//create multi sub object
							$this->_objectValues[$fieldID] = new CMS_multi_poly_object(io::substr($type,6),$subFieldsValues, $field, $this->_public);
							//and set subObjectValues
							$this->_objectValues[$fieldID]->populateSubObjectsValues($datas);
						} else {
							$this->_objectValues[$fieldID] = '';
						}
					} elseif (class_exists($type)) { //object
						if (!is_array($subFieldsValues)) {
							$subFieldsValues = array();
						}
						$this->_objectValues[$fieldID] = new $type($subFieldsValues, $field, $this->_public);
					} else {
						$this->setError("Unknown field type : ".$type);
						return;
					}
				} else {
					$this->setError("Unknown fieldID for object : ".$fieldID);
					return false;
				}
			}
			//if this object is a primary resource, load CMS_subobject_integer to store resource value if any
			if ($this->_objectResourceStatus == 1) {
				if (isset($datas[$this->_ID][0]) && $datas[$this->_ID][0]) {
					$subFieldsValues = $datas[$this->_ID][0];
					$this->_resource = new CMS_subobject_integer($subFieldsValues[0]['id'],array(),$subFieldsValues[0], $this->_public);
					parent::__construct($subFieldsValues[0]['value']);
				} else {
					parent::__construct();
					$this->_resource = new CMS_subobject_integer('',array(),array(), $this->_public);
				}
			}
		} else {
			//load clean subObjects and set $this->_objectValues
			$this->_populateSubObjects();
		}
		unset($datas);
		return true;
	}

	/**
	  * Sets clean subobjects
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _populateSubObjects() {
		//get all subObjects for fields
		foreach(array_keys($this->_objectFieldsDefinition) as $fieldID) {
			$this->_objectValues[$fieldID] = $this->_objectFieldsDefinition[$fieldID]->getTypeObject(false, $this->_public);
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				//load CMS_subobject_integer to store value
				$this->_polyObjectValues[$fieldID] = new CMS_subobject_integer('',array(),array(), $this->_public);
			}
		}

		//if this object is a primary resource, load CMS_subobject_integer to store resource value
		if ($this->_objectResourceStatus == 1) {
			parent::__construct();
			$this->_resource = new CMS_subobject_integer('',array(),array(), $this->_public);
		}
		return true;
	}

	/**
	  * Sets subObjectsDefinitions
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _populateSubObjectsDefinitions() {
		if (!$this->_objectFieldsDefinition) {
			$this->setError("No fields for objectID : ".$this->_objectID." in catalog");
			return false;
		}
		//get all subDefinitions for fields
		foreach(array_keys($this->_objectFieldsDefinition) as $fieldID) {
			if (is_object($this->_objectFieldsDefinition[$fieldID])) {
				$type = $this->_objectFieldsDefinition[$fieldID]->getValue('type');
				if (sensitiveIO::isPositiveInteger($type)) { //poly object
					$typeObject = new CMS_poly_object($type);
					$this->_subObjectsDefinitions[$fieldID] = $typeObject->getSubFieldsDefinition($this->_ID);
				} elseif (io::strpos($type,"multi|") !== false) { //multi objects
					$this->_subObjectsDefinitions[$fieldID] = CMS_multi_poly_object::getSubFieldsDef(io::substr($type,6),$this->_ID,$this->_objectFieldsDefinition[$fieldID]);
				} elseif (class_exists($type)) { //object
					$typeObject = new $type(array(),$this->_objectFieldsDefinition[$fieldID]);
					$this->_subObjectsDefinitions[$fieldID] = $typeObject->getSubFieldsDefinition($this->_ID);
				} else {
					$this->setError("Unknown field type : ".$type);
					return false;
				}
			}
		}
		return true;
	}

	/**
	  * Get field ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getID()
	{
		return $this->_ID;
	}

	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getObjectID()
	{
		return $this->_objectID;
	}

	/**
	  * Get all subobject
	  *
	  * @return array of mixed cms_object_{type}
	  * @access public
	  */
	function getFieldsObjects() {
		return $this->_objectValues;
	}

	/**
	  * get object resource status
	  * beware, for secondary resources, real status is not checked, use isSecondaryResource method of CMS_poly_object_definition instead
	  *
	  * @return integer, the object resource status
	  * @access public
	  */
	function getObjectResourceStatus() {
		return $this->_objectResourceStatus;
	}

	/**
	  * set CMS_poly_object_field reference (only if this object is used as a field of another object)
	  *
	  * @param $field CMS_poly_object_field : the field reference for this object
	  * @return void
	  * @access public
	  */
	function setField($field) {
		//set $this->_field
		$this->_field = &$field;
	}

	/**
	  * get object language if any language field exists else, return APPLICATION_DEFAULT_LANGUAGE
	  *
	  * @return integer, the object resource status
	  * @access public
	  */
	function getLanguage() {
		static $languageFieldIDForObjectType;
		//find language field for this type of object
		if (!isset($languageFieldIDForObjectType[$this->_objectID])) {
			$languageFieldIDForObjectType[$this->_objectID] = false;
			foreach(array_keys($this->_subObjectsDefinitions) as $fieldID) {
				$type = $this->_objectFieldsDefinition[$fieldID]->getValue('type');
				if ($type == 'CMS_object_language') { //language field
					$languageFieldIDForObjectType[$this->_objectID] = $fieldID;
				}
			}
		}
		if ($languageFieldIDForObjectType[$this->_objectID] === false) {
			return io::strtolower(APPLICATION_DEFAULT_LANGUAGE);
		}
		//then get field value
		$value = $this->_objectValues[$languageFieldIDForObjectType[$this->_objectID]]->getValue('value');
		return ($value) ? $value : io::strtolower(APPLICATION_DEFAULT_LANGUAGE);
	}

	/**
	  * Get languages for object from
	  * - Categories (which support multi language)
	  * - Sub object multiple which has a language field
	  *
	  * @return array of supported languages codes or false if only one language is supported
	  * @access public
	  */
	function getLanguages() {
		static $languages;
		//find language field for this type of object
		if (!isset($languageFieldIDForObjectType[$this->_objectID])) {
			//get Object definition
			$objectDef = $this->getObjectDefinition();
			$languages[$this->_objectID] = array();
			if ($objectDef->getValue("multilanguage")) {
				foreach(array_keys($this->_subObjectsDefinitions) as $fieldID) {
					$type = $this->_objectFieldsDefinition[$fieldID]->getValue('type');
					if ($type == 'CMS_object_language') { //language field
						//object is not multilanguage if a language field exists
						return false;
					} elseif ($type == 'CMS_object_category') {
						//get module codename
						$polyModuleCodename = $objectDef->getValue('module');
						$allLanguages = CMS_languagesCatalog::getAllLanguages($polyModuleCodename);
						foreach ($allLanguages as $code => $language) {
							$languages[$this->_objectID][$code] = $code;
						}
					} elseif (substr($type, 0, 6) == 'multi|') {
						$subObjects = $this->_objectValues[$fieldID]->getValue('fields');
						foreach ($subObjects as $subObject) {
							$code = $subObject->getLanguage();
							$languages[$this->_objectID][$code] = $code;
						}
					}
				}
			}
		}
		return $languages[$this->_objectID];
	}

	/**
	  * Get object publication date
	  * If object is a primary resource, return resource pub date else, try to find a date field with creation date
	  *
	  * @return CMS_date, the publication date object if any (false otherwise)
	  * @access public
	  */
	function getPublicationDate() {
		static $pubFieldIDForObjectType;
		if ($this->getObjectResourceStatus() == 1) {
			return $this->getPublicationDateStart();
		} else {
			//find creation date field for this type of object
			if (!isset($pubFieldIDForObjectType[$this->_objectID])) {
				$pubFieldIDForObjectType[$this->_objectID] = false;
				foreach(array_keys($this->_subObjectsDefinitions) as $fieldID) {
					$type = $this->_objectFieldsDefinition[$fieldID]->getValue('type');
					if ($type == 'CMS_object_date' && $this->_objectFieldsDefinition[$fieldID]->getParameter('creationDate')) { //date field
						$pubFieldIDForObjectType[$this->_objectID] = $fieldID;
					}
				}
			}
			if ($pubFieldIDForObjectType[$this->_objectID] === false) {
				return false;
			}
			//then get field value
			$value = $this->_objectValues[$pubFieldIDForObjectType[$this->_objectID]]->getValue('value');
			$date = new CMS_date();
			$date->setFromDBValue($value);
			return $date;
		}
	}

	/**
	  * Get object Definition (CMS_poly_object_definition)
	  *
	  * @return CMS_poly_object_definition
	  * @access public
	  */
	function getObjectDefinition () {
		return CMS_poly_object_catalog::getObjectDefinition($this->_objectID);
	}

	/**
	  * Get subfields definition for current object
	  *
	  * @param integer (can be null - for compatibility only) $objectID the object ID who requests these infos
	  * @return array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @access public
	  */
	function getSubFieldsDefinition($objectID = "") {
		$subFieldsDefinition=array();
		foreach(array_keys($this->_objectValues) as $subFieldID) {
			if (!is_a($this->_objectValues[$subFieldID],'CMS_multi_poly_object')) {
				$subFieldDefinition = $this->_objectValues[$subFieldID]->getSubFieldsDefinition($this->_ID);
			} else {
				$type = $this->_objectFieldsDefinition[$subFieldID]->getValue('type');
				$subFieldDefinition = CMS_multi_poly_object::getSubFieldsDef(io::substr($type,6),$this->_ID,$this->_objectFieldsDefinition[$subFieldID]);
			}
			$subFieldsDefinition = array_merge($subFieldsDefinition,$subFieldDefinition);
		}
		return $subFieldsDefinition;
	}

	/**
	  * Get soap values
	  *
	  * @param integer $fieldID The field ID
	  * @param object $language The CMS_language to deal with
	  *
	  * @return string $xml XML definition
	  * @access public
	  */
	function getSoapValues($fieldID, $language) {
		$xml = '';
		$xmlFields = '';

		//get Object definition
		$objectDef = $this->getObjectDefinition();
		//get module codename
		$moduleCodename = $objectDef->getValue('module');

		foreach(array_keys($this->_objectValues) as $subFieldID) {
			$xmlFields .= $this->_objectValues[$subFieldID]->getSoapValues($subFieldID, $language);
		}

		$resource = '';
		switch($this->_objectResourceStatus) {
			case 2: //secondary
				$resource = '<resource type="2" name="secondary"/>';
			break;
			case 1: //primary
				$dateStart = $this->getPublicationDateStart();
		    	$dateEnd = $this->getPublicationDateEnd();
				$resource =
				'<resource type="1" name="primary">
					<pubdatestart>'.$dateStart->getDBValue().'</pubdatestart>
					<pubdateend>'.$dateEnd->getDBValue().'</pubdateend>
				</resource>';
			break;
			case 0: //none
			default:
				$resource = '<resource type="0" name="none"/>';
			break;
		}

		$xml .=
		'<object module="'.SensitiveIO::sanitizeHTMLString($moduleCodename).'" type="'.$objectDef->getID().'" id="'.$this->getID().'" label="'.SensitiveIO::sanitizeHTMLString($this->getLabel()).'">
			'.$resource.'
			'.$xmlFields.'
		</object>';

		return $xml;
	}

	/**
	  * Get soap values
	  *
	  * @param integer $fieldID The field ID
	  * @param object $language The CMS_language to deal with
	  * @param string $xml Values to set
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setSoapValues($fieldID, $domdocument) {
	    $view = CMS_view::getInstance();
		$return = true;
		$itemId = '';
        // Fields
        foreach($domdocument->childNodes as $childNode) {
			if($childNode->nodeType == XML_ELEMENT_NODE) {
				switch ($childNode->tagName) {
					case 'field':
						//<field id="40" label="Identifiant" required="1">
						$fieldId = $childNode->getAttribute('id');
						if (!sensitiveIO::isPositiveInteger($fieldId)) {
							$view->addError('Missing or invalid attribute id for field tag');
							return false;
						}
						if (!isset($this->_objectValues[$fieldId])) {
							$view->addError('Unknown field id '.$fieldId.' for object '.$this->_objectID);
							return false;
						}
						// Check if field requires itemID to set values

						if(method_exists($this->_objectValues[$fieldId], 'needIDToSetValues')){
						    if (!$this->getID()) {
						        //if object has no id yet, save it
						        if(!$this->writeToPersistence(false, false, true)){
						            $view->addError('Error during saving process (pre-saving need for the field '.$this->_objectID.')');
							        return false;
						        }
					        }
					        $itemId = $this->getID();
						}

						if (!$this->_objectValues[$fieldId]->setSoapValues($fieldId, $childNode, $itemId)) {
							$view->addError('Unable to set values for field '.$fieldId);
							$return = false;
						}
					break;
					case 'resource':
						//TODO
					break;
					default:
						$view->addError('Unknown xml tag '.$childNode->tagName.' to process.');
						return false;
					break;
				}
			} else {
				if ($childNode->nodeType == XML_TEXT_NODE && trim($childNode->nodeValue)) {
					$view->addError('Unknown xml content tag '.$childNode->nodeValue.' to process.');
					return false;
				}
			}
        }
		return $return;
	}

	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @param CMS_language $language, the current admin language
	  * @param string prefixname : the prefix to use for post names
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLAdmin($fieldID, $language, $prefixName) {
		global $cms_user;
		if (is_object($this->_objectFieldsDefinition[$fieldID])) {
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				//is this field mandatory ?
				$mandatory = $this->_objectFieldsDefinition[$fieldID]->getValue('required') ? '<span class="atm-red">*</span> ' : '';
				$desc = $this->_objectFieldsDefinition[$fieldID]->getFieldDescription($language);
				$params = array();
				$params['doNotUseExternalSubObjects'] = false;

				if (POLYMOD_DEBUG) {
					$desc .= $desc ? '<br />' : '';
					$desc .= '<span class="atm-red">Field : '.$fieldID.' - Value : <ul>';
					$desc .= '<li>'.$fieldID.'&nbsp;:&nbsp;'.$this->_polyObjectValues[$fieldID]->getValue().'</li>';
					$desc .= '</ul></span>';
				}

				$label = $desc ? '<span class="atm-help" ext:qtip="'.io::htmlspecialchars($desc).'">'.$mandatory.$this->_objectFieldsDefinition[$fieldID]->getLabel($language).'</span>' : $mandatory.$this->_objectFieldsDefinition[$fieldID]->getLabel($language);

				$listId = 'list'.md5(mt_rand().microtime());

				//get object definition
				$objectDef = $this->_objectFieldsDefinition[$fieldID]->getTypeObject(true);

				$associatedItems = array();
				if (isset($this->_polyObjectValues[$fieldID]) && is_object($this->_polyObjectValues[$fieldID]) && !is_null($this->_polyObjectValues[$fieldID]->getValue())) {
					$associatedItem = $this->_polyObjectValues[$fieldID]->getValue();
				} else {
					$associatedItem = '';
				}

				$items = array();
				$editURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/item.php';
				$associateURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/associate-items.php';
				$searchURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/search.php';
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_objectFieldsDefinition[$fieldID]->getID());
				$objectID = $this->_objectValues[$fieldID]->getObjectID();
				if (!$cms_user->hasModuleClearance($moduleCodename, CLEARANCE_MODULE_EDIT)) {
					define("MESSAGE_ERROR_MODULE_RIGHTS",570);
					$module = CMS_modulesCatalog::getByCodename($moduleCodename);
					$items[] = array(
							'width'			=> '100%',
							'layout'		=> 'fit',
							'border'		=> false,
							'bodyStyle'		=> 'margin:5px 0 3px 0',
							'html'			=> $language->getMessage(MESSAGE_ERROR_MODULE_RIGHTS,array($module->getLabel($language)))
						);
				} else {
					$items[] = array(
							'width'			=> '100%',
							'layout'		=> 'fit',
							'border'		=> false,
							'bodyStyle'		=> 'margin:5px 0 3px 0',
							'html'			=> $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECT_LIST_ZONE,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME)
						);
					$items[] = array(
						'xtype'			=> "multiselect2",
			            'hideLabel'		=> true,
			            'id'			=>	$listId,
						'name'			=>	'polymodFieldsValue['.$prefixName.$this->_objectFieldsDefinition[$fieldID]->getID().'_0]',
						'allowBlank'	=> !$this->_objectFieldsDefinition[$fieldID]->getValue('required'),
			            'valueField'	=> 'id',
						'displayField'	=> 'label',
						'listeners'		=> array(
							'valid' => sensitiveIO::sanitizeJSString('function(field) {
								if (field.getValue()) {
									Ext.getCmp(\'btnAssociate'.$listId.'\').disable();
									Ext.getCmp(\'btnDesassociate'.$listId.'\').enable();
									Ext.getCmp(\'btnModify'.$listId.'\').enable();
									Ext.getCmp(\'btnNew'.$listId.'\').disable();
								} else {
									Ext.getCmp(\'btnAssociate'.$listId.'\').enable();
									Ext.getCmp(\'btnDesassociate'.$listId.'\').disable();
									Ext.getCmp(\'btnModify'.$listId.'\').disable();
									Ext.getCmp(\'btnNew'.$listId.'\').enable();
								}
								if (field.store.getAt(0)) {
									if (field.store.getAt(0).data.locked) {
										Ext.getCmp(\'btnModify'.$listId.'\').disable();
									}
								}
								return true;
							}', false, false),
							'render' => sensitiveIO::sanitizeJSString('function(field) {
								if (field.getValue()) {
									Ext.getCmp(\'btnAssociate'.$listId.'\').disable();
									Ext.getCmp(\'btnDesassociate'.$listId.'\').enable();
									Ext.getCmp(\'btnModify'.$listId.'\').enable();
									Ext.getCmp(\'btnNew'.$listId.'\').disable();
								} else {
									Ext.getCmp(\'btnAssociate'.$listId.'\').enable();
									Ext.getCmp(\'btnDesassociate'.$listId.'\').disable();
									Ext.getCmp(\'btnModify'.$listId.'\').disable();
									Ext.getCmp(\'btnNew'.$listId.'\').enable();
								}
								if (field.store.getAt(0)) {
									if (field.store.getAt(0).data.locked) {
										Ext.getCmp(\'btnModify'.$listId.'\').disable();
									}
								}
								return true;
							}', false, false)
						),
						'tpl'			=> sensitiveIO::sanitizeJSString('<tpl for="rows">
							<dl>
								<tpl for="parent.columns">
									<dt style="width:100%;text-align:{align};" class="MultiselectDD">
										<div unselectable="on" class="atm-result x-unselectable" id="object-{parent.id}">
											<div class="atm-title">
												<table>
													<tr>
														<td class="atm-label" ext:qtip="ID: {parent.id}">{parent.status}&nbsp;{parent.label}</td>
														<td class="atm-pubrange">{parent.pubrange}</td>
													</tr>
												</table>
											</div>
											<div class="atm-description">{parent.description}<div style="clear:both;height:1px;">&nbsp;</div></div>
										</div>
									</dt>
								</tpl>
								<div class="x-clear"></div>
							</dl>
		                </tpl>'),
						'scripts'		=> true, //execute JS scripts in response
						'store'			=> array(
							'xtype'				=> 'atmJsonstore',
							'root'				=> 'results',
							'totalProperty'		=> 'total',
							'url'				=> $searchURL,
							'id'				=> 'id',
							'remoteSort'		=> true,
							'baseParams'		=> array(
								'module'			=> $moduleCodename,
								'objectId'			=> $objectID
							),
							'fields'			=> array('id', 'status', 'pubrange', 'label', 'description', 'locked', 'deleted', 'previz', 'edit')
						),
						'value' 		=> $associatedItem,
			            'width'			=> 'auto',
						'height'		=> 'auto',
						'cls'			=> 'x-list-body',
						'tbar'			=> array(
							array(
								'id'		=> 'btnAssociate'.$listId,
								'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_ASSOCIATE),
								'tooltip'	=> $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECT_CHOOSE_ELEMENT,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME),
								'handler'	=> sensitiveIO::sanitizeJSString('function(button){
									var windowId = \'module'.$moduleCodename.'AssociateWindow\';
									/*create window element*/
									var window = new Automne.Window({
										id:				windowId,
										objectId:		\'\',
										autoLoad:		{
											url:			\''.$associateURL.'\',
											params:			{
												winId:			windowId,
												module:			\''.$moduleCodename.'\',
												type:			\''.$objectID.'\',
												unique:			1
											},
											nocache:		true,
											scope:			this
										},
										modal:			true,
										width:			750,
										height:			580,
										animateTarget:	button,
										listeners:{\'close\':function(window){
											var cmp = Ext.getCmp(\''.$listId.'\');
											if (window.selectedItem) {
												cmp.setValue(window.selectedItem);
											}
										}}
									});
									/*display window*/
									window.show(button.getEl());
								}', false, false),
								'scope'		=> 'this'
							),
							array(
								'id'		=> 'btnDesassociate'.$listId,
								'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_DESASSOCIATE),
								'tooltip'	=> $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECT_DISASSOCIATE_ELEMENT, false, MOD_POLYMOD_CODENAME),
								'handler'	=> sensitiveIO::sanitizeJSString('function(button){
									var cmp = Ext.getCmp(\''.$listId.'\');
									var selected = cmp.view.getSelectedRecords();
									if (!selected.length || selected.length > 1) {
										Automne.message.popup({
											msg: 				\''.$language->getJSMessage(self::MESSAGE_POLYOBJECT_OBJECT_SELECT_BEFORE, false, MOD_POLYMOD_CODENAME).'\',
											buttons: 			Ext.MessageBox.OKCANCEL,
											animEl: 			button.getEl(),
											closable: 			false,
											icon: 				Ext.MessageBox.INFO
										});
										return;
									}
									Automne.message.popup({
										msg: 				\''.io::htmlspecialchars($language->getMessage(self::MESSAGE_PAGE_ACTION_DESASSOCIATE_CONFIRM, array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME)).'\',
										buttons: 			Ext.MessageBox.OKCANCEL,
										animEl: 			button.getEl(),
										closable: 			false,
										icon: 				Ext.MessageBox.WARNING,
										scope:				this,
										fn: 				function (button) {
											if (button == \'ok\') {
												var cmp = Ext.getCmp(\''.$listId.'\');
												var selected = cmp.view.getSelectedRecords();
												if (!selected.length || selected.length > 1) {
													return;
												}
												var objectId = selected[0].id;
												var values = cmp.getRawValue();
												values.remove(objectId);
												cmp.setValue(values.join(cmp.delimiter));

												if (cmp.getValue()) {
													Ext.getCmp(\'btnAssociate'.$listId.'\').disable();
													Ext.getCmp(\'btnDesassociate'.$listId.'\').enable();
													Ext.getCmp(\'btnModify'.$listId.'\').enable();
													Ext.getCmp(\'btnNew'.$listId.'\').disable();
												} else {
													Ext.getCmp(\'btnAssociate'.$listId.'\').enable();
													Ext.getCmp(\'btnDesassociate'.$listId.'\').disable();
													Ext.getCmp(\'btnModify'.$listId.'\').disable();
													Ext.getCmp(\'btnNew'.$listId.'\').enable();
												}
											}
										}
									});
								}', false, false),
								'scope'		=> 'this'
							),'->', array(
								'id'		=> 'btnModify'.$listId,
								'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_MODIFIY),
								'tooltip'	=> $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECT_EDIT_ELEMENT, false, MOD_POLYMOD_CODENAME),
								'iconCls'	=> 'atm-pic-modify',
								'handler'	=> sensitiveIO::sanitizeJSString('function(button){
									var cmp = Ext.getCmp(\''.$listId.'\');
									var selected = cmp.view.getSelectedRecords();
									if (!selected.length || selected.length > 1) {
										Automne.message.popup({
											msg: 				\''.$language->getJSMessage(self::MESSAGE_POLYOBJECT_OBJECT_SELECT_BEFORE, false, MOD_POLYMOD_CODENAME).'\',
											buttons: 			Ext.MessageBox.OKCANCEL,
											animEl: 			button.getEl(),
											closable: 			false,
											icon: 				Ext.MessageBox.INFO
										});
										return;
									}
									var objectId = selected[0].id;
									var windowId = \'module'.$moduleCodename.'EditWindow\'+objectId;
									/*create window element*/
									var window = new Automne.Window({
										id:				windowId,
										objectId:		objectId,
										autoLoad:		{
											url:			\''.$editURL.'\',
											params:			{
												winId:			windowId,
												module:			\''.$moduleCodename.'\',
												type:			\''.$objectID.'\',
												item:			objectId
											},
											nocache:		true,
											scope:			this
										},
										modal:			true,
										width:			750,
										height:			580,
										animateTarget:	button,
										listeners:{\'close\':function(window){
											var cmp = Ext.getCmp(\''.$listId.'\');
											cmp.store.reload();
										}}
									});
									/*display window*/
									window.show(button.getEl());
								}', false, false),
								'scope'		=> 'this'
							), array(
								'id'		=> 'btnNew'.$listId,
								'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_NEW),
								'tooltip'	=> $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECT_CREATE_ZONE,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME),
								'iconCls'	=> 'atm-pic-add',
								'handler'	=> sensitiveIO::sanitizeJSString('function(button){
									var objectId = \'create\';
									var windowId = \'module'.$moduleCodename.'EditWindow\'+objectId;
									/*create window element*/
									var window = new Automne.Window({
										id:				windowId,
										objectId:		\'\',
										autoLoad:		{
											url:			\''.$editURL.'\',
											params:			{
												winId:			windowId,
												module:			\''.$moduleCodename.'\',
												type:			\''.$objectID.'\'
											},
											nocache:		true,
											scope:			this
										},
										modal:			true,
										width:			750,
										height:			580,
										animateTarget:	button,
										listeners:{\'close\':function(window){
											var cmp = Ext.getCmp(\''.$listId.'\');
											if (window.objectId) {
												var values = cmp.getRawValue();
												values.unshift(window.objectId);
												cmp.setValue(values.join(cmp.delimiter));
											}
										}}
									});
									/*display window*/
									window.show(button.getEl());
								}', false, false),
								'scope'		=> 'this'
							),
						),
			            'ddReorder'		=> true
					);
				}
				$return = array(
					'title' 		=>	$label,
					'xtype'			=>	'fieldset',
					'autoHeight'	=>	true,
					'layout'		=>	'form',
					'defaults'		=> 	array(
						'anchor'		=> '97%',
					),
					'items'			=>	$items
				);
				return $return;
			} else {
				//return html for other type of objects fields
				return $this->_objectValues[$fieldID]->getHTMLAdmin($fieldID, $language, $prefixName);
			}
		} else {
			return false;
		}
	}

	/**
      * Return the needed form field tag for current object field
      *
      * @param array $values : parameters values array(parameterName => parameterValue) in :
      *     id : the form field id to set
      * @param multidimentionnal array $tags : xml2Array content of atm-function tag
      * @return string : the form field HTML tag
      * @access public
      */
	function getInput($fieldID, $language, $inputParams) {
		if (isset($this->_objectValues[$fieldID])) {
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				if (isset($inputParams['prefix'])) {
					$prefixName = $inputParams['prefix'];
					unset($inputParams['prefix']);
				} else {
					$prefixName = '';
				}
				//serialize all htmlparameters
				$htmlParameters = CMS_object_common::serializeHTMLParameters($inputParams);
				$html = '';
				//get searched objects conditions
				$searchedObjects = (is_array($this->_objectFieldsDefinition[$fieldID]->getParameter('searchedObjects'))) ? $this->_objectFieldsDefinition[$fieldID]->getParameter('searchedObjects') : array();
				$objectsNames = CMS_poly_object_catalog::getListOfNamesForObject($this->_objectValues[$fieldID]->getObjectID(), false, $searchedObjects);
				if (is_array($objectsNames) && $objectsNames) {
					//append field id to html field parameters (if not already exists)
					$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_objectFieldsDefinition[$fieldID]->getID().'_0"' : '';

					if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
						//create field value
						$value = isset($inputParams['value']) ? $inputParams['value'] : $this->_polyObjectValues[$fieldID]->getValue();
						$html .= '<input type="hidden"'.$htmlParameters.' name="'.$prefixName.$this->_objectFieldsDefinition[$fieldID]->getID().'_0" value="'.$value.'" />'."\n";
					} else {
						$html .= '<select name="'.$prefixName.$this->_objectFieldsDefinition[$fieldID]->getID().'_0"'.$htmlParameters.'>
									<option value="0">'.$language->getMessage(self::MESSAGE_POLYMOD_CHOOSE_OBJECT).'</option>';
						foreach ($objectsNames as $objectID => $objectName) {
							$selected = ((is_object($this->_polyObjectValues[$fieldID]) && $this->_polyObjectValues[$fieldID]->getValue() == $objectID) || ($inputParams['defaultvalue'] == $objectID && (!is_object($this->_polyObjectValues[$fieldID]) || !$this->_polyObjectValues[$fieldID]->getValue()))) ? ' selected="selected"':'';
							$html .= '<option value="'.$objectID.'"'.$selected.'>'.io::htmlspecialchars(io::decodeEntities($objectName)).'</option>'."\n";
						}
						$html .= '</select>';
					}
					if (POLYMOD_DEBUG) {
						$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.$this->_polyObjectValues[$fieldID]->getValue().' - objectID : '.$this->_objectValues[$fieldID]->getObjectID().')</span>';
					}
				} else {
					$html .= $language->getMessage(self::MESSAGE_POLYMOD_EMPTY_OBJECTS_SET);
				}
				//append html hidden field which store field name
				if ($html) {
					$html .= '<input type="hidden" name="polymodFields['.$this->_objectFieldsDefinition[$fieldID]->getID().']" value="'.$this->_objectFieldsDefinition[$fieldID]->getID().'" />';
				}
				return $html;
			} elseif (is_object($this->_objectValues[$fieldID])) {
				//return html for other type of objects fields
				return $this->_objectValues[$fieldID]->getInput($fieldID, $language, $inputParams);
			}
		}
		return '';
	}

	/**
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($fieldID, $values, $prefixName, $newFormat = false) {
		if (is_object($this->_objectFieldsDefinition[$fieldID])) {
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				//check values for poly object field
				if ($this->_objectFieldsDefinition[$fieldID]->getValue('required')) {
					//if no value set for it, return false
					if (!$values[$prefixName.$this->_objectFieldsDefinition[$fieldID]->getID().'_0']) {
						return false;
					}
				}
			} else {
				//check value for other type of objects fields
				return $this->_objectValues[$fieldID]->checkMandatory($values, $prefixName, $newFormat);
			}
		} else {
			return false;
		}
		return true;
	}

	/**
	  * get object label (composed by some objects fields)
	  *
	  * @return string : the object name
	  * @access public
	  */
	function getLabel() {
		//if object have a composed name return it
		if ($this->_composedLabel) {
			//$parameters = array('object' => &$this);
			$parameters['item'] = &$this;
			$parameters['public'] = $this->_public;
			$polymodParsing = new CMS_polymod_definition_parsing($this->_composedLabel, false);
			return $polymodParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
		} else {//else return only the first object field value
			if (is_array($this->_objectValues)) {
				$keys = array_keys($this->_objectValues);
				if (isset($keys[0]) && isset($this->_objectValues[$keys[0]]) && is_object($this->_objectValues[$keys[0]])) {
					return $this->_objectValues[$keys[0]]->getLabel();
				}
			}
			return '';
		}
	}

	/**
	  * get object type label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string : the object name
	  * @access public
	  */
	function getTypeLabel($language) {
		return $this->getObjectDefinition()->getLabel($language);
	}

	/**
	  * get object previzualisation URL if set
	  *
	  * @param boolean $addPrevizParameter : add the previz=previz parameter at end of address (default : true)
	  * @return string : the object previzualisation URL or false if none set
	  * @access public
	  */
	function getPrevizPageURL($addPrevizParameter = true) {
		//get Object definition
		$objectDef = $this->getObjectDefinition();
		if (!$objectDef->getValue("previewURL")) {
			//no previz set
			return false;
		}
		$previzInfos = explode('||',$objectDef->getValue("previewURL"));
		if (!sensitiveIO::isPositiveInteger($previzInfos[0])) {
			//no valid previz page set
			return false;
		}
		$page = CMS_tree::getPageByID($previzInfos[0]);
		if (!$page || $page->hasError()) {
			//no valid previz page set
			return false;
		}
		$previewPageURL = $page->getURL(false, false, PATH_RELATIVETO_WEBROOT, false, $addPrevizParameter);

		if (!$previewPageURL) {
			//no valid previz page set
			return false;
		}
		//convert URL parameters
		$parameters['item'] = &$this;
		$parameters['public'] = $this->_public;
		$polymodParsing = new CMS_polymod_definition_parsing($previzInfos[1], false);
		$previewPageParams = $polymodParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);

		//overwrite website host with admin current host (to avoid session lost)
		if ($addPrevizParameter) {
			//check for website host
			$pageHost = @parse_url($previewPageURL, PHP_URL_HOST);
			$httpHost = @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
			if ($pageHost && $_SERVER['HTTP_HOST'] && io::strtolower($httpHost) != io::strtolower($pageHost)) {
				//page host is not the same of current host so change it to avoid JS restriction
				$previewPageURL = str_replace($pageHost, $httpHost, $previewPageURL);
			}
			//check for website protocol
			$pageScheme = @parse_url($previewPageURL, PHP_URL_SCHEME);
			$currentScheme = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && strtolower($_SERVER["HTTPS"]) != 'off') ? 'https' : 'http';
			if ($pageScheme && $currentScheme != io::strtolower($pageScheme)) {
				$previewPageURL = str_replace($pageScheme.'://', $currentScheme.'://', $panelURL);
			}
		}

		return $previewPageURL.'?'.$previewPageParams.($addPrevizParameter ? '&atm-previz=previz' : '');
	}

	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription() {
		return $this->getLabel();
	}

	/**
	  * set fields objects Values
	  *
	  * @param integer $fieldID : the object field id to set values
	  * @param array $values : the POST result values
	  * @param string $prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($fieldID, $values, $prefix, $newFormat = false) {
		if (isset($this->_objectValues[$fieldID]) && is_object($this->_objectValues[$fieldID])) {
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				//set values for poly object field in $this->_polyObjectValues
				if (is_a($this->_polyObjectValues[$fieldID],'CMS_subobject_integer')) {
					if (isset($values[$prefix.$fieldID.'_0'])) {
						$value = $values[$prefix.$fieldID.'_0'] ? $values[$prefix.$fieldID.'_0'] : 0;
						return $this->_polyObjectValues[$fieldID]->setValue($value);
					} else {
						return true;
					}
				}
				return false;
			} else {
				//set values for other type of objects fields
				if (!method_exists($this->_objectValues[$fieldID], 'needIDToSetValues')) {
					//for object who does not need object id
					return $this->_objectValues[$fieldID]->setValues($values, $prefix, $newFormat);
				} else {
					//for object who need object id
					if (!$this->getID()) {
						//if object has no id yet, create it
						$this->writeToPersistence(false, false, true);
					}
					return $this->_objectValues[$fieldID]->setValues($values, $prefix, $newFormat, $this->getID());
				}
			}
		} else {
			return false;
		}
	}

	/**
	  * get admin field label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getFieldLabel($language) {
		//get label of current field
		$label = new CMS_object_i18nm($this->_objectName);
		if (is_a($language, "CMS_language")) {
			return $label->getValue($language->getCode());
		} else {
			return $label->getValue($language);
		}
	}

	/**
	  * get admin field description
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the description
	  * @access public
	  */
	function getFieldDesc($language) {
		//get label of current field
		$label = new CMS_object_i18nm($this->_objectDesc);
		if (is_a($language, "CMS_language")) {
			return $label->getValue($language->getCode());
		} else {
			return $label->getValue($language);
		}
	}

	/**
	  * Writes all objects values into persistence (MySQL for now), along with base data.
	  *
	  * @param boolean $withResource treat also the resource status (if object is a primary resource) default true
	  * @param boolean $emailValidators send emails to validators (if object is a primary resource) default true
	  * @param boolean $onlyCreateID create only the object ID (used to save fiels fields). Default false
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence($treatResource = true, $emailValidators = true, $onlyCreateID = false) {
		global $cms_user;
		if ($this->_public) {
			$this->setError("Can't write public object");
			return false;
		}
		if ($this->hasError()) {
			$this->setError("Can't write object with error");
			return false;
		}

		$isNew = $this->_ID === NULL;
		// Inform modules of the object creation
		$modules = CMS_modulesCatalog::getAll('id');
		foreach ($modules as $codename => $module) {
			if(method_exists($module, 'polyObjectPreSave')) {
				$module->polyObjectPreSave($this, $isNew);
			}
		}

		if (!$this->_ID) {
			//first, if object does not have ID, create one
			$sql = "
				insert into
					mod_object_polyobjects
				set
					object_type_id_moo='".SensitiveIO::sanitizeSQLString($this->_objectID)."'
				";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->setError("Can't save object");
				return false;
			} elseif (!$this->_ID) {
				//set ID
				$this->_ID = $q->getLastInsertedID();
				//reload all sub objects definition to add ID
				$this->_populateSubObjectsDefinitions();
			}
			if ($onlyCreateID) {
				return true;
			}
		}
		$forceSecondaryRessourcePublication = false;
		//if this object is a primary resource
		if($this->_objectResourceStatus == 1) {
			if ($treatResource) {
				//add content edition status
				$this->addEdition(RESOURCE_EDITION_CONTENT, $cms_user);
			}
			//write parent to persistence
			parent::writeToPersistence();
			//set $this->_resource
			$this->_resource->setValue(parent::getID());
			//then save resource ID
			//set definition for resource
			$definition = array('objectID' => $this->_ID,
								'fieldID' => 0,
								'subFieldID' => 0);
			$this->_resource->setDefinition($definition);
			if (!$this->_resource->writeToPersistence()) {
				return false;
			}
		} elseif ($this->_objectResourceStatus == 2) { //if this object is a secondary resource
			//get all primary resource associated
			$primaryItems = CMS_poly_object_catalog::getPrimaryItemsWhichUsesSecondaryItem($this->_ID, true, false);
			if ($primaryItems) {
				foreach ($primaryItems as $primaryItem) {
					$primaryItem->writeToPersistence();
				}
			} else {
				$forceSecondaryRessourcePublication = true;
			}
		}
		//save all subobjects
		foreach(array_keys($this->_objectValues) as $fieldID) {
			if (is_a($this->_objectValues[$fieldID],'CMS_poly_object')) {
				//set definition for poly object field in $this->_polyObjectValues
				$definition = array('objectID' => $this->_ID,
									'fieldID' => $fieldID,
									'subFieldID' => 0);
				$this->_polyObjectValues[$fieldID]->setDefinition($definition);
				if (!$this->_polyObjectValues[$fieldID]->writeToPersistence()) {
					return false;
				}
			} else {
				//set sub fields definitions for other object fields
				$this->_objectValues[$fieldID]->setSubFieldsDefinition($this->_subObjectsDefinitions[$fieldID]);
				if (!$this->_objectValues[$fieldID]->writeToPersistence()) {
					return false;
				}
			}
		}
		//resource management
		if ($treatResource) {
			//get Object definition
			$objectDef = $this->getObjectDefinition();
			//get module codename
			$polyModuleCodename = $objectDef->getValue('module');
			//if object is not a resource, copy datas to public location
			if (($this->_objectResourceStatus != 1 && $this->_objectResourceStatus != 2) || ($this->_objectResourceStatus == 2 && $forceSecondaryRessourcePublication)) {
				$modulesCodes = new CMS_modulesCodes();
				//add a call to all modules for before validation specific treatment
				$modulesCodes->getModulesCodes(MODULE_TREATMENT_BEFORE_VALIDATION_TREATMENT, '', $this, array('result' => VALIDATION_OPTION_ACCEPT, 'lastvalidation' => true, 'module' => $polyModuleCodename, 'action' => 'update'));
				//move resource datas to public location
				CMS_modulePolymodValidation::moveResourceData($polyModuleCodename, $this->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_PUBLIC, true);
				//add a call to all modules for after validation specific treatment
				$modulesCodes->getModulesCodes(MODULE_TREATMENT_AFTER_VALIDATION_TREATMENT, '', $this, array('result' => VALIDATION_OPTION_ACCEPT, 'lastvalidation' => true, 'module' => $polyModuleCodename, 'action' => 'update'));
			}
			//if item is a primary resource, send emails to validators
			if ($this->_objectResourceStatus == 1) {
				if (APPLICATION_ENFORCES_WORKFLOW) {
					if (!NO_APPLICATION_MAIL && $emailValidators) {
						$validators = CMS_profile_usersCatalog::getValidators($polyModuleCodename);
						//get editors
						$editors = $this->getEditors();
						$editorsIds = array();
						foreach($editors as $editor) {
							$editorsIds[] = $editor->getUserId();
						}
						foreach ($validators as $validator) {
							//add script to send email for validator if needed
							CMS_scriptsManager::addScript($polyModuleCodename, array('task' => 'emailNotification', 'object' => $this->getID(), 'validator' => $validator->getUserId(), 'type' => 'validate', 'editors' => $editorsIds));
						}
						//then launch scripts execution
						CMS_scriptsManager::startScript();
					}
				} else {
					$validation = new CMS_resourceValidation($polyModuleCodename, RESOURCE_EDITION_CONTENT, $this);
					$mod = CMS_modulesCatalog::getByCodename($polyModuleCodename);
					$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
				}
				//Log action
				$log = new CMS_log();
				$language = $cms_user->getLanguage();
				$status = $this->getStatus();
				$labelLocal = $this->getLabel();
				$objectDefLabel = $objectDef->getLabel($language);
				$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT, $cms_user, $polyModuleCodename, $status, 'Item \''.$labelLocal.'\' ('.$objectDefLabel.')', $this);
			} else {
				//Log action
				$log = new CMS_log();
				$language = $cms_user->getLanguage();
				$labelLocal = $this->getLabel();
				$objectDefLabel = $objectDef->getLabel($language);
				$log->logMiscAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT, $cms_user, 'Item \''.$labelLocal.'\' ('.$objectDefLabel.')', $polyModuleCodename);
			}
			//Clear polymod cache
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $polyModuleCodename));
			CMS_cache::clearTypeCache('polymod');
		}

		// Inform modules of the object creation
		$modules = CMS_modulesCatalog::getAll('id');
		foreach ($modules as $codename => $module) {
			if(method_exists($module, 'polyObjectPostSave')) {
				$module->polyObjectPostSave($this, $isNew);
			}
		}
		return true;
	}

	/**
	  * Delete object and values.
	  * If object is a primary resource, this deletion is submitted to validation and an email is sent to validators.
	  *
	  * @param boolean $hardDelete : completely destroy object and associated resource if any. After this, this object will no longer exists at all. Default : false.
	  * /!\ if object is a primary resource, no validation will be queried to validators, object will be directly destroyed from all locations. /!\
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function delete($hardDelete = false) {
		global $cms_user;
		//get Object definition
		$objectDef = $this->getObjectDefinition();
		//get module codename
		$polyModuleCodename = $objectDef->getValue('module');

		//if object is not a primary resource
		if ($this->_objectResourceStatus != 1 || $hardDelete) {
			$forceSecondaryRessourcePublication = false;
			if ($this->_objectResourceStatus == 2 && !$hardDelete) { //if this object is a secondary resource, primary items which uses this object must be updated
				//get all primary resource associated
				$primaryItems = CMS_poly_object_catalog::getPrimaryItemsWhichUsesSecondaryItem($this->_ID, true, false);
				if ($primaryItems) {
					foreach ($primaryItems as $primaryItem) {
						$primaryItem->writeToPersistence();
					}
				} else {
					$forceSecondaryRessourcePublication = true;
				}
			}
			//if object is not a secondary resource, delete public datas, else preserve it : it will be deleted on primary resource validation
			if ($this->_objectResourceStatus != 2 || ($this->_objectResourceStatus == 2 && $forceSecondaryRessourcePublication) || $hardDelete) {
				//delete datas from public locations
				CMS_modulePolymodValidation::moveResourceData($polyModuleCodename, $this->getID(), RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_DEVNULL);
				if (!$hardDelete) {
					//mark item as deleted
					CMS_modulePolymodValidation::markDeletedItem($this->getID());
				} else {
					//destroy poly_object reference
					$sql = "delete from mod_object_polyobjects where id_moo = '".$this->getID()."'";
					new CMS_query($sql);
				}
			}
			if (($this->_objectResourceStatus != 1 && $this->_objectResourceStatus != 2) || ($this->_objectResourceStatus == 2 && $forceSecondaryRessourcePublication)) {
				$modulesCodes = new CMS_modulesCodes();
				//add a call to all modules for before validation specific treatment
				$modulesCodes->getModulesCodes(MODULE_TREATMENT_BEFORE_VALIDATION_TREATMENT, '', $this, array('result' => VALIDATION_OPTION_ACCEPT, 'lastvalidation' => true, 'module' => $polyModuleCodename, 'action' => 'delete'));
			}
			if (!$hardDelete) {
				//move resource datas from edited to deleted location
				CMS_modulePolymodValidation::moveResourceData($polyModuleCodename, $this->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_DELETED);
			} else {
				//delete datas from edited locations
				CMS_modulePolymodValidation::moveResourceData($polyModuleCodename, $this->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_DEVNULL);
			}
			if (($this->_objectResourceStatus != 1 && $this->_objectResourceStatus != 2) || ($this->_objectResourceStatus == 2 && $forceSecondaryRessourcePublication)) {
				//add a call to all modules for after validation specific treatment
				$modulesCodes->getModulesCodes(MODULE_TREATMENT_AFTER_VALIDATION_TREATMENT, '', $this, array('result' => VALIDATION_OPTION_ACCEPT, 'lastvalidation' => true, 'module' => $polyModuleCodename, 'action' => 'delete'));
			}
			if ($this->_objectResourceStatus == 1 && $hardDelete) {
				//delete associated resource
				parent::destroy();
			}

			//Log action
			$log = new CMS_log();
			$language = $cms_user->getLanguage();
			$log->logMiscAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, 'Item \''.$this->getLabel().'\' ('.$objectDef->getLabel($language).')', $polyModuleCodename);

			if ($hardDelete) {
				$this->__destroy();
			}
			//Clear polymod cache
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $polyModuleCodename));
			CMS_cache::clearTypeCache('polymod');

			return true;
		} else {
			//change the article proposed location and send emails to all the validators
			if ($this->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user)) {
				parent::writeToPersistence();
				if (APPLICATION_ENFORCES_WORKFLOW) {
					if (!NO_APPLICATION_MAIL) {
						//get editors
						$editors = $this->getEditors();
						$editorsIds = array();
						foreach($editors as $editor) {
							$editorsIds[] = $editor->getUserId();
						}
						$validators = CMS_profile_usersCatalog::getValidators($polyModuleCodename);
						foreach ($validators as $validator) {
							//add script to send email for validator if needed
							CMS_scriptsManager::addScript($polyModuleCodename, array('task' => 'emailNotification', 'object' => $this->getID(), 'validator' => $validator->getUserId(), 'type' => 'delete', 'editors' => $editorsIds));
						}
						//then launch scripts execution
						CMS_scriptsManager::startScript();
					}
				} else {
					$validation = new CMS_resourceValidation($polyModuleCodename, RESOURCE_EDITION_LOCATION, $this);
					$mod = CMS_modulesCatalog::getByCodename($polyModuleCodename);
					$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
				}
				//Log action
				$log = new CMS_log();
				$language = $cms_user->getLanguage();
				$status = $this->getStatus();
				$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, $polyModuleCodename, $status, 'Item \''.$this->getLabel().'\' ('.$objectDef->getLabel($language).')', $this);

				//Clear polymod cache
				//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $polyModuleCodename));
				CMS_cache::clearTypeCache('polymod');

				return true;
			} else {
				return false;
			}
		}
	}

	/**
	  * Is this object deleted
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function isDeleted() {
		return CMS_modulePolymodValidation::isDeletedItem($this->getID());
	}

	/**
	  * Un-delete an object proposed for deletion (only for primary resource object type)
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function undelete() {
		if ($this->_objectResourceStatus != 1) {
			return false;
		}
		$this->removeProposedLocation();
		if (parent::writeToPersistence()) {
			global $cms_user;
			//get Object definition
			$objectDef = $this->getObjectDefinition();
			//get module codename
			$polyModuleCodename = $objectDef->getValue('module');

			//Log action
			$log = new CMS_log();
			$language = $cms_user->getLanguage();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNDELETE, $cms_user, $polyModuleCodename, $this->getStatus(), 'Item \''.$this->getLabel().'\' ('.$objectDef->getLabel($language).')', $this);
			return true;
		} else {
			return false;
		}
	}

	/**
	  * get all secondary resources ids attached to this primary resource
	  *
	  * @return array of secondary resource poly_object ids
	  * @access public
	  */
	function getAllSecondaryResourcesForPrimaryResource() {
		//here we check if this object is really a primary resource, cause secondary resources must be attached to a primary resource
		if ($this->_objectResourceStatus != 1) {
			$this->setError("This (id : ".$this->getID().") is not a primary resource.");
			return array();
		}
		$secondaryResourcesIds = array();
		foreach(array_keys($this->_objectValues) as $fieldID) {
			//if field is a poly_object or a multi_poly_object, check if it is a secondary resource
			if (is_a($this->_objectValues[$fieldID],'CMS_multi_poly_object')) {
				if ($this->_objectValues[$fieldID]->getObjectResourceStatus() == 2) {
					//then get objects ids
					$secondaryResourcesIds = array_merge($this->_objectValues[$fieldID]->getIDs(), $secondaryResourcesIds);
				}
			} elseif (is_a($this->_objectValues[$fieldID], 'CMS_poly_object')) {
				if ($this->_objectValues[$fieldID]->getObjectResourceStatus() == 2) {
					//then get object id
					if (sensitiveIO::isPositiveInteger($this->_polyObjectValues[$fieldID]->getValue())) {
						$secondaryResourcesIds[] = $this->_polyObjectValues[$fieldID]->getValue();
					}
				}
			}
		}
		return $secondaryResourcesIds;
	}

	/**
	  * Is this object currently in userspace
	  * return true if object is not deleted (for edited object)
	  * and if object is valided and in range of publications date (for public primary resource object)
	  *
	  * @param boolean $public : public userspace (else, it is edited userpsace) default : false
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function isInUserSpace() {
		if (!$this->_ID) {
			return false;
		}
		if ($this->isDeleted()) {
			return false;
		}
		if ($this->_objectResourceStatus == 1 && $this->_public) {
			if ($this->getPublication() != RESOURCE_PUBLICATION_PUBLIC) {
				return false;
			}
		}
		return true;
	}

	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		//
		// YOU MUST UPDATE getStructure() method of CMS_poly_object_definition accordingly !
		//
		$structure = array();
		$structure['id'] = '';
		$structure['label'] = '';
		$structure['fieldname'] = '';
		$structure['objectname'] = '';
		$structure['objectdescription'] = '';
		$structure['objecttype'] = '';
		$structure['fieldID'] = '';
		$structure['required'] = '';
		$structure['description'] = '';
		if($this->_objectResourceStatus == 1) {
			$structure['resource'] = '';
			$structure['formatedDateStart'] = '';
			$structure['formatedDateEnd'] = '';
			$structure['dateStartNotNull'] = '';
			$structure['dateStartTimestamp'] = '';
			$structure['dateEndNotNull'] = '';
			$structure['dateEndTimestamp'] = '';
		}
		return $structure;
	}

	/**
	  * get an object field
	  *
	  * @param integer $fieldID : the field to get. If empty, return an array of all objects values
	  * @return mixed : the object field or an array of the object fields
	  * @access public
	  */
	function objectValues($fieldID = '') {
		if (!$fieldID) {
			return $this->_objectValues;
		} else {
			if (!isset($this->_objectValues[$fieldID])) {
				global $cms_language;
				$language = $cms_language ? $cms_language : CMS_languagesCatalog::getDefaultLanguage();
				$this->setError('Object field with ID '.$fieldID.' does not exists as a field of object '.$this->getFieldLabel($language).' ('.$this->_objectID.') - '.io::getCallInfos(3));
				//return dummy object field (correct bug 536)
				return new CMS_poly_object($this->_objectID);
			}
			return $this->_objectValues[$fieldID];
		}
	}

	/**
	  * get an object value
	  *
	  * @param string $name : the name of the value to get
	  * @param string $parameters (optional) : parameters for the value to get
	  * @return mixed : the object values structure
	  * @access public
	  */
	function getValue($name, $parameters = '') {
		global $cms_language;
		// @TODOV4 : Manage language into database !
		$languages = array();
        $languages['fr'] = array(
            // French months
            'January'   => 'Janvier',
            'February'  => 'F&eacute;vrier',
            'March'     => 'Mars',
            'April'     => 'Avril',
            'May'       => 'Mai',
            'June'      => 'Juin',
            'July'      => 'Juillet',
            'August'    => 'Ao&ucirc;t',
            'September' => 'Septembre',
            'October'   => 'Octobre',
            'November'  => 'Novembre',
            'December'  => 'D&eacute;cembre',
            // French days
            'Monday'    => 'Lundi',
            'Tuesday'   => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday'  => 'Jeudi',
            'Friday'    => 'Vendredi',
            'Saturday'  => 'Samedi',
            'Sunday'    => 'Dimanche',
            // French shorts months
            'Jan'       => 'Jan',
            'Feb'       => 'F&eacute;v',
            'Mar'       => 'Mar',
            'Apr'       => 'Avr',
            'May'       => 'Mai',
            'Jun'       => 'Jui',
            'Jul'       => 'Jui',
            'Aug'       => 'Ao&ucirc;',
            'Sep'       => 'Sep',
            'Oct'       => 'Oct',
            'Nov'       => 'Nov',
            'Dec'       => 'D&eacute;c',
            // French shorts days
            'Mon'       => 'Lun',
            'Tue'       => 'Mar',
            'Wed'       => 'Mer',
            'Thu'       => 'Jeu',
            'Fri'       => 'Ven',
            'Sat'       => 'Sam',
            'Sun'       => 'Dim',
        );

		switch ($name) {
			case 'id':
				return (string) $this->_ID;
			break;
			case 'label':
				if ($parameters == 'js') {
					return sensitiveIO::sanitizeJSString($this->getLabel());
				} else {
					return $this->getLabel();
				}
			break;
			case 'objectname':
				return $this->getFieldLabel($cms_language);
			break;
			case 'objectdescription':
				return $this->getFieldDesc($cms_language);
			break;
			case 'objecttype':
				return $this->_objectID;
			break;
			case 'resource':
				if($this->_objectResourceStatus == 1) {
					return parent::getID();
				}
				return;
			break;
			case 'formatedDateStart':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateStart();
					if (io::strtolower($parameters) == 'rss') {
						$date = date('r', $date->getTimeStamp());
					} else {
						$date = date($parameters, $date->getTimeStamp());
						if (is_object($cms_language) && isset($languages[$cms_language->getCode()])) {
		                    $date = str_replace(array_keys($languages[$cms_language->getCode()]), $languages[$cms_language->getCode()], $date);
		                }
					}
					return io::htmlspecialchars($date);
				}
			break;
			case 'formatedDateEnd':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateEnd();
					if (is_a($date, 'CMS_date')) {
						if (io::strtolower($parameters) == 'rss') {
							$date = date('r', $date->getTimeStamp());
						} else {
							$date = date($parameters, $date->getTimeStamp());
							if (is_object($cms_language) && isset($languages[$cms_language->getCode()])) {
			                    $date = str_replace(array_keys($languages[$cms_language->getCode()]), $languages[$cms_language->getCode()], $date);
			                }
						}
						return io::htmlspecialchars($date);
					}
				}
			break;
			case 'dateStartNotNull':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateStart();
					return !$date->isNull();
				}
			break;
			case 'dateStartTimestamp':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateStart();
					return $date->getTimestamp();
				}
			break;
			case 'dateEndNotNull':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateEnd();
					return !$date->isNull();
				}
			break;
			case 'dateEndTimestamp':
				if($this->_objectResourceStatus == 1) {
					$date = parent::getPublicationDateEnd();
					return $date->getTimestamp();
				}
			break;
			//field related values, may not exists ...
			case 'fieldID':
				if (!is_a($this->_field, 'CMS_poly_object_field')) {
					$this->setError("Can't get 'fieldID' value for an object which is not a field of another object ...");
					return '';
				}
				return $this->_field->getID();
			break;
			case 'description':
				if (!is_a($this->_field, 'CMS_poly_object_field')) {
					$this->setError("Can't get 'description' value for an object which is not a field of another object ...");
					return '';
				}
				return io::htmlspecialchars($this->_field->getFieldDescription($cms_language));
				break;
			case 'required':
				if (!is_a($this->_field, 'CMS_poly_object_field')) {
					$this->setError("Can't get 'required' value for an object which is not a field of another object ...");
					return false;
				}
				return ($this->_field->getValue("required")) ? true : false;
			break;
			case 'fieldname':
				if (!is_a($this->_field, 'CMS_poly_object_field')) {
					$this->setError("Can't get 'fieldname' value for an object which is not a field of another object ...");
					return '';
				}
				//get label of current field
				$fieldLabel = new CMS_object_i18nm($this->_field->getValue("labelID"));
				return $fieldLabel->getValue($cms_language->getCode());
			break;
			default:
				$this->setError("Unknown value to get : ".$name);
				return false;
			break;
		}
	}

	/**
	  * For a given object type, return options tag list (for a select tag) of all objects labels
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	selected : the object id which is selected (optional)
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
	  * @return string : options tag list
	  * @access public
	  */
	function selectOptions($values, $tags) {
		$objectValues = CMS_poly_object_catalog::getListOfNamesForObject($this->_objectID, true);
		$return = "";
		if (is_array($objectValues) && $objectValues) {
			foreach ($objectValues as $objectID => $objectLabel) {
				$selected = ($objectID == $values['selected']) ? ' selected="selected"':'';
				$return .= '<option title="'.io::htmlspecialchars($objectLabel).'" value="'.$objectID.'"'.$selected.'>'.$objectLabel.'</option>';
			}
		}
		return $return;
	}

	/**
	  * For an object ID, set object
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	value : the object id which to be set
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
	  * @return void
	  * @access public
	  */
	function loadObject($values, $tags) {
		global $object;
		if (!sensitiveIO::isPositiveInteger($values['value'])) {
			$this->setError("Value parameter must be a valid category ID : ".$values['value']);
			return false;
		}
		$object[$this->_objectID] = new CMS_poly_object($this->_objectID, $values["value"], array(), true, true);
		return;
	}

	/**
	  * Return given RSS feed informations
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	selected : the selected rss ID
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag
	  * 	... {url} ... {label} ... {description} ...
	  * @return string : the RSS feed informations
	  * @access public
	  */
	function rss($values, $tags) {
		global $cms_language;
		if (!sensitiveIO::isPositiveInteger($values['selected'])) {
			$this->setError("Selected value parameter must be a valid RSS Feed ID : ".$values['selected']);
			return false;
		}
		$RSSDefinition = new CMS_poly_rss_definitions($values['selected']);
		if ($RSSDefinition->hasError()) {
			$this->setError("Selected value parameter must be a valid RSS Feed ID : ".$values['selected']);
			return false;
		}
		$linkParameters='';
		if (sizeof($values) > 1) {
			foreach ($values as $key => $value) {
				if ($key != 'selected') {
					$linkParameters .= '&amp;'.$key.'='.io::htmlspecialchars($value);
				}
			}
		}
		$replace = array(
			'{url}' => PATH_REALROOT_WR.'/rss/rss'.(!STRIP_PHP_EXTENSION ? '.php' : '').'?id='.$RSSDefinition->getID().$linkParameters,
			'{label}' => $RSSDefinition->getLabel($cms_language),
			'{description}' => $RSSDefinition->getDescription($cms_language),
		);
		$xml2Array = new CMS_xml2Array($tags);
		$return = $xml2Array->toXML($tags);
		$return = str_replace(array_keys($replace), $replace, $return);
		return $return;
	}

	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName = '') {
		$labels = array();
		$labels['structure']['id'] = $language->getMessage(self::MESSAGE_POLYOBJECT_ID_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['label'] = $language->getMessage(self::MESSAGE_POLYOBJECT_LABEL_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['objectname'] = $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECTNAME_DESCRIPTION,array($this->getFieldLabel($language)) ,MOD_POLYMOD_CODENAME);
		$labels['structure']['objectdescription'] = $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECTDESC_DESCRIPTION,array($this->getFieldDesc($language)) ,MOD_POLYMOD_CODENAME);
		$labels['structure']['objecttype'] = $language->getMessage(self::MESSAGE_POLYOBJECT_OBJECTTYPE_DESCRIPTION,array($this->_objectID) ,MOD_POLYMOD_CODENAME);
		if (is_a($this->_field, 'CMS_poly_object_field')) {
			$labels['structure']['fieldname'] = $language->getMessage(self::MESSAGE_POLYOBJECT_FIELDNAME_DESCRIPTION,array($this->getFieldLabel($language)),MOD_POLYMOD_CODENAME);
			$labels['structure']['required'] = $language->getMessage(self::MESSAGE_POLYOBJECT_REQUIRED_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
			$labels['structure']['fieldID'] = $language->getMessage(self::MESSAGE_POLYOBJECT_FIELDID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['description'] = $language->getMessage(self::MESSAGE_OBJECT_FIELD_DESC_DESCRIPTION,array($this->_field->getFieldDescription($language)),MOD_POLYMOD_CODENAME);
		}
		if($this->_objectResourceStatus == 1) {
			$labels['structure']['resource'] = $language->getMessage(self::MESSAGE_POLYOBJECT_RESOURCE_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
			$labels['structure']['formatedDateStart|format'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATESTART_FORMATEDVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['formatedDateEnd|format'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATEEND_FORMATEDVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);

			$labels['structure']['dateStartNotNull'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATE_HASVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['dateStartTimestamp'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATE_TIMESTAMP_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['dateEndNotNull'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATE_HASVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['dateEndTimestamp'] = $language->getMessage(self::MESSAGE_POLYOBJECT_DATE_TIMESTAMP_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		}
		$RRSDefinitions = CMS_poly_object_catalog::getAllRSSDefinitionsForObject($this->getObjectID());
		if (is_array($RRSDefinitions) && $RRSDefinitions) {
			$rssFeeds = '<ul>';
			foreach ($RRSDefinitions as $RRSDefinition) {
				$rssFeeds .= '<li><strong>'.$RRSDefinition->getID().'</strong> : '.$RRSDefinition->getLabel($language->getCode()).' ('.$RRSDefinition->getDescription($language->getCode()).')</li>';
			}
			$rssFeeds .= '</ul>';
			$labels['function']['rss'] = $language->getMessage(self::MESSAGE_POLYOBJECT_FUNCTION_RSS_DESCRIPTION,array('{'.$objectName.'}',$rssFeeds),MOD_POLYMOD_CODENAME);
		}
		$labels['function']['selectOptions'] = $language->getMessage(self::MESSAGE_POLYOBJECT_FUNCTION_SELECTOPTIONS_DESCRIPTION,array('{'.$objectName.'}'),MOD_POLYMOD_CODENAME);
		$labels['function']['loadObject'] = $language->getMessage(self::MESSAGE_POLYOBJECT_FUNCTION_LOADOBJECT_DESCRIPTION,array('{'.$objectName.'}'),MOD_POLYMOD_CODENAME);
		return $labels;
	}

	/**
	  * Get field search SQL request (used by class CMS_object_search)
	  *
	  * @param integer $fieldID : this field id in object
	  * @param mixed $value : the value to search
	  * @param string $operator : additionnal search operator
	  * @param string $where : where clauses to add to SQL
	  * @param boolean $public : values are public or edited ? (default is edited)
	  * @return string : the SQL request
	  * @access public
	  */
	function getFieldSearchSQL($fieldID, $value, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";
		$sql = "
		select
			distinct objectID
		from
			mod_subobject_integer".$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			and value ".(is_array($value) ? "in (".SensitiveIO::sanitizeSQLString(implode(',',$value)).")" : "= '".SensitiveIO::sanitizeSQLString($value)."'")."
			$where
		";
		return $sql;
	}

	/**
	  * Return a list of all objects names of given type
	  *
	  * @param boolean $public are the needed datas public ? (default false)
	  * @param array $searchConditions, search conditions to add. Format : array(conditionType => conditionValue)
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	function getListOfNamesForObject($public = false, $searchConditions = array()) {
		return CMS_poly_object_catalog::getListOfNamesForObject($this->_objectID, $public, $searchConditions);
	}

	/**
	  * Current object has passed the validation process
	  *
	  * @param integer : the validation status
	  * @return boolean
	  * @access public
	  * @static
	  */
	function afterValidation($validationResult) {
		$return = true;
		//check object fields for validation action
		foreach(array_keys($this->_objectValues) as $fieldID) {
			//if method_exists 'afterValidation', launch it
			if (method_exists($this->_objectValues[$fieldID],'afterValidation')) {
				$return = $return && $this->_objectValues[$fieldID]->afterValidation($validationResult, $this);
			}
		}
		return $return;
	}

	/**
	  * Module script task
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		object : string module codename for the task
	  *		field : string module uid
	  *		...	: optional field relative parameters
	  * @return Boolean true/false
	  * @access public
	  */
	function scriptTask($parameters) {
		//if script concern a field, pass to it
		if (isset($parameters['field']) && sensitiveIO::isPositiveInteger($parameters['field'])) {
			if (!is_object($this->_objectValues[$parameters['field']]) || !method_exists($this->_objectValues[$parameters['field']],'scriptTask')) {
				return false;
			}
			//then pass task to field
			return $this->_objectValues[$parameters['field']]->scriptTask($parameters);
		} else {
			//this is an object related script
			switch($parameters['task']) {
				case 'emailNotification':
					//instanciate user
					$user = CMS_profile_usersCatalog::getByID($parameters['validator']);
					if ($this->userHasClearance($user, CLEARANCE_MODULE_EDIT)) {
						//get Object definition
						$objectDef = $this->getObjectDefinition();
						//get module
						$codename = CMS_poly_object_catalog::getModuleCodenameForObjectType($objectDef->getID());
						switch($parameters['type']) {
							case 'validate':
								$group_email = new CMS_emailsCatalog();
								$languages = CMS_languagesCatalog::getAllLanguages();
								$subjects = array();
								$bodies = array();
								//editors
								$editorsIds = $parameters['editors'];
								$editors = array();
								foreach($editorsIds as $editorId) {
									$editor = CMS_profile_usersCatalog::getByID($editorId);
									if (is_a($editor, 'CMS_profile_user') && !$editor->hasError()) {
										$editors[] = $editor;
									}
								}
								//$editors = $this->getEditors();
								$editorsInfos = '';
								foreach($editors as $editor){
									$editorsInfos .= ($editorsInfos) ? ",\n" : '';
									$editorsInfos .= $editor->getFullName().($editor->getEmail() ? ' ('.$editor->getEmail().')' : '');
								}
								foreach ($languages as $language) {
									$subjects[$language->getCode()] = $language->getMessage(self::MESSAGE_POLYMOD_ACTION_EMAIL_SUBJECT, array($objectDef->getLabel($language)), MOD_POLYMOD_CODENAME);
									$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
											."\n".$language->getMessage(self::MESSAGE_POLYMOD_ACTION_EMAIL_BODY, array($objectDef->getLabel($language), $this->getLabel(), $editorsInfos), MOD_POLYMOD_CODENAME);
								}
								$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_VALIDATION, $codename);
								$group_email->sendMessages();
							break;
							case 'delete':
								$group_email = new CMS_emailsCatalog();
								$languages = CMS_languagesCatalog::getAllLanguages();
								$subjects = array();
								$bodies = array();
								//editors
								$editorsIds = $parameters['editors'];
								$editors = array();
								foreach($editorsIds as $editorId) {
									$editor = CMS_profile_usersCatalog::getByID($editorId);
									if (is_a($editor, 'CMS_profile_user') && !$editor->hasError()) {
										$editors[] = $editor;
									}
								}
								//$editors = $this->getEditors();
								$editorsInfos = '';
								foreach($editors as $editor){
									$editorsInfos .= ($editorsInfos) ? ",\n" : '';
									$editorsInfos .= $editor->getFullName().($editor->getEmail() ? ' ('.$editor->getEmail().')' : '');
								}
								foreach ($languages as $language) {
									$subjects[$language->getCode()] = $language->getMessage(self::MESSAGE_POLYMOD_ACTION_EMAIL_DELETE_SUBJECT, array($objectDef->getLabel($language)), MOD_POLYMOD_CODENAME);
									$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
											."\n".$language->getMessage(self::MESSAGE_POLYMOD_ACTION_EMAIL_DELETE_BODY, array($objectDef->getLabel($language), $this->getLabel(), $editorsInfos), MOD_POLYMOD_CODENAME);
								}
								$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_VALIDATION, $codename);
								$group_email->sendMessages();
							break;
							default:
								$this->setError('Unknown script task to do : '.print_r($parameters,true));
								return false;
							break;
						}
					}
					return true;
				break;
				default:
					$this->setError('Unknown script task to do : '.print_r($parameters,true));
					return false;
				break;
			}
		}
	}

	/**
	  * Module script info : get infos for a given script parameters
	  *
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		module : string module codename for the task
	  *		uid : string module uid
	  * @return string : HTML scripts infos
	  * @access public
	  */
	function scriptInfo($parameters) {
		if (isset($parameters['field']) && sensitiveIO::isPositiveInteger($parameters['field'])) {
			if (!is_object($this->_objectValues[$parameters['field']]) || !method_exists($this->_objectValues[$parameters['field']],'scriptInfo')) {
				return false;
			}
			//then pass query to field
			return $this->_objectValues[$parameters['field']]->scriptInfo($parameters);
		} else {
			//this is an object related script
			switch($parameters['task']) {
				case 'emailNotification':
					global $cms_language;
					if ($parameters['type'] == 'validate') {
						return $cms_language->getMessage(self::MESSAGE_OBJECT_VALIDATION_AWAIT_NOTIFICATION, false, MOD_POLYMOD_CODENAME);
					} elseif ($parameters['type'] == 'delete') {
						return $cms_language->getMessage(self::MESSAGE_OBJECT_DELETION_AWAIT_NOTIFICATION, false, MOD_POLYMOD_CODENAME);
					}
				break;
				default:
					$this->setError('Unknown script task to do : '.print_r($parameters,true));
					return false;
				break;
			}
		}
		return false;
	}

	/**
	  * Get field order SQL request (used by class CMS_object_search)
	  *
	  * @param integer $fieldID : this field id in object (aka $this->_field->getID())
	  * @param mixed $direction : the direction to search (asc/desc)
	  * @param string $operator : additionnal search operator
	  * @param string $where : where clauses to add to SQL
	  * @param boolean $public : values are public or edited ? (default is edited)
	  * @return string : the SQL request
	  * @access public
	  */
	function getFieldOrderSQL($fieldID, $direction, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";
		//operators are not supported for now : TODO
		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->setError("Unknown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		$sql = '';
		//choose table
		$fromTable = 'mod_subobject_integer';
		// create sql
		$sql = "
		select
			distinct objectID
		from
			".$fromTable.$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			$where
		order by value ".$direction;

		return $sql;
	}

	/**
	  * Does given user have the requested clearance for this object ?
	  * This method is pretty heavy, so if it must be used on a lots of objects, prefer usage of a search on those objects, it is much faster.
	  *
	  * @param cms_profile_user $user : the user to check clearance
	  * @param constant $clearance : the requested clearance to check (default : CLEARANCE_MODULE_VIEW)
	  * @param boolean $checkParent : if no categories fields found, check the parent object (if any) to see if it as some (beware this is heavy). Default : false
	  * @return boolean
	  * @access public
	  */
	function userHasClearance($user, $clearance = CLEARANCE_MODULE_VIEW, $checkParent = false) {
		if (!$this->_public || APPLICATION_ENFORCES_ACCESS_CONTROL === true){
			//user is an administrator?
			if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				return true;
			}
			//get Object definition
			$objectDef = $this->getObjectDefinition();
			//get module codename
			$polyModuleCodename = $objectDef->getValue('module');
			//check user right on module (check only minimum needed : VIEW, proper right is checked after on category)
			if (!$user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_VIEW)) {
				return false;
			}
			//object has categories fields ?
			$categoriesFields = CMS_poly_object_catalog::objectHasCategories($this->getObjectID());
			$allCategories = array();
			if (!$categoriesFields && !$checkParent) {
				//no categories on object so user has rights
				return true;
			} elseif (!$categoriesFields && $checkParent) {
				//check for module Categories usage
				if (!CMS_poly_object_catalog::moduleHasCategories($polyModuleCodename)) {
					//no categories used on module : item is viewvable
					return true;
				}
				//check for a parent for the given object
				if ($objectParentsIDs = CMS_poly_object_catalog::getParentsObject($this->getObjectID())) {
					$found = false;
					//check object for each parent objects found
					foreach ($objectParentsIDs as $objectParentID => $objectParentFields) {
						$categoriesFields = CMS_poly_object_catalog::objectHasCategories($objectParentID);
						if (is_array($categoriesFields) && $categoriesFields) {
							//load current object definition
							$object = CMS_poly_object_catalog::getObjectDefinition($objectParentID);
							foreach($objectParentFields as $fieldID) {
								$search = new CMS_object_search($object,$this->_public);
								$search->addWhereCondition($fieldID, $this->getID());
								$ids = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_IDS);
								$found = ($ids) ? true : $found;
							}
						}
					}
					//if one parent was found then object is visible
					return $found;
				} else {
					//no parent object for this object, item is viewvable
					return true;
				}
			} elseif (is_array($categoriesFields) && $categoriesFields) {
				$search = new CMS_object_search($objectDef,($clearance == CLEARANCE_MODULE_VIEW));
				$search->addWhereCondition('item', $this->getID());
				$search->addWhereCondition("profile", $user);
				$ids = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_IDS);
				return ($ids) ? true : false;
			}
		}
		//user has clearance
		return true;
	}
}
?>