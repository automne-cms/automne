<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2004 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | or (at your discretion) to version 3.0 of the PHP license.           |
// | The first is bundled with this package in the file LICENSE-GPL, and  |
// | is available at through the world-wide-web at                        |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | The later is bundled with this package in the file LICENSE-PHP, and  |
// | is available at through the world-wide-web at                        |
// | http://www.php.net/license/3_0.txt.                                  |
// +----------------------------------------------------------------------+
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: is_alive.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

// This page aims to check if website keeps alive
// A production purpose
//
// @param boolean $_GET["quiet"] : won't produce output
// 
// In a cron can use such script :
// For a quiet version (Outputs only if any problem founded)
// 0 0 * * * root /usr/bin/lynx http://serveraddr/is_alive.php?quiet=true
// 
// More visually or to get informed by email set :
// http://serveraddr/is_alive.php
//
// 1. Test database server connection
// 2. Test database selection
// 3. Test HTTP Header response on main page
// 4. Prints Nothing or OK if anything goes well, KO otherwise
// also send a mail to an administrator
// 

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

// Email to advertise when problem found on website
define("EMAIL_SYSTEME_ADMIN", APPLICATION_MAINTAINER_EMAIL);

// Page to test HTTP response of
define("INDEX_PAGE", '/index.php');

// Stores errors founded while running tests
$errs = array();

// Test database connection to server
if (APPLICATION_DB_HOST != '' && APPLICATION_DB_NAME != '' && APPLICATION_DB_USER != '') {
	$db = new PDO(APPLICATION_DB_DSN, APPLICATION_DB_USER, APPLICATION_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => APPLICATION_DB_PERSISTENT_CONNNECTION, PDO::ERRMODE_EXCEPTION => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	if (!is_object($db)) {
		$errs[] = 'DB Connexion failed !';
	}
}

// Test HTTP Header on main page
$port = ($_SERVER["SERVER_PORT"] > 0 ) ? $_SERVER["SERVER_PORT"] : 80 ;
$fp = @fsockopen($_SERVER["SERVER_ADDR"], $port, $errno, $errstr, 30);
if ($errno !== 0 || $fp === false) {
   $errs[] = 'Socket open failed on server : '.$_SERVER["HTTP_HOST"].', port '.$port.' : '.$errstr;
} else {
    @fwrite($fp, "HEAD ".INDEX_PAGE." HTTP/1.0\r\nHost: ".$_SERVER["HTTP_HOST"]."\r\n\r\n");
    $http_response = @fgets($fp, 25);
    if (@strpos($http_response, "404") !== false 
    		|| @strpos($http_response, "500") !== false) {
    	$errs[] = 'HTTP Error found on page '.INDEX_PAGE.' : '.$http_response;
    }
}
@fclose($fp);

// Output
if (!$errs) {
	if (!isset($_GET["quiet"])) {
		echo 'REPONSE_CORRECTE';
	}
} else {
	$to = APPLICATION_LABEL." administrator <".APPLICATION_MAINTAINER_EMAIL.">";
	$message = @implode("\n", $errs);
	$headers = "From: ".APPLICATION_LABEL." <".APPLICATION_LABEL.">\r\n";
	@mail($to, '[alert] Website '.APPLICATION_LABEL.'('.$_SERVER["SERVER_NAME"].') KO ?', $message, $headers);
	echo 'KO' ;
}
?>
