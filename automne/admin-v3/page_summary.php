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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: page_summary.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page summary
  * Presents the summary of a page, with all possible actions.
  *
  * @package CMS
  * @subpackage admin
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1075);
define("MESSAGE_PAGE_TITLE_CREATION", 130);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_UNKNOWN_PAGE", 66);
define("MESSAGE_PAGE_INFO_ID", 70);
define("MESSAGE_PAGE_INFO_PUBLICATION", 71);
define("MESSAGE_PAGE_INFO_TEMPLATE", 72);
define("MESSAGE_PAGE_INFO_WEBSITE", 824);
define("MESSAGE_PAGE_ACTION_CANCEL_EDITIONS", 857);
define("MESSAGE_PAGE_ACTION_CANCEL_EDITIONS_CONFIRM", 858);
define("MESSAGE_PAGE_ACTION_VIEW", 78);
define("MESSAGE_PAGE_ACTION_PREVIEW", 79);
define("MESSAGE_PAGE_ACTION_ONLINE", 80);
define("MESSAGE_PAGE_ACTION_OTHER", 81);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_ARCHIVE", 83);
define("MESSAGE_PAGE_ACTION_ARCHIVECONFIRM", 119);
define("MESSAGE_PAGE_ACTION_DELETE", 84);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 118);
define("MESSAGE_PAGE_ACTION_UNDELETE", 85);
define("MESSAGE_PAGE_ACTION_UNDELETECONFIRM", 97);
define("MESSAGE_PAGE_ACTION_UNARCHIVE", 86);
define("MESSAGE_PAGE_ACTION_UNARCHIVECONFIRM", 98);
define("MESSAGE_PAGE_ACTION_EDIT", 87);
define("MESSAGE_PAGE_ACTION_BASEDATA", 88);
define("MESSAGE_PAGE_ACTION_CONTENT", 89);
define("MESSAGE_PAGE_ACTION_CREATE", 90);
define("MESSAGE_PAGE_ACTION_SIBLING", 91);
define("MESSAGE_PAGE_ACTION_DISPLACE", 92);
define("MESSAGE_PAGE_ACTION_DISPLACE_TITLE", 100);
define("MESSAGE_PAGE_ACTION_DISPLACE_HEADING", 101);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_ACTION_UNDELETE_ERROR", 126);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT", 123);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY", 125);
define("MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_SUBJECT", 127);
define("MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_BODY", 128);
define("MESSAGE_PAGE_SIBLINGS", 159);
define("MESSAGE_PAGE_SIBLINGS_STATUS", 160);
define("MESSAGE_PAGE_SIBLINGS_TITLE", 161);
define("MESSAGE_PAGE_SIBLINGS_ACTIONS", 162);
define("MESSAGE_SUBPAGE", 163);
define("MESSAGE_PAGE_SIBLINGS_ORDER_UP", 164);
define("MESSAGE_PAGE_SIBLINGS_ORDER_DOWN", 165);
define("MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR", 166);
define("MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_SUBJECT", 170);
define("MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_BODY", 171);
define("MESSAGE_PAGE_ACTION_COPY", 1046);
define("MESSAGE_PAGE_LOGS", 29);
define("MESSAGE_PAGE_LOGS_ACTION", 910);
define("MESSAGE_PAGE_ACTION_BY", 1074);
define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_PAGE_CREATE_TITLE", 1085);
define("MESSAGE_PAGE_ACTION_RETURN_PROPERTIES", 1086);
define("MESSAGE_PAGE_TITLE_CREATION_UNDER", 1087);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_FIELD_LINKTITLE", 133);
define("MESSAGE_PAGE_FIELD_LINKTITLE_COMMENT", 147);
define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_PAGE_FIELD_DATE_COMMENT", 148);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_PAGE_FIELD_REMINDERDELAY", 136);
define("MESSAGE_PAGE_FIELD_REMINDERDELAY_COMMENT", 150);
define("MESSAGE_PAGE_FIELD_REMINDERDATE", 137);
define("MESSAGE_PAGE_FIELD_REMINDERMESSAGE", 138);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_DESCRIPTION_COMMENT", 149);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 140);
define("MESSAGE_PAGE_TITLE_BASEDATAS", 88);
define("MESSAGE_PAGE_TITLE_METATAGS", 1043);
define("MESSAGE_PAGE_TITLE_COMMONMETATAGS", 1041);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_FIELD_AUTHOR", 1033);
define("MESSAGE_PAGE_FIELD_REPLYTO", 1034);
define("MESSAGE_PAGE_FIELD_COPYRIGHT", 1035);
define("MESSAGE_PAGE_FIELD_LANGUAGE", 1036);
define("MESSAGE_PAGE_FIELD_ROBOTS", 1037);
define("MESSAGE_PAGE_FIELD_ROBOTS_COMMENT", 1042);
define("MESSAGE_PAGE_FIELD_PRAGMA", 1038);
define("MESSAGE_PAGE_FIELD_PRAGMA_COMMENTS", 1040);
define("MESSAGE_PAGE_FIELD_REFRESH", 1039);
define("MESSAGE_PAGE_FIELD_WEBSITE", 1076);
define("MESSAGE_PAGE_FIELD_PRINT", 1077);
define("MESSAGE_PAGE_TAB_IDENTITY", 1078);
define("MESSAGE_PAGE_TAB_DATESALERTS", 1079);
define("MESSAGE_PAGE_TAB_SEARCHENGINES", 1080);
define("MESSAGE_PAGE_TAB_METATAGS", 1081);
define("MESSAGE_PAGE_FIELD_REFRESH_COMMENT", 1084);
define("MESSAGE_PAGE_ACTION_UNDOCONFIRM", 1097);
define("MESSAGE_PAGE_URL", 1099);
define("MESSAGE_SUBPAGE_ORDER", 1115);
define("MESSAGE_PAGE_ACTION_EMAIL_SUBJECT", 172);
define("MESSAGE_PAGE_ACTION_EMAIL_BODY", 173);
define("MESSAGE_PAGE_ACTION_ROW_CONTENT", 1130);
define("MESSAGE_PAGE_SAVE_NEWORDER", 1183);
define("MESSAGE_PAGE_ACTION_DATE", 1284);
define("MESSAGE_PAGE_FIELD_MATCHING_TEMPLATES", 1299);
define("MESSAGE_PAGE_FIELD_UNMATCHING_TEMPLATES", 1300);
define("MESSAGE_PAGE_ACTION_UNMATCHING_TEMPLATES_USE", 1301);
define("MESSAGE_PAGE_FIELD_TO", 1302);
define("MESSAGE_PAGE_FIELD_PAGE", 1303);
define("MESSAGE_PAGE_ACTION_NO_TEMPLATES_RIGHTS", 1311);
define("MESSAGE_PAGE_ACTION_NO_PAGE_CREATION", 1312);
define("MESSAGE_PAGE_FIELD_FORCEURLREFRESH_COMMENT", 1317);
define("MESSAGE_PAGE_FIELD_FORCEURLREFRESH_CONFIRM", 1318);
define("MESSAGE_PAGE_LINKS_RELATIONS", 1405);
define('MESSAGE_PAGE_RESULTS_RELATIONS', 1417);
define('MESSAGE_PAGE_RESULTS_LINKS', 1418);
define('MESSAGE_PAGE_WARNING_DELETION',1414);
define('MESSAGE_PAGE_CHOOSE', 1132);
define("MESSAGE_PAGE_ACTION_SUBMIT_FOR_VALIDATION", 1422);
define("MESSAGE_PAGE_ACTION_ACTIONS", 181);
define("MESSAGE_PAGE_CANCEL_DRAFT_CONFIRM", 1425);
define("MESSAGE_PAGE_ACTION_CANCEL_DRAFT", 1424);
define("MESSAGE_PAGE_ACTION_DRAFT_PREVIEW", 1426);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_SUBJECT", 182);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_BODY", 183);
define("MESSAGE_PAGE_ACTION_DRAFT", 1422);
//use mode can be "view", "edition" for base data simple editing or "creation" for page creation.
//this value is passed as a parameter to all pages view/edition/creation process

