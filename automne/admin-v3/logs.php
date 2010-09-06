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
// $Id: logs.php,v 1.3 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : logs
  * Used to view the log, offers the choice of viewing it by resource or by user
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 894);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_BY_USER", 895);
define("MESSAGE_PAGE_BY_RESOURCE", 896);
define("MESSAGE_PAGE_TREE_TITLE", 897);
define("MESSAGE_PAGE_TREE_HEADING", 898);
define("MESSAGE_PAGE_SELECT", 28);
define("MESSAGE_PAGE_CHOOSE", 63);
define("MESSAGE_PAGE_EMPTY_LOG", 1069);
define("MESSAGE_PAGE_CLEAN_LOG", 1119);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 1120);
define("MESSAGE_PAGE_BY_RESOURCE_NUMBER", 1121);
define("MESSAGE_PAGE_RESULT_FOR_RESOURCE", 910);
define("MESSAGE_PAGE_FIELD_DATE", 905);
define("MESSAGE_PAGE_FIELD_ACTION", 906);
define("MESSAGE_PAGE_FIELD_COMMENTS", 907);
define("MESSAGE_PAGE_FIELD_USER", 908);
define("MESSAGE_PAGE_FIELD_STATUS", 909);
define("MESSAGE_PAGE_NONE_ACTION", 265);
define("MESSAGE_PAGE_RESULT_FOR_USER", 904);
define("MESSAGE_ACTION_PAGE", 1122);
define("MESSAGE_ACTION_ALL", 1123);
define("MESSAGE_PAGE_CHOOSE_USER", 1124);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//get all active users
$users = CMS_profile_usersCatalog::getAll(true);

$cms_action = ($_POST["cms_action"]) ? $_POST["cms_action"]:$_GET["cms_action"];

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($cms_action) {
	case "emptylog":
		$sql = "
			delete from
				log
			where
				left(datetime_log, 7) <= '" . sensitiveIO::sanitizeSQLString($_POST["startingmonth"]) . "'
		";
		$q = new CMS_query($sql);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		break;
	case "logbypage":
		$good_actions = CMS_log_catalog::getResourceActions();
		$module  = CMS_modulesCatalog::getByCodename($_GET["action_module"]);
		$resource = $module->getResourceByID($_GET["action_resource"]);
		if ($resource && $cms_user->hasPageClearance($resource->getID(), CLEARANCE_PAGE_VIEW)) {
			$logsByPage = CMS_log_catalog::getByResource($_GET["action_module"], $_GET["action_resource"]);
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_CLEARANCE_ERROR);
		}
		break;
	case "logbyusers":
		$misc_actions = CMS_log_catalog::getMiscActions();
		$all_actions = CMS_log_catalog::getAllActions();
		$action_user = CMS_profile_usersCatalog::getByID($_POST["action_user"]);
		$logsByUsers = CMS_log_catalog::getByUser($action_user->getUserID());
		break;
}


$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_journal.gif');
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

$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "'.$currentOnglet.'");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_BY_RESOURCE).'", "'.$cms_language->getMessage(MESSAGE_PAGE_BY_RESOURCE).'"));
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_BY_USER).'", "'.$cms_language->getMessage(MESSAGE_PAGE_BY_USER).'"));';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$content .='
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_PAGE_CLEAN_LOG).'", "'.$cms_language->getMessage(MESSAGE_PAGE_CLEAN_LOG).'"));';
}
$content .='
</script>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
<script>monOnglet.displayHeader();</script>';

// ****************************************************************
// ** Logs by Page                                               **
// ****************************************************************

