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
// $Id: templates.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : templates
  * Permit management of the templates
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 841);
define("MESSAGE_PAGE_HEADING_TEMPLATES", 842);
define("MESSAGE_PAGE_HEADING_ROWS", 843);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 825);
define("MESSAGE_PAGE_ACTION_BASEDATA", 1105);
define("MESSAGE_PAGE_ACTION_CLIENTSPACES", 829);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_VIEW_PAGES", 828);
define("MESSAGE_PAGE_TREE_TITLE", 826);
define("MESSAGE_PAGE_TREE_HEADING", 827);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 847);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR_ROW", 848);
define("MESSAGE_PAGE_BUTTON_ACTIVATE", 156);
define("MESSAGE_PAGE_BUTTON_DISACTIVATE", 155);
define("MESSAGE_PAGE_TEMPLATE_GROUPS", 837);
define("MESSAGE_PAGE_INACTIVE_TEMPLATE", 1005);
define("MESSAGE_PAGE_SHOW", 1006);
define("MESSAGE_PAGE_ALL_TEMPLATES", 1007);
define("MESSAGE_PAGE_SHOW_ONLY_GROUPS", 1008);
define("MESSAGE_PAGE_SHOW_INACTIVATES", 1009);
define("MESSAGE_PAGE_NO_TEMPLATE", 1010);
define("MESSAGE_PAGE_INACTIVE_HIDDEN", 1011);
define("MESSAGE_PAGE_PRINTING", 1052);
define("MESSAGE_PAGE_EDIT_TEMPLATE", 72);
define("MESSAGE_PAGE_HEADING_CSS", 950);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM_ROW", 844);
define("MESSAGE_PAGE_MAIN_CSS_LABEL", 951);
define("MESSAGE_PAGE_EDITPREVIZ", 1014);
define("MESSAGE_PAGE_SHOW_ONLY_GROUPS_MESSAGE", 1108);
define("MESSAGE_PAGE_FIELD_EDITION", 24);
define("MESSAGE_PAGE_EDIT_PRINT_TEMPLATE", 1133);
define("MESSAGE_PAGE_ACTION_VIEWPAGES", 1440);
define("MESSAGE_PAGE_ACTION_REGENERATEPAGES", 17);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($_GET["bookmark"]) {
	$_SESSION["cms_context"]->setBookmark($_GET["bookmark"]);
}
if ($_GET["rowsBookmark"]) {
	$cms_context->setSessionVar('rowsBookmark',$_GET["rowsBookmark"]);
}

