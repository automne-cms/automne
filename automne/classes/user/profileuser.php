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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profileuser.php,v 1.7 2009/10/22 16:30:27 sebastien Exp $

/**
  * Class CMS_profile_user
  *
  * Login data and functions of user
  *
  * @package CMS
  * @subpackage user
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_profile_user extends CMS_profile
{
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
	  * LDAP distinguished name
	  *
	  * @var string
	  * @access private
	  */
	protected $_dn;
	
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
	function __construct($id = false, $forceRefreshLDAP = false)
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
			} elseif (defined("APPLICATION_LDAP_AUTH") && APPLICATION_LDAP_AUTH != false) {
				//here in some unkown case (with LDAP connection) contactDatas is not set (or destroyed ?) 
				//then request must be done without this table
				$sql = "
					select
						*
					from
						profilesUsers,
						profiles
					where
						id_pru='$id' and
						id_pr=profile_pru
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
				} else {
					$this->raiseError("Unknown DB ID : ".$id);
					$this->_language = new CMS_language();
					$this->_contactData = CMS_contactDatas_catalog::getByUser(array(), $forceRefreshLDAP);
					// Initialize super class
					parent::__construct();
				}
			} else {
				$this->raiseError("Unknown DB ID : ".$id);
				$this->_language = new CMS_language();
				$this->_contactData = CMS_contactDatas_catalog::getByUser(array());
				// Initialize super class
				parent::__construct();
			}
			if (is_array($data)) {
				$this->_userId = $id;
				$this->_login = $data["login_pru"];
				$this->_password = $data["password_pru"];
				$this->_firstName = $data["firstName_pru"];
				$this->_lastName = $data["lastName_pru"];
				parent::__construct($data);
				$this->_language = new CMS_language($data["language_pru"]);
				$this->_dn = $data["dn_pru"];
				$this->_active = $data["active_pru"];
				$this->_deleted = $data["deleted_pru"];
				$this->_favorites = $data["favorites_pru"] ? explode(',',$data["favorites_pru"]) : array();
				$this->_alerts->setTextDefinition($data["alerts_pru"]);
				$this->_contactData = CMS_contactDatas_catalog::getByUser($data, $forceRefreshLDAP);
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
	  * @return void
	  * @access public
	  */
	function setActive($active)
	{
		$this->_active = ($active) ? true : false;
		$this->_validationChange = true;
	}
	
	/**
	  * Set The deleted flag
	  * Sets the login to nothing, so this login could be reused in the future
	  * idem for LDAP dn
	  *
	  * @param boolean $active
	  * @return void
	  * @access public
	  */
	function setDeleted($deleted)
	{
		$this->_deleted = ($deleted) ? true : false;
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
	  * Set Login
	  *
	  * @param string $login
	  * @return void
	  * @access public
	  */
	function setLogin($login)
	{
		if (!$login) {
			$this->raiseError("Must be string > 0");
			return false;
		}
		$this->_login = $login;
		return true;
	}
	
	/**
	  * Set Password
	  *
	  * @param string $password
	  * @return  void
	  * @access public
	  */
	function setPassword($password)
	{
		$this->_password = md5($password);
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
	  * @return  void
	  * @access public
	  */
	function setFirstName($firstName)
	{
		$this->_firstName = $firstName;
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
	  * @return  void
	  * @access public
	  */
	function setLastName($lastName)
	{
		$this->_lastName = $lastName;
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
	  * @return  void
	  * @access public
	  */
	function setContactData($contactData)
	{
		// Check if CMS_contactData object
		if (is_a($contactData, "CMS_contactData")) {
			$this->_contactData = $contactData;
		} else {
			$this->raiseError("Contact data object required: ".$contactData);
		}
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
	  * @return  void
	  * @access public
	  */
	function setLanguage($language)
	{
		// Check if CMS_contactData object
		if (is_a($language, "CMS_language")) {
			$this->_language = $language;
		} else {
			$this->raiseError("Data object required: ".$language);
		}
	}
	
	/**
	  * Get Animation
	  *
	  * @return boolean
	  * @access public
	  */
	 
	function getAnimation() {
		return null; //TODOV4
	}
	
	/**
	  * Get Tooltips
	  *
	  * @return boolean
	  * @access public
	  */
	 
	function getTooltips() {
		return null; //TODOV4
	}
	
	/**
	  * Get DN
	  *
	  * @return string
	  * @access public
	  */
	function getDN()
	{
		return $this->_dn;
	}
	
	/**
	  * Set DN
	  *
	  * @param string $s
	  * @return void
	  * @access public
	  */
	function setDN($s)
	{
		if ($s) {
			$this->_dn = $s;
		} else {
			$this->raiseError("Must be string > 0");
		}
	}
	
	/**
	  * Add Validation Clearance
	  * Overwrite super class function to update validation catalog
	  *
	  * @param integer $moduleid 
	  * @return void
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
		} else {
			$this->raiseError("Invalid module name :".$moduleName);	
		}
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
	  * @return void
	  * @access public
	  */
	function setValidationClearances($validationClearances)
	{
		if (is_a($validationClearances, 'CMS_stack')) {
			parent::setValidationClearances($validationClearances);
			$this->_validationChange = true;
		} else {
			$this->raiseError("Validation object required");
		}
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
			$this->_dn = '';
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
			dn_pru='".SensitiveIO::sanitizeSQLString($this->_dn)."',
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
			// Check that LDAP dn fields exist in profileUsers tables
			$sql = "
				DESCRIBE profilesUsers dn_pru
			";
			$q = new CMS_query($sql);
			if (!$q->getNumRows() || io::strtolower($q->getValue("Type")) != 'varchar(255)') {
				$sqls = array();
				$sqls[] = "
					ALTER TABLE 
						profilesUsers
					ADD
						dn_pru VARCHAR( 255 ) NOT NULL
					AFTER
						textEditor_pru
				";
				$sqls[] = "
					ALTER TABLE
						profilesUsers ADD INDEX ( `dn_pru` )
				";
				foreach ($sqls as $sql) {
					$qa = new CMS_query($sql);
				}
			}
			$sql = "
				DESCRIBE profilesUsersGroups dn_prg
			";
			$q = new CMS_query($sql);
			if (!$q->getNumRows() || io::strtolower($q->getValue("Type")) != 'varchar(255)') {
				$sqls = array();
				$sqls[] = "
					ALTER TABLE
						profilesUsersGroups
					ADD 
						dn_prg VARCHAR( 255 ) NOT NULL
				";
				$sqls[] = "
					ALTER TABLE
						profilesUsersGroups ADD INDEX ( `dn_prg` )
				";
				foreach ($sqls as $sql) {
					$qa = new CMS_query($sql);
				}
			}
			return $this->writeToPersistence();
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
				$userGroups .= '<a href="#" onclick="Automne.view.search(\'group:'.$group->getGroupId().'\');return false;" ext:qtip="'.htmlspecialchars($group->getDescription()).' (Cliquez pour voir les utilisateurs)" class="atm-help">'.$group->getLabel().'</a>';
			}
		} else {
			$userGroups = 'Aucun';
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
			'type'			=> 'Utilisateur',
			'description'	=> '
				Nom : <strong>'.$this->getLastname().'</strong><br />
				Prénom : <strong>'.$this->getFirstname().'</strong><br />
				Email : <a href="mailto:'.$this->getEmail().'" ext:qtip="Ecrire à '.htmlspecialchars($this->getFullName()).'">'.$this->getEmail().'</a><br />
				Groupes : '.$userGroups,
			'edit'			=> $edit
		);
	}
}
?>