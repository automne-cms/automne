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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Devin Doucette <darksnoopy@shaw.ca>                          |
// +----------------------------------------------------------------------+
//
// $Id: archive-zip.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_archive
  *
  * This script manages TAR/GZIP/BZIP2/ZIP archives
  *
  * Based on an original script "TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.0"
  * from Devin Doucette mentionned in copyright
  *
  * @package CMS
  * @subpackage files
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Devin Doucette <darksnoopy@shaw.ca>
  */

class CMS_zip_file extends CMS_archive
{
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function __construct($name)
	{
		if (trim($name) == '') {
			$this->raiseError("Not a valid name given to archive ".$name);
			return;
		}
		$this->CMS_archive($name);
		$this->options['type'] = "zip";
	}

	/**
	 * Creates compressed file by compressing raw data contained into $this->CMS_archive
	 * 
	 * @return true on success, false on failure
	 */
	function create_zip()
	{
		$files = 0;
		$offset = 0;
		$central = "";

		if (!empty ($this->options['sfx'])) {
			if ($fp = @ fopen($this->options['sfx'], "rb")) {
				$temp = fread($fp, filesize($this->options['sfx']));
				fclose($fp);
				$this->add_data($temp);
				$offset += strlen($temp);
				unset ($temp);
			} else {
				$this->raiseError("Could not open sfx module from {$this->options['sfx']}.");
			}
		}

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current) {
			if ($current['name'] == $this->options['name']) {
				continue;
			}
			// Special chars management
			$translate = array (
				'Ç' => pack("C", 128),
				'ü' => pack("C", 129),
				'é' => pack("C", 130),
				'â' => pack("C", 131),
				'ä' => pack("C", 132),
				'à' => pack("C", 133),
				'å' => pack("C", 134),
				'ç' => pack("C", 135),
				'ê' => pack("C", 136),
				'ë' => pack("C", 137),
				'è' => pack("C", 138),
				'ï' => pack("C", 139),
				'î' => pack("C", 140),
				'ì' => pack("C", 141),
				'Ä' => pack("C", 142),
				'Å' => pack("C", 143),
				'É' => pack("C", 144),
				'æ' => pack("C", 145),
				'Æ' => pack("C", 146),
				'ô' => pack("C", 147),
				'ö' => pack("C", 148),
				'ò' => pack("C", 149),
				'û' => pack("C", 150),
				'ù' => pack("C", 151),
				//'_' => pack("C", 152),
				'Ö' => pack("C", 153),
				'Ü' => pack("C", 154),
				'£' => pack("C", 156),
				'¥' => pack("C", 157),
				//'_' => pack("C", 158),
				'ƒ' => pack("C", 159),
				'á' => pack("C", 160),
				'í' => pack("C", 161),
				'ó' => pack("C", 162),
				'ú' => pack("C", 163),
				'ñ' => pack("C", 164),
				'Ñ' => pack("C", 165)
			);
			$current['name2'] = strtr($current['name2'], $translate);

			$timedate = explode(" ", date("Y n j G i s", $current['stat'][9]));
			$timedate = ($timedate[0] - 1980 << 25) | ($timedate[1] << 21) | ($timedate[2] << 16) | ($timedate[3] << 11) | ($timedate[4] << 5) | ($timedate[5]);

			$block = pack("VvvvV", 0x04034b50, 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate);

			if ($current['stat'][7] == 0 && $current['type'] == 5) {
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000);
				$block .= $current['name2']."/";
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2']."/";
				$files ++;
				$offset += (31 + strlen($current['name2']));
			} else
				if ($current['stat'][7] == 0) {
					$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000);
					$block .= $current['name2'];
					$this->add_data($block);
					$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
					$central .= $current['name2'];
					$files ++;
					$offset += (30 + strlen($current['name2']));
				} else
					if ($fp = @ fopen($current['name'], "rb")) {
						$temp = fread($fp, $current['stat'][7]);
						fclose($fp);
						$crc32 = crc32($temp);
						if (!isset ($current['method']) && $this->options['method'] == 1) {
							$temp = gzcompress($temp, $this->options['level']);
							$size = strlen($temp) - 6;
							$temp = substr($temp, 2, $size);
						} else {
							$size = strlen($temp);
						}
						$block .= pack("VVVvv", $crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000);
						$block .= $current['name2'];
						$this->add_data($block);
						$this->add_data($temp);
						unset ($temp);
						$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, $crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, 0x00000000, $offset);
						$central .= $current['name2'];
						$files ++;
						$offset += (30 + strlen($current['name2']) + $size);
					} else {
						$this->raiseError("Could not open file {$current['name']} for reading. It was not added.");
					}
		}
		$this->add_data($central);
		$this->add_data(pack("VvvvvVVv", 0x06054b50, 0x0000, 0x0000, $files, $files, strlen($central), $offset, !empty ($this->options['comment']) ? strlen($this->options['comment']) : 0x0000));
		if (!empty ($this->options['comment'])) {
			$this->add_data($this->options['comment']);
		}
		chdir($pwd);
		return true;
	}
}

?>