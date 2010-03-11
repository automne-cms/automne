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
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  */

// *************************************************************************
// ** REDIRECTION HANDLER. KEEP ALL THIS PHP CODE IN 403 ERROR DOCUMENT ! **
// **     YOU CAN DEFINE YOUR OWN ERROR PAGE WITH THE FILE /403.html      **
// *************************************************************************

require_once(dirname(__FILE__).'/cms_rc_frontend.php');

//check for alternative 403 file and display it if any
if (file_exists(PATH_REALROOT_FS.'/403.html')) {
	readfile(PATH_REALROOT_FS.'/403.html');
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
	<style type="text/css">
	body {
		background-color: #FFFFFF;
		margin:			0;
		font:			normal 12px Verdana,Arial,Helvetica,sans-serif;
	}
	#message {
		width:			300px;
		margin:			0 auto 0 auto;
		display: 		block;
		padding:		20px;
		border:			1px solid red;
		text-align:		center;
		background:		url(<?php echo PATH_REALROOT_WR; ?>/automne/admin/img/logo_small.gif) top right no-repeat;
	}
	hr {
		border:			0px solid white;
		border-bottom:	1px solid red;
	}
	</style>
</head>
<body>
<br /><br />
<div id="message">
403 Forbidden<br />
You do not have sufficient privileges to view this page ...<br /><br />
<a href="/">Back to the Home Page</a><br /><br />
<hr />
403 Acc&egrave;s interdit.<br />
Vous n'avez pas les droits d'acc&egrave;s suffisants pour voir cette page ...<br /><br />
<a href="/">Retour &agrave; l'accueil</a><br /><br />
</div>
</body>
</html>
