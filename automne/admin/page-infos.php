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
//
// $Id: page-infos.php,v 1.21 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : Load page infos
  * Used accross an Ajax request to get some infos for current page
  * Then update panels accordingly
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//define used messages (standard)
$cms_language->startPrefetch();
define("MESSAGE_PAGE_TREE_TIP_TITLE",1031);
define("MESSAGE_PAGE_TREE_TIP_DESC",304);
define("MESSAGE_PAGE_EDIT_CONTENT",330);
define("MESSAGE_PAGE_EDIT_CONTENT_TIP_TITLE",89);
define("MESSAGE_PAGE_EDIT_CONTENT_TIP_DESC",309);
define("MESSAGE_PAGE_EDIT_CONTENT_TIP_DISABLED_DESC",310);
define("MESSAGE_PAGE_EDIT_PROPERTIES", 1105);
define("MESSAGE_PAGE_EDIT_PROPERTIES_TIP_TITLE",172);
define("MESSAGE_PAGE_EDIT_PROPERTIES_TIP_DESC",316);
define("MESSAGE_PAGE_PAGE",1328);
define("MESSAGE_PAGE_PUBLIC_TIP_TITLE",132);
define("MESSAGE_PAGE_PUBLIC_TIP_DISABLED_DESC",317);
define("MESSAGE_PAGE_PUBLIC_TIP_LINKTITLE",133);
define("MESSAGE_PAGE_PUBLIC_TIP_ID",863);
define("MESSAGE_PAGE_PUBLIC_TIP_PUBLICATION",258);
define("MESSAGE_PAGE_PUBLIC_TIP_TEMPLATE",72);
define("MESSAGE_PAGE_PUBLIC_TIP_STATUS",160);
define("MESSAGE_PAGE_PUBLIC_TIP_LASTCHANGES",311);
define("MESSAGE_PAGE_PUBLIC_TIP_LASTMODIFICATION",312);
define("MESSAGE_PAGE_PUBLIC_TIP_LASTVALIDATION",313);
define("MESSAGE_PAGE_PREVIZ",811);
define("MESSAGE_PAGE_PREVIZ_TIP_TITLE",79);
define("MESSAGE_PAGE_PREVIZ_TIP_DESC",305);
define("MESSAGE_PAGE_PREVIZ_TIP_DISABLED_DESC",306);
define("MESSAGE_PAGE_DRAFT_PREVIZ",1426);
define("MESSAGE_PAGE_DRAFT_PREVIZ_TIP_DESC",307);
define("MESSAGE_PAGE_DRAFT_PREVIZ_TIP_DISABLED_DESC",308);
define("MESSAGE_PAGE_SEARCH_TIP_TITLE",1091);
define("MESSAGE_PAGE_SEARCH_TIP_DESC",326);
define("MESSAGE_PAGE_ADD",90);
define("MESSAGE_PAGE_ADD_TIP_TITLE",1085);
define("MESSAGE_PAGE_ADD_TIP_DESC",327);
define("MESSAGE_PAGE_ACTION",162);
define("MESSAGE_PAGE_ACTION_TIP_TITLE",328);
define("MESSAGE_PAGE_ACTION_TIP_DESC",329);
define("MESSAGE_PAGE_LOCKEDBY",321);
define("MESSAGE_PAGE_UNLOCK_LOCKED_PAGE",341);
define("MESSAGE_PAGE_COPY_INFO", 450);
define("MESSAGE_PAGE_COPY", 1046);
define("MESSAGE_PAGE_UNLOCK_CONFIRM", 451);
define("MESSAGE_PAGE_UNDO_DELETION_INFO", 452);
define("MESSAGE_PAGE_UNDO_DELETION", 453);
define("MESSAGE_PAGE_UNDO_ARCHIVING_INFO", 454);
define("MESSAGE_PAGE_UNDO_ARCHIVING", 455);
define("MESSAGE_PAGE_MOVE_PAGE_INFO", 456);
define("MESSAGE_PAGE_MOVE_PAGE", 92);
define("MESSAGE_PAGE_ARCHIVING_PAGE_INFO", 457);
define("MESSAGE_PAGE_ARCHIVING_PAGE", 83);
define("MESSAGE_PAGE_ARCHIVING_PAGE_CONFIRM", 458);
define("MESSAGE_PAGE_DELETING_PAGE_INFO", 459);
define("MESSAGE_PAGE_DELETING_PAGE", 84);
define("MESSAGE_PAGE_DELETING_PAGE_CONFIRM", 460);
define("MESSAGE_PAGE_UNDO_EDITING_INFO", 461);
define("MESSAGE_PAGE_UNDO_EDITING", 462);
define("MESSAGE_PAGE_UNDO_EDITING_CONFIRM", 463);
define("MESSAGE_PAGE_DELETE_DRAFT_INFO", 464);
define("MESSAGE_PAGE_DELETE_DRAFT", 465);
define("MESSAGE_PAGE_DELETE_DRAFT_CONFIRM", 466);
define("MESSAGE_PAGE_DRAFT_TO_VALIDATION_INFO", 467);
define("MESSAGE_PAGE_DRAFT_TO_VALIDATION", 468);
define("MESSAGE_PAGE_INCORRECT_DOMAIN", 649);
define("MESSAGE_PAGE_INCORRECT_WEBSITE_CONFIG", 650);
define("MESSAGE_PAGE_INCORRECT_WEBSITE_CONFIG_ADMIN", 651);
define("MESSAGE_PAGE_QUIT_AUTOMNE", 652);
define("MESSAGE_PAGE_FOLLOW_EXTERNAL_LINK", 653);
define("MESSAGE_PAGE_ERROR", 654);
define("MESSAGE_PAGE_PAGE_NOT_VIEWVABLE", 655);
define("MESSAGE_PAGE_SEARCH", 656);
define("MESSAGE_PAGE_ADD_BOOKMARK", 657);
define("MESSAGE_PAGE_ADD_BOOKMARK_DESC", 658);
define("MESSAGE_PAGE_REMOVE_BOOKMARK_DESC", 659);
define("MESSAGE_PAGE_UNLOCK_PAGE", 660);
define("MESSAGE_PAGE_MOVE_PAGE_USING_ICONS", 661);
define("MESSAGE_PAGE_MOVING_PAGE", 662);
define("MESSAGE_PAGE_VALIDATION_MODIFICATIONS", 663);
define("MESSAGE_PAGE_VALIDATION", 664);
define("MESSAGE_PAGE_REGEN_DESC", 665);
define("MESSAGE_PAGE_REGENERATE", 666); //Evil message
define("MESSAGE_PAGE_EDIT_NOT_VALIDATED", 667);
define("MESSAGE_PAGE_NO_PAGES_RIGHTS", 668);
define("MESSAGE_PAGE_NO_PAGE_RIGHT", 669);
define("MESSAGE_PAGE_LOCKED_ON_AT", 1591);
$cms_language->endPrefetch();

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$pageUrl = sensitiveIO::request('pageUrl');
$pageId = sensitiveIO::request('pageId', 'sensitiveIO::isPositiveInteger');
$from = sensitiveIO::request('from', 'sensitiveIO::isPositiveInteger');
$fromtab = sensitiveIO::request('fromTab', array('edit', 'edited', 'public'));
$tab = sensitiveIO::request('tab', array('edit', 'edited', 'public'));
$followRedirect = sensitiveIO::request('followRedirect') ? true : false;
$regenerate = sensitiveIO::request('regenerate') ? true : false;
$reload = sensitiveIO::request('reload') ? true : false;
$noreload = sensitiveIO::request('noreload') ? true : false;
$unlock = sensitiveIO::request('unlock') ? true : false;

