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
// $Id: cms_rc_admin.php,v 1.7 2009/06/05 15:30:36 sebastien Exp $

/**
  * Administration rc file.
  *
  * Contains declarations and includes for the administration.
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//include general configuration file
require_once(dirname(__FILE__)."/cms_rc.php");
//Set session name
start_atm_session();

/**
  * Define User Type if APPLICATION_ENFORCES_ACCESS_CONTROL is True
  */
if (!defined("APPLICATION_USER_TYPE")) {
	define("APPLICATION_USER_TYPE", "admin");
}

// Start output buffering for compression so we don't prevent
// headers from being sent if there's a blank line in an included file
if (!defined('HTML_COMPRESSION_STARTED')) {
	ob_start( 'compress_handler' );
}

//If we are into an admin module, load it
if (strpos($_SERVER['SCRIPT_NAME'], PATH_ADMIN_MODULES_WR) === 0 
	&& file_exists(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php')) {
	require_once(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php');
}
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
		
		if (isset($_GET["cms_message_id"]) && SensitiveIO::isPositiveInteger($_GET["cms_message_id"]))	{
			$cms_message = $cms_language->getMessage($_GET["cms_message_id"]);
		} else {
			$cms_message = (isset($_GET["cms_message"])) ? SensitiveIO::sanitizeHTMLString($_GET["cms_message"]) : false;
		}
	} else {
		//load interface instance
		$view = CMS_view::getInstance();
		//set disconnected status
		$view->setDisconnected(true);
		//set default display mode for this page
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$view->setDisplayMode(4); //4 = CMS_view::SHOW_RAW : this constant cannot be used here because this file can be parsed by PHP4
		}
		$view->show();
	}
}

//force module standard loading
if (!class_exists('CMS_module_standard')) {
	die('Cannot find standard module ...');
}

//some commonly used messages
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
