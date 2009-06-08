<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2007 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// | The license text is bundled with this package in the file            |
// | LICENSE-GPL, and is available at through the world-wide-web at       |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: modules_admin.php,v 1.3 2009/06/08 09:40:47 sebastien Exp $

/**
  * PHP page : modules admin
  * Used to manage modules
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1224);
define("MESSAGE_PAGE_TITLE_APPLICATIONS", 264);
define("MESSAGE_PAGE_CHOOSE", 1132);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_CHOOSE_MODULE", 1225);
define("MESSAGE_PAGE_CHOOSE_OBJECTS", 1226);
define("MESSAGE_PAGE_OBJECTS", 1227);
define("MESSAGE_PAGE_APPLICATION", 1228);
define("MESSAGE_PAGE_OBJECT", 1234);
define("MESSAGE_PAGE_FIELDS", 1235);
define("MESSAGE_PAGE_FIELD", 1236);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_RESOURCE",1230);
define("MESSAGE_PAGE_FIELD_RESOURCE_NONE",195);
define("MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY",1231);
define("MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY",1232);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_FIELD_TYPE", 1238);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 1277);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_FIELD_ORDER",1115);
define("MESSAGE_PAGE_SAVE_NEWORDER", 1183);
define("MESSAGE_PAGE_FIELD_EDITABLE", 1271);
define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN", 1276);
define("MESSAGE_ACTION_DELETE_FIELD_ERROR", 1278);
define("MESSAGE_ACTION_OBJECT_STRUCTURE", 1279);
define("MESSAGE_PAGE_FIELD_OBJECT_USEAGE", 1281);
define("MESSAGE_PAGE_FIELD_OBJECT_USED", 1282);
define("MESSAGE_PAGE_ACTION_DELETE_OBJECT_CONFIRM", 1323);
define("MESSAGE_ACTION_DELETE_OBJECT_ERROR", 1284);
define("MESSAGE_PAGE_FIELD_COMPOSED_LABEL", 1294);
define("MESSAGE_PAGE_MODULE_UNKNOWN", 809);
define("MESSAGE_PAGE_MODULE_NOPARAMETERS", 810);
define("MESSAGE_PAGE_PARAMETERS", 807);
define("MESSAGE_PAGE_YES", 1082);
define("MESSAGE_PAGE_NO", 1083);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_FIELD_NONE", 10);
define("MESSAGE_PAGE_ACTION_PARAMETERS", 807);
define("MESSAGE_PAGE_ACTION_MODULE_PARAMETERS", 808);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//load page objects and vars
$moduleCodename = ($_POST["moduleCodename"]) ? $_POST["moduleCodename"]:$_GET["moduleCodename"];
$objectID = ($_POST["object"]) ? $_POST["object"]:$_GET["object"];
$modules = CMS_modulesCatalog::getAll("label", false);
if ($moduleCodename) {
	$module = CMS_modulesCatalog::getByCodename($moduleCodename);
}

//Create page object
$dialog = new CMS_dialog();

$cms_message = "";
// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "validate_module":
	$new_parameters = array();
	foreach ($_POST as $label => $value) {
		if ($label != "cms_action" && $label != "action" && $label != "moduleCodename" && !strpos($label,'_contentType')) {
			if ($_POST[$label."_contentType"]) {
				$new_parameters[$label] = array($value,$_POST[$label."_contentType"]);
			} else {
				$new_parameters[$label] = $value;
			}
		}
	}
	if (sizeof($new_parameters)) {
		$module->setAndWriteParameters($new_parameters);
	}
	if ($_GET["module"]=='standard') {
		//$dialog->reloadAll();
	}
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	if ($_GET["module"]=='standard') {
		$parameters = $module->getParameters(false,true);
	} else {
		$parameters = $module->getParameters();
	}
break;
}

$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_APPLICATIONS)." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE),'picto_modules.gif');

//Show a list of all modules
if (!sizeof($modules)) {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
	$content .= '
	<form action="polymod_mod.php" method="post">
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form><br />';
} else {
	$content .= '
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
		'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE_MODULE).' :
		<select name="moduleCodename" class="admin_input_text" onchange="submit();">
			<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
			foreach ($modules as $aModule) {
				$selected = ($moduleCodename == $aModule->getCodename()) ? ' selected="selected"':'';
				if ($aModule->isPolymod()) {
					$content .= '<option value="'.$aModule->getCodename().'"'.$selected.' style="font-weight:bold;color:red;">'.$aModule->getLabel($cms_language).'</option>';
				} elseif ($aModule->hasParameters()) {
					$content .= '<option value="'.$aModule->getCodename().'"'.$selected.' style="font-weight:bold;">'.$aModule->getLabel($cms_language).'</option>';
				} else {
					$content .= '<option value="'.$aModule->getCodename().'"'.$selected.'>'.$aModule->getLabel($cms_language).'</option>';
				}
			}
		$content .= '
		</select>
	</form>
	<table border="0" cellpadding="2" cellspacing="2">
		<tr>';
		if (class_exists('CMS_polymod')) {
			$content .= '
			<form action="module.php" method="post">
			<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
			</form>';
		}
		if (is_object($module)) {
			$content .= '
			<form action="module.php" method="post">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
			</form>';
			// Polymod module parameters
			if ($module->isPolymod() && $module->hasParameters()) {
				$content .= '
				<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
				<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
				<input type="hidden" name="action" value="parameters" />
				<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_PARAMETERS).'" /></td>
				</form>';
			}
		}
		$content .= '
		</tr>
	</table>
	<br />';
}
if (is_object($module)) {
	if ($module->isPolymod()) {
		//all polymod management is in another file
		require_once('polymod_admin.php');
	}
	if(!$module->isPolymod() || ($module->isPolymod() && $_REQUEST['action'] == 'parameters')){
		//get module Paramaters
		if ($module->getCodename()=='standard') {
			$parameters = $module->getParameters(false,true);
		} else {
			$parameters = $module->getParameters();
		}
		if (is_array($parameters) && sizeof($parameters)) {
			$content .= '
			<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_MODULE_PARAMETERS,array('"'.$module->getLabel($cms_language).'"'),MOD_STANDARD_CODENAME).' :</dialog-title>
			<br />
			<table border="0" cellpadding="3" cellspacing="2">
			<form action="'.$_SERVER["SCRIPT_NAME"].'?module='.$module->getCodename().'" method="post">
			<input type="hidden" name="action" value="parameters" />
			<input type="hidden" name="cms_action" value="validate_module" />
			<input type="hidden" name="moduleCodename" value="'.$module->getCodename().'" />';
			foreach ($parameters as $label => $value) {
				if (is_array($value)) {
					switch ($value[1]) {
						default:
						case 'text':
							$paramContent ='<input type="text" size="30" class="admin_input_text" name="'.$label.'" value="'.htmlspecialchars($value[0]).'" />';
						break;
						case 'boolean':
							$yes = ($value[0]=='1') ? ' selected="true"':'';
							$no = ($value[0]=='0') ? ' selected="true"':'';
							$paramContent ='
								<select name="'.$label.'" class="admin_input_text">
									<option value="0"'.$no.'>'.$cms_language->getMessage(MESSAGE_PAGE_NO).'</option>
									<option value="1"'.$yes.'>'.$cms_language->getMessage(MESSAGE_PAGE_YES).'</option>
								</select>';
						break;
						case 'integer':
							$paramContent ='<input type="text" size="30" class="admin_input_text" name="'.$label.'" value="'.htmlspecialchars($value[0]).'" />';
						break;
					}
					$paramContent .='<input type="hidden" name="'.$label.'_contentType" value="'.$value[1].'" />';
					$content .= '
						<tr>
							<td class="admin" align="right">'.htmlspecialchars(str_replace("_"," ",$label)).'</td>
							<td class="admin">'.$paramContent.'</td>
						</tr>
					';
				} else {
					$content .= '
						<tr>
							<td class="admin" align="right">'.htmlspecialchars(str_replace("_"," ",$label)).'</td>
							<td class="admin"><input type="text" size="30" class="admin_input_text" name="'.$label.'" value="'.htmlspecialchars($value).'" /></td>
						</tr>
					';
				}
			}
			$content .= '
				<tr>
					<td colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
				</tr>
				</form>
				</table>
			';
		}
	}
}
//set messages if any
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//draw content
$dialog->setContent($content);
$dialog->show();
?>