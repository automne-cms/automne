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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profiles_users.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : profile users
  * Entry page. Presents all the users and available editing
  *
  * @package CMS
  * @subpackage admin
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 67);
define("MESSAGE_NEW_USER", 152);
define("MESSAGE_USER_SURNAME", 94);
define("MESSAGE_USER_NAME", 93);
define("MESSAGE_USER_GROUP", 931);
define("MESSAGE_USER_DISACTIVATE", 155);
define("MESSAGE_USER_ACTIVATE", 156);
define("MESSAGE_USER_EDIT", 87);
define("MESSAGE_USER_VIEW", 78);
define("MESSAGE_USER_OF", 157);
define("GROUPS_PER_PAGE", $_SESSION["cms_context"]->getRecordsPerPage());
define("USERS_PER_PAGE", $_SESSION["cms_context"]->getRecordsPerPage());
define("USERS_PAGE_VIEW", 207);
define("USERS_ALPHABETIC_VIEW", 206);
define("MESSAGE_PAGE_SEARCH", 212);
define("MESSAGE_USER_ENDSEARCH", 214);
define("MESSAGE_SEARCH_NOT_FOUND", 222);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 929);
define("MESSAGE_PAGE_ACTION_DELETEGROUPCONFIRM", 930);
define("MESSAGE_PAGE_ACTION_RESULT", 933);
define("MESSAGE_GROUP_PROFILES", 75);
define("MESSAGE_PERSONAL_PROFILE", 120);
define("MESSAGE_USER_PROFILES", 73);
define("MESSAGE_PAGE_ALL_USERS", 1117);
define("MESSAGE_PAGE_ALL_GROUPS", 1118);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_GROUP_NAME", 257);
define("MESSAGE_GROUP_DESCRIPTION", 139);
define("MESSAGE_NEW_GROUP", 168);
define("MESSAGE_VIEW_USERS", 926);
define("MESSAGE_GROUP_EDIT", 87);
define("MESSAGE_PAGE_NONE_ACTION", 265);

//Redirection if not user administrator
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	header("Location: ".PATH_ADMIN_WR."/profiles_user.php?".session_name()."=".session_id()) ;
	exit;
}

// Retrieve hidden values for navigation
$surnameSort = $_POST["surnameSort"].$_GET["surnameSort"];
$nameSort = $_POST["nameSort"].$_GET["nameSort"];
$primarySort = $_POST["primarySort"].$_GET["primarySort"];
$viewByLetter = $_POST["viewByLetter"].$_GET["viewByLetter"];
$alphabet = CMS_profile_usersCatalog::getLettersForLastName();

if ($_POST["searchUsers"]) {
	$showWhat = $_POST["showWhat"];
	$searchValue = $_POST["newSearchValue"];
	$searchCol = $_POST["newSearchCol"];
	$cms_context->setSessionVar('usersShowWhat',$showWhat);
	$cms_context->setSessionVar('usersSearchValue',$searchValue);
	$cms_context->setSessionVar('usersSearchCol',$searchCol);
} else {
	$showWhat = $cms_context->getSessionVar('usersShowWhat');
	$searchValue = $cms_context->getSessionVar('usersSearchValue');
	$searchCol = $cms_context->getSessionVar('usersSearchCol');
}

// Retrieve hidden values for group navigation
$groupnameSort = $_POST["groupnameSort"].$_GET["groupnameSort"];
$viewGroupByLetter = $_POST["viewGroupByLetter"].$_GET["viewGroupByLetter"];
$alphabetGroup = CMS_profile_usersGroupsCatalog::getLettersForTitle();

if ($_POST["searchGroups"]) {
	$showGroupWhat = $_POST["showGroupWhat"];
	$searchGroupValue = $_POST["newSearchGroupValue"];
	$cms_context->setSessionVar('groupsShowWhat',$showGroupWhat);
	$cms_context->setSessionVar('groupsSearchValue',$searchGroupValue);
} else {
	$showGroupWhat = $cms_context->getSessionVar('groupsShowWhat');
	$searchGroupValue = $cms_context->getSessionVar('groupsSearchValue');
}

