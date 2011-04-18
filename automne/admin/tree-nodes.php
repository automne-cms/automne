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
//
// $Id: tree-nodes.php,v 1.6 2010/03/08 16:41:22 sebastien Exp $

/**
  * PHP page : Load tree window infos
  * Used accross an Ajax request
  * Return formated tree nodes infos in JSON format
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_REDIRECT", 1625);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//simple function used to test a value with the string 'false'
function checkFalse($value) {
	return ($value == 'false');
}
function checkNotFalse($value) {
	return ($value !== 'false');
}
$nodeId = (isset($_REQUEST['node']) && io::strpos($_REQUEST['node'], 'page') === 0 && sensitiveIO::isPositiveInteger(io::substr($_REQUEST['node'],4))) ? io::substr($_REQUEST['node'],4) : false;
$rootId = sensitiveIO::request('root', 'sensitiveIO::isPositiveInteger', 'APPLICATION_ROOT_PAGE_ID');
$editable = (sensitiveIO::request('editable', 'checkNotFalse')) ? true : false;
$onClick = sensitiveIO::request('onClick');
$onSelect = sensitiveIO::request('onSelect');
$pageProperty = sensitiveIO::request('pageProperty');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger');
$winId = sensitiveIO::request('winId', '', 'treeWindow');
$showRoot = (sensitiveIO::request('showRoot', 'checkFalse')) ? false : true;
$maxlevel = (int) sensitiveIO::request('maxlevel', '', 0);
$enableDD = (sensitiveIO::request('enableDD', 'checkNotFalse')) ? true : false;

$maxlevelReached = false;
//load node page and siblings
if ($nodeId) {
	$node = CMS_tree::getPageByID($nodeId);
	if ($node->hasError()) {
		CMS_grandFather::raiseError('Node page has error ...');
		$view->show();
	}
	if ($maxlevel) {
		//check current level number
		$lineage = CMS_tree::getLineage($rootId, $nodeId, false);
		if ($maxlevel && sizeof($lineage) >= $maxlevel) $maxlevelReached = true;
	}
	$siblings = CMS_tree::getSiblings($node);
} elseif (isset($_REQUEST['node']) && io::strpos($_REQUEST['node'], 'root') === 0) {
	//load website root
	$node = CMS_tree::getPageByID($rootId);
	//check for users rights
	if ($showRoot && $cms_user->hasPageClearance($node->getID(), ($editable ? CLEARANCE_PAGE_EDIT : CLEARANCE_PAGE_VIEW))) {
		$siblings = array($node);
		unset($node);
	} else {
		$siblings = CMS_tree::getSiblings($node);
	}
	if ($maxlevel == 1) $maxlevelReached = true;
}
//remove unused siblings
foreach ($siblings as $key => $sibling) {
	if (!$cms_user->hasPageClearance($sibling->getID(), ($editable ? CLEARANCE_PAGE_EDIT : CLEARANCE_PAGE_VIEW))) {
		unset($siblings[$key]);
	}
}
//if node is root, then get all orphan tree pages and append them to siblings
if (isset($node) && $node->getID() == $rootId) {
	//get all clearances root pages
	$roots = ($editable) ? $cms_user->getEditablePageClearanceRoots() : $cms_user->getViewablePageClearanceRoots();
	foreach ($roots as $pageRootID) {
		if ($pageRootID != APPLICATION_ROOT_PAGE_ID) {
			//get lineage for this clearance root
			$rootLineage = CMS_tree::getLineage(APPLICATION_ROOT_PAGE_ID, $pageRootID, false);
			//go through lineage to check for a break in pages rights
			if (is_array($rootLineage)) {
				$ancestor = array_pop($rootLineage);
				$lastAncestor = '';
				
				while ($rootLineage && $cms_user->hasPageClearance($ancestor, ($editable ? CLEARANCE_PAGE_EDIT : CLEARANCE_PAGE_VIEW))) {
					$lastAncestor = $ancestor;
					$ancestor = array_pop($rootLineage);
				}
				if ($rootLineage && $lastAncestor && !isset($siblings['ancestor'.$lastAncestor])) { //lineage has a break in pages rights so append page to siblings
					$pageRoot = CMS_tree::getPageByID($lastAncestor);
					if ($pageRoot->hasError()) {
						CMS_grandFather::raiseError('Node page '.$lastAncestor.' has error ...');
					} else {
						$siblings['ancestor'.$lastAncestor] = $pageRoot;
					}
				}
			}
		}
	}
}

//get lineage for current page if any
$currentPageLineage = ($currentPage) ? CMS_tree::getLineage($rootId, $currentPage, false) : array();
if (!is_array($currentPageLineage)) {
	$currentPageLineage =  array();
}

$nodes = array();
foreach ($siblings as $sibling) {
	if ($cms_user->hasPageClearance($sibling->getID(), ($editable ? CLEARANCE_PAGE_EDIT : CLEARANCE_PAGE_VIEW))) {
		//property display
		if ($pageProperty) {
			$property = '';
			switch ($pageProperty) {
			case "last_creation_date":
				$date = $sibling->getLastFileCreationDate();
				if (is_a($date, "CMS_date")) {
					$date->setFormat($cms_language->getDateFormat());
					$property = '('.$date->getLocalizedDate().')';
				}
				break;
			case "template":
				$tmp = $sibling->getTemplate();
				$property = '('.((is_a($tmp, "CMS_pageTemplate")) ?  $tmp->getLabel() : '???').')';
				break;
			}
		} else {
			$property = '('.$sibling->getID().')';
			$redirectlink = $sibling->getRedirectLink(true);
			if ($redirectlink->hasValidHREF()) {
				if ($redirectlink->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
					$redirectPage = new CMS_page($redirectlink->getInternalLink());
					if (!$redirectPage->hasError()) {
						$property .= '<small class="atm-help" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_REDIRECT, array('\''.$redirectPage->getTitle(true).'\' ('.$redirectPage->getID().')')).'"> &rArr; '.$redirectPage->getID().'</small>';
					}
				} else {
					$label = $redirectlink->getExternalLink();
					$property .= '<small class="atm-help" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_REDIRECT, array(io::ellipsis($label, '80'))).'"> &rArr; '.io::ellipsis($label, '50').'</small>';
				}
			}
		}
		
		$pageTitle = (PAGE_LINK_NAME_IN_TREE) ? $sibling->getLinkTitle() : $sibling->getTitle();
		$hasSiblings = CMS_tree::hasSiblings($sibling) ? true : false;
		$ddtext = '';
		$draggable = $allowDrop = false;
		$editableSibling = $cms_user->hasPageClearance($sibling->getId(), CLEARANCE_PAGE_EDIT);
		if ($enableDD) {
			//does this node draggable ? (/!\ only public nodes can be draggable)
			$draggable = ($editableSibling
							 && (!$hasSiblings || ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) && $sibling->getID() != APPLICATION_ROOT_PAGE_ID))
							 && $sibling->getPublication() == RESOURCE_PUBLICATION_PUBLIC);
			
			//does this node can be a drop target ?
			$allowDrop = (!$maxlevelReached && $cms_user->hasPageClearance($sibling->getId(), CLEARANCE_PAGE_EDIT));
			//$ddtext = $allowDrop ? ' allowDrop' : '';
		}
		
		$nodes[] = array(
			'id'		=>	'page'.$sibling->getID(), 
			'onClick'	=>	($editableSibling || $sibling->getPublication() == RESOURCE_PUBLICATION_PUBLIC) ? sprintf($onClick, $sibling->getID()) : '',
			'onSelect'	=>	sprintf($onSelect, $sibling->getID()),
			'text'		=>	io::htmlspecialchars($pageTitle).' '.$property.$ddtext,
			'status'	=>	$sibling->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $sibling->getID()),
			'leaf'		=>	($maxlevelReached || !$hasSiblings), 
			/*'qtip'		=>	'tip for page '.$sibling->getTitle(),
			'qtipTitle'	=>	'tip title',*/
			'draggable'	=>	$draggable,
			'allowDrop'	=>	$allowDrop,
			'allowChildren' => true, //allow appening a node by DD even if it is a leaf
			'disabled'	=>	false,
			'uiProvider'=>	'page',
			'selected'	=>	($sibling->getID() == $currentPage),
			'expanded'	=>	in_array($sibling->getID(), $currentPageLineage),
		);
	}
}

$view->setContent($nodes);
$view->show();
?>