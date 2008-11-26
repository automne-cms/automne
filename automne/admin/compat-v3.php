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
// $Id: compat-v3.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Compatibility file for old V3 modules
  * This file (called by constant PATH_ADMIN_SPECIAL_SESSION_CHECK_FS)
  * was used before Automne V4 for admin session management purposes.
  * Now it is used to set some PHP vars for old V3 modules compatibility
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//set error reporting level to default V3 value
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('PATH_ADMIN_SPECIAL_TREE_WR')) {
	define('PATH_ADMIN_SPECIAL_TREE_WR', '/automne/admin-v3/tree.php');
}
?>