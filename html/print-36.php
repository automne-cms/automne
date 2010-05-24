<?php require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
CMS_view::redirect('http://127.0.0.1/web/demo/9-contact.php', true, 302);
 ?><?php //Generated on Mon, 24 May 2010 17:00:12 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-36-formulaire.php', true, 301);
}
 ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
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
<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* Start row [220 Texte et Image Gauche - r46_220_Texte_et_Image_Gauche.xml] */   ?>
	
	
<?php /* End row [220 Texte et Image Gauche - r46_220_Texte_et_Image_Gauche.xml] */   ?><?php /* Start row [120 Mini Titre (niveau 3) - r67_120_Sous_Sous_Titre.xml] */   ?>

<?php /* End row [120 Mini Titre (niveau 3) - r67_120_Sous_Sous_Titre.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Formulaire" (http://127.0.0.1/web/demo/36-formulaire.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>