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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &			  |
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &			  |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>  			  |
// +----------------------------------------------------------------------+
//
// $Id: blockimage.php,v 1.8 2010/03/08 16:43:29 sebastien Exp $

/**
  * Class CMS_block_image
  *
  * represent a block of zoomable image data inside a row.
  * This block actually can contain 2 images, one for standard viewing and a
  * second which is the same, enlarged. The second one is optional.
  *
  * @package CMS
  * @subpackage module
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */

class CMS_block_image extends CMS_block
{
	/**
	* Name of the enlarged image pop-up
	*/
	const BLOCK_IMAGE_POPUP = "imagezoom.php";
	/**
	* is image resizeable ?
	*
	* @var boolean
	* @access private
	*/
	protected $_resizeable=false;
	
	/**
	* block have content attached ?
	*
	* @var boolean
	* @access private
	*/
	protected $_hasContent;
	
	/**
	* image have a maximum width size ?
	*
	* @var integer : the number of pixel width
	* @access private
	*/
	protected $_maxWidth;
	
	/**
	* image have a minimum width size ?
	*
	* @var integer : the number of pixel width
	* @access private
	*/
	protected $_minWidth;
	
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
				$this->_label = $data["label"];
				$this->_file = $data["file"];
				$this->_enlargedFile = $data["enlargedFile"];
				$this->_externalLink = $data["externalLink"];
				
