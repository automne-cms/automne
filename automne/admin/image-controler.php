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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: image-controler.php,v 1.4 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP controler : Receive uploaded images
  * Used accross a SWFUpload request to process one uploaded image
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
set_time_limit(300);
define("MESSAGE_PAGE_NO_IMG", 555);
define("MESSAGE_PAGE_GIF_SUPPORT", 556);
define("MESSAGE_PAGE_JPG_SUPPORT", 557);
define("MESSAGE_PAGE_PNG_SUPPORT", 558);
define("MESSAGE_PAGE_ALL_FILES_SUPPORT", 559);
define("MESSAGE_PAGE_LIB_GD_VERIF", 560);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

$width = sensitiveIO::request('width', 'sensitiveIO::isPositiveInteger', 0);
$height = sensitiveIO::request('height', 'sensitiveIO::isPositiveInteger', 0);
$cropTop = sensitiveIO::request('cropTop', 'sensitiveIO::isPositiveInteger', 0);
$cropBottom = sensitiveIO::request('cropBottom', 'sensitiveIO::isPositiveInteger', 0);
$cropLeft = sensitiveIO::request('cropLeft', 'sensitiveIO::isPositiveInteger', 0);
$cropRight = sensitiveIO::request('cropRight', 'sensitiveIO::isPositiveInteger', 0);
$autocrop = sensitiveIO::request('autocrop') ? true : false;
$image = sensitiveIO::request('image');

$return = array(
	'error'		=> '',
	'filepath'	=> '',
	'filename'	=> '',
);

$image = new CMS_image($image, CMS_file::WEBROOT);
//Check image
if (!$image->exists()) {
	CMS_grandFather::raiseError('Can\'t find queried image : '.$image->getFilename());
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_NO_IMG);
	$view->setContent($return);
	$view->show();
}
if (!function_exists('imagecreatefromgif')) {
	CMS_grandFather::raiseError('Can\'t find imagecreatefromgif, please install GD library.');
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_GIF_SUPPORT);
	$view->setContent($return);
	$view->show();
}
if (!function_exists('imagecreatefromjpeg')) {
	CMS_grandFather::raiseError('Can\'t find imagecreatefromjpeg, please install GD library.');
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_JPG_SUPPORT);
	$view->setContent($return);
	$view->show();
}
if (!function_exists('imagecreatefrompng')) {
	CMS_grandFather::raiseError('Can\'t find imagecreatefrompng, please install GD library.');
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_PNG_SUPPORT);
	$view->setContent($return);
	$view->show();
}
//Resize image
if (!$image->resize($width, $height, '', true, $autocrop)) {
	CMS_grandFather::raiseError('Error during treatment of file '.$image->getFilename().', please check GD library.');
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_LIB_GD_VERIF);
	$view->setContent($return);
	$view->show();
}
//Crop image if needed
if ($cropTop || $cropBottom || $cropLeft || $cropRight) {
	if (!$image->crop($cropTop, $cropBottom, $cropLeft, $cropRight)) {
		CMS_grandFather::raiseError('Error during treatment of file '.$image->getFilename().', please check GD library.');
		$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_LIB_GD_VERIF);
		$view->setContent($return);
		$view->show();
	}
}
$newimage = new CMS_file($image->getFilename());
//set new image infos and return
clearstatcache();
$return['filesize'] = $newimage->getFileSize();
$return['filepath'] = $newimage->getFilePath(CMS_file::WEBROOT);
$return['filename'] = $newimage->getFilename(false);

$view->setContent($return);
$view->show();
?>