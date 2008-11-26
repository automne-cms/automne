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
// $id: $

/**
  * Class CMS_resourceValidation
  *
  * represent a resource validation. Contains a reference to the resource moduleID and the resource itself.
  * It is passed from the kernel to the moduleIDs for workflow purposes
  *
  * @package CMS
  * @subpackage workflow
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resourceValidation extends CMS_grandFather
{
	/**
	  * Validation persistence timeout, in minutes. All validations stored in persistence older than this amount will be deleted.
	  * Default : 100 minutes
	  */
	const VALIDATION_PERSISTENCE_TIMEOUT = 100;
	/**
	  * The DB id of the resourceValidation object.
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_id;
	
	/**
	  * The module the validation belongs to, its codename
	  *
	  * @var string
	  * @access protected
	  */
	protected $_moduleCodename;
	
	/**
	  * The editions concerned by the validation. May be empty (validation of the prioritary proposedFor location).
	  * It's a sum of RESOURCE_EDITION constants
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_editions;
	
	/**
	  * The internal type of validation label for the module.
	  *
	  * @var string
	  * @access protected
	  */
	protected $_validationTypeLabel;
	
	/**
	  * The resource DB ID to be validated
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_resourceID;
	
	/**
	  * The resource status
	  *
	  * @var CMS_resourceStatus
	  * @access protected
	  */
	protected $_status;
	
	/**
	  * The label shown to the user.
	  *
	  * @var string
	  * @access protected
	  */
	protected $_validationLabel;
	
	/**
	  * The short label shown to the user.
	  *
	  * @var string
	  * @access protected
	  */
	protected $_validationShortLabel;
	
	/**
	  * The validation options. May contain one or more of 
	  * VALIDATION_OPTION_ACCEPT, VALIDATION_OPTION_REFUSE, VALIDATION_OPTION_TRANSFER
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_validationOptions;
	
	/**
	  * An array of help URLs that will be proposed to the user to guide the validation process.
	  * (examples : previz, => (location in node tree, target))
	  * 
	  *
	  * @var array(string=>array(string,string)) An associative array where the label is the key, and the url the value.
	  * @access protected
	  */
	protected $_helpURLs = array();
	
	/**
	  * The editors stack : a CMS_stack array of all the users ids who provoked the validation (i.e. modified the resource).
	  *
	  * @var CMS_stack
	  * @access protected
	  */
	protected $_editorsStack = false;
	
	/**
	  * Constructor. Caution ! Only the mandatory properties are passed here, but many others are needed to
	  * provide a readable validation.
	  *
	  * @param string $moduleCodename the codename of the module the resource belongs to
	  * @param integer $editions the editions concerned by the validation
	  * @param CMS_resource $resource the resource to be validated
	  * @return void
	  * @access public
	  */
	function __construct($moduleCodename, $editions, &$resource)
	{
		//validation tests
		if (!is_a($resource, "CMS_resource")) {
			$this->raiseError("Resource must be a valid CMS_resource object");
			return;
		}
		$this->_validationOptions = VALIDATION_OPTION_ACCEPT + VALIDATION_OPTION_REFUSE + VALIDATION_OPTION_TRANSFER;
		$this->_moduleCodename = $moduleCodename;
		$this->_editions = $editions;
		$this->_resourceID = $resource->getID();
		$this->_status = $resource->getStatus();
	}
	
	/**
	  * Removes a validation option from the possibilities.
	  *
	  * @param integer $option the value of an option
	  * @return void
	  * @access public
	  */
	function removeValidationOption($option)
	{
		if ($this->_validationOptions & $option) {
			$this->_validationOptions -= $option;
		}
	}
	
	/**
	  * Tests for the presence of a validation option
	  *
	  * @param integer $option the value of an option to test for
	  * @return true if it's part of the current options, false otherwise
	  * @access public
	  */
	function hasValidationOption($option)
	{
		if ($this->_validationOptions & $option) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Data access method : get the validation id
	  *
	  * @return integer the validation id (from DB for old system or from validation Infos for the new one)
	  * @access public
	  */
	function getID()
	{
		if (!$this->_id) {
			if (!$this->_constructValidationID()) {
				$this->writeToPersistence();
			}
		}
		return $this->_id;
	}
	
	/**
	  * Data access method : set the DB id
	  *
	  * @param integer $id The ID to set
	  * @return void
	  * @access public
	  */
	function setID($id)
	{
		$this->_id = $id;
	}
	
	/**
	  * Construct the validation ID
	  * Validation must have module codename, editions and resourceID set
	  * The module mus have getValidationByID function to properly decode the created ID
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _constructValidationID()
	{
		if ($this->_moduleCodename && $this->_editions && $this->_resourceID) {
			$module = CMS_modulesCatalog::getByCodename($this->_moduleCodename);
			if (method_exists($module, "getValidationByID")) {
				$this->_id = base64_encode($this->_moduleCodename.'||'.$this->_editions.'||'.$this->_resourceID);
				return true;
			} else {
				return false;
			}
		} else {
			$this->raiseError("Can't construct ID, missing datas");
			return false;
		}
	}
	
	/**
	  * Data access method : get the moduleCodename
	  *
	  * @return string the module codename
	  * @access public
	  */
	function getModuleCodename()
	{
		return $this->_moduleCodename;
	}
	
	/**
	  * Data access method : get the label
	  *
	  * @return string the label
	  * @access public
	  */
	function getValidationLabel()
	{
		return $this->_validationLabel;
	}
	
	/**
	  * Data access method : get the short label if exist
	  *
	  * @return string the short label
	  * @access public
	  */
	function getValidationShortLabel()
	{
		return ($this->_validationShortLabel) ? $this->_validationShortLabel:$this->_validationLabel;
	}
	
	/**
	  * Data access method : set the validation label
	  *
	  * @param string $label the label of the validation
	  * @return boolean true on success to set it, false otherwise.
	  * @access public
	  */
	function setValidationLabel($label)
	{
		$this->_validationLabel = SensitiveIO::sanitizeHTMLString($label);
		return true;
	}
	
	/**
	  * Data access method : set the validation short label
	  *
	  * @param string $label the short label of the validation
	  * @return boolean true on success to set it, false otherwise.
	  * @access public
	  */
	function setValidationShortLabel($label)
	{
		$this->_validationShortLabel = SensitiveIO::sanitizeHTMLString($label);
		return true;
	}
	
	/**
	  * Data access method : get the help URLs
	  *
	  * @return array(string=>string) the help URLs
	  * @access public
	  */
	function getHelpURLs()
	{
		return $this->_helpURLs;
	}
	
	/**
	  * Data access method : add an URL to the help URLs array
	  *
	  * @param string $label the URL label
	  * @param string $url the URL itself
          * @param string $url the target for this URL, _blank if not given
	  * @return boolean true on success to set it, false otherwise.
	  * @access public
	  */
	function addHelpURL($label, $url='', $target="_blank", $js = '')
	{
		$label = SensitiveIO::sanitizeHTMLString($label);
		$url = SensitiveIO::sanitizeHTMLString($url);
		$target = SensitiveIO::sanitizeHTMLString($target);
		$this->_helpURLs[] = array($label, $url, $target, $js);
		return true;
	}
	
	/**
	  * Data access method : get the editions concerned by the validation
	  *
	  * @return integer the sum of REOURCE_EDITION constants
	  * @access public
	  */
	function getEditions()
	{
		return $this->_editions;
	}
	
	/**
	  * Data access method : get the validation type label
	  *
	  * @return integer the internal type of validation label (module-wide range)
	  * @access public
	  */
	function getValidationTypeLabel()
	{
		return $this->_validationTypeLabel;
	}
	
	/**
	  * Data access method : set the validation type label
	  *
	  * @param string $label the label of the internal type
	  * @return boolean true on success to set it, false otherwise.
	  * @access public
	  */
	function setValidationTypeLabel($label)
	{
		$this->_validationTypeLabel = SensitiveIO::sanitizeHTMLString($label);
		return true;
	}
	
	/**
	  * Data access method : get the id of the resource
	  *
	  * @return integer the internal id of the resource (module-wide range)
	  * @access public
	  */
	function getResourceID()
	{
		return $this->_resourceID;
	}
	
	/**
	  * Data access method : get the resource object
	  *
	  * @return CMS_resource The resource object, i.e. the subclassed resource object. Return false on failure to retrieve it.
	  * @access public
	  */
	function getResource()
	{
		if ($module = CMS_modulesCatalog::getByCodename($this->_moduleCodename)) {
			return $module->getResourceByID($this->_resourceID);
		} else {
			return false;
		}
	}
	
	/**
	  * Data access method : get the status representation HTML string
	  *
	  * @param boolean $tinyOutput If set to true, returns a compact version of the representation.
	  * @return string the status HTML representation
	  * @access public
	  */
	function getStatusRepresentation($tinyOutput = false, $user=false, $modCodeName=false, $resourceID=false)
	{
		return $this->_status->getHTML($tinyOutput, $user, $modCodeName, $resourceID);
	}
	
	/**
	  * Data access method : get the editors stack
	  *
	  * @return CMS_stack the users ids stack.
	  * @access public
	  */
	function getEditorsStack()
	{
		return $this->_editorsStack;
	}
	
	/**
	  * Data access method : set the editors stack.
	  *
	  * @param CMS_stack $stack the users stack.
	  * @return boolean true on success to set it, false otherwise.
	  * @access public
	  */
	function setEditorsStack($stack)
	{
		if (!is_a($stack, "CMS_stack")) {
			$this->raiseError("Stack is not a CMS_stack");
			return false;
		} else {
			$this->_editorsStack = $stack;
			return true;
		}
	}
	
	/**
	  * cleans the table of the validations older than self::VALIDATION_PERSISTENCE_TIMEOUT.
	  *
	  * @access public
	  */
	function cleanOldValidations ()
	{
		//cleans old validations
		$timeOut=self::VALIDATION_PERSISTENCE_TIMEOUT * 60;
		
		$sql = "
			delete from
				resourceValidations
			where
				unix_timestamp(creationDate_rv) < ".(time()-$timeOut)."
		";
		
		$q = new CMS_query($sql);
		
	}
	
	/**
	  * Writes the object instance into persistance.
	  *
	  * @return integer the DB id of the inserted validation.
	  * @access public
	  */
	function writeToPersistence()
	{
		//insert this one into persistence : first insert key data
		$sql = "
			insert into
				resourceValidations
			set
				module_rv='".$this->_moduleCodename."',
				editions_rv='".$this->_editions."',
				resourceID_rv='".$this->_resourceID."'
		";
		$q = new CMS_query($sql);
		
		$this->_id = $q->getLastInsertedID();
		
		//then update with serialized string, which now will contain the id		
		$sql = "
			update
				resourceValidations
			set
				serializedObject_rv='".addslashes(serialize($this))."'
			where
				id_rv='".$this->_id."'
		";
		$q = new CMS_query($sql);
	}
	
	/**
	  * Get the array of VALIDATION_OPTIONs
	  *
	  * @return aray(integer=>integer) The validation options constants indexed by message ID
	  * @access public
	  */
	function getAllValidationOptions()
	{
		return array(	MESSAGE_VALIDATION_ACCEPT	=> VALIDATION_OPTION_ACCEPT,
						MESSAGE_VALIDATION_REFUSE	=> VALIDATION_OPTION_REFUSE,
						MESSAGE_VALIDATION_TRANSFER	=> VALIDATION_OPTION_TRANSFER);
	}
}
 
?>