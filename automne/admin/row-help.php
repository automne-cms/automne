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
// $Id: row-help.php,v 1.5 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP page : Load template help window.
  * Used accross an Ajax request.
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_PAGE", 282);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS", 706);
define("MESSAGE_PAGE_ROW_SYNTAX_HELP", 727);
define("MESSAGE_TOOLBAR_HELP_DESC", 728);

$winId = sensitiveIO::request('winId');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has row edition clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
	CMS_grandFather::raiseError('User has no rights on rows editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_ROWS));
	$view->show();
}

//include modules codes in output file
$row = '';
$modulesCodes = new CMS_modulesCodes();
$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_ROWS_EDITION_LABELS, PAGE_VISUALMODE_CLIENTSPACES_FORM, $row, array("language" => $cms_language, "user" => $cms_user));
$modulesTab = '';
if (is_array($modulesCodeInclude) && $modulesCodeInclude) {
	foreach ($modulesCodeInclude as $codename => $description) {
		//if user has rights on module
		if ($cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
			$module = CMS_modulesCatalog::getByCodename($codename);
			if (is_object($module) && !$module->hasError()) {
				$label = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
				$description = sensitiveIO::sanitizeJSString($description);
				$modulesTab .= "{
					title:				'{$label}',
					html:				'{$description}'
				},";
			}
		}
	}
}
//remove last comma
if ($modulesTab) $modulesTab = io::substr($modulesTab, 0, -1);

$jscontent = <<<END
	var helpWindow = Ext.getCmp('{$winId}');
	//set window title
	helpWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_ROW_SYNTAX_HELP)}');
	//set help button on top of page
	helpWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		helpWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});

	var center = new Ext.TabPanel({
		activeTab: 			0,
        region:				'center',
		plain:				true,
        enableTabScroll:	true,
		plugins:			[ new Ext.ux.TabScrollerMenu() ],
		defaults:			{
			border:				false,
			autoScroll:			true,
			bodyStyle: 			'padding:5px',
			cls:				'atm-help-panel'
		},
		items: [{$modulesTab}]
	});
	helpWindow.add(center);
	//redo windows layout
	helpWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>