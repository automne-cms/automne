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
  * PHP page : Load module alias tree window.
  * Used accross an Ajax request. Render alias tree nodes.
  * 
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

define("MESSAGE_ERROR_MODULE_RIGHTS",570);
define("MESSAGE_ERROR_UNKNOWN_PAGE",66);
define("MESSAGE_PAGE_PAGE",78);
//Specific Alias messages
define("MESSAGE_ALIAS_PROTECTED", 22);
define("MESSAGE_ALIAS_PROTECTED_DESC", 23);
define("MESSAGE_PAGE_REDIRECT_TO", 25);
define("MESSAGE_PAGE_ALIAS_FOR_ALL_WEBSITES", 31);
define("MESSAGE_PAGE_ALIAS_RESTRICTED", 32);
define("MESSAGE_PAGE_ALIAS_FOR_WEBSITES", 33);
define("MESSAGE_PAGE_ALIAS", 34);
define("MESSAGE_PAGE_REPLACE_ADDRESS", 40);
define("MESSAGE_PAGE_ALIAS_ERROR", 42);

function checkAliasId($aliasId) {
	return (io::strpos($aliasId, 'alias') === 0) && sensitiveIO::isPositiveInteger(io::substr($aliasId, 5));
}

$codename = 'cms_aliases';
$rootId = io::substr(sensitiveIO::request('node', 'checkAliasId', 'alias0'), 5);
$maxDepth = sensitiveIO::request('maxDepth', 'sensitiveIO::isPositiveInteger', 2);
$pageId = sensitiveIO::request('page', 'io::isPositiveInteger');

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

//get queried module aliases
if ($pageId) {
	$aliases = CMS_module_cms_aliases::getAllByPage($rootId, $pageId, true);
} else {
	$aliases = CMS_module_cms_aliases::getAll($rootId, true);
}
$nodes = array();
foreach ($aliases as $alias) {
	$hasSiblings = $alias->hasSubAliases();
	if ($alias->hasError()) {
		$label = ($alias->getWebsites() ? '<span style="color:red;">*</span>' : '').'<span style="color:red;">'.$alias->getAlias().'</span>';
	} elseif ($pageId && $alias->getPageID() == $pageId && $alias->urlReplaced()) {
		$label = ($alias->getWebsites() ? '<span style="color:red;">*</span>' : '').'<span style="color:green;">'.$alias->getAlias().'</span>';
	} else {
		$label = ($alias->getWebsites() ? '<span style="color:red;">*</span>' : '').$alias->getAlias();
	}
	
	if ($alias->hasError()) {
		$qtip = '<span style="color:red;"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_ALIAS_ERROR, false, 'cms_aliases').'</strong></span><br />';
	} else {
		$qtip = $cms_language->getMessage(MESSAGE_PAGE_ALIAS, false, 'cms_aliases').' <strong>'.$alias->getPath().'</strong><br />';
	}
	if ($alias->getPageID()) {
		$page = CMS_tree::getPageById($alias->getPageID());
		if ($page && !$page->hasError()) {
			$label .= $alias->urlReplaced() ? ' ('.$alias->getPageID().')' : '<small> &rArr; '.$alias->getPageID().'</small>';
			$qtip .= $cms_language->getMessage(($alias->urlReplaced() ? MESSAGE_PAGE_REPLACE_ADDRESS : MESSAGE_PAGE_REDIRECT_TO), false, 'cms_aliases').' '.$cms_language->getMessage(MESSAGE_PAGE_PAGE).' '.$page->getTitle().' ('.$alias->getPageID().')<br />';
		} else {
			$label .= $alias->urlReplaced() ? ' (<span style="color:red;">'.$alias->getPageID().'</span>)' : '<small> &rArr; <span style="color:red;">'.$alias->getPageID().'</span></small>';
			$qtip .= $cms_language->getMessage(($alias->urlReplaced() ? MESSAGE_PAGE_REPLACE_ADDRESS : MESSAGE_PAGE_REDIRECT_TO), false, 'cms_aliases').' <span style="color:red;">'.$cms_language->getMessage(MESSAGE_ERROR_UNKNOWN_PAGE).' ('.$alias->getPageID().')</span><br />';
		}
	} elseif ($alias->getURL()) {
		$label .= '<small> &rArr; '.$alias->getURL().'</small>';
		$qtip .= $cms_language->getMessage(MESSAGE_PAGE_REDIRECT_TO, false, 'cms_aliases').' '.$alias->getURL().'<br />';
	}
	if (!$alias->getWebsites()) {
		$qtip .= $cms_language->getMessage(MESSAGE_PAGE_ALIAS_FOR_ALL_WEBSITES, false, 'cms_aliases').'<br />';
	} else {
		$qtip .= '<strong>'.$cms_language->getMessage(MESSAGE_PAGE_ALIAS_RESTRICTED, false, 'cms_aliases').' </strong>'.$cms_language->getMessage(MESSAGE_PAGE_ALIAS_FOR_WEBSITES, false, 'cms_aliases').'<br />';
		foreach ($alias->getWebsites() as $websiteId) {
			$website = CMS_websitesCatalog::getById($websiteId);
			$qtip .= ' - '.$website->getLabel().' ('.$website->getURL().')<br />';
		}
	}
	if ($alias->isProtected()) {
		$qtip .= '<strong>'.$cms_language->getMessage(MESSAGE_ALIAS_PROTECTED, false, 'cms_aliases').' : </strong>'.$cms_language->getMessage(MESSAGE_ALIAS_PROTECTED_DESC, false, 'cms_aliases').'<br />';
	}
	if ($pageId) {
		$manageable = $alias->getPageID() == $pageId ? true : false;
		$deletable = !$hasSiblings && !$alias->isProtected() && $alias->getPageID() == $pageId ? true : false;
		$protected = $alias->getPageID() != $pageId || ($alias->isProtected() && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL));
		$expanded = true;
	} else {
		$deletable = !$hasSiblings && !$alias->isProtected();
		$manageable = true;
		$protected = ($alias->isProtected() && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL));
		$expanded = ((sizeof($alias->getAliasLineAge()) - 1) < $maxDepth);
	}
	
	$nodes[] = array(
		'id'			=>	'alias'.$alias->getID(), 
		'aliasId'		=>	$alias->getID(), 
		'text'			=>	'<span'.($protected  ? ' style="color:grey;"' : '').' ext:qtip="'.io::htmlspecialchars($qtip).'">'.$label.'</span>',
		'leaf'			=>	!$hasSiblings, 
		'qtip'			=>	($qtip ? $qtip : false),
		'allowChildren' =>	true,
		'deletable'		=>	$deletable,
		'manageable'	=>	$manageable,
		'expanded'		=>	$expanded,
		'protected'		=>  $protected,
	);
}
$view->setContent($nodes);
$view->show();

?>