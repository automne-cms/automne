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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: profile.php,v 1.6 2009/10/22 16:30:27 sebastien Exp $

/**
  * Class CMS_Profile
  *
  *  editing/viewing permissions for a user profile
  *
  * @package CMS
  * @subpackage user
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_profile extends CMS_grandFather
{
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL = 16;
	const MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES = 17;
	const MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES = 18;  
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES = 19;  
	const MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG = 20;
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS = 77;
	const MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH = 438;
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL_DESCRIPTION = 487;
	const MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES_DESCRIPTION = 488;
	const MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES_DESCRIPTION = 489;  
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES_DESCRIPTION = 490;  
	const MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG_DESCRIPTION = 491;
	const MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS_DESCRIPTION = 492;
	const MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH_DESCRIPTION = 1448;
	
	const MESSAGE_ALERT_LEVEL_VALIDATION = 21;
	const MESSAGE_ALERT_LEVEL_PROFILE = 22;
	const MESSAGE_ALERT_LEVEL_PAGE_ALERTS = 23;
	const MESSAGE_ALERT_LEVEL_VALIDATION_DESCRIPTION = 335;
	const MESSAGE_ALERT_LEVEL_PROFILE_DESCRIPTION = 336;
	const MESSAGE_ALERT_LEVEL_PAGE_ALERTS_DESCRIPTION = 337;

	const MESSAGE_CLEARANCE_PAGE_NONE = 1;
	const MESSAGE_CLEARANCE_PAGE_VIEW = 2;
	const MESSAGE_CLEARANCE_PAGE_EDIT = 3;
	
	const MESSAGE_CLEARANCE_MODULE_NONE = 266;
	const MESSAGE_CLEARANCE_MODULE_VIEW = 267;
	const MESSAGE_CLEARANCE_MODULE_EDIT = 268;
	const MESSAGE_CLEARANCE_MODULE_NONE_DESCRIPTION = 470;
	const MESSAGE_CLEARANCE_MODULE_VIEW_DESCRIPTION = 471;
	const MESSAGE_CLEARANCE_MODULE_EDIT_DESCRIPTION = 472;
	
	const MESSAGE_CLEARANCE_MODULE_CATEGORIES_NONE = 266;
	const MESSAGE_CLEARANCE_MODULE_CATEGORIES_VIEW = 1340;
	const MESSAGE_CLEARANCE_MODULE_CATEGORIES_EDIT = 1341;
	const MESSAGE_CLEARANCE_MODULE_CATEGORIES_MANAGE = 1342;
	
	/**
	  * pageClearances, stack of page Clearances
	  *
	  * @var CMS_stack
	  * @access private
	  */
	protected $_pageClearances;
	
	/**
	  * moduleClearances , array of module Clearances
	  *
	  * @var CMS_stack
	  * @access private
	  */
	protected $_moduleClearances;
	
	/**
	  * moduleCategoriesClearances , array of clearances on
	  * each CMS_moduleCategory concerned
	  *
	  * @var CMS_moduleCategoriesClearances
	  * @access private
	  */
	protected $_moduleCategoriesClearances;
	
	/**
	  * validationClearances , array of validation Clearance
	  *
	  * @var CMS_stack
	  * @access private
	  */
	protected $_validationClearances;
	
	/**
	  * adminClearance , administration Clearance
	  *
	  * @var integer
	  * @access private
	  */
	protected $_adminClearance;
	

	/**
	  * id of profile record in db
	  *
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * templateGroupsDenied, template groups denied to user 
	  *
	  * @var CMS_stack(string)
	  * @access private
	  */
	protected $_templateGroupsDenied;
	
	/**
	  * rowGroupsDenied, row groups denied to user 
	  *
	  * @var CMS_stack(string)
	  * @access private
	  */
	protected $_rowGroupsDenied;
	
	/**
	  * Constructor.
	  * initializes the profile from the database if the id
	  * is given
	  *
	  * @param integer $id if of profile 
	  * @return void
	  * @access public
	  */
	function __construct($id = 0)
	{
		// Initiate Stack objects
		$this->_pageClearances = new CMS_stack();
		$this->_validationClearances = new CMS_stack();
		$this->_validationClearances->setValuesByAtom(1);
		$this->_moduleClearances = new CMS_stack();
		$this->_templateGroupsDenied = new CMS_stack();
		$this->_templateGroupsDenied->setValuesByAtom(1); // Assume 1 atom
		$this->_rowGroupsDenied = new CMS_stack();
		$this->_rowGroupsDenied->setValuesByAtom(1); // Assume 1 atom
		
		// Categories clearance only
		$this->_moduleCategoriesClearances = new CMS_moduleCategoriesClearances();
		if ($id) {
			if (SensitiveIO::isPositiveInteger($id)) {
				$this->_id = $id;
				$sql = "
					select
						*
					from
						profiles
					where
						id_pr='$id'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					
					// Get integer values
					$this->_adminClearance = $data["administrationClearance_pr"];
					
					// Categories clearance only
					$this->_moduleCategoriesClearances = new CMS_moduleCategoriesClearances($this->_id);
					
					//Get values Catch errors?
					if (
					  	!$this->_pageClearances->
					    	setTextDefinition($data["pageClearancesStack_pr"]) ||
						!$this->_validationClearances->
					  		setTextDefinition($data["validationClearancesStack_pr"]) ||
						!$this->_moduleClearances->
							setTextDefinition($data["moduleClearancesStack_pr"]) ||
						!$this->_templateGroupsDenied->
							setTextDefinition($data["templateGroupsDeniedStack_pr"]) ||
						!$this->_rowGroupsDenied->
							setTextDefinition($data["rowGroupsDeniedStack_pr"])) {
							
						$this->raiseError("Incorrect Stack formation in profile id ".$id);
					}
				} else {
					$this->raiseError("Unknown DB ID : ".$id);
				}
			} elseif (is_array($id)) {
				$data = $id;
					
				// Get integer values
				$this->_id = $data["id_pr"];
				$this->_adminClearance = $data["administrationClearance_pr"];
				
				// Categories clearance only
				$this->_moduleCategoriesClearances = new CMS_moduleCategoriesClearances($this->_id);
				
				//Get values Catch errors?
				if (
				  	!$this->_pageClearances->
				    	setTextDefinition($data["pageClearancesStack_pr"]) ||
					!$this->_validationClearances->
				  		setTextDefinition($data["validationClearancesStack_pr"]) ||
					!$this->_moduleClearances->
						setTextDefinition($data["moduleClearancesStack_pr"]) ||
					!$this->_templateGroupsDenied->
						setTextDefinition($data["templateGroupsDeniedStack_pr"]) ||
					!$this->_rowGroupsDenied->
						setTextDefinition($data["rowGroupsDeniedStack_pr"])) {
						
					$this->raiseError("Incorrect Stack formation in profile id ".$id);
				}
			} else {
				$this->raiseError("Id is not a positive integer nor array");
				return;
			}
		}
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$this->_moduleCategoriesClearances->setAdminLevel(true);
		}
	}
	
	/**
	  * Get Id
	  *
	  * @return integer
	  * @access public
	  */
	function getId()
	{
		return $this->_id;
	}
	
	/**
	  * Sets Administration Clearance
	  *
	  * @param  integer $adminClearance
	  * @return void
	  * @access public
	  */
	function setAdminClearance($adminClearance)
	{
		$sumAllAdminClearances = array_sum(array_keys($this->getAllAdminClearances()));
		if ($sumAllAdminClearances >= $adminClearance && 
		    $adminClearance >= 0 ) {
			$this->_adminClearance = $adminClearance;
		} else {
			$this->raiseError('Invalid set admin Clearance: '.$adminClearance);
		}
	}
	
	/**
	  * add Administration Clearance
	  *
	  * @param  integer $adminClearance
	  * @return void
	  * @access public
	  */
	function addAdminClearance($adminClearance)
	{
		$adminClearance = (int) $adminClearance;
		$sumAllAdminClearances = array_sum(array_keys($this->getAllAdminClearances()));
		if ($adminClearance > $sumAllAdminClearances || ($adminClearance | $this->_adminClearance) > $sumAllAdminClearances) {
			$this->raiseError('Invalid set admin Clearance: '.$adminClearance);
			return false;
		}
		//bitwise addition
		$this->_adminClearance = $adminClearance | $this->_adminClearance;
		return true;
	}
	
	/**
	  * Get Administration Clearance
	  *
	  * @return integer
	  * @access public
	  */
	function getAdminClearance()
	{
		return $this->_adminClearance;
	}

	/**
	  * Has Administration Clearance
	  *
	  * @param  integer $clearance clearance to test for
	  * @return boolean
	  * @access public
	  */
	function hasAdminClearance($clearance)
	{
		return ($this->_adminClearance & $clearance) || ($this->_adminClearance & CLEARANCE_ADMINISTRATION_EDITVALIDATEALL);
	}
	
	/**
	  * Has Administration Access
	  * Need an admin clearance or a page edition clearance or a module admin clearance
	  *
	  * @param  integer $clearance clearance to test for
	  * @return boolean
	  * @access public
	  */
	function hasAdminAccess()
	{
		return $this->_adminClearance || /*$this->hasValidationClearance() ||*/ $this->hasEditablePages() || $this->hasEditableModules();
	}
	
	/**
	  * Sets Page Clearances
	  *
	  * @param  CMS_stack $pageClearances page clearances for this profile
	  * @return void
	  * @access public
	  */
	function setPageClearances($pageClearances)
	{
		if (is_a($pageClearances, "CMS_stack")) {
			$this->_pageClearances = $pageClearances;
		} else {
			$this->raiseError('Stack object required: '.$pageClearances);
		}
	}
	
	/**
	  * Add Page Clearances
	  *
	  * @param  CMS_stack $pageClearances page clearances to add to this profile
	  * @return void
	  * @access public
	  */
	function addPageClearances($pageClearances)
	{
		if (!is_a($pageClearances, "CMS_stack")) {
			$this->raiseError('Stack object required: '.$pageClearances);
			return false;
		}
		$this->_pageClearances = $this->_addStackClearances($pageClearances, $this->_pageClearances);
		return true;
	}
	
	/**
	  * Gets Page Clearances
	  *
	  * @return CMS_stack()
	  * @access public
	  */
	function getPageClearances()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$this->_pageClearances = new CMS_stack();
			$this->_pageClearances->add(APPLICATION_ROOT_PAGE_ID, CLEARANCE_PAGE_EDIT);
		}
		return $this->_pageClearances;
	}
	
	/**
	  * Del Page Clearances
	  *
	  * @return void
	  * @access public
	  */
	function delPageClearances()
	{
		$this->_pageClearances->emptyStack();
	}
	
	/**
	  * Del Page Clearance
	  *
	  * @var integer $pageid
	  * @return void
	  * @access public
	  */
	function delPageClearance($pageid)
	{
		if (!is_null($this->_pageClearances->getElementsWithOneValue($pageid,1))) {
			$this->_pageClearances->delAllWithOneValue($pageid, 1);
		}
	}
	
    /**
	  * Get all the viewvable page roots (page IDs)
	  *
	  * @return array(integer)
	  * @access public
	  */
	function getViewablePageClearanceRoots()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return array(APPLICATION_ROOT_PAGE_ID);
		}
		$clearances = $this->_pageClearances->getElements();
		$roots = array();
		foreach ($clearances as $clearance) {
			if ($clearance[1] >= CLEARANCE_PAGE_VIEW) {
				$roots[] = $clearance[0];
			}
		}
		return $roots;
	}
	
	/**
	  * Does profile has visible clearances roots (page IDs)
	  *
	  * @return boolean
	  * @access public
	  */
	function hasViewvablePages()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return true;
		}
		$clearances = $this->_pageClearances->getElements();
		$roots = array();
		foreach ($clearances as $clearance) {
			if ($clearance[1] >= CLEARANCE_PAGE_VIEW) {
				return true;
			}
		}
		return false;
	}
	
    /**
	  * Get all the editable page roots (page IDs)
	  *
	  * @return array(integer)
	  * @access public
	  */
	function getEditablePageClearanceRoots()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return array(APPLICATION_ROOT_PAGE_ID);
		}
		$clearances = $this->_pageClearances->getElements();
		$roots = array();
		foreach ($clearances as $clearance) {
			if ($clearance[1] >= CLEARANCE_PAGE_EDIT) {
				$roots[] = $clearance[0];
			}
		}
		return $roots;
	}
	
	/**
	  * Does profile has editable clearances roots (page IDs)
	  *
	  * @return boolean
	  * @access public
	  */
	function hasEditablePages()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return true;
		}
		$clearances = $this->_pageClearances->getElements();
		$roots = array();
		foreach ($clearances as $clearance) {
			if ($clearance[1] >= CLEARANCE_PAGE_EDIT) {
				return true;
			}
		}
		return false;
	}
	
	/**
	  * Does profile has editable clearances roots (page IDs)
	  *
	  * @return boolean
	  * @access public
	  */
	function hasEditableModules()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return true;
		}
		$clearances = $this->_moduleClearances->getElements();
		$roots = array();
		foreach ($clearances as $clearance) {
			if ($clearance[1] >= CLEARANCE_MODULE_EDIT) {
				return true;
			}
		}
		return false;
	}
	
	 /**
	  * has Page Clearances (this function must be as fast as possible
	  * because it is often used with APPLICATION_ENFORCES_ACCESS_CONTROL)
	  *
	  * @param integer $pageId
	  * @param integer $clearance The clearance to test
	  * @return boolean
	  * @access public
	  * @calls _hasClearance
	  */
	function hasPageClearance($pageId, $clearance)
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return true;
		}
		$rootID = $this->getPageClearanceRoot($pageId,false);
		if ($rootID) {
			return $this->_hasClearance($this->_pageClearances, $rootID, $clearance);
		} else {
			return false;
		}
	}
	
	/**
	  * Get the page clearance root for a given page (this function must be as fast as possible
	  * because it is often used with APPLICATION_ENFORCES_ACCESS_CONTROL)
	  *
	  * @param integer $pageId The DB ID of the page we test
	  * @return The root page (CMS_page if $outputCMS_page is true, else pageID)
	  * @access public
	  * @static
	  */
	function getPageClearanceRoot($pageId,$outputCMS_page=true)
	{
		if (!$this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$clearances = $this->_pageClearances->getElements();
			$nearestRoot = false;
			//get the full lineage of queried page
			$lineage = CMS_tree::getLineage(APPLICATION_ROOT_PAGE_ID, $pageId, false);
			if (!$lineage) {
				CMS_grandFather::raiseError('Lineage error for page : '.$pageId);
				return false;
			} else {
				$lineage = array_reverse($lineage);
				foreach ($lineage as $ancestor) {
					foreach ($clearances as $clearance) {
						if ($ancestor == $clearance[0]) {
							$nearestRoot = $ancestor;
							break 2;
						}
					}
				}
			}
		} else {
			$nearestRoot = APPLICATION_ROOT_PAGE_ID;
		}
		if ($outputCMS_page) {
			return CMS_tree::getPageByID($nearestRoot);
		} else {
			return $nearestRoot;
		}
	}
	
	
	/**
	  * add Page Clearances
	  *
	  * @param integer $pageId pageid 
	  * @param integer $clearance clearance to add
	  * @param boolean $overwrite if true overwrites previous clearance
	  * @return void
	  * @access public
	  */
	function addPageClearance($pageId, $clearance, $overwrite)
	{
		if (!SensitiveIO::isInSet($clearance, $this->getAllPageClearances())) {
			$this->raiseError("Invalid Page Clearance: ".$clearance);	
		} else if (!SensitiveIO::isPositiveInteger($pageId)) {
			$this->raiseError("Invalid Page Id Clearance: ".$pageId);	
		} else {
			if ($this->_pageClearances->getElementsWithOneValue($pageId, 1)) {
				if ($overwrite) {
					$this->_pageClearances->delAllWithOneValue($pageId, 1);
					$this->_pageClearances->add($pageId, $clearance);
				}
			} else {
				$this->_pageClearances->add($pageId, $clearance);
			}
		}
	}
	
	/**
	  * Sets Module Clearances
	  *
	  * @param  CMS_stack() $moduleClearances
	  * @return void
	  * @access public
	  */
	function setModuleClearances($moduleClearances)
	{
		if (is_a($moduleClearances, "CMS_stack")) {
			$this->_moduleClearances = $moduleClearances;
		} else {
			$this->raiseError('Stack object required');
		}
	}
	
	/**
	  * add Module Clearances
	  *
	  * @param  CMS_stack() $moduleClearances
	  * @return void
	  * @access public
	  */
	function addModuleClearances($moduleClearances)
	{
		if (!is_a($moduleClearances, "CMS_stack")) {
			$this->raiseError('Stack object required: '.$moduleClearances);
			return false;
		}
		$this->_moduleClearances = $this->_addStackClearances($moduleClearances, $this->_moduleClearances);
		return true;
	}
	
	/**
	  * Gets Module Clearances
	  *
	  * @return CMS_stack()
	  * @access public
	  */
	function getModuleClearances()
	{
		return $this->_moduleClearances;
	}
	
	/**
	  * Del Module Clearances
	  *
	  * @return void
	  * @access public
	  */
	function delModuleClearances()
	{
		$this->_moduleClearances->emptyStack();
	}
	
	/**
	  * Del Module Clearance
	  *
	  * @var string $moduleCodename
	  * @return void
	  * @access public
	  */
	function delModuleClearance($moduleCodename)
	{
		if (!is_null($this->_moduleClearances->getElementsWithOneValue($moduleCodename,1))) {
			$this->_moduleClearances->delAllWithOneValue($moduleCodename, 1);
		}
	}
	
    /**
	  * Has Module Clearances
	  *
	  * @param string $moduleCodename
	  * @param integer $clearance
	  * @return boolean
	  * @access public
	  */
	function hasModuleClearance($moduleCodename, $clearance)
	{
		return ($this->_hasClearance($this->_moduleClearances, $moduleCodename, $clearance)
			|| $this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL));
	}
	
	/**
	  * add Module Clearances
	  *
	  * @param string $moduleCodename
	  * @param integer $clearance
	  * @param boolean $overwrite if true overwrites previous clearance
	  * if clearance exists
	  * @return void
	  * @access public
	  */
	function addModuleClearance($moduleCodename, $clearance, $overwrite)
	{
		$clearances = $this->getAllModuleClearances();
		if (!isset($clearances[$clearance])) {
			$this->raiseError("Invalid Module Clearance: ".$clearance);	
		} else {
			if ($this->_moduleClearances->getElementsWithOneValue($moduleCodename, 1)) {
				if ($overwrite) {
					$this->_moduleClearances->delAllWithOneValue($moduleCodename, 1);
					$this->_moduleClearances->add($moduleCodename, $clearance);
				}
			} else {
				$this->_moduleClearances->add($moduleCodename, $clearance);
			}
		}
	}
	
	/**
	  * Sets Validation Clearances
	  *
	  * @param  CMS_stack $validationClearances
	  * @return void
	  * @access public
	  */
	function setValidationClearances($validationClearances)
	{
		if (is_a($validationClearances, "CMS_stack")) {
			$this->_validationClearances = $validationClearances;
		}
	}
	
	/**
	  * add Validation Clearances
	  *
	  * @param  CMS_stack $validationClearances
	  * @return void
	  * @access public
	  */
	function addValidationClearances($validationClearances)
	{
		if (!is_a($validationClearances, "CMS_stack")) {
			$this->raiseError('Stack object required: '.$validationClearances);
			return false;
		}
		$this->_validationClearances = $this->_addStackClearances($validationClearances, $this->_validationClearances);
		return true;
	}
	
	/**
	  * Gets Validation Clearances
	  *
	  * @return CMS_stack
	  * @access public
	  */
	function getValidationClearances()
	{
		return $this->_validationClearances;
	}
	
	/**
	  * Del Validation Clearances
	  *
	  * @return void
	  * @access public
	  */
	function delValidationClearances()
	{
		$this->_validationClearances->emptyStack();
		$this->_validationClearances->setValuesByAtom(1);
	}
	
	/**
	  * Del Validation Clearance
	  *
	  * @var string $moduleCodename
	  * @return void
	  * @access public
	  */
	function delValidationClearance($moduleCodename)
	{
		if ($this->hasValidationClearance($moduleCodename)) {
			$this->_validationClearances->delAllWithOneValue($moduleCodename, 1);
		}
	}
	
	/**
	  * Has Validation Clearance
	  *
	  * @param string $moduleCodename
	  * @return boolean
	  * @access public
	  */
	function hasValidationClearance($moduleCodename = false)
	{
		if ($moduleCodename) {
			$clearanceOk = false;
			$clearances = $this->_validationClearances->getElementsWithOneValue($moduleCodename, 1);
			if (isset($clearances[0][0])
				|| $this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
					return true;
			}
		} else {
			if (sizeof($this->_validationClearances->getElements()) || $this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	  * Add Validation Clearance
	  *
	  * @param string $moduleCodename
	  * @return void
	  * @access public
	  */
	function addValidationClearance($moduleCodename)
	{
		$clearance = $this->_validationClearances->getElementsWithOneValue($moduleCodename, 1);
		if (!isset($clearance[0][0]) || !$clearance[0][0]) {
			$this->_validationClearances->add($moduleCodename);
		}
	}
	
	/**
	  * Check if user has a clearance
	  *
	  * @param CMS_stack $clearances
	  * @param integer $id
	  * @param integer $clearance
	  * @return boolean
	  * @access private
	  */
	protected function _hasClearance($clearances, $id, $clearance)
	{
		if (!SensitiveIO::isPositiveInteger($clearance) && $clearance != 0) {
			return false;
		}
		$clearanceOk = false;
		if ($aClearance = $clearances->getElementsWithOneValue($id, 1)) {
			foreach ($aClearance as $element) {
				if ($element[1] >= $clearance) {
					$clearanceOk = true;
					break;
				}
			}
		}
		return $clearanceOk;
	}
	
	/**
	  * Sets Templates groups denied
	  *
	  * @param  CMS_stack() $templateGroupsDenied
	  * @return void
	  * @access public
	  */
	function setTemplateGroupsDenied($templateGroupsDenied)
	{
		if (is_a($templateGroupsDenied, "CMS_stack") && $templateGroupsDenied->getValuesByAtom() == 1) {
			if (!$this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$this->_templateGroupsDenied = $templateGroupsDenied;
			}
		} else {
			$this->raiseError("Stack object with one value by atom is required");
			return false;
		}
	}
	
	/**
	  * add Templates groups denied
	  *
	  * @param  CMS_stack() $templateGroupsDenied
	  * @return void
	  * @access public
	  */
	function addTemplateGroupsDenied($templateGroupsDenied)
	{
		if (!is_a($templateGroupsDenied, "CMS_stack")) {
			$this->raiseError('Stack object required');
			return false;
		}
		if($templateGroupsDenied->getValuesByAtom() != 1 || $this->_templateGroupsDenied->getValuesByAtom() != 1) {
			$this->raiseError('Can\'t add stack objects without the same value by atom number ...');
			return false;
		}
		//add clearances (in this case it is in fact a difference between clearances)
		if (!$this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			//create arrays from clearances stacks (easier to manage)
			$stack1Clearance = array();
			foreach($templateGroupsDenied->getElements() as $clearanre) {
				$stack1Clearance[$clearanre[0]] = $clearanre[0];
			}
			$stack2Clearance = array();
			foreach($this->_templateGroupsDenied->getElements() as $clearanre) {
				$stack2Clearance[$clearanre[0]] = $clearanre[0];
			}
			//then diff both together
			$newClearance = array_unique(array_intersect($stack1Clearance, $stack2Clearance));
			//set CMS_stack with new pages clearance
			$addedClearances = new CMS_stack();
			$addedClearances->setValuesByAtom(1); // Assume 1 atom
			foreach($newClearance as $clearance) {
				$addedClearances->add($clearance);
			}
			$this->_templateGroupsDenied = $addedClearances;
		}
		return true;
	}
	
	/**
	  * Gets Templates groups denied
	  *
	  * @return CMS_stack()
	  * @access public
	  */
	function getTemplateGroupsDenied()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$this->_templateGroupsDenied = new CMS_stack();
			$this->_templateGroupsDenied->setValuesByAtom(1);
			return $this->_templateGroupsDenied;
		} else {
			return $this->_templateGroupsDenied;
		}
	}
	
	/**
	  * Gets Templates groups denied
	  *
	  * @param  string $templateGroup
	  * @return boolean
	  * @access public
	  */
	function hasTemplateGroupsDenied($templateGroup)
	{
		$template_denied = $this->_templateGroupsDenied->getElementsWithOneValue($templateGroup, 1);
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL) || !isset($template_denied[0]) || !$template_denied[0]) {
			return false;
		}
		return true;
	}
	
		/**
	  * Sets Row groups denied
	  *
	  * @param  CMS_stack() $rowGroupsDenied
	  * @return void
	  * @access public
	  */
	function setRowGroupsDenied($rowGroupsDenied)
	{
		if (is_a($rowGroupsDenied, "CMS_stack") && $rowGroupsDenied->getValuesByAtom() == 1) {
			if (!$this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$this->_rowGroupsDenied = $rowGroupsDenied;
			}
		} else {
			$this->raiseError('Stack object with one value by atom is required');
			return false;
		}
	}
	
	
	/**
	  * add Row groups denied
	  *
	  * @param  CMS_stack() $rowGroupsDenied
	  * @return void
	  * @access public
	  */
	function addRowGroupsDenied($rowGroupsDenied)
	{
		if (!is_a($rowGroupsDenied, "CMS_stack")) {
			$this->raiseError('Stack object required');
			return false;
		}
		if($rowGroupsDenied->getValuesByAtom() != 1 || $this->_rowGroupsDenied->getValuesByAtom() != 1) {
			$this->raiseError('Can\'t add stack objects without the same value by atom number ...');
			return false;
		}
		//add clearances (in this case it is in fact a difference between clearances)
		if (!$this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			//create arrays from clearances stacks (easier to manage)
			$stack1Clearance = array();
			foreach($rowGroupsDenied->getElements() as $clearanre) {
				$stack1Clearance[$clearanre[0]] = $clearanre[0];
			}
			$stack2Clearance = array();
			foreach($this->_rowGroupsDenied->getElements() as $clearanre) {
				$stack2Clearance[$clearanre[0]] = $clearanre[0];
			}
			//then diff both together
			$newClearance = array_unique(array_intersect($stack1Clearance, $stack2Clearance));
			//set CMS_stack with new pages clearance
			$addedClearances = new CMS_stack();
			$addedClearances->setValuesByAtom(1); // Assume 1 atom
			foreach($newClearance as $clearance) {
				$addedClearances->add($clearance);
			}
			$this->_rowGroupsDenied = $addedClearances;
		}
		return true;
	}
	
	/**
	  * Gets Row groups denied
	  *
	  * @return CMS_stack()
	  * @access public
	  */
	function getRowGroupsDenied()
	{
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$this->_rowGroupsDenied = new CMS_stack();
			$this->_rowGroupsDenied->setValuesByAtom(1);
			return $this->_rowGroupsDenied;
		} else {
			return $this->_rowGroupsDenied;
		}
	}
	
	/**
	  * Gets Row groups denied
	  *
	  * @param  string $rowGroup
	  * @return boolean
	  * @access public
	  */
	function hasRowGroupsDenied($rowGroup)
	{
		$row_denied = $this->_rowGroupsDenied->getElementsWithOneValue($rowGroup, 1);
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL) || !isset($row_denied[0]) || !$row_denied[0]) {
				return false;
		}
		return true;
	}
	
	/**
	  * Reset all profile clearances
	  *
	  * @return boolean
	  * @access public
	  */
	function resetClearances() {
		//admin clearance
		$this->_adminClearance = 0;
		// Initiate Stack objects
		$this->_pageClearances = new CMS_stack();
		$this->_validationClearances = new CMS_stack();
		$this->_validationClearances->setValuesByAtom(1);
		$this->_moduleClearances = new CMS_stack();
		$this->_templateGroupsDenied = CMS_pageTemplatesCatalog::getAllGroups(true);
		$this->_rowGroupsDenied = CMS_rowsCatalog::getAllGroups(true);
		// Categories clearance only
		$this->_moduleCategoriesClearances = new CMS_moduleCategoriesClearances();
		return true;
	}
	
	/**
	  * Add a given group to user
	  *
	  * @param mixed $group : the group to add or the group id to add
	  * @return boolean
	  * @access public
	  */
	function addGroup($group) {
		if (sensitiveIO::isPositiveInteger($group)) {
			//instanciate group to add
			$group = CMS_profile_usersGroupsCatalog::getByID($group);
		}
		if (!is_a($group, 'CMS_profile_usersGroup')) {
			$this->raiseError('Invalid group value to add : '.$group);
			return false;
		}
		return $group->addToUserAndWriteToPersistence($this);
	}
	
	/**
	  * Add two Clearances stacks together
	  *
	  * @param  CMS_stack $pageClearances page clearances to add to this profile
	  * @return void
	  * @access public
	  */
	protected function _addStackClearances($stack1, $stack2) {
		if (!is_a($stack1, "CMS_stack")) {
			$this->raiseError('Stack1 must be a valid stack object : '.$stack1);
			return false;
		}
		if (!is_a($stack2, "CMS_stack")) {
			$this->raiseError('Stack2 must be a valid stack object : '.$stack2);
			return false;
		}
		if ($stack1->getValuesByAtom() == 2 && $stack2->getValuesByAtom() == 2) {
			//create arrays from clearances stacks (easier to manage)
			$stack1Clearance = array();
			foreach($stack1->getElements() as $clearanre) {
				$stack1Clearance[$clearanre[0]] = $clearanre[1];
			}
			$stack2Clearance = array();
			foreach($stack2->getElements() as $clearanre) {
				$stack2Clearance[$clearanre[0]] = $clearanre[1];
			}
			//then add both together
			$newClearance = array();
			foreach($stack1Clearance as $clearance => $clearanceValue) {
				if ((isset($newClearance[$clearance]) && $newClearance[$clearance] < $clearanceValue) || !isset($newClearance[$clearance])) {
					$newClearance[$clearance] = $clearanceValue;
				}
			}
			foreach($stack2Clearance as $clearance => $clearanceValue) {
				if ((isset($newClearance[$clearance]) && $newClearance[$clearance] < $clearanceValue) || !isset($newClearance[$clearance])) {
					$newClearance[$clearance] = $clearanceValue;
				}
			}
			//set CMS_stack with new pages clearance
			$addedClearances = new CMS_stack();
			foreach($newClearance as $clearance => $clearanceValue) {
				$addedClearances->add($clearance, $clearanceValue);
			}
			return $addedClearances;
		} elseif($stack1->getValuesByAtom() == 1 && $stack2->getValuesByAtom() == 1) {
			//create arrays from clearances stacks (easier to manage)
			$stack1Clearance = array();
			foreach($stack1->getElements() as $clearanre) {
				$stack1Clearance[$clearanre[0]] = $clearanre[0];
			}
			$stack2Clearance = array();
			foreach($stack2->getElements() as $clearanre) {
				$stack2Clearance[$clearanre[0]] = $clearanre[0];
			}
			//then add both together
			$newClearance = array_unique(array_merge($stack1Clearance, $stack2Clearance));
			//set CMS_stack with new pages clearance
			$addedClearances = new CMS_stack();
			$addedClearances->setValuesByAtom(1); // Assume 1 atom
			foreach($newClearance as $clearance) {
				$addedClearances->add($clearance);
			}
			return $addedClearances;
		} else {
			$this->raiseError('Can\'t add stack objects without the same value by atom number ...');
			return false;
		}
	}
	
	// Module categories clearances
	// If too many methods comes here uses public attribute 
	// or inheritance awaiting for interfaces
	
	/**
	  * Gets clearances on modules categories
	  *
	  * @return CMS_moduleCategoriesClearances
	  * @access public
	  */
	function &getModuleCategoriesClearances()
	{
		return $this->_moduleCategoriesClearances;
	}
	
	/**
	  * Sets clearances on modules categories
	  *
	  * @param CMS_moduleCategoriesClearances $clearances, clearances to set
	  * @return boolean true on success
	  * @access public
	  */
	function setModuleCategoriesClearances($clearances)
	{
		if (is_a($clearances, "CMS_moduleCategoriesClearances")) {
			$this->_moduleCategoriesClearances = $clearances;
			return true;
		} else {
			$this->raiseError("CMS_moduleCategoriesClearances object expected");
			return false;
		}
	}
	
	/**
	  * Gets modules categories clarances as a stack
	  *
	  * @param string $moduleCodename, the module to get categories related to
	  * @return CMS_moduleCategoriesClearances
	  * @access public
	  */
	function getModuleCategoriesClearancesStack($moduleCodename = false)
	{
		return $this->_moduleCategoriesClearances->getCategoriesClearances($moduleCodename);
	}
	
	/**
	  * Sets modules categories clearances from a stack
	  *
	  * @param CMS_stack $clearances, clearances to set
	  * @return boolean true on success
	  * @access public
	  */
	function setModuleCategoriesClearancesStack($clearances)
	{
		if (is_a($clearances, "CMS_stack")) {
			$this->_moduleCategoriesClearances->setCategoriesClearances($clearances);
		} else {
			$this->raiseError("CMS_stack object expected");
			return false;
		}
	}
	
	/**
	  * Sets modules categories clearances from a stack
	  *
	  * @param CMS_stack $clearances, clearances to set
	  * @return boolean true on success
	  * @access public
	  */
	function addModuleCategoriesClearancesStack($clearances)
	{
		if (!is_a($clearances, "CMS_stack")) {
			$this->raiseError('CMS_stack object expected');
			return false;
		}
		if ($catClearance = $this->_addStackClearances($clearances, $this->_moduleCategoriesClearances->getCategoriesClearances())) {
			$this->_moduleCategoriesClearances->setCategoriesClearances($catClearance);
		} else {
			$this->raiseError('Can\'t add clearances stacks');
			return false;
		}
		return true;
	}
	
	/**
	  * Delete all category clearances for profile
	  * 
	  * @return boolean true on success
	  * @access public
	  */
	function deleteCategoriesClearances()
	{
		if ($this->_moduleCategoriesClearances->deleteCategoriesClearances()) {
			return true;
		} else {
			$this->raiseError("Can't delete categories clearance");
			return false;
		}
	}
	
	/**
	  * Get all the moduleCategories (used as root) which have a level 
	  * upper or equal to CLEARANCE_MODULE_EDIT
	  *
	  * @param string $module, the codename of the module we want root categories from
	  * @param integer $clearance, clearance level categories equals to (Default set to false)
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootModuleCategories($module = false, $return_objects = false)
	{
		return $this->getRootCategories(false, $module, $return_objects);
	}
	
	/**
	  * Get all the categories (used as root) which have a level 
	  * equal to clearance given (@see CMS_profile, constants CLEARANCE_MODULE_* )
	  *
	  * @param integer $clearance, clearance level categories equals to (Default set to false : returns all categories)
	  * @param string $module, the module codename we want root categories of
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @param boolean $strict, if set to true method strictly check clearance (default : true)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootCategories($clearance = false, $module = false, $return_objects = false, $strict = true) {
		static $rootCategories;
		$mode = 'mode_'.(string)$this->_id.'_'.($clearance === false ? 'false' : (string)$clearance).'_'.(string)$module.'_'.(string)$strict;
		if (!isset($rootCategories[$mode])) {
			$rootCategories[$mode] = array();
			if (SensitiveIO::isPositiveInteger($this->_id)) {
				// Take only categories from given module
				$stack_categoriesClearances = $this->_moduleCategoriesClearances->getCategoriesClearances($module);
			}
			$elements = $stack_categoriesClearances->getElements();
			if (is_array($elements) && $elements) {
				$items = array();
				while (list($k, $v) = each($elements)) {
					$categoryID = $v[0];
					$categoryClearance = $v[1];
					if ($categoryID && (
						($clearance !== false && $strict && (int) $categoryClearance === (int) $clearance) ||
						($clearance !== false && !$strict && (int) $categoryClearance >= (int) $clearance) ||
						($clearance === false)
						)) {
						$rootCategories[$mode][] = (int) $categoryID;
					}
				}
				$rootCategories[$mode] = @array_unique($rootCategories[$mode]);
			} else {
				$rootCategories[$mode] = false;
			}
		}
		if ($rootCategories[$mode] === false) {
			return false;
		} else {
			if ($return_objects) {
				$items = array();
				if (is_array($rootCategories[$mode]) && $rootCategories[$mode]) {
					foreach ($rootCategories[$mode] as $categoryID) {
						$items[] = CMS_moduleCategories_catalog::getByID($categoryID);
					}
				}
				return $items;
			} else {
				return $rootCategories[$mode];
			}
		}
	}
	
	/**
	  * Get all the categories  (used as root) which have a level 
	  * equal to CLEARANCE_MODULE_NONE and add deleted categories
	  *
	  * @param string $module, the codename of the module we want root categories from
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootModuleCategoriesDenied($module = false, $return_objects = false)
	{
		$categories = $this->getRootCategories(CLEARANCE_MODULE_NONE, $module, $return_objects);
		$categories = (is_array($categories)) ? array_merge(CMS_moduleCategories_catalog::getDeletedCategories($module, $return_objects),$categories) : CMS_moduleCategories_catalog::getDeletedCategories($module, $return_objects);
		$categories = array_unique($categories);
		return $categories;
	}
	
	/**
	  * Get all the categories  (used as root) which have a level 
	  * equal to CLEARANCE_MODULE_VIEW
	  *
	  * @param string $module, the codename of the module we want root categories from
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootModuleCategoriesReadable($module = false, $return_objects = false)
	{
		$items = $this->getRootCategories(CLEARANCE_MODULE_VIEW, $module, $return_objects, false);
		if (is_array($items) && $items) {
			return $items;
		}
		return false;
	}
	
	/**
	  * Get all the categories  (used as root) which have a level 
	  * equal to CLEARANCE_MODULE_EDIT
	  *
	  * @param string $module, the codename of the module we want root categories from
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootModuleCategoriesWritable($module = false, $return_objects = false)
	{
		$items = $this->getRootCategories(CLEARANCE_MODULE_EDIT, $module, $return_objects, false);
		if (is_array($items) && $items) {
			return $items;
		}
		return false;
	}
	
	/**
	  * Get all the categories  (used as root) which have a level 
	  * equal to CLEARANCE_MODULE_MANAGE
	  *
	  * @param string $module, the codename of the module we want root categories from
	  * @param boolean $return_objects, if set to true method will return an array of CMS_moduleCategory (Default set to false)
	  * @return array(integer or CMS_moduleCategory), false if nothing founded
	  * @access public
	  */
	function getRootModuleCategoriesManagable($module = false, $return_objects = false)
	{
		$items = $this->getRootCategories(CLEARANCE_MODULE_MANAGE, $module, $return_objects, false);
		if (is_array($items) && $items) {
			return $items;
		}
		return false;
	}
	
	/**
	  * Has module category clearance
	  *
	  * @param integer $category_id, ID of category we test
	  * @param integer $clearance, default is CLEARANCE_MODULE_VIEW
	  * @param string $module : the module codename
	  * @return boolean
	  * @access public
	  */
	function hasModuleCategoryClearance($category_id, $clearance = CLEARANCE_MODULE_VIEW, $module = false)
	{
		if (!SensitiveIO::isPositiveInteger($category_id)) {
			return false;
		}
		//get denied cats (including deleted cats)
		$cats_denied = $this->getRootModuleCategoriesDenied($module);
		if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			if (in_array($category_id, $cats_denied)) {
				return false;
			}
			return true;
		}
		$a_category_lineage = CMS_moduleCategories_catalog::getLineageOfCategory($category_id);
		$a_category_lineage = array_reverse ($a_category_lineage);
		switch($clearance) {
		case CLEARANCE_MODULE_VIEW:
			$matching_cats = $this->getRootModuleCategoriesReadable($module);
			break;
		case CLEARANCE_MODULE_EDIT:
			$cats_denied = array_merge($cats_denied, $this->getRootModuleCategoriesReadable($module));
			$matching_cats = $this->getRootModuleCategoriesWritable($module);
			break;
		case CLEARANCE_MODULE_MANAGE:
			$cats_denied = array_merge($cats_denied, $this->getRootModuleCategoriesReadable($module));
			$cats_denied = array_merge($cats_denied, $this->getRootModuleCategoriesWritable($module));
			$matching_cats = $this->getRootModuleCategoriesManagable($module);
			break;
		}
		foreach ($a_category_lineage as $aCat) {
			if (is_array($matching_cats) && in_array($aCat, $matching_cats)) {
				return true;
			} elseif (in_array($aCat, $cats_denied)) {
				return false;
			}
		}
		//no match founded so we return false for security
		return false;
	}
	
	/**
	  * filter array of categories ID with user clearance
	  *
	  * @param array $categories, IDs of categories to filter
	  * @param integer $clearance, default is CLEARANCE_MODULE_VIEW
	  * @param string $module : the module codename
	  * @param boolean $strict : strict filtering of categories : do not allow parent categories of lower levels
	  * @return array
	  * @access public
	  */
	function filterModuleCategoriesClearance($categories, $clearance = CLEARANCE_MODULE_VIEW, $module = false, $strict = false)
	{
		if (!is_array($categories)) {
			return array();
		}
		$filteredCategories = array();
		//get denied cats (including deleted cats)
		$deniedCats = $this->getRootModuleCategoriesDenied($module);
		if (!is_array($deniedCats)) {
			$deniedCats = array();
		}
		if (!$strict) {
			switch($clearance) {
				case CLEARANCE_MODULE_VIEW:
					$matchingCats = $this->getRootModuleCategoriesReadable($module);
				break;
				case CLEARANCE_MODULE_EDIT:
					$matchingCats = $this->getRootModuleCategoriesWritable($module);
				break;
				case CLEARANCE_MODULE_MANAGE:
					$matchingCats = $this->getRootModuleCategoriesManagable($module);
				break;
			}
			if (!is_array($matchingCats)) {
				$matchingCats = array();
			}
			if ($this->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				//only remove catsDenied
				foreach ($deniedCats as $deniedCatID) {
					unset($categories[$deniedCatID]);
				}
				return $categories;
			}
			//construct n level tree with all of these categories and array of lineages
			foreach($categories as $catID) {
				//get category lineage
				$lineage = CMS_moduleCategories_catalog::getLineageOfCategoryAsString($catID);
				$lineageArray[$catID] = $lineage;
				//then create n level table
				$ln = sensitiveIO::sanitizeExecCommand('if (!isset($nLevelArray['.str_replace(';','][',$lineage).'])) $nLevelArray['.str_replace(';','][',$lineage).'] =  array();');
				eval($ln);
			}
			$filteredCategories = $this->_filterModuleCategoriesClearanceRecursion($nLevelArray, $matchingCats, $deniedCats, false);
			$returnedFilteredCategories = array();
			foreach ($filteredCategories as $catID) {
				$returnedFilteredCategories[$catID] = $catID;
			}
		} else {
			$returnedFilteredCategories = array();
			foreach($categories as $catID) {
				if (!in_array($catID, $deniedCats) && $this->hasModuleCategoryClearance($catID, $clearance, $module)) {
					$returnedFilteredCategories[$catID] = $catID;
				}
			}
		}
		return $returnedFilteredCategories;
	}
	protected function _filterModuleCategoriesClearanceRecursion($nLevelArray, &$matchingCats, &$deniedCats, $fatherRights) {
		$returnedMatchingCats = array();
		foreach ($nLevelArray as $catID => $subCats) {
			if (in_array($catID, $matchingCats)) {
				$catRights = true;
			} elseif (in_array($catID, $deniedCats)) {
				$catRights = false;
			} else {
				$catRights = $fatherRights;
			}
			if (is_array($subCats) && $subCats) {
				$returnedMatchingSubCats = $this->_filterModuleCategoriesClearanceRecursion($subCats, $matchingCats, $deniedCats, $catRights);
				$returnedMatchingCats = array_merge($returnedMatchingCats, $returnedMatchingSubCats);
			} else {
				$returnedMatchingSubCats = array();
			}
			if ($catRights || (is_array($returnedMatchingSubCats) && $returnedMatchingSubCats)) {
				$returnedMatchingCats[] = $catID;
			}
		}
		return $returnedMatchingCats;
	}
	
	/**
	  * Returns array with translation key values for all admin clearance constants
	  *
	  * @return array(integer=>integer)
	  * @access public static getAllClearances
	  */
	function getAllAdminClearances()
	{
		return array(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL 	=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL,	'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDITVALIDATEALL_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_REGENERATEPAGES 	=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES,	'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_REGENERATEPAGES_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_TEMPLATES 		=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES, 	 	'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_TEMPLATES_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES 	=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES, 	'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_VIEWLOG 			=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG, 		'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_VIEWLOG_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_EDITUSERS 		=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS, 	 	'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_EDITUSERS_DESCRIPTION),
					 CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH	=> array('label' => self::MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH,'description' => self::MESSAGE_CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH_DESCRIPTION),
		);
	}
	
	/**
	  * Returns array with translation key values for all module level constants
	  *
	  * @return array(integer clearance => array('label' => integer, 'description' => integer))
	  * @access public static getAllModuleClearances
	  */
	function getAllModuleClearances() {
		return array(CLEARANCE_MODULE_NONE => array('label' => self::MESSAGE_CLEARANCE_MODULE_NONE,	'description' => self::MESSAGE_CLEARANCE_MODULE_NONE_DESCRIPTION),
					 CLEARANCE_MODULE_VIEW => array('label' => self::MESSAGE_CLEARANCE_MODULE_VIEW, 'description' => self::MESSAGE_CLEARANCE_MODULE_VIEW_DESCRIPTION),
					 CLEARANCE_MODULE_EDIT => array('label' => self::MESSAGE_CLEARANCE_MODULE_EDIT, 'description' => self::MESSAGE_CLEARANCE_MODULE_EDIT_DESCRIPTION),
		);
	}
	
	/**
	  * Returns array with translation key values for all module level constants
	  *
	  * @return array(integer=>integer)
	  * @access public static getAllModuleClearances
	  */
	function getAllModuleCategoriesClearances()
	{
		return array(self::MESSAGE_CLEARANCE_MODULE_CATEGORIES_NONE 	=> CLEARANCE_MODULE_NONE,
		             self::MESSAGE_CLEARANCE_MODULE_CATEGORIES_VIEW 	=> CLEARANCE_MODULE_VIEW,
					 self::MESSAGE_CLEARANCE_MODULE_CATEGORIES_EDIT 	=> CLEARANCE_MODULE_EDIT,
					 self::MESSAGE_CLEARANCE_MODULE_CATEGORIES_MANAGE	=> CLEARANCE_MODULE_MANAGE);
	}

	/**
	  * Returns array with translation key values for all clearance page
	  * level constants
	  *
	  * @return array(integer=>integer)
	  * @access public static getAllPageClearances
	  */
	function getAllPageClearances()
	{
		return array(self::MESSAGE_CLEARANCE_PAGE_NONE => CLEARANCE_PAGE_NONE,
					 self::MESSAGE_CLEARANCE_PAGE_VIEW => CLEARANCE_PAGE_VIEW, 
					 self::MESSAGE_CLEARANCE_PAGE_EDIT => CLEARANCE_PAGE_EDIT);
	}
	
	/**
	  * destroys the cmsprofile from persistence (MySQL for now).
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
					profiles
				where
					id_pr='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		unset($this);
	}
	
	/**
	  * Writes the cmsprofile into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			administrationClearance_pr='".SensitiveIO::sanitizeSQLString($this->_adminClearance)."',
			pageClearancesStack_pr='".SensitiveIO::sanitizeSQLString($this->_pageClearances->getTextDefinition())."',
			validationClearancesStack_pr='".SensitiveIO::sanitizeSQLString($this->_validationClearances->getTextDefinition())."',
			moduleClearancesStack_pr='".SensitiveIO::sanitizeSQLString($this->_moduleClearances->getTextDefinition())."',
			templateGroupsDeniedStack_pr='".SensitiveIO::sanitizeSQLString($this->_templateGroupsDenied->getTextDefinition())."',
			rowGroupsDeniedStack_pr='".SensitiveIO::sanitizeSQLString($this->_rowGroupsDenied->getTextDefinition())."'
		";
		if ($this->_id) {
			$sql = "
				update
					profiles
				set
					".$sql_fields."
				where
					id_pr='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					profiles
				set
					".$sql_fields;
		}
		//pr($sql);
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		if (!sensitiveIO::isPositiveInteger($this->_moduleCategoriesClearances->getProfileID())) {
			$this->_moduleCategoriesClearances->setProfileID($this->_id);
		}
		// Write moduleCategories clearances to persistence also
		return $this->_moduleCategoriesClearances->writeToPersistence();
	}
}
?>