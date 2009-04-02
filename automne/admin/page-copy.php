<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: page-copy.php,v 1.3 2009/04/02 13:55:54 sebastien Exp $

/**
  * PHP page : Load copy-page window.
  * Used accross an Ajax request
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_COPY_INFO",350);
define("MESSAGE_PAGE_COPY_CONTENT",351);
define("MESSAGE_PAGE_REPLACE_TEMPLATE",352);
define("MESSAGE_PAGE_MATCHING_TEMPLATE",353);
define("MESSAGE_PAGE_UNMATCHING_TEMPLATE",354);
define("MESSAGE_PAGE_SELECT_COPIED_MOTHER",355);
define("MESSAGE_PAGE_COPY_OK",1361);
define("MESSAGE_PAGE_COPY_FATHER_INFO",356);
define("MESSAGE_PAGE_COPY_KEEP_CONTENT",357);
define("MESSAGE_PAGE_COPY_NOTKEEP_CONTENT",358);
define("MESSAGE_PAGE_COPY_KEEP_TEMPLATE",359);
define("MESSAGE_PAGE_COPY_NOTKEEP_TEMPLATE",360);
define("MESSAGE_PAGE_COPY_CONFIRM",361);
define("MESSAGE_PAGE_CANCEL",180);
define("MESSAGE_PAGE_COPY",499);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

$winId = sensitiveIO::request('winId', '', 'copyPageWindow');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger');

//try to instanciate the requested page
$cms_page = CMS_tree::getPageByID($currentPage);

//instanciate page and check if user has view rights on it
if ((isset($cms_page) && $cms_page->hasError()) || !is_object($cms_page)) {
	CMS_grandFather::raiseError('Error on page : '.$cms_page->getID());
	$view->show();
}
//check for view rights for user
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_VIEW)) {
	CMS_grandFather::raiseError('Error, user has no rights on page : '.$cms_page->getID());
	$view->show();
}

$pageId = $cms_page->getID();
$pageTitle = sensitiveIO::sanitizeJSString($cms_page->getTitle(true));

$onClick = base64_encode("
	this.node.select();
");

//Page templates replacement
$pageTemplate = $cms_page->getTemplate();
//hack if page has no valid template attached
if (!is_a($pageTemplate, "CMS_pageTemplate")) {
	$pageTemplate = new CMS_pageTemplate();
}
$pageTplId = CMS_pageTemplatesCatalog::getTemplateIDForCloneID($pageTemplate->getID());
$pageTplLabel = sensitiveIO::sanitizeJSString($pageTemplate->getLabel());

$jscontent = <<<END
	var copyPageWindow = Ext.getCmp('{$winId}');
	//if we are in a window context
	
	//set window title
	copyPageWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_COPY)} \'{$pageTitle}\'');
	//set help button on top of page
	copyPageWindow.tools['help'].show();
	//add a tooltip on button
	var pageTip = new Ext.ToolTip({
		target: 		copyPageWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_INFO)}',
		dismissDelay:	0
	});
	//add 5px padding to body
	copyPageWindow.body.applyStyles('padding:5px;');
	
	var copyOptions = new Ext.form.FormPanel({
		region:			'north',
		labelWidth: 	220,
		/*autoHeight:		true,*/
		height:			60,
		border:			false,
		bodyStyle:		'padding:5px;',
		url:			'page-controler.php',
		labelAlign:		'right',
		items: [{
			fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_CONTENT)}',
			xtype:			'checkbox',
			name:			'copyContent',
			inputValue:		'1',
			checked:		true
		},{
			fieldLabel:			'<span class="atm-help" ext:qtip="Choisissez un modèle parmi ceux disponible. Un modèle compatible permet de conserver toutes les données de la page d\'origine. Un modèle incompatible ne copiera pas tout le contenu de la page d\'origine.">{$cms_language->getJsMessage(MESSAGE_PAGE_REPLACE_TEMPLATE)}</span>',
			anchor:				'100%',
			xtype:				'combo',
			name:				'template',
			forceSelection:		true,
			mode:				'remote',
			valueField:			'id',
			displayField:		'name',
			value:				'{$pageTplLabel}',
			triggerAction: 		'all',
			store:				new Automne.JsonStore({
				url: 			'page-templates-datas.php',
				baseParams:		{
					template: 		{$pageTplId},
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
			renderer:			function(field) {
				return (field.store.getAt(field.store.find(field.valueField, field.getValue()))) ? field.store.getAt(field.store.find(field.valueField, field.getValue())).get(field.displayField) : field.getValue();
			},
			allowBlank: 		false,
			selectOnFocus:		true,
			editable:			false,
			tpl: 				'<tpl for="."><div ext:qtip="{qtip}" class="x-combo-list-item {cls}">{label}</div></tpl>'
		}]
	})
	
	var pagesTree = {
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_SELECT_COPIED_MOTHER)}',
		id:				'pagesTree',
		region:			'center',
		layout: 		'atm-border',
		border: 		false,
		xtype:			'atmPanel',
		autoLoad:		{
			url:		'tree.php',
			params:		{
				winId:			'pagesTree',
				editable:		true,
				currentPage:	{$pageId},
				window:			false,
				encodedOnClick:	'{$onClick}',
				heading:		false
			},
			nocache:	true,
			scope:		this
		}
	};
	//add regions to window
	copyPageWindow.add(copyOptions);
	copyPageWindow.add(pagesTree);
	//add buttons
	var buttons = [new Ext.Button({
		text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_OK)}',
		id:			'buttonCopy',
		handler:	function() {
			//get copy infos
			var tree = Ext.getCmp('treePanelpagesTree');
			var father = tree.selModel.getSelectedNode().id.substr(4);
			var fatherLabel = tree.selModel.getSelectedNode().text;
			var copyContent = copyOptions.form.getValues().copyContent;
			var tplField = copyOptions.form.findField('template');
			var template = isNaN(tplField.getValue()) ? {$pageTplId} : tplField.getValue();
			var message = '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_FATHER_INFO, array($pageTitle, $pageId))} '+fatherLabel+'.<br />';
			if (copyContent) {
				message += '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_KEEP_CONTENT)}';
			} else {
				message += '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_NOTKEEP_CONTENT)}';
			}
			if (template == {$pageTplId}) {
				message += '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_KEEP_TEMPLATE)}';
			} else {
				message += '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_NOTKEEP_TEMPLATE)}';
			}
			message += '{$cms_language->getJsMessage(MESSAGE_PAGE_COPY_CONFIRM)}';
			Automne.message.popup({
				msg: 				message,
				buttons: 			Ext.MessageBox.OKCANCEL,
				animEl: 			Ext.getCmp('buttonCopy').getEl(),
				closable: 			false,
				icon: 				Ext.MessageBox.QUESTION,
				scope:				{
					currentPage:		father,
					copyContent:		copyContent,
					template:			template,
					copiedPage:			{$pageId}
				},
				fn: 				function (button) {
					if (button == 'ok') {
						Automne.server.call({
							url:				'page-controler.php',
							params: 			{
								currentPage:		this.currentPage,
								copyContent:		this.copyContent,
								template:			this.template,
								copiedPage:			this.copiedPage,
								action:				'copy'
							}
						});
						copyPageWindow.close();
					}
				}
			});
		},
		scope:		copyPageWindow
	}), new Ext.Button({
		text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CANCEL)}',
		handler:	function() {
			this.close();
		},
		scope:		copyPageWindow
	})];
	
	copyPageWindow.addButtons(buttons);
	copyPageWindow.doLayout();
	copyPageWindow.setWidth(copyPageWindow.width);
	copyPageWindow.setHeight(copyPageWindow.height - 70); //to correct a bug when add buttons to window
	
END;

$view->addJavascript($jscontent);
$view->show();
?>