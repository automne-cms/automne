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
// $Id: object_date.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_object_date
  *
  * represent a date object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_date extends CMS_object_common
{
	/**
	  * Polymod Messages
	*/
	const MESSAGE_OBJECT_DATE_FORMATEDVALUE_DESCRIPTION = 150;
	const MESSAGE_OBJECT_DATE_LABEL = 170;
	const MESSAGE_OBJECT_DATE_DESCRIPTION = 171;
	const MESSAGE_OBJECT_DATE_PARAMETER_SETNOW = 172;
	const MESSAGE_OBJECT_DATE_PARAMETER_WITH_HMS = 173;
	const MESSAGE_OBJECT_DATE_HMS_FORMAT = 174;
	const MESSAGE_OBJECT_DATE_PARAMETER_CREATION_DATE = 368;
	const MESSAGE_OBJECT_DATE_PARAMETER_MOVE_DATE = 369;
	const MESSAGE_OBJECT_DATE_PARAMETER_MOVE_DATE_DESCRIPTION = 370;
	const MESSAGE_OBJECT_DATE_PARAMETER_UPDATE_DATE = 371;
	const MESSAGE_OBJECT_DATE_OPERATOR_DESCRIPTION = 380;
	const MESSAGE_OBJECT_DATE_OPERATOR_TITLE = 390;
	
	/**
	  * Standard Messages
	  */
	const MESSAGE_OBJECT_DATE_DATE_COMMENT = 148;
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_DATE_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_DATE_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|text|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'date',
										'required' 		=> false,
										'internalName'	=> 'date',
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
										'internalName'	=> 'setNow',
										'externalName'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_SETNOW,
									),
							 1 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'withHMS',
										'externalName'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_WITH_HMS,
									),
							 2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'creationDate',
										'externalName'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_CREATION_DATE,
									),
							 3 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'updateDate',
										'externalName'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_UPDATE_DATE,
									),
							 4 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'moveDate',
										'externalName'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_MOVE_DATE,
										'description'	=> self::MESSAGE_OBJECT_DATE_PARAMETER_MOVE_DATE_DESCRIPTION,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => false, 2 => false, 3 => false, 4 => '');
	
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
	  * get object label
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		global $cms_language;
		if (!is_object($this->_subfieldValues[0])) {
			$this->raiseError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		$date = new CMS_date();
		$date->setFromDBValue($this->_subfieldValues[0]->getValue());
		$params = $this->getParamsValues();
		if (!$date->isNull()) {
			if (!$params['withHMS']) {
				return $date->getLocalizedDate($cms_language->getDateFormat());
			} else {
				return $date->getLocalizedDate($cms_language->getDateFormat()).' '.$date->getHour().':'.$date->getMinute().':'.$date->getSecond();
			}
		}
		return '';
	}
	
	/**
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values,$prefixName) {
		//if field is required check values
		if ($this->_field->getValue('required')) {
			$params = $this->getParamsValues();
			//can be null if param setNow is true
			if (!$values[$prefixName.$this->_field->getID().'_0'] && !$params['setNow']) {
				return false;
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
		$params = $this->getParamsValues();
		//is this field mandatory ?
		$mandatory = ($this->_field->getValue('required')) ? '<span class="admin_text_alert">*</span> ':'';
		//create html for each subfields
		$date_mask = $language->getDateFormatMask();
		$html = '<tr><td class="admin" align="right" valign="top">'.$mandatory.$this->getFieldLabel($language).'<br />
		<small>('.$language->getMessage(self::MESSAGE_OBJECT_DATE_DATE_COMMENT, array($date_mask)).')</small></td><td class="admin">'."\n";
		//add description if any
		if ($this->getFieldDescription($language)) {
			$html .= '<dialog-title type="admin_h3">'.$this->getFieldDescription($language).'</dialog-title><br />';
		}
		$inputParams = array(
			'class' 	=> 'admin_input_text',
			'prefix'	=>	$prefixName,
			'size'  	=> 15,
			'form'		=> 'frmitem',
			'calendar'	=> true,
		);
		$html .= $this->getInput($fieldID, $language, $inputParams);
		$html .= '</td></tr>'."\n";
		return $html;
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
		} else {
			$prefixName = '';
		}
		//serialize all htmlparameters 
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$html = '';
		//create fieldname
		$fieldName = $prefixName.$this->_field->getID().'_0';
		//create object CMS_date
		$date = new CMS_date();
		$date->setFromDBValue($this->_subfieldValues[0]->getValue());
		$wasNull = ($date->isNull()) ? true : false;
		if ($date->isNull() && ($params['setNow'] || $params['creationDate'])) {
			$date->setNow();
		}
		if ($params['updateDate']) {
			$date->setNow();
		}
		if ($wasNull && $params['moveDate'] && ($params['setNow'] || $params['creationDate'] || $params['updateDate'])) {
			$date->moveDate($params['moveDate']);
		}
		if (!$params['creationDate'] && !$params['updateDate']) {
			$html .= '<input type="text"'.$htmlParameters.' id="'.$prefixName.$this->_field->getID().'_0" name="'.$prefixName.$this->_field->getID().'_0" value="'.$date->getLocalizedDate($language->getDateFormat()).'" />';
			if ($inputParams['calendar']) {
				$html .= '&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\''.$prefixName.$this->_field->getID().'_0\'),\''.$language->getCode().'\',this);return false;" />';
			}
		} else {
			$html .= $date->getLocalizedDate($language->getDateFormat()).' <input type="hidden" id="'.$prefixName.$this->_field->getID().'_0" name="'.$prefixName.$this->_field->getID().'_0" value="'.$date->getLocalizedDate($language->getDateFormat()).'" />';
		}
		if ($params['withHMS']) {
			if (!$date->isNull()) {
				$hms = $date->getHour().':'.$date->getMinute().':'.$date->getSecond();
			}
			if (!$params['creationDate'] && !$params['updateDate']) {
				$html .= '&nbsp;&nbsp;<input type="text"'.$htmlParameters.' id="'.$prefixName.$this->_field->getID().'_1" name="'.$prefixName.$this->_field->getID().'_1" value="'.$hms.'" /> <small>('.$language->getMessage(self::MESSAGE_OBJECT_DATE_DATE_COMMENT, array($language->getMessage(self::MESSAGE_OBJECT_DATE_HMS_FORMAT, false, MOD_POLYMOD_CODENAME))).')</small>';
			} else {
				$html .= '&nbsp;&nbsp;'.$hms.'<input type="hidden" id="'.$prefixName.$this->_field->getID().'_1" name="'.$prefixName.$this->_field->getID().'_1" value="'.$hms.'" />';
			}
		}
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
	  * @param string $prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName) {
		global $cms_language;
		$params = $this->getParamsValues();
		$date = new CMS_date();
		$date->setFormat($cms_language->getDateFormat());
		if ($values[$prefixName.$this->_field->getID().'_0']) {
			if (!$date->setLocalizedDate($values[$prefixName.$this->_field->getID().'_0'], !$this->_field->getValue('required'))) {
				return false;
			}
			if ($params['withHMS'] && $values[$prefixName.$this->_field->getID().'_1']) {
				$hms = explode(':',$values[$prefixName.$this->_field->getID().'_1']);
				if (sizeof($hms) != 3) {
					return false;
				}
				if (!$date->setHour($hms[0])) {
					return false;
				}
				if (!$date->setMinute($hms[1])) {
					return false;
				}
				if (!$date->setSecond($hms[2])) {
					return false;
				}
			}
		}
		if (($date->isNull() && ($params['setNow'] || $params['creationDate'])) || $params['updateDate']) {
			$date->setNow();
			if ($params['moveDate']) {
				$date->moveDate($params['moveDate']);
			}
		}
		if (!$this->_subfieldValues[0]->setValue($date->getDBValue())) {
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
		$structure['formatedValue'] = '';
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
			case 'formatedValue':
				$date = new CMS_date();
				$date->setFromDBValue($this->_subfieldValues[0]->getValue());
				if (strtolower($parameters) == 'rss') {
					$parameters = 'r';
				}
				return htmlspecialchars(date($parameters, $date->getTimeStamp()));
			break;
			default:
				return parent::getValue($name, $parameters);
			break;
		}
	}
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName) {
		$labels = parent::getLabelsStructure($language, $objectName);
		$labels['structure']['formatedValue|format'] = $language->getMessage(self::MESSAGE_OBJECT_DATE_FORMATEDVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator'][$language->getMessage(self::MESSAGE_OBJECT_DATE_OPERATOR_TITLE,false ,MOD_POLYMOD_CODENAME)] = $language->getMessage(self::MESSAGE_OBJECT_DATE_OPERATOR_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
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
			'>=',
			'<=',
			'>',
			'<',
			'>= or null',
			'<= or null',
			'> or null',
			'< or null',
			'>= and not null',
			'<= and not null',
			'> and not null',
			'< and not null'
		);
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError("Unknown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		if (!$operator) {
			return parent::getFieldSearchSQL($fieldID, $value, $operator, $where, $public);
		}
		
		// canBeNull
		$operators = explode('or',$operator);
		$operator = trim($operators[0]);
		$canBeNull = (isset($operators[1])) ? ' or value is NULL' : '';
		// cantBeNull
		$operators = explode('and',$operator);
		$operator = trim($operators[0]);
		$cantBeNull = (isset($operators[1])) ? ' and value is not NULL and value != \'0000-00-00\' and value != \'0000-00-00 00:00:00\'' : '';
		
		$statusSuffix = ($public) ? "_public":"_edited";
		$sql = "
			select
				distinct objectID
			from
				mod_subobject_date".$statusSuffix."
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and (value ".$operator." '".SensitiveIO::sanitizeSQLString($value)."'".$canBeNull.$cantBeNull.")
				$where";
		return $sql;
	}
}
?>