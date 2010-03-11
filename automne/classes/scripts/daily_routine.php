#!/usr/bin/env php
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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id:

/**
  * Daily routine script
  *
  * Checks all unpublished pages to delete them, etc.
  *
  * @package CMS
  * @subpackage backgroundScripts
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

//define application type
define('APPLICATION_EXEC_TYPE', 'cli');
//include required file
require_once(dirname(__FILE__).'/../../../cms_rc_admin.php');

$modules = CMS_modulesCatalog::getAll();
foreach ($modules as $aModule) {
	$aModule->processDailyRoutine();
}
?>
