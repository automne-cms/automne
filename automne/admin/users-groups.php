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
// $Id: users-groups.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Load page users-groups search window.
  * Used accross an Ajax request. Render users-groups search.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);

define("MESSAGE_PAGE_USER_GROUP_PROFILE", 408);
define("MESSAGE_PAGE_SEARCH_USER_GROUP_INFO", 409);
define("MESSAGE_PAGE_USERS_LABEL", 926);
define("MESSAGE_PAGE_GROUPS_LABEL", 837);

$winId = sensitiveIO::request('winId', '', 'usersGroupsWindow');
$type = (sensitiveIO::request('type') && in_array($_REQUEST['type'], array('users', 'groups')) ) ? $_REQUEST['type'].'Panel' : 'usersPanel';


//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

$jscontent = <<<END
	var usersGroupsWindow = Ext.getCmp('{$winId}');
	//set window title
	usersGroupsWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_USER_GROUP_PROFILE)}');
	//set help button on top of page
	usersGroupsWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		usersGroupsWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_SEARCH_USER_GROUP_INFO)}',
		dismissDelay:	0
	});
	//create center panel
	var center = new Ext.TabPanel({
        activeTab: 			0,
        id:					'usersGroupsPanel',
		region:				'center',
		plain:				true,
        enableTabScroll:	true,
		defaults:			{
			autoScroll: true
		},
		activeTab:			'{$type}',
        items:[{
				title:	'{$cms_language->getJSMessage(MESSAGE_PAGE_USERS_LABEL)}',
				id:		'usersPanel',
				xtype:	'atmPanel',
				layout:	'atm-border',
				autoLoad:		{
					url:		'users.php',
					params:			{
						fatherId:		usersGroupsWindow.id
					},
					nocache:	true,
					scope:		center
				}
			},{
				title:	'{$cms_language->getJSMessage(MESSAGE_PAGE_GROUPS_LABEL)}',
				id:		'groupsPanel',
				xtype:	'atmPanel',
				autoLoad:		{
					url:		'groups.php',
					params:			{
						fatherId:		usersGroupsWindow.id
					},
					nocache:	true,
					scope:		center
				}
            }
        ],
		listeners: {'beforetabchange' : function(tabPanel, newTab, currentTab ) {
			if (newTab.rendered) {
				//update search on new tab
				newTab.launchSearch();
			}
			return true;
		}}
    });
	
	usersGroupsWindow.add(center);
	//redo windows layout
	usersGroupsWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>