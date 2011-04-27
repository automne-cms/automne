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
// $Id: page-properties.php,v 1.14 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP page : Load page properties window.
  * Used accross an Ajax request render page page properties window.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

$cms_language->startPrefetch();
define("MESSAGE_WINDOW_TITLE", 129);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_PAGE_LINKS_RELATIONS", 1405);
define('MESSAGE_PAGE_RESULTS_RELATIONS', 1417);
define('MESSAGE_PAGE_RESULTS_LINKS', 1418);
define("MESSAGE_PAGE_FIELD_TO", 1302);
define("MESSAGE_PAGE_FIELD_PAGE", 1303);
define("MESSAGE_PAGE_INFO_CLICK_TO_EDIT", 331);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_FIELD_LINKTITLE", 133);
define("MESSAGE_PAGE_INFO_ID", 54);
define("MESSAGE_PAGE_INFO_URL", 1099);
define("MESSAGE_PAGE_INFO_TEMPLATE", 72);
define("MESSAGE_PAGE_INFO_WEBSITE", 1076);
define("MESSAGE_PAGE_INFO_LINKS_RELATIONS", 1405);
define("MESSAGE_PAGE_INFO_PRINT", 1077);
define("MESSAGE_PAGE_FIELD_REDIRECT", 1039);
define("MESSAGE_PAGE_INFO_REQUIRED_FIELD", 1239);
define("MESSAGE_PAGE_FIELD_FORCEURLREFRESH_COMMENT", 1317);
define("MESSAGE_PAGE_INFO_FORCEURLREFRESH", 1318);
define("MESSAGE_PAGE_FIELD_CODENAME", 1675);
define("MESSAGE_PAGE_INFO_FIELD_CODENAME", 1676);
define("MESSAGE_PAGE_INFO_FIELD_CODENAME_VTYPE", 1677);

define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_PAGE_FIELD_DATE_COMMENT", 148);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_PAGE_FIELD_REMINDERDELAY", 136);
define("MESSAGE_PAGE_FIELD_REMINDERDELAY_COMMENT", 150);
define("MESSAGE_PAGE_FIELD_REMINDERDATE", 137);
define("MESSAGE_PAGE_FIELD_REMINDERMESSAGE", 138);

define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_DESCRIPTION_COMMENT", 149);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 140);
define("MESSAGE_PAGE_TITLE_BASEDATAS", 88);
define("MESSAGE_PAGE_TITLE_METATAGS", 1043);
define("MESSAGE_PAGE_TITLE_COMMONMETATAGS", 1041);
define("MESSAGE_PAGE_FIELD_CATEGORY", 1044);
define("MESSAGE_PAGE_FIELD_AUTHOR", 1033);
define("MESSAGE_PAGE_FIELD_REPLYTO", 1034);
define("MESSAGE_PAGE_FIELD_COPYRIGHT", 1035);
define("MESSAGE_PAGE_FIELD_LANGUAGE", 1036);
define("MESSAGE_PAGE_FIELD_ROBOTS", 1037);
define("MESSAGE_PAGE_FIELD_ROBOTS_COMMENT", 1042);
define("MESSAGE_PAGE_FIELD_PRAGMA", 1038);
define("MESSAGE_PAGE_FIELD_PRAGMA_COMMENTS", 1040);

