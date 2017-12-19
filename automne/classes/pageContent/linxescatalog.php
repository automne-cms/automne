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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: linxescatalog.php,v 1.4 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_linxesCatalog
  *
  * Represents a collection of linxes
  *
  * @package Automne
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_linxesCatalog extends CMS_grandFather
{
	const PAGE_LINK_TO = 1;
	const PAGE_LINK_FROM = 2;
	
	/**
	  * Get the array of available linx types
	  * Static function
	  *
	  * @return void
	  * @access public
	  */
	public static function getAllTypes()
	{
		return array("direct", "desclinks", "sublinks","recursivelinks");
	}
	
	/**
	  * Delete all the linxes for a page
	  * Static function
	  *
	  * @param CMS_page $page the page to forget
	  * @param boolean $includingWhenTarget Set to true to really delete all the linxes, including the one where the page is a target only
	  * @return void
	  * @access public
	  */
	public static function deleteLinxes(&$page, $includingWhenTarget = false)
	{
		//check argument is a page
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		
		//empty all tables from existing linxes
		$sql = "
			delete from
				linx_real_public
			where
				start_lre='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		$sql = "
			delete from
				linx_watch_public
			where
				page_lwa='".$page->getID()."'
		";
		$q = new CMS_query($sql);

		if ($includingWhenTarget) {
			$sql = "
				delete from
					linx_real_public
				where
					stop_lre='".$page->getID()."'
			";
			$q = new CMS_query($sql);
			$sql = "
				delete from
					linx_watch_public
				where
					target_lwa='".$page->getID()."'
			";
			$q = new CMS_query($sql);
		}
	}

	/**
	  * Get the DB IDs of pages who "watch" this one
	  * Static function
	  *
	  * @param CMS_page $page the page watched
	  * @return array(integer) The DB IDs of pages watching the one in argument
	  * @access public
	  */
	public static function getWatchers($page) {
		//check argument is a page
		if (!is_a($page, "CMS_page") && !sensitiveIO::isPositiveInteger($page)) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page or positive integer");
			return false;
		}
		$pageId = (is_object($page)) ? $page->getID() : $page;
		$sql = "
			select
				page_lwa
			from
				linx_watch_public
			where
				target_lwa='".$pageId."'
		";
		$q = new CMS_query($sql);
		
		$watchers = array();
		while ($id = $q->getValue("page_lwa")) {
			$watchers[] = $id;
		}
		return $watchers;
	}

	/**
	  * Get the DB IDs of pages who "link" this one
	  * Static function
	  *
	  * @param CMS_page $page the page linked
	  * @return array(integer) The DB IDs of pages linking the one in argument
	  * @access public
	  */
	public static function getLinkers($page) {
		//check argument is a page
		if (!is_a($page, "CMS_page") && !sensitiveIO::isPositiveInteger($page)) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page or positive integer");
			return false;
		}
		$pageId = (is_object($page)) ? $page->getID() : $page;
		$sql = "
			select
				start_lre
			from
				linx_real_public
			where
				stop_lre='".$pageId."'
		";
		$q = new CMS_query($sql);
		$linkers = array();
		while ($id = $q->getValue("start_lre")) {
			$linkers[] = $id;
		}
		return $linkers;
	}
	
	/**
	  * Get links relations between a page and linked ones
	  * Static function
	  *
	  * @param constant $type : the type of relation (self::PAGE_LINK_FROM or self::PAGE_LINK_TO)
	  * @param integer $page : the page to get relations of
	  * @return array(integer) : pages IDs
	  * @access public
	  * @static
	  */
	public static function searchRelations($type, $pageID){
		if (!sensitiveIO::isPositiveInteger($pageID)) {
			CMS_grandFather::raiseError('$pageID must be a positive integer : '.$pageID);
			return false;
		}
		if ($type == self::PAGE_LINK_TO) {
			$select = ' distinct(start_lre) as id ';
			$where = " page_pbd=start_lre and stop_lre='".$pageID."' ";
		} else {
			$select = ' distinct(stop_lre)  as id ';
			$where = "  page_pbd=stop_lre and start_lre='".$pageID."' ";
		}
		$sql ="
			select
				".$select."
			from
				linx_real_public,
				pagesBaseData_edited
			where
				".$where;
		//pr($sql);
		$q = new CMS_query($sql);
		$relations = array();
		while ($id = $q->getValue('id')){
			$relations[]=$id;
		}
		return $relations;
	}
}
?>