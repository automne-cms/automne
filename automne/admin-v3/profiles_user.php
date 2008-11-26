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
// | Author: S?stien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profiles_user.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : entry
  * Entry page. Presents all the user "sections" (page clearances sections) and all the user available validations.
  *
  * @package CMS
  * @subpackage admin
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author S?stien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 68);
define("MESSAGE_NAME", 93);  
define("MESSAGE_SURNAME", 94); 
define("MESSAGE_LOGIN", 54);
define("MESSAGE_PASSWORD", 55);
define("MESSAGE_PAGE_GROUPS", 837);
define("MESSAGE_BASE_DATA", 1106);
define("MESSAGE_CONFIRM_PASSWORD", 95);
define("MESSAGE_WORD_LANGUAGE", 96);
define("MESSAGE_WORD_EDITOR", 288);
define("MESSAGE_CONTACT_DATA", 99);
define("MESSAGE_EMAIL", 102);  
define("MESSAGE_JOBTITLE", 112); 
define("MESSAGE_SERVICE", 103); 
define("MESSAGE_ADDRESS", 104);
define("MESSAGE_ZIP", 105);
define("MESSAGE_CITY", 106);
define("MESSAGE_STATE", 107);
define("MESSAGE_COUNTRY", 108);
define("MESSAGE_PHONE", 109);
define("MESSAGE_CELLPHONE", 110);
define("MESSAGE_FAX", 111);
define("MESSAGE_USER_RIGHTS", 113);
define("MESSAGE_TOTAL_USER_RIGHTS", 114);
define("MESSAGE_META_RIGHTS", 115);
define("MESSAGE_LOGIN_EXISTS", 146);
define("MESSAGE_INCORRECT_PASSWORD_VALUES", 184);
define("MESSAGE_NO_GROUP", 190);
define("MESSAGE_ALERT_LEVEL_DESCRIPTION", 204);
define("MESSAGE_ALERT_LEVEL_HEADING", 197);
define("MESSAGE_LEVEL", 230);
define("MESSAGE_CHANGE", 231);
define("MESSAGE_TEMPLATESROWS_HEADING", 1107);
define("MESSAGE_TEMPLATES_HEADING", 1333);
define("MESSAGE_TEMPLATE_DESCRIPTION", 232);
define("MESSAGE_TEMPLATE_INSTRUCTION", 233);
define("MESSAGE_ROWS_HEADING", 1334);
define("MESSAGE_ROW_DESCRIPTION", 1335);
define("MESSAGE_RIGHTS", 242);
define("MESSAGE_NEW_SECTION", 244);
define("MESSAGE_DELETE", 1131);
define("MESSAGE_NEW_SECTION_SUBTITLE", 63);
define("TEMPLATE_COLS", 10);
define("MESSAGE_BUTTON_CANCEL", 180);
define("MESSAGE_MODULE_RIGHTS", 247);
define("MESSAGE_VALIDATION_RIGHTS", 279);
define("MESSAGE_ADD", 260);
define("MESSAGE_PAGE_EDITOR_NONE", 285);
define("MESSAGE_PAGE_EDITOR_RICHTEXT", 286);
define("MESSAGE_PAGE_EDITOR_APPLET", 287);
define("MESSAGE_PAGE_EDITOR_FCKEDITOR", 1164);
define("MESSAGE_USER_RIGHTS_NONE", 10);
define("MESSAGE_USER_RIGHTS_VIEW", 11);
define("MESSAGE_USER_RIGHTS_EDIT", 12);
define("MESSAGE_MOD_STANDARD_LABEL", 213);
define("MESSAGE_EMAIL_USER_EDIT_SUBJECT", 913);
define("MESSAGE_EMAIL_USER_EDIT_BODY", 914);
define("MESSAGE_EMAIL_USER_EDIT_PAGECLEARANCE", 915);
define("MESSAGE_EMAIL_USER_EDIT_PERSONALDATA", 916);
define("MESSAGE_EMAIL_USER_EDIT_CONTACTDATA", 917);
define("MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE", 918);
define("MESSAGE_EMAIL_USER_EDIT_ADMINCLEARANCE", 919);
define("MESSAGE_EMAIL_USER_EDIT_VALIDATIONCLEARANCE", 920);
define("MESSAGE_EMAIL_USER_EDIT_TEMPLATES", 921);
define("MESSAGE_EMAIL_USER_EDIT_ROWS", 1337);
define("MESSAGE_EMAIL_USER_EDIT_ALERTLEVEL", 922);
define("MESSAGE_USER_RIGHTS_MODULES_NONE", 1101);
define("MESSAGE_USER_RIGHTS_MODULES_VIEW", 1102);
define("MESSAGE_USER_RIGHTS_MODULES_EDIT", 1103);
define("MESSAGE_MODULE_DELETE", 1114);
define("MESSAGE_DISTINGUISHED_NAME", 1215);
define("MESSAGE_DISTINGUISHED_NAME_EXISTS", 1216);
define("MESSAGE_PAGE_REMOVE_USER_OF_GROUP_CONFIRM", 1310);
define("MESSAGE_PAGE_TITLE_MODULES_ACCESS", 1210);
define("MESSAGE_PAGE_TITLE_VIEW_MODULES_ACCESS", 1349);

