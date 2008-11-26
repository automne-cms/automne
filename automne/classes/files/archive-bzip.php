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
// $Id: archive-bzip.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

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

class CMS_bzip_file extends CMS_tar_file
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
		$this->CMS_tar_file($name);
		$this->options['type'] = "bzip";
	}

	/**
	 * Creates compressed file by compressing raw data contained into $this->CMS_archive
	 * 
	 * @return true on success, false on failure
	 */
	function create_bzip()
	{
		if ($this->options['inmemory'] == 0) {
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = bzopen($this->options['name'], "wb")) {
				fseek($this->CMS_archive, 0);
				while ($temp = fread($this->CMS_archive, 1048576)) {
					bzwrite($fp, $temp);
				}
				bzclose($fp);
				chdir($pwd);
			} else {
				$this->raiseError("Could not open {$this->options['name']} for writing.");
				chdir($pwd);
				return false;
			}
		} else {
			$this->CMS_archive = bzcompress($this->CMS_archive, $this->options['level']);
		}

		return true;
	}

	/**
	 * Opens archive by opening/decompressing file
	 * 
	 * @return true on success, false on failure
	 */
	function open_archive()
	{
		return @bzopen($this->options['name'], "rb");
	}
}

?>