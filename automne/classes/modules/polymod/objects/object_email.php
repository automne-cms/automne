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
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr> & 			  |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: object_email.php,v 1.5 2009/11/10 16:49:01 sebastien Exp $

/**
  * Class CMS_object_email
  *
  * represent an email object
  *
  * @package CMS
  * @subpackage module
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_email extends CMS_object_common
{
	/**
  * Polymod Messages
  */
	const MESSAGE_OBJECT_EMAIL_LABEL = 336;
	const MESSAGE_OBJECT_EMAIL_DESCRIPTION = 337;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SUBJECT = 338;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_BODY = 339;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL = 340;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_DESC = 343;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_FILES = 344;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_FILES_DESC = 345;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_EMAIL_FROM = 346;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_EMAIL_FROM_DESC = 347;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_VALIDATION = 348;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_SYSTEM_EVENT = 349;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON = 350;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_DESC = 351;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_EXPLANATION = 352;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_BODY_PAGE = 353;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_BODY_HTML = 354;
	const MESSAGE_OBJECT_EMAIL_LAST_SENDING = 355;
	const MESSAGE_OBJECT_EMAIL_NEVER = 356;
	const MESSAGE_OBJECT_EMAIL_ACTIVE = 357;
	const MESSAGE_OBJECT_EMAIL_INACTIVE = 358;
	const MESSAGE_OBJECT_EMAIL_TASK_PREPARE_EMAIL_NOTIFICATION = 359;
	const MESSAGE_OBJECT_EMAIL_TASK_SEND_EMAIL_NOTIFICATION = 360;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_EXCLUDE = 320;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_EXCLUDE_DESCRIPTION = 388;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_DISABLEUSERS = 314;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_DISABLEGROUPS = 315;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_USERS_LEFT_TITLE = 316;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_USERS_RIGHT_TITLE = 317;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_GROUPS_LEFT_TITLE = 318;
	const MESSAGE_OBJECT_EMAIL_PARAMETER_GROUPS_RIGHT_TITLE = 319;
	const MESSAGE_OBJECT_EMAIL_MESSAGES_SENT = 427;
	
	const OBJECT_EMAIL_PARAMETER_SEND_ON_VALIDATION = 1;
	const OBJECT_EMAIL_PARAMETER_SEND_ON_SYSTEM_EVENT = 2;
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_EMAIL_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_EMAIL_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'emailNotify',
									),
							1 => array(
										'type' 			=> 'date',
										'required' 		=> false,
										'internalName'	=> 'sendingDate',
									),
							2 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'emailSent',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '', 1 => '', 2 => 0);
	
	/**+
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'emailsubject',
										'required' 		=> true,
										'internalName'	=> 'emailSubject',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_SUBJECT,
									),
							1 => array(
										'type' 			=> 'emailbody',
										'required' 		=> true,
										'internalName'	=> 'emailBody',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_BODY,
									),
							2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'chooseSendEmail',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL,
										'description'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_DESC,
									),
							3 => array(
										'type' 			=> 'sendemailon',
										'required' 		=> false,
										'internalName'	=> 'sendEmailOn',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON,
										'description'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_DESC,
									),
							4 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'includeFiles',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_FILES,
										'description'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_FILES_DESC,
									),
							5 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'emailFrom',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_EMAIL_FROM,
										'description'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_EMAIL_FROM_DESC,
									),
							6 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'includeExclude',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_EXCLUDE,
										'description'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_INCLUDE_EXCLUDE_DESCRIPTION,
									),
						 	 7 => array(
										'type' 			=> 'disableUsers',
										'required' 		=> false,
										'internalName'	=> 'disableUsers',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_DISABLEUSERS,
									),
							 8 => array(
										'type' 			=> 'disableGroups',
										'required' 		=> false,
										'internalName'	=> 'disableGroups',
										'externalName'	=> self::MESSAGE_OBJECT_EMAIL_PARAMETER_DISABLEGROUPS,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(	0 => '',
									1 => '',
									2 => false,
									3 => self::OBJECT_EMAIL_PARAMETER_SEND_ON_VALIDATION,
									4 => false,
									5 => '',
									6 => false, 
									7 => '', 
									8 => '',);
	
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
	function checkMandatory($values,$prefixName) {
		return true;
	}
	
	/**
	  * get object label : by default, the first subField value (used to designate this object in lists)
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		$params = $this->getParamsValues();
		
		if (!is_object($this->_subfieldValues[0])) {
			$this->raiseError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		global $cms_language;
		if (!is_object($cms_language)) {
			$this->raiseError("Language currently instancied");
			return $this->_subfieldValues[0]->getValue();
		}
		if ($params['chooseSendEmail']) {
			return ($this->_subfieldValues[0]->getValue()) ? $cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_ACTIVE, false, MOD_POLYMOD_CODENAME) : $cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_INACTIVE, false, MOD_POLYMOD_CODENAME);
		} else {
			//instanciate sending date object
			$sendingDate = new CMS_date();
			$sendingDate->setFromDBValue($this->_subfieldValues[1]->getValue());
			if ($sendingDate->isNull()) {
				$lastSendingDate = $cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_NEVER, false, MOD_POLYMOD_CODENAME);
			} else {
				$lastSendingDate = $sendingDate->getLocalizedDate($cms_language->getDateFormat()).' '.date('H:i:s',$sendingDate->getTimestamp()).($this->_subfieldValues[2]->getValue() ? ' ('.$this->_subfieldValues[2]->getValue().' '.$cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_MESSAGES_SENT, false, MOD_POLYMOD_CODENAME).')' : '');
			}
			return $lastSendingDate;
		}
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
		global $moduleCodename;
		$parameters = $this->getSubFieldParameters();
		//treat all parameters by parent method
		$params = parent::treatParams($post, $prefix);
		//if parameters are not correct, return
		if ($params === false) {
			return false;
		}
		//then retreat some parameters specific to this object
		$module = CMS_modulesCatalog::getByCodename($moduleCodename);
		foreach($parameters as $aParameter) {
			$paramType = $aParameter['type'];
			switch ($paramType) {
				case 'emailsubject':
					$params[$aParameter['internalName']] = $module->convertDefinitionString($params[$aParameter['internalName']], false);
				break;
				case 'emailbody':
					$bodyType = $post[$prefix.'emailBody'];
					$bodyPageId = (int) $post[$prefix.'emailBody_pageID'];
					$bodyHTML = $post[$prefix.'emailBody_html'];
					$bodyPageURL = $post[$prefix.'emailBody_pageURL'];
					if (!$bodyType || ($bodyType == 1 && !$bodyHTML) || ($bodyType == 2 && !$bodyPageId)) {
						return false;
					}
					$params[$aParameter['internalName']] = array(
						'type' 		=> $bodyType,
						'pageID'	=> $bodyPageId,
						'html' 		=> $module->convertDefinitionString($bodyHTML, false),
						'pageURL'	=> $module->convertDefinitionString($bodyPageURL, false),
					);
				break;
			}
		}
		return $params;
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
				$usersGroups = CMS_profile_usersCatalog::getAll();
				//sort and index table
				$userGroupSorted = array();
				foreach ($usersGroups as $aUserGroup) {
					if ($aUserGroup->isActive()) {
						$userGroupSorted[$aUserGroup->getUserId()] = $aUserGroup->getLastName().' '.$aUserGroup->getFirstName();
					}
				}
				//sort objects by name case insensitive
				natcasesort($userGroupSorted);
				$allIDs = $userGroupSorted;
				// Search all selected users/groups
				$associated_items = array();
				if ($params[$parameter["internalName"]]) {
					$associated_items = explode(";",$params[$parameter["internalName"]]);
				}
				// Create usersListboxes
				$s_items_listboxes = CMS_dialog_listboxes::getListBoxes(
					array (
					'field_name' 		=> $prefixName.$parameter['internalName'],	// Hidden field name to get value in
					'items_possible' 	=> $allIDs,											// array of all categories availables: array(ID => label)
					'items_selected' 	=> $associated_items,								// array of selected ids
					'select_width' 		=> '250px',											// Width of selects, default 200px
					'select_height' 	=> '200px',											// Height of selects, default 140px
					'form_name' 		=> 'frm',											// Javascript form name
					'leftTitle'			=> $language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_USERS_LEFT_TITLE,false,MOD_POLYMOD_CODENAME),	// left title
					'rightTitle'		=> $language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_USERS_RIGHT_TITLE,false,MOD_POLYMOD_CODENAME)	// right title
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
				$usersGroups = CMS_profile_usersGroupsCatalog::getAll();
				//sort and index table
				$userGroupSorted = array();
				foreach ($usersGroups as $aUserGroup) {
					$userGroupSorted[$aUserGroup->getGroupId()] = $aUserGroup->getLabel();
				}
				//sort objects by name case insensitive
				natcasesort($userGroupSorted);
				$allIDs = $userGroupSorted;
				// Search all selected users/groups
				$associated_items = array();
				if ($params[$parameter["internalName"]]) {
					$associated_items = explode(";",$params[$parameter["internalName"]]);
				}
				// Create usersListboxes
				$s_items_listboxes = CMS_dialog_listboxes::getListBoxes(
					array (
					'field_name' 		=> $prefixName.$parameter['internalName'],	// Hidden field name to get value in
					'items_possible' 	=> $allIDs,											// array of all categories availables: array(ID => label)
					'items_selected' 	=> $associated_items,								// array of selected ids
					'select_width' 		=> '250px',											// Width of selects, default 200px
					'select_height' 	=> '200px',											// Height of selects, default 140px
					'form_name' 		=> 'frm',											// Javascript form name
					'leftTitle'			=> $language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_GROUPS_LEFT_TITLE,false,MOD_POLYMOD_CODENAME),	// left title
					'rightTitle'		=> $language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_GROUPS_RIGHT_TITLE,false,MOD_POLYMOD_CODENAME)	// right title
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
	function getHTMLSubFieldsParametersEmailSubject($language, $prefixName) {
		global $moduleCodename;
		$module = CMS_modulesCatalog::getByCodename($moduleCodename);
		$params = $this->getParamsValues();
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "emailsubject") {
				$input = '<textarea class="admin_textarea" cols="100" rows="5" name="'.$prefixName.$parameter['internalName'].'">'.$module->convertDefinitionString($params[$parameter["internalName"]],true).'</textarea>';
			}
		}
		return $input;
	}
	function getHTMLSubFieldsParametersEmailBody($language, $prefixName) {
		global $cms_language, $moduleCodename, $object;
		$module = CMS_modulesCatalog::getByCodename($moduleCodename);
		$params = $this->getParamsValues();
		$values = $this->_parameterValues;
		$parameters = $this->getSubFieldParameters();
		$htmlSelected = (!isset($params['emailBody']['type']) || $params['emailBody']['type'] == 1) ? ' checked="checked"' : '';
		$input = '
		<fieldset>
			<legend><label for="'.$prefixName.'message_body_html"><input'.$htmlSelected.' id="'.$prefixName.'message_body_html" type="radio" name="'.$prefixName.'emailBody" value="1" />'.$cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_BODY_HTML, false, MOD_POLYMOD_CODENAME).'</label></legend>';
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "emailbody") {
				$html = (isset($params['emailBody']['html'])) ? $params['emailBody']['html'] : '';
				$input .= '<textarea class="admin_textarea" cols="100" rows="15" name="'.$prefixName.'emailBody_html">'.$module->convertDefinitionString($html,true).'</textarea>';
			}
		}
		$pageSelected = (isset($params['emailBody']['type']) && $params['emailBody']['type'] == 2) ? ' checked="checked"' : '';
		$pageID = (isset($params['emailBody']['pageID'])) ? $params['emailBody']['pageID'] : '';
		$pageURL = (isset($params['emailBody']['pageURL'])) ? $params['emailBody']['pageURL'] : '';
		$input.='
		</fieldset>
		<fieldset>
			<legend><label for="'.$prefixName.'message_body_page"><input'.$pageSelected.' id="'.$prefixName.'message_body_page" type="radio" name="'.$prefixName.'emailBody" value="2" />'.$cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_BODY_PAGE, false, MOD_POLYMOD_CODENAME).'</label></legend>
			<input type="text" class="admin_input_text" id="'.$prefixName.'emailBody_pageID" name="'.$prefixName.'emailBody_pageID" value="'.io::htmlspecialchars($pageID).'" size="6" />';
			//build tree link
			$grand_root = CMS_tree::getRoot();
			$href = PATH_ADMIN_SPECIAL_TREE_WR;
			$href .= '?root='.$grand_root->getID();
			$href .= '&amp;heading='.$cms_language->getMessage(MESSAGE_PAGE_TREEH1);
			$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('".$prefixName."emailBody_pageID').value = '%s';self.close();");
			$href .= '&encodedPageLink='.base64_encode('false');
			$input .= '&nbsp;<a href="'.$href.'" class="admin" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR. '/picto-arbo.gif" border="0" align="absmiddle" /></a>
			&nbsp;?<input type="text" size="80" name="'.$prefixName.'emailBody_pageURL" value="'.io::htmlspecialchars($module->convertDefinitionString($pageURL,true)).'" class="admin_input_text" />
		</fieldset>';
		
		//object Explanation
		$input .= '
			<fieldset>
				<legend>'.$cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_PARAMETER_EXPLANATION, false, MOD_POLYMOD_CODENAME).'</legend>
				<br />';
			if (!isset($_POST['objectexplanation'])) $_POST['objectexplanation'] = '';
			//selected value
			$selected['working'] = ($_POST['objectexplanation'] == 'working') ? ' selected="selected"':'';
			$selected['search'] = ($_POST['objectexplanation'] == 'search') ? ' selected="selected"':'';
			$selected['vars'] = ($_POST['objectexplanation'] == 'vars') ? ' selected="selected"':'';
			
			$input.= '
			<select name="objectexplanation" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
				<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
				<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
					<option value="search"'.$selected['search'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
					<option value="working"'.$selected['working'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
					<option value="vars"'.$selected['vars'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS,false,MOD_POLYMOD_CODENAME).'</option>
				</optgroup>
				<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
					$input.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $object->getID());
				$input.= '
				</optgroup>';
			$input.= '
			</select><br /><br />';
			
			//then display chosen object infos
			if ($_POST['objectexplanation']) {
				switch ($_POST['objectexplanation']) {
					case 'search':
						$input.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION,array(implode(', ',CMS_object_search::getStaticSearchConditionTypes()), implode(', ',CMS_object_search::getStaticOrderConditionTypes())),MOD_POLYMOD_CODENAME);
					break;
					case 'working':
						$input.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
					break;
					case 'vars':
						$input.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
					break;
					default:
						//object info
						$input.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
					break;
				}
			}
		$input.='</fieldset>';
		return $input;
	}
	function getHTMLSubFieldsParametersSendEmailOn($language, $prefixName) {
		global $cms_language;
		$params = $this->getParamsValues();
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = isset($values[$parameterID]) ? $values[$parameterID] : null;
			if ($parameter["type"] == "sendemailon") {
				$input = '<select name="'.$prefixName.$parameter['internalName'].'" class="admin_input_text">';
				$values = array(
					self::OBJECT_EMAIL_PARAMETER_SEND_ON_VALIDATION => 	self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_VALIDATION,
					self::OBJECT_EMAIL_PARAMETER_SEND_ON_SYSTEM_EVENT =>	self::MESSAGE_OBJECT_EMAIL_PARAMETER_SEND_EMAIL_ON_SYSTEM_EVENT
				);
				foreach ($values as $value => $languageValue) {
					$selected = ($value == $params[$parameter["internalName"]]) ? ' selected="selected"' : '';
					$input .= '<option value="'.$value.'"'.$selected.'>'.$cms_language->getMessage($languageValue, false, MOD_POLYMOD_CODENAME).'</option>';
				}
				$input .= '</select>';
			}
		}
		return $input;
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
			case 'label':
				return $this->getLabel();
			break;
			case 'value':
				return $this->_subfieldValues[0]->getValue();
			break;
			default:
				return parent::getValue($name, $parameters);
			break;
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
		$params = $this->getParamsValues();
		
		//instanciate sending date object
		$sendingDate = new CMS_date();
		$sendingDate->setFromDBValue($this->_subfieldValues[1]->getValue());
		if ($sendingDate->isNull()) {
			$lastSendingDate = $language->getMessage(self::MESSAGE_OBJECT_EMAIL_NEVER, false, MOD_POLYMOD_CODENAME);
		} else {
			$lastSendingDate = $sendingDate->getLocalizedDate($language->getDateFormat()).' '.date('H:i:s',$sendingDate->getTimestamp());
		}
		
		$label = $return['title'];
		$return = array(
			'layout'	=> 'column',
			'xtype'		=> 'panel',
			'border'	=> false,
			'items'		=> array(
				($params['chooseSendEmail'] ? 
					array(
						'width'			=> '100%',
						'layout'		=> 'form',
						'border'		=> false,
						'items'			=> array(array(
							'id'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]',
							'name'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]',
							'xtype'			=> 'checkbox',
							'fieldLabel'	=> '&nbsp;',
							'labelSeparator'=> '',
							'inputValue'	=> 1,
							'anchor'		=> false,
							'checked'		=> !!$this->_subfieldValues[0]->getValue(),
							'boxLabel'		=> $label.'&nbsp;<small>('.$language->getMessage(self::MESSAGE_OBJECT_EMAIL_LAST_SENDING, false, MOD_POLYMOD_CODENAME).' : '.$lastSendingDate.')</small>'
						))
					)
				 : array(
						'width'			=> '100%',
						'layout'		=> 'fit',
						'border'		=> true,
						'padding'		=> '5',
						'bodyStyle'		=> 'margin:10px 0 15px 0',
						'html'			=> $label.' : '.$language->getMessage(self::MESSAGE_OBJECT_EMAIL_LAST_SENDING, false, MOD_POLYMOD_CODENAME).' : '.$lastSendingDate
					)
				)
				,array(
					'columnWidth'	=> 1,
					'layout'		=> 'form',
					'border'		=> false,
					'hideLabels'	=> true,
					'items'			=> array(array(
						'xtype'			=> 'hidden',
						'value'			=> $this->_subfieldValues[1]->getValue(),
						'id'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]',
						'name'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]'
					),array(
						'xtype'			=> 'hidden',
						'value'			=> $this->_subfieldValues[2]->getValue(),
						'id'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_2]',
						'name'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_2]'
					))
				)
			)
		);
		if (!$params['chooseSendEmail']) {
			$return['items'][1]['items'][] = array(
				'xtype'			=> 'hidden',
				'value'			=> 1,
				'id'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]',
				'name'			=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]'
			);
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
		
		//instanciate sending date object
		$sendingDate = new CMS_date();
		$sendingDate->setFromDBValue($this->_subfieldValues[1]->getValue());
		
		//append field id to html field parameters (if not already exists)
		$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_0"' : '';
		
		if ($params['chooseSendEmail']) {
			$checked = ($this->_subfieldValues[0]->getValue() == '1') ? 'checked="checked"' : '';
			$html .= '
			<input'.$htmlParameters.' type="checkbox" '.$checked.' name="'.$prefixName.$this->_field->getID().'_0" value="1" />
			<input type="hidden" name="'.$prefixName.$this->_field->getID().'_1" value="'.$sendingDate->getLocalizedDate($language->getDateFormat()).'" />
			<input type="hidden" name="'.$prefixName.$this->_field->getID().'_2" value="0" />';
		} else {
			$html .= '
			<input type="hidden" name="'.$prefixName.$this->_field->getID().'_0" value="1" />
			<input type="hidden" name="'.$prefixName.$this->_field->getID().'_1" value="'.$sendingDate->getLocalizedDate($language->getDateFormat()).'" />
			<input type="hidden" name="'.$prefixName.$this->_field->getID().'_2" value="0" />';
		}
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		if (POLYMOD_DEBUG) {
			$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Value : '.$this->_subfieldValues[0]->getValue().' - '.$this->_subfieldValues[1]->getValue().')</span>';
		}
		return $html;
	}
	
	/**
	  * Current object pass the validation process
	  *
	  * @param integer : the validation status
	  * @param CMS_poly_object : the reference of the object currently validated
	  * @return boolean
	  * @access public
	  */
	function afterValidation($validationResult, &$validatedObject) {
		$params = $this->getParamsValues();
		// Check if sending is done by validation, if object validation is accepted, object is in user space, and fieldValue is checked
		if ($params['sendEmailOn'] == self::OBJECT_EMAIL_PARAMETER_SEND_ON_VALIDATION 
			&& $validationResult == VALIDATION_OPTION_ACCEPT 
			&& $validatedObject->isInUserSpace() 
			&& $this->_subfieldValues[0]->getValue() == 1){
			$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			//add script to send email for user if needed
			CMS_scriptsManager::addScript($module, array('task' => 'emailNotification', 'field' => $this->_field->getID(), 'object' => $validatedObject->getID()));
			//then launch scripts execution
			CMS_scriptsManager::startScript();
		}
		return true;
	}
	
	/**
	  * Module script task
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		object : string module codename for the task
	  *		field : string module uid
	  *		...	: optional field relative parameters
	  * @return Boolean true/false
	  * @access public
	  */
	function scriptTask($parameters) {
		switch ($parameters['task']) {
			case 'emailNotification':
				@set_time_limit(300);
				$module = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//create a new script for all users
				$allUsers = CMS_profile_usersCatalog::getAll(true, false, false);
				foreach ($allUsers as $userId) {
					//add script to send email for user if needed
					CMS_scriptsManager::addScript($module, array('task' => 'emailSend', 'user' => $userId, 'field' => $parameters['field'], 'object' => $parameters['object']));
				}
				//then set sending date to current date
				$sendingDate = new CMS_date();
				$sendingDate->setNow();
				$this->_subfieldValues[1]->setValue($sendingDate->getDBValue());
				$this->writeToPersistence();
			break;
			case 'emailSend':
				@set_time_limit(300);
				$params = $this->getParamsValues();
				if (!sensitiveIO::isPositiveInteger($parameters['user'])) {
					return false;
				}
				//instanciate script related item
				$item = CMS_poly_object_catalog::getObjectByID($parameters['object'],false,true);
				if (!is_object($item) || $item->hasError()) {
					return false;
				}
				//instanciate user
				$cms_user = new CMS_profile_user($parameters['user']);
				if (!$cms_user || $cms_user->hasError() || !sensitiveIO::isValidEmail($cms_user->getEmail())) {
					return false;
				}
				//check if user is in included or excluded parameters lists
				$selectedGroups = ($params['disableGroups']) ? explode(';',$params['disableGroups']) : array();
				$selectedUsers = ($params['disableUsers']) ? explode(';',$params['disableUsers']) : array();
				if($params['includeExclude']){
					//user must be in selected groups or users to get email
					$userId = $cms_user->getUserId();
					$userSelected = false;
					if (is_array($selectedGroups) && $selectedGroups) {
						foreach($selectedGroups as $groupId){
							if(CMS_profile_usersGroupsCatalog::userBelongsToGroup($userId, $groupId)){
								$userSelected = true;
							}
						}
					}
					if (is_array($selectedUsers) && $selectedUsers && in_array($userId,$selectedUsers)) {
						$userSelected = true;
					}
				} else {
					//user must NOT be in selected groups or users to get email
					$userId = $cms_user->getUserId();
					$userSelected = true;
					if (is_array($selectedGroups) && $selectedGroups) {
						foreach($selectedGroups as $groupId){
							if(CMS_profile_usersGroupsCatalog::userBelongsToGroup($userId, $groupId)){
								$userSelected = false;
							}
						}
					}
					if (is_array($selectedUsers) && $selectedUsers && in_array($userId,$selectedUsers)) {
						$userSelected = false;
					}
				}
				if (!$userSelected) {
					return false;
				}
				
				$cms_language = $cms_user->getLanguage();
				//globalise cms_user and cms_language
				$GLOBALS['cms_language'] = $cms_user->getLanguage();
				$GLOBALS['cms_user'] = $cms_user;
				//check user clearance on object
				if (!$item->userHasClearance($cms_user, CLEARANCE_MODULE_VIEW)) {
					return false;
				}
				//create email subject
				$parameters['item'] = $item;
				$parameters['public'] = true;
				$polymodParsing = new CMS_polymod_definition_parsing($params['emailSubject'], false);
				$subject = $polymodParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
				$body = '';
				//create email body
				if ($params['emailBody']['type'] == 1) {
					//send body
					$parameters['module'] = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
					$polymodParsing = new CMS_polymod_definition_parsing($params['emailBody']['html'], true, CMS_polymod_definition_parsing::PARSE_MODE, $parameters['module']);
					$body = $polymodParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
				} elseif ($params['emailBody']['type'] == 2) {
					//send a page
					$page = CMS_tree::getPageById($params['emailBody']['pageID']);
					if (!$page || $page->hasError()) {
						$this->raiseError('Page ID is not a valid page : '.$params['emailBody']['pageID']);
						return false;
					}
					$pageHTMLFile = new CMS_file($page->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM));
					if (!$pageHTMLFile->exists()) {
						$this->raiseError('Page HTML file does not exists : '.$page->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM));
						return false;
					}
					$body = $pageHTMLFile->readContent();
					//create page URL call
					$polymodParsing = new CMS_polymod_definition_parsing($params['emailBody']['pageURL'], false);
					$pageURL = $polymodParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
					parse_str($pageURL,$GLOBALS['_REQUEST']);
					//$GLOBALS['_REQUEST']
					
					//parse and eval HTML page
					$cms_page_included = true;
					$GLOBALS['cms_page_included'] = $cms_page_included;
					//eval() the PHP code
					$body = sensitiveIO::evalPHPCode($body);
					
					$website = $page->getWebsite();
					$webroot = $website->getURL();
					//replace URLs values
					$replace = array(
						'="/' => '="'.$webroot.'/',
						"='/" => "='".$webroot."/",
						"url(/" => "url(".$webroot."/",
					);
					$body = str_replace(array_keys($replace), $replace, $body);
					
				} else {
					$this->raiseError('No valid email type to send : '.$params['emailBody']['type']);
					return false;
				}
				if (isset($sendmail)) {
					//$body .= print_r($sendmail,true);
				}
				//drop email sending
				if (isset($sendmail) && $sendmail === false) {
					return false;
				}
				
				//if no body for email or if sendmail var is set to false, quit
				if (!$body) {
					$this->raiseError('No email body to send ... Email parameters : user : '.$parameters['user'].' - object '.$parameters['object']);
					return false;
				}
				
				//This code is for debug purpose only.
				//$testFile = new CMS_file('/test/test_'.$cms_user->getUserId().'.php', CMS_file::WEBROOT);
				//$testFile->setContent($body);
				//$testFile->writeToPersistence();
				
				// Set email
				$email = new CMS_email();
				$email->setSubject($subject);
				$email->setEmailHTML($body);
				$email->setEmailTo($cms_user->getEmail());
				if ($params['includeFiles']) {
					//check for file fields attached to object
					$files = array();
					$this->_getFieldsFiles($item, $files);
					if (sizeof($files)) {
						foreach ($files as $file) {
							$email->setFile($file);
						}
					}
				}
				
				//set email From
				if (!$params['emailFrom']) {
					$email->setFromName(APPLICATION_LABEL);
					$email->setEmailFrom(APPLICATION_POSTMASTER_EMAIL);
				} else {
					$email->setFromName($params['emailFrom']);
					$email->setEmailFrom($params['emailFrom']);
				}
				//Send
				if ($email->sendEmail()) {
					//store email sent number
					$this->_subfieldValues[2]->setValue($this->_subfieldValues[2]->getValue() + 1);
					$this->writeToPersistence();
					return true;
				} else {
					return false;
				}
			break;
			default:
				$this->raiseError('No valid task given : '.$parameters['task']);
				return false;
			break;
		}
	}
	protected function _getFieldsFiles($item, &$files) {
		//get object fields definitions
		$objectFields = CMS_poly_object_catalog::getFieldsDefinition($item->getObjectID());
		$itemFieldsObjects =& $item->getFieldsObjects();
		foreach ($itemFieldsObjects as $fieldID => $itemField) {
			//check field type
			$fieldType = $objectFields[$fieldID]->getValue('type');
			if (sensitiveIO::isPositiveInteger($fieldType)) {
				//this field is a poly_object so recurse on his values
				$this->_getFieldsFiles($itemField, $files);
			} elseif (io::strpos($fieldType,"multi|") !== false) {
				//this field is a multi_poly_object so recurse on all poly_objects it contain
				$params = $itemField->getParamsValues();
				if ($itemField->getValue('count')) {
					$items = $itemField->getValue('fields');
					foreach ($items as $anItem) {
						$this->_getFieldsFiles($anItem, $files);
					}
				}
			} else {
				//if this field is a file, check for file
				if ($fieldType == 'CMS_object_file') {
					if ($itemField->getValue('filename')) {
						$files[] = PATH_REALROOT_FS.$itemField->getValue('filePath').'/'.$itemField->getValue('filename');
					}
				}
			}
		}
		return;
	}
	
	/**
	  * Module script info : get infos for a given script parameters
	  *
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		module : string module codename for the task
	  *		uid : string module uid
	  * @return string : HTML scripts infos
	  * @access public
	  */
	function scriptInfo($parameters) {
		global $cms_language;
		if ($parameters['task'] == 'emailNotification') {
			return $cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_TASK_PREPARE_EMAIL_NOTIFICATION, false, MOD_POLYMOD_CODENAME);
		} elseif ($parameters['task'] == 'emailSend') {
			return $cms_language->getMessage(self::MESSAGE_OBJECT_EMAIL_TASK_SEND_EMAIL_NOTIFICATION, false, MOD_POLYMOD_CODENAME);
		} else {
			return parent::scriptInfo($parameters);
		}
	}
}
?>