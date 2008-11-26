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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: index.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : index
  * Manages the login and logout of users. Creates the context and put it into $_SESSION.
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_PAGE_LOADING", 1321);

//load language object
$language = CMS_languagesCatalog::getDefaultLanguage(true);

//load interface instance
$view = CMS_view::getInstance();
//set main and ext CSS
$view->addCSSFile('ext');
$view->addCSSFile('main');
if (SYSTEM_DEBUG) {
	$view->addCSSFile('blackbird');
}
//set needed JS files
if (SYSTEM_DEBUG) {
	$jsfiles = array('ext','blackbird','codemirror','main','launch');
} else {
	$jsfiles = array('ext','codemirror','main','launch');
}

//set title
$view->settitle($language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)));

$content = '
<div id="atm-loading-mask"></div>
<div id="atm-center">
	<div class="atm-loading-indicator">'.$language->getMessage(MESSAGE_PAGE_LOADING).'</div>
	<noscript class="atm-alert">You must have Javascript enabled to access Automne.<hr />Vous devez avoir Javascript actif pour accéder à Automne.</noscript>
</div>
<!-- include everything after the loading indicator -->
'.CMS_view::getJavascript($jsfiles);
if (isset($_REQUEST["cms_action"]) && $_REQUEST["cms_action"] == 'logout') {
	//append logout info
	$content .= '<script type="text/javascript">Automne.logout = true;</script>';
}
$content .= '
<div id="atm-server-call"></div>';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>