// Action management
switch ($_POST["cms_action"]) {
	// ****************************************************************
	// ** Groups actions                                             **
	// ****************************************************************
	case "groupnamesort":
		if ($groupnameSort) {
			$groupnameSort = "";
		} else {
			$groupnameSort = "desc";
		}
		break;
	case "searchGroups":
		$cms_context->setSessionVar('groupBookmark',1);
		switch ($showGroupWhat) {
			case 'all':
				$viewGroupByLetter = "";
				$searchGroupValue = "";
				$cms_context->setSessionVar('groupsSearchValue','');
			break;
			case 'letter':
				$viewGroupByLetter = $alphabetGroup[0];
				$searchGroupValue = "";
				$cms_context->setSessionVar('groupsSearchValue','');
			break;
			case 'search':
				if ($searchGroupValue = $_POST["newSearchGroupValue"].$_GET["newSearchGroupValue"] ) {
					$searchGroupValue = str_replace( "*", "%", $searchGroupValue);
					if (strpos($searchGroupValue, "%") === false) {
						$searchGroupValue = $searchGroupValue."%";
					}
					$searchGroupValue = SensitiveIO::sanitizeSQLString($searchGroupValue);	
				} else {
					$searchGroupValue = "";
				}
				$cms_context->setSessionVar('groupsSearchValue',$searchGroupValue);
				$viewGroupByLetter = "";
			break;
		}
		break;
	case "deleteGroup":
		$group = CMS_profile_usersGroupsCatalog::getByID($_POST["groupId"]);
		$group->destroy();
		$log = new CMS_log();
		$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_DELETE, $cms_user, "Group : ".$group->getLabel());
		break;
		
	// ****************************************************************
	// ** Users Actions                                              **
	// ****************************************************************
	case "activateuser":
		$usr = CMS_profile_usersCatalog::getByID($_POST["userId"]);
		if (is_a($usr, "CMS_profile_user")) {
			$usr->setActive(true);
			$usr->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$usr->getFirstName()." ".$usr->getLastName(). " (activate)");
		}
		break;
	case "disactivateuser":
		$usr = CMS_profile_usersCatalog::getByID($_POST["userId"]);
		if (is_a($usr, "CMS_profile_user")) {
			$usr->setActive(false);
			$usr->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$usr->getFirstName()." ".$usr->getLastName(). " (disactivate)");
		}
		break;
	case "deleteuser":
		$usr = CMS_profile_usersCatalog::getByID($_POST["userId"]);
		if (is_a($usr, "CMS_profile_user")) {
			$usr->setDeleted(true);
			$usr->setActive(false);
			$usr->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$usr->getFirstName()." ".$usr->getLastName(). " (delete)");
		}
		break;
	case "surnamesort":
		$primarySort = "surname";
		if ($surnameSort) {
			$surnameSort = "";
		} else {
			$surnameSort = "desc";
		}
		break;
	case "namesort":
		$primarySort = "name";
		if ($nameSort) {
			$nameSort = "";
		} else {
			$nameSort = "desc";
		}
		break;
	case "search":
		switch ($showWhat) {
			case 'all':
				$viewByLetter = "";
				$searchValue = "";
				$searchCol = "";
				$cms_context->setSessionVar('usersSearchValue','');
				$cms_context->setSessionVar('usersSearchCol','');
			break;
			case 'letter':
				$viewByLetter = $alphabet[0];
				$searchValue = "";
				$searchCol = "";
				$cms_context->setSessionVar('usersSearchValue','');
				$cms_context->setSessionVar('usersSearchCol','');
			break;
			case 'search':
				if ($newSearchValue = $_POST["newSearchValue"].$_GET["newSearchValue"] ) {
					$searchValue = str_replace("*", "%", $newSearchValue);
					if (strpos($searchValue, "%") === false) {
						$searchValue = $searchValue."%";
					}
					$searchValue = SensitiveIO::sanitizeSQLString($searchValue);	
					$searchCol = SensitiveIO::sanitizeSQLString($_POST["newSearchCol"]);
					$cms_context->setBookmark(1); //reset context
				} else {
					$searchValue = "";
					$searchCol = "";
					$cms_context->setBookmark(1); //reset context
				}
				$viewByLetter = "";
			break;
		}
		break;
}

