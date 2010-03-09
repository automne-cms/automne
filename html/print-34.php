<?php //Generated on Tue, 09 Mar 2010 12:18:30 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://automne4.401/web/demo/print-34-fonctions-avancees.php', true, 301);
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Fonctions avancées</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Fonctions avancées</h1>
<h3>

		&raquo;&nbsp;Fonctionnalités
		
		&raquo;&nbsp;Fonctions avancées
		
</h3>


<div class="text"><h2>Gestion Multi-sites</h2> <p>Une seule et m&ecirc;me interface d'Automne 4 peut g&eacute;rer autant de sites diff&eacute;rents que vous le souhaitez. Chacun peut poss&eacute;der son propre nom de domaine, sa propre langue et ses propres &eacute;l&eacute;ments (mod&egrave;les de pages, rang&eacute;es) permettant de g&eacute;rer les diff&eacute;rentes pages qui les composent.</p> <p>&nbsp;</p> <h2>S&eacute;curiser l'acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</h2> <p>Ce syst&egrave;me &eacute;volu&eacute; de gestion des droits permet de r&eacute;aliser des <strong>espaces s&eacute;curis&eacute;s</strong> sur vos sites. Par l&rsquo;interm&eacute;diaire d&rsquo;un Nom d'utilisateur et d'un mot de de passe, votre site Internet se transforme en <strong>site Extranet </strong>appliquant ainsi des <strong>droits et restrictions</strong> sur certaines pages et certains contenus que vous sp&eacute;cifiez. Les restrictions mises en place sont <strong>invisibles </strong>&agrave; ceux qui ne poss&egrave;dent pas les droits de les voir &eacute;vitant ainsi toute frustration de vos utilisateurs.<strong><br /> </strong></p> <h3>Exemple : celui qui n&rsquo;a pas acc&egrave;s &agrave; la page &laquo; ressource &raquo; ne verra pas cet &eacute;l&eacute;ment dans la navigation.</h3> <p>&nbsp;</p> <h2>Connexion LDAP</h2> <p>L'int&eacute;r&ecirc;t principal d'un annuaire LDAP est la <strong>normalisation de l'authentification.</strong> Cet annuaire regroupe toutes les informations de type de l&rsquo;utilisateur (nom, pr&eacute;nom, services, postes &hellip;etc).  Automne 4 permet de r&eacute;cup&eacute;rer automatiquement les informations de l&rsquo;annuaire afin de d&eacute;finir les utilisateurs et leurs droits. &laquo; Le salari&eacute; travaillant au service des ressources humaines, aura automatiquement acc&egrave;s &agrave; la page ressource humaine, l&agrave; o&ugrave; d&rsquo;autres n&rsquo;y auront pas acc&egrave;s &raquo;.</p> <h3>Lors de l&rsquo;ouverture de session, les identifiants et mot de passe sont envoy&eacute;es &agrave; cet annuaire qui transmet alors les informations de l&rsquo;utilisateur.</h3> <p>&nbsp;</p> <h2>SSO (single Sign On)</h2> <p><strong>L'authentification unique</strong> est une m&eacute;thode permettant &agrave; un utilisateur de ne proc&eacute;der qu'&agrave; une seule authentification pour acc&eacute;der &agrave; plusieurs applications informatiques (ou sites web s&eacute;curis&eacute;s). Automne 4 dispose aujourd&rsquo;hui de cette technologie et les utilisateurs pourront directement &ecirc;tre connect&eacute;s &agrave; l&rsquo;interface d'Automne 4 d&eacute;s l&rsquo;ouverture de session sur leur machine.</p> <h3>Plus besoin de s'authentifier &agrave; Automne 4.</h3></div>

<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Fonctions avancées" (http://automne4.401/web/demo/34-fonctions-avancees.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>