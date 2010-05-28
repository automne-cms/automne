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
// $Id: modulecategory.php,v 1.4 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Add/Edit one category
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_SAVE_ERROR", 178);
define("MESSAGE_PAGE_FIELD_EDITIMAGE", 272);
define("MESSAGE_PAGE_FIELD_EDITFILE", 192);
define("MESSAGE_PAGE_EXISTING_IMAGE", 803);
define("MESSAGE_PAGE_EXISTING_IMAGE_NONE", 804);
define("MESSAGE_PAGE_FIELD_THUMBNAIL", 833); //Vignette
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_FILE", 200);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_FIELD_SEE_LINKED_FILE", 200);
define("MESSAGE_PAGE_CATEGORIES_ROOT", 1208);
define("MESSAGE_PAGE_TITLE", 1211);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_ALL_LABELS", 1212);
define("MESSAGE_PAGE_FIELD_LABEL_IN", 1213);
define("MESSAGE_PAGE_FIELD_PARENT_CATEGORY", 1214);

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
//resort by user language first
$userlanguage = $all_languages[$cms_language->getCode()];
unset($all_languages[$cms_language->getCode()]);
array_unshift($all_languages, $userlanguage);

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

// Current category object to manipulate
$item = new CMS_moduleCategory($_REQUEST["item"]);
$item->setAttribute('language', $cms_language);
$item->setAttribute('moduleCodename', $cms_module_codename);
if (!$_REQUEST["parentID"]) {
	$parentCategory = $item->getParent();
} else {
	// Parent category
	$parentCategory = CMS_moduleCategories_catalog::getById($_REQUEST["parentID"]);
}
$parentCategory->setAttribute('language', $cms_language);

switch ($_REQUEST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$item->setDebug(false);
	
	//check mandatory fields
	if (!$_REQUEST["label_".$cms_module->getDefaultLanguageCodename()]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		// If insertion, must be saved once added to its parent
		if (!$cms_message) {
			$newParentCategory = CMS_moduleCategories_catalog::getById($_REQUEST["parentID"]);
			if (!$newParentCategory->hasError()) {
				// Detach from current category
				$oldParentCategory = $item->getParent();
				if ($item->getID()) {
					if ($oldParentCategory->getID() != $newParentCategory->getID()) {
						if (!CMS_moduleCategories_catalog::detachCategory($item)) {
							$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
						}
						// Attach to new category
						if (!CMS_moduleCategories_catalog::attachCategory($item, $newParentCategory)) {
							$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
						}
					}
				} else {
					// Attach to new category
					if (!CMS_moduleCategories_catalog::attachCategory($item, $newParentCategory)) {
						$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
					}
				}
			} else {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
			}
		}
	}
	// Save all translated datas
	foreach ($all_languages as $aLanguage) {
		$lng = $aLanguage->getCode();
		$item->setLabel($_REQUEST["label_".$lng], $aLanguage);
		$item->setDescription($_REQUEST["description_".$lng], $aLanguage);
		// File upload management
		if ($_REQUEST["edit_file_".$lng]) {
			$o_file_upload = new CMS_fileUpload("file_".$lng, true);
			$o_file_upload->setPath('origin', $item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM));
			// Delete previous file
			$o_file_upload->deleteOrigin();
			// Proceed to upload if needed (must write to persistence to get the item ID)
			if ($_FILES["file_".$lng]["name"] && $item->writeToPersistence()) {
				$destination_path = $item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, false);
				$extension = pathinfo($_FILES["file_".$lng]["name"], PATHINFO_EXTENSION);
				$destination_path .= "/cat-".$item->getID()."-file-".$lng.".".$extension;
				$o_file_upload->setPath('destination', $destination_path);
				if (!$o_file_upload->doUpload()) {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
				}
			}
			//remove old one if any
			if ($item->getFilePath($aLanguage, false, PATH_RELATIVETO_FILESYSTEM, true) && is_file($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, true))) {
				@unlink($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, true));
			}
			$item->setFile($o_file_upload->getFilename(), $aLanguage);
			$item->writeToPersistence();
		}
	}
	
	// Icon upload management
	if ($_REQUEST["edit_icon"]) {
		$o_file_upload = new CMS_fileUpload_dialog("file");
		$o_file_upload->setOrigin($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM), $_REQUEST["edit_icon"]);
		if ($o_file_upload->ready() && $item->writeToPersistence()) {
			$extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			$o_file_upload->setDestination($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, false)."/cat-".$item->getID()."-icon.".$extension);
		}
		if (!$o_file_upload->doUpload()) {
			$cms_message .= $o_file_upload->getErrorMessage($cms_language);
		} else {
			//remove old one if any
			if ($item->getIconPath(false, PATH_RELATIVETO_FILESYSTEM, true) && is_file($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true))) {
				@unlink($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
			}
			$item->setAttribute('icon', $o_file_upload->getFilename());
			$item->writeToPersistence();
		}
	}
	if (!$cms_message && !$item->writeToPersistence()) {
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
	}
	$item->setDebug(SYSTEM_DEBUG);
	if (!$cms_message) {
		//header("Location: modulecategories.php?root=".$item->getAttribute('rootID')."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		//exit;
	}
	break;
}