$cms_action = ($_GET["cms_action"]) ? $_GET["cms_action"] : $_POST["cms_action"];

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($cms_action) {
case "delete_template":
	//delete the template
	$template = CMS_pageTemplatesCatalog::getByID($_POST["template"]);
	if (is_a($template, "CMS_pageTemplate") && !$template->hasPages()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_DELETE, $cms_user, "Template : ".$template->getLabel());
		if ($template->isPrivate()) {
			$template->destroy();
		} else {
			//destroy with definition file
			$template->destroy(true);
		}
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
case "prepare_clientspace_edition":
	//if template is correct, move data from clientspace table to edition one
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($_POST["template"], RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
	header("Location: ".PATH_ADMIN_SPECIAL_OUT_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_CLIENTSPACES_EDITION_WR.'?template='.$_POST["template"]."&".$_SERVER["QUERY_STRING"])."&".session_name()."=".session_id());
	exit;
	break;
case "cancel_clientspace_edition":
	//if template is correct, delete data from clientspace_edition table
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($_GET["template"], RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "validate_clientspace_edition":
	//if template is correct, delete data from clientspace_edition table and insert it into public one
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($_GET["template"], RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, false);
	$template = CMS_pageTemplatesCatalog::getByID($_GET["template"]);
	$regen_pages = $template->getPages();
	$regen_pages_ids = array();
	foreach ($regen_pages as $pg) {
		$regen_pages_ids[] = $pg->getID();
	}
	CMS_tree::submitToRegenerator($regen_pages_ids, true);
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (edit client spaces)");
	break;
case "change_usability":
	$template = CMS_pageTemplatesCatalog::getByID($_POST["template"]);
	$template->setUsability($_POST["new_usability"]);
	$template->writeToPersistence();
	break;
case "delete_row":
	//delete the website and move all of its pages
	$row = CMS_rowsCatalog::getByID($_POST["row"], '');
	if (is_a($row, "CMS_row") && !$row->hasClientSpaces()) {
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_DELETE_ROW, $cms_user, "Row : ".$row->getLabel());
		$row->destroy();
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
case "regenerate_templates":
	if (sensitiveIO::isPositiveInteger($_GET["action_page"])) {
		$pages = CMS_tree::getAllSiblings($_GET["action_page"], true);
		if (sizeof($pages) > 3) {
			//submit pages to regenerator
			CMS_tree::submitToRegenerator($pages, true);
		} else {
			//regenerate pages
			@set_time_limit(1000);
			foreach ($pages as $pageID) {
				$pg = CMS_tree::getPageByID($pageID);
				if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
				    $pg->regenerate(true);
				}
			}
		}
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	break;
	case 'regenerate_pagesByTemplate':
		if (SensitiveIO::isPositiveInteger($_REQUEST['templateID'])) {
			$pages = CMS_pageTemplatesCatalog::getPagesByTemplate($_REQUEST['templateID']);
			if (sizeof($pages) > 3) {
				//submit pages to regenerator
				CMS_tree::submitToRegenerator($pages, true);
			} elseif($pages){
				//regenerate pages
				@set_time_limit(1000);
				foreach ($pages as $pageID) {
					$pg = CMS_tree::getPageByID($pageID);
					if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					    $pg->regenerate(true);
					}
				}
			}
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
	case 'regenerate_pagesByRow':
		if (SensitiveIO::isPositiveInteger($_REQUEST['rowID'])) {
			$pages = CMS_rowsCatalog::getPagesByRow($_REQUEST['rowID']);
			if (sizeof($pages) > 3) {
				//submit pages to regenerator
				CMS_tree::submitToRegenerator($pages, true);
			} elseif($pages){
				//regenerate pages
				@set_time_limit(1000);
				foreach ($pages as $pageID) {
					$pg = CMS_tree::getPageByID($pageID);
					if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					    $pg->regenerate(true);
					}
				}
			}
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
}


// ****************************************************************
// ** TEMPLATES                                                  **
// ****************************************************************

if ($_GET["searchTemplates"]) {
	$showWhat = $_GET["showWhat"];
	$showGroups = $_GET["showGroups"];
	$showInactives = $_GET["showInactives"];
	$cms_context->setSessionVar('templatesShowWhat',$showWhat);
	$cms_context->setSessionVar('templatesShowGroups',$showGroups);
	$cms_context->setSessionVar('templatesShowInactives',$showInactives);
} else {
	$showWhat = $cms_context->getSessionVar('templatesShowWhat');
	$showGroups = $cms_context->getSessionVar('templatesShowGroups');
	$showInactives = $cms_context->getSessionVar('templatesShowInactives');
}


$inactivesHidden = -1;

if ($showWhat) {
	$templates = CMS_pageTemplatesCatalog::getAll(true);
	if ($showWhat == "parts") {
		$good_templates = array();
		$searchedGroups = $showGroups;
		if ($searchedGroups && is_array($searchedGroups) && sizeof($searchedGroups)) {
			foreach ($templates as $tpl) {
				$grps = $tpl->getGroups();
				$good = true;
				foreach ($searchedGroups as $grp) {
					if (!in_array($grp, $grps)) {
						$good = false;
						break;
					}
				}
				if ($good) {
					$good_templates[] = $tpl;
				}
			}
		}
		$templates = $good_templates;
	}
	
	//clear inactive templates if asked to
	if (!$showInactives) {
		$inactivesHidden = 0;
		foreach ($templates as $key => $tpl) {
			if (!$tpl->isUseable()) {
				unset($templates[$key]);
				$inactivesHidden++;
			}
		}
	}
}

$allGroups = CMS_pageTemplatesCatalog::getAllGroups();

$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();
$bookmark = $_SESSION["cms_context"]->getBookmark();
$pages = ceil(sizeof($templates) / $records_per_page);
$first_record = ($bookmark - 1) * $records_per_page;

$dialog = new CMS_dialog();	
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_modeles.gif');
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
$dialog->addOnglet();

if ($_GET["currentOnglet"]) {
	$currentOnglet = $_GET["currentOnglet"];
	$dialog->dontMakeFocus();
	$currentOnglet = ($currentOnglet == '2' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) ? '1':$currentOnglet;
} elseif ($_POST["currentOnglet"]) {
	$currentOnglet = $_POST["currentOnglet"];
	$dialog->dontMakeFocus();
	$currentOnglet = ($currentOnglet == '2' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) ? '1':$currentOnglet;
} else {
	$currentOnglet ='0';
}

//THE USER SECTIONS, Check if user has only sections administration
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$sections_roots = $cms_context->getSessionVar('sectionsRoots');
	$root = '9999999';
	$count='0';
	foreach ($sections_roots as $rootID) {
		$pg = CMS_tree::getPageByID($rootID);
		if ($pg && !$pg->hasError()) {
			$root = ($rootID<$root) ? $rootID: $root;
		}
	}
} else {
	$root = APPLICATION_ROOT_PAGE_ID;
}