				$this->_resizeable = ($data["file"]) ? true:false;
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
		$s = "";
		foreach ($this->_attributes as $name => $value) {
			if ($name != "module" && $name != "type" && $name != "maxWidth" && $name != "minWidth") {
				$html_attributes .= ' '.$name.'="'.$value.'"';
			} elseif ($name == "maxWidth") {
				$this->_maxWidth=$value;
			} elseif ($name == "minWidth") {
				$this->_minWidth=$value;
			}
		}
		$this->_hasContent = ($data && $data["file"]) ? true : false;
		
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			if ($this->_hasContent) {
				return $this->_replaceBlockVars($data, $html_attributes, RESOURCE_DATA_LOCATION_PUBLIC, true);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			if ($this->_hasContent) {
				return $this->_replaceBlockVars($data, $html_attributes, RESOURCE_DATA_LOCATION_PUBLIC, false);
			}
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
			if ($this->_hasContent) {
				return $this->_replaceBlockVars($data, $html_attributes, RESOURCE_DATA_LOCATION_EDITION, false);
			}
			break;
		case PAGE_VISUALMODE_FORM:
			$this->_editable = true;
			if ($this->_hasContent) {
				$form_data=$this->_replaceBlockVars($data, $html_attributes, RESOURCE_DATA_LOCATION_EDITION, false);
			} else {
				$replace = array(
					'{{data}}'				=> '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/image.gif" alt="X" title="X" '.$html_attributes.' />',
					'{{label}}'				=> io::htmlspecialchars($data["label"]),
					'{{jslabel}}'			=> io::htmlspecialchars($data["label"]),
					'{{linkLabel}}'			=> io::htmlspecialchars($data["label"]),
					'{{imageZoomHtml}}'	 	=> '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/image.gif" alt="X" title="X" '.$html_attributes.' />',
					'{{imagePath}}'			=> PATH_MODULES_FILES_STANDARD_WR,
					'{{imageName}}'			=> 'image.gif',
					'{{imageZoomHref}}'		=> '',
					'{{imageZoomName}}'	 	=> '',
					'{{imageWidth}}'        => '80',
					'{{imageHeight}}'       => '80',
					'{{imageZoomWidth}}'    => '0',
					'{{imageZoomHeight}}'   => '0',
				);
				$form_data = str_replace(array_keys($replace), $replace, $this->_definition);
			}
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$this->_hasContent = false;
			$this->_editable = false;
			$replace = array(
				'{{data}}'				=> '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/image.gif" alt="X" title="X" '.$html_attributes.' />',
				'{{label}}'				=> io::htmlspecialchars($data["label"]),
				'{{jslabel}}'			=> io::htmlspecialchars($data["label"]),
				'{{linkLabel}}'			=> io::htmlspecialchars($data["label"]),
				'{{imageZoomHtml}}'	 	=> '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/image.gif" alt="X" title="X" '.$html_attributes.' />',
				'{{imagePath}}'			=> PATH_MODULES_FILES_STANDARD_WR,
				'{{imageName}}'			=> 'image.gif',
				'{{imageZoomHref}}'		=> '',
				'{{imageZoomName}}'	 	=> '',
				'{{imageWidth}}'        => '80',
				'{{imageHeight}}'       => '80',
				'{{imageZoomWidth}}'    => '0',
				'{{imageZoomHeight}}'   => '0',
			);
			
			$form_data = str_replace(array_keys($replace), $replace, $this->_definition);
			return $this->_getHTMLForm($language, $page, $clientSpace, $row, $this->_tagID, $form_data);
			break;
		}
	}
	
	/**
	* Replace block definition vars.
	*
	* @param array data : the block datas
	* @param string html_attributes : html attributes
	* @param integer $location The location of the page
	* @param boolean $public The needed precision for USERSPACE location
	* @return string the HTML data
	* @access public
	*/
	function _replaceBlockVars($data, $html_attributes, $location, $public) {
		switch ($location) {
		case RESOURCE_DATA_LOCATION_PUBLIC:
			$folder = ($public) ? "public" : "edited";
			break;
		case RESOURCE_DATA_LOCATION_ARCHIVED:
			$folder = "archived";
			break;
		case RESOURCE_DATA_LOCATION_DELETED:
			$folder = "deleted";
			break;
		case RESOURCE_DATA_LOCATION_EDITION:
			$folder = "edition";
			break;
		}
		$currentLink = new CMS_href($data["externalLink"]);

		//must put the main website URL before
		$html_imgZoomHtml='';
		$html_imgZoomName='';
		$html_imageZoomHref='';
		$html_imageZoomPop='';
		if ($data["file"]) {
			$html_img = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/'.$folder.'/'.$data["file"].'" alt="'.io::htmlspecialchars($data["label"]).'" title="' . io::htmlspecialchars($data["label"]) . '" '.$html_attributes.' />';
		}
		if ($data["enlargedFile"]) {
			$html_imgZoomName = $data["enlargedFile"];
			$html_imgZoomHtml = '<img src="'.PATH_MODULES_FILES_STANDARD_WR.'/'.$folder.'/'.$data["enlargedFile"].'" alt="'.io::htmlspecialchars($data["label"]).'" title="' . io::htmlspecialchars($data["label"]) . '" '.$html_attributes.' />';
		}
		if ($data["enlargedFile"]) {
			$href = PATH_REALROOT_WR . "/" . CMS_block_image::BLOCK_IMAGE_POPUP . '?location='.$folder.'&amp;file=' . $data["enlargedFile"] . '&amp;label=' . urlencode($data["label"]);
			$popup = (OPEN_ZOOMIMAGE_IN_POPUP) ? ' onclick="javascript:CMS_openPopUpImage(\''.addslashes($href).'\');return false;"':'';
			if ($html_img) {
				$html = '<a target="_blank" href="'. $href . '"'.$popup.' title="' . io::htmlspecialchars($data["label"]) . '">' . $html_img . '</a>';
			}
			$html_imageZoomHref = $href;
			$linkLabel = '<a class="imagezoomlink" target="_blank" href="'. $href . '"'.$popup.' title="' . io::htmlspecialchars($data["label"]) . '">' . io::htmlspecialchars($data["label"]) . '</a>';
		} else {
			if ($currentLink->getHTML(false,MOD_STANDARD_CODENAME,$location)) {
				$html = $currentLink->getHTML($html_img,MOD_STANDARD_CODENAME, $location);
				$currentLink->setLabel('');
				$linkLabel = $currentLink->getHTML($data['label'],MOD_STANDARD_CODENAME, $location);
			} else {
				$html = $html_img;
				$linkLabel = io::htmlspecialchars($data["label"]);
			}
		}
		$replace = array(
			'{{data}}'			=> $html,
			'{{label}}'			=> io::htmlspecialchars($data["label"]),
			'{{jslabel}}'		=> io::htmlspecialchars($data["label"]),
			'{{linkLabel}}'		=> $linkLabel,
			'{{imageZoomHtml}}'	=> $html_imgZoomHtml,
			'{{imagePath}}'		=> PATH_MODULES_FILES_STANDARD_WR.'/'.$folder,
			'{{imageName}}'		=> $data["file"],
			'{{imageZoomHref}}'	=> $html_imageZoomHref,
			'{{imageZoomName}}'	=> $html_imgZoomName,
		);
		if (io::strpos($this->_definition,'Width}}') !== false || io::strpos($this->_definition,'Height}}') !== false) {
			list($sizeX, $sizeY) = @getimagesize(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data["file"]);
			if (isset($data["enlargedFile"])) {
				list($sizeZoomX, $sizeZoomY) = @getimagesize(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data["enlargedFile"]);
			}
			$replace['{{imageWidth}}']		= (isset($sizeX)) ? $sizeX : "0";
			$replace['{{imageHeight}}']	 	= (isset($sizeY)) ? $sizeY : "0";
			$replace['{{imageZoomWidth}}']  = (isset($sizeZoomX)) ? $sizeZoomX : "0";
			$replace['{{imageZoomHeight}}'] = (isset($sizeZoomY)) ? $sizeZoomY : "0";
		}
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
				return $q->getArray();
			} else {
				return array("file" => "", "enlargedFile" =>"", "label" => "", "externalLink" => "");
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
			$table = ($public) ? "blocksImages_public" : "blocksImages_edited";
			break;
		case RESOURCE_LOCATION_ARCHIVED:
			$table = "blocksImages_archived";
			break;
		case RESOURCE_LOCATION_DELETED:
			$table = "blocksImages_deleted";
			break;
		case RESOURCE_LOCATION_EDITION:
			$table = "blocksImages_edition";
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
			$this->raiseError("DelFromLocation was given a bad location");
			return false;
		}
		if ($withfile) {
			$data = $this->getRawData($pageID, $clientSpaceID, $rowID, $location, $public);
			$folder = $this->_getFolderName($location, $public);
			if($data['file']) {
				//get folder for files
				if (file_exists(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['file'])) {
					@unlink(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['file']);
				}
			}
			if($data['enlargedFile']) {
				//get folder for files
				if (file_exists(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['enlargedFile'])) {
					@unlink(PATH_MODULES_FILES_STANDARD_FS.'/'.$folder.'/'.$data['enlargedFile']);
				}
			}
			if ($data['externalLink']) {
				$link = new CMS_href($data["externalLink"]);
				$file = $link->getFileLink(true, MOD_STANDARD_CODENAME, $folder, PATH_RELATIVETO_FILESYSTEM);
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
				blockID='".$this->_tagID."',
		";
		if ($data["file"]) {
			$sql .= "file='".$data["file"]."',";
		}
		if ($data["enlargedFile"]) {
			$sql .= "enlargedFile='".$data["enlargedFile"]."',";
		}
		$sql .= "
				externalLink = '" . SensitiveIO::sanitizeSQLString($data["externalLink"]) . "',
				label='".SensitiveIO::sanitizeSQLString(stripslashes($data["label"]))."'
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
		$this->_jsBlockClass = 'Automne.blockImage';
		$datas = array(
			'page'			=> isset($rawDatas['page']) ? $rawDatas['page'] : '',
			'clientSpaceID'	=> isset($rawDatas['clientSpaceID']) ? $rawDatas['clientSpaceID'] : '',
			'rowID'			=> isset($rawDatas['rowID']) ? $rawDatas['rowID'] : '',
			'blockID'		=> isset($rawDatas['blockID']) ? $rawDatas['blockID'] : '',
			'minwidth'		=> $this->_minWidth,
			'maxwidth'		=> $this->_maxWidth,
		);
		$this->_value = $datas;
		$this->_administrable = false;
		$html = parent::_getHTMLForm($language, $page, $clientSpace, $row, $blockID, $data);
		return $html;
	}
	
	
	/**
	* Get the filename and optionnaly path of a file given its original name
	* Cleans the name and add the directory where files should reside (when page is un USERSPACE location)
	*
	* @param string $originalName The original name of the file
	* @param CMS_page &$page The page which contains the block
	* @param string &$clientspace The clientspace which contains the block
	* @param string &$row The row which contains the block
	* @param string &$block The block
	* @param boolean $withPath If false, only the filename will be returned
	* @param boolean $isEnlarged Is it the enlarged image we want the path of ?
	* @return string The full pathname
	* @access private
	*/
	function getFilePath($originalName, &$page,&$clientspace,&$row,&$block, $withPath = true, $isEnlarged = false)
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
			
			if (@is_file(PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file) 
				&& @copy(PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file, PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename)
				&& @chmod (PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newFilename, octdec(FILES_CHMOD)) ) {
				//Public
				if ($public) {
					if (!@copy(PATH_MODULES_FILES_STANDARD_FS."/public/".$this->_file, PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename)
						|| !@chmod (PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename, octdec(FILES_CHMOD)) ) {
						$this->raiseError("Duplicate, copy of new file failed : ".PATH_MODULES_FILES_STANDARD_FS."/public/".$_newFilename);
					}
				}
				$_newEnlargedFilename = '';
				//With enlarged file
				if ($this->_enlargedFile!='') {
					
					$_newEnlargedFilename = "p".$destinationPage->getID().io::substr( $this->_enlargedFile, io::strpos($this->_enlargedFile,"_"), io::strlen($this->_enlargedFile));
					
					//Edited
					if (!@copy(PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_enlargedFile, PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newEnlargedFilename)
						|| !@chmod (PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newEnlargedFilename, octdec(FILES_CHMOD)) ) {
						$this->raiseError("Duplicate, copy of new enlarged file failed : ".PATH_MODULES_FILES_STANDARD_FS."/edited/".$_newEnlargedFilename);
					}
					//Public
					if ($public) {
						if (!@copy(PATH_MODULES_FILES_STANDARD_FS."/public/".$this->_enlargedFile, PATH_MODULES_FILES_STANDARD_FS."/public/".$_newEnlargedFilename)
							|| !@chmod (PATH_MODULES_FILES_STANDARD_FS."/public/".$_newEnlargedFilename, octdec(FILES_CHMOD)) ) {
							$this->raiseError("Duplicate, copy of new enlarged file failed : ".PATH_MODULES_FILES_STANDARD_FS."/public/".$_newEnlargedFilename);
						}
					}
				}
				
				//Save new datas
				$str_set = "
						page='".$destinationPage->getID()."',
						clientSpaceID='".$this->_clientSpaceID."',
						rowID='".$this->_rowID."',
						blockID='".$this->_tagID."',
						label='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($this->_label))."',
						file='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($_newFilename))."',
						externalLink='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($this->_externalLink))."',
						enlargedFile='".SensitiveIO::sanitizeSQLString(SensitiveIO::stripPHPTags($_newEnlargedFilename))."'
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
					$this->raiseError("Duplicate, SQL insertion of new filename failed : ".$sql);
				}
			} else {
				$this->raiseError("Duplicate, copy of file failed :".PATH_MODULES_FILES_STANDARD_FS."/edited/".$this->_file);
			}
		}
		return false;
	}
}
?>