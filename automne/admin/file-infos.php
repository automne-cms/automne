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
// $Id: file-infos.php,v 1.3 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP controler : Return file infos for a given filename
  * Used accross a fileupload request to process one uploaded file
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

$file = sensitiveIO::sanitizeAsciiString(sensitiveIO::request('file'));
$module = sensitiveIO::sanitizeAsciiString(sensitiveIO::request('module'));
$visualisation = sensitiveIO::sanitizeAsciiString(sensitiveIO::request('visualisation'));

$fileDatas = array(
	'filename'		=> '',
	'filepath'		=> '',
	'filesize'		=> '',
	'fileicon'		=> '',
	'module'		=> $module,
	'visualisation'	=> $visualisation
);

if (!$file || !$module) {
	$view->setContent($fileDatas);
	$view->show();
}
//check for the given file for queried module
if (!file_exists(PATH_MODULES_FILES_FS.'/'.$module.'/'.$visualisation.'/'.$file)) {
	$view->setContent($fileDatas);
	$view->show();
}
$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$module.'/'.$visualisation.'/'.$file);

//return file datas
$fileDatas = array(
	'filename'		=> $file->getName(false),
	'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
	'filesize'		=> $file->getFileSize(),
	'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
	'extension'		=> $file->getExtension(),
	'module'		=> $module,
	'visualisation'	=> $visualisation
);

$view->setContent($fileDatas);
$view->show();
?>