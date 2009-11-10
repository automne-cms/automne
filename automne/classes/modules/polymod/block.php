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
// $Id: block.php,v 1.4 2009/11/10 16:48:59 sebastien Exp $

/**
  * Class CMS_block_polymod
  *
  * represent a block of polymod data inside a row.
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_block_polymod extends CMS_block
{
	/**
	  * block have parameters set ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_hasParameters;
	
	/**
	  * does this block can have parameters ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_canhasParameters = null;
	
	/**
	  * does this block _MUST_ have parameters ?
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_musthaveParameters = null;
	
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
				$this->_value = unserialize($data["value"]);
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
		//look for block parameters requirement
		$this->_lookForBlockParameters();
		$this->_hasParameters = ($data && is_array($data["value"]) && $data["value"]) ? true:false;
		//build the HTML
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_PRINT:
		case PAGE_VISUALMODE_HTML_PUBLIC:
			if (($this->_hasParameters && $this->_musthaveParameters) || !$this->_musthaveParameters) {
				return  $this->_createDatasFromDefinition($data["value"], $page, true, CMS_polymod_definition_parsing::OUTPUT_PHP);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
		case PAGE_VISUALMODE_HTML_EDITION:
			if (($this->_hasParameters && $this->_musthaveParameters) || !$this->_musthaveParameters) {
				return $this->_createDatasFromDefinition($data["value"], $page, false, CMS_polymod_definition_parsing::OUTPUT_PHP);
			}
			break;
		case PAGE_VISUALMODE_FORM:
			//$this->_lookForBlockParameters();
			$this->_administrable = true;
			$this->_editable = $this->_canhasParameters;
			if (($this->_hasParameters && $this->_musthaveParameters) || !$this->_musthaveParameters) {
				$this->_hasContent = true;
				$form_data = $this->_createDatasFromDefinition($data["value"], $page, false, CMS_polymod_definition_parsing::OUTPUT_PHP);
			} else {
				$this->_hasContent = false;
				$form_data = '<img src="'.PATH_ADMIN_MODULES_WR.'/polymod/block.gif" alt="X" title="X" />';
			}
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$this->_administrable = false;
			$this->_editable = false;
			$this->_hasContent = false;
			$form_data = '<img src="'.PATH_ADMIN_MODULES_WR.'/polymod/block.gif" alt="X" title="X" />';
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		}
		return;
	}
	
	/**
	  * Create datas from definition.
	  * Parse definition and create PHP / HTML string
	  *
	  * @param serialized datas $rawDatas : The user specified parameters for the row
	  * @param CMS_page $page The reference of the current page using block
	  * @param boolean $public The needed precision for USERSPACE location (default : false)
	  * @param constant $type The needed return type of datas (default : CMS_polymod_definition_parsing::OUTPUT_RESULT)
	  * @return string The PHP / HTML datas
	  * @access private
	  */
	protected function _createDatasFromDefinition($rawDatas, &$page, $public = false, $type = CMS_polymod_definition_parsing::OUTPUT_RESULT) {
		$parameters = ($rawDatas) ? array_merge($rawDatas, $this->_attributes) : $this->_attributes;
		// If no language parameter : set page language
		$parameters['language'] = (isset($parameters['language']) && $parameters['language']) ? $parameters['language'] : $page->getLanguage();
		$parameters = array('block_attributes' => $parameters,
							'module' => $this->_attributes['module'],
							'language' => $parameters['language'],
							'pageID' => $page->getID(),
							'public' => $public,);
		$polymodParsing = new CMS_polymod_definition_parsing($this->_definition, true, CMS_polymod_definition_parsing::PARSE_MODE, $this->_attributes['module']);
		return $polymodParsing->getContent($type, $parameters);
	}
	
	/**
	  * Get all block parameters requirement
	  * Parse definition and get block params
	  *
	  * @param serialized datas $rawDatas : The user specified parameters for the row
	  * @param CMS_page $page The reference of the current page using block
	  * @param boolean $public The needed precision for USERSPACE location (default : false)
	  * @return multidimentionnal array : all block parameters requirement
	  * @access private
	  */
	function getBlockParametersRequirement($rawDatas, &$page, $public = false) {
		$polymodParsing = new CMS_polymod_definition_parsing($this->_definition, true, CMS_polymod_definition_parsing::BLOCK_PARAM_MODE);
		return $polymodParsing->getBlockParams();
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
			$this->raiseError("Unknown table");
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
				$r = $q->getArray();
				$r['value'] = unserialize($r['value']);
				$this->_dbID = $r["id"];
				$this->_pageID = $r["page"];
				$this->_clientSpaceID = $r["clientSpaceID"];
				$this->_rowID = $r["rowID"];
				$this->_tagID = $r["blockID"];
				$this->_value = $r["value"];
				return $r;
			} else {
				return array("value" => array());
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
				page='".sensitiveIO::sanitizeSQLString($pageID)."',
				clientSpaceID='".sensitiveIO::sanitizeSQLString($clientSpaceID)."',
				rowID='".sensitiveIO::sanitizeSQLString($rowID)."',
				blockID='".sensitiveIO::sanitizeSQLString($this->_tagID)."',
				value='".sensitiveIO::sanitizeSQLString(serialize($data["value"]))."'
		";
		
		/*$sqlParameters = array(
			'page' => $pageID,
			'clientspace' => $clientSpaceID,
			'rowID' => $rowID,
			'blockID' => $this->_tagID,
			'value' => serialize($data["value"]),
		);*/
		$q = new CMS_query($sql);
		//$q->executePreparedQuery($sql, $sqlParameters);
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
	protected function _getHTMLForm($language, &$page, &$clientSpace, &$row, $blockID, $data)
	{
		global $cms_user;
		$this->_jsBlockClass = 'Automne.blockPolymod';
		$rawDatas = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_EDITION, false);
		$datas = array(
			'page'			=> isset($rawDatas['page']) ? $rawDatas['page'] : '',
			'clientSpaceID'	=> isset($rawDatas['clientSpaceID']) ? $rawDatas['clientSpaceID'] : '',
			'rowID'			=> isset($rawDatas['rowID']) ? $rawDatas['rowID'] : '',
			'blockID'		=> isset($rawDatas['blockID']) ? $rawDatas['blockID'] : '',
			'module'		=> $this->_attributes['module']
		);
		$this->_value = $datas;
		
		$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, '<div class="atm-polymod-block atm-block-helper">'.$data.'</div>');
		//load interface instance
		$view = CMS_view::getInstance();
		//append JS block class file
		$view->addJSFile(PATH_ADMIN_WR.'/js/edit/block-polymod.js');
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
					page='".sensitiveIO::sanitizeSQLString($destinationPage->getID())."',
					clientSpaceID='".sensitiveIO::sanitizeSQLString($this->_clientSpaceID)."',
					rowID='".sensitiveIO::sanitizeSQLString($this->_rowID)."',
					blockID='".sensitiveIO::sanitizeSQLString($this->_tagID)."',
					value='".sensitiveIO::sanitizeSQLString($this->_value)."'
			";
			$sql = "
				insert into
					".$table."
				set
					".$str_set."
			";
			$q = new CMS_query($sql);
			//$q->executePreparedQuery($sql, $sqlParameters);
			if (!$q->hasError()) {
				//Table Edition
				$sql = "
					insert into
						".$this->_getDataTableName(RESOURCE_LOCATION_EDITION, false)."
					set
						id='".$id."',
						".$str_set."
				";
				$q = new CMS_query($sql);
				return !$q->hasError();
			} else {
				$this->raiseError("Insertion failed: ".$sql);
			}
		} else {
			$this->raiseError("Object does not have a DB ID, not initialized");
		}
		return false;
	}
	
	/**
	  * Look if this block can have or must have parameters to been set ? (search parameters for now)
	  *
	  * @return boolean true
	  * @access private
	  */
	private function _lookForBlockParameters() {
		if ($this->_canhasParameters !== null && $this->_musthaveParameters !== null) {
			return true;
		}
		$this->_canhasParameters = false;
		$this->_musthaveParameters = false;
		$domdocument = new CMS_DOMDocument();
		try {
			$domdocument->loadXML('<dummy>'.$this->_definition.'</dummy>');
		} catch (DOMException $e) {
			$this->raiseError('Parse error during search for blocks parameters : '.$e->getMessage()." :\n".io::htmlspecialchars($this->_definition));
			return true;
		}
		$searchTags = $domdocument->getElementsByTagName('atm-search');
		if ($searchTags->length) {
			foreach ($searchTags as $searchTag) {
				$paramTags = array();
				$paramTags[] = $searchTag->getElementsByTagName('atm-search-param');
				$paramTags[] = $searchTag->getElementsByTagName('atm-search-limit');
				$paramTags[] = $searchTag->getElementsByTagName('atm-search-page');
				$paramTags[] = $searchTag->getElementsByTagName('atm-search-order');
				foreach ($paramTags as $paramTagType) {
					foreach ($paramTagType as $paramTag) {
						if ($paramTag->hasAttribute('value') && $paramTag->getAttribute('value') == 'block') {
							$this->_canhasParameters = true;
							//check for mandatory block parameter value (all are mandatory except for atm-search-param which is explicitely defined)
							if (($paramTag->getAttribute('mandatory') == 'true' && $paramTag->tagName == 'atm-search-param')
								 || $paramTag->tagName != 'atm-search-param') {
								$this->_musthaveParameters = true;
								return true;
							}
						}
					}
				}
			}
		}
		return true;
	}
}
?>