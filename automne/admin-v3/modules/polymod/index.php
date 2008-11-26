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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: index.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : module polymod admin
  * Presents list of all actions in module
  *
  * @package CMS
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_SHOW", 1006);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_UNDELETE", 250);
define("MESSAGE_PAGE_ACTION_UNARCHIVE", 251);
define("MESSAGE_PAGE_ACTION_ARCHIVE", 253);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_PREVISUALIZATION", 811);
define("MESSAGE_PAGE_ACTION_CHANGE", 820);
define("MESSAGE_PAGE_FIELD_STATUS", 256);
define("MESSAGE_PAGE_FIELD_TITLE", 257);
define("MESSAGE_PAGE_FIELD_PUBLICATION", 258);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_ACTION_EDIT", 12); //Editer
define("MESSAGE_PAGE_FIELD_LANGUAGE", 96); //Language
define("MESSAGE_PAGE_ACTION_SEARCH", 1091);
define("MESSAGE_PAGE_MENU_CATEGORIES", 1206);
define("MESSAGE_PAGE_MENU_GROUPS", 1217);

/**
  * Messages from this module 
  */
define("MESSAGE_PAGE_TITLE", 7);
define("MESSAGE_PAGE_ACTION_LIST", 77);
define("MESSAGE_PAGE_MANAGE_OBJECTS", 108);

//get polymod codename
$polyModuleCodename = ($_REQUEST["polymod"]) ? $_REQUEST["polymod"]:'';

//CHECK Module
if (!$polyModuleCodename) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($polyModuleCodename);

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

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
	$cms_message .= $cms_language->getMessage(SensitiveIO::sanitizeAsciiString($_GET["cms_message_module_id"]), false, MOD_POLYMOD_CODENAME);
}
// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

//occasional unlocking
if ($_GET["item"]) {
	$itm = CMS_polymod::getResourceByID($_GET["item"]);
	if (!$itm->hasError() && $itm->getLock() == $cms_user->getUserID()) {
		$itm->unlock();
	}
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false, MOD_POLYMOD_CODENAME));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//show version number
if (file_exists(PATH_MODULES_FS.'/'.MOD_POLYMOD_CODENAME.'/VERSION')) {
	$content .= '<div style="position:absolute;top:2px;right:2px;font-size:8px;">v'.file_get_contents(PATH_MODULES_FS.'/'.MOD_POLYMOD_CODENAME.'/VERSION').'</div>';
}
$content .= '
	<table width="90%" cellpadding="2" cellspacing="1" border="0">';
//if module uses categories
if (CMS_poly_object_catalog::moduleHasCategories($polyModuleCodename)) {
	//if user has some categories to manage
	$userManageCategories = $cms_user->getRootModuleCategoriesManagable($polyModuleCodename);
	if ((is_array($userManageCategories) && $userManageCategories) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$content .= '
			<!-- Gestion des catégories -->
			<tr>
				<td class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_MENU_CATEGORIES).'</strong></td>
				<form action="'.PATH_ADMIN_WR.'/modulecategories.php" method="get">
				<input type="hidden" name="module" value="'.$polyModuleCodename.'" />
				<input type="hidden" name="backlink" value="'.$_SERVER["SCRIPT_NAME"].'?polymod='.$polyModuleCodename.'" />
				<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_LIST, false, MOD_POLYMOD_CODENAME).'" /></td>
				</form>
				<form action="'.PATH_ADMIN_WR.'/modulecategory.php" method="post">
				<input type="hidden" name="module" value="'.$polyModuleCodename.'" />
				<input type="hidden" name="backlink" value="'.$_SERVER["SCRIPT_NAME"].'?polymod='.$polyModuleCodename.'" />
				<input type="hidden" name="parentID" value="0" />
				<td class="admin" align="right"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
				</form>
				<td class="admin">&nbsp;</td>
			</tr>
			<tr>
				<td class="admin" colspan="4">&nbsp;</td>
			</tr>';
	}
}
$objects = $cms_module->getObjects();

if (APPLICATION_ENFORCES_ACCESS_CONTROL === false || 
	 (APPLICATION_ENFORCES_ACCESS_CONTROL === true
		&& $cms_user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_EDIT)) ) {
	foreach ($objects as $anObjectType) {
		//if object is editable or if user has full privileges
		if ($anObjectType->getValue("admineditable") == 0 || ($anObjectType->getValue("admineditable") == 2 && $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
			//load fields objects for object
			$objectFields = CMS_poly_object_catalog::getFieldsDefinition($anObjectType->getID());
			if(sizeof($objectFields)) {
				$content .= '
				<!-- Gestion des objets -->
				<tr>
					<td width="200" nowrap="nowrap" class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_MANAGE_OBJECTS, array($anObjectType->getLabel($cms_language)), MOD_POLYMOD_CODENAME).'</strong></td>
					<form action="items.php" method="get">
					<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
					<input type="hidden" name="object" value="'.$anObjectType->getID().'" />
					<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_LIST, false, MOD_POLYMOD_CODENAME).'" /></td>
					</form>
					<form action="item.php" method="post">
					<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
					<input type="hidden" name="object" value="'.$anObjectType->getID().'" />
					<td width="200" class="admin" align="right"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
					</form>
					<td width="100%" class="admin">('.$anObjectType->getDescription($cms_language).')</td>
				</tr>';
			}
		}
	}
}
$content .='</table>
<br />';

$dialog->setContent($content);
$dialog->show();
?>