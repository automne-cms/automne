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
// $Id: page_content_block_image_resize.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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

define("MESSAGE_PAGE_TITLE", 1016);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_INTRO", 1017);
define("MESSAGE_PAGE_REINIT", 1018);
define("MESSAGE_PAGE_HEIGHT", 291);
define("MESSAGE_PAGE_WIDTH", 290);
define("MESSAGE_PAGE_IMAGE_MAX_WIDTH", 1160);
define("MESSAGE_PAGE_IMAGE_MIN_WIDTH", 1161);
define("MESSAGE_ERROR_IMAGE_TOO_BIG", 1163);
define("MESSAGE_ERROR_IMAGE_TOO_SMALL", 1162);

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

$cms_block = new CMS_block_image();
$cms_block->initializeFromBasicAttributes($_POST["block"]);

$clientspace_id=$_POST["clientSpace"];
$row_id=$_POST["row"];
$block_id=$_POST["block"];
$maxWidth=($_GET["maxWidth"]) ? base64_decode($_GET["maxWidth"]):$_POST["maxWidth"];
$minWidth=($_GET["minWidth"]) ? base64_decode($_GET["minWidth"]):$_POST["minWidth"];


//grab block content
$data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
$dimensions = getimagesize(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$data["file"]);
$sizeX = $dimensions[0];
$sizeY = $dimensions[1];

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";

	$srcfilepath = PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$data["file"];
	$destfilepath = substr($srcfilepath, 0, strrpos($srcfilepath, '.')) . ".png";
	$extension = strtolower(substr($srcfilepath, strrpos($srcfilepath, '.') + 1));
	$dest = imagecreatetruecolor($_POST["newSizeX"], $_POST["newSizeY"]);
	
	switch ($extension) {
	case "gif":
		$src = imagecreatefromgif($srcfilepath);
		break;
	case "jpg":
	case "jpeg":
	case "jpe":
		$src = imagecreatefromjpeg($srcfilepath);
		break;
	case "png":
		$src = imagecreatefrompng($srcfilepath);
		break;
	}
	imagecopyresampled($dest, $src, 0, 0, 0, 0, $_POST["newSizeX"], $_POST["newSizeY"], $sizeX, $sizeY);
	imagedestroy($src);
	imagepng($dest, $destfilepath);
	@chmod($destfilepath, octdec(FILES_CHMOD));
	imagedestroy($dest);
	if ($destfilepath != $srcfilepath) {
		unlink($srcfilepath);
	}

	//now, update the DB
	$data = array("label" => $_POST["label"]);
	$old_data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
	$data = $old_data;
	$data["file"] = substr($destfilepath, strrpos($destfilepath, '/') + 1);
	if (!$cms_block->writeToPersistence($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false, $data)) {
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
	}
			
	if (!$cms_message) {
		header("Location: ".PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?".session_name()."=".session_id());
		exit;
	}
	break;
}

if (!$data["file"]) {
	die("error, no file to resize");
}

//Then check image min-max width if any
if (($maxWidth || $minWidth) && !($imageTooBig || $imageTooSmall)) {
	if ($maxWidth && $sizeX>$maxWidth) {
		$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_BIG,array($maxWidth))."\n";
		$imageTooBig = true;
	}
	if ($minWidth && $sizeX<$minWidth) {
		$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_IMAGE_TOO_SMALL,array($minWidth))."\n";
	}
}

$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($minWidth || $maxWidth) {
	$widthLabel = '
	<tr>
		<td class="admin">';
	$widthLabel .= ($minWidth) ? $cms_language->getMessage(MESSAGE_PAGE_IMAGE_MIN_WIDTH,array($minWidth)):'';
	$widthLabel .= ($minWidth && $maxWidth) ? ', ':'';
	$widthLabel .= ($maxWidth) ? $cms_language->getMessage(MESSAGE_PAGE_IMAGE_MAX_WIDTH,array($maxWidth)):'';
	$widthLabel .= '
		</td>
	</tr>
	';
}

if ($_POST["back"] && !$imageTooBig) {
	$form='
		<form action="'.$_POST["back"].'" method="post">
	';
	$dialog->setBackLink($_POST["back"]);
} else{
	$form='
		<form action="page_content_block_image.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="page" value="'.$_POST["page"].'" />
		<input type="hidden" name="clientSpace" value="'.$_POST["clientSpace"].'" />
		<input type="hidden" name="row" value="'.$_POST["row"].'" />
		<input type="hidden" name="block" value="'.$_POST["block"].'" />
		<input type="hidden" name="maxWidth" value="'.$maxWidth.'" />
		<input type="hidden" name="minWidth" value="'.$minWidth.'" />
	';
	$dialog->setBackLink('page_content_block_image.php?page='.$_POST["page"].'&clientSpace='.base64_encode($_POST["clientSpace"]).'&row='.base64_encode($_POST["row"]).'&block='.base64_encode($_POST["block"]).'&minWidth='.base64_encode($_POST["minWidth"]).'&maxWidth='.base64_encode($_POST["maxWidth"]));
}

