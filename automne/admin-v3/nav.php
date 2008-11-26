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
// $Id: nav.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : change navigator
  * Manage the navigator version if Netscape 4
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
  
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_TITLE", 51);
define("MESSAGE_PAGE_NAV_OLD", 1093);

if ($_GET["language"] && SensitiveIO::isInSet($_GET["language"], array_keys(CMS_languagesCatalog::getAllLanguages()))) {
	$language = CMS_languagesCatalog::getByCode($_GET["language"]);
	if (!$language) {
		$language = CMS_languagesCatalog::getDefaultLanguage();
	}
} elseif (SensitiveIO::isInSet(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), array_keys(CMS_languagesCatalog::getAllLanguages()))) {
	$language = CMS_languagesCatalog::getByCode(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));
	if (!$language) {
		$language = CMS_languagesCatalog::getDefaultLanguage();
	}
} else {
	$language = CMS_languagesCatalog::getDefaultLanguage();
}

echo '
<html>
<head>
	<title>'.$language->getMessage(MESSAGE_PAGE_TITLE, array(APPLICATION_LABEL)).'</title>
</head>
<body>
';
echo $language->getMessage(MESSAGE_PAGE_NAV_OLD);
echo '
</body>
</html>
'
?>