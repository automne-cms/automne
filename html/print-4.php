<?php //Generated on Tue, 25 Nov 2008 16:53:31 +0100 by Automne (TM) 4.0.0a
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://automne4/web/fr/print-4-fonctionnalites.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Automne 4 : Fonctionnalités</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Fonctionnalités</h1>
<h3>

		
&raquo;
&nbsp;
Fonctionnalités
		

</h3>



	
	
		<div class="text"><p>Cette page doit d&eacute;crire bri&egrave;vement les grands principes d'utilisattion du CMS et renvoyer vers les sous pages d&eacute;taillant cette utilisation.</p></div>
	
	<div class="spacer"></div>
<br />
<hr />
<div align="center">
	<small>
		Dernière mise à jour le 14/11/2008<br />
		
				Page  "Fonctionnalités" (http://automne4/web/fr/4-fonctionnalites.php)
				
<br />
		Tiré du site http://<?php echo $_SERVER["HTTP_HOST"];   ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat(); if (VIEW_SQL && isset($_SESSION["cms_context"]) && is_object($_SESSION["cms_context"])) {save_stat();}}  ?>
</body>
</html>