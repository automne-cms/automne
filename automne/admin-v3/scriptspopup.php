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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: scriptspopup.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : Scripts Popup
  * Process all scripts in queue
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//for this page, HTML output compression is not welcome.
define("ENABLE_HTML_COMPRESSION", false);
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_ACTION_REGENERATION", 944);
define("MESSAGE_PAGE_ACTION_REMAININGSCRIPTS", 1326);
define("MESSAGE_PAGE_SCRIPTS_INPROGRESS", 1066);
define("MESSAGE_PAGE_DONE", 1180);
define("MESSAGE_PAGE_DO_NOT_CLOSE", 1181);

//augment the execution time, because things here can be quite lengthy
@set_time_limit(0);

// +----------------------------------------------------------------------+
// | Scripts Infos                                                        |
// +----------------------------------------------------------------------+

$_SESSION["cms_context"]->setSessionVar('scriptpopup_is_open',true);
$_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',0);
if ($_SESSION["cms_context"]->getSessionVar('scriptpopup_TotalScripts')) {
	$scripts = CMS_scriptsManager::getScriptsLeft();
	$totalScripts = $_SESSION["cms_context"]->getSessionVar('scriptpopup_TotalScripts');
} else {
	$scripts = CMS_scriptsManager::getScriptsLeft();
	$totalScripts = sizeof($scripts);
	$_SESSION["cms_context"]->setSessionVar('scriptpopup_TotalScripts',$totalScripts);
}

$scriptsLeft = sizeof($scripts);
$scriptsDone = $totalScripts - $scriptsLeft;
$percentScriptsLeft = ($scriptsDone > 0) ? intval(($scriptsDone*100) / $totalScripts) : 0;
$close='';
if ($scriptsLeft == 0) {
	$_SESSION["cms_context"]->setSessionVar('scriptpopup_TotalScripts','');
	$_SESSION["cms_context"]->setSessionVar('start_script',false);
	$_SESSION["cms_context"]->setSessionVar('scriptpopup_is_open',false);
	$_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',0);
	$close = '
	<script language="javascript">
	<!--
		window.close();
	//-->
	</script>';
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

@ini_set('output_buffering','Off');
@ob_end_flush();
$content ='
<html>
<head>
	'.CMS_dialog::copyright().'
	<title>'.$percentScriptsLeft.'% '.$cms_language->getMessage(MESSAGE_PAGE_DONE).'</title>
	<link rel="STYLESHEET" type="text/css" href="' . PATH_ADMIN_CSS_WR. '/main.css" />
	<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
	<meta http-equiv="pragma" content="no-cache" />
</head>
<body onload="location.replace(\'scriptspopup.php?'.session_name().'='.session_id().'\');" style="background:url(\'' .PATH_ADMIN_IMAGES_WR .'/logo_small.gif\') right top no-repeat;">
'.$close.'
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="admin">
		'.CMS_dialog::_getTitleDesign($cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_INPROGRESS).'.<br />
		'.$cms_language->getMessage(MESSAGE_PAGE_DO_NOT_CLOSE),'admin_h3').'<br />
		'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_REMAININGSCRIPTS).' : '.$scriptsLeft.' / '.$totalScripts.'<br />
		</td>
	</tr>
	<tr>
		<td class="admin" align="center"><br />'.$percentScriptsLeft.' %<br />
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #000000;">
				<tr>
					<td width="'.$percentScriptsLeft.'%" bgcolor="#D8FA90"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="12" border="0" /></td>
					<td width="'.(100-$percentScriptsLeft).'%"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="1" height="12" border="0" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
';
//render
echo $content;
@flush();

// +----------------------------------------------------------------------+
// | Script Process                                                       |
// +----------------------------------------------------------------------+

//the sql which selects scripts to regenerate at a time
$sql_select = "
	select
		*
	from
		regenerator
	limit
		".REGENERATION_THREADS."
";
$q = new CMS_query($sql_select);
$modules = array();
while($data = $q->getArray()) {
	//instanciate script module
	if (!$modules[$data['module_reg']]) {
		$modules[$data['module_reg']] = CMS_modulesCatalog::getByCodename($data['module_reg']);
	}
	//then send script task to module (return task title by reference)
	$task = $modules[$data['module_reg']]->scriptTask(unserialize($data['parameters_reg']));
	
	//delete the current script task
	$sql_delete = "
		delete
		from
			regenerator
		where
			id_reg='".$data['id_reg']."'";
	$q_delete = new CMS_query($sql_delete);
}
//send something then close
echo ' ';
exit;
?>