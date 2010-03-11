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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: imagezoom.php,v 1.3 2010/03/08 16:45:48 sebastien Exp $

/**
  * PHP page : visualization of an enlarged image for the imageZoom block type
  * Waits for a GET var : "file" which must contain the filename (without path)
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/cms_rc_frontend.php');

define("POPUP_ADD_X_SIZE", 40);
define("POPUP_ADD_Y_SIZE", 115);

$replace = array(
	'..' => '',
	'\\' => '',
	'/' => '',
);

//clean a little the filename
if (isset($_GET["file"])) {
	$filename = io::htmlspecialchars(strtr($_GET["file"], "/\\", "__"));
} else {
	die('Error, No image to display ...');
}
$label = isset($_GET["label"]) ? stripslashes(io::htmlspecialchars(urldecode($_GET["label"]))) : '';

//Trick used to view not published images
$location = (isset($_GET["location"]) && ((isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"], "automne/admin") !== false) || (isset($_GET["popup"]) && $_GET["popup"]==="true"))) ? $_GET["location"] : "public";
$module = (isset($_GET["module"])) ? $_GET["module"] : 'standard';

$filename = str_replace(array_keys($replace), $replace, $filename);
$module = str_replace(array_keys($replace), $replace, $module);
$location = str_replace(array_keys($replace), $replace, $location);

$filepath = "/automne_modules_files/" . $module . "/" . $location . "/" . $filename;

$dimensions = array(0,0);
if(file_exists(PATH_REALROOT_FS . $filepath) && strpos(pathinfo(PATH_REALROOT_FS . $filepath, PATHINFO_DIRNAME), PATH_REALROOT_FS) === 0) {
	$html = '<img src="' . PATH_REALROOT_WR . $filepath . '" onclick="window.close();" alt="'.$label.'" title="'.$label.'" />';
	if (isset($_GET["popup"]) && $_GET["popup"]==="true") {
		$dimensions = getimagesize(PATH_REALROOT_FS . $filepath);
	}
} else {
	$html = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />'; ?>
	<title><?php echo $label; ?></title>
	<style type="text/css">
		body {
			font:				bold 12px Verdana,Arial,sans; 
			color:				#000000;
			background-color:	#FFFFFF;
			margin:				0px;
			padding:			0px;
		}
		body div {
			text-align:			center;
		}
		p {
			margin:				0px;
			padding:			0px;
		}
		img {
			border:				0;
			cursor:				pointer;
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
	<div>
		<?php echo $html; ?>
		<p><?php echo $label; ?></p>
	</div>
</body>
</html>