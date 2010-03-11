<?php //Generated on Thu, 11 Mar 2010 16:28:43 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://test-folder/trunk/web/demo/24-documentation.php', true, 301);
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Fonctionnalités</title>
		<?php echo CMS_view::getCSS(array('/css/reset.css','/css/demo/common.css','/css/demo/interieur.css'), 'all');  ?>

	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/demo/ie6.css" media="all" />
	<![endif]-->
		<?php echo CMS_view::getCSS(array('/css/demo/print.css'), 'print');  ?>

	<?php echo CMS_view::getJavascript(array('','/js/CMS_functions.js'));  ?>

	<link rel="icon" type="image/x-icon" href="http://test-folder/trunk/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://test-folder/trunk" />
	<base href="http://test-folder/trunk/" />
</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				
							<a id="lienAccueil" href="http://test-folder/trunk/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
						
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open CMS_current"><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
				</div>
				<div id="content" class="page24">
					<div id="breadcrumbs">
						<a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a> &gt; 
					</div>
					<div id="title">
						<h1>Fonctionnalités</h1>
					</div>
					<atm-toc />
					
	
	
		<div class="text"><h2>Vous trouverez dans cette partie les grands principes d&rsquo;utilisations d'Automne 4.</h2> <p>Syst&egrave;me de gestion de contenu puissant, Automne 4 permet de g&eacute;rer des sites de plusieurs milliers de pages, d'en <strong>modifier simplement l'apparence</strong> gr&acirc;ce aux <a href="http://test-folder/trunk/web/demo/25-modeles.php">mod&egrave;les de pages</a> et de modifier intuitivement le contenu gr&acirc;ce au principe des <a href="http://test-folder/trunk/web/demo/26-rangees.php">rang&eacute;es de contenu.</a></p> <p>Les nombreuses fonctionnalit&eacute;s pour le site Internet, simples ou complexes, peuvent &ecirc;tre <span style="font-weight: bold;">g&eacute;n&eacute;r&eacute;es</span><strong> automatiquement par le g&eacute;n&eacute;rateur de module appel&eacute; </strong><a href="http://test-folder/trunk/web/demo/27-modules.php"><strong>POLYMOD</strong></a> ou bien d&eacute;velopp&eacute;es directement en code PHP.</p> <p>Automne 4 dispose d'un syst&egrave;me de <a href="http://test-folder/trunk/web/demo/28-administration.php">gestion des utilisateurs</a> et <a href="http://test-folder/trunk/web/demo/28-administration.php">groupes d'utilisateurs</a> particuli&egrave;rement &eacute;volu&eacute; permettant une <a href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">gestion tr&egrave;s fine des droits.</a> Votre environnement de travail est homog&egrave;ne et ne pr&eacute;sente que les fonctionnalit&eacute;s sur lesquelles vous avez le droit d'agir.</p> <h3>Vous trouverez un descriptif des principales fonctions d'Automne 4 dans les pages ci-dessous :</h3> <ul>     <li><a href="http://test-folder/trunk/web/demo/25-modeles.php">Mod&egrave;les de pages</a> (l'habillage graphique du site Internet),</li>     <li><a href="http://test-folder/trunk/web/demo/26-rangees.php">Rang&eacute;es de contenu</a> (l'habillage de vos contenus et m&eacute;dias),</li>     <li><a href="http://test-folder/trunk/web/demo/27-modules.php">Modules dynamiques</a> (vos outils personnalis&eacute;s et applications d&eacute;di&eacute;es),</li>     <li><a href="http://test-folder/trunk/web/demo/28-administration.php">Gestion des utilisateurs et des groupes d'utilisateurs</a>,</li>     <li><a href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">Gestion des droits d'acc&egrave;s</a>,</li>     <li><a href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">Workflow de publication des contenus</a>,</li>     <li><a href="http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php">Aide aux utilisateurs</a>,</li>     <li><a href="http://test-folder/trunk/web/demo/34-fonctions-avancees.php">Fonctions avanc&eacute;es</a>.</li> </ul></div>
	

					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
				<li><a href="http://test-folder/trunk/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://test-folder/trunk/web/demo/9-contact.php">Contact</a></li>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>