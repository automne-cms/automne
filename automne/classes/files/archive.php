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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Devin Doucette <darksnoopy@shaw.ca>                          |
// +----------------------------------------------------------------------+
//
// $Id: archive.php,v 1.4 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_archive
  *
  * This script aimed to manage TAR, GZIP, BZIP2, ZIP archives
  * Needs inherited classes to become more efficient
  * 
  * Based on an original script "TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.0"
  * from Devin Doucette mentionned in copyright
  *
  * @package Automne
  * @subpackage files
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Devin Doucette <darksnoopy@shaw.ca>
  */

class CMS_archive extends CMS_grandFather
{
	
	/**
	 * Stores raw data in this var
	 * @var string
	 */
	protected $CMS_archive;
	
	/**
	 * All options about this archive:
	 * @var mixed array
	 * @access public
	 */
	protected $options = array ();

	/**
	 * All files managed when processing the archive
	 * @var array
	 * @access public
	 */
	protected $files = array ();

	/**
	 * Contains files not to be stored into archive
	 * @var array
	 * @access public
	 */
	protected $exclude = array ();

	/**
	 * Contains files to be stored into archive
	 * @var array
	 * @access public
	 */
	protected $storeonly = array ();

	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function CMS_archive($name) {
		if (trim($name) == '') {
			$this->raiseError("Not a valid name given to archive ".$name);
			return;
		}
		$this->options = array (
			'basedir'			=> ".",
			'name'				=> $name,
			'prepend'			=> '', 
			'inmemory'			=> 0, 
			'overwrite'			=> 0,
			'recurse'			=> 1,
			'storepaths'		=> 1,
			'level'				=> 3,
			'method'			=> 1,
			'sfx'				=> '',
			'type'				=> '',
			'comment'			=> '',
			'dontUseFilePerms'	=> true
		);
	}

	/**
	 * Sets options array to this archive
	 * 
	 * @var mixed array, @see $options attributes for details
	 * @return void
	 */
	function set_options($options) {
		if (is_array($options)) {
			foreach ($options as $key => $value) {
				$this->options[$key] = $value;
			}
			if (!empty ($this->options['basedir'])) {
				$this->options['basedir'] = str_replace("\\", "/", $this->options['basedir']);
				$this->options['basedir'] = preg_replace("/\/+/", "/", $this->options['basedir']);
				$this->options['basedir'] = preg_replace("/\/$/", "", $this->options['basedir']);
			}
			if (!empty ($this->options['name'])) {
				$this->options['name'] = str_replace("\\", "/", $this->options['name']);
				$this->options['name'] = preg_replace("/\/+/", "/", $this->options['name']);
			}
			if (!empty ($this->options['prepend'])) {
				$this->options['prepend'] = str_replace("\\", "/", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/^(\.*\/+)+/", "", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/\/+/", "/", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/\/$/", "", $this->options['prepend'])."/";
			}
		} else {
			$this->raiseError("Not a valid optins array given");
		}
	}

	/**
	 * Creates the archive
	 * Not so well done. This method should be abstract and redefined
	 * by each class through inheritance, awaiting interfaces in PHP 5
	 * 
	 * @return boolean true on success, false on failure
	 */
	function create_archive() {
		$this->make_list();

		if ($this->options['inmemory'] == 0) {
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($this->options['overwrite'] == 0 && file_exists($this->options['name']. ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : ""))) {
				$this->raiseError("File {$this->options['name']} already exists.");
				chdir($pwd);
				return 0;
			} elseif ($this->CMS_archive = @ fopen($this->options['name']. ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : ""), "wb+")) {
					chdir($pwd);
				} else {
					$this->raiseError("Could not open {$this->options['name']} for writing.");
					chdir($pwd);
					return false;
				}
		} else {
			$this->CMS_archive = "";
		}
		
