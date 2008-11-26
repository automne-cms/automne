# $Id: automne4-data.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
# Base de données: `automne3`
# 

-- 
-- Dumping data for table `actionsTimestamps`
-- 


-- 
-- Dumping data for table `blocksFiles_archived`
-- 


-- 
-- Dumping data for table `blocksFiles_deleted`
-- 


-- 
-- Dumping data for table `blocksFiles_edited`
-- 


-- 
-- Dumping data for table `blocksFiles_edition`
-- 


-- 
-- Dumping data for table `blocksFiles_public`
-- 


-- 
-- Dumping data for table `blocksFlashes_archived`
-- 


-- 
-- Dumping data for table `blocksFlashes_deleted`
-- 


-- 
-- Dumping data for table `blocksFlashes_edited`
-- 


-- 
-- Dumping data for table `blocksFlashes_edition`
-- 


-- 
-- Dumping data for table `blocksFlashes_public`
-- 


-- 
-- Dumping data for table `blocksImages_archived`
-- 


-- 
-- Dumping data for table `blocksImages_deleted`
-- 


-- 
-- Dumping data for table `blocksImages_edited`
-- 

INSERT INTO blocksImages_edited (id, page, clientSpaceID, rowID, blockID, label, file, enlargedFile, externalLink) VALUES (1, 9, 'center-1', '800812be426455ff6024bc14af5b532e', 'image', 'Automne', 'p9_c57d12418416a2cef835a8f9897be9d8photo.jpg', '', '');

-- 
-- Dumping data for table `blocksImages_edition`
-- 


-- 
-- Dumping data for table `blocksImages_public`
-- 

INSERT INTO blocksImages_public (id, page, clientSpaceID, rowID, blockID, label, file, enlargedFile, externalLink) VALUES (1, 9, 'center-1', '800812be426455ff6024bc14af5b532e', 'image', 'Automne', 'p9_c57d12418416a2cef835a8f9897be9d8photo.jpg', '', '');

-- 
-- Dumping data for table `blocksRawDatas_archived`
-- 


-- 
-- Dumping data for table `blocksRawDatas_deleted`
-- 


-- 
-- Dumping data for table `blocksRawDatas_edited`
-- 

INSERT INTO blocksRawDatas_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (1, 6, 'center-1', '648c715da08c46777e6d870b8fd963d6', 'form', 'a:1:{s:6:"formID";s:1:"1";}');

-- 
-- Dumping data for table `blocksRawDatas_edition`
-- 


-- 
-- Dumping data for table `blocksRawDatas_public`
-- 

INSERT INTO blocksRawDatas_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (1, 6, 'center-1', '648c715da08c46777e6d870b8fd963d6', 'form', 'a:1:{s:6:"formID";s:1:"1";}');

-- 
-- Dumping data for table `blocksTexts_archived`
-- 


-- 
-- Dumping data for table `blocksTexts_deleted`
-- 


-- 
-- Dumping data for table `blocksTexts_edited`
-- 

INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (11, 4, 'center-1', '5bc67447f23f433ab70a58c6842ff1f9', 'texte', '<p>Serveur Linux, Windows, Max OSX, Solaris, BSD, ou tout autre syst&egrave;me syst&egrave;me Unix permettant de faire tourner les trois outils suivant sur lesquels repose Automne :</p>\r\n<ul>\r\n	<li><a href="http://httpd.apache.org/" target="_blank">Apache 1.3.x</a> (Apache 2 fonctionne mais n&rsquo;est pas support&eacute; officiellement pour le moment).</li>\r\n	<li><a href="http://www.php.net" target="_blank">PHP 4.3.x</a>. Pour des raisons de s&eacute;curit&eacute; nous recommandons la derni&egrave;re version de la branche 4.4.x (la compatibilit&eacute; avec PHP 5 est pr&eacute;vue pour Automne 4.0 disponible d&eacute;but 2008).\r\n	<ul>\r\n		<li>Extension GD disponible pour PHP (permet le <a href="http://www.php.net/manual/fr/ref.image.php" target="_blank">traitement des images</a>) avec les librairies JPEG, GIF et PNG.</li>\r\n		<li>Option &quot;<a href="http://fr2.php.net/manual/fr/features.safe-mode.php" target="_blank">safe_mode</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li>\r\n		<li>16Mo de m&eacute;moire allou&eacute; aux scripts PHP</li>\r\n	</ul>\r\n	</li>\r\n	<li><a href="http://www.mysql.com/" target="_blank">MySQL 4.x</a> (La version 3.23 de MySQL ne sera plus support&eacute;e par Automne &agrave; partir de la version 3.3.0. La version 5 de MySQL n&rsquo;a pas &eacute;t&eacute; test&eacute; mais devrait fonctionner parfaitement).</li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (18, 9, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<ul>\r\n	<li>Cr&eacute;ation et gestion du contenu de mani&egrave;re intuitive permettant de visualiser directement votre mise en page sans avoir &agrave; les mettre en ligne. Utilisation de l&rsquo;&eacute;diteur visuel <a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a> (WYSIWYG) pour saisir vos textes de fa&ccedil;on souple et claire, &agrave; la fa&ccedil;on de votre &eacute;diteur de texte pr&eacute;f&eacute;r&eacute;.</li>\r\n	<li>Planification des dates de d&eacute;but et de fin de publication.</li>\r\n	<li>S&eacute;paration de la mise en forme et du contenu.</li>\r\n	<li>G&eacute;n&eacute;ration de caches du contenu dynamique pour permettre la plus grande rapidit&eacute; du site c&ocirc;t&eacute; client. Vous pouvez de ce fait servir des milliers de visiteurs simultan&eacute;ment sans&nbsp;serveurs surdimensionn&eacute;s. Seul le code PHP strictement n&eacute;cessaire est ex&eacute;cut&eacute;, le reste &eacute;tant du XHTML g&eacute;n&eacute;r&eacute; une fois pour toute et mis &agrave; jour uniquement au besoin.</li>\r\n	<li>Pages imprimables : une version optimis&eacute;e de chaque page est r&eacute;alis&eacute;e pour servir de base aux impressions de votre site, permettant ainsi un rendu propre du contenu imprim&eacute; sans probl&egrave;mes de mise en page.</li>\r\n	<li>Administration du contenu depuis le c&ocirc;t&eacute; client du site, c''est nouveau ! depuis la version 3.2.1.</li>\r\n	<li>Gestion des meta-donn&eacute;es de vos pages.</li>\r\n	<li>Gestion simplifi&eacute;e des images (redimensionnement et compression).</li>\r\n	<li>Gestion simplifi&eacute;e des formulaires (contact, envoyer &agrave; un ami, sondage, etc.)</li>\r\n	<li>G&eacute;n&eacute;ration de Fils RSS</li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (20, 10, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<ul>\r\n	<li>Gestion fine des droits des utilisateurs et des groupes d&rsquo;utilisateurs.</li>\r\n	<li>Possibilit&eacute; d&rsquo;associer un utilisateur &agrave; plusieurs groupes d&rsquo;utilisateurs pour une gestion encore plus fine des droits utilisateurs (de type <a target="_blank" href="http://en.wikipedia.org/wiki/RBAC">Role Based Access Control</a>). C''est nouveau ! depuis la version 3.3.0.</li>\r\n	<li>Syst&egrave;me de validation (workflow) permettant de conserver plusieurs versions du contenu (public, en cours d&rsquo;&eacute;dition, en attente de validation, etc.).</li>\r\n	<li>Permet de g&eacute;rer plusieurs classes d&rsquo;utilisateurs (r&eacute;dacteurs, validateurs, administrateurs, etc.).</li>\r\n	<li>Syst&egrave;me d&rsquo;authentification cot&eacute; client permettant de r&eacute;aliser des espaces s&eacute;curis&eacute;s sur vos sites pour des intranet et extranets.</li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (21, 11, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 'texte', '<ul>\r\n	<li>Compatible Internet Explorer 5.5, 6 et 7 ainsi que Firefox, Mozilla et Safari.</li>\r\n	<li>Syst&egrave;me de mise &agrave; jour automatique.</li>\r\n	<li>Utilisation de scripts serveurs pour r&eacute;aliser des proc&eacute;dures en t&acirc;che de fond sans n&eacute;cessiter de connection au syst&egrave;me (sur les serveurs le supportant : n&eacute;cessite le module CLI de PHP).</li>\r\n	<li>Gestion de modules permettant d&rsquo;ajouter tout type d&rsquo;applications dynamiques pour enrichir les fonctionnalit&eacute;s natives. La notion de crochet (hook) d&eacute;ploy&eacute;e autour des modules permet le traitement et retraitement de tout tag XML pr&eacute;sent &agrave; n&rsquo;importe quel niveau du syst&egrave;me (mod&egrave;les, contenu statique, pages g&eacute;n&eacute;r&eacute;es, contenu dynamique, etc.). Et c''est nouveau ! depuis la version 3.2.0).</li>\r\n	<li>Gestion avanc&eacute;e des liens entres pages : toute page sait qui la lie, et surveille ces pages ainsi que les pages qu&rsquo;elle lie. Tous les liens interpages sont mis &agrave; jour en temps r&eacute;el &agrave; chaque modification apport&eacute;e aux pages.</li>\r\n	<li>Syst&egrave;me de mod&egrave;les de pages (templates) XML / XHTML permettant &agrave; l&rsquo;aide de simples balises XML de d&eacute;finir les zones de contenu et les pages qui les utilisent.</li>\r\n	<li>G&eacute;n&eacute;rateur de modules pour ajouter simplement, et sans avoir &agrave; saisir le moindre code PHP, tout type d&rsquo;applications de gestion de donn&eacute;es dynamiques. Vous n&rsquo;avez plus &agrave; vous soucier de la structure de la base de donn&eacute;es, vous n&rsquo;avez plus &agrave; conna&icirc;tre les fondements du noyau du syst&egrave;me pour cr&eacute;er vos propres applications dynamiques. Tout se fait gr&acirc;ce &agrave; une interface d&rsquo;administration simple et &agrave; quelques balises XML. Cet outil permet de plus la g&eacute;n&eacute;ration de fils RSS &agrave; partir du contenu de vos applications ainsi que la r&eacute;utilisation de votre contenu dynamique dans n&rsquo;importe quelle page, en utilisant le WYSIWYG. c''est nouveau ! depuis la version 3.3.0.</li>\r\n	<li>Edition des mod&egrave;les de pages et des CSS qui les composent dans l&rsquo;interface d&rsquo;administration.</li>\r\n	<li>Gestion multisites : une m&ecirc;me interface&nbsp;Automne peut g&eacute;rer plusieurs sites simultan&eacute;ment, partageant ainsi vos droits utilisateurs sur plusieurs domaines distincts.</li>\r\n	<li>Optimisation du r&eacute;f&eacute;rencement naturel avec URL significatives (sans l&rsquo;emploi du mod_rewrite d&rsquo;apache), et c''est nouveau ! depuis la version 3.2.1</li>\r\n	<li>Gestion de sites multilangues (l&rsquo;administration d&rsquo;Automne existe actuellement en fran&ccedil;ais et en anglais).</li>\r\n	<li>Gestion des alias</li>\r\n	<li>Plan du site</li>\r\n	<li>Gestion d&rsquo;annuaires LDAP</li>\r\n	<li>Assistant d&rsquo;installation.</li>\r\n	<li>etc.</li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (6, 13, 'center-1', '26bfc25da40ba8f17f3a1080bfb3fe5a', 'texte', '<p>Automne is a content management system (CMS). Create, and modify web pages for any internet, intranet, or extranet site. Automne manages your user profiles and rights within a workflow validation system for corporate presentation pages or dynamically generated data-base driven web sites. </p>\r\n<p>Key features in Automne include: </p>\r\n<ul>\r\n    <li>Import templates directly into Automne </li>\r\n    <li>Customize templates for each web page using an intuitive editor and copy/paste content from office software </li>\r\n    <li>Control access to the admin and public site per page and per application </li>\r\n    <li>Use an integrated workflow system to validate content modifications </li>\r\n    <li>Automatize publication dates and alerts </li>\r\n    <li>Configure and add automne parameters using advanced tools </li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (12, 4, 'center-1', 'e200c1a9cbf36731f79136ca50f89f48', 'texte', '<ul>\r\n	<li>PHP install&eacute; sous forme de module Apache (la version CGI offre des performances moindres et ne permet pas de configurer PHP &agrave; l''aide de fichier .htaccess).</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/features.commandline.php">Module CLI de PHP install&eacute;</a> et disponible sur le serveur ainsi que les fonctions &quot;<a target="_blank" href="http://www.php.net/system">system</a>&quot; et &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/function.exec.php">exec</a>&quot; de PHP pour profiter des scripts en tache de fond.</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/fr/ref.zlib.php">Extension Zlib</a> (permet d''activer la compression HTML cot&eacute; administration du CMS).</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/fr/ref.exif.php">Extension EXIF</a> et <a target="_blank" href="http://www.php.net/manual/fr/ref.image.php">FreeType (avec les cha&icirc;nes TrueType pour GD)</a> (Permet la manipulation avanc&eacute;e des images pour certains modules)</li>\r\n	<li>Option &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/ref.info.php#ini.magic-quotes-gpc">magic_quotes_gpc</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li>\r\n	<li>Apache doit avoir le droit de cr&eacute;er et de modifier l&rsquo;ensemble des fichiers d''Automne sur le serveur pour profiter du syst&egrave;me d&rsquo;installation et de mise &agrave; jour automatique. Sans cela, certaines parties de l&rsquo;installation et des mises &agrave; jour devront &ecirc;tre faites manuellement.</li>\r\n	<li>Un acc&eacute;l&eacute;rateur de code PHP tel que <a target="_blank" href="http://pecl.php.net/package/APC">APC</a>, <a target="_blank" href="http://turck-mmcache.sourceforge.net">Turck mmcache</a> ou <a target="_blank" href="http://www.zend.com/products/zend_optimizer">Zend optimizer</a> est un plus pour les performances.</li>\r\n	<li>Certaines fonctionnalit&eacute;s d&rsquo;Automne (telle que la g&eacute;n&eacute;ration des pages du site) peuvent n&eacute;cessiter plus de m&eacute;moire vive (en particulier si vous avez compil&eacute; PHP avec un tr&egrave;s grand nombre d''extensions). En r&egrave;gle g&eacute;n&eacute;rale ce n&rsquo;est pas un probl&egrave;me mais il est pr&eacute;f&eacute;rable de laisser PHP g&eacute;rer lui m&ecirc;me la m&eacute;moire vive allou&eacute; aux scripts en permettant l''usage de la fonction &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/ini.core.php#ini.memory-limit">memory_limit</a>&quot;.</li>\r\n	<li>Certains h&eacute;bergeurs activent l''option &quot;session.use_trans_sid&quot;. Cette option doit &ecirc;tre d&eacute;sactiv&eacute;e via les fichiers .htaccess ou via le fichier php.ini pour qu''Automne puisse fonctionner correctement. Cette option <a target="_blank" href="http://www.php.net/manual/fr/ref.session.php#ini.session.use-trans-sid">pouvant repr&eacute;senter un risque de s&eacute;curit&eacute;</a>, il est de toute mani&egrave;re conseill&eacute; de la d&eacute;sactiver.</li>\r\n</ul>\r\n<p>Pour des raisons de performance, nous recommandons l&rsquo;usage d&rsquo;un serveur Linux ou Unix en production.<br  />\r\n<br  />\r\nDu fait de l&rsquo;emploi de fichiers .htaccess, le serveur Apache est fortement conseill&eacute; par rapport &agrave; un serveur IIS. Automne devrait pouvoir fonctionner avec ce type de serveur mais aucun test n&rsquo;a &eacute;t&eacute; r&eacute;alis&eacute; en ce sens jusqu&rsquo;&agrave; pr&eacute;sent.</p>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (10, 3, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 'texte', '<p>Automne est un syst&egrave;me de gestion de contenu professionnel d&eacute;di&eacute; aux entreprises, organismes public et associations de toutes tailles &agrave; la recherche d''un outil&nbsp;performant, ergonomique et&nbsp;Open Source pour g&eacute;rer leurs pages web et leurs applications dynamiques dans un environnement&nbsp;s&eacute;curis&eacute; et collaboratif.</p>\r\n<p>Automne est votre solution si vous recherchez un outil de gestion de contenu performant et &eacute;volutif, permettant autonomie et contr&ocirc;le &eacute;ditorial. Que votre&nbsp;contenu soit statique ou dynamique avec une gestion en&nbsp;bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes sans contraintes techniques.</p>\r\n<p>Les fonctionnalit&eacute;s cl&eacute;s sont notamment :</p>\r\n<ul>\r\n	<li>Gestion dynamique de l''arborescence</li>\r\n	<li>Utilisation de mod&egrave;les de pages</li>\r\n	<li>Syst&egrave;me de workflow collaboratif</li>\r\n	<li>Multi-sites, multi-lingues</li>\r\n	<li>Gestion des profils et groupes utilisateurs</li>\r\n	<li>Dates de publication automatique</li>\r\n	<li>Espaces s&eacute;curis&eacute;s</li>\r\n	<li>Editeur visuel int&eacute;gr&eacute; (WYSIWYG)</li>\r\n	<li>Int&eacute;gration de modules personnalis&eacute;s</li>\r\n	<li>Contr&ocirc;le avanc&eacute; de l''administration</li>\r\n	<li>etc.</li>\r\n</ul>\r\n<p>Le logiciel Automne est &eacute;crit en PHP, totalement orient&eacute; objet, et propos&eacute; en open source. Il utilise XML comme base de structure de donn&eacute;es et XHTML comme langage de g&eacute;n&eacute;ration des sites qu''il produit. Automne est sous licence GNU-GPL, il n''y a donc aucun frais de licence. Multiplateforme, Automne a &eacute;t&eacute; test&eacute; avec succ&egrave;s sur Linux, Windows, Mac OSX et Solaris.</p>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (19, 8, 'center-1', 'a83c27402b936960393834bf42204813a', 'texte', '');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (13, 8, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<p>Automne est un syst&egrave;me de gestion de contenu (CMS = Content Management System) d&eacute;di&eacute; &agrave; la publication d&rsquo;informations structur&eacute;es sur internet (cr&eacute;ation et mise &agrave; jour de sites internet, intranet, extranet, s&eacute;curis&eacute;s ou non). Il est &eacute;crit&nbsp;en langage PHP, utilise une base de donn&eacute;es MySQL et est publi&eacute; sous <a target="_blank" href="http://www.gnu.org/copyleft/gpl.html">licence GNU-GPL</a>.<br  />\r\n<br  />\r\nIl permet de g&eacute;rer une arborescence de pages. Ces pages peuvent accueillir tout type de contenus et de m&eacute;dias statiques :</p>\r\n<ul>\r\n	<li>Texte mis en forme</li>\r\n	<li>Images</li>\r\n	<li>Fichiers</li>\r\n	<li>Vid&eacute;os</li>\r\n	<li>Animations Flash</li>\r\n	<li>etc.</li>\r\n</ul>\r\n<p>Mais aussi tout type de m&eacute;dias dynamiques :</p>\r\n<ul>\r\n	<li>Actualit&eacute;s</li>\r\n	<li>Agenda</li>\r\n	<li>Base documentaire</li>\r\n	<li>Phototh&egrave;que</li>\r\n	<li>Annuaire</li>\r\n	<li>etc.</li>\r\n</ul>');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (17, 8, 'center-1', 'a7676475a99cfa897a228910539c967c9', 'texte', '');
INSERT INTO blocksTexts_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (14, 8, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 'texte', '<ul>\r\n	<li><strong>Robuste</strong>, Automne permet la gestion fiable de plusieurs milliers de pages ainsi que de tr&egrave;s nombreuses donn&eacute;es dynamiques. Il est b&acirc;ti autour de technologies ayant fait leurs preuves : PHP 4, MySQL, XML, XHTML, CSS et Javascript. Compl&egrave;tement orient&eacute; objet, le fonctionnement d&rsquo;Automne est donc particuli&egrave;rement modulaire.</li>\r\n	<li><strong>P&eacute;renne</strong>, Automne existe depuis 1999 et respecte une stricte politique de compatibilit&eacute; ascendante. De plus, comme tout logiciel Open Source, vous pouvez le faire &eacute;voluer vous-m&ecirc;me.</li>\r\n	<li><strong>Eprouv&eacute;</strong>, Automne est employ&eacute; avec satisfaction par de nombreux grands comptes mais aussi des PME, PMI et des administrations fran&ccedil;aises.</li>\r\n	<li><strong>Respectueux</strong>, son d&eacute;veloppement s&rsquo;attache &agrave; respecter les normes en vigueur autour des technologies qu&rsquo;il emploie, notamment les recommandations du W3C, et les r&egrave;gles d''accessibilit&eacute;.</li>\r\n	<li><strong>Ergonomique</strong>, travaillez directement en naviguant dans votre site :&nbsp;la saisie du contenu se fait dans un &eacute;diteur visuel WYSIWYG. La cr&eacute;ation de page est intuitive et permet de visualiser imm&eacute;diatement votre mise en page.</li>\r\n	<li><strong>Accessible</strong>, utilisant nativement XHTML, vous pouvez mettre en oeuvre des sites respectant les normes d&rsquo;accessibilit&eacute; les plus strictes &agrave; l&rsquo;aide d&rsquo;Automne. Des administrations fran&ccedil;aises s&rsquo;en servent pour mettre leurs sites en conformit&eacute; avec les r&eacute;centes lois sur l&rsquo;accessibilit&eacute; num&eacute;rique.</li>\r\n	<li><strong>Modulaire</strong>, vous pouvez ajouter autant de modules dynamiques que vous le souhaitez pour enrichir les fonctionnalit&eacute;s d&rsquo;Automne selon vos besoins.</li>\r\n	<li><strong>Support&eacute;</strong>, Automne est &eacute;dit&eacute; par <a target="_blank" href="http://www.ws-interactive.fr">WS Interactive</a>, agence web toulousaine (31) qui propose des formations utilisateurs et d&eacute;veloppeurs ainsi qu&rsquo;un support professionnel fiable en ligne et sur site.</li>\r\n</ul>');

-- 
-- Dumping data for table `blocksTexts_edition`
-- 


-- 
-- Dumping data for table `blocksTexts_public`
-- 

INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (11, 4, 'center-1', '5bc67447f23f433ab70a58c6842ff1f9', 'texte', '<p>Serveur Linux, Windows, Max OSX, Solaris, BSD, ou tout autre syst&egrave;me syst&egrave;me Unix permettant de faire tourner les trois outils suivant sur lesquels repose Automne :</p>\r\n<ul>\r\n	<li><a href="http://httpd.apache.org/" target="_blank">Apache 1.3.x</a> (Apache 2 fonctionne mais n&rsquo;est pas support&eacute; officiellement pour le moment).</li>\r\n	<li><a href="http://www.php.net" target="_blank">PHP 4.3.x</a>. Pour des raisons de s&eacute;curit&eacute; nous recommandons la derni&egrave;re version de la branche 4.4.x (la compatibilit&eacute; avec PHP 5 est pr&eacute;vue pour Automne 4.0 disponible d&eacute;but 2008).\r\n	<ul>\r\n		<li>Extension GD disponible pour PHP (permet le <a href="http://www.php.net/manual/fr/ref.image.php" target="_blank">traitement des images</a>) avec les librairies JPEG, GIF et PNG.</li>\r\n		<li>Option &quot;<a href="http://fr2.php.net/manual/fr/features.safe-mode.php" target="_blank">safe_mode</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li>\r\n		<li>16Mo de m&eacute;moire allou&eacute; aux scripts PHP</li>\r\n	</ul>\r\n	</li>\r\n	<li><a href="http://www.mysql.com/" target="_blank">MySQL 4.x</a> (La version 3.23 de MySQL ne sera plus support&eacute;e par Automne &agrave; partir de la version 3.3.0. La version 5 de MySQL n&rsquo;a pas &eacute;t&eacute; test&eacute; mais devrait fonctionner parfaitement).</li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (18, 9, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<ul>\r\n	<li>Cr&eacute;ation et gestion du contenu de mani&egrave;re intuitive permettant de visualiser directement votre mise en page sans avoir &agrave; les mettre en ligne. Utilisation de l&rsquo;&eacute;diteur visuel <a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a> (WYSIWYG) pour saisir vos textes de fa&ccedil;on souple et claire, &agrave; la fa&ccedil;on de votre &eacute;diteur de texte pr&eacute;f&eacute;r&eacute;.</li>\r\n	<li>Planification des dates de d&eacute;but et de fin de publication.</li>\r\n	<li>S&eacute;paration de la mise en forme et du contenu.</li>\r\n	<li>G&eacute;n&eacute;ration de caches du contenu dynamique pour permettre la plus grande rapidit&eacute; du site c&ocirc;t&eacute; client. Vous pouvez de ce fait servir des milliers de visiteurs simultan&eacute;ment sans&nbsp;serveurs surdimensionn&eacute;s. Seul le code PHP strictement n&eacute;cessaire est ex&eacute;cut&eacute;, le reste &eacute;tant du XHTML g&eacute;n&eacute;r&eacute; une fois pour toute et mis &agrave; jour uniquement au besoin.</li>\r\n	<li>Pages imprimables : une version optimis&eacute;e de chaque page est r&eacute;alis&eacute;e pour servir de base aux impressions de votre site, permettant ainsi un rendu propre du contenu imprim&eacute; sans probl&egrave;mes de mise en page.</li>\r\n	<li>Administration du contenu depuis le c&ocirc;t&eacute; client du site, c''est nouveau ! depuis la version 3.2.1.</li>\r\n	<li>Gestion des meta-donn&eacute;es de vos pages.</li>\r\n	<li>Gestion simplifi&eacute;e des images (redimensionnement et compression).</li>\r\n	<li>Gestion simplifi&eacute;e des formulaires (contact, envoyer &agrave; un ami, sondage, etc.)</li>\r\n	<li>G&eacute;n&eacute;ration de Fils RSS</li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (20, 10, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<ul>\r\n	<li>Gestion fine des droits des utilisateurs et des groupes d&rsquo;utilisateurs.</li>\r\n	<li>Possibilit&eacute; d&rsquo;associer un utilisateur &agrave; plusieurs groupes d&rsquo;utilisateurs pour une gestion encore plus fine des droits utilisateurs (de type <a target="_blank" href="http://en.wikipedia.org/wiki/RBAC">Role Based Access Control</a>). C''est nouveau ! depuis la version 3.3.0.</li>\r\n	<li>Syst&egrave;me de validation (workflow) permettant de conserver plusieurs versions du contenu (public, en cours d&rsquo;&eacute;dition, en attente de validation, etc.).</li>\r\n	<li>Permet de g&eacute;rer plusieurs classes d&rsquo;utilisateurs (r&eacute;dacteurs, validateurs, administrateurs, etc.).</li>\r\n	<li>Syst&egrave;me d&rsquo;authentification cot&eacute; client permettant de r&eacute;aliser des espaces s&eacute;curis&eacute;s sur vos sites pour des intranet et extranets.</li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (21, 11, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 'texte', '<ul>\r\n	<li>Compatible Internet Explorer 5.5, 6 et 7 ainsi que Firefox, Mozilla et Safari.</li>\r\n	<li>Syst&egrave;me de mise &agrave; jour automatique.</li>\r\n	<li>Utilisation de scripts serveurs pour r&eacute;aliser des proc&eacute;dures en t&acirc;che de fond sans n&eacute;cessiter de connection au syst&egrave;me (sur les serveurs le supportant : n&eacute;cessite le module CLI de PHP).</li>\r\n	<li>Gestion de modules permettant d&rsquo;ajouter tout type d&rsquo;applications dynamiques pour enrichir les fonctionnalit&eacute;s natives. La notion de crochet (hook) d&eacute;ploy&eacute;e autour des modules permet le traitement et retraitement de tout tag XML pr&eacute;sent &agrave; n&rsquo;importe quel niveau du syst&egrave;me (mod&egrave;les, contenu statique, pages g&eacute;n&eacute;r&eacute;es, contenu dynamique, etc.). Et c''est nouveau ! depuis la version 3.2.0).</li>\r\n	<li>Gestion avanc&eacute;e des liens entres pages : toute page sait qui la lie, et surveille ces pages ainsi que les pages qu&rsquo;elle lie. Tous les liens interpages sont mis &agrave; jour en temps r&eacute;el &agrave; chaque modification apport&eacute;e aux pages.</li>\r\n	<li>Syst&egrave;me de mod&egrave;les de pages (templates) XML / XHTML permettant &agrave; l&rsquo;aide de simples balises XML de d&eacute;finir les zones de contenu et les pages qui les utilisent.</li>\r\n	<li>G&eacute;n&eacute;rateur de modules pour ajouter simplement, et sans avoir &agrave; saisir le moindre code PHP, tout type d&rsquo;applications de gestion de donn&eacute;es dynamiques. Vous n&rsquo;avez plus &agrave; vous soucier de la structure de la base de donn&eacute;es, vous n&rsquo;avez plus &agrave; conna&icirc;tre les fondements du noyau du syst&egrave;me pour cr&eacute;er vos propres applications dynamiques. Tout se fait gr&acirc;ce &agrave; une interface d&rsquo;administration simple et &agrave; quelques balises XML. Cet outil permet de plus la g&eacute;n&eacute;ration de fils RSS &agrave; partir du contenu de vos applications ainsi que la r&eacute;utilisation de votre contenu dynamique dans n&rsquo;importe quelle page, en utilisant le WYSIWYG. c''est nouveau ! depuis la version 3.3.0.</li>\r\n	<li>Edition des mod&egrave;les de pages et des CSS qui les composent dans l&rsquo;interface d&rsquo;administration.</li>\r\n	<li>Gestion multisites : une m&ecirc;me interface&nbsp;Automne peut g&eacute;rer plusieurs sites simultan&eacute;ment, partageant ainsi vos droits utilisateurs sur plusieurs domaines distincts.</li>\r\n	<li>Optimisation du r&eacute;f&eacute;rencement naturel avec URL significatives (sans l&rsquo;emploi du mod_rewrite d&rsquo;apache), et c''est nouveau ! depuis la version 3.2.1</li>\r\n	<li>Gestion de sites multilangues (l&rsquo;administration d&rsquo;Automne existe actuellement en fran&ccedil;ais et en anglais).</li>\r\n	<li>Gestion des alias</li>\r\n	<li>Plan du site</li>\r\n	<li>Gestion d&rsquo;annuaires LDAP</li>\r\n	<li>Assistant d&rsquo;installation.</li>\r\n	<li>etc.</li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (12, 4, 'center-1', 'e200c1a9cbf36731f79136ca50f89f48', 'texte', '<ul>\r\n	<li>PHP install&eacute; sous forme de module Apache (la version CGI offre des performances moindres et ne permet pas de configurer PHP &agrave; l''aide de fichier .htaccess).</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/features.commandline.php">Module CLI de PHP install&eacute;</a> et disponible sur le serveur ainsi que les fonctions &quot;<a target="_blank" href="http://www.php.net/system">system</a>&quot; et &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/function.exec.php">exec</a>&quot; de PHP pour profiter des scripts en tache de fond.</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/fr/ref.zlib.php">Extension Zlib</a> (permet d''activer la compression HTML cot&eacute; administration du CMS).</li>\r\n	<li><a target="_blank" href="http://www.php.net/manual/fr/ref.exif.php">Extension EXIF</a> et <a target="_blank" href="http://www.php.net/manual/fr/ref.image.php">FreeType (avec les cha&icirc;nes TrueType pour GD)</a> (Permet la manipulation avanc&eacute;e des images pour certains modules)</li>\r\n	<li>Option &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/ref.info.php#ini.magic-quotes-gpc">magic_quotes_gpc</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li>\r\n	<li>Apache doit avoir le droit de cr&eacute;er et de modifier l&rsquo;ensemble des fichiers d''Automne sur le serveur pour profiter du syst&egrave;me d&rsquo;installation et de mise &agrave; jour automatique. Sans cela, certaines parties de l&rsquo;installation et des mises &agrave; jour devront &ecirc;tre faites manuellement.</li>\r\n	<li>Un acc&eacute;l&eacute;rateur de code PHP tel que <a target="_blank" href="http://pecl.php.net/package/APC">APC</a>, <a target="_blank" href="http://turck-mmcache.sourceforge.net">Turck mmcache</a> ou <a target="_blank" href="http://www.zend.com/products/zend_optimizer">Zend optimizer</a> est un plus pour les performances.</li>\r\n	<li>Certaines fonctionnalit&eacute;s d&rsquo;Automne (telle que la g&eacute;n&eacute;ration des pages du site) peuvent n&eacute;cessiter plus de m&eacute;moire vive (en particulier si vous avez compil&eacute; PHP avec un tr&egrave;s grand nombre d''extensions). En r&egrave;gle g&eacute;n&eacute;rale ce n&rsquo;est pas un probl&egrave;me mais il est pr&eacute;f&eacute;rable de laisser PHP g&eacute;rer lui m&ecirc;me la m&eacute;moire vive allou&eacute; aux scripts en permettant l''usage de la fonction &quot;<a target="_blank" href="http://fr2.php.net/manual/fr/ini.core.php#ini.memory-limit">memory_limit</a>&quot;.</li>\r\n	<li>Certains h&eacute;bergeurs activent l''option &quot;session.use_trans_sid&quot;. Cette option doit &ecirc;tre d&eacute;sactiv&eacute;e via les fichiers .htaccess ou via le fichier php.ini pour qu''Automne puisse fonctionner correctement. Cette option <a target="_blank" href="http://www.php.net/manual/fr/ref.session.php#ini.session.use-trans-sid">pouvant repr&eacute;senter un risque de s&eacute;curit&eacute;</a>, il est de toute mani&egrave;re conseill&eacute; de la d&eacute;sactiver.</li>\r\n</ul>\r\n<p>Pour des raisons de performance, nous recommandons l&rsquo;usage d&rsquo;un serveur Linux ou Unix en production.<br  />\r\n<br  />\r\nDu fait de l&rsquo;emploi de fichiers .htaccess, le serveur Apache est fortement conseill&eacute; par rapport &agrave; un serveur IIS. Automne devrait pouvoir fonctionner avec ce type de serveur mais aucun test n&rsquo;a &eacute;t&eacute; r&eacute;alis&eacute; en ce sens jusqu&rsquo;&agrave; pr&eacute;sent.</p>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (6, 13, 'center-1', '26bfc25da40ba8f17f3a1080bfb3fe5a', 'texte', '<p>Automne is a content management system (CMS). Create, and modify web pages for any internet, intranet, or extranet site. Automne manages your user profiles and rights within a workflow validation system for corporate presentation pages or dynamically generated data-base driven web sites. </p>\r\n<p>Key features in Automne include: </p>\r\n<ul>\r\n    <li>Import templates directly into Automne </li>\r\n    <li>Customize templates for each web page using an intuitive editor and copy/paste content from office software </li>\r\n    <li>Control access to the admin and public site per page and per application </li>\r\n    <li>Use an integrated workflow system to validate content modifications </li>\r\n    <li>Automatize publication dates and alerts </li>\r\n    <li>Configure and add automne parameters using advanced tools </li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (10, 3, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 'texte', '<p>Automne est un syst&egrave;me de gestion de contenu professionnel d&eacute;di&eacute; aux entreprises, organismes public et associations de toutes tailles &agrave; la recherche d''un outil&nbsp;performant, ergonomique et&nbsp;Open Source pour g&eacute;rer leurs pages web et leurs applications dynamiques dans un environnement&nbsp;s&eacute;curis&eacute; et collaboratif.</p>\r\n<p>Automne est votre solution si vous recherchez un outil de gestion de contenu performant et &eacute;volutif, permettant autonomie et contr&ocirc;le &eacute;ditorial. Que votre&nbsp;contenu soit statique ou dynamique avec une gestion en&nbsp;bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes sans contraintes techniques.</p>\r\n<p>Les fonctionnalit&eacute;s cl&eacute;s sont notamment :</p>\r\n<ul>\r\n	<li>Gestion dynamique de l''arborescence</li>\r\n	<li>Utilisation de mod&egrave;les de pages</li>\r\n	<li>Syst&egrave;me de workflow collaboratif</li>\r\n	<li>Multi-sites, multi-lingues</li>\r\n	<li>Gestion des profils et groupes utilisateurs</li>\r\n	<li>Dates de publication automatique</li>\r\n	<li>Espaces s&eacute;curis&eacute;s</li>\r\n	<li>Editeur visuel int&eacute;gr&eacute; (WYSIWYG)</li>\r\n	<li>Int&eacute;gration de modules personnalis&eacute;s</li>\r\n	<li>Contr&ocirc;le avanc&eacute; de l''administration</li>\r\n	<li>etc.</li>\r\n</ul>\r\n<p>Le logiciel Automne est &eacute;crit en PHP, totalement orient&eacute; objet, et propos&eacute; en open source. Il utilise XML comme base de structure de donn&eacute;es et XHTML comme langage de g&eacute;n&eacute;ration des sites qu''il produit. Automne est sous licence GNU-GPL, il n''y a donc aucun frais de licence. Multiplateforme, Automne a &eacute;t&eacute; test&eacute; avec succ&egrave;s sur Linux, Windows, Mac OSX et Solaris.</p>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (19, 8, 'center-1', 'a83c27402b936960393834bf42204813a', 'texte', '');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (13, 8, 'center-1', '800812be426455ff6024bc14af5b532e', 'texte', '<p>Automne est un syst&egrave;me de gestion de contenu (CMS = Content Management System) d&eacute;di&eacute; &agrave; la publication d&rsquo;informations structur&eacute;es sur internet (cr&eacute;ation et mise &agrave; jour de sites internet, intranet, extranet, s&eacute;curis&eacute;s ou non). Il est &eacute;crit&nbsp;en langage PHP, utilise une base de donn&eacute;es MySQL et est publi&eacute; sous <a target="_blank" href="http://www.gnu.org/copyleft/gpl.html">licence GNU-GPL</a>.<br  />\r\n<br  />\r\nIl permet de g&eacute;rer une arborescence de pages. Ces pages peuvent accueillir tout type de contenus et de m&eacute;dias statiques :</p>\r\n<ul>\r\n	<li>Texte mis en forme</li>\r\n	<li>Images</li>\r\n	<li>Fichiers</li>\r\n	<li>Vid&eacute;os</li>\r\n	<li>Animations Flash</li>\r\n	<li>etc.</li>\r\n</ul>\r\n<p>Mais aussi tout type de m&eacute;dias dynamiques :</p>\r\n<ul>\r\n	<li>Actualit&eacute;s</li>\r\n	<li>Agenda</li>\r\n	<li>Base documentaire</li>\r\n	<li>Phototh&egrave;que</li>\r\n	<li>Annuaire</li>\r\n	<li>etc.</li>\r\n</ul>');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (17, 8, 'center-1', 'a7676475a99cfa897a228910539c967c9', 'texte', '');
INSERT INTO blocksTexts_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (14, 8, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 'texte', '<ul>\r\n	<li><strong>Robuste</strong>, Automne permet la gestion fiable de plusieurs milliers de pages ainsi que de tr&egrave;s nombreuses donn&eacute;es dynamiques. Il est b&acirc;ti autour de technologies ayant fait leurs preuves : PHP 4, MySQL, XML, XHTML, CSS et Javascript. Compl&egrave;tement orient&eacute; objet, le fonctionnement d&rsquo;Automne est donc particuli&egrave;rement modulaire.</li>\r\n	<li><strong>P&eacute;renne</strong>, Automne existe depuis 1999 et respecte une stricte politique de compatibilit&eacute; ascendante. De plus, comme tout logiciel Open Source, vous pouvez le faire &eacute;voluer vous-m&ecirc;me.</li>\r\n	<li><strong>Eprouv&eacute;</strong>, Automne est employ&eacute; avec satisfaction par de nombreux grands comptes mais aussi des PME, PMI et des administrations fran&ccedil;aises.</li>\r\n	<li><strong>Respectueux</strong>, son d&eacute;veloppement s&rsquo;attache &agrave; respecter les normes en vigueur autour des technologies qu&rsquo;il emploie, notamment les recommandations du W3C, et les r&egrave;gles d''accessibilit&eacute;.</li>\r\n	<li><strong>Ergonomique</strong>, travaillez directement en naviguant dans votre site :&nbsp;la saisie du contenu se fait dans un &eacute;diteur visuel WYSIWYG. La cr&eacute;ation de page est intuitive et permet de visualiser imm&eacute;diatement votre mise en page.</li>\r\n	<li><strong>Accessible</strong>, utilisant nativement XHTML, vous pouvez mettre en oeuvre des sites respectant les normes d&rsquo;accessibilit&eacute; les plus strictes &agrave; l&rsquo;aide d&rsquo;Automne. Des administrations fran&ccedil;aises s&rsquo;en servent pour mettre leurs sites en conformit&eacute; avec les r&eacute;centes lois sur l&rsquo;accessibilit&eacute; num&eacute;rique.</li>\r\n	<li><strong>Modulaire</strong>, vous pouvez ajouter autant de modules dynamiques que vous le souhaitez pour enrichir les fonctionnalit&eacute;s d&rsquo;Automne selon vos besoins.</li>\r\n	<li><strong>Support&eacute;</strong>, Automne est &eacute;dit&eacute; par <a target="_blank" href="http://www.ws-interactive.fr">WS Interactive</a>, agence web toulousaine (31) qui propose des formations utilisateurs et d&eacute;veloppeurs ainsi qu&rsquo;un support professionnel fiable en ligne et sur site.</li>\r\n</ul>');

-- 
-- Dumping data for table `blocksVarchars_archived`
-- 


-- 
-- Dumping data for table `blocksVarchars_deleted`
-- 


-- 
-- Dumping data for table `blocksVarchars_edited`
-- 

INSERT INTO blocksVarchars_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (1, 13, 'center-1', '78d78979d868517dd4fef947c432f91f', 'stitre', 'Automne, version 3');
INSERT INTO blocksVarchars_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (2, 3, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 'stitre', 'Automne, version 3');
INSERT INTO blocksVarchars_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (3, 4, 'center-1', '312620b9f6a33a5e2064b28f0da38972', 'stitre', 'Pré-requis techniques obligatoires :');
INSERT INTO blocksVarchars_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (4, 4, 'center-1', 'a45b3f02ce891ee839a7779056bf3a92a', 'stitre', 'Pré-requis facultatif :');
INSERT INTO blocksVarchars_edited (id, page, clientSpaceID, rowID, blockID, value) VALUES (5, 8, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 'stitre', 'Pourquoi Automne - Point forts :');

-- 
-- Dumping data for table `blocksVarchars_edition`
-- 


-- 
-- Dumping data for table `blocksVarchars_public`
-- 

INSERT INTO blocksVarchars_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (1, 13, 'center-1', '78d78979d868517dd4fef947c432f91f', 'stitre', 'Automne, version 3');
INSERT INTO blocksVarchars_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (2, 3, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 'stitre', 'Automne, version 3');
INSERT INTO blocksVarchars_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (3, 4, 'center-1', '312620b9f6a33a5e2064b28f0da38972', 'stitre', 'Pré-requis techniques obligatoires :');
INSERT INTO blocksVarchars_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (4, 4, 'center-1', 'a45b3f02ce891ee839a7779056bf3a92a', 'stitre', 'Pré-requis facultatif :');
INSERT INTO blocksVarchars_public (id, page, clientSpaceID, rowID, blockID, value) VALUES (5, 8, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 'stitre', 'Pourquoi Automne - Point forts :');

-- 
-- Dumping data for table `contactDatas`
-- 

INSERT INTO contactDatas (id_cd, service_cd, jobTitle_cd, addressField1_cd, addressField2_cd, addressField3_cd, zip_cd, city_cd, state_cd, country_cd, phone_cd, cellphone_cd, fax_cd, email_cd) VALUES (1, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');
INSERT INTO contactDatas (id_cd, service_cd, jobTitle_cd, addressField1_cd, addressField2_cd, addressField3_cd, zip_cd, city_cd, state_cd, country_cd, phone_cd, cellphone_cd, fax_cd, email_cd) VALUES (3, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');

-- 
-- Dumping data for table `languages`
-- 

INSERT INTO languages (code_lng, label_lng, dateFormat_lng, availableForBackoffice_lng, modulesDenied_lng) VALUES ('fr', 'Français', 'd/m/Y', 1, '');
INSERT INTO languages (code_lng, label_lng, dateFormat_lng, availableForBackoffice_lng, modulesDenied_lng) VALUES ('en', 'English', 'm/d/Y', 1, '');

-- 
-- Dumping data for table `linx_real_public`
-- 

INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4639, 2, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4638, 2, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4724, 3, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4723, 3, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4722, 3, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4721, 3, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4720, 3, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4719, 3, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4541, 4, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4540, 4, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4539, 4, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4538, 4, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4537, 4, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4536, 4, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4718, 3, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4717, 3, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4535, 4, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4534, 4, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4716, 3, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4715, 3, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4714, 3, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4713, 3, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4567, 5, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4566, 5, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4565, 5, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4564, 5, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4563, 5, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4562, 5, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4561, 5, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4560, 5, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4578, 6, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4577, 6, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4576, 6, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4575, 6, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4574, 6, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4573, 6, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4572, 6, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4571, 6, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4709, 8, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4708, 8, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4707, 8, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4706, 8, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4705, 8, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4696, 9, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4704, 8, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4703, 8, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4702, 8, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4757, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4756, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4701, 8, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4700, 8, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4699, 8, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4698, 8, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4695, 9, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4694, 9, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4693, 9, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4454, 13, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4692, 9, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4691, 9, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4690, 9, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4689, 9, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4688, 9, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4687, 9, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4770, 10, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4769, 10, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4768, 10, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4767, 10, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4766, 10, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4765, 10, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4764, 10, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4763, 10, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4762, 10, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4783, 11, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4782, 11, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4781, 11, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4780, 11, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4779, 11, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4778, 11, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4777, 11, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4776, 11, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4775, 11, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4637, 2, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4636, 2, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4635, 2, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4634, 2, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4453, 13, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4452, 13, 17);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4451, 13, 16);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4450, 13, 15);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4444, 12, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4443, 12, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4470, 15, 15);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4469, 15, 15);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4468, 15, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4467, 15, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4462, 14, 14);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4686, 9, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4449, 13, 14);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4448, 13, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4447, 13, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4486, 17, 17);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4485, 17, 17);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4484, 17, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4483, 17, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4482, 17, 17);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4478, 16, 16);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4477, 16, 16);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4476, 16, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4475, 16, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4474, 16, 16);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4461, 14, 14);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4466, 15, 15);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4460, 14, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4459, 14, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4458, 14, 14);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4755, 7, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4754, 7, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4753, 7, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4752, 7, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4751, 7, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4750, 7, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4749, 7, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4748, 7, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4747, 7, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4746, 7, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4712, 3, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4711, 3, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4533, 4, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4532, 4, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4559, 5, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4558, 5, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4570, 6, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4569, 6, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4685, 9, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4761, 10, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4760, 10, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4759, 10, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4774, 11, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4773, 11, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4772, 11, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4446, 13, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4445, 13, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4457, 14, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4456, 14, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4455, 14, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4465, 15, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4464, 15, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4463, 15, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4473, 16, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4472, 16, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4471, 16, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4481, 17, 13);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4480, 17, 12);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4479, 17, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4745, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4744, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4743, 7, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4742, 7, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4741, 7, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4740, 7, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4739, 7, 11);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4738, 7, 10);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4737, 7, 9);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4736, 7, 8);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4735, 7, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4734, 7, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4733, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4732, 7, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4731, 7, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4730, 7, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4729, 7, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4728, 7, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4683, 18, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4682, 18, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4681, 18, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4680, 18, 6);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4679, 18, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4678, 18, 5);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4677, 18, 4);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4676, 18, 3);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4675, 18, 18);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4674, 18, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4673, 18, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4633, 2, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4710, 3, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4531, 4, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4697, 8, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4684, 9, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4758, 10, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4771, 11, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4557, 5, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4568, 6, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4727, 7, 7);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4726, 7, 2);
INSERT INTO linx_real_public (id_lre, start_lre, stop_lre) VALUES (4725, 7, 2);

