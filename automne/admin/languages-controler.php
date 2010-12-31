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
// $Id: items-controler.php,v 1.8 2010/03/08 16:42:07 sebastien Exp $

/**
  * cms_i18n item controler
  * Used accross an Ajax request. Make actions on cms_i18n items
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//Controler vars
$action = sensitiveIO::request('action', array('save'));
$code = sensitiveIO::request('code');
$selectedCode = sensitiveIO::request('selectedCode');
$dateFormat = sensitiveIO::request('dateformat');
$modulesDenied = sensitiveIO::request('modulesDenied');
$admin = sensitiveIO::request('admin') ? true : false;

//set default content
$content = array('success' => false);

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on language management');
	$view->setContent($content);
	$view->show();
}

if (!$action) {
	$view->setContent($content);
	CMS_grandFather::raiseError('Unknown action ... '.$action);
	$view->show();
}
if (!$code && !$selectedCode) {
	CMS_grandFather::raiseError('Missing language code ... ');
	$view->setContent($content);
	$view->show();
}

$cms_message = '';
switch ($action) {
	case 'save':
		if ($code) {
			$language = CMS_languagesCatalog::getByCode($code);
			if (!$language || $language->hasError()) {
				CMS_grandFather::raiseError('Unknown language code : '.$code);
				$view->setContent($content);
				$view->show();
			}
		} else {
			$language = new CMS_language();
			$language->setCode($selectedCode);
			$languagesCodes = CMS_languagesCatalog::getAllLanguagesCodes();
			$language->setLabel($languagesCodes[$selectedCode]);
		}
		$language->setDateFormat($dateFormat);
		if ($modulesDenied) {
			$modulesDenied = array_map('trim', explode(',',$modulesDenied));
			$language->setModulesDenied($modulesDenied);
		} else {
			$language->setModulesDenied(array());
		}
		$language->setAvailableForBackoffice($admin);
		
		if ($language->writeToPersistence()) {
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$view->setContent($content);
			$view->show();
		}
	break;
}
//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
//beware, here we add content (not set) because object saving can add his content to (uploaded file infos updated)
$view->addContent($content);
$view->show();
?>