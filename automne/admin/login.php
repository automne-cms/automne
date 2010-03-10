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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: login.php,v 1.13 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Login
  * Manages the login of users. Creates login window.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

define("MESSAGE_PAGE_LOGIN", 54);
define("MESSAGE_PAGE_PASSWORD", 55);
define("MESSAGE_PAGE_REMEMBER_ME", 1218);
define("MESSAGE_BUTTON_VALIDATE", 56);
define("MESSAGE_BUTTON_CANCEL", 180);
define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_ERROR_LOGIN_INCORRECT", 50);
define("MESSAGE_ERROR_TITLE", 301);
define("MESSAGE_PAGE_LOGIN_IN_PROGRESS", 302);
define("MESSAGE_PAGE_REQUIRED_FIELD", 1239);
define("MESSAGE_ERROR_REQUIRED_FIELD", 303);
define("MESSAGE_PAGE_USER_WELCOME", 314);
define("MESSAGE_PAGE_USER_NOVALIDATION", 1113);
define("MESSAGE_PAGE_USER_VALIDATIONS", 315);
define("MESSAGE_PAGE_DEBUG", 674);
define("MESSAGE_PAGE_PRESS_F2_FOR_LOG", 675);
define("MESSAGE_ERROR_SESSION_EXPIRED", 676);

//load language object
$language = CMS_languagesCatalog::getDefaultLanguage(true);
//load interface instance
$view = CMS_view::getInstance();
//var used to display error of login
$loginError = '';

$cms_action = io::request('cms_action');

//Action management	
switch ($cms_action) {
case 'logout':
		// Reset cookie (kill current session)
		CMS_context::resetSessionCookies();
	break;
case 'reconnect':
		//display error login window on top of login form
		$loginError = "
		Automne.message.popup({
			msg: '{$language->getJsMessage(MESSAGE_ERROR_SESSION_EXPIRED)}',
			buttons: Ext.MessageBox.OK,
			icon: Ext.MessageBox.ERROR,
			fn:function() {
				//Ext.fly('loginField').dom.select();
			}
		});";
		//reset session (start fresh)
		session_destroy();
	break;
default:
	// First attempt to obtain $_COOKIE information from domain
	if ((!$cms_action || $cms_action != 'logout') && CMS_context::autoLoginSucceeded()) {
		if (!$_SESSION["cms_context"]->hasError() && ($cms_user = $_SESSION["cms_context"]->getUser()) && $cms_user->hasAdminAccess()) {
			//launch the daily routine incase it's not in the cron
			CMS_module_standard::processDailyRoutine();
			//then set context and load Automne interface
			$userSessionsInfos = CMS_context::getSessionInfos();
			$cms_user = $_SESSION["cms_context"]->getUser();
			$language = $cms_user->getLanguage();
			//welcome message
			$welcome = $language->getJsMessage(MESSAGE_PAGE_USER_WELCOME, array($userSessionsInfos['fullname']));
			if ($userSessionsInfos['hasValidations']) {
				$welcome .= '<br /><br />'.(($userSessionsInfos['awaitingValidation']) ? $language->getJsMessage(MESSAGE_PAGE_USER_VALIDATIONS, array($userSessionsInfos['awaitingValidation'])) : $language->getJsMessage(MESSAGE_PAGE_USER_NOVALIDATION));
			}
			if (SYSTEM_DEBUG && $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$welcome .= '<br /><br /><span class="atm-red">'.$language->getJsMessage(MESSAGE_PAGE_DEBUG).'</span> '.$language->getJsMessage(MESSAGE_PAGE_PRESS_F2_FOR_LOG);
			}
			$jscontent = '
			//show front page in tab
			Automne.tabPanels.getActiveTab().setFrameURL(\'/\');
			Automne.tabPanels.getActiveTab().reload();
			//load interface
			Automne.load('.sensitiveIO::jsonEncode($userSessionsInfos).');
			//display welcome message
			Automne.message.show(\''.sensitiveIO::sanitizeJSString($welcome).'\');
			';
			//add all JS locales
			$jscontent .= CMS_context::getJSLocales();
			$view->addJavascript($jscontent);
			$view->show(CMS_view::SHOW_RAW);
		} else {
			//display error login window on top of login form
			$loginError = "
			Automne.message.popup({
				msg: '{$language->getJsMessage(MESSAGE_ERROR_SESSION_EXPIRED)}',
				buttons: Ext.MessageBox.OK,
				icon: Ext.MessageBox.ERROR
			});";
		}
	}
	break;
}

//Send Login form window
$applicationLabel = addcslashes(APPLICATION_LABEL, "'");
$loginURL = PATH_ADMIN_WR.'/login-form.php?_ts='.time();
$jscontent = 
<<<END
	var loginWindow = new Automne.frameWindow({
		title: 			'{$language->getJsMessage(MESSAGE_PAGE_TITLE, array($applicationLabel))}',
		id:				'loginWindow',
		frameURL:		'{$loginURL}',
		allowFrameNav:	true,
		width: 			400,
		height:			218,
		resizable:		false,
		maximizable:	false,
		autoScroll:		false,
		bodyStyle:		'padding:5px;overflow:hidden;'
	});
	loginWindow.closeAndBack = function() {
		if (Ext.EventManager) {
			Ext.EventManager.removeAll(window);
		}
		document.location.replace('/');
	};
	loginWindow.on('beforeclose', loginWindow.closeAndBack);
	loginWindow.show();
	//show front page in tab
	Automne.tabPanels.getActiveTab().setFrameURL('/');
	Automne.tabPanels.getActiveTab().reload();
	//display login error window if any
	{$loginError}
END;
//send content
$view->addJavascript($jscontent);
$view->show(CMS_view::SHOW_RAW);
?>