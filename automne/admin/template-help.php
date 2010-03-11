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
// $Id: template-help.php,v 1.5 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load template help window.
  * Used accross an Ajax request.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_PAGE", 282);
define("MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES", 799);
define("MESSAGE_PAGE_TITLE", 1468);
define("MESSAGE_TOOLBAR_HELP_DESC", 1469);

$winId = sensitiveIO::request('winId');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_ERROR_NO_RIGHTS_FOR_TEMPLATES));
	$view->show();
}

//include modules codes in output file
$template = '';
$modulesCodes = new CMS_modulesCodes();
$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_TEMPLATES_EDITION_LABELS, PAGE_VISUALMODE_CLIENTSPACES_FORM, $template, array("language" => $cms_language, "user" => $cms_user));
$modulesTab = '';
if (is_array($modulesCodeInclude) && $modulesCodeInclude) {
	foreach ($modulesCodeInclude as $codename => $description) {
		//if user has rights on module
		if ($cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
			$module = CMS_modulesCatalog::getByCodename($codename);
			$label = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
			$description = sensitiveIO::sanitizeJSString($description);
			$modulesTab .= "{
				title:				'{$label}',
				html:				'{$description}'
			},";
		}
	}
}
//remove last comma
if ($modulesTab) $modulesTab = io::substr($modulesTab, 0, -1);

$jscontent = <<<END
	var helpWindow = Ext.getCmp('{$winId}');
	//set window title
	helpWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}');
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