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
// $Id: template.php,v 1.15 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load template detail window.
  * Used accross an Ajax request. Render template informations.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_SELECT_PICTURE",528);
define("MESSAGE_IMAGE",803);
define("MESSAGE_SELECT_FILE",534);
define("MESSAGE_FIELD_GROUPS",837);
define("MESSAGE_PAGE_PROPERTIES", 7);
define("MESSAGE_PAGE_LABEL", 814);
define("MESSAGE_PAGE_DESCRIPTION", 139);
define("MESSAGE_ACTION_HELP", 1073);
define("MESSAGE_PAGE_NEW_GROUPS", 714);
define("MESSAGE_PAGE_SYNTAX_COLOR", 725);
define("MESSAGE_PAGE_ACTION_REINDENT", 726);
define("MESSAGE_PAGE_ALLOWED", 719);
define("MESSAGE_PAGE_AVAILABLE", 720);
define("MESSAGE_PAGE_XML_DEFINITION", 723);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES", 799);
define("MESSAGE_FIELD_GROUPS_DESC", 1449);
define("MESSAGE_PAGE_TEMPLATE", 1450);
define("MESSAGE_PAGE_CREATE_TEMPLATE", 1451);
define("MESSAGE_PAGE_PRINT", 1452);
define("MESSAGE_PAGE_PRINT_DESC", 1453);
define("MESSAGE_PAGE_PRINT_ZONES", 1454);
define("MESSAGE_PAGE_SELECT", 1455);
define("MESSAGE_TOOLBAR_HELP_DESC", 1456);
define("MESSAGE_PAGE_NEW_GROUPS_DESC", 1457);
define("MESSAGE_PAGE_NEW_GROUPS_NO_RIGHTS_DESC", 1458);
define("MESSAGE_PAGE_NEW_GROUPS_NO_RIGHTS", 1459);
define("MESSAGE_PAGE_WEBSITES_DESC", 1460);
define("MESSAGE_PAGE_WEBSITES", 1461);
define("MESSAGE_PAGE_THUMBNAIL_DESC", 1462);
define("MESSAGE_PAGE_THUMBNAIL", 1463);
define("MESSAGE_PAGE_XML_DEFINITION_DESC", 1464);
define("MESSAGE_PAGE_XML_FILE", 1465);
define("MESSAGE_PAGE_XML_DEFINITION_USAGE_DESC", 1466);
define("MESSAGE_PAGE_DEFAULT_ROWS", 1467);
define("MESSAGE_PAGE_SAVE_AND_REGEN", 1548);
define("MESSAGE_PAGE_SAVE_AND_REGEN_DESC", 1550);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);

$winId = sensitiveIO::request('winId', '', 'templateWindow');
$templateId = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger', 'createTemplate');

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

//load template if any
if (sensitiveIO::isPositiveInteger($templateId)) {
	$template = CMS_pageTemplatesCatalog::getByID($templateId);
	if (!$template || $template->hasError()) {
		CMS_grandFather::raiseError('Unknown template for given Id : '.$templateId);
		$view->show();
	}
} else {
	//create new user
	$template = new CMS_pageTemplate();
}

//MAIN TAB

//Need to sanitize all datas which can contain single quotes
$label = sensitiveIO::sanitizeJSString($template->getLabel());
$description = sensitiveIO::sanitizeJSString($template->getDescription(), false, true, true); //this is a textarea, we must keep cariage return
$templateDefinition = $template->getDefinition();
$imageName = $template->getImage();
$templateGroups = $template->getGroups();
$websitesDenied = $template->getWebsitesDenied();

//image
$maxFileSize = CMS_file::getMaxUploadFileSize('K');
if ($imageName && file_exists(PATH_TEMPLATES_IMAGES_FS.'/'.$imageName) && $imageName != 'nopicto.gif') {
	$image = new CMS_file(PATH_TEMPLATES_IMAGES_FS.'/'.$imageName);
	$imageDatas = array(
		'filename'		=> $image->getName(false),
		'filepath'		=> $image->getFilePath(CMS_file::WEBROOT),
		'filesize'		=> $image->getFileSize(),
		'fileicon'		=> $image->getFileIcon(CMS_file::WEBROOT),
		'extension'		=> $image->getExtension(),
	);
} else {
	$imageDatas = array(
		'filename'		=> '',
		'filepath'		=> '',
		'filesize'		=> '',
		'fileicon'		=> '',
		'extension'		=> '',
	);
}
$imageDatas = sensitiveIO::jsonEncode($imageDatas);

