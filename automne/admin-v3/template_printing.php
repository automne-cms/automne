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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: template_printing.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template base data
  * Used to edit the templates base data.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1053);
define("MESSAGE_PAGE_H1", 1054);
define("MESSAGE_PAGE_SUBTTL_PRINTED", 1056);
define("MESSAGE_PAGE_SUBTTL_NOT_PRINTED", 1055);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DONTPRINT", 1057);
define("MESSAGE_PAGE_ACTION_PRINT", 1058);
define("MESSAGE_PAGE_ACTION_APPLY", 1059);
define("MESSAGE_PAGE_CS_NONE", 195);


//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

$template = CMS_pageTemplatesCatalog::getByID($_POST["template"]);

//Action management	
switch ($_POST["cms_action"]) {
case "up":
	$print_clientspaces = $template->getPrintingClientSpaces();
	$pcs_new = array();
	for ($i = 0 ; $i < sizeof($print_clientspaces) ; $i++) {
		if ($print_clientspaces[$i+1] == $_POST["clientspace"]) {
			$pcs_new[] = $print_clientspaces[$i+1];
			$pcs_new[] = $print_clientspaces[$i];
			$i++;
		} else {
			$pcs_new[] = $print_clientspaces[$i];
		}
	}
	$template->setPrintingClientSpaces(implode(";", $pcs_new));
	$template->writeToPersistence();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "down":
	$print_clientspaces = $template->getPrintingClientSpaces();
	$pcs_new = array();
	for ($i = 0 ; $i < sizeof($print_clientspaces) ; $i++) {
		if ($print_clientspaces[$i] == $_POST["clientspace"] && $i != sizeof($print_clientspaces) - 1) {
			$pcs_new[] = $print_clientspaces[$i+1];
			$pcs_new[] = $print_clientspaces[$i];
			$i++;
		} else {
			$pcs_new[] = $print_clientspaces[$i];
		}
	}
	$template->setPrintingClientSpaces(implode(";", $pcs_new));
	$template->writeToPersistence();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "dontprint":
	$print_clientspaces = $template->getPrintingClientSpaces();
	$key = array_search($_POST["clientspace"], $print_clientspaces);
	if ($key !== false) {
		unset($print_clientspaces[$key]);
	}
	$template->setPrintingClientSpaces(implode(";", $print_clientspaces));
	$template->writeToPersistence();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "print":
	$print_clientspaces = $template->getPrintingClientSpaces();
	if (!in_array($_POST["clientspace"], $print_clientspaces)) {
		$print_clientspaces[] = $_POST["clientspace"];
	}
	$template->setPrintingClientSpaces(implode(";", $print_clientspaces));
	$template->writeToPersistence();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "apply":
	//submit all pages of this template to the regenerator
	$pages = $template->getPages();
	$pages_ids = array();
	foreach ($pages as $page) {
		if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
			$pages_ids[] = $page->getID();
		}
	}
	if (sizeof($pages_ids)) {
		CMS_tree::submitToRegenerator($pages_ids, true);
	}
	header("Location: templates.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
	exit;
	break;
}

$template = CMS_pageTemplatesCatalog::getByID($_POST["template"]);
$cstags = $template->getClientSpacesTags();
if (!is_array($cstags)) {
	$cstags = array();
}
$clientspaces = array();
$print_clientspaces = $template->getPrintingClientSpaces();
foreach ($cstags as $tag) {
	$id = $tag->getAttribute("id");
	$module = $tag->getAttribute("module");
	//if ($module == MOD_STANDARD_CODENAME && !in_array($id, $print_clientspaces)) {
	if (!in_array($id, $print_clientspaces)) {
		$clientspaces[] = $id;
	}
}

$dialog = new CMS_dialog();
$dialog->setBackLink("templates.php?template=".$template->getID() . '&' . $_SERVER["QUERY_STRING"]);
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//PRINTED TEMPLATES
$content = $cms_language->getMessage(MESSAGE_PAGE_H1).'<br /><br />
	<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTTL_PRINTED).'</dialog-title>';
if (sizeof($print_clientspaces)) {
	$content .= '
	<table border="0" cellpadding="3" cellspacing="2">
	<tr>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
	</tr>';
	$count = 0;
	foreach ($print_clientspaces as $cs) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		
		$content .= '
			<tr>
				<td class="' . $td_class . '">' . $cs . '</td>
				<td class="' . $td_class . '">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post">
						<input type="hidden" name="cms_action" value="up" />
						<input type="hidden" name="template" value="'.$template->getID().'" />
						<input type="hidden" name="clientspace" value="'.$cs.'" />
						<td><input type="image" class="admin_input_image" src="'.PATH_ADMIN_IMAGES_WR.'/fleche_haut.gif" /></td>
						</form>
						<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post">
						<input type="hidden" name="cms_action" value="down" />
						<input type="hidden" name="template" value="'.$template->getID().'" />
						<input type="hidden" name="clientspace" value="'.$cs.'" />
						<td><input type="image" class="admin_input_image" src="'.PATH_ADMIN_IMAGES_WR.'/fleche_bas.gif" /></td>
						</form>
						<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post">
						<input type="hidden" name="cms_action" value="dontprint" />
						<input type="hidden" name="template" value="'.$template->getID().'" />
						<input type="hidden" name="clientspace" value="'.$cs.'" />
						<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DONTPRINT).'" /></td>
						</form>
					</tr>
					</table>
				</td>
			</tr>
		';
	}
	$content .= '</table>';
} else {
	$content .= '<br />'.$cms_language->getMessage(MESSAGE_PAGE_CS_NONE);
}
//NOT PRINTED TEMPLATES
$content .= '
	<br /><br />
	<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTTL_NOT_PRINTED).'</dialog-title>';
if (sizeof($clientspaces)) {
	$content .= '
	<table border="0" cellpadding="3" cellspacing="2">
	<tr>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
	</tr>';
	
	$count = 0;
	foreach ($clientspaces as $cs) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		
		$content .= '
			<tr>
				<td class="' . $td_class . '">' . $cs . '</td>
				<td class="' . $td_class . '">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post">
						<input type="hidden" name="cms_action" value="print" />
						<input type="hidden" name="template" value="'.$template->getID().'" />
						<input type="hidden" name="clientspace" value="'.$cs.'" />
						<td><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_PRINT).'" /></td>
						</form>
					</tr>
					</table>
				</td>
			</tr>
		';
	}
	$content .= '</table>';
} else {
	$content .= '<br />'.$cms_language->getMessage(MESSAGE_PAGE_CS_NONE);
}
$content .= '
	<br /><br />
	<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post">
	<input type="hidden" name="cms_action" value="apply" />
	<input type="hidden" name="template" value="'.$template->getID().'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_APPLY).'" />
	</form>
	<br />
';

$dialog->setContent($content);
$dialog->show();

?>