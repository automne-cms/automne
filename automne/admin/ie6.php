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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: ie6.php,v 1.2 2010/03/08 16:41:18 sebastien Exp $

/**
  * PHP page : change navigator
  * Manage the navigator version if Netscape 4
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
  
require_once(dirname(__FILE__).'/../../cms_rc_frontend.php');

define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_PAGE_NAV_OLD", 1093);

//load language object
$language = CMS_languagesCatalog::getDefaultLanguage(true);

//load interface instance
$view = CMS_view::getInstance();
//set main CSS
$view->addCSSFile('main');
$view->addCSSFile('info');
//set title
$view->settitle($language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)));

$content = '
<div id="atm-center" class="no-ie6">
	<div class="atm-alert"><img src="img/no-ie6.jpg" title="NO IE6" />'.$language->getMessage(MESSAGE_PAGE_NAV_OLD).'</div>
</div>
';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>