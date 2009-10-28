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
// $Id: page-controler.php,v 1.13 2009/10/28 16:26:00 sebastien Exp $

/**
  * PHP page : Receive pages updates
  * Used accross an Ajax request by an inline editor to update a page value
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_ACTION_EMAIL_SUBJECT", 172);
define("MESSAGE_PAGE_ACTION_EMAIL_BODY", 173);
define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_FORM_ERROR_MALFORMED_DATES", 332);
define("MESSAGE_FORM_ERROR_WRITING", 178);
define("MESSAGE_FORM_ERROR_CONTENT", 333);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_PAGE_ERROR_LOCKED", 334);
define("MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR", 166);
define("MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_SUBJECT", 170);
define("MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_BODY", 171);
define("MESSAGE_PAGE_ACTION_EMAIL_MOVE_SUBJECT", 597);
define("MESSAGE_PAGE_ACTION_EMAIL_MOVE_BODY", 598);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_SUBJECT", 182);
define("MESSAGE_PAGE_ACTION_EMAIL_CONTENT_BODY", 183);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT", 123);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY", 125);
define("MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_SUBJECT", 127);
define("MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_BODY", 128);
define("MESSAGE_PAGE_COPY_OF", 524);
define("MESSAGE_PAGE_ERROR_MISSING_DATA", 364);
define("MESSAGE_PAGE_ERROR_RIGHT", 365);
define("MESSAGE_PAGE_ERROR_COPY", 366);
define("MESSAGE_PAGE_ERROR_CREATION", 563);
define("MESSAGE_PAGE_ACTION_MOVE_ERROR", 695);
define("MESSAGE_PAGE_ACTION_MOVE_ERROR_NO_RIGHTS", 696);
define("MESSAGE_PAGE_ACTION_DUPLICATION_ERROR_NO_RIGHTS", 697);
define("MESSAGE_PAGE_ACTION_DUPLICATION_ERROR", 698);
define("MESSAGE_PAGE_ACTION_DUPLICATION_DONE", 699);
define("MESSAGE_ACTION_BLANK_PAGE", 1590);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_XML);
//This file is an admin file. Interface must be secure
$view->setSecure();

$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID());
$field = sensitiveIO::request('field', '', '');
$action = sensitiveIO::request('action', '', '');
$value = sensitiveIO::request('value', '', '');
$forceblank = sensitiveIO::request('forceblank') ? true : false;

//load page
$cms_page = CMS_tree::getPageByID($currentPage);
if ($cms_page->hasError()) {
	CMS_grandFather::raiseError('Selected page ('.$currentPage.') has error ...');
	$view->show();
}
//check for user rights on page
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	CMS_grandFather::raiseError('User has no edition rights on page ('.$currentPage.') ...');
	$view->show();
}
//check for lock
if ($action != 'unlock' || ($action == 'unlock' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
	if ($cms_page->getLock() && $cms_page->getLock() != $cms_user->getUserId()) {
		CMS_grandFather::raiseError('Page '.$currentPage.' is currently locked by another user and can\'t be updated.');
		$lockuser = CMS_profile_usersCatalog::getByID($cms_page->getLock());
		$view->setActionMessage($cms_language->getMessage(MESSAGE_PAGE_ERROR_LOCKED, array($lockuser->getFullName())));
		$view->show();
	}
}
$initialStatus = $cms_page->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
//page edited status
$edited = $logAction = false;
switch ($action) {
	case 'creation':
		$father = sensitiveIO::request('father', 'sensitiveIO::isPositiveInteger', false);
		$template = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger', false);
		$title = sensitiveIO::request('title');
		$linktitle = sensitiveIO::request('linktitle');
		$emptytpl = (sensitiveIO::request('emptytpl') == 1) ? true : false;
		
		$cms_page = new CMS_page();
		$cms_father = CMS_tree::getPageByID($father);
		if ($cms_father->hasError()) {
			CMS_grandFather::raiseError('Page creation : Father page ('.$father.') has error ...');
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_CREATION);
			break;
		}
		//must set the lastReminder to today
		$cms_page->touchLastReminder();
		$cms_page->setTitle($title, $cms_user);
		if ($linktitle) {
			$cms_page->setLinkTitle($linktitle, $cms_user);
		} else {
			$cms_page->setLinkTitle($title, $cms_user);
		}
		$cms_page->writeToPersistence();
		//create page, attach it to the tree
		CMS_tree::attachPageToTree($cms_page, $cms_father, false);
		//clone the template
		$pageTpl = CMS_pageTemplatesCatalog::getCloneFromID($template, false, true, $emptytpl);
		
		if ($cms_page->setTemplate($pageTpl->getID())) {
			$cms_page->writeToPersistence();
			//goto copied page
			$jscontent = '
			Automne.utils.getPageById('. $cms_page->getID() .', \'edit\');
			';
			$view->addJavascript($jscontent);
		} else {
			CMS_grandFather::raiseError('Page creation : Can\'t set page template : '.$pageTpl->getID().' ...');
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_CREATION);
		}
	break;
	case 'copy':
		//get datas
		$copyContent = (sensitiveIO::request('copyContent') == 1) ? true : false;
		$copiedPage = sensitiveIO::request('copiedPage', 'sensitiveIO::isPositiveInteger', false);
		$template = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger', false);
		
		if (!$copiedPage || !$template) {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_MISSING_DATA);
			$cms_page->raiseError('Error during copy of page. Copied page id : '.$copiedPage.' or template page id : '.$template.' not set.');
		}
		if (!$cms_user->hasPageClearance($copiedPage, CLEARANCE_PAGE_VIEW)) {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_RIGHT);
			$cms_page->raiseError('Error during copy of page '.$copiedPage.'. User has no view rights on page.');
		}
		//Proceeds with tree duplication
		if (!$cms_page->hasError()) {
			//page to copy
			$pageToDuplicate = CMS_tree::getPageByID($copiedPage);
			//page template
			$originalTemplate = $pageToDuplicate->getTemplate();
			//original source template
			$pageTplId = CMS_pageTemplatesCatalog::getTemplateIDForCloneID($originalTemplate->getID());
			if ($pageTplId == $template)  { //same template
				$duplicatedPage = $pageToDuplicate->duplicate($cms_user, false, !$copyContent);
			} else {
				$duplicatedPage = $pageToDuplicate->duplicate($cms_user, $template, !$copyContent);
			}
			if (is_a($duplicatedPage, 'CMS_page') && !$duplicatedPage->hasError()) {
				//attach duplicated page to tree
				if (CMS_tree::attachPageToTree($duplicatedPage, $cms_page)) {
					$edited = RESOURCE_EDITION_CONTENT;
					$logAction = CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT;
					$cms_page = $duplicatedPage;
					//append 'copy of' to page title
					$cms_page->setTitle($cms_language->getMessage(MESSAGE_PAGE_COPY_OF).' '.$cms_page->getTitle(), $cms_user);
					$cms_page->writeToPersistence();
					//goto copied page
					$jscontent = '
					Automne.utils.getPageById('. $cms_page->getID() .');
					';
					$view->addJavascript($jscontent);
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_COPY);
					$cms_page->raiseError('Error during copy of page '.$copiedPage.'. attachPageToTree method return false.');
				}
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_COPY);
				$cms_page->raiseError('Error during copy of page '.$copiedPage.'. duplicate method return false or an invalid page.');
			}
		}
	break;
	case 'regenerate':
		if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) && $cms_page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
			$cms_page->regenerate(true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			//reload public tab
			$jscontent = '
			if (Automne.tabPanels.getActiveTab().id == \'public\') {
				Automne.tabPanels.getActiveTab().reload();
			}';
			$view->addJavascript($jscontent);
		}
	break;
	case "cancel_draft":
		if ($cms_page->isDraft()) {
			//delete draft datas
			$tpl = $cms_page->getTemplate();
			CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
			CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
			
			$logAction = CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT;
			$edited = true;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
	case 'validate_draft':
	case 'submit_for_validation':
		//augment the execution time, because things here can be quite lengthy
		@set_time_limit(9000);
		//ignore user abort to avoid interuption of process
		@ignore_user_abort(true);
		//unlock page
		$cms_page->unlock();
		$tpl = $cms_page->getTemplate();
		//put draft datas into edited
		if (!CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true, $forceblank)) {
			//alert user for blank page
			$jscontent = '
			Automne.message.popup({
				msg: 				\''.$cms_language->getJSMessage(MESSAGE_ACTION_BLANK_PAGE).'\',
				buttons: 			Ext.MessageBox.YESNO,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR,
				fn: 				function (button) {
					if (button == \'cancel\') {
						return;
					}
					Automne.server.call({
						url:				\'page-controler.php\',
						params: 			{
							currentPage:		'.$currentPage.',
							forceblank:			1,
							action:				\''.$action.'\'
						},
						fcnCallback: 		function() {
							//then reload page infos
							Automne.tabPanels.getPageInfos({
								pageId:		this.pageId,
								noreload:	true
							});
						},
						callBackScope:		this
					});
				}
			});';
			$view->addJavascript($jscontent);
			break;
		}
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true);
		//change page editions (add CONTENT), move data from _edition to _edited
		$cms_page->addEdition(RESOURCE_EDITION_CONTENT, $cms_user);
		$cms_page->writeToPersistence();
		//delete draft datas
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		//if we only want to submit to validation, break here
		if ($action == 'submit_for_validation') {
			$edited = RESOURCE_EDITION_CONTENT;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT;
			//reload current tab
			$jscontent = '
			//goto previz tab
			Automne.tabPanels.setActiveTab(\'edited\', true);';
			$view->addJavascript($jscontent);
			break;
		}
		
		$logAction = CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION;
		//then validate this page content
		$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_CONTENT, $cms_page);
		$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
		$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
		$edited = true;
		//check for basedatas edition pending
		if ($cms_page->getStatus()->getEditions() & RESOURCE_EDITION_BASEDATA) {
			//then validate this page basedatas content
			$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, RESOURCE_EDITION_BASEDATA, $cms_page);
			$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
			$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
		}
		//reload page to force update status
		$cms_page = CMS_tree::getPageById($cms_page->getID());
		//reload current tab
		$jscontent = '
		//goto previz tab
		Automne.tabPanels.setActiveTab(\'public\', true);';
		$view->addJavascript($jscontent);
	break;
	case 'cancel_editions':
		// Copy clientspaces and data from public to edited tables
		$tpl = $cms_page->getTemplate();
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
		
		$cms_page->cancelAllEditions();
		$cms_page->writeToPersistence();
		
		$edited = true;
		$logAction = CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case "delete":
		//change the page proposed location and send emails to all the validators
		if ($cms_page->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user)) {
			$cms_page->writeToPersistence();
			$edited = RESOURCE_EDITION_LOCATION;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_DELETE;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
	case "archive":
		//change the page proposed location and send emails to all the validators
		if ($cms_page->setProposedLocation(RESOURCE_LOCATION_ARCHIVED, $cms_user)) {
			$cms_page->writeToPersistence();
			$edited = RESOURCE_EDITION_LOCATION;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_ARCHIVE;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
    break;
	case "unarchive":
		$cms_page->removeProposedLocation();
		$cms_page->writeToPersistence();
		
		$edited = true;
		$logAction = CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case "undelete":
		$cms_page->removeProposedLocation();
		$cms_page->writeToPersistence();
		
		$edited = true;
		$logAction = CMS_log::LOG_ACTION_RESOURCE_UNDELETE;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case 'move':
		$newParent = sensitiveIO::request('newParent');
		$oldParent = sensitiveIO::request('oldParent');
		
		if (!sensitiveIO::isPositiveInteger($newParent) || !sensitiveIO::isPositiveInteger($oldParent)) {
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR);
			$cms_page->raiseError('Error during move of page '.$cms_page->getID().'. Value set : '.$value);
		} else {
			if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
				if ($newParent == $oldParent) {
					//this is a reordering
					//the page used is the father of the current page
					//load parent page
					$cms_page = CMS_tree::getPageByID($newParent);
					$currentPage = $newParent;
					if ($cms_page->hasError()) {
						CMS_grandFather::raiseError('Selected page ('.$currentPage.') has error ...');
						$view->show();
					}
					//check for user rights on page
					if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
						CMS_grandFather::raiseError('User has no edition rights on page ('.$currentPage.') ...');
						$view->show();
					}
					$initialStatus = $cms_page->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
					
					$newPagesOrder = explode(',',$value);
					if (CMS_tree::changePagesOrder($newPagesOrder, $cms_user)) {
						$edited = RESOURCE_EDITION_SIBLINGSORDER;
						$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER;
						//must reload page
						$cms_page = CMS_tree::getPageByID($cms_page->getID());
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_SIBLINGMOVE_ERROR);
						$cms_page->raiseError('Error during move of page '.$cms_page->getID().'. Can\'t apply new order.');
					}
				} else {
					//this is a page moving
					$newPagesOrder = explode(',',$value);
					if (CMS_tree::movePage($cms_page, CMS_tree::getPageByID($newParent), $newPagesOrder, $cms_user)) {
						$edited = RESOURCE_EDITION_MOVE;
						$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_MOVE;
						//must reload page
						$cms_page = CMS_tree::getPageByID($cms_page->getID());
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_MOVE_ERROR);
						$cms_page->raiseError('Error during move of page '.$cms_page->getID().'.');
					}
				}
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_MOVE_ERROR_NO_RIGHTS);
				$cms_page->raiseError('Error during move of page '.$cms_page->getID().'. User does not have edition rights on current page.');
			}
		}
	break;
	case 'pageContent':
		$template = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
		$title = strip_tags(sensitiveIO::request('title'));
		$linktitle = strip_tags(sensitiveIO::request('linkTitle'));
		$redirection = sensitiveIO::request('redirection');
		$updateURL = sensitiveIO::request('updateURL') ? true : false;
		//base datas has changed so write the new ones
		if ($cms_page->getTitle() != $title || $cms_page->getLinkTitle() != $linktitle || $updateURL || $cms_page->getRedirectLink()->getTextDefinition() != $redirection) {
			if (!$cms_page->setTitle($title, $cms_user)) {
				$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
				$cms_page->raiseError('Error during set title for page '.$cms_page->getID().'. Value set : '.$title);
			}
			if (!$cms_page->setLinkTitle($linktitle, $cms_user)) {
				$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
				$cms_page->raiseError('Error during set link title for page '.$cms_page->getID().'. Value set : '.$linktitle);
			}
			if (!$cms_page->setRefreshUrl($updateURL, $cms_user)) {
				$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
				$cms_page->raiseError('Error during set refresh url for page '.$cms_page->getID().'. Value set : '.$updateURL);
			}
			$redirection = new CMS_href($redirection);
			if ($redirection->getLinkType() != RESOURCE_LINK_TYPE_INTERNAL || $redirection->getInternalLink() != $cms_page->getID()) {
				$cms_page->setRedirectLink($redirection,$cms_user);
			}
			if (!$cms_page->hasError() && $cms_page->writeToPersistence()) {
				$edited = RESOURCE_EDITION_BASEDATA;
				$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA;
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
				$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pageContent');
			}
		}
		//Page template update
		$tpl_original = $cms_page->getTemplate();
		//first check if page template is updated
		if (sensitiveIO::isPositiveInteger($template) && CMS_pageTemplatesCatalog::getTemplateIDForCloneID($tpl_original->getID()) != $template) {
			//hack if page has no valid template attached
			if (!is_a($tpl_original, "CMS_pageTemplate")) {
				$tpl_original = new CMS_pageTemplate();
			}
			$tpl = new CMS_pageTemplate($template);
			
			$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $tpl_original->getID());
			$cms_page->setTemplate($tpl_copy->getID());
			//destroy old template only if it's a copy
			if ($tpl_original->isPrivate()) {
				$tpl_original->destroy();
			}
			//save the page data
			if (!$cms_page->writeToPersistence()) {
				$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
				$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update template. New template set : '.$template);
			} else {
				$cms_page->regenerate(true);
				$jscontent = '
				Automne.tabPanels.getActiveTab().reload();
				';
				$view->addJavascript($jscontent);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			}
		}
	break;
	case 'pageDates':
		$pubdatestart = sensitiveIO::request('pubdatestart');
		$pubdateend = sensitiveIO::request('pubdateend');
		$reminderdate = sensitiveIO::request('reminderdate');
		$reminderdelay = sensitiveIO::request('reminderdelay', 'sensitiveIO::isPositiveInteger', 0);
		$remindertext = strip_tags(sensitiveIO::request('remindertext'));
		
		$reminderDate = $cms_page->getReminderOn();
		$dt_remind = new CMS_date();
		$dt_remind->setDebug(false);
		$dt_remind->setFormat($cms_language->getDateFormat());
		$dt_remind->setLocalizedDate($reminderdate, true);
		
		if (!$cms_page->setReminderOnMessage($remindertext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set reminder message for page '.$cms_page->getID().'. Value set : '.$remindertext);
		}
		if (!$cms_page->setReminderPeriodicity($reminderdelay, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set reminder delay for page '.$cms_page->getID().'. Value set : '.$reminderdelay);
		}
		if (!$dt_remind->setLocalizedDate($reminderdate, true)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set reminderdate for page '.$cms_page->getID().'. Value set : '.$reminderdate);
		} else {
			$cms_page->setReminderOn($dt_remind, $cms_user);
		}
		if (!$cms_page->hasError() && $cms_page->writeToPersistence()) {
			$edited = RESOURCE_EDITION_BASEDATA;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
			$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pageMetas');
		}
		
		
		$dt_beg = new CMS_date();
		$dt_beg->setDebug(false);
		$dt_beg->setFormat($cms_language->getDateFormat());
		$dateStart = $cms_page->getPublicationDateStart(false);
		
		$dt_end = new CMS_date();
		$dt_end->setDebug(false);
		$dt_end->setFormat($cms_language->getDateFormat());
		$dateEnd = $cms_page->getPublicationDateEnd(false);
		
		if ($dt_beg->setLocalizedDate($pubdatestart, false) && $dt_end->setLocalizedDate($pubdateend, true)) {
			//check if dates has changed
			if (!CMS_date::compare($dateStart, $dt_beg, '==') || !CMS_date::compare($dateEnd, $dt_end, '==')) {
				if (!$dt_end->isNull() && CMS_date::compare($dt_beg, $dt_end, '>')) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_DATES);
					$cms_page->raiseError('Error during set pubdatestart : date start is higher than date end. Values set for date start : '.$pubdatestart.', for date end : '.$pubdateend);
				} else {
					$cms_page->setPublicationDates($dt_beg, $dt_end);
					if ($cms_page->writeToPersistence()) {
						$edited = RESOURCE_EDITION_BASEDATA;
						$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pubdatestart, value : '.$pubdatestart);
					}
				}
			}
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set publication dates start/end for page '.$cms_page->getID().'. Values set for date start : '.$pubdatestart.', for date end : '.$pubdateend);
		}
	break;
	case 'pageSearchEngines':
		$categorytext = str_replace('"','',strip_tags(sensitiveIO::request('categorytext')));
		$descriptiontext = str_replace('"','',strip_tags(sensitiveIO::request('descriptiontext')));
		$keywordstext = str_replace('"','',strip_tags(sensitiveIO::request('keywordstext')));
		$robotstext = str_replace('"','',strip_tags(sensitiveIO::request('robotstext')));
		
		if (!$cms_page->setCategory($categorytext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set category for page '.$cms_page->getID().'. Value set : '.$categorytext);
		}
		if (!$cms_page->setDescription($descriptiontext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set description for page '.$cms_page->getID().'. Value set : '.$descriptiontext);
		}
		if (!$cms_page->setKeywords($keywordstext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set keywords for page '.$cms_page->getID().'. Value set : '.$keywordstext);
		}
		if (!$cms_page->setRobots($robotstext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set robots for page '.$cms_page->getID().'. Value set : '.$robotstext);
		}
		if (!$cms_page->hasError() && $cms_page->writeToPersistence()) {
			$edited = RESOURCE_EDITION_BASEDATA;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
			$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pageSearchEngines');
		}
	break;
	case 'pageMetas':
		$authortext = str_replace('"','',strip_tags(sensitiveIO::request('authortext')));
		$copyrighttext = str_replace('"','',strip_tags(sensitiveIO::request('copyrighttext')));
		$language = sensitiveIO::request('language');
		$metatext = sensitiveIO::request('metatext');
		$replytotext = str_replace('"','',strip_tags(sensitiveIO::request('replytotext', 'sensitiveIO::isValidEmail')));
		$pragma = sensitiveIO::request('pragmatext', 'sensitiveIO::isPositiveInteger', 0);
		
		if (!$cms_page->setAuthor($authortext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set author for page '.$cms_page->getID().'. Value set : '.$authortext);
		}
		if (!$cms_page->setCopyright($copyrighttext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set copyright for page '.$cms_page->getID().'. Value set : '.$copyrighttext);
		}
		if (!$cms_page->setLanguage($language, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set language for page '.$cms_page->getID().'. Value set : '.$language);
		}
		if (!$cms_page->setMetas($metatext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set metas for page '.$cms_page->getID().'. Value set : '.$metatext);
		}
		if (!$cms_page->setReplyto($replytotext, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set replyto for page '.$cms_page->getID().'. Value set : '.$replytotext);
		}
		if (!$cms_page->setPragma($pragma, $cms_user)) {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
			$cms_page->raiseError('Error during set pragma for page '.$cms_page->getID().'. Value set : '.$pragma);
		}
		if (!$cms_page->hasError() && $cms_page->writeToPersistence()) {
			$edited = RESOURCE_EDITION_BASEDATA;
			$logAction = CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
			$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pageMetas');
		}
	break;
	case 'tree-duplicate':
		$pageFromId = sensitiveIO::request('pageFrom', 'sensitiveIO::isPositiveInteger', false);
		$pageToId = sensitiveIO::request('pageTo', 'sensitiveIO::isPositiveInteger', false);
		
		//CHECKS user has duplication clearance
		if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH)) {
			CMS_grandFather::raiseError('User has no rights to duplicate branch...');
			$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DUPLICATION_ERROR_NO_RIGHTS);
		} else {
			//augment the execution time, because things here can be quite lengthy
			@set_time_limit(9000);
			//ignore user abort to avoid interuption of process
			@ignore_user_abort(true);
			
			//Proceeds with tree duplication
			//First node page
			$pageFrom = CMS_tree::getPageByID($pageFromId);
			//First destination page
			$pageTo = CMS_tree::getPageByID($pageToId);
			$pageDuplicated = array();
			
			function duplicatePage($user, $page, $pageToAttachTo) {
				global $pageDuplicated;
				if (is_a($page, "CMS_page") && is_a($pageToAttachTo, "CMS_page") && $page->getTemplate()) {
					//Duplicate page template
					$tpl = $page->getTemplate();
					$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $tpl->getID());
					$_tplID = $tpl_copy->getID();
					//Create copy of given page
					$newPage = $page->duplicate($user, $_tplID) ;
					//Move to destination in tree
					if (is_null($newPage) || !CMS_tree::attachPageToTree($newPage, $pageToAttachTo) ) {
						return null;
					}
					$pageDuplicated[] = $newPage->getID();
					//Proceed with siblings
					$sibs = CMS_tree::getSiblings($page);
					if (!$sibs || !sizeof($sibs)) {
						return $pageToAttachTo;
					} else {
						$pageToAttachTo = $newPage ;
					}
					foreach ($sibs as $sib) {
						if ($user->hasPageClearance($sib->getID(), CLEARANCE_PAGE_EDIT) && !in_array($sib->getID(),$pageDuplicated)) {
							duplicatePage($user, $sib, $pageToAttachTo);
						}
					}
				}
			}
			if (!$pageFrom->hasError() && !$pageTo->hasError()) {
				//Do recursivly
				duplicatePage($cms_user, $pageFrom, $pageTo) ;
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DUPLICATION_DONE);
			} else {
				$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DUPLICATION_ERROR);
			}
		}
	break;
	default:
		CMS_grandFather::raiseError('Unknown action '.$action.' to do for page '.$currentPage.' with value : '.$value);
		$view->show();
	break;
}
//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
//if page is edited, proceed edition
if ($edited) {
	$status = $cms_page->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
	//if page status is changed
	if ($status != $initialStatus) {
		//Replace all the status icons by the new one across the whole interface
		$tinyStatus = $cms_page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
		$statusId = $cms_page->getStatus()->getStatusId(MOD_STANDARD_CODENAME, $cms_page->getID());
		$xmlcontent = '
		<status><![CDATA['.$status.']]></status>
		<tinystatus><![CDATA['.$tinyStatus.']]></tinystatus>';
		$view->setContent($xmlcontent);
		$jscontent = '
		Automne.utils.updateStatus(\''.$statusId.'\', response.responseXML.getElementsByTagName(\'status\').item(0).firstChild.nodeValue, response.responseXML.getElementsByTagName(\'tinystatus\').item(0).firstChild.nodeValue);
		';
		$view->addJavascript($jscontent);
		if ($edited && $edited !== true) {
			//send validators emails
			if (APPLICATION_ENFORCES_WORKFLOW) {
				$group_email = new CMS_emailsCatalog();
				$languages = CMS_languagesCatalog::getAllLanguages();
				$subjects = array();
				$bodies = array();
				switch ($edited) {
					case RESOURCE_EDITION_MOVE:
						foreach ($languages as $language) {
							$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_MOVE_SUBJECT);
							$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
									."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_MOVE_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFullName()));
						}
					break;
					case RESOURCE_EDITION_SIBLINGSORDER:
						foreach ($languages as $language) {
							$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_SUBJECT);
							$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
									."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SIBLINGSORDER_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFullName()));
						}
					break;
					case RESOURCE_EDITION_BASEDATA:
						foreach ($languages as $language) {
							$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_SUBJECT);
							$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
									."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFullName()." (".$cms_user->getEmail().")"));
						}
					break;
					case RESOURCE_EDITION_CONTENT:
						foreach ($languages as $language) {
							$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_CONTENT_SUBJECT);
							$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
									."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_CONTENT_BODY, array($cms_user->getFullName()." (".$cms_user->getEmail().")", $cms_page->getTitle().' (ID : '.$cms_page->getID().')'));
						}
					break;
					case RESOURCE_EDITION_LOCATION:
						switch ($action) {
							case 'delete':
								foreach ($languages as $language) {
									$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT);
									$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
											."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFullName()));
								}
							break;
							case 'archive':
								foreach ($languages as $language) {
									$subjects[$language->getCode()] = $language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_SUBJECT);
									$bodies[$language->getCode()] = $language->getMessage(MESSAGE_EMAIL_VALIDATION_AWAITS)
											."\n".$language->getMessage(MESSAGE_PAGE_ACTION_EMAIL_ARCHIVE_BODY, array($cms_page->getTitle().' (ID : '.$cms_page->getID().')', $cms_user->getFullName()));
								}
							break;
						}
					break;
				}
				$potentialValidators = CMS_profile_usersCatalog::getValidators(MOD_STANDARD_CODENAME);
				
				$validators = array();
				foreach ($potentialValidators as $aPotentialValidator) {
					if ($aPotentialValidator->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
						$validators[]=$aPotentialValidator;
					}
				}
				$group_email->setUserMessages($validators, $bodies, $subjects);
				$group_email->sendMessages();
			} else {
				$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, $edited, $cms_page);
				$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
				$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
			}
		}
	}
	//log event
	if ($logAction) {
		$log = new CMS_log();
		$log->logResourceAction($logAction, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	}
}
$view->show();
?>