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
// $Id: page_content_block_text.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content block edition : text
  * Used to edit a block of text data inside a page.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 176);
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_PARSING_ERROR", 1419);

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

$cms_block = new CMS_block_text();
$cms_block->initializeFromBasicAttributes($_POST["block"]);

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//if fckeditor, we need to create all Automne Links
	if ($cms_user->getTextEditor()=="fckeditor") {
		$_POST["data1"] = FCKeditor::createAutomneLinks($_POST["data1"]);
	}
	//checks and assignments
	$cms_message = "";
	//test the XML validity of the data entered
	$parseError = false;
	$domdocument = new CMS_DOMDocument();
	try {
		$domdocument->loadXML('<dummy>'.$_POST["data1"].'</dummy>');
	} catch (DOMException $e) {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_PARSING_ERROR, array($e->getMessage()))."\n";
		//grab block content
		$parseError = true;
	}
	if (!$parseError) {
		if (!$cms_block->writeToPersistence($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false, array("value"=>$_POST["data1"]))) {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
		}
	}
	$data["value"] = $_POST["data1"];
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

$editor = new CMS_textEditor("Formular", "data1", $data["value"], $_SERVER["HTTP_USER_AGENT"], $cms_user->getTextEditor(), $cms_language);

$dialog->setJavascript($editor->getJavascript());
$editor->setEditorAttributes(array('Height' => 400));
$content = '
	<table border="0" cellpadding="3" cellspacing="2" width="90%">
	<form name="Formular" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="page" value="'.$_POST["page"].'" />
	<input type="hidden" name="clientSpace" value="'.$_POST["clientSpace"].'" />
	<input type="hidden" name="row" value="'.$_POST["row"].'" />
	<input type="hidden" name="block" value="'.$_POST["block"].'" />
	<input type="hidden" name="cms_action" value="validate" />
	<tr>
		<td class="admin">
		' . $editor->getHTML() . '
		</td>
	</tr>
	<tr>
		<td class="admin">
			<input type="submit" value="' . $cms_language->getMessage(MESSAGE_BUTTON_VALIDATE) . '" class="admin_input_submit" />
		</td>
	</tr>
	</form>
	</table>
	<br />
';

$dialog->setContent($content, true);
$dialog->show('out');
?>