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
// $Id: templates-files-controler.php,v 1.4 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP controler : Receive actions on modules categories
  * Used accross an Ajax request to process one module categories action
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

function checkNode($value) {
	return $value != 'source' && io::strpos($value, '..') === false;
}
function checkFile($value) {
	return io::strpos($value, '..') === false && io::strpos($value, '/') === false && io::strpos($value, '\\') === false;
}

define("MESSAGE_PAGE_STYLESHEET", 1486);
define("MESSAGE_PAGE_WYSIWYG", 1487);
define("MESSAGE_PAGE_JAVASCRIPT", 1488);
define("MESSAGE_ACTION_DELETE_FILE", 1500);
define("MESSAGE_ERROR_DELETE_FILE", 1501);
define("MESSAGE_ACTION_UPDATE_FILE", 1502);
define("MESSAGE_ERROR_UPDATE_FILE", 1503);
define("MESSAGE_ACTION_CREATE_FILE", 1504);
define("MESSAGE_ERROR_CREATE_FILE_EXTENSION", 1505);
define("MESSAGE_ERROR_CREATE_FILE_EXISTS", 1506);
define("MESSAGE_PAGE_TXT", 273);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'update', 'create'));
$node = sensitiveIO::request('node', 'checkNode', '');
$definition = sensitiveIO::request('definition');
$filelabel = sensitiveIO::request('filelabel', 'checkFile', '');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has module clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on page templates ...');
	$view->show();
}
if (!$node && $action != 'create') {
	CMS_grandFather::raiseError('Unknown node ...');
	$view->show();
}

$allowedFiles = array(
	'css' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_STYLESHEET), 'class' => 'atm-css'),
	'xml' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_WYSIWYG), 'class' => 'atm-xml'),
	'js' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_JAVASCRIPT), 'class' => 'atm-js'),
	'txt' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_TXT), 'class' => 'atm-txt'),
);

$file = PATH_REALROOT_FS.'/'.$node;
if (!is_file($file) && $action != 'create') {
	CMS_grandFather::raiseError('Action on folders is not allowed');
	$view->show();
}
if ($action != 'create') {
	$extension = io::strtolower(pathinfo($file, PATHINFO_EXTENSION));
	if (!isset($allowedFiles[$extension])) {
		CMS_grandFather::raiseError('Action on this type of file is not allowed.');
		$view->show();
	}
}
$cms_message = '';
$content = array('success' => false);

switch ($action) {
	case 'delete':
		if (@unlink($file)) {
			$content = array('success' => true);
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_DELETE_FILE, $cms_user, "File : ".$node);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_DELETE_FILE, array($node));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_DELETE_FILE).' '.$node;
		}
	break;
	case 'update':
		if (file_exists($file)) {
			$file = new CMS_file($file);
			if ($file->setContent($definition) && $file->writeToPersistence()) {
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_FILE, $cms_user, "File : ".$node);
				$content = array('success' => true);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_UPDATE_FILE, array($node));
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UPDATE_FILE).' '.$node;
			}
		}
	break;
	case 'create':
		if (is_dir($file) && $filelabel) {
			if (!is_file($file.'/'.$filelabel)) {
				$extension = io::strtolower(pathinfo($file.'/'.$filelabel, PATHINFO_EXTENSION));
				if (isset($allowedFiles[$extension])) {
					$file = new CMS_file($file.'/'.$filelabel);
					if ($file->setContent($definition) && $file->writeToPersistence()) {
						$log = new CMS_log();
						$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_FILE, $cms_user, "File : ".$node.'/'.$filelabel);
						$content = array('success' => true);
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_CREATE_FILE, array($filelabel));
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UPDATE_FILE).' '.$filelabel;
					}
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_ERROR_CREATE_FILE_EXTENSION, array($filelabel));
				}
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_ERROR_CREATE_FILE_EXISTS, array($filelabel));
			}
		}
	break;
	default:
		CMS_grandFather::raiseError('Unknown action to do ...');
		$view->show();
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
if ($content) {
	$view->setContent($content);
}
$view->show();
?>