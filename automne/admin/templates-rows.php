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
// $Id: templates-rows.php,v 1.2 2009/02/09 10:01:43 sebastien Exp $

/**
  * PHP page : template default rows
  * Used to view and set the default template rows
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_TITLE", 852);

$view = CMS_view::getInstance();

$templateId = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
//unset request to avoid it to have interaction with page code
sensitiveIO::unsetRequest(array('template'));

//CHECKS
if (!SensitiveIO::isPositiveInteger($templateId)) {
	die("Invalid template");
}
$template = CMS_pageTemplatesCatalog::getByID($templateId);
if (!is_object($template) || $template->hasError()) {
	die("Invalid template or template error");
}
//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	die("User has no rights on template edition");
}

$dummy_page = CMS_tree::getRoot();
$dummy_page->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE, array($template->getLabel())), $cms_user);

//add ext and edit JS files
$view->addJSFile('ext');
$view->addJSFile('edit');
//get page content
$dummy_page->setTemplate($template->getID()) ;

//$content = $template->getContent($cms_language, $dummy_page, PAGE_VISUALMODE_CLIENTSPACES_FORM);

//get page content
$content = $dummy_page->getContent($cms_language, PAGE_VISUALMODE_CLIENTSPACES_FORM);

echo $content;
?>