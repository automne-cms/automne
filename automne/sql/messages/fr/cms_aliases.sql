#----------------------------------------------------------------
#
# Messages content for module cms_aliases
# French Messages
#
#----------------------------------------------------------------
# $Id: cms_aliases.sql,v 1.2 2010/02/03 16:53:49 sebastien Exp $

DELETE FROM messages WHERE module_mes = 'cms_aliases' and language_mes = 'fr';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_aliases', 'fr', 'Alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_aliases', 'fr', 'Chemin de l''alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(3, 'cms_aliases', 'fr', 'Cible');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(4, 'cms_aliases', 'fr', 'Sous-alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(5, 'cms_aliases', 'fr', 'Confirmer la suppression de l''alias ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(6, 'cms_aliases', 'fr', 'Parent');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(7, 'cms_aliases', 'fr', 'Création / modification d''alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(8, 'cms_aliases', 'fr', '[Erreur : Impossible de créer l''alias, un dossier portant ce nom existe déjà  !]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(9, 'cms_aliases', 'fr', '[Erreur durant la suppression de l\'alias ...]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(10, 'cms_aliases', 'fr', 'Nom de votre alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(11, 'cms_aliases', 'fr', 'Libellé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(12, 'cms_aliases', 'fr', 'Redirection');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(13, 'cms_aliases', 'fr', 'Choisissez la destination de l\'alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(14, 'cms_aliases', 'fr', 'Sites');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(15, 'cms_aliases', 'fr', 'Choisissez les domaines pour lesquels l\'alias s\'applique. Si aucun domaine n\'est sélectionné, tous les domaine gérés dans les sites Automne utiliseront cet alias. Il est déconseillé de remplir ce champ si vous n\'employez pas le multi-site dans Automne.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(16, 'cms_aliases', 'fr', 'Remplacer l\'adresse');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(17, 'cms_aliases', 'fr', 'Remplacer l\'adresse de la page sélectionnée par l\'adresse de l\'alias ?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(18, 'cms_aliases', 'fr', 'Si vous cochez cette case, l\'adresse de la page sélectionnée sera replacée par l\'adresse de cet alias. Une page ne peut avoir qu\'un seul alias possédant cette propriété cochée.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(19, 'cms_aliases', 'fr', 'Redirection définitive');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(20, 'cms_aliases', 'fr', 'Cet alias doit il retourner un code HTTP de redirection définitive (301) ?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(21, 'cms_aliases', 'fr', 'Si vous cochez cette case, la redirection effectuée sera de type 301, c\'est à dire que l\'adresse de cet alias ne sera pas indexée par les moteurs de recherche. Seule l\'adresse de la page de destination sera indexée.<br />Si vous ne cochez pas cette case, la redirection sera de type 302 : elle sera considérée comme temporaire par les moteurs de recherche qui indexeront aussi l\'adresse de l\'alias dans leur base.<br />Si vous ne savez pas quoi choisir, cochez la case pour éviter les problèmatiques liées au référencement de votre site.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(22, 'cms_aliases', 'fr', 'Alias protégé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(23, 'cms_aliases', 'fr', 'Un alias protégé ne peut plus être modifié, déplacé, supprimé excepté par un administrateur.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(24, 'cms_aliases', 'fr', 'Si un alias est protégé, il n\'est plus possible d\'en modifier les propriétés ni la position dans l\'arborescence. Seul un administrateur à la possibilité d\'enlever la protection sur un alias. Il est ensuite possible d\'en modifier les propriétés ou la position. Utilisez la protection pour éviter qu\'un alias important de votre site ne puisse être modifié par inadvertance.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(25, 'cms_aliases', 'fr', 'Redirige vers :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(26, 'cms_aliases', 'fr', 'Gestion des alias de vos sites. Un alias est une adresse de redirection vers une page ou une URL externe.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(27, 'cms_aliases', 'fr', 'Racine du site :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(28, 'cms_aliases', 'fr', 'Confirmez vous la suppression de l\'alias :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(29, 'cms_aliases', 'fr', 'Sur cette page, vous pouvez gérez un alias et ses propriétés. Passez votre souris sur chacun des champs pour obtenir de l\'aide sur leur usage.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(30, 'cms_aliases', 'fr', 'Vous devez sélectionner une redirection vers une Page (Lien Interne) dans le champ Redirection ci-dessus pour pouvoir cocher cette option.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(31, 'cms_aliases', 'fr', 'Cet alias est valable pour tous les sites.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(32, 'cms_aliases', 'fr', 'Alias restreint :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(33, 'cms_aliases', 'fr', 'Cet alias n\'est valable que pour les sites suivants :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(34, 'cms_aliases', 'fr', 'Alias :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(35, 'cms_aliases', 'fr', 'Vous ne pouvez employer ce libellé pour votre alias, le répertoire existe déjà ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(36, 'cms_aliases', 'fr', 'La redirection spécifiée est incorrecte ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(37, 'cms_aliases', 'fr', 'Erreur sur la page de destination de la redirection ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(38, 'cms_aliases', 'fr', 'Erreur durant la modification : l\'alias est protégé et ne peut être modifié.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(39, 'cms_aliases', 'fr', 'Gestion des alias de la page. L\'alias en rouge remplace l\'adresse de la page.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(40, 'cms_aliases', 'fr', 'Remplace l\'adresse :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(41, 'cms_aliases', 'fr', 'Erreur : La page %s possède déjà un alias qui remplace son adresse ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(42, 'cms_aliases', 'fr', 'L\'ALIAS A UNE ERREUR.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(43, 'cms_aliases', 'fr', 'Restreindre aux domaines');
