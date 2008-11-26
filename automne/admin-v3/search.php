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
// $Id: search.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : search
  * Search page. Presents all the result pages for a given search
  * 
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1091);
define("MESSAGE_SEARCH", 212);
define("MESSAGE_PAGE_SEARCH_RESULT", 1092);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_WEBSITE", 824);
/**
  *	Results by page for search in admin control panel
  *	Default : "20"
  */
if (!defined("RESULTS_BY_PAGE")) {
	define("RESULTS_BY_PAGE", "20");
}


$bookmark = ($_POST["bookmark"]) ? $_POST["bookmark"]:$_GET["bookmark"];
$pagenb = ($_GET["bookmark"]) ? $_GET["bookmark"]:'1';
$search = ($_POST["search"]) ? $_POST["search"]:urldecode($_GET["search"]);

if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($bookmark) {
	$_SESSION["cms_context"]->setBookmark($bookmark);
}

//function getSearch($keyword,&$user, $start='0', $max=CMS_search::MAX_RESULTS_BY_PAGE,$frontend=false)

$results = CMS_search::getSearch($search, $cms_user,(($pagenb-1)*RESULTS_BY_PAGE),RESULTS_BY_PAGE,false);
$dialog = new CMS_dialog();

$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content='
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
<input type="hidden" name="bookmark" value="1" />
'.$cms_language->getMessage(MESSAGE_SEARCH).' : <input type="text" name="search" class="admin_input_text" value="'.$search.'" style="width:200px;" />
<input type="image" name="valid" align="absmiddle" src="'.PATH_ADMIN_IMAGES_WR.'/search2.gif" value="'.$cms_language->getMessage(MESSAGE_SEARCH).'" />
</form>
';
if($results['message']){
	$content.='<br/><dialog-title type="admin_h3">'.$results['message'].'</dialog-title><br/>';
}
$content.='
<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SEARCH_RESULT).' : '.$results['nbresult'].'</dialog-title>
';

if ($results['nbresult']>0 && sizeof($results['results']>0)) {
	$nb_pages=ceil($results['nbresult']/RESULTS_BY_PAGE);
	$content .= '
	<table border="0" width="60%" cellpadding="2" cellspacing="2">
		<tr>
			<th class="admin">&nbsp;</th>
			<th class="admin">ID</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_WEBSITE).'</th>
			<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</th>
		</tr>';
	
	$count='';
	foreach ($results['results'] as $aResultPage) {
		if (is_object($aResultPage)) {
			$count++;
			$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
			$status = $aResultPage->getStatus();
			$ws = CMS_tree::getPageWebsite($aResultPage);
			if (is_object($ws)) {
				$label = $ws->getLabel();
			} else {
				$label = '<span class="admin_text_alert">Error</span>';
			}
			$content .= '
			<tr>
				<td width="14" class="'.$td_class.'" align="center">'.$status->getHTML(true,$cms_user,MOD_STANDARD_CODENAME,$aResultPage->getID()).'</td>
				<td width="14" class="'.$td_class.'">'.$aResultPage->getID().'</td>
				<td class="'.$td_class.'">'.$label.'</td>
				<td class="'.$td_class.'"><a href="page_summary.php?page='.$aResultPage->getID().'" target="main" class="admin">'.$aResultPage->getTitle().'</a></td>
			</tr>';
		}
	}
	$content .= '</table>
	<dialog-pages maxPages="'.$nb_pages.'"><dialog-pages-param name="search" value="'.urlencode($search).'" /></dialog-pages>';
}

$dialog->setContent($content);
$dialog->show();
?>