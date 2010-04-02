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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: websitescatalog.php,v 1.5 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_websitesCatalog
  *
  *  Manages the collection of websites.
  *
  * @package CMS
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_websitesCatalog extends CMS_grandFather
{
	
	/**
	  * Returns a CMS_website when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_website
	  * @return CMS_website or false on failure to find it
	  * @access public
	  */
	function getByID($id)
	{
		static $websites;
		if (!isset($websites[$id])) {
			$websites[$id] = new CMS_website($id);
			if ($websites[$id]->hasError()) {
				$websites[$id] = false;
			}
		}
		return $websites[$id];
	}
	
	/**
	  * Returns all the websites, sorted by label.
	  * Static function.
	  *
	  * @param string $orderby, order of the websites returned in : label (default) or id
	  * @return array(CMS_website)
	  * @access public
	  */
	function getAll($orderby = 'label')
	{
		static $websites;
		if (!isset($websites[$orderby])) {
			$sql = "
				select
					id_web
				from
					websites
				order by
					".sensitiveIO::sanitizeSQLString($orderby)."_web
			";
			$q = new CMS_query($sql);
			$websites[$orderby] = array();
			while ($id = $q->getValue("id_web")) {
				$ws = new CMS_website($id);
				if (!$ws->hasError()) {
					$websites[$orderby][$ws->getID()] = $ws;
				}
			}
		}
		return $websites[$orderby];
	}
	
	/**
	  * Check if website currently exists
	  * Static function.
	  *
	  * @param integer $id The DB ID of the CMS_website to check
	  * @return boolean
	  * @access public
	  */
	function exists($id)
	{
		static $websites;
		if (!isset($websites[$id])) {
			$websites[$id] = false;
			$sql = "
				select
					id_web
				from
					websites
				where
					id_web = ".sensitiveIO::sanitizeSQLString($id)."
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$websites[$id] = true;
			}
		}
		return $websites[$id];
	}
	
	/**
	  * Returns The URL of the main website, the one for the root. Don't produce any error here, or the log will be filled in no time.
	  * Static function.
	  *
	  * @return string The main URL
	  * @access public
	  */
	function getMainURL()
	{
		static $mainURL;
		if (!isset($mainURL)) {
			$website = CMS_websitesCatalog::getMainWebsite();
			$mainURL = $website->getURL();
			if (io::substr($mainURL, io::strlen($mainURL) - 1) == "/") {
				$mainURL = io::substr($mainURL, 0, -1);
			}
		}
		return $mainURL;
	}
	
	/**
	  * Returns The main website, the one for the root.
	  * Static function.
	  *
	  * @return CMS_website the main website
	  * @access public
	  */
	function getMainWebsite() {
		static $mainWebsite;
		if (!isset($mainWebsite)) {
			$websites = CMS_websitesCatalog::getAll();
			foreach ($websites as $website) {
				if ($website->isMain()) {
					$mainWebsite = $website;
					return $mainWebsite;
				}
			}
		}
		return $mainWebsite;
	}
	
	/**
	  * Returns true if the pageID passed in parameter is the root of a website
	  * Static function.
	  *
	  * @param inetger $pageID The supposed root page
	  * @return boolean
	  * @access public
	  */
	function isWebsiteRoot($pageID)
	{
		static $webroots;
		if (!sensitiveIO::isPositiveInteger($pageID)) {
			CMS_grandFather::raiseError('Page id must be a positive integer : '.$pageID);
			return false;
		}
		if (!$webroots) {
			$sql = "
				select
					root_web
				from
					websites";
			$q = new CMS_query($sql);
			$arr = array();
			while ($r = $q->getArray()) {
				$arr[] = $r["root_web"];
			}
			$webroots = $arr;
		}
		return in_array($pageID,$webroots);
	}
	
	/**
	  * Returns The instance of the website whose page is a root of, or false if page is not a website root
	  * Static function.
	  *
	  * @param CMS_page|integer $root The supposed root page or root page ID
	  * @return CMS_website the website whose page is a root, or false
	  * @access public
	  */
	function getWebsiteFromRoot($root)
	{
		static $roots;
		if (is_object($root)) {
			$rootID = $root->getID();
		} elseif (sensitiveIO::isPositiveInteger($root)) {
			$rootID = $root;
		} else {
			CMS_grandFather::raiseError('Root must be instance of CMS_page or valid root ID');
			return false;
		}
		if (!isset($roots[$rootID])) {
			$sql = "
				select
					id_web
				from
					websites
				where
					root_web='".$rootID."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$roots[$rootID] = new CMS_website($q->getValue("id_web"));
			} else {
				$roots[$rootID] = false;
			}
		}
		return $roots[$rootID];
	}
	
	/**
	  * Reset websites order
	  *
	  * @param array $websitesIDsOrdered : the websites IDs ordered
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setOrders($websitesIDsOrdered) {
		$count = 0;
		foreach ($websitesIDsOrdered as $websiteID) {
			if (!sensitiveIO::isPositiveInteger($websiteID)) {
				CMS_grandFather::raiseError('Website id must be a positive integer : '.$websiteID);
				return false;
			}
			$sql = "
				update 
					websites 
				set 
					order_web='".$count."'
				where
					id_web='".$websiteID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				CMS_grandFather::raiseError('Saving order error for website : '.$websiteID);
				return false;
			}
			$count++;
		}
		return true;
	}
	
	/**
	  * get website for a given domain or false if none founded
	  *
	  * @param string $domain : the domain to found website of
	  * @return CMS_website or false
	  * @access public
	  */
	function getWebsiteFromDomain($domain) {
		//get all websites
		$websites = CMS_websitesCatalog::getAll('order');
		foreach ($websites as $website) {
			if (io::strtolower($domain) == io::strtolower(@parse_url($website->getURL(), PHP_URL_HOST))) {
				return $website;
			}
			$altDomains = $website->getAltDomains();
			foreach ($altDomains as $altDomain) {
				if (io::strtolower($domain) == io::strtolower(@parse_url($altDomain, PHP_URL_HOST))) {
					return $website;
				}
			}
		}
		return false;
	}
	
	/**
	  * Writes the website root redirection : an index.php page redirecting to the root page
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeRootRedirection()
	{
		//and write general and specific redirection files
		/*$filename = 'index.php';
		$content = '<?php'."\n".
		'//Generated on '.date('r').' by '.CMS_grandFather::SYSTEM_LABEL.' '.AUTOMNE_VERSION."\n".
		'require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");'."\n".
		'$httpHost = @parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_HOST) ? @parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_HOST) : $_SERVER[\'HTTP_HOST\'];'."\n".
		'//search page id by domain address'."\n".
		'$website = CMS_websitesCatalog::getWebsiteFromDomain($httpHost);'."\n".
		'if (!$website) {'."\n".
		'	$website = CMS_websitesCatalog::getMainWebsite();'."\n".
		'}'."\n".
		'$rootPage = $website->getRoot();'."\n".
		'//redirect to subpage if any'."\n".
		'$redirectlink = $rootPage->getRedirectLink(true);'."\n".
		'while ($redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {'."\n".
		'	$rootPage = new CMS_page($redirectlink->getInternalLink());'."\n".
		'	$redirectlink = $rootPage->getRedirectLink(true);'."\n".
		'}'."\n".
		'$pPath = $rootPage->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);'."\n".
		'if ($pPath) {'."\n".
		'	if (file_exists($pPath)) {'."\n".
		'		$cms_page_included = true;'."\n".
		'		require($pPath);'."\n".
		'		exit;'."\n".
		'	}'."\n".
		'}'."\n".
		'header(\'HTTP/1.x 301 Moved Permanently\', true, 301);'."\n".
		'header(\'Location: \'.PATH_SPECIAL_PAGE_NOT_FOUND_WR.\'\');'."\n".
		'? >';
		//and write general redirection file
		$indexPath = PATH_REALROOT_FS;
		$fp = @fopen($indexPath . "/".$filename, "wb");
		if (is_resource($fp)) {
			fwrite($fp, $content);
			fclose($fp);
			@chmod($indexPath."/".$filename, octdec(FILES_CHMOD));
			return true;
		}
		return false;*/
		return true;
	}
}
?>