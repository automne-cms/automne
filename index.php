<?php
//Generated on Thu, 11 Mar 2010 17:06:41 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/cms_rc_frontend.php');
$httpHost = @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
//search page id by domain address
$website = CMS_websitesCatalog::getWebsiteFromDomain($httpHost);
if (!$website) {
	$website = CMS_websitesCatalog::getMainWebsite();
}
$rootPage = $website->getRoot();
//redirect to subpage if any
$redirectlink = $rootPage->getRedirectLink(true);
while ($redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {
	$rootPage = new CMS_page($redirectlink->getInternalLink());
	$redirectlink = $rootPage->getRedirectLink(true);
}
$pPath = $rootPage->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
if ($pPath) {
	if (file_exists($pPath)) {
		$cms_page_included = true;
		require($pPath);
		exit;
	}
}
header('HTTP/1.x 301 Moved Permanently', true, 301);
header('Location: '.PATH_SPECIAL_PAGE_NOT_FOUND_WR.'');
?>