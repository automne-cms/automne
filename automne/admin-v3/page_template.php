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
// $Id: page_template.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template chooser
  * Used to choose a template for a new page.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 186);
define("MESSAGE_PAGE_TITLE_CREATION", 130);
define("MESSAGE_PAGE_CHOOSE", 185);
define("MESSAGE_PAGE_ERROR", 188);
define("MESSAGE_EMPTY_TEMPLATE", 1068);
define("MESSAGE_NOEMPTY_TEMPLATE", 1100);
define("MESSAGE_PAGE_TITLE_CREATION_UNDER", 1087);
define("MESSAGE_PAGE_ROWS", 1012);

//RIGHTS CHECK
$cms_page = $cms_context->getPage();

if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_OUT_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT)."&".session_name()."=".session_id());
	exit;
}

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//copy the template
	$pageTpl = CMS_pageTemplatesCatalog::getCloneFromID($_POST["template"], false, true, $_POST["empty_template"]);
	
	if ($cms_page->setTemplate($pageTpl->getID())) {
		$cms_page->writeToPersistence();
		$visual_mode = PAGE_VISUALMODE_FORM; //($_POST["empty_template"]) ? PAGE_VISUALMODE_CLIENTSPACES_FORM : PAGE_VISUALMODE_FORM;
		$viewWhat = ($_POST["empty_template"]) ? 'row' : '';
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($pageTpl->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
		header("Location: ".PATH_ADMIN_SPECIAL_OUT_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?template=" . $pageTpl->getID() . "&cms_visualmode=" . $visual_mode . "&use_mode=creation&viewWhat=".$viewWhat)."&".session_name()."=".session_id());
		exit;
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR);
	}
	break;
}

$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_CREATION, array("2")));
$content .='<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_TITLE).'</dialog-title>';
$dialog->reloadTree();

$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?unlock_page=1');

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//get array of available templates
$selected_templates = CMS_pageTemplatesCatalog::getAvailableTemplatesForUser($cms_user);

$content .= '
	<br />
	<form name="frm" method="post" action="' .$_SERVER["SCRIPT_NAME"]. '">
	<input type="hidden" name="cms_action" value="validate" />
	<table border="0" cellpadding="0" cellspacing="8"><tr>';

	for ($count = 0 ; $count < sizeof($selected_templates) ; $count++) {
		if ($count % 3 == 0 && $count!='0') {
			$content .= '</tr><tr>';
		}
		$template = $selected_templates[$count];
		$imgSrc = ($template->getImage()) ? $template->getImage() : 'nopicto.gif';
		$checked= (!$count) ? ' checked="checked"':'';
		$content .= '
		<td valign="top" class="admin">
			<img border="1" bordercolor="#000000" onClick="javascript:document.frm.template_' .$template->getID(). '.checked=true;" width="150" src="' .PATH_TEMPLATES_IMAGES_WR . "/" . $imgSrc . '" /><br />
			<label for="template_' .$template->getID(). '">
				<input type="radio" name="template" id="template_' .$template->getID(). '" value="' .$template->getID(). '"'.$checked.' />&nbsp;' .$template->getLabel(). '
			</label>
		</td>';
	}
	$content .= '</tr></table><br />
	<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_ROWS).'</dialog-title>
	<label for="empty_template_0">
		<input type="radio" id="empty_template_0" name="empty_template" value="0" checked="checked" /> ' . $cms_language->getMessage(MESSAGE_NOEMPTY_TEMPLATE) . '<br />
	</label>
	<label for="empty_template_1">
		<input type="radio" id="empty_template_1" name="empty_template" value="1" /> ' . $cms_language->getMessage(MESSAGE_EMPTY_TEMPLATE) . '<br />
	</label>
	<br />
	<input type="submit" value="Valider" class="admin_input_submit" />
	</form>
';

$dialog->setContent($content);
$dialog->show();

?>