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
// $Id: scripts.php,v 1.6 2010/03/08 16:41:20 sebastien Exp $

/**
  * PHP page : Simple empty page, used to refresh scripts count
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_XML);
//This file is an admin file. Interface must be secure
$view->setSecure();

//if we do not use background regenerator, then it is time to run pending scripts
if (!USE_BACKGROUND_REGENERATOR) {
	CMS_scriptsManager::runQueuedScripts();
}

define("MESSAGE_PAGE_ACTION_SCRIPTS_LEFT_NONE", 10);
define("MESSAGE_PAGE_SCRIPTS_IN_PROGRESS", 735);
define("MESSAGE_PAGE_SCRIPTS_IN_PROGRESS_PID_OK", 736);
define("MESSAGE_PAGE_NO_SCRIPTS_PID_OK", 737);
define("MESSAGE_PAGE_SCRIPTS_END_PID_OK", 738);
define("MESSAGE_PAGE_NO_SCRIPTS_IN_PROGRESS", 739);
define("MESSAGE_PAGE_NO_SCRIPTS_QUEUED", 740);

//Controler vars
$details = (sensitiveIO::request('details') == 'true') ? true : false;
$queue = (sensitiveIO::request('queue') == 'true') ? true : false;

$xmlcontent = $detailsContent = $queueContent = '';

if ($details) {
	$runningScripts = processManager::getRunningScript();
	if (is_array($runningScripts) && sizeof($runningScripts)) {
		$detailsContent = '<ul class="atm-server">';
		foreach ($runningScripts as $runningScript) {
			$date= new CMS_date();
			$date->setFromDBValue($runningScript["Date"]);
			switch ($runningScript["PIDFile"]) {
				case '0':
					$detailsContent .= '<li class="atm-pic-question" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_IN_PROGRESS).'">'.$runningScript["Title"].' ('.$date->getLocalizedDate($cms_language->getDateFormat()." H:i:s").')</li>';
				break;
				case '1':
					$detailsContent .= '<li class="atm-pic-ok" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_IN_PROGRESS_PID_OK).'">'.$runningScript["Title"].' ('.$date->getLocalizedDate($cms_language->getDateFormat()." H:i:s").')</li>';
				break;
				case '2':
					$detailsContent .= '<li class="atm-pic-cancel" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_NO_SCRIPTS_PID_OK).'">'.$runningScript["Title"].' ('.$date->getLocalizedDate($cms_language->getDateFormat()." H:i:s").')</li>';
				break;
				case '3':
					$detailsContent .= '<li class="atm-pic-cancel" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_END_PID_OK).'">'.$runningScript["Title"].' ('.$date->getLocalizedDate($cms_language->getDateFormat()." H:i:s").')</li>';
				break;
			}
		}
		$detailsContent .= '</ul>';
	} else {
		$detailsContent = $cms_language->getJsMessage(MESSAGE_PAGE_NO_SCRIPTS_IN_PROGRESS);
	}
}
if ($queue) {
	$scripts = CMS_scriptsManager::getScriptsLeft();
	if (is_array($scripts) && sizeof($scripts)) {
		$queueContent = '<ol>';
		foreach ($scripts as $script) {
			$queueContent .= '<li>'.$script.'</li>';
		}
		$queueContent .= '</ol>';
	} else {
		$queueContent .= $cms_language->getJsMessage(MESSAGE_PAGE_NO_SCRIPTS_QUEUED);
	}
}
if ($detailsContent || $queueContent) {
	$xmlcontent = '
	<details><![CDATA['.$detailsContent.']]></details>
	<queue><![CDATA['.$queueContent.']]></queue>';
	$view->setContent($xmlcontent);
	
	$jscontent = '
	if (Ext.get(\'scriptsDetailText\')) {
		Ext.get(\'scriptsDetailText\').dom.innerHTML = response.responseXML.getElementsByTagName(\'details\').item(0).firstChild.nodeValue;
	}
	if (Ext.get(\'scriptsQueueText\')) {
		Ext.get(\'scriptsQueueText\').dom.innerHTML = response.responseXML.getElementsByTagName(\'queue\').item(0).firstChild.nodeValue;
	}';
	$view->addJavascript($jscontent);
}
//send
$view->show();
?>