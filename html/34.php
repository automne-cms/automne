<?php //Generated on Fri, 23 Oct 2009 12:22:00 +0200 by Automne (TM) 4.0.0rc3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/fr/34-fonctions-avancees.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Automne-Démo-UTF8 : Fonctions avancées</title>
			<?php echo CMS_view::getCSS(array('/css/common.css','/css/interieur.css'), 'all');  ?>

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
					
								

<a id="lienAccueil" href="http://127.0.0.1/web/fr/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>


							
				</div>
				<div id="backgroundBottomContainer">
					<div id="menuLeft">
						<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_open "><a class="CMS_lvl1" href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/fr/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/31-exemples-de-modules.php">Exemples de modules</a></li></ul></li></ul>
					</div>
					<div id="content" class="page34">
						<div id="breadcrumbs">
							<a href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a>

 &gt; 
<a href="http://127.0.0.1/web/fr/24-documentation.php">Fonctionnalités</a>

 &gt; 
						</div>
						<div id="title">
							<h1>Fonctions avancées</h1>
						</div>
						

<div class="text"><h2>Gestion Multi-sites</h2> <p>Une seule et m&ecirc;me interface d'Automne 4 peut g&eacute;rer autant de sites diff&eacute;rents que vous le souhaitez. Chacun peut poss&eacute;der son propre nom de domaine, sa propre langue et ses propres &eacute;l&eacute;ments (mod&egrave;les de pages, rang&eacute;es) permettant de g&eacute;rer les diff&eacute;rentes pages qui les composent.</p> <p>&nbsp;</p> <h2>S&eacute;curiser l'acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</h2> <p>Ce syst&egrave;me &eacute;volu&eacute; de gestion des droits permet de r&eacute;aliser des <strong>espaces s&eacute;curis&eacute;s</strong> sur vos sites. Par l&rsquo;interm&eacute;diaire d&rsquo;un Nom d'utilisateur et d'un mot de de passe, votre site Internet se transforme en <strong>site Extranet </strong>appliquant ainsi des <strong>droits et restrictions</strong> sur certaines pages et certains contenus que vous sp&eacute;cifiez. Les restrictions mises en place sont <strong>invisibles </strong>&agrave; ceux qui ne poss&egrave;dent pas les droits de les voir &eacute;vitant ainsi toute frustration de vos utilisateurs.<strong><br /> </strong></p> <h3>Exemple : celui qui n&rsquo;a pas acc&egrave;s &agrave; la page &laquo; ressource &raquo; ne verra pas cet &eacute;l&eacute;ment dans la navigation.</h3> <p>&nbsp;</p> <h2>Connexion LDAP</h2> <p>L'int&eacute;r&ecirc;t principal d'un annuaire LDAP est la <strong>normalisation de l'authentification.</strong> Cet annuaire regroupe toutes les informations de type de l&rsquo;utilisateur (nom, pr&eacute;nom, services, postes &hellip;etc).  Automne 4 permet de r&eacute;cup&eacute;rer automatiquement les informations de l&rsquo;annuaire afin de d&eacute;finir les utilisateurs et leurs droits. &laquo; Le salari&eacute; travaillant au service des ressources humaines, aura automatiquement acc&egrave;s &agrave; la page ressource humaine, l&agrave; o&ugrave; d&rsquo;autres n&rsquo;y auront pas acc&egrave;s &raquo;.</p> <h3>Lors de l&rsquo;ouverture de session, les identifiants et mot de passe sont envoy&eacute;es &agrave; cet annuaire qui transmet alors les informations de l&rsquo;utilisateur.</h3> <p>&nbsp;</p> <h2>SSO (single Sign On)</h2> <p><strong>L'authentification unique</strong> est une m&eacute;thode permettant &agrave; un utilisateur de ne proc&eacute;der qu'&agrave; une seule authentification pour acc&eacute;der &agrave; plusieurs applications informatiques (ou sites web s&eacute;curis&eacute;s). Automne 4 dispose aujourd&rsquo;hui de cette technologie et les utilisateurs pourront directement &ecirc;tre connect&eacute;s &agrave; l&rsquo;interface d'Automne 4 d&eacute;s l&rsquo;ouverture de session sur leur machine.</p> <h3>Plus besoin de s'authentifier &agrave; Automne 4.</h3></div>


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
	<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>