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
// $Id: itemactions.php,v 1.5 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Presents one module formular destinations to edit
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);
//add polymod requirement
require_once(PATH_MODULES_FS."/polymod.php");

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_FORM_ERROR_MALFORMED_FIELD", 145);
define("MESSAGE_PAGE_FIELD_ACTIONS", 162);
define("MESSAGE_BUTTON_ADD", 260);
define("MESSAGE_PAGE_DELETE", 8);
define("MESSAGE_PAGE_TREEH1", 1049);
define("MESSAGE_PAGE_CHOOSE", 1132);

/**
 * Message of this module
 */
define("MESSAGE_PAGE_TITLE", 36);
define("MESSAGE_PAGE_EMPTY", 6);
define("MESSAGE_PAGE_FIELD_ACTION_TYPE", 38);
define("MESSAGE_ACTION_DISPLAY_TEXT", 50);
define("MESSAGE_ACTION_REDIRECT_TO_PAGE", 51);
define("MESSAGE_PAGE_DELETE_CONFIRM", 9);
define("MESSAGE_PAGE_SUBTITLE_CURRENT_ACTIONS", 53);
define("MESSAGE_PAGE_SUBTITLE_ADD_ACTIONS", 54);
define("MESSAGE_ACTION_ENTER_EMAILS", 55);
define("MESSAGE_ACTION_DISPLAYED_TEXT", 57);
define("MESSAGE_ACTION_FORM_FIELD", 58);
define("MESSAGE_ACTION_LINK_TO_CSV_FILE", 59);
define("MESSAGE_ACTION_LINK_TO_CSV_FILE_WHEN_EXISTS", 60);
define("MESSAGE_ACTION_NO_MAIL_FIELD_FOUNDED", 61);
define("MESSAGE_ACTION_ENTER_HEADER_MESSAGE", 56);
define("MESSAGE_ACTION_ENTER_FOOTER_MESSAGE", 70);
define("MESSAGE_ACTION_ENTER_SUBJECT_MESSAGE", 71);
define("MESSAGE_ACTION_DOWNLOAD_CSV_FILE", 72);
define("MESSAGE_PAGE_RESET_DB_CONFIRM", 73);
define("MESSAGE_PAGE_RESET_DB", 74);
define("MESSAGE_ACTION_NO_USERID_FIELD_FOUNDED", 76);
define("MESSAGE_ACTION_NO_PASS_FIELD_FOUNDED", 77);
define("MESSAGE_PAGE_FIELD_LOGIN", 78);
define("MESSAGE_PAGE_FIELD_PASSWORD", 79);
define("MESSAGE_ACTION_AUTH_DISPLAYED_TEXT", 80);
define("MESSAGE_PAGE_FIELD_REMEMBERME", 81);
define("MESSAGE_ACTION_NO_REMEMBER_FIELD_FOUNDED", 82);
define("MESSAGE_ACTION_ENTER_EMAIL_SENDER", 88);
define("MESSAGE_ACTION_DOWNLOAD_CSV_FILE_WITH_DATE", 89);
define("MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION", 1705);

//CHECKS
$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

