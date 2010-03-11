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
// $Id: modulecategories.php,v 1.3 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : Presents list of module categories for given module
  * Add/Delete/Update categories
  *
  * @package CMS
  * @subpackage admin
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_ADD", 260);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_TITLE", 1206);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 1207);
define("MESSAGE_PAGE_CATEGORIES_ROOT", 1208);
define("MESSAGE_PAGE_DISPLAYED_DEPTH", 1339);

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

// Get current root category under navigation
if (isset($_GET["ctg"])) {
	$_SESSION["cms_context"]->setSessionVar("items_current_category", (int) $_GET["ctg"]);
}
// Current category which will be deployed
if ($_SESSION["cms_context"]->getSessionVar("items_current_category")) {
	$current_category = CMS_moduleCategories_catalog::getByID($_SESSION["cms_context"]->getSessionVar("items_current_category"));
}

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($_POST["cms_action"]) {
case "delete":
	$item = new CMS_moduleCategory($_POST["item"]);
	if (CMS_moduleCategories_catalog::detachCategory($item)) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
case "move_up":
	$item = CMS_moduleCategories_catalog::getByID($_POST["item"]);
	if (!$item->hasError()) {
		if (CMS_moduleCategories_catalog::moveCategoryOrder($item, -1)) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
		}
	}
	break;
case "move_down":
	$item = CMS_moduleCategories_catalog::getByID($_POST["item"]);
	if (!$item->hasError()) {
		if (CMS_moduleCategories_catalog::moveCategoryOrder($item, 1)) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
		}
	}
	break;
case 'maxDepth':
		if (sensitiveIO::isPositiveInteger($_POST['maxDepth'])) {
			$_SESSION["cms_context"]->setSessionVar("modules_categories_max_depth", $_POST['maxDepth']);
		}
	break;
}

// Limit recurse process to n iterations
if (!sensitiveIO::isPositiveInteger($_SESSION["cms_context"]->getSessionVar("modules_categories_max_depth"))) {
	$_SESSION["cms_context"]->setSessionVar("modules_categories_max_depth", 2);
}
$GLOBALS["max_depth"] = $_SESSION["cms_context"]->getSessionVar("modules_categories_max_depth");

// +----------------------------------------------------------------------+
// | Functions                                                            |
// +----------------------------------------------------------------------+

