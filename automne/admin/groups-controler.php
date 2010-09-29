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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: groups-controler.php,v 1.4 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP controler : Receive users actions
  * Used accross an Ajax request to process one user action
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_USER", 908);
define("MESSAGE_PAGE_NO_GROUP_SEARCH", 404);
define("MESSAGE_PAGE_GROUP_DELETED", 493);
define("MESSAGE_PAGE_GROUP_UNKNOWN", 494);
define("MESSAGE_PAGE_USER_OR_GROUP_UNKNOWN", 495);
define("MESSAGE_PAGE_DATA_SAVED_GROUP", 496);
define("MESSAGE_PAGE_GROUP_CREATED", 497);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'identity', 'adduser', 'deluser', 'module-rights', 'templates-rights', 'rows-rights', 'categories-rights', 'admin-rights'));
$groupId = sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');

//Identity vars
$label = sensitiveIO::request('label');
$description = sensitiveIO::request('description');
$dn = sensitiveIO::request('dn');
$invertdn = sensitiveIO::request('invertdn');
//alerts
$alerts = sensitiveIO::request('alerts');
//users
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
//modules
$moduleCodename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$access = (int) sensitiveIO::request('access');
$validation = (int) sensitiveIO::request('validation');
$templates = sensitiveIO::request('templates', '', array());
$rows = sensitiveIO::request('rows', '', array());
//categories rights
$rights = sensitiveIO::request('rights');
$catIds = sensitiveIO::request('catIds');
//admin rights
$admin = sensitiveIO::request('admin', '', array());

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

//load user if any
if ($groupId) {
	$group = CMS_profile_usersGroupsCatalog::getByID($groupId);
	if (!$group || $group->hasError()) {
		CMS_grandFather::raiseError('Unknown group for given Id : '.$groupId);
		$cms_message = $cms_language->getJsMessage(MESSAGE_PAGE_NO_GROUP_SEARCH);
		$view->setActionMessage($cms_message);
		$view->show();
	}
}

$cms_message = '';

