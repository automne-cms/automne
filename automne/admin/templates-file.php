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
// $Id: templates-file.php,v 1.1 2009/04/02 13:55:54 sebastien Exp $

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

function checkNode($value) {
	return $value != 'source' && strpos($value, '..') === false;
}

//Controler vars
$winId = sensitiveIO::request('winId', '', 'printTemplateWindow');
$fileType = sensitiveIO::request('type', array('css', 'js'));
$node = sensitiveIO::request('node', 'checkNode', '');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has module clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on page templates ...');
	$view->show();
}

switch ($fileType) {
	case 'css':
		$dir = $_SERVER['DOCUMENT_ROOT'].'/css/';
		$allowedFiles = array(
			'css' => array('name' => 'Feuille de style', 'class' => 'atm-css'),
			'xml' => array('name' => 'Style Wysiwyg', 'class' => 'atm-xml'),
		);
	break;
	case 'js':
		$dir = $_SERVER['DOCUMENT_ROOT'].'/js/';
		$allowedFiles = array('js' => array('name' => 'Javascript', 'class' => 'atm-js'));
	break;
	default:
		CMS_grandFather::raiseError('Unknown fileType to use ...');
		$view->show();
	break;
}

$file = $dir.$node;
if (!is_file($file) && !is_dir($file)) {
	CMS_grandFather::raiseError('Queried file does not exists.');
	$view->show();
}
if (!is_file($file)) {
	//file creation
	$fileCreation = true;
	$extension = $fileType;
	$fileId = md5(rand());
	$fileDefinition = '';
	$labelField = "{
		xtype:			'textfield',
		value:			'',
		name:			'filelabel',
		fieldLabel:		'Libellé',
		border:			false,
		bodyStyle: 		'padding-bottom:10px'
	},";
	$anchor = '-105';
	$action = 'create';
} else {
	//file edition
	$fileCreation = false;
	$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	if (!isset($allowedFiles[$extension])) {
		CMS_grandFather::raiseError('Action on this type of file is not allowed.');
		$view->show();
	}
	$fileId = md5($file);
	$file = new CMS_file($file);
	$fileDefinition = $file->readContent();
	$labelField = '';
	$anchor = '-50';
	$action = 'update';
}

//DEFINITION TAB
$content = '<textarea id="file-content-'.$fileId.'" style="display:none;">'.htmlspecialchars($fileDefinition).'</textarea>';
$view->setContent($content);

switch ($extension) {
	case 'css':
		$codemirrorConf = '
			parserfile: 	["parsecss.js"],
			stylesheet: 	["/automne/codemirror/css/csscolors.css"],
		';
		$title = sensitiveIO::sanitizeJSString($fileCreation ? 'Création d\'un fichier de feuille de style' : 'Edition du fichier de feuille de style '.$node);
	break;
	case 'js':
		$codemirrorConf = '
			parserfile: 	["tokenizejavascript.js", "parsejavascript.js"],
			stylesheet: 	["/automne/codemirror/css/jscolors.css"],
		';
		$title = sensitiveIO::sanitizeJSString($fileCreation ? 'Création d\'un fichier Javascript' : 'Edition du fichier Javascript '.$node);
	break;
	case 'xml':
		$codemirrorConf = '
			parserfile: 	["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
			stylesheet: 	["/automne/codemirror/css/xmlcolors.css", "/automne/codemirror/css/jscolors.css", "/automne/codemirror/css/csscolors.css"],
		';
		$title = sensitiveIO::sanitizeJSString('Edition du fichier de style de l\'éditeur Wysiwyg '.$node);
	break;
}

$jscontent = <<<END
	var fileWindow = Ext.getCmp('{$winId}');
	fileWindow.fileId = '{$fileId}';
	//set window title
	fileWindow.setTitle('{$title}');
	//set help button on top of page
	fileWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 fileWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 'Cette page permet l\'édition d\'un fichier Javascript ou d\'une feuille de style (CSS). Ce fichier peut-être ensuite appelé dans le code d\'un modèle de page.',
		dismissDelay:	0
	});
	//editor var
	var editor;
	//create center panel
	var center = new Automne.FormPanel({
		id:					'fileDef-{$fileId}',
		autoScroll:			true,
		url:				'templates-files-controler.php',
		layout: 			'form',
		region:				'center',
		plain:				true,
		border:				false,
		bodyStyle: 			'padding:5px',
		defaults: {
			anchor:				'97%',
			allowBlank:			false
		},
		layoutConfig: {
	        labelAlign: 		'top'
	    },
		labelAlign: 		'top',
		items:[{$labelField}{
			xtype:			'checkbox',
			boxLabel:		'Activer la coloration syntaxique',
			hideLabel:		true,
			listeners:		{'check':function(field, checked) {
				if (checked) {
					editor = CodeMirror.fromTextArea('defText-{$fileId}', {
						{$codemirrorConf}
						path: 			"/automne/codemirror/js/",
						textWrapping:	false,
						initCallback:	function(){
							editor.reindent();
						}
					});
					field.disable();
					Ext.getCmp('reindent-{$fileId}').show();
				}
			}, scope:this}
		},{
			id:				'defText-{$fileId}',
			xtype:			'textarea',
			name:			'definition',
			cls:			'atm-code',
			anchor:			'97%, {$anchor}',
			enableKeyEvents:true,
			fieldLabel:		'Définition',
			/*hideLabel:		true,*/
			value:			Ext.get('file-content-{$fileId}').dom.value,
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
			id:				'reindent-{$fileId}',
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
				var form = Ext.getCmp('fileDef-{$fileId}').getForm();
				if (form.isValid()) {
					form.submit({
						params:{
							action:		'{$action}',
							type:		'{$fileType}',
							node:		'{$node}'
						},
						scope:this
					});
				}
			}
		}]
	});
	
	fileWindow.add(center);
	//redo windows layout
	fileWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>