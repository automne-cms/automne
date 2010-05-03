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
// $Id: modules-categories-nodes.php,v 1.4 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load module categories tree window.
  * Used accross an Ajax request. Render categories tree for a given module.
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

define("MESSAGE_ERROR_MODULE_RIGHTS",570);

function checkCatId($catId) {
	return (io::strpos($catId, 'cat') === 0) && sensitiveIO::isPositiveInteger(io::substr($catId, 3));
}

$codename = sensitiveIO::request('module');
$rootId = io::substr(sensitiveIO::request('node', 'checkCatId', 'cat0'), 3);
$maxDepth = sensitiveIO::request('maxDepth', 'sensitiveIO::isPositiveInteger', 2);

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

//get queried module categories
$attrs = array(
	"module" 	=> $codename,
	"language" 	=> $cms_language,
	"level" 	=> $rootId,
	"root" 		=> $rootId ? false : 0,
	"attrs" 	=> false,
	"cms_user" 	=> $cms_user
);
$categories = CMS_module::getModuleCategories($attrs);

$nodes = array();
foreach ($categories as $category) {
	$parentRight = sensitiveIO::isPositiveInteger($category->getAttribute('parentID')) ? $cms_user->hasModuleCategoryClearance($category->getAttribute('parentID'), CLEARANCE_MODULE_MANAGE) : $cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT);
	$categoryRight = $cms_user->hasModuleCategoryClearance($category->getID(), CLEARANCE_MODULE_MANAGE);
	$hasSiblings = $category->hasSiblings();
	$qtip = $category->getIconPath(false, PATH_RELATIVETO_WEBROOT, true) ? '<img style="max-width:280px;" src="'.$category->getIconPath(true).'" /><br />' : '';
	$qtip .= $category->getDescription() ? $category->getDescription().'<br />' : '';
	$qtip .= 'ID : '.$category->getID();
	$nodes[] = array(
		'id'			=>	'cat'.$category->getID(), 
		'catId'			=>	$category->getID(), 
		'text'			=>	$category->getLabel(),
		'leaf'			=>	!$hasSiblings, 
		'qtip'			=>	($qtip ? $qtip : false),
		'draggable'		=>	$parentRight,
		'allowDrop'		=>	$categoryRight,
		'allowChildren' =>	true,
		'disabled'		=>	!$categoryRight,
		'deletable'		=>	$categoryRight && !$hasSiblings && !$module->isCategoryUsed($category),
		'manageable'	=>	$categoryRight,
		'expanded'		=>	(sizeof($category->getLineageStack()) < $maxDepth),
	);
}
$view->setContent($nodes);
$view->show();

?>