#----------------------------------------------------------------
#
# Messages content for module cms_aliases
# English Messages
#
#----------------------------------------------------------------
# $Id: cms_aliases.sql,v 1.1 2010/01/18 17:29:43 sebastien Exp $

DELETE FROM messages WHERE module_mes = 'cms_aliases' and language_mes = 'en';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_aliases', 'en', 'Aliases ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_aliases', 'en', 'Alias path');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(3, 'cms_aliases', 'en', 'Target');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(4, 'cms_aliases', 'en', 'Sub-aliases');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(5, 'cms_aliases', 'en', 'Do you confirm deletion of the alias ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(6, 'cms_aliases', 'en', 'Parent');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(7, 'cms_aliases', 'en', 'Alias creation / modification');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(8, 'cms_aliases', 'en', '[Error: Impossible to create this alias, a folder with this name already exists!]');