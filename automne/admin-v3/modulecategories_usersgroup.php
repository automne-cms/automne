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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: modulecategories_usersgroup.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module admin frontend
  * Manage rights for categories and pages
  *
  * @package CMS
  * @subpackage admin
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_SAVE", 952);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_FIELD_GROUP", 189);
define("MESSAGE_PAGE_TITLE_PROFILES", 67);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_CATEGORIES_ROOT", 1208);
define("MESSAGE_PAGE_TITLE_CATEGORIES_GROUP_ACCESS", 1209);
define("MESSAGE_PAGE_DISPLAYED_DEPTH", 1339);
define("MESSAGE_PAGE_FIELD_MODULE", 1345);
define("MESSAGE_PAGE_FIELD_GROUP", 931);
define("MESSAGE_PAGE_TITLE_PAGES_GROUP_ACCESS", 1346);
define("MESSAGE_PAGE_TITLE_PAGES_USER_ACCESS", 1347);
define("MESSAGE_PAGE_PAGES_ROOT", 1348);
define("MESSAGE_PAGE_FIELD_PAGES", 213);
define("MESSAGE_PAGE_FIELD_USER", 908);
define("MESSAGE_PAGE_TITLE_CATEGORIES_USER_ACCESS", 1350);
define("MESSAGE_PAGE_USER_BELONGS_TO_GROUPS", 1351);

//augment the execution time, because things here can be quite lengthy
@set_time_limit(300);
//ignore user abort to avoid interuption of process
@ignore_user_abort(true);

// Colors used to visualize access level
$clearance_colors = array (
	CLEARANCE_MODULE_NONE 	=> '#FF7E71',
	CLEARANCE_MODULE_VIEW 	=> '#e2faaa',
	CLEARANCE_MODULE_EDIT 	=> '#CFE779',
	CLEARANCE_MODULE_MANAGE => '#85A122',
);
$bg_color_selected = "#fdf5a2";

