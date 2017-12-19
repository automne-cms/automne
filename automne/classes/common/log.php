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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: log.php,v 1.6 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_log
  *
  * Keeps track of logs
  *
  * @package Automne
  * @subpackage common
  * @author Andre Haynes <andre.haynes@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_log extends CMS_grandFather
{
	/**
	  * Log actions
	  */
	const LOG_ACTION_RESOURCE_EDIT_BASEDATA = 1;
	const LOG_ACTION_RESOURCE_EDIT_CONTENT = 2;
	const LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER = 16;
	const LOG_ACTION_RESOURCE_EDIT_MOVE = 32;
	const LOG_ACTION_RESOURCE_DELETE = 3;
	const LOG_ACTION_RESOURCE_UNDELETE = 4;
	const LOG_ACTION_RESOURCE_ARCHIVE = 5;
	const LOG_ACTION_RESOURCE_UNARCHIVE = 6;
	const LOG_ACTION_RESOURCE_CANCEL_EDITIONS = 7;
	const LOG_ACTION_RESOURCE_VALIDATE_EDITION = 8;
	const LOG_ACTION_RESOURCE_START_DRAFT = 30;
	const LOG_ACTION_RESOURCE_EDIT_DRAFT = 25;
	const LOG_ACTION_RESOURCE_DELETE_DRAFT = 26;
	const LOG_ACTION_RESOURCE_SUBMIT_DRAFT = 27;
	const LOG_ACTION_RESOURCE_DIRECT_VALIDATION = 34;
	
	const LOG_ACTION_WEBSITE_ADD = 9;
	const LOG_ACTION_WEBSITE_EDIT = 10;
	const LOG_ACTION_WEBSITE_DELETE = 11;
	
	const LOG_ACTION_PROFILE_GROUP_EDIT = 12;
	const LOG_ACTION_PROFILE_GROUP_DELETE = 13;
	const LOG_ACTION_PROFILE_USER_EDIT = 14;
	const LOG_ACTION_PROFILE_USER_DELETE = 15;
	
	const LOG_ACTION_TEMPLATE_EDIT = 20;
	const LOG_ACTION_TEMPLATE_EDIT_ROW = 21;
	const LOG_ACTION_TEMPLATE_DELETE = 22;
	const LOG_ACTION_TEMPLATE_DELETE_ROW = 23;
	
	const LOG_ACTION_TEMPLATE_DELETE_FILE = 24;
	const LOG_ACTION_TEMPLATE_EDIT_FILE = 29;
	
	const LOG_ACTION_SEND_EMAIL = 28;
	
	const LOG_ACTION_AUTO_LOGIN = 31;
	const LOG_ACTION_LOGIN = 33;
	const LOG_ACTION_DISCONNECT = 35;
	
	/**
	  * Log actions messages
	  */
	const MESSAGE_LOG_ACTION_RESOURCE_EDIT_BASEDATA = 871;
	const MESSAGE_LOG_ACTION_RESOURCE_EDIT_CONTENT = 872;
	const MESSAGE_LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER = 911;
	const MESSAGE_LOG_ACTION_RESOURCE_EDIT_MOVE = 593;
	const MESSAGE_LOG_ACTION_RESOURCE_DELETE = 873;
	const MESSAGE_LOG_ACTION_RESOURCE_UNDELETE = 874;
	const MESSAGE_LOG_ACTION_RESOURCE_ARCHIVE = 875;
	const MESSAGE_LOG_ACTION_RESOURCE_UNARCHIVE = 876;
	const MESSAGE_LOG_ACTION_RESOURCE_CANCEL_EDITIONS = 877;
	const MESSAGE_LOG_ACTION_RESOURCE_VALIDATE_EDITION = 878;
	const MESSAGE_LOG_ACTION_RESOURCE_START_DRAFT = 1568;
	const MESSAGE_LOG_ACTION_RESOURCE_EDIT_DRAFT = 1428;
	const MESSAGE_LOG_ACTION_RESOURCE_DELETE_DRAFT = 1429;
	const MESSAGE_LOG_ACTION_RESOURCE_SUBMIT_DRAFT = 1430;
	const MESSAGE_LOG_ACTION_RESOURCE_DIRECT_VALIDATION = 1592;
	
	const MESSAGE_LOG_ACTION_WEBSITE_ADD = 879;
	const MESSAGE_LOG_ACTION_WEBSITE_EDIT = 880;
	const MESSAGE_LOG_ACTION_WEBSITE_DELETE = 881;
	
	const MESSAGE_LOG_ACTION_PROFILE_GROUP_EDIT = 882;
	const MESSAGE_LOG_ACTION_PROFILE_GROUP_DELETE = 883;
	const MESSAGE_LOG_ACTION_PROFILE_USER_EDIT = 884;
	const MESSAGE_LOG_ACTION_PROFILE_USER_DELETE = 885;
	  
	const MESSAGE_LOG_ACTION_TEMPLATE_EDIT = 890;
	const MESSAGE_LOG_ACTION_TEMPLATE_EDIT_ROW = 891;
	const MESSAGE_LOG_ACTION_TEMPLATE_DELETE = 892;
	const MESSAGE_LOG_ACTION_TEMPLATE_DELETE_ROW = 893;
	
	const MESSAGE_LOG_ACTION_TEMPLATE_EDIT_FILE = 1110;
	const MESSAGE_LOG_ACTION_TEMPLATE_DELETE_FILE = 638;
	
	const MESSAGE_LOG_ACTION_SEND_EMAIL = 573;
	
	const MESSAGE_LOG_ACTION_AUTO_LOGIN = 1572;
	const MESSAGE_LOG_ACTION_LOGIN = 1571;
	const MESSAGE_LOG_ACTION_DISCONNECT = 1739;
	
	/**
	  * Id
	  *
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * User
	  *
	  * @var CMS_user
	  * @access private
	  */
	protected $_user;
	
	/**
	  * Action
	  *
	  * @var integer
	  * @access private
	  */
	protected $_action;
	
	/**
	  * Status of resource after 
	  *
	  * @var CMS_resourceStatus
	  * @access private
	  */
	protected $_resourceStatusAfter;
	
	/**
	  * Date and time of log
	  *
	  * @var CMS_date
	  * @access private
	  */
	protected $_datetime;
	
	/**
	  * Text Data
	  *
	  * @var string
	  * @access private
	  */
	protected $_textData;
	
	/**
	  * Label
	  *
	  * @var string
	  * @access private
	  */
	protected $_label;
	
	/**
	  * module 
	  * stored privately as codename
	  *
	  * @var string
	  * @access private
	  */
	protected $_module;
	
	/**
	  * resource
	  * stored privately as integer
	  *
	  * @var integer
	  * @access private
	  */
	protected $_resource;
	
	/**
	  * Constructor.
	  *
	  * @return void
	  * @access public
	  */
	public function __construct($id = 0, $user = false)
	{
		// Loads up CMS_log with Id from database or with DB array
		if ($id) {
			if (SensitiveIO::isPositiveInteger($id)) {
				$sql = "
					select
						*
					from
						log
					where
						id_log='".$id."'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$this->_id = $id;
					$data = $q->getArray();
				} else {
					$this->setError("Unknown DB ID : ".$id);
					return;
				}
			} elseif (is_array($id)) {
				$data = $id;
				$this->_id = $data['id_log'];
			} else {
				$this->setError("Id is not a positive integer nor array");
				return;
			}
			if (is_array($data) && $data) {
				if ($user === false) {
					$this->_user = new CMS_profile_user($data["user_log"]);
				} else {
					$this->_user = $user;
				}
				$this->_action = $data["action_log"];
				$date = new CMS_date();
				$date->setFromDBValue($data["datetime_log"]);
				$this->_datetime = $date;
				$this->_textData = $data["textData_log"];
				$this->_label = $data["label_log"];
			    $this->_module = $data["module_log"];
				$this->_resource = $data["resource_log"];
				
				// Create resource objects and populate
				$this->_resourceStatusAfter = new CMS_resourceStatus();
				$this->_resourceStatusAfter->setDebug(false);
				$this->_resourceStatusAfter->setLog(false);
				$this->_resourceStatusAfter->setLocation($data["rsAfterLocation_log"]);
				$this->_resourceStatusAfter->setProposedFor($data["rsAfterProposedFor_log"]);
				$this->_resourceStatusAfter->setAllEditions($data["rsAfterEditions_log"]);
				$this->_resourceStatusAfter->setAllValidationsRefused($data["rsAfterValidationsRefused_log"]);
				$this->_resourceStatusAfter->setPublication($data["rsAfterPublication_log"]);
				//specific draft status
				if ($this->_action == CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT) {
					$this->_resourceStatusAfter->setDraft(true);
				}
			}
		} else {
			$this->_user = new CMS_profile_user();
			$this->_resourceStatusAfter = new CMS_resourceStatus();
			$this->_datetime = new CMS_date();
		}
	}
	
	public function getID() {
		return $this->_id;
	}
	
	/**
	  * Record log in database for page or module
	  *
	  * @param integer action
	  * @param CMS_profile_user user 
	  * @param string $module the module codename
	  * @param CMS_resourceStatus resourceStatusAfter
	  * @param string textData
	  * @param CMS_resource resource
	  * @return void
	  * @access public
	  */
	public function logResourceAction($action, &$user, $module, &$resourceStatusAfter, $textData, $resource)
	{
		$this->setLogAction($action);
		$this->_setUser($user);
		$this->_setModule($module);
		$this->_setResourceStatusAfter($resourceStatusAfter);
		$this->setTextData($textData);
		$this->setResource($resource);
		$this->_datetime = new CMS_Date;
		$this->_datetime->setNow();
		
		if (!$this->hasError()) {
			$sql_fields = "
				user_log='".SensitiveIO::sanitizeSQLString($this->_user->getUserId())."',
				action_log='".SensitiveIO::sanitizeSQLString($this->_action)."',
				datetime_log='".SensitiveIO::sanitizeSQLString($this->_datetime->getDBValue())."',
				textData_log='".SensitiveIO::sanitizeSQLString($this->_textData)."',
				label_log='".SensitiveIO::sanitizeSQLString($this->_label)."',
				module_log='".SensitiveIO::sanitizeSQLString($this->_module)."',
				resource_log='".SensitiveIO::sanitizeSQLString($this->_resource)."',
				rsAfterLocation_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getLocation())."',
				rsAfterProposedFor_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getProposedFor())."',
				rsAfterEditions_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getEditions())."',
				rsAfterValidationsRefused_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getValidationRefused())."',
				rsAfterPublication_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getPublication())."'	
			";
			if ($this->_id) {
				$sql = "
					update
						log
					set
						".$sql_fields."
					where
						id_log='".$this->_id."'
				";
			} else {
				$sql = "
					insert into
						log
					set
						".$sql_fields;
			}
			$q = new CMS_query($sql);
			if (!$q->hasError()) {
				$this->_id = $q->getLastInsertedID();
			}
		} else {
			$this->setError("Incorrect parameter types");
		}
	}

	/**
	  * Record log in database for miscelaneous resource
	  *
	  * @param integer action
	  * @param CMS_profile_user user 
	  * @param string textData
	  * @param string $module : the module codename
	  * @return void
	  * @access public
	  */
	public function logMiscAction($action, &$user, $textData, $module = '') {
		$this->setLogAction($action);
		$this->_setUser($user);
		$this->setTextData($textData);
		$this->_datetime = new CMS_Date;
		$this->_datetime->setNow();
		$this->_setModule($module);
		if (!$this->hasError()) {
			$sql_fields = "
				user_log='".SensitiveIO::sanitizeSQLString($this->_user->getUserId())."',
				action_log='".SensitiveIO::sanitizeSQLString($this->_action)."',
				datetime_log='".SensitiveIO::sanitizeSQLString($this->_datetime->getDBValue())."',
				module_log='".SensitiveIO::sanitizeSQLString($this->_module)."',
				textData_log='".SensitiveIO::sanitizeSQLString($this->_textData)."'
			";
			if ($this->_id) {
				$sql = "
					update
						log
					set
						".$sql_fields."
					where
						id_log='".$this->_id."'
				";
			} else {
				$sql = "
					insert into
						log
					set
						".$sql_fields;
			}
			$q = new CMS_query($sql);
			if (!$q->hasError()) {
				$this->_id = $q->getLastInsertedID();
			}
		} else {
			$this->setError("Incorrect paramater types");
		}
	}
	
	
	/**
	  * Get log user
	  *
	  * @return cms_profile_user
	  * @access public
	  */
	public function getUser()
	{
		return $this->_user;
	}
	
	/**
	  * Set log user
	  *
	  * @param cms_profile_user
	  * @return void
	  * @access private
	  */
	protected function _setUser($user)
	{
		// Check if CMS_profile_user
		if (is_a($user, "CMS_profile_user")) {
			$this->_user = $user;
		} else {
			$this->setError("User object required: ");
		}
	}
	
	/**
	  * Get log action
	  *
	  * @return integer
	  * @access public
	  */
	public function getLogAction()
	{
		return $this->_action;
	}
	
	/**
	  * Set log action
	  *
	  * @param integer
	  * @return void
	  * @access public
	  */
	public function setLogAction($action)
	{
		if (SensitiveIO::isPositiveInteger($action)) {
			$this->_action = $action;
		} else {
			$this->setError("Action is not a positive integer");
		}
	}
	
	/**
	  * Get resource Status
	  *
	  * @return CMS_resourceStatus
	  * @access public
	  */
	public function getResourceStatusAfter()
	{
		return $this->_resourceStatusAfter;
	}
	
	/**
	  * Set resource status
	  *
	  * @return CMS_resourceStatus
	  * @access private
	  */
	protected function _setResourceStatusAfter($resourceStatus)
	{
		// Check if CMS_resourceStatus object
		if (is_a($resourceStatus, "CMS_resourceStatus")) {
			$this->_resourceStatusAfter = $resourceStatus;
		} else {
			$this->setError("Resource status object required: ");
		}
	}
	
	/**
	  * Get date time
	  *
	  * @return CMS_date
	  * @access public
	  */
	public function getDateTime()
	{
		return $this->_datetime;
	}
	
	/**
	  * Set date time
	  *
	  * @param CMS_date
	  * @return void
	  * @access public
	  */
	public function setDateTime($datetime)
	{
		// Check if CMS_date object
		if (is_a($datetime, "CMS_date")) {
			$this->_datetime = $datetime;
		} else {
			$this->setError("Date time object required: ");
		}
	}
	
	/**
	  * Get text Data
	  *
	  * @return string
	  * @access public
	  */
	public function getTextData()
	{
		return $this->_textData;
	}
	
	/**
	  * Set text Data
	  *
	  * @param string
	  * @return void
	  * @access public
	  */
	public function setTextData($textData)
	{
		$this->_textData = $textData;
	}
	
	/**
	  * Get label
	  *
	  * @return string
	  * @access public
	  */
	public function getLabel()
	{
		return $this->_label;
	}
	
	/**
	  * Set label
	  *
	  * @param string
	  * @return void
	  * @access public
	  */
	public function setLabel($label)
	{
		$this->_label = $label;
	}
	
	/**
	  * Get Module
	  *
	  * @return CMS_module
	  * @access public
	  */
	public function getModule()
	{
		if ($this->_module) {
			return CMS_modulesCatalog::getByCodename($this->_module);
		} else {
			return false;
		}
	}
	
	/**
	  * Set ModuleId
	  *
	  * @param mixed string or CMS_module $module The module codename
	  * @return void
	  * @access public
	  */
	protected function _setModule($module)
	{
		if (is_object($module)) {
			$this->_module = $module->getCodename();
		} else {
			$this->_module = $module;
		}
	}
	
	/**
	  * Get Resource Id
	  *
	  * @return integer
	  * @access public
	  */
	public function getResource()
	{
		$mod = $this->getModule();
		if (is_a($mod, "CMS_module") && io::isPositiveInteger($this->_resource)) {
			return CMS_module::getResourceByID($this->_resource);
		} else {
			return false;
		}
	}
	
	/**
	  * Set ResourceId
	  *
	  * @param integer
	  * @return void
	  * @access public
	  */
	public function setResource($resource)
	{
		// Check if CMS_module object
		if (is_a($resource, "CMS_resource")) {
			$this->_resource = $resource->getID();
		} elseif (SensitiveIO::isPositiveInteger($id)) {
			$this->_resource = $resource;
		}
		 else {
			$this->setError("Resource object required: ");
		}
	}
	
	/**
	  * destroys the log from persistence (MySQL for now).
	  *
	  * @return void
	  * @access public
	  */
	public function destroy()
	{
		if ($this->_id) {
			$sql = "
				delete
				from
					logs
				where
					id_log='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		parent::destroy();
	}
	
	
	
	/**
	  * Write to persistence
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence()
	{
		$sql_fields = "
				user_log='".SensitiveIO::sanitizeSQLString($this->_user->getUserId())."',
				action_log='".SensitiveIO::sanitizeSQLString($this->_action)."',
				datetime_log='".SensitiveIO::sanitizeSQLString($this->_datetime->getDBValue())."',
				textData_log='".SensitiveIO::sanitizeSQLString($this->_textData)."',
				label_log='".SensitiveIO::sanitizeSQLString($this->_label)."',
				module_log='".SensitiveIO::sanitizeSQLString($this->_module)."',
				resource_log='".SensitiveIO::sanitizeSQLString($this->_resource)."',
				rsAfterLocation_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getLocation())."',
				rsAfterProposedFor_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getProposedFor())."',
				rsAfterEditions_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getEditions())."',
				rsAfterValidationsRefused_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getValidationRefused())."',
				rsAfterPublication_log='".SensitiveIO::sanitizeSQLString(
					$this->_resourceStatusAfter->getPublication())."'	
			";
			if ($this->_id) {
				$sql = "
					update
						log
					set
						".$sql_fields."
					where
						id_log='".$this->_id."'
				";
			} else {
				$sql = "
					insert into
						log
					set
						".$sql_fields;
			}
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				return false;
			} else {
				$this->_id = $q->getLastInsertedID();
			}
		return true;
	}
}
?>