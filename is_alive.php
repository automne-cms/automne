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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: is_alive.php,v 1.3 2010/03/08 16:45:48 sebastien Exp $

/**
  * PHP page : This page aims to check if website keeps alive
  * For a production purpose
  * 
  * In a cron can use such script :
  * For a quiet version (Outputs only if any problem found)
  *	5 * * * * root /usr/bin/lynx http://serveraddr/is_alive.php?quiet=true
  * 
  * More visually or to get informed by email set :
  * http://serveraddr/is_alive.php
  * 
  * 1. Test database server connection
  * 2. Test database selection
  * 3. Test HTTP Header response on main page
  * 4. Prints Nothing or REPONSE_CORRECTE if anything goes well, KO otherwise
  * also send a mail to an administrator (constant APPLICATION_MAINTAINER_EMAIL)
  
  * @param boolean $_GET["quiet"] : won't produce output
  * @package Automne
  * @subpackage tools
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// This page aims to check if website keeps alive
// A production purpose
//
// 
// 
// In a cron can use such script :
// For a quiet version (Outputs only if any problem found)
// */5 * * * * root /usr/bin/lynx http://serveraddr/is_alive.php?quiet=true
// 
// More visually or to get informed by email set :
// http://serveraddr/is_alive.php
//
// 1. Test database server connection
// 2. Test database selection
// 3. Test HTTP Header response on main page
// 4. Prints Nothing or REPONSE_CORRECTE if anything goes well, KO otherwise
// also send a mail to an administrator
// 

require_once(dirname(__FILE__).'/cms_rc_frontend.php');

// Page to test HTTP response of
define("INDEX_PAGE", PATH_REALROOT_WR.'/index.php');

// Stores errors found while running tests
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
	$headers = "From: ".APPLICATION_LABEL." <".APPLICATION_POSTMASTER_EMAIL.">\n";
	@mail($to, '[alert] Website '.APPLICATION_LABEL.'('.$_SERVER["SERVER_NAME"].') KO ?', $message, $headers);
	echo 'KO' ;
}
?>
