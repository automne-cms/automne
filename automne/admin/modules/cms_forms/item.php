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
// $Id: item.php,v 1.3 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Presents one module formular to edit
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
define("MESSAGE_FORM_ERROR_MALFORMED_FIELD", 145);

/**
 * Message of this module
 */
define("MESSAGE_PAGE_TITLE", 3);
define("MESSAGE_PAGE_FIELD_NAME", 27);
define("MESSAGE_PAGE_FIELD_LABEL", 26);
define("MESSAGE_PAGE_FIELD_SOURCE", 28);
define("MESSAGE_PAGE_FIELD_RECEIVEDATA", 29);
define("MESSAGE_PAGE_FIELD_CATEGORIES", 30);
define("MESSAGE_ACTION_ERROR_INVALID_XHTML", 32);
define("MESSAGE_ACTION_ERROR_CATEGORIES_EMPTY", 35);
define("MESSAGE_ACTION_ERROR_ADD_CATEGORY", 34);
define("MESSAGE_ACTION_ERROR_ADD_CATEGORIES", 33);
define("MESSAGE_PAGE_FIELD_FORM_OPEN", 44);
define("MESSAGE_PAGE_FIELD_FORM_CLOSED", 45);
define("MESSAGE_JS_ERROR_EMPTY", 37);
define("MESSAGE_JS_ERROR_LISTED", 38);
define("MESSAGE_PAGE_FIELD_RESPONSES", 48);
define("MESSAGE_PAGE_FIELD_RESPONSES_DESCRIPTION", 49);
define("MESSAGE_FORM_ERROR_COPY_PASTED_CODE", 90);

//CHECKS
$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

if (!$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
} elseif (!$_POST["cms_action"] && $_POST["item"]) {
	$item = new CMS_forms_formular($_POST["item"]);
}

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Language
if ($_REQUEST["items_language"] != '') {
	CMS_session::setSessionVar("items_language", $_REQUEST["items_language"]);
} elseif (CMS_session::getSessionVar("items_language") == '' || is_object(CMS_session::getSessionVar("items_language"))) {
	CMS_session::setSessionVar("items_language", $cms_module->getParameters("default_language"));
}
$items_language = new CMS_language(CMS_session::getSessionVar("items_language"));

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

$item = new CMS_forms_formular($_POST["item"]);
if (!$item->getID()) {
	$item->setAttribute('language', $items_language);
	//item need an ID
	$item->writeToPersistence();
}
// All item relations with categories
$item_relations = new CMS_forms_formularCategories($item);

switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$item->setDebug(false);
	
	//check mandatory fields
	if (!$_POST["name"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		$item->setAttribute('name', $_POST["name"]);
	}
	//check for copy-pasted code
	if (!$item->checkFormCode($_POST["source_".$item->getID()])) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_COPY_PASTED_CODE, false, MOD_CMS_FORMS_CODENAME);
	}
	
	$public = ($_POST["public"] > -1) ? true : false ;
	$item->setAttribute('public', $public);
	$item->setAttribute("responses",(int) $_POST["responses"]);
	// If new item set current user as media owner
	if ($item->getAttribute('ownerID') <= 0) {
		$item->setAttribute('ownerID', $cms_user->getUserID());
	}
	// Validate XHTML source
	$domdocument = new CMS_DOMDocument();
	try {
		$domdocument->loadXML("<dummy>".$_POST["source_".$item->getID()]."</dummy>");
	} catch (DOMException $e) {
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_ERROR_INVALID_XHTML, false, MOD_CMS_FORMS_CODENAME). " : ".$e->getMessage();
	}
	if (!$cms_message) {
		//check inputs tags (sometimes, IE remove type="text" ...)
		//then save source
		$item->setAttribute('source', $item->checkInputs($_POST["source_".$item->getID()]));
	}
	// Categories
	// Write item relations with categories
	$ids = ($_POST["ids"]) ? @array_unique(@explode(';', $_POST["ids"])) : array() ;
	if (!$cms_message && $item->writeToPersistence()) {
		$item_relations = new CMS_forms_formularCategories($item);
		if (sizeof($ids) <= 0) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_ERROR_CATEGORIES_EMPTY, false, MOD_CMS_FORMS_CODENAME)."\n";
		} else {
			$item_relations->init();
			foreach ($ids as $id) {
				$cat = CMS_moduleCategories_catalog::getByID($id);
				if ($cat->hasError() 
						|| (!$item_relations->categoryExists($cat) && !$item_relations->addCategory($cat))) {
					$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_ERROR_ADD_CATEGORY, array($cat->getLabel($cms_language)), MOD_CMS_FORMS_CODENAME)."\n";
				}
			}
			if (!$item_relations->writeToPersistence()) {
				$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_ERROR_ADD_CATEGORIES, false, MOD_CMS_FORMS_CODENAME)."\n";
			}
		}
	}
	// Save data
	if (!$cms_message && $item->writeToPersistence()) {
		header("Location: items.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	}
	break;
}


// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false, MOD_CMS_FORMS_CODENAME));
$dialog->setBacklink("items.php?item=".$item->getId());

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

// Insert prefered text editor for textarea field
$toolbarset = (!$cms_module->getParameters("editor_toolbar")) ? 'Basic' : $cms_module->getParameters("editor_toolbar") ;
$attrs = array(
	'form' => 'frmitem',							// Form name
	'field' => 'source_'.$item->getID(),			// Field name
	'value' => $item->getAttribute('source'),		// Default value
	'language' => $cms_language,					// language
	'width' => 600,									// textarea width
	'height' => 600,								// textarea width
	'rows' => 8,									// textarea rows
	'toolbarset' => $toolbarset						// fckeditor toolbarset
);
$text_editor = CMS_textEditor::getEditorFromParams($attrs);
$dialog->setJavascript($text_editor->getJavascript());

// Get listboxes for categories
$a_all_categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, $cms_module->getCodename(), $cms_language);
if (!sizeof($a_all_categories)) {
	//user has no right on categories so he can't edit/create items
	header("Location: ".$cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT)."?cms_message_id=65&".session_name()."=".session_id());
	exit;
}
$s_categories_listboxes = CMS_moduleCategories_catalog::getListBoxes(
	array (
	'field_name' 		=> 'ids',								// Hidden field name to get value in
	'items_possible' 	=> $a_all_categories,					// array of all categories availables: array(ID => label)
	'items_selected' 	=> $item_relations->getCategoriesIds(), // array of selected ids
	'select_width' 		=> '250px',								// Width of selects, default 200px
	'select_height' 	=> '120px',								// Height of selects, default 140px
	'form_name' 		=> 'frmitem'							// Javascript form name
	)
);


// Default check statuses for radios
$public = array ();
$public[1] = ($item->getAttribute('public') === true) ? ' checked="checked"' : '' ;
$public[0] = ($item->getAttribute('public') === false) ? ' checked="checked"' : '' ;

$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form name="frmitem" action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data" onSubmit="getSelectedOptionsInField_ids();">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="language" value="'.CMS_session::getSessionVar("items_language").'" />
	<input id="itemId" type="hidden" name="item" value="'.$item->getID().'" />
	<tr>
		<td class="admin" align="right">
			<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL, false, MOD_CMS_FORMS_CODENAME).' :</td>
		<td class="admin">
			<input type="text" size="30" class="admin_input_text" name="name" value="'.io::htmlspecialchars($item->getAttribute('name')).'" /></td>
	</tr>
<tr>
	<td class="admin" align="right">
			<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RECEIVEDATA, false, MOD_CMS_FORMS_CODENAME).' :</td>
	<td class="admin">
		<input id="frm_open" type="radio" name="public" value="1"'.$public[1].' /><label for="frm_open">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FORM_OPEN, false, MOD_CMS_FORMS_CODENAME).'</label>
		<input id="frm_closed" type="radio" name="public" value="-1"'.$public[0].' /><label for="frm_closed">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FORM_CLOSED, false, MOD_CMS_FORMS_CODENAME).'</label>
	</td>
</tr>
	<tr>
		<td class="admin" align="right" valign="top">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SOURCE, false, MOD_CMS_FORMS_CODENAME).' :</td>
		<td class="admin">'.$text_editor->getHTML().'<br /><br /></td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESPONSES, false, MOD_CMS_FORMS_CODENAME).'</td>
		<td class="admin"><input type="text" name="responses" class="admin_input_text" value="'.$item->getAttribute("responses").'" /><br />
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESPONSES_DESCRIPTION, false, MOD_CMS_FORMS_CODENAME).'<br /><br /></td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORIES, false, MOD_CMS_FORMS_CODENAME).' :</td>
		<td class="admin">
			'.$s_categories_listboxes.'
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<br />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table><br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';
$dialog->setContent($content);
$dialog->show();

?>