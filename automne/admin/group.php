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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: group.php,v 1.8 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP page : Load group detail window.
  * Used accross an Ajax request. Render group informations.
  * 
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_DESC", 139);
define("MESSAGE_TOOLBAR_FILTER", 322);
define("MESSAGE_PAGE_SEARCH", 1091);
define("MESSAGE_PAGE_USERS", 926);
define("MESSAGE_PAGE_NAME", 94);
define("MESSAGE_PAGE_FIRSTNAME", 93);
define("MESSAGE_PAGE_EMAIL", 102);
define("MESSAGE_PAGE_ACTIVE", 410);
define("MESSAGE_PAGE_ALL_USERS", 1117);
define("MESSAGE_PAGE_GROUP_USERS", 1439);
define("MESSAGE_PAGE_USER_X_ON", 412);
define("MESSAGE_PAGE_NO_USER", 928);
define("MESSAGE_PAGE_PAGE", 62);
define("MESSAGE_PAGE_ADMINISTRATION", 449);
define("MESSAGE_PAGE_GROUP_PROFILE", 74);
define("MESSAGE_PAGE_CREATE_GROUP", 1445);
define("MESSAGE_PAGE_TOOLBAR_INFO", 1446);
define("MESSAGE_PAGE_YES", 1082);
define("MESSAGE_PAGE_NO", 1083);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);

$winId = sensitiveIO::request('winId', '', 'groupWindow');
$groupId = sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger', 'createGroup');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

//load group if any
if (sensitiveIO::isPositiveInteger($groupId)) {
	$group = CMS_profile_usersGroupsCatalog::getByID($groupId);
	if (!$group || $group->hasError()) {
		CMS_grandFather::raiseError('Unknown group for given Id : '.$groupId);
		$view->show();
	}
} else {
	//create new group
	$group = new CMS_profile_usersGroup();
}

//MAIN TAB

//Need to sanitize all datas which can contain single quotes
$label = sensitiveIO::sanitizeJSString($group->getLabel());
$labelValue = ($label) ? "value:'{$label}'," : '';
$description = addslashes(sensitiveIO::sanitizeJSString($group->getDescription(), false, true, true));

//get records / pages
$recordsPerPage = CMS_session::getRecordsPerPage();

$usersTab = $modulesTab = $adminTab = '';

//USERS TAB
$usersTab = ",{
		id:					'groupUsers-{$groupId}',
		title:				'{$cms_language->getMessage(MESSAGE_PAGE_USERS)}',
		xtype:				'grid',
		store: 				store,
		border:				false,
		autoExpandColumn:	'description',
		cm: 				new Ext.grid.ColumnModel([
			sm,
			{header: \"ID\", 													width: 30, 	dataIndex: 'id', 			sortable: true, 	hidden:true},
			{header: \"{$cms_language->getJsMessage(MESSAGE_PAGE_NAME)}\", 		width: 80, 	dataIndex: 'lastName', 		sortable: true,						renderer:renderUsers},
			{header: \"{$cms_language->getJsMessage(MESSAGE_PAGE_FIRSTNAME)}\", width: 80, 	dataIndex: 'firstName', 	sortable: true},
			{header: \"{$cms_language->getJsMessage(MESSAGE_PAGE_EMAIL)}\", 	width: 120, dataIndex: 'email', 		sortable: false, 	hidden:true, 	renderer:function(value) {return '<a href=\"mailto:'+value+'\">'+value+'</a>';}},
			{header: \"{$cms_language->getJsMessage(MESSAGE_PAGE_ACTIVE)}\", 	width: 20, 	dataIndex: 'active', 		sortable: true, 					renderer:function(value) {return value == 1 ? '{$cms_language->getJsMessage(MESSAGE_PAGE_YES)}' : '{$cms_language->getJsMessage(MESSAGE_PAGE_NO)}';}}
		]),
		sm: 				sm,
		anchor:				'100%',
		viewConfig: 		{
			forceFit:			true
		},
		tbar:[{
			xtype: 			'textfield',
			emptyText:		'{$cms_language->getJsMessage(MESSAGE_PAGE_SEARCH)} ...',
			id: 			'groupSearch-{$groupId}',
			selectOnFocus: 	true,
			width:			300,
			listeners: 		{
				'render': {fn:function(){
					Ext.getCmp('groupSearch-{$groupId}').getEl().on('keyup', filter, this, {buffer:500});
				}, scope:groupWindow}
			}
		},'-',{
			xtype:			'checkbox',
			boxLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_ALL_USERS)}',
			listeners:		{'check': function(item, checked) {
				if (checked) {
					filterGroupsUsers = false;
				} else {
					filterGroupsUsers = true;
				}
				filter();
			}}
		}],
		bbar:				new Ext.PagingToolbar({
			pageSize: 			{$recordsPerPage},
			store: 				store,
			displayInfo: 		true,
			displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_USER_X_ON)}',
			emptyMsg: 			\"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_USER)} ...\"
		})
	}";