-- 
-- Dumping data for table `linx_tree_edited`
-- 

INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (1, 1, 2, 1);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (2, 2, 3, 1);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (3, 2, 4, 2);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (4, 2, 5, 3);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (5, 2, 6, 5);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (6, 2, 7, 6);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (7, 3, 8, 1);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (8, 3, 9, 2);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (9, 3, 10, 3);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (10, 3, 11, 4);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (11, 1, 12, 2);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (12, 12, 13, 1);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (13, 13, 14, 1);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (14, 13, 15, 2);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (15, 13, 16, 3);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (16, 13, 17, 4);
INSERT INTO linx_tree_edited (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (17, 2, 18, 4);

-- 
-- Dumping data for table `linx_tree_public`
-- 

INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (27, 1, 2, 1);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (46, 2, 7, 6);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (45, 2, 6, 5);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (44, 2, 18, 4);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (43, 2, 5, 3);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (42, 2, 4, 2);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (25, 3, 10, 3);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (24, 3, 9, 2);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (23, 3, 8, 1);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (26, 3, 11, 4);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (28, 1, 12, 2);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (29, 12, 13, 1);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (38, 13, 16, 3);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (37, 13, 15, 2);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (36, 13, 14, 1);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (39, 13, 17, 4);
INSERT INTO linx_tree_public (id_ltr, father_ltr, sibling_ltr, order_ltr) VALUES (41, 2, 3, 1);

-- 
-- Dumping data for table `linx_watch_public`
-- 

INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (962, 2, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (978, 3, 3);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (977, 3, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (947, 4, 4);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (946, 4, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (951, 5, 5);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (953, 6, 6);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (976, 8, 8);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (986, 7, 7);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (975, 8, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (974, 9, 9);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (973, 9, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (988, 10, 10);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (987, 10, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (990, 11, 11);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (989, 11, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (929, 13, 13);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (928, 13, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (927, 12, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (933, 15, 15);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (932, 15, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (937, 17, 17);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (936, 17, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (935, 16, 16);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (934, 16, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (931, 14, 14);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (930, 14, 12);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (950, 5, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (985, 7, 3);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (952, 6, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (984, 7, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (983, 7, 7);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (982, 7, 7);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (981, 7, 3);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (980, 7, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (979, 7, 2);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (972, 18, 18);
INSERT INTO linx_watch_public (id_lwa, page_lwa, target_lwa) VALUES (971, 18, 2);

-- 
-- Dumping data for table `locks`
-- 


-- 
-- Dumping data for table `log`
-- 


-- 
-- Dumping data for table `mod_cms_aliases`
-- 


-- 
-- Dumping data for table `mod_cms_forms_actions`
-- 

INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (1, 1, 'text', 0, '');
INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (2, 1, '', 2, '');
INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (3, 1, 'text', 99, 'Merci d''avoir pris le temps de complèter ce formulaire. Nous vous répondrons aussi rapidement que possible.');
INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (4, 1, 'text', 1, 'Il y a des erreurs de saisie ...');
INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (5, 1, 'administrateur@votredomaine.com', 3, 'Une demande de contact depuis votre site Automne.§§Voici les informations saisies dans le formulaire de contact de votre site Automne :§§');
INSERT INTO mod_cms_forms_actions (id_act, form_act, value_act, type_act, text_act) VALUES (6, 1, '7', 4, 'Copie de votre demande de contact.§§Voici un récapitulatif des informations que vous avez saisies dans notre formulaire de contact :§§Merci encore.\r\nL''équipe Automne.');

-- 
-- Dumping data for table `mod_cms_forms_categories`
-- 

INSERT INTO mod_cms_forms_categories (id_fca, form_fca, category_fca) VALUES (1, 1, 1);

-- 
-- Dumping data for table `mod_cms_forms_fields`
-- 

INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (1, 1, '6c0932cb0a777b1a3cfd6eb7781757bd', '* Nom', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 0);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (2, 1, 'a4754bd2b3156da6d38d2a1b5cee418c', 'Prénom', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 0, 1, 1);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (3, 1, '3fd45c0caea0d8aa06c10f11724f6529', 'Adresse', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 0, 1, 2);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (4, 1, 'a645886eb0842c8d97a9bff1554a89fa', 'Ville', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 0, 1, 3);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (5, 1, 'dc9331f08a82df5ad7b6c98836ac1acb', 'Pays', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 0, 1, 4);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (6, 1, '204a5b764689787f9747830788ace9ef', 'Code Postal', '', '', 'integer', 'a:1:{s:0:"";s:0:"";}', 0, 1, 5);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (7, 1, '67d6757e187859e6554642dbb33ceff7', '* Email', '', '', 'email', 'a:1:{s:0:"";s:0:"";}', 1, 1, 6);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (8, 1, '5f3f17537be7f0e440af05ec47f9fcd9', 'Téléphone', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 0, 1, 7);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (9, 1, 'a25359cb1832b4b313d8b16ba5967155', '* Commentaires', '', '', 'textarea', 'a:1:{s:0:"";s:0:"";}', 1, 1, 8);
INSERT INTO mod_cms_forms_fields (id_fld, form_fld, name_fld, label_fld, defaultValue_fld, dataValidation_fld, type_fld, options_fld, required_fld, active_fld, order_fld) VALUES (10, 1, 'b435b91f3358e35512594804faef202e', 'Envoyer', '', '', 'submit', 'a:1:{s:0:"";s:0:"";}', 0, 1, 9);

-- 
-- Dumping data for table `mod_cms_forms_formulars`
-- 

INSERT INTO mod_cms_forms_formulars (id_frm, name_frm, source_frm, language_frm, owner_frm, closed_frm, destinationType_frm, DestinationData_frm, responses_frm) VALUES (1, 'Formulaire de contact', '\n<form id="cms_forms_1">\n<table width="100%" cellspacing="3" cellpadding="3" border="0" align="center" summary="">\n<tbody>\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzFfcmVx">* Nom</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzFfcmVx" name="6c0932cb0a777b1a3cfd6eb7781757bd" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzI=">Prénom</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzI=" name="a4754bd2b3156da6d38d2a1b5cee418c" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzM=">Adresse</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzM=" name="3fd45c0caea0d8aa06c10f11724f6529" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzQ=">Ville</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzQ=" name="a645886eb0842c8d97a9bff1554a89fa" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzZfaW50ZWdlcg==">Code Postal</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzZfaW50ZWdlcg==" name="204a5b764689787f9747830788ace9ef" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzU=">Pays</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzU=" name="dc9331f08a82df5ad7b6c98836ac1acb" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzdfZW1haWxfcmVx">* Email</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzdfZW1haWxfcmVx" name="67d6757e187859e6554642dbb33ceff7" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzg=">Téléphone</label>\n</td>\n\n<td>\n<input type="text" value="" id="zY21zX2ZpZWxkXzg=" name="5f3f17537be7f0e440af05ec47f9fcd9" /></td>\n</tr>\n\n<tr>\n<td style="text-align: right;">\n<label for="zY21zX2ZpZWxkXzlfcmVx">* Commentaires</label>\n</td>\n\n<td>\n<textarea id="zY21zX2ZpZWxkXzlfcmVx" name="a25359cb1832b4b313d8b16ba5967155"></textarea>\n</td>\n</tr>\n\n<tr>\n<td style="text-align: right;"> </td>\n\n<td>\n<input type="submit" id="zY21zX2ZpZWxkXzEw" class="button" name="b435b91f3358e35512594804faef202e" value="Envoyer" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n\n<div align="center"> 				"Conformément à la loi informatique et liberté du 06.01.78 (article 27), \n<br />vous disposez d''un droit d''accès et de rectification des données vous concernant". </div>\n', 'fr', 1, 0, 0, '', 0);

-- 
-- Dumping data for table `mod_cms_forms_records`
-- 


-- 
-- Dumping data for table `mod_cms_forms_senders`
-- 


-- 
-- Dumping data for table `mod_object_definition`
-- 

INSERT INTO mod_object_definition (id_mod, label_id_mod, description_id_mod, resource_usage_mod, module_mod, admineditable_mod, composedLabel_mod, previewURL_mod, indexable_mod, indexURL_mod, compiledIndexURL_mod) VALUES (1, 1, 2, 1, 'pnews', 0, '', '5||item={[''object1''][''id'']}', 0, '', '');
INSERT INTO mod_object_definition (id_mod, label_id_mod, description_id_mod, resource_usage_mod, module_mod, admineditable_mod, composedLabel_mod, previewURL_mod, indexable_mod, indexURL_mod, compiledIndexURL_mod) VALUES (2, 12, 13, 1, 'pdocs', 0, '', '', 0, '', '');

-- 
-- Dumping data for table `mod_object_field`
-- 

INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (1, 1, 3, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (2, 1, 4, 5, 'CMS_object_text', 3, 0, 1, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"500";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (3, 1, 6, 7, 'CMS_object_text', 4, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"500";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (4, 1, 8, 0, 'CMS_object_image', 5, 0, 0, 0, 0, 1, 'a:3:{s:8:"maxWidth";s:3:"100";s:15:"useDistinctZoom";b:0;s:8:"makeZoom";b:1;}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (5, 1, 9, 0, 'CMS_object_categories', 2, 0, 1, 0, 1, 1, 'a:3:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:1:"2";s:15:"associateUnused";b:0;}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (6, 2, 14, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (7, 2, 15, 0, 'CMS_object_categories', 2, 0, 1, 0, 1, 1, 'a:3:{s:15:"multiCategories";b:1;s:12:"rootCategory";s:1:"6";s:15:"associateUnused";b:0;}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (8, 2, 16, 0, 'CMS_object_language', 3, 0, 1, 0, 1, 1, 'a:0:{}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (9, 2, 17, 0, 'CMS_object_text', 4, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"500";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (10, 2, 18, 0, 'CMS_object_file', 5, 0, 1, 0, 1, 1, 'a:7:{s:12:"useThumbnail";b:0;s:13:"thumbMaxWidth";s:0:"";s:9:"fileIcons";a:18:{s:3:"doc";s:7:"doc.gif";s:3:"gif";s:7:"gif.gif";s:4:"html";s:8:"html.gif";s:3:"htm";s:8:"html.gif";s:3:"jpg";s:7:"jpg.gif";s:4:"jpeg";s:7:"jpg.gif";s:3:"jpe";s:7:"jpg.gif";s:3:"mov";s:7:"mov.gif";s:3:"mp3";s:7:"mp3.gif";s:3:"pdf";s:7:"pdf.gif";s:3:"png";s:7:"png.gif";s:3:"ppt";s:7:"ppt.gif";s:3:"pps";s:7:"ppt.gif";s:3:"swf";s:7:"swf.gif";s:3:"sxw";s:7:"sxw.gif";s:3:"url";s:7:"url.gif";s:3:"xls";s:7:"xls.gif";s:3:"xml";s:7:"xml.gif";}s:8:"allowFtp";b:0;s:6:"ftpDir";s:13:"/automne/tmp/";s:11:"allowedType";s:0:"";s:14:"disallowedType";s:31:"exe,php,pif,vbs,bat,com,scr,reg";}');

-- 
-- Dumping data for table `mod_object_i18nm`
-- 

INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (1, 'fr', 'Actualités');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (1, 'en', 'News');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (2, 'fr', 'Cette ressource permet de publier des textes soumis à une date de publication.');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (2, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (3, 'fr', 'Titre');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (3, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (4, 'fr', 'Introduction');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (4, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (5, 'fr', 'Visible sur la page d''accueil');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (5, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (6, 'fr', 'Texte');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (6, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (7, 'fr', 'Visible dans le détail d''une actualité');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (7, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (8, 'fr', 'Image');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (8, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (9, 'fr', 'Catégorie');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (9, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (10, 'fr', 'Automne : Actualités');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (10, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (11, 'fr', 'Fil RSS des actualités de la démonstration d''Automne');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (11, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (12, 'fr', 'Document');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (12, 'en', 'Document');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (13, 'fr', 'Un document est un fichier Word, PDF au autre complété par un titre, une description, etc.');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (13, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (14, 'fr', 'Titre');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (14, 'en', 'Title');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (15, 'fr', 'Catégories');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (15, 'en', 'Catégories');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (16, 'fr', 'Langue');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (16, 'en', 'Language');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (17, 'fr', 'Description');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (17, 'en', 'Description');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (18, 'fr', 'Fichier');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (18, 'en', '');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (19, 'fr', 'Documents Français');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (19, 'en', 'French Documents');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (20, 'fr', 'Insérez un lien vers un document français dans vos textes.');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (20, 'en', 'Insert a link to a french document into your texts');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (21, 'fr', 'Documents Anglais');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (21, 'en', 'English Documents');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (22, 'fr', 'Insérez un lien vers un document anglais dans vos textes');
INSERT INTO mod_object_i18nm (id_i18nm, code_i18nm, value_i18nm) VALUES (22, 'en', 'Insert a link to an english document into your texts');

-- 
-- Dumping data for table `mod_object_plugin_definition`
-- 

INSERT INTO mod_object_plugin_definition (id_mowd, object_id_mowd, label_id_mowd, description_id_mowd, query_mowd, definition_mowd, compiled_definition_mowd) VALUES (1, 2, 19, 20, 'a:2:{i:7;s:1:"0";i:8;s:2:"fr";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <a href="{[''object2''][''fields''][10][''filePath'']}/{[''object2''][''fields''][10][''filename'']}" target="_blank" title="Lien vers le document ''{[''object2''][''label'']}'' ({[''object2''][''fields''][10][''fileExtension'']} - {[''object2''][''fields''][10][''fileSize'']}Mo)">{plugin:selection}</a>\r\n    </atm-plugin-valid>\r\n    <atm-plugin-invalid>\r\n        {plugin:selection}\r\n    </atm-plugin-invalid>\r\n</atm-plugin>', '<?php\n//Generated by : $Id: automne4-data.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $\n$content = "";\n$replace = "";\nif (!is_array($objectDefinitions)) $objectDefinitions = array();\n$parameters[''objectID''] = 2;\nif (!isset($cms_language)) $cms_language = new CMS_language(''fr'');\n$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\nif (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\nif (!is_array($object)) $object = array();\nif (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n$parameters[''module''] = ''pdocs'';\n//PLUGIN TAG START 5_08a4ad\nif (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n	CMS_grandFather::_raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n} else {\n	//search needed object (need to search it for publications and rights purpose)\n	if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n		$objectDefinitions[$parameters[''objectID'']] = &new CMS_poly_object_definition($parameters[''objectID'']);\n	}\n	$search_5_08a4ad = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n	$search_5_08a4ad->addWhereCondition(''item'', $parameters[''itemID'']);\n	$results_5_08a4ad = $search_5_08a4ad->search();\n	if (is_object($results_5_08a4ad[$parameters[''itemID'']])) {\n		$object[$parameters[''objectID'']] = $results_5_08a4ad[$parameters[''itemID'']];\n	}\n	//PLUGIN-VALID TAG START 6_d4a8dd\n	if ($object[$parameters[''objectID'']]->isInUserSpace()) {\n		$content .="<a href=\\"".$object[2]->_objectValues[10]->getValue(''filePath'','''')."/".$object[2]->_objectValues[10]->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Lien vers le document ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->_objectValues[10]->getValue(''fileExtension'','''')." - ".$object[2]->_objectValues[10]->getValue(''fileSize'','''')."Mo)\\">".$parameters[''selection'']."</a>";\n	}\n	//PLUGIN-VALID END 6_d4a8dd\n	//PLUGIN-INVALID TAG START 7_4fe067\n	if (!$object[$parameters[''objectID'']]->isInUserSpace()) {\n		$content .="        ".$parameters[''selection''];\n	}\n	//PLUGIN-INVALID END 7_4fe067\n}\n//PLUGIN TAG END 5_08a4ad\necho CMS_polymod_definition_parsing::replaceVars($content, $replace);\n?>');
INSERT INTO mod_object_plugin_definition (id_mowd, object_id_mowd, label_id_mowd, description_id_mowd, query_mowd, definition_mowd, compiled_definition_mowd) VALUES (2, 2, 21, 22, 'a:2:{i:7;s:1:"0";i:8;s:2:"en";}', '<atm-plugin language="en">\r\n    <atm-plugin-valid>\r\n        <a href="{[''object2''][''fields''][10][''filePath'']}/{[''object2''][''fields''][10][''filename'']}" target="_blank" title="Link to document ''{[''object2''][''label'']}'' ({[''object2''][''fields''][10][''fileExtension'']} - {[''object2''][''fields''][10][''fileSize'']}MB)">{plugin:selection}</a>\r\n    </atm-plugin-valid>\r\n    <atm-plugin-invalid>\r\n        {plugin:selection}\r\n    </atm-plugin-invalid>\r\n</atm-plugin>', '<?php\n//Generated by : $Id: automne4-data.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $\n$content = "";\n$replace = "";\nif (!is_array($objectDefinitions)) $objectDefinitions = array();\n$parameters[''objectID''] = 2;\nif (!isset($cms_language)) $cms_language = new CMS_language(''en'');\n$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\nif (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\nif (!is_array($object)) $object = array();\nif (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n$parameters[''module''] = ''pdocs'';\n//PLUGIN TAG START 5_364aaf\nif (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n	CMS_grandFather::_raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n} else {\n	//search needed object (need to search it for publications and rights purpose)\n	if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n		$objectDefinitions[$parameters[''objectID'']] = &new CMS_poly_object_definition($parameters[''objectID'']);\n	}\n	$search_5_364aaf = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n	$search_5_364aaf->addWhereCondition(''item'', $parameters[''itemID'']);\n	$results_5_364aaf = $search_5_364aaf->search();\n	if (is_object($results_5_364aaf[$parameters[''itemID'']])) {\n		$object[$parameters[''objectID'']] = $results_5_364aaf[$parameters[''itemID'']];\n	}\n	//PLUGIN-VALID TAG START 6_cb9f15\n	if ($object[$parameters[''objectID'']]->isInUserSpace()) {\n		$content .="<a href=\\"".$object[2]->_objectValues[10]->getValue(''filePath'','''')."/".$object[2]->_objectValues[10]->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Link to document ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->_objectValues[10]->getValue(''fileExtension'','''')." - ".$object[2]->_objectValues[10]->getValue(''fileSize'','''')."MB)\\">".$parameters[''selection'']."</a>";\n	}\n	//PLUGIN-VALID END 6_cb9f15\n	//PLUGIN-INVALID TAG START 7_4e58d5\n	if (!$object[$parameters[''objectID'']]->isInUserSpace()) {\n		$content .="        ".$parameters[''selection''];\n	}\n	//PLUGIN-INVALID END 7_4e58d5\n}\n//PLUGIN TAG END 5_364aaf\necho CMS_polymod_definition_parsing::replaceVars($content, $replace);\n?>');

-- 
-- Dumping data for table `mod_object_polyobjects`
-- 

INSERT INTO mod_object_polyobjects (id_moo, object_type_id_moo, deleted_moo) VALUES (1, 1, 0);
INSERT INTO mod_object_polyobjects (id_moo, object_type_id_moo, deleted_moo) VALUES (2, 2, 0);

-- 
-- Dumping data for table `mod_object_rss_definition`
-- 

INSERT INTO mod_object_rss_definition (id_mord, object_id_mord, label_id_mord, description_id_mord, link_mord, author_mord, copyright_mord, categories_mord, ttl_mord, email_mord, definition_mord, compiled_definition_mord, last_compilation_mord) VALUES (1, 1, 10, 11, '', '', '', '', 1440, '', '<atm-rss language="fr">\r\n	<atm-search what="{[''object1'']}" name="news">\r\n		<atm-search-limit search="news" value="20" />\r\n		<atm-result search="news">\r\n			<atm-rss-item>\r\n				<atm-rss-item-url>{page:5:url}?item={[''object1''][''id'']}</atm-rss-item-url>\r\n				<atm-rss-item-title>{[''object1''][''fields''][1][''label'']}</atm-rss-item-title>\r\n				<atm-rss-item-content>\r\n				<atm-if what="{[''object1''][''fields''][4][''imageName'']}">{[''object1''][''fields''][4][''imageHTML'']}</atm-if>\r\n				<atm-if what="{[''object1''][''fields''][2][''value'']}"><strong>{[''object1''][''fields''][2][''value'']}</strong></atm-if><atm-if what="{[''object1''][''fields''][3][''value'']}"><br /><br />{[''object1''][''fields''][3][''htmlvalue'']}</atm-if></atm-rss-item-content>\r\n				<atm-rss-item-date>{[''object1''][''formatedDateStart'']|rss}</atm-rss-item-date>\r\n				<atm-rss-item-category>{[''object1''][''fields''][5][''label'']}</atm-rss-item-category>\r\n			</atm-rss-item>\r\n		</atm-result>\r\n	</atm-search>\r\n</atm-rss>', '<?php\n//Generated by : $Id: automne4-data.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $\n$content = "";\n$replace = "";\nif (!is_array($objectDefinitions)) $objectDefinitions = array();\n$parameters[''objectID''] = 1;\nif (!isset($cms_language)) $cms_language = new CMS_language(''fr'');\n$parameters[''public''] = true;\nif (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\nif (!is_array($object)) $object = array();\nif (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters[''public'']);\n$parameters[''module''] = ''pnews'';\n//RSS TAG START 2_e58559\nif (!sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n	CMS_grandFather::_raiseError(''Error into atm-rss tag : can\\''t found object infos to use into : $parameters[\\''objectID\\'']'');\n} else {\n	//SEARCH news TAG START 3_9d51c0\n	$objectDefinition_news = ''1'';\n	if (!isset($objectDefinitions[$objectDefinition_news])) {\n		$objectDefinitions[$objectDefinition_news] = &new CMS_poly_object_definition($objectDefinition_news);\n	}\n	//public search ?\n	$public_3_9d51c0 = $public_search;\n	//get search params\n	$search_news = &new CMS_object_search($objectDefinitions[$objectDefinition_news], $public_3_9d51c0);\n	$launchSearch_news = true;\n	//add search conditions if any\n	$search_news->setAttribute(''itemsPerPage'', (int) CMS_polymod_definition_parsing::replaceVars("20", $replace));\n	//RESULT news TAG START 4_d93f0e\n	//launch search news if not already done\n	if($launchSearch_news && !isset($results_news)) {\n		if (isset($search_news)) {\n			$results_news = $search_news->search();\n		} else {\n			CMS_grandFather::_raiseError("malformed atm-result tag : can''t use this tag outside of atm-search \\"news\\" tag ...");\n			$results_news = array();\n		}\n	} elseif (!$launchSearch_news) {\n		$results_news = array();\n	}\n	if ($results_news) {\n		$object_4_d93f0e = &$object[$objectDefinition_news]; //save previous object search if any\n		$replace_4_d93f0e = $replace; //save previous replace vars if any\n		$count_4_d93f0e = 0;\n		$content_4_d93f0e = $content; //save previous content var if any\n		$maxPages = $search_news->getMaxPages();\n		$maxResults = $search_news->getNumRows();\n		foreach ($results_news as $object[$objectDefinition_news]) {\n			$content = "";\n			$replace["atm-search"] = array (\n				"{firstresult}" => (!$count_4_d93f0e) ? 1 : 0,\n				"{lastresult}" 	=> ($count_4_d93f0e == sizeof($results_news)-1) ? 1 : 0,\n				"{resultcount}" => ($count_4_d93f0e+1),\n				"{maxpages}" 	=> $maxPages,\n				"{currentpage}" => ($search_news->getAttribute(''page'')+1),\n				"{maxresults}"	=> $maxResults,\n			);\n			//RSS-ITEM TAG START 5_3b4bc5\n			$content .= ''<item>\n			<guid isPermaLink="false">object''.$parameters[''objectID''].''-''.$object[$parameters[''objectID'']]->getID().''</guid>'';\n			//RSS-ITEM-LINK TAG START 6_611470\n			$content .= ''<link>'';\n			//save content\n			$content_6_611470 = $content;\n			$content = '''';\n			$content .=cms_tree::getPageValue("5","url")."?item=".$object[1]->getValue(''id'','''');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_6_611470.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</link>'';\n			//RSS-ITEM-LINK TAG END 6_611470\n			//RSS-ITEM-TITLE TAG START 7_207336\n			$content .= ''<title>'';\n			//save content\n			$content_7_207336 = $content;\n			$content = '''';\n			$content .=$object[1]->_objectValues[1]->getValue(''label'','''');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_7_207336.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</title>'';\n			//RSS-ITEM-TITLE TAG END 7_207336\n			//RSS-ITEM-DESCRIPTION TAG START 8_e69112\n			$content .= ''<description>'';\n			$content .= ''<![CDATA['';\n			//IF TAG START 9_2a55ca\n			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->_objectValues[4]->getValue(''imageName'','''')), $replace);\n			if ($ifcondition) {\n				$func = create_function("","return (".$ifcondition.");");\n				if ($func()) {\n					$content .=$object[1]->_objectValues[4]->getValue(''imageHTML'','''');\n				}\n			}//IF TAG END 9_2a55ca\n			//IF TAG START 10_597f77\n			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->_objectValues[2]->getValue(''value'','''')), $replace);\n			if ($ifcondition) {\n				$func = create_function("","return (".$ifcondition.");");\n				if ($func()) {\n					$content .="<strong>".$object[1]->_objectValues[2]->getValue(''value'','''')."</strong>";\n				}\n			}//IF TAG END 10_597f77\n			//IF TAG START 11_fb6fcd\n			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->_objectValues[3]->getValue(''value'','''')), $replace);\n			if ($ifcondition) {\n				$func = create_function("","return (".$ifcondition.");");\n				if ($func()) {\n					$content .="<br /><br />".$object[1]->_objectValues[3]->getValue(''htmlvalue'','''');\n				}\n			}//IF TAG END 11_fb6fcd\n			$content .= '']]>'';\n			$content .= ''</description>'';\n			//RSS-ITEM-DESCRIPTION TAG END 8_e69112\n			//RSS-ITEM-PUBDATE TAG START 12_e22af4\n			$content .= ''<pubDate>'';\n			//save content\n			$content_12_e22af4 = $content;\n			$content = '''';\n			$content .=$object[1]->getValue(''formatedDateStart'',''rss'');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_12_e22af4.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</pubDate>'';\n			//RSS-ITEM-PUBDATE TAG END 12_e22af4\n			//RSS-ITEM-CATEGORY TAG START 13_2349c6\n			$content .= ''<category>'';\n			//save content\n			$content_13_2349c6 = $content;\n			$content = '''';\n			$content .=$object[1]->_objectValues[5]->getValue(''label'','''');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_13_2349c6.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</category>'';\n			//RSS-ITEM-CATEGORY TAG END 13_2349c6\n			$content .= ''</item>'';\n			//RSS-ITEM TAG END 5_3b4bc5\n			$count_4_d93f0e++;\n			//do all result vars replacement\n			$content_4_d93f0e.= CMS_polymod_definition_parsing::replaceVars($content, $replace);\n		}\n		$content = $content_4_d93f0e; //retrieve previous content var if any\n		$replace = $replace_4_d93f0e; //retrieve previous replace vars if any\n		$object[$objectDefinition_news] = &$object_4_d93f0e; //retrieve previous object search if any\n	}\n	//RESULT news TAG END 4_d93f0e\n	//destroy search and results news objects\n	unset($search_news);\n	unset($results_news);\n	//SEARCH news TAG END 3_9d51c0\n}\n//RSS TAG END 2_e58559\necho CMS_polymod_definition_parsing::replaceVars($content, $replace);\n?>', '2007-09-20 10:13:39');

-- 
-- Dumping data for table `mod_standard_clientSpaces_archived`
-- 


-- 
-- Dumping data for table `mod_standard_clientSpaces_deleted`
-- 


-- 
-- Dumping data for table `mod_standard_clientSpaces_edited`
-- 

INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (22, 'center-1', '767d1164bc82edaf0101cc6e17b0cdab', 44, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (22, 'gauche-1', 'baf3a6a3c83201a424f89ae724c4c2a4', 44, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'center-1', '312620b9f6a33a5e2064b28f0da38972', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'center-1', '5bc67447f23f433ab70a58c6842ff1f9', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'center-1', 'e200c1a9cbf36731f79136ca50f89f48', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'center-1', 'ca7745927f80a75b785d09cd2d6d24ca', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'center-1', '87962463b938f07542808268a646cde1', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'gauche-1', '057a252fe3445ac5d19daec08c1abd4b', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (26, 'gauche-1', '884f0e5d97b4c88a15069bc743b72d04', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'center-1', '7eee1b56a131d9eff9fa91b963e75922', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'center-1', '2f22c3c48c9cc9cf920f9a2d450cde31', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'center-1', '18cd67d446807e0e2ea17a1a1f9f54b7', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (27, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (28, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (29, 'center-1', 'a57beb9be7b004cbfd4845d591dbebb40', 56, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '18cd67d446807e0e2ea17a1a1f9f54b7', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '2f22c3c48c9cc9cf920f9a2d450cde31', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '7eee1b56a131d9eff9fa91b963e75922', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (52, 'center-1', 'd2a1cec85f1abbc2d05465c72ab1c0ff', 54, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'ad77cbd191b4980f76ab6158000a79b2a', 43, 5);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a7676475a99cfa897a228910539c967c9', 44, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a7dc8dcd336f697c2b237958b2339d4be', 43, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '2f22c3c48c9cc9cf920f9a2d450cde31', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '7eee1b56a131d9eff9fa91b963e75922', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '18cd67d446807e0e2ea17a1a1f9f54b7', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'center-1', '78d78979d868517dd4fef947c432f91f', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'center-1', '26bfc25da40ba8f17f3a1080bfb3fe5a', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'center-1', 'fcd265158a36f90a71dc320b1c840aa1', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'center-1', 'e07836e4908165abecaa90d49fa8e6d4', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'center-1', '6cd84fb4af33bc828a7ff1e4b22fc88e', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'gauche-1', 'b1470ed0ff588937cc9b6e3d6cf4dc8c', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (40, 'gauche-1', '64c90a47d9bf53a53c7a652122bf77c3', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (41, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'gauche-1', 'b1470ed0ff588937cc9b6e3d6cf4dc8c', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'gauche-1', '64c90a47d9bf53a53c7a652122bf77c3', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '78d78979d868517dd4fef947c432f91f', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '26bfc25da40ba8f17f3a1080bfb3fe5a', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', 'fcd265158a36f90a71dc320b1c840aa1', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', 'e07836e4908165abecaa90d49fa8e6d4', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '6cd84fb4af33bc828a7ff1e4b22fc88e', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a3dca76f7921c46ca238f5e24e7a206a8', 44, 5);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a8382fb4beb05798080f08fe9e6664ebf', 43, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'e200c1a9cbf36731f79136ca50f89f48', 46, 3);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a45b3f02ce891ee839a7779056bf3a92a', 43, 2);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', '5bc67447f23f433ab70a58c6842ff1f9', 45, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', '312620b9f6a33a5e2064b28f0da38972', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'center-1', '648c715da08c46777e6d870b8fd963d6', 55, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (29, 'center-1', '767d1164bc82edaf0101cc6e17b0cdab', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (49, 'center-1', 'a67aff64b2377bff89aaa8842fc4eb522', 57, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (49, 'gauche-1', 'ae395d916b2cc75b0a3d4508cf92b6f07', 58, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (54, 'gauche-1', 'a8b94aec6f03fd9ab5b88e3d75447f8f4', 59, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (54, 'center-1', 'a9e4f1391c4bb33f5c551bd08a26c119c', 60, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'gauche-1', '057a252fe3445ac5d19daec08c1abd4b', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'gauche-1', '884f0e5d97b4c88a15069bc743b72d04', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a83c27402b936960393834bf42204813a', 44, 6);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a00f6daba57c838e9ead9c860c2b0a7b4', 43, 7);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'ac58bed77d343c51f627dc1ee62d6eafa', 44, 8);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_edited (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);

-- 
-- Dumping data for table `mod_standard_clientSpaces_edition`
-- 


-- 
-- Dumping data for table `mod_standard_clientSpaces_public`
-- 

INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (29, 'center-1', '767d1164bc82edaf0101cc6e17b0cdab', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '7eee1b56a131d9eff9fa91b963e75922', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '2f22c3c48c9cc9cf920f9a2d450cde31', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a3dca76f7921c46ca238f5e24e7a206a8', 44, 5);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a8382fb4beb05798080f08fe9e6664ebf', 43, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'e200c1a9cbf36731f79136ca50f89f48', 46, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', 'a45b3f02ce891ee839a7779056bf3a92a', 43, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', '5bc67447f23f433ab70a58c6842ff1f9', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'center-1', '312620b9f6a33a5e2064b28f0da38972', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (52, 'center-1', 'd2a1cec85f1abbc2d05465c72ab1c0ff', 54, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'ad77cbd191b4980f76ab6158000a79b2a', 43, 5);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a83c27402b936960393834bf42204813a', 44, 6);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a00f6daba57c838e9ead9c860c2b0a7b4', 43, 7);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'ac58bed77d343c51f627dc1ee62d6eafa', 44, 8);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '18cd67d446807e0e2ea17a1a1f9f54b7', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '2f22c3c48c9cc9cf920f9a2d450cde31', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', '7eee1b56a131d9eff9fa91b963e75922', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', 'f60304f2f17ad19ba276ba603db111d7', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'center-1', 'ba8b17a6191f969b5d7cddeb09ff95b8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'gauche-1', 'b1470ed0ff588937cc9b6e3d6cf4dc8c', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'gauche-1', '64c90a47d9bf53a53c7a652122bf77c3', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '78d78979d868517dd4fef947c432f91f', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '26bfc25da40ba8f17f3a1080bfb3fe5a', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', 'fcd265158a36f90a71dc320b1c840aa1', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', 'e07836e4908165abecaa90d49fa8e6d4', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (43, 'center-1', '6cd84fb4af33bc828a7ff1e4b22fc88e', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (44, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (45, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '55f215aa94fbaa862ce5a67c4c3a2c7a', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '4c133bfdd1b51d0818293a0f95e3740c', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '4bf134bebd16269445386ab432bd4c58', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', 'e1a09fbfc73d1eb8db34631d825ef1d0', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'center-1', '382d2cc5c036e6566abba4b6ebabe142', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'gauche-1', '74eb8a4731fbc6bce06e5cb4f63993a5', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (46, 'gauche-1', 'c10a87dd57a826f1050681bbcb0a6a86', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', 'c77917cec0f461e9a9d370b26c7daf8a', 47, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'gauche-1', '923759bb49690b3c0cb9481cdc85f1e8', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (47, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'center-1', '648c715da08c46777e6d870b8fd963d6', 55, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'gauche-1', '4add1ed7e3e4ebac2f0a92497b1e3c13', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (53, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (29, 'center-1', 'a57beb9be7b004cbfd4845d591dbebb40', 56, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (49, 'center-1', 'a67aff64b2377bff89aaa8842fc4eb522', 57, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (49, 'gauche-1', 'ae395d916b2cc75b0a3d4508cf92b6f07', 58, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (54, 'gauche-1', 'a8b94aec6f03fd9ab5b88e3d75447f8f4', 59, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (54, 'center-1', 'a9e4f1391c4bb33f5c551bd08a26c119c', 60, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (30, 'center-1', '18cd67d446807e0e2ea17a1a1f9f54b7', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'gauche-1', '057a252fe3445ac5d19daec08c1abd4b', 43, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (51, 'gauche-1', '884f0e5d97b4c88a15069bc743b72d04', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a7676475a99cfa897a228910539c967c9', 44, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'a7dc8dcd336f697c2b237958b2339d4be', 43, 3);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'bb2fe0b07c15772f3337f8f753353b51', 46, 2);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', 'd0a3efa38a0d7fb343836b7e644f82d9', 43, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'center-1', '800812be426455ff6024bc14af5b532e', 45, 0);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (35, 'gauche-1', '439d70e88ddc76241f66a5feb1394a99', 44, 1);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (36, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (37, 'center-1', '0be71ec976056594abae79b14949a3a1', 47, 4);
INSERT INTO mod_standard_clientSpaces_public (template_cs, tagID_cs, rowsDefinition_cs, type_cs, order_cs) VALUES (38, 'gauche-1', '79f8e2e58b93d26056e27de34ac9f870', 44, 1);

-- 
-- Dumping data for table `mod_standard_rows`
-- 

INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (25, '000 Exemple', 'r25_Complet.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (46, '220 Texte et Image Gauche', 'r46_220_Texte_et_Image_Gauche.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (45, '210 Texte et Image Droite', 'r45_210_Texte__image_droite.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (44, '200 Texte', 'r44_200_Texte.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (43, '110 Sous Titre', 'r43_100_Sous_Titre.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (42, '100 Titre', 'r42_000_Titre.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (47, '400 Télécharger un fichier', 'r47_400_Telecharger_un_fichier.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (48, '300 Image Centrée', 'r48_300_Image_Centree.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (49, '410 Animation Flash', 'r49_500_Animation_Flash.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (54, '700 Plan du site', 'r54_700_Plan_du_site.xml', 'standard', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (55, '800 Formulaire', 'r55_800_Formulaire.xml', 'cms_forms', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (56, '600 Actualités : Dernières actualités FR', 'r56_600_Dernieres_actualites_FR.xml', 'pnews', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (57, '610 Actualités : Résultats de recherche FR', 'r57_605_Actualites__Resultat_de_recherche_FR.xml', 'pnews', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (58, '605 Actualités : Recherche FR', 'r58_610_Actualites__Recherche_FR.xml', 'pnews', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (59, '500 Gestion documentaire : Recherche FR', 'r59_500_Base_documentaire__Recherche_FR.xml', 'pdocs', '');
INSERT INTO mod_standard_rows (id_row, label_row, definitionFile_row, modulesStack_row, groupsStack_row) VALUES (60, '510 Gestion documentaire : Résultats de recherche FR', 'r60_510_Gestion_documentaire__Recherche_FR.xml', 'pdocs', '');

-- 
-- Dumping data for table `mod_subobject_date_deleted`
-- 


-- 
-- Dumping data for table `mod_subobject_date_edited`
-- 


-- 
-- Dumping data for table `mod_subobject_date_public`
-- 


-- 
-- Dumping data for table `mod_subobject_integer_deleted`
-- 


-- 
-- Dumping data for table `mod_subobject_integer_edited`
-- 

INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 0, 0, 34);
INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 5, 0, 3);
INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 2, 0, 0, 37);
INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (4, 2, 7, 0, 12);
INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (5, 2, 10, 3, 1);
INSERT INTO mod_subobject_integer_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (6, 2, 7, 1, 13);

-- 
-- Dumping data for table `mod_subobject_integer_public`
-- 

INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 5, 0, 3);
INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 0, 0, 34);
INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (5, 2, 10, 3, 1);
INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (4, 2, 7, 0, 12);
INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 2, 0, 0, 37);
INSERT INTO mod_subobject_integer_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (6, 2, 7, 1, 13);

-- 
-- Dumping data for table `mod_subobject_string_deleted`
-- 


-- 
-- Dumping data for table `mod_subobject_string_edited`
-- 

INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 1, 0, 'Automne 3.3.1');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 4, 0, 'r1_4_logo-automne_thumbnail.png');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 1, 4, 1, 'Automne');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (4, 1, 4, 2, '');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (5, 2, 6, 0, 'Logo Automne');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (6, 2, 8, 0, 'fr');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (7, 2, 10, 0, 'Logo Automne');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (8, 2, 10, 1, '');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (9, 2, 10, 2, '0');
INSERT INTO mod_subobject_string_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (10, 2, 10, 4, 'r2_10_logo-automne.png');

-- 
-- Dumping data for table `mod_subobject_string_public`
-- 

INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (4, 1, 4, 2, '');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 1, 4, 1, 'Automne');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 4, 0, 'r1_4_logo-automne_thumbnail.png');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 1, 0, 'Automne 3.3.1');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (8, 2, 10, 1, '');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (7, 2, 10, 0, 'Logo Automne');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (6, 2, 8, 0, 'fr');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (5, 2, 6, 0, 'Logo Automne');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (9, 2, 10, 2, '0');
INSERT INTO mod_subobject_string_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (10, 2, 10, 4, 'r2_10_logo-automne.png');

-- 
-- Dumping data for table `mod_subobject_text_deleted`
-- 


-- 
-- Dumping data for table `mod_subobject_text_edited`
-- 

INSERT INTO mod_subobject_text_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 2, 0, '<p>La nouvelle version d''Automne est disponible. Plein de nouveaut&eacute;s et de modifications ont &eacute;t&eacute; apport&eacute;es ...</p>');
INSERT INTO mod_subobject_text_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 3, 0, '<ul>\r\n	<li>Ajout de la notion de brouillon pour l''&eacute;dition des pages : Vous pouvez &eacute;diter plusieurs fois votre page puis d&eacute;cider quand elle doit &ecirc;tre soumise au syst&egrave;me de validation pour sa publication en ligne.</li>\r\n	<li>Gestion des fichiers li&eacute;s aux images.</li>\r\n	<li>Int&eacute;gration de la derni&egrave;re version du g&eacute;n&eacute;rateur de modules : plus stable, il permet simplement l''int&eacute;gration de fonctionnalit&eacute;s Ajax. Il permet aussi la cr&eacute;ation simplifi&eacute;e de formulaires cot&eacute; client pour ajouter et modifier des objets sans utiliser l''administration d''Automne.</li>\r\n	<li>Int&eacute;gration de la derni&egrave;re version du module de formulaire pour modifier plus simplement les formulaires cr&eacute;&eacute;s &agrave; partir de l''assistant.</li>\r\n	<li>Tous les modules Automne int&eacute;gr&eacute;s dans le Wysiwyg permettent maintenant la modification par un clic droit sur l''&eacute;l&eacute;ment &agrave; modifier dans le Wysiwyg.</li>\r\n	<li>Optimisation de nombreuses fonctions pour rendre l''utilisation d''Automne et la navigation des pages du site encore plus fluide.</li>\r\n	<li>Et bien d''autres encore ...</li>\r\n</ul>');
INSERT INTO mod_subobject_text_edited (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 2, 9, 0, '<p>Ce fichier est une miniature du logo Automne</p>');

-- 
-- Dumping data for table `mod_subobject_text_public`
-- 

INSERT INTO mod_subobject_text_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (3, 2, 9, 0, '<p>Ce fichier est une miniature du logo Automne</p>');
INSERT INTO mod_subobject_text_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (1, 1, 2, 0, '<p>La nouvelle version d''Automne est disponible. Plein de nouveaut&eacute;s et de modifications ont &eacute;t&eacute; apport&eacute;es ...</p>');
INSERT INTO mod_subobject_text_public (id, objectID, objectFieldID, objectSubFieldID, value) VALUES (2, 1, 3, 0, '<ul>\r\n	<li>Ajout de la notion de brouillon pour l''&eacute;dition des pages : Vous pouvez &eacute;diter plusieurs fois votre page puis d&eacute;cider quand elle doit &ecirc;tre soumise au syst&egrave;me de validation pour sa publication en ligne.</li>\r\n	<li>Gestion des fichiers li&eacute;s aux images.</li>\r\n	<li>Int&eacute;gration de la derni&egrave;re version du g&eacute;n&eacute;rateur de modules : plus stable, il permet simplement l''int&eacute;gration de fonctionnalit&eacute;s Ajax. Il permet aussi la cr&eacute;ation simplifi&eacute;e de formulaires cot&eacute; client pour ajouter et modifier des objets sans utiliser l''administration d''Automne.</li>\r\n	<li>Int&eacute;gration de la derni&egrave;re version du module de formulaire pour modifier plus simplement les formulaires cr&eacute;&eacute;s &agrave; partir de l''assistant.</li>\r\n	<li>Tous les modules Automne int&eacute;gr&eacute;s dans le Wysiwyg permettent maintenant la modification par un clic droit sur l''&eacute;l&eacute;ment &agrave; modifier dans le Wysiwyg.</li>\r\n	<li>Optimisation de nombreuses fonctions pour rendre l''utilisation d''Automne et la navigation des pages du site encore plus fluide.</li>\r\n	<li>Et bien d''autres encore ...</li>\r\n</ul>');

-- 
-- Dumping data for table `modules`
-- 

INSERT INTO modules (id_mod, label_mod, codename_mod, administrationFrontend_mod, hasParameters_mod, isPolymod_mod) VALUES (1, 243, 'standard', '', 1, 0);
INSERT INTO modules (id_mod, label_mod, codename_mod, administrationFrontend_mod, hasParameters_mod, isPolymod_mod) VALUES (2, 1, 'cms_aliases', 'index.php', 0, 0);
INSERT INTO modules (id_mod, label_mod, codename_mod, administrationFrontend_mod, hasParameters_mod, isPolymod_mod) VALUES (3, 1, 'cms_forms', 'index.php', 1, 0);
INSERT INTO modules (id_mod, label_mod, codename_mod, administrationFrontend_mod, hasParameters_mod, isPolymod_mod) VALUES (4, 1, 'pnews', 'index.php', 0, 1);
INSERT INTO modules (id_mod, label_mod, codename_mod, administrationFrontend_mod, hasParameters_mod, isPolymod_mod) VALUES (5, 1, 'pdocs', 'index.php', 0, 1);

-- 
-- Dumping data for table `modulesCategories`
-- 

INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (1, 'cms_forms', 0, 0, '1', 1, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (2, 'pnews', 0, 0, '2', 2, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (3, 'pnews', 2, 2, '2;3', 1, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (4, 'pnews', 2, 2, '2;4', 2, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (5, 'pnews', 2, 2, '2;5', 3, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (6, 'pdocs', 0, 0, '6', 3, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (7, 'pdocs', 6, 6, '6;7', 1, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (8, 'pdocs', 10, 6, '6;10;8', 1, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (9, 'pdocs', 6, 6, '6;9', 2, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (10, 'pdocs', 6, 6, '6;10', 3, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (11, 'pdocs', 10, 6, '6;10;11', 2, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (12, 'pdocs', 6, 6, '6;12', 4, '');
INSERT INTO modulesCategories (id_mca, module_mca, parent_mca, root_mca, lineage_mca, order_mca, icon_mca) VALUES (13, 'pdocs', 6, 6, '6;13', 5, '');

-- 
-- Dumping data for table `modulesCategories_clearances`
-- 

INSERT INTO modulesCategories_clearances (id_mcc, profile_mcc, category_mcc, clearance_mcc) VALUES (9, 1, 2, 3);
INSERT INTO modulesCategories_clearances (id_mcc, profile_mcc, category_mcc, clearance_mcc) VALUES (8, 1, 1, 3);
INSERT INTO modulesCategories_clearances (id_mcc, profile_mcc, category_mcc, clearance_mcc) VALUES (10, 1, 6, 3);

-- 
-- Dumping data for table `modulesCategories_i18nm`
-- 

INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (3, 1, 'en', '', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (4, 1, 'fr', 'Formulaire', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (7, 2, 'en', '', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (8, 2, 'fr', 'Actualités', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (11, 3, 'en', '', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (12, 3, 'fr', 'Brèves', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (19, 4, 'en', '', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (20, 4, 'fr', 'Personnel', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (23, 5, 'en', '', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (24, 5, 'fr', 'A voir', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (27, 6, 'en', 'Documents', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (28, 6, 'fr', 'Documents', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (35, 7, 'en', 'Presentation', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (36, 7, 'fr', 'Présentation', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (55, 8, 'en', 'Press release', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (56, 8, 'fr', 'Communiqué', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (47, 9, 'en', 'Product datasheet', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (48, 9, 'fr', 'Fiche produit', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (51, 10, 'en', 'Press', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (52, 10, 'fr', 'Presse', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (59, 11, 'en', 'Press kit', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (60, 11, 'fr', 'Dossier', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (63, 12, 'en', 'Resources', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (64, 12, 'fr', 'Ressources', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (67, 13, 'en', 'Miscellaneous', '', '');
INSERT INTO modulesCategories_i18nm (id_mcl, category_mcl, language_mcl, label_mcl, description_mcl, file_mcl) VALUES (68, 13, 'fr', 'Divers', '', '');

-- 
-- Dumping data for table `pageTemplates`
-- 

INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (22, 'FR - Accueil', 'fr', 'standard', 'pt22_accueil.xml', 0, 0, 'pt22_accueil.jpg', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (26, 'FR - Fleuve', 'fr', 'standard', 'pt26_page_interieure_fleuve.xml', 0, 0, 'pt26_fleuve.jpg', 1, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (27, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 0, 'pt27_foret.jpg', 1, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (28, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 0, 'pt28_feux.jpg', 1, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (29, 'FR - Accueil', 'fr', 'standard', 'pt22_accueil.xml', 0, 1, '', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (30, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 1, 'pt27_foret.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (52, 'FR - Fleuve', 'fr', 'standard', 'pt26_page_interieure_fleuve.xml', 0, 1, 'pt26_fleuve.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (35, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (36, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (37, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (38, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 1, 'pt27_foret.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (39, 'EN - Home Page', 'en', 'standard', 'pt39_Home.xml', 0, 0, 'pt39_accueil.jpg', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (45, 'EN - River', 'en', 'standard', 'pt41_Interior_River.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (40, 'EN - Fire', 'en', 'standard', 'pt40_Interior_Fire.xml', 0, 0, 'pt40_feux.jpg', 1, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (41, 'EN - River', 'en', 'standard', 'pt41_Interior_River.xml', 0, 0, 'pt41_fleuve.jpg', 1, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (42, 'EN - Home Page', 'en', 'standard', 'pt39_Home.xml', 0, 1, '', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (43, 'EN - Fire', 'en', 'standard', 'pt40_Interior_Fire.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (44, 'EN - River', 'en', 'standard', 'pt41_Interior_River.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (46, 'EN - River', 'en', 'standard', 'pt41_Interior_River.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (47, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 1, '', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (48, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 0, '');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (49, 'FR - Feux', 'fr', 'standard', 'pt28_page_interieure_feux.xml', 0, 1, 'pt28_feux.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (51, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 1, 'pt27_foret.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (53, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 1, 'pt27_foret.jpg', 0, 'center-1;gauche-1');
INSERT INTO pageTemplates (id_pt, label_pt, groupsStack_pt, modulesStack_pt, definitionFile_pt, creator_pt, private_pt, image_pt, inUse_pt, printingCSOrder_pt) VALUES (54, 'FR - Forêt', 'fr', 'standard', 'pt27_page_interieure_foret.xml', 0, 1, 'pt27_foret.jpg', 0, 'center-1;gauche-1');

-- 
-- Dumping data for table `pages`
-- 

INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (1, 1, '1', '2005-05-30', 1, '2007-09-20 15:58:44', '1-automne-demo.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (2, 17, '', '2005-05-30', 29, '2007-09-20 16:27:46', '2-accueil.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (3, 18, '1;1', '2005-05-30', 30, '2007-09-20 16:37:34', '3-presentation-automne.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (4, 19, '1;1', '2005-05-30', 51, '2007-09-20 16:27:35', '4-pre-requis.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (5, 20, '1', '2005-05-30', 49, '2007-09-20 16:27:37', '5-actualites.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (6, 21, '1;1', '2005-05-30', 53, '2007-09-20 16:27:38', '6-contact.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (7, 22, '1', '2005-05-30', 52, '2007-09-20 16:37:35', '7-plan-du-site.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (8, 23, '1', '2005-05-30', 35, '2007-09-20 16:37:32', '8-fonctionnalites.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (9, 24, '1;1', '2005-05-30', 36, '2007-09-20 16:37:32', '9-gestion-de-contenu.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (10, 25, '1;1', '2005-05-30', 37, '2007-09-20 16:37:37', '10-gestion-utilisateurs.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (11, 26, '1;1', '2005-05-30', 38, '2007-09-20 16:37:38', '11-architecture-et-gestion-technique.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (12, 27, '1;1', '2005-05-30', 42, '2007-09-20 15:59:00', '12-home.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (13, 28, '1', '2005-05-30', 43, '2007-09-20 15:59:02', '13-automne-features.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (14, 29, '1', '2005-05-30', 44, '2007-09-20 15:59:03', '14-user-administration.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (15, 30, '1;1', '2005-05-30', 45, '2007-09-20 15:59:05', '15-rights-administration.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (16, 31, '1;1', '2005-05-30', 46, '2007-09-20 15:59:06', '16-workflow-collaboration.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (17, 32, '1;1', '2005-05-30', 47, '2007-09-20 15:59:08', '17-template-administration.php');
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (18, 36, '1', '2007-09-20', 54, '2007-09-20 16:27:49', '18-documents.php');

-- 
-- Dumping data for table `pagesBaseData_archived`
-- 


-- 
-- Dumping data for table `pagesBaseData_deleted`
-- 


-- 
-- Dumping data for table `pagesBaseData_edited`
-- 

INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Automne-Install', 'Automne-Install', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '1|2|http://||_top|||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (2, 2, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (3, 3, 'Présentation Automne', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (4, 4, 'Pré-requis', 'Pré-requis', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (5, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (6, 6, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (7, 7, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (8, 8, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (9, 9, 'Gestion de contenu', 'Gestion de contenu', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (10, 10, 'Gestion utilisateurs', 'Gestion utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (11, 11, 'Architecture et Gestion Technique', 'Architecture et Gestion Technique', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (12, 12, 'Home', 'Home', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (13, 13, 'Automne Features', 'Features', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (14, 14, 'User Administration', 'User Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (15, 15, 'Rights Administration', 'Rights Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (16, 16, 'Workflow collaboration', 'Workflow collaboration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (17, 17, 'Template Administration', 'Template Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (18, 18, 'Documents', 'Documents', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '|||||||', 0, '');

-- 
-- Dumping data for table `pagesBaseData_public`
-- 

INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Automne-Install', 'Automne-Install', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '1|2|http://||_top|||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (2, 2, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (3, 3, 'Présentation Automne', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (4, 4, 'Pré-requis', 'Pré-requis', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (6, 6, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (7, 7, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (9, 9, 'Gestion de contenu', 'Gestion de contenu', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (10, 10, 'Gestion utilisateurs', 'Gestion utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (11, 11, 'Architecture et Gestion Technique', 'Architecture et Gestion Technique', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (12, 12, 'Home', 'Home', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (13, 13, 'Automne Features', 'Features', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (14, 14, 'User Administration', 'User Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (15, 15, 'Rights Administration', 'Rights Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (16, 16, 'Workflow collaboration', 'Workflow collaboration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (17, 17, 'Template Administration', 'Template Administration', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (5, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (18, 18, 'Documents', 'Documents', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '|||||||', 0, '');
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (8, 8, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');

-- 
-- Dumping data for table `profileUsersByGroup`
-- 


-- 
-- Dumping data for table `profiles`
-- 

INSERT INTO profiles (id_pr, templateGroupsDeniedStack_pr, rowGroupsDeniedStack_pr, pageClearancesStack_pr, moduleClearancesStack_pr, validationClearancesStack_pr, administrationClearance_pr, alertLevel_pr) VALUES (1, '', '', '1,2', 'standard,2;cms_aliases,2;pnews,2;cms_forms,2', 'standard', 63, 1);
INSERT INTO profiles (id_pr, templateGroupsDeniedStack_pr, rowGroupsDeniedStack_pr, pageClearancesStack_pr, moduleClearancesStack_pr, validationClearancesStack_pr, administrationClearance_pr, alertLevel_pr) VALUES (3, 'fr;en', '', '1,1', '', '', 0, 2);

-- 
-- Dumping data for table `profilesUsers`
-- 

INSERT INTO profilesUsers (id_pru, login_pru, password_pru, firstName_pru, lastName_pru, contactData_pru, profile_pru, language_pru, textEditor_pru, dn_pru, active_pru, deleted_pru) VALUES (1, 'root', '3b0d99b9bb927794036aa828050f364d', '', 'Super administrateur', 1, 1, 'fr', 'fckeditor', '', 1, 0);
INSERT INTO profilesUsers (id_pru, login_pru, password_pru, firstName_pru, lastName_pru, contactData_pru, profile_pru, language_pru, textEditor_pru, dn_pru, active_pru, deleted_pru) VALUES (3, 'anonymous', '294de3557d9d00b3d2d8a1e6aab028cf', '', 'Public user', 3, 3, 'fr', 'none', '', 1, 0);

-- 
-- Dumping data for table `profilesUsersGroups`
-- 


-- 
-- Dumping data for table `profilesUsers_validators`
-- 

INSERT INTO profilesUsers_validators (id_puv, userId_puv, module_puv) VALUES (1, 1, 'standard');

-- 
-- Dumping data for table `regenerator`
-- 


-- 
-- Dumping data for table `resourceStatuses`
-- 

INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (1, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (17, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (18, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (19, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (20, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (21, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (22, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (23, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (24, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (25, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (26, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (27, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (28, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (29, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (30, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (31, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (32, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (33, 1, 0, 0, 0, 1, '2007-09-20', '2008-07-01');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (34, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (35, 3, 0, 2, 0, 1, '2007-07-24', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (36, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');
INSERT INTO resourceStatuses (id_rs, location_rs, proposedFor_rs, editions_rs, validationsRefused_rs, publication_rs, publicationDateStart_rs, publicationDateEnd_rs) VALUES (37, 1, 0, 0, 0, 2, '2007-09-20', '0000-00-00');

-- 
-- Dumping data for table `resourceValidations`
-- 


-- 
-- Dumping data for table `resources`
-- 

INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (1, 1, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (17, 17, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (18, 18, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (19, 19, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (20, 20, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (21, 21, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (22, 22, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (23, 23, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (24, 24, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (25, 25, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (26, 26, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (27, 27, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (28, 28, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (29, 29, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (30, 30, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (31, 31, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (32, 32, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (33, 33, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (34, 34, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (35, 35, '1,2');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (36, 36, '');
INSERT INTO resources (id_res, status_res, editorsStack_res) VALUES (37, 37, '');

-- 
-- Dumping data for table `scriptsStatuses`
-- 


-- 
-- Dumping data for table `sessions`
-- 


-- 
-- Dumping data for table `toolbars`
-- 

INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (1, 'Default', 'Default', 'Source|Separator1|FitWindow|Separator2|Preview|Templates|Separator3|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Print|Separator5|Undo|Redo|Separator6|Find|Replace|Separator7|SelectAll|RemoveFormat|Separator8|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator15|Style|FontFormat|FontSize|TextColor|BGColor|Separator16|automneLinks|polymod|Image');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (2, 'Basic', 'Basic', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Table|Rule|SpecialChar|Separator1');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (3, 'BasicLink', 'BasicLink', 'Source|Separator1|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator16|automneLinks|polymod');

-- 
-- Dumping data for table `websites`
-- 

INSERT INTO websites (id_web, label_web, url_web, root_web, keywords_web, description_web, category_web, author_web, replyto_web, copyright_web, language_web, robots_web, favicon_web, order_web) VALUES (1, 'Site principal', '127.0.0.1', 1, '', '', '', '', '', '', 'fr', '', '/favicon.ico', 3);
INSERT INTO websites (id_web, label_web, url_web, root_web, keywords_web, description_web, category_web, author_web, replyto_web, copyright_web, language_web, robots_web, favicon_web, order_web) VALUES (2, 'fr', '127.0.0.1', 2, '', '', '', '', '', '', 'fr', '', '/favicon.ico', 1);
INSERT INTO websites (id_web, label_web, url_web, root_web, keywords_web, description_web, category_web, author_web, replyto_web, copyright_web, language_web, robots_web, favicon_web, order_web) VALUES (3, 'en', '127.0.0.1', 12, '', '', '', '', '', '', 'en', '', '/favicon.ico', 2);
