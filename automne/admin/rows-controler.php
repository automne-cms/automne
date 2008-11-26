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
// $Id: rows-controler.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

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
$action = sensitiveIO::request('action', array('properties', 'definition', 'regenerate'));
$rowId = sensitiveIO::request('rowId', '');

//Properties vars vars
$label = sensitiveIO::request('label');
$description = sensitiveIO::request('description');
$image = sensitiveIO::request('image');
$newimage = sensitiveIO::request('newimage');
$groups = sensitiveIO::request('groups', 'is_array', array());
$newgroups = (sensitiveIO::request('newgroup')) ? array_map('trim', preg_split("/[;,]+/", sensitiveIO::request('newgroup'))) : array();
$selectedTemplates = (sensitiveIO::request('templates')) ? explode(',', sensitiveIO::request('templates')) : array();
$nouserrights = sensitiveIO::request('nouserrights') ? true : false;
//definition
$definition = sensitiveIO::request('definition');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//CHECKS user has row edition clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	CMS_grandFather::raiseError('User has no rights on rows editions');
	$view->setActionMessage('Vous n\'avez pas le droit de gérer les modèles de rangées ...');
	$view->show();
}

//load template if any
if (sensitiveIO::isPositiveInteger($rowId)) {
	$row = CMS_rowsCatalog::getByID($rowId);
	if (!$row || $row->hasError()) {
		CMS_grandFather::raiseError('Unknown template row for given Id : '.$rowId);
		$view->setActionMessage('Le modèle de rangée à modifier n\'existe pas ou possède une erreur.');
		$view->show();
	}
}

$cms_message = '';

switch ($action) {
	case 'properties':
		//Edition
		$creation = false;
		if (!isset($row)) {
			//CREATION
			$row = new CMS_row();
			$creation = true;
		} elseif (is_a($row, "CMS_row") && $row->hasError()) {
			$cms_message = 'Le modèle de rangée à modifier n\'existe pas ou possède une erreur.';
			break;
		}
		//rename template and set description
		$row->setLabel($label);
		$row->setDescription($description);
		if ($creation) {
			//set basic definition
			$row->setDefinition('<row></row>');
		}
		//remove the old file if any and if new one is different
		if ($newimage && strpos($newimage, PATH_MAIN_WR.'/upload/') !== false) {
			//move and rename uploaded file
			$newimage = str_replace(PATH_MAIN_WR.'/upload/', PATH_MAIN_FS.'/upload/', $newimage);
			$basename = pathinfo($newimage, PATHINFO_BASENAME);
			$movedImage = PATH_TEMPLATES_ROWS_FS.'/images/'.SensitiveIO::sanitizeAsciiString($basename);
			CMS_file::moveTo($newimage, $movedImage);
			CMS_file::chmodFile(FILES_CHMOD, $movedImage);
			$image = pathinfo($movedImage, PATHINFO_BASENAME);
		} elseif ($image) {
			$image = pathinfo($image, PATHINFO_BASENAME);
		}
		$row->setImage($image);
		//groups
		$row->delAllGroups();
		foreach ($groups as $group) {
			$row->addGroup($group);
		}
		if ($newgroups) {
			foreach ($newgroups as $group) {
				$row->addGroup($group);
			}
			if ($nouserrights) {
				CMS_profile_usersCatalog::denyRowGroupsToUsers($newgroups);
			}
		}
		//selected templates
		$row->setFilteredTemplates($selectedTemplates);
		if (!$cms_message && !$row->hasError()) {
			$row->writeToPersistence();
			$log = new CMS_log();
			if (!$creation) {
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row : ".$row->getLabel()." (edit base data)");
				$content = array('success' => true);
				$cms_message = 'Rangée enregistrée avec succès.';
			} else {
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row  : ".$row->getLabel()." (create row)");
				$content = array('success' => array('rowId' => $row->getID()));
				$cms_message = 'Rangée créé avec succès.';
			}
			$view->setContent($content);
		}
	break;
	case 'definition':
		//Update template definition
		if (is_a($row, "CMS_row") && !$row->hasError()) {
			//Replace space indentation : set four spaces as a tab
			$definition = str_replace('    ', "\t", $definition);
			$error = $row->setDefinition($definition);
			if ($error !== true) {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
			} else {
				$row->writeToPersistence();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row : ".$row->getLabel()." (update row definition)");
				//submit all public pages using this row to the regenerator
				$pagesIds = CMS_rowsCatalog::getPagesByRow($rowId, false, true);
				if ($pagesIds) {
					CMS_tree::submitToRegenerator($pagesIds, true);
				}
				$content = array('success' => true);
				$cms_message = 'Définition XML mise à jour avec succès'.($pagesIds ? ',<br />'.sizeof($pagesIds).' pages en cours de régénération.' : '.');
				$view->setContent($content);
			}
		} else {
			$cms_message = 'Le modèle de rangée à modifier n\'existe pas ou possède une erreur.';
		}
	break;
	case 'regenerate' :
		//submit all public pages using this row to the regenerator
		$pagesIds = CMS_rowsCatalog::getPagesByRow($rowId, false, true);
		if ($pagesIds) {
			CMS_tree::submitToRegenerator($pagesIds, true);
			$cms_message = sizeof($pagesIds).' pages en cours de régénération.';
		} else {
			$cms_message = 'Aucune page publique n\'emploie ce modèle ...';
		}
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>