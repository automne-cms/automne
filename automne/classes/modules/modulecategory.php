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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: modulecategory.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_moduleCategory
  *
  * @package CMS
  * @subpackage module
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_moduleCategory extends CMS_grandFather {
	
	const MESSAGE_CATEGORY_DELETED = 1223;
	const LINEAGE_PARK_POSITION = 99999;
	
	/**
	 * Unique DB ID
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_categoryID;
	
	/**
	 * Codename of module this category belongs to
	 * 
	 * @var string
	 * @access private
	 */
	protected $_moduleCodename;
	
	/**
	 * Sorting position in siblings list, from 1 to infinite
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_order = 1;

	/**
	 * Parent category ID
	 *
	 * @var integer
	 * @access private
	 */
	protected $_parentID = 0;

	/**
	 * Root category ID
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_rootID = 0;

	/**
	 * Language to use to print out labels
	 * 
	 * @var CMS_language
	 * @access private
	 */
	protected $_language;
	
	/**
	 * Stores I18NM labels in availables languages
	 * 
	 * @var array(string)
	 * @access private
	 */
	protected $_labels = array();
	
	/**
	 * Stores I18NM descriptions
	 * 
	 * @var array(string)
	 * @access private
	 */
	protected $_descriptions = array();
	
	/**
	 * Stores I18NM descriptions from external file
	 * 
	 * @var array(string)
	 * @access private
	 */
	protected $_files = array();
	
	/**
	 * Stores icon path
	 * 
	 * @var string
	 * @access private
	 */
	protected $_icon;
	
	/**
	 * Stores all parent categories IDs to this one. For ease of use and rapidity.
	 * @var array(integer)
	 * @access private
	 */
	protected $_lineageStack = array();
	
	/**
	 * DB lineage.
	 * @var string
	 * @access private
	 */
	protected $_lineageFromDB = '';
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @param integer $id 
	 * @param CMS_language $language 
	 * @param CMS_moduleCategory $parentCategory 
	 * @param CMS_moduleCategory $rootCategory 
	 */
	function __construct($id=0, $language = false, $parentCategory = false, $rootCategory = false) {
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					modulesCategories
				where
					id_mca='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_categoryID = $id;
				$this->_moduleCodename = $data["module_mca"];
				$this->_parentID = $data["parent_mca"];
				$this->_rootID = $data["root_mca"];
				$this->_lineageStack = @explode(';', $data["lineage_mca"]);
				$this->_lineageFromDB = $data["lineage_mca"];
				$this->_icon = $data["icon_mca"];
				$this->_order = $data["order_mca"];
			} else {
				$this->raiseError("unknown ID :".$id);
			}
		}
		if (is_a($language, 'CMS_language')) {
			$this->_language = $language;
		}
		if (is_a($parentCategory, 'CMS_moduleCategory')
				&& $parentCategory->getID() > 0) {
			$this->_parentID = $parentCategory->getID();
		}
		if (is_a($rootCategory, 'CMS_moduleCategory')
				&& $rootCategory->getID() > 0) {
			$this->_rootID = $rootCategory->getID();
		}
	}

	/**
	  * Getter for the ID
	  * @access public
	  * @return integer
	  */
	function getID() {
		return $this->_categoryID;
	}
	
	/**
	  * Getter for any private attribute on this class
	  *
	  * @access public
	  * @param string $name
	  * @return string
	  */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	  * Setter for any private attribute on this class
	  *
	  * @access public
	  * @param string $name name of attribute to set
	  * @param $value , the value to give
	  */
	function setAttribute($name, $value) {
		eval('$this->_'.$name.' = $value ;');
		return true;
	}
	
	/**
	  * Get all siblings (children) categories
	  * returned ordered by order_mca position in db
	  * 
	  * @access public
	  * @param boolean $returnObjects, return CMS_moduleCategory on true, or id on false
	  * @return array(CMS_moduleCategory or id)
	  */
	function getSiblings($returnObjects = true) {
		$items = array();
		$sql = "
			select
				id_mca as id,
				order_mca as o
			from
				modulesCategories
			where
				parent_mca='".$this->_categoryID."'
			order by
				order_mca asc
		";
		$q = new CMS_query($sql);
		while ($data = $q->getArray()) {
			if($returnObjects){
				$obj = CMS_moduleCategories_catalog::getByID($data['id']);
				if (!$obj->hasError()) {
					$items[($data['o']-1)] = $obj;
				}
			} else {
				$items[($data['o']-1)] = $data['id'];
			}
		}
		return $items;
	}
	
	/**
	  * Builds lineage of categories from lineage stack
	  * 
	  * @access public
	  * @return array(CMS_moduleCategory)
	  */
	function getLineage() {
		$lineage = array();
		$stack = $this->getLineageStack();
		while (list($k, $id) = @each($stack)) {
			 $obj = CMS_moduleCategories_catalog::getByID($id);
			 if (!$obj->hasError()) {
				 $lineage[$k] = $obj;
			 }
		}
		return $lineage;
	}
	
	/**
	  * Stores category lineage IDs in a CMS_stack for rapid access
	  * From oldest to itself
	  *
	  * @access public
	  * @return array(integer)
	  */
	function getLineageStack() {
		if (!$this->_lineageStack) {
			$this->_lineageStack = CMS_moduleCategories_catalog::getLineageOfCategory($this->_categoryID, true);
		}
		return $this->_lineageStack;
	}
	
	/**
	  * Test if given categry has the one represented by given id as ancestor
	  * 
	  * @access public
	  * @param integer or CMS_moduleCateogry $category, the category to search in lineage
	  */
	function hasAncestor($category) {
		if (is_a($category, 'CMS_moduleCategory')) {
			$category_id = $category->getID();
		} elseif (SensitiveIO::isPositiveInteger($category)) {
			$category_id = $category;
		}
		return in_array($category_id, $this->getLineageStack());
	}
	
	/**
	  * Get parent category to this one
	  * 
	  * @access public
	  * @return CMS_moduleCategory
	  */
	function &getParent() {
		return CMS_moduleCategories_catalog::getById($this->_parentID);
	}
	
	/**
	 * Get root category to this one
	 * 
	 * @access public
	 * @return CMS_moduleCategory
	 */
	function &getRoot() {
		if ($this->isRoot()) {
			return null;
		} else {
			return CMS_moduleCategories_catalog::getById($this->_rootID);
		}
	}
	
	/**
	 * Test if given categry this one's parent
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @return boolean
	 */
	function hasParent($category) {
		if (is_a($category, 'CMS_moduleCategory')
					&& $category->getID() == $this->_parentID) {
			return true;
		}
		return false;
	}
	
	/**
	 * Test if given categry this one's root
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 */
	function hasRoot($category) {
		if (is_a($category, 'CMS_moduleCategory')
					&& $category->getID() == $this->_rootID) {
			return true;
		} elseif (SensitiveIO::isPositiveInteger($category) && $category == $this->_rootID) {
			return true;
		}
		return false;
	}
	
	/**
	 * Test if given categry is a root one
	 * 
	 * @access public
	 * @return boolean
	 */
	function isRoot() {
		return ($this->_categoryID > 0 && $this->_rootID == 0 && $this->_parentID == 0);
	}
	
	/**
	 * Prepare _labels attribute arrays with data from i18NM table
	 * 
	 * @access private
	 * @return void
	 */
	protected function _retrieveLabels() {
		static $labels;
		
		$this->_labels = array();
		$this->_descriptions = array();
		$this->_files = array();
		if (!isset($labels[$this->getID()])) {
			// Initialize table with all languages currently 
			// supported by the module. The way to add new translations
			foreach (CMS_languagesCatalog::getAllLanguages() as $aLanguage) {
				$this->_labels[$aLanguage->getCode()] = '';
				$this->_descriptions[$aLanguage->getCode()] = '';
				$this->_files[$aLanguage->getCode()] = '';
			}
			// Fill with values from DB
			$sql = "
				select
					label_mcl as libelle,
					description_mcl as description,
					file_mcl as file,
					LOWER(language_mcl) as lang
				from
					modulesCategories_i18nm
				where
					category_mcl='".$this->getID()."'
				order by
					language_mcl asc
			";
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$this->_labels[$data['lang']] = $data['libelle'];
				$this->_descriptions[$data['lang']] = $data['description'];
				$this->_files[$data['lang']] = $data['file'];
			}
			$labels[$this->getID()]['labels'] = $this->_labels;
			$labels[$this->getID()]['descriptions'] = $this->_descriptions;
			$labels[$this->getID()]['files'] = $this->_files;
		} else {
			$this->_labels = $labels[$this->getID()]['labels'];
			$this->_descriptions = $labels[$this->getID()]['descriptions'];
			$this->_files = $labels[$this->getID()]['files'];
		}
	}
	
	/**
	 * @access public
	 * @param CMS_language $language 
	 * @return string
	 */
	function getLabel($language = false) {
		if (!$this->_labels) {
			$this->_retrieveLabels();
		}
		if (!is_a($language, 'CMS_language')) {
			$language = $this->_language;
		}
		if (is_a($language, 'CMS_language')) {
			//category is deleted so return a specific label
			if ($this->_parentID == self::LINEAGE_PARK_POSITION) {
				return $language->getMessage(self::MESSAGE_CATEGORY_DELETED);
			}
			return $this->_labels[$language->getCode()];
		} else {
			return '';
		}
	}

	/**
	 * Sets a new label
	 * 
	 * @access public
	 * @param string $value
	 * @param CMS_language $language 
	 */
	function setLabel($value, $language = false) {
		if (is_a($language, 'CMS_language')) {
			$this->_labels[$language->getCode()] = $value;
			return true;
		} elseif (is_a($this->_language, 'CMS_language')) {
			$this->_labels[$this->_language->getCode()] = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Access to description
	 *
	 * @access public
	 * @param CMS_language $language 
	 * @return string
	 */
	function getDescription($language = false) {
		if(!$this->_descriptions) {
			$this->_retrieveLabels();
		}
		if (!is_a($language, 'CMS_language')) {
			$language = $this->_language;
		}
		if (is_a($language, 'CMS_language')) {
			return $this->_descriptions[$language->getCode()];
		} else {
			return '';
		}
	}

	/**
	 * Sets a new description
	 * 
	 * @access public
	 * @param string $value
	 * @param CMS_language $language 
	 */
	function setDescription($value, $language = false) {
		if (is_a($language, 'CMS_language')) {
			$this->_descriptions[$language->getCode()] = $value;
			return true;
		} elseif (is_a($this->_language, 'CMS_language')) {
			$this->_descriptions[$this->_language->getCode()] = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Access to a filename
	 *
	 * @access public
	 * @param CMS_language $language 
	 * @return string
	 */
	function getFile($language = false) {
		if(!$this->_files) {
			$this->_retrieveLabels();
		}
		if (!is_a($language, 'CMS_language')) {
			$language = $this->_language;
		}
		if (is_a($language, 'CMS_language')) {
			return $this->_files[$language->getCode()];
		} else {
			return '';
		}
	}
	
	/**
	 * Sets a file name
	 * 
	 * @access public
	 * @param string $value
	 * @param CMS_language $language 
	 */
	function setFile($value, $language = false) {
		if (is_a($language, 'CMS_language')) {
			$this->_files[$language->getCode()] = $value;
			return true;
		} elseif (is_a($this->_language, 'CMS_language')) {
			$this->_files[$this->_language->getCode()] = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Access to a filename path
	 *
	 * @access public
	 * @param CMS_language $language
	 * @param boolean $withPath If false, only returns the filename
	 * @param string $dataLocation Where does the data lies ? See CMS_resource constants
	 * @param integer $relativeTo Can be web root or filesystem relative, see base constants
	 * @param boolean $withFilename Should the function return the filename too or only the path ?
	 * @return string
	 */
	function getFilePath($language = false, $withPath = true, $relativeTo = PATH_RELATIVETO_WEBROOT, $withFilename = true) {
		if(!$this->_files) {
			$this->_retrieveLabels();
		}
		if (!is_a($language, 'CMS_language')) {
			$language = $this->_language;
		}
		if (is_a($language, 'CMS_language')) {
			if ($withPath) {
				switch ($relativeTo) {
				case PATH_RELATIVETO_WEBROOT:
					$path = PATH_MODULES_FILES_WR."/".$this->_moduleCodename."/".RESOURCE_DATA_LOCATION_PUBLIC;
					break;
				case PATH_RELATIVETO_FILESYSTEM:
					$path = PATH_MODULES_FILES_FS."/".$this->_moduleCodename."/".RESOURCE_DATA_LOCATION_PUBLIC;
					break;
				}
				if ($withFilename) {
					return $path."/".$this->_files[$language->getCode()];
				} else {
					return $path;
				}
				return false;
			} else {
				return $this->_files[$language->getCode()];
			}
		} else {
			return '';
		}
	}
	
	/**
	 * Get a full path to icon, or icon name only
	 * 
	 * @access public
	 * @param string $name 
	 * @param boolean $withPath If false, only returns the filename
	 * @param string $dataLocation Where does the data lies ? See CMS_resource constants
	 * @param integer $relativeTo Can be web root or filesystem relative, see base constants
	 * @param boolean $withFilename Should the function return the filename too or only the path ?
	 * @return string
	 */
	function getIconPath($withPath = true, $relativeTo = PATH_RELATIVETO_WEBROOT, $withFilename = true) {
		if ($withPath) {
			switch ($relativeTo) {
			case PATH_RELATIVETO_WEBROOT:
				$path = PATH_MODULES_FILES_WR."/".$this->_moduleCodename."/".RESOURCE_DATA_LOCATION_PUBLIC;
				break;
			case PATH_RELATIVETO_FILESYSTEM:
				$path = PATH_MODULES_FILES_FS."/".$this->_moduleCodename."/".RESOURCE_DATA_LOCATION_PUBLIC;
				break;
			}
			if ($withFilename) {
				return $path . "/" . $this->_icon;
			} else {
				return $path;
			}
			return false;
		} else {
			return $this->_icon;
		}
	}
	
	/**
	 * This category contains any sibling ?
	 * 
	 * @access public
	 * @return boolean
	 */
	function hasSiblings() {
		$items = array();
		$sql = "
			select
				count(*) as c
			from
				modulesCategories
			where
				parent_mca='".$this->_categoryID."'
		";
		$q = new CMS_query($sql);
		return ((int) $q->getValue("c") > 0);
	}
	
	/**
	  * Writes into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence() {
		// Prepare SQL
		$sql_fields = "
			module_mca='".SensitiveIO::sanitizeSQLString($this->_moduleCodename)."',
			root_mca='".SensitiveIO::sanitizeSQLString($this->_rootID)."',
			parent_mca='".SensitiveIO::sanitizeSQLString($this->_parentID)."',
			order_mca='".SensitiveIO::sanitizeSQLString($this->_order)."',
			icon_mca='".SensitiveIO::sanitizeSQLString($this->_icon)."'";
		// Finish SQL
		if ($this->_categoryID) {
			$sql = "
				update
					modulesCategories
				set
					".$sql_fields."
				where
					id_mca='".$this->_categoryID."'
			";
		} else {
			$sql = "
				insert into
					modulesCategories
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_categoryID) {
			$this->_categoryID = $q->getLastInsertedID();
		}
		//reset catalog info
		CMS_moduleCategories_catalog::getParentIdOf($this->_categoryID, true);
		// Update lineage again with current ID
		$lineage = (string) @implode(';', CMS_moduleCategories_catalog::getLineageOfCategory($this->_categoryID, true));
		if ($this->_lineageFromDB != $lineage) {
			$sql = "
				update
					modulesCategories
				set
					lineage_mca='".SensitiveIO::sanitizeSQLString($lineage)."'
				where
					id_mca='".$this->_categoryID."'
			";
			$q = new CMS_query($sql);
			//update siblings lineage if any
			if ($this->hasSiblings()) {
				$siblings = $this->getSiblings();
				foreach ($siblings as $aSibling) {
					$aSibling->writeToPersistence();
				}
			}
		}
		// Save translations
		// Number of languages availables depends on module
		// instead of languages initially tored into object
		// A way to support easily any new language
		if (is_array($this->_labels) && $this->_labels && $this->_categoryID) {
			$err = 0;
			// Insert each label
			foreach (CMS_languagesCatalog::getAllLanguages($this->_moduleCodename) as $aLanguage) {
				$lang = $aLanguage->getCode();
				// Delete
				$sql = "
					delete
					from
						modulesCategories_i18nm
					where
						category_mcl='".$this->_categoryID."'
						and language_mcl='".SensitiveIO::sanitizeSQLString($lang)."'
				";
				$qD = new CMS_query($sql);
				if ($qD->hasError()) {
					$err++;
					$this->raiseError("Error deleting label in language : `$lang`");
				}
				// Insert
				$sql = "
					insert into
						modulesCategories_i18nm
					set
						language_mcl='".SensitiveIO::sanitizeSQLString($lang)."',
						category_mcl = ".$this->_categoryID.",
						label_mcl='".SensitiveIO::SanitizeSQLString($this->_labels[$lang])."',
						description_mcl='".SensitiveIO::SanitizeSQLString($this->_descriptions[$lang])."',
						file_mcl='".SensitiveIO::SanitizeSQLString($this->_files[$lang])."'
				";
				$q = new CMS_query($sql);
				if ($q->hasError()) {
					$err++;
					$this->raiseError("Error inserting label in language : `$lang`");
				}
			}
			return ($err <= 0);
		}
		return true;
	}

	/**
	 * Deletes a category from persistence
	 * Must be called from static method
	 * @see CMS_moduleCategories_catalog
	 * 
	 * @access public
	 * @return boolean
	 */
	function destroy() {
		if ($this->_categoryID > 0) {
			$err = 0;
			$sql = "
				delete
				from
					modulesCategories
				where
					id_mca='".$this->_categoryID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$err++;
				$this->raiseError("Error deleting category.");
			}
			$sql = "
				delete
				from
					modulesCategories_i18nm
				where
					category_mcl='".$this->_categoryID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$err++;
				$this->raiseError("Error deleting category labels.");
			}
			$sql = "
				delete
				from
					modulesCategories_clearances
				where
					category_mcc='".$this->_categoryID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$err++;
				$this->raiseError("Error deleting category clearances.");
			}
			unset($this);
			return ($err <= 0);
		}
		return false;
	}
}
?>