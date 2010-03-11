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
// $Id: regenerateall.php,v 1.6 2010/03/08 16:43:32 sebastien Exp $

/**
  * background script : regenerateall
  *
  * Regenerates All the pages : call the function in CMS_tree and lauch regenerator
  *
  * @package CMS
  * @subpackage backgroundScripts
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */
//define application type
define('APPLICATION_EXEC_TYPE', 'cli');
//include required file
require_once(dirname(__FILE__).'/../../../cms_rc_admin.php');

CMS_tree::regenerateAllPages(true);
?>
