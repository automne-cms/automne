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
// $Id: modules-categories-controler.php,v 1.1 2009/04/02 13:55:54 sebastien Exp $

/**
  * PHP controler : Receive actions on modules categories
  * Used accross an Ajax request to process one module categories action
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'move'));
$categoryId = sensitiveIO::request('category', 'sensitiveIO::isPositiveInteger');
$newParentId = sensitiveIO::request('newParent', 'sensitiveIO::isPositiveInteger', 0);
$index = sensitiveIO::request('index', 'sensitiveIO::isPositiveInteger', 0);
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$categoryId) {
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
	$view->setActionMessage($cms_message->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}
//CHECKS if user has module category manage clearance
if (!$cms_user->hasModuleCategoryClearance($categoryId, CLEARANCE_MODULE_MANAGE)) {
	CMS_grandFather::raiseError('User has no rights on category : '.$categoryId.' for module : '.$codename);
	$view->setActionMessage('Vous n\'avez pas le droit d\'administrer cette catégorie ...');
	$view->show();
}

$cms_message = '';
$content = array('success' => false);

switch ($action) {
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
			$cms_message = 'Erreur durant le déplacement de la catégorie ...';
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