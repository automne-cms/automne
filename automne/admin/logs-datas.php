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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: logs-datas.php,v 1.3 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load logs datas
  * Used accross an Ajax request.
  * Return formated logs infos in JSON format
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$pageId = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', 0);
$type = sensitiveIO::request('type', array('all','login','resource','admin','email'), 'all');
$sort = sensitiveIO::request('sort', array('datetime', 'user', 'action'), 'datetime');
$dir = sensitiveIO::request('dir', array('ASC','DESC'), 'DESC');
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', $_SESSION["cms_context"]->getRecordsPerPage());
$delete = sensitiveIO::request('del') ? true : false;

if ($delete && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$delete = false;
}

$logsDatas = array();
$logsDatas['logs'] = array();

if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	CMS_grandFather::raiseError('User has no logs management rights ...');
	$view->show();
}
if (!$type) {
	CMS_grandFather::raiseError('Unknown type of logs to display ...');
	$view->show();
}
switch($type) {
	case 'login':
		$types = CMS_log_catalog::getLoginActions();
	break;
	case 'email':
		$types = CMS_log_catalog::getEmailActions();
	break;
	case 'admin':
		$types = CMS_log_catalog::getMiscActions();
	break;
	case 'resource':
		$types = CMS_log_catalog::getResourceActions();
	break;
	case 'all':
	default:
		$types = CMS_log_catalog::getAllActions();
	break;
}
if ($delete) {
	CMS_log_catalog::purge($codename, $pageId, $userId, $types);
} else {
	
	//search logs
	$logs = CMS_log_catalog::search($codename, $pageId, $userId, $types, $start, $limit, $sort, io::strtolower($dir), $returnCount = false);
	$actions = CMS_log_catalog::getAllActions();
	//loop over users to get all required infos
	foreach ($logs as $log) {
		$dt = $log->getDatetime();
		$user = $log->getUser();
		$resource = $log->getResource();
		if ($resource) {
			$status = $log->getResourceStatusAfter()->getHTML(true,false,false,false,false);
			$module = $log->getModule();
			$element = '';
			if ($resource && !$resource->hasError()) {
				$method = '';
				if (method_exists($module, 'getRessourceNameMethod') && $module->getRessourceNameMethod()) {
					$method = $module->getRessourceNameMethod();
				} elseif (method_exists($resource, 'getLabel')) {
					$method = 'getLabel';
				} elseif (method_exists($resource, 'getTitle')) {
					$method = 'getTitle';
				}
				if ($method) {
					$element = $resource->{$method}();
				}
				if (!$element) {
					$element = $resource->getID();
				} else {
					$element .= ' ('.$resource->getID().')';
				}
				//get resource type label
				if (method_exists($module, 'getRessourceTypeLabelMethod') && $module->getRessourceTypeLabelMethod()) {
					$element = $resource->{$module->getRessourceTypeLabelMethod()}($cms_language).' : '.$element;
				} else {
					$element .= ' ('.$module->getLabel($cms_language).')';
				}
			}
		} else {
			$element = $status = '';
		}
		$datas = array(
			'id'			=> $log->getID(),
			'element'		=> $element,
			'datetime'		=> $dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s'),
			'action'		=> $cms_language->getMessage(array_search($log->getLogAction(), $actions)),
			'user'			=> $user->getFullname(),
			'userId'		=> $user->getUserId(),
			'status'		=> $status,
			'comment'		=> $log->getTextData(),
		);
		$logsDatas['logs'][] = $datas;
	}
	//total logs count for search
	$logsDatas['totalCount'] = CMS_log_catalog::search($codename, $pageId, $userId, $types = array(), $start, $limit, 'datetime', 'desc', true);
}
$view->setContent($logsDatas);
$view->show();
?>