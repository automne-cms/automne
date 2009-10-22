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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: modulePolymodValidation.php,v 1.4 2009/10/22 16:30:02 sebastien Exp $

/**
  * Class CMS_modulePolymodValidation
  *
  * All validations code for a polymod modules
  *
  * @package CMS
  * @subpackage modules
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_modulePolymodValidation extends CMS_module
{
	const MESSAGE_MOD_POLYMOD_VALIDATION_EDITION = 2;
	const MESSAGE_MOD_POLYMOD_VALIDATION_EDITION_OFRESOURCE = 3;
	const MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE = 4;
	const MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE_OFRESOURCE = 5;
	const MESSAGE_PAGE_ACTION_PREVIZ = 811;
	
	/**
	  * Method to get the item label
	  * @var string
	  * @access private
	  */
	protected $_resourceNameMethod 	= 'getLabel';
	
	/**
	  * Current primary resource object definition
	  * @var CMS_poly_object_definition
	  * @access private
	  */
	protected $_primaryResourceObjectDefinition;
	
	/**
	  * Constructor.
	  * initializes the module object
	  *
	  * @return void
	  * @access public
	  */
	function __construct($codename)
	{
		//Initialize object.
		parent::__construct($codename);
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
				if ($tag->getAttribute("type")) {
					$clientSpaceClassName = 'CMS_moduleClientspace_'.$this->getCodename();
					$instance = new $clientSpaceClassName($tag->getAttributes());
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
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		if (CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			$this->getPrimaryResourceDefinition();
			$all_validations = array();
			$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_LOCATION);
			if ($validations) {
				$all_validations = array_merge($all_validations, $validations);
			}
			
			$validations = $this->getValidationsByEditions($user, RESOURCE_EDITION_CONTENT);
			if ($validations) {
				$all_validations = array_merge($all_validations, $validations);
			}
		} else {
			return false;
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
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		if (CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			$this->getPrimaryResourceDefinition();
			$all_validations = array();
			$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_LOCATION);
			if ($validations) {
				$all_validations = array_merge($all_validations, $validations);
			}
			
			$validations = $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_CONTENT);
			if ($validations) {
				$all_validations = array_merge($all_validations, $validations);
			}
		} else {
			return false;
		}
		if (!$all_validations) {
			return false;
		} else {
			return $all_validations;
		}
	}
	
	/**
	  * Gets the module validations count
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @return integer
	  * @access public
	  */
	function getValidationsCount($user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename) || !CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			return 0;
		}
		$validations = 0;
		if (isset($this->_resourceInfo) && is_array($this->_resourceInfo) && $this->_resourceInfo) {
			$validations += $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_LOCATION, true);
			$validations += $this->getValidationsInfoByEditions($user, RESOURCE_EDITION_CONTENT, true);
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
		
		if (CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			//get object type ID
			$objectID = CMS_poly_object_catalog::getPrimaryResourceObjectType($this->getCodename());
			//get viewvable objects list for current user
			if (CMS_poly_object_catalog::objectHasCategories($objectID)) {
				$objects = CMS_poly_object_catalog::getAllObjects($objectID, false, array(), false);
				//$where = (is_array($objects) && $objects) ? ' and objectID in ('.implode(',',$objects).')' : '';
				if (is_array($objects) && $objects) {
					$where = ' and objectID in ('.implode(',',$objects).')';
				} else {
					return $validations;
				}
			} else {
				$where = '';
			}
			
			$this->getPrimaryResourceDefinition();
			//content and/or base data change
			if ($editions & RESOURCE_EDITION_CONTENT) {
				$sql = "
					select
						objectID as id
					from
						mod_subobject_integer_edited,
						mod_object_polyobjects,
						resources,
						resourceStatuses,
					where
						value = id_res
						and object_type_id_moo = '".$objectID."'
						and id_moo = objectID
						and objectFieldID = 0
						and objectSubFieldID = 0
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs = 0
						and (editions_rs & ".RESOURCE_EDITION_CONTENT."
								and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
						$where
				";
				$q = new CMS_query($sql);
				
				while ($id = $q->getValue("id")) {
					$item = $this->getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_CONTENT, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_EDITION, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
						$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_EDITION_OFRESOURCE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME)." ".io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$previzURL = $item->getPrevizPageURL();
						if ($previzURL) {
							$validation->addHelpUrl($language->getMessage(self::MESSAGE_PAGE_ACTION_PREVIZ),$previzURL);
						}
						$validation->setEditorsStack($item->getEditorsStack());
						$validations[] = $validation;
					}
				}
			}
			if ($editions & RESOURCE_EDITION_LOCATION) {
				//Location change
				$sql = "
					select
						objectID as id
					from
						mod_subobject_integer_edited,
						mod_object_polyobjects,
						resources,
						resourceStatuses
					where
						value = id_res
						and object_type_id_moo = '".$objectID."'
						and id_moo = objectID
						and objectFieldID = 0
						and objectSubFieldID = 0
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs != 0
						and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
						$where
				";
				$q = new CMS_query($sql);
				while ($id = $q->getValue("id")) {
					$item = $this->getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
						$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE_OFRESOURCE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME)." ".io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$previzURL = $item->getPrevizPageURL();
						if ($previzURL) {
							$validation->addHelpUrl($language->getMessage(self::MESSAGE_PAGE_ACTION_PREVIZ),$previzURL);
						}
						$validation->setEditorsStack($item->getEditorsStack());
						$validations[] = $validation;
					}
				}
			}
		}
		return $validations;
	}
	
	/**
	  * Gets the module validations Info for the given editions and user
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @param integer $editions The editions we want the validations of
	  * @param boolean $returnCount only return the count of validations
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if noen found
	  * @access public
	  */
	function getValidationsInfoByEditions(&$user, $editions, $returnCount = false)
	{
		$language = $user->getLanguage();
		$validations = array();
		$validationsCount = 0;
		if (CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			//get object type ID
			$objectID = CMS_poly_object_catalog::getPrimaryResourceObjectType($this->getCodename());
			//get viewvable objects list for current user
			if (CMS_poly_object_catalog::objectHasCategories($objectID)) {
				$objects = CMS_poly_object_catalog::getAllObjects($objectID, false, array(), false);
				//$where = (is_array($objects) && $objects) ? ' and objectID in ('.implode(',',$objects).')' : '';
				if (is_array($objects) && $objects) {
					$where = ' and objectID in ('.implode(',',$objects).')';
				} else {
					return $validations;
				}
			} else {
				$where = '';
			}
			$this->getPrimaryResourceDefinition();
			if ($editions & RESOURCE_EDITION_CONTENT) {
				//content and/or base data change
				$sql = "
					select
						objectID as id
					from
						mod_subobject_integer_edited,
						mod_object_polyobjects,
						resources,
						resourceStatuses
					where
						value = id_res
						and object_type_id_moo = '".$objectID."'
						and id_moo = objectID
						and objectFieldID = 0
						and objectSubFieldID = 0
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs = 0
						and (editions_rs & ".RESOURCE_EDITION_CONTENT."
								and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
						$where
				";
				$q = new CMS_query($sql);
				if ($returnCount) {
					$validationsCount += $q->getNumRows();
				} else {
					while ($id = $q->getValue("id")) {
						$validation = new CMS_resourceValidationInfo($this->_codename, RESOURCE_EDITION_CONTENT, $id);
						if (!$validation->hasError()) {
							$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_EDITION, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
							$validations[] = $validation;
						}
					}
				}
			}
			
			if ($editions & RESOURCE_EDITION_LOCATION) {
				//Location change
				$sql = "
					select
						objectID as id
					from
						mod_subobject_integer_edited,
						mod_object_polyobjects,
						resources,
						resourceStatuses
					where
						value = id_res
						and object_type_id_moo = '".$objectID."'
						and id_moo = objectID
						and objectFieldID = 0
						and objectSubFieldID = 0
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs != 0
						and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
						$where
				";
				$q = new CMS_query($sql);
				if ($returnCount) {
					$validationsCount += $q->getNumRows();
				} else {
					while ($id = $q->getValue("id")) {
						$validation = new CMS_resourceValidationInfo($this->_codename, RESOURCE_EDITION_LOCATION, $id);
						if (!$validation->hasError()) {
							$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
							$validations[] = $validation;
						}
					}
				}
			}
		}
		return ($returnCount) ? $validationsCount : $validations;
	}
	
	/**
	  * Gets a validation for a given item
	  *
	  * @param integer $itemID The item we want the validations for
	  * @param CMS_user $user The user we want the validations for
	  * @param integer $getEditionType The validation type we want.
	  *  by default function return RESOURCE_EDITION_LOCATION then RESOURCE_EDITION_CONTENT then RESOURCE_EDITION_SIBLINGSORDER
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if none found for the given user.
	  * @access public
	  */
	function getValidationByID($itemID, &$user, $getEditionType=false)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		
		if (CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			//get object type ID
			$objectID = CMS_poly_object_catalog::getPrimaryResourceObjectType($this->getCodename());
			//get viewvable objects list for current user
			if (CMS_poly_object_catalog::objectHasCategories($objectID)) {
				$objects = CMS_poly_object_catalog::getAllObjects($objectID, false, array(), false);
				//$where = (is_array($objects) && $objects) ? ' and objectID in ('.implode(',',$objects).')' : '';
				if (is_array($objects) && $objects) {
					$where = ' and objectID in ('.implode(',',$objects).')';
				} else {
					return false;
				}
			} else {
				$where = '';
			}
			
			$this->getPrimaryResourceDefinition();
			if (!$getEditionType) {
				$getEditionType = RESOURCE_EDITION_LOCATION + RESOURCE_EDITION_CONTENT;
			}
			$sql = "
					select
						objectID as id,
						location_rs as location,
						proposedFor_rs as proposedFor,
						validationsRefused_rs as validationsRefused,
						editions_rs as editions,
						mod_subobject_integer_edited.id as fieldID
					from
						mod_subobject_integer_edited,
						mod_object_polyobjects,
						resources,
						resourceStatuses
					where
						objectID = '".$itemID."'
						and value = id_res
						and object_type_id_moo = '".$objectID."'
						and id_moo = objectID
						and objectFieldID = 0
						and objectSubFieldID = 0
						and status_res = id_rs
						$where
				";
			$q = new CMS_query($sql);
			if ($q->getNumRows() >= 1) {
				$r = $q->getArray();
				$id = $r["id"];
				//here, this is an ugly hack to resolve a strange bug (multiple resources for an unique object).
				//not time to found the real cause for now ...
				if ($q->getNumRows() > 1) {
					while ($exceptionFiledID = $q->getValue('fieldID')) {
						$sql_delete = "delete from mod_subobject_integer_edited where id = '".$exceptionFiledID."'";
						$q_delete = new CMS_query($sql_delete);
					}
				}
				//search the type of edition
				
				//RESOURCE_EDITION_LOCATION
				if (($r["location"] == RESOURCE_LOCATION_USERSPACE
					&&	$r["proposedFor"] != 0
					&&	!($r["validationsRefused"] & RESOURCE_EDITION_LOCATION)) && ($getEditionType & RESOURCE_EDITION_LOCATION)) {
					
					$language = $user->getLanguage();
					
					$item = $this->getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
						$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_LOCATIONCHANGE_OFRESOURCE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME)." ".io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$validation->setValidationShortLabel(io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$previzURL = $item->getPrevizPageURL();
						if ($previzURL) {
							$validation->addHelpUrl($language->getMessage(self::MESSAGE_PAGE_ACTION_PREVIZ),$previzURL);
						}
						$validation->setEditorsStack($item->getEditorsStack());
						return $validation;
					} else {
						return false;
					}
				
				//RESOURCE_EDITION_CONTENT
				} elseif(($r["location"] == RESOURCE_LOCATION_USERSPACE
						&&	$r["proposedFor"] == 0
						&&	($r["editions"] & RESOURCE_EDITION_CONTENT && !($r["validationsRefused"] & RESOURCE_EDITION_CONTENT))
						 ) && ($getEditionType & RESOURCE_EDITION_CONTENT)) {
					
					$language = $user->getLanguage();
					
					$editions = $r["editions"];//RESOURCE_EDITION_CONTENT
					
					$item = $this->getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, $editions, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_EDITION, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME));
						$validation->setValidationLabel($language->getMessage(self::MESSAGE_MOD_POLYMOD_VALIDATION_EDITION_OFRESOURCE, array($this->_primaryResourceObjectDefinition->getLabel($language)), MOD_POLYMOD_CODENAME)." ".io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$validation->setValidationShortLabel(io::decodeEntities($item->{$this->_resourceNameMethod}()));
						$previzURL = $item->getPrevizPageURL();
						if ($previzURL) {
							$validation->addHelpUrl($language->getMessage(self::MESSAGE_PAGE_ACTION_PREVIZ),$previzURL);
						}
						$validation->setEditorsStack($item->getEditorsStack());
						return $validation;
					} else {
						return false;
					}
				}
				
			} elseif ($q->getNumRows() == 0) {
				return false;
			} else {
				$this->raiseError("Can't have more than one item for a given ID");
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Process the module validations. Note that the EMails sent to either the transferred validator or the editors were sent before.
	  *
	  * @param CMS_resourceValidation $resourceValidation The resource validation to process
	  * @param integer $result The result of the validation process. See VALIDATION_OPTION constants
	  * @return boolean true on success, false on failure to process
	  * @access public
	  */
	function processValidation($resourceValidation, $result, $lastValidation = true) {
		if (!CMS_poly_object_catalog::hasPrimaryResource($this->getCodename())) {
			$this->raiseError("Module have not any primary resource !");
			return false;
		}
		if (!is_a($resourceValidation, "CMS_resourceValidation")) {
			$this->raiseError("ResourceValidation is not a valid CMS_resourceValidation object");
			return false;
		}
		if (!SensitiveIO::isInSet($result, CMS_resourceValidation::getAllValidationOptions())) {
			$this->raiseError("ProcessValidation : result is not a valid validation option");
			return false;
		}
		
		//Tell the resource of the changes
		$resource = $resourceValidation->getResource();
		$editions = $resourceValidation->getEditions();
		
		//add a call to all modules for validation specific treatment
		$modulesCodes = new CMS_modulesCodes();
		//add a call to modules after validation
		$modulesCodes->getModulesCodes(MODULE_TREATMENT_BEFORE_VALIDATION_TREATMENT, '', $resource, array('result' => $result, 'lastvalidation' => $lastValidation, 'module' => $this->_codename));
		
		switch ($result) {
		case VALIDATION_OPTION_REFUSE:
			//validation was refused, adjust the array of validations refused
			$all_editions = CMS_resourceStatus::getAllEditions();
			foreach ($all_editions as $aEdition) {
				if ($aEdition & $editions) {
					if (RESOURCE_EDITION_LOCATION & $aEdition && $resource->getProposedLocation() == RESOURCE_LOCATION_DELETED) {
						$resource->removeProposedLocation(); 
					} else {
						$resource->addValidationRefused($aEdition);
					}
				}
			}
			break;
		case VALIDATION_OPTION_ACCEPT:
			//if one of the edition was the location, only treat this one. Move the data.
			if ($editions & RESOURCE_EDITION_LOCATION) {
				if ($resource->getLocation() == RESOURCE_LOCATION_USERSPACE) {
					//pulling resource out of USERSPACE
					switch ($resource->getProposedLocation()) {
					case RESOURCE_LOCATION_DELETED:
						$locationTo = RESOURCE_DATA_LOCATION_DELETED;
						break;
					}
					//first, move edited
					$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_EDITED, $locationTo);
					//then delete public
					$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_DEVNULL);
					//mark item as deleted
					CMS_modulePolymodValidation::markDeletedItem($resource->getID());
				} else {
					if ($resource->getProposedLocation() == RESOURCE_LOCATION_USERSPACE) {
						//Pushing resource to USERSPACE
						switch ($resource->getLocation()) {
						case RESOURCE_LOCATION_DELETED:
							$locationFrom = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						//if resource was published, copy data to public table
						if ($resource->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED) {
							$this->_changeDataLocation($resource, $locationFrom, RESOURCE_DATA_LOCATION_PUBLIC, true);
						}
						//move data from its location to edited 
						$this->_changeDataLocation($resource, $locationFrom, RESOURCE_DATA_LOCATION_EDITED);
					} else {
						//the move entirely takes place outside of USERSPACE (archived to deleted hopefully)
						switch ($resource->getLocation()) {
						case RESOURCE_LOCATION_DELETED:
							$locationFrom = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						switch ($resource->getProposedLocation()) {
						case RESOURCE_LOCATION_DELETED:
							$locationTo = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						$this->_changeDataLocation($resource, $locationFrom, $locationTo);
						if ($locationTo == RESOURCE_DATA_LOCATION_DELETED) {
							//mark item as deleted
							CMS_modulePolymodValidation::markDeletedItem($resource->getID());
						}
					}
				}
				$resource->validateProposedLocation();
			} else {
				$all_editions = CMS_resourceStatus::getAllEditions();
				$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_PUBLIC, true);
				
				foreach ($all_editions as $aEdition) {
					if ($aEdition & $editions) {
						$resource->validateEdition($aEdition);
					}
				}
			}
			break;
		}
		//if resource is a polyobject, we need to save only it resource (parent) status
		if (!is_a($resource, 'CMS_poly_object')) {
			$resource->writeToPersistence();
		} else {
			$resource->writeToPersistence(false);
		}
		$modulesCodes->getModulesCodes(MODULE_TREATMENT_AFTER_VALIDATION_TREATMENT, '', $resource, array('result' => $result, 'lastvalidation' => $lastValidation, 'module' => $this->_codename));
		return true;
	}
	
	/**
	  * Mark item as deleted (to be easily excluded from all searches)
	  *
	  * @param integer $itemID The item ID to mark as deleted
	  * @return boolean
	  */
	function markDeletedItem($itemID) {
		//set deleted status to item
		$sql = "
			update
				mod_object_polyobjects
			set 
				deleted_moo = '1'
			where
				id_moo = '".sensitiveIO::sanitizeSQLString($itemID)."'
		";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Check if item is deleted
	  *
	  * @param integer $itemID The item ID to check as deleted
	  * @return boolean true if ite is deleted, false otherwise
	  */
	function isDeletedItem($itemID) {
		static $deletedItems;
		if (!isset($deletedItems[$itemID])) {
			//set deleted status to item
			$sql = "
				select
					1
				from
					mod_object_polyobjects
				where
					id_moo = '".sensitiveIO::sanitizeSQLString($itemID)."'
					and deleted_moo = '1'
			";
			$q = new CMS_query($sql);
			$deletedItems[$itemID] = ($q->getNumRows()) ? true : false;
		}
		return $deletedItems[$itemID];
	}
	
	/**
	  * Changes The item data (in the DB) from one location to another.
	  *
	  * @param CMS_resource $resource The resource concerned by the data location change
	  * @param string $locationFrom The starting location among "edited", "edition", "public", "archived", "deleted"
	  * @param string $locationTo The ending location among "edited", "edition", "public", "archived", "deleted"
	  * @param boolean $copyOnly If true, data is not deleted from the original location
	  * @return void
	  * @access private
	  */
	protected function _changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly = false)
	{
		//check queried data location change
		if (!parent::_changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly)) {
			return false;
		}
		//get all secondary resources concerned by this validation
		$secondaryResourceIds = $resource->getAllSecondaryResourcesForPrimaryResource();
		if (is_array($secondaryResourceIds) && $secondaryResourceIds) {
			foreach($secondaryResourceIds as $secondaryResourceId) {
				//move the data
				CMS_modulePolymodValidation::moveResourceData($this->getCodename(), $secondaryResourceId, $locationFrom, $locationTo, $copyOnly);
				if ($locationTo == RESOURCE_DATA_LOCATION_DELETED) {
					//mark item as deleted
					CMS_modulePolymodValidation::markDeletedItem($secondaryResourceId);
				}
			}
		}
		//then move resource data for concerned resource
		CMS_modulePolymodValidation::moveResourceData($this->getCodename(), $resource->getID(), $locationFrom, $locationTo, $copyOnly);
	}
	
	/**
	  * Move the data of a resource from one data location to another.
	  * May be used by every module, provided it respects the naming rules described in the modules HOWTO
	  *
	  * @param string $module, The module codename
	  * @param integer $resourceID The DB ID of the resource whose data we want to move
	  * @param string $locationFrom The starting location, among the available RESOURCE_DATA_LOCATION
	  * @param string $locationTo The ending location, among  the available RESOURCE_DATA_LOCATION
	  * @param boolean $copyOnly If set to true, the deletion from the originating tables and dirs won't occur
	  * @return boolean true on success, false on failure
	  * @access public
	  * @static
	  */
	function moveResourceData($module, $resourceID, $locationFrom, $locationTo, $copyOnly = false)
	{
		//get all datas locations
		$locations = CMS_resource::getAllDataLocations();
		if (!in_array($locationFrom,$locations)) {
			CMS_grandFather::raiseError("LocationFrom is not a valid location : ".$locationFrom);
			return false;
		}
		if (!in_array($locationTo,$locations)) {
			CMS_grandFather::raiseError("LocationTo is not a valid location : ".$locationTo);
			return false;
		}
		if (!sensitiveIO::IsPositiveInteger($resourceID)) {
			CMS_grandFather::raiseError("ResourceID must be a positive integer : ".$resourceID);
			return false;
		}
		//first move DB datas
		$tables_prefixes = array(
			'mod_subobject_date_',
			'mod_subobject_integer_',
			'mod_subobject_string_',
			'mod_subobject_text_',
		);
		foreach ($tables_prefixes as $table_prefix) {
			//delete all in the destination table and insert new ones
			if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
				$sql = "
					delete from
						".$table_prefix.$locationTo."
					where
						objectID='".$resourceID."'
				";
				$q = new CMS_query($sql);
				$sql = "
					replace into
						".$table_prefix.$locationTo."
						select
							*
						from
							".$table_prefix.$locationFrom."
						where
							objectID='".$resourceID."'
				";
				$q = new CMS_query($sql);
			}
			if (!$copyOnly) {
				//delete from the starting table
				$sql = "
					delete from
						".$table_prefix.$locationFrom."
					where
						objectID='".$resourceID."'
				";
				$q = new CMS_query($sql);
			}
		}
		
		//second, move the files
		$locationFromDir = new CMS_file(PATH_MODULES_FILES_FS."/".$module."/".$locationFrom, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		//cut here if the locationFromDir doesn't exists. That means the module doesn't have files
		if (!$locationFromDir->exists()) {
			return true;
		}
		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
			$locationToDir = new CMS_file(PATH_MODULES_FILES_FS."/".$module."/".$locationTo, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
			//cut here if the locationToDir doesn't exists.
			if (!$locationToDir->exists()) {
				CMS_grandFather::raiseError("LocationToDir does not exists : ".PATH_MODULES_FILES_FS."/".$module."/".$locationTo);
				return false;
			}
			//delete all files of the locationToDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module."/".$locationTo.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					if (!CMS_file::deleteFile($file)) {
						$this->raiseError("Can't delete file ".$file);
						return false;
					}
				}
			}
			//then copy or move them to the locationToDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module."/".$locationFrom.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					$to = str_replace('/'.$locationFrom.'/','/'.$locationTo.'/',$file);
					if ($copyOnly) {
						if (!CMS_file::copyTo($file,$to)) {
							$this->raiseError("Can't copy file ".$file." to ".$to);
							return false;
						}
					} else {
						if (!CMS_file::moveTo($file,$to)) {
							$this->raiseError("Can't move file ".$file." to ".$to);
							return false;
						}
					}
					//then chmod new file
					CMS_file::chmodFile(FILES_CHMOD,$to);
				}
			}
		} else {
			//then get all files of the locationFromDir
			$files = glob(PATH_MODULES_FILES_FS."/".$module."/".$locationFrom.'/r'.$resourceID.'_*', GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					if (!CMS_file::deleteFile($file)) {
						$this->raiseError("Can't delete file ".$file);
						return false;
					}
				}
			}
		}
		return true;
	}
	
	/** 
	  * Get the default language code for this module
	  * Comes from parameters or Constant
	  * Upgrades constant with parameter founded
	  *
	  * @return String the language codename
	  * @access public
	  */
	function getDefaultLanguageCodename()
	{
		if (!defined("MOD_".io::strtoupper($this->getCodename())."_DEFAULT_LANGUAGE")) {
			$polymodLanguages = CMS_object_i18nm::getAvailableLanguages();
			define("MOD_".io::strtoupper($this->getCodename())."_DEFAULT_LANGUAGE", $polymodLanguages[0]);
		}
		return constant("MOD_".io::strtoupper($this->getCodename())."_DEFAULT_LANGUAGE");
	}
	
	/** 
	  * Get the module primary resource definition
	  *
	  * @return boolean true
	  * @access public
	  */
	function getPrimaryResourceDefinition()
	{
		if (!is_a($this->_primaryResourceObjectDefinition,'CMS_poly_object_definition')) {
			$this->_primaryResourceObjectDefinition = new CMS_poly_object_definition(CMS_poly_object_catalog::getPrimaryResourceObjectType($this->getCodename()));
		}
		return true;
	}
}
?>