$content = '
	<script type="text/javascript" src="'.PATH_ADMIN_WR.'/js/wz_dragdrop.js"></script>
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data" name="frmResize">
	<input type="hidden" name="page" value="'.$_POST["page"].'" />
	<input type="hidden" name="clientSpace" value="'.$_POST["clientSpace"].'" />
	<input type="hidden" name="row" value="'.$_POST["row"].'" />
	<input type="hidden" name="block" value="'.$_POST["block"].'" />
	<input type="hidden" name="label" value="'.$data["label"].'" />
	<input type="hidden" name="newSizeX" value="' . $sizeX . '" />
	<input type="hidden" name="newSizeY" value="' . $sizeY . '" />
	<input type="hidden" name="cms_action" value="validate" />
	'.$widthLabel.'
	<tr>
		<td class="admin">' . $cms_language->getMessage(MESSAGE_PAGE_INTRO) . '</td>
	</tr>
	<tr>
		<td class="admin">
			<input type="button" class="admin_input_submit" value="' . $cms_language->getMessage(MESSAGE_PAGE_REINIT) . '" onClick="reinit()" />
			<input type="submit" name="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
		</td>
	</tr>
	<tr>
		<td class="admin">
		<br />
		' . $cms_language->getMessage(MESSAGE_PAGE_WIDTH) . ' : <input readonly="true" class="admin_input_view" size="5" type="text" name="vnewSizeX" value="' . $sizeX . '" /> px<br />
		' . $cms_language->getMessage(MESSAGE_PAGE_HEIGHT) . ' : <input readonly="true" class="admin_input_view" size="5" type="text" name="vnewSizeY" value="' . $sizeY . '" /> px<br /><br />
		
		<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"].'" border="0" name="resized" width="' . $sizeX . '" height="' . $sizeY . '" /></td>
	</tr>
	</form>
	</table>
	<br />
';

$jsminWidth = ($minWidth) ? $minWidth:0;
$jsmaxWidth = ($maxWidth) ? $maxWidth:0;

$beforeBody = '
	<script type="text/javascript">
		var minWidth = '.$jsminWidth.';
		var maxWidth = '.$jsmaxWidth.';
		checkSize ();
		SET_DHTML("resized");
		
		function my_ResizeFunc()
		{
			dd.d.frmResize.newSizeX.value = dd.elements.resized.w;
			dd.d.frmResize.newSizeY.value = dd.elements.resized.h;
			dd.d.frmResize.vnewSizeX.value = dd.elements.resized.w;
			dd.d.frmResize.vnewSizeY.value = dd.elements.resized.h;
			checkSize();
		}
		
		function reinit(element)
		{
			dd.elements.resized.resizeTo(dd.elements.resized.defw, dd.elements.resized.defh);
			dd.d.frmResize.newSizeX.value = dd.elements.resized.w;
			dd.d.frmResize.newSizeY.value = dd.elements.resized.h;
			dd.d.frmResize.vnewSizeX.value = dd.elements.resized.w;
			dd.d.frmResize.vnewSizeY.value = dd.elements.resized.h;
			checkSize();
		}
		
		function resizeTo()
		{
			dd.elements.resized.resizeTo(dd.d.frmResize.newSizeX.value, dd.d.frmResize.newSizeY.value);
		}
		
		function checkSize ()
		{
			if (minWidth>0 && dd.d.frmResize.vnewSizeX.value < minWidth) {
				dd.d.frmResize.vnewSizeX.style.backgroundColor = "FF0000";
				dd.d.frmResize.submit.disabled=true;
			}
			if (maxWidth>0 && dd.d.frmResize.vnewSizeX.value > maxWidth) {
				dd.d.frmResize.vnewSizeX.style.backgroundColor = "FF0000";
				dd.d.frmResize.submit.disabled=true;
			}
			if (((maxWidth>0 && dd.d.frmResize.vnewSizeX.value <= maxWidth) || maxWidth==0) && ((minWidth>0 && dd.d.frmResize.vnewSizeX.value >= minWidth) || minWidth==0)) {
				dd.d.frmResize.vnewSizeX.style.backgroundColor = "FFFFFF";
				dd.d.frmResize.submit.disabled=false;
			}
		}
	</script>
';
$dialog->setTextBeforeBody($beforeBody);

$dialog->setContent($content);
$dialog->show('out');
?>