// ****************************************************************
// ** Groups search management                                   **
// ****************************************************************
// Set sql where
if ($searchGroupValue || $showGroupWhat=='search') {
	$sqlGroupWhere = "
			where
				label_prg
			like 
	    '".$searchGroupValue."'
	";
	
} elseif ($viewGroupByLetter || $showGroupWhat=='letter') {
	if (!$viewGroupByLetter) {
		$viewGroupByLetter = $alphabetGroup[0];
	}
	$sqlGroupWhere = "
		where
	 		label_prg like '".strtolower($viewGroupByLetter)."%'
		or
			label_prg like '".$viewGroupByLetter."%'
	";
}

// Set Hidden values html
$postHiddenGroupValues = '
	<input type="hidden" name="groupnameSort" value="'.$groupnameSort.'" />
	<input type="hidden" name="viewGroupByLetter" value="'.$viewGroupByLetter.'" />
';

$urlHiddenGroupValues = 'groupnameSort='.$nameSort.'&amp;viewGroupByLetter='.$viewGroupByLetter;

// Update bookmark for page navigation
if ($_GET["groupBookmark"] && !$viewGroupByLetter) {
	$cms_context->setSessionVar('groupBookmark',$_GET["groupBookmark"]);
}

// Run Query
$sqlGroup = "
	select
		*
	from
		profilesUsersGroups ".
	$sqlGroupWhere."
	order by
		label_prg ".$groupnameSort."
	";
$qGroup = new CMS_query($sqlGroup);
$totalGroupRecords = $qGroup->getNumRows();

// Letter Navigation
if ($viewGroupByLetter) {
	
	$dialogpagesGroup = '
		<br />
		<table>
		  <tr>
		    <td class="admin"><b>';
		
	foreach ($alphabetGroup as $letterGroup) {
		if ($letterGroup == $viewGroupByLetter) {
			$dialogpagesGroup .= '<span class="admin_current">'.$letterGroup.'</span> ';
		} else {
			$dialogpagesGroup .= '<a class="admin" href="'.$_SERVER["SCRIPT_NAME"].'?viewGroupByLetter='.$letterGroup.'&amp;currentOnglet=1&amp;groupnameSort='.$groupnameSort.'">'.$letterGroup.'</a> ';
		}
	}
		
	$dialogpagesGroup .= '</b>
			</td>
	      </tr>
		</table>
	';
	
	if ($totalGroupRecords) {
		$firstGroupPageRecord = 1;
		$lastGroupPageRecord = $totalGroupRecords;
	}

// Regular Navigation hence check records	
} elseif ($totalGroupRecords) {
				
	// Set record Naviagtion details
	$firstGroupPageRecord = (($cms_context->getSessionVar('groupBookmark') - 1) * GROUPS_PER_PAGE) + 1;
	$lastGroupPageRecord = $cms_context->getSessionVar('groupBookmark') * GROUPS_PER_PAGE;
	
	if ($lastGroupPageRecord > $totalGroupRecords) {
		$lastGroupPageRecord = $totalGroupRecords; 
	}
	
	// Check Pages
	$remainderGroup = $totalGroupRecords % GROUPS_PER_PAGE;
		if ($remainderGroup) {
		$maxGroupPages = (($totalGroupRecords - ($remainderGroup)) / GROUPS_PER_PAGE) + 1;	
	} else {
		$maxGroupPages = $totalGroupRecords / GROUPS_PER_PAGE;
	}
	
	$dialogpagesGroup = '
	  	<dialog-pages maxPages="'.$maxGroupPages.'" boomarkName="groupBookmark">
			<dialog-pages-param name="groupnameSort" value="'.$groupnameSort.'" />
			<dialog-pages-param name="currentOnglet" value="1" />
			<dialog-pages-param name="viewGroupByLetter" value="'.$viewGroupByLetter.'" />
		</dialog-pages>
	';
} elseif($searchGroupValue) {
	// No values and is search hence display message
	
	$colGroup = $cms_language->getMessage(MESSAGE_GROUP_NAME);
	$searchGroupMessage .= $cms_language->getMessage(
	 		MESSAGE_SEARCH_NOT_FOUND, 
			array($colGroup, str_replace( "%", "", $searchGroupValue)));
}

