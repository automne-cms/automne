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
// $Id: formcategories.php,v 1.3 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_formularCategories
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_formularCategories extends CMS_grandFather {

	/**
	 * The formular which will be put in relation with categories
	 * 
	 * @var CMS_forms_formular
	 * @access private
	 */
	protected $_form;
	
	/**
	 * All categories the resource has to belong to
	 * Indexed by categories IDs
	 * 
	 * @var array(integer id => CMS_moduleCategory)
	 * @access private
	 */
	protected $_categories;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param CMS_forms_formular $resource
	 * @return void 
	 */
	public function __construct(&$resource) {
		if ($resource && !is_a($resource, 'CMS_forms_formular')) {
			$this->raiseError("Not a valid CMS_forms_formular given");
		}
		$this->_form = $resource;
	}
	
	/**
	 * Getter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name
	 * @return string
	 */
	public function getAttribute($name) {
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
	public function setAttribute($name, $value) {
		if ($this->_public) {
			$this->raiseError("Object is public, read-only !");
			return false;
		}
		$name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	 * Gets all categories this resource belongs to
	 * 
	 * @access public
	 * @param boolean $public
	 * @return array(CMS_categories_medias)
	 */
	public function getCategories($public = false) {
		if ($public) {
			$this->_public = true;
		}
		if (!is_a($this->_form, 'CMS_forms_formular')) {
			$this->raiseError("Not a valid CMS_forms_formular given");
			return $this->_categories;
		}
		if ( (!isset($this->_categories) || sizeof($this->_categories) <= 0) 
				&& $this->_form->getID() > 0) {
			$this->_categories = array();
			
			// Fill with values from DB
			$sql = "
				select
					category_fca as id
				from
					mod_cms_forms_categories
				where
					form_fca='".SensitiveIO::sanitizeSQLString($this->_form->getID())."'
				group by
					category_fca
			";
			$q = new CMS_query($sql);
			while ($id = (int) $q->getValue('id')) {
				$obj = CMS_moduleCategories_catalog::getByID($id);
				if (!$obj->hasError()) {
					$this->_categories[$id] = $obj;
				}
			}
		}
		return $this->_categories;
	}
	
	/**
	 * Gets all categories IDs this resource belongs to
	 * 
	 * @access public
	 * @param boolean $public, to get only public datas
	 * @return array(integer)
	 */
	public function getCategoriesIds($public = false) {
		$a_ctgs = $this->getCategories($public);
		if (sizeof($a_ctgs) > 0) {
			$ids = array();
			foreach($a_ctgs as $obj) {
				$ids[] = $obj->getID();
			}
			return $ids;
		}
		return false;
	}
	
	/**
	 * Check if a category already is in current list
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @return boolean true if already exists in set
	 */
	public function categoryExists(&$obj) {
		if (!is_a($obj, 'CMS_moduleCategory')) {
			$this->raiseError("No a valid CMS_moduleCategory given");
			return false;
		}
		if (!isset($this->_categories)) {
			$this->getCategories();
		}
		return (@in_array($obj->getID(), @array_keys($this->_categories)));
	}
	
	/**
	 * Adds resource to this category
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @return boolean
	 */
	public function addCategory(&$obj) {
		if ($this->_public) {
			$this->raiseError("Object is public, read-only !");
			return false;
		}
		if (!is_a($obj, 'CMS_moduleCategory')) {
			$this->raiseError("No a valid CMS_moduleCategory given");
			return false;
		}
		if ($this->categoryExists($obj)) {
			$this->raiseError("Category to add already exists in list");
			return false;
		} else {
			$this->_categories[$obj->getID()] = $obj;
			return true;
		}
	}

	/**
	 * Delete resource linked to this category
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category
	 * @return boolean
	 */
	public function delCategory(&$obj) {
		if ($this->_public) {
			$this->raiseError("Object is public, read-only !");
			return false;
		}
		if (!is_a($obj, 'CMS_moduleCategory')) {
			$this->raiseError("No a valid CMS_moduleCategory given");
			return false;
		}
		if (!$this->categoryExists($obj)) {
			$this->raiseError("Category to delete not in list");
			return false;
		} else {
			unset($this->_categories[$obj->getId()]);
			return true;
		}
	}
	
	/**
	 * Write to persistence and submit resource to validation process too.
	 * 
	 * @access public
	 * @return boolean true on success, false on failure
	 */
	public function writeToPersistence() {
		if ($this->_public) {
			$this->raiseError("Object is public, read-only !");
			return false;
		}
		if (!is_a($this->_form, 'CMS_forms_formular') || $this->_form->getID() <= 0) {
			$this->raiseError("No CMS_forms_formular found");
			return false;
		}
		
		// Delete old relations
		$sql = "
			delete
			from
				mod_cms_forms_categories
			where
				form_fca='".SensitiveIO::sanitizeSQLString($this->_form->getID())."'
		";
		$qD = new CMS_query($sql);
		if ($qD->hasError()) {
			$this->raiseError("Error deleting previous relations");
			return false;
		}
		// Insert
		if (sizeof($this->_categories)) {
			$err = 0;
			// Insert each label
			foreach ($this->_categories as $obj) {
				if (is_a($obj, 'CMS_moduleCategory')) {
					// Insert
					$sql = "
						insert into
							mod_cms_forms_categories
						set
							form_fca='".SensitiveIO::sanitizeSQLString($this->_form->getID())."',
					 		category_fca='".SensitiveIO::sanitizeSQLString($obj->getID())."'
					";
					$q = new CMS_query($sql);
					if ($q->hasError()) {
						$err++;
						$this->raiseError("Error inserting relation for cateogry : ".$obj->getID());
					}
				}
			}
			return ($err == 0) ? true : false ;
		}
		return true;
	}
	
	/**
	 * Empty category array
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		$this->_categories = array();
	}
	
	/**
	  * Returns each category ID and label in a module given user can see
	  *
	  * @access public
	  * @param CMS_language $cms_language, the language of the labels
	  * @param boolean $restrictToUsedCat, restrict returned categories to used ones only (default false)
	  * @return array(string) the statements or false if profile hasn't any access to any categories
	  */
	public static function getAllCategoriesAsArray($language = false, $restrictToUsedCat = false) {
		global $cms_user;
		
		$categories = CMS_moduleCategories_catalog::getAllCategoriesAsArray($cms_user, MOD_CMS_FORMS_CODENAME, $language);
		//pr($categories);
		if (!$restrictToUsedCat) {
			return $categories;
		} else {
			//Get all used categories IDS for this object field
			$usedCategories = CMS_forms_formularCategories::getAllUsedCategoriesForField($language);
			
			if (sizeof($usedCategories)) {
				//get all categories lineage
				$catArbo = CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($cms_user, MOD_CMS_FORMS_CODENAME, true);
				//pr($catArbo);
				
				//need to remove all unused categories from list
				$categoriesToKeep = array();
				foreach ($usedCategories as $catID) {
					$cats = explode(';',$catArbo[$catID]);
					foreach ($cats as $aCat) {
						$categoriesToKeep[$aCat] = $aCat;
					}
				}
				//pr($categoriesToKeep);
				//then remove unused categories from initial list
				foreach ($categories as $catID => $catLabel) {
					if (!isset($categoriesToKeep[$catID])) {
						unset($categories[$catID]);
					}
				}
				//pr($categories);
				return $categories;
			} else {
				//no categories used
				return array();
			}
		}
	}
	
	/**
	  * Returns all categories IDs who has used by forms
	  *
	  * @param CMS_language $language, restrict to language (default : false)
	  * @access public
	  * @return array(interger id => integer id) the object ids
	  * @static
	  */
	public static function getAllUsedCategoriesForField($language = false) {
		$sql = "
			select
				distinct category_fca as cat
			from
				mod_cms_forms_categories,
				mod_cms_forms_formulars
			where
				form_fca = id_frm
		";
		if (is_a($language, 'CMS_language')) {
			$sql .= " and language_frm='".$language->getCode()."'";
		}
		$q = new CMS_query($sql);
		$r = array();
		if ($q->getNumRows()) {
			while ($catID = $q->getValue('cat')) {
				$r[$catID] = $catID;
			}
		}
		return $r;
	}
}
?>