// +----------------------------------------------------------------------+
// | Functions                                                            |
// +----------------------------------------------------------------------+

if (!function_exists("build_category_tree_options")) {
	/** 
	  * Recursive function to build the categories tree.
	  *
	  * @param CMS_moduleCategory $category
	  * @param integer $count, to determine category in-tree depth
	  * @return string HTML formated
	  */
	function build_category_tree_options($category, $count) {
		
		global $cms_module_codename, $cms_language, $parentCategory, $cms_module, $cms_user;
		//if category is not itself (to avoid infinite loop in lineage)
		if ($category->getID() != $_REQUEST["item"]) {
			$category->setAttribute('language', $cms_language);
			$sel = ($parentCategory->getId() > 0 && $parentCategory->getId() == $category->getID()) ? ' selected="selected"' : '' ;
			$label = htmlspecialchars($category->getLabel());
			if ($count >= 1) {
				$label = str_repeat('&nbsp;::', $count).'&nbsp;'.$label;
			}
			$s = '<option value="'.$category->getID().'"'.$sel.'>'.$label.'</option>';
			$count++;
			$attrs = array(
				"module" => $cms_module_codename,
				"language" => $cms_language,
				"level" => $category->getID(),
				"root" => -1,
				"cms_user" => &$cms_user,
				"clearanceLevel" => CLEARANCE_MODULE_MANAGE,
				"strict" => true,
			);
			$siblings = CMS_module::getModuleCategories($attrs);
			if (sizeof($siblings)) {
				foreach ($siblings as $aSibling) {
					$aSibling->setAttribute('language', $cms_language);
					$s .= build_category_tree_options($aSibling, $count);
				}
			}
		}
		return $s;
	}
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false));
if ($_REQUEST["backlink"]) {
	$dialog->setBacklink($_REQUEST["backlink"]);
} else {
	//$dialog->setBacklink("modulecategories.php");
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

// Image preview
if ($item->getIconPath(false, PATH_RELATIVETO_WEBROOT, true)) {
	$thumbnail = '<img src="'.$item->getIconPath(true).'" border="O" /><br />';
} else {
	$thumbnail = $cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE_NONE)."<br />";
}

//CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, $cms_module_codename, $cms_language, false, -1, CLEARANCE_MODULE_MANAGE, true);

