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
  * Automne index handler. Redirect to correct website accordingly to queried domain
  *
  * @package Automne
  * @subpackage frontend
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/cms_rc_frontend.php');
$httpHost = @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
//search page id by domain address
$website = CMS_websitesCatalog::getWebsiteFromDomain($httpHost, '', $isAlt);
//redirect to website main domain if current domain is an altdomain and need redirection
if ($website && $isAlt && $website->redirectAltDomain()) {
	CMS_view::redirect($website->getURL(), true, 301);
}
if (!$website) {
	$website = CMS_websitesCatalog::getMainWebsite();
}
$rootPage = $website->getRoot();
if ($rootPage->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
	//redirect to subpage if any
	$redirectlink = $rootPage->getRedirectLink(true);
	while ($redirectlink && $redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {
		$rootPage = new CMS_page($redirectlink->getInternalLink());
		if ($rootPage->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
			$redirectlink = $rootPage->getRedirectLink(true);
		} else {
			$redirectlink = '';
		}
	}
}
$pPath = $rootPage->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
if ($pPath) {
	if (file_exists($pPath)) {
		$cms_page_included = true;
		require($pPath);
		exit;
	} elseif ($rootPage->regenerate(true)) {
		clearstatcache ();
		if (file_exists($pPath)) {
			$cms_page_included = true;
			require($pPath);
			exit;
		}
	}
}
CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
?>