$href = PATH_ADMIN_SPECIAL_TREE_WR;
$href .= '?root='.$root;
$href .= '&amp;backLink=templates.php';
$href .= '&amp;title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_TITLE));
$href .= '&amp;heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_HEADING));
$href .= '&amp;pageProperty=template';

$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "'.$currentOnglet.'");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_TEMPLATES).'", "'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_TEMPLATES).'"));';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) {
	$content .='
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_ROWS).'", "'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_ROWS).'"));';
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$content .='
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_CSS).'", "'.$cms_language->getMessage(MESSAGE_PAGE_HEADING_CSS).'"));';
}
$content .='
</script>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
<script>monOnglet.displayHeader();</script>
<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" border="0" height="1" width="1" /></td>
		</tr>
		<tr>
			<td class="admin"><br />';

// ****************************************************************
// ** TEMPLATES                                                  **
// ****************************************************************

//affichage des groupes
$selectedShowAll = ($showWhat == "all" || $showWhat=="") ? ' checked="checked"' : '';
$selectedShowParts = ($showWhat == "parts") ? ' checked="checked"' : '';
$content .= '
<form action="' . $_SERVER["SCRIPT_NAME"] . '" method="get">
<fieldset id="link" class="admin">
	<legend class="admin"><b>'.$cms_language->getMessage(MESSAGE_PAGE_SHOW).'</b></legend>
	<input type="hidden" name="bookmark" value="1" />
	<input type="hidden" name="searchTemplates" value="1" />
	<label for="showAll">
		<div nowrap="nowrap"><input id="showAll" type="radio" class="admin_input_radio" name="showWhat" value="all"' . $selectedShowAll . ' /> ' . $cms_language->getMessage(MESSAGE_PAGE_ALL_TEMPLATES) . '</div>
	</label>
	<br />
	<label for="showSelected">
		<input id="showSelected" type="radio" class="admin_input_radio" name="showWhat" value="parts"' . $selectedShowParts . ' /> ' . $cms_language->getMessage(MESSAGE_PAGE_SHOW_ONLY_GROUPS) . ' :
		<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		foreach ($allGroups as $aGroup) {
			$checked = (is_array($searchedGroups) && in_array($aGroup, $searchedGroups)) ?  ' checked="checked"' : '';
			$content .= '<label for="group_'.$aGroup.'"><input id="group_'.$aGroup.'" type="checkbox" name="showGroups[]"' . $checked . ' class="admin_checkbox" value="' . $aGroup . '" /> ' . $aGroup . '</label> ';
		}
		$checkedInactives = ($showInactives) ?   ' checked="checked"' : '';
		$content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;('.$cms_language->getMessage(MESSAGE_PAGE_SHOW_ONLY_GROUPS_MESSAGE).')
	</label>
	<br /><br />

<label for="showInactive"><input id="showInactive" type="checkbox"' . $checkedInactives . ' class="admin_checkbox" name="showInactives" /> ' . $cms_language->getMessage(MESSAGE_PAGE_SHOW_INACTIVATES) . '</label><br /><br />
</fieldset>
<input type="submit" class="admin_input_submit" value="' . $cms_language->getMessage(MESSAGE_PAGE_SHOW) . '" />&nbsp;
<input type="Button" onClick="location.replace(\''.$href.'&'.session_name().'='.session_id().'\');check();" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW_PAGES).'" />&nbsp;';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$content .= '
	<input type="Button" onClick="location.replace(\'template_basedata.php?'.session_name().'='.session_id().'\');check();" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />';
}
if (USE_PRINT_PAGES) {
	$content .= '
	<input type="Button" onClick="location.replace(\'edit_template.php?template=print&'.session_name().'='.session_id().'\');check();" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_EDIT_PRINT_TEMPLATE).'" />';
}
$content .= '
</form>
';

