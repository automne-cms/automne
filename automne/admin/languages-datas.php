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
$dir = sensitiveIO::request('dir');

$itemsDatas = array();
$itemsDatas['results'] = array();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on language management');
	$view->show();
}

//get messages
$resultCount = 0;
$languages = CMS_languagesCatalog::getAllLanguages('all');

// Vars for lists output purpose and pages display, see further
$itemsDatas['total'] = sizeof($languages);

//loop on results items
foreach($languages as $language) {
	$modulesDenied = '';
	if ($language->getModulesDenied()) {
		foreach ($language->getModulesDenied() as $codename) {
			if ($codename) {
				$module = CMS_modulesCatalog::getByCodename($codename);
				if ($module) {
					$modulesDenied .= ($modulesDenied ? ', ' : '').$module->getLabel($cms_language);
				}
			}
		}
	}
	$itemsDatas['results'][] = array(
		'code'			=> $language->getCode(),
		'label'			=> $language->getLabel(),
		'admin'			=> $language->isAvailableForBackoffice(),
		'dateFormat'	=> $language->getDateFormat(),
		'modulesDenied' => $modulesDenied,
	);
}

$view->setContent($itemsDatas);
$view->show();
?>