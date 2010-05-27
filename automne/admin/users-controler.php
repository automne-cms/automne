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
// $Id: users-controler.php,v 1.6 2010/03/08 16:41:22 sebastien Exp $

/**
  * PHP controler : Receive actions on users
  * Used accross an Ajax request to process one user action
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_FIELD_LOGIN", 54);
define("MESSAGE_FIELD_EMAIL", 102);  
define("MESSAGE_LOGIN_EXISTS", 146);
define("MESSAGE_EMAIL_USER_EDIT_SUBJECT", 913);
define("MESSAGE_EMAIL_USER_EDIT_BODY", 914);
define("MESSAGE_EMAIL_USER_EDIT_PERSONALDATA", 916);
define("MESSAGE_FIELD_DISTINGUISHED_NAME", 1215);
define("MESSAGE_DISTINGUISHED_NAME_EXISTS", 1216);
define("MESSAGE_INCORRECT_PASSWORD_VALUES", 184);
define("MESSAGE_FIELD_PASSWORD", 55);
define("MESSAGE_FIELD_LASTNAME", 94);
define("MESSAGE_EMAIL_USER_EDIT_CONTACTDATA", 917);
define("MESSAGE_EMAIL_USER_EDIT_ALERTLEVEL", 922);
define("MESSAGE_EMAIL_USER_EDIT_GROUPS", 469);
define("MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE", 918);
define("MESSAGE_EMAIL_USER_EDIT_TEMPLATES", 921);
define("MESSAGE_EMAIL_USER_EDIT_ROWS", 1337);
define("MESSAGE_PAGE_NO_USER", 473);
define("MESSAGE_PAGE_USER_X_DELETED", 474);
define("MESSAGE_PAGE_UNKNOWN_USER", 475);
define("MESSAGE_PAGE_UNKNOWN_GROUP", 478);
define("MESSAGE_PAGE_USER_X_ACTIVATED", 476);
define("MESSAGE_PAGE_USER_X_DISABLED", 477);
define("MESSAGE_PAGE_USER_DATA_REGISTERED", 479);
define("MESSAGE_EMAIL_USER_EDIT_ADMINCLEARANCE", 919);
define("MESSAGE_EMAIL_USER_CREATED", 520);
define("MESSAGE_EMAIL_USER_MUST_RECONNECT", 591);
define("MESSAGE_PAGE_ADDED_TO_FAVORITES", 1530);
define("MESSAGE_PAGE_REMOVED_TO_FAVORITES", 1531);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'activate', 'disactivate', 'identity', 'userdetails', 'useralerts', 'addgroup', 'delgroup', 'module-rights', 'templates-rights', 'rows-rights', 'categories-rights', 'admin-rights', 'favorites'));
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');

//Identity vars
$firstname = sensitiveIO::request('firstname');
$lastname = sensitiveIO::request('lastname');
$login = sensitiveIO::request('login');
$email = sensitiveIO::request('email', 'sensitiveIO::isValidEmail');
$pass1 = sensitiveIO::request('pass1', 'sensitiveIO::isValidPassword');
$pass2 = sensitiveIO::request('pass2', 'sensitiveIO::isValidPassword');
$language = sensitiveIO::request('language');
$dn = sensitiveIO::request('dn');
//user details vars
$address1 = sensitiveIO::request('address1');
$address2 = sensitiveIO::request('address2');
$address3 = sensitiveIO::request('address3');
$cellphone = sensitiveIO::request('cellphone');
$city = sensitiveIO::request('city');
$country = sensitiveIO::request('country');
$fax = sensitiveIO::request('fax');
$jobtitle = sensitiveIO::request('jobtitle');
$phone = sensitiveIO::request('phone');
$service = sensitiveIO::request('service');
$state = sensitiveIO::request('state');
$zipcode = sensitiveIO::request('zipcode');
//alerts
$alerts = sensitiveIO::request('alerts', 'is_array', array());
//groups
$groupId = sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');
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
//favorites
$pageId = sensitiveIO::request('pageId', 'sensitiveIO::isPositiveInteger');
$status = sensitiveIO::request('status') == 'true' ? true : false;

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//load user if any
if ($userId) {
	$user = CMS_profile_usersCatalog::getByID($userId);
	if (!$user || $user->hasError()) {
		CMS_grandFather::raiseError('Unknown user for given Id : '.$userId);
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_NO_USER);
		$view->setActionMessage($cms_message);
		$view->show();
	}
}

//is it a personal profile edition ?
$personalProfile = (isset($user) && $user->getUserId() == $cms_user->getUserId());

//check user rights
if (!$personalProfile && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
} elseif ($personalProfile && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS) && !in_array($action, array('identity', 'userdetails', 'useralerts', 'favorites'))) {//define here all actions which can be done by user itself
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

$cms_message = '';

switch ($action) {
	case 'delete':
		if (is_a($user, "CMS_profile_user")) {
			$user->setDeleted(true);
			$user->setActive(false);
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "Delete user : ".$user->getFullName());
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_X_DELETED, array($user->getFullName()));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'activate':
		if (is_a($user, "CMS_profile_user")) {
			$user->setActive(true);
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "Activate user : ".$user->getFullName());
			$cms_message = $cms_language->getJSMessage(MESSAGE_PAGE_USER_X_ACTIVATED, array($user->getFullName()));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'disactivate':
		if (is_a($user, "CMS_profile_user")) {
			$user->setActive(false);
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "Disactivate user : ".$user->getFullName());
			$cms_message = $cms_language->getJSMessage(MESSAGE_PAGE_USER_X_DISABLED, array($user->getFullName()));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'addgroup':
		if (is_a($user, "CMS_profile_user")) {
			if ($groupId) {
				//add group
				$user->addGroup($groupId);
				//then write user profile into persistence
				$user->writeToPersistence();
				
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (add group to user)");
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_GROUP);
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'delgroup':
		if (is_a($user, "CMS_profile_user")) {
			if ($groupId) {
				//Get current user groups ids
				$userGroupIds = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user, true, true);
				//first reset profile clearances
				$user->resetClearances();
				
				//second, loop through user groups to remove group
				foreach ($userGroupIds as $userGroupId) {
					if ($userGroupId == $groupId) {
						//remove user to group
						$oldGroup = CMS_profile_usersGroupsCatalog::getByID($groupId);
						if ($oldGroup->removeUser($user)) {
							$oldGroup->writeToPersistence();
						}
					}
				}
				//third, loop through user groups to add old groups
				foreach ($userGroupIds as $userGroupId) {
					if ($userGroupId != $groupId) {
						//add group to user
						$user->addGroup($userGroupId);
					}
				}
				//then write user profile into persistence
				$user->writeToPersistence();
				
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (remove group to user)");
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_GROUP);
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'module-rights':
		if (is_a($user, "CMS_profile_user")) {
			$user->addModuleClearance($moduleCodename, $access, true);
			$user->delValidationClearance($moduleCodename);
			if ($validation) {
				$user->addValidationClearance($moduleCodename);
			}
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit module clearance)");
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
			if ($personalProfile) {
				$cms_message .= '<br /><br /><span class="atm-red">'.$cms_language->getMessage(MESSAGE_EMAIL_USER_MUST_RECONNECT).'</span>';
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'templates-rights':
		if (is_a($user, "CMS_profile_user")) {
			$templateGroups = CMS_pageTemplatesCatalog::getAllGroups();
			$newTemplateGroups = new CMS_Stack();
			$newTemplateGroups->setValuesByAtom(1);
			foreach ($templateGroups as $templateGroup) {
				if	(!isset($templates[$templateGroup]) || $templates[$templateGroup] != 'on') {
					$newTemplateGroups->add($templateGroup);
				}
			}
			$user->setTemplateGroupsDenied($newTemplateGroups);
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit templates groups)");
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_TEMPLATES);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'rows-rights':
		if (is_a($user, "CMS_profile_user")) {
			$rowGroups = CMS_rowsCatalog::getAllGroups();
			$newRowGroups = new CMS_Stack();
			$newRowGroups->setValuesByAtom(1);
			foreach ($rowGroups as $rowGroup) {
				if	(!isset($rows[$rowGroup]) || $rows[$rowGroup] != 'on') {
					$newRowGroups->add($rowGroup);
				}
			}
			$user->setRowGroupsDenied($newRowGroups);
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit rows groups)");
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ROWS);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_USER);
		}
	break;
	case 'categories-rights':
		if (is_a($user, "CMS_profile_user")) {
			if ($moduleCodename != MOD_STANDARD_CODENAME) {
				// All clearances to assign to user (static)
				$modulesClearances = CMS_Profile::getAllModuleCategoriesClearances();
				$stackClearances = $user->getModuleCategoriesClearancesStack();
			} else {
				// All clearances to assign to user (static)
				$modulesClearances = CMS_Profile::getAllPageClearances();
				$stackClearances = $user->getPageClearances();
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
				$user->setModuleCategoriesClearancesStack($stackClearances);
			} else {
				$user->setPageClearances($stackClearances);
			}
			$user->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (Page clearances)");
			
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
		}
	break;
	case 'admin-rights':
		if (is_a($user, "CMS_profile_user")) {
			$newAdminClearance = 0;
			foreach ($admin as $clearance) {
				if	($cms_user->hasAdminClearance($clearance)) {
					$newAdminClearance += $clearance;
				}
			}
			$user->setAdminClearance($newAdminClearance);
			$user->writeToPersistence();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit admin clearances)");
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ADMINCLEARANCE);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
			if ($personalProfile) {
				$cms_message .= '<br /><br /><span class="atm-red">'.$cms_language->getMessage(MESSAGE_EMAIL_USER_MUST_RECONNECT).'</span>';
			}
		}
	break;
	case 'identity':
		//set return to false by default
		$content = array('success' => false);
		if (!isset($user) || !is_a($user, "CMS_profile_user")) {
			$user = new CMS_profile_user();
		}
		//is it a new user creation ?
		$userCreation = $user->getUserId() ? false : true;
		//email
		if ($email) {
			$contactData = $user->getContactData();
			$contactData->setEmail($email);
			$user->setContactData($contactData); 
		} elseif(!$user->getEmail()) {
			$cms_message = $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE, array($cms_language->getMessage(MESSAGE_FIELD_EMAIL)))."\n";
		}
		
		//lastname
		if ($lastname) {
			$user->setLastName(ucfirst($lastname));
		} elseif (!$user->getDN()) {
			$cms_message = $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE, array($cms_language->getMessage(MESSAGE_FIELD_LASTNAME)))."\n";
		}
		//firstname
		$user->setFirstName(ucfirst($firstname));
		//login
		if ($login && CMS_profile_usersCatalog::loginExists($login, $user)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_LOGIN_EXISTS, array($login))."\n";
		} elseif ($login && !$user->setLogin($login)) { 
			$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE, array($cms_language->getMessage(MESSAGE_FIELD_LOGIN)))."\n";
		} elseif (APPLICATION_LDAP_AUTH && !$user->getDN()) {
			$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE, array($cms_language->getMessage(MESSAGE_FIELD_LOGIN)))."\n";
		}
		
		//Check password fields
		if($pass1 && $pass2 && $pass1 == $pass2 && $user->getLogin() != $pass1) {
		   $user->setPassword($pass1);
		   /*if (!APPLICATION_LDAP_AUTH)  {
				$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_PASSWORD_VALUES)."\n";
		   }*/
		} elseif (!$user->havePassword() && !$user->getDN()) {
			$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE, array($cms_language->getMessage(MESSAGE_FIELD_PASSWORD)))."\n";
		} elseif ($pass1 || $pass2) {
			$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_PASSWORD_VALUES)."\n";
		}
		
		//Update new language if necessary
		if ($newlanguage = CMS_languagesCatalog::getByCode($language)) {
			$user->setLanguage($newlanguage);
			if ($personalProfile) {
				$cms_language = $newlanguage;
				//TODOV4 : reload cms_user and user interface
				$reloadAll = true;
			}
		}
		
		// LDAP dn, only required when LDAP Auth activated
		if ($dn) {
			if (CMS_profile_usersCatalog::dnExists($dn, $user)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_DISTINGUISHED_NAME_EXISTS, array($dn))."\n";
			} else {
				$user->setDN(CMS_ldap_query::appendWithBaseDn($dn));
			}
		} elseif (APPLICATION_LDAP_AUTH && !$user->getDN()) {
			$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_FIELD_VALUE,array($cms_language->getMessage(MESSAGE_FIELD_DISTINGUISHED_NAME)))."\n";
		}
		
		// Check if any errors when updating user datas
		if (!$cms_message) {
			$user->writeToPersistence();
			$log = new CMS_log();
			if (!$userCreation) {
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit personal data)");
			} else {
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (user creation)");
			}
			//if this not a personal profile update and not a user creation, send email alert
			if (!$personalProfile && !$userCreation) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_PERSONALDATA);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			if ($userCreation) {
				$content = array('success' => array('userId' => $user->getUserId()));
				$cms_message = $cms_language->getMessage(MESSAGE_EMAIL_USER_CREATED);
			} else {
				$content = array('success' => true);
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
				if ($personalProfile) {
					$cms_message .= '<br /><br /><span class="atm-red">'.$cms_language->getMessage(MESSAGE_EMAIL_USER_MUST_RECONNECT).'</span>';
				}
			}
		}
		$view->setContent($content);
	break;
	case 'userdetails':
		//set return to false by default
		$content = array('success' => false);
		if (is_a($user, "CMS_profile_user")) {
			//get user CD
			$contactData = $user->getContactData();
			$contactData->setJobTitle($jobtitle);
			$contactData->setService($service);
			$contactData->setPhone($phone);
			$contactData->setCellphone($cellphone);
			$contactData->setFax($fax);
			$contactData->setAddressField1($address1);
			$contactData->setAddressField2($address2);
			$contactData->setAddressField3($address3);
			$contactData->setZip($zipcode);
			$contactData->setCity($city);
			$contactData->setState($state);
			$contactData->setCountry($country);
			$user->setContactData($contactData); 
			$user->writeToPersistence();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit contact data)");
			//if this not a personal profile update, send email alert
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_CONTACTDATA);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
			if ($personalProfile) {
				$cms_message .= '<br /><br /><span class="atm-red">'.$cms_language->getMessage(MESSAGE_EMAIL_USER_MUST_RECONNECT).'</span>';
			}
		}
		$view->setContent($content);
	break;
	case 'useralerts':
		//set return to false by default
		$content = array('success' => false);
		if (is_a($user, "CMS_profile_user")) {
			//set all alerts levels
			$user->resetAlertLevel();
			foreach($alerts as $codename => $levels) {
				$level = array_sum($levels);
				$user->setAlertLevel($level, $codename);
			}
			$user->writeToPersistence();
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFullName()." (edit alerts levels)");
			//if this not a personal profile update, send email alert
			if (!$personalProfile) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($user->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ALERTLEVEL);
				}
				$group_email->setUserMessages(array($user), $bodies, $subjects, ALERT_LEVEL_PROFILE, MOD_STANDARD_CODENAME);
				$group_email->sendMessages();
			}
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_USER_DATA_REGISTERED);
		}
		$view->setContent($content);
	break;
	case 'favorites':
		//set return to false by default
		$content = array('success' => false);
		if (is_a($user, "CMS_profile_user")) {
			$user->setFavorite($status, $pageId);
			$user->writeToPersistence();
			$content = array('success' => true);
			if ($status) {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ADDED_TO_FAVORITES);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_REMOVED_TO_FAVORITES);
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