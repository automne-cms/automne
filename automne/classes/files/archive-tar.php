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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Devin Doucette <darksnoopy@shaw.ca>                          |
// +----------------------------------------------------------------------+
//
// $Id: archive-tar.php,v 1.4 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_archive
  *
  * This script manages TAR/GZIP/BZIP2/ZIP archives
  *
  * Based on an original script "TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.0"
  * from Devin Doucette mentionned in copyright
  *
  * @package Automne
  * @subpackage files
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Devin Doucette <darksnoopy@shaw.ca>
  */

class CMS_tar_file extends CMS_archive
{
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function CMS_tar_file($name)
	{
		if (trim($name) == '') {
			$this->raiseError("Not a valid name given to archive ".$name);
			return;
		}
		$this->CMS_archive($name);
		$this->options['type'] = "tar";
	}

	/**
	 * Creates compressed file by compressing raw data contained into $this->CMS_archive
	 * 
	 * @return true on success, false on failure
	 */
	function create_tar()
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current) {
			if ($current['name'] == $this->options['name']) {
				continue;
			}
			if (io::strlen($current['name2']) > 99) {
				$path = io::substr($current['name2'], 0, io::strpos($current['name2'], "/", io::strlen($current['name2']) - 100) + 1);
				$current['name2'] = io::substr($current['name2'], io::strlen($path));
				if (io::strlen($path) > 154 || io::strlen($current['name2']) > 99) {
					$this->raiseError("Could not add {$path}{$current['name2']} to archive because the filename is too long.");
					continue;
				}
			}
			$block = pack("a100a8a8a8a12a12a8a1a100a6a2a32a32a8a8a155a12", $current['name2'], decoct($current['stat'][2]), sprintf("%6s ", decoct($current['stat'][4])), sprintf("%6s ", decoct($current['stat'][5])), sprintf("%11s ", decoct($current['stat'][7])), sprintf("%11s ", decoct($current['stat'][9])), "        ", $current['type'], "", "ustar", "00", "Unknown", "Unknown", "", "", !empty ($path) ? $path : "", "");

			$checksum = 0;
			for ($i = 0; $i < 512; $i ++) {
				$checksum += ord(io::substr($block, $i, 1));
			}
			$checksum = pack("a8", sprintf("%6s ", decoct($checksum)));
			$block = substr_replace($block, $checksum, 148, 8);

			if ($current['stat'][7] == 0) {
				$this->add_data($block);
			} else
				if ($fp = @ fopen($current['name'], "rb")) {
					$this->add_data($block);
					while ($temp = fread($fp, 1048576)) {
						$this->add_data($temp);
					}
					if ($current['stat'][7] % 512 > 0) {
						$temp = "";
						for ($i = 0; $i < 512 - $current['stat'][7] % 512; $i ++) {
							$temp .= "\0";
						}
						$this->add_data($temp);
					}
					fclose($fp);
				} else {
					$this->raiseError("Could not open file {$current['name']} for reading. It was not added.");
				}
		}
		$this->add_data(pack("a512", ""));
		chdir($pwd);
		return true;
	}
	
	/**
	 * Extract files from the archive
	 * 
	 * @return true on success
	 */
	function extract_files() 
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		if ($fp = $this->open_archive()) {
			if ($this->options['inmemory'] == 1) {
				$this->files = array ();
			}

			while ($block = fread($fp, 512)) {
				$temp = unpack("a100name/a8mode/a8uid/a8gid/a12size/a12mtime/a8checksum/a1type/a100temp/a6magic/a2temp/a32temp/a32temp/a8temp/a8temp/a155prefix/a12temp", $block);
				$file = array ('name' => $temp['prefix'].$temp['name'], 'stat' => array (2 => $temp['mode'], 4 => octdec($temp['uid']), 5 => octdec($temp['gid']), 7 => octdec($temp['size']), 9 => octdec($temp['mtime']),), 'checksum' => octdec($temp['checksum']), 'type' => $temp['type'], 'magic' => $temp['magic'],);
				if ($file['checksum'] == 0x00000000) {
					break;
				} else
					/*if ($file['magic'] != "ustar") {
						$this->raiseError("This script does not support extracting this type of tar file.");
						break;
					}*/
				$block = substr_replace($block, "        ", 148, 8);
				$checksum = 0;
				for ($i = 0; $i < 512; $i ++) {
					$checksum += ord(io::substr($block, $i, 1));
				}
				if ($file['checksum'] != $checksum) {
					$this->raiseError("Could not extract from {$this->options['name']}, it is corrupt.");
				}

				if ($this->options['inmemory'] == 1) {
					$file['data'] = @fread($fp, $file['stat'][7]);
					@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					unset ($file['checksum'], $file['magic']);
					$this->files[] = $file;
				} else {
					if ($file['type'] == 5) {
						if (!is_dir($file['name'])) {
							
							/*if ($this->options['forceWriting']) {
								chmod($file['name'], 1777);
							}*/
							if (!$this->options['dontUseFilePerms']) {
								@mkdir($file['name'], $file['stat'][2]);
								//pr($file['name'].' : '.$file['stat'][4]);
								//pr($file['name'].' : '.$file['stat'][5]);
								@chown($file['name'], $file['stat'][4]);
								@chgrp($file['name'], $file['stat'][5]);
							} else {
								@mkdir($file['name']);
							}
						}
					} else {
						if ($this->options['overwrite'] == 0 && file_exists($file['name'])) {
							$this->raiseError("{$file['name']} already exists.");
						} else {
							//check if destination dir exists
							$dirname = dirname($file['name']);
							if (!is_dir($dirname)) {
								CMS_file::makeDir($dirname);
							}
							if ($new = @fopen($file['name'], "wb")) {
								@fwrite($new, @fread($fp, $file['stat'][7]));
								@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
								@fclose($new);
								//pr($file['name'].' : '.$file['stat'][2]);
								if (!$this->options['dontUseFilePerms']) {
									@chmod($file['name'], $file['stat'][2]);
									@chown($file['name'], $file['stat'][4]);
									@chgrp($file['name'], $file['stat'][5]);
								}
								/*if ($this->options['forceWriting']) {
									chmod($file['name'], 0777);
								}*/
							} else {
								$this->raiseError("Could not open {$file['name']} for writing.");
							}
						}
					}
				}
				unset ($file);
			}
		} else {
			$this->raiseError("Could not open file {$this->options['name']}");
		}
		chdir($pwd);
		return true;
	}

	/**
	 * Opens archive by opening/decompressing file
	 * 
	 * @return true on success, false on failure
	 */
	function open_archive()
	{
		return @fopen($this->options['name'], "rb");
	}

}
?>