define("MESSAGE_PAGE_UNPUBLISHED", 367);
define("MESSAGE_PAGE_UPDATE_NEXT_VALIDATION", 368);
define("MESSAGE_PAGE_LINK_LABEL_POINTING", 369);
define("MESSAGE_PAGE_IDENTIFIER_INFO", 370);
define("MESSAGE_PAGE_TEMPLATE_USED_INFO", 371);
define("MESSAGE_PAGE_BELONG_SITE", 372);
define("MESSAGE_PAGE_RELATION_BETWEEN_PAGE", 373);
define("MESSAGE_PAGE_PRINTABLE_VERSION", 374);
define("MESSAGE_PAGE_AUTOMATIC_REDIRECTION", 375);
define("MESSAGE_PAGE_DATE_START_PUBLICATION", 376);
define("MESSAGE_PAGE_DATE_END_PUBLICATION", 377);
define("MESSAGE_PAGE_DELAY_ALERT_MESSAGE", 378);
define("MESSAGE_PAGE_DATE_RECEPTION_ALERT_MESSAGE", 379);
define("MESSAGE_PAGE_ALERT_MESSAGE_INFO", 380);
define("MESSAGE_PAGE_TITLE_INFO", 381);
define("MESSAGE_PAGE_DESC_INFO", 382);
define("MESSAGE_PAGE_KEYWORD_INFO", 383);
define("MESSAGE_PAGE_CATEGORY_INFO", 384);
define("MESSAGE_PAGE_ROBOTS_INFO", 385);
define("MESSAGE_PAGE_BROWSER_DEFAULT_VALUE", 386);
define("MESSAGE_PAGE_AUTHOR_INFO", 387);
define("MESSAGE_PAGE_MAIL_INFO", 388);
define("MESSAGE_PAGE_COPYRIGHT_INFO", 389);
define("MESSAGE_PAGE_LANGUAGE_USED_INFO", 390);
define("MESSAGE_PAGE_BROWSER_CACHE_INFO", 391);
define("MESSAGE_PAGE_META_DATA", 398);
define("MESSAGE_PAGE_META_DATA_INFO", 392);
define("MESSAGE_PAGE_META_DATA_LABEL", 393);
define("MESSAGE_PAGE_SUBPAGES_LABEL", 394);
define("MESSAGE_PAGE_SUBPAGES_LIST_MESSAGE", 395);
define("MESSAGE_PAGE_DRAGANDDROP_MESSAGE", 396);
define("MESSAGE_PAGE_LOG_LABEL", 29);
define("MESSAGE_PAGE_TOOLBAR_HELP_INFO", 397);
define("MESSAGE_PAGE_MATCHING_TEMPLATE", 353);
define("MESSAGE_PAGE_UNMATCHING_TEMPLATE", 354);
define("MESSAGE_PAGE_PROPERTIES_LABEL", 8);
define("MESSAGE_PAGE_DATE_ALERT_LABEL", 1079);
define("MESSAGE_PAGE_SEARCH_ENGINE_LABEL", 1080);
define("MESSAGE_PAGE_ALIAS_LABEL", 399);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_PROPERTIES", 7);
define("MESSAGE_PAGE_CONTENT", 8);
define("MESSAGE_PAGE_FIELD_CURRENT_ADDRESS", 701);
define("MESSAGE_PAGE_INFORMATIONS", 702);
define("MESSAGE_PAGE_ALERTS_DISABLED", 1593);
define("MESSAGE_PAGE_FIELD_TEMPLATE_ALERT", 1600);
$cms_language->endPrefetch();

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId', '', 'propertiesWindow');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());

//load page
$cms_page = CMS_tree::getPageByID($currentPage);
if ($cms_page->hasError()) {
	CMS_grandFather::raiseError('Selected page ('.$currentPage.') has error ...');
	$view->show();
}

//set editable status
if ($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	if ($cms_page->getLock() && $cms_page->getLock() != $cms_user->getUserId()) {
		$editable = false;
	} else {
		$editable = true;
		$cms_page->lock($cms_user);
	}
} else {
	$editable = false;
}

if (!$editable) {
	$disabled = 'disabled:true,';
} else {
	$disabled = '';
}

/***************************************\
*             PAGE PROPERTIES           *
\***************************************/

$pageId = $cms_page->getID();
$pageTitle = $cms_page->getTitle();
$pageLinkTitle = $cms_page->getLinkTitle();
$website = $cms_page->getWebsite();
$status = $cms_page->getStatus()->getHTML(false, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getID());
$lineage = CMS_tree::getLineage($website->getRoot(), $cms_page);

//Page templates replacement
$pageTemplate = $cms_page->getTemplate();
//hack if page has no valid template attached
if (!is_a($pageTemplate, "CMS_pageTemplate")) {
	$pageTemplate = new CMS_pageTemplate();
}
$pageTplId = CMS_pageTemplatesCatalog::getTemplateIDForCloneID($pageTemplate->getID());
$pageTplLabel = $pageTemplate->getLabel();

