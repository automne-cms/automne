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
// $Id: help.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : help
  * Help page.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 10031);
define("MESSAGE_GUIDE_GUIDE-REDACTEUR", 1196);
define("MESSAGE_GUIDE_GUIDE-DEVELOPPEUR", 1197);
define("MESSAGE_GUIDE_GUIDE-ADMINISTRATEUR", 1198);
define("MESSAGE_GUIDE_GUIDE-INSTALLATION", 1199);
define("MESSAGE_GUIDE_PRESENTATION", 1200);
define("MESSAGE_GUIDE_GETTING-STARTED", 1201);
define("MESSAGE_PAGE_MULTIPLE_PAGES", 1202);
define("MESSAGE_PAGE_ONE_PAGE", 1203);
define("MESSAGE_PAGE_PDF_FILE", 1204);
define("MESSAGE_PAGE_ONLY_IN_DEFAULT_LANGUAGE", 1205);
define("MESSAGE_GUIDE_ONLINE", 1332);

$dialog = new CMS_dialog();

$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_aide.gif');
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$guidesURL = "http://www.automne.ws/docs";
$defaultLanguage = "fr";

/**
 * format : array(
 *				"guide_name" => "guide_level_clearance"
 *		   )
 * use constant "MESSAGE_GUIDE_".strtoupper(guide_name) for guide label
 */
$guides = array(
	"getting-started" => "",
	"presentation" => "",
	"guide-redacteur" => "",
	"guide-administrateur" => CLEARANCE_ADMINISTRATION_EDITUSERS,
	"guide-developpeur" => CLEARANCE_ADMINISTRATION_EDITUSERS,
	"guide-installation" => CLEARANCE_ADMINISTRATION_EDITUSERS,
);


$isDefaultLanguage = false;
if (@fopen($guidesURL.'/'.AUTOMNE_VERSION.'/'.$cms_language->getCode().'/index.php','r')) {
	//Inline Guides
	$url = $guidesURL.'/'.AUTOMNE_VERSION.'/'.$cms_language->getCode().'/index.php';
} elseif (@fopen($guidesURL.'/'.AUTOMNE_VERSION.'/'.$defaultLanguage.'/index.php','r')) {
	//distant guides in default language
	$isDefaultLanguage = true;
	$url = $guidesURL.'/'.AUTOMNE_VERSION.'/'.$defaultLanguage.'/index.php';
} else {
	//no guide available, send to automne.ws
	$isDefaultLanguage = true;
	$url = $guidesURL.'/';
}
if ($url != '') {
	$onlyInDefaultLanguage = ($isDefaultLanguage) ? ' ('.$cms_language->getMessage(MESSAGE_PAGE_ONLY_IN_DEFAULT_LANGUAGE).')':'';
	$content .= '<ul class="admin"><li class="admin"><img src="'.PATH_ADMIN_IMAGES_WR.'/pic_html.gif" align="absmiddle" border="0" /> <a href="'.$url.'" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_GUIDE_ONLINE).'</a>'.$onlyInDefaultLanguage.'</li></ul><br /><br />';
}


//HTML Guides
$content .='
<ul class="admin">';
foreach ($guides as $guideName => $guideClearance) {
	$isDefaultLanguage = false;
	//local guides in user language
	if (file_exists(PATH_ADMIN_FS.'/help/'.$cms_language->getCode().'/'.$guideName.'/index.html')) {
		$url = PATH_ADMIN_WR.'/help/'.$cms_language->getCode().'/'.$guideName;
	//local guides in default language
	} elseif (file_exists(PATH_ADMIN_FS.'/help/'.$defaultLanguage.'/'.$guideName.'/index.html')) {
		$isDefaultLanguage = true;
		$url = PATH_ADMIN_WR.'/help/'.$defaultLanguage.'/'.$guideName;
	//no guide available
	} else {
		$url = '';
	}
	if ($url != '' && ($guideClearance == '' || $cms_user->hasAdminClearance($guideClearance))) {
		$onlyInDefaultLanguage = ($isDefaultLanguage) ? ' ('.$cms_language->getMessage(MESSAGE_PAGE_ONLY_IN_DEFAULT_LANGUAGE).')':'';
		$content .= '<li class="admin"><img src="'.PATH_ADMIN_IMAGES_WR.'/pic_html.gif" align="absmiddle" border="0" /> '.$cms_language->getMessage(constant("MESSAGE_GUIDE_".strtoupper($guideName))).' : <a href="'.$url.'/index.html" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_MULTIPLE_PAGES).'</a>, <a href="'.$url.'/full.html" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_ONE_PAGE).'</a>'.$onlyInDefaultLanguage.'</li><br /><br />';
	}
}
$content .='
</ul>';

//PDF Guides
$content .='
<ul class="admin">';
foreach ($guides as $guideName => $guideClearance) {
	$isDefaultLanguage = false;
	//local guides in user language
	if (file_exists(PATH_ADMIN_FS.'/help/'.$cms_language->getCode().'/'.$guideName.'/'.sensitiveIO::sanitizeAsciiString($cms_language->getMessage(constant("MESSAGE_GUIDE_".strtoupper($guideName)))).'.pdf')) {
		$url = PATH_ADMIN_WR.'/help/'.$cms_language->getCode().'/'.$guideName;
	//local guides in default language
	} elseif (file_exists(PATH_ADMIN_FS.'/help/'.$defaultLanguage.'/'.$guideName.'/'.sensitiveIO::sanitizeAsciiString($cms_language->getMessage(constant("MESSAGE_GUIDE_".strtoupper($guideName)))).'.pdf')) {
		$isDefaultLanguage = true;
		$url = PATH_ADMIN_WR.'/help/'.$defaultLanguage.'/'.$guideName;
	//no guide available
	} else {
		$url = '';
	}
	if ($url != '' && ($guideClearance == '' || $cms_user->hasAdminClearance($guideClearance))) {
		$onlyInDefaultLanguage = ($isDefaultLanguage) ? ' ('.$cms_language->getMessage(MESSAGE_PAGE_ONLY_IN_DEFAULT_LANGUAGE).')':'';
		$content .= '<li class="admin"><img src="'.PATH_ADMIN_IMAGES_WR.'/pic_acrobat.gif" align="absmiddle" border="0" /> '.$cms_language->getMessage(constant("MESSAGE_GUIDE_".strtoupper($guideName))).' : <a href="'.$url.'/'.sensitiveIO::sanitizeAsciiString($cms_language->getMessage(constant("MESSAGE_GUIDE_".strtoupper($guideName)))).'.pdf" target="_blank" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_PDF_FILE).'</a>'.$onlyInDefaultLanguage.'</li><br /><br />';
	}
}
$content .='
</ul>';

$dialog->setContent($content);
$dialog->show();
?>