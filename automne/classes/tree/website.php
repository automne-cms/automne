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
// $Id: website.php,v 1.7 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_website
  *
  * represent a website placed on a page in the tree structure. A websites defines mainly a directory
  * where the pages files will be placed. 
  * Beware ! Because of the label-to-directory relationship, label should'nt be changeable after the website creation.
  * This condition is enforced here.
  *
  * @package Automne
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_website extends CMS_grandFather
{
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * Label of the website
	  * @var string
	  * @access private
	  */
	protected $_label;

	/**
	  * Codename of the website
	  * @var string
	  * @access private
	  */
	protected $_codename;

	/**
	  * URL of the website (does NOT start with http://)
	  * @var string
	  * @access private
	  */
	protected $_url;

	/**
	  * Alternative domains of the website
	  * @var string
	  * @access private
	  */
	protected $_altdomains;
	
	/**
	  * Does alternative domains should be redirected to main domain ?
	  * @var boolean
	  * @access private
	  */
	protected $_altredir = false;
	
	/**
	  * Root page.
	  * @var CMS_page
	  * @access private
	  */
	protected $_root;

	/**
	  * Is this website the main website ?
	  * @var boolean
	  * @access private
	  */
	protected $_isMain = false;

	/**
	  * Website order
	  * @var integer
	  * @access private
	  */
	protected $_order;

	/**
	  * Default Meta values for website
	  * @var boolean
	  * @access private
	  */
	protected $_meta = array(
		'keywords' => '',
		'description' => '',
		'category' => '',
		'author' => '',
		'replyto' => '',
		'copyright' => '',
		'language' => '',
		'robots' => '',
		'favicon' => '',
		'metas' => '',
	);
	
	/**
	  * Website 403 page
	  * @var integer
	  * @access private
	  */
	protected $_403;
	
	/**
	  * Website 404 page
	  * @var integer
	  * @access private
	  */
	protected $_404;

	
	/**
	  * Constructor.
	  * initializes the website if the id is given.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function __construct($id = 0)
	{
		static $applicationWebroot;
		if ($id) {
			if (($id == 1 && !is_object($applicationWebroot)) || $id != 1) {
				if (!SensitiveIO::isPositiveInteger($id)) {
					$this->raiseError("Id is not a positive integer");
					return;
				}
				$sql = "
					select
						*
					from
						websites
					where
						id_web='$id'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$this->_id = $id;
					$this->_label = $data["label_web"];
					$this->_codename = isset($data["codename_web"]) ? $data["codename_web"] : '';
					$this->_url = $data["url_web"];
					$this->_altdomains = $data["altdomains_web"];
					$this->_altredir = $data["altredir_web"] ? true : false;
					$this->_root = new CMS_page($data["root_web"]);
					$this->_order = $data["order_web"];
					$this->_403 = $data["403_web"];
					$this->_404 = $data["404_web"];
					//the main website has The main page (ID 1) as root
					if ($data["root_web"] == APPLICATION_ROOT_PAGE_ID) {
						$this->_isMain = true;
					}
					$this->_meta['keywords'] = $data["keywords_web"];
					$this->_meta['description'] = $data["description_web"];
					$this->_meta['category'] = $data["category_web"];
					$this->_meta['author'] = $data["author_web"];
					$this->_meta['replyto'] = $data["replyto_web"];
					$this->_meta['copyright'] = $data["copyright_web"];
					$this->_meta['language'] = $data["language_web"];
					$this->_meta['robots'] = $data["robots_web"];
					$this->_meta['favicon'] = $data["favicon_web"];
					$this->_meta['metas'] = $data["metas_web"];
				} else {
					$this->raiseError("Unknown ID :".$id);
				}
				if ($id == 1) {
					$applicationWebroot = $this;
				}
			} else {
				$this->_id = $id;
				$this->_label = $applicationWebroot->_label;
				$this->_codename = $applicationWebroot->_codename;
				$this->_url = $applicationWebroot->_url;
				$this->_altdomains = $applicationWebroot->_altdomains;
				$this->_root = $applicationWebroot->_root;
				$this->_order = $applicationWebroot->_order;
				$this->_403 = $applicationWebroot->_403;
				$this->_404 = $applicationWebroot->_404;
				$this->_isMain = $applicationWebroot->_isMain;
				$this->_meta = $applicationWebroot->_meta;
			}
		}
	}
	
	/**
	  * Gets the DB ID of the instance.
	  *
	  * @return integer the DB id
	  * @access public
	  */
	function getID()
	{
		return $this->_id;
	}
	
	/**
	  * Get a website meta value
	  *
	  * @param string $meta The meta name to get
	  * @return string the website meta value
	  * @access public
	  */
	function getMeta($meta) {
		if (!isset($this->_meta[$meta])) {
			$this->raiseError("Unknown meta to get : ".$meta);
			return false;
		}
		return $this->_meta[$meta];
	}
	
	/**
	  * Set a website meta value
	  *
	  * @param string $meta The meta name to set
	  * @param string $value The meta value to get
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setMeta($meta, $value) {
		if (!isset($this->_meta[$meta])) {
			$this->raiseError("Unknown meta to set : ".$meta);
			return false;
		}
		$this->_meta[$meta] = $value;
		return true;
	}
	
	/**
	  * Is this the main website ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isMain()
	{
		return $this->_isMain;
	}
	
	/**
	  * Gets the label
	  *
	  * @return string The label
	  * @access public
	  */
	function getLabel()
	{
		return $this->_label;
	}
	
	/**
	  * Sets the label.
	  *
	  * @param string $label The label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setLabel($label)
	{
		$this->_label = $label;
		return true;
	}
	
	/**
	  * Gets the 404 page
	  *
	  * @param boolean $returnObject Return a public CMS_page. If false, return only page Id (default : true)
	  * @return mixed The 404 CMS_page object if any and public or false if none found
	  * @access public
	  */
	function get404($returnObject = true)
	{
		if (!io::isPositiveInteger($this->_404)) {
			return false;
		}
		if (!$returnObject) {
			return $this->_404;
		}
		$page = CMS_tree::getPageById($this->_404);
		if ($page && !$page->hasError() && $page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
			return $page;
		}
		return false;
	}
	
	/**
	  * Sets the 404 page Id for the website
	  *
	  * @param integer $pageId The 404 page Id to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function set404($pageId)
	{
		if ($pageId && !io::isPositiveInteger($pageId)) {
			return false;
		}
		$this->_404 = $pageId;
		return true;
	}
	
	/**
	  * Gets the 403 page
	  *
	  * @param boolean $returnObject Return a public CMS_page. If false, return only page Id (default : true)
	  * @return mixed The 403 CMS_page object if any and public or false if none found
	  * @access public
	  */
	function get403($returnObject = true)
	{
		if (!io::isPositiveInteger($this->_403)) {
			return false;
		}
		if (!$returnObject) {
			return $this->_403;
		}
		$page = CMS_tree::getPageById($this->_403);
		if ($page && !$page->hasError() && $page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
			return $page;
		}
		return false;
	}
	
	/**
	  * Sets the 403 page Id for the website
	  *
	  * @param integer $pageId The 403 page Id to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function set403($pageId)
	{
		if ($pageId && !io::isPositiveInteger($pageId)) {
			return false;
		}
		$this->_403 = $pageId;
		return true;
	}
	
	/**
	  * Gets the Codename
	  *
	  * @return string The Codename
	  * @access public
	  */
	function getCodename()
	{
		return $this->_codename;
	}
	
	/**
	  * Sets the Codename.
	  *
	  * @param string $codename The Codename to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setCodename($codename)
	{
		//codename should'nt be changed once set
		if ($this->_id) {
			$this->raiseError("Trying to change the codename of a website already existing");
			return false;
		}
		if ($codename) {
			$old_codename = $this->_codename;
			$this->_codename = $codename;
			
			//now test to see if a directory already exists with that name (Because codename must _not_ be moveable once set)
			if (!$this->_isMain && CMS_websitesCatalog::getByCodename($this->_codename)) {
				$this->_codename = $old_codename;
				$this->raiseError("Codename to set has same directory for pages than a previously set one.");
				return false;
			} else {
				return true;
			}
		} else {
			$this->raiseError("Codename can't be empty");
			return false;
		}
	}
	
	/**
	  * Gets the url (including http://).
	  *
	  * @return string the URL
	  * @access public
	  */
	function getURL($includeHTTP = true)
	{
		//strip final slash
		if (io::substr($this->_url, io::strlen($this->_url) - 1) == "/") {
			$this->_url = io::substr($this->_url, 0, -1);
		}
		if ($includeHTTP) {
			return (io::substr($this->_url,0,4) != 'http') ? "http://".$this->_url : $this->_url;
		} else {
			return (io::substr($this->_url,0,4) != 'http') ? $this->_url : io::substr($this->_url,7);
		}
	}
	
	/**
	  * Sets the url. Can be empty. Will be riden of http://.
	  *
	  * @param string $url The url to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setURL($url)
	{
		if (io::substr($url, 0, 7) == "http://") {
			$url = io::substr($url, 7);
		}
		if ($url) {
			//strip final slash
			if (io::substr($url, io::strlen($url) - 1) == "/") {
				$url = io::substr($url, 0, -1);
			}
			$this->_url = $url;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the alternatives domains (including http://).
	  *
	  * @return array the URL of alternatives domains
	  * @access public
	  */
	function getAltDomains($includeHTTP = true)
	{
		if (!$this->_altdomains) {
			return array();
		}
		$domains = explode(';', $this->_altdomains);
		$return = array();
		foreach ($domains as $domain) {
			if ($includeHTTP) {
				$return[] = (io::substr($domain,0,4) != 'http') ? "http://".$domain : $domain;
			} else {
				$return[] = (io::substr($domain,0,4) != 'http') ? $domain : io::substr($domain,7);
			}
		}
		return $return;
	}
	
	/**
	  * Sets the alternatives domains url. Can be empty. Will be riden of http://.
	  *
	  * @param string $url The url to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setAltDomains($domains)
	{
		if (!$domains) {
			$this->_altdomains = '';
			return true;
		}
		$this->_altdomains = '';
		$domains = str_replace(CHR(13).CHR(10),";", $domains);
		$domains = explode(';', $domains);
		foreach ($domains as $domain) {
			if (io::substr($domain, 0, 7) == "http://") {
				$domain = io::substr($domain, 7);
			}
			if ($domain) {
				$this->_altdomains .= $this->_altdomains ? ';' : '';
				if (io::substr($domain, io::strlen($domain) - 1) == "/") {
					$domain = io::substr($domain, 0, -1);
				}
				$this->_altdomains .= $domain;
			}
		}
		return true;
	}
	
	/**
	  * Should we redirect altdomains to main domain
	  *
	  * @return boolean
	  * @access public
	  */
	function redirectAltDomain()
	{
		return $this->_altredir ? true : false;
	}
	
	/**
	  * Sets the redirect altdomains to main domain status
	  *
	  * @param boolean $altredir redirect status
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setRedirectAltDomain($altredir)
	{
		$this->_altredir = $altredir ? true : false;
		return true;
	}
	
	
	/**
	  * Gets the root page.
	  *
	  * @return CMS_page The Root page
	  * @access public
	  */
	function getRoot()
	{
		return $this->_root;
	}
	
	/**
	  * Sets the root page.
	  *
	  * @param CMS_page $page The new root page to set.
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRoot($page)
	{
		if (is_a($page, "CMS_page")) {
			$ws = CMS_tree::getPageWebsite($page);
			if ($ws->getRoot() == $page && $ws->getID() != $this->_id) {
				$this->raiseError("Root page to set is already a root page for the website : ".$ws->getLabel());
				return false;
			} else {
				$this->_root = $page;
				return true;
			}
		} else {
			$this->raiseError("Root page to set is not a page");
			return false;
		}
	}
	
	/**
	  * Gets the pages directory. It's derived from the label
	  *
	  * @param string $relativeTo Can be PATH_RELATIVETO_WEBROOT for relative to website root, or PATH_RELATIVETO_FILESYSTEM for relative to filesystem root
	  * @return string The pages directory.
	  * @access public
	  */
	function getPagesPath($relativeTo)
	{
		if ($this->_codename) {
			if (SensitiveIO::isInSet($relativeTo, array(PATH_RELATIVETO_WEBROOT, PATH_RELATIVETO_FILESYSTEM))) {
				$relative = ($relativeTo == PATH_RELATIVETO_WEBROOT) ? PATH_PAGES_WR : PATH_PAGES_FS;
				if ($this->_isMain) {
					if (!is_dir(PATH_PAGES_FS)) {
						if (!CMS_file::makeDir(PATH_PAGES_FS)) {
							$this->raiseError('Can\'t create pages dir : '.PATH_PAGES_FS);
						}
					}
					return $relative;
				} else {
					if (!is_dir(PATH_PAGES_FS."/".io::sanitizeAsciiString($this->_codename))) {
						if (!CMS_file::makeDir(PATH_PAGES_FS."/".io::sanitizeAsciiString($this->_codename))) {
							$this->raiseError('Can\'t create pages dir : '.PATH_PAGES_FS.'/'.io::sanitizeAsciiString($this->_codename));
						}
					}
					return $relative.'/'.io::sanitizeAsciiString($this->_codename);
				}
			} else {
				$this->raiseError("Can't give pages path relative to anything other than WR or FS");
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the pages directory. It's derived from the label
	  *
	  * @param string $relativeTo Can be PATH_RELATIVETO_WEBROOT for relative to website root, or PATH_RELATIVETO_FILESYSTEM for relative to filesystem root
	  * @return string The pages directory.
	  * @access public
	  */
	function getHTMLPagesPath($relativeTo)
	{
		if (io::isInSet($relativeTo, array(PATH_RELATIVETO_WEBROOT, PATH_RELATIVETO_FILESYSTEM))) {
			$relative = ($relativeTo == PATH_RELATIVETO_WEBROOT) ? PATH_PAGES_HTML_WR : PATH_PAGES_HTML_FS;
			return $relative;
		} else {
			$this->raiseError("Can't give pages path relative to anything other than WR or FS");
			return false;
		}
	}
	
	/**
	  * Totally destroys the website, including its directory
	  * After deletion from database, launch a regen of the whole tree.
	  *
	  * @return void
	  * @access public
	  */
	function destroy()
	{
		if ($this->_id) {
			$sql = "
				delete
				from
					websites
				where
					id_web='".$this->_id."'
			";
			$q = new CMS_query($sql);
			
			//deletes the pages directory (with all the pages inside)
			if (!$this->_isMain) {
				$dir = $this->getPagesPath(PATH_RELATIVETO_FILESYSTEM);
				if ($opendir = @opendir($dir)) {
					while (false !== ($readdir = readdir($opendir))) {
						if($readdir !== '..' && $readdir !== '.') {
							$readdir = trim($readdir);
							if (is_file($dir.'/'.$readdir)) {
								@unlink($dir.'/'.$readdir);
							}
						}
					}
					closedir($opendir);
					@rmdir($dir);
				}
			}
			
			//regenerates all the pages
			CMS_tree::regenerateAllPages(true);
		}
		unset($this);
	}
	
	/**
	  * Writes the website into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if (!sensitiveIO::isPositiveInteger($this->_order)) {
			//get max order
			$sql = "
				select 
					max(order_web) as order_max
				from
					websites
			";
			$q = new CMS_query($sql);
			if ($q->hasError() || !$q->getNumRows()) {
				CMS_grandFather::raiseError('Error to get max order from websites table ... ');
				return false;
			}
			$this->_order = ($q->getValue('order_max')+1) ;
		}
		$sql_fields = "
			label_web='".SensitiveIO::sanitizeSQLString($this->_label)."',
			codename_web='".SensitiveIO::sanitizeSQLString($this->_codename)."',
			url_web='".SensitiveIO::sanitizeSQLString($this->_url)."',
			altdomains_web='".SensitiveIO::sanitizeSQLString($this->_altdomains)."',
			altredir_web='".($this->_altredir ? 1 : 0)."',
			root_web='".$this->_root->getID()."',
			keywords_web='".SensitiveIO::sanitizeSQLString($this->_meta['keywords'])."',
			description_web='".SensitiveIO::sanitizeSQLString($this->_meta['description'])."',
			category_web='".SensitiveIO::sanitizeSQLString($this->_meta['category'])."',
			author_web='".SensitiveIO::sanitizeSQLString($this->_meta['author'])."',
			replyto_web='".SensitiveIO::sanitizeSQLString($this->_meta['replyto'])."',
			copyright_web='".SensitiveIO::sanitizeSQLString($this->_meta['copyright'])."',
			language_web='".SensitiveIO::sanitizeSQLString($this->_meta['language'])."',
			robots_web='".SensitiveIO::sanitizeSQLString($this->_meta['robots'])."',
			favicon_web='".SensitiveIO::sanitizeSQLString($this->_meta['favicon'])."',
			metas_web='".SensitiveIO::sanitizeSQLString($this->_meta['metas'])."',
			order_web='".SensitiveIO::sanitizeSQLString($this->_order)."',
			403_web='".SensitiveIO::sanitizeSQLString($this->_403)."',
			404_web='".SensitiveIO::sanitizeSQLString($this->_404)."'
		";
		if ($this->_id) {
			$sql = "
				update
					websites
				set
					".$sql_fields."
				where
					id_web='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					websites
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		//create the page directory
		if (!is_dir($this->getPagesPath(PATH_RELATIVETO_FILESYSTEM))) {
			@mkdir($this->getPagesPath(PATH_RELATIVETO_FILESYSTEM));
			@chmod($this->getPagesPath(PATH_RELATIVETO_FILESYSTEM), octdec(DIRS_CHMOD));
		}
		return true;
	}
	
	/**
	  * Get all pages codenames for website
	  *
	  * @return array(codename => pageId)
	  * @access public
	  */
	function getAllPagesCodenames() {
		$pageIds = CMS_tree::getAllSiblings($this->_root->getID(), false, true);
		if (!is_array($pageIds)) {
			$pageIds = array();
		}
		$pageIds[] = $this->_root->getID();
		//pr($pagesIds);
		$q = new CMS_query("
			select
				page_pbd, codename_pbd
			from
				pagesBaseData_edited
			where
				page_pbd in (".implode(',', $pageIds).")
				and codename_pbd != ''
		");
		$pagesCodenames = $q->getAll();
		$codenames = array();
		foreach ($pagesCodenames as $pageCodename) {
			$codenames[$pageCodename['codename_pbd']] = $pageCodename['page_pbd'];
		}
		return $codenames;
	}
}
?>