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
// $Id: object_date.php,v 1.14 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_object_date
  *
  * represent a date object
  *
  * @package Automne
  * @subpackage polymod
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
	const MESSAGE_OBJECT_DATE_HOURS = 515;
	const MESSAGE_OBJECT_TEXT_HASVALUE_DESCRIPTION = 411;
	
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
		if (!is_object($cms_language)) {
			$cms_language = new CMS_language(APPLICATION_DEFAULT_LANGUAGE);
		}
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
		global $cms_language;
		$date = new CMS_date();
		$date->setFormat($cms_language->getDateFormat());
		if (isset($values[$prefixName.$this->_field->getID().'_0']) && $values[$prefixName.$this->_field->getID().'_0']) {
			if (!$date->setLocalizedDate($values[$prefixName.$this->_field->getID().'_0'], !$this->_field->getValue('required'))) {
				return false;
			}
		}
		//if field is required check values
		if ($this->_field->getValue('required')) {
			$params = $this->getParamsValues();
			//can be null if param setNow or creationDate is true
			if ($params['setNow'] || $params['creationDate'] || $params['updateDate']) {
				return true;
			}
			if (!isset($values[$prefixName.$this->_field->getID().'_0']) || !$values[$prefixName.$this->_field->getID().'_0']) {
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
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		
		//is this field mandatory ?
		$mandatory = $this->_field->getValue('required') ? '<span class="atm-red">*</span> ' : '';
		$desc = $this->getFieldDescription($language);
		
		//create object CMS_date
		$date = new CMS_date();
		$date->setFromDBValue($this->_subfieldValues[0]->getValue());
		$dateFormat = $language->getDateFormat();
		$dateMask = $language->getDateFormatMask();
		$wasNull = ($date->isNull()) ? true : false;
		if ($date->isNull() && ($params['setNow'] || $params['creationDate'])) {
			$date->setNow();
		}
		if ($params['updateDate']) {
			$date->setNow();
		}
		if ($params['moveDate'] && (($params['setNow'] && $wasNull) || ($params['creationDate'] && $wasNull) || $params['updateDate'])) {
			$date->moveDate($params['moveDate']);
		}
		if (!$params['creationDate'] && !$params['updateDate']) {
			$desc .= ($desc ? ' - ' : '').$language->getMessage(self::MESSAGE_OBJECT_DATE_DATE_COMMENT, array($dateMask));
		}
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
		
		if ($params['withHMS']) {
			$hms = !$date->isNull() ? $date->getHour().':'.$date->getMinute().':'.$date->getSecond() : '';
			$return = array(
				'layout'	=> 'column',
				'xtype'		=> 'panel',
				'border'	=> false,
				'items'		=> array(
					array(
						'width'			=> 230,
						'layout'		=> 'form',
						'border'		=> false,
						'items'			=> array(array(
							'allowBlank'	=> !$this->_field->getValue('required'),
							/*'id'			=> $return['id'],*/
							'name'			=> $return['name'],
							'xtype'			=> 'datefield',
							'fieldLabel'	=> $label,
							'value'			=> !$date->isNull() ? $date->getLocalizedDate($dateFormat) : '',
							'format'		=> $dateFormat,
							'disabled'		=>	($params['creationDate'] || $params['updateDate'])
						))
					),array(
						'columnWidth'	=> 1,
						'layout'		=> 'form',
						'border'		=> false,
						'labelWidth'	=> 55,
						'items'			=> array(array(
							'xtype'			=> 'textfield',
							'fieldLabel'	=> '<span class="atm-help" ext:qtip="'.io::htmlspecialchars($language->getMessage(self::MESSAGE_OBJECT_DATE_DATE_COMMENT, array($language->getMessage(self::MESSAGE_OBJECT_DATE_HMS_FORMAT, false, MOD_POLYMOD_CODENAME)))).'">'.$language->getMessage(self::MESSAGE_OBJECT_DATE_HOURS, false, MOD_POLYMOD_CODENAME).'</span>',
							'value'			=> $hms,
							/*'id'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]',*/
							'name'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]',
							'disabled'		=>	($params['creationDate'] || $params['updateDate'])
						))
					)
				)
			);
		} else {
			$return['fieldLabel'] =	$label;
			$return['xtype'] =	'datefield';
			$return['value'] =	!$date->isNull() ? $date->getLocalizedDate($dateFormat) : '';
			$return['format'] =	$dateFormat;
			$return['width'] =	100;
			$return['anchor'] =	false;
			$return['disabled'] = ($params['creationDate'] || $params['updateDate']);
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
		if ($params['moveDate'] && (($params['setNow'] && $wasNull) || ($params['creationDate'] && $wasNull) || $params['updateDate'])) {
			$date->moveDate($params['moveDate']);
		}
		if (!$params['creationDate'] && !$params['updateDate']) {
			$html .= '<input type="text"'.$htmlParameters.' id="'.$prefixName.$this->_field->getID().'_0" name="'.$prefixName.$this->_field->getID().'_0" value="'.$date->getLocalizedDate($language->getDateFormat()).'" />';
			if (isset($inputParams['calendar']) && $inputParams['calendar']) {
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
		if (isset($values[$prefixName.$this->_field->getID().'_0'])) {
			if (!$date->setLocalizedDate($values[$prefixName.$this->_field->getID().'_0'], !$this->_field->getValue('required'))) {
				return false;
			}
			if ($params['withHMS'] && isset($values[$prefixName.$this->_field->getID().'_1']) && $values[$prefixName.$this->_field->getID().'_1']) {
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
		if ($params['creationDate']) {
			$date->setFromDBValue($this->_subfieldValues[0]->getValue());
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
		$structure['notNull'] = '';
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
		switch($name) {
			case 'formatedValue':
				global $cms_language;
        		$date = new CMS_date();
				$date->setFromDBValue($this->_subfieldValues[0]->getValue());
				if (io::strtolower($parameters) == 'rss') {
					$date = date('r', $date->getTimeStamp());
				} else {
					$date = date($parameters, $date->getTimeStamp());
					if (is_object($cms_language) && isset($languages[$cms_language->getCode()])) {
	                    $date = str_replace(array_keys($languages[$cms_language->getCode()]), $languages[$cms_language->getCode()], $date);
	                }
				}
				return io::htmlspecialchars($date);
			break;
			case 'notNull':
				$date = new CMS_date();
				$date->setFromDBValue($this->_subfieldValues[0]->getValue());
				return !$date->isNull();
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
		$labels['structure']['notNull'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_HASVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
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
	
	/**
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string $prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence() {
		$params = $this->getParamsValues();
		$date = new CMS_date();
		if ($this->_subfieldValues[0]->getValue()) {
			$date->setFromDBValue($this->_subfieldValues[0]->getValue());
		}
		if ($params['updateDate'] || ($date->isNull() && ($params['setNow'] || $params['creationDate']))) {
			$date->setNow();
			if ($params['moveDate']) {
				$date->moveDate($params['moveDate']);
			}
			if (!$this->_subfieldValues[0]->setValue($date->getDBValue())) {
				return false;
			}
		}
		return parent::writeToPersistence();
	}
}
?>