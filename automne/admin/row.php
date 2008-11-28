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
// $Id: row.php,v 1.2 2008/11/28 14:41:24 sebastien Exp $

/**
  * PHP page : Load row detail window.
  * Used accross an Ajax request. Render row informations.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_SELECT_PICTURE",528);
define("MESSAGE_IMAGE",803);
define("MESSAGE_SELECT_FILE",534);

$winId = sensitiveIO::request('winId', '', 'rowWindow');
$rowId = sensitiveIO::request('row', 'sensitiveIO::isPositiveInteger', 'createRow');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has row edition clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	CMS_grandFather::raiseError('User has no rights on rows editions');
	$view->setActionMessage('Vous n\'avez pas le droit de gérer les modèles de rangées ...');
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
$label = sensitiveIO::sanitizeJSString($row->getLabel());
$description = sensitiveIO::sanitizeJSString($row->getDescription());
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
	$columns = sizeof($allGroups) < 6 ? sizeof($allGroups) : 6;
	$groupsfield .= "{
		xtype: 		'checkboxgroup',
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"Vous pouvez utiliser des groupes pour catégoriser votre modèle de rangée. Vous pourrez ainsi simplifier sa sélection mais aussi associer des droits aux utilisateurs sur ces groupes. Ceci permettra de limiter l\'usage de certains modèles spécifiques à certains profils d\'utilisateurs.\">Groupes</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allGroups as $aGroup) {
			$groupsfield .= "{boxLabel: '{$aGroup}', inputValue:'{$aGroup}', name: 'groups[]', checked:".(isset($rowGroups[$aGroup]) ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$groupsfield = substr($groupsfield, 0, -1);
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
		list($sizeX, $sizeY) = @getimagesize($_SERVER['DOCUMENT_ROOT']."/".$icon);
		$maxheight = $sizeY > $maxheight ? $sizeY : $maxheight;
	}
	$maxheight += 10;
	$columns = sizeof($allIcons) < 5 ? sizeof($allIcons) : 5;
	$iconsField .= "{
		xtype: 		'radiogroup',
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"Vous pouvez utiliser des icônes pour identifier votre modèle de rangée. Vous pourrez ainsi simplifier sa sélection.\">Icône</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allIcons as $icon) {
			$iconsField .= "{boxLabel: '<img src=\"{$icon}\">', height:".$maxheight.", inputValue:'{$icon}', name: 'image', checked:".($row->getImage() == $icon ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$iconsField = substr($iconsField, 0, -1);
		$iconsField .= "
		]
	},";
}

//Templates filters
$filteredTemplates = $row->getFilteredTemplates();
$templates = CMS_pageTemplatesCatalog::getAll(false, '', array(), '', array(), $cms_user, 0, 0, true);
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
$content = '<textarea id="row-definition-'.$rowId.'" style="display:none;">'./*str_replace("\t", '    ', */(htmlspecialchars($rowDefinition)).'</textarea>';
$view->setContent($content);

$title = (sensitiveIO::isPositiveInteger($rowId)) ? 'Modèle de rangée : '.$label : 'Création d\\\'un modèle de rangée';

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
		html:			'Cette page vous permet de créer et modifier un modèle de rangée. Les modèles de rangée servent de base de saisie au contenu des pages des sites.',
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
			title:				'Propriétés',
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
				fieldLabel:		'* Libellé',
				name:			'label',
				value:			'{$label}',
				allowBlank:		false
			},{
				fieldLabel:		'Description',
				xtype:			'textarea',
				name:			'description',
				value:			'{$description}'
			},{$groupsfield}{
				fieldLabel:		'<span class="atm-help" ext:qtip="Vous pouvez ajouter un ou plusieurs nouveaux groupes au modèle de rangée en cours. Le nom du groupe ne doit contenir que des caractères alphanumériques. Les groupes doivent être séparés par des virgules ou des point-virgules.">Nouveaux groupes</span>',
				name:			'newgroup',
				value:			''
			},{
				fieldLabel:		'',
				labelSeparator:	'',
				xtype:			'checkbox',
				boxLabel: 		'<span class="atm-help" ext:qtip="En cochant cette case, aucun utilisateur ne pourra voir ou utiliser ce modèle de rangée tant qu\'ils n\'auront pas les droits sur les nouveaux groupes ajoutés ci-dessus.">Ne pas donner les droits de voir ces nouveaux groupes aux utilisateurs.</span>',
				name: 			'nouserrights',
				inputValue:		'1'
			},{
				xtype:			"itemselector",
				name:			"templates",
				fieldLabel:		'<span class="atm-help" ext:qtip="Sélectionnez les modèles de pages pour lesquels l\'utilisation de ce modèle de rangée sera possible. Si aucun modèle n\'est spécifié, tous les modèles de page pourront employer cette rangée.">Modèles de pages</span>',
				dataFields:		["code", "desc"],
				toData:			{$selectedTemplates},
				msWidth:		250,
				msHeight:		130,
				height:			140,
				valueField:		"code",
				displayField:	"desc",
				toLegend:		"Autorisés",
				fromLegend:		"Disponibles",
				fromData:		{$availableTemplates}
			},{$iconsField}{
				xtype: 			'atmImageUploadField',
				emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
				fieldLabel: 	'<span class="atm-help" ext:qtip="Si aucune icône ne convient dans la liste ci-dessus, vous pouvez en ajouter une nouvelle..">Nouvelle icône</span>',
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
				anchor:			'',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('rowDatas-{$rowId}').getForm();
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
				}
			}]
		},{
			id:					'rowDef-{$rowId}',
			title:				'Définition XML',
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
				html:			'Vous pouvez modifier ici la structure XML de cette rangée. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, ne supprimez pas de tag &lt;block&gt; existant sous peine de perdre du contenu sur les pages employant déjà ce modèle de rangée.',
				border:			false,
				bodyStyle: 		'padding-bottom:10px'
			}, {
				xtype:			'checkbox',
				boxLabel:		'Activer la coloration syntaxique',
				listeners:		{'check':function(field, checked) {
					if (checked) {
						editor = CodeMirror.fromTextArea('defText-{$rowId}', {
							parserfile: 	["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
							stylesheet: 	["/automne/codemirror/css/xmlcolors.css", "/automne/codemirror/css/jscolors.css", "/automne/codemirror/css/csscolors.css"],
							path: 			"/automne/codemirror/js/",
							textWrapping:	false,
							content:		Ext.getCmp('defText-{$rowId}').getValue().replace(/\t/g, '  ')
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
				anchor:			'0, -70',
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
				text:			'Aide',
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
				text:			'Réindenter',
				anchor:			'',
				hidden:			true,
				listeners:		{'click':function(button) {
					editor.reindent();
				}, scope:this}
			},{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
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
END;
$view->addJavascript($jscontent);
$view->show();
?>