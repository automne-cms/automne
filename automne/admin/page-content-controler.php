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
// $Id: page-content-controler.php,v 1.10 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP controler : Receive actions on page content
  * Used accross an Ajax request to process one page content action
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_ERROR_LOCKED", 334);
define("MESSAGE_PAGE_ERROR_ADD_ROW", 550);
define("MESSAGE_PAGE_ERROR_DEL_ROW", 551);
define("MESSAGE_PAGE_ERROR_MOV_ROW", 552);
define("MESSAGE_PAGE_ERROR_DEL_BLOCK", 553);
define("MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT", 554);
define("MESSAGE_PAGE_COPY_PASTE_ERROR", 694);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$action = sensitiveIO::request('action', array('add-row', 'del-row', 'move-row', 'move-row-cs', 'clear-block', 'update-row', 'update-block-varchar', 'update-block-text', 'update-block-file', 'update-block-flash', 'update-block-image', 'update-block-link'));
$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$index = sensitiveIO::request('index', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$oldCs = sensitiveIO::request('oldCs');
$currentPage = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());
$blocks = json_decode(sensitiveIO::request('blocks', '', '[]'), true);
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');
$value = sensitiveIO::request('value');
//row actions
$visualMode = sensitiveIO::request('visualMode', array(PAGE_VISUALMODE_FORM, PAGE_VISUALMODE_CLIENTSPACES_FORM), PAGE_VISUALMODE_FORM);
//block file
$filelabel = sensitiveIO::request('filelabel');
$filename = sensitiveIO::request('filename');
//block flash
$width = sensitiveIO::request('flashwidth');
$height = sensitiveIO::request('flashheight');
$name = sensitiveIO::request('flashname');
$version = sensitiveIO::request('flashversion');
$params = sensitiveIO::request('flashparams');
$flashvars = sensitiveIO::request('flashvars');
$attributes = sensitiveIO::request('flashattributes');
//block image
$imagelink = sensitiveIO::request('imagelink');
$imagelabel = sensitiveIO::request('imagelabel');
$zoomname = sensitiveIO::request('zoomname');
//block link
$linktext = sensitiveIO::request('link');

//unset requests to avoid them to have interaction with evaluated page codes
sensitiveIO::unsetRequest(array_keys($_REQUEST));
//try to instanciate the requested page
$cms_page = CMS_tree::getPageByID($currentPage);

//instanciate page and check if user has view rights on it
if (isset($cms_page) && $cms_page->hasError()) {
	CMS_grandFather::raiseError('Error on page : '.$cms_page->getID());
	$view->show();
}
//check for edit rights for user
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on page : '.$cms_page->getID());
	$view->show();
}
//check for lock
if ($cms_page->getLock() && $cms_page->getLock() != $cms_user->getUserId()) {
	CMS_grandFather::raiseError('Page '.$currentPage.' is currently locked by another user and can\'t be updated.');
	$lockuser = CMS_profile_usersCatalog::getByID($cms_page->getLock());
	$view->setActionMessage($cms_language->getMessage(MESSAGE_PAGE_ERROR_LOCKED, array($lockuser->getFullName())));
	$view->show();
}

