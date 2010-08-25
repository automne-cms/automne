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
// $Id: logs.php,v 1.4 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load users search window.
  * Used accross an Ajax request. Render users search.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_TITLE",20);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_TOOLBAR_HELP_DESC", 1569);
define("MESSAGE_PAGE_FILTER", 322);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_FIELD_DATE", 905);
define("MESSAGE_PAGE_FIELD_ACTION", 906);
define("MESSAGE_PAGE_FIELD_COMMENTS", 907);
define("MESSAGE_PAGE_FIELD_USER", 908);
define("MESSAGE_PAGE_FIELD_STATUS", 909);
define("MESSAGE_PAGE_ACTIONS", 162);
define("MESSAGE_PAGE_TYPE_IDENTIFICATION", 1575);
define("MESSAGE_PAGE_TYPE_EMAILS", 1574);
define("MESSAGE_PAGE_TYPE_ALL", 1576);
define("MESSAGE_PAGE_TYPE_ADMIN", 1577);
define("MESSAGE_PAGE_TYPE_PUBLICATION", 1578);
define("MESSAGE_PAGE_FIELD_ELEMENT", 1579);
define("MESSAGE_PAGE_ACTION_X_ON_Y", 1580);
define("MESSAGE_PAGE_NO_ACTION", 1581);
define("MESSAGE_PAGE_FIELD_BY_MODULE", 1582);
define("MESSAGE_PAGE_FIELD_BY_USER", 1583);
define("MESSAGE_PAGE_FIELD_BY_TYPE", 1584);
define("MESSAGE_PAGE_FIELD_BY_PAGE_DESC", 1585);
define("MESSAGE_PAGE_FIELD_BY_PAGE", 1586);
define("MESSAGE_ACTION_PURGE", 1587);
define("MESSAGE_ACTION_PURGE_DESC", 1588);
define("MESSAGE_ACTION_PURGE_CONFIRM", 1589);

$winId = sensitiveIO::request('winId', '', 'logsWindow');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	CMS_grandFather::raiseError('User has no logs management rights ...');
	$view->show();
}

//get records / pages
$recordsPerPage = $_SESSION["cms_context"]->getRecordsPerPage();

//users
$users = array();
$users['users'] = array(array(
	'id'			=> 0,
	'name'			=> '-'
));
$allUsers = CMS_profile_usersCatalog::getUsersLabels();
foreach ($allUsers as $id => $fullname) {
	$users['users'][] = array(
		'id'			=> $id,
		'name'			=> $fullname
	);
}
//json encode groups datas
$users = sensitiveIO::jsonEncode($users);

//modules
$modules = array();
$allModules = CMS_modulesCatalog::getAll();
$modules['modules'] = array(array(
	'codename'			=> '',
	'label'				=> '-'
));
$modules['modules'][] = array(
	'codename'		=> MOD_STANDARD_CODENAME,
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL)
);
foreach ($allModules as $module) {
	if ($module->getCodename() != MOD_STANDARD_CODENAME) {
		$modules['modules'][] = array(
			'codename'		=> $module->getCodename(),
			'label'			=> $module->getLabel($cms_language)
		);
	}
}
//json encode groups datas
$modules = sensitiveIO::jsonEncode($modules);

//types
$types = array();
$types['types'][] = array(
	'id'			=> 'all',
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_TYPE_ALL)
);
$types['types'][] = array(
	'id'			=> 'admin',
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_TYPE_ADMIN)
);
$types['types'][] = array(
	'id'			=> 'resource',
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_TYPE_PUBLICATION)
);
$types['types'][] = array(
	'id'			=> 'login',
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_TYPE_IDENTIFICATION)
);
$types['types'][] = array(
	'id'			=> 'email',
	'label'			=> $cms_language->getMessage(MESSAGE_PAGE_TYPE_EMAILS)
);
//json encode groups datas
$types = sensitiveIO::jsonEncode($types);