// Get module codename and check user's permissions on the module
if (trim($_REQUEST["module"])) {
	$cms_module_codename = trim($_REQUEST["module"]);
	$_SESSION["cms_context"]->setSessionVar("module_codename", $cms_module_codename);
} elseif ($_SESSION["cms_context"]->getSessionVar("module_codename") !== false) {
	$cms_module_codename = $_SESSION["cms_context"]->getSessionVar("module_codename");
}
if (!$cms_module_codename) {
	header("Location :".PATH_ADMIN_SPECIAL_ENTRY_WR."?".session_name()."=".session_id());
	exit;
}
if (!$cms_user->hasModuleClearance($cms_module_codename, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$cms_module = CMS_modulesCatalog::getByCodename($cms_module_codename);

$all_languages = CMS_languagesCatalog::getAllLanguages($cms_module_codename);

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+
if (isset($_GET["open"]) && sensitiveIO::isPositiveInteger($_GET["open"])) {
	$openedItems = $_SESSION["cms_context"]->getSessionVar("items_opened");
	$closedItems = $_SESSION["cms_context"]->getSessionVar("items_closed");
	if (isset($closedItems[$_GET["open"]])) {
		unset($closedItems[$_GET["open"]]);
	} elseif (!isset($openedItems[$_GET["open"]])) {
		$openedItems[$_GET["open"]] = true;
	}
	$_SESSION["cms_context"]->setSessionVar("items_opened", $openedItems);
	$_SESSION["cms_context"]->setSessionVar("items_closed", $closedItems);
	$_GET["item"] = $_GET["open"];
}
if (isset($_GET["close"]) && sensitiveIO::isPositiveInteger($_GET["close"])) {
	$openedItems = $_SESSION["cms_context"]->getSessionVar("items_opened");
	$closedItems = $_SESSION["cms_context"]->getSessionVar("items_closed");
	if (isset($openedItems[$_GET["close"]])) {
		unset($openedItems[$_GET["close"]]);
	} elseif (!isset($closedItems[$_GET["close"]])) {
		$closedItems[$_GET["close"]] = true;
	}
	$_SESSION["cms_context"]->setSessionVar("items_opened", $openedItems);
	$_SESSION["cms_context"]->setSessionVar("items_closed", $closedItems);
	$_GET["item"] = $_GET["close"];
}
// Get current root item under navigation
if (isset($_GET["item"]) && sensitiveIO::isPositiveInteger($_GET["item"])) {
	$_SESSION["cms_context"]->setSessionVar("current_item", (int) $_GET["item"]);
}
// Get current group to edit 
if (SensitiveIO::isPositiveInteger($_REQUEST["group"])) {
	$_SESSION["cms_context"]->setSessionVar("current_group", (int) $_REQUEST["group"]);
	$_SESSION["cms_context"]->setSessionVar("current_user", '');
} elseif (SensitiveIO::isPositiveInteger($_REQUEST["user"])) {
	$_SESSION["cms_context"]->setSessionVar("current_user", (int) $_REQUEST["user"]);
	$_SESSION["cms_context"]->setSessionVar("current_group", '');
}
$disableFields = false;
//instanciate group or user
if ($_SESSION["cms_context"]->getSessionVar("current_group")) {
	$group = CMS_profile_usersGroupsCatalog::getById($_SESSION["cms_context"]->getSessionVar("current_group"));
	if (!is_object($group) || $group->hasError()) {
		header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
		exit;
	}
} else if ($_SESSION["cms_context"]->getSessionVar("current_user")) {
	$user = CMS_profile_usersCatalog::getById($_SESSION["cms_context"]->getSessionVar("current_user"));
	if (!is_object($user) || $user->hasError()) {
		header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
		exit;
	}
	//Get groups of user
	$userGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user);
	if (sizeof($userGroups)) {
		//if user has groups, fields must be disabled
		$disableFields = true;
	}
} else {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
// Store backlink in session
if (isset($_GET["backlink"])) {
	$_SESSION["cms_context"]->setSessionVar("backlink", $_GET["backlink"]);
}

// Current usersgroup clearances
if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
	if (is_object($group)) {
		$stack_clearances = $group->getModuleCategoriesClearancesStack();
	} elseif (is_object($user)) {
		$stack_clearances = $user->getModuleCategoriesClearancesStack();
	}
	$modules_clearances = CMS_Profile::getAllModuleCategoriesClearances();
	// Current category which will be deployed
	if ($_SESSION["cms_context"]->getSessionVar("current_item")) {
		$current_item = CMS_moduleCategories_catalog::getByID($_SESSION["cms_context"]->getSessionVar("current_item"));
	}
} else {
	if (is_object($group)) {
		$stack_clearances = $group->getPageClearances();
	} elseif (is_object($user)) {
		$stack_clearances = $user->getPageClearances();
	}
	$modules_clearances = CMS_Profile::getAllPageClearances();
	// Current page which will be deployed
	if ($_SESSION["cms_context"]->getSessionVar("current_item")) {
		$current_item = CMS_tree::getPageByID($_SESSION["cms_context"]->getSessionVar("current_item"));
	}
}

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+
switch ($_POST["cms_action"]) {
case 'maxDepth':
		if (sensitiveIO::isPositiveInteger($_POST['maxDepth'])) {
			$_SESSION["cms_context"]->setSessionVar("modules_clearances_max_depth", $_POST['maxDepth']);
			$_SESSION["cms_context"]->setSessionVar("items_opened", array());
			$_SESSION["cms_context"]->setSessionVar("items_closed", array());
		}
	break;
}
// Limit recurse process to n iterations
if (!sensitiveIO::isPositiveInteger($_SESSION["cms_context"]->getSessionVar("modules_clearances_max_depth"))) {
	$_SESSION["cms_context"]->setSessionVar("modules_clearances_max_depth", 2);
}
$maxDepth = $_SESSION["cms_context"]->getSessionVar("modules_clearances_max_depth");
$openedItems = $_SESSION["cms_context"]->getSessionVar("items_opened");
$closedItems = $_SESSION["cms_context"]->getSessionVar("items_closed");

// +----------------------------------------------------------------------+
// | Functions                                                            |
// +----------------------------------------------------------------------+

if (!function_exists("build_items_tree")) {
	/** 
	  * Recursive function to build items tree.
	  *
	  * @param mixed $items : current category or page
	  * @param integer $count, to determine item in-tree depth
	  * @param integer $parent_clearance, immediate parent item clearance
	  * @return string HTML formated
	  */
	function build_items_tree(&$item, $count, $parent_clearance) {
		global $cms_module_codename, $cms_language, $cms_module, $cms_user;
		global $current_item, $items_ids;
		global $modules_clearances, $stack_clearances;
		global $maxDepth, $openedItems, $closedItems, $clearance_colors;
		global $disableFields;
		$s = '';
		$count++;
		// Current category clearance
		$i_default_clearance = $stack_clearances->getElementValueFromKey($item->getID());
		// Thig hidden but sets current category clearance identical 
		// to its parent's one, used to hide some checkboxes
		$i_current_clearance = ($i_default_clearance !== false) ? (int) $i_default_clearance : $parent_clearance ;
		if ($i_default_clearance !== false) {
			$bgColor = ' style="background-color:'.$clearance_colors[$i_default_clearance].';"';
		} elseif (!$i_default_clearance && $item->isRoot()) {
			$bgColor = ' style="background-color:'.$clearance_colors[CLEARANCE_MODULE_NONE].';"';
		} else {
			$bgColor = '';
		}
		$items_ids[]=$item->getID();
		if (is_a($item, 'CMS_moduleCategory')) {
			$hasSiblings = $item->hasSiblings();
		} else {
			$hasSiblings = CMS_tree::hasSiblings($item);
		}
		//Link to sub categories
		if ($hasSiblings) {
			if (($count < $maxDepth || isset($openedItems[$item->getID()])) && !isset($closedItems[$item->getID()])) {
				$thumbnail = '<a href="'.$_SERVER["SCRIPT_NAME"].'?close='.$item->getID().'" title="ID : '.$item->getID().'" class="admin"><b>-&nbsp;</b></a>';
			} else {
				$thumbnail = '<a href="'.$_SERVER["SCRIPT_NAME"].'?open='.$item->getID().'" title="ID : '.$item->getID().'" class="admin"><b>+&nbsp;</b></a>';
			}
		} else {
			$thumbnail = '';
		}
		$label = (is_a($item, 'CMS_moduleCategory')) ? $item->getLabel() : $item->getTitle();
		// Get title and form actions
		$s .= '
			<li'.$bgColor.' id="li'.$item->getID().'">
				<table border="0" cellpadding="0" cellspacing="0"'.$bgColor.' onMouseOver="onRow(this);" onMouseOut="outRow(this);">
					<tr>
						<td width="100%" class="admin">&nbsp;'.$thumbnail.'<span title="ID : '.$item->getID().'">'.$label.'</span></td>
						<td width="120" class="admin">
							<table width="120" border="0" cellpadding="0" cellspacing="0" id="checkboxes'.$item->getID().'">
								<tr>';
		$disabled = ($disableFields) ? ' disabled="disabled"':'';
		@reset($modules_clearances);
		while (list ($msg, $value) = @each($modules_clearances)) {
			$sel = '';
			if ($item->isRoot() || (!$item->isRoot() && $parent_clearance !== $value)) {
				// If none clearance defined yet, access is denied to any root category
				if ((!$i_default_clearance && $value === CLEARANCE_MODULE_NONE && $item->isRoot())
					|| ($i_default_clearance !== false && (int) $i_default_clearance === $value)) {
					$sel = ' checked="checked"';
				}
				$s .= '<td width="30" class="admin" align="center"><input type="checkbox" onclick="unselectOthers(\''.$item->getID().'\',\''.$value.'\', \''.$count.'\');" id="check'.$item->getID().'_'.$value.'" name="cat'.$item->getID().'" value="'.$value.'"'.$sel.$disabled.' /></td>';
			} else {
				$s .= '<td width="30" class="admin" align="center"><input type="checkbox" onclick="unselectOthers(\''.$item->getID().'\',\''.$value.'\', \''.$count.'\');" id="check'.$item->getID().'_'.$value.'" name="cat'.$item->getID().'" value="'.$value.'" style="display:none;"'.$disabled.' /></td>';
			}
		}
		$s .= '					</tr>
							</table>
						</td>
					</tr>
				</table>';
		
		// Print siblings tree recursivly
		if($hasSiblings) {
			if (($count < $maxDepth 
				|| isset($openedItems[$item->getID()]))
				&& !isset($closedItems[$item->getID()])) {
				//get siblings
				if (is_a($item, 'CMS_moduleCategory')) {
					$attrs = array(
						"module" => $cms_module_codename,
						"language" => $cms_language,
						"level" => $item->getID(),
						"root" => false,
						"attrs" => false,
						"cms_user" => &$cms_user
					);
					$siblings = CMS_module::getModuleCategories($attrs);
				} else {
					$siblings = CMS_tree::getSiblings($item);
				}
				// Prepare form actions here
				if (is_array($siblings) && $siblings) {
					$s .= '<ul id="ul'.$item->getID().'">';
					foreach ($siblings as $aSibling) {
						if (is_a($item, 'CMS_moduleCategory')) {
							$aSibling->setAttribute('language', $cms_language);
						}
						$s .= build_items_tree($aSibling, $count, $i_current_clearance);
					}
					$s .= '</ul>';
				}
			}
		}
		$s .= '</li>';
		return $s;
	}
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE_PROFILES);	// Profiles
$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)));

