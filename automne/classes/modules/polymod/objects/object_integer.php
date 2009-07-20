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
// $Id: object_integer.php,v 1.4 2009/07/20 16:35:37 sebastien Exp $

/**
  * Class CMS_object_integer
  *
  * represent a simple integer object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_integer extends CMS_object_common
{
	/**
  * Polymod Messages
  */
	const MESSAGE_OBJECT_INTEGER_LABEL = 177;
	const MESSAGE_OBJECT_INTEGER_DESCRIPTION = 178;
	const MESSAGE_OBJECT_INTEGER_PARAMETER_CANBENULL = 179;
	const MESSAGE_OBJECT_INTEGER_PARAMETER_CANBENEGATIVE = 180;
	const MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT = 417;
  	const MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT_DESC = 418;
  	const MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT_DESCRIPTION = 419;
	const MESSAGE_OBJECT_INTEGER_OPERATOR_OTHERS_DESCRIPTION = 539;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_INTEGER_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_INTEGER_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'integer',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '');
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'canBeNull',
										'externalName'	=> self::MESSAGE_OBJECT_INTEGER_PARAMETER_CANBENULL,
									),
							 1 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'canBeNegative',
										'externalName'	=> self::MESSAGE_OBJECT_INTEGER_PARAMETER_CANBENEGATIVE,
									),
							2 => array(
										'type'                  => 'string',
										'required'              => false,
										'internalName'  => 'unit',
										'externalName'  => self::MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT,
										'description'   => self::MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT_DESC,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => false, 2 => '');
	
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
		parent::__construct($datas, $field, $public);
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
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				if ($values[$prefixName.$this->_field->getID().'_'.$subFieldID] || $values[$prefixName.$this->_field->getID().'_'.$subFieldID] === '0') {
					//check value according to parameters
					
					//must be numeric
					if (!is_numeric($values[$prefixName.$this->_field->getID().'_'.$subFieldID])) {
						return false;
					}
					//check canBeNull parameter
					if (!$params['canBeNull'] && $values[$prefixName.$this->_field->getID().'_'.$subFieldID] === '0') {
						return false;
					}
					//check canBeNegative parameter
					if (!$params['canBeNegative'] && $values[$prefixName.$this->_field->getID().'_'.$subFieldID] < 0) {
						return false;
					}
					if (!$this->_subfieldValues[$subFieldID]->setValue($values[$prefixName.$this->_field->getID().'_'.$subFieldID])) {
						return false;
					}
				} else {
					$this->_subfieldValues[$subFieldID]->setValue(null);
				}
			}
		}
		return true;
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
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		$return['xtype'] =	'numberfield';
		$return['allowDecimals'] =	false;
		if (isset($params['canBeNegative'])) {
			$return['allowNegative'] =	$params['canBeNegative'];
		}
		if (isset($params['canBeNull'])) {
			$return['minValue'] = ($params['canBeNull']) ? 0 : 1;
			$return['value'] = (!$params['canBeNull'] && !$return['value']) ? false : $return['value'];
		}
		$return['anchor'] = false;
		$return['width'] = 200;
		if (isset($params['unit']) && $params['unit']) {
			$return['labelSeparator'] = '';
			$return['fieldLabel'] .= ' :<br /><small>'.$language->getMessage(self::MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT, false, MOD_POLYMOD_CODENAME).' : '.$params['unit'].'</small>';
		}
		return $return;
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
			$value = ($this->_subfieldValues[0]->getValue() || $params['canBeNull']) ? $this->_subfieldValues[0]->getValue() : '';
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
    function getLabelsStructure(&$language) {
		$labels = parent::getLabelsStructure($language);
		$params = $this->getParamsValues();
		unset($labels['structure']['value']);
		$labels['operator']['&lt;, &gt;,&lt;=, &gt;= '] = $language->getMessage(self::MESSAGE_OBJECT_INTEGER_OPERATOR_OTHERS_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		if(isset($params['unit']) && $params['unit']){
			$labels['structure']['unit'] = $language->getMessage(self::MESSAGE_OBJECT_INTEGER_PARAMETER_UNIT_DESCRIPTION,array($params['unit']) ,MOD_POLYMOD_CODENAME);
		}
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
		$supportedOperator = array(
			'<',
			'<=',
			'>',
			'>=',
		);
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->_raiseError(get_class($this)." : getFieldSearchSQL : unkown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		if (!$operator) {
			return parent::getFieldSearchSQL($fieldID, $value, $operator, $where, $public);
		}
		$statusSuffix = ($public) ? "_public":"_edited";
		$sql = "
			select
				distinct objectID
			from
				mod_subobject_integer".$statusSuffix."
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and value ".$operator." '".SensitiveIO::sanitizeSQLString($value)."'
				$where";
		return $sql;
	}
}
?>