//print
$print = ($cms_page->getPrintStatus()) ? $cms_language->getMessage(MESSAGE_PAGE_FIELD_YES):$cms_language->getMessage(MESSAGE_PAGE_FIELD_NO);

//page relations 
$linksFrom = CMS_linxesCatalog::searchRelations(CMS_linxesCatalog::PAGE_LINK_FROM, $cms_page->getID());
$linksTo = CMS_linxesCatalog::searchRelations(CMS_linxesCatalog::PAGE_LINK_TO, $cms_page->getID());

//page redirection
$redirectlink = $cms_page->getRedirectLink();
$redirectValue = '';
$module = MOD_STANDARD_CODENAME;
$visualmode = RESOURCE_DATA_LOCATION_EDITED;
if ($redirectlink->hasValidHREF()) {
	$redirect = $cms_language->getMessage(MESSAGE_PAGE_FIELD_YES).' '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TO).' : ';
	if ($redirectlink->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
		$redirectPage = new CMS_page($redirectlink->getInternalLink());
		if (!$redirectPage->hasError()) {
			$label = $cms_language->getMessage(MESSAGE_PAGE_FIELD_PAGE).' "'.$redirectPage->getTitle().'" ('.$redirectPage->getID().')';
		}
	} else {
		$label = $redirectlink->getExternalLink();
	}
	$redirectlink->setTarget('_blank');
	$redirect .= $redirectlink->getHTML($label, MOD_STANDARD_CODENAME, RESOURCE_DATA_LOCATION_EDITED, 'class="admin"', false);
	$redirectValue = sensitiveIO::sanitizeJSString($redirectlink->getTextDefinition());
} else {
	$redirect = $cms_language->getMessage(MESSAGE_PAGE_FIELD_NO);
}
//page URL
if ($cms_page->getURL()) {
	$pageUrl = '<a href="'.$cms_page->getURL().'" target="_blank">'.$cms_page->getURL().'</a>'.($cms_page->getRefreshURL() ? ' (<em>'.$cms_language->getMessage(MESSAGE_PAGE_UPDATE_NEXT_VALIDATION).'</em>)' : '');
} else {
	$pageUrl = '<em>'.$cms_language->getMessage(MESSAGE_PAGE_UNPUBLISHED).'</em>';
}
//mandatory 
$mandatory='<span class="atm-red">*</span> ';

$websiteLabel = sensitiveIO::sanitizeJSString($website->getLabel());

$pageRelations = sensitiveIO::sanitizeJSString('<ul>
	<li><a href="#" onclick="Automne.view.search(\''.CMS_search::SEARCH_TYPE_LINKFROM.':'.$cms_page->getID().'\');">'.$cms_language->getMessage(MESSAGE_PAGE_RESULTS_RELATIONS,array(count($linksTo)),MOD_STANDARD_CODENAME).'</a></li>
	<li><a href="#" onclick="Automne.view.search(\''.CMS_search::SEARCH_TYPE_LINKTO.':'.$cms_page->getID().'\');">'.$cms_language->getMessage(MESSAGE_PAGE_RESULTS_LINKS,array(count($linksFrom)),MOD_STANDARD_CODENAME).'</a></li>
</ul>');

/***************************************\
*         PAGE DATES & ALERTS           *
\***************************************/

$dateFormat = $cms_language->getDateFormat();
$pub_start = $cms_page->getPublicationDateStart(false);
$pub_end = $cms_page->getPublicationDateEnd(false);
$reminder_date = $cms_page->getReminderOn();
$date_mask = $cms_language->getDateFormatMask();
$pubStart = $pub_start->getLocalizedDate($dateFormat);
$pubEnd = $pub_end->getLocalizedDate($dateFormat);
$reminderPeriodicity = $cms_page->getReminderPeriodicity();
$reminderDate = $reminder_date->getLocalizedDate($dateFormat);
$reminderMessage = sensitiveIO::sanitizeJSString(htmlspecialchars($cms_page->getReminderOnMessage()), false, true, true); //this is a textarea, we must keep cariage return

$alertDisabled = '';
if (!$cms_user->hasAlertLevel(ALERT_LEVEL_PAGE_ALERTS, MOD_STANDARD_CODENAME)) {
	$alertDisabled = "{
		cls:	'atm-text-alert',
		xtype:	'fieldset',
		html:	'{$cms_language->getJSMessage(MESSAGE_PAGE_ALERTS_DISABLED)}'
	},";
}
/***************************************\
*            SEARCH ENGINES             *
\***************************************/
$description = sensitiveIO::sanitizeJSString($cms_page->getDescription());
$keywords = sensitiveIO::sanitizeJSString($cms_page->getKeywords());
$category = sensitiveIO::sanitizeJSString($cms_page->getCategory());
$robots = sensitiveIO::sanitizeJSString($cms_page->getRobots());

