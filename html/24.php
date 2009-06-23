<?php //Generated on Tue, 23 Jun 2009 18:05:03 +0200 by Automne (TM) 4.0.0rc1
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/fr/24-documentation.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Automne 4 : Fonctionnalités</title>
			<?php echo CMS_view::getCSS(array('/css/common.css','/css/interieur.css'), 'screen');  ?>

		<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/ie6.css" media="screen" />
		<![endif]-->
		<?php echo CMS_view::getJavascript(array('/js/sifr.js','/js/common.js','/js/CMS_functions.js'));  ?>

		<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

	</head>
	<body>
		<div id="main">
			<div id="container">
				<div id="header">
					
								

<a id="lienAccueil" href="http://127.0.0.1/web/fr/2-accueil.php" title="Retour à l'accueil">Retour à l'accueil</a>


							
				</div>
				<div id="backgroundBottomContainer">
					<div id="menuLeft">
						<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_open "><a class="CMS_lvl1" href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open CMS_current"><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/31-exemples-de-modules.php">Exemples de modules</a></li></ul></li></ul>
					</div>
					<div id="content" class="page24">
						<div id="breadcrumbs">
							<a href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a>

 &gt; 
						</div>
						<div id="title">
							<h1>Fonctionnalités</h1>
						</div>
						
	
	
		<div class="text"><h2>Vous trouverez dans cette partie les grands principes d&rsquo;utilisations d'Automne 4.</h2> <p>Syst&egrave;me de gestion de contenu puissant, Automne 4 permet de g&eacute;rer des sites de plusieurs milliers de pages, d'en <strong>modifier simplement l'apparence</strong> gr&acirc;ce aux <a href="http://127.0.0.1/web/fr/25-modeles.php">mod&egrave;les de pages</a> et de modifier intuitivement le contenu gr&acirc;ce au principe des <a href="http://127.0.0.1/web/fr/26-rangees.php">rang&eacute;es de contenu.</a></p> <p>Les nombreuses fonctionnalit&eacute;s pour le site Internet, simples ou complexes, peuvent &ecirc;tre <span style="font-weight: bold;">g&eacute;n&eacute;r&eacute;es</span><strong> automatiquement par le g&eacute;n&eacute;rateur de module appel&eacute; </strong><a href="http://127.0.0.1/web/fr/27-modules.php"><strong>POLYMOD</strong></a> ou bien d&eacute;velopp&eacute;es directement en code PHP.</p> <p>Automne 4 dispose d'un syst&egrave;me de <a href="http://127.0.0.1/web/fr/28-administration.php">gestion des utilisateurs</a> et <a href="http://127.0.0.1/web/fr/28-administration.php">groupes d'utilisateurs</a> particuli&egrave;rement &eacute;volu&eacute; permettant une <a href="http://127.0.0.1/web/fr/35-gestion-des-droits.php">gestion tr&egrave;s fine des droits.</a> Votre environnement de travail est homog&egrave;ne et ne pr&eacute;sente que les fonctionnalit&eacute;s sur lesquelles vous avez le droit d'agir.</p> <h3>Vous trouverez un descriptif des principales fonctions d'Automne 4 dans les pages ci-dessous :</h3> <ul>     <li><a href="http://127.0.0.1/web/fr/25-modeles.php">Mod&egrave;les de pages</a> (l'habillage graphique du site Internet),</li>     <li><a href="http://127.0.0.1/web/fr/26-rangees.php">Rang&eacute;es de contenu</a> (l'habillage de vos contenus et m&eacute;dias),</li>     <li><a href="http://127.0.0.1/web/fr/27-modules.php">Modules dynamiques</a> (vos outils personnalis&eacute;s et applications d&eacute;di&eacute;es),</li>     <li><a href="http://127.0.0.1/web/fr/28-administration.php">Gestion des utilisateurs et des groupes d'utilisateurs</a>,</li>     <li><a href="http://127.0.0.1/web/fr/35-gestion-des-droits.php">Gestion des droits d'acc&egrave;s</a>,</li>     <li><a href="http://127.0.0.1/web/fr/37-droit-de-validation.php">Workflow de publication des contenus</a>,</li>     <li><a href="http://127.0.0.1/web/fr/38-aide-aux-utilisateurs.php">Aide aux utilisateurs</a>,</li>     <li><a href="http://127.0.0.1/web/fr/34-fonctions-avancees.php">Fonctions avanc&eacute;es</a>.</li> </ul></div>
	

						<a href="#header" id="top" title="haut de la page">Haut</a>
					</div>
					<div class="spacer"></div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div id="menuBottom">
				<ul>
					<li><a href="http://127.0.0.1/web/fr/8-plan-du-site.php">Plan du site</a></li>
<li><a href="http://127.0.0.1/web/fr/9-contact.php">Contact</a></li>
				</ul>
				<div class="spacer"></div>
			</div>
		</div>
	<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>