$use_mode = ($_POST["use_mode"]) ? $_POST["use_mode"] : $_GET["use_mode"];
$use_mode = (!$use_mode) ? "view":$use_mode;
$action_page = ($_POST["action_page"]) ? $_POST["action_page"]: $_GET["action_page"];
$cms_action = ($_POST["cms_action"]) ? $_POST["cms_action"]: $_GET["cms_action"];

//add a special redirection clause so some modules can create page then return to the module administration
if (is_array($cms_context->getSessionVar("redir")) && sizeof($cms_context->getSessionVar("redir")) && strpos($_SERVER["HTTP_REFERER"], "frames.php") !== false) {
	$redirParam = $cms_context->getSessionVar("redir");
	if ($redirParam["location"]) {
		$redirString = '';
		$count=0;
		foreach ($redirParam as $paramName => $paramValue) {
			if ($paramName != "location") {
				if ($paramValue == '{{pageID}}') {
					$cms_page = $cms_context->getPage();
					$paramValue = $cms_page->getID();
					$redirParam[$paramName] = $paramValue;
					$cms_context->setSessionVar("redir",$redirParam);
				}
				
				$redirString .= ($count) ? '&'.$paramName.'='.$paramValue:$paramName.'='.$paramValue;
				$count++;
			}
		}
		header("Location: ".$redirParam["location"]."?".$redirString);
		exit;
	}
}
//set redir session var if any
if(is_array($_REQUEST['redir'])) {
	$cms_context->setSessionVar("redir",$_REQUEST['redir']);
}

// ****************************************************************
// ** PAGE CLEARANCE CHECKS / REGISTRATION                       **
// ****************************************************************

switch ($use_mode) {
	case "edition":
		//RIGHTS CHECK
		if ($_REQUEST["page"] && $cms_context->getPageID() != $_REQUEST["page"]) {
			$cms_page = CMS_tree::getPageByID($_REQUEST["page"]);
			$cms_context->setPage($cms_page);
		} else {
			$cms_page =& $cms_context->getPage();
		}
		if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
			Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
			exit;
		} elseif (!$cms_action) {
			//put a lock on the page or redirect to previous page if already locked
			if ($cms_page->getLock()) {
				Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_PAGE_LOCKED."&".session_name()."=".session_id());
				exit;
			} else {
				if ($use_mode != "creation") {
					$cms_page->lock($cms_user);
				}
			}
		}
		$siblings = CMS_tree::getSiblings($cms_page);
	break;
	case "creation":
		//RIGHTS CHECK
		$cms_page = $cms_context->getPage();
		if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT) || !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
			Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
			exit;
		}
		//check for templates rights
		$useableTemplates = CMS_pageTemplatesCatalog::getAvailableTemplatesForUser($cms_user);
		if (!sizeof($useableTemplates)) {
			Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_PAGE_ACTION_NO_PAGE_CREATION."&".session_name()."=".session_id());
			exit;
		}
		if (SensitiveIO::isPositiveInteger($action_page)) {
			$cms_father = CMS_tree::getPageByID($action_page);
		}
		$cms_page = new CMS_page();
	break;
	case 'view':
	default:
		if ($_REQUEST["page"]) {
			$cms_page = CMS_tree::getPageByID($_REQUEST["page"]);
			if ($cms_page->hasError()) {
				header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_UNKNOWN_PAGE."&".session_name()."=".session_id());
				exit;
			}
			if (!$cms_user->hasPageClearance($_REQUEST["page"], CLEARANCE_PAGE_VIEW)) {
				header("Location: ".PATH_ADMIN_SPECIAL_LOGIN_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
				exit;
			}
			
			if ($cms_context->getPageID() != $_REQUEST["page"]) {
				$cms_context->setPage($cms_page);
			}
		} else {
			$cms_page = $cms_context->getPage();
			
			if (!$cms_page) {
				header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_UNKNOWN_PAGE."&".session_name()."=".session_id());
				exit;
			}
			if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
				header("Location: ".PATH_ADMIN_SPECIAL_LOGIN_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
				exit;
			}
		}
		$siblings = CMS_tree::getSiblings($cms_page);
	break;
}
// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($cms_action) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$cms_page->setDebug(false);
	if (!$_POST["title"] || (!$_POST["linktitle"] && $use_mode=='edition')) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		$cms_page->setTitle($_POST["title"], $cms_user);
		if ($use_mode=='edition' || $_POST["linktitle"]) {
			$cms_page->setLinkTitle($_POST["linktitle"], $cms_user);
		} else {
			$cms_page->setLinkTitle($_POST["title"], $cms_user);
		}
	}
	$cms_page->setRefreshUrl($_POST["forcePageURLRefresh"], $cms_user);
	$dt_beg = new CMS_date();
	$dt_beg->setDebug(false);
	$dt_beg->setFormat($cms_language->getDateFormat());
	$dt_end = new CMS_date();
	$dt_end->setDebug(false);
	$dt_end->setFormat($cms_language->getDateFormat());
	if (!$dt_beg->setLocalizedDate($_POST["pub_start"], true)) {
		if ($dt_beg->isNull()) {
			$dt_beg->setNow();
		}
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
	} elseif (!$dt_end->setLocalizedDate($_POST["pub_end"], true)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
	} else {
		$cms_page->setPublicationDates($dt_beg, $dt_end);
	}
	if (!$_POST["reminder"]) {
		$_POST["reminder"] = 0;
	}
	if (!$cms_page->setReminderPeriodicity($_POST["reminder"], $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY)));
	}
	$dt_remind = new CMS_date();
	$dt_remind->setDebug(false);
	$dt_remind->setFormat($cms_language->getDateFormat());
	if ($_POST["reminder_on"] && !$dt_remind->setLocalizedDate($_POST["reminder_on"], true)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDATE)));
	} else {
		$cms_page->setReminderOn($dt_remind, $cms_user);
	}
	if (!$cms_page->setReminderOnMessage($_POST["reminder_on_message"], $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERMESSAGE)));
	}
	
	if (!$cms_page->setPragma(str_replace('"',"", $_POST["pragma"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PRAGMA)));
	}
	if (!$cms_page->setRefresh(str_replace('"',"", $_POST["refresh"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REFRESH)));
	}
	
	// All referencing meta tags, careful to " in attributes
	if (!$cms_page->setDescription(str_replace('"',"", $_POST["description"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)));
	}
	if (!$cms_page->setKeywords(str_replace('"',"", $_POST["keywords"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS)));
	}
	if (!$cms_page->setCategory(str_replace('"',"", $_POST["category"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY)));
	}
	if (!$cms_page->setRobots(str_replace('"',"", $_POST["robots"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_ROBOTS)));
	}
	if (!NO_PAGES_EXTENDED_META_TAGS) {
		if (!$cms_page->setAuthor(str_replace('"',"", $_POST["author"]), $cms_user)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_AUTHOR)));
		}
		if (!$cms_page->setReplyto(str_replace('"',"", $_POST["replyto"]), $cms_user)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REPLYTO)));
		}
		if (!$cms_page->setCopyright(str_replace('"',"", $_POST["copyright"]), $cms_user)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_COPYRIGHT)));
		}
	}
	if (!$cms_page->setLanguage(str_replace('"',"", $_POST["language"]), $cms_user)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_LANGUAGE)));
	}
	
	
	//template change
	if ($_POST["templateReplacement"]) {
		$tpl_original = $cms_page->getTemplate();
		//hack if page has no valid template attached
		if (!is_a($tpl_original, "CMS_pageTemplate")) {
			$tpl_original = new CMS_pageTemplate();
		}
		$tpl = new CMS_pageTemplate($_POST["templateReplacement"]);
		
		$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $tpl_original->getID());
		$cms_page->setTemplate($tpl_copy->getID());
		//destroy old template only if it's a copy
		if ($tpl_original->isPrivate()) {
			$tpl_original->destroy();
		}
	}
	//redirection
	$redirectlinkDialog = new CMS_dialog_href($cms_page->getRedirectLink());
	$redirectlinkDialog->doPost(MOD_STANDARD_CODENAME, $cms_page->getID());
	$cms_page->setRedirectLink($redirectlinkDialog->getHref(),$cms_user);
	
	$cms_page->setDebug(SYSTEM_DEBUG);
	
	if (!$cms_message) {
		//save the page data
		$cms_page->writeToPersistence();
		
		switch ($use_mode) {
		case "edition":
			//unlock page, send emails and redirect to summary
			$cms_page->unlock();
			
			if (APPLICATION_ENFORCES_WORKFLOW) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
							."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFirstName()." ".$cms_user->getLastName()." (".$cms_user->getEmail().")"));
				}
				$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
				$validators = array();
				foreach ($potentialValidators as $aPotentialValidator) {
					if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
						$validators[]=$aPotentialValidator;
					}
				}
				$group_email->setUserMessages($validators, $bodies, $subjects);
				$group_email->sendMessages();
			} else {
				$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_BASEDATA, $cms_page);
				$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
				$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			}
			
			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
			
			header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
			exit;
			break;
		case "creation":
			//must set the lastReminder to today
			$cms_page->touchLastReminder();
			$cms_page->writeToPersistence();
			$cms_father = $cms_context->getPage();
			//create page, lock it, attach it to the tree and redirect to template selection
			CMS_tree::attachPageToTree($cms_page, $cms_father, false);
			$cms_context->setPage($cms_page);
			$cms_page = $cms_context->getPage();
			$cms_page->lock($cms_user);
			
			header("Location: page_template.php?father=".$cms_father->getID()."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
			exit;
			break;
		}
	}
	break;
