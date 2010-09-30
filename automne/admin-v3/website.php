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
// $Id: website.php,v 1.4 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : page base data
  * Used to edit the pages base data. Also used when creating a page, it's the first step.
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 816);
define("MESSAGE_PAGE_ROOT_ALREADY_USED", 817);
define("MESSAGE_PAGE_ROOT_SET_ERROR", 818);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_URL", 819);
define("MESSAGE_PAGE_FIELD_ROOT", 815);
define("MESSAGE_PAGE_BUTTON_CHANGE", 820);
define("MESSAGE_PAGE_TREE_TITLE", 822);
define("MESSAGE_PAGE_TREE_HEADING", 823);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 140);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_FIELD_AUTHOR", 1033);
define("MESSAGE_PAGE_FIELD_REPLYTO", 1034);
define("MESSAGE_PAGE_FIELD_COPYRIGHT", 1035);
define("MESSAGE_PAGE_FIELD_LANGUAGE", 1036);
define("MESSAGE_PAGE_FIELD_ROBOTS", 1037);
define("MESSAGE_PAGE_FIELD_ROBOTS_COMMENT", 1042);
define("MESSAGE_PAGE_META_DESCRIPTION", 1327);
define("MESSAGE_PAGE_FIELD_FAVICON", 1343);
define("MESSAGE_PAGE_FIELD_FAVICON_COMMENT", 1344);
define("MESSAGE_PAGE_CHOOSE", 1132);
define("MESSAGE_PAGE_FIELD_LABEL_DESC", 1431);
define("MESSAGE_PAGE_META_DATA_LABEL", 393);
define("MESSAGE_PAGE_FIELD_SUB_DOMAINS", 1603);
define("MESSAGE_PAGE_FIELD_SUB_DOMAINS_DESC", 1604);
define("MESSAGE_PAGE_CODENAMES", 1683);

//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

$website = new CMS_website($_GET["website"]);
$grand_root = CMS_tree::getRoot();

//website root page change
if ($_GET["cms_action"] == "set_root" && $_GET["website_root"]) {
	$page = CMS_tree::getPageByID($_GET["website_root"]);
	
	//must check that the page ain't the root of another website already
	$all_websites = CMS_websitesCatalog::getAll();
	foreach ($all_websites as $aWebsite) {
		$current_root = $aWebsite->getRoot();
		if ($current_root->getID() == $page->getID() && $aWebsite->getID() != $website->getID()) {
			Header("Location: websites.php?cms_message_id=".MESSAGE_PAGE_ROOT_ALREADY_USED."&".session_name()."=".session_id());
			exit;
		}
	}
	
	if (!$website->setRoot($page)) {
		Header("Location: websites.php?cms_message_id=".MESSAGE_PAGE_ROOT_SET_ERROR."&".session_name()."=".session_id());
		exit;
	}
}
$dialog = new CMS_dialog();
//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$_POST["url"] || $_POST["url"] == "http://" || !$_POST["root"]) {
		header("Location: websites.php?cms_message_id=".MESSAGE_FORM_ERROR_MANDATORY_FIELDS."&".session_name()."=".session_id());
		exit;
	} else {
		$website->setURL($_POST["url"]);
		$website->setAltDomains($_POST["altdomains"]);
		if ($website->getID()) {
			$page = CMS_tree::getPageByID($_POST["root"]);
			$website_root = $website->getRoot();
			if ($page->getID() != $website_root->getID()) {
				$website->setRoot($page);
			}
		} else {
			$website->setLabel($_POST["label"]);
			$page = CMS_tree::getPageByID($_POST["root"]);
			$website->setRoot($page);
		}
		//set meta values
		$website->setMeta('description', $_POST['description']);
		$website->setMeta('keywords', $_POST['keywords']);
		$website->setMeta('category', $_POST['category']);
		$website->setMeta('robots', $_POST['robots']);
		$website->setMeta('author', $_POST['author']);
		$website->setMeta('replyto', $_POST['replyto']);
		$website->setMeta('copyright', $_POST['copyright']);
		$website->setMeta('language', $_POST['language']);
		$website->setMeta('favicon', $_POST['favicon']);
		$website->setMeta('metas', $_POST['metas']);
		if (!$website->hasError()) {
			$website->writeToPersistence();
			CMS_tree::regenerateAllPages(true);
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_WEBSITE_EDIT, $cms_user, "Website : ".$website->getLabel());
			$dialog->reloadAll();
		}
		header("Location: websites.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	}
	break;
}


$dialog->setBackLink("websites.php");
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$grand_root = CMS_tree::getRoot();
$tree_href = PATH_ADMIN_SPECIAL_TREE_WR;
$tree_href .= '?root='.$grand_root->getID();
//$tree_href .= '&amp;pageLink=website.php'.chr(167).chr(167).'website_root=%s'.chr(167).'cms_action=set_root'.chr(167).'website='.$website->getID();
$tree_href .= '&amp;encodedPageLink='.base64_encode('website.php'.chr(167).chr(167).'website_root=%s'.chr(167).'cms_action=set_root'.chr(167).'website='.$website->getID());
$tree_href .= '&amp;backLink=websites.php';
$tree_href .= '&amp;title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_TITLE));
$tree_href .= '&amp;heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_HEADING));
$website_root = $website->getRoot();

