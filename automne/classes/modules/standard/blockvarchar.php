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
// $Id: blockvarchar.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_block_varchar
  *
  * represent a block of varchar data inside a row.
  *
  * @package CMS
  * @subpackage module
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_block_varchar extends CMS_block
{
	/**
	  * block have content attached ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_hasContent;
	
	/**
	  * Constructor
	  * Used while getting all datas from database
	  * Useful for duplicate function for example
	  *
	  * @param integer $id, DB ID of this block
	  * @param integer $location The location we want to get the block from
	  * @param boolean $public The needed precision for USERSPACE location
	  * @access public
	  */
	function __construct($id=0, $location=RESOURCE_LOCATION_USERSPACE, $public=false)
	{
		parent::__construct();
		
		if (SensitiveIO::isPositiveInteger($id)) {
			//Select table
			$table = $this->_getDataTableName($location, $public);
			
			$sql = "
				select
					*
				from
					".$table."
				where
					id=".$id."
					";
			$q = new CMS_query($sql);
			if(!$q->hasError()) {
				$data = $q->getArray();
				$this->_dbID = $id;
				$this->_pageID = $data["page"];
				$this->_clientSpaceID = $data["clientSpaceID"];
				$this->_rowID = $data["rowID"];
				$this->_tagID = $data["blockID"];
				$this->_value = $data["value"];
			}
		}
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
		parent::getData($language, $page, $clientSpace, $row, $visualizationMode);
		
		//get the data
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_USERSPACE, true);
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_USERSPACE, false);
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
		case PAGE_VISUALMODE_FORM:
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_EDITION, false);
			break;
		}
		
		//build the HTML
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_HTML_EDITED:
		case PAGE_VISUALMODE_HTML_EDITION:
		case PAGE_VISUALMODE_PRINT:
			if ($data && $data["value"]) {
				$html = htmlspecialchars($data["value"]);
				return str_replace("{{data}}", $html, $this->_definition);
			}
			break;
		//case PAGE_VISUALMODE_CLIENTSPACES_FORM:
		case PAGE_VISUALMODE_FORM:
			if ($data && $data["value"]) {
				$html = htmlspecialchars($data["value"]);
			} else {
				$html = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy.";
			}
			$form_data = str_replace("{{data}}", $html, $this->_definition);
			$this->_hasContent = ($data && $data["value"]) ? true:false;
			$this->_editable = true;
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$html = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy.";
			$form_data = str_replace("{{data}}", $html, $this->_definition);
			$this->_hasContent = false;
			$this->_editable = false;
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
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
	  * @return array(mixed=>mixed) The data indexed by data type (value, file, alt_tag, ...), or false on failure (table not found)
	  * @access public
	  */
	function getRawData($pageID, $clientSpaceID, $rowID, $location, $public)
	{
		parent::getRawData($pageID, $clientSpaceID, $rowID, $location, $public);
		
		$table = $this->_getDataTableName($location, $public);
		if (!$table) {
			$this->raiseError("unknown table");
			return false;
		}
		$sql = "
			select
				*
			from
				".$table."
			where
				page='".$pageID."'
				and clientSpaceID='".$clientSpaceID."'
				and rowID='".$rowID."'
				and blockID='".$this->_tagID."'
		";
		$q = new CMS_query($sql);
		if (!$q->hasError()) {
			if ($q->getNumRows()) {
				return $q->getArray();
			} else {
				return array("value" => "");
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the table name which depends of the page location
	  *
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return string The table name
	  * @access public
	  */
	protected function _getDataTableName($location, $public)
	{
		switch ($location) {
		case RESOURCE_LOCATION_USERSPACE:
			$table = ($public) ? "blocksVarchars_public" : "blocksVarchars_edited";
			break;
		case RESOURCE_LOCATION_ARCHIVED:
			$table = "blocksVarchars_archived";
			break;
		case RESOURCE_LOCATION_DELETED:
			$table = "blocksVarchars_deleted";
			break;
		case RESOURCE_LOCATION_EDITION:
			$table = "blocksVarchars_edition";
			break;
		}
		return $table;
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
		parent::writeToPersistence($pageID, $clientSpaceID, $rowID, $location, $public, $data);

		//delete the old data
		$this->delFromLocation($pageID, $clientSpaceID, $rowID, $location, $public);
		
		$table = $this->_getDataTableName($location, $public);
		
		$sql = "
			insert into
				".$table."
			set
				page='".$pageID."',
				clientSpaceID='".$clientSpaceID."',
				rowID='".$rowID."',
				blockID='".$this->_tagID."',
				value='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($data["value"]))."'
		";
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} else {
			return true;
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
		$rawDatas = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_EDITION, false);
		$this->_jsBlockClass = 'Automne.blockVarchar';
		$this->_value = htmlspecialchars($rawDatas['value']);
		$this->_administrable = false;
		$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, $data);
		return $html;
	}
	
	
	/**
	  * Duplicate this block
	  * Used to duplicate a CMS_page.
	  *
	  * @param CMS_page $destinationPage, the page receiving a copy of this block
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return CMS_block object
	  */
	function duplicate(&$destinationPage, $public = false)
	{
		if (SensitiveIO::isPositiveInteger($this->_dbID)) {
			$table = $this->_getDataTableName(RESOURCE_LOCATION_USERSPACE, $public);
			$str_set = "
					page='".$destinationPage->getID()."',
					clientSpaceID='".$this->_clientSpaceID."',
					rowID='".$this->_rowID."',
					blockID='".$this->_tagID."',
					value='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($this->_value))."'
			";
			$sql = "
				insert into
					".$table."
				set
					".$str_set."
			";
			$q = new CMS_query($sql);
			if (!$q->hasError()) {
				//Table Edition
				$sql = "
					insert into
						".$this->_getDataTableName(RESOURCE_LOCATION_EDITION, false)."
					set
						id='',
						".$str_set."
				";
				$q = new CMS_query($sql);
				return !$q->hasError();
			} else {
				$this->raiseError("Duplicate, insertion failed: ".$sql);
			}
		} else {
			$this->raiseError("Duplicate, object does not have a DB ID, not initialized");
		}
		return false;
	}
}

?>