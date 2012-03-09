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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+

/**
  * PHP controler : Receive actions on modules cms_aliases
  * Used accross an Ajax request to process one alias action
  * 
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_PAGE_ACTION_DELETE_ERROR", 121);
define("MESSAGE_PAGE_ACTION_SAVE_ERROR", 178);
//Specific Alias messages
define("MESSAGE_ERROR_DIRECTORY_EXISTS", 35);
define("MESSAGE_ERROR_REDIRECTION_INCORRECT", 36);
define("MESSAGE_ERROR_PAGE_REDIRECTION_INCORRECT", 37);
define("MESSAGE_ERROR_ALIAS_PROTECTED", 38);
define("MESSAGE_ERROR_PAGE_ALREADY_ALIASED", 41);

//Controler vars
$action = sensitiveIO::request('action', array('delete', 'save'));
$aliasId = sensitiveIO::request('alias', 'sensitiveIO::isPositiveInteger');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

$codename = 'cms_aliases';
if (!$aliasId && $action != 'save') {
	CMS_grandFather::raiseError('Unknown alias ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module for codename : '.$codename);
	$view->show();
}
//CHECKS if user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

$cms_message = '';
$content = array('success' => false);

switch ($action) {
	case 'save':
		$fatherId = sensitiveIO::request('fatherId', 'sensitiveIO::isPositiveInteger');
		$newFatherId = sensitiveIO::request('newFatherId', 'sensitiveIO::isPositiveInteger');
		$pageId = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger');
		$name = sensitiveIO::request('name');
		$redirection = sensitiveIO::request('redirection');
		$websites = sensitiveIO::request('websites');
		$replaceURL = sensitiveIO::request('replaceURL') ? true : false;
		$permanent = sensitiveIO::request('permanent') ? true : false;
		
		// Current alias object to manipulate
		if ($aliasId) {
			$item = CMS_module_cms_aliases::getByID($aliasId);
		} else {
			$item = new CMS_resource_cms_aliases();
		}
		//check protected status
		$protected = sensitiveIO::request('protected') ? true : false;
		if (!$item->isProtected() || (!$protected && $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
			//set alias websites (needed to know if alias is correct in case of name conflict)
			$item->setWebsites(explode(',', $websites));
			//set parent only if alias has no subaliases
			if (!$item->hasSubAliases()) {
				if (io::isPositiveInteger($newFatherId)) {
					$parent = CMS_module_cms_aliases::getByID($newFatherId);
					$item->setParent($parent);
				} else {
					$item->setParent(false);
				}
				//then set alias name
				if (!$item->setAlias($name)) {
					$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_DIRECTORY_EXISTS, false, 'cms_aliases');
					break;
				}
			}
			$item->setReplaceURL($replaceURL);
			$item->setPermanent($permanent);
			$item->setProtected($protected);
			if ($pageId) {
				$page = CMS_tree::getPageById($pageId);
				if ($page && !$page->hasError()) {
					if (!$item->setPage($page)) {
						$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_PAGE_ALREADY_ALIASED, array($page->getID()), 'cms_aliases');
						break;
					}
				}
			} else {
				$href = new CMS_href($redirection);
				if (!$href->hasValidHREF()) {
					$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_REDIRECTION_INCORRECT, false, 'cms_aliases');
					break;
				}
				if ($href->getLinkType() == RESOURCE_LINK_TYPE_EXTERNAL) {
					$item->setURL($href->getExternalLink());
				} elseif ($href->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
					$page = $href->getInternalLinkPage();
					if ($page && !$page->hasError()) {
						if (!$item->setPage($page)) {
							$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_PAGE_ALREADY_ALIASED, array($page->getID()), 'cms_aliases');
							break;
						}
					} else {
						$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_PAGE_REDIRECTION_INCORRECT, false, 'cms_aliases');
						break;
					}
				}
			}
			if (!$cms_message) {
				if (!$item->writeToPersistence()) {
					$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SAVE_ERROR);
				} else {
					//Log action
					$log = new CMS_log();
					if ($aliasId) {
						$log->logMiscAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT, $cms_user, 'Edit Alias '.$item->getPath(), 'cms_aliases');
					} else {
						$log->logMiscAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT, $cms_user, 'Create Alias '.$item->getPath(), 'cms_aliases');
					}
					
					$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					$content = array('success' => true, 'id' => $item->getID());
				}
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_ALIAS_PROTECTED, false, 'cms_aliases');
			$item->raiseError('Error during modification of alias '.$item->getID().'. Alias is protected.');
		}
	break;
	case 'delete':
		$item = CMS_module_cms_aliases::getByID($aliasId);
		if (!$item->isProtected()) {
			$path = $item->getPath();
			if ($item->destroy()) {
				//Log action
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, 'Delete Alias '.$path, 'cms_aliases');
				
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
				$content = array('success' => true);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_ERROR_ALIAS_PROTECTED, false, 'cms_aliases');
			$category->raiseError('Error during modification of alias '.$item->getID().'. Alias is protected.');
		}
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