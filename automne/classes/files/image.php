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
  * This script aimed to manage images files for crop and resize. it extends CMS_file
  * It handle JPG, PNG and GIF formats and respect alpha channel or transparency of files
  *
  * @package Automne
  * @subpackage files
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_image extends CMS_file
{
	/**
	 * @constant integer the jpg quality used from 0 (min quality) to 100 (max quality)
	 * @access public
	 */
	const JPEG_QUALITY = 90;
	/**
	 * @constant integer the png compression used from 0 (max quality) to 9 (min quality)
	 * @access public
	 */
	const PNG_COMPRESSION = 9;
	
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
	
	/**
	 * Get current image width in pixels
	 * 
	 * @return integer : the current image width
	 * @access public
	 */
	function getWidth() {
		if ($this->_width === null) {
			$this->_loadImageSize();
		}
		return $this->_width;
	}
	
	/**
	 * Get current image height in pixels
	 * 
	 * @return integer : the current image height
	 * @access public
	 */
	function getHeight() {
		if ($this->_height === null) {
			$this->_loadImageSize();
		}
		return $this->_height;
	}
	
	/**
	 * Load current image size from file
	 * 
	 * @return void
	 * @access private
	 */
	private function _loadImageSize() {
		if ($this->exists()) {
			@list($this->_width, $this->_height) = @getimagesize($this->getFilename());
		}
	}
	
	/**
	 * Resize current image to a specified size
	 * 
	 * @param integer $newSizeX, the new width size for the image in pixels
	 * @param integer $newSizeY, the new height size for the image in pixels
	 * @param integer $saveToPathFS, save resized image to given FS path instead of replacing current one
	 * @param boolean $keepRatio, keep current image ratio (default : true)
	 * @param boolean $crop, crop image if needed to respect ratio and image dimension queried (default : false)
	 * @return boolean true on success, false on failure
	 * @access public
	 */
	function resize($newSizeX, $newSizeY, $saveToPathFS = '', $keepRatio = true, $crop = false) {
		$imagepathFS = $this->getFilename();
		$sizeX = $this->getWidth();
		$sizeY = $this->getHeight();
		if (!io::isPositiveInteger($sizeX) || !io::isPositiveInteger($sizeY)) {
			$this->raiseError('Unkown image size ...');
			return false;
		}
		//if no resize needed
		if ($sizeX == $newSizeX && $sizeY == $newSizeY) {
			if (!$saveToPathFS) {
				return true;
			}
			return CMS_file::copyTo($imagepathFS, $saveToPathFS);
		}
		//if we do not have a path to save image, replace current file
		if (!$saveToPathFS) {
			$this->_height = $this->_width = null;
			$saveToPathFS = $imagepathFS;
		}
		if ($keepRatio) {
			//store original queried size
			$x = $newSizeX;
			$y = $newSizeY;
			if (!$crop) {
				// set new image dimensions without crop
				$newSizeX = $sizeX;
				$newSizeY = $sizeY;
				if ($x && $newSizeX > $x) {
					$newSizeY = round(($x * $newSizeY) / $newSizeX);
					$newSizeX = $x;
				}
				if($y && $newSizeY > $y){
					$newSizeX = round(($y * $newSizeX) / $newSizeY);
					$newSizeY = $y;
				}
			} else {
				// set new image dimensions with crop
				if ($sizeX == $x || $sizeY == $y) {
					$newSizeX = $sizeX;
					$newSizeY = $sizeY;
				} else {
					if ($sizeX > $sizeY) {
						$ratio = $sizeY / $sizeX;
					} else {
						$ratio = $sizeX / $sizeY;
					}
					if (round(($newSizeX * $sizeY) / $sizeX) <= $newSizeY) {
						$newSizeX = round(($newSizeY * $sizeX) / $sizeY);
						$newSizeY = round($newSizeX * $ratio);
					} else {
						$newSizeY = round(($newSizeX * $sizeY) / $sizeX);
						$newSizeX = round($newSizeY * $ratio);
					}
				}
			}
		}
		
		//resize image
		if ($newSizeX < $sizeX || $newSizeY < $sizeY) {
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
					imagegif($dest, $saveToPathFS);
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
					imagejpeg($dest, $saveToPathFS, self::JPEG_QUALITY);
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
					imagepng($dest, $saveToPathFS, self::PNG_COMPRESSION);
					//destroy resources
					imagedestroy($src);
					imagedestroy($dest);
				break;
			}
			//chmod new file
			CMS_file::chmodFile(FILES_CHMOD, $saveToPathFS);
		}
		
		//check for crop if needed
		if ($keepRatio && $crop && ($newSizeX > $x || $newSizeY > $y)) {
			$cropTop = $cropBottom = $cropLeft = $cropRight = 0;
			//calculate crop values
			if ($newSizeX > $x) {
				$cropLeft = ceil(($newSizeX - $x) / 2);
				$cropRight = floor(($newSizeX - $x) / 2);
			}
			if ($newSizeY > $y) {
				$cropTop = ceil(($newSizeY - $y) / 2);
				$cropBottom = floor(($newSizeY - $y) / 2);
			}
			if (!file_exists($saveToPathFS)) {
				CMS_file::copyTo($imagepathFS, $saveToPathFS);
			}
			$tmpImage = new CMS_image($saveToPathFS);
			return $tmpImage->crop($cropTop, $cropBottom, $cropLeft, $cropRight);
		}
		return true;
	}
	
	/**
	 * Crop current image from specified dimensions
	 * 
	 * @param integer $cropTop, the top value of the crop in pixels
	 * @param integer $cropBottom, the bottom value of the crop in pixels
	 * @param integer $cropLeft, the left value of the crop in pixels
	 * @param integer $cropRight, the right value of the crop in pixels
	 * @param integer $saveToPathFS, save cropped image to given FS path instead of replacing current one
	 * @return boolean true on success, false on failure
	 * @access public
	 */
	function crop($cropTop, $cropBottom, $cropLeft, $cropRight, $saveToPathFS = '') {
		$imagepathFS = $this->getFilename();
		$sizeX = $this->getWidth();
		$sizeY = $this->getHeight();
		if (!io::isPositiveInteger($sizeX) || !io::isPositiveInteger($sizeY)) {
			$this->raiseError('Unkown image size ...');
			return false;
		}
		//if no crop needed
		if (!$cropTop && !$cropBottom && !$cropLeft && !$cropRight) {
			if (!$saveToPathFS) {
				return true;
			}
			return CMS_file::copyTo($imagepathFS, $saveToPathFS);
		}
		//if we do not have a path to save image, replace current file
		if (!$saveToPathFS) {
			$this->_height = $this->_width = null;
			$saveToPathFS = $imagepathFS;
		}
		//calculate cropped width and height
		$cWidth = ($sizeX - $cropLeft) - $cropRight;
		$cHeight = ($sizeY - $cropTop) - $cropBottom;
		//resize image and keep transparency if any
		switch ($this->getExtension()) {
			case "gif":
				$src = imagecreatefromgif($imagepathFS);
				$dest = imagecreate($cWidth,$cHeight);
				$transparent = imagecolortransparent($src);
				// If we have a specific transparent color
				if ($transparent >= 0) {
					$transColor = imagecolorsforindex($src, $transparent);
					$transparent = imagecolorallocate($dest, $transColor['red'], $transColor['green'], $transColor['blue']);
					imagefill($dest, 0, 0, $transparent);
					imagecolortransparent($dest, $transparent);
				}
				//create new image
				@imagecopyresampled($dest, $src, 0, 0, $cropLeft, $cropTop, $cWidth, $cHeight, $cWidth, $cHeight);
				imagegif($dest, $saveToPathFS);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
			case "jpg":
			case "jpeg":
			case "jpe":
				$src = imagecreatefromjpeg($imagepathFS);
				$dest = imagecreatetruecolor($cWidth, $cHeight);
				//create new image
				@imagecopyresampled($dest, $src, 0, 0, $cropLeft, $cropTop, $cWidth, $cHeight, $cWidth, $cHeight);
				imagejpeg($dest, $saveToPathFS, self::JPEG_QUALITY);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
			case "png":
				$src = imagecreatefrompng($imagepathFS);
				$dest = imagecreatetruecolor($cWidth, $cHeight);
				//save alpha channel
				imagealphablending($dest, false);
				imagesavealpha($dest,true);
				$transparent = imagecolorallocatealpha($dest, 255, 255, 255, 127);
				imagefilledrectangle($dest, 0, 0, $cWidth, $cHeight, $transparent);
				//create new image
				@imagecopyresampled($dest, $src, 0, 0, $cropLeft, $cropTop, $cWidth, $cHeight, $cWidth, $cHeight);
				imagepng($dest, $saveToPathFS, self::PNG_COMPRESSION);
				//destroy resources
				imagedestroy($src);
				imagedestroy($dest);
			break;
		}
		//chmod new file
		CMS_file::chmodFile(FILES_CHMOD, $saveToPathFS);
		
		return true;
	}
}
?>