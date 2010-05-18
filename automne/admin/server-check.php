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
// $Id: server-check.php,v 1.4 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP controler : Receive actions on server
  * Used accross an Ajax request to process one server action
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//Controler vars
$action = sensitiveIO::request('action', array('check-files', 'check-htaccess', 'browser-cache-reset', 'polymod-cache-reset'));

define("MESSAGE_PAGE_NO_SERVER_RIGHTS",748);
define("MESSAGE_PAGE_MORE_THAN_THOUSAND",763);
define("MESSAGE_CHECK_ERROR",764);
define("MESSAGE_FILES_ACCESS_ERROR",765);
define("MESSAGE_CHECK_DONE",766);
define("MESSAGE_PAGE_FOLDER_NO",767);
define("MESSAGE_PAGE_FILES_NO",768);
define("MESSAGE_PAGE_DISK_SPACE",769);
define("MESSAGE_OPERATION_DONE",122);
define("MESSAGE_UPDATE_ERROR",178);
define("MESSAGE_CREATION_ERROR",1503);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) { //templates
	CMS_grandFather::raiseError('User has no administration rights');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_PAGE_NO_SERVER_RIGHTS));
	$view->show();
}

$cms_message = '';
$content = '';

switch ($action) {
	case 'check-files':
		@set_time_limit(600);
		$path = PATH_REALROOT_FS;
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		$countFile = 0;
		$countDir = 0;
		$countSize = 0;
		$countError = 0;
		$content = '';
		foreach($objects as $name => $object){
		    if (!$object->isWritable()) {
				$countError++;
				if ($countError < 1000) {
					$content .= '<li class="atm-pic-cancel">'.$name.'</li>';
				} elseif ($countError == 1000) {
					$content .= '<li class="atm-pic-cancel">'.$cms_language->getMessage(MESSAGE_PAGE_MORE_THAN_THOUSAND).'</li>';
				}
			}
			if ($object->isFile()) {
				$countFile++;
			} else {
				$countDir++;
			}
			$countSize += $object->getSize();
		}
		if ($content) {
			$cms_message = $cms_language->getMessage(MESSAGE_CHECK_ERROR);
			$content = '<span class="atm-red">'.$cms_language->getMessage(MESSAGE_FILES_ACCESS_ERROR).'</span><ul class="atm-server">'.$content.'</ul>';
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_CHECK_DONE);
		}
		$filesize = ($countSize < 1073741824) ? round(($countSize/1048576),2).' M' : round(($countSize/1073741824),2).' G';
		$content = $cms_language->getMessage(MESSAGE_PAGE_FOLDER_NO).' <strong>'.$countDir.'</strong><br />
		'.$cms_language->getMessage(MESSAGE_PAGE_FILES_NO).' <strong>'.$countFile.'</strong><br />
		'.$cms_language->getMessage(MESSAGE_PAGE_DISK_SPACE).' <strong>'.$filesize.'</strong><br /><br />'.$content;
	break;
	case 'check-htaccess':
		$automnePatch = new CMS_patch($cms_user);
		if ($automnePatch->automneGeneralScript()) {
			$cms_message = $cms_language->getMessage(MESSAGE_CHECK_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_CHECK_ERROR);
		}
		$return = $automnePatch->getReturn();
		$content = '<ul class="atm-server">';
		foreach ($return as $line) {
			switch($line['type']) {
				case 'verbose':
					$content .= '<li>'.$line['text'].'</li>';
				break;
				case 'report':
					switch ($line['error']) {
						case 0:
							$content .= '<li class="atm-pic-ok">'.$line['text'].'</li>';
						break;
						case 1:
							$content .= '<li class="atm-pic-cancel">'.$line['text'].'</li>';
						break;
					}
				break;
			}
		}
		$content .= '</ul>';
	break;
	case 'browser-cache-reset':
		//update SUBVERSION file
		$file = new CMS_file(PATH_MAIN_FS."/SUBVERSION");
		if ($file->exists()) {
			$date = (int) $file->getContent();
			$date++;
			$file->setContent((string) $date);
			if ($file->writeToPersistence()) {
				$cms_message = $cms_language->getMessage(MESSAGE_OPERATION_DONE);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_UPDATE_ERROR);
			}
		} else {
			if (@file_put_contents(PATH_MAIN_FS."/SUBVERSION" , time()) !== false) {
				CMS_file::chmodFile(FILES_CHMOD, PATH_MAIN_FS."/SUBVERSION");
				$cms_message = $cms_language->getMessage(MESSAGE_OPERATION_DONE);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_CREATION_ERROR);
			}
		}
		//remove JS and CSS cache
		if (!CMS_cache::clearTypeCache('text/javascript') || !CMS_cache::clearTypeCache('text/css')) {
			$cms_message = $cms_language->getMessage(MESSAGE_CREATION_ERROR);
		}
	break;
	case 'polymod-cache-reset':
		//remove polymod cache
		if (CMS_cache::clearTypeCache('polymod')) {
			$cms_message = $cms_language->getMessage(MESSAGE_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_CREATION_ERROR);
		}
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