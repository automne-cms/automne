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
// $Id: modules.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : arbo
  * Menu page. Presents all the user menu "sections"
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 264);
define("MESSAGE_PAGE_MODULES_PARAMETERS", 807);

$dialog = new CMS_dialog();
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
} else if ($_GET["cms_message"]!='') {
	$dialog->setActionMessage(SensitiveIO::sanitizeHTMLString($_GET["cms_message"]));
}

$content = '';

//THE MODULES ADMINISTRATIONS
$modules = CMS_modulesCatalog::getALL();
$modules_good = array();
foreach ($modules as $module) {
	if ($module->getCodename() != MOD_STANDARD_CODENAME
		&& $cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {
		$modules_good[] = $module;
	}
}
if (sizeof($modules_good)) {
	$content .= '<ul class="admin">';
	foreach ($modules_good as $module) {
		$content .= '
			<li class="admin">
			<a class="admin" href="'.$module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT).'" target="main">'.$module->getLabel($cms_language).'</a>';
		$content .= '</li>';
	}
	$content .= '</ul>';
} else {
	$cms_context->setSessionVar('hauteurModules',0);
}
$dialog->setContent($content);
$dialog->show('modules');
?>