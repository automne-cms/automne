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
// $Id: rows-controler.php,v 1.6 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP controler : Receive actions on templates
  * Used accross an Ajax request to process one user action
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_MALFORMED_DEFINITION_FILE", 840);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS", 706);
define("MESSAGE_ERROR_UNKNOWN_ROW", 729);
define("MESSAGE_ACTION_ROW_SAVED", 730);
define("MESSAGE_ACTION_ROW_CREATED", 731);
define("MESSAGE_ACTION_XML_UPDATED", 732);
define("MESSAGE_ACTION_N_PAGES_REGEN", 733);
define("MESSAGE_ACTION_NO_PAGES", 734);
define("MESSAGE_ERROR_WRITE_ROW", 1551);

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
$regenerate = sensitiveIO::request('regenerate') ? true : false;

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has row edition clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	CMS_grandFather::raiseError('User has no rights on rows editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS));
	$view->show();
}

//load template if any
if (sensitiveIO::isPositiveInteger($rowId)) {
	$row = CMS_rowsCatalog::getByID($rowId);
	if (!$row || $row->hasError()) {
		CMS_grandFather::raiseError('Unknown template row for given Id : '.$rowId);
		$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_ROW));
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
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_ROW);
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
		if ($newimage && io::strpos($newimage, PATH_UPLOAD_WR.'/') !== false) {
			//move and rename uploaded file
			$newimage = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $newimage);
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
			if ($row->writeToPersistence()) {
				$log = new CMS_log();
				if (!$creation) {
					$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row : ".$row->getLabel()." (edit base data)");
					$content = array('success' => true);
					$cms_message = $cms_language->getMessage(MESSAGE_ACTION_ROW_SAVED);
				} else {
					$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row  : ".$row->getLabel()." (create row)");
					$content = array('success' => array('rowId' => $row->getID()));
					$cms_message = $cms_language->getMessage(MESSAGE_ACTION_ROW_CREATED);
				}
				$view->setContent($content);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_ERROR_WRITE_ROW);
			}
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
				if ($row->writeToPersistence()) {
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW, $cms_user, "Row : ".$row->getLabel()." (update row definition)");
					$content = array('success' => true);
					if ($regenerate) {
						//submit all public pages using this row to the regenerator
						$pagesIds = CMS_rowsCatalog::getPagesByRow($rowId, false, true);
						if ($pagesIds) {
							CMS_tree::submitToRegenerator($pagesIds, true);
						}
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_XML_UPDATED).($pagesIds ? ',<br />'.$cms_language->getMessage(MESSAGE_ACTION_N_PAGES_REGEN, array(sizeof($pagesIds))) : '.');
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_XML_UPDATED);
					}
					$view->setContent($content);
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_ERROR_WRITE_ROW);
				}
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_ROW);
		}
	break;
	case 'regenerate' :
		//submit all public pages using this row to the regenerator
		$pagesIds = CMS_rowsCatalog::getPagesByRow($rowId, false, true);
		if ($pagesIds) {
			CMS_tree::submitToRegenerator($pagesIds, true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_N_PAGES_REGEN, array(sizeof($pagesIds)));
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_NO_PAGES);
		}
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>