//Modules tabs
$modulesTab = ",{
		id:					'groupPages-{$groupId}',
		title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_PAGE)}',
		border:				false,
		xtype:				'atmPanel',
		autoScroll:			true,
		autoLoad:		{
			url:		'user-modules-rights.php',
			params:			{
				fatherId:		groupWindow.id,
				winId:			'groupPages-{$groupId}',
				groupId:		groupWindow.groupId
			},
			nocache:	true
		}
	}";
$modules = CMS_modulesCatalog::getAll();
unset($modules[MOD_STANDARD_CODENAME]);
foreach ($modules as $codename => $module) {
	$modLabel = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
	if ($modLabel) {
		$modulesTab .= ",{
			id:					'group-{$codename}-{$groupId}',
			title:				'{$modLabel}',
			border:				false,
			xtype:				'atmPanel',
			autoScroll:			true,
			autoLoad:		{
				url:		'user-modules-rights.php',
				params:			{
					fatherId:		groupWindow.id,
					module:			'{$codename}',
					winId:			'group-{$codename}-{$groupId}',
					groupId:		groupWindow.groupId
				},
				nocache:	true
			}
		}";
	}
}
//ADMIN TAB
$adminTab = ",{
		id:				'groupAdmin-{$groupId}',
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_ADMINISTRATION)}',
		border:			false,
		xtype:			'atmPanel',
		autoScroll:		true,
		autoLoad:		{
			url:		'user-admin-rights.php',
			params:			{
				winId:			'groupAdmin-{$groupId}',
				groupId:		groupWindow.groupId
			},
			nocache:	true
		}
	}";

/********************************************\
*             MODULES ACCORDION              *
\********************************************/
$modulesAccordion = '';

//usefull temporary function
function replaceCallBack($parts) {
	return 'function('.str_replace(array('\"','\/'), array('"', '/'), $parts[1]).'}';
}

foreach ($modules as $aModule) {
	if (method_exists($aModule,'getGroupAccordionProperties')) {
		$moduleCodename = $aModule->getCodename();
		//get accordion datas from module
		$moduleDatas = $aModule->getGroupAccordionProperties($groupId, $cms_language);
		
		$moduleURL = false;
		if (isset($moduleDatas['url'])) {
			$moduleURL = $moduleDatas['url'];
		}
		$moduleLabel = io::sanitizeJSString($aModule->getLabel($cms_language));
		if (isset($moduleDatas['label'])) {
			$moduleLabel = $moduleDatas['label'];
		}
		
		$moduleFields = array();
		if (isset($moduleDatas['fields']) && is_array($moduleDatas['fields'])) {
			$moduleFields = $moduleDatas['fields'];
		}
		if (is_array($moduleFields)) {
			$moduleFields = sensitiveIO::jsonEncode($moduleFields);
		}
		//do some search and replace to allow use of js functions in returned code
		$moduleFields = str_replace('"scope":"this"', '"scope":this', $moduleFields);
		$moduleFields = preg_replace_callback('#"function\((.*)}"#U', 'replaceCallBack', $moduleFields);
		$button = ($moduleURL) ? ",
			buttons:[{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				iconCls:		'atm-pic-validate',
				xtype:			'button',
				name:			'submit{$moduleCodename}Group',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('groupPanel-{$moduleCodename}-{$groupId}').getForm();
					form.submit({params:{
						action:		'update-group',
						groupId:	groupWindow.groupId
					}});
				}
			}]" : '';
		$modulesAccordion .= ",{
			title:			'{$moduleLabel}',
			id:				'groupPanel-{$moduleCodename}-{$groupId}',
			layout: 		'form',
			xtype:			'atmForm',
			url:			'{$moduleURL}',
			collapsible:	true,
			defaultType:	'textfield',
			collapsed:		true,
			autoWidth:		true,
			autoScroll:		true,
			buttonAlign:	'center',
			labelAlign:		'right',
			autoScroll:		true,
			defaults: {
				xtype:			'textfield',
				anchor:			'97%'
			},
			items:[{$moduleFields}]
			{$button}
		}";
	}
}