		switch ($this->options['type']) {
			case "zip" :
				if (!$this->create_zip()) {
					$this->raiseError("Could not create zip file.");
					return false;
				}
				break;
			case "bzip" :
				if (!$this->create_tar()) {
					$this->raiseError("Could not create tar file.");
					return false;
				}
				if (!$this->create_bzip()) {
					$this->raiseError("Could not create bzip2 file.");
					return false;
				}
				break;
			case "gzip" :
				if (!$this->create_tar()) {
					$this->raiseError("Could not create tar file.");
					return false;
				}
				if (!$this->create_gzip()) {
					$this->raiseError("Could not create gzip file.");
					return false;
				}
				break;
			case "tar" :
				if (!$this->create_tar()) {
					$this->raiseError("Could not create tar file.");
					return false;
				}
		}

		if ($this->options['inmemory'] == 0) {
			fclose($this->CMS_archive);
			if ($this->options['type'] == "gzip" || $this->options['type'] == "bzip") {
				unlink($this->options['basedir']."/".$this->options['name'].".tmp");
			}
		}
		return true;
	}

	/**
	 * Add raw data to archive
	 * 
	 * @param string $data 
	 * @return void 
	 */
	function add_data($data) {
		if ($this->options['inmemory'] == 0) {
			fwrite($this->CMS_archive, $data);
		} else {
			$this->CMS_archive .= $data;
		}
	}
	
	/**
	 * Build list of all files to manage respecting stored files and
	 * those to exlude
	 * 
	 * @return void
	 */
	function make_list() {
		if (!empty ($this->exclude)) {
			foreach ($this->files as $key => $value) {
				foreach ($this->exclude as $current) {
					if ($value['name'] == $current['name']) {
						unset ($this->files[$key]);
					}
				}
			}
		}
		if (!empty ($this->storeonly)) {
			foreach ($this->files as $key => $value) {
				foreach ($this->storeonly as $current) {
					if ($value['name'] == $current['name']) {
						$this->files[$key]['method'] = 0;
					}
				}
			}
		}
		unset($this->exclude, $this->storeonly);
	}

	/**
	 * Add files to archive
	 * 
	 * @param array $list, an array of files to add 
	 * @return void
	 */
	function add_files($list) {
		$temp = $this->list_files($list);
		foreach ($temp as $current) {
			$this->files[] = $current;
		}
	}

	/**
	 * Sets all files to exclude from archive
	 * 
	 * @param array $list, an array of files to add 
	 * @return void
	 */
	function exclude_files($list) {
		$temp = $this->list_files($list);
		foreach ($temp as $current) {
			$this->exclude[] = $current;
		}
	}

	/**
	 * Stores files into archive
	 * 
	 * @param array $list, all files to list in an array 
	 * @return array, sorted with sort_files method
	 */
	function store_files($list) {
		$temp = $this->list_files($list);
		foreach ($temp as $current) {
			$this->storeonly[] = $current;
		}
	}

	/**
	 * List files of archive and sort them with sort_files method
	 * 
	 * @param array $list, all files to list in an array 
	 * @return array, files to list
	 */
	function list_files($list) {
		if (!is_array($list)) {
			$temp = $list;
			$list = array ($temp);
			unset ($temp);
		}

		$files = array ();

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($list as $current) {
			$current = str_replace("\\", "/", $current);
			$current = preg_replace("/\/+/", "/", $current);
			$current = preg_replace("/\/$/", "", $current);
			if (strstr($current, "*")) {
				$regex = preg_replace("/([\\\^\$\.\[\]\|\(\)\?\+\{\}\/])/", "\\\\\\1", $current);
				$regex = str_replace("*", ".*", $regex);
				$dir = strstr($current, "/") ? io::substr($current, 0, strrpos($current, "/")) : ".";
				$temp = $this->parse_dir($dir);
				foreach ($temp as $current2) {
					if (preg_match("/^{$regex}$/i", $current2['name'])) {
						$files[] = $current2;
					}
				}
				unset ($regex, $dir, $temp, $current);
			} elseif (@ is_dir($current)) {
				$temp = $this->parse_dir($current);
				foreach ($temp as $file) {
					$files[] = $file;
				}
				unset ($temp, $file);
			} elseif (@ file_exists($current)) {
				$files[] = array ('name' => $current, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($current, "/")) ? io::substr($current, strrpos($current, "/") + 1) : $current), 'type' => 0, 'ext' => io::substr($current, strrpos($current, ".")), 'stat' => stat($current));
			}
		}
		chdir($pwd);
		unset ($current, $pwd);
		usort($files, array ("CMS_archive", "sort_files"));
		return $files;
	}
	
	/**
	 * Parse a directory to get its content
	 *  
	 * @param string $dirname, name of the directory to parse
	 * @return array $files founded in the directory
	 */
	function parse_dir($dirname) {
		if ($this->options['storepaths'] == 1 && !preg_match("/^(\.+\/*)+$/", $dirname)) {
			$files = array (array ('name' => $dirname, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname, "/")) ? io::substr($dirname, strrpos($dirname, "/") + 1) : $dirname), 'type' => 5, 'stat' => stat($dirname)));
		} else {
			$files = array ();
		}
		$dir = @opendir($dirname);

		while ($file = @readdir($dir)) {
			if ($file == "." || $file == "..") {
				continue;
			} elseif (@is_dir($dirname."/".$file)) {
				if (empty ($this->options['recurse'])) {
					continue;
				}
				$temp = $this->parse_dir($dirname."/".$file);
				foreach ($temp as $file2) {
					$files[] = $file2;
				}
			} elseif (@file_exists($dirname."/".$file)) {
				$files[] = array ('name' => $dirname."/".$file, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname."/".$file, "/")) ? io::substr($dirname."/".$file, strrpos($dirname."/".$file, "/") + 1) : $dirname."/".$file), 'type' => 0, 'ext' => io::substr($file, strrpos($file, ".")), 'stat' => stat($dirname."/".$file));
			}
		}
		@closedir($dir);
		return $files;
	}

	/**
	 * Sorts files
	 * 
	 * @param string $a
	 * @param  string $b
	 * @return integer, 0 if nothing sorted
	 */
	function sort_files($a, $b) {
		if ($a['type'] != $b['type']) {
			return $a['type'] > $b['type'] ? -1 : 1;
		} elseif ($a['type'] == 5) {
			return strcmp(io::strtolower($a['name']), io::strtolower($b['name']));
		} else {
			if ($a['ext'] != $b['ext']) {
				return strcmp($a['ext'], $b['ext']);
			} elseif ($a['stat'][7] != $b['stat'][7]) {
				return $a['stat'][7] > $b['stat'][7] ? -1 : 1;
			} else {
				return strcmp(io::strtolower($a['name']), io::strtolower($b['name']));
			}
		}
		return 0;
	}
	
	/**
	 * Proceeds to archive download
	 * 
	 * @return binary file content to be downloaded
	 */
	function download_file() {
		if ($this->options['inmemory'] == 0) {
			$this->raiseError("Can only use download_file() if archive is in memory. Redirect to file otherwise, it is faster.");
			return;
		}
		switch ($this->options['type']) {
			case "zip" :
				header("Content-type:application/zip");
				break;
			case "bzip" :
				header("Content-type:application/x-compressed");
				break;
			case "gzip" :
				header("Content-type:application/x-compressed");
				break;
			case "tar" :
				header("Content-type:application/x-tar");
		}
		$header = "Content-disposition: attachment; filename=\"";
		$header .= strstr($this->options['name'], "/") ? io::substr($this->options['name'], strrpos($this->options['name'], "/") + 1) : $this->options['name'];
		$header .= "\"";
		header($header);
		header("Content-length: ".io::strlen($this->CMS_archive));
		header("Content-transfer-encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");
		print ($this->CMS_archive);
	}
}

?>