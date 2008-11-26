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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cms_rc_admin.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * Administration rc file.
  *
  * Contains declarations and includes for the administration.
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//include general configuration file
require_once(dirname(__FILE__)."/cms_rc.php");

//start session
@session_start();

/**
  * Define User Type if APPLICATION_ENFORCES_ACCESS_CONTROL is True
  */
if (!defined("APPLICATION_USER_TYPE")) {
	define("APPLICATION_USER_TYPE", "admin");
}

/**
  * Define execution Type
  */
if (!defined("APPLICATION_EXEC_TYPE")) {
	define("APPLICATION_EXEC_TYPE", "http");
}

// Start output buffering for compression so we don't prevent
// headers from being sent if there's a blank line in an included file
ob_start( 'compress_handler' );

//If we are into an admin module, load it
if (strpos($_SERVER['SCRIPT_NAME'], PATH_ADMIN_MODULES_WR) === 0 
	&& file_exists(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php')) {
	require_once(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php');
}
//TODOV4 ici, si des objets de modules se trouvent dans un backtrace précédent, ils posent pb au chargement d'une nouvelle page, d'ou un unset ...
//une meilleure solution sera à trouver
if (isset($_SESSION["backTrace"]) && strpos($_SERVER['SCRIPT_NAME'], 'backTrace.php') === false) unset($_SESSION["backTrace"]);
//check for authentification
if (APPLICATION_EXEC_TYPE == 'http') {
	//check user privileges
	if (isset($_SESSION["cms_context"]) && is_a($_SESSION["cms_context"], "CMS_context")) {
		$_SESSION["cms_context"]->checkSession();
		
		//set some useful vars
		$cms_context =& $_SESSION["cms_context"];
		$cms_user = $_SESSION["cms_context"]->getUser();
		$cms_language = $cms_user->getLanguage();
	
		if (isset($_GET["cms_message_id"]) && SensitiveIO::isPositiveInteger($_GET["cms_message_id"]))	{
			$cms_message = $cms_language->getMessage($_GET["cms_message_id"]);
		} else {
			$cms_message = (isset($_GET["cms_message"])) ? SensitiveIO::sanitizeHTMLString($_GET["cms_message"]) : false;
		}
	} elseif (isset($_REQUEST["cms_action"]) && $_REQUEST["cms_action"] != 'logout' && CMS_context::autoLoginSucceeded()) {
		$_SESSION["cms_context"]->checkSession();
		
		//set some useful vars
		$cms_context =& $_SESSION["cms_context"];
		$cms_user = $_SESSION["cms_context"]->getUser();
		$cms_language = $cms_user->getLanguage();
	
		if ($_GET["cms_message_id"] && SensitiveIO::isPositiveInteger($_GET["cms_message_id"]))	{
			$cms_message = $cms_language->getMessage($_GET["cms_message_id"]);
		} else {
			$cms_message = ($_GET["cms_message"]) ? SensitiveIO::sanitizeHTMLString($_GET["cms_message"]) : false;
		}
	} else {
		//load interface instance
		$view = CMS_view::getInstance();
		//set default display mode for this page
		//$view->setDisplayMode(CMS_view::SHOW_RAW);
		//set disconnected status
		$view->setDisconnected(true);
		$view->show();
	}
}

//force module standard loading
if (!class_exists('CMS_module_standard')) {
	die('Cannot find standard module ...');
}

//TODOV4 : remove those messages from here
//some commonly used messages

/**
  * Constants messages IDs. These constants are the IDs of the translation for the textual expression of all the 
  * system constants.
  */

define("MESSAGE_CLEARANCE_PAGE_NONE", 1);
define("MESSAGE_CLEARANCE_PAGE_VIEW", 2);
define("MESSAGE_CLEARANCE_PAGE_EDIT", 3);

define("MESSAGE_CLEARANCE_MODULE_NONE", 266);
define("MESSAGE_CLEARANCE_MODULE_VIEW", 267);
define("MESSAGE_CLEARANCE_MODULE_EDIT", 268);
define("MESSAGE_CLEARANCE_MODULE_NONE_DESCRIPTION", 470);
define("MESSAGE_CLEARANCE_MODULE_VIEW_DESCRIPTION", 471);
define("MESSAGE_CLEARANCE_MODULE_EDIT_DESCRIPTION", 472);

define("MESSAGE_CLEARANCE_MODULE_CATEGORIES_NONE", 266);
define("MESSAGE_CLEARANCE_MODULE_CATEGORIES_VIEW", 1340);
define("MESSAGE_CLEARANCE_MODULE_CATEGORIES_EDIT", 1341);
define("MESSAGE_CLEARANCE_MODULE_CATEGORIES_MANAGE", 1342);

define("MESSAGE_RESOURCE_PUBLICATION_NEVERVALIDATED", 4);
define("MESSAGE_RESOURCE_PUBLICATION_VALIDATED", 5);
define("MESSAGE_RESOURCE_PUBLICATION_PUBLIC", 6);

define("MESSAGE_RESOURCE_EDITION_BASEDATA", 7);
define("MESSAGE_RESOURCE_EDITION_CONTENT", 8);
define("MESSAGE_RESOURCE_EDITION_SIBLINGSORDER", 9);
define("MESSAGE_RESOURCE_EDITION_LOCATION", 41);

define("MESSAGE_RESOURCE_LOCATION_USERSPACE", 13);
define("MESSAGE_RESOURCE_LOCATION_ARCHIVED", 14);
define("MESSAGE_RESOURCE_LOCATION_DELETED", 15);
define("MESSAGE_RESOURCE_LOCATION_EDITION", 205);

define("MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL", 16);
define("MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES", 17);
define("MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES", 18);  
define("MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES", 19);  
define("MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG", 20);
define("MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS", 77);
define("MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH", 438);
define("MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL_DESCRIPTION", 487);
define("MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES_DESCRIPTION", 488);
define("MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES_DESCRIPTION", 489);  
define("MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES_DESCRIPTION", 490);  
define("MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG_DESCRIPTION", 491);
define("MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS_DESCRIPTION", 492);
define("MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH_DESCRIPTION", 1448);

define("MESSAGE_ALERT_LEVEL_VALIDATION", 21);
define("MESSAGE_ALERT_LEVEL_PROFILE", 22);
define("MESSAGE_ALERT_LEVEL_PAGE_ALERTS", 23);
define("MESSAGE_ALERT_LEVEL_VALIDATION_DESCRIPTION", 335);
define("MESSAGE_ALERT_LEVEL_PROFILE_DESCRIPTION", 336);
define("MESSAGE_ALERT_LEVEL_PAGE_ALERTS_DESCRIPTION", 337);

define("MESSAGE_BUTTON_EDIT", 24);
define("MESSAGE_BUTTON_DELETE", 854);
define("MESSAGE_BUTTON_VALIDATE", 56);
define("MESSAGE_BUTTON_CANCEL", 180);
define("MESSAGE_BUTTON_DETAIL", 217);
define("MESSAGE_BUTTON_MOVEUP", 850);
define("MESSAGE_BUTTON_MOVEDOWN", 851);
define("MESSAGE_BUTTON_ADDROW", 855);
define("MESSAGE_BACK", 25);
define("MESSAGE_FORM_NAME", 853);
define("MESSAGE_FORM_CLIENTSPACE", 856);
define("MESSAGE_TREE", 28);
define("MESSAGE_THE", 33);
define("MESSAGE_HELLO", 34);
define("MESSAGE_LANGUAGE", 35);
define("MESSAGE_DATE_FORMAT", 36);
define("MESSAGE_SESSION_EXPIRED", 37);
define("MESSAGE_VALIDATION_ACCEPT", 38);
define("MESSAGE_VALIDATION_REFUSE", 39);
define("MESSAGE_VALIDATION_TRANSFER", 40);
define("MESSAGE_DATE_TO", 69);
define("MESSAGE_ABBREVIATION_DAY", 141);
define("MESSAGE_ABBREVIATION_MONTH", 142);
define("MESSAGE_ABBREVIATION_YEAR", 143);
define("MESSAGE_CLEARANCE_INSUFFICIENT", 153);
define("MESSAGE_PAGE_LOCKED", 154);
define("MESSAGE_INCORRECT_FIELD_VALUE", 145); 
define("MESSAGE_BUTTON_ON_BOTTOM", 1127);
define("MESSAGE_BUTTON_ON_TOP", 1126);

define("MESSAGE_FORM_MANDATORY_FIELDS", 131);
define("MESSAGE_FORM_ERROR_MANDATORY_FIELDS", 144);
define("MESSAGE_FORM_ERROR_MALFORMED_FIELD", 145);
define("MESSAGE_ACTION_OPERATION_DONE", 122);

define("MESSAGE_EMAIL_VALIDATION_AWAITS", 124);

/**
 * Visualization modes for a page : HTML from public or edited or edition tables ; form mode ; clientSpaces edition mode.
 */
define("PAGE_VISUALMODE_FORM", 1);
define("PAGE_VISUALMODE_HTML_PUBLIC", 2);
define("PAGE_VISUALMODE_HTML_EDITED", 3);
define("PAGE_VISUALMODE_HTML_EDITION", 4);
define("PAGE_VISUALMODE_CLIENTSPACES_FORM", 5);
define("PAGE_VISUALMODE_PRINT", 6);
define("PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE", 7);
?>
