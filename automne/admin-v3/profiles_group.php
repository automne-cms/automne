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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cedric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: profiles_group.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : entry
  * Entry page. Presents all the user "sections" (page clearances sections) and all the user available validations.
  *
  * @package CMS
  * @subpackage admin
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//augment the execution time, because things here can be quite lengthy
@set_time_limit(9000);
//ignore user abort to avoid interuption of process
@ignore_user_abort(true);

define("MESSAGE_NAME", 814); 
define("MESSAGE_PAGE_TITLE", 74);
define("MESSAGE_BASE_DATA", 1106);
define("MESSAGE_LABEL_EXISTS", 175); 
define("MESSAGE_GROUP_RIGHTS", 113);
define("MESSAGE_TOTAL_GROUP_RIGHTS", 114);
define("MESSAGE_META_RIGHTS", 115);
define("MESSAGE_ALERT_LEVEL_DESCRIPTION", 204);
define("MESSAGE_ALERT_LEVEL_HEADING", 197);
define("MESSAGE_LEVEL", 230);
define("MESSAGE_CHANGE", 231);
define("MESSAGE_TEMPLATESROWS_HEADING", 1107);
define("MESSAGE_TEMPLATES_HEADING", 1333);
define("MESSAGE_ROWS_HEADING", 1334);
define("MESSAGE_TEMPLATE_DESCRIPTION", 232);
define("MESSAGE_TEMPLATE_INSTRUCTION", 233);
define("MESSAGE_RIGHTS", 242);
define("MESSAGE_NEW_SECTION", 244);
define("MESSAGE_DELETE", 1131);
define("MESSAGE_NEW_SECTION_SUBTITLE", 63);
define("TEMPLATE_COLS", 10);
define("MESSAGE_BUTTON_CANCEL", 180);
define("MESSAGE_MODULE_RIGHTS", 247);
define("MESSAGE_VALIDATION_RIGHTS", 279);
define("MESSAGE_ADD", 260);
define("MESSAGE_BUTTON_APPLY_TO_ALL_USERS", 283);
define("MESSAGE_GROUP_RIGHTS_NONE", 10);
define("MESSAGE_GROUP_RIGHTS_VIEW", 11);
define("MESSAGE_GROUP_RIGHTS_EDIT", 12);
define("MESSAGE_GROUP_RIGHTS_MODULES_NONE", 1101);
define("MESSAGE_GROUP_RIGHTS_MODULES_VIEW", 1102);
define("MESSAGE_GROUP_RIGHTS_MODULES_EDIT", 1103);
define("MESSAGE_MODULE_DELETE", 1114);
define("MESSAGE_MOD_STANDARD_LABEL", 213);
define("MESSAGE_DISTINGUISHED_NAME", 1215);
define("MESSAGE_DISTINGUISHED_NAME_EXISTS", 1216);
define("MESSAGE_PAGE_TITLE_MODULES_ACCESS", 1210);
define("MESSAGE_GROUP_DESCRIPTION", 139);
define("MESSAGE_INVERT_DISTINGUISHED_NAME", 1338);
define("MESSAGE_ONGLET_USERS", 926);
define("MESSAGE_GROUP_LIST_USERS", 1439);
define("MESSAGE_PAGE_NO_USERS", 1441);
define("MESSAGE_GROUP_USER_ACTIVE", 1443);
define("MESSAGE_GROUP_USER_INACTIVE", 1444);

//Redirection if not user administrator
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	header("Location: ".PATH_ADMIN_WR."/profiles_user.php?".session_name()."=".session_id()) ;
	exit;
}

//Retrieve navigation values from previous page
$groupId = $_POST["groupId"].$_GET["groupId"];

if ($groupId) {
	$groupEdited = CMS_profile_usersGroupsCatalog::getByID($groupId);
} else {
	$groupEdited = new CMS_profile_usersGroup();
} 

//Create backLink
$backLink = PATH_ADMIN_WR.'/profiles_users.php?currentOnglet=1';

// Possible get action
switch (trim($_GET["cms_action"])) {
	case "add":
		$superAction = "add";
	break;
	// Change template group data	
	/*case "addPageClearance":
			$groupEdited->addPageClearance($_GET["sectionroot"], CLEARANCE_PAGE_NONE, true);
			$groupEdited->writeToPersistence();
			$groupEdited->applyToUsers();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(page clearance)");
		break;*/
}