if (!$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

$form = new CMS_forms_formular($_POST["form"]);

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Language
if ($_REQUEST["items_language"] != '') {
	$_SESSION["cms_context"]->setSessionVar("items_language", $_REQUEST["items_language"]);
} elseif ($_SESSION["cms_context"]->getSessionVar("items_language") == '' || is_object($_SESSION["cms_context"]->getSessionVar("items_language"))) {
	$_SESSION["cms_context"]->setSessionVar("items_language", $cms_module->getParameters("default_language"));
}
$items_language = new CMS_language($_SESSION["cms_context"]->getSessionVar("items_language"));

$separator = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? "\xa7\xa7" : "\xc2\xa7\xc2\xa7";

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	
	$action = new CMS_forms_action($_POST["item"]);
	switch ($_POST["type"]) {
		case CMS_forms_action::ACTION_ALREADY_FOLD:
		case CMS_forms_action::ACTION_FORMNOK :
		case CMS_forms_action::ACTION_FORMOK :
			/*if ($action->getString('value') == $_POST["value"] && $action->getString('value') == 'page' && !sensitiveIO::IsPositiveInteger($_POST["text"])) {
				$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, array($cms_language->getMessage(MESSAGE_PAGE_TREEH1)));
			}
			if ($action->getString('value') != $_POST["value"]) {
				//reset field content
				$_POST["text"] = '';
			}*/
			//set page redirection value
			if ($action->getString('value') == $_POST["value"] && $action->getString('value') == 'page') {
				//redirection
				//for compatibility with old versions of module
				if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
					$redirect = new CMS_href();
					$redirect->setInternalLink($action->getString('text'));
					$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
				} else {
					$redirect = new CMS_href($action->getString('text'));
				}
				$redirectlinkDialog = new CMS_dialog_href($redirect);
				$redirectlinkDialog->doPost(MOD_CMS_FORMS_CODENAME, $action->getID());
				$redirect = $redirectlinkDialog->getHref();
				$_POST["text"] = $redirect->getTextDefinition();
			}
			if ($action->getString('value') != $_POST["value"]) {
				//reset field content
				$_POST["text"] = '';
			}
		break;
		case CMS_forms_action::ACTION_FIELDEMAIL :
			$sender = (isset($_POST["sender"]) && sensitiveIO::isValidEmail($_POST["sender"]) && APPLICATION_POSTMASTER_EMAIL != $_POST["sender"]) ? $separator.$_POST["sender"] : '';
			//aggregate email text fields
			$_POST["text"] = strip_tags($_POST["subject"].$separator.$_POST["header"].$separator.$_POST["footer"]).$sender;
		break;
		/*case CMS_forms_action::ACTION_FILE :
			//link to download file
			
		break;*/
		case CMS_forms_action::ACTION_EMAIL :
			//enter emails
			if ($_POST["value"]) {
				$emails = array_map('trim',preg_split("/[,;]+/",$_POST["value"]));
				$ok = true;
				/*foreach($emails as $email) {
					//value can be a valid email or a $_SESSION value
					if (!sensitiveIO::isValidEmail($email) && io::strpos($email, '$_SESSION') === false) {
						$ok = false;
					}
				}*/
				if (!$ok) {
					$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, array($cms_language->getMessage(MESSAGE_ACTION_ENTER_EMAILS, false, MOD_CMS_FORMS_CODENAME)));
				} else {
					$_POST["value"] = implode('; ', $emails);
				}
			}
			$sender = (isset($_POST["sender"]) && sensitiveIO::isValidEmail($_POST["sender"]) && APPLICATION_POSTMASTER_EMAIL != $_POST["sender"]) ? $separator.$_POST["sender"] : '';
			//aggregate email text fields
			$_POST["text"] = strip_tags($_POST["subject"].$separator.$_POST["header"].$separator.$_POST["footer"]).$sender;
		break;
		case CMS_forms_action::ACTION_AUTH :
			//login / pass fields
			if ($_POST["value"]) {
				if (!$_POST["value"]['pass'] || !$_POST["value"]['login']) {
					$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, array($cms_language->getMessage(MESSAGE_ACTION_FORM_FIELD, false, MOD_CMS_FORMS_CODENAME)));
				}
				$_POST["value"] = implode(';', $_POST["value"]);
			}
		break;
		case CMS_forms_action::ACTION_DB :
		default:
			//NOTHING HERE
		break;
	}
	$action->setInteger('form', $form->getID());
	$action->setInteger('type', $_POST["type"]);
	$action->setString('value', $_POST["value"]);
	$action->setString('text', $_POST["text"]);
	
	// Save data
	if (!$cms_message && $action->writeToPersistence()) {
		//reload form
		$form = new CMS_forms_formular($_POST["form"]);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	break;
case "addaction":
	//checks and assignments
	$cms_message = "";
	if ($_POST["type"]) {
		$action = new CMS_forms_action();
		
		$action->setInteger('form', $form->getID());
		$action->setInteger('type', $_POST["type"]);
		
		// Save data
		if (!$cms_message && $action->writeToPersistence()) {
			//reload form
			$form = new CMS_forms_formular($_POST["form"]);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	}
	break;
case "delete":
	//checks and assignments
	$cms_message = "";
	$action = new CMS_forms_action($_POST["item"]);
	if ($action->destroy()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	break;
case "reset":
	$cms_message = "";
	if ($form->resetRecords()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	//reload form
	$form = new CMS_forms_formular($_POST["form"]);
	break;
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false, MOD_CMS_FORMS_CODENAME)." :: ".$form->getAttribute('name'));
$dialog->setBacklink("items.php");

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$actionsTypesLabels = CMS_forms_action::getAllTypes();
$formActions = $form->getActions();

if (sizeof($formActions)) {
	$content .= '
	<!-- Current Actions -->
	<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_CURRENT_ACTIONS, false, MOD_CMS_FORMS_CODENAME).'</dialog-title>
	<br /><br />
	<table width="700" border="0" cellpadding="2" cellspacing="1">
	<tr>
		<th colspan="3" class="admin" width="100%" style="text-align:left;">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTION_TYPE, false, MOD_CMS_FORMS_CODENAME).'</th>
		<th colspan="2" class="admin">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
	</tr>';
	
	$count = 0;
	foreach ($formActions as $item) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$content .= '
			<tr>
				<td class="' . $td_class . '">'.$cms_language->getMessage($actionsTypesLabels[$item->getInteger('type')], false, MOD_CMS_FORMS_CODENAME).'</td>
				<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
				<input type="hidden" name="cms_action" value="validate" />
				<input type="hidden" name="form" value="'.$form->getID().'" />
				<input type="hidden" name="item" value="'.$item->getID().'" />
				<input type="hidden" name="type" value="'.$item->getInteger('type').'" />
				<td class="' . $td_class . '">';
				switch($item->getInteger('type')) {
					case CMS_forms_action::ACTION_ALREADY_FOLD:
					case CMS_forms_action::ACTION_FORMNOK :
					case CMS_forms_action::ACTION_FORMOK :
						//select between text message or page redirection
						$pageSelected = ($item->getString('value') == 'page') ? ' selected="selected"':'';
						$content .= '
							<select name="value" class="admin_input_text" onchange="submit();">
								<option value="text">'.$cms_language->getMessage(MESSAGE_ACTION_DISPLAY_TEXT, false, MOD_CMS_FORMS_CODENAME).'</option>
								<option value="page"'.$pageSelected.'>'.$cms_language->getMessage(MESSAGE_ACTION_REDIRECT_TO_PAGE, false, MOD_CMS_FORMS_CODENAME).'</option>
							</select>';
					break;
					case CMS_forms_action::ACTION_FIELDEMAIL :
						//select form field
						//enter emails
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_FORM_FIELD, false, MOD_CMS_FORMS_CODENAME).' :<br />';
							$fields = $form->getFields(true);
							$fieldscontent = '';
							foreach ($fields as $fieldID => $field) {
								if ($field->getAttribute('type') == 'email' || $field->getAttribute('type') == 'select') {
									$selected = ($field->getID() == $item->getString('value')) ? ' selected="selected"':'';
									$fieldscontent .= '<option value="'.$field->getID().'"'.$selected.'>'.$field->getAttribute('label').'</option>';
								}
							}
							if ($fieldscontent) {
								$content .= '
								<select name="value" class="admin_input_text">
									<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>'
									.$fieldscontent.
								'</select>';
							} else {
								$content .= $cms_language->getMessage(MESSAGE_ACTION_NO_MAIL_FIELD_FOUNDED, false, MOD_CMS_FORMS_CODENAME);
							}
						$content .= '</small>';
					break;
					case CMS_forms_action::ACTION_AUTH :
						//select form fields
						$values = explode(';',$item->getString('value'));
						//enter login field
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_FORM_FIELD, false, MOD_CMS_FORMS_CODENAME).' :</small>';
						$content .= '<table border="0" cellpadding="1" cellspacing="1">
							<tr>
								<td class="admin" align="right"><small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LOGIN, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						$fields = $form->getFields(true);
						$fieldscontent = '';
						foreach ($fields as $fieldID => $field) {
							if ($field->getAttribute('type') == 'text') {
								$selected = ($field->getID() == $values[0]) ? ' selected="selected"':'';
								$fieldscontent .= '<option value="'.$field->getID().'"'.$selected.'>'.$field->getAttribute('label').'</option>';
							}
						}
						if ($fieldscontent) {
							$content .= '
							<td class="admin">
								<select name="value[login]" class="admin_input_text">
									<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>'
									.$fieldscontent.
								'</select>
							</td>';
						} else {
							$content .= '<td class="admin"><small>'.$cms_language->getMessage(MESSAGE_ACTION_NO_USERID_FIELD_FOUNDED, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						}
						//password field
						$content .= '
						</tr>
						<tr>
							<td class="admin" align="right"><small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PASSWORD, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						$fieldscontent = '';
						foreach ($fields as $fieldID => $field) {
							if ($field->getAttribute('type') == 'pass') {
								$selected = ($field->getID() == $values[1]) ? ' selected="selected"':'';
								$fieldscontent .= '<option value="'.$field->getID().'"'.$selected.'>'.$field->getAttribute('label').'</option>';
							}
						}
						if ($fieldscontent) {
							$content .= '
						<td class="admin">
							<select name="value[pass]" class="admin_input_text">
								<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>'
								.$fieldscontent.
							'</select>
						</td>';
						} else {
							$content .= '<td class="admin"><small>'.$cms_language->getMessage(MESSAGE_ACTION_NO_PASS_FIELD_FOUNDED, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						}
						//remember me field
						$content .= '
						</tr>
						<tr>
							<td class="admin" align="right"><small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REMEMBERME, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						$fieldscontent = '';
						foreach ($fields as $fieldID => $field) {
							if ($field->getAttribute('type') == 'checkbox') {
								$selected = ($field->getID() == $values[2]) ? ' selected="selected"':'';
								$fieldscontent .= '<option value="'.$field->getID().'"'.$selected.'>'.$field->getAttribute('label').'</option>';
							}
						}
						if ($fieldscontent) {
							$content .= '
						<td class="admin">
							<select name="value[rememberme]" class="admin_input_text">
								<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>'
								.$fieldscontent.
							'</select>
						</td>';
						} else {
							$content .= '<td class="admin"><small>'.$cms_language->getMessage(MESSAGE_ACTION_NO_REMEMBER_FIELD_FOUNDED, false, MOD_CMS_FORMS_CODENAME).'</small></td>';
						}
						$content .= '</tr></table>';
					break;
					case CMS_forms_action::ACTION_DB :
						//link to download file
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_LINK_TO_CSV_FILE, false, MOD_CMS_FORMS_CODENAME).' :<br />';
						if ($form->hasRecords()) {
							$content .= '<a href="csv.php?form='.$form->getID().'" onclick="this.href = this.href + \'&amp;withDate=\' + (document.getElementById(\'withDate\').checked ? 1:0); return true;" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_ACTION_DOWNLOAD_CSV_FILE, false, MOD_CMS_FORMS_CODENAME).'</a>
								<br /><label for="withDate"><input type="checkbox" name="withDate" id="withDate" value="1" checked="checked" />&nbsp;'.$cms_language->getMessage(MESSAGE_ACTION_DOWNLOAD_CSV_FILE_WITH_DATE, false, MOD_CMS_FORMS_CODENAME).'</label>
							';
						} else {
							$content .= $cms_language->getMessage(MESSAGE_ACTION_LINK_TO_CSV_FILE_WHEN_EXISTS, false, MOD_CMS_FORMS_CODENAME);
						}
						$content .= '</small>';
					break;
					case CMS_forms_action::ACTION_EMAIL :
						//enter emails
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_ENTER_EMAILS, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<textarea cols="35" rows="10" name="value" class="admin_input_text">'.$item->getString('value').'</textarea>';
					break;
					default:
						//NOTHING HERE
						$content .= '&nbsp;';
					break;
				}
		$content .= '
				</td>
				<td class="' . $td_class . '">';
				switch($item->getInteger('type')) {
					case CMS_forms_action::ACTION_ALREADY_FOLD:
					case CMS_forms_action::ACTION_FORMNOK :
					case CMS_forms_action::ACTION_FORMOK :
						//display text field or page number selection
						if ($item->getString('value') == 'page') {
							//display page selection field
							//build tree link
							/*$grand_root = CMS_tree::getRoot();
							$href = PATH_ADMIN_SPECIAL_TREE_WR;
							$href .= '?root='.$grand_root->getID();
							$href .= '&amp;heading='.$cms_language->getMessage(MESSAGE_PAGE_TREEH1);
							$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('page_redirection_".$item->getID()."').value = '%s';self.close();");
							$href .= '&encodedPageLink='.base64_encode('false');
							$pageValue = (sensitiveIO::isPositiveInteger($item->getString('text'))) ? $item->getString('text') : '';
							$urlValue = (!sensitiveIO::isPositiveInteger($item->getString('text'))) ? $item->getString('text') : '';
							$treeLink = '
										<a href="'.$href.'" class="admin" target="_blank">
										<img src="'.PATH_ADMIN_IMAGES_WR. '/picto-arbo.gif" align="absmiddle" border="0" /></a>';
							$content .= '<small>'.$cms_language->getMessage(MESSAGE_PAGE_TREEH1).' : <input type="text" name="text" id="page_redirection_'.$item->getID().'" class="admin_input_text" size="5" maxlength="5" value="'.$pageValue.'" /> '.$treeLink.'<br />
							ou l\'url : <input type="text" name="url_redirection_'.$item->getID().'" value="'.$urlValue.'" class="admin_input_text" /></small>';*/
							//for compatibility with old versions of module
							if (sensitiveIO::isPositiveInteger($item->getString('text'))) {
								$redirect = new CMS_href();
								$redirect->setInternalLink($item->getString('text'));
								$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
							} else {
								$redirect = new CMS_href($item->getString('text'));
							}
							$redirectlinkDialog = new CMS_dialog_href($redirect);
							$linkOptions = array (
								'label' 		=> false,				// Link has label ?
								'internal' 		=> true,				// Link can target an Automne page ?
								'external' 		=> true,				// Link can target an external resource ?
								'file' 			=> false,				// Link can target a file ?
								'destination'	=> false,				// Can select a destination for the link ?
							);
							$content .= '<small>'.$redirectlinkDialog->getHTMLFields($cms_language, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_EDITED, $linkOptions).'</small>';
						} else {
							//display text field
							$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_DISPLAYED_TEXT, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
							<textarea cols="35" rows="5" name="text" class="admin_input_text">'.$item->getString('text').'</textarea>';
						}
					break;
					case CMS_forms_action::ACTION_AUTH :
						//display text field
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_AUTH_DISPLAYED_TEXT, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<textarea cols="35" rows="5" name="text" class="admin_input_text">'.$item->getString('text').'</textarea>';
					break;
					case CMS_forms_action::ACTION_FIELDEMAIL :
					case CMS_forms_action::ACTION_EMAIL :
						$texts = explode($separator, $item->getString('text'));
						//display subject field
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_ENTER_SUBJECT_MESSAGE, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<textarea cols="35" rows="2" name="subject" class="admin_input_text">'.$texts[0].'</textarea><br />';
						//display header text field
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_ENTER_HEADER_MESSAGE, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<textarea cols="35" rows="5" name="header" class="admin_input_text">'.$texts[1].'</textarea><br />';
						//display footer text field
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_ENTER_FOOTER_MESSAGE, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<textarea cols="35" rows="5" name="footer" class="admin_input_text">'.$texts[2].'</textarea><br />';
						//email sender (if none set, use postmaster email)
						$sender = (!isset($texts[3]) || !sensitiveIO::isValidEmail($texts[3])) ? APPLICATION_POSTMASTER_EMAIL : $texts[3];
						$content .= '<small>'.$cms_language->getMessage(MESSAGE_ACTION_ENTER_EMAIL_SENDER, false, MOD_CMS_FORMS_CODENAME).' :</small><br />
						<input type="text" name="sender" class="admin_input_text" style="width:100%;" value="'.io::htmlspecialchars($sender).'"/>';
					break;
					case CMS_forms_action::ACTION_DB :
					default:
						//NOTHING HERE
						$content .= '&nbsp;';
					break;
				}
	$content .= '</td>
				<td class="' . $td_class . '">';
					if ($item->getInteger('type') != CMS_forms_action::ACTION_DB) {
						$content .= '
						<input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />';
					}
	$content .= '</td>
				</form>
				<td class="'.$td_class.'">';
					if ($item->getInteger('type') == CMS_forms_action::ACTION_FIELDEMAIL
						|| $item->getInteger('type') == CMS_forms_action::ACTION_EMAIL
						/*|| $item->getInteger('type') == CMS_forms_action::ACTION_FILE*/
						|| $item->getInteger('type') == CMS_forms_action::ACTION_AUTH ) {
						$content .= '
						<table border="0" cellpadding="2" cellspacing="0">
						<tr>
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\'' . str_replace("'", "\'", $cms_language->getMessage(MESSAGE_PAGE_DELETE_CONFIRM, array($cms_language->getMessage($actionsTypesLabels[$item->getInteger('type')], false, MOD_CMS_FORMS_CODENAME)), MOD_CMS_FORMS_CODENAME)) . '\')">
							<input type="hidden" name="cms_action" value="delete" />
							<input type="hidden" name="form" value="'.$form->getID().'" />
							<input type="hidden" name="item" value="'.$item->getID().'" />
							<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_DELETE, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>
						</tr>
						</table>';
					} elseif ($item->getInteger('type') == CMS_forms_action::ACTION_DB && $form->hasRecords()) {
						$content .= '
						<table border="0" cellpadding="2" cellspacing="0">
						<tr>
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\'' . str_replace("'", "\'", $cms_language->getMessage(MESSAGE_PAGE_RESET_DB_CONFIRM, array($form->getAttribute('name')), MOD_CMS_FORMS_CODENAME)) . '\')">
							<input type="hidden" name="cms_action" value="reset" />
							<input type="hidden" name="form" value="'.$form->getID().'" />
							<input type="hidden" name="item" value="'.$item->getID().'" />
							<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_RESET_DB, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>
						</tr>
						</table>';
					} else {
						$content .= '&nbsp;';
					}
	$content .= '
				</td>
			</tr>';
	}
	$content .= '</table><br /><br />';
}
// Add new action
$content .= '
<!-- Add Actions -->
<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_ADD_ACTIONS, false, MOD_CMS_FORMS_CODENAME).'</dialog-title>
<br /><br />
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
<input type="hidden" name="cms_action" value="addaction" />
<input type="hidden" name="form" value="'.$form->getID().'" />
<select name="type" class="admin_input_text">
	<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
foreach ($actionsTypesLabels as $type => $label) {
	if ($type != CMS_forms_action::ACTION_DB &&
		$type != CMS_forms_action::ACTION_ALREADY_FOLD &&
		$type != CMS_forms_action::ACTION_FORMNOK &&
		$type != CMS_forms_action::ACTION_FORMOK) {
		if ($type != CMS_forms_action::ACTION_AUTH || ($type == CMS_forms_action::ACTION_AUTH && !sizeof($form->getActionsByType(CMS_forms_action::ACTION_AUTH)))) {
			$content .= '<option value="'.$type.'">'.$cms_language->getMessage($label, false, MOD_CMS_FORMS_CODENAME).'</option>';
		}
	}
}
$content .= '
</select>
<input type="submit" class="admin_input_admin_lightgreybg" value="'.$cms_language->getMessage(MESSAGE_BUTTON_ADD).'" />
</form>

<br />
'.$cms_language->getMessage(MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION, array($cms_language->getDateFormatMask(),$cms_language->getDateFormatMask(),$cms_language->getDateFormatMask())).'
';

$dialog->setContent($content);
$dialog->show();
?>