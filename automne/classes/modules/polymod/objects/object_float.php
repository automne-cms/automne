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
// $Id: object_float.php,v 1.4 2009/07/20 16:35:37 sebastien Exp $

/**
  * Class CMS_object_float
  *
  * represent a simple float object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_float extends CMS_object_string {
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_FLOAT_LABEL = 396;
	const MESSAGE_OBJECT_FLOAT_DESCRIPTION = 397;
	const MESSAGE_OBJECT_FLOAT_OPERATOR_OTHERS_DESCRIPTION = 394;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_MAXLENGTH = 187;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_CANBENEGATIVE = 395;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_MATCH_EXPRESSION = 372;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_MATCH_EXPRESSION_DESCRIPTION = 373;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT = 417;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT_DESC = 418;
	const MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT_DESCRIPTION = 419;
	const MESSAGE_OBJECT_FLOAT_FUNCTION_SELECTEDOPTIONS_DESCRIPTION = 538;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_FLOAT_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_FLOAT_DESCRIPTION;
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'maxLength',
										'externalName'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_MAXLENGTH,
									),
							 1 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'canBeNegative',
										'externalName'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_CANBENEGATIVE,
									),
							 2 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'matchExp',
										'externalName'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_MATCH_EXPRESSION,
										'description'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_MATCH_EXPRESSION_DESCRIPTION,
									),
							3 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'unit',
										'externalName'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT,
										'description'	=> self::MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT_DESC,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => '255', 1 => true, 2 => '^-?[0-9]+(\.[0-9]+|)$', 3 => '');
	
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
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		$return['xtype'] =	'numberfield';
		$return['allowDecimals'] =	true;
		$return['allowNegative'] =	$params['canBeNegative'];
		$return['anchor'] = false;
		$return['width'] = 200;
		$return['maxLength'] = $params['maxLength'];
		$return['decimalPrecision'] = 8;
		$return['decimalSeparator'] = '.';
		if ($params['unit']) {
			$return['labelSeparator'] = '';
			$return['fieldLabel'] .= ' :<br /><small>'.$language->getMessage(self::MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT, false, MOD_POLYMOD_CODENAME).' : '.$params['unit'].'</small>';
		}
		return $return;
	}
	
	/**
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName) {
		$params = $this->getParamsValues();
		if ($values[$prefixName.$this->_field->getID().'_0']) {
			//check string length parameter
			if (strlen($values[$prefixName.$this->_field->getID().'_0']) > $params['maxLength']) {
				return false;
			}
			//check if value is a negative number (if needed)
			if ($values[$prefixName.$this->_field->getID().'_0'] && !$params['canBeNegative'] && ((int)$values[$prefixName.$this->_field->getID().'_0'] < 0)) {
				return false;
			}
			//check if value has no html tags
			if (strip_tags($values[$prefixName.$this->_field->getID().'_0']) != $values[$prefixName.$this->_field->getID().'_0']) {
				return false;
			}
			//check match expression if any
			if ($params['matchExp'] && !preg_match('#'.$params['matchExp'].'#', $values[$prefixName.$this->_field->getID().'_0'])) {
				return false;
			}
		}
		if (!$this->_subfieldValues[0]->setValue(htmlspecialchars($values[$prefixName.$this->_field->getID().'_0']))) {
			return false;
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
		$structure = parent::getStructure();
		unset($structure['value']);
		$structure['unit'] = '';
		return $structure;
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
		$params = $this->getParamsValues();
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
			unset($inputParams['prefix']);
		} else {
			$prefixName = '';
		}
		//serialize all htmlparameters 
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$html = '';
		if (is_object($this->_subfieldValues[0])) {
			//create fieldname
			$fieldName = $prefixName.$this->_field->getID().'_0';
			//append field id to html field parameters (if not already exists)
			$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_0"' : '';
			//create field value
			$value = ($this->_subfieldValues[0]->getValue() || (isset($params['canBeNull']) && $params['canBeNull'])) ? $this->_subfieldValues[0]->getValue() : '';
			//then create field HTML
			$html .= ($html) ? '<br />':'';
			$html .= '<input type="text"'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_0" value="'.$value.'" />'."\n";
			if ($params['unit']) {
				$html .= '&nbsp;<small>'.$params['unit'].'</small>';
			}
			if (POLYMOD_DEBUG) {
				$html .= ' <span class="admin_text_alert">(Field : '.$this->_field->getID().' - SubField : 0)</span>';
			}
		}
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
	}
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName) {
		$params = $this->getParamsValues();
		$labels = parent::getLabelsStructure($language, $objectName);
		$labels['operator']['&lt;, &gt;,&lt;=, &gt;= '] = $language->getMessage(self::MESSAGE_OBJECT_FLOAT_OPERATOR_OTHERS_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		if($params['unit']){
			$labels['structure']['unit'] = $language->getMessage(self::MESSAGE_OBJECT_FLOAT_PARAMETER_UNIT_DESCRIPTION,array($params['unit']) ,MOD_POLYMOD_CODENAME);
		}
		$labels['function']['selectOptions'] = $language->getMessage(self::MESSAGE_OBJECT_FLOAT_FUNCTION_SELECTEDOPTIONS_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);
		return $labels;
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
		switch($name) {
			case 'unit':
				//get field parameters
				$params = $this->getParamsValues();
				return ($params['unit']) ? $params['unit'] : '';
			break;
			default:
				return parent::getValue($name, $parameters);
			break;
		}
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
		$supportedOperator = array(
			'>=',
			'<=',
			'>',
			'<',
		);
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError('Unkown search operator : '.$operator.', use default search instead');
			$operator = false;
		}
		if (!$operator) {
			return parent::getFieldSearchSQL($fieldID, $value, $operator, $where, $public);
		}
		$statusSuffix = ($public) ? "_public":"_edited";

		//if numeric comparison such as > or <, we have to transtype the string field
		$field = "CAST(value AS SIGNED)";
		
		$sql = "
		select
			distinct objectID
		from
			mod_subobject_string".$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			and ".$field." ".$operator." '".SensitiveIO::sanitizeSQLString($value)."'
			$where";
			
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
		//operators are not supported for now : TODO
		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError('Unkown search operator : '.$operator.', use default search instead');
			$operator = false;
		}
		$sql = '';
		
		//choose table
		$fromTable = 'mod_subobject_string';
		
		// create sql
		$sql = "
		select
			distinct objectID
		from
			".$fromTable.$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			and objectSubFieldID = '0'
			$where
		order by (value+0) ".$direction;
		
		return $sql;
	}
	
	/**
     * Return options tag list (for a select tag) of all float values for this field
     *
     * @param array $values : parameters values array(parameterName => parameterValue) in :
     *     selected : the float value which is selected (optional)
     * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
     * @return string : options tag list
     * @access public
     */
	function selectOptions($values, $tags) {
		$return = "";
		$fieldID = $this->_field->getID();
		$allValues = array();
		$status = ($this->_public ? 'public' : 'edited');
		// Search all values for this field
		$sql = "select
                   distinct value
               from
                   mod_subobject_string_".$status."
               where
                   objectFieldID='".$fieldID."'
		";
		$q = new CMS_query($sql);
		while($value = $q->getValue('value')) {
			$allValues[$value] = $value;
		}
		if (is_array($allValues) && $allValues) {
			natsort($allValues);
			foreach ($allValues as $id => $label) {
				$selected = ($id == $values['selected']) ? ' selected="selected"':'';
				$return .= '<option value="'.$id.'"'.$selected.'>'.$label.'</option>';
			}
		}
		return $return;
	}
}
?>