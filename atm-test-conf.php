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
// $Id: atm-test-conf.php,v 1.6 2009/11/24 15:04:24 sebastien Exp $

/**
  * PHP page : Test all Automne v4 requirements
  * 
  * @package CMS
  * @subpackage installation
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author Antoine Cézar <antoine.cezar@ws-interactive.fr>
  */

//Test all PHP requirements
if (!isset($_GET['file'])) {
	//Test PHP version
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Test file for Automne version 4.</title>
		<style type="text/css">
			body{
				background-color:	#e9f1da;
				font-family:		arial,verdana,helvetica,sans-serif;
				font-size:			12px;
				margin:				0;
				padding:			0;
			}
			.error {
				color:				red;
				font-weight:		bold;
			}
			a{
				text-decoration:	none;
				color:				#5f900b;
			}
			#main{
				width:				639px;
				margin:				auto;
			}
			#content{
				background:			url('.$_SERVER['SCRIPT_NAME'].'?file=logo) no-repeat 75px 0;
				margin:				auto;
				background-color:	#ffffff;
				width:				639px;
				border-left:		1px solid #dde6cb;
				border-right:		1px solid #dde6cb;
				border-bottom:		1px solid #dde6cb;
				color:				#5d5856;
				padding-top:		118px;
				padding-bottom:		30px;
				min-height:			300px;
			}
			#text {
				padding-left:		35px;
				padding-right:		15px;
			}
			h1{
				background:			url('.$_SERVER['SCRIPT_NAME'].'?file=picto) no-repeat 0 5px;
				font-size:			16px;
				color:				#8cbe35;
				padding-left:		21px;
				margin-bottom:		20px;
			}
			#footer{
				color:				#5a6266;
				height:				60px;
				width:				639px;
				margin:				auto;
				padding-top:		8px;
				text-align:			center;
				font-size:			11px;
			}
			.license,
			.htaccess,
			.extraction {
				width:				100%;
				height:				250px;
				overflow:			auto;
				padding:			5px 5px 5px 0;
				margin:				10px 10px 10px 0;
				background-color:	#EFF8CF;
			}
			.dbinfos{
				text-align:			right;
			}
			.dbinfos label {
				width:				400px;
				display:			block;
			}
			input.submit {
				cursor: 			pointer;
				border: 			0px;
				padding: 			2px;
				color:				#FFFFFF;
				height: 			20px;
				background-color:	#ABD64A;
				background-position:top-left;
				background-repeat: 	no-repeat;
				float:				right;
			}
			ul.atm-server {
				padding:			10px 0 0 0;
				margin:				0;
				list-style-image:	none;
				list-style-position:outside;
				list-style-type:	none;
			}
			ul.atm-server li {
				background-repeat:	no-repeat;
			    padding:			2px 0 6px 20px;
			}
			.atm-pic-ok {
				background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
				background-position:0px -100px;
			}
			.atm-pic-cancel{
				background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
				background-position:0px -124px;
			}
			.atm-pic-question{
				background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
				background-position:0px -77px;
			}
		</style>
	</head>
	<body>
		<div id="main">
			<div id="content">
				<div id="text">
					<h1>This file test all needed parameters to run Automne V4.</h1>
						<ul class="atm-server">';
	if (version_compare(PHP_VERSION, "5.2.0") === -1) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP version ('.PHP_VERSION.') not match</li>';
	} else {
		$content .= '<li class="atm-pic-ok">PHP version <strong style="color:green">OK</strong> ('.PHP_VERSION.')</li>';
	}
	//GD
	if (!function_exists('imagecreatefromgif') || !function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, GD extension not installed</li>';
	} else {
		$content .= '<li class="atm-pic-ok">GD extension <strong style="color:green">OK</strong></li>';
	}
	//MySQL
	if (!class_exists('PDO')) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PDO extension not installed</li>';
	} else{
		$content .= '<li class="atm-pic-ok">PDO extension <strong style="color:green">OK</strong></li>';
	    $pdo_drivers = PDO::getAvailableDrivers();
	    if(!in_array('mysql', $pdo_drivers)){
	        $content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PDO MySQL driver not installed</li>';
	    }
	    else{
	        $content .= '<li class="atm-pic-ok">PDO MySQL driver <strong style="color:green">OK</strong></li>';
	        //Connection Data
	        $connection = array();
	        $connection['host']   = (isset($_POST['host']))   ? $_POST['host']   : 'localhost' ;
	        $connection['user']   = (isset($_POST['user']))   ? $_POST['user']   : '' ;
	        $connection['pass']   = (isset($_POST['pass']))   ? $_POST['pass']   : '' ;
	        $connection['dbname'] = (isset($_POST['dbname'])) ? $_POST['dbname'] : '' ;
	        //Connection Test
	        $connection_is_ok = false;
	        if($connection['user']   != ''
	        && $connection['dbname'] != ''
	        ){
	            $dsn = 'mysql:host='.$connection['host'].';dbname='.$connection['dbname'];
				try {
					$db = new PDO($dsn, $connection['user'], $connection['pass'],
	                              array(PDO::ATTR_PERSISTENT => APPLICATION_DB_PERSISTENT_CONNNECTION,
	                                    PDO::ERRMODE_EXCEPTION => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	                //MySQL Version
					$result = $db->query('SELECT VERSION() as v;');
	                if(is_object($result)){
	                    $version = ($arr = $result->fetch(PDO::FETCH_BOTH)) ?  $arr['v'] : false;
	                    if($version !== false){
	                        if (version_compare($version, '5.0.0') === -1) {
	                            $content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, MySQL version ('.$version.') not match (5.0.0 minimum)</li>';
	                        } else {
	                            $content .= '<li class="atm-pic-ok">MySQL connection and version <strong style="color:green">OK</strong> ('.$version.')</li>';
	                            $connection_is_ok = true;
	                        }
	                    }
	                    else{
	                        $content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, Can not retrieve MySQL version</li>';
	                    }
	                }
				} catch (PDOException $e) {
	                $content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, MySQL connection error. Please check connection informations.</li>';
					$content .= '<pre>'.$e->getMessage().'</pre>';
				}
	        }
	        //Connection Form
	        if(!$connection_is_ok){
	            $content .= '
	                <fieldset>
						<legend>Test database connexion</legend>
						<form method="post">
		                    <p>
		                        <label>Host</label>
		                        <input type="text" name="host" value="'.$connection['host'].'" />
		                    </p>
		                    <p>
		                        <label>User</label>
		                        <input type="text" name="user" value="'.$connection['user'].'" />
		                    </p>
		                    <p>
		                        <label>Password</label>
		                        <input type="text" name="pass" value="'.$connection['pass'].'" />
		                    </p>
		                    <p>
		                        <label>Database Name</label>
		                        <input type="text" name="dbname" value="'.$connection['dbname'].'"" />
		                    </p>
		                    <p><input type="submit" class="submit" value="Test Connexion" /></p>
		                </form>
					</fieldset>
	            ';
	        }
	    }
	}
	//MBSTRING
	if (!function_exists('mb_substr') || !function_exists('mb_convert_encoding')) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, Multibyte String (mbsring) extension is not installed.</li>';
	} else {
		$content .= '<li class="atm-pic-ok">Multibyte String (mbsring) extension <strong style="color:green">OK</strong></li>';
	}
	//LDAP
	if (!function_exists('ldap_bind')) {
	    $content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, LDAP extension not installed <strong>(only needed if LDAP authentification is used)</strong></li>';
	} else {
	    $content .= '<li class="atm-pic-ok">LDAP extension <strong style="color:green">OK</strong></li>';
	}
	//XAPIAN
	$xapianVersion = '';
	if (function_exists('version_string')) {
		$xapianVersion = version_string();
		if (version_compare($xapianVersion, '1.0.2') === -1) {
			$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, Xapian version ('.$xapianVersion.') not match (1.0.2 minimum)</li>';
		} else {
			$content .= '<li class="atm-pic-ok">Xapian extension <strong style="color:green">OK</strong> ('.$xapianVersion.')</li>';
		}
	} else {
		$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, Xapian extension not installed <strong>(only needed if ASE module is installed)</strong></li>';
	}
	//Files writing
	if (!is_writable(realpath($_SERVER['DOCUMENT_ROOT']))) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, No permissions to write files on website root directory ('.realpath($_SERVER['DOCUMENT_ROOT']).')</li>';
	} else {
		$content .= '<li class="atm-pic-ok">Website root filesystem permissions are <strong style="color:green">OK</strong></li>';
	}
	//Email
	if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, No SMTP server founded</li>';
	} else {
		$content .= '<li class="atm-pic-ok">SMTP server <strong style="color:green">OK</strong></li>';
	}
	//Memory
	ini_set('memory_limit', "64M");
	if (ini_get('memory_limit') && ini_get('memory_limit') < 64) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, Cannot upgrade memory limit to 64M. Memory detected : '.ini_get('memory_limit')."\n";
	} else {
		$content .= '<li class="atm-pic-ok">Memory limit <strong style="color:green">OK</strong></li>';
	}
	//CLI
	if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
		$content .= '<li class="atm-pic-question">Cannot test CLI on Windows Platform ...</li>';
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
			$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong> when finding php CLI with command "which php" : '.$error."\n";
		}
		if ($return === false) {
			$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, passthru() and exec() commands not available</li>';
		} elseif (substr($return,0,1) != '/') {
			$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong> when finding php CLI with command "which php"</li>';
		}
		//test CLI version
		$return = executeCommand('php -v',$error);
		if (strpos(strtolower($return), '(cli)') === false) {
			$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, installed php is not the CLI version : '.$return."\n";
		} else {
			$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
			if (version_compare($cliversion, "5.2.0") === -1) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP CLI version ('.$cliversion.') not match</li>';
			} else {
				$content .= '<li class="atm-pic-ok">PHP CLI version <strong style="color:green">OK</strong> ('.$cliversion.')</li>';
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
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP magic_quotes_gpc is active and cannot be changed</li>';
	}
	if (ini_get('magic_quotes_runtime') != 0) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP magic_quotes_runtime is active and cannot be changed</li>';
	}
	if (ini_get('magic_quotes_sybase') != 0) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP magic_quotes_sybase is active and cannot be changed</li>';
	}
	if (ini_get('register_globals') != 0) {
		$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP register_globals is active and cannot be changed</li>';
	}
	
	$content .='</ul>
				</div>
			</div>
			<div id="footer">Test file for Automne version 4. For more informations, visit <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.</div>
		</div>
	</body>
	</html>';
	
	echo $content;
	exit;
} else {
	// +----------------------------------------------------------------------+
	// | Installation Binary files           		                          |
	// +----------------------------------------------------------------------+
	switch($_GET['file']) {
		case 'logo':
			$file = base64_decode('
				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');
			header('Content-Type: image/jpg');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
		case 'picto':
			$file = base64_decode('
				R0lGODlhDQAJAIAAAP///2aZACH5BAAAAAAALAAAAAANAAkAAAIRDIwHy+2bonpUSVnbtfltwxQA
				Ow==');
			header('Content-Type: image/gif');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
		case 'pictos':
			$file = base64_decode('
				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
				drk6CAAAAABJRU5ErkJggg==');
			header('Content-Type: image/png');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
	}
}
?>