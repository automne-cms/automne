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

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//Standard messages
define("MESSAGE_PAGE_NEW", 262);
define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_YES", 1082);
define("MESSAGE_PAGE_NO", 1083);
define("MESSAGE_PAGE_LOADING", 1321);
define("MESSAGE_PAGE_LANGUAGE_MANAGEMENT", 446);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_CODE", 1691);
define("MESSAGE_PAGE_ADMIN_LANGUAGE", 1692);
define("MESSAGE_PAGE_DATE_FORMAT", 1693);
define("MESSAGE_PAGE_EXCLUDED_MODULES", 1694);
define("MESSAGE_PAGE_EDIT_SELECTED", 1695);
define("MESSAGE_PAGE_CREATE_NEW_LANGUAGE", 1696);

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on language management');
	$view->show();
}

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');

if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//usefull vars
$searchURL = PATH_ADMIN_WR.'/languages-datas.php';
$editURL = PATH_ADMIN_WR.'/language.php';
$itemsControlerURL = PATH_ADMIN_WR.'/languages-controler.php';

$jscontent = <<<END
	var moduleObjectWindow = Ext.getCmp('{$winId}');
	moduleObjectWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_LANGUAGE_MANAGEMENT)}');
	
	//define search function into window (to be accessible by parent window)
	moduleObjectWindow.search = function() {
		if (!moduleObjectWindow.ok) {
			return;
		}
		if (resultsPanel.getEl()) {
			resultsPanel.getEl().mask('{$cms_language->getJSMessage(MESSAGE_PAGE_LOADING)}');
		}
		store.load({
			callback:		function() {
				if (resultsPanel.getEl()) {
					resultsPanel.getEl().unmask();
				}
			},
			scope:			this
		});
		return;
	}
	
	var objectsWindows = [];
	
	// Results store
	var store = new Automne.JsonStore({
		autoDestroy: 	true,
		root:			'results',
		totalProperty:	'total',
		url:			'{$searchURL}',
		id:				'code',
		remoteSort:		true,
		fields:			['label', 'code', 'admin', 'dateFormat', 'modulesDenied'],
		listeners:		{
			'load': 		{fn:function(store, records, options){
				moduleObjectWindow.syncSize();
			}},
			scope : this
		}
	});
	
	var editItem = function(code, button) {
		if (!code) {
			code = '';
		}
		var windowId = 'languageEditWindow'+code;
		if (objectsWindows[windowId]) {
			Ext.WindowMgr.bringToFront(objectsWindows[windowId]);
		} else {
			//create window element
			objectsWindows[windowId] = new Automne.Window({
				id:				windowId,
				code:			code,
				autoLoad:		{
					url:			'{$editURL}',
					params:			{
						winId:			windowId,
						code:			code
					},
					nocache:		true,
					scope:			this
				},
				modal:			false,
				father:			moduleObjectWindow,
				width:			750,
				height:			580,
				animateTarget:	button,
				listeners:{'close':function(window){
					//enable button to allow creation of a other items
					if (!window.code) {
						Ext.getCmp('{$winId}createItem').enable();
					}
					//reload search
					moduleObjectWindow.search();
					//delete window from list
					delete objectsWindows[window.id];
				}}
			});
			//display window
			objectsWindows[windowId].show(button.getEl());
			if (code == '') {
				Ext.getCmp('{$winId}createItem').disable();
			}
		}
	}
	
	var resultsPanel = new Ext.grid.GridPanel({
        id:					'{$winId}resultsPanel',
		cls:				'atm-results',
		collapsible:		false,
		region:				'center',
		border:				false,
		store: store,
        autoExpandColumn:	'label',
		colModel: new Ext.grid.ColumnModel([
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_LABEL)}", 			width: 80, 	dataIndex: 'label', 		sortable: false},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_CODE)}", 			width: 80, 	dataIndex: 'code', 			sortable: false},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_ADMIN_LANGUAGE)}", 	width: 80, 	dataIndex: 'admin', 		sortable: false,	renderer:function(value) {return value == 1 ? '{$cms_language->getJSMessage(MESSAGE_PAGE_YES)}' : '{$cms_language->getJSMessage(MESSAGE_PAGE_NO)}';}},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_DATE_FORMAT)}", 	width: 80, 	dataIndex: 'dateFormat', 	sortable: false},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_EXCLUDED_MODULES)}",width: 80, 	dataIndex: 'modulesDenied', sortable: false},
		]),
		selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
		anchor:				'100%',
		viewConfig: 		{
			forceFit:			true
		},
        loadMask: true,
		tbar: new Ext.Toolbar({
            id: 			'{$winId}toolbar',
            enableOverflow: true,
            items: [{
				id:			'{$winId}editItem',
				iconCls:	'atm-pic-modify',
				xtype:		'button',
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_MODIFY)}',
				handler:	function(button) {
					var row = resultsPanel.getSelectionModel().getSelected();
					editItem(row.id, button);
				},
				scope:		this,
				disabled:	true
			}, '->', {
				id:			'{$winId}createItem',
				iconCls:	'atm-pic-add',
				xtype:		'button',
				text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_NEW)}',
				handler:	function(button) {
					editItem(0, button);
				},
				scope:		resultsPanel
			}]
		})
    });
	
	moduleObjectWindow.add(resultsPanel);
	
	//redo windows layout
	moduleObjectWindow.doLayout();
	
	setTimeout(function(){
		moduleObjectWindow.syncSize();
	}, 500);
	
	//this flag is needed, because form construction, launch multiple search queries before complete page construct so we check in moduleObjectWindow.search if construction is ok
	moduleObjectWindow.ok = true;
	//launch search
	moduleObjectWindow.search();
	
	//add selection events to selection model
	var qtips = [];
	qtips['edit'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}editItem').getEl(),
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_EDIT_SELECTED)}',
		disabled:		true
	});
	qtips['create'] = new Ext.ToolTip({
		target: 		Ext.getCmp('{$winId}createItem').getEl(),
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_CREATE_NEW_LANGUAGE)}'
	});
	
	resultsPanel.getSelectionModel().on('selectionchange', function(sm){
		if (!sm.getCount()) {
			qtips['edit'].disable();
			Ext.getCmp('{$winId}editItem').disable();
		} else { //enable / disable buttons allowed by selection
			qtips['edit'].enable();
			Ext.getCmp('{$winId}editItem').enable();
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