//Default tab to open
if ($tab && !$fromtab) {
	$fromtab = $tab;
} elseif(!$fromtab) {
	$fromtab = 'public';
}

if (!$pageUrl && !$pageId && !$from) {
	CMS_grandFather::raiseError('Missing page parameter ...');
	$view->show();
} elseif(!$pageUrl && !$pageId) {
	$pageId = $from;
}

$jscontent = '';
$isAutomne = $querystring = false;
//current http host
$httpHost = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST'];
if ($pageUrl && !$pageId) {
	//get page from requested url
	if ($cms_page = CMS_tree::analyseURL($pageUrl)) {
		$pageId = $cms_page->getID();
		$isAutomne = true;
	}
} elseif ($pageId) {
	//try to instanciate the requested page
	$cms_page = CMS_tree::getPageByID($pageId);
	$isAutomne = true;
}
if (!isset($cms_page) || !$cms_page || !is_object($cms_page) || $cms_page->hasError() || ($cms_page->getID() != APPLICATION_ROOT_PAGE_ID && !CMS_tree::hasAncestor($cms_page->getID()))) {
	if ($pageUrl && !$isAutomne) {
		if ($pageUrl == '/' && $httpHost != parse_url(CMS_websitesCatalog::getMainURL(), PHP_URL_HOST)) {
			//Website domain is not properly set
			if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$jscontent = "
					Automne.message.popup({
						title: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_DOMAIN)."', 
						msg: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_WEBSITE_CONFIG, array($httpHost, parse_url(CMS_websitesCatalog::getMainURL(), PHP_URL_HOST)))."',
						buttons:	Ext.MessageBox.OK,
						icon: 		Ext.MessageBox.WARNING,
						fn: 		function (button) {
										var window = new Automne.frameWindow({
											id:				'websitesWindow',
											frameURL:		'/automne/admin-v3/websites.php',
											allowFrameNav:	true,
											width:			750,
											height:			580
										});
										window.show();
									}
					});
				";
			} else {
				$jscontent = "
					Automne.message.popup({
						title: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_DOMAIN)."', 
						msg: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_WEBSITE_CONFIG_ADMIN, array($httpHost, parse_url(CMS_websitesCatalog::getMainURL(), PHP_URL_HOST)))."',
						buttons:	Ext.MessageBox.OK,
						icon: 		Ext.MessageBox.ERROR
					});
				";
			}
		} else {
			$jscontent = "
				Automne.message.popup({
					title: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_QUIT_AUTOMNE)."', 
					msg: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_FOLLOW_EXTERNAL_LINK, array($pageUrl))."',
					buttons:	Ext.MessageBox.YESNO,
					icon: 		Ext.MessageBox.QUESTION,
					fn: 		function (button) {
									if (button == 'yes') {
										window.location = '{$pageUrl}';
									}
								}
				});
			";
		}
		$view->addJavascript($jscontent);
		if ($from) {
			$cms_page = CMS_tree::getPageByID($from);
			$pageId = $cms_page->getID();
		}
	} else {
		$jscontent = "
			//disable all tabs except search and tree
			Automne.tabPanels.items.each(function(panel) {
				if (panel.id != 'search' && panel.id != 'tree') {
					panel.disable();
				} else {
					panel.enable();
				}
			});
			Automne.message.popup({
				title: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_ERROR)."', 
				msg: 		'".$cms_language->getJSMessage(MESSAGE_PAGE_PAGE_NOT_VIEWVABLE, array($pageId))."',
				buttons:	Ext.MessageBox.OK,
				icon: 		Ext.MessageBox.ERROR
			});
		";
		$view->addJavascript($jscontent);
		CMS_grandFather::raiseError('Error on page : '.$pageId);
		$view->show();
	}
}
if (!isset($cms_page) || !is_object($cms_page)) {
	CMS_grandFather::raiseError('Error, can\'t get a valid page to work with.');
	$view->show();
}
//check if page is useable (public or edited at least)
if(!$cms_page->isUseable() || $followRedirect) {
	if (!$cms_page->isUseable()) {
		//page is deleted, go to root
		$cms_page = CMS_tree::getRoot();
	}
	//redirect to subpage if any redirection exists
	$redirectlink = $cms_page->getRedirectLink(true);
	while ($redirectlink->hasValidHREF() && sensitiveIO::IsPositiveInteger($redirectlink->getInternalLink())) {
		$cms_page = new CMS_page($redirectlink->getInternalLink());
		$redirectlink = $cms_page->getRedirectLink(true);
	}
	$pageId = $cms_page->getID();
}
if (!isset($cms_context) || !is_object($cms_context)) {
	CMS_grandFather::raiseError('Error, user context not found');
	$view->show();
}
pr('View page : '.$cms_page->getID().($reload ? ' (Force reload queried by interface)' : ''));

