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
// $Id: groups.php,v 1.6 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load groups search window.
  * Used accross an Ajax request. Render groups search.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_DESC", 139);
define("MESSAGE_PAGE_N_USERS", 400);
define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_DELETE", 854);

define("MESSAGE_PAGE_USER_GROUPS", 401);
define("MESSAGE_PAGE_DELETE_GROUP_QUESTION", 402);
define("MESSAGE_PAGE_X_GROUP_ON", 403);
define("MESSAGE_PAGE_NO_GROUP_SEARCH", 404);
define("MESSAGE_PAGE_FILTER", 322);
define("MESSAGE_PAGE_BY_LABEL", 405);
define("MESSAGE_PAGE_BY_LETTER", 406);
define("MESSAGE_PAGE_CREATE_NEW_GROUP", 407);
define("MESSAGE_PAGE_ERROR_DELETE_GROUP", 1447);

$winId = sensitiveIO::request('winId', '', 'groupsPanel');
$fatherId = sensitiveIO::request('fatherId', '', 'usersGroupsWindow');

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

//get records / pages
$recordsPerPage = $_SESSION["cms_context"]->getRecordsPerPage();

//groups letters
$letters = CMS_profile_usersGroupsCatalog::getLettersForTitle();
//$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$lettersButtons = '';
foreach ($letters as $letter) {
	$lettersButtons .= '{
		text:			\''. io::strtoupper($letter) .'\',
		enableToggle:	true,
		handler:		clickLetter
	},';
}
//remove last comma
$lettersButtons = io::substr($lettersButtons, 0, -1);