if (!function_exists("build_category_tree")) {
	/** 
	  * Recursive function to build the categories tree.
	  *
	  * @param CMS_moduleCategory $category
	  * @param integer $count, to determine category in-tree depth
	  * @return string HTML formated
	  */
	function build_category_tree(&$category, $count) {
		
		global $cms_module_codename, $cms_language, $cms_module, $cms_user;
		global $current_category;
		
		$s = '';
		
		$count++;
		
		$attrs = array(
			"module" => $cms_module_codename,
			"language" => &$cms_language,
			"level" => $category->getID(),
			"root" => false,
			"attrs" => false,
			"cms_user" => &$cms_user
		);
		$siblings = CMS_module::getModuleCategories($attrs);
		
		// Each category item belongs to appears on green
		// otherwise bg color depends on category depth in tree
		$bg_color = '#f'.$count.'f'.$count.'f'.$count;
		
		// Thumbnail and Link to sub categories
		if ($category->getIconPath(false, PATH_RELATIVETO_WEBROOT, true)) {
			$thumbnail = '<a href="'.$_SERVER["SCRIPT_NAME"].'?ctg='.$category->getID().'" title="ID : '.$category->getId().'" class="admin"><img src="'.$category->getIconPath(true).'" height="20" border="O" align="absmiddle" /></a>';
		} else if ($category->hasSiblings()) {
			$thumbnail = '<a href="'.$_SERVER["SCRIPT_NAME"].'?ctg='.$category->getID().'" title="ID : '.$category->getId().'" class="admin"><b>&nbsp;+</b></a>';
		} else {
			$thumbnail = '';
		}
		
		// Get title and form actions
		$s .= '
			<table border="0" cellpadding="2" cellspacing="0" style="background-color:'.$bg_color.';" onMouseOver="onRow(this);" onMouseOut="outRow(this, \''.$bg_color.'\');" onClick="clickRow(this, \''.$bg_color.'\');">
			<tr>
				<td width="100%" class="admin">
					'.$thumbnail.'&nbsp;<b><span title="ID: '.$category->getID().'">'.$category->getLabel().'</span></b>
					<br /><i><small>'.$category->getDescription().'</small></i>
					</td>
				<td width="220" class="admin" align="right">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>';
		if ($cms_user->hasModuleCategoryClearance($category->getID(), CLEARANCE_MODULE_MANAGE)) {
			// Delete & Edit
			if (!$category->hasSiblings()) {
				if (!$cms_module->isCategoryUsed($category)) {
					$s .= '
							<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array(htmlspecialchars($category->getLabel())))) . ' ?\')">
							<input type="hidden" name="cms_action" value="delete" />
							<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
							<input type="hidden" name="module" value="'.$cms_module_codename.'" />
							<input type="hidden" name="item" value="'.$category->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_admin_lightgreybg" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
							</form>';
				}
			}
			$s .= '
							<form action="modulecategory.php" method="post">
							<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
							<input type="hidden" name="module" value="'.$cms_module_codename.'" />
							<input type="hidden" name="item" value="'.$category->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_admin_lightgreybg" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
							</form>';
			if ($cms_user->hasModuleCategoryClearance($category->getAttribute('parentID'), CLEARANCE_MODULE_MANAGE)) {
				// Move up / down
				if ($category->getAttribute('order') > 1) {
					$s .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
								<input type="hidden" name="cms_action" value="move_up" />
								<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
								<input type="hidden" name="module" value="'.$cms_module_codename.'" />
								<input type="hidden" name="item" value="'.$category->getID().'" />
									<td valign="top" class="admin"><input style="padding: 3px" type="image" class="admin_input_image" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fleche_haut.gif" /></td>
								</form>';
				} else {
					$s .= '
									<td class="admin"><img style="padding: 3px" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="10" height="1" alt="" border="0" /></td>';
				}
				if ($category->getAttribute('order') < CMS_moduleCategories_catalog::getLastSiblingOrder($category->getAttribute('parentID'))) {
					$s .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
								<input type="hidden" name="cms_action" value="move_down" />
								<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
								<input type="hidden" name="module" value="'.$cms_module_codename.'" />
								<input type="hidden" name="item" value="'.$category->getID().'" />
									<td class="admin"><input type="image" style="padding: 3px" class="admin_input_image" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fleche_bas.gif" /></td>
								</form>';
				} else {
					$s .= '
									<td class="admin"><img style="padding: 3px" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="11" height="1" alt="" border="0" /></td>';
				}
			}
		}
		$s .= '
					   </tr>
					</table></td>
				</tr>';
		$s .= '
			</table>';
		
		// Print recursivly siblings tree
		if ($count < $GLOBALS["max_depth"] 
				|| ( !$GLOBALS["undeploy"]
					&&  (is_object($current_category) && $current_category->hasAncestor($category->getID())
						|| is_object($current_category) && $category->getID() == $current_category->getID()) ) ) {
			if ($category->getID() == $_SESSION["cms_context"]->getSessionVar("items_current_category")) {
				$GLOBALS["undeploy"] = true;
			}
			if (sizeof($siblings)) {
				// Prepare form actions here
				$s .= '
				<ul style="list-style:url(\''.PATH_ADMIN_IMAGES_WR.'/../v3/img/pic_ctg_nochild.gif\');">';
				foreach ($siblings as $aSibling) {
					$aSibling->setAttribute('language', $cms_language);
					$s .= '
						<li class="admin_h3" style="margin-top:5px;">
						'.build_category_tree($aSibling, $count).'
						</li>';
				}
				$s .= '
				</ul>'."\n";
			}
		}
		return $s;
	}
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, false));
if (isset($_REQUEST["backlink"])) {
	$dialog->setBacklink($_REQUEST["backlink"]);
} else {
	$dialog->setBacklink($cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT));
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//
// Getting root categories
//

// Base label
// FIXME : Messages à traduire : Root
$current_category_label = '<a href="'.$_SERVER["SCRIPT_NAME"].'?module='.$cms_module->getCodename().'&ctg=root" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_CATEGORIES_ROOT).'</a>';