// Check user rights and assign appropriate details
if($hasAdminClearance = $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	if ($_GET["userId"]) {
		$userEdited = CMS_profile_usersCatalog::getByID($_GET["userId"]);
	} else {
		$userEdited = CMS_profile_usersCatalog::getByID($_POST["userId"]);
	} 
	
	//Retrieve navigation values from previous page
	$surnameSort = $_POST["surnameSort"].$_GET["surnameSort"];
	$nameSort = $_POST["nameSort"].$_GET["nameSort"];
	$primarySort = $_POST["primarySort"].$_GET["primarySort"];
	$searchValue = $_POST["searchValue"].$_GET["searchValue"];
	$searchCol = $_POST["searchCol"].$_GET["searchCol"];
	$viewByLetter = $_POST["viewByLetter"].$_GET["viewByLetter"];
	
	// Set Hidden values html
	$postHiddenValues = '
		<input type="hidden" name="surnameSort" value="'.$surnameSort.'" />
		<input type="hidden" name="nameSort" value="'.$nameSort.'" />
		<input type="hidden" name="primarySort" value="'.$primarySort.'" />
		<input type="hidden" name="searchValue" value="'.$searchValue.'" />
		<input type="hidden" name="searchCol" value="'.$searchCol.'" />
		<input type="hidden" name="viewByLetter" value="'.$viewByLetter.'" />
	';
	
	$urlHiddenValues = 'surnameSort='.$surnameSort.'&nameSort='.$nameSort.'&';
	$urlHiddenValues .= 'primarySort='.$primarySort.'&searchValue='.$searchValue.'&';
	$urlHiddenValues .= 'searchCol='.$searchCol.'&viewByLetter='.$viewByLetter;
	
	//Create back Link for administrator
	$backLink = PATH_ADMIN_WR.'/profiles_users.php?'.$urlHiddenValues;
	
} else {
	$userEdited = &$cms_user;
}

// Check if editing own profile
$personalProfile = false;
if ($cms_user->getUserId() == $_POST["userId"]
    || $cms_user->getUserId() == $_GET["userId"]) {
	$personalProfile = true;
	$userEdited = &$cms_user;
}


$alterGroupAction = false;

// Possible get action
switch (trim($_GET["cms_action"])) {
//Create blank form
case "add":
	$userEdited = new CMS_profile_user;
	$superAction = "add";
	break;
// Change template group data
/*case "addPageClearance":
	$userEdited->addPageClearance($_GET["sectionroot"], CLEARANCE_PAGE_NONE, true);
	$userEdited->writeToPersistence();
	$alterGroupAction = true;

	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (add page clearances)");
	
	$group_email = new CMS_emailsCatalog();
	$languages = CMS_languagesCatalog::getAllLanguages();
	$subjects = array();
	$bodies = array();
	foreach ($languages as $language) {
		$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
		$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_PAGECLEARANCE);
	}
	$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
	$group_email->sendMessages();
	break;	*/
}

// Possible post actions
switch (trim($_POST["cms_action"])) {
//Create blank form
case "add":
	$userEdited = new CMS_profile_user;
	$superAction = "add";
	break;

//Update all core data
case "changeCoreData":
   if ($_POST["cms_super_action"] == "add") {
	   $userEdited = new CMS_profile_user;
	   $errors = 0;
   }
   
   //email
	if ($_POST["email"]) {
		$contactData = $userEdited->getContactData();
		$contactData->setEmail($_POST["email"]);
		$userEdited->setContactData($contactData); 
		$userEdited->writeToPersistence();
	}
   
   //Check surname
   if ($_POST["surname"]) {
	   $userEdited->setLastName(ucfirst($_POST["surname"]));
   } elseif (!$userEdited->getDN()) {
	   $cms_message = $cms_language->getMessage(
			MESSAGE_INCORRECT_FIELD_VALUE, 
			array($cms_language->getMessage(MESSAGE_SURNAME)));
		$errors++;
   }
   
   // Check login details
   if ($_POST["login"] && CMS_profile_usersCatalog::loginExists($_POST["login"], $userEdited)) {
	   if ($cms_message) {
		   $cms_message .= "\n";
	   }
	   $cms_message .= $cms_language->getMessage(
			MESSAGE_LOGIN_EXISTS, array($_POST["login"]));
	   $errors++;
   } elseif ($_POST["login"]) { 
	   $userEdited->setLogin($_POST["login"]);
   } elseif (!$userEdited->getDN()) {
	   if ($cms_message) {
		   $cms_message .= "\n";
	   }
	   $cms_message .= $cms_language->getMessage(
		 MESSAGE_INCORRECT_FIELD_VALUE, 
		 array($cms_language->getMessage(MESSAGE_LOGIN)));
	   $errors++;
   }
   
   //Check password fields
   if($_POST["pass"] && SensitiveIO::isValidPassword($_POST["pass"]) && $userEdited->getLogin() != $_POST["pass"]) {
	   if($_POST["pass"] == $_POST["pass2"]) {
		   $userEdited->setPassword($_POST["pass"]);
	   } elseif (!APPLICATION_LDAP_AUTH)  {
		   if ($cms_message) {
			   $cms_message .= "\n";
		   }
		   $cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_PASSWORD_VALUES);
		   $errors++;
	   }
   } elseif (!$userEdited->havePassword() && !$userEdited->getDN()) {
	   if ($cms_message) {
		   $cms_message .= "\n";
	   }
	   $cms_message .= $cms_language->getMessage(
		   MESSAGE_INCORRECT_FIELD_VALUE, 
		   array($cms_language->getMessage(MESSAGE_PASSWORD)));
	   $errors++;
   } elseif ($_POST["pass"] && (!SensitiveIO::isValidPassword($_POST["pass"]) || $userEdited->getLogin() == $_POST["pass"])) {
   		$cms_message .= $cms_language->getMessage(MESSAGE_INCORRECT_PASSWORD_VALUES);
		$errors++;
   }
   
   $userEdited->setFirstName(ucfirst($_POST["name"]));
   
   //Update new language if necessary
   if ($newlanguage = CMS_languagesCatalog::getByCode($_POST["language"])) {
	  $userEdited->setLanguage($newlanguage);
	  if ($personalProfile) {
		  $cms_language = $newlanguage;
		  $reloadAll = true;
	  }
   }

   //set text editor
   $userEdited->setTextEditor($_POST["texteditor"]);
   
   // LDAP dn, only required when LDAP Auth activated
   if ($_POST["dn"]) {
		if (CMS_profile_usersCatalog::dnExists($_POST["dn"], $userEdited)) {
			if ($cms_message) {
				$cms_message .= "\n";
			}
			$cms_message .= $cms_language->getMessage(
					MESSAGE_DISTINGUISHED_NAME_EXISTS, array($_POST["dn"]));
			$errors++;
		} else {
			$userEdited->setDN(CMS_ldap_query::appendWithBaseDn($_POST["dn"]));
		}
	} elseif (APPLICATION_LDAP_AUTH && !$userEdited->getDN()) {
		if ($cms_message) {
			$cms_message .= "\n";
		}
		$cms_message .= $cms_language->getMessage(
   				MESSAGE_INCORRECT_FIELD_VALUE,
   				array($cms_language->getMessage(MESSAGE_DISTINGUISHED_NAME)));
   		$errors++;
   	}
	
	// Check if any errors when creating user
	if ($errors && $_POST["cms_super_action"]) {
		$superAction = "add";
	} else {
		$superAction = "";
		$userEdited->writeToPersistence();

		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit personal data)");
	
		if (!$_POST["cms_super_action"]) {
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
						."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_PERSONALDATA);
			}
			$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
			$group_email->sendMessages();
		}
	}	
	break;
	
