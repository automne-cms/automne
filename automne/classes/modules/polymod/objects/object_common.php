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
// $Id: object_common.php,v 1.11 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_object_common
  *
  * represent common methods for CMS_object_{type}
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

abstract class CMS_object_common extends CMS_grandFather
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_FIELD_YES = 1082;
	const MESSAGE_FIELD_NO = 1083;

	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_COMMON_LABEL_DESCRIPTION = 117;
	const MESSAGE_OBJECT_COMMON_FIELDNAME_DESCRIPTION = 118;
	const MESSAGE_OBJECT_COMMON_FIELDID_DESCRIPTION = 119;
	const MESSAGE_OBJECT_COMMON_VALUE_DESCRIPTION = 120;
	const MESSAGE_UNKNOWN_OBJECT_LABEL = 1249;
	const MESSAGE_UNKNOWN_OBJECT_DESCRIPTION = 1250;
	const MESSAGE_OBJECT_COMMON_REQUIRED_DESCRIPTION = 366;
	const MESSAGE_OBJECT_COMMON_FIELD_DESC_DESCRIPTION = 402;

	/**
	  * CMS_object_field reference
	  * @var CMS_object_field
	  * @access private
	  */
	protected $_field;
	
	/**
	  * from which module, fields messages should be get ?
	  * @var constant
	  * @access private
	  */
	protected $_messagesModule = MOD_POLYMOD_CODENAME;

	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_UNKNOWN_OBJECT_LABEL;

	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_UNKNOWN_OBJECT_DESCRIPTION;

	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, "isParameter" => boolean))
	  * @access private
	  */
	protected $_subfields = array();

	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array();

	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array();

	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array();

	/**
	  * Public or edited datas
	  * @var boolean
	  * @access private
	  */
	protected $_public;

	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param array $datas DB object values : array(integer "subFieldID" => mixed)
	  * @param CMS_object_field reference
	  * @param boolean $public values are public or edited ? (default is edited)
	  * @return void
	  * @access public
	  */
	function __construct($datas=array(), &$field, $public=false)
	{
		//check object defined internal vars
		if (sizeof($this->_subfields) != sizeof($this->_subfieldValues)) {
			$this->raiseError('Object internal vars hasn\'t the same count of subfields, check $_subfields, $_subfieldValues.');
			return;
		}
		if (!is_array($datas)) {
			$this->raiseError("Datas need to be an array : ".print_r($datas,true));
			return;
		}
		//Set public values
		$this->_public = $public;
		//set $this->_field
		$this->_field = &$field;
		//set $this->_subfieldValues
		foreach ($this->_subfields as $subFieldID => $subField) {
			if (is_array($this->_subfields[$subFieldID])) {
				//load subobject
				$subFieldValue = isset($datas[$subFieldID]) ? $datas[$subFieldID] : null;
				$objectName = 'CMS_subobject_'.$this->_subfields[$subFieldID]['type'];
				$this->_subfieldValues[$subFieldID] = new $objectName(0,array(),$subFieldValue,$this->_public);
			}
		}
		//set $this->_parameterValues
		if (is_object($field)) {
			foreach ($this->_parameters as $parameterID => $parameter) {
				$param = $field->getParameter($parameter['internalName']);
				if (isset($param)) {
					$this->_parameterValues[$parameterID] = $param;
				}
			}
		}
	}

	/**
      * Return only html parameters serialized as string
      *
      * @param array $values : parameters
      * @return string : the serialized parameters
      * @access public
	  * @static
      */
	function serializeHTMLParameters($inputParams) {
		$htmlParameters = '';		
		if(is_array($inputParams)){
		    foreach ($inputParams as $k => $v) {
			    if (in_array($k, array('id','class','cols','size','rows','style','tabindex','disabled','dir','lang','width','height','onchange',))) {
				    $htmlParameters .= ' '.$k.'="'.$v.'"';
			    }
		    }
		}
		return $htmlParameters;
	}

	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @param integer $fieldID, the current field id (only for poly object compatibility)
	  * @param CMS_language $language, the current admin language
	  * @param string prefixname : the prefix to use for post names
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLAdmin($fieldID, $language, $prefixName) {
		//is this field mandatory ?
		$mandatory = $this->_field->getValue('required') ? '<span class="atm-red">*</span> ' : '';
		$desc = $this->getFieldDescription($language);
		if (POLYMOD_DEBUG) {
			$values = array();
			foreach (array_keys($this->_subfieldValues) as $subFieldID) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					$values[$subFieldID] = sensitiveIO::ellipsis(strip_tags($this->_subfieldValues[$subFieldID]->getValue()), 50);
				}
			}
			$desc .= $desc ? '<br />' : '';
			$desc .= '<span class="atm-red">Field : '.$fieldID.' - Value(s) : <ul>';
			foreach ($values as $subFieldID => $value) {
				$desc .= '<li>'.$subFieldID.'&nbsp;:&nbsp;'.$value.'</li>';
			}
			$desc .= '</ul></span>';
		}
		
		$label = $desc ? '<span class="atm-help" ext:qtip="'.io::htmlspecialchars($desc).'">'.$mandatory.$this->getFieldLabel($language).'</span>' : $mandatory.$this->getFieldLabel($language);
		$return = array();
		
		
		if (sizeof($this->_subfields) === 1) {
			$return = array(
				'allowBlank'	=>	!$this->_field->getValue('required'),
				'fieldLabel' 	=>	$label,
				'xtype'			=>	'textfield',
				'name'			=>	'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]',
				'value'			=>	($this->_subfieldValues[0]->getValue() ? sensitiveIO::decodeEntities($this->_subfieldValues[0]->getValue()) : ''),
			);
		} else {
			$fields = array();
			foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					$fields[] = array(
						'hideLabel' 	=>	true,
						'xtype'			=>	'textfield',
						'name'			=>	'polymodFieldsValue['.$prefixName.$this->_field->getID().'_'.$subFieldID.']',
						'value'			=>	($this->_subfieldValues[$subFieldID]->getValue() ? sensitiveIO::decodeEntities($this->_subfieldValues[$subFieldID]->getValue()) : ''),
					);
				}
			}
			$return = array(
				'title' 		=>	$label,
				'xtype'			=>	'fieldset',
				'autoHeight'	=>	true,
				'defaultType'	=>	'textfield',
				'defaults'		=> 	array(
					'anchor'		=>	'97%',
					'allowBlank'	=>	!$this->_field->getValue('required')
				),
				'items'			=>	$fields
			);
		}
		return $return;
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
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
			unset($inputParams['prefix']);
		} else {
			$prefixName = '';
		}
		//serialize all htmlparameters
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$html = '';
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				//create fieldname
				$fieldName = $prefixName.$this->_field->getID().'_'.$subFieldID;
				//append field id to html field parameters (if not already exists)
				$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_'.$subFieldID.'"' : '';
				//create field value
				$value = $this->_subfieldValues[$subFieldID]->getValue();
				//then create field HTML
				$html .= ($html) ? '<br />':'';
				$html .= '<input type="text"'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_'.$subFieldID.'" value="'.$value.'" />'."\n";
				if (POLYMOD_DEBUG) {
					$html .= ' <span class="admin_text_alert">(Field : '.$this->_field->getID().' - SubField : '.$subFieldID.')</span>';
				}
			}
		}
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
	}

	/**
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName, $newFormat = false) {
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				//if no value set for it, return false
				if (!$this->_subfieldValues[$subFieldID]->setValue(@$values[$prefixName.$this->_field->getID().'_'.$subFieldID])) {
					return false;
				}
			}
		}
		return true;
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
	function checkMandatory($values, $prefixName, $newFormat = false) {
		//if field is required check values
		if ($this->_field->getValue('required')) {
			//check each subfield values
			foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					//if no value set for it, return false
					if (!isset($values[$prefixName.$this->_field->getID().'_'.$subFieldID]) || !$values[$prefixName.$this->_field->getID().'_'.$subFieldID]) {
						return false;
					}
				}
			}
		}
		return true;
	}

	/**
	  * get object label : by default, the first subField value (used to designate this object in lists)
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		if (!is_object($this->_subfieldValues[0])) {
			$this->raiseError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		return $this->_subfieldValues[0]->getValue();
	}

	/**
	  * get admin object label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getObjectLabel($language) {
		if (is_a($language, "CMS_language")) {
			return $language->getMessage($this->_objectLabel, false, $this->_messagesModule);
		} else {
			$tmplanguage = new CMS_language($language);
			return $tmplanguage->getMessage($this->_objectLabel, false, $this->_messagesModule);
		}
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
	  * get admin field label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getFieldLabel($language) {
		//get label of current field
		$label = new CMS_object_i18nm($this->_field->getValue("labelID"));
		if (is_a($language, "CMS_language")) {
			return $label->getValue($language->getCode());
		} else {
			return $label->getValue($language);
		}
	}

	/**
	  * get admin field description if any
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label or false if none defined
	  * @access public
	  */
	function getFieldDescription($language) {
		if (!sensitiveIO::isPositiveInteger($this->_field->getValue("descriptionID"))) {
			return false;
		}
		//get label of current field
		$description = new CMS_object_i18nm($this->_field->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			return $description->getValue($language->getCode());
		} else {
			return $description->getValue($language);
		}
	}

	/**
	  * get admin object description
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for description
	  * @return string, the description
	  * @access public
	  */
	function getDescription($language) {
		if (is_a($language, "CMS_language")) {
			return $language->getMessage($this->_objectDescription, false, $this->_messagesModule);
		} else {
			$tmplanguage = new CMS_language($language);
			return $tmplanguage->getMessage($this->_objectDescription, false, $this->_messagesModule);
		}
	}

	/**
	  * get subfields parameters
	  *
	  * @return array(integer parameterID => array parameter) : the subfield parameters
	  * @access public
	  */
	function getSubFieldParameters () {
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
				case 'text':
					$input = '<textarea cols="70" rows="4" name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text">'.io::htmlspecialchars($paramValue).'</textarea>';
				break;
				case 'fields':
					//get all fields for current object
					$fields = CMS_poly_object_catalog::getFieldsDefinition($this->_field->getValue('objectID'));
					$selectValues = array();
					foreach ($fields as $field) {
						$label = new CMS_object_i18nm($field->getValue("labelID"));
						$selectValues[$field->getID()] = $label->getValue($language->getCode());
					}
					$selectedValues = explode(';', $paramValue);
					$listboxesParameters = array (
						'field_name' 		=> $prefixName.$parameter['internalName'],	// Hidden field name to get value in
						'items_possible' 	=> $selectValues,			// array of all categories availables: array(ID => label)
						'items_selected' 	=> $selectedValues,		// array of selected ids
						'select_width' 		=> '300px',					// Width of selects, default 200px
						'select_height' 	=> '200px',					// Height of selects, default 140px
						'form_name' 		=> 'frm'				// Javascript form name
					);
					$input = CMS_dialog_listboxes::getListBoxes($listboxesParameters);
				break;
				default:
					if ($parameter['type'] && method_exists($this, "getHTMLSubFieldsParameters".$parameter['type'])) {
						$method = "getHTMLSubFieldsParameters".$parameter['type'];
						$input = $this->$method($language, $prefixName, $parameter);
					} else {
						$this->raiseError("Can't get parameter HTML for type : ".$parameter['type']);
						return false;
					}
				break;
			}
			if ($input) {
				$paramLabel = (sensitiveIO::isPositiveInteger($parameter['externalName'])) ? $language->getMessage($parameter['externalName'], false, $this->_messagesModule):'Undefined';
				$paramDescription = (isset($parameter['description']) && sensitiveIO::isPositiveInteger($parameter['description'])) ? '<br /><small>'.$language->getMessage($parameter['description'], false, $this->_messagesModule).'</small>':'';
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
	  * treat all params then return array of values treated or false if error
	  *
	  * @param array $post the posted datas
	  * @param string $prefix the prefix for datas name
	  * @return array, the treated datas
	  * @access public
	  */
	function treatParams($post, $prefix) {
		$parameters = $this->getSubFieldParameters();
		$treatedParams = array();
		foreach($parameters as $aParameter) {
			//string|boolean|integer|date|text
			$postedParamValue = isset($post[$prefix.$aParameter['internalName']]) ? $post[$prefix.$aParameter['internalName']] : null;
			$paramType = $aParameter['type'];
			if (!is_null($postedParamValue)) {
				switch ($paramType) {
					case 'boolean':
						$params[$aParameter['internalName']] = ($postedParamValue) ? true:false;
					break;
					case 'integer':
						if (($aParameter['required'] || $postedParamValue) && !ctype_digit($postedParamValue)) {
							return false;
						}
						$params[$aParameter['internalName']] = $postedParamValue;
					break;
					case 'date':
						$params[$aParameter['internalName']] = $postedParamValue;
					break;
					case 'string':
					case "text":
					default:
						$params[$aParameter['internalName']] = $postedParamValue;
					break;
				}
			} else {
				$params[$aParameter['internalName']] = null;
				if ($aParameter['required']) {
					return false;
				}
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
		$parameters = $this->getSubFieldParameters();
		$params = array();
		foreach($parameters as $parameterID => $parameter) {
			$params[$parameter['internalName']] = $this->_parameterValues[$parameterID];
		}
		return $params;
	}

	/**
      * Set a parameter value (this value is not saved, it is only changed for the current object instance)
      *
      * @param string $paramName : the parameter name to get value of
      * @param string $value : the parameter value to set
      * @return boolean : true on success, false on failure
      * @access public
      */
	function setParamValue($name,$value) {
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			if($parameter['internalName']==$name) {
				$this->_parameterValues[$parameterID]=$value;
			}
		}
		return true;
	}

	/**
	  * Get a parameter value
	  *
	  * @param string $paramName : the parameter name to get value of
	  * @return mixed : the parameter value or null if it does not exists
	  * @access public
	  */
	function getParamValue($paramName) {
		return (isset($this->_parameters[$paramName])) ? $this->_parameters[$paramName] : null;
	}

	/**
	  * Get subfields definition for current object
	  *
	  * @param integer (can be null) $objectID the object ID who requests these infos
	  * @return array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @access public
	  */
	function getSubFieldsDefinition($objectID) {
		$subFieldsDefinition=array();
		foreach($this->_subfields as $subFieldID => $subFieldDefinition) {
			$subFieldsDefinition[$subFieldID] = array(	'type' 		=> $subFieldDefinition['type'],
														'objectID'	=> $objectID,
														'fieldID'	=> $this->_field->getID(),
														'subFieldID'=> $subFieldID,
													);
		}
		return $subFieldsDefinition;
	}

	/**
	  * Set subfields definition for current object
	  *
	  * @param $subFieldsDefinition array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setSubFieldsDefinition($subFieldsDefinition) {
		foreach($this->_subfieldValues as $subFieldID => $subFieldObject) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				$this->_subfieldValues[$subFieldID]->setDefinition($subFieldsDefinition[$subFieldID]);
			}
		}
		return true;
	}

	/**
	  * Writes all subobjects into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence() {
		if ($this->_public) {
			$this->raiseError("Can't write public object");
			return false;
		}
		$ok = true;
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			if (is_object($this->_subfieldValues[$subFieldID]) && $ok) {
				$ok = ($this->_subfieldValues[$subFieldID]->writeToPersistence()) ? $ok:false;
			}
		}
		return $ok;
	}

	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = array();
		$structure['label'] = '';
		$structure['fieldname'] = '';
		$structure['fieldID'] = '';
		$structure['value'] = '';
		$structure['required'] = '';
		$structure['description'] = '';
		//$structure['objectclass'] = '';
		return $structure;
	}

	/**
	  * get an object value
	  *
	  * @param string $name : the name of the value to get
	  * @param string $parameters (optional) : parameters for the value to get
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getValue($name, $parameters = '') {
		global $cms_language;
		switch($name) {
			case 'label':
				return io::htmlspecialchars($this->getLabel());
			break;
			case 'fieldname':
				return io::htmlspecialchars($this->getFieldLabel($cms_language));
			break;
			case 'value':
				return (is_object($this->_subfieldValues[0])) ? io::htmlspecialchars($this->_subfieldValues[0]->getValue()) : '';
			break;
			case 'set':
				return $this->_subfieldValues[0]->setValue($parameters);
			break;
			case 'required' :
				return ($this->_field->getValue("required")) ? true : false;
			break;
			case 'description' :
				return io::htmlspecialchars($this->getFieldDescription($cms_language));
			break;
			case 'fieldID':
				return $this->_field->getID();
			break;
			default:
				$this->raiseError("Unknown value to get : ".$name);
				return false;
			break;
		}
	}
	
	/**
	  * Get soap values
	  *
	  * @return string $xml XML definition
	  * @access public
	  */
	function getSoapValues($fieldID, $language) {
		$xml = '<field id="'.$fieldID.'" label="'.sensitiveIO::sanitizeHTMLString($this->getFieldLabel($language)).'" required="'.$this->_field->getValue('required').'">'."\n";
		
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				$xml .= 
				'<subfield id="'.$subFieldID.'" name="'.$subFieldDefinition['internalName'].'" type="'.$subFieldDefinition['type'].'" required="'.$subFieldDefinition['required'].'">'."\n";
				switch ($subFieldDefinition['type']) {
					case 'integer':
					case 'date':
						$xml .= $this->_subfieldValues[$subFieldID]->getValue();
					break;
					case 'text':
					case 'string':
					default:
						$xml .= '<![CDATA['.$this->_subfieldValues[$subFieldID]->getValue().']]>';
					break;
				}
				$xml .= "\n".'</subfield>'."\n";
			}
		}
		$xml .= '</field>'."\n";
		return $xml;
	}
	
	/**
	  * Set soap values
	  *
	  * @param integer $fieldID The field ID
	  * @param $domdocument XML values to set
	  * @param $itemId the ID of the polyobject item, if any (necessary for some fields (image, file, etc...)
	  * @return boolean true or false
	  * @access public
	  */
	function setSoapValues($fieldID, $domdocument, $itemId = '') {
	    $view = CMS_view::getInstance();
		$fieldValues = array();
		// subfield
        foreach($domdocument->childNodes as $childNode) {
			if($childNode->nodeType == XML_ELEMENT_NODE) {
				switch ($childNode->tagName) {
					case 'subfield':
						//<subfield id="{int}" [name="{string}"] type="int|string|date|text|object|binary|category|user|group">
						$subFieldId = $childNode->getAttribute('id');
						if (!sensitiveIO::isPositiveInteger($subFieldId) && $subFieldId != 0) {
							$view->addError('Missing or invalid attribute id for subfield tag');
							return false;
						}
						if (!isset($this->_subfields[$subFieldId])) {
							$view->addError('Unknown field id '.$fieldId.' for object '.$this->_objectID);
							return false;
						}
						$fieldValues[$fieldID.'_'.$subFieldId] = trim((io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? utf8_decode($childNode->nodeValue) : $childNode->nodeValue);
					break;
					case 'object':
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
		if (!$this->checkMandatory($fieldValues, '')) {
			$view->addError('Error of mandatory values for field '.$fieldID);
			return false;
		} elseif (!$this->setValues($fieldValues, '', false, $itemId)) {
			return false;
		}
		return true;
	}

	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName = '') {
		$labels = array();
		$labels['structure']['label'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_LABEL_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['fieldname'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_FIELDNAME_DESCRIPTION,array(io::htmlspecialchars($this->getFieldLabel($language))),MOD_POLYMOD_CODENAME);
		$labels['structure']['fieldID'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_FIELDID_DESCRIPTION,array($this->_field->getID()),MOD_POLYMOD_CODENAME);
		$labels['structure']['value'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_VALUE_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['required'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_REQUIRED_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['description'] = $language->getMessage(self::MESSAGE_OBJECT_COMMON_FIELD_DESC_DESCRIPTION,array(io::htmlspecialchars($this->getFieldDescription($language))),MOD_POLYMOD_CODENAME);

		return $labels;
	}

	/**
	  * Get field search SQL request (used by class CMS_object_search)
	  *
	  * @param integer $fieldID : this field id in object (aka $this->_field->getID())
	  * @param mixed $value : the value to search
	  * @param string $operator : additionnal search operator
	  * @param string $where : where clauses to add to SQL
	  * @param boolean $public : values are public or edited ? (default is edited)
	  * @return string : the SQL request
	  * @access public
	  */
	function getFieldSearchSQL($fieldID, $value, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";

		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError("Unkown search operator : ".$operator.", use default search instead");
			$operator = false;
		}

		//only add tables used by subfields
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			$types[$subFieldDefinition['type']] = true;
		}
		$sql = '';
		if (isset($types['text']) && $types['text'] == true) {
			$sql = "
				select
					distinct objectID
				from
					mod_subobject_text".$statusSuffix."
				where
					objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
					and value like '%".SensitiveIO::sanitizeSQLString($value)."%'
					$where";
		}
		if (isset($types['string']) && $types['string'] == true) {
			$sql .= ($sql) ? "\n".' union distinct '."\n" : '';
			$sql .= "
				select
					distinct objectID
				from
					mod_subobject_string".$statusSuffix."
				where
					objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
					and value like '%".SensitiveIO::sanitizeSQLString($value)."%'
					$where";
		}
		if (isset($types['date']) && $types['date'] == true) {
			$sql .= ($sql) ? "\n".' union distinct '."\n" : '';
			$sql .= "
				select
					distinct objectID
				from
					mod_subobject_date".$statusSuffix."
				where
					objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
					and value like '".SensitiveIO::sanitizeSQLString($value)."%'
					$where";
		}
		if (isset($types['integer']) && $types['integer'] == true) {
			$sql .= ($sql) ? "\n".' union distinct '."\n" : '';
			$sql .= "
				select
					distinct objectID
				from
					mod_subobject_integer".$statusSuffix."
				where
					objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
					and value ".(is_array($value) ? "in (".SensitiveIO::sanitizeSQLString(implode(',',$value)).")" : "= '".SensitiveIO::sanitizeSQLString($value)."'")."
					$where";
		}
		return $sql;
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
		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError("Unknown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		$sql = '';

		//only add tables used by subfields
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			$types[$subFieldDefinition['type']] = true;
		}
		//choose table
		if (isset($types['integer']) && $types['integer'] == true) {
			$fromTable = 'mod_subobject_integer';
		} elseif (isset($types['date']) && $types['date'] == true) {
			$fromTable = 'mod_subobject_date';
		} elseif (isset($types['text']) && $types['text'] == true) {
			$fromTable = 'mod_subobject_text';
		} elseif (isset($types['string']) && $types['string'] == true) {
			$fromTable = 'mod_subobject_string';
		}
		if (!$fromTable) {
			$fromTable = 'mod_subobject_integer';
		}
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
	  * Get field parameters as an array structure used for export
	  *
	  * @return array : the object array structure
	  * @access public
	  */
	public function asArray()
	{
		$aParameters = array();
		foreach ($this->_parameters as $key=>$aParameter) {
			$aParameters[$aParameter['internalName']] = $this->_parameterValues[$key];
		}
		return $aParameters;
	}
}
?>