// Possible post actions
switch (trim($_POST["cms_action"])) {
//Create blank form
case "add":
		$superAction = "add";
	break;
//Update all core data
case "changeCoreData":
   $error = false;
   //Check Label
   if ($_POST["name"]) {
		if ($_POST["cms_super_action"] == "add") {
			$labelExists = CMS_profile_usersGroupsCatalog::labelExists($_POST["name"]);
		} else {
			$labelExists = CMS_profile_usersGroupsCatalog::labelExists(
									$_POST["name"], $groupEdited->getGroupId());
		}
		if ($labelExists) {
			$cms_message = $cms_language->getMessage(MESSAGE_LABEL_EXISTS, array($_POST["name"]));  
			$error = true;
		} else {
			$groupEdited->setLabel($_POST["name"]);
			$groupEdited->writeToPersistence();
			$groupEdited->applyToUsers();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel());
		}
   } else {
	   $error = true;
	   $cms_message = $cms_language->getMessage(
			MESSAGE_INCORRECT_FIELD_VALUE, 
			array($cms_language->getMessage(MESSAGE_NAME)));
   }
	
	// LDAP dn
	$groupEdited->setInvertDN($_POST["invertdn"]);
	if ($_POST["dn"]) {
		if (CMS_profile_usersGroupsCatalog::dnExists($_POST["dn"], $groupEdited)) {
			if ($cms_message) {
				$cms_message .= "\n";
			}
			$cms_message .= $cms_language->getMessage(
					MESSAGE_DISTINGUISHED_NAME_EXISTS, array($_POST["dn"]));
			$errors++;
		} else {
			$groupEdited->setDN(CMS_ldap_query::appendWithBaseDn($_POST["dn"]));
		}
	}
	//Group description
	if ($_POST['description']) {
		$groupEdited->setDescription($_POST['description']);
	}
   	
	// Check if any errors when creating group
	if ($error && $_POST["cms_super_action"]) {
		$superAction = "add";
	} else {
		$superAction = "";
		$groupEdited->writeToPersistence();
		$groupEdited->applyToUsers();
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(Creation)");
	}
	break;
	
case "applyToAllUsers":
	$groupEdited->applyToUsers();
	break;
	
// Change template data	
/*case "setPageClearance":
	foreach ($_POST["pagesClearance"] as $aPageClearance) {
		if ($_POST["removePage_".$aPageClearance]=='1') {
			$groupEdited->delPageClearance($aPageClearance);
		} else {
			if ($_POST["setPageClearance_".$aPageClearance] != $_POST["initClearance_".$aPageClearance]) {
				$groupEdited->addPageClearance($aPageClearance, $_POST["setPageClearance_".$aPageClearance], true);
			}
		}
	}
	$groupEdited->writeToPersistence();
	$groupEdited->applyToUsers();
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(page clearance)");
	break;*/
// Change admin clearance	
case "changeAdminClearance":
	$adminClearances = CMS_profile::getAllAdminClearances();
	$newAdminClearance = $groupEdited->getAdminClearance();
	foreach ($adminClearances as $adminClearance) {
		if	($cms_user->hasAdminClearance($adminClearance) && 
			 $_POST[$adminClearance] && 
			 !($groupEdited->hasAdminClearance($adminClearance))) {
			$newAdminClearance += $adminClearance;
		} elseif (!$_POST[$adminClearance] && 
			   $groupEdited->hasAdminClearance($adminClearance)) {
			$newAdminClearance -= $adminClearance;
		}
	}
	
	$groupEdited->setAdminClearance($newAdminClearance);
	$groupEdited->writeToPersistence();
	$groupEdited->applyToUsers();
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(change admin clearance)");
	break;	
	
