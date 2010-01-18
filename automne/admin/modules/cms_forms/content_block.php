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
// $Id: content_block.php,v 1.3 2010/01/18 15:24:53 sebastien Exp $

/**
  * PHP page : page content block edition : cms_forms
  * Used to edit a block of form datas inside a page.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//Standard module messages
define("MESSAGE_PAGE_FIELD_LANGUAGE", 96);
define("MESSAGE_PAGE_ACTION_SHOW", 1006);
define("MESSAGE_PAGE_FIELD_ACTIONS", 162);
define("MESSAGE_PAGE_ACTION_PREVIZ", 811);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_PREVIEW", 811);

//Messages specific to module
define("MESSAGE_PAGE_TITLE", 64);
define("MESSAGE_PAGE_FIND_FORM", 63);
define("MESSAGE_PAGE_FIELD_CATEGORY", 62);
define("MESSAGE_PAGE_HEADING1", 12);
define("MESSAGE_PAGE_FIELD_FORMNAME", 19);
define("MESSAGE_PAGE_FIELD_RECEIVEDATA", 29);
define("MESSAGE_PAGE_ACTION_SELECT", 65);
define("MESSAGE_PAGE_FIELD_FORM_CLOSED", 45);
define("MESSAGE_PAGE_FIELD_FORM_OPEN", 44);
define("MESSAGE_PAGE_ACTION_UNSELECT", 66);
define("MESSAGE_PAGE_EMPTY", 6);

$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$currentPage = is_object($cms_context) ? sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID()) : '';
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

$cms_page = CMS_tree::getPageByID($currentPage);

if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	die('No rigths on page or module ...');
	exit;
}

//ARGUMENTS CHECK
if (!$cs
	|| !$rowTag
	|| !$rowId
	|| !$blockId) {
	die("Data missing.");
}
/*
$cms_block = new CMS_block_cms_forms();
$cms_block->initializeFromBasicAttributes($_POST["block"]);
*/
//instanciate block
$cms_block = new CMS_block_polymod();
$cms_block->initializeFromID($blockId, $rowId);

$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

// Language
if (isset($_REQUEST["items_language"])) {
	$_SESSION["cms_context"]->setSessionVar("items_language", $_REQUEST["items_language"]);
} elseif ($_SESSION["cms_context"]->getSessionVar("items_language") == '') {
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

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$value = array('formID' => $_POST["value"]);
	if (!$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, array("value"=>$value))) {
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
	}
	if (!$cms_message) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		//grab block content
		$data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
	}
	break;
case "disassociate":
	//checks and assignments
	$cms_message = "";
	$value = array();
	if (!$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, array("value"=>$value))) {
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
	}
	if (!$cms_message) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		//grab block content
		$data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
	}
	break;
case "previz":
	//checks and assignments
	$previz = $_POST["item"];
default:
	//grab block content
	$data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
	break;
}

$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE, false, MOD_CMS_FORMS_CODENAME));
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
	<input type="hidden" name="page" value="'.$cms_page->getID().'" />
	<input type="hidden" name="cs" value="'.$cs.'" />
	<input type="hidden" name="rowTag" value="'.$rowTag.'" />
	<input type="hidden" name="rowType" value="'.$rowId.'" />
	<input type="hidden" name="block" value="'.$blockId.'" />
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

$content .= $cms_language->getMessage(MESSAGE_PAGE_HEADING1, false, MOD_CMS_FORMS_CODENAME).'<br /><br />';

$items = $search->search();

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
		if ($data["value"]['formID'] == $obj->getID()) {
			$td_class = "admin_selectedbg";
		}
		$i_receiveMsgID = ($obj->getAttribute('public') === true) ? MESSAGE_PAGE_FIELD_FORM_OPEN : MESSAGE_PAGE_FIELD_FORM_CLOSED ;
		$content .= '
			<tr>
				<td class="' . $td_class . '" style="">
					'.$obj->getAttribute('name').'</td>
				<td class="' . $td_class . '" align="center">'.$cms_language->getMessage($i_receiveMsgID, false, MOD_CMS_FORMS_CODENAME).'</td>
				<td class="'.$td_class.'">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
						<input type="hidden" name="cms_action" value="previz" />
						<input type="hidden" name="page" value="'.$cms_page->getID().'" />
						<input type="hidden" name="cs" value="'.$cs.'" />
						<input type="hidden" name="rowTag" value="'.$rowTag.'" />
						<input type="hidden" name="rowType" value="'.$rowId.'" />
						<input type="hidden" name="block" value="'.$blockId.'" />
						<input type="hidden" name="item" value="' . $obj->getID() . '" />
							<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_PREVIZ).'" /></td>
						</form>';
						if ($data["value"]['formID'] != $obj->getID()) {
							$content .= '
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
							<input type="hidden" name="cms_action" value="validate" />
							<input type="hidden" name="page" value="'.$cms_page->getID().'" />
							<input type="hidden" name="cs" value="'.$cs.'" />
							<input type="hidden" name="rowTag" value="'.$rowTag.'" />
							<input type="hidden" name="rowType" value="'.$rowId.'" />
							<input type="hidden" name="block" value="'.$blockId.'" />
							<input type="hidden" name="value" value="' . $obj->getID() . '" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_SELECT, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>';
						} else {
							$content .= '
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
							<input type="hidden" name="cms_action" value="disassociate" />
							<input type="hidden" name="page" value="'.$cms_page->getID().'" />
							<input type="hidden" name="cs" value="'.$cs.'" />
							<input type="hidden" name="rowTag" value="'.$rowTag.'" />
							<input type="hidden" name="rowType" value="'.$rowId.'" />
							<input type="hidden" name="block" value="'.$blockId.'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNSELECT, false, MOD_CMS_FORMS_CODENAME).'" /></td>
							</form>';
						}
						$content .= '
					</tr>
					</table>
				</td>
			</tr>
		';
	}
	
	$content .= '
		</table>';
}
//previsualization of a form
if (sensitiveIO::isPositiveInteger($previz)) {
	$previzform = new CMS_forms_formular($previz);
	$content .= '
		<br /><br />
		<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_PREVIEW).'</dialog-title><br /><br />
		<table border="1" cellpadding="3" cellspacing="0">
		<tr>
			<td class="admin">
				' . $previzform->getContent(CMS_forms_formular::REMOVE_FORM_SUBMIT) . '
			</td>
		</tr>
		</table>
	';
}

$dialog->setContent($content);
$dialog->show();

?>