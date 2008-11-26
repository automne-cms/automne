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
// $Id: validation.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : validations
  * Handle all validations.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 223);
define("MESSAGE_PAGE_EDITORS", 224);
define("MESSAGE_PAGE_HELP", 225);
define("MESSAGE_PAGE_ACCEPT", 226);
define("MESSAGE_PAGE_REFUSE", 227);
define("MESSAGE_PAGE_TRANSFERTO", 228);
define("MESSAGE_PAGE_COMMENTS", 229);
define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT", 234);
define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY", 235);
define("MESSAGE_PAGE_ACTION_EMAIL_REFUSE_SUBJECT", 236);
define("MESSAGE_PAGE_ACTION_EMAIL_REFUSE_BODY", 237);
define("MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_SUBJECT", 238);
define("MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_BODY", 239);
define("MESSAGE_PAGE_ERROR_MODULE", 240);
define("MESSAGE_PAGE_ERROR_PROCESS", 241);

define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_CHOOSE", 1132);

//checks
if (!($_POST["validation_id"].$_GET["validation_id"])) {
	die("Data missing.");
    exit;
}

$validation = CMS_resourceValidationsCatalog::getValidationInstance($_POST["validation_id"].$_GET["validation_id"],$cms_user);
if (!is_a($validation, "CMS_resourceValidation")) {
	die("Invalid parameter.");
	exit;
}

$from=($_GET["validation_id"]) ? "get":"post";

//Action management
switch ($_POST["cms_action"]) {
case "validate":
	//ignore user abort to avoid interuption of process
	@ignore_user_abort(true);
	//ask the module to process the validation
	$mod = CMS_modulesCatalog::getByCodename($validation->getModuleCodename());
	if (is_a($mod, "CMS_module")) {
		if ($mod->processValidation($validation, $_POST["result"])) {
			//send the emails
			$languages = CMS_languagesCatalog::getAllLanguages();	
			$subjects = array();
			$bodies = array();
			switch ($_POST["result"]) {
			case VALIDATION_OPTION_ACCEPT:
				//send an email to all the editors
				$args = array($validation->getValidationLabel()." (ID : ".$validation->getResourceID().")", $mod->getLabel($cms_language), SensitiveIO::sanitizeHTMLString($_POST["comments"]));
				$editorsStack = $validation->getEditorsStack();
				$elements = $editorsStack->getElements();
				$users = array();
				foreach ($elements as $element) {
					$usr = CMS_profile_usersCatalog::getByID($element[0]);
					if (is_a($usr, 'CMS_profile_user') && !$usr->hasError()) {
						$users[] = $usr;
					}
				}
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY, $args);
				}
				break;
			case VALIDATION_OPTION_REFUSE:
				//send an email to all the editors
				$args = array($validation->getValidationLabel()." (ID : ".$validation->getResourceID().")", $mod->getLabel($cms_language), SensitiveIO::sanitizeHTMLString($_POST["comments"]));
				$editorsStack = $validation->getEditorsStack();
				$elements = $editorsStack->getElements();
				$users = array();
				foreach ($elements as $element) {
					$usr = CMS_profile_usersCatalog::getByID($element[0]);
					if (is_a($usr, 'CMS_profile_user') && !$usr->hasError()) {
						$users[] = $usr;
					}
				}
				foreach ($languages as $language) {
					$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_REFUSE_SUBJECT);
					$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_REFUSE_BODY, $args);
				}
				break;
			case VALIDATION_OPTION_TRANSFER:
				if ($_POST["validator"]) {
					//send an email to the transferred validator
					$args = array($cms_user->getFirstName()." ".$cms_user->getLastName(),
									$validation->getValidationLabel()." (ID : ".$validation->getResourceID().")",
									$mod->getLabel($cms_language),
									SensitiveIO::sanitizeHTMLString($_POST["comments"]));
					$users = array(CMS_profile_usersCatalog::getByID($_POST["validator"]));
					foreach ($languages as $language) {
						$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_SUBJECT);
						$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_BODY, $args);
					}
					break;
				}
			}
			$group_email = new CMS_emailsCatalog();
			$group_email->setUserMessages($users, $bodies, $subjects);
			$group_email->sendMessages();
			
			$log = new CMS_log();
			if ($validation->getModuleCodename() == MOD_STANDARD_CODENAME) {
				$res = $validation->getResource();
				$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION, $cms_user, MOD_STANDARD_CODENAME, $res->getStatus(), "", $res);
			}
			
			header('Location: validations.php?module='.$validation->getModuleCodename().'&editions='.$validation->getEditions().'&cms_message_id='.MESSAGE_OPERATION_DONE.'&'.session_name().'='.session_id());
			exit;
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_PROCESS);
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_MODULE);
	}
	break;
}

//grab the validation

$dialog = new CMS_dialog();

$backLink = ($from=="get") ? "javascript:window.history.go(-1)":"validations.php?module=".$validation->getModuleCodename()."&editions=".$validation->getEditions();

$dialog->setBackLink($backLink);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$td_class = "admin_darkgreybg";

