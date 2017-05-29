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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: polymod-help.php,v 1.3 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load polymod help for object.
  * Used accross an Ajax request.
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
//load interface instance
$view = CMS_view::getInstance();

$module = sensitiveIO::request('module');
$object = sensitiveIO::request('object');
$mode = sensitiveIO::request('mode');
if ($object) {
	$modulesCodes = new CMS_modulesCodes();
	$modulesCodeInclude = $modulesCodes->getModulesCodes($mode, PAGE_VISUALMODE_CLIENTSPACES_FORM, '', array("language" => $cms_language, "user" => $cms_user, 'request' => array($module => true, $module.'object' => $object)));
	$view->setContent($modulesCodeInclude[$module]);
} else {
	$view->setContent('');
}
$view->show(CMS_view::SHOW_HTML);
?>