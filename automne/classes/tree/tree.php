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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: tree.php,v 1.12 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_tree
  *
  *  Manages the tree structure and the collection of pages.
  *
  * @package CMS
  * @subpackage tree
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_tree extends CMS_grandFather
{
	/**
	  * Returns the CMS_page of the root. It MUST exists or else everything fails.
	  * Static function.
	  *
	  * @return CMS_page The root page instance
	  * @access public
	  */
	function getRoot()
	{
		static $applicationRoot;
		if (!is_object($applicationRoot)) {
			$applicationRoot = new CMS_page(APPLICATION_ROOT_PAGE_ID);
			if ($applicationRoot->hasError()) {
				CMS_grandFather::raiseError("Root page error...");
				return false;
			}
			return $applicationRoot;
		} else {
			return $applicationRoot;
		}
	}
	
	/**
	  * Returns a CMS_page when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_page
	  * @return CMS_page or false on failure to find it
	  * @access public
	  */
	function getPageByID($id)
	{
		if (!SensitiveIO::isPositiveInteger($id)) {
			CMS_grandFather::raiseError("Id must be positive integer : ".$id);
			return false;
		}
		$page = new CMS_page($id);
		if ($page->hasError()) {
			return false;
		} else {
			return $page;
		}
	}
	
	/**
	  * Returns a queried CMS_page value
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_page
	  * @param string $type The value type to get
	  * @return CMS_page or false on failure to find it
	  * @access public
	  */
	function getPageValue($id, $type)
	{
		static $pagesInfos;
		if (!SensitiveIO::isPositiveInteger($id)) {
			CMS_grandFather::raiseError("Page id must be positive integer");
			return false;
		}
		if (!isset($pagesInfos[$id][$type])) {
			$page = new CMS_page($id);
			if ($page->hasError()) {
				return false;
			} else {
				switch ($type) {
					case 'url':
						$return = $page->getURL();
					break;
					case 'printurl':
						$return = $page->getURL(true);
					break;
					case 'title':
						$return = $page->getTitle(true);
					break;
					case 'id':
						$return = $page->getID();
					break;
					default:
						CMS_grandFather::raiseError("Unknown type value to get : ".$type);
						return false;
					break;
				}
				$pagesInfos[$id][$type] = $return;
			}
		}
		return $pagesInfos[$id][$type];
	}
	
	/**
	  * Check if page(s) exists and is(are) in userspace.
	  * Static function.
	  *
	  * @param $pagesID mixed integer / array of page(s) id(s) : the page(s) id(s) to check
	  * @return mixed boolean / array of page(s) id(s) in userspace
	  * @access public
	  */
	function pagesExistsInUserSpace($pagesID) {
		if (is_array($pagesID)) {
			$sql = "
					select
						id_pag
					from
						pages,
						resources,
						resourceStatuses
					where
						id_pag in (".implode(',',$pagesID).")
						and resource_pag = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and publication_rs = '".RESOURCE_PUBLICATION_PUBLIC."'
					";
			$q = new CMS_query($sql);
			$return = array();			
			while ($id = $q->getValue('id_pag')) {
				$return[] = $id;
			}
			return $return;
		} elseif (sensitiveIO::isPositiveInteger($pagesID)) {
			$sql = "
					select
						id_pag
					from
						pages,
						resources,
						resourceStatuses
					where
						id_pag = ".$pagesID."
						and resource_pag = id_res
						and status_res = id_rs
						and location_rs = '".RESOURCE_LOCATION_USERSPACE."'
						and publication_rs = '".RESOURCE_PUBLICATION_PUBLIC."'
					";
			$q = new CMS_query($sql);
			return ($q->getNumRows()) ? true : false;
		}
	}
	
	/**
	  * Check if public page exists for given user
	  * Static function.
	  *
	  * @param $pageID integer : the page id to check
	  * @param $user CMS_profile_user : the user to check
	  * @return boolean
	  * @access public
	  * @static
	  */
	function pageExistsForUser($pageID) {
		global $cms_user;
		if (APPLICATION_ENFORCES_ACCESS_CONTROL) {
			if (!is_object($cms_user) || !$cms_user->hasPageClearance($pageID, CLEARANCE_PAGE_VIEW)) {
				return false;
			}
		}
		return CMS_tree::pagesExistsInUserSpace($pageID);
	}
	
	/**
	  * Returns all the siblings pages, sorted by sibling order.
	  * Static function.
	  *
	  * @param CMS_page $page The page we want he siblings of (can accept the page ID instead of CMS_page)
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @param boolean $getPages if false, return only an array of sibling ID, else, return an array of sibling CMS_pages
	  * @return array(CMS_page) The siblings ordered
	  * @access public
	  */
	function getSiblings(&$page, $publicTree = false, $getPages=true)
	{
		if (!is_a($page, "CMS_page") && sensitiveIO::isPositiveInteger($page)) {
			$pageID = $page;
		} else {
			$pageID = $page->getID();
		}
		
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		$sql = "
			select
				sibling_ltr
			from
				".$table."
			where
				father_ltr='".$pageID."'
			order by
				order_ltr
		";
		$q = new CMS_query($sql);
		$pages = array();
		while ($id = $q->getValue("sibling_ltr")) {
			if ($getPages) {
				$pg = new CMS_page($id);
				if (!$pg->hasError()) {
					$pages[] = $pg;
				}
			} else {
				$pages[]=$id;
			}
		}
		return $pages;
	}
	
	/**
	  * Does given page has sibling ?
	  * Static function.
	  *
	  * @param CMS_page $page The page we want he siblings of (can accept the page ID instead of CMS_page)
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return boolean
	  * @access public
	  * @static
	  */
	function hasSiblings(&$page, $publicTree = false)
	{
		if (!is_a($page, "CMS_page") && sensitiveIO::isPositiveInteger($page)) {
			$pageID = $page;
		} else {
			$pageID = $page->getID();
		}
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		$sql = "
			select
				1
			from
				".$table."
			where
				father_ltr='".$pageID."'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true : false;
	}
	
	/**
	  * Returns all the siblings pages recursively.
	  * Static function.
	  *
	  * @param integer $pageID The page we want he siblings of
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return array(id) All siblings page id
	  * @access public
	  */
	function getAllSiblings($pageID, $publicTree = false)
	{
		$pages = array();
		$siblings = CMS_tree::getSiblings($pageID, $publicTree, false);
		$pages = array_merge($pages, $siblings);
		foreach ($siblings as $siblingID) {
			$pages = array_merge($pages, CMS_tree::getAllSiblings($siblingID, $publicTree));
		}
		return $pages;
	}
	
	/**
	  * Returns the brother of the given page, at the given brotherhood position.
	  * Offset : positive for right-hand brothers, negative for left-hand brother.
	  * Static function.
	  *
	  * @param CMS_page $page The page we want the brother of
	  * @param integer $offset The brotherhood offset
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return CMS_page The brother, or false if not found
	  * @access public
	  */
	function getBrother(&$page, $offset, $publicTree = false)
	{
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		if (!$offset) {
			return false;
		}
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		$sql = "
			select
				father_ltr,
				order_ltr
			from
				".$table."
			where
				sibling_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			CMS_grandFather::raiseError("Trying to get the brother of an unknown page");
			return false;
		}
		$data = $q->getArray();
		$page_sibling_order = $data["order_ltr"];
		$father_id = $data["father_ltr"];
		$brother_sibling_order = $page_sibling_order + $offset;
		if ($brother_sibling_order > 0) {
			$sql = "
				select
					sibling_ltr
				from
					".$table."
				where
					father_ltr='".$father_id."'
					and order_ltr='".$brother_sibling_order."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$pg = new CMS_page($q->getValue("sibling_ltr"));
				return $pg;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Returns true if the page is in the public tree
	  * Static function.
	  *
	  * @param CMS_page $page The page to check
	  * @return boolean true on success, false if the page is not in the public tree
	  * @access public
	  */
	function isInPublicTree(&$page)
	{
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		$sql = "
			select
				1
			from
				linx_tree_public
			where
				sibling_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Returns the ancestors of the given page to root, including root and the page.
	  * Static function.
	  *
	  * @param CMS_page $ancestor The oldest ancestor we want
	  * @param CMS_page $page The page we want the lineage of
	  * @param boolean $IO_CMS_page if it false, then the Input arguments aren't CMS_page but only page ID and function return an array(pageID). (this is realy fastest)
	  * @return array(CMS_page) The ancestors, from root to the page. Minimum is array(rootpage) if lineage of root wanted. Return false if break in lineage or page is archived or deleted.
	  * @access public
	  */
	function getLineage($ancestor, $page, $IO_CMS_page=true, $publicTree = false)
	{
		static $fathers;
		if ($IO_CMS_page && (!is_a($ancestor, "CMS_page") || !is_a($page, "CMS_page"))) {
			CMS_grandFather::raiseError("Ancestor and page must be instances of CMS_page");
			return false;
		}
		$lineage = array($page);
		$currentPageID = ($IO_CMS_page) ? $page->getID() : $page;
		$ancestorPageID = ($IO_CMS_page) ? $ancestor->getID() : $ancestor;
		$table = ($publicTree) ? 'linx_tree_public' : 'linx_tree_edited';
		while ($currentPageID != APPLICATION_ROOT_PAGE_ID && $currentPageID != $ancestorPageID) {
			if (!isset($fathers[$currentPageID])) {
				$sql = "
					select
						father_ltr
					from
						".$table."
					where
						sibling_ltr='".sensitiveIO::sanitizeSQLString($currentPageID)."'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$father = $q->getValue("father_ltr");
					$fathers[$currentPageID] = $father;
					$currentPageID = $father;
					if($IO_CMS_page) {
						$pg = new CMS_page($currentPageID);
						array_unshift($lineage, $pg);
					} else {
						array_unshift($lineage, $currentPageID);
					}
				} else {
					return false;
				}
			} else {
				$currentPageID = $fathers[$currentPageID];
				if($IO_CMS_page) {
					$pg = new CMS_page($currentPageID);
					array_unshift($lineage, $pg);
				} else {
					array_unshift($lineage, $currentPageID);
				}
			}
		}
		//if while was stopped because of reaching the root first, no lineage found
		if ($currentPageID == APPLICATION_ROOT_PAGE_ID && $currentPageID != $ancestorPageID) {
			return false;
		} else {
			return $lineage;
		}
	}
	
	/**
	  * Returns page father
	  * Static function.
	  *
	  * @param mixed $page : the page id or the cms_page object to get father of
	  * @param boolean $outputObject : if true, return father as a cms_page object, otherwise, return father page Id (default false)
	  * @param boolean $publicTree : if true, return public father page, else, return edited father (default false : edited)
	  * @return mixed, cms_page or page id
	  * @access public
	  */
	function getFather($page, $outputObject = false, $publicTree = false) {
		//check argument is a page
		if (!is_a($page, "CMS_page") && !sensitiveIO::isPositiveInteger($page)) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page or positive integer");
			return false;
		}
		$pageId = (is_object($page)) ? $page->getID() : $page;
		$table = ($publicTree) ? 'linx_tree_public' : 'linx_tree_edited';
		$sql = "
			select
				father_ltr
			from
				".$table."
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($pageId)."'
		";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			return false;
		}
		return $outputObject ? CMS_tree::getPageByID($q->getValue("father_ltr")) : $q->getValue("father_ltr");
	}
	
	/**
	  * Returns the ancestor of the given page, at the given offset.
	  * Offset : 	positive : 1 is for father, 2 for grand-father, and so on.
	  * 			negative : -1 for the root sibling, -2 for the root grand-son (which are ancestors of $page)
	  * Static function.
	  *
	  * @param CMS_page $page The page we want the brother of
	  * @param integer $offset The ancestor offset (negative, will be sibling from root
	  * @param boolean $stopAtWebsites Should the lineage stop at websites roots (other than the main website) ?
	  * @return CMS_page The ancestor, or false if not found
	  * @access public
	  */
	function getAncestor(&$page, $offset, $stopAtWebsites = false, $publicTree = false)
	{
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		if ($stopAtWebsites) {
			$ws = CMS_tree::getPageWebsite($page);
			$root = $ws->getRoot();
		} else {
			$root = CMS_tree::getRoot();
		}
		$lineage = CMS_tree::getLineage($root->getID(), $page->getID(), false, $publicTree);
		if (!$lineage) {
			return false;
		}
		if ($offset > 0) {
			$lineage = array_reverse($lineage);
		} else {
			$offset = abs($offset);
		}
		if ($offset >= sizeof($lineage)) {
			return false;
		} else {
			return CMS_tree::getPageByID($lineage[$offset]);
		}
	}
	
	/**
	  * Is the page an ancetor of the other ?
	  * Static function.
	  *
	  * @param CMS_page $ancestor The contested ancestor page
	  * @param CMS_page $sibling The sibling page
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return boolean true is there's a lineage beetween the two
	  * @access public
	  */
	function isAncestor(&$ancestor, &$page, $publicTree = false)
	{
		if (!is_a($ancestor, "CMS_page") || !is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Ancestor and page must be instances of CMS_page");
			return false;
		}
		$lineage = CMS_tree::getLineage($ancestor, $page, true, $publicTree);
		if ($lineage) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	  * Change pages order. Add the RESOURCE_EDITION_SIBLINGSORDER edition to the father.
	  * Static function.
	  *
	  * @param array of CMS_page id $newSiblingOrder The sibling pages to move in the good order
	  * @param CMS_profile_user $user The user operating the change.
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function changePagesOrder($newSiblingOrder, &$user)
	{
		//checks : pages must be CMS_pages and offset in (1, -1)
		if (!$newSiblingOrder) {
			CMS_grandFather::raiseError("NewSiblingOrder need to be an array");
			return false;
		}
		// Find the siblings to switch order
		$firstNewSibling = new CMS_page($newSiblingOrder[0]);
		$father = CMS_tree::getAncestor($firstNewSibling, 1);
		// Use this function to compact of siblings order
		if (!CMS_tree::compactSiblingOrder($father)) {
			CMS_grandFather::raiseError("Reordering siblings failed for page ".$father->getID());
			return false;
		}
		
		//move pages
		foreach ($newSiblingOrder as $newOrder => $sibling) {
			$newOrder += 1; //because array keys start to 0 and sibling number to 1
			//move the siblings order
			$sql = "
				update
					linx_tree_edited
				set
					order_ltr='".$newOrder."'
				where
					sibling_ltr='".$sibling."'
			";
			$q = new CMS_query($sql);
		}
		
		//set the father status editions
		$father->addEdition(RESOURCE_EDITION_SIBLINGSORDER, $user);
		$father->writeToPersistence();
		return true;
	}
	
	/**
	  * Revert siblings order from public state (used when a reordering is not validated).
	  * Take care to set never validated pages to the end of public order
	  * Static function.
	  *
	  * @param CMS_page $page The pages to revert siblings order
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function revertSiblingsOrder($page) {
		//check arguments are pages
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be an instance of CMS_page");
			return false;
		}
		//get public siblings order
		$sql = 
			"select 
				*
			from
				linx_tree_public
			where
				father_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			order by 
				order_ltr asc";
		$q = new CMS_query($sql);
		$publicOrders = array();
		while($r = $q->getArray()) {
			$publicOrders[$r['sibling_ltr']] = $r['order_ltr'];
		}
		//get edited siblings order (to get the never validated pages)
		$sql = 
			"select 
				*
			from
				linx_tree_public
			where
				father_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			order by 
				order_ltr asc";
		$q = new CMS_query($sql);
		$editedOrders = array();
		while($r = $q->getArray()) {
			$editedOrders[$r['sibling_ltr']] = $r['order_ltr'];
		}
		
		//delete all siblings from edited table
		$sql = "
			delete from
				linx_tree_edited
			where
				father_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		
		//add all siblings from public order
		$neworder = 0;
		foreach ($publicOrders as $sibling => $order) {
			$neworder++;
			$sql = "
				insert into
					linx_tree_edited
				set
					father_ltr='".$page->getID()."',
					sibling_ltr='".$sibling."',
					order_ltr='".$neworder."'
			";
			$q = new CMS_query($sql);
			unset($editedOrders[$sibling]);
		}
		//and set never validated page if any at end of order
		foreach ($editedOrders as $sibling => $order) {
			$neworder++;
			$sql = "
				insert into
					linx_tree_edited
				set
					father_ltr='".$page->getID()."',
					sibling_ltr='".$sibling."',
					order_ltr='".$neworder."'
			";
			$q = new CMS_query($sql);
			unset($editedOrders[$sibling]);
		}
		return true;
	}
	
	/**
	  * Revert page move from public state (used when a move is not validated).
	  * This function must only be used on page which was already validated once
	  * Static function.
	  *
	  * @param CMS_page $page The page to revert move
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function revertPageMove($page) {
		//check arguments are pages
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be an instance of CMS_page");
			return false;
		}
		//get current (edited) page father
		$sql = 
			"select 
				father_ltr
			from
				linx_tree_edited
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			";
		$q = new CMS_query($sql);
		$father = $q->getValue('father_ltr');
		//get old (public) page position
		$sql = 
			"select 
				father_ltr, order_ltr
			from
				linx_tree_public
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			";
		$q = new CMS_query($sql);
		$r = $q->getArray();
		$oldFather = $r['father_ltr'];
		$oldPosition = $r['order_ltr'];
		//remove page from current (edited) position
		$sql = "
			delete from
				linx_tree_edited
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
		";
		$q = new CMS_query($sql);
		// compact old siblings order
		CMS_tree::compactSiblingOrder(CMS_tree::getPageById($father));
		//get current order of siblings for old father
		$sql = 
			"select 
				sibling_ltr
			from
				linx_tree_edited
			where
				father_ltr='".sensitiveIO::sanitizeSQLString($oldFather)."'
			order by order_ltr asc
			";
		$q = new CMS_query($sql);
		$siblingsOrder = array();
		while($id = $q->getValue('sibling_ltr')) {
			$siblingsOrder[] = $id;
		}
		//set moved page into siblings at it's old position
		$newSiblingOrder = array_slice($siblingsOrder, 0, $oldPosition - 1);
		$newSiblingOrder[] = $page->getID();
		$newSiblingOrder = array_merge($newSiblingOrder, array_slice($siblingsOrder, $oldPosition - 1));
		//set new pages order
		foreach ($newSiblingOrder as $newOrder => $sibling) {
			$newOrder += 1; //because array keys start to 0 and sibling number to 1
			if ($sibling != $page->getID()) {
				//move the siblings order
				$sql = "
					update
						linx_tree_edited
					set
						order_ltr='".$newOrder."'
					where
						sibling_ltr='".$sibling."'
				";
			} else {
				//move the siblings order
				$sql = "
					insert into
						linx_tree_edited
					set
						father_ltr='".$oldFather."',
						sibling_ltr='".$sibling."',
						order_ltr='".$newOrder."'
				";
			}
			$q = new CMS_query($sql);
		}
		return true;
	}
	
	/**
	  * Publish the siblings order of a page : all its siblings order will go from _edited to _public
	  * Static function.
	  *
	  * @param CMS_page $page The page whose siblings are well ordered
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function publishSiblingsOrder(&$page)
	{
		//check arguments are pages
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be an instance of CMS_page");
			return false;
		}
		
		//if page was nevervalidated, do nothing
		if ($page->getPublication() == RESOURCE_PUBLICATION_NEVERVALIDATED) {
			return false;
		}

		//calculate the siblings ids to add
		$siblings = CMS_tree::getSiblings($page);
		$siblings_published = array();
		foreach ($siblings as $sibling) {
			if ($sibling->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
				$siblings_published[] = $sibling;
			}
		}
		
		//delete all siblings from old table
		$sql = "
			delete from
				linx_tree_public
			where
				father_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		
		//add all siblings
		$order = 0;
		foreach ($siblings_published as $sibling) {
			$order++;
			$sql = "
				insert into
					linx_tree_public
				set
					father_ltr='".$page->getID()."',
					sibling_ltr='".$sibling->getID()."',
					order_ltr='".$order."'
			";
			$q = new CMS_query($sql);
		}
		return true;
	}
	
	/**
	  * Publish the move of a page : page new position pass from edited to public
	  * Static function.
	  *
	  * @param CMS_page $page The page which move
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function publishPageMove(&$page)
	{
		//check arguments are pages
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be an instance of CMS_page");
			return false;
		}
		
		//if page was nevervalidated, do nothing
		if ($page->getPublication() == RESOURCE_PUBLICATION_NEVERVALIDATED) {
			return false;
		}
		
		//get current old (public) page father
		$sql = 
			"select 
				father_ltr
			from
				linx_tree_public
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			";
		$q = new CMS_query($sql);
		$oldFather = $q->getValue('father_ltr');
		//get new (edited) page position
		$sql = 
			"select 
				father_ltr, order_ltr
			from
				linx_tree_edited
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
			";
		$q = new CMS_query($sql);
		$r = $q->getArray();
		$newFather = $r['father_ltr'];
		$newPosition = $r['order_ltr'];
		//remove page from current (public) position
		$sql = "
			delete from
				linx_tree_public
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($page->getID())."'
		";
		$q = new CMS_query($sql);
		// compact old public siblings order
		CMS_tree::compactSiblingOrder(CMS_tree::getPageById($oldFather), true);
		//get current order of siblings for new father
		$sql = 
			"select 
				sibling_ltr
			from
				linx_tree_public
			where
				father_ltr='".sensitiveIO::sanitizeSQLString($newFather)."'
			order by order_ltr asc
			";
		$q = new CMS_query($sql);
		$siblingsOrder = array();
		while($id = $q->getValue('sibling_ltr')) {
			$siblingsOrder[] = $id;
		}
		//set moved page into siblings at it's old position
		$newSiblingOrder = array_slice($siblingsOrder, 0, $newPosition - 1);
		$newSiblingOrder[] = $page->getID();
		$newSiblingOrder = array_merge($newSiblingOrder, array_slice($siblingsOrder, $newPosition - 1));
		//set new pages order
		foreach ($newSiblingOrder as $newOrder => $sibling) {
			$newOrder += 1; //because array keys start to 0 and sibling number to 1
			if ($sibling != $page->getID()) {
				//move the siblings order
				$sql = "
					update
						linx_tree_public
					set
						order_ltr='".$newOrder."'
					where
						sibling_ltr='".$sibling."'
				";
			} else {
				//move the siblings order
				$sql = "
					insert into
						linx_tree_public
					set
						father_ltr='".$newFather."',
						sibling_ltr='".$sibling."',
						order_ltr='".$newOrder."'
				";
			}
			$q = new CMS_query($sql);
		}
		return true;
	}
	
	/**
	  * Change a sibling order. Add the RESOURCE_EDITION_SIBLINGSORDER edition to the father.
	  * Static function.
	  *
	  * @param CMS_page $sibling The sibling page to move
	  * @param integer $moveOffset The move offset : 1 to move it to the right, -1 to the left. No other values permitted.
	  * @param CMS_profile_user $user The user operating the change.
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function changeSiblingOrder(&$sibling, $moveOffset, &$user)
	{
		//checks : pages must be CMS_pages and offset in (1, -1)
		if (!is_a($sibling, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		if (!SensitiveIO::isInSet($moveOffset, array(1, -1))) {
			CMS_grandFather::raiseError("Offset must be 1 or -1");
			return false;
		}
		
		// Find the siblings to switch order
		$father = CMS_tree::getAncestor($sibling, 1);
		// Use this function to compact of siblings order
		if (!CMS_tree::compactSiblingOrder($father)) {
			CMS_grandFather::raiseError("Reordering siblings failed for page ".$father->getID());
			return false;
		}
		
		$siblings = CMS_tree::getSiblings($father);
		$sibling_to_move_left = false;
		$sibling_to_move_right = false;
		$lastSibling = false;
		foreach ($siblings as $aSibling) {
			if ($moveOffset == 1 && $lastSibling && $lastSibling->getID() == $sibling->getID()) {
				$sibling_to_move_left = $aSibling;
				$sibling_to_move_right = $sibling;
				break;
			}
			if ($moveOffset == -1 && $lastSibling && $aSibling->getID() == $sibling->getID()) {
				$sibling_to_move_left = $sibling;
				$sibling_to_move_right = $lastSibling;
				break;
			}
			$lastSibling = $aSibling;
		}
		
		if ($sibling_to_move_left && $sibling_to_move_right) {
			//move the siblings order
			$sql = "
				update
					linx_tree_edited
				set
					order_ltr=order_ltr - 1
				where
					sibling_ltr='".$sibling_to_move_left->getID()."'
			";
			$q = new CMS_query($sql);
			$sql = "
				update
					linx_tree_edited
				set
					order_ltr=order_ltr + 1
				where
					sibling_ltr='".$sibling_to_move_right->getID()."'
			";
			$q = new CMS_query($sql);
			
			//set the father status editions
			$father->addEdition(RESOURCE_EDITION_SIBLINGSORDER, $user);
			$father->writeToPersistence();
			return true;
		} else {
			CMS_grandFather::raiseError("Move impossible (first or last sibling to move, or father and sibling not related");
			return false;
		}
	}
	
	/**
	  * Compact ordered list of siblings, prevent from blank intervals in 
	  * the list of integers representing order. All orders must increase 
	  * one by one to avoir bugs in reordering then.
	  * Static function.
	  *
	  * @param CMS_page $page The sibling page order list of siblings
	  * @return boolean true on succes, false if error
	  * @access public
	  */
	function compactSiblingOrder(&$page, $publicTree = false)
	{
		$proceed = true;
		// Chekcs
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		// Checks if any hole in list order (more orders than records in siblings)
		$sql = "
			select
				count(*),
				max(order_ltr)
			from
				".$table."
			where
				father_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		$arr = $q->getArray();
		if ((int) $arr["max(order_ltr)"] != (int) $arr["count(*)"]) {
			//move the siblings order
			$sql = "
				select
					id_ltr
				from
					".$table."
				where
					father_ltr='".$page->getID()."'
				order by
					order_ltr
			";
			$q = new CMS_query($sql);
			$order=0;
			while ($link_id = $q->getValue("id_ltr")) {
				$order++;
				$sql = "
					update
						".$table."
					set
						order_ltr='".$order."'
					where
						id_ltr='".$link_id."'
				";
				$qU = new CMS_query($sql);
				if ($qU->hasError()) {
					CMS_grandFather::raiseError("Error while reordering siblings of page ".$page->getID().", link ID in linx_tree_edited: ".$link_id);
					$proceed = false;
				}
			}
		}
		return $proceed;
	}
	
	/**
	  * Returns the website of a page
	  * Static function
	  * 
	  * @param mixed CMS_page or pageID $page : The page we want the website of
	  * @return CMS_website or false on failure
	  * @access public
	  */
	function getPageWebsite(&$page)
	{
		//check argument is a page
		if (is_object($page)) {
			$pageID = $page->getID();
		} elseif (sensitiveIO::isPositiveInteger($page)) {
			$pageID = $page;
		} else {
			CMS_grandFather::raiseError('Page must be instance of CMS_page or valid page ID');
			return false;
		}
		$nearestWebsite = false;
		//get the full lineage of queried page
		$lineage = CMS_tree::getLineage(APPLICATION_ROOT_PAGE_ID, $pageID, false);
		if (!$lineage) {
			CMS_grandFather::raiseError('Lineage error for page : '.$pageID);
			return false;
		} else {
			$lineage = array_reverse($lineage);
			foreach ($lineage as $ancestor) {
				if (CMS_websitesCatalog::isWebsiteRoot($ancestor)) {
					$nearestWebsite = $ancestor;
					break;
				}
			}
		}
		if (!$nearestWebsite) {
			return false;
		}
		return CMS_websitesCatalog::getWebsiteFromRoot($nearestWebsite);
	}
	
	/**
	  * Move a page in the tree structure
	  * Static function.
	  *
	  * @param CMS_page $page The page to move
	  * @param CMS_page $newFather The new father of the page
	  * @param array of CMS_page id $newSiblingOrder The sibling pages to move in the good order
	  * @param CMS_profile_user $user The user operating the change.
	  * @return string The error string (abbreviated) or false if no error
	  * @access public
	  */
	function movePage(&$page, &$newFather, $newSiblingOrder, &$user)
	{
		//check arguments are pages
		if (!is_a($page, "CMS_page") || !is_a($newFather, "CMS_page")) {
			CMS_grandFather::_raiseError("CMS_tree : movePage : ancestor and page must be instances of CMS_page");
			return false;
		}
		//get page current father
		$father = CMS_tree::getAncestor($page, 1);
		//can't move page to the same father (useless...)
		if (is_object($father) && $newFather->getID() == $father->getID()) {
			CMS_grandFather::_raiseError("CMS_tree : movePage : can't move page under the same father (use changePagesOrder instead)");
			return false;
		}
		//check that the page to move ain't the root.
		$root = CMS_tree::getRoot();
		if ($root->getID() == $page->getID()) {
			CMS_grandFather::_raiseError("CMS_tree : movePage : can't move root");
			return false;
		}
		//check that the page to move ain't an ancestor of new father.
		$lineage = CMS_tree::getLineage($page, $newFather);
		if ($lineage) {
			CMS_grandFather::_raiseError("CMS_tree : movePage : can't move a page to a descendant of it");
			return false;
		}
		
		//detach the page from the edited tree
		CMS_tree::detachPageFromTree($page, false);
		//attach the page to the edited tree under the new father
		CMS_tree::attachPageToTree($page, $newFather, false);
		//set new pages order
		foreach ($newSiblingOrder as $newOrder => $sibling) {
			$newOrder += 1; //because array keys start to 0 and sibling number to 1
			//move the siblings order
			$sql = "
				update
					linx_tree_edited
				set
					order_ltr='".$newOrder."'
				where
					sibling_ltr='".$sibling."'
			";
			$q = new CMS_query($sql);
		}
		
		//set the page status editions
		$page->addEdition(RESOURCE_EDITION_MOVE, $user);
		$page->writeToPersistence();
		
		return true;
	}
	
	/**
	  * Regenerates all the pages AND make all re-register their links
	  * Static function.
	  *
	  * @param boolean $fromScratch If set to true, all pages will rebuild their content and not only their linxes
	  * @return void
	  * @access public
	  */
	function regenerateAllPages($fromScratch = false)
	{
		//first, clean all the linx files
		if ($fromScratch === true) {
			$dir = PATH_PAGES_LINXFILES_FS;
			if ($opendir = @opendir($dir)) {
				while (false !== ($readdir = readdir($opendir))) {
					if ($readdir !== '..' && $readdir !== '.' && $readdir !== '.htaccess' && $readdir !== '.cvsignore') {
						$readdir = trim($readdir);
						if (is_file($dir.'/'.$readdir)) {
							@unlink($dir.'/'.$readdir);
						}
					}
				}
				closedir($opendir);
			}
		}
		//then regenerate all the pages
		$sql = "
			select
				id_pag
			from
				pages,
				pagesBaseData_public,
				resources,
				resourceStatuses
			where
				page_pbd = id_pag
				and resource_pag=id_res
				and status_res=id_rs
				and location_rs='".RESOURCE_LOCATION_USERSPACE."'
				and publication_rs='".RESOURCE_PUBLICATION_PUBLIC."'
		";
		$q = new CMS_query($sql);
	    while ($id = $q->getValue("id_pag")) {
		    $regen_pages[] = $id;
		}
		CMS_tree::submitToRegenerator($regen_pages, $fromScratch);
	}
	
	/**
	  * Does the page has an ancestor ?
	  * Static function.
	  *
	  * @param integer $pageId The page to check for ancestor
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return boolean true or false
	  * @access public
	  */
	function hasAncestor($pageId, $publicTree = false) {
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		//check that the page ain't already in the tree
		$sql = "
			select
				1
			from
				".$table."
			where
				sibling_ltr='".sensitiveIO::sanitizeSQLString($pageId)."'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return true;
		}
		return false;
	}
	
	/**
	  * Attach a page to the tree (references it in the linx_tree tables)
	  * Static function.
	  *
	  * @param mixed $page The page to attach
	  * @param mixed $ancestor The father to attach to
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	function attachPageToTree($page, $ancestor, $publicTree = false)
	{
		//check argument is a page
		if (!is_a($page, "CMS_page") && !sensitiveIO::isPositiveInteger($page)) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page or positive integer");
			return false;
		}
		$pageId = (is_object($page)) ? $page->getID() : $page;
		//check argument is a page
		if (!is_a($ancestor, "CMS_page") && !sensitiveIO::isPositiveInteger($ancestor)) {
			CMS_grandFather::raiseError("Ancestor must be instance of CMS_page or positive integer");
			return false;
		}
		$ancestorId = (is_object($ancestor)) ? $ancestor->getID() : $ancestor;
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		//check that the page ain't already in the tree
		if (CMS_tree::hasAncestor($pageId, $publicTree)) {
			return true;
		}
		if ($publicTree) {
			//get the edited sibling order of the page if any
			$sql = "
				select
					order_ltr as eo
				from
					linx_tree_edited
				where
					sibling_ltr='".sensitiveIO::sanitizeSQLString($pageId)."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$sibling_order = $q->getValue("eo");
			}
			if (!sensitiveIO::isPositiveInteger($sibling_order)) {
				//get the current sibling order of the ancestor
				$sql = "
					select
						max(order_ltr) as mo
					from
						".$table."
					where
						father_ltr='".sensitiveIO::sanitizeSQLString($ancestorId)."'
				";
				$q = new CMS_query($sql);
				$sibling_order = $q->getValue("mo") + 1;
			}
		} else {
			//get the current sibling order of the ancestor
			$sql = "
				select
					max(order_ltr) as mo
				from
					".$table."
				where
					father_ltr='".sensitiveIO::sanitizeSQLString($ancestorId)."'
			";
			$q = new CMS_query($sql);
			$sibling_order = $q->getValue("mo") + 1;
		}
		//add page to the table
		$sql = "
			insert into
				".$table."
			set
				father_ltr='".sensitiveIO::sanitizeSQLString($ancestorId)."',
				sibling_ltr='".sensitiveIO::sanitizeSQLString($pageId)."',
				order_ltr='".$sibling_order."'
		";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Deletes a page from the tree (it will not be deleted, only detached).
	  * Static function.
	  *
	  * @param CMS_page $page The page to delete
	  * @param boolean $publicTree Do we want to fetch the public tree or the edited one ?
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function detachPageFromTree(&$page, $publicTree = false)
	{
		//check argument is a page
		if (!is_a($page, "CMS_page")) {
			CMS_grandFather::raiseError("Page must be instance of CMS_page");
			return false;
		}
		
		//check that the page to detach ain't the root.
		$root = CMS_tree::getRoot();
		if ($root->getID() == $page->getID()) {
			CMS_grandFather::raiseError("Can't detach root");
			return false;
		}
		
		$table = ($publicTree) ? "linx_tree_public" : "linx_tree_edited";
		$father = CMS_tree::getAncestor($page, 1);
		
		if (!$father) {
			//page is not in the tree
			return true;
		}
		
		//get the current sibling order of the page
		$sql = "
			select
				order_ltr
			from
				".$table."
			where
				father_ltr='".$father->getID()."'
		";
		$q = new CMS_query($sql);
		$current_sibling_order = $q->getValue("order_ltr");
		
		//delete page from the table
		$sql = "
			delete from
				".$table."
			where
				sibling_ltr='".$page->getID()."'
		";
		$q = new CMS_query($sql);
		//compact siblings orders of father
		CMS_tree::compactSiblingOrder($father, $publicTree);
		
		return true;
	}
	
	/**
	  * Get all the archived pages data : title, reference (ID), lastFileCreation date
	  * Static function.
	  *
	  * @return array(string=>string) The basic attribute indexed by "title", "id", "lastFileCreation"
	  * @access public
	  */
	function getArchivedPagesData()
	{
		$sql = "
			select
				id_pag,
				lastFileCreation_pag,
				title_pbd
			from
				pages,
				pagesBaseData_archived,
				resources,
				resourceStatuses
			where
				id_pag=page_pbd
				and resource_pag=id_res
				and status_res=id_rs
				and location_rs='".RESOURCE_LOCATION_ARCHIVED."'
		";
		$q = new CMS_query($sql);
		
		$pages = array();
		while ($data = $q->getArray()) {
			$page = array(	"title"				=> $data["title_pbd"],
							"id"				=> $data["id_pag"],
							"lastFileCreation"	=> $data["lastFileCreation_pag"]);
			$pages[] = $page;
		}
		return $pages;
	}
	
	/**
	  * Get the tree string needed by the text edition applet
	  * format is :
	  * 	pageID/roottitle/subroottitle/pagetitle:::[SAME AS BEFORE...]
	  * where ::: is the separator passed as argument
	  * Static function.
	  * Recursive function
	  *
	  * @param string $separator The pages separator.
	  * @return string the tree string
	  * @access public
	  */
	function getTreeString(&$user, $pageID, $separator, &$treeString)
	{
		static $treeStringInfos;
		$root = CMS_tree::getRoot();
		$lineage = CMS_tree::getLineage($root->getID(), $pageID, false);
		$treeString .= $pageID;
		
		//add ancestors
		if (is_array($lineage) && $lineage) {
			foreach ($lineage as $ancestor) {
				//to reduce the total time of the function (really long on big websites).
				if (!$treeStringInfos[$ancestor]) {
					$ancestor = new CMS_page($ancestor);
					$ancestorTitle = $treeStringInfos[$ancestor->getID()] = $ancestor->getTitle();
				} else {
					$ancestorTitle = $treeStringInfos[$ancestor];
				}
				
				//test the presence of the separator in the sibling title
				if (io::strpos($ancestorTitle, $separator) !== false) {
					CMS_grandFather::raiseError("Page has the separator in its title (transformed) : ".$ancestorTitle);
					$title = str_replace($separator, "[SEPARATOR]", $ancestorTitle);
				} else {
					$title = $ancestorTitle;
				}
				$treeString .= "/".addslashes($title);
			}
		}
		$treeString .= $separator;
		
		//get siblings and recursively show them
		$sibs = CMS_tree::getSiblings($pageID,false,false);
		if (!$sibs) {
			return $treeString;
		}
		foreach ($sibs as $sib) {
			CMS_tree::getTreeString($user, $sib, $separator, $treeString);
		}
	}
	
	/**
	  * Submit pages to the regenerator. The first argument can either be a single page ID or an array of those.
	  *
	  * @param mixed $pages If it's a scalar, it's a page ID, else an array of pages IDs
	  * @param integer $fromScratch Is the submission concerning a full from scratch regeneration (true) or a regeneration from linx files (false) ?
	  * @param boolean $dontLaunchRegenerator to avoid multiple launch of the regenerator during multiple validation only the last page validation launch the script
	  * @return void
	  * @access public
	  */
	function submitToRegenerator($pages, $fromScratch, $dontLaunchRegenerator=false)
	{
		$fs = ($fromScratch) ? true : false;
		if (!is_array($pages)) {
			$pages = array($pages);
		}
		//get all scripts for standard module
		if (!class_exists('CMS_module_standard')) {
			CMS_grandFather::raiseError("Can not found standard module");
			return false;
		}
		$scripts = CMS_scriptsManager::getScripts(MOD_STANDARD_CODENAME);
		$pagesToRegen = array();
		foreach ($scripts as $scriptID => $script) {
			$pagesToRegen[$script['pageid']] = array('fromscratch' => $script['fromscratch'], 'script' => $scriptID);
		}
		
		foreach ($pages as $page) {
			if (isset($pagesToRegen[$page])) {
				//is existant script need to be updated ?
				$actual_fs = $pagesToRegen[$page]['fromscratch'];
				if (!$actual_fs && $fs) {
					$parameters = array(
						'pageid' => $page,
						'fromscratch' => $fs,
					);
					CMS_scriptsManager::addScript(MOD_STANDARD_CODENAME, $parameters, $pagesToRegen[$page]['script']);
				}
			} else {
				//add script
				$parameters = array(
					'pageid' => $page,
					'fromscratch' => $fs,
				);
				CMS_scriptsManager::addScript(MOD_STANDARD_CODENAME, $parameters);
			}
		}
		if (!$dontLaunchRegenerator) {
			//then, launch the regenerator script
			CMS_scriptsManager::startScript();
		}
	}
	
	/**
	  * Return a valid page for a given URL
	  *
	  * @param string $pageUrl the page URL
	  * @param boolean $useDomain : use queried domain to found root page associated (default : true)
	  * @return CMS_page if page founded, false otherwise
	  * @access public
	  */
	function analyseURL($pageUrl, $useDomain = true) {
		if (strpos($pageUrl, PATH_FORBIDDEN_WR) === 0 || strpos($pageUrl, PATH_SPECIAL_PAGE_NOT_FOUND_WR) === 0) {
			return false;
		}
		$requestedPageId = null;
		$urlinfo = @parse_url($pageUrl);
		if (isset($urlinfo['path'])) {
			$pathinfo = pathinfo($urlinfo['path']);
			$basename = (isset($pathinfo['filename'])) ? $pathinfo['filename'] : $pathinfo['basename'];
		}
		if (isset($urlinfo['query'])) {
			$querystring = $urlinfo['query'];
		}
		if ($useDomain) {
			$httpHost = @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
			//search page id by domain address
			$domain = isset($urlinfo['host']) ? $urlinfo['host'] : $httpHost;
			$domainFounded = CMS_websitesCatalog::getWebsiteFromDomain($domain);
		}
		//if basename founded
		if (isset($urlinfo['path']) && $urlinfo['path'] != '/' && $basename && ((isset($pathinfo['extension']) && strtolower($pathinfo['extension']) == 'php') || !isset($pathinfo['extension']))) {
			//search page id in basename (declare matching patterns by order of research)
			$patterns[] = "#^([0-9]+)-#U"; // for request like id-page_title.php
			$patterns[] = "#^print-([0-9]+)-#U"; // for request like print-id-page_title.php
			$patterns[] = "#_([0-9]+)_$#U"; // for request like _id_id_.php : old V3 style url
			$patterns[] = "#^([0-9]+)$#U"; // for request like id
			$count = 0;
			while(!preg_match($patterns[$count] , $basename, $requestedPageId) && $count+1 < sizeof($patterns)) {
				$count++;
			}
			if (isset($requestedPageId[1]) && sensitiveIO::IsPositiveInteger($requestedPageId[1])) {
				//try to instanciate the requested page
				$cms_page = CMS_tree::getPageByID($requestedPageId[1]);
				if ($cms_page && !$cms_page->hasError() && (!$useDomain || $domainFounded)) {
					return $cms_page;
				}
			}
		} elseif (isset($pathinfo['extension']) && $pathinfo['extension'] && $pathinfo['extension'] != 'php') {
			return false;
		} elseif ($useDomain) {
			if (is_object($domainFounded)) {
				$cms_page = $domainFounded->getRoot();
				if ($cms_page && !$cms_page->hasError()) {
					return $cms_page;
				}
			}
		}
		return false;
	}
}
?>
