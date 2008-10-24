<pre>
Test file for Automne 3.3.X compatibility.
Use it at WebServer root.
------------------------------------------
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2008 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// | The license text is bundled with this package in the file            |
// | LICENSE-GPL, and is available at through the world-wide-web at       |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: atm-test-conf.php,v 1.2 2008/10/24 12:19:52 sebastien Exp $

/**
  * Automne 3.3.X Serveurs configuration Tests
  *
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Test PHP version
if (version_compare(phpversion(), "5.0.0", ">=") || version_compare(phpversion(), "4.3.8", "<")) {
	echo 'Error, PHP version ('.phpversion().') not match'."\n";
} else {
	echo 'PHP version OK ('.phpversion().')'."\n";
}
//GD
if (!function_exists('imagecreatefromgif') || !function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
	echo 'Error, GD extension not installed'."\n";
} else {
	echo 'GD extension OK'."\n";
}
//LDAP
if (!function_exists('ldap_bind')) {
	echo 'Error, LDAP extension not installed (may be not needed ...)'."\n";
} else {
	echo 'LDAP extension OK'."\n";
}
//XAPIAN
$xapianVersion = '';
if (function_exists('xapian_version_string')) {
	$xapianVersion = xapian_version_string();
} elseif (class_exists('Xapian')) {
	$xapianVersion = Xapian::version_string();
} else {
	echo 'Error, Xapian extension not installed (may be not needed ...)'."\n";
}
if ($xapianVersion) {
	if (version_compare($xapianVersion, '1.0.2' , '<' )) {
		echo 'Error, Xapian version ('.$xapianVersion.') not match (1.0.2 minimum)'."\n";
	} else {
		echo 'Xapian extension OK ('.$xapianVersion.')'."\n";
	}
}
//MySQL
if (!function_exists('mysql_connect')) {
	echo 'Error, MySQL extension not installed'."\n";
} else {
	echo 'MySQL extension OK (please check version manually : 4.0.0 minimumm)'."\n";
}
//Files writing
$randomFile = dirname(__FILE__).'/test_'.md5(mt_rand().microtime()).'.tmp';
if (!@touch($randomFile) || !file_exists($randomFile)) {
	echo 'Error, No permissions to write files on this directory'."\n";
} else {
	if (!@unlink($randomFile)) {
		echo 'Error, No permissions to delete file on this directory ('.$randomFile.')'."\n";
	} else {
		echo 'Filesystem permissions OK'."\n";
	}
}
//Email
if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
	echo 'Error, No SMTP server founded'."\n";
} else {
	echo 'SMTP server OK'."\n";
}
//Memory
ini_set('memory_limit', "32M");
if (ini_get('memory_limit') && ini_get('memory_limit') < 32) {
	echo 'Error, Cannot upgrade memory limit to 32M. Memory detected : '.ini_get('memory_limit')."\n";
} else {
	echo 'Memory limit OK'."\n";
}
//CLI
if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
	echo 'Cannot test CLI on Windows Platform ...'."\n";
} else {
	function executeCommand($command, &$error) {
		//change current dir
		$pwd = getcwd();
		if (function_exists("exec")) {
			//execute command
			@exec($command, $return , $error );
			$return = implode("\n",$return);
		} elseif (function_exists("passthru")) {
			//execute command
			@ob_start();
			@passthru ($command, $error);
			$return = @ob_get_contents();
			@ob_end_clean();
		} else {
			$error=1;
			return false;
		}
		//restore original dir
		@chdir($pwd);
		return $return;
	}
	$error = '';
	$return = executeCommand('which php 2>&1',$error);
	if ($error && $return !== false) {
		echo 'Error when finding php CLI with command "which php" : '.$error."\n";
	}
	if ($return === false) {
		echo 'Error, passthru() and exec() commands not available'."\n";
	} elseif (substr($return,0,1) != '/') {
		echo 'Error when finding php CLI with command "which php"'."\n";
	}
	//test CLI version
	$return = executeCommand('php -v',$error);
	if (strpos(strtolower($return), '(cli)') === false) {
		echo 'Error, installed php is not the CLI version : '."\n".$return."\n";
	} else {
		$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
		if (version_compare($cliversion, "5.0.0", ">=") || version_compare($cliversion, "4.3.8", "<")) {
			echo 'Error, PHP CLI version ('.$cliversion.') not match'."\n";
		} else {
			echo 'PHP CLI version OK ('.$cliversion.')'."\n";
		}
	}
}

//Conf PHP

//try to change some misconfigurations
@ini_set('magic_quotes_gpc', 0);
@ini_set('magic_quotes_runtime', 0);
@ini_set('magic_quotes_sybase', 0);
@ini_set('session.use_trans_sid', 0);
if (ini_get('magic_quotes_gpc') != 0) {
	echo 'Error, PHP magic_quotes_gpc cannot be changed and has not the right value'."\n";
}
if (ini_get('magic_quotes_runtime') != 0) {
	echo 'Error, PHP magic_quotes_runtime cannot be changed and has not the right value'."\n";
}
if (ini_get('magic_quotes_sybase') != 0) {
	echo 'Error, PHP magic_quotes_sybase cannot be changed and has not the right value'."\n";
}
if (ini_get('session.use_trans_sid') != 0) {
	echo 'Error, PHP session.use_trans_sid cannot be changed and has not the right value'."\n";
}
?>
</pre>