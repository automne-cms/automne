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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: resource.php,v 1.3 2009/03/02 11:29:53 sebastien Exp $

/**
  * Class CMS_resource
  *
  * represent a resource. Can be either a page or a module resource.
  *
  * @package CMS
  * @subpackage workflow
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resource extends CMS_grandFather
{
	const MESSAGE_RESOURCE_LINK_TYPE_NONE = 208;
	const MESSAGE_RESOURCE_LINK_TYPE_INTERNAL = 209;
	const MESSAGE_RESOURCE_LINK_TYPE_EXTERNAL = 210;
	const MESSAGE_RESOURCE_LINK_TYPE_FILE = 191;
	
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * Status of the resource.
	  * @var CMS_resourceStatus
	  * @access private
	  */
	protected $_status;

	/**
	  * Stack of editors, i.e. users that edited the resource.
	  * @var CMS_stack
	  * @access private
	  */
	protected $_editors;

	/**
	  * Constructor.
	  * initializes the resource if the id is given
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function CMS_resource($id=0)
	{
		if ($id) {
			if (SensitiveIO::isPositiveInteger($id)) {
				$sql = "
					select
						*
					from
						resources,
						resourceStatuses
					where
						id_res='$id'
						and status_res=id_rs
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$this->_id = $id;
					$this->_status = new CMS_resourceStatus($data);
					if ($this->_status->hasError()) {
						$this->raiseError("Unfound status :".$data["status_res"]);
						return;
					}
					
					//build editors stack. If stack is malformed, it's a minor error, so proceed.
					$this->_editors = new CMS_stack();
					if (!$this->_editors->setTextDefinition($data["editorsStack_res"])) {
						$this->raiseError("Editors stack malformed");
						$this->_editors->emptyStack();
					}
				} else {
					$this->raiseError("Unknown ID :".$id);
				}
			} elseif (is_array($id)) {
				$data = $id;
				$this->_id = $data["id_res"];
				$this->_status = new CMS_resourceStatus($data);
				if ($this->_status->hasError()) {
					$this->raiseError("Unfound status :".$data["status_res"]);
					return;
				}
				
				//build editors stack. If stack is malformed, it's a minor error, so proceed.
				$this->_editors = new CMS_stack();
				if (!$this->_editors->setTextDefinition($data["editorsStack_res"])) {
					$this->raiseError("Editors stack malformed");
					$this->_editors->emptyStack();
				}
			} else {
				$this->raiseError("Id is not a positive integer nor array");
				return;
			}
		} else {
			$this->_status = new CMS_resourceStatus();
			$this->_editors = new CMS_stack();
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
		return $this->_id;
	}
	
	/**
	  * Gets the locksmith data of a lock placed on the resource.
	  *
	  * @return integer the locksmithData : DB ID of the user who placed the lock
	  * @access public
	  */
	function getLock()
	{
		return $this->_status->getLock();
	}
	
	/**
	  * Gets the locksmith data of a lock placed on the resource.
	  *
	  * @return integer the locksmithData : DB ID of the user who placed the lock
	  * @access public
	  */
	function getLockDate()
	{
		return $this->_status->getLockDate();
	}
	
	/**
	  * Locks the page. Takes the user DB ID and place it as locksmith data. Impossible if resource is already locked.
	  *
	  * @param CMS_profile_user $user The user placing the lock
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function lock(&$user)
	{
		return $this->_status->lock($user);
	}
	
	/**
	  * Unlocks the page. No checks done here.
	  *
	  * @return void
	  * @access public
	  */
	function unlock()
	{
		return $this->_status->unlock();
	}
	
	/**
	  * Gets the status
	  *
	  * @return CMS_resourceStatus The resource status
	  * @access public
	  */
	function getStatus()
	{
		return $this->_status;
	}
	
	/**
	  * Add an edition.
	  *
	  * @param integer $edition the edition to add
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function addEdition($edition, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Edition addition didn't received a valid user");
			return false;
		}
		if ($this->_status->addEdition($edition)) {
			//add the user to the editors if not present with the same edition
			$found = false;
			$elements = $this->_editors->getElements();
			foreach ($elements as $element) {
				if ($element[0] == $user->getUserID() && $element[1] == $edition) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$this->_editors->add($user->getUserID(), $edition);
			}
			
			//remove the validationRefused for this edition (CONTENT and BASE-DATA are linked)
			$this->_status->delValidationRefused($edition);
			if ($edition == RESOURCE_EDITION_BASEDATA) {
				$this->_status->delValidationRefused(RESOURCE_EDITION_CONTENT);
			}
			if ($edition == RESOURCE_EDITION_CONTENT) {
				$this->_status->delValidationRefused(RESOURCE_EDITION_BASEDATA);
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Add an edition to the validation refused
	  *
	  * @param integer $edition the edition to add
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function addValidationRefused($edition)
	{
		if ($this->_status->addValidationRefused($edition)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Validates an edition. Sets the status as validated if it's a content validation.
	  *
	  * @param integer $edition the edition to validate
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function validateEdition($edition)
	{
		if ($this->_status->delEdition($edition)) {
			$this->_editors->delAllWithOneValue($edition, 2);
			if ($edition == RESOURCE_EDITION_CONTENT) {
				$this->_status->setValidated();
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Cancel all the editions on the resource
	  *
	  * @return void
	  * @access public
	  */
	function cancelAllEditions()
	{
		$this->_status->delAllEditions();
		$this->resetEditorsStack();
	}
	
	/**
	  * Get the editors for an edition, or all the editors if no edition given.
	  *
	  * @param integer $edition We want the editors that edited this edition, or all if it's set to false
	  * @return array(CMS_profile_user) The users, or an empty array if none found
	  * @access public
	  */
	function getEditors($edition = false)
	{
		if ($edition) {
			$usersIDs =  $this->_editors->getElementsWithOneValue($edition, 2);
		} else {
			$usersIDs =  $this->_editors->getElements();
		}
		
		$users = array();
		foreach ($usersIDs as $userID) {
			$user = CMS_profile_usersCatalog::getByID($userID[0]);
			if (is_a($user, 'CMS_profile_user') && !$user->hasError()) {
				$users[] = $user;
			}
		}
		return $users;
	}
	
	/**
	  * Get the editors stack
	  *
	  * @return CMS_stack The users stack
	  * @access public
	  */
	function getEditorsStack()
	{
		return $this->_editors;
	}
	
	/**
	  * Resets the editors stack to an empty stack
	  *
	  * @return void
	  * @access public
	  */
	function resetEditorsStack()
	{
		$this->_editors = new CMS_stack();
	}
	
	/**
	  * Get the resource publication status
	  *
	  * @return integer the resource publication
	  * @access public
	  */
	function getPublication()
	{
		return $this->_status->getPublication();
	}
	
	/**
	  * Get the resource location
	  *
	  * @return integer the resource location
	  * @access public
	  */
	function getLocation()
	{
		return $this->_status->getLocation();
	}
	
	/**
	  * Gets the proposedFor location
	  *
	  * @return integer the location
	  * @access public
	  */
	function getProposedLocation()
	{
		return $this->_status->getProposedFor();
	}
	
	/**
	  * Set the proposedFor location of the resource. Also add the editor who proposed the location.
	  *
	  * @param integer $location the location to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setProposedLocation($location, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		
		if (is_object($this->_status) && $this->_status->setProposedFor($location)) {
			//add the edition
			$this->_status->addEdition(RESOURCE_EDITION_LOCATION);
			//add the user to the editors
			$this->_editors->add($user->getUserID(), RESOURCE_EDITION_LOCATION);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Remove the proposed location. Also removes the editors who proposed the location.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function removeProposedLocation()
	{
		
		$this->_status->setProposedFor(0);
		$this->_editors->delAllWithOneValue(RESOURCE_EDITION_LOCATION, 2);
		
		//remove the edition
		$this->_status->delEdition(RESOURCE_EDITION_LOCATION);
		
		//remove any validations refused
		$this->_status->delValidationRefused(RESOURCE_EDITION_LOCATION);
	}
	
	/**
	  * Validate the location proposition of the resource (proposedFor attribute).
	  *
	  * @return void
	  * @access public
	  */
	function validateProposedLocation()
	{
		if ($this->_status->setLocation($this->_status->getProposedFor())
			&& $this->_status->setProposedFor(0)) {
			$this->validateEdition(RESOURCE_EDITION_LOCATION);
		}
	}
	
	/**
	  * Does the resource has a proposed location outside of userspace ?
	  *
	  * @return boolean true if the resource may move out of user space soon (proposedFor attribute)
	  * @access public
	  */
	function isProposedForOutsideUserspace()
	{
		return $this->_status->getProposedFor(RESOURCE_LOCATION_ARCHIVED)
			|| $this->_status->getProposedFor(RESOURCE_LOCATION_DELETED);
	}
	
	/**
	  * Set the publication dates of the resource.
	  *
	  * @param CMS_date $start the publication start to set
	  * @param CMS_date $end the publication end to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setPublicationDates($start, $end)
	{
		return $this->_status->setPublicationDateStart($start)
			&& $this->_status->setPublicationDateEnd($end);
	}
	
	/**
	  * Gets the publication date start.
	  *
	  * @return CMS_date the publication date start.
	  * @access public
	  */
	function getPublicationDateStart()
	{
		return $this->_status->getPublicationDateStart();
	}
	
	/**
	  * Gets the publication date end.
	  *
	  * @return CMS_date the publication date end.
	  * @access public
	  */
	function getPublicationDateEnd()
	{
		return $this->_status->getPublicationDateEnd();
	}
	
	/**
	  * Totally destroys the resource from persistence. Also destroys the status.
	  *
	  * @return void
	  * @access public
	  */
	function destroy()
	{
		if ($this->_id) {
			//destroy the resource status
			$this->_status->destroy();
			
			$sql = "
				delete
				from
					resources
				where
					id_res='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		unset($this);
	}
	
	/**
	  * Writes the resource into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$this->_status->writeToPersistence();
		$sql_fields = "
			status_res='".$this->_status->getID()."',
			editorsStack_res='".SensitiveIO::sanitizeSQLString($this->_editors->getTextDefinition())."'
		";
		if ($this->_id) {
			$sql = "
				update
					resources
				set
					".$sql_fields."
				where
					id_res='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					resources
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		return true;
	}
	
	/**
	  * Returns an array of all the available link types
	  * Static function
	  *
	  * @return array(integer=>integer) The link types indexed by their translation messages DB ID
	  * @access public
	  */
	function getAllLinkTypes()
	{
		return array(	self::MESSAGE_RESOURCE_LINK_TYPE_NONE		=> RESOURCE_LINK_TYPE_NONE,
						self::MESSAGE_RESOURCE_LINK_TYPE_INTERNAL	=> RESOURCE_LINK_TYPE_INTERNAL,
						self::MESSAGE_RESOURCE_LINK_TYPE_EXTERNAL	=> RESOURCE_LINK_TYPE_EXTERNAL,
						self::MESSAGE_RESOURCE_LINK_TYPE_FILE		=> RESOURCE_LINK_TYPE_FILE);
	}
	
	/**
	  * Returns an array of all the available resource data locations
	  * Static function
	  *
	  * @return array(integer) The Data locations
	  * @access public
	  */
	function getAllDataLocations()
	{
		return array(	RESOURCE_DATA_LOCATION_EDITED,
						RESOURCE_DATA_LOCATION_EDITION,
						RESOURCE_DATA_LOCATION_PUBLIC,
						RESOURCE_DATA_LOCATION_ARCHIVED,
						RESOURCE_DATA_LOCATION_DELETED,
						RESOURCE_DATA_LOCATION_DEVNULL);
	}
}
?>
