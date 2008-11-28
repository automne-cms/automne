-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-4
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Vendredi 28 Novembre 2008 à 16:14
-- Version du serveur: 5.0.32
-- Version de PHP: 4.4.4-8+etch6
-- 
-- Base de données: `automne4`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `I18NM_messages`
-- 

DROP TABLE IF EXISTS `I18NM_messages`;
CREATE TABLE `I18NM_messages` (
  `id` int(11) unsigned NOT NULL default '0',
  `module` varchar(50) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `fr` mediumtext NOT NULL,
  `en` mediumtext NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `I18NM_messages`
-- 

INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1418, 'standard', '2008-11-14 19:56:24', 'Cette page lie %s page(s).', 'This page targets %s page(s).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1419, 'standard', '2008-11-14 19:56:24', '[Erreur, le code XHTML n''est pas conforme à la syntaxe attendue. Merci de le corriger (%s)]', '[Error, XHTML code does not conform to the expected syntax. Please correct it (%s)]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1420, 'standard', '2008-11-14 19:56:24', 'Destination', 'Destination');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1421, 'standard', '2008-11-14 19:56:24', 'Edition du contenu en cours', 'Content edition in progress');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1422, 'standard', '2008-11-14 19:56:24', 'Soumettre à Validation', 'Submit for Validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1423, 'standard', '2008-11-14 19:56:24', 'Sauvegarder le contenu', 'Save content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1424, 'standard', '2008-11-14 19:56:24', 'Effacer le contenu', 'Delete content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1425, 'standard', '2008-11-14 19:56:24', 'Confirmer la suppression du contenu ?', 'Confirm content deletion?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1426, 'standard', '2008-11-14 19:56:24', 'Voir le contenu', 'Content preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1380, 'standard', '2008-11-14 19:56:24', 'Diminuer le retrait', 'Outdent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1378, 'standard', '2008-11-14 19:56:24', 'Liste Ordonnée', 'Ordered List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1379, 'standard', '2008-11-14 19:56:24', 'Liste non-ordonnée', 'Unordered List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1376, 'standard', '2008-11-14 19:56:24', 'Indice', 'Subscript');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1377, 'standard', '2008-11-14 19:56:24', 'Exposant', 'Superscript');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1375, 'standard', '2008-11-14 19:56:24', 'Barrer', 'Strike Through');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1372, 'standard', '2008-11-14 19:56:24', 'Gras', 'Bold');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1373, 'standard', '2008-11-14 19:56:24', 'Italique', 'Italic');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1374, 'standard', '2008-11-14 19:56:24', 'Souligner', 'Underline');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1370, 'standard', '2008-11-14 19:56:24', 'Tout sélectionner', 'Select All');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1371, 'standard', '2008-11-14 19:56:24', 'Supprimer le format', 'Remove format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1367, 'standard', '2008-11-14 19:56:24', 'Refaire', 'Redo');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1368, 'standard', '2008-11-14 19:56:24', 'Chercher', 'Search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1369, 'standard', '2008-11-14 19:56:24', 'Remplacer', 'Replace');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1366, 'standard', '2008-11-14 19:56:24', 'Annuler', 'Undo');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1365, 'standard', '2008-11-14 19:56:24', 'Imprimer', 'Print');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1360, 'standard', '2008-11-14 19:56:24', 'Couper', 'Cut');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1361, 'standard', '2008-11-14 19:56:24', 'Copier', 'Copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1362, 'standard', '2008-11-14 19:56:24', 'Coller', 'Paste');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1363, 'standard', '2008-11-14 19:56:24', 'Coller comme texte seul', 'Paste as plain text');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1364, 'standard', '2008-11-14 19:56:24', 'Coller depuis Word', 'Paste from Word');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1356, 'standard', '2008-11-14 19:56:24', 'Code Source', 'Source code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1357, 'standard', '2008-11-14 19:56:24', 'Edition pleine page', 'Edition fit window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1358, 'standard', '2008-11-14 19:56:24', 'Prévisualisation', 'Preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1359, 'standard', '2008-11-14 19:56:24', 'Modèles', 'Template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1353, 'standard', '2008-11-14 19:56:24', '[Erreur lors du réordonancement des sites ...]', '[Error during websites reorder...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1354, 'standard', '2008-11-14 19:56:24', 'Protéger les fichiers à télécharger.', 'Protect download files.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1355, 'standard', '2008-11-14 19:56:24', 'Avec cette option active pour le module, les fichiers à télécharger (fichiers PDF, images, etc.) seront filtrés avant tout téléchargement. Si des droits sont nécessaires à leur consultation, l''accès en sera interdit à toute personne n''ayant pas les autorisations suffisantes. De plus, le nom du fichier sera systématiquement nettoyé des données de contrôles ajoutées par Automne. Activer cette option entraîne une charge plus importante sur le serveur pour tous les téléchargements. Ne l''activez que si le besoin est réel.', 'With this option active for the module, the files to be downloaded (PDF files, images, etc) will be filtered before any downloading. If rights are necessary to their consultation, the access will be forbidden to any person not having the sufficient clearance. Moreover, the name of the file will be systematically cleaned of controls datas added by Automne. Activating this option involves a more important load on the server for all the downloading. Activate it only if the need is real.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1352, 'standard', '2008-11-14 19:56:24', 'Plusieurs sites peuvent partager le même domaine. Dans ce cas, le premier dans la liste ci-dessous sera prioritaire : Il s''affichera pour cette adresse de domaine.', 'Several websites can share the same domain. In this case, the first in the list below will have priority: It will be shown for this domain address.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1351, 'standard', '2008-11-14 19:56:24', 'Cet utilisateur appartient à un ou plusieurs groupes d''utilisateurs, ses droits dépendent de son appartenance à ces groupes d''utilisateurs.', 'This user belongs to one or more user groups, his rights depend on his membership of these user groups.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1347, 'standard', '2008-11-14 19:56:24', 'Accès aux pages pour l''utilisateur ''%s''', 'Pages access for user ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1348, 'standard', '2008-11-14 19:56:24', 'Racine des pages', 'Pages root');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1349, 'standard', '2008-11-14 19:56:24', 'Voir les accès au contenu des modules', 'View accesses to modules content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1350, 'standard', '2008-11-14 19:56:24', 'Accès aux catégories pour l''utilisateur ''%s''', 'Access to categories for user ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1344, 'standard', '2008-11-14 19:56:24', 'Valeur : /favicon.ico ou /img/favicon.png, etc.', 'Value : /favicon.ico or /img/favicon.png, ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1346, 'standard', '2008-11-14 19:56:24', 'Accès aux pages pour le groupe ''%s''', 'Pages access for group ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1345, 'standard', '2008-11-14 19:56:24', 'Module', 'Application');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1339, 'standard', '2008-11-14 19:56:24', 'Profondeur affichée', 'Displayed depth');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1340, 'standard', '2008-11-14 19:56:24', 'Visualisation des objets associés', 'Viewing associated objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1341, 'standard', '2008-11-14 19:56:24', 'Edition des objets associés', 'Edit associated objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1342, 'standard', '2008-11-14 19:56:24', 'Gestion des catégories', 'Categories management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1343, 'standard', '2008-11-14 19:56:24', 'Favicon', 'Favicon');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1338, 'standard', '2008-11-14 19:56:24', 'Inverser', 'Invert');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1335, 'standard', '2008-11-14 19:56:24', 'Les rangées de page appartiennent à un ou plusieurs groupes de rangées. Pour utiliser une rangée, un utilisateur doit avoir des droits sur tous les groupes de cette rangée.', 'Each row belong to one or more groups. For a user to be able to use a row, he or she must have usage rights for ALL the groups to which that row belongs to.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1336, 'standard', '2008-11-14 19:56:24', 'Aucun groupe', 'No group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1337, 'standard', '2008-11-14 19:56:24', '[Modification des groupes de rangées interdits]', '[Modification of unauthorized rows groups]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1334, 'standard', '2008-11-14 19:56:24', 'Rangées', 'Rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1333, 'standard', '2008-11-14 19:56:24', 'Modèles', 'Templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1331, 'standard', '2008-11-14 19:56:24', 'Stopper scripts', 'Stop scripts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1332, 'standard', '2008-11-14 19:56:24', 'Consulter l''aide en ligne', 'View online help');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1330, 'standard', '2008-11-14 19:56:24', 'Rafraîchir', 'Refresh');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1322, 'standard', '2008-11-14 19:56:24', 'Contenu / Rangées', 'Content / Rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1323, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de l''objet ''%s'' ?', 'Do you confirm deletion of the object ''%s''?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1324, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la sortie sans sauvegarder ?', 'Do you confirm exit without saving?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1325, 'standard', '2008-11-14 19:56:24', 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1326, 'standard', '2008-11-14 19:56:24', 'Scripts restants', 'Remaining scripts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1327, 'standard', '2008-11-14 19:56:24', 'Meta données par défaut pour le site :', 'Default meta datas for website:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1328, 'standard', '2008-11-14 19:56:24', 'Page', 'Page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1329, 'standard', '2008-11-14 19:56:24', 'Maximum %so', 'Maximum %sB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1321, 'standard', '2008-11-14 19:56:24', 'Chargement ...', 'Loading...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1320, 'standard', '2008-11-14 19:56:24', 'Verrouillé', 'Locked');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1319, 'standard', '2008-11-14 19:56:24', '[La page de destination sélectionnée est déjà la page père actuelle de la page à déplacer ...]', '[The destination page selected is already the father page of the page to move...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1318, 'standard', '2008-11-14 19:56:24', 'Adresse de la page en ligne. Vous pouvez la mettre à jour si vous modifiez le titre de la page mais attention ! Changer l''adresse de la page peut entraîner des problèmes de référencement sur les moteurs de recherche ainsi que des problèmes si d''autres sites lient cette page.', 'Address of this page online. You can update it if you change the title of the page but attention! If you Change page URL, this can cause problems of referencing on search engines and problems if other sites links to this page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1315, 'standard', '2008-11-14 19:56:24', 'Fermer la fenêtre d''administration', 'Close administration window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1316, 'standard', '2008-11-14 19:56:24', 'Administrer la page', 'Page administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1317, 'standard', '2008-11-14 19:56:24', 'Cochez pour mettre à jour l''adresse de la page (en fonction du titre donné à la page.)', 'Check to update page URL (Page URL will be updated using page title.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1314, 'standard', '2008-11-14 19:56:24', 'Minimiser la fenêtre d''administration', 'Minimize administration window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1313, 'standard', '2008-11-14 19:56:24', 'Maximiser la fenêtre d''administration', 'Maximize administration window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1312, 'standard', '2008-11-14 19:56:24', 'Vous ne pouvez créer de nouvelle page : Vous n''avez aucun droits d''utilisation sur aucun modèles de pages.', 'You cannot create of new page: You do not have any rights of use on any pages templates.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1311, 'standard', '2008-11-14 19:56:24', 'Vous n''avez aucun droits d''utilisation sur aucun modèles de pages.', 'You do not have any rights of use on any pages templates.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1310, 'standard', '2008-11-14 19:56:24', 'L''utilisateur %s fait parti du groupe %s. Modifier directement ses droits enlèvera l''utilisateur de ce groupe. Etes-vous sur de vouloir continuer ?', '%s user makes party of the group %s. Modify its rights directly will remove the user of this group. Do you want to continue?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1301, 'standard', '2008-11-14 19:56:24', 'Attention, l''utilisation d''un modèle incompatible peut entraîner la perte des données de la page.', 'Attention, using an unmatching template can involve the loss of all data of the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1309, 'standard', '2008-11-14 19:56:24', 'Le module est créé mais certaines erreurs se sont produites lors de la création des répertoires du module.\nVérifiez que les répertoires suivants existent et sont accessible en écriture :\n%s,\n%s,\n%s,\n%s', 'Module is created but some errors append for module directories creation.\nPlease check following directories exists and are writable :\n%s,\n%s,\n%s,\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1308, 'standard', '2008-11-14 19:56:24', '[Erreur : cet identifiant est déjà utilisé]', '[Error : this ID already used]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1307, 'standard', '2008-11-14 19:56:24', 'Maximum 20 caractères alphanumériques (a-z0-9) uniquement', 'Maximum 20 alphanumerics caracters (a-z0-9) only');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1306, 'standard', '2008-11-14 19:56:24', 'Identifiant (Codename)', 'ID (Codename)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1305, 'standard', '2008-11-14 19:56:24', 'Création d''une application', 'Application creation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1304, 'standard', '2008-11-14 19:56:24', 'Gestion de l''application ''%s''', '''%s'' application management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1302, 'standard', '2008-11-14 19:56:24', 'vers', 'to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1303, 'standard', '2008-11-14 19:56:24', 'page', 'page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1300, 'standard', '2008-11-14 19:56:24', 'Modèles non compatibles', 'Unmatching templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1299, 'standard', '2008-11-14 19:56:24', 'Modèles compatibles', 'Matching templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1298, 'standard', '2008-11-14 19:56:24', 'Accès des fichiers', 'Files accesses');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1297, 'standard', '2008-11-14 19:56:24', 'Syntaxe du libellé pour l''objet ''%s''', 'Label syntax for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1294, 'standard', '2008-11-14 19:56:24', 'Libellé composé', 'Made up label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1295, 'standard', '2008-11-14 19:56:24', 'Attribut ''module'' manquant sur un tag ''block''', 'Missing ''module'' attribute on ''block'' tag');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1296, 'standard', '2008-11-14 19:56:24', '[Erreur : syntaxe de rangée incorrecte : %s]', '[Error : malformed row syntax : %s]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1292, 'standard', '2008-11-14 19:56:24', 'Les informations grisées nécessiteront une recherche récursive.', 'Grayed informations will require a recursive search.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1293, 'standard', '2008-11-14 19:56:24', '[Erreur : vous n''avez pas les droits suffisant sur le module ''%s'' pour lui ajouter une rangée.]', '[Error: you do not have sufficient rights on the module ''%s'' to add a row to it.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1283, 'standard', '2008-11-14 19:56:24', '[Erreur durant la suppression de l''objet]', '[Error during object deletion]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1284, 'standard', '2008-11-14 19:56:24', 'Cliquez pour choisir une date', 'Clic to pick a date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1281, 'standard', '2008-11-14 19:56:24', 'Utilisation de l''objet par d''autres objets', 'Use of the object by other objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1282, 'standard', '2008-11-14 19:56:24', 'Oui par', 'Yes by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1283, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de l''objet ''%s'' ?', 'Do you confirm deletion of the object ''%s''?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1280, 'standard', '2008-11-14 19:56:24', 'Structure de l''objet ''%s''', '''%s'' object structure');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1279, 'standard', '2008-11-14 19:56:24', 'Structure', 'Structure');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1278, 'standard', '2008-11-14 19:56:24', '[Erreur durant la suppression du champ]', '[Error during field deletion]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1277, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la suppression du champ ''%s'' ? Attention cette suppression est définitive, elle n''est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce champ !', 'Do you confirm the deletion of the field ''%s''? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this field!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1276, 'standard', '2008-11-14 19:56:24', 'Pour les administrateurs seulement', 'Only for administrators');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1234, 'standard', '2008-11-14 19:56:24', 'Objet', 'Object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1235, 'standard', '2008-11-14 19:56:24', 'Champs', 'Fields');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1236, 'standard', '2008-11-14 19:56:24', 'Champ', 'Field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1237, 'standard', '2008-11-14 19:56:24', 'Edition / création d''un champ de données pour l''objet ''%s''', 'Edit / create data field for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1238, 'standard', '2008-11-14 19:56:24', 'Type de données', 'Data type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1239, 'standard', '2008-11-14 19:56:24', 'Champ requis', 'Required field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1240, 'standard', '2008-11-14 19:56:24', 'Visible coté client', 'Available in frontend');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1241, 'standard', '2008-11-14 19:56:24', 'Visible dans les résultats d''une recherche', 'Available in search results');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1242, 'standard', '2008-11-14 19:56:24', 'Ajouter au formulaire de recherche<br /><small>(ou effectuer la recherche par mot-clé sur ce champ)</small>', 'Add to search form<br /><small>(or search by keyword on this field)</small>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1243, 'standard', '2008-11-14 19:56:24', 'Paramètres', 'Parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1244, 'standard', '2008-11-14 19:56:24', 'Multiples', 'Multiples');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1247, 'standard', '2008-11-14 19:56:24', 'Objets simples', 'Standard objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1248, 'standard', '2008-11-14 19:56:24', 'Objets composés', 'Made up objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1267, 'standard', '2008-11-14 19:56:24', 'Associer', 'Associate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1268, 'standard', '2008-11-14 19:56:24', 'Désassocier', 'Disassociate ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1271, 'standard', '2008-11-14 19:56:24', 'Visible sur l''accueil du module ?', 'Visible on the index of the module?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1230, 'standard', '2008-11-14 19:56:24', 'Ressource', 'Ressource');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1231, 'standard', '2008-11-14 19:56:24', 'Ressource primaire', 'Primary resource');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1232, 'standard', '2008-11-14 19:56:24', 'Ressource secondaire', 'Secondary resource');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1233, 'standard', '2008-11-14 19:56:24', '<ul><li>Aucune : Cet objet ne sera pas soumis à validation. Son contenu apparaîtra en ligne dès sa saisie. Toute modification sera immédiate.</li><li>Ressource primaire : Ce type d''objet est soumis à validation. Son contenu n''apparaîtra en ligne qu''après validation par une personne autorisée.</li><li>Ressource secondaire : Ce type d''objet est soumis à la validation de la ressource primaire. Son contenu n''apparaîtra en ligne qu''après validation de la ressource primaire à laquelle il est directement attaché. Sans attache à une ressource primaire, il se comportera de la même manière qu''un objet sans ressource.</li></ul>', '<ul><li>None : This object will not be subjected to validation. Its contents will appear on line as of its seizure.</li><li>Primary resource : This type of object is subjected to validation. Its contents will appear on line only after validation by an authorized person.</li><li>Secondary resource : This type of object is subjected to the validation of the primary resource. Its contents will appear on line only after validation of the primary resource to which it is attached. Without attach to a primary resource, it will have the same behavior of an object without resource.</li></ul>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1223, 'standard', '2008-11-14 19:56:24', 'Catégorie supprimée', 'Deleted category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1224, 'standard', '2008-11-14 19:56:24', 'Gestion des Applications', 'Manage Applications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1225, 'standard', '2008-11-14 19:56:24', 'Application à éditer', 'Edit application');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1226, 'standard', '2008-11-14 19:56:24', 'Objet à éditer', 'Edit object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1227, 'standard', '2008-11-14 19:56:24', 'Objets', 'Objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1229, 'standard', '2008-11-14 19:56:24', 'Edition / création d''un objet', 'Edit / create object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1228, 'standard', '2008-11-14 19:56:24', 'Application', 'Application');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1221, 'standard', '2008-11-14 19:56:24', 'Syntaxe des modèles pour le module ''%s''', 'Templates syntax for the module ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1222, 'standard', '2008-11-14 19:56:24', '<strong> 	Titre de la page courante :<br />&lt;atm-title /&gt;</strong><br /><br /><strong> 	M&eacute;ta-donn&eacute;es de la page courante :<br />&lt;atm-meta-tags /&gt;</strong><br /><br /><strong> 	Valeur d''une constante (voir les fichiers de constantes d''Automne) :<br />&lt;atm-constant name=&quot;</strong>constantName<strong>&quot; /&gt;</strong><br /><ul><li><strong>constantName :</strong> Nom de la constante &agrave; afficher. </li></ul><strong> 	Lien(s) vers une ou plusieur pages :<br />&lt;atm-linx type=&quot;</strong>linxType<strong>&quot;&gt;</strong>linxDefinition<strong>&lt;/atm-linx&gt;</strong><br /><ul><li><strong>linxType :</strong> Type de lien parmi :<ul>    <li><strong>direct :</strong> Lien direct vers une page donn&eacute;e.</li>    <li><strong>sublinks :</strong> Liens vers les sous pages de la page courante.</li>    <li><strong>desclinks :</strong> Historique de navigation d''une page &agrave; une autre.</li>    <li><strong>recursivelinks :</strong> Arborescence de sous liens depuis une page donn&eacute;e.</li></ul></li><li><strong>linxDefinition :</strong> Voir la documentation Automne pour le d&eacute;tail.</li></ul><strong> 	Zone de contenu : Permet l''affichage de rang&eacute;es de contenu :<br />&lt;atm-clientspace module=&quot;standard&quot; id=&quot;</strong>uniqueID<strong>&quot; /&gt;</strong><br /><ul><li><strong>uniqueID :</strong> Identifiant unique de la zone de contenu dans le mod&egrave;le. </li></ul><strong> Lien vers la page d''impression :<br />&lt;atm-print-link&gt;</strong>{{href}}<strong>&lt;/atm-print-link&gt;</strong><br /><ul><li><strong>{{href}} :</strong> sera remplac&eacute; par le lien vers la page imprimable.</li></ul>', '<ol>\r\n<li>\r\n	Title of the current page:<br />\r\n	&lt;atm-title /&gt;\r\n</li>\r\n<li>\r\n	Metadata of the current page:<br />\r\n	&lt;atm-meta-tags /&gt;\r\n</li>\r\n<li>\r\n	Value of a constant (see Automne constants files):<br />\r\n	&lt;atm-constant name="constantName" /&gt;<br />\r\n	<b>constantName :</b> Name of the constant to display.\r\n</li>\r\n<li>\r\n	link(s) to one or several pages:<br />\r\n	&lt;atm-linx type="linxType"&gt;linxDefinition&lt;/atm-linx&gt;<br />\r\n	<b>linxType :</b> link type between:\r\n	<ul>\r\n		<li>''direct'' : Direct link to a given page.</li>\r\n		<li>''sublinks'' : Links to subpages of the current page.</li>\r\n		<li>''desclinks'' : Navigation history from a page to another.</li>\r\n		<li>''recursivelinks'' : Tree structure of sublinks from a given page.</li>\r\n	</ul>\r\n	<b>linxDefinition :</b> See Automne documentation for the detail.\r\n</li>\r\n<li>\r\n	Content zone : Alow use of content rows :<br />\r\n	&lt;atm-clientspace module="standard" id="uniqueID" /&gt;<br />\r\n	<b>uniqueID :</b> Unique identifier of the content zone for the template.\r\n</li>\r\n<li>\r\n	Link to the printable page :<br />\r\n	&lt;atm-print-link&gt;{{href}}&lt;/atm-print-link&gt;<br />\r\n	<b>{{href}} :</b> will be replaced by the link to the printable page.\r\n</li>\r\n</ol>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1220, 'standard', '2008-11-14 19:56:24', 'Syntaxe des rangées pour le module ''%s''', 'Rows syntax for the module ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1219, 'standard', '2008-11-14 19:56:24', '<strong>Titre ou sous-titre (255 charact&egrave;res max) :</strong><br /><strong>&lt;block module=&quot;standard&quot; type=&quot;</strong><strong>varchar&quot; id=&quot;</strong>uniqueID<strong>&quot;&gt; ... &lt;/block&gt;</strong><ul><li><strong>uniqueID :</strong> Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :<br /><ul><li><strong>{{data}} : </strong>Contenu textuel.</li></ul><strong>Texte mis en forme (HTML) :</strong><br /><strong>&lt;block module=&quot;standard&quot; type=&quot;text&quot; id=&quot;</strong>uniqueID<strong>&quot;&gt; ... &lt;/block&gt;</strong><ul><li><strong>uniqueID :</strong> Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :<br /><ul><li><strong>{{data}} : </strong>Contenu mis en forme (HTML).</li></ul><strong>Image :</strong><br /><strong> &lt;block module=&quot;standard&quot; type=&quot;image&quot; id=&quot;</strong>uniqueID<strong>&quot; maxWidth=&quot;</strong>value<strong>&quot; minWidth=&quot;</strong>value<strong>&quot;&gt; ... &lt;/block&gt;</strong><br /><ul><li><strong>uniqueID :</strong> Identifiant unique du bloc dans la rang&eacute;e.</li><li><strong>value : </strong>Valeur minimum ou maximum autoris&eacute;e pour l''image en pixels. Les attributs maxWidth et minWidth sont optionnels.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :<br /><ul><li><strong>{{data}} : </strong>Code de l''image et lien vers l''image zoom si elle existe.</li><li><strong>{{linkLabel}} : </strong>Nom de l''image si il existe.</li></ul><strong>Fichier - Pi&egrave;ce jointe :</strong><br /><strong>&lt;block module=&quot;standard&quot; type=&quot;file&quot; id=&quot;</strong>uniqueID<strong>&quot;&gt; ... &lt;/block&gt;</strong><ul><li><strong>uniqueID :</strong> Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :<br /><ul><li><strong>{{data}} : </strong>Lien vers le fichier si il existe.</li><li><strong>{{href}} : </strong>Adresse (URL) du fichier.<br /></li><li><strong>{{label}} : </strong>Libell&eacute; du fichier.<br /></li><li><strong>{{jslabel}} : </strong>Libell&eacute; du fichier (&eacute;chapp&eacute; pour insertion dans du javascript ou un attribut de tag)<br /></li><li><strong>{{size}} : </strong>Taille du fichier en m&eacute;ga octets.<br /></li><li><strong>{{filename}} : </strong>Nom du fichier.<br /></li><li><strong>{{originalfilename}} : </strong>Nom original du fichier.<br /></li><li><strong>{{type}} : </strong>Extention du fichier.<br /></li></ul><strong>Animation Flash :</strong><br /><strong>&lt;block module=&quot;standard&quot; type=&quot;flash&quot; id=&quot;</strong>uniqueID<strong>&quot;&gt; ... &lt;/block&gt;</strong><ul><li><strong>uniqueID :</strong> Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :<br /><ul><li><strong>{{data}} :</strong> Contenu de l''animation flash.</li></ul>', '<ol><li>Title or sub-title<br />&lt;block module="standard" type="varchar" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Free text<br />&lt;block module="standard" type="text" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Image<br />&lt;block module="standard" type="image" id="uniqueID"&gt;{{data}} and / or {{linkLabel}}&lt;/block&gt;<br />NB : Attributes maxWidth and minWidth enable you to control the width of the image for each block image.</li><li>File<br />&lt;block module="standard" type="file" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Flash Animation<br />&lt;block module="standard" type="flash" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li></ol><b>uniqueID :</b> Unique identifier of the block for the row.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1218, 'standard', '2008-11-14 19:56:24', 'Se souvenir de mon compte', 'Remember me');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1217, 'standard', '2008-11-14 19:56:24', 'Gestion des accès par groupes d''utilisateurs', 'Users groups categories access management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1216, 'standard', '2008-11-14 19:56:24', '[Le dn (Distinguished Name) "%s" existe dejà ]', '[Sorry, the LDAP dn "%s" is already used]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1215, 'standard', '2008-11-14 19:56:24', 'Nom distinctif (dn)', 'Distinguished Name (dn)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1214, 'standard', '2008-11-14 19:56:24', 'Catégorie parente', 'Parent category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1212, 'standard', '2008-11-14 19:56:24', 'Les libellés', 'Labels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1213, 'standard', '2008-11-14 19:56:24', 'Libellé en %s', 'Label in %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1210, 'standard', '2008-11-14 19:56:24', 'Gestion des accès au contenu des modules', 'Access management to modules content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1211, 'standard', '2008-11-14 19:56:24', 'Administrer les catégories', 'Manage categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1208, 'standard', '2008-11-14 19:56:24', 'Racine des catégories', 'Categories root');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1209, 'standard', '2008-11-14 19:56:24', 'Accès aux catégories pour le groupe ''%s''', 'Access to categories for group ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1204, 'standard', '2008-11-14 19:56:24', 'Format PDF', 'PDF Format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1205, 'standard', '2008-11-14 19:56:24', 'Seulement dans le langage par défaut', 'Only in default language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1206, 'standard', '2008-11-14 19:56:24', 'Gestion des catégories', 'Categories management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1207, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de la catégorie %s', 'Do you confirm deletion of category %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1203, 'standard', '2008-11-14 19:56:24', 'Une page', 'One page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1201, 'standard', '2008-11-14 19:56:24', 'Démarrer avec Automne', 'Getting started');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1202, 'standard', '2008-11-14 19:56:24', 'Multiples pages', 'Multiple pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1199, 'standard', '2008-11-14 19:56:24', 'Guide d''installation', 'Installation guide');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1200, 'standard', '2008-11-14 19:56:24', 'Présentation d''Automne', 'Automne presentation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1197, 'standard', '2008-11-14 19:56:24', 'Guide du développeur', 'Developer guide');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1198, 'standard', '2008-11-14 19:56:24', 'Guide de l''administrateur', 'Administrator guide');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1196, 'standard', '2008-11-14 19:56:24', 'Guide du rédacteur', 'User guide');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1193, 'standard', '2008-11-14 19:56:24', '[Le fichier que vous souhaitez importer est trop grand]', '[File to upload is too wide]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1195, 'standard', '2008-11-14 19:56:24', 'Menu général', 'General Menu');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1194, 'standard', '2008-11-14 19:56:24', 'Lister', 'List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1191, 'standard', '2008-11-14 19:56:24', 'Vous tentez de mettre à  jour un fichier qui a été modifié manuellement. Merci de reporter ces modifications dans le fichier contenu dans le patch.', 'You try to update a file which was modified manually. Thank you to defer these modifications in the file contained in the patch.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1192, 'standard', '2008-11-14 19:56:24', 'Reprise du processus de mise à  jour après correction des erreurs', 'Patching process resume after errors correction');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1187, 'standard', '2008-11-14 19:56:24', 'Valider la correction', 'Validate the correction');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1188, 'standard', '2008-11-14 19:56:24', 'Fichier original protégé', 'Original protected file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1189, 'standard', '2008-11-14 19:56:24', 'Fichier du patch', 'Patch file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1190, 'standard', '2008-11-14 19:56:24', 'Collez ici le contenu du fichier mis à  jour', 'Paste here the contents of the file updated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1186, 'standard', '2008-11-14 19:56:24', 'Valider et corriger l''erreur suivante', 'Validate and correct next error');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1185, 'standard', '2008-11-14 19:56:24', '[Erreur incorrigible. Patch Interrompu]', '[Incorrigible error. Patch Stopped]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1184, 'standard', '2008-11-14 19:56:24', 'Cliquez pour corriger les erreurs', 'Click to correct errors');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1183, 'standard', '2008-11-14 19:56:24', 'Sauvegarder le nouvel ordre', 'Save the new order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1182, 'standard', '2008-11-14 19:56:24', '[Une fenêtre pop-up à  tenté de s''ouvrir sans succès.\nMerci de désactiver le système anti pop-up de votre navigateur pour ce site.]', '[A pop-up window attempted to open without success.\nThank you to deactivate the anti pop-up system of your browser for this site.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1181, 'standard', '2008-11-14 19:56:24', 'Merci de ne pas fermer cette fenêtre.', 'Do not close this window.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1179, 'standard', '2008-11-14 19:56:24', 'Etes-vous sur de vouloir finaliser l''installation ?', 'Are you sure to want to finalize installation ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1180, 'standard', '2008-11-14 19:56:24', 'Effectué', 'Done');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1177, 'standard', '2008-11-14 19:56:24', 'Execution terminée', 'End of process');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1178, 'standard', '2008-11-14 19:56:24', 'Ne finalisez pas l''installation si des erreurs (en rouge) se sont produites. Si vous avez des erreurs, copiez-collez le rapport complet et envoyez le à  votre administrateur technique ou à  WS Interactive.', 'Do not finalize installation if errors (in red) occurred. If you have errors, copy-paste the full report and send it to your technical administrator or to WS Interactive.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1176, 'standard', '2008-11-14 19:56:24', 'Cliquez pour finaliser l''installation', 'Click to finalize installation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1175, 'standard', '2008-11-14 19:56:24', '<font color="red">Attention, patcher Automne est un processus critique. Suivez scrupuleusement les indications et ne fermez pas votre navigateur avant la fin du processus.</font>', '<font color="red">Beware, Automne patching is a critical process. Follow indications scrupulously and do not close your navigator before the end of the process.</font>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1174, 'standard', '2008-11-14 19:56:24', 'Mise à  jour', 'Update');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1172, 'standard', '2008-11-14 19:56:24', 'Traitement du fichier', 'Treatment of the file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1173, 'standard', '2008-11-14 19:56:24', 'Traitement des commandes', 'Treatment of commands');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1171, 'standard', '2008-11-14 19:56:24', 'Ligne de commande', 'Command line');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1169, 'standard', '2008-11-14 19:56:24', 'Rapport de mise à  jour', 'Update report');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1170, 'standard', '2008-11-14 19:56:24', 'Impossible de nettoyer le dossier temporaire, veuillez effacer le contenu de ''%s'' manuellement', 'Impossible to clean the temporary folder, please erase the contents of ''%s'' manually');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1167, 'standard', '2008-11-14 19:56:24', 'Bavard', 'Verbose');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1168, 'standard', '2008-11-14 19:56:24', 'Exécution forcée<br /><font color="red">(/!\\ Dangereux, ne cochez pas ceci si vous ne connaissez pas le fonctionnement interne d''Automne /!\\)</font>', 'Force execution<br /><font color="red">(/!\\ Dangerous do not check this if you do not know internal Automne process /!\\)</font>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1166, 'standard', '2008-11-14 19:56:24', 'Fichier de mise à  jour', 'Update file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1165, 'standard', '2008-11-14 19:56:24', 'Mise à  jour d''Automne', 'Automne update');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1164, 'standard', '2008-11-14 19:56:24', 'Editeur visuel Javascript (WYSIWYG)', 'Javascript Visual editor (WYSIWYG)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1163, 'standard', '2008-11-14 19:56:24', 'Votre image est trop grande, maximum : %s pixels de large, veuillez utiliser la fonction de redimensionnement.', 'Your image is too big, maximum width : %s pixels, please use resize function.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1162, 'standard', '2008-11-14 19:56:24', 'Votre image est trop petite, minimum : %s pixels de large.', 'Your image is too small, minimum width : %s pixels.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1161, 'standard', '2008-11-14 19:56:24', 'Largeur mini : %s pixels', 'Min width : %s pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1159, 'standard', '2008-11-14 19:56:24', 'Nouveau, validation refusée', 'New, validation refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1160, 'standard', '2008-11-14 19:56:24', 'Largeur max : %s pixels. Vous pourrez redimensionner l''image après son chargement.', 'Max width : %s pixels. You will be able to resize your image after his loading.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1156, 'standard', '2008-11-14 19:56:24', 'Nouveau, à  supprimer', 'New, pending deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1157, 'standard', '2008-11-14 19:56:24', 'Nouveau, suppression refusée', 'New, deletion refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1158, 'standard', '2008-11-14 19:56:24', 'Nouveau, à valider', 'New, pending validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1154, 'standard', '2008-11-14 19:56:24', 'Nouveau, à  archiver', 'New, pending archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1155, 'standard', '2008-11-14 19:56:24', 'Nouveau, archivage refusé', 'New, archiving refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1152, 'standard', '2008-11-14 19:56:24', 'Ordre des liens à valider', 'Order of links pending validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1153, 'standard', '2008-11-14 19:56:24', 'Ordre des liens validation refusée', 'Order of links validation refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1150, 'standard', '2008-11-14 19:56:24', 'Dépublication refusée', 'Un-publication refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1151, 'standard', '2008-11-14 19:56:24', 'Non publié', 'Un-published');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1148, 'standard', '2008-11-14 19:56:24', 'Non publié, supprimé', 'Non published, deleted');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1149, 'standard', '2008-11-14 19:56:24', 'A dépublier', 'Pending un-publication');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1146, 'standard', '2008-11-14 19:56:24', 'Non publié, à  supprimer', 'Non published, pending deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1147, 'standard', '2008-11-14 19:56:24', 'Non pubié, suppression refusée', 'Non published, deletion refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1142, 'standard', '2008-11-14 19:56:24', 'Supprimé', 'Deleted');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1143, 'standard', '2008-11-14 19:56:24', 'Modifié, à valider', 'Modified, pending validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1144, 'standard', '2008-11-14 19:56:24', 'Modifié, validation refusée', 'Modified, validation refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1145, 'standard', '2008-11-14 19:56:24', 'Publié', 'Published');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1139, 'standard', '2008-11-14 19:56:24', 'Archivé', 'Archived');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1140, 'standard', '2008-11-14 19:56:24', 'A supprimer', 'Pending deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1141, 'standard', '2008-11-14 19:56:24', 'Suppression refusée', 'Deletion refused ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1137, 'standard', '2008-11-14 19:56:24', 'A archiver', 'Pending archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1138, 'standard', '2008-11-14 19:56:24', 'Validation refusée', 'Archive validation refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1134, 'standard', '2008-11-14 19:56:24', 'Non publié, à  archiver', 'Non published, pending archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1135, 'standard', '2008-11-14 19:56:24', 'Non publié, archivage refusé', 'Non published, archiving refused');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1136, 'standard', '2008-11-14 19:56:24', 'Non publié, archivé', 'Non published, archived');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1132, 'standard', '2008-11-14 19:56:24', 'Choisissez...', 'Choose...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1133, 'standard', '2008-11-14 19:56:24', 'Modifier modèle d''impression', 'Modify print template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1130, 'standard', '2008-11-14 19:56:24', 'Modifier les rangées', 'Modify rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1131, 'standard', '2008-11-14 19:56:24', 'Supprimer la section', 'Delete section');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1129, 'standard', '2008-11-14 19:56:24', 'Confirmer l''effacement du contenu de ce bloc ?', 'Do you confirm content clear?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1128, 'standard', '2008-11-14 19:56:24', 'Effacer le contenu', 'Clear content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1124, 'standard', '2008-11-14 19:56:24', 'Choisir un profil', 'Choose user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1125, 'standard', '2008-11-14 19:56:24', 'Sélection', 'Selection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1126, 'standard', '2008-11-14 19:56:24', 'En haut', 'On top');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1127, 'standard', '2008-11-14 19:56:24', 'En bas', 'On bottom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1123, 'standard', '2008-11-14 19:56:24', 'Toutes les actions', 'All actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1122, 'standard', '2008-11-14 19:56:24', 'Actions d''administration', 'Administration actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1121, 'standard', '2008-11-14 19:56:24', 'N° de page', 'Page number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1119, 'standard', '2008-11-14 19:56:24', 'Effacer le journal', 'Delete log');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1120, 'standard', '2008-11-14 19:56:24', 'Confirmer la suppression du journal ?', 'Confirm deletion request for log?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1118, 'standard', '2008-11-14 19:56:24', 'Tous les groupes', 'All groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1117, 'standard', '2008-11-14 19:56:24', 'Tous les utilisateurs', 'All users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1116, 'standard', '2008-11-14 19:56:24', 'Désarchiver', 'Unarchive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1115, 'standard', '2008-11-14 19:56:24', 'Ordre', 'Order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1114, 'standard', '2008-11-14 19:56:24', 'Supprimer l''accès au module', 'Delete module access');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1112, 'standard', '2008-11-14 19:56:24', 'Base de Données', 'DataBase');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1113, 'standard', '2008-11-14 19:56:24', 'Aucun élément en attente de validation.', 'No validations pending.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1110, 'standard', '2008-11-14 19:56:24', 'Modification d''une feuille de style (CSS)', 'Modify a stylesheet (CSS)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1111, 'standard', '2008-11-14 19:56:24', 'Les feuilles de style utilisent du code CSS spécifique à  votre site %s. <br /> Attention, Toute modification peut entrainer des changements visuels sur l''ensemble de votre site !', 'Style sheets use CSS code specific to your site %s.<br />Attention, Any modification can change the visual of all your site!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1109, 'standard', '2008-11-14 19:56:24', 'Editer', 'Edit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1103, 'standard', '2008-11-14 19:56:24', 'Administrer', 'Manage');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1104, 'standard', '2008-11-14 19:56:24', 'Modifier', 'Modify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1105, 'standard', '2008-11-14 19:56:24', 'Propriétés', 'Properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1106, 'standard', '2008-11-14 19:56:24', 'Identification', 'Identification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1107, 'standard', '2008-11-14 19:56:24', 'Modèles et rangées authorisés', 'Authorized templates and rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1108, 'standard', '2008-11-14 19:56:24', 'pour afficher un modèle, sélectionner tous les groupes auxquels il appartient', 'a template must belong to all the selected groups to be shown');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1102, 'standard', '2008-11-14 19:56:24', 'Voir', 'View');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1101, 'standard', '2008-11-14 19:56:24', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1099, 'standard', '2008-11-14 19:56:24', 'Adresse', 'Address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1100, 'standard', '2008-11-14 19:56:24', 'Rangées par défaut', 'Default rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (10031, 'standard', '2008-11-14 19:56:24', 'Aide', 'Help');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1096, 'standard', '2008-11-14 19:56:24', '[Impossible de remplacer le modèle, aucune correspondance trouvée]', '[Impossible to replace template, no match found]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1097, 'standard', '2008-11-14 19:56:24', 'Annuler les modifications des propriétés de la page ''%s'' ?', 'Confirm cancelling property changes for page ''%s'' ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (10030, 'standard', '2008-11-14 19:56:24', 'La démonstration suivante se limite aux actions de création et de modification de contenu ainsi qu''à  la phase de validation. Pour tester Automne cà´té administration, vous devez télécharger le code source sur le site <a href="http://www.automne.ws" target="_blank" class="admin"><b>www.automne.ws</b></a>. N''hésitez pas à  nous <a href="http://www.automne.ws/html/_77_.php" target="_blank" class="admin"><b>contacter</b></a> si vous avez des questions sur cette démonstration ou sur la faà§on dont Automne pourrait optimiser la gestion de vos sites.<br /><br /> Les contenus sont initialisés chaque dimanche. Si vous souhaitez tester les dates de publication, pensez à  ne pas dépasser la date du dimanche suivant à  minuit.\r\n', 'The following demo is limited to content addition and modification, including validation. To use Automne from an administrative perspective you must download the source code from <a href="http://www.automne.ws" target="_blank" class="admin"><b>www.automne.ws</b></a>. If you have further questions on this demo and on how Automne can help you manage your web sites, please <a href="http://www.automne.ws/html/_77_.php" target="_blank" class="admin"><b>contact us</b></a>.\r\n\r\nPlease note that all new content is erased every Sunday to renew the database. If you would like to test publication dates you must do so within the week ending on Sunday at midnight.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1098, 'standard', '2008-11-14 19:56:24', 'Ou', 'Or');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (10008, 'standard', '2008-11-14 19:56:24', 'L''image est trop grande (> %s pixels)', 'Image is too wide (> %s pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1095, 'standard', '2008-11-14 19:56:24', 'Remplacer le modèle de la page copiée par', 'Replace template?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1093, 'standard', '2008-11-14 19:56:24', 'Le navigateur utilisé est obsolète.<br />\r\nMerci de le mettre à  jour avec une version plus récente :<br />\r\n<ul>\r\n<li><a href="http://www.mozilla.com/firefox/" target="_blank">Mozilla - Firefox</a></li>\r\n<li><a href="http://www.microsoft.com/ie/" target="_blank">Internet Explorer</a></li>\r\n</ul>', 'Your navigator is obsolete...<br />\r\nPlease update it with a more recent version:<br />\r\n<ul>\r\n<li><a href="http://www.mozilla.com/firefox/" target="_blank">Mozilla - Firefox</a></li>\r\n<li><a href="http://www.microsoft.com/ie/" target="_blank">Internet Explorer</a></li>\r\n</ul>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1091, 'standard', '2008-11-14 19:56:24', 'Rechercher', 'Search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1092, 'standard', '2008-11-14 19:56:24', 'Résultat', 'Result');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1090, 'standard', '2008-11-14 19:56:24', 'Tà¢ches', 'Task');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1088, 'standard', '2008-11-14 19:56:24', 'Modification de modèle', 'Template Modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1089, 'standard', '2008-11-14 19:56:24', 'Les modèles utilisent du code XHTML associé à  des tags Automne spécifiques à  votre site %s. Automne n''utilisera pas du code non conforme à  l''XHTML. <font color="red">Attention à  ne supprimer aucun tag ''&lt;atm-clientspace /&gt;'' sous peine de perdre le contenu associé !</font>', 'Templates use xHTML code associated with Automne tags specific to your site, %s. Automne will not use any xHTML non-conform<br />\r\n<font color="red">Attention, do not delete any tag ''&lt;atm-clientspace /&gt;'' or all associed content will be lost!</font>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1084, 'standard', '2008-11-14 19:56:24', 'Format : 0;url=http://domain.com', 'Format: 0;url=http://domain.com');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1085, 'standard', '2008-11-14 19:56:24', 'Créer une nouvelle page', 'Create a new page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1086, 'standard', '2008-11-14 19:56:24', 'Retourner aux propriétés', 'Return to properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1087, 'standard', '2008-11-14 19:56:24', 'sous %s', 'under %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1083, 'standard', '2008-11-14 19:56:24', 'Non', 'No');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1082, 'standard', '2008-11-14 19:56:24', 'Oui', 'Yes');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1081, 'standard', '2008-11-14 19:56:24', 'Balises meta', 'Meta Tags');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1080, 'standard', '2008-11-14 19:56:24', 'Moteurs de recherche', 'Search engines');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1078, 'standard', '2008-11-14 19:56:24', 'Propriétés', 'Identity');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1079, 'standard', '2008-11-14 19:56:24', 'Dates & alertes', 'Dates & Alerts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1075, 'standard', '2008-11-14 19:56:24', 'Gestion de page', 'Page administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1076, 'standard', '2008-11-14 19:56:24', 'Site', 'Web Site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1077, 'standard', '2008-11-14 19:56:24', 'Impression active', 'Print page Active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1072, 'standard', '2008-11-14 19:56:24', 'Statistiques', 'Statistics');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1073, 'standard', '2008-11-14 19:56:24', 'Aide', 'Help');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1074, 'standard', '2008-11-14 19:56:24', 'par', 'by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1066, 'standard', '2008-11-14 19:56:24', 'Scripts en attente', 'Scripts pending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1067, 'standard', '2008-11-14 19:56:24', 'Scripts en cours', 'Scripts in progress');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1068, 'standard', '2008-11-14 19:56:24', 'Pas de rangées', 'No rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1069, 'standard', '2008-11-14 19:56:24', 'Effacer les enregistrements antérieurs au', 'Delete log before');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1070, 'standard', '2008-11-14 19:56:24', 'Site', 'Website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1071, 'standard', '2008-11-14 19:56:24', 'Calendrier', 'Calendar');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1065, 'standard', '2008-11-14 19:56:24', 'Absent', 'Absent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1064, 'standard', '2008-11-14 19:56:24', 'Présent', 'Present');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1061, 'standard', '2008-11-14 19:56:24', 'Pages (ID)', 'Pages (ID)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1062, 'standard', '2008-11-14 19:56:24', 'Lancé le', 'Launch Date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1063, 'standard', '2008-11-14 19:56:24', 'Fichier PID', 'PID File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1056, 'standard', '2008-11-14 19:56:24', 'Zones modifiables à  imprimer', 'Printed zones');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1057, 'standard', '2008-11-14 19:56:24', 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1058, 'standard', '2008-11-14 19:56:24', 'Sélectionner', 'Add');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1059, 'standard', '2008-11-14 19:56:24', 'Valider', 'Validate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1060, 'standard', '2008-11-14 19:56:24', 'Effacer la file', 'Clear queue');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1055, 'standard', '2008-11-14 19:56:24', 'Zones modifiables à  ne pas imprimer', 'Non-printed zones');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1050, 'standard', '2008-11-14 19:56:23', 'Copier le contenu', 'Copy the content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1052, 'standard', '2008-11-14 19:56:23', 'Impression', 'Printing');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1053, 'standard', '2008-11-14 19:56:23', 'Gestion des zones modifiables imprimables', 'Printing zone management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1054, 'standard', '2008-11-14 19:56:23', 'Sélectionner les zones modifiables et leur ordre d''impression.', 'Select content management zones active on the print page and their order of appearance.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1047, 'standard', '2008-11-14 19:56:23', 'Sélectionner la section de destination', 'Select the destination section');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1048, 'standard', '2008-11-14 19:56:23', 'Copie de page', 'Page copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1049, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page de destination dans l''arborescence', 'Select the destination page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1046, 'standard', '2008-11-14 19:56:23', 'Copier la page', 'Copy page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1044, 'standard', '2008-11-14 19:56:23', 'Catégorie', 'Category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1045, 'standard', '2008-11-14 19:56:23', 'Le fichier à  télécharger dépasse les limites autorisées par ce\r\nserveur : %s.', 'This file is too big. Server limits upload to %s.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1043, 'standard', '2008-11-14 19:56:23', 'Données de référencement', 'Search enging referencing content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1042, 'standard', '2008-11-14 19:56:23', 'Valeurs : all, index, follow, noindex, nofollow', 'values : all, index, follow, noindex, nofollow');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1041, 'standard', '2008-11-14 19:56:23', 'Balises meta courantes (visibles dans le code source de la page)', 'Common meta tags (visible in source code)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1037, 'standard', '2008-11-14 19:56:23', 'Robots', 'Robots');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1038, 'standard', '2008-11-14 19:56:23', 'Cache du navigateur', 'Browser cache');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1039, 'standard', '2008-11-14 19:56:23', 'Redirection', 'Redirection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1040, 'standard', '2008-11-14 19:56:23', 'Forcer la mise à  jour (balise Pragma en `no-cache`)', 'Force refresh setting (Pragma value) to `no-cache`');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1035, 'standard', '2008-11-14 19:56:23', 'Copyright', 'Copyright');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1036, 'standard', '2008-11-14 19:56:23', 'Langue utilisée', 'Language used');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1031, 'standard', '2008-11-14 19:56:23', 'Arborescence des pages', 'List of all pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1033, 'standard', '2008-11-14 19:56:23', 'Auteur', 'Author');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1034, 'standard', '2008-11-14 19:56:23', 'Email de réponse', 'Reply-to email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1029, 'standard', '2008-11-14 19:56:23', 'Hauteur de la pop-up', 'Pop-up height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1030, 'standard', '2008-11-14 19:56:23', '[La librairie de fonctions GD2 de PHP n''est pas installée : les fonctionnalités de redimensionnement d''image sont désactivées. Contacter l''administrateur technique.]', '[PHP GD2 library is not present. Automne image resizing functionalities are disabled. Please contact your technical administrator]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1028, 'standard', '2008-11-14 19:56:23', 'Largeur de la pop-up', 'Pop-up width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1024, 'standard', '2008-11-14 19:56:23', 'Dans une nouvelle fenêtre', 'In a new window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1025, 'standard', '2008-11-14 19:56:23', 'Dans une fenêtre pop-up', 'In a pop-up window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1026, 'standard', '2008-11-14 19:56:23', 'Cible du lien', 'Link target');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1027, 'standard', '2008-11-14 19:56:23', 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1022, 'standard', '2008-11-14 19:56:23', 'Ouverture', 'Open');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1023, 'standard', '2008-11-14 19:56:23', 'Dans la fenêtre en cours', 'In the main window');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1019, 'standard', '2008-11-14 19:56:23', 'Type de lien', 'Link type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1020, 'standard', '2008-11-14 19:56:23', 'Interne', 'Internal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1021, 'standard', '2008-11-14 19:56:23', 'Externe', 'External');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1018, 'standard', '2008-11-14 19:56:23', 'Annuler', 'Reinitialize');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1016, 'standard', '2008-11-14 19:56:23', 'Redimensionner l''image', 'Image resizing');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1017, 'standard', '2008-11-14 19:56:23', 'Cliquer sur l''image à  l''aide du bouton gauche de la souris.<br />Maintenir le bouton et déplacer la souris vers le coin gauche pour redimmensionner l''image.<br />Une fois l''image à  la taille désirée, relà¢cher le bouton. L''image sera recompressée après validation.<br /><br />ATTENTION : agrandir une image la pixelise.', 'With the mouse, click on the image and with the button still pressed, move the mouse to resize the image. Once done, validate.<br />\r\nAttention, multiple resize actions can hinder the quality of the image!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1011, 'standard', '2008-11-14 19:56:23', '%s modèle(s) inactif(s) masqué(s).', '%s inactive template(s) exist.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1013, 'standard', '2008-11-14 19:56:23', 'Visualisation de la rangée', 'Style-row preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1014, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Modify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1015, 'standard', '2008-11-14 19:56:23', 'Redimensionner', 'Resize');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1012, 'standard', '2008-11-14 19:56:23', 'Gestion des rangées', 'Style-Rows management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1010, 'standard', '2008-11-14 19:56:23', '[Aucun modèle à  afficher]', '[No templates correspond]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1005, 'standard', '2008-11-14 19:56:23', 'Un modèle inactif ne peut être utilisé.', 'An inactive template cannot be used by a content provider.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1006, 'standard', '2008-11-14 19:56:23', 'Afficher', 'Show');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1007, 'standard', '2008-11-14 19:56:23', 'Tous les modèles', 'All templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1008, 'standard', '2008-11-14 19:56:23', 'Modèles appartenant aux groupes', 'Selected Templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1009, 'standard', '2008-11-14 19:56:23', 'Afficher le(s) modèle(s) inactivé(s)', 'Include inactive templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1004, 'standard', '2008-11-14 19:56:23', 'Confirmation', 'Confirmation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (999, 'standard', '2008-11-14 19:56:23', 'Modules', 'Applications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1000, 'standard', '2008-11-14 19:56:23', 'Rangées', 'Style-rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1001, 'standard', '2008-11-14 19:56:23', 'Substitution de modèles', 'Replacement of Templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1002, 'standard', '2008-11-14 19:56:23', '[Les modèles de contenu ne sont pas concordants]', '[The templates do not match]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1003, 'standard', '2008-11-14 19:56:23', 'Du modèle "%s" vers "%s" :', 'From template "%s" to "%s":');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (997, 'standard', '2008-11-14 19:56:23', 'Comparaison des modèles', 'Template compatibility');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (998, 'standard', '2008-11-14 19:56:23', '[Modèle inutilisable]', '[Template cannot be used]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (992, 'standard', '2008-11-14 19:56:23', 'Page à copier', 'Page to copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (993, 'standard', '2008-11-14 19:56:23', 'Page de destination sélectionnée', 'Selected destination page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (994, 'standard', '2008-11-14 19:56:23', 'Les zones modifiables ne sont pas concordantes.', 'Content management zones do not match in the templates.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (995, 'standard', '2008-11-14 19:56:23', '[Les modèles sont identiques]', '[Templates are identical]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (996, 'standard', '2008-11-14 19:56:23', '[Les rangées et les modèles ne sont pas concordants]', '[Style-rows do not match in the templates]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (991, 'standard', '2008-11-14 19:56:23', '[Vérifier la correspondance des modèles : ils doivent etre identiques]', '[Verify the corresponding templates.\r\nThey must be identical!]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (987, 'standard', '2008-11-14 19:56:23', '... sélectionner la page recevant le contenu.', '... select the destination page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (988, 'standard', '2008-11-14 19:56:23', 'La sélection de pages semble incorrecte. Recommencer la procédure.', 'Selection of pages is incorrect, please repeat procedure.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (989, 'standard', '2008-11-14 19:56:23', 'La page a été modifiée : %s', 'Page has been modified : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (990, 'standard', '2008-11-14 19:56:23', '[Une erreur est survenue lors du traitement du contenu. Vérifier les pages :\r\n     Origine : %s\r\n     Destination : %s]', '[An error occured while copying contents, please check pages :\r\n     Original : %s\r\n     Destination : %s]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (985, 'standard', '2008-11-14 19:56:23', 'Copie du contenu d''une page', 'Copying one page contents');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (986, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page dont le contenu sera copié ...', 'Select the page to copy content from ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (983, 'standard', '2008-11-14 19:56:23', 'Une branche', 'A branch');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (984, 'standard', '2008-11-14 19:56:23', 'Un contenu de page', 'One page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (981, 'standard', '2008-11-14 19:56:23', 'Le modèle <b>%s</b> est remplacé par:', 'Template <b>%s</b> will be replaced by:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (982, 'standard', '2008-11-14 19:56:23', 'Dupliquer', 'Duplicate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (979, 'standard', '2008-11-14 19:56:23', '[Les pages ont été créées. Vérifier leur contenu depuis l''arborescence.]', '[The new pages have been successfully copied]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (980, 'standard', '2008-11-14 19:56:23', 'Sélectionner les modèles de remplacement\r\ndes pages à  dupliquer. Les modèles doivent contenir les mêmes zones modifiables et les mêmes rangées.', 'Select different templates for the new pages.<br />\r\nAll templates must have exactly the same structure of content management zones.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (978, 'standard', '2008-11-14 19:56:23', '[Les pages sélectionnées pour la duplication d''arborescence sont incorrectes. Essayer à  nouveau.]', '[Pages selected for duplication seem incorrect, please try again]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (976, 'standard', '2008-11-14 19:56:23', 'Sélectionner la première page de la branche à  copier ...', 'Select first page from branch you want to copy ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (977, 'standard', '2008-11-14 19:56:23', '... sélectionner la page de destination.', '... select destination page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (970, 'standard', '2008-11-14 19:56:23', 'Largeur de la pop-up', 'Pop-up width:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (971, 'standard', '2008-11-14 19:56:23', 'Hauteur de la pop-up ', 'Pop-up height:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (975, 'standard', '2008-11-14 19:56:23', 'Copie de branche d''arborescence', 'Select a branch of the tree to copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (969, 'standard', '2008-11-14 19:56:23', 'Ouvrir ce lien en pop-up ?', 'Open this link in a pop-up?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (968, 'standard', '2008-11-14 19:56:23', 'Image zoom', 'Image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (963, 'standard', '2008-11-14 19:56:23', '[Copie de sauvegarde impossible]', '[Creation of backup file impossible]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (964, 'standard', '2008-11-14 19:56:23', '[La définition de style semble incomplète]', '[Your style definition seems incomplete]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (965, 'standard', '2008-11-14 19:56:23', '[Ce style existe déjà ]', '[This style already exists]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (966, 'standard', '2008-11-14 19:56:23', '[Style supprimé]', '[Style deleted]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (967, 'standard', '2008-11-14 19:56:23', '[Style modifié]', '[Style modified]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (962, 'standard', '2008-11-14 19:56:23', '[Recréation depuis le fichier de sauvegarde impossible]', '[Rebuild from backup file failed]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (951, 'standard', '2008-11-14 19:56:23', 'Feuille de style "%s"', 'Stylesheet "%s"');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (952, 'standard', '2008-11-14 19:56:23', 'Enregistrer', 'Save');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (953, 'standard', '2008-11-14 19:56:23', 'Balise', 'Tag');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (954, 'standard', '2008-11-14 19:56:23', 'Style', 'Style');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (955, 'standard', '2008-11-14 19:56:23', 'Nom du style', 'Style name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (956, 'standard', '2008-11-14 19:56:23', 'Pseudo classe', 'Pseudo class');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (957, 'standard', '2008-11-14 19:56:23', 'Attribut', 'Attribute');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (958, 'standard', '2008-11-14 19:56:23', 'Valeur', 'Value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (959, 'standard', '2008-11-14 19:56:23', 'Nouveau style', 'Add new style');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (960, 'standard', '2008-11-14 19:56:23', 'Supprimer cet élément de la feuille de style ?', 'Delete this style element from stylesheet ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (961, 'standard', '2008-11-14 19:56:23', '[L''écriture est impossible dans le fichier de feuille de style donné]', '[Impossible to write into given stylesheet file]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (942, 'standard', '2008-11-14 19:56:23', 'Sélection de la page à régénérer', 'Select a page to regenerate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (943, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page à régénérer', 'Select a page to regenerate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (944, 'standard', '2008-11-14 19:56:23', 'Scripts en cours', 'Active scripts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (945, 'standard', '2008-11-14 19:56:23', 'Voir file d''attente', 'View queue list');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (946, 'standard', '2008-11-14 19:56:23', 'Redémarrer scripts', 'Restart scripts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (947, 'standard', '2008-11-14 19:56:23', 'Voici les scripts restant en file d''attente', 'These are the scripts left into queue');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (948, 'standard', '2008-11-14 19:56:23', 'Créer depuis le modèle', 'Create from template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (949, 'standard', '2008-11-14 19:56:23', 'Nouveau modèle', 'New template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (950, 'standard', '2008-11-14 19:56:23', 'Feuilles de style', 'Stylesheet (CSS) files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (941, 'standard', '2008-11-14 19:56:23', 'Historique des actions sur le contenu', 'Show content management action log');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (935, 'standard', '2008-11-14 19:56:23', 'Sélection de la page', 'Page selection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (936, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page', 'Select the page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (937, 'standard', '2008-11-14 19:56:23', 'Créer un lien interne', 'Create an internal link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (938, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Modify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (939, 'standard', '2008-11-14 19:56:23', 'Insérer au curseur', 'Insert at cursor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (940, 'standard', '2008-11-14 19:56:23', 'Espace "Copier-coller"', '"Copy-paste" space');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (932, 'standard', '2008-11-14 19:56:23', 'Création d''un lien interne', 'Create an internal link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (933, 'standard', '2008-11-14 19:56:23', 'Résultat', 'Result');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (934, 'standard', '2008-11-14 19:56:23', 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (931, 'standard', '2008-11-14 19:56:23', 'Groupe', 'Group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (930, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression du groupe ''%s''', 'Confirm deletion of group ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (929, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression de l''utilisateur ''%s''', 'Confirm deletion of user ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (926, 'standard', '2008-11-14 19:56:23', 'Utilisateurs', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (927, 'standard', '2008-11-14 19:56:23', 'Utilisateurs appartenant au groupe %s', 'Users belonging to group %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (928, 'standard', '2008-11-14 19:56:23', 'Aucun utilisateur', 'No user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (925, 'standard', '2008-11-14 19:56:23', 'Un message d''alerte est associé :\r\n%s', 'A personalised alert message is included:\r\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (921, 'standard', '2008-11-14 19:56:23', '[Modification des groupes de modèles refusée]', '[Template groups denied modification]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (922, 'standard', '2008-11-14 19:56:23', 'Modification du niveau de notification', 'Modification of alert level');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (923, 'standard', '2008-11-14 19:56:23', 'Alerte sur contenu de page', 'Content management alert');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (924, 'standard', '2008-11-14 19:56:23', 'La page ''%s'' est obsolète et doit être mise à  jour.', 'This is an automatic alert for the page ''%s''. You or another provider must log on to the administration platform and make the appropriate modifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (920, 'standard', '2008-11-14 19:56:23', 'Modification des droits de validation', 'Modification of validation rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (919, 'standard', '2008-11-14 19:56:23', 'Modifications des droits d''administration', 'Modification of administration rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (917, 'standard', '2008-11-14 19:56:23', 'Modification des données de contact', 'Modification of contact information');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (918, 'standard', '2008-11-14 19:56:23', 'Modification des droits sur les modules', 'Modification of application rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (916, 'standard', '2008-11-14 19:56:23', 'Modification des données personnelles', 'Modification of user properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (915, 'standard', '2008-11-14 19:56:23', 'Modification des sections de droit', 'Modification of content management rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (914, 'standard', '2008-11-14 19:56:23', 'Votre profil a été modifié. Vos identifiants sont :\r\nIdentifiant : %s\r\n\r\nModification(s) effectuée(s) : \r\n', 'Your user profile has been updated.\r\nLogin : %s\r\n\r\nModification type:\r\n');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (913, 'standard', '2008-11-14 19:56:23', 'Modification de votre profil d''utilisateur', 'Modify your user profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (911, 'standard', '2008-11-14 19:56:23', 'Changement de l''ordre du menu de navigation', 'Order of sub page links modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (912, 'standard', '2008-11-14 19:56:23', 'Cet email est généré automatiquement par Automne concernant votre site %s.\r\nSite : %s\r\nAdministration du site : %s', 'This email was automatically generated by Automne regarding your website %s.\r\nWebsite: %s\r\nAdministration platform: %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (910, 'standard', '2008-11-14 19:56:23', 'Journal des actions pour %s', 'Logged action for resource %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (909, 'standard', '2008-11-14 19:56:23', 'Statut après', 'Status after');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (908, 'standard', '2008-11-14 19:56:23', 'Utilisateur', 'User');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (904, 'standard', '2008-11-14 19:56:23', 'Journal des actions pour l''utilisateur %s', 'Logged actions for user %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (905, 'standard', '2008-11-14 19:56:23', 'Date', 'Date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (906, 'standard', '2008-11-14 19:56:23', 'Action', 'Action');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (907, 'standard', '2008-11-14 19:56:23', 'Commentaires', 'Comments');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (902, 'standard', '2008-11-14 19:56:23', 'Une page (choisir)', 'One page (choose)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (903, 'standard', '2008-11-14 19:56:23', 'Meta administration', 'Advanced administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (897, 'standard', '2008-11-14 19:56:23', 'Sélection d''une page', 'Select a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (898, 'standard', '2008-11-14 19:56:23', 'Sélectionner une page pour afficher le journal des actions', 'Select a page to see its corresponding action log');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (899, 'standard', '2008-11-14 19:56:23', 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (900, 'standard', '2008-11-14 19:56:23', 'Régénérer', 'Regenerate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (901, 'standard', '2008-11-14 19:56:23', 'Toutes les pages', 'All pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (894, 'standard', '2008-11-14 19:56:23', 'Journal des actions', 'Action log');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (895, 'standard', '2008-11-14 19:56:23', 'Par profil', 'By user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (896, 'standard', '2008-11-14 19:56:23', 'Par page', 'By page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (892, 'standard', '2008-11-14 19:56:23', 'Suppression d''un modèle', 'Delete template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (893, 'standard', '2008-11-14 19:56:23', 'Suppression d''une rangée de modèle', 'Delete template style-row');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (891, 'standard', '2008-11-14 19:56:23', 'Modification d''une rangée de modèle', 'Modify style-row of a template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (883, 'standard', '2008-11-14 19:56:23', 'Suppression d''un groupe de profils', 'Delete group profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (884, 'standard', '2008-11-14 19:56:23', 'Modification d''un profil', 'Modify user profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (885, 'standard', '2008-11-14 19:56:23', 'Suppression d''un utilisateur', 'Delete user profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (890, 'standard', '2008-11-14 19:56:23', 'Modification d''un modèle', 'Modify template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (881, 'standard', '2008-11-14 19:56:23', 'Suppression d''un site', 'Delete web site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (882, 'standard', '2008-11-14 19:56:23', 'Modification d''un groupe de profils', 'Modify Group Profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (874, 'standard', '2008-11-14 19:56:23', 'Annuler la suppression', 'Undeletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (875, 'standard', '2008-11-14 19:56:23', 'Archiver', 'Archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (876, 'standard', '2008-11-14 19:56:23', 'Annuler l''archivage', 'Unarchiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (877, 'standard', '2008-11-14 19:56:23', 'Annuler les modifications', 'Cancel modifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (878, 'standard', '2008-11-14 19:56:23', 'Valider', 'Validate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (879, 'standard', '2008-11-14 19:56:23', 'Ajout d''un site', 'Add web site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (880, 'standard', '2008-11-14 19:56:23', 'Modification d''un site', 'Modify web site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (871, 'standard', '2008-11-14 19:56:23', 'Modification des propriétés', 'Modification of properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (872, 'standard', '2008-11-14 19:56:23', 'Modification du contenu', 'Content modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (873, 'standard', '2008-11-14 19:56:23', 'Suppression', 'Deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (870, 'standard', '2008-11-14 19:56:23', '[La page de destination ne peut pas être une page non validée]', '[The new destination page must be validated]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (867, 'standard', '2008-11-14 19:56:23', '[Impossible de déplacer une page qui n''a jamais été validée]', 'Impossible to move a page that has never been validated.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (868, 'standard', '2008-11-14 19:56:23', '[Impossible de déplacer la racine]', '[Error, the Start Page cannot be moved]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (869, 'standard', '2008-11-14 19:56:23', '[Impossible de déplacer une page vers ses descendants]', '[Error, a page cannot be moved to one of its sub pages]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (865, 'standard', '2008-11-14 19:56:23', 'Dernière publication', 'Last publication');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (866, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression de la page ''%s'' ? ATTENTION ! Cette suppression n''est pas soumise à  validation et prendra effet immédiatement.', 'Confirm deletion of the page ''%s'' ? Attention, this action takes effect immediately!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (860, 'standard', '2008-11-14 19:56:23', 'Archives', 'Archives');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (861, 'standard', '2008-11-14 19:56:23', 'Page de destination', 'Destination page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (862, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page de destination d''une page sortant d''archive', 'Select the destination page for the unarchived page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (863, 'standard', '2008-11-14 19:56:23', 'Identifiant', 'Reference');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (864, 'standard', '2008-11-14 19:56:23', 'Titre', 'Title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (859, 'standard', '2008-11-14 19:56:23', 'Archives', 'Archives');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (857, 'standard', '2008-11-14 19:56:23', 'Effacer les modifications', 'Delete modifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (858, 'standard', '2008-11-14 19:56:23', 'Confirmer l''annulation des modifications pour ''%s'' ? ATTENTION! Cette action n''est pas soumise à  validation et prendra effet immédiatement.', 'Confirm cancellation of modifications for page ''%s'' ? Attention, this action takes effect immediatly!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'cms_aliases', '2008-11-14 19:56:24', 'Sous-alias', 'Sub-aliases');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'cms_aliases', '2008-11-14 19:56:24', 'Chemin de l''alias', 'Alias path');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'cms_aliases', '2008-11-14 19:56:24', 'Cible', 'Target');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'cms_aliases', '2008-11-14 19:56:24', 'Création / modification d''alias', 'Alias creation / modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'cms_aliases', '2008-11-14 19:56:24', 'Alias', 'Aliases ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (8, 'cms_aliases', '2008-11-14 19:56:24', '[Erreur : Impossible de créer l''alias, un dossier portant ce nom existe déjà  !]', '[Error: Impossible to create this alias, a folder with this name already exists!]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (87, 'cms_forms', '2008-11-14 19:56:24', 'Assistant de création de formulaires', 'Forms creation wizard');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (88, 'cms_forms', '2008-11-14 19:56:24', 'Adresse d''émission', 'Sender address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (89, 'cms_forms', '2008-11-14 19:56:24', 'Avec la date de soumission', 'With submission date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (90, 'cms_forms', '2008-11-14 19:56:24', '[Erreur : vous ne devez pas copier-coller le code d''un formulaire dans un autre formulaire !]', '[Error : you must not copy-paste code from one form to another one!]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (86, 'cms_forms', '2008-11-14 19:56:24', '<strong>Formulaire &agrave; afficher pour toutes les pages employant le modèle :</strong><br /><strong>&lt;atm-clientspace module=&quot;cms_forms&quot; id=&quot;form&quot; type=&quot;formular&quot; formID=&quot;</strong>formID<strong>&quot;/&gt;<br /></strong><ul><li><strong>formID : </strong>Identifiant du formulaire &agrave; afficher.</li></ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (85, 'cms_forms', '2008-11-14 19:56:24', '<strong>Formulaire &agrave; choisir pour une page :</strong><br /><strong>&lt;block module=&quot;cms_forms&quot; id=&quot;form&quot;&gt;</strong>{{data}}<strong>&lt;/block&gt;<br /></strong><ul><li><strong>{{data}} : </strong>Sera remplacé par le formulaire &agrave; afficher.</li></ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (84, 'cms_forms', '2008-11-14 19:56:24', 'Vous devez avoir ''%s'' actif dans votre profil pour pouvoir Créer / Editer un formulaire.', 'You must have ''%s'' active in your profile to Create / Edit a form.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (83, 'cms_forms', '2008-11-14 19:56:24', 'Cette action n''est pas autorisée durant l''édition ou la prévisualisation de la page.', 'This action is not allowed during edition / previsualisation of the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (82, 'cms_forms', '2008-11-14 19:56:24', 'Aucun champ pouvant servir à retenir le compte utilisateur n''a été trouvé dans le formulaire.', 'No field which can be used to remember user account was found in the form.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (81, 'cms_forms', '2008-11-14 19:56:24', 'Se souvenir du compte', 'Remember account');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (78, 'cms_forms', '2008-11-14 19:56:24', 'Identifiant', 'User ID');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (79, 'cms_forms', '2008-11-14 19:56:24', 'Mot de passe', 'Password');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (80, 'cms_forms', '2008-11-14 19:56:24', 'Message à afficher si l''authentification est incorrecte', 'Message displayed on wrong authentification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (77, 'cms_forms', '2008-11-14 19:56:24', 'Aucun champ pouvant contenir un mot de passe utilisateur n''a été trouvé dans le formulaire.', 'No field which can contain a user password was found in the form.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (74, 'cms_forms', '2008-11-14 19:56:24', 'Remise à zéro', 'Reset');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (75, 'cms_forms', '2008-11-14 19:56:24', 'Authentifier l''utilisateur', 'Authenticate user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (76, 'cms_forms', '2008-11-14 19:56:24', 'Aucun champ pouvant contenir un identifiant utilisateur n''a été trouvé dans le formulaire.', 'No field which can contain a user ID was found in the form.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (72, 'cms_forms', '2008-11-14 19:56:24', 'Télécharger les données du formulaire au format CSV', 'Download form datas in CSV format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (73, 'cms_forms', '2008-11-14 19:56:24', 'Confirmez-vous la suppression des données enregistrées pour le formulaire ''%s'' ?', 'Do you confirm deletion of recorded datas for the form ''%s''?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (71, 'cms_forms', '2008-11-14 19:56:24', 'Saisissez le sujet des emails', 'Enter the subject message for emails');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (70, 'cms_forms', '2008-11-14 19:56:24', 'Saisissez le message de fin pour les emails', 'Enter the footer message for emails');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (69, 'cms_forms', '2008-11-14 19:56:24', 'Message du formulaire ''%s'' du site ''%s''', 'Message from form ''%s'' from website ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (66, 'cms_forms', '2008-11-14 19:56:24', 'Déselectionner', 'Deselect');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (67, 'cms_forms', '2008-11-14 19:56:24', 'Veuillez compléter les champs requis :', 'Please complete the following required fields:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (68, 'cms_forms', '2008-11-14 19:56:24', 'Le contenu de ces champs est incorrect :', 'The following fields have incorrect content:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (64, 'cms_forms', '2008-11-14 19:56:24', 'Sélection d''un formulaire', 'Form selection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (65, 'cms_forms', '2008-11-14 19:56:24', 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (62, 'cms_forms', '2008-11-14 19:56:24', 'Catégorie', 'Category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (63, 'cms_forms', '2008-11-14 19:56:24', 'Trouver un formulaire', 'Find a form');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (61, 'cms_forms', '2008-11-14 19:56:24', 'Aucun champ pouvant contenir un email n''a été trouvé dans le formulaire.', 'No field which can contain an email was found in the form.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (59, 'cms_forms', '2008-11-14 19:56:24', 'Fichier CSV', 'CSV File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (60, 'cms_forms', '2008-11-14 19:56:24', 'Vous pourrez télécharger ici le fichier CSV lorsque des données seront disponibles.', 'You will be able to download CSV file here when data are available.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (57, 'cms_forms', '2008-11-14 19:56:24', 'Texte à afficher', 'Text to display');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (58, 'cms_forms', '2008-11-14 19:56:24', 'Champ(s) du formulaire', 'Form field(s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (56, 'cms_forms', '2008-11-14 19:56:24', 'Saisissez le message d''en tête pour les emails', 'Enter the header message for emails');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (54, 'cms_forms', '2008-11-14 19:56:24', 'Ajouter une action :', 'Add an action:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (55, 'cms_forms', '2008-11-14 19:56:24', 'Saisissez votre liste d''emails (séparateur virgule ou point-virgule)', 'Enter your emails list (separator comma or semicolon)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (53, 'cms_forms', '2008-11-14 19:56:24', 'Actions actuelles :', 'Current actions:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (51, 'cms_forms', '2008-11-14 19:56:24', 'Rediriger vers une page', 'Redirect to a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (52, 'cms_forms', '2008-11-14 19:56:24', 'Si le nombre de réponses est dépassé', 'If the number of answers is exceeded');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (50, 'cms_forms', '2008-11-14 19:56:24', 'Afficher un texte', 'Display a text');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (49, 'cms_forms', '2008-11-14 19:56:24', 'Saisissez le nombre maximum de réponses désirées par utilisateurs, ou laisser vide pour ne pas limiter ce nombre', 'Enter the maximum number of wished answers per users, or to leave vacuum not to limit this number ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (48, 'cms_forms', '2008-11-14 19:56:24', 'Nombre de réponses max :<br /><small>(par utilisateurs)</small>', 'Max number of answers :<br /><small>(per users)</small>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (47, 'cms_forms', '2008-11-14 19:56:24', 'Stocker les valeurs du formulaire dans un fichier CSV', 'Store form values in a CSV file ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (45, 'cms_forms', '2008-11-14 19:56:24', 'Non', 'No');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (46, 'cms_forms', '2008-11-14 19:56:24', 'Merci, votre message est enregistré.', 'Thank you, your message has been saved.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (44, 'cms_forms', '2008-11-14 19:56:24', 'Oui', 'Yes');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (43, 'cms_forms', '2008-11-14 19:56:24', 'Envoi des valeurs du formulaire à un email fournis dans un champ du formulaire', 'Sending of form values to one email provided in a field of the form');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (41, 'cms_forms', '2008-11-14 19:56:24', 'Si la saisie du formulaire est correcte', 'If form datas are correct');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (42, 'cms_forms', '2008-11-14 19:56:24', 'Envoi des valeurs du formulaire à un ou plusieurs emails fournis', 'Sending of form values to one or more provided emails ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (396, 'polymod', '2008-11-14 19:56:24', 'Nombre flottant (à virgule)', 'Float number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (397, 'polymod', '2008-11-14 19:56:24', 'Chaîne contenant un nombre à virgule (255 caractères maximum).', 'String containing a float number (255 characters maximum).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (398, 'polymod', '2008-11-14 19:56:24', 'Ensemble des IDs des objets de type ''%s'' associés à ce  champ.', 'All IDs of objects of type ''%s'' associated to this field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (399, 'polymod', '2008-11-14 19:56:24', 'Largeur des boîtes de sélection (pixels)', 'Select boxes width (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (400, 'polymod', '2008-11-14 19:56:24', 'Hauteur des boîtes de sélection (pixels)', 'Select boxes height (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (401, 'polymod', '2008-11-14 19:56:24', 'Uniquement dans le cas de catégories multiples. 300x200 par défaut.', 'Only if multi-categories. Default 300x200.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (402, 'polymod', '2008-11-14 19:56:24', 'Description du champ : ''%s''', 'Field description: ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (403, 'polymod', '2008-11-14 19:56:24', 'Ordre de création', 'Creation order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (404, 'polymod', '2008-11-14 19:56:24', 'Début de publication', 'Publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (405, 'polymod', '2008-11-14 19:56:24', 'Trier par', 'Sort by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (406, 'polymod', '2008-11-14 19:56:24', 'Page', 'Page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (407, 'polymod', '2008-11-14 19:56:24', 'Permet de choisir une page Automne', 'Permit to choose an Automne page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (409, 'polymod', '2008-11-14 19:56:24', 'Largeur de la vignette dans les résultats de la recherche', 'Thumbnail width in search results list');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (410, 'polymod', '2008-11-14 19:56:24', '(largeur de l''image dans la liste des résultats, si elle est visible dans les résultats de la recherche) ', '(only if image is visible in search results)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (411, 'polymod', '2008-11-14 19:56:24', 'Retourne vrai (true) si ce champ possède une valeur', 'Retrun true if this field has a value set');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (412, 'polymod', '2008-11-14 19:56:24', '(Si la vignette dépasse cette hauteur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (413, 'polymod', '2008-11-14 19:56:24', 'Hauteur maximum de l''image en pixels', 'Image maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (414, 'polymod', '2008-11-14 19:56:24', 'Hauteur maximum de la vignette en pixels', 'Thumbnail maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (415, 'polymod', '2008-11-14 19:56:24', '(Sera redimensionnée à %s pixels de hauteur)', '(Will be resized to %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (416, 'polymod', '2008-11-14 19:56:24', '(Sera redimensionnée à %s pixels de largeur et %s  pixels de hauteur)', '(Will be resized to %s pixels width and %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (417, 'polymod', '2008-11-14 19:56:24', 'Unité', 'Unit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (418, 'polymod', '2008-11-14 19:56:24', '(Sera affichée à côté de la valeur)', '(Will be display front of value)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (419, 'polymod', '2008-11-14 19:56:24', 'Unité : "%s"', 'Unit : "%s"');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (420, 'polymod', '2008-11-14 19:56:24', 'Affichage des résultats côté admin', 'Backoffice search results display');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (421, 'polymod', '2008-11-14 19:56:24', 'Syntaxe pour l''objet "%s"', 'Syntax for "%s" object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (422, 'polymod', '2008-11-14 19:56:24', 'Recherchable', 'Searchable');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (423, 'polymod', '2008-11-14 19:56:24', 'Hauteur maximum de la vignette en pixels', 'Maximum height of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (424, 'polymod', '2008-11-14 19:56:24', 'Indexé', 'Indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (425, 'polymod', '2008-11-14 19:56:24', 'Largeur de la fenêtre popup', 'Popup window width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (426, 'polymod', '2008-11-14 19:56:24', 'Hauteur de la fenêtre popup', 'Popup window height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (427, 'polymod', '2008-11-14 19:56:24', 'message(s) envoyé(s)', 'message(s) sent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (428, 'polymod', '2008-11-14 19:56:24', 'Ne recherche que les objets associés à la(aux) catégorie(s) éditable(s) fournie(s) en paramètre', 'Search only objects associated to the category(ies) in parameter');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (429, 'polymod', '2008-11-14 19:56:24', 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre', 'Search only objects which are not associated to the category in parameter');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (430, 'polymod', '2008-11-14 19:56:24', 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre, de façon stricte (les sous-catégories ne sont plus prises en compte)', 'Search only objects which are not associated to the category in parameter, by strict search (sub-categories are not used)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (500, 'polymod', '2008-11-14 19:56:24', 'Les catégories sont employées pour le(s) champ(s) : ', 'Catégories are used for fields: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (501, 'polymod', '2008-11-14 19:56:24', 'Résultats : {0} %s sur {1}', 'Results : {0} %s of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (502, 'polymod', '2008-11-14 19:56:24', 'Résultats : Aucun résultat pour votre recherche ...', 'Results: No result for your search...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (503, 'polymod', '2008-11-14 19:56:24', 'Résultats', 'Results');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (504, 'polymod', '2008-11-14 19:56:24', '{0} %s sur {1}', '{0} %s of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (505, 'polymod', '2008-11-14 19:56:24', 'Supprime le ou les éléments %s sélectionnés. ', 'Remove the or these selected %s elements. ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (506, 'polymod', '2008-11-14 19:56:24', 'Cette action est soumise à une validation ultérieure.', 'This action is subject to later validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (507, 'polymod', '2008-11-14 19:56:24', 'Cette action n''est pas soumise à une validation et est effective directement.', 'This action is not subject to later validation and take effect immediatly.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (508, 'polymod', '2008-11-14 19:56:24', 'Annule la demande de suppression du ou des éléments %s sélectionnés.', 'Cancel the deletion of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (509, 'polymod', '2008-11-14 19:56:24', 'Dévérouille le ou les éléments %s sélectionnés. Attention, si une personne est actuellement en train de modifier cet élément, il pourrait perdre ses modifications.', 'Unlock the or these %s selected elements. Attention, if somebody is currently editing the element, he may lose it''s modifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (510, 'polymod', '2008-11-14 19:56:24', 'Aperçu avant validation du ou des éléments %s sélectionnés.', 'Preview of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (511, 'polymod', '2008-11-14 19:56:24', 'Modification du ou des éléments %s sélectionnés.', 'Modification of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (393, 'polymod', '2008-11-14 19:56:24', 'Affiche uniquement les sous catégories de la racine spécifiée', 'Display only sub categories of the specified root category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (392, 'polymod', '2008-11-14 19:56:24', 'Un opérateur permet de modifier l''affichage d''un champ (<span class="keyword">atm-input</span>) dans un formulaire (<span class="keyword">atm-form</span>). Il s''ajoute au tag <span class="keyword">atm-input</span> en ajoutant le paramètre <span class="keyword">operator</span> suivi de la valeur souhaitée. Les valeurs suivantes sont possibles :', 'An operator can modify the display of a field (tag <span class="keyword">atm-input</span>) in a form (tag <span class="keyword">atm-form</span>). It added to the tag <span class="keyword">atm-input</span> by adding the <span class="keyword">operator</span> parameter followed by the desired value. Following values are available:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (384, 'polymod', '2008-11-14 19:56:24', 'Booléen', 'Boolean');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (385, 'polymod', '2008-11-14 19:56:24', 'Permet spécifier un état (oui - non)', 'Choose a state (yes - no)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (386, 'polymod', '2008-11-14 19:56:24', 'Libellé de la catégorie', 'Category label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (387, 'polymod', '2008-11-14 19:56:24', 'Identifiant des utilisateur/groupe du champ', 'User/group IDs of the field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (388, 'polymod', '2008-11-14 19:56:24', 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés ci-dessous recevront les notifications.<br/>"non" : les utilisateurs/groupes sélectionnés ci-dessous sont exclus de la reception des notifications.', 'If this parameter is :<br/>"yes" : only selected users/groups below will receive notifications.<br/>"no" : selected users/groups below are excluded of the notifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (389, 'polymod', '2008-11-14 19:56:24', 'Permet de faire une recherche sur une valeur incomplète. Utilisez le caractère % pour spécifier la partie inconnue. Par exemple, "cha%" retournera "chat", "chameau", etc.', 'Allow the research on incomplete value. Use the caracter % for the unkown part. For example, "ca%" will return "cat", "car", etc.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (390, 'polymod', '2008-11-14 19:56:24', 'Les valeurs suivantes sont possibles', 'Following values are available');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (391, 'polymod', '2008-11-14 19:56:24', 'Opérateurs des champs de saisie pour ce champ', 'Input field operators for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (382, 'polymod', '2008-11-14 19:56:24', 'Tags de formulaires (création - modification)', 'Forms tags (create - edit)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (383, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n<h1>Cr&eacute;ation modification d''objets cot&eacute; client :</h1>\n<p><span class="code">&lt;atm-form what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">formName</span>&quot;&gt; ... &lt;/atm-form&gt;</span><br />\nCe tag permet de cr&eacute;er un formulaire de saisie pour un nouvel objet (si ce tag n''est pas dans un r&eacute;sultat de recherche) ou de modification pour un objet existsnat (si ce tag se trouve dans un r&eacute;sultat de recherche.</p>\n<ul>\n	<li><span class="keyword">objet</span> : Type d''objet &agrave; saisir (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>\n	<li><span class="keyword">formName</span> : Nom du formulaire : identifiant unique pour le formulaire dans la rang&eacute;e.</li>\n</ul>\nLes valeurs suivantes seront remplac&eacute;es dans le tag :\n<ul>\n	<li><span class="vertclair">{filled}</span> : Vrai si le formulaire a &eacute;t&eacute; correctement rempli et que sa validation n''a provoqu&eacute; aucune erreur.</li>\n	<li><span class="vertclair">{required}</span> : Vrai si le formulaire n''a pas &eacute;t&eacute; correctement rempli et que des champs requis ont &eacute;t&eacute; laiss&eacute;s vides.</li>\n	<li><span class="vertclair">{malformed}</span> : Vrai si le formulaire n''a pas &eacute;t&eacute; correctement rempli et que les values de certains champs sont incorrectes.</li>\n</ul>\n<h2>Ce tag peut contenir les sous-tags suivants :</h2>\n<div class="retrait">\n<h3>Affichage des champs requis :</h3>\n<div class="retrait"><span class="code">&lt;atm-form-required form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{requiredname}</span> ...<br />\n&lt;/atm-form-required&gt;</span><br />\nLe contenu du tag sera lu pour chaque champ requis lors de la saisie du formulaire.<br />\n<ul>\n	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>\n</ul>\n<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>\n<ul>\n	<li><span class="vertclair">{firstrequired}</span> : Vrai si le champ requis en cours est le premier du formulaire en cours.</li>\n	<li><span class="vertclair">{last</span><span class="vertclair">required</span><span class="vertclair">}</span> : Vrai si le champ requis en cours est le dernier du formulaire en cours.</li>\n	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">count}</span> : Num&eacute;ro du champ requis dans le formulaire en cours.</li>\n	<li><span class="vertclair">{max</span><span class="vertclair">required</span><span class="vertclair">}</span> : Nombre de champs requis dans le formulaire en cours.</li>\n	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">name}</span> : Nom du champ requis dans le formulaire en cours.</li>\n	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">field}</span> : Objet champ requis dans le formulaire en cours.</li>\n</ul>\n</div>\n<h3>Affichage des champs malform&eacute;s :</h3>\n<div class="retrait"><span class="code">&lt;atm-form-malformed form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{malformedname}</span> ...<br />\n&lt;/atm-form-malformed&gt;</span><br />\nLe contenu du tag sera lu pour chaque champ malform&eacute; lors de la saisie du formulaire.<br />\n<ul>\n	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>\n</ul>\n<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>\n<ul>\n	<li><span class="vertclair">{firstmalformed}</span> : Vrai si le champ malform&eacute; en cours est le premier du formulaire en cours.</li>\n	<li><span class="vertclair">{lastmalformed}</span> : Vrai si le champ malform&eacute; en cours est le dernier du formulaire en cours.</li>\n	<li><span class="vertclair">{malformedcount}</span> : Num&eacute;ro du champ malform&eacute; dans le formulaire en cours.</li>\n	<li><span class="vertclair">{maxmalformed}</span> : Nombre de champs malform&eacute;s dans le formulaire en cours.</li>\n	<li><span class="vertclair">{malformedname}</span> : Nom du champ malform&eacute; dans le formulaire en cours.</li>\n	<li><span class="vertclair">{malformedfield}</span> : Objet champ malform&eacute; dans le formulaire en cours.</li>\n</ul>\n</div>\n<h3>Affichage d''un champ de saisie :</h3>\n<div class="retrait"><span class="code">&lt;atm-input field=&quot;<span class="keyword">{objet:champ}</span>&quot; form=&quot;<span class="keyword">formName</span>&quot; /&gt;</span><br />\nCe tag sera remplac&eacute; par la zone de saisie (champ de formulaire) n&eacute;cessaire &agrave; la saisie correcte des informations relatives au type du champ sp&eacute;cifi&eacute;.<br />\n<ul>\n	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>\n	<li><span class="keyword">{objet:champ}</span> : Champ de l''objet g&eacute;r&eacute; par le formulaire sur lequel la saisie doit &ecirc;tre effectu&eacute;e.</li>\n</ul>\n<p>Ce tag peut ensuite avoir tout une suite d''attributs html qui seront repost&eacute;s sur le code HTML du champ g&eacute;n&eacute;r&eacute; (<span class="vertclair">width, height, id, class, etc.</span>).</p>\n</div>\n</div>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (381, 'polymod', '2008-11-14 19:56:24', 'Ne recherche que les objets associés à la catégorie en paramètre (les sous-catégories ne sont plus prises en compte)', 'Search only objects associated to the category in parameter (sub-categories are not used)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (380, 'polymod', '2008-11-14 19:56:24', '<br/><span class="keyword">&gt;=</span> : supérieur ou égal<br/><span class="keyword">&lt;=</span> : inférieur ou égal<br/><span class="keyword">&lt;</span> : inférieur<br/><span class="keyword">&gt;</span> : supérieur<br/><span class="keyword">&gt;= or null</span> : supérieur ou égal ou nul<br/><span class="keyword">&lt;= or null</span> : inférieur ou égal ou nul<br/><span class="keyword">&lt; or null</span> : inférieur ou nul<br/><span class="keyword">&gt; or null</span> : supérieur ou nul<br/><span class="keyword">&gt;= and not null</span> : (supérieur ou égal) et non nul<br/><span class="keyword">&lt;= and not null</span> : (inférieur ou égal) et non nul<br/><span class="keyword">&lt; and not null</span> : inférieur et non nul<br/><span class="keyword">&gt; and not null</span> : supérieur et non nul', '<br/><span class="keyword">&gt;=</span> : greater or equal<br/><span class="keyword">&lt;=</span> : lower or equal<br/><span class="keyword">&lt;</span> : lower<br/><span class="keyword">&gt;</span> : greater<br/><span class="keyword">&gt;= or null</span> : greater or equal or null<br/><span class="keyword">&lt;= or null</span> : lower or equal or null<br/><span class="keyword">&lt; or null</span> : lower or null<br/><span class="keyword">&gt; or null</span> : greater or null<br/><span class="keyword">&gt;= and not null</span> : (greater or equal) and not null<br/><span class="keyword">&lt;= and not null</span> : (lower or equal) and not null<br/><span class="keyword">&lt; and not null</span> : lower and not null<br/><span class="keyword">&gt; and not null</span> : greater and not null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (379, 'polymod', '2008-11-14 19:56:24', 'Un opérateur permet de modifier le fonctionnement d''un filtre (tag <span class="keyword">atm-search-param</span>) dans une recherche. Il s''ajoute au filtre en ajoutant le paramètre <span class="keyword">operator</span> suivit de la valeur souhaitée au tag <span class="keyword">atm-search-param</span> proposant un filtre sur ce champ. Les valeurs suivantes sont possibles :', 'An operator can modify the operation of a filter (tag <span class="keyword">atm-search-param</span>) in a search. It added to the filter by adding the <span class="keyword">operator</span> parameter followed by the desired value to tag <span class="keyword">atm-search-param</span> proposing a filter on that field. Following values are available:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (378, 'polymod', '2008-11-14 19:56:24', 'Opérateurs des filtres de recherche pour ce champ', 'Search filter operator for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (364, 'polymod', '2008-11-14 19:56:24', 'Notification de validation en attente', 'Notification of awaiting validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (365, 'polymod', '2008-11-14 19:56:24', 'Notification de suppression en attente', 'Notification of deletion validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (366, 'polymod', '2008-11-14 19:56:24', 'Champ requis (renvoie un booléen true ou false)', 'Required field (return a boolean true or false)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (367, 'polymod', '2008-11-14 19:56:24', 'Catégorie par défaut', 'Default category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (368, 'polymod', '2008-11-14 19:56:24', 'Date de création de l''objet', 'Creation date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (369, 'polymod', '2008-11-14 19:56:24', 'Décalage temporel', 'Time offset');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (370, 'polymod', '2008-11-14 19:56:24', 'Si "Date du jour", "Date de création" ou "Date de mise à jour" est sélectionné, décaler la valeur de cette durée (Voir le <a href="http://www.php.net/manual/fr/function.strtotime.php" target="_blank" class="admin">format de la fonction strtotime</a>)', 'If "Current date", "Creation date" or "Update date" is selected, offset the date of this value (See the <a href="http://www.php.net/manual/en/function.strtotime.php" target="_blank" class="admin">function strtotime format</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (371, 'polymod', '2008-11-14 19:56:24', 'Date de mise à jour de l''objet', 'Update date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (372, 'polymod', '2008-11-14 19:56:24', 'Format à respecter', 'Format to comply');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (373, 'polymod', '2008-11-14 19:56:24', 'Ce champ vous permet de spécifier un format à respecter en utilisant une expression régulière PERL (<a href="http://www.php.net/manual/fr/reference.pcre.pattern.syntax.php" target="_blank" class="admin">voir l''aide du format</a>)', 'This field allow you to specify a format to match using a PERL regular expression (<a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank" class="admin">see format help</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (374, 'polymod', '2008-11-14 19:56:24', 'Extensions autorisées', 'Allowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (375, 'polymod', '2008-11-14 19:56:24', 'Séparées par une virgule', 'Comma separated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (376, 'polymod', '2008-11-14 19:56:24', 'Extensions interdites', 'Disallowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (377, 'polymod', '2008-11-14 19:56:24', 'Utilisateur créant l''objet', 'User creating object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (314, 'polymod', '2008-11-14 19:56:24', 'Utilisateurs', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (315, 'polymod', '2008-11-14 19:56:24', 'Groupes', 'Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (316, 'polymod', '2008-11-14 19:56:24', 'Tous les utilisateurs', 'All users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (317, 'polymod', '2008-11-14 19:56:24', 'Utilisateurs inclus/exclus', 'Included/excluded users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (318, 'polymod', '2008-11-14 19:56:24', 'Tous les groupes', 'All groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (319, 'polymod', '2008-11-14 19:56:24', 'Groupes inclus/exclus', 'Included/excluded groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (320, 'polymod', '2008-11-14 19:56:24', 'Inclusion', 'Inclusion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (321, 'polymod', '2008-11-14 19:56:24', 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés sont affichés dans la liste déroulante du champs.<br/>"non" : les utilisateurs sélectionnés sont exclus de la liste déroulante du champs.', 'If this parameter is :<br/>"yes" : only selected users/groups are display in the selection box of the field.<br/>"no" : selected users are excluded of the selection box of the field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (322, 'polymod', '2008-11-14 19:56:24', 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (323, 'polymod', '2008-11-14 19:56:24', 'Langue', 'Language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (324, 'polymod', '2008-11-14 19:56:24', 'Langue de l''objet. Créé une relation avec les langues disponibles sur le système. Nécessaire à l''indexation correcte dans le moteur de recherche.', 'Language of the object. It create a relationship with system''s languages. Needed for a correct indexation in search engine.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (325, 'polymod', '2008-11-14 19:56:24', 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (326, 'polymod', '2008-11-14 19:56:24', 'Indexation', 'Indexation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (327, 'polymod', '2008-11-14 19:56:24', 'Si cet objet appartient en tant que champs à un objet indexé, inutile de l''indexer lui même', 'If this object belongs as a field to an indexed object, it is useless to index itself');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (328, 'polymod', '2008-11-14 19:56:24', 'Adresse du lien vers l''objet', 'Link address to the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (329, 'polymod', '2008-11-14 19:56:24', 'Cette adresse devra permettre d''aller vers l''objet à partir des résultats de recherche.', 'This address will have to make possible to go towards the object from the search results.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (330, 'polymod', '2008-11-14 19:56:24', 'Indexer uniquement le dernier sous-objet', 'Index only the last sub-object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (331, 'polymod', '2008-11-14 19:56:24', 'Cette option est utile pour le versioning d''objets ou les versions antérieures ne doivent pas être indexées dans le moteur de recherche.', 'This option is usefull in case of object versioning which older versions does not need to be indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (332, 'polymod', '2008-11-14 19:56:24', 'Désactiver l''association de sous-objets', 'Disactivate selection of sub-objets');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (333, 'polymod', '2008-11-14 19:56:24', 'Cette option permet d''empêcher l''emploi de sous-objets crées en dehors de l''objet principal. Elle n''est utile que si l''option "Ces objets peuvent être édités" est active.', 'This option avoid the use of objects which are not created inside the master object. It is usefull only if the option "These objects can be edited" is active.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (334, 'polymod', '2008-11-14 19:56:24', 'Contourner les droits', 'Bypass rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (335, 'polymod', '2008-11-14 19:56:24', 'Permet de ne pas tenir compte des droits de ces catégories pour les recherches', 'Do not use categories rights management for searching');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (336, 'polymod', '2008-11-14 19:56:24', 'Notification par email', 'Notify by email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (337, 'polymod', '2008-11-14 19:56:24', 'Ce champs permet d''envoyer une notification par email lors de la validation d''un objet', 'This field allow email notification when object is validated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (338, 'polymod', '2008-11-14 19:56:24', 'Sujet de l''email', 'Email subject');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (339, 'polymod', '2008-11-14 19:56:24', 'Corps de l''email', 'Email body');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (340, 'polymod', '2008-11-14 19:56:24', 'Emission au choix', 'Choice for sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (341, 'polymod', '2008-11-14 19:56:24', 'Hauteur de l''éditeur', 'Editor height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (342, 'polymod', '2008-11-14 19:56:24', 'Largeur de l''éditeur', 'Editor width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (343, 'polymod', '2008-11-14 19:56:24', 'Permet de choisir lors de l''édition de l''objet si l''email doit être envoyé', 'Allow to choose if the email will be sent at object edition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (344, 'polymod', '2008-11-14 19:56:24', 'Inclure des fichiers', 'Include files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (345, 'polymod', '2008-11-14 19:56:24', 'Permet d''inclure les fichiers de l''objet en pièce jointe dans l''email', 'Allow the inclusion as attachment of object files in the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (346, 'polymod', '2008-11-14 19:56:24', 'Emetteur de l''email', 'Email sender');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (347, 'polymod', '2008-11-14 19:56:24', 'Permet de spécifier une adresse d''emetteur pour l''email. Si aucun, l''adresse "postmaster" d''Automne sera employée.', 'Allow usage of a specific email address for email sending. If none, "postmaster" Automne email will be used');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (348, 'polymod', '2008-11-14 19:56:24', 'A la validation', 'On validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (349, 'polymod', '2008-11-14 19:56:24', 'Evènement système', 'System event');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (350, 'polymod', '2008-11-14 19:56:24', 'Emission', 'Sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (351, 'polymod', '2008-11-14 19:56:24', 'L''email sera envoyé à la validation de l''objet ou déclenché par un évènement système à spécifier (code PHP spécifique).', 'Email will be sent at validation or by a specified system event (specific PHP code).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (363, 'polymod', '2008-11-14 19:56:24', 'Libellé des objets (séparés par des virgules, ou spécifiez un séparateur en paramètre)', 'Objects labels (comma separated or specify a separator in parameter)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (360, 'polymod', '2008-11-14 19:56:24', 'Envoi d''une notification email', 'Sending email notification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (361, 'polymod', '2008-11-14 19:56:24', 'Autoriser l''association des inutilisées', 'Allow association of the unused ones');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (362, 'polymod', '2008-11-14 19:56:24', 'Permet de sélectionner les catégories inutilisées dans les rangées', 'Allow association of the unused categories in rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (359, 'polymod', '2008-11-14 19:56:24', 'Preparation des notifications par email', 'Prepare emails notifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (358, 'polymod', '2008-11-14 19:56:24', 'Inactif', 'inactive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (357, 'polymod', '2008-11-14 19:56:24', 'Actif', 'Active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (356, 'polymod', '2008-11-14 19:56:24', 'Jamais', 'Never');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (355, 'polymod', '2008-11-14 19:56:24', 'Dernier envoi', 'Last sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (354, 'polymod', '2008-11-14 19:56:24', 'Code HTML', 'HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (352, 'polymod', '2008-11-14 19:56:24', 'Syntaxe de la définition du sujet et du corps de l''email', 'Syntax definition for the subject and body of the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (353, 'polymod', '2008-11-14 19:56:24', 'Où choisir une page', 'Or choose a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (312, 'polymod', '2008-11-14 19:56:24', '<strong>Permet de charger un objet par son identifiant&nbsp; :<br />\n<br />\n</strong><span class="code">&lt;atm-function function=&quot;loadObject&quot; object=&quot;%s&quot; value=&quot;<span class="keyword">objectId</span>&quot;&gt;&lt;/atm-function&gt;</span><br />\nCette fonction permet de charger depuis la base de donn&eacute;e l''objet correspondant &agrave; l''identifiant fourni en param&egrave;tre. L''objet ainsi charg&eacute; devient accessible m&ecirc;me en dehors d''une recherche.<br />\n<ul>\n	<li><span class="keyword">objectId </span><strong>: </strong>Identifiant unique de l''objet &agrave; charger.</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (313, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n<h1>Bloc de donn&eacute;es d''un fil RSS :</h1>\n<span class="code">&lt;atm-rss language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-title&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &lt;atm-search ...&gt;<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;atm-result ...&gt;<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="keyword"> &lt;atm-rss-item&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-url&gt;</span>{page:id:url}?item={object:id}<span class="keyword">&lt;/atm-rss-item-url&gt; </span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-title&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-content&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-content&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-author&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-author&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-date&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-date&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-category&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-category&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-rss-item&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;/atm-result&gt;<br />\n&nbsp;&nbsp;&nbsp; &lt;/atm-search&gt;<br />\n&lt;/atm-rss&gt;</span><br />\n<br />\nCe tag permet de cr&eacute;er un fil RSS &agrave; partir d''objets r&eacute;pondant &agrave; une recherche.<br />\n<ul>\n	<li><strong><span class="keyword">languageCode </span></strong>: Code du langage relatif au contenu parmi les codes suivants : <strong><span class="vertclair">%s</span></strong>.</li>\n</ul>\nLe tag <span class="keyword">atm-rss</span> peut contenir un tag <span class="keyword">atm-rss-title</span> (facultatif) permettant de red&eacute;finir le titre du fil RSS. <br />\nLe tag <span class="keyword">atm-rss</span><strong> </strong>doit contenir un sous tag <span class="keyword">atm-rss-item</span> lui m&ecirc;me devant &ecirc;tre dans un r&eacute;sultat d''une recherche. Pour chaque &eacute;l&eacute;ment r&eacute;sultat de la recherche, ce tag permettra la cr&eacute;ation d''un &eacute;l&eacute;ment correspondant dans le fil RSS.<br />\n<br />\nLe tag <span class="keyword">atm-rss-item</span> doit<strong> </strong>contenir les sous tags suivants :<br />\n<ul>\n	<li><span class="keyword">atm-rss-item-url</span><strong> :</strong> Tag obligatoire, il permet de sp&eacute;cifier l''adresse internet source de l''&eacute;l&eacute;ment du fil RSS (Les aggr&eacute;gateurs RSS s''en servent pour cr&eacute;er un lien vers cet &eacute;l&eacute;ment sur votre site). Ce doit donc &ecirc;tre une adresse valide vers l''&eacute;l&eacute;ment source. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-title</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le nom de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-content</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le contenu de l''&eacute;l&eacute;ment du fil RSS. Le code HTML y est autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n</ul>\nLe tag <span class="keyword">atm-rss-item</span> peut<strong> </strong>contenir les sous tags suivants :<br />\n<ul>\n	<li><span class="keyword">atm-rss-item-author</span><strong> : </strong>Ce tag permet de sp&eacute;cifer l''auteur de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-date</span><strong> :</strong> Ce tag permet de sp&eacute;cifer la date de cr&eacute;ation de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item. Pensez &agrave; employer le format <span class="vertclair">rss</span> si vous employez la valeur d''un champ de type Date.</li>\n	<li><span class="keyword">atm-rss-item-category</span><strong> :</strong> Ce tag permet de sp&eacute;cifer une le nom d''une cat&eacute;gorie pour l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Vous pouvez mettre plusieurs tags de ce type dans chaque tag atm-rss-item.</li>\n</ul>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (305, 'polymod', '2008-11-14 19:56:24', 'Fréquence dans cet interval', 'Frequency in this interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (306, 'polymod', '2008-11-14 19:56:24', 'Horaire', 'Hourly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (307, 'polymod', '2008-11-14 19:56:24', 'Quotidienne', 'Daily');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (308, 'polymod', '2008-11-14 19:56:24', 'Hebdomadaire', 'Weekly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (309, 'polymod', '2008-11-14 19:56:24', 'Mensuelle', 'Monthly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (310, 'polymod', '2008-11-14 19:56:24', 'Annuelle', 'Yearly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (311, 'polymod', '2008-11-14 19:56:24', '<strong>Permet de faire un lien vers l''un des fil RSS de l''objet&nbsp; :<br />\n</strong><br />\n<span class="code">&lt;atm-function function=&quot;rss&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">rssId</span>&quot; attributeName=&quot;<span class="keyword">attributeValue</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; &lt;a href=&quot;<span class="vertclair">{url}</span>&quot; title=&quot;<span class="vertclair">{description}</span>&quot;&gt;<span class="vertclair">{label}</span>&lt;/a&gt;<br />\n&lt;/atm-function&gt;</span><br />\nCette fonction permet d''obtenir les informations concernant l''un des fil RSS de l''objet. Elle est usuellement utilis&eacute;e pour r&eacute;aliser un lien d''abonnement vers ce fil RSS.<br />\n<ul>\n	<li><span class="keyword">rssId </span><strong>: </strong>Identifiant du fil RSS &agrave; selectionner parmis les suivants : %s</li>\n	<li>L''attribut <span class="keyword">attributeName </span>et sa valeur <span class="keyword">attributeValue </span>sont facultatifs. Ils permettent d''ajouter un attribut et sa valeur &agrave; l''adresse du fil RSS g&eacute;n&eacute;r&eacute; par la fonction. Vous pouvez mettre autant d''attributs suppl&eacute;mentaires de cette fa&ccedil;on.</li>\n	<li><span class="vertclair">{url}</span> sera remplac&eacute; par l''adresse du fil RSS.</li>\n	<li><span class="vertclair">{label}</span> sera remplac&eacute; par le libell&eacute; du fil RSS.</li>\n	<li><span class="vertclair">{description}</span> sera remplac&eacute; par la description du fil RSS.</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (298, 'polymod', '2008-11-14 19:56:24', 'Auteur', 'Author');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (299, 'polymod', '2008-11-14 19:56:24', 'Email de l''auteur', 'Author email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (300, 'polymod', '2008-11-14 19:56:24', 'Copyright', 'Copyright');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (301, 'polymod', '2008-11-14 19:56:24', 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (302, 'polymod', '2008-11-14 19:56:24', 'Liste de termes séparés par des virgules permettant de catégoriser le fil RSS', 'Terms list separated by commas allowing to categorize the RSS feed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (303, 'polymod', '2008-11-14 19:56:24', 'Interval de mise à jour', 'Update interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (304, 'polymod', '2008-11-14 19:56:24', 'Permet aux lecteurs de fils RSS d''avoir une valeur indicative concernant la fréquence de mise à jour du fil. Par défaut : une fois par jour, minimum : 2 fois par heures.', 'Give to the feed reader an indicative value of the update frequency of the feed. By default : once a day, minimum : twice an hours');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (296, 'polymod', '2008-11-14 19:56:24', 'Adresse vers le site du fil', 'Address to the feed website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (297, 'polymod', '2008-11-14 19:56:24', 'Ce lien sera employé dans le fil RSS et permettra d''aller au site source du fil. Si ce champ n''est pas rempli, l''adresse ''%s'' sera utilisée.', 'This link will be used in the RSS feed and will allow to go to source website of the feed. If this field is not filled, the address ''%s'' will be used.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (294, 'polymod', '2008-11-14 19:56:24', 'Fils RSS', 'RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (295, 'polymod', '2008-11-14 19:56:24', '<strong>Bloc de donn&eacute;es d''un module WYSIWYG :<br /><br />&lt;atm-plugin language=&quot;</strong>languageCode<strong>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-invalid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-invalid&gt;<br />&lt;/atm-plugin&gt;</strong><br /><br />Ce tag permet l''affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l''&eacute;diteur de texte visuel (WYSIWYG).<br />Le tag <strong>atm-plugin-valid</strong> sera lu si l''objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />Le tag <strong>atm-plugin-invalid</strong> (facultatif) sera lu si l''objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l''utilisateur n''a pas les droits de consultation de cet objet).<br /><ul><li><strong>languageCode</strong> : Code du langage relatif au contenu parmi les codes suivants : <strong>%s</strong>.</li><li><strong>{plugin:selection}</strong> : Sera replac&eacute; par la valeur s&eacute;lectionn&eacute;e dans le Wysiwyg (facultatif).</li></ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (293, 'polymod', '2008-11-14 19:56:24', 'Syntaxe de la définition du fil RSS pour l''objet ''%s''', 'Syntax definition for the RSS feed for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (292, 'polymod', '2008-11-14 19:56:24', 'Création / modification d''un fil RSS pour l''objet ''%s''', 'Create / Edit an RSS feed for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (291, 'polymod', '2008-11-14 19:56:24', 'Confirmez-vous la suppression du fil RSS ''%s'' ? Attention cette suppression est définitive, elle n''est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the RSS Feed ''%s''? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (290, 'polymod', '2008-11-14 19:56:24', 'Fils RSS associés', 'Associated RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (289, 'polymod', '2008-11-14 19:56:24', '<strong>Charge une cat&eacute;gorie donn&eacute;e :<br />\n</strong><br />\n<span class="code"> &lt;atm-function function=&quot;category&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <br />\n&lt;/atm-function&gt;</span><strong><br />\n</strong>Cette fonction permet d''afficher le contenu d''une cat&eacute;gorie donn&eacute;e.<br />\n<ul>\n	<li><span class="keyword">categoryID </span><strong>: </strong>L''identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>\n	<li>La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (288, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n<h1>Bloc de donn&eacute;es d''un module WYSIWYG :</h1>\n<span class="code"> &lt;atm-plugin language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-valid&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-valid&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-invalid&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-invalid&gt;</span><br />\n&lt;/atm-plugin&gt;</span><br />\n<br />\nCe tag permet l''affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l''&eacute;diteur de texte visuel (WYSIWYG).<br />\nLe <span class="keyword">tag atm-plugin-valid</span> sera lu si l''objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />\nLe tag <span class="keyword">atm-plugin-invalid </span>(facultatif) sera lu si l''objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l''utilisateur n''a pas les droits de consultation de cet objet).<br />\n<ul>\n	<li><span class="keyword">languageCode </span>: Code du langage relatif au contenu parmi les codes suivants : <span class="vertclair">%s</span>.</li>\n	<li><span class="keyword">{plugin:selection}</span> : Sera replac&eacute; par la valeur textuelle s&eacute;lectionn&eacute;e dans l''&eacute;diteur (facultatif).</li>\n</ul>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (287, 'polymod', '2008-11-14 19:56:24', 'Modules WYSIWYG', 'WYSIWYG plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (286, 'polymod', '2008-11-14 19:56:24', '[Erreur : Ce module nécessite d''avoir sélectionné un texte. Merci de sélectionner le texte souhaité ...]', '[Error : this plugin must have a selected text. Please select a text first ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (284, 'polymod', '2008-11-14 19:56:24', 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (285, 'polymod', '2008-11-14 19:56:24', 'Déselectionner', 'Deselect');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (283, 'polymod', '2008-11-14 19:56:24', 'Elément actuellement sélectionné', 'Item currently selected');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (281, 'polymod', '2008-11-14 19:56:24', 'Type', 'Type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (282, 'polymod', '2008-11-14 19:56:24', 'Editeur de texte', 'Text editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (280, 'polymod', '2008-11-14 19:56:24', '[Erreur : Aucun module WYSIWYG disponible ...]', '[Error : No WYSIWYG plugin available ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (279, 'polymod', '2008-11-14 19:56:24', 'Confirmez-vous la suppression du module WYSIWYG ''%s'' ? Attention cette suppression est définitive, elle n''est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the WYSIWYG plugin ''%s''? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (278, 'polymod', '2008-11-14 19:56:24', 'Syntaxe de la définition du module WYSIWYG pour l''objet ''%s''', 'Syntax definition for the WYSIWYG plugin for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (276, 'polymod', '2008-11-14 19:56:24', 'Propriétés de l''objet', 'Object properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (277, 'polymod', '2008-11-14 19:56:24', 'Création / modification d''un module WYSIWYG pour l''objet ''%s''', 'Create / Edit a WYSIWYG plugin for object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (275, 'polymod', '2008-11-14 19:56:24', 'Modules WYSIWYG associés', 'Associated WYSIWYG Plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (274, 'polymod', '2008-11-14 19:56:24', 'Email de l''utilisateur', 'Email of the user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (273, 'polymod', '2008-11-14 19:56:24', 'Email d''un utilisateur du champ (utilisable dans un tag atm-loop)', 'Email of one user of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (272, 'polymod', '2008-11-14 19:56:24', 'Nom et prénom de l''utilisateur ou nom du groupe', 'Lastname and firstname of the user or name of the group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (271, 'polymod', '2008-11-14 19:56:24', '<strong>Liste de tous les utilisateurs/groupes du champ :<br />\n</strong><br />\n<span class="code"> &lt;select&gt;<strong>&lt;</strong>atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span><strong>&quot;&gt;&lt;/</strong>atm-function<strong>&gt;</strong>&lt;/select&gt;</span><br />\nCette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les utilisateurs/groupes du champ donn&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.<br />\n<ul>\n	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de l''utilisateur/groupe &agrave; selectionner dans la liste</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (268, 'polymod', '2008-11-14 19:56:24', 'La valeur est l''utilisateur actuel', 'Value is the current user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (269, 'polymod', '2008-11-14 19:56:24', 'Ce paramètre exclu les autres', 'This parameter exclude the others');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (270, 'polymod', '2008-11-14 19:56:24', 'Si ce paramètre est sélectionné, vous pourrez utiliser des groupes d''utilisateurs. Sinon, ce sera des utilisateurs', 'If this parameter is selected, you will use groups of users. Otherwise, it will be users.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (267, 'polymod', '2008-11-14 19:56:24', 'Utiliser des groupes', 'Use groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (266, 'polymod', '2008-11-14 19:56:24', 'Multiples utilisateurs ou groupes', 'Multiples users or groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (220, 'polymod', '2008-11-14 19:56:24', 'Largeur de l''image en pixels', 'Image width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (221, 'polymod', '2008-11-14 19:56:24', 'Hauteur de l''image en pixels', 'Image height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (222, 'polymod', '2008-11-14 19:56:24', 'Largeur de l''image zoom en pixels', 'Image zoom width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (223, 'polymod', '2008-11-14 19:56:24', 'Hauteur de l''image zoom en pixels', 'Image zoom height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (224, 'polymod', '2008-11-14 19:56:24', 'Poids de l''image en Mo', 'Image file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (225, 'polymod', '2008-11-14 19:56:24', 'Poids de l''image zoom en Mo', 'Image zoom file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (226, 'polymod', '2008-11-14 19:56:24', 'La valeur du champ doit-être un email valide', 'Field value must be a valid email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (227, 'polymod', '2008-11-14 19:56:24', 'Fichier', 'File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (228, 'polymod', '2008-11-14 19:56:24', 'Champ contenant un fichier avec ou sans vignette', 'Field with a file, with or without thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (229, 'polymod', '2008-11-14 19:56:24', 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (230, 'polymod', '2008-11-14 19:56:24', 'Utiliser une vignette pour le fichier', 'Use thumbnail for file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (231, 'polymod', '2008-11-14 19:56:24', '<!--Icônes de type pour les fichiers-->', '<!--Type icons for files-->');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (232, 'polymod', '2008-11-14 19:56:24', 'Fichier source', 'Source file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (233, 'polymod', '2008-11-14 19:56:24', 'ou Fichier FTP', 'or FTP file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (234, 'polymod', '2008-11-14 19:56:24', 'Chemin du repertoire FTP à utiliser', 'Path for FTP directory to use');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (235, 'polymod', '2008-11-14 19:56:24', '(Laissez vide pour empêcher l''utilisation d''un répertoire FTP comme source pour vos documents)', '(Leave empty to prevent the use of a FTP directory as a source for your documents');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (236, 'polymod', '2008-11-14 19:56:24', '(max : %s)', '(max : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (237, 'polymod', '2008-11-14 19:56:24', '(Répertoire FTP : %s)', '(FTP directory : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (238, 'polymod', '2008-11-14 19:56:24', 'Chemin vers l''icône du fichier (si elle existe)', 'Path to the file icon (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (239, 'polymod', '2008-11-14 19:56:24', 'Type de fichier (extension)', 'File type (extension)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (240, 'polymod', '2008-11-14 19:56:24', 'Cochez la case pour effacer le fichier', 'Check the box to delete file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (241, 'polymod', '2008-11-14 19:56:24', 'Fichier actuel', 'Current file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (242, 'polymod', '2008-11-14 19:56:24', 'Code HTML du fichier', 'File HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (243, 'polymod', '2008-11-14 19:56:24', 'Libellé du fichier', 'File label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (244, 'polymod', '2008-11-14 19:56:24', 'Nom du fichier', 'File name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (245, 'polymod', '2008-11-14 19:56:24', 'Nom du fichier de la vignette', 'Thumbnail file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (246, 'polymod', '2008-11-14 19:56:24', 'Chemin du repertoire du fichier et de la vignette', 'Path to the file and thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (247, 'polymod', '2008-11-14 19:56:24', 'Largeur de la vignette en pixels', 'Thumbnail width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (248, 'polymod', '2008-11-14 19:56:24', 'Hauteur de a vignette en pixels', 'Thumbnail height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (249, 'polymod', '2008-11-14 19:56:24', 'Autoriser l''utilisation de fichiers du repertoire FTP', 'Allow usage of FTP files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (250, 'polymod', '2008-11-14 19:56:24', '(Permet, pour les gros fichiers, d''utiliser un répertoire d''automne pour déposer des fichiers via FTP)', '(Allow, for big files, to use an Automne directory to store files with FTP)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (251, 'polymod', '2008-11-14 19:56:24', 'Poids du fichier en Mo', 'File Size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (252, 'polymod', '2008-11-14 19:56:24', 'Renvoi vrai si l''objet contient un lien valide.', 'Return true if object contain a valid link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (253, 'polymod', '2008-11-14 19:56:24', 'Largeur maximum de l''image en pixels', 'Image maximum width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (254, 'polymod', '2008-11-14 19:56:24', 'Adresse de prévisualisation', 'Preview  address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (255, 'polymod', '2008-11-14 19:56:24', 'Valeur HTML du texte (retours chariots convertis pour le texte seul)', 'HTML value of the text (Line breaks converted for plain-text)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (256, 'polymod', '2008-11-14 19:56:24', 'Fichier associé à la catégorie du champ', 'File associated to the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (257, 'polymod', '2008-11-14 19:56:24', 'Fichier d''une catégorie du champ (utilisable dans un tag atm-loop)', 'One category File of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (258, 'polymod', '2008-11-14 19:56:24', 'Sans %s', 'Without %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (259, 'polymod', '2008-11-14 19:56:24', 'Nombre d''utilisateurs/groupes associées à ce champ', 'Number of users/groups associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (260, 'polymod', '2008-11-14 19:56:24', 'Utilisateurs/Groupes associés à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Users/Groups associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (261, 'polymod', '2008-11-14 19:56:24', 'Identifiant d''un utilisateur/groupe du champ (utilisable dans un tag atm-loop)', 'One user/group ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (262, 'polymod', '2008-11-14 19:56:24', 'Nom et prénom d''un utilisateur ou nom d''un groupe du champ (utilisable dans un tag atm-loop)', 'Lastname and firstname of one user or name of one group of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (263, 'polymod', '2008-11-14 19:56:24', 'Identifiant de l''utilisateur ou du groupe', 'Id of the user or group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (264, 'polymod', '2008-11-14 19:56:24', 'Utilisateur/Groupe', 'User/Group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (265, 'polymod', '2008-11-14 19:56:24', 'Permet d''associer un ou plusieurs utilisateurs ou groupe(s) d''utilisateurs', 'Allows you to associate one or more users or group(s) of users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (204, 'polymod', '2008-11-14 19:56:24', 'Date de fin de publication formatée (si elle existe). Remplacez ''format'' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>', 'Formatted date. Replace ''format'' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">''date function''</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (205, 'polymod', '2008-11-14 19:56:24', 'Utiliser l''image originale comme image zoom', 'Use original image as zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (206, 'polymod', '2008-11-14 19:56:24', 'Vignette', 'Thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (207, 'polymod', '2008-11-14 19:56:24', 'Image zoom', 'Zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (208, 'polymod', '2008-11-14 19:56:24', '(Sera redimensionnée à %s pixels de large)', '(Will be resized to %s pixels width)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (209, 'polymod', '2008-11-14 19:56:24', 'Utiliser une image zoom distincte', 'Use distinct zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (210, 'polymod', '2008-11-14 19:56:24', '(Si vous n''utilisez pas d''image zoom distincte)', '(If you do no uses a distinct image zoom)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (211, 'polymod', '2008-11-14 19:56:24', 'Conserver l''image originale comme image zoom', 'Keep original image as an image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (212, 'polymod', '2008-11-14 19:56:24', '(Si la vignette dépasse cette largeur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (213, 'polymod', '2008-11-14 19:56:24', 'Cochez la case pour effacer l''image', 'Check the box to delete image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (214, 'polymod', '2008-11-14 19:56:24', 'Image actuelle', 'Current image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (215, 'polymod', '2008-11-14 19:56:24', 'Code HTML de l''image. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Image HTML code. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (216, 'polymod', '2008-11-14 19:56:24', 'Libellé de l''image', 'Image label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (217, 'polymod', '2008-11-14 19:56:24', 'Nom du fichier de l''image', 'Image file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (218, 'polymod', '2008-11-14 19:56:24', 'Nom du fichier de l''image zoom', 'Image file name zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (219, 'polymod', '2008-11-14 19:56:24', 'Chemin du repertoire de l''image et de l''image zoom', 'Path to the image and image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (165, 'polymod', '2008-11-14 19:56:24', '<strong>Liste de toutes les cat&eacute;gories d''un champ donn&eacute; :</strong><br />\n<br />\n<span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />\nCette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant toutes les cat&eacute;gories et sous cat&eacute;gories d''un champ donn&eacute;. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.\n<ul>\n	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de la cat&eacute;gorie &agrave; selectionner dans la liste (facultatif)</li>\n	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>\n	<li><span class="keyword">editableonly </span>: Bool&eacute;en <span class="vertclair">true, false</span>, arffiche uniquement les cat&eacute;gories &eacute;ditables (facultatif, d&eacute;faut : false).</li>\n	<li><span class="keyword">root </span>: L''identifiant de la cat&eacute;gorie &agrave;&agrave; employer comme racine.</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (151, 'polymod', '2008-11-14 19:56:24', 'Adresse du lien (URL)', 'Link address (URL)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (152, 'polymod', '2008-11-14 19:56:24', 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (153, 'polymod', '2008-11-14 19:56:24', 'Cible du lien (_blank, _top, etc.)', 'Link target (_blank, _top, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (154, 'polymod', '2008-11-14 19:56:24', 'Type de lien (interne, externe, fichier, etc.)', 'Link type (internal, external, file, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (203, 'polymod', '2008-11-14 19:56:24', 'Date de début de publication formatée. Remplacez ''format'' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>', 'Formatted date. Replace ''format'' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">''date function''</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (202, 'polymod', '2008-11-14 19:56:24', 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (201, 'polymod', '2008-11-14 19:56:24', 'Champ contenant une image avec ou sans image zoom', 'Field with an image, with or without zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (200, 'polymod', '2008-11-14 19:56:24', 'Image', 'Image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (199, 'polymod', '2008-11-14 19:56:24', 'Uniquement les objets répondant à ces paramètres', 'Only objects with these parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (194, 'polymod', '2008-11-14 19:56:24', 'Edition d''un objet ''%s''', 'Edit ''%s'' object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (195, 'polymod', '2008-11-14 19:56:24', 'Objets ''%s'' associés', 'Associated ''%s'' objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (196, 'polymod', '2008-11-14 19:56:24', 'Associer un objet ''%s'' existant', 'Associate an existing object ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (197, 'polymod', '2008-11-14 19:56:24', 'Forcer le chargement des sous objets ?', 'Force subobjects loading?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (198, 'polymod', '2008-11-14 19:56:24', 'Attention, ce paramètre doit rester désactivé sauf si des données sont manquantes lors de certains chargements. Activer ce paramètre peut entraîner une perte de performance très importante.', 'Attention, this parameter must remain inactived except if data are missing during some loadings. Activate this parameter can involve a very significant loss of performance.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (193, 'polymod', '2008-11-14 19:56:24', 'Création d''un objet ''%s'' à associer', 'Create ''%s'' object to associate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (192, 'polymod', '2008-11-14 19:56:24', 'Ces objets peuvent être édités ?', 'These objects can be edited?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (190, 'polymod', '2008-11-14 19:56:24', 'Multiples objets ''%s''', 'Multiple objects ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (191, 'polymod', '2008-11-14 19:56:24', 'Objet composé de multiples objets ''%s''', 'Object composed with Multiple objects ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (188, 'polymod', '2008-11-14 19:56:24', 'Objet inconnu', 'Unknown object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (189, 'polymod', '2008-11-14 19:56:24', 'Cet objet n''est pas défini', 'This object is not defined');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (187, 'polymod', '2008-11-14 19:56:24', 'Nombre maximum de charactères :<br /><small>(255 maximum)</small>', 'Max count of caracters :<br /><small>(255 max)</small>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (185, 'polymod', '2008-11-14 19:56:24', 'Chaîne de caractères', 'Characters string');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (186, 'polymod', '2008-11-14 19:56:24', 'Chaîne contenant 255 caractères maximum sans HTML. Peut-être un email.', 'String containing 255 characters maximum without HTML. Can be an email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (183, 'polymod', '2008-11-14 19:56:24', 'HTML autorisé', 'HTML allowed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (184, 'polymod', '2008-11-14 19:56:24', 'Type de barre d''outil pour l''éditeur de texte (wysiwyg)', 'Toolbar type for the text editor (wysiwyg)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (181, 'polymod', '2008-11-14 19:56:24', 'Champ texte', 'Text field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (182, 'polymod', '2008-11-14 19:56:24', 'Champ de texte long, avec ou sans HTML', 'Long text field, with or without HTML');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (180, 'polymod', '2008-11-14 19:56:24', 'Peut-être négatif', 'Can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (173, 'polymod', '2008-11-14 19:56:24', 'Avec gestion des Heures - minutes - secondes', 'With management of Hours - minutes - seconds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (174, 'polymod', '2008-11-14 19:56:24', 'hh:mm:ss', 'hh:mm:ss');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (175, 'polymod', '2008-11-14 19:56:24', 'Lien', 'Link field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (176, 'polymod', '2008-11-14 19:56:24', 'Champ contenant un lien vers un site externe, une page ou un fichier.', 'Field containing a link to an external site, a page or a file.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (177, 'polymod', '2008-11-14 19:56:24', 'Nombre entier', 'Integer number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (178, 'polymod', '2008-11-14 19:56:24', 'Nombre entier de 11 chiffres maximum', 'Integer number containing 11 digits maximum');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (179, 'polymod', '2008-11-14 19:56:24', 'Peut-être nul', 'Can be null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (166, 'polymod', '2008-11-14 19:56:24', 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (167, 'polymod', '2008-11-14 19:56:24', 'Permet de catégoriser les objets et de gérer leurs droits d''accès', 'Allows you to categorize objects and to manage their access rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (168, 'polymod', '2008-11-14 19:56:24', 'Catégories multiples', 'Multiples categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (169, 'polymod', '2008-11-14 19:56:24', 'Catégorie de plus haut niveau', 'Top level category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (170, 'polymod', '2008-11-14 19:56:24', 'Date', 'Date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (171, 'polymod', '2008-11-14 19:56:24', 'Champ contenant une date au format de la langue courante', 'Field containing a date with the current language format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (172, 'polymod', '2008-11-14 19:56:24', 'Si le champ est vide, enregistrer la date du jour', 'If the field is empty, record the current date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (155, 'polymod', '2008-11-14 19:56:24', 'Code HTML complet du lien. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Complete HTML code of the link. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (156, 'polymod', '2008-11-14 19:56:24', 'Identifiant de la catégorie racine de ce champ', 'Root category ID for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (157, 'polymod', '2008-11-14 19:56:24', 'Nombre de catégories associées à ce champ', 'Number of categories associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (158, 'polymod', '2008-11-14 19:56:24', 'Catégories associées à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Categories associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (159, 'polymod', '2008-11-14 19:56:24', 'Identifiant d''une catégorie du champ (utilisable dans un tag atm-loop)', 'One category ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (160, 'polymod', '2008-11-14 19:56:24', 'Libellé d''une catégorie du champ (utilisable dans un tag atm-loop)', 'One category label of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (161, 'polymod', '2008-11-14 19:56:24', 'Identifiant de la catégorie du champ', 'Id of the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (162, 'polymod', '2008-11-14 19:56:24', '<strong>Liste de tous les objets d''un type donn&eacute; :</strong><br /><br /><span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />Cette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les objets du m&ecirc;me type que l''objet pass&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.<br /><ul><li><span class="keyword">selectedID : </span>Identifiant de l''objet &agrave; selectionner dans la liste</li></ul><br />', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (163, 'polymod', '2008-11-14 19:56:24', '<strong>Arborescence de cat&eacute;gories : </strong><br />\n<br />\n<span class="code">&lt;atm-function function=&quot;categoriesTree&quot; object=&quot;%s&quot; root=&quot;<span class="keyword">rootID</span>&quot; maxlevel=&quot;<span class="keyword">maxLevel</span>&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;item&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/item&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;itemselected&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/itemselected&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;template&gt;</span>&lt;ul&gt;<span class="vertclair">{sublevel}</span>&lt;/ul&gt;<span class="keyword">&lt;/template&gt;</span><br />\n&lt;/atm-function&gt;<strong><br />\n</strong></span>\n<p>Cette Fonction permet d''afficher une arborescence de cat&eacute;gories.</p>\n<ul> <strong>	</strong>\n	<li><span class="keyword">rootID </span>: L''identifiant de la cat&eacute;gorie devant servir de racine &agrave; l''arborescence.</li>\n	<li><span class="keyword">maxLevel </span>: Nombre de niveaux maximum &agrave; afficher pour l''arborescence (facultatif).</li>\n	<li><span class="keyword">selectedID </span>: Cat&eacute;gorie actuellement s&eacute;lectionn&eacute;e (facultatif).</li>\n	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>\n	<li>Le tag &lt;<span class="keyword">item</span>&gt; sera lu pour chaque cat&eacute;gorie &agrave; lister. La valeur <span style="font-weight: bold;"><span class="vertclair">{id}</span> </span>sera remplac&eacute;e par l''identifiant de la cat&eacute;gorie en cours, la valeur <span class="vertclair">{label}</span> par son libell&eacute;. La valeur <span class="vertclair">{lvl}</span> sera remplac&eacute;e par le num&eacute;ro du niveau en cours dans l''arborescence et la valeur <span class="vertclair">{sublevel}</span> par le niveau suivant dans l''arborescence.</li>\n	<li>Le tag &lt;<span class="keyword">template</span>&gt; sera lu au d&eacute;but de chaque niveau d''arborescence. La valeur <span class="vertclair">{sublevel}</span> sera remplac&eacute;e par le contenu du niveau d''arborescence en cours.</li>\n	<li>Le tag &lt;<span class="keyword">itemselected</span>&gt; sera lu pour la cat&eacute;gorie actuellement selectionn&eacute;e (facultatif).</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (164, 'polymod', '2008-11-14 19:56:24', '<strong>Hi&eacute;rarchie - Historique de cat&eacute;gories :</strong><br />\n<br />\n<span class="code"> &lt;atm-function function=&quot;categoryLineage&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot; root=&quot;<span class="keyword">rootCatID</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;ancestor&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/ancestor&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;self&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/self&gt;</span><br />\n&lt;/atm-function&gt;</span><strong><br />\n</strong>Cette fonction permet d''afficher la hi&eacute;rarchie parente (historique) d''une cat&eacute;gorie donn&eacute;e.\n<ul>\n    <li><strong><span class="keyword">categoryID </span>: </strong>L''identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>\n    <li><strong><span class="keyword">rootCatID </span>: </strong>L''identifiant de la cat&eacute;gorie à partir de laquelle on souhaite afficher la hi&eacute;rarchie (facultatif si "catégorie de plus haut niveau" sélectionnée, obligatoire dans le cas contraire).</li>\n    <li>Le tag <strong>&lt;<span class="keyword">ancestor</span>&gt;</strong> sera lu pour chaque anc&egrave;tre de la cat&eacute;gorie trouv&eacute;. La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>\n    <li>Le tag optionel <strong>&lt;<span class="keyword">self</span>&gt;</strong> sera lu pour la cat&eacute;gorie dont on affiche la hierarchie (si le tag n''existe pas, le tag &lt;<span class="keyword">ancestor</span>&gt; sera employ&eacute;). La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie&nbsp; dont on affiche la hierarchie, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>\n</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (111, 'polymod', '2008-11-14 19:56:24', 'Syntaxe des tags', 'Tags syntax');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (112, 'polymod', '2008-11-14 19:56:24', 'Variables et fonctions des objets', 'Objects variables and functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (113, 'polymod', '2008-11-14 19:56:24', 'Tags de travail', 'Working tags');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (114, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n	<h1>Tags de travail :</h1>\n	<div class="retrait">\n		<h3>Afficher le contenu du tag si la condition est remplie :</h3>\n			<div class="retrait">\n			<span class="code">\n				&lt;atm-if what=&quot;<span class="keyword">condition</span>&quot;&gt; ... &lt;/atm-if&gt;\n			</span>\n			<ul>\n				<li><span class="keyword">condition</span> : Condition &agrave; remplir pour afficher le contenu du tag. L''usage courant est de valider la pr&eacute;sence d''une valeur non nulle. Cette condition peut aussi prendre toutes les formes valides d''une condition PHP (voir : <a target="_blank" href="http://www.php.net/if" class="admin">Les structures de contr&ocirc;le en PHP</a>). La condition sera remplie si la valeur existe ou bien n''est pas nulle ou bien n''est pas &eacute;gale &agrave; faux (false).</li>\n			</ul>\n			</div>\n		<h3>Boucler sur un ensemble d''objets :</h3>\n			<div class="retrait">\n			<span class="code">&lt;atm-loop on=&quot;<span class="keyword">objets</span>&quot;&gt; ... &lt;/atm-loop&gt;</span>\n			<ul>\n				<li><span class="keyword">objets</span> : Collection d''objets. Employ&eacute; pour traiter tous les objets d''un ensemble d''objets multiple (dit multi-objet).</li>\n			</ul>\n			Les valeurs suivantes seront remplac&eacute;es dans le tag :\n			<ul>\n				<li><span class="vertclair">{firstloop}</span> : Vrai si l''objet en cours est le premier de la liste d''objets.</li>\n				<li><span class="vertclair">{lastloop}</span> : Vrai si l''objet en cours est le dernier de la liste d''objets.</li>\n				<li><span class="vertclair">{loopcount}</span> : Num&eacute;ro de l''objet en cours dans la liste d''objets.</li>\n				<li><span class="vertclair">{lastloop}</span> : Vrai si l''objet en cours est le dernier de la liste d''objets.</li>\n				<li><span class="vertclair">{maxloops}</span> : Nombre d''objets sur lesquels boucler.</li>\n			</ul>\n			</div>\n		<h3>Ajouter un attribut au tag XHTML p&egrave;re (contenant ce tag) :</h3>\n			<div class="retrait">\n			<span class="code">\n				&lt;atm-parameter attribute=&quot;<span class="keyword">attributeName</span>&quot; value=&quot;<span class="keyword">attributeValue</span>&quot; /&gt;\n			</span>\n			<ul>\n				<li><span class="keyword">attributeName</span> : Nom de l''attribut &agrave; ajouter.</li>\n				<li><span class="keyword">attributeValue</span> : Valeur de l''attribut &agrave; ajouter.</li>\n			</ul>\n			</div>\n		<h3>Assigner une valeur &agrave; une variable :</h3>\n			<div class="retrait">\n			<span class="code">&lt;atm-setvar vartype=&quot;<span class="keyword">type</span>&quot; varname=&quot;<span class="keyword">name</span>&quot; value=&quot;<span class="keyword">varValue</span>&quot; /&gt;\n			</span>\n			<ul>\n				<li><span class="keyword">type </span>: Type de la variable &agrave; assigner : <span class="vertclair">request</span>, <span class="vertclair">session</span> ou <span class="vertclair">var</span>.</li>\n				<li><span class="keyword">name </span>: Nom de la variable &agrave; assigner. Attention, r&eacute;assigner une variable existante supprimera l''ancienne valeur.</li>\n				<li><span class="keyword">varValue</span> : valeur &agrave; assigner &agrave; la variable.</li>\n			</ul>\n			</div>\n	</div>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (115, 'polymod', '2008-11-14 19:56:24', 'Bloc de données', 'Datas block');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (116, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n	<h1>Bloc de donn&eacute;es du module :</h1>\n	<div class="retrait">\n	<span class="code">\n		&lt;block module=&quot;%s&quot; id=&quot;<span class="keyword">blockID</span>&quot; language=&quot;<span class="keyword">languageCode</span>&quot;&gt; ... &lt;/block&gt;\n	</span>\n	<br/><br/>\n	Ce tag permet l''affichage de donn&eacute;es sp&eacute;cifiques &agrave; ce module. Il doit entourer tout ensemble de tags relatif &agrave; un traitement de donn&eacute;es du module.<br />\n	<ul>\n		<li><span class="keyword">blockID </span>: Identifiant unique du bloc de contenu dans la rang&eacute;e. Deux blocs de contenus d''une m&ecirc;me rang&eacute;e ne doivent pas avoir d''identifiants identiques.</li>\n		<li><span class="keyword">languageCode </span>: (facultatif) Code du langage relatif &agrave; ce bloc de contenu parmi les codes suivants : <span class="vertclair">%s</span>. <br/>Si non présent, la langue de la page sera utilisée. Si non présente, la langue par défaut d''Automne sera utilisée.</li>\n	</ul>\n	</div>\n</div>', 'TODO %s %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (117, 'polymod', '2008-11-14 19:56:24', 'Libellé de l''objet, correspond à sa valeur', 'Object label, same as object value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (118, 'polymod', '2008-11-14 19:56:24', 'Libellé du champ : ''%s''', 'Field label : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (119, 'polymod', '2008-11-14 19:56:24', 'Identifiant du champ : ''%s''', 'Field id : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (120, 'polymod', '2008-11-14 19:56:24', 'Valeur du champ', 'Field value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (121, 'polymod', '2008-11-14 19:56:24', 'Nom de l''objet', 'Object name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (122, 'polymod', '2008-11-14 19:56:24', 'Variables de l''objet', 'Object vars');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (123, 'polymod', '2008-11-14 19:56:24', 'Fonctions de l''objet', 'Object functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (124, 'polymod', '2008-11-14 19:56:24', 'Sélection des paramètres de recherche de la rangée ''%s'' du module ''%s''', 'Parameters selection for row ''%s'' of module ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (125, 'polymod', '2008-11-14 19:56:24', 'Pour la recherche ayant l''identifiant ''%s'' dans cette rangée', 'For search with ''%s'' ID in this row');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (126, 'polymod', '2008-11-14 19:56:24', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Elle porte sur un objet inexistant.]', '[Error : search with ''%s'' ID in ''%s'' row is not valid : It relates to a non-existent object.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (127, 'polymod', '2008-11-14 19:56:24', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Un de ses paramètre porte sur un champ inexistant.]', '[Error : search with ''%s'' ID in ''%s'' row is not valid : One of its parameter relates to a non-existent field.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (128, 'polymod', '2008-11-14 19:56:24', 'Nombre de résultats par pages', 'Number of results per pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (129, 'polymod', '2008-11-14 19:56:24', 'Croissant', 'Ascending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (130, 'polymod', '2008-11-14 19:56:24', 'Décroissant', 'Descending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (131, 'polymod', '2008-11-14 19:56:24', 'Ordre d''affichage', 'Display order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (132, 'polymod', '2008-11-14 19:56:24', 'Par création d''objets', 'By object creation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (133, 'polymod', '2008-11-14 19:56:24', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Le type de l''un de ses paramètres est inconnu : ''%s'']', '[Error : search with ''%s'' ID in ''%s'' row is not valid : The type of the one of its parameters is unknown : ''%s'']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (134, 'polymod', '2008-11-14 19:56:24', 'Publié à partir du', 'Published from');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (135, 'polymod', '2008-11-14 19:56:24', 'Publié jusqu''au', 'Published to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (136, 'polymod', '2008-11-14 19:56:24', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Le type de l''un de ses paramètres de tri est inconnu : ''%s'']', '[Error : search with ''%s'' ID in ''%s'' row is not valid : The type of the one of its sort parameters is unknown : ''%s'']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (137, 'polymod', '2008-11-14 19:56:24', 'Par date de début de publication', 'By publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (138, 'polymod', '2008-11-14 19:56:24', 'Par date de fin de publication', 'By publication date end');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (139, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n	<h1>Variables g&eacute;n&eacute;rales :</h1>\n	<div class="retrait">\n	<h3>Variables relatives aux pages :</h3>\n		<div class="retrait">\n			Les variables relatives aux pages sont de la forme <span class="vertclair">{page:<span class="keyword">id</span>:<span class="keyword">type</span>}</span>:\n			<ul>\n				<li><span class="keyword">id </span>: Identifiant de la page &agrave; laquelle faire r&eacute;f&eacute;rence, peut-&ecirc;tre un identifiant num&eacute;rique d''une page ou bien ''<span class="vertclair">self</span>'' pour faire r&eacute;f&eacute;rence &agrave; la page courante.</li>\n				<li><span class="keyword">type</span> : type de donn&eacute;e souhait&eacute; pour la page parmi les suivant : <span class="vertclair">url </span>(adresse de la page), <span class="vertclair">printurl </span>(adresse de la page d''impression), <span class="vertclair">id </span>(identifiant de la page), <span class="vertclair">title </span>(nom de la page).</li>\n			</ul>\n		</div>\n	<h3>Variables relatives aux donn&eacute;es envoy&eacute;es (via une adresse ou un formulaire) :</h3>\n		<div class="retrait">\n		Ces variables correspondent &agrave; une variable provenant de la soumission d''un formulaire ou bien d''un param&egrave;tre du lien ayant amen&eacute; &agrave; la page en cours. <br />\n		Elles sont de la forme <span class="vertclair">{request:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :\n		<ul>\n			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant : <br />\n			<ul>\n				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>\n				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>\n				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>\n				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>\n				<li><span class="vertclair">email </span>: email valide,</li>\n				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>\n				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>\n				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>\n			</ul>\n			</li>\n			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom du param&egrave;tre dans l''url ou bien nom du champ du formulaire).</li>\n		</ul>\n		</div>\n	<h3>Variables de session :</h3>\n		<div class="retrait">\n		Ces variables sont disponible tout au long de la navigation du visiteur sur le site. <br />\n		Elles sont de la forme <span class="vertclair">{session:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :\n		<ul>\n			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :\n			<ul>\n				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>\n				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>\n				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>\n				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>\n				<li><span class="vertclair">email </span>: email valide,</li>\n				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>\n				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>\n				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>\n			</ul>\n			</li>\n			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable de session).</li>\n		</ul>\n		</div>\n	<h3>Variables&nbsp;:</h3>\n		<div class="retrait">\n		Ces variables correspondent &agrave; des variables PHP classiques. <br />\n		Elles sont de la forme <span class="vertclair">{var:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :\n		<ul>\n			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :\n			<ul>\n				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>\n				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>\n				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>\n				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>\n				<li><span class="vertclair">email </span>: email valide</li>\n				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>\n				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>\n				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>\n			</ul>\n			</li>\n			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable PHP).</li>\n		</ul>\n		</div>\n	</div>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'pnews', '2008-11-14 19:56:24', 'Actualités', 'News');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'pdocs', '2008-11-14 19:56:24', 'Gestion documentaire', 'Documents management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'ppictures', '2008-10-31 14:53:30', 'Photothèque', 'Pictures');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (854, 'standard', '2008-11-14 19:56:23', 'Supprimer', 'Delete');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (855, 'standard', '2008-11-14 19:56:23', 'Insérer la rangée', 'Add Style-row');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (856, 'standard', '2008-11-14 19:56:23', 'Zone modifiable ''%s''', 'Content management zone ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (850, 'standard', '2008-11-14 19:56:23', 'Vers le haut', 'Move up');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (851, 'standard', '2008-11-14 19:56:23', 'Vers le bas', 'Move down');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (852, 'standard', '2008-11-14 19:56:23', 'Modification des zones modifiables du modèle %s', 'Modification of default content management zones for template %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (853, 'standard', '2008-11-14 19:56:23', 'Nom', 'Name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (848, 'standard', '2008-11-14 19:56:23', '[Erreur lors de la suppression d''une rangée]', '[Error while trying to delete style-row]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (849, 'standard', '2008-11-14 19:56:23', 'Les rangées utilisent du code XHTML associé à  des tags Automne spécifiques à  votre site %s. <br /> Attention, Automne n''utilisera pas le code non conforme à  l''XHTML.', 'Style-rows use XHTML in conjunction with Automne tags specific to your site %s.<br />Attention, Automne will not use non-conformed xHTML.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (845, 'standard', '2008-11-14 19:56:23', 'Gestion d''une rangée ', 'Style-Rows management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (846, 'standard', '2008-11-14 19:56:23', 'Définition XML', 'XML definition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (847, 'standard', '2008-11-14 19:56:23', '[Erreur lors de la suppression du modèle]', '[Error while trying to delete template]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (844, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression de la rangée ''%s''?', 'Do you confirm deletion of the style-row ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (841, 'standard', '2008-11-14 19:56:23', 'Gestion des modèles', 'Template management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (842, 'standard', '2008-11-14 19:56:23', 'Modèles', 'Templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (843, 'standard', '2008-11-14 19:56:23', 'Bibliothèque de rangées', 'Library of Style-rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (834, 'standard', '2008-11-14 19:56:23', 'Modifier la vignette', 'Edit image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (835, 'standard', '2008-11-14 19:56:23', 'Vignette', 'Current thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (836, 'standard', '2008-11-14 19:56:23', 'Aucune', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (837, 'standard', '2008-11-14 19:56:23', 'Groupes', 'Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (838, 'standard', '2008-11-14 19:56:23', 'Nouveaux groupes (séparés par des points-virgules)', 'New groups (separated by semi-colons)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (839, 'standard', '2008-11-14 19:56:23', '[Erreur lors de l''insertion d''un fichier]', '[Error while uploading file]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (840, 'standard', '2008-11-14 19:56:23', '[Le modèle XML importé est mal formé]', '[Error, the uploaded XML file contains conformity anomalies]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (829, 'standard', '2008-11-14 19:56:23', 'Rangées par défaut', 'Default style-rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (830, 'standard', '2008-11-14 19:56:23', 'Propriétés d''un modèle', 'Template properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (831, 'standard', '2008-11-14 19:56:23', 'Modèle XML', 'XML file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (832, 'standard', '2008-11-14 19:56:23', 'Modifier le fichier', 'Edit file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (833, 'standard', '2008-11-14 19:56:23', 'Vignette', 'Thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (826, 'standard', '2008-11-14 19:56:23', 'Voir les modèles des pages', 'View templates used for a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (827, 'standard', '2008-11-14 19:56:23', 'Arborescence : pages et modèles (entre parenthèses).', 'Site organisation with page template (in parenthesis)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (828, 'standard', '2008-11-14 19:56:23', 'Modèle par page', 'Template per page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (821, 'standard', '2008-11-14 19:56:23', 'Gestion des sites', 'Multi-site management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (822, 'standard', '2008-11-14 19:56:23', 'Sélection d''une racine', 'Website Start Page selection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (823, 'standard', '2008-11-14 19:56:23', 'Sélectionner une page racine pour le site modifié.', 'Please select a Start Page for the website you are declaring.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (824, 'standard', '2008-11-14 19:56:23', 'Site', 'Website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (825, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression du modèle ''%s''', 'Confirm deletion of template ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (819, 'standard', '2008-11-14 19:56:23', 'Domaine (URL)', 'Doamin (URL)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (820, 'standard', '2008-11-14 19:56:23', 'Changer', 'Change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (818, 'standard', '2008-11-14 19:56:23', '[Erreur lors du changement de racine]', '[Error while attempting to modify the Start Page]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (816, 'standard', '2008-11-14 19:56:23', 'Modification d''un site', 'Website edition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (817, 'standard', '2008-11-14 19:56:23', '[Opération impossible : la page sélectionnée comme racine est déjà  la racine d''un autre site.]', '[Action denied: the page you have selected as the Start Page is already chosen for another website]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (814, 'standard', '2008-11-14 19:56:23', 'Libellé', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (815, 'standard', '2008-11-14 19:56:23', 'Racine', 'Start Page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (813, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression du site ''%s'' ? ATTENTION ! Cette action n''est pas soumise à  validation et prendra effet immédiatement !', 'Confirm deletion of the website ''%s'' ? ATTENTION, this action will take effect immediatly!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (810, 'standard', '2008-11-14 19:56:23', '[Ce module n''a pas de paramètres]', '[This application does not have parameters to enter]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (811, 'standard', '2008-11-14 19:56:23', 'Aperçu', 'Preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (812, 'standard', '2008-11-14 19:56:23', 'Sites', 'Websites');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (809, 'standard', '2008-11-14 19:56:23', '[Module inconnu]', '[Unknown application]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (804, 'standard', '2008-11-14 19:56:23', 'Aucune', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (805, 'standard', '2008-11-14 19:56:23', 'Suppression d''actualité', 'News item deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (806, 'standard', '2008-11-14 19:56:23', 'Suppression de l''actualité : ', 'Deletion of news item: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (807, 'standard', '2008-11-14 19:56:23', 'Paramètres', 'Parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (808, 'standard', '2008-11-14 19:56:23', 'Paramètres du module %s', '%s parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (803, 'standard', '2008-11-14 19:56:23', 'Image', 'Current image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (800, 'standard', '2008-11-14 19:56:23', 'Suppression d''actualité', 'News item deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (801, 'standard', '2008-11-14 19:56:23', 'Suppression de l''actualité : ''%s''', 'Deletion of news article ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (802, 'standard', '2008-11-14 19:56:23', 'Pour un lien interne, saisir une ID page.<br /> Pour un lien externe, saisir une URL.', 'For internal links enter a page reference number.<br />\r\nFor external links enter an URL.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (589, 'standard', '2008-11-14 19:56:23', 'Modification de ou des rangées sélectionnés.', 'Modification of the or these selected rows.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (590, 'standard', '2008-11-14 19:56:23', 'Création d''une nouvelle rangée.', 'Create a new row.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (591, 'standard', '2008-11-14 19:56:23', 'Veuillez vous reconnecter pour voir les modifications.', 'Please reconnect to see the modifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (588, 'standard', '2008-11-14 19:56:23', 'Désactive la ou les rangées sélectionnés. Une rangée inactive ne peut plus être ajoutée dans des pages.', 'Desactivate the or these selected rows. An inactive row can not be added into pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (586, 'standard', '2008-11-14 19:56:23', 'Résultats : {0} Rangées sur {1}', 'Results : {0} Rows of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (587, 'standard', '2008-11-14 19:56:23', 'Active la ou les rangées sélectionnés. Une rangée active peut-être utilisé dans des pages.', 'Activate the or these selected rows. An active row can be used into pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (582, 'standard', '2008-11-14 19:56:23', 'Modification du ou des modèles sélectionnés.', 'Modification of the or these selected templates.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (583, 'standard', '2008-11-14 19:56:23', 'Création d''un nouveau modèle.', 'Create a new template.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (584, 'standard', '2008-11-14 19:56:23', '{0} Rangées sur {1}', '{0} Rows of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (585, 'standard', '2008-11-14 19:56:23', 'Supprime le ou les rangées sélectionnés. Une rangée ne doit plus être employée pour être supprimée.', 'Remove the or these selected templates. A template must not be used anymore to be removed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (581, 'standard', '2008-11-14 19:56:23', 'Désactive le ou les modèles sélectionnés. Un modèle inactif ne peut plus être utilisé pour créer des pages.', 'Desactivate the or these selected templates. An inactive template can not be used to create new pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (578, 'standard', '2008-11-14 19:56:23', 'Résultats : {0} Modèles sur {1}', 'Results : {0} Templates of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (579, 'standard', '2008-11-14 19:56:23', 'Résultats : Aucun résultat pour votre recherche ...', 'Results: No result for your search...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (580, 'standard', '2008-11-14 19:56:23', 'Active le ou les modèles sélectionnés. Un modèle actif peut-être utilisé pour créer des pages.', 'Activate the or these selected templates. An active template can be used to create new pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (577, 'standard', '2008-11-14 19:56:23', 'Supprime le ou les modèles sélectionnés. Un modèle ne doit plus être employé pour être supprimé.', 'Remove the or these selected templates. A template must not be used anymore to be removed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (573, 'standard', '2008-11-14 19:56:23', 'Envoi d''email', 'Email sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (574, 'standard', '2008-11-14 19:56:23', 'Création d''un utilisateur.', 'User creation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (575, 'standard', '2008-11-14 19:56:23', 'Résultats', 'Results');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (576, 'standard', '2008-11-14 19:56:23', '{0} Modèles sur {1}', '{0} Templates of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (572, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de gérer le contenu du module %s. Vous pouvez ajouter / supprimer / modifier les différents éléments gérés par ce module.', 'This window let you administrate the module %s. You can add / delete and modify elements managed by this module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (569, 'standard', '2008-11-14 19:56:23', 'Administrer le module %s', 'Administrate module %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (570, 'standard', '2008-11-14 19:56:23', 'Vous n''avez pas le droit d''accéder à l''administration du module %s.', 'You have no privileges to access module %s administration.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (571, 'standard', '2008-11-14 19:56:23', 'Administration du module %s', 'Administratio of module %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (566, 'standard', '2008-11-14 19:56:23', 'Paramètres avancés', 'Advanced parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (567, 'standard', '2008-11-14 19:56:23', 'Actions {0} à {1} sur {2}', 'Actions from {0} to {1} on {2}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (568, 'standard', '2008-11-14 19:56:23', 'Aucune action trouvée ...', 'No action founded...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (565, 'standard', '2008-11-14 19:56:23', 'Créer la page sans les rangées par défaut du modèle', 'Create page without any default rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (564, 'standard', '2008-11-14 19:56:23', 'Si vous cochez cette case, la page sera créée mais les zones de contenu seront vide de toutes rangées. Si vous ne la cochez pas, les rangées par défaut du modèle sélectionné seront automatiquement présente dans la page.', 'If you check this box, the page will be created without any default content rows. If you do not check it, the default template rows will be added to all content zone of the created pagge.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (562, 'standard', '2008-11-14 19:56:23', '... ou bien faire un lien vers une page, un site externe, un fichier.', '... or make a link to a page, an external site, a file.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (563, 'standard', '2008-11-14 19:56:23', 'Erreur durant la création de la page.', 'Error during page creation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (559, 'standard', '2008-11-14 19:56:23', 'Impossible de traiter les fichiers', 'Enable to process files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (560, 'standard', '2008-11-14 19:56:23', 'Impossible de traiter le fichier, veuillez vérifier l''installation de la librairie GD de PHP.', 'Enable to process files, please verify the installation of the PHP GD library.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (561, 'standard', '2008-11-14 19:56:23', 'Vous pouvez choisir de créer un lien vers une image grand format (Image Zoom) ...', 'You can choose to create a link to an image format (Image Zoom) ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (558, 'standard', '2008-11-14 19:56:23', 'Impossible de traiter les fichiers PNG, veuillez installer la librairie GD de PHP.', 'Enable to process PNG files, please install the PHP GD library.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (557, 'standard', '2008-11-14 19:56:23', 'Impossible de traiter les fichiers JPG, veuillez installer la librairie GD de PHP.', 'Enable to process JPG files, please install the PHP GD library.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (556, 'standard', '2008-11-14 19:56:23', 'Impossible de traiter les fichiers GIF, veuillez installer la librairie GD de PHP.', 'Enable to process GIF files, please install the PHP GD library.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (555, 'standard', '2008-11-14 19:56:23', 'Impossible de trouver le fichier image à traiter.', 'Unable to find the image file to be processed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (553, 'standard', '2008-11-14 19:56:23', 'Erreur durant l''effacement du bloc ... veuillez rééssayer.', 'Error during deleting the block ... please retry.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (554, 'standard', '2008-11-14 19:56:23', 'Erreur durant la mise à jour du contenu du bloc ... veuillez rééssayer.', 'Error during updating the block content ... please retry.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (552, 'standard', '2008-11-14 19:56:23', 'Erreur durant le déplacement de la rangée ... veuillez rééssayer.', 'Error during moving the row ... please retry.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (550, 'standard', '2008-11-14 19:56:23', 'Erreur durant l''ajout de la rangée ... veuillez rééssayer.', 'Error during adding the row ... please retry.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (551, 'standard', '2008-11-14 19:56:23', 'Erreur durant la suppression de la rangée ... veuillez rééssayer.', 'Error during deleting the row ... please retry.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (549, 'standard', '2008-11-14 19:56:23', 'Erreur de format', 'Format error');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (547, 'standard', '2008-11-14 19:56:23', 'Attributs', 'Attributes');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (548, 'standard', '2008-11-14 19:56:23', 'Name', 'Name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (546, 'standard', '2008-11-14 19:56:23', 'Vous pouvez spécifier ici les différents attributs du tag HTML \\''object\\'' qui sera employé pour l\\''animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\''valeur1\\'',\\nnom2:\\''valeur2\\'',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>class:\\''flash\\'',\\nalign:\\''top\\''</pre>', 'You can say the different attributes of the HTML tag \\''object\\'' to be used for Flash animation.<br />Attention to the following format :<pre>name1:\\''value1\\'',\\nname2:\\''value2\\'',\\n...</pre><br /><strong>Example :</strong><br /><pre>class:\\''flash\\'',\\nalign:\\''top\\''</pre>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (545, 'standard', '2008-11-14 19:56:23', 'Flashvars', 'Flashvars');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (544, 'standard', '2008-11-14 19:56:23', 'Vous pouvez spécifier ici les différentes variables à fournir (valeur de \\''flashvars\\'') à employer par l\\''animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\''valeur1\\'',\\nnom2:\\''valeur2\\'',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>titre:\\''Mon animation flash\\'',\\ndescription:\\''Hello World !\\''</pre>', 'You can specify the different variables here to provide (value \\''flashvars\\'') to be used by Flash animation.<br />Attention the following format :<pre>name1:\\''value1\\'',\\nname2:\\''value2\\'',\\n...</pre><br /><strong>Example :</strong><br /><pre>title:\\''My flash animation\\'',\\ndescription:\\''Hello World !\\''</pre>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (542, 'standard', '2008-11-14 19:56:23', 'Version', 'Version');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (543, 'standard', '2008-11-14 19:56:23', 'Vous pouvez spécifier ici les différents paramètres (tags \\''params\\'') à employer par l\\''animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\''valeur1\\'',\\nnom2:\\''valeur2\\'',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>wmode:\\''transparent\\'',\\nmenu:false,\\nscale:\\''showall\\''</pre>', 'You can specify different settings here (tags \\''params\\'') to be used by Flash animation.<br />Attention the following format :<pre>name1:\\''value1\\'',\\nname2:\\''value2\\'',\\n...</pre><br /><strong>Example :</strong><br /><pre>wmode:\\''transparent\\'',\\nmenu:false,\\nscale:\\''showall\\''</pre>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (541, 'standard', '2008-11-14 19:56:23', 'Version minimale du plugin Flash nécessaire pour cette animation.<br />Attention à respecter le format suivant :<pre>majeur.mineur.version</pre><br /><strong>Exemple :</strong> 9.0.24', 'Version of Flash needed for this animation.<br />Attention to comply with the following format: <pre>majeur.mineur.version</pre> <strong>Example :</strong> 9.0.24');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (540, 'standard', '2008-11-14 19:56:23', 'Sera employé comme attribut ''name'' de l''animation Flash pour l''identifier dans la page.', 'Will be used as an attribute ''name'' Flash animation to identify on the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (539, 'standard', '2008-11-14 19:56:23', 'Hauteur de l''animation Flash en pixels.', 'Flash animation height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (537, 'standard', '2008-11-14 19:56:23', 'Animation Flash', 'Flash animation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (538, 'standard', '2008-11-14 19:56:23', 'Largeur de l''animation Flash en pixels.', 'Flash animation width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (536, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de saisir ou modifier une animation Flash pour l''élément de la page en cours de modification.', 'This window allows you to enter or modify a Flash animation for the element of the page being edited.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (535, 'standard', '2008-11-14 19:56:23', 'Modification d''un élement ''Animation Flash''', 'Modifying a ''Flash animation'' element');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (534, 'standard', '2008-11-14 19:56:23', 'Sélectionnez un fichier', 'Select a file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (531, 'standard', '2008-11-14 19:56:23', 'Modification d''un élément ''Fichier''', 'Modifying a ''File'' element');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (532, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de saisir ou modifier un fichier pour l''élément de la page en cours de modification.', 'This window allows you to enter or modify a file and its page element being edited.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (533, 'standard', '2008-11-14 19:56:23', 'Libellé du fichier', 'File label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (530, 'standard', '2008-11-14 19:56:23', 'Tous les fichiers', 'All files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (528, 'standard', '2008-11-14 19:56:23', 'Sélectionnez une image', 'Select a picture');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (529, 'standard', '2008-11-14 19:56:23', 'Légende/Alt tag', 'Legend/Alt tag');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (524, 'standard', '2008-11-14 19:56:23', 'Copie de :', 'Copy of:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (525, 'standard', '2008-11-14 19:56:23', 'Afficher les blocs', 'Show blocks');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (526, 'standard', '2008-11-14 19:56:23', 'Modification d''un élément ''Image''', 'Modifying an ''Image'' element');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (527, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de saisir ou modifier une image ainsi que son lien pour l''élément de la page en cours de modification.', 'This window allows you to enter or modify a picture and its link to the page element being amended.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (522, 'standard', '2008-11-14 19:56:23', 'Réactiver l''utilisateur lui permet de se connecter à nouveau.', 'Reactivate the user permit him to connect again.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (523, 'standard', '2008-11-14 19:56:23', 'Désactiver l''utilisateur ne lui permet plus de se connecter.', 'Disabling the user prevent his connect.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (521, 'standard', '2008-11-14 19:56:23', 'Vous ne pouvez supprimer cet utilisateur car c''est un utilisateur système nécessaire au fonctionnement d''Automne.', 'You cannot delete this user because he is a system user required to operate Autumn.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (519, 'standard', '2008-11-14 19:56:23', 'Accès au contenu', 'Content access');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (520, 'standard', '2008-11-14 19:56:23', 'Utilisateur créé', 'User created');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (518, 'standard', '2008-11-14 19:56:23', 'Accès général au module', 'General module access');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (516, 'standard', '2008-11-14 19:56:23', 'Droits sur les modèles de rangées', 'Rights on rows templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (517, 'standard', '2008-11-14 19:56:23', 'Les droits sur les modèles de rangées permettent d''autoriser l''utilisation des rangées comportant ces groupes lors de l''édition du contenu des pages.', 'The rights on the rows templates can authorize the use of rows with these groups when editing content pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (513, 'standard', '2008-11-14 19:56:23', 'Aucun groupe n''existe sur les rangées actuellement...', 'No group exists on rows now...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (514, 'standard', '2008-11-14 19:56:23', 'Droits sur les modèles de pages', 'Rights on pages templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (515, 'standard', '2008-11-14 19:56:23', 'Les droits sur les modèles de pages permettent d''autoriser l''utilisation des modèles comportant ces groupes lors de la création des pages.', 'The rights on pages templates can authorize the use of templates with these groups when creating pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (511, 'standard', '2008-11-14 19:56:23', 'Droit de validation sur le module', 'Validation rights in the module');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (509, 'standard', '2008-11-14 19:56:23', 'Le groupe possède le droit "Administrateur" : Il possède tous les droits sur le module.', 'The group is the administrator: It has all the rights in the module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (510, 'standard', '2008-11-14 19:56:23', 'Cette case permet d''autoriser la validation des éléments du module pour lequels l''utilisateur à le droit d''administration.', 'This box allows you to authorize the validation elements of the module for which the user to the right of directors.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (512, 'standard', '2008-11-14 19:56:23', 'Aucun groupe n''existe sur les modèles actuellement...', 'No group exists on templates now...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (508, 'standard', '2008-11-14 19:56:23', 'Vous ne pouvez pas modifier les droits de cette page pour cet utilisateur car ils dépendent des groupes auquel il appartient. Modifiez les groupes de l''utilisateur pour modifier ses droits sur Automne.', 'You can not modify the rights of this page for the user because they depend on the groups to which it belongs. Change the groups the user to modify its rights in Autumn.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (502, 'standard', '2008-11-14 19:56:23', 'Déverrouiller la page', 'Unlock the page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (503, 'standard', '2008-11-14 19:56:23', 'Les deux champs de mot de passe doivent être identiques. Le mot de passe doit faire %s caractères minimum et être différent de l''identifiant.', 'The two fields password must be identical. The password must be at least %s characters and be different from the identifier.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (507, 'standard', '2008-11-14 19:56:23', 'L''utilisateur est Administrateur : Il possède tous les droits sur le module.', 'The user is the administrator: It has all the rights in the module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (506, 'standard', '2008-11-14 19:56:23', 'Vous pouvez gérer ici les différents droits d''administration d''Automne.', 'You can manage here the various administration rights of Autumn.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (505, 'standard', '2008-11-14 19:56:23', 'Vous ne pouvez pas modifier les droits de cette page pour cet utilisateur car ils dépendent des groupes auquel il appartient. Modifiez les groupes de l''utilisateur pour modifier ses droits sur Automne.', 'You can not modify the rights of this page for this user because they depend on the groups to which it belongs. Change the groups the user to modify its rights in Autumn.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (504, 'standard', '2008-11-14 19:56:23', 'L''utilisateur est l''administrateur : Il possède tous les droits sur Automne.', 'The user is the administrator: It has all the rights in Autumn.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (500, 'standard', '2008-11-14 19:56:23', 'Ajouter aux favoris', 'Add to your bookmarks');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (501, 'standard', '2008-11-14 19:56:23', 'Vous pouvez ajouter cette page aux favoris Automne pour pouvoir y accéder plus rapidement ! Pour la retrouver ensuite, allez dans la barre latérale puis dans "Gestion des pages".', 'You can add this page to Autumn bookmarks to get there faster! To find then, go to the sidebar then in "Management of pages".');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (499, 'standard', '2008-11-14 19:56:23', 'Copie de la page', 'Page copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (495, 'standard', '2008-11-14 19:56:23', 'Utilisateur ou groupe inconnu.', 'User or group unknown.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (496, 'standard', '2008-11-14 19:56:23', 'Données du groupe enregistrées', 'Data saved group.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (497, 'standard', '2008-11-14 19:56:23', 'Groupe créé', 'Group created');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (498, 'standard', '2008-11-14 19:56:23', 'niveaux', 'levels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (493, 'standard', '2008-11-14 19:56:23', 'Groupe supprimé.', 'Group deleted.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (494, 'standard', '2008-11-14 19:56:23', 'Groupe inconnu.', 'Group unknown.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (492, 'standard', '2008-11-14 19:56:23', 'Ce droit permet de donner accès à la gestion des utilisateurs d''Automne. Il permet de modifier les utilisateurs et groupes ainsi que leurs droits d''accès.', 'This right give the control on all users management in Automne. It allows the modification of all users and groups and their rights.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (489, 'standard', '2008-11-14 19:56:23', 'Ce droit permet de gérer toutes les rangées de contenu présentes dans Automne.', 'This right give control on all content rows in Automne.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (490, 'standard', '2008-11-14 19:56:23', 'Ce droit permet de gérer tous les modèles de pages d''Automne.', 'This right give control on all pages templates in Automne.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (491, 'standard', '2008-11-14 19:56:23', 'Ce droit permet de donner l''accès au journal de toutes les actions. Il permet aussi de purger ce journal des actions.', 'This right give the access to all actions logs in Automne. It allows logs deletion too.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (488, 'standard', '2008-11-14 19:56:23', 'Ce droit permet de régénérer les pages du sites manuellement et de controler les scripts en tâches de fond.', 'This right give control on pages regenerations and all scripts tasks in background.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (487, 'standard', '2008-11-14 19:56:23', 'Ce droit est le plus important dans Automne, il donne la possibilité de réaliser absolument toutes les actions sans aucune contrainte. Ce droit est à réserver uniquement aux administrateurs de plus haut niveau.', 'This right is the highter in Automne. It allows a full clearance on all actions. It should be reserved to hightest administrators only.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (484, 'standard', '2008-11-14 19:56:23', 'Alertes email', 'Notifications email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (485, 'standard', '2008-11-14 19:56:23', 'Les cases suivantes permettent de choisir pour chaque module quel type d''alertes vous ou l''utilisateur souhaitez recevoir par email.', 'The following boxes to choose for each module what kind of alerts or user you wish to receive by email.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (486, 'standard', '2008-11-14 19:56:23', 'Les deux champs de mot de passe doivent être identiques. Le mot de passe doit faire %s caractères minimum et être différent de l''identifiant.', 'The two password fields must be identical. The password must contain at least %s characters  and be different from the user name.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (483, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de consulter et modifier le profil d''un utilisateur. Ce profil comprend les informations personnelles de l''utilisateur ainsi que ses droits et les groupes auquel il appartient.', 'This window allows you to view and change the profile of a user. This profile includes personal information of the user and its rights and groups to which it belongs.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (480, 'standard', '2008-11-14 19:56:23', 'Groupes de l''utilisateur', 'User groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (481, 'standard', '2008-11-14 19:56:23', 'Confirmer', 'Confirm');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (482, 'standard', '2008-11-14 19:56:23', '* Nom distinctif (DN)', '* Distinguished name (DN)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (477, 'standard', '2008-11-14 19:56:23', 'Utilisateur %s désactivé', 'User %s disabled');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (478, 'standard', '2008-11-14 19:56:23', 'Erreur : Groupe inconnu...', 'Error: Unknown group ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (479, 'standard', '2008-11-14 19:56:23', 'Données utilisateur enregistrées.', 'User data registered.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (476, 'standard', '2008-11-14 19:56:23', 'Utilisateur %s activé', 'User %s activated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (473, 'standard', '2008-11-14 19:56:23', 'Erreur : utilisateur inexistant...', 'Error: no user ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (474, 'standard', '2008-11-14 19:56:23', 'Utilisateur %s supprimé', '%s user deleted');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (475, 'standard', '2008-11-14 19:56:23', 'Erreur : Utilisateur inconnu...', 'Error: Unknown user ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (471, 'standard', '2008-11-14 19:56:23', 'L''utilisateur ne peux voir que les éléments du module visibles coté client du site. L''accès coté administration d''Automne lui est impossible.', 'The user can only see frontend elements of the module. Backend access is not allowed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (472, 'standard', '2008-11-14 19:56:23', 'L''utilisateur peut voir le coté client et le coté administration d''Automne pour ce module.', 'The user can see frontend and backend elements for this module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (468, 'standard', '2008-11-14 19:56:23', 'Soumettre les modifications à la validation', 'Submit the modifications to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (469, 'standard', '2008-11-14 19:56:23', 'Modification des groupes de l''utilisateur', 'User''s groups modifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (470, 'standard', '2008-11-14 19:56:23', 'L''utilisateur ne peux pas voir les éléments du module.', 'The user can not see any elements of the module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (467, 'standard', '2008-11-14 19:56:23', 'Soumettre les modifications du contenu de la page à la validation. Une fois validée, la page présentera ce contenu en ligne.', 'Submit the current page content modifications to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (465, 'standard', '2008-11-14 19:56:23', 'Annuler la modification du contenu', 'Cancel content modifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (466, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir supprimer les modifications actuelles du contenu ?<br /><br />Le contenu de la page reviendra au précédent état validé ou en attente de validation de la page.<br />Cette action n''est pas soumise à la validation.', 'Are you sure you want to delete the current content modifications? <br /> <br /> The content of the page will return to the previous validated or validation pending state of the page. <br /> This action is not subject to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (464, 'standard', '2008-11-14 19:56:23', 'Supprimer le contenu actuel. Le contenu reviendra au précédent état validé ou en attente de validation. Cette action n''est pas soumise à validation et prend effet immédiatement.', 'Delete the current page content. The content will revert to the previous content validated or awaiting validation. This action is not subject to validation and takes effect immediately.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (462, 'standard', '2008-11-14 19:56:23', 'Annuler l''édition de la page', 'Undo editing page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (463, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir supprimer le contenu en attente de validation ?<br /><br />Le contenu de la page reviendra à l''état de la précédente validation.<br />Cette action n''est pas soumise à la validation.', 'Are you sure you want to delete the content awaiting validation? <br /> <br /> The content of the page will return to the status of the previous validation. <br /> This action is not subject to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (461, 'standard', '2008-11-14 19:56:23', 'Annuler l''édition de la page en attente de validation. Son contenu reviendra à l''état de la précédente validation. Cette action n''est pas soumise à validation et prend effet immédiatement.', 'Undo editing page awaiting validation. Its contents will return to the status of the previous validation. This action is not subject to validation and takes effect immediately.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (460, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir supprimer définitivement la page ?<br /><br />Cette action est soumise à la validation.', 'Are you sure you want to finally delete the page? <br /><br />This action is subject to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (458, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir archiver la page ?<br /><br />Cette action est soumise à la validation.', 'Are you sure you want to archiving the page ?<br /><br />This action is subject to validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (459, 'standard', '2008-11-14 19:56:23', 'Supprimer définitivement la page. Cette action est soumise à validation et peut-être annulé.', 'Delete the final page. This action is subject to validation and maybe cancelled.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (457, 'standard', '2008-11-14 19:56:23', 'Archiver la page en dehors de l''arborescence. La page ne sera plus consultable mais pourra être replacé dans l''arborescence plus tard. Cette action est soumise à validation et peut-être annulé.', 'Archive page outside of the tree. The page will no longer be available but may be placed in the tree later. This action is subject to validation and maybe cancelled.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (455, 'standard', '2008-11-14 19:56:23', 'Annuler l''archivage de la page', 'Undo page archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (456, 'standard', '2008-11-14 19:56:23', 'Déplacer la page et son contenu à un autre point de l''arborescence.', 'Move the page and its contents to another item on the tree.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (453, 'standard', '2008-11-14 19:56:23', 'Annuler la suppression de la page.', 'Undo the page deletion.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (454, 'standard', '2008-11-14 19:56:23', 'Annuler la demande d''archivage de la page.', 'Undo the page archiving request.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (452, 'standard', '2008-11-14 19:56:23', 'Annuler la demande de suppression de la page.', 'Undo the page deletion request.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (451, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir déverrouiller cette page ? Les modifications en cours par %s peuvent être perdues.', 'Are you sure you want to unlock this page? The changes underway by %s may be lost.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (447, 'standard', '2008-11-14 19:56:23', 'Paramètres Serveur', 'Server settings');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (448, 'standard', '2008-11-14 19:56:23', 'Paramètres Automne', 'Autumn settings');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (449, 'standard', '2008-11-14 19:56:23', 'Administration', 'Administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (450, 'standard', '2008-11-14 19:56:23', 'Copier la page et son contenu à un autre point de l''arborescence.', 'Copy the page and its contents to another item on the tree.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (445, 'standard', '2008-11-14 19:56:23', 'Gestion des scripts', 'Scripts management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (446, 'standard', '2008-11-14 19:56:23', 'Gestion des langues', 'Languages management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (444, 'standard', '2008-11-14 19:56:23', 'Barre d''outils Wysiwyg', 'Wysiwyg toolbar');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (443, 'standard', '2008-11-14 19:56:23', 'Styles Wysiwyg', 'Wysiwyg Styles');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (442, 'standard', '2008-11-14 19:56:23', 'Feuilles de styles', 'Stylesheets');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (441, 'standard', '2008-11-14 19:56:23', 'Modèles de rangées', 'Templates of rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (440, 'standard', '2008-11-14 19:56:23', 'Modèles de page', 'Page templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (439, 'standard', '2008-11-14 19:56:23', 'Voir les paramètres du module.', 'See the module parameters.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (438, 'standard', '2008-11-14 19:56:23', 'Duplication de branches', 'Duplication branches');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (437, 'standard', '2008-11-14 19:56:23', 'Pages Archivées', 'Archived Pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (436, 'standard', '2008-11-14 19:56:23', 'Vos Pages Favorites :', 'Your Bookmarked Pages:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (435, 'standard', '2008-11-14 19:56:23', 'Aucun élément en attente de validation sélectionné.', 'Nothing pending validation selected.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (434, 'standard', '2008-11-14 19:56:23', 'Validation', 'Validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (431, 'standard', '2008-11-14 19:56:23', 'Refuser la validation', 'Refuse validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (432, 'standard', '2008-11-14 19:56:23', 'Transférer la validation', 'Transfert validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (433, 'standard', '2008-11-14 19:56:23', 'à', 'to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (430, 'standard', '2008-11-14 19:56:23', 'Accepter la validation', 'Accept validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (429, 'standard', '2008-11-14 19:56:23', 'Erreur : fonction non prise en charge...', 'Error: function not care ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (428, 'standard', '2008-11-14 19:56:23', 'Cette action fermera la fenêtre des validations.<br />Etes-vous sur ?', 'This action will close the window of validations. <br /> Are you sure?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (426, 'standard', '2008-11-14 19:56:23', 'Fermer', 'Close');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (427, 'standard', '2008-11-14 19:56:23', 'éléments en attente de validation sélectionnés. Cliquez sur "Valider par lot" pour valider ces éléments.', 'elements awaiting validation selected. Click on "Submit a lot" to validate these elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (425, 'standard', '2008-11-14 19:56:23', 'Valider par lot', 'Submit a lot');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (424, 'standard', '2008-11-14 19:56:23', 'Aucune validation à afficher', 'No validation display');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (423, 'standard', '2008-11-14 19:56:23', 'Validations {0} à {1} sur {2}', 'Validations from {0} to {1} on {2}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (422, 'standard', '2008-11-14 19:56:23', 'Aucun élément en attente de validation.', 'Nothing awaiting validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (420, 'standard', '2008-11-14 19:56:23', 'Validation effectuée', 'Validation made');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (421, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de voir les différentes validations de contenu en attente sur les différents modules.', 'This window lets you see the various validations content waiting on the various modules.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (419, 'standard', '2008-11-14 19:56:23', 'Validations effectuées', 'Validations made');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (418, 'standard', '2008-11-14 19:56:23', 'Erreur durant la validation...', 'Error while validating ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (417, 'standard', '2008-11-14 19:56:23', 'Créer un nouvel utilisateur', 'Create a new user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (416, 'standard', '2008-11-14 19:56:23', 'Aucun groupe actuellement.', 'No group now.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (415, 'standard', '2008-11-14 19:56:23', 'Par groupe', 'By group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (414, 'standard', '2008-11-14 19:56:23', 'Par nom, prénom, identifiant', 'By name, firstname, reference');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (413, 'standard', '2008-11-14 19:56:23', 'Aucun utilisateur pour votre recherche...', 'No user for your search ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (412, 'standard', '2008-11-14 19:56:23', 'Utilisateurs {0} à {1} sur {2}', 'Users from {0} to {1} on {2}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (410, 'standard', '2008-11-14 19:56:23', 'Actif', 'Active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (411, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir supprimer définitivement l''utilisateur', 'Are you sure you want to permanently delete the user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (409, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de rechercher les profils d''utilisateurs et de groupes d''utilisateurs déclarés dans Automne pour pouvoir modifier leurs droits.', 'This window lets you search user profiles and user groups declared in Autumn to modify their rights.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (405, 'standard', '2008-11-14 19:56:23', 'Par libellé', 'By label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (406, 'standard', '2008-11-14 19:56:23', 'Par lettre :', 'By letter :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (407, 'standard', '2008-11-14 19:56:23', 'Créer un nouveau groupe', 'Create a new group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (408, 'standard', '2008-11-14 19:56:23', 'Profils d''Utilisateurs et de Groupes', 'Profiles of Users and Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (404, 'standard', '2008-11-14 19:56:23', 'Aucun groupe pour votre recherche...', 'No group for your search ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (403, 'standard', '2008-11-14 19:56:23', 'Groupes {0} à {1} sur {2}', 'Groups from {0} to {1} on {2}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (402, 'standard', '2008-11-14 19:56:23', 'Etes-vous sur de vouloir supprimer définitivement le groupe : ', 'Are you sure you want to permanently delete the group: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (401, 'standard', '2008-11-14 19:56:23', 'Groupes d''utilisateurs', 'User Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (398, 'standard', '2008-11-14 19:56:23', 'Méta données', 'Meta data');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (399, 'standard', '2008-11-14 19:56:23', 'Alias', 'Alias');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (400, 'standard', '2008-11-14 19:56:23', '# utilisateurs', '# users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (396, 'standard', '2008-11-14 19:56:23', 'Vous pouvez changer leur ordre par glisser-déposer.', 'You can change their order by dragging and dropping.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (397, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de voir et de modifier (si vous en avez le droit) les propriétés de la page en cours.', 'This window allows you to view and modify (if you have the right) the properties of the current page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (394, 'standard', '2008-11-14 19:56:23', 'Sous pages', 'Sub pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (395, 'standard', '2008-11-14 19:56:23', 'Liste des sous pages de la page', 'List of sub pages of the page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (393, 'standard', '2008-11-14 19:56:23', 'Méta données libres (format HTML)', 'Free meta data (HTML format)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (392, 'standard', '2008-11-14 19:56:23', 'Si vous êtes administrateur, vous pouvez saisir ici toute les méta-données supplémentaires que vous souhaitez ajouter à la page.', 'If you are an administrator, you can enter here any meta data which you want to add to the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (391, 'standard', '2008-11-14 19:56:23', 'Ce champ vous permet de d''activer ou de désactiver le cache du navigateur de l''internaute pour cette page.', 'This field allows you to enable or disable the browser cache for this page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (390, 'standard', '2008-11-14 19:56:23', 'Choisissez la langue de cette page. Ce champ est utile pour permettre un référencement optimal.', 'Choose the language of this page. This field is useful to allow for optimal referencing.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (389, 'standard', '2008-11-14 19:56:23', 'Vous permet de spécifier le copyright du contenu de cette page. Ce champ est visible par les moteurs de recherche.', 'You can specify the copyright content of this page. This field is visible by search engines.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (388, 'standard', '2008-11-14 19:56:23', 'Vous permet de spécifier une adresse email de contact. Ce champ est visible par les moteurs de recherche.', 'You can specify a contact email address. This field is visible by search engines.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (387, 'standard', '2008-11-14 19:56:23', 'Vous permet de spécifier l''auteur du contenu pour cette page. Ce champ est visible par les moteurs de recherche.', 'You can specify the content author of this page. This field is visible by search engines.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (386, 'standard', '2008-11-14 19:56:23', 'Valeur par défaut du navigateur', 'Default browser value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (376, 'standard', '2008-11-14 19:56:23', 'Date à partir de laquelle la page sera visible en ligne.', 'Date from which the page will be visible online.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (385, 'standard', '2008-11-14 19:56:23', 'Cette zone permet de spécifier si les robots utilisés par les moteurs de recherche doivent lire ou non cette page.', 'This area allows you to specify if the robots used by search engines should or not, read this page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (384, 'standard', '2008-11-14 19:56:23', 'Catégories de la page à destination des moteurs de recherche.', 'Categories of the page to search engines.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (383, 'standard', '2008-11-14 19:56:23', 'Mots clés de la page à destination des moteurs de recherche.', 'Keywords of the page to search engines.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (382, 'standard', '2008-11-14 19:56:23', 'Description de la page à destination des moteurs de recherche.', 'Page description to search engines');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (381, 'standard', '2008-11-14 19:56:23', 'Titre de cette page', 'Page title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (377, 'standard', '2008-11-14 19:56:23', 'Date à partir de laquelle la page ne sera plus visible en ligne.', 'Date from which the page is no longer visible online.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (378, 'standard', '2008-11-14 19:56:23', 'Délai pour recevoir le message d''alerte ci-dessous.', 'Deadline for receiving the alert message below.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (379, 'standard', '2008-11-14 19:56:23', 'Date à laquelle recevoir le message d''alerte ci-dessous.', 'Date when receiving the alert message below.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (380, 'standard', '2008-11-14 19:56:23', 'Message d''alerte à recevoir par email. Attention, votre compte utilisateur doit avoir une adresse email valide.', 'Alert to be received by email. Be careful, your user account must have a valid email address.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (375, 'standard', '2008-11-14 19:56:23', 'Est ce que cette page redirige automatiquement le visiteur vers un autre endroit.', 'Does this page automatically forwards the visitor to another place.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (374, 'standard', '2008-11-14 19:56:23', 'Est ce que cette page possède une version imprimable spécifique.', 'Does this page gets a printable specific version.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (373, 'standard', '2008-11-14 19:56:23', 'Quelles sont les relations des autres pages avec cette page.', 'What are the relations of other pages with this page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (372, 'standard', '2008-11-14 19:56:23', 'Site auquel appartient la page', 'Site which belongs page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (371, 'standard', '2008-11-14 19:56:23', 'Modèle employé par la page. Permet de structurer son visuel', 'Template used by the page. Used to structure its visual');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (370, 'standard', '2008-11-14 19:56:23', 'Identifiant unique de cette page. Permet de la retrouver aisément', 'Unique identifier of this page. Allows to find it easily');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (369, 'standard', '2008-11-14 19:56:23', 'Libellé des liens pointant vers cette page', 'Links label pointing to this page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (368, 'standard', '2008-11-14 19:56:23', 'Mise à jour lors de la prochaine validation de la page', 'Updated at the next validation of the page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (366, 'standard', '2008-11-14 19:56:23', 'Erreur durant la copie de la page...', 'Error during the copy of the page ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (367, 'standard', '2008-11-14 19:56:23', 'Page non publiée', 'Page unpublished');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (364, 'standard', '2008-11-14 19:56:23', 'Erreur, données manquantes, veuillez rééssayer.', 'Error, missing data, please try again.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (365, 'standard', '2008-11-14 19:56:23', 'Vous n''avez pas le droit de voir la page que vous cherchez à copier', 'You do not have the right to see the page you want to copy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (362, 'standard', '2008-11-14 19:56:23', 'Message', 'Message');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (363, 'standard', '2008-11-14 19:56:23', 'Complément', 'Supplement');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (361, 'standard', '2008-11-14 19:56:23', '<br />Confirmez vous que ces informations sont correctes ?', '<br />Confirm you that this information is correct?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (360, 'standard', '2008-11-14 19:56:23', 'Vous avez choisi de changer le modèle de la page d''origine.<br />', 'You choose to change the original page template.<br />');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (359, 'standard', '2008-11-14 19:56:23', 'Vous avez choisi de conserver le modèle de la page d''origine.<br />', 'You choose to keep the original page template.<br />');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (357, 'standard', '2008-11-14 19:56:23', 'Vous avez choisi de conserver le contenu de la page d''origine.<br />', 'You choose to keep the original page content.<br />');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (358, 'standard', '2008-11-14 19:56:23', 'Vous avez choisi de ne pas conserver le contenu de la page d''origine.<br />', 'You choose not to keep the original page content.<br />');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (355, 'standard', '2008-11-14 19:56:23', 'Sélectionnez la page à utiliser comme père de la page copiée :', 'Select the page to use as father of the copied page:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (356, 'standard', '2008-11-14 19:56:23', 'Vous allez copier la page %s (%s) sous la page', 'You are going to copy the page %s (%s) under the page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (353, 'standard', '2008-11-14 19:56:23', 'Modèle compatible', 'Matching template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (354, 'standard', '2008-11-14 19:56:23', 'Modèle incompatible', 'Unmatching template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (352, 'standard', '2008-11-14 19:56:23', 'Remplacer le modèle de la page par', 'Replace page template by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (351, 'standard', '2008-11-14 19:56:23', 'Copier le contenu de la page', 'Copy page content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (350, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de créer copier la page et son contenu à un autre point de l''arborescence des pages du site. Vous pouvez aussi changer le modèle utilisé et choisir de ne pas copier le contenu mais uniquement sa structure.', 'This window allows you to create the page and copy its contents to another item on the site''s tree pages. You can also change the template used and choose not to copy the content but only its structure.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (349, 'standard', '2008-11-14 19:56:23', 'Vous n''avez pas renseigné toutes les informations requises', 'You have not filled all the required informations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (348, 'standard', '2008-11-14 19:56:23', 'Choisissez le modèle à utiliser pour la nouvelle page :', 'Choose new page template:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (347, 'standard', '2008-11-14 19:56:23', 'Titre du lien', 'Link title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (346, 'standard', '2008-11-14 19:56:23', 'Titre de la page', 'Page title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (345, 'standard', '2008-11-14 19:56:23', 'Vous n''avez aucun modèle disponible ...', 'You don''t have any available template...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (344, 'standard', '2008-11-14 19:56:23', 'Nom', 'Name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (341, 'standard', '2008-11-14 19:56:23', 'Déverrouiller la page verrouillée par %s', 'Unlock page locked by %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (342, 'standard', '2008-11-14 19:56:23', 'Création d''une nouvelle page', 'Creating a new page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (343, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de créer une nouvelle page sous la page en actuelle. Donnez un nom à cette nouvelle page ainsi que le nom des liens qui pointeront vers cette page. Puis choisissez le modèle à utiliser.', 'This window allows you to create a new page under the actual one. Give a name to this new page and links name which will link to this page. Then choose a template.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (338, 'standard', '2008-11-14 19:56:23', 'validation(s) en attente', 'validation(s) pending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (339, 'standard', '2008-11-14 19:56:23', 'Editeurs', 'Editors');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (340, 'standard', '2008-11-14 19:56:23', 'Rafraichir le contenu de cette zone.', 'Refresh zone content.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (337, 'standard', '2008-11-14 19:56:23', 'Recevez un email lorsqu''une alerte est spécifié au niveau d''une page que vous pouvez modifier.', 'Receive an email when an alert is set on a page you can change.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (336, 'standard', '2008-11-14 19:56:23', 'Recevez un email lorsque votre profil utilisateur est modifié.', 'Receive an email when your user profile is modified.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (335, 'standard', '2008-11-14 19:56:23', 'Recevez un email pour toute validation de page en attente dans vos sections.', 'Receive an email for any pages validation pending in your sections.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (334, 'standard', '2008-11-14 19:56:23', 'Erreur : La page est actuellement vérouillée par l''utilisateur %s et ne peut être mise à jour.', 'Error : The page is currenlty locked by user %s and cannot be updated.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (332, 'standard', '2008-11-14 19:56:23', 'Erreur : La date de début ne peut-être supérieure à la date de fin de publication.', 'Error : The starting date can not be higher than the end of publication date.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (333, 'standard', '2008-11-14 19:56:23', 'Erreur : Un problème est survenu lors du traitement ... Vérifez votre contenu.', 'Error : A problem occured during treatment... Please check your content.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (330, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Edit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (331, 'standard', '2008-11-14 19:56:23', 'Cliquez pour modifier ce champ', 'Click to edit this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (329, 'standard', '2008-11-14 19:56:23', 'Vous permet de réaliser diverses actions sur la page en cours : supprimer, déplacer, copier, etc.', 'Lets you perform various actions on the current page: delete, move, copy, and so on.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (328, 'standard', '2008-11-14 19:56:23', 'Actions sur la page.', 'Page actions.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (327, 'standard', '2008-11-14 19:56:23', 'Vous permet d''ajouter une nouvelle page sous la page en cours.', 'Lets you add a new page below the current one.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (325, 'standard', '2008-11-14 19:56:23', 'Cette fenêtre vous permet de naviger parmis l''arborescence des pages de votre site. Cliquez sur le nom d''une page pour sélectionner cette page. Cliquez sur les signes "+" et "-" à gauche des pages pour plier ou déplier l''arborescence.', 'This window allows you to navigate among the tree of pages of your website. Click on the name of a page to select this page. Click on the "+" and "-" signs left of the pages for folding or unfolding the tree.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (326, 'standard', '2008-11-14 19:56:23', 'Vous permet de rechercher les éléments de votre site par leur nom.', 'Lets you search any elements of your website by name.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (318, 'standard', '2008-11-14 19:56:23', 'Pages visibles', 'Visible pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (324, 'standard', '2008-11-14 19:56:23', 'Ce champ vous permet de rechercher une page en saisissant directement son identifiant numérique ou en saisissant un texte appartenant à son titre (minimum : 3 caractères). Choisissez ensuite la page que vous souhaitez dans la liste déroulante au fur et à mesure que vous saisissez vos termes de recherche.', 'This field allows you to search for a page directly by entering its ID number or by typing a text belonging to its title (with a minimum of 3 characters). Then select the page you want from the drop down list as you enter your search terms.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (323, 'standard', '2008-11-14 19:56:23', 'Ce menu vous permet de filtrer l''affichage des pages selon vos droits. "Pages visibles" affichera toutes les pages visibles et modifiables. "Pages modifiable" n''affichera que les pages modifiables.', 'This menu allows you to filter the display of pages according to your rights. "Visible pages" display all the pages visible and editable. "Editable pages" display only editable pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (321, 'standard', '2008-11-14 19:56:23', 'Verrouillé par :', 'Locked by:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (322, 'standard', '2008-11-14 19:56:23', 'Filtrer', 'Filter');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (319, 'standard', '2008-11-14 19:56:23', 'Pages modifiables', 'Editable pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (320, 'standard', '2008-11-14 19:56:23', 'Cette page comporte une redirection vers : %s. Elle ne présente donc pas de contenu visible.', 'This page include a redirect to: %s. It may not show any visible content.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (317, 'standard', '2008-11-14 19:56:23', 'L''onglet est inaccessible car actuellement, la page n''existe pas coté public du site.', 'The tab is disabled because currently, the page does not exists in the public website.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (316, 'standard', '2008-11-14 19:56:23', 'Vous permet de consulter et modifier les propriétés de la page tel que le titre le modèle et autre méta-données.', 'Lets you see and modify the page properties such as title, template and others meta datas.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (315, 'standard', '2008-11-14 19:56:23', 'Vous avez %s validations en attente.', 'You have %s validations pending.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (314, 'standard', '2008-11-14 19:56:23', 'Bienvenue %s !', 'Welcome %s!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (313, 'standard', '2008-11-14 19:56:23', 'Validé par %s le %s.', 'Validated by %s on %s.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (312, 'standard', '2008-11-14 19:56:23', 'Modifié par %s le %s.', 'Modified by %s on %s.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (311, 'standard', '2008-11-14 19:56:23', 'Derniers changements', 'Last changes');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (310, 'standard', '2008-11-14 19:56:23', 'L''onglet est inaccessible car cette page ne peut être modifié directement.', 'The tab is disabled because the content of this page cannot be directly changed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (309, 'standard', '2008-11-14 19:56:23', 'Vous permet de modifier le contenu de cette page ou de continuer les modifications en cours.', 'Lets you change the content of this page or continue the modifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (308, 'standard', '2008-11-14 19:56:23', 'L''onglet est inaccessible car actuellement, aucun contenu n''est en cours de modification pour le page.', 'The tab is disabled because currently, there is no content modification for the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (307, 'standard', '2008-11-14 19:56:23', 'Vous permet de voir l''état du contenu en cours de modification pour la page.', 'Lets you see the state of the content modification for the page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (306, 'standard', '2008-11-14 19:56:23', 'L''onglet est inaccessible car actuellement, la page est publiée et aucun contenu n''est en attente de validation.', 'The tab is disabled because currently, the page is published and has no content pending validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (305, 'standard', '2008-11-14 19:56:23', 'Vous permet de voir l''état du contenu de cette page avant sa publication.', 'Lets you see the state of the page content before publication.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (304, 'standard', '2008-11-14 19:56:23', 'Vous permet de consultez et naviguer dans l''arborescences des pages du site.', 'Lets you see and navigate the tree of website pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (303, 'standard', '2008-11-14 19:56:23', 'Veuillez compléter les champs requis !', 'Please complete required fields!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (301, 'standard', '2008-11-14 19:56:23', 'Erreur ...', 'Error ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (302, 'standard', '2008-11-14 19:56:23', 'Authentification ...', 'Authentification ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (298, 'standard', '2008-11-14 19:56:23', 'Nom d''identifiant (ID)', 'Name (ID)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (300, 'standard', '2008-11-14 19:56:23', 'Paramètre BGCOLOR', 'Param BGCOLOR');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (297, 'standard', '2008-11-14 19:56:23', 'Paramètre QUALITY', 'Param QUALITY');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (295, 'standard', '2008-11-14 19:56:23', 'Paramètre MENU', 'Param MENU');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (296, 'standard', '2008-11-14 19:56:23', 'Paramètre SCALE', 'Param SCALE');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (292, 'standard', '2008-11-14 19:56:23', 'Paramètre WMODE', 'Param WMODE');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (293, 'standard', '2008-11-14 19:56:23', 'Paramètre SWLIVECONNECT', 'Param SWLIVECONNECT');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (294, 'standard', '2008-11-14 19:56:23', 'Texte long', 'Long text');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (290, 'standard', '2008-11-14 19:56:23', 'Largeur', 'Width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (291, 'standard', '2008-11-14 19:56:23', 'Hauteur', 'Height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (288, 'standard', '2008-11-14 19:56:23', 'Gestion du texte', 'Text editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (289, 'standard', '2008-11-14 19:56:23', 'Vous devez activer Javascript pour voir cette animation.', 'You must activate Javascript to see this animation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (287, 'standard', '2008-11-14 19:56:23', 'Editeur visuel Java (WYSIWYG)', 'Java Visual editor (WYSIWYG)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (286, 'standard', '2008-11-14 19:56:23', 'Editeur texte enrichi', 'Richtext editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (285, 'standard', '2008-11-14 19:56:23', 'Editeur texte', 'Text editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (284, 'standard', '2008-11-14 19:56:23', 'Confirmer l''annulation ?', 'Confirm cancellation of modifications?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (283, 'standard', '2008-11-14 19:56:23', 'Appliquer a tous les utilisateurs', 'Apply to all users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (282, 'standard', '2008-11-14 19:56:23', 'Pages', 'Pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (281, 'standard', '2008-11-14 19:56:23', 'Changement du contenu de l''actualité : ''%s''', 'News article content change for article : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (280, 'standard', '2008-11-14 19:56:23', 'Changement du contenu d''une actualité', 'News content change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (279, 'standard', '2008-11-14 19:56:23', 'Droits de validation', 'Validation rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (276, 'standard', '2008-11-14 19:56:23', 'Interne vers la page n°', 'Internal to page (ID)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (278, 'standard', '2008-11-14 19:56:23', 'La ressource est verrouillée. Elle est en cours d''utilisation par un tiers.', 'The page or item is currently being modified by another user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (277, 'standard', '2008-11-14 19:56:23', 'Externe ', 'External : ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (275, 'standard', '2008-11-14 19:56:23', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (274, 'standard', '2008-11-14 19:56:23', 'Lien', 'Link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (273, 'standard', '2008-11-14 19:56:23', 'Texte', 'Text');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (271, 'standard', '2008-11-14 19:56:23', 'Image', 'Image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (272, 'standard', '2008-11-14 19:56:23', 'Mettre à  jour<br />(Pour supprimer l''image, cocher la case et laisser le champ "parcourir" vide).', 'Update<br />\r\n(to delete file check box and leave above field empty.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (270, 'standard', '2008-11-14 19:56:23', 'Date de publication sur accueil, fin', 'Homepage publication date, end');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (269, 'standard', '2008-11-14 19:56:23', 'Date de publication sur accueil, début', 'Homepage publication date, start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (268, 'standard', '2008-11-14 19:56:23', 'Droit d''administration', 'Backend rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (261, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Edit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (262, 'standard', '2008-11-14 19:56:23', 'Nouveau', 'New');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (264, 'standard', '2008-11-14 19:56:23', 'Applications', 'Applications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (265, 'standard', '2008-11-14 19:56:23', 'Aucun enregistrement.', 'Empty set.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (266, 'standard', '2008-11-14 19:56:23', 'Aucun droit', 'No rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (267, 'standard', '2008-11-14 19:56:23', 'Droit de consultation coté client', 'Frontend rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (257, 'standard', '2008-11-14 19:56:23', 'Titre', 'Title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (258, 'standard', '2008-11-14 19:56:23', 'Publication', 'Publication');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (260, 'standard', '2008-11-14 19:56:23', 'Ajouter', 'Add');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (259, 'standard', '2008-11-14 19:56:23', 'Actions', 'Actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (40, 'cms_forms', '2008-11-14 19:56:24', 'Si la saisie du formulaire n''est pas correcte', 'If form datas are not correct ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (39, 'cms_forms', '2008-11-14 19:56:24', 'Valeurs insérées en base de données', 'Values inserted in data base ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (38, 'cms_forms', '2008-11-14 19:56:24', 'Type d''action', 'Action type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (37, 'cms_forms', '2008-11-14 19:56:24', 'Aucun élément n''est sélectionné', 'Nothing is selected');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (36, 'cms_forms', '2008-11-14 19:56:24', 'Actions du formulaire', 'Form actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (34, 'cms_forms', '2008-11-14 19:56:24', 'Une erreur est survenue lors de l''ajout de la catégorie %s', 'Add of category %s failed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (35, 'cms_forms', '2008-11-14 19:56:24', 'Vous devez sélectionner une catégorie au minimum	', 'Choose at least one category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (27, 'cms_forms', '2008-11-14 19:56:24', 'Nom du formulaire', 'Form name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (28, 'cms_forms', '2008-11-14 19:56:24', 'Source XHTML', 'XHTML source');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (29, 'cms_forms', '2008-11-14 19:56:24', 'Actif', 'Activated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (30, 'cms_forms', '2008-11-14 19:56:24', 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (31, 'cms_forms', '2008-11-14 19:56:24', 'Une erreur est survenue lors de la suppression du formulaire', 'An error occured while attempting to delete form');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (32, 'cms_forms', '2008-11-14 19:56:24', 'Veuillez vérifier la syntaxe XHTML de votre formulaire', 'Please verify formular XHTML syntax');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (33, 'cms_forms', '2008-11-14 19:56:24', 'Une erreur est survenue lors de l''ajout des catégories', 'Add of categories failed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (22, 'cms_forms', '2008-11-14 19:56:24', 'Gestion des accès par groupes d''utilisateurs :', 'User access by groups :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (23, 'cms_forms', '2008-11-14 19:56:24', 'Gestion des formulaires :', 'Forms management :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (24, 'cms_forms', '2008-11-14 19:56:24', 'Lister', 'List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (25, 'cms_forms', '2008-11-14 19:56:24', 'Accueil', 'Entry');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (26, 'cms_forms', '2008-11-14 19:56:24', 'Libellé', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (140, 'polymod', '2008-11-14 19:56:24', 'Variables générales', 'General variables');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (141, 'polymod', '2008-11-14 19:56:24', 'Identifiant unique de l''objet', 'Unique ID for object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (142, 'polymod', '2008-11-14 19:56:24', 'Libellé de l''objet', 'Object label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (143, 'polymod', '2008-11-14 19:56:24', 'Nom de l''objet : ''%s''', 'Object name : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (144, 'polymod', '2008-11-14 19:56:24', 'Description de l''objet : ''%s''', 'Object description : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (145, 'polymod', '2008-11-14 19:56:24', 'Identifiant de type de l''objet : ''%s''', 'Object type ID : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (146, 'polymod', '2008-11-14 19:56:24', 'Identifiant du champ auquel l''objet appartient (si il existe)', 'Identifier of the field to which the object belongs (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (147, 'polymod', '2008-11-14 19:56:24', 'Identifiant de ressource de l''objet', 'Object resource ID');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (148, 'polymod', '2008-11-14 19:56:24', 'Ensemble des objets de type ''%s'' associés à ce  champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Objects of type ''%s'' associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (149, 'polymod', '2008-11-14 19:56:24', 'Nombre d''objets de type ''%s'' associés à ce champ', 'Count of objects of the type ''%s'' associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (150, 'polymod', '2008-11-14 19:56:24', 'Date format&eacute;e. Remplacez ''format'' par la valeur correspondant au format accept&eacute; en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur ''<strong>rss</strong>'' pour sp&eacute;cifier le format.', 'Formatted date. Replace ''format'' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">''date function''</a>. For a date used in an RSS feed, use ''<strong>rss</strong>'' to specify the format.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1381, 'standard', '2008-11-14 19:56:24', 'Augmenter le retrait', 'Indent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1382, 'standard', '2008-11-14 19:56:24', 'Aligner à gauche', 'Justify Left');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1383, 'standard', '2008-11-14 19:56:24', 'Centrer', 'Center');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1384, 'standard', '2008-11-14 19:56:24', 'Aligner à droite', 'Justify Right');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1385, 'standard', '2008-11-14 19:56:24', 'Justifier', 'Justify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1386, 'standard', '2008-11-14 19:56:24', 'Insérer / modifier un lien', 'Add / Edit link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1387, 'standard', '2008-11-14 19:56:24', 'Supprimer un lien', 'Remove link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1388, 'standard', '2008-11-14 19:56:24', 'Insérer / modifier une ancre', 'Add / Edit anchor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1389, 'standard', '2008-11-14 19:56:24', 'Insérer / modifier une Image', 'Add / Edit image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1390, 'standard', '2008-11-14 19:56:24', 'Insérer / modifier un tableau', 'Add / Edit table');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1391, 'standard', '2008-11-14 19:56:24', 'Insérer un séparateur', 'Add rule');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1392, 'standard', '2008-11-14 19:56:24', 'Insérer un caractère spécial', 'Add a special char');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1393, 'standard', '2008-11-14 19:56:24', 'Style de mise en forme', 'Format style');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1394, 'standard', '2008-11-14 19:56:24', 'Format du texte', 'Text format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1395, 'standard', '2008-11-14 19:56:24', 'Taille du texte', 'Text size');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1396, 'standard', '2008-11-14 19:56:24', 'Couleur du texte', 'Text color');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1397, 'standard', '2008-11-14 19:56:24', 'Couleur de fond', 'Background color');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1398, 'standard', '2008-11-14 19:56:24', '---------------------------------', '---------------------------------');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1399, 'standard', '2008-11-14 19:56:24', 'Editeur WYSIWYG', 'WYSIWYG Editor ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1400, 'standard', '2008-11-14 19:56:24', 'Gestion des barres d''outils de l''éditeur visuel (WYSIWYG)', 'Visual editor (WYSIWYG) toolbars management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1401, 'standard', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de la barre d''outil sélectionnée ?', 'Do you confirm the deletion of the selected toolbar?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1402, 'standard', '2008-11-14 19:56:24', 'Eléments', 'Elements');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1403, 'standard', '2008-11-14 19:56:24', 'Liens internes', 'Internal links');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1404, 'standard', '2008-11-14 19:56:24', 'Barre d''outils', 'Toolbar');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1405, 'standard', '2008-11-14 19:56:24', 'Relations', 'Relations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1406, 'standard', '2008-11-14 19:56:24', 'Pages relationnelles', 'Relationnal pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1407, 'standard', '2008-11-14 19:56:24', 'Pages liées', 'Linked pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1408, 'standard', '2008-11-14 19:56:24', 'Aucun résultat.', 'No result.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1409, 'standard', '2008-11-14 19:56:24', 'Liste des pages', 'Pages list');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1410, 'standard', '2008-11-14 19:56:24', 'liant la page %s', 'which target the page %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1411, 'standard', '2008-11-14 19:56:24', 'liées par la page %s', 'targets by the page %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1412, 'standard', '2008-11-14 19:56:24', 'utilisant les mots clés %s', 'using keywords %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1413, 'standard', '2008-11-14 19:56:24', 'et', 'and');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1414, 'standard', '2008-11-14 19:56:24', 'Attention, cette page est liée par %s pages, voulez vous vraiment supprimer la page "%s" ?', 'Warning, this page is linked by %s pages, do you really want to delete the page "%s" ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1415, 'standard', '2008-11-14 19:56:24', 'ou', 'or');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1416, 'standard', '2008-11-14 19:56:24', 'utilisant les identifiants %s', 'using identifiers %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1417, 'standard', '2008-11-14 19:56:24', '%s page(s) lient cette page.', '%s page(s) targets this page.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (256, 'standard', '2008-11-14 19:56:23', 'Statut', 'Status');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (255, 'standard', '2008-11-14 19:56:23', 'Confirmer l''archivage de l''actualité ''%s''', 'Do you confirm archiving of the news ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (230, 'standard', '2008-11-14 19:56:23', 'Niveau', 'Level');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (231, 'standard', '2008-11-14 19:56:23', 'Valider', 'Change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (232, 'standard', '2008-11-14 19:56:23', 'Les modèles et rangées de page appartiennent à un ou plusieurs groupes. Pour utiliser un modèle ou une rangée, un utilisateur doit avoir les droits sur tous ses groupes.', 'Each template or row belong to one or more groups. For a user to be able to use a template or a row, he or she must have usage rights for ALL the groups to which that belongs to.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (233, 'standard', '2008-11-14 19:56:23', 'Cocher le(s) groupe(s) attribué(s).', 'Check the appropriate groups.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (234, 'standard', '2008-11-14 19:56:23', 'Validation', 'Validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (235, 'standard', '2008-11-14 19:56:23', 'Validation :\r\n\r\n%s\r\nModule : %s\r\n\r\nCommentaires :\r\n%s', 'The following validation has been approved:\r\n\r\n%s\r\napplication : %s\r\n\r\nComments :\r\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (236, 'standard', '2008-11-14 19:56:23', 'Refus de validation ', 'Negative validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (237, 'standard', '2008-11-14 19:56:23', 'Refus de validation :\r\n\r\n%s\r\nModule : %s\r\nCommentaire :\r\n%s', 'A negative validation occurred on the following resource (which should therefore be edited before being able to pass validation again) :\r\n\r\n%s\r\nModule : %s\r\nComment :\r\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (238, 'standard', '2008-11-14 19:56:23', '[Validation transférée]', 'Transferred validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (239, 'standard', '2008-11-14 19:56:23', 'Validation transférée :\r\n\r\nAuteur du transfert : %s\r\n%s\r\nModule : %s\r\nCommentaire :\r\n%s', 'The following validation has been transferred to you :\r\n\r\nValidator author of transfer : %s\r\n%s\r\nModule : %s\r\nComment :\r\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (240, 'standard', '2008-11-14 19:56:23', '[Erreur ! L''élément à valider n''est pas rattaché à  un module]', '[Error. The item to approve is not attached to a valid application]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (241, 'standard', '2008-11-14 19:56:23', '[Erreur ! Le module n''a pas correctement procédé à  la validation de sa ressource]', '[Error: the application failed to properly validate the item]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (242, 'standard', '2008-11-14 19:56:23', 'Droits sur le contenu', 'Content Mgmt. Rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (243, 'standard', '2008-11-14 19:56:23', 'Gestion de pages', 'Pages management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (244, 'standard', '2008-11-14 19:56:23', 'Nouvelle section', 'New section');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (245, 'standard', '2008-11-14 19:56:23', 'Création / modification de l''actualité', 'News item creation / modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (246, 'standard', '2008-11-14 19:56:23', 'Création / modification de l''actualité : ', 'Creation / modification of news item: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (247, 'standard', '2008-11-14 19:56:23', 'Gestion des accès aux modules', 'Access management to modules');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (248, 'standard', '2008-11-14 19:56:23', 'Module %s', 'Module %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (249, 'standard', '2008-11-14 19:56:23', 'Accueil administration', 'Administration home');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (250, 'standard', '2008-11-14 19:56:23', 'Rétablir', 'Undelete');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (251, 'standard', '2008-11-14 19:56:23', 'Rétablir', 'Unarchive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (252, 'standard', '2008-11-14 19:56:23', 'Supprimer', 'Delete');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (253, 'standard', '2008-11-14 19:56:23', 'Archiver', 'Archive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (254, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression de l''actualité ''%s''', 'Do you confirm deletion of the news ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (229, 'standard', '2008-11-14 19:56:23', 'Commentaires', 'Comments');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (228, 'standard', '2008-11-14 19:56:23', 'Déléguer à  ', 'Delegate to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (227, 'standard', '2008-11-14 19:56:23', 'Refuser', 'Refuse');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (226, 'standard', '2008-11-14 19:56:23', 'Accepter', 'Approve');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (225, 'standard', '2008-11-14 19:56:23', 'Aide', 'Help');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (224, 'standard', '2008-11-14 19:56:23', 'Editeur(s) de la ressource', 'Resource editor(s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (223, 'standard', '2008-11-14 19:56:23', 'Validation', 'Validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (222, 'standard', '2008-11-14 19:56:23', '[Le %s "%s" n''a pas été trouvé]', '[Sorry the %s "%s" was not found]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (205, 'standard', '2008-11-14 19:56:23', 'Modification', 'Modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (206, 'standard', '2008-11-14 19:56:23', 'Affichage par lettre', 'Alphabetical search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (207, 'standard', '2008-11-14 19:56:23', 'Affichage par page', 'Complete list search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (208, 'standard', '2008-11-14 19:56:23', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (209, 'standard', '2008-11-14 19:56:23', 'Interne', 'Internal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (210, 'standard', '2008-11-14 19:56:23', 'Externe', 'External');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (211, 'standard', '2008-11-14 19:56:23', 'Validations', 'Validations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (212, 'standard', '2008-11-14 19:56:23', 'Recherche', 'Search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (213, 'standard', '2008-11-14 19:56:23', 'Pages', 'Pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (214, 'standard', '2008-11-14 19:56:23', 'Enlever recherche', 'Remove search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (215, 'standard', '2008-11-14 19:56:23', '[Validations effectuées]', '[Validations approved]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (216, 'standard', '2008-11-14 19:56:23', 'Validation par lot', 'Batch validations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (217, 'standard', '2008-11-14 19:56:23', 'Détail', 'Detail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (218, 'standard', '2008-11-14 19:56:23', 'Cocher les éléments à valider.', 'Check the boxes of files to validate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (219, 'standard', '2008-11-14 19:56:23', 'Soumettre', 'Submit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (220, 'standard', '2008-11-14 19:56:23', 'Cocher', 'Check all');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (221, 'standard', '2008-11-14 19:56:23', 'Décocher', 'Uncheck all');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (203, 'standard', '2008-11-14 19:56:23', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (204, 'standard', '2008-11-14 19:56:23', 'Il existe deux niveaux de notification :<br />\r\n>"Courant" : emails pour tout changement dans vos sections. <br /> >"Critique" : emails relatifs à  des dysfonctionnements ou lorsque votre attention est requise (modification de vos droits par exemple).', 'There are two alert levels:<br />\r\n> "All": Sends an email for all modifications within the section<br />\r\n> "Critical": Sends an email only for major changes and alerts critical to the user.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (200, 'standard', '2008-11-14 19:56:23', 'Fichier joint', 'Uploaded file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (201, 'standard', '2008-11-14 19:56:23', 'Lien', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (202, 'standard', '2008-11-14 19:56:23', 'Fichier existant', 'Existing file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (199, 'standard', '2008-11-14 19:56:23', 'Droits sur les groupes de modèles', 'Application group rights.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (198, 'standard', '2008-11-14 19:56:23', 'Niveau d''accès', 'Access Level');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (197, 'standard', '2008-11-14 19:56:23', 'Notification', 'Alert');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (195, 'standard', '2008-11-14 19:56:23', 'Aucune', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (196, 'standard', '2008-11-14 19:56:23', '[Erreur lors de l''upload du fichier]', '[Error while uploading file]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (194, 'standard', '2008-11-14 19:56:23', 'Image ', 'Current image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (189, 'standard', '2008-11-14 19:56:23', 'Groupe', 'Group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (190, 'standard', '2008-11-14 19:56:23', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (191, 'standard', '2008-11-14 19:56:23', 'Fichier', 'File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (192, 'standard', '2008-11-14 19:56:23', 'Mettre à  jour<br />(Pour supprimer le fichier, cocher la case et laisser le champ "parcourir" vide).', 'Update<br />(to delete file check box and leave above field empty.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (193, 'standard', '2008-11-14 19:56:23', 'Alt tag/Légende', 'Alt tag/caption');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (188, 'standard', '2008-11-14 19:56:23', '[Erreur lors du choix du modèle]', '[Error while loading template]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (187, 'standard', '2008-11-14 19:56:23', 'Changer de modèle', 'Modify template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (186, 'standard', '2008-11-14 19:56:23', 'Choix du modèle', 'Template selection');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (185, 'standard', '2008-11-14 19:56:23', 'Choisir un modèle', 'Select a template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (184, 'standard', '2008-11-14 19:56:23', '[Les champs "mot de passe" doivent être identiques, supérieur à 4 caractères et différents de l''identifiant.]', '[Password fields must be the same, have more than 4 characters and not the same of the login]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (183, 'standard', '2008-11-14 19:56:23', 'L''utilisateur %s a modifié la page : ''%s''', 'User %s has changed the content of the following page : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (180, 'standard', '2008-11-14 19:56:23', 'Annuler', 'Cancel');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (181, 'standard', '2008-11-14 19:56:23', 'Actions', 'Actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (182, 'standard', '2008-11-14 19:56:23', 'Modification d''une page', 'Page content modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (179, 'standard', '2008-11-14 19:56:23', 'Modifier la page', 'Content management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (177, 'standard', '2008-11-14 19:56:23', 'Contenu', 'Content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (178, 'standard', '2008-11-14 19:56:23', 'Erreur lors de la sauvegarde des données ...', 'Error while saving new content ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (176, 'standard', '2008-11-14 19:56:23', 'Modification du contenu', 'Content modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (175, 'standard', '2008-11-14 19:56:23', '[L''identifiant de groupe "%s" existe déjà ]', '[Sorry, the group "%s" is unavailable]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (173, 'standard', '2008-11-14 19:56:23', 'Modification des propriétés de la page ''%s'' par l''utilisateur %s', 'Modification of page properties for page ''%s'' by user %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (174, 'standard', '2008-11-14 19:56:23', 'Modification de la page : %s', 'Page modification : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (172, 'standard', '2008-11-14 19:56:23', 'Modification des propriétés d''une page', 'Page properties modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (171, 'standard', '2008-11-14 19:56:23', 'Modification de l''ordre du menu de navigation de la page ''%s'' par l''utilisateur %s.', 'Order of sub page links modification for page ''%s'' by user %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (168, 'standard', '2008-11-14 19:56:23', 'Nouveau groupe', 'New group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (170, 'standard', '2008-11-14 19:56:23', 'Modification de l''ordre du menu', 'Order of sub-page links modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (162, 'standard', '2008-11-14 19:56:23', 'Actions', 'Actions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (163, 'standard', '2008-11-14 19:56:23', 'Sous-pages', 'Sub pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (164, 'standard', '2008-11-14 19:56:23', 'Haut', 'Up');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (165, 'standard', '2008-11-14 19:56:23', 'Bas', 'Down');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (166, 'standard', '2008-11-14 19:56:23', 'Erreur lors de la modification de l''ordre des pages.', 'Error while trying to modify the order of the sub-pages.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (158, 'standard', '2008-11-14 19:56:23', '[Erreur lors du déplacement de page]', '[Error while moving the page]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (159, 'standard', '2008-11-14 19:56:23', 'Créer une page', 'Create a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (160, 'standard', '2008-11-14 19:56:23', 'Statut', 'Status');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (161, 'standard', '2008-11-14 19:56:23', 'Titre', 'Title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (155, 'standard', '2008-11-14 19:56:23', 'Désactiver', 'Disactivate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (156, 'standard', '2008-11-14 19:56:23', 'Activer', 'Activate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (157, 'standard', '2008-11-14 19:56:23', 'de', 'of');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (152, 'standard', '2008-11-14 19:56:23', 'Nouvel utilisateur', 'New user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (153, 'standard', '2008-11-14 19:56:23', '[Autorisation insuffisante]', 'Clearance insufficient.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (154, 'standard', '2008-11-14 19:56:23', 'Page verrouillée', 'The page is locked.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (150, 'standard', '2008-11-14 19:56:23', 'en jours, 0 pour jamais', 'in number of days, 0 for never');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (149, 'standard', '2008-11-14 19:56:23', 'Moteurs de recherche', 'for search engines');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (148, 'standard', '2008-11-14 19:56:23', 'Format %s', 'format %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (147, 'standard', '2008-11-14 19:56:23', 'Lien', 'Link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (146, 'standard', '2008-11-14 19:56:23', '[L''identifiant "%s" existe déjà ]', '[Sorry, the user name "%s" is unavailable]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (138, 'standard', '2008-11-14 19:56:23', 'Message d''alerte', 'Alert message');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (139, 'standard', '2008-11-14 19:56:23', 'Description', 'Description');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (140, 'standard', '2008-11-14 19:56:23', 'Mots clés', 'Keywords');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (141, 'standard', '2008-11-14 19:56:23', 'jj', 'dd');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (142, 'standard', '2008-11-14 19:56:23', 'mm', 'mm');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (143, 'standard', '2008-11-14 19:56:23', 'aaaa', 'yyyy');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (144, 'standard', '2008-11-14 19:56:23', '[Tous les champs obligatoires ne sont pas renseignés]', '[Please enter required information]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (145, 'standard', '2008-11-14 19:56:23', 'Format incorrect pour le champ : %s', 'Incorrect value entered for: %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (136, 'standard', '2008-11-14 19:56:23', 'Délai d''alerte', 'Alert delay');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (137, 'standard', '2008-11-14 19:56:23', 'Date d''alerte', 'Alert date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (135, 'standard', '2008-11-14 19:56:23', 'Fin de publication', 'Publication end');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (134, 'standard', '2008-11-14 19:56:23', 'Début de publication', 'Publication start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (132, 'standard', '2008-11-14 19:56:23', 'Titre', 'Title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (133, 'standard', '2008-11-14 19:56:23', 'Lien', 'Link name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (131, 'standard', '2008-11-14 19:56:23', '<span class="admin_text_alert">*</span> Champ obligatoire', '<span class="admin_text_alert">*</span> Required');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (130, 'standard', '2008-11-14 19:56:23', 'Création de page - étape %s/3', 'Page creation step %s/3');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (129, 'standard', '2008-11-14 19:56:23', 'Propriétés de la page', 'Page properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (128, 'standard', '2008-11-14 19:56:23', 'Archivage de la page "%s" par l''utilisateur %s', 'Archivage of page "%s" by user %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (127, 'standard', '2008-11-14 19:56:23', 'Archivage de page', 'Page archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (123, 'standard', '2008-11-14 19:56:23', 'Suppression de page', 'Page deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (124, 'standard', '2008-11-14 19:56:23', 'Validation en attente :\r\n', 'The following task needs validation:\r\n');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (125, 'standard', '2008-11-14 19:56:23', 'Suppression de la page "%s" par l''utilisateur %s', 'Deletion of page "%s" by user %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (126, 'standard', '2008-11-14 19:56:23', '[Erreur lors du rétablissement]', '[Error while trying to undo deletion of the page)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (122, 'standard', '2008-11-14 19:56:23', 'Opération effectuée', 'Action completed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (121, 'standard', '2008-11-14 19:56:23', '[Erreur lors de la suppression]', '[Error while deleting page]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (120, 'standard', '2008-11-14 19:56:23', 'Votre profil', 'Your profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (119, 'standard', '2008-11-14 19:56:23', 'Confirmer l''archivage de la page ''%s'' ?', 'Do you confirm asking for archiving of the page ''%s'' ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (118, 'standard', '2008-11-14 19:56:23', 'Confirmer la suppression de la page ''%s'' ?', 'Confirm deletion request for page ''%s'' ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (115, 'standard', '2008-11-14 19:56:23', 'Droits d''administration', 'Administration Rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (111, 'standard', '2008-11-14 19:56:23', 'Fax', 'Fax');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (112, 'standard', '2008-11-14 19:56:23', 'Fonction', 'Job Title');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (113, 'standard', '2008-11-14 19:56:23', 'Droits de consultation', 'Viewing rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (114, 'standard', '2008-11-14 19:56:23', 'Cet utilisateur a tous les droits sur l''application. Il n''est donc pas possible de gérer ses droits par section. Cependant il est possible d''ajouter ou de supprimer des sections dans l''éventualité oà¹ il perdrait ses droits d''origine.', 'This user has total application access. It is not possible to administer his or her viewing and editing rights. To administrate the user''s rights the current status must be modified.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (105, 'standard', '2008-11-14 19:56:23', 'Code Postal', 'Zip Code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (106, 'standard', '2008-11-14 19:56:23', 'Ville', 'City');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (107, 'standard', '2008-11-14 19:56:23', 'Région', 'State');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (108, 'standard', '2008-11-14 19:56:23', 'Pays', 'Country');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (109, 'standard', '2008-11-14 19:56:23', 'Téléphone', 'Phone');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (110, 'standard', '2008-11-14 19:56:23', 'Portable', 'Cell Phone');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (103, 'standard', '2008-11-14 19:56:23', 'Service', 'Service');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (104, 'standard', '2008-11-14 19:56:23', 'Adresse', 'Address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (102, 'standard', '2008-11-14 19:56:23', 'Email', 'Email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (89, 'standard', '2008-11-14 19:56:23', 'Modifier le contenu de la page', 'Modify page content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (90, 'standard', '2008-11-14 19:56:23', 'Créer', 'Create');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (91, 'standard', '2008-11-14 19:56:23', 'Créer une page', 'Create new page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (92, 'standard', '2008-11-14 19:56:23', 'Déplacer la page', 'Move page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (93, 'standard', '2008-11-14 19:56:23', 'Prénom', 'First name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (94, 'standard', '2008-11-14 19:56:23', 'Nom', 'Last name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (95, 'standard', '2008-11-14 19:56:23', 'Confirmer mot de passe', 'Confirm Password');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (96, 'standard', '2008-11-14 19:56:23', 'Langue', 'Language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (97, 'standard', '2008-11-14 19:56:23', 'Rétablir la page "%s" ?', 'Confirm undo deletion of page "%s" ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (98, 'standard', '2008-11-14 19:56:23', 'Sortir d''archive la page "%s" ?', 'Confirm undo archiving of page "%s" ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (99, 'standard', '2008-11-14 19:56:23', 'Coordonnées', 'Contact Information');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (100, 'standard', '2008-11-14 19:56:23', 'Déplacer la page : choisir la destination', 'Move page: choose the destination');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (101, 'standard', '2008-11-14 19:56:23', 'Sélectionner la page de destination de la page %s', 'Select the page destination for the page %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (88, 'standard', '2008-11-14 19:56:23', 'Modifier les propriétés', 'Modify properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (87, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Modify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (86, 'standard', '2008-11-14 19:56:23', 'Annuler l''archivage', 'Undo archiving');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (85, 'standard', '2008-11-14 19:56:23', 'Annuler la suppression', 'Undo deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (84, 'standard', '2008-11-14 19:56:23', 'Supprimer la page', 'Delete page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (83, 'standard', '2008-11-14 19:56:23', 'Archiver la page', 'Archive page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (82, 'standard', '2008-11-14 19:56:23', 'Déverrouiller', 'Unlock');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (81, 'standard', '2008-11-14 19:56:23', 'Autres', 'Other');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (80, 'standard', '2008-11-14 19:56:23', 'Voir en ligne', 'On line');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (79, 'standard', '2008-11-14 19:56:23', 'Aperçu de la page', 'Page preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (78, 'standard', '2008-11-14 19:56:23', 'Page', 'View page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (77, 'standard', '2008-11-14 19:56:23', 'Gestion des utilisateurs', 'Users administration ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (76, 'standard', '2008-11-14 19:56:23', 'Utilisateurs du groupe', 'Users in group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (75, 'standard', '2008-11-14 19:56:23', 'Profils de groupes', 'Group profiles');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (74, 'standard', '2008-11-14 19:56:23', 'Profil de groupe', 'Group profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (73, 'standard', '2008-11-14 19:56:23', 'Profils utilisateurs', 'User profiles');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (72, 'standard', '2008-11-14 19:56:23', 'Modèle', 'Template');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (71, 'standard', '2008-11-14 19:56:23', 'Publication', 'Publication');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (70, 'standard', '2008-11-14 19:56:23', 'ID', 'ID');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (69, 'standard', '2008-11-14 19:56:23', 'au', 'to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (68, 'standard', '2008-11-14 19:56:23', 'Profil utilisateur', 'User Profile');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (67, 'standard', '2008-11-14 19:56:23', 'Profils', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (66, 'standard', '2008-11-14 19:56:23', 'Page inconnue', 'Page unknown');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (65, 'standard', '2008-11-14 19:56:23', '[Droits insuffisants pour accéder à  cette page]', '[Error, you do not have sufficiant rights to view this page]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (64, 'standard', '2008-11-14 19:56:23', 'Gestion de contenu', 'Content management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (63, 'standard', '2008-11-14 19:56:23', 'Choisir une page', 'Select a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (62, 'standard', '2008-11-14 19:56:23', 'Pages', 'Your web pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (60, 'standard', '2008-11-14 19:56:23', 'Validations en attente', 'Validations pending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (57, 'standard', '2008-11-14 19:56:23', 'Sommaire', 'Home');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (58, 'standard', '2008-11-14 19:56:23', 'Sommaire', 'Home');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (56, 'standard', '2008-11-14 19:56:23', 'Valider', 'Validate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (55, 'standard', '2008-11-14 19:56:23', 'Mot de passe', 'Password');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (53, 'standard', '2008-11-14 19:56:23', 'Langue', 'Language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (54, 'standard', '2008-11-14 19:56:23', 'Identifiant', 'Identification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (52, 'standard', '2008-11-14 19:56:23', 'Identification', 'Please enter your access codes');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (51, 'standard', '2008-11-14 19:56:23', 'Bienvenue sur %s', 'Welcome to %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (50, 'standard', '2008-11-14 19:56:23', 'Erreur de login, nouvel essai', 'Login error, please try again.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (49, 'standard', '2008-11-14 19:56:23', 'Page en ligne', 'On line');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (48, 'standard', '2008-11-14 19:56:23', 'Prévisualiser la page', 'Preview');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (47, 'standard', '2008-11-14 19:56:23', 'Modification de l''ordre du menu de navigation de la page :', 'Modification of link order for the page :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (46, 'standard', '2008-11-14 19:56:23', 'Ordre du menu', 'Order of sub page links');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (45, 'standard', '2008-11-14 19:56:23', 'Création / modification de la page :', 'Creation / modification of the page :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (44, 'standard', '2008-11-14 19:56:23', 'Création / modification de page', 'Creation / modification of page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (43, 'standard', '2008-11-14 19:56:23', 'Suppression / archivage de la page :', 'Deletion / archiving of the page :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (40, 'standard', '2008-11-14 19:56:23', 'Transfert', 'Transfer');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (41, 'standard', '2008-11-14 19:56:23', 'Emplacement (suppression / archivage)', 'Location (deletion/archiving)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (42, 'standard', '2008-11-14 19:56:23', 'Suppression / archivage', 'Deletion / archiving of page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (39, 'standard', '2008-11-14 19:56:23', 'Refus', 'Refusal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (38, 'standard', '2008-11-14 19:56:23', 'Acceptation', 'Approval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (37, 'standard', '2008-11-14 19:56:23', '[Session perdue]', '[Session expired]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (36, 'standard', '2008-11-14 19:56:23', 'm/d/y', 'm/d/y');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (35, 'standard', '2008-11-14 19:56:23', 'French', 'English');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (34, 'standard', '2008-11-14 19:56:23', 'Connecté :', 'Connected as:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (33, 'standard', '2008-11-14 19:56:23', 'le', 'the');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (32, 'standard', '2008-11-14 19:56:23', 'Quitter', 'Disconnect');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (31, 'standard', '2008-11-14 19:56:23', 'Meta', 'Advanced');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (30, 'standard', '2008-11-14 19:56:23', 'Modèles', 'Templates');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (29, 'standard', '2008-11-14 19:56:23', 'Journal', 'Log');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (25, 'standard', '2008-11-14 19:56:23', 'Retour', 'Back');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (26, 'standard', '2008-11-14 19:56:23', 'Sommaire', 'Home');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (27, 'standard', '2008-11-14 19:56:23', 'Profils', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (28, 'standard', '2008-11-14 19:56:23', 'Arborescence', 'Tree');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (24, 'standard', '2008-11-14 19:56:23', 'Modifier', 'Modify');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (22, 'standard', '2008-11-14 19:56:23', 'Modification de votre profil', 'Profile modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (23, 'standard', '2008-11-14 19:56:23', 'Alertes sur les pages', 'Pages alerts');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (21, 'standard', '2008-11-14 19:56:23', 'Validations', 'Validations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (20, 'standard', '2008-11-14 19:56:23', 'Journal des actions', 'Action Log Administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (19, 'standard', '2008-11-14 19:56:23', 'Gestion des modèles', 'Template Administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (18, 'standard', '2008-11-14 19:56:23', 'Gestion des rangées', 'Style-rows Administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (17, 'standard', '2008-11-14 19:56:23', 'Régénérer les pages', 'Advanced Administration');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (15, 'standard', '2008-11-14 19:56:23', 'Supprimé', 'Deleted');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (16, 'standard', '2008-11-14 19:56:23', 'Administrateur', 'Super Administrator');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (14, 'standard', '2008-11-14 19:56:23', 'Archivé', 'Archived');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (13, 'standard', '2008-11-14 19:56:23', 'Utilisable', 'Useable');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (12, 'standard', '2008-11-14 19:56:23', 'Admin', 'Admin');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'standard', '2008-11-14 19:56:23', 'Public', 'Public');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'standard', '2008-11-14 19:56:23', 'Propriétés', 'Properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (8, 'standard', '2008-11-14 19:56:23', 'Contenu', 'Content');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (9, 'standard', '2008-11-14 19:56:23', 'Ordre des liens', 'Order of links');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (10, 'standard', '2008-11-14 19:56:23', 'Aucun', 'None');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (11, 'standard', '2008-11-14 19:56:23', 'Site', 'Site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'standard', '2008-11-14 19:56:23', 'Jamais validé', 'Never validated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'standard', '2008-11-14 19:56:23', 'Validé non public', 'Validated not public');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'standard', '2008-11-14 19:56:23', 'Aucun droit', 'No rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'standard', '2008-11-14 19:56:23', 'Site', 'Site');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'standard', '2008-11-14 19:56:23', 'Admin', 'Admin');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'cms_aliases', '2008-11-14 19:56:24', 'Confirmer la suppression de l''alias ''%s''', 'Do you confirm deletion of the alias ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (20, 'cms_forms', '2008-11-14 19:56:24', 'Ajouter un formulaire', 'Add a new form');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (21, 'cms_forms', '2008-11-14 19:56:24', 'Gestion des catégories :', 'Categories management :');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (19, 'cms_forms', '2008-11-14 19:56:24', 'Nom du formulaire', 'Form name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (17, 'cms_forms', '2008-11-14 19:56:24', 'Insérer un document PDF', 'Insert PDF file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (18, 'cms_forms', '2008-11-14 19:56:24', 'Erreur lors de l''insertion du fichier !', 'Error while uploading file !');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (15, 'cms_forms', '2008-11-14 19:56:24', 'Date d''insertion', 'Insertion date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (16, 'cms_forms', '2008-11-14 19:56:24', 'Confirmez-vous la suppresion du formulaire ''%s'' ?', 'Do you confirm deletion of form ''%s'' ?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (13, 'cms_forms', '2008-11-14 19:56:24', 'Fichier', 'File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (14, 'cms_forms', '2008-11-14 19:56:24', 'Adresse', 'URL');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (10, 'cms_forms', '2008-11-14 19:56:24', 'Données reçues', 'Data received');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (11, 'cms_forms', '2008-11-14 19:56:24', 'Formulaires disponibles pour les utilisateurs', 'PDF forms available for users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (12, 'cms_forms', '2008-11-14 19:56:24', 'Voici les formulaires disponibles.', 'Here are the forms available.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'cms_forms', '2008-11-14 19:56:24', 'Enregistrements', 'Records');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'cms_forms', '2008-11-14 19:56:24', 'Dernier envoi', 'Last post');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'cms_forms', '2008-11-14 19:56:24', 'Aucun résultats trouvés', 'No results found');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'cms_forms', '2008-11-14 19:56:24', 'Exporter', 'Export');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (8, 'cms_forms', '2008-11-14 19:56:24', 'Supprimer', 'Delete');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (9, 'cms_forms', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de l''action ''%s'' ?', 'Do you confirm deletion of the ''%s'' action?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'cms_forms', '2008-11-14 19:56:24', 'Formulaire', 'Form');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'cms_forms', '2008-11-14 19:56:24', 'Formulaires', 'Forms');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'cms_forms', '2008-11-14 19:56:24', 'Voici les formulaires qui ont été reçus par l''application. Vous pouvez en exporter les données ou supprimer le contenu existant.', 'Here are the forms that were received by the application. You can export their data or delete it.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (394, 'polymod', '2008-11-14 19:56:24', 'Comparaison numérique de deux champs numériques flottant.', 'Numeric comparison between two float fields.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (395, 'polymod', '2008-11-14 19:56:24', 'La valeur du champ peut-être un nombre négatif', 'Field value can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (109, 'polymod', '2008-11-14 19:56:24', 'Effectuer une recherche', 'Research');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (110, 'polymod', '2008-11-14 19:56:24', '<div class="rowComment">\n<h1>Lance une recherche sur un type d''objet donn&eacute; :</h1>\n<div class="retrait"><span class="code"> 	&lt;atm-search what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">searchName</span>&quot;&gt;...&lt;/atm-search&gt; 	</span><br />\n<br />\n<ul>\n	<li><span class="keyword">objet</span> : Type d''objet &agrave; rechercher (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>\n	<li><span class="keyword">searchName</span> : Nom de la recherche : identifiant unique pour la recherche dans la rang&eacute;e.</li>\n	<li>Un attribut <span class="keyword">public</span> (facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier une recherche sur la zone publique ou &eacute;dit&eacute;e. Il prend pour valeur <span class="vertclair">true</span> pour une recherche publique (d&eacute;faut) ou <span class="vertclair">false</span> pour une recherche dans la zone &eacute;dit&eacute;e.</li>\n</ul>\n</div>\n<h2>Ce tag peut contenir les sous-tags suivants :</h2>\n<div class="retrait">\n<h3>Affichage des r&eacute;sultats :</h3>\n<div class="retrait"><span class="code"> 	&lt;atm-result&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-result&gt; 	</span><br />\n<br />\nLe contenu de ce tag sera lu pour chaque r&eacute;sultat trouv&eacute; pour la recherche en cours.\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>\n	<li>Un attribut <span class="keyword">return </span>(facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier le type de r&eacute;sultat retourn&eacute;. Par d&eacute;faut une recherche revoie des objets, mais dans l''optique d''am&eacute;liorer les performances, il est possible de sp&eacute;cifier les deux valeurs suivantes de retour :\n	<ul>\n		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_IDS</span> : retournera uniquement l''identifiant du r&eacute;sultat.</li>\n		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_OBJECTSLIGHT</span> : retournera le r&eacute;sultat mais sans charger les sous-objets qu''il peut contenir dans ses diff&eacute;rents champs. Attention, ce param&egrave;tre n''est possible que sur une recherche publique.</li>\n	</ul>\n	</li>\n</ul>\n<br />\nLes valeurs suivantes seront remplac&eacute;es dans le tag :\n<ul>\n	<li><span class="vertclair">{firstresult}</span> : Vrai si le r&eacute;sultat en cours est le premier de la page en cours.</li>\n	<li><span class="vertclair">{lastresult}</span> : Vrai si le r&eacute;sultat en cours est le dernier de la page en cours.</li>\n	<li><span class="vertclair">{resultcount}</span> : Num&eacute;ro du r&eacute;sultat dans la page.</li>\n	<li><span class="vertclair">{maxresults}</span> : Nombre de r&eacute;sultats pour la recherche.</li>\n	<li><span class="vertclair">{maxpages}</span> : Nombre de pages maximum pour la recherche en cours.</li>\n	<li><span class="vertclair">{currentpage}</span> : Num&eacute;ro de la page actuelle pour la recherche en cours.</li>\n	<li><span class="vertclair">{resultid}</span> : Identifiant du r&eacute;sultat. Utile dans le cas du''une recherche retournant uniquement les identifiants des r&eacute;sultats (param&egrave;tre return avec la valeur POLYMOD_SEARCH_RETURN_IDS).</li>\n</ul>\n</div>\n<h3>Aucun r&eacute;sultats :</h3>\n<div class="retrait"><span class="code"> 	&lt;atm-noresult&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-noresult&gt; 	</span><br />\n<br />\nLe contenu de ce tag sera affich&eacute; si aucun r&eacute;sultat n''est trouv&eacute; pour la recherche en cours.\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>\n</ul>\n</div>\n<h3>Param&egrave;tre de recherche :</h3>\n<div class="retrait"><span class="code"> 	&lt;atm-search-param search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">paramType</span>&quot; value=&quot;<span class="keyword">paramValue</span>&quot; mandatory=&quot;<span class="keyword">mandatoryValue</span>&quot; /&gt; 	</span><br />\n<br />\nPermet de limiter les r&eacute;sultats de la recherche &agrave; des param&egrave;tres donn&eacute;s.\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>\n	<li><span class="keyword">paramType</span> : Type de param&egrave;tre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> pour filtrer la recherche sur la valeur d''un champs donn&eacute; ou bien un nom de type fixe parmi : <span class="vertclair">%s</span> pour utiliser un filtrage pr&eacute;d&eacute;finis.</li>\n	<li><span class="keyword">paramValue</span> : Valeur du param&egrave;tre de la recherche. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>\n	<li><span class="keyword">mandatoryValue</span> : Bool&eacute;en (<span class="vertclair">true</span> ou <span class="vertclair">false</span>), permet de sp&eacute;cifier si ce param&egrave;tre de recherche est optionnel ou obligatoire.</li>\n</ul>\n<br />\nUn param&egrave;tre suppl&eacute;mentaire <span class="keyword">operator</span> permet d''ajouter un comportement sp&eacute;cifique au type de champs sur le filtre. La valeur accept&eacute;e par ce param&egrave;tre est expliqu&eacute;e dans l''aide du champ concern&eacute; si il accepte un tel param&egrave;tre.</div>\n<h3>Afficher une page donn&eacute;e de r&eacute;sultats (le nombre de r&eacute;sultats d''une page est sp&eacute;cifi&eacute; par le tag atm-search-limit) :</h3>\n<div class="retrait"><span class="code"> 	&lt;atm-search-page search=&quot;<span class="keyword">searchName</span>&quot;  value=&quot;<span class="keyword">pageValue</span>&quot; /&gt; 	</span><br />\n<br />\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>\n	<li><span class="keyword">pageValue</span> : Valeur num&eacute;rique de la page &agrave; afficher.</li>\n</ul>\n</div>\n<h3>Limiter le nombre de r&eacute;sultats d''une page :</h3>\n<div class="retrait"><span class="code"> 	&lt;atm-search-limit search=&quot;<span class="keyword">searchName</span>&quot; value=&quot;<span class="keyword">limitValue</span>&quot; /&gt; 	</span><br />\n<br />\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>\n	<li><span class="keyword">limitValue</span> : Valeur num&eacute;rique de la limite &agrave; appliquer. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>\n</ul>\n</div>\n<h3>Ordonner les r&eacute;sultats :</h3>\n<div class="retrait"><span class="code">&lt;atm-search-order search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">orderType</span>&quot; direction=&quot;<span class="keyword">directionValue</span>&quot; /&gt;</span><br />\n<br />\n<ul>\n	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>\n	<li><span class="keyword">orderType</span> : Type de valeur sur lequel appliquer l''ordre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> ou un nom de type fixe parmi : <span class="vertclair">%s</span>.</li>\n	<li><span class="keyword">directionValue</span> : Sens &agrave; appliquer : <span class="vertclair">asc</span> pour croissant, <span class="vertclair">desc</span> pour d&eacute;croissant. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>\n</ul>\n</div>\n</div>\n<h2>Fonctions :</h2>\n<div class="retrait">\n<h3>Afficher la liste des pages de la recherche en cours :</h3>\n<div class="retrait">\n<div class="code">&lt;atm-function function=&quot;pages&quot; maxpages=&quot;<span class="keyword">maxpagesValues</span>&quot; currentpage=&quot;<span class="keyword">currentpageValue</span>&quot; displayedpage=&quot;<span class="keyword">displayedpagesValue</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;pages&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/pages&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;currentpage&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/currentpage&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;start&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/start&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;previous&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/previous&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;next&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/next&gt;</span><br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;end&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/end&gt;</span><br />\n&lt;/atm-function&gt;</div>\n<br />\n<br />\nCette fonction permet d''afficher la liste de toutes les pages possibles pour la recherche.<br />\n<ul>\n	<li><span class="keyword">maxpagesValue</span> : Nombre de page maximum sur lesquelles boucler (habituellement : <span class="vertclair">{maxpages}</span> ).</li>\n	<li><span class="keyword">currentpageValue</span> : Num&eacute;ro de la page courante de la recherche (habituellement : <span class="vertclair">{currentpage}</span> ).</li>\n	<li><span class="keyword">displayedpagesValue</span> : Nombre de pages &agrave; afficher.</li>\n	<li>Le tag &lt;<span class="keyword">pages</span>&gt; sera lu pour chaque pages &agrave; lister except&eacute; la page courante et la valeur <span class="vertclair">{n}</span> sera remplac&eacute;e par le num&eacute;ro de la page.</li>\n	<li>Le tag optionnel &lt;<span class="keyword">currentpage</span>&gt; sera lu pour la page en cours. Si il n''existe pas, le tag &lt;<span class="keyword">pages</span>&gt; sera utilis&eacute; &agrave; la place.</li>\n	<li>Le tag optionnel &lt;<span class="keyword">start</span>&gt; sera lu pour la premi&egrave;re page.</li>\n	<li>Le tag optionnel &lt;<span class="keyword">previous</span>&gt; sera lu pour la page pr&eacute;c&eacute;dente.</li>\n	<li>Le tag optionnel &lt;<span class="keyword">next</span>&gt; sera lu pour la page suivante.</li>\n	<li>Le tag optionnel &lt;<span class="keyword">end</span>&gt; sera lu pour la derni&egrave;re page.</li>\n</ul>\n</div>\n</div>\n</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (66, 'polymod', '2008-11-14 19:56:24', 'Trouver un objet ''%s''', 'Find a ''%s'' object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (77, 'polymod', '2008-11-14 19:56:24', 'Lister', 'List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (82, 'polymod', '2008-11-14 19:56:24', 'Gestion des éléments ''%s''', '''%s'' elements management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (108, 'polymod', '2008-11-14 19:56:24', 'Gérer les éléments ''%s''', 'Manage elements ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (57, 'polymod', '2008-11-14 19:56:24', 'Publication sur le site', 'Publication on website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (55, 'polymod', '2008-11-14 19:56:24', 'Suppression de l''objet ''%s'' : %s', 'Deletion of ''%s'' object : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (53, 'polymod', '2008-11-14 19:56:24', 'Proposition de suppression d''un objet %s', '%s object deletion proposal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (52, 'polymod', '2008-11-14 19:56:24', 'Confirmez-vous la suppression de l''objet ''%s'' : %s', 'Do you confirm deletion of object ''%s'' : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (37, 'polymod', '2008-11-14 19:56:24', 'Libellé', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (39, 'polymod', '2008-11-14 19:56:24', 'Description', 'Description');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (32, 'polymod', '2008-11-14 19:56:24', 'Changement apporté sur l''objet ''%s'' : %s', 'Content change for object ''%s'' : ''%s''');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (30, 'polymod', '2008-11-14 19:56:24', 'Objet', 'Object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (31, 'polymod', '2008-11-14 19:56:24', 'Changement du contenu d''un objet ''%s''', 'Object ''%s'' content change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'polymod', '2008-11-14 19:56:24', 'Accueil', 'Entry');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (18, 'polymod', '2008-11-14 19:56:24', 'Mots-clés', 'Kewyords');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (19, 'polymod', '2008-11-14 19:56:24', 'Publié entre le', 'Published between');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (20, 'polymod', '2008-11-14 19:56:24', 'et le', 'and');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (21, 'polymod', '2008-11-14 19:56:24', '%s objet(s) ''%s'' correspondant à votre recherche', '%s ''%s'' object(s) relative to your search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'polymod', '2008-11-14 19:56:24', 'Lien existant', 'Current link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'polymod', '2008-11-14 19:56:24', 'Suppression d''un objet ''%s''', '''%s'' object deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'polymod', '2008-11-14 19:56:24', 'Suppression de l''objet ''%s'' :', 'Deletion of ''%s'' object:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'polymod', '2008-11-14 19:56:24', 'Création / modification de l''objet ''%s'' :', 'Creation / modification of ''%s'' object:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'polymod', '2008-11-14 19:56:24', 'Création / modification d''un objet ''%s''', 'Object ''%s'' creation / modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1427, 'standard', '2008-11-14 19:56:24', 'Enregistrer et Quitter', 'Save and Quit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1428, 'standard', '2008-11-14 19:56:24', 'Edition du contenu', 'Content edition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1429, 'standard', '2008-11-14 19:56:24', 'Suppression du contenu', 'Content deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1430, 'standard', '2008-11-14 19:56:24', 'Soumission à validation', 'Submission to validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1431, 'standard', '2008-11-14 19:56:24', 'Ce libellé servira à constituer l''adresse URL du site. Seuls les caractères alphanumériques sont acceptés.', 'This label will be used to create the website URL. Only aphanumerics caracters are allowed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1432, 'standard', '2008-11-14 19:56:24', 'Une branche', 'A branch');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1433, 'standard', '2008-11-14 19:56:24', 'Sélection de la branche à régénérer', 'Select a branch to regenerate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1434, 'standard', '2008-11-14 19:56:24', 'Sélectionner la page racine de la branche à régénérer', 'Select the root page of the branch to regenerate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1435, 'standard', '2008-11-14 19:56:24', 'utilisant les modèles %s', 'using templates %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1436, 'standard', '2008-11-14 19:56:24', 'utilisant le modèle %s', 'using template %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1437, 'standard', '2008-11-14 19:56:24', 'utilisant la rangée %s', 'using row %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1438, 'standard', '2008-11-14 19:56:24', 'utilisant les rangées %s', 'using rows %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1439, 'standard', '2008-11-14 19:56:24', 'Utilisateurs du groupe "%s"', '"%s" group users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1440, 'standard', '2008-11-14 19:56:24', 'Voir les pages', 'See pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1441, 'standard', '2008-11-14 19:56:24', 'Aucun utilisateur n''est associé à ce groupe', 'No users associate to this group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1442, 'standard', '2008-11-14 19:56:24', 'Cocher cette case pour que les utilisateurs n''aient pas les droits sur ces nouveaux groupes', 'If you check this box, no users have rights to these new groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1443, 'standard', '2008-11-14 19:56:24', 'actif', 'active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1444, 'standard', '2008-11-14 19:56:24', 'inactif', 'inactive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1445, 'standard', '2008-11-14 19:56:24', 'Création d''un groupe', 'Create a group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1446, 'standard', '2008-11-14 19:56:24', 'Cette fenêtre vous permet de consulter et modifier le profil d''un groupe d''utilisateurs. En associant un groupe à un ensemble d''utilisateurs vous pouvez centraliser les droits de cet ensemble d''utilisateurs.', 'This window allows you to view and change the profile of a user group. By combining a group to a set of users you can centralize the rights of this group of users.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1447, 'standard', '2008-11-14 19:56:24', 'Vous ne pouvez supprimer un groupe qui possède des utilisateurs.', 'You can not delete a group that has users.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1448, 'standard', '2008-11-14 19:56:24', 'Ce droit permet d''autoriser la duplication d''une branche de pages.', 'This right give the permission to duplicate a pages branch.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'cms_aliases', '2008-11-14 19:56:24', 'Parent', 'Parent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (512, 'polymod', '2008-11-14 19:56:24', 'Création d''un nouvel élément %s.', 'Create a new %s element.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (513, 'polymod', '2008-11-14 19:56:24', 'Recevez un email pour toute validation en attente dans ce module.', 'Receive an email for validation pending in this module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (514, 'polymod', '2008-11-14 19:56:24', 'Validations', 'Validations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (1, 'pmedia', '2008-11-18 12:36:49', 'Médiathèque', 'Mediacenter');

-- --------------------------------------------------------

-- 
-- Structure de la table `actionsTimestamps`
-- 

DROP TABLE IF EXISTS `actionsTimestamps`;
CREATE TABLE `actionsTimestamps` (
  `type_at` varchar(50) NOT NULL default '',
  `date_at` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `actionsTimestamps`
-- 

INSERT INTO `actionsTimestamps` (`type_at`, `date_at`) VALUES ('DAILY_ROUTINE', '2008-11-28 09:39:33');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFiles_archived`
-- 

DROP TABLE IF EXISTS `blocksFiles_archived`;
CREATE TABLE `blocksFiles_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFiles_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFiles_deleted`
-- 

DROP TABLE IF EXISTS `blocksFiles_deleted`;
CREATE TABLE `blocksFiles_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFiles_deleted`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFiles_edited`
-- 

DROP TABLE IF EXISTS `blocksFiles_edited`;
CREATE TABLE `blocksFiles_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFiles_edited`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFiles_edition`
-- 

DROP TABLE IF EXISTS `blocksFiles_edition`;
CREATE TABLE `blocksFiles_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFiles_edition`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFiles_public`
-- 

DROP TABLE IF EXISTS `blocksFiles_public`;
CREATE TABLE `blocksFiles_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFiles_public`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFlashes_archived`
-- 

DROP TABLE IF EXISTS `blocksFlashes_archived`;
CREATE TABLE `blocksFlashes_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFlashes_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFlashes_deleted`
-- 

DROP TABLE IF EXISTS `blocksFlashes_deleted`;
CREATE TABLE `blocksFlashes_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFlashes_deleted`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFlashes_edited`
-- 

DROP TABLE IF EXISTS `blocksFlashes_edited`;
CREATE TABLE `blocksFlashes_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFlashes_edited`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFlashes_edition`
-- 

DROP TABLE IF EXISTS `blocksFlashes_edition`;
CREATE TABLE `blocksFlashes_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFlashes_edition`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksFlashes_public`
-- 

DROP TABLE IF EXISTS `blocksFlashes_public`;
CREATE TABLE `blocksFlashes_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksFlashes_public`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksImages_archived`
-- 

DROP TABLE IF EXISTS `blocksImages_archived`;
CREATE TABLE `blocksImages_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksImages_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksImages_deleted`
-- 

DROP TABLE IF EXISTS `blocksImages_deleted`;
CREATE TABLE `blocksImages_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksImages_deleted`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksImages_edited`
-- 

DROP TABLE IF EXISTS `blocksImages_edited`;
CREATE TABLE `blocksImages_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksImages_edited`
-- 

INSERT INTO `blocksImages_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `label`, `file`, `enlargedFile`, `externalLink`) VALUES (4, 3, 'first', 'a132ad8e6542489be399526940001ee82', 'image', '', 'p3_7333fffc806233ad382709b1af305da0Nenuphars.png', '', '0||||_top||0,0|');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksImages_edition`
-- 

DROP TABLE IF EXISTS `blocksImages_edition`;
CREATE TABLE `blocksImages_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksImages_edition`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksImages_public`
-- 

DROP TABLE IF EXISTS `blocksImages_public`;
CREATE TABLE `blocksImages_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksImages_public`
-- 

INSERT INTO `blocksImages_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `label`, `file`, `enlargedFile`, `externalLink`) VALUES (4, 3, 'first', 'a132ad8e6542489be399526940001ee82', 'image', '', 'p3_7333fffc806233ad382709b1af305da0Nenuphars.png', '', '0||||_top||0,0|');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksRawDatas_archived`
-- 

DROP TABLE IF EXISTS `blocksRawDatas_archived`;
CREATE TABLE `blocksRawDatas_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksRawDatas_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksRawDatas_deleted`
-- 

DROP TABLE IF EXISTS `blocksRawDatas_deleted`;
CREATE TABLE `blocksRawDatas_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksRawDatas_deleted`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksRawDatas_edited`
-- 

DROP TABLE IF EXISTS `blocksRawDatas_edited`;
CREATE TABLE `blocksRawDatas_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksRawDatas_edited`
-- 

INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (1, 9, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 'form', 'a:1:{s:6:"formID";s:1:"2";}');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksRawDatas_edition`
-- 

DROP TABLE IF EXISTS `blocksRawDatas_edition`;
CREATE TABLE `blocksRawDatas_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksRawDatas_edition`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksRawDatas_public`
-- 

DROP TABLE IF EXISTS `blocksRawDatas_public`;
CREATE TABLE `blocksRawDatas_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksRawDatas_public`
-- 

INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (1, 9, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 'form', 'a:1:{s:6:"formID";s:1:"2";}');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksTexts_archived`
-- 

DROP TABLE IF EXISTS `blocksTexts_archived`;
CREATE TABLE `blocksTexts_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksTexts_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksTexts_deleted`
-- 

DROP TABLE IF EXISTS `blocksTexts_deleted`;
CREATE TABLE `blocksTexts_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksTexts_deleted`
-- 

INSERT INTO `blocksTexts_deleted` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (50, 19, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe et utilisation du module Actualit&eacute;s<ul><li>Emploi des Flux RSS</li></ul></li><li>Principe et utilisation du module M&eacute;diath&egrave;que<ul><li>Emploi des plugin Wysiwyg</li></ul></li><li>Principe et utilisation du module Formulaires</li><li>Principe et utilisation du module Alias</li></ul></div>');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksTexts_edited`
-- 

DROP TABLE IF EXISTS `blocksTexts_edited`;
CREATE TABLE `blocksTexts_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksTexts_edited`
-- 

INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (8, 15, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe et utilisation du module Actualit&eacute;s<ul><li>Emploi des Flux RSS</li></ul></li><li>Principe et utilisation du module M&eacute;diath&egrave;que<ul><li>Emploi des plugin Wysiwyg</li></ul></li><li>Principe et utilisation du module Formulaires</li><li>Principe et utilisation du module Alias</li></ul></div>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (9, 16, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Gestion Multi-sites</li><li>S&eacute;curiser l''acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</li><li>Connexion LDAP</li><li>SSO (single Sign On)</li></ul></div>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (5, 14, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Droits sur les pages</li><li>Droits sur les modules</li><li>Droits sur les cat&eacute;gories</li><li>Droits d''administration</li><li>L''utilisateur &quot;anonyme&quot;</li></ul></div>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (10, 4, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Cette page doit d&eacute;crire bri&egrave;vement les grands principes d''utilisattion du CMS et renvoyer vers les sous pages d&eacute;taillant cette utilisation.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (4, 13, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe &quot;d''Utilisateur&quot;</li><li>Principe de &quot;Groupes&quot; d''utilisateurs</li></ul></div>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (3, 12, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe de &quot;Module&quot;</li><li>Modules sur mesure</li><li>G&eacute;n&eacute;rateur de modules</li></ul><p>&nbsp;</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (2, 11, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe de &quot;Page&quot;</li><li>Principe de &quot;Mod&egrave;le&quot;</li><li>Principe de &quot;Rang&eacute;e&quot;</li></ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (29, 2, 'first', 'a0922acb28a233e527aa46607bfec987c', 'texte', '<p><strong>Automne est votre solution</strong> si vous recherchez un outil de gestion de contenu performant et &eacute;volutif, permettant autonomie et contr&ocirc;le &eacute;ditorial. Que votre contenu soit statique ou dynamique avec une gestion en bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes <strong>sans contraintes techniques.<br /></strong></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (49, 3, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p style="text-align: left;">Dans cette page, il faut pr&eacute;senter le CMS. Quels sont ces cas d''utilisations les plus adapt&eacute;s (Sites institutionnels multilangues, intranet, extranet, etc.) et ses forces (modulaire, simple d''usage, solide, perenne, resistant &agrave; la charge, etc.).</p>');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksTexts_edition`
-- 

DROP TABLE IF EXISTS `blocksTexts_edition`;
CREATE TABLE `blocksTexts_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksTexts_edition`
-- 

INSERT INTO `blocksTexts_edition` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (50, 19, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe et utilisation du module Actualit&eacute;s<ul><li>Emploi des Flux RSS</li></ul></li><li>Principe et utilisation du module M&eacute;diath&egrave;que<ul><li>Emploi des plugin Wysiwyg</li></ul></li><li>Principe et utilisation du module Formulaires</li><li>Principe et utilisation du module Alias</li></ul></div>');
INSERT INTO `blocksTexts_edition` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (2, 11, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe de &quot;Page&quot;</li><li>Principe de &quot;Mod&egrave;le&quot;</li><li>Principe de &quot;Rang&eacute;e&quot;</li></ul>');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksTexts_public`
-- 

DROP TABLE IF EXISTS `blocksTexts_public`;
CREATE TABLE `blocksTexts_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksTexts_public`
-- 

INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (3, 12, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe de &quot;Module&quot;</li><li>Modules sur mesure</li><li>G&eacute;n&eacute;rateur de modules</li></ul><p>&nbsp;</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (8, 15, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe et utilisation du module Actualit&eacute;s<ul><li>Emploi des Flux RSS</li></ul></li><li>Principe et utilisation du module M&eacute;diath&egrave;que<ul><li>Emploi des plugin Wysiwyg</li></ul></li><li>Principe et utilisation du module Formulaires</li><li>Principe et utilisation du module Alias</li></ul></div>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (9, 16, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Gestion Multi-sites</li><li>S&eacute;curiser l''acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</li><li>Connexion LDAP</li><li>SSO (single Sign On)</li></ul></div>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (5, 14, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Droits sur les pages</li><li>Droits sur les modules</li><li>Droits sur les cat&eacute;gories</li><li>Droits d''administration</li><li>L''utilisateur &quot;anonyme&quot;</li></ul></div>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (4, 13, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<div class="text"><p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe &quot;d''Utilisateur&quot;</li><li>Principe de &quot;Groupes&quot; d''utilisateurs</li></ul></div>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (10, 4, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Cette page doit d&eacute;crire bri&egrave;vement les grands principes d''utilisattion du CMS et renvoyer vers les sous pages d&eacute;taillant cette utilisation.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (2, 11, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p>Dans cette page doit se trouver des explications sur :</p><ul><li>Principe de &quot;Page&quot;</li><li>Principe de &quot;Mod&egrave;le&quot;</li><li>Principe de &quot;Rang&eacute;e&quot;</li></ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (29, 2, 'first', 'a0922acb28a233e527aa46607bfec987c', 'texte', '<p><strong>Automne est votre solution</strong> si vous recherchez un outil de gestion de contenu performant et &eacute;volutif, permettant autonomie et contr&ocirc;le &eacute;ditorial. Que votre contenu soit statique ou dynamique avec une gestion en bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes <strong>sans contraintes techniques.<br /></strong></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (49, 3, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<p style="text-align: left;">Dans cette page, il faut pr&eacute;senter le CMS. Quels sont ces cas d''utilisations les plus adapt&eacute;s (Sites institutionnels multilangues, intranet, extranet, etc.) et ses forces (modulaire, simple d''usage, solide, perenne, resistant &agrave; la charge, etc.).</p>');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksVarchars_archived`
-- 

DROP TABLE IF EXISTS `blocksVarchars_archived`;
CREATE TABLE `blocksVarchars_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksVarchars_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksVarchars_deleted`
-- 

DROP TABLE IF EXISTS `blocksVarchars_deleted`;
CREATE TABLE `blocksVarchars_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksVarchars_deleted`
-- 

INSERT INTO `blocksVarchars_deleted` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (11, 18, 'first', 'e41e88d5ba9dc4da5ec2772895543861', 'stitre', 'coucou');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksVarchars_edited`
-- 

DROP TABLE IF EXISTS `blocksVarchars_edited`;
CREATE TABLE `blocksVarchars_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksVarchars_edited`
-- 

INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (6, 2, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 'stitre', 'Faciliter la communication et les échanges !');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (4, 3, 'first', 'a909549cfffa588cae12e01ad4152f1f8', 'titre', 'Présentation Titre h1');

-- --------------------------------------------------------

-- 
-- Structure de la table `blocksVarchars_edition`
-- 

DROP TABLE IF EXISTS `blocksVarchars_edition`;
CREATE TABLE `blocksVarchars_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksVarchars_edition`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `blocksVarchars_public`
-- 

DROP TABLE IF EXISTS `blocksVarchars_public`;
CREATE TABLE `blocksVarchars_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `blocksVarchars_public`
-- 

INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (6, 2, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 'stitre', 'Faciliter la communication et les échanges !');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES (4, 3, 'first', 'a909549cfffa588cae12e01ad4152f1f8', 'titre', 'Présentation Titre h1');

-- --------------------------------------------------------

-- 
-- Structure de la table `contactDatas`
-- 

DROP TABLE IF EXISTS `contactDatas`;
CREATE TABLE `contactDatas` (
  `id_cd` int(11) unsigned NOT NULL auto_increment,
  `service_cd` varchar(100) NOT NULL default '',
  `jobTitle_cd` varchar(100) NOT NULL default '',
  `addressField1_cd` varchar(255) NOT NULL default '',
  `addressField2_cd` varchar(255) NOT NULL default '',
  `addressField3_cd` varchar(255) NOT NULL default '',
  `zip_cd` varchar(20) NOT NULL default '',
  `city_cd` varchar(100) NOT NULL default '',
  `state_cd` varchar(50) NOT NULL default '',
  `country_cd` varchar(100) NOT NULL default '',
  `phone_cd` varchar(20) NOT NULL default '',
  `cellphone_cd` varchar(20) NOT NULL default '',
  `fax_cd` varchar(20) NOT NULL default '',
  `email_cd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_cd`),
  KEY `id_cd` (`id_cd`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `contactDatas`
-- 

INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (1, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (3, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (4, '', '', '', '', '', '', '', '', '', '', '', '', 'thierry.bernier@ws-interactive.fr');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (5, '', '', '', '', '', '', '', '', '', '', '', '', 'frank.taillandier@ac-toulouse.fr');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (6, '', '', '', '', '', '', '', '', '', '', '', '', 'wilfrid.leflon@gmail.com');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (7, '', '', '', '', '', '', '', '', '', '', '', '', 'darian81@hotmail.com');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES (8, '', '', '', '', '', '', '', '', '', '', '', '', 'marc.dulibeaud@airbus.com');

-- --------------------------------------------------------

-- 
-- Structure de la table `languages`
-- 

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `code_lng` varchar(5) NOT NULL default '',
  `label_lng` varchar(50) NOT NULL default '',
  `dateFormat_lng` varchar(5) NOT NULL default 'm/d/Y',
  `availableForBackoffice_lng` tinyint(4) NOT NULL default '0',
  `modulesDenied_lng` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`code_lng`),
  KEY `code_lng` (`code_lng`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `languages`
-- 

INSERT INTO `languages` (`code_lng`, `label_lng`, `dateFormat_lng`, `availableForBackoffice_lng`, `modulesDenied_lng`) VALUES ('fr', 'Français', 'd/m/Y', 1, '');
INSERT INTO `languages` (`code_lng`, `label_lng`, `dateFormat_lng`, `availableForBackoffice_lng`, `modulesDenied_lng`) VALUES ('en', 'English', 'm/d/Y', 1, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `linx_real_public`
-- 

DROP TABLE IF EXISTS `linx_real_public`;
CREATE TABLE `linx_real_public` (
  `id_lre` int(11) unsigned NOT NULL auto_increment,
  `start_lre` int(11) unsigned NOT NULL default '0',
  `stop_lre` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_lre`),
  KEY `id_lre` (`id_lre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `linx_real_public`
-- 

INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15958, 8, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15957, 8, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15956, 8, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15955, 8, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15954, 8, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15975, 9, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15974, 9, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15973, 9, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15972, 9, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15885, 4, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15994, 11, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15902, 5, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15901, 5, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15900, 5, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15899, 5, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15898, 5, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15993, 11, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15919, 6, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15918, 6, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15917, 6, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15916, 6, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15915, 6, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15992, 11, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15953, 8, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15991, 11, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15971, 9, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15990, 11, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15952, 8, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15951, 8, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15950, 8, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15949, 8, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15948, 8, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15884, 4, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15989, 11, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15988, 11, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15883, 4, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15897, 5, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15914, 6, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15947, 8, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15970, 9, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15882, 4, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15896, 5, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15913, 6, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15946, 8, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15969, 9, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15987, 11, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15895, 5, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15912, 6, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15968, 9, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15986, 11, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15985, 11, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15945, 8, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15944, 8, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16013, 12, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16012, 12, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16011, 12, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16010, 12, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16009, 12, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16008, 12, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16007, 12, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16006, 12, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16005, 12, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16004, 12, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16003, 12, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16002, 12, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16001, 12, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16000, 12, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15999, 12, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16089, 16, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16088, 16, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16087, 16, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16086, 16, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16085, 16, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16084, 16, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16083, 16, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16082, 16, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16081, 16, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16080, 16, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16079, 16, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16078, 16, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16077, 16, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16076, 16, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16075, 16, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15984, 11, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15983, 11, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15982, 11, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15981, 11, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15980, 11, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15881, 4, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15880, 4, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15879, 4, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15878, 4, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15877, 4, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15943, 8, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15942, 8, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15941, 8, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15940, 8, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15939, 8, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15938, 8, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15937, 8, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15936, 8, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15935, 8, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15934, 8, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16032, 13, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16031, 13, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16030, 13, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16029, 13, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16028, 13, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16027, 13, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16026, 13, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16025, 13, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16024, 13, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16023, 13, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16022, 13, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16021, 13, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16020, 13, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16019, 13, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16018, 13, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16051, 14, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16050, 14, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16049, 14, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16048, 14, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16047, 14, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16046, 14, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16045, 14, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16044, 14, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16043, 14, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16042, 14, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16041, 14, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16040, 14, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16039, 14, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16038, 14, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16037, 14, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16070, 15, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16069, 15, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16068, 15, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16067, 15, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16066, 15, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16065, 15, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16064, 15, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16063, 15, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16062, 15, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16061, 15, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16060, 15, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16059, 15, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16058, 15, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16057, 15, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16056, 15, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15894, 5, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15893, 5, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15892, 5, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15891, 5, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15890, 5, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15889, 5, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15755, 18, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15868, 3, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15911, 6, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15910, 6, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15909, 6, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15908, 6, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15907, 6, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15906, 6, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15967, 9, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15966, 9, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15965, 9, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15964, 9, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15963, 9, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15962, 9, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15629, 10, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15628, 10, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15627, 10, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15626, 10, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15625, 10, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15624, 10, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15623, 10, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15622, 10, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15621, 10, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15620, 10, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15619, 10, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15618, 10, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15867, 3, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15866, 3, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15865, 3, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15876, 4, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15875, 4, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15888, 5, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15887, 5, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15905, 6, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15904, 6, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15933, 8, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15932, 8, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15931, 8, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15930, 8, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15929, 8, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15928, 8, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15927, 8, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15926, 8, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15925, 8, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15924, 8, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15923, 8, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15922, 8, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15961, 9, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15960, 9, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15979, 11, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15978, 11, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15977, 11, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15998, 12, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15997, 12, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15996, 12, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16017, 13, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16016, 13, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16015, 13, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16036, 14, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16035, 14, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16034, 14, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16055, 15, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16054, 15, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16053, 15, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16074, 16, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16073, 16, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16072, 16, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15874, 4, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15873, 4, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15872, 4, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15871, 4, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15870, 4, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15864, 3, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15976, 11, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15921, 8, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15920, 8, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15995, 12, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16071, 16, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16014, 13, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16033, 14, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (16052, 15, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15886, 5, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15863, 3, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15903, 6, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15959, 9, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15869, 4, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15851, 2, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15850, 2, 9);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15849, 2, 8);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15848, 2, 6);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15847, 2, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15846, 2, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15845, 2, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15862, 3, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15861, 3, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15860, 3, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15859, 3, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15858, 3, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15857, 3, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15856, 3, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15855, 3, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15854, 3, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15853, 3, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15852, 3, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15754, 18, 5);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15753, 18, 16);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15752, 18, 15);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15751, 18, 14);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15750, 18, 13);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15749, 18, 12);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15748, 18, 11);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15747, 18, 4);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15746, 18, 3);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15745, 18, 2);
INSERT INTO `linx_real_public` (`id_lre`, `start_lre`, `stop_lre`) VALUES (15744, 18, 2);

-- --------------------------------------------------------

-- 
-- Structure de la table `linx_tree_edited`
-- 

DROP TABLE IF EXISTS `linx_tree_edited`;
CREATE TABLE `linx_tree_edited` (
  `id_ltr` int(11) unsigned NOT NULL auto_increment,
  `father_ltr` int(11) unsigned NOT NULL default '0',
  `sibling_ltr` int(11) unsigned NOT NULL default '0',
  `order_ltr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_ltr`),
  KEY `father_ltr` (`father_ltr`),
  KEY `sibling_ltr` (`sibling_ltr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `linx_tree_edited`
-- 

INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (19, 1, 2, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (20, 2, 3, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (21, 2, 4, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (22, 2, 5, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (23, 2, 6, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (24, 2, 7, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (25, 7, 8, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (26, 7, 9, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (28, 4, 11, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (29, 4, 12, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (30, 4, 13, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (31, 4, 14, 4);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (32, 4, 15, 5);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (33, 4, 16, 6);

-- --------------------------------------------------------

-- 
-- Structure de la table `linx_tree_public`
-- 

DROP TABLE IF EXISTS `linx_tree_public`;
CREATE TABLE `linx_tree_public` (
  `id_ltr` int(11) unsigned NOT NULL auto_increment,
  `father_ltr` int(11) unsigned NOT NULL default '0',
  `sibling_ltr` int(11) unsigned NOT NULL default '0',
  `order_ltr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_ltr`),
  KEY `id_ltr` (`id_ltr`),
  KEY `father_ltr` (`father_ltr`),
  KEY `sibling_ltr` (`sibling_ltr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `linx_tree_public`
-- 

INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (61, 1, 2, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (104, 2, 6, 4);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (103, 2, 5, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (102, 2, 4, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (101, 2, 3, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (77, 7, 8, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (78, 7, 9, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (99, 4, 15, 5);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (98, 4, 14, 4);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (97, 4, 13, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (96, 4, 12, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (95, 4, 11, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES (100, 4, 16, 6);

-- --------------------------------------------------------

-- 
-- Structure de la table `linx_watch_public`
-- 

DROP TABLE IF EXISTS `linx_watch_public`;
CREATE TABLE `linx_watch_public` (
  `id_lwa` int(11) unsigned NOT NULL auto_increment,
  `page_lwa` int(11) unsigned NOT NULL default '0',
  `target_lwa` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_lwa`),
  KEY `id_lwa` (`id_lwa`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `linx_watch_public`
-- 

INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3917, 11, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3909, 8, 8);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3916, 11, 11);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3913, 9, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3915, 11, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3908, 8, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3891, 4, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3890, 4, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3895, 5, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3894, 5, 5);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3914, 11, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3899, 6, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3898, 6, 6);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3907, 8, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3912, 9, 9);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3921, 12, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3906, 8, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3905, 8, 8);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3904, 8, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3887, 3, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3889, 4, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3893, 5, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3897, 6, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3903, 8, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3911, 9, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3920, 12, 12);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3919, 12, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3918, 12, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3937, 16, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3936, 16, 16);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3935, 16, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3934, 16, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3925, 13, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3924, 13, 13);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3923, 13, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3922, 13, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3929, 14, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3928, 14, 14);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3927, 14, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3926, 14, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3933, 15, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3932, 15, 15);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3931, 15, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3930, 15, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3892, 5, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3886, 3, 3);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3896, 6, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3910, 9, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3832, 10, 10);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3831, 10, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3830, 10, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3902, 8, 8);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3901, 8, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3900, 8, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3888, 4, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3883, 2, 7);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3882, 2, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3885, 3, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3884, 3, 2);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3859, 18, 18);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3858, 18, 4);
INSERT INTO `linx_watch_public` (`id_lwa`, `page_lwa`, `target_lwa`) VALUES (3857, 18, 2);

-- --------------------------------------------------------

-- 
-- Structure de la table `locks`
-- 

DROP TABLE IF EXISTS `locks`;
CREATE TABLE `locks` (
  `id_lok` int(11) unsigned NOT NULL auto_increment,
  `resource_lok` int(11) unsigned NOT NULL default '0',
  `locksmithData_lok` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_lok`),
  KEY `id_lok` (`id_lok`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `locks`
-- 

INSERT INTO `locks` (`id_lok`, `resource_lok`, `locksmithData_lok`) VALUES (153, 52, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `log`
-- 

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id_log` int(11) unsigned NOT NULL auto_increment,
  `user_log` int(11) unsigned NOT NULL default '0',
  `action_log` int(11) unsigned NOT NULL default '0',
  `datetime_log` datetime NOT NULL default '0000-00-00 00:00:00',
  `textData_log` mediumtext NOT NULL,
  `label_log` tinytext NOT NULL,
  `module_log` varchar(100) NOT NULL default '',
  `resource_log` int(11) unsigned NOT NULL default '0',
  `rsAfterLocation_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterProposedFor_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterEditions_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterValidationsRefused_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterPublication_log` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_log`),
  KEY `id_ulo` (`id_log`),
  KEY `user_log` (`user_log`),
  KEY `action_log` (`action_log`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `log`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_aliases`
-- 

DROP TABLE IF EXISTS `mod_cms_aliases`;
CREATE TABLE `mod_cms_aliases` (
  `id_ma` int(11) unsigned NOT NULL auto_increment,
  `parent_ma` int(11) unsigned NOT NULL default '0',
  `page_ma` int(11) NOT NULL default '0',
  `url_ma` varchar(255) NOT NULL default '',
  `alias_ma` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_ma`),
  KEY `alias_ma` (`alias_ma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_aliases`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_actions`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_actions`;
CREATE TABLE `mod_cms_forms_actions` (
  `id_act` int(10) unsigned NOT NULL auto_increment,
  `form_act` int(11) unsigned NOT NULL default '0',
  `value_act` mediumtext NOT NULL,
  `type_act` tinyint(2) unsigned NOT NULL default '0',
  `text_act` mediumtext NOT NULL,
  PRIMARY KEY  (`id_act`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_actions`
-- 

INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES (7, 2, 'text', 0, '');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES (8, 2, '', 2, '');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES (9, 2, 'text', 99, '');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES (10, 2, 'text', 1, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_categories`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_categories`;
CREATE TABLE `mod_cms_forms_categories` (
  `id_fca` int(11) unsigned NOT NULL auto_increment,
  `form_fca` int(11) unsigned NOT NULL default '0',
  `category_fca` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_fca`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_categories`
-- 

INSERT INTO `mod_cms_forms_categories` (`id_fca`, `form_fca`, `category_fca`) VALUES (2, 2, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_fields`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_fields`;
CREATE TABLE `mod_cms_forms_fields` (
  `id_fld` int(11) unsigned NOT NULL auto_increment,
  `form_fld` int(11) unsigned NOT NULL default '0',
  `name_fld` varchar(32) NOT NULL default '',
  `label_fld` varchar(255) NOT NULL default '',
  `defaultValue_fld` mediumtext NOT NULL,
  `dataValidation_fld` varchar(100) NOT NULL default '',
  `type_fld` varchar(255) NOT NULL default '',
  `options_fld` mediumtext NOT NULL,
  `required_fld` int(1) NOT NULL default '0',
  `active_fld` int(1) NOT NULL default '0',
  `order_fld` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_fld`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_fields`
-- 

INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (11, 2, '54b8a11ea29b491d40561eb321aed37f', 'Nom * ', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 0);
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (12, 2, '5d62b28a2c474455ae3a937127cf7204', 'Pr é nom * ', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 1);
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (13, 2, '4f77750ba5f191904e9aaab3acab488d', 'Email * ', '', '', 'email', 'a:1:{s:0:"";s:0:"";}', 1, 1, 2);
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (14, 2, '4005693f0d616bab1865d71fea32d1f6', 'Sujet du message * ', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 3);
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (15, 2, '778a8c9cce20558836139d64c7d403c0', 'Message * ', '', '', 'textarea', 'a:1:{s:0:"";s:0:"";}', 1, 1, 5);
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`) VALUES (16, 2, '8e17e732a07c18b447c226014789627c', 'Envoyer', 'Envoyer', '', 'submit', 'a:1:{s:0:"";s:0:"";}', 0, 1, 4);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_formulars`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_formulars`;
CREATE TABLE `mod_cms_forms_formulars` (
  `id_frm` int(11) unsigned NOT NULL auto_increment,
  `name_frm` varchar(255) NOT NULL default '',
  `source_frm` text NOT NULL,
  `language_frm` char(2) NOT NULL default 'en',
  `owner_frm` int(11) unsigned NOT NULL default '0',
  `closed_frm` tinyint(1) NOT NULL default '0',
  `destinationType_frm` int(2) NOT NULL default '0',
  `DestinationData_frm` mediumtext NOT NULL,
  `responses_frm` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_frm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_formulars`
-- 

INSERT INTO `mod_cms_forms_formulars` (`id_frm`, `name_frm`, `source_frm`, `language_frm`, `owner_frm`, `closed_frm`, `destinationType_frm`, `DestinationData_frm`, `responses_frm`) VALUES (2, 'Contact', '<form id="cms_forms_2">\n	<table width="100%" cellspacing="1" cellpadding="1" border="0" align="center">\n		<tbody>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzExX3JlcQ==">Nom * </label></td>\n				<td><input type="text" name="54b8a11ea29b491d40561eb321aed37f" id="zY21zX2ZpZWxkXzExX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzEyX3JlcQ==">Prénom * </label></td>\n				<td><input type="text" name="5d62b28a2c474455ae3a937127cf7204" id="zY21zX2ZpZWxkXzEyX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzEzX2VtYWlsX3JlcQ==">Email * </label></td>\n				<td><input type="text" name="4f77750ba5f191904e9aaab3acab488d" id="zY21zX2ZpZWxkXzEzX2VtYWlsX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzE0X3JlcQ==">Sujet du message * </label></td>\n				<td><input type="text" name="4005693f0d616bab1865d71fea32d1f6" id="zY21zX2ZpZWxkXzE0X3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzE1X3JlcQ==">Message * </label></td>\n				<td><textarea name="778a8c9cce20558836139d64c7d403c0" id="zY21zX2ZpZWxkXzE1X3JlcQ=="></textarea></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"> </td>\n				<td><input type="submit" value="Envoyer" name="8e17e732a07c18b447c226014789627c" class="button" id="zY21zX2ZpZWxkXzE2" /></td>\n			</tr>\n		</tbody>\n	</table>\n</form>', 'fr', 4, 0, 0, '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_records`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_records`;
CREATE TABLE `mod_cms_forms_records` (
  `id_rec` int(11) unsigned NOT NULL auto_increment,
  `sending_rec` int(11) unsigned NOT NULL default '0',
  `field_rec` int(11) unsigned NOT NULL default '0',
  `value_rec` text NOT NULL,
  PRIMARY KEY  (`id_rec`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_records`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_cms_forms_senders`
-- 

DROP TABLE IF EXISTS `mod_cms_forms_senders`;
CREATE TABLE `mod_cms_forms_senders` (
  `id_snd` int(11) unsigned NOT NULL auto_increment,
  `clientIP_snd` varchar(255) NOT NULL default '',
  `dateInserted_snd` datetime default '0000-00-00 00:00:00',
  `sessionID_snd` varchar(100) NOT NULL default '',
  `userAgent_snd` varchar(255) NOT NULL default '',
  `languages_snd` varchar(255) NOT NULL default '',
  `userID_snd` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_snd`),
  KEY `userID_snd` (`userID_snd`),
  KEY `sessionID_snd` (`sessionID_snd`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_cms_forms_senders`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_definition`
-- 

DROP TABLE IF EXISTS `mod_object_definition`;
CREATE TABLE `mod_object_definition` (
  `id_mod` int(11) unsigned NOT NULL auto_increment,
  `label_id_mod` int(11) unsigned NOT NULL default '0',
  `description_id_mod` int(11) unsigned NOT NULL default '0',
  `resource_usage_mod` int(2) unsigned NOT NULL default '0',
  `module_mod` varchar(255) NOT NULL default '',
  `admineditable_mod` int(1) unsigned NOT NULL default '0',
  `composedLabel_mod` varchar(255) NOT NULL default '',
  `previewURL_mod` varchar(255) NOT NULL default '',
  `indexable_mod` int(1) NOT NULL default '0',
  `indexURL_mod` mediumtext NOT NULL,
  `compiledIndexURL_mod` mediumtext NOT NULL,
  `resultsDefinition_mod` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mod`),
  KEY `module_mod` (`module_mod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_definition`
-- 

INSERT INTO `mod_object_definition` (`id_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES (1, 1, 2, 1, 'pnews', 0, '', '5||item={[''object1''][''id'']}', 0, '', '', '');
INSERT INTO `mod_object_definition` (`id_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES (2, 70, 71, 1, 'pmedia', 0, '', '6||item={[''object2''][''id'']}', 0, '', '', '<div class="pmedias">\r\n	<p>{[''object2''][''fields''][9][''fieldname'']} : <strong><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="{[''object2''][''fields''][9][''fileExtension'']}" title="{[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''fields''][9][''fileHTML'']} ({[''object2''][''fields''][9][''fileSize'']}Mo)</strong></p>\r\n	<p>{[''object2''][''fields''][8][''fieldname'']} : <strong>{[''object2''][''fields''][8][''label'']}</strong></p>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n		<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n			</script>\r\n		</atm-if>\r\n		<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n			</script>\r\n		</atm-if>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n		<script type="text/javascript">\r\n			swfobject.embedSWF(''/automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\r\n		</script>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''thumbnail'']} &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3''">\r\n		<p><a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" /></a></p>\r\n	</atm-if>\r\n</div>');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_field`
-- 

DROP TABLE IF EXISTS `mod_object_field`;
CREATE TABLE `mod_object_field` (
  `id_mof` int(11) unsigned NOT NULL auto_increment,
  `object_id_mof` int(11) unsigned NOT NULL default '0',
  `label_id_mof` int(11) unsigned NOT NULL default '0',
  `desc_id_mof` int(11) unsigned NOT NULL default '0',
  `type_mof` varchar(255) NOT NULL default '',
  `order_mof` int(11) unsigned NOT NULL default '0',
  `system_mof` int(1) unsigned NOT NULL default '0',
  `required_mof` int(1) unsigned NOT NULL default '0',
  `indexable_mof` int(1) unsigned NOT NULL default '0',
  `searchlist_mof` int(1) unsigned NOT NULL default '0',
  `searchable_mof` int(1) unsigned NOT NULL default '0',
  `params_mof` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mof`),
  KEY `object_id_mof` (`object_id_mof`,`type_mof`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_field`
-- 

INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (1, 1, 3, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (2, 1, 4, 5, 'CMS_object_text', 3, 0, 1, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"500";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (3, 1, 6, 7, 'CMS_object_text', 4, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"500";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (4, 1, 8, 0, 'CMS_object_image', 5, 0, 0, 0, 0, 1, 'a:3:{s:8:"maxWidth";s:3:"100";s:15:"useDistinctZoom";b:0;s:8:"makeZoom";b:1;}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (5, 1, 9, 0, 'CMS_object_categories', 2, 0, 1, 0, 1, 1, 'a:3:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:1:"2";s:15:"associateUnused";b:0;}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (6, 2, 80, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (7, 2, 83, 0, 'CMS_object_text', 2, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:4:"100%";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (8, 2, 84, 0, 'CMS_object_categories', 3, 0, 1, 0, 1, 1, 'a:6:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:2:"18";s:12:"defaultValue";s:0:"";s:15:"associateUnused";b:0;s:11:"selectWidth";s:0:"";s:12:"selectHeight";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES (9, 2, 85, 86, 'CMS_object_file', 4, 0, 1, 0, 1, 1, 'a:8:{s:12:"useThumbnail";b:1;s:13:"thumbMaxWidth";s:3:"200";s:14:"thumbMaxHeight";s:0:"";s:9:"fileIcons";a:18:{s:3:"doc";s:7:"doc.gif";s:3:"gif";s:7:"gif.gif";s:4:"html";s:8:"html.gif";s:3:"htm";s:8:"html.gif";s:3:"jpg";s:7:"jpg.gif";s:4:"jpeg";s:7:"jpg.gif";s:3:"jpe";s:7:"jpg.gif";s:3:"mov";s:7:"mov.gif";s:3:"mp3";s:7:"mp3.gif";s:3:"pdf";s:7:"pdf.gif";s:3:"png";s:7:"png.gif";s:3:"ppt";s:7:"ppt.gif";s:3:"pps";s:7:"ppt.gif";s:3:"swf";s:7:"swf.gif";s:3:"sxw";s:7:"sxw.gif";s:3:"url";s:7:"url.gif";s:3:"xls";s:7:"xls.gif";s:3:"xml";s:7:"xml.gif";}s:8:"allowFtp";b:0;s:6:"ftpDir";s:13:"/automne/tmp/";s:11:"allowedType";s:0:"";s:14:"disallowedType";s:31:"exe,php,pif,vbs,bat,com,scr,reg";}');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_i18nm`
-- 

DROP TABLE IF EXISTS `mod_object_i18nm`;
CREATE TABLE `mod_object_i18nm` (
  `id_i18nm` int(11) unsigned NOT NULL auto_increment,
  `code_i18nm` char(2) NOT NULL default '',
  `value_i18nm` mediumtext NOT NULL,
  UNIQUE KEY `id` (`id_i18nm`,`code_i18nm`),
  KEY `code` (`code_i18nm`),
  KEY `id_2` (`id_i18nm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_i18nm`
-- 

INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (1, 'fr', 'Actualités');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (1, 'en', 'News');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (2, 'fr', 'Cette ressource permet de publier des textes soumis à une date de publication.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (2, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (3, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (3, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (4, 'fr', 'Introduction');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (4, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (5, 'fr', 'Visible sur la page d''accueil');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (5, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (6, 'fr', 'Texte');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (6, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (7, 'fr', 'Visible dans le détail d''une actualité');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (7, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (8, 'fr', 'Image');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (8, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (9, 'fr', 'Catégorie');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (9, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (10, 'fr', 'Automne : Actualités');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (10, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (11, 'fr', 'Fil RSS des actualités de la démonstration d''Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (11, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (13, 'fr', 'Un document est un fichier Word, PDF au autre complété par un titre, une description, etc.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (13, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (20, 'fr', 'Insérez un lien vers un document français dans vos textes.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (20, 'en', 'Insert a link to a french document into your texts');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (22, 'fr', 'Insérez un lien vers un document anglais dans vos textes');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (22, 'en', 'Insert a link to an english document into your texts');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (24, 'fr', 'Cette ressource permet de publier des images soumises à validation');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (24, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (26, 'fr', 'Permet de catégoriser les images');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (26, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (29, 'fr', 'Titre de l''image');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (29, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (31, 'fr', 'Image de la photothèque, alignée à droite');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (31, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (33, 'fr', 'Image de la photothèque, alignée à gauche');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (33, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (34, 'fr', 'RSS de la photothèque');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (34, 'en', 'Pictures RSS');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (35, 'fr', 'Fil RSS de la photothèque');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (35, 'en', 'Pictures RSS feed');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (36, 'fr', 'Actualités de Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (36, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (37, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (37, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (38, 'fr', 'Actualités de Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (38, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (39, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (39, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (40, 'fr', 'Actualités de Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (40, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (41, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (41, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (42, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (42, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (43, 'fr', 'Fichier média à télécharger. Ce peut-être une vidéo (flv), un son (mp3), une image (jpg, png, gif) ou bien tout autre document (doc, pdf, txt, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (43, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (44, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (44, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (45, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (45, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (46, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (46, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (47, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (47, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (48, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (48, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (49, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (49, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (50, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (50, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (51, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (51, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (52, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (52, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (53, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (53, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (54, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (54, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (55, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (55, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (56, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (56, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (57, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (57, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (58, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (58, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (59, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (59, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (60, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (60, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (61, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (61, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (62, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (62, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (63, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (63, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (64, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (64, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (65, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (65, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (66, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (66, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (67, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (67, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (68, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (68, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (69, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (69, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (70, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (70, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (71, 'fr', 'Média à télécharger de type Vidéo (flv), Image (jpg, gif, png), Son (mp3) ou tout autre type de fichier (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (71, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (72, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (72, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (73, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (73, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (74, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (74, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (75, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (75, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (76, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (76, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (77, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (77, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (78, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (78, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (79, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (79, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (80, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (80, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (81, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (82, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (83, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (83, 'en', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (84, 'fr', 'Catégorie');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (84, 'en', 'Category');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (85, 'fr', 'Fichier');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (85, 'en', 'File');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (86, 'fr', 'Média à télécharger de type Vidéo (flv), Image (jpg, gif, png), Son (mp3) ou tout autre type de fichier (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (86, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (87, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (87, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (88, 'fr', 'Insérez un média depuis la médiathèque directement dans votre texte.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES (88, 'en', 'Insert a media from the mediacenter directly into your text.');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_plugin_definition`
-- 

DROP TABLE IF EXISTS `mod_object_plugin_definition`;
CREATE TABLE `mod_object_plugin_definition` (
  `id_mowd` int(11) unsigned NOT NULL auto_increment,
  `object_id_mowd` int(11) unsigned NOT NULL default '0',
  `label_id_mowd` int(11) unsigned NOT NULL default '0',
  `description_id_mowd` int(11) unsigned NOT NULL default '0',
  `query_mowd` mediumtext NOT NULL,
  `definition_mowd` mediumtext NOT NULL,
  `compiled_definition_mowd` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mowd`),
  KEY `object_id_mowd` (`object_id_mowd`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_plugin_definition`
-- 

INSERT INTO `mod_object_plugin_definition` (`id_mowd`, `object_id_mowd`, `label_id_mowd`, `description_id_mowd`, `query_mowd`, `definition_mowd`, `compiled_definition_mowd`) VALUES (1, 2, 87, 88, 'a:1:{i:8;s:1:"0";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="/js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n				</script>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="/js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n				</script>\r\n			</atm-if>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n			<script type="text/javascript" src="/js/modules/pmedia/swfobject.js"></script>\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''/automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''/automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\r\n			</script>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''/imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-valid>\r\n	<atm-plugin-view>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''/imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-view>\r\n</atm-plugin>', '<?php\n//Generated by : $Id: automne4.sql,v 1.2 2008/11/28 15:11:28 sebastien Exp $\n$content = "";\n$replace = "";\nif (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n$parameters[''objectID''] = 2;\nif (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\nif (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\nif (!isset($object) || !is_array($object)) $object = array();\nif (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n$parameters[''module''] = ''pmedia'';\n//PLUGIN TAG START 19_64e515\nif (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n	CMS_grandFather::raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n} else {\n	//search needed object (need to search it for publications and rights purpose)\n	if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n		$objectDefinitions[$parameters[''objectID'']] = new CMS_poly_object_definition($parameters[''objectID'']);\n	}\n	$search_19_64e515 = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n	$search_19_64e515->addWhereCondition(''item'', $parameters[''itemID'']);\n	$results_19_64e515 = $search_19_64e515->search();\n	if (isset($results_19_64e515[$parameters[''itemID'']]) && is_object($results_19_64e515[$parameters[''itemID'']])) {\n		$object[$parameters[''objectID'']] = $results_19_64e515[$parameters[''itemID'']];\n	} else {\n		$object[$parameters[''objectID'']] = new CMS_poly_object($parameters[''objectID''], 0, array(), $parameters[''public'']);\n	}\n	//PLUGIN-VALID TAG START 20_959bd7\n	if ($object[$parameters[''objectID'']]->isInUserSpace() && !isset($parameters[''plugin-view'']) && !isset($this->_parameters[''has-plugin-view'']) ) {\n		//IF TAG START 21_ae5109\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''flv'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''mp3'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				$content .="\n				<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n				//IF TAG START 22_84d8d5\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n					}\n				}//IF TAG END 22_84d8d5\n				$content .=" ".$object[2]->getValue(''label'','''')."</a>\n				";\n			}\n		}//IF TAG END 21_ae5109\n		//IF TAG START 23_05c919\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''flv''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				//IF TAG START 24_5dc02e\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<script type=\\"text/javascript\\" src=\\"/js/modules/pmedia/swfobject.js\\"></script>\n						<script type=\\"text/javascript\\">\n						swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''/automne/playerflv/config_playerflv.xml'', startimage:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."''}, {allowfullscreen:true, wmode:''transparent''}, false);\n						</script>\n						";\n					}\n				}//IF TAG END 24_5dc02e\n				//IF TAG START 25_638f90\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<script type=\\"text/javascript\\" src=\\"/js/modules/pmedia/swfobject.js\\"></script>\n						<script type=\\"text/javascript\\">\n						swfobject.embedSWF(''/automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''/automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\n						</script>\n						";\n					}\n				}//IF TAG END 25_638f90\n				$content .="\n				<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-video\\" style=\\"width:320px;height:200px;\\">\n				<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n				</div>\n				";\n			}\n		}//IF TAG END 23_05c919\n		//IF TAG START 26_360b52\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''mp3''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				$content .="\n				<script type=\\"text/javascript\\" src=\\"/js/modules/pmedia/swfobject.js\\"></script>\n				<script type=\\"text/javascript\\">\n				swfobject.embedSWF(''/automne/playermp3/player_mp3.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''200'', ''20'', ''9.0.0'', ''/automne/swfobject/expressInstall.swf'', {mp3:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''/automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\n				</script>\n				<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-audio\\" style=\\"width:200px;height:20px;\\">\n				<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n				</div>\n				";\n			}\n		}//IF TAG END 26_360b52\n		//IF TAG START 27_77b95d\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				//IF TAG START 28_088e6c\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&label=".$object[2]->getValue(''label'','''')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n						";\n					}\n				}//IF TAG END 28_088e6c\n				//IF TAG START 29_e1c9d8\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" />\n						";\n					}\n				}//IF TAG END 29_e1c9d8\n			}\n		}//IF TAG END 27_77b95d\n	}\n	//PLUGIN-VALID END 20_959bd7\n	//PLUGIN-VIEW TAG START 30_cf486b\n	if ($object[$parameters[''objectID'']]->isInUserSpace() && isset($parameters[''plugin-view''])) {\n		//IF TAG START 31_deddcd\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				$content .="\n				<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n				//IF TAG START 32_584bb8\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n					}\n				}//IF TAG END 32_584bb8\n				$content .=" ".$object[2]->getValue(''label'','''')."</a>\n				";\n			}\n		}//IF TAG END 31_deddcd\n		//IF TAG START 33_4ea590\n		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n		if ($ifcondition) {\n			$func = create_function("","return (".$ifcondition.");");\n			if ($func()) {\n				//IF TAG START 34_0f7052\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&label=".$object[2]->getValue(''label'','''')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n						";\n					}\n				}//IF TAG END 34_0f7052\n				//IF TAG START 35_d1f8f4\n				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n				if ($ifcondition) {\n					$func = create_function("","return (".$ifcondition.");");\n					if ($func()) {\n						$content .="\n						<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" />\n						";\n					}\n				}//IF TAG END 35_d1f8f4\n			}\n		}//IF TAG END 33_4ea590\n	}\n	//PLUGIN-VIEW END 30_cf486b\n	$content .="\n	";\n}\n//PLUGIN TAG END 19_64e515\necho CMS_polymod_definition_parsing::replaceVars($content, $replace);\n?>');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_polyobjects`
-- 

DROP TABLE IF EXISTS `mod_object_polyobjects`;
CREATE TABLE `mod_object_polyobjects` (
  `id_moo` int(11) unsigned NOT NULL auto_increment,
  `object_type_id_moo` int(11) unsigned NOT NULL default '0',
  `deleted_moo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_moo`),
  KEY `object_id_moo` (`object_type_id_moo`),
  KEY `deleted_moo` (`deleted_moo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_polyobjects`
-- 

INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (4, 1, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (5, 1, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (6, 1, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (7, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (8, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (9, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (10, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (11, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (12, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (13, 2, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES (14, 2, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_object_rss_definition`
-- 

DROP TABLE IF EXISTS `mod_object_rss_definition`;
CREATE TABLE `mod_object_rss_definition` (
  `id_mord` int(11) unsigned NOT NULL auto_increment,
  `object_id_mord` int(11) unsigned NOT NULL default '0',
  `label_id_mord` int(11) unsigned NOT NULL default '0',
  `description_id_mord` int(11) unsigned NOT NULL default '0',
  `link_mord` varchar(255) NOT NULL default '',
  `author_mord` varchar(255) NOT NULL default '',
  `copyright_mord` varchar(255) NOT NULL default '',
  `categories_mord` mediumtext NOT NULL,
  `ttl_mord` int(11) NOT NULL default '0',
  `email_mord` varchar(255) NOT NULL default '',
  `definition_mord` mediumtext NOT NULL,
  `compiled_definition_mord` mediumtext NOT NULL,
  `last_compilation_mord` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_mord`),
  KEY `object_id_mord` (`object_id_mord`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_object_rss_definition`
-- 

INSERT INTO `mod_object_rss_definition` (`id_mord`, `object_id_mord`, `label_id_mord`, `description_id_mord`, `link_mord`, `author_mord`, `copyright_mord`, `categories_mord`, `ttl_mord`, `email_mord`, `definition_mord`, `compiled_definition_mord`, `last_compilation_mord`) VALUES (3, 1, 40, 41, '', '', '', '', 1440, '', '<atm-rss language="fr">\r\n    <atm-rss-title>Actualités du site démo d''Automne</atm-rss-title>\r\n    <atm-search what="{[''object1'']}" name="rss">\r\n        <atm-search-order search="rss" type="publication date after" direction="desc" />\r\n        <atm-result search="rss">\r\n            <atm-rss-item>\r\n                <atm-rss-item-url>{page:5:url}?item={[''object1''][''id'']}</atm-rss-item-url>\r\n                <atm-rss-item-title>{[''object1''][''fields''][1][''value'']}</atm-rss-item-title>\r\n                <atm-rss-item-content>{[''object1''][''fields''][2][''htmlvalue'']}</atm-rss-item-content>\r\n                <atm-rss-item-date>{[''object1''][''formatedDateStart'']|d/m/Y}</atm-rss-item-date>\r\n            </atm-rss-item>\r\n        </atm-result>\r\n    </atm-search>\r\n</atm-rss>', '<?php\n//Generated by : $Id: automne4.sql,v 1.2 2008/11/28 15:11:28 sebastien Exp $\n$content = "";\n$replace = "";\nif (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n$parameters[''objectID''] = 1;\nif (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n$parameters[''public''] = true;\nif (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\nif (!isset($object) || !is_array($object)) $object = array();\nif (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters[''public'']);\n$parameters[''module''] = ''pnews'';\n//RSS TAG START 2_d5241c\nif (!sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n	CMS_grandFather::raiseError(''Error into atm-rss tag : can\\''t found object infos to use into : $parameters[\\''objectID\\'']'');\n} else {\n	//RSS-ITEM-TITLE TAG START 3_5f8d28\n	$content .= ''<title>'';\n	//save content\n	$content_3_5f8d28 = $content;\n	$content = '''';\n	$content .="Actualités du site démo d''Automne";\n	//then remove tags from content and add it to old content\n	$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n	$content = $content_3_5f8d28.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n	$content .= ''</title>'';\n	//RSS-ITEM-TITLE TAG END 3_5f8d28\n	//SEARCH rss TAG START 4_8e98f2\n	$objectDefinition_rss = ''1'';\n	if (!isset($objectDefinitions[$objectDefinition_rss])) {\n		$objectDefinitions[$objectDefinition_rss] = new CMS_poly_object_definition($objectDefinition_rss);\n	}\n	//public search ?\n	$public_4_8e98f2 = isset($public_search) ? $public_search : false;\n	//get search params\n	$search_rss = new CMS_object_search($objectDefinitions[$objectDefinition_rss], $public_4_8e98f2);\n	$launchSearch_rss = true;\n	//add search conditions if any\n	$search_rss->addOrderCondition("publication date after", "desc");\n	//RESULT rss TAG START 5_f8701d\n	//launch search rss if not already done\n	if($launchSearch_rss && !isset($results_rss)) {\n		if (isset($search_rss)) {\n			$results_rss = $search_rss->search();\n		} else {\n			CMS_grandFather::raiseError("Malformed atm-result tag : can''t use this tag outside of atm-search \\"rss\\" tag ...");\n			$results_rss = array();\n		}\n	} elseif (!$launchSearch_rss) {\n		$results_rss = array();\n	}\n	if ($results_rss) {\n		$object_5_f8701d = $object[$objectDefinition_rss]; //save previous object search if any\n		$replace_5_f8701d = $replace; //save previous replace vars if any\n		$count_5_f8701d = 0;\n		$content_5_f8701d = $content; //save previous content var if any\n		$maxPages_5_f8701d = $search_rss->getMaxPages();\n		$maxResults_5_f8701d = $search_rss->getNumRows();\n		foreach ($results_rss as $object[$objectDefinition_rss]) {\n			$content = "";\n			$replace["atm-search"] = array (\n				"{resultid}" 	=> (isset($resultID_rss)) ? $resultID_rss : $object[$objectDefinition_rss]->getID(),\n				"{firstresult}" => (!$count_5_f8701d) ? 1 : 0,\n				"{lastresult}" 	=> ($count_5_f8701d == sizeof($results_rss)-1) ? 1 : 0,\n				"{resultcount}" => ($count_5_f8701d+1),\n				"{maxpages}"    => $maxPages_5_f8701d,\n				"{currentpage}" => ($search_rss->getAttribute(''page'')+1),\n				"{maxresults}"  => $maxResults_5_f8701d,\n			);\n			//RSS-ITEM TAG START 6_45825c\n			$content .= ''<item>\n			<guid isPermaLink="false">object''.$parameters[''objectID''].''-''.$object[$parameters[''objectID'']]->getID().''</guid>'';\n			//RSS-ITEM-LINK TAG START 7_c68f82\n			$content .= ''<link>'';\n			//save content\n			$content_7_c68f82 = $content;\n			$content = '''';\n			$content .=CMS_tree::getPageValue("5","url")."?item=".$object[1]->getValue(''id'','''');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_7_c68f82.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</link>'';\n			//RSS-ITEM-LINK TAG END 7_c68f82\n			//RSS-ITEM-TITLE TAG START 8_66bf43\n			$content .= ''<title>'';\n			//save content\n			$content_8_66bf43 = $content;\n			$content = '''';\n			$content .=$object[1]->objectValues(1)->getValue(''value'','''');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_8_66bf43.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</title>'';\n			//RSS-ITEM-TITLE TAG END 8_66bf43\n			//RSS-ITEM-DESCRIPTION TAG START 9_9a189c\n			$content .= ''<description>'';\n			$content .= ''<![CDATA['';\n			$content .=$object[1]->objectValues(2)->getValue(''htmlvalue'','''');\n			$content .= '']]>'';\n			$content .= ''</description>'';\n			//RSS-ITEM-DESCRIPTION TAG END 9_9a189c\n			//RSS-ITEM-PUBDATE TAG START 10_603f10\n			$content .= ''<pubDate>'';\n			//save content\n			$content_10_603f10 = $content;\n			$content = '''';\n			$content .=$object[1]->getValue(''formatedDateStart'',''d/m/Y'');\n			//then remove tags from content and add it to old content\n			$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n			$content = $content_10_603f10.str_replace(array_keys($entities),$entities,strip_tags(html_entity_decode($content)));\n			$content .= ''</pubDate>'';\n			//RSS-ITEM-PUBDATE TAG END 10_603f10\n			$content .= ''</item>'';\n			//RSS-ITEM TAG END 6_45825c\n			$count_5_f8701d++;\n			//do all result vars replacement\n			$content_5_f8701d.= CMS_polymod_definition_parsing::replaceVars($content, $replace);\n		}\n		$content = $content_5_f8701d; //retrieve previous content var if any\n		$replace = $replace_5_f8701d; //retrieve previous replace vars if any\n		$object[$objectDefinition_rss] = $object_5_f8701d; //retrieve previous object search if any\n	}\n	//RESULT rss TAG END 5_f8701d\n	//destroy search and results rss objects\n	unset($search_rss);\n	unset($results_rss);\n	//SEARCH rss TAG END 4_8e98f2\n	$content .="\n	";\n}\n//RSS TAG END 2_d5241c\necho CMS_polymod_definition_parsing::replaceVars($content, $replace);\n?>', '2008-11-27 16:36:09');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_clientSpaces_archived`
-- 

DROP TABLE IF EXISTS `mod_standard_clientSpaces_archived`;
CREATE TABLE `mod_standard_clientSpaces_archived` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_clientSpaces_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_clientSpaces_deleted`
-- 

DROP TABLE IF EXISTS `mod_standard_clientSpaces_deleted`;
CREATE TABLE `mod_standard_clientSpaces_deleted` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_clientSpaces_deleted`
-- 

INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (66, 'first', 'affc86791d167e2cb69ceee0cc7ef15aa', 42, 0);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (66, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (73, 'first', 'affc86791d167e2cb69ceee0cc7ef15aa', 42, 0);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (73, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (74, 'first', 'e41e88d5ba9dc4da5ec2772895543861', 43, 0);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (74, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (74, 'first', 'ef68332801171f3678986a9192ea85db', 67, 2);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (74, 'first', 'f903cd685e932c2c4869aa1abb7f9baa', 46, 3);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (77, 'first', 'd1b7f6a5f47092f9a7bfea7cec1372a8', 43, 0);
INSERT INTO `mod_standard_clientSpaces_deleted` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (77, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_clientSpaces_edited`
-- 

DROP TABLE IF EXISTS `mod_standard_clientSpaces_edited`;
CREATE TABLE `mod_standard_clientSpaces_edited` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_clientSpaces_edited`
-- 

INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', 'e41e88d5ba9dc4da5ec2772895543861', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (60, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (60, 'first', '32cb0307cd8ffed124fc134040c3f3aa', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (61, 'first', 'a23554f135ed742872910b38a70131cf3', 58, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (62, 'first', 'a1ba42094f9b45486a0338b5eea859dfb', 68, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (68, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (64, 'first', '85e7287f61fa20d9cd0d0adabbef07d1', 54, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (65, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 55, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', '208a024f3937f27fe18ed500d8cc5f45', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'second', 'a149c4ef608130b6963fff950126d8690', 66, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'a3d870864a3e56a90a0d28aa0c711e1ea', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (68, 'first', 'eeae69d143e8c84965ca473216a6ecb3', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (69, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (69, 'first', '371c9ed72e688f253f0a36a4a59d2a03', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (70, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (70, 'first', '122bb16237bbd0fe1635ecc17c9c1afe', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (71, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (72, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (71, 'first', 'd1b7f6a5f47092f9a7bfea7cec1372a8', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (72, 'first', '719aac17d1664a0c0d26c80baaeb37a7', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'first', 'a0922acb28a233e527aa46607bfec987c', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'a5044a1116de2d2e01240551e660e115b', 67, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (76, 'first', 'd1b7f6a5f47092f9a7bfea7cec1372a8', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (76, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', 'ef68332801171f3678986a9192ea85db', 67, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', 'f903cd685e932c2c4869aa1abb7f9baa', 46, 3);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'ad770773dce6c671ccba8c91a72921bbe', 46, 3);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_clientSpaces_edition`
-- 

DROP TABLE IF EXISTS `mod_standard_clientSpaces_edition`;
CREATE TABLE `mod_standard_clientSpaces_edition` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_clientSpaces_edition`
-- 

INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (73, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (73, 'first', 'affc86791d167e2cb69ceee0cc7ef15aa', 42, 0);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', '198690666d878af31b7d27d2f4c1cfd3', 67, 3);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', '472f95744f761c8f816f68cd59cf28a8', 46, 2);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', '53a2f135735e315515920da75a688354', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (58, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edition` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', '208a024f3937f27fe18ed500d8cc5f45', 43, 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_clientSpaces_public`
-- 

DROP TABLE IF EXISTS `mod_standard_clientSpaces_public`;
CREATE TABLE `mod_standard_clientSpaces_public` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_clientSpaces_public`
-- 

INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (60, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (60, 'first', '32cb0307cd8ffed124fc134040c3f3aa', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (61, 'first', 'a23554f135ed742872910b38a70131cf3', 58, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (62, 'first', 'a1ba42094f9b45486a0338b5eea859dfb', 68, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (68, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (64, 'first', '85e7287f61fa20d9cd0d0adabbef07d1', 54, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (65, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 55, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'first', 'a0922acb28a233e527aa46607bfec987c', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (67, 'first', '208a024f3937f27fe18ed500d8cc5f45', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (68, 'first', 'eeae69d143e8c84965ca473216a6ecb3', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (69, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (69, 'first', '371c9ed72e688f253f0a36a4a59d2a03', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (70, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (70, 'first', '122bb16237bbd0fe1635ecc17c9c1afe', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (71, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (71, 'first', 'd1b7f6a5f47092f9a7bfea7cec1372a8', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (72, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (72, 'first', '719aac17d1664a0c0d26c80baaeb37a7', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'a3d870864a3e56a90a0d28aa0c711e1ea', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (57, 'second', 'a149c4ef608130b6963fff950126d8690', 66, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'a5044a1116de2d2e01240551e660e115b', 67, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES (59, 'first', 'ad770773dce6c671ccba8c91a72921bbe', 46, 3);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_standard_rows`
-- 

DROP TABLE IF EXISTS `mod_standard_rows`;
CREATE TABLE `mod_standard_rows` (
  `id_row` int(11) unsigned NOT NULL auto_increment,
  `label_row` varchar(100) NOT NULL default '',
  `definitionFile_row` varchar(100) NOT NULL default '',
  `modulesStack_row` varchar(255) NOT NULL default '',
  `groupsStack_row` varchar(255) NOT NULL default '',
  `image_row` varchar(255) NOT NULL,
  `description_row` text NOT NULL,
  `tplfilter_row` varchar(255) NOT NULL,
  `useable_row` int(1) NOT NULL,
  PRIMARY KEY  (`id_row`),
  KEY `id_row` (`id_row`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_standard_rows`
-- 

INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (25, '000 Exemple', 'r25_Complet.xml', 'standard', '', 'nopicto.gif', '', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (46, '220 Texte et Image Gauche', 'r46_220_Texte_et_Image_Gauche.xml', 'standard', '', 'text-img-left.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (45, '210 Texte et Image Droite', 'r45_210_Texte__image_droite.xml', 'standard', '', 'text-img-right.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (44, '200 Texte', 'r44_200_Texte.xml', 'standard', '', 'text.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (43, '110 Sous Titre', 'r43_100_Sous_Titre.xml', 'standard', '', 'title.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (42, '100 Titre', 'r42_000_Titre.xml', 'standard', '', 'title.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (47, '400 Télécharger un fichier', 'r47_400_Telecharger_un_fichier.xml', 'standard', '', 'file.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (48, '300 Image Centrée', 'r48_300_Image_Centree.xml', 'standard', '', 'img.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (49, '410 Animation Flash', 'r49_500_Animation_Flash.xml', 'standard', '', 'flash.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (54, '700 Plan du site', 'r54_700_Plan_du_site.xml', 'standard', 'admin', 'nopicto.gif', '', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (55, '800 Formulaire', 'r55_800_Formulaire.xml', 'cms_forms', 'admin', 'form.gif', '', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (58, '605 Actualités : Recherche', 'r58_610_Actualites__Recherche_FR.xml', 'pnews', 'admin', 'module.gif', '', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (61, '900 Google Maps', 'r61_900_Google_Maps.xml', 'standard', 'admin', 'nopicto.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (62, '901 Lecteur MP3', 'r62_901_Lecteur_MP3.xml', 'standard', '', '', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (63, '902 Lecteur vidéo', 'r63_902_Lecteur_video.xml', 'standard', '', '', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (66, '615 Dernière actualité', 'r66_615_Derniere_actualite.xml', 'pnews', 'admin', 'module.gif', '', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (67, '120 Sous Sous Titre', 'r67_120_Sous_Sous_Titre.xml', 'standard', '', 'title.gif', '', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES (68, '650 Mediathèque', 'r68_650_Mediatheque.xml', 'pmedia', 'admin', 'module.gif', '', '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_date_deleted`
-- 

DROP TABLE IF EXISTS `mod_subobject_date_deleted`;
CREATE TABLE `mod_subobject_date_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_date_deleted`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_date_edited`
-- 

DROP TABLE IF EXISTS `mod_subobject_date_edited`;
CREATE TABLE `mod_subobject_date_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_date_edited`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_date_public`
-- 

DROP TABLE IF EXISTS `mod_subobject_date_public`;
CREATE TABLE `mod_subobject_date_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_date_public`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_integer_deleted`
-- 

DROP TABLE IF EXISTS `mod_subobject_integer_deleted`;
CREATE TABLE `mod_subobject_integer_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_integer_deleted`
-- 

INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (14, 6, 0, 0, 51);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (15, 6, 5, 0, 17);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (12, 5, 0, 0, 50);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (13, 5, 5, 0, 17);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (16, 7, 0, 0, 60);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (17, 7, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (18, 7, 8, 0, 20);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (19, 8, 0, 0, 61);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (20, 8, 8, 0, 19);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (21, 8, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (22, 9, 0, 0, 62);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (23, 9, 8, 0, 21);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (24, 9, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (25, 10, 0, 0, 63);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (26, 10, 8, 0, 22);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (27, 10, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (28, 11, 0, 0, 64);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (29, 11, 8, 0, 22);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (30, 11, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (37, 14, 0, 0, 68);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (38, 14, 8, 0, 21);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (39, 14, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (34, 13, 0, 0, 67);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (35, 13, 8, 0, 20);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (36, 13, 9, 3, 1);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (31, 12, 0, 0, 66);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (32, 12, 8, 0, 22);
INSERT INTO `mod_subobject_integer_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (33, 12, 9, 3, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_integer_edited`
-- 

DROP TABLE IF EXISTS `mod_subobject_integer_edited`;
CREATE TABLE `mod_subobject_integer_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_integer_edited`
-- 

INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (9, 4, 0, 0, 49);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (11, 4, 5, 0, 17);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_integer_public`
-- 

DROP TABLE IF EXISTS `mod_subobject_integer_public`;
CREATE TABLE `mod_subobject_integer_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_integer_public`
-- 

INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (11, 4, 5, 0, 17);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (9, 4, 0, 0, 49);

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_string_deleted`
-- 

DROP TABLE IF EXISTS `mod_subobject_string_deleted`;
CREATE TABLE `mod_subobject_string_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_string_deleted`
-- 

INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (23, 6, 1, 0, 'Duis ut diam');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (24, 6, 4, 0, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (25, 6, 4, 1, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (26, 6, 4, 2, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (19, 5, 1, 0, 'Test');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (20, 5, 4, 0, 'r5_4_coucher_de_soleil_thumbnail.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (21, 5, 4, 1, 'Coucher de soleil.jpg');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (22, 5, 4, 2, 'r5_4_coucher_de_soleil.jpg');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (27, 7, 6, 0, 'Test médiathèque Image');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (28, 7, 9, 0, 'Clint-blog-.jpg');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (29, 7, 9, 1, 'r7_9_clint-blog-.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (30, 7, 9, 2, '0.17');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (31, 7, 9, 4, 'r7_9_clint-blog-.jpg');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (32, 8, 6, 0, 'test vidéo');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (33, 8, 9, 0, 'videoplayback.flv');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (34, 8, 9, 1, 'r8_9_my_cms_kick_your_cms_ass.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (35, 8, 9, 2, '3.32');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (36, 8, 9, 4, 'r8_9_videoplayback.flv');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (37, 9, 6, 0, 'test PDF');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (38, 9, 9, 0, 'fichier PDF');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (39, 9, 9, 1, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (40, 9, 9, 2, '1.01');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (41, 9, 9, 4, 'r9_9_accessiweb_v11_deploye_9juin2008.pdf');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (42, 10, 6, 0, 'Test Mp3');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (43, 10, 9, 0, '01-asa-jailer.mp3');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (44, 10, 9, 1, 'r10_9_asa.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (45, 10, 9, 2, '5.26');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (46, 10, 9, 4, 'r10_9_01-asa-jailer.mp3');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (47, 11, 6, 0, 'Test mp3 2');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (48, 11, 9, 0, 'MIA');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (49, 11, 9, 1, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (50, 11, 9, 2, '5.27');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (51, 11, 9, 4, 'r11_9_m.i.a._xl_11_paper_planes.mp3');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (62, 14, 6, 0, 'test doc');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (63, 14, 9, 0, 'doc pdf ');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (64, 14, 9, 1, '');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (65, 14, 9, 2, '0.03');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (66, 14, 9, 4, 'r14_9_formation_js.doc');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (57, 13, 6, 0, 'test image');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (58, 13, 9, 0, 'image ...');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (59, 13, 9, 1, 'r13_9_asa-asa-2007-back.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (60, 13, 9, 2, '0.21');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (61, 13, 9, 4, 'r13_9_asa-asa-2007-back.jpg');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (52, 12, 6, 0, 'test mp3');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (53, 12, 9, 0, 'ASA Jailer');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (54, 12, 9, 1, 'r12_9_asa-asa-2007-front.png');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (55, 12, 9, 2, '5.26');
INSERT INTO `mod_subobject_string_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (56, 12, 9, 4, 'r12_9_01-asa-jailer.mp3');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_string_edited`
-- 

DROP TABLE IF EXISTS `mod_subobject_string_edited`;
CREATE TABLE `mod_subobject_string_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_string_edited`
-- 

INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (15, 4, 1, 0, 'Automne V.4 disponible');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (16, 4, 4, 0, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (17, 4, 4, 1, 'Automne 4');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (18, 4, 4, 2, 'r4_4_automne.jpg');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_string_public`
-- 

DROP TABLE IF EXISTS `mod_subobject_string_public`;
CREATE TABLE `mod_subobject_string_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_string_public`
-- 

INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (18, 4, 4, 2, 'r4_4_automne.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (17, 4, 4, 1, 'Automne 4');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (16, 4, 4, 0, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (15, 4, 1, 0, 'Automne V.4 disponible');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_text_deleted`
-- 

DROP TABLE IF EXISTS `mod_subobject_text_deleted`;
CREATE TABLE `mod_subobject_text_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_text_deleted`
-- 

INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (8, 6, 2, 0, '<p>Duis ut diam id eros faucibus consectetuer! In tortor. Aenean leo dui, aliquam non, dapibus volutpat, rhoncus quis, orci. Ut consequat leo sed erat. Aliquam aliquam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris tincidunt placerat urna? Curabitur laoreet imperdiet arcu. Suspendisse iaculis. Vestibulum mattis malesuada urna.</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (9, 6, 3, 0, '<p>Etiam dolor nisl, fringilla sit amet, condimentum laoreet, pellentesque a, sapien. Donec mattis, elit nec congue adipiscing, orci ipsum cursus eros, et sollicitudin eros metus ut lorem. Sed adipiscing dolor a nisl pharetra interdum. Nullam fringilla pharetra felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent pretium. Quisque velit. Aenean diam dui, pellentesque eu, tristique ut, vulputate a, lacus. Donec pretium. Maecenas vel nulla. Donec sed nisl sed ligula convallis consectetuer. Fusce non mauris.<br  />\r\n<br  />\r\nNam ut metus in felis facilisis pulvinar! In justo leo, fermentum vel, volutpat a, lacinia eu, enim. Nulla facilisi. Cras auctor ullamcorper nibh.</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (6, 5, 2, 0, '<p>Fusce dictum, metus ut interdum posuere, sem nisl dictum risus, eget sagittis massa massa tempor lorem. Morbi ut sapien eu dui aliquam mollis? Nullam scelerisque nisi id neque. Donec scelerisque mi at dui. Etiam pretium pharetra pede. Praesent quis leo at erat dictum dictum. Suspendisse eget sapien sed odio venenatis facilisis.</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (7, 5, 3, 0, '<p>Cras turpis justo, accumsan sollicitudin, lacinia consectetuer, placerat a, velit. Vivamus vel mi? Phasellus quis nisl ac orci porttitor volutpat. Quisque ultrices imperdiet tortor. Integer tempus velit sed metus. Duis vehicula tempor massa. Nullam sodales, tellus at fringilla aliquet, velit lorem egestas lorem, id semper erat orci eget elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce luctus nibh quis augue. Mauris faucibus, justo a semper venenatis, odio metus rhoncus est, vitae mollis risus felis id odio. Phasellus imperdiet porta tortor. Suspendisse risus tellus, laoreet ut, blandit nec, venenatis id, est? Pellentesque vestibulum nunc ac diam? Duis pulvinar, metus id viverra pellentesque, augue sapien porttitor dui, in hendrerit ante mauris sit amet enim. Vivamus enim. Donec nibh ligula, ultrices vitae, sollicitudin et, feugiat ut, elit! Curabitur pulvinar tortor sit amet pede. Phasellus semper metus et urna.<br  />\r\n<br  />\r\nMaecenas vehicula. Aliquam id felis sed nunc laoreet lacinia? Nunc quis felis vel velit consequat congue. Sed felis tellus, viverra quis, venenatis et, lobortis et, enim. Nam a lacus egestas nulla semper tincidunt! Mauris tellus. Cras laoreet viverra ipsum. Pellentesque vulputate, lorem non accumsan consequat, eros dolor sodales felis, vitae pharetra turpis orci a sem. Ut et dolor vel elit lacinia volutpat! Etiam tempor. Aenean interdum ultricies lacus. Pellentesque odio nisi, bibendum id, pharetra id, sagittis et, augue. Aliquam sollicitudin? Nulla non orci id dui vehicula scelerisque? Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris vel sem. Pellentesque a tellus.<br  />\r\n<br  />\r\nFusce eros. Maecenas tristique tempus odio. Sed tellus enim, cursus et, accumsan in, molestie sed, felis. Fusce dapibus, odio quis sagittis fermentum, arcu tellus posuere tortor; quis laoreet lectus ante eget ante. Aenean ac felis. Praesent nec justo nec dui interdum consectetuer. Pellentesque diam nibh, pulvinar vel, dictum ac, consectetuer nec, erat. Pellentesque vel magna et tellus molestie sagittis. Vestibulum consectetuer viverra tortor. Curabitur interdum nunc pellentesque nisl! Etiam sodales! Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce sit amet tellus in risus malesuada luctus. Vivamus luctus sollicitudin leo!</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (10, 7, 7, 0, '<p>Un petit test d''image</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (11, 8, 7, 0, '<p>un test de vid&eacute;o ...</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (12, 9, 7, 0, '<p>test de fichier PDF</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (13, 10, 7, 0, '<p>test fichier mp3</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (14, 11, 7, 0, '<p>deuxi&egrave;me test de meupeutroi</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (17, 14, 7, 0, '<p>un ptit doc ...</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (16, 13, 7, 0, '<p>tite image</p>');
INSERT INTO `mod_subobject_text_deleted` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (15, 12, 7, 0, '<p>un ptit test de meupeutroi</p>');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_text_edited`
-- 

DROP TABLE IF EXISTS `mod_subobject_text_edited`;
CREATE TABLE `mod_subobject_text_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_text_edited`
-- 

INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (4, 4, 2, 0, '<p>Depuis pr&egrave;s d''un an maintenant nous travaillons &agrave; la <strong>refonte compl&egrave;te d''Automne</strong>.Cette version est aujourd''hui bien avanc&eacute;e et cel&agrave; nous permet de vous livrer quelques infos &agrave; son sujet.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (5, 4, 3, 0, '<p>Le code est enti&egrave;rement r&eacute;&eacute;crit pour tirer le meilleur parti de PHP5. L''interface d''administration a &eacute;t&eacute; enti&egrave;rement revue pour &ecirc;tre plus intuitive et plus extensible. Elle fait <strong>un grand usage de la librairie Javascript </strong><a href="http://extjs.com/" target="_blank"><strong>ExtJS</strong></a><strong>.</strong></p>\n<p>Elle emploie aussi les composants open-source suivant :</p>\n<ul>\n    <li><a href="http://www.gscottolson.com/blackbirdjs/" target="_blank">Blackbird</a></li>\n    <li><a href="http://marijn.haverbeke.nl/codemirror/" target="_blank">CodeMirror</a></li>\n    <li><a target="_blank" href="http://code.google.com/p/cssmin/">CSSMin</a></li>\n    <li><a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a></li>\n    <li><a href="http://www.crockford.com/javascript/jsmin.html" target="_blank">JSMin</a></li>\n    <li><a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a></li>\n    <li><a href="http://code.google.com/p/swfobject/" target="_blank">SWFObject</a></li>\n    <li><a href="http://swfupload.org/" target="_blank">SWFUpload</a></li>\n    <li><a href="http://framework.zend.com/" target="_blank">Zend Framework</a></li>\n</ul>\n<p>Si vous souhaitez nous aider pour finaliser cette version, vous pouvez le faire savoir dans <a href="http://www.automne.ws/forum/viewtopic.php?t=391" target="_blank">ce sujet sur le forum</a>. Vous y trouverez les d&eacute;tails n&eacute;cessaires.</p>\n<p>Merci &agrave; vous !</p>');

-- --------------------------------------------------------

-- 
-- Structure de la table `mod_subobject_text_public`
-- 

DROP TABLE IF EXISTS `mod_subobject_text_public`;
CREATE TABLE `mod_subobject_text_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `mod_subobject_text_public`
-- 

INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (4, 4, 2, 0, '<p>Depuis pr&egrave;s d''un an maintenant nous travaillons &agrave; la <strong>refonte compl&egrave;te d''Automne</strong>.Cette version est aujourd''hui bien avanc&eacute;e et cel&agrave; nous permet de vous livrer quelques infos &agrave; son sujet.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES (5, 4, 3, 0, '<p>Le code est enti&egrave;rement r&eacute;&eacute;crit pour tirer le meilleur parti de PHP5. L''interface d''administration a &eacute;t&eacute; enti&egrave;rement revue pour &ecirc;tre plus intuitive et plus extensible. Elle fait <strong>un grand usage de la librairie Javascript </strong><a href="http://extjs.com/" target="_blank"><strong>ExtJS</strong></a><strong>.</strong></p>\n<p>Elle emploie aussi les composants open-source suivant :</p>\n<ul>\n    <li><a href="http://www.gscottolson.com/blackbirdjs/" target="_blank">Blackbird</a></li>\n    <li><a href="http://marijn.haverbeke.nl/codemirror/" target="_blank">CodeMirror</a></li>\n    <li><a target="_blank" href="http://code.google.com/p/cssmin/">CSSMin</a></li>\n    <li><a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a></li>\n    <li><a href="http://www.crockford.com/javascript/jsmin.html" target="_blank">JSMin</a></li>\n    <li><a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a></li>\n    <li><a href="http://code.google.com/p/swfobject/" target="_blank">SWFObject</a></li>\n    <li><a href="http://swfupload.org/" target="_blank">SWFUpload</a></li>\n    <li><a href="http://framework.zend.com/" target="_blank">Zend Framework</a></li>\n</ul>\n<p>Si vous souhaitez nous aider pour finaliser cette version, vous pouvez le faire savoir dans <a href="http://www.automne.ws/forum/viewtopic.php?t=391" target="_blank">ce sujet sur le forum</a>. Vous y trouverez les d&eacute;tails n&eacute;cessaires.</p>\n<p>Merci &agrave; vous !</p>');

-- --------------------------------------------------------

-- 
-- Structure de la table `modules`
-- 

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id_mod` int(11) unsigned NOT NULL auto_increment,
  `label_mod` int(11) unsigned NOT NULL default '0',
  `codename_mod` varchar(20) NOT NULL default '',
  `administrationFrontend_mod` varchar(100) NOT NULL default '',
  `hasParameters_mod` tinyint(4) NOT NULL default '0',
  `isPolymod_mod` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_mod`),
  KEY `id_mod` (`id_mod`),
  KEY `codename_mod` (`codename_mod`),
  KEY `isPolymod_mod` (`isPolymod_mod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `modules`
-- 

INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES (1, 243, 'standard', '', 1, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES (2, 1, 'cms_aliases', 'index.php', 0, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES (3, 1, 'cms_forms', 'index.php', 1, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES (4, 1, 'pnews', 'index.php', 0, 1);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES (5, 1, 'pmedia', 'index.php', 0, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `modulesCategories`
-- 

DROP TABLE IF EXISTS `modulesCategories`;
CREATE TABLE `modulesCategories` (
  `id_mca` int(11) unsigned NOT NULL auto_increment,
  `module_mca` varchar(20) NOT NULL default '',
  `parent_mca` int(10) unsigned NOT NULL default '0',
  `root_mca` int(10) unsigned NOT NULL default '0',
  `lineage_mca` varchar(255) NOT NULL default '',
  `order_mca` int(10) unsigned NOT NULL default '1',
  `icon_mca` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mca`),
  KEY `module` (`module_mca`),
  KEY `lineage` (`lineage_mca`),
  KEY `parent` (`parent_mca`),
  KEY `root` (`root_mca`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `modulesCategories`
-- 

INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (1, 'cms_forms', 0, 0, '1', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (2, 'pnews', 0, 0, '2', 2, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (6, 'pdocs', 0, 0, '6', 3, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (14, 'ppictures', 0, 0, '14', 4, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (17, 'pnews', 2, 2, '2;17', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (18, 'pmedia', 0, 0, '18', 5, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (19, 'pmedia', 18, 18, '18;19', 3, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (20, 'pmedia', 18, 18, '18;20', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (21, 'pmedia', 18, 18, '18;21', 2, '');
INSERT INTO `modulesCategories` (`id_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES (22, 'pmedia', 18, 18, '18;22', 4, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `modulesCategories_clearances`
-- 

DROP TABLE IF EXISTS `modulesCategories_clearances`;
CREATE TABLE `modulesCategories_clearances` (
  `id_mcc` int(11) unsigned NOT NULL auto_increment,
  `profile_mcc` int(11) unsigned NOT NULL default '0',
  `category_mcc` int(10) unsigned NOT NULL default '0',
  `clearance_mcc` tinyint(16) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_mcc`),
  UNIQUE KEY `profilecategories` (`profile_mcc`,`category_mcc`),
  KEY `profile` (`profile_mcc`),
  KEY `category` (`category_mcc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `modulesCategories_clearances`
-- 

INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (404, 1, 6, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (405, 1, 14, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (403, 1, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (174, 3, 14, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (173, 3, 6, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (172, 3, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (171, 3, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (406, 1, 18, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (247, 4, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (248, 4, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (249, 4, 6, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (250, 4, 14, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (251, 5, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (252, 5, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (253, 5, 6, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (254, 5, 14, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (402, 1, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (380, 10, 18, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (379, 10, 2, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (384, 9, 18, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (383, 9, 2, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (388, 7, 18, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (387, 7, 2, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (392, 8, 18, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (391, 8, 2, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (396, 6, 18, 2);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES (395, 6, 2, 2);

-- --------------------------------------------------------

-- 
-- Structure de la table `modulesCategories_i18nm`
-- 

DROP TABLE IF EXISTS `modulesCategories_i18nm`;
CREATE TABLE `modulesCategories_i18nm` (
  `id_mcl` int(11) unsigned NOT NULL auto_increment,
  `category_mcl` int(11) unsigned NOT NULL default '0',
  `language_mcl` char(2) NOT NULL default 'en',
  `label_mcl` varchar(255) NOT NULL default '',
  `description_mcl` text NOT NULL,
  `file_mcl` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mcl`),
  UNIQUE KEY `categoryperlang` (`category_mcl`,`language_mcl`),
  KEY `category` (`category_mcl`),
  KEY `language` (`language_mcl`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `modulesCategories_i18nm`
-- 

INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (3, 1, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (4, 1, 'fr', 'Formulaire', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (7, 2, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (8, 2, 'fr', 'Actualités', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (27, 6, 'en', 'Documents', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (28, 6, 'fr', 'Documents', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (71, 14, 'en', 'Pictures', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (72, 14, 'fr', 'Photos', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (83, 17, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (84, 17, 'fr', 'Actualité', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (87, 18, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (88, 18, 'fr', 'Média', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (91, 19, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (92, 19, 'fr', 'Vidéo', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (99, 20, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (100, 20, 'fr', 'Image', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (103, 21, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (104, 21, 'fr', 'Document', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (107, 22, 'en', '', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES (108, 22, 'fr', 'Audio', '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `pageTemplates`
-- 

DROP TABLE IF EXISTS `pageTemplates`;
CREATE TABLE `pageTemplates` (
  `id_pt` int(11) unsigned NOT NULL auto_increment,
  `label_pt` varchar(100) NOT NULL default '',
  `groupsStack_pt` varchar(255) NOT NULL default '',
  `modulesStack_pt` varchar(255) NOT NULL default '1',
  `definitionFile_pt` varchar(100) NOT NULL default '',
  `creator_pt` int(11) unsigned NOT NULL default '0',
  `private_pt` tinyint(4) NOT NULL default '0',
  `image_pt` varchar(255) NOT NULL default '',
  `inUse_pt` tinyint(4) unsigned NOT NULL default '0',
  `printingCSOrder_pt` varchar(255) NOT NULL default '',
  `description_pt` text NOT NULL,
  `websitesdenied_pt` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_pt`),
  KEY `id_pt` (`id_pt`),
  KEY `definitionFile_pt` (`definitionFile_pt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pageTemplates`
-- 

INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle vide. Employé pour les pages de redirections.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (2, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle d''exemple.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (56, 'Accueil', 'fr', 'standard', 'pt56_Accueil.xml', 0, 0, 'accueil.jpg', 0, 'first;second', 'Modèles de la page d''accueil du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (57, 'Accueil', 'fr', 'standard', 'pt56_Accueil.xml', 0, 1, 'accueil.jpg', 0, 'first;second', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (58, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 0, 'interieur-vert.jpg', 1, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (59, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (60, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (61, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (62, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (63, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (64, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (65, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (66, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (67, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (68, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (69, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (70, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (71, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (72, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (73, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (74, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (76, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (77, 'Intérieur', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');

-- --------------------------------------------------------

-- 
-- Structure de la table `pages`
-- 

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id_pag` int(11) unsigned NOT NULL auto_increment,
  `resource_pag` int(11) unsigned NOT NULL default '0',
  `remindedEditorsStack_pag` varchar(255) NOT NULL default '',
  `lastReminder_pag` date NOT NULL default '0000-00-00',
  `template_pag` int(11) unsigned NOT NULL default '0',
  `lastFileCreation_pag` datetime NOT NULL default '0000-00-00 00:00:00',
  `url_pag` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pag`),
  KEY `id_pag` (`id_pag`),
  KEY `template_pag` (`template_pag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pages`
-- 

INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (1, 1, '4', '2008-10-31', 1, '2008-11-28 15:56:32', '1-demo-automne.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (2, 40, '1', '2008-10-31', 57, '2008-11-28 15:56:34', '2-accueil.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (3, 41, '1', '2008-11-03', 59, '2008-11-28 15:56:36', '3-presentation.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (4, 42, '1', '2008-11-03', 60, '2008-11-28 15:56:37', '4-fonctionnalites.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (5, 43, '1', '2008-11-03', 61, '2008-11-28 15:56:39', '5-actualite.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (6, 44, '4', '2008-11-03', 62, '2008-11-28 15:56:40', '6-mediatheque.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (7, 45, '4;4', '2008-11-03', 63, '0000-00-00 00:00:00', '7-bas-de-page.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (8, 46, '1', '2008-11-03', 64, '2008-11-28 15:56:42', '8-plan-du-site.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (9, 47, '4', '2008-11-03', 65, '2008-11-28 15:56:43', '9-contact.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (10, 48, '', '2008-11-04', 66, '2008-11-12 12:31:21', '10-lorem-ipsum.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (11, 52, '1', '2008-11-12', 67, '2008-11-28 15:56:45', '11-gestion-de-contenu.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (12, 53, '1', '2008-11-12', 68, '2008-11-28 15:56:46', '12-modules.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (13, 54, '1', '2008-11-12', 69, '2008-11-28 15:56:48', '13-gestion-des-utilisateurs.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (14, 55, '1', '2008-11-12', 70, '2008-11-28 15:56:49', '14-gestion-des-droits.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (15, 56, '1', '2008-11-12', 71, '2008-11-28 15:56:51', '15-module-actualites-mediatheque.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (16, 57, '1', '2008-11-12', 72, '2008-11-28 15:56:52', '16-fonctions-annexes.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (17, 58, '', '2008-11-14', 73, '0000-00-00 00:00:00', '');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (18, 59, '', '2008-11-14', 74, '2008-11-14 16:54:55', '18-test.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES (19, 65, '', '0000-00-00', 77, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `pagesBaseData_archived`
-- 

DROP TABLE IF EXISTS `pagesBaseData_archived`;
CREATE TABLE `pagesBaseData_archived` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pbd`),
  KEY `id_pbd` (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pagesBaseData_archived`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `pagesBaseData_deleted`
-- 

DROP TABLE IF EXISTS `pagesBaseData_deleted`;
CREATE TABLE `pagesBaseData_deleted` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pbd`),
  KEY `id_pbd` (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pagesBaseData_deleted`
-- 

INSERT INTO `pagesBaseData_deleted` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (28, 10, 'Lorem ipsum', 'Lorem ipsum', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_deleted` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (35, 17, 'Test', 'Test', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_deleted` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (36, 18, 'test', 'test', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_deleted` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (37, 19, 'Modules Actualités, Médiathèque, Formulaires, Alias', 'Les modules', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `pagesBaseData_edited`
-- 

DROP TABLE IF EXISTS `pagesBaseData_edited`;
CREATE TABLE `pagesBaseData_edited` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pbd`),
  KEY `id_pbd` (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pagesBaseData_edited`
-- 

INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (1, 1, 'Démo Automne', 'Démo Automne', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '1|2|||_top|||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (20, 2, 'Automne version 4, goûter à la simplicité', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (21, 3, 'Présentation', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (22, 4, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (23, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (24, 6, 'Médiathèque', 'Médiathèque', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (25, 7, 'Bas de page', 'Bas de page', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (26, 8, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (27, 9, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (29, 11, 'Gestion de contenu', 'Gestion de contenu', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (30, 12, 'Modules', 'Modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (31, 13, 'Gestion des utilisateurs', 'Les utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (32, 14, 'Gestion des droits', 'Gestion des droits', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (33, 15, 'Modules Actualités, Médiathèque, Formulaires, Alias', 'Les modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (34, 16, 'Fonctions annexes', 'Fonctions annexes', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `pagesBaseData_public`
-- 

DROP TABLE IF EXISTS `pagesBaseData_public`;
CREATE TABLE `pagesBaseData_public` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pbd`),
  KEY `id_pbd` (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `pagesBaseData_public`
-- 

INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (1, 1, 'Démo Automne', 'Démo Automne', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '1|2|||_top|||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (20, 2, 'Automne version 4, goûter à la simplicité', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (21, 3, 'Présentation', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (22, 4, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (23, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (24, 6, 'Médiathèque', 'Médiathèque', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (25, 7, 'Bas de page', 'Bas de page', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (26, 8, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (27, 9, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (29, 11, 'Gestion de contenu', 'Gestion de contenu', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (30, 12, 'Modules', 'Modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (31, 13, 'Gestion des utilisateurs', 'Les utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (32, 14, 'Gestion des droits', 'Gestion des droits', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (33, 15, 'Modules Actualités, Médiathèque, Formulaires, Alias', 'Les modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`) VALUES (34, 16, 'Fonctions annexes', 'Fonctions annexes', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '');

-- --------------------------------------------------------

-- 
-- Structure de la table `profileUsersByGroup`
-- 

DROP TABLE IF EXISTS `profileUsersByGroup`;
CREATE TABLE `profileUsersByGroup` (
  `id_gu` int(11) NOT NULL auto_increment,
  `groupId_gu` int(11) NOT NULL default '0',
  `userId_gu` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_gu`),
  KEY `groupId_gu` (`groupId_gu`),
  KEY `userId_gu` (`userId_gu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `profileUsersByGroup`
-- 

INSERT INTO `profileUsersByGroup` (`id_gu`, `groupId_gu`, `userId_gu`) VALUES (2, 1, 4);
INSERT INTO `profileUsersByGroup` (`id_gu`, `groupId_gu`, `userId_gu`) VALUES (3, 2, 8);
INSERT INTO `profileUsersByGroup` (`id_gu`, `groupId_gu`, `userId_gu`) VALUES (4, 2, 6);
INSERT INTO `profileUsersByGroup` (`id_gu`, `groupId_gu`, `userId_gu`) VALUES (5, 2, 7);
INSERT INTO `profileUsersByGroup` (`id_gu`, `groupId_gu`, `userId_gu`) VALUES (6, 2, 5);

-- --------------------------------------------------------

-- 
-- Structure de la table `profiles`
-- 

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id_pr` int(11) unsigned NOT NULL auto_increment,
  `templateGroupsDeniedStack_pr` varchar(255) NOT NULL default '',
  `rowGroupsDeniedStack_pr` varchar(255) NOT NULL default '',
  `pageClearancesStack_pr` text NOT NULL,
  `moduleClearancesStack_pr` varchar(255) NOT NULL default '',
  `validationClearancesStack_pr` varchar(255) NOT NULL default '',
  `administrationClearance_pr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_pr`),
  KEY `id_pr` (`id_pr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `profiles`
-- 

INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (1, '', '', '1,2', 'standard,2;cms_aliases,2;pnews,2;cms_forms,2;ppictures,2', 'standard', 319);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (3, 'fr;en', '', '1,1', '', '', 0);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (4, '', '', '1,2', 'pnews,2;cms_aliases,2;cms_forms,2;standard,2;pdocs,2;ppictures,2', '', 319);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (5, 'fr', '', '1,2', 'pnews,2;cms_aliases,2;cms_forms,2;standard,2;pdocs,2;ppictures,2', '', 319);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (6, '', '', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (7, '', '', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (8, '', '', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (9, '', '', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES (10, '', 'admin', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `profilesUsers`
-- 

DROP TABLE IF EXISTS `profilesUsers`;
CREATE TABLE `profilesUsers` (
  `id_pru` int(11) unsigned NOT NULL auto_increment,
  `login_pru` varchar(50) NOT NULL default '',
  `password_pru` varchar(32) NOT NULL default '',
  `firstName_pru` varchar(50) NOT NULL default '',
  `lastName_pru` varchar(50) NOT NULL default '',
  `contactData_pru` int(11) unsigned NOT NULL default '0',
  `profile_pru` int(11) unsigned NOT NULL default '0',
  `language_pru` varchar(16) NOT NULL default 'fr',
  `dn_pru` varchar(255) NOT NULL default '',
  `active_pru` tinyint(4) NOT NULL default '0',
  `deleted_pru` tinyint(4) unsigned NOT NULL default '0',
  `alerts_pru` text NOT NULL,
  `favorites_pru` text NOT NULL,
  PRIMARY KEY  (`id_pru`),
  KEY `id_pru` (`id_pru`),
  KEY `ldapDN_pru` (`dn_pru`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `profilesUsers`
-- 

INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (1, 'root', '3b0d99b9bb927794036aa828050f364d', '', 'Super administrateur', 1, 1, 'fr', '', 1, 0, 'standard,7', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (3, 'anonymous', '294de3557d9d00b3d2d8a1e6aab028cf', '', 'Public user', 3, 3, 'fr', '', 1, 0, 'standard,7', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (4, 'thierry', 'c8bc8f21fc80f7f0965b8db7d425e9fb', 'Thierry', 'Bernier', 4, 5, 'fr', '', 1, 0, 'standard,7', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (5, 'DirtyF', '5c8fc78d09d28a6dc5581df279d13073', 'Frank', 'Taillandier', 5, 6, 'fr', '', 1, 0, '', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (6, 'Chrys', 'e2f589caa6257c438c0763a649273d65', 'Wilfrid', 'Leflon', 6, 7, 'fr', '', 1, 0, '', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (7, 'Damien', '25a351b9e65b3a25490201d92a5a81fa', 'Damien', 'Marcoul', 7, 8, 'fr', '', 1, 0, '', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES (8, 'DULIBEAUD', '701e2c87ac7020512951727fd4cada4a', 'Marc', 'Dulibeaud', 8, 9, 'fr', '', 1, 0, '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `profilesUsersGroups`
-- 

DROP TABLE IF EXISTS `profilesUsersGroups`;
CREATE TABLE `profilesUsersGroups` (
  `id_prg` int(11) unsigned NOT NULL auto_increment,
  `description_prg` mediumtext NOT NULL,
  `label_prg` varchar(50) NOT NULL default '',
  `profile_prg` int(11) unsigned NOT NULL default '0',
  `dn_prg` varchar(255) NOT NULL default '',
  `invertdn_prg` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_prg`),
  KEY `id_prg` (`id_prg`),
  KEY `ldapDN_prg` (`dn_prg`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `profilesUsersGroups`
-- 

INSERT INTO `profilesUsersGroups` (`id_prg`, `description_prg`, `label_prg`, `profile_prg`, `dn_prg`, `invertdn_prg`) VALUES (1, 'Groupe des administrateurs du site', 'Administrateurs', 4, '', 0);
INSERT INTO `profilesUsersGroups` (`id_prg`, `description_prg`, `label_prg`, `profile_prg`, `dn_prg`, `invertdn_prg`) VALUES (2, 'Groupes des rédacteurs pour le contenu du site.', 'Rédacteurs', 10, '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `profilesUsers_validators`
-- 

DROP TABLE IF EXISTS `profilesUsers_validators`;
CREATE TABLE `profilesUsers_validators` (
  `id_puv` int(11) NOT NULL auto_increment,
  `userId_puv` int(11) unsigned NOT NULL default '0',
  `module_puv` varchar(100) default NULL,
  PRIMARY KEY  (`id_puv`),
  KEY `id_puv` (`id_puv`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `profilesUsers_validators`
-- 

INSERT INTO `profilesUsers_validators` (`id_puv`, `userId_puv`, `module_puv`) VALUES (1, 1, 'standard');

-- --------------------------------------------------------

-- 
-- Structure de la table `regenerator`
-- 

DROP TABLE IF EXISTS `regenerator`;
CREATE TABLE `regenerator` (
  `id_reg` int(11) unsigned NOT NULL auto_increment,
  `module_reg` varchar(255) NOT NULL default '0',
  `parameters_reg` text NOT NULL,
  PRIMARY KEY  (`id_reg`),
  KEY `page_reg` (`id_reg`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `regenerator`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `resourceStatuses`
-- 

DROP TABLE IF EXISTS `resourceStatuses`;
CREATE TABLE `resourceStatuses` (
  `id_rs` int(11) unsigned NOT NULL auto_increment,
  `location_rs` tinyint(4) unsigned NOT NULL default '1',
  `proposedFor_rs` tinyint(4) unsigned NOT NULL default '0',
  `editions_rs` tinyint(4) unsigned NOT NULL default '0',
  `validationsRefused_rs` tinyint(4) unsigned NOT NULL default '0',
  `publication_rs` tinyint(4) unsigned NOT NULL default '0',
  `publicationDateStart_rs` date NOT NULL default '0000-00-00',
  `publicationDateEnd_rs` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_rs`),
  KEY `id_rs` (`id_rs`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `resourceStatuses`
-- 

INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (1, 1, 0, 0, 0, 2, '2008-10-31', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (40, 1, 0, 0, 0, 2, '2008-10-31', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (41, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (42, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (43, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (44, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (45, 1, 0, 0, 0, 1, '2008-11-03', '2008-11-02');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (46, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (47, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (48, 3, 0, 0, 0, 2, '2008-11-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (49, 1, 0, 0, 0, 2, '2008-11-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (50, 3, 0, 2, 0, 2, '2008-11-07', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (51, 3, 0, 2, 0, 2, '2008-11-07', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (52, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (53, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (54, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (55, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (56, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (57, 1, 0, 0, 0, 2, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (58, 3, 0, 1, 0, 0, '2008-11-14', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (59, 3, 0, 0, 0, 2, '2008-11-14', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (60, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (61, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (62, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (63, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (64, 3, 0, 2, 0, 2, '2008-11-21', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (65, 3, 0, 3, 0, 0, '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (66, 3, 0, 2, 0, 2, '2008-11-28', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (67, 3, 0, 2, 0, 2, '2008-11-28', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`) VALUES (68, 3, 0, 2, 0, 2, '2008-11-28', '0000-00-00');

-- --------------------------------------------------------

-- 
-- Structure de la table `resourceValidations`
-- 

DROP TABLE IF EXISTS `resourceValidations`;
CREATE TABLE `resourceValidations` (
  `id_rv` int(11) unsigned NOT NULL auto_increment,
  `module_rv` varchar(100) NOT NULL default '',
  `editions_rv` int(11) unsigned NOT NULL default '0',
  `resourceID_rv` int(11) unsigned NOT NULL default '0',
  `serializedObject_rv` mediumtext NOT NULL,
  `creationDate_rv` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id_rv`),
  KEY `id_rv` (`id_rv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `resourceValidations`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `resources`
-- 

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `id_res` int(11) unsigned NOT NULL auto_increment,
  `status_res` int(11) unsigned NOT NULL default '0',
  `editorsStack_res` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_res`),
  KEY `id_res` (`id_res`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `resources`
-- 

INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (1, 1, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (40, 40, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (41, 41, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (42, 42, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (43, 43, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (44, 44, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (45, 45, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (46, 46, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (47, 47, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (48, 48, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (49, 49, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (50, 50, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (51, 51, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (52, 52, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (53, 53, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (54, 54, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (55, 55, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (56, 56, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (57, 57, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (58, 58, '1,1');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (59, 59, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (60, 60, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (61, 61, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (62, 62, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (63, 63, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (64, 64, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (65, 65, '1,2;1,1');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (66, 66, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (67, 67, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (68, 68, '1,2');

-- --------------------------------------------------------

-- 
-- Structure de la table `scriptsStatuses`
-- 

DROP TABLE IF EXISTS `scriptsStatuses`;
CREATE TABLE `scriptsStatuses` (
  `scriptName_ss` varchar(255) NOT NULL default '',
  `launchDate_ss` datetime default NULL,
  `pidFileName_ss` varchar(255) NOT NULL default '',
  `module_ss` varchar(255) NOT NULL default '',
  `parameters_ss` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `scriptsStatuses`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `sessions`
-- 

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id_ses` int(11) unsigned NOT NULL auto_increment,
  `phpid_ses` varchar(75) NOT NULL default '',
  `lastTouch_ses` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_ses` int(11) unsigned NOT NULL default '0',
  `remote_addr_ses` varchar(64) NOT NULL,
  `http_user_agent_ses` varchar(255) NOT NULL default '',
  `cookie_expire_ses` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_ses`),
  KEY `id_ses` (`id_ses`),
  KEY `lastTouch_ses` (`lastTouch_ses`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `sessions`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `toolbars`
-- 

DROP TABLE IF EXISTS `toolbars`;
CREATE TABLE `toolbars` (
  `id_tool` int(11) unsigned NOT NULL auto_increment,
  `code_tool` varchar(20) NOT NULL default '',
  `label_tool` varchar(255) NOT NULL default '',
  `elements_tool` text NOT NULL,
  PRIMARY KEY  (`id_tool`),
  KEY `code_tool` (`code_tool`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `toolbars`
-- 

INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES (1, 'Default', 'Default', 'Source|Separator1|FitWindow|Separator2|Preview|Templates|Separator3|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Print|Separator5|Undo|Redo|Separator6|Find|Replace|Separator7|SelectAll|RemoveFormat|Separator8|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator15|Style|FontFormat|FontSize|Separator16|TextColor|BGColor|Separator17|automneLinks|polymod|Image');
INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES (2, 'Basic', 'Basic', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Table|Rule|SpecialChar|Separator1');
INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES (3, 'BasicLink', 'BasicLink', 'Source|Separator1|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator16|automneLinks|polymod');

-- --------------------------------------------------------

-- 
-- Structure de la table `websites`
-- 

DROP TABLE IF EXISTS `websites`;
CREATE TABLE `websites` (
  `id_web` int(11) unsigned NOT NULL auto_increment,
  `label_web` varchar(255) NOT NULL default '',
  `url_web` varchar(255) NOT NULL default '',
  `root_web` int(11) unsigned NOT NULL default '0',
  `keywords_web` mediumtext NOT NULL,
  `description_web` mediumtext NOT NULL,
  `category_web` varchar(255) NOT NULL default '',
  `author_web` varchar(255) NOT NULL default '',
  `replyto_web` varchar(255) NOT NULL default '',
  `copyright_web` varchar(255) NOT NULL default '',
  `language_web` varchar(255) NOT NULL default '',
  `robots_web` varchar(255) NOT NULL default '',
  `favicon_web` varchar(255) NOT NULL default '',
  `order_web` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_web`),
  KEY `id_web` (`id_web`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `websites`
-- 

INSERT INTO `websites` (`id_web`, `label_web`, `url_web`, `root_web`, `keywords_web`, `description_web`, `category_web`, `author_web`, `replyto_web`, `copyright_web`, `language_web`, `robots_web`, `favicon_web`, `order_web`) VALUES (1, 'Site principal', 'localhost', 1, '', '', '', '', '', '', 'fr', '', '/favicon.ico', 1);
INSERT INTO `websites` (`id_web`, `label_web`, `url_web`, `root_web`, `keywords_web`, `description_web`, `category_web`, `author_web`, `replyto_web`, `copyright_web`, `language_web`, `robots_web`, `favicon_web`, `order_web`) VALUES (2, 'fr', 'localhost', 2, '', '', '', '', '', '', 'fr', '', '/favicon.ico', 2);
