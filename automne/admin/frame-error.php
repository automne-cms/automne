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
// $Id: frame-error.php,v 1.1 2010/01/18 15:23:54 sebastien Exp $

/**
  * PHP page : No page info
  * Return info when no visible page is available
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_FRAME_ERROR", 1597);

//load interface instance
$view = CMS_view::getInstance();
$view->addCSSFile('main');
$view->addCSSFile('info');

$content = '
<div id="atm-center">
	<div class="atm-alert atm-alert-green atm-frame-green">'.$cms_language->getMessage(MESSAGE_PAGE_FRAME_ERROR, array($_SERVER['HTTP_HOST'])).(sensitiveIO::isValidEmail(APPLICATION_MAINTAINER_EMAIL) ? ' (<a href="mailto:'.APPLICATION_MAINTAINER_EMAIL.'">'.APPLICATION_MAINTAINER_EMAIL.'</a>)' : '').'</div>
</div>';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>