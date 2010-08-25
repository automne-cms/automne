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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: ldapauth.php,v 1.3 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_ldap_auth
  *
  * Launches LDAP query against a given server.
  * Performs basic searches through static methods.
  *
  * @package Automne
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_ldap_auth extends CMS_grandFather
{
	/**
		* User array of datas founded in LDAP
		* 
		* @var array()
		* @access private
		*/
    var $_userData = array();
    
	/**
     * The DN of a group which will be used by default
	 * for any user connnecting whose group is unknown
	 * 
     * @var string
     * @access private
     */
    var $_defaultGroupID;
    
    /**
     * Attributes to test for login
     * Value corresponding to each one of these attributes 
     * will be compared to $login given to authenticate
	 * default : array('uid', 'cn', 'sn', 'login', 'userid')
	 * 
     * @var array
     * @access private
     */
    var $_loginAttributes ;
    
    /**
     * Attributes we want to obtain from server when authentication suceeded
     * Strongly recommended in fact to limit returned attributes 
     * for performance purpose
	 * 
     * @var array
     * @access private
     */
    var $_awaitedAttributes = array(
		APPLICATION_LDAP_USER_DN,
		APPLICATION_LDAP_USER_LOGIN,
		APPLICATION_LDAP_USER_LASTNAME,
		APPLICATION_LDAP_USER_FIRSTNAME,
		APPLICATION_LDAP_USER_EMAIL
	);
    
    /**
      * Constructor
	  * 
      * @param integer $defaultGroupID
	  * @param array() $loginAttributes, the login attributes we want to compare login with
	  * @param array() $awaitedAttributes, the attributes we want to get content from
	  * @return void
      * @access public
      */
    function __construct($defaultGroupID = 0, $loginAttributes=false, $awaitedAttributes=false)
    {
		// Sets default group to the one given
		if (SensitiveIO::isPositiveInteger($defaultGroupID)) {
			$this->_defaultGroupID = $defaultGroupID;
		} elseif (SensitiveIO::isPositiveInteger(APPLICATION_LDAP_DEFAULT_GROUP)) {
			$this->_defaultGroupID = APPLICATION_LDAP_DEFAULT_GROUP;
		}
		
		// Set login attributes
		if (is_array($loginAttributes) && $loginAttributes) {
			$this->_loginAttributes = $loginAttributes;
		} else {
			$this->_loginAttributes = $this->getLoginAttributes();
		}
		
		// Set awaited attributes
		if (is_array($awaitedAttributes) && $awaitedAttributes) {
			$this->_awaitedAttributes = $awaitedAttributes;
		}
		// Add login attributes to awaited attribute if ever forgotten
		foreach ($this->_loginAttributes as $att ) {
			if ($att && !in_array($att, $this->_awaitedAttributes)) {
					$this->_awaitedAttributes[] = $att;
			}
		}
		$this->_awaitedAttributes = @array_unique($this->_awaitedAttributes);
    }
    
    /**
      * Proceed to LDAP authentification for given login and password
      * Uses global LDAP parameters to connect to server and search for dn
      * corresponding to given login, then try to bind server again with dn and
      * password
      *
      * @param string $login
      * @param string $pass
      * @return boolean true on success, false on failure
      * @access public
      */
    function authenticate($login, $pass)
    {
		// Security in case of very laxist LDAP server
		if (trim($login) == '' || trim($pass) == '') {
			$this->raiseError("Neither login nor password can be empty.");
			return false;
		}
		// Search for user dn with $login given
		@reset($this->_loginAttributes);
		while (list($i, $att) = each($this->_loginAttributes)) {
			if ($att != '') {
				// Prepare filter
				// Determine if this attribute is present into $login
				// login may already have syntax such as cn=Login or sn=Login
				if (false === io::strpos($login, "=")) {
					$filter = $att."=";
				} else {
					$filter = '';
				}
				//$filter .= ereg_replace("[^-@._[:space:][:alnum:]]", "", $login);
				$filter .= $login;
				$q = new CMS_ldap_query($filter/*, $this->_awaitedAttributes*/);
				//pr($this->_awaitedAttributes);
				//pr($filter);
				if ($q->getNumRows() > 0) {
					$e = $q->getEntries();
					if (is_array($e) && $e['count'] == 1) {
						if ($q->bind($e[0][APPLICATION_LDAP_USER_DN], $pass)/* || $q->bind($login, $pass)*/) {
							while (list($k, $v) = each($e[0])) {
								if (!is_integer($k)) {
									if (is_array($v)) {
										$this->_userData[$k] = utf8_decode($v[0]);
									} else {
										$this->_userData[$k] = utf8_decode($v);
									}
								}
							}
							// Add login too
							if (!$this->_userData['login']) {
								$this->_userData['login'] = $login;
							}
							$q->close();
							return true;
						} else {
							$this->raiseError("User entry for login `$login` founded in directory, but binding not permitted.");
							$q->close();
							return false;
						}
					} else {
						$this->raiseError("No entry found for login `$login` in directory.");
					}
				}
				$q->close();
			}
		}
		return false;
	}
    
    /**
	  * Returns a CMS_profile_user related to dn founded after
	  * succesfull athentification
	  * 
	  * @return CMS_profile_user or null
	  * @access public
	  */
    function &getUser()
    {
    	if (!$this->getUserData(APPLICATION_LDAP_USER_DN)) {
    		$this->raiseError("No DN given for user.");
    		return null;
    	} else {
    		$user = CMS_profile_usersCatalog::getByDN($this->getUserData(APPLICATION_LDAP_USER_DN));
			$groups = array();
			// Get user LDAP groups
			$LDAPGroups = array();
			$groupsDNs = CMS_profile_usersGroupsCatalog::getGroupsDN();
			foreach ($groupsDNs as $groupId => $dnInfos) {
				// Check users group association
				$baseQuery = (io::strpos(io::strtolower($dnInfos['dn']), 'ou=group') === false) ? '('.APPLICATION_LDAP_USER_LOGIN.'='.$this->getUserdata("login").')' : '(member='.APPLICATION_LDAP_USER_LOGIN.'='.$this->getUserdata("login").')';
				if (!$dnInfos['filter']) {
					$q = new CMS_ldap_query($baseQuery, array(APPLICATION_LDAP_USER_DN), $dnInfos['dn']);
				} else {
					if (io::substr($dnInfos['filter'],0,1) == '(' && io::substr($dnInfos['filter'],-1,1) == ')') {
						$dnInfos['filter'] = io::substr($dnInfos['filter'],1,-1);
					}
					$q = new CMS_ldap_query('(&'.$baseQuery.'('.$dnInfos['filter'].'))', array(APPLICATION_LDAP_USER_DN), $dnInfos['dn']);
				}
				if ($q->getNumRows() == 1) {
					$LDAPGroups[$groupId] = CMS_profile_usersGroupsCatalog::getByID($groupId);
				}
			}
			if (!is_a($user, 'CMS_profile_user')) {
  	            // No user founded yet registered into Automne
				//then add default group if any
				if ($this->getDefaultGroup()) {
					// Use default if given
					$LDAPGroups[] = CMS_profile_usersGroupsCatalog::getById($this->getDefaultGroup());
				}
				//instanciate user
				$user = new CMS_profile_user();
				// Check login and DN to be unique
				if(CMS_profile_usersCatalog::loginExists($this->getUserdata("login"), $user)
						|| CMS_profile_usersCatalog::dnExists($this->getUserdata(APPLICATION_LDAP_USER_DN), $user)) {
					$this->raiseError("User login or dn already in use, can't register twice.");
					return null;
				}
				$user->setLastName($this->getUserdata(APPLICATION_LDAP_USER_LASTNAME));
				$user->setFirstName($this->getUserdata(APPLICATION_LDAP_USER_FIRSTNAME));
				$user->setLogin($this->getUserdata("login"));
				$user->setDN($this->getUserdata(APPLICATION_LDAP_USER_DN));
				$user->setTextEditor(defined('ADMINISTRATION_TEXT_EDITOR') ? ADMINISTRATION_TEXT_EDITOR : 'fckeditor');
				$user->setActive(true);
				//contact datas
				$userCD = CMS_contactDatas_catalog::getByUser($user, true);
				$user->setContactData($userCD);
				if ($user->writeToPersistence() && !$user->hasError()) {
					//add groups
					foreach ($LDAPGroups as $group) {
						if (is_a($group, 'CMS_profile_usersGroup') && !$group->hasError()) {
							// Add user to its group
							if (!$group->addToUserAndWriteToPersistence($user)) {
								$this->raiseError("Failed to save user ".$this->getUserData('dn')." datas or unable to add user to its group.");
								return null;
							}
						}
					}
				}
				return $user;
			} else {
				// Auto detect changes in user profile
				//Change user group if necessary
				$currentGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user);
				//user has no groups and we need to add some
				if (!$currentGroups && $LDAPGroups) {
					//first reset profile clearances
					$user->resetClearances();
					//then add user to all LDAP groups
					foreach ($LDAPGroups as $groupID => $LDAPGroup) {
						$user->addGroup($groupID);
					}
				}
				//user has groups and we need to remove all
				if ($currentGroups && !$LDAPGroups) {
					//we need to remove groups with DN
					foreach ($currentGroups as $currentGroup) {
						if ($currentGroup->getDN()) {
							if ($currentGroup->removeUser($user)) {
								$currentGroup->writeToPersistence();
							}
						}
					}
				}
				//user has groups and we need to update them
				if ($currentGroups && $LDAPGroups) {
					//first reset profile clearances
					$user->resetClearances();
					foreach ($LDAPGroups as $groupID => $LDAPGroup) {
						//if user is not already in this group, add it
						$user->addGroup($LDAPGroup);
					}
					//then add all current groups again
					foreach ($currentGroups as $groupID => $currentGroup) {
						//if group has no DN, add it
						if (!$currentGroup->getDN()) {
							$user->addGroup($currentGroup);
						} elseif (!isset($LDAPGroups[$groupID])) {
							if ($currentGroup->removeUser($user)) {
								$currentGroup->writeToPersistence();
							}
						}
					}
				}
				//then add default group if not already done
				if ($defaultGroupID = $this->getDefaultGroup()) {
					if (!isset($currentGroups[$defaultGroupID]) && !isset($LDAPGroups[$defaultGroupID])) {
						$user->addGroup($defaultGroupID);
					}
				}
				//then write user profile into persistence
				$user->writeToPersistence();
				// User has changed of dn or private data ?
				// or has been inactivated
				if ($this->getUserData(APPLICATION_LDAP_USER_DN) != $user->getDn()
						|| $this->getUserData(APPLICATION_LDAP_USER_LASTNAME) != $user->getLastName()
						|| $this->getUserData(APPLICATION_LDAP_USER_FIRSTNAME) != $user->getFirstName()
						|| !$user->isActive()) {
					// Login can't change !
					$user->setDN($this->getUserdata(APPLICATION_LDAP_USER_DN));
					$user->setLastName($this->getUserdata(APPLICATION_LDAP_USER_LASTNAME));
					$user->setFirstName($this->getUserdata(APPLICATION_LDAP_USER_FIRSTNAME));
					$user->setActive(true);
					$user->writeToPersistence();
				}
				if (!$user->hasError()) {
					return $user;
				}
			}
    	}
    	return null;
    }
    
	/**
		* Get one user info or all user info array if no parameter passed
		*
		* @param string $name, key of attribute to return value of
		* @return  string
		* @access public
		*/
	function getUserData($name = false)
	{
		if (!$name) {
			return $this->_userData;
		} else {
        	return $this->_userData[$name];
		}
	}
	
	/**
      * Get all login attributes used to compare user's login to
      *
      * @return array()
      * @access public
		* @static
      */
	function getLoginAttributes()
	{
		return array(APPLICATION_LDAP_USER_LOGIN);
	}
	
	/**
      * Get default LDAP group 
	   * Default : APPLICATION_LDAP_DEFAULT_GROUP or nothing;
      *
      * @return string
      * @access public
	   * @static
      */
	function getDefaultGroup()
	{
		if(sensitiveIO::isPositiveInteger($this->_defaultGroupID)) {
			return $this->_defaultGroupID;
		} elseif (defined('APPLICATION_LDAP_DEFAULT_GROUP') && APPLICATION_LDAP_DEFAULT_GROUP != ''
			&& sensitiveIO::isPositiveInteger(APPLICATION_LDAP_DEFAULT_GROUP)) {
			return APPLICATION_LDAP_DEFAULT_GROUP;
		} else {
			return false;
		}
	}
}
?>