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
// $Id: modules-categories-rights.php,v 1.6 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load modules categories rights interface
  * Used accross an Ajax request. Render categories list
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_FIELD_PAGES", 213);
define("MESSAGE_PAGE_DEPTH", 1339);
define("MESSAGE_PAGE_LEVELS", 498);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

$userId = (int) sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
$groupId = (int) sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');
$moduleCodename = sensitiveIO::request('module', '', MOD_STANDARD_CODENAME);
$maxDepth = sensitiveIO::request('maxDepth', 'sensitiveIO::isPositiveInteger');
$item = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');

//load profile if any
$isUser = false;
if ($userId) {
	$profile = CMS_profile_usersCatalog::getByID($userId);
	$isUser = true;
	$userId = $profile->getUserId();
} elseif($groupId) {
	$profile = CMS_profile_usersGroupsCatalog::getByID($groupId);
	$groupId = $profile->getGroupId();
}
$profileId = $profile->getId();
if (!isset($profile) || $profile->hasError()) {
	CMS_grandFather::raiseError('Unknown profile for given Id : '.$profileId);
	$view->show();
}

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

//Set max depth (iterations count)
if ($maxDepth) {
	CMS_session::setSessionVar("modules_clearances_max_depth", $maxDepth);
}
if (!sensitiveIO::isPositiveInteger(CMS_session::getSessionVar("modules_clearances_max_depth"))) {
	CMS_session::setSessionVar("modules_clearances_max_depth", 3);
}
$maxDepth = CMS_session::getSessionVar("modules_clearances_max_depth");

// Colors used to visualize access level
$clearance_colors = array (
	CLEARANCE_MODULE_NONE 	=> '#FF7E71',
	CLEARANCE_MODULE_VIEW 	=> '#e2faaa',
	CLEARANCE_MODULE_EDIT 	=> '#CFE779',
	CLEARANCE_MODULE_MANAGE => '#85A122',
);
$bg_color_selected = "#fdf5a2";

//if user belongs to groups, all fields are disabled
$disableFields = ($profile->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL) || ($isUser && sizeof(CMS_profile_usersGroupsCatalog::getGroupsOfUser($profile, true)))) ? true : false;

//unique hash relative to user module
$hash = md5($moduleCodename.'-'.$profileId);

