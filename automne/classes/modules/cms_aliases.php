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
  * Class CMS_module_cms_aliases
  *
  * represent the cms_alias module.
  *
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_cms_aliases extends CMS_moduleValidation
{
	const MESSAGE_CMS_ALIAS_ALIASES = 1;
	
	/**
	  * Array of resources infos
	  * The first record is the primary resource of the module.
	  * All other key field of other resources defined need to correspond to the first resource field and does not necessary represent the table key.
	  * For module who does not use Automne resource, leave array empty.
	  * @var multidimentional array (tableName => array ('key' => keyFielname, 'resource' => resourceFieldname))
	  * @access private
	  */
	protected $_resourceInfo	= array();
	
	/**
	  * Method to get the item label
	  * @var string
	  * @access private
	  */
	protected $_resourceNameMethod 	= '';
	
	/**
	  * File name to be queried for the item previzualisation
	  * A param "item" is passed to this file with the ID of the resource to previz.
	  * @var string
	  * @access private
	  */
	protected $_resourcePrevizFile 	= "";
	
	/**
	  * Gets resource by its internal ID (not the resource table DB ID)
	  * This function need to stay here because sometimes it is directly queried
	  *
	  * @param integer $resourceID The DB ID of the resource in the module table(s)
	  * @return CMS_resource The CMS_resource subclassed object
	  * @access public
	  */
	public static function getResourceByID($resourceID)
	{
		parent::getResourceByID($resourceID);
		return new CMS_resource_cms_aliases($resourceID);
	}
	
	/**
	  * Return a list of objects infos to be displayed in module index according to user privileges
	  *
	  * @return string : HTML scripts infos
	  * @access public
	  */
	public function getObjectsInfos($user) {
		$objectsInfos = array();
		$cms_language = $user->getLanguage();
		if (APPLICATION_ENFORCES_ACCESS_CONTROL === false ||
			 (APPLICATION_ENFORCES_ACCESS_CONTROL === true
				&& $user->hasModuleClearance($this->getCodename(), CLEARANCE_MODULE_EDIT)) ) {
			$objectsInfos[] = array(
							'label'			=> $cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'),
							'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MANAGE_OBJECTS, array($cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'))),
							'description'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MANAGE_OBJECTS, array($cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'))),
							'objectId'		=> 'cms_aliases',
							'url'			=> PATH_ADMIN_MODULES_WR.'/cms_aliases/index.php',
							'module'		=> $this->getCodename(),
							'class'			=> 'atm-elements'
						);
		}
		return $objectsInfos;
	}
	
	/**
	  * Module autoload handler
	  *
	  * @param string $classname the classname required for loading
	  * @return string : the file to use for required classname
	  * @access public
	  */
	public function load($classname) {
		static $classes;
		if (!isset($classes)) {
			$classes = array(
				/**
				 * Module main classes
				 */
				'cms_resource_cms_aliases' 		=> PATH_MODULES_FS.'/cms_aliases/resource.php',
			);
		}
		$file = '';
		if (isset($classes[io::strtolower($classname)])) {
			$file = $classes[io::strtolower($classname)];
		}
		return $file;
	}
	
	/**
	  * Return a list of objects infos to be displayed in page properties tabs according to user privileges
	  *
	  * @return string : HTML scripts infos
	  * @access public
	  */
	public function getPageTabsProperties($page, $user) {
		$objectsInfos = array();
		$cms_language = $user->getLanguage();
		if ($user->hasModuleClearance($this->getCodename(), CLEARANCE_MODULE_EDIT)) {
			$objectsInfos[] = array(
							'label'			=> $cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'),
							'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MANAGE_OBJECTS, array($cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'))),
							'description'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MANAGE_OBJECTS, array($cms_language->getMessage(self::MESSAGE_CMS_ALIAS_ALIASES, false, 'cms_aliases'))),
							'objectId'		=> 'cms_aliases',
							'url'			=> PATH_ADMIN_MODULES_WR.'/cms_aliases/index.php',
							'module'		=> $this->getCodename(),
							'class'			=> 'atm-elements',
							'page'			=> $page->getID(),
						);
		}
		return $objectsInfos;
	}
	
	/**
	  * Return alias page URL if exists for a given page
	  *
	  * @param mixed $page the page or page Id to get URL of
	  * @param constant $relativeTo Return the alias path relative from webroot (default) or from filesystem (PATH_RELATIVETO_FILESYSTEM)
	  * @return string : the alias page url or false if none found
	  * @access public
	  */
	public function getPageURL($page, $relativeTo = PATH_RELATIVETO_WEBROOT) {
		$pageId = is_object($page) ? $page->getID() : $page;
		$sql = "
			select 
				id_ma
			from
				mod_cms_aliases
			where
				page_ma='".io::sanitizeSQLString($pageId)."'
				and replace_ma = 1";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			return false;
		}
		$alias = CMS_module_cms_aliases::getById($q->getValue('id_ma'));
		if (!$alias || $alias->hasError()) {
			return false;
		}
		return $alias->getPath(true, $relativeTo);
	}
	
	/**
	  * Return a valid page for a given URL
	  *
	  * @param string $pageUrl the page URL
	  * @param boolean $useDomain : use queried domain to found root page associated (default : true)
	  * @return CMS_page if page found, false otherwise
	  * @access public
	  */
	public function getPageFromURL($pageUrl, $useDomain = true) {
		$urlinfo = @parse_url($pageUrl);
		if (!isset($urlinfo['path'])) {
			//no alias can exists without path
			return false;
		}
		//strip final slash from path
		$urlinfo['path'] = substr($urlinfo['path'], -1) == '/' ? substr($urlinfo['path'], 0, -1) : $urlinfo['path'];
		//get aliases for current folder
		$array_temp = explode('/', $urlinfo['path']);
		$dirname = array_pop($array_temp);
		$aliases = CMS_module_cms_aliases::getByName($dirname);
		if (!$aliases) {
			return false;
		}
		//check each aliases returned to get the one which respond to current alias
		$matchAlias = false;
		$website = false;
		if ($useDomain) {
			$httpHost = @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
			//search page id by domain address
			$domain = isset($urlinfo['host']) ? $urlinfo['host'] : $httpHost;
			$website = CMS_websitesCatalog::getWebsiteFromDomain($domain);
		}
		foreach ($aliases as $alias) {
			if (!$matchAlias && $urlinfo['path'] == substr($alias->getPath(), 0, -1)) {
				//alias match path, check for website
				if (!$alias->getWebsites() || !$website || in_array($website->getId(), $alias->getWebsites())) {
					//alias match website, use it
					$matchAlias = $alias;
				}
			}
		}
		if (!$matchAlias) {
			return false;
		}
		//if alias is used as a page url, return page
		if ($matchAlias->urlReplaced()) {
			if (io::isPositiveInteger($matchAlias->getPageID())) {
				$page = CMS_tree::getPageById($matchAlias->getPageID());
			} else {
				return false;
			}
			if (!$page || $page->hasError()) {
				return false;
			}
			return $page;
		}
		return false;
	}
	
	/**
	  * Get all the sub-aliases of a given alias
	  *
	  * @param CMS_resource_cms_aliases $parent The parent of the sub-aliases to get or 0 to get first level or false to get all aliases recursively
	  * @param boolean $returnObject function return array of id (default) or array of CMS_resource_cms_aliases
	  * @return array
	  * @access public
	  * @static
	  */
	public static function getAll($parent, $returnObject=false) {
		if (io::isPositiveInteger($parent)) {
			$id = $parent;
		} elseif (is_a($parent, "CMS_resource_cms_aliases")) {
			$id = $parent->getID();
		} elseif ($parent === false) {
			$id = null;
		} else {
			$id = 0;
		}
		$sql = "
			select
				id_ma
			from
				mod_cms_aliases";
		if ($id !== null) {
			$sql .= " where parent_ma=".io::sanitizeSQLString($id);
		}
		$q = new CMS_query($sql);
		$result = array();
		while ($arr = $q->getArray()) {
			if ($returnObject) {
				$alias = CMS_module_cms_aliases::getByID($arr["id_ma"]);
				if ($alias/* && !$alias->hasError()*/) {
					$result[strtolower($alias->getAlias()).$alias->getID()] = $alias;
				}
			} else {
				$result[$arr["id_ma"]] = $arr["id_ma"];
			}
		}
		if ($returnObject) {
			ksort($result);
		}
		return $result;
	}
	
	/**
	  * Get all the sub-aliases of a given alias which contain the given page in tree
	  *
	  * @param CMS_resource_cms_aliases $parent The parent of the sub-aliases to get or 0 to get first level or false to get all aliases recursively
	  * @param boolean $returnObject function return array of id (default) or array of CMS_resource_cms_aliases
	  * @return array
	  * @access public
	  * @static
	  */
	public static function getAllByPage($parent, $pageId, $returnObject=false) {
		if (io::isPositiveInteger($parent)) {
			$id = $parent;
		} elseif (is_a($parent, "CMS_resource_cms_aliases")) {
			$id = $parent->getID();
		} elseif ($parent === false) {
			$id = null;
		} else {
			$id = 0;
		}
		$sql = "
			select 
				id_ma
			from
				mod_cms_aliases
			where
				page_ma='".io::sanitizeSQLString($pageId)."'";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			return array();
		}
		$aliasesIds = array();
		while ($r = $q->getArray()) {
			$aliasesIds[$r['id_ma']] = $r['id_ma'];
			$alias = CMS_module_cms_aliases::getByID($r["id_ma"]);
			if ($alias/* && !$alias->hasError()*/) {
				$lineage = $alias->getAliasLineAge(true);
				foreach ($lineage as $anAlias) {
					$aliasesIds[$anAlias->getID()] = $anAlias->getID();
				}
			}
		}
		$sql = "
			select
				id_ma
			from
				mod_cms_aliases
			 where 
			 	id_ma in (".implode(',', $aliasesIds).")";
		if ($id !== null) {
			$sql .= " and parent_ma=".io::sanitizeSQLString($id);
		}
		$q = new CMS_query($sql);
		$result = array();
		while ($arr = $q->getArray()) {
			if ($returnObject) {
				$alias = CMS_module_cms_aliases::getByID($arr["id_ma"]);
				if ($alias && !$alias->hasError()) {
					$result[strtolower($alias->getAlias()).$alias->getID()] = $alias;
				}
			} else {
				$result[$arr["id_ma"]] = $arr["id_ma"];
			}
		}
		if ($returnObject) {
			ksort($result);
		}
		return $result;
	}
	
	/**
	  * Get all the aliases for a given name
	  *
	  * @param string $name The name to get aliases of
	  * @param boolean $returnObject function return array of id or array of CMS_resource_cms_aliases (default)
	  * @return array
	  * @access public
	  * @static
	  */
	public static function getByName($name, $returnObject = true) {
		if (!$name || $name != sensitiveIO::sanitizeAsciiString($name, '@')) {
			return array();
		}
		$sql = "
			select
				id_ma
			from
				mod_cms_aliases
			where 
				alias_ma='".io::sanitizeSQLString($name)."'
			order by id_ma asc";
		$q = new CMS_query($sql);
		$result = array();
		while ($arr = $q->getArray()) {
			if ($returnObject) {
				$alias = CMS_module_cms_aliases::getByID($arr["id_ma"]);
				if ($alias && !$alias->hasError()) {
					$result[$arr["id_ma"]] = $alias;
				}
			} else {
				$result[$arr["id_ma"]] = $arr["id_ma"];
			}
		}
		return $result;
	}
	
	/**
	  * Gets alias by its internal ID
	  *
	  * @param integer $id The DB ID of the alias to get
	  * @return CMS_resource_cms_aliases or false if not found
	  * @access public
	  * @static
	  */
	public static function getByID($id, $reset = false) {
		if (!SensitiveIO::isPositiveInteger($id)) {
			CMS_grandFather::raiseError("Id must be positive integer : ".$id.' - '.io::getCallInfos());
			return false;
		}
		static $aliases;
		if (isset($aliases[$id]) && !$reset) {
			return $aliases[$id];
		}
		$aliases[$id] = new CMS_resource_cms_aliases($id);
		/*if ($aliases[$id]->hasError()) {
			$aliases[$id] = false;
		}*/
		return $aliases[$id];
	}
	
	/**
	* Create the redirection of an alias
	*
	* @return boolean true on success, false on failure
	* @access public
	* @static
	*/
	public static function redirect() {
		//get aliases for current folder
		$arrayDirname = explode(DIRECTORY_SEPARATOR, dirname($_SERVER['SCRIPT_NAME']));
		$dirname = array_pop($arrayDirname);
		$aliases = CMS_module_cms_aliases::getByName($dirname);
		if (!$aliases) {
			//no alias found, go to 404
			CMS_grandFather::raiseError('No alias found for directory '.dirname($_SERVER['SCRIPT_NAME']));
			CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
		}
		//check each aliases returned to get the one which respond to current alias
		$matchAlias = false;
		$domain = @parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST) ? @parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST) : (@parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST']);
		$websites = array();
		if ($domain) {
			$websites = CMS_websitesCatalog::getWebsitesFromDomain($domain);
		}
		foreach ($aliases as $alias) {
			if (!$matchAlias && dirname($_SERVER['SCRIPT_NAME']) == substr($alias->getPath(), 0, -1)) {
				if ($websites) {
					foreach ($websites as $website) {
						//alias match path, check for website
						if (!$alias->getWebsites() || !$website || in_array($website->getId(), $alias->getWebsites())) {
							//alias match website, use it
							$matchAlias = $alias;
						}
					}
				} else {
					//alias match path, check for website
					if (!$alias->getWebsites()) {
						//alias match website, use it
						$matchAlias = $alias;
					}
				}
			}
		}
		
		if (!$matchAlias) {
			//no alias found, go to 404
			CMS_grandFather::raiseError('No alias found for directory '.dirname($_SERVER['SCRIPT_NAME']).' and domain '.$domain);
			CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
		}
		//if alias is used as a page url, return page
		if ($matchAlias->urlReplaced()) {
			if (io::isPositiveInteger($matchAlias->getPageID())) {
				$page = CMS_tree::getPageById($matchAlias->getPageID());
			} else {
				//no valid page set, go to 404
				$matchAlias->setError('No page set for alias '.$matchAlias->getID());
				CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
			}
			if (!$page || $page->hasError()) {
				//no valid page found, go to 404
				$matchAlias->setError('Invalid page '.$matchAlias->getPageID().' for alias '.$matchAlias->getID());
				CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
			}
			//return page path
			$pPath = $page->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
			if ($pPath) {
				if (file_exists($pPath)) {
					return $pPath;
				} elseif ($page->regenerate(true)) {
					clearstatcache ();
					if (file_exists($pPath)) {
						return $pPath;
					}
				}
			}
			//no valid url page found, go to 404
			$matchAlias->setError('Invalid url page '.$matchAlias->getPageID().' for alias '.$matchAlias->getID());
			CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
		} else {
			//this is a redirection
			$params = (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
			if (isset($_SERVER['HTTP_REFERER'])) {
				header("Referer: ".$_SERVER['HTTP_REFERER']);
			}
			if (io::isPositiveInteger($matchAlias->getPageID())) {
				//it's a redirection to an Automne Page
				$page = CMS_tree::getPageById($matchAlias->getPageID());
				if ($page && !$page->hasError()) {
					$pageURL = CMS_tree::getPageValue($matchAlias->getPageID(), 'url');
					if ($pageURL) {
						CMS_view::redirect($pageURL.$params, true, ($matchAlias->isPermanent() ? 301 : 302));
					} else {
						//no valid url page found, go to 404
						$matchAlias->setError('Invalid url page '.$matchAlias->getPageID().' for alias '.$matchAlias->getID());
						CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
					}
				}  else {
					//no valid page found, go to 404
					$matchAlias->setError('Invalid page '.$matchAlias->getPageID().' for alias '.$matchAlias->getID());
					CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
				}
			} elseif ($matchAlias->getURL()) {
				//it's a redirection to an URL
				CMS_view::redirect($matchAlias->getURL(), true, ($matchAlias->isPermanent() ? 301 : 302));
			} else {
				//no valid redirection found, go to 404
				$matchAlias->setError('Invalid redirection for alias '.$matchAlias->getID());
				CMS_view::redirect(PATH_SPECIAL_PAGE_NOT_FOUND_WR, true, 301);
			}
		}
	}
}
?>