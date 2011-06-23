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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profileuser.php,v 1.12 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_profile_user
  *
  * Login data and functions of user
  *
  * @package Automne
  * @subpackage user
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_profile_user extends CMS_profile
{
	const MESSAGE_PAGE_CLICK_TO_VIEW_USER = 1622;
	const MESSAGE_PAGE_NONE = 10;
	const MESSAGE_PAGE_USER = 908;
	const MESSAGE_PAGE_NAME = 94;
	const MESSAGE_PAGE_FIRSTNAME = 93;
	const MESSAGE_PAGE_EMAIL = 102;
	const MESSAGE_PAGE_WRITE_TO = 1624;
	const MESSAGE_PAGE_GROUPS = 837;
	
	/**
	  * Id of user profile in database
	  *
	  * @var integer
	  * @access private
	  */
	protected $_userId;

	/**
	  * User Login
	  *
	  * @var string
	  * @access private
	  */
	protected $_login;
	
	/**
	  * password of User
	  *
	  * @var string
	  * @access private
	  */
	protected $_password;
	
	/**
	  * firstName of User
	  *
	  * @var string
	  * @access private
	  */
	protected $_firstName;
	
	/**
	  * lastName of User
	  *
	  * @var string
	  * @access private
	  */
	protected $_lastName;
	
	/**
	  * contactData
	  *
	  * @var CMS_contactData
	  * @access private
	  */
	protected $_contactData;
		
	/**
	  * validationChange, determines whether validations have been changed 
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_validationChange = false;
	
	/**
	  * language, that user prefers to work with 
	  *
	  * @var CMS_language : default French
	  * @access private
	  */
	protected $_language;
	
	/**
	  * Is the user active ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_active = true;
	
	/**
	  * Is the user "deleted" ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_deleted = false;
	
	/**
	  * Level of alerts
	  *
	  * @var integer
	  * @access private
	  */
	protected $_alerts = false;
	
	/**
	  * Pages favorites
	  *
	  * @var integer
	  * @access private
	  */
	protected $_favorites = array();
	
	/**
	  * Constructor.
	  * Loads all Id variables if
	  *
	  * @param integer $id id of profile in DB
	  * @return  void
	  * @access public
	  */
	function __construct($id = false)
	{
		// Initiate Stack objects
		$this->_alerts = new CMS_stack();
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					profilesUsers,
					contactDatas,
					profiles
				where
					id_pru='$id' and
					id_cd=contactData_pru and
					id_pr=profile_pru
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
			} else {
				$this->raiseError("Unknown DB ID : ".$id);
				$this->_language = new CMS_language();
				$this->_contactData = CMS_contactDatas_catalog::getByUser(array());
				// Initialize super class
				parent::__construct();
			}
			if (isset($data) && is_array($data)) {
				$this->_userId = $id;
				$this->_login = $data["login_pru"];
				$this->_password = $data["password_pru"];
				$this->_firstName = $data["firstName_pru"];
				$this->_lastName = $data["lastName_pru"];
				parent::__construct($data);
				$this->_language = CMS_languagesCatalog::getByCode($data["language_pru"]);
				$this->_active = $data["active_pru"];
				$this->_deleted = $data["deleted_pru"];
				$this->_favorites = $data["favorites_pru"] ? explode(',',$data["favorites_pru"]) : array();
				$this->_alerts->setTextDefinition($data["alerts_pru"]);
				$this->_contactData = CMS_contactDatas_catalog::getByUser($data);
			}
		} else {
			$this->_language = new CMS_language();
			$this->_contactData = CMS_contactDatas_catalog::getByUser(array());
			// Initialize super class
			parent::__construct();
		}
	}
	
	/**
	  * Get Id
	  *
	  * @return integer
	  * @access public
	  */
	function getUserId()
	{
		return $this->_userId;
	}
	
	/**
	  * Is the user active ?
	  *
	  * @return string
	  * @access public
	  */
	function isActive()
	{
		return $this->_active;
	}
	
	/**
	  * Is the user deleted ?
	  *
	  * @return string
	  * @access public
	  */
	function isDeleted()
	{
		return $this->_deleted;
	}
	
	/**
	  * Set The active flag
	  *
	  * @param boolean $active
	  * @return boolean
	  * @access public
	  */
	function setActive($active)
	{
		$this->_active = ($active) ? true : false;
		$this->_validationChange = true;
		return true;
	}
	
	/**
	  * Set The deleted flag
	  * Sets the login to nothing, so this login could be reused in the future
	  *
	  * @param boolean $active
	  * @return boolean
	  * @access public
	  */
	function setDeleted($deleted)
	{
		$this->_deleted = ($deleted) ? true : false;
		return true;
	}
	
	/**
	  * Is page a favorite for user ?
	  *
	  * @param integer $pageId, the pageId to check page favorite status
	  * @return boolean
	  * @access public
	  */
	function isFavorite($pageId) {
		return in_array(trim($pageId), $this->_favorites);
	}
	
	/**
	  * Set page a favorite status for user
	  *
	  * @param boolean $status, the page favorite status
	  * @param integer $pageId, the pageId to set favorite status
	  * @return boolean
	  * @access public
	  */
	function setFavorite($status, $pageId) {
		if (!sensitiveIO::isPositiveInteger($pageId)) {
			$this->raiseError("Page Id must be an integer : ".$pageId);
			return false;
		}
		if (in_array($pageId, $this->_favorites)) {
			if (!$status) {
				unset($this->_favorites[array_search($pageId, $this->_favorites)]);
			}
		} else {
			if ($status) {
				$this->_favorites[] = $pageId;
			}
		}
		return true;
	}
	
	/**
	  * Get pages favorites for user
	  *
	  * @return array(pageIds)
	  * @access public
	  */
	function getFavorites() {
		return $this->_favorites;
	}
	
	/**
	  * Get Login
	  *
	  * @return string
	  * @access public
	  */
	function getLogin()
	{
		return $this->_login;
	}
	
	/**
      * Check if the login is valid
      *
      * @param string $login
      * @return boolean true on success, false on failure
      * @access public
      */
    function checkLogin($login){
        return io::isValidLogin( $login ); 
    }
	
	/**
      * Set Login
      *
      * @param string $login
      * @return void
      * @access public
      */
    function setLogin($login)
    {
        if (!CMS_profile_user::checkLogin($login)) {
            $this->raiseError('Login is invalid. A login must use only alphanumerics caracters');
            return false;
        }
        // Check if login allready exists
        if (CMS_profile_usersCatalog::loginExists($login, $this)){
            $this->raiseError('Login allready exists. Choose another one');
            return false;
        }
        $this->_login = $login;
        return true;
    } 
	
	/**
	  * Set Password
	  *
	  * @param string $password
	  * @param boolean $encode : encode the setted password using sha1 hash function
	  * @return boolean
	  * @access public
	  */
	function setPassword($password, $encode = true) {
		// Check password validity
	    if ($encode && !SensitiveIO::isValidPassword($password)) {
			$this->raiseError('Invalid password. Length must be > '.MINIMUM_PASSWORD_LENGTH);
			return false;
		}
		$this->_password = $encode ? '{sha}'.sha1($password) : $password;
		return true;
	}
	
	/**
	  * Get Password
	  *
	  * @return string The SHA1 user password
	  * @access public
	  */
	function getPassword()
	{
		return $this->_password;
	}
	
	/**
	  * have Password
	  *
	  * @return  void
	  * @access public
	  */
	function havePassword()
	{
		return ($this->_password) ? true:false;
	}
	
	/**
	  * Get user fullname (firstname then last name)
	  *
	  * @return string
	  * @access public
	  */
	function getFullName()
	{
		return ($this->_firstName ? ucfirst($this->_firstName) : '').
		(($this->_firstName && $this->_lastName) ? ' ' : '').
		($this->_lastName ? ucfirst($this->_lastName) : '');
	}
	
	/**
	  * Get First Name
	  *
	  * @return string
	  * @access public
	  */
	function getFirstName()
	{
		return $this->_firstName;
	}
	
	/**
	  * Set First Name
	  *
	  * @param string $firstName
	  * @return boolean
	  * @access public
	  */
	function setFirstName($firstName)
	{
		$this->_firstName = $firstName;
		return true;
	}
	
	/**
	  * Get Last Name
	  *
	  * @return string
	  * @access public
	  */
	function getLastName()
	{
		return $this->_lastName;
	}
	
	/**
	  * Set Last Name
	  *
	  * @param string $lastName
	  * @return boolean
	  * @access public
	  */
	function setLastName($lastName)
	{
		$this->_lastName = $lastName;
		return true;
	}
	
	/**
	  * Get Contact Data
	  *
	  * @return CMS_contactData
	  * @access public
	  */
	function getContactData()
	{
		return $this->_contactData;
	}
	
	/**
	  * Set Contact Data
	  *
	  * @param CMS_contactData $contactData
	  * @return boolean
	  * @access public
	  */
	function setContactData($contactData)
	{
		// Check if CMS_contactData object
		if (is_a($contactData, "CMS_contactData") && !$contactData->hasError()) {
			$this->_contactData = $contactData;
			return true;
		} else {
			$this->raiseError("Try to set an invalid Contact data object or object has an error: ".print_r($contactData, true));
		}
		return false;
	}
	
	/**
	  * Get Contact Data part : the email (often used)
	  *
	  * @return string The email
	  * @access public
	  */
	function getEmail()
	{
		return $this->_contactData->getEmail();
	}
	
	/**
	  * Get Language
	  *
	  * @return CMS_language
	  * @access public
	  */
	 
	function getLanguage()
	{
		return $this->_language;
	}
	
	/**
	  * Set language
	  *
	  * @param CMS_language $language
	  * @return boolean
	  * @access public
	  */
	function setLanguage($language)
	{
		// Check if CMS_contactData object
		if (is_a($language, "CMS_language") && !$language->hasError()) {
			$this->_language = $language;
			return true;
		} else {
		    $language = new CMS_language($language);
		    if($language && !$language->hasError()){
		        $this->_language = $language;
		        return true;
		    }
		}
		$this->raiseError("Object required, or available language code : ".$language);
		return false;
	}
	
	/**
	  * Add Validation Clearance
	  * Overwrite super class function to update validation catalog
	  *
	  * @param integer $moduleid 
	  * @return boolean
	  * @access public
	  */
	function addValidationClearance($moduleName)
	{
		if ($moduleName) {
			$hasValidation = parent::hasValidationClearance($moduleName);
			if (!$hasValidation) {
				parent::addValidationClearance($moduleName);
				$this->_validationChange = true;
			}
			return true;
		} else {
			$this->raiseError("Invalid module name :".$moduleName);
		}
		return false;
	}
	
	/**
	  * Del Validation Clearance
	  * Overwrite super class function to update validation catalog
	  *
	  * @var integer $moduleId
	  * @return void
	  * @access public
	  */
	function delValidationClearance($moduleId)
	{
		$hasValidation = parent::hasValidationClearance($moduleId);
		parent::delValidationClearance($moduleId);
		
		// Remove from validation catalog if no validations
		if ($hasValidation) {
			$this->_validationChange = true;
		}
	}
	
	/**
	  * Del Validation Clearances
	  * Overwrite super class function to update validation catalog
	  *
	  * @return void
	  * @access public
	  */
	function delValidationClearances()
	{
		$validationClearances = parent::getValidationClearances();
		$prevElements = $validationClearances->getElements();
		parent::delValidationClearances();
		
		if ($prevElements) {
			$this->_validationChange = true;
		}
	}
	
	/**
	  * Sets Validation Clearances
	  * Overwrite super class function to update validation catalog
	  *
	  * @param  CMS_stack $validationClearances
	  * @return boolean
	  * @access public
	  */
	function setValidationClearances($validationClearances)
	{
		if (is_a($validationClearances, 'CMS_stack')) {
			parent::setValidationClearances($validationClearances);
			$this->_validationChange = true;
			return true;
		} else {
			$this->raiseError("Validation object required");
		}
		return false;
	}
	
	/**
	  * Short hand to get values by property name
	  *
	  * @param string $property The name of the property
	  * @return mixed See functions for more details
	  * @access public
	  */
	function getValue($property){
		switch($property){
		    case 'id':
		        return $this->getUserId();
		    break;
			case 'active':
		        return $this->isActive();
		    break;
		    case 'validationChange':
		        return $this->_validationChange;
		    break;
            case 'deleted':
		        return $this->isDeleted();
		    break;
            case 'alerts':
		        return $this->_alerts;
		    break;
            default:
				$method = 'get'.ucfirst($property);
				if (method_exists($this, $method)) {
					return $this->{$method}();
				} else if (method_exists($this->_contactData, $method)) {
					return $this->_contactData->{$method}();
				} else {
					$this->raiseError('Unknown property to get : "'.$property.'"');
				}
			break;
		}
		return false;
	}
	
	/**
	  * Short hand to set values by property name
	  *
	  * @param string $property The name of the property
	  * @param string $value The value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($property, $value){
		switch($property){
		    default:
				$method = 'set'.ucfirst($property);
				if (method_exists($this, $method)) {
					return $this->{$method}($value);
				} else {
					$this->raiseError('Unknown property to set : "'.$property.'"');
				}
			break;
		}
		return false;
	}
	
	/**
	 * Set user by xml definition. Return XML
	 * 
	 * @access public
	 * @param string $xmlInput XML definition to define user properties
	 * @return boolean True on success, false on failure
	 */
	function setSoapValues($domdocument){
	    $view = CMS_view::getInstance();
	    
	    $contactData = new CMS_contactData();
        $currentPassword = '';
        $newGroups = array();
        
	    foreach($domdocument->childNodes as $childNode) {
	        if($childNode->nodeType == XML_ELEMENT_NODE) {
		        switch($childNode->tagName){
			        case 'contactData':
				        foreach($childNode->childNodes as $cdChildNode) {
					        if($cdChildNode->nodeType == XML_ELEMENT_NODE) {
					            if(!$contactData->setValue($cdChildNode->tagName, $cdChildNode->nodeValue)){
					                $view->addError('Invalid value for contactData tag '.$cdChildNode->tagName.' and value '.$cdChildNode->nodeValue);
	                                return false;
					            }
					        } elseif ($cdChildNode->nodeType == XML_TEXT_NODE && trim($cdChildNode->nodeValue)) {
	                            $view->addError('Unknown xml content contactData tag '.$cdChildNode->nodeValue.' to process.');
	                            return false;
	                        }
				        }
			        break;
			        case 'groups':
				        foreach($childNode->childNodes as $groupChildNode) {
					        if($groupChildNode->nodeType == XML_ELEMENT_NODE) {
					            $group = CMS_profile_usersGroupsCatalog::getByID($groupChildNode->nodeValue);
					            if($group && !$group->hasError()){
					                $newGroups[$group->getGroupId()] = $group->getGroupId();
					            } else {
					                $view->addError('Unknown group ID '.$groupChildNode->nodeValue.'.');
	                                return false;
					            }
					        } elseif ($cdChildNode->nodeType == XML_TEXT_NODE && trim($cdChildNode->nodeValue)) {
	                            $view->addError('Unknown xml content contactData tag '.$cdChildNode->nodeValue.' to process.');
	                            return false;
	                        }
				        }
			        break;
			        default:
				         if(!$this->setValue($childNode->tagName, $childNode->nodeValue)){
				            $view->addError('Invalid value for tag '.$childNode->tagName.' and value '.$childNode->nodeValue);
	                        return false;
				         }
				         if($childNode->tagName == 'password'){
				            $currentPassword = $childNode->nodeValue;
				         }
			        break;
		        }
	        } elseif ($childNode->nodeType == XML_TEXT_NODE && trim($childNode->nodeValue)) {
	            $view->addError('Unknown xml content tag '.$childNode->nodeValue.' to process.');
	            return false;
	        }
	    }
	    // Check user required fields.
	    if($this->hasError()){
	        $view->addError('Values to set are invalid.');
	        return false;
	    }
	    if($currentPassword == $this->getValue('login')){
	        $view->addError('Login and password must be different.');
	        return false;
	    }
	    if($this->getValue('login') && $contactData->getValue('email')){
	        // Save contact data object
	        if($contactData->writeToPersistence() && $this->setValue('contactData', $contactData)){
	            // Get current user groups ids
	            $userGroupIds = CMS_profile_usersGroupsCatalog::getGroupsOfUser($this, true, true);
			    
		        // First reset profile clearances
		        $this->resetClearances();
		        
		        // Second, loop through user groups to remove group
		        foreach ($userGroupIds as $oldGroupId) {
			        if (!in_array($oldGroupId, $newGroups)) {
				        // Remove user to group
				        $oldGroup = CMS_profile_usersGroupsCatalog::getByID($oldGroupId);
				        if (!$oldGroup->removeUser($this) || !$oldGroup->writeToPersistence()) {
					        $view->addError('Error deleting user\'s group : '.$oldGroupId);
                            return false;
				        }
			        }
		        }
		        
	            // Third, loop through user groups to add groups
	            foreach ($newGroups as $newGroupId) {
		            if (!in_array($newGroupId, $userGroupIds)) {
		                $newGroup = CMS_profile_usersGroupsCatalog::getByID($newGroupId);
			            if($newGroup && !$newGroup->hasError()){
			                // Add group to user
			                $this->addGroup($newGroupId);
			            } else {
			                $view->addError('Error adding user\'s group : '.$newGroupId);
                            return false;
			            }
		            }
	            }
	            
				//Clear polymod cache
				CMS_cache::clearTypeCacheByMetas('polymod', array('resource' => 'users'));
				
	            return true;
	        } else {
	            $view->addError('Error saving contactData.');
	            return false;
	        }
	    } else {
	        $view->addError('Missing values to set user. Check the login, password and email.');
	    }
        return false;
	}
	
	/**
	  * Writes the  user Data into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$this->writeProfileToPersistence();
		$this->_contactData->writeToPersistence();
		//if deleted, must set the login to nothing, so this login could be reused in the future
		if ($this->_deleted) {
			$this->_login = '';
		}
		$sql_fields = "
			active_pru='".$this->_active."',
			deleted_pru='".$this->_deleted."',
			login_pru='".SensitiveIO::sanitizeSQLString($this->_login)."',
			password_pru='".SensitiveIO::sanitizeSQLString($this->_password)."',
			firstName_pru='".SensitiveIO::sanitizeSQLString($this->_firstName)."',
			lastName_pru='".SensitiveIO::sanitizeSQLString($this->_lastName)."',
			contactData_pru='".SensitiveIO::sanitizeSQLString($this->_contactData->getId())."',
			language_pru='".SensitiveIO::sanitizeSQLString($this->_language->getCode())."',
			profile_pru='".SensitiveIO::sanitizeSQLString(parent::getId())."',
			alerts_pru='".SensitiveIO::sanitizeSQLString($this->_alerts->getTextDefinition())."',
			favorites_pru='".SensitiveIO::sanitizeSQLString(implode(',',$this->_favorites))."'
		";
		
		if ($this->_userId) {
			$sql = "
				update
					profilesUsers
				set
					".$sql_fields."
				where
					id_pru='".$this->_userId."'
			";
		} else {
			$sql = "
				insert into
					profilesUsers
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_userId) {
			$this->_userId = $q->getLastInsertedID();
		}
		
		// Update validation catalog
		if ($this->_validationChange || $this->_deleted) {
				$sql = "
				delete 
				from
					profilesUsers_validators
				where
					userId_puv='".$this->_userId."'
				";
				$q = new CMS_query($sql);
				
				if ($this->_active) {
					//loop through validationClearances
					$validationClearances = parent::getValidationClearances();
					$elements = $validationClearances->getElements(); 
					$sql = '';
					foreach ($elements as $value) {
						$sql .= ($sql) ? ', ':'';
						$sql .= "('".$this->_userId."' ,'".$value[0]."') ";
					}
					if ($sql) {
						$sql = "
							insert into
								profilesUsers_validators (userId_puv, module_puv)
							values 
								".$sql;
						$q = new CMS_query($sql);
					}
				}
				$this->_validationChange = false;
		}
		//if deleted, must remove user from group list
		if ($this->_deleted) {
			$sql = "
				delete 
				from
					profileUsersByGroup
				where
					userId_gu='".$this->_userId."'
			";
			$q = new CMS_query($sql);
		}
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('resource' => 'users'));
		return true;
	}
	
	/**
	  * Writes the profile Data into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeProfileToPersistence() {
		return parent::writeToPersistence();
	}
	
	/**
      * Checks if the user is in a given group
      * @param integer $group_id
      * @return boolean true if the user is in the group. false otherwise
      */
	public function hasGroup($groupId){
		$groups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($this, true);
		return in_array($groupId, $groups);
	}
	
	/**
	  * Does user has the queried alert level set
	  *
	  * @param integer $level : the level needed
	  * @param  string $module : module codename to check
	  * @return void
	  * @access public
	  */
	function hasAlertLevel($level, $module) {
		$moduleLevel = $this->_alerts->getElementValueFromKey($module);
		if ($moduleLevel & $level) {
			return true;
		}
		return false;
	}
	
	/**
	  * Sets Alert Level
	  *
	  * @param  string $module : module codename to set
	  * @param integer $level : the level to set
	  * @return true
	  * @access public
	  */
	function setAlertLevel($level, $module) {
		$this->_alerts->delAllWithOneKey($module);
		$this->_alerts->add($module, $level);
		return true;
	}
	
	/**
	  * Reset Alert Level
	  *
	  * @return true
	  * @access public
	  */
	function resetAlertLevel() {
		// Initiate Stack objects
		$this->_alerts = new CMS_stack();
		return true;
	}
	
	function getJSonDescription($user, $cms_language) {
		//groups of user
		$userGroups = array();
		$groups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($this);
		$userGroups = '';
		if ($groups) {
			foreach ($groups as $group) {
				$userGroups .= ($userGroups) ? ', ' : '';
				$userGroups .= '<a href="#" onclick="Automne.view.search(\'group:'.$group->getGroupId().'\');return false;" ext:qtip="'.io::htmlspecialchars($group->getDescription()).' ('.$cms_language->getMessage(self::MESSAGE_PAGE_CLICK_TO_VIEW_USER).')" class="atm-help">'.$group->getLabel().'</a>';
			}
		} else {
			$userGroups = $cms_language->getMessage(self::MESSAGE_PAGE_NONE);
		}
		if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
			$edit = array(
				'url' 		=> 'user.php',
				'params'	=> array(
					'userId' 	=> $this->getUserId()
				)
			);
		} else {
			$edit = false;
		}
		return array(
			'id'			=> $this->getUserId(),
			'label'			=> $this->getFullName(),
			'type'			=> $cms_language->getMessage(self::MESSAGE_PAGE_USER),
			'description'	=> '
				'.$cms_language->getMessage(self::MESSAGE_PAGE_NAME).' : <strong>'.$this->getLastname().'</strong><br />
				'.$cms_language->getMessage(self::MESSAGE_PAGE_FIRSTNAME).' : <strong>'.$this->getFirstname().'</strong><br />
				'.$cms_language->getMessage(self::MESSAGE_PAGE_EMAIL).' : <a href="mailto:'.$this->getEmail().'" ext:qtip="'.$cms_language->getMessage(self::MESSAGE_PAGE_WRITE_TO, array(io::htmlspecialchars($this->getFullName()))).'">'.$this->getEmail().'</a><br />
				'.$cms_language->getMessage(self::MESSAGE_PAGE_GROUPS).' : '.$userGroups,
			'edit'			=> $edit
		);
	}
}
?>
