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
// $Id: template_row.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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

define("MESSAGE_PAGE_TITLE", 845);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_DEFINITION", 846);
define("MESSAGE_PAGE_TEXT", 849);
define("MESSAGE_PAGE_PREVIEW", 1013);
define("MESSAGE_PAGE_FIELD_ROWS_EXPLANATION", 1220);
define("MESSAGE_PAGE_NO_MODULE_RIGHT", 1293);
define("MESSAGE_PAGE_UNKNOWN_MODULE", 809);
define("MESSAGE_PAGE_FIELD_GROUPS", 837);
define("MESSAGE_PAGE_FIELD_GROUPS_NEW", 838);
define("MESSAGE_PAGE_FIELD_GROUPS_NO", 1336);
define("MESSAGE_BUTTON_SAVE", 952);
define("MESSAGE_BUTTON_SAVE_AND_QUIT", 1427);
define("MESSAGE_PAGE_FIELD_NO_RIGHTS_ON_NEW_GROUPS", 1442);

//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

$row = new CMS_row($_POST["row"]);
$all_groups = CMS_rowsCatalog::getAllGroups();
//Action management
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$_POST["label"] || !$_POST["definition"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		$row->setLabel($_POST["label"]);
		//get parsing message if any
		if (($return = $row->setDefinition($_POST["definition"])) !== false && $return !== true) {
			$cms_message .= $return;
		}
		//get modules and check users edit rights on it
		$modulesRow = $row->getModules();
		foreach ($modulesRow as $module) {
			if (!is_a($module, 'CMS_module')) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_MODULE)."\n";
			} elseif (!$cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_NO_MODULE_RIGHT, array($module->getLabel($cms_language)))."\n";
			}
		}
		if (!$cms_message) {
			//groups
			$row->delAllGroups();
			foreach ($all_groups as $aGroup) {
				if ($_POST["group_".$aGroup]) {
					$row->addGroup($aGroup);
				}
			}
			if ($_POST["newgroups"]) {
				$new_groups = array_map('trim',explode(";", $_POST["newgroups"]));
				if ($new_groups) {
					foreach ($new_groups as $ng) {
						$row->addGroup($ng);
					}
					if ($_POST['nouserrights']) {
						CMS_profile_usersCatalog::denyRowGroupsToUsers($new_groups);
					}
				}
			}
			// Save data
			$row->writeToPersistence();

			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row : ".$row->getLabel());
			if ($_POST['quit'] == 1) {
				header("Location: templates.php?currentOnglet=1&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
				exit;
			} else {
				//reload row and groups
				$row = new CMS_row($_POST["row"]);
				$all_groups = CMS_rowsCatalog::getAllGroups(false, true);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			}
		}
	}
	break;
}

$dialog = new CMS_dialog();
$dialog->setBackLink("templates.php?currentOnglet=1");
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
$dialog->addStopTab();
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($_POST["definition"]) {
	$definition = $_POST["definition"];
} else {
	$definition = $row->getDefinition();
	if (!$definition) {
		$definition = "<row>\n\n</row>";
	}
}
if ($_POST["label"]) {
	$label = $_POST["label"];
} else {
	$label = $row->getLabel();
}

$testPage = CMS_tree::getRoot();
$testCS = new CMS_moduleClientSpace_standard(0, 0);

$content = '
	'.$cms_language->getMessage(MESSAGE_PAGE_TEXT, array(APPLICATION_LABEL)).'<br />
	<br />
	<table border="0" cellpadding="3" cellspacing="2" width="100%">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" id="quit" name="quit" value="0" />
	<input type="hidden" id="editedrow" name="row" value="'.$row->getID().'" />
	<tr>
		<td class="admin" align="right" width="1" nowrap="nowrap"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'&nbsp;:</td>
		<td class="admin"><input type="text" size="60" class="admin_input_text" id="editedlabel" name="label" value="'.htmlspecialchars($label).'" /></td>
	</tr>';
	$content .= '
	<tr>
		<td class="admin" align="right" valign="top" width="1" nowrap="nowrap">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUPS).'&nbsp;:</td>
		<td class="admin">';
	//Row groups
	if(is_array($all_groups) && $all_groups){
		foreach ($all_groups as $aGroup) {
			$checked = ($row->belongsToGroup($aGroup)) ? ' checked="checked"' : '';
			$content .= '<input type="checkbox" class="admin_input_checkbox" name="group_'.$aGroup.'" id="group_'.$aGroup.'" value="1"'.$checked.' /><label for="group_'.$aGroup.'">'.$aGroup.'</label>&nbsp;';
		}
	} else {
		$content .= '-'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUPS_NO).'-';
	}
	$content .= '<br />'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUPS_NEW).' : <input type="text" class="admin_input_text" size="30" name="newgroups" />
		&nbsp;<label for="noUserRights"><input type="checkbox" class="admin_input_checkbox" name="nouserrights" value="1" id="noUserRights" />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_NO_RIGHTS_ON_NEW_GROUPS).'</label>
		</td>
	</tr>';
	// XML definition
	$content .= '
	<tr>
		<td class="admin" colspan="2">
			<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).' : <br />
			<textarea class="admin_textarea" onkeydown="return catchTab(this,event)" id="editeddefinition" name="definition" rows="30" cols="130" style="width:95%;">'.htmlspecialchars($definition).'</textarea>
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
$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_ROWS_EDITION_LABELS, PAGE_VISUALMODE_CLIENTSPACES_FORM, $row, array("language" => $cms_language, "user" => $cms_user, "request" => $_REQUEST));
if (sizeof($modulesCodeInclude)) {
	foreach ($modulesCodeInclude as $aModule => $aModuleRowsExplanation) {
		//if user has rights on module
		if ($cms_user->hasModuleClearance($aModule, CLEARANCE_MODULE_EDIT)) {
			$currentModule = CMS_modulesCatalog::getByCodename($aModule);
			$view = ($_POST["moduleExpl"] == $currentModule->getCodename()) ? 'block':'none';
			$content .= '
			<fieldset>
				<legend>
					<a href="#" onclick=" return switchExpl(\'expl_'.$currentModule->getCodename().'\');" class="admin" title="'.htmlspecialchars($cms_language->getMessage(MESSAGE_PAGE_FIELD_ROWS_EXPLANATION, array($currentModule->getLabel($cms_language)))).'">+ '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROWS_EXPLANATION, array($currentModule->getLabel($cms_language))).'</a>
				</legend>
				<br />
				<div id="expl_'.$currentModule->getCodename().'" style="display:'.$view.';">
				'.$aModuleRowsExplanation.'
				</div>
			</fieldset>';
		}
	}
	$content .= '<br /><br />';
}
if ($row->getID()) {
	$content .= '
		<b>'.$cms_language->getMessage(MESSAGE_PAGE_PREVIEW).' : </b><br /><br />
		<table border="1" cellpadding="3" cellspacing="0">
		<tr><td class="admin">
		' . $row->getData($cms_language, $testPage, $testCS, PAGE_VISUALMODE_CLIENTSPACES_FORM,false,false) . '
		</td></tr>
		</table>
	';
}

$dialog->setContent($content);
$dialog->show();
?>