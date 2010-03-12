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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-content-block-flash.php,v 1.4 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : Load block flash interface
  * Used accross an Ajax request. Render a flash block form
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_EDIT_FLASH",535);
define("MESSAGE_WINDOW_INFO",536);
define("MESSAGE_SELECT_FILE",534);
define("MESSAGE_FILE",191);
define("MESSAGE_FLASH_ANIMATION",537);
define("MESSAGE_WIDTH_INFO",538);
define("MESSAGE_WIDTH",290);
define("MESSAGE_HEIGHT_INFO",539);
define("MESSAGE_HEIGHT",291);
define("MESSAGE_NAME_INFO",540);
define("MESSAGE_NAME",548);
define("MESSAGE_VERSION_INFO",541);
define("MESSAGE_VERSION",542);
define("MESSAGE_PARAM_INFO",543);
define("MESSAGE_PARAM",807);
define("MESSAGE_FLASHVAR_INFO",544);
define("MESSAGE_FLASHVAR",545);
define("MESSAGE_ATTRIBUT_INFO",546);
define("MESSAGE_ATTRIBUT",547);
define("MESSAGE_ERROR_FORMAT",549);
define("MESSAGE_ADVANCED_PARAMETERS",566);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);

$winId = sensitiveIO::request('winId', '', 'blockFlashWindow');
$currentPage = is_object($cms_context) ? sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID()) : '';
$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');
$value = sensitiveIO::request('value');

//load page
$cms_page = CMS_tree::getPageByID($currentPage);
if ($cms_page->hasError()) {
	CMS_grandFather::raiseError('Selected page ('.$currentPage.') has error ...');
	$view->show();
}

//check user rights
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on page : '.$cms_page->getID());
	$view->show();
}

//get block datas
if (class_exists($blockClass)) {
	$cms_block = new $blockClass();
	$cms_block->initializeFromBasicAttributes($blockId);
	$rawDatas = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
} else {
	CMS_grandFather::raiseError('Error, can\'t get block class : '.$blockClass);
	$view->show();
}

$maxFileSize = CMS_file::getMaxUploadFileSize('K');

if ($rawDatas['file'] && file_exists(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$rawDatas['file'])) {
	$file = new CMS_file(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$rawDatas['file']);
	$fileDatas = array(
		'filename'		=> $file->getName(false),
		'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
		'filesize'		=> $file->getFileSize(),
		'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
		'extension'		=> $file->getExtension(),
	);
} else {
	$fileDatas = array(
		'filename'		=> '',
		'filepath'		=> '',
		'filesize'		=> '',
		'fileicon'		=> '',
		'extension'		=> '',
	);
}
$filePath = $fileDatas['filepath'];
$fileDatas = sensitiveIO::jsonEncode($fileDatas);

$flashvars = sensitiveIO::sanitizeJSString($rawDatas["flashvars"]);
$params = sensitiveIO::sanitizeJSString($rawDatas["params"]);
$attributes = sensitiveIO::sanitizeJSString($rawDatas["attributes"]);

$jscontent = <<<END
	var blockWindow = Ext.getCmp('{$winId}');
	//set window title
	blockWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_EDIT_FLASH)}');
	//set help button on top of page
	blockWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 blockWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_WINDOW_INFO)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'blockFlashWindow-form',
			layout: 		'form',
			bodyStyle: 		'padding:10px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			xtype:			'atmForm',
			url:			'page-content-controler.php',
			labelAlign:		'right',
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		false
			},
			items:[{
	            xtype: 			'atmFileUploadField',
	            emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_FILE)}',
	            fieldLabel: 	'* {$cms_language->getJsMessage(MESSAGE_FILE)}',
	            name: 			'filename',
	            uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.swf',
					file_types_description:	'{$cms_language->getJsMessage(MESSAGE_FLASH_ANIMATION)} ...'
				},
				listeners:	{
					'delete':{
						fn:function(field, deletedInfos) {
							if (deletedInfos['filepath'] == '{$filePath}') {
								this.clearContent();
							}
						},
						scope:this
					}
				},
				fileinfos:	{$fileDatas}
	        },{
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_WIDTH_INFO)}">* {$cms_language->getJsMessage(MESSAGE_WIDTH)}</span>',
				name:			'flashwidth',
				value:			'{$rawDatas["width"]}',
				allowBlank:		false
			},{
				fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_HEIGHT_INFO)}">* {$cms_language->getJsMessage(MESSAGE_HEIGHT)}</span>',
				name:			'flashheight',
				value:			'{$rawDatas["height"]}',
				allowBlank:		false
			},{
				xtype:			'fieldset',
				title: 			'{$cms_language->getJsMessage(MESSAGE_ADVANCED_PARAMETERS)}',
				defaultType: 	'checkbox',
				autoHeight:		true,
				collapsed:		true,
				collapsible:	true,
				defaults: {
					xtype:			'textfield',
					anchor:			'97%',
					allowBlank:		true
				},
				items:			[{
					fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_NAME_INFO)}">{$cms_language->getJsMessage(MESSAGE_NAME)}</span>',
					name:			'flashname',
					value:			'{$rawDatas["name"]}',
					allowBlank:		true,
					maskRe:			Ext.form.VTypes.alphanumMask
				},{
					fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_VERSION_INFO)}">* {$cms_language->getJsMessage(MESSAGE_VERSION)}</span>',
					name:			'flashversion',
					value:			'{$rawDatas["version"]}',
					allowBlank:		false
				},{
					fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getMessage(MESSAGE_PARAM_INFO)}">{$cms_language->getJsMessage(MESSAGE_PARAM)}</span>',
					xtype:			'textarea',
					name:			'flashparams',
					value:			'{$params}',
					allowBlank:		true
				},{
					fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getMessage(MESSAGE_FLASHVAR_INFO)}">{$cms_language->getJsMessage(MESSAGE_FLASHVAR)}</span>',
					xtype:			'textarea',
					name:			'flashvars',
					value:			'{$flashvars}',
					allowBlank:		true
				},{
					fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getMessage(MESSAGE_ATTRIBUT_INFO)}">{$cms_language->getJsMessage(MESSAGE_ATTRIBUT)}</span>',
					xtype:			'textarea',
					name:			'flashattributes',
					value:			'{$attributes}',
					allowBlank:		true
				}]
			}]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			xtype:			'button',
			iconCls:		'atm-pic-validate',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('blockFlashWindow-form').getForm();
				if (form.isValid()) {
					var values = form.getValues();
					//check fields values for correct JS format
					var checkFields = ['flashparams', 'flashvars', 'flashattributes'];
					var invalid = {};
					var hasInvalid = false;
					for (var i = 0; i < checkFields.length; i++) {
						if (values[checkFields[i]]) {
							if (values[checkFields[i]].trim().substr(-1) == ',') {
								values[checkFields[i]] = values[checkFields[i]].trim().substr(0, values[checkFields[i]].trim().length - 1);
							}
							try {
								eval('var test = {'+ values[checkFields[i]] +'};');
							} catch(e) {
								invalid[checkFields[i]] = '{$cms_language->getJSMessage(MESSAGE_ERROR_FORMAT)}';
								hasInvalid = true;
							}
						}
					}
					if (hasInvalid) {
						form.markInvalid(invalid);
					} else {
						this.validateEdition(values);
					}
				} else {
					Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES)}', '', blockWindow);
				}
			},
			scope:			this
		}]
	});
	blockWindow.add(center);
	//redo windows layout
	blockWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>