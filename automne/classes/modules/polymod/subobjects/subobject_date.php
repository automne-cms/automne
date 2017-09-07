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
// $Id: subobject_date.php,v 1.2 2010/03/08 16:43:36 sebastien Exp $

/**
  * Class CMS_subobject_date
  *
  * represent a date
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_subobject_date extends CMS_subobject_common
{
	/**
	  * db table name
	  * @var string
	  * @access private
	  */
	protected $_table = 'mod_subobject_date';

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
	}
	
	/**
	  * Sets the date value.
	  *
	  * @param integer $value the date value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($value)
	{
		$this->_value = $value;
		return true;
	}
}

?>