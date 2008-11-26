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
// $Id: login.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

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

//load language object
$language = CMS_languagesCatalog::getDefaultLanguage(true);
//load interface instance
$view = CMS_view::getInstance();
//var used to display error of login
$loginError = '';

//Action management	
switch (isset($_POST["cms_action"])) {
case "login":
	$permanent = isset($_POST["permanent"]) ? $_POST["permanent"] : 0;
	$cms_context = new CMS_context($_POST["login"], $_POST["pass"], $permanent);
	if (!$cms_context->hasError()) {
		@session_start();
		$_SESSION["cms_context"] = $cms_context;
		$cms_user = $_SESSION["cms_context"]->getUser();
		//launch the daily routine in case it's not in the cron
		CMS_module_standard::processDailyRoutine();
		$userSessionsInfos = CMS_context::getSessionInfos();
		
		//welcome message
		$welcome = $language->getJsMessage(MESSAGE_PAGE_USER_WELCOME, array($userSessionsInfos['fullname']));
		if ($userSessionsInfos['hasValidations']) {
			$welcome .= '<br /><br />'.(($userSessionsInfos['awaitingValidation']) ? $language->getJsMessage(MESSAGE_PAGE_USER_VALIDATIONS, array($userSessionsInfos['awaitingValidation'])) : $language->getJsMessage(MESSAGE_PAGE_USER_NOVALIDATION));
		}
		if (SYSTEM_DEBUG && $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$welcome .= '<br /><br /><span class="atm-red">Attention, le debuggage est actif.</span> Pressez F2 pour voir la fenêtre de log.';
		}
		
		//then set context, remove login window and load Automne interface
		$jscontent = '
		//set user context
		Automne.context = '.sensitiveIO::jsonEncode($userSessionsInfos).';
		//remove event closeAndBack on window
		Ext.WindowMgr.get(\'loginWindow\').un(\'close\', Ext.WindowMgr.get(\'loginWindow\').closeAndBack);
		//add event to load Automne interface after close
		Ext.WindowMgr.get(\'loginWindow\').on(\'close\', Automne.load);
		//display welcome message
		Automne.message.show(\''.sensitiveIO::sanitizeJSString($welcome).'\');
		if (Ext.Element.cache[\'loginField\']) {delete Ext.Element.cache[\'loginField\']};
		';
		//add all JS locales
		$jscontent .= CMS_context::getJSLocales();
		$jscontent .= '
		//close login window
		Ext.WindowMgr.get(\'loginWindow\').close();';
		//eval content into parent
		$jscontent = '
		if (parent.Ext.Element.cache[\'loginField\']) {delete parent.Ext.Element.cache[\'loginField\']};
		parent.eval(\''.sensitiveIO::sanitizeJSString($jscontent, true).'\');';
		$view->addJavascript($jscontent);
		$view->show(CMS_view::SHOW_HTML);
	} else {
		//display error login window on top of login form
		$loginError = "
		parent.Automne.message.popup({
			title: '{$language->getJsMessage(MESSAGE_ERROR_TITLE)}',
			msg: '{$language->getJsMessage(MESSAGE_ERROR_LOGIN_INCORRECT)}',
			buttons: Ext.MessageBox.OK,
			icon: Ext.MessageBox.ERROR,
			fn:function() {
				Ext.fly('loginField').dom.select();
			}
		});";
	}
	break;
default:
	// First attempt to obtain $_COOKIE information from domain
	if ((!isset($_REQUEST["cms_action"]) || $_REQUEST["cms_action"] != 'logout') && CMS_context::autoLoginSucceeded()) {
		$cms_user = $_SESSION["cms_context"]->getUser();
		//launch the daily routine incase it's not in the cron
		CMS_module_standard::processDailyRoutine();
		//then set context and load Automne interface
		$userSessionsInfos = CMS_context::getSessionInfos();
		//welcome message
		$welcome = $language->getJsMessage(MESSAGE_PAGE_USER_WELCOME, array($userSessionsInfos['fullname']));
		if ($userSessionsInfos['hasValidations']) {
			$welcome .= '<br /><br />'.(($userSessionsInfos['awaitingValidation']) ? $language->getJsMessage(MESSAGE_PAGE_USER_VALIDATIONS, array($userSessionsInfos['awaitingValidation'])) : $language->getJsMessage(MESSAGE_PAGE_USER_NOVALIDATION));
		}
		if (SYSTEM_DEBUG && $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$welcome .= '<br /><br /><span class="atm-red">Attention, le debuggage est actif.</span> Pressez F2 pour voir la fenêtre de log.';
		}
		$jscontent = '
		//set user context
		Automne.context = '.sensitiveIO::jsonEncode($userSessionsInfos).';
		//load interface
		Automne.load();
		//display welcome message
		Automne.message.show(\''.sensitiveIO::sanitizeJSString($welcome).'\');
		';
		//add all JS locales
		$jscontent .= CMS_context::getJSLocales();
		$view->addJavascript($jscontent);
		$view->show(CMS_view::SHOW_RAW);
	}
	// Reset cookie
	CMS_context::resetSessionCookies();
	break;
}

if (!isset($_GET['loginform'])) {
	//Send Login form window
	
	$applicationLabel = addcslashes(APPLICATION_LABEL, "'");
	$htmlForm = '<iframe id="formframe" width="100%" height="100%" frameborder="0" src="'.$_SERVER['SCRIPT_NAME'].'?loginform=true">&nbsp;</iframe>';
	$jscontent = 
<<<END
	var loginWindow = new Ext.Window({
		title: 		'{$language->getJsMessage(MESSAGE_PAGE_TITLE, array($applicationLabel))}',
		id:			'loginWindow',
		iconCls:	'atm-pic-logo',
		width: 		400,
		height:		218,
		resizable:	false,
		modal: 		true,
		layout: 	'fit',
		plain:		true,
		bodyStyle:	'padding:5px;',
		buttonAlign:'center',
		html: '{$htmlForm}'
	});
	loginWindow.closeAndBack = function() {
		document.location.replace('/');
	};
	loginWindow.on('close', loginWindow.closeAndBack);
	loginWindow.show();
END;
	//send content
	$view->addJavascript($jscontent);
	$view->show(CMS_view::SHOW_RAW);
	
} else {
	//Send Login form frame window (in which login form is displayed)
	$view->addJSFile('ext');
	$view->addCSSFile('ext');
	
	$jscontent = 
<<<END
	Ext.onReady(function() {
		// turn on validation errors beside the field globally
		Ext.form.Field.prototype.msgTarget = 'under';
		var loginField = new Ext.form.TextField({
			allowBlank:	false,
			blankText:	'{$language->getJsMessage(MESSAGE_PAGE_REQUIRED_FIELD)}',
			applyTo:	'loginField'
		});
		var passField = new Ext.form.TextField({
			allowBlank:	false,
			inputType: 	'password',
			blankText:	'{$language->getJsMessage(MESSAGE_PAGE_REQUIRED_FIELD)}',
			applyTo:	'passField'
		});
		var cancelButton = new Ext.Button({
			text: 		'{$language->getJsMessage(MESSAGE_BUTTON_CANCEL)}',
			handler:	function() {if (parent) {parent.Ext.WindowMgr.get('loginWindow').close();}},
			applyTo:	'cancelButton'
		});
		var submitButton = new Ext.Button({
			text: 		'{$language->getJsMessage(MESSAGE_BUTTON_VALIDATE)}',
			handler:	function() {loginForm.doSubmit();},
			applyTo:	'submitButton'
		});
		var loginForm = new Ext.form.BasicForm("loginForm", {
	        doSubmit:function(){
				if (Ext.fly('loginField').dom.value && Ext.fly('passField').dom.value) {
					this.getEl().dom.submit();
				} else {
					Ext.MessageBox.show({
						title: '{$language->getJsMessage(MESSAGE_ERROR_TITLE)}',
						msg: '{$language->getJsMessage(MESSAGE_ERROR_REQUIRED_FIELD)}',
						buttons: Ext.MessageBox.OK,
						icon: Ext.MessageBox.ERROR,
						fn:function() {
							Ext.fly('loginField').dom.select();
						}
					});
				}
			}
	    });
		//set enter keymap
		var map = new Ext.KeyMap("loginForm", {
		    key: 		Ext.EventObject.ENTER,
		    fn: 		loginForm.doSubmit,
			scope:		loginForm
		});
		//put focus on the first login field
		//if (Ext.get('loginField').dom.value){ alert('select');Ext.get('loginField').dom.select(); } else { alert('focus');Ext.get('loginField').focus();}
		//display login error window if any
		{$loginError}
	});
END;
	$view->addJavascript($jscontent);
	//set form HTML
	$content = '
	<div class="x-panel x-form-label-left" style="width: 374px;">
		<div class="x-panel-tl">
			<div class="x-panel-tr">
				<div class="x-panel-tc"></div>
			</div>
		</div>
		<div class="x-panel-bwrap">
			<div class="x-panel-ml">
				<div class="x-panel-mr">
					<div class="x-panel-mc">
						<div style="width: 362px; height: 126px;" class="x-panel-body">
							<form id="loginForm" class="x-form" method="post" action="login.php?loginform=true">
								<input value="login" class="x-form-hidden x-form-field" size="20" autocomplete="on" name="cms_action" type="hidden" />
									<div class="x-form-item" tabindex="-1">
										<label for="loginField" style="width: 90px;" class="x-form-item-label">'.$language->getMessage(MESSAGE_PAGE_LOGIN).':</label>
										<div class="x-form-element" style="padding-left: 95px;">
											<input style="width: 240px;" class="x-form-text x-form-field" autocomplete="on" id="loginField" name="login" type="text" value="'.(isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '').'" />
										</div>
										<div class="x-form-clear-left"></div>
									</div>
									<div class="x-form-item" tabindex="-1">
										<label for="passField" style="width: 90px;" class="x-form-item-label">'.$language->getMessage(MESSAGE_PAGE_PASSWORD).':</label>
										<div class="x-form-element" style="padding-left: 95px;">
											<input style="width: 240px;" class="x-form-text x-form-field" autocomplete="on" id="passField" name="pass" type="password" value="'.(isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : '').'" />
										</div>
										<div class="x-form-clear-left"></div>
									</div>
									<div class="x-form-item" tabindex="-1">
										<div class="x-form-element" style="padding-left: 95px;">
											<label for="rememberField" class="x-form-item-label" style="width: 240px;">
												<input value="1" class="x-form-checkbox x-form-field" size="20" autocomplete="on" id="rememberField" name="permanent" type="checkbox" />
												'.$language->getMessage(MESSAGE_PAGE_REMEMBER_ME).'
											</label>
										</div>
										<div class="x-form-clear-left"></div>
									</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="x-panel-bl">
				<div class="x-panel-br">
					<div class="x-panel-bc">
						<div class="x-panel-footer">
							<div class="x-panel-btns-ct">
								<div class="x-panel-btns x-panel-btns-center" id="formsButton">
									<table cellspacing="0">
										<tbody>
											<tr>
												<td class="x-panel-btn-td">
													<div id="submitButton"></div>
												</td>
												<td class="x-panel-btn-td">
													<div id="cancelButton"></div>
												</td>
											</tr>
										</tbody>
									</table>
									<div class="x-clear"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
	//send content
	$view->setContent($content);
	$view->show(CMS_view::SHOW_HTML);
}
?>