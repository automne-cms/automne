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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: linxbuilder.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : linx builder
  * This page is opened during text edition to build internal links (aka atm-linx)
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 932);
define("MESSAGE_PAGE_RESULT", 933);
define("MESSAGE_PAGE_PROMPT", 934);
define("MESSAGE_PAGE_TREE_TITLE", 935);
define("MESSAGE_PAGE_TREE_HEADING", 936);
define("MESSAGE_PAGE_PROMPT2", 969);
define("MESSAGE_PAGE_PROMPT3", 970);
define("MESSAGE_PAGE_PROMPT4", 971);
define("MESSAGE_PAGE_LINK_TYPE", 1019);
define("MESSAGE_PAGE_LINK_INTERNAL", 1020);
define("MESSAGE_PAGE_LINK_EXTERNAL", 1021);
define("MESSAGE_PAGE_LINK_OPEN", 1022);
define("MESSAGE_PAGE_LINK_OPEN_MAIN", 1023);
define("MESSAGE_PAGE_LINK_OPEN_NEW", 1024);
define("MESSAGE_PAGE_LINK_OPEN_POPUP", 1025);
define("MESSAGE_PAGE_FIELD_LINK_TARGET", 1026);
define("MESSAGE_PAGE_FIELD_LINK_LABEL", 1027);
define("MESSAGE_PAGE_FIELD_POPUP_WIDTH", 1028);
define("MESSAGE_PAGE_FIELD_POPUP_HEIGHT", 1029);

/*
//RIGHTS CHECK
$cms_page = $cms_context->getPage();
$cms_module = CMS_modulesCatalog::getByCodename(MOD_FIC_CODENAME);

if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}*/

if ($_GET["cms_action"]) {
	$cms_action=$_GET["cms_action"];
} elseif ($_POST["cms_action"])  {
	$cms_action=$_POST["cms_action"];
}

if ($_GET["wysiwyg"]) {
	$wysiwyg=$_GET["wysiwyg"];
} elseif ($_POST["wysiwyg"])  {
	$wysiwyg=$_POST["wysiwyg"];
}

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($cms_action) {
case "validate":
	$validate='1';
	if ($_POST["type"]=='internal') {
		$grand_root = CMS_tree::getRoot();
		$linx_href = PATH_ADMIN_SPECIAL_TREE_WR;
		$linx_href .= '?root='.$grand_root->getID();
		$linx_href .= '&title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_TITLE));
		$linx_href .= '&heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TREE_HEADING));
		$linx_href .= '&linkTarget=toolbox';
		$linx_href .= '&hideMenu=1';
		//$linx_href .= '&pageLink=linxbuilder.php'.chr(167).chr(167).'linx_page=%s'.chr(167).'open='.$_POST["open"].chr(167).'cms_action=validate'.chr(167).'wysiwyg='.$wysiwyg;
		$linx_href .= '&encodedPageLink='.base64_encode('linxbuilder.php'.chr(167).chr(167).'linx_page=%s'.chr(167).'open='.$_POST["open"].chr(167).'cms_action=validate'.chr(167).'wysiwyg='.$wysiwyg);
		header("Location: ".$linx_href."&".session_name()."=".session_id());
		exit;
	} elseif($_POST["type"]=='external') {
		$type='external';
		$open=$_POST["open"];
	}
	if ($_GET["linx_page"]) {
		$type='internal';
		$target=$_GET["linx_page"];
		$open=$_GET["open"];
	}
break;
case "create":
	$create='1';
	if (($_POST["type"]=='external' && (!$_POST["target"] || $_POST["target"]=='http://')) || !$_POST["label"] || ($_POST["open"]=='popup' && (!$_POST["width"] || !$_POST["height"] || !SensitiveIO::isPositiveInteger($_POST["width"]) || !SensitiveIO::isPositiveInteger($_POST["height"])))) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
		$create='0';
		$validate='1';
		$open=$_POST["open"];
		$type=$_POST["type"];
	} else {
		$open=$_POST["open"];
		$type=$_POST["type"];
		$target=$_POST["target"];
		$label=$_POST["label"];
		$width=$_POST["width"];
		$height=$_POST["height"];
	}
break;
}

$dialog = new CMS_dialog();
$dialog->setMenu(false);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
	