switch ($action) {
	case 'delete':
		if (is_a($group, "CMS_profile_usersGroup")) {
			$group->destroy();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_DELETE, $cms_user, "Group : ".$group->getLabel());
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_GROUP_DELETED);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_GROUP_UNKNOWN);
		}
	break;
	case 'adduser':
		if ($userId) {
			$user = CMS_profile_usersCatalog::getByID($userId);
			if (!$user || $user->hasError()) {
				$user = false;
			}
		}
		if (is_a($group, "CMS_profile_usersGroup") && is_a($user, "CMS_profile_user")) {
			//add group
			$user->addGroup($groupId);
			//then write user profile into persistence
			$user->writeToPersistence();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (add group to user)");
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_OR_GROUP_UNKNOWN);
		}
	break;
	case 'deluser':
		if ($userId) {
			$user = CMS_profile_usersCatalog::getByID($userId);
			if (!$user || $user->hasError()) {
				$user = false;
			}
		}
		if (is_a($group, "CMS_profile_usersGroup") && is_a($user, "CMS_profile_user")) {
			//Get current user groups ids
			$userGroupIds = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user, true, true);
			
			//first reset profile clearances
			$user->resetClearances();
			
			//then loop through user groups
			foreach ($userGroupIds as $userGroupId) {
				if ($userGroupId == $groupId) {
					//remove user to group
					$oldGroup = CMS_profile_usersGroupsCatalog::getByID($groupId);
					if ($oldGroup->removeUser($user)) {
						$oldGroup->writeToPersistence();
					}
				} else {
					//add group to user
					$user->addGroup($userGroupId);
				}
			}
			//then write user profile into persistence
			$user->writeToPersistence();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (remove group to user)");
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_OR_GROUP_UNKNOWN);
		}
	break;
	case 'module-rights':
		if (is_a($group, "CMS_profile_usersGroup")) {
			$group->addModuleClearance($moduleCodename, $access, true);
			$group->delValidationClearance($moduleCodename);
			if ($validation) {
				$group->addValidationClearance($moduleCodename);
			}
			$group->writeToPersistence();
			$group->applyToUsers();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel()." (edit module clearance)");
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'templates-rights':
		if (is_a($group, "CMS_profile_usersGroup")) {
			$templateGroups = CMS_pageTemplatesCatalog::getAllGroups();
			$newTemplateGroups = new CMS_Stack();
			$newTemplateGroups->setValuesByAtom(1);
			foreach ($templateGroups as $templateGroup) {
				if	(!isset($templates[base64_encode($templateGroup)]) || $templates[base64_encode($templateGroup)] != 'on') {
					$newTemplateGroups->add($templateGroup);
				}
			}
			$group->setTemplateGroupsDenied($newTemplateGroups);
			$group->writeToPersistence();
			$group->applyToUsers();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel()." (edit templates groups)");
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'rows-rights':
		if (is_a($group, "CMS_profile_usersGroup")) {
			$rowGroups = CMS_rowsCatalog::getAllGroups();
			$newRowGroups = new CMS_Stack();
			$newRowGroups->setValuesByAtom(1);
			foreach ($rowGroups as $rowGroup) {
				if	(!isset($rows[base64_encode($rowGroup)]) || $rows[base64_encode($rowGroup)] != 'on') {
					$newRowGroups->add($rowGroup);
				}
			}
			$group->setRowGroupsDenied($newRowGroups);
			$group->writeToPersistence();
			$group->applyToUsers();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel()." (edit rows groups)");
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'categories-rights': //TODOV4
		if (is_a($group, "CMS_profile_usersGroup")) {
			if ($moduleCodename != MOD_STANDARD_CODENAME) {
				// All clearances to assign to user (static)
				$modulesClearances = CMS_Profile::getAllModuleCategoriesClearances();
				$stackClearances = $group->getModuleCategoriesClearancesStack();
			} else {
				// All clearances to assign to user (static)
				$modulesClearances = CMS_Profile::getAllPageClearances();
				$stackClearances = $group->getPageClearances();
			}
			// Clearances
			$rights = explode(';', $rights);
			$clearances = array();
			foreach ($rights as $right) {
				list($id, $clr) = explode(',', $right);
				$clearances[$id] = $clr;
			}
			// IDs
			$ids = explode(',', $catIds);
			//set clearance stack
			if ($ids) {
				foreach ($ids as $id) {
					$stackClearances->delAllWithOneKey($id);
					if (isset($clearances[$id])) {
						$clr = (int) $clearances[$id];
						if (in_array($clr,$modulesClearances)) {
							$stackClearances->add($id, $clr);
						}
					}
				}
			}
			//set new clearances to user
			if ($moduleCodename != MOD_STANDARD_CODENAME) {
				$group->setModuleCategoriesClearancesStack($stackClearances);
			} else {
				$group->setPageClearances($stackClearances);
			}
			$group->writeToPersistence();
			$group->applyToUsers();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel()." (Page clearances)");
			
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
		}
	break;
	case 'admin-rights':
		if (is_a($group, "CMS_profile_usersGroup")) {
			$newAdminClearance = 0;
			foreach ($admin as $clearance) {
				if	($cms_user->hasAdminClearance($clearance)) {
					$newAdminClearance += $clearance;
				}
			}
			$group->setAdminClearance($newAdminClearance);
			$group->writeToPersistence();
			$group->applyToUsers();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel()." (edit admin clearances)");
			
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
		}
	break;
	case 'identity':
		//set return to false by default
		$content = array('success' => false);
		if (!isset($group) || !is_a($group, "CMS_profile_usersGroup")) {
			$group = new CMS_profile_usersGroup();
		}
		//is it a new user creation ?
		$groupCreation = $group->getGroupId() ? false : true;
		
		$group->setLabel($label);
		
		// LDAP dn
		$group->setInvertDN($invertdn);
		// LDAP dn, only required when LDAP Auth activated
		if ($dn) {
			if (CMS_profile_usersCatalog::dnExists($dn, $group)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_DISTINGUISHED_NAME_EXISTS, array($dn))."\n";
			} else {
				$group->setDN(CMS_ldap_query::appendWithBaseDn($dn));
			}
		}
		
		$group->setDescription($description);
		// Check if any errors when updating group datas
		if (!$cms_message) {
			$group->writeToPersistence();
			$log = new CMS_log();
			if (!$groupCreation) {
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel(). "(Edit group identity)");
			} else {
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel(). "(Creation)");
			}
			
			if ($groupCreation) {
				$content = array('success' => array('groupId' => $group->getGroupId()));
				$cms_message = $cms_language->getJsMessage(MESSAGE_PAGE_GROUP_CREATED);
			} else {
				$content = array('success' => true);
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_DATA_SAVED_GROUP);
			}
		}
		$view->setContent($content);
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>