// Set contact Data	
case "changeContactData":
	$contactData = $userEdited->getContactData();
	$contactData->setJobTitle($_POST["jobtitle"]);
	$contactData->setService($_POST["service"]);
	$contactData->setPhone($_POST["phone"]);
	$contactData->setCellphone($_POST["cellphone"]);
	$contactData->setFax($_POST["fax"]);
	$contactData->setAddressField1($_POST["address1"]);
	$contactData->setAddressField2($_POST["address2"]);
	$contactData->setAddressField3($_POST["address3"]);
	$contactData->setZip($_POST["zip"]);
	$contactData->setCity($_POST["city"]);
	$contactData->setState($_POST["state"]);
	$contactData->setCountry($_POST["country"]);
	$userEdited->setContactData($contactData); 
	$userEdited->writeToPersistence();
	
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit contact data)");
	
	$group_email = new CMS_emailsCatalog();
	$languages = CMS_languagesCatalog::getAllLanguages();
	$subjects = array();
	$bodies = array();
	foreach ($languages as $language) {
		$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
		$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_CONTACTDATA);
	}
	$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
	$group_email->sendMessages();
	break;
case 'changeGroups':
	//get posted groups
	$groups = explode(';',$_REQUEST['userGroups']);
	foreach ($groups as $key => $groupID) {
		if (!sensitiveIO::isPositiveInteger($groupID)) {
			unset($groups[$key]);
		}
	}
	//Get current user groups
	$oldGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($userEdited, false, true);
	
	//user has no groups and we need to add some
	if (!sizeof($oldGroups) && sizeof($groups)) {
		//first reset profile clearances
		$userEdited->resetClearances();
		//then add user to all groups
		foreach ($groups as $groupID) {
			$userEdited->addGroup($groupID);
		}
	}
	//user has groups and we need to remove all
	if (sizeof($oldGroups) && !sizeof($groups)) {
		//we need to remove groups without removing user clearances
		foreach ($oldGroups as $oldGroup) {
			if ($oldGroup->removeUser($userEdited)) {
				$oldGroup->writeToPersistence();
			}
		}
	}
	//user has groups and we need to update them
	if (sizeof($oldGroups) && sizeof($groups)) {
		//first reset profile clearances
		$userEdited->resetClearances();
		//then remove all groups which user does not belongs to anymore
		foreach ($oldGroups as $groupID => $oldGroup) {
			if (!in_array($groupID, $groups)) {
				if ($oldGroup->removeUser($userEdited)) {
					$oldGroup->writeToPersistence();
				}
			}
		}
		//add new groups
		foreach ($groups as $groupID) {
			//if user is not already in this group, add it
			if (!isset($oldGroups[$groupID])) {
				$userEdited->addGroup($groupID);
			}
		}
		//then add all old groups again
		foreach ($oldGroups as $groupID => $oldGroup) {
			if (in_array($groupID, $groups)) {
				$userEdited->addGroup($oldGroup);
			}
		}
	}
	//then write user profile into persistence
	$userEdited->writeToPersistence();
	break;
// Change admin clearance	
case "changeAdminClearance":
	$adminClearances = CMS_profile::getAllAdminClearances();
	$newAdminClearance = $userEdited->getAdminClearance();
	
	foreach ($adminClearances as $adminClearance) {
		if	($cms_user->hasAdminClearance($adminClearance) && 
			 $_POST[$adminClearance] && 
			 !($userEdited->hasAdminClearance($adminClearance))) {
			$newAdminClearance += $adminClearance;
		} elseif (!$_POST[$adminClearance] && 
			   $userEdited->hasAdminClearance($adminClearance)) {
			$newAdminClearance -= $adminClearance;
		}
	}
	
	$userEdited->setAdminClearance($newAdminClearance);
	$userEdited->writeToPersistence();
	$alterGroupAction = true;

	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit admin clearances)");
	
	$group_email = new CMS_emailsCatalog();
	$languages = CMS_languagesCatalog::getAllLanguages();
	$subjects = array();
	$bodies = array();
	foreach ($languages as $language) {
		$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
		$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ADMINCLEARANCE);
	}
	$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
	$group_email->sendMessages();
	break;	
	