if (is_object($group)) {
	$profileLabel = $group->getLabel();
} elseif (is_object($user)) {
	$profileLabel = $user->getFirstName(). ($user->getFirstName() && $user->getLastName() ? ' ' : '') .$user->getLastName();
}
if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
	if (is_object($group)) {
		$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_CATEGORIES_GROUP_ACCESS, array($profileLabel));
	} elseif (is_object($user)) {
		$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_CATEGORIES_USER_ACCESS, array($profileLabel));
	}
} else {
	if (is_object($group)) {
		$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_PAGES_GROUP_ACCESS, array($profileLabel));
	} elseif (is_object($user)) {
		$title .= ' :: '.$cms_language->getMessage(MESSAGE_PAGE_TITLE_PAGES_USER_ACCESS, array($profileLabel));
	}
}
$dialog->setTitle($title, 'pic_comptes.gif');
$dialog->setBacklink($_SESSION["cms_context"]->getSessionVar("backlink"));//"modulecategories_usersgroups.php?module=".$cms_module_codename."&backlink=".$_REQUEST["backlink"]);
$dialog->addAjaxAPI();
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

// Base label
$current_item_label = '<a href="'.$_SERVER["SCRIPT_NAME"].'?item=root" class="admin">'.($cms_module->getCodename() != MOD_STANDARD_CODENAME ? $cms_language->getMessage(MESSAGE_PAGE_CATEGORIES_ROOT) : $cms_language->getMessage(MESSAGE_PAGE_PAGES_ROOT)).'</a>';
// Label
if ($_SESSION["cms_context"]->getSessionVar("current_item") > 0) {
	if (is_a($current_item, 'CMS_moduleCategory')) {
		$current_item->setAttribute('language', $cms_language);
		$label = $current_item->getLabel();
		foreach ($current_item->getLineage() as $anAncestor) {
			$anAncestor->setAttribute('language', $cms_language);
			$current_item_label .= ' :: <a href="'.$_SERVER["SCRIPT_NAME"].'?item='.$anAncestor->getID().'" class="admin">'.$anAncestor->getLabel().'</a>';
		}
	} elseif (is_a($current_item, 'CMS_page')) {
		$label = $current_item->getTitle();
		$lineage = CMS_tree::getLineage(CMS_tree::getRoot(), $current_item);
		foreach ($lineage as $anAncestor) {
			$current_item_label .= ' :: <a href="'.$_SERVER["SCRIPT_NAME"].'?item='.$anAncestor->getID().'" class="admin">'.$anAncestor->getTitle().'</a>';
		}
	}
}