$fileDatas = array(
	'filename'		=> '',
	'filepath'		=> '',
	'filesize'		=> '',
	'fileicon'		=> '',
	'extension'		=> '',
);

//Groups
$allGroups = CMS_pageTemplatesCatalog::getAllGroups();
$groupsfield = '';
if ($allGroups) {
	$columns = sizeof($allGroups) < 5 ? sizeof($allGroups) : 5;
	$groupsfield .= "{
		xtype: 		'checkboxgroup',
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"{$cms_language->getJsMessage(MESSAGE_FIELD_GROUPS_DESC)}\">{$cms_language->getJsMessage(MESSAGE_FIELD_GROUPS)}</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allGroups as $aGroup) {
			$groupsfield .= "{boxLabel: '{$aGroup}', inputValue:'{$aGroup}', name: 'groups[]', checked:".(isset($templateGroups[$aGroup]) ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$groupsfield = io::substr($groupsfield, 0, -1);
		$groupsfield .= "
		]
	},";
}

//Websites
$websites = CMS_websitesCatalog::getAll();
$availableWebsites = $selectedWebsites = array();
foreach ($websites as $id => $website) {
	if (!isset($websitesDenied[$id])) {
		$selectedWebsites[] = array($id, $website->getLabel());
	} else {
		$availableWebsites[] = array($id, $website->getLabel());
	}
}
$availableWebsites = sensitiveIO::jsonEncode($availableWebsites);
$selectedWebsites = sensitiveIO::jsonEncode($selectedWebsites);

//DEFINITION TAB
$content = '
<textarea id="tpl-definition-'.$templateId.'" style="display:none;">'.htmlspecialchars($templateDefinition).'</textarea>';
$view->setContent($content);

$title = sensitiveIO::isPositiveInteger($templateId) ? $cms_language->getJSMessage(MESSAGE_PAGE_TEMPLATE).' '.$label : $cms_language->getJSMessage(MESSAGE_PAGE_CREATE_TEMPLATE);

$rowsURL = PATH_ADMIN_WR.'/templates-rows.php';

$printTab = '';
if (USE_PRINT_PAGES) {
	$cstags = $template->getClientSpacesTags();
	if (!is_array($cstags)) {
		$cstags = array();
	}
	$clientspaces = array();
	$printableCS = array();
	$print_clientspaces = $template->getPrintingClientSpaces();
	foreach ($cstags as $tag) {
		$id = $tag->getAttribute("id");
		//$module = $tag->getAttribute("module");
		if (!in_array($id, $print_clientspaces)) {
			$clientspaces[] = array($id);
		} else {
			$printableCS[] =  array($id);
		}
	}
	$clientspaces = sensitiveIO::jsonEncode($clientspaces);
	$printableCS = sensitiveIO::jsonEncode($printableCS);
	
	$printTab = ",{
		id:				'printcs-{$templateId}',
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_PRINT)}',
		layout: 		'form',
		xtype:			'atmForm',
		url:			'templates-controler.php',
		bodyStyle: 		'padding:5px',
		labelAlign:		'right',
		border:			false,
		buttonAlign:	'center',
		items:[{
			xtype:			'panel',
			border:			false,
			html:			'{$cms_language->getJsMessage(MESSAGE_PAGE_PRINT_DESC)}',
			bodyStyle: 		'padding:10px 0 10px 0'
		},{
			xtype:			'itemselector',
			name:			'printableCS',
			fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_PRINT_ZONES)}',
			dataFields:		['code'],
			toData:			{$printableCS},
			msWidth:		250,
			msHeight:		130,
			height:			140,
			valueField:		'code',
			displayField:	'code',
			toLegend:		'{$cms_language->getJsMessage(MESSAGE_PAGE_SELECT)}',
			fromLegend:		'{$cms_language->getJsMessage(MESSAGE_PAGE_AVAILABLE)}',
			fromData:		{$clientspaces}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('printcs-{$templateId}').getForm();
				form.submit({
					params:{
						action:		'printcs',
						templateId:	templateWindow.templateId
					},
					scope:this
				});
			}
		}]
	}";
}

