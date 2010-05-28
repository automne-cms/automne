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
// $Id: module.php,v 1.7 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : Load module backend window
  * Used accross an Ajax request
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_TOOLBAR_HELP_MESSAGE",572);
define("MESSAGE_PAGE_MODULE_ADMIN",571);
define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$options = sensitiveIO::request('options');
if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
$winId = 'module'. $codename .'Window';
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module error for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}
if ($options) {
	$options = json_decode($options, true);
}
$moduleLabel = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
//create item for each objects
$objectsInfos = $module->getObjectsInfos($cms_user);
$items = '';
$activeTab = 0;
foreach ($objectsInfos as $objectsInfo) {
	$items .= ($items) ? ',':'';
	$label = $objectsInfo['description'] ? '<span ext:qtip="'.sensitiveIO::sanitizeJSString($objectsInfo['description']).'">'.sensitiveIO::sanitizeJSString($objectsInfo['label']).'</span>' : sensitiveIO::sanitizeJSString($objectsInfo['label']);
	$url = (isset($objectsInfo['url'])) ? $objectsInfo['url'] : PATH_ADMIN_MODULES_WR.'/'.$codename.'/items.php';
	$objectWinId = 'module'. $codename . $objectsInfo['objectId'] .'Panel';
	$objectsInfo['winId'] = $objectWinId;
	$objectsInfo['fatherId'] = $winId;
	$params = sensitiveIO::jsonEncode($objectsInfo);
	if (isset($options['objectId']) && $options['objectId'] == $objectsInfo['objectId']) {
		$activeTab = $objectWinId;
	} elseif($activeTab === 0) {
		$activeTab = $objectWinId;
	}
	if ($objectsInfo['objectId'] == 'categories') {
		$url = 'modules-categories.php';
	}
	if (!isset($objectsInfo['frame']) || $objectsInfo['frame'] == false) {
		$items .= "{
			title:	'{$label}',
			id:		'{$objectWinId}',
			xtype:	'atmPanel',
			layout:	'atm-border',
			autoLoad:		{
				url:		'{$url}',
				params:		{$params},
				nocache:	true,
				scope:		center
			}
		}";
	} else {
		$items .= "{
			title:			'{$label}',
			id:				'{$objectWinId}',
			xtype:			'framePanel',
			frameURL:		'{$url}',
			allowFrameNav:	true
		}";
	}
}

$jscontent = <<<END
	var moduleWindow = Ext.getCmp('{$winId}');
	//set window title
	moduleWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_MODULE_ADMIN, array($moduleLabel))}');
	//set help button on top of page
	moduleWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		moduleWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_MESSAGE, array($moduleLabel))}',
		dismissDelay:	0
	});
	//create center panel
	var center = new Ext.TabPanel({
        activeTab: 			'{$activeTab}',
        id:					'module{$codename}Panel',
		region:				'center',
		plain:				true,
		enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		defaults:			{
			autoScroll: true
		},
		items:[{$items}],
		listeners: {
			'beforetabchange' : function(tabPanel, newTab, currentTab ) {
				if (newTab.beforeActivate) {
					newTab.beforeActivate(tabPanel, newTab, currentTab);
				}
				if (newTab.rendered && newTab.update) {
					//update new tab on tab change
					newTab.update();
				}
				return true;
			},
			'tabchange': function(tabPanel, newTab) {
				if (newTab.afterActivate) {
					newTab.afterActivate(tabPanel, newTab);
				}
			}
		}
    });
	
	moduleWindow.add(center);
	//redo windows layout
	moduleWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>