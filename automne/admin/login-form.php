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
// $Id: login-form.php,v 1.5 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Login form
  * Manages the login of users. Creates login form.
  *
  * @package Automne
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

switch ($cms_action) {
case "login":
	$permanent = isset($_POST["permanent"]) ? $_POST["permanent"] : 0;
	$cms_context = new CMS_context($_POST["login"], $_POST["pass"], $permanent, $_POST["atm-token"]);
	//CMS_grandFather::log('Login ok1 (user : '.$cms_context->getUserId().')');
	if (!$cms_context->hasError() && ($cms_user = $cms_context->getUser()) && $cms_user->hasAdminAccess()) {
		//CMS_grandFather::log('Login ok2 (user : '.$cms_context->getUserId().')');
		$_SESSION["cms_context"] = $cms_context;
		//launch the daily routine in case it's not in the cron
		CMS_module_standard::processDailyRoutine();
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
		
		//then set context, remove login window and load Automne interface
		$jscontent = '/*remove event closeAndBack on window*/
		Ext.WindowMgr.get(\'loginWindow\').un(\'beforeclose\', Ext.WindowMgr.get(\'loginWindow\').closeAndBack);
		/*add event to load Automne interface after close*/
		Ext.WindowMgr.get(\'loginWindow\').on(\'close\', Automne.load.createDelegate(this, ['.sensitiveIO::jsonEncode($userSessionsInfos).']));
		/*display welcome message*/
		Automne.message.show(\''.sensitiveIO::sanitizeJSString($welcome).'\');
		try {delete Ext.Element.cache[\'loginField\'];} catch (e) {}
		';
		//add all JS locales
		$jscontent .= CMS_context::getJSLocales();
		$jscontent .= '
		/*show front page in tab*/
		Automne.tabPanels.getActiveTab().reload();
		/*close login window*/
		Ext.WindowMgr.get(\'loginWindow\').close();';
		//eval content into parent
		$jscontent = '
		try {delete parent.Ext.Element.cache[\'loginField\'];} catch (e) {}
		parent.eval(\''.sensitiveIO::sanitizeJSString($jscontent, true).'\');';
		$view->addJavascript($jscontent);
		$view->show(CMS_view::SHOW_HTML);
	} else {
		//reset session (start fresh)
		session_destroy();
		CMS_view::redirect($_SERVER['SCRIPT_NAME'].'?cms_action=wrongcredentials', true, 301);
	}
	break;
	case 'wrongcredentials':
		//display error login window on top of login form
		$loginError = "
		parent.Automne.message.popup({
			msg: '{$language->getJsMessage(MESSAGE_ERROR_LOGIN_INCORRECT)}',
			buttons: Ext.MessageBox.OK,
			icon: Ext.MessageBox.ERROR,
			fn:function() {
				Ext.fly('loginField').dom.select();
			}
		});";
	break;
}
//Send Login form frame window (in which login form is displayed)
//set main and ext CSS
$view->addCSSFile('ext');
$view->addCSSFile('main');
if (SYSTEM_DEBUG) {
	$view->addCSSFile('debug');
}
$view->addJSFile('ext');
if (SYSTEM_DEBUG) {
	$view->addJSFile('debug');
}
$view->addJSFile('codemirror');
$view->addJSFile('main');

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
					parent.Ext.MessageBox.show({
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
		if (parent.Ext && parent.Ext.getCmp('loginWindow')) {
			var loginWindow = parent.Ext.getCmp('loginWindow');
			loginWindow.body.unmask();
		}
		
		//set enter keymap
		var map = new Ext.KeyMap("loginForm", {
		    key: 		Ext.EventObject.ENTER,
		    fn: 		loginForm.doSubmit,
			scope:		loginForm
		});
		setTimeout(function(){
			//put focus on the first login field
			var field = Ext.get('loginField');
			if (field) {
				if (field.dom.value){
					field.dom.select();
				} else {
					field.focus()
				}
			}
		}, 100);
		//display login error window if any
		{$loginError}
	});
END;
$view->addJavascript($jscontent);
//set form HTML
$content = '<div class="x-panel x-form-label-left" style="width: 374px;">
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
						<form id="loginForm" class="x-form" method="post" action="'.$_SERVER['SCRIPT_NAME'].'">
							<input name="cms_action" value="login" type="hidden" />
							<input name="atm-token" value="'.CMS_context::getToken('login').'" type="hidden" />
							<div class="x-form-item" tabindex="-1">
								<label for="loginField" style="width: 90px;" class="x-form-item-label">'.$language->getMessage(MESSAGE_PAGE_LOGIN).':</label>
								<div class="x-form-element" style="padding-left: 95px;">
									<input style="width: 240px;" class="x-form-text x-form-field" autocomplete="on" id="loginField" name="login" type="text" value="'.(isset($_POST['login']) ? io::htmlspecialchars($_POST['login']) : '').'" />
								</div>
								<div class="x-form-clear-left"></div>
							</div>
							<div class="x-form-item" tabindex="-1">
								<label for="passField" style="width: 90px;" class="x-form-item-label">'.$language->getMessage(MESSAGE_PAGE_PASSWORD).':</label>
								<div class="x-form-element" style="padding-left: 95px;">
									<input style="width: 240px;" class="x-form-text x-form-field" autocomplete="on" id="passField" name="pass" type="password" value="'.(isset($_POST['pass']) ? io::htmlspecialchars($_POST['pass']) : '').'" />
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
							<div class="x-panel-btns" id="formsButton">
								<div class="x-panel-fbar x-small-editor x-toolbar-layout-ct" style="width:110px;margin:auto;">
									<table cellspacing="0" class="x-toolbar-ct">
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
	</div>
</div>';
//send content
$view->setContent($content);
//remove errors from display
$view->getErrors(true);
//send datas to display
$view->show(CMS_view::SHOW_HTML);
?>