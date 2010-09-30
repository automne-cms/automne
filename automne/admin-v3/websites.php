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
// $Id: websites.php,v 1.3 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : websites
  * Permit management of the websites
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 821);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 813);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_ROOT", 815);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_TREE_TITLE", 822);
define("MESSAGE_PAGE_TREE_HEADING", 823);
define("MESSAGE_PAGE_FIELD_URL", 819);
define("MESSAGE_PAGE_SAVE_NEWORDER", 1183);
define("MESSAGE_PAGE_SAME_DOMAIN_EXPLANATION", 1352);
define("MESSAGE_PAGE_ACTION_ORDERING_ERROR", 1353);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

switch ($_POST["cms_action"]) {
case "delete":
	//delete the website and move all of its pages
	$website = CMS_websitesCatalog::getByID($_POST["website"]);
	if (is_a($website, "CMS_website") && !$website->isMain()) {
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_WEBSITE_DELETE, $cms_user, "Website : ".$website->getLabel());
		//check for codenames duplications
		//get website codenames
		$websiteCodenames = $website->getAllCodenames();
		//get codenames of parent website
		$websiteRoot = $website->getRoot();
		$father = CMS_tree::getFather($websiteRoot, true);
		$fatherWebsite = $father->getWebsite();
		$fatherCodenames = $fatherWebsite->getAllCodenames();
		$codenamesToRemove = array();
		//get duplicated codenames
		foreach ($websiteCodenames as $codename => $pageId) {
			if (isset($fatherCodenames[$codename])) {
				$codenamesToRemove[$codename] = $pageId;
			}
		}
		//remove duplicated codenames
		if ($codenamesToRemove) {
			foreach ($codenamesToRemove as $codename => $pageId) {
				$page = CMS_tree::getPageById($pageId);
				$page->setCodename('', $cms_user);
				$page->writeToPersistence();
				//validate the modification
				$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_BASEDATA, $page);
				$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
				$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			}
		}
		//then destroy website
		$website->destroy();
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
case "change_order":
	if ($_POST['new_order']) {
		$orders = explode(',',$_POST['new_order']);
		if (CMS_websitesCatalog::setOrders($orders)) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_ORDERING_ERROR);
		}
	}
	break;
}

if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($_GET["bookmark"]) {
	$_SESSION["cms_context"]->setBookmark($_GET["bookmark"]);
}

$websites = CMS_websitesCatalog::getAll('order');

$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();
$bookmark = $_SESSION["cms_context"]->getBookmark();
$pages = ceil(sizeof($websites) / $records_per_page);
$first_record = ($bookmark - 1) * $records_per_page;

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content .= '
<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/dragsort.js"></script>
<script language="JavaScript" type="text/javascript">
	<!--
	function sortList() {
		DragSort.makeListSortable(document.getElementById("websites"));
	};
	function startDragging() {
		if (document.getElementById("validateDrag").className=="hideit") {
			document.getElementById("validateDrag").className="showit";
		}
		return true;
	}
	function getNewOrder() {
		var websites = document.getElementById("websites");
		websitesArray = websites.getElementsByTagName("li");
		var newOrder;
		for (var i=0; i<websitesArray.length; i++) {
			newOrder = (newOrder) ? newOrder + "," + websitesArray[i].id.substr(1) : websitesArray[i].id.substr(1);
		}
		document.change_order.new_order.value=newOrder;
		return true;
	}
	//-->
</script>

'.$cms_language->getMessage(MESSAGE_PAGE_SAME_DOMAIN_EXPLANATION).'
<br /><br />
<table border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th class="admin" width="120">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		<th class="admin" width="230">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROOT).'</th>
		<th class="admin" width="150">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_URL).'</th>
		<th class="admin" width="192">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
	</tr>
</table>
<ul id="websites" class="sortable">';
$count = 0;
foreach ($websites as $website) {
	$count++;
	$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
	$website_root = $website->getRoot();
	
	$content .= '
	<li id="w'.$website->getID().'">
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="'.$td_class.'" width="120">'.htmlspecialchars($website->getLabel()).'</td>
			<td class="'.$td_class.'" width="230"><a href="#" onclick="Automne.utils.getPageById('.$website_root->getID().');Ext.WindowMgr.getActive().close();" class="admin">'.htmlspecialchars($website_root->getTitle()).' ('.$website_root->getID().')</a></td>
			<td class="'.$td_class.'" width="150"><a href="'.$website->getURL().'" target="_blank" class="admin">'.htmlspecialchars($website->getURL()).'</a></td>
			<td class="'.$td_class.'" width="150">
				<table border="0" cellpadding="2" cellspacing="0" width="146">
				<tr>
				<form action="website.php" method="get">
				<input type="hidden" name="website" value="'.$website->getID().'" />
					<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
				</form>
				';
	if (!$website->isMain()) {
		$content .= '
				<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array($website->getLabel()))) . '\')">
				<input type="hidden" name="cms_action" value="delete" />
				<input type="hidden" name="website" value="'.$website->getID().'" />
					<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
				</form>
		';
	}
	$content .= '
				</tr>
				</table>
			</td>
			<td width="36" align="center" class="'.$td_class.'" style="cursor:move;"><img src="'.PATH_ADMIN_IMAGES_WR.'/drag.gif" border="0" /></td>
		</tr>
		</table>
	</li>
	';
}
$content .= '
</ul>
<div id="validateDrag" class="hideit">
	<form name="change_order" onsubmit="return getNewOrder();" action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
		<input type="hidden" name="cms_action" value="change_order" />
		<input type="hidden" name="new_order" value="" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_SAVE_NEWORDER).'" />
	</form>
</div>';

//new website : send to tree to select the root page (hope the user has the PAGE clearance for the root)
$grand_root = CMS_tree::getRoot();
$href = PATH_ADMIN_SPECIAL_TREE_WR;
$href .= '?root='.$grand_root->getID();
//$href .= '&amp;pageLink=website.php'.chr(167).chr(167).'website_root=%s'.chr(167).'cms_action=set_root';
$href .= '&amp;encodedPageLink='.base64_encode('website.php'.chr(167).chr(167).'website_root=%s'.chr(167).'cms_action=set_root');
$href .= '&amp;backLink=websites.php';
$href .= '&amp;title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_TITLE));
$href .= '&amp;heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_HEADING));

$content .= '
	<br />
	<form method="post" action="'.$href.'">
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form>
	<br />
';

$dialog->setContent($content);
$dialog->show();
?>