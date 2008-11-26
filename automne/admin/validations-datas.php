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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: validations-datas.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Load validations pending for given module and editions
  * Used accross an Ajax request.
  * Return formated validations infos in JSON format
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_VALIDATION_PENDING", 338);


//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//get current editions and module
/*
	$editions = (isset($_REQUEST['editions']) && sensitiveIO::isPositiveInteger($_REQUEST['editions'])) ? $_REQUEST['editions'] : false;
	$module = (isset($_REQUEST['module']) && sensitiveIO::sanitizeAsciiString($_REQUEST['module'])) ? $_REQUEST['module'] : false;
	$resource = (isset($_REQUEST['resource']) && sensitiveIO::sanitizeAsciiString($_REQUEST['resource'])) ? $_REQUEST['resource'] : false;
	$withValidationsPending = (isset($_REQUEST['withValidationsPending']) && $_REQUEST['withValidationsPending']) ? true : false;
	$start = (isset($_REQUEST['start']) && sensitiveIO::isPositiveInteger($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
	$limit = (isset($_REQUEST['limit']) && sensitiveIO::isPositiveInteger($_REQUEST['limit'])) ? $_REQUEST['limit'] : 0;
*/
$editions = sensitiveIO::request('editions', 'sensitiveIO::isPositiveInteger');
$module = sensitiveIO::request('module', 'sensitiveIO::sanitizeAsciiString');
$resource = sensitiveIO::request('resource', 'sensitiveIO::sanitizeAsciiString');
$withValidationsPending = (sensitiveIO::request('withValidationsPending')) ? true : false;
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', 0);

if ($editions && $module) {
	$cms_module = CMS_modulesCatalog::getByCodename($module);
}

$validationsDatas = array();
$validationsDatas['validations'] = array();

if (!isset($cms_module) || !$cms_module || $cms_module->hasError()) {
	CMS_grandFather::raiseError('Module or editions not set or do not exists ...');
	$view->setContent($validationsDatas);
	$view->show();
}

//grab the validations
if (method_exists($cms_module, "getValidationByID") && method_exists($cms_module, "getValidationsInfoByEditions")) {
	//new validations system, more efficient
	$validations = $cms_module->getValidationsInfoByEditions($cms_user, $editions);
	$newValidationMethod = true;
} else {
	//old validations system (Automne < 3.1.1), keeped for modules compatibility, do not use pagination
	$validations = $cms_module->getValidationsByEditions($cms_user, $editions);
	$newValidationMethod = false;
	
	//Clean old DB validations
	CMS_resourceValidation::cleanOldValidations();
}
//get an array of editors infos for a given resource
function getResourceEditors($validation) {
	global $all_editions;
	//Editors
	$editors = array();
	$stack = $validation->getEditorsStack();
	if (is_a($stack, "CMS_stack")) {
		$editions = $validation->getEditions();
		$users = array();
		foreach ($all_editions as $aEdition) {
			if ($editions & $aEdition) {
				$elements = $stack->getElementsWithOneValue($aEdition, 2);
				foreach ($elements as $user_edition) {
					$users[] = $user_edition[0];
				}
			}
		}
		if ($users) {
			$users = array_unique($users);
			foreach ($users as $usr) {
				$tmp_user = CMS_profile_usersCatalog::getByID($usr) ;
				if (is_a($tmp_user, 'CMS_profile_user')) {
					$editors[] = array(
						$tmp_user->getUserId(),
						$tmp_user->getFullName()
					);
				}
			}
		}
	}
	return $editors;
}

$itemCount = 0;
$all_editions = CMS_resourceStatus::getAllEditions();

