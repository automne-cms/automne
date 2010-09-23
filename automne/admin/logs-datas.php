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
if (isset($_GET['export'])) {
	//disactive HTML compression
	define("ENABLE_HTML_COMPRESSION", false);
}

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//is this call for an export
$export = sensitiveIO::request('export') ? true : false;

//load interface instance
$view = CMS_view::getInstance();

if (!$export) {
	//set default display mode for this page
	$view->setDisplayMode(CMS_view::SHOW_JSON);
	//This file is an admin file. Interface must be secure
	$view->setSecure();
} else {
	//set default display mode for this page
	$view->setDisplayMode(CMS_view::SHOW_HTML);
}

define("MESSAGE_PAGE_FIELD_DATE", 905);
define("MESSAGE_PAGE_FIELD_ACTION", 906);
define("MESSAGE_PAGE_FIELD_COMMENTS", 907);
define("MESSAGE_PAGE_FIELD_USER", 908);
define("MESSAGE_PAGE_FIELD_STATUS", 909);
define("MESSAGE_PAGE_FIELD_ELEMENT", 1579);

//get search vars
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$pageId = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', 0);
$type = sensitiveIO::request('type', array('all','login','resource','admin','email','modules'), 'all');
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
	case 'modules':
		$types = CMS_log_catalog::getModulesActions($cms_language);
	break;
	case 'all':
	default:
		$types = CMS_log_catalog::getAllActions($cms_language);
	break;
}
if ($delete) {
	CMS_log_catalog::purge($codename, $pageId, $userId, $types);
} else {
	//search logs
	$logs = CMS_log_catalog::search($codename, $pageId, $userId, $types, $start, $limit, $sort, io::strtolower($dir), $returnCount = false);
	$actions = CMS_log_catalog::getAllActions($cms_language);
	//loop over users to get all required infos
	foreach ($logs as $log) {
		$dt = $log->getDatetime();
		$user = $log->getUser();
		$resource = $log->getResource();
		if ($resource) {
			if (!$export) {
				$status = $log->getResourceStatusAfter()->getHTML(true,false,false,false,false);
			} else {
				$status = $log->getResourceStatusAfter()->getStatusLabel($cms_language);
			}
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
		$actionKey = array_search($log->getLogAction(), $actions);
		$actionLabel = io::isPositiveInteger($actionKey) ? $cms_language->getMessage($actionKey) : $actionKey;
		$datas = array(
			'id'			=> $log->getID(),
			'datetime'		=> $dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s'),
			'element'		=> $element,
			'action'		=> $actionLabel,
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
//export datas as CSV
if ($export) {
	$array2csv = new CMS_array2csv('logs-'.date('Y-m-d').'.csv');
	//add header
	$array2csv->addDatas(array(
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE),
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_ELEMENT),
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTION),
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_USER),
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_STATUS),
		$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMMENTS),
	));
	//add datas
	foreach ($logsDatas['logs'] as $datas) {
		unset($datas['id']);
		unset($datas['userId']);
		$array2csv->addDatas($datas);
	}
	//get csv file
	$file = $array2csv->getFile();
	//send to download
	if ($file->download(false, true) === false) {
		CMS_grandFather::raiseError('Error during CSV creation ...');
		$view->show();
	}
}

$view->setContent($logsDatas);
$view->show();
?>