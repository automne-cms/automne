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
// $Id: template-print.php,v 1.6 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load print template window.
  * Used accross an Ajax request. Render print template definition.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES", 799);
define("MESSAGE_ACTION_HELP", 1073);
define("MESSAGE_PAGE_TITLE", 1470);
define("MESSAGE_TOOLBAR_HELP_DESC", 1471);
define("MESSAGE_PAGE_XML_DEFINITION_USAGE_DESC", 1472);

$winId = sensitiveIO::request('winId', '', 'printTemplateWindow');
$templateId = sensitiveIO::request('template', '', 'print');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES));
	$view->show();
}

//MAIN TAB

$templateFile = new CMS_file(PATH_TEMPLATES_FS."/print.xml");
$templateDefinition = $templateFile->readContent();

//DEFINITION TAB
$content = '<textarea id="tpl-definition-'.$templateId.'" style="display:none;">'.htmlspecialchars($templateDefinition).'</textarea>';
$view->setContent($content);

$jscontent = <<<END
	var templateWindow = Ext.getCmp('{$winId}');
	templateWindow.templateId = '{$templateId}';
	//set window title
	templateWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}');
	//set help button on top of page
	templateWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 templateWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});
	//create center panel
	var center = new Automne.FormPanel({
		id:					'templateDef-{$templateId}',
		autoScroll:			true,
		url:				'templates-controler.php',
		layout: 			'form',
		region:				'center',
		plain:				true,
		border:				false,
		bodyStyle: 			'padding:5px',
		defaults: {
			anchor:				'97%',
			allowBlank:			false,
			hideLabel:			true
		},
		layoutConfig: {
	        labelAlign: 		'top'
	    },
		labelAlign: 		'top',
		beforeActivate:		function(tabPanel, newTab, currentTab) {
			if (Ext.get('defText-{$templateId}')) {
				//call server for definition update
				Automne.server.call({
					url:			'page-templates-datas.php',
					scope:			this,
					fcnCallback:	function(response, options, jsonResponse){
						//update store
						for(var i = 0; i < jsonResponse.total; i++) {
							var data = jsonResponse.results[i];
							Ext.get('defText-{$templateId}').dom.value = data.definition;
						}
					},
					params:			{
						items:			[{$templateId}],
						definition:		1
					}
				});
			}
		},
		items:[{
			xtype:			'panel',
			html:			'{$cms_language->getJsMessage(MESSAGE_PAGE_XML_DEFINITION_USAGE_DESC)}',
			border:			false,
			bodyStyle: 		'padding-bottom:10px'
		},{
			id:				'defText-{$templateId}',
			xtype:			'textarea',
			name:			'definition',
			cls:			'atm-code',
			anchor:			'-25, -65',
			enableKeyEvents:true,
			value:			Ext.get('tpl-definition-{$templateId}').dom.value,
			listeners:{'keypress': function(field, e){
				var k = e.getKey();
				//manage TAB press
				if(k == e.TAB) {
					e.stopEvent();
					var myValue = '\t';
					var myField = field.el.dom;
					if (document.selection) {//IE support
						myField.focus();
						sel = document.selection.createRange();
						sel.text = myValue;
						myField.focus();
					} else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var scrollTop = myField.scrollTop;
						myField.value = myField.value.substring(0, startPos)
						              + myValue 
				                      + myField.value.substring(endPos, myField.value.length);
						myField.focus();
						myField.selectionStart = startPos + myValue.length;
						myField.selectionEnd = startPos + myValue.length;
						myField.scrollTop = scrollTop;
					}
				}
			}}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_ACTION_HELP)}',
			iconCls:		'atm-pic-question',
			anchor:			'',
			scope:			this,
			handler:		function(button) {
				var windowId = 'templateHelpWindow';
				if (Ext.WindowMgr.get(windowId)) {
					Ext.WindowMgr.bringToFront(windowId);
				} else {
					//create window element
					var win = new Automne.Window({
						id:				windowId,
						modal:			false,
						father:			templateWindow.father,
						autoLoad:		{
							url:			'template-help.php',
							params:			{
								winId:			windowId
							},
							nocache:		true,
							scope:			this
						}
					});
					
					//display window
					win.show(button.getEl());
				}
			}
		},{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			anchor:			'',
			scope:			this,
			handler:		function() {
				var form = Ext.getCmp('templateDef-{$templateId}').getForm();
				form.submit({
					params:{
						action:		'definition',
						templateId:	templateWindow.templateId
					},
					scope:this
				});
			}
		}]
	});
	
	templateWindow.add(center);
	//redo windows layout
	templateWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>