//Prepare form
$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form name="Formular" action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
	<input type="hidden" name="item" value="'.$_REQUEST["item"].'" />';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	// Select parent category
	$attrs = array(
		"module" => $cms_module_codename,
		"language" => $cms_language,
		"level" => 0,
		"root" => -1,
		"cms_user" => &$cms_user,
		"clearanceLevel" => CLEARANCE_MODULE_MANAGE,
		"strict" => true,
	);
	$root_categories = CMS_module::getModuleCategories($attrs);
} else {
	$parentID = $item->getAttribute('parentID');
	if ((sensitiveIO::isPositiveInteger($parentID) && $cms_user->hasModuleCategoryClearance($parentID, CLEARANCE_MODULE_MANAGE, $cms_module_codename)) || !$_REQUEST["item"]) {
		$root_categories = $cms_user->getRootModuleCategoriesManagable($cms_module_codename, true);
	}
}
$selectContent = '';
if (is_array($root_categories) && sizeof($root_categories) > 0) {
	foreach ($root_categories as $aRoot) {
		// Show all sub categories
		$selectContent .= build_category_tree_options($aRoot, 0);
	}
}
if ($selectContent) {
	$content .= '
	<tr>
		<td class="admin">
			<dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARENT_CATEGORY).' : </dialog-title></td>
		<td class="admin">
			<select name="parentID" size="1" class="admin_input_text">';
			if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$content .= '
				<option value="0">'.$cms_language->getMessage(MESSAGE_PAGE_CATEGORIES_ROOT).'</option>
				<option value="0"></option>';
			}
			$content .= '
				'.$selectContent.'
			</select></td>
	</tr>';
}
// Thumbnail
$content .= '
	<tr>
		<td class="admin" valign="top">
			<dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_THUMBNAIL).' :</dialog-title></td>
		<td class="admin" valign="top">
			'.$thumbnail.'
			<input type="file" size="30" class="admin_input_text" name="file" /><br />
			<label for="edit_icon"><input id="edit_icon" type="checkbox" class="admin_input_checkbox" name="edit_icon" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITIMAGE).'</label>
		</td>
	</tr>
	<tr>
		<td class="admin" colspan="2">
			<dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ALL_LABELS).'</dialog-title></td>
	</tr>';

// Build label list of all languages avalaibles
foreach ($all_languages as $aLanguage) {
	
	// File preview
	$thumbnail = '';
	if ($item->getFilePath($aLanguage, false, PATH_RELATIVETO_WEBROOT, true)) {
		$thumbnail = '<a href="'.$item->getFilePath($aLanguage, true).'" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SEE_LINKED_FILE).'</a><br />';
	}
	
	// Insert prefered text editor for textarea field
	$attrs = array(
		'form' => 'Formular',								// Form name
		'field' => 'description_'.$aLanguage->getCode(),	// Field name
		'value' => $item->getDescription($aLanguage),		// Default value
		'language' => $cms_language,						// language
		'width' => '100%',									// textarea width
		'height' => 200,									// textarea width
		'rows' => 8,										// textarea rows
		'toolbarset' => 'BasicLink'							// fckeditor toolbarset
	);
	$text_editor = CMS_textEditor::getEditorFromParams($attrs);
	$dialog->setJavascript($text_editor->getJavascript());
	
	// Default language is mandatory
	$mandatory = ($aLanguage->getCode() == $cms_module->getDefaultLanguageCodename()) ? '<span class="admin_text_alert">*</span>&nbsp;' : '' ;
	$checked = ($aLanguage->getCode() == $cms_language->getCode()) ? ' checked="checked"' : '';
	$content .= '
	<tr>
		<td class="admin" valign="top" align="right">
			<b>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL_IN, array($aLanguage->getLabel())).' :</b>
			'.$mandatory.'</td>
		<td class="admin"><input type="text" size="40" class="admin_input_text" name="label_'.$aLanguage->getCode().'" value="'.htmlspecialchars($item->getLabel($aLanguage)).'" /></td>
	</tr>
	<tr>
		<td class="admin" valign="top" align="right">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).' :</td>
		<td class="admin">'.$text_editor->getHTML().'</td>
	</tr>
	<tr>
		<td class="admin" valign="top" align="right">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE).' :</td>
		<td class="admin">
			'.$thumbnail.'
			<input type="file" size="30" class="admin_input_text" name="file_'.$aLanguage->getCode().'" /><br />
			<label for="edit_file_'.$aLanguage->getCode().'"><input id="edit_file_'.$aLanguage->getCode().'" type="checkbox" class="admin_input_checkbox" name="edit_file_'.$aLanguage->getCode().'" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITFILE).'</label>
		</td>
	</tr>';
}
$content .='
	<tr>
		<td colspan="2">
			<br />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
';

$content .= '
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';

$dialog->setContent($content);
$dialog->show();
?>