$content .='
<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
		</tr>
		<tr>
			<td class="admin"><br />';
			
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
				
			$content .= '
			<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td class="admin" valign="top" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</td>
				<td class="admin">
					<form action="'.PATH_ADMIN_SPECIAL_TREE_WR.'" method="get">
						<input type="hidden" name="root" value="'.$root.'" />
						<input type="hidden" name="backLink" value="'.$_SERVER["SCRIPT_NAME"].'" />
						<input type="hidden" name="title" value="'.$cms_language->getMessage(MESSAGE_PAGE_TREE_TITLE).'" />
						<input type="hidden" name="heading" value="'.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_HEADING)).'" />';
						//<input type="hidden" name="pageLink" value="'.$_SERVER["SCRIPT_NAME"].chr(167).chr(167).'action_module=standard'.chr(167).'cms_action=logbypage'.chr(167).'action_resource=%s" />
			$content .= '
						<input type="hidden" name="encodedPageLink" value="'.base64_encode($_SERVER["SCRIPT_NAME"].chr(167).chr(167).'action_module=standard'.chr(167).'cms_action=logbypage'.chr(167).'action_resource=%s').'" />
						<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_SELECT).'" />
					</form>
				</td>
			</tr>
			<tr>
				<td class="admin" valign="top" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_BY_RESOURCE_NUMBER).'</td>
				<td class="admin">
					<form action="' . $_SERVER["SCRIPT_NAME"] . '" method="get">
					<input type="text" class="admin_input_text" name="action_resource" value="'.$_GET["action_resource"].'" />
					<input type="hidden" name="cms_action" value="logbypage" />
					<input type="hidden" name="action_module" value="standard" />
					<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
					</form>
				</td>
			</tr>
			</table>';
			
			// Results
			if ($cms_action=="logbypage" && !$cms_message) {
				$content .= '
				<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_RESULT_FOR_RESOURCE, array(htmlspecialchars($resource->getTitle()))).'</dialog-title>
				<br />';
				if (is_array($logsByPage) && $logsByPage) {
					$actions = $logsByPage;
					$content .= '
						<table border="0" cellpadding="2" cellspacing="2">
						<tr>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTION).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_USER).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_STATUS).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMMENTS).'</th>
						</tr>
					';
					$count=0;
					foreach ($actions as $action) {
						if (in_array($action->getLogAction(), $good_actions)) {
							$count++;
							$dt = $action->getDatetime();
							$usr = $action->getUser();
							if (is_a($usr, "CMS_profile_user")) {
								$userlink = '<a class="admin" href="mailto:'.$usr->getEmail().'">'.$usr->getFirstName()." ".$usr->getLastName().'</a>';
							} else {
								$userlink = "";
							}
							$status = $action->getResourceStatusAfter();
							$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
							$content .= '
								<tr>
									<td class="'.$td_class.'">'.$dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s').'</td>
									<td class="'.$td_class.'">'.htmlspecialchars($cms_language->getMessage(array_search($action->getLogAction(), $good_actions))).'</td>
									<td class="'.$td_class.'">'.$userlink.'</td>
									<td class="'.$td_class.'" align="center">'.$status->getHTML(false,false,false,false,false).'</td>
									<td class="'.$td_class.'">'.$action->getTextData().'</td>
								</tr>
							';
						}
					}
					$content .= '
						</table><br />
					';
				} else {
					$content .= $cms_language->getMessage(MESSAGE_PAGE_NONE_ACTION).'<br /><br />';
				}
			}
			$content .='
			</td>
		</tr>
	</table>
</div>';

// ****************************************************************
// ** Logs by Users                                              **
// ****************************************************************