case "page_del":
	//change the page proposed location and send emails to all the validators
	$pg = CMS_tree::getPageByID($action_page);
	if ($pg->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user)) {
		$pg->writeToPersistence();
		$cms_page = $cms_context->getPage();
		
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "", $pg);
		
		if (APPLICATION_ENFORCES_WORKFLOW) {
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
						."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY, array($pg->getTitle().' (ID : '.$pg->getID().')', $cms_user->getFirstName()." ".$cms_user->getLastName()));
			}
			$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
			$validators = array();
			foreach ($potentialValidators as $aPotentialValidator) {
				if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
					$validators[]=$aPotentialValidator;
				}
			}
			$group_email->setUserMessages($validators, $bodies, $subjects);
			$group_email->sendMessages();
		} else {
			$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_LOCATION, $pg);
			$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
			$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			
			//redirect to entry page, this page doesn't exists
			$_SESSION["context"]->_pageID = false;
			Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
			exit;
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
    $siblings = CMS_tree::getSiblings($cms_page);
	break;
case "page_archive":
	//change the page proposed location and send emails to all the validators
	$pg = CMS_tree::getPageByID($action_page);
	if ($pg->setProposedLocation(RESOURCE_LOCATION_ARCHIVED, $cms_user)) {
		$pg->writeToPersistence();
		$cms_page = $cms_context->getPage();
		
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_ARCHIVE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "", $pg);
		
		if (APPLICATION_ENFORCES_WORKFLOW) {
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
						."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_BODY, array($pg->getTitle().' (ID : '.$pg->getID().')', $cms_user->getFirstName()." ".$cms_user->getLastName()));
			}
			$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
			$validators = array();
			foreach ($potentialValidators as $aPotentialValidator) {
				if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
					$validators[]=$aPotentialValidator;
				}
			}
			$group_email->setUserMessages($validators, $bodies, $subjects);
			$group_email->sendMessages();
		} else {
			$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_LOCATION, $pg);
			$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
			$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			
			//redirect to entry page, this page doesn't exists
			$_SESSION["context"]->_pageID = false;
			Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
			exit;
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
    $siblings = CMS_tree::getSiblings($cms_page);
	break;
case "page_unarchive":
	$pg = CMS_tree::getPageByID($action_page);
	$pg->removeProposedLocation();
	$pg->writeToPersistence();
	$cms_page = $cms_context->getPage();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "", $pg);
    $siblings = CMS_tree::getSiblings($cms_page);
	break;
case "page_undel":
	$pg = CMS_tree::getPageByID($action_page);
	$pg->removeProposedLocation();
	$pg->writeToPersistence();
	$cms_page = $cms_context->getPage();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNDELETE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "", $pg);
    $siblings = CMS_tree::getSiblings($cms_page);
	break;
case "page_unEditBaseData":
	$cms_page->unlock();
	break;
case "page_unlock":
	$cms_page->unlock();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "change_order":
	if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
		//construct array of new pages order and check user right on all pages
		$newPagesOrder = array();
		$tmpPagesOrder = explode(',',$_POST["new_order"]);
		if (sizeof($tmpPagesOrder)) {
			$userHaveRight=true;
			foreach ($tmpPagesOrder as $tmpPage) {
				if (substr($tmpPage,0,1)=='p') {
					if ($cms_user->hasPageClearance(substr($tmpPage,1), CLEARANCE_PAGE_EDIT)) {
						$newPagesOrder[] = substr($tmpPage,1);
					} else {
						$userHaveRight=false;
					}
				}
			}
		}
		if (!$userHaveRight || !sizeof($newPagesOrder)) {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR);
			break;
		}
		if (CMS_tree::changePagesOrder($newPagesOrder, $cms_user)) {
			if (APPLICATION_ENFORCES_WORKFLOW) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
							."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFirstName()." ".$cms_user->getLastName()));
				}
				$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
				$validators = array();
				foreach ($potentialValidators as $aPotentialValidator) {
					if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
						$validators[]=$aPotentialValidator;
					}
				}
				$group_email->setUserMessages($validators, $bodies, $subjects);
				$group_email->sendMessages();
			} else {
				$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_SIBLINGSORDER, $cms_page);
				$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
				$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			}
			
			//must "reload" $cms_page
			$cms_page = $cms_context->getPage();
			$siblings = CMS_tree::getSiblings($cms_page);
			
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			
			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR);
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR);
	}
	break;
case "prepare_row_edition":
	$viewWhat = "row";
