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
// $Id: favorites-sidepanel.php,v 1.7 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP page : Load side panel favorites infos.
  * Used accross an Ajax request to refresh the favorites side panel
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

define('MESSAGE_PAGE_NO_BOOKMARKS', 645);

$content = '';

$favorites = $cms_user->getFavorites();
if ($favorites) {
	foreach($favorites as $pageId) {
		$page = CMS_tree::getPageById($pageId);
		if (is_object($page) && $page->getTitle() && !$page->hasError()) {
			$content .= '<li><a href="#" atm:action="favorite" atm:page="'.$pageId.'" alt="'.io::htmlspecialchars($page->getTitle()).'" title="'.io::htmlspecialchars($page->getTitle()).'">'.$page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $page->getID()).'&nbsp;'.sensitiveIO::ellipsis($page->getTitle(), 32).'&nbsp;('.$pageId.')</a></li>';
		}
	}
}
if ($content) {
	$content = '<ul>'.$content.'</ul>';
} else {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_NO_BOOKMARKS);
}

//send content
$view->setContent($content);
$view->show();
?>