// Get root
if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
	$categories_search_attrs = array(
		"module" => $cms_module_codename,
		"language" => $cms_language,
		"level" => 0,
		"root" => 0,
		"attrs" => false,
		"cms_user" => &$cms_user
	);
	$root_items = $cms_module->getModuleCategories($categories_search_attrs);
} else {
	$root_items = array(CMS_tree::getRoot());
}
$modules = CMS_modulesCatalog::getAll();

$content .= '
	<div style="width:95%;">
		<form method="" action="'.$_SERVER['SCRIPT_NAME'].'">
		<!-- module -->
		'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_MODULE).' : 
		<select name="module" class="admin_input_text" onchange="submit();">';
			foreach ($modules as $module) {
				if ($module->useCategories() || $module->getCodename() == MOD_STANDARD_CODENAME) {
					$selected = ($cms_module_codename == $module->getCodename()) ? ' selected="selected"':'';
					$content .= '<option value="'.$module->getCodename().'"'.$selected.'>'.$module->getLabel($cms_language).'</option>';
				}
			}
			$content .= '
		</select> - ';
		if (is_object($group)) {
			$profilesLabels = CMS_profile_usersGroupsCatalog::getGroupsLabels();
			$content .= '
			<!-- groups -->
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUP).' : 
			<select name="group" class="admin_input_text" onchange="submit();">';
				foreach ($profilesLabels as $profileId => $label) {
					$selected = ($group->getGroupId() == $profileId) ? ' selected="selected"':'';
					$content .= '<option value="'.$profileId.'"'.$selected.'>'.$label.'</option>';
				}
				$content .= '
			</select>';
		} elseif (is_object($user)) {
			$profilesLabels = CMS_profile_usersCatalog::getUsersLabels();
			$content .= '
			<!-- users -->
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_USER).' : 
			<select name="user" class="admin_input_text" onchange="submit();">';
				foreach ($profilesLabels as $profileId => $label) {
					$selected = ($user->getUserId() == $profileId) ? ' selected="selected"':'';
					$content .= '<option value="'.$profileId.'"'.$selected.'>'.$label.'</option>';
				}
				$content .= '
			</select>';
		}
		$content .= '
		</form>
		<!-- depth -->
		<div align="right">
		<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
			'.$cms_language->getMessage(MESSAGE_PAGE_DISPLAYED_DEPTH).' : 
			<input type="hidden" name="cms_action" value="maxDepth" />
			<input type="text" name="maxDepth" value="'.$maxDepth.'" class="admin_input_text" size="2" />
			<input type="submit" name="validate" value="OK" class="admin_input_submit" />
		</form>
		</div>';
		if ($disableFields) {
			$content .= '<br />
			<div class="admin_text_alert">'.$cms_language->getMessage(MESSAGE_PAGE_USER_BELONGS_TO_GROUPS).'</div><br />';
		}
		$content .= '
		<dialog-title type="admin_h2">'.$current_item_label.'</dialog-title>
	</div>'; 

