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
// $Id: template.php,v 1.5 2009/03/02 11:25:15 sebastien Exp $

/**
  * PHP page : Load template detail window.
  * Used accross an Ajax request. Render template informations.
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

$winId = sensitiveIO::request('winId', '', 'templateWindow');
$templateId = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger', 'createTemplate');

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
$description = sensitiveIO::sanitizeJSString($template->getDescription());
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
		fieldLabel: '<span class=\"atm-help\" ext:qtip=\"Vous pouvez utiliser des groupes pour catégoriser votre modèle de page. Vous pourrez ainsi simplifier sa sélection mais aussi associer des droits aux utilisateurs sur ces groupes. Ceci permettra de limiter l\'usage de certains modèles spécifiques à certains profils d\'utilisateurs.\">Groupes</span>',
		columns: 	{$columns},
		items: [";
		foreach ($allGroups as $aGroup) {
			$groupsfield .= "{boxLabel: '{$aGroup}', inputValue:'{$aGroup}', name: 'groups[]', checked:".(isset($templateGroups[$aGroup]) ? 'true' : 'false')."},";
		}
		//remove last comma from groups
		$groupsfield = substr($groupsfield, 0, -1);
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
<textarea id="tpl-definition-'.$templateId.'" style="display:none;">'./*str_replace("\t", '    ', */(htmlspecialchars($templateDefinition)).'</textarea>';
$view->setContent($content);

$title = (sensitiveIO::isPositiveInteger($templateId)) ? 'Modèle de page : '.$label : 'Création d\\\'un modèle de page';

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
		title:			'Impression',
		layout: 		'form',
		xtype:			'atmForm',
		url:			'templates-controler.php',
		bodyStyle: 		'padding:5px',
		labelAlign:		'right',
		border:			false,
		items:[{
			xtype:			'panel',
			border:			false,
			html:			'Sélectionnez les zones de contenu du modèle que vous souhaitez voir apparaitre dans la page d\'impression. Choisissez aussi l\'ordre d\'affichage de ces zones de contenu.',
			bodyStyle: 		'padding:10px 0 10px 0'
		},{
			xtype:			'itemselector',
			name:			'printableCS',
			fieldLabel:		'Zones de contenu imprimables',
			dataFields:		['code'],
			toData:			{$printableCS},
			msWidth:		250,
			msHeight:		130,
			height:			140,
			valueField:		'code',
			displayField:	'code',
			toLegend:		'Séléctionnés',
			fromLegend:		'Disponibles',
			fromData:		{$clientspaces}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
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
		html:			 'Cette page vous permet de créer et modifier un modèle de page. Les modèles de page servent de base à la création des pages du site.',
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
			title:				'Propriétés',
			autoScroll:			true,
			url:				'templates-controler.php',
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
				fieldLabel:		'<span class="atm-help" ext:qtip="Vous pouvez ajouter un ou plusieurs nouveaux groupes au modèle de page en cours. Le nom du groupe ne doit contenir que des caractères alphanumériques. Les groupes doivent être séparés par des virgules ou des point-virgules.">Nouveaux groupes</span>',
				name:			'newgroup',
				value:			''
			},{
				fieldLabel:		'',
				labelSeparator:	'',
				xtype:			'checkbox',
				boxLabel: 		'<span class="atm-help" ext:qtip="En cochant cette case, aucun utilisateur ne pourra voir ou utiliser ce modèle tant qu\'ils n\'auront pas les droits sur les nouveaux groupes ajoutés ci-dessus.">Ne pas donner les droits de voir ces nouveaux groupes aux utilisateurs.</span>',
				name: 			'nouserrights',
				inputValue:		'1'
			},{
				xtype:			"itemselector",
				name:			"websites",
				fieldLabel:		'<span class="atm-help" ext:qtip="Sélectionnez les sites pour lesquels l\'utilisation de ce modèle de page sera possible.">Sites</span>',
				dataFields:		["code", "desc"],
				toData:			{$selectedWebsites},
				msWidth:		250,
				msHeight:		130,
				height:			140,
				valueField:		"code",
				displayField:	"desc",
				toLegend:		"Autorisés",
				fromLegend:		"Disponibles",
				fromData:		{$availableWebsites}
			},{
				xtype: 			'atmImageUploadField',
				emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
				fieldLabel: 	'<span class="atm-help" ext:qtip="Utilisez une vignette représentant le visuel du modèle de page pour permettre une selection plus aisée.">Vignette</span>',
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
				fieldLabel: 	'<span class="atm-help" ext:qtip="Vous pouvez utiliser un fichier XML pour importer la définition XML à employer pour ce modèle de page.">Définition XML</span>',
				name: 			'definitionfile',
				uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.xml',
					file_types_description:	'Fichier XML ...'
				},
				fileinfos:	{$fileDatas}
			}],
			buttons:[{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				anchor:			'',
				scope:			this,
				handler:		function() {
					var form = Ext.getCmp('templateDatas-{$templateId}').getForm();
					pr(form.isValid());
					if (form.isValid()) {
						form.submit({
							params:{
								action:		'properties',
								templateId:	templateWindow.templateId
							},
							success:function(form, action){
								//if it is a successful user creation
								if (action.result.success != false && isNaN(parseInt(templateWindow.templateId))) {
									//set userId
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
					}
				}
			}]
		},{
			id:					'templateDef-{$templateId}',
			title:				'Définition XML',
			autoScroll:			true,
			url:				'templates-controler.php',
			layout: 			'form',
			xtype:				'atmForm',
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
				html:			'Vous pouvez modifier ici la structure XML de ce modèle. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, ne supprimez ni ne modifiez pas de tag &lt;atm-clientspace&gt; sous peine de perdre du contenu sur les pages employant déjà le modèle en cours.',
				border:			false,
				bodyStyle: 		'padding-bottom:10px'
			}, {
				xtype:			'checkbox',
				boxLabel:		'Activer la coloration syntaxique',
				listeners:		{'check':function(field, checked) {
					if (checked) {
						editor = CodeMirror.fromTextArea('defText-{$templateId}', {
							parserfile: 	["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
							stylesheet: 	["/automne/codemirror/css/xmlcolors.css", "/automne/codemirror/css/jscolors.css", "/automne/codemirror/css/csscolors.css"],
							path: 			"/automne/codemirror/js/",
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
				anchor:			'0, -70',
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
			}, {
				id:				'reindent-{$templateId}',
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
					var form = Ext.getCmp('templateDef-{$templateId}').getForm();
					if (editor) {
						form.setValues({'defText-{$templateId}': editor.getCode().replace(/  /g, "\t")});
					}
					form.submit({
						params:{
							action:		'definition',
							templateId:	templateWindow.templateId
						},
						scope:this
					});
				}
			}]
		},{
			xtype:			'framePanel',
			title:			'Rangées par défaut',
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
	//center.syncSize();
END;
$view->addJavascript($jscontent);
$view->show();
?>