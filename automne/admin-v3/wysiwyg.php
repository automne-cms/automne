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
// $Id: wysiwyg.php,v 1.2 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : Wysiwyg toolbars management
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1400);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_FIELD_CHOOSE", 1132);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 1401);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_CODENAME", 1306);
define("MESSAGE_PAGE_FIELD_CODENAME_ALPHANUM", 1307);
define("MESSAGE_PAGE_SAVE_NEWORDER", 1183);
define("MESSAGE_PAGE_ACTION_ORDERING_ERROR", 1353);
define("MESSAGE_PAGE_FIELD_ELEMENTS", 1402);
define("MESSAGE_PAGE_SEPARATOR_ELEMENT", 1398);
define("MESSAGE_PAGE_FIELD_ADD", 260);
define("MESSAGE_PAGE_FIELD_DELETE", 854);
define("MESSAGE_FORM_ERROR_CODENAME_USED", 1308);
define("MESSAGE_PAGE_FIELD_TOOLBAR", 1404);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//get all toolbars
$toolbars = CMS_wysiwyg_toolbar::getAll($cms_user);
$cms_message = '';
switch ($_POST["cms_action"]) {
case "validate":
	$toolbar = new CMS_wysiwyg_toolbar($_POST['toolbar'], $cms_user);
	if (!$_POST['label'] || !$_POST['code']) {
		
	}
	if (!$toolbar->getID() && (!$_POST["code"] || $_POST["code"] != substr(sensitiveIO::sanitizeAsciiString($_POST["code"]),0,20))) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME)));
	} elseif ($_POST['code'] && !$toolbar->getID()) {
		foreach ($toolbars as $aToolbar) {
			if ($aToolbar->getCode() == $_POST["code"]) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_CODENAME_USED);
			}
		}
		if (!$cms_message) {
			$toolbar->setCode($_POST["code"]);
		}
	}
	$toolbar->setLabel($_POST["label"]);
	$toolbar->setElements(explode(';',$_POST["elements"]));
	if (!$cms_message) {
		$toolbar->writeToPersistence();
		//get all toolbars again
		$toolbars = CMS_wysiwyg_toolbar::getAll($cms_user);
	}
	break;
case "new":
	$toolbar = new CMS_wysiwyg_toolbar('', $cms_user);
	break;
case "change":
	$toolbar = new CMS_wysiwyg_toolbar($_POST['toolbar'], $cms_user);
	break;
case "delete":
	$toolbar = new CMS_wysiwyg_toolbar($_POST['toolbar'], $cms_user);
	$toolbar->destroy();
	unset($toolbar);
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content .= '
<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
	<input id="toolbarSelectAction" type="hidden" name="cms_action" value="change" />';
	if (is_array($toolbars) && $toolbars) {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_TOOLBAR).' : <select name="toolbar" onchange="submit();" class="admin_input_text">
			<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CHOOSE).'</option>';
			foreach ($toolbars as $aToolbar) {
				$selected = (is_object($toolbar) && $toolbar->getID() == $aToolbar->getID()) ? ' selected="selected"' : '';
				$content .= '<option value="'.$aToolbar->getID().'"'.$selected.'>'.$aToolbar->getLabel().'</option>';
			}
		$content .= '
		</select>';
	}
	if (isset($toolbar) && sensitiveIO::isPositiveInteger($toolbar->getID())) {
		$content .= '&nbsp;<input type="button" class="admin_input_submit" name="delete" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" onclick="if (confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM)) . '\')) {document.getElementById(\'toolbarSelectAction\').value=\'delete\';submit();}" />';
	}
	$content .= '
	&nbsp;<input type="button" class="admin_input_submit" name="new" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" onclick="document.getElementById(\'toolbarSelectAction\').value=\'new\';submit();" />
</form><br /><br />';

if (is_object($toolbar)) {
	$content .= '
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" name="frmitem">
	<input id="toolbarAction" type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="toolbar" value="'.$toolbar->getID().'" />
	<table border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
		<td class="admin"><input type="text" class="admin_input_text" name="label" value="'.$toolbar->getLabel().'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME).'</td>
		<td class="admin">';
		$content .= (sensitiveIO::isPositiveInteger($toolbar->getID())) ? $toolbar->getCode() : '<input type="text" class="admin_input_text" name="code" value="'.$toolbar->getCode().'" />  <small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME_ALPHANUM).')</small>';
		$content .= '
		</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ELEMENTS).'</td>
		<td class="admin">
			';
			$allElements = CMS_wysiwyg_toolbar::getAllElements($cms_user);
			//pr($toolbar->getElements());
			//pr($allElements);
			$args = array(
				'field_name' => 'elements',
				'items_possible' => $allElements,
				'items_selected' => $toolbar->getElements(),
				'select_width' 		=> '300px',					// Width of selects, default 200px
				'select_height' 	=> '200px',					// Height of selects, default 140px
				'form_name' 		=> 'frmitem'				// Javascript form name
			);
			$content .= CMS_dialog_listboxes::getListBoxes($args).'
		</td>
	</tr>
	</table>
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
	</form>';
}

$dialog->setContent($content);
$dialog->show();
?>