if (!$templates && $showWhat) {
	$content .= '<b>' . $cms_language->getMessage(MESSAGE_PAGE_NO_TEMPLATE) . '</b><br /><br />';
} elseif ($templates) {
	$content .= '
	<table border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_TEMPLATE_GROUPS).'</th>
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITION).'</th>';
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
		$content .= '
		<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>';
	}
	$content .= '
	</tr>';
	$count = 0;
	foreach ($templates as $template) {
		$count++;
		if ($count - 1 < $first_record) {
			continue;
		}
		if ($count - 1 >= $first_record + $records_per_page) {
			break;
		}
		
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)){
			$title = 'title="'.$template->getDefinitionFile().'"';
		}
		$label = '<span '.$title.'>'.htmlspecialchars($template->getLabel()).'</span>';
		$label = ($template->isUseable()) ? '<b>' . $label . '</b>' : '* ' . $label;
		$content .= '
		<tr>
			<td class="'.$td_class.'">'.$label.'</td>
			<td class="'.$td_class.'">'.implode(", ", $template->getGroups()).'</td>';
		$content .= '
			<td class="'.$td_class.'">
				<table border="0" cellpadding="2" cellspacing="0">
				<tr>';
		if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
			$content .= '
			<form action="template_basedata.php" method="post">
			<input type="hidden" name="template" value="'.$template->getID().'" />
				<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_BASEDATA).'" /></td>
			</form>
			<form action="edit_template.php" method="post">
			<input type="hidden" name="template" value="'.$template->getID().'" />
				<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_EDIT_TEMPLATE).'" /></td>
			</form>
			';
		}
		$content .= '
			<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
			<input type="hidden" name="template" value="'.$template->getID().'" />
			<input type="hidden" name="cms_action" value="prepare_clientspace_edition" />
				<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_CLIENTSPACES).'" /></td>
			</form>';
		if (USE_PRINT_PAGES) {
			$content .= '
			<form action="template_printing.php" method="post">
			<input type="hidden" name="template" value="'.$template->getID().'" />
				<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_PRINTING).'" /></td>
			</form>
			';
		}
		
		$content .= '
			</tr>
			</table>
		</td>';
		if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
			$content .= '
				<td class="'.$td_class.'">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>';
			
			if ($template->isUseable()) {
				$new_usability = 0;
				$button_label = $cms_language->getMessage(MESSAGE_PAGE_BUTTON_DISACTIVATE);
			} else {
				$new_usability = 1;
				$button_label = $cms_language->getMessage(MESSAGE_PAGE_BUTTON_ACTIVATE);
			}
			
			$content .= '
					<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
					<input type="hidden" name="template" value="'.$template->getID().'" />
					<input type="hidden" name="new_usability" value="'.$new_usability.'" />
					<input type="hidden" name="cms_action" value="change_usability" />
						<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$button_label.'" /></td>
					</form>
			';
			if (!$template->hasPages()) {
				$content .= '
					<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array($template->getLabel()))) . ' ?\')">
					<input type="hidden" name="cms_action" value="delete_template" />
					<input type="hidden" name="template" value="'.$template->getID().'" />
						<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
					</form>
				';
			} else {
				$content .= '
				<form action="search.php" method="post">
					<input type="hidden" name="search" value="template:'.$template->getID().'" />
					<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEWPAGES).'" /></td>
				</form>';
				if($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)){
					$content .= '
					<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
						<input type="hidden" name="cms_action" value="regenerate_pagesByTemplate" />
						<input type="hidden" name="currentOnglet" value="0" />
						<input type="hidden" name="templateID" value="'.$template->getID().'" />
						<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATEPAGES).'" /></td>
					</form>';
				}
			}
			$content .= '
					</tr>
					</table>
				</td>';
		}
		$content .= '
			</tr>
		';
	}
	$content .= '
		</table>
		<dialog-pages maxPages="'.$pages.'"></dialog-pages><br />
		* : ' . $cms_language->getMessage(MESSAGE_PAGE_INACTIVE_TEMPLATE) . '<br />
	';
	
	//show info about hidden templates
	if ($inactivesHidden != -1) {
		$content .= '<br />' . $cms_language->getMessage(MESSAGE_PAGE_INACTIVE_HIDDEN, array($inactivesHidden)) . "<br />";
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
		$content .= '
		<br />
		<form action="template_basedata.php" method="post" onSubmit="check();">
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form>';
	}
}

$content .= '
		</td>
	</tr>
