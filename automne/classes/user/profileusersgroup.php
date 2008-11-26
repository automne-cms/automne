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
// $Id: profileusersgroup.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_profile_usersGroup
  *
  * Login data and functions of user group
  *
  * @package CMS
  * @subpackage user
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_profile_usersGroup extends CMS_profile
{
	/**
	  * Id of user group in database
	  *
	  * @var integer
	  * @access private
	  */
	protected $_groupId;
	
	/**
	  * User Label
	  *
	  * @var string
	  * @access private
	  */
	protected $_label;
	
	/**
	  * LDAP distinguished name
	  *
	  * @var string
	  * @access private
	  */
	protected $_dn;
	
	/**
	  * Invert LDAP distinguished name
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_invertdn;
	
	/**
	  * Group description
	  *
	  * @var string
	  * @access private
	  */
	protected $_description;
	
	/**
	  * Users in group
	  *
	  * @var array(integer)
	  * For memory purpouses will store reference user id not user object
	  * @access private
	  */
	protected $_users;
	
	/**
	  * Users in group before modification, used for database save
	  *
	  * @var array(integer)
	  * For memory purpouses will store reference user id not user object
	  * @access private
	  */
	protected $_usersOld = array();
	
	/**
	  * Constructor.
	  * Loads all Id variables if
	  *
	  * @param integer $id of profile in DB
	  * @return  void
	  * @access public
	  */
	function __construct($id = false)
	{
		$this->_users = array();
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError('Id is not a positive integer');
				return;
			}
			
			$sql = "
				select
					*
				from
					profilesUsersGroups,
					profiles
				where
					id_prg='".$id."' and
					id_pr=profile_prg
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_groupId = $id;
				$this->_label = $data["label_prg"];
				$this->_dn = $data["dn_prg"];
				$this->_invertdn = ($data["invertdn_prg"]) ? true : false;
				$this->_description = $data["description_prg"];
				parent::__construct($data);
				
				// Create users array
				$sql = "
					select
						userId_gu
					from
						profileUsersByGroup
					where
						groupId_gu='".$id."'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					while ($userId = $q->getValue("userId_gu")) {
						$this->_users[] = $userId;
					}
				}
				$this->_usersOld = $this->_users;
			} else {
				$this->raiseError('Unknown DB ID : '.$id);
			}
		} else {
			// initialize super class object and users
			parent::__construct();
		}
	}
	
	/**
	  * Get Id
	  *
	  * @return integer
	  * @access public
	  */
	function getGroupId()
	{
		return $this->_groupId;
	}
	
	/**
	  * Get Label
	  *
	  * @return string
	  * @access public
	  */
	function getLabel()
	{
		return $this->_label;
	}
	
	/**
	  * Set Label
	  *
	  * @param string $label
	  * @return void
	  * @access public
	  */
	function setLabel($label)
	{
		if ($label) {
			$this->_label = $label;
		} else {
			$this->raiseError('Label must be string > 0');
		}
	}
	
	/**
	  * Get Description
	  *
	  * @return string
	  * @access public
	  */
	function getDescription()
	{
		return $this->_description;
	}
	
	/**
	  * Set Label
	  *
	  * @param string $label
	  * @return void
	  * @access public
	  */
	function setDescription($description)
	{
		if ($description) {
			$this->_description = $description;
		} else {
			$this->raiseError('Description must be string > 0');
		}
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
			$this->raiseError('Must be string > 0');
		}
	}
	
	/**
	  * Get Invert DN
	  *
	  * @return boolean
	  * @access public
	  */
	function getInvertDN()
	{
		return $this->_invertdn;
	}
	
	/**
	  * Set Invert DN
	  *
	  * @param string $s
	  * @return boolean
	  * @access public
	  */
	function setInvertDN($s)
	{
		$this->_invertdn = ($s) ? true : false;
		return true;
	}
	
	/**
	  * Get Users
	  *
	  * @retrun array(CMS_profileuser)
	  * @access public
	  */
	function getUsers($returnIDs = false)
	{
		$users = array();
		foreach ($this->_users as $user) {
			if($returnIDs){
				$users[] = $user;
			} else {
				$usr = CMS_profile_usersCatalog::getByID($user);
				if (!$usr->hasError()) {
					$users[] = $usr;
				}
			}
		}
		return $users;
	}
	
	/**
	  * Set Users
	  *
	  * @param array(int|CMS_profile_user) $users
	  * @return void
	  * @access public
	  */
	function setUsers($users)
	{
		foreach ($users as $user) {
			$this->addUser($user);
		}
	}

	/**
	  * Get User References
	  *
	  * @return array(integer)
	  * @access public
	  */
	function getUsersRef()
	{
		return $this->_users;
	}
	
	/**
	  * Add User
	  *
	  * @var integer|CMS_profile_user $user
	  * @access public
	  */
	function addUser(&$user)
	{
		if (is_a($user,"CMS_profile_user")) {
			if (!SensitiveIO::isInSet($user->getUserId(), $this->_users)) {
				$this->_users[] = $user->getUserId();
			}
		} elseif (SensitiveIO::isPositiveInteger($user)) {
			if (!SensitiveIO::isInSet($user, $this->_users)) {
				$this->_users[] = $user;
			}
		} else {
			$this->raiseError('Incorrect input type');
		}
	}
	
	/**
	  * Remove User
	  *
	  * @var integer or CMS_profile_user
	  * @access public
	  */
	function removeUser(&$user)
	{
		if (is_a($user,"CMS_profile_user")) {
			if (SensitiveIO::isInSet($user->getUserId(), $this->_users)) {
				$users = array();
				foreach ($this->_users as $userId ) {
					if ($userId != $user->getUserId()) {
						$users[] = $userId;
					}
				}
				$this->_users = $users;
				//then remove categories clearance to user because they are only associated to group
				$user->deleteCategoriesClearances();
			}
		} elseif (SensitiveIO::isPositiveInteger($user)) {
			if (SensitiveIO::isInSet($user, $this->_users)) {
				$users = array();
				foreach ($this->_users as $userId ) {
					if ($userId != $user) {
						$users[] = $userId;
					}
				}
				$this->_users = $users;
				//then remove categories clearance to user because they are only associated to group
				$user = CMS_profile_usersCatalog::getByID($user);
				if (is_a($user,"CMS_profile_user")) {
					$user->deleteCategoriesClearances();
				}
			}
		} else {
			$this->raiseError('Incorrect user type');
			return false;
		}
		return true;
	}
	
	/**
	  * Add group to user and write to persistence immediately
	  * The method has to update user's profile and group relationship
	  *
	  * @var CMS_profile_user $user
	  * @return true on success, false on failure
	  * @access public
	  */
	function addToUserAndWriteToPersistence(&$user, $writeUser = true)
	{
		if (is_a($user,"CMS_profile_user") && !$user->hasError()) {
			// Update user profile
			$user->addPageClearances(parent::getPageClearances());
			$user->addModuleClearances(parent::getModuleClearances());
			$user->addModuleCategoriesClearancesStack(parent::getModuleCategoriesClearancesStack());
			$user->addValidationClearances(parent::getValidationClearances());
			$user->addAdminClearance(parent::getAdminClearance());
			$user->addTemplateGroupsDenied(parent::getTemplateGroupsDenied());
			$user->addRowGroupsDenied(parent::getRowGroupsDenied());
			$user->setActive(true);
			if ($writeUser) {
				$user->writeToPersistence();
			}
			if (!$user->hasError()) {
				if (!SensitiveIO::isInSet($user->getUserId(), $this->_users)) {
					// Insert this user in group
					$this->_users[] = $user->getUserId();
					$sql = "
					insert into
						profileUsersByGroup
					set
						groupId_gu='".$this->_groupId."' ,
						userId_gu='".$user->getUserID()."'
					";
					$q = new CMS_query($sql);
					if ($q->hasError()) {
						$this->raiseError('Insertion failed');
					} else {
						return true;
					}
				} else {
					return true;
				}
			} else {
				$this->raiseError('User error when adding group values');
			}
		} else {
			$this->raiseError('Incorrect user given');
		}
		return false;
	}
	
	/**
	  * Apply group profile to all users belonging in this group
	  * This method must be as fast as possible
	  *
	  * @return void
	  * @access public
	  */
	function applyToUsers() {
		// class users by groups they belong to
		$usersByGroups = array();
		foreach ($this->_users as $userId) {
			$userGroupsIds = CMS_profile_usersGroupsCatalog::getGroupsOfUser($userId, true);
			$usersByGroups[implode(',',$userGroupsIds)][] = $userId;
		}
		//then loop through usersByGroups to compute rights of users by groups
		foreach ($usersByGroups as $groupsIds => $usersIds) {
			$userGroups = null;
			$firstUser = null;
			foreach ($usersIds as $userId) {
				//Get current user groups (only once because all users in this foreach loop has the same groups)
				$userGroups = (!isset($userGroups)) ? CMS_profile_usersGroupsCatalog::getGroupsOfUser($userId, false, true) : $userGroups;
				if (!isset($firstUser) || !is_a($firstUser,"CMS_profile_user")) {//for the first user of the current loop, compute rights
					//get user as the first user
					$firstUser = CMS_profile_usersCatalog::getByID($userId);
					if (is_object($firstUser) && !$firstUser->hasError()) {
						//reset profile clearances
						$firstUser->resetClearances();
						foreach ($userGroups as $group) {
							// Update user profile
							$firstUser->addPageClearances($group->getPageClearances());
							$firstUser->addModuleClearances($group->getModuleClearances());
							$firstUser->addModuleCategoriesClearancesStack($group->getModuleCategoriesClearancesStack());
							$firstUser->addValidationClearances($group->getValidationClearances());
							$firstUser->addAdminClearance($group->getAdminClearance());
							$firstUser->addTemplateGroupsDenied($group->getTemplateGroupsDenied());
							$firstUser->addRowGroupsDenied($group->getRowGroupsDenied());
							$firstUser->setActive(true);
						}
						if (!$firstUser->hasError()) {
							$firstUser->writeProfileToPersistence();
						}
					} else {
						$firstUser = null;
					}
				} else {//for other users, take the first user rights as reference to avoid rights computation
					//get user
					$user = CMS_profile_usersCatalog::getByID($userId);
					if (is_object($user) && !$user->hasError()) {
						//reset profile clearances
						$user->resetClearances();
						//then set user clearance like the first user
						$user->setPageClearances($firstUser->getPageClearances());
						$user->setModuleClearances($firstUser->getModuleClearances());
						$user->setModuleCategoriesClearancesStack($firstUser->getModuleCategoriesClearancesStack());
						$user->setValidationClearances($firstUser->getValidationClearances());
						$user->setAdminClearance($firstUser->getAdminClearance());
						$user->setTemplateGroupsDenied($firstUser->getTemplateGroupsDenied());
						$user->setRowGroupsDenied($firstUser->getRowGroupsDenied());
						$user->setActive(true);
						if (!$user->hasError()) {
							$user->writeProfileToPersistence();
						}
					}
				}
			}
		}
		return true;
	}
	
	/**
	  * destroys the cmsprofile from persistence (MySQL for now).
	  *
	  * @return void
	  * @access public
	  */
	function destroy()
	{
		parent::destroy();
		
		if ($this->_groupId) {
			$sql = "
				delete
				from
					profilesUsersGroups
				where
					id_prg='".$this->_groupId."'
			";
			$q = new CMS_query($sql);
			
			$sql = "
				delete
				from
					profileUsersByGroup
				where
					groupId_gu='".$this->_groupId."'
			";
			$q = new CMS_query($sql);
		}
		
		$this->applyToUsers();
		unset($this);
	}
	
	/**
	  * Writes the group data into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		parent::writeToPersistence();
		$sql_fields = "
			label_prg='".SensitiveIO::sanitizeSQLString($this->_label)."',
			description_prg='".SensitiveIO::sanitizeSQLString($this->_description)."',
			profile_prg='".SensitiveIO::sanitizeSQLString(parent::getId())."',
			dn_prg='".SensitiveIO::sanitizeSQLString($this->_dn)."',
			invertdn_prg='".($this->_invertdn ? 1 : 0)."'
		";
		
		if ($this->_groupId) {
			$sql = "
				update
					profilesUsersGroups
				set
					".$sql_fields."
				where
					id_prg='".$this->_groupId."'
			";
		} else {
			$sql = "
				insert into
					profilesUsersGroups
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
			if (!$q->getNumRows() || strtolower($q->getValue("Type")) != 'varchar(255)') {
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
			if (!$q->getNumRows() || strtolower($q->getValue("Type")) != 'varchar(255)') {
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
		} elseif (!$this->_groupId) {
			$this->_groupId = $q->getLastInsertedID();
		}
		
		/* Delete all records and re-insert the good ones */ 
		$sql = "
			delete from
				profileUsersByGroup
			where
				groupId_gu='".$this->_groupId."'
		";
		$q = new CMS_query($sql);
		if (is_array($this->_users) && $this->_users) {
			$sql = '';
			foreach ($this->_users as $user) {
				$sql .= ($sql) ? ', ':'';
				$sql .= "('".$this->_groupId."' ,'".$user."') ";
			}
			$sql = "
				insert into
					profileUsersByGroup (groupId_gu, userId_gu)
				values 
					".$sql;
			$q = new CMS_query($sql);
		}
		return true;
	}
}
?>