// Change template and row group data
case "changeTemplateRowGroup":
	// Templates
	$templateGroups = CMS_pageTemplatesCatalog::getAllGroups();
	$newTemplateGroups = new CMS_Stack();
	$newTemplateGroups->setValuesByAtom(1);
	foreach ($templateGroups as $templateGroup) {
		if	(!$_POST["groupTemplate_".$templateGroup]) {
			$newTemplateGroups->add($templateGroup);
		}
	}
	$userEdited->setTemplateGroupsDenied($newTemplateGroups);
	$userEdited->writeToPersistence();
	$alterGroupAction = true;	
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit denied templates groups)");
	// Rows
	$rowGroups = CMS_rowsCatalog::getAllGroups();
	$newRowGroups = new CMS_Stack();
	$newRowGroups->setValuesByAtom(1);
	foreach ($rowGroups as $rowGroup) {
		if	(!$_POST["groupRow_".$rowGroup]) {
			$newRowGroups->add($rowGroup);
		}
	}
	$userEdited->setRowGroupsDenied($newRowGroups);
	$userEdited->writeToPersistence();
	$alterGroupAction = true;
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit denied rows groups)");
	// Email for templates/rows edition
	$group_email = new CMS_emailsCatalog();
	$languages = CMS_languagesCatalog::getAllLanguages();
	$subjects = array();
	$bodies = array();
	foreach ($languages as $language) {
		$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
		$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_TEMPLATES)
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ROWS);
	}
	$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
	$group_email->sendMessages();
	break;
	
case "changeAlertLevel":
	$userEdited->setAlertLevel($_POST["alert"]); 
	$userEdited->writeToPersistence();

	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (change alert level)");
	
	$group_email = new CMS_emailsCatalog();
	$languages = CMS_languagesCatalog::getAllLanguages();
	$subjects = array();
	$bodies = array();
	foreach ($languages as $language) {
		$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
		$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
				."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_ALERTLEVEL);
	}
	$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
	$group_email->sendMessages();
	break;	
case "setModuleClearance":
	foreach ($_POST["modulesClearance"] as $aModuleClearance) {
		if ($_POST["removeModule_".$aModuleClearance]=='1') {
			$userEdited->delModuleClearance($aModuleClearance);
			$userEdited->writeToPersistence();
			$alterGroupAction = true;
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (remove module clearance)");
			
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
						."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE);
			}
			$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
			$group_email->sendMessages();
		} else {
			if ($_POST["setModuleClearance_".$aModuleClearance] != $_POST["initClearance_".$aModuleClearance]) {
				$userEdited->addModuleClearance($aModuleClearance, $_POST["setModuleClearance_".$aModuleClearance], true);
				$userEdited->writeToPersistence();
				$alterGroupAction = true;
				
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit module clearance)");
				
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
							."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE);
				}
				$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
				$group_email->sendMessages();
			}
		}
	}
	break;

case "addModuleClearance":
	if ($_POST["othermodules"]) {
		$userEdited->addModuleClearance($_POST["othermodules"], CLEARANCE_MODULE_NONE, true);
		$userEdited->writeToPersistence();
		$alterGroupAction = true;
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (add module clearance)");
		$group_email = new CMS_emailsCatalog();
		$languages = CMS_languagesCatalog::getAllLanguages();
		$subjects = array();
		$bodies = array();
		foreach ($languages as $language) {
			$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
			$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
					."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_MODULECLEARANCE);
		}
		$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
		$group_email->sendMessages();
	}
	break;
	
case "changeValidation":
	// Loop through each of the users old modules as these
	// are the only ones that can be validated
	$validationClearancesStack = $userEdited->getModuleClearances();
	$validationClearances = $validationClearancesStack->getElements();
	
	foreach ($validationClearances as $validationClearance) {
	
		$validationName = $validationClearance[0];
		
		if ($cms_user->hasValidationClearance($validationName) &&
			$_POST[$validationName] && 
			!($userEdited->hasValidationClearance($validationName))) {
			
			$userEdited->addValidationClearance($validationName);
			$userEdited->writeToPersistence();
			$alterGroupAction = true;
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit validation clearances)");
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
						."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_VALIDATIONCLEARANCE);
			}
			$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
			$group_email->sendMessages();
		} elseif (!$_POST[$validationName] && 
			$cms_user->hasValidationClearance($validationName)) {
			$userEdited->delValidationClearance($validationName);	
			$userEdited->writeToPersistence();
			$alterGroupAction = true;
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$userEdited->getFirstName()." ".$userEdited->getLastName(). " (edit validation clearances)");
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_USER_EDIT_BODY, array($userEdited->getLogin()))
						."\n".$language->getMessage(MESSAGE_EMAIL_USER_EDIT_VALIDATIONCLEARANCE);
			}
			$group_email->setUserMessages(array($userEdited), $bodies, $subjects, ALERT_LEVEL_WARNING);
			$group_email->sendMessages();
		}
	}
	break;
}

//Display
$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE).' : '.$userEdited->getFirstName().' '.$userEdited->getLastName(),'pic_profil.gif');
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
$dialog->addOnglet();
$dialog->setBackLink($backLink);

if ($reloadAll && !$cms_message) {
	 $dialog->reloadAll();
}

if ($_GET["currentOnglet"]) {
	$currentOnglet = $_GET["currentOnglet"];
	$dialog->dontMakeFocus();
} elseif ($_POST["currentOnglet"]) {
	$currentOnglet = $_POST["currentOnglet"];
	$dialog->dontMakeFocus();
} else {
	$currentOnglet ='0';
}

//text editors select menu
$editors = array(	"none" => MESSAGE_PAGE_EDITOR_NONE,
					"richtext" => MESSAGE_PAGE_EDITOR_RICHTEXT,
					"fckeditor" => MESSAGE_PAGE_EDITOR_FCKEDITOR);

