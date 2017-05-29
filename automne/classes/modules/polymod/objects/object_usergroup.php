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
// | Author: J�r�mie Bryon <jeremie.bryon@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: object_usergroup.php,v 1.9 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_usergroup
  *
  * represent a usergroup object
  *
  * @package Automne
  * @subpackage polymod
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author J�r�mie Bryon <jeremie.bryon@ws-interactive.fr>
  */

class CMS_object_usergroup extends CMS_object_common
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_EMPTY_OBJECTS_SET = 265;
	const MESSAGE_CHOOSE_OBJECT = 1132;
	
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_USERGROUP_COUNT_DESCRIPTION = 259;
	const MESSAGE_OBJECT_USERGROUP_VALUES_DESCRIPTION = 260;
	const MESSAGE_OBJECT_USERGROUP_VALUESID_DESCRIPTION = 261;
	const MESSAGE_OBJECT_USERGROUP_VALUESLABEL_DESCRIPTION = 262;
	const MESSAGE_OBJECT_USERGROUP_VALUESEMAIL_DESCRIPTION = 273;
	const MESSAGE_OBJECT_USERGROUP_ID_DESCRIPTION = 263;
	const MESSAGE_OBJECT_USERGROUP_LABEL_DESCRIPTION = 272;
	const MESSAGE_OBJECT_USERGROUP_EMAIL_DESCRIPTION = 274;
	const MESSAGE_OBJECT_USERGROUP_FUNCTION_SELECTEDOPTIONS_DESCRIPTION = 271;
	const MESSAGE_OBJECT_USERGROUP_LABEL = 264;
	const MESSAGE_OBJECT_USERGROUP_DESCRIPTION = 265;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_MULTI = 266;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_ROOT_CATEGORY = 267;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_ROOT_CATEGORY_DESCRIPTION = 270;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_CURRENT_USER = 268;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_CURRENT_USER_DESCRIPTION = 269;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_DISABLEUSERS = 314;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_DISABLEGROUPS = 315;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_USERS_LEFT_TITLE = 316;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_USERS_RIGHT_TITLE = 317;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_GROUPS_LEFT_TITLE = 318;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_GROUPS_RIGHT_TITLE = 319;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_INCLUDE_EXCLUDE = 320;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_INCLUDE_EXCLUDE_DESCRIPTION = 321;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_CREATION_USER = 377;
	const MESSAGE_OBJECT_USERGROUP_PARAMETER_CREATION_USER_DESCRIPTION = 269;
	const MESSAGE_OBJECT_USERGROUP_IDS_DESCRIPTION = 387;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_USERGROUP_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_USERGROUP_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'usergroup',
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
	protected $_parameters = array(
							 0 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'isCurrentUser',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_CURRENT_USER,
										'description'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_CURRENT_USER_DESCRIPTION,
									),
							 1 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'isGroup',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_ROOT_CATEGORY,
										'description'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_ROOT_CATEGORY_DESCRIPTION,
									),
							 2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'multiUserGroup',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_MULTI,
									),
							 3 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'includeExclude',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_INCLUDE_EXCLUDE,
										'description'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_INCLUDE_EXCLUDE_DESCRIPTION,
									),
						 	 4 => array(
										'type' 			=> 'disableUsers',
										'required' 		=> false,
										'internalName'	=> 'disableUsers',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_DISABLEUSERS,
									),
							 5 => array(
										'type' 			=> 'disableGroups',
										'required' 		=> false,
										'internalName'	=> 'disableGroups',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_DISABLEGROUPS,
									),
							 6 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'creationUser',
										'externalName'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_CREATION_USER,
										'description'	=> self::MESSAGE_OBJECT_USERGROUP_PARAMETER_CREATION_USER_DESCRIPTION,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => false, 2 => false, 3 => false, 4 => '', 5 => '', 6 => false);
	
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
			$this->setError('Object internal vars hasn\'t the same count of parameters, check $_subfields, $_subfieldValues.');
			return;
		}
		if (!is_array($datas)) {
			$this->setError("Datas need to be an array : ".print_r($datas,true));
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
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		global $cms_user;
		$params = $this->getParamsValues();
		$return['name'] 			/*= $return['id'] */			= 'polymodFieldsValue[list'.$prefixName.$this->_field->getID().'_0]';
		if ($params['multiUserGroup']) {
			// Get all users or groups
			$a_all_users = $this->getListOfNamesForObject();
			$associatedItems = $availableItems = array();
			if (is_array($a_all_users) && $a_all_users) {
				foreach (array_keys($this->_subfieldValues) as $subFieldID) {
					if (is_object($this->_subfieldValues[$subFieldID])) {
						$associatedItems[$this->_subfieldValues[$subFieldID]->getValue()] = $this->_subfieldValues[$subFieldID]->getValue();
					}
				}
				foreach ($a_all_users as $id => $user) {
					$availableItems[] = array($id, $user);
				}
			} else {
				$availableItems[] = array('', $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET));
				$return['disabled'] = true;
				$return['value']	= '';
			}
			/*$return['xtype'] 			= 'multiselect';
			$return['dataFields'] 		= array('id', 'label');
			$return['data'] 			= $availableItems;
			$return['value'] 			= implode(',',$associatedItems);
			$return['valueField'] 		= "id";
			$return['displayField'] 	= "label";
			$return['width'] 			= '97%';*/
			
			
			$return['xtype'] 			= 'superboxselect';
			$return['dataFields'] 		= array('id', 'label');
			$return['store'] 			= $availableItems;
			$return['mode'] 			= 'local';
			$return['value'] 			= implode(',',$associatedItems);
			$return['valueField'] 		= "id";
			$return['displayField'] 	= "label";
			$return['width'] 			= '100%';
			$return['stackItems'] 		= true;
			
			
		} else {
			$usersDatas = array();
			if ($params['isCurrentUser']) {
				$usersDatas[] = array($cms_user->getUserId(), $cms_user->getFullName());
				$return['disabled']	= true;
				$return['value']	= $cms_user->getUserId();
			} elseif ($params['creationUser']) {
				if (sensitiveIO::isPositiveInteger($this->_subfieldValues[0]->getValue())) {
					$user = CMS_profile_usersCatalog::getByID($this->_subfieldValues[0]->getValue());
				} else {
					$user = $cms_user;
				}
				$usersDatas[] = array($user->getUserId(), $user->getFullName());
				$return['disabled'] = true;
				$return['value']	= $user->getUserId();
			} else {
				// Get all users or groups
				$a_all_users = $this->getListOfNamesForObject();
				if (is_array($a_all_users) && $a_all_users) {
					$usersDatas[] = array('', $language->getMessage(self::MESSAGE_CHOOSE_OBJECT));
					foreach($a_all_users as $userGroupID => $aUserGroupLabel) {
						$usersDatas[] = array($userGroupID, io::decodeEntities($aUserGroupLabel));
					}
					$return['value']	= $this->_subfieldValues[0]->getValue();
				} else {
					$usersDatas[] = array('', $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET));
					$return['disabled'] = true;
					$return['value']	= '';
				}
			}
			$return['hiddenName'] 		= $return['name'];
			/*unset($return['id']);*/
			$return['xtype'] 			= 'atmCombo';
			$return['forceSelection'] 	= true;
			$return['mode'] 			= 'local';
			$return['valueField'] 		= 'id';
			$return['displayField'] 	= 'name';
			$return['triggerAction'] 	= 'all';
			$return['store'] 			= array(
				'xtype'			=> 'arraystore',
				'fields' 		=> array('id', 'name'),
				'data' 			=> $usersDatas
			);
			$return['selectOnFocus'] 	= true;
			$return['editable'] 		= true;
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
		global $cms_user;
		$html = '';
		$params = $this->getParamsValues();
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
		} else {
			$prefixName = '';
		}
		if ($params['isCurrentUser']) {
			$html .= $cms_user->getFirstName().' '.$cms_user->getLastName().
					'<input type="hidden" name="list'.$prefixName.$this->_field->getID().'_0" value="'.$cms_user->getUserId().'" />';
			if (POLYMOD_DEBUG) {
				$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.$this->_subfieldValues[0]->getValue().')</span>';
			}
		} elseif ($params['creationUser']) {
			if (sensitiveIO::isPositiveInteger($this->_subfieldValues[0]->getValue())) {
				$user = CMS_profile_usersCatalog::getByID($this->_subfieldValues[0]->getValue());
			} else {
				$user = $cms_user;
			}
			$html .= $user->getFirstName().' '.$user->getLastName().
					'<input type="hidden" name="list'.$prefixName.$this->_field->getID().'_0" value="'.$user->getUserId().'" />';
			if (POLYMOD_DEBUG) {
				$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.$this->_subfieldValues[0]->getValue().')</span>';
			}
		} else {
			
			
			if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
				if (isset($inputParams['value'])) {
					$value = $inputParams['value'];
				} elseif (isset($this->_subfieldValues[0]) && is_object($this->_subfieldValues[0]) && !is_null($this->_subfieldValues[0]->getValue())) {
					if ($params['multiUserGroup']) {
						// Get all users or groups
						$a_all_users = $this->getListOfNamesForObject();
						if (is_array($a_all_users) && $a_all_users) {
							$associated_items = array();
							foreach (array_keys($this->_subfieldValues) as $subFieldID) {
								if (is_object($this->_subfieldValues[$subFieldID])) {
									$associated_items[] = $this->_subfieldValues[$subFieldID]->getValue();
								}
							}
						}
						$value = implode(',', $associated_items);
					} else {
						$value = $this->_subfieldValues[0]->getValue();
					}
				} else {
					$value = '';
				}
				$html = '<input type="hidden" name="list'.$prefixName.$this->_field->getID().'_0" value="'.$value.'" />'."\n";
			} else {
				if ($params['multiUserGroup']) {
					// Get all users or groups
					$a_all_users = $this->getListOfNamesForObject();
					if (is_array($a_all_users) && $a_all_users) {
						$associated_items = array();
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
						$listboxesParameters = array (
							'field_name' 		=> 'list'.$prefixName.$this->_field->getID().'_0',	// Hidden field name to get value in
							'items_possible' 	=> $a_all_users,			// array of all categories availables: array(ID => label)
							'items_selected' 	=> $associated_items,		// array of selected ids
							'select_width' 		=> '300px',					// Width of selects, default 200px
							'select_height' 	=> '200px',					// Height of selects, default 140px
							'form_name' 		=> $inputParams['form']				// Javascript form name
						);
						//append optional attributes
						foreach ($inputParams as $k => $v) {
							if (in_array($k, array('select_width','select_height','no_admin','leftTitle','rightTitle','position','description','selectIDFrom','selectIDTo',))) {
								$listboxesParameters[$k] = $v;
							}
						}
						$html .= CMS_dialog_listboxes::getListBoxes($listboxesParameters);
					} else {
						$html .= $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET);
					}
					if (POLYMOD_DEBUG) {
						$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Values : '.implode(';',$associated_items).')</span>';
					}
				} else {
					//serialize all htmlparameters 
					$htmlParameters = $this->serializeHTMLParameters($inputParams);
					// Get all users or groups
					$a_all_users = $this->getListOfNamesForObject();
					$value = (is_object($this->_subfieldValues[0])) ? $this->_subfieldValues[0]->getValue() : '';
					if (is_array($a_all_users) && $a_all_users) {
						$html .= '
						<select name="list'.$prefixName.$this->_field->getID().'_0"'.$htmlParameters.'>
							<option value="0">'.$language->getMessage(self::MESSAGE_CHOOSE_OBJECT).'</option>';
						foreach($a_all_users as $userGroupID => $aUserGroupLabel) {
							$selected = ($value == $userGroupID) ? ' selected="selected"':'';
							$html .= '<option value="'.$userGroupID.'"'.$selected.'>'.$aUserGroupLabel.'</option>';
						}
						$html .= '</select>';
						
					} else {
						$html .= $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET);
					}
					if (POLYMOD_DEBUG) {
						$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.$value.')</span>';
					}
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
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values, $prefixName, $newFormat = false) {
		$params = $this->getParamsValues();
		//if field is required check values
		if (!$params['isCurrentUser'] && !$params['creationUser'] && $this->_field->getValue('required')) {
			if (!isset($values['list'.$prefixName.$this->_field->getID().'_0']) || !$values['list'.$prefixName.$this->_field->getID().'_0']) {
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
	function setValues($values,$prefixName, $newFormat = false) {
		$params = $this->getParamsValues();
		if (isset($values['list'.$prefixName.$this->_field->getID().'_0']) || $params['isCurrentUser'] || $params['creationUser']) {
			// If params : set userID
			if ($params['isCurrentUser']) {
				global $cms_user;
				$userID = $cms_user->getUserId();
			} elseif ($params['creationUser']) {
				if (sensitiveIO::isPositiveInteger($this->_subfieldValues[0]->getValue())) {
					$userID = $this->_subfieldValues[0]->getValue();
				} else {
					global $cms_user;
					$userID = $cms_user->getUserId();
				}
			}
			// If params : Save userID value in a single CMS_subobject_integer
			if($params['isCurrentUser'] || $params['creationUser']){
				if(!is_a($this->_subfieldValues[0],'CMS_subobject_integer')){
					unset($this->_subfieldValues[0]);
					$this->_subfieldValues[0] = new CMS_subobject_integer();
				}
				$this->_subfieldValues[0]->setValue($userID);
				return true;
			} else {
				// No params
				$values['list'.$prefixName.$this->_field->getID().'_0'] = str_replace(',',';',$values['list'.$prefixName.$this->_field->getID().'_0']);
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
	  * treat all params then return array of values treated or false if error
	  *
	  * @param array $post the posted datas
	  * @param string $prefix the prefix for datas name
	  * @return array, the treated datas
	  * @access public
	  */
	function treatParams($post, $prefix) {
		$params = parent::treatParams($post, $prefix);
		//if isCurrentUser parameter is selected, then the two others parameters can't be checked
		if ($params['isCurrentUser']) {
			$params['isGroup'] = false;
			$params['multiUserGroup'] = false;
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
		$params = $this->getParamsValues();
		$labels = array();
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				//load user/group
				$userGroup = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getByID($this->_subfieldValues[$subFieldID]->getValue()) : CMS_profile_usersCatalog::getByID($this->_subfieldValues[$subFieldID]->getValue());
				if (is_object($userGroup) && !$userGroup->hasError()) {
					$label = ($params['isGroup']) ? $userGroup->getLabel() : $userGroup->getFirstName().' '.$userGroup->getLastName();
					if ($label) {
						$labels[] = io::htmlspecialchars($label);
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
			$this->setError("Can't write public object");
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
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = parent::getStructure();
		$params = $this->getParamsValues();
		unset($structure['value']);
		if ($params['multiUserGroup']) {
			unset($structure['label']);
			unset($structure['value']);
			$structure['count'] = '';
			$structure['ids'] = '';
			$structure['values'] = '';
			$structure['values']['n']['id'] = '';
			$structure['values']['n']['label'] = '';
			if (!$params['isGroup']) {
				$structure['values']['n']['email'] = '';
			}
		} else {
			$structure['id'] = '';
			if (!$params['isGroup']) {
				$structure['email'] = '';
			}
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
		$params = $this->getParamsValues();
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
			default:
				if (sensitiveIO::isPositiveInteger($name) || $name === "0") {
					if (!is_object($this->_subfieldValues[$name])) {
						return '';
					}
					switch ($parameters) {
						case 'id':
							return $this->_subfieldValues[$name]->getValue();
						break;
						case 'label':
							//load user/group
							$userGroup = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getByID($this->_subfieldValues[$name]->getValue()) : CMS_profile_usersCatalog::getByID($this->_subfieldValues[$name]->getValue());
							if (is_object($userGroup) && !$userGroup->hasError()) {
								return ($params['isGroup']) ? io::htmlspecialchars($userGroup->getLabel()) : io::htmlspecialchars($userGroup->getFirstName().' '.$userGroup->getLastName());
							}
							return '';
						break;
						case 'email':
							//load user/group
							$userGroup = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getByID($this->_subfieldValues[$name]->getValue()) : CMS_profile_usersCatalog::getByID($this->_subfieldValues[$name]->getValue());
							if (is_object($userGroup) && !$userGroup->hasError()) {
								return ($params['isGroup']) ? '' : io::htmlspecialchars($userGroup->getEmail());
							}
							return '';
						break;
					}
				} else {
					if (!isset($this->_subfieldValues[0]) || !is_object($this->_subfieldValues[0])) {
						return '';
					}
					switch ($name) {
						case 'label':
							//load user/group
							$userGroup = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getByID($this->_subfieldValues[0]->getValue()) : CMS_profile_usersCatalog::getByID($this->_subfieldValues[0]->getValue());
							if (is_object($userGroup) && !$userGroup->hasError()) {
								return ($params['isGroup']) ? io::htmlspecialchars($userGroup->getLabel()) : io::htmlspecialchars($userGroup->getFirstName().' '.$userGroup->getLastName());
							}
							return '';
						break;
						case 'email':
							//load user/group
							$userGroup = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getByID($this->_subfieldValues[0]->getValue()) : CMS_profile_usersCatalog::getByID($this->_subfieldValues[0]->getValue());
							if (is_object($userGroup) && !$userGroup->hasError()) {
								return ($params['isGroup']) ? '' : io::htmlspecialchars($userGroup->getEmail());
							}
							return '';
						break;
						case 'id':
							return $this->_subfieldValues[0]->getValue();
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
	function getLabelsStructure(&$language, $objectName = '') {
		$labels = parent::getLabelsStructure($language, $objectName);
		$params = $this->getParamsValues();
		unset($labels['structure']['value']);
		if ($params['multiUserGroup']) {
			unset($labels['structure']['label']);
			unset($labels['structure']['value']);
			$labels['structure']['count'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_COUNT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['ids'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_IDS_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_VALUES_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values:id'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_VALUESID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['values:label'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_VALUESLABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			if (!$params['isGroup']) {
				$labels['structure']['values:email'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_VALUESEMAIL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			}
		} else {
			$labels['structure']['id'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_ID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			$labels['structure']['label'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_LABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			if (!$params['isGroup']) {
				$labels['structure']['email'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_EMAIL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
			}
		}
		$labels['function']['selectOptions'] = $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_FUNCTION_SELECTEDOPTIONS_DESCRIPTION,array('{'.$objectName.'}'),MOD_POLYMOD_CODENAME);
		
		return $labels;
	}
	
	/**
	  * For a given category, return options tag list (for a select tag) of all sub categories
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	selected : the category id which is selected (optional)
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
	  * @return string : options tag list
	  * @access public
	  */
	function selectOptions($values, $tags) {
		$usersGroups = $this->getListOfNamesForObject();
		$return = "";
		if (is_array($usersGroups) && $usersGroups) {
			foreach ($usersGroups as $userGroupID => $userGroupLabel) {
				$selected = ($userGroupID == $values['selected']) ? ' selected="selected"':'';
				$return .= '<option title="'.io::htmlspecialchars($userGroupLabel).'" value="'.$userGroupID.'"'.$selected.'>'.$userGroupLabel.'</option>';
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
		if (!is_array($value)) {
			$value = array($value);
		}
		$sql = "
				select
					distinct objectID
				from
					mod_subobject_integer".$statusSuffix."
				where
					objectFieldID = '".$fieldID."'
					and value in (".SensitiveIO::sanitizeSQLString(implode(',',$value)).")
					$where
				";
		return $sql;
	}
	
	/**
	  * Return a list of all objects names of given type
	  *
	  * @param boolean $public are the needed datas public ? /!\ Does not apply for this type of object
	  * @param array $searchConditions, search conditions to add. /!\ only keywords apply for this type of object
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	function getListOfNamesForObject($public = false, $searchConditions = array()) {
		$params = $this->getParamsValues();
		//load user/group
		$userGroupSorted = ($params['isGroup']) ? CMS_profile_usersGroupsCatalog::getGroupsLabels() : CMS_profile_usersCatalog::getUsersLabels(true, true);
		//filter by keyword if any
		if (isset($searchConditions['keywords']) && $searchConditions['keywords']) {
			$keywords = trim($searchConditions['keywords']);
			foreach ($userGroupSorted as $id => $label) {
				if (stripos($label, $keywords) === false) {
					unset($userGroupSorted[$id]);
				}
			}
		}
		
		// Clean users/groups with enable/disable parameters
		if ($params['isGroup']) {
			$disableGroups = ($params['disableGroups']) ? explode(';',$params['disableGroups']) : array();
			if (is_array($disableGroups) && $disableGroups) {
				if($params['includeExclude']){
					// Include
					foreach($userGroupSorted as $groupId => $label){
						if(!in_array($groupId,$disableGroups)){
							unset($userGroupSorted[$groupId]);
						}
					}
				} else {
					// Exclude
					foreach($userGroupSorted as $groupId => $label){
						if(in_array($groupId,$disableGroups)){
							unset($userGroupSorted[$groupId]);
						}
					}
				}
			}
		} else {
			$disableGroups = ($params['disableGroups']) ? explode(';',$params['disableGroups']) : array();
			$disableUsers = ($params['disableUsers']) ? explode(';',$params['disableUsers']) : array();
			if (is_array($disableGroups) && $disableGroups) {
				if($params['includeExclude']){
					// Include
					foreach($userGroupSorted as $userId => $label){
						foreach($disableGroups as $groupId){
							if(!CMS_profile_usersGroupsCatalog::userBelongsToGroup($userId, $groupId)){
								unset($userGroupSorted[$userId]);
							}
						}
					}
				} else {
					// Exclude
					foreach($userGroupSorted as $userId => $label){
						foreach($disableGroups as $groupId){
							if(CMS_profile_usersGroupsCatalog::userBelongsToGroup($userId, $groupId)){
								unset($userGroupSorted[$userId]);
							}
						}
					}
				}
			}
			if (is_array($disableUsers) && $disableUsers) {
				if($params['includeExclude']){
					// Include
					foreach($userGroupSorted as $groupId => $label){
						if(!in_array($groupId,$disableUsers)){
							unset($userGroupSorted[$groupId]);
						}
					}
				} else {
					// Exclude
					foreach($userGroupSorted as $groupId => $label){
						if(in_array($groupId,$disableUsers)){
							unset($userGroupSorted[$groupId]);
						}
					}
				}
			}
		}
		//sort objects by name case insensitive
		natcasesort($userGroupSorted);
		return $userGroupSorted;
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object categories parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersDisableUsers($language, $prefixName) {
		$params = $this->getParamsValues();
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "disableUsers") {
				// Search all users/groups
				$usersGroups = CMS_profile_usersCatalog::getUsersLabels(true, true);
				//sort and index table
				$userGroupSorted = array();
				foreach ($usersGroups as $userId => $aUserLabel) {
					$userGroupSorted[$userId] = $aUserLabel;
				}
				//sort objects by name case insensitive
				natcasesort($userGroupSorted);
				// Search all selected users/groups
				$associated_items = array();
				if ($params[$parameter["internalName"]]) {
					$associated_items = explode(";",$params[$parameter["internalName"]]);
				}
				//remove deleted users from selected list
				foreach ($associated_items as $key => $userId) {
					if (!isset($userGroupSorted[$userId])) {
						unset($associated_items[$key]);
					}
				}
				// Create usersListboxes
				$s_items_listboxes = CMS_dialog_listboxes::getListBoxes(
					array (
					'field_name' 		=> $prefixName.$parameter['internalName'],	// Hidden field name to get value in
					'items_possible' 	=> $userGroupSorted,								// array of all categories availables: array(ID => label)
					'items_selected' 	=> $associated_items,								// array of selected ids
					'select_width' 		=> '250px',											// Width of selects, default 200px
					'select_height' 	=> '200px',											// Height of selects, default 140px
					'form_name' 		=> 'frm',											// Javascript form name
					'leftTitle'			=> $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_PARAMETER_USERS_LEFT_TITLE,false,MOD_POLYMOD_CODENAME),	// left title
					'rightTitle'		=> $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_PARAMETER_USERS_RIGHT_TITLE,false,MOD_POLYMOD_CODENAME)	// right title
					)
				);
				$input .= $s_items_listboxes;
			}
		}
		return $input;
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object categories parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersDisableGroups($language, $prefixName) {
		$params = $this->getParamsValues();
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "disableGroups") {
				// Search all users/groups
				$usersGroups = CMS_profile_usersGroupsCatalog::getGroupsLabels();
				//sort and index table
				$userGroupSorted = array();
				foreach ($usersGroups as $groupId => $aGroupLabel) {
					$userGroupSorted[$groupId] = $aGroupLabel;
				}
				//sort objects by name case insensitive
				natcasesort($userGroupSorted);
				// Search all selected users/groups
				$associated_items = array();
				if ($params[$parameter["internalName"]]) {
					$associated_items = explode(";",$params[$parameter["internalName"]]);
				}
				//remove deleted groups from selected list
				foreach ($associated_items as $key => $groupId) {
					if (!isset($userGroupSorted[$groupId])) {
						unset($associated_items[$key]);
					}
				}
				// Create usersListboxes
				$s_items_listboxes = CMS_dialog_listboxes::getListBoxes(
					array (
					'field_name' 		=> $prefixName.$parameter['internalName'],	// Hidden field name to get value in
					'items_possible' 	=> $userGroupSorted,								// array of all categories availables: array(ID => label)
					'items_selected' 	=> $associated_items,								// array of selected ids
					'select_width' 		=> '250px',											// Width of selects, default 200px
					'select_height' 	=> '200px',											// Height of selects, default 140px
					'form_name' 		=> 'frm',											// Javascript form name
					'leftTitle'			=> $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_PARAMETER_GROUPS_LEFT_TITLE,false,MOD_POLYMOD_CODENAME),	// left title
					'rightTitle'		=> $language->getMessage(self::MESSAGE_OBJECT_USERGROUP_PARAMETER_GROUPS_RIGHT_TITLE,false,MOD_POLYMOD_CODENAME)	// right title
					)
				);
				$input .= $s_items_listboxes;
			}
		}
		return $input;
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
			$this->_setError(get_class($this)." : getFieldSearchSQL : unkown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		$sql = '';
		
		//choose table
		$fromTable = 'mod_subobject_integer';
		$params = $this->getParamsValues();
		if ($params['isGroup']) {
			// create sql
			$sql = "
			select
				distinct objectID
			from
				".$fromTable.$statusSuffix.",
				profilesUsersGroups
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and objectSubFieldID = '0'
				and value = id_prg
				$where
			order by label_prg ".$direction;
		} else {
			// create sql
			$sql = "
			select
				distinct objectID
			from
				".$fromTable.$statusSuffix.",
				profilesUsers
			where
				objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
				and objectSubFieldID = '0'
				and value = id_pru
				$where
			order by lastName_pru ".$direction.", firstName_pru ".$direction;
		}
		return $sql;
    }
}
?>
