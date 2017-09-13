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
// $Id: resourcestatus.php,v 1.8 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_resourceStatus
  *
  * represent a resource status : its life cycle, and edition and validation states
  * Tested OK.
  *
  * @package Automne
  * @subpackage workflow
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resourceStatus extends CMS_grandFather {
	const MESSAGE_STATUS_LOCKED = 1320;
	const MESSAGE_STATUS_DRAFT = 1421;
	const MESSAGE_STATUS_LOCKEDBY = 321;
	
	const MESSAGE_RESOURCE_PUBLICATION_NEVERVALIDATED = 4;
	const MESSAGE_RESOURCE_PUBLICATION_VALIDATED = 5;
	const MESSAGE_RESOURCE_PUBLICATION_PUBLIC = 6;
	
	const MESSAGE_RESOURCE_EDITION_BASEDATA = 7;
	const MESSAGE_RESOURCE_EDITION_CONTENT = 8;
	const MESSAGE_RESOURCE_EDITION_SIBLINGSORDER = 9;
	const MESSAGE_RESOURCE_EDITION_LOCATION = 41;
	const MESSAGE_RESOURCE_EDITION_MOVE = 592;
	
	const MESSAGE_RESOURCE_LOCATION_USERSPACE = 13;
	const MESSAGE_RESOURCE_LOCATION_ARCHIVED = 14;
	const MESSAGE_RESOURCE_LOCATION_DELETED = 15;
	const MESSAGE_RESOURCE_LOCATION_EDITION = 205;
	
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * Location of the resource. See constants.
	  * @var integer
	  * @access private
	  */
	protected $_location = RESOURCE_LOCATION_USERSPACE;

	/**
	  * Where is this resource going (See location constants)
	  * @var integer
	  * @access private
	  */
	protected $_proposedFor = false;

	/**
	  * Editions made on the resource. Addition of all editions in one variable. See constants.
	  * @var array(integer)
	  * @access private
	  */
	protected $_editions = false;

	/**
	  * Validations refused. Concern editions made. All added in one variable. See constants.
	  * @var array(integer)
	  * @access private
	  */
	protected $_validationsRefused = false;

	/**
	  * Publication status. See constants
	  * @var integer
	  * @access private
	  */
	protected $_publication = RESOURCE_PUBLICATION_NEVERVALIDATED;

	/**
	  * Publication Date, start.
	  * @var CMS_date
	  * @access private
	  */
	protected $_publicationDateStart;

	/**
	  * Publication Date, end.
	  * @var CMS_date
	  * @access private
	  */
	protected $_publicationDateEnd;
	
	/**
	  * Edited Publication Date, start.
	  * @var CMS_date
	  * @access private
	  */
	protected $_publicationDateStartEdited;

	/**
	  * Edited Publication Date, end.
	  * @var CMS_date
	  * @access private
	  */
	protected $_publicationDateEndEdited;

	/**
	  * resource locksmith status
	  * @var integer : the user id which lock the resource or false if not locked
	  * @access private
	  */
	protected $_lockStatus;
	protected $_lockDate;
	
	/**
	  * resource draft status
	  * @var boolean
	  * @access private
	  */
	protected $_draft = false;
	
	/**
	  * Constructor.
	  * initializes the resourceStatus if the id is given
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function __construct($id=0)
	{
		if ($id) {
			if (SensitiveIO::isPositiveInteger($id)) {
				$sql = "
					select
						*
					from
						resourceStatuses
					where
						id_rs='$id'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$this->_id = $id;
					$this->_location = $data["location_rs"];
					$this->_proposedFor = $data["proposedFor_rs"];
					$this->_editions = $data["editions_rs"];
					$this->_validationsRefused = $data["validationsRefused_rs"];
					$this->_publicationDateStart = new CMS_date();
					$this->_publicationDateStart->setFromDBValue($data["publicationDateStart_rs"]);
					$this->_publicationDateEnd = new CMS_date();
					$this->_publicationDateEnd->setFromDBValue($data["publicationDateEnd_rs"]);
					$this->_publicationDateStartEdited = new CMS_date();
					$this->_publicationDateStartEdited->setFromDBValue($data["publicationDateStartEdited_rs"]);
					$this->_publicationDateEndEdited = new CMS_date();
					$this->_publicationDateEndEdited->setFromDBValue($data["publicationDateEndEdited_rs"]);
					$this->_publication = $data["publication_rs"];
					//We must adjust the publication because of the publication dates
					$this->_adjustPublication();
				} else {
					$this->setError("Unknown ID :".$id);
				}
			} elseif (is_array($id)) {
				$data=$id;
				$this->_id = $data["status_res"];
				$this->_location = $data["location_rs"];
				$this->_proposedFor = $data["proposedFor_rs"];
				$this->_editions = $data["editions_rs"];
				$this->_validationsRefused = $data["validationsRefused_rs"];
				$this->_publicationDateStart = new CMS_date();
				$this->_publicationDateStart->setFromDBValue($data["publicationDateStart_rs"]);
				$this->_publicationDateEnd = new CMS_date();
				$this->_publicationDateEnd->setFromDBValue($data["publicationDateEnd_rs"]);
				$this->_publicationDateStartEdited = new CMS_date();
				$this->_publicationDateStartEdited->setFromDBValue($data["publicationDateStartEdited_rs"]);
				$this->_publicationDateEndEdited = new CMS_date();
				$this->_publicationDateEndEdited->setFromDBValue($data["publicationDateEndEdited_rs"]);
				$this->_publication = $data["publication_rs"];
				//We must adjust the publication because of the publication dates
				$this->_adjustPublication();
			} else {
				$this->setError("Id is not a positive integer");
				return;
			}
		} else {
			$this->_publicationDateStart = new CMS_date();
			$this->_publicationDateEnd = new CMS_date();
			$this->_publicationDateStartEdited = new CMS_date();
			$this->_publicationDateEndEdited = new CMS_date();
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
	  * Set the draft of the instance.
	  *
	  * @param boolean $draft : the instance draft status to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDraft($draft) {
		$this->_draft = ($draft) ? true : false;
		return true;
	}
	
	/**
	  * Get the draft of the instance.
	  *
	  * @return boolean : the draft status
	  * @access public
	  */
	function getDraft() {
		return $this->_draft;
	}
	
	/**
	  * Gets the location
	  *
	  * @return integer The resource location
	  * @access public
	  */
	function getLocation()
	{
		return $this->_location;
	}
	
	/**
	  * Sets the location.
	  *
	  * @param integer $location the location to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setLocation($location)
	{
		if (SensitiveIO::isInSet($location, $this->getAllLocations())) {
			$this->_location = $location;
			return true;
		} else {
			$this->setError("Unknown location : ".$location);
			return false;
		}
	}
	
	/**
	  * Gets the proposedFor location.
	  *
	  * @return integer The proposedFor location.
	  * @access public
	  */
	function getProposedFor()
	{
		return $this->_proposedFor;
	}
	
	/**
	  * Sets the proposedFor location.
	  *
	  * @param integer $location the proposedFor location to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setProposedFor($location)
	{
		if (SensitiveIO::isInSet($location, $this->getAllLocations()) || $location === 0) {
			$this->_proposedFor = $location;
			return true;
		} else {
			$this->setError("Unknown location for proposedFor : ".$location);
			return false;
		}
	}
	
	/**
	  * Gets the editions done on the resource.
	  *
	  * @return integer The editions, all added in one integer.
	  * @access public
	  */
	function getEditions()
	{
		return $this->_editions;
	}
	
	/**
	  * Has the resource edition parameter been done on it ?
	  *
	  * @param integer $edition The edition to test for
	  * @return boolean true if the edition was made on the resource, false otherwise
	  * @access public
	  */
	function hasEdition($edition)
	{
		if ($this->_editions & $edition) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Add an edition.
	  *
	  * @param integer $edition the edition to add
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	public function addEdition($edition)
	{
		if (SensitiveIO::isInSet($edition, CMS_resourceStatus::getAllEditions())) {
			if (!$this->hasEdition($edition)) {
				$this->_editions += $edition;
			}
			return true;
		} else {
			$this->setError("Unknown edition : ".$edition);
			return false;
		}
	}
	
	/**
	  * Deletes an edition.
	  *
	  * @param integer $edition the edition to del
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function delEdition($edition)
	{
		if (SensitiveIO::isInSet($edition, CMS_resourceStatus::getAllEditions())) {
			if ($this->hasEdition($edition)) {
				$this->_editions -= $edition;
			}
			return true;
		} else {
			$this->setError("Unknown edition : ".$edition);
			return false;
		}
	}
	
	/**
	  * Deletes all editions.
	  *
	  * @return void
	  * @access public
	  */
	function delAllEditions()
	{
		$this->_editions = 0;
	}
	
	/**
	  * Sets all editions.
	  *
	  * @param integer $allEditions
	  * @return void
	  * @access public
	  */
	function setAllEditions($allEditions)
	{
		if (SensitiveIO::isPositiveInteger($allEditions)) {
			$this->_editions = $allEditions;
		}
	}
	
	/**
	  * Has the resource edition parameter been refused by a validator on it ?
	  *
	  * @param integer $edition The edition to test for
	  * @return boolean true if the validations refused contains the edition, false otherwise
	  * @access public
	  */
	function hasValidationRefused($edition)
	{
		if ($this->_validationsRefused & $edition) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Get validations Refused .
	  *
	  * @return array(integer)
	  * @access public
	  */
	function getValidationRefused()
	{
		return	$this->_validationsRefused;
	}
	
	/**
	  * Add a Validation refused.
	  *
	  * @param integer $edition the edition to add
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function addValidationRefused($edition)
	{
		if (SensitiveIO::isInSet($edition, CMS_resourceStatus::getAllEditions())) {
			if (!$this->hasValidationRefused($edition)) {
				$this->_validationsRefused += $edition;
			}
			return true;
		} else {
			$this->setError("Unknown edition : ".$edition);
			return false;
		}
	}
	
	/**
	  * Deletes an edition off the validations refused.
	  *
	  * @param integer $edition the edition to del from the validations refused
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function delValidationRefused($edition)
	{
		if (SensitiveIO::isInSet($edition, CMS_resourceStatus::getAllEditions())) {
			if ($this->hasValidationRefused($edition)) {
				$this->_validationsRefused -= $edition;
			}
			return true;
		} else {
			$this->setError("Unknown edition : ".$edition);
			return false;
		}
	}
	
	/**
	  * Sets all validations refused.
	  *
	  * @param integer $allEditions
	  * @return void
	  * @access public
	  */
	function setAllValidationsRefused($allEditions)
	{
		if (SensitiveIO::isPositiveInteger($allEditions)) {
			$this->_validationsRefused = $allEditions;
		}
	}
	
	/**
	  * Gets the publication status of the resource.
	  *
	  * @return integer The publication status.
	  * @access public
	  */
	function getPublication()
	{
		return $this->_publication;
	}
	
	/**
	  * Sets the publication status to RESOURCE_PUBLICATION_VALIDATED.
	  * If the publication dates fits, auto-set it to RESOURCE_PUBLICATION_PUBLIC
	  *
	  * @return void
	  * @access public
	  */
	function setValidated()
	{
		$this->_publication = RESOURCE_PUBLICATION_VALIDATED;
		$this->_adjustPublication();
	}
	
	/**
	  * Sets the publication status by hand. Beware ! This function should be used only be the log to create fake resource statuses !
	  *
	  * @param integer $status The status to set
	  * @return void
	  * @access public
	  */
	function setPublication($status)
	{
		$this->_publication = $status;
	}
	
	/**
	  * Adjust the publication status according to publication dates.
	  *
	  * @return void
	  * @access public
	  */
	protected function _adjustPublication()
	{
		$now = new CMS_date();
		$now->setNow(true);
		
		//set public if validated and into the "window" of publication and located inside userspace
		if ($this->_publication == RESOURCE_PUBLICATION_VALIDATED
			&& CMS_date::compare($this->_publicationDateStart, $now, "<=")
			&& (CMS_date::compare($this->_publicationDateEnd, $now, ">=") || $this->_publicationDateEnd->isNull())
			&& $this->_location == RESOURCE_LOCATION_USERSPACE) {
			$this->_publication = RESOURCE_PUBLICATION_PUBLIC;
			if ($this->_id) {
				$this->writeToPersistence();
			}
		}

		//set validated if public and no validation pending on basedata and out of the "window" of publication or located outside userspace
		if ($this->_publication == RESOURCE_PUBLICATION_PUBLIC
			&& $this->_editions != RESOURCE_EDITION_BASEDATA
			&& (CMS_date::compare($this->_publicationDateStart, $now, ">")
				|| (CMS_date::compare($this->_publicationDateEnd, $now, "<") 
					&& !$this->_publicationDateEnd->isNull()))) {
			$this->_publication = RESOURCE_PUBLICATION_VALIDATED;
			if ($this->_id) {
				$this->writeToPersistence();
			}
		}
	}
	
	/**
	  * Gets the publication date start.
	  *
	  * @return CMS_date the publication date start.
	  * @access public
	  */
	function getPublicationDateStart($public = true)
	{
		return $public ? $this->_publicationDateStart : $this->_publicationDateStartEdited;
	}
	
	/**
	  * Sets the publication date start.
	  *
	  * @param CMS_date $date the publication date to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setPublicationDateStart($date)
	{
		if (is_a($date, "CMS_date")) {
			$this->_publicationDateStartEdited = $date;
			$this->_adjustPublication();
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the publication date end.
	  *
	  * @return CMS_date the publication date end.
	  * @access public
	  */
	function getPublicationDateEnd($public = true)
	{
		return $public ? $this->_publicationDateEnd : $this->_publicationDateEndEdited;
	}
	
	/**
	  * Sets the publication date end.
	  *
	  * @param CMS_date $date the publication date to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setPublicationDateEnd($date)
	{
		if (is_a($date, "CMS_date")) {
			$this->_publicationDateEndEdited = $date;
			$this->_adjustPublication();
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Validate the publication dates range
	  *
	  * @return void
	  * @access public
	  */
	function validatePublicationDates() {
		$this->_publicationDateStart = $this->_publicationDateStartEdited;
		$this->_publicationDateEnd = $this->_publicationDateEndEdited;
	}
	
	/**
	  * Gets the publication range : from xx/xx/xxxx to xx/xx/xxxx (last is replaced by "++" if not defined)
	  *
	  * @param string $userLanguage The user language
	  * @return string The publication range
	  * @access public
	  */
	function getPublicationRange($userLanguage, $public = true)
	{
		if ($public) {
			$this->_publicationDateStart->setFormat($userLanguage->getDateFormat());
			$this->_publicationDateEnd->setFormat($userLanguage->getDateFormat());
			$text = $this->_publicationDateStart->getLocalizedDate();
			$text .= " ".$userLanguage->getMessage(MESSAGE_DATE_TO)." ";
			if ($ld = $this->_publicationDateEnd->getLocalizedDate()) {
				$text .= $ld;
			} else {
				$text .= "++";
			}
		} else {
			$this->_publicationDateStartEdited->setFormat($userLanguage->getDateFormat());
			$this->_publicationDateEndEdited->setFormat($userLanguage->getDateFormat());
			$text = $this->_publicationDateStartEdited->getLocalizedDate();
			$text .= " ".$userLanguage->getMessage(MESSAGE_DATE_TO)." ";
			if ($ld = $this->_publicationDateEndEdited->getLocalizedDate()) {
				$text .= $ld;
			} else {
				$text .= "++";
			}
		}
		return $text;
	}
	
	/**
	  * Gets the locksmith data of a lock placed on the resource.
	  *
	  * @return integer the locksmithData : DB ID of the user who placed the lock
	  * @access public
	  */
	function getLock()
	{
		if (!isset($this->_lockStatus)) {
			$sql = "
				select
					locksmithData_lok
				from
					locks
				where
					resource_lok = '".$this->_id."'
			";
			$q = new CMS_query($sql);
			$this->_lockStatus = ($q->getNumRows()) ? $q->getValue("locksmithData_lok") : false;
		}
		return $this->_lockStatus;
	}
	
	/**
	  * Gets the locksmith date of a lock placed on the resource.
	  *
	  * @return CMS_date the locksmithData : date where the lock was placed
	  * @access public
	  */
	function getLockDate()
	{
		if (!isset($this->_lockDate) || !is_object($this->_lockDate)) {
			$this->_lockDate = new CMS_date();
			$sql = "
				select
					date_lok
				from
					locks
				where
					resource_lok = '".$this->_id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$this->_lockDate->setFromDBValue($q->getValue("date_lok"));
			}
		}
		return $this->_lockDate;
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
		if ($this->getLock()) {
			return false;
		}
		$this->_lockDate = new CMS_date();
		$this->_lockDate->setNow();
		$sql = "
			insert into
				locks
			set
				resource_lok = '".$this->_id."',
				locksmithData_lok = '".$user->getUserID()."',
				date_lok = '".$this->_lockDate->getDBValue()."'
		";
		$q = new CMS_query($sql);
		//set object lock status
		$this->_lockStatus = $user->getUserID();
		return true;
	}
	
	/**
	  * Unlocks the page. No checks done here.
	  *
	  * @return void
	  * @access public
	  */
	function unlock()
	{
		$sql = "
			delete from
				locks
			where
				resource_lok = '".$this->_id."'
		";
		$q = new CMS_query($sql);
		$this->_lockStatus = false;
		$this->_lockDate = false;
	}
	
	/**
	  * Returns the HTML representation of the status, available in tiny form.
	  *
	  * @param boolean $tiny If set to true, returns the tiny version of the images.
	  * @param CMS_profile_user $user : current user (used to check validation rights)
	  * @param string $modCodeName : resource module codename (used to provide simple access to validation on status click)
	  * @param integer $resourceID : resource Id (used to provide simple access to validation on status click)
	  * @param boolean $checkLock : does it need to check lock status on resource (used for standard module only for now)
	  * @return string HTML data
	  * @access public
	  */
	function getHTML($tiny = false, $user=false, $modCodeName=false, $resourceID=false, $checkLock = true, $withQTip = true)
	{
		$modified = false;
		//Hack : check for non-sense status (usually it is a page which creation is not properly done)
		if ($this->_publication == RESOURCE_PUBLICATION_NEVERVALIDATED && !$this->_editions) {
			$this->addEdition(RESOURCE_EDITION_CONTENT, $user);
			$this->writeToPersistence();
		}
		$img_status = ($this->_publication == RESOURCE_PUBLICATION_NEVERVALIDATED) ? "rond" : "carre";
		
		if ($this->_publication == RESOURCE_PUBLICATION_PUBLIC) {
			$img_status .= "_pub";
		}
		
		if ($this->_proposedFor == RESOURCE_LOCATION_DELETED) {
			$img_status .= "_sup";
			$modified=true;
		}
		if ($this->_proposedFor == RESOURCE_LOCATION_ARCHIVED) {
			$img_status .= "_arc";
			$modified=true;
		}
		
		if (($this->_editions & RESOURCE_EDITION_BASEDATA || $this->_editions & RESOURCE_EDITION_CONTENT) 
			&& !($this->_validationsRefused & RESOURCE_EDITION_BASEDATA)
			&& !($this->_validationsRefused & RESOURCE_EDITION_CONTENT)) {
			$img_status .= "-o";
			$modified=true;
		} elseif ($this->_validationsRefused & RESOURCE_EDITION_BASEDATA 
			|| $this->_validationsRefused & RESOURCE_EDITION_CONTENT
			|| $this->_validationsRefused & RESOURCE_EDITION_LOCATION) {
			$img_status .= "-r";
			$modified=false;
		} else {
			$img_status .= "-v";
		}
		
		if ($this->_editions & RESOURCE_EDITION_SIBLINGSORDER) {
			if ($this->_validationsRefused & RESOURCE_EDITION_SIBLINGSORDER) {
				//$img_siblings = "orderefuse";
			} else {
				$img_siblings = "ordervalider";
				$modified=true;
			}
		}
		if ($this->_editions & RESOURCE_EDITION_MOVE) {
			if ($this->_validationsRefused & RESOURCE_EDITION_MOVE) {
				//$img_siblings = "mouvrefuse";
			} else {
				$img_siblings = "mouvalider";
				$modified=true;
			}
		}
		
		$img_dir = ($tiny) ? "/status/tiny" : "/status";
		
		if ($this->getDraft() && $img_status == 'rond-o') {
			$img_status = 'draft';
		}
		
		$label = $this->_getStatusLabel($img_status);
		$label.= (isset($img_siblings)) ? ', '.$this->_getStatusLabel($img_siblings):'';
		
		//create link for validation if can
		//$hrefStart = $hrefEnd = '';
		$onclick = '';
		if ($modCodeName && $resourceID && $modified) {
			if (!is_a($user, "CMS_profile_user")) {
				$this->setError("User is not a valid CMS_profile_user object");
			} elseif ($img_status != 'draft') {
				if ($modCodeName != MOD_STANDARD_CODENAME) {
					//if its a module
					if ($user->hasValidationClearance($modCodeName)) {
						//TODOV4 : check for validation categories clearance
						$onclick = ' onclick="Automne.utils.getValidationByID(this, \''.$modCodeName.'\', \''.$resourceID.'\');" style="cursor:pointer;"';
					}
				} else {
					//if its the standard module
					if ($user->hasPageClearance($resourceID, CLEARANCE_PAGE_EDIT) && $user->hasValidationClearance($modCodeName)) {
						$onclick = ' onclick="Automne.utils.getValidationByID(this, \''.$modCodeName.'\', \''.$resourceID.'\');" style="cursor:pointer;"';
					}
				}
			}
		}
		if ($checkLock && $this->getLock()) {
			global $cms_language;
			if ($lockUserId = $this->getLock()) {
				$lockUser = CMS_profile_usersCatalog::getById($lockUserId);
				$lockDate = $this->getLockDate();
				if (is_object($lockUser) && is_object($lockDate)) {
					$label .= ' - '.$cms_language->getMessage(self::MESSAGE_STATUS_LOCKEDBY).' '.$lockUser->getFullName().' ('.$lockDate->getLocalizedDate($cms_language->getDateFormat().' - H:i:s').')';
				} else {
					$label .= ' - '.$cms_language->getMessage(self::MESSAGE_STATUS_LOCKED);
				}
			}
			$lock = '<img src="'.PATH_ADMIN_IMAGES_WR.'/lock.gif" class="atm-status-lock" />';
		} else {
			$lock = '';
		}
		$draft = '';
		if ($this->getDraft()) {
            global $cms_language;
            $label .= ($img_status != 'draft') ? ' - '.$cms_language->getMessage(self::MESSAGE_STATUS_DRAFT) : $cms_language->getMessage(self::MESSAGE_STATUS_DRAFT);
            if ($img_status != 'draft') {
                if ($tiny) {
                    $draft = '<img src="'.PATH_ADMIN_IMAGES_WR.'/draft.gif" class="atm-status-draft" />';
                } else {
                    $draft = '<img src="'.PATH_ADMIN_IMAGES_WR.'/draft.gif" class="atm-status-draft" />';
                }
            }
        }
		$class = ($tiny) ? "atm-status-tiny" : "atm-status";
		//create a unique class name for this status to allow search for
		$uniqueClassName = ($modCodeName && $resourceID) ? $this->getStatusId($modCodeName, $resourceID) : '';
		$qtip = ($withQTip) ? ' ext:qtip="'.$label.'"' : '';
		$html = '<span class="'.$class.' '.$uniqueClassName.'"'.$onclick.'>'.$lock.$draft.'<img'.$qtip.' src="'.PATH_ADMIN_IMAGES_WR.$img_dir."/".$img_status.'.gif" />';
		if (isset($img_siblings)) {
			$html .= '<img src="'.PATH_ADMIN_IMAGES_WR.$img_dir."/".$img_siblings.'.gif" class="atm-status-siblings" />';
		}
		$html .= '</span>';
		return $html;
	}
	
	/**
	  * Returns the label for current status.
	  *
	  * @param CMS_language $language : Current language to get label
	  * @return string label
	  * @access public
	  */
	function getStatusLabel($language)
	{
		//Hack : check for non-sense status (usually it is a page which creation is not properly done)
		if ($this->_publication == RESOURCE_PUBLICATION_NEVERVALIDATED && !$this->_editions) {
			$this->addEdition(RESOURCE_EDITION_CONTENT, $user);
			$this->writeToPersistence();
		}
		$img_status = ($this->_publication == RESOURCE_PUBLICATION_NEVERVALIDATED) ? "rond" : "carre";
		if ($this->_publication == RESOURCE_PUBLICATION_PUBLIC) {
			$img_status .= "_pub";
		}
		if ($this->_proposedFor == RESOURCE_LOCATION_DELETED) {
			$img_status .= "_sup";
		}
		if ($this->_proposedFor == RESOURCE_LOCATION_ARCHIVED) {
			$img_status .= "_arc";
		}
		if (($this->_editions & RESOURCE_EDITION_BASEDATA || $this->_editions & RESOURCE_EDITION_CONTENT) 
			&& !($this->_validationsRefused & RESOURCE_EDITION_BASEDATA)
			&& !($this->_validationsRefused & RESOURCE_EDITION_CONTENT)) {
			$img_status .= "-o";
		} elseif ($this->_validationsRefused & RESOURCE_EDITION_BASEDATA 
			|| $this->_validationsRefused & RESOURCE_EDITION_CONTENT
			|| $this->_validationsRefused & RESOURCE_EDITION_LOCATION) {
			$img_status .= "-r";
		} else {
			$img_status .= "-v";
		}
		if ($this->_editions & RESOURCE_EDITION_SIBLINGSORDER) {
			if ($this->_validationsRefused & RESOURCE_EDITION_SIBLINGSORDER) {
				$img_siblings = "orderefuse";
			} else {
				$img_siblings = "ordervalider";
			}
		}
		if ($this->_editions & RESOURCE_EDITION_MOVE) {
			if ($this->_validationsRefused & RESOURCE_EDITION_MOVE) {
				$img_siblings = "mouvrefuse";
			} else {
				$img_siblings = "mouvalider";
			}
		}
		if ($this->getDraft() && $img_status == 'rond-o') {
			$img_status = 'draft';
		}
		$label = $this->_getStatusLabel($img_status);
		$label.= (isset($img_siblings)) ? ', '.$this->_getStatusLabel($img_siblings):'';
		
		if ($lockUserId = $this->getLock()) {
			$lockUser = CMS_profile_usersCatalog::getById($lockUserId);
			$lockDate = $this->getLockDate();
			if (is_object($lockUser) && is_object($lockDate)) {
				$label .= ' - '.$language->getMessage(self::MESSAGE_STATUS_LOCKEDBY).' '.$lockUser->getFullName().' ('.$lockDate->getLocalizedDate($language->getDateFormat().' - H:i:s').')';
			} else {
				$label .= ' - '.$language->getMessage(self::MESSAGE_STATUS_LOCKED);
			}
		}
		if ($this->getDraft()) {
            $label .= ($img_status != 'draft') ? ' - '.$language->getMessage(self::MESSAGE_STATUS_DRAFT) : $language->getMessage(self::MESSAGE_STATUS_DRAFT);
        }
		/*if ($this->getDraft() && $img_status == 'rond-o') {
			$label .= $language->getMessage(self::MESSAGE_STATUS_DRAFT);
		}*/
		return $label;
	}
	
	/**
	  * Get the status id for this resource
	  * @param string $modCodeName : resource module codename (used to provide simple access to validation on status click)
	  * @param integer $resourceID : resource Id (used to provide simple access to validation on status click)
	  *
	  * @return void
	  * @access public
	  */
	function getStatusId($module, $resourceId) {
		return 'status-'.$module.'-'.$resourceId;
	}
	
	/**
	  * Totally destroys the resource status from persistence.
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
					resourceStatuses
				where
					id_rs='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		$this->__destroy();
	}
	
	/**
	  * Writes the resourceStatus into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		//first adjust publication and start publication date
		$this->_adjustPublication();
		if ($this->_publicationDateStart->isNull()) {
			$this->_publicationDateStart->setNow();
		}
		
		$sql_fields = "
			location_rs='".SensitiveIO::sanitizeSQLString($this->_location)."',
			proposedFor_rs='".SensitiveIO::sanitizeSQLString($this->_proposedFor)."',
			editions_rs='".SensitiveIO::sanitizeSQLString($this->_editions)."',
			validationsRefused_rs='".SensitiveIO::sanitizeSQLString($this->_validationsRefused)."',
			publication_rs='".SensitiveIO::sanitizeSQLString($this->_publication)."',
			publicationDateStart_rs='".$this->_publicationDateStart->getDBValue()."',
			publicationDateEnd_rs='".$this->_publicationDateEnd->getDBValue()."',
			publicationDateStartEdited_rs='".$this->_publicationDateStartEdited->getDBValue()."',
			publicationDateEndEdited_rs='".$this->_publicationDateEndEdited->getDBValue()."'
		";
		if ($this->_id) {
			$sql = "
				update
					resourceStatuses
				set
					".$sql_fields."
				where
					id_rs='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					resourceStatuses
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
	  * Gets the array of all the locations.
	  * Static function.
	  *
	  * @return array(integer=>integer) All the locations indexed by their message DB ID
	  * @access public
	  */
	public static function getAllLocations()
	{
		return array(
			self::MESSAGE_RESOURCE_LOCATION_USERSPACE	=> RESOURCE_LOCATION_USERSPACE,
			self::MESSAGE_RESOURCE_LOCATION_EDITION		=> RESOURCE_LOCATION_EDITION,
			self::MESSAGE_RESOURCE_LOCATION_ARCHIVED	=> RESOURCE_LOCATION_ARCHIVED,
			self::MESSAGE_RESOURCE_LOCATION_DELETED		=> RESOURCE_LOCATION_DELETED);
	}
	
	/**
	  * Gets the array of all the editions possibly made on a resource.
	  * Static function.
	  *
	  * @return array(integer=>integer) All the editions indexed by their message DB ID
	  * @access public
	  */
	public static function getAllEditions()
	{
		return array(
			self::MESSAGE_RESOURCE_EDITION_BASEDATA			=> RESOURCE_EDITION_BASEDATA,
			self::MESSAGE_RESOURCE_EDITION_CONTENT			=> RESOURCE_EDITION_CONTENT,
			self::MESSAGE_RESOURCE_EDITION_SIBLINGSORDER	=> RESOURCE_EDITION_SIBLINGSORDER,
			self::MESSAGE_RESOURCE_EDITION_LOCATION			=> RESOURCE_EDITION_LOCATION,
			self::MESSAGE_RESOURCE_EDITION_MOVE				=> RESOURCE_EDITION_MOVE);
	}
	
	/**
	  * Gets the array of all the publications.
	  * Static function.
	  *
	  * @return array(integer=>integer) All the publications indexed by their message DB ID
	  * @access public
	  */
	function getAllPublications()
	{
		return array(
			self::MESSAGE_RESOURCE_PUBLICATION_NEVERVALIDATED	=> RESOURCE_PUBLICATION_NEVERVALIDATED,
			self::MESSAGE_RESOURCE_PUBLICATION_VALIDATED		=> RESOURCE_PUBLICATION_VALIDATED,
			self::MESSAGE_RESOURCE_PUBLICATION_PUBLIC			=> RESOURCE_PUBLICATION_PUBLIC);
	}
	
	/**
	  * Gets the message of the given icon status.
	  * @param string, the gif icon name without extension.
	  *
	  * @return string of label message
	  * @access private
	  */
	protected function _getStatusLabel($iconFileName)
	{
		//need to get the global value of $cms_language because it avoid lot of query on cms_user
		global $cms_language;
		
		$statusLabel = array(
			'carre_arc-o' => 1134, //Unpublished page pending archive
			'carre_arc-r' => 1135, //Unpublished page refused archive
			'carre_arc-v' => 1136, //Unpublished page archived
			'carre_pub_arc-o' => 1137, //Page pending archive
			'carre_pub_arc-r' => 1138, //Page refused validation
			'carre_pub_arc-v' => 1139, //Page archived
			'carre_pub_sup-o' => 1140, //Page pending deletion
			'carre_pub_sup-r' => 1141, //Page refused deletion
			'carre_pub_sup-v' => 1142, //Page deleted
			'carre_pub-o' => 1143, //Page modified pending validation
			'carre_pub-r' => 1144, //Page modified refused validation
			'carre_pub-v' => 1145, //Page published
			'carre_sup-o' => 1146, //Unpublished page pending deletion
			'carre_sup-r ' => 1147, //Unpublished page refused deletion
			'carre_sup-v ' => 1148, //Unpublished page deleted
			'carre-o' => 1149, //Page pending un-publication
			'carre-r' => 1150, //Page refused un-publication
			'carre-v' => 1151, //Page unpublished
			'ordervalider' => 1152, //Order of links pending validation
			'orderefuse' => 1153, //Order of links refused validation
			'mouvalider' => 595, //Move of page pending validation
			'mouvrefuse' => 596, //Move of page refused validation
			'rond_arc-o' => 1154, //New page pending archive
			'rond_arc-r' => 1155, //New page refused archive
			'rond_sup-o' => 1156, //New page pending deletion
			'rond_sup-r' => 1157, //New page refused deletion
			'rond-o' => 1158, //New page pending validation
			'rond-r' => 1159, //New page refused validation
		);
		if (isset($statusLabel[$iconFileName]) && $statusLabel[$iconFileName]) {
			//get user language
			return $cms_language->getMessage($statusLabel[$iconFileName]);
		} else {
			return;
		}
	}
}
?>