/***************************************\
*              META-DATAS               *
\***************************************/
if (!NO_PAGES_EXTENDED_META_TAGS) {
	$author = sensitiveIO::sanitizeJSString($cms_page->getAuthor());
	$replyTo = sensitiveIO::sanitizeJSString($cms_page->getReplyto());
	$copyright = sensitiveIO::sanitizeJSString($cms_page->getCopyright());
}
$language = CMS_languagesCatalog::getByCode($cms_page->getLanguage());
$pageLanguage = sensitiveIO::sanitizeJSString($language->getLabel());
$languageValue = $language->getCode();
$pragmaValue = ($cms_page->getPragma() != '') ? 'true' : 'false';

$languages = CMS_languagesCatalog::getAllLanguages(MOD_STANDARD_CODENAME);
$languagesDatas = array();
foreach ($languages as $aLanguage) {
	$languagesDatas[] = array($aLanguage->getCode(), $aLanguage->getLabel());
}
$languagesDatas = sensitiveIO::jsonEncode($languagesDatas);
$metas = sensitiveIO::sanitizeJSString($cms_page->getMetas(), false, true, true); //this is a textarea, we must keep cariage return

/***************************************\
*               SUB-PAGES               *
\***************************************/
$siblings = '';
if (CMS_tree::hasSiblings($cms_page)) {
	$siblings = ", {
					title:	'".$cms_language->getMessage(MESSAGE_PAGE_SUBPAGES_LABEL)."',
					xtype:	'atmPanel',
					id:		'subPagesPanel',
					autoLoad:		{
						url:		'tree.php',
						params:		{
							winId:		'subPagesPanel',
							root:		'$pageId',
							showRoot:	false,
							maxlevel:	1,
							hideMenu:	true,
							window:		false,
							heading:	'".$cms_language->getJSMessage(MESSAGE_PAGE_SUBPAGES_LIST_MESSAGE)." ".sensitiveIO::sanitizeJSString($cms_page->getTitle()).".".($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT) ? ' '.$cms_language->getJSMessage(MESSAGE_PAGE_DRAGANDDROP_MESSAGE) : '')."',
							enableDD:	".($cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT) ? 'true' : 'false')."
						},
						nocache:	true,
						scope:		this
					}
	            }";
}

/***************************************\
*              PAGE LOGS                *
\***************************************/
$logs = '';
//if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	$logs = ", {
					title:	'".$cms_language->getMessage(MESSAGE_PAGE_LOG_LABEL)."',
					xtype:	'atmPanel',
					layout:	'fit',
					id:		'logPanel',
					autoLoad:		{
						url:		'page-logs.php',
						params:		{
							winId:		'logPanel',
							currentPage:'$pageId',
							action:		'view'
						},
						nocache:	true,
						scope:		this
					}
	            }";
//}

