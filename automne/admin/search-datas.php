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
// $Id: search-datas.php,v 1.1 2008/12/18 10:36:43 sebastien Exp $

/**
  * PHP page : Load page search results infos
  * Used accross an Ajax request.
  * Return formated search infos in JSON format
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

$keyword = sensitiveIO::request('keyword');
$elements = sensitiveIO::request('elements', 'is_array', array());
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', 0);


$results = $scores = array();

//Users search
if (in_array('users', $elements)) {
	$usersResults = CMS_profile_usersCatalog::search($keyword, '', '', 'score', 'desc', 0, 0, false, false, $usersScore);
	if ($usersResults) {
		foreach ($usersResults as $resultId) {
			if (isset($usersScore[$resultId])) {
				$scores[$usersScore[$resultId]][] = array('users', $resultId);
			} else {
				$scores[0][] = array('users', $resultId);
			}
		}
		//pr('Users :');
		//pr($usersResults);
		//pr($rowsScore);
	}
}

if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	//Groups search
	if (in_array('groups', $elements)) {
		$groupsResults = CMS_profile_usersGroupsCatalog::search($keyword, '', false, array(), 'score', 'desc', 0, 0, false, $groupsScore);
		if ($groupsResults) {
			foreach ($groupsResults as $resultId) {
				if (isset($groupsScore[$resultId])) {
					$scores[$groupsScore[$resultId]][] = array('groups', $resultId);
				} else {
					$scores[0][] = array('groups', $resultId);
				}
			}
			//pr('Groups :');
			//pr($groupsResults);
			//pr($groupsScore);
		}
	}
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	//Templates search
	if (in_array('templates', $elements)) {
		$templatesResults = CMS_pageTemplatesCatalog::getAll(true, $keyword, array(), '', array(), $cms_user, 0, 0, false, $templatesScore);
		if ($templatesResults) {
			foreach ($templatesResults as $resultId) {
				if (isset($templatesScore[$resultId])) {
					$scores[$templatesScore[$resultId]][] = array('templates', $resultId);
				} else {
					$scores[0][] = array('templates', $resultId);
				}
			}
			//pr('Templates :');
			//pr($templatesResults);
			//pr($templatesScore);
		}
	}
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	//Rows search
	if (in_array('rows', $elements)) {
		$rowsResults = CMS_rowsCatalog::getAll(true, $keyword, array(), array(), $cms_user, false, false, 0, 0, false, $rowsScore);
		if ($rowsResults) {
			foreach ($rowsResults as $resultId) {
				if (isset($rowsScore[$resultId])) {
					$scores[$rowsScore[$resultId]][] = array('rows', $resultId);
				} else {
					$scores[0][] = array('rows', $resultId);
				}
			}
			//pr('Rows :');
			//pr($rowsResults);
			//pr($rowsScore);
		}
	}
}

//Modules search
$modResults = $modScore = array();
foreach ($elements as $element) {
	if (!in_array($element, array('users', 'groups', 'templates', 'rows', ))) {
		$module = CMS_modulesCatalog::getByCodename($element);
		if ($cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT) && method_exists($module, 'search')) {
			$modResults[$element] = $module->search($keyword, $cms_user, false, $modScore[$element]);
			if ($modResults[$element]) {
				foreach ($modResults[$element] as $resultId) {
					if (isset($modScore[$element][$resultId])) {
						$scores[$modScore[$element][$resultId]][] = array($element, $resultId);
					} else {
						$scores[0][] = array($element, $resultId);
					}
				}
				//pr($element.' :');
				//pr($modResults[$element]);
				//pr($modScore[$element]);
			}
		}
	}
}
//sort results by relevance score
krsort($scores, SORT_NUMERIC);

//pr($scores);

//extract results according to queried limits
$count = $countok = 0;
$searchResultsByType = $searchResultsOrdered = array();
foreach ($scores as $results) {
	foreach ($results as $result) {
		if ($count >= $start && $countok < $limit) {
			$searchResultsByType[$result[0]][$result[1]] = $count;
			$countok++;
		}
		$count++;
	}
}
//pr($searchResultsByType);

$resultsDatas = array();
$resultsDatas['results'] = array();
$resultsDatas['total'] = $count;

foreach($searchResultsByType as $type => $results) {
	$items = array();
	switch($type) {
		case 'rows':
			$rows = CMS_rowsCatalog::getAll(true, '', array(), array_keys($results));
			foreach($rows as $row) {
				$items[] = $row->getJSonDescription($cms_user, $cms_language, false);
			}
		break;
		case 'templates':
			$tpls = CMS_pageTemplatesCatalog::getAll(true, '', array(), '', array_keys($results));
			foreach($tpls as $tpl) {
				$items[] = $tpl->getJSonDescription($cms_user, $cms_language, false);
			}
		break;
		case 'users':
			$users = CMS_profile_usersCatalog::getAll(false, false, true, array('id_pru' => array_keys($results)));
			foreach($users as $user) {
				$items[] = $user->getJSonDescription($cms_user, $cms_language, false);
			}
		break;
		case 'groups':
			$groups = CMS_profile_usersGroupsCatalog::search('', '', false, array_keys($results));
			foreach($groups as $group) {
				$items[] = $group->getJSonDescription($cms_user, $cms_language, false);
			}
		break;
		default:
			$module = CMS_modulesCatalog::getByCodename($type);
			$items = $module->getSearchResults(array_keys($results), $cms_user);
		break;
	}
	//set each results items as right position
	foreach ($items as $item) {
		if ($item['id']) {
			$resultsDatas['results'][$results[$item['id']]] = $item;
			//rewrite id to avoid overwrite
			$resultsDatas['results'][$results[$item['id']]]['id'] = md5($type.$item['id']);
		}
	}
}
//sort results by position
ksort($resultsDatas['results'], SORT_NUMERIC);
//pr($resultsDatas['results']);

$view->setContent($resultsDatas);
$view->show();
?>