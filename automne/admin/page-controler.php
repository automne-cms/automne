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
// $Id: page-controler.php,v 1.3 2009/02/03 14:24:43 sebastien Exp $

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

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_XML);

$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID());
$field = sensitiveIO::request('field', '', '');
$action = sensitiveIO::request('action', '', '');
$value = sensitiveIO::request('value', '', '');

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
$edited = false;
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
					$edited = true;
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
	case 'unlock':
		if ($cms_page->getLock()) {
			$cms_page->unlock();
			$cms_page->writeToPersistence();
		}
	break;
	case "cancel_draft":
		if ($cms_page->isDraft()) {
			//delete draft datas
			$tpl = $cms_page->getTemplate();
			CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
			CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
			
			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
			$edited = RESOURCE_EDITION_CONTENT;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
	case 'validate_draft':
	case 'submit_for_validation':
		//augment the execution time, because things here can be quite lengthy
		@set_time_limit(9000);
		//ignore user abort to avoid interuption of process
		@ignore_user_abort(true);
		$tpl = $cms_page->getTemplate();
		//put draft datas into edited
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_EDITED, true);
		//change page editions (add CONTENT), move data from _edition to _edited and unlock the page
		$cms_page->addEdition(RESOURCE_EDITION_CONTENT, $cms_user);
		$cms_page->writeToPersistence();
		//delete draft datas
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_EDITION, RESOURCE_DATA_LOCATION_DEVNULL, false);
		$edited = RESOURCE_EDITION_CONTENT;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		//if we only want to submit to validation, break here
		if ($action == 'submit_for_validation') {
			//reload current tab
			$jscontent = 'Automne.tabPanels.getActiveTab().reload();';
			$view->addJavascript($jscontent);
			break;
		}
		//log draft submission
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
		//then validate this page content
		$validation = new CMS_resourceValidation(MOD_STANDARD_CODENAME, $edited, $cms_page);
		$mod = CMS_modulesCatalog::getByCodename(MOD_STANDARD_CODENAME);
		$mod->processValidation($validation, VALIDATION_OPTION_ACCEPT);
		//log this validation
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	break;
	case 'cancel_editions':
		// Copy clientspaces and data from public to edited tables
		$tpl = $cms_page->getTemplate();
		CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
		CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
		
		$cms_page->cancelAllEditions();
		$cms_page->writeToPersistence();
		
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
		
		$edited = RESOURCE_EDITION_CONTENT;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
	case "delete":
		//change the page proposed location and send emails to all the validators
		if ($cms_page->setProposedLocation(RESOURCE_LOCATION_DELETED, $cms_user)) {
			$cms_page->writeToPersistence();
			$edited = RESOURCE_EDITION_LOCATION;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	break;
	case "archive":
		//change the page proposed location and send emails to all the validators
		if ($cms_page->setProposedLocation(RESOURCE_LOCATION_ARCHIVED, $cms_user)) {
			$cms_page->writeToPersistence();
			$edited = RESOURCE_EDITION_LOCATION;
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
    break;
	case "unarchive":
		$cms_page->removeProposedLocation();
		$cms_page->writeToPersistence();
		
		$edited = RESOURCE_EDITION_LOCATION;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
	break;
	case "undelete":
		$cms_page->removeProposedLocation();
		$cms_page->writeToPersistence();
		
		$edited = RESOURCE_EDITION_LOCATION;
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		
		$log = new CMS_log();
		$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNDELETE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
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
						//must reload page
						$cms_page = CMS_tree::getPageByID($cms_page->getID());
					} else {
						$cms_message = 'Erreur lors du déplacement de la page...';
						$cms_page->raiseError('Error during move of page '.$cms_page->getID().'.');
					}
				}
			} else {
				$cms_message = 'Erreur lors du déplacement de la page... Vous n\'avez pas les droits d\'édition sur cette page.';
				$cms_page->raiseError('Error during move of page '.$cms_page->getID().'. User does not have edition rights on current page.');
			}
		}
	break;
	case 'update':
		switch ($field) {
			case 'template': //template change
				if (sensitiveIO::isPositiveInteger($value)) {
					$tpl_original = $cms_page->getTemplate();
					//hack if page has no valid template attached
					if (!is_a($tpl_original, "CMS_pageTemplate")) {
						$tpl_original = new CMS_pageTemplate();
					}
					$tpl = new CMS_pageTemplate($value);
					
					$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $tpl_original->getID());
					$cms_page->setTemplate($tpl_copy->getID());
					//destroy old template only if it's a copy
					if ($tpl_original->isPrivate()) {
						$tpl_original->destroy();
					}
					//save the page data
					if (!$cms_page->writeToPersistence()) {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update template, value : '.$value);
					} else {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					}
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
					$cms_page->raiseError('Error during set template for page '.$cms_page->getID().'. Value set : '.$value);
				}
			break;
			case 'redirection': //redirection link
				$redirection = new CMS_href($value);
				if ($redirection->getLinkType() != RESOURCE_LINK_TYPE_INTERNAL || $redirection->getInternalLink() != $cms_page->getID()) {
					$cms_page->setRedirectLink($redirection,$cms_user);
					if ($cms_page->writeToPersistence()) {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update redirection, value : '.$value);
					}
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
					$cms_page->raiseError('Error during set redirection for page '.$cms_page->getID().'. Value set : '.$value);
				}
			break;
			case 'pubdatestart':
				$dt_beg = new CMS_date();
				$dt_beg->setDebug(false);
				$dt_beg->setFormat($cms_language->getDateFormat());
				if (!$dt_beg->setLocalizedDate($value, false)) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
					$cms_page->raiseError('Error during set pubdatestart : date format not match : '.$value);
				} elseif (!$cms_page->getPublicationDateEnd()->isNull() && CMS_date::compare($dt_beg, $cms_page->getPublicationDateEnd(), '>')) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_DATES);
					$cms_page->raiseError('Error during set pubdatestart : date start is higher than date end : '.$value);
				} else {
					$cms_page->setPublicationDates($dt_beg, $cms_page->getPublicationDateEnd());
					if ($cms_page->writeToPersistence()) {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pubdatestart, value : '.$value);
					}
				}
			break;
			case 'pubdateend':
				$dt_end = new CMS_date();
				$dt_end->setDebug(false);
				$dt_end->setFormat($cms_language->getDateFormat());
				if (!$dt_end->setLocalizedDate($value, true)) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
					$cms_page->raiseError('Error during set pubdateend : date format not match : '.$value);
				} elseif (!$dt_end->isNull() && CMS_date::compare($cms_page->getPublicationDateStart(), $dt_end, '>')) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_DATES);
					$cms_page->raiseError('Error during set pubdateend : date start is higher than date end : '.$value);
				} else {
					$cms_page->setPublicationDates($cms_page->getPublicationDateStart(), $dt_end);
					if ($cms_page->writeToPersistence()) {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update pubdateend, value : '.$value);
					}
				}
			break;
			case 'reminderdate':
				$dt_remind = new CMS_date();
				$dt_remind->setDebug(false);
				$dt_remind->setFormat($cms_language->getDateFormat());
				if (!$dt_remind->setLocalizedDate($value, true)) {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
					$cms_page->raiseError('Error during set reminderdate for page '.$cms_page->getID().'. Value set : '.$value);
				} else {
					$cms_page->setReminderOn($dt_remind, $cms_user);
					if ($cms_page->writeToPersistence()) {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					} else {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update reminderdate, value : '.$value);
					}
				}
			break;
			//string without double quotes and tags (metas)
			case 'remindertext':
				$method = isset($method) ? $method : 'setReminderOnMessage';
			case 'keywordstext':
				$method = isset($method) ? $method : 'setKeywords';
			case 'categorytext':
				$method = isset($method) ? $method : 'setCategory';
			case 'authortext':
				$method = isset($method) ? $method : 'setAuthor';
			case 'replytotext':
				$method = isset($method) ? $method : 'setReplyto';
			case 'copyrighttext':
				$method = isset($method) ? $method : 'setCopyright';
			case 'descriptiontext':
				$method = isset($method) ? $method : 'setDescription';
			case 'robotstext':
				$method = isset($method) ? $method : 'setRobots';
				$value = strip_tags(str_replace('"','',$value));
			//trimmed string
			case 'metatext':
				$method = isset($method) ? $method : 'setMeta';
			case 'language':
				$method = isset($method) ? $method : 'setLanguage';
			case 'title':
				$method = isset($method) ? $method : 'setTitle';
			case 'linkTitle':
				$method = isset($method) ? $method : 'setLinkTitle';
				$value = trim($value);
			//Integer
			case 'reminderdelay':
				$method = isset($method) ? $method : 'setReminderPeriodicity';
				if (!$value) $value = 0;
			//Boolean
			case 'pragmatext':
				$method = isset($method) ? $method : 'setPragma';
			case 'updateURL':
				$method = isset($method) ? $method : 'setRefreshUrl';
				$value = ($value == 'true') ? true : (($value == 'false') ? false : $value);
				if (method_exists($cms_page , $method)) {
					if (!$cms_page->$method($value, $cms_user)) {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
						$cms_page->raiseError('Error during set '.$field.' for page '.$cms_page->getID().'. Value set : '.$value);
					} elseif (!$cms_page->writeToPersistence()) {
						$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_WRITING);
						$cms_page->raiseError('Error during writing of page '.$cms_page->getID().'. Action : update '.$field.', value : '.$value);
					} else {
						$edited = RESOURCE_EDITION_BASEDATA;
						$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
					}
				} else {
					$cms_message = $cms_language->getMessage(MESSAGE_FORM_ERROR_CONTENT);
					$cms_page->raiseError('Error during set '.$field.' for page '.$cms_page->getID().'. Unknown method : '.$method.'. Value set : '.$value);
				}
			break;
			default:
				CMS_grandFather::raiseError('Unknown field '.$field.' to update for page '.$currentPage.' with value : '.$value);
				$view->show();
			break;
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
		
		if ($action == 'update'
			|| $action == 'submit_for_validation'
			|| $action == 'delete'
			|| $action == 'archive' ) {
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
			//log event
			$log = new CMS_log();
			switch ($edited) {
				case RESOURCE_EDITION_MOVE:
					$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_MOVE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
				break;
				case RESOURCE_EDITION_SIBLINGSORDER:
					$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
				break;
				case RESOURCE_EDITION_BASEDATA:
					$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
				break;
				case RESOURCE_EDITION_CONTENT:
					$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
				break;
				case RESOURCE_EDITION_LOCATION:
					switch ($action) {
						case 'delete':
							$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_DELETE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
						break;
						case 'archive':
							$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_ARCHIVE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
						break;
					}
				break;
			}
		}
	}
}
$view->show();
?>