// Change template group data
case "changeTemplateRowGroup":
	// templates
	$templateGroups = CMS_pageTemplatesCatalog::getAllGroups();
	$newTemplateGroups = new CMS_Stack();
	$newTemplateGroups->setValuesByAtom(1);
	foreach ($templateGroups as $templateGroup) {
		if	(!$_POST["groupTemplate_".$templateGroup]) {
			$newTemplateGroups->add($templateGroup);
		} 
	}
	$groupEdited->setTemplateGroupsDenied($newTemplateGroups);
	// Rows
	$rowsgroups = CMS_rowsCatalog::getAllGroups();
	$newRowGroups = new CMS_Stack();
	$newRowGroups->setValuesByAtom(1);
	foreach ($rowsgroups as $rowgroup) {
		if	(!$_POST["groupRow_".$rowgroup]) {
			$newRowGroups->add($rowgroup);
		}
	}
	$groupEdited->setRowGroupsDenied($newRowGroups);
	// Save data
	$groupEdited->writeToPersistence();
	$groupEdited->applyToUsers();
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(change groups)");
	break;
	
case "changeAlertLevel":
	$groupEdited->setAlertLevel($_POST["alert"]); 
	$groupEdited->writeToPersistence();
	$groupEdited->applyToUsers();
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(change alert level)");
	break;	
case "setModuleClearance":
	foreach ($_POST["modulesClearance"] as $aModuleClearance) {
		if ($_POST["removeModule_".$aModuleClearance]=='1') {
			$groupEdited->delModuleClearance($aModuleClearance);
			$groupEdited->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(remove module clearance)");
		} else {
			if ($_POST["setModuleClearance_".$aModuleClearance] != $_POST["initClearance_".$aModuleClearance]) {
				$groupEdited->addModuleClearance($aModuleClearance, $_POST["setModuleClearance_".$aModuleClearance], true);
				$groupEdited->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(change module clearance)");
			}
		}
	}
	$groupEdited->applyToUsers();
	break;

case "addModuleClearance":
	if ($_POST["othermodules"]) {
		$groupEdited->addModuleClearance($_POST["othermodules"], CLEARANCE_MODULE_NONE, true);
		$groupEdited->writeToPersistence();
		$groupEdited->applyToUsers();
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(add module clearance)");
	}
	break;
	
case "changeValidation":
	
	// Loop through each of the users old modules as these
	// are the only ones that can be validated
	$validationClearancesStack = $groupEdited->getModuleClearances();
	$validationClearances = $validationClearancesStack->getElements();
	
	foreach ($validationClearances as $validationClearance) {
		$validationName = $validationClearance[0];
		if ($cms_user->hasValidationClearance($validationName) &&
			$_POST[$validationName] && 
			!($groupEdited->hasValidationClearance($validationName))) {
			$groupEdited->addValidationClearance($validationName);
		} elseif (!$_POST[$validationName] && 
			$cms_user->hasValidationClearance($validationName)) {
			$groupEdited->delValidationClearance($validationName);
		}
	}
	$groupEdited->writeToPersistence();
	$groupEdited->applyToUsers();
	$log = new CMS_log();
	$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$groupEdited->getLabel(). "(edit validation clearances)");
	break;
}

//Display
$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE).' : '.$groupEdited->getLabel());
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
$dialog->addOnglet();

if ($_GET["currentOnglet"]) {
	$currentOnglet = $_GET["currentOnglet"];
	$dialog->dontMakeFocus();
} elseif ($_POST["currentOnglet"]) {
	$currentOnglet = $_POST["currentOnglet"];
	$dialog->dontMakeFocus();
} else {
	$currentOnglet ='0';
}

$dialog->setBackLink($backLink);


//Base Data
$content = '';
$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "'.$currentOnglet.'");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_BASE_DATA).'", "'.$cms_language->getMessage(MESSAGE_BASE_DATA).'"));';
if (!$superAction) {
	$content .='
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_RIGHTS).'", "'.$cms_language->getMessage(MESSAGE_RIGHTS).'"));
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_META_RIGHTS).'", "'.$cms_language->getMessage(MESSAGE_META_RIGHTS).'"));
	monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_ONGLET_USERS).'", "'.$cms_language->getMessage(MESSAGE_ONGLET_USERS).'"));';
}
$content .='
</script>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>

