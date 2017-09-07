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
// $Id: object_text.php,v 1.8 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_text
  *
  * represent a simple text object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_text extends CMS_object_common
{
	const MESSAGE_EMPTY_OBJECTS_SET = 265;
	const MESSAGE_CHOOSE_OBJECT = 1132;
	
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_TEXT_LABEL = 181;
	const MESSAGE_OBJECT_TEXT_DESCRIPTION = 182;
	const MESSAGE_OBJECT_TEXT_PARAMETER_HTML_ALLOWED = 183;
	const MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_TYPE = 184;
	const MESSAGE_OBJECT_TEXT_HTMLVALUE_DESCRIPTION = 255;
	const MESSAGE_OBJECT_TEXT_TXTVALUE_DESCRIPTION = 627;
	const MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_WIDTH = 342;
	const MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_HEIGHT = 341;
	const MESSAGE_OBJECT_TEXT_HASVALUE_DESCRIPTION = 411;
	const MESSAGE_OBJECT_TEXT_COPY_PASTE_ERROR = 537;
	const MESSAGE_OBJECT_TEXT_OPERATOR_DESCRIPTION = 389;
	const MESSAGE_OBJECT_TEXT_OPERATOR_COMPARAISON_DESCRIPTION = 599;
	const MESSAGE_OBJECT_TEXT_OPERATOR_ARRAY_DESCRIPTION = 600;
	const MESSAGE_OBJECT_TEXT_OPERATOR_ANY_DESCRIPTION = 635;
	const MESSAGE_OBJECT_TEXT_OPERATOR_ALL_DESCRIPTION = 636;
	const MESSAGE_OBJECT_TEXT_OPERATOR_PHRASE_DESCRIPTION = 637;
	const MESSAGE_OBJECT_TEXT_OPERATOR_BEGINSWITH_DESCRIPTION = 638;

	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_TEXT_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_TEXT_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|text|boolean|integer|date)", "required" => boolean, "isParameter" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'text',
										'required' 		=> false,
										'internalName'	=> 'text',
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
										'required' 		=> true,
										'internalName'	=> 'html',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_HTML_ALLOWED,
									),
							 1 => array(
										'type' 			=> 'toolbar',
										'required' 		=> false,
										'internalName'	=> 'toolbar',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_TYPE,
									),
							 2 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'toolbarWidth',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_WIDTH,
									),
							 3 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'toolbarHeight',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_WYSIWYG_HEIGHT,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => true, 1 => 'BasicLink', 2 => '100%', 3 => '200');
	
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
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values,$prefixName, $newFormat = false) {
		//if field is required check values
		$params = $this->getParamsValues();
		if ($this->_field->getValue('required')) {
			if (!isset($values[$prefixName.$this->_field->getID().'_0']) || !$values[$prefixName.$this->_field->getID().'_0']) {
				return false;
			}
		}
		//check value for copy/paste and XHTML conformity
		if ($newFormat && $params['html'] && isset($values[$prefixName.$this->_field->getID().'_0']) && $values[$prefixName.$this->_field->getID().'_0']) {
			$value = $values[$prefixName.$this->_field->getID().'_0'];
			$errors = '';
			if (!sensitiveIO::checkXHTMLValue($value, $errors)) {
				//Send an error to user about his content
				global $cms_language;
				if (is_object($cms_language)) {
					return $cms_language->getMessage(self::MESSAGE_OBJECT_TEXT_COPY_PASTE_ERROR, array($this->getFieldLabel($cms_language)), MOD_POLYMOD_CODENAME).($errors ? '<br /><br />'.$errors : '');
				} else {
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object categories parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersToolbar($language, $prefixName) {
		global $cms_user;
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "toolbar") {
				// Get toolbars
				$toolbars = CMS_wysiwyg_toolbar::getAll($cms_user);
				if (is_array($toolbars) && $toolbars) {
					$input = '<select name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text">';
					foreach($toolbars as $code => $toolbar) {
						$selected = ($paramValue == $code) ? ' selected="selected"':'';
						$input .= '<option value="'.$code.'"'.$selected.'>'.$toolbar->getLabel().'</option>';
					}
					$input .= '</select>';
				} else {
					$input = $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET).'<input type="hidden" name="'.$prefixName.$parameter['internalName'].'" value="0" />';
				}
			}
		}
		return $input;
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
		if ($params['html']) {
			global $cms_user;
			// Insert prefered text editor for textarea field
			$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$toolbarset = (!$params['toolbar']) ? $module : $params['toolbar'] ;
			//create field value
			$value = $this->_subfieldValues[0]->getValue();
			if (class_exists('CMS_wysiwyg_toolbar')) {
				$toolbar = CMS_wysiwyg_toolbar::getByCode($toolbarset, $cms_user);
				$value = $toolbar->hasModulePlugins() ? CMS_textEditor::parseInnerContent($value, $module) : $value;
			}
			$return['xtype'] =	'ckeditor';
			$return['id'] =		'ckeditor'.md5(mt_rand().microtime());
			$return['value'] =	(string) $value;
			$return['editor'] = array(
				'scayt_sLang'		=> $language->getCode(),
				'language'			=> $language->getCode(),
				'customConfig'		=> PATH_MAIN_WR.'/ckeditor/config.php',
				'atmToolbar'		=> $toolbarset,
			);
		} else {
			$return['xtype'] = 'textarea';
			$return['value'] = str_replace('<br />',"\n",str_replace(array("\n","\r"),"",sensitiveIO::decodeEntities($return['value'])));
		}
		if (sensitiveIO::isPositiveInteger($params['toolbarHeight'])) {
			$return['height'] = $params['toolbarHeight'];
		}
		if (sensitiveIO::isPositiveInteger($params['toolbarWidth'])) {
			$return['width'] = $params['toolbarWidth'];
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
		//hidden field : use parent method
		if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
			return parent::getInput($fieldID, $language, $inputParams);
		}
		global $cms_user;
		$params = $this->getParamsValues();
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
		} else {
			$prefixName = '';
		}
		//serialize all htmlparameters 
		//$htmlParameters = $this->serializeHTMLParameters($inputParams);
		
		$html = '';
		//create fieldname
		$fieldName = $prefixName.$this->_field->getID().'_0';
		//create field value
		$value = $this->_subfieldValues[0]->getValue();
		if ($params['html']) {
			// Insert prefered text editor for textarea field
			$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$toolbarset = (!$params['toolbar']) ? $module : $params['toolbar'] ;
			if (class_exists('CMS_wysiwyg_toolbar')) {
				$toolbar = CMS_wysiwyg_toolbar::getByCode($toolbarset, $cms_user);
				$value = ($toolbar->hasModulePlugins()) ? CMS_textEditor::parseInnerContent($value, $module) : $value;
			}
			$CKEditor = new CKEditor(PATH_MAIN_WR.'/ckeditor/');
			$CKEditor->returnOutput = true;
			$html .= $CKEditor->editor($fieldName, $value, array(
				'language'		=> $language->getCode(),
				'width' 		=> ($params['toolbarWidth']) ? $params['toolbarWidth'] : '100%',								// textarea width
				'height' 		=> (sensitiveIO::isPositiveInteger($params['toolbarHeight'])) ? $params['toolbarHeight'] : 200, // textarea height
				'customConfig'	=> (PATH_MAIN_WR.'/ckeditor/config.php?toolbar='.$toolbarset),
			));
		} else {
			//serialize all htmlparameters 
			$htmlParameters = $this->serializeHTMLParameters($inputParams);
			//append field id to html field parameters (if not already exists)
			$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_0"' : '';
			$width = '100%';
			if ($params['toolbarWidth']) {
				$width = (io::substr($params['toolbarWidth'], -1, 1) == '%') ? $params['toolbarWidth'] : $params['toolbarWidth'].'px';
			}
			$html .= '<textarea type="text" name="'.$fieldName.'"'.$htmlParameters.' style="width:'.$width.';height:'.((sensitiveIO::isPositiveInteger($params['toolbarHeight'])) ? $params['toolbarHeight'] : 200).'px">'.str_replace('<br />',"\n",str_replace(array("\n","\r"),"",$value)).'</textarea>'."\n";
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
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName, $new_format = false) {
		$params = $this->getParamsValues();
		if (!$params['html']) {
			//remove html characters if any then convert line breaks to <br /> tags
			$value = isset($values[$prefixName.$this->_field->getID().'_0']) ? nl2br(strip_tags(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_0']))) : '';
		} else {
			$value = CMS_textEditor::parseOuterContent($values[$prefixName.$this->_field->getID().'_0'], CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID()));
		}
		if (!$this->_subfieldValues[0]->setValue($value)) {
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
		$structure['htmlvalue'] = '';
		$structure['txtvalue'] = '';
		$structure['hasvalue'] = '';
		$structure['rawvalue'] = '';
		return $structure;
	}
	
	/**
	  * get object label : by default, the first subField value (used to designate this object in lists)
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		if (!is_object($this->_subfieldValues[0])) {
			$this->setError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		//return $this->_subfieldValues[0]->getValue();
		return $this->getValue('htmlvalue');
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
		$params = $this->getParamsValues();
		switch($name) {
			case 'label':
				return (isset($params['html']) && $params['html']) ? $this->getLabel() : io::htmlspecialchars($this->getLabel());
			break;
			case 'txtvalue':
				if (isset($params['html']) && $params['html']) {
					return strip_tags(str_replace('<br />',"\n",str_replace(array("\n","\r"),"", $this->_evalPHPContent($this->_subfieldValues[0]->getValue()))));
				} else {
					return $this->_subfieldValues[0]->getValue();
				}
			break;
			case 'htmlvalue':
			case 'value':
				//do not put an htmlspecialchars on text only value because line-breaks are auto converted to <br /> tags
				if (isset($params['html']) && $params['html']) {
					return $this->_evalPHPContent($this->_subfieldValues[0]->getValue());
				} else {
					return ($name == 'value') ? str_replace('<br />',"\n",str_replace(array("\n","\r"),"",$this->_subfieldValues[0]->getValue())) : sensitiveIO::convertTextToHTML($this->_subfieldValues[0]->getValue(), false);
				}
			break;
  	        case 'hasvalue':
				return ($this->_subfieldValues[0]->getValue()) ? true : false;
			break;
			case 'rawvalue':
				return $this->_subfieldValues[0]->getValue();
			break;
			default:
				return parent::getValue($name, $parameters);
			break;
		}
	}
	
	protected function _evalPHPContent($content) {
		//eval() the PHP code
		if ($content != '' && !function_exists((string) $content)) {
			//first, try to get all items ids to search
			$count = preg_match_all("#(<\?php|<\?).*'([0-9]*?)', '([0-9]*?)',.*\?>#Usi", $content, $matches);
			//if more than one item is found in text, it is faster to search them by one search
			if ($count > 1) {
				$ids = $GLOBALS['polymod']['preparedItems'] = array();
				//then sort all items ids by plugin ID
				foreach ($matches[2] as $key => $match) {
					$ids[$match][] = $matches[3][$key];
				}
				//then search all items
				foreach ($ids as $pluginID => $itemsIds) {
					//get plugin
					$plugin = new CMS_poly_plugin_definitions($pluginID);
					if ($plugin && is_object($plugin) && !$plugin->hasError()) {
						//then search all objects and put results in a global var usable in CMS_poly_definition_functions::pluginCode method (ugly i know)
						$GLOBALS['polymod']['preparedItems'][$plugin->getValue('objectID')] = CMS_poly_object_catalog::getAllObjects($plugin->getValue('objectID'), $this->_public, array('items' => $itemsIds), true);
					}
				}
			}
         	//then eval all php codes if any
			if (strpos($content, '<?php') !== false) {
				$content = io::evalPHPCode($content);
			}
			if (isset($GLOBALS['polymod']['preparedItems'])) {
				unset($GLOBALS['polymod']['preparedItems']);
			}
		}
		return $content;
	}
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName = '') {
		$labels = parent::getLabelsStructure($language, $objectName);
		$labels['structure']['htmlvalue'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_HTMLVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['txtvalue'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_TXTVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hasvalue'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_HASVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['like'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['!= '] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_COMPARAISON_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['in, not in '] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_ARRAY_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['any'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_ANY_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['all'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_ALL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['phrase'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_PHRASE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['beginswith'] = $language->getMessage(self::MESSAGE_OBJECT_TEXT_OPERATOR_BEGINSWITH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		
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
			'like',
			'!=',
			'=',
			'any',
			'all',
			'phrase',
			'beginswith'
		);
		$supportedOperatorForArray = array(
			'in',
			'not in',
			'any',
			'all',
		);
		
		// No operator : use default search
		if (!$operator) {
			return parent::getFieldSearchSQL($fieldID, $value, $operator, $where, $public);
		}
		// Check supported operators
		if ($operator && !in_array($operator, array_merge($supportedOperator, $supportedOperatorForArray))) {
			$this->setError("Unknown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		// Check operators for array value
		if (is_array($value) && $operator && !in_array($operator, $supportedOperatorForArray)) {
			$this->setError("Can't use this operator : ".$operator." with an array value, return empty sql");
			return '';
		}
		$statusSuffix = ($public) ? "_public":"_edited";
		$cleanedWords = array();
		if(is_array($value)){
			if(($operator == 'any') || ($operator == 'all')) {
				// in this case, we do a specific cleanup
				foreach($value as $i => $val){
					$cleanedWords[] = str_replace(array('%','_'), array('\%','\_'), $val);
					
					
				}
			}
			else {
				foreach($value as $i => $val){
					$value[$i] = "'".SensitiveIO::sanitizeSQLString($val)."'";
				}
				$value = '('.implode(',', $value).')';
			}
			
		} elseif (strtolower($value) == 'null') {
			$value = "''";
		} else {
			if(($operator == 'any') || ($operator == 'all')) {
				$words = array();
				$words = array_map("trim",array_unique(explode(" ", $value)));
				
				foreach ($words as $aWord) {
					if ($aWord && $aWord!='' && io::strlen($aWord) >= 3) {
						$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
						$cleanedWords[] = $aWord;
					}
				}
			} elseif ($operator != 'phrase' && $operator != 'beginswith') {
				// we keep this for backward compatibility, where the user can specify his search with % at the beginning / end
				$value = "'".SensitiveIO::sanitizeSQLString($value)."'";
			}
		}
		
		$whereClause = '';
		switch ($operator) {
			case 'any';
				$whereClause .= '(';
				//then add keywords
				$count='0';
				foreach ($cleanedWords as $aWord) {
					$whereClause.= ($count) ? ' or ':'';
					$count++;
					$whereClause .= "value like '%".$aWord."%'";
					if (htmlentities($aWord) != $aWord) {
						$whereClause .= " or value like '%".htmlentities($aWord)."%'";
					}
				}
				$whereClause .= ')';
			break;
			case 'all':
				$whereClause .= '(';
				//then add keywords
				$count='0';
				foreach ($cleanedWords as $aWord) {
					$whereClause.= ($count) ? ' and ':'';
					$count++;
					if (htmlentities($aWord) != $aWord) {
						$whereClause .= "(value like '%".$aWord."%' or value like '%".htmlentities($aWord)."%')";
					} else {
						$whereClause .= "value like '%".$aWord."%'";
					}
				}
				$whereClause .= ')';
			break;
			case 'phrase':
				$value = str_replace(array('%','_'), array('\%','\_'), trim($value));
				if (htmlentities($value) != $value) {
					$whereClause .= "(value like '%".$value."%' or value like '%".htmlentities($value)."%')";
				} else {
					$whereClause .= "value like '%".$value."%'";
				}
			break;
			case 'beginswith':
				$value = str_replace(array('%','_'), array('\%','\_'), trim($value));
				if (htmlentities($value) != $value) {
					$whereClause .= "(value like '".$value."%' or value like '".htmlentities($value)."%')";
				} else {
					$whereClause .= "value like '".$value."%'";
				}
			break;
			default:
				$whereClause .= " value ".$operator." ".$value;
			break;
		}
		
		$sql = "
			select
				distinct objectID
			from
				mod_subobject_text".$statusSuffix."
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and ". $whereClause. "
				$where";
		return $sql;
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
			$paramType = $aParameter['type'];
			$postedParamValue = isset($post[$prefix.$aParameter['internalName']]) ? $post[$prefix.$aParameter['internalName']] : null;
			if ($aParameter['type'] == 'boolean') {
				$params[$aParameter['internalName']] = ($postedParamValue) ? true:false;
			} else {
				$params[$aParameter['internalName']] = $postedParamValue;
			}
		}
		return $params;
	}
	
	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription() {
		return io::ellipsis(strip_tags($this->getLabel()), 500, '...', false, false);
	}
}

?>