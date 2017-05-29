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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-content.php,v 1.5 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : page previsualization
  * Used to view the page edited data.
  *
  * @package Automne
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

$cms_view = CMS_view::getInstance();

$currentPage = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());
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
CMS_session::setPage($cms_page);

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
	//log action
	$log = new CMS_log();
	$status = $cms_page->getStatus();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_START_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $status, "(Start new draft for page)", $cms_page);
} else {
	//log action
	$log = new CMS_log();
	$cmsPageStatus = $cms_page->getStatus();
	$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cmsPageStatus, "(Continue existing page draft)", $cms_page);
}

//add ext and edit JS files
$cms_view->addJSFile('ext');
$cms_view->addJSFile('edit');
//unset vars to avoid interraction with page
unset($currentPage);
unset($action);
unset($tpl);
unset($log);
//get page content
$content = $cms_page->getContent($cms_language, PAGE_VISUALMODE_FORM);

echo $content;
/*only for stats*/
//if (STATS_DEBUG) view_stat();
?>