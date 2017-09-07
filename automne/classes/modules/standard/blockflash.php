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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: blockflash.php,v 1.7 2010/03/08 16:43:29 sebastien Exp $

/**
  * Class CMS_block_flash
  *
  * represent a block of Flash Animation inside a row.
  *
  * @package Automne
  * @subpackage standard
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_block_flash extends CMS_block
{
	const MESSAGE_PAGE_JAVASCRIPT_MANDATORY = 289;
	
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
				//Flash parameters
				$this->_file = $data["file"];
				$this->_width = $data["width"];
				$this->_height = $data["height"];
				$this->_name = $data["name"];
				$this->_version = $data["version"];
				$this->_params = $data["params"];
				$this->_flashvars = $data["flashvars"];
				$this->_flashattributes = $data["attributes"];
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
		$html_attributes = "";
		foreach ($this->_attributes as $name => $value) {
			if ($name != "module" && $name != "type") {
				$html_attributes .= ' '.$name.'="'.$value.'"';
			}
		}
		
		$src = '';
		$this->_hasContent = ($data && $data["file"]) ? true : false;
		
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			if ($this->_hasContent) {
				$language = CMS_languagesCatalog::getByCode($page->getLanguage(true));
				$src = PATH_MODULES_FILES_STANDARD_WR.'/public/'.$data["file"];
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			if ($this->_hasContent) {
				$language = CMS_languagesCatalog::getByCode($page->getLanguage(false));
				$src = PATH_MODULES_FILES_STANDARD_WR.'/edited/'.$data["file"];
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
			if ($this->_hasContent) {
				$language = CMS_languagesCatalog::getByCode($page->getLanguage(false));
				$src = PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"];
			}
			break;
		case PAGE_VISUALMODE_FORM:
			$this->_editable = true;
			if ($this->_hasContent) {
				$language = CMS_languagesCatalog::getByCode($page->getLanguage(false));
				$src = PATH_MODULES_FILES_STANDARD_WR.'/edition/'.$data["file"];
			} else {
				$html = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/flash.gif" alt="X" title="X" />';
				$form_data = str_replace("{{data}}", $html, $this->_definition);
				return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			}
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$this->_hasContent = false;
			$this->_editable = false;
			$html = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/flash.gif" alt="X" title="X" />';
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		}
		if (!$src) {
			return '';
		}
		
		$id = ($data["name"]) ? 'flash-'.sensitiveIO::sanitizeHTMLString($data["name"]) : 'flash-'.md5(mt_rand().microtime());
		$html = '<div>'."\n". //first div is used to avoid row positionning problems
		'	<script type="text/javascript">'."\n".
		'		swfobject.embedSWF(\''.$src.'\', \''.$id.'\', \''.$data['width'].'\', \''.$data['height'].'\', \''.$data['version'].'\', "'.PATH_MAIN_WR.'/swfobject/expressInstall.swf", {'.sensitiveIO::sanitizeJSString($data['flashvars'], false, false).'}, {'.sensitiveIO::sanitizeJSString($data['params'], false, false).'}, {'.sensitiveIO::sanitizeJSString($data['attributes'], false, false).'});'."\n".
		'	</script>'."\n".
		'	<div id="'.$id.'" class="atm-blockflash" style="width:'.$data["width"].'px;height:'.$data["height"].'px;">'."\n".
		'		<noscript>'.$language->getMessage(self::MESSAGE_PAGE_JAVASCRIPT_MANDATORY).'</noscript>'."\n".
		'		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>'."\n".
		'	</div>'.
		'</div>'."\n";
		
		$blockinfos = array('blockflash' => array());
		$blockinfos['blockflash'] = true;
		CMS_module::moduleUsage($page->getID(), MOD_STANDARD_CODENAME, $blockinfos);
		if ($visualizationMode != PAGE_VISUALMODE_FORM) {
			return str_replace("{{data}}", $html, $this->_definition);
		} else {
			$form_data = str_replace("{{data}}", $html, $this->_definition);
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
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
				return array(
							"file" => "",
							"name" => "",
							"width" => "200",
							"height" => "100",
							"version" => "9.0.0",
							"params" => "wmode:'transparent'",
							"flashvars" => "",
							"attributes" => ""
							);
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
			$table = ($public) ? "blocksFlashes_public" : "blocksFlashes_edited";
			break;
		case RESOURCE_LOCATION_ARCHIVED:
			$table = "blocksFlashes_archived";
			break;
		case RESOURCE_LOCATION_DELETED:
			$table = "blocksFlashes_deleted";
			break;
		case RESOURCE_LOCATION_EDITION:
			$table = "blocksFlashes_edition";
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
			if ($data['file']) {
				//get folder for files
				$folder = $this->_getFolderName($location, $public);
				if (file_exists(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['file'])) {
					@unlink(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['file']);
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
				blockID='".$this->_tagID."',
		";
		if ($data["file"]) {
			$sql .= "file='".$data["file"]."',";
		}
		$sql .= "
				name='".SensitiveIO::sanitizeSQLString(SensitiveIO::sanitizeAsciiString($data["name"]))."',
				width='".SensitiveIO::sanitizeSQLString($data["width"])."',
				height='".SensitiveIO::sanitizeSQLString($data["height"])."',
				version='".SensitiveIO::sanitizeSQLString($data["version"])."',
				params='".SensitiveIO::sanitizeSQLString($data["params"])."',
				flashvars='".SensitiveIO::sanitizeSQLString($data["flashvars"])."',
				attributes='".SensitiveIO::sanitizeSQLString($data["attributes"])."'
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
		$this->_jsBlockClass = 'Automne.blockFlash';
		$this->_value = $rawDatas;
		$this->_administrable = false;
		$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, $data);
		return $html;
	}
	
	/**
	  * Get the filename and optionnaly path of a file given its original name
	  * Cleans the name and add the directory where files should reside (when page is un USERSPACE location)
	  * BEWARE ! The path is only used when editing, so it returns the file located in the "edition" subfolder of the blocks files dir.
	  *
	  * @param string $originalName The original name of the file
	  * @param CMS_page &$page The page which contains the block
	  * @param string &$clientspace The clientspace which contains the block
	  * @param string &$row The row which contains the block
	  * @param string &$block The block
	  * @param boolean $withPath If false, only the filename will be returned
	  * @return string The full pathname
	  * @access private
	  */
	function getFilePath($originalName, &$page,&$clientspace,&$row,&$block, $withPath = true)
	{
		$name = md5(mt_rand().microtime());
		$name .= SensitiveIO::sanitizeAsciiString($originalName);
		$name = "p".$page->getID()."_".$name;
		if (io::strlen($name) > 255) {
			$name = sensitiveIO::ellipsis($name, 255, '-', true);
		}
		if ($withPath) {
			return PATH_MODULES_FILES_STANDARD_FS."/edition/".$name;
		} else {
			return $name;
		}
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
		if (SensitiveIO::isPositiveInteger($this->_dbID) && $this->_file) {
			$table = $this->_getDataTableName(RESOURCE_LOCATION_USERSPACE, $public);
			
			//Copy linked file
			//In new file name, delete reference to old page and add refernce to new one
			$_newFilename = "p".$destinationPage->getID().io::substr( $this->_file, io::strpos($this->_file,"_"), io::strlen($this->_file));
			
			if ( @is_file(PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file) 
					&& @copy(PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file, PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename)
					&& @chmod (PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename, octdec(FILES_CHMOD)) ) {
				//Public
				if ($public) {
					if (!@copy(PATH_MODULES_FILES_STANDARD_FS."/public/".$this->_file, PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename)
						|| !@chmod (PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename, octdec(FILES_CHMOD)) ) {
						$this->setError("Duplicate, flash file copy failed : ".PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename);
					}
				}
				//Save new datas
				$str_set = "
						page='".$destinationPage->getID()."',
						clientSpaceID='".$this->_clientSpaceID."',
						rowID='".$this->_rowID."',
						blockID='".$this->_tagID."',
						file='".SensitiveIO::sanitizeSQLString($_newFilename)."',
						width='".SensitiveIO::sanitizeSQLString($this->_width)."',
						height='".SensitiveIO::sanitizeSQLString($this->_height)."',
						name='".SensitiveIO::sanitizeSQLString($this->_name)."',
						version='".SensitiveIO::sanitizeSQLString($this->_version)."',
						params='".SensitiveIO::sanitizeSQLString($this->_params)."',
						flashvars='".SensitiveIO::sanitizeSQLString($this->_flashvars)."',
						attributes='".SensitiveIO::sanitizeSQLString($this->_flashattributes)."'
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
							id='".$q->getLastInsertedID()."',
							".$str_set."
					";
					$q = new CMS_query($sql);
					return !$q->hasError();
				} else {
					$this->setError("Duplicate, SQL insertion of new flash failed: ".$sql);
				}
			} else {
				$this->setError("Duplicate, copy of file failed :".PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file);
			}
		}
		return false;
	}
}
?>