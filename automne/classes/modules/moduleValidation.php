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
// $Id: moduleValidation.php,v 1.4 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_moduleValidation
  *
  * All validations code for modules
  *
  * @package Automne
  * @subpackage modules
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_moduleValidation extends CMS_module
{
	/**
	  * Array of resources infos
	  * The first record is the primary resource of the module.
	  * All other key field of other resources defined need to correspond to the first resource field and does not necessary represent the table key.
	  * For module who does not use Automne resource, leave array empty.
	  * @var multidimentional array (tableName => array ('key' => keyFielname, 'resource' => resourceFieldname))
	  * @access private
	  */
	protected $_resourceInfo;

	/**
	  * Method to get the item label
	  * @var string
	  * @access private
	  */
	protected $_resourceNameMethod;

	/**
	  * File name to be queried for the item previzualisation
	  * A param "item" is passed to this file with the ID of the resource to previz.
	  * @var string
	  * @access private
	  */
	protected $_resourcePrevizFile;

	/**
	  * Constructor.
	  * initializes the module object
	  *
	  * @return void
	  * @access public
	  */
	public function __construct($codename)
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
	public function getTagRepresentation($tag, $args, $compatArg = false)
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
	public function getValidations($user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->setError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
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
	public function getValidationsInfo($user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->setError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
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
	public function getValidationsCount($user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->setError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return 0;
		}
		$validations = 0;
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
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
	public function getValidationsByEditions(&$user, $editions)
	{
		$language = $user->getLanguage();
		$validations = array();

		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			$primaryResource = $this->getPrimaryResourceInfo();
			//content and/or base data change
			if ($editions & RESOURCE_EDITION_CONTENT) {
				$sql = "
					select
						".$primaryResource['key']." as id
					from
						".$primaryResource['tableName']."_edited,
						resources,
						resourceStatuses
					where
						".$primaryResource['resource']." = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs = 0
						and (editions_rs & ".RESOURCE_EDITION_CONTENT."
								and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
				";
				$q = new CMS_query($sql);

				while ($id = $q->getValue("id")) {
					$item = CMS_module::getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_CONTENT, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("edition"), false, $this->_codename));
						$validation->setValidationLabel($language->getMessage($this->getModuleValidationLabel("editionOfResource"), false, $this->_codename)." ".$item->{$this->_resourceNameMethod}());
						if ($this->_resourcePrevizFile) {
							$validation->addHelpUrl($language->getMessage($this->getModuleValidationLabel("URLPreviz"), false, $this->_codename),
									PATH_ADMIN_MODULES_WR."/".$this->_codename."/".$this->_resourcePrevizFile."?item=".$id);
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
						".$primaryResource['key']." as id
					from
						".$primaryResource['tableName']."_edited,
						resources,
						resourceStatuses
					where
						".$primaryResource['resource']." = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs != 0
						and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
				";
				$q = new CMS_query($sql);
				while ($id = $q->getValue("id")) {
					$item = CMS_module::getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("locationChange"), false, $this->_codename));
						$validation->setValidationLabel($language->getMessage($this->getModuleValidationLabel("locationChangeOfResource"), false, $this->_codename)." ".$item->{$this->_resourceNameMethod}());
						if ($this->_resourcePrevizFile) {
							$validation->addHelpUrl($language->getMessage($this->getModuleValidationLabel("URLPreviz"), false, $this->_codename),
									PATH_ADMIN_MODULES_WR."/".$this->_codename."/".$this->_resourcePrevizFile.".php?item=".$id);
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
	public function getValidationsInfoByEditions(&$user, $editions, $returnCount = false)
	{
		$language = $user->getLanguage();
		$validations = array();
		$validationsCount = 0;
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			$primaryResource = $this->getPrimaryResourceInfo();

			if ($editions & RESOURCE_EDITION_CONTENT) {
				//content and/or base data change
				$sql = "
					select
						".$primaryResource['key']." as id
					from
						".$primaryResource['tableName']."_edited,
						resources,
						resourceStatuses
					where
						".$primaryResource['resource']." = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs = 0
						and (editions_rs & ".RESOURCE_EDITION_CONTENT."
								and not (validationsRefused_rs & ".RESOURCE_EDITION_CONTENT."))
				";
				$q = new CMS_query($sql);
				if ($returnCount) {
					$validationsCount += $q->getNumRows();
				} else {
					while ($id = $q->getValue("id")) {
						$validation = new CMS_resourceValidationInfo($this->_codename, RESOURCE_EDITION_CONTENT, $id);
						if (!$validation->hasError()) {
							$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("edition"), false, $this->_codename));
							$validations[] = $validation;
						}
					}
				}
			}

			if ($editions & RESOURCE_EDITION_LOCATION) {
				//Location change
				$sql = "
					select
						".$primaryResource['key']." as id
					from
						".$primaryResource['tableName']."_edited,
						resources,
						resourceStatuses
					where
						".$primaryResource['resource']." = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and proposedFor_rs != 0
						and not (validationsRefused_rs & ".RESOURCE_EDITION_LOCATION.")
				";
				$q = new CMS_query($sql);
				if ($returnCount) {
					$validationsCount += $q->getNumRows();
				} else {
					while ($id = $q->getValue("id")) {
						$validation = new CMS_resourceValidationInfo($this->_codename, RESOURCE_EDITION_LOCATION, $id);
						if (!$validation->hasError()) {
							$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("locationChange"), false, $this->_codename));
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
	public function getValidationByID($itemID, &$user, $getEditionType=false)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->setError("User is not a valid CMS_profile_user object");
			return false;
		}
		if (!$user->hasValidationClearance($this->_codename)) {
			return false;
		}

		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			$primaryResource = $this->getPrimaryResourceInfo();

			if (!$getEditionType) {
				$getEditionType = RESOURCE_EDITION_LOCATION + RESOURCE_EDITION_CONTENT;
			}

			$sql = "
					select
						".$primaryResource['key']." as id,
						location_rs as location,
						proposedFor_rs as proposedFor,
						validationsRefused_rs as validationsRefused,
						editions_rs as editions
					from
						".$primaryResource['tableName']."_edited,
						resources,
						resourceStatuses
					where
						".$primaryResource['key']." = '".$itemID."'
						and ".$primaryResource['resource']." = id_res
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

					$language = $user->getLanguage();

					$item = CMS_module::getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, RESOURCE_EDITION_LOCATION, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("locationChange"), false, $this->_codename));
						$validation->setValidationLabel($language->getMessage($this->getModuleValidationLabel("locationChangeOfResource"), false, $this->_codename)." ".$item->{$this->_resourceNameMethod}());
						$validation->setValidationShortLabel($item->{$this->_resourceNameMethod}());
						if ($this->_resourcePrevizFile) {
							$validation->addHelpUrl($language->getMessage($this->getModuleValidationLabel("URLPreviz"), false, $this->_codename),
									PATH_ADMIN_MODULES_WR."/".$this->_codename."/".$this->_resourcePrevizFile.".php?item=".$id);
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

					$item = CMS_module::getResourceByID($id);
					$validation = new CMS_resourceValidation($this->_codename, $editions, $item);
					if (!$validation->hasError()) {
						$validation->setValidationTypeLabel($language->getMessage($this->getModuleValidationLabel("edition"), false, $this->_codename));
						$validation->setValidationLabel($language->getMessage($this->getModuleValidationLabel("editionOfResource"), false, $this->_codename)." ".$item->{$this->_resourceNameMethod}());
						$validation->setValidationShortLabel($item->{$this->_resourceNameMethod}());
						if ($this->_resourcePrevizFile) {
							$validation->addHelpUrl($language->getMessage($this->getModuleValidationLabel("URLPreviz"), false, $this->_codename),
										PATH_ADMIN_MODULES_WR."/".$this->_codename."/".$this->_resourcePrevizFile."?item=".$id);
	                    }
					    $validation->setEditorsStack($item->getEditorsStack());
						return $validation;
					} else {
						return false;
					}
				}

			} elseif ($q->getNumRows() ==0) {
				return false;
			} else {
				$this->setError("Can't have more than one item for a given ID");
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	  * Process the module validations : here, calls the parent function but before :
	  *
	  * @param CMS_resourceValidation $resourceValidation The resource validation to process
	  * @param integer $result The result of the validation process. See VALIDATION_OPTION constants
	  * @return boolean true on success, false on failure to process
	  * @access public
	  */
	public function processValidation($resourceValidation, $result, $lastValidation = true)
	{
		if (!is_a($resourceValidation, "CMS_resourceValidation")) {
			$this->setError("ResourceValidation is not a valid CMS_resourceValidation object");
			return false;
		}
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			//call the parent function
			if (!parent::processValidation($resourceValidation, $result)) {
				return false;
			}
		}
		return true;
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
	protected static function _changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly = false)
	{
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			if (!parent::_changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly)) {
				return false;
			}
			foreach($this->_resourceInfo as $tableName => $tableInfo) {
				//move the data
				CMS_modulesCatalog::moveResourceData($this, $tableName, $tableInfo['key'], $resource->getID(), $locationFrom, $locationTo, $copyOnly);
			}
		}
	}

	/**
	  * Get the module message constants
	  *
	  * @param string, the constant name to get
	  * @return the constant value
	  * @access public
	  */
	public function getModuleValidationLabel($label)
	{
		$labels = array(
			"edition" 					=> constant("MESSAGE_MOD_".io::strtoupper($this->getCodename())."_VALIDATION_EDITION"),
			"editionOfResource" 		=> constant("MESSAGE_MOD_".io::strtoupper($this->getCodename())."_VALIDATION_EDITION_OFRESOURCE"),
			"URLPreviz" 				=> constant("MESSAGE_MOD_".io::strtoupper($this->getCodename())."_URL_PREVIZ"),
			"locationChange"			=> constant("MESSAGE_MOD_".io::strtoupper($this->getCodename())."_VALIDATION_LOCATIONCHANGE"),
			"locationChangeOfResource" 	=> constant("MESSAGE_MOD_".io::strtoupper($this->getCodename())."_VALIDATION_LOCATIONCHANGE_OFRESOURCE")
		);

		if ($labels[$label]) {
			return $labels[$label];
		} else {
			$this->setError("Unknown label or constant not set : ".$label);
			return false;
		}
	}

	/**
	  * Get the module primary resource infos (the first record of $this->_resourceInfo table)
	  *
	  * @return array
	  * @access public
	  */
	public function getPrimaryResourceInfo()
	{
		if (is_array($this->_resourceInfo) && $this->_resourceInfo) {
			$resourceTables = array_keys($this->_resourceInfo);
			return array 	(
							'tableName' => $resourceTables[0],
							'key' 		=> $this->_resourceInfo[$resourceTables[0]]['key'],
							'resource'	=> $this->_resourceInfo[$resourceTables[0]]['resource']
							);
		} else {
			return false;
		}
	}
}
?>