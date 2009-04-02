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
// $Id: validations-controler.php,v 1.3 2009/04/02 13:55:55 sebastien Exp $

/**
  * PHP controler : Receive validations actions
  * Used accross an Ajax request to process one or more validations pending
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT", 234);
define("MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY", 235);
define("MESSAGE_PAGE_ACTION_EMAIL_REFUSE_SUBJECT", 236);
define("MESSAGE_PAGE_ACTION_EMAIL_REFUSE_BODY", 237);
define("MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_SUBJECT", 238);
define("MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_BODY", 239);
define("MESSAGE_PAGE_ERROR_MODULE", 240);
define("MESSAGE_PAGE_ERROR_PROCESS", 241);

define("MESSAGE_PAGE_ERROR_VALIDATION", 418);
define("MESSAGE_PAGE_VALIDATIONS_MADE", 419);
define("MESSAGE_PAGE_VALIDATION_MADE", 420);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);

$action = sensitiveIO::request('action');
$module = sensitiveIO::request('module');
$editions = sensitiveIO::request('editions', 'sensitiveIO::isPositiveInteger');
$resource = sensitiveIO::request('resource', 'sensitiveIO::isPositiveInteger');
$transferUser = sensitiveIO::request('transferUser', 'sensitiveIO::isPositiveInteger');
$comment = sensitiveIO::request('comment');
$validationId = sensitiveIO::request('validationId');
$validationIds = (sensitiveIO::request('validationIds')) ? explode(',',$_REQUEST['validationIds']) : array($validationId);

if (isset($_REQUEST['accept']) && in_array($_REQUEST['accept'], array('accept', 'refuse', 'transfer'))) {
	switch($_REQUEST['accept']) {
		case 'accept':
			$acceptStatus = VALIDATION_OPTION_ACCEPT;
		break;
		case 'refuse':
			$acceptStatus = VALIDATION_OPTION_REFUSE;
		break;
		case 'transfer':
			$acceptStatus = VALIDATION_OPTION_TRANSFER;
		break;
		default:
			$acceptStatus = false;
		break;
	}
} else {
	$acceptStatus = false;
}

//check for user rights on module
if (!$cms_user->hasValidationClearance($module)) {
	CMS_grandFather::raiseError('User has no validation rights on module '.$module.' ...');
	$view->show();
}
//set return to false by default
$content = array('success' => false);
$cms_message = $cms_language->getJsMessage(MESSAGE_PAGE_ERROR_VALIDATION);
$jscontent = '';

//ignore user abort to avoid interuption of process
@ignore_user_abort(true);
@set_time_limit(9000);

switch ($action) {
	case 'validateById':
		$validationIds = array();
		//load module
		$mod = CMS_modulesCatalog::getByCodename($module);
		//load module resource by ID
		$resource = $mod->getResourceByID($resource);
		//Clean old validations
		CMS_resourceValidation::cleanOldValidations();
		//get validation
		if (is_object($resource) && !$resource->hasError()) {
			if (method_exists($mod, "getValidationByID")) {
				$validation = $mod->getValidationByID($resource->getID(),$cms_user);
				if (is_a($validation,"CMS_resourceValidation") && !$validation->hasError()) {
					$validationIds[] = $validation->getID();
				}
			} else {
				$validations = $mod->getValidations($cms_user);
				foreach ($validations as $aValidation) {
					if ($aValidation->getResourceID() == $resource->getID()) {
						$validationIds[] = $aValidation->getID();
					}
				}
			}
		}
		if (!sizeof($validationIds)) {//stop
			CMS_grandFather::raiseError('No validation founded for module '.$module.' and resource ID '.$resource->getID());
			break;
		}
		$acceptStatus = VALIDATION_OPTION_ACCEPT;
	case 'batch-validate':
		$acceptStatus = VALIDATION_OPTION_ACCEPT;
	case "validate":
		foreach ($validationIds as $validationId) {
			//get validation
			$validation = CMS_resourceValidationsCatalog::getValidationInstance($validationId,$cms_user);
			if (!is_a($validation, "CMS_resourceValidation")) {
				CMS_grandFather::raiseError('invalid validation Id '.$validationId.' ...');
				$view->show();
			}
			//ask the module to process the validation
			$mod = CMS_modulesCatalog::getByCodename($validation->getModuleCodename());
			if (is_a($mod, "CMS_module")) {
				$res = $validation->getResource();
				if ($mod->processValidation($validation, $acceptStatus)) {
					//send the emails
					$languages = CMS_languagesCatalog::getAllLanguages();
					$subjects = array();
					$bodies = array();
					switch ($acceptStatus) {
						case VALIDATION_OPTION_ACCEPT:
							//send an email to all the editors
							$args = array($validation->getValidationLabel()." (ID : ".$validation->getResourceID().")", $mod->getLabel($cms_language), SensitiveIO::sanitizeHTMLString($comment));
							$editorsStack = $validation->getEditorsStack();
							$elements = $editorsStack->getElements();
							$users = array();
							foreach ($elements as $element) {
								$usr = CMS_profile_usersCatalog::getByID($element[0]);
								if (is_a($usr, 'CMS_profile_user') && !$usr->hasError()) {
									$users[] = $usr;
								}
							}
							foreach ($languages as $language) {
								$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_SUBJECT);
								$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ACCEPT_BODY, $args);
							}
						break;
						case VALIDATION_OPTION_REFUSE:
							//send an email to all the editors
							$args = array($validation->getValidationLabel()." (ID : ".$validation->getResourceID().")", $mod->getLabel($cms_language), SensitiveIO::sanitizeHTMLString($comment));
							$editorsStack = $validation->getEditorsStack();
							$elements = $editorsStack->getElements();
							$users = array();
							foreach ($elements as $element) {
								$usr = CMS_profile_usersCatalog::getByID($element[0]);
								if (is_a($usr, 'CMS_profile_user') && !$usr->hasError()) {
									$users[] = $usr;
								}
							}
							foreach ($languages as $language) {
								$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_REFUSE_SUBJECT);
								$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_REFUSE_BODY, $args);
							}
						break;
						case VALIDATION_OPTION_TRANSFER:
							if ($transferUser) {
								//send an email to the transferred validator
								$args = array($cms_user->getFullName(),
												$validation->getValidationLabel()." (ID : ".$validation->getResourceID().")",
												$mod->getLabel($cms_language),
												SensitiveIO::sanitizeHTMLString($comment));
								$users = array(CMS_profile_usersCatalog::getByID($transferUser));
								foreach ($languages as $language) {
									$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_SUBJECT);
									$bodies[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_TRANSFER_BODY, $args);
								}
							}
						break;
					}
					$group_email = new CMS_emailsCatalog();
					$group_email->setUserMessages($users, $bodies, $subjects);
					$group_email->sendMessages();
					
					$log = new CMS_log();
					$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION, $cms_user, $validation->getModuleCodename(), $res->getStatus(), "", $res);
					//check if resource still exists
					$res = $validation->getResource();
					if ($res->getStatus()) {
						//Replace all the status icons by the new one across the whole interface
						$status = $res->getStatus()->getHTML(false, $cms_user, $validation->getModuleCodename(), $res->getID());
						$tinyStatus = $res->getStatus()->getHTML(true, $cms_user, $validation->getModuleCodename(), $res->getID());
						$statusId = $res->getStatus()->getStatusId($validation->getModuleCodename(), $res->getID());
						$jscontent .= '
						Automne.utils.updateStatus(\''.$statusId.'\', \''.sensitiveIO::sanitizeJSString($status).'\', \''.sensitiveIO::sanitizeJSString($tinyStatus).'\');';
					} else {
						$jscontent .= '
						Automne.utils.removeResource(\''.$validation->getModuleCodename().'\', \''.$res->getID().'\');';
					}
				}
			}
		}
		$cms_message = (sizeof($validationIds) > 1) ? $cms_language->getJSMessage(MESSAGE_PAGE_VALIDATIONS_MADE) : $cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION_MADE);
		$content = array('success' => true);
		$view->addJavascript($jscontent);
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->setContent($content);
$view->show();
?>