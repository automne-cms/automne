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
// $Id: edit_template.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template row edition
  * Used to edit the rows that compose the client spaces contained in the page templates
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1088);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_DEFINITION", 846);
define("MESSAGE_PAGE_TEXT", 1089);
define("MESSAGE_PAGE_PRINTING", 1052);
define("MESSAGE_PAGE_FIELD_TEMPLATES_EXPLANATION", 1221);
define("MESSAGE_BUTTON_SAVE", 952);
define("MESSAGE_BUTTON_SAVE_AND_QUIT", 1427);

//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

if ($_REQUEST["template"]!='print') {
	$template = new CMS_pageTemplate($_REQUEST["template"]);
}
//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$_POST["label"] || !$_POST["definition"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		//definition parsing test
		$domdocument = new CMS_DOMDocument();
		try {
			$domdocument->loadXML($_POST["definition"]);
		} catch (DOMException $e) {
			$cms_message .= $e->getMessage();
		}
		if (!$cms_message) {
			if ($_REQUEST["template"]!='print') {
				$template->setLabel($_POST["label"]);
				$template->setDefinition($_POST["definition"]);
				$template->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel());
			} else {
				$filename = "print.xml";
				$templateFile = new CMS_file(PATH_TEMPLATES_FS."/".$filename);
				$templateFile->setContent($_POST["definition"]);
				$templateFile->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : Print template");
			}
			if ($_POST['quit'] == 1) {
				header("Location: templates.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
				exit;
			} else {
				//reload row and groups
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			}
		}
	}
	break;
}

$dialog = new CMS_dialog();
$dialog->setBackLink("templates.php");
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
$dialog->addStopTab();
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($_POST["definition"]) {
	$definition = $_POST["definition"];
} elseif ($_REQUEST["template"]=='print') {
	$file ="print.xml";
	$fp = fopen(PATH_TEMPLATES_FS."/".$file, 'rb');
	if (is_resource($fp)) {
		$definition = fread($fp, filesize(PATH_TEMPLATES_FS."/".$file));
		fclose($fp);
	} else {
		$definition = "<html>\n\n</html>";
	}
} else {
	$definition = $template->getDefinition();
	if (!$definition) {
		$definition = "<html>\n\n</html>";
	}
}
$tplLabel = ($_REQUEST["template"]!='print') ? htmlspecialchars($template->getLabel()):$cms_language->getMessage(MESSAGE_PAGE_PRINTING);
$content = '
	'.$cms_language->getMessage(MESSAGE_PAGE_TEXT, array(APPLICATION_LABEL)).'<br />
	<br />
	<table border="0" cellpadding="3" cellspacing="2" width="100%">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" id="quit" name="quit" value="0" />
	<input type="hidden" name="template" value="'.$_REQUEST["template"].'" />
	<tr>
		<td class="admin" align="right" width="1" nowrap="nowrap"><span class="admin_text_alert">*</span>&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'&nbsp;:</td>
		<td class="admin"><input type="text" size="30" class="admin_input_text" name="label" value="'.htmlspecialchars($tplLabel).'" /></td>
	</tr>
	<tr>
		<td class="admin" colspan="2">
			<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).'&nbsp;:<br />
			<textarea class="admin_textarea" onkeydown="return catchTab(this,event)" name="definition" rows="30" cols="130" style="width:95%;">'.htmlspecialchars($definition).'</textarea>
		</td>
	</tr>
	<tr>
		<td class="admin" colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_SAVE).'" />&nbsp;<input type="button" onclick="document.getElementById(\'quit\').value=1;submit();" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_SAVE_AND_QUIT).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
	<script type="text/javascript">
		function switchExpl(divID) {
			if (document.getElementById(divID).style.display==\'none\') {
				document.getElementById(divID).style.display=\'block\';
			} else {
				document.getElementById(divID).style.display=\'none\';
			}
			return false;
		}
	</script>
';

//include modules codes in output file
$modulesCodes = new CMS_modulesCodes();
$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_TEMPLATES_EDITION_LABELS, PAGE_VISUALMODE_CLIENTSPACES_FORM, $template, array("language" => $cms_language, "user" => $cms_user));
if (is_array($modulesCodeInclude) && $modulesCodeInclude) {
	foreach ($modulesCodeInclude as $aModule => $aModuleTemplateExplanation) {
		//if user has rights on module
		if ($cms_user->hasModuleClearance($aModule, CLEARANCE_MODULE_EDIT)) {
			$currentModule = CMS_modulesCatalog::getByCodename($aModule);
			$view = ($_POST["moduleExpl"] == $currentModule->getCodename()) ? 'block':'none';
			$content .= '
			<fieldset>
				<legend>
					<a href="#" onclick=" return switchExpl(\'expl_'.$currentModule->getCodename().'\');" class="admin" title="'.htmlspecialchars($cms_language->getMessage(MESSAGE_PAGE_FIELD_TEMPLATES_EXPLANATION, array($currentModule->getLabel($cms_language)))).'">+ '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TEMPLATES_EXPLANATION, array($currentModule->getLabel($cms_language))).'</a>
				</legend>
				<br />
				<div id="expl_'.$currentModule->getCodename().'" style="display:'.$view.';">
				'.$aModuleTemplateExplanation.'
				</div>
			</fieldset>';
		}
	}
	$content .= '<br /><br />';
}

$dialog->setContent($content);
$dialog->show();
?>