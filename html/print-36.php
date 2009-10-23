<?php header('HTTP/1.x 302 Found',true,302);
header("Location: http://127.0.0.1/web/fr/9-contact.php");
exit;
 ?><?php //Generated on Fri, 23 Oct 2009 12:21:57 +0200 by Automne (TM) 4.0.0rc3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/fr/print-36-formulaire.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne-Démo-UTF8 : Formulaire</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Formulaire</h1>
<h3>

		&raquo;&nbsp;

Exemples de modules
		
		&raquo;&nbsp;

Formulaire
		
</h3>



	
	

	
	


<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Formulaire" (http://127.0.0.1/web/fr/36-formulaire.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>