/**
  * Module Elements rights
  * (This is recycled code from the V3)
  */
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
		global $moduleCodename, $cms_language, $cms_user, $profileId, $hash; //current user environment
		global $items_ids; //reference to all displayed items
		global $modules_clearances, $stack_clearances; //all clearances types available
		global $maxDepth, $clearance_colors; //displaying options
		global $disableFields; //disable status
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
			if ($count < $maxDepth) {
				$thumbnail = '';
			} else {
				$thumbnail = '<a href="#" onclick="Automne.categories.open('.$item->getID().', \''.$hash.'\', this);return false;" title="ID : '.$item->getID().'">+</a>';
			}
		} else {
			$thumbnail = '';
		}
		//disabled checkboxes if needed
		if ($disableFields) {
			$disabled = ' disabled="disabled"';
		} else {
			//check if user has edition rights on item
			if (is_a($item, 'CMS_moduleCategory')) {
				$disabled = $cms_user->hasModuleCategoryClearance($item->getID(), CLEARANCE_MODULE_MANAGE) ? '' : ' disabled="disabled"';
			} else {
				$disabled = $cms_user->hasPageClearance($item->getId(), CLEARANCE_PAGE_EDIT) ? '' : ' disabled="disabled"';
			}
		}
		
		$label = (is_a($item, 'CMS_moduleCategory')) ? $item->getLabel() : $item->getTitle();
		$label = $disabled ? '<span style="color:grey;">'.$label.'</span>' : $label;
		
		// Get title and form actions
		$s .= '
			<li'.$bgColor.' id="li-'.$hash.'-'.$item->getID().'">
				<table border="0" cellpadding="0" cellspacing="0"'.$bgColor.' onMouseOver="Automne.categories.onRow(this);" onMouseOut="Automne.categories.outRow(this);">
					<tr>
						<td width="100%">&nbsp;'.$thumbnail.'<span title="ID : '.$item->getID().'">'.$label.'</span></td>
						<td width="120">
							<table width="120" border="0" cellpadding="0" cellspacing="0" id="checkboxes-'.$hash.'-'.$item->getID().'">
								<tr>';
		@reset($modules_clearances);
		while (list ($msg, $value) = @each($modules_clearances)) {
			$sel = '';
			//check if user has edition rights on item
			if ($disableFields) {
				$disabled = ' disabled="disabled"';
			} else {
				if (is_a($item, 'CMS_moduleCategory')) {
					$disabled = $cms_user->hasModuleCategoryClearance($item->getID(), CLEARANCE_MODULE_MANAGE) ? '' : ' disabled="disabled"';
				} else {
					$disabled = $cms_user->hasPageClearance($item->getId(), CLEARANCE_PAGE_EDIT) ? '' : ' disabled="disabled"';
				}
			}
			if ($item->isRoot() || (!$item->isRoot() && $parent_clearance !== $value)) {
				// If none clearance defined yet, access is denied to any root category
				if ((!$i_default_clearance && $value === CLEARANCE_MODULE_NONE && $item->isRoot())
					|| ($i_default_clearance !== false && (int) $i_default_clearance === $value)) {
					$sel = ' checked="checked"';
				}
				$s .= '<td width="30" align="center"><input type="checkbox"'.$disabled.' onclick="Automne.categories.unselectOthers(\''.$item->getID().'\',\''.$value.'\', \''.$count.'\', \''.$hash.'\');" id="check-'.$hash.'-'.$item->getID().'_'.$value.'" name="cat'.$item->getID().'" value="'.$value.'"'.$sel.$disabled.' /></td>';
			} else {
				$s .= '<td width="30" align="center"><input type="checkbox"'.$disabled.' onclick="Automne.categories.unselectOthers(\''.$item->getID().'\',\''.$value.'\', \''.$count.'\', \''.$hash.'\');" id="check-'.$hash.'-'.$item->getID().'_'.$value.'" name="cat'.$item->getID().'" value="'.$value.'" style="display:none;"'.$disabled.' /></td>';
			}
		}
		$s .= '					</tr>
							</table>
						</td>
					</tr>
				</table>';
		// Print siblings tree recursivly
		if($hasSiblings) {
			if ($count < $maxDepth) {
				//get siblings
				if (is_a($item, 'CMS_moduleCategory')) {
					$attrs = array(
						"module" => $moduleCodename,
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
					$s .= '<ul id="ul-'.$hash.'-'.$item->getID().'">';
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
// Current usersgroup clearances
if ($moduleCodename != MOD_STANDARD_CODENAME) {
	$stack_clearances = $profile->getModuleCategoriesClearancesStack();
	$modules_clearances = CMS_Profile::getAllModuleCategoriesClearances();
} else {
	$stack_clearances = $profile->getPageClearances();
	$modules_clearances = CMS_Profile::getAllPageClearances();
}
if (!$item) {
	// Get root
	if ($moduleCodename != MOD_STANDARD_CODENAME) {
		$categories_search_attrs = array(
			"module" => $moduleCodename,
			"language" => $cms_language,
			"level" => 0,
			"root" => 0,
			"attrs" => false,
			"cms_user" => &$cms_user
		);
		$root_items = CMS_module::getModuleCategories($categories_search_attrs);
	} else {
		$root_items = array(CMS_tree::getRoot());
	}
	
	$content = '';
	if (!$root_items || !sizeof($root_items)) {
		$content .= "<br />".$cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
	} else {
		$content .= '
		<div style="width:100%;" id="cats-'.$hash.'">
			<table border="0" cellpadding="2" cellspacing="0" style="margin-bottom:2px;">
				<tr>
					<th width="100%" style="text-align:left;"><label for="maxDepth-'.$moduleCodename.'-'.$profileId.'">'.$cms_language->getMessage(MESSAGE_PAGE_DEPTH).' : </label><input id="maxDepth-'.$moduleCodename.'-'.$profileId.'" type="text" style="width:18px;" name="" value="'.$maxDepth.'" />&nbsp; '.$cms_language->getMessage(MESSAGE_PAGE_LEVELS).'</th>
					<th width="120" align="right">
						<table width="120" border="0" cellpadding="2" cellspacing="0">
							<tr>';
			reset($modules_clearances);
			$pictos = array(
				CLEARANCE_MODULE_NONE => 'right-none',
				CLEARANCE_MODULE_VIEW => 'right-view',
				CLEARANCE_MODULE_EDIT => 'right-edit',
				CLEARANCE_MODULE_MANAGE => 'right-manage',
			);
			while (list($msg, $v) = each($modules_clearances)) {
				$content .= '<th width="30" align="center"><div class="'.$pictos[$v].'" title="'.io::htmlspecialchars($cms_language->getMessage($msg)).'"></div></th>';
			}
			$content .= '
						</tr>
					</table></th>
				</tr>
			</table>
			<ul class="categoriesList" id="categoriesList-'.$hash.'">';
			$items_ids = array();
			foreach ($root_items as $aRoot) {
				// Current category clearance
				$i_current_clearance = (int) $stack_clearances->getElementValueFromKey($aRoot->getID());
				// Show all sub categories
				$content .= build_items_tree($aRoot, 0, $i_current_clearance);
			}
			$content .= '
			</ul>
			<input type="hidden" id="type-'.$hash.'" value="'.($isUser ? 'user' : 'group').'" />
			<input type="hidden" id="catIds-'.$hash.'" value="'.implode(',',$items_ids).'" />
			<input type="hidden" id="profile-'.$hash.'" value="'.($isUser ? $userId : $groupId).'" />
			<input type="hidden" id="module-'.$hash.'" value="'.$moduleCodename.'" />
		</div>';
	}
} else {
	//get siblings
	if ($moduleCodename != MOD_STANDARD_CODENAME) {
		$item = CMS_moduleCategories_catalog::getByID($item);
		$attrs = array(
			"module" => $moduleCodename,
			"language" => $cms_language,
			"level" => $item->getID(),
			"root" => false,
			"attrs" => false,
			"cms_user" => &$cms_user
		);
		$siblings = CMS_module::getModuleCategories($attrs);
	} else {
		$item = CMS_tree::getPageByID($item);
		$siblings = CMS_tree::getSiblings($item);
	}
	$clearances = array_reverse($modules_clearances, true);
	// Current item clearance
	$i_current_clearance = false;
	foreach ($clearances as $clearance) {
		if ($i_current_clearance === false) {
			if ($moduleCodename != MOD_STANDARD_CODENAME) {
				if ($profile->hasModuleCategoryClearance($item->getID(), $clearance, $moduleCodename)) $i_current_clearance = $clearance;
			} else {
				if ($profile->hasPageClearance($item->getID(), $clearance)) $i_current_clearance = $clearance;
			}
		}
	}
	if ($i_current_clearance === false) $i_current_clearance = CLEARANCE_MODULE_NONE;
	// Prepare form actions here
	$content = '';
	if (is_array($siblings) && $siblings) {
		$content .= '<ul id="ul-'.$hash.'-'.$item->getID().'">';
		foreach ($siblings as $aSibling) {
			if ($moduleCodename != MOD_STANDARD_CODENAME) {
				$aSibling->setAttribute('language', $cms_language);
			}
			$content .= build_items_tree($aSibling, 0, $i_current_clearance);
		}
		$content .= '</ul>';
	}
	//append newly displayed categories IDS to existing ones
	$jscontent = 'Ext.get(\'catIds-'.$hash.'\').dom.value += \','.implode(',', $items_ids).'\';';
	$view->addJavascript($jscontent);
}
$view->setContent($content);
$view->show();
?>