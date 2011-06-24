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
// $Id: page-add.php,v 1.9 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : Load add-page window infos. Set title and template then redirect to page content edition
  * Used accross an Ajax request
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);

define("MESSAGE_PAGE_CREATING_NEW_PAGE",342);
define("MESSAGE_PAGE_CREATING_NEW_PAGE_INFO",343);
define("MESSAGE_PAGE_NAME",344);
define("MESSAGE_PAGE_GROUPS", 837);
define("MESSAGE_PAGE_NO_TEMPLATE_AVAILABLE", 345);
define("MESSAGE_PAGE_TITLE", 346);
define("MESSAGE_PAGE_LINK_TITLE", 347);
define("MESSAGE_PAGE_CHOOSE_TEMPLATE", 348);
define("MESSAGE_PAGE_CREATE", 90);
define("MESSAGE_PAGE_CANCEL", 180);
define("MESSAGE_PAGE_NO_ALL_REQUIRED_FIELDS", 349);
define("MESSAGE_PAGE_DEFAULT_ROWS_HELP", 564);
define("MESSAGE_PAGE_DEFAULT_ROWS", 565);
define("MESSAGE_PAGE_FILTER", 693);
define("MESSAGE_PAGE_WEBSITES", 1461);
define('MESSAGE_PAGE_FATHER_PAGE', 1721);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId', '', 'addPageWindow');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger');

//try to instanciate the requested page
$cms_page = CMS_tree::getPageByID($currentPage);

//instanciate page and check if user has view rights on it
if (isset($cms_page) && $cms_page->hasError()) {
	CMS_grandFather::raiseError('Error on page : '.$cms_page->getID());
	$view->show();
}
$website = $cms_page->getWebsite();
//check for edit rights for user
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on page : '.$cms_page->getID());
	$view->show();
}

