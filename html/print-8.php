<?php //Generated on Fri, 28 Nov 2008 15:56:42 +0100 by Automne (TM) 4.0.0a1
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://localhost/web/fr/print-8-plan-du-site.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Automne 4 : Plan du site</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Plan du site</h1>
<h3>

		
&raquo;
&nbsp;
Plan du site
		

</h3>

	<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_sub"><a  href="http://localhost/web/fr/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_nosub"><a  href="http://localhost/web/fr/3-presentation.php">Présentation</a></li>
<li class="CMS_lvl2 CMS_sub"><a  href="http://localhost/web/fr/4-fonctionnalites.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/11-gestion-de-contenu.php">Gestion de contenu</a></li>
<li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/12-modules.php">Modules</a></li>
<li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/13-gestion-des-utilisateurs.php">Les utilisateurs</a></li>
<li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/14-gestion-des-droits.php">Gestion des droits</a></li>
<li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/15-module-actualites-mediatheque.php">Les modules</a></li>
<li class="CMS_lvl3 CMS_nosub"><a  href="http://localhost/web/fr/16-fonctions-annexes.php">Fonctions annexes</a></li>
</ul>
</li>
<li class="CMS_lvl2 CMS_nosub"><a  href="http://localhost/web/fr/5-actualite.php">Actualités</a></li>
<li class="CMS_lvl2 CMS_nosub"><a  href="http://localhost/web/fr/6-mediatheque.php">Médiathèque</a></li>
</ul>
</li>
</ul>

<br />
<hr />
<div align="center">
	<small>
		Dernière mise à jour le 12/11/2008<br />
		
				Page  "Plan du site" (http://localhost/web/fr/8-plan-du-site.php)
				
<br />
		Tiré du site http://<?php echo $_SERVER["HTTP_HOST"];   ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat(); if (VIEW_SQL && isset($_SESSION["cms_context"]) && is_object($_SESSION["cms_context"])) {save_stat();}}  ?>
</body>
</html>