$editors_select = '<select class="admin_input_text" name="texteditor">'."\n";
foreach ($editors as $value => $label) {
	$selected = ($userEdited->getTextEditor() == $value) ? ' selected="selected"' : '';
	//to replace applet by fckeditor
	$selected = (!ADMINISTRATION_ALLOW_JAVA_EDITOR && $userEdited->getTextEditor()=="applet" && $value=="fckeditor") ? ' selected="selected"' : $selected;
	$editors_select .= '<option value="'.$value.'"'.$selected.'>'.$cms_language->getMessage($label).'</option>'."\n";
}
$editors_select .= '</select>'."\n";

//Group select option menu
$userGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($userEdited);
$allGroups = CMS_profile_usersGroupsCatalog::getAll();

if (is_array($allGroups) && $allGroups) {
	$groupsNames = $groupDescriptions = array();
	foreach ($allGroups as $group) {
		$groupNames[$group->getGroupId()] = $group->getLabel();
		$groupDescriptions[$group->getGroupId()] = $group->getDescription();
	}
	$groupSelect = CMS_dialog_listboxes::getListBoxes(
		array (
		'field_name' 		=> 'userGroups',			// Hidden field name to get value in
		'items_possible' 	=> $groupNames,				// array of all categories availables: array(ID => label)
		'items_selected' 	=> array_keys($userGroups),	// array of selected ids
		'select_width' 		=> '230px',					// Width of selects, default 200px
		'select_height' 	=> '100px',					// Height of selects, default 140px
		'form_name' 		=> 'frmgroups',				// Javascript form name
		'description' 		=> $groupDescriptions,		// All groups descriptions
		)
	);
}
//if user has groups, some fields must be disabled
$disableFields = (sizeof($userGroups)) ? ' disabled="disabled"':'';
//disable user infos fields if LDAP is active and user has no user edition rights
$disableUserInfosFields = (APPLICATION_LDAP_AUTH && $userEdited->getDN() && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) ? ' disabled="disabled"':'';

//languages option menu
$languages = CMS_languagesCatalog::getAllLanguages();
$languageSelect = '<select class="admin_input_text" name="language">';
$userLanguage = $userEdited->getLanguage();

//Contact Data
$contactData = $userEdited->getContactData();

foreach ($languages as $language) {
	$languageSelect .= '  <option value="'.$language->getCode().'" ';
	if (trim($language->getCode()) == trim($userLanguage->getCode())) {
		$languageSelect .= 'selected="true" ';	
	}
	
	$languageSelect .= '>'.$language->getLabel().'</option>';
}

$languageSelect .= '</select>';

//Base Data
$content = '';
$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "'.$currentOnglet.'");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_BASE_DATA).'", "'.$cms_language->getMessage(MESSAGE_BASE_DATA).'"));';
if (!$superAction) {
	$content .='
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_CONTACT_DATA).'&nbsp;", "'.$cms_language->getMessage(MESSAGE_CONTACT_DATA).'"));
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_RIGHTS).'", "'.$cms_language->getMessage(MESSAGE_RIGHTS).'"));';
	if ($hasAdminClearance) {
		$content .='
		monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_META_RIGHTS).'", "'.$cms_language->getMessage(MESSAGE_META_RIGHTS).'"));';
	}
}
$content .='
</script>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>

<script>monOnglet.displayHeader();</script>
<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
			<form name="coredata" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<tr>
				<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_NAME).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="name" value="'.SensitiveIO::sanitizeHTMLString($userEdited->getFirstName()).'"'.$disableUserInfosFields.' /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_SURNAME).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="surname" value="'.SensitiveIO::sanitizeHTMLString($userEdited->getLastName()).'"'.$disableUserInfosFields.' /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_EMAIL).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="email" value="'.SensitiveIO::sanitizeHTMLString($contactData->getEmail()).'"'.$disableUserInfosFields.' /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_LOGIN).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_text" size="20" name="login" value="'.SensitiveIO::sanitizeHTMLString($userEdited->getLogin()).'"'.($userEdited->getUserId() && $userEdited->getUserId() <= 3 ? ' disabled="disabled"' : '').''.$disableUserInfosFields.' />'.($userEdited->getID() == 1 ? '<input type="hidden" name="login" value="'.SensitiveIO::sanitizeHTMLString($userEdited->getLogin()).'" />' : '').'</td>
			</tr>';
		if (!APPLICATION_LDAP_AUTH) {
			// Local passwords
			if ($userEdited->getUserId() != 3
				&& ($userEdited->getUserId() != 1 || ($userEdited->getUserId() == 1 && $cms_user->getUserId() == 1))) {
				$content .= '
				<tr>
					<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PASSWORD).'</td>
					<td class="admin_onglet_body"><input type="password" class="admin_input_text" size="20" name="pass" value="" /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_CONFIRM_PASSWORD).'</td>
					<td class="admin_onglet_body"><input type="password" class="admin_input_text" size="20" name="pass2" value="" /></td>
				</tr>';
			}
		} else {
			// LDAP DN
			$content .= '
			<tr>
				<td class="admin_onglet_head"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_DISTINGUISHED_NAME).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="dn" value="'.SensitiveIO::sanitizeHTMLString($userEdited->getDN()).'"'.$disableUserInfosFields.' /></td>
			</tr>';
		}
$content .=	  '
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_WORD_LANGUAGE).'</td>
				<td class="admin_onglet_body">'.$languageSelect.'</td>
			</tr>
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_WORD_EDITOR).'</td>
				<td class="admin_onglet_body">'.$editors_select.'</td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				<td class="admin_onglet_body" align="right"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
			</tr>
			'.$postHiddenValues.'
	  		<input type="hidden" name="cms_super_action" value="'.$superAction.'" />
	    	<input type="hidden" name="cms_action" value="changeCoreData" />
			<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
   			</form>
';