$jscontent = <<<END
	var groupsWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	
	//groups store
	var store = new Automne.JsonStore({
		url: 			'groups-datas.php',
		root: 			'groups',
		totalProperty:	'totalCount',
		id:				'id',
		remoteSort:		true,
		fields:			['id', 'label', 'description', 'users'],
		listeners:		{
			'load': 		{fn:function(store, records, options){
				//select first row if none selected
				if (sm.getCount() == 0) sm.selectRow(0);
				//if no row selected, disable all buttons
				if (sm.getCount() == 0) {
					Ext.getCmp('editGroup').disable();
					Ext.getCmp('deleteGroup').disable();
				}
			}},
			'beforeload': 	{fn:function(store, options){ 
				//append search parameters if missing
				if (options.params.search  == undefined || options.params.letter  == undefined) {
					var formValues = Ext.getCmp('groupsSearchPanel').getForm().getValues();
					options.params.search = formValues.search;
					options.params.letter = (clickedLetter) ? clickedLetter.text.toLowerCase() : '';
				}
				return true;
			}}
		}
	});
	
	var sm = new Ext.grid.RowSelectionModel({singleSelect:true});
	if (fatherWindow.groupWindows == undefined) {
		fatherWindow.groupWindows = [];
	}
	//results grid
	var grid = new Ext.grid.GridPanel({
		id:					'groupsResultsGrid',
		title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_USER_GROUPS)}',
		store: 				store,
		border:				false,
		autoExpandColumn:	'description',
		cm: 				new Ext.grid.ColumnModel([
			{header: "ID", 														width: 30, 	dataIndex: 'id', 			sortable: true, 	hidden:true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_LABEL)}", 		width: 50, 	dataIndex: 'label', 		sortable: true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_DESC)}", 		width: 170, dataIndex: 'description',	sortable: true, 					renderer:function(value) {return '<span ext:qtip="'+value+'">'+value+'</span>';}},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_N_USERS)}", 	width: 30,	dataIndex: 'users', 		sortable: false}
		]),
		sm: 				sm,
		anchor:				'100%',
		viewConfig: 		{
			forceFit:			true
		},
		tbar:[new Ext.Button({
			id:			'editGroup',
			iconCls:	'atm-pic-modify',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_MODIFY)}',
			handler:	function(button) {
				if (sm.getSelected().id) {
					var fatherWindow = Ext.getCmp('{$fatherId}');
					var groupId = sm.getSelected().id;
					if (fatherWindow.groupWindows[groupId]) {
						Ext.WindowMgr.bringToFront(fatherWindow.groupWindows[groupId]);
					} else {
						//create window element
						fatherWindow.groupWindows[groupId] = new Automne.Window({
							id:				'groupWindow'+groupId,
							modal:			false,
							father:			fatherWindow,
							autoLoad:		{
								url:			'group.php',
								params:			{
									winId:			'groupWindow'+groupId,
									groupId:		groupId
								},
								nocache:		true,
								scope:			this
							},
							listeners:{'close':function(window){
								delete fatherWindow.groupWindows[window.id.substr(11)];
								//refresh search list
								if (groupsWindow && groupsWindow.launchSearch) {
									groupsWindow.launchSearch();
								}
							}}
						});
						//display window
						fatherWindow.groupWindows[groupId].show(button.getEl());
					}
				}
			},
			scope:		groupsWindow,
			disabled:	true
		}),new Ext.Button({
			id:			'deleteGroup',
			iconCls:	'atm-pic-deletion',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_DELETE)}',
			handler:	function(button) {
				var selectedGroup = sm.getSelected();
				if (selectedGroup.id) {
					Automne.message.popup({
						msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_DELETE_GROUP_QUESTION)}'+ selectedGroup.data.label +' ?',
						buttons: 			Ext.MessageBox.OKCANCEL,
						animEl: 			button.getEl(),
						closable: 			false,
						icon: 				Ext.MessageBox.QUESTION,
						fn: 				function (button) {
							if (button == 'ok') {
								Automne.server.call('groups-controler.php', function() {store.reload();}, {
									groupId:		sm.getSelected().id,
									action:			'delete'
								});
							}
						}
					});
				}
			},
			scope:		groupsWindow,
			disabled:	true
		}), '->', new Ext.Button({
			id:			'createGroup',
			iconCls:	'atm-pic-add',
			text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CREATE_NEW_GROUP)}',
			handler:	function(button) {
				//create window element
				fatherWindow.groupWindows[0] = new Automne.Window({
					id:				'groupWindowCreate',
					modal:			false,
					father:			fatherWindow,
					autoLoad:		{
						url:			'group.php',
						params:			{
							winId:			'groupWindowCreate'
						},
						nocache:		true,
						scope:			this
					},
					listeners:{'close':function(window){
						delete fatherWindow.groupWindows[0];
						//refresh search list
						if (groupsWindow && groupsWindow.launchSearch) {
							groupsWindow.launchSearch();
						}
						//enable button to allow creation of a other groups
						Ext.getCmp('createGroup').enable();
					}}
				});
				//display window
				fatherWindow.groupWindows[0].show(button.getEl());
				//disable button to avoid creation of a second group
				button.disable();
			},
			scope:		groupsWindow
		})],
		bbar:				new Ext.PagingToolbar({
			pageSize: 			{$recordsPerPage},
			store: 				store,
			displayInfo: 		true,
			displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_X_GROUP_ON)}',
			emptyMsg: 			"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_GROUP_SEARCH)}"
		})
	});
	var clickedLetter;
	var clickLetter = function(clickedButton) {
		if (clickedButton.pressed) {
			if (clickedLetter) clickedLetter.toggle(false);
			clickedLetter = clickedButton;
		} else {
			clickedLetter = null;
		}
		groupsWindow.launchSearch();
	}
	var lettersToolbar = {
		xtype:	'toolbar',
		style:	'background:#FFFFFF;border-color:#FFFFFF;',
		items:	[{$lettersButtons}]
	};
	//define search function into window (to be accessible by parent window)
	groupsWindow.launchSearch = function() {
		var formValues = Ext.getCmp('groupsSearchPanel').getForm().getValues();
		store.reload({params:{
			start:			0,
			limit:			{$recordsPerPage},
			search:			formValues.search,
			letter:			(clickedLetter) ? clickedLetter.text.toLowerCase() : ''
		}});
	}
	
	var center = new Ext.Panel({
		region:				'center',
		border: 			false,
		layout: 			'anchor',
		items: [{
				id: 			'groupsSearchPanel',
				title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_FILTER)}',
				xtype:			'form',
				height:			120,
				anchor:			'100%',
				border:			false,
				bodyStyle: {
					background: 	'#ffffff',
					padding: 		'5px'
				},
				labelAlign: 	'top',
				keys: {
					key: 			Ext.EventObject.ENTER,
					handler: 		groupsWindow.launchSearch,
					scope:			groupsWindow
				},
				items:[{
					fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_BY_LABEL)}',
					xtype:			'textfield',
					name: 			'search',
					anchor:			'100%',
					listeners:		{'valid':{
						fn: 			groupsWindow.launchSearch, 
						options:		{buffer:300}
					}}
		        },{
		            text: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_BY_LETTER)}',
		            xtype:			'label',
					name: 			'letter',
					cls:			'x-form-item',
					style:			'padding:0;margin:0',
					anchor:			'100%'
		        },lettersToolbar
			]},grid
		]
	});
	groupsWindow.add(center);
	
	//first load of groups store
	store.load({
		params:		{
			start:			0,
			limit:			{$recordsPerPage},
			search:			'',
			letter:			''
		}
	});
	//set resize event to fix grid size
	groupsWindow.on('resize', function(panel, width, height, rawwidth, rawheight){
		Ext.getCmp('groupsResultsGrid').setHeight(height - 120);
	});
	//redo windows layout
	groupsWindow.doLayout();
	groupsWindow.syncSize();
	
	//add selection events to selection model
	var qtips = [];
	qtips['delete'] = new Ext.ToolTip({
		target: 		Ext.getCmp('deleteGroup').getEl(),
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_ERROR_DELETE_GROUP)}'
	});
	sm.on('rowselect', function(sm, rowIdx, r) {
		Ext.getCmp('editGroup').enable();
		//Ext.getCmp('deleteGroup').enable();
		if (r.data.users == 0) {
			Ext.getCmp('deleteGroup').enable();
			qtips['delete'].disable();
		} else {
			Ext.getCmp('deleteGroup').disable();
			qtips['delete'].enable();
		}
	});
END;
$view->addJavascript($jscontent);
$view->show();
?>