case "prepare_content_edition":
	if (!$cms_page->isDraft()) {
		//must copy data from edited to edition
		$tpl = $cms_page->getTemplate();
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
	}
	header("Location: ".PATH_ADMIN_SPECIAL_OUT_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?viewWhat=".$viewWhat)."&".session_name()."=".session_id());
	exit;
case "page_cancel_editions":
	// Copy clientspaces and data from public to edited tables
	$tpl = $cms_page->getTemplate();
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
	
	$cms_page->cancelAllEditions();
	$cms_page->writeToPersistence();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	break;
case "page_cancel_draft":
	//delete draft datas
	$tpl = $cms_page->getTemplate();
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	break;
case "submit_for_validation":
	//augment the execution time, because things here can be quite lengthy
	@set_time_limit(9000);
	//ignore user abort to avoid interuption of process
	@ignore_user_abort(true);
	$tpl = $cms_page->getTemplate();
	//put draft datas into edited
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true);
	//change page editions (add CONTENT), move data from _edition to _edited and unlock the page
	$cms_page->addEdition(RESOURCE_EDITION_CONTENT, $cms_user);
	$cms_page->writeToPersistence();
	//delete draft datas
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	
	if (APPLICATION_ENFORCES_WORKFLOW) {
		$group_email = new CMS_emailsCatalog();
		$languages = CMS_languagesCatalog::getAllLanguages();
		$subjects = array();
		$bodies = array();
		foreach ($languages as $language) {
			$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_CONTENT_SUBJECT);
			$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
					."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_CONTENT_BODY, array($cms_user->getFirstName()." ".$cms_user->getLastName()." (".$cms_user->getEmail().")", $cms_page->getTitle().' (ID : '.$cms_page->getID().')'));
		}
		$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
		$validators = array();
		foreach ($potentialValidators as $aPotentialValidator) {
			if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
				$validators[]=$aPotentialValidator;
			}
		}
		$group_email->setUserMessages($validators, $bodies, $subjects);
		$group_email->sendMessages();
	} else {
		$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_CONTENT + RESOURCE_EDITION_BASEDATA, $cms_page);
		$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
		$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
	}
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	//$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	break;
}

//occasional unlocking
if ($_GET["unlock_page"]) {
	if ($cms_page->getLock() == $cms_user->getUserID()) {
		$cms_page->unlock();
	}
}

//get page status
$status = $cms_page->getStatus();

$dialog = new CMS_dialog();
$content = '';
switch ($use_mode) {
	case "edition":
		$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
		$pageTitle = (PAGE_LINK_NAME_IN_TREE) ? $cms_page->getLinkTitle():$cms_page->getTitle();
		$content .='<dialog-title type="admin_h2" picto="'.base64_encode($status->getHTML(false,$cms_user,MOD_STANDARD_CODENAME,$cms_page->getID())).'">'.$pageTitle.'</dialog-title>';
		//add calendar javascript
		$dialog->addCalendar();
	break;
	case "creation":
		$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_CREATION, array("1")));
		$content .='<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_TAB_IDENTITY).'</dialog-title>';
		$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR);
		//add calendar javascript
		$dialog->addCalendar();
	break;
	default:
	case "view":
		$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
		$pageTitle = (PAGE_LINK_NAME_IN_TREE) ? $cms_page->getLinkTitle():$cms_page->getTitle();
		$content .='<dialog-title type="admin_h2" picto="'.base64_encode($status->getHTML(false,$cms_user,MOD_STANDARD_CODENAME,$cms_page->getID())).'">'.$pageTitle.'</dialog-title>';
	break;
}

$dialog->reloadTree();
$dialog->addOnglet();

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($use_mode!='creation') {
	// ****************************************************************
	// ** LINEAGE TITLE                                              **
	// ****************************************************************
	$lineage = CMS_tree::getLineage($cms_user->getPageClearanceRoot($cms_page->getID()), $cms_page);
	
	$lineage_title = '<br /><table border="0" cellpadding="0" cellspacing="0"><tr>';
	
	if (is_array($lineage) && sizeof($lineage)) {
		foreach ($lineage as $ancestor) {
			$ancestorTitle = (PAGE_LINK_NAME_IN_TREE) ? $ancestor->getLinkTitle():$ancestor->getTitle();
			if ($ancestor->getID() != $cms_page->getID()) {
				$lineage_title .= '
					<td class="admin"><nobr>&nbsp;/&nbsp;<a href="'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?page='.$ancestor->getID().'" class="admin">'.htmlspecialchars($ancestorTitle).'</a></nobr></td>
				';
			} else {
				$lineage_title .= '<td class="admin">&nbsp;/&nbsp;'.htmlspecialchars($ancestorTitle).'</td>';
			}
		}
	}
	$lineage_title .= '
		</tr>
		</table><br /><br />
	';
	
	$content .= $lineage_title;
} else {
	$content .= '<br /><br />';
}

// ****************************************************************
// ** INFORMATION LINE                                           **
// ****************************************************************
if ($use_mode=='creation') {
	$template =  new CMS_pageTemplate();
	$website =  CMS_tree::getPageWebsite($cms_father);
} else {
	$template = $cms_page->getTemplate();
	if (!is_a($template, "CMS_pageTemplate")) {
		$template =  new CMS_pageTemplate();
	}
	$website =  CMS_tree::getPageWebsite($cms_page);
}
$grand_root = CMS_tree::getRoot();