<script>monOnglet.displayHeader();</script>
<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
			<form name="coredata" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<tr>
				<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_NAME).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="name" value="'.SensitiveIO::sanitizeHTMLString($groupEdited->getLabel()).'" /></td>
			</tr>
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_DISTINGUISHED_NAME).'</td>
				<td class="admin_onglet_body"><input type="text" class="admin_input_long_text" size="20" name="dn" value="'.SensitiveIO::sanitizeHTMLString($groupEdited->getDN()).'" /><br /><label for="invertdn"><input type="checkbox" name="invertdn" id="invertdn" value="1" '.($groupEdited->getInvertDN() ? ' checked="checked"':'').' />&nbsp;'.$cms_language->getMessage(MESSAGE_INVERT_DISTINGUISHED_NAME).'</label></td>
			</tr>
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_GROUP_DESCRIPTION).'</td>
				<td class="admin_onglet_body"><textarea cols="45" rows="2" class="admin_long_textarea" name="description">'.htmlspecialchars($groupEdited->getDescription()).'</textarea></td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				<td class="admin_onglet_body" align="right"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
			</tr>
			'.$postHiddenValues.'
	  		<input type="hidden" name="cms_super_action" value="'.$superAction.'" />
	    	<input type="hidden" name="cms_action" value="changeCoreData" />
			<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
   			</form>
';
if (!$superAction) {
	$content .= '
	<!--
    <form name="applytoallusers" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">	
	<tr>
		<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
		<td class="admin_onglet_body" align="right">
			'.$postHiddenValues.'
		      <input type="hidden" name="cms_action" value="applyToAllUsers" />
		      <input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
			<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_APPLY_TO_ALL_USERS).'" class="admin_input_submit" />
		</td>
	</tr>
	</form>-->';
}
if ($superAction) {
	$content .= '
    <form name="coredata" method="post" action="'.PATH_ADMIN_WR.'/profiles_users.php?currentOnglet=1">	
	<tr>
		<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
		<td class="admin_onglet_body" align="right">
			'.$postHiddenValues.'
			<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_CANCEL).'" class="admin_input_submit" />
		</td>
	</tr>
	</form>';
}
$content .= '
	</table>