if ($_SESSION["cms_context"]->getSessionVar("items_current_category") > 0) {
	// Label
	$current_category = CMS_moduleCategories_catalog::getByID($_SESSION["cms_context"]->getSessionVar("items_current_category"));
	$current_category->setAttribute('language', $cms_language);
	foreach ($current_category->getLineage() as $aCat) {
		$aCat->setAttribute('language', $cms_language);
		$current_category_label .= ' :: <a href="'.$_SERVER["SCRIPT_NAME"].'?module='.$cms_module->getCodename().'&ctg='.$aCat->getID().'" class="admin">'.$aCat->getLabel().'</a>';
	}
}
// Get root categories
$categories_search_attrs = array(
	"module" => $cms_module_codename,
	"language" => &$cms_language,
	"level" => 0,
	"root" => 0,
	"attrs" => false,
	"cms_user" => &$cms_user
);
$root_categories = CMS_module::getModuleCategories($categories_search_attrs);

$content .= '
	<div style="width:700px;">
		<div align="right">
		<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
			'.$cms_language->getMessage(MESSAGE_PAGE_DISPLAYED_DEPTH).' : 
			<input type="hidden" name="cms_action" value="maxDepth" />
			<input type="text" name="maxDepth" value="'.$GLOBALS["max_depth"].'" class="admin_input_text" size="2" />
			<input type="submit" name="validate" value="OK" class="admin_input_submit" />
		</form>
		</div>
		<!-- title -->
		<dialog-title type="admin_h2">'.$current_category_label.'</dialog-title>
		<!-- Add a category -->
		<div align="right" style="margin-top:10px;">
			<a name="new"></a>
			<form action="modulecategory.php" method="post">
			<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
			<input type="hidden" name="parentID" value="'.$_SESSION["cms_context"]->getSessionVar("items_current_category").'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_ADD).'" />
			</form>
		</div>
	</div>'; 

//
// Category tree
//
if (!$root_categories || !sizeof($root_categories)) {
	$content .= "<br />".$cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
} else {
	
	$content .= '
	<div style="width:700px;">
	
	<script type="text/javascript" language="javascript">
	'."
	<!--
	function onRow(obj) {
		if (obj != 'undefined') {
			if (obj.style.backgroundColor.toString() != 'rgb(253, 245, 162)'
					&& obj.style.backgroundColor.toString() != '#fdf5a2') {
				obj.style.backgroundColor = '#e2faaa';
			}
		}
	}
	function outRow(obj, color) {
		if (obj != 'undefined') {
			if (obj.style.backgroundColor.toString() != 'rgb(253, 245, 162)'
					&& obj.style.backgroundColor.toString() != '#fdf5a2') {
				obj.style.backgroundColor = color;
			}
		}
	}
	function clickRow(obj, color) {
		if (obj != 'undefined') {
			if (obj.style.backgroundColor.toString() == 'rgb(253, 245, 162)'
					|| obj.style.backgroundColor.toString() == '#fdf5a2') {
				obj.style.backgroundColor = color;
			} else {
				obj.style.backgroundColor = '#fdf5a2';
			}
		}
	}
	".'
	//-->
	</script>
	
	<ul style="list-style-type:none;padding-left:0px;">';
	
	$maxCount = 0;
	foreach ($root_categories as $aRoot) {
		// Table header
		$table_header = '';
		if (!$table_header_done) {
			$table_header = '
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th width="100%" class="admin" style="text-align:left;padding-left:10px;">
						'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY).'</th>
					<th width="220" class="admin" style="text-align:center;">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
				</tr>
				</table>';
			$table_header_done = true;
		}
		// Show all sub categories
		$content .= '
			<li class="admin_h2" style="margin-top:5px;">
				'.$table_header.'
				'.build_category_tree($aRoot,0).'
			</li>';
	}
	
	$content .= '
	</ul>
	
	<!-- Add a category -->
	<div align="right" style="margin-top:10px;">
	<a name="new"></a>
	<form action="modulecategory.php" method="post">
	<input type="hidden" name="backlink" value="'.$_REQUEST["backlink"].'" />
	<input type="hidden" name="parentID" value="'.$_SESSION["cms_context"]->getSessionVar("items_current_category").'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_ADD).'" />
	</form>
	</div>
	
	</div>';
}


$dialog->setContent($content);
$dialog->show();

?>