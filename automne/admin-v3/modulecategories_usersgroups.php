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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: modulecategories_usersgroups.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Presents list of categories
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_ADD", 260);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_FIELD_GROUP", 189);
define("MESSAGE_PAGE_TITLE_PROFILES", 67);
define("MESSAGE_PAGE_TITLE_CATEGORIES_ACCESS", 1210);

// Get module codename and check user's permissions on the module
if (trim($_REQUEST["module"])) {
	$cms_module_codename = trim($_REQUEST["module"]);
	$_SESSION["cms_context"]->setSessionVar("module_codename", $cms_module_codename);
} elseif ($_SESSION["cms_context"]->getSessionVar("module_codename") !== false) {
	$cms_module_codename = $_SESSION["cms_context"]->getSessionVar("module_codename");
}
if (!$cms_module_codename) {
	header("Location :".PATH_ADMIN_SPECIAL_ENTRY_WR."?".session_name()."=".session_id());
	exit;
}
if (!$cms_user->hasModuleClearance($cms_module_codename, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$cms_module = CMS_modulesCatalog::getByCodename($cms_module_codename);

$all_languages = CMS_languagesCatalog::getAllLanguages($cms_module_codename);

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Get current root category under navigation
if ($_GET["ctg"]) {
	$_SESSION["cms_context"]->setSessionVar("items_current_category", (int) $_GET["ctg"]);
}

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($_POST["cms_action"]) {
case "delete":
	$item = new CMS_moduleCategory($_POST["item"]);
	if (CMS_moduleCategories_catalog::detachCategory($item)) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE_PROFILES);	// Profiles
$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)));
$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_CATEGORIES_ACCESS);
$dialog->setTitle($title, 'pic_comptes.gif');
if ($_REQUEST["backlink"]) {
	$dialog->setBacklink($_REQUEST["backlink"]);
} else {
	$dialog->setBacklink($cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT));
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

// Getting all groups
$groups = CMS_profile_usersGroupsCatalog::getAll();

if (sizeof($groups)) {
	$content .= '
	<table width="700" border="0" cellpadding="2" cellspacing="0">
		<tr>
			<th class="admin" style="text-align:left;"> 
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUP).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
		</tr>';
	foreach ($groups as $item) {
		
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		
		$content .= '
		<tr>
			<td width="100%" class="'.$td_class.'">
				<b>'.$item->getLabel().'</b>
			</td>
			<td class="'.$td_class.'" align="right">
				<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<form action="modulecategories_usersgroup.php" method="post">
					<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
					<input type="hidden" name="group" value="'.$item->getGroupID().'" />
						<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
					</form>
               </tr>
			</table></td>
		</tr>';
	}
	$content .= '
	</table>';
}

$dialog->setContent($content);
$dialog->show();

?>