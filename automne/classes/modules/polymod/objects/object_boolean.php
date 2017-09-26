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
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: object_boolean.php,v 1.6 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_object_integer
  *
  * represent a simple integer object
  *
  * @package Automne
  * @subpackage polymod
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */
class CMS_object_boolean extends CMS_object_common
{
	const MESSAGE_OBJECT_BOOLEAN_LABEL = 384;
	const MESSAGE_OBJECT_BOOLEAN_DESCRIPTION = 385;
	//Standard messages
	const MESSAGE_OBJECT_BOOLEAN_YES = 1538;
	const MESSAGE_OBJECT_BOOLEAN_NO = 1539;
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_BOOLEAN_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_BOOLEAN_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required'		=> false,
										'internalName'	=> 'boolean',
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
	protected $_parameters = array();
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array();
	
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
	public function __construct($datas=array(), &$field, $public=false)
	{
		parent::__construct($datas, $field, $public);
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
	public function getHTMLAdmin($fieldID, $language, $prefixName) {
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$return['xtype'] =	'checkbox';
		$return['checked'] = !!$this->_subfieldValues[0]->getValue();
		$return['anchor'] = '';
		$return['inputValue'] =	1;
		$return['boxLabel'] = '&nbsp;'; //needed to avoid checkbox to be centered
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
	public function getInput($fieldID, $language, $inputParams) {
		//hidden field : use parent method
		if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
			return parent::getInput($fieldID, $language, $inputParams);
		}
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
			unset($inputParams['prefix']);
		} else {
			$prefixName = '';
		}
		$params = $this->getParamsValues();
		//serialize all htmlparameters 
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$html = '';
		
		//create fieldname
		$fieldName = $prefixName.$this->_field->getID().'_0';
		//append field id to html field parameters (if not already exists)
		$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_0"' : '';
		//create field value
		$value = isset($inputParams['value']) ? $inputParams['value'] : $this->_subfieldValues[0]->getValue();
		//then create field HTML
		$html .= ($html) ? '<br />':'';
		$checked = ($value) ? 'checked="checked"' : '';
		$html .= '<input '.$htmlParameters.' '.$checked.' type="checkbox" name="'.$fieldName.'" value="1" />'."\n";
		if (POLYMOD_DEBUG) {
			$html .= ' <span class="admin_text_alert">(Field : '.$this->_field->getID().' - SubField : 0)</span>';
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
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setValues($values,$prefixName, $newFormat = false) {
		if (is_object($this->_subfieldValues[0])) {
			$value = isset($values[$prefixName.$this->_field->getID().'_0']) ? $values[$prefixName.$this->_field->getID().'_0'] : 0;
			// Convert boolean to integer
			$value = ($value) ? 1 : 0;
			if (!$this->_subfieldValues[0]->setValue($value)) {
				return false;
			}
		}
		return true;
	}
	
	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	public function getHTMLDescription() {
		global $cms_language;
		if (is_object($this->_subfieldValues[0])) {
			return $this->_subfieldValues[0]->getValue() ? $cms_language->getMessage(self::MESSAGE_OBJECT_BOOLEAN_YES) : $cms_language->getMessage(self::MESSAGE_OBJECT_BOOLEAN_NO);
		}
		return $cms_language->getMessage(self::MESSAGE_OBJECT_BOOLEAN_NO);
	}
	
	/**
	  * Return a list of all objects names of given type
	  *
	  * @param boolean $public are the needed datas public ? /!\ Does not apply for this type of object
	  * @param array $searchConditions, search conditions to add. /!\ Does not apply for this type of object
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	public function getListOfNamesForObject($public = false, $searchConditions = array(), $restrictToUsedCat = true) {
		global $cms_language;
		$a_boolean['-'] = $cms_language->getMessage(self::MESSAGE_OBJECT_BOOLEAN_NO);
		$a_boolean[1] = $cms_language->getMessage(self::MESSAGE_OBJECT_BOOLEAN_YES);
		return $a_boolean;
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
	public function getFieldSearchSQL($fieldID, $value, $operator, $where, $public = false) {
		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->setError("Unknown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		$statusSuffix = ($public) ? "_public":"_edited";
		$value = $value == '-' ? '0' : $value;
		$sql = "
			select
				distinct objectID
			from
				mod_subobject_integer".$statusSuffix."
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and value = '".$value."'
				$where";
		return $sql;
	}
}
?>