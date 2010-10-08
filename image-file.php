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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Automne image files download handler
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  */

// *******************************************************************************
// **   IMAGE FILE HANDLER. THIS PHP CODE IS NEEDED TO DOWNLOAD IMAGES          **
// *******************************************************************************
//disactive HTML compression
define("ENABLE_HTML_COMPRESSION", false);
require_once(dirname(__FILE__).'/cms_rc_frontend.php');

$replace = array(
	'..' => '',
	'\\' => '',
	'/' => '',
);

//Get image vars
$image = io::get('image');
$location = (io::get('location') && isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"], "automne/admin") !== false) ? io::get('location') : RESOURCE_DATA_LOCATION_PUBLIC;
$location = in_array($location, array(RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_PUBLIC)) ? $location : '';
$module = io::get('module') ? io::get('module') : MOD_STANDARD_CODENAME;
$module = in_array($module, CMS_modulesCatalog::getAllCodenames()) ? $module : '';
$x = io::get('x', 'io::isPositiveInteger');
$y = io::get('y', 'io::isPositiveInteger');
if ($image != io::htmlspecialchars(str_replace(array_keys($replace), $replace, $image))) {
	$image = '';
}

$imagepathFS = PATH_MODULES_FILES_FS . '/' . $module . '/' . $location . '/' . $image;

if(!$image || !$module || !$location || !file_exists($imagepathFS)) {
	//send image 404
	if (file_exists(PATH_REALROOT_FS.'/img/404.png')) {
		CMS_file::downloadFile(PATH_REALROOT_FS.'/img/404.png');
	}
}
$image = new CMS_image($imagepathFS);
//get current file size
$sizeX = $image->getWidth();
$sizeY = $image->getHeight();

//check if file already exists
if (($x && $sizeX > $x) || ($y && $sizeY > $y)) {
	//check image size
	$newSizeX = $sizeX;
	$newSizeY = $sizeY;
	// set new image dimensions
	if ($x && $newSizeX > $x) {
		$newSizeY = round(($x * $newSizeY) / $newSizeX);
		$newSizeX = $x;
	}
	if($y && $newSizeY > $y){
		$newSizeX = round(($y * $newSizeX) / $newSizeY);
		$newSizeY = $y;
	}
	$pathInfo = pathinfo($imagepathFS);
	$resizedImage = $pathInfo['filename'] .'-'. $newSizeX .'-'. $newSizeY .'.'. $pathInfo['extension'];
} else {
	$resizedImage = $image;
}

//resized image path
$resizedImagepathFS = PATH_MODULES_FILES_FS . '/' . $module . '/' . $location . '/' . $resizedImage;
//if file already exists, no need to resize file
if(file_exists($resizedImagepathFS)) {
	//send file to browser
	CMS_file::downloadFile($resizedImagepathFS);
}
//resize image
$resizedImage = $image->resize($resizedImagepathFS, $newSizeX, $newSizeY);

//send resized image to browser
CMS_file::downloadFile($resizedImage->getFilename());
?>