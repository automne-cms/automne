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
// $Id: page-previsualization.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

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

//CHECKS
if (!SensitiveIO::isPositiveInteger($currentPage)) {
	die("Invalid page");
}

//view edited or edition mode ?
$visual_mode = ($draft) ? PAGE_VISUALMODE_HTML_EDITION : PAGE_VISUALMODE_HTML_EDITED;

$cms_page = CMS_tree::getPageByID($currentPage);
if (!$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

echo $cms_page->getContent($cms_language, $visual_mode);

/*only for stats*/
if (STATS_DEBUG) view_stat();
?>