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
// $Id: server.php,v 1.4 2009/03/02 11:25:15 sebastien Exp $

/**
  * PHP page : Load server detail window.
  * Used accross an Ajax request. Render server informations.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$winId = sensitiveIO::request('winId', '', 'serverWindow');

define("MESSAGE_TOOLBAR_HELP",1073);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) { //templates
	CMS_grandFather::raiseError('User has no administration rights');
	$view->setActionMessage('Vous n\'avez pas les droits d\'administrateur ...');
	$view->show();
}

//Test all PHP requirements

//Test PHP version
$content = '
<h1>Test des paramètres du serveur nécessaires au fonctionnement d\'Automne :</h1>
<ul class="atm-server">';
if (version_compare(PHP_VERSION, "5.2.0") === -1) {
	$content .= '<li class="atm-pic-cancel">Error, PHP version ('.PHP_VERSION.') not match</li>';
} else {
	$content .= '<li class="atm-pic-ok">PHP version OK ('.PHP_VERSION.')</li>';
}
//GD
if (!function_exists('imagecreatefromgif') || !function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
	$content .= '<li class="atm-pic-cancel">Error, GD extension not installed</li>';
} else {
	$content .= '<li class="atm-pic-ok">GD extension OK</li>';
}
//MySQL
if (!class_exists('PDO')) {
	$content .= '<li class="atm-pic-cancel">Error, PDO extension not installed</li>';
} else {
	$q = new CMS_query('SELECT VERSION() as v;');
	if ($q->hasError()) {
		$content .= '<li class="atm-pic-cancel">Error, MySQL connection error. Please check /config.php file for correct connection informations.</li>';
	} else {
		$version = $q->getValue('v');
		if (version_compare($version, '5.0.0') === -1) {
			$content .= '<li class="atm-pic-cancel">Error, MySQL version ('.$version.') not match (5.0.0 minimum)</li>';
		} else {
			$content .= '<li class="atm-pic-ok">MySQL connection and version OK ('.$version.')</li>';
		}
	}
}
//LDAP
if (!defined('APPLICATION_LDAP_AUTH') || (defined('APPLICATION_LDAP_AUTH') && APPLICATION_LDAP_AUTH)) {
	if (!function_exists('ldap_bind')) {
		$content .= '<li class="atm-pic-cancel">Error, LDAP extension not installed (only needed if LDAP authentification is used)</li>';
	} else {
		$content .= '<li class="atm-pic-ok">LDAP extension OK</li>';
	}
}
//XAPIAN
if (class_exists('CMS_module_ase')) {
	$xapianVersion = '';
	if (function_exists('xapian_version_string')) {
		$xapianVersion = xapian_version_string();
	} elseif (class_exists('Xapian')) {
		$xapianVersion = Xapian::version_string();
	} else {
		$content .= '<li class="atm-pic-cancel">Error, Xapian extension not installed (only needed if ASE module is installed)</li>';
	}
	if ($xapianVersion) {
		if (version_compare($xapianVersion, '1.0.2') === -1) {
			$content .= '<li class="atm-pic-cancel">Error, Xapian version ('.$xapianVersion.') not match (1.0.2 minimum)</li>';
		} else {
			$content .= '<li class="atm-pic-ok">Xapian extension OK ('.$xapianVersion.')</li>';
		}
	}
}
//Files writing
$randomFile = realpath($_SERVER['DOCUMENT_ROOT']).'/test_'.md5(mt_rand().microtime()).'.tmp';
if (!is_writable(realpath($_SERVER['DOCUMENT_ROOT']))) {
	$content .= '<li class="atm-pic-cancel">Error, No permissions to write files on website root directory ('.realpath($_SERVER['DOCUMENT_ROOT']).')</li>';
} else {
	$content .= '<li class="atm-pic-ok">Website root filesystem permissions are OK</li>';
}
//Email
if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
	$content .= '<li class="atm-pic-cancel">Error, No SMTP server founded</li>';
} else {
	$content .= '<li class="atm-pic-ok">SMTP server OK</li>';
}
//Memory
ini_set('memory_limit', "32M");
if (ini_get('memory_limit') && ini_get('memory_limit') < 32) {
	$content .= '<li class="atm-pic-cancel">Error, Cannot upgrade memory limit to 32M. Memory detected : '.ini_get('memory_limit')."\n";
} else {
	$content .= '<li class="atm-pic-ok">Memory limit OK</li>';
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
		$content .= '<li class="atm-pic-cancel">Error when finding php CLI with command "which php" : '.$error."\n";
	}
	if ($return === false) {
		$content .= '<li class="atm-pic-cancel">Error, passthru() and exec() commands not available</li>';
	} elseif (substr($return,0,1) != '/') {
		$content .= '<li class="atm-pic-cancel">Error when finding php CLI with command "which php"</li>';
	}
	//test CLI version
	$return = executeCommand('php -v',$error);
	if (strpos(strtolower($return), '(cli)') === false) {
		$content .= '<li class="atm-pic-cancel">Error, installed php is not the CLI version : '.$return."\n";
	} else {
		$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
		if (version_compare($cliversion, "5.2.0") === -1) {
			$content .= '<li class="atm-pic-cancel">Error, PHP CLI version ('.$cliversion.') not match</li>';
		} else {
			$content .= '<li class="atm-pic-ok">PHP CLI version OK ('.$cliversion.')</li>';
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
	$content .= '<li class="atm-pic-cancel">Error, PHP magic_quotes_gpc is active and cannot be changed</li>';
}
if (ini_get('magic_quotes_runtime') != 0) {
	$content .= '<li class="atm-pic-cancel">Error, PHP magic_quotes_runtime is active and cannot be changed</li>';
}
if (ini_get('magic_quotes_sybase') != 0) {
	$content .= '<li class="atm-pic-cancel">Error, PHP magic_quotes_sybase is active and cannot be changed</li>';
}
if (ini_get('register_globals') != 0) {
	$content .= '<li class="atm-pic-cancel">Error, PHP register_globals is active and cannot be changed</li>';
}

$content .='</ul>';

$content = sensitiveIO::sanitizeJSString($content);

//Files tab
$filescontent = '
<h1>Vérifier les droits d\'accès aux fichiers :</h1>
	<h2>Pour Automne : </h2>
	Permet de valider qu\'Automne possède bien les droits nécessaire sur l\'ensemble des fichiers du site.<br /><br />
	<div id="launchFilesCheck"></div><br />
	<div id="filesCheckProgress"></div><br />
	<div id="filesCheckDetail"></div>
	<br />
	<h2>Pour les utilisateurs : </h2>
	Permet de valider que les utilisateurs et internautes possèdent bien les droits nécessaire sur l\'ensemble des fichiers du site.<br /><br />
	<div id="launchHtaccessCheck"></div><br />
	<div id="htaccessCheckProgress"></div><br />
	<div id="htaccessCheckDetail"></div>
';
$filescontent = sensitiveIO::sanitizeJSString($filescontent);

$jscontent = <<<END
	var serverWindow = Ext.getCmp('{$winId}');
	//set window title
	serverWindow.setTitle('Paramètres du serveur');
	//set help button on top of page
	serverWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 serverWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 'Cette page vous permet de voir l\'état des différents paramètres du serveur nécessaire à l\'éxécution d\'Automne.',
		dismissDelay:	0
	});
	
	//create files objects
	var progressFiles = new Ext.ProgressBar({
		id:				'filesCheckProgressBar'
    });
	var progressHtaccess = new Ext.ProgressBar({
		id:				'htaccessCheckProgressBar'
    });
	var launchFilesCheck = new Ext.Button({
		id:				'launchFilesCheck',
		text:			'Vérifier',
		listeners:		{'click':function(){
			launchFilesCheck.disable();
	        progressFiles.wait({
	            interval:	200,
	            increment:	15,
				text:		'En cours ...'
	        });
			Automne.server.call({
				url:				'server-check.php',
				params: 			{
					action:				'check-files'
				},
				fcnCallback: 		function(response, options, content) {
					if (!filesCheckDetail.rendered) {
						filesCheckDetail.render('filesCheckDetail');
					}
					Ext.get('filesCheckDetailText').dom.innerHTML = content;
					progressFiles.updateText('').reset();
					launchFilesCheck.enable();
				},
				callBackScope:		this
			});
		},scope:this}
    });
	var launchHtaccessCheck = new Ext.Button({
		id:				'launchHtaccessCheck',
		text:			'Vérifier',
		listeners:		{'click':function(){
			launchHtaccessCheck.disable();
	        progressHtaccess.wait({
	            interval:	200,
	            increment:	15,
				text:		'En cours ...'
	        });
			Automne.server.call({
				url:				'server-check.php',
				params: 			{
					action:				'check-htaccess'
				},
				fcnCallback: 		function(response, options, content) {
					if (!htaccessCheckDetail.rendered) {
						htaccessCheckDetail.render('htaccessCheckDetail');
					}
					Ext.get('htaccessCheckDetailText').dom.innerHTML = content;
					progressHtaccess.updateText('').reset();
					launchHtaccessCheck.enable();
				},
				callBackScope:		this
			});
		},scope:this}
    });
	var filesCheckDetail = new Ext.form.FieldSet({
		title:			'Détails',
		collapsible:	true,
		collapsed:		false,
		height:			220,
		autoScroll:		true,
		html:			'<div id="filesCheckDetailText"></div>'
	});
	var htaccessCheckDetail = new Ext.form.FieldSet({
		title:			'Détails',
		collapsible:	true,
		collapsed:		false,
		height:			220,
		autoScroll:		true,
		html:			'<div id="htaccessCheckDetailText"></div>'
	});
	
	//create center panel
	var center = new Ext.TabPanel({
		activeTab:			 0,
		id:					'serverPanels',
		region:				'center',
		border:				false,
		enableTabScroll:	true,
		listeners: {
			'beforetabchange' : function(tabPanel, newTab, currentTab ) {
				if (newTab.beforeActivate) {
					newTab.beforeActivate(tabPanel, newTab, currentTab);
				}
				return true;
			},
			'tabchange': function(tabPanel, newTab) {
				if (newTab.afterActivate) {
					newTab.afterActivate(tabPanel, newTab);
				}
			}
		},
		items:[{
			id:					'serverDatas',
			title:				'Paramètres serveur',
			autoScroll:			true,
			border:				false,
			bodyStyle: 			'padding:5px',
			html: 				'$content'
		},{
			id:					'serverFiles',
			title:				'Accès aux fichiers',
			autoScroll:			true,
			border:				false,
			bodyStyle: 			'padding:5px',
			html:				'$filescontent',
			listeners:			{'activate':function(){
				if (!progressFiles.rendered) {
					progressFiles.render('filesCheckProgress');
				}
				if (!launchFilesCheck.rendered) {
					launchFilesCheck.render('launchFilesCheck');
				}
				if (!progressHtaccess.rendered) {
					progressHtaccess.render('htaccessCheckProgress');
				}
				if (!launchHtaccessCheck.rendered) {
					launchHtaccessCheck.render('launchHtaccessCheck');
				}
			}, scope:this}
		},{
			xtype:				'framePanel',
			title:				'Informations PHP',
			id:					'phpDatas',
			frameURL:			'/automne/admin/phpinfo.php',
			allowFrameNav:		true
		}]
	});
	
	serverWindow.add(center);
	//redo windows layout
	serverWindow.doLayout();
	//center.syncSize();
END;
$view->addJavascript($jscontent);
$view->show();
?>