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
// $Id: field.php,v 1.9 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_field
  * 
  * Represents a field belonging to a formular
  * Stores some field attributes, label and validation process
  * 
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_field extends CMS_grandFather {

    const MESSAGE_CMS_FORMS_FILE_PARAMS_ALLOWED_EXTENSIONS = 92;
	const MESSAGE_CMS_FORMS_FILE_PARAMS_MAX_FILESIZE = 93;
	
	/**
	 * Unique db ID
	 * @var integer
	 * @access private
	 */
	protected $_fieldID;
	
	/**
	 * CMS_forms_formular ID, this form this this field belongs to
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_formID;
	
	/**
	 * Field name
	 * 
	 * @var string
	 * @access private
	 */
	protected $_name;
	
	/**
	 * Field label
	 * 
	 * @var string
	 * @access private
	 */
	protected $_label;
	
	/**
	 * Field type (text, textarea, etc.)
	 * 
	 * @var string
	 * @access private
	 */
	protected $_type;
	
	/**
	 * Field default value, useful to be comppared to users's input
	 * 
	 * @var string
	 * @access private
	 */
	protected $_value;
	
	/**
	 * Field option, for multiple choice fields (like select or radio)
	 * 
	 * @var array
	 * @access private
	 */
	protected $_options=array();
	
	/**
	 * Which type of validation to use
	 * 
	 * @var string
	 * @access private
	 */
	protected $_dataValidation;
	
	/**
	 * is field active ?
	 * 
	 * @var boolean
	 * @access private
	 */
	protected $_active=true;
	
	/**
	 * Is this field required ?
	 * 
	 * @var boolean
	 * @access private
	 */
	protected $_required=false;
	
	/**
	 * Field order in the form
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_order;
	
	/**
	 * Params for the field
	 * 
	 * @var text
	 * @access private
	 */
	protected $_params;
	
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param integer $id
	 * @return void 
	 */
	function __construct($id = 0, $formID = false) {
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					mod_cms_forms_fields
				where
					id_fld='".$id."'
			";
			if (sensitiveIO::isPositiveInteger($formID)) {
				$sql .= " and form_fld='".$formID."' ";
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_fieldID = $id;
				if (SensitiveIO::isPositiveInteger($formID)) {
					$this->_formID = $formID;
				}
				if (SensitiveIO::isPositiveInteger($data["form_fld"])) {
					$this->_formID = $data["form_fld"];
				}
				$this->_label = $data["label_fld"];
				$this->_type = $data["type_fld"];
				$this->_options = unserialize($data["options_fld"]);
				$this->_name = $data["name_fld"];
				$this->_required = ($data["required_fld"]) ? true:false;
				$this->_active = ($data["active_fld"]) ? true:false;
				$this->_value = $data["defaultValue_fld"];
				$this->_dataValidation = $data["dataValidation_fld"];
				$this->_order = $data["order_fld"];
				$this->_params = unserialize($data["params_fld"]);
			} else {
				$this->raiseError("Unknown ID :".$id);
				/*
				if (SensitiveIO::isPositiveInteger($formID)) {
					$this->_formID = $formID;
				}
				if (SensitiveIO::isPositiveInteger($id)) {
					$this->_fieldID = $id;
				}*/
			}
		} else {
			if (SensitiveIO::isPositiveInteger($formID)) {
				$this->_formID = $formID;
			}
		}
	}
	
	/**
	  * Getter for the ID
	 * @access public
	 * @return integer
	 */
	function getID() {
		return $this->_fieldID;
	}
	
	/**
	 * Getter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name
	 * @return string
	 */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	 * Setter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name name of attribute to set
	 * @param $value , the value to give
	 */
	function setAttribute($name, $value) {
	    $name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	 * desactivate the field
	 *
	 * @access public
	 */
	function desactivate() {
		$this->_active = false;
		return true;
	}
	
	/**
	  * Writes the news into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			form_fld='".SensitiveIO::sanitizeSQLString($this->_formID)."',
			name_fld='".SensitiveIO::sanitizeSQLString($this->_name)."',
			label_fld='".SensitiveIO::sanitizeSQLString($this->_label)."',
			type_fld='".SensitiveIO::sanitizeSQLString($this->_type)."',
			dataValidation_fld='".SensitiveIO::sanitizeSQLString($this->_dataValidation)."',
			defaultValue_fld='".SensitiveIO::sanitizeSQLString($this->_value)."',
			required_fld='".SensitiveIO::sanitizeSQLString($this->_required)."',
			active_fld='".SensitiveIO::sanitizeSQLString($this->_active)."',
			order_fld='".SensitiveIO::sanitizeSQLString($this->_order)."',
			options_fld='".SensitiveIO::sanitizeSQLString(serialize($this->_options))."',
			params_fld='".SensitiveIO::sanitizeSQLString(serialize($this->_params))."'
			";
		if ($this->_fieldID) {
			$sql = "
				update
					mod_cms_forms_fields
				set
					".$sql_fields."
				where
					id_fld='".$this->_fieldID."'
			";
		} else {
			$sql = "
				insert into
					mod_cms_forms_fields
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Failed to write");
			return false;
		} elseif (!$this->_fieldID) {
			$this->_fieldID = $q->getLastInsertedID();
		}
		//then write options in a second query, (cause in the first query it cause a strange error with PDO
		/*$sql_fields = "
				options_fld=:options
		";
		$sqlParameters = array(
			'options' => serialize($this->_options),
		);
		$sql = "
			update
				mod_cms_forms_fields
			set
				".$sql_fields."
			where
				id_fld='".$this->_fieldID."'
		";
		$q = new CMS_query();
		$q->executePreparedQuery($sql, $sqlParameters);
		if ($q->hasError()) {
			$this->raiseError("Failed to write");
			return false;
		}*/
		return true;
	}
	
	/**
	 * Analyse a form xhtml code to create all CMS_forms_field and return it
	 *
	 * @access public
	 * @param string $postValues the form xhtml code to analyse and some other values like current form id
	 * @return array of CMS_forms_field objects
	 */
	function analyseForm($postValues) 
	{
		$formCode = $postValues["formCode"];
		
		//get form ID in xhtml code
		$status = preg_match('#<form[^>]* id="cms_forms_(\d*)"#iU',$formCode,$formId);
		$formId = array_map("trim",$formId);
		if( $status ) {
			$formIdXHTML = $formId[1];
		}
		//get form Id form POST
		if ($postValues["formId"]) {
			$formIdPost = $postValues["formId"];
		}
		if (isset($formIdXHTML) && isset($formIdPost) && $formIdXHTML != $formIdPost) {
			CMS_grandFather::raiseError("Can't use another form code pasted into XHTML source code");
			return false;
		} else {
			$formId = ($formIdPost) ? $formIdPost : $formIdXHTML;
		}
		if (!sensitiveIO::isPositiveInteger($formId)) {
			CMS_grandFather::raiseError("Must have a valid form ID");
			return false;
		}
		//parse form content
		$domdocument = new CMS_DOMDocument();
		try {
			$domdocument->loadXML('<html>'.$formCode.'</html>');
		} catch (DOMException $e) {
			CMS_grandFather::raiseError("Parse error : ".$e->getMessage());
			return false;
		}
		$tagLists['input'] = $domdocument->getElementsByTagName('input');
		$tagLists['textarea'] = $domdocument->getElementsByTagName('textarea');
		$tagLists['select'] = $domdocument->getElementsByTagName('select');
		$tagLists['label'] = $domdocument->getElementsByTagName('label');
		$tags = array();
		foreach ($tagLists as $tagList) {
			if ($tagList->length > 0) {
				foreach ($tagList as $aTag) {
					$tags[] = $aTag;
				}
			}
		}
		if ($tags) {
			$formTags = array();
			//then launch tags analysis
			foreach ($tags as $aTag) {
				//get field type datas and ID
				if ($aTag->tagName == 'label') {
					$fieldIDDatas = CMS_forms_field::decodeFieldIdDatas($aTag->getAttribute('for'));
					$fieldId = CMS_forms_field::extractEncodedID($aTag->getAttribute('for'));
				} else {
					$fieldIDDatas = CMS_forms_field::decodeFieldIdDatas($aTag->getAttribute('id'));
					$fieldId = CMS_forms_field::extractEncodedID($aTag->getAttribute('id'));
				}
				
				//create CMS_forms_fields objects
				if ($aTag->getAttribute('id')) {
					if (!isset($formTags[$aTag->getAttribute('id')]) || !is_a($formTags[$aTag->getAttribute('id')],"CMS_forms_field")) {
						$formTags[$aTag->getAttribute('id')] = new CMS_forms_field($fieldId,$formId);
					}
				} elseif($aTag->getAttribute('for')) {
					if (!is_a($formTags[$aTag->getAttribute('for')],"CMS_forms_field")) {
						$formTags[$aTag->getAttribute('for')] = new CMS_forms_field($fieldId,$formId);
					}
				}
				//get inputs and set CMS_forms_field object values
				if ($aTag->tagName == 'input') {
					$formTags[$aTag->getAttribute('id')]->setAttribute("name",$aTag->getAttribute('name'));
					if ($aTag->getAttribute('type') != 'checkbox') {
						$formTags[$aTag->getAttribute('id')]->setAttribute("value",$aTag->getAttribute('value'));
					} else {
						//do not update field value for checkbox
					}
					if ($aTag->getAttribute('type') == 'text' || !$aTag->getAttribute('type')) {
						if (in_array('email',$fieldIDDatas)) {
							$formTags[$aTag->getAttribute('id')]->setAttribute("type",'email');
						} elseif (in_array('integer',$fieldIDDatas)) {
							$formTags[$aTag->getAttribute('id')]->setAttribute("type",'integer');
						} elseif (in_array('url',$fieldIDDatas)) {
							$formTags[$aTag->getAttribute('id')]->setAttribute("type",'url');
						} else {
							$formTags[$aTag->getAttribute('id')]->setAttribute("type",$aTag->getAttribute('type'));
						}
					} elseif ($aTag->getAttribute('type') == 'submit') {
						$formTags[$aTag->getAttribute('id')]->setAttribute("label",$aTag->getAttribute('value'));
						$formTags[$aTag->getAttribute('id')]->setAttribute("type",$aTag->getAttribute('type'));
					}  elseif ($aTag->getAttribute('type') == 'password') {
						$formTags[$aTag->getAttribute('id')]->setAttribute("type",'pass');
					} else {
						$formTags[$aTag->getAttribute('id')]->setAttribute("type",$aTag->getAttribute('type'));
					}
				} elseif ($aTag->tagName == 'textarea') {
					$formTags[$aTag->getAttribute('id')]->setAttribute("name",$aTag->getAttribute('name'));
					$formTags[$aTag->getAttribute('id')]->setAttribute("type",'textarea');
					$formTags[$aTag->getAttribute('id')]->setAttribute("value",CMS_DOMDocument::DOMElementToString($aTag, true));
					
				} elseif ($aTag->tagName == 'select') {
					$formTags[$aTag->getAttribute('id')]->setAttribute("name",$aTag->getAttribute('name'));
					$formTags[$aTag->getAttribute('id')]->setAttribute("type",'select');
					$optionTags = $aTag->getElementsByTagName('option');
					$options = array();
					foreach ($optionTags as $anOptionTag) {
						$options[$anOptionTag->getAttribute('value')] = CMS_DOMDocument::DOMElementToString($anOptionTag, true);
						if ($anOptionTag->getAttribute('selected') == 'selected') {
							$formTags[$aTag->getAttribute('id')]->setAttribute("value",$anOptionTag->getAttribute('value'));
						}
					}
					$formTags[$aTag->getAttribute('id')]->setAttribute("options",$options);
					
				} elseif ($aTag->tagName == 'label') {
					$formTags[$aTag->getAttribute('for')]->setAttribute("label", str_replace("\n", "", CMS_DOMDocument::DOMElementToString($aTag, true)));
				}
				//is field required ?
				if (in_array('req',$fieldIDDatas)) {
					if ($aTag->tagName == 'label') {
						$formTags[$aTag->getAttribute('for')]->setAttribute('required',true);
					} else {
						$formTags[$aTag->getAttribute('id')]->setAttribute('required',true);
					}
				}
			}
		}
		if($formTags){
		    foreach ($formTags as $field) {
			    $field->writeToPersistence();
		    }
		}
		//add form object
		$formTags = array();
		$formTags['form'] = new CMS_forms_formular($formId);
		
		//compare DB form fields if any and add missing ones
		$dbFields = $formTags['form']->getFields(true);
		foreach ($formTags as $formTag) {
			if (is_a($formTag, 'CMS_forms_field') && in_array($formTag->getID(), array_keys($dbFields))) {
				unset($dbFields[$formTag->getID()]);
			}
		}
		if ($dbFields) {
			foreach($dbFields as $field) {
				$formTags[$field->generateFieldIdDatas()] = $field;
			}
		}
		return $formTags;
	}
	
	/**
	 * Analyse an array of field id datas and return the CMS_forms_field DB id associated
	 *
	 * @access private
	 * @param string $fieldIDDatas the encoded field id datas to analyse
	 * @return integer the field id found
	 */
	function extractEncodedID($fieldIDDatas) {
		$fieldIDDatas = CMS_forms_field::decodeFieldIdDatas($fieldIDDatas);
		$id = false;
		if (is_array($fieldIDDatas)) {
			foreach($fieldIDDatas as $anIDData) {
				$id = (sensitiveIO::isPositiveInteger($anIDData)) ? $anIDData : $id;
			}
		}
		if (!$id) {
			if (is_object($this)) {
				$this->raiseError("No positive integer id found");
				return false;
			} else {
				CMS_grandFather::raiseError("No positive integer id found");
				return false;
			}
		}
		return $id;
	}
	
	/**
	 * Analyse a CMS_forms_field object then create a xhtml identifier for it
	 *
	 * @access public
	 * @param CMS_forms_field $fieldObject the object to analyse
	 * @return string base64 encoded xhtml identifier
	 */
	function generateFieldIdDatas() {
		if (!$this->getID()) {
			$this->raiseError("Field need an id");
			return false;
		}
		
		$identifier = 'cms_field_'.$this->getID();
		$identifier .= ($this->getAttribute('type') == 'email') ? '_email':'';
		$identifier .= ($this->getAttribute('type') == 'integer') ? '_integer':'';
		$identifier .= ($this->getAttribute('type') == 'url') ? '_url':'';
		$identifier .= ($this->getAttribute('type') == 'pass') ? '_pass':'';
		$identifier .= ($this->getAttribute('required')) ? '_req':'';
		$identifier = rtrim(base64_encode($identifier), '=');
		return 'z'.$identifier;
	}
	
	/**
	 * Analyse an xhtml identifier for a CMS_forms_field object then return decoded datas
	 *
	 * @access public
	 * @param string $datas base64 encoded xhtml identifier
	 * @return array : decoded datas
	 */
	function decodeFieldIdDatas($datas) {
		return explode('_',base64_decode(io::substr($datas,1)));
	}
	
	/**
	 * Get all form fields
	 * 
	 * @param integer $formID : the form id for wanted fields
	 * @param boolean $outputobjects : return array of CMS_forms_field instead of array of ids (default : false)
	 * @param boolean $withDesactivedFields : add desactived fields to returned list (default : false)
	 * @access public
	 * @return array of CMS_forms_field
	 */
	function getAll($formID, $outputobjects = false, $withDesactivedFields = false) {
		if (!sensitiveIO::isPositiveInteger($formID)) {
			$this->raiseError("FormID must be a positive integer : ".$formID);
			return false;
		}
		$sql = "
			select
				id_fld as id
			from
				mod_cms_forms_fields
			where
				form_fld='".$formID."'
		";
		if (!$withDesactivedFields) {
			$sql .= " and active_fld = '1'";
		}
		$sql .= " order by order_fld asc";
		$q = new CMS_query($sql);
		$return = array();
		while ($id = $q->getValue('id')) {
			if ($outputobjects) {
				$return[$id] = new CMS_forms_field($id);
			} else {
				$return[$id] = $id;
			}
		}
		
		return $return;
	}
	
	/**
	 * Get field XHTML
	 * 
	 * @param CMS_language $formLanguage : the language for messages
	 * @return array array(label, input)
	 */
	function getFieldXHTML($formLanguage = '') {
	    // Language
	    global $cms_language;
	    if(!$formLanguage){
	        $formLanguage = $cms_language;
	    }
		//generate field id datas
		$fieldIDDatas = $this->generateFieldIdDatas();
		$input = $label = '';
		switch ($this->getAttribute("type")) {
			case 'fieldset':
				$label = $this->getAttribute("label");
				$input = '';
			break;
			case 'hidden':
				$input = '<input type="hidden" value="'.io::htmlspecialchars($this->getAttribute("value")).'" id="'.$fieldIDDatas.'" name="'.$this->getAttribute("name").'" />';
			break;
			case 'select':
				$label = '<label for="'.$fieldIDDatas.'">'.$this->getAttribute("label").'</label>';
				$input = '<select name="'.$this->getAttribute("name").'" id="'.$fieldIDDatas.'">';
				$options = $this->getAttribute("options");
				if (sizeof($options)) {
					foreach ($options as $aValue => $anOption) {
						$selected = ($this->getAttribute("value") == $aValue) ? ' selected="selected"':'';
						$input .= '<option value="'.$aValue.'"'.$selected.'>'.$anOption.'</option>';
					}
				}
				$input .= '</select>';
			break;
			case 'text':
			case 'email':
			case 'url':
			case 'integer':
			case 'file':
			case 'pass':
			case 'checkbox':
				$label = '<label for="'.$fieldIDDatas.'">'.$this->getAttribute("label").'</label>';
				$input = '<input';
				$fileHelp = '';
				switch ($this->getAttribute("type")) {
					case 'file':
						$input .= ' type="file"';
						$fileParams = $this->getAttribute("params");
						$fileHelpTab = array();
						if($fileParams){
						    foreach($fileParams as $fileParamName => $fileParamValue){
						        switch($fileParamName){
						            case 'extensions':
						                $fileHelpTab['extensions'] = $formLanguage->getMessage(self::MESSAGE_CMS_FORMS_FILE_PARAMS_ALLOWED_EXTENSIONS, false, MOD_CMS_FORMS_CODENAME).' '.$fileParamValue;
						            break;
						            case 'weight':
						                $fileHelpTab['weight'] = $formLanguage->getMessage(self::MESSAGE_CMS_FORMS_FILE_PARAMS_MAX_FILESIZE, false, MOD_CMS_FORMS_CODENAME).' '.$fileParamValue. 'Ko';
						            break;
						        }
						    }
						}
						if(!isset($fileHelpTab['weight'])){
						    $fileHelpTab['weight'] = $formLanguage->getMessage(self::MESSAGE_CMS_FORMS_FILE_PARAMS_MAX_FILESIZE, false, MOD_CMS_FORMS_CODENAME).' '.CMS_file::getMaxUploadFileSize('K'). 'Ko';
						}
						if($fileHelpTab){
						    $fileHelp = '<br/>('.implode(' ; ', $fileHelpTab).')';
						}
					break;
					case 'pass':
						$input .= ' type="password" value=""';
					break;
					case 'checkbox':
						$input .= ' type="checkbox" value="1" class="checkbox" '.($this->getAttribute("value") ? ' checked="checked"' : '');
					break;
					case 'text':
					case 'email':
					case 'url':
					case 'integer':
					default:
						$input .= ' type="text" value="'.io::htmlspecialchars($this->getAttribute("value")).'"';
					break;
				}
				$fileHelp = ($fileHelp) ? ' <span class="inputHelp">'.$fileHelp.'</span>' : '';
				$input .= ' id="'.$fieldIDDatas.'" name="'.$this->getAttribute("name").'" />'.$fileHelp;
			break;
			case 'submit':
				$input = '<input id="'.$fieldIDDatas.'" type="submit" class="button" name="'.$this->getAttribute("name").'" value="'.$this->getAttribute("label").'" />';
			break;
			case 'textarea':
				$label = '<label for="'.$fieldIDDatas.'">'.$this->getAttribute("label").'</label>';
				$input = '<textarea cols="40" rows="6" id="'.$fieldIDDatas.'" name="'.$this->getAttribute("name").'">'.io::htmlspecialchars($this->getAttribute("value")).'</textarea>';
			break;
		}
		return array($label, $input);
	}
}
?>
