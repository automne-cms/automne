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
// $Id: items.php,v 1.7 2010/03/08 16:42:08 sebastien Exp $

/**
  * PDFForms module : index
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//Standard module messages
define("MESSAGE_PAGE_TITLE", 249);
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_FIELD_ACTIONS", 162);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_FIELD_LANGUAGE", 96); //Language
define("MESSAGE_PAGE_ACTION_SHOW", 1006);
define("MESSAGE_PAGE_WYSIWYG_EDITOR", 1164);

//Messages specific to news module
define("MESSAGE_PAGE_HEADING2", 2);
define("MESSAGE_PAGE_FIELD_NAME", 3);
define("MESSAGE_PAGE_FIELD_NUMRECORDS", 4);
define("MESSAGE_PAGE_FIELD_LASTPOST", 5);
define("MESSAGE_PAGE_EMPTY", 6);
define("MESSAGE_PAGE_EXPORT", 7);
define("MESSAGE_PAGE_DELETE", 8);
define("MESSAGE_PAGE_SUBTITLE1", 11);
define("MESSAGE_PAGE_SUBTITLE2", 20);
define("MESSAGE_PAGE_SUBTITLE3", 10);
define("MESSAGE_PAGE_HEADING1", 12);
define("MESSAGE_PAGE_FIELD_FILE", 13);
define("MESSAGE_PAGE_FIELD_URL", 14);
define("MESSAGE_PAGE_FIELD_DATE", 15);
define("MESSAGE_PAGE_DELETE_FORM_CONFIRM", 16);
define("MESSAGE_PAGE_INSERT", 17);
define("MESSAGE_PAGE_FILE_ERROR", 18);
define("MESSAGE_PAGE_FIELD_FORMNAME", 19);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 31);
define("MESSAGE_PAGE_ACTION_ACTIONS", 36);
define("MESSAGE_PAGE_FIELD_RECEIVEDATA", 29);
define("MESSAGE_PAGE_FIELD_FORM_OPEN", 44);
define("MESSAGE_PAGE_FIELD_FORM_CLOSED", 45);
define("MESSAGE_PAGE_FIELD_CATEGORY", 62);
define("MESSAGE_PAGE_FIND_FORM", 63);
define("MESSAGE_PAGE_WYSIWYG_ERROR", 84);

//CHECKS
if (!$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

//get all user categories
$user_categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, $cms_module->getCodename(), $cms_language);

//maintenance task : clean all empty forms
CMS_forms_formular::cleanEmptyForms();

// Language
if ($_REQUEST["items_language"] != '') {
	$_SESSION["cms_context"]->setSessionVar("items_language", $_REQUEST["items_language"]);
} elseif ($_SESSION["cms_context"]->getSessionVar("items_language") == '' || is_object($_SESSION["cms_context"]->getSessionVar("items_language"))) {
	$_SESSION["cms_context"]->setSessionVar("items_language", $cms_module->getParameters("default_language"));
}
$items_language = new CMS_language($_SESSION["cms_context"]->getSessionVar("items_language"));

//
// Get default search options
//

// Get search options from posted datas
if ($_POST["cms_action"] == 'search') {
	$_SESSION["cms_context"]->setSessionVar("items_ctg", $_POST["items_ctg"]);
}

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($_POST["cms_action"]) {
case "delete":
	//change the article proposed location and send emails to all the validators
	$item = CMS_module_cms_forms::getResourceByID($_POST["item"]);
	if ($item->destroy()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR, false, MOD_CMS_FORMS_CODENAME);
	}
	break;
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE));
//$dialog->setBacklink("index.php");

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

// Search for all forms in current language
$search = new CMS_forms_search();
// Param : userpermisison on module
$search->addWhereCondition("profile", $cms_user);
// Param : Language
$search->addWhereCondition("language", $items_language);
// Param : With categories
if ($_SESSION["cms_context"]->getSessionVar("items_ctg") != '') {
	$search->addWhereCondition("category", $_SESSION["cms_context"]->getSessionVar("items_ctg"));
}
//language selection
$content .= '
<fieldset style="width:500px;">
	<legend class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIND_FORM, false, MOD_CMS_FORMS_CODENAME).'</legend>
	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="search" />';

//
// Build list of all languages in which module is available
//
$content .= '
	<tr>
		<td width="150" class="admin">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LANGUAGE).' :</td>
		<td width="350" class="admin">';
$all_languages = CMS_languagesCatalog::getAllLanguages(MOD_CMS_FORMS_CODENAME);
foreach ($all_languages as $aLanguage) {
	$checked = ($aLanguage->getCode() == $items_language->getCode()) ? ' checked="checked"' : '';
	$content .= '
			<label><input name="items_language" type="radio" value="'.$aLanguage->getCode().'"'.$checked.' onclick="submit();" /> '.$aLanguage->getLabel().'</label>';
}
$content .= '</td>
	</tr>';
// Categories
$a_all_categories = CMS_forms_formularCategories::getAllCategoriesAsArray($cms_language,true);
if (sizeof($a_all_categories)) {
	$s_categories_listbox = CMS_moduleCategories_catalog::getListBox(
		array (
		'field_name' => 'items_ctg',									// Select field name to get value in
		'items_possible' => $a_all_categories,							// array of all categories availables: array(ID => label)
		'default_value' => $cms_context->getSessionVar("items_ctg"),	// Same format
		'attributes' => 'class="admin_input_text" style="width:250px;"'
		)
	);
	$content .= '
		<tr>
			<td class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY, false, MOD_CMS_FORMS_CODENAME).'&nbsp;:</td>
			<td class="admin">'.$s_categories_listbox.'</td>
		</tr>';
}
$content .= '
	<tr>
		<td class="admin" colspan="2">
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_SHOW).'" /></td>
	</tr>
</form>
</table></fieldset><br />';

$content .= '
	<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE1, false, MOD_CMS_FORMS_CODENAME).'</dialog-title>
	'.$cms_language->getMessage(MESSAGE_PAGE_HEADING1, false, MOD_CMS_FORMS_CODENAME).'<br />
	<br />';


$items = $search->search();

if (sizeof($user_categories)) {
	$content .= '
		<form action="item.php" method="post" style="position:relative;float:right;margin:0 20px 10px 0;">
		<input type="hidden" name="items_language" value="'.$items_language->getCode().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
}

if (!sizeof($items)) {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EMPTY, false, MOD_CMS_FORMS_CODENAME) . "<br /><br />";
} else {
	$content .= '
		<table width="700" border="0" cellpadding="2" cellspacing="1">
		<tr>
			<th class="admin" width="100%" style="text-align:left;">
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FORMNAME, false, MOD_CMS_FORMS_CODENAME).'</th>
			<th class="admin" nowrap="nowrap">
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RECEIVEDATA, false, MOD_CMS_FORMS_CODENAME).'</th>
			<th class="admin">
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
		</tr>';
	
	$count = 0;
	@reset($items);
	foreach ($items as $obj) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$i_receiveMsgID = ($obj->getAttribute('public') === true) ? MESSAGE_PAGE_FIELD_FORM_OPEN : MESSAGE_PAGE_FIELD_FORM_CLOSED ;
		$content .= '
			<tr>
				<td class="' . $td_class . '">
					'.$obj->getAttribute('name').'</td>
				<td class="' . $td_class . '" align="center">'.$cms_language->getMessage($i_receiveMsgID, false, MOD_CMS_FORMS_CODENAME).'</td>
				<td class="'.$td_class.'">';
					if (sizeof($user_categories)) { //if user has no right on categories he can't edit/create items
						$content .= '
						<table border="0" cellpadding="2" cellspacing="0">
						<tr>
							<form action="item.php" method="post">
							<input type="hidden" name="item" value="'.$obj->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
							</form>
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\'' . str_replace("'", "\'", $cms_language->getMessage(MESSAGE_PAGE_DELETE_FORM_CONFIRM, array($obj->getAttribute("name")), MOD_CMS_FORMS_CODENAME)) . '\')">
							<input type="hidden" name="cms_action" value="delete" />
							<input type="hidden" name="item" value="' . $obj->getID() . '" />
							<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_DELETE, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>
							<form action="itemactions.php" method="post">
							<input type="hidden" name="form" value="'.$obj->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>
						</tr>
						</table>';
					}
				$content .= '
				</td>
			</tr>
		';
	}
	
	$content .= '
		</table>';
		
	if (sizeof($user_categories)) {
		$content .= '
			<form action="item.php" method="post" style="position:relative;float:right;margin:10px 20px 0 0;">
		<input type="hidden" name="items_language" value="'.$items_language->getCode().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
	}
}

$dialog->setContent($content);
$dialog->show();
?>