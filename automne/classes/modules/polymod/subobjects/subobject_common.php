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
// $Id: subobject_common.php,v 1.2 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_subobject_common
  *
  * represent common stuff for CMS_subobject_{type}
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

abstract class CMS_subobject_common extends CMS_grandFather
{
	/**
	  * string DB id
	  * @var integer
	  * @access private
	  */
	protected $_ID;

	/**
	  * object reference ID
	  * @var integer
	  * @access private
	  */
	protected $_objectID;

	/**
	  * field ID of CMS_object_field reference
	  * @var integer
	  * @access private
	  */
	protected $_objectFieldID;

	/**
	  * subField ID of CMS_object_{object} reference
	  * @var integer
	  * @access private
	  */
	protected $_objectSubFieldID;

	/**
	  * mixed Value
	  * @var mixed
	  * @access private
	  */
	protected $_value;

	/**
	  * Public or edited datas
	  * @var boolean
	  * @access private
	  */
	protected $_public;

	/**
	  * db table name
	  * @var string
	  * @access private
	  */
	protected $_table;

	/**
	  * all constructor values
	  * @var array('string dbFieldName' => 'value')
	  * @access private
	  */
	protected $_constructorValues;

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
	function __construct($id = 0, $objectIDs = array(), $dbValues=array(), $public = false)
	{
		//Set public values
		$this->_public = $public;
		$datas = array();
		if ($id && !$dbValues && !$objectIDs) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer : ".$id);
				return;
			}
			$sql = "
				select
					*
				from
					".$this->getTableName()."
				where
					id='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$datas = $q->getArray();
			} else {
				$this->setError("Unknown ID :".$id);
				return;
			}
		} elseif (!$dbValues && is_array($objectIDs) && $objectIDs) {
			if (!SensitiveIO::isPositiveInteger($objectIDs['objectID'])) {
				$this->setError("ObjectID is not a positive integer : ".$objectIDs['objectID']);
				return;
			}
			if (!SensitiveIO::isPositiveInteger($objectIDs['objectFieldID'])) {
				$this->setError("ObjectFieldID is not a positive integer : ".$objectIDs['objectFieldID']);
				return;
			}
			if (!SensitiveIO::isPositiveInteger($objectIDs['objectSubFieldID'])) {
				$this->setError("ObjectSubFieldID is not a positive integer : ".$objectIDs['objectSubFieldID']);
				return;
			}
			$sql = "
				select
					*
				from
					".$this->getTableName()."
				where
					objectID = '".$objectIDs['objectID']."'
					and objectFieldID = '".$objectIDs['objectFieldID']."'
					and objectSubFieldID = '".$objectIDs['objectSubFieldID']."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$datas = $q->getArray();
			} else {
				$this->setError("Unknown objectIDs :".print_r($objectIDs,true));
				return;
			}
		} elseif (is_array($dbValues) && $dbValues) {
			$datas = $dbValues;
		}
		if (is_array($datas) && $datas) {
			//save constructor values for post treatment if needed
			$this->_constructorValues = $datas;
			
			$this->_ID = (int) $datas['id'];
			$this->_objectID = (int) $datas['objectID'];
			$this->_objectFieldID = (int) $datas['objectFieldID'];
			$this->_objectSubFieldID = (int) $datas['objectSubFieldID'];
			$this->_value = $datas['value'];
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
		return $this->_ID;
	}
	
	/**
	  * Gets the DB object ID of the instance.
	  *
	  * @return integer the DB object id
	  * @access public
	  */
	function getObjectID()
	{
		return $this->_objectID;
	}
	
	/**
	  * Gets the DB object field ID of the instance.
	  *
	  * @return integer the DB object field id
	  * @access public
	  */
	function getObjectFieldID()
	{
		return $this->_objectFieldID;
	}
	
	/**
	  * Gets the DB object subfield ID of the instance.
	  *
	  * @return integer the DB object subfield id
	  * @access public
	  */
	function getObjectSubFieldID()
	{
		return $this->_objectSubFieldID;
	}
	
	/**
	  * Sets the DB object ID of the instance.
	  *
	  * @param integer $objectID the DB object id to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setObjectID($objectID)
	{
		if (!sensitiveIO::IsPositiveInteger($objectID)) {
			$this->setError("ObjectID must be a positive integer :".$objectID);
			return false;
		}
		$this->_objectID = $objectID;
		return true;
	}
	
	/**
	  * Sets the DB object Unique ID of the instance.
	  *
	  * @param integer $objectUniqueID the DB object Unique id to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setObjectFieldID($objectFieldID)
	{
		if (!is_numeric($objectFieldID)) {
			$this->setError("ObjectFieldID must be an integer :".$objectFieldID);
			return false;
		}
		$this->_objectFieldID = $objectFieldID;
		return true;
	}
	
	/**
	  * Sets the DB object Unique ID of the instance.
	  *
	  * @param integer $objectUniqueID the DB object Unique id to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setObjectSubFieldID($objectSubFieldID)
	{
		if (!is_numeric($objectSubFieldID)) {
			$this->setError("ObjectSubFieldID must be an integer :".$objectSubFieldID);
			return false;
		}
		$this->_objectSubFieldID = $objectSubFieldID;
		return true;
	}
	
	/**
	  * Sets the DB object definitions (objectID, fieldID, subFieldID).
	  *
	  * @param integer $fieldDefinition the DB object definition array("objectID" => integer, "fieldID" => integer, "subFieldID" => integer)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDefinition($fieldDefinition) {
		if ($this->setObjectID($fieldDefinition['objectID'])
			&& $this->setObjectFieldID($fieldDefinition['fieldID'])
			&& $this->setObjectSubFieldID($fieldDefinition['subFieldID'])) {
			return true;
		}
		return false;
	}
	
	/**
	  * Gets the current DB table name
	  *
	  * @return string the DB table name
	  * @access public
	  */
	function getTableName()
	{
		return $this->_table . (($this->_public) ? '_public':'_edited');
	}
	
	/**
	  * Gets the string value.
	  *
	  * @return string the string value
	  * @access public
	  */
	function getValue()
	{
		return $this->_value;
	}
	
	/**
	  * Writes the subobject into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if ($this->_public) {
			$this->setError("Can't write public object");
			return false;
		}
		
		//save data
		$sql_fields = "
			objectID='".SensitiveIO::sanitizeSQLString($this->_objectID)."',
			objectFieldID='".SensitiveIO::sanitizeSQLString($this->_objectFieldID)."',
			objectSubFieldID='".SensitiveIO::sanitizeSQLString($this->_objectSubFieldID)."',
			value='".SensitiveIO::sanitizeSQLString($this->_value)."'
		";
		
		if ($this->_ID) {
			$sql = "
				update
					".$this->getTableName()."
				set
					".$sql_fields."
				where
					id='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					".$this->getTableName()."
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->setError("Can't save object");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}
		return true;
	}
	
	/**
	  * Destroy this object, in DB and filesystem if needed
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy() {
		if ($this->_public) {
			$this->setError("Resource is public, read-only !");
			return false;
		}
		
		//delete DB record
		if ($this->_ID) {
			$sql = "
				delete from
					".$this->getTableName()."
				where
					id='".$this->_ID."'
			";
			$q = new CMS_query($sql);
		}
		//finally destroy object instance
		unset($this);
		return true;
	}
}

?>