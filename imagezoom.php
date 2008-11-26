<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2007 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// | The license text is bundled with this package in the file            |
// | LICENSE-GPL, and is available at through the world-wide-web at       |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: imagezoom.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : visualization of an enlarged image for the imageZoom block type
  * Waits for a GET var : "file" which must contain the filename (without path)
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

define("POPUP_ADD_X_SIZE", 40);
define("POPUP_ADD_Y_SIZE", 85);

//clean a little the filename
if (isset($_GET["file"])) {
	$filename = htmlspecialchars(strtr($_GET["file"], "/\\", "__"));
} else {
	die('Error, No image to display ...');
}
$label = isset($_GET["label"]) ? stripslashes(htmlspecialchars(urldecode($_GET["label"]))) : '';

//Trick used to view not published images
$location = (isset($_GET["location"]) && ((isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"], "automne/admin") !== false) || (isset($_GET["popup"]) && $_GET["popup"]==="true"))) ? $_GET["location"] : "public";
$module = (isset($_GET["module"])) ? $_GET["module"] : 'standard';
$filepath = "/automne_modules_files/" . $module . "/" . $location . "/" . $filename;
$dimensions = array(0,0);
if (file_exists($_SERVER["DOCUMENT_ROOT"] . $filepath)) {
	$html = '<img src="' . $filepath . '" border="0" onclick="window.close();" alt="'.str_replace('"','\"',$label).'" title="'.str_replace('"','\"',$label).'" />';
	if (isset($_GET["popup"]) && $_GET["popup"]==="true") {
		$dimensions = getimagesize($_SERVER["DOCUMENT_ROOT"] . $filepath);
	}
} else {
	$html = '';
}
?>
<html>
<head>
	<title><?php echo $label; ?></title>
	<style type="text/css">
		body {
			font-family:Verdana,Arial,sans; 
			font-size:12px; 
			color:#000000;
			background-color:#FFFFFF;
			margin:	0px;
			padding: 0px;
		}
		td,th,p {
			font-family:Verdana,Arial,sans; 
			font-size:12px; 
		}
		.imagezoom {
			color:#000000;
			font-weight:bold;
			font-size:12px;
		}
	</style>
</head>
<body>
	<?php
	if (isset($_GET["popup"]) && $_GET["popup"]==="true" && $dimensions[0]>20) {
		echo '
		<!-- resize popup to image size -->
		<script language="Javascript">
			var sizeX = (screen.availWidth >'.($dimensions[0]+POPUP_ADD_X_SIZE).') ? '.($dimensions[0]+POPUP_ADD_X_SIZE).':screen.availWidth;
			var sizeY = (screen.availHeight>'.($dimensions[1]+POPUP_ADD_Y_SIZE).') ? '.($dimensions[1]+POPUP_ADD_Y_SIZE).':screen.availHeight;
			window.resizeTo(sizeX,sizeY);
		</script>
		';
	}
	?>
	<table border="0" cellpadding="2" cellspacing="0" width="100%" height="100%">
	<tr>
		<td align="center" valign="middle" width="100%" height="100%"><?php echo $html; ?></td>
	</tr>
	<tr>
		<td align="center" valign="middle" width="100%" height="100%"><span class="imagezoom"><?php echo $label; ?></span></td>
	</tr>
	</table>
</body>
</html>