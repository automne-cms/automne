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

/**
  * PHP page : Load alias item interface
  * Used accross an Ajax request. Render an alias item for edition
  *
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');


define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_DESC", 139);
define("MESSAGE_PAGE_FIELD_FILE", 191);
define("MESSAGE_ALL_FILE",530);
define("MESSAGE_IMAGE",803);
define("MESSAGE_PAGE_FIELD_PARENT_CATEGORY", 1214);
define("MESSAGE_PAGE_FIELD_THUMBNAIL", 833);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_FORM_INCORRECT", 682);
define("MESSAGE_PAGE_FIELD_PROTECTED", 1730);
define("MESSAGE_PAGE_FIELD_PROTECTED_DESC", 1731);
define("MESSAGE_PAGE_FIELD_PROTECTED_INFO", 1732);
define("MESSAGE_PAGE_INFO_FIELD_CODENAME_VTYPE", 1677);
define("MESSAGE_PAGE_ALLOWED", 719);
define("MESSAGE_PAGE_AVAILABLE", 720);
define("MESSAGE_PAGE_PROTECTED_ALERT", 1743);

//Alias specific messages
define("MESSAGE_PAGE_TITLE", 7);
define("MESSAGE_TOOLBAR_HELP_MESSAGE", 29);
define("MESSAGE_PAGE_LABEL", 11);
define("MESSAGE_PAGE_LABEL_DESC", 10);
define("MESSAGE_PAGE_REDIR", 12);
define("MESSAGE_PAGE_REDIR_DESC", 13);
define("MESSAGE_PAGE_WEBSITES", 43);
define("MESSAGE_PAGE_WEBSITES_DESC", 15);
define("MESSAGE_PAGE_REPLACE", 16);
define("MESSAGE_PAGE_REPLACE_INFO", 17);
define("MESSAGE_PAGE_REPLACE_DESC", 18);
define("MESSAGE_PAGE_REDIR_TYPE", 19);
define("MESSAGE_PAGE_REDIR_TYPE_INFO", 20);
define("MESSAGE_PAGE_REDIR_TYPE_DESC", 21);
define("MESSAGE_PAGE_PROTECTED", 22);
define("MESSAGE_PAGE_PROTECTED_INFO", 23);
define("MESSAGE_PAGE_PROTECTED_DESC", 24);
define("MESSAGE_PAGE_SELECT_PAGE_REDIRECTION", 30);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId', 'sensitiveIO::isPositiveInteger');
$aliasId = sensitiveIO::request('alias', 'sensitiveIO::isPositiveInteger');
$pageId = sensitiveIO::request('page', 'io::isPositiveInteger');
$codename = 'cms_aliases';

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on module : '.$codename);
	$view->show();
}
//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($codename);

// Current alias object to manipulate
if ($aliasId) {
	$item = CMS_module_cms_aliases::getByID($aliasId);
	if (io::isPositiveInteger($item->getParent())) {
		$parentAlias = CMS_module_cms_aliases::getByID($item->getParent());
	}
} else {
	$item = new CMS_resource_cms_aliases();
	if (io::isPositiveInteger($fatherId)) {
		// Parent alias
		$parentAlias = CMS_module_cms_aliases::getByID($fatherId);
	}
}

$items = array();

$selectContent = array();
$aliases = CMS_module_cms_aliases::getAll(false, true);
foreach ($aliases as $alias) {
	if ($alias->getID() != $item->getID() && !$alias->hasParent($item->getID())) {
		$lineage = $alias->getPath();
		$selectContent[$lineage] = array($alias->getID(), $lineage);
	}
}

ksort($selectContent);
array_unshift($selectContent, array(0, '/'));
$selectContent = sensitiveIO::jsonEncode(array_values($selectContent));

$controlerURL = PATH_ADMIN_MODULES_WR.'/'.$codename.'/controler.php';

$parentId = (isset($parentAlias) && is_object($parentAlias)) ? $parentAlias->getId() : 0;
//mandatory 
$mandatory = '<span class="atm-red">*</span> ';
//create pseudo href for redirection infos
$href = new CMS_href();
if ($pageId) {
	$href->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
	$href->setInternalLink($pageId);
	$redirDisabled = 'disabled:true,';
	$redirHidden = "{
		xtype:			'hidden',
		name:			'page',
		value:			'{$pageId}'
	},";
} else {
	if (io::isPositiveInteger($item->getPageID())) {
		$href->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
		$href->setInternalLink($item->getPageID());
	} elseif($item->getURL()) {
		$href->setLinkType(RESOURCE_LINK_TYPE_EXTERNAL);
		$href->setExternalLink($item->getURL());
	}
	$redirDisabled = $redirHidden = '';
}
$redirectValue = io::sanitizeJSString($href->getTextDefinition());
$visualmode = RESOURCE_DATA_LOCATION_EDITED;

//Websites
$currentWebsites = $item->getWebsites();
$websites = CMS_websitesCatalog::getAll();
$availableWebsites = $selectedWebsites = array();
foreach ($websites as $id => $website) {
	if (in_array($website->getId(), $currentWebsites)) {
		$exists = false;
		foreach ($selectedWebsites as $data) {
			if ($data[1] == $website->getURL()) {
				$exists = true;
			}
		}
		if (!$exists) {
			$selectedWebsites[] = array($id, $website->getURL());
		}
	} else {
		$exists = false;
		foreach ($availableWebsites as $data) {
			if ($data[1] == $website->getURL()) {
				$exists = true;
			}
		}
		if (!$exists) {
			$availableWebsites[] = array($id, $website->getURL());
		}
	}
}

$availableWebsites = sensitiveIO::jsonEncode($availableWebsites);
$selectedWebsites = sensitiveIO::jsonEncode($selectedWebsites);

$subAliasesDisabled = $item->hasSubAliases() ? 'disabled:true,' : '';

//add an alert on protected option for non admin users
$protectedAlert = '';
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$protectedAlert = ",
		listeners:	{
			'check':function(el, checked) {
				if (checked) {
					Automne.message.popup({
						msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_PROTECTED_ALERT)}',
						buttons: 			Ext.MessageBox.OK,
						closable: 			false,
						icon: 				Ext.MessageBox.WARNING
					});
				}
			},
			scope:this
		}";
}

$jscontent = <<<END
	var window = Ext.getCmp('{$winId}');
	//set window title
	window.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE, false, "cms_aliases")}');
	//set help button on top of page
	window.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 window.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_MESSAGE, false, "cms_aliases")}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'{$winId}-alias',
			layout: 		'form',
			bodyStyle: 		'padding:10px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			xtype:			'atmForm',
			url:			'{$controlerURL}',
			labelAlign:		'right',
			labelWidth:		130,
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		true
			},
			items:[{
				{$subAliasesDisabled}
				xtype:			'atmCombo',
				fieldLabel:		'{$mandatory}Parent',
				name:			'newFatherId',
				hiddenName:		'newFatherId',
				forceSelection:	true,
				mode:			'local',
				valueField:		'id',
				displayField:	'name',
				triggerAction:	'all',
				allowBlank:		true,
				selectOnFocus:	true,
				editable:		false,
				value:			{$parentId},
				store:	{
					xtype:		'arraystore',
					fields: 	['id', 'name'],
					data: 		$selectContent
				}
			}, {
				{$subAliasesDisabled}
				fieldLabel:		'{$mandatory}<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_LABEL_DESC, false, "cms_aliases")}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_LABEL, false, "cms_aliases")}</span>',
				xtype:			'textfield',
				name:			'name',
				maxLength:		100,
				vtype:			'codename',
				allowBlank:		false,
				vtypeText:		'{$cms_language->getJSMessage(MESSAGE_PAGE_INFO_FIELD_CODENAME_VTYPE)}',
				value:			'{$item->getAlias()}'
			},{$redirHidden}{
				{$redirDisabled}
				fieldLabel:		'{$mandatory}<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_REDIR_DESC, false, "cms_aliases")}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_REDIR, false, "cms_aliases")}</span>',
				id:				'{$winId}-aliasRedirection',
				name:			'redirection',
				xtype: 			'atmLinkField',
				selectOnFocus:	true,
				value:			'{$redirectValue}',
				allowBlur:		true,
				linkConfig: {
					admin: 				true,						// Link has label ?
					label: 				false,						// Link has label ?
					internal: 			true,						// Link can target an Automne page ?
					external: 			true,						// Link can target an external resource ?
					file: 				false,						// Link can target a file ?
					destination:		false,						// Can select a destination for the link ?
					currentPage:		'{$item->getPageID()}',		// Current page to open tree
					module:				'cms_aliases', 
					visualmode:			'{$visualmode}'
				}
			},{
				xtype:			"itemselector",
				id:				'{$winId}-aliasWebsites',
				name:			"websites",
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_WEBSITES_DESC, false, "cms_aliases")}">{$cms_language->getJSMessage(MESSAGE_PAGE_WEBSITES, false, "cms_aliases")}</span>',
				dataFields:		["code", "desc"],
				toData:			{$selectedWebsites},
				msWidth:		250,
				msHeight:		130,
				height:			140,
				valueField:		"code",
				displayField:	"desc",
				toLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_ALLOWED)}",
				fromLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_AVAILABLE)}",
				fromData:		{$availableWebsites}
			},{
				fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_REPLACE_DESC, false, "cms_aliases")}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_REPLACE, false, "cms_aliases")}</span>',
				name:			'replaceURL',
				inputValue:		'1',
				xtype:			'checkbox',
				checked:		'{$item->urlReplaced()}',
				boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_REPLACE_INFO, false, "cms_aliases")}',
				listeners:	{
					'check':function(el, checked) {
						if (checked) {
							var redirectionLink = Ext.getCmp('{$winId}-aliasRedirection');
							if (redirectionLink) {
								if (redirectionLink.typecombo.getValue() != 1) {
									Automne.message.popup({
										msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_PAGE_REDIRECTION, false, "cms_aliases")}',
										buttons: 			Ext.MessageBox.OK,
										closable: 			false,
										icon: 				Ext.MessageBox.ERROR
									});
									el.setValue(false);
									return false;
								}
							}
							Ext.getCmp('{$winId}-aliasRedirType').disable();
						} else {
							Ext.getCmp('{$winId}-aliasRedirType').enable();
						}
					},
					scope:this
				}
			},{
				fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_REDIR_TYPE_DESC, false, "cms_aliases")}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_REDIR_TYPE, false, "cms_aliases")}</span>',
				id:				'{$winId}-aliasRedirType',
				name:			'permanent',
				inputValue:		'1',
				checked:		'{$item->isPermanent()}',
				disabled:		'!!{$item->urlReplaced()}',
				xtype:			'checkbox',
				boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_REDIR_TYPE_INFO, false, "cms_aliases")}',
			},{
				fieldLabel:		'<span ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_PROTECTED_DESC, false, "cms_aliases")}" class="atm-help">{$cms_language->getJSMessage(MESSAGE_PAGE_PROTECTED, false, "cms_aliases")}</span>',
				name:			'protected',
				inputValue:		'1',
				xtype:			'checkbox',
				checked:		'{$item->isProtected()}',
				boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_PROTECTED_INFO, false, "cms_aliases")}'
				{$protectedAlert}
			}]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('{$winId}-alias').getForm();
				if (form.isValid()) {
					form.submit({
						params:{
							action:		'save',
							fatherId:	'{$fatherId}',
							alias:	window.aliasId
						},
						success:function(form, action){
							//extract updated json datas from response
							var jsonResponse = {};
							if (action.response.responseXML && action.response.responseXML.getElementsByTagName('jsoncontent').length) {
								try{
									jsonResponse = Ext.decode(action.response.responseXML.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue);
								} catch(e) {
									jsonResponse = {};
									pr(e, 'error');
									Automne.server.failureResponse(action.response, action.options, e, 'json');
								}
							}
							if (jsonResponse.id) {
								window.aliasId = jsonResponse.id;
							}
						},
						scope:this
					});
				} else {
					Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_FORM_INCORRECT)}', '', window);
				}
			},
			scope:			this
		}]
	});
	window.add(center);
	setTimeout(function(){
		//redo windows layout
		window.doLayout();
		if (Ext.isIE7) {
			center.syncSize();
		}
	}, 100);
END;
$view->addJavascript($jscontent);
$view->show();
?>