if ($superAction) {
	$content .= '
    <form name="coredata" method="post" action="'.PATH_ADMIN_WR.'/profiles_users.php">	
	<tr>
		<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
		<td class="admin_onglet_body" align="right">
			'.$postHiddenValues.'
			<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_CANCEL).'" class="admin_input_submit" />
		</td>
	</tr>
	</form>';
}
$content .= '
	</table>
</div>';
if (!$superAction) {
	$content .= '
	<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">';
	$content .= '
	 	<form name="contactdata" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_JOBTITLE).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="jobtitle" value="'.SensitiveIO::sanitizeHTMLString($contactData->getJobTitle()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_SERVICE).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="service" value="'.SensitiveIO::sanitizeHTMLString($contactData->getService()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PHONE).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="phone" value="'.SensitiveIO::sanitizeHTMLString($contactData->getPhone()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_CELLPHONE).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="cellphone" value="'.SensitiveIO::sanitizeHTMLString($contactData->getCellPhone()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_FAX).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="fax" value="'.SensitiveIO::sanitizeHTMLString($contactData->getFax()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head" rowspan="3">'.$cms_language->getMessage(MESSAGE_ADDRESS).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="address1" value="'.SensitiveIO::sanitizeHTMLString($contactData->getAddressField1()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="address2" value="'.SensitiveIO::sanitizeHTMLString($contactData->getAddressField2()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="address3" value="'.SensitiveIO::sanitizeHTMLString($contactData->getAddressField3()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_ZIP).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="zip" value="'.SensitiveIO::sanitizeHTMLString($contactData->getZip()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_CITY).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="city" value="'.SensitiveIO::sanitizeHTMLString($contactData->getCity()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_STATE).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="state" value="'.SensitiveIO::sanitizeHTMLString($contactData->getState()).'"'.$disableUserInfosFields.' /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_COUNTRY).'</td>
					<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="country" value="'.SensitiveIO::sanitizeHTMLString($contactData->getCountry()).'"'.$disableUserInfosFields.' /></td>
				</tr>';
				if (!$disableUserInfosFields) {
					$content .= '
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
					</tr>';
				}
			$content .= '
			</table>
			'.$postHiddenValues.'
			<input type="hidden" name="cms_action" value="changeContactData" />
			<input type="hidden" name="currentOnglet" value="1" />
			<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
		</form>
	</div>';
	// Display for User administrators only
	if ($hasAdminClearance) {
		$pageClearanceChangeable=false;
		$rowContent ='';
		$content .= '
		<div id="og_monOnglet2" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">';
			if ($groupSelect) {
				$content .= '
				<form name="frmgroups" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_PAGE_GROUPS).' :</b></td>
				</tr>
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" colspan="6">
						'.$groupSelect.'
					</td>
				</tr>
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" align="right" colspan="6">
						<input type="hidden" name="currentOnglet" value="2" />
						<input type="hidden" name="cms_action" value="changeGroups" />
						<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
						'.$postHiddenValues.'
						<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
					</td>
				</tr>
				</form>';
			}
			
		// Module Clearances
		$moduleClearanceChangeable=false;
		$rowContent='';
		$content .='
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_MODULE_RIGHTS).' :</b></td>
				</tr>
				<form  method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>
			';
			
			$moduleClearancesStack = $userEdited->getModuleClearances();
			$moduleClearances = $moduleClearancesStack->getElements();
			
			//Loop through stack and display clearances
			foreach ($moduleClearances as $moduleClearance) {
				// Build menu
				$module = $moduleClearance[0];
				$clearance = $moduleClearance[1];
				$allclearances = CMS_profile::getAllModuleClearances();
				$userModuleNames[] = $module;
				
				//Check current user has a clearance to modify
				if ($cms_user->hasModuleClearance($module, $clearance)) { 
					$options = 0;
					$clearanceSelect = '<input type="hidden" value="'.$clearance.'" name="initClearance_'.$module.'" />';
					foreach ($allclearances as $message=>$allclearance) {
						if ($cms_user->hasModuleClearance($module, $allclearance)) {
							$moduleClearanceChangeable=true;
							$clearanceSelect .= '<td class="admin_onglet_body" align="center"><input type="radio"'.$disableFields.' value="'.$allclearance.'" ';
							if ($allclearance == $clearance) {
								$clearanceSelect .= ' checked="checked" ';
							}
							$clearanceSelect .= ' name="setModuleClearance_'.$module.'" /></td>';
							$options++;
						} else {
							$clearanceSelect .= '<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
						}
					}
					
					//no need to display select if only one
					if ($options == 1) {
						$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
					}
				} else {
					// Cannot change hence display value
					foreach ($allclearances as $message=>$allclearance) {
						if ($allclearance == $clearance) {
							$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
						}
					}
				}
				$moduleObject = new CMS_module($module);
				$moduleName = ($module == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):$moduleObject->getLabel($cms_language);
				// row format
				$rowContent .='
					<tr>
						<td class="admin_onglet_head">'.SensitiveIO::sanitizeHTMLString($moduleName).'</td>
						<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						'.$clearanceSelect.'
						<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						';
				if (!$disableFields) {
					if ($cms_user->hasPageClearance($module, CLEARANCE_MODULE_EDIT)) {
						$moduleClearanceChangeable=true;
						$rowContent .='<td class="admin_onglet_body" align="center"><input type="checkbox"'.$disableFields.' name="removeModule_'.$module.'" value="1" /></td>';
					} else {
						$rowContent .='<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
					}
				}
				$rowContent .='
					</tr>
					<input type="hidden" value="'.$module.'" name="modulesClearance[]" />
				';
			}
		if ($moduleClearanceChangeable) {
			$content .='
				<tr>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="200" /></td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_USER_RIGHTS_MODULES_NONE).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_USER_RIGHTS_MODULES_VIEW).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_USER_RIGHTS_MODULES_EDIT).'</td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
			if (!$disableFields) {
				$content .='
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_MODULE_DELETE).'</td>';
			}
			$content .='
				</tr>';
		}
		$content .=$rowContent;
		if (!$disableFields) {
			if ($moduleClearanceChangeable) {
				$content .='
						<tr>
							<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
							<td class="admin_onglet_body" align="right" colspan="6"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
						</tr>';
			}
				$content .=$postHiddenValues.'
						<input type="hidden" name="cms_action" value="setModuleClearance" />
						<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
						<input type="hidden" name="currentOnglet" value="2" />
						</form>';
						
			//Module Clearance Add Form
			//Loop through and put in those that the user doesnt have....
			$otherModuleSelect = '<select class="admin_input_text" name="othermodules">';
					  
				$allModules = CMS_modulesCatalog::getAll();
				$modulesRemaining = 0;
					  
				// Create pulldown menu
				foreach ($allModules as $aModule) {
					if (!SensitiveIO::isInSet($aModule->getCodeName(), $userModuleNames)) {
						$moduleName = ($aModule->getCodeName() == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):$aModule->getLabel($cms_language);
						$otherModuleSelect .='<option value="'.$aModule->getCodeName().'">'.$moduleName.'</option>';	  
						$modulesRemaining++;
					}
				}
					  
			$otherModuleSelect .= '</select>';
			
			if ($modulesRemaining > 0) {
				$content .='
						<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>
						<tr>
							<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
							<td class="admin_onglet_body" align="right" colspan="6">
								<input type="hidden" name="cms_action" value="addModuleClearance" />
								<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
								<input type="hidden" name="currentOnglet" value="2" />
								'.$postHiddenValues.'
								'.$otherModuleSelect.' <input type="submit" value="'.$cms_language->getMessage(MESSAGE_ADD).'" class="admin_input_submit" />
							</td>
						</tr>
						</form>';
			}
		} else {
			$content .='</form>';
		}
		
		// Module access
		$moduleCtgsRows = '';
		$allModules = CMS_modulesCatalog::getAll();
		foreach ($allModules as $aModule) {
			if (/*$userEdited->hasModuleClearance($aModule->getCodeName(), CLEARANCE_MODULE_VIEW) &&*/ ($aModule->useCategories() || $aModule->getCodeName() == MOD_STANDARD_CODENAME)) {
				$moduleCtgsRows .= ' :: <a href="modulecategories_usersgroup.php?module='.$aModule->getCodeName().'&user='.$userEdited->getUserId().'&backlink='.urlencode($_SERVER["SCRIPT_NAME"].'?userId='.$userEdited->getUserId().'&currentOnglet=2').'" class="admin">'.$aModule->getLabel($cms_language).'</a> ';
			}
		}
		if ($moduleCtgsRows != '') {
			$content .= '
			<tr>
				<td class="admin_onglet_head_top" colspan="7">
					<b>'.(!$disableFields ? $cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULES_ACCESS) : $cms_language->getMessage(MESSAGE_PAGE_TITLE_VIEW_MODULES_ACCESS)).' :</b>
				</td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				<td class="admin_onglet_body" colspan="6">
					'.substr($moduleCtgsRows, 4).'
				</td>
			</tr>';
		}
		
		// Validation Clearances
		if (sizeof($userModuleNames)) {
			$validationRows = '';
			foreach ($userModuleNames as $validationName) {
				if ($cms_user->hasValidationClearance($validationName)) {
					$moduleObject = new CMS_module($validationName);
					$moduleName = ($validationName == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):$moduleObject->getLabel($cms_language);
					$checked = ($userEdited->hasValidationClearance($validationName)) ? 'checked="true"' : '';
					$disabled = ($disableFields || $userEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
					$validationRows .= '<label for="validation_'.$validationName.'"><input type="checkbox" id="validation_'.$validationName.'" name="'.$validationName.'" '.$checked.$disabled.' />'.$moduleName.'</label> ';
				}
			}
			if ($validationRows) {
				$content .= '
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_VALIDATION_RIGHTS).' :</b></td>
				</tr>
				<form name="templategroups" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" colspan="6">'.$validationRows.'</td>
				</tr>';
				if (!$disableFields && !$userEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
					$content .= '
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6">
							<input type="hidden" name="currentOnglet" value="2" />
							'.$postHiddenValues.'
							<input type="hidden" name="cms_action" value="changeValidation" />
							<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
					  		<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
						</td>
					</tr>';
				}
				$content .= '</form>';
			}
		}
		//TEMPLATES / ROWS
		$templategroups = CMS_pageTemplatesCatalog::getAllGroups();
		$rowsgroups = CMS_rowsCatalog::getAllGroups();
		//Create templates checkboxes
		foreach ($templategroups as $templategroup) {
			// Check if in template groups denied
			$checked = (!$userEdited->hasTemplateGroupsDenied($templategroup)) ? 'checked="true"' : '';
			$disabled = ($disableFields || $userEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$templatesCheckboxes .= '<label for="groupTemplate_'.$templategroup.'"><input type="checkbox" name="groupTemplate_'.$templategroup.'" id="groupTemplate_'.$templategroup.'" '.$checked.$disabled.' /> '.$templategroup.'</label> ';
		}
		//Create rows checkboxes
		foreach ($rowsgroups as $rowgroup) {
			// Check if in row groups denied
			$checked = (!$userEdited->hasRowGroupsDenied($rowgroup)) ? 'checked="true"' : '';
			$disabled = ($disableFields || $userEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$rowsCheckboxes .= '<label for="groupRow_'.$rowgroup.'"><input type="checkbox" name="groupRow_'.$rowgroup.'" id="groupRow_'.$rowgroup.'" '.$checked.$disabled.' /> '.$rowgroup.'</label> ';
		}
		if ($templatesCheckboxes || $rowsCheckboxes) {
			$content .= '
			<form name="authorisationsForm" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>	
			<tr>
				<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_TEMPLATESROWS_HEADING).' :</b></td>
			</tr>';
			if ($templatesCheckboxes) {
				$content .= '
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_TEMPLATES_HEADING).'</td>
					<td class="admin_onglet_body" colspan="6">
					'.$templatesCheckboxes.'
					</td>
				</tr>';
			}
			if ($rowsCheckboxes) {
				$content .= '
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_ROWS_HEADING).'</td>
					<td class="admin_onglet_body" colspan="6">
					'.$rowsCheckboxes.'
					</td>
				</tr>';
			}
			if (!$disableFields && !$userEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$content .= '
				<tr>
					<td class="admin_onglet_head">&nbsp;</td>
					<td class="admin_onglet_body" colspan="6">
						<div style="text-align:right;">
						<input type="hidden" name="currentOnglet" value="2" />
						'.$postHiddenValues.'
						<input type="hidden" name="cms_action" value="changeTemplateRowGroup" />
						<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
						<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
						</div>
					</td>
				</tr>';
			}
			$content .= '
			</form>';
		}
		// Alert level select menu
		$content .= '	
		<tr>
			<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).' :</b></td>
		</tr>';
		
		$alerts = CMS_profile::getAllAlertLevels();
		$alertSelect = '<select class="admin_input_text" name="alert"'.$disableFields.'>';
		
		foreach ($alerts as $message=>$alert) {
			$alertSelect .= '  <option value="'.$alert.'" ';
			if ($alert == $userEdited->getAlertLevel()) {
				$alertSelect .= 'selected="true" ';	
			}
			$alertSelect .= '>'.$cms_language->getMessage($message).'</option>';
		}
		
		$alertSelect .= '</select>';
		
		// Alert Level display
		$content .= '
			<form name="messagelevel" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>  
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_LEVEL).'</td>
				<td class="admin_onglet_body" colspan="6">'.$alertSelect.'</td>
			</tr>';
			if (!$disableFields) {
				$content .= '
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" align="right" colspan="6">
						<input type="hidden" name="currentOnglet" value="2" />
						<input type="hidden" name="cms_action" value="changeAlertLevel" />
						<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
						'.$postHiddenValues.'
						<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
					</td>
				</tr>';
			}
			$content .= '
			</form>
		</table><br />
		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td class="admin">
					<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_TEMPLATES_HEADING).' & '.$cms_language->getMessage(MESSAGE_ROWS_HEADING).'</dialog-title>
					<br />
					'.$cms_language->getMessage(MESSAGE_TEMPLATE_DESCRIPTION).'
					<br /><br />
					'.$cms_language->getMessage(MESSAGE_TEMPLATE_INSTRUCTION).'
					<br /><br />
					<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).'</dialog-title>
					<br />
					'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_DESCRIPTION).'
				</td>
			</tr>
		</table>
	</div>
	
	<div id="og_monOnglet3" style="DISPLAY: none;top:0px;left:0px;width:100%;">';
		// Admin clearance rows
		$admins = CMS_profile::getAllAdminClearances();
		
		$adminRows = '';
		foreach ($admins as $message=>$admin) {
			if ($cms_user->hasAdminClearance($admin)) {
				$checked = ($userEdited->hasAdminClearance($admin)) ? 'checked="true"' : '';
				$adminRows .= '
					<tr>
					  <td class="admin_onglet_head">'.$cms_language->getMessage($message).'</td>
					  <td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="480" /><br /><input type="checkbox" name="'.$admin.'" '.$checked.(($userEdited->getID() == 1 || $disableFields) ? ' disabled="disabled"':'').' /></td>
					</tr>';
			}
		}
		if ($adminRows) {
			$content .= '
			<form name="templategroups" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>'.$adminRows;
				if ($userEdited->getID() != 1 && !$disableFields) {
					$content .= '
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
					</tr>';
				}
			$content .= '
			</table>
			'.$postHiddenValues.'
			<input type="hidden" name="currentOnglet" value="3" />
			<input type="hidden" name="cms_action" value="changeAdminClearance" />
			<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
			</form>
			';
		}
	$content .= '
	</div>';
	} else {
		$content .= '
		<div id="og_monOnglet2" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
			<tr>
				<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).' :</b></td>
			</tr>';
			
			$alerts = CMS_profile::getAllAlertLevels();
			$alertSelect = '<select class="admin_input_text" name="alert"'.$disableFields.'>';
			
			foreach ($alerts as $message => $alert) {
				$alertSelect .= '  <option value="'.$alert.'" ';
				if ($alert == $userEdited->getAlertLevel()) {
					$alertSelect .= 'selected="true" ';	
				}
				$alertSelect .= '>'.$cms_language->getMessage($message).'</option>';
			}
			
			$alertSelect .= '</select>';
			
			// Alert Level display
			$content .= '
				<form name="messagelevel" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>  
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_LEVEL).'</td>
					<td class="admin_onglet_body" colspan="6">'.$alertSelect.'</td>
				</tr>';
				if (!$disableFields) {
					$content .= '
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6">
							<input type="hidden" name="currentOnglet" value="2" />
							<input type="hidden" name="cms_action" value="changeAlertLevel" />
							<input type="hidden" name="userId" value="'.$userEdited->getUserId().'" />
							'.$postHiddenValues.'
							<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
						</td>
					</tr>';
				}
				$content .= '
				</form>
			</table><br />
			<table border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td class="admin">
						<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).'</dialog-title>
						<br />
						'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_DESCRIPTION).'
					</td>
				</tr>
			</table>
		</div>';
	}
}
$content .= '
<script>monOnglet.displayFooter();</script>
		</td>
	</tr>
</table>
';

$dialog->setContent($content);
$dialog->show();
?>