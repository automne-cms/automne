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
// $Id: users-datas.php,v 1.2 2009/10/22 16:26:28 sebastien Exp $

/**
  * PHP page : Load users datas
  * Used accross an Ajax request.
  * Return formated users infos in JSON format
  *
  * @package CMS
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
$search = sensitiveIO::request('search');
$letter = sensitiveIO::request('letter');
$groupId = sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');
$sort = sensitiveIO::request('sort');
$dir = sensitiveIO::request('dir');
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', $_SESSION["cms_context"]->getRecordsPerPage());
$filter = (sensitiveIO::request('filter')) ? true : false;
$withGroups = (sensitiveIO::request('groups')) ? true : false;

$usersDatas = array();
$usersDatas['users'] = array();

if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->setContent($usersDatas);
	$view->show();
}
//load group's users if any
if ($groupId) {
	$groupUsers = CMS_profile_usersGroupsCatalog::getGroupUsers($groupId, false);
} else {
	$groupUsers = array();
}

if ($groupId && $filter) {
	//search users
	$users = CMS_profile_usersCatalog::search($search, $letter, $groupId, $sort, $dir, $start, $limit);
} else {
	//search users
	$users = CMS_profile_usersCatalog::search($search, $letter, false, $sort, $dir, $start, $limit);
}

//loop over users to get all required infos
foreach ($users as $user) {
	$datas = array(
		'id'			=> $user->getUserId(),
		'firstName'		=> $user->getFirstName(),
		'lastName'		=> $user->getLastName(),
		'login'			=> $user->getLogin(),
		'email'			=> $user->getEmail(),
		'active'		=> $user->isActive(),
	);
	if ($groupId) {
		$datas['belong'] = isset($groupUsers[$user->getUserId()]);
	}
	if ($withGroups) {
		//groups of user
		$userGroups = array();
		$groups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user);
		foreach ($groups as $group) {
			$userGroups[] = array(
				'id' 			=> $group->getGroupId(),
				'label'			=> $group->getLabel(),
				'description' 	=> $group->getDescription(),
			);
		}
		$datas['groups'] = $userGroups;
	}
	$usersDatas['users'][] = $datas;
}
//total users count for search
if ($groupId && $filter) {
	$usersDatas['totalCount'] = sizeof(CMS_profile_usersCatalog::search($search, $letter, $groupId, $sort, $dir, 0, 0, false, false));
} else {
	$usersDatas['totalCount'] = sizeof(CMS_profile_usersCatalog::search($search, $letter, false, $sort, $dir, 0, 0, false, false));
}

$view->setContent($usersDatas);
$view->show();
?>