$automnePath = PATH_MAIN_WR;
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
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});
	//editor var
	var editor;
	//create center panel
	var center = new Ext.TabPanel({
		activeTab:			 0,
		id:					'templatePanels-{$templateId}',
		region:				'center',
		border:				false,
		enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		listeners: {
			'beforetabchange' : function(tabPanel, newTab, currentTab ) {
				if (newTab.beforeActivate) {
					newTab.beforeActivate(tabPanel, newTab, currentTab);
				}
				return true;
			},
			'tabchange': function(tabPanel, newTab) {
				if (newTab.afterActivate) {
					newTab.afterActivate(tabPanel, newTab);
				}
			}
		},
		items:[{
			id:					'templateDatas-{$templateId}',
			title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_PROPERTIES)}',
			autoScroll:			true,
			url:				'templates-controler.php',
			layout: 			'form',
			xtype:				'atmForm',
			labelWidth:			120,
			border:				false,
			labelAlign:			'right',
			defaultType:		'textfield',
			bodyStyle: 			'padding:5px',
			buttonAlign:	'center',
			defaults: {
				xtype:				'textfield',
				anchor:				'97%',
				allowBlank:			true
			},
			items:[{
				fieldLabel:		'<span class="atm-red">*</span> {$cms_language->getJsMessage(MESSAGE_PAGE_LABEL)}',
				name:			'label',
				value:			'{$label}',
				allowBlank:		false
			},{
				fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_DESCRIPTION)}',
				xtype:			'textarea',
				name:			'description',
				value:			"{$description}"
			},{$groupsfield}{
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_GROUPS_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_GROUPS)}</span>',
				name:			'newgroup',
				value:			''
			},{
				fieldLabel:		'',
				labelSeparator:	'',
				xtype:			'checkbox',
				boxLabel: 		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_GROUPS_NO_RIGHTS_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_GROUPS_NO_RIGHTS)}</span>',
				name: 			'nouserrights',
				inputValue:		'1'
			},{
				xtype:			"itemselector",
				name:			"websites",
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_WEBSITES_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_WEBSITES)}</span>',
				dataFields:		["code", "desc"],
				toData:			{$selectedWebsites},
				msWidth:		250,
				msHeight:		130,
				height:			140,
				valueField:		"code",
				displayField:	"desc",
				toLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_ALLOWED)}",
				fromLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_AVAILABLE)}",
				fromData:		{$availableWebsites}
			},{
				xtype: 			'atmImageUploadField',
				emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
				fieldLabel: 	'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_THUMBNAIL_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_THUMBNAIL)}</span>',
				name: 			'image',
				maxWidth:		240,
	            uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.jpg;*.png;*.gif',
					file_types_description:	'{$cms_language->getJsMessage(MESSAGE_IMAGE)} ...'
				},
				fileinfos:	{$imageDatas}
			},{
				xtype: 			'atmFileUploadField',
				id: 			'form-file',
				emptyText: 		'{$cms_language->getJSMessage(MESSAGE_SELECT_FILE)}',
				fieldLabel: 	'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_XML_DEFINITION_DESC)}">{$cms_language->getJSMessage(MESSAGE_PAGE_XML_DEFINITION)}</span>',
				name: 			'definitionfile',
				uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.xml',
					file_types_description:	'{$cms_language->getJsMessage(MESSAGE_PAGE_XML_FILE)}'
				},
				fileinfos:	{$fileDatas}
			}],
			buttons:[{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				iconCls:		'atm-pic-validate',
				anchor:			'',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('templateDatas-{$templateId}').getForm();
					if (form.isValid()) {
						form.submit({
							params:{
								action:		'properties',
								templateId:	templateWindow.templateId
							},
							success:function(form, action){
								//if it is a successful user creation
								if (action.result.success != false && isNaN(parseInt(templateWindow.templateId))) {
									//set templateId
									templateWindow.templateId = action.result.success.templateId;
									//display hidden elements
									Ext.getCmp('templateDef-{$templateId}').enable();
									Ext.getCmp('templateRows-{$templateId}').enable();
									if (Ext.getCmp('print-{$templateId}')) {
										Ext.getCmp('print-{$templateId}').enable();
									}
								}
							},
							scope:this
						});
					} else {
						Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES)}', '', templateWindow);
					}
				}
			}]
		},{
			id:					'templateDef-{$templateId}',
			title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_XML_DEFINITION)}',
			autoScroll:			true,
			url:				'templates-controler.php',
			layout: 			'form',
			xtype:				'atmForm',
			border:				false,
			bodyStyle: 			'padding:5px',
			buttonAlign:		'center',
			beforeActivate:		function(tabPanel, newTab, currentTab) {
				if (!Ext.get('defText-{$templateId}')) {
					//call server for definition update
					Automne.server.call({
						url:			'page-templates-datas.php',
						scope:			this,
						fcnCallback:	function(response, options, jsonResponse){
							if (Ext.get('defText-{$templateId}')) {
								//update store
								for(var i = 0; i < jsonResponse.total; i++) {
									var data = jsonResponse.results[i];
									if (data.definition && data.definition != 'false') {
										Ext.get('defText-{$templateId}').dom.value = data.definition;
									} else {
										Ext.get('defText-{$templateId}').dom.value = '';
									}
								}
							}
						},
						params:			{
							items:			[templateWindow.templateId],
							definition:		1,
							viewinactive:	1
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
				html:			'{$cms_language->getJsMessage(MESSAGE_PAGE_XML_DEFINITION_USAGE_DESC)}',
				border:			false,
				bodyStyle: 		'padding-bottom:10px'
			}, {
				xtype:			'checkbox',
				boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SYNTAX_COLOR)}',
				listeners:		{'check':function(field, checked) {
					if (checked) {
						editor = CodeMirror.fromTextArea('defText-{$templateId}', {
							iframeClass:	'x-form-text',
							lineNumbers:	true,
							parserfile: 	["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
					                     	"../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js",
					                     	"../contrib/php/js/parsephphtmlmixed.js"],
					        /*continuousScanning: 500,*/
							stylesheet: 	["{$automnePath}/codemirror/css/xmlcolors.css", "{$automnePath}/codemirror/css/jscolors.css", "{$automnePath}/codemirror/css/csscolors.css", "{$automnePath}/codemirror/contrib/php/css/phpcolors.css"],
							path: 			"{$automnePath}/codemirror/js/",
							textWrapping:	false,
							initCallback:	function(){
								editor.reindent();
							}
						});
						field.disable();
						Ext.getCmp('reindent-{$templateId}').show();
					}
				}, scope:this}
			}, {
				id:				'defText-{$templateId}',
				xtype:			'textarea',
				name:			'definition',
				cls:			'atm-code',
				anchor:			'-35, -70',
				enableKeyEvents:true,
				value:			Ext.get('tpl-definition-{$templateId}').dom.value,
				listeners:{'keypress': function(field, e){
					var k = e.getKey();
					//manage TAB press
					if(k == e.TAB) {
						e.stopEvent();
						var myValue = '    ';//'\t';
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
				}, 'resize': function(field, width, height){
					if (editor) { //resize editor according to textarea size
						if (width) editor.frame.style.width = (width - 8) + 'px';
						if (height) editor.frame.style.height = (height - 6) + 'px';
					}
				},
				scope:this}
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
							popupable:		true,
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
			}, {
				id:				'reindent-{$templateId}',
				iconCls:		'atm-pic-reindent',
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_REINDENT)}',
				anchor:			'',
				hidden:			true,
				listeners:		{'click':function(button) {
					editor.reindent();
				}, scope:this}
			},{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				iconCls:		'atm-pic-validate',
				anchor:			'',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('templateDef-{$templateId}').getForm();
					if (editor) {
						form.setValues({'defText-{$templateId}': editor.getCode().replace(/  /g, "\t")});
					}
					form.submit({
						params:{
							action:		'definition',
							regenerate:	0,
							templateId:	templateWindow.templateId
						},
						scope:this
					});
				}
			},{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE_AND_REGEN)}',
				iconCls:		'atm-pic-reload',
				anchor:			'',
				scope:			this,
				tooltip:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE_AND_REGEN_DESC)}',
				handler:		function() {
					var form = Ext.getCmp('templateDef-{$templateId}').getForm();
					if (editor) {
						form.setValues({'defText-{$templateId}': editor.getCode().replace(/  /g, "\t")});
					}
					form.submit({
						params:{
							action:		'definition',
							regenerate:	1,
							templateId:	templateWindow.templateId
						},
						scope:this
					});
				}
			}]
		},{
			xtype:			'framePanel',
			title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_DEFAULT_ROWS)}',
			id:				'templateRows-{$templateId}',
			editable:		true,
			frameURL:		'{$rowsURL}?template={$templateId}',
			allowFrameNav:	false
		}{$printTab}]
	});
	
	templateWindow.add(center);
	//redo windows layout
	templateWindow.doLayout();
	
	//disable all elements not usable in first user creation step
	if (isNaN(parseInt(templateWindow.templateId))) {
		//hide elements
		Ext.getCmp('templateDef-{$templateId}').disable();
		Ext.getCmp('templateRows-{$templateId}').disable();
		if (Ext.getCmp('print-{$templateId}')) {
			Ext.getCmp('print-{$templateId}').disable();
		}
	}
	if (Ext.isIE) {
		center.syncSize(); //needed for IE7
	}
END;
$view->addJavascript($jscontent);
$view->show();
?>