$content = '
<form action="'.$_SERVER["SCRIPT_NAME"].'?website='.$website->getID().'" method="post">
<table border="0" cellpadding="3" cellspacing="2">
	<input type="hidden" name="cms_action" value="validate" />
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
	';
	if ($website->getID()) {
		$content .= '
			<td class="admin">'.htmlspecialchars($website->getLabel()).'</td>
		';
	} else {
		$content .= '
			<td class="admin"><input type="text" size="30" class="admin_input_text" name="label" value="'.htmlspecialchars($website->getLabel()).'" /> <small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL_DESC).'</small></td>
		';
	}
	$content .= '
	</tr>
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_URL).'</td>
		<td class="admin"><input type="text" size="30" class="admin_input_text" name="url" value="'.htmlspecialchars($website->getURL()).'" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROOT).'</td>
		<td class="admin">'.htmlspecialchars($website_root->getTitle()).' ('.$website_root->getID().')<input type="hidden" name="root" value="'.$website_root->getID().'" />
';

//users can modify the website root, unless it's the main root
if ($website_root->getID() != $grand_root->getID()) {
	$content .= '
		<input type="Button" onClick="location.replace(\''.$tree_href.'&'.session_name().'='.session_id().'\');" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_BUTTON_CHANGE).'" />
	';
}
$content .= '
		</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SUB_DOMAINS).'</td>
		<td class="admin"><input type="text" size="30" class="admin_input_text" name="altdomains" value="'.htmlspecialchars(implode(';', $website->getAltDomains())).'" /><br /><small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SUB_DOMAINS_DESC).'</small></td>
	</tr>
</table>
<fieldset class="admin">
<legend class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_META_DESCRIPTION).'</strong></legend>
<table border="0" cellpadding="3" cellspacing="2">
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
		<td class="admin"><textarea cols="45" rows="2" class="admin_long_textarea" name="description">'.htmlspecialchars($website->getMeta('description')).'</textarea>&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS).'</td>
		<td class="admin"><textarea cols="45" rows="2" class="admin_long_textarea" name="keywords">'.htmlspecialchars($website->getMeta('keywords')).'</textarea>&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORY).'</td>
		<td class="admin"><input type="text" size="30" maxlength="255" class="admin_input_long_text" name="category" value="'.htmlspecialchars($website->getMeta('category')).'" />&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROBOTS).'</td>
		<td class="admin"><input type="text" size="15" maxlength="255" class="admin_input_text" name="robots" value="'.htmlspecialchars($website->getMeta('robots')).'" /><br /><span class="admin_comment">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ROBOTS_COMMENT).'</span>&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_AUTHOR).'</td>
		<td class="admin"><input type="text" size="30" maxlength="255" class="admin_input_long_text" name="author" value="'.htmlspecialchars($website->getMeta('author')).'" />&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REPLYTO).'</td>
		<td class="admin"><input type="text" size="15" maxlength="255" class="admin_input_long_text" name="replyto" value="'.htmlspecialchars($website->getMeta('replyto')).'" />&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COPYRIGHT).'</td>
		<td class="admin"><input type="text" size="30" maxlength="255" class="admin_input_long_text" name="copyright" value="'.htmlspecialchars($website->getMeta('copyright')).'" />&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getJsMessage(MESSAGE_PAGE_META_DATA_LABEL).'</td>
		<td class="admin"><textarea cols="45" rows="2" class="admin_long_textarea" name="metas">'.htmlspecialchars($website->getMeta('metas')).'</textarea>&nbsp;</td>
	</tr>
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LANGUAGE).'</td>
		<td class="admin"><select name="language" class="admin_input_text">
			<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
		$languages = CMS_languagesCatalog::getAllLanguages(MOD_STANDARD_CODENAME);
		foreach ($languages as $aLanguage) {
			$content .= '<option value="'.$aLanguage->getCode().'"'.($aLanguage->getCode() == $website->getMeta('language') ? ' selected="selected"':'').'>'.$aLanguage->getLabel().'</option>';
		}
		$content .= '
		</select>
		</td>
	</tr>
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FAVICON).'</td>
		<td class="admin"><input type="text" size="30" maxlength="255" class="admin_input_long_text" name="favicon" value="'.htmlspecialchars($website->getMeta('favicon')).'" />&nbsp; <span class="admin_comment">('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FAVICON_COMMENT).')</span></td>
	</tr>
	<tr>
		<td colspan="2" class="admin"><br /><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
</table>
</fieldset>
</form>
<br />
'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
<br /><br />';
$codenames = $website->getAllCodenames();
if ($codenames) {
	$content .= '
	<fieldset class="admin">
	<legend class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_CODENAMES).'</strong></legend><ul>';
	foreach ($codenames as $codename => $pageId) {
		$page = CMS_tree::getPageById($pageId);
		$content .= '<li>'.$codename.' : <a href="#" onclick="Automne.utils.getPageById('.$page->getID().');Ext.WindowMgr.getActive().close();" class="admin">'.$page->getTitle().' ('.$page->getID().')</a></li>';
	}
	$content .= '
	</ul></fieldset>
	';
}
$dialog->setContent($content);
$dialog->show();
?>