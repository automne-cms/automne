<?php //Generated on Mon, 18 Jan 2010 16:11:10 +0100 by Automne (TM) 4.0.0
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-8-plan-du-site.php', true, 301);
}
 ?><?php if (!is_object($cms_user) || !$cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
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
<?php if ($cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
echo '
		&raquo;&nbsp;Plan du site
		';
}
?>
</h3>

	<ul class="CMS_lvl1"><?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl1 CMS_sub"><a  href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a><ul class="CMS_lvl2">';  if ($cms_user->hasPageClearance(3, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub"><a  href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a><ul class="CMS_lvl3">';  if ($cms_user->hasPageClearance(29, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(33, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveautés</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(30, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pré-requis</a></li>';
}
 echo '</ul></li>';
}
 echo '';  if ($cms_user->hasPageClearance(24, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub"><a  href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3">';  if ($cms_user->hasPageClearance(25, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(26, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(27, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(28, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(35, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(37, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(38, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(34, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li>';
}
 echo '</ul></li>';
}
 echo '';  if ($cms_user->hasPageClearance(31, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub"><a  href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3">';  if ($cms_user->hasPageClearance(5, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/5-actualite.php">Actualités</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(6, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/6-mediatheque.php">Médiathèque</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(36, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub"><a  href="http://127.0.0.1/web/demo/36-formulaire.php">Formulaire</a></li>';
}
 echo '</ul></li>';
}
 echo '</ul></li>';
}
?></ul>
<br />
<hr />
<div align="center">
	<small>
		
		<?php if ($cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
echo '
				Page  "Plan du site" (http://127.0.0.1/web/demo/8-plan-du-site.php)
				';
}
?><br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>