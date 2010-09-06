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
// $Id: groups-datas.php,v 1.4 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP page : Load groups datas
  * Used accross an Ajax request.
  * Return formated groups infos in JSON format
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$search = sensitiveIO::request('search');
$letter = sensitiveIO::request('letter');
$sort = sensitiveIO::request('sort');
$dir = sensitiveIO::request('dir');
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', $_SESSION["cms_context"]->getRecordsPerPage());
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
$filter = (sensitiveIO::request('filter')) ? true : false;

$groupsDatas = array();
$groupsDatas['groups'] = array();

if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->setContent($groupsDatas);
	$view->show();
}

//load user's groups if any
if ($userId) {
	$userGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($userId, true);
} else {
	$userGroups = array();
}
if ($userId && $filter) {
	//search users
	$groups = CMS_profile_usersGroupsCatalog::search($search, $letter, $userId, array(), $sort, $dir, $start, $limit);
} else {
	//search users
	$groups = CMS_profile_usersGroupsCatalog::search($search, $letter, false, array(), $sort, $dir, $start, $limit);
}
//loop over groups to get all required infos
foreach ($groups as $group) {
	$datas = array(
		'id'			=> $group->getGroupId(),
		'label'			=> $group->getLabel(),
		'description'	=> $group->getDescription(),
	);
	if ($userId) {
		$datas['belong'] = isset($userGroups[$group->getGroupId()]);
	} else {
		$datas['users'] = sizeof($group->getUsersRef());
	}
	$groupsDatas['groups'][] = $datas;
}


if ($userId && $filter) {
	//total users count for search
	$groupsDatas['totalCount'] = sizeof(CMS_profile_usersGroupsCatalog::search($search, $letter, $userId, array(), $sort, $dir, 0, 0, false));
} else {
	//total users count for search
	$groupsDatas['totalCount'] = sizeof(CMS_profile_usersGroupsCatalog::search($search, $letter, false, array(), $sort, $dir, 0, 0, false));
}

$view->setContent($groupsDatas);
$view->show();
?>