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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: upload-controler.php,v 1.2 2008/12/18 10:36:44 sebastien Exp $

/**
  * PHP controler : Receive upload files
  * Used accross a SWFUpload request to process one uploaded file
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Workaround for the Flash Cookie Bug
if (isset($_POST[session_name()])) {
	$_COOKIE[session_name()] = urldecode($_POST[session_name()]);
	session_id($_COOKIE[session_name()]);
}
if (isset($_POST['Automne_4_autologin'])) {
	$_COOKIE['Automne_4_autologin'] = urldecode($_POST['Automne_4_autologin']);
}
//Workaround for the Flash User Agent Bug
if (isset($_POST['userAgent'])) {
	$_SERVER['HTTP_USER_AGENT'] = urldecode($_POST['userAgent']);
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);

//define upload constant according to SWFupload constants
define('SFWUPLOAD_SECURITY_ERROR', -230);
define('SFWUPLOAD_UPLOAD_LIMIT_EXCEEDED', -240);
define('SFWUPLOAD_UPLOAD_FAILED', -250);
define('SFWUPLOAD_FILE_VALIDATION_FAILED', -270);
define('SFWUPLOAD_FILE_CANCELLED', -280);
define('SFWUPLOAD_UPLOAD_STOPPED', -290);

$fileDatas = array(
	'error' 		=> 0,
	'filename'		=> '',
	'filepath'		=> '',
	'filesize'		=> '',
	'fileicon'		=> '',
	'success'		=> false
);

// Check the upload
if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
	CMS_grandFather::raiseError('Uploaded file has error : '.print_r($_FILES["Filedata"], true));
	$fileDatas['error'] = SFWUPLOAD_UPLOAD_FAILED;
	$view->setContent($fileDatas);
	$view->show();
}
//move uploaded file (and rename it if needed)
$count = 2;
$name = $_FILES["Filedata"]["name"];
while (file_exists(PATH_MAIN_FS.'/upload/'.$name)) {
	$pathinfo = pathinfo($_FILES["Filedata"]["name"]);
	$name = $pathinfo['filename'].'-'.$count++.'.'.$pathinfo['extension'];
}
if (!@move_uploaded_file($_FILES["Filedata"]["tmp_name"], PATH_MAIN_FS.'/upload/'.$name)) {
	CMS_grandFather::raiseError('Can\'t move uploaded file to : '.PATH_MAIN_FS.'/upload/'.$name);
	$fileDatas['error'] = SFWUPLOAD_FILE_VALIDATION_FAILED;
	$view->setContent($fileDatas);
	$view->show();
}
$file = new CMS_file(PATH_MAIN_FS.'/upload/'.$name);
$file->chmod(FILES_CHMOD);

//check file extension
if (in_array($file->getExtension(), explode(',', FILE_UPLOAD_EXTENSIONS_DENIED))) {
	$file->delete();
	$fileDatas['error'] = SFWUPLOAD_SECURITY_ERROR;
	$view->setContent($fileDatas);
	$view->show();
}
//return file datas
$fileDatas = array(
	'error' 		=> 0,
	'filename'		=> $file->getName(false),
	'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
	'filesize'		=> $file->getFileSize(),
	'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
	'extension'		=> $file->getExtension(),
	'success'		=> true
);
CMS_grandFather::raiseError(print_r($fileDatas,true));
$view->setContent($fileDatas);
$view->show();
?>