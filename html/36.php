<?php require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
CMS_view::redirect('http://127.0.0.1/web/demo/9-contact.php', true, 302);
 ?><?php //Generated on Mon, 24 May 2010 17:00:12 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/36-formulaire.php', true, 301);
}
 ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Formulaire</title>
		<?php echo CMS_view::getCSS(array('/css/reset.css','/css/demo/common.css','/css/demo/interieur.css'), 'all');  ?>

	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/demo/ie6.css" media="all" />
	<![endif]-->
		<?php echo CMS_view::getCSS(array('/css/demo/print.css'), 'print');  ?>

	<?php echo CMS_view::getJavascript(array('','/js/CMS_functions.js'));  ?>

	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
						
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul>
				</div>
				<div id="content" class="page36">
					<div id="breadcrumbs">
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a> &gt; 
					</div>
					<div id="title">
						<h1>Formulaire</h1>
					</div>
					<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* Start row [220 Texte et Image Gauche - r46_220_Texte_et_Image_Gauche.xml] */   ?>
	
	
<?php /* End row [220 Texte et Image Gauche - r46_220_Texte_et_Image_Gauche.xml] */   ?><?php /* Start row [120 Mini Titre (niveau 3) - r67_120_Sous_Sous_Titre.xml] */   ?>

<?php /* End row [120 Mini Titre (niveau 3) - r67_120_Sous_Sous_Titre.xml] */   ?><?php /* End clientspace [first] */   ?>
					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
				<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>