$help_urls = $validation->getHelpUrls();
$content = '
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
<table border="0" cellpadding="2" cellspacing="2" width="100%">
	<tr>
		<th class="admin">&nbsp;</th>
		<th class="admin">ID</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
	</tr>
	<tr>
		<td class="'.$td_class.'" align="center">'.$validation->getStatusRepresentation().'</td>
		<td class="'.$td_class.'">'.$validation->getResourceID().'</td>
		<td class="'.$td_class.'">'.$validation->getValidationLabel().'</td>
		<td class="'.$td_class.'">
			<table border="0" cellpadding="0" cellspacing="2"><tr>';
				foreach ($help_urls as $label => $aHelp_url) {
					$content .= '
					<form action="'.$aHelp_url[0].'" method="post" target="'.$aHelp_url[1].'">
					<td class="'.$td_class.'"><input type="submit" class="admin_input_'.$td_class.'" value="'.$label.'" /></td>
					</form>';
				}
$content .= '</tr></table>
		</td>
	</tr>
</table>

<br />

<table border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
	<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_TITLE).'</th>
	<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_EDITORS).'</th>
</tr>
<tr>
	<td class="'.$td_class.'">';

//CHOICES
$content .= '
	<table border="0" width="100%" cellpadding="3" cellspacing="0">
	<form action="' .$_SERVER["SCRIPT_NAME"]. '" method="post" onSubmit="check();">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="validation_id" value="'.$validation->getID().'" />
	<tr>
		<td class="'.$td_class.'">
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
';
if ($validation->hasValidationOption(VALIDATION_OPTION_ACCEPT)) {
	$content .= '
			<tr>
				<td class="'.$td_class.'">
					<label for="accepValidation"><input id="accepValidation" class="admin_input_radio" type="radio" name="result" value="' .VALIDATION_OPTION_ACCEPT. '" checked="checked" /> '.$cms_language->getMessage(MESSAGE_PAGE_ACCEPT).'</label>
				</td>
			</tr>
	';
}
if ($validation->hasValidationOption(VALIDATION_OPTION_REFUSE)) {
	$content .= '
			<tr>
				<td class="'.$td_class.'">
					<label for="refuseValidation"><input id="refuseValidation" class="admin_input_radio" type="radio" name="result" value="' .VALIDATION_OPTION_REFUSE. '" /> '.$cms_language->getMessage(MESSAGE_PAGE_REFUSE).'</label>
				</td>
			</tr>
	' ;
}
if ($validation->hasValidationOption(VALIDATION_OPTION_TRANSFER)) {
	//transferred (if we have other validators than the current user)
	$validators = CMS_profile_usersCatalog::getValidators($validation->getModuleCodename());
	
	if (is_array($validators) && count($validators) > 1) {
		$content .= '
				<tr>
					<td class="'.$td_class.'">
						<label for="delegateValidation"><input id="delegateValidation" class="admin_input_radio" type="radio" name="result" value="' .VALIDATION_OPTION_TRANSFER. '" /> 
							'.$cms_language->getMessage(MESSAGE_PAGE_TRANSFERTO).'</label>
						<select name="validator" class="admin_input_text">
						<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>' ;
		foreach ($validators as $validator) {
			if ($validator->getUserID() != $cms_user->getUserID()) {
				$content .= '<option value="' .$validator->getUserID(). '">'.$validator->getLastName(). ' ' .$validator->getFirstName().'</option>' ;
			}
		}
		$content .= '</select></td></tr>' ;
	}
}

$content .= '
			</table>
		</td>
	</tr>
	<tr>
';

if ($validation->hasValidationOption(VALIDATION_OPTION_TRANSFER) ||
	($validation->hasValidationOption(VALIDATION_OPTION_REFUSE)
	&& sizeof($validators) > 1)) {
	$content .= '
			<td valign="top" class="'.$td_class.'">
				'.$cms_language->getMessage(MESSAGE_PAGE_COMMENTS).' : <br />
				<textarea name="comments" cols="50" rows="4" class="admin_long_textarea"></textarea>
			</td>
	';
}
$content .= '
		</tr>
		<tr>
			<td valign="bottom" align="right" class="'.$td_class.'">
			<input type="submit" class="admin_input_admin_darkgreybg" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>
		</form>
		</table>
		
		</td>
		<td class="'.$td_class.'" valign="top">';
		
		//EDITORS
$stack = $validation->getEditorsStack();
if (is_a($stack, "CMS_stack")) {
	$editions = $validation->getEditions();
	$all_editions = CMS_resourceStatus::getAllEditions();
	$users = array();
	foreach ($all_editions as $aEdition) {
		if ($editions & $aEdition) {
			$elements = $stack->getElementsWithOneValue($aEdition, 2);
			foreach ($elements as $user_edition) {
				$users[] = $user_edition[0];
			}
		}
	}
}

if (is_array($users) && sizeof($users)) {
	$users = array_unique($users);
	$count = 0;
	foreach ($users as $usr) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$tmp_user = CMS_profile_usersCatalog::getByID($usr) ;
		if (is_a($tmp_user, 'CMS_profile_user')) {
			$content .= $tmp_user->getFirstName()." " .$tmp_user->getLastName(). '<br />' ;
		}
	}
}
$content .= '
		</td>
	</tr>
</table>
	</td>
	</tr>
</table>
' ;

$dialog->setContent($content);
$dialog->show();
?>