//set page into user context
$cms_context->setPage($cms_page);

//for the page, create all javascript informations needed
$hasPreviz = $hasPublic = $hasDraft = $isEditable = $hasLock = $hasRedirect = false;

//which panels can be seen by user (according to his rights)
//this array represent the order of each panel (left to right)
$userPanels = array(
	'search' 	=> array('type' => 'searchPanel', 	'visible' => true), //TODOV4 : checker si le user peut voir la recherche
	'tree' 		=> array('type' => 'winPanel', 		'visible' => false),
	'favorite' 	=> array('type' => 'favoritePanel', 'visible' => $cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_VIEW)),
	'action' 	=> array('type' => 'menuPanel', 	'visible' => false),
	'add' 		=> array('type' => 'winPanel', 		'visible' => false),
	'properties'=> array('type' => 'winPanel', 		'visible' => false),
	'edit' 		=> array('type' => 'framePanel', 	'visible' => false),
	'edited' 	=> array('type' => 'framePanel', 	'visible' => false),
	'public' 	=> array('type' => 'framePanel', 	'visible' => true),
	'nopages' 	=> array('type' => 'framePanel', 	'visible' => false),
	'norights' 	=> array('type' => 'framePanel', 	'visible' => false),
);

//check for public page
if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
	if ($cms_page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
		$hasPublic = true;
	}
}

//check for tree access
if ($cms_user->hasViewvablePages()) {
	$userPanels['tree']['visible']= true;
}

//remove lock on pages which user has locked
if ($unlock || ($cms_page->getLock() == $cms_user->getUserId() && $fromtab != 'edit')) {
	$cms_page->unlock();
}
//check for draft
if ($cms_page->isDraft()) {
	$hasDraft = true;
}
//get lock status
$hasLock = $cms_page->getLock();
//if user has edition rights
if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	$userPanels['properties']['visible']= true;
	$userPanels['add']['visible'] 		= true;
	$userPanels['edit']['visible'] 		= true;
	$userPanels['action']['visible'] 	= true;
	$userPanels['edited']['visible'] 	= true;
	//check for previz page (validation pending)
	//pr('location : '.$cms_page->getLocation());
	//pr('editions : '.$cms_page->getStatus()->getEditions());
	//pr('publication : '.$cms_page->getStatus()->getPublication());
	if ((($cms_page->getLocation() == RESOURCE_LOCATION_USERSPACE && $cms_page->getStatus()->getEditions()/* & RESOURCE_EDITION_CONTENT*/)
		&& !($cms_page->getLocation() == RESOURCE_LOCATION_USERSPACE && $cms_page->getStatus()->getEditions() == RESOURCE_EDITION_BASEDATA && $cms_page->getStatus()->getPublication() == RESOURCE_PUBLICATION_VALIDATED))
		|| ($cms_page->getLocation() == RESOURCE_LOCATION_USERSPACE /*&& !$cms_page->getStatus()->getEditions()*/ && $cms_page->getStatus()->getPublication() == RESOURCE_PUBLICATION_VALIDATED)
		) {
		$hasPreviz = true;
	}
	//is page editable (not proposed to deleted or archived location and with editable CS)
	if ($cms_page->getProposedLocation() != RESOURCE_LOCATION_DELETED
		&& $cms_page->getProposedLocation() != RESOURCE_LOCATION_ARCHIVED
		&& (!$hasLock || ($hasLock == $cms_user->getUserId() && $fromtab == 'edit'))) {
		//module specific actions (only for standard module)
		if ($cms_page->hasModule(MOD_STANDARD_CODENAME) && $cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
			$isEditable = true;
		}
	}
} elseif ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
	//allow page copy
	$userPanels['action']['visible'] 	= true;
} else {
	//user can't see the page
	$userPanels['public']['visible'] 	= false;
	$userPanels['favorite']['visible'] 	= false;
}
//pr($userPanels);

