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
// $Id: index.php,v 1.5 2010/03/08 16:42:06 sebastien Exp $

/**
  * PHP page : module admin frontend : cms_aliases : index
  * Presents the module cms_aliases
  *
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 249);
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_ACTION_VIEW", 1006);
define("MESSAGE_PAGE_UNKNOWN_PAGE", 66);

//module specific
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_NAME", 2);
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_TARGET", 3);
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_SUB_CMS_ALIASES", 4);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 5);
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_PARENT", 6);
define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 9);

//CHECKS
if (!$cms_user->hasModuleClearance(MOD_CMS_ALIAS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "delete":
	//delete alias
	$article = new CMS_resource_cms_aliases($_POST["article"]);
	if ($article->destroy()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR,false,MOD_CMS_ALIAS_CODENAME);
	}
	break;
}

$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_ALIAS_CODENAME);

//get aliases for this level
$cms_parent = ($_GET["parent"].$_POST["parent"]) ? new CMS_resource_cms_aliases($_GET["parent"].$_POST["parent"]):false;
$cms_parentID = ($_GET["parent"]) ? $cms_parent->getID():0;
$aliases = CMS_resource_cms_aliases::getAll($cms_parent,true);

//render initialisation
$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($cms_parent) {
	$dialog->setBacklink($cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT)."?parent=".$cms_parent->getParent());
	$parents = $cms_parent->getAliasLineAge(true);
	$parentLineAge='';
	if (sizeof($parents)) {
		foreach ($parents as $aParent) {
			$parentLineAge .='<a href="'.$_SERVER["SCRIPT_NAME"].'?parent='.$aParent->getID().'" class="admin">'.$aParent->getAlias().'</a>/';
		}
	}
	$parentLineAge .=$cms_parent->getAlias().'/';
	$lineAge = $cms_parent->getAliasLineAge().$cms_parent->getAlias().'/';
} else {
	$parentLineAge = $lineAge = '';
}
$content .=$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_PARENT,false,MOD_CMS_ALIAS_CODENAME).' : /'.$parentLineAge.'<br />';

$content .= '
	<form action="alias.php" method="post">
	<input type="hidden" name="parent" value="'.$cms_parentID.'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form>
';
if (sizeof($aliases)) {
	$content .= '
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_NAME,false,MOD_CMS_ALIAS_CODENAME).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_TARGET,false,MOD_CMS_ALIAS_CODENAME).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_SUB_CMS_ALIASES,false,MOD_CMS_ALIAS_CODENAME).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
		</tr>
	';
	
	$count = 0;
	foreach ($aliases as $article) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		
		if ($article->getPageID()) {
			$page = new CMS_page($article->getPageID());
			if ($page->getTitle()) {
				$target = '<a href="#" onclick="Automne.utils.getPageById('.$page->getID().');Ext.WindowMgr.getActive().close();" class="admin">Page : '.$page->getTitle().' ('.$page->getID().')</a>';
			} else {
				$target = '<a href="#" onclick="Automne.utils.getPageById('.$page->getID().');Ext.WindowMgr.getActive().close();" class="admin">Page : <span class="admin_text_alert">'.$cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_PAGE).' ('.$page->getID().')</span></a>';
			}
		} else {
			$target = '<a href="'.$article->getURL().'" class="admin" target="_blank">URL : '.$article->getURL().'</a>';
		}
		
		$content .= '
			<tr>
				<td class="'.$td_class.'"><a href="/'.$lineAge.$article->getAlias().'/" class="admin" target="_blank">'.$lineAge.$article->getAlias().'/</a></td>
				<td class="'.$td_class.'">'.$target.'</td>
				<td class="'.$td_class.'">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<form action="alias.php" method="post">
						<input type="hidden" name="parent" value="'.$article->getID().'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" /></td>
						</form>';
				if ($article->hasSubAliases()) {
					$content .= '
						<form action="'.$_SERVER["SCRIPT_NAME"].'" method="get">
						<input type="hidden" name="parent" value="'.$article->getID().'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW).'" /></td>
						</form>';
				}
					$content .= '
					</tr>
					</table>
				</td>
				<td class="'.$td_class.'">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr>
						<form action="alias.php" method="post">
						<input type="hidden" name="article" value="'.$article->getID().'" />
						<input type="hidden" name="parent" value="'.$cms_parentID.'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
						</form>
					';
				if (!$article->hasSubAliases()) {
					$content .= '
						<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array($article->getAlias()),MOD_CMS_ALIAS_CODENAME)) . ' ?\')">
						<input type="hidden" name="cms_action" value="delete" />
						<input type="hidden" name="article" value="'.$article->getID().'" />
						<input type="hidden" name="parent" value="'.$cms_parentID.'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
						</form>';
				}
				$content .= '
					</tr>
					</table>
				</td>
			</tr>
		';
	}
	$content .= '</table>';
} else {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
}

$content .= '
	<form action="alias.php" method="post">
	<input type="hidden" name="parent" value="'.$cms_parentID.'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form><br />
';

$dialog->setContent($content);
$dialog->show();

?>