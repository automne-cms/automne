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
// $Id: record.php,v 1.3 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_record
  * 
  * Represents a record (value) associated to a field
  * Each form is made of some fields an their values posted by users
  * 
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_record extends CMS_grandFather {

	/**
	 * Unique db ID
	 * @var integer
	 * @access private
	 */
	protected $_recordID;
	
	/**
	 * The field this record refers to
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_fieldID;
	
	/**
	 * The sending this record was part of
	 * 
	 * @var integer
	 * @access private
	 */
	protected $_senderID;
	
	/**
	 * Value given by user
	 * 
	 * @var string
	 * @access private
	 */
	protected $_value;
	
	/**
	 * Date this record was posted
	 * 
	 * @var CMS_date
	 * @access private
	 */
	protected $_dateInserted;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param integer $id
	 * @return void 
	 */
	function __construct($id = 0) {
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					mod_cms_forms_records
				where
					id_rec='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_recordID = $id;
				$this->_fieldID = $data["field_rec"];
				$this->_senderID = $data["sending_rec"];
				$this->_value = $data["value_rec"];
			} else {
				$this->raiseError("Unknown ID :".$id);
			}
		}
	}
	
	/**
	  * Getter for the ID
	 * @access public
	 * @return integer
	 */
	function getID() {
		return $this->_recordID;
	}
	
	/**
	 * Getter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name
	 * @return string
	 */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	 * Setter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name name of attribute to set
	 * @param $value , the value to give
	 */
	function setAttribute($name, $value) {
		$name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	  * Writes the news into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			sending_rec='".SensitiveIO::sanitizeSQLString($this->_senderID)."',
			field_rec='".SensitiveIO::sanitizeSQLString($this->_fieldID)."',
			value_rec='".SensitiveIO::sanitizeSQLString($this->_value)."'";
		if ($this->_recordID) {
			$sql = "
				update
					mod_cms_forms_records
				set
					".$sql_fields."
				where
					id_rec='".$this->_recordID."'
			";
		} else {
			$sql = "
				insert into
					mod_cms_forms_records
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Failed to write");
			return false;
		} elseif (!$this->_recordID) {
			$this->_recordID = $q->getLastInsertedID();
		}
		return true;
	}
}
?>