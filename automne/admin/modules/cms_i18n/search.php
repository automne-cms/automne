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
// $Id: search.php,v 1.8 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load cms_i18n items datas
  * Used accross an Ajax request.
  * Return formated items infos in JSON format
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$codename = sensitiveIO::request('module');
$search = sensitiveIO::request('search');
$languages = sensitiveIO::request('languages', 'is_array', array());
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', $_SESSION["cms_context"]->getRecordsPerPage());
$dir = sensitiveIO::request('dir');

$itemsDatas = array();
$itemsDatas['results'] = array();

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
//load module
if ($codename != 'cms_i18n_vars' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($codename)));
	$view->show();
}

//get all search datas from requests
$keywords = sensitiveIO::request('items_'.$codename.'_kwrds');
$options = sensitiveIO::request('options', 'is_array', array());

if (io::isPositiveInteger($keywords)) {
	$options['ids'] = array($keywords);
	$keywords = '';
}

//show/hide keys in page navigation ?
if (!isset($options['view-keys']) || !$options['view-keys']) {
	CMS_session::setSessionVar('i18n-show-keys', false);
} else {
	CMS_session::setSessionVar('i18n-show-keys', true);
	unset($options['view-keys']);
}

//get messages
$resultCount = 0;
$messages = CMS_languagesCatalog::searchMessages($codename, $keywords, $languages, $options, $dir, $start, $limit, $resultCount);

// Vars for lists output purpose and pages display, see further
$itemsDatas['total'] = $resultCount;

//loop on results items
foreach($messages as $message) {
	$itemsDatas['results'][] = $message;
}

$view->setContent($itemsDatas);
$view->show();
?>