//then create JS needed to control each panels
$jscontent = '
//def some vars
var panel;
if (Automne.tabPanels) {
	var tabs = Automne.tabPanels;
	tabs.beginUpdate();
';

//then for each framePanels, found the one which is enabled and go to it
$active = false;
switch ($fromtab) {
	case 'edit':
		if ($isEditable) {
			$active = 'edit';
		} else {
			$active = 'public';
		}
	break;
	case 'edited':
		if ($hasPreviz) { 
			$active = 'edited';
		} else {
			$active = 'public';
		}
	break;
	case 'public':
		if ($hasPublic) { 
			$active = 'public';
		} elseif ($hasPreviz) {
			$active = 'edited';
		} else {
			$active = 'public';
		}
	break;
}

//Check for public page existence.
//when a page is just validated, (first validation), 
//the page file may not exists yet, 
//so to prevent the display of an error, we must force the page generation here
if ($cms_page->getPublication() == RESOURCE_PUBLICATION_PUBLIC && ($regenerate || ($active == 'public' && !file_exists($cms_page->getURL(false, false, PATH_RELATIVETO_FILESYSTEM, true))))) {
	pr($regenerate ? 'Page regeneration queried' : 'Page file missing => auto regeneration');
	$cms_page->regenerate(true);
	//if anything goes wrong during regeneration, we must desactivate the public tab
	if (!file_exists($cms_page->getURL(false, false, PATH_RELATIVETO_FILESYSTEM, true))) {
		$active = 'edited';
		$hasPreviz = true;
		$hasPublic = false;
	}
}

$redirectlink = $cms_page->getRedirectLink(true);
$hasRedirect = $redirectlink->hasValidHREF();

//if no pages rights or no page at all, then activate infos panel
if (!$userPanels['edited']['visible'] && !$userPanels['edit']['visible'] && !$userPanels['public']['visible']) {
	if (!$userPanels['action']['visible'] && !$userPanels['tree']['visible']) {
		$active = 'nopages';
		$userPanels['nopages']['visible'] = true;
	} else {
		$active = 'norights';
		$userPanels['norights']['visible'] = true;
	}
}

$index = 0;
foreach ($userPanels as $panel => $panelStatus) {
	//load panel
	$jscontent .= '
	//Panel '.$panel.'
	panel = tabs.getItem(\''.$panel.'\');
	';
	if ($panelStatus['visible']) {
		//init vars
		$panelContent = $panelTitle = $panelHTML = $panelTip = $panelTipTitle = $panelURL = $panelPicto = '';
		$panelDisabled = 'true';
		$panelEditable = $allowFrameNav = 'false';
		$panelID = $panel;
		switch ($panel) {
			case 'search':
				$panelTitle = '<img src="'.PATH_ADMIN_IMAGES_WR.'/s.gif" width="1" height="16" />';
				$panelPicto = 'atm-pic-big-search';
				$panelDisabled = 'false';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_SEARCH_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_SEARCH_TIP_DESC);
				$panelContent = "
				if (panel) {
					panel.setDisabled(".$panelDisabled.");
				} else {
					//create search panels
					var search = new Ext.Panel({
						id:			'atmSearchPanel',
						x:			18,
						y:			48,
						width:		400,
						height:		36,
						border:		true,
						frame:		true,
						shadow:		true,
						floating:	true,
						hideMode:	'display',
						listeners:	{
							'show':function(panel){
								panel.items.first().focus(true, 100);
							}, scope:this
						},
						items:[{
							xtype:			'trigger',
							emptyText:		'".$cms_language->getJSMessage(MESSAGE_PAGE_SEARCH)."',
							triggerClass:	'x-form-search-trigger',
							width:			385,
							onTriggerClick:	function(){
								this.fireEvent('blur', this);
								Automne.view.search(this.getValue());
							},
							listeners:	{
								'render':function(field){
									field.focus(true, 100);
								},
								'blur':function(field){
									var search = Ext.getCmp('atmSearchPanel');
									if (search.allowBlur) {
										field.getEl().blur();
										search.hide();
										Ext.getCmp('atmSearchTopPanel').hide();
									}
								},
								'focus':function(field){
									Ext.getCmp('atmSearchPanel').allowBlur = true;
								},
								'specialkey':function(field, e) {
									if (Ext.EventObject.getKey() == Ext.EventObject.ENTER) {
										field.fireEvent('blur', field);
										Automne.view.search(field.getValue());
									}
								},
								scope:this
							}
						}]
					});
					var searchTop = new Ext.Panel({
						id:			'atmSearchTopPanel',
						x:			18,
						y:			20,
						width:		41,
						height:		29,
						border:		false,
						shadow:		false,
						floating:	true,
						bodyStyle:	'background:transparent;',
						hideMode:	'display',
						html:		'<img src=\"".PATH_ADMIN_IMAGES_WR."/searchTop.png\" />'
					});
					//set blur event on document to remove search
					Ext.getDoc().on('blur', Automne.view.removeSearch);
					
					panel = new Automne.panel ({
						title:			'".sensitiveIO::sanitizeJSString($panelTitle)."',
						id:				'".$panel."',
						disabled:		".$panelDisabled.",
						listeners:		{
							'beforeactivate' : {
								fn: function(panel, e) {
									try {
										//this test is to avoid IE bug if this method is called without browser event as origin
										if (e.type) {}
									} catch (e){
										return false;
									}
									if (e.type == 'mousedown') {
										var search = Ext.getCmp('atmSearchPanel');
										var searchTop = Ext.getCmp('atmSearchTopPanel');
										if (search && searchTop) {
											if (!search.rendered) {
												search.allowBlur = false;
												search.render(document.body);
												searchTop.render(document.body);
											} else {
												if (search.isVisible()) {
													search.hide();
													searchTop.hide();
												} else {
													search.setPosition(search.x, search.y)
													searchTop.setPosition(searchTop.x, searchTop.y)
													search.allowBlur = false;
													search.show();
													searchTop.show();
												}
											}
										}
									}
									return false;
								},
								scope: this
							}
						}";
						if ($panelPicto) {
							$panelContent .= ',
							iconCls:	\''.$panelPicto.'\'';
						}
					$panelContent .= '
					});
					tabs.insert('.$index.', panel);
				}
				';
			break;
			case 'tree':
				$panelTitle = '<img src="'.PATH_ADMIN_IMAGES_WR.'/s.gif" width="1" height="16" />';
				$panelPicto = 'atm-pic-big-tree';
				$panelDisabled = 'false';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_TREE_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_TREE_TIP_DESC);
				$panelURL = 'tree.php';
			break;
			case 'favorite':
				$panelTitle = '<img src="'.PATH_ADMIN_IMAGES_WR.'/s.gif" width="1" height="16" />';
				$panelPicto = 'atm-pic-big-favorite';
				$panelDisabled = 'false';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_ADD_BOOKMARK);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_ADD_BOOKMARK_DESC);
				if ($cms_user->isFavorite($pageId)) {
					$panelTip .= '<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_REMOVE_BOOKMARK_DESC).'</strong>';
				}
				$panelContent = "
				if (panel) {
					panel.setDisabled(".$panelDisabled.");
				} else {
					panel = new Automne.panel ({
						title:			'".sensitiveIO::sanitizeJSString($panelTitle)."',
						id:				'".$panel."',
						disabled:		".$panelDisabled.",
						listeners:		{
							'beforeactivate' : {
								fn: function(panel, e) {
									if (e && e.type && e.type == 'mousedown') {
										Automne.server.call({
											url:				'users-controler.php',
											params: 			{
												action:			'favorites',
												pageId:			tabs.pageId,
												userId:			".$cms_user->getUserId().",
												status:			!tabs.isFavorite
											},
											fcnCallback: 		function(response, options, jsonResponse) {
												if (jsonResponse.success == true) {
													tabs.setFavorite(options.params.status);
													//reload favorite panel if exists
													var favorites = Ext.get('atm-favorites-pages');
													if (favorites) {
														favorites.getUpdater().renderer = new Automne.windowRenderer();
														favorites.load({
															url: 		'favorites-sidepanel.php',
															nocache: 	true
														});
													}
												}
											},
											callBackScope:		this
										});
									}
									return false;
								},
								scope: this
							}
						}";
						if ($panelPicto) {
							$panelContent .= ',
							iconCls:	\''.$panelPicto.'\'';
						}
					$panelContent .= '
					});
					tabs.insert('.$index.', panel);
				}
				';
			break;
			case 'properties':
				$panelTitle = $cms_language->getMessage(MESSAGE_PAGE_EDIT_PROPERTIES);
				$panelPicto = 'atm-pic-big-properties';
				$panelDisabled = $hasLock ? 'true' : 'false';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_EDIT_PROPERTIES_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_EDIT_PROPERTIES_TIP_DESC);
				$panelURL = 'page-properties.php';
			break;
			case 'add':
				$panelTitle = $cms_language->getMessage(MESSAGE_PAGE_ADD);
				$panelPicto = 'atm-pic-big-add';
				$panelDisabled = 'false';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_ADD_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_ADD_TIP_DESC);
				$panelURL = 'page-add.php';
			break;
			case 'action':
				/*
				Actions can be :
				- unlock
				- copy
				- move
				- delete / undelete
				- archive / unarchive
				- cancel edition
				- cancel draft 
				- submit draft to validation
				- validate
				- regenerate
				*/
				$panelTitle = $cms_language->getMessage(MESSAGE_PAGE_ACTION);
				$panelPicto = 'atm-pic-big-action';
				$panelDisabled = $cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW) ? 'false' : 'true';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_ACTION_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_ACTION_TIP_DESC);
				if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
					$hasSiblings = CMS_tree::hasSiblings($cms_page);
					
					$pageCopy = "
					menu.addItem(new Ext.menu.Item({
						text: '<span ext:qtip=\"".$cms_language->getJsMessage(MESSAGE_PAGE_COPY_INFO)."\">".$cms_language->getJsMessage(MESSAGE_PAGE_COPY)."</span>',
						iconCls: 'atm-pic-copy',
						handler: function() {
							//create window element
							var win = new Automne.Window({
								id:				'pageCopyWindow',
								currentPage:	".$cms_page->getID().",
								autoLoad:		{
									url:		'page-copy.php',
									params:		{
										winId:		'pageCopyWindow',
										currentPage:".$cms_page->getID()."
									},
									nocache:	true,
									scope:		this
								}
							});
							win.show(this.getEl());
						}
					}));";
				} else {
					$pageCopy = '';
				}
				//draft
				if ($fromtab == 'edit' && $cms_user->getUserID() == $hasLock) {
					//cancel draft and submit draft to validation
					$pageDraft = "
					menu.addSeparator();
					menu.addItem(new Ext.menu.Item({
						text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_DELETE_DRAFT_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_DELETE_DRAFT)."</span>',
						iconCls: 'atm-pic-draft-deletion',
						handler: function(){
							Automne.message.popup({
								msg: 				'".$cms_language->getJSMessage(MESSAGE_PAGE_DELETE_DRAFT_CONFIRM)."',
								buttons: 			Ext.MessageBox.OKCANCEL,
								animEl: 			this.getEl(),
								closable: 			false,
								icon: 				Ext.MessageBox.WARNING,
								fn: 				function (button) {
									if (button == 'ok') {
										//send to public or edited tab
										var pubTab = tabs.getItem('public');
										if (!pubTab.disabled) {
											tabs.setActiveTab('public');
										} else {
											tabs.setActiveTab('edited');
										}
										Automne.server.call({
											url:				'page-controler.php',
											params: 			{
												currentPage:		'".$cms_page->getID()."',
												action:				'cancel_draft'
											},
											fcnCallback: 		function() {
												//then reload page infos
												tabs.getPageInfos({
													pageId:		'".$cms_page->getID()."',
													noreload:	true
												});
											},
											callBackScope:		this
										});
									}
								}
							});
						}
					}));
					menu.addItem(new Ext.menu.Item({
						text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_DRAFT_TO_VALIDATION_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_DRAFT_TO_VALIDATION)."</span>',
						iconCls: 'atm-pic-draft-validation',
						handler: function () {
							//submit page to validation
							Automne.server.call({
								url:				'page-controler.php',
								params: 			{
									currentPage:		'".$cms_page->getID()."',
									action:				'submit_for_validation'
								},
								fcnCallback: 		function() {
									//then reload page infos
									tabs.getPageInfos({
										pageId:		'".$cms_page->getID()."',
										noreload:	true
									});
								},
								callBackScope:		this
							});
						}
					}));";
				} else {
					$pageDraft = '';
				}
				
				if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
					if ($hasLock) {
						//unlock
						if ($fromtab != 'edit' && ($cms_user->getUserID() == $hasLock || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
							$lockUser = CMS_profile_usersCatalog::getById($hasLock);
							$panelContent .= "
							menu.addItem(new Ext.menu.Item({
								text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_UNLOCK_LOCKED_PAGE, array(io::htmlspecialchars($lockUser->getFullName())))."\">".$cms_language->getJSMessage(MESSAGE_PAGE_UNLOCK_PAGE)."</span>',
								iconCls: 'atm-pic-unlock',
								handler: function(){
									Automne.message.popup({
										msg: 				'".$cms_language->getJSMessage(MESSAGE_PAGE_UNLOCK_CONFIRM, array(io::htmlspecialchars($lockUser->getFullName())))."',
										buttons: 			Ext.MessageBox.OKCANCEL,
										animEl: 			this.getEl(),
										closable: 			false,
										icon: 				Ext.MessageBox.WARNING,
										fn: 				function (button) {
											if (button == 'ok') {
												Automne.server.call({
													url:				'resource-controler.php',
													params: 			{
														resource:		'".$cms_page->getID()."',
														module:			'standard',
														action:			'unlock'
													},
													callBackScope:		this
												});
											}
										}
									});
								}
							}));";
						} elseif ($fromtab == 'edit' && $cms_user->getUserID() == $hasLock) {
							$panelContent .= $pageDraft;
						}
					} else {
						if ($cms_page->getProposedLocation() == RESOURCE_LOCATION_DELETED) {
							//undelete
							$panelContent .= "
							menu.addItem(new Ext.menu.Item({
								text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_DELETION_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_DELETION)."</span>',
								iconCls: 'atm-pic-undelete',
								handler: function () {
									Automne.server.call({
										url:				'page-controler.php',
										params: 			{
											currentPage:		'".$cms_page->getID()."',
											action:				'undelete'
										}
									});
								}
							}));";
						} elseif ($cms_page->getProposedLocation() == RESOURCE_LOCATION_ARCHIVED) {	
							//unarchive
							$panelContent .= "
							menu.addItem(new Ext.menu.Item({
								text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_ARCHIVING_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_ARCHIVING)."</span>',
								iconCls: 'atm-pic-unarchive',
								handler: function () {
									Automne.server.call({
										url:				'page-controler.php',
										params: 			{
											currentPage:		'".$cms_page->getID()."',
											action:				'unarchive'
										}
									});
								}
							}));";
						} else {
							//move page
							$father = CMS_tree::getAncestor($cms_page, 1);
							$draggable = is_object($father) && $cms_user->hasPageClearance($father->getID(), CLEARANCE_PAGE_EDIT)
			 							&& (!$hasSiblings || ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) && $cms_page->getID() != APPLICATION_ROOT_PAGE_ID));
							
							if ($draggable) {
								$panelContent .= "
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_MOVE_PAGE_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_MOVE_PAGE)."</span>',
									iconCls: 'atm-pic-move',
									handler: function() {
										//create window element
										var win = new Automne.Window({
											id:				'pageMoveWindow',
											currentPage:	".$cms_page->getID().",
											autoLoad:		{
												url:		'tree.php',
												params:		{
													winId:		'pageMoveWindow',
													currentPage:".$cms_page->getID().",
													enableDD:	true,
													heading:	'".$cms_language->getJSMessage(MESSAGE_PAGE_MOVE_PAGE_USING_ICONS)."',
													title:		'".$cms_language->getJSMessage(MESSAGE_PAGE_MOVING_PAGE)."'
												},
												nocache:	true,
												scope:		this
											}
										});
										win.show(this.getEl());
									}
								}));";
							}
							//page copy
							$panelContent .= $pageCopy;
							//archiving
							if (!$hasSiblings) {
								$panelContent .= "
								menu.addSeparator();
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_ARCHIVING_PAGE_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_ARCHIVING_PAGE)."</span>',
									iconCls: 'atm-pic-archiving',
									handler: function(){
										Automne.message.popup({
											msg: 				'".$cms_language->getJSMessage(MESSAGE_PAGE_ARCHIVING_PAGE_CONFIRM)."',
											buttons: 			Ext.MessageBox.OKCANCEL,
											animEl: 			this.getEl(),
											closable: 			false,
											icon: 				Ext.MessageBox.QUESTION,
											fn: 				function (button) {
												if (button == 'ok') {
													Automne.server.call({
														url:				'page-controler.php',
														params: 			{
															currentPage:		'".$cms_page->getID()."',
															action:				'archive'
														}
													});
												}
											}
										});
									}
								}));";
							}
							//deletion
							if (!$hasSiblings && !CMS_websitesCatalog::isWebsiteRoot($cms_page->getID())) {
								$panelContent .= "
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_DELETING_PAGE_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_DELETING_PAGE)."</span>',
									iconCls: 'atm-pic-deletion',
									handler: function(){
										Automne.message.popup({
											msg: 				'".$cms_language->getJSMessage(MESSAGE_PAGE_DELETING_PAGE_CONFIRM)."',
											buttons: 			Ext.MessageBox.OKCANCEL,
											animEl: 			this.getEl(),
											closable: 			false,
											icon: 				Ext.MessageBox.QUESTION,
											fn: 				function (button) {
												if (button == 'ok') {
													Automne.server.call({
														url:				'page-controler.php',
														params: 			{
															currentPage:		'".$cms_page->getID()."',
															action:				'delete'
														}
													});
												}
											}
										});
									}
								}));";
							}
							//page editions cancelling
							$editions = $cms_page->getStatus()->getEditions();
							if ($cms_page->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED
								 && ($editions & RESOURCE_EDITION_CONTENT)) {
								$panelContent .= "
								menu.addSeparator();
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_EDITING_INFO)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_EDITING)."</span>',
									iconCls: 'atm-pic-editions-cancelling',
									handler: function(){
										Automne.message.popup({
											msg: 				'".$cms_language->getJSMessage(MESSAGE_PAGE_UNDO_EDITING_CONFIRM)."',
											buttons: 			Ext.MessageBox.OKCANCEL,
											animEl: 			this.getEl(),
											closable: 			false,
											icon: 				Ext.MessageBox.WARNING,
											fn: 				function (button) {
												if (button == 'ok') {
													tabs.setActiveTab('public');
													Automne.server.call({
														url:				'page-controler.php',
														params: 			{
															currentPage:		'".$cms_page->getID()."',
															action:				'cancel_editions'
														},
														fcnCallback: 		function() {
															//then reload page infos
															tabs.getPageInfos({
																pageId:		'".$cms_page->getID()."',
																noreload:	true
															});
														},
														callBackScope:		this
													});
												}
											}
										});
									}
								}));";
							}
							if (($editions & RESOURCE_EDITION_CONTENT) && $cms_user->hasValidationClearance(MOD_STANDARD_CODENAME)) {
								//validate
								$panelContent .= "
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION_MODIFICATIONS)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION)."</span>',
									iconCls: 'atm-pic-validate',
									handler: function () {
										Automne.server.call('validations-controler.php', function(response, options, jsonResponse){
											if (!jsonResponse.success) {
												//get validation message
												if (response.responseXML && response.responseXML.getElementsByTagName('message').length) {
													var message = response.responseXML.getElementsByTagName('message').item(0).firstChild.nodeValue;
												}
												Automne.message.popup({
													msg: 				message,
													buttons: 			Ext.MessageBox.OK,
													closable: 			false,
													icon: 				Ext.MessageBox.WARNING
												});
											}
										}, {
											action:				'validateById',
											resource:			'".$cms_page->getID()."',
											module:				'".MOD_STANDARD_CODENAME."',
											evalMessage:		false
										});
									}
								}));";
							}
							if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) && $cms_page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
								//regenerate
								$panelContent .= "
								menu.addSeparator();
								menu.addItem(new Ext.menu.Item({
									text: '<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_REGEN_DESC)."\">".$cms_language->getJSMessage(MESSAGE_PAGE_REGENERATE)."</span>',
									iconCls: 'atm-pic-scripts',
									handler: function () {
										Automne.server.call({
											url:				'page-controler.php',
											params: 			{
												currentPage:		'".$cms_page->getID()."',
												action:				'regenerate'
											}
										});
									}
								}));";
							}
							//separator
							$panelContent .= "'-'".$pageDraft;
						}
					}
				} elseif ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
					//if user has page edition rights somewhere
					if ($cms_user->hasEditablePages()) {
						//page copy
						$panelContent .= $pageCopy;
					}
				}
				if ($panelContent) {
					//check if panel exists. If not, create it, otherwise change properties
					$panelContent = "
					//check if menu exists, else create it
					if (!Ext.menu.MenuMgr.get('".$panel."Menu')) {
						var menu = new Automne.Menu({
							id: '".$panel."Menu'
						});
					} else {
						var menu = Ext.menu.MenuMgr.get('".$panel."Menu');
						menu.removeAll();
					}".$panelContent."
					if (panel) {
						panel.setDisabled(".$panelDisabled.");
					} else {
						panel = new Automne.panel ({
							title:			'".sensitiveIO::sanitizeJSString($panelTitle)."',
							id:				'".$panel."',
							disabled:		".$panelDisabled.",
							listeners:		{
								'beforeactivate' : {
									fn: function(panel, e) {
										if (e.type == 'mousedown') {
											if (menu.isVisible()) {
												menu.hide();
											} else {
												panel.loadTabEl();
												menu.show(panel.tabEl);
											}
										}
										return false;
									},
									scope: this
								}
							}";
							if ($panelPicto) {
								$panelContent .= ',
								iconCls:	\''.$panelPicto.'\'';
							}
						$panelContent .= '
						});
						tabs.insert('.$index.', panel);
					}
					';
				}
			break;
			case 'edit':
				$panelTitle = $cms_language->getMessage(MESSAGE_PAGE_EDIT_CONTENT);
				$panelDisabled = ($isEditable && !$hasRedirect) ? 'false' : 'true';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_EDIT_CONTENT_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_EDIT_CONTENT_TIP_DESC);
				$panelPicto = 'atm-pic-big-edit';
				if($hasDraft) {
					$panelTip .= '<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_EDIT_NOT_VALIDATED).'</strong>';
				}
				if ($hasLock && sensitiveIO::isPositiveInteger($hasLock)) {
					$lockUser = CMS_profile_usersCatalog::getById($hasLock);
					$lockDate = $cms_page->getLockDate();
					$panelTip .= '<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_LOCKEDBY).' </strong>'.$lockUser->getFullName().' '.$cms_language->getMessage(MESSAGE_PAGE_LOCKED_ON_AT, array($lockDate->getLocalizedDate($cms_language->getDateFormat()), $lockDate->getLocalizedDate('H:i:s')));
				} elseif (!$isEditable) {
					$panelTip .= '<br /><br />'.$cms_language->getMessage(MESSAGE_PAGE_EDIT_CONTENT_TIP_DISABLED_DESC);
				}
				$panelURL = PATH_ADMIN_WR.'/page-content.php?page='.$cms_page->getID().($querystring ? '&'.$querystring : '');
				$panelEditable = 'true';
			break;
			case 'edited':
				$panelTitle = $cms_language->getMessage(MESSAGE_PAGE_PREVIZ);
				$panelPicto = 'atm-pic-big-edited';
				$panelDisabled = ($hasPreviz && !$hasRedirect) ? 'false' : 'true';
				$panelTipTitle = $cms_language->getMessage(MESSAGE_PAGE_PREVIZ_TIP_TITLE);
				$panelTip = $cms_language->getMessage(MESSAGE_PAGE_PREVIZ_TIP_DESC);
				if (!$hasPreviz) {
					$panelTip .= '<br /><br />'.$cms_language->getMessage(MESSAGE_PAGE_PREVIZ_TIP_DISABLED_DESC);
				}
				$panelURL = PATH_ADMIN_WR.'/page-previsualization.php?currentPage='.$cms_page->getID().($querystring ? '&'.$querystring : '');
			break;
			case 'public':
				$icon = $cms_page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID(), true, false);
				$panelTitle = '<span class="atm-tab">'.$icon.'&nbsp;&nbsp;'.sensitiveIO::ellipsis($cms_page->getTitle().' ('.$cms_page->getID().')', 52, '...', true).'</span>';
				$panelDisabled = ($hasPublic) ? 'false' : 'true';
				$pageTemplateLabel = ($cms_page->getTemplate()) ? $cms_page->getTemplate()->getLabel() : '';
				//page panel tip content
				$panelTipTitle = '<div id="tip-header-img">'.$cms_page->getStatus()->getHTML().'</div>
				<div id="tip-header-text">
				<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_TITLE).' : </strong>'.$cms_page->getTitle().'<br />
				<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_LINKTITLE).' : </strong>'.$cms_page->getLinkTitle().'</div>';
				$panelTip = '<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_ID).' : </strong>'.$cms_page->getID().'<br />
				<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_STATUS).' : </strong>'.$cms_page->getStatus()->getStatusLabel($cms_language).'<br />
				<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_TEMPLATE).' : </strong>'.$pageTemplateLabel.'<br />
				<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_PUBLICATION).' : </strong>'.$cms_page->getStatus()->getPublicationRange($cms_language).'<br />';
				$lastupdate = CMS_log_catalog::getByResourceAction(MOD_STANDARD_CODENAME, $cms_page->getID(), CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT, 1);
				$lastvalidation = CMS_log_catalog::getByResourceAction(MOD_STANDARD_CODENAME, $cms_page->getID(), CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION, 1);
				if (($lastupdate && is_object($lastupdate[0])) || ($lastvalidation && is_object($lastvalidation[0]))) {
					$panelTip .= '<strong>'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_LASTCHANGES).' :</strong><br />';
					$format = $cms_language->getDateFormat().' H:i:s';
				}
				if ($lastupdate && is_object($lastupdate[0])) {
					$user = $lastupdate[0]->getUser();
					$date = $lastupdate[0]->getDateTime();
					$panelTip .= $cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_LASTMODIFICATION, array($user->getFullName(), $date->getLocalizedDate($format))).'<br />';
				}
				if ($lastvalidation && is_object($lastvalidation[0])) {
					$user = $lastvalidation[0]->getUser();
					$date = $lastvalidation[0]->getDateTime();
					$panelTip .= $cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_LASTVALIDATION, array($user->getFullName(), $date->getLocalizedDate($format))).'<br />';
				}
				if (!$hasPublic) {
					$panelTip .= '<br /><br />'.$cms_language->getMessage(MESSAGE_PAGE_PUBLIC_TIP_DISABLED_DESC);
				}
				if ($hasRedirect) {
					$panelURL = PATH_ADMIN_WR.'/page-redirect-info.php?pageId='.$cms_page->getID();
				} else {
					if ($pageUrl) {
						//analyse get parameters
						$query = parse_url($pageUrl, PHP_URL_QUERY);
						$fragment = parse_url($pageUrl, PHP_URL_FRAGMENT);
						$panelURL = $cms_page->getURL().($query ? '?'.$query : '').($fragment ? '#'.$fragment : '');
					} else {
						$panelURL = $cms_page->getURL();
					}
					//check for website host
					$pageHost = parse_url($panelURL, PHP_URL_HOST);
					if ($pageHost && $_SERVER['HTTP_HOST'] && io::strtolower($httpHost) != io::strtolower($pageHost)) {
						//page host is not the same of current host so change it to avoid JS restriction
						$panelURL = str_replace($pageHost, $httpHost, $panelURL);
					}
				}
			break;
			case 'nopages':
				$panelTitle = APPLICATION_LABEL;
				$panelDisabled = 'false';
				$panelTipTitle = APPLICATION_LABEL;
				$panelTip = $cms_language->getJSMessage(MESSAGE_PAGE_NO_PAGES_RIGHTS);
				$panelURL = PATH_ADMIN_WR.'/no-pages.php';
				$allowFrameNav = 'true';
			break;
			case 'norights':
				$panelTitle = APPLICATION_LABEL;
				$panelDisabled = 'false';
				$panelTipTitle = APPLICATION_LABEL;
				$panelTip = $cms_language->getJSMessage(MESSAGE_PAGE_NO_PAGE_RIGHT);
				$panelURL = PATH_ADMIN_WR.'/no-rights.php';
				$allowFrameNav = 'true';
			break;
		}
		switch ($panelStatus['type']) {
			case 'winPanel':
				//check if panel exists. If not, create it, otherwise change properties
				$jscontent .= '
				if (panel) {
					panel.setTitle(\''.sensitiveIO::sanitizeJSString($panelTitle).'\');
					panel.setDisabled('.$panelDisabled.');
					panel.setCurrentPage('.$cms_page->getID().');
				} else {
					panel = new Automne.winPanel ({
						title:			\''.sensitiveIO::sanitizeJSString($panelTitle).'\',
						id:				\''.$panel.'\',
						disabled:		'.$panelDisabled.',
						currentPage:	'.$cms_page->getID();
						if ($panelPicto) {
							$jscontent .= ',
							iconCls:	\''.$panelPicto.'\'';
						}
						if ($panelURL) {
							$jscontent .= ',
							winURL:		\''.$panelURL.'\'';
						}
					$jscontent .= '
					});
					tabs.insert('.$index.', panel);
				}
				panel.setToolTip(\''.sensitiveIO::sanitizeJSString($panelTipTitle).'\', \''.sensitiveIO::sanitizeJSString($panelTip).'\');
				';
			break;
			case 'framePanel':
				//check if panel exists. If not, create it, otherwise change properties
				$jscontent .= '
				if (panel) {
					panel.setTitle(\''.sensitiveIO::sanitizeJSString($panelTitle).'\');
					panel.setDisabled('.$panelDisabled.');
					panel.setFrameURL(\''.$panelURL.'\');
					panel.setPageId(\''.$pageId.'\');
					panel.setReloadable(true);
				} else {
					panel = new Automne.framePanel ({
						title:			\''.sensitiveIO::sanitizeJSString($panelTitle).'\',
						id:				\''.$panel.'\',
						frameURL:		\''.$panelURL.'\',
						pageId:			\''.$pageId.'\',
						allowFrameNav:	'.$allowFrameNav.',
						editable:		'.$panelEditable.',
						reloadable:		true,
						disabled:		'.$panelDisabled;
						if ($panelPicto) {
							$jscontent .= ',
							iconCls:	\''.$panelPicto.'\'';
						}
					$jscontent .= '
					});
					tabs.insert('.$index.', panel);
				}
				panel.setToolTip(\''.sensitiveIO::sanitizeJSString($panelTipTitle).'\', \''.sensitiveIO::sanitizeJSString($panelTip).'\');
				';
			break;
			default:
				if ($panelContent) {
					$jscontent .= $panelContent.'
					panel.setToolTip(\''.sensitiveIO::sanitizeJSString($panelTipTitle).'\', \''.sensitiveIO::sanitizeJSString($panelTip).'\');'
					;
				} else {
					$jscontent .= '
					//then remove panel
					if (panel) tabs.remove(\''.$panel.'\');
					';
				}
			break;
		}
	} else {
		$index--;
		//remove panel
		$jscontent .= '
		//then remove panel
		if (panel) tabs.remove(\''.$panel.'\');
		';
	}
	$index++;
}
$jscontent .= '
	//set active panel
	var panel = tabs.getItem(\''.$active.'\');
	if (panel) {
		if ('.($noreload ? 'true' : 'false').') {
			panel.noreload();
		}
		tabs.setActiveTab(panel);
	}
	tabs.setPageId(\''.$pageId.'\');
	tabs.endUpdate();
	tabs.setDraft('.$hasDraft.');
	tabs.setFavorite('.$cms_user->isFavorite($pageId).');
	if ('.($reload ? 'true' : 'false').' && panel) {
		panel.reload();
	}
} else {
	pr(\'Cannot found tabPanels element ...\');
}
';
//set pageId as header of response
header('X-Automne-PageId: '.$pageId);
$view->addJavascript($jscontent);
$view->show();
?>