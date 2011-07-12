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
  * PHP page : Load polymod items selection
  * Used accross an Ajax request. Render polymod items for association with multi object fields
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

//Standard messages
define("MESSAGE_ERROR_MODULE_RIGHTS",570);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_TOOLBAR_HELP",1073);

//Polymod messages
define("MESSAGE_PAGE_TITLE", 124);
define("MESSAGE_TOOLBAR_HELP_DESC", 521);
define("MESSAGE_PAGE_ACTION_ASSOCIATE", 1267);
define("MESSAGE_MULTI_OBJECT_CHOOSE_ELEMENT", 518);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$objectId = sensitiveIO::request('type', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$unique = sensitiveIO::request('unique') ? true : false;

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module || !$module->isPolymod()) {
	CMS_grandFather::raiseError('Unknown module or module is not polymod for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

//load current object definition
$object = new CMS_poly_object_definition($objectId);

$winLabel = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_MULTI_OBJECT_CHOOSE_ELEMENT,array($object->getObjectLabel($cms_language)), MOD_POLYMOD_CODENAME));

$md5 = md5(mt_rand().microtime());
$url = PATH_ADMIN_MODULES_WR.'/polymod/item-selector.php';
$params = sensitiveIO::jsonEncode(array(
	'winId'			=> 'selector-'.$md5,
	'objectId'		=> $object->getID(),
	'module'		=> $codename,
	'multiple'		=> $unique ? 0 : 1
));

$unique = $unique ? '1' : '0';

//this is only an single item selection, so help selection a little
$jscontent = <<<END
	var window = Ext.getCmp('{$winId}');
	//set window title
	window.setTitle('{$winLabel}');
	//set help button on top of page
	window.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 window.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC, false, MOD_POLYMOD_CODENAME)}',
		dismissDelay:	0
	});
	window.selectedItems = [];
	window.selectedItem = '';
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		layout:				'fit',
		plain:				true,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:		'selector-{$md5}',
			height:	(window.getHeight()-70),
			xtype:	'atmPanel',
			layout:	'atm-border',
			border:	false,
			autoLoad:		{
				url:		'{$url}',
				params:		{$params},
				nocache:	true,
				scope:		center
			}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_ASSOCIATE)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		function() {
				if ({$unique}) {
					window.selectedItem = Ext.getCmp('selector-{$md5}').selectedItem
				} else {
					window.selectedItems = Ext.getCmp('selector-{$md5}').selectedItems;
				}
				window.close();
			},
			scope:			this
		}]
	});
	window.add(center);
	setTimeout(function(){
		//redo windows layout
		window.doLayout();
		if (Ext.isIE7) {
			center.syncSize();
		}
	}, 100);
END;
$view->addJavascript($jscontent);
$view->show();
?>