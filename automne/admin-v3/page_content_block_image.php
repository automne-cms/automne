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
// $Id: page_content_block_image.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content block edition : image
  * Used to edit a block of data inside a page.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 176);
define("MESSAGE_PAGE_FIELD_FILE", 191);
define("MESSAGE_PAGE_FIELD_FILE_ZOOM", 968);
define("MESSAGE_PAGE_FIELD_EDITFILE", 192);
define("MESSAGE_PAGE_FIELD_LABEL", 193);
define("MESSAGE_PAGE_FIELD_LINK", 274);
define("MESSAGE_PAGE_NOLINK", 275);
define("MESSAGE_PAGE_INTERNALLINK", 276);
define("MESSAGE_PAGE_EXTERNALLINK", 277);
define("MESSAGE_PAGE_EXISTING_IMAGE", 194);
define("MESSAGE_PAGE_EXISTING_IMAGE_NONE", 195);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_FILE_ERROR", 196);
define("MESSAGE_PAGE_RESIZE", 1015);
define("MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG", 1045);
define("MESSAGE_PAGE_NO_GD2_LIBRARY", 1030);
define("MESSAGE_PAGE_TREEH1", 1031);
define("MESSAGE_PAGE_OR", 1098);
define("MESSAGE_PAGE_IMAGE_MAX_WIDTH", 1160);
define("MESSAGE_PAGE_IMAGE_MIN_WIDTH", 1161);
define("MESSAGE_ERROR_IMAGE_TOO_BIG", 1163);
define("MESSAGE_ERROR_IMAGE_TOO_SMALL", 1162);
define("MESSAGE_PAGE_FILE_MAX_SIZE", 1329);

//RIGHTS CHECK
$cms_page = $cms_context->getPage();
if (!is_object($cms_page) || $cms_page->hasError()
	|| !$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id()));
	exit;
}

$page_id=($_GET["page"]) ? $_GET["page"]:$_POST["page"];
$clientspace_id=($_GET["clientSpace"]) ? base64_decode($_GET["clientSpace"]):$_POST["clientSpace"];
$row_id=($_GET["row"]) ? base64_decode($_GET["row"]):$_POST["row"];
$block_id=($_GET["block"]) ? base64_decode($_GET["block"]):$_POST["block"];
$maxWidth=($_GET["maxWidth"]) ? base64_decode($_GET["maxWidth"]):$_POST["maxWidth"];
$minWidth=($_GET["minWidth"]) ? base64_decode($_GET["minWidth"]):$_POST["minWidth"];

//ARGUMENTS CHECK
if (!SensitiveIO::isPositiveInteger($page_id)
	|| !$clientspace_id
	|| !$row_id
	|| !$block_id) {
	die("Data missing...");
}

$cms_block = new CMS_block_image();
$cms_block->initializeFromBasicAttributes($block_id);

