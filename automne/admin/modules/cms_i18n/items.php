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
// $Id: items.php,v 1.14 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load cms_i18n items search window.
  * Used accross an Ajax request.
  * 
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

//Standard messages
define("MESSAGE_PAGE_IMPORT", 1649);
define("MESSAGE_PAGE_EXPORT", 1672);
define("MESSAGE_PAGE_SEARCH", 212);
define("MESSAGE_PAGE_LOADING", 1321);
define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_DELETE", 252);
define("MESSAGE_ERROR_MODULE_RIGHTS",570);
define("MESSAGE_PAGE_NEW", 262);
define("MESSAGE_SELECT_FILE",534);
define("MESSAGE_ALL_FILE",530);

//Polymod messages
if (!defined('MOD_POLYMOD_CODENAME')) {
	define('MOD_POLYMOD_CODENAME', 'polymod');
}
define("MESSAGE_PAGE_FIELD_KEYWORDS", 18);
define("MESSAGE_PAGE_RESULTS_COUNT", 501);
define("MESSAGE_PAGE_NORESULTS", 502);
define("MESSAGE_PAGE_RESULTS", 503);
define("MESSAGE_PAGE_X_OBJECTS_OF_Y", 504);
define("MESSAGE_ACTION_DELETE_SELECTED", 505);
define("MESSAGE_ACTION_EDIT_SELECTED", 511);
define("MESSAGE_ACTION_CREATE_SELECTED", 512);

//cms_i18n messages
define("MESSAGE_PAGE_EXACT_PHRASE", 7);
define("MESSAGE_PAGE_LANGUAGES", 8);
define("MESSAGE_PAGE_KEYS", 9);
define("MESSAGE_PAGE_OPTIONS", 10);
define("MESSAGE_PAGE_MISSING_MESSAGES_ONLY", 11);
define("MESSAGE_PAGE_MESSAGES", 12);
define("MESSAGE_PAGE_TXT_FORMAT", 13);
define("MESSAGE_PAGE_HTML_FORMAT", 14);
define("MESSAGE_PAGE_TRANSLATIONS", 15);
define("MESSAGE_PAGE_ACTION_DELETE_CONFIRM", 16);
define("MESSAGE_PAGE_ACTION_TRANSLATE_SELECTED", 17);
define("MESSAGE_PAGE_FROM_TO", 18);
define("MESSAGE_PAGE_ACTION_GOOGLE_REQUEST", 19);
define("MESSAGE_PAGE_TRANSLATION_SUGGESTION", 20);
define("MESSAGE_PAGE_KEEP_OR_MODIFY", 21);
define("MESSAGE_PAGE_ERROR_GOOGLE_REQUEST", 22);
define("MESSAGE_PAGE_ERROR_NO_VALUE", 31);
define("MESSAGE_PAGE_ALL", 32);
define("MESSAGE_PAGE_FORMAT_XLS2007", 33);
define("MESSAGE_PAGE_FORMAT_XLS97", 34);
define("MESSAGE_PAGE_FORMAT_PO", 35);
define("MESSAGE_PAGE_FORMAT_XML", 36);
define("MESSAGE_PAGE_FORMAT_SQL", 37);
define("MESSAGE_PAGE_EXPORT_FORMAT", 38);
define("MESSAGE_PAGE_EXPORT_SEARCH", 39);
define("MESSAGE_PAGE_EXPORT_LANGUAGES", 40);
define("MESSAGE_PAGE_SELECT_EXPORT_FORMAT", 41);
define("MESSAGE_PAGE_SELECT_PO_LANGUAGE", 42);
define("MESSAGE_PAGE_SELECT_IMPORT_FORMAT", 43);
define("MESSAGE_PAGE_IMPORT_FORMAT", 45);
define("MESSAGE_PAGE_IMPORT_FILE", 46);
define("MESSAGE_PAGE_IMPORT_WARNING", 47);
define("MESSAGE_PAGE_SELECT_IMPORT_FILE", 48);
define("MESSAGE_PAGE_IMPORT_IN_PROGRESS", 49);
define("MESSAGE_PAGE_VIEW_KEYS", 63);
define("MESSAGE_PAGE_VIEW_KEYS_DESC", 64);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId');
$codename = sensitiveIO::request('module');
$objectId = sensitiveIO::request('objectId');

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//load module
if ($codename != 'cms_i18n_vars' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($codename)));
	$view->show();
}
//usefull vars
$recordsPerPage = $_SESSION["cms_context"]->getRecordsPerPage();
$searchURL = PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/search.php';
$editURL = PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/item.php';
$itemsControlerURL = PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/items-controler.php';
$exportURL = PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/export.php';
//
// Search Panel
//
$searchPanel = $exportPanel = $importPanel = '';
$keywordsSearch = true;
$searchLists = '';

