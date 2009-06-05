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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: blockscatalog.php,v 1.2 2009/06/05 15:02:17 sebastien Exp $

/**
  * Class CMS_blocksCatalog
  *
  * Represents a collection of blocks
  *
  * @package CMS
  * @subpackage module
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_blocksCatalog extends CMS_grandFather
{
	/**
	  * Move the blocks of a page from one location to another.
	  *
	  * @param string $locationFrom The starting location, among the available RESOURCE_DATA_LOCATION
	  * @param string $locationTo The ending location, among  the available RESOURCE_DATA_LOCATION
	  * @param boolean $copyOnly If set to true, the deletion from the originating tables and dirs won't occur
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function moveBlocks(&$page, $locationFrom, $locationTo, $copyOnly = false)
	{
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page is not a CMS_page");
			return false;
		}
		if (!SensitiveIO::isInSet($locationFrom, CMS_resource::getAllDataLocations())
			|| !SensitiveIO::isInSet($locationTo, CMS_resource::getAllDataLocations())) {
			CMS_grandFather::raiseError("Locations are not in the set");
			return false;
		}
		
		//get the blocks tables : named blocksXXXX_public
		$sql = "show tables";
		$q = new CMS_query($sql);
		$tables_prefixes = array();
		while ($data = $q->getArray()) {
			if (preg_match("#^blocks(.*)_public$#", $data[0])) {
				$tables_prefixes[] = substr($data[0], 0, strrpos($data[0], "_") + 1);
			}
		}
		
		foreach ($tables_prefixes as $table_prefix) {
			//delete all in the destination table just incase and insert
			if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
				$sql = "
					delete from
						".$table_prefix.$locationTo."
					where
						page='".$page->getID()."'
				";
				$q = new CMS_query($sql);
				$sql = "
					replace into
						".$table_prefix.$locationTo."
						select
							*
						from
							".$table_prefix.$locationFrom."
						where
							page='".$page->getID()."'
				";
				$q = new CMS_query($sql);
			}
			if (!$copyOnly) {
				//delete from the starting table
				$sql = "
					delete from
						".$table_prefix.$locationFrom."
					where
						page='".$page->getID()."'
				";
				$q = new CMS_query($sql);
			}
		}
		
		//second, move the files
		$locationFromDir = new CMS_file(PATH_MODULES_FILES_STANDARD_FS."/".$locationFrom, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		//cut here if the locationFromDir doesn't exists. That means the module doesn't have files
		if (!$locationFromDir->exists()) {
			return true;
		}
		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
			$locationToDir = new CMS_file(PATH_MODULES_FILES_STANDARD_FS."/".$locationTo, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
			//cut here if the locationToDir doesn't exists.
			if (!$locationToDir->exists()) {
				CMS_grandFather::raiseError("LocationToDir does not exists : ".PATH_MODULES_FILES_STANDARD_FS."/".$locationTo);
				return false;
			}
			//delete all files of the locationToDir
			foreach(glob(PATH_MODULES_FILES_STANDARD_FS."/".$locationTo.'/p'.$page->getID().'_*', GLOB_NOSORT) as $file) {
				if (!CMS_file::deleteFile($file)) {
					CMS_grandFather::raiseError("Can't delete file ".$file);
					return false;
				}
			}
			//then copy or move them to the locationToDir
			foreach(glob(PATH_MODULES_FILES_STANDARD_FS."/".$locationFrom.'/p'.$page->getID().'_*', GLOB_NOSORT) as $file) {
				$to = str_replace('/'.$locationFrom.'/','/'.$locationTo.'/',$file);
				if ($copyOnly) {
					if (!CMS_file::copyTo($file,$to)) {
						CMS_grandFather::raiseError("Can't copy file ".$file." to ".$to);
						return false;
					}
				} else {
					if (!CMS_file::moveTo($file,$to)) {
						CMS_grandFather::raiseError("Can't move file ".$file." to ".$to);
						return false;
					}
				}
				//then chmod new file
				CMS_file::chmodFile(FILES_CHMOD,$to);
			}
		}
		//cleans the initial dir if not a copy
		if (!$copyOnly) {
			//then get all files of the locationFromDir
			foreach(glob(PATH_MODULES_FILES_STANDARD_FS."/".$locationFrom.'/p'.$page->getID().'_*', GLOB_NOSORT) as $file) {
				if (!CMS_file::deleteFile($file)) {
					CMS_grandFather::raiseError("Can't delete file ".$file);
					return false;
				}
			}
		}
		
		//move the files
		/*$initial_path = PATH_MODULES_FILES_STANDARD_FS."/".$locationFrom;
		if (!is_dir($initial_path)) {
			CMS_grandFather::raiseError("Can't open dir ".$initial_path." : permission denied or dir does not exists ");
			return false;
		}
		$initial_dir = dir($initial_path);
		$files_prefix = "p".$page->getID()."_";
		if ($locationTo != RESOURCE_DATA_LOCATION_DEVNULL) {
			//cleans the destination dir
			$destination_path = PATH_MODULES_FILES_STANDARD_FS."/".$locationTo;
			if (!is_dir($destination_path)) {
				CMS_grandFather::raiseError("Can't open dir ".$destination_path." : permission denied or dir does not exists ");
				return false;
			}
			$destination_dir = dir($destination_path);
			while (false !== ($file = $destination_dir->read())) {
				if (is_file($destination_path."/".$file)
					&& substr($file, 0, strlen($files_prefix)) == $files_prefix) {
					unlink($destination_path."/".$file);
				}
			}
			//copy or move the files
			while (false !== ($file = $initial_dir->read())) {
				if (is_file($initial_path."/".$file)
					&& substr($file, 0, strlen($files_prefix)) == $files_prefix) {
					if ($copyOnly) {
						if (@copy($initial_path."/".$file, $destination_path."/".$file)) {
							@chmod($destination_path."/".$file, octdec(FILES_CHMOD));
						} else {
							CMS_grandFather::raiseError("Can't copy file ".$initial_path."/".$file." to ".$destination_path."/".$file." : permission denied");
						}
					} else {
						if (@rename($initial_path."/".$file, $destination_path."/".$file)) {
							@chmod($destination_path."/".$file, octdec(FILES_CHMOD));
						} else {
							CMS_grandFather::raiseError("Can't move file ".$initial_path."/".$file." to ".$destination_path."/".$file." : permission denied");
						}
					}
				}
			}
		}
		//cleans the initial dir if not a copy
		if (!$copyOnly) {
			$initial_dir->rewind();
			while (false !== ($file = $initial_dir->read())) {
				if (is_file($initial_path."/".$file)
					&& substr($file, 0, strlen($files_prefix)) == $files_prefix) {
					unlink($initial_path."/".$file);
				}
			}
		}*/
		return true;
	}
	
	/**
	  * Get all edited blocks founded for a given page
	  * Detect all blocks
	  * Sends an array of all blocks of given page
	  * 
	  * @param CMS_page $page the page we want data from
	  * @param boolean $public, if only public datas are concerned
	  * @return array of CMS_block
	  */
	function getAllBlocksForPage(&$page, $public=false)
	{
		$_blocks = array();
		//@var : array ( array(Table prefix, Class name) )
		$_blockTypes = array(
					array('blocksImages','CMS_block_image'),
					array('blocksFlashes','CMS_block_flash'),
					array('blocksFiles','CMS_block_file'),
					array('blocksTexts', 'CMS_block_text'),
					array('blocksVarchars','CMS_block_varchar')
					);
		//Rotate all block types availables
		foreach ($_blockTypes as $b) {
			$table = ($public) ? $b[0].'_public' : $b[0].'_edited';
			$klass = $b[1];
			$sql = "
				select
					id
				from
					".$table."
				where
					page=".$page->getID()."
				";
			$q = new CMS_query($sql);
			while($id = $q->getvalue("id")) {
				$_blocks[] = new $klass($id, RESOURCE_LOCATION_USERSPACE, $public);
			}
		}
		return $_blocks ;
	}
}
?>