$pub_start = $cms_page->getPublicationDateStart();
$pub_end = $cms_page->getPublicationDateEnd();
$reminder_date = $cms_page->getReminderOn();
$date_mask = $cms_language->getDateFormatMask();
$print = ($cms_page->getPrintStatus()) ? $cms_language->getMessage(MESSAGE_PAGE_FIELD_YES):$cms_language->getMessage(MESSAGE_PAGE_FIELD_NO);
//get page relation
if (sensitiveIO::isPositiveInteger($cms_page->getID())) {
	$linksFrom = CMS_linxesCatalog::searchRelations(CMS_linxesCatalog::PAGE_LINK_FROM, $cms_page->getID());
	$linksTo = CMS_linxesCatalog::searchRelations(CMS_linxesCatalog::PAGE_LINK_TO, $cms_page->getID());
}
if ($use_mode!='creation') {
	$editable = false;
	// ****************************************************************
	// ** ACTIONS POSSIBLE ON PAGE (SUB-MENU DEFINITION)             **
	// ****************************************************************
	$actions = new CMS_subMenus();
	if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
		if ($lock = $cms_page->getLock()) {
			
			//actions are impossible, but lock can be eventually removed if its the user who placed the lock
			if ($cms_user->getUserID() == $lock && $use_mode=='edition') {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
						$cms_language->getMessage(MESSAGE_PAGE_ACTION_RETURN_PROPERTIES),
						PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
						'view_basedata.gif');
				$one_action->addAttribute("onSubmit", 'return confirm(\'' . addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDOCONFIRM, array($cms_page->getTitle()))).'\')');
				$one_action->addHidden("cms_action", "page_unEditBaseData");
			} elseif ($cms_user->getUserID() == $lock || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
						$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNLOCK),
						PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
						'verrou.gif');
				$one_action->addHidden("cms_action", "page_unlock");
			}
		} else {
			//actions are possible
			if ($cms_page->getProposedLocation() == RESOURCE_LOCATION_DELETED) {
				//there's only one action : undo the page deletion proposal.
				
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
						$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDELETE),
						PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
						'annul_delete.gif');
				$one_action->addHidden("cms_action", "page_undel");
				$one_action->addHidden("action_page", $cms_page->getID());
				$one_action->addAttribute("onSubmit", 'return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDELETECONFIRM, array($cms_page->getTitle()))) . '\')');
			} elseif ($cms_page->getProposedLocation() == RESOURCE_LOCATION_ARCHIVED) {	
				//there's only one action : undo the page archiving proposal.
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
						$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNARCHIVE),
						PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
						'annul_archiver.gif');
				$one_action->addHidden("cms_action", "page_undel");
				$one_action->addHidden("action_page", $cms_page->getID());
				$one_action->addAttribute("onSubmit", 'return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_UNARCHIVECONFIRM, array($cms_page->getTitle()))) . ' ?\')');
			} else {
				//module specific actions (only for standard module)
				$modules = $cms_page->getModules();
				if ($modules) {
					foreach ($modules as $module) {
						if ($module && $module->getCodename() == MOD_STANDARD_CODENAME && $cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {
							$editable = true;
						}
					}
				}
				if ($editable && $cms_page->isDraft()) {
					//draft actions
					//previz draft
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_DRAFT),
														$cms_language->getMessage(MESSAGE_PAGE_ACTION_DRAFT_PREVIEW),
														PATH_ADMIN_SPECIAL_PAGEPREVIZ_WR,
														'draft_previz.gif');
					$one_action->addAttribute("target", "_blank");
					$one_action->addAttribute("method", "get");
					$one_action->addHidden("draft", "true");
					$one_action->addHidden("page", $cms_page->getID());
					//delete draft
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_DRAFT),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_CANCEL_DRAFT),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'draft_trash.gif');
							$one_action->addHidden("cms_action", "page_cancel_draft");
							$one_action->addAttribute("onSubmit", "return confirm('".str_replace("'", "\'", $cms_language->getMessage(MESSAGE_PAGE_CANCEL_DRAFT_CONFIRM))."');");
					//submit draft to publication
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_DRAFT),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_SUBMIT_FOR_VALIDATION),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'save_to_publication.gif');
							$one_action->addHidden("cms_action", "submit_for_validation");
				}
				
				//page base data editing
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
						$cms_language->getMessage(MESSAGE_PAGE_ACTION_BASEDATA),
						$_SERVER["SCRIPT_NAME"],
						'edit_basedata.gif');
						$one_action->addHidden("action_page", $cms_page->getID());
						$one_action->addHidden("use_mode", "edition");
				if ($editable) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_CONTENT),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'modifier.gif');
							$one_action->addHidden("cms_action", "prepare_content_edition");
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_ROW_CONTENT),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'editer_modele.gif');
							$one_action->addHidden("cms_action", "prepare_row_edition");
				}
				//sibling add
				if ($cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_CREATE),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLING),
							$_SERVER["SCRIPT_NAME"],
							'creer_sous_page.gif');
					$one_action->addHidden("action_page", $cms_page->getID());
					$one_action->addHidden("use_mode", "creation");
				}
				//page displacement
				if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) 
						&& $cms_page->getID() != APPLICATION_ROOT_PAGE_ID) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_DISPLACE),
							PATH_ADMIN_SPECIAL_TREE_WR,
							'deplacer.gif');
					$one_action->addAttribute("method", "get");
					$one_action->addHidden("root", $grand_root->getID());
					$one_action->addHidden("encodedPageLink", base64_encode(PATH_ADMIN_SPECIAL_ENTRY_WR.chr(167).chr(167).'cms_action=displace'.chr(167).'new_father=%s'));
					$one_action->addHidden("backLink", PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR);
					$one_action->addHidden("title", $cms_language->getMessage(MESSAGE_PAGE_ACTION_DISPLACE_TITLE));
					$one_action->addHidden("heading", $cms_language->getMessage(MESSAGE_PAGE_ACTION_DISPLACE_HEADING, array(addslashes($cms_page->getTitle()))));
				}
				//page archiving
				if (!sizeof($siblings)) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_ARCHIVE),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'archiver.gif');
					$one_action->addHidden("cms_action", "page_archive");
					$one_action->addHidden("action_page", $cms_page->getID());
					$one_action->addAttribute("onSubmit", 'return confirm(\'' . addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_ARCHIVECONFIRM, array($cms_page->getTitle()))).'\')');
				}
				//page copy
				if ($cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_COPY),
							"page_copy.php",
							'copier.gif');
					$one_action->addHidden("duplicationNodeFrom", $cms_page->getID());
					$one_action->addHidden("cms_action", "pc_select_section");
					$one_action->addAttribute("method", "get");
				}
				//page deletion
				if (!sizeof($siblings) && $cms_page->getID() != $grand_root->getID()) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'poubelle.gif');
					$one_action->addHidden("cms_action", "page_del");
					$one_action->addHidden("action_page", $cms_page->getID());
					if(is_array($linksTo) && $linksTo){
						$one_action->addAttribute("onSubmit", 'return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_WARNING_DELETION,array(count($linksTo),$cms_page->getTitle()),MOD_STANDARD_CODENAME)).'\')');
					} else {
						$one_action->addAttribute("onSubmit", 'return confirm(\'' . addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array($cms_page->getTitle()))).'\')');
					}
				}
				//page editions cancelling
				$editions = $status->getEditions();
				if ($cms_page->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED && 
					($editions & RESOURCE_EDITION_CONTENT)) {
					$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
							$cms_language->getMessage(MESSAGE_PAGE_ACTION_CANCEL_EDITIONS),
							PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
							'annuler_modifs.gif');
					$one_action->addHidden("cms_action", "page_cancel_editions");
					$one_action->addHidden("action_page", $cms_page->getID());
					$one_action->addAttribute("onSubmit", 'return confirm(\'' . addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_CANCEL_EDITIONS_CONFIRM, array($cms_page->getTitle()))).'\')');
				}
			}
		}
	}
	//views
	if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
		$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
											$cms_language->getMessage(MESSAGE_PAGE_ACTION_PREVIEW),
											PATH_ADMIN_SPECIAL_PAGEPREVIZ_WR,
											'previz.gif');
		$one_action->addAttribute("target", "_blank");
		$one_action->addAttribute("method", "get");
		$one_action->addHidden("page", $cms_page->getID());
	}
	if ($cms_page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
		
		$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
											$cms_language->getMessage(MESSAGE_PAGE_ACTION_ONLINE),
											$cms_page->getURL(),
											'en_ligne.gif');
		$one_action->addAttribute("target", "_blank");
	}
	$dialog->setSubMenu($actions);
}

// ****************************************************************
// ** TAB CONTENT                                                **
// ****************************************************************

