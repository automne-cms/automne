<?php //Generated on Mon, 09 Feb 2009 12:09:30 +0100 by Automne (TM) 4.0.0a3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/fr/print-16-fonctions-annexes.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Automne 4 : Fonctions annexes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Fonctions annexes</h1>
<h3>

		

&raquo;


&nbsp;

Fonctionnalités
		

		

&raquo;


&nbsp;

Fonctions annexes
		


</h3>



	
	
		<div class="text"><p>Dans cette page doit se trouver des explications sur :</p> <ul>     <li>Gestion Multi-sites</li>     <li>S&eacute;curiser l'acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</li>     <li>Connexion LDAP</li>     <li>SSO (single Sign On)</li> </ul></div>
	
<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Fonctions annexes" (http://127.0.0.1/web/fr/16-fonctions-annexes.php)
				

<br />
		Tiré du site http://<?php echo $_SERVER["HTTP_HOST"];   ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>