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
// $Id: search-pages.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : return search pages results
  * 
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

/*
	$query = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
	$start = (isset($_REQUEST['start']) && sensitiveIO::isPositiveInteger($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
	$limit = (isset($_REQUEST['limit']) && sensitiveIO::isPositiveInteger($_REQUEST['limit'])) ? $_REQUEST['limit'] : 10;
*/
$query = sensitiveIO::request('query', '', '');
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', 10);

if (!$query || strlen($query) < 3) {
	CMS_grandFather::raiseError('Missing query or query is too short : '.$query);
	$view->show();
}
//lauch search
$results = CMS_search::getSearch($query, $cms_user,$start,$limit,false);

//pr($results);
$pages = array();
if (isset($results['results']) && is_array($results['results'])) {
	foreach ($results['results'] as $result) {
		if (is_object($result)) {
			$pages[] = array(
				'pageId' 	=> $result->getID(),
				'title' 	=> $result->getTitle().' ('.$result->getID().')',
				'status' 	=> $result->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $result->getID()),
				'lineage' 	=> CMS_tree::getLineage(APPLICATION_ROOT_PAGE_ID, $result->getID(), false),
			);
		} else {
			$results['nbresult']--;
		}
	}
}
$return = array(
	'pages' 	=> $pages,
	'totalCount'=> $results['nbresult'],
);

$view->setContent($return);
$view->show();
?>