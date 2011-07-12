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

/**
  * PHP page : Load oembed HTML datas
  * Used accross an Ajax request.
  * Return oembed infos in HTML format
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define('MESSAGE_ERROR_OEMBED_NOT_FOUND', 628);
define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$url = sensitiveIO::request('url');
$width = sensitiveIO::request('width', 'sensitiveIO::isPositiveInteger', 300);
$height = sensitiveIO::request('height', 'sensitiveIO::isPositiveInteger', 300);
$codename = sensitiveIO::request('module');

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->setContent('');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module || !$module->isPolymod()) {
	CMS_grandFather::raiseError('Unknown module or module is not polymod for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->setContent('');
	$view->show();
}
$html = '';
if ($url) {
	$oembed = new CMS_oembed($url, $width, $height);
	$html = $oembed->getHTML();
	if (!$html) {
		$html = $cms_language->getMessage(MESSAGE_ERROR_OEMBED_NOT_FOUND, false, MOD_POLYMOD_CODENAME);
	}
}
$view->setContent($html);
$view->show();
?>