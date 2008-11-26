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
// $Id: validations.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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

define("MESSAGE_PAGE_TITLE", 211);
define("MESSAGE_PAGE_NO_MORE_VALIDATIONS", 215);
define("MESSAGE_PAGE_BATCH_VALIDATIONS", 216);
define("MESSAGE_PAGE_POSITIVEVALIDATION", 219);
define("MESSAGE_PAGE_CHECK_ALL", 220);
define("MESSAGE_PAGE_UNCHECK_ALL", 221);
define("MESSAGE_PAGE_ERROR_MODULE", 240);
define("MESSAGE_PAGE_ERROR_PROCESS", 241);
define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT", 234);
define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY", 235);
define("MESSAGE_PAGE_HEADING", 218);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_FIELD_VIEW", 11);
define("MESSAGE_PAGE_FIELD_VALIDATE", 1125);

//checks
if (!$_GET["module"] || !SensitiveIO::isPositiveInteger($_GET["editions"])) {
	die("Data missing.");
}

$cms_module = CMS_modulesCatalog::getByCodename(SensitiveIO::sanitizeAsciiString($_GET["module"]));
if ($cms_module->hasError()) {
	die("Unknown module");
}

if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($_GET["bookmark"]) {
	$_SESSION["cms_context"]->setBookmark($_GET["bookmark"]);
} else {
	$_SESSION["cms_context"]->setBookmark(1);
}

$moduleStandard = ($_GET["module"]==MOD_STANDARD_CODENAME) ? true:false;

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//ask the module to process the validations
	$mod = CMS_modulesCatalog::getByCodename($_GET["module"]);
	if (is_a($mod, "CMS_module")) {
		
		if (is_array($_POST["validations_checked"]) && sizeof($_POST["validations_checked"])) {
			//augment the execution time, because things here can be quite lengthy
			@set_time_limit(9000);
			//ignore user abort to avoid interuption of process
			@ignore_user_abort(true);
			
			//verification needed to remove zero entry in array validations_checked returned by form
			$validationsChecked = array();
			foreach($_POST["validations_checked"] as $aValidationChecked) {
				if ($aValidationChecked) {
					$validationsChecked[]=$aValidationChecked;
				}
			}
			//then process all validations
			$action_msg = "";
			$count = 0;
			foreach ($validationsChecked as $validation_id) {
				if ($validation_id) {
					$validation = CMS_resourceValidationsCatalog::getValidationInstance($validation_id,$cms_user);
					$count++;
					$lastValidation = ($count == sizeof($validationsChecked)) ? true : false;
					if ($mod->processValidation($validation, VALIDATION_OPTION_ACCEPT, $lastValidation)) {
						//send the emails
						$languages = CMS_languagesCatalog::getAllLanguages();
						$subjects = array();
						$bodies = array();
						$args = array($validation->getValidationLabel()." (ID : ".$validation->getResourceID().")", $mod->getLabel($cms_language), "");
						$editorsStack = $validation->getEditorsStack();
						$elements = $editorsStack->getElements();
						$users = array();
						foreach ($elements as $element) {
							$usr = CMS_profile_usersCatalog::getByID($element[0]);
							if (!$usr->hasError()) {
								$users[] = $usr;
							}
						}
						foreach ($languages as $language) {
							$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT);
							$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY, $args);
						}
						$group_email = new CMS_emailsCatalog();
						$group_email->setUserMessages($users, $bodies, $subjects);
						$group_email->sendMessages();
						
						if ($validation->getModuleCodename() == MOD_STANDARD_CODENAME) {
							$log = new CMS_log();
							$res = $validation->getResource();
							$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION, $cms_user, MOD_STANDARD_CODENAME, $res->getStatus(), "", $res);
						}
					}
				}
			}
			header('Location: validations.php?module='.$_GET["module"].'&editions='.$_GET["editions"].'&cms_message_id='.MESSAGE_ACTION_OPERATION_DONE.'&'.session_name().'='.session_id());
			exit;
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_MODULE);
	}
}

//grab the validations and redirect to entry if no more
if (method_exists($cms_module, "getValidationByID") && method_exists($cms_module, "getValidationsInfoByEditions")) {
	//new validations system, more efficient
	$validations = $cms_module->getValidationsInfoByEditions($cms_user, $_GET["editions"]);
	$newValidationMethod=true;
} else {
	//old validations system, keeped for modules compatibility
	$validations = $cms_module->getValidationsByEditions($cms_user, $_GET["editions"]);
	$newValidationMethod=false;
	
	//Clean old DB validations
	CMS_resourceValidation::cleanOldValidations();
}

if (!is_array($validations) || !sizeof($validations)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_NO_MORE_VALIDATIONS."&".session_name()."=".session_id());
	exit;
}

$dialog = new CMS_dialog();
$dialog->setBackLink(PATH_ADMIN_SPECIAL_ENTRY_WR);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE)." : ".$validations[0]->getValidationTypeLabel());

