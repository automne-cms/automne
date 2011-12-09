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
  * Class CMS_resource_cms_aliases
  *
  * represent a resource of the aliases module
  *
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resource_cms_aliases extends CMS_resource
{
	/**
	  * alias DB id
	  * @var integer
	  * @access private
	  */
	protected $_ID;

	/**
	  * Title of the alias
	  * @var string
	  * @access private
	  */
	protected $_alias;

	/**
	  * parent alias DB ID
	  * @var integer or 0 if no parent
	  * @access private
	  */
	protected $_parentID = 0;

	/**
	  * page ID
	  * @var integer
	  * @access private
	  */
	protected $_pageID;

	/**
	  * url
	  * @var string
	  * @access private
	  */
	protected $_url;

	/**
	  * Websites
	  * @var string
	  * @access private
	  */
	protected $_websites;

	/**
	  * Replace page URL
	  * @var boolean
	  * @access private
	  */
	protected $_replace = false;
	protected $_needRegen = false;

	/**
	  * Permanent
	  * @var boolean
	  * @access private
	  */
	protected $_permanent = false;

	/**
	  * Protected
	  * @var boolean
	  * @access private
	  */
	protected $_protected;

	/**
	  * Constructor.
	  * initializes the page if the id is given.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function __construct($id = 0)
	{
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					mod_cms_aliases
				where
					id_ma='$id'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_ID = $id;
				$this->_alias = $data["alias_ma"];
				$this->_parentID = $data["parent_ma"];
				$this->_pageID = $data["page_ma"];
				$this->_url = $data["url_ma"];
				$this->_websites = $data["websites_ma"];
				$this->_replace = $data["replace_ma"] ? true : false;
				$this->_permanent = $data["permanent_ma"] ? true : false;
				$this->_protected = $data["protected_ma"] ? true : false;
				if (!$this->_checkfiles()) {
					$this->raiseError('Alias files does not exists and cannot be recreated: '.$this->getPath(true, PATH_RELATIVETO_FILESYSTEM));
				}
			} else {
				$this->raiseError("Unknown ID :".$id);
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
		return $this->_ID;
	}
	
	/**
	  * Gets the title of the alias
	  *
	  * @return string The title
	  * @access public
	  */
	function getAlias()
	{
		return $this->_alias;
	}
	
	/**
	  * Sets the title of the alias
	  *
	  * @param string $alias The title to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setAlias($alias)
	{
		//clean alias characters
		$alias = sensitiveIO::sanitizeURLString($alias);
		//check if alias directory already exists
		if (@is_dir($this->getPath(false, PATH_RELATIVETO_FILESYSTEM).'/'.$alias)) {
			//check if directory is used by another alias
			$aliases = CMS_module_cms_aliases::getByName($alias);
			$otherAlias = false;
			$otherAliasesUsesWebsites = array();
			foreach($aliases as $anAlias) {
				if ($this->getID() != $anAlias->getID() && $this->getPath(false).$alias.'/' == $anAlias->getPath(true)) {
					//check websites of other aliases. It must not use same domain as current one
					if (!$anAlias->getWebsites()) {
						//this other alias use all domains, so current alias can never be used
						return false;
					} else {
						$otherAliasesUsesWebsites = array_merge($anAlias->getWebsites(), $otherAliasesUsesWebsites);
					}
					$otherAlias = true;
				}
			}
			if (!$otherAlias) {
				//no other alias use this directory, so it is used by something else
				return false;
			} elseif($otherAliasesUsesWebsites) {
				//check if this alias can be used by a website
				$otherAliasesUsesWebsites = array_unique($otherAliasesUsesWebsites);
				if ($this->getWebsites()) {
					$websites = $this->getWebsites();
				} else {
					$websites = array_keys(CMS_websitesCatalog::getAll());
				}
				$freeWebsite = array();
				foreach ($websites as $codename) {
					if (!in_array($codename, $otherAliasesUsesWebsites)) {
						$freeWebsite[] = $codename;
					}
				}
				if (!$freeWebsite) {
					//no free website for this alias
					return false;
				}
				//limit alias to free websites
				$this->setWebsites($freeWebsite);
			}
		}
		//alias already exists, check if alias name change. If so, delete old files
		if ($this->getID() && $this->_alias != $alias) {
			$this->_deleteFiles();
		}
		$this->_alias = $alias;
		return true;
	}
	
	/**
	  * Get alias path
	  *
	  * @param boolean $withName Return the alias name in path
	  * @param constant $relativeTo Return the alias path relative from webroot (default) or from filesystem (PATH_RELATIVETO_FILESYSTEM)
	  * @return string : the alias path
	  * @access public
	  */
	function getPath($withName = true, $relativeTo = PATH_RELATIVETO_WEBROOT) {
		$path = ($relativeTo == PATH_RELATIVETO_WEBROOT) ? PATH_REALROOT_WR.'/' : PATH_REALROOT_FS.'/';
		if ($withName) {
			return $path.$this->getAliasLineAge().$this->getAlias().'/';
		} else {
			return $path.$this->getAliasLineAge();
		}
	}
	
	/**
	  * Sets the parent
	  *
	  * @param CMS_resource_cms_aliases $parent The parent to set or false if alias has no parent
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setParent($parent)
	{
		if (is_a($parent, "CMS_resource_cms_aliases")) {
			//delete old alias files if any
			if ($this->getID() && $this->_parentID != $parent->getID()) {
				$this->_deleteFiles();
			}
			$this->_parentID = $parent->getID();
			return true;
		} elseif ($parent === false) {
			//delete old alias files if any
			if ($this->getID() && $this->_parentID !== 0) {
				$this->_deleteFiles();
			}
			$this->_parentID = 0;
			return false;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the parent
	  *
	  * @return integer of The parent
	  * @access public
	  */
	function getParent()
	{
		return $this->_parentID;
	}
	
	/**
	  * Gets the redirection URL
	  *
	  * @return string the URL
	  * @access public
	  */
	function getURL()
	{
		return $this->_url;
	}
	
	/**
	  * Sets the redirection URL
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setURL($url)
	{
		$this->_url = (io::substr($url,0,4) == 'http') ? $url : 'http://'.$url;
		$this->_pageID ='';
		return true;
	}
	
	/**
	  * Gets the redirection page ID
	  *
	  * @return integer The ID of the page
	  * @access public
	  */
	function getPageID()
	{
		return $this->_pageID;
	}
	
	/**
	  * Sets the redirection page
	  *
	  * @param CMS_page $page The page to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setPage($page)
	{
		if (is_a($page, "CMS_page") && !$page->hasError()) {
			if ($this->_replace) {
				//check if another alias already replace this page URL
				$sql = "
					select 
						id_ma
					from
						mod_cms_aliases
					where
						page_ma='".io::sanitizeSQLString($page->getID())."'
						and replace_ma='1'";
				if ($this->getID()) {
					$sql .= " and id_ma != '".$this->getID()."'";
				}
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					return false;
				}
			}
			$this->_pageID = $page->getID();
			$this->_url = '';
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the websites codenames on which alias is restricted.
	  * If none, all websites use this alias
	  *
	  * @return array of websites codenames
	  * @access public
	  */
	function getWebsites() {
		return $this->_websites ? explode(';', $this->_websites) : array();
	}
	
	/**
	  * Sets the websites codename on which alias is restricted
	  * If none, all websites use this alias
	  *
	  * @param array $websites : array of websites codenames
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setWebsites($websites) {
		if (!is_array($websites)) {
			$this->raiseError('websites must be an array');
			return false;
		}
		$this->_websites = implode(';', $websites);
		return true;
	}
	
	/**
	  * Does this alias replace target page URL ?
	  *
	  * @return boolean
	  * @access public
	  */
	function urlReplaced() {
		return $this->_replace ? true : false;
	}
	
	/**
	  * Sets the replace URL status
	  *
	  * @param boolean $replace : the replace status
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setReplaceURL($replace) {
		if ($this->_replace && !$replace) {
			$this->_needRegen = true;
		}
		$this->_replace = $replace ? true : false;
		return true;
	}
	
	/**
	  * Is this alias permanent (redirection 301) ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isPermanent() {
		return $this->_permanent ? true : false;
	}
	
	/**
	  * Sets the permanent status
	  *
	  * @param boolean $permanent : the permanent status
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setPermanent($permanent) {
		$this->_permanent = $permanent ? true : false;
		return true;
	}
	
	/**
	  * Is this alias protected
	  *
	  * @return boolean
	  * @access public
	  */
	function isProtected() {
		return $this->_protected ? true : false;
	}
	
	/**
	  * Sets the protected status
	  *
	  * @param boolean $protected : the protected status
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setProtected($protected) {
		$this->_protected = $protected ? true : false;
		return true;
	}
	
	/**
	  * Writes the alias into persistence and create files if needed
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		//save data
		$sql_fields = "
			parent_ma='".SensitiveIO::sanitizeSQLString($this->_parentID)."',
			page_ma='".SensitiveIO::sanitizeSQLString($this->_pageID)."',
			url_ma='".SensitiveIO::sanitizeSQLString($this->_url)."',
			alias_ma='".SensitiveIO::sanitizeSQLString($this->_alias)."',
			websites_ma='".SensitiveIO::sanitizeSQLString($this->_websites)."',
			replace_ma='".($this->_replace ? 1 : 0)."',
			permanent_ma='".($this->_permanent ? 1 : 0)."',
			protected_ma='".($this->_protected ? 1 : 0)."'
		";
		
		if ($this->_ID) {
			$sql = "
				update
					mod_cms_aliases
				set
					".$sql_fields."
				where
					id_ma='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					mod_cms_aliases
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}
		//regenerate pages if needed
		$this->_regenerate();
		
		return $this->createRedirectionFile();
	}
	
	/**
	  * Get the lineAge of an alias
	  *
	  * @param boolean $returnObject function return lineAge string or array of CMS_resource_cms_aliases
	  * @return array or string
	  * @access public
	  */
	function getAliasLineAge($returnObject=false) {
		static $aliasesLineAge;
		if (!isset($aliasesLineAge[$this->getID()])) {
			$aliasesLineAge[$this->getID()] = array();
			if ($this->getParent()) {
				$aliasesLineAge[$this->getID()] = array();
				$parent = CMS_module_cms_aliases::getByID($this->_parentID);
				while($parent && $parent->getID() != 0) {
					$aliasesLineAge[$this->getID()][$parent->getID()] = $parent;
					if ($parent->getParent()) {
						$parent = CMS_module_cms_aliases::getByID($parent->getParent());
					} else {
						$parent = '';
					}
				}
			}
			$aliasesLineAge[$this->getID()] = array_reverse($aliasesLineAge[$this->getID()], true);
		}
		if ($returnObject) {
			return $aliasesLineAge[$this->getID()];
		} else {
			$lineAgeString='';
			foreach ($aliasesLineAge[$this->getID()] as $anAlias) {
				$lineAgeString .= $anAlias->getAlias()."/";
			}
			return $lineAgeString;
		}
	}
	
	/**
	  * alias have sub-aliases ?
	  *
	  * @return boolean true or false
	  * @access public
	  */
	function hasSubAliases() 
	{
		if (!$this->getID()) {
			return false;
		}
		$sql = "
			select
				id_ma
			from
				mod_cms_aliases
			where
				parent_ma=".$this->_ID."
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true:false;
	}
	
	/**
	  * Create the folder of an alias
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	private function _checkfiles() {
		//check if alias directory already exists
		if (!@is_dir($this->getPath(true, PATH_RELATIVETO_FILESYSTEM))) {
			return $this->createRedirectionFile();
		} elseif (!is_file($this->getPath(true, PATH_RELATIVETO_FILESYSTEM).'index.php')) {
			return $this->createRedirectionFile();
		}
		return true;
	}
	
	/**
	  * Create the folder of an alias
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	private function _createFolder() 
	{
		if (!$this->getAlias()) {
			$this->raiseError("Must have an alias name to create directory");
			return false;
		}
		if (!CMS_file::makeDir($this->getPath(true, PATH_RELATIVETO_FILESYSTEM))) {
			$this->raiseError("Cannot create directory ".$this->getPath(true, PATH_RELATIVETO_FILESYSTEM));
			return false;
		}
		return true;
	}
	
	/**
	  * Create the redirection file (index.php) of an alias
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function createRedirectionFile() {
		if (!$this->_createFolder()) {
			return false;
		}
		//get alias position
		$pos = substr_count('/'.$this->getAliasLineAge().$this->getAlias()  , '/');
		$fileContent =
		'<?php'."\n".
		'//Alias file generated on '.date('r').' by '.CMS_grandFather::SYSTEM_LABEL.' '.AUTOMNE_VERSION."\n".
		'require_once(dirname(__FILE__).\'/'.str_repeat  ('../', $pos).'cms_rc_frontend.php\');'."\n".
		'$pPath = CMS_module_cms_aliases::redirect();'."\n".
		'$cms_page_included = true;'."\n".
		'require($pPath);'."\n".
		'?>';
		//then create index.php file in folder
		$file = new CMS_file($this->getPath(true, PATH_RELATIVETO_FILESYSTEM).'index.php');
		$file->setContent($fileContent);
		return $file->writeToPersistence();
	}
	
	/**
	  * Destroy an alias (folder, redirection file and DB reference)
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy()
	{
		//1- delete alias files
		if (!$this->_deleteFiles()) {
			return false;
		}
		//2- launch pages regen if needed
		$this->_regenerate();
		
		//3- delete mysql data
		$sql = "
			delete
			from
				mod_cms_aliases
			where
				id_ma=".$this->_ID."
		";
		$q = new CMS_query($sql);
		
		//4- unset object
		unset($this);
		return true;
	}
	
	/**
	  * Delete alias files (folder and redirection file)
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	private function _deleteFiles() {
		//check if alias directory already exists
		if (!@is_dir($this->getPath(true, PATH_RELATIVETO_FILESYSTEM))) {
			return true;
		}
		//if this directory is used by subaliases, do not delete it
		if ($this->hasSubAliases()) {
			return true;
		}
		//check if directory is used by another alias
		$aliases = CMS_module_cms_aliases::getByName($this->getAlias());
		$otherAlias = false;
		foreach($aliases as $anAlias) {
			if ($this->getID() != $anAlias->getID() && $this->getPath() == $anAlias->getPath()) {
				$otherAlias = true;
			}
		}
		if ($otherAlias) {
			//another alias still use this directory so, do not delete it
			return true;
		}
		return CMS_file::deltree($this->getPath(true, PATH_RELATIVETO_FILESYSTEM), true);
	}
	
	/**
	  * Does this alias has the given id as parent ?
	  *
	  * @param integer $id The alias id to check
	  * @return boolean
	  * @access public
	  */
	function hasParent($id) {
		$lineage = $this->getAliasLineAge(true);
		return isset($lineage[$id]);
	}
	
	/**
	  * Method used for compatibility with cms_aliases V1
	  *
	  * @return string
	  * @access public
	  */
	function redirect() {
		return CMS_module_cms_aliases::redirect();
	}
	
	/**
	  * Regenerate alias page and all pages related to this alias
	  *
	  * @return string
	  * @access protected
	  */
	protected function _regenerate() {
		if (($this->_replace || $this->_needRegen) && $this->_pageID) {
			$page = CMS_tree::getPageById($this->_pageID);
			if ($page && !$page->hasError()) {
				$regen_pages = array();
				$temp_regen = CMS_linxesCatalog::getWatchers($page);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
				$temp_regen = CMS_linxesCatalog::getLinkers($page);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
				$regen_pages = array_unique($regen_pages);
				//regen page itself
				CMS_tree::submitToRegenerator($page->getID(), false, false);
				//regen all pages which link this one and lauch regeneration
				CMS_tree::submitToRegenerator($regen_pages, false, true);
			}
		}
		return true;
	}
}
?>