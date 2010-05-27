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
// $Id: alias.php,v 1.3 2010/03/08 16:42:06 sebastien Exp $

/**
  * PHP page : module admin frontend : aliases : alias
  * Presents the module aliases
  *
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_INTERNALLINK", 276);
define("MESSAGE_PAGE_EXTERNALLINK", 277);
define("MESSAGE_PAGE_TREEH1", 1049);
define("MESSAGE_FORM_ERROR_LINK_MANDATORY", 802);
define("MESSAGE_FORM_ERROR_PAGE", 870);

//module specific
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_NAME", 2);
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_TARGET", 3);
define("MESSAGE_PAGE_FIELD_CMS_ALIAS_PARENT", 6);
define("MESSAGE_PAGE_TITLE", 7);
define("MESSAGE_FORM_ERROR_CMS_ALIAS_EXIST", 8);


//CHECKS
$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_ALIAS_CODENAME);

if (!$cms_user->hasModuleClearance(MOD_CMS_ALIAS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$article = new CMS_resource_cms_aliases($_POST["article"]);
$cms_parent = new CMS_resource_cms_aliases($_POST["parent"]);
$cms_parentID = ($cms_parent->getID()) ? $cms_parent->getID():0;

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	$article->setDebug(false);
	if (!$_POST["aliasFolder"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS)."\n";
	} elseif (($_POST["link_type"] == RESOURCE_LINK_TYPE_INTERNAL && !$_POST["link_internal"])
				||($_POST["link_type"] == RESOURCE_LINK_TYPE_EXTERNAL && !$_POST["link_external"])) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_LINK_MANDATORY)."\n";
	}
	//need to set parent before set alias name
	$article->setParent($cms_parent);
	
	if ($article->setAlias($_POST["aliasFolder"])===false) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_CMS_ALIAS_EXIST,false,MOD_CMS_ALIAS_CODENAME)."\n";
	}
	
	if ($_POST["link_type"] == RESOURCE_LINK_TYPE_INTERNAL) {
		$page = new CMS_page($_POST["link_internal"]);
		if (!$article->setPage($page)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_PAGE)."\n";
		}
	}elseif($_POST["link_type"] == RESOURCE_LINK_TYPE_EXTERNAL) {
		$article->setURL($_POST["link_external"]);
	}
	
	$article->setDebug(SYSTEM_DEBUG);
	
	if (!$cms_message) {
		//save the data
		$article->writeToPersistence();
		
		header("Location: ".$cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT)."?parent=".$cms_parentID."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE,false,MOD_CMS_ALIAS_CODENAME));
$dialog->setBacklink($cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT)."?parent=".$cms_parent->getID());
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//build tree link
$grand_root = CMS_tree::getRoot();
$href = PATH_ADMIN_SPECIAL_TREE_WR;
$href .= '?root='.$grand_root->getID();
$href .= '&amp;heading='.$cms_language->getMessage(MESSAGE_PAGE_TREEH1);
$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('page_link').value = '%s';self.close();");
$href .= '&encodedPageLink='.base64_encode('false');

if ($cms_parent) {
	$parentLineAge =$cms_parent->getAliasLineAge().$cms_parent->getAlias().'/';
} else {
	$parentLineAge ='';
}

if (!$article->getID()) {
	$aliasFolder='<input type="text" size="30" class="admin_input_text" name="aliasFolder" value="" />';
} else {
	$aliasFolder='<strong>'.$article->getAlias().'</strong><input type="hidden" name="aliasFolder" value="'.$article->getAlias().'" />';
}

$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="article" value="'.$_POST["article"].'" />
	<input type="hidden" name="parent" value="'.$cms_parentID.'" />
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_NAME,false,MOD_CMS_ALIAS_CODENAME).' :</td>
		<td class="admin">'.$aliasFolder.'</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_PARENT,false,MOD_CMS_ALIAS_CODENAME).' :</td>
		<td class="admin">'.$parentLineAge.'</td>
	</tr>
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CMS_ALIAS_TARGET,false,MOD_CMS_ALIAS_CODENAME).' :</td>
		<td class="admin">
			<table border="0" cellpadding="2" cellspacing="0">';
if ($article->getPageID()) {
	$pageChecked = ' checked="checked"';
	$urlChecked = '';
} elseif ($article->getURL()) {
	$urlChecked = ' checked="checked"';
	$pageChecked = '';
} else {
	$pageChecked = ' checked="checked"';
	$urlChecked = '';
}
$content .= '
			<tr>
				<td class="admin">
					<input type="radio" name="link_type" value="'.RESOURCE_LINK_TYPE_INTERNAL.'"'.$pageChecked.' />
					'.$cms_language->getMessage(MESSAGE_PAGE_INTERNALLINK).'
					<input type="text" id="page_link" class="admin_input_text" name="link_internal" value="'.$article->getPageID().'" size="6" /> <a href="'.$href.'" class="admin" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR. '/picto-arbo.gif" border="0" /></a>
				</td>
			</tr>
';
$content .= '
			<tr>
				<td class="admin">
					<input type="radio" name="link_type" value="'.RESOURCE_LINK_TYPE_EXTERNAL.'"'.$urlChecked.' />
					'.$cms_language->getMessage(MESSAGE_PAGE_EXTERNALLINK).'
					<input type="text" class="admin_input_text" name="link_external" value="'.$article->getURL().'" size="30" />
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';

$dialog->setContent($content);
$dialog->show();

?>