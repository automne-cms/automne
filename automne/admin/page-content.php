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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-content.php,v 1.2 2009/06/05 15:01:04 sebastien Exp $

/**
  * PHP page : page previsualization
  * Used to view the page edited data.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$view = CMS_view::getInstance();

$currentPage = is_object($cms_context) ? sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID()) : '';
$action = sensitiveIO::request('action');
//unset request to avoid it to have interaction with page code
sensitiveIO::unsetRequest(array('action', 'page'));

//CHECKS
if (!SensitiveIO::isPositiveInteger($currentPage)) {
	die("Invalid page");
}
$cms_page = CMS_tree::getPageByID($currentPage);
if (!is_object($cms_page) || $cms_page->hasError()) {
	die("Invalid page or page error");
}
//set page to context
$cms_context->setPage($cms_page);

//RIGHTS CHECK
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	die("User has no rights on page");
} elseif (!$action && !$cms_page->getLock()) {
	$cms_page->lock($cms_user);
} elseif ($cms_page->getLock() && $cms_page->getLock() != $cms_user->getUserId()) {
	die("Page is locked");
}

if (!$cms_page->isDraft()) {
	//must copy data from edited to edition
	$tpl = $cms_page->getTemplate();
	CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
	CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_EDITION, true);
}

//add ext and edit JS files
$view->addJSFile('ext');
$view->addJSFile('edit');
//get page content
$content = $cms_page->getContent($cms_language, PAGE_VISUALMODE_FORM);

echo $content;
/*only for stats*/
//if (STATS_DEBUG) view_stat();
?>