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
// $Id: templates-controler.php,v 1.9 2009/11/02 10:33:12 sebastien Exp $

/**
  * PHP controler : Receive actions on templates
  * Used accross an Ajax request to process one user action
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_MALFORMED_DEFINITION_FILE", 840);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES", 799);
define("MESSAGE_ACTION_XML_UPDATED", 732);
define("MESSAGE_ACTION_N_PAGES_REGEN", 733);
define("MESSAGE_ERROR_UNKNOWN_TEMPLATE", 1480);
define("MESSAGE_ACTION_SAVE_DONE", 1481);
define("MESSAGE_ACTION_CREATION_DONE", 1482);
define("MESSAGE_ACTION_SAVE_PRINT_DONE", 1483);
define("MESSAGE_ERROR_NO_PUBLIC_PAGE", 1484);
define("MESSAGE_ACTION_DUPICATION_DONE", 1485);
define("MESSAGE_ERROR_WRITE_TEMPLATE", 1552);

//Controler vars
$action = sensitiveIO::request('action', array('properties', 'definition', 'printcs', 'regenerate', 'copy'));
$templateId = sensitiveIO::request('templateId', '');

//Properties vars vars
$label = sensitiveIO::request('label');
$description = sensitiveIO::request('description');
$image = sensitiveIO::request('image');
$definitionfile = sensitiveIO::request('definitionfile');
$groups = sensitiveIO::request('groups', 'is_array', array());
$newgroups = (sensitiveIO::request('newgroup')) ? array_map('trim', preg_split("/[;,]+/", sensitiveIO::request('newgroup'))) : array();
$selectedWebsites = (sensitiveIO::request('websites')) ? explode(',', sensitiveIO::request('websites')) : array();
$nouserrights = sensitiveIO::request('nouserrights') ? true : false;
//definition
$definition = sensitiveIO::request('definition');
$regenerate = sensitiveIO::request('regenerate') ? true : false;

//printable CS
$printableCS = (sensitiveIO::request('printableCS')) ? explode(',', sensitiveIO::request('printableCS')) : array();

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES));
	$view->show();
}

//load template if any
if (sensitiveIO::isPositiveInteger($templateId)) {
	$template = CMS_pageTemplatesCatalog::getByID($templateId);
	if (!$template || $template->hasError()) {
		CMS_grandFather::raiseError('Unknown template for given Id : '.$templateId);
		$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_TEMPLATE));
		$view->show();
	}
} elseif ($templateId == 'print') {
	$templateFile = new CMS_file(PATH_TEMPLATES_FS."/print.xml");
} else {
	$template = false;
}

$cms_message = '';

switch ($action) {
	case 'properties':
		//Edition
		if (is_a($template, "CMS_pageTemplate") && !$template->hasError()) {
			//rename template and set description
			$template->renameTemplate($label);
			$template->setDescription($description);
			//remove the old file if any and if new one is different
			if ($image) {
				if (is_file(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage())
					 && $image != PATH_TEMPLATES_IMAGES_WR.'/'.$template->getImage()
					 && $template->getImage() != 'nopicto.gif') {
					unlink(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage());
				}
			}
			if ($image && io::strpos($image, PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file
				$image = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $image);
				$basename = pathinfo($image, PATHINFO_BASENAME);
				$movedImage = PATH_TEMPLATES_IMAGES_FS.'/pt'.$template->getID().'_'.SensitiveIO::sanitizeAsciiString($basename);
				CMS_file::moveTo($image, $movedImage);
				CMS_file::chmodFile(FILES_CHMOD, $movedImage);
				$image = pathinfo($movedImage, PATHINFO_BASENAME);
			} elseif ($image && $template->getImage()) {
				//keep old file
				$image = $template->getImage();
			} elseif (!$image && $template->getImage()) {
				//remove old file
				if ($template->getImage() != 'nopicto.gif') {
					@unlink(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage());
				}
				$image = 'nopicto.gif';
			} else {
				$image = 'nopicto.gif';
			}
			$template->setImage($image);
			//groups
			$template->delAllGroups();
			foreach ($groups as $group) {
				$template->addGroup($group);
			}
			if ($newgroups) {
				foreach ($newgroups as $group) {
					$template->addGroup($group);
				}
				if ($nouserrights) {
					CMS_profile_usersCatalog::denyTemplateGroupsToUsers($newgroups);
				}
			}
			//websites denied
			$websites = CMS_websitesCatalog::getAll();
			$deniedWebsites = array();
			foreach ($websites as $id => $website) {
				if (!in_array($id, $selectedWebsites)) {
					$deniedWebsites[] = $id;
				}
			}
			$template->delAllWebsiteDenied();
			foreach ($deniedWebsites as $deniedWebsite) {
				$template->denyWebsite($deniedWebsite);
			}
			//XML definition file
			if ($definitionfile && io::strpos($definitionfile, PATH_UPLOAD_WR.'/') !== false) {
				//read uploaded file
				$definitionfile = new CMS_file($definitionfile, CMS_file::WEBROOT);
				$template->setDebug(false);
                $template->setLog(false);
				$error = $template->setDefinition($definitionfile->readContent());
				if ($error !== true) {
	            	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
				}
			}
			if (!$cms_message && !$template->hasError()) {
				if ($template->writeToPersistence()) {
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (edit base data)");
					$content = array('success' => true);
					$cms_message = $cms_language->getMessage(MESSAGE_ACTION_SAVE_DONE);
					$view->setContent($content);
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_ERROR_WRITE_TEMPLATE);
				}
			}
		} elseif (is_a($template, "CMS_pageTemplate") && $template->hasError()) {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_TEMPLATE);
		} else {
			//CREATION
			$template = new CMS_pageTemplate();
			if ($label) {
				$template->setlabel($label);
				$template->setDebug(false);
                $template->setLog(false);
			}
			if (!$cms_message) {
				//description
				$template->setDescription($description);
				//remove the old file if any and if new one is different
				if ($image) {
					if (is_file(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage())
						 && $image != PATH_TEMPLATES_IMAGES_WR.'/'.$template->getImage()
						 && $template->getImage() != 'nopicto.gif') {
						unlink(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage());
					}
				}
				if ($image && io::strpos($image, PATH_UPLOAD_WR.'/') !== false) {
					//move and rename uploaded file
					$image = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $image);
					$basename = pathinfo($image, PATHINFO_BASENAME);
					$movedImage = PATH_TEMPLATES_IMAGES_FS.'/'.SensitiveIO::sanitizeAsciiString($basename);
					CMS_file::moveTo($image, $movedImage);
					CMS_file::chmodFile(FILES_CHMOD, $movedImage);
					$image = pathinfo($movedImage, PATHINFO_BASENAME);
				} elseif ($template->getImage()) {
					//keep old file
					$image = $template->getImage();
				} else {
					$image = 'nopicto.gif';
				}
				$template->setImage($image);
				//groups
				$template->delAllGroups();
				foreach ($groups as $group) {
					$template->addGroup($group);
				}
				if ($newgroups) {
					foreach ($newgroups as $group) {
						$template->addGroup($group);
					}
					if ($nouserrights) {
						CMS_profile_usersCatalog::denyTemplateGroupsToUsers($newgroups);
					}
				}
				//websites denied
				$websites = CMS_websitesCatalog::getAll();
				$deniedWebsites = array();
				foreach ($websites as $id => $website) {
					if (!in_array($id, $selectedWebsites)) {
						$deniedWebsites[] = $id;
					}
				}
				$template->delAllWebsiteDenied();
				foreach ($deniedWebsites as $deniedWebsite) {
					$template->denyWebsite($deniedWebsite);
				}
				//XML definition file
				if ($definitionfile && io::strpos($definitionfile, PATH_UPLOAD_WR.'/') !== false) {
					//read uploaded file
					$definitionfile = new CMS_file($definitionfile, CMS_file::WEBROOT);
					$template->setDebug(false);
	                $template->setLog(false);
					$error = $template->setDefinition($definitionfile->readContent());
					if ($error !== true) {
		            	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
					}
				}
				if (!$cms_message && !$template->hasError()) {
					if ($template->writeToPersistence()) {
						$log = new CMS_log();
						$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (create template)");
						$content = array('success' => array('templateId' => $template->getID()));
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_CREATION_DONE);
						$view->setContent($content);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_ERROR_WRITE_TEMPLATE);
					}
				}
			} else {
				//clean template
				$template->destroy(true);
			}
		}
	break;
	case 'definition':
		//Update template definition
		if (isset($template) && is_a($template, "CMS_pageTemplate") && !$template->hasError()) {
			//Replace space indentation : set four spaces as a tab
			$definition = str_replace('    ', "\t", $definition);
			$error = $template->setDefinition($definition);
			if ($error !== true) {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
			} else {
				if ($template->writeToPersistence()) {
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (update template definition)");
					$content = array('success' => true);
					if ($regenerate) {
						//submit all pages of this template to the regenerator
						$pages = $template->getPages(true);
						$pagesIds = array();
						foreach ($pages as $page) {
							if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
								$pagesIds[] = $page->getID();
							}
						}
						if ($pagesIds) {
							CMS_tree::submitToRegenerator($pagesIds, true);
						}
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_XML_UPDATED).($pagesIds ? ',<br />'.$cms_language->getMessage(MESSAGE_ACTION_N_PAGES_REGEN, array(sizeof($pagesIds))) : '.');
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_XML_UPDATED);
					}
					$view->setContent($content);
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_ERROR_WRITE_TEMPLATE);
				}
			}
		} elseif (is_a($templateFile, "CMS_file") && $templateFile->exists()) {
			//definition parsing test
			$domdocument = new CMS_DOMDocument();
			try {
				$domdocument->loadXML($definition);
			} catch (DOMException $e) {
				$cms_message = $e->getMessage();
			}

			if (!$cms_message) {
				$templateFile->setContent($definition);
				$templateFile->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : Print template");

				$content = array('success' => true);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_SAVE_PRINT_DONE);
				$view->setContent($content);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$cms_message;
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_TEMPLATE);
		}
	break;
	case 'printcs':
		//Update template definition
		if (is_a($template, "CMS_pageTemplate") && !$template->hasError()) {
			$template->setPrintingClientSpaces($printableCS);
			$template->writeToPersistence();
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (update printable clientspaces)");

			//submit all pages of this template to the regenerator
			$pages = $template->getPages(true);
			$pagesIds = array();
			foreach ($pages as $page) {
				if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
					$pagesIds[] = $page->getID();
				}
			}
			if ($pagesIds) {
				CMS_tree::submitToRegenerator($pagesIds, true);
			}

			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_SAVE_DONE).($pagesIds ? ',<br />'.$cms_language->getMessage(MESSAGE_ACTION_N_PAGES_REGEN, array(sizeof($pagesIds))) : '.');
			$view->setContent($content);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_TEMPLATE);
		}
	break;
	case 'regenerate' :
		//submit all pages of this template to the regenerator
		$pages = $template->getPages(true);
		$pagesIds = array();
		foreach ($pages as $page) {
			if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
				$pagesIds[] = $page->getID();
			}
		}
		if ($pagesIds) {
			CMS_tree::submitToRegenerator($pagesIds, true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_N_PAGES_REGEN, array(sizeof($pagesIds)));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_NO_PUBLIC_PAGE);
		}
	break;
	case 'copy':
		if (is_a($template, "CMS_pageTemplate") && !$template->hasError()) {
			//Dupplicate selected template with given label
			$label = 'Copie de '.$template->getLabel();
			$template = CMS_pageTemplatesCatalog::getCloneFromID($templateId, $label);

			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$label." (create template)");

			$content = array('success' => array('templateId' => $template->getID()));
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_DUPICATION_DONE, array($label));
			$view->setContent($content);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_TEMPLATE);
		}
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>