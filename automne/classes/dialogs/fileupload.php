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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: fileupload.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_fileUpload_dialog
  *
  * This class manages a file upload onto the server
  * Need to give it at least a path representing the destination of uploaded 
  * file and the file input field name concerned 
  * (used like: $_FILES[$fieldname])
  * @see CMS_fileUpload
  *
  * Intégration samples (Where "file" is the $_FILES field name and 
  * $_POST["edit_file"] is used as a flag to determine if previous image has 
  * to be deleted before new upload)
  * 
  * a) For a CMS_resource :
  * 
  *   // Image upload management
  * 	$o_file_upload = new CMS_fileUpload_dialog("file");
  * 	$b_uploaded = $o_file_upload->doUploadForResource(
  * 		$item,
  * 		$cms_module->getCodename(),
  * 		$item->getImagePath(true, RESOURCE_DATA_LOCATION_EDITED, PATH_RELATIVETO_FILESYSTEM),
  * 		$_POST["edit_file"],
  * 		(integer) $cms_module->getParameters("image_max_width")
  * 	);
  * 	if (!$b_uploaded) {
  * 		$cms_message .= $o_file_upload->getErrorMessage($cms_language);
  * 	} else {
  * 		$item->setImage($o_file_upload->getFilename());
  * 		$item->writeToPersistence();
  * 	}
  * @see doUploadForResource()
  * 
  * b) In any other situation :
  * 
  *     // an icon upload management for any purpose
  * 	$o_file_upload = new CMS_fileUpload_dialog("file");
  * 	$o_file_upload->setOrigin($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM), $_POST["edit_file"]);
  * 	if ($o_file_upload->ready() && $item->writeToPersistence()) {
  *         // Destination file personnalized
  * 		$o_file_upload->setDestination($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, false)."/cat-".$item->getID()."-icon".strrchr($_FILES["file"]["name"], "."));
  * 	}
  * 	if (!$o_file_upload->doUpload()) {
  * 		$cms_message .= $o_file_upload->getErrorMessage($cms_language);
  * 	} else {
  * 		$item->setIcon($o_file_upload->getFilename());
  * 		$item->writeToPersistence();
  * 	}
  *
  * @package CMS
  * @subpackage files
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_fileUpload_dialog extends CMS_grandFather
{
	/**
	  * Messages
	  */
	const MESSAGE_ERROR_FILE_UPLOAD = 196;
	const MESSAGE_ERROR_FILE_TOO_WIDE = 1193;
	const MESSAGE_ERROR_IMAGE_TOO_WIDE = 10008;
	
	
	/**
	  * CMS_fileUpload object to use to handle upload
	  * 
	  * @var CMS_fileUpload
	  * @access private
	  */
	protected $_fileUpload;
	
	/**
	  * This boolean determine if deletion of previous file
	  * must be executed before upload starts
	  * 
	  * @var boolean
	  * @access private
	  */
	protected $_overwrite;
	
	/**
	  * This attribute represents is used to return an i18NM_message 
	  * through a CMS_language object
	  * 
	  * @see getErrorMessage()
	  * @var array(integer, array(string))
	  * @access private
	  */
	protected $_errorMessages = array();
	
	/**
	 * Constructor
	 * 
	 * @param string $fieldname, the name of the field containing file to upload (ex: $_FILES["fieldname"])
	 * @param boolean $overwrite, if set to true, deletes any previous file 
	 * responding to $destinationPath before uploading new one
	 * @return void
	 */
	function __construct($fieldname = false, $overwrite = false) {
		$this->_overwrite = ($overwrite !== false) ? true : false ;
		$this->_fileUpload = new CMS_fileUpload((string) $fieldname, $this->_overwrite);
	}
	
	/**
	  * Getter for origin path file
	  *
	  * @access public
	  * @return string
	  */
	function getOrigin() {
		return $this->_fileUpload->getPath('origin');
	}
	
	/**
	  * Set origin path
	  *
	  * @access public
	  * @param string $value, value to set
	  * @return boolean true on success, false otherwise
	  */
	function setOrigin($value, $overwrite = false) {
		if ($overwrite) {
			$this->_overwrite = true;
			$this->_fileUpload->setAttribute('overwrite', $this->_overwrite);
		}
		return $this->_fileUpload->setPath('origin', $value);
	}
	
	/**
	  * Getter for destination path file
	  *
	  * @access public
	  * @return string
	  */
	function getDestination() {
		return $this->_fileUpload->getPath('destination');
	}
	
	/**
	  * Set destination path
	  *
	  * @access public
	  * @param string $value, value to set
	  * @return boolean true on success, false otherwise
	  */
	function setDestination($value) {
		return $this->_fileUpload->setPath('destination', $value);
	}
	
	/**
	  * Get destination filename
	  *
	  * @return string, the filename
	  * @access public
	  */
	function getFilename() {
		return $this->_fileUpload->getFilename();
	}
	
	/**
	  * Says if there is something uploaded
	  *
	  * @return boolean true if ready to move upload
	  * @access public
	  */
	function ready() {
		return $this->_fileUpload->ready();
	}
	
	/**
	  * Get error message if process fails somehow
	  *
	  * @access public
	  * @return string
	  */
	function getErrorMessage(&$cms_language) {
		if (!is_a($cms_language, 'CMS_language')) {
			return false;
		}
		if (is_array($this->_errorMessages) && $this->_errorMessages) {
			return (string) $cms_language->getMessage($this->_errorMessages[0], $this->_errorMessages[1])."\n";
		} else {
			return false;
		}
	}
	
	/**
	  * Proceed to file upload 
	  *
	  * @return boolean true if file upload successfully done, false otherwise
	  * @access public
	  */
	function doUpload()
	{
		if ($this->_overwrite) {
			$this->_fileUpload->deleteOrigin();
		}
		if ($this->ready()) {
			if (!$this->_fileUpload->doUpload()) {
				$this->_errorMessages = array(self::MESSAGE_ERROR_FILE_UPLOAD);
				return false;
			} else {
				return true;
			}
		}
		return true;
	}
	
	/**
	  * For an easy acces from a CMS_resource management page
	  * Sets the CMS_resource receiving the file uploaded and proceed to upload
	  * at the same time
	  * Given object must have these methods : getID() and writeToPersistence()
	  * they help determining thename of uploaded file
	  *
	  * @access public
	  * @param CMS_resource $obj, the object receiving file uploaded as a field
	  * @param string $moduleCodename, the module of the resource
	  * @param string $originPath, path of current file to delete before upload
	  * @param boolean $overwrite, if set to true, deletes any previous file
	  * @param integer $maxwidth, maxwidth allowed for an image
	  * @return boolean true on success, false otherwise
	  */
	function doUploadForResource(&$obj, $moduleCodename, $originPath = false, $overwrite = false, $maxwidth = false) {
		
		if ($overwrite) {
			$this->_overwrite = true;
			$this->_fileUpload->setAttribute('overwrite', $this->_overwrite);
		}
		
		if ( is_a($obj, 'CMS_resource') 
				&& method_exists($obj, 'getID')
				&& method_exists($obj, 'writeToPersistence')
				&& $moduleCodename != ''
				&& $this->_overwrite) {
			if ($originPath) {
				$this->_fileUpload->setPath('origin', $originPath);
			}
			if (SensitiveIO::isPositiveInteger($maxwidth)) {
				$sizes = @getimagesize($this->_fileUpload->getInputValue("tmp_name"));
				if ($sizes[0] > $maxwidth) {
					$this->_errorMessages = array(self::MESSAGE_ERROR_IMAGE_TOO_WIDE, array($maxwidth));
					return false;
				}
			}
			$f = SensitiveIO::sanitizeAsciiString($this->_fileUpload->getInputValue("name"));
			if ($f != '' && $obj->writeToPersistence()) {
				$path = PATH_MODULES_FILES_FS."/".$moduleCodename."/".RESOURCE_DATA_LOCATION_EDITED;
				$path .= "/r".$obj->getID()."_".$f;
				$this->_fileUpload->setPath('destination', $path);
			}
			// Check file size
			if ($this->_fileUpload->inputFileTooWide()) {
				$this->_errorMessages = array(self::MESSAGE_ERROR_FILE_TOO_WIDE);
				return false;
			}
			return $this->doUpload();
		}
		return false;
	}
}
?>
