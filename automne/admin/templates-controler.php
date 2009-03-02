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
// $Id: templates-controler.php,v 1.3 2009/03/02 11:25:15 sebastien Exp $

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
//printable CS
$printableCS = (sensitiveIO::request('printableCS')) ? explode(',', sensitiveIO::request('printableCS')) : array();

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage('Vous n\'avez pas le droit de gérer les modèles de pages ...');
	$view->show();
}

//load template if any
if (sensitiveIO::isPositiveInteger($templateId)) {
	$template = CMS_pageTemplatesCatalog::getByID($templateId);
	if (!$template || $template->hasError()) {
		CMS_grandFather::raiseError('Unknown template for given Id : '.$templateId);
		$view->setActionMessage('Le modèle à modifier n\'existe pas ou possède une erreur.');
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
			if ($image && strpos($image, PATH_MAIN_WR.'/upload/') !== false) {
				//move and rename uploaded file
				$image = str_replace(PATH_MAIN_WR.'/upload/', PATH_MAIN_FS.'/upload/', $image);
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
				unlink(PATH_TEMPLATES_IMAGES_FS.'/'.$template->getImage());
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
			if ($definitionfile && strpos($definitionfile, PATH_MAIN_WR.'/upload/') !== false) {
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
				$template->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (edit base data)");
				$content = array('success' => true);
				$cms_message = 'Modèle enregistré avec succès.';
				$view->setContent($content);
			}
		} elseif (is_a($template, "CMS_pageTemplate") && $template->hasError()) {
			$cms_message = 'Le modèle à modifier n\'existe pas ou possède une erreur.';
		} else {
			//CREATION
			$template = new CMS_pageTemplate();
			//check XML definition file
			if ($definitionfile && strpos($definitionfile, PATH_MAIN_WR.'/upload/') !== false) {
				if ($label) {
					$template->setlabel($label);
					//read uploaded file
					$definitionfile = new CMS_file($definitionfile, CMS_file::WEBROOT);
					$template->setDebug(false);
	                $template->setLog(false);
					$error = $template->setDefinition($definitionfile->readContent());
					if ($error !== true) {
						$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
					}
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
					if ($image && strpos($image, PATH_MAIN_WR.'/upload/') !== false) {
						//move and rename uploaded file
						$image = str_replace(PATH_MAIN_WR.'/upload/', PATH_MAIN_FS.'/upload/', $image);
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
					if (!$cms_message && !$template->hasError()) {
						$template->writeToPersistence();
						$log = new CMS_log();
						$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (create template)");
						$content = array('success' => array('templateId' => $template->getID()));
						$cms_message = 'Modèle créé avec succès.';
						$view->setContent($content);
					}
				} else {
					//clean template
					$template->destroy(true);
				}
			} else {
				$cms_message = 'Erreur : Définition XML manquante !';
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
				$template->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (update template definition)");
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
				$cms_message = 'Définition XML mise à jour avec succès'.($pagesIds ? ',<br />'.sizeof($pagesIds).' pages en cours de régénération.' : '.');
				$view->setContent($content);
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
				$cms_message = 'Modèle d\'impression mis à jour avec succès.';
				$view->setContent($content);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$cms_message;
			}
		} else {
			$cms_message = 'Le modèle à modifier n\'existe pas ou possède une erreur.';
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
			$cms_message = 'Modèle mis à jour avec succès'.($pagesIds ? ',<br />'.sizeof($pagesIds).' pages en cours de régénération.' : '.');
			$view->setContent($content);
		} else {
			$cms_message = 'Le modèle à modifier n\'existe pas ou possède une erreur.';
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
			$cms_message = sizeof($pagesIds).' pages en cours de régénération.';
		} else {
			$cms_message = 'Aucune page publique n\'emploie ce modèle ...';
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
			$cms_message = 'Modèle dupliqué avec succès.<br />Le nouveau modèle \''.$label.'\' est inactif.';
			$view->setContent($content);
		} else {
			$cms_message = 'Le modèle à modifier n\'existe pas ou possède une erreur.';
		}
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>