/***************************************\
*             MODULES TABS              *
\***************************************/
$modules = CMS_modulesCatalog::getALL();
$modulesTabs = '';
foreach ($modules as $aModule) {
	if ($aModule->getCodename() != MOD_STANDARD_CODENAME
		&& $cms_user->hasModuleClearance($aModule->getCodename(), CLEARANCE_MODULE_EDIT)
		&& method_exists($aModule,'getPageTabsProperties')) {
		
		$tabsInfos = $aModule->getPageTabsProperties($cms_page, $cms_user);
		foreach ($tabsInfos as $tabInfos) {
			$label = $tabInfos['description'] ? '<span ext:qtip="'.sensitiveIO::sanitizeJSString($tabInfos['description']).'">'.sensitiveIO::sanitizeJSString($tabInfos['label']).'</span>' : sensitiveIO::sanitizeJSString($tabInfos['label']);
			$url = $tabInfos['url'];
			$tabInfos['winId'] = $objectWinId = 'module'. $aModule->getCodename() . $tabInfos['tabId'] .'TabPanel';
			$tabInfos['fatherId'] = $winId;
			$params = sensitiveIO::jsonEncode($tabInfos);
			if (!isset($tabInfos['frame']) || $tabInfos['frame'] == false) {
				$modulesTabs .= ",{
					title:	'{$label}',
					id:		'{$objectWinId}',
					xtype:	'atmPanel',
					layout:	'atm-border',
					autoLoad:		{
						url:		'{$url}',
						params:		{$params},
						nocache:	true,
						scope:		center
					}
				}";
			} else {
				$modulesTabs .= ",{
					title:			'{$label}',
					id:				'{$objectWinId}',
					xtype:			'framePanel',
					frameURL:		'{$url}',
					allowFrameNav:	true
				}";
			}
		}
	}
}

//sanitize some js string
$pageTitle = sensitiveIO::sanitizeJSString($pageTitle);
$pageLinkTitle = sensitiveIO::sanitizeJSString($pageLinkTitle);
$pageTplLabel = sensitiveIO::sanitizeJSString($pageTplLabel);

$jscontent = <<<END
	var propertiesWindow = Ext.getCmp('{$winId}');
	//set window title
	propertiesWindow.setTitle('{$cms_language->getJSMessage(MESSAGE_WINDOW_TITLE)} \'{$pageTitle}\'');
	//set window icon
	propertiesWindow.setIconClass('atm-pic-edit');
	//set help button on top of page
	propertiesWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		propertiesWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_TOOLBAR_HELP_INFO)}',
		dismissDelay:	0
    });
	//unlock page just before window close
	propertiesWindow.on('beforeclose', function() {
		//send server call
		Automne.server.call({
			url:				'resource-controler.php',
			params: 			{
				resource:		'{$pageId}',
				module:			'standard',
				action:			'unlock'
			},
			callBackScope:		this
		});
		return true;
	});
END;

if (!NO_PAGES_EXTENDED_META_TAGS) {
	$extendedMetas = "{
		{$disabled}
		fieldLabel:		'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_AUTHOR_INFO)}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_AUTHOR)}</span>',
		name:			'authortext',
		value:			'{$author}'
	},{
		{$disabled}
		fieldLabel:		'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_MAIL_INFO)}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REPLYTO)}</span>',
		name:			'replytotext',
		value:			'{$replyTo}',
		allowBlank:		true,
		validator:		function(value){
			if (!value) {
				return true;
			}
			var vt = Ext.form.VTypes;
            if(!vt['email'](value, this)){
                return vt['emailText'];
            }
			return true;
		}
	},{
		{$disabled}
		fieldLabel:		'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_COPYRIGHT_INFO)}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_COPYRIGHT)}</span>',
		name:			'copyrighttext',
		value:			'{$copyright}'
	},";
} else {
	$extendedMetas = '';
}

//create page lineage
$lineageTitle = '';
if (is_array($lineage) && sizeof($lineage)) {
	foreach ($lineage as $ancestor) {
		if ($ancestor->getID() != $cms_page->getID()) {
			$lineageTitle .= '&nbsp;/&nbsp;<a href="#" onclick="Automne.utils.getPageById('.$ancestor->getID().');Ext.getCmp(\''.$winId.'\').close();">'.io::htmlspecialchars($ancestor->getTitle()).'</a>';
		} else {
			$lineageTitle .= '&nbsp;/&nbsp;'.io::htmlspecialchars($ancestor->getTitle());
		}
	}
}

