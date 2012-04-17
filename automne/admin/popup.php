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
//
// $Id: index.php,v 1.12 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : index
  * Manages the login and logout of users. Creates the context and put it into $_SESSION.
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_PAGE_LOADING", 1321);

//load language object
$language = CMS_languagesCatalog::getDefaultLanguage(true);

//load interface instance
$view = CMS_view::getInstance();

//set main and ext CSS
$view->addCSSFile('ext');
$view->addCSSFile('main');
$view->addCSSFile('codemirror');
if (SYSTEM_DEBUG) {
	$view->addCSSFile('debug');
}
//set needed JS files
if (SYSTEM_DEBUG) {
	$jsfiles = array('ext','debug','codemirror','main');
} else {
	$jsfiles = array('ext','codemirror','main');
}

//set title
$view->setTitle($language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)));

$content = '
<div id="atm-loading-mask"></div>
<div id="atm-center">
	<div class="atm-loading-indicator">'.$language->getMessage(MESSAGE_PAGE_LOADING).'</div>
	<noscript class="atm-alert">You must have Javascript enabled to access Automne.<hr />Vous devez avoir Javascript actif pour acc&eacute;der &agrave; Automne.</noscript>
</div>
<script type="text/javascript">
var CKEDITOR_BASEPATH = \''.PATH_MAIN_WR.'/ckeditor/\';
</script>
'.CMS_view::getJavascript($jsfiles).CMS_view::getJavascript(array('popup'));

if (APPLICATION_GCF_SUPPORT) {
	//GCF prompt for IE
	$content .= '
	<script type="text/javascript" 
		src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
	<style type="text/css">
	.chromeFrameOverlayContent {
		z-index:200001;
	}
	</style> 
	<script type="text/javascript">
		CFInstall.check({mode: "overlay"});
	</script>';
}
//Page content
$content .= '
<div id="atm-server-call"></div>
<div style="display:none;">
<form id="history-form" class="x-hidden">
    <input type="hidden" id="x-history-field" />
    <iframe id="x-history-frame"></iframe>
</form>
</div>
<div class="x-hidden"><hr />If this message does not disappear in a few seconds, please contact your system administrator or consult the Automne error log file.<hr />Si ce message ne dispara&icirc;t pas dans quelques secondes, veuillez contacter votre administrateur syst&egrave;me ou consulter le fichier de log d\'erreur d\'Automne.</div>
';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>