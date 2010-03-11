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
// $Id: no-rights.php,v 1.4 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : No page info
  * Return info when no visible page is available
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_NO_PAGE_RIGHT", 692);

//load interface instance
$view = CMS_view::getInstance();
$view->addCSSFile('main');
$view->addCSSFile('info');

$content = '
<div id="atm-center">
	<div class="atm-alert atm-alert-green">'.$cms_language->getMessage(MESSAGE_PAGE_NO_PAGE_RIGHT).(sensitiveIO::isValidEmail(APPLICATION_MAINTAINER_EMAIL) ? ' (<a href="mailto:'.APPLICATION_MAINTAINER_EMAIL.'">'.APPLICATION_MAINTAINER_EMAIL.'</a>)' : '').'.</div>
</div>';

$view->setContent($content);
$view->show(CMS_view::SHOW_HTML);
?>