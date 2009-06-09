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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: server-scripts-controler.php,v 1.2 2009/06/09 13:27:49 sebastien Exp $

/**
  * PHP controler : Receive actions on server
  * Used accross an Ajax request to process one server action
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//Controler vars
$action = sensitiveIO::request('action', array('regenerate-all', 'regenerate-tree', 'regenerate-pages', 'restart-scripts', 'stop-scripts', 'clear-scripts'));
$page = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger');
$pages = sensitiveIO::request('pages');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has scripts admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	CMS_grandFather::raiseError('User has no regeneration rights');
	$view->setActionMessage('Vous n\'avez pas les droits d\'administrer les scripts ...');
	$view->show();
}

$cms_message = '';
$content = '';

switch ($action) {
	case 'regenerate-all':
		//give it more time
		@set_time_limit(1000);
		CMS_tree::regenerateAllPages(true);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE).' : Toutes les pages ont été soumises à régénération.';
	break;
	case 'regenerate-tree':
		if ($page) {
			$pages = CMS_tree::getAllSiblings($page, true);
			if (sizeof($pages) > 3) {
				//submit pages to regenerator
				$validPages = CMS_tree::pagesExistsInUserSpace($pages);
				CMS_tree::submitToRegenerator($validPages, true);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE).' : '.sizeof($validPages).' pages soumises à régénération.';
			} else {
				//regenerate pages
				@set_time_limit(1000);
				$validPages = CMS_tree::pagesExistsInUserSpace($pages);
				foreach ($validPages as $pageID) {
					$pg = CMS_tree::getPageByID($pageID);
					if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					    $pg->regenerate(true);
					}
				}
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE).' : '.sizeof($validPages).' pages régénérées.';
			}
		}
	break;
	case 'regenerate-pages':
		if ($pages) {
			$tmpPages = preg_split('#[ ;,]#', $pages);
			$pages = array();
			foreach ($tmpPages as $p) {
				$p=trim($p);
				if (SensitiveIO::isPositiveInteger($p)) {
					$pages[] = $p;		
				} elseif (ereg("[0-9]+\-[0-9]+", $p)) { //TODOV4
					$subPages = split('-', $p);
					sort($subPages);
					for ($idp = $subPages[0]; $idp <= $subPages[1]; $idp++) {
						$pages[] = $idp;
					}
				}
			}
			$pages = array_unique($pages);
			sort($pages);
			if (sizeof($pages)) {
				$validPages = CMS_tree::pagesExistsInUserSpace($pages);
				if (sizeof($validPages)) {
					if (sizeof($validPages) > 3) {
						//submit pages to regenerator
						CMS_tree::submitToRegenerator($validPages, true);
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE).' : '.sizeof($validPages).' pages soumises à régénération.';
					} else {
						//regenerate pages
						@set_time_limit(1000);
						foreach ($validPages as $pageID) {
							$pg = CMS_tree::getPageByID($pageID);
							if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
							    $pg->regenerate(true);
							}
						}
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE).' : '.sizeof($validPages).' pages régénérées.';
					}
				} else {
					$cms_message = 'Aucune page publique ne correspond aux identifiants saisis ...';
				}
			}
		}
	break;
	case 'restart-scripts':
		CMS_scriptsManager::startScript(true);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case 'stop-scripts':
		CMS_scriptsManager::clearScripts();
		CMS_scriptsManager::startScript(true);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case 'clear-scripts':
		CMS_scriptsManager::clearScripts();
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	default:
		CMS_grandFather::raiseError('Unknown action to do ...');
		$view->show();
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
if ($content) {
	$view->setContent($content);
}
$view->show();
?>