switch ($use_mode) {
	case 'view':
		$title=htmlspecialchars($cms_page->getTitle());
		$link_title=htmlspecialchars($cms_page->getLinkTitle());
		$publi_start=$pub_start->getLocalizedDate($cms_language->getDateFormat()).' <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</span>';
		$publi_end=$pub_end->getLocalizedDate($cms_language->getDateFormat());
		$reminderPeriodicity=$cms_page->getReminderPeriodicity().' <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY_COMMENT).')</span>';
		$reminderDate=$reminder_date->getLocalizedDate($cms_language->getDateFormat());
		$reminderMessage=htmlspecialchars($cms_page->getReminderOnMessage());
		$description=htmlspecialchars($cms_page->getDescription());
		$keywords=htmlspecialchars($cms_page->getKeywords());
		$category=htmlspecialchars($cms_page->getCategory());
		$robots=htmlspecialchars($cms_page->getRobots());
		if (!NO_PAGES_EXTENDED_META_TAGS) {
			$author=htmlspecialchars($cms_page->getAuthor());
			$replyTo=htmlspecialchars($cms_page->getReplyto());
			$copyright=htmlspecialchars($cms_page->getCopyright());
		}
		$language=htmlspecialchars($cms_page->getLanguage());
		$pragma= ($cms_page->getPragma()!='') ? $cms_language->getMessage(MESSAGE_PAGE_FIELD_PRAGMA_COMMENTS):'';
		$refresh=htmlspecialchars($cms_page->getRefresh());
		$mandatory="";
		$tpl = ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) ? '<a href="' .PATH_ADMIN_WR. '/template_basedata.php?template='.$template->getID().'" class="admin">'.htmlspecialchars($template->getLabel()).'</a>' : htmlspecialchars($template->getLabel());
		$redirectlink = $cms_page->getRedirectLink();
		if ($redirectlink->hasValidHREF()) {
			$redirect = $cms_language->getMessage(MESSAGE_PAGE_FIELD_YES).' '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TO).' : ';
			if ($redirectlink->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
				$redirectPage = new CMS_page($redirectlink->getInternalLink());
				if (!$redirectPage->hasError()) {
					$label = $cms_language->getMessage(MESSAGE_PAGE_FIELD_PAGE).' "'.$redirectPage->getTitle().'" ('.$redirectPage->getID().')';
				}
			} else {
				$label = $redirectlink->getExternalLink();
			}
			$redirectlink->setTarget('_blank');
			$redirect .= $redirectlink->getHTML($label, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED, 'class="admin"', false);
		} else {
			$redirect = $cms_language->getMessage(MESSAGE_PAGE_FIELD_NO);
		}
	break;
	case 'creation':
	case 'edition':
		$title='<input type="text" size="30" maxlength="150" class="admin_input_long_text" name="title" value="'.htmlspecialchars($cms_page->getTitle()).'" />';
		if ($use_mode == 'edition') {
			$refreshUrl .='<br /><label for="forcePageURLRefresh"><input type="checkbox" onclick="return (this.checked) ? confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_FIELD_FORCEURLREFRESH_CONFIRM)).'\') : true;" id="forcePageURLRefresh" name="forcePageURLRefresh" value="1"'.($cms_page->getRefreshURL() ? ' checked="cheched"':'').' />'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FORCEURLREFRESH_COMMENT).'</label>';
		}
		$link_title='<input type="text" size="30" maxlength="150" class="admin_input_long_text" name="linktitle" value="'.htmlspecialchars($cms_page->getLinkTitle()).'" />';
		$publi_start='<input type="text" size="15" class="admin_input_text" id="pub_start" name="pub_start" value="'.$pub_start->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'pub_start\'),\''.$cms_language->getCode().'\',this);return false;" />&nbsp;<span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</span>';
		$publi_end='<input type="text" size="15" class="admin_input_text" id="pub_end" name="pub_end" value="'.$pub_end->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'pub_end\'),\''.$cms_language->getCode().'\',this);return false;" />&nbsp;<span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</span>';
		$reminderPeriodicity='<input type="text" size="5" class="admin_input_text" name="reminder" value="'.$cms_page->getReminderPeriodicity().'" /> <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY_COMMENT).')</span>';
		$reminderDate='<input type="text" size="15" class="admin_input_text" id="reminder_on" name="reminder_on" value="'.$reminder_date->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'reminder_on\'),\''.$cms_language->getCode().'\',this);return false;" />&nbsp;<span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</span>';
		$reminderMessage='<textarea cols="45" rows="2" class="admin_long_textarea" name="reminder_on_message">'.htmlspecialchars($cms_page->getReminderOnMessage()).'</textarea>';
		$description='<textarea cols="45" rows="2" class="admin_long_textarea" name="description">'.htmlspecialchars($cms_page->getDescription(false,false)).'</textarea>';
		$keywords='<textarea cols="45" rows="2" class="admin_long_textarea" name="keywords">'.htmlspecialchars($cms_page->getKeywords(false,false)).'</textarea>';
		$category='<input type="text" size="30" maxlength="255" class="admin_input_long_text" name="category" value="'.htmlspecialchars($cms_page->getCategory(false,false)).'" />';
		$robots='<input type="text" size="15" maxlength="255" class="admin_input_text" name="robots" value="'.htmlspecialchars($cms_page->getRobots(false,false)).'" /> <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROBOTS_COMMENT).')</span>';
		if (!NO_PAGES_EXTENDED_META_TAGS) {
			$author='<input type="text" size="30" maxlength="255" class="admin_input_long_text" name="author" value="'.htmlspecialchars($cms_page->getAuthor(false,false)).'" />';
			$replyTo='<input type="text" size="15" maxlength="255" class="admin_input_long_text" name="replyto" value="'.htmlspecialchars($cms_page->getReplyto(false,false)).'" />';
			$copyright='<input type="text" size="30" maxlength="255" class="admin_input_long_text" name="copyright" value="'.htmlspecialchars($cms_page->getCopyright(false,false)).'" />';
		}
		$language='<select name="language" class="admin_input_text"><option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
		$languages = CMS_languagesCatalog::getAllLanguages();
		foreach ($languages as $aLanguage) {
			$language .= '<option value="'.$aLanguage->getCode().'"'.($aLanguage->getCode() == $cms_page->getLanguage(false,false) ? ' selected="selected"':'').'>'.$aLanguage->getLabel().'</option>';
		}
		$language .= '</select>';
		$pragma_checked = ($cms_page->getPragma()!='') ? ' checked="checked"' : '' ;
		$pragma='<label><input type="checkbox" name="pragma" value="no-cache"'.$pragma_checked.' />'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PRAGMA_COMMENTS).'</label>';
		$refresh='<input type="text" size="30" maxlength="255" class="admin_input_text" name="refresh" value="'.htmlspecialchars($cms_page->getRefresh()).'" /> <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REFRESH_COMMENT).')</span>';
		$mandatory='<span class="admin_text_alert">*</span> ';
		$redirectlinkDialog = new CMS_dialog_href($cms_page->getRedirectLink());
		$linkOptions = array (
			'label' 		=> false,				// Link has label ?
			'internal' 		=> true,				// Link can target an Automne page ?
			'external' 		=> true,				// Link can target an external resource ?
			'file' 			=> false,				// Link can target a file ?
			'destination'	=> false,				// Can select a destination for the link ?
		);
		$redirect = $redirectlinkDialog->getHTMLFields($cms_language, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED, $linkOptions);
		
		if ($use_mode == 'edition') {
			/*
			 * Template replacement
			 * check all templates from catalogue and select wich are useable for replacement
			 */
			//the tplFrom
			$tplFrom = $cms_page->getTemplate();
			//hack if page has no valid template attached
			if (!is_a($tplFrom, "CMS_pageTemplate")) {
				$tplFrom = new CMS_pageTemplate();
			}
			//All templates avalaibles for this user
			$templatesReplacements = CMS_pageTemplatesCatalog::getAvailableTemplatesForUser($cms_user);
			//$templatesReplacements = CMS_pageTemplatesCatalog::getAll();
			$useableTpl = array();
			$notMatchTpl = array();
			//modules called in tplFrom
			$tplFromModules = $tplFrom->getModules();
			
			//clientSpaces in tplFrom
			//Temporary var used to simplify clientspaces comparaison : array('id' => 'module');
			$oldClientSpaces = array();
			foreach ($tplFrom->getClientSpacesTags() as $tag) {
				$id = ($tag->getAttribute("id")!='') ? $tag->getAttribute("id") : 'NO ID';
				$oldClientSpacesLabels[] = 'id: '.$tag->getAttribute("id").', module: '.$tag->getAttribute("module");
				$oldClientSpaces[] = array($id => $tag->getAttribute("module"));
			}
			ksort($oldClientSpaces);
			foreach ($templatesReplacements as $tplTo) {
				//remove templates wich not use same modules
				$tplToModules = $tplTo->getModules();
				if ($tplToModules==$tplFromModules) {
					//remove templates wich not have same ClientSpaces
					$newClientSpaces = array();
					foreach ($tplTo->getClientSpacesTags() as $tag) {
						$id = ($tag->getAttribute("id")!='') ? $tag->getAttribute("id") : 'NO ID';
						$newClientSpacesLabels[] = 'id: '.$tag->getAttribute("id").', module: '.$tag->getAttribute("module");
						$newClientSpaces[] = array($id => $tag->getAttribute("module"));
					}
					ksort($newClientSpaces);
					//check templates clientspaces conformity and remove the current template of the page from list
					if ($oldClientSpaces == $newClientSpaces && $tplFrom->getID() != $tplTo->getID()) {
						//here templates are repleceable so add it to the array
						$useableTpl[$tplTo->getID()]=$tplTo;
					} elseif($tplFrom->getID() != $tplTo->getID()) {
						$notMatchTpl[]=$tplTo;
					}
				} else {
					$notMatchTpl[]=$tplTo;
				}
			}
			if (sizeof($useableTpl) || sizeof($notMatchTpl)) {
				$tpl='<table border="0" cellspacing="0" cellpadding="3">
				<tr><td>
					<select name="templateReplacement" class="admin_input_text" size="1">';
				$hasSelection = false;
				$tpl.='<optgroup label="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_MATCHING_TEMPLATES).'">';
				foreach ($useableTpl as $aUseableTpl) {
					if ($tplFrom->getDefinitionFile()==$aUseableTpl->getDefinitionFile()) {
						$hasSelection = true;
						$tpl .= '<option value="" selected="selected">'.$aUseableTpl->getLabel().'</option>';
					} else {
						$tpl .= '<option value="'.$aUseableTpl->getID().'">'.$aUseableTpl->getLabel().'</option>';
					}
				}
				//add template page if not already listed
				if ($hasSelection===false) {
					$tpl .= '<option value="" selected="selected">'.$tplFrom->getLabel().'</option>';
				}
				$tpl.='</optgroup>';
				if (sizeof($notMatchTpl)) {
					$tpl.='<optgroup label="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_UNMATCHING_TEMPLATES).'">';
					foreach ($notMatchTpl as $aNotMatchTpl) {
						if (!$useableTpl[$aNotMatchTpl->getID()]) {
							$tpl .= '<option value="'.$aNotMatchTpl->getID().'" style="color:red;">'.$aNotMatchTpl->getLabel().'</option>';
						}
					}
					$tpl.='</optgroup>';
				}
				$tpl .= '
				</select></td>';
				if (sizeof($notMatchTpl)) {
					$tpl .= '<td class="admin" style="color:red;"><small><em>'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNMATCHING_TEMPLATES_USE).'</em></small></td>';
				}
				$tpl .= '</tr></table>';
			} else {
				$tpl .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_NO_TEMPLATES_RIGHTS);
			}
		}
	break;
}

