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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: templates-file.php,v 1.8 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load print template window.
  * Used accross an Ajax request. Render print template definition.
  * 
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_SYNTAX_COLOR", 725);
define("MESSAGE_PAGE_ACTION_REINDENT", 726);
define("MESSAGE_PAGE_LABEL", 1745);
define("MESSAGE_PAGE_STYLESHEET", 1486);
define("MESSAGE_PAGE_WYSIWYG", 1487);
define("MESSAGE_PAGE_JAVASCRIPT", 1488);
define("MESSAGE_PAGE_CREATE_CSS", 1489);
define("MESSAGE_PAGE_EDIT_CSS", 1490);
define("MESSAGE_PAGE_CREATE_JS", 1491);
define("MESSAGE_PAGE_EDIT_JS", 1492);
define("MESSAGE_PAGE_EDIT_WYSIWYG", 1493);
define("MESSAGE_TOOLBAR_HELP_DESC", 1494);
define("MESSAGE_PAGE_DEFINITION", 1495);
define("MESSAGE_PAGE_CREATE_FILE", 1744);
define("MESSAGE_PAGE_TXT", 273);

function checkNode($value) {
	return $value != 'source' && io::strpos($value, '..') === false;
}

//Controler vars
$winId = sensitiveIO::request('winId', '', 'printTemplateWindow');
$node = sensitiveIO::request('node', 'checkNode', '');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has module clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on page templates ...');
	$view->show();
}

$allowedFiles = array(
	'less' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_STYLESHEET), 'class' => 'atm-css'),
	'css' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_STYLESHEET), 'class' => 'atm-css'),
	'xml' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_WYSIWYG), 'class' => 'atm-xml'),
	'js' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_JAVASCRIPT), 'class' => 'atm-js'),
	'txt' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_TXT), 'class' => 'atm-txt'),
);

$file = PATH_REALROOT_FS.'/'.$node;
if (!is_file($file) && !is_dir($file)) {
	CMS_grandFather::raiseError('Queried file does not exists.');
	$view->show();
}

if (!is_file($file)) {
	//file creation
	$fileCreation = true;
	$extension = '';
	$fileId = md5(rand());
	$fileDefinition = '';
	$labelField = "{
		xtype:			'textfield',
		value:			'',
		name:			'filelabel',
		fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_PAGE_LABEL)}',
		border:			false,
		bodyStyle: 		'padding-bottom:10px'
	},";
	$anchor = '-110';
	$action = 'create';
} else {
	//file edition
	$fileCreation = false;
	$extension = io::strtolower(pathinfo($file, PATHINFO_EXTENSION));
	if (!isset($allowedFiles[$extension])) {
		CMS_grandFather::raiseError('Action on this type of file is not allowed.');
		$view->show();
	}
	$fileId = md5($file);
	$file = new CMS_file($file);
	$fileDefinition = $file->readContent();
	$labelField = '';
	$anchor = '-60';
	$action = 'update';
}
if (strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
	if (!io::isUTF8($fileDefinition)) {
		$fileDefinition = utf8_encode($fileDefinition);
	}
} else {
	if (io::isUTF8($fileDefinition)) {
		$fileDefinition = utf8_decode($fileDefinition);
	}
}

//DEFINITION TAB
$content = '<textarea id="file-content-'.$fileId.'" style="display:none;">'.htmlspecialchars($fileDefinition).'</textarea>';
$view->setContent($content);

switch ($extension) {
	case 'less':
	case 'css':
		$codemirrorConf = '
			mode: "text/css",
		';
		$title = sensitiveIO::sanitizeJSString($fileCreation ? $cms_language->getMessage(MESSAGE_PAGE_CREATE_CSS) : $cms_language->getMessage(MESSAGE_PAGE_EDIT_CSS).' '.$node);
	break;
	case 'js':
		$codemirrorConf = '
			mode: "text/javascript",
		';
		$title = sensitiveIO::sanitizeJSString($fileCreation ? $cms_language->getMessage(MESSAGE_PAGE_CREATE_JS) : $cms_language->getMessage(MESSAGE_PAGE_EDIT_JS).' '.$node);
	break;
	case 'xml':
		$codemirrorConf = '
			mode: "text/html",
		';
		$title = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_EDIT_WYSIWYG).' '.$node);
	break;
	default:
		$codemirrorConf = '
			mode: "text/html",
		';
		$title = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_CREATE_FILE));
	break;
}

$automnePath = PATH_MAIN_WR;
$colorcoding = '';
if ($codemirrorConf) {
	$colorcoding = "{
		xtype:			'checkbox',
		boxLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SYNTAX_COLOR)}',
		hideLabel:		true,
		listeners:		{'check':function(field, checked) {
			if (checked) {
				var textarea = Ext.get('defText-{$fileId}');
				var width = textarea.getWidth();
				var height = textarea.getHeight();
				var foldFunc = CodeMirror.newFoldFunction(CodeMirror.braceRangeFinder);
				editor = CodeMirror.fromTextArea(document.getElementById('defText-{$fileId}'), {
			        lineNumbers: true,
			        matchBrackets: true,
			        {$codemirrorConf}
					indentWithTabs: true,
			        enterMode: \"keep\",
			        tabMode: \"shift\",
					tabSize: 2,
					onGutterClick: foldFunc,
					extraKeys: {
						\"Ctrl-Q\": function(cm){
							foldFunc(cm, cm.getCursor().line);
						},
						\"Ctrl-S\": function() {
							Ext.getCmp('save-{$fileId}').handler();
						}
					}
			    });
				Ext.select('.CodeMirror-scroll').setHeight((height - 6));
				Ext.select('.CodeMirror-scroll').setWidth(width);
				
				field.disable();
				Ext.getCmp('reindent-{$fileId}').show();
			}
		}, scope:this}
	},";
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
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
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
		buttonAlign:		'center',
		defaults: {
			anchor:				'97%',
			allowBlank:			false
		},
		layoutConfig: {
	        labelAlign: 		'top'
	    },
		labelAlign: 		'top',
		items:[{$labelField}{$colorcoding}{
			id:				'defText-{$fileId}',
			xtype:			'textarea',
			name:			'definition',
			cls:			'atm-code',
			anchor:			'-35, {$anchor}',
			enableKeyEvents:true,
			fieldLabel:		'{$cms_language->getJSMessage(MESSAGE_PAGE_DEFINITION)}',
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
			}, 'resize': function(field, width, height){
				if (editor) { //resize editor according to textarea size
					if (height) Ext.select('.CodeMirror-scroll').setHeight((height - 6));
					if (width) Ext.select('.CodeMirror-scroll').setWidth(width);
				}
			},
			scope:this}
		}],
		buttons:[{
			id:				'reindent-{$fileId}',
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_REINDENT)}',
			anchor:			'',
			hidden:			true,
			listeners:		{'click':function(button) {
				editor.reindent();
			}, scope:this}
		},{
			id:				'save-{$fileId}',
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			anchor:			'',
			scope:			this,
			handler:		function() {
				if (editor) {
					editor.save();
				}
				var form = Ext.getCmp('fileDef-{$fileId}').getForm();
				if (form.isValid()) {
					form.submit({
						params:{
							action:		'{$action}',
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
	if (Ext.isIE) {
		center.syncSize(); //needed for IE7
	}
END;
$view->addJavascript($jscontent);
$view->show();
?>