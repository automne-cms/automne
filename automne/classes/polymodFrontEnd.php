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
// $Id: polymodFrontEnd.php,v 1.4 2009/10/22 16:29:22 sebastien Exp $

/**
  * Main Include File of the Frontend Package : polymod
  * Includes all of the package files.
  */

//Add strict frontend requirements for polymod
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
//add ASE module if exists
if (file_exists(PATH_PACKAGES_FS.'/aseFrontEnd.php')) {
	require_once(PATH_PACKAGES_FS.'/aseFrontEnd.php');
}
//set public search status
$public_search = (isset($_GET["previz"]) && $_GET["previz"] == 'previz' && isset($_SERVER["HTTP_REFERER"]) && io::strpos($_SERVER["HTTP_REFERER"], "automne/admin") !== false) ? false : true;
?>