if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$purgeLogs = "tbar:['->',{
			xtype:		'button',
			iconCls:	'atm-pic-deletion',
			text:		'{$cms_language->getJsMessage(MESSAGE_ACTION_PURGE)}',
			tooltip:	'{$cms_language->getJsMessage(MESSAGE_ACTION_PURGE_DESC)}',
			handler:	function(button) {
				Automne.message.popup({
					msg: 				'{$cms_language->getJsMessage(MESSAGE_ACTION_PURGE_CONFIRM)}',
					buttons: 			Ext.MessageBox.OKCANCEL,
					animEl: 			button.getEl(),
					closable: 			false,
					icon: 				Ext.MessageBox.WARNING,
					fn: 				function (button) {
						if (button == 'ok') {
							var formValues = Ext.getCmp('logsSearchPanel').getForm().getValues();
							params = Ext.apply(formValues, {
								del:			true,
								limit:			0,
								start:			0
							});
							Automne.server.call('logs-datas.php', function() {
								logWindow.launchSearch();
							}, params);
						}
					}
				});
			}
		}],";
} else {
	$purgeLogs = '';
}

$jscontent = <<<END
	var logWindow = Ext.getCmp('{$winId}');
	
	//set window title
	logWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}');
	//set help button on top of page
	logWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		logWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
    });
	
	//users store
	var store = new Automne.JsonStore({
		url: 			'logs-datas.php',
		root: 			'logs',
		totalProperty:	'totalCount',
		id:				'id',
		remoteSort:		true,
		fields:			['id', 'element', 'datetime', 'action', 'user', 'userId', 'status', 'comment'],
		listeners:		{
			'beforeload': 	{fn:function(store, options){ 
				//append search parameters
				var formValues = Ext.getCmp('logsSearchPanel').getForm().getValues();
				options.params = Ext.apply(options.params, formValues, {
					limit:			{$recordsPerPage}
				});
				if (!options.params.start) {
					options.params.start = 0;
				}
				return true;
			}}
		}
	});
	//renderer for user names
	var renderUser = function(fullname, cell, user) {
		return '<a href="#" onclick="Automne.view.user(' + user.data.userId + ');return false;">' + fullname + '</a>';
	}
	var renderComment = function(comment){
		return '<span ext:qtip="' + comment + '">' + comment + '</span>';
	}
	var sm = new Ext.grid.RowSelectionModel({singleSelect:true});
	//results grid
	var grid = new Ext.grid.GridPanel({
		id:					'logsResultsGrid',
		title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_ACTIONS)}',
		store: 				store,
		border:				false,
		flex:				1,
		autoExpandColumn:	'comment',
		cm: 				new Ext.grid.ColumnModel([
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_DATE)}", 			width: 90, 	dataIndex: 'datetime',	sortable: true},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_ELEMENT)}", 		width: 90,	dataIndex: 'element',	sortable: false},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_ACTION)}", 			width: 120, dataIndex: 'action',	sortable: true},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_USER)}", 	width: 110,	dataIndex: 'user',		sortable: true,		renderer:renderUser},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_STATUS)}", 	width: 35, 	dataIndex: 'status',	sortable: false},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_COMMENTS)}", 	width: 120, dataIndex: 'comment',	sortable: false,	renderer:renderComment},
		]),
		sm: 				sm,
		viewConfig: 		{
			forceFit:			true
		},
		{$purgeLogs}
		bbar:				new Ext.PagingToolbar({
			pageSize: 			{$recordsPerPage},
			store: 				store,
			displayInfo: 		true,
			displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_ACTION_X_ON_Y)}',
			emptyMsg: 			"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_ACTION)}"
		})
	});
	//define search function into window (to be accessible by parent window)
	var launchSearch = false;
	logWindow.launchSearch = function() {
		if (launchSearch) {
			store.reload();
		}
	}
	//users store
	var usersStore = new Ext.data.JsonStore({
		id:				'id',
		root: 			'users',
		fields: 		['id', 'name'],
		data:			{$users},
		listeners:		{
			'load': 		{fn:function(store, records, options){
				var usersField = Ext.getCmp('usersField');
				//if store is empty, reset the combo
				if (store.totalLength == 0) usersField.disable();
			}}
		}
	});
	
	//modules store
	var modulesStore = new Ext.data.JsonStore({
		id:				'id',
		root: 			'modules',
		fields: 		['codename', 'label'],
		data:			{$modules}
	});
	
	//type store
	var typesStore = new Ext.data.JsonStore({
		id:				'id',
		root: 			'types',
		fields: 		['id', 'label'],
		data:			{$types}
	});
	
	var center = new Ext.Panel({
		region:				'center',
		border: 			false,
		layoutConfig: {
			align : 'stretch',
			pack  : 'start'
		},
		layout: 			'vbox',
		items: [{
				id: 			'logsSearchPanel',
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_FILTER)}',
				xtype:			'form',
				height:			220,
				border:			false,
				bodyStyle: {
					background: 	'#ffffff',
					padding: 		'5px'
				},
				labelAlign: 	'top',
				keys: {
					key: 			Ext.EventObject.ENTER,
					handler: 		logWindow.launchSearch,
					scope:			logWindow
				},
				items:[{
					xtype:				'combo',
					id:					'modulesField',
					name:				'module',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_BY_MODULE)}',
					anchor:				'100%',
					forceSelection:		true,
					mode:				'local',
					triggerAction:		'all',
					valueField:			'codename',
					hiddenName: 		'module',
					displayField:		'label',
					store:				modulesStore,
					allowBlank: 		true,
					selectOnFocus:		true,
					editable:			false,
					typeAhead:			false,
					listeners:			{
						'valid':function(field){
							logWindow.launchSearch();
							if (field.hiddenField.value == 'standard') {
								Ext.getCmp('logPageSelect').enable();
							} else {
								Ext.getCmp('logPageSelect').disable();
							}
						}
					}
		        },{
					xtype:				'atmPageField',
					id:					'logPageSelect',
					fieldLabel:			'<span class="atm-help" ext:qtip="{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_BY_PAGE_DESC)}">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_BY_PAGE)}</span>',
					name:				'page',
					disabled:			true,
					value:				'',
					width:				200,
					anchor:				false,
					allowBlank:			true,
					validateOnBlur:		false,
					listeners:			{'valid':{
						fn: 				logWindow.launchSearch,
						options:			{buffer:300}
					}}
				},{
					xtype:				'combo',
					id:					'usersField',
					name:				'userId',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_BY_USER)}',
					anchor:				'100%',
					forceSelection:		true,
					mode:				'local',
					triggerAction:		'all',
					valueField:			'id',
					hiddenName: 		'userId',
					displayField:		'name',
					store:				usersStore,
					allowBlank: 		true,
					selectOnFocus:		true,
					editable:			false,
					typeAhead:			false,
					listeners:			{'valid':logWindow.launchSearch}
		        },{
					xtype:				'combo',
					id:					'typeField',
					name:				'type',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_BY_TYPE)}',
					anchor:				'100%',
					forceSelection:		true,
					mode:				'local',
					triggerAction:		'all',
					valueField:			'id',
					hiddenName: 		'type',
					displayField:		'label',
					store:				typesStore,
					allowBlank: 		true,
					selectOnFocus:		true,
					editable:			false,
					typeAhead:			false,
					value:				'all',
					listeners:			{'valid':logWindow.launchSearch}
		        }]
			},grid
		]
	});
	logWindow.add(center);
	//redo windows layout
	logWindow.doLayout();
	
	launchSearch = true;
	setTimeout(function(){
		logWindow.launchSearch();
	}, 500);
END;
$view->addJavascript($jscontent);
$view->show();
?>