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
// $Id: 403.php,v 1.4 2010/03/08 16:45:47 sebastien Exp $

/**
  * Automne 403 error handler
  * This file is used as 403 error document from .htaccess
  * @package Automne
  * @subpackage apache
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

// *************************************************************************
// ** REDIRECTION HANDLER. KEEP ALL THIS PHP CODE IN 403 ERROR DOCUMENT ! **
// **     YOU CAN DEFINE YOUR OWN ERROR PAGE WITH THE FILE /403.html      **
// *************************************************************************

//check for alternative 403 file and display it if any
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/403.html')) {
	readfile($_SERVER['DOCUMENT_ROOT'].'/403.html');
	exit;
}
//or display default Automne 403 page ...
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Forbidden</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo APPLICATION_DEFAULT_ENCODING; ?>" />
	<meta name="robots" content="noindex" />
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
		background:				#FFF url(/img/atm-logo.gif) 480px 7px no-repeat;
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
<h1>403 Forbidden</h1>
You do not have sufficient privileges to view this page ...<br /><br />
<a href="/">Back to the Home Page</a><br /><br />
<hr />
<h1>403 Acc&egrave;s interdit.</h1>
Vous n'avez pas le droit de voir cette page ...<br /><br />
<a href="/">Retour &agrave; l'accueil</a><br /><br />
</div>
</body>
</html>