// ****************************************************************
// ** Users search management                                    **
// ****************************************************************
// Set sql where
if ($searchValue && $showWhat=='search') {
	$sqlWhere = "
			where
				deleted_pru=0
				and ".$searchCol."_pru like '".$searchValue."'
	";
} elseif ($viewByLetter && $showWhat=='letter') {
	$sqlWhere = "
		where
			deleted_pru=0
	 		and (lastName_pru like '".strtolower($viewByLetter)."%'
			or lastName_pru like '".$viewByLetter."%')
	";
} else {
	$sqlWhere = "
		where
			deleted_pru=0
	";
}

// Set Hidden values html
$postHiddenValues = '
	<input type="hidden" name="surnameSort" value="'.$surnameSort.'" />
	<input type="hidden" name="nameSort" value="'.$nameSort.'" />
	<input type="hidden" name="primarySort" value="'.$primarySort.'" />
	<input type="hidden" name="viewByLetter" value="'.$viewByLetter.'" />
';

$urlHiddenValues_without_letter = 'surnameSort='.$surnameSort.'&amp;nameSort='.$nameSort.'&amp;';
$urlHiddenValues_without_letter .= 'primarySort='.$primarySort;
$urlHiddenValues = $urlHiddenValues_without_letter.'&amp;viewByLetter='.$viewByLetter; 

//Create sql order by
if ($primarySort == "name") {
	$sqlOrderBy = "
		order by
			firstName_pru ".$nameSort.",
			lastName_pru ".$surnameSort."
	";
} else {
	$sqlOrderBy = "
		order by
			lastName_pru ".$surnameSort.",
			firstName_pru ".$nameSort."
	";
}

//Update bookmark for page navigation
if ($_GET["bookmark"] || $_POST["bookmark"]) {
	$cms_context->setBookmark($_REQUEST["bookmark"]);
}

// Run query
$sql = "
	select
		*
	from
		profilesUsers
	".$sqlWhere."
	".$sqlOrderBy. "
";
$q = new CMS_query($sql);
$totalRecords = $q->getNumRows();

// Letter Navigation
if ($viewByLetter) {
	$dialogpages = '
		<table>
		  <tr>
		    <td class="admin"><b>';
	foreach ($alphabet as $letter) {
		if ($letter == $viewByLetter) {
			$dialogpages .= '<span class="admin_current">'.$letter.'</span> ';
		} else {
			$dialogpages .= '<a href="'.$_SERVER["SCRIPT_NAME"].'?viewByLetter='.$letter.'&amp;'.$urlHiddenValues_without_letter.'" class="admin">'.$letter.'</a> ';
		}
	}
	$dialogpages .= '</b>
			</td>
	      </tr>
		</table>
	';
	
	if ($totalRecords) {
		$firstPageRecord = (($cms_context->getBookmark() - 1) * USERS_PER_PAGE) + 1;
		$lastPageRecord = $cms_context->getBookmark() * USERS_PER_PAGE;
	}
	$maxPages = ceil($totalRecords / USERS_PER_PAGE);
	
	$dialogpages .= '
	  	<dialog-pages maxPages="'.$maxPages.'">
		  <dialog-pages-param name="surnameSort" value="'.$surnameSort.'" />
	      <dialog-pages-param name="nameSort" value="'.$nameSort.'" />
	      <dialog-pages-param name="primarySort" value="'.$primarySort.'" />
		  <dialog-pages-param name="viewByLetter" value="'.$viewByLetter.'" />
		</dialog-pages>';

// Regular Navigation hence check records	
} elseif($totalRecords) {
	// Set record Naviagtion details
	$firstPageRecord = (($cms_context->getBookmark() - 1) * USERS_PER_PAGE) + 1;
	$lastPageRecord = $cms_context->getBookmark() * USERS_PER_PAGE;
	
	if ($lastPageRecord > $totalRecords) {
		$lastPageRecord = $totalRecords; 
	}
	
	// Check Pages
	$maxPages = ceil($totalRecords / USERS_PER_PAGE);
	$dialogpages = '
	  	<dialog-pages maxPages="'.$maxPages.'">
		  <dialog-pages-param name="surnameSort" value="'.$surnameSort.'" />
	      <dialog-pages-param name="nameSort" value="'.$nameSort.'" />
	      <dialog-pages-param name="primarySort" value="'.$primarySort.'" />
		  <dialog-pages-param name="viewByLetter" value="'.$viewByLetter.'" />
		</dialog-pages>';
} elseif($searchValue) {
	// No values and is search hence display message
	
	if ($searchCol == "firstName") {
		$col = $cms_language->getMessage(MESSAGE_USER_NAME);
	} else {
		$col = $cms_language->getMessage(MESSAGE_USER_SURNAME);
	}
	
	$searchMessage .= $cms_language->getMessage(
	 		MESSAGE_SEARCH_NOT_FOUND, 
			array($col, str_replace( "%", "", $searchValue)));
}

