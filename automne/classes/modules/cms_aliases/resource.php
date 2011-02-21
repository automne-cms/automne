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
//
// $Id: resource.php,v 1.6 2010/03/08 16:43:35 sebastien Exp $

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
	protected $_cms_alias;

	/**
	  * parent alias DB ID
	  * @var integer
	  * @access private
	  */
	protected $_parentID;

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
				$this->_cms_alias = $data["alias_ma"];
				$this->_parentID = $data["parent_ma"];
				$this->_pageID = $data["page_ma"];
				$this->_url = $data["url_ma"];
				
			} else {
				$this->raiseError("Unknown ID :".$id);
			}
		} else {
			//do nothing
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
		return $this->_cms_alias;
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
		if ($this->getParent()==='') {
			$this->raiseError("Must have a parent to check directory");
			return;
		}
		if ($this->getID()) {
			//alias already exist and name can't change so return
			return;
		}
		$alias = sensitiveIO::sanitizeAsciiString($alias);
		//need to check here if alias folder don't already exist
		if (!@is_dir(PATH_REALROOT_FS.$this->getAliasLineAge().'/'.$alias)) {
			$this->_cms_alias = $alias;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Sets the parent
	  *
	  * @param CMS_resource_cms_aliases $parent The parent to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setParent($parent)
	{
		if (is_a($parent, "CMS_resource_cms_aliases")) {
			$this->_parentID = $parent->getID();
			return true;
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
		$this->_url = (io::substr($url,0,7)=='http://') ? $url:'http://'.$url;
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
			$this->_pageID = $page->getID();
			$this->_url = '';
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Writes the alias into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		//save data
		$sql_fields = "
			parent_ma='".$this->_parentID."',
			page_ma='".$this->_pageID."',
			url_ma='".SensitiveIO::sanitizeSQLString($this->_url)."',
			alias_ma='".SensitiveIO::sanitizeSQLString($this->_cms_alias)."'
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
			//its a creation, then create folder and index.php redirection file
			if ($this->createFolder()) {
				$this->createRedirectionFile();
			}
		} else {
			$this->createRedirectionFile();
		}
		return true;
	}
	
	/**
	  * Get all the sub-aliases of a given alias
	  *
	  * @param CMS_resource_cms_aliases $parent The parent of the sub-aliases to get
	  * @param boolean $returnObject function return array of id (default) or array of CMS_resource_cms_aliases
	  * @return array
	  * @access public
	  */
	function getAll($parent,$returnObject=false)
	{
		if (is_a($parent, "CMS_resource_cms_aliases")) {
			$id = $parent->getID();
		} else {
			$id = 0;
		}
		$sql = "
			select
				id_ma
			from
				mod_cms_aliases
			where
				parent_ma=".$id."
		";
		$q = new CMS_query($sql);
		$result = array();
		while ($arr = $q->getArray()) {
			if ($returnObject) {
				$result[] = new CMS_resource_cms_aliases($arr["id_ma"]);
			} else {
				$result[] = $arr["id_ma"];
			}
		}
		return $result;
	}
	
	/**
	  * Get the lineAge of an alias
	  *
	  * @param boolean $returnObject function return lineAge string or array of CMS_resource_cms_aliases
	  * @return array or string
	  * @access public
	  */
	function getAliasLineAge($returnObject=false) 
	{
		if ($this->getParent()==0) {
			if ($returnObject) {
				return array();
			} else {
				return false;
			}
		} else {
			$aliasesLineAge=array();
			$parent = new CMS_resource_cms_aliases($this->_parentID);
			while($parent->getID() !=0) {
				$aliasesLineAge[] = $parent;
				$parent = new CMS_resource_cms_aliases($parent->getParent());
			}
		}
		$aliasesLineAge = array_reverse($aliasesLineAge);
		if ($returnObject) {
			return $aliasesLineAge;
		} else {
			$lineAgeString='';
			foreach ($aliasesLineAge as $anAlias) {
				$lineAgeString.=$anAlias->getAlias()."/";
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
	  * @access public
	  */
	function createFolder() 
	{
		if (!$this->getAlias()) {
			$this->raiseError("Must have an alias name to create directory");
			return false;
		}
		return @mkdir (PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias(), octdec(DIRS_CHMOD));
	}
	
	/**
	  * Create the redirection file (index.php) of an alias
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function createRedirectionFile() {
		//check wich type of redirection we need to create
		if ($this->getPageID()) {
			//it's a redirection to an Automne Page
			$page = new CMS_page($this->getPageID());
			if ($page->hasError()) {
				$this->raiseError("Can't create redirection to invalid page");
				return false;
			}
		} elseif (!$this->getURL()) {
			$this->raiseError("Must have an destination");
			return false;
		}
		//get alias position
		$pos = substr_count('/'.$this->getAliasLineAge().$this->getAlias()  , '/');
		$fileContent =
		'<?php'."\n".
		'require_once(dirname(__FILE__).\'/'.str_repeat  ('../', $pos).'cms_rc_frontend.php\');'."\n".
		'$alias = new CMS_resource_cms_aliases('.$this->getID().');'."\n".
		'$alias->redirect();'."\n".
		'?>';
		//then create index.php file in folder
		$fp = @fopen(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias() . "/index.php", "wb");
		if (is_resource($fp) && @fwrite($fp, $fileContent)) {
			@fclose($fp);
			@chmod(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias() . "/index.php", octdec(FILES_CHMOD));
			return true;
		} else {
			$this->raiseError("Can't create redirection file : check write permissions");
			return false;
		}
	}
	
	/**
	* Create the redirection  of an alias
	*
	* @return boolean true on success, false on failure
	* @access public
	*/
	function redirect() {
		$params = (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
		if (isset($_SERVER['HTTP_REFERER'])) {
			header("Referer: ".$_SERVER['HTTP_REFERER']);
		}
		if ($this->getPageID()) {
			//it's a redirection to an Automne Page
			$page = new CMS_page($this->getPageID());
			if (!$page->hasError()) {
				$pageURL = CMS_tree::getPageValue($this->getPageID(), 'url');
				if ($pageURL) {
					CMS_view::redirect($pageURL.$params, true, 302);
				} else {
					CMS_view::redirect(CMS_websitesCatalog::getMainURL().$params, true, 302);
				}
			}  else {
				$this->raiseError("Can't create redirection to invalid page");
				return false;
			}
		} elseif ($this->getURL()) {
			//it's a redirection to an URL
			CMS_view::redirect($this->getURL(), true, 302);
		} else {
			$this->raiseError("Must have an destination");
			return false;
		}
	}
	
	/**
	  * Destroy an alias (folder, redirection file and DB reference)
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy()
	{
		//1- delete index.php file
		if (is_file(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias() . "/index.php") && !@unlink(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias() . "/index.php")) {
			$this->raiseError("Error during deletion of index.php file, check file right");
			return false;
		}
		//2- delete alias folder
		if (is_dir(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias()) && !@rmdir(PATH_REALROOT_FS.'/'.$this->getAliasLineAge().$this->getAlias() )) {
			$this->raiseError("Error during deletion of alias folder, check file right");
			return false;
		}
		//3- delete mysql data
		$sql = "
			delete
			from
				mod_cms_aliases
			where
				id_ma=".$this->_ID."
		";
		$q = new CMS_query($sql);
		
		//4-unset object
		unset($this);
		return true;
	}
}
?>