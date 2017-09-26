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
// $Id: modulesCodes.php,v 1.2 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_modulesCodes
  *
  * represent all modules codes processing.
  *
  * @package Automne
  * @subpackage modules
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_modulesCodes extends CMS_grandFather
{
	/**
	  * The modules codes definition.
	  * @var multidimensional array
	  * @access private
	  */
	protected $_modulesCodes = array();
	
	/**
	  * Automne modules
	  * @var array
	  * @access private
	  */
	protected $_modules = array();
	
	/**
	  * The current treatment mode.
	  * @var integer
	  * @access private
	  */
	protected $_treatmentMode = '';
	
	/**
	  * The current visualization mode.
	  * @var integer
	  * @access private
	  */
	protected $_visualizationMode = '';
	
	/**
	  * The current object treated.
	  * @var object
	  * @access private
	  */
	protected $_treatedObject = '';
	
	/**
	  * Constructor.
	  * initializes object.
	  *
	  * @return void
	  * @access public
	  */
	public function __construct()
	{
		//get all modules
		$this->_modules = CMS_modulesCatalog::getAll("id");
	}
	
	/**
	  * Function to get the modules codes
	  * @param integer $treatmentMode The current treatment mode (see constants on top of this file for accepted values).
	  * @param integer $visualizationMode The current visualization mode, optional (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  *
	  * @return string : the modules codes to add
	  * @access public
	  */
	public function getModulesCodes($treatmentMode, $visualizationMode='', $treatedObject = false, $treatmentParameters = array())
	{
		$this->_treatmentMode = $treatmentMode;
		$this->_visualizationMode = $visualizationMode;
		$this->_treatedObject = &$treatedObject;
		$this->_modulesCodes = array();
		foreach ($this->_modules as $aModule) {
			$this->_modulesCodes = $aModule->getModuleCode($this->_modulesCodes, $this->_treatmentMode, $this->_visualizationMode, $this->_treatedObject, $treatmentParameters);
		}
		return $this->_modulesCodes;
	}
}
?>