$pageTopPanel = sensitiveIO::sanitizeJSString('<div id="pagePropTopPanel">
	<div id="pagePropTitle">
	'.$status.'
	<span class="title">'.$cms_page->getTitle().'</span>
	</div>
	<div id="breadcrumbs">'.$lineageTitle.'</div>
</div>');

$allowExternalRedirection = ALLOW_EXTERNAL_PAGE_REDIRECTION ? 'true' : 'false';

//Hack to allow template selection if page does not have a valid template
if (!$pageTplId) {
	$pageTplId = '-';
}

$codename = $cms_page->getCodename();
$codenameField = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$codenameField = ",{
				{$disabled}
				fieldLabel:		'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_FIELD_CODENAME)}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_CODENAME)}</span>',
				xtype:			'textfield',
				name:			'codename',
				maxLength:		20,
				vtype:			'codename',
				allowBlank:		true,
				vtypeText:		'{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_FIELD_CODENAME_VTYPE)}',
				value:			'{$codename}'
			}";
} else {
	if ($codename) {
		$codenameField = ",{
				fieldLabel:		'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_FIELD_CODENAME)}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_CODENAME)}</span>',
				name:			'pageCodename',
				xtype:			'atmEmptyfield',
				value:			'{$codename}'
			}";
	}
}
$jscontent .= <<<END
	//create center panel
	var center = new Ext.TabPanel({
        activeTab: 			0,
        id:					'pagePropPanel',
		region:				'center',
		plain:				true,
        enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		defaults:			{
			autoScroll: true
		},
        items:[{
				title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_PROPERTIES)}',
				id:					'propertiesPanel',
				autoScroll:			true,
				layout: 			'accordion',
				border:				false,
				bodyBorder: 		false,
				defaults: {
					// applied to each contained panel
					bodyStyle: 			'padding:5px',
					border:				false,
					autoScroll:			true
				},
				layoutConfig: {
					// layout-specific configs go here
					animate: 			true
				},
				items:[{
					title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_CONTENT)}',
					id:				'pageContentPanel',
					layout: 		'form',
					xtype:			'atmForm',
					url:			'page-controler.php',
					collapsible:	true,
					labelAlign:		'right',
					defaultType:	'textfield',
					labelWidth:		120,
					buttonAlign:	'center',
					defaults: {
						xtype:			'textfield',
						anchor:			'97%',
						allowBlank:		true
					},
					items:[{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_TITLE_INFO)}" class="atm-help">{$mandatory}{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_TITLE)}</span>',
						name:			'title',
						value:			'{$pageTitle}',
						allowBlank:		false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_LINK_LABEL_POINTING)}" class="atm-help">{$mandatory}{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_LINKTITLE)}</span>',
						name:			'linkTitle',
						value:			'{$pageLinkTitle}',
						allowBlank:		false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_TEMPLATE_USED_INFO)}" class="atm-help">{$mandatory}{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_TEMPLATE)}</span>',
						name:			'template',
						hiddenName:		'template',
						xtype:			'atmCombo',
						forceSelection:	true,
						mode:			'remote',
						valueField:		'id',
						displayField:	'label',
						value:			'{$pageTplId}',
						triggerAction: 	'all',
						store:			new Automne.JsonStore({
							url: 			'page-templates-datas.php',
							baseParams:		{
								template: 		'{$pageTplId}',
								page:			$pageId
							},
							root: 			'results',
							fields: 		['id', 'label', 'image', 'groups', 'compatible', 'description'],
							prepareData: 	function(data){
						    	data.qtip = Ext.util.Format.htmlEncode(data.description);
								data.cls = data.compatible ? '' : 'atm-red';
								return data;
							}
						}),
						allowBlank: 		false,
						selectOnFocus:		true,
						editable:			false,
						tpl: 				'<tpl for="."><div ext:qtip="{qtip}" class="x-combo-list-item {cls}">{label}</div></tpl>',
						anchor:				false,
						listeners:{'collapse':function(field){
							if (field.getStore().getById(field.hiddenField.value)) {
								if (!field.getStore().getById(field.hiddenField.value).get('compatible')) {
									Automne.message.popup({
										msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_TEMPLATE_ALERT)}',
										buttons: 			Ext.MessageBox.OK,
										animEl: 			field.getEl(),
										closable: 			false,
										icon: 				Ext.MessageBox.WARNING
									});
								}
							}
							return true;
						}}
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_FORCEURLREFRESH)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_URL)}</span>',
						name:			'updateURL',
						inputValue:		'1',
						xtype:			'checkbox',
						boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_CURRENT_ADDRESS)} {$pageUrl}',
						height:			40
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_AUTOMATIC_REDIRECTION)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REDIRECT)}</span>',
						name:			'redirection',
						xtype: 			'atmLinkField',
						selectOnFocus:	true,
						value:			'{$redirectValue}',
						allowBlur:		true,
						linkConfig: {
							admin: 				true,						// Link has label ?
							label: 				false,						// Link has label ?
							internal: 			true,						// Link can target an Automne page ?
							external: 			{$allowExternalRedirection},// Link can target an external resource ?
							file: 				false,						// Link can target a file ?
							destination:		false,						// Can select a destination for the link ?
							currentPage:		'{$pageId}',				// Current page to open tree
							module:				'{$module}', 
							visualmode:			'{$visualmode}'
						}
					},{
						title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_INFORMATIONS)}',
						xtype:			'fieldset',
						autoHeight:		true,
						autoWidth:		true,
						collapsed:		false,
						defaults: {
							xtype:			'atmEmptyfield'
						},
						items:[{
							fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_IDENTIFIER_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_ID)}</span>',
							name:			'pageId',
							xtype:			'atmEmptyfield',
							value:			'{$pageId}'
						}{$codenameField},{
							fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_BELONG_SITE)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_WEBSITE)}</span>',
							name:			'pageWebsite',
							xtype:			'atmEmptyfield',
							value:			'{$websiteLabel}'
						},{
							fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_RELATION_BETWEEN_PAGE)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_LINKS_RELATIONS)}</span>',
							name:			'pageRelations',
							xtype:			'atmEmptyfield',
							value:			'{$pageRelations}'
						},{
							fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_PRINTABLE_VERSION)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_PRINT)}</span>',
							name:			'pagePrint',
							xtype:			'atmEmptyfield',
							value:			'{$print}'
						}]
					}],
					buttons:[{
						{$disabled}
						iconCls:		'atm-pic-validate',
						text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
						name:			'submitPageContent',
						anchor:			false,
						scope:			this,
						handler:		function() {
							var form = Ext.getCmp('pageContentPanel').getForm();
							form.submit({
								params:{
									action:		'pageContent',
									currentPage:'{$pageId}'
								},
								scope:this
							});
						}
					}]
				},{
					title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_DATE_ALERT_LABEL)}',
					id:				'pageDatesPanel',
					layout: 		'form',
					xtype:			'atmForm',
					url:			'page-controler.php',
					collapsible:	true,
					defaultType:	'textfield',
					collapsed:		true,
					labelAlign:		'right',
					labelWidth:		145,
					buttonAlign:	'center',
					defaults: {
						xtype:			'textfield',
						anchor:			'97%',
						allowBlank:		true
					},
					items:[{$alertDisabled}{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_DATE_START_PUBLICATION)} {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask))}" class="atm-help">{$mandatory}{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)}</span>',
						name:			'pubdatestart',
						value:			'{$pubStart}',
						xtype:			'datefield',
						allowBlank: 	false,
						format:			'{$dateFormat}',
						width:			100,
						anchor:			false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_DATE_END_PUBLICATION)} {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask))}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)}</span>',
						name:			'pubdateend',
						value:			'{$pubEnd}',
						xtype:			'datefield',
						format:			'{$dateFormat}',
						width:			100,
						anchor:			false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_DELAY_ALERT_MESSAGE)} {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY_COMMENT)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REMINDERDELAY)}</span>',
						name:			'reminderdelay',
						value:			'{$reminderPeriodicity}',
						width:			30,
						anchor:			false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_DATE_RECEPTION_ALERT_MESSAGE)} {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask))}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REMINDERDATE)}</span>',
						name:			'reminderdate',
						value:			'{$reminderDate}',
						xtype:			'datefield',
						format:			'{$dateFormat}',
						width:			100,
						anchor:			false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_ALERT_MESSAGE_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_REMINDERMESSAGE)}</span>',
						name:			'remindertext',
						value:			"{$reminderMessage}",
						xtype:			'textarea'
					}],
					buttons:[{
						{$disabled}
						iconCls:		'atm-pic-validate',
						text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
						name:			'submitPageDates',
						scope:			this,
						handler:		function() {
							var form = Ext.getCmp('pageDatesPanel').getForm();
							form.submit({params:{
								action:		'pageDates',
								currentPage:'{$pageId}'
							}});
						}
					}]
				},{
					title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SEARCH_ENGINE_LABEL)}',
					id:				'pageSearchEnginesPanel',
					layout: 		'form',
					xtype:			'atmForm',
					url:			'page-controler.php',
					collapsible:	true,
					defaultType:	'textfield',
					collapsed:		true,
					labelAlign:		'right',
					buttonAlign:	'center',
					defaults: {
						xtype:			'textfield',
						anchor:			'97%',
						allowBlank:		true
					},
					items:[{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_DESC_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)}</span>',
						name:			'descriptiontext',
						value:			'{$description}',
						xtype:			'textarea'
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_KEYWORD_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_KEYWORDS)}</span>',
						name:			'keywordstext',
						value:			'{$keywords}',
						xtype:			'textarea'
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_CATEGORY_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_CATEGORY)}</span>',
						name:			'categorytext',
						value:			'{$category}',
						xtype:			'textarea'
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_ROBOTS_INFO)} {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_ROBOTS_COMMENT)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_ROBOTS)}</span>',
						name:			'robotstext',
						value:			'{$robots}'
					}],
					buttons:[{
						{$disabled}
						iconCls:		'atm-pic-validate',
						text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
						name:			'submitPageSearchEngine',
						scope:			this,
						handler:		function() {
							var form = Ext.getCmp('pageSearchEnginesPanel').getForm();
							form.submit({params:{
								action:		'pageSearchEngines',
								currentPage:'{$pageId}'
							}});
						}
					}]
				},{
					title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_META_DATA)}',
					id:				'pageMetasPanel',
					layout: 		'form',
					xtype:			'atmForm',
					url:			'page-controler.php',
					collapsible:	true,
					defaultType:	'textfield',
					collapsed:		true,
					labelAlign:		'right',
					labelWidth:		120,
					buttonAlign:	'center',
					defaults: {
						xtype:			'textfield',
						anchor:			'97%',
						allowBlank:		true
					},
					items:[{$extendedMetas}{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_LANGUAGE_USED_INFO)}" class="atm-help">{$mandatory}{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_LANGUAGE)}</span>',
						name:			'language',
						hiddenName:		'language',
						xtype:			'combo',
						forceSelection:	true,
						mode:			'local',
						valueField:		'id',
						displayField:	'name',
						value:			'{$languageValue}',
						triggerAction: 	'all',
						store:			new Ext.data.SimpleStore({
						    fields: 		['id', 'name'],
						    data : 			{$languagesDatas}
						}),
						allowBlank: 		false,
						selectOnFocus:		true,
						editable:			false,
						anchor:				false
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_BROWSER_CACHE_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_PRAGMA)}</span>',
						name:			'pragmatext',
						inputValue:		'1',
						checked:		{$pragmaValue},
						xtype:			'checkbox',
						boxLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_PRAGMA_COMMENTS)}'
					},{
						{$disabled}
						fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_META_DATA_INFO)}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_META_DATA_LABEL)}</span>',
						name:			'metatext',
						value:			"{$metas}",
						xtype:			'textarea'
					}],
					buttons:[{
						{$disabled}
						iconCls:		'atm-pic-validate',
						text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
						name:			'submitPageMetas',
						scope:			this,
						handler:		function() {
							var form = Ext.getCmp('pageMetasPanel').getForm();
							form.submit({params:{
								action:		'pageMetas',
								currentPage:'{$pageId}'
							}});
						}
					}]
				}]
			}
			{$siblings}
			{$modulesTabs}
			{$logs}
        ]
    });
	// Panel for the north
	var top = new Ext.Panel({
		region:			'north',
		border:			false,
		height:			56,
		html:			'{$pageTopPanel}'
	});
	propertiesWindow.add(top);
	propertiesWindow.add(center);
	//redo windows layout
	propertiesWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>