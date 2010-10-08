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
  * Class CMS_image
  *
  * This script aimed to manage images files. it extends CMS_file
  *
  * @package Automne
  * @subpackage files
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
  
class CMS_image extends CMS_file
{
	/**
	 * Width size of the image in pixels
	 * @var integer the width size
	 * @access public
	 */
	protected $_width = null;
	
	/**
	 * Height size of the image in pixels
	 * @var integer the height size
	 * @access public
	 */
	protected $_height = null;
	
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the file or dir
	 * @param integer $from, the file path is : self::FILE_SYSTEM or self::WEBROOT
	 * @param integer $type, the type of the current object : self::TYPE_FILE for a file, self::TYPE_DIRECTORY for a dir, false for undefined
	 * @return void
	 */
	function __construct($name, $from=self::FILE_SYSTEM, $type=self::TYPE_FILE) {
		parent::__construct($name, $from, $type);
		if (!in_array($this->getExtension(), array('gif', 'png', 'jpg', 'jpe', 'jpeg'))) {
			$this->raiseError('File extension is not a valid image extension : '.$this->getExtension());
			return false;
		}
	}
	
	function getWidth() {
		if ($this->_width === null) {
			$this->_loadImageSize();
		}
		return $this->_width;
	}
	
	function getHeight() {
		if ($this->_height === null) {
			$this->_loadImageSize();
		}
		return $this->_height;
	}
	
	private function _loadImageSize() {
		if ($this->exists()) {
			list($this->_width, $this->_height) = @getimagesize($this->getFilename());
		}
	}
	
	function resize($resizedImagepathFS, $newSizeX, $newSizeY) {
		$imagepathFS = $this->getFilename();
		$sizeX = $this->getWidth();
		$sizeY = $this->getHeight();
		
		//resize image and keep transparency if any
		switch ($this->getExtension()) {
			case "gif":
				$src = imagecreatefromgif($imagepathFS);
				$dest = imagecreate($newSizeX,$newSizeY);
				$transparent = imagecolortransparent($src);
				// If we have a specific transparent color
				if ($transparent >= 0) {
					$transColor    = imagecolorsforindex($src, $transparent);
					$transparent    = imagecolorallocate($dest, $transColor['red'], $transColor['green'], $transColor['blue']);
					imagefill($dest, 0, 0, $transparent);
					imagecolortransparent($dest, $transparent);
				}
				//create new image
				imagecopyresampled($dest, $src, 0, 0, 0, 0, $newSizeX, $newSizeY, $sizeX, $sizeY);
				imagegif($dest, $resizedImagepathFS);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
			case "jpg":
			case "jpeg":
			case "jpe":
				$src = imagecreatefromjpeg($imagepathFS);
				$dest = imagecreatetruecolor($newSizeX, $newSizeY);
				//create new image
				imagecopyresampled($dest, $src, 0, 0, 0, 0, $newSizeX, $newSizeY, $sizeX, $sizeY);
				imagejpeg($dest, $resizedImagepathFS);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
			case "png":
				$src = imagecreatefrompng($imagepathFS);
				$dest = imagecreatetruecolor($newSizeX, $newSizeY);
				//save alpha channel
				imagealphablending($dest, false);
				imagesavealpha($dest,true);
				$transparent = imagecolorallocatealpha($dest, 255, 255, 255, 127);
				imagefilledrectangle($dest, 0, 0, $newSizeX, $newSizeY, $transparent);
				//create new image
				imagecopyresampled($dest, $src, 0, 0, 0, 0, $newSizeX, $newSizeY, $sizeX, $sizeY);
				imagepng($dest, $resizedImagepathFS);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
		}
		//chmod new file
		CMS_file::chmodFile(FILES_CHMOD, $resizedImagepathFS);
		
		return true;
	}
}
?>