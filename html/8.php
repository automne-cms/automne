<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:46 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:32 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/8-plan-du-site.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/8-plan-du-site.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Plan du site</title>
		<?php echo CMS_view::getCSS(array('/css/reset.css','/css/demo/common.css','/css/demo/interieur.css'), 'all');  ?>

	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/demo/ie6.css" media="all" />
	<![endif]-->
		<?php echo CMS_view::getCSS(array('/css/demo/print.css'), 'print');  ?>

	<?php echo CMS_view::getJavascript(array('','/js/CMS_functions.js'));  ?>

<<<<<<< TREE
	<link rel="icon" type="image/x-icon" href="http://test-folder/trunk/favicon.ico" />
=======
	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
>>>>>>> MERGE-SOURCE
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
<<<<<<< TREE
	<meta name="identifier-url" content="http://test-folder/trunk" />
	<base href="http://test-folder/trunk/" />
=======
	<meta name="identifier-url" content="http://127.0.0.1" />

>>>>>>> MERGE-SOURCE
</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				
<<<<<<< TREE
							<a id="lienAccueil" href="http://test-folder/trunk/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
=======
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
>>>>>>> MERGE-SOURCE
						
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
<<<<<<< TREE
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
=======
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
>>>>>>> MERGE-SOURCE
				</div>
				<div id="content" class="page8">
					<div id="breadcrumbs">
<<<<<<< TREE
						<a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a> &gt; 
=======
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; 
>>>>>>> MERGE-SOURCE
					</div>
					<div id="title">
						<h1>Plan du site</h1>
					</div>
					<atm-toc />
<<<<<<< TREE
					
	<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_sub"><a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub"><a href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/29-automne-v4.php">Automne</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/33-nouveautes.php">Nouveautés</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/30-notions-essentielles.php">Pré-requis</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://test-folder/trunk/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul></li></ul>

=======
					<?php /* Start clientspace [first] */   ?><?php /* Start row [700 Plan du site - r54_700_Plan_du_site.xml] */   ?>
	<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_sub"><a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub"><a href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveautés</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pré-requis</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://127.0.0.1/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul></li></ul>
<?php /* End row [700 Plan du site - r54_700_Plan_du_site.xml] */   ?><?php /* End clientspace [first] */   ?>
>>>>>>> MERGE-SOURCE
					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
<<<<<<< TREE
				<li><a href="http://test-folder/trunk/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://test-folder/trunk/web/demo/9-contact.php">Contact</a></li>
=======
				<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>
>>>>>>> MERGE-SOURCE
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>