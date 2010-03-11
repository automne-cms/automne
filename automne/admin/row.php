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
// $Id: row.php,v 1.13 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP page : Load row detail window.
  * Used accross an Ajax request. Render row informations.
  *
  * @package CMS
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
define("MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS", 706);
define("MESSAGE_FIELD_GROUPS_DESC", 707);
define("MESSAGE_FIELD_ICON_DESC", 708);
define("MESSAGE_FIELD_ICON", 709);
define("MESSAGE_PAGE_ROW", 710);
define("MESSAGE_PAGE_ROW_CREATE", 711);
define("MESSAGE_TOOLBAR_HELP_DESC", 712);
define("MESSAGE_PAGE_NEW_GROUPS_DESC", 713);
define("MESSAGE_PAGE_NEW_GROUPS", 714);
define("MESSAGE_PAGE_NO_GROUPS_RIGHTS_DESC", 715);
define("MESSAGE_PAGE_NO_GROUPS_RIGHTS", 716);
define("MESSAGE_PAGE_PAGE_TEMPLATES_DESC", 717);
define("MESSAGE_PAGE_PAGE_TEMPLATES", 718);
define("MESSAGE_PAGE_ALLOWED", 719);
define("MESSAGE_PAGE_AVAILABLE", 720);
define("MESSAGE_PAGE_NEW_ICON_DESC", 721);
define("MESSAGE_PAGE_NEW_ICON", 722);
define("MESSAGE_PAGE_XML_DEFINITION", 723);
define("MESSAGE_PAGE_XML_DEFINITION_DESC", 724);
define("MESSAGE_PAGE_SYNTAX_COLOR", 725);
define("MESSAGE_PAGE_ACTION_REINDENT", 726);
define("MESSAGE_PAGE_SAVE_AND_REGEN", 1548);
define("MESSAGE_PAGE_SAVE_AND_REGEN_DESC", 1549);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);

$winId = sensitiveIO::request('winId', '', 'rowWindow');
$rowId = sensitiveIO::request('row', 'sensitiveIO::isPositiveInteger', 'createRow');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has row edition clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	CMS_grandFather::raiseError('User has no rights on rows editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS));
	$view->show();
}

//load row if any
if (sensitiveIO::isPositiveInteger($rowId)) {
	$row = CMS_rowsCatalog::getByID($rowId);
	if (!$row || $row->hasError()) {
		CMS_grandFather::raiseError('Unknown row for given Id : '.$rowId);
		$view->show();
	}
} else {
	//create new row
	$row = new CMS_row();
}

//MAIN TAB

//Need to sanitize all datas which can contain single quotes
$label = $row->getLabel();
$description = sensitiveIO::sanitizeJSString($row->getDescription(), false, true, true); //this is a textarea, we must keep cariage return
$rowDefinition = $row->getDefinition();
$rowGroups = $row->getGroups();

//image
$maxFileSize = CMS_file::getMaxUploadFileSize('K');
$imageDatas = array(
	'filename'		=> '',
	'filepath'		=> '',
	'filesize'		=> '',
	'fileicon'		=> '',
	'extension'		=> '',
);
$imageDatas = sensitiveIO::jsonEncode($imageDatas);

//Groups
$allGroups = CMS_rowsCatalog::getAllGroups();
$groupsfield = '';
if ($allGroups) {
	$columns = sizeof($allGroups) < 5 ? sizeof($allGroups) : 5;
	$groupsfield .= "{
		xtype: 		'checkboxgroup',
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"{$cms_language->getJsMessage(MESSAGE_FIELD_GROUPS_DESC)}\">{$cms_language->getJsMessage(MESSAGE_FIELD_GROUPS)}</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allGroups as $aGroup) {
			$groupsfield .= "{boxLabel: '{$aGroup}', inputValue:'{$aGroup}', name: 'groups[]', checked:".(isset($rowGroups[$aGroup]) ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$groupsfield = io::substr($groupsfield, 0, -1);
		$groupsfield .= "
		]
	},";
}

//images
$allIcons = CMS_rowsCatalog::getAllIcons();
$iconsField = '';


