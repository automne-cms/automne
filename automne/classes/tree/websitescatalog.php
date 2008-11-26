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
// $Id: websitescatalog.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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
			$websites = CMS_websitesCatalog::getAll();
			foreach ($websites as $website) {
				if ($website->isMain()) {
					$mainURL = $website->getURL();
					if (substr($mainURL, strlen($mainURL) - 1) == "/") {
						$mainURL = substr($mainURL, 0, -1);
					}
				}
			}
		}
		return $mainURL;
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
	  * Writes the website root redirection : an index.php page redirecting to the root page
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeRootRedirection()
	{
		//get all websites
		$websites = CMS_websitesCatalog::getAll('order');
		//and write general and specific redirection files
		$filename = 'index.php';
		$content = '';
		$count=0;
		foreach ($websites as $website) {
			if (!$website->isMain() || sizeof($websites) > 1) {
				$rootPage = $website->getRoot();
				//redirect to subpage if any
				$redirectlink = $rootPage->getRedirectLink(true);
				while ($redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {
					$rootPage = new CMS_page($redirectlink->getInternalLink());
					$redirectlink = $rootPage->getRedirectLink(true);
				}
				$pPath = $rootPage->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
				if ($pPath) {
					$redirectionCode = CMS_page::redirectionCode($pPath);
					// write specific redirection file
					$rootPath = PATH_PAGES_WR."/".SensitiveIO::sanitizeURLString($website->getLabel());
					$indexPath = PATH_REALROOT_FS.'/'.$rootPath;
					$fp = @fopen($indexPath . "/".$filename, "wb");
					if (is_resource($fp)) {
						fwrite($fp, $redirectionCode);
						fclose($fp);
						@chmod($indexPath."/".$filename, octdec(FILES_CHMOD));
					}
					//and append content to general redirection file
					$content .= ($count) ? 'else' : '';
					$content .= 'if (strtolower(parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_HOST)) == \''.strtolower($website->getURL(false)).'\' || strtolower($_SERVER[\'HTTP_HOST\']) == \''.strtolower($website->getURL(false)).'\') {'."\n";
					$content .= '	// '.$website->getURL();
					$content .= str_replace(array('<?php','?>'), "", $redirectionCode)."\n";
					$content .= '} ';
					$count++;
				}
			}
			if ($website->isMain()) {
				$mainWebsite = $website;
			}
		}
		if ($mainWebsite) {
			$rootPage = $mainWebsite->getRoot();
			//redirect to subpage if any
			$redirectlink = $rootPage->getRedirectLink(true);
			while ($redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {
				$rootPage = new CMS_page($redirectlink->getInternalLink());
				$redirectlink = $rootPage->getRedirectLink(true);
			}
			$pPath = $rootPage->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
			$redirectionCode = CMS_page::redirectionCode($pPath);
			// write specific redirection file
			$indexPath = PATH_REALROOT_FS.'/'.PATH_PAGES_WR;
			$fp = @fopen($indexPath . "/".$filename, "wb");
			if (is_resource($fp)) {
				fwrite($fp, $redirectionCode);
				fclose($fp);
				@chmod($indexPath."/".$filename, octdec(FILES_CHMOD));
			}
			//and append content to general redirection file
			if ($content) {
				$content .= 'else {'."\n";
				$content .= '	// '.$mainWebsite->getURL();
				$content .= str_replace(array('<?php','?>'), "", $redirectionCode);
				$content .= '} ';
			} else {
				$content .= '// '.$mainWebsite->getURL();
				$content .= str_replace(array('<?php','?>'), "", $redirectionCode);
			}
		}
		//append php tags
		$content = '<?php'."\n".$content.'?>';
		//and write general redirection file
		$indexPath = PATH_REALROOT_FS;
		$fp = @fopen($indexPath . "/".$filename, "wb");
		if (is_resource($fp)) {
			fwrite($fp, $content);
			fclose($fp);
			@chmod($indexPath."/".$filename, octdec(FILES_CHMOD));
			return true;
		}
		return false;
	}
}
?>