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
// $Id: modules-categories-controler.php,v 1.7 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP controler : Receive actions on modules categories
  * Used accross an Ajax request to process one module categories action
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_ACTION_SAVE_ERROR", 178);
define("MESSAGE_ERROR_CATEGORY_RIGHTS", 687);
define("MESSAGE_ERROR_CATEGORY_MOVE", 688);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'move', 'save'));
$categoryId = sensitiveIO::request('category', 'sensitiveIO::isPositiveInteger');
$fatherId = sensitiveIO::request('fatherId', 'sensitiveIO::isPositiveInteger');
$newParentId = sensitiveIO::request('newParent', 'sensitiveIO::isPositiveInteger', 0);
$index = sensitiveIO::request('index', 'sensitiveIO::isPositiveInteger', 0);
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$categoryId && $action != 'save') {
	CMS_grandFather::raiseError('Unknown category ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module for codename : '.$codename);
	$view->show();
}
//CHECKS if user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}
//CHECKS if user has module category manage clearance
if ($categoryId && !$cms_user->hasModuleCategoryClearance($categoryId, CLEARANCE_MODULE_MANAGE)) {
	CMS_grandFather::raiseError('User has no rights on category : '.$categoryId.' for module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_CATEGORY_RIGHTS));
	$view->show();
}

$cms_message = '';
$content = array('success' => false);

switch ($action) {
	case 'save':
		$all_languages = CMS_languagesCatalog::getAllLanguages($codename);
		
		$parentId = sensitiveIO::request('parentId', 'sensitiveIO::isPositiveInteger');
		$icon = sensitiveIO::request('icon');
		$defaultLabel = sensitiveIO::request('label_'.$module->getDefaultLanguageCodename());
		
		// Current category object to manipulate
		$item = new CMS_moduleCategory($categoryId);
		$item->setAttribute('language', $cms_language);
		$item->setAttribute('moduleCodename', $codename);
		if (!$parentId) {
			$parentCategory = $item->getParent();
		} else {
			// Parent category
			$parentCategory = CMS_moduleCategories_catalog::getById($parentId);
		}
		$parentCategory->setAttribute('language', $cms_language);
		
		//check mandatory fields
		if (!$defaultLabel) {
			$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
			break;
		} else {
			// If insertion, must be saved once added to its parent
			$newParentCategory = CMS_moduleCategories_catalog::getById($parentId);
			if (!$newParentCategory->hasError()) {
				// Detach from current category
				$oldParentCategory = $item->getParent();
				if ($item->getID()) {
					if ($oldParentCategory->getID() != $newParentCategory->getID()) {
						if (!CMS_moduleCategories_catalog::detachCategory($item)) {
							$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
						}
						// Attach to new category
						if (!CMS_moduleCategories_catalog::attachCategory($item, $newParentCategory)) {
							$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
						}
					}
				} else {
					// Attach to new category
					if (!CMS_moduleCategories_catalog::attachCategory($item, $newParentCategory)) {
						$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
					}
				}
			} else {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
			}
		}
		// Save all translated datas
		foreach ($all_languages as $aLanguage) {
			$lng = $aLanguage->getCode();
			
			$label = sensitiveIO::request('label_'.$lng);
			$desc = sensitiveIO::request('description_'.$lng);
			$file = sensitiveIO::request('file_'.$lng);
			
			$item->setLabel($label, $aLanguage);
			$item->setDescription($desc, $aLanguage);
			// File upload management
			if ($item->getFilePath($aLanguage, false, PATH_RELATIVETO_WEBROOT, true) && (!$file || pathinfo($file, PATHINFO_BASENAME) != $item->getFilePath($aLanguage, false, PATH_RELATIVETO_WEBROOT, true))) {
				@unlink($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, true));
				$item->setFile('', $aLanguage);
			}
			if ($file && io::strpos($file, PATH_UPLOAD_WR.'/') !== false) {
				//destroy old file if any
				if ($item->getFilePath($aLanguage, false, PATH_RELATIVETO_WEBROOT, true)) {
					@unlink($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, true));
					$item->setFile('', $aLanguage);
				}
				
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $file);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				if (!$item->getID()) { //need item ID
					$item->writeToPersistence();
				}
				//create file path
				$path = $item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM, false).'/';
				$extension = pathinfo($file, PATHINFO_EXTENSION);
				$newBasename = "cat-".$item->getID()."-file-".$lng.".".$extension;
				$newFilename = $path.'/'.$newBasename;
				if (!CMS_file::moveTo($filename, $newFilename)) {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
					break;
				}
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				//set it
				if (!$item->setFile($newBasename, $aLanguage)) {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
					break;
				}
			}
			$item->writeToPersistence();
		}
		if ($item->getIconPath(false, PATH_RELATIVETO_WEBROOT, true) && (!$icon || pathinfo($icon, PATHINFO_BASENAME) != $item->getIconPath(false, PATH_RELATIVETO_WEBROOT, true))) {
			@unlink($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
			$item->setAttribute('icon', '');
		}
		if ($icon && io::strpos($icon, PATH_UPLOAD_WR.'/') !== false) {
			//destroy old file if any
			if ($item->getIconPath(false, PATH_RELATIVETO_WEBROOT, true)) {
				@unlink($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
				$item->setAttribute('icon', '');
			}
			
			//move and rename uploaded file 
			$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $icon);
			$basename = pathinfo($filename, PATHINFO_BASENAME);
			if (!$item->getID()) { //need item ID
				$item->writeToPersistence();
			}
			//create file path
			$path = $item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, false).'/';
			$extension = pathinfo($icon, PATHINFO_EXTENSION);
			$newBasename = "cat-".$item->getID()."-icon.".$extension;
			$newFilename = $path.'/'.$newBasename;
			if (!CMS_file::moveTo($filename, $newFilename)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
				break;
			}
			CMS_file::chmodFile(FILES_CHMOD, $newFilename);
			//set it
			if (!$item->setAttribute('icon', $newBasename)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
				break;
			}
			$item->writeToPersistence();
		}
		if (!$cms_message) {
			if (!$item->writeToPersistence()) {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
				$content = array('success' => true, 'id' => $item->getID());
			}
		}
	break;
	case 'delete':
		$category = new CMS_moduleCategory($categoryId);
		$father = new CMS_moduleCategory($category->getAttribute('parentID'));
		if (CMS_moduleCategories_catalog::detachCategory($category)) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			$content = array('success' => true);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
		}
	break;
	case 'move':
		$category = new CMS_moduleCategory($categoryId);
		$newParent = new CMS_moduleCategory($newParentId);
		if (!$newParentId) {
			$newParent->setAttribute('moduleCodename', $codename);
		}
		$index++; //+1 because interface start index to 0 and system start it to 1
		if (CMS_moduleCategories_catalog::moveCategory($category, $newParent, $index)) { 
			$content = array('success' => true);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_CATEGORY_MOVE);
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