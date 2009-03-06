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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: favorites-sidepanel.php,v 1.3 2009/03/06 10:51:51 sebastien Exp $

/**
  * PHP page : Load side panel favorites infos.
  * Used accross an Ajax request to refresh the favorites side panel
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

$content = '';

$favorites = $cms_user->getFavorites();
if ($favorites) {
	foreach($favorites as $pageId) {
		$page = CMS_tree::getPageById($pageId);
		if (is_object($page) && $page->getTitle() && !$page->hasError()) {
			$content .= '<li><a href="#" atm:action="favorite" atm:page="'.$pageId.'" alt="'.htmlspecialchars($page->getTitle()).'" title="'.htmlspecialchars($page->getTitle()).'">'.$page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $page->getID()).'&nbsp;'.sensitiveIO::ellipsis($page->getTitle(), 32).'&nbsp;('.$pageId.')</a></li>';
		}
	}
}
if ($content) {
	$content = '<ul>'.$content.'</ul>';
} else {
	$content .= 'Aucune page dans vos favoris.';
}

//send content
$view->setContent($content);
$view->show();
?>