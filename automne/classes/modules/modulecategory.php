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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: modulecategory.php,v 1.7 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_moduleCategory
  *
  * @package Automne
  * @subpackage modules
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
	 * Category uuid.
	 * @var string
	 * @access private
	 */
	protected $_uuid = '';
	
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
				$this->_uuid = $data["uuid_mca"];
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
		if ($name == 'uuid') {
			$this->raiseError("Cannot change UUID");
			return false;
		}
		$name = '_'.$name;
		$this->$name = $value;
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
		if (sensitiveIO::isPositiveInteger($this->_parentID)) {
			return CMS_moduleCategories_catalog::getById($this->_parentID);
		} else {
			$parent = new CMS_moduleCategory(0);
			$parent->setAttribute('moduleCodename', $this->_moduleCodename);
			return $parent;
		}
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
	function getLabel($language = false, $useAlternative = true) {
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
			if (isset($this->_labels[$language->getCode()]) && $this->_labels[$language->getCode()]) {
				return $this->_labels[$language->getCode()];
			} elseif ($useAlternative && isset($this->_labels[APPLICATION_DEFAULT_LANGUAGE]) && $this->_labels[APPLICATION_DEFAULT_LANGUAGE]) {
				return $this->_labels[APPLICATION_DEFAULT_LANGUAGE];
			} else {
				if ($useAlternative) {
					foreach ($this->_labels as $label) {
						if (trim($label)) {
							return $label;
						}
					}
				}
				return '';
			}
		} else {
			return '';
		}
	}

	/**
	 * Sets a new label
	 * 
	 * @access public
	 * @param string $value
	 * @param mixed $language : CMS_language or language code
	 */
	function setLabel($value, $language = false) {
		if (!$this->_labels) {
			$this->_retrieveLabels();
		}
		if ($language && is_string($language)) {
			$this->_labels[$language] = $value;
			return true;
		} elseif (is_a($language, 'CMS_language')) {
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
	function getDescription($language = false, $useAlternative = true) {
		if(!$this->_descriptions) {
			$this->_retrieveLabels();
		}
		if (!is_a($language, 'CMS_language')) {
			$language = $this->_language;
		}
		if (is_a($language, 'CMS_language') && isset($this->_descriptions[$language->getCode()]) && $this->_descriptions[$language->getCode()]) {
			return $this->_descriptions[$language->getCode()];
		} elseif ($useAlternative && isset($this->_descriptions[APPLICATION_DEFAULT_LANGUAGE]) && $this->_descriptions[APPLICATION_DEFAULT_LANGUAGE]) {
			return $this->_descriptions[APPLICATION_DEFAULT_LANGUAGE];
		} else {
			return '';
		}
	}

	/**
	 * Sets a new description
	 * 
	 * @access public
	 * @param string $value
	 * @param mixed $language : CMS_language or language code
	 */
	function setDescription($value, $language = false) {
		if(!$this->_descriptions) {
			$this->_retrieveLabels();
		}
		if ($language && is_string($language)) {
			$this->_descriptions[$language] = $value;
			return true;
		} elseif (is_a($language, 'CMS_language')) {
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
	 * @param mixed $language : CMS_language or language code
	 */
	function setFile($value, $language = false) {
		if(!$this->_files) {
			$this->_retrieveLabels();
		}
		if ($language && is_string($language)) {
			$this->_files[$language] = $value;
			return true;
		} elseif (is_a($language, 'CMS_language')) {
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
	 * @param mixed $language : CMS_language or language code
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
		if (!$language && is_object($this->_language)) {
			$language = $this->_language->getCode();
		} elseif (is_a($language, 'CMS_language')) {
			$language = $language->getCode();
		}
		if (!$language) {
			return '';
		}
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
				return $path."/".$this->_files[$language];
			} else {
				return $path;
			}
			return false;
		} elseif (isset($this->_files[$language])) {
			return $this->_files[$language];
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
		if (!$this->_uuid) {
			$this->_uuid = io::uuid();
		}
		// Prepare SQL
		$sql_fields = "
			module_mca='".SensitiveIO::sanitizeSQLString($this->_moduleCodename)."',
			root_mca='".SensitiveIO::sanitizeSQLString($this->_rootID)."',
			parent_mca='".SensitiveIO::sanitizeSQLString($this->_parentID)."',
			order_mca='".SensitiveIO::sanitizeSQLString($this->_order)."',
			icon_mca='".SensitiveIO::sanitizeSQLString($this->_icon)."',
			uuid_mca='".SensitiveIO::sanitizeSQLString($this->_uuid)."'";
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
		// instead of languages initially stored into object
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
						label_mcl='".SensitiveIO::SanitizeSQLString(@$this->_labels[$lang])."',
						description_mcl='".SensitiveIO::SanitizeSQLString(@$this->_descriptions[$lang])."',
						file_mcl='".SensitiveIO::SanitizeSQLString(@$this->_files[$lang])."'
				";
				$q = new CMS_query($sql);
				if ($q->hasError()) {
					$err++;
					$this->raiseError("Error inserting label in language : `$lang`");
				}
			}
			
			//Clear polymod cache
			CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_moduleCodename));
			return ($err <= 0);
		}
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_moduleCodename));
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
			
			//Clear polymod cache
			CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_moduleCodename));
			unset($this);
			return ($err <= 0);
		}
		return false;
	}
	
	/**
	  * Get object as an array structure used for export
	  *
	  * @param array $params The export parameters.
	  *		array(
	  *				categoriesChildren	=> false|true : export children categories also (default : true)
	  *			)
	  * @param array $files The reference to the founded files used by object
	  * @return array : the object array structure
	  * @access public
	  */
	public function asArray($params = array(), &$files) {
		if (!is_array($files)) {
			$files = array();
		}
		$this->_retrieveLabels();
		$icon = $this->_icon ? $this->getIconPath(true, PATH_RELATIVETO_WEBROOT, true) : '';
		$aCategory = array(
			'id'			=> $this->getID(),
			'uuid'			=> $this->_uuid,
			'parent'		=> '',
			'root'			=> '',
			'icon'			=> $icon,
			'order'			=> $this->_order,
			'labels'		=> $this->_labels,
			'descriptions'	=> $this->_descriptions,
			'module'		=> $this->_moduleCodename,
		);
		if ($this->_parentID) {
			$aCategory['parent'] = $this->getParent()->getAttribute('uuid');
		}
		if ($this->_rootID) {
			$aCategory['root'] = $this->getRoot()->getAttribute('uuid');
		}
		if (!isset($params['categoriesChildren']) || $params['categoriesChildren'] == true) {
			$aCategory['childs'] = array();
			$childs = $this->getSiblings();
			foreach ($childs as $child) {
				$aCategory['childs'][] = $child->asArray($params, $files);
			}
		}
		if ($this->_files) {
			foreach ($this->_files as $language => $file) {
				if ($file) {
					$file = $this->getFilePath($language, true, PATH_RELATIVETO_WEBROOT, true);
					$files[] = $file;
					$aCategory['files'][$language] = $file;
				}
			}
		}
		if ($icon) {
			$files[] = $icon;
		}
		return $aCategory;
	}
	
	/**
	  * Import row from given array datas
	  *
	  * @param array $data The module datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				module	=> false|true : the module to create categories (required)
	  *				create	=> false|true : create missing objects (default : true)
	  *				update	=> false|true : update existing objects (default : true)
	  *				files	=> false|true : use files from PATH_TMP_FS (default : true)
	  *			)
	  * @param CMS_language $cms_language The CMS_langage to use
	  * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	  * @param string $infos : Reference : The import infos returned
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for categories importation ...'."\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for categories importation : '.$params['module']."\n";
			return false;
		}
		
		if (!$this->getID() && CMS_moduleCategories_catalog::uuidExists($data['uuid'])) {
			//check imported uuid. If categories does not have an Id, the uuid must be unique or must be regenerated
			$uuid = io::uuid();
			//store old uuid relation
			$idsRelation['categories-uuid'][$data['uuid']] = $uuid;
			$data['uuid'] = $uuid;
		}
		//set category uuid if not exists
		if (!$this->_uuid) {
			$this->_uuid = $data['uuid'];
		}
		
		if (!isset($params['files']) || $params['files'] == true) {
			if (isset($data['icon'])) {
				$icon = $data['icon'];
				if ($icon && file_exists(PATH_TMP_FS.$icon)) {
					//destroy old file if any
					if ($this->getIconPath(false, PATH_RELATIVETO_WEBROOT, true)) {
						@unlink($this->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
						$this->setAttribute('icon', '');
					}
					//move and rename uploaded file 
					$filename = PATH_TMP_FS.$icon;
					$basename = pathinfo($filename, PATHINFO_BASENAME);
					if (!$this->getID()) { //need item ID
						$this->writeToPersistence();
					}
					//create file path
					$path = $this->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, false).'/';
					$extension = pathinfo($icon, PATHINFO_EXTENSION);
					$newBasename = "cat-".$this->getID()."-icon.".$extension;
					$newFilename = $path.'/'.$newBasename;
					if (CMS_file::moveTo($filename, $newFilename)) {
						CMS_file::chmodFile(FILES_CHMOD, $newFilename);
						//set it
						$this->setAttribute('icon', $newBasename);
					}
				} elseif(!$icon) {
					//destroy old file if any
					if ($this->getIconPath(false, PATH_RELATIVETO_WEBROOT, true)) {
						@unlink($this->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
						$this->setAttribute('icon', '');
					}
				}
			}
		}
		if (isset($data['labels'])) {
			foreach ($data['labels'] as $language => $label) {
				$this->setLabel($label, $language);
			}
		}
		if (isset($data['descriptions'])) {
			foreach ($data['descriptions'] as $language => $desc) {
				$this->setDescription($label, $desc);
			}
		}
		if (!isset($params['files']) || $params['files'] == true) {
			if (isset($data['files']) && is_array($data['files'])) {
				foreach ($data['files'] as $language => $file) {
					if ($file && file_exists(PATH_TMP_FS.$file)) {
						//destroy old file if any
						if ($this->getFilePath($language, false, PATH_RELATIVETO_WEBROOT, true)) {
							@unlink($this->getFilePath($language, true, PATH_RELATIVETO_FILESYSTEM, true));
							$this->setFile('', $language);
						}
						
						//move and rename uploaded file 
						$filename = PATH_TMP_FS.$file;
						$basename = pathinfo($filename, PATHINFO_BASENAME);
						if (!$this->getID()) { //need item ID
							$this->writeToPersistence();
						}
						//create file path
						$path = $this->getFilePath($language, true, PATH_RELATIVETO_FILESYSTEM, false).'/';
						$extension = pathinfo($file, PATHINFO_EXTENSION);
						$newBasename = "cat-".$this->getID()."-file-".$language.".".$extension;
						$newFilename = $path.'/'.$newBasename;
						if (CMS_file::moveTo($filename, $newFilename)) {
							CMS_file::chmodFile(FILES_CHMOD, $newFilename);
							//set it
							$this->setFile($newBasename, $language);
						}
					} elseif(!$file) {
						//destroy old file if any
						if ($this->getFilePath($language, false, PATH_RELATIVETO_WEBROOT, true)) {
							@unlink($this->getFilePath($language, true, PATH_RELATIVETO_FILESYSTEM, true));
							$this->setFile('', $language);
						}
					}
				}
			}
		}
		//write object
		if (!$this->writeToPersistence()) {
			$infos .= 'Error : can not write category ...'."\n";
			return false;
		}
		//if current category id has changed from imported id, set relation
		if (isset($data['id']) && $data['id'] && $this->getID() != $data['id']) {
			$idsRelation['categories'][$data['id']] = $this->getID();
			if (isset($data['uuid']) && $data['uuid']) {
				$idsRelation['categories'][$data['uuid']] = $this->getID();
			}
		}
		//set category order
		if (isset($data['order']) && $data['order']) {
			CMS_moduleCategories_catalog::moveCategoryIndex($this, $data['order']);
		}
		//set categories childs
		if (isset($data['childs']) && $data['childs']) {
			return CMS_moduleCategories_catalog::fromArray($data['childs'], $params, $cms_language, $idsRelation, $infos);
		}
		return true;
	}
}
?>