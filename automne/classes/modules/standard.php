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
// $Id: standard.php,v 1.22 2010/03/08 16:43:31 sebastien Exp $

/**
  * Codename of the standard module
  */
define("MOD_STANDARD_CODENAME", "standard");

/**
  * Class CMS_module_standard
  *
  * represent the standard module.
  *
  * @package Automne
  * @subpackage standard
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_standard extends CMS_module
{
	/**
	  * Messages
	  */
	const MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE = 42;
	const MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE_OFPAGE = 43;
	const MESSAGE_MOD_STANDARD_VALIDATION_EDITION = 44;
	const MESSAGE_MOD_STANDARD_VALIDATION_EDITION_OFPAGE = 45;
	const MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER = 46;
	const MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER_OFPAGE = 47;
	
	const MESSAGE_MOD_STANDARD_VALIDATION_MOVE = 592;
	const MESSAGE_MOD_STANDARD_VALIDATION_MOVE_OFPAGE = 594;
	
	const MESSAGE_MOD_STANDARD_URL_PREVIZ = 48;
	const MESSAGE_MOD_STANDARD_URL_ONLINE = 49;
	const MESSAGE_MOD_STANDARD_URL_EDIT = 261;
	const MESSAGE_MOD_STANDARD_EMAIL_REMINDER_SUBJECT = 923;
	const MESSAGE_MOD_STANDARD_EMAIL_REMINDER_BODY = 924;
	const MESSAGE_MOD_STANDARD_EMAIL_REMINDER_BODY_MESSAGE = 925;
	const MESSAGE_MOD_STANDARD_PLUGIN = 1403;
	
	const MESSAGE_MOD_STANDARD_LINKTITLE = 133;
	const MESSAGE_MOD_STANDARD_CODENAME = 1675;
	const MESSAGE_MOD_STANDARD_ID = 863;
	const MESSAGE_MOD_STANDARD_TEMPLATE = 72;
	const MESSAGE_MOD_STANDARD_STATUS = 160;
	const MESSAGE_MOD_STANDARD_PAGE = 1328;
	
	const MESSAGE_PARAM_APPLICATION_LABEL = 599;
	const MESSAGE_PARAM_APPLICATION_MAINTAINER_EMAIL = 600;
	const MESSAGE_PARAM_APPLICATION_POSTMASTER_EMAIL = 601;
	const MESSAGE_PARAM_PAGE_LINK_NAME_IN_TREE = 602;
	const MESSAGE_PARAM_USE_PRINT_PAGES = 603;
	const MESSAGE_PARAM_OPEN_ZOOMIMAGE_IN_POPUP = 604;
	const MESSAGE_PARAM_SYSTEM_DEBUG = 605;
	const MESSAGE_PARAM_STATS_DEBUG = 606;
	const MESSAGE_PARAM_POLYMOD_DEBUG = 607;
	const MESSAGE_PARAM_VIEW_SQL = 608;
	const MESSAGE_PARAM_NO_APPLICATION_MAIL = 609;
	const MESSAGE_PARAM_NO_PAGES_EXTENDED_META_TAGS = 610;
	const MESSAGE_PARAM_APPLICATION_LDAP_AUTH = 611;
	const MESSAGE_PARAM_USE_BACKGROUND_REGENERATOR = 612;
	const MESSAGE_PARAM_ERROR404_EMAIL_ALERT = 613;
	const MESSAGE_PARAM_APPLICATION_ENFORCES_ACCESS_CONTROL = 614;
	const MESSAGE_PARAM_ALLOW_IMAGES_IN_WYSIWYG = 615;
	const MESSAGE_PARAM_LOG_SENDING_MAIL = 616;
	//const MESSAGE_PARAM_ALLOW_WYSIWYG_XHTML_VALIDATION = 1566;
	
	const MESSAGE_PARAM_APPLICATION_LABEL_DESC = 617;
	const MESSAGE_PARAM_APPLICATION_MAINTAINER_EMAIL_DESC = 618;
	const MESSAGE_PARAM_APPLICATION_POSTMASTER_EMAIL_DESC = 619;
	const MESSAGE_PARAM_PAGE_LINK_NAME_IN_TREE_DESC = 620;
	const MESSAGE_PARAM_USE_PRINT_PAGES_DESC = 621;
	const MESSAGE_PARAM_OPEN_ZOOMIMAGE_IN_POPUP_DESC = 622;
	const MESSAGE_PARAM_SYSTEM_DEBUG_DESC = 623;
	const MESSAGE_PARAM_STATS_DEBUG_DESC = 624;
	const MESSAGE_PARAM_POLYMOD_DEBUG_DESC = 625;
	const MESSAGE_PARAM_VIEW_SQL_DESC = 626;
	const MESSAGE_PARAM_NO_APPLICATION_MAIL_DESC = 627;
	const MESSAGE_PARAM_NO_PAGES_EXTENDED_META_TAGS_DESC = 628;
	const MESSAGE_PARAM_APPLICATION_LDAP_AUTH_DESC = 629;
	const MESSAGE_PARAM_USE_BACKGROUND_REGENERATOR_DESC = 630;
	const MESSAGE_PARAM_ERROR404_EMAIL_ALERT_DESC = 631;
	const MESSAGE_PARAM_APPLICATION_ENFORCES_ACCESS_CONTROL_DESC = 632;
	const MESSAGE_PARAM_ALLOW_IMAGES_IN_WYSIWYG_DESC = 633;
	const MESSAGE_PARAM_LOG_SENDING_MAIL_DESC = 634;
	//const MESSAGE_PARAM_ALLOW_WYSIWYG_XHTML_VALIDATION_DESC = 1567;
	
	const MESSAGE_PAGE_TAGS_CHOOSE = 1707;
	const MESSAGE_PAGE_ROW_EXPLANATION = 1219;
	const MESSAGE_PAGE_WORKING_TAGS = 1704;
	const MESSAGE_PAGE_WORKING_TAGS_EXPLANATION = 1703;
	const MESSAGE_PAGE_BLOCK_GENERAL_VARS = 1706;
	const MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION = 1705;
	const MESSAGE_PAGE_BLOCK_TAGS = 1708;
	const MESSAGE_PAGE_BLOCK_TAGS_EXPLANATION = 1219;
	const MESSAGE_PAGE_WORKING_STANDARD_TAGS = 1710;
	const MESSAGE_PAGE_WORKING_STANDARD_TAGS_EXPLANATION = 1709;
	const MESSAGE_PAGE_TEMPLATE_EXPLANATION = 1222;
	
	/**
	  * Gets the administration frontend path. No centralized admin for the standard module.
	  *
	  * @param integer $relativeTo Can be to webroot or filesystem. See constants.
	  * @return string The administration frontend path
	  * @access public
	  */
	function getAdminFrontendPath($relativeTo)
	{
		return false;
	}
	
	/**
	  * Gets resource by its internal ID (not the resource table DB ID)
	  *
	  * @param integer $resourceID The DB ID of the resource in the module table(s)
	  * @return CMS_resource The CMS_resource subclassed object
	  * @access public
	  */
	function getResourceByID($resourceID)
	{
		parent::getResourceByID($resourceID);
		return CMS_tree::getPageByID($resourceID);
	}
	
	/**
	  * Gets module ressource name method (method to get the name of resource objects of the module)
	  *
	  * @return string : the method name to get objects label
	  * @access public
	  */
	function getRessourceNameMethod() {
		return 'getTitle';
	}
	
	/**
	  * Gets module ressource type method (method to get the type of resource objects of the module)
	  *
	  * @return string : the method type to get objects type label
	  * @access public
	  */
	function getRessourceTypeLabelMethod() {
		return 'getTypeLabel';
	}
	
	/**
	  * Gets a tag representation instance
	  *
	  * @param CMS_XMLTag $tag The xml tag from which to build the representation
	  * @param array(mixed) $args The arguments needed to build
	  * @return object The module tag representation instance
	  * @access public
	  */
	function getTagRepresentation($tag, $args)
	{
		switch ($tag->getName()) {
		case "atm-clientspace":
			if ($args["template"] && $tag->getAttribute("id")) {
				$args["editedMode"] = (isset($args["editedMode"])) ? $args["editedMode"] : null;
				$instance = new CMS_moduleClientspace_standard($args["template"], $tag->getAttribute("id"), $args["editedMode"]);
				return $instance;
			} else {
				return false;
			}
			break;
		case "block":
			if ($tag->getAttribute("type")) {
				//try to guess the class to instanciate
				$class_name = "CMS_block_".$tag->getAttribute("type");
				if (class_exists($class_name)) {
					$instance = new $class_name();
				} else {
					//not found. Place here block types requiring special attention
					switch ($tag->getAttribute("type")) {
					default:
						$this->raiseError("Unknown block type : ".$tag->getAttribute("type"));
						return false;
						break;
					}
				}
				$instance->initializeFromTag($tag->getAttributes(), $tag->getInnerContent());
				return $instance;
			} else {
				return false;
			}
			break;
		}
	}
	
	/**
	  * Gets the module validations
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if none found
	  * @access public
	  */
	function getValidations($user)
	{
		if (!($user instanceof CMS_profile_user)) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		
		$all_validations = array();
		$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_LOCATION);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_CONTENT);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_SIBLINGSORDER);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_MOVE);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		if (!$all_validations) {
			return false;
		} else {
			return $all_validations;
		}
	}
	
	/**
	  * Gets the module validations info
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if none found
	  * @access public
	  */
	function getValidationsInfo($user)
	{
		if (!($user instanceof CMS_profile_user)) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		$all_validations = array();
		$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_LOCATION);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_CONTENT);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_SIBLINGSORDER);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_MOVE);
		if ($validations) {
			$all_validations = array_merge($all_validations, $validations);
		}
		
		if (!$all_validations) {
			return false;
		} else {
			return $all_validations;
		}
	}
	
	/**
	  * Gets a validation for a given page
	  *
	  * @param integer $pageID The page we want the validations for
	  * @param CMS_user $user The user we want the validations for
	  * @param integer $getEditionType The validation type we want.
	  *  by default function return RESOURCE_EDITION_LOCATION then RESOURCE_EDITION_CONTENT then RESOURCE_EDITION_SIBLINGSORDER
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if none found for the given user.
	  * @access public
	  */
	function getValidationByID($pageID, &$user, $getEditionType=false)
	{
		if (!($user instanceof CMS_profile_user)) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		if (!$getEditionType) {
			$getEditionType = RESOURCE_EDITION_LOCATION + RESOURCE_EDITION_CONTENT + RESOURCE_EDITION_SIBLINGSORDER + RESOURCE_EDITION_MOVE;
		}
		
		$sql = "
				select
					id_pag as id,
					location_rs as location,
					proposedFor_rs as proposedFor,
					validationsRefused_rs as validationsRefused,
					editions_rs as editions
				from
					pages,
					resources,
					resourceStatuses
				where
					id_pag = '".$pageID."'
					and resource_pag = id_res
					and status_res = id_rs
			";
		$q = new CMS_query($sql);
		if ($q->getNumRows() == 1) {
			$r = $q->getArray();
			$id = $r["id"];
			
			//search the type of edition
			
			//RESOURCE_EDITION_LOCATION
			if (($r["location"] == RESOURCE_LOCATION_USERSPACE
				&&	$r["proposedFor"] != 0
				&&	!($r["validationsRefused"] & RESOURCE_EDITION_LOCATION)) && ($getEditionType & RESOURCE_EDITION_LOCATION)) {
				
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					return false;
				}
				
				$language = $user->getLanguage();
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					return $validation;
				} else {
					return false;
				}
			
			//RESOURCE_EDITION_CONTENT || RESOURCE_EDITION_BASEDATA
			} elseif(($r["location"] == RESOURCE_LOCATION_USERSPACE
					&&	$r["proposedFor"] == 0
					&&	(
						   ($r["editions"] & RESOURCE_EDITION_CONTENT && !($r["validationsRefused"] & RESOURCE_EDITION_CONTENT))
						|| ($r["editions"] & RESOURCE_EDITION_BASEDATA && !($r["validationsRefused"] & RESOURCE_EDITION_BASEDATA))
						)
					) && ($getEditionType & RESOURCE_EDITION_CONTENT || $getEditionType & RESOURCE_EDITION_BASEDATA)) {
				
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					return false;
				}
				
				$language = $user->getLanguage();
				
				$editions = $r["editions"];//RESOURCE_EDITION_CONTENT + RESOURCE_EDITION_BASEDATA;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_EDITION));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_EDITION_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
                    //Back to edition location
                    $validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
                        PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
                    $validation->setEditorsStack($page->getEditorsStack());
					return $validation;
				} else {
					return false;
				}
			
			//RESOURCE_EDITION_SIBLINGSORDER
			} elseif (($r["location"] == RESOURCE_LOCATION_USERSPACE
					&&	$r["proposedFor"] == 0
					&&	$r["editions"] & RESOURCE_EDITION_SIBLINGSORDER
					&&	!($r["validationsRefused"] & RESOURCE_EDITION_SIBLINGSORDER)) && ($getEditionType & RESOURCE_EDITION_SIBLINGSORDER)) {
				
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					return false;
				}
				
				$language = $user->getLanguage();
				
				$editions = RESOURCE_EDITION_SIBLINGSORDER;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					return $validation;
				} else {
					return false;
				}
			
			//RESOURCE_EDITION_MOVE
			} elseif (($r["location"] == RESOURCE_LOCATION_USERSPACE
					&&	$r["proposedFor"] == 0
					&&	$r["editions"] & RESOURCE_EDITION_MOVE
					&&	!($r["validationsRefused"] & RESOURCE_EDITION_MOVE)) && ($getEditionType & RESOURCE_EDITION_MOVE)) {
				
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					return false;
				}
				
				$language = $user->getLanguage();
				
				$editions = RESOURCE_EDITION_MOVE;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_MOVE));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_MOVE_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					return $validation;
				} else {
					return false;
				}
			}
		} elseif ($q->getNumRows() ==0) {
			return false;
		} else {
			$this->raiseError("Can't have more than one page for a given ID");
			return false;
		}
	}
	
	/**
	  * Gets the module validations Info for the given editions and user
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @param integer $editions The editions we want the validations of
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if noen found
	  * @access public
	  */
	function getValidationsInfoByEditions(&$user, $editions)
	{
		$language = $user->getLanguage();
		$validations = array();
		if ($editions & RESOURCE_EDITION_LOCATION) {
			//Location change
			$sql = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs != 0
					and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
			";
			$q = new CMS_query($sql);
			while ($id = $q->getValue("id_pag")) {
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				//$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidationInfo($this->_codename, RESOURCE_EDITION_LOCATION, $id);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE));
					$validations[] = $validation;
				}
			}
		}
		
		if ($editions & RESOURCE_EDITION_CONTENT || $editions & RESOURCE_EDITION_BASEDATA) {
			//content and/or base data change
			$sql = "
				select
					id_pag,
					editions_rs,
					publication_rs
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and ((editions_rs & ".RESOURCE_EDITION_CONTENT."
							and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
						or (editions_rs & ".RESOURCE_EDITION_BASEDATA."
							and not (validationsRefused_rs & ".RESOURCE_EDITION_BASEDATA.")))
			";
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				//check if the page is not in draft only state. If it is, can't validate it
				if ($data['publication_rs'] == RESOURCE_PUBLICATION_NEVERVALIDATED) {
					$page = $this->getResourceByID($id);
					if ($page->isDraft()) {
						continue;
					}
				}
				
				$editions = RESOURCE_EDITION_CONTENT + RESOURCE_EDITION_BASEDATA;
				$validation = new CMS_resourceValidationInfo($this->_codename, $editions, $id);
				
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_EDITION));
					$validations[] = $validation;
				}
			}
		}
		if ($editions & RESOURCE_EDITION_SIBLINGSORDER) {
			//siblings order change
			$sql = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and editions_rs & ".RESOURCE_EDITION_SIBLINGSORDER."
					and not (validationsRefused_rs & ".RESOURCE_EDITION_SIBLINGSORDER.")
			";
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$editions = RESOURCE_EDITION_SIBLINGSORDER;
				
				//$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidationInfo($this->_codename, $editions, $id);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER));
					$validations[] = $validation;
				}
			}
		}
		
		if ($editions & RESOURCE_EDITION_MOVE) {
			//siblings order change
			$sql = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and editions_rs & ".RESOURCE_EDITION_MOVE."
					and not (validationsRefused_rs & ".RESOURCE_EDITION_MOVE.")
			";
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$editions = RESOURCE_EDITION_MOVE;
				
				$validation = new CMS_resourceValidationInfo($this->_codename, $editions, $id);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_MOVE));
					$validations[] = $validation;
				}
			}
		}
		
		return $validations;
	}
	
	/**
	  * Gets the module validations for the given editions and user
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @param integer $editions The editions we want the validations of
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if noen found
	  * @access public
	  */
	function getValidationsByEditions(&$user, $editions)
	{
		$language = $user->getLanguage();
		$validations = array();
		$nb_loc = $nb_cont = $nb_ord = '0';
		
		if ($editions & RESOURCE_EDITION_LOCATION) {
			//Location change
			$sql_loc = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs != 0
					and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
			";
			$q_loc = new CMS_query($sql_loc);
			$nb_loc = $q_loc->getNumRows();
		}
		
		if ($editions & RESOURCE_EDITION_CONTENT || $editions & RESOURCE_EDITION_BASEDATA) {
			//content and/or base data change
			$sql_cont = "
				select
					id_pag,
					editions_rs
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and ((editions_rs & ".RESOURCE_EDITION_CONTENT."
							and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
						or (editions_rs & ".RESOURCE_EDITION_BASEDATA."
							and not (validationsRefused_rs & ".RESOURCE_EDITION_BASEDATA.")))
			";
			$q_cont = new CMS_query($sql_cont);
			$nb_cont = $q_cont->getNumRows();
		}
		
		if ($editions & RESOURCE_EDITION_SIBLINGSORDER) {
			//siblings order change
			$sql_ord = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and editions_rs & ".RESOURCE_EDITION_SIBLINGSORDER."
					and not (validationsRefused_rs & ".RESOURCE_EDITION_SIBLINGSORDER.")
			";
			$q_ord = new CMS_query($sql_ord);
			$nb_ord = $q_ord->getNumRows();
		}
		
		if ($editions & RESOURCE_EDITION_MOVE) {
			//siblings order change
			$sql_mov = "
				select
					id_pag
				from
					pages,
					resources,
					resourceStatuses
				where
					resource_pag = id_res
					and status_res = id_rs
					and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
					and proposedFor_rs = 0
					and editions_rs & ".RESOURCE_EDITION_MOVE."
					and not (validationsRefused_rs & ".RESOURCE_EDITION_MOVE.")
			";
			$q_mov = new CMS_query($sql_mov);
			$nb_mov = $q_mov->getNumRows();
		}
		
		//Location change
		if ($nb_loc) {
			while ($id = $q_loc->getValue("id_pag")) {
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_LOCATIONCHANGE_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					$validations[] = $validation;
				}
			}
		}
		
		//content and/or base data change
		if ($nb_cont) {
			while ($data = $q_cont->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$editions = RESOURCE_EDITION_CONTENT + RESOURCE_EDITION_BASEDATA;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_EDITION));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_EDITION_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					$validations[] = $validation;
				}
			}
		}
		
		//siblings order change
		if ($nb_ord) {
			while ($data = $q_ord->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$editions = RESOURCE_EDITION_SIBLINGSORDER;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_SIBLINGSORDER_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					$validations[] = $validation;
				}
			}
		}
		
		//move change
		if ($nb_mov) {
			while ($data = $q_mov->getArray()) {
				$id = $data["id_pag"];
				//check if the page is editable by the user. If not, can't validate it
				if (!$user->hasPageClearance($id, CLEARANCE_PAGE_EDIT)) {
					continue;
				}
				
				$editions = RESOURCE_EDITION_MOVE;
				
				$page = $this->getResourceByID($id);
				$validation = new CMS_resourceValidation($this->_codename, $editions, $page);
				if (!$validation->hasError()) {
					$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_MOVE));
					$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_STANDARD_VALIDATION_MOVE_OFPAGE)." ".$page->getTitle());
					$validation->setValidationShortLabel($page->getTitle());
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_PREVIZ),
						PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$id);
					if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
						$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_ONLINE),
							$page->getURL());
					}
					//Back to edition location
					$validation->addHelpUrl($language->getMessage(self::MESSAGE_MOD_STANDARD_URL_EDIT), 
							PATH_ADMIN_WR.'/page-content.php?page='.$id, "_self", 'Automne.tabPanels.setActiveTab(\'edit\');Automne.utils.getPageById('. $id .');');
					$validation->setEditorsStack($page->getEditorsStack());
					$validations[] = $validation;
				}
			}
		}
		
		return $validations;
	}
	
	/**
	  * Process the module validations : here, calls the parent function but before :
	  * - Pass all the editors to remindedEditors
	  * - computes all the pages that got to be regenerated.
	  *
	  * @param CMS_resourceValidation $resourceValidation The resource validation to process
	  * @param integer $result The result of the validation process. See VALIDATION_OPTION constants
	  * @param boolean $lastValidation Is this the last validation done in a load of multiple validations (or the only one) ?
	  *        if true, launch the regeneration script.
	  * @return boolean true on success, false on failure to process
	  * @access public
	  */
	function processValidation($resourceValidation, $result, $lastValidation = true)
	{
		if (!($resourceValidation instanceof CMS_resourceValidation)) {
			$this->raiseError("ResourceValidation is not a valid CMS_resourceValidation object");
			return false;
		}
		
		$editions = $resourceValidation->getEditions();
		$page = $resourceValidation->getResource();
		$publication_before = $page->getPublication();
		$location_before = $page->getLocation();
		
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('module' => MOD_STANDARD_CODENAME));
		
		//Get the linked pages (it will be too late after parent processing if pages move outside USERSPACE
		
		//first add the page to regen
		$regen_pages = array();
		if ($result == VALIDATION_OPTION_ACCEPT) {
			//2.1. If editions contains SIBLINGSORDER, all pages monitoring this one for father changes should regen
			if ($editions & RESOURCE_EDITION_SIBLINGSORDER || $editions & RESOURCE_EDITION_MOVE) {
				$temp_regen = CMS_linxesCatalog::getWatchers($page);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
			}
			
			//2.2. If editions contains BASEDATA, all pages linked with this one should regen, and all monitoring its father
			if (($editions & RESOURCE_EDITION_BASEDATA) || ($editions & RESOURCE_EDITION_LOCATION)) {
				$temp_regen = CMS_linxesCatalog::getLinkers($page);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
				$father = CMS_tree::getFather($page);
				if ($father) {
					$temp_regen = CMS_linxesCatalog::getWatchers($father);
					if ($temp_regen) {
						$regen_pages = array_merge($regen_pages, $temp_regen);
					}
				}
			}
			//2.3. If editions contains CONTENT, only the page should be regen
			if ($editions & RESOURCE_EDITION_CONTENT) {
				//do nothing, the page is already in the array
			}
			$regen_pages = array_unique($regen_pages);
		}

		//call the parent function, but empty the reminded editors stack before
		if ($result == VALIDATION_OPTION_ACCEPT) {
			$stack = $page->getRemindedEditorsStack();
			$stack->emptyStack();
			$page->setRemindedEditorsStack($stack);
			$page->writeToPersistence();
		}
		if (!parent::processValidation($resourceValidation, $result)) {
			return false;
		}

		if ($result == VALIDATION_OPTION_REFUSE && ($editions & RESOURCE_EDITION_SIBLINGSORDER || $editions & RESOURCE_EDITION_MOVE)) {
			//validation was refused, move the page to it's original position
			if ($editions & RESOURCE_EDITION_SIBLINGSORDER) {
				//revert page order to the old one
				CMS_tree::revertSiblingsOrder($page);
			} elseif ($editions & RESOURCE_EDITION_MOVE) {
				//revert page move to the old position
				CMS_tree::revertPageMove($page);
			}
		}
		
		//if validation was not accepted, nothing more to do
		if ($result != VALIDATION_OPTION_ACCEPT) {
			return true;
		}
		
		//re-instanciate the page object that have changed
		$page = CMS_tree::getPageByID($resourceValidation->getResourceID());

		//page was moved out of userspace
		if ($editions & RESOURCE_EDITION_LOCATION) {
			if ($page->getLocation() != RESOURCE_LOCATION_USERSPACE && $location_before == RESOURCE_LOCATION_USERSPACE) {
				$page->deleteFiles();
				CMS_linxesCatalog::deleteLinxes($page, true);
				if ($publication_before != RESOURCE_PUBLICATION_NEVERVALIDATED) {
					CMS_tree::detachPageFromTree($page, true);
				}
				CMS_tree::detachPageFromTree($page, false);
				
				//can't regenerate the page now
				if ($key = array_search($page->getID(), $regen_pages)) {
					unset($regen_pages[$key]);
				}
			}
		} elseif (($editions & RESOURCE_EDITION_BASEDATA && $publication_before != RESOURCE_PUBLICATION_NEVERVALIDATED && $page->getPublication() != RESOURCE_PUBLICATION_PUBLIC && CMS_tree::isInPublicTree($page))) {
			//detach page if publication dates changed and page no longer published
			$page->deleteFiles();
			CMS_linxesCatalog::deleteLinxes($page, true);
			CMS_tree::detachPageFromTree($page, true);
			
			//can't regenerate the page now
			if ($key = array_search($page->getID(), $regen_pages)) {
				unset($regen_pages[$key]);
			}
		} else {
			//LINX_TREE RECORDS GENERATION
			//1. If the page has never been validated
			if ($publication_before == RESOURCE_PUBLICATION_NEVERVALIDATED) {
				//test the father's editions. If SIBLINGSORDER, only attach the page, else validate all of siblings orders
				$father = CMS_tree::getFather($page, true);
				$father_status = $father->getStatus();
				if ($father_status->getEditions() & RESOURCE_EDITION_SIBLINGSORDER || $editions & RESOURCE_EDITION_MOVE) {
					CMS_tree::attachPageToTree($page, $father, true);
				} else {
					CMS_tree::publishSiblingsOrder($father);
				}
			}
			//2. If the page has been validated, attach it to the public tree
			$grand_root = CMS_tree::getRoot();
			if ($page->getPublication() == RESOURCE_PUBLICATION_PUBLIC && $page->getID() != $grand_root->getID()) {
				$father = CMS_tree::getFather($page);
				if ($editions & RESOURCE_EDITION_MOVE) {
					//publish page move
					CMS_tree::publishPageMove($page);
					//regenerate all pages which link moved page
					$temp_regen = CMS_linxesCatalog::getLinkers($page);
					if ($temp_regen) {
						$regen_pages = array_merge($regen_pages, $temp_regen);
					}
					//and regenerate all page who watch new father page
					$temp_regen = CMS_linxesCatalog::getWatchers($father);
					if ($temp_regen) {
						$regen_pages = array_merge($regen_pages, $temp_regen);
					}
				} else {
					CMS_tree::attachPageToTree($page, $father, true);
				}
			}
			
			//PAGE REGENERATION
			//3. the page itself (fromscratch needed).
			$launchRegnerator = ($lastValidation && !$regen_pages) ? true:false;
			CMS_tree::submitToRegenerator($page->getID(), true, $launchRegnerator);
		}
		$regen_pages = array_unique($regen_pages);
		//2. the linked pages
		CMS_tree::submitToRegenerator($regen_pages, false,!$lastValidation);
		
		return true;
	}
	
	/**
	  * Process the daily routine, which typically put out of userspace resources which have a past publication date
	  *
	  * @return void
	  * @access public
	  */
	function processDailyRoutine()
	{
		//see if the action was done today
		$sql = "
			select
				1
			from
				actionsTimestamps
			where
				to_days(date_at) = to_days(now())
				and type_at='DAILY_ROUTINE'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return;
		}
		
		CMS_module_standard::_dailyRoutineUnpublish();
		CMS_module_standard::_dailyRoutinePublish();
		CMS_module_standard::_dailyRoutineReminders();
		CMS_module_standard::_dailyRoutineOptimize();
		CMS_module_standard::_dailyRoutineClean();
		//update the timestamp
		$sql = "
			delete from
				actionsTimestamps
			where
				type_at='DAILY_ROUTINE'
		";
		$q = new CMS_query($sql);
		
		$sql = "
			insert into
				actionsTimestamps
			set
				type_at='DAILY_ROUTINE',
				date_at=now()
		";
		$q = new CMS_query($sql);
	}
	
	/**
	  * Process the daily routine publication part : publish page that needs to be
	  *
	  * @return void
	  * @access private
	  */
	protected function _dailyRoutinePublish()
	{
		$today = new CMS_date();
		$today->setNow();
		
		//process all pages that have to be published
		$sql = "
			select
				id_pag
			from
				pages,
				resources,
				resourceStatuses
			where
				resource_pag=id_res
				and status_res=id_rs
				and location_rs='".RESOURCE_LOCATION_USERSPACE."'
				and publication_rs='".RESOURCE_PUBLICATION_VALIDATED."'
				and	publicationDateStart_rs <= '".$today->getDBValue(true)."'
				and (publicationDateEnd_rs >= '".$today->getDBValue(true)."' or publicationDateEnd_rs = '0000-00-00')
		";
		
		$q = new CMS_query($sql);
		$published = array();
		while ($id = $q->getValue("id_pag")) {
			$published[] = $id;
		}
		
		$regen_pages = array();
		foreach ($published as $page_id) {
			$page = CMS_tree::getPageByID($page_id);
			
			//apply changes on the page
			$father = CMS_tree::getAncestor($page, 1);
			CMS_tree::attachPageToTree($page, $father, true);
			CMS_tree::submitToRegenerator($page->getID(), true);
			
			//calculate the pages to regenerate
			$temp_regen = CMS_linxesCatalog::getLinkers($page);
			if ($temp_regen) {
				$regen_pages = array_merge($regen_pages, $temp_regen);
			}
			$father = CMS_tree::getAncestor($page, 1);
			if ($father) {
				$temp_regen = CMS_linxesCatalog::getWatchers($father);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
			}
		}
		
		//regenerate the pages that needs to be, but first pull off the array the ids of the unpublished pages
		$regen_pages = array_unique(array_diff($regen_pages, $published));
		
		CMS_tree::submitToRegenerator($regen_pages, true);
	}
	
	/**
	  * Process the daily routine unpublication part : unpublish page that needs to be
	  *
	  * @return void
	  * @access private
	  */
	protected function _dailyRoutineUnpublish()
	{
		$today = new CMS_date();
		$today->setNow();
		
		//process all pages that are to be unpublished
		$sql = "
			select
				id_pag
			from
				pages,
				resources,
				resourceStatuses
			where
				resource_pag=id_res
				and status_res=id_rs
				and location_rs='".RESOURCE_LOCATION_USERSPACE."'
				and publication_rs='".RESOURCE_PUBLICATION_PUBLIC."'
				and	(publicationDateStart_rs > '".$today->getDBValue(true)."'
					or (publicationDateEnd_rs < '".$today->getDBValue(true)."' and publicationDateEnd_rs!='0000-00-00'))
		";
		
		$q = new CMS_query($sql);
		$unpublished = array();
		while ($id = $q->getValue("id_pag")) {
			$unpublished[] = $id;
		}
		
		$regen_pages = array();
		foreach ($unpublished as $page_id) {
			$page = CMS_tree::getPageByID($page_id);
			
			//calculate the pages to regenerate
			$temp_regen = CMS_linxesCatalog::getLinkers($page);
			if ($temp_regen) {
				$regen_pages = array_merge($regen_pages, $temp_regen);
			}
		
			$father = CMS_tree::getAncestor($page, 1);
			if ($father) {
				$temp_regen = CMS_linxesCatalog::getWatchers($father);
				if ($temp_regen) {
					$regen_pages = array_merge($regen_pages, $temp_regen);
				}
			}
			
			//apply changes on the page
			$page->deleteFiles();
			CMS_linxesCatalog::deleteLinxes($page, true);
			CMS_tree::detachPageFromTree($page, true);
		}
		
		//regenerate the pages that needs to be, but first pull off the array the ids of the unpublished pages
		$regen_pages = array_unique(array_diff($regen_pages, $unpublished));
		
		CMS_tree::submitToRegenerator($regen_pages, false);
	}
	
	/**
	  * Process the daily routine reminders part : send reminders to users
	  *
	  * @return void
	  * @access private
	  */
	protected function _dailyRoutineReminders()
	{
		$today = new CMS_date();
		$today->setNow();
		
		$sql = "
			SELECT  
				id_pag,
				remindedEditorsStack_pag,
				reminderOnMessage_pbd 
			FROM 
				pages, pagesBaseData_public
			WHERE 
				page_pbd = id_pag 
				AND (
					(lastReminder_pag < reminderOn_pbd
					AND
					'".$today->getDBValue()."' >= reminderOn_pbd)
					OR (
						(to_days('".$today->getDBValue()."') - to_days(lastReminder_pag))  >= reminderPeriodicity_pbd
						AND
						reminderPeriodicity_pbd != '0'
					)
				)
		";
		
		$q = new CMS_query($sql);
		$reminders = array();
		while ($data = $q->getArray()) {
			$reminders[] = $data;
		}
		
		//send the emails
		foreach ($reminders as $reminder) {
			//instanciate page and update its lastReminder vars
			$page = CMS_tree::getPageByID($reminder["id_pag"]);
			$page->touchLastReminder();
			$page->writeToPersistence();
			
			//build users array
			$users_stack = new CMS_stack();
			$users_stack->setTextDefinition($reminder["remindedEditorsStack_pag"]);
			$users_stack_elements = $users_stack->getElements();
			$users = array();
			foreach ($users_stack_elements as $element) {
				$usr = CMS_profile_usersCatalog::getByID($element[0]);
				if ($usr instanceof CMS_profile_user) {
					$users[$element[0]] = $usr;
				}
			}
			if (!$users) {
				continue;
			}
			//prepare emails and send them
			$group_email = new CMS_emailsCatalog();
			$languages = CMS_languagesCatalog::getAllLanguages();
			$subjects = array();
			$bodies = array();
			foreach ($languages as $language) {
				$subjects[$language->getCode()] = $language->getMessage(self::MESSAGE_MOD_STANDARD_EMAIL_REMINDER_SUBJECT);
				$bodies[$language->getCode()] = $language->getMessage(self::MESSAGE_MOD_STANDARD_EMAIL_REMINDER_BODY, array($page->getTitle()." (ID : ".$page->getID().")"))
						."\n".$language->getMessage(self::MESSAGE_MOD_STANDARD_EMAIL_REMINDER_BODY_MESSAGE, array($reminder["reminderOnMessage_pbd"]));
			}
			$group_email->setUserMessages($users, $bodies, $subjects, ALERT_LEVEL_PAGE_ALERTS, MOD_STANDARD_CODENAME);
			$group_email->sendMessages();
		}
	}
	
	/**
	  * Process the daily routine optimisation part : optimize SQL tables
	  *
	  * @return void
	  * @access private
	  */
	protected function _dailyRoutineOptimize() {
		$sql = "show tables";
		$q = new CMS_query($sql);
		$tables = array();
		while ($table = $q->getValue(0)) {
			$tables[] = $table;
		}
		if (is_array($tables) && $tables) {
			$sql = "optimize table
				".implode(', ',$tables)."
			";
			$q = new CMS_query($sql);
		}
	}
	
	/**
	  * Process the daily routine clean part : remove useless files
	  *
	  * @return void
	  * @access private
	  */
	protected function _dailyRoutineClean() {
		//clean all files older than 4h in both uploads directories
		$yesterday = time() - 14400; //4h
		try{
			foreach ( new DirectoryIterator(PATH_UPLOAD_FS) as $file) {
				if ($file->isFile() && $file->getFilename() != ".htaccess" && $file->getMTime() < $yesterday) {
					@unlink($file->getPathname());
				}
			}
		} catch(Exception $e) {}
		try{
			foreach ( new DirectoryIterator(PATH_UPLOAD_VAULT_FS) as $file) {
				if ($file->isFile() && $file->getFilename() != ".htaccess" && $file->getMTime() < $yesterday) {
					@unlink($file->getPathname());
				}
			}
		} catch(Exception $e) {}
		//clean all files older than 30 days in cache directory
		$month = time() - 2592000; //30 days
		try{
			foreach ( new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_CACHE_FS), RecursiveIteratorIterator::SELF_FIRST) as $file) {
				if ($file->isFile() && $file->getFilename() != ".htaccess" && $file->getMTime() < $month) {
					@unlink($file->getPathname());
				}
			}
		} catch(Exception $e) {}
		//clean tmp dir
		try{
			//files first
			foreach ( new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_TMP_FS), RecursiveIteratorIterator::SELF_FIRST) as $file) {
				if ($file->isFile()) @unlink($file->getPathname());
			}
			//then directories
			foreach ( new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_TMP_FS), RecursiveIteratorIterator::SELF_FIRST) as $file) {
				if ($file->isDir()) @rmdir($file->getPathname());
			}
		} catch(Exception $e) {}
		//rotate error log file
		try{
			$source = PATH_MAIN_FS.'/'.CMS_grandFather::ERROR_LOG;
			$dest = PATH_LOGS_FS.'/'.CMS_grandFather::ERROR_LOG.'-'.date('Y-m-d').'.gz';
			if (is_file($source) && !is_file($dest) && CMS_file::gzipfile($source, $dest, 3)) {
				//erase error log file
				@unlink($source);
			}
		} catch(Exception $e) {}
	}
	
	/**
	  * Changes The page data (in the DB) from one location to another.
	  *
	  * @param CMS_page $resource The resource concerned by the data location change
	  * @param string $locationFrom The starting location among "edited", "edition", "public", "archived", "deleted"
	  * @param string $locationTo The ending location among "edited", "edition", "public", "archived", "deleted"
	  * @param boolean $copyOnly If true, data is not deleted from the original location
	  * @return void
	  * @access private
	  */
	function _changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly = false) {
		if (!parent::_changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly)) {
			return false;
		}
		
		// Move the client spaces
		$tpl = $resource->getTemplate();
		if (($tpl instanceof CMS_pageTemplate) && $tpl->getID() > 0) {
			CMS_moduleClientspace_standard_catalog::moveClientSpaces($tpl->getID(), $locationFrom, $locationTo, $copyOnly);
		} else {
			CMS_grandFather::raiseError("Bad template founded for page ".$resourceID);
			return false;
		}
		// Move the blocks
		CMS_blocksCatalog::moveBlocks($resource, $locationFrom, $locationTo, $copyOnly);
		
		// Move data to the new location (delete data there before)
		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
			$sql = "
				delete from
					pagesBaseData_".$locationTo."
				where
					page_pbd='".$resource->getID()."';
			";
			$q = new CMS_query($sql);
			
			//here we have a bug with insert into... so try with a replace
			$sql = "
				replace into
					pagesBaseData_".$locationTo."
					select
						*
					from
						pagesBaseData_".$locationFrom."
					where
						page_pbd='".$resource->getID()."'
			";
			$q = new CMS_query($sql);
		}

		if (!$copyOnly) {
			$sql = "
				delete from
					pagesBaseData_".$locationFrom."
				where
					page_pbd='".$resource->getID()."'
			";
			$q = new CMS_query($sql);
		}
	}

	/**
	  * Supposed to destroy the module. Not possible.
	  *
	  * @return boolean false
	  * @access public
	  */
	function destroy()
	{
		return false;
	}
	
	/**
	  * This module can't be edited.
	  *
	  * @return boolean false
	  * @access public
	  */
	function writeToPersistence()
	{
		return false;
	}
	
	/** 
	  * Get the tags to be treated by this module for the specified treatment mode, visualization mode and object.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @return array of tags to be treated.
	  * @access public
	  */
	function getWantedTags($treatmentMode, $visualizationMode) 
	{
		$return = array();
		switch ($treatmentMode) {
			case MODULE_TREATMENT_CLIENTSPACE_TAGS :
				$return = array (
					"atm-clientspace" => array("selfClosed" => true, "parameters" => array()),
				);
			break;
			case MODULE_TREATMENT_BLOCK_TAGS :
				$return = array (
					"block" => array("selfClosed" => false, "parameters" => array("module"	=> MOD_STANDARD_CODENAME,
																				  "type"	=> "file|text|varchar|image|flash")),
					"row" => array("selfClosed" => false, "parameters" => array()),
				);
			break;
			case MODULE_TREATMENT_PAGEHEADER_TAGS :
				$return = array (
					"atm-keywords" 		=> array("selfClosed" => true, "parameters" => array()),
					"atm-description" 	=> array("selfClosed" => true, "parameters" => array()),
					"atm-meta-tags" 	=> array("selfClosed" => true, "parameters" => array()),
					"atm-css-tags" 		=> array("selfClosed" => true, "parameters" => array()),
					"atm-js-tags" 		=> array("selfClosed" => true, "parameters" => array()),
				);
			break;
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				$return = array (
					"atm-admin" 		=> array("selfClosed" => false, "parameters" => array(),	'class' => 'CMS_XMLTag_admin'),
					"atm-noadmin" 		=> array("selfClosed" => false, "parameters" => array(),	'class' => 'CMS_XMLTag_noadmin'),
					"atm-edit" 			=> array("selfClosed" => false, "parameters" => array(),	'class' => 'CMS_XMLTag_edit'),
					"atm-noedit" 		=> array("selfClosed" => false, "parameters" => array(),	'class' => 'CMS_XMLTag_noedit'),
					"atm-title" 		=> array("selfClosed" => true, "parameters" => array(),		'class' => 'CMS_XMLTag_title'),
					"atm-website" 		=> array("selfClosed" => true, "parameters" => array(),		'class' => 'CMS_XMLTag_website'),
					"atm-page" 			=> array("selfClosed" => true, "parameters" => array(),		'class' => 'CMS_XMLTag_page'),
					"atm-main-url" 		=> array("selfClosed" => true, "parameters" => array()),
					"atm-constant" 		=> array("selfClosed" => true, "parameters" => array()),
					"atm-last-update" 	=> array("selfClosed" => false, "parameters" => array()),
					"a"					=> array("selfClosed" => false, "parameters" => array('href' => '#([a-zA-Z0-9._{}:-]*)'),'class' => 'CMS_XMLTag_anchor'),
					"area"				=> array("selfClosed" => false, "parameters" => array('href' => '#([a-zA-Z0-9._{}:-]*)'),'class' => 'CMS_XMLTag_anchor'),
					"body" 				=> array("selfClosed" => false, "parameters" => array()),
					"head" 				=> array("selfClosed" => false, "parameters" => array()),
					"html" 				=> array("selfClosed" => false, "parameters" => array()),
				);
				//for public (and print) visualmode, this is done by MODULE_TREATMENT_LINXES_TAGS mode during page file linx treatment
				if ($visualizationMode != PAGE_VISUALMODE_HTML_PUBLIC) {
					$return['atm-linx'] = array("selfClosed" => false, "parameters" => array());
				}
				//for print visualmode, this tag is useless
				if ($visualizationMode != PAGE_VISUALMODE_PRINT) {
					$return['atm-print-link'] = array("selfClosed" => false, "parameters" => array());
				}
			break;
			case MODULE_TREATMENT_LINXES_TAGS:
				$return = array (
					"atm-linx" => array("selfClosed" => false, "parameters" => array()),
				);
			break;
			case MODULE_TREATMENT_WYSIWYG_INNER_TAGS :
				$return = array (
					"atm-linx" => array("selfClosed" => false, "parameters" => array()),
					"span" => array("selfClosed" => false, "parameters" => array('id' => MOD_STANDARD_CODENAME.'-(.*)-(.*)')),
				);
			break;
			case MODULE_TREATMENT_WYSIWYG_OUTER_TAGS :
				$return = array (
					"a"		=> array("selfClosed" => false, "parameters" => array()), //this definition handle both anchors and internal links 
					"area"	=> array("selfClosed" => false, "parameters" => array('href' => '#([a-zA-Z0-9._{}:-]*)'),'class' => 'CMS_XMLTag_anchor'),
				);
			break;
		}
		return $return;
	}
	
	/** 
	  * Treat given content tag by this module for the specified treatment mode, visualization mode and object.
	  *
	  * @param string $tag The CMS_XMLTag.
	  * @param string $tagContent previous tag content.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  * @return string the tag content treated.
	  * @access public
	  */
	function treatWantedTag(&$tag, $tagContent, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_BLOCK_TAGS:
				if (!($treatedObject instanceof CMS_row)) {
					$this->raiseError('$treatedObject must be a CMS_row object');
					return false;
				}
				if (!($treatmentParameters["page"] instanceof CMS_page)) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!($treatmentParameters["language"] instanceof CMS_language)) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				if (!($treatmentParameters["clientSpace"] instanceof CMS_moduleClientspace)) {
					$this->raiseError('$treatmentParameters["clientSpace"] must be a CMS_moduleClientspace object');
					return false;
				}
				if ($tag->getName() == 'row') {
					//replace {{pageID}} tag in all page content.
					return str_replace('{{pageID}}', $treatmentParameters["page"]->getID(), $tag->getInnerContent());
				} else {
					//create the block data
					$block = $tag->getRepresentationInstance();
					return $block->getData($treatmentParameters["language"], $treatmentParameters["page"], $treatmentParameters["clientSpace"], $treatedObject, $visualizationMode);
				}
			break;
			case MODULE_TREATMENT_CLIENTSPACE_TAGS:
				if (!($treatedObject instanceof CMS_pageTemplate)) {
					$this->raiseError('$treatedObject must be a CMS_pageTemplate object');
					return false;
				}
				if (!($treatmentParameters["page"] instanceof CMS_page)) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!($treatmentParameters["language"] instanceof CMS_language)) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				$args = array("template"=>$treatedObject->getID());
				if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM
					|| $visualizationMode == PAGE_VISUALMODE_HTML_EDITION
					|| $visualizationMode == PAGE_VISUALMODE_FORM) {
					$args["editedMode"] = true;
				}
				//load CS datas
				switch ($tag->getName()) {
					case 'atm-clientspace':
					default:
						$client_space = $tag->getRepresentationInstance($args);
						switch ($visualizationMode) {
							case PAGE_VISUALMODE_PRINT:
								$data = "";
								$clientSpacesData = array();
								$csTagID = $tag->getAttribute("id");
								$printingCS = $treatedObject->getPrintingClientSpaces();
								if (in_array($csTagID, $printingCS)) {
									$clientSpacesData[$csTagID] = $client_space->getData($treatmentParameters["language"], $treatmentParameters["page"], $visualizationMode, $treatedObject->hasPages());
								}
								foreach ($printingCS as $cs) {
									if (isset($clientSpacesData[$cs])) {
										$data .= $clientSpacesData[$cs]. '<br />';
									}
								}
								return $data;
							break;
							default:
								if (is_object($client_space)) {
									return $client_space->getData($treatmentParameters["language"], $treatmentParameters["page"], $visualizationMode, false);
								} else {
									return '';
								}
							break;
						}
					break;
				}
			break;
			case MODULE_TREATMENT_LINXES_TAGS:
				switch ($tag->getName()) {
					case "atm-linx":
						//linx are visible only if target pages are published (public tree)
						$linx_args = array("page"=> $treatedObject, "publicTree"=> true);
						$linx = $tag->getRepresentationInstance($linx_args);
						return $linx->getOutput(true);
					break;
				}
				return '';
			break;
			case MODULE_TREATMENT_PAGECONTENT_TAGS:
				if (!($treatedObject instanceof CMS_page)) {
					$this->raiseError('$treatedObject must be a CMS_page object');
					return false;
				}
				switch ($tag->getName()) {
					case "atm-linx":
						if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM || $visualizationMode == PAGE_VISUALMODE_FORM) {
							//direct linx are visible even if target pages are not published (edited tree)
							//all other linx are only visible if they are published (public tree)
							$linx_args = array("page"=> $treatedObject, "publicTree"=> !($tag->getAttribute('type') == 'direct' || !$tag->getAttribute('type')));
							$linx = $tag->getRepresentationInstance($linx_args);
							$linx->setDebug(false);
							$linx->setLog(false);
							return $linx->getOutput();
						} else
						//for public and print visualmode, this treatment is done by MODULE_TREATMENT_LINXES_TAGS mode during page file linx treatment
						if ($visualizationMode != PAGE_VISUALMODE_HTML_PUBLIC 
							&& $visualizationMode != PAGE_VISUALMODE_PRINT) {
							//linx are visible only if target pages are published (public tree)
							$linx_args = array("page"=> $treatedObject, "publicTree"=> true);
							$linx = $tag->getRepresentationInstance($linx_args);
							return $linx->getOutput();
						}
					break;
					case "atm-main-url":
						return CMS_websitesCatalog::getMainURL();
					break;
					case "atm-keywords":
						return '<meta name="keywords" content="'.SensitiveIO::sanitizeHTMLString($treatedObject->getKeywords($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC)).'" />';
					break;
					case "atm-description":
						return '<meta name="description" content="'.SensitiveIO::sanitizeHTMLString($treatedObject->getDescription($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC)).'" />';
					break;
					case "atm-last-update":
						$lastlog = CMS_log_catalog::getByResourceAction(MOD_STANDARD_CODENAME, $treatedObject->getID(), array(CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT, CMS_log::LOG_ACTION_RESOURCE_DIRECT_VALIDATION), 1);
						if (!$lastlog || !is_object($lastlog[0])) {
							return '';
						}
						$user = $lastlog[0]->getUser();
						$date = $lastlog[0]->getDateTime();
						$dateformat = ($tag->getAttribute("format")) ? $tag->getAttribute("format") : 'Y-m-d';
						$replace = array(
							'{{date}}' 		=> date($dateformat , $date->getTimestamp()),
							'{{firstname}}' => $user->getFirstName(),
							'{{lastname}}' 	=>  $user->getLastName(),
						);
						return str_replace(array_keys($replace), $replace, $tag->getInnerContent());
					break;
					case "atm-print-link":
						if ($treatedObject->getPrintStatus()) {
							$template = $tag->getInnerContent();
							if ($tag->getAttribute("keeprequest") == 'true') {
								return '<?php echo \''.str_replace("{{href}}", $treatedObject->getURL(true).'\'.($_SERVER["QUERY_STRING"] ? \'?\'.$_SERVER["QUERY_STRING"] : \'\').\'', str_replace("\\\\'", "\'", str_replace("'", "\'", $template))).'\' ?>';
							} else{
								return str_replace("{{href}}", $treatedObject->getURL(true), $template);
							}
						}
						return '';
					break;
					case "atm-constant":
						$const = SensitiveIO::stripPHPTags(io::strtoupper($tag->getAttribute("name")));
						if (defined($const)) {
							return constant($const);
						}
						return '';
					break;
					case "head":
						$headCode = '<?php'."\n".
						'$atmHost = @parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_HOST) ? @parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_HOST) : $_SERVER[\'HTTP_HOST\'];'."\n".
						'$atmProtocol = stripos($_SERVER["SERVER_PROTOCOL"], \'https\') !== false ? \'https://\' : \'http://\';'."\n".
						'$atmPort = @parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_PORT) ? \':\'.@parse_url($_SERVER[\'HTTP_HOST\'], PHP_URL_PORT) : \'\';'."\n".
						'echo "\t".\'<base href="\'.$atmProtocol.$atmHost.$atmPort.PATH_REALROOT_WR.\'/" />\'."\n";'."\n".
						' ?>';
						//Append base code
						return preg_replace('#<head([^>]*)>#', '<head\1>'."\n".$headCode, $tag->getContent());
					break;
					case "body":
						$statsCode = '<?php if (SYSTEM_DEBUG && STATS_DEBUG) {echo CMS_stats::view();} ?>';
						//Append stats code
						return preg_replace('#</body>$#', $statsCode."\n".'</body>', $tag->getContent());
					break;
					case "html":
						//Append DTD
						return '<?php if (defined(\'APPLICATION_XHTML_DTD\')) echo APPLICATION_XHTML_DTD."\n"; ?>'."\n".$tag->getContent();
					break;
				}
				return '';
			break;
			case MODULE_TREATMENT_PAGEHEADER_TAGS:
				if (!($treatedObject instanceof CMS_page)) {
					$this->raiseError('$treatedObject must be a CMS_page object');
					return false;
				}
				switch ($tag->getName()) {
					case "atm-js-tags":
					case "atm-css-tags":
						$usage = CMS_module::moduleUsage($treatedObject->getID(), $this->_codename);
						$tagFiles = $tag->getAttribute('files');
						$tagFiles = array_map('trim', explode(',', $tagFiles));
						//only if current page use a block of this module
						if ($tagFiles) {
							//save in global var the page ID who use this tag
							CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array($tag->getName() => true));
							$return = ''; //overwrite previous modules return to append files of this module
							//save new modules files
							switch ($tag->getName()) {
								case "atm-js-tags":
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-js-tags");
									$files = is_array($files) ? $files : array();
									
									//append module js files
									$files = array_merge($files, $tagFiles);
									//append CMS_function.js file
									if (!isset($usage['js-files']) && file_exists(PATH_JS_FS.'/CMS_functions.js')) {
										$file = str_replace(PATH_REALROOT_FS.'/', '', PATH_JS_FS.'/CMS_functions.js');
										$files = array_merge($files, array($file));
									}
									//append swfobject for block flash
									if (is_array($usage) && isset($usage['blockflash']) && $usage['blockflash'] == true) {
										$files[] = 'swfobject';
									}
									//save files
									CMS_module::moduleUsage($treatedObject->getID(), $tag->getName(), $files, true);
								break;
								case "atm-css-tags":
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags");
									$files = is_array($files) ? $files : array();
									$media = $tag->getAttribute('media') ? $tag->getAttribute('media') : 'all';
									//append module css files
									if (!isset($files[$media])) {
										$files[$media] = array();
									}
									$files[$media] = array_merge($files[$media], $tagFiles);
									//save files
									CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags", $files, true);
								break;
							}
							//Create return for all saved modules files
							switch ($tag->getName()) {
								case "atm-js-tags":
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-js-tags");
									$return .= '<?php echo CMS_view::getJavascript(array(\''.implode('\',\'', $files).'\')); ?>'."\n";
								break;
								case "atm-css-tags":
									$media = $tag->getAttribute('media') ? $tag->getAttribute('media') : 'all';
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags");
									if (isset($files[$media])) {
										$return .= '	<?php echo CMS_view::getCSS(array(\''.implode('\',\'', $files[$media]).'\'), \''.$media.'\'); ?>'."\n";
									}
								break;
							}
							return $return;
						}
					break;
					case "atm-meta-tags":
						$metaDatas = $treatedObject->getMetaTags($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC);
						$usage = CMS_module::moduleUsage($treatedObject->getID(), $this->_codename);
						//if page template already use atm-js-tags tag, no need to add JS again
						if (!is_array($usage) || !isset($usage['atm-js-tags'])) {
							$metaDatas .= '	<script type="text/javascript" src="'.PATH_REALROOT_WR.'/js/CMS_functions.js"></script>'."\n";
							//save JS handled
							CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('js-files' => true));
						}
						if ($visualizationMode == PAGE_VISUALMODE_FORM) {
							global $cms_user;
							$isValidator = (is_object($cms_user) && $cms_user->hasPageClearance($treatedObject->getID(), CLEARANCE_PAGE_EDIT) && $cms_user->hasValidationClearance(MOD_STANDARD_CODENAME)) ? 'true' : 'false';
							//add needed javascripts
							$metaDatas .= '<script type="text/javascript">'."\n".
								'var atmRowsDatas = {};'."\n".
								'var atmBlocksDatas = {};'."\n".
								'var atmCSDatas = {};'."\n".
								'var atmIsValidator = '.$isValidator.';'."\n".
								'var atmIsValidable = true;'."\n".
								'var atmHasPreview = true;'."\n".
							'</script>';
							//append JS from current view instance
							$view = CMS_view::getInstance();
							$metaDatas .= $view->getJavascript();
							$metaDatas .= CMS_view::getCSS(array('edit'));
						} else if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM) {
							//add needed javascripts
							$metaDatas .= '<script type="text/javascript">'."\n".
								'var atmRowsDatas = {};'."\n".
								'var atmBlocksDatas = {};'."\n".
								'var atmCSDatas = {};'."\n".
								'var atmIsValidator = false;'."\n".
								'var atmIsValidable = false;'."\n".
								'var atmHasPreview = false;'."\n".
							'</script>';
							//append JS from current view instance
							$view = CMS_view::getInstance();
							$metaDatas .= $view->getJavascript();
							$metaDatas .= CMS_view::getCSS(array('edit'));
						}
						//if page template already use atm-js-tags tag, no need to add JS again
						if (!is_array($usage) || !isset($usage['atm-js-tags'])) {
							//if this page use a row block of this module then add the header code to the page
							if (is_array($usage) && isset($usage['blockflash']) && $usage['blockflash'] == true) {
								$metaDatas .= '<script type="text/javascript" src="'.PATH_MAIN_WR.'/swfobject/swfobject.js"></script>'."\n";
							}
						}
						return $metaDatas;
					break;
				}
				return '';
			break;
			case MODULE_TREATMENT_WYSIWYG_INNER_TAGS :
				if ($tag->getName() == 'atm-linx') { //linx from standard module
					$domdocument = new CMS_DOMDocument();
					try {
						$domdocument->loadXML('<html>'.$tag->getContent().'</html>');
					} catch (DOMException $e) {
						$this->raiseError('Parse error for atm-linx : '.$e->getMessage()." :\n".io::htmlspecialchars($tag->getContent()));
						return '';
					}
					$nodespecs = $domdocument->getElementsByTagName('nodespec');
					if ($nodespecs->length == 1) {
						$nodespec = $nodespecs->item(0);
					}
					$htmltemplates = $domdocument->getElementsByTagName('htmltemplate');
					if ($htmltemplates->length == 1) {
						$htmltemplate = $htmltemplates->item(0);
					}
					$noselections = $domdocument->getElementsByTagName('noselection');
					if ($noselections->length == 1) {
						$noselection = $noselections->item(0);
					}
					if($nodespec && $htmltemplate) {
						//if ($paramsTags[0]->getName() == "nodespec" && $paramsTags[1]->getName() == "noselection" && $paramsTags[2]->getName() == "htmltemplate") {
						if (isset($noselection)) {
							// case noselection tag
							$pageID = $nodespec->getAttribute("value");
							$link = CMS_DOMDocument::DOMElementToString($htmltemplate, true);
							$treatedLink = str_replace('href','noselection="true" href',str_replace('{{href}}','{{'.$pageID.'}}',$link));
						} else {
							$pageID = $nodespec->getAttribute("value");
							$link = CMS_DOMDocument::DOMElementToString($htmltemplate, true);
							$treatedLink = str_replace('{{href}}','{{'.$pageID.'}}',$link);
						}
					}
				} elseif ($tag->getName() == 'span') { //linx from other module
					$ids = explode('-', $tag->getAttribute('id'));
					$selectedPageID = (int) $ids[1];
					$noselection = $ids[2];
					//then create the code to paste for the current selected object if any
					if (sensitiveIO::isPositiveInteger($selectedPageID) && ($noselection == 'true' || $noselection == 'false')) {
						$pattern = "/(.*)<a([^>]*)'\.CMS_tree.*, 'url'\)\.'(.*)\<\/a>(.*)<\/span>/U";
						if ($noselection == 'true') {
							$replacement = '<a noselection="true"\\2{{'.$selectedPageID.'}}\\3</a>';
						} else {
							$replacement = '<a\\2{{'.$selectedPageID.'}}\\3</a>';
						}
						$treatedLink = str_replace("\'", "'", preg_replace($pattern,$replacement,$tag->getContent()));
					}
				}
				return $treatedLink;
			case MODULE_TREATMENT_WYSIWYG_OUTER_TAGS :
				//Anchor
				if (preg_match('/^#([a-zA-Z0-9._{}:-]*)$/i', $tag->getAttribute('href')) > 0) {
					//instanciate anchor tag
					$anchor = new CMS_XMLTag_anchor(
							$tag->getName(),
							$tag->getAttributes(),
							$tag->getChildren(),
							$tag->getParameters()
					);
					return $anchor->compute(array(
						'mode'			=> $treatmentMode,
						'visualization' => $visualizationMode,
						'object'		=> $treatedObject,
						'parameters'	=> $treatmentParameters
					));
				} elseif (preg_match('/^.*\{\{(\d+)\}\}.*$/i', $tag->getAttribute('href')) > 0) { //internal links
					/* Pattern explanation :
					 * 
					 * \<a([^>]*) : start with "<a" and any characters after except a ">". Content found into the "()" (first parameters of the link) is the first variable : "\\1"
					 * {{(\d+)}} : some numbers only into "{{" and "}}". Content found into the "()" (the page number) is the second variable : "\\2"
					 * (.*)\<\/a> : any characters after followed by "</a>". Content found into the "()" (last parameters of the link and link content) is the third variable : "\\3"
					 * /U : PCRE_UNGREEDY stop to the first finded occurence.
					*/
					$pattern = "/<a([^>]*){{(\d+)}}(.*)\<\/a>/Us";
					if ($tag->getName() == 'a' && $treatmentParameters['module'] == MOD_STANDARD_CODENAME) {
						if ($tag->getAttribute('noselection') == 'true') {
							$replacement = "<atm-linx type=\"direct\"><selection><start><nodespec type=\"node\" value=\"\\2\"/></start></selection><noselection>".$tag->getInnerContent()."</noselection><display><htmltemplate><a\\1{{href}}\\3</a></htmltemplate></display></atm-linx>";
							$treatedLink = preg_replace($pattern, $replacement, str_replace('noselection="true"', '', $tag->getContent()));
						} else {
							$replacement = "<atm-linx type=\"direct\"><selection><start><nodespec type=\"node\" value=\"\\2\"/></start></selection><display><htmltemplate><a\\1{{href}}\\3</a></htmltemplate></display></atm-linx>";
							$treatedLink = preg_replace($pattern, $replacement, $tag->getContent());
						}
					} elseif ($tag->getName() == 'a' && $treatmentParameters['module'] != MOD_STANDARD_CODENAME) {
						if ($tag->getAttribute('noselection') == 'true') {
							$replacement = '<span id="'.MOD_STANDARD_CODENAME.'-\\2-true"><?php if (CMS_tree::pageExistsForUser(\\2)) { echo \'<a\\1\'.CMS_tree::getPageValue(\\2, \'url\').\'\\3</a>\';} else { echo '.var_export($tag->getInnerContent(),true).';} ?><!--{elements:'.base64_encode(serialize(array('module' => array(0 => MOD_STANDARD_CODENAME)))).'}--></span>';
							$treatedLink = preg_replace($pattern, $replacement, str_replace(array('noselection="true"',"'"), array('',"\'"), $tag->getContent()));
						} else {
							$replacement = '<span id="'.MOD_STANDARD_CODENAME.'-\\2-false"><?php if (CMS_tree::pageExistsForUser(\\2)) { echo \'<a\\1\'.CMS_tree::getPageValue(\\2, \'url\').\'\\3</a>\';} ?><!--{elements:'.base64_encode(serialize(array('module' => array(0 => MOD_STANDARD_CODENAME)))).'}--></span>';
							$treatedLink = preg_replace($pattern, $replacement, str_replace("'","\'", $tag->getContent()));
						}
					}
					return $treatedLink;
				}
			break;
		}
		//in case of no tag treatment, simply return it
		return $tag->getContent();
	}
	
	/**
	  * Return the module code for the specified treatment mode, visualization mode and object.
	  * 
	  * @param mixed $modulesCode the previous modules codes (usually string)
	  * @param integer $treatmentMode The current treatment mode (see constants on top of this file for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  *
	  * @return string : the module code to add
	  * @access public
	  */
	function getModuleCode($modulesCode, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_PAGECONTENT_HEADER_CODE :
				$modulesCode[MOD_STANDARD_CODENAME] = '';
				if ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC 
					|| $visualizationMode == PAGE_VISUALMODE_PRINT) {
					//path to cms_rc_frontend
					$path = PATH_PAGES_HTML_WR == PATH_MAIN_WR."/html" ? '/../../cms_rc_frontend.php' : '/../cms_rc_frontend.php';
					//redirection code if any
					$redirectlink = $treatedObject->getRedirectLink(true);
					if ($redirectlink->hasValidHREF()) {
						$href = $redirectlink->getHTML(false, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
						$modulesCode[MOD_STANDARD_CODENAME] .= 
								'<?php'."\n".
								'if (!defined(\'PATH_REALROOT_FS\')){'."\n".
								'	require_once(dirname(__FILE__).\''.$path.'\');'."\n".
								'} else {'."\n".
								'	require_once(PATH_REALROOT_FS."/cms_rc_frontend.php");'."\n".
								'}'."\n".
								'CMS_view::redirect(\''.$href.'\', true, 302);'."\n".
								'?>';
					}
					//include frontend files
					$modulesCode[MOD_STANDARD_CODENAME] .= 
					'<?php'."\n".
					'//Generated on '.date('r').' by '.CMS_grandFather::SYSTEM_LABEL.' '.AUTOMNE_VERSION."\n".
					'if (!defined(\'PATH_REALROOT_FS\')){'."\n".
					'	require_once(dirname(__FILE__).\''.$path.'\');'."\n".
					'} else {'."\n".
					'	require_once(PATH_REALROOT_FS."/cms_rc_frontend.php");'."\n".
					'}'."\n".
					'if (!isset($cms_page_included) && !$_POST && !$_GET) {'."\n".
					'	CMS_view::redirect(\''.$treatedObject->getURL(($visualizationMode == PAGE_VISUALMODE_PRINT) ? true : false).'\', true, 301);'."\n".
					'}'."\n".
					'?>';
					if (APPLICATION_ENFORCES_ACCESS_CONTROL) {
						//include user access checking on top of output file
						$modulesCode[MOD_STANDARD_CODENAME] .= 
							'<?php'."\n".
							'if (!is_object($cms_user) || !$cms_user->hasPageClearance('.$treatedObject->getID().', CLEARANCE_PAGE_VIEW)) {'."\n".
							'	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.\'?referer=\'.base64_encode($_SERVER[\'REQUEST_URI\']));'."\n".
							'}'."\n".
							'?>';
					}
					return $modulesCode;
				} else {
					$modulesCode[MOD_STANDARD_CODENAME] .= '<?php if (!in_array("'.PATH_REALROOT_FS.'/cms_rc_frontend.php", get_included_files())){ require_once("'.PATH_REALROOT_FS.'/cms_rc_frontend.php");} else { global $cms_user,$cms_language;} ?>';
				}
			break;
			case MODULE_TREATMENT_EDITOR_CODE :
				if ($treatmentParameters["editor"] == "fckeditor") {
					$languages = implode(',',array_keys(CMS_languagesCatalog::getAllLanguages(MOD_STANDARD_CODENAME)));
					//This is an exception of the method, because here we return an array, see admin/fckeditor/fckconfig.php for the detail
					return array (
				 		  "Default"				=> array("'automneLinks'"),
				  		  "modulesDeclaration"	=> array("FCKConfig.Plugins.Add( 'automneLinks', '".$languages."' );")
				 		 );
				} else {
					return $modulesCode;
				}
			break;
			case MODULE_TREATMENT_EDITOR_PLUGINS:
				if ($treatmentParameters["editor"] == "fckeditor") {
					$language = $treatmentParameters["user"]->getLanguage();
					$modulesCode['automneLinks'] = $language->getMessage(self::MESSAGE_MOD_STANDARD_PLUGIN);
				}
			break;
			case MODULE_TREATMENT_EDITOR_JSCODE :
				$modulesCode[MOD_STANDARD_CODENAME] = "
				<script type=\"text/javascript\">
				function openWindow(url, name, w, h, r, s, m, left, top) {
					popupWin = window.open(url, name, 'width=' + w + ',height=' + h + ',resizable=' + r + ',scrollbars='+ s + ',menubar=' + m + ',left=' + left + ',top=' + top);
				}
				</script>";
				return $modulesCode;
			break;
			case MODULE_TREATMENT_ROWS_EDITION_LABELS :
				$modulesCode[$this->_codename] = '';
				//if user has rights on module
				if ($treatmentParameters["user"]->hasModuleClearance($this->_codename, CLEARANCE_MODULE_EDIT)) {
					if (!isset($treatmentParameters['request'])) {
						//add form to choose object to display
						$modulesCode[$this->_codename] = '
							<h1>'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_TAGS_CHOOSE).'<select onchange="Ext.get(\'help'.$this->_codename.'\').getUpdater().update({url: \''.PATH_ADMIN_WR.'/help-detail.php\',params: {module: \''.$this->_codename.'\',object: this.value, mode:'.MODULE_TREATMENT_ROWS_EDITION_LABELS.'}});">
								<option value="">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_CHOOSE).'</option>
								<option value="block">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_TAGS).'</option>
								<option value="working">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS).'</option>
								<option value="working-standard">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_STANDARD_TAGS).'</option>
								<option value="vars">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS).'</option>
							</select></h1>
							<div id="help'.$this->_codename.'"></div>
						';
					}
					//then display chosen object infos
					if (isset($treatmentParameters['request'][$this->_codename]) && isset($treatmentParameters['request'][$this->_codename.'object'])) {
						switch ($treatmentParameters['request'][$this->_codename.'object']) {
							case 'block':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_TAGS_EXPLANATION);
							break;
							case 'working':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION);
							break;
							case 'working-standard':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_STANDARD_TAGS_EXPLANATION);
							break;
							case 'vars':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask()));
							break;
						}
					}
				}
				return $modulesCode;
			break;
			case MODULE_TREATMENT_TEMPLATES_EDITION_LABELS :
				$modulesCode[$this->_codename] = '';
				//if user has rights on module
				if ($treatmentParameters["user"]->hasModuleClearance($this->_codename, CLEARANCE_MODULE_EDIT)) {
					if (!isset($treatmentParameters['request'])) {
						//add form to choose object to display
						$modulesCode[$this->_codename] = '
							<h1>'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_TAGS_CHOOSE).'<select onchange="Ext.get(\'help'.$this->_codename.'\').getUpdater().update({url: \''.PATH_ADMIN_WR.'/help-detail.php\',params: {module: \''.$this->_codename.'\',object: this.value, mode:'.MODULE_TREATMENT_TEMPLATES_EDITION_LABELS.'}});">
								<option value="">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_CHOOSE).'</option>
								<option value="block">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_TAGS).'</option>
								<option value="working">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS).'</option>
								<option value="working-standard">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_STANDARD_TAGS).'</option>
								<option value="vars">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS).'</option>
							</select></h1>
							<div id="help'.$this->_codename.'"></div>
						';
					}
					//then display chosen object infos
					if (isset($treatmentParameters['request'][$this->_codename]) && isset($treatmentParameters['request'][$this->_codename.'object'])) {
						switch ($treatmentParameters['request'][$this->_codename.'object']) {
							case 'block':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_TEMPLATE_EXPLANATION);
							break;
							case 'working':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION);
							break;
							case 'working-standard':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_STANDARD_TAGS_EXPLANATION);
							break;
							case 'vars':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask()));
							break;
						}
					}
				}
				return $modulesCode;
				
				
				/*$modulesCode[MOD_STANDARD_CODENAME] = $treatmentParameters["language"]->getMessage(self::MESSAGE_MOD_STANDARD_TEMPLATE_EXPLANATION);
				return $modulesCode;*/
			break;
			case MODULE_TREATMENT_ALERTS :
				$modulesCode[MOD_STANDARD_CODENAME] = array(
					ALERT_LEVEL_PROFILE 	=> array('label' => CMS_profile::MESSAGE_ALERT_LEVEL_PROFILE, 'description' => CMS_profile::MESSAGE_ALERT_LEVEL_PROFILE_DESCRIPTION)
				);
				//only if user has validation clearances
				if ($treatmentParameters['user']->hasValidationClearance(MOD_STANDARD_CODENAME)) {
					$modulesCode[MOD_STANDARD_CODENAME][ALERT_LEVEL_VALIDATION] = array('label' => CMS_profile::MESSAGE_ALERT_LEVEL_VALIDATION, 'description' => CMS_profile::MESSAGE_ALERT_LEVEL_VALIDATION_DESCRIPTION);
				}
				//only if user has edition clearances
				if ($treatmentParameters['user']->hasEditablePages()) {
					$modulesCode[MOD_STANDARD_CODENAME][ALERT_LEVEL_PAGE_ALERTS] = array('label' => CMS_profile::MESSAGE_ALERT_LEVEL_PAGE_ALERTS, 'description' => CMS_profile::MESSAGE_ALERT_LEVEL_PAGE_ALERTS_DESCRIPTION);
				}
				return $modulesCode;
			break;
		}
		return $modulesCode;
	}
	
	/**
	  * Module replacements vars
	  *
	  * @return array of replacements values (pattern to replace => replacement)
	  * @access public
	  */
	function getModuleReplacements() {
		$replace = array();
		
		//replace '{vartype:type:name}' value by corresponding var call
		$replace["#^\{(var|request|session|constant)\:([^:]*?(::)?[^:]*?):([^:]*?)\}$#U"] = 'CMS_poly_definition_functions::getVarContent("\1", "\4", "\2", @$\4)';
		$replace["#^\{(var|request|session|constant)\:([^:]*?(::)?[^:]*?):([^:]*?(::)?[^:]*?)\}$#U"] = 'CMS_poly_definition_functions::getVarContent("\1", "\4", "\2", "\4")';
		
		//replace '{page:id:type}' value by corresponding CMS_tree::getPageValue(id, type) call
		$replace["#^\{page\:([^:]*?(::)?[^:]*?)\:([^:]*?(::)?[^:]*?)\}$#U"] = 'CMS_tree::getPageValue("\1", "\3", @$public_search, \'{{pageID}}\')';
		
		//replace '{user:id:type}' value by corresponding CMS_profile_usersCatalog::getUserValue(id, type) call
		$replace["#^\{user\:([^:]*?(::)?[^:]*?)\:([^:]*?(::)?[^:]*?)\}$#U"] = 'CMS_profile_usersCatalog::getUserValue("\1", "\3", (isset($cms_user) ? $cms_user->getUserId() : null))';
		
		return $replace;
	}
	
	/**
	  * Module script task : regenerate a page
	  *
	  * @param array $parameters the task parameters
	  *		pageid : integer page id to regenerate
	  *		fromscratch : boolean, regenerate from scratch
	  * @return Boolean true/false
	  * @access public
	  */
	function scriptTask($parameters) {
		//regenerates the page (suppressing errors, we want the regenerator to continue unharmed. Of course, we can't have regeneration results this way)
		$page = @CMS_tree::getPageByID($parameters['pageid']);
		
		if (is_object($page) && !$page->hasError() && $page->isUseable()) {
			@$page->regenerate($parameters['fromscratch']);
			return true;
		}
		return false;
	}
	
	/**
	  * Module script info : get infos for a given script parameters
	  *
	  * @param array $parameters the task parameters
	  *		pageid : integer page id to regenerate
	  *		fromscratch : boolean, regenerate from scratch
	  * @return string : HTML scripts infos
	  * @access public
	  */
	function scriptInfo($parameters) {
		global $cms_language;
		//regenerates the page (suppressing errors, we want the regenerator to continue unharmed. Of course, we can't have regeneration results this way)
		$page = @CMS_tree::getPageByID($parameters['pageid']);
		
		if (is_object($page) && !$page->hasError()) {
			$label = @$page->getTitle();
			return 'Page : <a class="admin" href="#" onclick="Automne.utils.getPageById('.$page->getID().');Ext.getCmp(\'scriptsWindow\').close();return false;">'.io::htmlspecialchars($label).' ('.$parameters['pageid'].')</a>';
		}
		return $cms_language->getMessage(66).' ('.$parameters['pageid'].')';
	}
	
	/**
	  * Search module objects by Id
	  *
	  * @param string $keyword : the search keywords
	  * @param CMS_profile_user $user : the user which make the search
	  * @param booolean : public search (default : false)
	  * @param array : the results score returned by reference
	  * @return array : results elements Ids
	  * @access public
	  */
	function search ($keyword, &$user, $public = false, &$score = array()) {
		$search = new CMS_search();
		$pageResults = $search->getSearch($keyword, $user, $public, true);
		$score = $pageResults['score'];
		return $pageResults['results'];
	}
	
	/**
	  * Get search results objects for module by Id
	  *
	  * @param array : the results score ids
	  * @return array : results elements (cms_page)
	  * @access public
	  */
	function getSearchResults($resultsIds, $user) {
		$results = array();
		$cms_language = $user->getLanguage();
		foreach ($resultsIds as $id) {
			$page = CMS_tree::getPageById($id);
			
			//Resource related informations
			$htmlStatus = $pubRange = '';
			$status = $page->getStatus();
			if (is_object($status)) {
				$htmlStatus = $status->getHTML(false, $user, $this->getCodename(), $page->getID());
				$pubRange = $status->getPublicationRange($cms_language);
			}
			$pageTemplateLabel = ($page->getTemplate()) ? $page->getTemplate()->getLabel() : '';
			//page panel tip content
			$panelTip = '
			'.$cms_language->getMessage(self::MESSAGE_MOD_STANDARD_LINKTITLE).' : <strong>'.$page->getLinkTitle().'</strong><br />
			'.$cms_language->getMessage(self::MESSAGE_MOD_STANDARD_ID).' : <strong>'.$page->getID().'</strong><br />
			'.($page->getCodename() ? ($cms_language->getMessage(self::MESSAGE_MOD_STANDARD_CODENAME).' : <strong>'.$page->getCodename().'</strong><br />') : '').'
			'.$cms_language->getMessage(self::MESSAGE_MOD_STANDARD_STATUS).' : <strong>'.$page->getStatus()->getStatusLabel($cms_language).'</strong><br />
			'.$cms_language->getMessage(self::MESSAGE_MOD_STANDARD_TEMPLATE).' : <strong>'.$pageTemplateLabel.'</strong>';
			
			$edit = false;
			if ($user->hasPageClearance($page->getID(), CLEARANCE_PAGE_EDIT)) {
				$edit = array(
					'type'			=> 'function',
					'func'			=> "(function(button, window) {
						Automne.message.popup({
							msg: 				'Modifier la page \'".sensitiveIO::sanitizeJSString($page->getTitle())."\' fermera la recherche en cours. Etes vous sur ?',
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			button.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									return;
								}
								//view page
								Automne.utils.getPageById(".$page->getID().", 'edit');
								//close window
								window.close();
							}
						});
					})",
				);
			}
			
			$results[$id] = array(
				'id'			=> $id,
				'type'			=> $cms_language->getMessage(self::MESSAGE_MOD_STANDARD_PAGE),
				'status'		=> $htmlStatus,
				'pubrange'		=> $pubRange,
				'label'			=> $page->getTitle(),
				'description'	=> $panelTip,
				'edit'			=> $edit,
				'view'			=> array(
					'type'			=> 'function',
					'func'			=> "(function(button, window) {
						Automne.message.popup({
							msg: 				'Voir la page \'".sensitiveIO::sanitizeJSString($page->getTitle())."\' fermera la recherche en cours. Etes vous sur ?',
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			button.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									return;
								}
								//view page
								Automne.utils.getPageById(".$page->getID().", 'public');
								//close window
								window.close();
							}
						});
					})",
				),
			);
		}
		return $results;
	}
	
	/**
	  * Get the module authentification adapter
	  *
	  * @param array : the authentification params
	  * @return CMS_auth : the module authentification adapter
	  * @access public
	  */
	function getAuthAdapter($params) {
		//create auth adapter with params
		return new CMS_auth($params);
	}
}
?>