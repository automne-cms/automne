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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * AUTOMNE Administration rc file.
  * Contains declarations and includes for the backend part.
  * 
  * @package Automne
  * @subpackage config
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  */

/**
  * Define User Type
  */
if (!defined("APPLICATION_USER_TYPE")) {
	define("APPLICATION_USER_TYPE", "admin");
}
//include general configuration file
require_once(dirname(__FILE__)."/cms_rc.php");

//If we are into an admin module, load it
if (strpos($_SERVER['SCRIPT_NAME'], PATH_ADMIN_MODULES_WR) === 0 
	&& file_exists(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php')) {
	require_once(PATH_MODULES_FS.'/'.pathinfo(str_replace(PATH_ADMIN_MODULES_WR.'/', '', $_SERVER['SCRIPT_NAME']),PATHINFO_DIRNAME).'.php');
}

//check for authentification
if (APPLICATION_EXEC_TYPE == 'http') {
	if (!isset($cms_user) || (isset($cms_user) && is_object($cms_user) && !$cms_user->hasAdminAccess())) {
		//load interface instance
		$view = CMS_view::getInstance();
		//set disconnected status
		$view->setDisconnected(true);
		//set default display mode for this page
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$view->setDisplayMode(4); //4 = CMS_view::SHOW_RAW : this constant cannot be used here because this file can be parsed by PHP4
		}
		if (!isset($cms_user)) {
			$view->show();
		}
	}
}
//init message var
$cms_message = '';

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
?>