$title = (sensitiveIO::isPositiveInteger($groupId)) ? $cms_language->getJsMessage(MESSAGE_PAGE_GROUP_PROFILE).' : '.$label : $cms_language->getJsMessage(MESSAGE_PAGE_CREATE_GROUP);

$jscontent = <<<END
	var groupWindow = Ext.getCmp('{$winId}');
	groupWindow.groupId = '{$groupId}';
	//set window title
	groupWindow.setTitle('{$title}');
	//set help button on top of page
	groupWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 groupWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_PAGE_TOOLBAR_INFO)}',
		dismissDelay:	0
	});
	
	//renderer for users names
	var renderUsers = function(label, row, record) {
		return '<a onclick="var groupWindow = Ext.getCmp(\'{$winId}\');groupWindow.editUser('+ record.id +', this);">'+ label +'</a>';
	}
	//edit user
	groupWindow.editUser = function(userId, el) {
		el = Ext.get(el);
		var groupWindow = Ext.getCmp('{$winId}');
		var fatherWindow = groupWindow.father;
		if (fatherWindow.userWindows[userId]) {
			Ext.WindowMgr.bringToFront(fatherWindow.userWindows[userId]);
		} else {
			//create window element
			fatherWindow.userWindows[userId] = new Automne.Window({
				id:				'userWindow'+userId,
				modal:			false,
				father:			fatherWindow,
				autoLoad:		{
					url:			'user.php',
					params:			{
						winId:			'userWindow'+userId,
						userId:			userId
					},
					nocache:		true,
					scope:			this
				},
				listeners:{'close':function(window){
					delete fatherWindow.userWindows[window.id.substr(10)];
					//refresh search list
					if (fatherWindow.usersWindow && fatherWindow.usersWindow.launchSearch) {
						fatherWindow.usersWindow.launchSearch();
					}
				}}
			});
			//display window
			fatherWindow.userWindows[userId].show(el);
		}
	}
	if (groupWindow.father.userWindows == undefined) {
		groupWindow.father.userWindows = [];
	}
	
	//users store
	var store = new Automne.JsonStore({
		url: 			'users-datas.php',
		root: 			'users',
		totalProperty:	'totalCount',
		id:				'id',
		remoteSort:		true,
		fields:			['id', 'lastName', 'firstName', 'email', 'active', 'belong'],
		listeners:		{
			'load': 		function(store, records, options){
				//select all records which user belong to
				sm.selectRecords(store.query('belong', true).getRange());
				//resume events
				sm.resumeEvents();
			},
			'beforeload': 	function(store, options){ 
				//suspend events to avoid select events to be fired on store reload
				sm.suspendEvents();
				//append search parameters if missing
				if (options.params.search == undefined || options.params.filter == undefined || options.params.groupId == undefined) {
					var search = Ext.getCmp('groupSearch-{$groupId}');
					options.params.search = (search) ? search.getValue() : '';
					options.params.filter = (filterGroupsUsers) ? 1 : 0;
					options.params.groupId = groupWindow.groupId;
					options.params.withoutroot = 1;
				}
				return true;
			}
		}
	});
	//selection model
	var sm = new Ext.grid.CheckboxSelectionModel({header:'', checkOnly:true});
	//set groups selection change events
	sm.on({
		'rowselect':{fn:function(sm, index, record) {
			Automne.server.call('groups-controler.php', Ext.emptyFn, {
				groupId:		this.groupId,
				action:			'adduser',
				userId:			record.id
			});
		},scope:groupWindow},
		'rowdeselect':{fn:function(sm, index, record) {
			Automne.server.call('groups-controler.php', Ext.emptyFn, {
				groupId:		this.groupId,
				action:			'deluser',
				userId:			record.id
			});
		},scope:groupWindow}
	});
	//filter function
	var filter = function(){
		//get search field value
		var search = Ext.getCmp('groupSearch-{$groupId}');
		//load of groups store
		store.load({
			params:		{
				start:			0,
				limit:			{$recordsPerPage},
				search:			(search) ? search.getValue() : '',
				filter:			(filterGroupsUsers) ? 1 : 0,
				groupId:		groupWindow.groupId,
				withoutroot:	1
			}
		});
	}
	var filterGroupsUsers = true;
	//create center panel
	var center = new Ext.TabPanel({
		activeTab:			 0,
		id:					'groupPanels-{$groupId}',
		region:				'center',
		border:				false,
		enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		listeners: {'beforetabchange' : function(tabPanel, newTab, currentTab ) {
			if (newTab.id == 'groupUsers-{$groupId}') {
				//(re)load of groups store
				filter();
			} else if (newTab.id != 'groupProfile-{$groupId}') {
				//reload panel content
				if (newTab.rendered && newTab.body.updateManager) {
					newTab.body.updateManager.update(newTab.autoLoad);
				}
			}
			return true;
		}},
		items:[{
			title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_GROUP_PROFILE)}',
			id:					'groupIdentityPanel-{$groupId}',
			autoScroll:			true,
			layout: 			'accordion',
			border:				false,
			bodyBorder: 		false,
			defaults: {
				// applied to each contained panel
				bodyStyle: 			'padding:5px',
				border:				false
			},
			layoutConfig: {
				// layout-specific configs go here
				animate: 			true
			},
			items:[{
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_GROUP_PROFILE)}',
				id:				'groupIdentityAccordion-{$groupId}',
				layout: 		'form',
				xtype:			'atmForm',
				url:			'groups-controler.php',
				collapsible:	true,
				labelAlign:		'right',
				defaultType:	'textfield',
				buttonAlign:	'center',
				autoScroll:		true,
				defaults: {
					xtype:			'textfield',
					anchor:			'97%',
					allowBlank:		false
				},
				items:[{
					fieldLabel:		'<span class=\"atm-red\">*</span> {$cms_language->getMessage(MESSAGE_PAGE_LABEL)}',
					name:			'label',
					xtype:			'textfield',
					{$labelValue}
					allowBlank:		false
				},{
					fieldLabel:		'{$cms_language->getMessage(MESSAGE_PAGE_DESC)}',
					name:			'description',
					xtype:			'textarea',
					value:			'{$description}',
					allowBlank:		true
				}],
				buttons:[{
					text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
					iconCls:		'atm-pic-validate',
					name:			'submitIdentity',
					anchor:			'',
					scope:			this,
					handler:		function() {
						var form = Ext.getCmp('groupIdentityAccordion-{$groupId}').getForm();
						if (form.isValid()) {
							form.submit({
								params:{
									action:		'identity',
									groupId:	groupWindow.groupId
								},
								success:function(form, action){
									//if it is a successful group creation
									if (action.result.success != false && isNaN(parseInt(groupWindow.groupId))) {
										//set groupId
										groupWindow.groupId = action.result.success.groupId;
										//display hidden elements
										Ext.getCmp('groupPanels-{$groupId}').items.each(function(panel) {
											if (panel.disabled) {
												panel.enable();
												if (panel.autoLoad) {
													panel.autoLoad.params.groupId = groupWindow.groupId;
												}
											}
										});
										Ext.getCmp('groupIdentityPanel-{$groupId}').items.each(function(panel) {
											if (panel.disabled) {
												panel.enable();
											}
										});
									}
								},
								scope:this
							});
						} else {
							Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES)}', '', groupWindow);
						}
					}
				}]
			}{$modulesAccordion}]
		}{$usersTab}{$modulesTab}{$adminTab}]
	});
	
	groupWindow.add(center);
	//redo windows layout
	groupWindow.doLayout();
	
	//disable all elements not usable in first group creation step
	if (isNaN(parseInt(groupWindow.groupId))) {
		Ext.getCmp('groupPanels-{$groupId}').items.each(function(panel) {
			if (panel.id != 'groupIdentityPanel-{$groupId}') {
				panel.disable();
			}
		});
		Ext.getCmp('groupIdentityPanel-{$groupId}').items.each(function(panel) {
			if (panel.id != 'groupIdentityAccordion-{$groupId}') {
				panel.disable();
			}
		});
	}
	/*if (Ext.isIE) {
		center.syncSize(); //needed for IE7
	}*/
END;
$view->addJavascript($jscontent);
$view->show();
?>