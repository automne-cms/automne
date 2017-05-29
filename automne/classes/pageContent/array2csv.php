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
  * Class CMS_array2csv
  *
  * Create a CSV file (CMS_file) from a given array
  *
  * @package Automne
  * @subpackage pageContent
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_array2csv extends CMS_grandFather
{
	/**
	 * CSV filename to use
	 * @var string
	 * @access private
	 */
	protected $_filename = false;
	
	/**
	 * CSV filepath to use (FS relative)
	 * @var string
	 * @access private
	 */
	protected $_filepath = false;
	
	/**
	 * CSV fields separator
	 * @var string
	 * @access private
	 */
	protected $_separator = ';';
	
	/**
	 * CSV fields enclosure
	 * @var string
	 * @access private
	 */
	protected $_enclosure = '"';
	
	/**
	 * CSV file
	 * @var resource handle
	 * @access private
	 */
	protected $_file = false;
	
	/**
	 * Constructor
	 * 
	 * @param string $filename, the filename to use. io::sanitizeAsciiString will be used to clean this filename
	 * @param string $filepath, the filepath to use (FS relativeà). The path must exists and be writable. Default : PATH_TMP_FS
	 * @param string $separator, the CSV fields separator (default ;)
	 * @param string $enclosure, the CSV fields enclosure (default ")
	 * @return void
	 */
	function __construct($filename, $filepath = PATH_TMP_FS, $separator = ';', $enclosure = '"') {
		if (is_dir($filepath) && is_writable($filepath)) {
			$this->_filepath = $filepath;
		} else {
			$this->setError('File path does not exists or is not writable : '.$filepath);
			return false;
		}
		$this->_filename = io::sanitizeAsciiString($filename);
		$this->_separator = $separator;
		$this->_enclosure = $enclosure;
		if (!($this->_file = @fopen($this->_filepath.'/'.$this->_filename, 'ab+'))) {
			$this->setError('Cannot open file '.($this->_filepath.'/'.$this->_filename).' for writing');
			return false;
		}
	}
	
	function getFilename($withpath = false) {
		if ($withpath) {
			return $this->_filepath.'/'.$this->_filename;
		} else {
			return $this->_filename;
		}
	}
	
	function getFilepath() {
		return $this->_filepath;
	}
	
	/**
	 * Add datas to current CSV file
	 * 
	 * @param array $datas, the datas to add to current csv file. Allow use of array(array(datas)) to add multi lines to CSV file in one pass
	 * @return boolean
	 */
	function addDatas($datas) {
		if (@ftell($this->_file) === false) {
			$this->setError('Cannot add datas to a file already closed');
			return false;
		}
		$multiline = true;
		foreach ($datas as $data) {
			$multiline &= is_array($data);
		}
		if ($multiline) {
			$return = true;
			foreach ($datas as $data) {
				$return &= @fputcsv($this->_file, $data, $this->_separator, $this->_enclosure);
			}
			return $return;
		} else {
			return @fputcsv($this->_file, $datas, $this->_separator, $this->_enclosure);
		}
	}
	
	/**
	 * Get current CSV file
	 * 
	 * @return CMS_file : the CSV file
	 */
	function getFile() {
		@fclose ($this->_file);
		$file = new CMS_file($this->_filepath.'/'.$this->_filename);
		if ($file->exists()) {
			return $file;
		} else {
			$this->setError('File '.($this->_filepath.'/'.$this->_filename).' does not exists');
			return false;
		}
	}
}
?>