//
// Category tree
//
if (!$root_items || !sizeof($root_items)) {
	$content .= "<br />".$cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
} else {
	$content .= '
	<div style="width:95%;">
	<script type="text/javascript" language="javascript">
	'."
	<!--
	function onRow(obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '".$bg_color_selected."';
		}
	}
	function outRow(obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '';
		}
	}
	function unselectOthers(catID,catValue, count) {
		var clearances = [".implode(',',$modules_clearances)."];
		var clearancesColors = ['".implode('\',\'',$clearance_colors)."'];
		var parentClearance;
		//get parent clearance (from the disabled checkbox of this category)
		for (var i = 0; i < clearances.length; i++) {
			if (clearances[i] != catValue && document.getElementById('check' + catID + '_' + clearances[i]).style.display == 'none') {
				parentClearance = clearances[i];
			}
		}
		//set li color and disable other checkbox of the line (if any)
		if (getE('check' + catID + '_' + catValue).checked == true) {
			//unselect others from the same line
			for (var i=0; i < clearances.length; i++) {
				if (catValue != clearances[i]) {
					if (getE('check' + catID + '_' + clearances[i])) {
						getE('check' + catID + '_' + clearances[i]).checked = false;
					}
				}
			}
			//set color
			getE('li' + catID).style.backgroundColor=clearancesColors[catValue];
		} else {
			//set color
			if (count == 1) {
				getE('li' + catID).style.backgroundColor=clearancesColors[0];
			} else {
				getE('li' + catID).style.backgroundColor='';
			}
		}
		//then allow or disallow checkboxes below the checked one
		if (getE('ul' + catID)) {
			var checkbox = getE('check' + catID + '_' + catValue);
			var inputsToHide = new Array();
			var inputsToShow = new Array();
			var resetBackground = new Array();
			var stop = false;
			//for this UL, get all Li directly below then mark inputs to display or hide
			getInputs(getE('ul' + catID));
			//pr('parent : '+parentClearance+', hide : '+inputsToHide.length+', show : '+inputsToShow.length);
			for (var i = 0; i < inputsToHide.length; i++) {
				//if li is already checked, we must reset background
				if (inputsToHide[i].checked) {
					getE('li' + inputsToHide[i].name.substr(3)).style.backgroundColor='';
				}
				inputsToHide[i].checked = false;
				inputsToHide[i].style.display = 'none';
			}
			for (var i = 0; i < inputsToShow.length; i++) {
				inputsToShow[i].checked = false;
				inputsToShow[i].style.display = 'block';
			}
		}
		//force clearance 'none' checking
		if (count == 1 && getE('check' + catID + '_' + catValue).checked == false) {
			getE('check' + catID + '_' + 0).checked = true;
			unselectOthers(catID,0, 1);
		} else {
			saveValues();
		}
		
		//for a given UL, get all Li then mark inputs to display or hide. This function use reference vars
		function getInputs(el) {
			var childs = el.childNodes;
			var inputs = new Array();
			//get all checkboxes for Lis of this UL
			for (var i = 0; i < childs.length; i++) {
				if (childs[i].tagName == 'LI') {
					var checked = false;
					var liInputs = getE('checkboxes' + childs[i].id.substring(2)).getElementsByTagName('INPUT');
					for (var j = 0; j < liInputs.length; j++) {
						inputs[inputs.length] = liInputs[j];
						if (liInputs[j].checked) {
							checked = true;
						}
					}
					if (!checked && getE('ul' + childs[i].id.substring(2))) {
						getInputs(getE('ul' + childs[i].id.substring(2)));
					}
				}
			}
			for (var i = 0; i < inputs.length; i++) {
				if (inputs[i].value == catValue) {
					if (checkbox.checked == true) {
						inputsToHide[inputsToHide.length] = inputs[i];
					} else {
						inputsToShow[inputsToShow.length] = inputs[i];
					}
				} else if (inputs[i].style.display == 'none') {
					inputsToShow[inputsToShow.length] = inputs[i];
				} else if (checkbox.checked == false && inputs[i].value == parentClearance) {
					inputsToHide[inputsToHide.length] = inputs[i];
				}
			}
		}
	}
	function saveValues() {
		//get all checked inputs
		var inputs = getE('categoriesList').getElementsByTagName('INPUT');
		var rights = '';
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].type == 'checkbox' && inputs[i].checked) {
				rights += (rights) ? ';':'';
				rights += inputs[i].name.substr(3) + ',' + inputs[i].value;
			}
		}
		sendServerCall('".PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR."?cms_action=setClearance&mod=".$cms_module_codename.(is_object($group) ? "&group=".$group->getGroupId() : "&user=".$user->getUserId())."&rights=' + rights + '&ids=' + getE('catIds').value, null, true);
	}
	".'
	//-->
	</script>
	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-bottom:2px;">
		<tr>
			<th width="100%" class="admin" style="text-align:left;padding-left:10px;">
				'.($cms_module->getCodename() != MOD_STANDARD_CODENAME ? $cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY) : $cms_language->getMessage(MESSAGE_PAGE_FIELD_PAGES)).'</th>
			<th width="120" class="admin" align="right">
				<table width="120" border="0" cellpadding="2" cellspacing="0">
					<tr>';
	reset($modules_clearances);
	$pictos = array(
		CLEARANCE_MODULE_NONE => 'right-none.gif',
		CLEARANCE_MODULE_VIEW => 'right-view.gif',
		CLEARANCE_MODULE_EDIT => 'right-edit.gif',
		CLEARANCE_MODULE_MANAGE => 'right-manage.gif',
	);
	while (list($msg, $v) = each($modules_clearances)) {
		$content .= '<th width="30" align="center" class="admin"><img src="'.PATH_ADMIN_IMAGES_WR.'/'.$pictos[$v].'" alt="'.htmlspecialchars($cms_language->getMessage($msg)).'" title="'.htmlspecialchars($cms_language->getMessage($msg)).'" /></th>';
	}
	$content .= '
				</tr>
			</table></th>
		</tr>
	</table>
	<ul class="categoriesList" id="categoriesList">';
	$items_ids = array();
	foreach ($root_items as $aRoot) {
		// Current category clearance
		$i_current_clearance = (int) $stack_clearances->getElementValueFromKey($aRoot->getID());
		// Show all sub categories
		$content .= build_items_tree($aRoot, 0, $i_current_clearance);
	}
	$content .= '
	</ul>
	<input type="hidden" name="catIds" id="catIds" value="'.implode(',',$items_ids).'" />
	</div>';
}
$dialog->setContent($content);
$dialog->show();
?>