//Action management
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$old_data = $cms_block->getRawData($page_id, $clientspace_id, $row_id, RESOURCE_LOCATION_EDITION, false);
	$href = new CMS_href($old_data['externalLink']);
	$hrefDialog = new CMS_dialog_href($href);
	$href = ($hrefDialog->doPost(MOD_STANDARD_CODENAME,$page_id)) ? $hrefDialog->getHref() : '';
	$href = (is_a($href,'CMS_href')) ? $href->getTextDefinition() : '';
	
	$data = array(
		"label" 		=> $_POST["label"],
		"linkType" 		=> '',
		"internalLink" 	=> '',
		"externalLink" 	=> $href
	);
	//file upload management
	if ($_POST["edit_file"]) {
		// Check file size and server max uploading file size
		if ($_FILES['file']['error']==1 || $_FILES["file"]["size"] > (ini_get("upload_max_filesize")*1048576)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG, array(ini_get("upload_max_filesize")))."\n";
		} else {
			//remove the old file if any
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
	}
	
	//anlarged file upload management
	if ($_POST["edit_enlarged_file"]) {
		// Check file size and server max uploading file size
		if ($_FILES['enlargedFile']['error']==1 || $_FILES["enlargedFile"]["size"] > (ini_get("upload_max_filesize")*1048576)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG, array(ini_get("upload_max_filesize")))."\n";
		} else {
			//remove the old file if any
			if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["enlargedFile"])) {
				unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["enlargedFile"]);
			}
			
			if ($_FILES["enlargedFile"]["name"]) {
				if (move_uploaded_file($_FILES["enlargedFile"]["tmp_name"], $cms_block->getFilePath($_FILES["enlargedFile"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, true, true))) {
					@chmod ($cms_block->getFilePath($_FILES["enlargedFile"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, true, true), octdec(FILES_CHMOD));
					$data["enlargedFile"] = $cms_block->getFilePath($_FILES["enlargedFile"]["name"], $cms_page, $clientspace_id, $row_id, $block_id, false, true);
				} else {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
				}
			} else {
				$data["enlargedFile"] = '';
			}
		}
	}
	
	//Check image min-max width if any
	if ($maxWidth || $minWidth) {
		$imageFile = ($data["file"]) ? $data["file"]:$old_data["file"];
		if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$imageFile)) {
			$dimensions = getimagesize(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$imageFile);
			if ($maxWidth && $dimensions[0]>$maxWidth) {
				//don't raise an error here because this image can be resized so the process need to continue
				$imageTooBig = true;
			}
			if ($minWidth && $dimensions[0]<$minWidth) {
				//don't raise an error here, the process need to continue
				$imageTooSmall = true;
				//remove the too smal image
				if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$data["file"])) {
					unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$data["file"]);
				}
				$data["file"] = '';
			}
		}
	}
	
	if (!$cms_message) {
		if (!isset($data["file"])) {
			$old_data = $cms_block->getRawData($page_id, $clientspace_id, $row_id, RESOURCE_LOCATION_EDITION, false);
			$data["file"] = $old_data["file"];
		}
		if (!isset($data["enlargedFile"])) {
			$old_data = $cms_block->getRawData($page_id, $clientspace_id, $row_id, RESOURCE_LOCATION_EDITION, false);
			$data["enlargedFile"] = $old_data["enlargedFile"];
		}
		if (!$cms_block->writeToPersistence($page_id, $clientspace_id, $row_id, RESOURCE_LOCATION_EDITION, false, $data)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
		}
		//now we can raise the error
		if ($imageTooBig) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_BIG,array($maxWidth))."\n";
		}
		if ($imageTooSmall) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_SMALL,array($minWidth))."\n";
		}
	}
	if (!$cms_message) {
		header("Location: ".PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?".session_name()."=".session_id());
		exit;
	}
	break;
}

//build tree link
$grand_root = CMS_tree::getRoot();
$href = PATH_ADMIN_SPECIAL_TREE_WR;
$href .= '?root='.$grand_root->getID();
$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('internalLink').value = '%s';self.close();");
$href .= '&amp;heading='.$cms_language->getMessage(MESSAGE_PAGE_TREEH1);
$href .= '&encodedPageLink='.base64_encode('false');

//grab block content
$data = $cms_block->getRawData($page_id, $clientspace_id, $row_id, RESOURCE_LOCATION_EDITION, false);

//Then check image min-max width if any
if (($maxWidth || $minWidth) && !($imageTooBig || $imageTooSmall)) {
	if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$data["file"])) {
		$dimensions = getimagesize(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$data["file"]);
		if ($maxWidth && $dimensions[0]>$maxWidth) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_BIG,array($maxWidth))."\n";
			$imageTooBig=true;
		}
		if ($minWidth && $dimensions[0]<$minWidth) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_SMALL,array($minWidth))."\n";
			$imageTooSmall = true;
		}
	}
}

$dialog = new CMS_dialog();
if (!$imageTooBig) {
	$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR);
}
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//if image too big, display a big button to resize image
if ($imageTooBig) {
	$content .= '
		<form action="page_content_block_image_resize.php" method="post">
		<input type="hidden" name="page" value="'.$page_id.'" />
		<input type="hidden" name="clientSpace" value="'.$clientspace_id.'" />
		<input type="hidden" name="row" value="'.$row_id.'" />
		<input type="hidden" name="block" value="'.$block_id.'" />
		<input type="hidden" name="maxWidth" value="'.$maxWidth.'" />
		<input type="hidden" name="minWidth" value="'.$minWidth.'" />
		<input type="submit" class="admin_input_submit" value="' . $cms_language->getMessage(MESSAGE_PAGE_RESIZE) . '" />
		</form>';
}

if ($minWidth || $maxWidth) {
	$widthLabel = '
	<tr>
		<td class="admin" colspan="2">';
	$widthLabel .= ($minWidth) ? $cms_language->getMessage(MESSAGE_PAGE_IMAGE_MIN_WIDTH,array($minWidth)):'';
	$widthLabel .= ($minWidth && $maxWidth) ? ', ':'';
	$widthLabel .= ($maxWidth) ? $cms_language->getMessage(MESSAGE_PAGE_IMAGE_MAX_WIDTH,array($maxWidth)):'';
	$widthLabel .= '
		</td>
	</tr>
	';
}

