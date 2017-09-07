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
// | Author: C�dric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: modulecategoriescatalog.php,v 1.8 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_moduleCategories_catalog
  * 
  * Factory and any useful methods to manage CMS_moduleCategory instances
  *
  * @package Automne
  * @subpackage modules
  * @author C�dric Soret <cedric.soret@ws-interactive.fr>
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_moduleCategories_catalog extends CMS_grandFather {
	
	/**
	  * @access public
	  * @param integer $id
	  * @param CMS_language $language
	  * @return CMS_moduleCategory
	  */
	static function getByID($id, $language=false) {
		static $categories;
		$languageCode = (is_object($language)) ? $language->getCode() : 'none';
		if (!isset($categories[$id][$languageCode])) {
			$categories[$id][$languageCode] = new CMS_moduleCategory($id, $language);
		}
		return $categories[$id][$languageCode];
	}
	
	/**
	 * Return categories marked as deleted
	 * 
	 * @static
	 * @access public
	 * @param string $module, the module codename who want's deleted cats
	 * @param boolean $return_objects, does the function return array of objects or array of objects ID
	 * 
	 * @return array(CMS_moduleCategory)
	 */
	static function getDeletedCategories($module = false, $return_objects = false) {
		static $deletedCategories;
		$items = array();
		$moduleName = ($module) ? $module:'none';
		if ($return_objects || !isset($deletedCategories[$moduleName])) {
			$where = ($module) ? " and module_mca = '".$module."'":"";
			$sql = "
				select
					id_mca as id
				from
					modulesCategories
				where
					parent_mca='".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
					$where
			";
			$q = new CMS_query($sql);
			while ($id = $q->getValue('id')) {
				if ($return_objects) {
					$obj = CMS_moduleCategories_catalog::getByID($id);
					if (!$obj->hasError()) {
						$items[] = $obj;
					}
				} else {
					$items[] = $id;
				}
			}
			if (!$return_objects) {
				$deletedCategories[$moduleName] = $items;
			}
		}
		return $deletedCategories[$moduleName];
	}
	
	/**
	 * Get the last position used in siblings list
	 * 
	 * @access public
	 * @param integer $parentCategoryID, ID of parent category to count order of
	 * @return integer
	 */
	static function getLastSiblingOrder($parentCategoryID=0) {
		$rootID = (int) $parentCategoryID;
		$sql = "
			select
				max(order_mca) as mx
			from
				modulesCategories
			where
				parent_mca='".SensitiveIO::sanitizeSQLString($rootID)."'
		";
		$q = new CMS_query($sql);
		$length = $q->getValue("mx");
		return (int) $length;
	}
	
	/**
	 * Attach a category to parent given
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @param CMS_moduleCategory $parentCategory 
	 * @return boolean true on success, false on failure
	 */
	static function attachCategory(&$category, &$parentCategory) {
		if (!($parentCategory instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Bad parent given, not a valid CMS_moduleCategory instance");
			return false;
		}
		if (!($category instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Bad category given, not a valid CMS_moduleCategory instance");
			return false;
		}
		if ($parentCategory->getID() > 0 && $category->hasParent($parentCategory)) {
			CMS_grandFather::raiseError("Category is already child of parent given");
			return false;
		}
		CMS_moduleCategories_catalog::compactSiblingsOrder($parentCategory);
		$category->setAttribute('parentID', $parentCategory->getID());
		if ($parentCategory->isRoot()) {
			$category->setAttribute('rootID', $parentCategory->getID());
		} else {
			$category->setAttribute('rootID', $parentCategory->getAttribute('rootID'));
		}
		$order = CMS_moduleCategories_catalog::getLastSiblingOrder($parentCategory->getID()) + 1;
		$category->setAttribute('order', $order);
		return $category->writeToPersistence();
	}
	
	/**
	 * Detach a category from its parent and destroys category
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @return boolean true on success, false on failure
	 */
	static function detachCategory(&$category) {
		if (!($category instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Bad category given, not a valid CMS_moduleCategory instance");
			return false;
		}
		if ($category->getId() > 0) {
			$park_integer = CMS_moduleCategory::LINEAGE_PARK_POSITION; //This park position is almost impossible to reach
			$parentCategory = $category->getParent();
			$sql = "
				update
					modulesCategories
				set
					uuid_mca=$park_integer,
					parent_mca=$park_integer,
					root_mca=$park_integer,
					order_mca=$park_integer,
					lineage_mca=$park_integer
				where
					id_mca='".$category->getID()."'
			";
			$q = new CMS_query($sql);
			if (!$q->hasError()) {
				if ($parentCategory->getID()) { //if category has a parent (not a root category)
					return CMS_moduleCategories_catalog::compactSiblingsOrder($parentCategory->getID());
				} else {
					//Clear polymod cache
					//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $category->getAttribute('moduleCodename')));
					CMS_cache::clearTypeCache('polymod');
					
					return true;
				}
			} else  {
				CMS_grandFather::raiseError("Detaching category failed");
			}
		}
		return false;
	}
	
	/**
	 * Moves a cateogry from its parent to another
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @param CMS_moduleCategory $parentCategory
	 * @param integer $index : the new index for the new parent (if false, put the category at last position)
	 * @return boolean true on success, false on failure
	 */
	static function moveCategory(&$category, &$newParentCategory, $index = false) {
		if (!($newParentCategory instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Bad parent given, not a valid CMS_moduleCategory instance");
			return false;
		}
		if (!($category instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Bad category given, not a valid CMS_moduleCategory instance");
			return false;
		}
		if ($category->hasParent($newParentCategory) && $index === false) {
			CMS_grandFather::raiseError("Category is already child of new parent given");
			return false;
		}
		if ($category->hasParent($newParentCategory)) {
			//this is only a change of category index so  move category to new index
			return CMS_moduleCategories_catalog::moveCategoryIndex($category, $index);
		} else {
			$oldParentCategory = $category->getParent();
			if (CMS_moduleCategories_catalog::attachCategory($category, $newParentCategory)) {
				if (!CMS_moduleCategories_catalog::compactSiblingsOrder($oldParentCategory)) {
					CMS_grandFather::raiseError("Cannot compact sibling order for parent category");
					return false;
				}
				if (!$index) {
					return true;
				} else {
					//reload category
					$category = new CMS_moduleCategory($category->getID());
					//then move category to new index
					return CMS_moduleCategories_catalog::moveCategoryIndex($category, $index);
				}
			} else {
				CMS_grandFather::raiseError("Movement failed for category ".$category->getID());
				return false;
			}
		}
	}
	
	/**
	 * Check and/or repair positions in siblings of a given category
	 * if ever needed
	 * 
	 * @param integer $category_id, category ID to compact
	 * @access public
	 * @return boolean
	 */
	static function compactSiblingsOrder($category, $codename = false) {
		if ($category instanceof CMS_moduleCategory) {
			$categoryId = $category->getID();
			$codename = $category->getAttribute('moduleCodename');
		} else if(sensitiveIO::isPositiveInteger($category)) {
			$categoryId = $category;
		} else {
			CMS_grandFather::raiseError("Category parameter is not a valid ID nor a valid category");
			return false;
		}
		// Checks if any hole in list order (more orders than records in siblings)
		$proceed = true;
		$sql = "
			select
				COUNT(*),
				max(order_mca) as m
			from
				modulesCategories
			where
				parent_mca = '".SensitiveIO::sanitizeSQLString($categoryId)."'
		";
		if ($codename) {
			$sql .= " and module_mca = '".SensitiveIO::sanitizeSQLString($codename)."'";
		}
		$q = new CMS_query($sql);
		$arr = $q->getArray();
		if ((int) $arr["m"] != (int) $arr["COUNT(*)"]) {
			//move the siblings order
			$sql = "
				select
					id_mca as id
				from
					modulesCategories
				where
					parent_mca='".SensitiveIO::sanitizeSQLString($categoryId)."'";
			if ($codename) {
				$sql .= " and module_mca = '".SensitiveIO::sanitizeSQLString($codename)."'";
			}
			$sql .= "
				order by
					order_mca
			";
			$q = new CMS_query($sql);
			$order=0;
			while ($linkId = $q->getValue("id")) {
				$order++;
				$sql = "
					update
						modulesCategories
					set
						order_mca='".$order."'
					where
						id_mca='".$linkId."'
				";
				$qU = new CMS_query($sql);
				if ($qU->hasError()) {
					CMS_grandFather::raiseError("Error while reordering siblings of category ".$categoryId);
					$proceed = false;
				}
			}
		}
		if ($codename) {
			//Clear polymod cache
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $codename));
			CMS_cache::clearTypeCache('polymod');
			
		}
		
		return $proceed;
	}
	
	/**
	 * Moves position of a category in list at given index
	 * 
	 * @access public
	 * @param CMS_moduleCategory $category 
	 * @param integer $index values (start to 1)
	 * @return boolean true on succes, false on failure
	 */
	static function moveCategoryIndex($category, $index) {
		// Checks : pages must be CMS_moduleCategory and offset in (1, -1)
		if (!($category instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Category to move not valid.");
			return false;
		}
		if (!SensitiveIO::isPositiveInteger($index)) {
			CMS_grandFather::raiseError("Index must be a positive integer : ".$index);
			return false;
		}
		//if index is the same than current coregory index, do nothing
		if ($category->getAttribute('order') == $index) {
			return true;
		}
		
		// Find the siblings to switch order
		$parent = $category->getParent();
		
		// Use this function to compact of siblings order
		if (!($parent instanceof CMS_moduleCategory) 
				|| !CMS_moduleCategories_catalog::compactSiblingsOrder($parent)) {
			CMS_grandFather::raiseError("Reordering siblings failed for category ".$parent->getID());
			return false;
		}
		
		if ($category->getAttribute('order') < $index) {
			//move sibling order
			$sql = "
				update
					modulesCategories
				set
					order_mca = order_mca - 1
				where
					order_mca > '".$category->getAttribute('order')."'
					and order_mca <= '".$index."'
					and parent_mca = '".$parent->getID()."'
			";
			$q = new CMS_query($sql);
		} else {
			//move sibling order
			$sql = "
				update
					modulesCategories
				set
					order_mca = order_mca + 1
				where
					order_mca < '".$category->getAttribute('order')."'
					and order_mca >= '".$index."'
					and parent_mca = '".$parent->getID()."'
			";
			$q = new CMS_query($sql);
		}
		//move category index
		$sql = "
			update
				modulesCategories
			set
				order_mca = ".$index."
			where
				id_mca='".$category->getID()."'
		";
		$q = new CMS_query($sql);
		
		//Clear polymod cache
		//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $category->getAttribute('moduleCodename')));
		CMS_cache::clearTypeCache('polymod');
		
		return true;
	}
	
	/**
	 * Moves position of a category in list, with given offset
	 * 
	 * @access public
	 * @param CMS_moduleCategory $siblingCategory 
	 * @param integer $moveOffset values 1 or -1 expected
	 * @return boolean true on succes, false on failure
	 */
	static function moveCategoryOrder(&$siblingCategory, $moveOffset) {
		// Checks : pages must be CMS_moduleCategory and offset in (1, -1)
		if (!($siblingCategory instanceof CMS_moduleCategory)) {
			CMS_grandFather::raiseError("Category to move not valid.");
			return false;
		}
		if (!SensitiveIO::isInSet($moveOffset, array(1, -1))) {
			CMS_grandFather::raiseError("Offset must be 1 or -1");
			return false;
		}
		
		// Find the siblings to switch order
		$parent = $siblingCategory->getParent();
		
		// Use this function to compact of siblings order
		if (!($parent instanceof CMS_moduleCategory) 
				|| !CMS_moduleCategories_catalog::compactSiblingsOrder($parent->getID())) {
			CMS_grandFather::raiseError("Reordering siblings failed for category ".$parent->getID());
			return false;
		}
		
		$siblings = $parent->getSiblings();
		$sibling_to_move_left = false;
		$sibling_to_move_right = false;
		$lastSibling = false;
		foreach ($siblings as $aSibling) {
			if ($moveOffset == 1 && $lastSibling && $lastSibling->getID() == $siblingCategory->getID()) {
				$sibling_to_move_left = $aSibling;
				$sibling_to_move_right = $siblingCategory;
				break;
			}
			if ($moveOffset == -1 && $lastSibling && $aSibling->getID() == $siblingCategory->getID()) {
				$sibling_to_move_left = $siblingCategory;
				$sibling_to_move_right = $lastSibling;
				break;
			}
			$lastSibling = $aSibling;
		}
		
		if ($sibling_to_move_left && $sibling_to_move_right) {
			//move the siblings order
			$sql = "
				update
					modulesCategories
				set
					order_mca=order_mca - 1
				where
					id_mca='".$sibling_to_move_left->getID()."'
			";
			$q = new CMS_query($sql);
			$sql = "
				update
					modulesCategories
				set
					order_mca=order_mca + 1
				where
					id_mca='".$sibling_to_move_right->getID()."'
			";
			$q = new CMS_query($sql);
			
			//Clear polymod cache
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $sibling_to_move_right->getAttribute('moduleCodename')));
			CMS_cache::clearTypeCache('polymod');
			
			return true;
		} else {
			CMS_grandFather::raiseError("Move impossible (first or last sibling to move, or parent and sibling not related");
			return false;
		}
	}
	
	/**
	 * Get the ID of the category parent to another
	 * This method must be as fast as possible
	 * 
	 * @static
	 * @access public
	 * @param integer $categoryID, the category ID to get parent of
	 * @param boolean $reset, force cache reloading : default false (used by writeToPersistence in CMS_moduleCategory)
	 * @return false if nothing found, or integer parentID
	 */
	static function getParentIdOf($categoryID, $reset = false) {
		static $categoriesTree;
		if (!SensitiveIO::isPositiveInteger($categoryID)) {
			CMS_grandFather::raiseError("Bad category ID given : ". $categoryID);
			return false;
		}
		//cache initialisation
		if (!is_array($categoriesTree)) {
			$categoriesTree = array();
			$sql = "
				select
					id_mca as id,
					parent_mca as parent_id
				from
					modulesCategories
			";
			$q = new CMS_query($sql);
			while ($r = $q->getArray()) {
				$categoriesTree[$r['id']] = ($r['parent_id']) ? $r['parent_id'] : false;
			}
		}
		if (!isset($categoriesTree[$categoryID]) || $reset) {
			$sql = "
				select
					parent_mca as parent_id
				from
					modulesCategories
				where
					id_mca='".$categoryID."'
				limit
					0, 1
			";
			$q = new CMS_query($sql);
			$parent = (int) $q->getValue('parent_id');
			$categoriesTree[$categoryID] = ($parent) ? $parent : false;
		}
		return $categoriesTree[$categoryID];
	}
	
	/**
	  * Gives an array containing the lineage of a category ID was given
	  * From oldest ancestor to itself
	  *
	  * @access public
	  * @param integer $categoryID, the category ID
	  * @return array(integer)
	  * @static
	  */
	static function getLineageOfCategory($categoryID, $reset = false) {
		static $categoriesLineages;
		if (!SensitiveIO::isPositiveInteger($categoryID)) {
			CMS_grandFather::raiseError('Bad category ID given');
			return false;
		}
		//cache initialisation
		if (!is_array($categoriesLineages)) {
			$categoriesLineages = array();
			$sql = "
				select
					id_mca as id,
					lineage_mca as lineage
				from
					modulesCategories
			";
			$q = new CMS_query($sql);
			while ($r = $q->getArray()) {
				$categoriesLineages[$r['id']] = ($r['lineage']) ? $r['lineage'] : false;
			}
		}
		if (!isset($categoriesLineages[$categoryID]) || $reset) {
			//in this case, recalculate category lineage
			$stack = $childID = $categoryID;
			while (false !== ($parentID = CMS_moduleCategories_catalog::getParentIdOf($childID))) {
				if (!$parentID || $parentID == $childID) {
					CMS_grandFather::raiseError('Bad category lineage found for category '.$categoryID.' (Infinite loop ?)');
					return array();
				}
				$stack = $parentID.';'.$stack;
				$childID = $parentID;
			}
			$categoriesLineages[$categoryID] = $stack;
		}
		return explode(';',$categoriesLineages[$categoryID]);
	}
	
	/**
	  * Gives a string representing the lineage of a category whose ID was given
	  * From oldest ancestor to itself, imploded with ; (semicolon) by Default
	  *
	  * @access public
	  * @param integer $category_id, the category ID
	  * @param string $separator, the separator we want to use instead of semicolon (;)
	  * @return string
	  * @static
	  */
	static function getLineageOfCategoryAsString($category_id, $separator = ";")
	{
		static $modulesCategories;
		if (!$separator) {
			CMS_grandFather::raiseError("Bad separator given : $separator");
			return false;
		}
		if (!SensitiveIO::isPositiveInteger($category_id)) {
			CMS_grandFather::raiseError("Bad category ID given : $category_id");
			return false;
		}
		if (!isset($modulesCategories[$category_id])) {
			$modulesCategories[$category_id] = (string) @implode($separator, CMS_moduleCategories_catalog::getLineageOfCategory($category_id));
		}
		return $modulesCategories[$category_id];
	}
	
	/**
	  * Parses a lineage and returns a category ID in given level
	  * By default returns root category ID in lineage
	  *
	  * @access public
	  * @param strign $lineage, string with integers separated with ;
	  * @param integer $level, which level to get from lineage (default is rott, so 0)
	  * @return integer $category_id, the category ID
	  * @static
	  */
	static function getCategoryIdFromLineage($lineage, $level = 0) {
		if (false !== ($a_lineage = explode(';', $lineage))) {
			if (sizeof($a_lineage) > $level) {
				return (int) $a_lineage[$level];
			}
		}
		return false;
	}
	
	/**
	 * Return categories found in given module in current language
	 * 
	 * @static
	 * @access public
	 * @param array $attrs, search criteria
	 * Array ( 
	 *    "module" => string
	 *    "language" => CMS_language
	 *    "level" => integer (Default -1)
	 *    "root" => integer (Default -1)
	 *    "cms_user" => CMS_profile
	 *	  "clearanceLevel" => mixed (default : false)
	 * 		- false : CLEARANCE_MODULE_VIEW
	 * 		- true : CLEARANCE_MODULE_EDIT
	 * 		- constant value : clearanceLevel value
	 *	  "strict" => boolean (default : false)
	 * )
	 * @return array(CMS_moduleCategory)
	 */
	 public static function getAll($attrs) {
		$items = array();
		if (!$attrs["module"]) {
			CMS_grandFather::raiseError("Not a valid module codename given");
			return $items;
		}
		if (!isset($attrs["clearanceLevel"])) {
			$attrs["clearanceLevel"] = false;
		}
		if (!isset($attrs["strict"])) {
			$attrs["strict"] = false;
		}
		//for backward compatibility
		if (isset($attrs["editableOnly"]) && $attrs["editableOnly"]) {
			$attrs["clearanceLevel"] = true;
		}
		
		// Prepare SQL
		$s_where = $s_table = '';
		
		// Limit to module
		if ($attrs["module"]) {
			$s_where .= "
				and module_mca='".SensitiveIO::sanitizeSQLString($attrs["module"])."'";
		}
		// Limit to user permissions on module categories
		if (isset($attrs["cms_user"]) && is_a($attrs["cms_user"], 'CMS_profile')) {
			$a_where = CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($attrs["cms_user"], $attrs["module"], true, $attrs["clearanceLevel"], $attrs['strict']);
			//pr(array_keys($a_where));
			if (is_array($a_where) && $a_where) {
				$a_where = array_keys($a_where);
				$s_where .= ' and id_mca in ('.@implode(',', $a_where).')';
			} else {
				//user as no permissions on categories so return nothing
				return array();
			}
		}
		
		// Limit to parent and/or root categories given
		if (isset($attrs["level"]) && $attrs["level"] !== false && (int) $attrs["level"] >- 1) {
			$s_where .= "
				and parent_mca='".SensitiveIO::sanitizeSQLString($attrs["level"])."'";
		}
		if (isset($attrs["root"]) && $attrs["root"] !== false && (int) $attrs["root"] >- 1) {
			$s_where .= "
				and root_mca='".SensitiveIO::sanitizeSQLString($attrs["root"])."'";
		}
		if (isset($attrs["language"]) && is_a($attrs["language"], 'CMS_language')) {
			$s_table .= ',modulesCategories_i18nm ';
			$s_where .= "and id_mca=category_mcl and language_mcl='".SensitiveIO::sanitizeSQLString($attrs["language"]->getCode())."'";
		}
		
		$sql = "
			select
				id_mca as id
			from
				modulesCategories
				$s_table
			where
				1 = 1
				$s_where
			group by
				id_mca
			order by
				order_mca asc
		";
		//pr($sql);
		$q = new CMS_query($sql);
		while ($id = $q->getValue('id')) {
			$obj = CMS_moduleCategories_catalog::getByID($id, $attrs["language"]);
			if (!$obj->hasError()) {
				$items[] = $obj;
			}
		}
		return $items;
	}
	
	/**
	 * Returns a multidimentionnal array of categories viewvable
	 * If access control is active, we need to limit serch to user's 
	 * permissions on categories
	 * 
	 * @access public
	 * @param CMS_profile $cms_user, the profile concerned by these restrictions
	 * @param string $module the module codename we want
	 * @param boolean $returnLineageArray return array like array(catID => catLineage) instead
	 * @param mixed $clearanceLevel 
	 * - false : CLEARANCE_MODULE_VIEW
	 * - true : CLEARANCE_MODULE_EDIT
	 * - constant value : clearanceLevel value
	 * @param boolean $strict return only categories from this clearance (default : false, else, return complete categories tree until given clearance)
	 * @return array(catID => array(catID => array(...)))
	 * @static
	 */
	static function getViewvableCategoriesForProfile (&$cms_user, $module = false, $returnLineageArray = false, $clearanceLevel = false, $strict = false) {
		static $viewvableCats;
		$type = ($module) ? $module:'all';
		if ($clearanceLevel === false || $clearanceLevel === '' || $clearanceLevel === null) {
			$clearanceLevel = CLEARANCE_MODULE_VIEW;
		} elseif ($clearanceLevel === true) {
			$clearanceLevel = CLEARANCE_MODULE_EDIT;
		}
		
		$type = $type.((string) $clearanceLevel) . ($strict ? 'strict' : '') . ($cms_user instanceof CMS_profile ? $cms_user->getId() : '');
		//check if result is not allready in global var
		if (!isset($viewvableCats[$type])) {
			//first we get an array of all categories id for this module
			$catsID = array();
			
			$s_where = ($module) ? " and module_mca = '".$module."'":"";
			$sql = "
				select
					id_mca as id
				from
					modulesCategories
				where
					parent_mca != '".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
					$s_where
			";
			$q = new CMS_query($sql);
			while ($id = $q->getValue('id')) {
				$catsID[$id] = $id;
			}
			//then for each category, check if user have right to view it
			//if not, unset category
			if ($cms_user instanceof CMS_profile) {
				$categories = array();
				if (is_array($catsID) && $catsID) {
					$categories = $cms_user->filterModuleCategoriesClearance($catsID, $clearanceLevel, $module, $strict);
				}
			} else {
				$categories = $catsID;
			}
			//then create returned arrays
			$nLevelArray = $lineageArray = array();
			if (is_array($categories) && $categories) {
				foreach($categories as $catID) {
					//construct n level tree with all of these categories and array of lineages
					
					//get category lineage
					$lineage = CMS_moduleCategories_catalog::getLineageOfCategoryAsString($catID);
					if ($lineage) {
						$lineageArray[$catID] = $lineage;
						//then create n level table
						$ln = sensitiveIO::sanitizeExecCommand('if (!isset($nLevelArray['.str_replace(';','][',$lineage).'])) $nLevelArray['.str_replace(';','][',$lineage).'] =  array();');
						eval($ln);
					}
				}
			}
			$viewvableCats[$type]["lineageArray"] = $lineageArray;
			$viewvableCats[$type]["nLevelArray"] = $nLevelArray;
		}
		return ($returnLineageArray) ? $viewvableCats[$type]["lineageArray"] : $viewvableCats[$type]["nLevelArray"];
	}
	
	/**
	  * Returns each category ID and label in a module given user can see (from : none, to : view)
	  *
	  * @access public
	  * @param CMS_profile $cms_user, the profile concerned by these restrictions
	  * @param string $cms_module, the module codename
	  * @param CMS_language $cms_language, the language of the labels
	  * @param integer $level, the level category if any
	  * @param integer $root, the root category if any
	  * @param mixed $clearanceLevel 
	  * - false : CLEARANCE_MODULE_VIEW
	  * - true : CLEARANCE_MODULE_EDIT
	  * - constant value : clearanceLevel value
	  * @param boolean $strict return only categories from this clearance (default : false, else, return complete categories tree until given clearance)
	  * @return array(string) the statements or false if profile hasn't any access to any categories
	  * @static
	  */
	public static function getAllCategoriesAsArray(&$cms_user, $cms_module, $cms_language, $level = 0, $root = -1, $clearanceLevel = false, $strict = false, $crossLanguage = false) {
		if (!is_a($cms_user, 'CMS_profile') 
				|| !$cms_module
				|| !is_a($cms_language, 'CMS_language')) {
			return false;
		}
		if ($strict === false) {
			// Get root categories
			$categories_search_attrs = array(
				"module" 		=> $cms_module,
				"language" 		=> $crossLanguage ? '' : $cms_language,
				"level" 		=> $level,
				"root" 			=> $root,
				"cms_user" 		=> &$cms_user,
				"clearanceLevel"=> $clearanceLevel,
				"strict" 		=> $strict,
			);
			$root_categories = CMS_module::getModuleCategories($categories_search_attrs);
		} else {
			//for backward compatibility
			if ($clearanceLevel === false) {
				$clearanceLevel = CLEARANCE_MODULE_VIEW;
			} elseif ($clearanceLevel === true) {
				$clearanceLevel = CLEARANCE_MODULE_EDIT;
			}
			switch($clearanceLevel) {
				case CLEARANCE_MODULE_VIEW:
					$root_categories = $cms_user->getRootModuleCategoriesReadable($cms_module, true);
					break;
				case CLEARANCE_MODULE_EDIT:
					$root_categories = $cms_user->getRootModuleCategoriesWritable($cms_module, true);
					break;
				case CLEARANCE_MODULE_MANAGE:
					$root_categories = $cms_user->getRootModuleCategoriesManagable($cms_module, true);
					break;
			}
			if (is_array($root_categories) && $root_categories) {
				if (sensitiveIO::isPositiveInteger($level) || sensitiveIO::isPositiveInteger($root)) {
					//check for missing root cat
					$missing = true;
					foreach ($root_categories as $key => $obj) {
						if (sensitiveIO::isPositiveInteger($root)) {
							if (!$obj->hasAncestor($level)) {
								unset($root_categories[$key]);
								continue;
							}
						}
						if (sensitiveIO::isPositiveInteger($level)) {
							if (!$obj->hasAncestor($level)) {
								unset($root_categories[$key]);
							}
						}
						if ($obj->getID() == $level) {
							$missing = false;
						}
					}
					//For bug in ticket 2565 (support WS)
					if ($missing && $cms_user->hasModuleCategoryClearance($level, $clearanceLevel, $cms_module)) {
						if (sensitiveIO::isPositiveInteger($level)) {
							$lvlCat = CMS_moduleCategories_catalog::getByID($level);
						}
						$root_categories[] = $lvlCat;
					}
					foreach ($root_categories as $key => $obj) {
						if ($obj->getID() == $level) {
							unset($root_categories[$key]);
							//only sub categories needed
							$categories_search_attrs = array(
								"module" 		=> $cms_module,
								"language" 		=> $crossLanguage ? '' : $cms_language,
								"level" 		=> $level,
								"root" 			=> $root,
								"cms_user" 		=> &$cms_user,
								"clearanceLevel"=> $clearanceLevel,
								"strict" 		=> $strict,
							);
							$root_categories = array_merge(CMS_module::getModuleCategories($categories_search_attrs), $root_categories);
						}
					}
				}
			}
		}
		$ctgs = array();
		if (is_array($root_categories) && $root_categories) {
			foreach ($root_categories as $obj) {
				$obj->setAttribute('language', $cms_language);
				$ctgs[$obj->getID()] = io::htmlspecialchars($obj->getLabel());
				if (false !== ($a_siblings = CMS_moduleCategories_catalog::getSiblingCategoriesAsArray($obj, 0, $cms_user, $cms_module, $cms_language, $clearanceLevel, $strict))) {
					while(list($id, $lbl) = each($a_siblings)) {
						if ($id) {
							$ctgs[$id] = $lbl;
						}
					}
				}
			}
		}
		return $ctgs;
	}
	
	/**
	  * Returns each category ID and label in a module given user can see
	  *
	  * @access public
	  * @param CMS_profile $cms_user, the profile concerned by these restrictions
	  * @param string $cms_module, the module codename
	  * @param CMS_language $cms_language, the language of the labels
	  * @param mixed $clearanceLevel 
	  * - false : CLEARANCE_MODULE_VIEW
	  * - true : CLEARANCE_MODULE_EDIT
	  * - constant value : clearanceLevel value
	  * @param boolean $strict return only categories from this clearance (default : false, else, return complete categories tree until given clearance)
	  * @return array(string) the statements or false if profile hasn't any access to any categories
	  * @static
	  */
	static function getSiblingCategoriesAsArray(&$category, $count, &$cms_user, $cms_module, $cms_language, $clearanceLevel = false, $strict = false) {
		$count++;
		$attrs = array(
			"module" 		=> $cms_module,
			"language" 		=> $cms_language,
			"level" 		=> $category->getID(),
			"root" 			=> false,
			"cms_user" 		=> &$cms_user,
			"clearanceLevel"=> $clearanceLevel,
			"strict" 		=> $strict,
		);
		$siblings = CMS_module::getModuleCategories($attrs);
		if (is_array($siblings) && $siblings) {
			$ctgs = array();
			foreach ($siblings as $obj) {
				$ctgs[$obj->getID()] = str_repeat('-&nbsp;', $count).''.io::htmlspecialchars($obj->getLabel());
				if (false !== ($a_sibling = CMS_moduleCategories_catalog::getSiblingCategoriesAsArray($obj, $count, $cms_user, $cms_module, $cms_language, $clearanceLevel, $strict))) {
					while(list($id, $lbl) = each($a_sibling)) {
						if ($id) {
							$ctgs[$id] = $lbl;
						}
					}
				}
			}
			if (is_array($ctgs) && $ctgs) {
				return $ctgs;
			}
		}
		return false;
	}
	
	/**
	  * Create a select box XHTML containing all categories user has access to
	  * View CMS_dialog_listboxes::getListBox for detail
	  * @param mixed array() $args, This array contains all parameters.
	  * @return string, XHTML formated
	  */
	static function getListBox($args) {
		return CMS_dialog_listboxes::getListBox($args);
	}
	
	/**
	  * Create 2 listboxes XHTML exchanging their values through javascript
	  * View CMS_dialog_listboxes::getListBoxes for detail
	  * @param mixed array() $args, This array contains all parameters.
	  * @return string, XHTML formated
	  */
	static function getListBoxes($args) {
		return CMS_dialog_listboxes::getListBoxes($args);
	}
	
	/**
	  * Import module from given array datas
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
	static function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for categories importation ...'."\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for categories importation : '.$params['module']."\n";
			return false;
		}
		$return = true;
		foreach ($data as $categoryDatas) {
			$importType = '';
			if (isset($categoryDatas['uuid'])
				 && ($id = CMS_moduleCategories_catalog::categoryExists($params['module'], $categoryDatas['uuid']))) {
				//category already exist : load it if we can update it
				if (!isset($params['update']) || $params['update'] == true) {
					$category = CMS_moduleCategories_catalog::getByID($id);
					$importType = ' (Update)';
				}
			} else {
				//create new category if we can
				if (!isset($params['create']) || $params['create'] == true) {
					//if category to create has parent, try to get it
					if (isset($categoryDatas['parent']) && $categoryDatas['parent']) {
						//check for uuid translation
						if (isset($idsRelation['categories-uuid'][$categoryDatas['parent']])) {
							$categoryDatas['parent'] = $idsRelation['categories-uuid'][$categoryDatas['parent']];
						}
						//parent already exist : load it
						$parentId = CMS_moduleCategories_catalog::categoryExists($params['module'], $categoryDatas['parent']);
					}
					if (isset($categoryDatas['root']) && $categoryDatas['root']) {
						//check for uuid translation
						if (isset($idsRelation['categories-uuid'][$categoryDatas['root']])) {
							$categoryDatas['root'] = $idsRelation['categories-uuid'][$categoryDatas['root']];
						}
						//root already exist : load it
						$rootId = CMS_moduleCategories_catalog::categoryExists($params['module'], $categoryDatas['root']);
					}
					//create category
					$category = new CMS_moduleCategory(0, $cms_language);
					$importType = ' (Creation)';
					//set module
					$category->setAttribute('moduleCodename', $params['module']);
					if (isset($rootId)) {
						$category->setAttribute('rootID', $rootId);
					}
					if (isset($parentId)) {
						$category->setAttribute('parentID', $parentId);
					}
				}
			}
			if (isset($category)) {
				if ($category->fromArray($categoryDatas, $params, $cms_language, $idsRelation, $infos)) {
					$return &= true;
					$infos .= 'Category "'.$category->getLabel($cms_language).'" successfully imported'.$importType."\n";
				} else {
					$return = false;
					$infos .= 'Error during import of category '.$categoryDatas['id'].$importType."\n";
				}
			}
		}
		return $return;
	}
	
	/**
	  * Does a category exists with given parameters
	  * this method is use by fromArray import method to know if an imported category already exist or not
	  *
	  * @param string $module The module codename to check
	  * @param string $uuid The category uuid to check
	  * @return mixed : integer id if exists, false otherwise
	  * @access public
	  */
	static function categoryExists($module, $uuid) {
		if (!$module) {
			CMS_grandFather::raiseError("module must be set");
			return false;
		}
		if (!$uuid) {
			CMS_grandFather::raiseError("uuid must be set");
			return false;
		}
		$q = new CMS_query("
			select 
				id_mca
			from 
				modulesCategories 
			where
				uuid_mca='".io::sanitizeSQLString($uuid)."'
				and module_mca='".io::sanitizeSQLString($module)."'
		");
		if ($q->getNumRows()) {
			return $q->getValue('id_mca');
		}
		return false;
	}
	
	/**
	  * Does given uuid already exists for categories
	  *
	  * @param string $uuid The category uuid to check
	  * @return boolean
	  * @access public
	  */
	static function uuidExists($uuid) {
		if (!$uuid) {
			CMS_grandFather::raiseError("uuid must be set");
			return false;
		}
		$q = new CMS_query("
			select 
				id_mca
			from 
				modulesCategories 
			where
				uuid_mca='".io::sanitizeSQLString($uuid)."'
				and parent_mca != '".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
		");
		return $q->getNumRows() ? true : false;
	}
}
?>
