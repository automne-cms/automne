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

/**
  * Class CMS_websitesCatalog
  *
  *  Manages the collection of websites.
  *
  * @package Automne
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_websitesCatalog extends CMS_grandFather {
	/**
	  * Returns a CMS_website when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_website
	  * @return CMS_website or false on failure to find it
	  * @access public
	  */
	static function getByID($id) {
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
	  * Returns a CMS_website by a given codename
	  * Static function.
	  *
	  * @param string $codename The codename of the wanted CMS_website
	  * @return CMS_website or false on failure to find it
	  * @access public
	  */
	static function getByCodename($codename) {
		static $websites;
		if (!isset($websites[$codename])) {
			$sql = "
				select
					id_web
				from
					websites
				where
					codename_web='".io::sanitizeSQLString($codename)."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$websites[$codename] = CMS_websitesCatalog::getByID($q->getValue('id_web'));
			} else {
				$websites[$codename] = false;
			}
		}
		return $websites[$codename];
	}
	
	/**
	  * Returns a queried CMS_website value
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_website
	  * @param string $type The value type to get
	  * @return CMS_website value or false on failure to find it
	  * @access public
	  */
	static function getWebsiteValue($id, $type) {
		static $websitesInfos;
		if (!SensitiveIO::isPositiveInteger($id)) {
			CMS_grandFather::raiseError("Website id must be positive integer : ".$id);
			return false;
		}
		if (!isset($websitesInfos[$id][$type])) {
			$website = CMS_websitesCatalog::getByID($id);
			if (!$website) {
				$return = false;
			} else {
				switch ($type) {
					case 'codename':
						$return = $website->getCodename();
					break;
					case 'root':
						$return = $website->getRoot()->getID();
					break;
					case 'domain':
						$return = $website->getURL();
					break;
					case 'keywords':
					case 'description':
					case 'category':
					case 'author':
					case 'replyto':
					case 'copyright':
					case 'language':
					case 'robots':
					case 'favicon':
					case 'metas':
						$return = $website->getMeta($type);
					break;
					case 'title':
						$return = $website->getLabel();
					break;
					default:
						CMS_grandFather::raiseError("Unknown type value to get : ".$type);
						$return = false;
					break;
				}
				$websitesInfos[$id][$type] = $return;
			}
		}
		return $websitesInfos[$id][$type];
	}
	
	/**
	  * Returns all the websites, sorted by label.
	  * Static function.
	  *
	  * @param string $orderby, order of the websites returned in : label (default) or id
	  * @return array(CMS_website)
	  * @access public
	  */
	static function getAll($orderby = 'label') {
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
	static function exists($id) {
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
	static function getMainURL() {
		static $mainURL;
		if (!isset($mainURL)) {
			$website = CMS_websitesCatalog::getMainWebsite();
			$mainURL = $website->getURL();
		}
		return $mainURL;
	}
	
	/**
	  * Returns The URL of the current website, according to parameter or constant CURRENT_PAGE or the main domain URL if constant does not exists
	  * Static function.
	  *
	  * @param mixed $currentPage : The current page id or CMS_page
	  * @return string The current website URL
	  * @access public
	  */
	static function getCurrentDomain($currentPage = '') {
		static $domain;
		if (!isset($domain)) {
			$domain = '';
			if (io::isPositiveInteger($currentPage)) {
				$page = CMS_tree::getPageByID($currentPage);
			} elseif (is_object($currentPage)) {
				$page = $currentPage;
			} elseif (defined('CURRENT_PAGE') && io::isPositiveInteger(CURRENT_PAGE)) {
				$page = CMS_tree::getPageByID(CURRENT_PAGE);
			}
			if (isset($page) && is_object($page) && !$page->hasError()) {
				$domain = $page->getWebsite()->getURL();
				//check for HTTPS
				if ($page->isHTTPS() || (defined('PAGE_SSL_MODE') && PAGE_SSL_MODE)) {
					$domain = str_ireplace('http://', 'https://', $domain);
				}
			}
			if (!$domain) {
				$domain = CMS_websitesCatalog::getMainURL();
			}
		}
		return $domain;
	}
	
	/**
	  * Returns The main website, the one for the root.
	  * Static function.
	  *
	  * @return CMS_website the main website
	  * @access public
	  */
	static function getMainWebsite() {
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
	static function isWebsiteRoot($pageID) {
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
	static function getWebsiteFromRoot($root) {
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
				$roots[$rootID] = CMS_websitesCatalog::getByID($q->getValue("id_web"));
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
	static function setOrders($websitesIDsOrdered) {
		$count = 1;
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
	  * get first website for a given domain or false if none found
	  *
	  * @param string $domain : the domain to found website of
	  * @param string $path : the path to analyse (default nothing)
	  * @param boolean $isAlt : does the returned website use the domain as alternative (reference)
	  * @return CMS_website or false
	  * @access public
	  */
	static function getWebsiteFromDomain($domain, $path = '', &$isAlt = false) {
		//get all websites
		$websites = CMS_websitesCatalog::getAll('order');
		foreach ($websites as $website) {
			if (io::strtolower($domain) == io::strtolower(@parse_url($website->getURL(), PHP_URL_HOST))) {
				if (!$path || io::strtolower($path) == io::strtolower($website->getPagesPath(PATH_RELATIVETO_WEBROOT).'/')) {
					return $website;
				}
			}
			$altDomains = $website->getAltDomains();
			foreach ($altDomains as $altDomain) {
				if (io::strtolower($domain) == io::strtolower(@parse_url($altDomain, PHP_URL_HOST))) {
					if (!$path || io::strtolower($path) == io::strtolower($website->getPagesPath(PATH_RELATIVETO_WEBROOT).'/')) {
						$isAlt = true;
						return $website;
					}
				}
			}
		}
		return false;
	}
	
	/**
	  * get websites for a given domain or false if none found
	  *
	  * @param string $domain : the domain to found website of
	  * @return array(CMS_website)
	  * @access public
	  */
	static function getWebsitesFromDomain($domain, &$isAlt = false) {
		//get all websites
		$websites = CMS_websitesCatalog::getAll('order');
		$matchWebsites = array();
		foreach ($websites as $website) {
			if (io::strtolower($domain) == io::strtolower(@parse_url($website->getURL(), PHP_URL_HOST))) {
				$matchWebsites[$website->getID()] = $website;
			} else {
				$altDomains = $website->getAltDomains();
				foreach ($altDomains as $altDomain) {
					if (io::strtolower($domain) == io::strtolower(@parse_url($altDomain, PHP_URL_HOST))) {
						$isAlt = true;
						$matchWebsites[$website->getID()] = $website;
					}
				}
			}
		}
		return $matchWebsites;
	}
	
	/**
	  * Writes the website root redirection : an index.php page redirecting to the root page
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	static function writeRootRedirection() {
		return true;
	}
}
?>