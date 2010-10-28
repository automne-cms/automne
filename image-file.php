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
//only cms_rc needed in this case : no extra loading
define('APPLICATION_USER_TYPE', 'file');
require_once(dirname(__FILE__).'/cms_rc.php');

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
$crop = (io::get('crop') && $x && $y) ? true : false;
if ($image != io::htmlspecialchars(str_replace(array_keys($replace), $replace, $image))) {
	$image = '';
}
//missing datas : send 404
if(!$image || !$module || !$location) {
	//send 404 headers
	header('HTTP/1.x 404 Not Found', true, 404);
	//send image 404
	if (file_exists(PATH_REALROOT_FS.'/img/404.png')) {
		CMS_file::downloadFile(PATH_REALROOT_FS.'/img/404.png');
		exit;
	}
}

//resized image
$pathInfo = pathinfo($image);
$resizedImage = $pathInfo['filename'] .'-'. $x .'-'. $y .($crop ? '-c' : '').'.'. $pathInfo['extension'];
//resized image path
$resizedImagepathFS = PATH_MODULES_FILES_FS . '/' . $module . '/' . $location . '/' . $resizedImage;
//if file already exists, no need to resize file send it
if(file_exists($resizedImagepathFS)) {
	//check If-Modified-Since header if exists then return a 304 if needed
	if (isset($_SERVER['IF-MODIFIED-SINCE'])) {
		$ifModifiedSince = strtotime($_SERVER['IF-MODIFIED-SINCE']);
	} elseif (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
		$ifModifiedSince = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
	}
	if (isset($ifModifiedSince) && filemtime($resizedImagepathFS) <= $ifModifiedSince) {
		$filetype = CMS_file::mimeContentType($resizedImagepathFS);
		$filetype = ($filetype) ? $filetype : 'application/octet-stream';
		
		header('HTTP/1.1 304 Not Modified');
		header('Content-Type: '.$filetype);
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($resizedImagepathFS)) . ' GMT');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT'); //30 days
		header("Cache-Control: must-revalidate");
		header("Pragma: public"); 
		exit;
	}
	
	//Send cache headers
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($resizedImagepathFS)) . ' GMT');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT'); //30 days
	header("Cache-Control: must-revalidate");
	header("Pragma: public"); 
	
	//send file to browser
	CMS_file::downloadFile($resizedImagepathFS);
	exit;
}

//original image path
$imagepathFS = PATH_MODULES_FILES_FS . '/' . $module . '/' . $location . '/' . $image;
//if original image does not exists, send 404
if(!file_exists($imagepathFS)) {
	//send 404 headers
	header('HTTP/1.x 404 Not Found', true, 404);
	//send image 404
	if (file_exists(PATH_REALROOT_FS.'/img/404.png')) {
		CMS_file::downloadFile(PATH_REALROOT_FS.'/img/404.png');
		exit;
	}
}
//file does not exists, so resize original file
$image = new CMS_image($imagepathFS);
//get current file size
$sizeX = $image->getWidth();
$sizeY = $image->getHeight();

//check if file already exists
if (($x && $sizeX > $x) || ($y && $sizeY > $y)) {
	$pathInfo = pathinfo($imagepathFS);
	$newSizeX = $x;
	$newSizeY = $y;
	$resizedImage = $pathInfo['filename'] .'-'. $newSizeX .'-'. $newSizeY .($crop ? '-c' : '').'.'. $pathInfo['extension'];
} else {
	$resizedImage = $image;
}

//resize image
if ($image->resize($newSizeX, $newSizeY, $resizedImagepathFS, true, $crop)) {
	//Send cache headers
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($resizedImagepathFS)) . ' GMT');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT'); //30 days
	header("Cache-Control: must-revalidate");
	header("Pragma: public"); 
	
	//send resized image to browser
	CMS_file::downloadFile($resizedImagepathFS);
} else {
	//send 404 headers
	header('HTTP/1.x 404 Not Found', true, 404);
	//send image 404
	if (file_exists(PATH_REALROOT_FS.'/img/404.png')) {
		CMS_file::downloadFile(PATH_REALROOT_FS.'/img/404.png');
	}
}
?>