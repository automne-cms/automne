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

/**
  * PHP page : Load block link interface
  * Used accross an Ajax request. Render a link block form
  *
  * @package Automne
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
define("MESSAGE_TOOLBAR_HELP", 1073);
define("MESSAGE_EDIT_LINK", 1748);
define("MESSAGE_WINDOW_LINK_INFO",1749);
define("MESSAGE_LINK", 147);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 682);
define("MESSAGE_ALL_FILES",530);

$winId = sensitiveIO::request('winId', '', 'blockLinkWindow');
$currentPage = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());
$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');

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
$linkDatas = sensitiveIO::sanitizeJSString($rawDatas['value']);

$jscontent = <<<END
	var blockWindow = Ext.getCmp('{$winId}');
	//set window title
	
	blockWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_EDIT_LINK)}');
	//set help button on top of page
	blockWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 blockWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_WINDOW_LINK_INFO)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'blockLinkWindow-form',
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
		            xtype: 			'atmLinkField',
		            fieldLabel: 	'{$cms_language->getJsMessage(MESSAGE_LINK)}',
		            name: 			'link',
					uploadCfg:	{
						file_size_limit:		'{$maxFileSize}',
						file_types:				'*.*',
						file_types_description:	'{$cms_language->getJsMessage(MESSAGE_ALL_FILES)} ...'
					},
					fileinfos:{
						module:			'standard'
					},
					linkConfig: {
						label:			true
					},
					value:	'{$linkDatas }'
		        }]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			xtype:			'button',
			iconCls:		'atm-pic-validate',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('blockLinkWindow-form').getForm();
				if (form.isValid()) {
					this.validateEdition(form.getValues());
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