$jscontent = <<<END
	var addPageWindow = Ext.getCmp('{$winId}');
	//if we are in a window context
	
	//set window title 
	addPageWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_CREATING_NEW_PAGE)}');
	//set help button on top of page
	addPageWindow.tools['help'].show();
	//add a tooltip on button
	var pageTip = new Ext.ToolTip({
		target: 		addPageWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_CREATING_NEW_PAGE_INFO)}',
		dismissDelay:	0
	});
	
	var lookup = {};
	var thumbTemplate = new Ext.XTemplate(
		'<tpl for=".">',
			'<div class="thumb-wrap" id="{label}">',
			'<div class="thumb"><img src="{image}" title="{label}"></div>',
			'<span>{shortName}</span></div>',
		'</tpl>'
	);
	thumbTemplate.compile();
	
	var detailsTemplate = new Ext.XTemplate(
		'<div class="details">',
			'<tpl for=".">',
				'<img src="{image}"><div class="details-info">',
				'<b>{$cms_language->getJsMessage(MESSAGE_PAGE_NAME)} :</b>',
				'<strong>{label}</strong>',
				'<span>{desc:nl2br}</span>',
				'<b>{$cms_language->getJsMessage(MESSAGE_PAGE_GROUPS)} :</b>',
				'<span>{groups}</span>',
				'<b>{$cms_language->getJsMessage(MESSAGE_PAGE_WEBSITES)} :</b>',
				'<span>{websites}</span>',
			'</tpl>',
		'</div>'
	);
	detailsTemplate.compile();
	
	var store = new Automne.JsonStore({
		url: 			'page-templates-datas.php',
		baseParams:		{website:{$website->getID()}},
		root: 			'results',
		fields: 		['id', 'label', 'desc', 'image', 'groups', 'filter', 'websites'],
		listeners: {
			'load': 		{fn:function(){ view.select(0);}, single:true}
		}
	});
	store.load();
	
	var filter = function(){
		var filter = Ext.getCmp('filter');
		view.store.filter('filter', filter.getValue(), true, false);
		view.select(0);
	}
	
	var view = new Ext.DataView({
		tpl: 			thumbTemplate,
		singleSelect: 	true,
		overClass:		'x-view-over',
		itemSelector: 	'div.thumb-wrap',
		emptyText : 	'<div style="padding:10px;">{$cms_language->getJsMessage(MESSAGE_PAGE_NO_TEMPLATE_AVAILABLE)}</div>',
		store: 			store,
		listeners: {
			'selectionchange': {fn:function(){
				var selNode = view.getSelectedNodes();
				var detailEl = Ext.getCmp('atm-detail-panel').body;
				if(selNode && selNode.length > 0){
					selNode = selNode[0];
					//Ext.getCmp('ok-btn').enable();
					var data = lookup[selNode.id];
					detailEl.hide();
					detailsTemplate.overwrite(detailEl, data);
					detailEl.slideIn('l', {stopFx:true,duration:.2});
				}else{
					//Ext.getCmp('ok-btn').disable();
					detailEl.update('');
				}
			}, scope:this, buffer:100},
			'beforeselect': {fn:function(view){
		        return view.store.getRange().length > 0;
		    }}
		},
		prepareData: function(data){
	    	data.shortName = data.label.ellipse(15);
	    	lookup[data.label] = data;
	    	return data;
		}
	});
	var pageTitle = new Ext.form.FormPanel({
		region:			'north',
		labelWidth: 	120,
		autoHeight:		true,
		bodyStyle:		'padding:5px;',
		defaultType: 	'textfield',
		labelAlign:		'right',
		border:			false,
		items: [{
			fieldLabel:		'<span class="atm-red">*</span> {$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}',
			name:			'title',
			anchor:			'100%',
			allowBlank:		false
		},{
			fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_LINK_TITLE)}',
			name:			'linktitle',
			anchor:			'100%'
		},{
			fieldLabel:		'<span class="atm-red">*</span> {$cms_language->getJsMessage(MESSAGE_PAGE_FATHER_PAGE)}',
			name:			'parent',
			xtype:			'atmPageField',
			value:			'{$cms_page->getID()}',
			anchor:			'100%',
			allowBlank:		false
		},{
			fieldLabel:		'',
			labelSeparator:	'',
			boxLabel:		'<span ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_DEFAULT_ROWS_HELP)}" class="atm-help">{$cms_language->getJsMessage(MESSAGE_PAGE_DEFAULT_ROWS)}</span>',
			name:			'emptytpl',
			xtype:			'checkbox',
			inputValue:		1,
			anchor:			'100%'
		}]
	})
	
	var pageTemplate = {
		id: 			'atm-chooser-dlg',
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_CHOOSE_TEMPLATE)}',
		region:			'center',
		layout: 		'border',
		border: 		false,
		items:[{
			id: 			'atm-chooser-view',
			region: 		'center',
			autoScroll: 	true,
			items: 			view,
			border:			false,
			tbar:[{
				xtype: 			'textfield',
				emptyText:		'{$cms_language->getJsMessage(MESSAGE_PAGE_FILTER)}',
				id: 			'filter',
				selectOnFocus: 	true,
				width: 			300,
				listeners: 		{
					'render': {fn:function(){
						Ext.getCmp('filter').getEl().on('keyup', filter, this, {buffer:500});
					}, scope:this}
				}
			}]
		},{
			id: 			'atm-detail-panel',
			border:			false,
			autoScroll: 	true,
			region: 		'east',
			split: 			true,
			width: 			280
		}]
	};
	//add regions to window
	addPageWindow.add(pageTitle);
	addPageWindow.add(pageTemplate);
	//add buttons
	var buttons = [new Ext.Button({
		text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CREATE)}',
		iconCls:	'atm-pic-ok',
		handler:	function() {
			var selNode = view.getSelectedNodes()[0];
			if(selNode && pageTitle.form.isValid()) {
				//do valid stuff
				var templateId = lookup[selNode.id].id;
				var values = pageTitle.form.getValues();
				Automne.server.call({
					url:				'page-controler.php',
					params: 			{
						title:				values.title,
						linktitle:			values.linktitle,
						father:				values.parent,
						template:			templateId,
						emptytpl:			values.emptytpl,
						action:				'creation'
					}
				});
				this.close();
			} else {
				//send error message
				Automne.message.popup({
					msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_NO_ALL_REQUIRED_FIELDS)}',
					buttons: 			Ext.MessageBox.OK,
					closable: 			true,
					icon: 				Ext.MessageBox.ERROR
				});
			}
		},
		scope:		addPageWindow
	}), new Ext.Button({
		text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CANCEL)}',
		iconCls:	'atm-pic-cancel',
		handler:	function() {this.close();},
		scope:		addPageWindow
	})];
	
	addPageWindow.addButtons(buttons);
	addPageWindow.doLayout();
END;

$view->addJavascript($jscontent);
$view->show();
?>