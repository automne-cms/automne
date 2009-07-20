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
// $id: $

/**
  * Class CMS_resourceValidationInfo
  *
  * represent a resource validation. Contains a reference to the resource moduleID and the resource itself.
  * It is passed from the kernel to the moduleIDs for workflow purposes
  *
  * @package CMS
  * @subpackage workflow
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resourceValidationInfo extends CMS_grandFather
{
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
	  * The resource DB ID to be validated
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_resourceID;
	
	/**
	  * The validation options. May contain one or more of 
	  * VALIDATION_OPTION_ACCEPT, VALIDATION_OPTION_REFUSE, VALIDATION_OPTION_TRANSFER
	  *
	  * @var integer
	  * @access protected
	  */
	protected $_validationOptions;
	
	/**
	  * Constructor. Caution ! Only the mandatory properties are passed here, but many others are needed to
	  * provide a readable validation.
	  *
	  * @param string $moduleCodename the codename of the module the resource belongs to
	  * @param integer $editions the editions concerned by the validation
	  * @param integer $resourceID the resourceID to be validated
	  * @return void
	  * @access public
	  */
	function __construct($moduleCodename, $editions, $resourceID)
	{
		$this->_validationOptions = VALIDATION_OPTION_ACCEPT + VALIDATION_OPTION_REFUSE + VALIDATION_OPTION_TRANSFER;
		$this->_moduleCodename = $moduleCodename;
		$this->_editions = $editions;
		$this->_resourceID = $resourceID;
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
	  * Get the array of VALIDATION_OPTIONs
	  *
	  * @return aray(integer=>integer) The validation options constants indexed by message ID
	  * @access public
	  */
	function getAllValidationOptions()
	{
		return array(	CMS_resourceValidation::MESSAGE_VALIDATION_ACCEPT	=> VALIDATION_OPTION_ACCEPT,
						CMS_resourceValidation::MESSAGE_VALIDATION_REFUSE	=> VALIDATION_OPTION_REFUSE,
						CMS_resourceValidation::MESSAGE_VALIDATION_TRANSFER	=> VALIDATION_OPTION_TRANSFER);
	}
}
 
?>