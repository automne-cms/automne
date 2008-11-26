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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page_content.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content
  * Used to edit the pages content.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 174);
define("MESSAGE_PAGE_ACTION_VIEW", 78);
define("MESSAGE_PAGE_ACTION_PREVIEW", 79);
define("MESSAGE_PAGE_ACTION_FORM", 179);
define("MESSAGE_PAGE_ACTION_TEMPLATE", 72);
define("MESSAGE_PAGE_ACTION_ACTIONS", 181);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_SUBJECT", 182);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_BODY", 183);
define("MESSAGE_PAGE_BUTTON_TEMPLATE", 187);
define("MESSAGE_PAGE_CANCEL_CONFIRM", 284);
define("MESSAGE_BUTTON_SAVE", 952);
define("MESSAGE_PAGE_ACTION_CONTENT", 89);
define("MESSAGE_PAGE_ACTION_ROW_CONTENT", 1130);

//use mode can be "edition" for content simple editing or "creation" for page creation.
$use_mode = ($_REQUEST["use_mode"]) ? $_REQUEST["use_mode"] : "edition";
//set javascript default action
$viewWhat = ($_REQUEST["viewWhat"]) ? $_REQUEST["viewWhat"] : "block";

//RIGHTS CHECK
$cms_page = $cms_context->getPage();
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT)."&".session_name()."=".session_id());
	exit;
} elseif (!$_REQUEST["cms_action"]) {
	if ($use_mode == "edition" && !$cms_page->getLock()) {
		$cms_page->lock($cms_user);
	}
}

//add a special redirection clause so some modules can create page then return to the module administration
if (is_array($cms_context->getSessionVar("redir")) && sizeof($cms_context->getSessionVar("redir"))) {
	$redirParam = $cms_context->getSessionVar("redir");
	if ($redirParam["location"] && $redirParam["outframe"]) {
		$redirString = '';
		$count=0;
		foreach ($redirParam as $paramName => $paramValue) {
			if ($paramName != "location" && $paramName != "outframe") {
				if ($paramValue == '{{pageID}}') {
					$paramValue = $cms_page->getID();
					$redirParam[$paramName] = $paramValue;
				}
				$redirString .= ($count) ? '&'.$paramName.'='.$paramValue:$paramName.'='.$paramValue;
				$count++;
			}
		}
		$redirLocation = $redirParam["location"]."?".$redirString;
	}
}

//Action management	
switch ($_REQUEST["cms_action"]) {
case "validate":
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
	
	$cms_page->unlock();

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
	
	if ($redirLocation) {
		header("Location: ".$redirLocation);
	} else {
		header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE)."&".session_name()."=".session_id());
	}
	exit;
	break;
case "savedraft":
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	//only unlock page and back
	$cms_page->unlock();
	if ($redirLocation) {
		header("Location: ".$redirLocation);
	} else {
		header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR)."&".session_name()."=".session_id());
	}
	exit;
case "cancel":
	//delete draft datas and back
	$tpl = $cms_page->getTemplate();
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	
	$log = new CMS_log();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	
	$cms_page->unlock();
	
	if ($redirLocation) {
		header("Location: ".$redirLocation);
	} else {
		header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR)."&".session_name()."=".session_id());
	}
	exit;
case "row_moveup":
	//check for mandatory vars
	if ($_GET["template"] && $_GET["clientSpaceTagID"] && $_GET["rowTagID"] && $_GET["rowType"]) {
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($_GET["template"], $_GET["clientSpaceTagID"], true);
		$success = $clientSpace->moveRow($_GET["rowType"], $_GET["rowTagID"], -1);
		if ($success) {
			$clientSpace->writeToPersistence();
		}
	}
	$viewWhat = "row";
	break;
case "row_movedown":
	//check for mandatory vars
	if ($_GET["template"] && $_GET["clientSpaceTagID"] && $_GET["rowTagID"] && $_GET["rowType"]) {
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($_GET["template"], $_GET["clientSpaceTagID"], true);
		$success = $clientSpace->moveRow($_GET["rowType"], $_GET["rowTagID"], 1);
		if ($success) {
			$clientSpace->writeToPersistence();
		}
	}
	$viewWhat = "row";
	break;
case "row_delete":
	//check for mandatory vars
	if ($_GET["template"] && $_GET["clientSpaceTagID"] && $_GET["rowTagID"] && $_GET["rowType"]) {
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($_GET["template"], $_GET["clientSpaceTagID"], true);
		$success = $clientSpace->delRow($_GET["rowType"], $_GET["rowTagID"]);
		if ($success) {
			$clientSpace->writeToPersistence();
		}
	}
	$viewWhat = "row";
	break;
case "row_add":
	//check for mandatory vars
	if ($_GET["template"] && $_GET["clientSpaceTagID"] && $_GET["rowTagID"] && $_GET["rowType"]) {
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($_GET["template"], $_GET["clientSpaceTagID"], true);
		$direction = ($_GET["rowDirection"]=="top") ? false:true;
		$success = $clientSpace->addRow($_GET["rowType"], $_GET["rowTagID"],$direction);
		if ($success) {
			$clientSpace->writeToPersistence();
		}
	}
	$viewWhat = "row";
	break;
case "row_clear":
	//check for mandatory vars
	if ($_POST["page"] && $_POST["clientSpace"] && $_POST["row"] && $_POST["block"] && $_POST["blockClass"] && class_exists($_POST["blockClass"])) {
		$cms_block = new $_POST["blockClass"]();
		$cms_block->initializeFromBasicAttributes($_POST["block"]);
		$cms_block->delFromLocation($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
	}
	$viewWhat = "block";
	break;
}

$visual_mode = ($_REQUEST["cms_visualmode"]) ? $_REQUEST["cms_visualmode"] : PAGE_VISUALMODE_FORM;

/* init session temp array for javascript style switching
 * set in classes :
 * - clientspace.php
 * - row.php
 * - block*.php
 */
$cms_context->setSessionVar('switchBlock',array());
$cms_context->setSessionVar('switchRow',array());
$cms_context->setSessionVar('viewWhat',$viewWhat);

//Display Page content
echo $cms_page->getContent($cms_language, $visual_mode);

/*only for stats*/
if (STATS_DEBUG) view_stat();
?>