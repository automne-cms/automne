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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: module_parameters.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module parameters
  * Manages the paramters of a module
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 808);
define("MESSAGE_PAGE_MODULE_UNKNOWN", 809);
define("MESSAGE_PAGE_MODULE_NOPARAMETERS", 810);
define("MESSAGE_PAGE_PARAMETERS", 807);
define("MESSAGE_PAGE_YES", 1082);
define("MESSAGE_PAGE_NO", 1083);

//CHECKS
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

$module = CMS_modulesCatalog::getByCodename($_GET["module"]);
if (!is_a($module, "CMS_module")) {
	header("Location :".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_MODULE_UNKNOWN."&".session_name()."=".session_id());
	exit;
}
if (!$module->hasParameters()) {
	header("Location :".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_MODULE_NOPARAMETERS."&".session_name()."=".session_id());
	exit;
}



$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE, array($module->getCodename())));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
if ($_GET["module"]=='standard') {
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS).' Automne');
	$parameters = $module->getParameters(false,true);
} else {
	$parameters = $module->getParameters();
}

//Action management	
if ($_POST["cms_action"] == "validate") {
	$new_parameters = array();
	foreach ($_POST as $label => $value) {
		if ($label != "cms_action" && !strpos($label,'_contentType')) {
			if ($_POST[$label."_contentType"]) {
				$new_parameters[$label] = array($value,$_POST[$label."_contentType"]);
			} else {
				$new_parameters[$label] = $value;
			}
		}
	}
	if (sizeof($new_parameters)) {
		$module->setAndWriteParameters($new_parameters);
		$module = CMS_modulesCatalog::getByCodename($_GET["module"]);
		$parameters = $new_parameters;
	}
	if ($_GET["module"]=='standard') {
		//$dialog->reloadAll();
	}
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	$dialog->setActionMessage($cms_message);
	/*if ($_GET["module"]=='standard') {
		$parameters = $module->getParameters(false,true);
	} else {
		$parameters = $module->getParameters();
	}*/
}

$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'?module='.$module->getCodename().'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
';

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

$dialog->setContent($content);
$dialog->show();

?>