if ($allIcons) {
	//get max icons height
	$maxheight = 0;
	foreach ($allIcons as $icon) {
		list($sizeX, $sizeY) = @getimagesize(PATH_REALROOT_FS."/".$icon);
		$maxheight = $sizeY > $maxheight ? $sizeY : $maxheight;
	}
	$maxheight += 10;
	$columns = sizeof($allIcons) < 5 ? sizeof($allIcons) : 5;
	$iconsField .= "{
		xtype: 		'radiogroup',
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"{$cms_language->getJsMessage(MESSAGE_FIELD_ICON_DESC)}\">{$cms_language->getJsMessage(MESSAGE_FIELD_ICON)}</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allIcons as $icon) {
			$iconsField .= "{boxLabel: '<img src=\"{$icon}\">', height:".$maxheight.", inputValue:'{$icon}', name: 'image', checked:".($row->getImage() == $icon ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$iconsField = io::substr($iconsField, 0, -1);
		$iconsField .= "
		]
	},";
}

//Templates filters
$filteredTemplates = $row->getFilteredTemplates();
$templates = CMS_pageTemplatesCatalog::getAll(true, '', array(), '', array(), $cms_user, 0, 0, true);
$availableTemplates = $selectedTemplates = array();
foreach ($templates as $id => $template) {
	if (in_array($id, $filteredTemplates)) {
		$selectedTemplates[] = array($id, $template->getLabel());
	} else {
		$availableTemplates[] = array($id, $template->getLabel());
	}
}
$availableTemplates = sensitiveIO::jsonEncode($availableTemplates);
$selectedTemplates = sensitiveIO::jsonEncode($selectedTemplates);

//DEFINITION TAB
$rowDefinition = ($rowDefinition) ? $rowDefinition : '<row></row>';
$content = '<textarea id="row-definition-'.$rowId.'" style="display:none;">'.htmlspecialchars($rowDefinition).'</textarea>';
$view->setContent($content);

$title = sensitiveIO::sanitizeJSString((sensitiveIO::isPositiveInteger($rowId)) ? $cms_language->getMessage(MESSAGE_PAGE_ROW).' '.$label : $cms_language->getMessage(MESSAGE_PAGE_ROW_CREATE));

$label = sensitiveIO::sanitizeJSString($label);

$automnePath = PATH_MAIN_WR;

