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
  * PHP controler : Receive upload files
  * Used accross a SWFUpload request to process one uploaded file
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

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
$image = sensitiveIO::request('image');

$return = array(
	'error'		=> '',
	'filepath'	=> '',
	'filename'	=> '',
);

$image = new CMS_file($image, CMS_file::WEBROOT);
if (!$image->exists()) {
	CMS_grandFather::raiseError('Can\'t find queried image : '.$image->getFilename());
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_NO_IMG);
	$view->setContent($return);
	$view->show();
}

list($oWidth, $oHeight) = getimagesize($image->getFilename());

switch($image->getExtension()) {
	case 'gif':
		if (!function_exists('imagecreatefromgif')) {
			CMS_grandFather::raiseError('Can\'t find imagecreatefromgif, please install GD library.');
			$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_GIF_SUPPORT);
			$view->setContent($return);
			$view->show();
		}
		$simg = @imagecreatefromgif($image->getFilename());
		$dest = io::substr($image->getFilename(), 0, -4).'.gif';
	break;
	case 'jpg':
	case 'jpeg':
	case 'jpe':
		if (!function_exists('imagecreatefromjpeg')) {
			CMS_grandFather::raiseError('Can\'t find imagecreatefromjpeg, please install GD library.');
			$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_JPG_SUPPORT);
			$view->setContent($return);
			$view->show();
		}
		$simg = @imagecreatefromjpeg($image->getFilename());
		$dest = $image->getFilename();
	break;
	case 'png':
		if (!function_exists('imagecreatefrompng')) {
			CMS_grandFather::raiseError('Can\'t find imagecreatefrompng, please install GD library.');
			$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_PNG_SUPPORT);
			$view->setContent($return);
			$view->show();
		}
		$simg = @imagecreatefrompng($image->getFilename());
		$dest = io::substr($image->getFilename(), 0, -4).'.png';
	break;
	default:
		CMS_grandFather::raiseError('unknown image type : '.$image->getExtension());
		$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_ALL_FILES_SUPPORT).' '.$image->getExtension().'.';
		$view->setContent($return);
		$view->show();
	break;
}
if ($oWidth != $width || $oHeight != $height) {
	$dimg = @imagecreatetruecolor($width, $height);
	@imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $width, $height, $oWidth, $oHeight);
} else {
	$dimg = $simg;
}
$cWidth = ($width - $cropLeft) - $cropRight;
$cHeight = ($height - $cropTop) - $cropBottom;
if ($cWidth != $width || $cHeight != $height) {
	$cimg = @imagecreatetruecolor($cWidth, $cHeight);
	@imagecopyresampled($cimg, $dimg, 0, 0, $cropLeft, $cropTop, $cWidth, $cHeight, $cWidth, $cHeight);
	
	switch($image->getExtension()) {
		case 'gif':
			@imagegif($cimg,$dest);
		break;
		case 'jpg':
		case 'jpeg':
		case 'jpe':
			@imagejpeg($cimg,$dest,95);
		break;
		case 'png':
			@imagepng($cimg,$dest);
		break;
	}
} else {
	switch($image->getExtension()) {
		case 'gif':
			@imagegif($dimg,$dest);
		break;
		case 'jpg':
		case 'jpeg':
		case 'jpe':
			@imagejpeg($dimg,$dest,95);
		break;
		case 'png':
			@imagepng($dimg,$dest);
		break;
	}
}
if (!is_file($dest)) {
	CMS_grandFather::raiseError('Error during treatment of file '.$image->getFilename().', please check GD library.');
	$return['error'] = $cms_language->getJsMessage(MESSAGE_PAGE_LIB_GD_VERIF);
	$view->setContent($return);
	$view->show();
}
//delete old file
if ($dest != $image->getFilename()) {
	$image->delete();
}
$newimage = new CMS_file($dest);
//set new image infos and return
clearstatcache();
$return['filesize'] = $newimage->getFileSize();
$return['filepath'] = $newimage->getFilePath(CMS_file::WEBROOT);
$return['filename'] = $newimage->getFilename(false);

$view->setContent($return);
$view->show();
?>