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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-redirect-info.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Redirection page info
  * Return info on page redirection
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_REDIRECT", 320);
define("MESSAGE_PAGE_PAGE", 1303);

//load interface instance
$view = CMS_view::getInstance();
$view->addCSSFile('main');

if (isset($_GET['pageId']) && sensitiveIO::isPositiveInteger($_GET['pageId'])) {
	$page = CMS_tree::getpageById($_GET['pageId']);
}
if (isset($page) && !$page->hasError()) {
	$redirectlink = $page->getRedirectLink();
	if ($redirectlink->hasValidHREF()) {
		if ($redirectlink->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
			$redirectPage = new CMS_page($redirectlink->getInternalLink());
			if (!$redirectPage->hasError()) {
				$label = $cms_language->getMessage(MESSAGE_PAGE_PAGE).' "'.$redirectPage->getTitle().'" ('.$redirectPage->getID().')';
			}
			$redirect = '<a href="'.$redirectPage->getURL().'">'.htmlspecialchars($label).'</a>';
		} else {
			$label = $redirectlink->getExternalLink();
			$redirectlink->setTarget('_blank');
			$redirect = $redirectlink->getHTML($label, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED);
		}
	}
}
$content = '
<div id="atm-center">
	<div class="atm-alert">'.$cms_language->getMessage(MESSAGE_PAGE_REDIRECT, array($redirect)).'</div>
</div>';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>