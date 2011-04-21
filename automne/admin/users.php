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
// $Id: users.php,v 1.8 2010/03/08 16:41:22 sebastien Exp $

/**
  * PHP page : Load users search window.
  * Used accross an Ajax request. Render users search.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);

define("MESSAGE_PAGE_NO_GROUP", 1336);
define("MESSAGE_PAGE_USERS_LABEL", 926);
define("MESSAGE_PAGE_LASTNAME_LABEL", 94);
define("MESSAGE_PAGE_FIRSTNAME", 93);
define("MESSAGE_PAGE_GROUPS", 837);
define("MESSAGE_PAGE_LOGIN", 54);
define("MESSAGE_PAGE_EMAIL", 102);
define("MESSAGE_PAGE_ACTIVE", 410);
define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_DISACTIVATE", 155);
define("MESSAGE_PAGE_ACTIVATE", 156);
define("MESSAGE_PAGE_DELETE", 252);
define("MESSAGE_PAGE_DELETE_USER_QUESTION", 411);
define("MESSAGE_PAGE_X_USER_ON", 412);
define("MESSAGE_PAGE_NO_USER_SEARCH", 413);
define("MESSAGE_PAGE_FILTER", 322);
define("MESSAGE_PAGE_BY_NAME_FIRSTNAME_REFERENCE", 414);
define("MESSAGE_PAGE_BY_LETTER", 406);
define("MESSAGE_PAGE_BY_GROUP", 415);
define("MESSAGE_PAGE_NO_GROUP_NOW", 416);
define("MESSAGE_PAGE_CREATE_USER", 417);
define("MESSAGE_PAGE_YES", 1082);
define("MESSAGE_PAGE_NO", 1083);
define("MESSAGE_PAGE_USER_SYSTEM", 521);
define("MESSAGE_PAGE_REACTIVATE_USER", 522);
define("MESSAGE_PAGE_DISABLE_USER", 523);

$winId = sensitiveIO::request('winId', '', 'usersPanel');
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
//special users Id
$rootProfileUserId = ROOT_PROFILEUSER_ID;
$anonymousProfileUserId = ANONYMOUS_PROFILEUSER_ID;

//user groups
$userGroups = array();
$userGroups['groups'] = array(array(
	'id'			=> 0,
	'label'			=> '-',
	'description'	=> '{$cms_language->getJsMessage(MESSAGE_PAGE_NO_GROUP)}',
));
$groups = CMS_profile_usersGroupsCatalog::getAll();
foreach ($groups as $group) {
	$userGroups['groups'][] = array(
		'id'			=> $group->getGroupId(),
		'label'			=> $group->getLabel(),
		'description'	=> $group->getDescription(),
	);
}
//json encode groups datas
$userGroups = sensitiveIO::jsonEncode($userGroups);

//users letters
$letters = CMS_profile_usersCatalog::getLettersForLastName();
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
	var usersWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	
	//users store
	var store = new Automne.JsonStore({
		url: 			'users-datas.php',
		root: 			'users',
		totalProperty:	'totalCount',
		id:				'id',
		remoteSort:		true,
		fields:			['id', 'firstName', 'lastName', 'groups', 'active', 'login', 'email'],
		listeners:		{
			'load': 		{fn:function(store, records, options){
				//select first row if none selected
				if (sm.getCount() == 0) sm.selectRow(0);
				//if no row selected, disable all buttons
				if (sm.getCount() == 0) {
					Ext.getCmp('editUser').disable();
					Ext.getCmp('desactivateUser').hide();
					Ext.getCmp('activateUser').hide();
					Ext.getCmp('deleteUser').disable();
				}
			}},
			'beforeload': 	{fn:function(store, options){ 
				//append search parameters if missing
				if (options.params.groupId == undefined || options.params.search  == undefined || options.params.letter  == undefined) {
					var formValues = Ext.getCmp('usersSearchPanel').getForm().getValues();
					options.params.groups = 1;
					options.params.groupId = formValues.groups;
					options.params.search = formValues.search;
					options.params.filter =	(formValues.groups) ? true : false;
					options.params.letter = (clickedLetter) ? clickedLetter.text.toLowerCase() : '';
				}
				return true;
			}}
		}
	});
	
	//validations types
	var groupsStore = new Ext.data.JsonStore({
		id:				'id',
		root: 			'groups',
		fields: 		['id', 'label', 'description'],
		data:			{$userGroups},
		listeners:		{
			'load': 		{fn:function(store, records, options){
				var groupsCombo = Ext.getCmp('groupsField');
				//if store is empty, reset the combo
				if (store.totalLength == 0) groupsCombo.disable();
			}}
		}
	});
	
	usersWindow.editGroup = function(groupId, el) {
		el = Ext.get(el);
		var fatherWindow = Ext.getCmp('{$fatherId}');
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
					if (fatherWindow.groupsWindow && fatherWindow.groupsWindow.launchSearch) {
						fatherWindow.groupsWindow.launchSearch();
					}
				}}
			});
			//display window
			fatherWindow.groupWindows[groupId].show(el);
		}
	}
	//renderer for groups names
	var renderGroups = function(groups) {
		var stringGroups = '', groupsLength = groups.length;
		if (groupsLength) {
			for (var i = 0; i < groupsLength; i++) stringGroups += '<a class="atm-help" ext:qtip="'+ groups[i].description +'" onclick="var usersWindow = Ext.getCmp(\'{$winId}\');usersWindow.editGroup('+ groups[i].id +', this);">'+ groups[i].label +'</a>, ';
			stringGroups = stringGroups.substr(0, (stringGroups.length -2));
		}
		return stringGroups;
	}
	var sm = new Ext.grid.RowSelectionModel({singleSelect:true});
	if (fatherWindow.groupWindows == undefined) {
		fatherWindow.groupWindows = [];
	}
	if (fatherWindow.userWindows == undefined) {
		fatherWindow.userWindows = [];
	}
	//results grid
	var grid = new Ext.grid.GridPanel({
		id:					'usersResultsGrid',
		title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_USERS_LABEL)}',
		store: 				store,
		border:				false,
		autoExpandColumn:	'groups',
		cm: 				new Ext.grid.ColumnModel([
			{header: "ID", 															width: 30, 	dataIndex: 'id', 		sortable: true, 	hidden:true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_LASTNAME_LABEL)}", 	width: 80, 	dataIndex: 'lastName', 	sortable: true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_FIRSTNAME)}", 		width: 80, 	dataIndex: 'firstName', sortable: true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_GROUPS)}", 			width: 120,	dataIndex: 'groups', 	sortable: false,					renderer:renderGroups},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_LOGIN)}", 			width: 80, 	dataIndex: 'login', 	sortable: true, 	hidden:true},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_EMAIL)}", 			width: 120, dataIndex: 'email', 	sortable: false, 	hidden:true, 	renderer:function(value) {return '<a href="mailto:'+value+'">'+value+'</a>';}},
			{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_ACTIVE)}", 			width: 20, 	dataIndex: 'active', 	sortable: true, 					renderer:function(value) {return value == 1 ? '{$cms_language->getJSMessage(MESSAGE_PAGE_YES)}' : '{$cms_language->getJSMessage(MESSAGE_PAGE_NO)}';}}
		]),
		sm: 				sm,
		anchor:				'100%',
		viewConfig: 		{
			forceFit:			true
		},
		tbar:[new Ext.Button({
			id:			'editUser',
			iconCls:	'atm-pic-modify',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_MODIFY)}',
			handler:	function(button) {
				if (sm.getSelected().id) {
					var userId = sm.getSelected().id;
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
								if (usersWindow && usersWindow.launchSearch) {
									usersWindow.launchSearch();
								}
							}}
						});
						//display window
						fatherWindow.userWindows[userId].show(button.getEl());
					}
				}
			},
			scope:		usersWindow,
			disabled:	true
		}),new Ext.Button({
			id:			'deleteUser',
			iconCls:	'atm-pic-deletion',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_DELETE)}',
			handler:	function(button) {
				var selectedUser = sm.getSelected();
				if (selectedUser.id) {
					Automne.message.popup({
						msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_DELETE_USER_QUESTION)} '+ selectedUser.data.firstName +' '+ selectedUser.data.lastName +' ?',
						buttons: 			Ext.MessageBox.OKCANCEL,
						animEl: 			button.getEl(),
						closable: 			false,
						icon: 				Ext.MessageBox.QUESTION,
						fn: 				function (button) {
							if (button == 'ok') {
								Automne.server.call('users-controler.php', function() {store.reload();}, {
									userId:			sm.getSelected().id,
									action:			'delete'
								});
							}
						}
					});
				}
			},
			scope:		usersWindow,
			disabled:	true
		}),new Ext.Button({
			id:			'desactivateUser',
			iconCls:	'atm-pic-disable',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_DISACTIVATE)}',
			handler:	function() {
				if (sm.getSelected().id) {
					Automne.server.call('users-controler.php', function() {
							store.reload();
							Ext.getCmp('desactivateUser').hide();
							Ext.getCmp('activateUser').show();
						}, {
							userId:			sm.getSelected().id,
							action:			'disactivate'
						}
					);
				}
			},
			scope:		usersWindow,
			hidden:		true
		}),new Ext.Button({
			id:			'activateUser',
			iconCls:	'atm-pic-enable',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTIVATE)}',
			handler:	function() {
				if (sm.getSelected().id) {
					Automne.server.call('users-controler.php', function() {
							store.reload();
							Ext.getCmp('activateUser').hide();
							Ext.getCmp('desactivateUser').show();
						}, {
							userId:			sm.getSelected().id,
							action:			'activate'
						}
					);
				}
			},
			scope:		usersWindow,
			hidden:		true
		}), '->', new Ext.Button({
			id:			'createUser',
			iconCls:	'atm-pic-add',
			text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_CREATE_USER)}',
			handler:	function(button) {
				//create window element
				fatherWindow.userWindows[0] = new Automne.Window({
					id:				'userWindowCreate',
					modal:			false,
					father:			fatherWindow,
					autoLoad:		{
						url:			'user.php',
						params:			{
							winId:			'userWindowCreate'
						},
						nocache:		true,
						scope:			this
					},
					listeners:{'close':function(window){
						delete fatherWindow.userWindows[0];
						//refresh search list
						if (usersWindow && usersWindow.launchSearch) {
							usersWindow.launchSearch();
						}
						//enable button to allow creation of a other users
						Ext.getCmp('createUser').enable();
					}}
				});
				//display window
				fatherWindow.userWindows[0].show(button.getEl());
				//disable button to avoid creation of a second user
				button.disable();
			},
			scope:		usersWindow
		})],
		bbar:				new Ext.PagingToolbar({
			pageSize: 			{$recordsPerPage},
			store: 				store,
			displayInfo: 		true,
			displayMsg: 		'{$cms_language->getJSMessage(MESSAGE_PAGE_X_USER_ON)}',
			emptyMsg: 			"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_USER_SEARCH)}"
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
		usersWindow.launchSearch();
	}
	var lettersToolbar = {
		xtype:	'toolbar',
		style:	'background:#FFFFFF;border-color:#FFFFFF;',
		items:	[{$lettersButtons}]
	};
	//define search function into window (to be accessible by parent window)
	usersWindow.launchSearch = function() {
		var formValues = Ext.getCmp('usersSearchPanel').getForm().getValues();
		store.reload({params:{
			start:			store.lastOptions.params.start,
			limit:			{$recordsPerPage},
			groupId:		formValues.groups,
			search:			formValues.search,
			letter:			(clickedLetter) ? clickedLetter.text.toLowerCase() : '',
			filter:			(formValues.groups) ? true : false,
			groups:			1
		}});
	}
	
	var center = new Ext.Panel({
		region:				'center',
		border: 			false,
		layout: 			'anchor',
		items: [{
				id: 			'usersSearchPanel',
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_FILTER)}',
				xtype:			'form',
				height:			170,
				anchor:			'100%',
				border:			false,
				bodyStyle: {
					background: 	'#ffffff',
					padding: 		'5px'
				},
				labelAlign: 	'top',
				keys: {
					key: 			Ext.EventObject.ENTER,
					handler: 		usersWindow.launchSearch,
					scope:			usersWindow
				},
				items:[{
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_BY_NAME_FIRSTNAME_REFERENCE)}',
					xtype:			'textfield',
					name: 			'search',
					anchor:			'100%',
					listeners:		{'valid':{
						fn: 			usersWindow.launchSearch, 
						options:		{buffer:300}
					}}
		        },{
		            text: 			'{$cms_language->getJSMessage(MESSAGE_PAGE_BY_LETTER)}',
		            xtype:			'label',
					name: 			'letter',
					cls:			'x-form-item',
					style:			'padding:0;margin:0',
					anchor:			'100%'
		        },lettersToolbar,{
					xtype:				'combo',
					id:					'groupsField',
					name:				'groups',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_BY_GROUP)}',
					anchor:				'100%',
					forceSelection:		true,
					mode:				'local',
					triggerAction:		'all',
					valueField:			'id',
					hiddenName: 		'groups',
					displayField:		'label',
					store:				groupsStore,
					valueNotFoundText:	'{$cms_language->getJSMessage(MESSAGE_PAGE_NO_GROUP_NOW)}',
					allowBlank: 		true,
					selectOnFocus:		true,
					editable:			true,
					typeAhead:			true,
					tpl: 				'<tpl for="."><div ext:qtip="{description}" class="x-combo-list-item">{label}</div></tpl>',
					listeners:		{'valid':usersWindow.launchSearch}
		        }]
			},grid
		]
	});
	usersWindow.add(center);
	
	//first load of users store
	store.load({
		params:		{
			start:			0,
			limit:			{$recordsPerPage},
			groupId:		0,
			search:			'',
			letter:			'',
			groups:			1
		}
	});
	//set resize event to fix grid size
	usersWindow.on('resize', function(panel, width, height, rawwidth, rawheight){
		Ext.getCmp('usersResultsGrid').setHeight(height - 170);
	});
	//redo windows layout
	usersWindow.doLayout();
	usersWindow.syncSize();
	
	//add selection events to selection model
	var qtips = [];
	qtips['delete'] = new Ext.ToolTip({
		target: 		Ext.getCmp('deleteUser').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_PAGE_USER_SYSTEM)}'
	});
	qtips['activate'] = new Ext.ToolTip({
		target: 		Ext.getCmp('activateUser').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_PAGE_REACTIVATE_USER)}'
	});
	qtips['desactivate'] = new Ext.ToolTip({
		target: 		Ext.getCmp('desactivateUser').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_PAGE_DISABLE_USER)}'
	});
	//add selection events to selection model
	sm.on('rowselect', function(sm, rowIdx, r) {
		qtips['delete'].disable();
		qtips['activate'].disable();
		qtips['desactivate'].disable();
		if (r.data.active == 1) {
			Ext.getCmp('editUser').enable();
			Ext.getCmp('desactivateUser').show();
			qtips['desactivate'].enable();
			Ext.getCmp('activateUser').hide();
			Ext.getCmp('deleteUser').enable();
		} else {
			Ext.getCmp('editUser').enable();
			Ext.getCmp('desactivateUser').hide();
			Ext.getCmp('activateUser').show();
			qtips['activate'].enable();
			Ext.getCmp('deleteUser').enable();
		}
		//can't delete or desactivate special users
		if (r.data.id == {$rootProfileUserId} || r.data.id == {$anonymousProfileUserId}) {
			Ext.getCmp('desactivateUser').hide();
			Ext.getCmp('activateUser').hide();
			Ext.getCmp('deleteUser').disable();
			qtips['delete'].enable();
		}
	});
END;
$view->addJavascript($jscontent);
$view->show();
?>