$content .='
<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
		</tr>
		<tr>
			<td class="admin"><br />
				
				<form action="' . $_SERVER["SCRIPT_NAME"] . '" method="post">
					<input type="hidden" name="cms_action" value="logbyusers" />
					<input type="hidden" name="currentOnglet" value="1" />
					'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE_USER).'
					<select name="action_user" class="admin_input_text">
					';
					foreach ($users as $user) {
						$selectedUser = ($_POST["action_user"] == $user->getUserID()) ? ' selected="selected"' : '';
						$content .= '<option value="'.$user->getUserID().'"'.$selectedUser.'>'.$user->getFirstName()." ".$user->getLastName().'</option>';
					}
					$selectedShowPages = (!$_POST["show_resource_actions"]) ? ' checked="checked"' : '';
					$selectedShowAdmin = ($_POST["show_resource_actions"]) ? ' checked="checked"' : '';
					$content .= '
					</select><br /><br />
					<label for="showPages">
						<div nowrap="nowrap"><input id="showPages" type="radio" class="admin_input_radio" name="show_resource_actions" value="0"' . $selectedShowPages . ' /> ' . $cms_language->getMessage(MESSAGE_ACTION_PAGE) . '</div>
					</label><br />
					<label for="showAdmin">
						<div nowrap="nowrap"><input id="showAdmin" type="radio" class="admin_input_radio" name="show_resource_actions" value="1"' . $selectedShowAdmin . ' /> ' . $cms_language->getMessage(MESSAGE_ACTION_ALL) . '</div>
					</label><br />
					
					<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
				</form>';
				
				// Results
				if ($cms_action == "logbyusers" && !$cms_message) {
					$content .= '
					<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_RESULT_FOR_USER, array(htmlspecialchars($action_user->getFirstName()." ".$action_user->getLastName()))).'</dialog-title>
					<br />';
					if (sizeof($logsByUsers)) {
						
						$actions = $logsByUsers;
						$content .= '
						<table border="0" cellpadding="2" cellspacing="2">
						<tr>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTION).'</th>
							<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMMENTS).'</th>
						</tr>
						';
						$count=0;
						foreach ($actions as $action) {
							if ($_POST["show_resource_actions"] || in_array($action->getLogAction(), $misc_actions)) {
								$count++;
								
								$res = $action->getResource();
								if ($res) {
									$res_data = " (page " . $res->getID() . ")";
								} else {
									$res_data = "";
								}
								$dt = $action->getDatetime();
								$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
								$content .= '
									<tr>
										<td class="'.$td_class.'">'.$dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s').'</td>
										<td class="'.$td_class.'">'.htmlspecialchars($cms_language->getMessage(array_search($action->getLogAction(), $all_actions))). $res_data .'</td>
										<td class="'.$td_class.'">'.$action->getTextData().'</td>
									</tr>
								';
							}
						}
						$content .= '
							</table>
							<br />
						';
					} else {
						$content .= $cms_language->getMessage(MESSAGE_PAGE_NONE_ACTION).'<br /><br />';
					}
				}
				$content .='
			</td>
		</tr>
	</table>
</div>';

// ****************************************************************
// ** Delete Logs                                                **
// ****************************************************************
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$content .='
	<div id="og_monOnglet2" style="DISPLAY: none;top:0px;left:0px;width:100%;">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
			<tr>
				<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
			</tr>
			<tr>
				<td class="admin"><br />';
				
				//get Log months
				$sql = "
					select
						left (datetime_log, 7) as month
					from
						log
					group by
						month
					order by
						month desc
				";
				$q = new CMS_query($sql);
				$months = array();
				while ($month = $q->getValue("month")) {
					$months[] = $month;
				}
				
				if (sizeof($months)) {
					//show form
					$content .= '
						<form action="' . $_SERVER["SCRIPT_NAME"] . '" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM)) . '\')">
						<input type="hidden" name="cms_action" value="emptylog" />
						<input type="hidden" name="currentOnglet" value="2" />
						' . $cms_language->getMessage(MESSAGE_PAGE_EMPTY_LOG, array()) . ' 
						<select name="startingmonth" class="admin_input_text">
					';
					
					foreach ($months as $month) {
						$content .= '<option value="' . $month . '">' . $month . '</option>' . "\n";
					}
					
					$content .= '
						</select><br /><br />
						<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
						</form>
					';
				} else {
					$content .= $cms_language->getMessage(MESSAGE_PAGE_NONE_ACTION).'<br /><br />';
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