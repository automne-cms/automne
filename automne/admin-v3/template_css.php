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
// $Id: template_css.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template css edition
  * Used to edit the css that compose the client spaces contained in the page templates
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 950);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_DEFINITION", 846);
define("MESSAGE_PAGE_TEXT", 1111);
define("MESSAGE_PAGE_CSS_ERROR", 961);
define("MESSAGE_PAGE_CSS_EDITED", 967);


//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$_POST["cssFile"] || !$_POST["definition"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		$filename = PATH_CSS_FS.'/'.$_POST["cssFile"];
		
		$fh = @fopen($filename, "wb");
		if (is_resource($fh)) {
			$definition = $_POST["definition"];
			
			$write = fwrite($fh, $definition);
			fclose($fh);
			@chmod ($filename, octdec(FILES_CHMOD));
		}
		if ($write === false) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_CSS_ERROR);
		}
		if (!$cms_message) {
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_CSS, $cms_user, "CSS : ".$_POST["cssFile"]);
			header("Location: templates.php?currentOnglet=2&cms_message_id=".MESSAGE_PAGE_CSS_EDITED."&".session_name()."=".session_id());
			exit;
		}
	}
	break;
}


$filename = PATH_CSS_FS.'/'.$_POST["cssFile"];
if (file_exists($filename)) {
	$fp = @fopen($filename, 'rb');
		if (is_resource($fp)) {
			$definition = fread($fp, filesize ($filename));
			fclose($fp);
		}
} else {
	die("parameter or CSS file missing...");
	exit;
}

$dialog = new CMS_dialog();
$dialog->setBackLink("templates.php?currentOnglet=2");
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content = '
	'.$cms_language->getMessage(MESSAGE_PAGE_TEXT, array(APPLICATION_LABEL)).'<br />
	<br />
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="cssFile" value="'.$_POST["cssFile"].'" />
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
		<td class="admin">'.htmlspecialchars($_POST["cssFile"]).'</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).'</td>
		<td class="admin">
			<textarea class="admin_textarea" name="definition" rows="30" cols="130">'.stripslashes(htmlspecialchars($definition)).'</textarea>
		</td>
	</tr>
	<tr colspan="2">
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';

$dialog->setContent($content);
$dialog->show();

?>