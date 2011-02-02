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
// $Id: index.php,v 1.2 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Presents list of all actions in module
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_SEARCH", 1091);
define("MESSAGE_PAGE_MENU_CATEGORIES", 1206);
define("MESSAGE_PAGE_MENU_GROUPS", 1217);
define("MESSAGE_PAGE_WYSIWYG_EDITOR", 1164);

/**
  * Messages from this module 
  */
define("MESSAGE_PAGE_TITLE", 25);
define("MESSAGE_PAGE_ACTION_LIST", 24);
define("MESSAGE_PAGE_MENU_FORMS", 23);
define("MESSAGE_PAGE_WYSIWYG_ERROR", 84);

//CHECKS
if (!$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

// Useful date mask
$date_mask = $cms_language->getDateFormatMask(); 	// jj/mm/AAAA
$date_format = $cms_language->getDateFormat(); 		// d/m/Y

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Page management
if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($_GET["bookmark"]) {
	$_SESSION["cms_context"]->setBookmark($_GET["bookmark"]);
}
// Get a message to print from URL
if (SensitiveIO::isPositiveInteger($_GET["cms_message_module_id"])) {
	$cms_message .= $cms_language->getMessage(SensitiveIO::sanitizeAsciiString($_GET["cms_message_module_id"]), false, MOD_CMS_FORMS_CODENAME);
}
// Get current language
if ($_REQUEST["items_language"] != '') {
	$_SESSION["cms_context"]->setSessionVar("items_language", $_REQUEST["items_language"]);
} else if ($_SESSION["cms_context"]->getSessionVar("items_language") == '' || is_object($_SESSION["cms_context"]->getSessionVar("items_language"))) {
	$_SESSION["cms_context"]->setSessionVar("items_language", $cms_module->getParameters("default_language"));
}
$items_language = new CMS_language($_SESSION["cms_context"]->getSessionVar("items_language"));

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false, MOD_CMS_FORMS_CODENAME));

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//show version number
if (file_exists(PATH_MODULES_FS.'/'.MOD_CMS_FORMS_CODENAME.'/VERSION')) {
	$content .= '<div style="position:absolute;top:2px;right:2px;font-size:8px;">v'.file_get_contents(PATH_MODULES_FS.'/'.MOD_CMS_FORMS_CODENAME.'/VERSION').'</div>';
}

$content .= '
	<br />
	<table width="400" cellpadding="2" cellspacing="1">
	<!-- Gestion des catégories -->
	<tr>
		<td width="100%" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_MENU_CATEGORIES).'</td>
		<form action="'.PATH_ADMIN_WR.'/../admin-v3/modulecategory.php" method="post">
		<input type="hidden" name="module" value="'.MOD_CMS_FORMS_CODENAME.'" />
		<input type="hidden" name="backlink" value="'.$_SERVER["SCRIPT_NAME"].'" />
		<input type="hidden" name="parentID" value="0" />
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
		</form>
		<form action="'.PATH_ADMIN_WR.'/../admin-v3/modulecategories.php" method="get">
		<input type="hidden" name="module" value="'.MOD_CMS_FORMS_CODENAME.'" />
		<input type="hidden" name="backlink" value="'.$_SERVER["SCRIPT_NAME"].'" />
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_LIST, false, MOD_CMS_FORMS_CODENAME).'" /></td>
		</form>
	</tr>';

//get all user categories
$user_categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, $cms_module->getCodename(), $cms_language);
$content .= '
	<!-- Gestion des documents -->
	<tr>
		<td class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_MENU_FORMS, false, MOD_CMS_FORMS_CODENAME).'</td>';
if (sizeof($user_categories)) {
	$content .= '
		<form action="item.php" method="post">
		<input type="hidden" name="items_language" value="'.$items_language->getCode().'" />
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
		</form>';
} else {
	//user has no right on categories so he can't edit/create items
	$content .= '<td class="admin">&nbsp;</td>';
}
$content .= '
		<form action="items.php" method="get">
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_SEARCH).'" /></td>
		</form>
	</tr>
</table>
<br />';

$dialog->setContent($content);
$dialog->show();

?>