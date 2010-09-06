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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: file.php,v 1.3 2010/03/08 16:45:48 sebastien Exp $

/**
  * Automne files download handler
  * This file is used by protected modules to handle documents downloading.
  * 
  * @package Automne
  * @subpackage apache
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// *************************************************************************
// **   FILE HANDLER. THIS PHP CODE IS NEEDED TO DOWNLOAD ALL DOCUMENTS   **
// *************************************************************************

$auto_prepend_file = ini_get_all();
//get original auto_prepend_file if any and append it before this file
if ($auto_prepend_file['auto_prepend_file']['global_value']) {
	include_once($auto_prepend_file['auto_prepend_file']['global_value']);
}
//set realpath for requested file
$scriptFilename = realpath($_SERVER['SCRIPT_FILENAME']);
//check for file call method (this file can only be called using auto_prepend_file PHP directive)
if ($scriptFilename == realpath(__FILE__)) {
	die('Error : This file cannot be called directly ...');
}
if (!isset($auto_prepend_file['auto_prepend_file']['local_value']) || realpath($auto_prepend_file['auto_prepend_file']['local_value']) != realpath(__FILE__)) {
	die('Error : This file cannot be called directly ...');
}

//disactive HTML compression
define("ENABLE_HTML_COMPRESSION", false);
//add Automne configuration files
require_once(dirname(__FILE__).'/cms_rc_frontend.php');
//check for requested file existence
if (!file_exists($scriptFilename) || !is_file($scriptFilename)) {
	header('Location: '.PATH_SPECIAL_PAGE_NOT_FOUND_WR);
	exit;
}
//check for requested file location
if (strpos(pathinfo($scriptFilename, PATHINFO_DIRNAME), realpath(PATH_MODULES_FILES_FS)) !== 0) {
	header('Location: '.PATH_FORBIDDEN_WR);
	exit;
}
//check for requested file extension
if (in_array(pathinfo($scriptFilename, PATHINFO_EXTENSION), explode(',', FILE_UPLOAD_EXTENSIONS_DENIED))) {
	header('Location: '.PATH_FORBIDDEN_WR);
	exit;
}

//get requested file infos
$pathinfo = pathinfo($_SERVER['SCRIPT_NAME']);

//try to get original filename from 3 format of filenames
$filename = '';
if (preg_match('#^p[0-9]+_[a-z0-9]{32}.*#',$pathinfo['basename'])) {
	//standard module
	$filename = preg_replace ('#^p[0-9]+_[a-z0-9]{32}(.*)#', '\1', $pathinfo['basename']);
} elseif (preg_match('#^r[0-9]+_[0-9]+_.*#',$pathinfo['basename'])) {
	//polymod modules
	$filename = preg_replace ('#^r[0-9]+_[0-9]+_(.*)#', '\1', $pathinfo['basename']);
} elseif (preg_match('#^r[0-9]+_.*#',$pathinfo['basename'])) {
	//old modules
	$filename = preg_replace ('#^r[0-9]+_(.*)#', '\1', $pathinfo['basename']);
} else {
	//no match, keep filename
	$filename = $pathinfo['basename'];
}
//if APPLICATION_ENFORCES_ACCESS_CONTROL is active
if (APPLICATION_ENFORCES_ACCESS_CONTROL) {
	//Try to get module codename
	$codename = '';
	if (preg_match('#^'.PATH_MODULES_FILES_WR.'/[^/]+/(archived|deleted|edited|edition|public)$#',$pathinfo['dirname'])) {
		$codename = preg_replace ('#^'.PATH_MODULES_FILES_WR.'/([^/]+)/(archived|deleted|edited|edition|public)$#', '\1', $pathinfo['dirname']);
	}
	//Then check user rights on module
	if ($codename) {
		if ($codename == 'standard') {
			//get page id
			$pageId = '';
			if (preg_match('#^p[0-9]+_[a-z0-9]{32}.*#',$pathinfo['basename'])) {
				$pageId = preg_replace ('#^p([0-9]+)_[a-z0-9]{32}.*#', '\1', $pathinfo['basename']);
			}
			if (sensitiveIO::isPositiveInteger($pageId)) {
				if (!is_object($cms_user)) {
					//no user => LOGIN
					header('Location: '.PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
					exit;
				} elseif (!$cms_user->hasPageClearance($pageId, CLEARANCE_PAGE_VIEW)) {
					if ($cms_user->getLogin() == DEFAULT_USER_LOGIN) {
						//no rights and anonymous => LOGIN
						header('Location: '.PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
					} else {
						//no rights and logged => 403
						header('Location: '.PATH_FORBIDDEN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
					}
					exit;
				}
			}
		} elseif (CMS_modulesCatalog::isPolymod($codename)) {
			//get object item id
			$itemID = '';
			if (preg_match('#^r[0-9]+_[0-9]+_.*#',$pathinfo['basename'])) {
				$itemID = preg_replace ('#^r([0-9]+)_[0-9]+_.*#', '\1', $pathinfo['basename']);
			}
			if (sensitiveIO::isPositiveInteger($itemID)) {
				if (!is_object($cms_user)) {
					//no user => LOGIN
					header('Location: '.PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
					exit;
				} else {
					$public = (preg_match('#.*/(edited|edition)$#',$pathinfo['dirname'])) ? false : true;
					$item = CMS_poly_object_catalog::getObjectByID($itemID, false, $public);
					if (!$item->userHasClearance($cms_user,CLEARANCE_MODULE_VIEW, true)) {
						if ($cms_user->getLogin() == DEFAULT_USER_LOGIN) {
							//no rights and anonymous => LOGIN
							header('Location: '.PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
						} else {
							//no rights and logged => 403
							header('Location: '.PATH_FORBIDDEN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
						}
						exit;
					}
				}
			}
		}
	}
}

//send file to browser
CMS_file::downloadFile($scriptFilename);
?>