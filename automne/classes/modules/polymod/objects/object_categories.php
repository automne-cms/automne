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
// $Id: object_categories.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_object_categories
  *
  * represent a categories object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_categories extends CMS_object_common
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_EMPTY_OBJECTS_SET = 265;
	const MESSAGE_CHOOSE_OBJECT = 1132;
	
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_CATEGORY_START_DESCRIPTION = 156;
	const MESSAGE_OBJECT_CATEGORY_COUNT_DESCRIPTION = 157;
	const MESSAGE_OBJECT_CATEGORY_VALUES_DESCRIPTION = 158;
	const MESSAGE_OBJECT_CATEGORY_VALUESID_DESCRIPTION = 159;
	const MESSAGE_OBJECT_CATEGORY_VALUESLABEL_DESCRIPTION = 160;
	const MESSAGE_OBJECT_CATEGORY_VALUESFILE_DESCRIPTION = 257;
	const MESSAGE_OBJECT_CATEGORY_ID_DESCRIPTION = 161;
	const MESSAGE_OBJECT_CATEGORY_FILE_DESCRIPTION = 256;
	const MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORYTREE_DESCRIPTION = 163;
	const MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORYLINEAGE_DESCRIPTION = 164;
	const MESSAGE_OBJECT_CATEGORY_FUNCTION_SELECTEDOPTIONS_DESCRIPTION = 165;
	const MESSAGE_OBJECT_CATEGORIES_LABEL = 166;
	const MESSAGE_OBJECT_CATEGORIES_DESCRIPTION = 167;
	const MESSAGE_OBJECT_CATEGORIES_PARAMETER_MULTI = 168;
	const MESSAGE_OBJECT_CATEGORIES_PARAMETER_ROOT_CATEGORY = 169;
	const MESSAGE_OBJECT_CATEGORIES_FIELD_WITHOUT_CATEGORIES = 258;
	const MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORY_DESCRIPTION = 289;
	const MESSAGE_OBJECT_CATEGORIES_PARAMETER_ASSOCIATE_UNUSEDCATS = 361;
	const MESSAGE_OBJECT_CATEGORIES_PARAMETER_ASSOCIATE_UNUSEDCATS_DESCRIPTION = 362;
	const MESSAGE_OBJECT_CATEGORIES_PARAMETER_DEFAULT = 367;
	const MESSAGE_OBJECT_CATEGORY_OPERATOR_STRICT_DESCRIPTION = 381;
	const MESSAGE_OBJECT_CATEGORY_LABEL_DESCRIPTION = 386;
	const MESSAGE_OBJECT_CATEGORY_ATM_INPUT_OPERATOR_ROOT_DESCRIPTION = 393;
  	const MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_WIDTH = 399;
  	const MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_HEIGHT = 400;
  	const MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_MULTICATS_ONLY = 401;
  	const MESSAGE_OBJECT_CATEGORY_OPERATOR_EDITABLE_ONLY_DESCRIPTION = 428;
  	const MESSAGE_OBJECT_CATEGORY_OPERATOR_NOT_IN_DESCRIPTION = 429;
  	const MESSAGE_OBJECT_CATEGORY_OPERATOR_NOT_IN_STRICT_DESCRIPTION = 430;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_CATEGORIES_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_CATEGORIES_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'category',
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
										'internalName'	=> 'multiCategories',
										'externalName'	=> self::MESSAGE_OBJECT_CATEGORIES_PARAMETER_MULTI,
									),
							 1 => array(
										'type' 			=> 'categories',
										'required' 		=> false,
										'internalName'	=> 'rootCategory',
										'externalName'	=> self::MESSAGE_OBJECT_CATEGORIES_PARAMETER_ROOT_CATEGORY,
									),
							 3 => array(
										'type' 			=> 'categories',
										'required' 		=> false,
										'internalName'	=> 'defaultValue',
										'externalName'	=> self::MESSAGE_OBJECT_CATEGORIES_PARAMETER_DEFAULT,
									),
							 2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'associateUnused',
										'externalName'	=> self::MESSAGE_OBJECT_CATEGORIES_PARAMETER_ASSOCIATE_UNUSEDCATS,
										'description'	=> self::MESSAGE_OBJECT_CATEGORIES_PARAMETER_ASSOCIATE_UNUSEDCATS_DESCRIPTION,
									),
							4 => array(
										'type'			=> 'string',
										'required'		=> false,
										'internalName'	=> 'selectWidth',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_WIDTH,
										'description'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_MULTICATS_ONLY,
									),
							5 => array(
										'type'			=> 'string',
										'required'		=> false,
										'internalName'	=> 'selectHeight',
										'externalName'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_HEIGHT,
										'description'	=> self::MESSAGE_OBJECT_TEXT_PARAMETER_SELECTBOXES_MULTICATS_ONLY,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => '', 2 => false, 3 => '', 4 => '', 5 => '');
	
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
			$this->raiseError('Object internal vars hasn\'t the same count of parameters, check $_subfields, $_subfieldValues.');
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
		foreach (array_keys($this->_subfields) as $subFieldID) {
			if (is_array($this->_subfields[$subFieldID])) {
				//load subobject
				$subFieldValue = isset($datas[$subFieldID]) ? $datas[$subFieldID] : null;
				$objectName = 'CMS_subobject_'.$this->_subfields[$subFieldID]['type'];
				$this->_subfieldValues[$subFieldID] = new $objectName(0,array(),$subFieldValue,$this->_public);
			}
		}
		//then populate others fields values
		foreach (array_keys($datas) as $subFieldID) {
			$this->_subfieldValues[$subFieldID] = new CMS_subobject_integer($datas[$subFieldID]['id'],array(),$datas[$subFieldID], $this->_public);
		}
		ksort($this->_subfieldValues);
		
		//set $this->_parameterValues
		foreach (array_keys($this->_parameters) as $parameterID) {
			$param = $field->getParameter($this->_parameters[$parameterID]['internalName']);
			if (isset($param)) {
				$this->_parameterValues[$parameterID] = $param;
			}
		}
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
		$mandatory = ($this->_field->getValue('required')) ? '<span class="admin_text_alert">*</span> ':'';
		$html = '<tr><td class="admin" align="right" valign="top">'.$mandatory.$this->getFieldLabel($language).'</td><td class="admin">'."\n";
		//add description if any
		if ($this->getFieldDescription($language)) {
			$html .= '<dialog-title type="admin_h3">'.$this->getFieldDescription($language).'</dialog-title><br />';
		}
		$inputParams = array(
			'class' 	=> 'admin_input_text',
			'no_admin'	=> false,
			'prefix'	=>	$prefixName,
			'form' 		=> 'frmitem',
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
		global $cms_user;
		$params = $this->getParamsValues();
		$prefixName = (isset($inputParams['prefix'])) ? $inputParams['prefix'] : '';
		$rootCategory = (SensitiveIO::isPositiveInteger($inputParams['root'])) ? $inputParams['root'] : false;
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		if ($params['multiCategories']) {
			// Get categories
			$a_all_categories = $this->getAllCategoriesAsArray($language, false, $moduleCodename, CLEARANCE_MODULE_EDIT, $rootCategory, true);
			$associated_items = array();
			if (is_array($a_all_categories) && $a_all_categories) {
				foreach (array_keys($this->_subfieldValues) as $subFieldID) {
					if (is_object($this->_subfieldValues[$subFieldID])) {
						$associated_items[] = $this->_subfieldValues[$subFieldID]->getValue();
					}
				}
				//set some default parameters
				if (!isset($inputParams['no_admin'])) {
					$inputParams['no_admin'] = true;
				}
				if (!isset($inputParams['position'])) {
					$inputParams['position'] = 'horizontal';
				}
				if (isset($inputParams['width']) && !isset($inputParams['select_width'])) {
					$inputParams['select_width'] = $inputParams['width'];
				}
				if (isset($inputParams['height']) && !isset($inputParams['select_height'])) {
					$inputParams['select_height'] = $inputParams['height'];
				}
				$params['selectWidth'] = (SensitiveIO::isPositiveInteger($params['selectWidth'])) ? $params['selectWidth'] : '300';
				$params['selectHeight'] = (SensitiveIO::isPositiveInteger($params['selectHeight'])) ? $params['selectHeight'] : '200';
				$listboxesParameters = array (
					'field_name' 		=> 'list'.$prefixName.$this->_field->getID().'_0',	// Hidden field name to get value in
					'items_possible' 	=> $a_all_categories,								// array of all categories availables: array(ID => label)
					'items_selected' 	=> $associated_items,								// array of selected ids
					'select_width'		=> $params['selectWidth'].'px',        				// Width of selects, default 200px
					'select_height'		=> $params['selectHeight'].'px',					// Height of selects, default 140px
					'form_name' 		=> $inputParams['form'] 							// Javascript form name
					);
				//append optional attributes
				foreach ($inputParams as $k => $v) {
					if (in_array($k, array('select_width','select_height','no_admin','leftTitle','rightTitle','position','description','selectIDFrom','selectIDTo',))) {
						$listboxesParameters[$k] = $v;
					}
				}
				$html = CMS_dialog_listboxes::getListBoxes($listboxesParameters);
			} else {
				$html = $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET);
			}
			if (POLYMOD_DEBUG) {
				$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Values : '.implode(';',$associated_items).')</span>';
			}
		} else {
			//serialize all htmlparameters 
			$htmlParameters = $this->serializeHTMLParameters($inputParams);
			// Get categories
			$a_all_categories = $this->getAllCategoriesAsArray($language, false, $moduleCodename, CLEARANCE_MODULE_EDIT, false, true);
			if (is_array($a_all_categories) && $a_all_categories) {
				$html = '
				<select name="list'.$prefixName.$this->_field->getID().'_0"'.$htmlParameters.'>';
				//selected value
				if (!sensitiveIO::isPositiveInteger($params['defaultValue'])) {
					$html .= '<option value="0">'.$language->getMessage(self::MESSAGE_CHOOSE_OBJECT).'</option>';
				}
				if (is_object($this->_subfieldValues[0]) && !is_null($this->_subfieldValues[0]->getValue())) {
					$selectedValue = $this->_subfieldValues[0]->getValue();
				} elseif (sensitiveIO::isPositiveInteger($params['defaultValue'])) {
					$selectedValue = $params['defaultValue'];
				} else {
					$selectedValue = '';
				}
				foreach($a_all_categories as $catID => $aCategory) {
					$selected = ($selectedValue == $catID) ? ' selected="selected"':'';
					$html .= '<option value="'.$catID.'"'.$selected.'>'.$aCategory.'</option>';
				}
				$html .= '</select>';
			} else {
				$html .= $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET);
			}
			if (POLYMOD_DEBUG) {
				$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.((is_object($this->_subfieldValues[0])) ? $this->_subfieldValues[0]->getValue() : '').')</span>';
			}
		}
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
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
			if (!$values['list'.$prefixName.$this->_field->getID().'_0']) {
				return false;
			}
		}
		return true;
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
		if (isset($values['list'.$prefixName.$this->_field->getID().'_0'])) {
			$valuesArray = explode(';',$values['list'.$prefixName.$this->_field->getID().'_0']);
			foreach(array_keys($this->_subfieldValues) as $subFieldID) {
				$value = (isset($valuesArray[$subFieldID])) ? $valuesArray[$subFieldID] : false;
				if (is_object($this->_subfieldValues[$subFieldID]) && $value !== false && sensitiveIO::isPositiveInteger($value)) {
					//replace value
					$this->_subfieldValues[$subFieldID]->setValue($value);
				} else if  (is_object($this->_subfieldValues[$subFieldID]) && ($value === false || !sensitiveIO::isPositiveInteger($value))) {
					//remove unused $this->_subfieldValues
					$this->_subfieldValues[$subFieldID]->destroy();
					unset($this->_subfieldValues[$subFieldID]);
				}
			}
			foreach ($valuesArray as $subFieldID => $aValue) {
				if (!isset($this->_subfieldValues[$subFieldID]) && sensitiveIO::isPositiveInteger($aValue)) {
					$this->_subfieldValues[$subFieldID] = new CMS_subobject_integer();
					$this->_subfieldValues[$subFieldID]->setValue($aValue);
				}
			}
		}
		ksort($this->_subfieldValues);
		return true;
	}
	
	/**
	  * Set subfields definition for current object
	  *
	  * @param $subFieldsDefinition array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setSubFieldsDefinition($subFieldsDefinition) {
		foreach(array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				$subFieldsDefinition[0]['subFieldID'] = $subFieldID;
				$this->_subfieldValues[$subFieldID]->setDefinition($subFieldsDefinition[0]);
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
	function getHTMLSubFieldsParametersCategories($language, $prefixName, $parameter) {
		global $cms_user,$polymod;
		
		$params = $this->getParamsValues();
		$input = '';
		//$parameters = $this->getSubFieldParameters();
		//foreach($parameters as $parameterID => $parameter) {
			if ($parameter["type"] == "categories") {
				// Get categories
				$a_all_categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, $polymod->getCodename(), $language);
				if (is_array($a_all_categories) && $a_all_categories) {
					$input = '<select name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text">
					<option value=""></option>';
					foreach($a_all_categories as $catID => $aCategory) {
						$selected = ($params[$parameter['internalName']] == $catID) ? ' selected="selected"':'';
						$input .= '<option value="'.$catID.'"'.$selected.'>'.$aCategory.'</option>';
					}
					$input .= '</select>';
					
				} else {
					$input = $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET).'<input type="hidden" name="'.$prefixName.$parameter['internalName'].'" value="0" />';
				}
			}
		//}
		return $input;
	}
	
	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription() {
		global $cms_language;
		$labels = array();
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				//load category
				$cat = CMS_moduleCategories_catalog::getByID($this->_subfieldValues[$subFieldID]->getValue());
				if (!$cat->hasError()) {
					$catLabel = $cat->getLabel($cms_language);
					if ($catLabel) {
						$labels[] = $catLabel;
					}
				}
			}
		}
		
		return implode(', ',$labels);
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
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID]) && $ok) {
				$ok = ($this->_subfieldValues[$subFieldID]->writeToPersistence()) ? $ok:false;
			}
		}
		return $ok;
	}
	
	/**
	  * Returns each category ID and label in a module given user can see
	  *
	  * @param CMS_language $cms_language, the language of the labels
	  * @param boolean $restrictToUsedCat, restrict returned categories to used ones only (default false)
	  * @param string $cms_module, the module codename (optional)
	  * @param boolean $editableOnly, return only user editable categories (default false : viewvable ones)
	  * @param mixed $clearanceLevel 
	  * - false : CLEARANCE_MODULE_VIEW
	  * - true : CLEARANCE_MODULE_EDIT
	  * - constant value : clearanceLevel value
	  * @param mixed $categoriesRoot, root category ID to use (default : false : the field root category)
	  * @return array(string) the statements or false if profile hasn't any access to any categories
	  * @access public
	  */
	function getAllCategoriesAsArray($language = false, $restrictToUsedCat = false, $module = false, $clearanceLevel = false, $categoriesRoot = false, $strict = false) {
		global $cms_user;
		$params = $this->getParamsValues();
		$categoriesRoot = ($categoriesRoot) ? $categoriesRoot : $params['rootCategory'];
		//get module if none passed
		if (!$module) {
			$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		}
		if (APPLICATION_ENFORCES_ACCESS_CONTROL && !is_object($cms_user)) {
			$this->raiseError("Valid user missing");
			return false;
		}
		if(/*($params['bypassRights'] && $clearanceLevel === false) || */!is_object($cms_user)) {
			//TODO : ugly but missing time (need to redo the getAllCategoriesAsArray to accept no valid cms_user : append only in frontend without APPLICATION_ENFORCES_ACCESS_CONTROL. Medias module already doing something like this)
			$user = new CMS_profile_user(1);
			$categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($user, $module, $language, $categoriesRoot, -1, $clearanceLevel, $strict);
		} else {
			$user = $cms_user;
			$categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($user, $module, $language, $categoriesRoot, -1, $clearanceLevel, $strict);
		}
		//pr($categories,true);
		if (!$restrictToUsedCat) {
			return $categories;
		} else {
			//Get all used categories IDS for this object field
			$usedCategories = $this->getAllUsedCategoriesForField();
			//pr($usedCategories);
			
			if (is_array($usedCategories) && $usedCategories) {
				//get all categories lineage
				$catArbo = CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($user, $module, true, $clearanceLevel, $strict);
				//pr($catArbo);
				
				//need to remove all unused categories from list
				$categoriesToKeep = array();
				foreach ($usedCategories as $catID) {
					$cats = explode(';',$catArbo[$catID]);
					foreach ($cats as $aCat) {
						$categoriesToKeep[$aCat] = $aCat;
					}
				}
				//pr($categoriesToKeep);
				//then remove unused categories from initial list
				if (is_array($categories)) {
					foreach (array_keys($categories) as $catID) {
						if (!isset($categoriesToKeep[$catID])) {
							unset($categories[$catID]);
						}
					}
				}
				//pr($categories);
				return $categories;
			} else {
				//no categories used
				return array();
			}
		}
	}
	
	/**
	  * Returns all categories IDs who has used by this type of object (ie : this field)
	  *
	  * @access public
	  * @return array(interger id => integer id) the object ids
	  * @static
	  */
	function getAllUsedCategoriesForField() {
		//get field of categories for searched object type (assume it uses categories)
		$categoriesFields = CMS_poly_object_catalog::objectHasCategories(CMS_poly_object_catalog::getObjectIDForField($this->_field->getID()));
		$fieldsDefinitions = array();
		//bypass field categories rights if needed
		foreach ($categoriesFields as $key => $catFieldID) {
			if (!isset($fieldsDefinitions[$catFieldID]) || !is_object($fieldsDefinitions[$catFieldID])) {
				//get object fields definition
				$fieldsDefinitions = CMS_poly_object_catalog::getFieldsDefinition(CMS_poly_object_catalog::getObjectIDForField($this->_field->getID()));
			}
			/*if ($fieldsDefinitions[$catFieldID]->getParameter('bypassRights')) {
				unset($categoriesFields[$key]);
			}*/
		}
		if (!$categoriesFields) {
			return array();
		}
		//if this field is the only one which use categories
		if (sizeof($categoriesFields) == 1 && in_array($this->_field->getID(), $categoriesFields)) {
			$table = ($this->_public) ? 'mod_subobject_integer_public' : 'mod_subobject_integer_edited';
			$sql = "
				select
					value
				from
					$table
				where
					objectFieldID = '".$this->_field->getID()."'
			";
			$q = new CMS_query($sql);
			$r = array();
			if ($q->getNumRows()) {
				while ($arr = $q->getArray()) {
					//check for value because it can be null !
					if ($arr['value']) {
						$r[$arr['value']] = $arr['value'];
					}
				}
			}
		} else {
			//if this field is not only one which use categories
			global $cms_user;
			if (APPLICATION_ENFORCES_ACCESS_CONTROL && !is_object($cms_user)) {
				$this->raiseError("Valid user missing");
				return false;
			}
			if(/*$params['bypassRights'] || */!is_object($cms_user)) {
				//TODO : ugly but missing time (need to redo the getAllCategoriesAsArray to accept no valid cms_user : append only in frontend without APPLICATION_ENFORCES_ACCESS_CONTROL. Medias module already doing something like this)
				$user = new CMS_profile_user(1);
			} else {
				$user = $cms_user;
			}
			
			//get a list of all viewvable categories for current user
			$viewvableCats = array_keys(CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($user, CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID()), true));
			//if no viewvable categories, user has no rights to view anything
			if (!$viewvableCats) {
				return array();
			}
			$table = ($this->_public) ? 'mod_subobject_integer_public' : 'mod_subobject_integer_edited';
			$sql = "
				select
					distinct objectID
				from
					$table
				where
					objectFieldID in (".@implode(',', $categoriesFields).")
					and value in (".@implode(',', $viewvableCats).")
					";
			$q = new CMS_query($sql);
			$r = array();
			if ($q->getNumRows()) {
				while ($arr = $q->getArray()) {
					//check for value because it can be null !
					if ($arr['objectID']) {
						$r[$arr['objectID']] = $arr['objectID'];
					}
				}
			}
			if (!$r) {
				return array();
			}
			//add previously founded IDs to where clause
			$sql = "
				select
					distinct value
				from
					$table
				where
					objectFieldID = '".$this->_field->getID()."'
					and objectID in(".@implode(',', $r).")
			";
			$q = new CMS_query($sql);
			$r = array();
			if ($q->getNumRows()) {
				while ($arr = $q->getArray()) {
					//check for value because it can be null !
					if ($arr['value']) {
						$r[$arr['value']] = $arr['value'];
					}
				}
			}
		}
		return $r;
	}
	
	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = parent::getStructure();
		$params = $this->getParamsValues();
		$structure['start'] = '';
		if ($params['multiCategories']) {
			unset($structure['label']);
			unset($structure['value']);
			$structure['count'] = '';
			$structure['values'] = '';
			$structure['values']['n']['id'] = '';
			$structure['values']['n']['label'] = '';
			$structure['values']['n']['file'] = '';
		} else {
			$structure['id'] = '';
			$structure['file'] = '';
		}
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
		$name = ($name !== 0) ? $name : "0";
		switch ($name) {
			case 'ids':
				$ids = array();
				foreach (array_keys($this->_subfieldValues) as $subFieldID) {
					if (is_object($this->_subfieldValues[$subFieldID])) {
						$ids[] = $this->_subfieldValues[$subFieldID]->getValue();
					}
				}
				return $ids;
			break;
			case 'values':
				return $this->_subfieldValues;
			break;
			case 'count' :
				return sizeof($this->_subfieldValues);
			break;
			case 'start':
				$params = $this->getParamsValues();
				return $params['rootCategory'];
			break;
			/*case 'bypassRights':
				$params = $this->getParamsValues();
				return ($params['bypassRights']) ? true : false;
			break;*/
			default:
				if (sensitiveIO::isPositiveInteger($name) || $name === "0") {
					switch ($parameters) {
						case 'id':
							return $this->_subfieldValues[$name]->getValue();
						break;
						case 'file':
							$category = CMS_moduleCategories_catalog::getByID($this->_subfieldValues[$name]->getValue());
							if (!$category->hasError()) {
								$file = $category->getFile($cms_language);
								if ($file) {
									//get module codename
									$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
									return PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_PUBLIC.'/'.$file;
								}
							}
							return '';
						break;
						case 'label':
							$category = CMS_moduleCategories_catalog::getByID($this->_subfieldValues[$name]->getValue());
							if (!$category->hasError()) {
								return htmlspecialchars($category->getLabel($cms_language));
							}
							return '';
						break;
					}
				} else {
					switch ($name) {
						case 'label':
							$category = CMS_moduleCategories_catalog::getByID($this->_subfieldValues[0]->getValue());
							if (!$category->hasError()) {
								return htmlspecialchars($category->getLabel($cms_language));
							}
							return '';
						break;
						case 'id':
							return $this->_subfieldValues[0]->getValue();
						break;
						case 'file':
							$category = CMS_moduleCategories_catalog::getByID($this->_subfieldValues[0]->getValue());
							if (!$category->hasError()) {
								$file = $category->getFile($cms_language);
								if ($file) {
									//get module codename
									$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
									return PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_PUBLIC.'/'.$file;
								}
							}
							return '';
						break;
						default:
							return parent::getValue($name, $parameters);
						break;
					}
				}
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
		$labels = parent::getLabelsStructure($language);
		unset($labels['structure']['values']);
		$params = $this->getParamsValues();
		$labels['structure']['start'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_START_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		if ($params['multiCategories']) {
			unset($labels['structure']['label']);
			$labels['structure']['count'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_COUNT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_VALUES_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values:id'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_VALUESID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values:label'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_VALUESLABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values:file'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_VALUESFILE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		} else {
			$labels['structure']['label'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_LABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['id'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_ID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['file'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_FILE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		}
		$labels['function']['categoryLineage'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORYLINEAGE_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);
		$labels['function']['categoriesTree'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORYTREE_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);
		$labels['function']['selectOptions'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_FUNCTION_SELECTEDOPTIONS_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);
		$labels['function']['category'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_FUNCTION_CATEGORY_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);
		$labels['operator']['strict'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_OPERATOR_STRICT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['editableOnly'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_OPERATOR_EDITABLE_ONLY_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['not in'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_OPERATOR_NOT_IN_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['operator']['not in strict'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_OPERATOR_NOT_IN_STRICT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['atmInputOperator']['root'] = $language->getMessage(self::MESSAGE_OBJECT_CATEGORY_ATM_INPUT_OPERATOR_ROOT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		
		return $labels;
	}
	
	/**
      * Return a given category lineage
      *
      * @param array $values : parameters values array(parameterName => parameterValue) in :
      *     category : the category id
      * @param multidimentionnal array $tags : xml2Array content of atm-function tag
      *     ... {id} ... {label} ...
      * @return string : the category
      * @access public
      */
    function category($values, $tags) {
        global $cms_language;
       
        $return = "";
        if (!sensitiveIO::isPositiveInteger($values['category'])) {
            $this->raiseError("Category value parameter must be a valid category ID : ".$values['category']);
            return false;
        }
        if (!isset($tags[0]['textnode'])) {
            $this->raiseError("atm-function tag must have a content");
            return false;
        }
        $params = $this->getParamsValues();
        $category = new CMS_moduleCategory($values['category']);
        if ($category->hasError()) {
            $this->raiseError("Category ".$values['category']." has an error ...");
            return false;
        }
        $replace = array(
            '{id}' => $values['category'],
            '{label}' => $category->getLabel($cms_language)
        );
        $return .= str_replace(array_keys($replace), $replace, $tags[0]['textnode']);
        return $return;
    }
	
	/**
	  * Return a given category lineage
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	category : the category id to get lineage of
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag
	  * 	<ancestor> ... {id} ... {label} ... </ancestor>
	  * 	<self> ... {label} ...</self>
	  * @return string : the category lineage
	  * @access public
	  */
	function categoryLineage($values, $tags) {
		global $cms_language;
		
		$return = "";
		if (!sensitiveIO::isPositiveInteger($values['category'])) {
			$this->raiseError("Category value parameter must be a valid category ID : ".$values['category']);
			return false;
		}
		$params = $this->getParamsValues();
		if (!sensitiveIO::isPositiveInteger($values['root']) && !sensitiveIO::isPositiveInteger($params['rootCategory'])) {
			$this->_raiseError(get_class($this)." : categoryLineage : root value parameter must be a valid category ID : ".$values['root'].". Or specify a root category from field properties : ".$params['rootCategory']);
			return false;
		}
		$fullLineage = CMS_moduleCategories_catalog::getLineageOfCategory($values['category']);
		$lineage = array();
		$stopAncestor = (sensitiveIO::isPositiveInteger($values['root'])) ? $values['root'] : $params['rootCategory'];
		while($fullLineage && $ancestorID != $stopAncestor) {
			if ($ancestorID) {
				$lineage[] = $ancestorID;
			}
			$ancestorID = array_pop($fullLineage);
		}
		if (is_array($lineage) && $lineage) {
			$lineage = array_reverse($lineage);
			$xml2Array = new CMS_XML2Array();
			$ancestorPattern = $xml2Array->getXMLInTag($tags, 'ancestor');
			$selfPattern = $xml2Array->getXMLInTag($tags, 'self');
			if (!$ancestorPattern) {
				$this->raiseError("No 'ancestor' tag found or tag empty");
				return false;
			}
			if (!$selfPattern) {
				$selfPattern = $ancestorPattern;
			}
			foreach ($lineage as $ancestorID) {
				$ancestor = CMS_moduleCategories_catalog::getByID($ancestorID);
				$replace = array(
					'{id}' => $ancestorID,
					'{label}' => $ancestor->getLabel($cms_language)
				);
				if ($ancestorID != $values['category']) {
					$return .= str_replace(array_keys($replace), $replace, $ancestorPattern);
				} else {
					$return .= str_replace(array_keys($replace), $replace, $selfPattern);
				}
			}
		}
		return $return;
	}
	
	/**
	  * Return sub tree of a given category
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	root : the category id to get subtree. If none set, use the defined root category for field
	  *		maxlevel : the maximum number of level to get (optional)
	  *		selected : the current selected category id (optional)
	  * 	usedcategories : display only used categories (optional, default : true)
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag
	  * 	<item>...{lvl}...{id}...{label}...{sublevel}...</item>
	  * 	<itemselected>...{lvl}...{id}...{label}...{sublevel}...</itemselected>
	  * 	<template>...{sublevel}...</template>
	  * @return string : the sub tree of the given category
	  * @access public
	  */
	function categoriesTree($values, $tags) {
		global $cms_user, $cms_language;
		if ($values['usedcategories'] == 'true' || $values['usedcategories'] == '1' || !isset($values['usedcategories'])) {
			$restrictToUsedCategories = true;
		} else {
			$restrictToUsedCategories = false;
		}
		$return = "";
		$params = $this->getParamsValues();
		if (!sensitiveIO::isPositiveInteger($values['root']) && !sensitiveIO::IsPositiveInteger($params['rootCategory'])) {
			$this->raiseError("Root value parameter must be a valid category ID : ".$values['root']);
			return false;
		} elseif (!sensitiveIO::isPositiveInteger($values['root']) && sensitiveIO::IsPositiveInteger($params['rootCategory'])) {
			$values['root'] = $params['rootCategory'];
		}
		$usedCategories = $this->getAllUsedCategoriesForField();
		if (!$usedCategories) {
			return $return;
		}
		$xml2Array = new CMS_XML2Array();
		$itemPattern = $xml2Array->getXMLInTag($tags, 'item');
		$templatePattern = $xml2Array->getXMLInTag($tags, 'template');
		$selectedPattern = $xml2Array->getXMLInTag($tags, 'itemselected');
		$maxlevel = (int) $values['maxlevel'];
		$selectedID = (int) $values['selected'];
		$disableCategories = explode(';',$values['disable']);
		
		if (!$itemPattern) {
			$this->raiseError("No 'item' tag found or tag empty");
			return false;
		}
		if (!$templatePattern) {
			$this->raiseError("No 'template' tag found or tag empty");
			return false;
		}
		
		$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		$viewvableCategoriesForProfile = CMS_moduleCategories_catalog::getViewvableCategoriesForProfile ($cms_user, $module, true);
		
		if ($restrictToUsedCategories || (is_array($disableCategories) && $disableCategories)) {
			//unset unused categories (keep categories parents in lineage)
			$usedCategoriesTree = array();
			foreach ($usedCategories as $usedCategory) {
				if ($viewvableCategoriesForProfile[$usedCategory]) {
					$usedCategoriesTree = array_merge($usedCategoriesTree, explode(';', $viewvableCategoriesForProfile[$usedCategory]));
				}
			}
			$usedCategoriesTree = array_flip(array_unique($usedCategoriesTree));
			foreach ($viewvableCategoriesForProfile as $catID => $lineage) {
				//restrict to used categories
				if ($restrictToUsedCategories) {
					if (!$usedCategoriesTree[$catID]) {
						unset($viewvableCategoriesForProfile[$catID]);
					}
				}
				// Disable categories
				if(is_array($disableCategories) && $disableCategories){
					$lineageTab = explode(';', $lineage);
					foreach($disableCategories as $disableCategory){
						if(SensitiveIO::isPositiveInteger($disableCategory)){
							if (in_array($disableCategory,$lineageTab)) {
								unset($viewvableCategoriesForProfile[$catID]);
							}
						}
					}
				}
			}
		}
		$rootLineage = CMS_moduleCategories_catalog::getLineageOfCategoryAsString($values['root'], $separator = ";");
		//old method, seems buggy, keep it for now
		//$rootLineage = ($viewvableCategoriesForProfile[$values['root']]) ? $viewvableCategoriesForProfile[$values['root']] : $values['root'];
		
		//create recursive categories array
		foreach ($viewvableCategoriesForProfile as $catID => $lineage) {
			//this must be ^...;rootID;...$ or ^rootID;...$
			if (strpos($lineage, ';'.$values['root'].';') !== false || strpos($lineage, $values['root'].';') === 0) {
				$lineage = preg_replace('#^'.$rootLineage.';#','',$lineage);
				$ln = 'if (!isset($nLevelArray['.str_replace(';','][',$lineage).'])) $nLevelArray['.str_replace(';','][',$lineage).'] =  array();';
				eval($ln);
			}
		}
		//pr($nLevelArray);
		if (is_array($nLevelArray) && $nLevelArray) {
			$return = $this->_createCategoriesTree($nLevelArray, $itemPattern, $templatePattern, $selectedPattern, $maxlevel, $selectedID);
		}
		return $return;
	}
	//private function of categoriesTree method
	protected function _createCategoriesTree($categories, $itemPattern, $templatePattern, $selectedPattern, $maxlevel = 0, $selectedID = false) {
		global $cms_language;
		static $level;
		$level++;
		$return = "";
		//get all level categories object
		$categoriesObjects = array();
		$subCats = array();
		foreach ($categories as $catID => $subCategories) {
			$category = CMS_moduleCategories_catalog::getByID($catID);
			$categoriesObjects[$category->getAttribute('order')] = $category;
			$subCats[$catID] = $subCategories;
		}
		//sort categories by order
		ksort($categoriesObjects);
		///then display it
		foreach ($categoriesObjects as $category) {
			$catID = $category->getID();
			$subCategories = $subCats[$catID];
			$subcats = '';
			if (is_array($subCategories) && $subCategories && (!$maxlevel || $level < $maxlevel)) {
				//recurse on subcategories
				$subcats = $this->_createCategoriesTree($subCategories, $itemPattern, $templatePattern, $selectedPattern, $maxlevel, $selectedID);
			}
			$replace = array(
				'{id}' => $catID,
				'{label}' => $category->getLabel($cms_language),
				'{sublevel}' => $subcats,
				'{lvl}' => $level
			);
			if ($catID == $selectedID) {
				$return .= str_replace(array_keys($replace), $replace, $selectedPattern);
			} else {
				$return .= str_replace(array_keys($replace), $replace, $itemPattern);
			}
		}
		$return = str_replace('{sublevel}', $return, $templatePattern);
		$level--;
		return $return;
	}
	
	/**
	  * For a given category, return options tag list (for a select tag) of all sub categories
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	selected : the category id which is selected (optional)
	  * 	usedcategories : display only used categories (optional, default : true)
	  * 	editableonly : display only editable categories (optional, default : false)
	  * 	root : the category id to use as root (optional)
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
	  * @return string : options tag list
	  * @access public
	  */
	function selectOptions($values, $tags) {
		global $cms_language;
		if (!isset($values['usedcategories']) || $values['usedcategories'] == 'true' || $values['usedcategories'] == '1') {
			$usedCategories = true;
		} else {
			$usedCategories = false;
		}
		if (!isset($values['editableonly']) || $values['editableonly'] == 'false' || $values['editableonly'] == '0') {
			$editableOnly = false;
		} else {
			$editableOnly = true;
		}
		if (isset($values['root']) && sensitiveIO::isPositiveInteger($values['root'])) {
			$rootCategory = $values['root'];
		} else {
			$rootCategory = false;
		}
		$categories = $this->getAllCategoriesAsArray($cms_language, $usedCategories, false, $editableOnly, $rootCategory);
		$return = "";
		if (is_array($categories) && $categories) {
			foreach ($categories as $catID => $catLabel) {
				$selected = ($catID == $values['selected']) ? ' selected="selected"':'';
				$return .= '<option value="'.$catID.'"'.$selected.'>'.$catLabel.'</option>';
			}
		}
		return $return;
	}
	
	/**
	  * Get field search SQL request (used by class CMS_object_search)
	  *
	  * @param integer $fieldID : this field id in object (aka $this->_field->getID())
	  * @param integer $value : the category value to search
	  * @param string $operator : additionnal search operator
	  * @param string $where : where clauses to add to SQL
	  * @param boolean $public : values are public or edited ? (default is edited)
	  * @return string : the SQL request
	  * @access public
	  */
	function getFieldSearchSQL($fieldID, $value, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";
		
		$supportedOperator = array(
			'editableOnly',
			'strict',
			'not in',
			'not in strict',
		);
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->raiseError("Unkown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		
		if ($operator == 'editableOnly') {
			global $cms_user;
			
			//get module codename
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			
			//get a list of all viewvable categories for current user
			$editableCats = array_keys(CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($cms_user, $moduleCodename, true, true));
			
			//if no viewvable categories, user has no rights to view anything
			if (!$editableCats) {
				return false;
			}
			
			//add previously founded IDs to where clause
			$sql = "
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix."
					where
						objectFieldID = '".$fieldID."'
						and value in (".@implode(',', $editableCats).")
						$where
					";
			$q = new CMS_query($sql);
			$IDs = array();
			if (!$q->hasError()) {
				while ($id = $q->getValue('objectID')) {
					$IDs[$id] = $id;
				}
			}
			//if no results, no need to continue
			if (!$IDs) {
				return false;
			}
			$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
		}
		if ($value == CMS_moduleCategory::LINEAGE_PARK_POSITION) {
			//if it is a public search, and field is mandatory, no objects should be returned
			if ($this->_field->getValue('required') && $public) {
				return false;
			}
			$module = CMS_poly_object_catalog::getModuleCodenameForField($fieldID);
			//add deleted cats to searchs
			$viewvableCats = CMS_moduleCategories_catalog::getDeletedCategories($module);
			//add zero value for objects without categories
			$viewvableCats[] = 0;
			//get object type id
			$objectID = CMS_poly_object_catalog::getObjectIDForField($fieldID);
			
			//first we get objects with deleted or no categories (value 0)
			$sqlTmp = "
				select
					distinct objectID
				from
					mod_subobject_integer".$statusSuffix."
				where
					objectFieldID = '".$fieldID."'
					and value in (".implode(',',$viewvableCats).")
					$where
				";
			$qTmp = new CMS_query($sqlTmp);
			$deletedIDs = array();
			while ($r = $qTmp->getArray()) {
				if ($r['objectID']) {
					$deletedIDs[$r['objectID']] = $r['objectID'];
				}
			}
			//then if we get objects with no categories at all (not referenced in mod_subobject_integer table)
			$sqlTmp = "
				select
					distinct objectID
				from
					mod_subobject_integer".$statusSuffix."
				where
					objectFieldID = '".$fieldID."'
					$where
				";
			$qTmp = new CMS_query($sqlTmp);
			$noCatsIDs = $catsIDs = array();
			while ($r = $qTmp->getArray()) {
				if ($r['objectID']) {
					$catsIDs[$r['objectID']] = $r['objectID'];
				}
			}
			$IDs = array();
			if (preg_match_all('#\d+#',$where,$IDs)) {
				$IDs = array_shift($IDs);
			}
			$noCatsIDs = array_diff($IDs, $catsIDs);
			$IDs = array_merge($deletedIDs, $noCatsIDs);
			//if no results, no need to continue
			if (!$IDs) {
				return false;
			}
			//then we mix the too results and we return it as a fake SQL request to keep system compatibility
			$sql = "
				select
					distinct id_moo as objectID
				from
					mod_object_polyobjects
				where 
					id_moo in (".implode(',',$IDs).")
				";
		} else {
			if ($operator == 'strict') {
				//get category searched
				$sql = "
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix.",
						modulesCategories
					where
						objectFieldID = '".$fieldID."'
						and value = '".$value."'
						$where
					";
			} elseif ($operator == 'not in strict') {
				//get category searched
				$sql = "
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix.",
						modulesCategories
					where
						objectFieldID = '".$fieldID."'
						and value != '".$value."'
						$where
					";
			} else {
				if (!is_array($value)) {
					$value = array($value);
				}
				$lineages = array();
				foreach ($value as $catID) {
					//get lineage of category searched
					$lineages[] = CMS_moduleCategories_catalog::getLineageOfCategoryAsString($catID);
				}
				$sql = '';
				if ($operator == 'not in') {
					foreach ($lineages as $lineage) {
						$sql .= ($sql) ? ' and ' : '';
						$sql .= "
						lineage_mca != '".SensitiveIO::sanitizeSQLString($lineage)."'
						and lineage_mca not like '".SensitiveIO::sanitizeSQLString($lineage).";%' ";
					}
				} else {
					foreach ($lineages as $lineage) {
						$sql .= ($sql) ? ' or ' : '';
						$sql .= "
						lineage_mca = '".SensitiveIO::sanitizeSQLString($lineage)."'
						or lineage_mca like '".SensitiveIO::sanitizeSQLString($lineage).";%' ";
					}
				}
				$sql = "
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix.",
						modulesCategories
					where
						objectFieldID = '".$fieldID."'
						and id_mca=value
						and (".$sql.")
						$where";
			}
		}
		return $sql;
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
	function getListOfNamesForObject($public = false, $searchConditions = array(), $restrictToUsedCat = true) {
		global $cms_language;
		$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		if (APPLICATION_ENFORCES_ACCESS_CONTROL && !$public)  {
			$editableOnly = CLEARANCE_MODULE_EDIT;
		} else {
			$editableOnly = CLEARANCE_MODULE_VIEW;
		}
		$a_all_categories = $this->getAllCategoriesAsArray($cms_language, $restrictToUsedCat, $module, $editableOnly);
		$a_all_categories[CMS_moduleCategory::LINEAGE_PARK_POSITION] = '['.$cms_language->getMessage(self::MESSAGE_OBJECT_CATEGORIES_FIELD_WITHOUT_CATEGORIES, array($this->_field->getLabel($cms_language)), MOD_POLYMOD_CODENAME).']';
		
		return $a_all_categories;
	}
}
?>