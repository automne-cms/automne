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
// $Id: block.php,v 1.6 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_block_cms_forms
  *
  * represent a block of form data inside a row.
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_block_cms_forms extends CMS_block
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
		
		//build the HTML
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			if (isset($data["value"]['formID']) && sensitiveIO::IsPositiveInteger($data["value"]['formID'])) {
				//$form = new CMS_forms_formular($data["value"]['formID']);
				//$html = $form->getContent(CMS_FORMS_PHP_FORM_CALL);
				
				//call cms_forms clientspace content
				$cs = new CMS_moduleClientspace(array("module" => MOD_CMS_FORMS_CODENAME,  "id" => "cms_forms", "type" => "formular", "formID" => $data["value"]['formID']));
				$html = $cs->getClientspaceData(MOD_CMS_FORMS_CODENAME, new CMS_date(), $page, $visualizationMode);
				if ($visualizationMode != PAGE_VISUALMODE_PRINT) {
					//save in global var the page ID who need this module so we can add the header module code later.
					$GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$this->_pageID][] = $data["value"]['formID'];
				}
				return str_replace("{{data}}", $html, $this->_definition);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
		case PAGE_VISUALMODE_HTML_EDITION:
			if ($data && isset($data["value"]['formID']) && sensitiveIO::IsPositiveInteger($data["value"]['formID'])) {
				//$form = new CMS_forms_formular($data["value"]['formID']);
				//$html = $form->getContent(CMS_FORMS_PHP_FORM_CALL);
				
				//call cms_forms clientspace content
				$cs = new CMS_moduleClientspace(array("module" => MOD_CMS_FORMS_CODENAME,  "id" => "cms_forms", "type" => "formular", "formID" => $data["value"]['formID']));
				//$html = $cs->getClientspaceData(MOD_CMS_FORMS_CODENAME, new CMS_date(), $page, $visualizationMode);
				$form = new CMS_forms_formular($data["value"]['formID']);
				$html = $form->getContent(CMS_forms_formular::REMOVE_FORM_SUBMIT);
				return str_replace("{{data}}", $html, $this->_definition);
			}
		break;
		case PAGE_VISUALMODE_FORM:
			if ($data && isset($data["value"]['formID']) && sensitiveIO::IsPositiveInteger($data["value"]['formID'])) {
				$form = new CMS_forms_formular($data["value"]['formID']);
				$html = $form->getContent(CMS_forms_formular::REMOVE_FORM_SUBMIT);
			} else {
				$html = '<img src="'.PATH_MODULES_FILES_WR.'/'.MOD_CMS_FORMS_CODENAME.'/demo.gif" alt="X" title="X" />';
			}
			$form_data = str_replace("{{data}}", $html, $this->_definition);
			$this->_hasContent = ($data && isset($data["value"]['formID'])) ? true:false;
			$this->_editable = true;
			
			global $cms_user;
			$module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);
			$this->_administrable = $module->hasAdmin() && $cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT);
			
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$this->_hasContent = $this->_editable = $this->_administrable = false;
			$html = '<img src="'.PATH_MODULES_FILES_WR.'/'.MOD_CMS_FORMS_CODENAME.'/demo.gif" alt="X" title="X" />';
			$form_data = str_replace("{{data}}", $html, $this->_definition);
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
			'page' => ,
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
		//global $cms_user;
		//$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, '<div class="atm-form-block">'.$data.'</div>');
		
		
		
		global $cms_user;
		$this->_jsBlockClass = 'Automne.blockCMS_Forms';
		$rawDatas = $this->getRawData($page->getID(), $clientSpace->getTagID(), $row->getTagID(), RESOURCE_LOCATION_EDITION, false);
		$datas = array(
			'page'			=> isset($rawDatas['page']) ? $rawDatas['page'] : '',
			'clientSpaceID'	=> isset($rawDatas['clientSpaceID']) ? $rawDatas['clientSpaceID'] : '',
			'rowID'			=> isset($rawDatas['rowID']) ? $rawDatas['rowID'] : '',
			'blockID'		=> isset($rawDatas['blockID']) ? $rawDatas['blockID'] : '',
			'module'		=> MOD_CMS_FORMS_CODENAME
		);
		$this->_value = $datas;
		
		$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, '<div class="atm-form-block atm-block-helper">'.$data.'</div>');
		//load interface instance
		$view = CMS_view::getInstance();
		//append JS block class file
		if (PATH_REALROOT_WR) {
			$file = str_replace(PATH_REALROOT_WR.'/', '', PATH_ADMIN_WR.'/js/edit/block-cms-forms.js');
		} else {
			$file = PATH_ADMIN_WR.'/js/edit/block-cms-forms.js';
		}
		$view->addJSFile($file);
		
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
					value='".SensitiveIO::sanitizeSQLString(serialize($this->_value))."'
			";
			/*$str_set = "
					page=:page,
					clientSpaceID=:clientspace,
					rowID=:rowID,
					blockID=:blockID,
					value=:value
			";
			$sqlParameters = array(
				'page' => $destinationPage->getID(),
				'clientspace' => $this->_clientSpaceID,
				'rowID' => $this->_rowID,
				'blockID' => $this->_tagID,
				'value' => serialize($this->_value),
			);*/
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
				$this->raiseError("Duplicate, insertion failed: ".$sql);
			}
		} else {
			$this->raiseError("Duplicate, object does not have a DB ID, not initialized");
		}
		return false;
	}
}

?>