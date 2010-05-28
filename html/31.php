<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:33 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:46 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 17:00:06 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/31-exemples-de-modules.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/31-exemples-de-modules.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Exemples de modules</title>
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
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_open CMS_current"><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul>
=======
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_open CMS_current"><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/5-actualite.php">Actualités</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/6-mediatheque.php">Médiathèque</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/36-formulaire.php">Formulaire</a></li></ul></li></ul>
>>>>>>> MERGE-SOURCE
				</div>
				<div id="content" class="page31">
					<div id="breadcrumbs">
<<<<<<< TREE
						<a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a> &gt; 
=======
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; 
>>>>>>> MERGE-SOURCE
					</div>
					<div id="title">
						<h1>Exemples de modules</h1>
					</div>
<<<<<<< TREE
					<atm-toc />
<<<<<<< TREE
					

<div class="text"><p>Voici quelques exemples de modules int&eacute;gr&eacute;s &agrave; cette d&eacute;monstration. Il est possible d'en ajouter d'autres tr&egrave;s simplement ...</p> <p>&nbsp;</p> <h2>Module Actualit&eacute;s</h2> <h3>Permet de publier des actualit&eacute;s soumises &agrave; une date de publication.</h3> <h3>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories d'actualit&eacute;s, possibilit&eacute; d'ajouter des cat&eacute;gories.</h3> <h3>Permet d'effectuer une recherche par mots cl&eacute;s, dates de publication, cat&eacute;gories.</h3> <p><a href="http://test-folder/trunk/web/demo/5-actualite.php">Exemple d'affichage du module Actualit&eacute;s</a></p><p>&nbsp;</p> <h2>Module M&eacute;diath&egrave;que</h2> <h3>Permet de t&eacute;l&eacute;charger diff&eacute;rentes cat&eacute;gories de&nbsp; m&eacute;dia : vid&eacute;o, image, son... dans une base commune.</h3> <h3>Plus fonctionnel que dans ces versions ant&eacute;rieures</h3> <ul>     <li>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories de m&eacute;dias ... possibilit&eacute; de rajouter des cat&eacute;gories.</li>     <li>Permet d'effectuer une recherche par mots cl&eacute;s.</li>     <li>Accessible depuis l'&eacute;diteur Wysiwyg lors de l'&eacute;dition des pages.</li> </ul> <h3>Une fois l'objet dans la base du module, il est r&eacute;utilisable&nbsp; dans les pages et les autres modules autant de fois qu'on le souhaite.</h3> <p><a href="http://test-folder/trunk/web/demo/6-mediatheque.php">Exemple d'affichage du module M&eacute;diath&egrave;que</a></p><p>&nbsp;</p> <h2>Module Formulaire</h2> <h3>Permet l'envoi de mail, l'&eacute;criture dans une base de donn&eacute;es, l'identification des utilisateurs, de r&eacute;colter des avis, de faire des sondages ...</h3> <h3>Un assistant de cr&eacute;ation de formulaire vous aidera &agrave; mettre en place des formulaires tout aussi simple que complexes.</h3> <p><a href="http://test-folder/trunk/web/demo/9-contact.php">Exemple d'affichage du module Formulaire</a></p></div>


=======
=======
>>>>>>> MERGE-SOURCE
					<?php /* Start clientspace [first] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>Voici quelques exemples de modules int&eacute;gr&eacute;s &agrave; cette d&eacute;monstration. Il est possible d'en ajouter d'autres tr&egrave;s simplement ...</p> <p>&nbsp;</p> <h2>Module Actualit&eacute;s</h2> <h3>Permet de publier des actualit&eacute;s soumises &agrave; une date de publication.</h3> <h3>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories d'actualit&eacute;s, possibilit&eacute; d'ajouter des cat&eacute;gories.</h3> <h3>Permet d'effectuer une recherche par mots cl&eacute;s, dates de publication, cat&eacute;gories.</h3> <p><a href="http://127.0.0.1/web/demo/5-actualite.php">Exemple d'affichage du module Actualit&eacute;s</a></p><p>&nbsp;</p> <h2>Module M&eacute;diath&egrave;que</h2> <h3>Permet de t&eacute;l&eacute;charger diff&eacute;rentes cat&eacute;gories de&nbsp; m&eacute;dia : vid&eacute;o, image, son... dans une base commune.</h3> <h3>Plus fonctionnel que dans ces versions ant&eacute;rieures</h3> <ul>     <li>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories de m&eacute;dias ... possibilit&eacute; de rajouter des cat&eacute;gories.</li>     <li>Permet d'effectuer une recherche par mots cl&eacute;s.</li>     <li>Accessible depuis l'&eacute;diteur Wysiwyg lors de l'&eacute;dition des pages.</li> </ul> <h3>Une fois l'objet dans la base du module, il est r&eacute;utilisable&nbsp; dans les pages et les autres modules autant de fois qu'on le souhaite.</h3> <p><a href="http://127.0.0.1/web/demo/6-mediatheque.php">Exemple d'affichage du module M&eacute;diath&egrave;que</a></p><p>&nbsp;</p> <h2>Module Formulaire</h2> <h3>Permet l'envoi de mail, l'&eacute;criture dans une base de donn&eacute;es, l'identification des utilisateurs, de r&eacute;colter des avis, de faire des sondages ...</h3> <h3>Un assistant de cr&eacute;ation de formulaire vous aidera &agrave; mettre en place des formulaires tout aussi simple que complexes.</h3> <p><a href="http://127.0.0.1/web/demo/9-contact.php">Exemple d'affichage du module Formulaire</a></p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* End clientspace [first] */   ?>
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