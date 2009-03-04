<?php //Generated on Wed, 04 Mar 2009 11:06:51 +0100 by Automne (TM) 4.0.0b1
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://automne4/web/fr/print-3-presentation.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Automne 4 : Présentation</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Présentation</h1>
<h3>

		

&raquo;


&nbsp;

Présentation
		
</h3>


<h2>Préviz avant validation</h2>


	
	

	
	
		<div class="text"><p style="text-align: left;">Dans cette page, il faut pr&eacute;senter le CMS. Quels sont ces cas d'utilisations les plus adapt&eacute;s (Sites institutionnels multilangues, intranet, extranet, etc.) et ses forces (modulaire, simple d'usage, solide, perenne, resistant &agrave; la charge, etc.).</p></div>
	


<br />
<hr />
<div align="center">
	<small>
		Dernière mise à jour le 27/02/2009<br />
		
				Page  "Présentation" (http://automne4/web/fr/3-presentation.php)
				<br />
		Tiré du site http://<?php echo $_SERVER["HTTP_HOST"];   ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>