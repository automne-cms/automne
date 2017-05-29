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

/**
  * Class CMS_block_link
  *
  * represent a block of link data inside a row.
  *
  * @package Automne
  * @subpackage standard
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_block_link extends CMS_block
{
	const MESSAGE_BLOCK_LINK_LABEL = 147;
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
				$this->_link = new CMS_href($data["value"]);
			}
		} else {
			$this->_link = new CMS_href();
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
			$location = RESOURCE_LOCATION_USERSPACE;
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_USERSPACE, true);
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			$location = RESOURCE_LOCATION_USERSPACE;
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_USERSPACE, false);
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
		case PAGE_VISUALMODE_FORM:
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$location = RESOURCE_LOCATION_EDITION;
			$data = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_EDITION, false);
			break;
		}
		
		//build the HTML
		$html_attributes = "";
		if (isset($this->_attributes['class']) && $this->_attributes['class']) {
			$this->_attributes['class'] .= ' atm-link';
		} else {
			$this->_attributes['class'] = 'atm-link';
		}
		foreach ($this->_attributes as $name => $value) {
			if ($name != "module" && $name != "type") {
				$html_attributes .= ' '.$name.'="'.$value.'"';
			}
		}
		
		$link = new CMS_href($data["value"]);
		
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			if ($link->hasValidHREF()) {
				return $this->_replaceBlockVars($link, $html_attributes, RESOURCE_DATA_LOCATION_PUBLIC, true);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			if ($link->hasValidHREF()) {
				return $this->_replaceBlockVars($link, $html_attributes, RESOURCE_DATA_LOCATION_EDITED, false);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
			if ($link->hasValidHREF()) {
				return $this->_replaceBlockVars($link, $html_attributes, RESOURCE_DATA_LOCATION_EDITION, false);
			}
			break;
		case PAGE_VISUALMODE_FORM:
			$this->_hasContent = $link->hasValidHREF();
			$this->_editable = true;
			if ($link->hasValidHREF()) {
				$form_data = $this->_replaceBlockVars($link, $html_attributes, RESOURCE_DATA_LOCATION_EDITION, false);
			} else {
				if(isset($this->_attributes['default'])) {
					$html = $this->_attributes['default'];
				} else {
					$html = $language->getMessage(self::MESSAGE_BLOCK_LINK_LABEL);
				}
				$replace = array(
					'{{data}}' 		=> '<a href="#"'.$html_attributes.' title="'.io::htmlspecialchars($language->getMessage(self::MESSAGE_BLOCK_LINK_LABEL)).'">'.$html.'</a>',
					'{{href}}' 		=> '#',
					'{{label}}' 	=> $html,
					'{{jslabel}}' 	=> io::htmlspecialchars($html),
					'{{target}}'	=> '',
					'{{type}}'		=> '',
				);
				$form_data = str_replace(array_keys($replace), $replace, $this->_definition);
			}
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$this->_hasContent = false;
			$this->_editable = true;
			if(isset($this->_attributes['default'])) {
				$html = $this->_attributes['default'];
			} else {
				$html = $language->getMessage(self::MESSAGE_BLOCK_LINK_LABEL);
			}
			$replace = array(
					'{{data}}' 		=> '<a href="#"'.$html_attributes.' title="'.io::htmlspecialchars($language->getMessage(self::MESSAGE_BLOCK_LINK_LABEL)).'">'.$html.'</a>',
					'{{href}}' 		=> '#',
					'{{label}}' 	=> $html,
					'{{jslabel}}' 	=> io::htmlspecialchars($html),
					'{{target}}'	=> '',
					'{{type}}'		=> '',
				);
			$form_data = str_replace(array_keys($replace), $replace, $this->_definition);
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		}
	}
	
	/**
	  * Replace block definition vars.
	  *
	  * @param array link : the block datas (CMS_href)
	  * @param array attributes : html attributes to add
	  * @param integer $location The location of the page
	  * @param boolean $public The needed precision for USERSPACE location
	  * @return string the HTML data
	  * @access public
	  */
	protected function _replaceBlockVars($link, $attributes, $location, $public) {
		$replace = array(
			'{{data}}' 		=> $link->getHTML(false, MOD_STANDARD_CODENAME, $location, $attributes),
			'{{href}}' 		=> $link->getHTML(false, MOD_STANDARD_CODENAME, $location, false, true),
			'{{label}}' 	=> io::htmlspecialchars($link->getLabel()),
			'{{jslabel}}' 	=> io::htmlspecialchars($link->getLabel()),
			'{{target}}'	=> $link->getTarget(),
			'{{type}}'		=> $link->getLinkType(),
		);
		return str_replace(array_keys($replace), $replace, $this->_definition);
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
			$this->setError("Unknown table");
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
			$table = ($public) ? "blocksRawDatas_public" : "blocksRawDatas_edited";
			break;
		case RESOURCE_LOCATION_ARCHIVED:
			$table = "blocksRawDatas_archived";
			break;
		case RESOURCE_LOCATION_DELETED:
			$table = "blocksRawDatas_deleted";
			break;
		case RESOURCE_LOCATION_EDITION:
			$table = "blocksRawDatas_edition";
			break;
		}
		return $table;
	}
	
	/**
	  * Deletes the block from a location (public, archived, deleted, edited)
	  *
	  * @param integer $pageID The page which contains the client space, DB ID
	  * @param integer $clientSpaceID The client space which contains the row, DB ID
	  * @param integer $rowID The row which contains the block, DB ID
	  * @param integer $location The location we want to completly remove the block from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @param boolean $withfile : delete the attached file if any (default : false)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function delFromLocation($pageID, $clientSpaceID, $rowID, $location, $public = false, $withfile = false)
	{
		if (!SensitiveIO::isInSet($location, CMS_resourceStatus::getAllLocations())) {
			$this->setError("DelFromLocation was given a bad location");
			return false;
		}
		if($withfile) {
			$data = $this->getRawData($pageID, $clientSpaceID, $rowID, $location, $public);
			$link = new CMS_href($data["value"]);
			if ($link->getLinkType() == RESOURCE_LINK_TYPE_FILE) {
				//get file path
				$file = $link->getFileLink(true, MOD_STANDARD_CODENAME, $location, PATH_RELATIVETO_FILESYSTEM, true);;
				if (file_exists($file)) {
					@unlink($file);
				}
			}
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
				type='CMS_block_link',
				blockID='".$this->_tagID."'
		";
		if (isset($data["value"])) {
			$sql .= ",value='".SensitiveIO::sanitizeSQLString($data["value"])."'";
		}
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
		$this->_jsBlockClass = 'Automne.blockLink';
		$datas = array(
			'page'			=> isset($rawDatas['page']) ? $rawDatas['page'] : '',
			'clientSpaceID'	=> isset($rawDatas['clientSpaceID']) ? $rawDatas['clientSpaceID'] : '',
			'rowID'			=> isset($rawDatas['rowID']) ? $rawDatas['rowID'] : '',
			'blockID'		=> isset($rawDatas['blockID']) ? $rawDatas['blockID'] : ''
		);
		$this->_value = $datas;
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
			$link = $this->_link;
			if ($link->hasValidHREF()) {
				if ($link->getLinkType() == RESOURCE_LINK_TYPE_FILE) {
					//get file path
					$file = $link->getFileLink(false, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED, PATH_RELATIVETO_FILESYSTEM, true);
					$path = $link->getFileLink(true, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED, PATH_RELATIVETO_FILESYSTEM, false);
					if ($file && file_exists($path.'/'.$file)) {
						//Copy linked file
						//In new file name, delete reference to old page and add refernce to new one
						$_newFilename = "p".$destinationPage->getID().io::substr( $file, io::strpos($file,"_"), io::strlen($file));
						
						if (@is_file(PATH_MODULES_FILES_STANDARD_FS."/edited/".$file) 
							&& CMS_file::copyTo(PATH_MODULES_FILES_STANDARD_FS."/edited/".$file, PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename)
							&& CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename) ) {
							//Public
							if ($public) {
								if (!is_file(PATH_MODULES_FILES_STANDARD_FS."/public/".$file) 
									|| !CMS_file::copyTo(PATH_MODULES_FILES_STANDARD_FS."/public/".$file, PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename)
									|| !CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename)) {
									$this->setError("Duplicate, file copy failed : ".PATH_MODULES_FILES_STANDARD_FS."/public/".$file);
								}
							}
							$link->setFileLink($_newFilename);
						}
					}
				}
				$table = $this->_getDataTableName(RESOURCE_LOCATION_USERSPACE, $public);
				//Save new datas
				$str_set = "
						page='".$destinationPage->getID()."',
						clientSpaceID='".$this->_clientSpaceID."',
						rowID='".$this->_rowID."',
						blockID='".$this->_tagID."',
						type='CMS_block_link',
						value='".SensitiveIO::sanitizeSQLString($link->getTextDefinition())."'
				";
				$sql = "
					insert into
						".$table."
					set
						".$str_set."
				";
				$q = new CMS_query($sql);
				if (!$q->hasError())	{
					//Table Edition
					$sql = "
						insert into
							".$this->_getDataTableName(RESOURCE_LOCATION_EDITION, false)."
						set
							id='".$q->getLastInsertedID()."',
							".$str_set."
					";
					$q = new CMS_query($sql);
					return !$q->hasError();
				} else {
					$this->setError("Duplicate, SQL insertion of new filename failed: ".$sql);
				}
			} else {
				$this->setError("Duplicate, copy of file failed :".PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file);
			}
		}
		return false;
	}
}
?>