// Keywords
$searchPanel .= "{
	fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_KEYWORDS, false, MOD_POLYMOD_CODENAME)}',
	xtype:			'textfield',
	name: 			'items_{$codename}_kwrds',
	value:			'',
	minLength:		3,
	anchor:			'-20px',
	enableKeyEvents:true,
	listeners:		{
		'valid':{
			fn: 			moduleObjectWindow.search, 
			options:		{buffer:300}
		},
		'invalid':{
			fn: function(field, event) {
				if (!isNaN(parseInt(field.getValue()))) {
					field.clearInvalid();
					field.fireEvent('valid', field);
				} else if (!field.getValue()) {
					field.clearInvalid();
				}
			}, 
			options:		{buffer:300}
		}
	}
},{
	xtype: 		'checkbox', 
	hideLabel:	true,
	boxLabel: 	'{$cms_language->getJSMessage(MESSAGE_PAGE_EXACT_PHRASE, false, MOD_CMS_I18N_CODENAME)}', 
	inputValue:	'1', 
	name: 		'options[phrase]', 
	height:		30,
	listeners:	{'check':moduleObjectWindow.search}
},";

$languages = CMS_languagesCatalog::getAllLanguages($codename);
$storeLanguages = $jsLanguages = $comboLanguages = '';
if ($languages) {
	$columns = sizeof($languages) < 2 ? sizeof($languages) : 2;
	$searchPanel .= "{
		xtype: 		'checkboxgroup',
		id:			'{$winId}-languages',
		fieldLabel: '{$cms_language->getJSMessage(MESSAGE_PAGE_LANGUAGES, false, MOD_CMS_I18N_CODENAME)}', 
		columns: 	{$columns},
		items: [";
		$jsLanguages = '{';
		$comboLanguages = '[{id:\'all\',label:\''.$cms_language->getJSMessage(MESSAGE_PAGE_ALL, false, MOD_CMS_I18N_CODENAME).'\'},';
		if ($codename == 'cms_i18n_vars') {
			$searchPanel .= "{boxLabel: '{$cms_language->getJSMessage(MESSAGE_PAGE_KEYS, false, MOD_CMS_I18N_CODENAME)}', inputValue:'key', name: 'languages[]', checked:true, listeners: {'check':moduleObjectWindow.search}},";
			$storeLanguages .= '\'key\',';
			$comboLanguages .= '{id:\'key\',label:\''.$cms_language->getJSMessage(MESSAGE_PAGE_KEYS, false, MOD_CMS_I18N_CODENAME).'\'},';
		}
		foreach ($languages as $code => $language) {
			$searchPanel .= "{boxLabel: '{$language->getLabel()}', inputValue:'{$code}', name: 'languages[]', checked:true, listeners: {'check':moduleObjectWindow.search}},";
			$storeLanguages .= "'{$code}',";
			$jsLanguages .= $code.':\''.io::sanitizeJSString($language->getLabel()).'\',';
			$comboLanguages .= '{id:\''.$code.'\',label:\''.io::sanitizeJSString($language->getLabel()).'\'},';
		}
		//remove last comma from groups
		$searchPanel = io::substr($searchPanel, 0, -1);
		$storeLanguages = io::substr($storeLanguages, 0, -1);
		$jsLanguages = io::substr($jsLanguages, 0, -1).'}';
		$comboLanguages = io::substr($comboLanguages, 0, -1).']';
		$searchPanel .= "
		]
	},";
}
//options
$searchPanel .= "{
	xtype: 		'checkboxgroup',
	fieldLabel: '{$cms_language->getJSMessage(MESSAGE_PAGE_OPTIONS, false, MOD_CMS_I18N_CODENAME)}',
	columns: 	1,
	items: [
		{boxLabel: '{$cms_language->getJSMessage(MESSAGE_PAGE_MISSING_MESSAGES_ONLY, false, MOD_CMS_I18N_CODENAME)}', inputValue:'1', name: 'options[empty]', listeners: {'check':moduleObjectWindow.search}}";
		if ($codename == 'cms_i18n_vars') {
			$searchPanel .= ",{boxLabel: '<span class=\"atm-help\" ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_VIEW_KEYS_DESC, false, MOD_CMS_I18N_CODENAME)}\">{$cms_language->getJSMessage(MESSAGE_PAGE_VIEW_KEYS, false, MOD_CMS_I18N_CODENAME)}</span>', ".(CMS_session::getSessionVar('i18n-show-keys') ? 'checked:true, ' : '')."inputValue:'1', name: 'options[view-keys]', listeners: {'check':moduleObjectWindow.search}}";
		}
$searchPanel .= "
	]
},";

