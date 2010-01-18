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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-previsualization.php,v 1.4 2010/01/18 15:23:54 sebastien Exp $

/**
  * PHP page : page previsualization
  * Used to view the page edited data.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger', $cms_context->getPageID());
$draft = sensitiveIO::request('draft') ? true : false;
//unset request to avoid it to have interaction with page code
sensitiveIO::unsetRequest(array('draft', 'currentPage'));

//CHECKS
if (!SensitiveIO::isPositiveInteger($currentPage)) {
	die("Invalid page");
}

//view edited or edition mode ?
$cms_visual_mode = ($draft) ? PAGE_VISUALMODE_HTML_EDITION : PAGE_VISUALMODE_HTML_EDITED;

$cms_page = CMS_tree::getPageByID($currentPage);
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	die('No rigths on page ...');
	exit;
}
//unset vars to avoid interraction with page
unset($currentPage);
unset($draft);
echo $cms_page->getContent($cms_language, $cms_visual_mode);
?>