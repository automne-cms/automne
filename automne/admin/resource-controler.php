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
// $Id: resource-controler.php,v 1.6 2009/10/22 16:26:26 sebastien Exp $

/**
  * PHP page : Receive resource updates
  * Used accross an Ajax request to update a resource
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_ERROR_MODULE_RIGHTS",570);
define("MESSAGE_ERROR_ELEMENT_LOCKED",704);
define("MESSAGE_ERROR_ELEMENT_REALY_LOCKED",705);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_XML);
//This file is an admin file. Interface must be secure
$view->setSecure();

$resourceId = sensitiveIO::request('resource', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$action = sensitiveIO::request('action', array('unlock'));

//load module
if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module error for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

//load resource
$resource = $module->getResourceByID($resourceId);
if (!is_object($resource) || $resource->hasError()) {
	CMS_grandFather::raiseError('Cannot find resource '.$resourceId.' for module : '.$codename);
	$view->show();
}
if (!method_exists($resource, 'getStatus')) {
	CMS_grandFather::raiseError('Resource '.$resourceId.' for module : '.$codename.' is not an Automne resource ...');
	$view->show();
}
//do action on resource

//check for lock
if ($action != 'unlock' && $resource->getLock() && $resource->getLock() != $cms_user->getUserId()) {
	CMS_grandFather::raiseError('Object '.$resourceId.' of module '.$codename.' is currently locked by another user and can\'t be updated.');
	$lockuser = CMS_profile_usersCatalog::getByID($resource->getLock());
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_ELEMENT_LOCKED, array($lockuser->getFullName())));
	$view->show();
}
$initialStatus = $resource->getStatus()->getHTML(false, $cms_user, $codename, $resource->getID());
switch ($action) {
	case 'unlock':
		if ($resource->getLock() && $resource->getLock() != $cms_user->getUserId() && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			CMS_grandFather::raiseError('Object '.$resourceId.' of module '.$codename.' is currently locked by another user and can\'t be unlocked.');
			$lockuser = CMS_profile_usersCatalog::getByID($resource->getLock());
			$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_ELEMENT_REALY_LOCKED, array($lockuser->getFullName())));
			$view->show();
		}
		if ($resource->getLock()) {
			$resource->unlock();
		}
	break;
	default:
		CMS_grandFather::raiseError('Unknown action '.$action.' to do for resource '.$resourceId.' with value : '.$value);
		$view->show();
	break;
}
//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$status = $resource->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $resource->getID());
//if page status is changed
if ($status != $initialStatus) {
	//Replace all the status icons by the new one across the whole interface
	$tinyStatus = $resource->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $resource->getID());
	$statusId = $resource->getStatus()->getStatusId(MOD_STANDARD_CODENAME, $resource->getID());
	$xmlcontent = '
	<status><![CDATA['.$status.']]></status>
	<tinystatus><![CDATA['.$tinyStatus.']]></tinystatus>';
	$view->setContent($xmlcontent);
	$jscontent = '
	Automne.utils.updateStatus(\''.$statusId.'\', response.responseXML.getElementsByTagName(\'status\').item(0).firstChild.nodeValue, response.responseXML.getElementsByTagName(\'tinystatus\').item(0).firstChild.nodeValue, '.($action == 'unlock' ? 'true' : 'false').');
	';
	$view->addJavascript($jscontent);
}
$view->show();
?>