//remove last comma from search panel items
$searchPanel = io::substr($searchPanel, 0, -1);

//XLSX and ODT need zip extension
if (function_exists('zip_open')) {
	//Export panel
	$format = array(
		array('id' => '', 		'label' => '-'),
		array('id' => 'xlsx', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_XLS2007, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'xls', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_XLS97, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'po', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_PO, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'xml', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_XML, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'sql', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_SQL, false, MOD_CMS_I18N_CODENAME)),
	);
} else {
	//Export panel
	$format = array(
		array('id' => '', 		'label' => '-'),
		array('id' => 'xls', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_XLS97, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'po', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_PO, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'xml', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_XML, false, MOD_CMS_I18N_CODENAME)),
		array('id' => 'sql', 	'label' => $cms_language->getMessage(MESSAGE_PAGE_FORMAT_SQL, false, MOD_CMS_I18N_CODENAME)),
	);
}

$format = sensitiveIO::jsonEncode($format);
$exportPanel .= "{
	xtype:				'combo',
	name:				'format',
	hiddenName:		 	'format',
	forceSelection:		true,
	fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_EXPORT_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
	mode:				'local',
	triggerAction:		'all',
	valueField:			'id',
	displayField:		'label',
	value:				'',
	anchor:				'-20px',
	store:				new Ext.data.JsonStore({
		fields:				['id', 'label'],
		data:				{$format}
	}),
	allowBlank:		 	false,
	selectOnFocus:		true,
	editable:			false,
	validateOnBlur:		false
},{
	xtype: 		'checkbox', 
	hideLabel:	true,
	boxLabel: 	'{$cms_language->getJSMessage(MESSAGE_PAGE_EXPORT_SEARCH, false, MOD_CMS_I18N_CODENAME)}', 
	inputValue:	'1', 
	name: 		'currentsearch', 
	height:		30
},{
	xtype:				'combo',
	name:				'language',
	hiddenName:		 	'language',
	forceSelection:		true,
	fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_EXPORT_LANGUAGES, false, MOD_CMS_I18N_CODENAME)}',
	mode:				'local',
	triggerAction:		'all',
	valueField:			'id',
	displayField:		'label',
	value:				'all',
	anchor:				'-20px',
	store:				new Ext.data.JsonStore({
		fields:				['id', 'label'],
		data:				{$comboLanguages}
	}),
	allowBlank:		 	false,
	selectOnFocus:		true,
	editable:			false,
	validateOnBlur:		false
},";

//remove last comma from export panel items
$exportPanel = io::substr($exportPanel, 0, -1);


