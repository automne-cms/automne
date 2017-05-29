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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * PHP page : Load polyobjects items datas
  * Used accross an Ajax request.
  * Return formated items infos in JSON format
  *
  * @package Automne
  * @subpackage polymod
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_PAGE_NO_CATEGORIES", 529);
define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$objectId = sensitiveIO::request('objectId', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$fieldId = sensitiveIO::request('fieldId', 'sensitiveIO::isPositiveInteger');
$query = sensitiveIO::request('query', '');

$objectsDatas = array();
$objectsDatas['objects'] = array();

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->setContent($objectsDatas);
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module || !$module->isPolymod()) {
	CMS_grandFather::raiseError('Unknown module or module is not polymod for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->setContent($objectsDatas);
	$view->show();
}
//CHECKS objectId
if (!$objectId && !$fieldId) {
	CMS_grandFather::raiseError('Missing objectId to list in module '.$codename);
	$view->setContent($objectsDatas);
	$view->show();
} elseif (!$objectId && $fieldId) {
	$objectId = CMS_poly_object_catalog::getObjectIDForField($fieldId);
}

//load current object definition
$object = CMS_poly_object_catalog::getObjectDefinition($objectId);
//load fields objects for object
$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());

if ($objectFields[$fieldId]) {
	$objectType = $objectFields[$fieldId]->getTypeObject();
	if (method_exists($objectType, 'getAllCategoriesAsArray')) {
		// Get categories
		$a_all_categories = $objectType->getAllCategoriesAsArray($cms_language, false, $codename, CLEARANCE_MODULE_EDIT, false, true);
		if (is_array($a_all_categories) && $a_all_categories) {
			$objectsDatas['objects'][] = array(
				'id'			=> '',
				'label'			=> ' ',
			);
			foreach($a_all_categories as $id => $label) {
				if (!$query || stripos(io::sanitizeAsciiString(io::decodeEntities($label)), io::sanitizeAsciiString(trim($query))) !== false) {
					$objectsDatas['objects'][] = array(
						'id'			=> $id,
						'label'			=> io::decodeEntities($label),
					);
				}
			}
		} else {
			$objectsDatas['objects'][] = array(
				'id'			=> '',
				'label'			=> $cms_language->getMessage(MESSAGE_PAGE_NO_CATEGORIES, false, MOD_POLYMOD_CODENAME),
			);
		}
	}
}
$view->setContent($objectsDatas);
$view->show();
?>