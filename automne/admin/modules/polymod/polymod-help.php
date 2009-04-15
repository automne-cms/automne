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
// $Id: polymod-help.php,v 1.2 2009/04/15 12:07:22 sebastien Exp $

/**
  * PHP page : Load polymod help for object.
  * Used accross an Ajax request.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
//load interface instance
$view = CMS_view::getInstance();

$module = sensitiveIO::request('module');
$object = sensitiveIO::request('object');

$modulesCodes = new CMS_modulesCodes();
$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_ROWS_EDITION_LABELS, PAGE_VISUALMODE_CLIENTSPACES_FORM, '', array("language" => $cms_language, "user" => $cms_user, 'request' => array($module => true, $module.'object' => $object)));

$view->setContent($modulesCodeInclude[$module]);
$view->show(CMS_view::SHOW_HTML);
?>