$jscontent = <<<END
	var rowWindow = Ext.getCmp('{$winId}');
	rowWindow.rowId = '{$rowId}';
	//set window title
	rowWindow.setTitle('{$title}');
	//set help button on top of page
	rowWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:			rowWindow.tools['help'],
		title:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});
	//editor var
	var editor;
	//create center panel
	var center = new Ext.TabPanel({
		activeTab:			 0,
		id:					'rowPanels-{$rowId}',
		region:				'center',
		border:				false,
		enableTabScroll:	true,
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
			id:					'rowDatas-{$rowId}',
			title:				'{$cms_language->getJsMessage(MESSAGE_PAGE_PROPERTIES)}',
			autoScroll:			true,
			url:				'rows-controler.php',
			layout: 			'form',
			xtype:				'atmForm',
			labelWidth:			120,
			border:				false,
			labelAlign:			'right',
			defaultType:		'textfield',
			bodyStyle: 			'padding:5px',
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
				boxLabel: 		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_NO_GROUPS_RIGHTS_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_NO_GROUPS_RIGHTS)}</span>',
				name: 			'nouserrights',
				inputValue:		'1'
			},{
				xtype:			"itemselector",
				name:			"templates",
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_PAGE_TEMPLATES_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_PAGE_TEMPLATES)}</span>',
				dataFields:		["code", "desc"],
				toData:			{$selectedTemplates},
				msWidth:		250,
				msHeight:		130,
				height:			140,
				valueField:		"code",
				displayField:	"desc",
				toLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_ALLOWED)}",
				fromLegend:		"{$cms_language->getJsMessage(MESSAGE_PAGE_AVAILABLE)}",
				fromData:		{$availableTemplates}
			},{$iconsField}{
				xtype: 			'atmImageUploadField',
				emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
				fieldLabel: 	'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_ICON_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_NEW_ICON)}</span>',
				name: 			'newimage',
				maxWidth:		70,
				uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.jpg;*.png;*.gif',
					file_types_description:	'{$cms_language->getJsMessage(MESSAGE_IMAGE)} ...'
				},
				fileinfos:	{$imageDatas}
			}],
			buttons:[{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				iconCls:		'atm-pic-validate',
				anchor:			'',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('rowDatas-{$rowId}').getForm();
					if (form.isValid()) {
						form.submit({
							params:{
								action:		'properties',
								rowId:		rowWindow.rowId
							},
							success:function(form, action){
								//if it is a successful user creation
								if (action.result.success != false && isNaN(parseInt(rowWindow.rowId))) {
									//set rowId
									rowWindow.rowId = action.result.success.rowId;
									Ext.getCmp('rowDef-{$rowId}').enable();
								}
							},
							scope:this
						});
					} else {
						Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES)}', '', rowWindow);
					}
				}
			}]
		},{
			id:					'rowDef-{$rowId}',
			title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_XML_DEFINITION)}',
			autoScroll:			true,
			url:				'rows-controler.php',
			layout: 			'form',
			xtype:				'atmForm',
			border:				false,
			bodyStyle: 			'padding:5px',
			beforeActivate:		function(tabPanel, newTab, currentTab) {
				if (Ext.get('defText-{$rowId}')) {
					//call server for definition update
					Automne.server.call({
						url:			'page-rows-datas.php',
						scope:			this,
						fcnCallback:	function(response, options, jsonResponse){
							//update store
							for(var i = 0; i < jsonResponse.total; i++) {
								var data = jsonResponse.results[i];
								Ext.get('defText-{$rowId}').dom.value = data.definition;
							}
						},
						params:			{
							items:			[rowWindow.rowId],
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
				html:			'{$cms_language->getJSMessage(MESSAGE_PAGE_XML_DEFINITION_DESC)}',
				border:			false,
				bodyStyle: 		'padding-bottom:10px'
			}, {
				xtype:			'checkbox',
				boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SYNTAX_COLOR)}',
				listeners:		{'check':function(field, checked) {
					if (checked) {
						editor = CodeMirror.fromTextArea('defText-{$rowId}', {
							iframeClass:	'x-form-text',
							lineNumbers:	true,
							parserfile:		["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
											"../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js",
											"../contrib/php/js/parsephphtmlmixed.js"],
					        stylesheet: 	["{$automnePath}/codemirror/css/xmlcolors.css", "{$automnePath}/codemirror/css/jscolors.css", "{$automnePath}/codemirror/css/csscolors.css", "{$automnePath}/codemirror/contrib/php/css/phpcolors.css"],
							path: 			"{$automnePath}/codemirror/js/",
							textWrapping:	false,
							initCallback:	function(){
								editor.reindent();
							}
						});
						field.disable();
						Ext.getCmp('reindent-{$rowId}').show();
					}
				}, scope:this}
			},{
				id:				'defText-{$rowId}',
				xtype:			'textarea',
				name:			'definition',
				cls:			'atm-code',
				anchor:			'-35, -70',
				enableKeyEvents:true,
				value:			Ext.get('row-definition-{$rowId}').dom.value,
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
					var windowId = 'rowHelpWindow';
					if (Ext.WindowMgr.get(windowId)) {
						Ext.WindowMgr.bringToFront(windowId);
					} else {
						//create window element
						var win = new Automne.Window({
							id:				windowId,
							modal:			false,
							father:			rowWindow.father,
							autoLoad:		{
								url:			'row-help.php',
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
				id:				'reindent-{$rowId}',
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
					var form = Ext.getCmp('rowDef-{$rowId}').getForm();
					if (editor) {
						form.setValues({'defText-{$rowId}': editor.getCode().replace(/  /g, "\t")});
					}
					form.submit({
						params:{
							action:		'definition',
							regenerate:	0,
							rowId:		rowWindow.rowId
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
					var form = Ext.getCmp('rowDef-{$rowId}').getForm();
					if (editor) {
						form.setValues({'defText-{$rowId}': editor.getCode().replace(/  /g, "\t")});
					}
					form.submit({
						params:{
							action:		'definition',
							regenerate:	1,
							rowId:		rowWindow.rowId
						},
						scope:this
					});
				}
			}]
		}]
	});

	rowWindow.add(center);
	//redo windows layout
	rowWindow.doLayout();

	//disable all elements not usable in first user creation step
	if (isNaN(parseInt(rowWindow.rowId))) {
		//hide elements
		Ext.getCmp('rowDef-{$rowId}').disable();
	}
	if (Ext.isIE) {
		center.syncSize(); //needed for IE7
	}
END;
$view->addJavascript($jscontent);
$view->show();
?>