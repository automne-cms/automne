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
// $Id: template_clientSpaces.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template client spaces edition
  * Used to edit the client spaces that compose the template
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 852);
define("MESSAGE_PAGE_ACTION_ACTIONS", 181);
define("MESSAGE_BUTTON_SAVE", 952);

//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT)."&".session_name()."=".session_id());
	exit;
}

$template = CMS_pageTemplatesCatalog::getByID($_GET["template"]);

//before do anaything on templates rows, 
//check if this template is correctly separated from all pages
//only for Automnes migrated from V2
$template->checkTemplateSeparation();

//Action management	
if ($_GET["cms_action"]) {
	//check for mandatory vars
	if ($_GET["template"] && $_GET["clientSpaceTagID"] && $_GET["rowTagID"] && $_GET["rowType"]) {
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($_GET["template"], $_GET["clientSpaceTagID"], true);
		
		switch ($_GET["cms_action"]) {
		case "row_moveup":
			$success = $clientSpace->moveRow($_GET["rowType"], $_GET["rowTagID"], -1);
			break;
		case "row_movedown":
			$success = $clientSpace->moveRow($_GET["rowType"], $_GET["rowTagID"], 1);
			break;
		case "row_delete":
			$success = $clientSpace->delRow($_GET["rowType"], $_GET["rowTagID"]);
			break;
		case "row_add":
			$direction = ($_GET["rowDirection"]=="top") ? false:true;
			$success = $clientSpace->addRow($_GET["rowType"], $_GET["rowTagID"],$direction);
			break;
		}
		if ($success) {
			$clientSpace->writeToPersistence();
		}
		$template = CMS_pageTemplatesCatalog::getByID($_GET["template"]);
	}
}

$dummy_page = CMS_tree::getRoot();
$dummy_page->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE, array($template->getLabel())), $cms_user);

//Display Page content
echo $template->getContent($cms_language, $dummy_page, PAGE_VISUALMODE_CLIENTSPACES_FORM);

/*only for stats*/
if (STATS_DEBUG) view_stat();
?>