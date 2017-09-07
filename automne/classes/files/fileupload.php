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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: fileupload.php,v 1.4 2010/03/08 16:43:28 sebastien Exp $


/**
  * Class CMS_fileUpload
  *
  * This class manages a file upload onto the server
  * Need to give it at least a path representing the destination of uploaded 
  * file and the file input field name concerned 
  * (used like: $_FILES[$fieldname])
  *
  * Intégration sample where "fieldname" is the name of file input field :
  *     // File upload management
  * 	if ($_POST["edit_fieldname"]) { // comes from a radio to force deletion of previous file
  * 		$o_file_upload = new CMS_fileUpload("fieldname", true);
  * 		$o_file_upload->setPath('origin', $your_value_of_previous_file);
  * 		// Delete previous file
  * 		$o_file_upload->deleteOrigin();
  * 		// Proceed to upload if needed
  * 		if ($_FILES["fieldname"]["name"] && $item->writeToPersistence()) {
  * 			$o_file_upload->setPath('destination', $your_value_of_destination_path);
  * 			if (!$o_file_upload->doUpload()) {
  * 				$cms_message .= "Error message";
  * 			}
  * 		}
  * 		// Do something with filename on success
  *         $your_final_filename = $o_file_upload->getFilename();
  * 	}
  * 
  * @see function doUpload()
  * @see CMS_file
  *
  * @package Automne
  * @subpackage files
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_fileUpload extends CMS_grandFather
{
	/**
	 * Form file input field name bringing uploaded file
	 * 
	 * @var string
	 * @access private
	 */
	protected $_fieldname;
	
	/**
	 * Stores pathes to be managed by this class
	 *  - "destination" represents the path to use to store uploaded file
	 *  - "origin" represents the path of previous file before upload (file to 
	 * be deleted when new one uploaded)
	 * 
	 * @var array("destination" => string, "origin" => string)
	 * @access private
	 */
	protected $_pathes;
	
	/**
	 * Force overwrite of previous destination file if exists before upload
	 * default set to false
	 * 
	 * @var boolean
	 * @access private
	 */
	protected $_overwrite;
	
	/**
	 * File object representing destination file after all
	 * 
	 * @var CMS_file
	 * @access public
	 */
	protected $file;
	
	/**
	 * Constructor
	 * 
	 * @param string $fieldname, the name of the field containing file to upload (ex: $_FILES["fieldname"])
	 * @param boolean $overwrite, if set to true, deletes any previous file 
	 * responding to $destinationPath before uploading new one
	 * @return void
	 */
	function __construct($fieldname = false, $overwrite = false) {
		if ($fieldname != '') {
			$this->_fieldname = (string) $fieldname;
		}
		$this->_overwrite = ($overwrite !== false) ? true : false ;
		$this->_pathes = array (
			"destination" => false,
			"origin" => false
		);
	}
	
	/**
	  * Getter for any private attribute on this class
	  *
	  * @access public
	  * @param string $name
	  * @return string
	  */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	  * Setter for any private attribute on this class
	  *
	  * @access public
	  * @param string $name name of attribute to set
	  * @param $value , the value to give
	  */
	function setAttribute($name, $value) {
		$name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	  * Check that given key (key in $_pathes attribute array) is valid
	  *
	  * @param string $key, the key to test
	  * @return boolean true if a good key, false otherwise
	  * @access private
	  */
	protected function _isValidPathKey($key) {
		return (@in_array($key, @array_keys($this->_pathes))) ? true : false ;
	}
	
	/**
	  * Check any file as destination path and delete it 
	  * if $this->_overwrite attribute set to true
	  *
	  * @return boolean true if proceeded without any error, false otherwise
	  * @access private
	  */
	protected function _checkDestinationPath() {
		if (!$this->_pathes["destination"]) {
			$this->setError("Destination path cannot be empty");
			return false;
		}
		if (!@is_dir($this->getPathBasedir()) || !@is_writable($this->getPathBasedir())) {
			$this->setError("Destination dir doesn't exist or is not writable (".$this->getPathBasedir().")");
			return false;
		}
		if (@is_file($this->_pathes["destination"])) {
			if ($this->_overwrite) {
				if (!@unlink($this->_pathes["destination"])) {
					$this->setError("Destination file already exists (".$this->_pathes["destination"].") and cannot be deleted");
					return false;
				}
			} else {
				$this->setError("Destination file exists (".$this->_pathes["destination"]."), better force its deletion first");
				return false;
			}
		}
		return true;
	}
	
	/**
	  * Check presence of a file and delete it
	  *
	  * @param string $key, which path ?
	  * @return boolean true if deletion succeeded, false otherwise
	  * @access private
	  */
	protected function _deletePathFile($key)
	{
		if (!$this->_isValidPathKey($key)) {
			return false;
		} elseif (@is_file($this->_pathes[$key])) {
			if (!CMS_file::deleteFile($this->_pathes[$key])) {
				$this->setError("File exists (".$this->_pathes[$key].") but cannot be deleted");
				return false;
			} else {
				$this->_pathes[$key] = false;
				return true;
			}
		} else {
			$this->setError("File does not exists (".$this->_pathes[$key].")");
			return false;
		}
	}
	
	/**
	  * Getter for a path, given its key in $_pathes attribute array
	  *
	  * @access public
	  * @param string $key, which path ?
	  * @return string
	  */
	function getPath($key = false) {
		if ($this->_isValidPathKey($key)) {
			return $this->_pathes[$key];
		} else {
			return false;
		}
	}
	
	/**
	  * Set a path, given its key
	  *
	  * @access public
	  * @param string $key, which path ?
	  * @param string $value, value to set
	  * @return boolean true on success, false otherwise
	  */
	function setPath($key, $value) {
		if ($this->_isValidPathKey($key)) {
			$this->_pathes[$key] = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the overwrite behaviour
	  *
	  * @return boolean true if will overwrite, false otherwise
	  * @access public
	  */
	function overwrite() {
		return $this->_overwrite;
	}
	
	/**
	  * Says if there is something uploaded
	  *
	  * @return boolean true if ready to move upload 
	  * @access public
	  */
	function ready() {
		return ( $this->_fieldname != '' && $this->getInputValue("name") != '' );
	}
	
	/**
	  * Gets one path filename
	  *
	  * @param string $key, which path ?
	  * @return string, the filename
	  * @access public
	  */
	function getFilename($key = 'destination') {
		if ($this->_isValidPathKey($key)) {
			return @basename($this->_pathes[$key]);
		} else {
			return '';
		}
	}
	
	/**
	  * Check file size and server max uploading file size
	  *
	  * @return boolean true if too wide, false otherwise
	  * @access public
	  */
	function inputFileTooWide() {
		if ($_FILES[$this->_fieldname]["error"] == 1 
				|| $_FILES[$this->_fieldname]["size"] > (ini_get("upload_max_filesize") * 1048576) ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets an input field value (from $_FILES[$this->_fieldname][$key] Array)
	  *
	  * @param string $key, which key corresponding to wanted value
	  * @return mixed, the value of input file array
	  * @access public
	  */
	function getInputValue($key) {
		return $_FILES[$this->_fieldname][$key];
	}
	
	/**
	  * Get one path base directory
	  *
	  * @param string $key, which path ?
	  * @return string, the directory
	  * @access public
	  */
	function getPathBasedir($key = 'destination') {
		if ($this->_isValidPathKey($key)) {
			return @dirname($this->_pathes[$key]);
		} else {
			return '';
		}
	}
	
	/**
	  * Deletes file stored before fileUpload attempts to replace it
	  * Return true either file does not exists or file is deleted successfully
	  * This method is not called from doUpload(), use it manually first !
	  *
	  * @return boolean true if deletion succeeded, false otherwise
	  * @access public
	  */
	function deleteOrigin()
	{
		return (@is_file($this->_pathes["origin"])) ? $this->_deletePathFile("origin") : true ;
	}
	
	/**
	  * Proceed to file upload 
	  *
	  * @return boolean true if file upload successfully done, false otherwise
	  * @access public
	  */
	function doUpload()
	{
		if ($this->ready()) {
			if ($this->_checkDestinationPath()) {
				// Check file size and server max uploading file size
				if ($this->inputFileTooWide()) {
					$this->setError("File too wide for server (".$this->getInputValue("name")."), upload failed");
					return false;
				}
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($this->getInputValue("tmp_name"), PATH_TMP_FS);
				if ($fileDatas['error']) {
					$this->setError("Move uploaded file ".$this->getInputValue("tmp_name")." to ".$this->_pathes["destination"]." failed");
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $this->_pathes["destination"])) {
					$this->setError("Move uploaded file ".$this->getInputValue("tmp_name")." to ".$this->_pathes["destination"]." failed");
					return false;
				}
				$this->file = new CMS_file($this->_pathes["destination"]);
				return $this->file->chmod(FILES_CHMOD);
			} else {
				return false;
			}
		}
		return true;
	}
}
?>