$initialStatus = $cms_page->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
//page edited status
$edited = false;
switch ($action) {
	case 'add-row':
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
		//generate row unique ID
		$uniqueId = md5(uniqid());
		//add row to CS
		$row = $clientSpace->addRow($rowId, $uniqueId, $index);
		if ($row) {
			$clientSpace->writeToPersistence();
			$datas = $row->getData($cms_language, $cms_page, $clientSpace, $visualMode);
			//instanciate modules treatments for page content tags
			$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
			$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
			$modulesTreatment->setDefinition($datas);
			$datas = $modulesTreatment->treatContent(true);
			//append JS and CSS class needed by modules blocks
			$modules = $row->getModules();
			foreach ($modules as $module) {
				$jsFiles = $module->getJSFiles($cms_page->getID());
				foreach ($jsFiles as $jsFile) {
					$view->addJSFile($jsFile);
				}
				$cssFiles = $module->getCSSFiles($cms_page->getID());
				if (isset($cssFiles['screen'])) {
					foreach ($cssFiles['screen'] as $cssFile) {
						$view->addCSSFile($cssFile);
					}
				}
			}
			
			$view->setContent($datas);
			$edited = true;
		} else {
			CMS_grandFather::raiseError('Can\'t add row type '.$rowId.' in clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$uniqueId);
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_ADD_ROW));
		}
	break;
	case 'del-row':
		//clear all row blocks
		foreach ($blocks as $blockId => $blockClass) {
			if (class_exists($blockClass)) {
				$cms_block = new $blockClass();
				$cms_block->initializeFromBasicAttributes($blockId);
				$cms_block->delFromLocation($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, true);
			}
		}
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
		$success = $clientSpace->delRow($rowId, $rowTag);
		if ($success) {
			$clientSpace->writeToPersistence();
			$edited = true;
		} else {
			CMS_grandFather::raiseError('Can\'t delete row type '.$rowId.' in clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_DEL_ROW));
		}
	break;
	case 'move-row':
		//instanciate the clientspace
		$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
		$success = $clientSpace->moveRow($rowId, $rowTag, $index);
		if ($success) {
			$clientSpace->writeToPersistence();
			$edited = true;
		} else {
			CMS_grandFather::raiseError('Can\'t move row type '.$rowId.' in clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag.' to index '.$index);
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_MOV_ROW));
		}
	break;
	case 'move-row-cs':
		//move all row blocks
		foreach ($blocks as $blockId => $blockClass) {
			if (class_exists($blockClass)) {
				$cms_block = new $blockClass();
				$cms_block->initializeFromBasicAttributes($blockId);
				$cms_block->changeClientSpace($cms_page->getID(), $oldCs, $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
			}
		}
		//instanciate both clientspaces
		$oldClientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $oldCs, $visualMode == PAGE_VISUALMODE_FORM);
		$newClientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
		//remove row from old CS and add it to the new one at queried index
		$success = $oldClientSpace->delRow($rowId, $rowTag);
		$row = $newClientSpace->addRow($rowId, $rowTag, $index);
		if ($success && $row) {
			$oldClientSpace->writeToPersistence();
			$newClientSpace->writeToPersistence();
			$edited = true;
		} else {
			CMS_grandFather::raiseError('Can\'t move row type '.$rowId.' from clientspace '.$oldCs.' to clientspace '.$cs.' at index '.$index.' of page '.$cms_page->getID().' with row id '.$rowTag);
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_MOV_ROW));
		}
	break;
	case 'clear-block':
		//clear block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			$cms_block->delFromLocation($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, true);
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				/*$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				$view->setContent($datas);*/
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM, true);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_DEL_BLOCK));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to delete content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_DEL_BLOCK));
		}
	break;
	case 'update-row':
		//update block content
		if (class_exists($blockClass)) {
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM, true);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	case 'update-block-text':
	case 'update-block-varchar':
		//update block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			if ($action == 'update-block-text') {
				$errors = '';
				if (!sensitiveIO::checkXHTMLValue($value, $errors)) {
					//Send an error to user about his content
					$jscontent = "
					Automne.message.popup({
						msg: 				'".$cms_language->getJsMessage(MESSAGE_PAGE_COPY_PASTE_ERROR).($errors ? "<br /><br />".sensitiveIO::sanitizeJSString($errors) : '')."',
						buttons: 			Ext.MessageBox.OK,
						closable: 			true,
						icon: 				Ext.MessageBox.ERROR
					});";
					$view->addJavascript($jscontent);
					$view->show();
				}
				$value = FCKeditor::createAutomneLinks($value);
			}
			$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, array("value" => $value));
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => ($action != 'update-block-text')));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				if ($action == 'update-block-text') {
					//instanciate modules treatments for page content tags (needed for links)
					$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGEHEADER_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
					$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
					$modulesTreatment->setDefinition($datas);
					$datas = $modulesTreatment->treatContent(true);
				}
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	case 'update-block-file':
		//update block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			//remove the old file if any and if new one is different
			$old_data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
			if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]) && $filename != PATH_MODULES_FILES_STANDARD_WR."/edition/".$old_data["file"]) {
				unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]);
			}
			$data = array(
				'file' => '',
				'label'=> ($filelabel) ? $filelabel : pathinfo($filename, PATHINFO_BASENAME)
			);
			if ($filename && io::strpos($filename, PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $filename);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				$newFilename = $cms_block->getFilePath($basename, $cms_page, $cs, $rowTag, $blockId, true);
				CMS_file::moveTo($filename, $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				$data["file"] = pathinfo($newFilename, PATHINFO_BASENAME);
			} elseif ($filename) {
				//keep old file
				$data["file"] = pathinfo($filename, PATHINFO_BASENAME);
			} else {
				$data["file"] = '';
			}
			$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, $data);
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	case 'update-block-flash':
		//update block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			//remove the old file if any and if new one is different
			if ($filename) {
				$old_data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
				if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]) && $filename != PATH_MODULES_FILES_STANDARD_WR."/edition/".$old_data["file"]) {
					unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]);
				}
			}
			$data = array(
				'file' 		=> '',
				'name' 		=> $name,
				'width' 	=> $width,
				'height' 	=> $height,
				'version' 	=> $version,
				'params'	=> $params,
				'flashvars' => $flashvars,
				'attributes'=> $attributes,
			);
			if ($filename && io::strpos($filename, PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $filename);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				$newFilename = $cms_block->getFilePath($basename, $cms_page, $cs, $rowTag, $blockId, true);
				CMS_file::moveTo($filename, $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				$data["file"] = pathinfo($newFilename, PATHINFO_BASENAME);
			} elseif ($filename) {
				//keep old file
				$data["file"] = pathinfo($filename, PATHINFO_BASENAME);
			} else {
				$data["file"] = '';
			}
			$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, $data);
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	case 'update-block-image':
		//update block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			//remove the old image and zoom files if any and if new one is different
			$old_data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
			if ($filename) {
				if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]) && $filename != PATH_MODULES_FILES_STANDARD_WR."/edition/".$old_data["file"]) {
					unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["file"]);
				}
			}
			if ($zoomname) {
				if (is_file(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["enlargedFile"]) && $zoomname != PATH_MODULES_FILES_STANDARD_WR."/edition/".$old_data["enlargedFile"]) {
					unlink(PATH_MODULES_FILES_STANDARD_FS."/edition/".$old_data["enlargedFile"]);
				}
			}
			$data = array(
				'file' 			=> '',
				'enlargedFile' 	=> '',
				'label' 		=> $imagelabel,
				'externalLink' 	=> '',
			);
			//Image
			if ($filename && io::strpos($filename, PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $filename);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				$newFilename = $cms_block->getFilePath($basename, $cms_page, $cs, $rowTag, $blockId, true);
				CMS_file::moveTo($filename, $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				$data["file"] = pathinfo($newFilename, PATHINFO_BASENAME);
			} elseif ($filename) {
				//keep old file
				$data["file"] = pathinfo($filename, PATHINFO_BASENAME);
			} else {
				$data["file"] = '';
			}
			//Image Zoom
			if ($zoomname && io::strpos($zoomname, PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file 
				$zoomname = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $zoomname);
				$basename = pathinfo($zoomname, PATHINFO_BASENAME);
				$newFilename = $cms_block->getFilePath($basename, $cms_page, $cs, $rowTag, $blockId, true);
				CMS_file::moveTo($zoomname, $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				$data["enlargedFile"] = pathinfo($newFilename, PATHINFO_BASENAME);
			} elseif ($zoomname) {
				//keep old file
				$data["enlargedFile"] = pathinfo($zoomname, PATHINFO_BASENAME);
			} else {
				$data["enlargedFile"] = '';
			}
			//Link
			$link = ($old_data['externalLink']) ? new CMS_href($old_data['externalLink']) : new CMS_href();
			$linkDialog = new CMS_dialog_href($link);
			$linkDialog->create($imagelink, MOD_STANDARD_CODENAME, $cms_page->getID());
			$link = $linkDialog->getHref();
			$data['externalLink'] = $link->getTextDefinition();
			
			$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, $data);
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	case 'update-block-link':
		//update block content
		if (class_exists($blockClass)) {
			$cms_block = new $blockClass();
			$cms_block->initializeFromBasicAttributes($blockId);
			//get old datas
			$old_data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
			//Link
			$link = ($old_data['value']) ? new CMS_href($old_data['value']) : new CMS_href();
			$linkDialog = new CMS_dialog_href($link);
			$linkDialog->create($linktext, MOD_STANDARD_CODENAME, $cms_page->getID());
			$link = $linkDialog->getHref();
			$data['value'] = $link->getTextDefinition();
			
			$cms_block->writeToPersistence($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false, $data);
			//instanciate the clientspace
			$clientSpace = CMS_moduleClientSpace_standard_catalog::getByTemplateAndTagID($tpl, $cs, $visualMode == PAGE_VISUALMODE_FORM);
			//get block's row from CS
			$row = $clientSpace->getRow($rowId, $rowTag);
			if ($row) {
				//get row datas
				$datas = $row->getData($cms_language, $cms_page, $clientSpace, PAGE_VISUALMODE_FORM);
				//instanciate modules treatments for page content tags
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, PAGE_VISUALMODE_FORM, $cms_page);
				$modulesTreatment->setTreatmentParameters(array("language" => $cms_language, 'replaceVars' => true));
				$modulesTreatment->setDefinition($datas);
				$datas = $modulesTreatment->treatContent(true);
				//set datas as returned content
				$view->setContent($datas);
				$edited = true;
			} else {
				CMS_grandFather::raiseError('Can\'t get row type '.$rowId.' from clientspace '.$cs.' of page '.$cms_page->getID().' with row id '.$rowTag);
				$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
			}
		} else {
			CMS_grandFather::raiseError('Can\'t get block class type '.$blockClass.' to update content');
			$view->setActionMessage($cms_language->getJsMessage(MESSAGE_PAGE_ERROR_UPDATE_BLOCK_CONTENT));
		}
	break;
	default:
		CMS_grandFather::raiseError('Unknown action '.$action.' to do for page '.$currentPage);
		$view->show();
	break;
}
//set user message if any
if (isset($cms_message) && $cms_message) {
	$view->setActionMessage($cms_message);
}

//Eval PHP content if any
$content = $view->getContent();
if (io::strpos($content, '<?php') !== false) {
	ob_start();
	$content = sensitiveIO::evalPHPCode($content);
	$return = ob_get_clean();
	$content = $return.$content;
	//set datas as returned content
	$view->setContent($content);
}

$view->show();
?>