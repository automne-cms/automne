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
// $Id: templates.php,v 1.2 2009/04/02 13:55:55 sebastien Exp $

/**
  * PHP page : Load templates management window
  * Used accross an Ajax request
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

$winId = sensitiveIO::request('winId', '', 'templatesWindow');
$type = sensitiveIO::request('type', array('template','row','css','js','wysiwyg-toolbar'));

//CHECKS user has templates or rows clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on pages templates');
	$view->setActionMessage('Vous n\'avez pas les droits sur l\'édition des modèles ...');
	$view->show();
}
$items = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	$items .= "{
		title:	'Modèles de pages',
		id:		'templatePanel',
		xtype:	'atmPanel',
		layout:	'atm-border',
		autoLoad:		{
			url:		'templates-page.php',
			params:		{
				winId:		'templatePanel',
				fatherId:	'{$winId}'
			},
			nocache:	true,
			scope:		center
		}
	},";
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	$items .= "{
		title:	'Modèles de rangées',
		id:		'rowPanel',
		xtype:	'atmPanel',
		layout:	'atm-border',
		autoLoad:		{
			url:		'templates-row.php',
			params:		{
				winId:		'rowPanel',
				fatherId:	'{$winId}'
			},
			nocache:	true,
			scope:		center
		}
	},";
}
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	$items .= "{
		title:	'Feuilles de styles',
		id:		'cssPanel',
		xtype:	'atmPanel',
		layout:	'atm-border',
		autoLoad:		{
			url:		'templates-files.php',
			params:		{
				winId:		'cssPanel',
				fatherId:	'{$winId}',
				type:		'css'
			},
			nocache:	true,
			scope:		center
		}
	},{
		title:	'Scripts Javascripts',
		id:		'jsPanel',
		xtype:	'atmPanel',
		layout:	'atm-border',
		autoLoad:		{
			url:		'templates-files.php',
			params:		{
				winId:		'jsPanel',
				fatherId:	'{$winId}',
				type:		'js'
			},
			nocache:	true,
			scope:		center
		}
	},{
		xtype:			'framePanel',
		title:			'Barres d\'outils Wysiwyg',
		id:				'toolbarWysiwygPanel',
		frameURL:		'/automne/admin-v3/wysiwyg.php',
		allowFrameNav:	true
	},";
}
//remove last comma
$items = substr($items, 0, -1);

switch($type) {
	case 'row':
		$activeTab = 'rowPanel';
	break;
	case 'css':
		$activeTab = 'cssPanel';
	break;
	case 'js':
		$activeTab = 'jsPanel';
	break;
	case 'wysiwyg-toolbar':
		$activeTab = 'toolbarWysiwygPanel';
	break;
	case 'template':
	default:
		$activeTab = 'templatePanel';
	break;
}

$jscontent = <<<END
	var templatesWindow = Ext.getCmp('{$winId}');
	//set window title
	templatesWindow.setTitle('Gestion des modèles.');
	//set help button on top of page
	templatesWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		templatesWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'Sur cette page, vous pouvez gérer les modèles servant à la création des pages ainsi que les modèles des rangées de contenu employé dans les pages. Vous pouvez aussi gérer les feuiles de styles et les barres d\'outils employées par l\'éditeur WYSIWYG.',
		dismissDelay:	0
	});
	//create center panel
	var center = new Ext.TabPanel({
        activeTab: 			'{$activeTab}',
        id:					'templatesPanel',
		region:				'center',
		plain:				true,
        enableTabScroll:	true,
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

	templatesWindow.add(center);
	//redo windows layout
	templatesWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>