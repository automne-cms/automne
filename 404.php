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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: 404.php,v 1.10 2010/03/08 16:45:47 sebastien Exp $

/**
  * Automne 404 error handler
  * This file is used as 404 error document from .htaccess
  * 
  * @package Automne
  * @subpackage apache
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// *************************************************************************
// ** REDIRECTION HANDLER. KEEP ALL THIS PHP CODE IN 404 ERROR DOCUMENT ! **
// **     YOU CAN DEFINE YOUR OWN ERROR PAGE WITH THE FILE /404.html      **
// *************************************************************************
//disactive HTML compression
define("ENABLE_HTML_COMPRESSION", false);
require_once(dirname(__FILE__).'/cms_rc_frontend.php');
//parse requested URL to try to find a matching page
$redirectTo = '';
if ($_SERVER['REQUEST_URI'] && $_SERVER['REQUEST_URI'] != $_SERVER['SCRIPT_NAME']) {
	$pathinfo = pathinfo($_SERVER['REQUEST_URI']);
	$basename = (isset($pathinfo['filename'])) ? $pathinfo['filename'] : $pathinfo['basename'];
	//first try to get redirection rules from CSV file if exists
	if (file_exists(PATH_MAIN_FS.'/redirect/redirectRules.csv')) {
		$csvFile = new CMS_file(PATH_MAIN_FS.'/redirect/redirectRules.csv');
		$csvDatas = $csvFile->readContent('csv', 'trim', array('delimiter' => ';', 'enclosure' => '"', 'strict' => true));
		$rules = array();
		foreach ($csvDatas as $line => $csvData) {
			if (isset($csvData[0]) && $csvData[0] && isset($csvData[1]) && $csvData[1]) {
				$rules[$csvData[0]] = $csvData[1];
			}
		}
		if (isset($rules[$_SERVER['REQUEST_URI']]) && io::isPositiveInteger($rules[$_SERVER['REQUEST_URI']])) {
			$page = CMS_tree::getPageById($rules[$_SERVER['REQUEST_URI']]);
		} elseif (isset($rules[parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)]) && io::isPositiveInteger($rules[parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)])) {
			$page = CMS_tree::getPageById($rules[$_SERVER['REQUEST_URI']]);
		}
	}
	if (!isset($page)) { //get page from requested url
		$page = CMS_tree::analyseURL($_SERVER['REQUEST_URI'], false);
	}
	//get redirection URL for page
	if (isset($page) && is_object($page) && !$page->hasError()) {
		//get page file
		$pageURL = $page->getURL( (substr($basename,0,5) == 'print' ? true : false) , false, PATH_RELATIVETO_FILESYSTEM);
		if (file_exists($pageURL)) {
			$redirectTo = $page->getURL( (substr($basename,0,5) == 'print' ? true : false));
		} else {
			//try to regenerate page
			if ($page->regenerate(true)) {
				clearstatcache();
				if (file_exists($pageURL)) {
					$redirectTo = $page->getURL( (substr($basename,0,5) == 'print' ? true : false));
				}
			}
		}
	}
}
//do redirection to page if founded
if ($redirectTo) {
	CMS_view::redirect($redirectTo.(isset($_SERVER['REDIRECT_QUERY_STRING']) ? '?'.$_SERVER['REDIRECT_QUERY_STRING'] : ''), true, 301);
}
//then if no page founded, display 404 error page
header('HTTP/1.x 404 Not Found', true, 404);
//Check if requested file is an image
$imagesExtensions = array('jpg', 'jpeg', 'gif', 'png', 'ico');
if (isset($pathinfo['extension']) && in_array(strtolower($pathinfo['extension']), $imagesExtensions)) {
	if (file_exists(PATH_REALROOT_FS.'/img/404.png')) {
		CMS_file::downloadFile(PATH_REALROOT_FS.'/img/404.png');
	}
}
//send an email if needed
if (ERROR404_EMAIL_ALERT && sensitiveIO::isValidEmail(APPLICATION_MAINTAINER_EMAIL)) {
	$body ="A 404 Error occured on your website.\n";
	$body .="\n\n";
	$body .='The requested file : '.CMS_websitesCatalog::getMainURL().$_SERVER['REQUEST_URI'].' was not found.'."\n\n";
	$body .='From (Referer) : '.(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '')."\n\n";
	$body .='Date : '.date('r')."\n\n";
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$body .='User : '.$_SERVER['REMOTE_ADDR'].' ('.$_SERVER['HTTP_ACCEPT_LANGUAGE'].')'."\n\n";
	} else {
		$body .='User : '.$_SERVER['REMOTE_ADDR']."\n\n";
	}
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$body .='Browser : '.$_SERVER['HTTP_USER_AGENT']."\n\n";
	}
	$body .='Host : '.$_SERVER['HTTP_HOST'].' ('.$_SERVER['SERVER_ADDR'].")\n\n";
	$body .='This email is automaticaly sent from your website. You can stop this sending with the parameter ERROR404 EMAIL ALERT.';
	
	$mail= new CMS_email();
	$mail->setSubject("404 Error in ".APPLICATION_LABEL);
	$mail->setBody($body);
	$mail->setEmailFrom(APPLICATION_POSTMASTER_EMAIL."<".APPLICATION_POSTMASTER_EMAIL.">");
	$mail->setEmailTo(APPLICATION_MAINTAINER_EMAIL);
	
	$mainURL = CMS_websitesCatalog::getMainURL();
	$cms_language = CMS_languagesCatalog::getByCode('en');
	$mail->setFooter($cms_language->getMessage(CMS_emailsCatalog::MESSAGE_EMAIL_BODY_URLS, array(APPLICATION_LABEL, $mainURL."/", $mainURL.PATH_ADMIN_WR."/")));
	$mail->setTemplate(PATH_MAIL_TEMPLATES_FS);
	
	$mail->sendEmail();
}

//try to get website by domain to serve specific 404 page
$domain = @parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST) ? @parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST) : (@parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ? @parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) : $_SERVER['HTTP_HOST']);
if ($domain) {
	$website = CMS_websitesCatalog::getWebsiteFromDomain($domain);
	if ($website && !$website->hasError()) {
		//check if website has a 404 page defined
		$page404 = $website->get404();
		if ($page404) {
			$pPath = $page404->getHTMLURL(false, false, PATH_RELATIVETO_FILESYSTEM);
			if ($pPath) {
				if (file_exists($pPath)) {
					$cms_page_included = true;
					require($pPath);
					exit;
				} elseif ($page404->regenerate(true)) {
					clearstatcache ();
					if (file_exists($pPath)) {
						$cms_page_included = true;
						require($pPath);
						exit;
					}
				}
			}
		}
	}
}
//check for an alternative 404 file and display it if any
if (file_exists(PATH_REALROOT_FS.'/404.html')) {
	readfile(PATH_REALROOT_FS.'/404.html');
	exit;
}
//or display default Automne 404 page ...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>404 Not Found ...</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo APPLICATION_DEFAULT_ENCODING; ?>" />
	<meta name="robots" content="noindex, noarchive" /> 
	<style type="text/css">
	body {
		background-color: 		#E9F1DA;
		margin:					0;
		font:					13px/1.231 arial,helvetica,clean,sans-serif;
	}
	#message {
		font-size:				123.1%;
		width:					500px;
		margin:					20px auto 0 auto;
		display: 				block;
		padding:				10px;
		text-align:				center;
		background:				#FFF url(<?php echo PATH_REALROOT_WR; ?>/img/atm-logo.gif) 480px 7px no-repeat;
		border-radius: 			10px;
		-moz-border-radius:		10px;
		-webkit-border-radius:	10px;
		box-shadow:				3px 3px 5px #888;
		-moz-box-shadow:		3px 3px 5px #888;
		-webkit-box-shadow:		3px 3px 5px #888;
	}
	hr {
		border:					0px solid white;
		border-bottom:			1px solid #DDE6CB;
	}
	h1 {
		font-size:				123.1%;
		margin:					4px 0;
	}
	a, a:link {
		color:					#5F900B;
	}
	</style>
</head>
<body>
<div id="message">
<h1>Error 404...</h1>
Sorry, the requested page was not found.<br /><br />
<a href="<?php echo PATH_REALROOT_WR; ?>/">Back to the Home Page</a><br /><br />
<hr />
<h1>Erreur 404 ...</h1>
Nous ne trouvons pas la page que vous demandez.<br /><br />
<a href="<?php echo PATH_REALROOT_WR; ?>/">Retour &agrave; l'accueil</a><br /><br />
</div>
</body>
</html>