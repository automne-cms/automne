<?php //Generated on Tue, 17 Nov 2009 17:11:43 +0100 by Automne (TM) 4.0.0rc3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/demo/print-24-documentation.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Fonctionnalités</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Fonctionnalités</h1>
<h3>

		&raquo;&nbsp;

Fonctionnalités
		
</h3>

	
	
		<div class="text"><h2>Vous trouverez dans cette partie les grands principes d&rsquo;utilisations d'Automne 4.</h2> <p>Syst&egrave;me de gestion de contenu puissant, Automne 4 permet de g&eacute;rer des sites de plusieurs milliers de pages, d'en <strong>modifier simplement l'apparence</strong> gr&acirc;ce aux <a href="http://127.0.0.1/web/demo/25-modeles.php">mod&egrave;les de pages</a> et de modifier intuitivement le contenu gr&acirc;ce au principe des <a href="http://127.0.0.1/web/demo/26-rangees.php">rang&eacute;es de contenu.</a></p> <p>Les nombreuses fonctionnalit&eacute;s pour le site Internet, simples ou complexes, peuvent &ecirc;tre <span style="font-weight: bold;">g&eacute;n&eacute;r&eacute;es</span><strong> automatiquement par le g&eacute;n&eacute;rateur de module appel&eacute; </strong><a href="http://127.0.0.1/web/demo/27-modules.php"><strong>POLYMOD</strong></a> ou bien d&eacute;velopp&eacute;es directement en code PHP.</p> <p>Automne 4 dispose d'un syst&egrave;me de <a href="http://127.0.0.1/web/demo/28-administration.php">gestion des utilisateurs</a> et <a href="http://127.0.0.1/web/demo/28-administration.php">groupes d'utilisateurs</a> particuli&egrave;rement &eacute;volu&eacute; permettant une <a href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">gestion tr&egrave;s fine des droits.</a> Votre environnement de travail est homog&egrave;ne et ne pr&eacute;sente que les fonctionnalit&eacute;s sur lesquelles vous avez le droit d'agir.</p> <h3>Vous trouverez un descriptif des principales fonctions d'Automne 4 dans les pages ci-dessous :</h3> <ul>     <li><a href="http://127.0.0.1/web/demo/25-modeles.php">Mod&egrave;les de pages</a> (l'habillage graphique du site Internet),</li>     <li><a href="http://127.0.0.1/web/demo/26-rangees.php">Rang&eacute;es de contenu</a> (l'habillage de vos contenus et m&eacute;dias),</li>     <li><a href="http://127.0.0.1/web/demo/27-modules.php">Modules dynamiques</a> (vos outils personnalis&eacute;s et applications d&eacute;di&eacute;es),</li>     <li><a href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs et des groupes d'utilisateurs</a>,</li>     <li><a href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits d'acc&egrave;s</a>,</li>     <li><a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication des contenus</a>,</li>     <li><a href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide aux utilisateurs</a>,</li>     <li><a href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avanc&eacute;es</a>.</li> </ul></div>
	
<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Fonctionnalités" (http://127.0.0.1/web/demo/24-documentation.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>