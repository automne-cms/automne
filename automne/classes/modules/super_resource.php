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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: super_resource.php,v 1.7 2010/03/08 16:43:31 sebastien Exp $

/**
  * General-purpose Class
  *
  * Gathers the most usual functions of an object class for Automne
  *
  * @package Automne
  * @subpackage modules
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * 
  * HOW TO USE THIS CLASS
  * Fillin all class default vars with correspondant database informations
  * change the class name and the constructor name to respect the var $_className value
  * in case of special datatype wich need to be controlled, some switch are present in code to make these controls
  * see the constructor, setString(), setObject() methods
  * A useage example of this file is in the file /automne/classes/modules/superResourceExample.php
  */
  
class CMS_superResource extends CMS_resource
{
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_ID;
	
	/**
	  * Class Name for errors display
	  * @var string
	  * @access private
	  */
	protected $_className;
	
	/**
	  * Table name for sql queries 
	  * if class use resource, Table name must be without _edited, _deleted or _public, only the prefix
	  * @var string
	  * @access private
	  */
	protected $_tableName;
	
	/**
	  * Table id name for sql queries 
	  * @var string
	  * @access private
	  */
	protected $_idName = 'id';
	
	/**
	  * Columns name suffix
	  * @var string
	  * @access private
	  */
	protected $_tableSufix;
	
	/**
	  * the module codename
	  * @var string
	  * @access private
	  */
	protected $_moduleCodename;
	
	/**
	  * Table(s) fieldname and type
	  * /!\ MUST BE IN THE SAME ORDER OF DATABASE COLUMNS /!\
	  * @var multidimentional array (fieldname => array (field_type, field_default_value))
	  *  - fieldname is the database columns name WITHOUT SUFFIX
	  *  - fieldtype can be : 
	  *		resource : internal useage, Automne Resource.
	  *		string : use with getString and setString
	  *		html : use with getString and setString
	  *		email : use with getString and setString
	  *		integer : use with getInteger and setInteger
	  *		positiveInteger : use with getInteger and setInteger
	  *		boolean : use with getBoolean and SetBoolean
	  *		date : use with getTheDate and setDate. Create a CMS_date object. Default value can be used to launch a method of the object.
	  *		image : use with getImagePath and setImage
	  *		file : use with getFilePath and setFile
	  *		order : use with getOrder, setOrder, getOrderMax, moveUp, moveDown, moveTo
	  *		internalLink : use with getLinkType, getLink, setLink 	/!\ fieldname must be internalSomething /!\
	  *		externalLink : use with getLinkType, getLink, setLink 	/!\ fieldname must be externalSomething /!\
	  *		linkType : use with getLinkType, getLink, setLink 		/!\ fieldname must be somethingType 	/!\
	  *		CMS_className : use with getObject and setObject. Default value can be used to launch a method of the object.
	  *  - fielvalue is the default value
	  * @access private
	  */
	protected $_tableData = array();
	
	/**
	  * copy of default $_tableData values
	  * for further comparaisons only
	  */
	protected $_default;
	
	/**
	  * dataType wich be treated by getString() and setString() methods
	  * @var array(), default set to array('string','html','email')
	  * @access private
	  */
	protected $_classString = array('string','html','email');
	
	/**
	  * Constructor.
	  * initializes object if the id is given.
	  *
	  * @param integer $id DB id
	  * @param boolean $public wich type of data (default=false : edited)
	  * @return void
	  * @access public
	  */
	function CMS_superResource($id = 0,$public=false)
	{
		if (!class_exists("CMS_date") || !class_exists("SensitiveIO")) {
			die("CMS_superResource need at least CMS_date and SensitiveIO to run ...");
		}
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer");
				return false;
			}
			if ($this->_hasResource()) {
				$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
			} else {
				$from = $this->_tableName;
			}
			$sql = "
				select 
					*
				from
					".$from."
				where
					".$this->_idName.$this->_tableSufix."='$id'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				
				$data = $q->getArray();
				$this->_ID = $id;
				
				//backup tableData default values
				$this->_default = $this->_tableData;
				
