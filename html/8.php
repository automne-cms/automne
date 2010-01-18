<?php //Generated on Mon, 18 Jan 2010 16:11:10 +0100 by Automne (TM) 4.0.0
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/8-plan-du-site.php', true, 301);
}
 ?><?php if (!is_object($cms_user) || !$cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
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

	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l\'accueil">Retour &agrave; l\'accueil</a>
						';
}
?>
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
					<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '<ul class="CMS_lvl2">';  if ($cms_user->hasPageClearance(3, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(24, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(31, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li>';
}
 echo '</ul>';
}
?>
				</div>
				<div id="content" class="page8">
					<div id="breadcrumbs">
						<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; ';
}
?>
					</div>
					<div id="title">
						<h1>Plan du site</h1>
					</div>
					<atm-toc />
					
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

					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
				<?php if ($cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
echo '<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li>';
}
?><?php if ($cms_user->hasPageClearance(9, CLEARANCE_PAGE_VIEW)) {
echo '<li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>';
}
?>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>