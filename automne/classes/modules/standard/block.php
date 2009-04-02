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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: block.php,v 1.4 2009/04/02 13:57:58 sebastien Exp $

/**
  * Class CMS_block
  *
  * represent a block of data inside a row.
  * Abstract class, the following function _must_ be redefined in the subclasses :
  * 	- getData()
  * 	- getRawData()
  * 	- delFromLocation()
  * 	- writeToPersistence()
  *
  * @package CMS
  * @subpackage module
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_block extends CMS_grandFather
{
	/**
	  * From what the tag was initialized ? One of "basic" (from basic attributes), "definition" (from inner content), false (not initialized)
	  * @var string
	  * @access private
	  */
	protected $_initialized = false;

	/**
	  * ID attribute of the block tag
	  * @var integer
	  * @access private
	  */
	protected $_tagID;

	/**
	  * Attributes of the tag, excluding ID and repeat.
	  * @var array(string=>string)
	  * @access private
	  */
	protected $_attributes = array();

	/**
	* definition of the tag, may contain "{{data}}" which will be replaced by the raw data.
	  * @var string
	  * @access private
	  */
	protected $_definition = '';
	
	protected $_hasContent = false;
	
	protected $_editable = true;
	
	protected $_administrable = false;
	
	protected $_value = '';
	
	protected $_jsBlockClass = 'Automne.block';
	
	/**
	  * Constructor, unset by default
	  * Only used for each sub class while getting all datas from database
	  * Useful for duplicate function for example
	  *
	  * @param integer $id, DB ID of this block
	  * @param integer $location The location we want to get the block from
	  * @param boolean $public The needed precision for USERSPACE location
	  * @access public
	  */
	function CMS_block($id=0, $location=RESOURCE_LOCATION_USERSPACE, $public=false)
	{
	}
	
	/**
	  * Pseudo-constructor, sets the base attributes.
	  * initializes the block with the tag ID and repeat attributes.
	  *
	  * @param integer $blockID The ID attribute of the block tag
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function initializeFromBasicAttributes($blockID)
	{
		if ($blockID) {
			$this->_tagID = $blockID;
			$this->_initialized = "basic";
			return true;
		} else {
			$this->raiseError("Initialization tag ID empty");
			return false;
		}
	}
	
	/**
	  * Pseudo-constructor, initializes the tag with its definition.
	  *
	  * @param string $tagDefinition The tag definition, including the tag itself.
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function initializeFromTag($attributes, $tagInnerContent)
	{
		if (is_array($attributes)) {
			foreach ($attributes as $name=>$value) {
				switch ($name) {
				case "id":
					$this->_tagID = $value;
					break;
				default:
					if ($name != "repeat") {
						$this->_attributes[$name] = $value;
					}
					break;
				}
			}
		} else {
			$this->raiseError("Initialization attributes not an array");
			return false;
		}
		
		//The tag definition
		$this->_definition = $tagInnerContent;
		$this->_initialized = "definition";
		return true;
	}
	
	/**
	  * Pseudo-constructor, initializes the tag with its definition from tag and row id
	  *
	  * @param string $blockID, the block id to initialise
	  * @param integer $rowID, the row id which contain the block to load
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function initializeFromID($blockID, $rowID) {
		if (!sensitiveIO::isPositiveInteger($rowID)) {
			$this->raiseError("rowID must be a positive integer : ".$rowID);
			return false;
		}
		//instanciate row to get block definition
		$row = new CMS_row($rowID);
		$blockTag = $row->getBlockTagById($blockID);
		if (!is_object($blockTag)) {
			$this->raiseError('Can\'t get block '.$blockID.' from row id : '.$rowID);
			return false;
		}
		$this->initializeFromTag($blockTag->getAttributes(), $blockTag->getInnerContent());
		return true;
	}
	
	/**
	  * Gets the data in HTML mode.
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page The page which contains the client space
	  * @param CMS_clientSpace &$clientSpace The client space which contains the row
	  * @param CMS_row &$row The row which contains the block
	  * @param integer $visualizationMode The visualization mode used
	  * @return string the HTML data
	  * @access public
	  */
	function getData(&$language, &$page, &$clientSpace, &$row, $visualizationMode)
	{
		if ($this->_initialized != "definition") {
			$this->raiseError("Try to retrieve HTML data from a tag not initialized by definition");
			return false;
		}
	}
	
	/**
	  * Gets the data in array mode.
	  *
	  * @param integer $pageID The page DB ID which contains the client space
	  * @param integer $clientSpaceID The client space DB ID which contains the row
	  * @param integer $rowID The row DB ID which contains the block
	  * @param integer $location The location of the page
	  * @param boolean $public The needed precision for USERSPACE location
	  * @return array(string=>mixed) The data indexed by data type (value, file, alt_tag, ...), or false on failure (table not found)
	  * @access public
	  */
	function getRawData($pageID, $clientSpaceID, $rowID, $location, $public)
	{
		if (!$this->_initialized) {
			$this->raiseError("Try to retrieve HTML data from a tag not initialized");
			return false;
		}
	}
	
	/**
	  * Gets the folder name which depends of the page location
	  *
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return string The folder name
	  * @access public
	  */
	protected function _getFolderName($location, $public) {
		switch ($location) {
			case RESOURCE_LOCATION_USERSPACE:
				$folder = ($public) ? "public" : "edited";
			break;
			case RESOURCE_LOCATION_ARCHIVED:
				$folder = "archived";
			break;
			case RESOURCE_LOCATION_DELETED:
				$folder = "deleted";
			break;
			case RESOURCE_LOCATION_EDITION:
				$folder = "edition";
			break;
		}
		return $folder;
	}
	
	/**
	  * Deletes the block from a location (public, archived, deleted, edited)
	  *
	  * @param integer $pageID The page which contains the client space, DB ID
	  * @param integer $clientSpaceID The client space which contains the row, DB ID
	  * @param integer $rowID The row which contains the block, DB ID
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function delFromLocation($pageID, $clientSpaceID, $rowID, $location, $public = false)
	{
		if (!SensitiveIO::isInSet($location, CMS_resourceStatus::getAllLocations())) {
			$this->raiseError("DelFromLocation was given a bad location");
			return false;
		}
		
		$table = $this->_getDataTableName($location, $public);
		$sql = "
			delete from
				".$table."
			where
				page='".$pageID."'
				and clientSpaceID='".$clientSpaceID."'
				and rowID='".$rowID."'
				and blockID='".$this->_tagID."'
		";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Change the clientspace of block from a location (public, archived, deleted, edited)
	  *
	  * @param integer $pageID The page which contains the client space, DB ID
	  * @param integer $oldClientSpaceID The old client space which contains the row, DB ID
	  * @param integer $newClientSpaceID The new client space which now contains the row, DB ID
	  * @param integer $rowID The row which contains the block, DB ID
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function changeClientSpace($pageID, $oldClientSpaceID, $newClientSpaceID, $rowID, $location, $public = false)
	{
		if (!SensitiveIO::isInSet($location, CMS_resourceStatus::getAllLocations())) {
			$this->raiseError("DelFromLocation was given a bad location");
			return false;
		}
		$table = $this->_getDataTableName($location, $public);
		$sql = "
			update 
				".$table."
			set
				clientSpaceID='".$newClientSpaceID."'
			where
				page='".$pageID."'
				and clientSpaceID='".$oldClientSpaceID."'
				and rowID='".$rowID."'
				and blockID='".$this->_tagID."'
		";
		$q = new CMS_query($sql);
		$this->_clientSpaceID = $newClientSpaceID;
		return true;
	}
	
	
	/**
	  * Writes the block data into persistence (destroys previous and insert new)
	  *
	  * @param integer $pageID The page which contains the client space, DB ID
	  * @param integer $clientSpaceID The client space which contains the row, DB ID
	  * @param integer $rowID The row which contains the block, DB ID
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @param array(mixed=>mixed) $data The data indexed by data type (value, file, alt_tag, ...), 
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence($pageID, $clientSpaceID, $rowID, $location, $public, $data)
	{
		if (!SensitiveIO::isInSet($location, CMS_resourceStatus::getAllLocations())) {
			$this->raiseError("writeToPersistence was given a bad location");
			return false;
		}
	}
	
	/**
	  * Get the HTML form given the block HTML example data.
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page The page which contains the client space
	  * @param CMS_clientSpace &$clientSpace The client space which contains the row
	  * @param CMS_row &$row The row which contains the block
	  * @param integer $blockID The tag ID of the block
	  * @param string $data The data to show as example
	  * @return string The HTML form which can send to the page that will modify the block
	  * @access private
	  */
	protected function _getHTMLForm($language, &$page, &$clientSpace, &$row, $blockID, $data){
		global $cms_user;
		
		//append atm-block class and block-id to all first level tags founded in block datas
		$domdocument = new CMS_DOMDocument();
		try {
			$domdocument->loadXML('<block>'.$data.'</block>');
		} catch (DOMException $e) {
			$this->raiseError('Parse error for block : '.$e->getMessage()." :\n".htmlspecialchars($data));
			return '';
		}
		$blockNodes = $domdocument->getElementsByTagName('block');
		if ($blockNodes->length == 1) {
			$blockXML = $blockNodes->item(0);
		}
		//check for valid tags nodes inside current block tag
		$hasNode = false;
		foreach($blockXML->childNodes as $blockChildNode) {
			if (is_a($blockChildNode, 'DOMElement') && $blockChildNode->tagName != 'script') {
				$hasNode = true;
			}
		}
		if (!$hasNode) {
			//append div with atm-empty-block class around datas
			$domdocument = new CMS_DOMDocument();
			try {
				$domdocument->loadXML('<block><div class="atm-empty-block atm-block-helper">'.$data.'</div></block>');
			} catch (DOMException $e) {
				$this->raiseError('Parse error for block : '.$e->getMessage()." :\n".htmlspecialchars($data));
				return '';
			}
			$blockNodes = $domdocument->getElementsByTagName('block');
			if ($blockNodes->length == 1) {
				$blockXML = $blockNodes->item(0);
			}
		}
		
		$elements = array();
		$uniqueId = 'block-'.md5(mt_rand().microtime());
		foreach($blockXML->childNodes as $blockChildNode) {
			if (is_a($blockChildNode, 'DOMElement') && $blockChildNode->tagName != 'script') {
				if ($blockChildNode->hasAttribute('class')) {
					$blockChildNode->setAttribute('class', $blockChildNode->getAttribute('class').' atm-block '.$uniqueId);
				} else {
					$blockChildNode->setAttribute('class','atm-block '.$uniqueId);
				}
				$elementId = 'el-'.md5(mt_rand().microtime());
				$blockChildNode->setAttribute('id',$elementId);
				$elements[] = $elementId;
			}
		}
		$data = CMS_DOMDocument::DOMElementToString($blockXML, true);
		//add block JS specification
		$data = '
		<script type="text/javascript">
			atmBlocksDatas[\''.$uniqueId.'\'] = {
				page:				\''.$page->getID().'\',
				document:			document,
				clientSpaceTagID:	\''.$clientSpace->getTagID().'\',
				row:				\''.$row->getTagID().'\',
				id:					\''.$blockID.'\',
				jsBlockClass:		\''.$this->_jsBlockClass.'\',
				hasContent:			\''.$this->_hasContent.'\',
				editable:			\''.$this->_editable.'\',
				administrable:		\''.$this->_administrable.'\',
				value:				'.(is_array($this->_value) ? sensitiveIO::jsonEncode($this->_value) : '\''.sensitiveIO::sanitizeJSString($this->_value).'\'').',
				elements:			['.($elements ? '\''.implode('\',\'', $elements).'\'' : '').']
			};
		</script>
		'.$data;
		return $data;
	}
	
	/**
	  * Duplicate this block, all datas rebnamed and saved
	  * Used to duplicate a CMS_page.
	  *
	  * @param CMS_page $destinationPage, the page receiving a copy of this block
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return CMS_block object
	  */
	function duplicate(&$destinationPage, $public = false)
	{
		
	}
	
	/**
	  * Get the value of an attribute.
	  *
	  * @param string $attribute The attribute we want (its the key of the associative array)
	  * @return string The attribute value
	  * @access public
	  */
	function getAttribute($attribute)
	{
		if (is_array($this->_attributes)) {
			return $this->_attributes[$attribute];
		} else {
			return false;
		}
	}
}
?>