				//all table data
				foreach($this->_tableData as $label => $aData) {
					//here you can verifiy data
					switch($aData[0]) {
						case 'string':
						case 'html':
						case 'email':
						case 'integer':
						case 'positiveInteger':
						case 'boolean':
						case 'image':
						case 'file':
						case 'order':
						case 'internalLink':
						case 'externalLink':
						case 'linkType':
							$this->_tableData[$label][1]=$data[$label.$this->_tableSufix];
						break;
						case 'date':
							$this->_tableData[$label][1] = new CMS_date();
							$this->_tableData[$label][1]->setFromDBValue($data[$label.$this->_tableSufix]);
						break;
						case 'resource':
							//initialize resource-class
							parent::__construct($data[$label.$this->_tableSufix]);
						break;
						default:
							if (class_exists($aData[0])) {
								$this->_tableData[$label][1]=new $aData[0]($data[$label.$this->_tableSufix]);
							} else {
								$this->_tableData[$label][1]=$data[$label.$this->_tableSufix];
							}
						break;
					}
				}
			} else {
				$this->setError("Unknown ID :".$id);
				return false;
			}
		} else {
			$this->_initObjects();
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
	  * Gets the DB type of data.
	  *
	  * @return array() the DB data
	  * @access public
	  */
	function getTableData()
	{
		return $this->_tableData;
	}
	
	/**
	  * Gets the default value of a data.
	  *
	  * @return string the default value of the data
	  * @access public
	  */
	function getDefaultValue($name)
	{
		return $this->_default[$name][1];
	}
	
	/**
	  * if this object use Automne resource ?
	  *
	  * @return boolean true if it use Automne resource, false otherwise
	  * @access private
	  */
	protected function _hasResource() {
		if (isset($this->_tableData['resource'][0]) && $this->_tableData['resource'][0]=='resource') {
			return true;
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='resource') {
					return true;
				}
			}
			return false;
		}
	}
	
	/**
	  * initialise all objects for this resource
	  *
	  * @return boolean true, false otherwise
	  * @access private
	  */
	protected function _initObjects() {
		foreach($this->_tableData as $label => $aData) {
			$method='';
			switch($aData[0]) {
				case 'string':
				case 'html':
				case 'email':
				case 'integer':
				case 'positiveInteger':
				case 'boolean':
				case 'image':
				case 'file':
				case 'order':
				case 'internalLink':
				case 'externalLink':
				case 'linkType':
					//not objects, do nothing
				break;
				case 'resource':
					//initialize resource-class
					parent::__construct($aData[1]);
				break;
				case 'date':
					if ($aData[1]) {
						$method = $aData[1];
					}
					//create CMS_date object
					$this->_tableData[$label][1] = new CMS_date();
					//if object have a default method to lauch and if this method exists then launch it
					if ($method!="" && method_exists($this->_tableData[$label][1],$method)) {
						$this->_tableData[$label][1]->$method();
					}
				break;
				default:
					//create object if class exists
					if (class_exists($aData[0])) {
						if ($aData[1]) {
							$method = $aData[1];
						}
						$this->_tableData[$label][1]=new $aData[0]();
						//if object have a default method to lauch and if this method exists then launch it
						if ($method!="" && method_exists($this->_tableData[$label][1],$method)) {
							$this->_tableData[$label][1]->$method();
						}
					}
				break;
			}
		}
		return true;
	}
	
	/**
	  * Gets a string of the object
	  *
	  * @param string $string The string to return
	  * @return string The wanted string
	  * @access public
	  */
	function getString($string)
	{
		if (in_array($this->_tableData[$string][0],$this->_classString)) {
			return $this->_tableData[$string][1];
		} else {
			$this->setError("Unknown string :".$string);
			return false;
		}
	}
	
	/**
	  * Set a string of the object
	  *
	  * @param string $stringName The string name to set
	  * @param string $stringValue The string value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setString($stringName,$stringValue)
	{
		if (in_array($this->_tableData[$stringName][0],$this->_classString)) {
			//here you can verifiy string data
			switch ($this->_tableData[$stringName][0]) {
				case "email":
                    //null case
                    if(is_null($stringValue)){
                        $this->_tableData[$stringName][1] = null;
                        break;
                    }

					if (!SensitiveIO::isValidEmail($stringValue)) {
						$this->setError("Try to set an uncorrect email format :".$stringValue);
						return false;
					}
				break;
				case "string":
					$stringValue = SensitiveIO::sanitizeHTMLString($stringValue);
				break;
				case "html":
					//$stringValue = $stringValue;
				break;
				default:
					$this->setError("Unknown string or not a string dataType :".$stringName);
					return false;
				break;
			}
			$this->_tableData[$stringName][1]=$stringValue;
			return true;
		} else {
			$this->setError("Unknown string or not a string dataType :".$stringName);
			return false;
		}
	}
	
	/**
	  * Gets a boolean value of the object
	  *
	  * @param string $string The boolean to return
	  * @return boolean The wanted boolean
	  * @access public
	  */
	function getBoolean($boolean)
	{
		if ($this->_tableData[$boolean][0]=="boolean") {
			return ($this->_tableData[$boolean][1]) ? true:false;
		} else {
			$this->setError("Unknown boolean :".$boolean);
			return false;
		}
	}
	
	/**
	  * Set a boolean of the object
	  *
	  * @param string $booleanName The boolean name to set
	  * @param boolean $booleanValue The boolean value to set (0/1/true/false only)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setBoolean($booleanName,$booleanValue)
	{
		if ($this->_tableData[$booleanName][0]=="boolean") {
			if ($booleanValue==1 || $booleanValue===true || $booleanValue==0 || $booleanValue===false) {
				$this->_tableData[$booleanName][1]= ($booleanValue==1 || $booleanValue===true) ? true:false;
				return true;
			} else {
				$this->setError("Invalid boolean value :".$booleanValue);
				return false;
			}
		} else {
			$this->setError("Unknown boolean or not a boolean dataType :".$booleanName);
			return false;
		}
	}
	
	/**
	  * Gets a integer value of the object
	  *
	  * @param string $integer The integer to return
	  * @return integer The wanted integer
	  * @access public
	  */
	function getInteger($integer)
	{
		if (isset($this->_tableData[$integer]) && ($this->_tableData[$integer][0]=="integer" || $this->_tableData[$integer][0]=="positiveInteger")) {
			return $this->_tableData[$integer][1];
		} else {
			$this->setError("Unknown integer :".$integer);
			return false;
		}
	}
	
	/**
	  * Set an integer of the object
	  *
	  * @param string $integerName The integer name to set
	  * @param boolean $integerValue The integer or positiveInteger value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setInteger($integerName,$integerValue)
	{
		if ($this->_tableData[$integerName][0]=="integer" || $this->_tableData[$integerName][0]=="positiveInteger") {
			//null case
			if(is_null($integerValue)){
				$this->_tableData[$integerName][1] = null;
				return true;
			}

			//here you can verifiy string data
			switch ($this->_tableData[$integerName][0]) {
				case "integer":
					if (!(SensitiveIO::isPositiveInteger($integerValue) || $integerValue === 0 || $integerValue === '0' || !$integerValue || (is_numeric($integerValue) && SensitiveIO::isPositiveInteger(abs($integerValue))))) {
					 	$this->setError("Try to set an integer with uncorrect format :".$integerValue);
						return false;
					}
				break;
				case "positiveInteger":
					if (!SensitiveIO::isPositiveInteger($integerValue)) {
						$this->setError("Try to set an uncorrect positiveInteger value :".$integerValue);
						return false;
					}
				break;
				default:
					$this->setError("Unknown integer or not an integer dataType :".$integerName);
					return false;
				break;
			}
			$this->_tableData[$integerName][1]=$integerValue;
			return true;
		} else {
			$this->setError("Unknown integer or not an integer dataType :".$integerName);
			return false;
		}
	}
	
	/**
	  * Gets an object of the object
	  *
	  * @param string $object The object name to return
	  * @return CMS_object The wanted object
	  * @access public
	  */
	function getObject($object)
	{
		if(class_exists($this->_tableData[$object][0])) {
			return $this->_tableData[$object][1];
		} else {
			$this->setError("Unknown object or not a valid class type :".$object);
			return false;
		}
	}
	
	/**
	  * Set an object
	  *
	  * @param string $objectName The string name to set
	  * @param integer or object $objectValue the object ID or the object itself
	  * @param boolean $valueIsObject the type of $objectValue (ID or object) default is false (ID)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setObject($objectName,$objectValue,$valueIsObject=false)
	{
		if(class_exists($this->_tableData[$objectName][0])) {
			if ($valueIsObject) {
				//then test object and set it
				if (is_a($objectValue,$this->_tableData[$objectName][0])) {
					$this->_tableData[$objectName][1]=$objectValue;
					return true;
				} else {
					$this->setError("Object given not match the attempt type :".$this->_tableData[$objectName][0]);
				}
			} else {
				//then instanciate object and set it
				$this->_tableData[$objectName][1]=new $this->_tableData[$objectName][0]($objectValue);
				if (!is_object($this->_tableData[$objectName][1]) || $this->_tableData[$objectName][1]->hasError()) {
					$this->setError("Object not set, data error :".$objectName);
				} else {
					return true;
				}
			}
			return false;
		} else {
			$this->setError("Unknown object or not a valid class type :".$objectName);
			return false;
		}
	}
	
	/**
	  * Get a date object
	  *
	  * @param string $date The date name to return
	  * @return CMS_date The wanted object
	  * @access public
	  */
	function getTheDate($date)
	{
		if(class_exists("CMS_date") && is_a($this->_tableData[$date][1],"CMS_date")) {
			return $this->_tableData[$date][1];
		} else {
			$this->setError("Unknown date or class CMS_date not exist :".$object);
			return false;
		}
	}
	
	/**
	  * Set a date object
	  *
	  * @param string $dateName The date name to set
	  * @param dateValue the object date
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDate($dateName,$dateValue)
	{
		if(class_exists("CMS_date") && is_a($this->_tableData[$dateName][1],"CMS_date")) {
			//then instanciate object and set it
			$this->_tableData[$dateName][1]=$dateValue;
			if (!is_object($this->_tableData[$dateName][1]) || $this->_tableData[$dateName][1]->hasError()) {
				$this->setError("Date not set, data error :".$dateName);
			} else {
				return true;
			}
			return false;
		} else {
			$this->setError("Unknown class CMS_date or not a valid CMS_date type :".$dateName);
			return false;
		}
	}
	
	/**
	  * Get the object Order (search order field then return value)
	  *
	  * @return integer the object order
	  * @access public
	  */
	function getOrder()
	{
		//search order field
		if ($this->_tableData['order'][0]=='order') {
			return $this->_tableData['order'][1];
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='order') {
					return $this->_tableData[$label][1];
				}
			}
			$this->setError("Can not found order field in database");
			return false;
		}
	}
	
	/**
	  * Get the object Order (search order field then return value)
	  *
	  * @return integer the object order
	  * @access public
	  */
	function setOrder($order)
	{
		if (sensitiveIO::isPositiveInteger($order)) {
			//search order field
			if ($this->_tableData['order'][0]=='order') {
				$this->_tableData['order'][1]=$order;
				return true;
			} else {
				foreach($this->_tableData as $label => $aData) {
					if ($aData[0]=='order') {
						$this->_tableData[$label][1]=$order;
						return true;
					}
				}
				$this->setError("Can not found order field in database");
				return false;
			}
		} else {
			$this->setError("Order need to be a positive integer");
			return false;
		}
	}
	
	/**
	  * Get the current max objects Order (search order field then return value)
	  * @param array() $searchConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return integer the max order
	  * @access public
	  */
	function getOrderMax($whereConditions=array(),$public=false)
	{
		//search order field
		if ($this->_tableData['order'][0]=='order') {
			$currentOrder = $this->_tableData['order'][1];
			$orderFieldName = 'order'.$this->_tableSufix;
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='order') {
						$currentOrder = $this->_tableData[$label][1];
						$orderFieldName = $label.$this->_tableSufix;
				}
			}
			$this->setError("Can not found order field in database");
			return false;
		}
		
		//from
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//where clause
		if (count($whereConditions)) {
			$where ="where ";
			$count=0;
			foreach ($whereConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				$where .= " ".$label.$this->_tableSufix."='".SensitiveIO::sanitizeSQLString($condition)."' ";
			}
		}
		
		$sql = "
			select
				count(*),
				max(".$orderFieldName.")
			from
				".$from."
			".$where."
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->setError("Database query error");
			return false;
		} else {
			$max = $q->getarray();
			return $max["max(".$orderFieldName.")"];
		}
	}
	
	/**
	  * Move the current object Order to the top (order-1) (search order field then change it)
	  * @param array() $searchConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function moveUp($whereConditions=array(),$public=false)
	{
		//search order field
		if ($this->_tableData['order'][0]=='order') {
			$currentOrder = $this->_tableData['order'][1];
			$orderFieldName = 'order'.$this->_tableSufix;
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='order') {
						$currentOrder = $this->_tableData[$label][1];
						$orderFieldName = $label.$this->_tableSufix;
				}
			}
			$this->setError("Can not found order field in database");
			return false;
		}
		//if order = 0 then item is at top level then do nothing
		if ($currentOrder== '0') {
			return;
		}
		
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//where clause
		if (count($whereConditions)) {
			$where =" and ";
			$count=0;
			foreach ($whereConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				$where .= " ".$label.$this->_tableSufix."='".SensitiveIO::sanitizeSQLString($condition)."' ";
			}
		}
		
		//select item who take the place of current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".$currentOrder."'
				where
					".$orderFieldName."='".($currentOrder-1)."'
				".$where."
			";
		$q = new CMS_query($sql);
		
		//move current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".($currentOrder-1)."'
				where
					".$this->_idName.$this->_tableSufix."='".$this->getID()."'
			";
		$q = new CMS_query($sql);
		
		return true;
	}
	
	/**
	  * Move the current object Order to the bottom (order+1) (search order field then change it)
	  * @param array() $searchConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function moveDown($whereConditions=array(),$public=false)
	{
		//search order field
		if ($this->_tableData['order'][0]=='order') {
			$currentOrder = $this->_tableData['order'][1];
			$orderFieldName = 'order'.$this->_tableSufix;
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='order') {
						$currentOrder = $this->_tableData[$label][1];
						$orderFieldName = $label.$this->_tableSufix;
				}
			}
			$this->setError("Can not found order field in database");
			return false;
		}
		//if order = maxOrder then item is at bottom level then do nothing
		if ($currentOrder == $this->getOrderMax($whereConditions,$public)) {
			return;
		}
		
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//where clause
		if (count($whereConditions)) {
			$where =" and ";
			$count=0;
			foreach ($whereConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				$where .= " ".$label.$this->_tableSufix."='".SensitiveIO::sanitizeSQLString($condition)."' ";
			}
		}
		
		//select item who take the place of current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".$currentOrder."'
				where
					".$orderFieldName."='".($currentOrder+1)."'
				".$where."
			";
		$q = new CMS_query($sql);
		
		//move current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".($currentOrder+1)."'
				where
					".$this->_idName.$this->_tableSufix."='".$this->getID()."'
			";
		$q = new CMS_query($sql);
		
		return true;
	}
	
	/**
	  * Move the current object Order to a given position, the other object move to the current object position (search order field then change it)
	  * @param integer $moveTo the order to move to
	  * @param array() $searchConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function moveTo($moveTo,$whereConditions=array(),$public=false)
	{
		//search order field
		if ($this->_tableData['order'][0]=='order') {
			$currentOrder = $this->_tableData['order'][1];
			$orderFieldName = 'order'.$this->_tableSufix;
		} else {
			foreach($this->_tableData as $label => $aData) {
				if ($aData[0]=='order') {
						$currentOrder = $this->_tableData[$label][1];
						$orderFieldName = $label.$this->_tableSufix;
				}
			}
			$this->setError("Can not found order field in database");
			return false;
		}
		//if want to move to an impossible location then do nothing
		if ($moveTo > ($this->getOrderMax($whereConditions,$public)+1) || $moveTo < '0') {
			return;
		}
		
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//where clause
		if (count($whereConditions)) {
			$where =" and ";
			$count=0;
			foreach ($whereConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				$where .= " ".$label.$this->_tableSufix."='".SensitiveIO::sanitizeSQLString($condition)."' ";
			}
		}
		
		//select item who take the place of current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".$currentOrder."'
				where
					".$orderFieldName."='".$moveTo."'
				".$where."
			";
		$q = new CMS_query($sql);
		
		//move current item
		$sql = "update
					".$from."
				set
					".$orderFieldName."='".$moveTo."'
				where
					".$this->_idName.$this->_tableSufix."='".$this->getID()."'
			";
		$q = new CMS_query($sql);
		
		return true;
	}
	
	/**
	  * Gets an image of the object.
	  * Can return relative to web root of filesystem root, and with or without path.
	  *
	  * @param string $imageName The name of the image wanted
	  * @param boolean $withPath If false, only returns the filename
	  * @param string $dataLocation Where does the data lies ? See CMS_resource constants
	  * @param integer $relativeTo Can be web root or filesystem relative, see base constants
	  * @param boolean $withFilename Should the function return the filename too or only the path ?
	  * @return string The image path, false on error
	  * @access public
	  */
	function getImagePath($imageName, $withPath = false, $dataLocation = RESOURCE_DATA_LOCATION_EDITED, $relativeTo = PATH_RELATIVETO_WEBROOT, $withFilename = true)
	{
		if ($this->_tableData[$imageName][0]=='image') {
			if ($withPath) {
				
				if (!SensitiveIO::isInSet($dataLocation, CMS_resource::getAllDataLocations())
					|| $dataLocation == RESOURCE_DATA_LOCATION_DEVNULL) {
					$this->setError("DataLocation not in the valid set");
					return false;
				}
				switch ($relativeTo) {
				case PATH_RELATIVETO_WEBROOT:
					$path = PATH_MODULES_FILES_WR."/".$this->_moduleCodename."/".$dataLocation;
					break;
				case PATH_RELATIVETO_FILESYSTEM:
					$path = PATH_MODULES_FILES_FS."/".$this->_moduleCodename."/".$dataLocation;
					break;
				}
				if ($withFilename) {
					return $path . "/" . $this->_tableData[$imageName][1];
				} else {
					return $path;
				}
				return false;
			} else {
				return $this->_tableData[$imageName][1];
			}
		} else {
			$this->setError("Unknown image or not an image dataType :".$imageName);
			return false;
		}
	}
	
	/**
	  * Set an image filename
	  *
	  * @param string $imageName The image name to set
	  * @param string $filename The filename value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setImage($imageName,$filename)
	{
		if ($this->_tableData[$imageName][0]=='image') {
			$this->_tableData[$imageName][1] = $filename;
			return true;
		} else {
			$this->setError("Unknown image or not an image dataType :".$imageName);
			return false;
		}
	}
	
	/**
	  * Gets a file.
	  * Can return relative to web root of filesystem root, and with or without path.
	  *
	  * @param string $name The file wanted
	  * @param boolean $withPath If false, only returns the filename
	  * @param string $dataLocation Where does the data lies ? See CMS_resource constants
	  * @param integer $relativeTo Can be web root or filesystem relative, see base constants
	  * @param boolean $withFilename Should the function return the filename too or only the path ?
	  * @return string The image path, false on error
	  * @access public
	  */
	function getFilePath($name, $withPath = false, $dataLocation = RESOURCE_DATA_LOCATION_EDITED, $relativeTo = PATH_RELATIVETO_WEBROOT, $withFilename = true)
	{
		if ($this->_tableData[$name][0]=='file') {
			if ($withPath) {
				if (!SensitiveIO::isInSet($dataLocation, CMS_resource::getAllDataLocations())
					|| $dataLocation == RESOURCE_DATA_LOCATION_DEVNULL) {
					$this->setError("DataLocation not in the valid set");
					return false;
				}
				switch ($relativeTo) {
				case PATH_RELATIVETO_WEBROOT:
					$path = PATH_MODULES_FILES_WR."/".$this->_moduleCodename."/".$dataLocation;
					break;
				case PATH_RELATIVETO_FILESYSTEM:
					$path = PATH_MODULES_FILES_FS."/".$this->_moduleCodename."/".$dataLocation;
					break;
				}
				if ($withFilename) {
					return $path . "/" . $this->_tableData[$name][1];
				} else {
					return $path;
				}
				return false;
			} else {
				return $this->_tableData[$name][1];
			}
		} else {
			$this->setError("Unknown file or not an file dataType :".$name);
			return false;
		}
	}
	
	/**
	  * Set a file
	  *
	  * @param string $name The file to set
	  * @param string $filename The filename value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setFile($name,$filename)
	{
		if ($this->_tableData[$name][0]=='file') {
			$this->_tableData[$name][1] = $filename;
			return true;
		} else {
			$this->setError("Unknown file or not an file dataType :".$name);
			return false;
		}
	}
	
	/**
	  * Gets the type of the link
	  *
	  * @return string The link type
	  * @access public
	  */
	function getLinkType($linkName)
	{
		return $this->_linkType;
	}
	
	/**
	  * Gets the link
	  *
	  * @return array(linkType,linkValue)
	  * @access public
	  */
	function getLink($linkName)
	{
		return $this->_internalLink;
	}
	
	/**
	  * Sets the type of link
	  *
	  * @param integer $type The type to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setLink($linkName,$linkType,$linkValue)
	{
		if (!SensitiveIO::isInSet($type, CMS_resource::getAllLinkTypes())) {
			$this->setError("Type not in the valid set");
			return false;
		}
		$this->_linkType = $type;
		return true;
	}
	
	
	
	/**
	  * Gets the internal link (a page or false if no link)
	  *
	  * @return CMS_page
	  * @access public
	  */
	function getInternalLinkPage()
	{
		if ($this->_internalLink) {
			return CMS_tree::getPageByID($this->_internalLink);
		} else {
			return false;
		}
	}
	
	/**
	  * Sets the internal link
	  *
	  * @param integer $pageID The DB ID of the page linked
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setInternalLink($pageID)
	{
		$this->_internalLink = $pageID;
		return true;
	}
	
	/**
	  * Gets the URL of the external link
	  *
	  * @return string The URL
	  * @access public
	  */
	function getExternalLink()
	{
		return $this->_externalLink;
	}
	
	/**
	  * Sets the external link
	  *
	  * @param string $url The url to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setExternalLink($url)
	{
		if (io::substr($url, 0, 4) == "http") {
			$this->_externalLink = $url;
		} else {
			$this->_externalLink = 'http://'.$url;
		}
		return true;
	}
	
	/**
      * * Short hand to get value by property name
      *
      * @param string $name The name of the attribute to get
      * @return mixed The attribute or false if it does not exist
      * @access public
      */
    function getValue($name){
        if(strtolower($name) == 'id' || strtolower($name) == $this->_idName){
            return $this->getID();
        }
        if(isset($this->_tableData[$name][0])){
            $datatype = $this->_tableData[$name][0];
            switch($datatype){
                case 'html':
                case 'email':
                    return $this->getString($name);
                break;
                case 'positiveInteger':
                    return $this->getInteger($name);
                break;
                case 'date':
                    return $this->getTheDate($name);
                break;
                case 'file':
                    return $this->getFilePath($name);
                break;
                case 'image':
                    return $this->getImagePath($name);
                break;
                default:
                    $method = 'get'.ucfirst($datatype);
                    if (method_exists($this, $method)) {
                        return $this->{$method}($name);
                    } else {
                        $this->setError('Unknown method to use : "'.$method.'" for property "'.$name.'"');
                    }
                break;
            }
        } else {
            $this->setError("Unknown property :".$name);
            return false;
        }
    }
    
    /**
      * Short hand to set value by property name
      *
      * @param string $name The name of the attribute to get
      * @param mixed $value The value to set for the attribute
      * @return mixed The attribute or false if it does not exist
      * @access public
      */
    function setValue($name, $value = null){
        if(isset($this->_tableData[$name])){
            $datatype = $this->_tableData[$name][0];
            switch($datatype){
                case 'html':
                case 'email':
                    return $this->setString($name, $value);
                break;
                case 'positiveInteger':
                    return $this->setInteger($name, $value);
                break;
                default:
                    $method = 'set'.ucfirst($datatype);
                    if (method_exists($this, $method)) {
                        return $this->{$method}($name, $value);
                    } else {
                        $this->setError('Unknown method to use : "'.$method.'" for property "'.$name.'"');
                    }
                break;
            }
        } else {
            $this->setError("Unknown property :".$name);
            return false;
        }
    }
	
	/**
	  * Gets an list of distinct string values.
	  * Can return distinct string values of the database with where clauses and ordered by clause
	  *
	  * @param string $stringName The data name of the list wanted OR array of data names to get
	  * @param array() $whereConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param array() $orderConditions to construct the order by clause (default none)
	  *  format array("database column name" => "order type : asc or desc", ... => ..., ...)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return array() The list of string ordered
	  * @access public
	  */
	function getList($stringName,$whereConditions=array(),$orderConditions=array(),$public=false, $withIndex = false)
	{
		$where = $order = $from = '';
		//from clause
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//where clause
		if (count($whereConditions)) {
			$where ="where ";
			$count=0;
			foreach ($whereConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				$where .= " ".$label.$this->_tableSufix."='".SensitiveIO::sanitizeSQLString($condition)."' ";
			}
		}
		
		//order clause
		if (count($orderConditions)) {
			$order ="order by ";
			$count=0;
			foreach ($orderConditions as $orderLabel => $orderType) {
				$orderType = (!$orderType || ($orderType!='desc' && $orderType!='asc')) ? 'asc':$orderType;
				$order .= ($count) ? ",":'';
				$count++;
				$order .= " ".$orderLabel.$this->_tableSufix." ".$orderType." ";
			}
		}
		
		if (is_array($stringName)) {
			foreach ($stringName as $aStringName) {
				if (!in_array($this->_tableData[$aStringName][0],$this->_classString) && $aStringName != $this->_idName) {
					$this->setError("Unknown string or not a string dataType :".$aStringName);
					return false;
				}
			}
			$select = '';
			$count=0;
			foreach ($stringName as $aStringName) {
				$select .= ($count) ? ", ":'';
				$select .= $aStringName.$this->_tableSufix." ";
				$count++;
			}
			// the sql request
			$sql = "
				select
					".$select."
				from
					".$from."
					".$where."
					".$order."
				";
			
			$q = new CMS_query($sql);
			$r=array();
			if ($q->getNumRows()) {
				while ($arr = $q->getArray()) {
					$result = array();
					foreach ($stringName as $aStringName) {
						$result[$aStringName] = $arr[$aStringName.$this->_tableSufix];
					}
					$r[]=$result;
				}
			}
			return $r;
		} else {
			if (!in_array($this->_tableData[$stringName][0],$this->_classString)) {
				$this->setError("Unknown string or not a string dataType :".$stringName);
				return false;
			}
			// the sql request
			$sql = "
				select
					distinct ".$stringName.$this->_tableSufix." ".($withIndex ? ", ".$this->_idName.$this->_tableSufix : '')."
				from
					".$from."
					".$where."
					".$order."
				";
			$q = new CMS_query($sql);
			$r=array();
			if ($q->getNumRows()) {
				while ($arr = $q->getArray()) {
					if ($withIndex) {
						$r[$arr[$this->_idName.$this->_tableSufix]]=$arr[$stringName.$this->_tableSufix];
					} else {
						$r[]=$arr[$stringName.$this->_tableSufix];
					}
				}
			}
			return $r;
		}
	}
	
	/**
	  * make a search of objects in database
	  * Can return object or object ID values of the database with where clauses and ordered by clause
	  *
	  * @param array() $searchConditions to construct the where clause (default none)
	  *  format array("database column name" => "database value", ... => ..., ...)
	  * @param array() $orderConditions to construct the order by clause (default none)
	  *  format array("database column name" => "order type : asc or desc", ... => ..., ...)
	  * @param boolean $outputObjects the data to return (array of objects or array of object IDs) default is false (array of object IDs)
	  * @param boolean $public the data location wich needed (defaul false : edited)
	  * @return array() array of objects or array of object IDs (function of outputObjects value)
	  * @access public
	  */
	function search($searchConditions=array(),$orderConditions=array(),$outputObjects=false,$public=false,$operator="=")
	{
		//where clause
		if (count($searchConditions)) {
			$where ="where ";
			$count=0;
			foreach ($searchConditions as $label => $condition) {
				$where .= ($count) ? " and ":'';
				$count++;
				if (is_array($condition)) {
					if ($condition) {
						$where .= " ".$label.$this->_tableSufix." in (".SensitiveIO::sanitizeSQLString(implode(',', $condition)).") ";
					} else {
						return array();
					}
				} else {
					$where .= " ".$label.$this->_tableSufix." ".$operator." '".SensitiveIO::sanitizeSQLString($condition)."' ";
				}
			}
		} else {
			$where = '';
		}
		
		//order clause
		if (count($orderConditions)) {
			$order ="order by ";
			$count=0;
			foreach ($orderConditions as $orderLabel => $orderType) {
				$orderType = (!$orderType || ($orderType!='desc' && $orderType!='asc')) ? 'asc':$orderType;
				$order .= ($count) ? ",":'';
				$count++;
				$order .= " ".$orderLabel.$this->_tableSufix." ".$orderType." ";
			}
		} else {
			$order = '';
		}
		
		//from clause
		if ($this->_hasResource()) {
			$from = ($public) ? $this->_tableName.'_public':$this->_tableName.'_edited';
		} else {
			$from = $this->_tableName;
		}
		
		//sql request
		$sql = "
			select
				".$this->_idName.$this->_tableSufix."
			from
				".$from."
				".$where."
				".$order."
			";
		
		$q = new CMS_query($sql);
		$r=array();
		if ($q->getNumRows()) {
			while ($arr = $q->getArray()) {
				if ($outputObjects) {
					$r[]=new $this->_className($arr[$this->_idName.$this->_tableSufix]);
				} else {
					$r[]=$arr[$this->_idName.$this->_tableSufix];
				}
			}
		}
		return $r;
	}
	
	/**
	  * Writes the object data into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if ($this->_hasResource()) {
			//write parent
			parent::writeToPersistence();
		}
		//save data
		$sql_fields = "";
		$count=0;
		
		foreach($this->_tableData as $label => $aData) {
			$sql_fields .= ($count) ? ",":'';
			$count++;
			switch($aData[0]) {
				case 'integer':
				case 'positiveInteger':
				case 'email':
                    if(is_null($this->_tableData[$label][1])){
                        $sql_fields .= " `".$label.$this->_tableSufix."`=NULL";
                    }
                    else{
                        $sql_fields .= " `".$label.$this->_tableSufix."`='".SensitiveIO::sanitizeSQLString($this->_tableData[$label][1])."'";
                    }
                    break;
				case 'string':
				case 'html':
				case 'image':
				case 'file':
				case 'internalLink':
				case 'externalLink':
				case 'boolean':
				case 'linkType':
					$sql_fields .= " `".$label.$this->_tableSufix."`='".SensitiveIO::sanitizeSQLString($this->_tableData[$label][1])."'";
				break;
				case 'date':
					$sql_fields .= " `".$label.$this->_tableSufix."`='".$this->_tableData[$label][1]->getDBValue()."'";
				break;
				case 'resource':
					$sql_fields .= " `".$label.$this->_tableSufix."`='".parent::getID()."'";
				break;
				case 'order':
					/*
					 * ici il manque un truc pour pouvoir attribuer automatiquement les nouveaux ordres (lors de la création d'un objet)
					 * pb : savoir à quoi il se rapporte (clause where dans les fonctions associées aux ordre)
					 * solution ? lier ça direct dans la definition de la table (tableau _tableData ou autre variable) avantages, inconvénients ??? à voir
					 */
					$sql_fields .= " `".$label.$this->_tableSufix."`='".$this->_tableData[$label][1]."'";
				break;
				default:
					if (class_exists($aData[0])) {
						if (method_exists($this->_tableData[$label][1],"getID")) {
							$sql_fields .= " `".$label.$this->_tableSufix."`='".$this->_tableData[$label][1]->getID()."'";
						} elseif (method_exists($this->_tableData[$label][1],"getTextDefinition")) {
							$sql_fields .= " `".$label.$this->_tableSufix."`='".SensitiveIO::sanitizeSQLString($this->_tableData[$label][1]->getTextDefinition())."'";
						} else {
							$this->setError("Unknown save method for object ".$aData[0]);
							return false;
						}
					} else {
						$sql_fields .= " `".$label.$this->_tableSufix."`='".SensitiveIO::sanitizeSQLString($this->_tableData[$label][1])."'";
					}
				break;
			}
		}
		
		$from = ($this->_hasResource()) ? $this->_tableName.'_edited':$this->_tableName;
		
		if ($this->_ID) {
			$sql = "
				update
					".$from."
				set
					".$sql_fields."
				where
					".$this->_idName.$this->_tableSufix."='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					".$from."
				set
					".$sql_fields;
		}
		//pr($sql);
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->setError("Database write error");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}	
		return true;
	}
	
	/**
	  * Destroy the object 
	  * @param CMS_user $cms_user needed if object have a resource : the user who make the action
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy($cms_user=false)
	{
		 if ($this->_hasResource()) {
		 	if (is_a($cms_user,"CMS_profile_user")) {
				//change the article proposed location
				if ($this->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user)) {
					$this->writeToPersistence();
					unset($this);
					return true;
				} else {
					$this->setError("Resource deletion error");
					return false;
				}
			} else {
				$this->setError("Need a valid cms_user to destroy an object with a resource");
				return false;
			}
		 } else {
		 	$from = ' from '.$this->_tableName;
		 	$sql = "
				delete
					".$from."
				where
					".$this->_idName.$this->_tableSufix."='".$this->_ID."'
				";
			$q = new CMS_query($sql);
			unset($this);
			return true;
		}
	}
}
?>