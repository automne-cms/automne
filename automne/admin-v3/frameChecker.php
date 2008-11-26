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
// $Id: frameChecker.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : frames
  * frameChecker page. This frame supervise all the frameset and save new frames size if javascript in main frame detect changing.
  * 
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

$dialog = new CMS_dialog();

if ($cms_context->getSessionVar('hauteurArbo') == '0' && $cms_context->getSessionVar('hauteurModules') == '0') {
	//current user have not any admin rights so logout !
	header("Location: ".PATH_ADMIN_SPECIAL_LOGIN_WR."?cms_message_id=65&cms_action=logout&".session_name()."=".session_id());
	exit;
}

//Action management	
if ($_POST["cms_action"] == "saveFramesetSize") {
	$cms_context->setSessionVar('largeur',$_POST["largeur"]);
	$cms_context->setSessionVar('hauteurArbo',$_POST["hauteurArbo"]);
	$cms_context->setSessionVar('hauteurModules',$_POST["hauteurModules"]);
	$dialog->reloadTree();
	$dialog->reloadModules();
}

$content="";
$content.='
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" name="saveFramesetSize" target="frameChecker">
<input type="hidden" name="cms_action" value="saveFramesetSize" />
<input type="hidden" name="largeur" value="'.$cms_context->getSessionVar('largeur').'" />
<input type="hidden" name="hauteurArbo" value="'.$cms_context->getSessionVar('hauteurArbo').'" />
<input type="hidden" name="hauteurModules" value="'.$cms_context->getSessionVar('hauteurModules').'" />
</form>';
if (VIEW_SQL) {
	$content.='<br />
	<div align="center">
		<form action="stat.php" method="get" name="showStats" target="stats">
		<input type="submit" class="admin_input_submit" name="show" value="Show Debug Stats" />
		<input type="hidden" name="SQL_TIME_MARK" value="0.001" />
		</form>
	</div>';
}
$dialog->setContent($content);
$dialog->show('frameChecker');
?>
