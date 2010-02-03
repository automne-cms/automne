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