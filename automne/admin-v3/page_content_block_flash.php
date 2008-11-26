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
// $Id: page_content_block_flash.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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
define("MESSAGE_PAGE_FIELD_LABEL", 201);
define("MESSAGE_PAGE_FIELD_NAME", 298);
define("MESSAGE_PAGE_FIELD_WIDTH", 290);
define("MESSAGE_PAGE_FIELD_HEIGHT", 291);
define("MESSAGE_PAGE_FIELD_PARAM_WMODE", 292);
define("MESSAGE_PAGE_FIELD_PARAM_SWLIVECONNECT", 293);
define("MESSAGE_PAGE_FIELD_PARAM_BGCOLOR", 300);
define("MESSAGE_PAGE_FIELD_PARAM_MENU", 295);
define("MESSAGE_PAGE_FIELD_PARAM_SCALE", 296);
define("MESSAGE_PAGE_FIELD_PARAM_QUALITY", 297);
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

$cms_block = new CMS_block_flash();
$cms_block->initializeFromBasicAttributes($_POST["block"]);

$clientspace_id=$_POST["clientSpace"];
$row_id=$_POST["row"];
$block_id=$_POST["block"];

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$data = array(
				"name" => $_POST["name"],
				"width" => $_POST["width"],
				"height" => $_POST["height"],
				"scale" => $_POST["scale"],
				"quality" => $_POST["quality"],
				"wmode" => $_POST["wmode"],
				"swliveConnect" => $_POST["swliveConnect"],
				"bgcolor" => $_POST["bgcolor"],
				"menu" => $_POST["menu"]
				);
	
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
	$html_data = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
						codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=6,0,0,0" 
						width="'.$data["width"].'" 
						height="'.$data["height"].'" 
						id="'.$data["name"].'" 
						name="'.$data["name"].'" 
						vspace="0" hspace="0"'.$html_attributes.'>
						<param name="src" value="'.PATH_MODULES_FILES_STANDARD_WR.'/edited/'.$data["file"].'" />
						<param name="scale" value="'.$data["scale"].'" />
						<param name="quality" value="'.$data["quality"].'" />
						<param name="menu" value="'.$data["menu"].'" />
						<param name="wmode" value="'.$data["wmode"].'" />
						<param name="swliveConnect" value="'.$data["swliveConnect"].'" />
						<embed pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash"
							type="application/x-shockwave-flash"
							src="'.PATH_MODULES_FILES_STANDARD_WR.'/edited/'.$data["file"].'"
							id="'.$data["name"].'"
							name="'.$data["name"].'"
							width="'.$data["width"].'"
							height="'.$data["height"].'"
							menu="'.$data["menu"].'"
							quality="'.$data["quality"].'"
							scale="'.$data["scale"].'" 
							swliveconnect="'.$data["swliveConnect"].'"
							border="0" hspace="0" vspace="0"'.$html_attributes.'></embed>
					</object>';
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
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE).'</td>
		<td class="admin">
			<input type="file" size="50" class="admin_input_text" name="file" /> <small>'.$cms_language->getMessage(MESSAGE_PAGE_FILE_MAX_SIZE, array(ini_get("upload_max_filesize"))).'</small><br />
			<label for="editfile"><input id="editfile" type="checkbox" class="admin_input_checkbox" name="edit_file" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITFILE).'</label>
		</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_NAME).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="name" value="'.htmlspecialchars($data["name"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_WIDTH).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="width" value="'.htmlspecialchars($data["width"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_HEIGHT).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="height" value="'.htmlspecialchars($data["height"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_SCALE).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="scale" value="'.htmlspecialchars($data["scale"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_QUALITY).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="quality" value="'.htmlspecialchars($data["quality"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_WMODE).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="wmode" value="'.htmlspecialchars($data["wmode"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_MENU).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="menu" value="'.htmlspecialchars($data["menu"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_BGCOLOR).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="bgcolor" value="'.htmlspecialchars($data["bgcolor"]).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAM_SWLIVECONNECT).'</td>
		<td class="admin"><input type="text" size="50" class="admin_input_text" name="swliveConnect" value="'.htmlspecialchars($data["swliveConnect"]).'" /></td>
	</tr>
	<tr colspan="2">
		<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_PAGE_EXISTING_FILE).'<br />
	'.$html_data.'
	<br />
';

$dialog->setContent($content);
$dialog->show('out');
?>