//Import Panel
$fileDatas = array(
	'filename'		=> '',
	'filepath'		=> '',
	'filesize'		=> '',
	'fileicon'		=> '',
	'extension'		=> '',
);
$fileDatas = sensitiveIO::jsonEncode($fileDatas);
$maxFileSize = CMS_file::getMaxUploadFileSize('K');
$importPanel .= "{
	xtype:				'combo',
	name:				'format',
	hiddenName:		 	'format',
	forceSelection:		true,
	fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
	mode:				'local',
	triggerAction:		'all',
	valueField:			'id',
	displayField:		'label',
	value:				'',
	anchor:				'-20px',
	store:				new Ext.data.JsonStore({
		fields:				['id', 'label'],
		data:				{$format}
	}),
	allowBlank:		 	false,
	selectOnFocus:		true,
	editable:			false,
	validateOnBlur:		false
},{
	fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT_FILE, false, MOD_CMS_I18N_CODENAME)}',
	xtype:			'atmFileUploadField',
	id:				'{$winId}-importfile',
	name: 			'importfile',
	value:			'',
	anchor:			'-20px',
	emptyText: 		'{$cms_language->getJSMessage(MESSAGE_SELECT_FILE)}',
	name: 			'filename',
	uploadCfg:	{
		file_size_limit:		'{$maxFileSize}',
		file_types:				'*.xlsx;*.xls;*.po;*.xml;*.sql',
		file_types_description:	'{$cms_language->getJSMessage(MESSAGE_ALL_FILE)} ...'
	},
	fileinfos:	{$fileDatas}
},{
	xtype:			'panel',
	border:			false,
	html:			'<div style=\"color:grey;padding-top:15px;font-size:x-small;\">{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT_WARNING, false, MOD_CMS_I18N_CODENAME)}</div>'
},";

//remove last comma from export panel items
$importPanel = io::substr($importPanel, 0, -1);


