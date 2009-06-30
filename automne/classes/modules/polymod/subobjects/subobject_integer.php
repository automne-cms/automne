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
// $Id: subobject_integer.php,v 1.2 2009/06/30 08:55:57 sebastien Exp $

/**
  * Class CMS_subobject_integer
  *
  * represent an integer
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_subobject_integer extends CMS_subobject_common
{
	/**
	  * db table name
	  * @var string
	  * @access private
	  */
	protected $_table = 'mod_subobject_integer';

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
		if ($this->_constructorValues['value'] && !is_numeric($this->_constructorValues['value'])) {
			$this->_value='';
			$this->raiseError("Setting a non-integer for integer value : ".$this->_constructorValues['value']);
			return;
		}
	}
	
	/**
	  * Sets the integer value.
	  *
	  * @param integer $value the integer value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($value)
	{
		if (!is_null($value) && !is_numeric($value)) {
			$this->raiseError("Setting a non-integer for integer value : ".$value);
			return false;
		}
		$this->_value = $value;
		return true;
	}
	
	/**
	  * Gets the string value.
	  *
	  * @return string the string value
	  * @access public
	  */
	function getValue()
	{
		return (int) $this->_value;
	}
}
?>