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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: form.php,v 1.7 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_formular
  *
  * @package Automne
  * @subpackage cms_forms
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_formular extends CMS_grandFather {
	const MESSAGE_CMS_FORMS_SUBMIT_NOT_ALLOWED = 83;
	const MESSAGE_CMS_FORMS_EMAIL_SUBJECT = 69;
	const MESSAGE_CMS_FORMS_MALFORMED_FIELDS = 68;
	const MESSAGE_CMS_FORMS_REQUIRED_FIELDS = 67;
	const MESSAGE_CMS_FORMS_TOKEN_EXPIRED = 91;
	
	const ALLOW_FORM_SUBMIT = 1;
	const REMOVE_FORM_SUBMIT = 0;
	/**
	 * Unique db ID
	 * @var integer
	 * @access private
	 */
	protected $_formID;

	/**
	 * Integer corresponding to cms_profile_user ID known as media owner
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_ownerID;

	/**
	 * 
	 * @var CMS_language
	 * @access private
	 */
	protected $_language;
	
	/**
	 * Form name
	 * @var string
	 * @access private
	 */
	protected $_name;
	
	/**
	 * Full XHTML source
	 * @var string
	 * @access private
	 */
	protected $_source;
	
	/**
	 * Public means form can receive data
	 * @var boolean
	 * @access private
	 */
	protected $_public;
	
	/**
	 * Max number of responses per user for this form
	 * @var integer
	 * @access private
	 */
	protected $_responses ;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param integer $id 
	 * @param boolean $public if only public data to retrieve
	 * @param CMS_profile_user $cms_user 
	 */
	function __construct($id, $cms_user = false) {
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					mod_cms_forms_formulars
				where
					id_frm='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_formID = $id;
				$this->_name = $data["name_frm"];
				$this->_source = $data["source_frm"];
				$this->_public = ($data["closed_frm"] > 0) ? false : true ;
				// Form creator
				$this->_ownerID = (int) $data["owner_frm"];
				$this->_language = new CMS_language($data["language_frm"]);
				$this->_responses = (int) $data["responses_frm"];
				
			} else {
				$this->raiseError("Unknown ID :".$id);
			}
		} else {
			$this->_public = true;
			if (is_a($cms_user, 'CMS_profile_user')) {
				$this->_ownerID = $cms_user->getID();
			}
			$this->_language = CMS_languagesCatalog::getDefaultLanguage();
		}
	}
	
	/**
	 * This label is only used when printign resources in workflow tables
	 * 
	 * @access public
	 * @return string
	 */
	function getValidationLabel() {
		return (string) $this->getAttribute("name");
	}
	
	/**
	  * Getter for the ID
	 * @access public
	 * @return integer
	 */
	function getID() {
		return $this->_formID;
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
	 * Get the language
	 * 
	 * @access public
	 * @return CMS_language
	 */
	function &getLanguage() {
		return $this->_language;
	}
	
	/**
	 * @access public
	 * @param  $language 
	 * @return CMS_language
	 */
	function setLanguage($language) {
		$this->_language = $language;
		return true;
	}
	
	/**
	 * Is form pubic ?
	 *
	 * @access public
	 * @return boolean
	 */
	function isPublic() {
		return ($this->_public) ? true : false;
	}
	
	/**
	 * Get the resource's owner
	 * 
	 * @access public
	 * @return CMS_profile_user, or null if none found
	 */
	function getOwner() {
		if ($this->_ownerID > 0) {
			return CMS_profile_usersCatalog::getByID($this->_ownerID);
		} else {
			return null;
		}
	}
	
	/**
	 * Get the CMS_forms_formularCategories object representing
	 * relations between this object and modules categories
	 * 
	 * @access public
	 * @return CMS_forms_formularCategories
	 */
	function getCategories() {
		if ($this->getID() > 0) {
			return new CMS_forms_formularCategories($this);
		} else {
			return null;
		}
	}
	
	/**
	 * Get content for this formular means a PHP/XHTML source code executable
	 * representing full working form
	 * 
	 * @param constant $actionParams : add some params to form execution (default : false, return form just as it is in db)
	 *  - self::REMOVE_FORM_SUBMIT : form can't be submitted, throw js alert message
	 *  - self::ALLOW_FORM_SUBMIT : form can be submitted, add form action, hidden fields, selected values, etc. (used in public mode)
	 * @param array $fieldsError : add an array of error fields' id
	 * @access public
	 * @return XHTML string
	 */
	function getContent($actionParams = false, $fieldsError = array()) {
		global $cms_language;
		if ($actionParams === false) {
			return $this->_source;
		}
		$source = $this->_source;
		switch ($actionParams) {
			case self::REMOVE_FORM_SUBMIT:
				//disable submit with javascript
				$source = str_replace('<form ', '<form onsubmit="alert(\''.addslashes($cms_language->getMessage(self::MESSAGE_CMS_FORMS_SUBMIT_NOT_ALLOWED, false, MOD_CMS_FORMS_CODENAME)).'\');return false;" ', $source);
			break;
			case self::ALLOW_FORM_SUBMIT :
				//get fields
				$fields = $this->getFields(true);
				$referer = isset($_REQUEST['referer']) ? sensitiveIO::sanitizeHTMLString($_REQUEST['referer']) : null;
				//and add already selected values (from $_POST global values)
				//$xml2Array = new CMS_xml2Array(str_replace('&', '&amp;',io::decodeEntities($source)));
				$xml2Array = new CMS_xml2Array($source, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
				//parse XHTML form content
				$xmlArray = $xml2Array->getParsedArray();
				//add already selected values
				$this->_fillSelectedFormValues($xmlArray, $fields, $fieldsError);
				//then convert back into XHTML
				$source = $xml2Array->toXML($xmlArray);
				//add target and hidden fields
				$source = preg_replace('#<form([^>]+)>#U', 
				'<form action="'.$_SERVER["SCRIPT_NAME"].(isset($_SERVER['QUERY_STRING']) ? '?'.sensitiveIO::sanitizeHTMLString($_SERVER['QUERY_STRING']) : '').'#formAnchor'.$this->getID().'" method="post" enctype="multipart/form-data"\1>'."\n".
				'<input type="hidden" name="cms_action" value="validate" />'."\n".
				'<input type="hidden" name="atm-token" value="'.CMS_session::getToken(MOD_CMS_FORMS_CODENAME).'" />'."\n".
				'<input type="hidden" name="formID" value="'.$this->getID().'" />'."\n".
				'<input type="hidden" name="referer" value="'.$referer.'" />'."\n"
				, $source);
				//pr(io::htmlspecialchars($source));
			break;
		}
		$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);
		if($cms_module->getParameters("output")=='clean'){
			//replace fieldset tags and legende tags
			$source = 	preg_replace('#<fieldset>#', '</fieldset><fieldset>',
						preg_replace('#<tr class="fieldset">(.*)</tr>#siU', '<fieldset><legend>$1</legend>', $source, -1, $count_replace));
			//delete tags from table, add div tag between fields
			$source = 	preg_replace('#<table([^>]+)>#U', '',
						str_replace(array('</table>', '<tbody>', '</tbody>', '<td>', '</td>', '<tr>', '</tr>', '&#160;'), array('', '', '', '', '', '<div>', '</div>', ''),
						preg_replace('#<td([^>]+)>#U', '',$source)));
			// Close last fieldset
			if(isset($count_replace)){
				$temp_source=explode('<div>', $source);
				$temp_source[(count($temp_source)-2)].='</fieldset>';
				$source = preg_replace('#</fieldset>#', '', implode('<div>', $temp_source), 1);
			}
		}
		return $source;
	}
	
	/**
	 * Recursive method to add all selected values into a multidimentionnal array representing a formular source
	 * 
	 * @param multidimentionnal array &$definition : the XML definition to treat (by reference)
	 * @param array $fields : all form fields to get default values
	 * @param array $fieldsError : all form fields malformed or required
	 * @param (inplicit) the current global $_POST values
	 * @access private
	 * @return void
	 */
	protected function _fillSelectedFormValues(&$definition, $fields, $fieldsError) {
		global $mod_cms_forms, $cms_user;
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				$fieldValue = null;
				if (isset($definition[$key]['attributes']['name'])) {
					if (in_array($definition[$key]['attributes']['id'], $fieldsError)){ //set class cms_field_error to field
						$definition[$key]['attributes']['class'] = 'cms_field_error';
					}
					if (isset($_POST[$definition[$key]['attributes']['name']])) { //set value from POST
						$fieldValue = $_POST[$definition[$key]['attributes']['name']];
					} else { //set value from default field value
						foreach ($fields as $field) {
							if ($field->getAttribute('name') == $definition[$key]['attributes']['name'] && $field->getAttribute('value')) {
								//set current page ID as a parameter
								$parameters['pageID'] = sensitiveIO::isPositiveInteger($mod_cms_forms['pageID']) ? $mod_cms_forms['pageID'] : 1;
								//evaluate default value if needed
								$fieldValue = eval(sensitiveIO::sanitizeExecCommand('return "'.CMS_polymod_definition_parsing::preReplaceVars($field->getAttribute('value')).'";'));
							}
						}
					}
				}
				if (isset($definition[$key]['nodename']) && $definition[$key]['nodename'] == 'input' && $definition[$key]['attributes']['type'] == 'file') {
					unset($definition[$key]['attributes']['value']);
				}
				if (isset($fieldValue)) {
					switch ($definition[$key]['nodename']) {
						case 'select':
							foreach (array_keys($definition[$key]['childrens']) as $optionKey) {
								if (isset($definition[$key]['childrens'][$optionKey]['attributes']['value']) && $definition[$key]['childrens'][$optionKey]['attributes']['value'] == $fieldValue) {
									$definition[$key]['childrens'][$optionKey]['attributes']['selected'] = 'selected';
								}
							}
						break;
						case 'textarea':
							$definition[$key]['childrens']['0']['textnode'] = sensitiveIO::sanitizeHTMLString($fieldValue);
						break;
						case 'input':
							if ($definition[$key]['attributes']['type'] == 'text' || $definition[$key]['attributes']['type'] == 'hidden') {
								$definition[$key]['attributes']['value'] = sensitiveIO::sanitizeHTMLString($fieldValue);
							} elseif($definition[$key]['attributes']['type'] == 'checkbox') {
								$definition[$key]['attributes']['checked'] = 'checked';
							}
						break;
					}
				}
				if (isset($definition[$key]['childrens'])) {
					$this->_fillSelectedFormValues($definition[$key]['childrens'], $fields, $fieldsError);
				}
			}
		} else {
			$this->raiseError("Malformed definition to compute : ".print_r($definition, true));
			return false;
		}
	}
	
	/**
	 * Check all input tags in XHTML source (cause IE sometimes remove input type values)
	 * 
	 * @param string $source, the xhtml source to check
	 * @access public
	 * @return string, the xhtml source checked
	 */
	function checkInputs($source) {
		//and add already selected values (from $_POST global values)
		$replace = array(
			'&' => '&amp;'
		);
		$xml2Array = new CMS_xml2Array($source, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
		//parse XHTML form content
		$xmlArray = $xml2Array->getParsedArray();
		//add already selected values
		$this->_checkInputs($xmlArray);
		//then convert back into XHTML
		$source = $xml2Array->toXML($xmlArray);
		return $source;
	}
	
	/**
	 * Recursive method to check all input tags in XHTML source (cause IE sometimes remove input type values)
	 * 
	 * @param multidimentionnal array &definition : the XML definition to treat (by reference)
	 * @access private
	 * @return void
	 */
	protected function _checkInputs(&$definition) {
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if ($definition[$key]['nodename'] == 'input') {
					if (!$definition[$key]['attributes']['type']) {
						$definition[$key]['attributes']['type'] = 'text';
					}
				}
				if (is_array($definition[$key]) && sizeof($definition[$key]['childrens'])) {
					$this->_checkInputs($definition[$key]['childrens']);
				}
			}
		} else {
			$this->raiseError("Malformed definition to compute : ".print_r($definition, true));
			return false;
		}
	}
	
	/**
	 * Replace field in form code
	 * 
	 * @param string $source, the xhtml source to check
	 * @param CMS_forms_field $field, the field to replace
	 * @access public
	 * @return string, the xhtml source checked
	 */
	function replaceField($source, $field) {
		//and add already selected values (from $_POST global values)
		$replace = array(
			'&' => '&amp;'
		);
		$xml2Array = new CMS_xml2Array($source, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
		//parse XHTML form content
		$xmlArray = $xml2Array->getParsedArray();
		//replace field
		$this->_replaceField($xmlArray, $field);
		//add already selected values
		$this->_checkInputs($xmlArray);
		//then convert back into XHTML
		$source = $xml2Array->toXML($xmlArray);
		return $source;
	}
	/**
	 * Recursive method to replace input tags in XHTML source
	 * 
	 * @param multidimentionnal array &definition : the XML definition to treat (by reference)
	 * @param CMS_forms_field $field, the field to replace
	 * @access private
	 * @return void
	 */
	protected function _replaceField(&$definition, &$field) {
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if (in_array($definition[$key]['nodename'], array('input', 'textarea', 'select')) && isset($definition[$key]['attributes']['id'])) {
					$fieldId = CMS_forms_field::extractEncodedID($definition[$key]['attributes']['id']);
					if (sensitiveIO::isPositiveInteger($fieldId) && $field->getID() == $fieldId) {
						//recreate XHTML code for field
						list($label, $input) = $field->getFieldXHTML($this->_language);
						$replace = array(
							'&' => '&amp;'
						);
						//transform XHTML code to XML definition
						$xmlArray = new CMS_xml2Array($input, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
						//then replace field definition into current definition tag
						$fieldDefinition = $xmlArray->getParsedArray();
						// Default : add the first tag
					    $definition[$key] = $fieldDefinition[0];
					    // Check other tags
					    if($fieldDefinition){
					        foreach($fieldDefinition as $subFieldTagKey => $subFieldTag){
					            if(isset($subFieldTag['attributes']['class']) && $subFieldTag['attributes']['class'] == 'inputHelp'){
					                $definition[] = $subFieldTag;
					            }
					        }
					    }
					}
				} elseif ($definition[$key]['nodename'] == 'label' && isset($definition[$key]['attributes']['for'])) {
					$fieldId = CMS_forms_field::extractEncodedID($definition[$key]['attributes']['for']);
					if (sensitiveIO::isPositiveInteger($fieldId) && $field->getID() == $fieldId) {
						//recreate encoded id
						$definition[$key]['attributes']['for'] = $field->generateFieldIdDatas();
						//remove old text node
						unset($definition[$key]['childrens']);
						//set new text node
						$definition[$key]['childrens'][0]['textnode'] = $field->getAttribute('label');
					}
				}
				if (is_array($definition[$key]) && sizeof($definition[$key]['childrens'])) {
					$this->_replaceField($definition[$key]['childrens'], $field);
				}
			}
		} else {
			$this->raiseError("Malformed definition to compute : ".print_r($definition, true));
			return false;
		}
	}
	
	/**
	 * Add a field in form code
	 * 
	 * @param string $source, the xhtml source to check
	 * @param CMS_forms_field $field, the field to replace
	 * @access public
	 * @return string, the xhtml source checked
	 */
	function addField($source, $field) {
		//and add already selected values (from $_POST global values)
		$replace = array(
			'&' => '&amp;'
		);
		$xml2Array = new CMS_xml2Array($source, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
		//parse XHTML form content
		$xmlArray = $xml2Array->getParsedArray();
		//replace field
		$this->_addField($xmlArray, $field);
		//add already selected values
		$this->_checkInputs($xmlArray);
		//then convert back into XHTML
		$source = $xml2Array->toXML($xmlArray);
		return $source;
	}
	/**
	 * Recursive method to add input tags in XHTML source
	 * 
	 * @param multidimentionnal array &definition : the XML definition to treat (by reference)
	 * @param CMS_forms_field $field, the field to replace
	 * @access private
	 * @return void
	 */
	protected function _addField(&$definition, &$field) {
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if (isset($definition[$key]['textnode']) && $definition[$key]['textnode'] == '{{field}}') {
					//recreate XHTML code for field
					list($label, $input) = $field->getFieldXHTML($this->_language);
					$replace = array(
						'&' => '&amp;'
					);
					//transform XHTML code to XML definition
					$xmlArray = new CMS_xml2Array($input, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
					//then replace field definition into current definition tag
					$fieldDefinition = $xmlArray->getParsedArray();
					// Default : add the first tag
					$definition[$key] = $fieldDefinition[0];
					// Check other tags
					if($fieldDefinition){
					    foreach($fieldDefinition as $subFieldTagKey => $subFieldTag){
					        if(isset($subFieldTag['attributes']['class']) && $subFieldTag['attributes']['class'] == 'inputHelp'){
					            $definition[] = $subFieldTag;
					        }
					    }
					}
					$definition[$key] = $fieldDefinition[0];
				} elseif (isset($definition[$key]['textnode']) &&  $definition[$key]['textnode'] == '{{label}}') {
					//recreate XHTML code for field
					list($label, $input) = $field->getFieldXHTML($this->_language);
					$replace = array(
						'&' => '&amp;'
					);
					//transform XHTML code to XML definition
					$xmlArray = new CMS_xml2Array($label, CMS_xml2Array::XML_ENCLOSE | CMS_xml2Array::XML_PROTECT_ENTITIES);
					//then replace field definition into current definition tag
					$fieldDefinition = $xmlArray->getParsedArray();
					$definition[$key] = $fieldDefinition[0];
				}
				if (is_array($definition[$key]) && sizeof($definition[$key]['childrens'])) {
					$this->_addField($definition[$key]['childrens'], $field);
				}
			}
		} else {
			$this->raiseError("Malformed definition to compute : ".print_r($definition, true));
			return false;
		}
	}
	
	
	/**
	 * Totally destroys references to this formular and all its records
	 * @return boolean true on success, false on failure
	 * @access public
	 */
	function destroy() {
		
		if (!$this->getID()) {
			return false;
		}
		
		$err = false;
		// Destroy sendings
		$sql = "
			delete
				mod_cms_forms_senders.*
			from
				mod_cms_forms_fields,
				mod_cms_forms_records,
				mod_cms_forms_senders
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
				and sending_rec = id_snd
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$err += 1;
		}
		
		// Destroy records
		$sql = "
			delete
				mod_cms_forms_records.*
			from
				mod_cms_forms_fields,
				mod_cms_forms_records
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$err += 2;
		}
		// Destroy fields
		$sql = "
			delete
				mod_cms_forms_fields.*
			from
				mod_cms_forms_fields
			where
				form_fld = '".$this->getID()."'
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$err += 4;
		}
		
		// Destroy category relations
		$sql = "
			delete
			from
				mod_cms_forms_categories
			where
				form_fca='".$this->getID()."'
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$err += 8;
		}
		
		// Destroy form itself
		$sql = "
			delete
			from
				mod_cms_forms_formulars
			where
				id_frm='".$this->getID()."'
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$err += 16;
		}
		if ($err) {
			$this->raiseError("Failed to delete form. ID : ".$this->getID().". Error code : ".$err);
			return false;
		}
		unset($this);
		return (!$err) ? true : false;
	}
	
	/**
	  * Writes the news into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		//save data
		$closed = ($this->_public === true) ? 0 : 1 ;
		$sql_fields = "
			owner_frm='".$this->_ownerID."',
			language_frm='".SensitiveIO::sanitizeSQLString($this->_language->getCode())."',
			name_frm='".SensitiveIO::sanitizeSQLString($this->_name)."',
			source_frm='".SensitiveIO::sanitizeSQLString($this->_source)."',
			responses_frm='".SensitiveIO::sanitizeSQLString($this->_responses)."',
			closed_frm='".$closed ."'";
		if ($this->_formID) {
			$sql = "
				update
					mod_cms_forms_formulars
				set
					".$sql_fields."
				where
					id_frm='".$this->_formID."'
			";
		} else {
			$sql = "
				insert into
					mod_cms_forms_formulars
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Failed to write");
			return false;
		} elseif (!$this->_formID) {
			$this->_formID = $q->getLastInsertedID();
		}
		//then create the 4 defaut actions for this form if hasn't any
		if (!$this->hasActions()) {
			//Form answer excedeed
			$alreadyFoldAction = new CMS_forms_action();
			$alreadyFoldAction->setInteger("form",$this->_formID);
			$alreadyFoldAction->setInteger("type",CMS_forms_action::ACTION_ALREADY_FOLD);
			$alreadyFoldAction->setString("value",'text');
			$alreadyFoldAction->writeToPersistence();
			
			//Save form results in DB
			$dbAction = new CMS_forms_action();
			$dbAction->setInteger("form",$this->_formID);
			$dbAction->setInteger("type",CMS_forms_action::ACTION_DB);
			$dbAction->writeToPersistence();
			
			//form OK
			$okAction = new CMS_forms_action();
			$okAction->setInteger("form",$this->_formID);
			$okAction->setInteger("type",CMS_forms_action::ACTION_FORMOK);
			$okAction->setString("value",'text');
			$okAction->writeToPersistence();
			
			//form NOK
			$nokAction = new CMS_forms_action();
			$nokAction->setInteger("form",$this->_formID);
			$nokAction->setInteger("type",CMS_forms_action::ACTION_FORMNOK);
			$nokAction->setString("value",'text');
			$nokAction->writeToPersistence();
		}
		return true;
	}
	
	/**
	 * This form has actions attached to it ?
	 * 
	 * @access public
	 * @return boolean
	 */
	function hasActions() {
		$tmp = new CMS_forms_action();
		return (sizeof($tmp->getAll($this->getID()))) ? true : false;
	}
	
	/**
	 * Get all form actions
	 * 
	 * @access public
	 * @return array of CMS_forms_action
	 */
	function getActions() {
		$tmp = new CMS_forms_action();
		return $tmp->getAll($this->getID(), true);
	}
	
	/**
	 * Get all actions of a given type
	 * 
	 * @access public
	 * @return array of CMS_forms_action
	 */
	function getActionsByType($actionType) {
		$tmp = new CMS_forms_action();
		return $tmp->getAll($this->getID(), true, $actionType);
	}
	
	/**
	 * Is form already folded by sender
	 * 
	 * @access public
	 * @return array of CMS_forms_action
	 */
	function isAlreadyFolded($sender) {
		if (!is_a($sender, 'CMS_forms_sender')) {
			$sender = CMS_forms_sender::getSenderForContext();
		}
		//get number of responses for sender for this form
		if (!$this->getAttribute('responses')) {
			return false;
		} else {
			//get count of responses for sender
			$sql = "
				select
					distinct id_snd
				from
					mod_cms_forms_fields,
					mod_cms_forms_records,
					mod_cms_forms_senders
				where
					form_fld = '".$this->getID()."'
					and id_fld = field_rec
					and sending_rec = id_snd 
					and sessionID_snd = '".sensitiveIO::sanitizeSQLString($sender->getAttribute('sessionID'))."'
			";
			$q = new CMS_query($sql);
			return ($q->getNumRows() >= $this->getAttribute('responses'));
		}
	}
	
	/**
	 * Get all form fields
	 * 
	 * @param boolean $outputobjects : return array of CMS_forms_field instead of array of ids (default : false)
	 * @param boolean $withDesactivedFields : add desactived fields to returned list (default : false)
	 * @access public
	 * @return array of CMS_forms_field
	 */
	function getFields($outputobjects = false, $withDesactivedFields = false) {
		return CMS_forms_field::getAll($this->getID(), $outputobjects, $withDesactivedFields);
	}
	
	/**
	 * Get form field by it's name
	 * 
	 * @param string $fieldName : the form field name to get
	 * @param boolean $outputobjects : return array of CMS_forms_field instead of array of ids (default : false)
	 * @param boolean $withDesactivedFields : add desactived fields to returned list (default : false)
	 * @access public
	 * @return array of CMS_forms_field
	 */
	function getFieldByName($fieldName, $outputobjects = false, $withDesactivedFields = false) {
		$sql = "
			select
				id_fld as id
			from
				mod_cms_forms_fields
			where
				form_fld='".$this->getID()."'
				and name_fld='".sensitiveIO::sanitizeSQLString($fieldName)."'
		";
		if (!$withDesactivedFields) {
			$sql .= " and active_fld = '1'";
		}
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			if ($outputobjects) {
				return new CMS_forms_field($q->getValue('id'));
			} else {
				return $q->getValue('id');
			}
		}
	}
	
	/**
	 * Get form field by it's id
	 * 
	 * @param string $fieldId : the form field id to get
	 * @return CMS_forms_field or false if none found
	 * @access public
	 */
	function getFieldById($fieldId) {
		$field = new CMS_forms_field($fieldId, $this->getID());
		if (!$field->hasError()) {
			return $field;
		}
		$this->raiseError('Can\'t find field ID '.$fieldId.' for current form ...');
		return false;
	}
	
	/**
	 * This form has records attached to it ?
	 * 
	 * @access public
	 * @return boolean
	 */
	function hasRecords() {
		$sql = "
			select
				1
			from
				mod_cms_forms_fields,
				mod_cms_forms_records
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true : false;
	}
	
	/**
	 * Get all form records datas
	 * 
	 * @param boolean $withDesactivedFields : add desactived fields to returned result (default : false)
	 * @access public
	 * @return multidimentionnal array
	 */
	function getAllRecordDatas($withDesactivedFields = false, $withDate = false) {
		$sql = "
			select
				field_rec,
				value_rec,
				sending_rec";
		if ($withDate) {
			$sql .= ", dateInserted_snd";
		}
		$sql .= "
			from
				mod_cms_forms_fields,
				mod_cms_forms_records";
		if ($withDate) {
			$sql .= ", mod_cms_forms_senders";
		}
		$sql .= "
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
				and type_fld != 'submit'
			";
		if ($withDate) {
			$sql .= " and id_snd = sending_rec";
		}
		if (!$withDesactivedFields) {
			$sql .= " and active_fld = '1' ";
		}
		$sql .= "
			order by
				sending_rec,
				order_fld
		";
		$q = new CMS_query($sql);
		$result = array();
		while($r = $q->getArray()) {
			if ($withDate) {
				$result[$r['sending_rec']][0] = $r['dateInserted_snd'];
			}
			$result[$r['sending_rec']][$r['field_rec']] = $r['value_rec'];
		}
		return $result;
	}
	
	/**
	 * Delete all form records
	 * 
	 * @access public
	 * @return boolean
	 */
	function resetRecords() {
		//sender table
		$sql = "
			delete 
				mod_cms_forms_senders.*
			from 
				mod_cms_forms_fields,
				mod_cms_forms_records,
				mod_cms_forms_senders
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
				and id_snd = sending_rec
		";
		$q = new CMS_query($sql);
		//records table
		$sql = "
			delete 
				mod_cms_forms_records.*
			from 
				mod_cms_forms_fields,
				mod_cms_forms_records
			where
				form_fld = '".$this->getID()."'
				and id_fld = field_rec
		";
		
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	 * Delete all empty forms created
	 * 
	 * @access public
	 * @return boolean
	 * @static
	 */
	function cleanEmptyForms() {
		$sql = "
			delete 
			from 
				mod_cms_forms_formulars
			where
				responses_frm = '0' 
				and (
					name_frm = '' 
					or source_frm = ''
					)
		";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	 * Analyse a form xhtml code check if it has some copy-pasted code inside
	 *
	 * @access public
	 * @return true if none error found
	 */
	function checkFormCode($formCode)  {
		//get form ID in xhtml code
		$status = preg_match('#<form[^>]* id="cms_forms_(\d*)"#iU',$formCode,$formId);
		$formId = array_map("trim",$formId);
		if( $status ) {
			$formIdXHTML = $formId[1];
		}
		if (isset($formIdXHTML) && $this->getID() && $formIdXHTML != $this->getID()) {
			CMS_grandFather::raiseError("Can't use another form code pasted into XHTML source code");
			return false;
		}
		return true;
	}
}
?>