if (!$create && !$validate) {
	$content .= '
	<script language="JavaScript" type="text/javascript">window.name = "toolbox";</script>
	<table border="0" cellpadding="2" cellspacing="0">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="wysiwyg" value="'.$wysiwyg.'" />
		<tr>
			<td class="admin" colspan="3"><dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_LINK_TYPE).' :</dialog-title></td>
		</tr>
		<tr>
			<td class="admin" valign="top"></td>
			<td class="admin" colspan="2">
				<input type="radio" name="type" value="internal" checked="checked" />'.$cms_language->getMessage(MESSAGE_PAGE_LINK_INTERNAL).'<br />
				<input type="radio" name="type" value="external" />'.$cms_language->getMessage(MESSAGE_PAGE_LINK_EXTERNAL).'<br />
			</td>
		</tr>
		<tr>
			<td class="admin" colspan="3"><dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_LINK_OPEN).' :</dialog-title></td>
		</tr>
		<tr>
			<td class="admin" valign="top"></td>
			<td class="admin" colspan="2">
				<input type="radio" name="open" value="main_window" checked="checked" />'.$cms_language->getMessage(MESSAGE_PAGE_LINK_OPEN_MAIN).'<br />
				<input type="radio" name="open" value="new_window" />'.$cms_language->getMessage(MESSAGE_PAGE_LINK_OPEN_NEW).'<br />
				<input type="radio" name="open" value="popup" />'.$cms_language->getMessage(MESSAGE_PAGE_LINK_OPEN_POPUP).'<br />
			</td>
		</tr>
		<tr>
			<td class="admin" colspan="3"><br /></td>
		</tr>
		<tr>
			<td colspan="3"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>
		</form>
		</table>
		<br />';
} elseif ($validate) {
	$content .= '
	<script language="JavaScript" type="text/javascript">window.name = "main";</script>
	<table border="0" cellpadding="2" cellspacing="0">
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" value="create" />
	<input type="hidden" name="open" value="'.$open.'" />
	<input type="hidden" name="type" value="'.$type.'" />
	<input type="hidden" name="wysiwyg" value="'.$wysiwyg.'" />
	';
	if ($type=='external') {
		$link_target=($_POST["target"]!='') ? $_POST["target"]:'http://';
		$content .= '<tr>
			<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK_TARGET).' :</td>
			<td class="admin" colspan="2"><input type="text" size="25" class="admin_input_text" name="target" value="'.$link_target.'" /></td>
		</tr>';
	} else {
		$content .= '<input type="hidden" name="target" value="'.$target.'" />';
	}
	$content .= '<tr>
			<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK_LABEL).' :</td>
			<td class="admin" colspan="2"><input type="text" size="25" class="admin_input_text" name="label" value="'.$_POST["label"].'" /></td>
		</tr>';
	if ($open=='popup') {
		$width=($_POST["width"]!='') ? $_POST["width"]:'500';
		$height=($_POST["height"]!='') ? $_POST["height"]:'500';
		$content .= '<tr>
			<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_POPUP_WIDTH).' :</td>
			<td class="admin" colspan="2"><input type="text" size="10" class="admin_input_text" name="width" value="'.$width.'" /></td>
		</tr>
		<tr>
			<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_POPUP_HEIGHT).' :</td>
			<td class="admin" colspan="2"><input type="text" size="10" class="admin_input_text" name="height" value="'.$height.'" /></td>
		</tr>';
	}
	$content .= '<tr>
			<td class="admin" colspan="3"><br /></td>
		</tr>
		<tr>
			<td colspan="3"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>
		</form>
		</table>
		<br />'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
		<br />';
} elseif ($create) {
	if ($type=='external') {
		$link='<a href="';
		if ($open=='popup') {
			$link.="javascript:openWindow('".$target."','popup',".$width.", ".$height.",'yes','yes','no',0,0);";
		} else {
			$link.=$target;
		}
		$target_type=($open=='new_window') ? ' target="_blank"':'';
		$link .='"'.$target_type.'>'.$label.'</a>';
	} elseif ($type=='internal') {
		$link='<atm-linx type="direct"><selection><start><nodespec type="node" value="'.$target.'" /></start></selection><display><htmltemplate><a href="';
		if ($open=='popup') {
			$link.="javascript:CMS_openPopUpPage('{{href}}', {{id}}, ".$width.", ".$height.");";
		} else {
			$link.='{{href}}';
		}
		$target_type=($open=='new_window') ? ' target="_blank"':'';
		$link .='"'.$target_type.'>'.$label.'</a></htmltemplate></display></atm-linx>';
	}
	if (!$wysiwyg) {
		$content .= '
			<form name="dummy">
			'.$cms_language->getMessage(MESSAGE_PAGE_RESULT).' :<br />
			<textarea class="admin_long_textarea" name="result" cols="65" rows="8">' .$link. '</textarea>
			</form>
		' ;
	} else {
		$link =str_replace ("'","\'",$link);
		$content .= '<script language="javascript">
					opener.copyLink(\'' .$link. '\');
					window.close();
					</script>';
	}
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
$dialog->setJavascript($js);
$dialog->setContent($content);
$dialog->show();

?>