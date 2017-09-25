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
// $Id: profilemodulecategoriesclearances.php,v 1.2 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_moduleCategoriesClearances
  *
  *  editing/viewing permissions for a user profile on moduleCategories
  *
  * @package Automne
  * @subpackage user
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_moduleCategoriesClearances extends CMS_grandFather
{
	/**
	  * ID of user profile
	  * 
	  * @var integer
	  * @access private
	  */
	protected $_profileID;

	/**
	  * Stack containg pairs (categoryID, clearance integer value)
	  * 
	  * @var CMS_stack
	  * @access private
	  */
	protected $_categoriesClearances;
	
	/**
	  * Module codename if needed to restrict clearances output
	  * 
	  * @var CMS_stack
	  * @access private
	  */
	protected $_moduleCodename;
	
	/**
	  * Clearances are at admin level ?
	  * 
	  * @var booean
	  * @access private
	  */
	protected $_isAdmin = false;
	
	/**
	  * Constructor.
	  *
	  * @param integer $id if of user profile 
	  * @return void
	  * @access public
	  */
	public function __construct($profileID = false)
	{
		$this->_categoriesClearances = new CMS_stack();
		if ($profileID) {
			if (SensitiveIO::isPositiveInteger($profileID)) {
				$this->_profileID = $profileID;
				$sql = "
					select
						category_mcc as categoryID,
						clearance_mcc as clearance
					from
						modulesCategories,
						modulesCategories_clearances
					where
						id_mca=category_mcc
						and profile_mcc='".$this->_profileID."'
						and parent_mca != '".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
				";
				$q = new CMS_query($sql);
				while ($datas = $q->getArray()) {
					$this->_categoriesClearances->add($datas['categoryID'], $datas['clearance']);
				}
			} else {
				$this->setError("Id is not a positive integer");
				return;
			}
		}
	}

	/**
	  * Get profile user Id
	  *
	  * @return integer
	  * @access public
	  */
	public function getProfileID() {
		return $this->_profileID;
	} 

	/**
	  * Set profile user Id
	  *
	  * @param integer $profileID, the profile user ID to set
	  * @return boolean true on success
	  * @access public
	  */
	public function setProfileID($profileID) {
		if (SensitiveIO::isPositiveInteger($profileID)) {
			$this->_profileID = $profileID;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Set admin level on clearances
	  *
	  * @param boolean $isAdmin, clearances are at admin level ?
	  * @return boolean true on success
	  * @access public
	  */
	public function setAdminLevel($isAdmin) {
		$this->_isAdmin = ($isAdmin) ? true : false;
		if ($this->_isAdmin) {
			//reset all categories clearances
			$this->_categoriesClearances = new CMS_stack();
			$sql = "
				select
					id_mca as categoryID
				from
					modulesCategories
				where
					parent_mca = '0'
			";
			$q = new CMS_query($sql);
			while ($datas = $q->getArray()) {
				$this->_categoriesClearances->add($datas['categoryID'], CLEARANCE_MODULE_MANAGE);
			}
		}
		return true;
	}
	
	/**
	  * Get admin level on clearances
	  *
	  * @return boolean
	  * @access public
	  */
	public function getAdminLevel($isAdmin) {
		return $this->_isAdmin;
	}
	
	/**
	  * Get module codename
	  *
	  * @return string
	  * @access public
	  */
	public function getModuleCodename() {
		return $this->_moduleCodename;
	} 

	/**
	  * Set module codename
	  *
	  * @param integer $profileID, the profile user ID to set
	  * @return boolean true on success
	  * @access public
	  */
	public function setModuleCodename($moduleCodename) {
		$this->_moduleCodename = $moduleCodename;
		return true;
	}
	
	/**
	  * Set module codename
	  *
	  * @param string $moduleCodename, the module to get categories related to
	  * @return CMS_stack
	  * @access public
	  */
	public function getCategoriesClearances($moduleCodename = false) {
		static $getCategoriesClearances;
		// Limit output to one module
		if ($moduleCodename) {
			if (!isset($getCategoriesClearances[$moduleCodename]) || !isset($getCategoriesClearances[$moduleCodename][$this->_profileID]) || !is_a($getCategoriesClearances[$moduleCodename][$this->_profileID],'CMS_stack')) {
				$stack = new CMS_stack();
				if (!$this->_isAdmin) {
					$sql = "
						select
							category_mcc as categoryID,
							clearance_mcc as clearance
						from
							modulesCategories_clearances,
							modulesCategories
						where
							id_mca=category_mcc
							and module_mca = '".SensitiveiO::sanitizeSQLString($moduleCodename)."'
							and profile_mcc='".$this->_profileID."'
							and parent_mca != '".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
					";
				} else {
					$sql = "
						select
							id_mca as categoryID
						from
							modulesCategories
						where
							parent_mca = '0'
							and module_mca = '".SensitiveiO::sanitizeSQLString($moduleCodename)."'";
				}
				$q = new CMS_query($sql);
				while ($datas = $q->getArray()) {
					$clearance = (!$this->_isAdmin) ? $datas['clearance'] : CLEARANCE_MODULE_MANAGE;
					$stack->add($datas['categoryID'], $clearance);
				}
				$getCategoriesClearances[$moduleCodename][$this->_profileID] = $stack;
			} else {
				$stack = $getCategoriesClearances[$moduleCodename][$this->_profileID];
			}
			return $stack;
		} else {
			return $this->_categoriesClearances;
		}
	}
	
	/**
	  * Set all category clearances from a stack
	  * 
	  * @param CMS_stack $clearances, stack containing all categories
	  * @return boolean true on success
	  * @access public
	  */
	public function setCategoriesClearances($clearances) {
		if (is_a($clearances, "CMS_stack")) {
			$this->_categoriesClearances = $clearances;
			return true;
		} else {
			$this->setError("Stack object required : " . var_dump($clearances));
			return false;
		}
	}
	
	/**
	  * Delete one category clearance
	  * 
	  * @param integer $categoryID, ID of category to delete from stack
	  * @return boolean true on success
	  * @access public 
	  */
	public function del($categoryID) {
		if (SensitiveIO::isPositiveInteger($categoryID)) {
			$this->_categoriesClearances->del($categoryID);
			return true;
		} else {
			$this->setError("Category ID required : ".var_dump($categoryID));
			return false;
		}
	} 
	
	/**
	  * Add category clearances to current stack
	  * 
	  * @param CMS_stack $clearances, clearances to add
	  * @return boolean true on success
	  * @access public
	  */
	public function add($clearances) {
		if (is_a($clearances, "CMS_stack")) {
			$arr = $clearances->getElements();
			if (is_array($arr) && $arr) {
				while (list($k, $v) = each($arr)) {
					$this->_categoriesClearances->delAllWithOneValue($v[1], 1);
					$this->_categoriesClearances->add($v[1], $v[2]);
				}
			}
			return true;
		} else {
			$this->setError("Stack object required : " . var_dump($clearances));
			return false;
		}
	}
	
	/**
	  * Get all info in one string
	  * 
	  * @return string
	  * @access public
	  */
	public function toString()
	{
		return $this->_profileID.':'.$this->_categoriesClearances->getTextDefinition();
	}
	
	/**
	  * Delete all category clearances for profile
	  * 
	  * @return boolean true on success
	  * @access public
	  */
	public function deleteCategoriesClearances() 
	{
		if ($this->_profileID) {
			// Delete old clearances
			$sql = "
				delete
				from
					modulesCategories_clearances
				where
					profile_mcc='".$this->_profileID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->setError("Error on sql statement : " . var_dump($sql));
				return false;
			}
		}
		$this->_categoriesClearances = new CMS_stack();
		return true;
	}
	
	/**
	  * Writes these clearances into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence()
	{
		if ($this->_profileID && is_a($this->_categoriesClearances, "CMS_stack")) {
			$err = 0;
			// Delete old clearances
			$sql = "
				delete
				from
					modulesCategories_clearances
				where
					profile_mcc='".$this->_profileID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$err++;
				$this->setError("Error on sql statement : " . var_dump($sql));
			}
			// Insert new ones
			$elements = $this->_categoriesClearances->getElements();
			if (is_array($elements) && $elements) {
				$values = '';
				foreach ($elements as $v) {
					$values .= ($values) ? ',':'';
					$values .= "('".$this->_profileID."', '".$v[0]."', '".$v[1]."')";
				}
				$sql = "
					insert into modulesCategories_clearances
						(profile_mcc, category_mcc, clearance_mcc)
					values ".$values."
				";
				$q = new CMS_query($sql);
				if ($q->hasError()) {
					$err++;
					$this->setError("Error on sql statement : " . var_dump($sql));
				}
			}
			return (!$err) ? true : false ;
		}
	}
}
?>