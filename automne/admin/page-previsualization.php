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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page-previsualization.php,v 1.5 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : page previsualization
  * Used to view the page edited data.
  *
  * @package Automne
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());
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