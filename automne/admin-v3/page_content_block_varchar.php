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
// $Id: page_content_block_varchar.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content block edition : varchar
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
define("MESSAGE_PAGE_FIELD_CONTENT", 177);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);

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

$cms_block = new CMS_block_varchar();
$cms_block->initializeFromBasicAttributes($_POST["block"]);

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$cms_block->writeToPersistence($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false, array("value"=>$_POST["content"]))) {
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
	}
	if (!$cms_message) {
		header("Location: ".PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?".session_name()."=".session_id());
		exit;
	}
	break;
default:
	//grab block content
	$data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
	break;
}


$dialog = new CMS_dialog();
$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//prepare data
$content = $data["value"];
$content = str_replace('"', '&quot;', $content);

$content = '
	<table border="0" cellpadding="3" cellspacing="2" width="60%">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data">
	<input type="hidden" name="page" value="'.$_POST["page"].'" />
	<input type="hidden" name="clientSpace" value="'.$_POST["clientSpace"].'" />
	<input type="hidden" name="row" value="'.$_POST["row"].'" />
	<input type="hidden" name="block" value="'.$_POST["block"].'" />
	<input type="hidden" name="cms_action" value="validate" />
	<tr>
		<td class="admin" align="right" width="10">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CONTENT).'</td>
		<td class="admin" width="100%"><input type="text" maxlength="255" class="admin_input_long_text" name="content" value="'.htmlspecialchars($content).'" /></td>
	</tr>
	<tr>
		<td colspan="2"><br /><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
';

$dialog->setContent($content, true);
$dialog->show('out');
?>