$content .= '
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data">
	<input type="hidden" name="page" value="'.$page_id.'" />
	<input type="hidden" name="clientSpace" value="'.$clientspace_id.'" />
	<input type="hidden" name="row" value="'.$row_id.'" />
	<input type="hidden" name="block" value="'.$block_id.'" />
	<input type="hidden" name="maxWidth" value="'.$maxWidth.'" />
	<input type="hidden" name="minWidth" value="'.$minWidth.'" />
	<input type="hidden" name="cms_action" value="validate" />
	'.$widthLabel.'
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
	<tr>
		<td class="admin" valign="top" colspan="3">
		<fieldset id="link" class="admin">
			<legend class="admin"><b>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK).'</b></legend>
				<table border="0" cellpadding="3" cellspacing="2">
				<tr>
					<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE_ZOOM).'</td>
					<td class="admin">
						<input type="file" size="50" class="admin_input_text" name="enlargedFile" /> <small>'.$cms_language->getMessage(MESSAGE_PAGE_FILE_MAX_SIZE, array(ini_get("upload_max_filesize"))).'</small><br />
						<label for="edit_enlarged_file"><input id="edit_enlarged_file" type="checkbox" class="admin_input_checkbox" name="edit_enlarged_file" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITFILE).'</label>
					</td>
				</tr>
				<tr>
					<td class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_OR).'....</strong></td>
					<td class="admin"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" width="1" height="1" border="0" /><br /><br /></td>
				</tr>';
	// LINK
	$href = new CMS_href($data['externalLink']);
	$hrefDialog = new CMS_dialog_href($href);
	$content .= 
	'<tr>
		<td colspan="2">
			'.$hrefDialog->getHTMLFields($cms_language,MOD_STANDARD_CODENAME,RESOURCE_DATA_LOCATION_EDITION,array('label' => false)).'
		</td>
	</tr>';
	$content .= '
			</table>
			</fieldset>
		</td>
	</tr>
	<tr colspan="2">
		<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />';

if (is_array($data) && $data["file"]) {
	if (function_exists("imagecreatefromgif") && function_exists("imagecreatefromjpeg") && function_exists("imagecreatefrompng") && function_exists("imagecopyresampled")) {
		$currentImage = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"].'" border="0" />';
		if($href->getHTML($currentImage,MOD_STANDARD_CODENAME,RESOURCE_DATA_LOCATION_EDITION)){
			$currentImage = $href->getHTML($currentImage,MOD_STANDARD_CODENAME,RESOURCE_DATA_LOCATION_EDITION);
		}
		$content .= '
			<form action="page_content_block_image_resize.php" method="post">
			<input type="hidden" name="page" value="'.$page_id.'" />
			<input type="hidden" name="clientSpace" value="'.$clientspace_id.'" />
			<input type="hidden" name="row" value="'.$row_id.'" />
			<input type="hidden" name="block" value="'.$block_id.'" />
			<input type="hidden" name="maxWidth" value="'.$maxWidth.'" />
			<input type="hidden" name="minWidth" value="'.$minWidth.'" />
			<input type="image" src="'.PATH_ADMIN_IMAGES_WR.'/resize.gif" value="' . $cms_language->getMessage(MESSAGE_PAGE_RESIZE) . '" /> '.$cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE).' :<br />
			'.$currentImage.'
			</form>
		';
	} else {
		$currentImage = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"].'" border="0" />';
		if($href->getHTML()){
			$currentImage = $href->getHTML($currentImage);
		}
		$content .= '<span class="admin_text_alert">'.$cms_language->getMessage(MESSAGE_PAGE_NO_GD2_LIBRARY).'</span><br /><br />
		'.$cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE).' :<br />
		'.$currentImage.'<br /><br />';
	}
	if ($data["enlargedFile"]) {
		$currentImage = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["enlargedFile"].'" border="0" />';
		if($href->getHTML()){
			$currentImage = $href->getHTML($currentImage);
		}
		$content .= '
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE_ZOOM).' :<br />
			'.$currentImage.'<br />
		';
	}
} else {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE).' : '.$cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE_NONE);
}

$dialog->setContent($content);
$dialog->show('out');
?>