if ($_GET["cms_message_id"] && SensitiveIO::isPositiveInteger($_GET["cms_message_id"]))	{
	$cms_message = $cms_language->getMessage($_GET["cms_message_id"]);
}

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$dialog->reloadTree();

if ($newValidationMethod) {
	$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();
	$bookmark = $_SESSION["cms_context"]->getBookmark($_GET["bookmark"]);
	$pages = ceil(sizeof($validations) / $records_per_page);
	$first_record = ($bookmark - 1) * $records_per_page;
	$content .='
	<dialog-pages maxPages="'.$pages.'">
		<dialog-pages-param name="module" value="'.$_GET["module"].'" />
		<dialog-pages-param name="editions" value="'.$_GET["editions"].'" />
	</dialog-pages><br />
	';
}

$content .= '
	<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th class="admin">&nbsp;</th>
			<th class="admin">ID</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_VALIDATE).'</th>
		</tr>
';

$count = 0;
$itemCount=0;
foreach ($validations as $validation) {
	$itemCount++;
	if (($itemCount>(($bookmark-1)*$records_per_page) && $itemCount<=($bookmark*$records_per_page)) || !$newValidationMethod) {
		
		//for the new validations system, get the complete validation object.
		if ($newValidationMethod) {
			$validation = $cms_module->getValidationByID($validation->getResourceID(),$cms_user, $_GET["editions"]);
		}
		
		$help_urls = $validation->getHelpUrls();
		
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$content .= '
			<tr>
				<td class="'.$td_class.'" align="center">'.$validation->getStatusRepresentation(false, $cms_user, $cms_module->getCodename(), $validation->getResourceID()).'</td>
				<td class="'.$td_class.'">'.$validation->getResourceID().'</td>
				<td class="'.$td_class.'">'.$validation->getValidationShortLabel().'</td>
				<td class="'.$td_class.'">
					<table border="0" cellpadding="0" cellspacing="2"><tr>
						<form action="validation.php" method="post">
						<input type="hidden" name="validation_id" value="'.$validation->getID().'" />
						<td class="'.$td_class.'" align="center"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_BUTTON_DETAIL).'" /></td>
						</form>';
						foreach ($help_urls as $label => $aHelp_url) {
							$content .= '
							<form action="'.$aHelp_url[0].'" method="post" target="'.$aHelp_url[1].'">
							<td class="'.$td_class.'"><input type="submit" class="admin_input_'.$td_class.'" value="'.$label.'" /></td>
							</form>';
						}
		$content .= '</tr></table>
				</td>
				<td class="'.$td_class.'" align="center"><input type="checkbox" value="'.$validation->getID().'" id="validations_'.$count.'" /></td>
			</tr>
		';
	}
}

$js = '
<script language="javascript">
	var boxChecked;
	function checkboxCheck() {
		for (var i=0; i<'.$count.'; i++) {
			var elementID = "validations_" + (i+1);
			if (document.getElementById(elementID).checked == true) {
				document.frm.elements[i].value = document.getElementById(elementID).value;
			} else {
				document.frm.elements[i].value = 0;
			}
		}
		return true;
	}
	
	function check_all() {
		boxChecked = (boxChecked==true) ? false:true;
		boxLabel = (boxChecked==true) ? \''.$cms_language->getMessage(MESSAGE_PAGE_UNCHECK_ALL).'\':\''.$cms_language->getMessage(MESSAGE_PAGE_CHECK_ALL).'\';
		for (var i=1; i<'.($count+1).'; i++) {
			var elementID = "validations_" + i;
			document.getElementById(elementID).checked = boxChecked;
			document.getElementById(\'boxChecker\').value = boxLabel;
		}
	}
</script>
';

$dialog->setJavascript($js);

$content .= '
	<form name="frm" action="'.$_SERVER["SCRIPT_NAME"].'?module='.$_GET["module"].'&amp;editions='.$_GET["editions"].'" method="post" onSubmit="checkboxCheck();">';
	foreach ($validations as $validation) {
		$content .= '<input type="hidden" value="0" name="validations_checked[]" />';
	}
$content .= '
	<input type="hidden" name="cms_action" value="validate" />
	<tr>
		<td colspan="5" class="admin">';
		if ($newValidationMethod) {
			$content .='
			<dialog-pages maxPages="'.$pages.'">
				<dialog-pages-param name="module" value="'.$_GET["module"].'" />
				<dialog-pages-param name="editions" value="'.$_GET["editions"].'" />
			</dialog-pages>
			';
		}
$content .='
		<br />'.$cms_language->getMessage(MESSAGE_PAGE_HEADING).'<br /></td>
	</tr>
	<tr>
		<td colspan="5" align="right">
			<input type="button" id="boxChecker" value="'.$cms_language->getMessage(MESSAGE_PAGE_CHECK_ALL).'" class="admin_input_submit" onClick="javascript:check_all()" /><br />
			<br />
			<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
		</td>
	</tr>
	</form>
</table>
';

$dialog->setContent($content);
$dialog->show();
?>