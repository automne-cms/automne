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
// $Id: index.php,v 1.2 2010/03/08 16:41:39 sebastien Exp $

/**
  * PHP page : index
  * Manages the login and logout of users. Creates the context and put it into $_SESSION.
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_frontend.php');

define("MESSAGE_PAGE_LOGIN_INCORRECT", 50);
define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_PAGE_IDENTIFY", 52);
define("MESSAGE_PAGE_CHANGE_LANGUAGE", 53);
define("MESSAGE_PAGE_LOGIN", 54);
define("MESSAGE_PAGE_PASSWORD", 55);
define("MESSAGE_PAGE_REMEMBER_ME", 1218);
define("MESSAGE_BUTTON_VALIDATE", 56);

if (isset($_GET["language"]) && SensitiveIO::isInSet($_GET["language"], array_keys(CMS_languagesCatalog::getAllLanguages()))) {
	$language = CMS_languagesCatalog::getByCode($_GET["language"]);
	if (!$language) {
		$language = CMS_languagesCatalog::getDefaultLanguage();
	}
} elseif (SensitiveIO::isInSet(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), array_keys(CMS_languagesCatalog::getAllLanguages()))) {
	$language = CMS_languagesCatalog::getByCode(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));
	if (!$language) {
		$language = CMS_languagesCatalog::getDefaultLanguage();
	}
} else {
	$language = CMS_languagesCatalog::getDefaultLanguage();
}

if (isset($_GET["cms_message_id"]) && SensitiveIO::isPositiveInteger($_GET["cms_message_id"]))	{
	$cms_message = $language->getMessage($_GET["cms_message_id"]);
} else {
	$cms_message = (isset($_GET["cms_message"])) ? SensitiveIO::sanitizeHTMLString($_GET["cms_message"]) : false;
}

//Action management	
switch ($_POST["cms_action"]) {
case "login":
	$cms_context = new CMS_context($_POST["login"], $_POST["password"], $_POST["permanent"]);
	if (!$cms_context->hasError()) {
		@session_start();
		$_SESSION["cms_context"] = $cms_context;

		//launch the daily routine incase it's not in the cron
		CMS_module_standard::processDailyRoutine();
		
		//redirect to entry page
		header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?".session_name()."=".session_id());
		exit;
	} else {
		$cms_message = $language->getMessage(MESSAGE_PAGE_LOGIN_INCORRECT);
	}
	break;
default:
	// First attempt to obtain $_COOKIE information from domain
	// and redirects to entry page
	if ($_REQUEST["cms_action"] != 'logout' && CMS_context::autoLoginSucceeded()) {
		header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?".session_name()."=".session_id());
		exit;
	}
	// Reset cookie
	CMS_context::resetSessionCookies();
	break;
}

echo '
<html>
<head>
	<title>'.$language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)).'</title>
	<link rel="STYLESHEET" type="text/css" href="'.PATH_REALROOT_WR.'/automne/admin/css/main.css" />
	<script type="text/javascript" language="javascript">
		if (window.top != window.self) {
	    	window.top.location.replace(\'./index.php?cms_message_id='.$_GET["cms_message_id"].'&'.session_name().'='.session_id().'\');
		}
    </script>
	'.CMS_dialog::addJavascriptCheck().'
	<script src="'.PATH_ADMIN_WR.'/js/clientsnifferjr.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript">
	if (!is.ie4up && !is.nav5up && !is.opera) {
		window.top.location.replace(\'./nav.php?'.session_name().'='.session_id().'\');
	} 
	</script>
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" class="admin" onLoad="initJavascript();">

<table width="100%" height="72" border="0" cellpadding="0" cellspacing="0" style="background:url('.PATH_ADMIN_IMAGES_WR.'/fond.gif) repeat-x bottom left;">
	<tr>
		<td width="562" height="72" valign="top" class="admin">
			<table width="562" height="30" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="472" height="30" class="admin_date">
						&nbsp;&nbsp;<b>'. date($language->getDateFormat(), mktime()) . '</b></td>
					<td width="90" height="30" class="admin"><a href="http://www.automne.ws" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/powered.gif" border="0" /></a></td>
				</tr>
			</table>
			<table width="562" height="42" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="562" height="42" align="center" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" width="562" height="1" border="0" /><br />
						<span class="admin_hello"><strong>'.$language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)).'</strong></span> <span class="admin_subTitle">' .$language->getMessage(MESSAGE_PAGE_IDENTIFY). '</span>
					</td>
				</tr>
			</table>
		</td>
		<td width="138" height="72"><a href="'.CMS_websitesCatalog::getMainURL().'" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/logo.png" class="png" width="138" height="72" border="0" /></a></td>
		<td width="100%" height="72" valign="top" class="admin">
			<table width="100%" height="72" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" height="30"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" width="1" height="1" border="0" /></td>
				</tr>
				<tr>
					<td width="100%" height="42" align="right" valign="bottom" class="admin_date"><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" width="1" height="1" border="0" />';
					if (file_exists(PATH_REALROOT_FS."/VERSION")) {
						echo 'v';
						include_once(PATH_REALROOT_FS."/VERSION");
					}
			echo '</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<br />
<br />
<br />
<table width="60%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_hg.gif" border="0" alt="-" /></td>
		<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_h.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_h.gif" align="right"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_hd.gif" border="0" alt="-" /></td>
	</tr>
	<tr>
		<td width="36" valign="top" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_g.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td colspan="2" rowspan="2" class="admin">';
		
		if ($cms_message) {
			echo '
				<table border="0" width="100%" align="center">
				<tr>
					<td align="left">
						<span class="admin_text_alert">'.$cms_message.'</span>
					</td>
				</tr>
				</table>
			';
		}
		if (file_exists(PATH_ADMIN_FS."/inc/index_".$language->getCode().".inc.php")) {
			include_once(PATH_ADMIN_FS."/inc/index_".$language->getCode().".inc.php");
		}
		echo'
		<!-- identification form -->
		<table width="50%" border="0" cellpadding="3" cellspacing="0" align="center">
			<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
			<input type="hidden" name="cms_action" value="login" />
			<tr>
				<td class="admin_id_title">'.$language->getMessage(MESSAGE_PAGE_LOGIN).' :</td>
			</tr>
			<tr>
				<td class="admin"><input type="text" class="admin_input_id" name="login" /></td>
			</tr>
			<tr>
				<td class="admin_id_title">'.$language->getMessage(MESSAGE_PAGE_PASSWORD).' :</td>
			</tr>
			<tr>
				<td class="admin"><input type="password" class="admin_input_id" name="password" /></td>
			</tr>
			<tr>
				<td class="admin" colspan="2">
					<input id="rememberme" type="checkbox" name="permanent" value="1" /><label for="rememberme">'.$language->getMessage(MESSAGE_PAGE_REMEMBER_ME).'</label>
				</td>
			</tr>
			<tr>
				<td align="right">
				<input type="submit" value="'.$language->getMessage(MESSAGE_BUTTON_VALIDATE).'" class="admin_input_submit" /></td>
			</tr>
			</form>
		</table>
		
		</td>
		<td width="36" valign="top" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_d.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
	</tr>
	<tr>
		<td width="5" valign="bottom" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_g.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td width="5" valign="bottom" background="' .PATH_ADMIN_IMAGES_WR .'/tiret_d.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
	</tr>
	<tr>
		<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_bg.gif" border="0" alt="-" /></td>
		<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_b.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td background="' .PATH_ADMIN_IMAGES_WR .'/tiret_b.gif" align="right"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="1" border="0" alt="-" /></td>
		<td width="36" height="36"><img src="' .PATH_ADMIN_IMAGES_WR .'/rond_bd.gif" border="0" alt="-" /></td>
	</tr>
</table>
<br /><br />
<br /><br />
<br />
</body>
</html>';
?>