</div>';
if (!$superAction) {
	//Pages clearance
	$pageClearanceChangeable=false;
	$rowContent = '';
		$content .= '
		<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">';
			/*
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS).' :</b></td>
				</tr>
				<form  method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			';
			
			$pageClearancesStack = $groupEdited->getPageClearances();
			$pageClearances = $pageClearancesStack->getElements();
			
			//Loop through stack and display clearances
			foreach ($pageClearances as $pageClearance) {
				// Build menu
				$page = $pageClearance[0];
				$clearance = $pageClearance[1];
				$allclearances = CMS_profile::getAllPageClearances();
				
				//Check current user has a clearance to modify
				if ($cms_user->hasPageClearance($page, $clearance)) { 
					
					$options = 0;
					
					$clearanceSelect = '<input type="hidden" value="'.$clearance.'" name="initClearance_'.$page.'" />';
					foreach ($allclearances as $message=>$allclearance) {
						if ($cms_user->hasPageClearance($page, $allclearance)) {
							$pageClearanceChangeable=true;
							$clearanceSelect .= '<td class="admin_onglet_body" align="center"><input type="radio" value="'.$allclearance.'" ';
							if ($allclearance == $clearance) {
								$clearanceSelect .= ' checked="checked" ';	
							}
							$clearanceSelect .= ' name="setPageClearance_'.$page.'" /></td>';
							$options++;
						} else {
							$clearanceSelect .= '<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
						}
					}
					
					//no need to display select if only one
					if ($options == 1) {
						$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
					}
				} else {
					// Cannot change hence display value
					foreach ($allclearances as $message=>$allclearance) {
						if ($allclearance == $clearance) {
							$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
						}
					}
				}
				// row format
				$cms_page = CMS_tree::getPageByID($page);
				if (is_object($cms_page)) {
					$rowContent .='
						<tr>
							<td class="admin_onglet_head"><a href="'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?page='.$cms_page->getID().'" class="admin">'.SensitiveIO::sanitizeHTMLString($cms_page->getTitle()).' ('.$cms_page->getID().')</a></td>
							<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
							'.$clearanceSelect.'
							<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
							';
					if ($cms_user->hasPageClearance($page, CLEARANCE_PAGE_EDIT)) {
						$rowContent .='<td class="admin_onglet_body" align="center"><input type="checkbox" name="removePage_'.$page.'" value="1" /></td>';
						$pageClearanceChangeable=true;
					} else {
						$rowContent .='<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
					}
					$rowContent .='
						</tr>
						<input type="hidden" value="'.$page.'" name="pagesClearance[]" />
					';
				}
			}
		
		$root = CMS_tree::getRoot();
		$rootId = $root->getID();
		if ($pageClearanceChangeable) {
			$content .='
				<tr>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="200" /></td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_NONE).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_VIEW).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_EDIT).'</td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_DELETE).'</td>
				</tr>';
		}
		$content .= $rowContent;
		//Page Clearance New Form
		if ($pageClearanceChangeable) {
			$content .='
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6">
						<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
					</tr>';
		}
			$content .=$postHiddenValues.'
					<input type="hidden" name="cms_action" value="setPageClearance" />
					<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
					<input type="hidden" name="currentOnglet" value="1" />
					</form>
					<form method="get" action="'.PATH_ADMIN_WR.'/tree.php">
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6">
							<input type="hidden" name="root" value="'.$rootId.'" />
							<input type="hidden" name="currentOnglet" value="2" />
							<input type="hidden" name="title" value="'.$cms_language->getMessage(MESSAGE_NEW_SECTION).'" />
							<input type="hidden" name="heading" value="'.$cms_language->getMessage(MESSAGE_NEW_SECTION_SUBTITLE).'" />
							<input type="hidden" name="backLink" value="'.PATH_ADMIN_WR.'/profiles_group.php?groupId='.$groupEdited->getGroupId().chr(167).str_replace( "&", chr(167), $urlHiddenValues).'" />';
			        		//<input type="hidden" name="pageLink" value="'.PATH_ADMIN_WR.'/profiles_group.php?cms_action=addPageClearance&amp;groupId='.$groupEdited->getGroupId().'&amp;sectionroot=%s&amp;currentOnglet=1&amp;'.str_replace( "&", "&amp;", $urlHiddenValues).'" />
				$content .='<input type="hidden" name="encodedPageLink" value="'.base64_encode(PATH_ADMIN_WR.'/profiles_group.php?cms_action=addPageClearance&groupId='.$groupEdited->getGroupId().'&sectionroot=%s&currentOnglet=1&'.$urlHiddenValues).'" />
							<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_NEW_SECTION).'" />
						</td>
					</tr>
					</form>
				';
		*/
		// Module Clearances
		$moduleClearanceChangeable=false;
		$rowContent ='';
		$content .='
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_MODULE_RIGHTS).' :</b></td>
				</tr>
				<form  method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			';
			
			$moduleClearancesStack = $groupEdited->getModuleClearances();
			$moduleClearances = $moduleClearancesStack->getElements();
			
			//Loop through stack and display clearances
			foreach ($moduleClearances as $moduleClearance) {
				// Build menu
				$module = $moduleClearance[0];
				$clearance = $moduleClearance[1];
				$allclearances = CMS_profile::getAllModuleClearances();
				$userModuleNames[] = $module;
				//Check current user has a clearance to modify
				if ($cms_user->hasModuleClearance($module, $clearance)) { 
					$options = 0;
					$clearanceSelect = '<input type="hidden" value="'.$clearance.'" name="initClearance_'.$module.'" />';
					foreach ($allclearances as $message=>$allclearance) {
						if ($cms_user->hasModuleClearance($module, $allclearance)) {
							$moduleClearanceChangeable=true;
							$clearanceSelect .= '<td class="admin_onglet_body" align="center"><input type="radio" value="'.$allclearance.'" ';
							if ($allclearance == $clearance) {
								$clearanceSelect .= ' checked="checked" ';	
							}
							$clearanceSelect .= ' name="setModuleClearance_'.$module.'" /></td>';
							$options++;
						} else {
							$clearanceSelect .= '<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
						}
					}
					//no need to display select if only one
					if ($options == 1) {
						$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
					}
				} else {
					// Cannot change hence display value
					foreach ($allclearances as $message=>$allclearance) {
						if ($allclearance == $clearance) {
							$clearanceSelect = '<td class="admin_onglet_body" colspan="3" align="center">'.$cms_language->getMessage($message).'</td>';
						}
					}
				}
				// row format
				$moduleObject = CMS_modulesCatalog::getByCodename($module);
				$moduleName = /* ($module == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):*/ $moduleObject->getLabel($cms_language);
				$rowContent .='
					<tr>
						<td class="admin_onglet_head">'.SensitiveIO::sanitizeHTMLString($moduleName).'</td>
						<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						'.$clearanceSelect.'
						<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						';
				
				if ($cms_user->hasPageClearance($module, CLEARANCE_MODULE_EDIT)) {
					$moduleClearanceChangeable=true;
					$rowContent .='<td class="admin_onglet_body" align="center"><input type="checkbox" name="removeModule_'.$module.'" value="1" /></td>';
				} else {
					$rowContent .='<td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>';
				}
				
				$rowContent .='
					</tr>
					<input type="hidden" value="'.$module.'" name="modulesClearance[]" />
				';
			}
		if ($moduleClearanceChangeable) {
			$content .='
				<tr>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="200" /></td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_MODULES_NONE).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_MODULES_VIEW).'</td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_GROUP_RIGHTS_MODULES_EDIT).'</td>
					<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_head_top" align="center">'.$cms_language->getMessage(MESSAGE_MODULE_DELETE).'</td>
				</tr>';
		}
		$content .= $rowContent;
		if ($moduleClearanceChangeable) {
			$content .='
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
					</tr>';
		}
			$content .=$postHiddenValues.'
					<input type="hidden" name="cms_action" value="setModuleClearance" />
					<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
					<input type="hidden" name="currentOnglet" value="1" />
					</form>';
					
		//Module Clearance Add Form
		//Loop through and put in those that the user doesnt have....
		$otherModuleSelect = '<select class="admin_input_text" name="othermodules">';
				  
			$allModules = CMS_modulesCatalog::getAll();
			$modulesRemaining = 0;
				  
			// Create pulldown menu
			foreach ($allModules as $aModule) {
				if (!SensitiveIO::isInSet($aModule->getCodeName(), $userModuleNames)) {
								$moduleName = ($aModule->getCodeName() == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):$aModule->getLabel($cms_language);
					$otherModuleSelect .='<option value="'.$aModule->getCodeName().'">'.$moduleName.'</option>';
					$modulesRemaining++;
				}
			}
				  
		$otherModuleSelect .= '</select>';
		
		if ($modulesRemaining > 0) {
			$content .='
					<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
					<tr>
						<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
						<td class="admin_onglet_body" align="right" colspan="6">
							<input type="hidden" name="cms_action" value="addModuleClearance" />
							<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
							<input type="hidden" name="currentOnglet" value="1" />
							'.$postHiddenValues.'
							'.$otherModuleSelect.' <input type="submit" value="'.$cms_language->getMessage(MESSAGE_ADD).'" class="admin_input_submit" />
						</td>
					</tr>
					</form>';
		}
		
		// Module access
		$moduleCtgsRows = '';
		$allModules = CMS_modulesCatalog::getAll();
		foreach ($allModules as $aModule) {
			if (/*$groupEdited->hasModuleClearance($aModule->getCodeName(), CLEARANCE_MODULE_VIEW) && */($aModule->useCategories() || $aModule->getCodeName() == MOD_STANDARD_CODENAME)) {
				$moduleCtgsRows .= ' :: <a href="modulecategories_usersgroup.php?module='.$aModule->getCodeName().'&group='.$groupEdited->getGroupID().'&backlink='.urlencode($_SERVER["SCRIPT_NAME"].'?groupId='.$groupEdited->getGroupID().'&currentOnglet=1').'" class="admin">'.$aModule->getLabel($cms_language).'</a> ';
			}
		}
		if ($moduleCtgsRows != '') {
			$content .= '
			<tr>
				<td class="admin_onglet_head_top" colspan="7">
					<b>'.$cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULES_ACCESS).' :</b>
				</td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				<td class="admin_onglet_body" colspan="6">
					'.substr($moduleCtgsRows, 4).'
				</td>
			</tr>';
		}
		
		// Validation Clearances
		if (sizeof($userModuleNames)) {
			$validationRows = '';
			foreach ($userModuleNames as $validationName) {
				if ($cms_user->hasValidationClearance($validationName)) {
					$moduleObject = new CMS_module($validationName);
					$moduleName = ($validationName == 'standard') ? $cms_language->getMessage(MESSAGE_MOD_STANDARD_LABEL):$moduleObject->getLabel($cms_language);
					$checked = ($groupEdited->hasValidationClearance($validationName)) ? 'checked="true"' : '';
					$disabled = ($groupEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
					$validationRows .= '<label for="validation_'.$validationName.'"><input type="checkbox" id="validation_'.$validationName.'" name="'.$validationName.'" '.$checked.$disabled.' />'.$moduleName.'</label> ';
				}
			}
			if ($validationRows) {
				$content .= '
				<tr>
					<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_VALIDATION_RIGHTS).' :</b></td>
				</tr>
				<form name="templategroups" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" colspan="6">'.$validationRows.'</td>
				</tr>
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" align="right" colspan="6">
						<input type="hidden" name="currentOnglet" value="1" />
						'.$postHiddenValues.'
						<input type="hidden" name="cms_action" value="changeValidation" />
						<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />';
				  	if (!$groupEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
						$content .= '<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />';
					}
					$content .= '
					</td>
				</tr>
				</form>
				';
			}
		}
		//Template groups denied	
		$content .= '	
		<tr>
			<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_TEMPLATESROWS_HEADING).' :</b></td>
		</tr>';
		
		$templategroups = CMS_pageTemplatesCatalog::getAllGroups();
		$rowsgroups = CMS_rowsCatalog::getAllGroups();
		//Create templates checkboxes
		foreach ($templategroups as $templategroup) {
			// Check if in template groups denied
			$disabled = ($groupEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$checked = (!$groupEdited->hasTemplateGroupsDenied($templategroup)) ? 'checked="true"' : '';
			$templatesCheckboxes .= '<label for="groupTemplate_'.$templategroup.'"><input type="checkbox" name="groupTemplate_'.$templategroup.'" id="groupTemplate_'.$templategroup.'" '.$checked.$disabled.' /> '.$templategroup.'</label> ';
		}
		//Create rows checkboxes
		foreach ($rowsgroups as $rowgroup) {
			// Check if in row groups denied
			$checked = (!$groupEdited->hasRowGroupsDenied($rowgroup)) ? 'checked="true"' : '';
			$disabled = ($groupEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$rowsCheckboxes .= '<label for="groupRow_'.$rowgroup.'"><input type="checkbox" name="groupRow_'.$rowgroup.'" id="groupRow_'.$rowgroup.'" '.$checked.$disabled.' /> '.$rowgroup.'</label> ';
		}
		$content .= '
		<form name="authorisationsForm" method="post" action="'.$_SERVER["SCRIPT_NAME"].'"'.$confirmMessage.'>	
		<tr>
			<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_TEMPLATES_HEADING).'</td>
			<td class="admin_onglet_body" colspan="6">
			'.$templatesCheckboxes.'
			</td>
		</tr>
		<tr>
			<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_ROWS_HEADING).'</td>
			<td class="admin_onglet_body" colspan="6">
			'.$rowsCheckboxes.'
			</td>
		</tr>
		<tr>
			<td class="admin_onglet_head">&nbsp;</td>
			<td class="admin_onglet_body" colspan="6">
			';
			$content .= '
			<div style="text-align:right;">
			<input type="hidden" name="currentOnglet" value="1" />
			'.$postHiddenValues.'
			<input type="hidden" name="cms_action" value="changeTemplateRowGroup" />
			<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />';
			if (!$groupEdited->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$content .= '<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />';
			}
			$content .= '</div>
			</td>
		</tr>
		</form>';
		// Alert level select menu
		$content .= '	
		<tr>
			<td class="admin_onglet_head_top" colspan="7"><b>'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).' :</b></td>
		</tr>';
		
		$alerts = CMS_profile::getAllAlertLevels();
		$alertSelect = '<select class="admin_input_text" name="alert">';
		
		foreach ($alerts as $message=>$alert) {
			$alertSelect .= '  <option value="'.$alert.'" ';
			if ($alert == $groupEdited->getAlertLevel()) {
				$alertSelect .= 'selected="true" ';	
			}
			$alertSelect .= '>'.$cms_language->getMessage($message).'</option>';
		}
		
		$alertSelect .= '</select>';
		
		// Alert Level display
		$content .= '
			<form name="messagelevel" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">  
			<tr>
				<td class="admin_onglet_head">'.$cms_language->getMessage(MESSAGE_LEVEL).'</td>
				<td class="admin_onglet_body" colspan="6">'.$alertSelect.'</td>
			</tr>
			<tr>
				<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				<td class="admin_onglet_body" align="right" colspan="6">
					<input type="hidden" name="currentOnglet" value="1" />
					<input type="hidden" name="cms_action" value="changeAlertLevel" />
					<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
					'.$postHiddenValues.'
					<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />
				</td>
			</tr>
			</form>
		</table><br />
		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td class="admin">
					<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_TEMPLATES_HEADING).' & '.$cms_language->getMessage(MESSAGE_ROWS_HEADING).'</dialog-title>
					<br />
					'.$cms_language->getMessage(MESSAGE_TEMPLATE_DESCRIPTION).'
					<br /><br />
					'.$cms_language->getMessage(MESSAGE_TEMPLATE_INSTRUCTION).'
					<br /><br />
					<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_HEADING).'</dialog-title>
					<br />
					'.$cms_language->getMessage(MESSAGE_ALERT_LEVEL_DESCRIPTION).'
				</td>
			</tr>
		</table>
	</div>
	<div id="og_monOnglet2" style="DISPLAY: none;top:0px;left:0px;width:100%;">';
		// Admin clearance rows
		$admins = CMS_profile::getAllAdminClearances();
		
		$adminRows = '';
		foreach ($admins as $message=>$admin) {
			if ($cms_user->hasAdminClearance($admin)) {
				$checked = ($groupEdited->hasAdminClearance($admin)) ? 'checked="true"' : '';
				$adminRows .= '
					<tr>
					  <td class="admin_onglet_head">'.$cms_language->getMessage($message).'</td>
					  <td class="admin_onglet_body"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="480" /><br /><input type="checkbox" name="'.$admin.'" '.$checked.' /></td>
					</tr>
				';
			}
		}
		if ($adminRows) {
			$content .= '
			<form name="templategroups" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
				<tr>
					<td class="admin_onglet_head_top" colspan="2"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
				</tr>
				'.$adminRows.'
				<tr>
					<td class="admin_onglet_head"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
					<td class="admin_onglet_body" align="right"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
				</tr>
			</table>
			'.$postHiddenValues.'
			<input type="hidden" name="currentOnglet" value="2" />
			<input type="hidden" name="cms_action" value="changeAdminClearance" />
			<input type="hidden" name="groupId" value="'.$groupEdited->getGroupId().'" />
			</form>
			';
		}
	$content .= '
	</div>
	<div id="og_monOnglet3" style="DISPLAY: none;top:0px;left:0px;width:100%;">';
		// Admin clearance rows
		$content .= 
		'<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
		<tr>
			<td class="admin_onglet_head_top" colspan="2">
				<strong>'.$cms_language->getMessage(MESSAGE_GROUP_LIST_USERS,array($groupEdited->getLabel())).'</strong>
			</td>
		</tr>';
		$users = CMS_profile_usersGroupsCatalog::getGroupUsers($_POST["groupId"]);
		if ($users) {
			foreach ($users as $user) {
				$contactData = $user->getContactData();
				$active = ($user->isActive()) ? $cms_language->getMessage(MESSAGE_GROUP_USER_ACTIVE) : $cms_language->getMessage(MESSAGE_GROUP_USER_INACTIVE);
				$content .= '
				<tr>
	 				<td class="admin_onglet_head"><a class="admin" href="'.PATH_ADMIN_WR.'/profiles_user.php?cms_action=edituser&userId='.$user->getUserId().'">'.$user->getFirstName(). " ".$user->getLastName().'</a></td>
					<td class="admin_onglet_body">
						<a class="admin" href="mailto:'.$contactData->getEmail().'">'.$contactData->getEmail().'</a>
						 ('.$active.')
					</td>
				</tr>
				';
			}
		} else {
			$content .= '
			<tr>
 				<td class="admin_onglet_body" colspan="2">'.$cms_language->getMessage(MESSAGE_PAGE_NO_USERS).'</td>
			</tr>';
		}
		$content .= '
		</table>';
	$content .= '
	</div>
	';
}
$content .= '
<script>monOnglet.displayFooter();</script>
		</td>
	</tr>
</table>
';

$dialog->setContent($content);
$dialog->show();
?>