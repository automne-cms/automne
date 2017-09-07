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
// | Author: C�dric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Devin Doucette <darksnoopy@shaw.ca>                          |
// +----------------------------------------------------------------------+
//
// $Id: archive-zip.php,v 1.4 2010/03/08 16:43:28 sebastien Exp $

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
  * @author C�dric Soret <cedric.soret@ws-interactive.fr> &
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
	function CMS_zip_file($name)
	{
		if (trim($name) == '') {
			$this->setError("Not a valid name given to archive ".$name);
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
				$offset += io::strlen($temp);
				unset ($temp);
			} else {
				$this->setError("Could not open sfx module from {$this->options['sfx']}.");
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
				'�' => pack("C", 128),
				'�' => pack("C", 129),
				'�' => pack("C", 130),
				'�' => pack("C", 131),
				'�' => pack("C", 132),
				'�' => pack("C", 133),
				'�' => pack("C", 134),
				'�' => pack("C", 135),
				'�' => pack("C", 136),
				'�' => pack("C", 137),
				'�' => pack("C", 138),
				'�' => pack("C", 139),
				'�' => pack("C", 140),
				'�' => pack("C", 141),
				'�' => pack("C", 142),
				'�' => pack("C", 143),
				'�' => pack("C", 144),
				'�' => pack("C", 145),
				'�' => pack("C", 146),
				'�' => pack("C", 147),
				'�' => pack("C", 148),
				'�' => pack("C", 149),
				'�' => pack("C", 150),
				'�' => pack("C", 151),
				//'_' => pack("C", 152),
				'�' => pack("C", 153),
				'�' => pack("C", 154),
				'�' => pack("C", 156),
				'�' => pack("C", 157),
				//'_' => pack("C", 158),
				'�' => pack("C", 159),
				'�' => pack("C", 160),
				'�' => pack("C", 161),
				'�' => pack("C", 162),
				'�' => pack("C", 163),
				'�' => pack("C", 164),
				'�' => pack("C", 165)
			);
			$current['name2'] = strtr($current['name2'], $translate);

			$timedate = explode(" ", date("Y n j G i s", $current['stat'][9]));
			$timedate = ($timedate[0] - 1980 << 25) | ($timedate[1] << 21) | ($timedate[2] << 16) | ($timedate[3] << 11) | ($timedate[4] << 5) | ($timedate[5]);

			$block = pack("VvvvV", 0x04034b50, 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate);

			if ($current['stat'][7] == 0 && $current['type'] == 5) {
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, io::strlen($current['name2']) + 1, 0x0000);
				$block .= $current['name2']."/";
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, 0x00000000, 0x00000000, 0x00000000, io::strlen($current['name2']) + 1, 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2']."/";
				$files ++;
				$offset += (31 + io::strlen($current['name2']));
			} else
				if ($current['stat'][7] == 0) {
					$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, io::strlen($current['name2']), 0x0000);
					$block .= $current['name2'];
					$this->add_data($block);
					$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, 0x00000000, 0x00000000, 0x00000000, io::strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
					$central .= $current['name2'];
					$files ++;
					$offset += (30 + io::strlen($current['name2']));
				} else
					if ($fp = @ fopen($current['name'], "rb")) {
						$temp = fread($fp, $current['stat'][7]);
						fclose($fp);
						$crc32 = crc32($temp);
						if (!isset ($current['method']) && $this->options['method'] == 1) {
							$temp = gzcompress($temp, $this->options['level']);
							$size = io::strlen($temp) - 6;
							$temp = io::substr($temp, 2, $size);
						} else {
							$size = io::strlen($temp);
						}
						$block .= pack("VVVvv", $crc32, $size, $current['stat'][7], io::strlen($current['name2']), 0x0000);
						$block .= $current['name2'];
						$this->add_data($block);
						$this->add_data($temp);
						unset ($temp);
						$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000, (isset ($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate, $crc32, $size, $current['stat'][7], io::strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, 0x00000000, $offset);
						$central .= $current['name2'];
						$files ++;
						$offset += (30 + io::strlen($current['name2']) + $size);
					} else {
						$this->setError("Could not open file {$current['name']} for reading. It was not added.");
					}
		}
		$this->add_data($central);
		$this->add_data(pack("VvvvvVVv", 0x06054b50, 0x0000, 0x0000, $files, $files, io::strlen($central), $offset, !empty ($this->options['comment']) ? io::strlen($this->options['comment']) : 0x0000));
		if (!empty ($this->options['comment'])) {
			$this->add_data($this->options['comment']);
		}
		chdir($pwd);
		return true;
	}
}

?>