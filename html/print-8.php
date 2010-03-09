<?php //Generated on Tue, 09 Mar 2010 11:58:52 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://automne4.trunk/web/demo/print-8-plan-du-site.php', true, 301);
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Plan du site</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Plan du site</h1>
<h3>

		&raquo;&nbsp;Plan du site
		
</h3>

	<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_sub"><a href="http://automne4.trunk/web/demo/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub"><a href="http://automne4.trunk/web/demo/3-presentation.php">Présentation</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/29-automne-v4.php">Automne</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/33-nouveautes.php">Nouveautés</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/30-notions-essentielles.php">Pré-requis</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://automne4.trunk/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub"><a href="http://automne4.trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub"><a href="http://automne4.trunk/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul></li></ul>
<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Plan du site" (http://automne4.trunk/web/demo/8-plan-du-site.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>