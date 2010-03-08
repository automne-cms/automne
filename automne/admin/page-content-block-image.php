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
// $Id: page-content-block-image.php,v 1.5 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : Load block image interface
  * Used accross an Ajax request. Render an image block form
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_EDIT_IMG",526);
define("MESSAGE_WINDOW_IMG_INFO",527);
define("MESSAGE_SELECT_PICTURE",528);
define("MESSAGE_IMAGE",803);
define("MESSAGE_IMAGE_ZOOM",968);
define("MESSAGE_LEGEND",529);
define("MESSAGE_ALL_FILES",530);
define("MESSAGE_LINK", 133);
define("MESSAGE_LINK_IMAGE_ZOOM", 561);
define("MESSAGE_LINK_OTHER", 562);


$winId = sensitiveIO::request('winId', '', 'blockImageWindow');
$currentPage = is_object($cms_context) ? sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID()) : '';
$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');
$minWidth = sensitiveIO::request('minWidth', 'sensitiveIO::isPositiveInteger', 0);
$maxWidth = sensitiveIO::request('maxWidth', 'sensitiveIO::isPositiveInteger', 0);

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
if ($rawDatas['enlargedFile'] && file_exists(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$rawDatas['enlargedFile'])) {
	$file = new CMS_file(PATH_MODULES_FILES_STANDARD_FS.'/edition/'.$rawDatas['enlargedFile']);
	$zoomDatas = array(
		'filename'		=> $file->getName(false),
		'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
		'filesize'		=> $file->getFileSize(),
		'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
		'extension'		=> $file->getExtension(),
	);
} else {
	$zoomDatas = array(
		'filename'		=> '',
		'filepath'		=> '',
		'filesize'		=> '',
		'fileicon'		=> '',
		'extension'		=> '',
	);
}
$zoomDatas = sensitiveIO::jsonEncode($zoomDatas);
$linkDatas = sensitiveIO::sanitizeJSString($rawDatas['externalLink']);
$imageLabel = sensitiveIO::sanitizeJSString($rawDatas["label"]);

$jscontent = <<<END
	var blockWindow = Ext.getCmp('{$winId}');
	//set window title
	
	blockWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_EDIT_IMG)}');
	//set help button on top of page
	blockWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 blockWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_WINDOW_IMG_INFO)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'blockImageWindow-form',
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
	            xtype: 			'atmImageUploadField',
	            emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
	            fieldLabel: 	'* {$cms_language->getJsMessage(MESSAGE_IMAGE)}',
	            name: 			'filename',
				minWidth:		{$minWidth},
	            maxWidth:		{$maxWidth},
	            uploadCfg:	{
					file_size_limit:		'{$maxFileSize}',
					file_types:				'*.jpg;*.png;*.gif',
					file_types_description:	'{$cms_language->getJsMessage(MESSAGE_IMAGE)} ...'
				},
				fileinfos:	{$fileDatas}
	        },{
				fieldLabel:		'{$cms_language->getJsMessage(MESSAGE_LEGEND)}',
				name:			'imagelabel',
				value:			'{$imageLabel}',
				allowBlank:		true
			},{
				xtype:			'fieldset',
				title: 			'{$cms_language->getJsMessage(MESSAGE_LINK)}',
				defaultType: 	'checkbox',
				autoHeight:		true,
				defaults: {
					anchor:			'97%',
					allowBlank:		true
				},
				items:			[{
					xtype:			'panel',
					bodyStyle: 		'padding:0 0 10px 0',
					html:			'{$cms_language->getJsMessage(MESSAGE_LINK_IMAGE_ZOOM)}',
					border:			false
				},{
		            xtype: 			'atmImageUploadField',
		            emptyText: 		'{$cms_language->getJsMessage(MESSAGE_SELECT_PICTURE)}',
		            fieldLabel: 	'{$cms_language->getJsMessage(MESSAGE_IMAGE_ZOOM)}',
		            name: 			'zoomname',
		            uploadCfg:	{
						file_size_limit:		'{$maxFileSize}',
						file_types:				'*.jpg;*.png;*.gif',
						file_types_description:	'{$cms_language->getJsMessage(MESSAGE_IMAGE_ZOOM)} ...'
					},
					fileinfos:	{$zoomDatas}
		        },{
					xtype:			'panel',
					bodyStyle: 		'padding:0 0 10px 0',
					html:			'{$cms_language->getJsMessage(MESSAGE_LINK_OTHER)}',
					border:			false
				},{
		            xtype: 			'atmLinkField',
		            fieldLabel: 	'{$cms_language->getJsMessage(MESSAGE_LINK)}',
		            name: 			'imagelink',
					uploadCfg:	{
						file_size_limit:		'{$maxFileSize}',
						file_types:				'*.*',
						file_types_description:	'{$cms_language->getJsMessage(MESSAGE_ALL_FILES)} ...'
					},
					fileinfos:{
						module:			'standard'
					},
					linkConfig: {
						label:			false
					},
					value:	'{$linkDatas }'
		        }]
			}]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			xtype:			'button',
			iconCls:		'atm-pic-validate',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('blockImageWindow-form').getForm();
				if (form.isValid()) {
					this.validateEdition(form.getValues());
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