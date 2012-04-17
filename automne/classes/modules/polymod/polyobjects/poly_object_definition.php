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
// $Id: poly_object_definition.php,v 1.5 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_poly_object_definition
  *
  * represent a poly object definition
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_object_definition extends CMS_grandFather
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_FIELD_YES = 1082;
	const MESSAGE_FIELD_NO = 1083;
	
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_PARAMETER_LOADSUBOBJECTS = 197;
	const MESSAGE_OBJECT_PARAMETER_LOADSUBOBJECTS_DESCRIPTION = 198;
	const MESSAGE_OBJECT_PARAMETER_SEARCHEDOBJECTS = 199;
	/**
	  * Integer ID
	  * @var integer
	  * @access private
	  */
	protected $_ID;
	
	/**
	  * all values for object
	  * @var array	("resourceUsage"		=> integer,
	  				 "labelID" 				=> integer,
					 "descriptionID"		=> integer,
					 "module"				=> string,
					 "composedLabel"		=> string,
					 "previewURL"			=> string,
					 "indexable"			=> integer,
					 "multilanguage"		=> integer,
					 "indexURL"				=> integer,
					 "compiledIndexURL"		=> string,
					 "resultsDefinition"	=> string)
	  * @access private
	  */
	protected $_objectValues = array("resourceUsage"=> 0,
		  							 "labelID" 		=> 0,
									 "descriptionID"=> 0,
									 "admineditable"=> 0,
						 			 "module" 		=> "",
									 "composedLabel"=> "",
									 "previewURL"	=> "",
									 "indexable" 	=> 0,
									 "multilanguage"=> 0,
									 "indexURL" 	=> "",
									 "compiledIndexURL"=> "",
									 "resultsDefinition"=> "",
									 "uuid"			=> ""
								 );
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'search',
										'required' 		=> false,
										'internalName'	=> 'searchedObjects',
										'externalName'	=> self::MESSAGE_OBJECT_PARAMETER_SEARCHEDOBJECTS,
									),
							 1 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'loadSubObjects',
										'externalName'	=> self::MESSAGE_OBJECT_PARAMETER_LOADSUBOBJECTS,
										'description'	=> self::MESSAGE_OBJECT_PARAMETER_LOADSUBOBJECTS_DESCRIPTION,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => array(), 1 => false);
	
	/**
	  * is parameter loaded ? (not automatic)
	  * @var boolean
	  * @access private
	  */
	protected $_parametersLoaded = false;
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $id DB id
	  * @param array $dbValues DB values
	  * @return void
	  * @access public
	  */
	function __construct($id = 0, $dbValues=array())
	{
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
					mod_object_definition
				where
					id_mod='".$id."'
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
			$this->_ID = isset($datas['id_mod']) ? (int) $datas['id_mod'] : 0;
			$this->_objectValues["labelID"] = isset($datas['label_id_mod']) ? (int) $datas['label_id_mod'] : 0;
			$this->_objectValues["descriptionID"] = isset($datas['description_id_mod']) ? (int) $datas['description_id_mod'] : 0;
			$this->_objectValues["resourceUsage"] = isset($datas['resource_usage_mod']) ? (int) $datas['resource_usage_mod'] : 0;
			$this->_objectValues["admineditable"] = isset($datas['admineditable_mod']) ? (int) $datas['admineditable_mod'] : 0;
			$this->_objectValues["module"] = isset($datas['module_mod']) ? $datas['module_mod'] : '';
			$this->_objectValues["composedLabel"] = isset($datas['composedLabel_mod']) ? $datas['composedLabel_mod'] : '';
			$this->_objectValues["previewURL"] = isset($datas['previewURL_mod']) ? $datas['previewURL_mod'] : '';
			$this->_objectValues["indexable"] = (isset($datas['indexable_mod']) && $datas['indexable_mod']) ? 1 : 0;
			$this->_objectValues["multilanguage"] = (isset($datas['multilanguage_mod']) && $datas['multilanguage_mod']) ? 1 : 0;
			$this->_objectValues["indexURL"] = isset($datas['indexURL_mod']) ? $datas['indexURL_mod'] : '';
			$this->_objectValues["compiledIndexURL"] = isset($datas['compiledIndexURL_mod']) ? $datas['compiledIndexURL_mod'] : '';
			$this->_objectValues["resultsDefinition"] = isset($datas['resultsDefinition_mod']) ? $datas['resultsDefinition_mod'] : '';
			$this->_objectValues["uuid"] = isset($datas['uuid_mod']) ? $datas['uuid_mod'] : '';
		}
	}
	
	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getID()
	{
		return $this->_ID;
	}
	
	/**
	  * Sets an object value.
	  *
	  * @param string $valueName the name of the value to set
	  * @param mixed $value the value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($valueName, $value)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->raiseError("Unknown valueName to set :".$valueName);
			return false;
		}
		if ($valueName == 'uuid') {
			$this->raiseError("Cannot change UUID");
			return false;
		}
		if ($valueName == 'indexURL') {
			$parsing = new CMS_polymod_definition_parsing($value, true, CMS_polymod_definition_parsing::CHECK_PARSING_MODE);
			$errors = $parsing->getParsingError();
			if ($errors) {
				return $errors;
			}
		}
		$this->_objectValues[$valueName] = $value;
		if ($valueName == 'indexURL') {
			$this->compileDefinition();
		}
		return true;
	}
	
	/**
	  * Sets a object uuid.
	  *
	  * @param string $uuid the object UUID
	  * @return void
	  * @access public
	  */
	function setUuid($uuid) {
		$this->_objectValues['uuid'] = $uuid;
	}
	
	/**
	  * Compile the indexURL definition
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function compileDefinition() {
		global $cms_language;
		$parameters = array();
		$parameters['module'] = $this->_objectValues["module"];
		$parameters['cache'] = false; //Do not cache this content
		$definitionParsing = new CMS_polymod_definition_parsing($this->_objectValues['indexURL'], true, CMS_polymod_definition_parsing::PARSE_MODE, $parameters['module']);
		$compiledIndexURL = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_PHP, $parameters);
		$this->_objectValues['compiledIndexURL'] = $compiledIndexURL;
		return true;
	}
	
	/**
	  * get an object value.
	  *
	  * @param string $valueName the name of the value to get
	  * @return mixed, the value
	  * @access public
	  */
	function getValue($valueName)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->raiseError("Unknown valueName to get :".$valueName);
			return false;
		}
		return $this->_objectValues[$valueName];
	}
	
	/**
	  * get object label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getLabel($language = '') {
		$label = new CMS_object_i18nm($this->getValue("labelID"));
		if ($language instanceof CMS_language) {
			return $label->getValue($language->getCode());
		} else {
			return $label->getValue($language);
		}
	}
	
	/**
	  * get object label (same as getLabel, for objects compatibility)
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getObjectLabel($language) {
		return $this->getLabel($language);
	}
	
	/**
	  * get object description
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for description
	  * @return string, the description
	  * @access public
	  */
	function getDescription($language) {
		$description = new CMS_object_i18nm($this->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			return $description->getValue($language->getCode());
		} else {
			return $description->getValue($language);
		}
	}
	
	/**
	  * get subfields parameters
	  *
	  * @return array(integer parameterID => array parameter) : the subfield parameters
	  * @access public
	  */
	function getSubFieldParameters () {
		if (!$this->_parametersLoaded) {
			$this->raiseError("Parameters must be loaded first (use loadParameters method)");
			return false;
		}
		return $this->_parameters;
	}
	
	/**
	  * has subfields parameters ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasParameters() {
		return $this->_parameters ? true:false;
	}
	
	/**
	  * load parameters from field
	  *
	  * @return boolean
	  * @access public
	  */
	function loadParameters(&$field) {
		//set $this->_parameterValues
		foreach ($this->_parameters as $parameterID => $parameter) {
			$param = $field->getParameter($parameter['internalName']);
			if (isset($param)) {
				$this->_parameterValues[$parameterID] = $param;
			}
		}
		$this->_parametersLoaded = true;
		return true;
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParameters($language, $prefixName) {
		if (!is_a($language,'CMS_language')) {
			$this->raiseError("Language must be a CMS_language object : ".print_r($language,true));
			return false;
		}
		if (!$this->_parametersLoaded) {
			$this->raiseError("Parameters must be loaded first (use loadParameters method)");
			return false;
		}
		$values = $this->_parameterValues;
		$html = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			switch ($parameter['type']) {
				case 'boolean':
					$yes = ($paramValue) ? ' selected="selected"':'';
					$input = '<select name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text">
						<option value="0">'.$language->getMessage(self::MESSAGE_FIELD_NO).'</option>
						<option value="1"'.$yes.'>'.$language->getMessage(self::MESSAGE_FIELD_YES).'</option>
					</select>';
				break;
				case 'integer':
				case 'date':
				case 'string':
					$input = '<input type="text" size="30" name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text" value="'.io::htmlspecialchars($paramValue).'" />';
				break;
				default:
					if ($parameter['type'] && method_exists($this, "getHTMLSubFieldsParameters".$parameter['type'])) {
						$method = "getHTMLSubFieldsParameters".$parameter['type'];
						$input = $this->$method($language, $prefixName);
					} else {
						$this->raiseError("Can't get parameter HTML for type : ".$parameter['type']);
						return false;
					}
				break;
			}
			if ($input) {
				$paramLabel = (sensitiveIO::isPositiveInteger($parameter['externalName'])) ? $language->getMessage($parameter['externalName'], false, MOD_POLYMOD_CODENAME):'Undefined';
				$paramDescription = (sensitiveIO::isPositiveInteger($parameter['description'])) ? '<br />'.$language->getMessage($parameter['description'], false, MOD_POLYMOD_CODENAME):'';
				$required = ($parameter['required']) ? '<span class="admin_text_alert">*</span>':'';
				$html .= '
				<tr>
					<td class="admin" align="right" valign="top">'.$required.$paramLabel.'</td>
					<td class="admin" valign="top">'.$input.$paramDescription.'</td>
				</tr>';
			}
		}
		
		$html = ($html) ? '<table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d;">'.$html.'</table>' : '';
		
		return $html;
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object search parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersSearch($language, $prefixName = '', $selectedValues = false, $disableSelected = false) {
		global $polymodCodename;
		
		$values = (!$selectedValues) ? $this->_parameterValues[0] : $selectedValues;
		
		$input = '';
		//load object fields
		$objectFields = CMS_poly_object_catalog::getFieldsDefinition($this->getID());
		//Add all subobjects or special fields (like categories) to search if any
		foreach ($objectFields as $fieldID => $field) {
			//check if field is searchable
			if ($field->getValue('searchable')) {
				//check if field has a method to provide a list of names
				$objectType = $field->getTypeObject();
				if (method_exists($objectType, 'getListOfNamesForObject')) {
					$objectsNames = $objectType->getListOfNamesForObject();
					if (is_array($objectsNames) && $objectsNames) {
						$s_object_listbox = CMS_moduleCategories_catalog::getListBox(
							array (
							'field_name' 		=> $prefixName.'searchedObjects['.$fieldID.']',	// Select field name to get value in
							'items_possible' 	=> $objectsNames,								// array of all categories availables: array(ID => label)
							'default_value' 	=> isset($values[$fieldID]) ? $values[$fieldID] : null,// Same format
							'attributes' 		=> 'class="admin_input_text" style="width:250px;"'
							)
						);
						$input .= '
						<tr>
							<td class="admin" align="right">'.$field->getLabel($language).'&nbsp;:</td>
							<td class="admin">'.$s_object_listbox.'</td>
						</tr>';
					}
				}
			}
		}
		$input = ($input) ? '<table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d;">'.$input.'</table>' : '';
		return $input;
	}
	
	/**
	  * treat all params then return array of values treated or false if error
	  *
	  * @param array $post the posted datas
	  * @param string $prefix the prefix for datas name
	  * @return array, the treated datas
	  * @access public
	  */
	function treatParams($post, $prefix) {
		$parameters = $this->_parameters;
		$treatedParams = array();
		foreach($parameters as $aParameter) {
			//string|boolean|integer|date|text
			$postedParamValue = $post[$prefix.$aParameter['internalName']];
			$paramType = $aParameter['type'];
			switch ($paramType) {
				case 'boolean':
					if (!isset($postedParamValue) && $aParameter['required']) {
						return false;
					}
					$params[$aParameter['internalName']] = ($postedParamValue) ? true:false;
				break;
				case 'integer':
					if (!is_numeric($postedParamValue)) {
						return false;
					}
					if (!$postedParamValue && $aParameter['required']) {
						return false;
					}
					$params[$aParameter['internalName']] = $postedParamValue;
				break;
				case 'date':
					//TODO
					if (!$postedParamValue && $aParameter['required']) {
						return false;
					}
					$params[$aParameter['internalName']] = $postedParamValue;
				break;
				case 'string':
				case "text":
				default:
				if (!$postedParamValue && $aParameter['required']) {
						return false;
					}
					$params[$aParameter['internalName']] = $postedParamValue;
				break;
			}
		}
		return $params;
	}
	
	/**
	  * get array of object parameters indexed with parameter internalName
	  *
	  * @return array(string internalName => mixed parameter value)
	  * @access public
	  */
	function getParamsValues() {
		if (!$this->_parametersLoaded) {
			$this->raiseError("Parameters must be loaded first (use loadParameters method)");
			return false;
		}
		$parameters = $this->getSubFieldParameters();
		$params = array();
		foreach($parameters as $parameterID => $parameter) {
			$params[$parameter['internalName']] = $this->_parameterValues[$parameterID];
		}
		return $params;
	}
	
	/**
	  * is this object a primary resource ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isPrimaryResource() {
		return ($this->getValue("resourceUsage") == 1) ? true:false;
	}
	
	/**
	  * is this object a secondary resource ?
	  * Note : even if this object is declared as a secondary resource, object must be directly attached to a primary resource,
	  * else it is not a secondary resource
	  *
	  * @param boolean $dontCheckForPrimaryResourceAttachment : do not check for a primary resource attachement, consider it is already checked somewhere else.
	  * @return boolean
	  * @access public
	  */
	function isSecondaryResource($dontCheckForPrimaryResourceAttachment = false) {
		if ($dontCheckForPrimaryResourceAttachment) {
			return ($this->getValue("resourceUsage") == 2) ? true:false;
		}
		if ($this->getValue("resourceUsage") != 2) {
			return false;
		} else {
			//check for objects which use this one to see if one of them is a primary resource
			$objectsWhichUseObject = CMS_poly_object_catalog::getObjectUsage($this->getID(), true);
			if (!$objectsWhichUseObject) {
				return false;
			}
			foreach ($objectsWhichUseObject as $anObjectWhichUseObject) {
				if ($anObjectWhichUseObject->isPrimaryResource()) {
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	  * is this object use categories ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasCategories() {
		return CMS_poly_object_catalog::objectHasCategories($this->getID());
	}
	
	/**
	  * Writes object into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if (!$this->_objectValues["uuid"]) {
			$this->_objectValues["uuid"] = io::uuid();
		}
		//save data
		$sql_fields = "
			resource_usage_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["resourceUsage"])."',
			label_id_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["labelID"])."',
			description_id_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["descriptionID"])."',
			admineditable_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["admineditable"])."',
			module_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["module"])."',
			composedLabel_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["composedLabel"])."',
			previewURL_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["previewURL"])."',
			indexable_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["indexable"])."',
			multilanguage_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["multilanguage"])."',
			indexURL_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["indexURL"])."',
			compiledIndexURL_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["compiledIndexURL"])."',
			resultsDefinition_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["resultsDefinition"])."',
			uuid_mod='".SensitiveIO::sanitizeSQLString($this->_objectValues["uuid"])."'
		";
		if ($this->_ID) {
			$sql = "
				update
					mod_object_definition
				set
					".$sql_fields."
				where
					id_mod='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					mod_object_definition
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Can't save object");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}
		
		//Clear polymod cache
		//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_objectValues["module"]));
		CMS_cache::clearTypeCache('polymod');
		
		//unset polymod structure in cache
		CMS_cache::clearTypeCache('atm-polymod-structure');
		return true;
	}
	
	/**
	  * Destroy this object in DB
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy() {
		if ($this->_ID) {
			//first delete old polyobject references
			$sql = "
				delete from
					mod_object_polyobjects
				where
					object_type_id_moo = '".$this->_ID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->raiseError("Can't delete datas of table mod_object_polyobjects for object : ".$this->_ID);
				return false;
			}
			
			//second delete object label and description
			if (sensitiveIO::IsPositiveInteger($this->getValue("labelID"))) {
				$label = new CMS_object_i18nm($this->getValue("labelID"));
				$label->destroy();
			}
			if (sensitiveIO::IsPositiveInteger($this->getValue("descriptionID"))) {
				$description = new CMS_object_i18nm($this->getValue("labelID"));
				$description->destroy();
			}
			
			//third, delete object definition datas
			$sql = "
				delete from
					mod_object_definition
				where
					id_mod = '".$this->_ID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->raiseError("Can't delete datas of table mod_object_definition for object : ".$this->_ID);
				return false;
			}
			//unset objects catalog in cache
			CMS_cache::clearTypeCacheByMetas('atm-polymod-structure', array('type' => 'object'));
			
			//Clear polymod cache
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_objectValues["module"]));
			CMS_cache::clearTypeCache('polymod');
			
		}
		unset($this);
		return true;
	}
	
	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
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
		if($this->_objectValues["resourceUsage"] == 1) {
			$structure['resource'] = '';
			$structure['formatedDateStart'] = '';
			$structure['formatedDateEnd'] = '';
		}
		return $structure;
	}
	
	/**
	  * Get object as an array structure used for export
	  *
	  * @param array $params The export parameters. Not used here
	  * @param array $files The reference to the found files used by object
	  * @return array : the object array structure
	  * @access public
	  */
	public function asArray($params = array(), &$files) {
		$oPolymod = new CMS_polymod($this->_objectValues['module']);
		$aClass = array(
			'id'			=> $this->getID(),
			'uuid'			=> $this->getValue('uuid'),
			'labels'		=> CMS_object_i18nm::getValues($this->_objectValues['labelID']),
			'descriptions'	=> CMS_object_i18nm::getValues($this->_objectValues['descriptionID']),
			'params'		=> array(
				'resourceUsage'		=> $this->_objectValues['resourceUsage'],
				'admineditable'		=> $this->_objectValues['admineditable'],
				'composedLabel'		=> $this->_objectValues['composedLabel'],
				'previewURL'		=> $this->_objectValues['previewURL'],
				'indexable'			=> $this->_objectValues['indexable'],
				'multilanguage'		=> $this->_objectValues['multilanguage'],
				'indexURL'			=> $this->_objectValues['indexURL'],
				'resultsDefinition'	=> $this->_objectValues['resultsDefinition'],
			),
			'fields'	=> array()
		);
		if ($aClass['params']['composedLabel']) {
			$aClass['params']['composedLabel'] = $oPolymod->convertDefinitionString($aClass['params']['composedLabel'], true);
		}
		if ($aClass['params']['indexURL']) {
			$aClass['params']['indexURL'] = $oPolymod->convertDefinitionString($aClass['params']['indexURL'], true);
		}
		if ($aClass['params']['previewURL']) {
			$aClass['params']['previewURL'] = $oPolymod->convertDefinitionString($aClass['params']['previewURL'], true);
		}
		if ($aClass['params']['resultsDefinition']) {
			$aClass['params']['resultsDefinition'] = $oPolymod->convertDefinitionString($aClass['params']['resultsDefinition'], true);
		}

		$oQuery = new CMS_query('
			SELECT `id_mof`
			FROM `mod_object_field`
			WHERE `object_id_mof` = '.$this->_ID.'
		');
		if ($oQuery->getNumRows()) {
			foreach ($oQuery->getAll(PDO::FETCH_ASSOC) as $aRow) {
				$oFieldDefiniton = new CMS_poly_object_field($aRow['id_mof']);
				$aClass['fields'][] = $oFieldDefiniton->asArray($params, $files);
			}
		}

		return $aClass;
	}
	
	/**
	  * Import object from given array datas
	  *
	  * @param array $data The object datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				module	=> false|true : the module to create object (required)
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
	function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for object importation ...'."\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for object importation : '.$params['module']."\n";
			return false;
		}
		if (!$this->getID() && CMS_poly_object_catalog::objectUuidExists($data['uuid'])) {
			//check imported uuid. If objects does not have an Id, the uuid must be unique or must be regenerated
			$uuid = io::uuid();
			//store old uuid relation
			$idsRelation['objects-uuid'][$data['uuid']] = $uuid;
			$data['uuid'] = $uuid;
		}
		//set object uuid if not exists
		if (!$this->_objectValues["uuid"]) {
			$this->_objectValues["uuid"] = $data['uuid'];
		}
		if (isset($data['labels'])) {
			$label = new CMS_object_i18nm($this->getValue("labelID"));
			$label->setValues($data['labels']);
			$label->writeToPersistence();
			$this->setValue("labelID", $label->getID());
		}
		if (isset($data['descriptions'])) {
			$description = new CMS_object_i18nm($this->getValue("descriptionID"));
			$description->setValues($data['descriptions']);
			$description->writeToPersistence();
			$this->setValue("descriptionID", $description->getID());
		}
		if (isset($data['params']['resourceUsage'])) {
			$this->setValue("resourceUsage", $data['params']['resourceUsage']);
		}
		if (isset($data['params']['admineditable'])) {
			$this->setValue("admineditable", $data['params']['admineditable']);
		}
		if (isset($data['params']['indexable'])) {
			$this->setValue("indexable", $data['params']['indexable']);
		}
		if (isset($data['params']['multilanguage'])) {
			$this->setValue("multilanguage", $data['params']['multilanguage']);
		}
		if (isset($data['params']['composedLabel'])) {
			$this->setValue("composedLabel", $module->convertDefinitionString($data['params']['composedLabel'], false));
		}
		if (isset($data['params']['previewURL'])) {
			$this->setValue("previewURL", $module->convertDefinitionString($data['params']['previewURL'], false));
		}
		if (isset($data['params']['indexURL'])) {
			$this->setValue("indexURL", $module->convertDefinitionString($data['params']['indexURL'], false));
		}
		if (isset($data['params']['resultsDefinition'])) {
			$this->setValue("resultsDefinition", $module->convertDefinitionString($data['params']['resultsDefinition'], false));
		}
		//write object
		if (!$this->writeToPersistence()) {
			$infos .= 'Error : can not write object ...'."\n";
			return false;
		}
		//if current object id has changed from imported id, set relation
		if (isset($data['id']) && $data['id'] && $this->getID() != $data['id']) {
			$idsRelation['objects'][$data['id']] = $this->getID();
		}
		//set this object into definition to convert array so it can be converted again at end of import process
		$idsRelation['definitionToConvert'][] = $this;
		
		$return = true;
		//object fields
		if (isset($data['fields'])) {
			foreach ($data['fields'] as $fieldDatas) {
				$importType = '';
				if (isset($fieldDatas['type'])) {
					if (isset($fieldDatas['uuid'])
						 && ($id = CMS_poly_object_catalog::fieldExists($params['module'], $fieldDatas['uuid']))) {
						//field already exist : load it if we can update it
						if (!isset($params['update']) || $params['update'] == true) {
							$field = new CMS_poly_object_field($id);
							$importType = ' (Update)';
						}
					} else {
						//create new field if we can
						if (!isset($params['create']) || $params['create'] == true) {
							$field = new CMS_poly_object_field();
							$importType = ' (Creation)';
						}
					}
					if (isset($field)) {
						if ($field->fromArray($fieldDatas, $params, $cms_language, $idsRelation, $infos)) {
							$return &= true;
							$infos .= 'Field "'.$field->getLabel($cms_language).'" successfully imported'.$importType."\n";
						} else {
							$return = false;
							$infos .= 'Error during import of field ...'.$importType."\n";
						}
					}
				} else {
					$return = false;
					$infos .= 'Error during import of field : missing type'."\n";
				}
			}
		}
		//object rss feeds
		if (isset($data['rss'])) {
			foreach ($data['rss'] as $rssDatas) {
				$importType = '';
				if (isset($rssDatas['uuid'])
					 && ($id = CMS_poly_object_catalog::rssExists($params['module'], $rssDatas['uuid']))) {
					//rss already exist : load it if we can update it
					if (!isset($params['update']) || $params['update'] == true) {
						$rss = new CMS_poly_rss_definitions($id);
						$importType = ' (Update)';
					}
				} else {
					//create new rss if we can
					if (!isset($params['create']) || $params['create'] == true) {
						$rss = new CMS_poly_rss_definitions();
						$importType = ' (Creation)';
					}
				}
				if (isset($rss)) {
					if ($rss->fromArray($rssDatas, $params, $cms_language, $idsRelation, $infos)) {
						$return &= true;
						$infos .= 'RSS feed "'.$rss->getLabel($cms_language).'" successfully imported'.$importType."\n";
					} else {
						$return = false;
						$infos .= 'Error during import of rss feed ...'.$importType."\n";
					}
				}
			}
		}
		//plugins wysiwyg
		if (isset($data['plugins'])) {
			foreach ($data['plugins'] as $pluginDatas) {
				$importType = '';
				if (isset($pluginDatas['uuid'])
					 && ($id = CMS_poly_object_catalog::pluginExists($params['module'], $pluginDatas['uuid']))) {
					//plugin already exist : load it if we can update it
					if (!isset($params['update']) || $params['update'] == true) {
						$plugin = new CMS_poly_plugin_definitions($id);
						$importType = ' (Update)';
					}
				} else {
					//create new plugin if we can
					if (!isset($params['create']) || $params['create'] == true) {
						$plugin = new CMS_poly_plugin_definitions();
						$importType = ' (Creation)';
					}
				}
				if (isset($plugin)) {
					if ($plugin->fromArray($pluginDatas, $params, $cms_language, $idsRelation, $infos)) {
						$return &= true;
						$infos .= 'Plugin Wysiwyg "'.$plugin->getLabel($cms_language).'" successfully imported'.$importType."\n";
					} else {
						$return = false;
						$infos .= 'Error during import of plugin wysiwyg ...'.$importType."\n";
					}
				}
			}
		}
		return $return;
	}
	
	/**
	  * Convert all definitions used by this object from human format to Automne format.
	  * This method is usually used at end of module import process, when all objects are imported
	  *
	  * @param CMS_module $module The current object module
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	function convertDefinitions($module) {
		$this->setValue("composedLabel", $module->convertDefinitionString($this->getValue("composedLabel"), false, true));
		$this->setValue("previewURL", $module->convertDefinitionString($this->getValue("previewURL"), false, true));
		$this->setValue("indexURL", $module->convertDefinitionString($this->getValue("indexURL"), false, true));
		$this->setValue("resultsDefinition", $module->convertDefinitionString($this->getValue("resultsDefinition"), false, true));
		return $this->writeToPersistence();
	}
}
?>