//Display
$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_comptes.gif');
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

//Base Data
$content = '';

$selectedShowAll = ($showWhat == "all" || $showWhat == "") ? ' checked="checked"' : '';
$selectedShowLetters = ($showWhat == "letter") ? ' checked="checked"' : '';
$selectedShowSearch = ($showWhat == "search") ? ' checked="checked"' : '';
$selectedFirstCol = ($searchCol == "firstName") ? ' selected="selected"' : '';
$selectedLastCol = ($searchCol == "lastName") ? ' selected="selected"' : '';
$content .='
<script language="javascript">
<!-- Definir les Styles des onglets -->
ongletstyle();
<!-- Creation de l\'objet Onglet  -->
var monOnglet = new Onglet("monOnglet", "100%", "100%", "110", "30", "'.$currentOnglet.'");
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_USER_PROFILES).'", "'.$cms_language->getMessage(MESSAGE_USER_PROFILES).'"));
monOnglet.add(new OngletItem("'.$cms_language->getMessage(MESSAGE_GROUP_PROFILES).'", "'.$cms_language->getMessage(MESSAGE_GROUP_PROFILES).'"));
</script>
<table width="600" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
<script>monOnglet.displayHeader();</script>';

// ****************************************************************
// ** Users Tab                                                  **
// ****************************************************************

