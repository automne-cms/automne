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
// $Id: template-print.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Load print template window.
  * Used accross an Ajax request. Render print template definition.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);

$winId = sensitiveIO::request('winId', '', 'printTemplateWindow');
$templateId = sensitiveIO::request('template', '', 'print');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage('Vous n\'avez pas le droit de gérer les modèles de pages ...');
	$view->show();
}

//MAIN TAB

$templateFile = new CMS_file(PATH_TEMPLATES_FS."/print.xml");
$templateDefinition = $templateFile->readContent();

//DEFINITION TAB
$content = '<textarea id="tpl-definition-'.$templateId.'" style="display:none;">'.htmlspecialchars($templateDefinition).'</textarea>';
$view->setContent($content);

$title = 'Edition du modèle d\\\'impression des pages';

$jscontent = <<<END
	var templateWindow = Ext.getCmp('{$winId}');
	templateWindow.templateId = '{$templateId}';
	//set window title
	templateWindow.setTitle('{$title}');
	//set help button on top of page
	templateWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 templateWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 'Cette page vous permet de créer et modifier le modèle d\'impression employé pour les pages. Ce modèle sert à créer une version spécifique pour l\'impression des différentes pages des sites.',
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
		defaults: {
			anchor:				'97%',
			allowBlank:			false,
			hideLabel:			true
		},
		items:[{
			xtype:			'panel',
			html:			'Vous pouvez modifier ici la structure XML de ce modèle. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, les tags atm-clientspace ne fonctionnent pas pour ce modèle, utilisez <strong>{{data}}</strong> pour préciser l\'endroit ou vous souhaitez que le contenu de la page apparaisse.',
			border:			false,
			bodyStyle: 		'padding-bottom:10px'
		},{
			id:				'defText-{$templateId}',
			xtype:			'textarea',
			name:			'definition',
			cls:			'atm-code',
			anchor:			'0, -50',
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
			text:			'Aide',
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