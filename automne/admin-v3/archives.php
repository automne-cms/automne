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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: archives.php,v 1.2 2010/03/08 16:41:39 sebastien Exp $

/**
  * PHP page : page summary
  * Presents the summary of a page, with all possible actions.
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 860);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_TREE_TEXT", 1116);
define("MESSAGE_PAGE_ACTION_UNARCHIVE", 86);
define("MESSAGE_PAGE_ACTION_DELETE", 84);
define("MESSAGE_PAGE_ACTIONS", 162);
define("MESSAGE_PAGE_FIELD_REFERENCE", 863);
define("MESSAGE_PAGE_FIELD_TITLE", 864);
define("MESSAGE_PAGE_FIELD_LASTCREATION", 865);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 866);
define("MESSAGE_PAGE_NONE_ACTION", 265);
define("MESSAGE_PAGE_TREE_ACTION", 1049);

//checks
if (!$cms_user->hasValidationClearance(MOD_STANDARD_CODENAME)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$archives = CMS_tree::getArchivedPagesData();


switch ($_GET["cms_action"]) {
case "delete":
	if ($_GET["action_page"]) {
		$pg = CMS_tree::getPageByID($_GET["action_page"]);
		if (is_a($pg, "CMS_page")) {
			//sets the edition status and validate it
			$pg->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user);
			$pg->validateProposedLocation();
			$pg->writeToPersistence();
			
			//move the data
			CMS_module_standard::_changeDataLocation($pg, RESOURCE_DATA_LOCATION_ARCHIVED, RESOURCE_DATA_LOCATION_DELETED);
			
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			$archives = CMS_tree::getArchivedPagesData();

			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "From archives", $pg);
		}
	}
	break;
case "unarchive":
	if ($_GET["action_page"] && $_GET["father"]) {
		$pg = CMS_tree::getPageByID($_GET["action_page"]);
		$father = CMS_tree::getPageByID($_GET["father"]);
		if (is_a($pg, "CMS_page") && is_a($father, "CMS_page")) {
			//sets the edition status and validate it
			$pg->setProposedLocation(RESOURCE_LOCATION_USERSPACE, $cms_user);
			$pg->validateProposedLocation();

			//add an edition to the page
			if (APPLICATION_ENFORCES_WORKFLOW) {
				$pg->addEdition(RESOURCE_EDITION_CONTENT, $cms_user);
			}
			
			//don't add an edition (siblings order) to the father (which was the previous behavior)
			//$father->addEdition(RESOURCE_EDITION_SIBLINGSORDER, $cms_user);

			$pg->writeToPersistence();
			$father->writeToPersistence();
			
			//move the data
			if ($pg->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
				CMS_module_standard::_changeDataLocation($pg, RESOURCE_DATA_LOCATION_ARCHIVED, RESOURCE_DATA_LOCATION_PUBLIC, true);
			}
			CMS_module_standard::_changeDataLocation($pg, RESOURCE_DATA_LOCATION_ARCHIVED, RESOURCE_DATA_LOCATION_EDITED, false);
			
			//attach the page to the tree
			CMS_tree::attachPageToTree($pg, $father);
			if ($pg->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED) {
				CMS_tree::attachPageToTree($pg, $father, true);
			}
			
			if (!APPLICATION_ENFORCES_WORKFLOW) {
				//submit the page to the regenerator
				CMS_tree::submitToRegenerator($pg->getID(), true);
				
				//validate the father
				$pg->regenerate(true);
				$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_SIBLINGSORDER + RESOURCE_EDITION_CONTENT, $father);
				$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
				$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			}
			
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			$archives = CMS_tree::getArchivedPagesData();

			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE, $cms_user, MOD_STANDARD_CODENAME, $pg->getStatus(), "", $pg);
		}
	}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_archives.gif');
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
	$dialog->reloadTree();
}

if (is_array($archives) && $archives) {
	$content .= '
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REFERENCE).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LASTCREATION).'</th>
			<th class="admin" colspan="2">'.$cms_language->getMessage(MESSAGE_PAGE_ACTIONS).'</th>
		</tr>
	';
	
	$count = 0;
	
	foreach ($archives as $archive) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg" ;
		$last_creation = new CMS_date();
		$last_creation->setFromDBValue($archive["lastFileCreation"]);
		$href = PATH_ADMIN_SPECIAL_TREE_WR;
		$content .= '
			<tr>
				<td class="'.$td_class.'">'.$archive["id"].'</td>
				<td class="'.$td_class.'">'.htmlspecialchars($archive["title"]).'</td>
				<td class="'.$td_class.'">'.$last_creation->getLocalizedDate($cms_language->getDateFormat()).'</td>
				<form action="'.$_SERVER["SCRIPT_NAME"].'" method="get" onSubmit="return confirm(\'' . addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array(htmlspecialchars($archive["title"])))).'\')">
				<input type="hidden" name="cms_action" value="delete" />
				<input type="hidden" name="action_page" value="'.$archive["id"].'" />
				<td class="'.$td_class.'">
					<input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" />
				</td>
				</form>
				<form action="'.$href.'" method="get">
				<td class="'.$td_class.'">
					<input type="hidden" name="root" value="'.APPLICATION_ROOT_PAGE_ID.'" />
					<input type="hidden" name="backLink" value="'.$_SERVER["SCRIPT_NAME"].'" />
					<input type="hidden" name="title" value="'.$cms_language->getMessage(MESSAGE_PAGE_TREE_TEXT).'" />
					<input type="hidden" name="heading" value="'.$cms_language->getMessage(MESSAGE_PAGE_TREE_ACTION).'" />';
					//<input type="hidden" name="pageLink" value="'.$_SERVER["SCRIPT_NAME"].chr(167).chr(167).'father=%s'.chr(167).'cms_action=unarchive'.chr(167).'action_page='.$archive["id"].'" />
			$content .= '
					<input type="hidden" name="encodedPageLink" value="'.base64_encode($_SERVER["SCRIPT_NAME"].chr(167).chr(167).'father=%s'.chr(167).'cms_action=unarchive'.chr(167).'action_page='.$archive["id"]).'" />
					<input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNARCHIVE).'" />
				</td>
				</form>
			</tr>
		';
	}
	
	$content .= "</table>";
} else {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_NONE_ACTION).'<br />';
}

$dialog->setContent($content);
$dialog->show();

?>