$content .='
<div id="og_monOnglet0" style="DISPLAY: none;top:0px;left:0px;width:100%;">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
	<tr>
		<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
	</tr>
	<tr>
		<td class="admin"><br />
		<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
		<fieldset id="search" class="admin">
		<legend class="admin"><b>'.$cms_language->getMessage(MESSAGE_PAGE_SEARCH).'</b></legend>
			'.$postHiddenValues.'
			<input type="hidden" name="bookmark" value="1" />
			<input type="hidden" name="cms_action" value="search" />
			<label for="showAll">
				<div nowrap="nowrap"><input id="showAll" type="radio" class="admin_input_radio" name="showWhat" value="all"' . $selectedShowAll . ' /> ' . $cms_language->getMessage(MESSAGE_PAGE_ALL_USERS) . '</div>
			</label><br />
			<label for="showByLetter">
				<div nowrap="nowrap"><input id="showByLetter" type="radio" class="admin_input_radio" name="showWhat" value="letter"' . $selectedShowLetters . ' /> ' . $cms_language->getMessage(USERS_ALPHABETIC_VIEW) . '</div>
			</label><br />
			<label for="showBySearch">
				<div nowrap="nowrap"><input id="showBySearch" type="radio" class="admin_input_radio" name="showWhat" value="search"' . $selectedShowSearch . ' /> 
				<select class="admin_input_text" name="newSearchCol">
					<option value="firstName"'.$selectedFirstCol.'>'.$cms_language->getMessage(MESSAGE_USER_NAME).'</option>
					<option value="lastName"'.$selectedLastCol.'>'.$cms_language->getMessage(MESSAGE_USER_SURNAME).'</option>
				</select>
				<input type="text" class="admin_input_text" size="15" name="newSearchValue" value="'.str_replace( "%", "", $searchValue).'" /></div>
			</label><br />
		</fieldset>
		<input type="hidden" name="searchUsers" value="1" />
		<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />&nbsp;<input type="button" onClick="location.replace(\'profiles_user.php?cms_action=add&'.session_name().'='.session_id().'\');check();" value="'.$cms_language->getMessage(MESSAGE_NEW_USER).'" class="admin_input_submit" />
		</form>
		';
		
		// Results
		if ($showWhat) {
			$content .= '
			<br />	
			<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_RESULT).'</dialog-title>
			<br />';
			if ($totalRecords) {
				$content .= '
				<table border="0" cellpadding="2" cellspacing="2">
					<tr>
					  <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
					  <th class="admin">
						  '.$postHiddenValues.'
						  <input type="hidden" name="cms_action" value="surnamesort" />
						  <div align="left"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_USER_SURNAME).'" class="admin_input_submit" /></div>
					  </th>
					  </form>
					  <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
					  <th class="admin" align="left">
						  '.$postHiddenValues.'
						  <input type="hidden" name="cms_action" value="namesort" />
						  <div align="left"><input type="submit" value="'.$cms_language->getMessage(MESSAGE_USER_NAME).'" class="admin_input_submit" /></div>
					  </th>
					  </form>
					  <th class="admin" align="center">'.$cms_language->getMessage(MESSAGE_USER_GROUP).'</th>
					  <th class="admin" align="center" colspan="3">
						 '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'
					  </th>
					</tr>
				';
				// loop through and create user table
				for ($i=1; ($data = $q->getArray()) && ($i <= $lastPageRecord) ; $i++) {
					
					if (($i >= $firstPageRecord) && ($i <= $lastPageRecord)) {  
						$td_class = ($i % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
						//Check if user active or disactive
						if ($data["active_pru"]) {
							$active = $cms_language->getMessage(MESSAGE_USER_DISACTIVATE);
							$userAction = "disactivateuser";
							$cl = '';
						} else {
							$active = $cms_language->getMessage(MESSAGE_USER_ACTIVATE);
							$userAction = "activateuser";
							$cl = 'class="admin_lightgreybg"';
						}
						
						$user = CMS_profile_usersCatalog::getByID($data["id_pru"]);
						if(is_object($user)) {
							$groups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user);
							$currentName = ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? '<span style="cursor:help;" title="CMS_Profile: '.$user->getID().', CMS_profile_user: '.$user->getUserId().'">'.$user->getLastName().'</span>' : $user->getLastName();
							$content .= '
							<tr '.$cl.'>
								<td class="'.$td_class.'" align="left">
									'.$currentName.'
								</td>
								<td class="'.$td_class.'" align="left">
									'.$user->getFirstName().'
								</td>
								<td class="'.$td_class.'" align="left">';
								foreach ($groups as $group) {
									$content .= '<a href="'.PATH_ADMIN_WR.'/profiles_group.php?cms_action=editgroup&amp;groupId='.$group->getGroupId().'" class="admin" alt="'.htmlspecialchars($group->getDescription()).'" title="'.htmlspecialchars($group->getDescription()).'">'.$group->getLabel().'</a><br />';
								}
							$content .= '</td>
						    <form method="post" action="'.PATH_ADMIN_WR.'/profiles_user.php">
							  <td class="'.$td_class.'" align="center"> 
								  '.$postHiddenValues.'
								  <input type="hidden" name="cms_action" value="edituser" />
							      <input type="hidden" name="userId" value="'.$data["id_pru"].'" />
								  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_EDIT).'" class="admin_input_'.$td_class.'" />
							  </td>
						    </form>';
							//Root user and Public user can not be deleted
							if ($user->getUserId() > 3) {
								$content .= '
							    <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
						    	  <td class="'.$td_class.'" align="left"> 
									  '.$postHiddenValues.'
									  <input type="hidden" name="cms_action" value="'.$userAction.'" />
								      <input type="hidden" name="userId" value="'.$data["id_pru"].'" />
									  <input type="submit" value="'.$active.'" class="admin_input_'.$td_class.'"'.$disabled.' />
								  </td>
							    </form>
							    <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array($user->getFirstName()." ".$user->getLastName()))) . ' ?\')">
						    	  <td class="'.$td_class.'" align="left"> 
									  '.$postHiddenValues.'
									  <input type="hidden" name="cms_action" value="deleteuser" />
								      <input type="hidden" name="userId" value="'.$data["id_pru"].'" />
									  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_DELETE).'"'.$disabled.' class="admin_input_'.$td_class.'" />
								  </td>
							    </form>';
							} else {
								$content .= '<td class="'.$td_class.'">&nbsp;</td><td class="'.$td_class.'">&nbsp;</td>';
							}
							$content .= '
							</tr>';
						}
					}
				}
				$content .= '
			    </table>
				'.$dialogpages;
			} else {
				$content .= $searchMessage;
			}
			$content .= '
			<br />
			<form method="post" action="'.PATH_ADMIN_WR.'/profiles_user.php">
			'.$postHiddenValues.'
			<input type="hidden" name="cms_action" value="add" />
			<input type="submit" value="'.$cms_language->getMessage(MESSAGE_NEW_USER).'" class="admin_input_submit" />
			</form>';
		}
		$content .= '
		</td>
	</tr>
