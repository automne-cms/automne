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

/**
  * PHP page : Load help detail window.
  * Used accross an Ajax request. Render help informations.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

$winId = sensitiveIO::request('winId', '', 'atmHelpWindow');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_UNKNOWN",670);
define("MESSAGE_PAGE_NEVER",671);
define("MESSAGE_PAGE_VERSION",542);
define("MESSAGE_PAGE_ABOUT_MESSAGE",672);
define("MESSAGE_TOOLBAR_HELP_MESSAGE",673);
define("MESSAGE_PAGE_TITLE",644);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

if (!defined('MOD_POLYMOD_CODENAME')) {
	define('MOD_POLYMOD_CODENAME', 'polymod');
}

//show version number
$polymodVersion = file_exists(PATH_MODULES_FS.'/'.MOD_POLYMOD_CODENAME.'/VERSION') ? file_get_contents(PATH_MODULES_FS.'/'.MOD_POLYMOD_CODENAME.'/VERSION') : $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN);
$lastUpdate = AUTOMNE_LASTUPDATE ? date($cms_language->getDateFormat().' - H:i:s' , AUTOMNE_LASTUPDATE) : $cms_language->getMessage(MESSAGE_PAGE_NEVER);

$modules = CMS_modulesCatalog::getAll();
$modulesInfo = '';
foreach($modules as $module){
	if (!$module->isPolymod() && $module->getCodename() != MOD_STANDARD_CODENAME) {
		$modulesInfo .= $module->getLabel($cms_language);
		if (file_exists(PATH_MODULES_FS.'/'.$module->getCodename().'/VERSION')) {
			$modulesInfo .= ' - '.$cms_language->getMessage(MESSAGE_PAGE_VERSION).' : '.file_get_contents(PATH_MODULES_FS.'/'.$module->getCodename().'/VERSION');
		}
		$modulesInfo .= '<br />';
	}
}

//Scripts content
$content = $cms_language->getMessage(MESSAGE_PAGE_ABOUT_MESSAGE, array(AUTOMNE_VERSION, $lastUpdate, $polymodVersion, $modulesInfo));

$content = sensitiveIO::sanitizeJSString($content);

$jscontent = <<<END
	var serverWindow = Ext.getCmp('{$winId}');
	//set window title
	serverWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}');
	//set help button on top of page
	serverWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 serverWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_MESSAGE)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		activeTab:			 0,
		id:					'serverScriptsPanels',
		region:				'center',
		border:				false,
		autoScroll:			true,
		bodyCssClass: 		'help-window',
		html:				'$content'
	});
	serverWindow.add(center);
	//redo windows layout (timeout is for IE)
	setTimeout(function(){serverWindow.doLayout();}, 100);
END;
$view->addJavascript($jscontent);
$view->show();
?>