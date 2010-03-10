<?php require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
CMS_view::redirect('http://automne4.401/web/demo/9-contact.php', true, 302);
 ?><?php //Generated on Wed, 10 Mar 2010 17:28:49 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://automne4.401/web/demo/print-36-formulaire.php', true, 301);
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Formulaire</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Formulaire</h1>
<h3>

		&raquo;&nbsp;Exemples de modules
		
		&raquo;&nbsp;Formulaire
		
</h3>



	
	

	
	


<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Formulaire" (http://automne4.401/web/demo/36-formulaire.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>