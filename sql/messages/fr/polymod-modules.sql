#----------------------------------------------------------------
#
# Messages content for polymod modules pmedia and pnews
# French Messages
#
#----------------------------------------------------------------
# $Id: polymod-modules.sql,v 1.1 2010/01/18 17:29:42 sebastien Exp $

DELETE FROM messages WHERE (module_mes = 'pmedia' or module_mes = 'pnews') and language_mes = 'fr';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'pmedia', 'fr', 'Médiathèque');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'pnews', 'fr', 'Actualités');