</table>
</div>';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) {
	$content .='
	<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" border="0" height="1" width="1" /></td>
		</tr>
		<tr>
			<td class="admin_onglet_body">';
	
	
	// ****************************************************************
	// ** ROWS                                                       **
	// ****************************************************************
	$rows = CMS_rowsCatalog::getAll($cms_user);
	if (sizeof($rows)) {
		if ($_GET["rowsBookmark"]) {
			$cms_context->setSessionVar('rowsBookmark',$_GET["rowsBookmark"]);
		}
		
		$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();
		$bookmark = ($cms_context->getSessionVar('rowsBookmark')) ? $cms_context->getSessionVar('rowsBookmark'):'1';
		$pages = ceil(sizeof($rows) / $records_per_page);
		$first_record = ($bookmark - 1) * $records_per_page;
		
		$content .= '
			<br />
			<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			</tr>
		';
		
		$count = 0;
		foreach ($rows as $row) {
			$count++;
			if ($count - 1 < $first_record) {
				continue;
			}
			if ($count - 1 >= $first_record + $records_per_page) {
				break;
			}
			
			$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
			
			$content .= '
				<tr>
					<td class="'.$td_class.'">'.htmlspecialchars($row->getLabel()).'</td>
					<td class="'.$td_class.'">
						<table border="0" cellpadding="2" cellspacing="0">
						<tr>
						<form action="template_row.php" method="post">
						<input type="hidden" name="row" value="'.$row->getID().'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_EDITPREVIZ).'" /></td>
						</form>
						';
			if (!$row->hasClientSpaces()) {
				$content .= '
						<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM_ROW, array(htmlspecialchars($row->getLabel())))) . '\')">
						<input type="hidden" name="cms_action" value="delete_row" />
						<input type="hidden" name="currentOnglet" value="1" />
						<input type="hidden" name="row" value="'.$row->getID().'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
						</form>
				';
			} else {
					$content .= '
					<form action="search.php" method="post">
						<input type="hidden" name="search" value="row:'.$row->getID().'" />
						<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEWPAGES).'" /></td>
					</form>';
					if($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)){
						$content .= '
						<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
							<input type="hidden" name="cms_action" value="regenerate_pagesByRow" />
							<input type="hidden" name="currentOnglet" value="1" />
							<input type="hidden" name="rowID" value="'.$row->getID().'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATEPAGES).'" /></td>
						</form>';
					}
			}
			$content .= '
						</tr>
						</table>
					</td>
				</tr>
			';
		}
		$content .= '</table>
			<dialog-pages maxPages="'.$pages.'" boomarkName="rowsBookmark">
				<dialog-pages-param name="currentOnglet" value="1" />
			</dialog-pages>';
	}
	$content .= '
		<br />
		<form action="template_row.php" method="post">
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form>
			</td>
		</tr>
	</table> 
	</div>';
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$rowsTabNumber = ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) ? '2':'1';
	$content .= '
	<div id="og_monOnglet'.$rowsTabNumber.'" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" border="0" height="1" width="1" /></td>
		</tr>
		<tr>
			<td class="admin_onglet_body"><br />';
	// ****************************************************************
	// ** Style sheet for rows                                       **
	// ****************************************************************
	
	//list of css files in directory
	$cssFiles = array();
	if ($handle = opendir(PATH_CSS_FS)) {
	   while (false !== ($file = readdir($handle))) {
	       if (strpos($file,'.css') || strpos($file,'.xml')) {
		   		$cssFiles[] = $file;
		   }
	   }
	}
	if (sizeof($cssFiles)) {
		$count=0;
		$content .= '
			<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			</tr>';
			foreach ($cssFiles as $aCssFile) {
				$count++;
				$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
				$content .= '
				<tr>
					<td class="'.$td_class.'">'.htmlspecialchars($cms_language->getMessage(MESSAGE_PAGE_MAIN_CSS_LABEL, array($aCssFile))).'</td>
					<td class="'.$td_class.'">
						<table border="0" cellpadding="2" cellspacing="0">
						<tr>
							<form action="template_css.php" method="post">
							<input type="hidden" name="cms_action" value="show" />
							<input type="hidden" name="cssFile" value="'.$aCssFile.'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_BUTTON_EDIT).'" /></td>
							</form>
						</tr>
						</table>
					</td>
				</tr>';
			}
		$content .= '
		</table>';
	}
	$content .= '
			</td>
		</tr>
	</table>
	</div>';
}
$content .= '
<script>monOnglet.displayFooter();</script>
		</td>
	</tr>
</table>';

$dialog->setContent($content);
$dialog->show();
?>