$jscontent = <<<END
	var moduleObjectWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	
	//define update function into window (to be accessible by parent window)
	moduleObjectWindow.updateTab = function() {
		//reload all already loaded combos in search form
		var combos = searchPanel.findByType('atmCombo');
		var combosLen = combos.length;
		for(var i = 0; i < combosLen; i++) {
			if (combos[i].store.isLoaded()) {
				combos[i].store.reload();
			}
		}
		//reload search
		moduleObjectWindow.search();
	}
	//define search function into window (to be accessible by parent window)
	moduleObjectWindow.search = function(pageNb) {
		if (!moduleObjectWindow.ok) {
			return;
		}
		if (pageNb === 'current') {
			//simply refresh current page
			resultsPanel.getBottomToolbar().doRefresh();
			return;
		}
		if (pageNb === 'last') {
			//go to last page page
			resultsPanel.getBottomToolbar().moveLast();
			return;
		}
		
		var form = Ext.getCmp('{$winId}Search').getForm();
		var values = Ext.applyIf(form.getValues(), {
			module:			'{$codename}',
			start:			0,
			limit:			{$recordsPerPage}
		});
		
		store.baseParams = values;
		resultsPanel.body.mask('{$cms_language->getJSMessage(MESSAGE_PAGE_LOADING)}');
		store.load({
			params:			values,
			add:			false,
			callback:		function() {
				resultsPanel.body.unmask();
			},
			scope:			this
		});
		return;
	}
	
	var searchPanel = new Ext.Panel({
		id:				'{$winId}-accordion',
		region:			'west',
		width:			250,
		minSize:		200,
		maxSize:		400,
		collapsible:	false,
		split:			true,
		border:			false,
		autoScroll:		true,
		layout: 		'accordion',
		bodyBorder: 	false,
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
			id: 			'{$winId}Search',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SEARCH)}',
			xtype:			'form',
			labelAlign: 	'top',
			autoScroll:		true,
			bodyStyle: {
				padding: 		'5px'
			},
			defaults:	{
				validateOnBlur:	false
			},
			keys: {
				key: 			Ext.EventObject.ENTER,
				scope:			this,
				handler:		moduleObjectWindow.search
			},
			items:[{$searchPanel}]
		},{
			id: 			'{$winId}Export',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_EXPORT)}',
			xtype:			'form',
			labelAlign: 	'top',
			autoScroll:		true,
			bodyStyle: {
				padding: 		'5px'
			},
			defaults:	{
				validateOnBlur:	false
			},
			items:[{$exportPanel}],
			buttonAlign:	'center',
			buttons:[{
				text:'{$cms_language->getJSMessage(MESSAGE_PAGE_EXPORT)}',
				iconCls:	'atm-pic-export',
				handler:function(){
					var form = Ext.getCmp('{$winId}Export').getForm();
					var values = Ext.applyIf(form.getValues(), {
						module:			'{$codename}',
						action:			'export'
					});
					if (!values.format) {
						Automne.message.show('', '{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_EXPORT_FORMAT, false, MOD_CMS_I18N_CODENAME)}', fatherWindow);
						return;
					}
					if (values.format == 'po' && values.language == 'all') {
						Automne.message.show('', '{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_PO_LANGUAGE, false, MOD_CMS_I18N_CODENAME)}', fatherWindow);
						return;
					}
					if (values.currentsearch) {
						//append current search values if any
						var form = Ext.getCmp('{$winId}Search').getForm();
						values = Ext.applyIf(form.getValues(), values);
					}
					window.open('{$exportURL}?'+Ext.urlEncode(values));
				}
			}]
		},{
			id: 			'{$winId}Import',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT)}',
			xtype:			'form',
			labelAlign: 	'top',
			autoScroll:		true,
			bodyStyle: {
				padding: 		'5px'
			},
			defaults:	{
				validateOnBlur:	false
			},
			items:[{$importPanel}],
			buttonAlign:	'center',
			buttons:[{
				text:'{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT)}',
				iconCls:	'atm-pic-import',
				handler:function(){
					var form = Ext.getCmp('{$winId}Import').getForm();
					var values = Ext.applyIf(form.getValues(), {
						module:			'{$codename}',
						action:			'import'
					});
					if (!values.format) {
						Automne.message.show('', '{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_IMPORT_FORMAT, false, MOD_CMS_I18N_CODENAME)}', fatherWindow);
						return;
					}
					if (!values.filename) {
						Automne.message.show('', '{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_IMPORT_FILE, false, MOD_CMS_I18N_CODENAME)}', fatherWindow);
						return;
					}
					fatherWindow.getEl().mask('{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT_IN_PROGRESS, false, MOD_CMS_I18N_CODENAME)}');
					Automne.server.call({
						url:			'{$itemsControlerURL}',
						params:			values,
						scope:			this,
						fcnCallback:	function(response, options, jsonResponse){
							fatherWindow.getEl().unmask();
							//reset upload field
							Ext.getCmp('{$winId}-importfile').deleteFile();
							//reload search
							moduleObjectWindow.search();
						}
					});
					
				}
			}]
		}]
	});
	
	var objectsWindows = [];
	var selectedObjects = [];
	
	// Results store
	var store = new Automne.JsonStore({
		autoDestroy: 	true,
		root:			'results',
		totalProperty:	'total',
		url:			'{$searchURL}',
		id:				'id',
		remoteSort:		true,
		baseParams:		{
			module:			'{$codename}'
		},
		fields:			['id', {$storeLanguages}],
		listeners:		{
			'load': 		{fn:function(store, records, options){
				var resultsPanel = Ext.getCmp('{$winId}resultsPanel');
				//Update results title
				if (resultsPanel) {
					if (store.getTotalCount()) {
						var start = (options.params && options.params.start) ? options.params.start : 0;
						if (store.getTotalCount() < (start + {$recordsPerPage})) {
							var resultCount = store.getTotalCount();
						} else {
							var resultCount = start + {$recordsPerPage};
						}
						resultsPanel.setTitle(String.format('{$cms_language->getJSMessage(MESSAGE_PAGE_RESULTS_COUNT, array($cms_language->getJSMessage(MESSAGE_PAGE_MESSAGES, false, MOD_CMS_I18N_CODENAME)), MOD_POLYMOD_CODENAME)}', resultCount, store.getTotalCount()));
					} else {
						resultsPanel.setTitle('{$cms_language->getJSMessage(MESSAGE_PAGE_NORESULTS, false, MOD_POLYMOD_CODENAME)}');
					}
				}
				moduleObjectWindow.syncSize();
			}},
			'update': 		{fn:function(store, record, operation){
				if (operation == Ext.data.Record.COMMIT) {
					var params = {
						action:		'update',
						module:		'{$codename}',
						item:		record.id
					}
					for(var code in record.data) {
						if (code != 'id') {
							params['messages['+code+']'] = record.data[code];
						}
					}
					
					Automne.server.call({
						url:			'{$itemsControlerURL}',
						params:			params
					});
				}
			}},
			scope : this
		}
	});
	//create grid column model
	moduleObjectWindow.createColModel = function () {
        var columns = [{
            dataIndex: 	'id',
            header: 	'Id',
			width:		50,
			sortable:	true
        }];
		var checkboxes = Ext.getCmp('{$winId}-languages').items;
		checkboxes.each(function(el){
			columns[columns.length] = {
				dataIndex: el.inputValue,
           		header: el.boxLabel
			};
		});
		Ext.getCmp('{$winId}resultsPanel').reconfigure(store, new Ext.grid.ColumnModel({
            columns: columns,
            defaults: {
				width: 200
            }
        }));
		return true;
    };
	
	var editItem = function(itemId, format, button) {
		if (!itemId) {
			itemId = 0;
		}
		var windowId = 'module{$codename}EditWindow'+itemId;
		if (objectsWindows[windowId]) {
			Ext.WindowMgr.bringToFront(objectsWindows[windowId]);
		} else {
			//create window element
			objectsWindows[windowId] = new Automne.Window({
				id:				windowId,
				itemId:			itemId,
				autoLoad:		{
					url:			'{$editURL}',
					params:			{
						winId:			windowId,
						module:			'{$codename}',
						item:			itemId,
						format:			format
					},
					nocache:		true,
					scope:			this
				},
				modal:			false,
				father:			fatherWindow,
				width:			750,
				height:			580,
				animateTarget:	button,
				listeners:{'close':function(window){
					//enable button to allow creation of a other items
					if (!window.itemId) {
						//reload search and go to last page
						if (window.saved) {
							moduleObjectWindow.search('last');
						}
					} else {
						//reload search
						moduleObjectWindow.search('current');
					}
					Ext.getCmp('{$winId}createItem').enable();
					//delete window from list
					delete objectsWindows[window.id];
				}}
			});
			//display window
			objectsWindows[windowId].show(button.getEl());
			if (itemId == 0) {
				Ext.getCmp('{$winId}createItem').disable();
			}
		}
	}
	
	var resultsPanel = new Ext.grid.GridPanel({
        id:					'{$winId}resultsPanel',
		title: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_RESULTS, false, MOD_POLYMOD_CODENAME)}',
		cls:				'atm-results',
		collapsible:		false,
		region:				'center',
		border:				false,
		autoEncode:			true,
        store: store,
        colModel: new Ext.grid.ColumnModel({
            columns: []
        }),
		selModel: new Ext.grid.CellSelectionModel(),
        loadMask: true,
		bbar: new Ext.PagingToolbar({
            store: store,
            pageSize: {$recordsPerPage}
        }),
		tbar: new Ext.Toolbar({
            id: 			'{$winId}toolbar',
            enableOverflow: true,
            items: [{
				id:			'{$winId}editItem',
				iconCls:	'atm-pic-modify',
				xtype:		'button',
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_MODIFY)}',
				menu:		{
					items:[{
						text:	'{$cms_language->getJSMessage(MESSAGE_PAGE_TXT_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
						handler:	function(button) {
							var cell = resultsPanel.getSelectionModel().getSelectedCell();
							var record = resultsPanel.getStore().getAt(cell[0]);
							editItem(record.id, 'text', button);
						},
						scope:		this
					},{
						text:	'{$cms_language->getJSMessage(MESSAGE_PAGE_HTML_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
						handler:	function(button) {
							var cell = resultsPanel.getSelectionModel().getSelectedCell();
							var record = resultsPanel.getStore().getAt(cell[0]);
							editItem(record.id, 'html', button);
						},
						scope:		this
					}]
				},
				disabled:	true
			},{
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_TRANSLATIONS, false, MOD_CMS_I18N_CODENAME)}',
				disabled:	true,
				id:			'{$winId}translateItem',
				menu:{
	                id:			'{$winId}translateMenu',
					items: 		[]
				}
			},{
				id:			'{$winId}deleteItem',
				iconCls:	'atm-pic-deletion',
				xtype:		'button',
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_DELETE)}',
				handler:	function(button) {
					Automne.message.popup({
						msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_DELETE_CONFIRM, false, MOD_CMS_I18N_CODENAME)}',
						buttons: 			Ext.MessageBox.OKCANCEL,
						closable: 			false,
						icon: 				Ext.MessageBox.WARNING,
						fn:					function(button) {
							if (button == 'ok') {
								var cell = resultsPanel.getSelectionModel().getSelectedCell();
								// get column name
								var fieldName = resultsPanel.getColumnModel().getDataIndex(cell[1]);
								var record = resultsPanel.getStore().getAt(cell[0]);
								
								Automne.server.call({
									url:			'{$itemsControlerURL}',
									params:			{
										action:		'delete',
										module:		'{$codename}',
										item:		record.id
									},
									scope:			this,
									fcnCallback:	function(response, options, jsonResponse){
										//reload search
										moduleObjectWindow.search('current');
									}
								});
							}
						}
					});
				},
				scope:		resultsPanel,
				disabled:	true
			}, '->', {
				id:			'{$winId}createItem',
				iconCls:	'atm-pic-add',
				xtype:		'button',
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_NEW)}',
				menu:		{
					items:[{
						text:	'{$cms_language->getJSMessage(MESSAGE_PAGE_TXT_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
						handler:	function(button) {
							editItem(0, 'text', button);
						},
						scope:		resultsPanel
					},{
						text:	'{$cms_language->getJSMessage(MESSAGE_PAGE_HTML_FORMAT, false, MOD_CMS_I18N_CODENAME)}',
						handler:	function(button) {
							editItem(0, 'html', button);
						},
						scope:		resultsPanel
					}]
				}
			}]
		})
    });
	
	moduleObjectWindow.add(searchPanel);
	moduleObjectWindow.add(resultsPanel);
	
	//redo windows layout
	moduleObjectWindow.doLayout();
	
	setTimeout(function(){
		moduleObjectWindow.syncSize();
	}, 500);
	
	//this flag is needed, because form construction, launch multiple search queries before complete page construct so we check in moduleObjectWindow.search if construction is ok
	moduleObjectWindow.ok = true;
	//update column model
	moduleObjectWindow.createColModel();
	//launch search
	moduleObjectWindow.search();
	
	//add selection events to selection model
	var qtips = [];
	qtips['delete'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}deleteItem').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_ACTION_DELETE_SELECTED, array(""), MOD_POLYMOD_CODENAME)}',
		disabled:		true
	});
	qtips['edit'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}editItem').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_ACTION_EDIT_SELECTED, array(""), MOD_POLYMOD_CODENAME)}',
		disabled:		true
	});
	qtips['create'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}createItem').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_ACTION_CREATE_SELECTED, array(""), MOD_POLYMOD_CODENAME)}'
	});
	qtips['translate'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}translateItem').getEl(),
		html: 			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_TRANSLATE_SELECTED, false, MOD_CMS_I18N_CODENAME)}'
	});
	
	resultsPanel.getSelectionModel().on('selectionchange', function(sm, selection){
		if (!selection) {
			qtips['edit'].disable();
			qtips['delete'].disable();
			
			Ext.getCmp('{$winId}editItem').disable();
			Ext.getCmp('{$winId}deleteItem').disable();
			Ext.getCmp('{$winId}translateItem').disable();
		} else { //enable / disable buttons allowed by selection
			qtips['edit'].enable();
			qtips['delete'].enable();
			
			Ext.getCmp('{$winId}editItem').enable();
			Ext.getCmp('{$winId}deleteItem').enable();
			
			// get column name
			var fieldName = sm.grid.getColumnModel().getDataIndex(selection.cell[1]);
			if (fieldName != 'key' && fieldName != 'id') {
				//update translate menu
				var menu = Ext.getCmp('{$winId}translateMenu');
				//clear menu content
				menu.removeAll(true);
				var languages = {$jsLanguages};
				for(var code in languages) {
					if (code != fieldName) {
						menu.addMenuItem({
							text:			String.format('{$cms_language->getJSMessage(MESSAGE_PAGE_FROM_TO, false, MOD_CMS_I18N_CODENAME)}', languages[code], languages[fieldName]),
							langFrom:		fieldName,
							langTo:			code,
							translateData:	selection.record.get(code),
							handler:		function(b) {
								var format = 'text';
								if (!b.translateData) {
									Automne.message.popup({
										msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_NO_VALUE, false, MOD_CMS_I18N_CODENAME)}',
										buttons: 			Ext.MessageBox.OK,
										closable: 			false,
										icon: 				Ext.MessageBox.ERROR
									});
									return;
								}
								
								if (Ext.util.Format.stripTags(b.translateData) != b.translateData) {
									format = 'html';
								}
								var store = new Ext.data.JsonStore({
							        root: 'responseData',
							        fields: ['translatedText'],
									autoLoad: {params:{
											v: 			'1.0',
											q:			b.translateData,
											langpair:	b.langTo+'|'+b.langFrom,
											format:		format
									}},
							        proxy: new Ext.data.ScriptTagProxy({
							            url: 'https://ajax.googleapis.com/ajax/services/language/translate'
							        }),
									listeners:{
										'beforeload':function(){
											resultsPanel.getEl().mask('{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_GOOGLE_REQUEST, false, MOD_CMS_I18N_CODENAME)}');
										},
										'load':function(store, record, options){
											resultsPanel.getEl().unmask();
											if (store.reader.jsonData && store.reader.jsonData.responseData && store.reader.jsonData.responseData.translatedText) {
												var translatedValue = store.reader.jsonData.responseData.translatedText;
												Ext.MessageBox.prompt(
													'{$cms_language->getJSMessage(MESSAGE_PAGE_TRANSLATION_SUGGESTION, false, MOD_CMS_I18N_CODENAME)}',
													'{$cms_language->getJSMessage(MESSAGE_PAGE_KEEP_OR_MODIFY, false, MOD_CMS_I18N_CODENAME)}',
													function(button, translatedValue) {
														if (button == 'ok') {
															var cell = resultsPanel.getSelectionModel().getSelectedCell();
															// get column name
															var fieldName = resultsPanel.getColumnModel().getDataIndex(cell[1]);
															var record = resultsPanel.getStore().getAt(cell[0]);
															record.set(fieldName, translatedValue);
															resultsPanel.getStore().commitChanges();
														}
													},
													moduleObjectWindow,
													100,
													translatedValue
												);
											} else {
												Automne.message.popup({
													msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_GOOGLE_REQUEST, false, MOD_CMS_I18N_CODENAME)}',
													buttons: 			Ext.MessageBox.OK,
													closable: 			false,
													icon: 				Ext.MessageBox.ERROR
												});
											}
										},
										'exception':function(store, record, options){
											Automne.message.popup({
												msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_GOOGLE_REQUEST, false, MOD_CMS_I18N_CODENAME)}',
												buttons: 			Ext.MessageBox.OK,
												closable: 			false,
												icon: 				Ext.MessageBox.ERROR
											});
											resultsPanel.getEl().unmask();
										}
									}
							    });
							}
						});
					}
				}
				Ext.getCmp('{$winId}translateItem').enable();
			}
		}
		if (Ext.getCmp('{$winId}toolbar')) {
			Ext.getCmp('{$winId}toolbar').syncSize();
		}
		moduleObjectWindow.syncSize();
	}, this);
END;
$view->addJavascript($jscontent);
$view->show();
?>