</table>
</div>';

// ****************************************************************
// ** Groups Tab                                                 **
// ****************************************************************

$content .='
<div id="og_monOnglet1" style="DISPLAY: none;top:0px;left:0px;width:100%;">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="admin_onglet">
	<tr>
		<td class="admin_onglet_head_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" border="0" height="1" width="1" /></td>
	</tr>
	<tr>
		<td class="admin"><br />';
		$selectedShowAllGroups = ($showGroupWhat == "all" || $showGroupWhat == "") ? ' checked="checked"' : '';
		$selectedShowLettersGroups = ($showGroupWhat == "letter") ? ' checked="checked"' : '';
		$selectedShowSearchGroups = ($showGroupWhat == "search") ? ' checked="checked"' : '';
		$content .= '
		<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
		<fieldset id="search" class="admin">
		<legend class="admin"><b>'.$cms_language->getMessage(MESSAGE_PAGE_SEARCH).'</b></legend>
			'.$postHiddenValues.'
			<input type="hidden" name="cms_action" value="searchGroups" />
			<label for="showAllGroup">
				<div nowrap="nowrap"><input id="showAllGroup" type="radio" class="admin_input_radio" name="showGroupWhat" value="all"' . $selectedShowAllGroups . ' /> ' . $cms_language->getMessage(MESSAGE_PAGE_ALL_GROUPS) . '</div>
			</label><br />
			<label for="showGroupByLetter">
				<div nowrap="nowrap"><input id="showGroupByLetter" type="radio" class="admin_input_radio" name="showGroupWhat" value="letter"' . $selectedShowLettersGroups . ' /> ' . $cms_language->getMessage(USERS_ALPHABETIC_VIEW) . '</div>
			</label><br />
			<label for="showGroupBySearch">
				<div nowrap="nowrap"><input id="showGroupBySearch" type="radio" class="admin_input_radio" name="showGroupWhat" value="search"' . $selectedShowSearchGroups . ' /> 
				<input type="text" class="admin_input_text" size="15" name="newSearchGroupValue" value="'.str_replace( "%", "", $searchGroupValue).'" /></div>
			</label><br />
		</fieldset>
		<input type="hidden" name="searchGroups" value="1" />
		<input type="hidden" name="currentOnglet" value="1" />
		<input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" />&nbsp;<input type="button" onClick="location.replace(\'profiles_group.php?cms_action=add&'.session_name().'='.session_id().'\');check();" value="'.$cms_language->getMessage(MESSAGE_NEW_GROUP).'" class="admin_input_submit" />
		</form>';
		
		// Results
		if ($showGroupWhat) {
			$content .= '
			<br />	
			<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_RESULT).'</dialog-title>
			<br />';
			
			if ($totalGroupRecords) {
				$content .= '
				<table border="0" cellpadding="2" cellspacing="2">
					<tr>
					  <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
					  <th class="admin" align="left">
						  '.$postHiddenGroupValues.'
						  <input type="hidden" name="currentOnglet" value="1" />
						  <input type="hidden" name="cms_action" value="groupnamesort" />
						  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_GROUP_NAME).'" class="admin_input_submit" />
					  </th>
					  </form>
					  <th class="admin" align="left">
						  '.$cms_language->getMessage(MESSAGE_GROUP_DESCRIPTION).'
					  </th>
					  <th class="admin" align="center" colspan="3"> 
						'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'
					  </th>
					</tr>
				';
				// loop through and create group table
				for ($i=1; ($data = $qGroup->getArray()) && ($i <= $lastGroupPageRecord) ; $i++) {
					$currentGroupName = ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? '<span style="cursor:help;" title="groupID: '.$data["id_prg"].'">'.$data["label_prg"].'</span>' : $data["label_prg"];
					if (($i >= $firstGroupPageRecord) && ($i <= $lastGroupPageRecord)) {  
						$td_class = ($i % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
				$content .= '
					<tr>
					  <td class="'.$td_class.'" align="left" valign="top">
					   '.$currentGroupName.'
					  </td>
					  <td class="'.$td_class.'" align="left" valign="top">
					   '.$data["description_prg"].'
					  </td>
				    <form method="post" action="'.PATH_ADMIN_WR.'/profiles_group.php">
					  <td class="'.$td_class.'" align="center"> 
						  '.$postHiddenGroupValues.'
						  <input type="hidden" name="cms_action" value="editgroup" />
					      <input type="hidden" name="groupId" value="'.$data["id_prg"].'" />
						  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_GROUP_EDIT).'" class="admin_input_'.$td_class.'" />
					  </td>
				    </form>
				    <form method="post" action="'.$_SERVER["SCRIPT_NAME"].'" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETEGROUPCONFIRM, array($data["label_prg"]))) . ' ?\')">
					  <td class="'.$td_class.'">
						  <input type="hidden" name="cms_action" value="deleteGroup" />
					      '.$postHiddenGroupValues.'
						  <input type="hidden" name="currentOnglet" value="1" />
						  <input type="hidden" name="groupId" value="'.$data["id_prg"].'" />
						  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_DELETE).'" class="admin_input_'.$td_class.'" />
					  </td>
				    </form>
				    <form method="post" action="'.PATH_ADMIN_WR.'/profiles_group.php">
					  <td class="'.$td_class.'">
					      '.$postHiddenGroupValues.'
						  <input type="hidden" name="currentOnglet" value="3" />
						  <input type="hidden" name="groupId" value="'.$data["id_prg"].'" />
						  <input type="submit" value="'.$cms_language->getMessage(MESSAGE_VIEW_USERS).'" class="admin_input_'.$td_class.'" />
					  </td>
				    </form>
					</tr>';
					}
				}
				$content .= '
				   </table>
				   '.$dialogpagesGroup.'
				   <br />
				';
			} else {
				if ($searchGroupMessage) {
					$content .=$searchGroupMessage;
				} else {
					$content .= $cms_language->getMessage(MESSAGE_PAGE_NONE_ACTION);
				}
			}
			
			// Add Group button
			$content .= '
			<form method="post" action="'.PATH_ADMIN_WR.'/profiles_group.php">
			   	'.$postHiddenGroupValues.'
				<input type="hidden" name="cms_action" value="add" />
				<input type="submit" value="'.$cms_language->getMessage(MESSAGE_NEW_GROUP).'" class="admin_input_submit" />
			</form>';
		}
		$content .= '
		</td>
	</tr>
</table>
</div>
<script>monOnglet.displayFooter();</script>
		</td>
	</tr>
</table>
';

$dialog->setContent($content);
$dialog->show();
?>