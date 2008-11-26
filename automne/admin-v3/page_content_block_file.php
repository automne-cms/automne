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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page_content_block_file.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content block edition : image
  * Used to edit a block of data inside a page.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 176);
define("MESSAGE_PAGE_FIELD_FILE", 191);
define("MESSAGE_PAGE_FIELD_EDITFILE", 192);
define("MESSAGE_PAGE_FIELD_LABEL", 1325);
define("MESSAGE_PAGE_EXISTING_FILE", 202);
define("MESSAGE_PAGE_EXISTING_FILE_NONE", 203);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_FILE_ERROR", 196);
define("MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG", 1045);
define("MESSAGE_PAGE_FILE_MAX_SIZE", 1329);

//RIGHTS CHECK
$cms_page = $cms_context->getPage();
if (!is_object($cms_page) || $cms_page->hasError()
	|| !$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id()));
	exit;
}

//ARGUMENTS CHECK
if (!SensitiveIO::isPositiveInteger($_POST["page"])
	|| !$_POST["clientSpace"]
	|| !$_POST["row"]
	|| !$_POST["block"]) {
	die("Data missing.");
}

$cms_block = new CMS_block_file();
$cms_block->initializeFromBasicAttributes($_POST["block"]);

$clientspace_id=$_POST["clientSpace"];
$row_id=$_POST["row"];
$block_id=$_POST["block"];

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$data = array("label" => $_POST["label"]);
	
	//file upload management
	if ($_POST["edit_file"]) {
		//remove the old file if any
		$old_data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
		if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"])) {
			unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]);
		}
		
		if ($_FILES["file"]["name"]) {
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $cms_block->getFilePath($_FILES["file"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, true))) {
				@chmod ($cms_block->getFilePath($_FILES["file"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, true), octdec(FILES_CHMOD));
				$data["file"] = $cms_block->getFilePath($_FILES["file"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, false);
			} else {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
			}
		} else {
			$data["file"] = '';
		}
	}
	
	if (!$cms_message) {
		if (!isset($data["file"])) {
			$old_data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
			$data["file"] = $old_data["file"];
		}
		if (!$cms_block->writeToPersistence($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false, $data)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
		}
	}
			
	if (!$cms_message) {
		header("Location: ".PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?".session_name()."=".session_id());
		exit;
	}
	break;
}

//grab block content
$data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
if (is_array($data) && $data["file"]) {
	$html_data = '&raquo; <a href="'.PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"].'" class="admin">'.$data["label"].'</a>';
} else {
	$html_data = $cms_language->getMessage(MESSAGE_PAGE_EXISTING_FILE_NONE);
}


$dialog = new CMS_dialog();
$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data">
	<input type="hidden" name="page" value="'.$_POST["page"].'" />
	<input type="hidden" name="clientSpace" value="'.$_POST["clientSpace"].'" />
	<input type="hidden" name="row" value="'.$_POST["row"].'" />
	<input type="hidden" name="block" value="'.$_POST["block"].'" />
	<input type="hidden" name="cms_action" value="validate" />
	<tr>
		<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE).'</td>
		<td class="admin">
			<input type="file" size="50" class="admin_input_text" name="file" /> <small>'.$cms_language->getMessage(MESSAGE_PAGE_FILE_MAX_SIZE, array(ini_get("upload_max_filesize"))).'</small><br />
			<label for="editfile"><input id="editfile" type="checkbox" class="admin_input_checkbox" name="edit_file" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITFILE).'</label>
		</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="label" value="'.htmlspecialchars($data["label"]).'" /></td>
	</tr>
	<tr colspan="2">
		<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_PAGE_EXISTING_FILE).' : <br />
	'.$html_data.'
	<br />
';

$dialog->setContent($content);
$dialog->show('out');
?>