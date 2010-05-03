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
// $Id: entry.php,v 1.2 2010/03/08 16:41:39 sebastien Exp $

/**
  * PHP page : entry
  * Entry page. Presents all the user "sections" (page clearances sections) and all the user available validations.
  * 
  * Possibility to obtain a cms_message from GET : $_GET["cms_message"]
  * 
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 58);
define("MESSAGE_PAGE_VALIDATIONS_PENDING", 60);
define("MESSAGE_PAGE_ACTION_MOVE_ERROR", 158);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_MODULES", 264);
define("MESSAGE_PAGE_MODULES_PARAMETERS", 807);
define("MESSAGE_PAGE_ARCHIVES", 859);
define("MESSAGE_PAGE_ERROR_PAGE_NEVER_VALIDATED", 867);
define("MESSAGE_PAGE_ERROR_MOVE_ROOT", 868);
define("MESSAGE_PAGE_ERROR_FATHER_IS_DESCENDANT", 869);
define("MESSAGE_PAGE_ERROR_FATHER_SIBLINGS_NEVER_VALIDATED", 870);
define("MESSAGE_PAGE_TASK_PENDING", 1090);
define("MESSAGE_PAGE_NO_VALIDATIONS_PENDING", 1113);
define("MESSAGE_PAGE_ERROR_FATHER_IS_IDENTICAL", 1319);

//Action management	
if (isset($_GET["cms_action"]) && $_GET["cms_action"] == "displace") {
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
		$cms_page = $cms_context->getPage();
		$father = CMS_tree::getPageByID($_GET["new_father"]);
		//augment the execution time, because things here can be quite lengthy
		@set_time_limit(9000);
		//ignore user abort to avoid interuption of process
		@ignore_user_abort(true);
		if ($error = CMS_tree::movePage($cms_page, $father)) {
			switch ($error) {
			case "PAGE_NEVER_VALIDATED":
				$errmsg = $cms_language->getMessage(MESSAGE_PAGE_ERROR_PAGE_NEVER_VALIDATED);
				break;
			case "MOVE_ROOT":
				$errmsg = $cms_language->getMessage(MESSAGE_PAGE_ERROR_MOVE_ROOT);
				break;
			case "FATHER_IS_DESCENDANT":
				$errmsg = $cms_language->getMessage(MESSAGE_PAGE_ERROR_FATHER_IS_DESCENDANT);
				break;
			case "FATHER_SIBLINGS_NEVER_VALIDATED":
				$errmsg = $cms_language->getMessage(MESSAGE_PAGE_ERROR_FATHER_SIBLINGS_NEVER_VALIDATED);
				break;
			case "FATHER_IS_IDENTICAL":
				$errmsg = $cms_language->getMessage(MESSAGE_PAGE_ERROR_FATHER_IS_IDENTICAL);
				break;
			}
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_MOVE_ERROR) . "\n".$errmsg;
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_CLEARANCE_INSUFFICIENT);
	}
}

if ($cms_user) {
	$title = '<span class="admin">'. ($cms_language->getMessage(MESSAGE_HELLO)).' <strong>'.$cms_user->getFirstName().' '.$cms_user->getLastName().'</strong></span>';
}
$dialog = new CMS_dialog();
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
} else if (isset($_GET["cms_message"])) {
	$dialog->setActionMessage(SensitiveIO::sanitizeHTMLString($_GET["cms_message"]));
}
$dialog->reloadTree();
$content = '
<table border="0" cellpadding="2" cellspacing="0" class="admin_clientSpace">
<tr>
	<td class="admin" width="100%" align="center">&nbsp;'.$title.'&nbsp;</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td class="admin" width="100%" align="center">
<br />
<br />
<br />
<br />
<table border="0" width="70%" cellpadding="0" cellspacing="0">
<tr>
	<td class="admin"><!-- bloc notes ...--></td>
	
	<td class="admin"><!-- task-->';
//THE USER VALIDATIONS
if (APPLICATION_ENFORCES_WORKFLOW) {
		$modules_validations = CMS_modulesCatalog::getAllValidations($cms_user,true);
		$content .= '
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_hg.gif" border="0" alt="-" /></td>
				<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_h.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_h.gif" align="right"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_hd.gif" border="0" alt="-" /></td>
			</tr>
			<tr>
				<td width="36" valign="top" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_g.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td colspan="2" rowspan="2" class="admin" align="center">
					<dialog-title type="admin_h2">'.ucfirst($cms_language->getMessage(MESSAGE_PAGE_VALIDATIONS_PENDING)).'</dialog-title>';
	if ($modules_validations && sizeof($modules_validations)) {
		$content .= '
			<table width="100%" border="0" cellpadding="2" cellspacing="2">';
		foreach ($modules_validations as $module_codename=>$module_validations) {
			//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
			if ($module_codename == MOD_STANDARD_CODENAME) {
				$mod_label = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
			} else {
				$mod = CMS_modulesCatalog::getByCodename($module_codename);
				$mod_label = $mod->getLabel($cms_language);
			}
			
			$content .= '
				<tr>
					<td height="10"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" /></td>
				</tr>
				<tr>
					<th class="admin">'.$mod_label.'</th>
				</tr>
			';
			
			//sort the validations by type label
			$validations_sorted = array();
			foreach ($module_validations as $validation) {
				$validations_sorted[$validation->getValidationTypeLabel()][] = $validation;
			}
			ksort($validations_sorted);
			$count = 0;
			foreach ($validations_sorted as $label=>$validations) {
				$count++;
				$td_class = ($count % 2 == 0) ? "admin_darkgreybg" : "admin_lightgreybg" ;
				$validation = $validations[0];
				$content .= '
				<tr>
					<td class="'.$td_class.'"><a href="validations.php?module='.$module_codename.'&amp;editions='.$validation->getEditions().'" class="admin">'.$label."</a> : ".sizeof($validations).'</td>
				</tr>';
			}
		}
		$content .= '</table>';
	} else {
		$content .= '<br />'.$cms_language->getMessage(MESSAGE_PAGE_NO_VALIDATIONS_PENDING);
	}
	$content .='
					
				</td>
				<td width="36" valign="top" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_d.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
			</tr>
			<tr>
				<td width="5" valign="bottom" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_g.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td width="5" valign="bottom" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_d.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
			</tr>
			<tr>
				<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_bg.gif" border="0" alt="-" /></td>
				<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_b.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_b.gif" align="right"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
				<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_bd.gif" border="0" alt="-" /></td>
			</tr>
		</table>';
}
	
$content .= '		</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';

$dialog->setContent($content);
$dialog->show();
?>