// ****************************************************************
// ** TAB CREATION                                               **
// ****************************************************************

$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "0");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_TAB_IDENTITY).'", "'.$cms_language->getMessage(MESSAGE_PAGE_TAB_IDENTITY).'"));
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_TAB_DATESALERTS).'", "'.$cms_language->getMessage(MESSAGE_PAGE_TAB_DATESALERTS).'"));
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_TAB_SEARCHENGINES).'", "'.$cms_language->getMessage(MESSAGE_PAGE_TAB_SEARCHENGINES).'"));
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_TAB_METATAGS).'", "'.$cms_language->getMessage(MESSAGE_PAGE_TAB_METATAGS).'"));';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG) && $use_mode!='creation') {
	$content .='monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_LOGS).'", "'.$cms_language->getMessage(MESSAGE_PAGE_LOGS).'"));';
}
$content .='</script>

<table width="600" border="0" cellpadding="0" cellspacing="0">';

if ($use_mode!='view') {
	$content .='<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="check();">
	<input type="hidden" name="use_mode" value="'.$use_mode.'" />
	<input type="hidden" name="action_page" value="'.$action_page.'" />
	<input type="hidden" name="cms_action" value="validate" />';
}
$content .='
<tr>
	<td>
	<script>monOnglet.displayHeader();</script>
			<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</td>
					<td class="admin_onglet_body">'.$title.'</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">';
					if ($use_mode=='edition') {
						$content .= $mandatory;
					}
		$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_LINKTITLE).'</td>
					<td class="admin_onglet_body">'.$link_title.'</td>
				</tr>';
	if ($use_mode!='creation') {
		$content .='<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_INFO_ID).'</td>
					<td class="admin_onglet_body">' . $cms_page->getID() . '</td>
				</tr>';
		if ($cms_page->getURL()) {
			$content .='
					<tr>
						<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_URL).'</td>
						<td class="admin_onglet_body"><a href="'.$cms_page->getURL().'" target="_blank" class="admin">'.$cms_page->getURL().'</a>'.$refreshUrl.'</td>
					</tr>';
		}
		$content .='
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_INFO_TEMPLATE).'</td>
					<td class="admin_onglet_body">'.$tpl.'</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_WEBSITE).'</td>
					<td class="admin_onglet_body"><a class="admin" href="'.$website->getURL().'" target="_blank">' . $website->getLabel() . '</a></td>
				</tr>';
		// Relations
		$content.='
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_LINKS_RELATIONS).'</td>
					<td class="admin_onglet_body">
						- <a class="admin" href="'.PATH_ADMIN_WR.'/search.php?search='.CMS_search::SEARCH_TYPE_LINKFROM.':'.$cms_page->getID().'">'.$cms_language->getMessage(MESSAGE_PAGE_RESULTS_RELATIONS,array(count($linksTo)),MOD_STANDARD_CODENAME).'</a>
						<br/>- <a class="admin" href="'.PATH_ADMIN_WR.'/search.php?search='.CMS_search::SEARCH_TYPE_LINKTO.':'.$cms_page->getID().'">'.$cms_language->getMessage(MESSAGE_PAGE_RESULTS_LINKS,array(count($linksFrom)),MOD_STANDARD_CODENAME).'</a>
					</td>
				</tr>';
		$content.='
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PRINT).'</td>
					<td class="admin_onglet_body">'.$print.'</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REFRESH).'</td>
					<td class="admin_onglet_body">'.$redirect.'</td>
				</tr>';
	}
	$content .='</table>
			</div>
			<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG).'</td>
					<td class="admin_onglet_body">'.$publi_start.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END).'</td>
					<td class="admin_onglet_body">'.$publi_end.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY).'</td>
					<td class="admin_onglet_body">'.$reminderPeriodicity.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERDATE).'</td>
					<td class="admin_onglet_body">'.$reminderDate.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMINDERMESSAGE).'</td>
					<td class="admin_onglet_body">'.$reminderMessage.'&nbsp;</td>
				</tr>
          	</table>
			</div>
			<div id="og_monOnglet2" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
					<td class="admin_onglet_body">'.$description.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS).'</td>
					<td class="admin_onglet_body">'.$keywords.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY).'</td>
					<td class="admin_onglet_body">'.$category.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROBOTS).'</td>
					<td class="admin_onglet_body">'.$robots.'&nbsp;</td>
				</tr>
          	</table>
			</div>
			<div id="og_monOnglet3" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>';
			if (!NO_PAGES_EXTENDED_META_TAGS) {
				$content .='
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_AUTHOR).'</td>
					<td class="admin_onglet_body">'.$author.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REPLYTO).'</td>
					<td class="admin_onglet_body">'.$replyTo.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COPYRIGHT).'</td>
					<td class="admin_onglet_body">'.$copyright.'&nbsp;</td>
				</tr>';
			}
			$content .='
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LANGUAGE).'</td>
					<td class="admin_onglet_body">'.$language.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PRAGMA).'</td>
					<td class="admin_onglet_body">'.$pragma.'&nbsp;</td>
				</tr>
				<tr>
					<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REFRESH).'</td>
					<td class="admin_onglet_body">'.$refresh.'&nbsp;</td>
				</tr>
          	</table>
			</div>';

