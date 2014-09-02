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
// $Id: user.php,v 1.9 2010/03/08 16:41:22 sebastien Exp $

/**
  * PHP page : Load user detail window.
  * Used accross an Ajax request. Render user informations.
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_DESC", 139);
define("MESSAGE_PAGE_N_USERS", 400);
define("MESSAGE_TOOLBAR_FILTER", 322);
define("MESSAGE_PAGE_GROUPS", 837);
define("MESSAGE_PAGE_ALL_GROUPS", 1118);
define("MESSAGE_PAGE_USER_GROUPS", 480);
define("MESSAGE_PAGE_SEARCH", 1091);
define("MESSAGE_PAGE_GROUP_X_ON", 403);
define("MESSAGE_PAGE_NO_SEARCHED_GROUP", 404);
define("MESSAGE_PAGE_PASSWORD", 55);
define("MESSAGE_PAGE_CONFIRM", 481);
define("MESSAGE_PAGE_DISTINGUISHED_NAME", 482);
define("MESSAGE_PAGE_USER_PROFILE", 68);
define("MESSAGE_PAGE_WINDOW_INFO", 483);
define("MESSAGE_PAGE_IDENTIFICATION", 1106);
define("MESSAGE_PAGE_FIRST_NAME", 93);
define("MESSAGE_PAGE_LAST_NAME", 94);
define("MESSAGE_PAGE_EMAIL", 102);
define("MESSAGE_PAGE_LOGIN", 54);
define("MESSAGE_PAGE_LANGUAGE", 96);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_CONTACT_INFO", 99);
define("MESSAGE_PAGE_JOB_TITLE", 112);
define("MESSAGE_PAGE_SERVICE", 103);
define("MESSAGE_PAGE_PHONE", 109);
define("MESSAGE_PAGE_CELL_PHONE", 110);
define("MESSAGE_PAGE_FAX", 111);
define("MESSAGE_PAGE_ADDRESS", 104);
define("MESSAGE_PAGE_ZIP_CODE", 105);
define("MESSAGE_PAGE_CITY", 106);
define("MESSAGE_PAGE_STATE", 107);
define("MESSAGE_PAGE_COUNTRY", 108);
define("MESSAGE_PAGE_EMAIL_NOTIFICATIONS", 484);
define("MESSAGE_PAGE_BOXES_INFO", 485);
define("MESSAGE_PAGE_PAGE", 282);
define("MESSAGE_PAGE_ADMINISTRATION", 449);
define("MESSAGE_PAGE_PASSWORD_INFO", 503);
define("MESSAGE_PAGE_USER_CREATION", 574);
define("MESSAGE_PAGE_ADMIN_NO_GROUPS", 1594);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);
define("MESSAGE_PAGE_LOG_LABEL", 29);
define("MESSAGE_PAGE_NO_PASSWORD", 1720);
define("MESSAGE_PAGE_GENDER", 1738);
define("MESSAGE_PAGE_COMPANY", 1737);

$winId = sensitiveIO::request('winId', '', 'userWindow');
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger', 'createUser');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if ($cms_user->getUserId() != $userId && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

//load user if any
if (sensitiveIO::isPositiveInteger($userId)) {
	$user = CMS_profile_usersCatalog::getByID($userId);
	if (!$user || $user->hasError()) {
		CMS_grandFather::raiseError('Unknown user for given Id : '.$userId);
		$view->show();
	}
} else {
	//create new user
	$user = new CMS_profile_user();
}
//Contact Data
$contactData = $user->getContactData();

//is it a personal profile edition ?
$personalProfile = ($user->getUserId() == $cms_user->getUserId());

//MAIN TAB

//load languages
$languages = CMS_languagesCatalog::getAllLanguages();
$languagesDatas = array();
foreach ($languages as $language) {
	$languagesDatas[] = array(
		'id'	=> $language->getCode(),
		'label'	=> $language->getLabel(),
	);
}
$languagesDatas = sensitiveIO::jsonEncode($languagesDatas);

//Need to sanitize all datas which can contain single quotes
$fullname = sensitiveIO::sanitizeJSString($user->getFullName());
$firstname = sensitiveIO::sanitizeJSString($user->getFirstName());
$lastname = sensitiveIO::sanitizeJSString($user->getLastName());
$lastnameValue = ($lastname) ? "value:'{$lastname}'," : '';
$login = sensitiveIO::sanitizeJSString($user->getLogin());
$loginValue = ($login) ? "value:'{$login}'," : '';
$email = sensitiveIO::sanitizeJSString($user->getEmail());
$emailValue = ($email) ? "value:'{$email}'," : '';
//Contact datas
$service = sensitiveIO::sanitizeJSString($contactData->getService());
$jobtitle = sensitiveIO::sanitizeJSString($contactData->getJobTitle());
$address1 = sensitiveIO::sanitizeJSString($contactData->getAddressField1());
$address2 = sensitiveIO::sanitizeJSString($contactData->getAddressField2());
$address3 = sensitiveIO::sanitizeJSString($contactData->getAddressField3());
$zipcode = sensitiveIO::sanitizeJSString($contactData->getZip());
$city = sensitiveIO::sanitizeJSString($contactData->getCity());
$state = sensitiveIO::sanitizeJSString($contactData->getState());
$country = sensitiveIO::sanitizeJSString($contactData->getCountry());
$phone = sensitiveIO::sanitizeJSString($contactData->getPhone());
$cellphone = sensitiveIO::sanitizeJSString($contactData->getCellphone());
$fax = sensitiveIO::sanitizeJSString($contactData->getFax());
$company = sensitiveIO::sanitizeJSString($contactData->getCompany());
$gender = sensitiveIO::sanitizeJSString($contactData->getGender());
//Alerts
$modulesCodes = new CMS_modulesCodes();
$alerts = $modulesCodes->getModulesCodes(MODULE_TREATMENT_ALERTS, '', $user, array("user" => $cms_user));
$alertsPanel = '';
foreach ($alerts as $codename => $modAlerts) {
	$module = CMS_modulesCatalog::getByCodename($codename);
	$alertsPanel .= "{
		xtype:			'fieldset',
		title: 			'".sensitiveIO::sanitizeJSString($module->getlabel($cms_language))."',
		defaultType: 	'checkbox',
		autoHeight:		true,
		defaults: {
			xtype:			'checkbox',
			anchor:			'97%',
			hideLabel:		true,
			labelSeparator:	''
		},
		items:			[";
	foreach ($modAlerts as $level => $messages) {
		$checked = $user->hasAlertLevel($level, $codename) ? 'checked:true,':'';
		$msgcodename = $module->isPolymod() ? MOD_POLYMOD_CODENAME : $codename;
		$alertsPanel .= "{
			".$checked."
			boxLabel: 	'<span ext:qtip=\"".$cms_language->getJSMessage($messages['description'], false, $msgcodename)."\" class=\"atm-help\">".$cms_language->getJSMessage($messages['label'], false, $msgcodename)."</span>',
			name: 		'alerts[".$codename."][]',
			inputValue:	'".$level."'
		},";
	}
	//remove last comma
	$alertsPanel = io::substr($alertsPanel,0,-1);
	$alertsPanel .= ']},';
}
//remove last comma
$alertsPanel = io::substr($alertsPanel,0,-1);
//disable user infos fields (always false)
$disableUserInfosFields = '';
//disable login field for root and anonymous users
$disableLoginField = ($disableUserInfosFields || $user->getUserId() == ANONYMOUS_PROFILEUSER_ID || $user->getUserId() == ROOT_PROFILEUSER_ID) ? 'disabled:true,':'';
//min password length
$minimumPasswordLength = MINIMUM_PASSWORD_LENGTH;
//get records / pages
$recordsPerPage = CMS_session::getRecordsPerPage();

$groupsTab = $modulesTab = $adminTab = $logsTab = '';

//Get modules and remove standard (which is already treated in this file)
$modules = CMS_modulesCatalog::getAll();
unset($modules[MOD_STANDARD_CODENAME]);

//OTHERS TABS
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	$groupsDisabled = '';
	if ($user->getUserId() == ROOT_PROFILEUSER_ID) {
		$groupsDisabled = "disabled:			true,tabTip:'{$cms_language->getJSMessage(MESSAGE_PAGE_ADMIN_NO_GROUPS)}',";
	}
	//GROUPS TAB
	$groupsTab = ",{
			id:					'userGroups-{$userId}',
			title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_GROUPS)}',
			xtype:				'grid',
			store: 				store,
			{$groupsDisabled}
			border:				false,
			autoExpandColumn:	'description',
			cm: 				new Ext.grid.ColumnModel([
				sm,
				{header: \"ID\", 												width: 30, 	dataIndex: 'id', 			sortable: true, 	hidden:true},
				{header: \"{$cms_language->getMessage(MESSAGE_PAGE_LABEL)}\", 	width: 50, 	dataIndex: 'label', 		sortable: true,						renderer:renderGroups},
				{header: \"{$cms_language->getMessage(MESSAGE_PAGE_DESC)}\", 	width: 170, dataIndex: 'description',	sortable: true, 					renderer:function(value) {return '<span ext:qtip=\"'+value+'\">'+value+'</span>';}}
			]),
			sm: 				sm,
			anchor:				'100%',
			viewConfig: 		{
				forceFit:			true
			},
			tbar:[{
				xtype: 			'textfield',
				emptyText:		'{$cms_language->getJsMessage(MESSAGE_PAGE_SEARCH)} ...',
				id: 			'search-{$userId}',
				selectOnFocus: 	true,
				width:			300,
				listeners: 		{
					'render': {fn:function(){
						Ext.getCmp('search-{$userId}').getEl().on('keyup', filter, this, {buffer:500});
					}, scope:userWindow}
				}
			},'-',{
				xtype:			'checkbox',
				boxLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_ALL_GROUPS)}',
				listeners:		{'check': function(item, checked) {
					if (checked) {
						filterUsersGroups = false;
					} else {
						filterUsersGroups = true;
					}
					filter();
				}}
			}],
			bbar:				new Ext.PagingToolbar({
				pageSize: 			{$recordsPerPage},
				store: 				store,
				displayInfo: 		true,
				displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_GROUP_X_ON)}',
				emptyMsg: 			\"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_SEARCHED_GROUP)}\"
			})
		}";
	//Modules tabs
	$modulesTab = ",{
			id:					'userPages-{$userId}',
			title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_PAGE)}',
			border:				false,
			xtype:				'atmPanel',
			autoScroll:			true,
			autoLoad:		{
				url:		'user-modules-rights.php',
				params:			{
					fatherId:		userWindow.id,
					winId:			'userPages-{$userId}',
					userId:			userWindow.userId
				},
				nocache:	true
			}
		}";
	foreach ($modules as $codename => $module) {
		$label = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
		if ($label) {
			$modulesTab .= ",{
				id:					'user-{$codename}-{$userId}',
				title:				'{$label}',
				border:				false,
				xtype:				'atmPanel',
				autoScroll:			true,
				autoLoad:		{
					url:		'user-modules-rights.php',
					params:			{
						fatherId:		userWindow.id,
						module:			'{$codename}',
						winId:			'user-{$codename}-{$userId}',
						userId:			userWindow.userId
					},
					nocache:	true
				}
			}";
		}
	}
	//ADMIN TAB
	$adminTab = ",{
			id:				'userAdmin-{$userId}',
			title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_ADMINISTRATION)}',
			border:			false,
			xtype:			'atmPanel',
			autoScroll:		true,
			autoLoad:		{
				url:		'user-admin-rights.php',
				params:			{
					winId:			'userAdmin-{$userId}',
					userId:			userWindow.userId
				},
				nocache:	true
			}
		}";
	//LOGS TAB
	$logsTab = ", {
			id:				'userLogs-{$userId}',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_LOG_LABEL)}',
			border:			false,
			xtype:			'atmPanel',
			layout:			'fit',
			autoScroll:		true,
			autoLoad:		{
				url:			'user-logs.php',
				params:			{
					winId:			'userLogs-{$userId}',
					user:			'{$userId}',
					action:			'view'
				},
				nocache:		true,
				scope:			this
			}
           }";
}

//create dynamic vars

// Local passwords (root password is allowed only for root, and disabled for anonymous user)
if ($user->getUserId() != ANONYMOUS_PROFILEUSER_ID
	&& ($user->getUserId() != ROOT_PROFILEUSER_ID || ($user->getUserId() == ROOT_PROFILEUSER_ID && $cms_user->getUserId() == ROOT_PROFILEUSER_ID))) {
	$authentificationField = "{
		layout:			'column',
		xtype:			'panel',
		border:			false,
		items:[{
			columnWidth:	.5,
			layout: 		'form',
			border:			false,
			items: [{
				fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_PASSWORD)}',
				xtype:			'textfield',
				name:			'pass1',
				inputType:		'password',
				anchor:			'98%',
				allowBlank:		true
			}]
		},{
			columnWidth:	.5,
			layout: 		'form',
			border:			false,
			items: [{
				fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CONFIRM)}',
				xtype:			'textfield',
				name:			'pass2',
				inputType:		'password',
				anchor:			'100%',
				allowBlank:		true,
				validator:		validatePass
			}]
		}]
	},";
	if (!$user->havePassword() && $user->getUserId()) {
		$authentificationField .= "{
			bodyStyle:		'padding:0 0 10px 105px',
			xtype:			'panel',
			html:			'{$cms_language->getJsMessage(MESSAGE_PAGE_NO_PASSWORD)}',
			border:			false
		},";
	}
} else {
	$authentificationField = '';
}

/********************************************\
*             MODULES ACCORDION              *
\********************************************/
$modulesAccordion = '';
if ($user->getUserId() != ANONYMOUS_PROFILEUSER_ID && $user->getUserId() != ROOT_PROFILEUSER_ID) {
	//usefull temporary function
	function replaceCallBack($parts) {
		return 'function('.str_replace(array('\"','\/'), array('"', '/'), $parts[1]).'}';
	}

	foreach ($modules as $aModule) {
		if (method_exists($aModule,'getUserAccordionProperties')) {
			$moduleCodename = $aModule->getCodename();
			//get accordion datas from module
			$moduleDatas = $aModule->getUserAccordionProperties($userId, $cms_language);

			$moduleURL = false;
			if (isset($moduleDatas['url'])) {
				$moduleURL = $moduleDatas['url'];
			}
			$moduleLabel = io::sanitizeJSString($aModule->getLabel($cms_language));
			if (isset($moduleDatas['label'])) {
				$moduleLabel = io::sanitizeJSString($moduleDatas['label']);
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
					name:			'submit{$moduleCodename}User',
					scope:			this,
					handler:		function() {
						var form = Ext.getCmp('userPanel-{$moduleCodename}-{$userId}').getForm();
						form.submit({params:{
							action:		'update-user',
							userId:		userWindow.userId
						}});
					}
				}]" : '';
			$modulesAccordion .= ",{
				title:			'{$moduleLabel}',
				id:				'userPanel-{$moduleCodename}-{$userId}',
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
}
$title = (sensitiveIO::isPositiveInteger($userId)) ? $cms_language->getJsMessage(MESSAGE_PAGE_USER_PROFILE).' : '.$fullname : $cms_language->getJsMessage(MESSAGE_PAGE_USER_CREATION);

$jscontent = <<<END
	var userWindow = Ext.getCmp('{$winId}');
	userWindow.userId = '{$userId}';
	//set window title
	userWindow.setTitle('{$title}');
	//set help button on top of page
	userWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 userWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_PAGE_WINDOW_INFO)}',
		dismissDelay:	0
	});

	var validatePass = function(value) {
		if (value) {
			var form = Ext.getCmp('identityPanel-{$userId}').getForm();
			var pass1 = form.findField('pass1');
			var login = form.findField('login');
			if (pass1.getValue() != value || pass1.getValue().length < {$minimumPasswordLength} || pass1.getValue() == login.getValue()) {
				var mess = '{$cms_language->getJsMessage(MESSAGE_PAGE_PASSWORD_INFO, array($minimumPasswordLength))}';
				pass1.markInvalid(mess);
				return mess;
			}
			pass1.clearInvalid();
		}
		return true;
	}

	//renderer for groups names
	var renderGroups = function(label, row, record) {
		return '<a onclick="var userWindow = Ext.getCmp(\'{$winId}\');userWindow.editGroup('+ record.id +', this);">'+ label +'</a>';
	}
	//edit group
	userWindow.editGroup = function(groupId, el) {
		el = Ext.get(el);
		var userWindow = Ext.getCmp('{$winId}');
		var fatherWindow = userWindow.father;
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
	if (userWindow.father.groupWindows == undefined) {
		userWindow.father.groupWindows = [];
	}

	//groups store
	var store = new Automne.JsonStore({
		url: 			'groups-datas.php',
		root: 			'groups',
		totalProperty:	'totalCount',
		id:				'id',
		remoteSort:		true,
		fields:			['id', 'label', 'description', 'belong'],
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
				if (options.params.search == undefined || options.params.filter == undefined || options.params.userId == undefined) {
					var search = Ext.getCmp('search-{$userId}');
					options.params.search = (search) ? search.getValue() : '';
					options.params.filter = (filterUsersGroups) ? 1 : 0;
					options.params.userId = userWindow.userId;
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
			Automne.server.call('users-controler.php', Ext.emptyFn, {
				userId:			this.userId,
				action:			'addgroup',
				groupId:		record.id
			});
		},scope:userWindow},
		'rowdeselect':{fn:function(sm, index, record) {
			Automne.server.call('users-controler.php', Ext.emptyFn, {
				userId:			this.userId,
				action:			'delgroup',
				groupId:		record.id
			});
		},scope:userWindow}
	});
	//filter function
	var filter = function(){
		//get search field value
		var search = Ext.getCmp('search-{$userId}');
		//load of groups store
		store.load({
			params:		{
				start:			0,
				limit:			{$recordsPerPage},
				search:			(search) ? search.getValue() : '',
				filter:			(filterUsersGroups) ? 1 : 0,
				userId:			userWindow.userId
			}
		});
	}
	var filterUsersGroups = true;
	//create center panel
	var center = new Ext.TabPanel({
		activeTab:			 0,
		id:					'userPanels-{$userId}',
		region:				'center',
		border:				false,
		enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		listeners: {'beforetabchange' : function(tabPanel, newTab, currentTab ) {
			if (newTab.id == 'userGroups-{$userId}') {
				//(re)load of groups store
				filter();
			} else if (newTab.id != 'userProfile-{$userId}') {
				//reload panel content
				if (newTab.rendered && newTab.body.updateManager) {
					newTab.body.updateManager.update(newTab.autoLoad);
				}
			}
			return true;
		}},
		items:[{
			id:					'userProfile-{$userId}',
			title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_USER_PROFILE)}',
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
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_IDENTIFICATION)}',
				id:				'identityPanel-{$userId}',
				layout: 		'form',
				xtype:			'atmForm',
				url:			'users-controler.php',
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
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_FIRST_NAME)}',
					name:			'firstname',
					value:			'{$firstname}',
					allowBlank:		true
				},{
					{$disableUserInfosFields}
					fieldLabel:		'<span class=\"atm-red\">*</span> {$cms_language->getMessage(MESSAGE_PAGE_LAST_NAME)}',
					{$lastnameValue}
					name:			'lastname'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'<span class=\"atm-red\">*</span> {$cms_language->getMessage(MESSAGE_PAGE_EMAIL)}',
					name:			'email',
					{$emailValue}
				},{
					{$disableLoginField}
					fieldLabel:		'<span class=\"atm-red\">*</span> {$cms_language->getMessage(MESSAGE_PAGE_LOGIN)}',
					name:			'login',
					{$loginValue}
					vtype:			'login'
				},{$authentificationField}
				{
					xtype:				'combo',
					name:				'language',
					forceSelection:		true,
					fieldLabel:			'<span class=\"atm-red\">*</span> {$cms_language->getMessage(MESSAGE_PAGE_LANGUAGE)}',
					mode:				'local',
					triggerAction:		'all',
					valueField:			'id',
					hiddenName:		 	'language',
					displayField:		'label',
					value:				'{$user->getLanguage()->getCode()}',
					width:				100,
					listWidth:			120,
					store:				new Ext.data.JsonStore({
						fields:				['id', 'label'],
						data:				{$languagesDatas}
					}),
					allowBlank:		 	false,
					selectOnFocus:		true,
					editable:			false,
					anchor:				''
				}],
				buttons:[{
					text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
					iconCls:		'atm-pic-validate',
					name:			'submitIdentity',
					anchor:			'',
					scope:			this,
					handler:		function() {
						var form = Ext.getCmp('identityPanel-{$userId}').getForm();
						if (form.isValid()) {
							form.submit({
								params:{
									action:		'identity',
									userId:		userWindow.userId
								},
								success:function(form, action){
									//if it is a successful user creation
									if (action.result.success != false && isNaN(parseInt(userWindow.userId))) {
										//set userId
										userWindow.userId = action.result.success.userId;
										//display hidden elements
										Ext.getCmp('userProfile-{$userId}').items.each(function(panel) {
											if (panel.id != 'identityPanel-{$userId}') {
												panel.enable();
											}
										});
										Ext.getCmp('userPanels-{$userId}').items.each(function(panel) {
											if (panel.disabled) {
												panel.enable();
												if (panel.autoLoad) {
													panel.autoLoad.params.userId = userWindow.userId;
												}
											}
										});
									}
								},
								scope:this
							});
						} else {
							Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES)}', '', userWindow);
						}
					}
				}]
			}{$modulesAccordion},{
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_CONTACT_INFO)}',
				id:				'userDetailsPanel-{$userId}',
				layout: 		'form',
				xtype:			'atmForm',
				url:			'users-controler.php',
				collapsible:	true,
				defaultType:	'textfield',
				collapsed:		true,
				labelAlign:		'right',
				buttonAlign:	'center',
				autoScroll:		true,
				defaults: {
					xtype:			'textfield',
					anchor:			'97%'
				},
				items:[{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_GENDER)}',
					name:			'gender',
					value:			'{$gender}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_COMPANY)}',
					name:			'company',
					value:			'{$company}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_JOB_TITLE)}',
					name:			'jobtitle',
					value:			'{$jobtitle}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SERVICE)}',
					name:			'service',
					value:			'{$service}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_PHONE)}',
					name:			'phone',
					value:			'{$phone}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_CELL_PHONE)}',
					name:			'cellphone',
					value:			'{$cellphone}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_FAX)}',
					name:			'fax',
					value:			'{$fax}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_ADDRESS)}',
					name:			'address1',
					value:			'{$address1}'
				},{
					{$disableUserInfosFields}
					labelSeparator:	'',
					name:			'address2',
					value:			'{$address2}'
				},{
					{$disableUserInfosFields}
					labelSeparator:	'',
					name:			'address3',
					value:			'{$address3}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_ZIP_CODE)}',
					name:			'zipcode',
					value:			'{$zipcode}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_CITY)}',
					name:			'city',
					value:			'{$city}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_STATE)}',
					name:			'state',
					value:			'{$state}'
				},{
					{$disableUserInfosFields}
					fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_COUNTRY)}',
					name:			'country',
					value:			'{$country}'
				}],
				buttons:[{
					{$disableUserInfosFields}
					iconCls:		'atm-pic-validate',
					text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
					name:			'submitUserDetails',
					scope:			this,
					handler:		function() {
						var form = Ext.getCmp('userDetailsPanel-{$userId}').getForm();
						form.submit({params:{
							action:		'userdetails',
							userId:		userWindow.userId
						}});
					}
				}]
			},{
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_EMAIL_NOTIFICATIONS)}',
				id:				'alertsPanel-{$userId}',
				layout: 		'form',
				xtype:			'atmForm',
				url:			'users-controler.php',
				collapsible:	true,
				defaultType:	'textfield',
				collapsed:		true,
				autoWidth:		true,
				autoScroll:		true,
				buttonAlign:	'center',
				items:[{
					xtype:			'panel',
					bodyStyle: 		'padding:5px',
					html:			'{$cms_language->getJSMessage(MESSAGE_PAGE_BOXES_INFO)}',
					border:			false
				},{$alertsPanel}],
				buttons:[{
					text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
					iconCls:		'atm-pic-validate',
					xtype:			'button',
					name:			'submitAlerts',
					scope:			this,
					handler:		function() {
						var form = Ext.getCmp('alertsPanel-{$userId}').getForm();
						form.submit({params:{
							action:		'useralerts',
							userId:		userWindow.userId
						}});
					}
				}]
			}]
		}{$groupsTab}{$modulesTab}{$adminTab}{$logsTab}]
	});

	userWindow.add(center);
	//redo windows layout
	userWindow.doLayout();

	//disable all elements not usable in first user creation step
	if (isNaN(parseInt(userWindow.userId))) {
		Ext.getCmp('userProfile-{$userId}').items.each(function(panel) {
			if (panel.id != 'identityPanel-{$userId}') {
				panel.disable();
			}
		});
		Ext.getCmp('userPanels-{$userId}').items.each(function(panel) {
			if (panel.id != 'userProfile-{$userId}') {
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
