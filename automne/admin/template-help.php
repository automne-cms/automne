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
// $Id: template-help.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Load template help window.
  * Used accross an Ajax request.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_PAGE", 282);

$winId = sensitiveIO::request('winId');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//CHECKS user has templates clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
	CMS_grandFather::raiseError('User has no rights template editions');
	$view->setActionMessage('Vous n\'avez pas le droit de gérer les modèles de pages ...');
	$view->show();
}

//include modules codes in output file
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
if ($modulesTab) $modulesTab = substr($modulesTab, 0, -1);

$jscontent = <<<END
	var helpWindow = Ext.getCmp('{$winId}');
	//set window title
	helpWindow.setTitle('Aide à la syntaxe des modèles');
	//set help button on top of page
	helpWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		helpWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'Cette fenêtre regroupe les différentes aides nécessaire à la création de modèles pour chacun des modules.',
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