// ****************************************************************
// ** LOGS                                                       **
// ****************************************************************

if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG) && $use_mode!='creation') {
	
	$good_actions = CMS_log_catalog::getResourceActions();
	$actions = CMS_log_catalog::getByResource("standard", $cms_page->getID());
	$content .= '
	<div id="og_monOnglet4" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
	<tr>
		<td class="admin_onglet_head_top" colspan="2"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_LOGS_ACTION, array(htmlspecialchars("'".$cms_page->getTitle()."'"))).'</strong></td>
	</tr>
	
	';
	$count="";
	foreach ($actions as $action) {
		if (in_array($action->getLogAction(), $good_actions)) {
			$dt = $action->getDatetime();
			$usr = $action->getUser();
			if (is_a($usr, "CMS_profile_user")) {
				$userlink = '<a class="admin" href="mailto:'.$usr->getEmail().'">'.$usr->getFirstName()." ".$usr->getLastName().'</a>';
			} else {
				$userlink = "";
			}
			$count++;
			$td_class = ($count % 2 == 0) ? "admin_darkgreybg" : "admin_lightgreybg" ;
			$status = $action->getResourceStatusAfter();
			$content .= '<tr>';
			$content .= '<td class="'.$td_class.'">'.$status->getHTML(true, false, false, false, false).'</td>
					<td class="'.$td_class.'">'.$dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s').' : <b>'.htmlspecialchars($cms_language->getMessage(array_search($action->getLogAction(), $good_actions))).'</b> 
					'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_BY).' '.$userlink;
					if ($action->getTextData()) {
						$content .=' ('.$action->getTextData().')';
					}
			$content .= '</td>
				</tr>
			';
		}
	}
	$content .= '
		</table>
		</div>
	';
}
$content .= '
	<script>monOnglet.displayFooter();</script>
		</td>
	</tr>';

if ($use_mode!='view') {
	$content .='
	<tr>
		<td align="right"><br /><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	<tr>
		<td class="admin">'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'</td>
	</tr>
	</form>';
}
$content .='
</table>
';


// ****************************************************************
// ** SIBLINGS                                                   **
// ****************************************************************

if (sizeof($siblings) && $use_mode!='creation') {
	if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
		$content .= '
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/coordinates.js"></script>
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/drag.js"></script>
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/dragsort.js"></script>
		<script language="JavaScript" type="text/javascript">
			<!--
			function sortList() {
				DragSort.makeListSortable(document.getElementById("pages"));
			};
			function startDragging() {
				if (document.getElementById("validateDrag").className=="hideit") {
					document.getElementById("validateDrag").className="showit";
				}
				return true;
			}
			function getNewOrder() {
				var pages = document.getElementById("pages");
				pagesArray = pages.getElementsByTagName("li");
				var newOrder;
				for (var i=0; i<pagesArray.length; i++) {
					newOrder = (newOrder) ? newOrder + "," + pagesArray[i].id : pagesArray[i].id;
				}
				document.change_order.new_order.value=newOrder;
				return true;
			}
			//-->
		</script>
		<br />
		<table border="0" width="400" cellpadding="2" cellspacing="2">
			<tr>
				<th width="364" class="admin">'.$cms_language->getMessage(MESSAGE_SUBPAGE).'</th>
				<th width="36" class="admin">'.$cms_language->getMessage(MESSAGE_SUBPAGE_ORDER).'</th>
			</tr>
		</table>
		<ul id="pages" class="sortable">';
		$count=0;
		foreach ($siblings as $sibling) {
			if (!$cms_user->hasPageClearance($sibling->getID(), CLEARANCE_PAGE_VIEW)) {
				continue;
			}
			$sib_stat = $sibling->getStatus();
			$count++;
			$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg" ;
			$content .= '
			<li id="p'.$sibling->getID().'">
				<table border="0" width="400" cellpadding="2" cellspacing="2">
					<tr>
						<td width="10" class="'.$td_class.'">'.$sib_stat->getHTML(true,$cms_user,MOD_STANDARD_CODENAME,$sibling->getID()).'</td>
						<td width="350" class="'.$td_class.'"><a href="'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?page='.$sibling->getID().'" class="admin">'.htmlspecialchars($sibling->getTitle()).' ('.$sibling->getID().')</a></td>
						<td width="36" align="center" class="'.$td_class.'" style="cursor:move;"><img src="'.PATH_ADMIN_IMAGES_WR.'/drag.gif" border="0" /></td>
					</tr>
				</table>
			</li>';
		}
		$content .= '</ul>
		<div id="validateDrag" class="hideit">
		<form name="change_order" onsubmit="return getNewOrder();" action="'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'" method="post">
		<input type="hidden" name="cms_action" value="change_order" />
		<input type="hidden" name="new_order" value="" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_SAVE_NEWORDER).'" />
		</form>
		</div>
		';
	} else {
		$content .= '
		<br />
		<table border="0" width="400" cellpadding="2" cellspacing="2">
			<tr>
				<th class="admin" colspan="2">'.$cms_language->getMessage(MESSAGE_SUBPAGE).'</th>
			</tr>';
		$count=0;
		foreach ($siblings as $sibling) {
			if (!$cms_user->hasPageClearance($sibling->getID(), CLEARANCE_PAGE_VIEW)) {
				continue;
			}
			$sib_stat = $sibling->getStatus();
			$count++;
			$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg" ;
			$content .= '
			<tr>
				<td width="10" class="'.$td_class.'">'.$sib_stat->getHTML(true,$cms_user,MOD_STANDARD_CODENAME,$sibling->getID()).'</td>
				<td width="350" class="'.$td_class.'"><a href="'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?page='.$sibling->getID().'" class="admin">'.htmlspecialchars($sibling->getTitle()).' ('.$sibling->getID().')</a></td>
			</tr>';
		}
		$content .= '</table>';
	}
}
$dialog->setContent($content);
$dialog->show();
?>