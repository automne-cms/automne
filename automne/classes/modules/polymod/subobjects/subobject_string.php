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
// $Id: subobject_string.php,v 1.3 2010/03/08 16:43:36 sebastien Exp $

/**
  * Class CMS_subobject_string
  *
  * represent a string
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_subobject_string extends CMS_subobject_common
{
	/**
	  * db table name
	  * @var string
	  * @access private
	  */
	protected $_table = 'mod_subobject_string';

	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $id DB id
	  * @param array $objectIDs DB object values : array('objectID' => integer, 'objectFieldID' => integer, 'objectSubFieldID' => integer)
	  * @param array $dbValues DB values array('string dbFieldName' => 'value')
	  * @param boolean $public values are public or edited ? (default is edited)
	  * @return void
	  * @access public
	  */
	function __construct($id = 0, $objectIDs = array(), $dbValues = array(), $public = false)
	{
		parent::__construct($id, $objectIDs, $dbValues, $public);
		
		//add some complementary checks on values
		if ($this->_constructorValues['value'] && io::strlen($this->_constructorValues['value']) > 255) {
			$this->_value='';
			$this->raiseError("Setting a too long string for string value : max 255 cars, set : ".io::strlen($this->_constructorValues['value']));
			return;
		}
	}
	
	/**
	  * Sets the string value.
	  *
	  * @param string $value the string value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($value)
	{
		//add some complementary checks on values
		if ($value && io::strlen($value) > 255) {
			$this->raiseError("Setting a too long string for string value : max 255 cars, set : ".io::strlen($value));
			return false;
		}
		
		$this->_value = $value;
		return true;
	}
}

?>