//if a resource is selected, place it in first position of the list
$selectedValidation = false;
if ($resource) {
	foreach ($validations as $key => $validation) {
		if ($validation->getResourceID() == $resource) {
			$selectedValidation = $validation;
			unset($validations[$key]);
		}
	}
	if ($selectedValidation) {
		//for the new validations system, get the complete validation object.
		if ($newValidationMethod) {
			$selectedValidation = $cms_module->getValidationByID($selectedValidation->getResourceID(),$cms_user, $editions);
		}
		$validationsDatas['validations'][] = array(
			'validationId'	=> $selectedValidation->getID(),
			'resource'		=> $selectedValidation->getResourceID(),
			'shortLabel'	=> $selectedValidation->getValidationShortLabel(),
			'label'			=> $selectedValidation->getValidationLabel(),
			'status'		=> $selectedValidation->getStatusRepresentation(true),
			'actions'		=> $selectedValidation->getHelpUrls(),
			'editors'		=> getResourceEditors($selectedValidation),
			'accept'		=> $selectedValidation->hasValidationOption(VALIDATION_OPTION_ACCEPT),
			'refuse'		=> $selectedValidation->hasValidationOption(VALIDATION_OPTION_REFUSE),
			'transfer'		=> $selectedValidation->hasValidationOption(VALIDATION_OPTION_TRANSFER)
		);
		$itemCount++;
	}
}
//loop over validations to get all required infos
foreach ($validations as $validation) {
	if (($itemCount >= $start && $itemCount < ($start + $limit)) || !$newValidationMethod) {
		//for the new validations system, get the complete validation object.
		if ($newValidationMethod) {
			$validation = $cms_module->getValidationByID($validation->getResourceID(),$cms_user, $editions);
		}
		$validationsDatas['validations'][] = array(
			'validationId'	=> $validation->getID(),
			'resource'		=> $validation->getResourceID(),
			'shortLabel'	=> $validation->getValidationShortLabel(),
			'label'			=> $validation->getValidationLabel(),
			'status'		=> $validation->getStatusRepresentation(true),
			'actions'		=> $validation->getHelpUrls(),
			'editors'		=> getResourceEditors($validation),
			'accept'		=> $validation->hasValidationOption(VALIDATION_OPTION_ACCEPT),
			'refuse'		=> $validation->hasValidationOption(VALIDATION_OPTION_REFUSE),
			'transfer'		=> $validation->hasValidationOption(VALIDATION_OPTION_TRANSFER)
		);
	}
	$itemCount++;
}
//total validations count
$validationsDatas['totalCount'] = sizeof($validations);
//all validators except current user (for validation transfer)
$validators = CMS_profile_usersCatalog::getValidators($cms_module->getCodename());
$validatorsInfos = array();
foreach ($validators as $validator) {
	if ($validator->getUserId() != $cms_user->getUserId()) {
		$validatorsInfos[] = array(
			$validator->getUserId(),
			$validator->getFullName()
		);
	}
}
$validationsDatas['validators'] = $validatorsInfos;
$validationsDatas['module'] = $cms_module->getCodename();
$validationsDatas['editions'] = $editions;

if ($withValidationsPending) {
	//MODULES VALIDATIONS PENDING
	$modulesValidations = CMS_modulesCatalog::getAllValidations($cms_user,true);
	$validationsCount = 0;
	
	//validations types
	$validationsDatas['validationsType'] = array();
	$count = 1;
	$selectedValidations = false;
	if ($modulesValidations && sizeof($modulesValidations)) {
		foreach ($modulesValidations as $codename => $moduleValidations) {
			//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
			if ($codename == MOD_STANDARD_CODENAME) {
				$modLabel = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
			} else {
				$mod = CMS_modulesCatalog::getByCodename($codename);
				$modLabel = $mod->getLabel($cms_language);
			}
			
			//sort the validations by type label
			$validationsSorted = array();
			foreach ($moduleValidations as $validation) {
				$validationsSorted[$validation->getValidationTypeLabel()][] = $validation;
			}
			ksort($validationsSorted);
			
			foreach ($validationsSorted as $label => $validations) {
				$validation = $validations[0];
				$validationsDatas['validationsType'][] = array(
					'id' 		=> $count,
					'module'	=> $codename,
					'editions'	=> $validation->getEditions(),
					'label' 	=> $modLabel.' : '.$label.' : '.sizeof($validations).' '.$cms_language->getMessage(MESSAGE_PAGE_VALIDATION_PENDING),
				);
				if ($codename == $module && $validation->getEditions() == $editions) {
					$selectedValidations = $count;
				}
				$count++;
			}
		}
	}
}

$view->setContent($validationsDatas);
$view->show();
?>