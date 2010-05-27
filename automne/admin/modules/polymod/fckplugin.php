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
// $Id: fckplugin.php,v 1.6 2010/03/08 16:42:06 sebastien Exp $

/**
  * PHP page : Load module backend window
  * Used accross an Ajax request
  * 
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_ERROR_NO_PLUGIN", 280);
define("MESSAGE_PAGE_TAB_DISABLED_SELECT_TEXT", 523);
define("MESSAGE_PAGE_TAB_DISABLED_NO_SELECT_TEXT", 524);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$id = sensitiveIO::request('id');
$content = sensitiveIO::request('content');

//get ids from wysiwyg
if ($id) {
	$ids = explode('-', $id);
	$selectedPluginID = (int) $ids[1];
	$selectedItem = (int) $ids[2];
} else {
	$selectedPluginID = $selectedItem = 0;
}

//Select WYSIWYG Plugin
$pluginDefinitions = CMS_poly_object_catalog::getAllPluginDefinitionsForObject();
//check for user rights
$availablePlugin = array();
$availablePluginCount = 0;
if (sizeof($pluginDefinitions)) {
	foreach ($pluginDefinitions as $id => $pluginDefinition) {
		$objectID = $pluginDefinition->getValue('objectID');
		$polyModuleCodename = CMS_poly_object_catalog::getModuleCodenameForObjectType($objectID);
		if ($cms_user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_EDIT)) {
			$availablePlugin[$polyModuleCodename][$id] = $pluginDefinition;
			$availablePluginCount++;
		}
	}
}
//if no plugin available, display error and quit
if (!sizeof($availablePlugin)) {
	//messages
	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_NO_PLUGIN, false, MOD_POLYMOD_CODENAME);
	$view->setActionMessage($cms_message);
	$view->show();
}

$items = '';
$activeTab = 0;
$url = PATH_ADMIN_MODULES_WR.'/polymod/item-selector.php';
$pluginControler = PATH_ADMIN_MODULES_WR.'/polymod/items-controler.php';

foreach ($availablePlugin as $aPolyModuleCodename => $pluginDefinitions) {
	$polymodule = CMS_modulesCatalog::getByCodename($aPolyModuleCodename);
	foreach ($pluginDefinitions as $id => $pluginDefinition) {
		$items .= ($items) ? ',':'';
		$objectWinId = 'module'. $aPolyModuleCodename .'-'. $id .'Plugin';
		if ($pluginDefinition->needSelection() && !$content && $selectedPluginID != $id) {
			$disabled = 'disabled:true,';
			$label = '<span ext:qtip="'.sensitiveIO::sanitizeJSString($polymodule->getLabel($cms_language).' : '.$pluginDefinition->getDescription($cms_language).'<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_TAB_DISABLED_SELECT_TEXT, false, MOD_POLYMOD_CODENAME)).'</strong>">'.sensitiveIO::sanitizeJSString($pluginDefinition->getLabel($cms_language)).'</span>';
		} elseif (!$pluginDefinition->needSelection() && $content && $selectedPluginID != $id) {
			$disabled = 'disabled:true,';
			$label = '<span ext:qtip="'.sensitiveIO::sanitizeJSString($polymodule->getLabel($cms_language).' : '.$pluginDefinition->getDescription($cms_language).'<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_TAB_DISABLED_NO_SELECT_TEXT, false, MOD_POLYMOD_CODENAME)).'</strong>">'.sensitiveIO::sanitizeJSString($pluginDefinition->getLabel($cms_language)).'</span>';
		} else {
			if ($selectedPluginID == $id || $activeTab === 0) {
				$activeTab = $objectWinId;
			}
			$disabled = '';
			$label = '<span ext:qtip="'.sensitiveIO::sanitizeJSString($polymodule->getLabel($cms_language).' : '.$pluginDefinition->getDescription($cms_language)).'">'.sensitiveIO::sanitizeJSString($pluginDefinition->getLabel($cms_language)).'</span>';
		}
		$params = sensitiveIO::jsonEncode(array(
			'winId'			=> $objectWinId,
			'objectId'		=> $pluginDefinition->getValue('objectID'),
			'plugin'		=> $id,
			'selectedItem'	=> $selectedItem,
			'content'		=> $content,
			'module'		=> $aPolyModuleCodename
		));
		$items .= "{
			{$disabled}
			title:	'{$label}',
			id:		'{$objectWinId}',
			xtype:	'atmPanel',
			layout:	'atm-border',
			autoLoad:		{
				url:		'{$url}',
				params:		{$params},
				nocache:	true,
				scope:		center
			},
			selectItem:		function(id, params) {
				if (id) {
					window.parent.SetOkButton( false ) ;
					//grab code to paste from selected item id
					Automne.server.call('{$pluginControler}', function(response, option, content){
						window.parent.SetOkButton( true ) ;
						document.getElementById('codeToPaste').value = content;
					}, Ext.apply({
						item:		id,
						type:		params.objectId,
						action:		'pluginSelection'
					}, params), this);
				} else {
					document.getElementById('codeToPaste').value = ' ';
				}
			}.createDelegate(this, [{$params}], true)
		}";
	}
}

$jscontent = <<<END
	var moduleWindow = Ext.getCmp('{$winId}');
	//create center panel
	var center = new Ext.TabPanel({
        activeTab: 			'{$activeTab}',
        id:					'modulePluginsPanel',
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