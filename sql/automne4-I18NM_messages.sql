# $Id: automne4-I18NM_messages.sql,v 1.16 2009/06/24 10:06:55 sebastien Exp $
#
# Suppression avant mise à  jour du Contenu de la table `I18NM_messages` pour le module standard
#

DELETE FROM I18NM_messages WHERE module='standard';

#
# Contenu de la table `I18NM_messages` pour le module standard
#

INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1, 'standard', NOW(), 'Aucun droit', 'No rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (2, 'standard', NOW(), 'Site', 'Site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (3, 'standard', NOW(), 'Admin', 'Admin');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (4, 'standard', NOW(), 'Jamais validé', 'Never validated');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (5, 'standard', NOW(), 'Validé non public', 'Validated not public');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (6, 'standard', NOW(), 'Public', 'Public');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (7, 'standard', NOW(), 'Propriétés', 'Properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (8, 'standard', NOW(), 'Contenu', 'Content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (9, 'standard', NOW(), 'Ordre des pages', 'Order of pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (10, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (11, 'standard', NOW(), 'Site', 'Site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (12, 'standard', NOW(), 'Admin', 'Admin');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (13, 'standard', NOW(), 'Utilisable', 'Useable');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (14, 'standard', NOW(), 'Archivé', 'Archived');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (15, 'standard', NOW(), 'Supprimé', 'Deleted');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (16, 'standard', NOW(), 'Administrateur', 'Super Administrator');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (17, 'standard', NOW(), 'Régénérer les pages', 'Advanced Administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (18, 'standard', NOW(), 'Gestion des rangées', 'Style-rows Administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (19, 'standard', NOW(), 'Gestion des modèles', 'Template Administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (20, 'standard', NOW(), 'Journal des actions', 'Action Log Administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (21, 'standard', NOW(), 'Validations', 'Validations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (22, 'standard', NOW(), 'Modification de votre profil', 'Profile modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (23, 'standard', NOW(), 'Alertes sur les pages', 'Pages alerts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (24, 'standard', NOW(), 'Modifier', 'Modify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (25, 'standard', NOW(), 'Retour', 'Back');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (26, 'standard', NOW(), 'Sommaire', 'Home');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (27, 'standard', NOW(), 'Profils', 'Users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (28, 'standard', NOW(), 'Arborescence', 'Tree');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (29, 'standard', NOW(), 'Journal', 'Log');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (30, 'standard', NOW(), 'Modèles', 'Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (31, 'standard', NOW(), 'Meta', 'Advanced');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (32, 'standard', NOW(), 'Quitter', 'Disconnect');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (33, 'standard', NOW(), 'le', 'the');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (34, 'standard', NOW(), 'Connecté :', 'Connected as:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (35, 'standard', NOW(), 'French', 'English');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (36, 'standard', NOW(), 'm/d/y', 'm/d/y');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (37, 'standard', NOW(), '[Session perdue]', '[Session expired]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (38, 'standard', NOW(), 'Acceptation', 'Approval');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (39, 'standard', NOW(), 'Refus', 'Refusal');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (40, 'standard', NOW(), 'Transfert', 'Transfer');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (41, 'standard', NOW(), 'Emplacement (suppression / archivage)', 'Location (deletion/archiving)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (42, 'standard', NOW(), 'Suppression / archivage', 'Deletion / archiving of page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (43, 'standard', NOW(), 'Suppression / archivage de la page :', 'Deletion / archiving of the page :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (44, 'standard', NOW(), 'Création / modification de page', 'Creation / modification of page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (45, 'standard', NOW(), 'Création / modification de la page :', 'Creation / modification of the page :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (46, 'standard', NOW(), 'Ordre des pages', 'Order of pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (47, 'standard', NOW(), 'Modification de l\'ordre des sous pages de la page :', 'Modification of sub pages order for the page :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (48, 'standard', NOW(), 'Prévisualiser la page', 'Preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (49, 'standard', NOW(), 'Page en ligne', 'On line');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (50, 'standard', NOW(), 'Erreur d\'identification, veuillez réessayer ...', 'Login error, please try again...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (51, 'standard', NOW(), 'Bienvenue sur %s', 'Welcome to %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (52, 'standard', NOW(), 'Identification', 'Please enter your access codes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (53, 'standard', NOW(), 'Langue', 'Language');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (54, 'standard', NOW(), 'Identifiant', 'Identification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (55, 'standard', NOW(), 'Mot de passe', 'Password');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (56, 'standard', NOW(), 'Valider', 'Validate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (57, 'standard', NOW(), 'Sommaire', 'Home');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (58, 'standard', NOW(), 'Sommaire', 'Home');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (60, 'standard', NOW(), 'Validations en attente', 'Validations pending');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (62, 'standard', NOW(), 'Pages', 'Your web pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (63, 'standard', NOW(), 'Choisir une page', 'Select a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (64, 'standard', NOW(), 'Gestion de contenu', 'Content management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (65, 'standard', NOW(), '[Droits insuffisants pour accéder à  cette page]', '[Error, you do not have sufficiant rights to view this page]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (66, 'standard', NOW(), 'Page inconnue', 'Page unknown');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (67, 'standard', NOW(), 'Profils', 'Users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (68, 'standard', NOW(), 'Profil utilisateur', 'User Profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (69, 'standard', NOW(), 'au', 'to');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (70, 'standard', NOW(), 'ID', 'ID');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (71, 'standard', NOW(), 'Publication', 'Publication');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (72, 'standard', NOW(), 'Modèle', 'Template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (73, 'standard', NOW(), 'Profils utilisateurs', 'User profiles');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (74, 'standard', NOW(), 'Profil de groupe', 'Group profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (75, 'standard', NOW(), 'Profils de groupes', 'Group profiles');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (76, 'standard', NOW(), 'Utilisateurs du groupe', 'Users in group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (77, 'standard', NOW(), 'Gestion des utilisateurs', 'Users administration ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (78, 'standard', NOW(), 'Page', 'View page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (79, 'standard', NOW(), 'Aperçu de la page', 'Page preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (80, 'standard', NOW(), 'Voir en ligne', 'On line');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (81, 'standard', NOW(), 'Autres', 'Other');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (82, 'standard', NOW(), 'Déverrouiller', 'Unlock');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (83, 'standard', NOW(), 'Archiver la page', 'Archive page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (84, 'standard', NOW(), 'Supprimer la page', 'Delete page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (85, 'standard', NOW(), 'Annuler la suppression', 'Undo deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (86, 'standard', NOW(), 'Annuler l\'archivage', 'Undo archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (87, 'standard', NOW(), 'Modifier', 'Modify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (88, 'standard', NOW(), 'Modifier les propriétés', 'Modify properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (89, 'standard', NOW(), 'Modifier le contenu de la page', 'Modify page content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (90, 'standard', NOW(), 'Créer', 'Create');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (91, 'standard', NOW(), 'Créer une page', 'Create new page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (92, 'standard', NOW(), 'Déplacer la page', 'Move page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (93, 'standard', NOW(), 'Prénom', 'First name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (94, 'standard', NOW(), 'Nom', 'Last name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (95, 'standard', NOW(), 'Confirmer mot de passe', 'Confirm Password');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (96, 'standard', NOW(), 'Langue', 'Language');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (97, 'standard', NOW(), 'Rétablir la page "%s" ?', 'Confirm undo deletion of page "%s" ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (98, 'standard', NOW(), 'Sortir d\'archive la page "%s" ?', 'Confirm undo archiving of page "%s" ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (99, 'standard', NOW(), 'Coordonnées', 'Contact Information');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (100, 'standard', NOW(), 'Déplacer la page : choisir la destination', 'Move page: choose the destination');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (101, 'standard', NOW(), 'Sélectionner la page de destination de la page %s', 'Select the page destination for the page %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (102, 'standard', NOW(), 'Email', 'Email');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (103, 'standard', NOW(), 'Service', 'Service');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (104, 'standard', NOW(), 'Adresse', 'Address');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (105, 'standard', NOW(), 'Code Postal', 'Zip Code');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (106, 'standard', NOW(), 'Ville', 'City');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (107, 'standard', NOW(), 'Région', 'State');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (108, 'standard', NOW(), 'Pays', 'Country');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (109, 'standard', NOW(), 'Téléphone', 'Phone');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (110, 'standard', NOW(), 'Portable', 'Cell Phone');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (111, 'standard', NOW(), 'Fax', 'Fax');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (112, 'standard', NOW(), 'Fonction', 'Job Title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (113, 'standard', NOW(), 'Droits de consultation', 'Viewing rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (114, 'standard', NOW(), 'Cet utilisateur a tous les droits sur l\'application. Il n\'est donc pas possible de gérer ses droits par section. Cependant il est possible d\'ajouter ou de supprimer des sections dans l\'éventualité oà¹ il perdrait ses droits d\'origine.', 'This user has total application access. It is not possible to administer his or her viewing and editing rights. To administrate the user\'s rights the current status must be modified.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (115, 'standard', NOW(), 'Droits d\'administration', 'Administration Rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (118, 'standard', NOW(), 'Confirmer la suppression de la page \'%s\' ?', 'Confirm deletion request for page \'%s\' ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (119, 'standard', NOW(), 'Confirmer l\'archivage de la page \'%s\' ?', 'Do you confirm asking for archiving of the page \'%s\' ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (120, 'standard', NOW(), 'Votre profil', 'Your profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (121, 'standard', NOW(), '[Erreur lors de la suppression]', '[Error while deleting page]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (122, 'standard', NOW(), 'Opération effectuée', 'Action completed');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (123, 'standard', NOW(), 'Suppression de page', 'Page deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (124, 'standard', NOW(), 'Validation en attente :\r\n', 'The following task needs validation:\r\n');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (125, 'standard', NOW(), 'Suppression de la page "%s" par l\'utilisateur %s', 'Deletion of page "%s" by user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (126, 'standard', NOW(), '[Erreur lors du rétablissement]', '[Error while trying to undo deletion of the page)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (127, 'standard', NOW(), 'Archivage de page', 'Page archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (128, 'standard', NOW(), 'Archivage de la page "%s" par l\'utilisateur %s', 'Archivage of page "%s" by user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (129, 'standard', NOW(), 'Propriétés de la page', 'Page properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (130, 'standard', NOW(), 'Création de page - étape %s/3', 'Page creation step %s/3');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (131, 'standard', NOW(), '<span class="admin_text_alert">*</span> Champ obligatoire', '<span class="admin_text_alert">*</span> Required');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (132, 'standard', NOW(), 'Titre', 'Title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (133, 'standard', NOW(), 'Lien', 'Link name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (134, 'standard', NOW(), 'Début de publication', 'Publication start');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (135, 'standard', NOW(), 'Fin de publication', 'Publication end');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (136, 'standard', NOW(), 'Délai d\'alerte', 'Alert delay');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (137, 'standard', NOW(), 'Date d\'alerte', 'Alert date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (138, 'standard', NOW(), 'Message d\'alerte', 'Alert message');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (139, 'standard', NOW(), 'Description', 'Description');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (140, 'standard', NOW(), 'Mots clés', 'Keywords');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (141, 'standard', NOW(), 'jj', 'dd');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (142, 'standard', NOW(), 'mm', 'mm');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (143, 'standard', NOW(), 'aaaa', 'yyyy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (144, 'standard', NOW(), '[Tous les champs obligatoires ne sont pas renseignés]', '[Please enter required information]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (145, 'standard', NOW(), 'Format incorrect pour le champ : %s', 'Incorrect value entered for: %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (146, 'standard', NOW(), '[L\'identifiant "%s" existe déjà ]', '[Sorry, the user name "%s" is unavailable]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (147, 'standard', NOW(), 'Lien', 'Link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (148, 'standard', NOW(), 'Format %s', 'format %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (149, 'standard', NOW(), 'Moteurs de recherche', 'for search engines');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (150, 'standard', NOW(), 'en jours, 0 pour jamais', 'in number of days, 0 for never');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (152, 'standard', NOW(), 'Nouvel utilisateur', 'New user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (153, 'standard', NOW(), '[Autorisation insuffisante]', 'Clearance insufficient.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (154, 'standard', NOW(), 'Page verrouillée', 'The page is locked.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (155, 'standard', NOW(), 'Désactiver', 'Disactivate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (156, 'standard', NOW(), 'Activer', 'Activate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (157, 'standard', NOW(), 'de', 'of');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (158, 'standard', NOW(), '[Erreur lors du déplacement de page]', '[Error while moving the page]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (159, 'standard', NOW(), 'Créer une page', 'Create a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (160, 'standard', NOW(), 'Statut', 'Status');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (161, 'standard', NOW(), 'Titre', 'Title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (162, 'standard', NOW(), 'Actions', 'Actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (163, 'standard', NOW(), 'Sous-pages', 'Sub pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (164, 'standard', NOW(), 'Haut', 'Up');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (165, 'standard', NOW(), 'Bas', 'Down');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (166, 'standard', NOW(), 'Erreur lors de la modification de l\'ordre des pages.', 'Error while trying to modify the order of the sub-pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (168, 'standard', NOW(), 'Nouveau groupe', 'New group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (170, 'standard', NOW(), 'Modification de l\'ordre des pages', 'Order of pages modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (171, 'standard', NOW(), 'Modification de l\'ordre des sous-pages de la page \'%s\' par l\'utilisateur %s.', 'Order of sub pages modification for page \'%s\' by user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (172, 'standard', NOW(), 'Modification des propriétés d\'une page', 'Page properties modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (173, 'standard', NOW(), 'Modification des propriétés de la page \'%s\' par l\'utilisateur %s', 'Modification of page properties for page \'%s\' by user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (174, 'standard', NOW(), 'Modification de la page : %s', 'Page modification : %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (175, 'standard', NOW(), '[L\'identifiant de groupe "%s" existe déjà ]', '[Sorry, the group "%s" is unavailable]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (176, 'standard', NOW(), 'Modification du contenu', 'Content modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (177, 'standard', NOW(), 'Contenu', 'Content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (178, 'standard', NOW(), 'Erreur lors de la sauvegarde des données ...', 'Error while saving new content ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (179, 'standard', NOW(), 'Modifier la page', 'Content management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (180, 'standard', NOW(), 'Annuler', 'Cancel');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (181, 'standard', NOW(), 'Actions', 'Actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (182, 'standard', NOW(), 'Modification d\'une page', 'Page content modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (183, 'standard', NOW(), 'L\'utilisateur %s a modifié la page : \'%s\'', 'User %s has changed the content of the following page : \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (184, 'standard', NOW(), '[Les champs "mot de passe" doivent être identiques, supérieur à 4 caractères et différents de l\'identifiant.]', '[Password fields must be the same, have more than 4 characters and not the same of the login]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (185, 'standard', NOW(), 'Choisir un modèle', 'Select a template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (186, 'standard', NOW(), 'Choix du modèle', 'Template selection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (187, 'standard', NOW(), 'Changer de modèle', 'Modify template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (188, 'standard', NOW(), '[Erreur lors du choix du modèle]', '[Error while loading template]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (189, 'standard', NOW(), 'Groupe', 'Group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (190, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (191, 'standard', NOW(), 'Fichier', 'File');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (192, 'standard', NOW(), 'Mettre à  jour<br />(Pour supprimer le fichier, cocher la case et laisser le champ "parcourir" vide).', 'Update<br />(to delete file check box and leave above field empty.)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (193, 'standard', NOW(), 'Alt tag/Légende', 'Alt tag/caption');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (194, 'standard', NOW(), 'Image ', 'Current image');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (195, 'standard', NOW(), 'Aucune', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (196, 'standard', NOW(), '[Erreur lors de l\'upload du fichier]', '[Error while uploading file]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (197, 'standard', NOW(), 'Notification', 'Alert');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (198, 'standard', NOW(), 'Niveau d\'accès', 'Access Level');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (199, 'standard', NOW(), 'Droits sur les groupes de modèles', 'Application group rights.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (200, 'standard', NOW(), 'Fichier joint', 'Uploaded file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (201, 'standard', NOW(), 'Lien', 'Label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (202, 'standard', NOW(), 'Fichier existant', 'Existing file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (203, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (204, 'standard', NOW(), 'Il existe deux niveaux de notification :<br />\r\n>"Courant" : emails pour tout changement dans vos sections. <br /> >"Critique" : emails relatifs à  des dysfonctionnements ou lorsque votre attention est requise (modification de vos droits par exemple).', 'There are two alert levels:<br />\r\n> "All": Sends an email for all modifications within the section<br />\r\n> "Critical": Sends an email only for major changes and alerts critical to the user.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (205, 'standard', NOW(), 'Modification', 'Modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (206, 'standard', NOW(), 'Affichage par lettre', 'Alphabetical search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (207, 'standard', NOW(), 'Affichage par page', 'Complete list search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (208, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (209, 'standard', NOW(), 'Interne', 'Internal');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (210, 'standard', NOW(), 'Externe', 'External');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (211, 'standard', NOW(), 'Validations', 'Validations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (212, 'standard', NOW(), 'Recherche', 'Search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (213, 'standard', NOW(), 'Pages', 'Pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (214, 'standard', NOW(), 'Enlever recherche', 'Remove search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (215, 'standard', NOW(), '[Validations effectuées]', '[Validations approved]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (216, 'standard', NOW(), 'Validation par lot', 'Batch validations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (217, 'standard', NOW(), 'Détail', 'Detail');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (218, 'standard', NOW(), 'Cocher les éléments à valider.', 'Check the boxes of files to validate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (219, 'standard', NOW(), 'Soumettre', 'Submit');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (220, 'standard', NOW(), 'Cocher', 'Check all');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (221, 'standard', NOW(), 'Décocher', 'Uncheck all');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (222, 'standard', NOW(), '[Le %s "%s" n\'a pas été trouvé]', '[Sorry the %s "%s" was not found]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (223, 'standard', NOW(), 'Validation', 'Validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (224, 'standard', NOW(), 'Editeur(s) de la ressource', 'Resource editor(s)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (225, 'standard', NOW(), 'Aide', 'Help');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (226, 'standard', NOW(), 'Accepter', 'Approve');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (227, 'standard', NOW(), 'Refuser', 'Refuse');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (228, 'standard', NOW(), 'Déléguer à  ', 'Delegate to');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (229, 'standard', NOW(), 'Commentaires', 'Comments');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (230, 'standard', NOW(), 'Niveau', 'Level');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (231, 'standard', NOW(), 'Valider', 'Change');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (232, 'standard', NOW(), 'Les modèles et rangées de page appartiennent à un ou plusieurs groupes. Pour utiliser un modèle ou une rangée, un utilisateur doit avoir les droits sur tous ses groupes.', 'Each template or row belong to one or more groups. For a user to be able to use a template or a row, he or she must have usage rights for ALL the groups to which that belongs to.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (233, 'standard', NOW(), 'Cocher le(s) groupe(s) attribué(s).', 'Check the appropriate groups.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (234, 'standard', NOW(), 'Validation', 'Validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (235, 'standard', NOW(), 'Validation :\r\n\r\n%s\r\nModule : %s\r\n\r\nCommentaires :\r\n%s', 'The following validation has been approved:\r\n\r\n%s\r\napplication : %s\r\n\r\nComments :\r\n%s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (236, 'standard', NOW(), 'Refus de validation ', 'Negative validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (237, 'standard', NOW(), 'Refus de validation :\r\n\r\n%s\r\nModule : %s\r\nCommentaire :\r\n%s', 'A negative validation occurred on the following resource (which should therefore be edited before being able to pass validation again) :\r\n\r\n%s\r\nModule : %s\r\nComment :\r\n%s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (238, 'standard', NOW(), '[Validation transférée]', 'Transferred validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (239, 'standard', NOW(), 'Validation transférée :\r\n\r\nAuteur du transfert : %s\r\n%s\r\nModule : %s\r\nCommentaire :\r\n%s', 'The following validation has been transferred to you :\r\n\r\nValidator author of transfer : %s\r\n%s\r\nModule : %s\r\nComment :\r\n%s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (240, 'standard', NOW(), '[Erreur ! L\'élément à valider n\'est pas rattaché à  un module]', '[Error. The item to approve is not attached to a valid application]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (241, 'standard', NOW(), '[Erreur ! Le module n\'a pas correctement procédé à  la validation de sa ressource]', '[Error: the application failed to properly validate the item]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (242, 'standard', NOW(), 'Droits sur le contenu', 'Content Mgmt. Rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (243, 'standard', NOW(), 'Gestion de pages', 'Pages management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (244, 'standard', NOW(), 'Nouvelle section', 'New section');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (245, 'standard', NOW(), 'Création / modification de l\'actualité', 'News item creation / modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (246, 'standard', NOW(), 'Création / modification de l\'actualité : ', 'Creation / modification of news item: ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (247, 'standard', NOW(), 'Gestion des accès aux modules', 'Access management to modules');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (248, 'standard', NOW(), 'Module %s', 'Module %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (249, 'standard', NOW(), 'Accueil administration', 'Administration home');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (250, 'standard', NOW(), 'Rétablir', 'Undelete');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (251, 'standard', NOW(), 'Rétablir', 'Unarchive');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (252, 'standard', NOW(), 'Supprimer', 'Delete');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (253, 'standard', NOW(), 'Archiver', 'Archive');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (254, 'standard', NOW(), 'Confirmer la suppression de l\'actualité \'%s\'', 'Do you confirm deletion of the news \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (255, 'standard', NOW(), 'Confirmer l\'archivage de l\'actualité \'%s\'', 'Do you confirm archiving of the news \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (256, 'standard', NOW(), 'Statut', 'Status');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (257, 'standard', NOW(), 'Titre', 'Title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (258, 'standard', NOW(), 'Publication', 'Publication');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (259, 'standard', NOW(), 'Actions', 'Actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (260, 'standard', NOW(), 'Ajouter', 'Add');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (261, 'standard', NOW(), 'Modifier', 'Edit');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (262, 'standard', NOW(), 'Nouveau', 'New');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (264, 'standard', NOW(), 'Applications', 'Applications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (265, 'standard', NOW(), 'Aucun enregistrement.', 'Empty set.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (266, 'standard', NOW(), 'Aucun droit', 'No rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (267, 'standard', NOW(), 'Droit de consultation coté client', 'Frontend rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (268, 'standard', NOW(), 'Droit d\'administration', 'Backend rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (269, 'standard', NOW(), 'Date de publication sur accueil, début', 'Homepage publication date, start');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (270, 'standard', NOW(), 'Date de publication sur accueil, fin', 'Homepage publication date, end');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (271, 'standard', NOW(), 'Image', 'Image');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (272, 'standard', NOW(), 'Mettre à  jour<br />(Pour supprimer l\'image, cocher la case et laisser le champ "parcourir" vide).', 'Update<br />\r\n(to delete file check box and leave above field empty.)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (273, 'standard', NOW(), 'Texte', 'Text');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (274, 'standard', NOW(), 'Lien', 'Link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (275, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (276, 'standard', NOW(), 'Interne vers la page n°', 'Internal to page (ID)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (277, 'standard', NOW(), 'Externe ', 'External : ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (278, 'standard', NOW(), 'La ressource est verrouillée. Elle est en cours d\'utilisation par un tiers.', 'The page or item is currently being modified by another user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (279, 'standard', NOW(), 'Droits de validation', 'Validation rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (280, 'standard', NOW(), 'Changement du contenu d\'une actualité', 'News content change');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (281, 'standard', NOW(), 'Changement du contenu de l\'actualité : \'%s\'', 'News article content change for article : \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (282, 'standard', NOW(), 'Pages', 'Pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (283, 'standard', NOW(), 'Appliquer a tous les utilisateurs', 'Apply to all users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (284, 'standard', NOW(), 'Confirmer l\'annulation ?', 'Confirm cancellation of modifications?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (285, 'standard', NOW(), 'Editeur texte', 'Text editor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (286, 'standard', NOW(), 'Editeur texte enrichi', 'Richtext editor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (287, 'standard', NOW(), 'Editeur visuel Java (WYSIWYG)', 'Java Visual editor (WYSIWYG)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (288, 'standard', NOW(), 'Gestion du texte', 'Text editor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (289, 'standard', NOW(), 'Vous devez activer Javascript pour voir cette animation.', 'You must activate Javascript to see this animation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (290, 'standard', NOW(), 'Largeur', 'Width');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (291, 'standard', NOW(), 'Hauteur', 'Height');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (292, 'standard', NOW(), 'Paramètre WMODE', 'Param WMODE');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (293, 'standard', NOW(), 'Paramètre SWLIVECONNECT', 'Param SWLIVECONNECT');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (294, 'standard', NOW(), 'Texte long', 'Long text');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (295, 'standard', NOW(), 'Paramètre MENU', 'Param MENU');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (296, 'standard', NOW(), 'Paramètre SCALE', 'Param SCALE');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (297, 'standard', NOW(), 'Paramètre QUALITY', 'Param QUALITY');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (298, 'standard', NOW(), 'Nom d\'identifiant (ID)', 'Name (ID)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (300, 'standard', NOW(), 'Paramètre BGCOLOR', 'Param BGCOLOR');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (301, 'standard', NOW(), 'Erreur ...', 'Error ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (302, 'standard', NOW(), 'Authentification ...', 'Authentification ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (303, 'standard', NOW(), 'Veuillez compléter les champs requis !', 'Please complete required fields!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (304, 'standard', NOW(), 'Vous permet de consultez et naviguer dans l\'arborescences des pages du site.', 'Lets you see and navigate the tree of website pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (305, 'standard', NOW(), 'Vous permet de voir l\'état du contenu de cette page avant sa publication.', 'Lets you see the state of the page content before publication.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (306, 'standard', NOW(), 'L\'onglet est inaccessible car actuellement, la page est publiée et aucun contenu n\'est en attente de validation.', 'The tab is disabled because currently, the page is published and has no content pending validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (307, 'standard', NOW(), 'Vous permet de voir l\'état du contenu en cours de modification pour la page.', 'Lets you see the state of the content modification for the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (308, 'standard', NOW(), 'L\'onglet est inaccessible car actuellement, aucun contenu n\'est en cours de modification pour le page.', 'The tab is disabled because currently, there is no content modification for the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (309, 'standard', NOW(), 'Vous permet de modifier le contenu de cette page ou de continuer les modifications en cours.', 'Lets you change the content of this page or continue the modifications.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (310, 'standard', NOW(), 'L\'onglet est inaccessible car cette page ne peut être modifié directement.', 'The tab is disabled because the content of this page cannot be directly changed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (311, 'standard', NOW(), 'Derniers changements', 'Last changes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (312, 'standard', NOW(), 'Modifié par %s le %s.', 'Modified by %s on %s.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (313, 'standard', NOW(), 'Validé par %s le %s.', 'Validated by %s on %s.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (314, 'standard', NOW(), 'Bienvenue %s !', 'Welcome %s!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (315, 'standard', NOW(), 'Vous avez %s validations en attente.', 'You have %s validations pending.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (316, 'standard', NOW(), 'Vous permet de consulter et modifier les propriétés de la page tel que le titre le modèle et autre méta-données.', 'Lets you see and modify the page properties such as title, template and others meta datas.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (317, 'standard', NOW(), 'L\'onglet est inaccessible car actuellement, la page n\'existe pas coté public du site.', 'The tab is disabled because currently, the page does not exists in the public website.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (318, 'standard', NOW(), 'Pages visibles', 'Visible pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (319, 'standard', NOW(), 'Pages modifiables', 'Editable pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (320, 'standard', NOW(), 'Cette page comporte une redirection vers : %s. Elle ne présente donc pas de contenu visible.', 'This page include a redirect to: %s. It may not show any visible content.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (321, 'standard', NOW(), 'Verrouillé par :', 'Locked by:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (322, 'standard', NOW(), 'Filtrer', 'Filter');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (323, 'standard', NOW(), 'Ce menu vous permet de filtrer l\'affichage des pages selon vos droits. "Pages visibles" affichera toutes les pages visibles et modifiables. "Pages modifiable" n\'affichera que les pages modifiables.', 'This menu allows you to filter the display of pages according to your rights. "Visible pages" display all the pages visible and editable. "Editable pages" display only editable pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (324, 'standard', NOW(), 'Ce champ vous permet de rechercher une page en saisissant directement son identifiant numérique ou en saisissant un texte appartenant à son titre (minimum : 3 caractères). Choisissez ensuite la page que vous souhaitez dans la liste déroulante au fur et à mesure que vous saisissez vos termes de recherche.', 'This field allows you to search for a page directly by entering its ID number or by typing a text belonging to its title (with a minimum of 3 characters). Then select the page you want from the drop down list as you enter your search terms.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (325, 'standard', NOW(), 'Cette fenêtre vous permet de naviger parmis l\'arborescence des pages de votre site. Cliquez sur le nom d\'une page pour sélectionner cette page. Cliquez sur les signes "+" et "-" à gauche des pages pour plier ou déplier l\'arborescence.', 'This window allows you to navigate among the tree of pages of your website. Click on the name of a page to select this page. Click on the "+" and "-" signs left of the pages for folding or unfolding the tree.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (326, 'standard', NOW(), 'Vous permet de rechercher les éléments de votre site par leur nom.', 'Lets you search any elements of your website by name.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (327, 'standard', NOW(), 'Vous permet d\'ajouter une nouvelle page sous la page en cours.', 'Lets you add a new page below the current one.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (328, 'standard', NOW(), 'Actions sur la page.', 'Page actions.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (329, 'standard', NOW(), 'Vous permet de réaliser diverses actions sur la page en cours : supprimer, déplacer, copier, etc.', 'Lets you perform various actions on the current page: delete, move, copy, and so on.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (330, 'standard', NOW(), 'Modifier', 'Edit');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (331, 'standard', NOW(), 'Cliquez pour modifier ce champ', 'Click to edit this field');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (332, 'standard', NOW(), 'Erreur : La date de début ne peut-être supérieure à la date de fin de publication.', 'Error : The starting date can not be higher than the end of publication date.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (333, 'standard', NOW(), 'Erreur : Un problème est survenu lors du traitement ... Vérifez votre contenu.', 'Error : A problem occured during treatment... Please check your content.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (334, 'standard', NOW(), 'Erreur : La page est actuellement vérouillée par l\'utilisateur %s et ne peut être mise à jour.', 'Error : The page is currenlty locked by user %s and cannot be updated.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (335, 'standard', NOW(), 'Recevez un email pour toute validation de page en attente dans vos sections.', 'Receive an email for any pages validation pending in your sections.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (336, 'standard', NOW(), 'Recevez un email lorsque votre profil utilisateur est modifié.', 'Receive an email when your user profile is modified.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (337, 'standard', NOW(), 'Recevez un email lorsqu\'une alerte est spécifié au niveau d\'une page que vous pouvez modifier.', 'Receive an email when an alert is set on a page you can change.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (338, 'standard', NOW(), 'validation(s) en attente', 'validation(s) pending');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (339, 'standard', NOW(), 'Editeurs', 'Editors');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (340, 'standard', NOW(), 'Rafraichir le contenu de cette zone.', 'Refresh zone content.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (341, 'standard', NOW(), 'Déverrouiller la page verrouillée par %s', 'Unlock page locked by %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (342, 'standard', NOW(), 'Création d\'une nouvelle page', 'Creating a new page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (343, 'standard', NOW(), 'Cette fenêtre vous permet de créer une nouvelle page sous la page en actuelle. Donnez un nom à cette nouvelle page ainsi que le nom des liens qui pointeront vers cette page. Puis choisissez le modèle à utiliser.', 'This window allows you to create a new page under the actual one. Give a name to this new page and links name which will link to this page. Then choose a template.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (344, 'standard', NOW(), 'Nom', 'Name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (345, 'standard', NOW(), 'Vous n\'avez aucun modèle disponible ...', 'You don\'t have any available template...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (346, 'standard', NOW(), 'Titre de la page', 'Page title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (347, 'standard', NOW(), 'Titre du lien', 'Link title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (348, 'standard', NOW(), 'Choisissez le modèle à utiliser pour la nouvelle page :', 'Choose new page template:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (349, 'standard', NOW(), 'Vous n\'avez pas renseigné toutes les informations requises', 'You have not filled all the required informations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (350, 'standard', NOW(), 'Cette fenêtre vous permet de copier la page et son contenu à un autre point de l\'arborescence des pages du site. Vous pouvez aussi changer le modèle utilisé et choisir de ne pas copier le contenu mais uniquement sa structure.', 'This window allows you to copy the page and its contents under another page on the site\'s tree pages. You can also change the template used and choose not to copy the content but only its structure.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (351, 'standard', NOW(), 'Copier le contenu de la page', 'Copy page content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (352, 'standard', NOW(), 'Remplacer le modèle de la page par', 'Replace page template by');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (353, 'standard', NOW(), 'Modèle compatible', 'Matching template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (354, 'standard', NOW(), 'Modèle incompatible', 'Unmatching template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (355, 'standard', NOW(), 'Sélectionnez la page à utiliser comme mère de la page copiée :', 'Select the page to use as mother of the copied page:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (356, 'standard', NOW(), 'Vous allez copier la page %s (%s) sous la page', 'You are going to copy the page %s (%s) under the page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (357, 'standard', NOW(), 'Vous avez choisi de conserver le contenu de la page d\'origine.<br />', 'You choose to keep the original page content.<br />');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (358, 'standard', NOW(), 'Vous avez choisi de ne pas conserver le contenu de la page d\'origine.<br />', 'You choose not to keep the original page content.<br />');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (359, 'standard', NOW(), 'Vous avez choisi de conserver le modèle de la page d\'origine.<br />', 'You choose to keep the original page template.<br />');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (360, 'standard', NOW(), 'Vous avez choisi de changer le modèle de la page d\'origine.<br />', 'You choose to change the original page template.<br />');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (361, 'standard', NOW(), '<br />Confirmez vous que ces informations sont correctes ?', '<br />Confirm you that this information is correct?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (362, 'standard', NOW(), 'Message', 'Message');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (363, 'standard', NOW(), 'Complément', 'Supplement');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (364, 'standard', NOW(), 'Erreur, données manquantes, veuillez rééssayer.', 'Error, missing data, please try again.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (365, 'standard', NOW(), 'Vous n\'avez pas le droit de voir la page que vous cherchez à copier', 'You do not have the right to see the page you want to copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (366, 'standard', NOW(), 'Erreur durant la copie de la page...', 'Error during the copy of the page ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (367, 'standard', NOW(), 'Page non publiée', 'Page unpublished');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (368, 'standard', NOW(), 'Mise à jour lors de la prochaine validation de la page', 'Updated at the next validation of the page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (369, 'standard', NOW(), 'Libellé des liens pointant vers cette page', 'Links label pointing to this page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (370, 'standard', NOW(), 'Identifiant unique de cette page. Permet de la retrouver aisément', 'Unique identifier of this page. Allows to find it easily');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (371, 'standard', NOW(), 'Modèle employé par la page. Permet de structurer son visuel', 'Template used by the page. Used to structure its visual');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (372, 'standard', NOW(), 'Site auquel appartient la page', 'Site which belongs page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (373, 'standard', NOW(), 'Quelles sont les relations des autres pages avec cette page.', 'What are the relations of other pages with this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (374, 'standard', NOW(), 'Est ce que cette page possède une version imprimable spécifique.', 'Does this page gets a printable specific version.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (375, 'standard', NOW(), 'Est ce que cette page redirige automatiquement le visiteur vers un autre endroit.', 'Does this page automatically forwards the visitor to another place.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (376, 'standard', NOW(), 'Date à partir de laquelle la page sera visible en ligne.', 'Date from which the page will be visible online.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (377, 'standard', NOW(), 'Date à partir de laquelle la page ne sera plus visible en ligne.', 'Date from which the page is no longer visible online.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (378, 'standard', NOW(), 'Délai pour recevoir le message d\'alerte ci-dessous.', 'Deadline for receiving the alert message below.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (379, 'standard', NOW(), 'Date à laquelle recevoir le message d\'alerte ci-dessous.', 'Date when receiving the alert message below.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (380, 'standard', NOW(), 'Message d\'alerte à recevoir par email. Attention, votre compte utilisateur doit avoir une adresse email valide.', 'Alert to be received by email. Be careful, your user account must have a valid email address.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (381, 'standard', NOW(), 'Titre de cette page', 'Page title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (382, 'standard', NOW(), 'Description de la page à destination des moteurs de recherche.', 'Page description to search engines');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (383, 'standard', NOW(), 'Mots clés de la page à destination des moteurs de recherche.', 'Keywords of the page to search engines.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (384, 'standard', NOW(), 'Catégories de la page à destination des moteurs de recherche.', 'Categories of the page to search engines.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (385, 'standard', NOW(), 'Cette zone permet de spécifier si les robots utilisés par les moteurs de recherche doivent lire ou non cette page.', 'This area allows you to specify if the robots used by search engines should or not, read this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (386, 'standard', NOW(), 'Valeur par défaut du navigateur', 'Default browser value');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (387, 'standard', NOW(), 'Vous permet de spécifier l\'auteur du contenu pour cette page. Ce champ est visible par les moteurs de recherche.', 'You can specify the content author of this page. This field is visible by search engines.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (388, 'standard', NOW(), 'Vous permet de spécifier une adresse email de contact. Ce champ est visible par les moteurs de recherche.', 'You can specify a contact email address. This field is visible by search engines.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (389, 'standard', NOW(), 'Vous permet de spécifier le copyright du contenu de cette page. Ce champ est visible par les moteurs de recherche.', 'You can specify the copyright content of this page. This field is visible by search engines.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (390, 'standard', NOW(), 'Choisissez la langue de cette page. Ce champ est utile pour permettre un référencement optimal.', 'Choose the language of this page. This field is useful to allow for optimal referencing.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (391, 'standard', NOW(), 'Ce champ vous permet de d\'activer ou de désactiver le cache du navigateur de l\'internaute pour cette page.', 'This field allows you to enable or disable the browser cache for this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (392, 'standard', NOW(), 'Si vous êtes administrateur, vous pouvez saisir ici toute les méta-données supplémentaires que vous souhaitez ajouter à la page.', 'If you are an administrator, you can enter here any meta data which you want to add to the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (393, 'standard', NOW(), 'Méta données libres (format HTML)', 'Free meta data (HTML format)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (394, 'standard', NOW(), 'Sous pages', 'Sub pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (395, 'standard', NOW(), 'Liste des sous pages de la page', 'List of sub pages of the page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (396, 'standard', NOW(), 'Vous pouvez changer leur ordre par glisser-déposer.', 'You can change their order by dragging and dropping.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (397, 'standard', NOW(), 'Cette fenêtre vous permet de voir et de modifier (si vous en avez le droit) les propriétés de la page en cours.', 'This window allows you to view and modify (if you have the right) the properties of the current page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (398, 'standard', NOW(), 'Méta données', 'Meta data');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (399, 'standard', NOW(), 'Alias', 'Alias');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (400, 'standard', NOW(), '# utilisateurs', '# users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (401, 'standard', NOW(), 'Groupes d\'utilisateurs', 'User Groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (402, 'standard', NOW(), 'Etes-vous sur de vouloir supprimer définitivement le groupe : ', 'Are you sure you want to permanently delete the group: ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (403, 'standard', NOW(), 'Groupes {0} à {1} sur {2}', 'Groups from {0} to {1} on {2}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (404, 'standard', NOW(), 'Aucun groupe pour votre recherche...', 'No group for your search ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (405, 'standard', NOW(), 'Par libellé', 'By label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (406, 'standard', NOW(), 'Par lettre :', 'By letter :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (407, 'standard', NOW(), 'Créer un nouveau groupe', 'Create a new group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (408, 'standard', NOW(), 'Profils d\'Utilisateurs et de Groupes', 'Profiles of Users and Groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (409, 'standard', NOW(), 'Cette fenêtre vous permet de rechercher les profils d\'utilisateurs et de groupes d\'utilisateurs déclarés dans Automne pour pouvoir modifier leurs droits.', 'This window lets you search user profiles and user groups declared in Automne to modify their rights.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (410, 'standard', NOW(), 'Actif', 'Active');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (411, 'standard', NOW(), 'Etes-vous sur de vouloir supprimer définitivement l\'utilisateur', 'Are you sure you want to permanently delete the user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (412, 'standard', NOW(), 'Utilisateurs {0} à {1} sur {2}', 'Users from {0} to {1} on {2}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (413, 'standard', NOW(), 'Aucun utilisateur pour votre recherche...', 'No user for your search ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (414, 'standard', NOW(), 'Par nom, prénom, identifiant', 'By name, firstname, reference');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (415, 'standard', NOW(), 'Par groupe', 'By group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (416, 'standard', NOW(), 'Aucun groupe actuellement.', 'No group now.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (417, 'standard', NOW(), 'Créer un nouvel utilisateur', 'Create a new user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (418, 'standard', NOW(), 'Erreur durant la validation...', 'Error while validating ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (419, 'standard', NOW(), 'Validations effectuées', 'Validations made');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (420, 'standard', NOW(), 'Validation effectuée', 'Validation made');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (421, 'standard', NOW(), 'Cette fenêtre vous permet de voir les différentes validations de contenu en attente sur les différents modules.', 'This window lets you see the various validations content waiting on the various modules.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (422, 'standard', NOW(), 'Aucun élément en attente de validation.', 'Nothing awaiting validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (423, 'standard', NOW(), 'Validations {0} à {1} sur {2}', 'Validations from {0} to {1} on {2}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (424, 'standard', NOW(), 'Aucune validation à afficher', 'No validation display');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (425, 'standard', NOW(), 'Valider par lot', 'Submit a lot');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (426, 'standard', NOW(), 'Fermer', 'Close');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (427, 'standard', NOW(), 'éléments en attente de validation sélectionnés. Cliquez sur "Valider par lot" pour valider ces éléments.', 'elements awaiting validation selected. Click on "Submit a lot" to validate these elements.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (428, 'standard', NOW(), 'Cette action fermera la fenêtre des validations.<br />Etes-vous sur ?', 'This action will close the window of validations. <br /> Are you sure?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (429, 'standard', NOW(), 'Erreur : fonction non prise en charge...', 'Error: function not care ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (430, 'standard', NOW(), 'Accepter la validation', 'Accept validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (431, 'standard', NOW(), 'Refuser la validation', 'Refuse validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (432, 'standard', NOW(), 'Transférer la validation', 'Transfert validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (433, 'standard', NOW(), 'à', 'to');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (434, 'standard', NOW(), 'Validation', 'Validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (435, 'standard', NOW(), 'Aucun élément en attente de validation sélectionné.', 'Nothing pending validation selected.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (436, 'standard', NOW(), 'Vos Pages Favorites :', 'Your Bookmarked Pages:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (437, 'standard', NOW(), 'Pages Archivées', 'Archived Pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (438, 'standard', NOW(), 'Duplication de branches', 'Duplication branches');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (439, 'standard', NOW(), 'Voir les paramètres du module.', 'See the module parameters.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (440, 'standard', NOW(), 'Modèles de pages', 'Pages templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (441, 'standard', NOW(), 'Modèles de rangées', 'Templates of rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (442, 'standard', NOW(), 'Feuilles de styles', 'Stylesheets');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (443, 'standard', NOW(), 'Styles Wysiwyg', 'Wysiwyg Styles');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (444, 'standard', NOW(), 'Barre d\'outils Wysiwyg', 'Wysiwyg toolbar');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (445, 'standard', NOW(), 'Gestion des scripts', 'Scripts management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (446, 'standard', NOW(), 'Gestion des langues', 'Languages management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (447, 'standard', NOW(), 'Paramètres Serveur', 'Server settings');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (448, 'standard', NOW(), 'Paramètres Automne', 'Automne settings');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (449, 'standard', NOW(), 'Administration', 'Administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (450, 'standard', NOW(), 'Copier la page et son contenu à un autre point de l\'arborescence.', 'Copy the page and its contents to another item on the tree.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (451, 'standard', NOW(), 'Etes-vous sur de vouloir déverrouiller cette page ? Les modifications en cours par %s peuvent être perdues.', 'Are you sure you want to unlock this page? The changes underway by %s may be lost.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (452, 'standard', NOW(), 'Annuler la demande de suppression de la page.', 'Undo the page deletion request.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (453, 'standard', NOW(), 'Annuler la suppression de la page.', 'Undo the page deletion.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (454, 'standard', NOW(), 'Annuler la demande d\'archivage de la page.', 'Undo the page archiving request.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (455, 'standard', NOW(), 'Annuler l\'archivage de la page', 'Undo page archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (456, 'standard', NOW(), 'Déplacer la page et son contenu à un autre point de l\'arborescence.', 'Move the page and its contents to another item on the tree.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (457, 'standard', NOW(), 'Archiver la page en dehors de l\'arborescence. La page ne sera plus consultable mais pourra être replacé dans l\'arborescence plus tard. Cette action est soumise à validation et peut-être annulé.', 'Archive page outside of the tree. The page will no longer be available but may be placed in the tree later. This action is subject to validation and maybe cancelled.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (458, 'standard', NOW(), 'Etes-vous sur de vouloir archiver la page ?<br /><br />Cette action est soumise à la validation.', 'Are you sure you want to archiving the page ?<br /><br />This action is subject to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (459, 'standard', NOW(), 'Supprimer définitivement la page. Cette action est soumise à validation et peut-être annulé.', 'Delete the final page. This action is subject to validation and maybe cancelled.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (460, 'standard', NOW(), 'Etes-vous sur de vouloir supprimer définitivement la page ?<br /><br />Cette action est soumise à la validation.', 'Are you sure you want to finally delete the page? <br /><br />This action is subject to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (461, 'standard', NOW(), 'Annuler l\'édition de la page en attente de validation. Son contenu reviendra à l\'état de la précédente validation. Cette action n\'est pas soumise à validation et prend effet immédiatement.', 'Undo editing page awaiting validation. Its contents will return to the status of the previous validation. This action is not subject to validation and takes effect immediately.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (462, 'standard', NOW(), 'Annuler l\'édition de la page', 'Undo editing page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (463, 'standard', NOW(), 'Etes-vous sur de vouloir supprimer le contenu en attente de validation ?<br /><br />Le contenu de la page reviendra à l\'état de la précédente validation.<br />Cette action n\'est pas soumise à la validation.', 'Are you sure you want to delete the content awaiting validation? <br /> <br /> The content of the page will return to the status of the previous validation. <br /> This action is not subject to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (464, 'standard', NOW(), 'Supprimer le contenu actuel. Le contenu reviendra au précédent état validé ou en attente de validation. Cette action n\'est pas soumise à validation et prend effet immédiatement.', 'Delete the current page content. The content will revert to the previous content validated or awaiting validation. This action is not subject to validation and takes effect immediately.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (465, 'standard', NOW(), 'Annuler la modification du contenu', 'Cancel content modifications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (466, 'standard', NOW(), 'Etes-vous sur de vouloir supprimer les modifications actuelles du contenu ?<br /><br />Le contenu de la page reviendra au précédent état validé ou en attente de validation de la page.<br />Cette action n\'est pas soumise à la validation.', 'Are you sure you want to delete the current content modifications? <br /> <br /> The content of the page will return to the previous validated or validation pending state of the page. <br /> This action is not subject to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (467, 'standard', NOW(), 'Soumettre les modifications du contenu de la page à la validation. Une fois validée, la page présentera ce contenu en ligne.', 'Submit the current page content modifications to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (468, 'standard', NOW(), 'Soumettre les modifications à la validation', 'Submit the modifications to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (469, 'standard', NOW(), 'Modification des groupes de l\'utilisateur', 'User\'s groups modifications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (470, 'standard', NOW(), 'L\'utilisateur ne peux pas voir les éléments du module.', 'The user can not see any elements of the module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (471, 'standard', NOW(), 'L\'utilisateur ne peux voir que les éléments du module visibles coté client du site. L\'accès coté administration d\'Automne lui est impossible.', 'The user can only see frontend elements of the module. Backend access is not allowed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (472, 'standard', NOW(), 'L\'utilisateur peut voir le coté client et le coté administration d\'Automne pour ce module.', 'The user can see frontend and backend elements for this module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (473, 'standard', NOW(), 'Erreur : utilisateur inexistant...', 'Error: no user ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (474, 'standard', NOW(), 'Utilisateur %s supprimé', '%s user deleted');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (475, 'standard', NOW(), 'Erreur : Utilisateur inconnu...', 'Error: Unknown user ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (476, 'standard', NOW(), 'Utilisateur %s activé', 'User %s activated');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (477, 'standard', NOW(), 'Utilisateur %s désactivé', 'User %s disabled');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (478, 'standard', NOW(), 'Erreur : Groupe inconnu...', 'Error: Unknown group ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (479, 'standard', NOW(), 'Données utilisateur enregistrées.', 'User data registered.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (480, 'standard', NOW(), 'Groupes de l\'utilisateur', 'User groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (481, 'standard', NOW(), 'Confirmer', 'Confirm');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (482, 'standard', NOW(), '* Nom distinctif (DN)', '* Distinguished name (DN)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (483, 'standard', NOW(), 'Cette fenêtre vous permet de consulter et modifier le profil d\'un utilisateur. Ce profil comprend les informations personnelles de l\'utilisateur ainsi que ses droits et les groupes auquel il appartient.', 'This window allows you to view and change the profile of a user. This profile includes personal information of the user and its rights and groups to which it belongs.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (484, 'standard', NOW(), 'Alertes email', 'Notifications email');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (485, 'standard', NOW(), 'Les cases suivantes permettent de choisir pour chaque module quel type d\'alertes vous ou l\'utilisateur souhaitez recevoir par email.', 'The following boxes to choose for each module what kind of alerts or user you wish to receive by email.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (486, 'standard', NOW(), 'Les deux champs de mot de passe doivent être identiques. Le mot de passe doit faire %s caractères minimum et être différent de l\'identifiant.', 'The two password fields must be identical. The password must contain at least %s characters  and be different from the user name.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (487, 'standard', NOW(), 'Ce droit est le plus important dans Automne, il donne la possibilité de réaliser absolument toutes les actions sans aucune contrainte. Ce droit est à réserver uniquement aux administrateurs de plus haut niveau.', 'This right is the highter in Automne. It allows a full clearance on all actions. It should be reserved to hightest administrators only.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (488, 'standard', NOW(), 'Ce droit permet de régénérer les pages du sites manuellement et de controler les scripts en tâches de fond.', 'This right give control on pages regenerations and all scripts tasks in background.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (489, 'standard', NOW(), 'Ce droit permet de gérer toutes les rangées de contenu présentes dans Automne.', 'This right give control on all content rows in Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (490, 'standard', NOW(), 'Ce droit permet de gérer tous les modèles de pages d\'Automne.', 'This right give control on all pages templates in Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (491, 'standard', NOW(), 'Ce droit permet de donner l\'accès au journal de toutes les actions. Il permet aussi de purger ce journal des actions.', 'This right give the access to all actions logs in Automne. It allows logs deletion too.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (492, 'standard', NOW(), 'Ce droit permet de donner accès à la gestion des utilisateurs d\'Automne. Il permet de modifier les utilisateurs et groupes ainsi que leurs droits d\'accès.', 'This right give the control on all users management in Automne. It allows the modification of all users and groups and their rights.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (493, 'standard', NOW(), 'Groupe supprimé.', 'Group deleted.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (494, 'standard', NOW(), 'Groupe inconnu.', 'Group unknown.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (495, 'standard', NOW(), 'Utilisateur ou groupe inconnu.', 'User or group unknown.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (496, 'standard', NOW(), 'Données du groupe enregistrées', 'Data saved group.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (497, 'standard', NOW(), 'Groupe créé', 'Group created');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (498, 'standard', NOW(), 'niveaux', 'levels');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (499, 'standard', NOW(), 'Copie de la page', 'Page copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (500, 'standard', NOW(), 'Ajouter aux favoris', 'Add to your bookmarks');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (501, 'standard', NOW(), 'Vous pouvez ajouter cette page aux favoris Automne pour pouvoir y accéder plus rapidement ! Pour la retrouver ensuite, allez dans la barre latérale puis dans "Gestion des pages".', 'You can add this page to Automne bookmarks to get there faster! To find then, go to the sidebar then in "Management of pages".');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (502, 'standard', NOW(), 'Déverrouiller la page', 'Unlock the page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (503, 'standard', NOW(), 'Les deux champs de mot de passe doivent être identiques. Le mot de passe doit faire %s caractères minimum et être différent de l\'identifiant.', 'The two fields password must be identical. The password must be at least %s characters and be different from the identifier.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (504, 'standard', NOW(), 'L\'utilisateur est l\'administrateur : Il possède tous les droits sur Automne.', 'The user is the administrator: It has all the rights in Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (505, 'standard', NOW(), 'Vous ne pouvez pas modifier les droits de cette page pour cet utilisateur car ils dépendent des groupes auquel il appartient. Modifiez les groupes de l\'utilisateur pour modifier ses droits sur Automne.', 'You can not modify the rights of this page for this user because they depend on the groups to which it belongs. Change the groups the user to modify its rights in Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (506, 'standard', NOW(), 'Vous pouvez gérer ici les différents droits d\'administration d\'Automne.', 'You can manage here the various administration rights of Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (507, 'standard', NOW(), 'L\'utilisateur est Administrateur : Il possède tous les droits sur le module.', 'The user is the administrator: It has all the rights in the module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (508, 'standard', NOW(), 'Vous ne pouvez pas modifier les droits de cette page pour cet utilisateur car ils dépendent des groupes auquel il appartient. Modifiez les groupes de l\'utilisateur pour modifier ses droits sur Automne.', 'You can not modify the rights of this page for the user because they depend on the groups to which it belongs. Change the groups the user to modify its rights in Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (509, 'standard', NOW(), 'Le groupe possède le droit \"Administrateur\" : Il possède tous les droits sur le module.', 'The group is the administrator: It has all the rights in the module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (510, 'standard', NOW(), 'Cette case permet d\'autoriser la validation des éléments du module pour lequels l\'utilisateur à le droit d\'administration.', 'This box allows you to authorize the validation elements of the module for which the user to the right of directors.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (511, 'standard', NOW(), 'Droit de validation sur le module', 'Validation rights in the module');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (512, 'standard', NOW(), 'Aucun groupe n\'existe sur les modèles actuellement...', 'No group exists on templates now...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (513, 'standard', NOW(), 'Aucun groupe n\'existe sur les rangées actuellement...', 'No group exists on rows now...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (514, 'standard', NOW(), 'Droits sur les modèles de pages', 'Rights on pages templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (515, 'standard', NOW(), 'Les droits sur les modèles de pages permettent d\'autoriser l\'utilisation des modèles comportant ces groupes lors de la création des pages.', 'The rights on pages templates can authorize the use of templates with these groups when creating pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (516, 'standard', NOW(), 'Droits sur les modèles de rangées', 'Rights on rows templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (517, 'standard', NOW(), 'Les droits sur les modèles de rangées permettent d\'autoriser l\'utilisation des rangées comportant ces groupes lors de l\'édition du contenu des pages.', 'The rights on the rows templates can authorize the use of rows with these groups when editing content pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (518, 'standard', NOW(), 'Accès général au module', 'General module access');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (519, 'standard', NOW(), 'Accès au contenu', 'Content access');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (520, 'standard', NOW(), 'Utilisateur créé', 'User created');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (521, 'standard', NOW(), 'Vous ne pouvez supprimer cet utilisateur car c\'est un utilisateur système nécessaire au fonctionnement d\'Automne.', 'You cannot delete this user because he is a system user required to operate Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (522, 'standard', NOW(), 'Réactiver l\'utilisateur lui permet de se connecter à nouveau.', 'Reactivate the user permit him to connect again.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (523, 'standard', NOW(), 'Désactiver l\'utilisateur ne lui permet plus de se connecter.', 'Disabling the user prevent his connect.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (524, 'standard', NOW(), 'Copie de :', 'Copy of:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (525, 'standard', NOW(), 'Afficher les blocs', 'Show blocks');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (526, 'standard', NOW(), 'Modification d\'un élément \'Image\'', 'Modifying an \'Image\' element');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (527, 'standard', NOW(), 'Cette fenêtre vous permet de saisir ou modifier une image ainsi que son lien pour l\'élément de la page en cours de modification.', 'This window allows you to enter or modify a picture and its link to the page element being amended.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (528, 'standard', NOW(), 'Sélectionnez une image', 'Select a picture');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (529, 'standard', NOW(), 'Légende/Alt tag', 'Legend/Alt tag');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (530, 'standard', NOW(), 'Tous les fichiers', 'All files');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (531, 'standard', NOW(), 'Modification d\'un élément \'Fichier\'', 'Modifying a \'File\' element');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (532, 'standard', NOW(), 'Cette fenêtre vous permet de saisir ou modifier un fichier pour l\'élément de la page en cours de modification.', 'This window allows you to enter or modify a file and its page element being edited.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (533, 'standard', NOW(), 'Libellé du fichier', 'File label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (534, 'standard', NOW(), 'Sélectionnez un fichier', 'Select a file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (535, 'standard', NOW(), 'Modification d\'un élement \'Animation Flash\'', 'Modifying a \'Flash animation\' element');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (536, 'standard', NOW(), 'Cette fenêtre vous permet de saisir ou modifier une animation Flash pour l\'élément de la page en cours de modification.', 'This window allows you to enter or modify a Flash animation for the element of the page being edited.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (537, 'standard', NOW(), 'Animation Flash', 'Flash animation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (538, 'standard', NOW(), 'Largeur de l\'animation Flash en pixels.', 'Flash animation width in pixels');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (539, 'standard', NOW(), 'Hauteur de l\'animation Flash en pixels.', 'Flash animation height in pixels');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (540, 'standard', NOW(), 'Sera employé comme attribut \'name\' de l\'animation Flash pour l\'identifier dans la page.', 'Will be used as an attribute \'name\' Flash animation to identify on the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (541, 'standard', NOW(), 'Version minimale du plugin Flash nécessaire pour cette animation.<br />Attention à respecter le format suivant :<pre>majeur.mineur.version</pre><br /><strong>Exemple :</strong> 9.0.24', 'Version of Flash needed for this animation.<br />Attention to comply with the following format: <pre>majeur.mineur.version</pre> <strong>Example :</strong> 9.0.24');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (542, 'standard', NOW(), 'Version', 'Version');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (543, 'standard', NOW(), 'Vous pouvez spécifier ici les différents paramètres (tags \\\'params\\\') à employer par l\\\'animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\\'valeur1\\\',\\nnom2:\\\'valeur2\\\',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>wmode:\\\'transparent\\\',\\nmenu:false,\\nscale:\\\'showall\\\'</pre>', 'You can specify different settings here (tags \\\'params\\\') to be used by Flash animation.<br />Attention the following format :<pre>name1:\\\'value1\\\',\\nname2:\\\'value2\\\',\\n...</pre><br /><strong>Example :</strong><br /><pre>wmode:\\\'transparent\\\',\\nmenu:false,\\nscale:\\\'showall\\\'</pre>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (544, 'standard', NOW(), 'Vous pouvez spécifier ici les différentes variables à fournir (valeur de \\\'flashvars\\\') à employer par l\\\'animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\\'valeur1\\\',\\nnom2:\\\'valeur2\\\',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>titre:\\\'Mon animation flash\\\',\\ndescription:\\\'Hello World !\\\'</pre>', 'You can specify the different variables here to provide (value \\\'flashvars\\\') to be used by Flash animation.<br />Attention the following format :<pre>name1:\\\'value1\\\',\\nname2:\\\'value2\\\',\\n...</pre><br /><strong>Example :</strong><br /><pre>title:\\\'My flash animation\\\',\\ndescription:\\\'Hello World !\\\'</pre>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (545, 'standard', NOW(), 'Flashvars', 'Flashvars');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (546, 'standard', NOW(), 'Vous pouvez spécifier ici les différents attributs du tag HTML \\\'object\\\' qui sera employé pour l\\\'animation Flash.<br />Attention à respecter le format suivant :<pre>nom1:\\\'valeur1\\\',\\nnom2:\\\'valeur2\\\',\\n...</pre><br /><strong>Exemple :</strong><br /><pre>class:\\\'flash\\\',\\nalign:\\\'top\\\'</pre>', 'You can say the different attributes of the HTML tag \\\'object\\\' to be used for Flash animation.<br />Attention to the following format :<pre>name1:\\\'value1\\\',\\nname2:\\\'value2\\\',\\n...</pre><br /><strong>Example :</strong><br /><pre>class:\\\'flash\\\',\\nalign:\\\'top\\\'</pre>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (547, 'standard', NOW(), 'Attributs', 'Attributes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (548, 'standard', NOW(), 'Name', 'Name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (549, 'standard', NOW(), 'Erreur de format', 'Format error');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (550, 'standard', NOW(), 'Erreur durant l\'ajout de la rangée ... veuillez rééssayer.', 'Error during adding the row ... please retry.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (551, 'standard', NOW(), 'Erreur durant la suppression de la rangée ... veuillez rééssayer.', 'Error during deleting the row ... please retry.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (552, 'standard', NOW(), 'Erreur durant le déplacement de la rangée ... veuillez rééssayer.', 'Error during moving the row ... please retry.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (553, 'standard', NOW(), 'Erreur durant l\'effacement du bloc ... veuillez rééssayer.', 'Error during deleting the block ... please retry.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (554, 'standard', NOW(), 'Erreur durant la mise à jour du contenu du bloc ... veuillez rééssayer.', 'Error during updating the block content ... please retry.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (555, 'standard', NOW(), 'Impossible de trouver le fichier image à traiter.', 'Unable to find the image file to be processed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (556, 'standard', NOW(), 'Impossible de traiter les fichiers GIF, veuillez installer la librairie GD de PHP.', 'Enable to process GIF files, please install the PHP GD library.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (557, 'standard', NOW(), 'Impossible de traiter les fichiers JPG, veuillez installer la librairie GD de PHP.', 'Enable to process JPG files, please install the PHP GD library.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (558, 'standard', NOW(), 'Impossible de traiter les fichiers PNG, veuillez installer la librairie GD de PHP.', 'Enable to process PNG files, please install the PHP GD library.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (559, 'standard', NOW(), 'Impossible de traiter les fichiers', 'Enable to process files');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (560, 'standard', NOW(), 'Impossible de traiter le fichier, veuillez vérifier l\'installation de la librairie GD de PHP.', 'Enable to process files, please verify the installation of the PHP GD library.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (561, 'standard', NOW(), 'Vous pouvez choisir de créer un lien vers une image grand format (Image Zoom) ...', 'You can choose to create a link to an image format (Image Zoom) ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (562, 'standard', NOW(), '... ou bien faire un lien vers une page, un site externe, un fichier.', '... or make a link to a page, an external site, a file.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (563, 'standard', NOW(), 'Erreur durant la création de la page.', 'Error during page creation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (564, 'standard', NOW(), 'Si vous cochez cette case, la page sera créée mais les zones de contenu seront vide de toutes rangées. Si vous ne la cochez pas, les rangées par défaut du modèle sélectionné seront automatiquement présente dans la page.', 'If you check this box, the page will be created without any default content rows. If you do not check it, the default template rows will be added to all content zone of the created pagge.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (565, 'standard', NOW(), 'Créer la page sans les rangées par défaut du modèle', 'Create page without any default rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (566, 'standard', NOW(), 'Paramètres avancés', 'Advanced parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (567, 'standard', NOW(), 'Actions {0} à {1} sur {2}', 'Actions from {0} to {1} on {2}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (568, 'standard', NOW(), 'Aucune action trouvée ...', 'No action founded...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (569, 'standard', NOW(), 'Administrer le module %s', 'Administrate module %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (570, 'standard', NOW(), 'Vous n\'avez pas le droit d\'accéder à l\'administration du module %s.', 'You have no privileges to access module %s administration.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (571, 'standard', NOW(), 'Administration du module %s', 'Administration of module %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (572, 'standard', NOW(), 'Cette fenêtre vous permet de gérer le contenu du module %s. Vous pouvez ajouter / supprimer / modifier les différents éléments gérés par ce module.', 'This window let you administrate the module %s. You can add / delete and modify elements managed by this module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (573, 'standard', NOW(), 'Envoi d\'email', 'Email sending');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (574, 'standard', NOW(), 'Création d\'un utilisateur.', 'User creation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (575, 'standard', NOW(), 'Résultats', 'Results');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (576, 'standard', NOW(), '{0} Modèles sur {1}', '{0} Templates of {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (577, 'standard', NOW(), 'Supprime le ou les modèles sélectionnés. Un modèle ne doit plus être employé pour être supprimé.', 'Remove the or these selected templates. A template must not be used anymore to be removed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (578, 'standard', NOW(), 'Résultats : {0} Modèles sur {1}', 'Results : {0} Templates of {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (579, 'standard', NOW(), 'Résultats : Aucun résultat pour votre recherche ...', 'Results: No result for your search...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (580, 'standard', NOW(), 'Active le ou les modèles sélectionnés. Un modèle actif peut-être utilisé pour créer des pages.', 'Activate the or these selected templates. An active template can be used to create new pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (581, 'standard', NOW(), 'Désactive le ou les modèles sélectionnés. Un modèle inactif ne peut plus être utilisé pour créer des pages.', 'Desactivate the or these selected templates. An inactive template can not be used to create new pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (582, 'standard', NOW(), 'Modification du ou des modèles sélectionnés.', 'Modification of the or these selected templates.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (583, 'standard', NOW(), 'Création d\'un nouveau modèle.', 'Create a new template.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (584, 'standard', NOW(), '{0} Rangées sur {1}', '{0} Rows of {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (585, 'standard', NOW(), 'Supprime le ou les rangées sélectionnés. Une rangée ne doit plus être employée pour être supprimée.', 'Remove the or these selected templates. A template must not be used anymore to be removed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (586, 'standard', NOW(), 'Résultats : {0} Rangées sur {1}', 'Results : {0} Rows of {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (587, 'standard', NOW(), 'Active la ou les rangées sélectionnés. Une rangée active peut-être utilisé dans des pages.', 'Activate the or these selected rows. An active row can be used into pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (588, 'standard', NOW(), 'Désactive la ou les rangées sélectionnés. Une rangée inactive ne peut plus être ajoutée dans des pages.', 'Desactivate the or these selected rows. An inactive row can not be added into pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (589, 'standard', NOW(), 'Modification de ou des rangées sélectionnés.', 'Modification of the or these selected rows.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (590, 'standard', NOW(), 'Création d\'une nouvelle rangée.', 'Create a new row.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (591, 'standard', NOW(), 'Veuillez vous reconnecter pour voir les modifications.', 'Please reconnect to see the modifications.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (592, 'standard', NOW(), 'Déplacement de pages', 'Moving pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (593, 'standard', NOW(), 'Déplacement de page', 'Page moving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (594, 'standard', NOW(), 'Déplacement de la page :', 'Moving page :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (595, 'standard', NOW(),'Déplacement de page à valider', 'Move of page pending validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (596, 'standard', NOW(),'Déplacement de page validation refusée', 'Move of page validation refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (597, 'standard', NOW(), 'Déplacement d\'une page', 'Moving a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (598, 'standard', NOW(), 'Déplacement de la page \'%s\' par l\'utilisateur %s.', 'Moving of page \'%s\' by user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (599, 'standard', NOW(), 'Nom de l\'application', 'Application name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (600, 'standard', NOW(), 'Email de l\'administrateur', 'Administrator email');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (601, 'standard', NOW(), 'Email de l\'application', 'Application email');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (602, 'standard', NOW(), 'Titre des liens de page dans l\'arborescence', 'Page link name in tree');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (603, 'standard', NOW(), 'Activer l\'utilisation des pages imprimables', 'Activate print pages usage');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (604, 'standard', NOW(), 'Ouvrir les images zoom dans une pop-up', 'Open zoom image in a popup');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (605, 'standard', NOW(), 'Activer le Débuggage système', 'Activate System debug');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (606, 'standard', NOW(), 'Activer les Statistiques de débuggage', 'Activate Debug statistics');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (607, 'standard', NOW(), 'Activer le Débuggage du Polymod', 'Activate Polymod debug');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (608, 'standard', NOW(), 'Activer les Statistiques de débuggage avancées', 'Activate Advanced debug statistics');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (609, 'standard', NOW(), 'Désactiver l\'emission des emails', 'Desactivate emails sending');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (610, 'standard', NOW(), 'Désactiver les méta données avancées des pages', 'Desactivate advanced meta-tags for pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (611, 'standard', NOW(), 'Activer l\'authentification LDAP', 'Activate LDAP authentification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (612, 'standard', NOW(), 'Activer les scripts en tâche de fond', 'Activate background scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (613, 'standard', NOW(), 'Activer les alertes emails des pages 404', 'Activate email alerts for 404 pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (614, 'standard', NOW(), 'Activer la vérification des droits coté client', 'Activate rights checking on frontend');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (615, 'standard', NOW(), 'Autoriser l\'insertion d\'images dans le WYSIWYG', 'Allow images insertion in WYSIWYG');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (616, 'standard', NOW(), 'Activer les logs d\'emission des emails', 'Activate emails sending logs');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (617, 'standard', NOW(), 'Le nom de votre instance d\'Automne', 'The name of your instance of Automne');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (618, 'standard', NOW(), 'Cette adresse servira à envoyer les emails d\'erreur 404 et sera fourni aux utilisateurs lors d\'erreurs critiques.', 'This address will be used to send emails of 404 error and will be provided to users when critical errors occured.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (619, 'standard', NOW(), 'Cette adresse sera utilisée comme adresse d\'émission des différents emails générés par le système, autant coté administration (validations en attentes) que coté public (emails de formulaires).', 'This address will be used as the sender address of emails generated by the system, both side administration (validation pending) than public side (email forms).');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (620, 'standard', NOW(), 'Dans l\'arborescence des pages, permet de basculer entre l\'affichage des titres de pages et l\'affichage des titres de liens de pages lorsque les titres de pages sont trop long.', '	In the pages tree, you can toggle between displaying the titles of pages and the display of titles of links of pages when the titles of pages are too long.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (621, 'standard', NOW(), 'Cette option permet de générer des pages imprimables comportant les zones de contenu sélectionnées (au niveau des modèles de pages). Un modèle d\'impression est alors disponible dans la gestion des modèles de pages. Un lien vers la page imprimable peut-être automatiquement généré grace au tag \'atm-print-link\'. Cette option doit être activée lorsque le module \'Moteur de recherche\' d\'Automne est installé. Vous devez régénérer le(s) site(s) après avoir modifié cette option.', 'This option is used to generate printable pages containing the selected content areas (in each pages templates). A print template  is available in the pages templates management. A link to the print page can be automatically generated using the tag \'atm-print-link\'. This option should be activated when the module \'Search Engine\' of Automne is installed. You must regenerate websites after changing this option.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (622, 'standard', NOW(), 'Activer cette option permet d\'ouvrir les images zoom des blocks \'image\' des rangées dans une fenêtre pop-up. Si cette option n\'est pas active, les images zoom s\'ouvriront dans une nouvelle fenêtre. Vous devez régénérer le(s) site(s) après avoir modifié cette option.', 'Enable this option to open images zoom of \'image\' blocks of the rows in a pop-up window. If this option is not active, the images zoom will be opened in a new window. You must regenerate websites after changing this option.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (623, 'standard', NOW(), 'Cette option active l\'affichage des messages d\'erreurs du système. Elle désactive la compression des fichiers Javascript et CSS pour permettre leur débuggage. Cette option ne doit pas être active sur un site en production pour des raisons de sécurité. Lorsque cette option est désactivée, les messages d\'erreurs restent enregistrés dans le fichier /automne/cms_error_log.', 'This option enables the display of error messages in the system. It disables the compression of Javascript and CSS files. This option should not be active in a production site in for safety reasons. When this option is disabled, error messages are still saved in /automne/cms_error_log.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (624, 'standard', NOW(), 'Si le débuggage système est actif, cette option active l\'affichage des statistiques de traitement PHP et MySQL des scripts du site. Ces statistiques seront affichées en fin de page ou dans la console Javascript.', 'If system debug is enabled, this option enables the display of statistical treatment for PHP and MySQL web site scripts. These statistics will be displayed at the end of the page or in the Javascript console.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (625, 'standard', NOW(), 'Si le débuggage système est actif, cette option active l\'affichage des informations de débuggage spécifique aux modules Polymod.', 'If system debug is enabled, this option enables the display of specific Polymod modules debugging information.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (626, 'standard', NOW(), 'Si le débuggage système et les statistiques de débuggage sont actifs, cette option permet l\'affichage des statistiques détaillées de traitement PHP et MySQL des scripts du site. Un lien vers ces statistiques sera proposé dans la console de débuggage d\'Automne ou en bas de pages.', 'If the system debugging and statistics debugging is active, this option allows the display of detailed statistical treatment for PHP and MySQL scripts on the site.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (627, 'standard', NOW(), 'Désactive l\'émission de tous les emails d\'Automne et du site. A utiliser si votre serveur ne possède pas de SMTP ou si vous ne souhaitez pas qu\'Automne émette des emails.', 'Disable the sending of all emails of Automne and of the site. Should be used if the server does not have an SMTP server.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (628, 'standard', NOW(), 'Désactive les méta-données \'Auteur\', \'Email de réponse\' et \'Copyright\' des pages du site.', 'Disables the meta-datas \'Author\', \'Email response\' and \'Copyright\' of all the pages of the site.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (629, 'standard', NOW(), 'Active l\'authentification LDAP. Les paramètres de connection au serveur LDAP doivent être saisis dans le fichier /config.php. Se référer au fichier /cms_rc.php pour les constantes s\'y rapportant.', 'Active LDAP authentication. Connection parameters to the LDAP server must be entered in the file /config.php. Refer to /cms_rc.php for constants to use.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (630, 'standard', NOW(), 'Active le traitement des scripts (émission d\'emails, génération de pages, etc.) en tâche de fond sur le serveur. Cette option nécessite la présence de PHP CLI sur le serveur. Si cette option est désactivée, ces tâches nécessitent qu\'un utilisateur soit connecté à l\'administration d\'Automne pour s\'effectuer correctement.', 'Active processing scripts (emails sending, pages generation, etc.) in the background on the server. This option requires the presence of PHP CLI on the server. If this option is disabled, these tasks require a user to be connected to the Automne administration to run correctly.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (631, 'standard', NOW(), 'Si cette option est active, chaque erreur 404 génèrera un email d\'alerte pour l\'administrateur. Cet email contiendra toutes les informations nécessaires à l\'identification de l\'erreur. Cette option ne devrait pas être activée sur un site en production.', 'If this option is active, each 404 error will generate an email alert for the administrator. This email will contain all informations needed to identify the error. This option should not be enabled on a production site.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (632, 'standard', NOW(), 'Si cette option est active, l\'ensemble des droits d\'accès aux éléments du site (Pages, Modules, Eléments des modules) seront aussi vérifiés coté client du site. Les droits de \'l\'Utilisateur Anonyme\' seront utilisés pour les utilisateurs non authentifiés. Attention, cette option a un impact significatif sur les performances du site. Ne l\'activez pas si le site ne possède que des éléments visibles pour tout le monde. Elle est en général employée pour définir des sections sécurisées sur le site (cas d\'Extranet ou d\'Intranet). Vous devez régénérer le(s) site(s) après avoir modifié cette option.', 'If this option is active, all access rights to elements of the site (Pages, Modules, Elements of the modules) are also checked client side of the site. The rights of the \'Anonymous User\' will be used for unauthenticated users. Note that this option has a significant impact on site performance. Do not activate it if the site has only elements visible to everyone. It is usually used to define protected sections on the website (Extranet / Intranet). You must regenerate websites after changing this option.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (633, 'standard', NOW(), 'Cette option permet d\'ajouter le plugin \'Images\' aux barres d\'outils WYSIWYG. Cette option ne devrait pas être activée car les images insérées de cette manière ne sont pas soumises au processus de validation des pages et rien ne contrôle leurs pérennité. Employez à la place l\'insertion d\'images via les blocks \'image\' des rangées ou via les modules appropriés.', 'This option allows you to add the plugin \'Pictures\' to WYSIWYG toolbars. This option should not be activated because the images included in this way are not subject to the validation process of pages and nothing controls their survival. Use instead the insertion of images via the \'image\' blocks of rows or via adapted modules.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (634, 'standard', NOW(), 'Cette option permet de logger l\'émission de chaque email généré par Automne.', 'This option allows you to log the emission of each email generated by Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (635, 'standard', NOW(), 'Gérer les éléments \'%s\'', 'Manage elements \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (636, 'standard', NOW(), 'Catégories', 'Categories');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (637, 'standard', NOW(), 'Gérer les catégories utilisées pour le module  \'%s\'', 'Manage catégories used by the module \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (638, 'standard', NOW(), 'Suppression d\'un fichier de modèle', 'Delete a template file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (639, 'standard', NOW(), 'Voir votre site dans une nouvelle fenêtre', 'View your website in a new window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (640, 'standard', NOW(), 'Visiter le site d\'Automne', 'View Automne website');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (641, 'standard', NOW(), 'Bloquer / Débloquer la position du panneau latéral', 'Lock / Unlock side panel position');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (642, 'standard', NOW(), 'Terminer la session en cours et vous déconnecter', 'End current session and disconnect');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (643, 'standard', NOW(), 'Déconnexion', 'Disconnect');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (644, 'standard', NOW(), 'A propos d\'Automne', 'About Automne');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (645, 'standard', NOW(), 'Aucune page dans vos favoris.', 'No pages in your bookmarks.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (646, 'standard', NOW(), 'Scripts Javascript', 'Javascripts Scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (647, 'standard', NOW(), 'Gestion des modules', 'Modules management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (648, 'standard', NOW(), 'Base de données', 'Database');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (649, 'standard', NOW(), 'Le nom de domaine du site est incorrect.', 'Website domain name is incorrect.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (650, 'standard', NOW(), 'Le site actuel n\'est pas correctement configuré. Le nom de domaine actuel est \'%s\' mais votre site est configuré pour le nom de domaine \'%s\'. Avant de continuer, modifiez le nom de domaine dans \'Gestion des sites\' pour correspondre au nom de domaine actuel.', 'The current website is not properly configured. The current domain name is \'%s\' but your website is configured for the domain name \'%s\'. Before continuing, modify the domain name in \'Multi-Site Management\' to match the actual domain name.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (651, 'standard', NOW(), 'Le site actuel n\'est pas correctement configuré. Le nom de domaine actuel est \'%s\' alors que votre site est configuré pour le nom de domaine \'%s\'. Prévenez un administrateur du site en lui précisant ce message d\'erreur.', 'The current website is not properly configured. The current domain name is \'%s\' while your website is configured for the domain name \'%s\'. Notify an administrator of the site by specifying this error message.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (652, 'standard', NOW(), 'Voulez-vous quitter Automne ?', 'Do you want to leave Automne?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (653, 'standard', NOW(), 'Le lien vers \'%s\' semble être un lien externe à votre site. Le suivre vous fera quitter l\'administration d\'Automne, Etes-vous sur de vouloir continuer ?', 'The link to \'%s\' seems to be an external link to your website. Follow it will leave administration. Are you sure you want to continue?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (654, 'standard', NOW(), 'Erreur ...', 'Error...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (655, 'standard', NOW(), 'La page demandée (%s) ne peut-être affichée. Il est possible qu\'elle ai été supprimée ou que vous n\'ayez pas le droit de la consulter.<br />Veuillez sélectionner une nouvelle page dans l\'arborescence ou par le moteur de recherche.', 'The requested page (%s) can not be displayed. It is possible that it has been deleted it or you do not have right to consult it.<br />Please select a new page in the tree or by the search engine.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (656, 'standard', NOW(), 'Rechercher ...', 'Search...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (657, 'standard', NOW(), 'Ajouter aux favoris', 'Add to bookmarks');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (658, 'standard', NOW(), 'Vous pouvez ajouter cette page aux favoris Automne pour pouvoir y accéder plus rapidement ! Pour la retrouver ensuite, allez dans la barre latérale puis dans "Gestion des pages".', 'You can add this page to Automne bookmarks to access it faster! To find it, go in the sidebar and then on "Pages management".');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (659, 'standard', NOW(), 'Cette page est déjà marqué comme favorite. Cliquez à nouveau pour l\'enlever de vos favoris.', 'This page is already in your bookmarks. Click again to remove it.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (660, 'standard', NOW(), 'Dévérouiller la page', 'Unlock page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (661, 'standard', NOW(), 'Déplacez vos pages à l\'aide des icônes flêchées', 'Move pages using arrow icons');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (662, 'standard', NOW(), 'Déplacement de pages', 'Pages move');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (663, 'standard', NOW(), 'Valider les dernières modifications de la page.', 'Validate last page modifications.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (664, 'standard', NOW(), 'Valider la page', 'Page validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (665, 'standard', NOW(), 'Permet de recréer entièrement la page visible sur le site.', 'Recreate the entire page visible on the website.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (666, 'standard', NOW(), 'Régénérer la page', 'Regenerate page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (667, 'standard', NOW(), 'Cette page possède actuellement un contenu modifié qui n\'a pas encore été soumis à validation.', 'This page has a content modified which has not yet been subject to validation.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (668, 'standard', NOW(), 'Vous n\'avez pas le droit de voir les pages du ou des site(s) ...', 'You don\'t have no right to see any pages of the site(s)...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (669, 'standard', NOW(), 'Vous n\'avez pas le droit de voir la page demandée ...', 'You don\'t have no right to see the requested page...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (670, 'standard', NOW(), 'Inconnue', 'Unknown');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (671, 'standard', NOW(), 'Jamais', 'Never');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (672, 'standard', NOW(), '<h1>Version :</h1>
Automne <strong>%s</strong> - Dernière mise à jour : %s
<br /><br />
<h1>Modules installés :</h1>
Polymod - Version : %s<br />
%s
<br />
<h1>Sites de la communauté Automne :</h1>
<ul class="atm-server">
	<li class="atm-pic-logo"><a href="http://www.automne.ws" target="_blank">Visitez le site officel d\'Automne</a> : Vous y trouverez toutes les nouveautés.</li>
	<li class="atm-pic-logo"><a href="http://doc.automne.ws" target="_blank">Toute la Documentation Automne en ligne</a> : Pour toutes les explication sur l\'utilisation d\'Automne ainsi que des tutoriaux.</li>
	<li class="atm-pic-logo"><a href="http://www.automne.ws/forum/" target="_blank">Forum des utilisateurs d\'Automne</a> : Pour communiquer avec d\'autres utilisateurs et échanger vos idées ou vos problèmes.</li>
</ul>
<br />
<h1>Vos impressions sur Automne :</h1>
Vous pouvez nous envoyer vos commentaires sur Automne sur <a href="http://www.automne.ws/contact/" target="_blank">cette page</a>.<br />Toutes vos remarques et critiques seront les bienvenues !
<br /><br />
<h1>Besoin de Formation ou de Support ?</h1>
<a href="http://www.automne.ws/support/" target="_blank">N\'hésitez pas à nous contacter</a>. Nous fournissons des formations de tous niveaux ainsi que des prestations de support professionnel.
<br /><br />
<fieldset>
	Automne est un logiciel sous license open source GNU-GPL créé par<br /><br />
	<a href="http://www.ws-interactive.fr" target="_blank"><img src="/automne/admin/img/logo-ws.png" alt="WS Interactive" title="WS Interactive" /></a>
</fieldset>', '<h1>Version:</h1>
Automne <strong>%s</strong> - Last update: %s
<br /><br />
<h1>Installed modules:</h1>
Polymod - Version: %s<br />
%s
<br />
<h1>Automne community websites:</h1>
<ul class="atm-server">
	<li class="atm-pic-logo"><a href="http://www.automne.ws" target="_blank">Visit offical Automne website</a>: You can find all the news.</li>
	<li class="atm-pic-logo"><a href="http://doc.automne.ws" target="_blank">All Automne inline documentation</a> : For all the explanation on the use of Automne as well as tutorials..</li>
	<li class="atm-pic-logo"><a href="http://www.automne.ws/forum/" target="_blank">Forum of Automne users</a> : Contacting other users and share your ideas or your problems.</li>
</ul>
<br />
<h1>Your impressions of Automne:</h1>
You can send us your comments on <a href="http://www.automne.ws/contact/" target="_blank">this page</a>.<br />All your comments and criticisms are welcome!
<br /><br />
<h1>Need Training or Support?</h1>
<a href="http://www.automne.ws/support/" target="_blank">Feel free to contact us</a>. We provide training at all levels as well as professional support services.
<br /><br />
<fieldset>
	Automne is an open source software licensed under GNU-GPL and created by<br /><br />
	<a href="http://www.ws-interactive.fr" target="_blank"><img src="/automne/admin/img/logo-ws.png" alt="WS Interactive" title="WS Interactive" /></a>
</fieldset>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (673, 'standard', NOW(), 'Cette page vous présente les différents informations concernant votre version d\'Automne ainsi que tous les sites d\'aide disponible pour la communauté.', 'This page presents various information about your version of Automne and all websites available to help the community.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (674, 'standard', NOW(), 'Attention, le debuggage est actif.', 'Beware, debugging is active.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (675, 'standard', NOW(), 'Pressez F2 pour voir la fenêtre de log.', 'Press F2 to see the log window.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (676, 'standard', NOW(), 'Votre session a expiré. Veuillez vous reconnecter ...', 'Your session has expired. Please log in again...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (677, 'standard', NOW(), 'Paramètres enregistrés.', 'Parameters saved.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (678, 'standard', NOW(), 'Paramètres du module %s', 'Module parameters %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (679, 'standard', NOW(), 'Paramètres Automne', 'Automne parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (680, 'standard', NOW(), 'Cette page vous permet de paramétrer diverses fonctionnalités d\'Automne. Référez vous à l\'aide disponible sur chaque paramètre pour en connaitre l\'usage.', 'This page allows you to set various features of Automne. Refer to the help available on each parameter to know the usage.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (681, 'standard', NOW(), 'Vous pouvez modifier les %s. Référez vous à l\'aide disponible sur chaque paramètre pour en connaitre l\'utilité.<br /><br />Ces paramètres sont aussi directement accessible dans le fichier : /automne/classes/modules/%s_rc.xml', 'You can change the %s. Refer to the help available on each parameter to know the utility.<br /> <br /> These parameters are also directly accessible in the file: /automne/classes/modules/%s_rc.xml');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (682, 'standard', NOW(), 'Le formulaire est incomplet ou possède des valeurs incorrectes ...', 'The form is incomplete or has incorrect values ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (683, 'standard', NOW(), 'Glissez déposez les catégories pour les réorganiser', 'Drag-drop to reorder categories');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (684, 'standard', NOW(), 'Catégories du module %s', 'Module category %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (685, 'standard', NOW(), 'Profondeur affichée', 'Depth displayed');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (686, 'standard', NOW(), 'Confirmer la suppression de la catégorie', 'Confirm the deletion of the category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (687, 'standard', NOW(), 'Vous n\'avez pas le droit d\'administrer cette catégorie ...', 'You do not have the right to administer this category...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (688, 'standard', NOW(), 'Erreur durant le déplacement de la catégorie ...', 'Error during the movement of the category ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (689, 'standard', NOW(), 'Création / Modification d\'une catégorie', 'Creating / Editing a category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (690, 'standard', NOW(), 'Sur cette page, vous pouvez créer ou modifier les données (titre, description, vignettes) d\'une catégorie.', 'On this page, you can create or edit the data (title, description, thumbnails) of a category.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (691, 'standard', NOW(), 'Vos droits ne permettent pas de voir les pages du ou des site(s).<br /><br />Si vous pensez qu\'il s\'agit d\'une erreur, contactez votre administrateur', 'Your rights does not allow you to see the pages of the website(s).<br /><br />If you believe this is an error, contact your administrator');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (692, 'standard', NOW(), 'Vos droits ne permettent pas de voir la page demandée.<br /><br />Si vous pensez qu\'il s\'agit d\'une erreur, contactez votre administrateur', 'Your rights does not allow you to see the requested page.<br /><br />If you believe this is an error, contact your administrator');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (693, 'standard', NOW(), 'Filtrer ...', 'Filter...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (694, 'standard', NOW(), 'Le code de votre contenu est mal formatté et il ne peut être enregistré.<br />Evitez tout copier-coller de texte depuis un éditeur de texte externe. Employez les outils \'Coller comme texte\' ou \'Coller de Word\' de la barre d\'outils dans ce cas.<br />Vérifiez le code source de votre contenu : Il doit être composé de XHTML valide.', 'The code of your content is poorly formatted and can not be saved.<br />Avoid copying and pasting text from an external text editor. Use the tools \'Paste as plain text\' or \'Paste from Word\' on the toolbar in this case.<br />Check the source code of your content: It must consist of valid XHTML.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (695, 'standard', NOW(), 'Erreur lors du déplacement de la page ...', 'Error when moving the page...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (696, 'standard', NOW(), 'Erreur lors du déplacement de la page ... Vous n\'avez pas les droits d\'édition sur cette page.', 'Error when moving the page... You do not have the publishing rights to this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (697, 'standard', NOW(), 'Vous n\'avez pas le droit de dupliquer les branches d\'arborescences.', 'You are not allowed to duplicate the branches of trees.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (698, 'standard', NOW(), 'Duplication des pages effectuée.', 'Duplication of pages done.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (699, 'standard', NOW(), 'Erreur sur la page de départ ou de destination de la duplication.', 'Error on the start page or destination of the duplication.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (700, 'standard', NOW(), 'Choisissez un modèle parmi ceux disponible. Un modèle compatible permet de conserver toutes les données de la page d\'origine. Un modèle incompatible ne copiera pas tout le contenu de la page d\'origine.', 'Choose a template among those available. A compatible template allows all data to the original page. An incompatible template will not copy the entire contents of the original page..');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (701, 'standard', NOW(), 'Cochez la case pour mettre à jour l\'adresse de la page.<br />Adresse actuelle :', 'Check the box to update the address of the page.<br />Present address:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (702, 'standard', NOW(), 'Informations', 'Informations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (703, 'standard', NOW(), 'Cette page comporte une redirection vers une page qui n\'existe pas ou comporte une erreur. Elle ne présente donc pas de contenu visible.', 'This page contains a redirect to a page that does not exist or has an error. It may not show any visible content.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (704, 'standard', NOW(), 'L\'élément est actuellement vérouillé par l\'utilisateur %s et ne peut-être mis à jour', 'The item is currently locked by user %s and can not be updated');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (705, 'standard', NOW(), 'L\'élément est actuellement vérouillé par l\'utilisateur %s et ne peut-être dévérouillé', 'The item is currently locked by user %s and can not be unlocked');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (706, 'standard', NOW(), 'Vous n\'avez pas le droit de gérer les modèles de rangées ...', 'You do not have the right to manage models of rows...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (707, 'standard', NOW(), 'Vous pouvez utiliser des groupes pour catégoriser votre modèle de rangée. Vous pourrez ainsi simplifier sa sélection mais aussi associer des droits aux utilisateurs sur ces groupes. Ceci permettra de limiter l\'usage de certains modèles spécifiques à certains profils d\'utilisateurs.', 'You can use groups to categorize your template row. You can simplify the selection, but also involve rights to users on these groups. This will limit the use of certain specific user profiles.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (708, 'standard', NOW(), 'Vous pouvez utiliser des icônes pour identifier votre modèle de rangée. Vous pourrez ainsi simplifier sa sélection.', 'You can use icons to identify your model row. You can simplify its selection.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (709, 'standard', NOW(), 'Icône', 'Icon');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (710, 'standard', NOW(), 'Modèle de rangée :', 'Template row:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (711, 'standard', NOW(), 'Création d\'un modèle de rangée', 'Creating a template row');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (712, 'standard', NOW(), 'Cette page vous permet de créer et modifier un modèle de rangée. Les modèles de rangée servent de base de saisie au contenu des pages des sites.', 'This page allows you to create and edit a row. Row templates provide the basis for entering the pages content of websites.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (713, 'standard', NOW(), 'Vous pouvez ajouter un ou plusieurs nouveaux groupes au modèle de rangée en cours. Le nom du groupe ne doit contenir que des caractères alphanumériques. Les groupes doivent être séparés par des virgules ou des point-virgules.', 'You can add one or more new groups to the model of current row. The name of the group must only contain alphanumeric characters. Groups must be separated by commas or semi-colons.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (714, 'standard', NOW(), 'Nouveaux groupes', 'New groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (715, 'standard', NOW(), 'En cochant cette case, aucun utilisateur ne pourra voir ou utiliser ce modèle de rangée tant qu\'ils n\'auront pas les droits sur les nouveaux groupes ajoutés ci-dessus.', 'By checking this box, any user can see or use this model to row until they have the rights to the new groups added above.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (716, 'standard', NOW(), 'Ne pas donner les droits de voir ces nouveaux groupes aux utilisateurs.', 'Do not give the rights to see these new groups to users.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (717, 'standard', NOW(), 'Sélectionnez les modèles de pages pour lesquels l\'utilisation de ce modèle de rangée sera possible. Si aucun modèle n\'est spécifié, tous les modèles de page pourront employer cette rangée.', 'Select pages templates for which the use of this template row will be possible. If no template is specified, all page templates can use this row.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (718, 'standard', NOW(), 'Modèles de pages', 'Pages templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (719, 'standard', NOW(), 'Autorisés', 'Authorized');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (720, 'standard', NOW(), 'Disponibles', 'Available');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (721, 'standard', NOW(), 'Si aucune icône ne convient dans la liste ci-dessus, vous pouvez en ajouter une nouvelle.', 'If no icon would be in the list above, you can add a new one.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (722, 'standard', NOW(), 'Nouvelle icône', 'New icon');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (723, 'standard', NOW(), 'Définition XML', 'XML definition');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (724, 'standard', NOW(), 'Vous pouvez modifier ici la structure XML de cette rangée. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, ne supprimez pas de tag &lt;block&gt; existant sous peine de perdre du contenu sur les pages employant déjà ce modèle de rangée.', 'Here you can change the XML structure of this row. You must follow the XML standard under penalty of error.<br /><strong>Warning</strong>, do not remove existing tag &lt;block&gt; under penalty of losing content on the pages already using this template row.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (725, 'standard', NOW(), 'Activer la coloration syntaxique', 'Enable syntax highlighting');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (726, 'standard', NOW(), 'Réindenter', 'Reindent');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (727, 'standard', NOW(), 'Aide à la syntaxe des rangées de contenu', 'Help with syntax of rows of content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (728, 'standard', NOW(), 'Cette fenêtre regroupe les différentes aides nécessaire à la création de rangées de contenu pour chacun des modules.', 'This window lists all the various aids necessary for the creation of rows of content for each module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (729, 'standard', NOW(), 'Le modèle de rangée à modifier n\'existe pas ou possède une erreur.', 'The model row to modify does not exist or has an error.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (730, 'standard', NOW(), 'Rangée enregistrée avec succès.', 'Row successfully saved.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (731, 'standard', NOW(), 'Rangée créée avec succès.', 'Row successfully created.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (732, 'standard', NOW(), 'Définition XML mise à jour avec succès', 'XML definition updated successfully');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (733, 'standard', NOW(), '%s pages en cours de régénération.', '%s pages during regeneration.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (734, 'standard', NOW(), 'Aucune page publique n\'emploie ce modèle ...', 'No public page uses this model...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (735, 'standard', NOW(), 'Script en cours, Aucun fichier PID trouvé. Vérifiez la configuration du répertoire temporaire d\'Automne.', 'Script in progress, No PID file found. Check the configuration of the temporary directory of Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (736, 'standard', NOW(), 'Script en cours, Fichier PID trouvé.', 'Script in progress, PID file founded.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (737, 'standard', NOW(), 'Fichier PID trouvé sans référence en Base de données ...', 'PID file founded without reference in database...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (738, 'standard', NOW(), 'Fichier PID trouvé et script marqué comme terminé ...', 'PID file founded and script marked as completed...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (739, 'standard', NOW(), 'Aucun script en cours de traitement.', 'No script in progress.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (740, 'standard', NOW(), 'Aucun script en cours de traitement.', 'No script in the queue.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (741, 'standard', NOW(), 'Par nom, description, mots clés', 'By name, description, keywords');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (742, 'standard', NOW(), 'Rechercher dans', 'Search in');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (743, 'standard', NOW(), 'Rechercher dans \'%s\'', 'Search in \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (744, 'standard', NOW(), 'Sur cette page, vous pouvez rechercher toutes les pages des sites, les éléments des modules, les utilisateurs, groupes et modèles de pages et de rangées. Spécifiez vos mots clés ainsi que les éléments sur lesquels vous souhaitez effectuer votre recherche.', 'On this page you can search all pages of the sites, elements of the modules, users, groups and models of pages and rows. Specify your keywords and the elements on which you wish to search.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (745, 'standard', NOW(), 'Résultats : {0} résultats sur {1}', 'Results: {0} Results on {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (746, 'standard', NOW(), '{0} résultats sur {1}', '{0} Results on {1}');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (747, 'standard', NOW(), 'Voir le ou les éléments sélectionnés.', 'View your selected items.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (748, 'standard', NOW(), 'Vous n\'avez pas les droits d\'administrateur ...', 'You do not have administrator rights...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (749, 'standard', NOW(), 'Test des paramètres du serveur nécessaires au fonctionnement d\'Automne :', 'Test server settings required for the operation of Automne:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (750, 'standard', NOW(), 'Vérifier les droits d\'accès aux fichiers :', 'Check access rights to files:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (751, 'standard', NOW(), 'Pour Automne :', 'For Automne:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (752, 'standard', NOW(), 'Permet de valider qu\'Automne possède bien les droits nécessaire sur l\'ensemble des fichiers du site.', 'Used to validate that Automne has required rights to all files on the site.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (753, 'standard', NOW(), 'Pour les utilisateurs :', 'For users:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (754, 'standard', NOW(), 'Permet de valider que les utilisateurs et internautes possèdent bien les droits nécessaire sur l\'ensemble des fichiers du site.', 'Used to validate users and Internet users have the rights necessary to all files on the site.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (755, 'standard', NOW(), 'Paramètres du serveur', 'Server parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (756, 'standard', NOW(), 'Cette page vous permet de voir l\'état des différents paramètres du serveur nécessaire à l\'éxécution d\'Automne.', 'This page lets you view the status of various server settings needed for the execution of Automne.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (757, 'standard', NOW(), 'Vérifier', 'Check');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (758, 'standard', NOW(), 'En cours ...', 'In progress...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (759, 'standard', NOW(), 'Détails', 'Details');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (760, 'standard', NOW(), 'Accès aux fichiers', 'File access');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (761, 'standard', NOW(), 'Informations PHP', 'PHP informations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (762, 'standard', NOW(), 'Mises à jour', 'Updates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (763, 'standard', NOW(), '... Il y a plus de 1000 fichiers inaccessible en écriture ...', '... There are more than 1000 files inaccessible for writing ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (764, 'standard', NOW(), 'Erreur lors de la vérification ...', 'Error checking ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (765, 'standard', NOW(), 'Erreur : les fichiers et dossiers suivants ne sont pas accessibles en écriture :', 'Error: Files and folders are not accessible for writing:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (766, 'standard', NOW(), 'Vérification terminée !', 'Verification done!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (767, 'standard', NOW(), 'Nombre de dossiers :', 'Number of folders:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (768, 'standard', NOW(), 'Nombre de fichiers :', 'Number of files:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (769, 'standard', NOW(), 'Espace disque employé :', 'Disk space used:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (770, 'standard', NOW(), 'Régénération des pages :', 'Regeneration of pages:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (771, 'standard', NOW(), 'Permet recréer les pages visibles coté client des différents sites.', 'Lets recreate the visible client-side pages of the different websites.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (772, 'standard', NOW(), 'Scripts en cours :', 'Scripts in progress:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (773, 'standard', NOW(), 'Permet de visualiser les scripts en cours de traitement sur le serveur.', 'View the scripts being processed on the server.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (774, 'standard', NOW(), 'Gestion des scripts', 'Scripts management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (775, 'standard', NOW(), 'Cette page vous permet de gérer les différents scripts en tâche de fond ainsi que la régénération des pages du site. Régénérer une page permet de recréer le cache de cette page qui sert à sa consultation coté client.', 'This page allows you to manage the various scripts in the background and the regeneration of the site\'s pages. Regenerate a page used to recreate the cache of this page that serves its client side consulting.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (776, 'standard', NOW(), 'Tout Régénérer', 'Regenerate all');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (777, 'standard', NOW(), 'Régénère l\'ensemble des pages de tous les sites.', 'Regenerates all pages of all sites.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (778, 'standard', NOW(), 'Régénérer une branche', 'Regenerate tree branch');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (779, 'standard', NOW(), 'Régénère l\'ensemble des pages sous la page sélectionnée.', 'Regenerates all pages in the selected page branch.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (780, 'standard', NOW(), 'Sélectionnez la page parente de l\'arborescence à régénérer.', 'Select the parent of the tree to regenerate.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (781, 'standard', NOW(), 'Régénération des pages sélectionnées', 'Regeneration of selected pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (782, 'standard', NOW(), 'Régénère l\'ensemble des pages dont l\'identifiant est précisé. Employez le tiret pour spécifier un groupe de pages. Exemple : 1,3,10-15.', 'Regenerates all pages whose identifier is specified. Use a hyphen to specify a page group. Example: 1,3,10-15.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (783, 'standard', NOW(), 'Spécifiez les Pages', 'Specify Pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (784, 'standard', NOW(), 'Sélectionner la page de destination dans l\'arborescence', 'Select the destination page in the tree');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (785, 'standard', NOW(), 'Régénérer', 'Regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (786, 'standard', NOW(), 'Relancer les scripts', 'Restart scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (787, 'standard', NOW(), 'Relance le traitement des scripts dans la file d\'attente si les scripts ne sont pas déjà en cours de traitement.', 'Restart processing scripts in the queue if the scripts are not already being processed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (788, 'standard', NOW(), 'Stopper les scripts', 'Stop scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (789, 'standard', NOW(), 'Arrête le traitement de la file d\'attente des scripts.', 'Stop processing queue scripts.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (790, 'standard', NOW(), 'Effacer la file', 'Delete the queue');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (791, 'standard', NOW(), 'Vide la file d\'attente des scripts en cours de traitement.', 'Empty queue scripts being processed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (792, 'standard', NOW(), 'Détails des scripts en cours', 'Details of scripts in progress');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (793, 'standard', NOW(), 'Détails de la file d\'attente', 'Details of the queue');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (794, 'standard', NOW(), 'Vous n\'avez pas les droits d\'administrer les scripts ...', 'You do not have the rights to manage scripts...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (795, 'standard', NOW(), 'Toutes les pages ont été soumises à régénération.', 'All pages have been subjected to regeneration.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (796, 'standard', NOW(), '%s pages soumises à régénération.', '%s pages under regeneration.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (797, 'standard', NOW(), '%s pages régénérées.', '%s pages regenerated.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (798, 'standard', NOW(), 'Aucune page publique ne correspond aux identifiants saisis ...', 'None public page match the identifiers before...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (799, 'standard', NOW(), 'Vous n\'avez pas le droit de gérer les modèles de pages ...', 'You do not have the right to manage models of pages ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (800, 'standard', NOW(), 'Suppression d\'actualité', 'News item deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (801, 'standard', NOW(), 'Suppression de l\'actualité : \'%s\'', 'Deletion of news article \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (802, 'standard', NOW(), 'Pour un lien interne, saisir une ID page.<br /> Pour un lien externe, saisir une URL.', 'For internal links enter a page reference number.<br />\r\nFor external links enter an URL.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (803, 'standard', NOW(), 'Image', 'Current image');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (804, 'standard', NOW(), 'Aucune', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (805, 'standard', NOW(), 'Suppression d\'actualité', 'News item deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (806, 'standard', NOW(), 'Suppression de l\'actualité : ', 'Deletion of news item: ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (807, 'standard', NOW(), 'Paramètres', 'Parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (808, 'standard', NOW(), 'Paramètres du module %s', '%s parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (809, 'standard', NOW(), '[Module inconnu]', '[Unknown application]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (810, 'standard', NOW(), '[Ce module n\'a pas de paramètres]', '[This application does not have parameters to enter]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (811, 'standard', NOW(), 'Aperçu', 'Preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (812, 'standard', NOW(), 'Sites', 'Websites');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (813, 'standard', NOW(), 'Confirmer la suppression du site \'%s\' ? ATTENTION ! Cette action n\'est pas soumise à  validation et prendra effet immédiatement !', 'Confirm deletion of the website \'%s\' ? ATTENTION, this action will take effect immediatly!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (814, 'standard', NOW(), 'Libellé', 'Label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (815, 'standard', NOW(), 'Racine', 'Start Page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (816, 'standard', NOW(), 'Modification d\'un site', 'Website edition');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (817, 'standard', NOW(), '[Opération impossible : la page sélectionnée comme racine est déjà  la racine d\'un autre site.]', '[Action denied: the page you have selected as the Start Page is already chosen for another website]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (818, 'standard', NOW(), '[Erreur lors du changement de racine]', '[Error while attempting to modify the Start Page]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (819, 'standard', NOW(), 'Domaine (URL)', 'Doamin (URL)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (820, 'standard', NOW(), 'Changer', 'Change');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (821, 'standard', NOW(), 'Gestion des sites', 'Multi-site management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (822, 'standard', NOW(), 'Sélection d\'une racine', 'Website Start Page selection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (823, 'standard', NOW(), 'Sélectionner une page racine pour le site modifié.', 'Please select a Start Page for the website you are declaring.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (824, 'standard', NOW(), 'Site', 'Website');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (825, 'standard', NOW(), 'Confirmer la suppression du modèle \'%s\'', 'Confirm deletion of template \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (826, 'standard', NOW(), 'Voir les modèles des pages', 'View templates used for a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (827, 'standard', NOW(), 'Arborescence : pages et modèles (entre parenthèses).', 'Site organisation with page template (in parenthesis)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (828, 'standard', NOW(), 'Modèle par page', 'Template per page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (829, 'standard', NOW(), 'Rangées par défaut', 'Default style-rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (830, 'standard', NOW(), 'Propriétés d\'un modèle', 'Template properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (831, 'standard', NOW(), 'Modèle XML', 'XML file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (832, 'standard', NOW(), 'Modifier le fichier', 'Edit file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (833, 'standard', NOW(), 'Vignette', 'Thumbnail');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (834, 'standard', NOW(), 'Modifier la vignette', 'Edit image');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (835, 'standard', NOW(), 'Vignette', 'Current thumbnail');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (836, 'standard', NOW(), 'Aucune', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (837, 'standard', NOW(), 'Groupes', 'Groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (838, 'standard', NOW(), 'Nouveaux groupes (séparés par des points-virgules)', 'New groups (separated by semi-colons)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (839, 'standard', NOW(), '[Erreur lors de l\'insertion d\'un fichier]', '[Error while uploading file]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (840, 'standard', NOW(), '[Le modèle XML importé est mal formé]', '[Error, the uploaded XML file contains conformity anomalies]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (841, 'standard', NOW(), 'Gestion des modèles', 'Template management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (842, 'standard', NOW(), 'Modèles', 'Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (843, 'standard', NOW(), 'Bibliothèque de rangées', 'Library of Style-rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (844, 'standard', NOW(), 'Confirmer la suppression de la rangée \'%s\'?', 'Do you confirm deletion of the style-row \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (845, 'standard', NOW(), 'Gestion d\'une rangée ', 'Style-Rows management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (846, 'standard', NOW(), 'Définition XML', 'XML definition');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (847, 'standard', NOW(), '[Erreur lors de la suppression du modèle]', '[Error while trying to delete template]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (848, 'standard', NOW(), '[Erreur lors de la suppression d\'une rangée]', '[Error while trying to delete style-row]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (849, 'standard', NOW(), 'Les rangées utilisent du code XHTML associé à  des tags Automne spécifiques à  votre site %s. <br /> Attention, Automne n\'utilisera pas le code non conforme à  l\'XHTML.', 'Style-rows use XHTML in conjunction with Automne tags specific to your site %s.<br />Attention, Automne will not use non-conformed xHTML.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (850, 'standard', NOW(), 'Vers le haut', 'Move up');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (851, 'standard', NOW(), 'Vers le bas', 'Move down');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (852, 'standard', NOW(), 'Modification des rangées par défaut du modèle %s', 'Modification of default rows for template %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (853, 'standard', NOW(), 'Nom', 'Name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (854, 'standard', NOW(), 'Supprimer', 'Delete');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (855, 'standard', NOW(), 'Insérer la rangée', 'Add Style-row');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (856, 'standard', NOW(), 'Zone modifiable \'%s\'', 'Content management zone \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (857, 'standard', NOW(), 'Effacer les modifications', 'Delete modifications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (858, 'standard', NOW(), 'Confirmer l\'annulation des modifications pour \'%s\' ? ATTENTION! Cette action n\'est pas soumise à  validation et prendra effet immédiatement.', 'Confirm cancellation of modifications for page \'%s\' ? Attention, this action takes effect immediatly!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (859, 'standard', NOW(), 'Archives', 'Archives');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (860, 'standard', NOW(), 'Archives', 'Archives');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (861, 'standard', NOW(), 'Page de destination', 'Destination page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (862, 'standard', NOW(), 'Sélectionner la page de destination d\'une page sortant d\'archive', 'Select the destination page for the unarchived page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (863, 'standard', NOW(), 'Identifiant', 'Reference');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (864, 'standard', NOW(), 'Titre', 'Title');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (865, 'standard', NOW(), 'Dernière publication', 'Last publication');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (866, 'standard', NOW(), 'Confirmer la suppression de la page \'%s\' ? ATTENTION ! Cette suppression n\'est pas soumise à  validation et prendra effet immédiatement.', 'Confirm deletion of the page \'%s\' ? Attention, this action takes effect immediately!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (867, 'standard', NOW(), '[Impossible de déplacer une page qui n\'a jamais été validée]', 'Impossible to move a page that has never been validated.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (868, 'standard', NOW(), '[Impossible de déplacer la racine]', '[Error, the Start Page cannot be moved]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (869, 'standard', NOW(), '[Impossible de déplacer une page vers ses descendants]', '[Error, a page cannot be moved to one of its sub pages]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (870, 'standard', NOW(), '[La page de destination ne peut pas être une page non validée]', '[The new destination page must be validated]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (871, 'standard', NOW(), 'Modification des propriétés', 'Modification of properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (872, 'standard', NOW(), 'Modification du contenu', 'Content modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (873, 'standard', NOW(), 'Suppression', 'Deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (874, 'standard', NOW(), 'Annuler la suppression', 'Undeletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (875, 'standard', NOW(), 'Archiver', 'Archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (876, 'standard', NOW(), 'Annuler l\'archivage', 'Unarchiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (877, 'standard', NOW(), 'Annuler les modifications', 'Cancel modifications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (878, 'standard', NOW(), 'Valider', 'Validate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (879, 'standard', NOW(), 'Ajout d\'un site', 'Add web site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (880, 'standard', NOW(), 'Modification d\'un site', 'Modify web site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (881, 'standard', NOW(), 'Suppression d\'un site', 'Delete web site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (882, 'standard', NOW(), 'Modification d\'un groupe de profils', 'Modify Group Profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (883, 'standard', NOW(), 'Suppression d\'un groupe de profils', 'Delete group profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (884, 'standard', NOW(), 'Modification d\'un profil', 'Modify user profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (885, 'standard', NOW(), 'Suppression d\'un utilisateur', 'Delete user profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (890, 'standard', NOW(), 'Modification d\'un modèle', 'Modify template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (891, 'standard', NOW(), 'Modification d\'une rangée de modèle', 'Modify style-row of a template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (892, 'standard', NOW(), 'Suppression d\'un modèle', 'Delete template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (893, 'standard', NOW(), 'Suppression d\'une rangée de modèle', 'Delete template style-row');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (894, 'standard', NOW(), 'Journal des actions', 'Action log');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (895, 'standard', NOW(), 'Par profil', 'By user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (896, 'standard', NOW(), 'Par page', 'By page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (897, 'standard', NOW(), 'Sélection d\'une page', 'Select a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (898, 'standard', NOW(), 'Sélectionner une page pour afficher le journal des actions', 'Select a page to see its corresponding action log');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (899, 'standard', NOW(), 'Sélectionner', 'Select');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (900, 'standard', NOW(), 'Régénérer', 'Regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (901, 'standard', NOW(), 'Toutes les pages', 'All pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (902, 'standard', NOW(), 'Une page (choisir)', 'One page (choose)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (903, 'standard', NOW(), 'Meta administration', 'Advanced administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (904, 'standard', NOW(), 'Journal des actions pour l\'utilisateur %s', 'Logged actions for user %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (905, 'standard', NOW(), 'Date', 'Date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (906, 'standard', NOW(), 'Action', 'Action');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (907, 'standard', NOW(), 'Commentaires', 'Comments');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (908, 'standard', NOW(), 'Utilisateur', 'User');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (909, 'standard', NOW(), 'Statut après', 'Status after');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (910, 'standard', NOW(), 'Journal des actions pour %s', 'Logged action for resource %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (911, 'standard', NOW(), 'Changement de l\'ordre des pages', 'Order of pages modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (912, 'standard', NOW(), 'Cet email est généré automatiquement par Automne concernant votre site %s.\r\nSite : %s\r\nAdministration du site : %s', 'This email was automatically generated by Automne regarding your website %s.\r\nWebsite: %s\r\nAdministration platform: %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (913, 'standard', NOW(), 'Modification de votre profil d\'utilisateur', 'Modify your user profile');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (914, 'standard', NOW(), 'Votre profil a été modifié. Vos identifiants sont :\r\nIdentifiant : %s\r\n\r\nModification(s) effectuée(s) : \r\n', 'Your user profile has been updated.\r\nLogin : %s\r\n\r\nModification type:\r\n');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (915, 'standard', NOW(), 'Modification des sections de droit', 'Modification of content management rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (916, 'standard', NOW(), 'Modification des données personnelles', 'Modification of user properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (917, 'standard', NOW(), 'Modification des données de contact', 'Modification of contact information');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (918, 'standard', NOW(), 'Modification des droits sur les modules', 'Modification of application rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (919, 'standard', NOW(), 'Modifications des droits d\'administration', 'Modification of administration rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (920, 'standard', NOW(), 'Modification des droits de validation', 'Modification of validation rights');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (921, 'standard', NOW(), '[Modification des groupes de modèles refusée]', '[Template groups denied modification]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (922, 'standard', NOW(), 'Modification du niveau de notification', 'Modification of alert level');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (923, 'standard', NOW(), 'Alerte sur contenu de page', 'Content management alert');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (924, 'standard', NOW(), 'La page \'%s\' est obsolète et doit être mise à  jour.', 'This is an automatic alert for the page \'%s\'. You or another provider must log on to the administration platform and make the appropriate modifications.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (925, 'standard', NOW(), 'Un message d\'alerte est associé :\r\n%s', 'A personalised alert message is included:\r\n%s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (926, 'standard', NOW(), 'Utilisateurs', 'Users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (927, 'standard', NOW(), 'Utilisateurs appartenant au groupe %s', 'Users belonging to group %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (928, 'standard', NOW(), 'Aucun utilisateur', 'No user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (929, 'standard', NOW(), 'Confirmer la suppression de l\'utilisateur \'%s\'', 'Confirm deletion of user \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (930, 'standard', NOW(), 'Confirmer la suppression du groupe \'%s\'', 'Confirm deletion of group \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (931, 'standard', NOW(), 'Groupe', 'Group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (932, 'standard', NOW(), 'Création d\'un lien interne', 'Create an internal link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (933, 'standard', NOW(), 'Résultat', 'Result');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (934, 'standard', NOW(), 'Libellé du lien', 'Link label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (935, 'standard', NOW(), 'Sélection de la page', 'Page selection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (936, 'standard', NOW(), 'Sélectionner la page', 'Select the page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (937, 'standard', NOW(), 'Créer un lien interne', 'Create an internal link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (938, 'standard', NOW(), 'Modifier', 'Modify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (939, 'standard', NOW(), 'Insérer au curseur', 'Insert at cursor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (940, 'standard', NOW(), 'Espace "Copier-coller"', '"Copy-paste" space');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (941, 'standard', NOW(), 'Historique des actions sur le contenu', 'Show content management action log');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (942, 'standard', NOW(), 'Sélection de la page à régénérer', 'Select a page to regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (943, 'standard', NOW(), 'Sélectionner la page à régénérer', 'Select a page to regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (944, 'standard', NOW(), 'Scripts en cours', 'Active scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (945, 'standard', NOW(), 'Voir file d\'attente', 'View queue list');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (946, 'standard', NOW(), 'Redémarrer scripts', 'Restart scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (947, 'standard', NOW(), 'Voici les scripts restant en file d\'attente', 'These are the scripts left into queue');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (948, 'standard', NOW(), 'Créer depuis le modèle', 'Create from template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (949, 'standard', NOW(), 'Nouveau modèle', 'New template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (950, 'standard', NOW(), 'Feuilles de style', 'Stylesheet (CSS) files');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (951, 'standard', NOW(), 'Feuille de style "%s"', 'Stylesheet "%s"');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (952, 'standard', NOW(), 'Enregistrer', 'Save');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (953, 'standard', NOW(), 'Balise', 'Tag');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (954, 'standard', NOW(), 'Style', 'Style');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (955, 'standard', NOW(), 'Nom du style', 'Style name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (956, 'standard', NOW(), 'Pseudo classe', 'Pseudo class');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (957, 'standard', NOW(), 'Attribut', 'Attribute');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (958, 'standard', NOW(), 'Valeur', 'Value');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (959, 'standard', NOW(), 'Nouveau style', 'Add new style');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (960, 'standard', NOW(), 'Supprimer cet élément de la feuille de style ?', 'Delete this style element from stylesheet ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (961, 'standard', NOW(), '[L\'écriture est impossible dans le fichier de feuille de style donné]', '[Impossible to write into given stylesheet file]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (962, 'standard', NOW(), '[Recréation depuis le fichier de sauvegarde impossible]', '[Rebuild from backup file failed]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (963, 'standard', NOW(), '[Copie de sauvegarde impossible]', '[Creation of backup file impossible]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (964, 'standard', NOW(), '[La définition de style semble incomplète]', '[Your style definition seems incomplete]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (965, 'standard', NOW(), '[Ce style existe déjà ]', '[This style already exists]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (966, 'standard', NOW(), '[Style supprimé]', '[Style deleted]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (967, 'standard', NOW(), '[Style modifié]', '[Style modified]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (968, 'standard', NOW(), 'Image zoom', 'Image zoom');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (969, 'standard', NOW(), 'Ouvrir ce lien en pop-up ?', 'Open this link in a pop-up?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (970, 'standard', NOW(), 'Largeur de la pop-up', 'Pop-up width:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (971, 'standard', NOW(), 'Hauteur de la pop-up ', 'Pop-up height:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (975, 'standard', NOW(), 'Copie de branche d\'arborescence', 'Select a branch of the tree to copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (976, 'standard', NOW(), 'Sélectionner la première page de la branche à  copier ...', 'Select first page from branch you want to copy ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (977, 'standard', NOW(), '... sélectionner la page de destination.', '... select destination page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (978, 'standard', NOW(), '[Les pages sélectionnées pour la duplication d\'arborescence sont incorrectes. Essayer à  nouveau.]', '[Pages selected for duplication seem incorrect, please try again]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (979, 'standard', NOW(), '[Les pages ont été créées. Vérifier leur contenu depuis l\'arborescence.]', '[The new pages have been successfully copied]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (980, 'standard', NOW(), 'Sélectionner les modèles de remplacement\r\ndes pages à  dupliquer. Les modèles doivent contenir les mêmes zones modifiables et les mêmes rangées.', 'Select different templates for the new pages.<br />\r\nAll templates must have exactly the same structure of content management zones.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (981, 'standard', NOW(), 'Le modèle <b>%s</b> est remplacé par:', 'Template <b>%s</b> will be replaced by:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (982, 'standard', NOW(), 'Dupliquer', 'Duplicate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (983, 'standard', NOW(), 'Une branche', 'A branch');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (984, 'standard', NOW(), 'Un contenu de page', 'One page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (985, 'standard', NOW(), 'Copie du contenu d\'une page', 'Copying one page contents');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (986, 'standard', NOW(), 'Sélectionner la page dont le contenu sera copié ...', 'Select the page to copy content from ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (987, 'standard', NOW(), '... sélectionner la page recevant le contenu.', '... select the destination page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (988, 'standard', NOW(), 'La sélection de pages semble incorrecte. Recommencer la procédure.', 'Selection of pages is incorrect, please repeat procedure.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (989, 'standard', NOW(), 'La page a été modifiée : %s', 'Page has been modified : %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (990, 'standard', NOW(), '[Une erreur est survenue lors du traitement du contenu. Vérifier les pages :\r\n     Origine : %s\r\n     Destination : %s]', '[An error occured while copying contents, please check pages :\r\n     Original : %s\r\n     Destination : %s]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (991, 'standard', NOW(), '[Vérifier la correspondance des modèles : ils doivent etre identiques]', '[Verify the corresponding templates.\r\nThey must be identical!]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (992, 'standard', NOW(), 'Page à copier', 'Page to copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (993, 'standard', NOW(), 'Page de destination sélectionnée', 'Selected destination page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (994, 'standard', NOW(), 'Les zones modifiables ne sont pas concordantes.', 'Content management zones do not match in the templates.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (995, 'standard', NOW(), '[Les modèles sont identiques]', '[Templates are identical]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (996, 'standard', NOW(), '[Les rangées et les modèles ne sont pas concordants]', '[Style-rows do not match in the templates]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (997, 'standard', NOW(), 'Comparaison des modèles', 'Template compatibility');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (998, 'standard', NOW(), '[Modèle inutilisable]', '[Template cannot be used]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (999, 'standard', NOW(), 'Modules', 'Applications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1000, 'standard', NOW(), 'Rangées', 'Style-rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1001, 'standard', NOW(), 'Substitution de modèles', 'Replacement of Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1002, 'standard', NOW(), '[Les modèles de contenu ne sont pas concordants]', '[The templates do not match]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1003, 'standard', NOW(), 'Du modèle "%s" vers "%s" :', 'From template "%s" to "%s":');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1004, 'standard', NOW(), 'Confirmation', 'Confirmation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1005, 'standard', NOW(), 'Un modèle inactif ne peut être utilisé.', 'An inactive template cannot be used by a content provider.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1006, 'standard', NOW(), 'Afficher', 'Show');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1007, 'standard', NOW(), 'Tous les modèles', 'All templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1008, 'standard', NOW(), 'Modèles appartenant aux groupes', 'Selected Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1009, 'standard', NOW(), 'Afficher le(s) modèle(s) inactivé(s)', 'Include inactive templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1010, 'standard', NOW(), '[Aucun modèle à  afficher]', '[No templates correspond]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1011, 'standard', NOW(), '%s modèle(s) inactif(s) masqué(s).', '%s inactive template(s) exist.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1012, 'standard', NOW(), 'Gestion des rangées', 'Style-Rows management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1013, 'standard', NOW(), 'Visualisation de la rangée', 'Style-row preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1014, 'standard', NOW(), 'Modifier', 'Modify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1015, 'standard', NOW(), 'Redimensionner', 'Resize');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1016, 'standard', NOW(), 'Redimensionner l\'image', 'Image resizing');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1017, 'standard', NOW(), 'Cliquer sur l\'image à  l\'aide du bouton gauche de la souris.<br />Maintenir le bouton et déplacer la souris vers le coin gauche pour redimmensionner l\'image.<br />Une fois l\'image à  la taille désirée, relà¢cher le bouton. L\'image sera recompressée après validation.<br /><br />ATTENTION : agrandir une image la pixelise.', 'With the mouse, click on the image and with the button still pressed, move the mouse to resize the image. Once done, validate.<br />\r\nAttention, multiple resize actions can hinder the quality of the image!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1018, 'standard', NOW(), 'Annuler', 'Reinitialize');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1019, 'standard', NOW(), 'Type de lien', 'Link type');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1020, 'standard', NOW(), 'Interne', 'Internal');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1021, 'standard', NOW(), 'Externe', 'External');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1022, 'standard', NOW(), 'Ouverture', 'Open');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1023, 'standard', NOW(), 'Dans la fenêtre en cours', 'In the main window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1024, 'standard', NOW(), 'Dans une nouvelle fenêtre', 'In a new window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1025, 'standard', NOW(), 'Dans une fenêtre pop-up', 'In a pop-up window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1026, 'standard', NOW(), 'Cible du lien', 'Link target');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1027, 'standard', NOW(), 'Libellé du lien', 'Link label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1028, 'standard', NOW(), 'Largeur de la pop-up', 'Pop-up width');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1029, 'standard', NOW(), 'Hauteur de la pop-up', 'Pop-up height');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1030, 'standard', NOW(), '[La librairie de fonctions GD2 de PHP n\'est pas installée : les fonctionnalités de redimensionnement d\'image sont désactivées. Contacter l\'administrateur technique.]', '[PHP GD2 library is not present. Automne image resizing functionalities are disabled. Please contact your technical administrator]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1031, 'standard', NOW(), 'Arborescence des pages', 'List of all pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1033, 'standard', NOW(), 'Auteur', 'Author');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1034, 'standard', NOW(), 'Email de réponse', 'Reply-to email');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1035, 'standard', NOW(), 'Copyright', 'Copyright');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1036, 'standard', NOW(), 'Langue utilisée', 'Language used');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1037, 'standard', NOW(), 'Robots', 'Robots');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1038, 'standard', NOW(), 'Cache du navigateur', 'Browser cache');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1039, 'standard', NOW(), 'Redirection', 'Redirection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1040, 'standard', NOW(), 'Forcer la mise à  jour (balise Pragma en `no-cache`)', 'Force refresh setting (Pragma value) to `no-cache`');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1041, 'standard', NOW(), 'Balises meta courantes (visibles dans le code source de la page)', 'Common meta tags (visible in source code)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1042, 'standard', NOW(), 'Valeurs : <strong>all, index, follow, noindex, nofollow</strong><br />
Exemples :
<ul>
	<li><strong>index, follow</strong> : Je souhaite que ma page soit indexée et archivée par les moteurs de recherche et les archiveurs (comportement par défaut).</li>
	<li><strong>index, follow, noarchive</strong> : Je souhaite que ma page soit indexée mais pas archivée par les moteurs de recherche et les archiveurs.</li>
	<li><strong>noindex, nofollow, noarchive</strong> : Je souhaite que ma page ne soit ni indexée ni archivée par les moteurs de recherche et les archiveurs.</li>
</ul>', 'values : all, index, follow, noindex, nofollow');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1043, 'standard', NOW(), 'Données de référencement', 'Search enging referencing content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1044, 'standard', NOW(), 'Catégorie', 'Category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1045, 'standard', NOW(), 'Le fichier à  télécharger dépasse les limites autorisées par ce\r\nserveur : %s.', 'This file is too big. Server limits upload to %s.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1046, 'standard', NOW(), 'Copier la page', 'Copy page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1047, 'standard', NOW(), 'Sélectionner la section de destination', 'Select the destination section');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1048, 'standard', NOW(), 'Copie de page', 'Page copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1049, 'standard', NOW(), 'Sélectionner la page de destination dans l\'arborescence', 'Select the destination page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1050, 'standard', NOW(), 'Copier le contenu', 'Copy the content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1052, 'standard', NOW(), 'Impression', 'Printing');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1053, 'standard', NOW(), 'Gestion des zones modifiables imprimables', 'Printing zone management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1054, 'standard', NOW(), 'Sélectionner les zones modifiables et leur ordre d\'impression.', 'Select content management zones active on the print page and their order of appearance.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1055, 'standard', NOW(), 'Zones modifiables à  ne pas imprimer', 'Non-printed zones');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1056, 'standard', NOW(), 'Zones modifiables à  imprimer', 'Printed zones');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1057, 'standard', NOW(), 'Sélectionner', 'Select');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1058, 'standard', NOW(), 'Sélectionner', 'Add');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1059, 'standard', NOW(), 'Valider', 'Validate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1060, 'standard', NOW(), 'Effacer la file', 'Clear queue');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1061, 'standard', NOW(), 'Pages (ID)', 'Pages (ID)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1062, 'standard', NOW(), 'Lancé le', 'Launch Date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1063, 'standard', NOW(), 'Fichier PID', 'PID File');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1064, 'standard', NOW(), 'Présent', 'Present');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1065, 'standard', NOW(), 'Absent', 'Absent');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1066, 'standard', NOW(), 'Scripts en attente', 'Scripts pending');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1067, 'standard', NOW(), 'Scripts en cours', 'Scripts in progress');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1068, 'standard', NOW(), 'Pas de rangées', 'No rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1069, 'standard', NOW(), 'Effacer les enregistrements antérieurs au', 'Delete log before');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1070, 'standard', NOW(), 'Site', 'Website');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1071, 'standard', NOW(), 'Calendrier', 'Calendar');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1072, 'standard', NOW(), 'Statistiques', 'Statistics');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1073, 'standard', NOW(), 'Aide', 'Help');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1074, 'standard', NOW(), 'par', 'by');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1075, 'standard', NOW(), 'Gestion de page', 'Page administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1076, 'standard', NOW(), 'Site', 'Web Site');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1077, 'standard', NOW(), 'Impression active', 'Print page Active');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1078, 'standard', NOW(), 'Propriétés', 'Identity');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1079, 'standard', NOW(), 'Dates & alertes', 'Dates & Alerts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1080, 'standard', NOW(), 'Moteurs de recherche', 'Search engines');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1081, 'standard', NOW(), 'Balises meta', 'Meta Tags');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1082, 'standard', NOW(), 'Oui', 'Yes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1083, 'standard', NOW(), 'Non', 'No');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1084, 'standard', NOW(), 'Format : 0;url=http://domain.com', 'Format: 0;url=http://domain.com');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1085, 'standard', NOW(), 'Créer une nouvelle page', 'Create a new page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1086, 'standard', NOW(), 'Retourner aux propriétés', 'Return to properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1087, 'standard', NOW(), 'sous %s', 'under %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1088, 'standard', NOW(), 'Modification de modèle', 'Template Modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1089, 'standard', NOW(), 'Les modèles utilisent du code XHTML associé à  des tags Automne spécifiques à  votre site %s. Automne n\'utilisera pas du code non conforme à  l\'XHTML. <font color="red">Attention à  ne supprimer aucun tag \'&lt;atm-clientspace /&gt;\' sous peine de perdre le contenu associé !</font>', 'Templates use xHTML code associated with Automne tags specific to your site, %s. Automne will not use any xHTML non-conform<br />\r\n<font color="red">Attention, do not delete any tag \'&lt;atm-clientspace /&gt;\' or all associed content will be lost!</font>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1090, 'standard', NOW(), 'Tà¢ches', 'Task');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1091, 'standard', NOW(), 'Rechercher', 'Search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1092, 'standard', NOW(), 'Résultat', 'Result');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1093, 'standard', NOW(), 'Le navigateur utilisé est obsolète<br />et incompatible avec Automne 4.<br />
Pour une expérience optimale d\'Automne,<br />merci d\'employer une version plus récente :<br />
<ul>
	<li><a href="http://www.mozilla.com/firefox/" target="_blank">Mozilla - Firefox</a></li>
	<li><a href="http://www.google.com/chrome/" target="_blank">Google - Chrome</a></li>
	<li><a href="http://www.apple.com/fr/safari/" target="_blank">Apple - Safari</a></li>
	<li><a href="http://www.microsoft.com/ie/" target="_blank">Microsoft - Internet Explorer</a></li>
</ul>', 'Your navigator is obsolete...<br />
Please use a more recent version:<br />
<ul>
	<li><a href="http://www.mozilla.com/firefox/" target="_blank">Mozilla - Firefox</a></li>
	<li><a href="http://www.google.com/chrome/" target="_blank">Google - Chrome</a></li>
	<li><a href="http://www.apple.com/safari/" target="_blank">Apple - Safari</a></li>
	<li><a href="http://www.microsoft.com/ie/" target="_blank">Microsoft - Internet Explorer</a></li>
</ul>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1095, 'standard', NOW(), 'Remplacer le modèle de la page copiée par', 'Replace template?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1096, 'standard', NOW(), '[Impossible de remplacer le modèle, aucune correspondance trouvée]', '[Impossible to replace template, no match found]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1097, 'standard', NOW(), 'Annuler les modifications des propriétés de la page \'%s\' ?', 'Confirm cancelling property changes for page \'%s\' ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1098, 'standard', NOW(), 'Ou', 'Or');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (10008, 'standard', NOW(), 'L\'image est trop grande (> %s pixels)','Image is too wide (> %s pixels)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (10030, 'standard', NOW(), 'La démonstration suivante se limite aux actions de création et de modification de contenu ainsi qu\'à  la phase de validation. Pour tester Automne cà´té administration, vous devez télécharger le code source sur le site <a href="http://www.automne.ws" target="_blank" class="admin"><b>www.automne.ws</b></a>. N\'hésitez pas à  nous <a href="http://www.automne.ws/html/_77_.php" target="_blank" class="admin"><b>contacter</b></a> si vous avez des questions sur cette démonstration ou sur la faà§on dont Automne pourrait optimiser la gestion de vos sites.<br /><br /> Les contenus sont initialisés chaque dimanche. Si vous souhaitez tester les dates de publication, pensez à  ne pas dépasser la date du dimanche suivant à  minuit.\r\n', 'The following demo is limited to content addition and modification, including validation. To use Automne from an administrative perspective you must download the source code from <a href="http://www.automne.ws" target="_blank" class="admin"><b>www.automne.ws</b></a>. If you have further questions on this demo and on how Automne can help you manage your web sites, please <a href="http://www.automne.ws/html/_77_.php" target="_blank" class="admin"><b>contact us</b></a>.\r\n\r\nPlease note that all new content is erased every Sunday to renew the database. If you would like to test publication dates you must do so within the week ending on Sunday at midnight.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (10031, 'standard', NOW(), 'Aide', 'Help');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1099, 'standard', NOW( ), 'Adresse', 'Address');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1100, 'standard', NOW( ), 'Rangées par défaut', 'Default rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1101, 'standard', NOW( ), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1102, 'standard', NOW( ), 'Voir', 'View');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1103, 'standard', NOW( ), 'Administrer', 'Manage');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1104, 'standard', NOW( ), 'Modifier', 'Modify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1105, 'standard', NOW( ), 'Propriétés', 'Properties');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1106, 'standard', NOW( ), 'Identification', 'Identification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1107, 'standard', NOW( ), 'Modèles et rangées authorisés', 'Authorized templates and rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1108, 'standard', NOW( ), 'pour afficher un modèle, sélectionner tous les groupes auxquels il appartient', 'a template must belong to all the selected groups to be shown');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1109, 'standard', NOW( ), 'Editer', 'Edit');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1110, 'standard', NOW( ), 'Modification d\'un fichier de modèle', 'Modify a template file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1111, 'standard', NOW( ), 'Les feuilles de style utilisent du code CSS spécifique à  votre site %s. <br /> Attention, Toute modification peut entrainer des changements visuels sur l\'ensemble de votre site !', 'Style sheets use CSS code specific to your site %s.<br />Attention, Any modification can change the visual of all your site!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1112, 'standard', NOW( ), 'Base de Données', 'DataBase');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1113, 'standard', NOW( ), 'Aucun élément en attente de validation.', 'No validations pending.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1114, 'standard', NOW( ), 'Supprimer l\'accès au module', 'Delete module access');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1115, 'standard', NOW( ), 'Ordre', 'Order');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1116, 'standard', NOW( ), 'Désarchiver', 'Unarchive');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1117, 'standard', NOW( ), 'Tous les utilisateurs', 'All users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1118, 'standard', NOW( ), 'Tous les groupes', 'All groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1119, 'standard', NOW( ), 'Effacer le journal', 'Delete log');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1120, 'standard', NOW( ), 'Confirmer la suppression du journal ?', 'Confirm deletion request for log?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1121, 'standard', NOW( ), 'N° de page', 'Page number');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1122, 'standard', NOW( ), 'Actions d\'administration', 'Administration actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1123, 'standard', NOW( ), 'Toutes les actions', 'All actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1124, 'standard', NOW( ), 'Choisir un profil', 'Choose user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1125, 'standard', NOW( ), 'Sélection', 'Selection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1126, 'standard', NOW( ), 'En haut', 'On top');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1127, 'standard', NOW( ), 'En bas', 'On bottom');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1128, 'standard', NOW( ), 'Effacer le contenu', 'Clear content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1129, 'standard', NOW( ), 'Confirmer l\'effacement du contenu de ce bloc ?', 'Do you confirm content clear?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1130, 'standard', NOW( ), 'Modifier les rangées', 'Modify rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1131, 'standard', NOW( ), 'Supprimer la section', 'Delete section');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1132, 'standard', NOW( ), 'Choisissez...', 'Choose...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1133, 'standard', NOW( ), 'Modifier modèle d\'impression', 'Modify print template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1134, 'standard', NOW( ),'Non publié, à  archiver', 'Non published, pending archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1135, 'standard', NOW( ),'Non publié, archivage refusé', 'Non published, archiving refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1136, 'standard', NOW( ),'Non publié, archivé', 'Non published, archived');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1137, 'standard', NOW( ),'A archiver', 'Pending archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1138, 'standard', NOW( ),'Validation refusée', 'Archive validation refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1139, 'standard', NOW( ),'Archivé', 'Archived');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1140, 'standard', NOW( ),'A supprimer', 'Pending deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1141, 'standard', NOW( ),'Suppression refusée', 'Deletion refused ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1142, 'standard', NOW( ),'Supprimé', 'Deleted');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1143, 'standard', NOW( ),'Modifié, à valider', 'Modified, pending validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1144, 'standard', NOW( ),'Modifié, validation refusée','Modified, validation refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1145, 'standard', NOW( ),'Publié', 'Published');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1146, 'standard', NOW( ),'Non publié, à  supprimer', 'Non published, pending deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1147, 'standard', NOW( ),'Non pubié, suppression refusée', 'Non published, deletion refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1148, 'standard', NOW( ),'Non publié, supprimé', 'Non published, deleted');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1149, 'standard', NOW( ),'A dépublier', 'Pending un-publication');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1150, 'standard', NOW( ),'Dépublication refusée', 'Un-publication refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1151, 'standard', NOW( ),'Non publié','Un-published');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1152, 'standard', NOW( ),'Ordre des pages à valider', 'Order of pages pending validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1153, 'standard', NOW( ),'Ordre des pages validation refusée', 'Order of pages validation refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1154, 'standard', NOW( ),'Nouveau, à  archiver', 'New, pending archiving');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1155, 'standard', NOW( ),'Nouveau, archivage refusé', 'New, archiving refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1156, 'standard', NOW( ),'Nouveau, à  supprimer' , 'New, pending deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1157, 'standard', NOW( ),'Nouveau, suppression refusée', 'New, deletion refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1158, 'standard', NOW( ),'Nouveau, à valider', 'New, pending validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1159, 'standard', NOW( ),'Nouveau, validation refusée', 'New, validation refused');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1160, 'standard', NOW( ),'Largeur max : %s pixels. Vous pourrez redimensionner l\'image après son chargement.', 'Max width : %s pixels. You will be able to resize your image after his loading.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1161, 'standard', NOW( ),'Largeur mini : %s pixels', 'Min width : %s pixels');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1162, 'standard', NOW( ),'Votre image est trop petite, minimum : %s pixels de large.', 'Your image is too small, minimum width : %s pixels.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1163, 'standard', NOW( ),'Votre image est trop grande, maximum : %s pixels de large, veuillez utiliser la fonction de redimensionnement.', 'Your image is too big, maximum width : %s pixels, please use resize function.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1164, 'standard', NOW(), 'Editeur visuel Javascript (WYSIWYG)', 'Javascript Visual editor (WYSIWYG)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1165, 'standard', NOW(), 'Mise à  jour d\'Automne', 'Automne update');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1166, 'standard', NOW(), 'Fichier de mise à  jour', 'Update file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1167, 'standard', NOW(), 'Bavard', 'Verbose');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1168, 'standard', NOW(), 'Exécution forcée<br /><font color="red">(/!\\ Dangereux, ne cochez pas ceci si vous ne connaissez pas le fonctionnement interne d\'Automne /!\\)</font>', 'Force execution<br /><font color="red">(/!\\ Dangerous do not check this if you do not know internal Automne process /!\\)</font>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1169, 'standard', NOW(), 'Rapport de mise à  jour', 'Update report');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1170, 'standard', NOW(), 'Impossible de nettoyer le dossier temporaire, veuillez effacer le contenu de \'%s\' manuellement', 'Impossible to clean the temporary folder, please erase the contents of \'%s\' manually');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1171, 'standard', NOW(), 'Ligne de commande', 'Command line');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1172, 'standard', NOW(), 'Traitement du fichier', 'Treatment of the file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1173, 'standard', NOW(), 'Traitement des commandes', 'Treatment of commands');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1174, 'standard', NOW(), 'Mise à  jour', 'Update');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1175, 'standard', NOW(), '<font color="red">Attention, patcher Automne est un processus critique. Suivez scrupuleusement les indications et ne fermez pas votre navigateur avant la fin du processus.</font>', '<font color="red">Beware, Automne patching is a critical process. Follow indications scrupulously and do not close your navigator before the end of the process.</font>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1176, 'standard', NOW(), 'Cliquez pour finaliser l\'installation', 'Click to finalize installation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1177, 'standard', NOW(), 'Execution terminée', 'End of process');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1178, 'standard', NOW(), 'Ne finalisez pas l\'installation si des erreurs (en rouge) se sont produites. Si vous avez des erreurs, copiez-collez le rapport complet et envoyez le à  votre administrateur technique ou à  WS Interactive.', 'Do not finalize installation if errors (in red) occurred. If you have errors, copy-paste the full report and send it to your technical administrator or to WS Interactive.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1179, 'standard', NOW(), 'Etes-vous sur de vouloir finaliser l\'installation ?', 'Are you sure to want to finalize installation ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1180, 'standard', NOW(), 'Effectué', 'Done');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1181, 'standard', NOW(), 'Merci de ne pas fermer cette fenêtre.', 'Do not close this window.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1182, 'standard', NOW(), '[Une fenêtre pop-up à  tenté de s\'ouvrir sans succès.\nMerci de désactiver le système anti pop-up de votre navigateur pour ce site.]', '[A pop-up window attempted to open without success.\nThank you to deactivate the anti pop-up system of your browser for this site.]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1183, 'standard', NOW(), 'Sauvegarder le nouvel ordre', 'Save the new order');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1184, 'standard', NOW(), 'Cliquez pour corriger les erreurs', 'Click to correct errors');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1185, 'standard', NOW(), '[Erreur incorrigible. Patch Interrompu]', '[Incorrigible error. Patch Stopped]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1186, 'standard', NOW(), 'Valider et corriger l\'erreur suivante', 'Validate and correct next error');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1187, 'standard', NOW(), 'Valider la correction', 'Validate the correction');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1188, 'standard', NOW(), 'Fichier original protégé', 'Original protected file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1189, 'standard', NOW(), 'Fichier du patch', 'Patch file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1190, 'standard', NOW(), 'Collez ici le contenu du fichier mis à  jour', 'Paste here the contents of the file updated');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1191, 'standard', NOW(), 'Vous tentez de mettre à  jour un fichier qui a été modifié manuellement. Merci de reporter ces modifications dans le fichier contenu dans le patch.', 'You try to update a file which was modified manually. Thank you to defer these modifications in the file contained in the patch.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1192, 'standard', NOW(), 'Reprise du processus de mise à  jour après correction des erreurs', 'Patching process resume after errors correction');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1193, 'standard', NOW(), '[Le fichier que vous souhaitez importer est trop grand]', '[File to upload is too wide]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1194, 'standard', NOW(), 'Lister', 'List');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1195, 'standard', NOW(), 'Menu général', 'General Menu');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1196, 'standard', NOW(), 'Guide du rédacteur', 'User guide');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1197, 'standard', NOW(), 'Guide du développeur', 'Developer guide');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1198, 'standard', NOW(), 'Guide de l\'administrateur', 'Administrator guide');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1199, 'standard', NOW(), 'Guide d\'installation', 'Installation guide');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1200, 'standard', NOW(), 'Présentation d\'Automne', 'Automne presentation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1201, 'standard', NOW(), 'Démarrer avec Automne', 'Getting started');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1202, 'standard', NOW(), 'Multiples pages', 'Multiple pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1203, 'standard', NOW(), 'Une page', 'One page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1204, 'standard', NOW(), 'Format PDF', 'PDF Format');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1205, 'standard', NOW(), 'Seulement dans le langage par défaut', 'Only in default language');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1206, 'standard', NOW(), 'Gestion des catégories', 'Categories management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1207, 'standard', NOW(), 'Confirmez-vous la suppression de la catégorie %s', 'Do you confirm deletion of category %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1208, 'standard', NOW(), 'Racine des catégories', 'Categories root');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1209, 'standard', NOW(), 'Accès aux catégories pour le groupe \'%s\'', 'Access to categories for group \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1210, 'standard', NOW(), 'Gestion des accès au contenu des modules', 'Access management to modules content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1211, 'standard', NOW(), 'Administrer les catégories', 'Manage categories');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1212, 'standard', NOW(), 'Les libellés', 'Labels');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1213, 'standard', NOW(), 'Libellé en %s', 'Label in %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1214, 'standard', NOW(), 'Catégorie parente', 'Parent category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1215, 'standard', NOW( ), 'Nom distinctif (dn)', 'Distinguished Name (dn)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1216, 'standard', NOW(), '[Le dn (Distinguished Name) "%s" existe dejà ]', '[Sorry, the LDAP dn "%s" is already used]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1217, 'standard', NOW(), 'Gestion des accès par groupes d\'utilisateurs', 'Users groups categories access management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1218, 'standard', NOW(), 'Se souvenir de mon compte', 'Remember me');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1219, 'standard', NOW(), '<div class="rowComment">
	<h1>Titre ou sous-titre (255 charact&egrave;res max) :</h1>
	<div class="retrait"><span class="code">&lt;block module=&quot;standard&quot; type=&quot;varchar&quot; id=&quot;<span class="keyword">uniqueID</span>&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
	<ul>
	<li>
	<span class="keyword">uniqueID :</span>&nbsp;Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<ul>
	<li>
	<span class="vertclair">{{data}} :</span>&nbsp;Contenu textuel.</li></ul>
	</div>
	
	<h1>Texte mis en forme (HTML) :</h1>
	<div class="retrait"><span class="code">&lt;block module=&quot;standard&quot; type=&quot;text&quot; id=&quot;<span class="keyword">uniqueID</span>&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
	<ul>
	<li>
	<span class="keyword">uniqueID :</span>&nbsp;Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<ul>
	<li>
	<span class="vertclair">{{data}} :</span>&nbsp;Contenu mis en forme (HTML).</li></ul>
	</div>
	
	<h1>Image :</h1>
	<div class="retrait"><span class="code">&lt;block module=&quot;standard&quot; type=&quot;image&quot; id=&quot;<span class="keyword">uniqueID</span>&quot; maxWidth=&quot;<span class="keyword">value</span>&quot; minWidth=&quot;<span class="keyword">value</span>&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
	<ul>
	<li>
	<span class="keyword">uniqueID :</span>&nbsp;Identifiant unique du bloc dans la rang&eacute;e.</li>
	<li>
	<span class="keyword">value :</span>&nbsp;Valeur minimum ou maximum autoris&eacute;e pour l\'image en pixels. Les attributs maxWidth et minWidth sont optionnels.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<br/>
	<ul>
	<li><span class="vertclair">{{data}} :</span>&nbsp;Code de l\'image et lien vers l\'image zoom si elle existe.</li>
	<li><span class="vertclair">{{label}}</span> ou <span class="vertclair">{{linkLabel}} :</span>&nbsp;Nom / Légende de l\'image si il existe.</li>
	<li><span class="vertclair">{{jslabel}} :</span>&nbsp;Nom de l\'image  (&eacute;chapp&eacute; pour insertion dans du javascript ou un attribut de tag).</li>
	<li><span class="vertclair">{{imageZoomHtml}} :</span>&nbsp;Code HTML affichant l\'image zoom si elle existe.</li>
	<li><span class="vertclair">{{imagePath}} :</span>&nbsp;Répertoire de l\'image sur le serveur.</li>
	<li><span class="vertclair">{{imageName}} :</span>&nbsp;Nom du fichier image sur le serveur.</li>
	<li><span class="vertclair">{{imageZoomHref}} :</span>&nbsp;Adresse (répertoire et nom) du fichier Image zoom sur le serveur.</li>
	<li><span class="vertclair">{{imageZoomName}} :</span>&nbsp;Nom du fichier image zoom sur le serveur.</li>
	<li><span class="vertclair">{{imageWidth}} :</span>&nbsp;Largeur du fichier image sur le serveur.</li>
	<li><span class="vertclair">{{imageHeight}} :</span>&nbsp;Hauteur du fichier image sur le serveur.</li>
	<li><span class="vertclair">{{imageZoomWidth}} :</span>&nbsp;Largeur du fichier image zoom sur le serveur.</li>
	<li><span class="vertclair">{{imageZoomHeight}} :</span>&nbsp;Hauteur du fichier image zoom sur le serveur.</li>
	</ul>
	</div>
	
	<h1>Fichier - Pi&egrave;ce jointe :</h1>
	<div class="retrait"><span class="code">&lt;block module=&quot;standard&quot; type=&quot;file&quot; id=&quot;<span class="keyword">uniqueID</span>&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
	<ul>
	<li>
	<span class="keyword">uniqueID :</span>&nbsp;Identifiant unique du bloc dans la rang&eacute;e.</li></ul>
	Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<ul>
	<li>
	<span class="vertclair">{{data}} :</span>&nbsp;Lien vers le fichier si il existe.</li>
	<li>
	<span class="vertclair">{{href}} :</span>&nbsp;Adresse (URL) du fichier.
	</li>
	<li>
	<span class="vertclair">{{label}} :</span>&nbsp;Libell&eacute; du fichier.
	</li>
	<li>
	<span class="vertclair">{{jslabel}} :</span>&nbsp;Libell&eacute; du fichier (&eacute;chapp&eacute; pour insertion dans du javascript ou un attribut de tag).
	</li>
	<li>
	<span class="vertclair">{{size}} :</span>&nbsp;Taille du fichier en m&eacute;ga octets.
	</li>
	<li>
	<span class="vertclair">{{filename}} :</span>&nbsp;Nom du fichier.
	</li>
	<li>
	<span class="vertclair">{{originalfilename}} :</span>&nbsp;Nom original du fichier.
	</li>
	<li>
	<span class="vertclair">{{type}} :</span>&nbsp;Extention du fichier.
	</li>
	<li>
	<span class="vertclair">{{icon}} :</span>&nbsp;Icône de ce type de fichier si elle existe.
	</li>
	</ul>
	</div>
	
	<h1>Animation Flash :</h1>
	<div class="retrait"><span class="code">&lt;block module=&quot;standard&quot; type=&quot;flash&quot; id=&quot;<span class="keyword">uniqueID</span>&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
	<ul>
	<li>
	<span class="keyword">uniqueID :</span>&nbsp;Identifiant unique du bloc dans la rang&eacute;e.</li></ul>Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<br/>
	<ul>
	<li>
	<span class="vertclair">{{data}} :</span>&nbsp;Contenu de l\'animation flash.</li></ul>
	</div>
</div>', '<ol><li>Title or sub-title<br />&lt;block module="standard" type="varchar" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Free text<br />&lt;block module="standard" type="text" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Image<br />&lt;block module="standard" type="image" id="uniqueID"&gt;{{data}} and / or {{linkLabel}}&lt;/block&gt;<br />NB : Attributes maxWidth and minWidth enable you to control the width of the image for each block image.</li><li>File<br />&lt;block module="standard" type="file" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li><li>Flash Animation<br />&lt;block module="standard" type="flash" id="uniqueID"&gt;{{data}}&lt;/block&gt;</li></ol><b>uniqueID :</b> Unique identifier of the block for the row.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1220, 'standard', NOW(), 'Syntaxe des rangées pour le module \'%s\'', 'Rows syntax for the module \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1221, 'standard', NOW(), 'Syntaxe des modèles pour le module \'%s\'', 'Templates syntax for the module \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1222, 'standard', NOW(), '
<div class="rowComment">
	<h1>Titre de la page courante :</h1>
	<div class="retrait"><span class="code">&lt;atm-title /&gt;</span></div>
	<h1>M&eacute;ta-donn&eacute;es de la page courante :</h1>
	<div class="retrait"><span class="code">&lt;atm-meta-tags /&gt;</span>
	<br /><strong>Ce tag est obligatoire dans tous les modèles.</strong>
	</div>
	<h1>Valeur d\'une constante (voir les fichiers de constantes d\'Automne) :</h1>
	<div class="retrait"><span class="code">&lt;atm-constant name=&quot;<span class="keyword">constantName</span>&quot; /&gt;</span>
	<ul>
		<li>
			<span class="keyword">constantName :</span>&nbsp;Nom de la constante &agrave; afficher.
		</li>
	</ul>
	</div>
	<h1>Lien(s) vers une ou plusieur pages :</h1>
	<div class="retrait"><span class="code">&lt;atm-linx type=&quot;<span class="keyword">linxType</span>&quot;&gt;<span class="vertclair">linxDefinition</span>&lt;/atm-linx&gt;</span>
		<ul>
			<li>
				<span class="keyword">
					linxType :
				</span>
				&nbsp;Type de lien parmi :
				<ul>
					<li>
						<span class="keyword">
							direct :
						</span>
						&nbsp;Lien direct vers une page donn&eacute;e.
					</li>
					<li>
						<span class="keyword">
							sublinks :
						</span>
						&nbsp;Liens vers les sous pages de la page courante.
					</li>
					<li>
						<span class="keyword">
							desclinks :
						</span>
						&nbsp;Historique de navigation d\'une page &agrave; une autre.
					</li>
					<li>
						<span class="keyword">
							recursivelinks :
						</span>
						&nbsp;Arborescence de sous liens depuis une page donn&eacute;e.
					</li>
				</ul>
			</li>
			<li>
				<span class="vertclair">
					linxDefinition :
				</span>
				&nbsp;<a href="http://www.automne.ws/docs/" target="_blank">Voir la documentation Automne pour le d&eacute;tail</a>.
			</li>
		</ul>
	</div>
	<h1>Zone de contenu : Permet l\'affichage de rang&eacute;es de contenu :</h1>
	<div class="retrait"><span class="code">&lt;atm-clientspace module=&quot;standard&quot; id=&quot;<span class="keyword">uniqueID</span>&quot; /&gt;</span>
		<ul>
			<li>
				<span class="keyword">
					uniqueID :
				</span>
				&nbsp;Identifiant unique de la zone de contenu dans le mod&egrave;le.
			</li>
		</ul>
	</div>
	<h1>Lien vers la page d\'impression :</h1>
	<div class="retrait"><span class="code">&lt;atm-print-link keeprequest=&quot;<span class="keyword">true</span>&quot;&gt;<span class="vertclair">{{href}}</span>&lt;/atm-print-link&gt;</span>
	<ul>
		<li>
			<span class="vertclair">
				{{href}} :
			</span>
			&nbsp;Remplac&eacute; par le lien vers la page imprimable.
		</li>
		<li>
			<span class="keyword">
				Attribut keeprequest :
			</span>
			&nbsp;Optionnel, permet de conserver les attributs GET avec lesquels la page à imprimer est appelée (defaut : false)
		</li>
	</ul>
	</div>
	<h1>Date de dernière mise à jour :</h1>
	<div class="retrait"><span class="code">&lt;atm-last-update format=&quot;<span class="keyword">d-m-Y</span>&quot;&gt;<span class="vertclair">{{date}} {{firstname}} {{lastname}}</span>&lt;/atm-last-update&gt;</span>
	<ul>
		<li>
			<span class="vertclair">
				{{date}} :
			</span>
			&nbsp;Date de la dernière mise à jour du contenu de la page. Le format de la date à afficher est donné par l\'attribut <span class="keyword">format</span> du tag.
		</li>
		<li>
			<span class="vertclair">
				{{firstname}} :
			</span>
			&nbsp;Prénom de la personne responsable de la dernière mise à jour.
		</li>
		<li>
			<span class="vertclair">
				{{lastname}} :
			</span>
			&nbsp;Nom de la personne responsable de la dernière mise à jour.
		</li>
	</ul>
	</div>
	<h1>Fichiers Javascripts de la page :</h1>
	<div class="retrait"><span class="code">&lt;atm-js-tags files=&quot;<span class="keyword">/js/js1.js,/js/js2.js</span>&quot; /&gt;</span>
		<ul>
			<li>
				<span class="keyword">
					Attribut files :
				</span>
				&nbsp;Fichiers javascript à inclure dans la page (séparés par des virgules).
				<br/>
					Les fichiers ainsi listés seront concaténés et compressés avant d\'être servi à l\'internaute. Une gestion avancée du cache sur le navigateur de l\'internaute est employé.
			</li>
		</ul>
	</div>
	<h1>Feuilles de styles CSS de la page :</h1>
	<div class="retrait"><span class="code">&lt;atm-css-tags files=&quot;<span class="keyword">/css/css1.css,/css/css2.css</span>&quot; /&gt;</span>
		<ul>
			<li>
				<span class="keyword">
					Attribut files :
				</span>
				&nbsp;Feuilles de styles CSS à inclure dans la page (séparés par des virgules).
				<br/>
					Les fichiers ainsi listés seront concaténés et compressés avant d\'être servi à l\'internaute. Une gestion avancée du cache sur le navigateur de l\'internaute est employé. Seul le média <span class="keyword">screen</span> est concerné pour ces fichiers.
			</li>
		</ul>
	</div>
	<h1>Identifiant de la page :</h1>
	<div class="retrait"><span class="code"><span class="keyword">{{pageID}}</span></span>
	<ul>
		<li>
			<span class="keyword">
				{{pageID}} :
			</span>
			&nbsp;Remplacé par l\'identifiant de la page en cours.
		</li>
	</ul>
	</div>
</div>', '<ol>\r\n<li>\r\n	Title of the current page:<br />\r\n	&lt;atm-title /&gt;\r\n</li>\r\n<li>\r\n	Metadata of the current page:<br />\r\n	&lt;atm-meta-tags /&gt;\r\n</li>\r\n<li>\r\n	Value of a constant (see Automne constants files):<br />\r\n	&lt;atm-constant name="constantName" /&gt;<br />\r\n	<b>constantName :</b> Name of the constant to display.\r\n</li>\r\n<li>\r\n	link(s) to one or several pages:<br />\r\n	&lt;atm-linx type="linxType"&gt;linxDefinition&lt;/atm-linx&gt;<br />\r\n	<b>linxType :</b> link type between:\r\n	<ul>\r\n		<li>\'direct\' : Direct link to a given page.</li>\r\n		<li>\'sublinks\' : Links to subpages of the current page.</li>\r\n		<li>\'desclinks\' : Navigation history from a page to another.</li>\r\n		<li>\'recursivelinks\' : Tree structure of sublinks from a given page.</li>\r\n	</ul>\r\n	<b>linxDefinition :</b> See Automne documentation for the detail.\r\n</li>\r\n<li>\r\n	Content zone : Alow use of content rows :<br />\r\n	&lt;atm-clientspace module="standard" id="uniqueID" /&gt;<br />\r\n	<b>uniqueID :</b> Unique identifier of the content zone for the template.\r\n</li>\r\n<li>\r\n	Link to the printable page :<br />\r\n	&lt;atm-print-link&gt;{{href}}&lt;/atm-print-link&gt;<br />\r\n	<b>{{href}} :</b> will be replaced by the link to the printable page.\r\n</li>\r\n</ol>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1223, 'standard', NOW(), 'Catégorie supprimée', 'Deleted category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1224, 'standard', NOW(), 'Gestion des Applications', 'Manage Applications');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1225, 'standard', NOW(), 'Application à éditer', 'Edit application');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1226, 'standard', NOW(), 'Objet à éditer', 'Edit object');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1227, 'standard', NOW(), 'Objets', 'Objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1228, 'standard', NOW(), 'Application', 'Application');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1229, 'standard', NOW(), 'Edition / création d\'un objet', 'Edit / create object');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1230, 'standard', NOW(), 'Ressource', 'Ressource');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1231, 'standard', NOW(), 'Ressource primaire', 'Primary resource');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1232, 'standard', NOW(), 'Ressource secondaire', 'Secondary resource');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1233, 'standard', NOW(), '<ul><li>Aucune : Cet objet ne sera pas soumis à validation. Son contenu apparaîtra en ligne dès sa saisie. Toute modification sera immédiate.</li><li>Ressource primaire : Ce type d\'objet est soumis à validation. Son contenu n\'apparaîtra en ligne qu\'après validation par une personne autorisée.</li><li>Ressource secondaire : Ce type d\'objet est soumis à la validation de la ressource primaire. Son contenu n\'apparaîtra en ligne qu\'après validation de la ressource primaire à laquelle il est directement attaché. Sans attache à une ressource primaire, il se comportera de la même manière qu\'un objet sans ressource.</li></ul>', '<ul><li>None : This object will not be subjected to validation. Its contents will appear on line as of its seizure.</li><li>Primary resource : This type of object is subjected to validation. Its contents will appear on line only after validation by an authorized person.</li><li>Secondary resource : This type of object is subjected to the validation of the primary resource. Its contents will appear on line only after validation of the primary resource to which it is attached. Without attach to a primary resource, it will have the same behavior of an object without resource.</li></ul>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1234, 'standard', NOW(), 'Objet', 'Object');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1235, 'standard', NOW(), 'Champs', 'Fields');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1236, 'standard', NOW(), 'Champ', 'Field');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1237, 'standard', NOW(), 'Edition / création d\'un champ de données pour l\'objet \'%s\'', 'Edit / create data field for object \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1238, 'standard', NOW(), 'Type de données', 'Data type');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1239, 'standard', NOW(), 'Champ requis', 'Required field');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1240, 'standard', NOW(), 'Visible coté client', 'Available in frontend');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1241, 'standard', NOW(), 'Visible dans les résultats d\'une recherche', 'Available in search results');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1242, 'standard', NOW(), 'Ajouter au formulaire de recherche<br /><small>(ou effectuer la recherche par mot-clé sur ce champ)</small>', 'Add to search form<br /><small>(or search by keyword on this field)</small>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1243, 'standard', NOW(), 'Paramètres', 'Parameters');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1244, 'standard', NOW(), 'Multiples', 'Multiples');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1247, 'standard', NOW(), 'Objets simples', 'Standard objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1248, 'standard', NOW(), 'Objets composés', 'Made up objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1267, 'standard', NOW(), 'Associer', 'Associate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1268, 'standard', NOW(), 'Désassocier', 'Disassociate ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1271, 'standard', NOW(), 'Visible sur l\'accueil du module ?', 'Visible on the index of the module?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1276, 'standard', NOW(), 'Pour les administrateurs seulement', 'Only for administrators');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1277, 'standard', NOW(), 'Confirmez-vous la suppression du champ \'%s\' ? Attention cette suppression est définitive, elle n\'est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce champ !', 'Do you confirm the deletion of the field \'%s\'? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this field!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1278, 'standard', NOW(), '[Erreur durant la suppression du champ]', '[Error during field deletion]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1279, 'standard', NOW(), 'Structure', 'Structure');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1280, 'standard', NOW(), 'Structure de l\'objet \'%s\'', '\'%s\' object structure');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1281, 'standard', NOW(), 'Utilisation de l\'objet par d\'autres objets', 'Use of the object by other objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1282, 'standard', NOW(), 'Oui par', 'Yes by');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1283, 'standard', NOW(), 'Confirmez-vous la suppression de l\'objet \'%s\' ?', 'Do you confirm deletion of the object \'%s\'?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1283, 'standard', NOW(), '[Erreur durant la suppression de l\'objet]', '[Error during object deletion]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1284, 'standard', NOW(), 'Cliquez pour choisir une date', 'Clic to pick a date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1292, 'standard', NOW(), 'Les informations grisées nécessiteront une recherche récursive.', 'Grayed informations will require a recursive search.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1293, 'standard', NOW(), '[Erreur : vous n\'avez pas les droits suffisant sur le module \'%s\' pour lui ajouter une rangée.]', '[Error: you do not have sufficient rights on the module \'%s\' to add a row to it.]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1294, 'standard', NOW(), 'Libellé composé', 'Made up label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1295, 'standard', NOW(), 'Attribut \'module\' manquant sur un tag \'block\'', 'Missing \'module\' attribute on \'block\' tag');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1296, 'standard', NOW(), '[Erreur : syntaxe de rangée incorrecte : %s]', '[Error : malformed row syntax : %s]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1297, 'standard', NOW(), 'Syntaxe du libellé pour l\'objet \'%s\'', 'Label syntax for object \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1298, 'standard', NOW(), 'Accès des fichiers', 'Files accesses');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1299, 'standard', NOW(), 'Modèles compatibles', 'Matching templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1300, 'standard', NOW(), 'Modèles non compatibles', 'Unmatching templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1301, 'standard', NOW(), 'Attention, l\'utilisation d\'un modèle incompatible peut entraîner la perte des données de la page.', 'Attention, using an unmatching template can involve the loss of all data of the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1302, 'standard', NOW(), 'vers', 'to');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1303, 'standard', NOW(), 'page', 'page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1304, 'standard', NOW(), 'Gestion de l\'application \'%s\'', '\'%s\' application management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1305, 'standard', NOW(), 'Création d\'une application', 'Application creation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1306, 'standard', NOW(), 'Identifiant (Codename)', 'ID (Codename)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1307, 'standard', NOW(), 'Maximum 20 caractères alphanumériques (a-z0-9) uniquement', 'Maximum 20 alphanumerics caracters (a-z0-9) only');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1308, 'standard', NOW(), '[Erreur : cet identifiant est déjà utilisé]', '[Error : this ID already used]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1309, 'standard', NOW(), 'Le module est créé mais certaines erreurs se sont produites lors de la création des répertoires du module.\nVérifiez que les répertoires suivants existent et sont accessible en écriture :\n%s,\n%s,\n%s,\n%s', 'Module is created but some errors append for module directories creation.\nPlease check following directories exists and are writable :\n%s,\n%s,\n%s,\n%s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1310, 'standard', NOW(), 'L\'utilisateur %s fait parti du groupe %s. Modifier directement ses droits enlèvera l\'utilisateur de ce groupe. Etes-vous sur de vouloir continuer ?', '%s user makes party of the group %s. Modify its rights directly will remove the user of this group. Do you want to continue?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1311, 'standard', NOW(), 'Vous n\'avez aucun droits d\'utilisation sur aucun modèles de pages.', 'You do not have any rights of use on any pages templates.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1312, 'standard', NOW(), 'Vous ne pouvez créer de nouvelle page : Vous n\'avez aucun droits d\'utilisation sur aucun modèles de pages.', 'You cannot create of new page: You do not have any rights of use on any pages templates.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1313, 'standard', NOW(), 'Maximiser la fenêtre d\'administration', 'Maximize administration window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1314, 'standard', NOW(), 'Minimiser la fenêtre d\'administration', 'Minimize administration window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1315, 'standard', NOW(), 'Fermer la fenêtre d\'administration', 'Close administration window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1316, 'standard', NOW(), 'Administrer la page', 'Page administration');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1317, 'standard', NOW(), 'Cochez pour mettre à jour l\'adresse de la page (en fonction du titre donné à la page.)', 'Check to update page URL (Page URL will be updated using page title.)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1318, 'standard', NOW(), 'Adresse de la page en ligne. Vous pouvez la mettre à jour si vous modifiez le titre de la page mais attention ! Changer l\'adresse de la page peut entraîner des problèmes de référencement sur les moteurs de recherche ainsi que des problèmes si d\'autres sites lient cette page.', 'Address of this page online. You can update it if you change the title of the page but attention! If you Change page URL, this can cause problems of referencing on search engines and problems if other sites links to this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1319, 'standard', NOW(), '[La page de destination sélectionnée est déjà la page mère actuelle de la page à déplacer ...]', '[The destination page selected is already the mother page of the page to move...]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1320, 'standard', NOW(), 'Verrouillé', 'Locked');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1321, 'standard', NOW(), 'Chargement ...', 'Loading...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1322, 'standard', NOW(), 'Contenu / Rangées', 'Content / Rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1323, 'standard', NOW(), 'Confirmez-vous la suppression de l\'objet \'%s\' ?', 'Do you confirm deletion of the object \'%s\'?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1324, 'standard', NOW(), 'Confirmez-vous la sortie sans sauvegarder ?', 'Do you confirm exit without saving?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1325, 'standard', NOW(), 'Libellé du lien', 'Link label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1326, 'standard', NOW(), 'Scripts restants', 'Remaining scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1327, 'standard', NOW(), 'Meta données par défaut pour le site :', 'Default meta datas for website:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1328, 'standard', NOW(), 'Page', 'Page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1329, 'standard', NOW(), 'Maximum %so', 'Maximum %sB');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1330, 'standard', NOW(), 'Rafraîchir', 'Refresh');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1331, 'standard', NOW(), 'Stopper scripts', 'Stop scripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1332, 'standard', NOW(), 'Consulter l\'aide en ligne', 'View online help');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1333, 'standard', NOW(), 'Modèles', 'Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1334, 'standard', NOW(), 'Rangées', 'Rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1335, 'standard', NOW(), 'Les rangées de page appartiennent à un ou plusieurs groupes de rangées. Pour utiliser une rangée, un utilisateur doit avoir des droits sur tous les groupes de cette rangée.', 'Each row belong to one or more groups. For a user to be able to use a row, he or she must have usage rights for ALL the groups to which that row belongs to.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1336, 'standard', NOW(), 'Aucun groupe', 'No group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1337, 'standard', NOW(), '[Modification des groupes de rangées interdits]', '[Modification of unauthorized rows groups]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1338, 'standard', NOW(), 'Inverser', 'Invert');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1339, 'standard', NOW(), 'Profondeur affichée', 'Displayed depth');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1340, 'standard', NOW(), 'Visualisation des objets associés', 'Viewing associated objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1341, 'standard', NOW(), 'Edition des objets associés', 'Edit associated objects');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1342, 'standard', NOW(), 'Gestion des catégories', 'Categories management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1343, 'standard', NOW(), 'Favicon', 'Favicon');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1344, 'standard', NOW(), 'Valeur : /favicon.ico ou /img/favicon.png, etc.', 'Value : /favicon.ico or /img/favicon.png, ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1345, 'standard', NOW(), 'Module', 'Application');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1346, 'standard', NOW(), 'Accès aux pages pour le groupe \'%s\'', 'Pages access for group \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1347, 'standard', NOW(), 'Accès aux pages pour l\'utilisateur \'%s\'', 'Pages access for user \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1348, 'standard', NOW(), 'Racine des pages', 'Pages root');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1349, 'standard', NOW(), 'Voir les accès au contenu des modules', 'View accesses to modules content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1350, 'standard', NOW(), 'Accès aux catégories pour l\'utilisateur \'%s\'', 'Access to categories for user \'%s\'');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1351, 'standard', NOW(), 'Cet utilisateur appartient à un ou plusieurs groupes d\'utilisateurs, ses droits dépendent de son appartenance à ces groupes d\'utilisateurs.', 'This user belongs to one or more user groups, his rights depend on his membership of these user groups.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1352, 'standard', NOW(), 'Plusieurs sites peuvent partager le même domaine. Dans ce cas, le premier dans la liste ci-dessous sera prioritaire : Il s\'affichera pour cette adresse de domaine.', 'Several websites can share the same domain. In this case, the first in the list below will have priority: It will be shown for this domain address.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1353, 'standard', NOW(), '[Erreur lors du réordonancement des sites ...]', '[Error during websites reorder...]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1354, 'standard', NOW(), 'Protéger les fichiers à télécharger.', 'Protect download files.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1355, 'standard', NOW(), 'Avec cette option active pour le module, les fichiers à télécharger (fichiers PDF, images, etc.) seront filtrés avant tout téléchargement. Si des droits sont nécessaires à leur consultation, l\'accès en sera interdit à toute personne n\'ayant pas les autorisations suffisantes. De plus, le nom du fichier sera systématiquement nettoyé des données de contrôles ajoutées par Automne. Activer cette option entraîne une charge plus importante sur le serveur pour tous les téléchargements. Ne l\'activez que si le besoin est réel.', 'With this option active for the module, the files to be downloaded (PDF files, images, etc) will be filtered before any downloading. If rights are necessary to their consultation, the access will be forbidden to any person not having the sufficient clearance. Moreover, the name of the file will be systematically cleaned of controls datas added by Automne. Activating this option involves a more important load on the server for all the downloading. Activate it only if the need is real.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1356, 'standard', NOW(), 'Code Source', 'Source code');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1357, 'standard', NOW(), 'Edition pleine page', 'Edition fit window');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1358, 'standard', NOW(), 'Prévisualisation', 'Preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1359, 'standard', NOW(), 'Modèles', 'Template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1360, 'standard', NOW(), 'Couper', 'Cut');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1361, 'standard', NOW(), 'Copier', 'Copy');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1362, 'standard', NOW(), 'Coller', 'Paste');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1363, 'standard', NOW(), 'Coller comme texte seul', 'Paste as plain text');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1364, 'standard', NOW(), 'Coller depuis Word', 'Paste from Word');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1365, 'standard', NOW(), 'Imprimer', 'Print');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1366, 'standard', NOW(), 'Annuler', 'Undo');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1367, 'standard', NOW(), 'Refaire', 'Redo');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1368, 'standard', NOW(), 'Chercher', 'Search');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1369, 'standard', NOW(), 'Remplacer', 'Replace');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1370, 'standard', NOW(), 'Tout sélectionner', 'Select All');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1371, 'standard', NOW(), 'Supprimer le format', 'Remove format');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1372, 'standard', NOW(), 'Gras', 'Bold');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1373, 'standard', NOW(), 'Italique', 'Italic');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1374, 'standard', NOW(), 'Souligner', 'Underline');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1375, 'standard', NOW(), 'Barrer', 'Strike Through');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1376, 'standard', NOW(), 'Indice', 'Subscript');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1377, 'standard', NOW(), 'Exposant', 'Superscript');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1378, 'standard', NOW(), 'Liste Ordonnée', 'Ordered List');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1379, 'standard', NOW(), 'Liste non-ordonnée', 'Unordered List');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1380, 'standard', NOW(), 'Diminuer le retrait', 'Outdent');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1381, 'standard', NOW(), 'Augmenter le retrait', 'Indent');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1382, 'standard', NOW(), 'Aligner à gauche', 'Justify Left');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1383, 'standard', NOW(), 'Centrer', 'Center');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1384, 'standard', NOW(), 'Aligner à droite', 'Justify Right');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1385, 'standard', NOW(), 'Justifier', 'Justify');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1386, 'standard', NOW(), 'Insérer / modifier un lien', 'Add / Edit link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1387, 'standard', NOW(), 'Supprimer un lien', 'Remove link');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1388, 'standard', NOW(), 'Insérer / modifier une ancre', 'Add / Edit anchor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1389, 'standard', NOW(), 'Insérer / modifier une Image', 'Add / Edit image');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1390, 'standard', NOW(), 'Insérer / modifier un tableau', 'Add / Edit table');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1391, 'standard', NOW(), 'Insérer un séparateur', 'Add rule');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1392, 'standard', NOW(), 'Insérer un caractère spécial', 'Add a special char');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1393, 'standard', NOW(), 'Style de mise en forme', 'Format style');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1394, 'standard', NOW(), 'Format du texte', 'Text format');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1395, 'standard', NOW(), 'Taille du texte', 'Text size');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1396, 'standard', NOW(), 'Couleur du texte', 'Text color');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1397, 'standard', NOW(), 'Couleur de fond', 'Background color');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1398, 'standard', NOW(), '---------------------------------', '---------------------------------');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1399, 'standard', NOW(), 'Editeur WYSIWYG', 'WYSIWYG Editor ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1400, 'standard', NOW(), 'Gestion des barres d\'outils de l\'éditeur visuel (WYSIWYG)', 'Visual editor (WYSIWYG) toolbars management');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1401, 'standard', NOW(), 'Confirmez-vous la suppression de la barre d\'outil sélectionnée ?', 'Do you confirm the deletion of the selected toolbar?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1402, 'standard', NOW(), 'Eléments', 'Elements');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1403, 'standard', NOW(), 'Liens internes', 'Internal links');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1404, 'standard', NOW(), 'Barre d\'outils', 'Toolbar');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1405, 'standard', NOW(), 'Relations', 'Relations');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1406, 'standard', NOW(), 'Pages relationnelles', 'Relationnal pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1407, 'standard', NOW(), 'Pages liées', 'Linked pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1408, 'standard', NOW(), 'Aucun résultat.', 'No result.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1409, 'standard', NOW(), 'Liste des pages', 'Pages list');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1410, 'standard', NOW(), 'liant la page %s', 'which target the page %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1411, 'standard', NOW(), 'liées par la page %s', 'targets by the page %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1412, 'standard', NOW(), 'utilisant les mots clés %s', 'using keywords %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1413, 'standard', NOW(), 'et', 'and');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1414, 'standard', NOW(), 'Attention, cette page est liée par %s pages, voulez vous vraiment supprimer la page "%s" ?', 'Warning, this page is linked by %s pages, do you really want to delete the page "%s" ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1415, 'standard', NOW(), 'ou', 'or');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1416, 'standard', NOW(), 'utilisant les identifiants %s', 'using identifiers %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1417, 'standard', NOW(), '%s page(s) lient cette page.', '%s page(s) targets this page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1418, 'standard', NOW(), 'Cette page lie %s page(s).', 'This page targets %s page(s).');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1419, 'standard', NOW(), '[Erreur, le code XHTML n\'est pas conforme à la syntaxe attendue. Merci de le corriger (%s)]', '[Error, XHTML code does not conform to the expected syntax. Please correct it (%s)]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1420, 'standard', NOW(), 'Destination', 'Destination');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1421, 'standard', NOW(), 'Edition du contenu en cours', 'Content edition in progress');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1422, 'standard', NOW(), 'Soumettre à Validation', 'Submit for Validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1423, 'standard', NOW(), 'Sauvegarder le contenu', 'Save content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1424, 'standard', NOW(), 'Effacer le contenu', 'Delete content');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1425, 'standard', NOW(), 'Confirmer la suppression du contenu ?', 'Confirm content deletion?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1426, 'standard', NOW(), 'Voir le contenu', 'Content preview');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1427, 'standard', NOW(), 'Enregistrer et Quitter', 'Save and Quit');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1428, 'standard', NOW(), 'Edition du contenu', 'Content edition');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1429, 'standard', NOW(), 'Suppression du contenu', 'Content deletion');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1430, 'standard', NOW(), 'Soumission à validation', 'Submission to validation');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1431, 'standard', NOW(), 'Ce libellé servira à constituer l\'adresse URL du site. Seuls les caractères alphanumériques sont acceptés.', 'This label will be used to create the website URL. Only aphanumerics caracters are allowed.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1432, 'standard', NOW(), 'Une branche', 'A branch');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1433, 'standard', NOW(), 'Sélection de la branche à régénérer', 'Select a branch to regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1434, 'standard', NOW(), 'Sélectionner la page racine de la branche à régénérer', 'Select the root page of the branch to regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1435, 'standard', NOW(), 'utilisant les modèles %s', 'using templates %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1436, 'standard', NOW(), 'utilisant le modèle %s', 'using template %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1437, 'standard', NOW(), 'utilisant la rangée %s', 'using row %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1438, 'standard', NOW(), 'utilisant les rangées %s', 'using rows %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1439, 'standard', NOW(), 'Utilisateurs du groupe "%s"', '"%s" group users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1440, 'standard', NOW(), 'Voir les pages', 'See pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1441, 'standard', NOW(), 'Aucun utilisateur n\'est associé à ce groupe', 'No users associate to this group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1442, 'standard', NOW(), 'Cocher cette case pour que les utilisateurs n\'aient pas les droits sur ces nouveaux groupes', 'If you check this box, no users have rights to these new groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1443, 'standard', NOW(), 'actif', 'active');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1444, 'standard', NOW(), 'inactif', 'inactive');
#Start v4 messages
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1445, 'standard', NOW(), 'Création d\'un groupe', 'Create a group');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1446, 'standard', NOW(), 'Cette fenêtre vous permet de consulter et modifier le profil d\'un groupe d\'utilisateurs. En associant un groupe à un ensemble d\'utilisateurs vous pouvez centraliser les droits de cet ensemble d\'utilisateurs.', 'This window allows you to view and change the profile of a user group. By combining a group to a set of users you can centralize the rights of this group of users.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1447, 'standard', NOW(), 'Vous ne pouvez supprimer un groupe qui possède des utilisateurs.', 'You can not delete a group that has users.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1448, 'standard', NOW(), 'Ce droit permet d\'autoriser la duplication d\'une branche de pages.', 'This right give the permission to duplicate a pages branch.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1449, 'standard', NOW(), 'Vous pouvez utiliser des groupes pour catégoriser votre modèle de page. Vous pourrez ainsi simplifier sa sélection mais aussi associer des droits aux utilisateurs sur ces groupes. Ceci permettra de limiter l\'usage de certains modèles spécifiques à certains profils d\'utilisateurs.', 'You can use groups to categorize your page template. You can simplify the selection, but also involve rights to users on these groups. This will limit the use of certain model-specific user profiles.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1450, 'standard', NOW(), 'Modèle de page :', 'Page Template:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1451, 'standard', NOW(), 'Création d\'un modèle de page', 'Creating a page template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1452, 'standard', NOW(), 'Impression', 'Print');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1453, 'standard', NOW(), 'Sélectionnez les zones de contenu du modèle que vous souhaitez voir apparaitre dans la page d\'impression. Choisissez aussi l\'ordre d\'affichage de ces zones de contenu.', 'Select the content areas of the template you want to appear in the page printed. Also choose the display order of these content areas.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1454, 'standard', NOW(), 'Zones de contenu imprimables', 'Printable Content Areas');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1455, 'standard', NOW(), 'Séléctionnés', 'Selected');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1456, 'standard', NOW(), 'Cette page vous permet de créer et modifier un modèle de page. Les modèles de page servent de base à la création des pages du site.', 'This page allows you to create and edit a page template. Page templates provide the basis for the creation of the site\'s pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1457, 'standard', NOW(), 'Vous pouvez ajouter un ou plusieurs nouveaux groupes au modèle de page en cours. Le nom du groupe ne doit contenir que des caractères alphanumériques. Les groupes doivent être séparés par des virgules ou des point-virgules.', 'You can add one or more new groups to the model page. The name of the group must only contain alphanumeric characters. Groups must be separated by commas or semi-colons.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1458, 'standard', NOW(), 'En cochant cette case, aucun utilisateur ne pourra voir ou utiliser ce modèle tant qu\'ils n\'auront pas les droits sur les nouveaux groupes ajoutés ci-dessus.', 'By checking this box, no users can see or use this model until they have the rights to the new groups added above.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1459, 'standard', NOW(), 'Ne pas donner les droits de voir ces nouveaux groupes aux utilisateurs.', 'Do not give the rights to see these new groups to users.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1460, 'standard', NOW(), 'Sélectionnez les sites pour lesquels l\'utilisation de ce modèle de page sera possible.', 'Select sites for which the use of this page template is possible.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1461, 'standard', NOW(), 'Sites', 'Websites');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1462, 'standard', NOW(), 'Utilisez une vignette représentant le visuel du modèle de page pour permettre une selection plus aisée.', 'Use a thumbnail representing the visual page template to allow for easier selection.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1463, 'standard', NOW(), 'Vignette', 'Thumbnail');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1464, 'standard', NOW(), 'Vous pouvez utiliser un fichier XML pour importer la définition XML à employer pour ce modèle de page.', 'You can use an XML file to import the XML to be used for this page template.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1465, 'standard', NOW(), 'Fichier XML ...', 'XML File...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1466, 'standard', NOW(), 'Vous pouvez modifier ici la structure XML de ce modèle. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, ne supprimez ni ne modifiez pas de tag &lt;atm-clientspace&gt; sous peine de perdre du contenu sur les pages employant déjà le modèle en cours.', 'You can change the structure of the XML model. You must follow the XML standard under penalty of error.<br /><strong>Warning</strong>, nor delete or change tag &lt;atm-clientspace&gt; without losing content on the pages using already the current model.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1467, 'standard', NOW(), 'Rangées par défaut', 'Default rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1468, 'standard', NOW(), 'Aide à la syntaxe des modèles', 'Help with syntax models');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1469, 'standard', NOW(), 'Cette fenêtre regroupe les différentes aides nécessaire à la création de modèles pour chacun des modules.', 'This window lists all the various aids necessary to construct models for each module.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1470, 'standard', NOW(), 'Edition du modèle d\'impression des pages', 'Edition of the model for printing pages');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1471, 'standard', NOW(), 'Cette page vous permet de créer et modifier le modèle d\'impression employé pour les pages. Ce modèle sert à créer une version spécifique pour l\'impression des différentes pages des sites.', 'This page allows you to create and edit the template used to print the pages. This model is used to create a specific version for printing on different pages of the sites.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1472, 'standard', NOW(), 'Vous pouvez modifier ici la structure XML de ce modèle. Vous devez respecter la norme XML sous peine d\'erreur.<br /><strong>Attention</strong>, les tags atm-clientspace ne fonctionnent pas pour ce modèle, utilisez <strong>{{data}}</strong> pour préciser l\'endroit ou vous souhaitez que le contenu de la page apparaisse.', 'You can change the structure of the XML model. You must follow the XML standard under penalty of error.<br /><strong>Warning</strong> tags &lt;atm-clientspace&gt; does not work for this model, use <strong>{{data}}</strong> to specify where you want the content of the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1473, 'standard', NOW(), 'Modèles de pages', 'Page Templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1474, 'standard', NOW(), 'Modèles de rangées', 'Template rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1475, 'standard', NOW(), 'Feuilles de styles', 'Stylesheets');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1476, 'standard', NOW(), 'Scripts Javascripts', 'Scripts JavaScripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1477, 'standard', NOW(), 'Barres d\'outils Wysiwyg', 'Toolbars Wysiwyg');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1478, 'standard', NOW(), 'Gestion des modèles.', 'Templates management.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1479, 'standard', NOW(), 'Sur cette page, vous pouvez gérer les modèles servant à la création des pages ainsi que les modèles des rangées de contenu employé dans les pages. Vous pouvez aussi gérer les feuilles de styles et les barres d\'outils employées par l\'éditeur WYSIWYG.', 'On this page you can manage templates for the creation of pages and the templates rows used in the content pages. You can also manage the stylesheets and toolbars used by the WYSIWYG editor.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1480, 'standard', NOW(), 'Le modèle a modifier n\'existe pas ou possède une erreur.', 'The template to change does not exists or has an error.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1481, 'standard', NOW(), 'Modèle enregistré avec succès.', 'Template successfully saved.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1482, 'standard', NOW(), 'Modèle créé avec succès.', 'Template successfully created.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1483, 'standard', NOW(), 'Modèle d\'impression mis à jour avec succès.', 'Template Printing updated successfully.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1484, 'standard', NOW(), 'Aucune page publique n\'emploie ce modèle ...', 'No public page use this template ...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1485, 'standard', NOW(), 'Modèle dupliqué avec succès.<br />Le nouveau modèle \'%s\' est inactif.', 'Model successfully duplicated.<br />The new template \'%s\' is inactive.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1486, 'standard', NOW(), 'Feuille de style', 'Cascaded Stylesheet');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1487, 'standard', NOW(), 'Style Wysiwyg', 'Wysiwyg style');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1488, 'standard', NOW(), 'Javascript', 'Javascript');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1489, 'standard', NOW(), 'Création d\'un fichier de feuille de style', 'Creating a stylesheet');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1490, 'standard', NOW(), 'Edition du fichier de feuille de style', 'Editing a stylesheet');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1491, 'standard', NOW(), 'Création d\'un fichier Javascript', 'Creating a javascript file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1492, 'standard', NOW(), 'Edition du fichier Javascript', 'Editing a javascript file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1493, 'standard', NOW(), 'Edition du fichier de style de l\'éditeur Wysiwyg', 'File edition style WYSIWYG editor');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1494, 'standard', NOW(), 'Cette page permet l\'édition d\'un fichier Javascript ou d\'une feuille de style (CSS). Ce fichier peut-être ensuite appelé dans le code d\'un modèle de page.', 'This page allows editing of a JavaScript file or a stylesheet (CSS). This file can then be called in the code of a page template.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1495, 'standard', NOW(), 'Définition', 'Definition');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1496, 'standard', NOW(), 'Feuilles de styles des sites', 'Websites stylesheets');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1497, 'standard', NOW(), 'Scripts Javascript des sites', 'Websites javascripts');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1498, 'standard', NOW(), 'Confirmer la suppression définitive du fichier', 'Confirm the permanent removal of the file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1499, 'standard', NOW(), 'Attention, si ce fichier est employé par un modèle de page, sa mise en page risque d\'être corrompue !', 'Remember, if this file is used by a page template, the layout may be corrupt!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1500, 'standard', NOW(), 'Fichier %s supprimé.', 'File %s deleted.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1501, 'standard', NOW(), 'Erreur durant la suppression du fichier', 'Error deleting file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1502, 'standard', NOW(), 'Fichier %s mis à jour.', 'File %s updated.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1503, 'standard', NOW(), 'Erreur durant la mise à jour du fichier', 'Error updating file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1504, 'standard', NOW(), 'Fichier %s créé.', 'File %s created.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1505, 'standard', NOW(), 'Impossible de créer le fichier %s, son extention est incorrecte.', 'Unable to create file %s, its extension is incorrect.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1506, 'standard', NOW(), 'Impossible de créer le fichier %s, ce fichier existe déjà.', 'Unable to create file %s, file already exists.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1507, 'standard', NOW(), 'Type: Dossier<br />Dernière modification :', 'Type: Folder<br />Updated:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1508, 'standard', NOW(), 'Type: %s<br />Dernière modification : %s<br />Taille: %s', 'Type: %s<br />Updated: %s<br />Size: %s');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1509, 'standard', NOW(), 'Par nom, description', 'By name, description');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1510, 'standard', NOW(), 'Groupes', 'Groups');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1511, 'standard', NOW(), 'Site', 'Website');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1512, 'standard', NOW(), 'Page', 'Page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1513, 'standard', NOW(), 'Voir les modèles inactifs', 'See inactive templates');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1514, 'standard', NOW(), 'Chargement ...', 'Loading...');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1515, 'standard', NOW(), 'Filtrer', 'Filter');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1516, 'standard', NOW(), 'Modèle d\'impression', 'Print template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1517, 'standard', NOW(), 'Activer', 'Activate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1518, 'standard', NOW(), 'Désactiver', 'Disable');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1519, 'standard', NOW(), 'Confirmez-vous la suppression définitive du ou des modèles de pages sélectionnés ?', 'Do you confirm the deletion of the selected templates pages?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1520, 'standard', NOW(), 'Dupliquer', 'Duplicate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1521, 'standard', NOW(), 'Duplique le modèle sélectionné.', 'Duplicates the selected model.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1522, 'standard', NOW(), 'Voir les rangées inactives', 'See inactive rows');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1523, 'standard', NOW(), 'Confirmez-vous la suppression définitive du ou des modèles de rangées sélectionnés ?', 'Do you confirm the deletion of the selected templates rows?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1524, 'standard', NOW(), 'Vous n\'avez pas le droit de dupliquer les branches d\'arborescences.', 'You are not allowed to duplicate the branches of trees.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1525, 'standard', NOW(), 'Duplication de branche d\'arborescence', 'Duplication of tree branch');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1526, 'standard', NOW(), 'Cette page vous permet de dupliquer une branche complète de l\'arborescence de pages. Toutes les pages de la branche sélectionnée seront recréées avec leurs contenus sous la page que vous désignerez.', 'This page allows you to duplicate a branch of the tree of pages. All pages of the selected branch will be recreated with their content in the page you designate.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1527, 'standard', NOW(), 'Choisissez la branche à dupliquer', 'Select the branch to duplicate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1528, 'standard', NOW(), 'Choisissez la page de destination', 'Choose the destination page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1529, 'standard', NOW(), 'Vous allez dupliquer l\'ensemble des pages (ainsi que leur contenu) se trouvant sous la page {0}.<br /><br />La page sous laquelle seront recréées les pages dupliquées sera {1}.<br /><br />Confirmez-vous cette opération ?', 'You will duplicate all of the pages (and contents) which is below the page {0}.<br /><br />The page under which pages will be duplicated will be {1}.<br /><br />Can you confirm this?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1530, 'standard', NOW(), 'Page ajoutée à vos favoris !', 'Page added to your favorites!');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1531, 'standard', NOW(), 'Page enlevée de vos favoris.', 'Page removed from your favorites.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1532, 'standard', NOW(), 'Aux modèles :', 'To templates:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1533, 'standard', NOW(), 'Usage restreint :', 'Restricted:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1534, 'standard', NOW(), 'Modèle de Rangée', 'Template Row');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1535, 'standard', NOW(), 'Groupes :', 'Groups:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1536, 'standard', NOW(), 'Aucun', 'None');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1537, 'standard', NOW(), 'Actif :', 'Active:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1538, 'standard', NOW(), 'Oui', 'Yes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1539, 'standard', NOW(), 'Non', 'No');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1540, 'standard', NOW(), 'Employé :', 'Used:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1541, 'standard', NOW(), 'Voir', 'View');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1542, 'standard', NOW(), 'Régénérer', 'Regenerate');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1543, 'standard', NOW(), 'les pages.', 'pages.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1544, 'standard', NOW(), 'Fichier :', 'File:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1545, 'standard', NOW(), 'Modèle de page', 'Page Template');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1546, 'standard', NOW(), 'Sites :', 'Websites:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1547, 'standard', NOW(), 'Automne.locales = {
	validateOptions: 		\'Voir les options de validation\',
	validate: 				\'Valider\',
	actionImpossible: 		\'Action impossible\',
	cantSubmitFormPage: 	\'Vous ne pouvez pas soumettre un formulaire depuis une page non publique.\',
	loadingError: 			\'Erreur de traitement. Veuillez réessayer ou vous reconnecter ...\',
	jsError: 				\'Erreur de traitement Javascript. Veuillez réessayer ou vous reconnecter ...\',
	jsonError: 				\'Erreur de traitement JSon. Veuillez réessayer ou vous reconnecter ...\',
	contactAdministrator:	\'Si le problème persiste, veuillez contacter votre administrateur avec ces informations : \',
	cannotCloseModalGroup: 	\'Vous ne pouvez pas fermer cette fenêtre tant que des fenêtres dépendantes sont ouvertes. Veuillez les fermer d\\\'abord.\',
	noPageFounded: 			\'Aucune page trouvée ...\',
	noScript: 				\'Aucun script en cours de traitement.\',
	nScripts: 				\'Scripts en cours de traitement ... {0} scripts restant.\',
	//Page edition 
	rowDel:					\'Supprimer cette rangée\',
	rowDrag:				\'Glisser-Déposer cette rangée\',
	rowTop:					\'Monter cette rangée en haut de la zone éditable\',
	rowBottom:				\'Descendre cette rangée en bas de la zone éditable\',
	rowLeft:				\'Passer cette rangée dans la zone éditable de gauche\',
	rowRight:				\'Passer cette rangée dans la zone éditable de droite\',
	rowUp:					\'Monter cette rangée d\\\'un cran\',
	rowDown:				\'Descendre cette rangée d\\\'un cran\',
	csName:					\'Zone de contenu :\',
	rowType:				\'Rangée de type : \',
	newRow:					\'Nouvelle Rangée\',
	newRowTip:				\'Ajouter une nouvelle rangée de contenu dans la page\',
	blockDel:				\'Supprimer le contenu de ce bloc.\',
	blockModify:			\'Modifier le contenu de ce bloc.\',
	blockAdmin:				\'Gérer les éléments employés par ce bloc de contenu.\',
	blockValidate:			\'Enregistrer le contenu\',
	rowDeleteConfirm:		\'Etes-vous sur de vouloir supprimer définitivement la rangée \\\'{0}\\\' et tout son contenu ?\',
	blockDeleteConfirm:		\'Etes-vous sur de vouloir supprimer définitivement tout le contenu de ce bloc ?\',
	csSelectRowAdd:			\'Sélectionnez la rangée à ajouter : \',
	csSelectRow:			\'Sélectionnez la rangée à ajouter ...\',
	csClickToAdd:			\'Cliquez pour ajouter une nouvelle rangée à cette position\',
	csClickOnRed:			\'Cliquez sur la zone rouge où vous souhaitez ajouter votre nouvelle rangée.\',
	csCancelRowAdd:			\'Annuler l\\\'ajout d\\\'une nouvelle rangée dans la page.\',
	csAddRowToPosition:		\'Ajouter la rangée sélectionnée à la position choisie dans la page.\',
	options:				\'Options\',
	optionsDetail:			\'Vous permet de controler les options d\\\'affichage de l\\\'édition de la page\',
	optAnimateDetail:		\'Vous permet d\\\'activer et désactiver les déplacements animés des rangées. Désactiver cette option peut faire gagner en performance.\',
	optAnimate:				\'Déplacements animés des rangées\',
	optMoveDetail:			\'Vous permet d\\\'activer et désactiver le scrolling vertical de la page pour suivre la rangée active. Désactiver cette option peut faire gagner en performance.\',
	optMove:				\'Scroll de la fenêtre\',
	loading:				\'Chargement ...\',
	add:					\'Ajouter\',
	delDraft:				\'Supprimer le contenu\',
	delDraftDetail:			\'Supprimer le contenu actuel. Le contenu reviendra au précédent contenu validé ou en attente de validation. Cette action n\\\'est pas soumise à validation et prend effet immédiatement.\',
	SubmitToValid:			\'Soumettre à validation\',
	SubmitToValidDetail:	\'Soumettre l\\\'état actuel de la page à la validation. Une fois validée, la page présentera ce contenu en ligne.\',
	//File upload
	browse:					\'Parcourir ...\',
	cancel:					\'Annuler\',
	byte:					\'o\',
	max:					\'Max\',
	min:					\'Min\',
	init:					\'Initialisation ...\',
	queueLimit:				\'Vous avez dépassé le nombre de fichier possible.\',
	zeroByte:				\'Le fichier que vous tentez d\\\'envoyer est vide.\',
	tooBig:					\'Le fichier que vous tentez d\\\'envoyer est trop volumineux ({0} Mo). Vous ne devez pas dépasser {1} Mo\',
	invalidType:			\'Le type de fichier que vous tentez d\\\'envoyer n\\\'est pas authorisé.\',
	sendingCancelled:		\'Envoi sur le serveur annulé.\',
	sendingStopped:			\'Envoi sur le serveur interrompu.\',
	sizeLimit:				\'Limite d\\\'envoi sur le serveur atteinte.\',
	uploadError:			\'Erreur durant l\\\'envoi du fichier au serveur.\',
	treatmentError:			\'Erreur de traitement du fichier sur le serveur.\',
	securityError:			\'Erreur de sécurité : le type de fichier que vous envoyez n\\\'est pas autorisé.\',
	unknownError:			\'Erreur d\\\'envoi du fichier ... \',
	pleaseWait:				\'Veuillez patienter, transfert en cours ...\',
	browserError:			\'Votre navigateur ne peut gérer ce script.\',
	removeFile:				\'Supprimer le fichier actuel\',
	//Image upload
	clickOriginal:			\'Cliquez pour voir en format original.\',
	maxImageSize:			\'L\\\'image dépasse les limites de taille autorisées. Veuillez la redimensionner ou la modifier.\',
	clickToClose:			\'Cliquez pour fermer la prévisualisation.\',
	resize:					\'Redimensionner\',
	help:					\'Aide\',
	resizeHelp:				\'Vous pouvez redimensionner l\\\'image et la recadrer. Attention à respecter les limites de dimensions si il y en a. Lorsque vous cliquez sur "Appliquer", l\\\'image sera transformée sur le serveur et vous ne pourrez pas revenir à l\\\'image originale.\',
	width:					\'Largeur\',
	height:					\'Hauteur\',
	crop:					\'Recadrer\',
	apply:					\'Appliquer\',
	removeImage:			\'Supprimer l\\\'image actuelle\',
	updateImage:			\'Modifier (redimensionner - retailler) l\\\'image actuelle\',
	//Pages field
	select:					\'Sélectionner ...\',
	//Link field
	none:					\'Aucun\',
	title:					\'Titre\',
	internalLink:			\'Lien Interne (vers une page du site)\',
	externalLink:			\'Lien Externe (vers un autre site)\',
	fileLink:				\'Lien vers un Fichier\',
	type:					\'Type\',
	page:					\'Page\',
	externalLinkHelp:		\'Saisissez ici l\\\'adresse du lien en commençant par http://\',
	url:					\'URL\',
	file:					\'Fichier\',
	destination:			\'Destination\',
	currentWindow:			\'Dans la fenêtre en cours\',
	newWindow:				\'Dans une nouvelle fenêtre\',
	popupWindow:			\'Dans une fenêtre Pop-up\',
	//framepanel
	submitDraftConfirm:		\'Voulez vous soumettre le contenu actuel de la page à la validation ?\',
	validateDraft:			\'Valider ce contenu\',
	validateDraftDetail:	\'Valider l\\\'état actuel du contenu de la page. La page présentera ce contenu en ligne sans étape intermédiaire de validation.\',
	validateDraftConfirm:	\'Voulez vous valider le contenu actuel de la page ? Son contenu sera directement mis en ligne sans étape intermédiaire de validation.\',
	//edit
	endEdition:				\'Vous quittez l\\\'édition de la page. Voulez vous soumettre le contenu actuel de la page à la validation ?\',
	quitConfirm:			\'Vous allez perdre les modifications en cours qui n\\\'ont pas été sauvegardées.\',
	refresh:				\'Rafraichissement de la page ...\'
};
//Change default field label separator
if(Ext.layout.FormLayout) {
	Ext.layout.FormLayout.prototype.labelSeparator = \' :\';
}', 'Automne.locales = {
	validateOptions: 		\'See validations options\',
	validate: 				\'Validate\',
	actionImpossible: 		\'Action impossible\',
	cantSubmitFormPage: 	\'You can not submit a form from a non public page.\',
	loadingError: 			\'Error during loading, please retry or reconnect...\',
	jsError: 				\'Error during Javascript loading, please retry or reconnect...\',
	jsonError: 				\'Error during JSon loading, please retry or reconnect...\',
	contactAdministrator:	\'If the problem persist, please contact your administrator with this informations:\',
	cannotCloseModalGroup: 	\'You can not close this window since dependent windows are open. Please close them first.\',
	noPageFounded: 			\'No page founded...\',
	noScript: 				\'No script in progress.\',
	nScripts: 				\'Scripts in progress ... {0} scripts left.\',
	//Page edition 
	rowDel:					\'Delete this row\',
	rowDrag:				\'Drag and drop this row\',
	rowTop:					\'Move this row to the top of this editable zone\',
	rowBottom:				\'Move this row to the bottom of this editable zone\',
	rowLeft:				\'Put this row in the left editable zone\',
	rowRight:				\'Put this row in the right editable zone\',
	rowUp:					\'Move up this row\',
	rowDown:				\'Move down this row\',
	csName:					\'Editable zone:\',
	rowType:				\'Row type:\',
	newRow:					\'New Row\',
	newRowTip:				\'Add a new content row to the page\',
	blockDel:				\'Delete content of this block\',
	blockModify:			\'Modify content of this block\',
	blockAdmin:				\'Manage module datas used by this block\',
	blockValidate:			\'Save content\',
	rowDeleteConfirm:		\'Do you want to delete the row \\\'{0}\\\' and all his content?\',
	blockDeleteConfirm:		\'Do you want to definitively delete the content of this block?\',
	csSelectRowAdd:			\'Select the row to add: \',
	csSelectRow:			\'Select the row to add...\',
	csClickToAdd:			\'Click to add a new row at this position\',
	csClickOnRed:			\'Click on the red spot where you want to add the new row.\',
	csCancelRowAdd:			\'Cancel adding a new row in the page.\',
	csAddRowToPosition:		\'Add the selected row to the chosen position in the page.\',
	options:				\'Options\',
	optionsDetail:			\'Allow you to control some display parameters for the page edition\',
	optAnimateDetail:		\'Allow you to activate or disactivate animated movements of the rows in the page. Desactivating this option should improve performances.\',
	optAnimate:				\'Animated rows moving\',
	optMoveDetail:			\'Allow you to activate or disactivate the page scrolling to follow the active row. Desactivating this option should improve performances.\',
	optMove:				\'Window scroll\',
	loading:				\'Loading...\',
	add:					\'Add\',
	delDraft:				\'Delete content\',
	delDraftDetail:			\'Delete actual content. The page content will be back to the previous validated or validation pending state. This action will take effect immediatly.\',
	SubmitToValid:			\'Submit to validation\',
	SubmitToValidDetail:	\'Submit the current page content to validation.\',
	//File upload
	browse:					\'Browse...\',
	cancel:					\'Cancel\',
	byte:					\'B\',
	max:					\'Max\',
	min:					\'Min\',
	init:					\'Initialisation ...\',
	queueLimit:				\'You have reached the maximum number of files.\',
	zeroByte:				\'The file is empty.\',
	tooBig:					\'This file is too big ({0} MB). Maximum filesize is {1} MB\',
	invalidType:			\'This file type is not allowed.\',
	sendingCancelled:		\'Sending cancelled.\',
	sendingStopped:			\'Sending interrupted.\',
	sizeLimit:				\'Server limit reached.\',
	uploadError:			\'Error during sending to the server.\',
	treatmentError:			\'File treatment error on the server.\',
	securityError:			\'Security error, this file type is not allowed.\',
	unknownError:			\'File sending error... \',
	pleaseWait:				\'Please wait during file sending...\',
	browserError:			\'Your browser can not handle this script.\',
	removeFile:				\'Remove current file\',
	//Image upload
	clickOriginal:			\'Clic to see original size.\',
	maxImageSize:			\'This image is over autorized size. Please resize it ot modify it.\',
	clickToClose:			\'Clic to close the previsualisation.\',
	resize:					\'Resize\',
	help:					\'Help\',
	resizeHelp:				\'You can resize and crop your image. Attention to respect size limits. When you clic on "Apply", the image will be transformed on the server and you will not be able to go back to the original image.\',
	width:					\'Width\',
	height:					\'Height\',
	crop:					\'Crop\',
	apply:					\'Apply\',
	removeImage:			\'Remove current image\',
	updateImage:			\'Modify (resize - crop) current image\',
	//Pages field
	select:					\'Select...\',
	//Link field
	none:					\'None\',
	title:					\'Title\',
	internalLink:			\'Internal link (to a page of this website)\',
	externalLink:			\'External link (to another website)\',
	fileLink:				\'File link\',
	type:					\'Type\',
	page:					\'Page\',
	externalLinkHelp:		\'Type here the address begining by http://\',
	url:					\'URL\',
	file:					\'File\',
	destination:			\'Destination\',
	currentWindow:			\'In the current window\',
	newWindow:				\'In a new window\',
	popupWindow:			\'In a Pop-up window\',
	//framepanel
	submitDraftConfirm:		\'Do you want to submit the actual page content to validation?\',
	validateDraft:			\'Validate this content\',
	validateDraftDetail:	\'Validate the current page content. The page will present this content online without any further validation step.\',
	validateDraftConfirm:	\'Do you want to validate the current page content? This content will be directly put online without any further validation step.\',
	//edit
	endEdition:				\'You leave page edition. Do you want to submit actual page content to validation?\',
	quitConfirm:			\'You will lose all modifications which are not saved.\',
	refresh:				\'Refreshing current page...\'
};');


#
# Contenu de la table `I18NM_messages` modules Aliases
#

DELETE FROM I18NM_messages WHERE module='cms_aliases';

INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (5, 'cms_aliases', NOW(), 'Confirmer la suppression de l''alias ''%s''', 'Do you confirm deletion of the alias ''%s''');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (8, 'cms_aliases', NOW(), '[Erreur : Impossible de créer l''alias, un dossier portant ce nom existe déjà  !]', '[Error: Impossible to create this alias, a folder with this name already exists!]');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (7, 'cms_aliases', NOW(), 'Création / modification d''alias', 'Alias creation / modification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1, 'cms_aliases', NOW(), 'Alias', 'Aliases ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (2, 'cms_aliases', NOW(), 'Chemin de l''alias', 'Alias path');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (3, 'cms_aliases', NOW(), 'Cible', 'Target');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (4, 'cms_aliases', NOW(), 'Sous-alias', 'Sub-aliases');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (6, 'cms_aliases', NOW(), 'Parent', 'Parent');

#
# Contenu de la table `I18NM_messages` module Forms
#

DELETE FROM I18NM_messages WHERE module='cms_forms';

INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (1, 'cms_forms', NOW(), 'Formulaires', 'Forms');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (2, 'cms_forms', NOW(), 'Voici les formulaires qui ont été reçus par l''application. Vous pouvez en exporter les données ou supprimer le contenu existant.', 'Here are the forms that were received by the application. You can export their data or delete it.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (3, 'cms_forms', NOW(), 'Formulaire', 'Form');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (4, 'cms_forms', NOW(), 'Enregistrements', 'Records');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (5, 'cms_forms', NOW(), 'Dernier envoi', 'Last post');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (6, 'cms_forms', NOW(), 'Aucun résultats trouvés', 'No results found');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (7, 'cms_forms', NOW(), 'Exporter', 'Export');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (8, 'cms_forms', NOW(), 'Supprimer', 'Delete');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (9, 'cms_forms', NOW(), 'Confirmez-vous la suppression de l''action ''%s'' ?', 'Do you confirm deletion of the ''%s'' action?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (10, 'cms_forms', NOW(), 'Données reçues', 'Data received');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (11, 'cms_forms', NOW(), 'Formulaires disponibles pour les utilisateurs', 'PDF forms available for users');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (12, 'cms_forms', NOW(), 'Voici les formulaires disponibles.', 'Here are the forms available.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (13, 'cms_forms', NOW(), 'Fichier', 'File');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (14, 'cms_forms', NOW(), 'Adresse', 'URL');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (15, 'cms_forms', NOW(), 'Date d''insertion', 'Insertion date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (16, 'cms_forms', NOW(), 'Confirmez-vous la suppresion du formulaire ''%s'' ?', 'Do you confirm deletion of form ''%s'' ?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (17, 'cms_forms', NOW(), 'Insérer un document PDF', 'Insert PDF file');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (18, 'cms_forms', NOW(), 'Erreur lors de l''insertion du fichier !', 'Error while uploading file !');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (19, 'cms_forms', NOW(), 'Nom du formulaire', 'Form name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (20, 'cms_forms', NOW(), 'Ajouter un formulaire', 'Add a new form');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (21, 'cms_forms', NOW(), 'Gestion des catégories :', 'Categories management :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (22, 'cms_forms', NOW(), 'Gestion des accès par groupes d''utilisateurs :', 'User access by groups :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (23, 'cms_forms', NOW(), 'Gestion des formulaires :', 'Forms management :');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (24, 'cms_forms', NOW(), 'Lister', 'List');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (25, 'cms_forms', NOW(), 'Accueil', 'Entry');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (26, 'cms_forms', NOW(), 'Libellé', 'Label');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (27, 'cms_forms', NOW(), 'Nom du formulaire', 'Form name');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (28, 'cms_forms', NOW(), 'Source XHTML', 'XHTML source');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (29, 'cms_forms', NOW(), 'Actif', 'Activated');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (30, 'cms_forms', NOW(), 'Catégories', 'Categories');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (31, 'cms_forms', NOW(), 'Une erreur est survenue lors de la suppression du formulaire', 'An error occured while attempting to delete form');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (32, 'cms_forms', NOW(), 'Veuillez vérifier la syntaxe XHTML de votre formulaire', 'Please verify formular XHTML syntax');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (33, 'cms_forms', NOW(), 'Une erreur est survenue lors de l''ajout des catégories', 'Add of categories failed');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (34, 'cms_forms', NOW(), 'Une erreur est survenue lors de l''ajout de la catégorie %s', 'Add of category %s failed');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (35, 'cms_forms', NOW(), 'Vous devez sélectionner une catégorie au minimum	', 'Choose at least one category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (36, 'cms_forms', NOW(), 'Actions du formulaire', 'Form actions');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (37, 'cms_forms', NOW(), 'Aucun élément n''est sélectionné', 'Nothing is selected');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (38, 'cms_forms', NOW(), 'Type d''action', 'Action type');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (39, 'cms_forms', NOW(), 'Valeurs insérées en base de données', 'Values inserted in data base ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (40, 'cms_forms', NOW(), 'Si la saisie du formulaire n''est pas correcte', 'If form datas are not correct ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (41, 'cms_forms', NOW(), 'Si la saisie du formulaire est correcte', 'If form datas are correct');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (42, 'cms_forms', NOW(), 'Envoi des valeurs du formulaire à un ou plusieurs emails fournis', 'Sending of form values to one or more provided emails ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (43, 'cms_forms', NOW(), 'Envoi des valeurs du formulaire à un email fournis dans un champ du formulaire', 'Sending of form values to one email provided in a field of the form');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (44, 'cms_forms', NOW(), 'Oui', 'Yes');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (45, 'cms_forms', NOW(), 'Non', 'No');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (46, 'cms_forms', NOW(), 'Merci, votre message est enregistré.', 'Thank you, your message has been saved.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (47, 'cms_forms', NOW(), 'Stocker les valeurs du formulaire dans un fichier CSV', 'Store form values in a CSV file ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (48, 'cms_forms', NOW(), 'Nombre de réponses max :<br /><small>(par utilisateurs)</small>', 'Max number of answers :<br /><small>(per users)</small>');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (49, 'cms_forms', NOW(), 'Saisissez le nombre maximum de réponses désirées par utilisateurs, ou laisser vide pour ne pas limiter ce nombre', 'Enter the maximum number of wished answers per users, or to leave vacuum not to limit this number ');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (50, 'cms_forms', NOW(), 'Afficher un texte', 'Display a text');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (51, 'cms_forms', NOW(), 'Rediriger vers une page', 'Redirect to a page');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (52, 'cms_forms', NOW(), 'Si le nombre de réponses est dépassé', 'If the number of answers is exceeded');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (53, 'cms_forms', NOW(), 'Actions actuelles :', 'Current actions:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (54, 'cms_forms', NOW(), 'Ajouter une action :', 'Add an action:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (55, 'cms_forms', NOW(), 'Saisissez votre liste d''emails (séparateur virgule ou point-virgule)', 'Enter your emails list (separator comma or semicolon)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (56, 'cms_forms', NOW(), 'Saisissez le message d''en tête pour les emails', 'Enter the header message for emails');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (57, 'cms_forms', NOW(), 'Texte à afficher', 'Text to display');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (58, 'cms_forms', NOW(), 'Champ(s) du formulaire', 'Form field(s)');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (59, 'cms_forms', NOW(), 'Fichier CSV', 'CSV File');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (60, 'cms_forms', NOW(), 'Vous pourrez télécharger ici le fichier CSV lorsque des données seront disponibles.', 'You will be able to download CSV file here when data are available.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (61, 'cms_forms', NOW(), 'Aucun champ pouvant contenir un email n''a été trouvé dans le formulaire.', 'No field which can contain an email was found in the form.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (62, 'cms_forms', NOW(), 'Catégorie', 'Category');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (63, 'cms_forms', NOW(), 'Trouver un formulaire', 'Find a form');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (64, 'cms_forms', NOW(), 'Sélection d''un formulaire', 'Form selection');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (65, 'cms_forms', NOW(), 'Sélectionner', 'Select');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (66, 'cms_forms', NOW(), 'Déselectionner', 'Deselect');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (67, 'cms_forms', NOW(), 'Veuillez compléter les champs requis :', 'Please complete the following required fields:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (68, 'cms_forms', NOW(), 'Le contenu de ces champs est incorrect :', 'The following fields have incorrect content:');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (69, 'cms_forms', NOW(), 'Message du formulaire ''%s'' du site ''%s''', 'Message from form ''%s'' from website ''%s''');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (70, 'cms_forms', NOW(), 'Saisissez le message de fin pour les emails', 'Enter the footer message for emails');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (71, 'cms_forms', NOW(), 'Saisissez le sujet des emails', 'Enter the subject message for emails');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (72, 'cms_forms', NOW(), 'Télécharger les données du formulaire au format CSV', 'Download form datas in CSV format');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (73, 'cms_forms', NOW(), 'Confirmez-vous la suppression des données enregistrées pour le formulaire ''%s'' ?', 'Do you confirm deletion of recorded datas for the form ''%s''?');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (74, 'cms_forms', NOW(), 'Remise à zéro', 'Reset');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (75, 'cms_forms', NOW(), 'Authentifier l''utilisateur', 'Authenticate user');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (76, 'cms_forms', NOW(), 'Aucun champ pouvant contenir un identifiant utilisateur n''a été trouvé dans le formulaire.', 'No field which can contain a user ID was found in the form.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (77, 'cms_forms', NOW(), 'Aucun champ pouvant contenir un mot de passe utilisateur n''a été trouvé dans le formulaire.', 'No field which can contain a user password was found in the form.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (78, 'cms_forms', NOW(), 'Identifiant', 'User ID');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (79, 'cms_forms', NOW(), 'Mot de passe', 'Password');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (80, 'cms_forms', NOW(), 'Message à afficher si l''authentification est incorrecte', 'Message displayed on wrong authentification');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (81, 'cms_forms', NOW(), 'Se souvenir du compte', 'Remember account');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (82, 'cms_forms', NOW(), 'Aucun champ pouvant servir à retenir le compte utilisateur n''a été trouvé dans le formulaire.', 'No field which can be used to remember user account was found in the form.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (83, 'cms_forms', NOW(), 'Cette action n\'est pas autorisée durant l\'édition ou la prévisualisation de la page.', 'This action is not allowed during edition / previsualisation of the page.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (84, 'cms_forms', NOW(), 'Vous devez avoir \'%s\' actif dans votre profil pour pouvoir Créer / Editer un formulaire.', 'You must have \'%s\' active in your profile to Create / Edit a form.');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (85, 'cms_forms', NOW(), '<div class="rowComment">
<h1>Formulaire &agrave; choisir pour une page :</h1>
<div class="retrait"><span class="code">&lt;block module=&quot;cms_forms&quot; id=&quot;form&quot;&gt;<span class="vertclair">{{data}}</span>&lt;/block&gt;</span>
<ul><li><span class="vertclair">{{data}} : </span>Sera remplacé par le formulaire &agrave; afficher.</li></ul>
</div>
</div>', 'TODO');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (86, 'cms_forms', NOW(), '<div class="rowComment">
<h1>Formulaire &agrave; afficher pour toutes les pages employant le modèle :</h1>
<div class="retrait"><span class="code">&lt;atm-clientspace module=&quot;cms_forms&quot; id=&quot;form&quot; type=&quot;formular&quot; formID=&quot;<span class="keyword">formID</span>&quot;/&gt;</span>
<ul><li><span class="keyword">formID : </span>Identifiant du formulaire &agrave; afficher.</li></ul>
</div>
</div>', 'TODO');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (87, 'cms_forms', NOW(), 'Assistant de création de formulaires', 'Forms creation wizard');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (88, 'cms_forms', NOW(), 'Adresse d\'émission', 'Sender address');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (89, 'cms_forms', NOW(), 'Avec la date de soumission', 'With submission date');
INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES (90, 'cms_forms', NOW(), '[Erreur : vous ne devez pas copier-coller le code d\'un formulaire dans un autre formulaire !]', '[Error : you must not copy-paste code from one form to another one!]');

#
# Contenu de la table `I18NM_messages` module Polymod
#

DELETE FROM I18NM_messages WHERE module='polymod';

INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'polymod', NOW(), 'Création / modification d\'un élément \'%s\'', 'Item \'%s\' creation / modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'polymod', NOW(), 'Création / modification de l\'élément \'%s\' :', 'Creation / modification of \'%s\' item:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'polymod', NOW(), 'Suppression d\'un élément \'%s\'', '\'%s\' item deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'polymod', NOW(), 'Suppression de l\'élément \'%s\' :', 'Deletion of \'%s\' item:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'polymod', NOW(), 'Lien existant', 'Current link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'polymod', NOW(), 'Accueil', 'Entry');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (18, 'polymod', NOW(), 'Mots-clés', 'Keywords');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (19, 'polymod', NOW(), 'Publié entre le', 'Published between');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (20, 'polymod', NOW(), 'et le', 'and');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (21, 'polymod', NOW(), '%s élément(s) \'%s\' correspondant à votre recherche', '%s \'%s\' item(s) relative to your search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (30, 'polymod', NOW(), 'Objet', 'Object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (31, 'polymod', NOW(), 'Changement du contenu d\'un élement %s', 'Item %s content change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (32, 'polymod', NOW(), 'Changement apporté sur l\'élément %s : <strong>%s</strong>\n\nAuteur(s) de la modification :\n%s', 'Content change for the %s item: <strong>%s</strong>\n\nAuthor(s) of the change:\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (37, 'polymod', NOW(), 'Libellé', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (39, 'polymod', NOW(), 'Description', 'Description');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (52, 'polymod', NOW(), 'Confirmez-vous la suppression de l\'élément \'%s\' : %s', 'Do you confirm deletion of item \'%s\' : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (53, 'polymod', NOW(), 'Proposition de suppression d\'un élément %s', 'Item %s deletion proposal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (55, 'polymod', NOW(), 'Suppression de l\'élément %s : <strong>%s</strong>\n\nAuteur(s) de la suppression :\n%s', 'Deletion of the %s item: <strong>%s</strong>\n\nAuthor(s) of the deletion:\n%s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (57, 'polymod', NOW(), 'Publication sur le site', 'Publication on website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (66, 'polymod', NOW(), 'Trouver un élément \'%s\'', 'Find a \'%s\' item');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (77, 'polymod', NOW(), 'Lister', 'List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (82, 'polymod', NOW(), 'Gestion des éléments \'%s\'', '\'%s\' elements management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (108, 'polymod', NOW(), 'Gérer les éléments \'%s\'', 'Manage elements \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (109, 'polymod', NOW(), 'Effectuer une recherche', 'Research');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (110, 'polymod', NOW(), '<div class="rowComment">
<h1>Lance une recherche sur un type d\'objet donn&eacute; :</h1>
<div class="retrait"><span class="code"> 	&lt;atm-search what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">searchName</span>&quot;&gt;...&lt;/atm-search&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">objet</span> : Type d\'objet &agrave; rechercher (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>
	<li><span class="keyword">searchName</span> : Nom de la recherche : identifiant unique pour la recherche dans la rang&eacute;e.</li>
	<li>Un attribut <span class="keyword">public</span> (facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier une recherche sur la zone publique ou &eacute;dit&eacute;e. Il prend pour valeur <span class="vertclair">true</span> pour une recherche publique (d&eacute;faut) ou <span class="vertclair">false</span> pour une recherche dans la zone &eacute;dit&eacute;e.</li>
</ul>
</div>
<h2>Ce tag peut contenir les sous-tags suivants :</h2>
<div class="retrait">
<h3>Affichage des r&eacute;sultats :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-result&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-result&gt; 	</span><br />
<br />
Le contenu de ce tag sera lu pour chaque r&eacute;sultat trouv&eacute; pour la recherche en cours.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li>Un attribut <span class="keyword">return </span>(facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier le type de r&eacute;sultat retourn&eacute;. Par d&eacute;faut une recherche revoie des objets, mais dans l\'optique d\'am&eacute;liorer les performances, il est possible de sp&eacute;cifier les deux valeurs suivantes de retour :
	<ul>
		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_IDS</span> : retournera uniquement l\'identifiant du r&eacute;sultat.</li>
		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_OBJECTSLIGHT</span> : retournera le r&eacute;sultat mais sans charger les sous-objets qu\'il peut contenir dans ses diff&eacute;rents champs. Attention, ce param&egrave;tre n\'est possible que sur une recherche publique.</li>
	</ul>
	</li>
</ul>
<br />
Les valeurs suivantes seront remplac&eacute;es dans le tag :
<ul>
	<li><span class="vertclair">{firstresult}</span> : Vrai si le r&eacute;sultat en cours est le premier de la page en cours.</li>
	<li><span class="vertclair">{lastresult}</span> : Vrai si le r&eacute;sultat en cours est le dernier de la page en cours.</li>
	<li><span class="vertclair">{resultcount}</span> : Num&eacute;ro du r&eacute;sultat dans la page.</li>
	<li><span class="vertclair">{maxresults}</span> : Nombre de r&eacute;sultats pour la recherche.</li>
	<li><span class="vertclair">{maxpages}</span> : Nombre de pages maximum pour la recherche en cours.</li>
	<li><span class="vertclair">{currentpage}</span> : Num&eacute;ro de la page actuelle pour la recherche en cours.</li>
	<li><span class="vertclair">{resultid}</span> : Identifiant du r&eacute;sultat. Utile dans le cas du\'une recherche retournant uniquement les identifiants des r&eacute;sultats (param&egrave;tre return avec la valeur POLYMOD_SEARCH_RETURN_IDS).</li>
</ul>
</div>
<h3>Aucun r&eacute;sultats :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-noresult&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-noresult&gt; 	</span><br />
<br />
Le contenu de ce tag sera affich&eacute; si aucun r&eacute;sultat n\'est trouv&eacute; pour la recherche en cours.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
</ul>
</div>
<h3>Param&egrave;tre de recherche :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-param search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">paramType</span>&quot; value=&quot;<span class="keyword">paramValue</span>&quot; mandatory=&quot;<span class="keyword">mandatoryValue</span>&quot; /&gt; 	</span><br />
<br />
Permet de limiter les r&eacute;sultats de la recherche &agrave; des param&egrave;tres donn&eacute;s.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li><span class="keyword">paramType</span> : Type de param&egrave;tre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> pour filtrer la recherche sur la valeur d\'un champs donn&eacute; ou bien un nom de type fixe parmi : <span class="vertclair">%s</span> pour utiliser un filtrage pr&eacute;d&eacute;finis.</li>
	<li><span class="keyword">paramValue</span> : Valeur du param&egrave;tre de la recherche. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
	<li><span class="keyword">mandatoryValue</span> : Bool&eacute;en (<span class="vertclair">true</span> ou <span class="vertclair">false</span>), permet de sp&eacute;cifier si ce param&egrave;tre de recherche est optionnel ou obligatoire.</li>
</ul>
<br />
Un param&egrave;tre suppl&eacute;mentaire <span class="keyword">operator</span> permet d\'ajouter un comportement sp&eacute;cifique au type de champs sur le filtre. La valeur accept&eacute;e par ce param&egrave;tre est expliqu&eacute;e dans l\'aide du champ concern&eacute; si il accepte un tel param&egrave;tre.</div>
<h3>Afficher une page donn&eacute;e de r&eacute;sultats (le nombre de r&eacute;sultats d\'une page est sp&eacute;cifi&eacute; par le tag atm-search-limit) :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-page search=&quot;<span class="keyword">searchName</span>&quot;  value=&quot;<span class="keyword">pageValue</span>&quot; /&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li><span class="keyword">pageValue</span> : Valeur num&eacute;rique de la page &agrave; afficher.</li>
</ul>
</div>
<h3>Limiter le nombre de r&eacute;sultats d\'une page :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-limit search=&quot;<span class="keyword">searchName</span>&quot; value=&quot;<span class="keyword">limitValue</span>&quot; /&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>
	<li><span class="keyword">limitValue</span> : Valeur num&eacute;rique de la limite &agrave; appliquer. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
</ul>
</div>
<h3>Ordonner les r&eacute;sultats :</h3>
<div class="retrait"><span class="code">&lt;atm-search-order search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">orderType</span>&quot; direction=&quot;<span class="keyword">directionValue</span>&quot; /&gt;</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>
	<li><span class="keyword">orderType</span> : Type de valeur sur lequel appliquer l\'ordre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> ou un nom de type fixe parmi : <span class="vertclair">%s</span>.</li>
	<li><span class="keyword">directionValue</span> : Sens &agrave; appliquer : <span class="vertclair">asc</span> pour croissant, <span class="vertclair">desc</span> pour d&eacute;croissant. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
</ul>
</div>
</div>
<h2>Fonctions :</h2>
<div class="retrait">
<h3>Afficher la liste des pages de la recherche en cours :</h3>
<div class="retrait">
<div class="code">&lt;atm-function function=&quot;pages&quot; maxpages=&quot;<span class="keyword">maxpagesValues</span>&quot; currentpage=&quot;<span class="keyword">currentpageValue</span>&quot; displayedpage=&quot;<span class="keyword">displayedpagesValue</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;pages&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/pages&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;currentpage&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/currentpage&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;start&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/start&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;previous&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/previous&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;next&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/next&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;end&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/end&gt;</span><br />
&lt;/atm-function&gt;</div>
<br />
<br />
Cette fonction permet d\'afficher la liste de toutes les pages possibles pour la recherche.<br />
<ul>
	<li><span class="keyword">maxpagesValue</span> : Nombre de page maximum sur lesquelles boucler (habituellement : <span class="vertclair">{maxpages}</span> ).</li>
	<li><span class="keyword">currentpageValue</span> : Num&eacute;ro de la page courante de la recherche (habituellement : <span class="vertclair">{currentpage}</span> ).</li>
	<li><span class="keyword">displayedpagesValue</span> : Nombre de pages &agrave; afficher.</li>
	<li>Le tag &lt;<span class="keyword">pages</span>&gt; sera lu pour chaque pages &agrave; lister except&eacute; la page courante et la valeur <span class="vertclair">{n}</span> sera remplac&eacute;e par le num&eacute;ro de la page.</li>
	<li>Le tag optionnel &lt;<span class="keyword">currentpage</span>&gt; sera lu pour la page en cours. Si il n\'existe pas, le tag &lt;<span class="keyword">pages</span>&gt; sera utilis&eacute; &agrave; la place.</li>
	<li>Le tag optionnel &lt;<span class="keyword">start</span>&gt; sera lu pour la premi&egrave;re page.</li>
	<li>Le tag optionnel &lt;<span class="keyword">previous</span>&gt; sera lu pour la page pr&eacute;c&eacute;dente.</li>
	<li>Le tag optionnel &lt;<span class="keyword">next</span>&gt; sera lu pour la page suivante.</li>
	<li>Le tag optionnel &lt;<span class="keyword">end</span>&gt; sera lu pour la derni&egrave;re page.</li>
</ul>
</div>
</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (111, 'polymod', NOW(), 'Syntaxe des tags', 'Tags syntax');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (112, 'polymod', NOW(), 'Variables et fonctions des objets', 'Objects variables and functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (113, 'polymod', NOW(), 'Tags de travail', 'Working tags');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (114, 'polymod', NOW(), '<div class="rowComment">
	<h1>Tags de travail :</h1>
	<div class="retrait">
		<h3>Afficher le contenu du tag si la condition est remplie :</h3>
			<div class="retrait">
			<span class="code">
				&lt;atm-if what=&quot;<span class="keyword">condition</span>&quot;&gt; ... &lt;/atm-if&gt;
			</span>
			<ul>
				<li><span class="keyword">condition</span> : Condition &agrave; remplir pour afficher le contenu du tag. L\'usage courant est de valider la pr&eacute;sence d\'une valeur non nulle. Cette condition peut aussi prendre toutes les formes valides d\'une condition PHP (voir : <a target="_blank" href="http://www.php.net/if" class="admin">Les structures de contr&ocirc;le en PHP</a>). La condition sera remplie si la valeur existe ou bien n\'est pas nulle ou bien n\'est pas &eacute;gale &agrave; faux (false).</li>
			</ul>
			</div>
		<h3>Boucler sur un ensemble d\'objets :</h3>
			<div class="retrait">
			<span class="code">&lt;atm-loop on=&quot;<span class="keyword">objets</span>&quot;&gt; ... &lt;/atm-loop&gt;</span>
			<ul>
				<li><span class="keyword">objets</span> : Collection d\'objets. Employ&eacute; pour traiter tous les objets d\'un ensemble d\'objets multiple (dit multi-objet).</li>
			</ul>
			Les valeurs suivantes seront remplac&eacute;es dans le tag :
			<ul>
				<li><span class="vertclair">{firstloop}</span> : Vrai si l\'objet en cours est le premier de la liste d\'objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l\'objet en cours est le dernier de la liste d\'objets.</li>
				<li><span class="vertclair">{loopcount}</span> : Num&eacute;ro de l\'objet en cours dans la liste d\'objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l\'objet en cours est le dernier de la liste d\'objets.</li>
				<li><span class="vertclair">{maxloops}</span> : Nombre d\'objets sur lesquels boucler.</li>
			</ul>
			</div>
		<h3>Ajouter un attribut au tag XHTML p&egrave;re (contenant ce tag) :</h3>
			<div class="retrait">
			<span class="code">
				&lt;atm-parameter attribute=&quot;<span class="keyword">attributeName</span>&quot; value=&quot;<span class="keyword">attributeValue</span>&quot; /&gt;
			</span>
			<ul>
				<li><span class="keyword">attributeName</span> : Nom de l\'attribut &agrave; ajouter.</li>
				<li><span class="keyword">attributeValue</span> : Valeur de l\'attribut &agrave; ajouter.</li>
			</ul>
			</div>
		<h3>Assigner une valeur &agrave; une variable :</h3>
			<div class="retrait">
			<span class="code">&lt;atm-setvar vartype=&quot;<span class="keyword">type</span>&quot; varname=&quot;<span class="keyword">name</span>&quot; value=&quot;<span class="keyword">varValue</span>&quot; /&gt;
			</span>
			<ul>
				<li><span class="keyword">type </span>: Type de la variable &agrave; assigner : <span class="vertclair">request</span>, <span class="vertclair">session</span> ou <span class="vertclair">var</span>.</li>
				<li><span class="keyword">name </span>: Nom de la variable &agrave; assigner. Attention, r&eacute;assigner une variable existante supprimera l\'ancienne valeur.</li>
				<li><span class="keyword">varValue</span> : valeur &agrave; assigner &agrave; la variable.</li>
			</ul>
			</div>
	</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (115, 'polymod', NOW(), 'Bloc de données', 'Datas block');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (116, 'polymod', NOW(), '<div class="rowComment">
	<h1>Bloc de donn&eacute;es du module :</h1>
	<div class="retrait">
	<span class="code">
		&lt;block module=&quot;%s&quot; id=&quot;<span class="keyword">blockID</span>&quot; language=&quot;<span class="keyword">languageCode</span>&quot;&gt; ... &lt;/block&gt;
	</span>
	<br/><br/>
	Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; ce module. Il doit entourer tout ensemble de tags relatif &agrave; un traitement de donn&eacute;es du module.<br />
	<ul>
		<li><span class="keyword">blockID </span>: Identifiant unique du bloc de contenu dans la rang&eacute;e. Deux blocs de contenus d\'une m&ecirc;me rang&eacute;e ne doivent pas avoir d\'identifiants identiques.</li>
		<li><span class="keyword">languageCode </span>: (facultatif) Code du langage relatif &agrave; ce bloc de contenu parmi les codes suivants : <span class="vertclair">%s</span>. <br/>Si non présent, la langue de la page sera utilisée. Si non présente, la langue par défaut d\'Automne sera utilisée.</li>
	</ul>
	</div>
</div>', 'TODO %s %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (117, 'polymod', NOW(), 'Libellé de l\'objet, correspond à sa valeur', 'Object label, same as object value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (118, 'polymod', NOW(), 'Libellé du champ : \'%s\'', 'Field label : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (119, 'polymod', NOW(), 'Identifiant du champ : \'%s\'', 'Field id : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (120, 'polymod', NOW(), 'Valeur du champ', 'Field value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (121, 'polymod', NOW(), 'Nom de l\'objet', 'Object name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (122, 'polymod', NOW(), 'Variables de l\'objet', 'Object vars');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (123, 'polymod', NOW(), 'Fonctions de l\'objet', 'Object functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (124, 'polymod', NOW(), 'Sélection des paramètres de recherche de la rangée \'%s\' du module \'%s\'', 'Parameters selection for row \'%s\' of module \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (125, 'polymod', NOW(), 'Pour la recherche ayant l\'identifiant \'%s\' dans cette rangée', 'For search with \'%s\' ID in this row');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (126, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Elle porte sur un objet inexistant.]', '[Error : search with \'%s\' ID in \'%s\' row is not valid : It relates to a non-existent object.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (127, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Un de ses paramètre porte sur un champ inexistant.]', '[Error : search with \'%s\' ID in \'%s\' row is not valid : One of its parameter relates to a non-existent field.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (128, 'polymod', NOW(), 'Nombre de résultats par pages', 'Number of results per pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (129, 'polymod', NOW(), 'Croissant', 'Ascending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (130, 'polymod', NOW(), 'Décroissant', 'Descending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (131, 'polymod', NOW(), 'Ordre d\'affichage', 'Display order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (132, 'polymod', NOW(), 'Par création d\'objets', 'By object creation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (133, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Le type de l\'un de ses paramètres est inconnu : \'%s\']', '[Error : search with \'%s\' ID in \'%s\' row is not valid : The type of the one of its parameters is unknown : \'%s\']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (134, 'polymod', NOW(), 'Publié à partir du', 'Published from');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (135, 'polymod', NOW(), 'Publié jusqu\'au', 'Published to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (136, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Le type de l\'un de ses paramètres de tri est inconnu : \'%s\']', '[Error : search with \'%s\' ID in \'%s\' row is not valid : The type of the one of its sort parameters is unknown : \'%s\']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (137, 'polymod', NOW(), 'Par date de début de publication', 'By publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (138, 'polymod', NOW(), 'Par date de fin de publication', 'By publication date end');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (139, 'polymod', NOW(), '<div class="rowComment">
	<h1>Variables g&eacute;n&eacute;rales :</h1>
	<div class="retrait">
	<h3>Variables relatives aux pages :</h3>
		<div class="retrait">
			Les variables relatives aux pages sont de la forme <span class="vertclair">{page:<span class="keyword">id</span>:<span class="keyword">type</span>}</span>:
			<ul>
				<li><span class="keyword">id </span>: Identifiant de la page &agrave; laquelle faire r&eacute;f&eacute;rence, peut-&ecirc;tre un identifiant num&eacute;rique d\'une page ou bien \'<span class="vertclair">self</span>\' pour faire r&eacute;f&eacute;rence &agrave; la page courante.</li>
				<li><span class="keyword">type</span> : type de donn&eacute;e souhait&eacute; pour la page parmi les suivant : <span class="vertclair">url </span>(adresse de la page), <span class="vertclair">printurl </span>(adresse de la page d\'impression), <span class="vertclair">id </span>(identifiant de la page), <span class="vertclair">title </span>(nom de la page).</li>
			</ul>
		</div>
	<h3>Variables relatives aux donn&eacute;es envoy&eacute;es (via une adresse ou un formulaire) :</h3>
		<div class="retrait">
		Ces variables correspondent &agrave; une variable provenant de la soumission d\'un formulaire ou bien d\'un param&egrave;tre du lien ayant amen&eacute; &agrave; la page en cours. <br />
		Elles sont de la forme <span class="vertclair">{request:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant : <br />
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">safestring </span>: cha&icirc;ne de caract&egrave;re sans code HTML,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom du param&egrave;tre dans l\'url ou bien nom du champ du formulaire).</li>
		</ul>
		</div>
	<h3>Variables de session :</h3>
		<div class="retrait">
		Ces variables sont disponible tout au long de la navigation du visiteur sur le site. <br />
		Elles sont de la forme <span class="vertclair">{session:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable de session).</li>
		</ul>
		</div>
	<h3>Variables&nbsp;:</h3>
		<div class="retrait">
		Ces variables correspondent &agrave; des variables PHP classiques. <br />
		Elles sont de la forme <span class="vertclair">{var:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable PHP).</li>
		</ul>
		</div>
	</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (140, 'polymod', NOW(), 'Variables générales', 'General variables');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (141, 'polymod', NOW(), 'Identifiant unique de l\'objet', 'Unique ID for object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (142, 'polymod', NOW(), 'Libellé de l\'objet', 'Object label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (143, 'polymod', NOW(), 'Nom de l\'objet : \'%s\'', 'Object name : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (144, 'polymod', NOW(), 'Description de l\'objet : \'%s\'', 'Object description : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (145, 'polymod', NOW(), 'Identifiant de type de l\'objet : \'%s\'', 'Object type ID : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (146, 'polymod', NOW(), 'Identifiant du champ auquel l\'objet appartient (si il existe)', 'Identifier of the field to which the object belongs (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (147, 'polymod', NOW(), 'Identifiant de ressource de l\'objet', 'Object resource ID');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (148, 'polymod', NOW(), 'Ensemble des objets de type \'%s\' associés à ce  champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Objects of type \'%s\' associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (149, 'polymod', NOW(), 'Nombre d\'objets de type \'%s\' associés à ce champ', 'Count of objects of the type \'%s\' associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (150, 'polymod', NOW(), 'Date format&eacute;e. Remplacez \'format\' par la valeur correspondant au format accept&eacute; en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur \'<strong>rss</strong>\' pour sp&eacute;cifier le format.', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>. For a date used in an RSS feed, use \'<strong>rss</strong>\' to specify the format.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (151, 'polymod', NOW(), 'Adresse du lien (URL)', 'Link address (URL)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (152, 'polymod', NOW(), 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (153, 'polymod', NOW(), 'Cible du lien (_blank, _top, etc.)', 'Link target (_blank, _top, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (154, 'polymod', NOW(), 'Type de lien (interne, externe, fichier, etc.)', 'Link type (internal, external, file, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (155, 'polymod', NOW(), 'Code HTML complet du lien. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Complete HTML code of the link. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (156, 'polymod', NOW(), 'Identifiant de la catégorie racine de ce champ', 'Root category ID for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (157, 'polymod', NOW(), 'Nombre de catégories associées à ce champ', 'Number of categories associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (158, 'polymod', NOW(), 'Catégories associées à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Categories associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (159, 'polymod', NOW(), 'Identifiant d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (160, 'polymod', NOW(), 'Libellé d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category label of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (161, 'polymod', NOW(), 'Identifiant de la catégorie du champ', 'Id of the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (162, 'polymod', NOW(), '<strong>Liste de tous les objets d\'un type donn&eacute; :</strong><br /><br /><span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les objets du m&ecirc;me type que l\'objet pass&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.<br /><ul><li><span class="keyword">selectedID : </span>Identifiant de l\'objet &agrave; selectionner dans la liste</li></ul><br />', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (163, 'polymod', NOW(), '<strong>Arborescence de cat&eacute;gories : </strong><br />
<br />
<span class="code">&lt;atm-function function=&quot;categoriesTree&quot; object=&quot;%s&quot; root=&quot;<span class="keyword">rootID</span>&quot; maxlevel=&quot;<span class="keyword">maxLevel</span>&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;item&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/item&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;itemselected&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/itemselected&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;template&gt;</span>&lt;ul&gt;<span class="vertclair">{sublevel}</span>&lt;/ul&gt;<span class="keyword">&lt;/template&gt;</span><br />
&lt;/atm-function&gt;<strong><br />
</strong></span>
<p>Cette Fonction permet d\'afficher une arborescence de cat&eacute;gories.</p>
<ul> <strong>	</strong>
	<li><span class="keyword">rootID </span>: L\'identifiant de la cat&eacute;gorie devant servir de racine &agrave; l\'arborescence.</li>
	<li><span class="keyword">maxLevel </span>: Nombre de niveaux maximum &agrave; afficher pour l\'arborescence (facultatif).</li>
	<li><span class="keyword">selectedID </span>: Cat&eacute;gorie actuellement s&eacute;lectionn&eacute;e (facultatif).</li>
	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>
	<li>Le tag &lt;<span class="keyword">item</span>&gt; sera lu pour chaque cat&eacute;gorie &agrave; lister. La valeur <span style="font-weight: bold;"><span class="vertclair">{id}</span> </span>sera remplac&eacute;e par l\'identifiant de la cat&eacute;gorie en cours, la valeur <span class="vertclair">{label}</span> par son libell&eacute;. La valeur <span class="vertclair">{lvl}</span> sera remplac&eacute;e par le num&eacute;ro du niveau en cours dans l\'arborescence et la valeur <span class="vertclair">{sublevel}</span> par le niveau suivant dans l\'arborescence.</li>
	<li>Le tag &lt;<span class="keyword">template</span>&gt; sera lu au d&eacute;but de chaque niveau d\'arborescence. La valeur <span class="vertclair">{sublevel}</span> sera remplac&eacute;e par le contenu du niveau d\'arborescence en cours.</li>
	<li>Le tag &lt;<span class="keyword">itemselected</span>&gt; sera lu pour la cat&eacute;gorie actuellement selectionn&eacute;e (facultatif).</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (164, 'polymod', NOW(), '<strong>Hi&eacute;rarchie - Historique de cat&eacute;gories :</strong><br />
<br />
<span class="code"> &lt;atm-function function=&quot;categoryLineage&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot; root=&quot;<span class="keyword">rootCatID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;ancestor&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/ancestor&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;self&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/self&gt;</span><br />
&lt;/atm-function&gt;</span><strong><br />
</strong>Cette fonction permet d\'afficher la hi&eacute;rarchie parente (historique) d\'une cat&eacute;gorie donn&eacute;e.
<ul>
    <li><strong><span class="keyword">categoryID </span>: </strong>L\'identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>
    <li><strong><span class="keyword">rootCatID </span>: </strong>L\'identifiant de la cat&eacute;gorie à partir de laquelle on souhaite afficher la hi&eacute;rarchie (facultatif si "catégorie de plus haut niveau" sélectionnée, obligatoire dans le cas contraire).</li>
    <li>Le tag <strong>&lt;<span class="keyword">ancestor</span>&gt;</strong> sera lu pour chaque anc&egrave;tre de la cat&eacute;gorie trouv&eacute;. La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
    <li>Le tag optionel <strong>&lt;<span class="keyword">self</span>&gt;</strong> sera lu pour la cat&eacute;gorie dont on affiche la hierarchie (si le tag n\'existe pas, le tag &lt;<span class="keyword">ancestor</span>&gt; sera employ&eacute;). La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie&nbsp; dont on affiche la hierarchie, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (165, 'polymod', NOW(), '<strong>Liste de toutes les cat&eacute;gories d\'un champ donn&eacute; :</strong><br />
<br />
<span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />
Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant toutes les cat&eacute;gories et sous cat&eacute;gories d\'un champ donn&eacute;. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.
<ul>
	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de la cat&eacute;gorie &agrave; selectionner dans la liste (facultatif)</li>
	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>
	<li><span class="keyword">editableonly </span>: Bool&eacute;en <span class="vertclair">true, false</span>, arffiche uniquement les cat&eacute;gories &eacute;ditables (facultatif, d&eacute;faut : false).</li>
	<li><span class="keyword">root </span>: L\'identifiant de la cat&eacute;gorie &agrave; employer comme racine.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (166, 'polymod', NOW(), 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (167, 'polymod', NOW(), 'Permet de catégoriser les objets et de gérer leurs droits d\'accès', 'Allows you to categorize objects and to manage their access rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (168, 'polymod', NOW(), 'Catégories multiples', 'Multiples categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (169, 'polymod', NOW(), 'Catégorie de plus haut niveau', 'Top level category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (170, 'polymod', NOW(), 'Date', 'Date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (171, 'polymod', NOW(), 'Champ contenant une date au format de la langue courante', 'Field containing a date with the current language format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (172, 'polymod', NOW(), 'Si le champ est vide, enregistrer la date du jour', 'If the field is empty, record the current date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (173, 'polymod', NOW(), 'Avec gestion des Heures - minutes - secondes', 'With management of Hours - minutes - seconds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (174, 'polymod', NOW(), 'hh:mm:ss', 'hh:mm:ss');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (175, 'polymod', NOW(), 'Lien', 'Link field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (176, 'polymod', NOW(), 'Champ contenant un lien vers un site externe, une page ou un fichier.', 'Field containing a link to an external site, a page or a file.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (177, 'polymod', NOW(), 'Nombre entier', 'Integer number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (178, 'polymod', NOW(), 'Nombre entier de 11 chiffres maximum', 'Integer number containing 11 digits maximum');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (179, 'polymod', NOW(), 'Peut-être nul', 'Can be null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (180, 'polymod', NOW(), 'Peut-être négatif', 'Can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (181, 'polymod', NOW(), 'Champ texte', 'Text field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (182, 'polymod', NOW(), 'Champ de texte long, avec ou sans HTML', 'Long text field, with or without HTML');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (183, 'polymod', NOW(), 'HTML autorisé', 'HTML allowed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (184, 'polymod', NOW(), 'Type de barre d\'outil pour l\'éditeur de texte (wysiwyg)', 'Toolbar type for the text editor (wysiwyg)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (185, 'polymod', NOW(), 'Chaîne de caractères', 'Characters string');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (186, 'polymod', NOW(), 'Chaîne contenant 255 caractères maximum sans HTML. Peut-être un email.', 'String containing 255 characters maximum without HTML. Can be an email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (187, 'polymod', NOW(), 'Nombre maximum de charactères :<br /><small>(255 maximum)</small>', 'Max count of caracters :<br /><small>(255 max)</small>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (188, 'polymod', NOW(), 'Objet inconnu', 'Unknown object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (189, 'polymod', NOW(), 'Cet objet n\'est pas défini', 'This object is not defined');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (190, 'polymod', NOW(), 'Multiples objets \'%s\'', 'Multiple objects \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (191, 'polymod', NOW(), 'Objet composé de multiples objets \'%s\'', 'Object composed with Multiple objects \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (192, 'polymod', NOW(), 'Ces objets peuvent être édités ?', 'These objects can be edited?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (193, 'polymod', NOW(), 'Création d\'un élément \'%s\' à associer', 'Create \'%s\' element to associate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (194, 'polymod', NOW(), 'Edition d\'un objet \'%s\'', 'Edit \'%s\' object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (195, 'polymod', NOW(), 'Eléments \'%s\' actuellement associés', 'Currently associated \'%s\' elements');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (196, 'polymod', NOW(), 'Associer un objet \'%s\' existant', 'Associate an existing object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (197, 'polymod', NOW(), 'Forcer le chargement des sous objets ?', 'Force subobjects loading?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (198, 'polymod', NOW(), 'Attention, ce paramètre doit rester désactivé sauf si des données sont manquantes lors de certains chargements. Activer ce paramètre peut entraîner une perte de performance très importante.', 'Attention, this parameter must remain inactived except if data are missing during some loadings. Activate this parameter can involve a very significant loss of performance.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (199, 'polymod', NOW(), 'Uniquement les objets répondant à ces paramètres', 'Only objects with these parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (200, 'polymod', NOW(), 'Image', 'Image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (201, 'polymod', NOW(), 'Champ contenant une image avec ou sans image zoom', 'Field with an image, with or without zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (202, 'polymod', NOW(), 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (203, 'polymod', NOW(), 'Date de début de publication formatée. Remplacez \'format\' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (204, 'polymod', NOW(), 'Date de fin de publication formatée (si elle existe). Remplacez \'format\' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (205, 'polymod', NOW(), 'Utiliser la vignette originale pour l\'image zoom', 'Use original thumbnail as zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (206, 'polymod', NOW(), 'Vignette', 'Thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (207, 'polymod', NOW(), 'Image zoom', 'Zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (208, 'polymod', NOW(), '(La vignette sera redimensionnée à %s pixels de large)', '(Thumbnail will be resized to %s pixels width)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (209, 'polymod', NOW(), 'Utiliser une image zoom distincte', 'Use distinct zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (210, 'polymod', NOW(), '(Si vous n\'utilisez pas d\'image zoom distincte)', '(If you do no uses a distinct image zoom)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (211, 'polymod', NOW(), 'Conserver l\'image originale comme image zoom', 'Keep original image as an image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (212, 'polymod', NOW(), '(Si la vignette dépasse cette largeur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (213, 'polymod', NOW(), 'Cochez la case pour effacer l\'image', 'Check the box to delete image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (214, 'polymod', NOW(), 'Image actuelle', 'Current image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (215, 'polymod', NOW(), 'Code HTML de l\'image. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Image HTML code. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (216, 'polymod', NOW(), 'Libellé de l\'image', 'Image label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (217, 'polymod', NOW(), 'Nom du fichier de l\'image', 'Image file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (218, 'polymod', NOW(), 'Nom du fichier de l\'image zoom', 'Image file name zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (219, 'polymod', NOW(), 'Chemin du repertoire de l\'image et de l\'image zoom', 'Path to the image and image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (220, 'polymod', NOW(), 'Largeur de l\'image en pixels', 'Image width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (221, 'polymod', NOW(), 'Hauteur de l\'image en pixels', 'Image height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (222, 'polymod', NOW(), 'Largeur de l\'image zoom en pixels', 'Image zoom width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (223, 'polymod', NOW(), 'Hauteur de l\'image zoom en pixels', 'Image zoom height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (224, 'polymod', NOW(), 'Poids de l\'image en Mo', 'Image file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (225, 'polymod', NOW(), 'Poids de l\'image zoom en Mo', 'Image zoom file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (226, 'polymod', NOW(), 'La valeur du champ doit-être un email valide', 'Field value must be a valid email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (227, 'polymod', NOW(), 'Fichier', 'File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (228, 'polymod', NOW(), 'Champ contenant un fichier avec ou sans vignette', 'Field with a file, with or without thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (229, 'polymod', NOW(), 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (230, 'polymod', NOW(), 'Utiliser une vignette pour le fichier', 'Use thumbnail for file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (231, 'polymod', NOW(), '<!--Icônes de type pour les fichiers-->', '<!--Type icons for files-->');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (232, 'polymod', NOW(), 'Fichier source', 'Source file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (233, 'polymod', NOW(), 'ou Fichier FTP', 'or FTP file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (234, 'polymod', NOW(), 'Chemin du repertoire FTP à utiliser', 'Path for FTP directory to use');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (235, 'polymod', NOW(), '(Laissez vide pour empêcher l\'utilisation d\'un répertoire FTP comme source pour vos documents)', '(Leave empty to prevent the use of a FTP directory as a source for your documents');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (236, 'polymod', NOW(), '(max : %s)', '(max : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (237, 'polymod', NOW(), '(Répertoire FTP : %s)', '(FTP directory : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (238, 'polymod', NOW(), 'Chemin vers l\'icône du fichier (si elle existe)', 'Path to the file icon (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (239, 'polymod', NOW(), 'Type de fichier (extension)', 'File type (extension)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (240, 'polymod', NOW(), 'Cochez la case pour effacer le fichier', 'Check the box to delete file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (241, 'polymod', NOW(), 'Fichier actuel', 'Current file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (242, 'polymod', NOW(), 'Code HTML du fichier', 'File HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (243, 'polymod', NOW(), 'Libellé du fichier', 'File label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (244, 'polymod', NOW(), 'Nom du fichier', 'File name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (245, 'polymod', NOW(), 'Nom du fichier de la vignette', 'Thumbnail file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (246, 'polymod', NOW(), 'Chemin du repertoire du fichier et de la vignette', 'Path to the file and thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (247, 'polymod', NOW(), 'Largeur de la vignette en pixels', 'Thumbnail width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (248, 'polymod', NOW(), 'Hauteur de a vignette en pixels', 'Thumbnail height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (249, 'polymod', NOW(), 'Autoriser l\'utilisation de fichiers du repertoire FTP', 'Allow usage of FTP files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (250, 'polymod', NOW(), '(Permet, pour les gros fichiers, d\'utiliser un répertoire d\'automne pour déposer des fichiers via FTP)', '(Allow, for big files, to use an Automne directory to store files with FTP)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (251, 'polymod', NOW(), 'Poids du fichier en Mo', 'File Size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (252, 'polymod', NOW(), 'Renvoi vrai si l\'objet contient un lien valide.', 'Return true if object contain a valid link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (253, 'polymod', NOW(), 'Largeur maximum de l\'image en pixels', 'Image maximum width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (254, 'polymod', NOW(), 'Adresse de prévisualisation', 'Preview  address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (255, 'polymod', NOW(), 'Valeur HTML du texte (retours chariots convertis pour le texte seul)', 'HTML value of the text (Line breaks converted for plain-text)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (256, 'polymod', NOW(), 'Fichier associé à la catégorie du champ', 'File associated to the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (257, 'polymod', NOW(), 'Fichier d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category File of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (258, 'polymod', NOW(), 'Sans %s', 'Without %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (259, 'polymod', NOW(), 'Nombre d\'utilisateurs/groupes associées à ce champ', 'Number of users/groups associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (260, 'polymod', NOW(), 'Utilisateurs/Groupes associés à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Users/Groups associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (261, 'polymod', NOW(), 'Identifiant d\'un utilisateur/groupe du champ (utilisable dans un tag atm-loop)', 'One user/group ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (262, 'polymod', NOW(), 'Nom et prénom d\'un utilisateur ou nom d\'un groupe du champ (utilisable dans un tag atm-loop)', 'Lastname and firstname of one user or name of one group of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (263, 'polymod', NOW(), 'Identifiant de l\'utilisateur ou du groupe', 'Id of the user or group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (264, 'polymod', NOW(), 'Utilisateur/Groupe', 'User/Group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (265, 'polymod', NOW(), 'Permet d\'associer un ou plusieurs utilisateurs ou groupe(s) d\'utilisateurs', 'Allows you to associate one or more users or group(s) of users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (266, 'polymod', NOW(), 'Multiples utilisateurs ou groupes', 'Multiples users or groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (267, 'polymod', NOW(), 'Utiliser des groupes', 'Use groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (268, 'polymod', NOW(), 'La valeur est l\'utilisateur actuel', 'Value is the current user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (269, 'polymod', NOW(), 'Ce paramètre exclu les autres', 'This parameter exclude the others');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (270, 'polymod', NOW(), 'Si ce paramètre est sélectionné, vous pourrez utiliser des groupes d\'utilisateurs. Sinon, ce sera des utilisateurs', 'If this parameter is selected, you will use groups of users. Otherwise, it will be users.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (271, 'polymod', NOW(), '<strong>Liste de tous les utilisateurs/groupes du champ :<br />
</strong><br />
<span class="code"> &lt;select&gt;<strong>&lt;</strong>atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span><strong>&quot;&gt;&lt;/</strong>atm-function<strong>&gt;</strong>&lt;/select&gt;</span><br />
Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les utilisateurs/groupes du champ donn&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.<br />
<ul>
	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de l\'utilisateur/groupe &agrave; selectionner dans la liste</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (272, 'polymod', NOW(), 'Nom et prénom de l\'utilisateur ou nom du groupe', 'Lastname and firstname of the user or name of the group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (273, 'polymod', NOW(), 'Email d\'un utilisateur du champ (utilisable dans un tag atm-loop)', 'Email of one user of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (274, 'polymod', NOW(), 'Email de l\'utilisateur', 'Email of the user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (275, 'polymod', NOW(), 'Modules WYSIWYG associés', 'Associated WYSIWYG Plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (276, 'polymod', NOW(), 'Propriétés de l\'objet', 'Object properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (277, 'polymod', NOW(), 'Création / modification d\'un module WYSIWYG pour l\'objet \'%s\'', 'Create / Edit a WYSIWYG plugin for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (278, 'polymod', NOW(), 'Syntaxe de la définition du module WYSIWYG pour l\'objet \'%s\'', 'Syntax definition for the WYSIWYG plugin for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (279, 'polymod', NOW(), 'Confirmez-vous la suppression du module WYSIWYG \'%s\' ? Attention cette suppression est définitive, elle n\'est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the WYSIWYG plugin \'%s\'? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (280, 'polymod', NOW(), '[Erreur : Aucun module WYSIWYG disponible ...]', '[Error : No WYSIWYG plugin available ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (281, 'polymod', NOW(), 'Type', 'Type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (282, 'polymod', NOW(), 'Editeur de texte', 'Text editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (283, 'polymod', NOW(), 'Elément actuellement sélectionné', 'Item currently selected');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (284, 'polymod', NOW(), 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (285, 'polymod', NOW(), 'Déselectionner', 'Deselect');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (286, 'polymod', NOW(), '[Erreur : Ce module nécessite d\'avoir sélectionné un texte. Merci de sélectionner le texte souhaité ...]', '[Error : this plugin must have a selected text. Please select a text first ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (287, 'polymod', NOW(), 'Modules WYSIWYG', 'WYSIWYG plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (288, 'polymod', NOW(), '<div class="rowComment">
<h1>Bloc de donn&eacute;es d\'un module WYSIWYG :</h1>
<span class="code"> &lt;atm-plugin language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-valid&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-valid&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-invalid&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-invalid&gt;</span><br />
&lt;/atm-plugin&gt;</span><br />
<br />
Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l\'&eacute;diteur de texte visuel (WYSIWYG).<br />
Le <span class="keyword">tag atm-plugin-valid</span> sera lu si l\'objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />
Le tag <span class="keyword">atm-plugin-invalid </span>(facultatif) sera lu si l\'objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l\'utilisateur n\'a pas les droits de consultation de cet objet).<br />
<ul>
	<li><span class="keyword">languageCode </span>: Code du langage relatif au contenu parmi les codes suivants : <span class="vertclair">%s</span>.</li>
	<li><span class="keyword">{plugin:selection}</span> : Sera replac&eacute; par la valeur textuelle s&eacute;lectionn&eacute;e dans l\'&eacute;diteur (facultatif).</li>
</ul>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (289, 'polymod', NOW(), '<strong>Charge une cat&eacute;gorie donn&eacute;e :<br />
</strong><br />
<span class="code"> &lt;atm-function function=&quot;category&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <br />
&lt;/atm-function&gt;</span><strong><br />
</strong>Cette fonction permet d\'afficher le contenu d\'une cat&eacute;gorie donn&eacute;e.<br />
<ul>
	<li><span class="keyword">categoryID </span><strong>: </strong>L\'identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>
	<li>La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (290, 'polymod', NOW(), 'Fils RSS associés', 'Associated RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (291, 'polymod', NOW(), 'Confirmez-vous la suppression du fil RSS \'%s\' ? Attention cette suppression est définitive, elle n\'est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the RSS Feed \'%s\'? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (292, 'polymod', NOW(), 'Création / modification d\'un fil RSS pour l\'objet \'%s\'', 'Create / Edit an RSS feed for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (293, 'polymod', NOW(), 'Syntaxe de la définition du fil RSS pour l\'objet \'%s\'', 'Syntax definition for the RSS feed for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (294, 'polymod', NOW(), 'Fils RSS', 'RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (295, 'polymod', NOW(), '<strong>Bloc de donn&eacute;es d\'un module WYSIWYG :<br /><br />&lt;atm-plugin language=&quot;</strong>languageCode<strong>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-invalid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-invalid&gt;<br />&lt;/atm-plugin&gt;</strong><br /><br />Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l\'&eacute;diteur de texte visuel (WYSIWYG).<br />Le tag <strong>atm-plugin-valid</strong> sera lu si l\'objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />Le tag <strong>atm-plugin-invalid</strong> (facultatif) sera lu si l\'objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l\'utilisateur n\'a pas les droits de consultation de cet objet).<br /><ul><li><strong>languageCode</strong> : Code du langage relatif au contenu parmi les codes suivants : <strong>%s</strong>.</li><li><strong>{plugin:selection}</strong> : Sera replac&eacute; par la valeur s&eacute;lectionn&eacute;e dans le Wysiwyg (facultatif).</li></ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (296, 'polymod', NOW(), 'Adresse vers le site du fil', 'Address to the feed website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (297, 'polymod', NOW(), 'Ce lien sera employé dans le fil RSS et permettra d\'aller au site source du fil. Si ce champ n\'est pas rempli, l\'adresse \'%s\' sera utilisée.', 'This link will be used in the RSS feed and will allow to go to source website of the feed. If this field is not filled, the address \'%s\' will be used.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (298, 'polymod', NOW(), 'Auteur', 'Author');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (299, 'polymod', NOW(), 'Email de l\'auteur', 'Author email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (300, 'polymod', NOW(), 'Copyright', 'Copyright');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (301, 'polymod', NOW(), 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (302, 'polymod', NOW(), 'Liste de termes séparés par des virgules permettant de catégoriser le fil RSS', 'Terms list separated by commas allowing to categorize the RSS feed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (303, 'polymod', NOW(), 'Interval de mise à jour', 'Update interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (304, 'polymod', NOW(), 'Permet aux lecteurs de fils RSS d\'avoir une valeur indicative concernant la fréquence de mise à jour du fil. Par défaut : une fois par jour, minimum : 2 fois par heures.', 'Give to the feed reader an indicative value of the update frequency of the feed. By default : once a day, minimum : twice an hours');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (305, 'polymod', NOW(), 'Fréquence dans cet interval', 'Frequency in this interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (306, 'polymod', NOW(), 'Horaire', 'Hourly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (307, 'polymod', NOW(), 'Quotidienne', 'Daily');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (308, 'polymod', NOW(), 'Hebdomadaire', 'Weekly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (309, 'polymod', NOW(), 'Mensuelle', 'Monthly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (310, 'polymod', NOW(), 'Annuelle', 'Yearly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (311, 'polymod', NOW(), '<strong>Permet de faire un lien vers l\'un des fil RSS de l\'objet&nbsp; :<br />
</strong><br />
<span class="code">&lt;atm-function function=&quot;rss&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">rssId</span>&quot; attributeName=&quot;<span class="keyword">attributeValue</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; &lt;a href=&quot;<span class="vertclair">{url}</span>&quot; title=&quot;<span class="vertclair">{description}</span>&quot;&gt;<span class="vertclair">{label}</span>&lt;/a&gt;<br />
&lt;/atm-function&gt;</span><br />
Cette fonction permet d\'obtenir les informations concernant l\'un des fil RSS de l\'objet. Elle est usuellement utilis&eacute;e pour r&eacute;aliser un lien d\'abonnement vers ce fil RSS.<br />
<ul>
	<li><span class="keyword">rssId </span><strong>: </strong>Identifiant du fil RSS &agrave; selectionner parmis les suivants : %s</li>
	<li>L\'attribut <span class="keyword">attributeName </span>et sa valeur <span class="keyword">attributeValue </span>sont facultatifs. Ils permettent d\'ajouter un attribut et sa valeur &agrave; l\'adresse du fil RSS g&eacute;n&eacute;r&eacute; par la fonction. Vous pouvez mettre autant d\'attributs suppl&eacute;mentaires de cette fa&ccedil;on.</li>
	<li><span class="vertclair">{url}</span> sera remplac&eacute; par l\'adresse du fil RSS.</li>
	<li><span class="vertclair">{label}</span> sera remplac&eacute; par le libell&eacute; du fil RSS.</li>
	<li><span class="vertclair">{description}</span> sera remplac&eacute; par la description du fil RSS.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (312, 'polymod', NOW(), '<strong>Permet de charger un objet par son identifiant&nbsp; :<br />
<br />
</strong><span class="code">&lt;atm-function function=&quot;loadObject&quot; object=&quot;%s&quot; value=&quot;<span class="keyword">objectId</span>&quot;&gt;&lt;/atm-function&gt;</span><br />
Cette fonction permet de charger depuis la base de donn&eacute;e l\'objet correspondant &agrave; l\'identifiant fourni en param&egrave;tre. L\'objet ainsi charg&eacute; devient accessible m&ecirc;me en dehors d\'une recherche.<br />
<ul>
	<li><span class="keyword">objectId </span><strong>: </strong>Identifiant unique de l\'objet &agrave; charger.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (313, 'polymod', NOW(), '<div class="rowComment">
<h1>Bloc de donn&eacute;es d\'un fil RSS :</h1>
<span class="code">&lt;atm-rss language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-title&gt;</span><br />
&nbsp;&nbsp;&nbsp; &lt;atm-search ...&gt;<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;atm-result ...&gt;<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="keyword"> &lt;atm-rss-item&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-url&gt;</span>{page:id:url}?item={object:id}<span class="keyword">&lt;/atm-rss-item-url&gt; </span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-title&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-content&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-content&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-author&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-author&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-date&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-date&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-category&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-category&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-rss-item&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;/atm-result&gt;<br />
&nbsp;&nbsp;&nbsp; &lt;/atm-search&gt;<br />
&lt;/atm-rss&gt;</span><br />
<br />
Ce tag permet de cr&eacute;er un fil RSS &agrave; partir d\'objets r&eacute;pondant &agrave; une recherche.<br />
<ul>
	<li><strong><span class="keyword">languageCode </span></strong>: Code du langage relatif au contenu parmi les codes suivants : <strong><span class="vertclair">%s</span></strong>.</li>
</ul>
Le tag <span class="keyword">atm-rss</span> peut contenir un tag <span class="keyword">atm-rss-title</span> (facultatif) permettant de red&eacute;finir le titre du fil RSS. <br />
Le tag <span class="keyword">atm-rss</span><strong> </strong>doit contenir un sous tag <span class="keyword">atm-rss-item</span> lui m&ecirc;me devant &ecirc;tre dans un r&eacute;sultat d\'une recherche. Pour chaque &eacute;l&eacute;ment r&eacute;sultat de la recherche, ce tag permettra la cr&eacute;ation d\'un &eacute;l&eacute;ment correspondant dans le fil RSS.<br />
<br />
Le tag <span class="keyword">atm-rss-item</span> doit<strong> </strong>contenir les sous tags suivants :<br />
<ul>
	<li><span class="keyword">atm-rss-item-url</span><strong> :</strong> Tag obligatoire, il permet de sp&eacute;cifier l\'adresse internet source de l\'&eacute;l&eacute;ment du fil RSS (Les aggr&eacute;gateurs RSS s\'en servent pour cr&eacute;er un lien vers cet &eacute;l&eacute;ment sur votre site). Ce doit donc &ecirc;tre une adresse valide vers l\'&eacute;l&eacute;ment source. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-title</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le nom de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-content</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le contenu de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML y est autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
</ul>
Le tag <span class="keyword">atm-rss-item</span> peut<strong> </strong>contenir les sous tags suivants :<br />
<ul>
	<li><span class="keyword">atm-rss-item-author</span><strong> : </strong>Ce tag permet de sp&eacute;cifer l\'auteur de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-date</span><strong> :</strong> Ce tag permet de sp&eacute;cifer la date de cr&eacute;ation de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item. Pensez &agrave; employer le format <span class="vertclair">rss</span> si vous employez la valeur d\'un champ de type Date.</li>
	<li><span class="keyword">atm-rss-item-category</span><strong> :</strong> Ce tag permet de sp&eacute;cifer une le nom d\'une cat&eacute;gorie pour l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Vous pouvez mettre plusieurs tags de ce type dans chaque tag atm-rss-item.</li>
</ul>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (314, 'polymod', NOW(), 'Utilisateurs', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (315, 'polymod', NOW(), 'Groupes', 'Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (316, 'polymod', NOW(), 'Tous les utilisateurs', 'All users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (317, 'polymod', NOW(), 'Utilisateurs inclus/exclus', 'Included/excluded users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (318, 'polymod', NOW(), 'Tous les groupes', 'All groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (319, 'polymod', NOW(), 'Groupes inclus/exclus', 'Included/excluded groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (320, 'polymod', NOW(), 'Inclusion', 'Inclusion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (321, 'polymod', NOW(), 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés sont affichés dans la liste déroulante du champs.<br/>"non" : les utilisateurs sélectionnés sont exclus de la liste déroulante du champs.', 'If this parameter is :<br/>"yes" : only selected users/groups are display in the selection box of the field.<br/>"no" : selected users are excluded of the selection box of the field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (322, 'polymod', NOW(), 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (323, 'polymod', NOW(), 'Langue', 'Language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (324, 'polymod', NOW(), 'Langue de l\'objet. Créé une relation avec les langues disponibles sur le système. Nécessaire à l\'indexation correcte dans le moteur de recherche.', 'Language of the object. It create a relationship with system\'s languages. Needed for a correct indexation in search engine.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (325, 'polymod', NOW(), 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (326, 'polymod', NOW(), 'Indexation', 'Indexation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (327, 'polymod', NOW(), 'Si cet objet appartient en tant que champs à un objet indexé, inutile de l\'indexer lui même', 'If this object belongs as a field to an indexed object, it is useless to index itself');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (328, 'polymod', NOW(), 'Adresse du lien vers l\'objet', 'Link address to the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (329, 'polymod', NOW(), 'Cette adresse devra permettre d\'aller vers l\'objet à partir des résultats de recherche.', 'This address will have to make possible to go towards the object from the search results.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (330, 'polymod', NOW(), 'Indexer uniquement le dernier sous-objet', 'Index only the last sub-object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (331, 'polymod', NOW(), 'Cette option est utile pour le versioning d\'objets ou les versions antérieures ne doivent pas être indexées dans le moteur de recherche.', 'This option is usefull in case of object versioning which older versions does not need to be indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (332, 'polymod', NOW(), 'Désactiver l\'association de sous-objets', 'Disactivate selection of sub-objets');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (333, 'polymod', NOW(), 'Cette option permet d\'empêcher l\'emploi de sous-objets crées en dehors de l\'objet principal. Elle n\'est utile que si l\'option "Ces objets peuvent être édités" est active.', 'This option avoid the use of objects which are not created inside the master object. It is usefull only if the option "These objects can be edited" is active.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (334, 'polymod', NOW(), 'Contourner les droits', 'Bypass rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (335, 'polymod', NOW(), 'Permet de ne pas tenir compte des droits de ces catégories pour les recherches', 'Do not use categories rights management for searching');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (336, 'polymod', NOW(), 'Notification par email', 'Notify by email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (337, 'polymod', NOW(), 'Ce champs permet d\'envoyer une notification par email lors de la validation d\'un objet', 'This field allow email notification when object is validated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (338, 'polymod', NOW(), 'Sujet de l\'email', 'Email subject');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (339, 'polymod', NOW(), 'Corps de l\'email', 'Email body');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (340, 'polymod', NOW(), 'Emission au choix', 'Choice for sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (341, 'polymod', NOW(), 'Hauteur de l\'éditeur', 'Editor height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (342, 'polymod', NOW(), 'Largeur de l\'éditeur', 'Editor width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (343, 'polymod', NOW(), 'Permet de choisir lors de l\'édition de l\'objet si l\'email doit être envoyé', 'Allow to choose if the email will be sent at object edition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (344, 'polymod', NOW(), 'Inclure des fichiers', 'Include files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (345, 'polymod', NOW(), 'Permet d\'inclure les fichiers de l\'objet en pièce jointe dans l\'email', 'Allow the inclusion as attachment of object files in the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (346, 'polymod', NOW(), 'Emetteur de l\'email', 'Email sender');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (347, 'polymod', NOW(), 'Permet de spécifier une adresse d\'emetteur pour l\'email. Si aucun, l\'adresse "postmaster" d\'Automne sera employée.', 'Allow usage of a specific email address for email sending. If none, "postmaster" Automne email will be used');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (348, 'polymod', NOW(), 'A la validation', 'On validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (349, 'polymod', NOW(), 'Evènement système', 'System event');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (350, 'polymod', NOW(), 'Emission', 'Sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (351, 'polymod', NOW(), 'L\'email sera envoyé à la validation de l\'objet ou déclenché par un évènement système à spécifier (code PHP spécifique).', 'Email will be sent at validation or by a specified system event (specific PHP code).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (352, 'polymod', NOW(), 'Syntaxe de la définition du sujet et du corps de l\'email', 'Syntax definition for the subject and body of the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (353, 'polymod', NOW(), 'Où choisir une page', 'Or choose a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (354, 'polymod', NOW(), 'Code HTML', 'HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (355, 'polymod', NOW(), 'Dernier envoi', 'Last sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (356, 'polymod', NOW(), 'Jamais', 'Never');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (357, 'polymod', NOW(), 'Actif', 'Active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (358, 'polymod', NOW(), 'Inactif', 'inactive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (359, 'polymod', NOW(), 'Preparation des notifications par email', 'Prepare emails notifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (360, 'polymod', NOW(), 'Envoi d\'une notification email', 'Sending email notification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (361, 'polymod', NOW(), 'Autoriser l\'association des inutilisées', 'Allow association of the unused ones');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (362, 'polymod', NOW(), 'Permet de sélectionner les catégories inutilisées dans les rangées', 'Allow association of the unused categories in rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (363, 'polymod', NOW(), 'Libellé des objets (séparés par des virgules, ou spécifiez un séparateur en paramètre)', 'Objects labels (comma separated or specify a separator in parameter)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (364, 'polymod', NOW(), 'Notification de validation en attente', 'Notification of awaiting validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (365, 'polymod', NOW(), 'Notification de suppression en attente', 'Notification of deletion validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (366, 'polymod', NOW(), 'Champ requis (renvoie un booléen true ou false)', 'Required field (return a boolean true or false)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (367, 'polymod', NOW(), 'Catégorie par défaut', 'Default category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (368, 'polymod', NOW(), 'Date de création de l\'objet', 'Creation date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (369, 'polymod', NOW(), 'Décalage temporel', 'Time offset');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (370, 'polymod', NOW(), 'Si "Date du jour", "Date de création" ou "Date de mise à jour" est sélectionné, décaler la valeur de cette durée (Voir le <a href="http://www.php.net/manual/fr/function.strtotime.php" target="_blank" class="admin">format de la fonction strtotime</a>)', 'If "Current date", "Creation date" or "Update date" is selected, offset the date of this value (See the <a href="http://www.php.net/manual/en/function.strtotime.php" target="_blank" class="admin">function strtotime format</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (371, 'polymod', NOW(), 'Date de mise à jour de l\'objet', 'Update date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (372, 'polymod', NOW(), 'Format à respecter', 'Format to comply');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (373, 'polymod', NOW(), 'Ce champ vous permet de spécifier un format à respecter en utilisant une expression régulière PERL (<a href="http://www.php.net/manual/fr/reference.pcre.pattern.syntax.php" target="_blank" class="admin">voir l\'aide du format</a>)', 'This field allow you to specify a format to match using a PERL regular expression (<a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank" class="admin">see format help</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (374, 'polymod', NOW(), 'Extensions autorisées', 'Allowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (375, 'polymod', NOW(), 'Séparées par une virgule', 'Comma separated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (376, 'polymod', NOW(), 'Extensions interdites', 'Disallowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (377, 'polymod', NOW(), 'Utilisateur créant l\'objet', 'User creating object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (378, 'polymod', NOW(), 'Opérateurs des filtres de recherche pour ce champ', 'Search filter operator for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (379, 'polymod', NOW(), 'Un opérateur permet de modifier le fonctionnement d\'un filtre (tag <span class="keyword">atm-search-param</span>) dans une recherche. Il s\'ajoute au filtre en ajoutant le paramètre <span class="keyword">operator</span> suivit de la valeur souhaitée au tag <span class="keyword">atm-search-param</span> proposant un filtre sur ce champ. Les valeurs suivantes sont possibles :', 'An operator can modify the operation of a filter (tag <span class="keyword">atm-search-param</span>) in a search. It added to the filter by adding the <span class="keyword">operator</span> parameter followed by the desired value to tag <span class="keyword">atm-search-param</span> proposing a filter on that field. Following values are available:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (380, 'polymod', NOW(), '<br/><span class="keyword">&gt;=</span> : supérieur ou égal<br/><span class="keyword">&lt;=</span> : inférieur ou égal<br/><span class="keyword">&lt;</span> : inférieur<br/><span class="keyword">&gt;</span> : supérieur<br/><span class="keyword">&gt;= or null</span> : supérieur ou égal ou nul<br/><span class="keyword">&lt;= or null</span> : inférieur ou égal ou nul<br/><span class="keyword">&lt; or null</span> : inférieur ou nul<br/><span class="keyword">&gt; or null</span> : supérieur ou nul<br/><span class="keyword">&gt;= and not null</span> : (supérieur ou égal) et non nul<br/><span class="keyword">&lt;= and not null</span> : (inférieur ou égal) et non nul<br/><span class="keyword">&lt; and not null</span> : inférieur et non nul<br/><span class="keyword">&gt; and not null</span> : supérieur et non nul', '<br/><span class="keyword">&gt;=</span> : greater or equal<br/><span class="keyword">&lt;=</span> : lower or equal<br/><span class="keyword">&lt;</span> : lower<br/><span class="keyword">&gt;</span> : greater<br/><span class="keyword">&gt;= or null</span> : greater or equal or null<br/><span class="keyword">&lt;= or null</span> : lower or equal or null<br/><span class="keyword">&lt; or null</span> : lower or null<br/><span class="keyword">&gt; or null</span> : greater or null<br/><span class="keyword">&gt;= and not null</span> : (greater or equal) and not null<br/><span class="keyword">&lt;= and not null</span> : (lower or equal) and not null<br/><span class="keyword">&lt; and not null</span> : lower and not null<br/><span class="keyword">&gt; and not null</span> : greater and not null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (381, 'polymod', NOW(), 'Ne recherche que les objets associés à la catégorie en paramètre (les sous-catégories ne sont plus prises en compte)', 'Search only objects associated to the category in parameter (sub-categories are not used)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (382, 'polymod', NOW(), 'Tags de formulaires (création - modification)', 'Forms tags (create - edit)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (383, 'polymod', NOW(), '<div class="rowComment">
<h1>Cr&eacute;ation modification d\'objets cot&eacute; client :</h1>
<p><span class="code">&lt;atm-form what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">formName</span>&quot;&gt; ... &lt;/atm-form&gt;</span><br />
Ce tag permet de cr&eacute;er un formulaire de saisie pour un nouvel objet (si ce tag n\'est pas dans un r&eacute;sultat de recherche) ou de modification pour un objet existsnat (si ce tag se trouve dans un r&eacute;sultat de recherche.</p>
<ul>
	<li><span class="keyword">objet</span> : Type d\'objet &agrave; saisir (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>
	<li><span class="keyword">formName</span> : Nom du formulaire : identifiant unique pour le formulaire dans la rang&eacute;e.</li>
</ul>
Les valeurs suivantes seront remplac&eacute;es dans le tag :
<ul>
	<li><span class="vertclair">{filled}</span> : Vrai si le formulaire a &eacute;t&eacute; correctement rempli et que sa validation n\'a provoqu&eacute; aucune erreur.</li>
	<li><span class="vertclair">{required}</span> : Vrai si le formulaire n\'a pas &eacute;t&eacute; correctement rempli et que des champs requis ont &eacute;t&eacute; laiss&eacute;s vides.</li>
	<li><span class="vertclair">{malformed}</span> : Vrai si le formulaire n\'a pas &eacute;t&eacute; correctement rempli et que les values de certains champs sont incorrectes.</li>
</ul>
<h2>Ce tag peut contenir les sous-tags suivants :</h2>
<div class="retrait">
<h3>Affichage des champs requis :</h3>
<div class="retrait"><span class="code">&lt;atm-form-required form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{requiredname}</span> ...<br />
&lt;/atm-form-required&gt;</span><br />
Le contenu du tag sera lu pour chaque champ requis lors de la saisie du formulaire.<br />
<ul>
	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
</ul>
<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>
<ul>
	<li><span class="vertclair">{firstrequired}</span> : Vrai si le champ requis en cours est le premier du formulaire en cours.</li>
	<li><span class="vertclair">{last</span><span class="vertclair">required</span><span class="vertclair">}</span> : Vrai si le champ requis en cours est le dernier du formulaire en cours.</li>
	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">count}</span> : Num&eacute;ro du champ requis dans le formulaire en cours.</li>
	<li><span class="vertclair">{max</span><span class="vertclair">required</span><span class="vertclair">}</span> : Nombre de champs requis dans le formulaire en cours.</li>
	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">name}</span> : Nom du champ requis dans le formulaire en cours.</li>
	<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">field}</span> : Objet champ requis dans le formulaire en cours.</li>
</ul>
</div>
<h3>Affichage des champs malform&eacute;s :</h3>
<div class="retrait"><span class="code">&lt;atm-form-malformed form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{malformedname}</span> ...<br />
&lt;/atm-form-malformed&gt;</span><br />
Le contenu du tag sera lu pour chaque champ malform&eacute; lors de la saisie du formulaire.<br />
<ul>
	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
</ul>
<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>
<ul>
	<li><span class="vertclair">{firstmalformed}</span> : Vrai si le champ malform&eacute; en cours est le premier du formulaire en cours.</li>
	<li><span class="vertclair">{lastmalformed}</span> : Vrai si le champ malform&eacute; en cours est le dernier du formulaire en cours.</li>
	<li><span class="vertclair">{malformedcount}</span> : Num&eacute;ro du champ malform&eacute; dans le formulaire en cours.</li>
	<li><span class="vertclair">{maxmalformed}</span> : Nombre de champs malform&eacute;s dans le formulaire en cours.</li>
	<li><span class="vertclair">{malformedname}</span> : Nom du champ malform&eacute; dans le formulaire en cours.</li>
	<li><span class="vertclair">{malformedfield}</span> : Objet champ malform&eacute; dans le formulaire en cours.</li>
</ul>
</div>
<h3>Affichage d\'un champ de saisie :</h3>
<div class="retrait"><span class="code">&lt;atm-input field=&quot;<span class="keyword">{objet:champ}</span>&quot; form=&quot;<span class="keyword">formName</span>&quot; /&gt;</span><br />
Ce tag sera remplac&eacute; par la zone de saisie (champ de formulaire) n&eacute;cessaire &agrave; la saisie correcte des informations relatives au type du champ sp&eacute;cifi&eacute;.<br />
<ul>
	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
	<li><span class="keyword">{objet:champ}</span> : Champ de l\'objet g&eacute;r&eacute; par le formulaire sur lequel la saisie doit &ecirc;tre effectu&eacute;e.</li>
</ul>
<p>Ce tag peut ensuite avoir tout une suite d\'attributs html qui seront repost&eacute;s sur le code HTML du champ g&eacute;n&eacute;r&eacute; (<span class="vertclair">width, height, id, class, etc.</span>).</p>
</div>
</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (384, 'polymod', NOW(), 'Booléen', 'Boolean');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (385, 'polymod', NOW(), 'Permet spécifier un état (oui - non)', 'Choose a state (yes - no)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (386, 'polymod', NOW(), 'Libellé de la catégorie', 'Category label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (387, 'polymod', NOW(), 'Identifiant des utilisateur/groupe du champ', 'User/group IDs of the field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (388, 'polymod', NOW(), 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés ci-dessous recevront les notifications.<br/>"non" : les utilisateurs/groupes sélectionnés ci-dessous sont exclus de la reception des notifications.', 'If this parameter is :<br/>"yes" : only selected users/groups below will receive notifications.<br/>"no" : selected users/groups below are excluded of the notifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (389, 'polymod', NOW(), 'Permet de faire une recherche sur une valeur incomplète. Utilisez le caractère % pour spécifier la partie inconnue. Par exemple, "cha%" retournera "chat", "chameau", etc.', 'Allow the research on incomplete value. Use the caracter % for the unkown part. For example, "ca%" will return "cat", "car", etc.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (390, 'polymod', NOW(), 'Les valeurs suivantes sont possibles','Following values are available');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (391, 'polymod', NOW(), 'Opérateurs des champs de saisie pour ce champ', 'Input field operators for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (392, 'polymod', NOW(), 'Un opérateur permet de modifier l\'affichage d\'un champ (<span class="keyword">atm-input</span>) dans un formulaire (<span class="keyword">atm-form</span>). Il s\'ajoute au tag <span class="keyword">atm-input</span> en ajoutant le paramètre <span class="keyword">operator</span> suivi de la valeur souhaitée. Les valeurs suivantes sont possibles :','An operator can modify the display of a field (tag <span class="keyword">atm-input</span>) in a form (tag <span class="keyword">atm-form</span>). It added to the tag <span class="keyword">atm-input</span> by adding the <span class="keyword">operator</span> parameter followed by the desired value. Following values are available:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (393, 'polymod', NOW(), 'Affiche uniquement les sous catégories de la racine spécifiée','Display only sub categories of the specified root category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (394, 'polymod', NOW(), 'Comparaison numérique de deux champs numériques flottant.', 'Numeric comparison between two float fields.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (395, 'polymod', NOW(), 'La valeur du champ peut-être un nombre négatif', 'Field value can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (396, 'polymod', NOW(), 'Nombre flottant (à virgule)', 'Float number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (397, 'polymod', NOW(), 'Chaîne contenant un nombre à virgule (255 caractères maximum).', 'String containing a float number (255 characters maximum).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (398, 'polymod', NOW(), 'Ensemble des IDs des objets de type \'%s\' associés à ce  champ.', 'All IDs of objects of type \'%s\' associated to this field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (399, 'polymod', NOW(), 'Largeur des boîtes de sélection (pixels)', 'Select boxes width (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (400, 'polymod', NOW(), 'Hauteur des boîtes de sélection (pixels)', 'Select boxes height (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (401, 'polymod', NOW(), 'Uniquement dans le cas de catégories multiples. 300x200 par défaut.', 'Only if multi-categories. Default 300x200.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (402, 'polymod', NOW(), 'Description du champ : \'%s\'', 'Field description: \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (403, 'polymod', NOW(), 'Ordre de création', 'Creation order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (404, 'polymod', NOW(), 'Début de publication', 'Publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (405, 'polymod', NOW(), 'Trier par', 'Sort by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (406, 'polymod', NOW(), 'Page', 'Page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (407, 'polymod', NOW(), 'Permet de choisir une page Automne', 'Permit to choose an Automne page');

INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (409, 'polymod', NOW(), 'Largeur de la vignette dans les résultats de la recherche', 'Thumbnail width in search results list');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (410, 'polymod', NOW(), '(largeur de l\'image dans la liste des résultats, si elle est visible dans les résultats de la recherche) ', '(only if image is visible in search results)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (411, 'polymod', NOW(), 'Retourne vrai (true) si ce champ possède une valeur', 'Retrun true if this field has a value set');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (412, 'polymod', NOW(), '(Si la vignette dépasse cette hauteur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (413, 'polymod', NOW(), 'Hauteur maximum de l\'image en pixels', 'Image maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (414, 'polymod', NOW(), 'Hauteur maximum de la vignette en pixels', 'Thumbnail maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (415, 'polymod', NOW(), '(La vignettte sera redimensionnée à %s pixels de hauteur)', '(Thumbnail will be resized to %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (416, 'polymod', NOW(), '(La vignettte sera redimensionnée à %s pixels de largeur et %s  pixels de hauteur)', '(Thumbnail will be resized to %s pixels width and %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (417, 'polymod', NOW(), 'Unité', 'Unit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (418, 'polymod', NOW(), '(Sera affichée à côté de la valeur)', '(Will be display front of value)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (419, 'polymod', NOW(), 'Unité : "%s"', 'Unit : "%s"');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (420, 'polymod', NOW(), 'Affichage des résultats côté admin', 'Backoffice search results display');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (421, 'polymod', NOW(), 'Syntaxe pour l\'objet "%s"', 'Syntax for "%s" object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (422, 'polymod', NOW(), 'Recherchable', 'Searchable');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (423, 'polymod', NOW(), 'Hauteur maximum de la vignette en pixels', 'Maximum height of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (424, 'polymod', NOW(), 'Indexé', 'Indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (425, 'polymod', NOW(), 'Largeur de la fenêtre popup', 'Popup window width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (426, 'polymod', NOW(), 'Hauteur de la fenêtre popup', 'Popup window height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (427, 'polymod', NOW(), 'message(s) envoyé(s)', 'message(s) sent');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (428, 'polymod', NOW(), 'Ne recherche que les objets associés à la(aux) catégorie(s) éditable(s) fournie(s) en paramètre', 'Search only objects associated to the category(ies) in parameter');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (429, 'polymod', NOW(), 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre', 'Search only objects which are not associated to the category in parameter');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (430, 'polymod', NOW(), 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre, de façon stricte (les sous-catégories ne sont plus prises en compte)', 'Search only objects which are not associated to the category in parameter, by strict search (sub-categories are not used)');

#V4 labels starts to id 500
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (500, 'polymod', NOW(), 'Les catégories sont employées pour le(s) champ(s) : ', 'Catégories are used for fields: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (501, 'polymod', NOW(), 'Résultats : {0} %s sur {1}', 'Results : {0} %s of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (502, 'polymod', NOW(), 'Résultats : Aucun résultat pour votre recherche ...', 'Results: No result for your search...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (503, 'polymod', NOW(), 'Résultats', 'Results');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (504, 'polymod', NOW(), '{0} %s sur {1}', '{0} %s of {1}');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (505, 'polymod', NOW(), 'Supprime le ou les éléments %s sélectionnés. ', 'Remove the or these selected %s elements. ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (506, 'polymod', NOW(), 'Cette action est soumise à une validation ultérieure.', 'This action is subject to later validation.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (507, 'polymod', NOW(), 'Cette action n\'est pas soumise à une validation et est effective directement.', 'This action is not subject to later validation and take effect immediatly.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (508, 'polymod', NOW(), 'Annule la demande de suppression du ou des éléments %s sélectionnés.', 'Cancel the deletion of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (509, 'polymod', NOW(), 'Dévérouille le ou les éléments %s sélectionnés. Attention, si une personne est actuellement en train de modifier cet élément, il pourrait perdre ses modifications.', 'Unlock the or these %s selected elements. Attention, if somebody is currently editing the element, he may lose it\'s modifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (510, 'polymod', NOW(), 'Aperçu avant validation du ou des éléments %s sélectionnés.', 'Preview of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (511, 'polymod', NOW(), 'Modification du ou des éléments %s sélectionnés.', 'Modification of the or these %s selected elements.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (512, 'polymod', NOW(), 'Création d\'un nouvel élément %s.', 'Create a new %s element.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (513, 'polymod', NOW(), 'Recevez un email pour toute validation en attente dans ce module.', 'Receive an email for validation pending in this module.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (514, 'polymod', NOW(), 'Validations', 'Validations');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (515, 'polymod', NOW(), 'Heures', 'Hours');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (516, 'polymod', NOW(), 'Modifié l\'élément associé sélectionné', 'Modify selected associated element');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (517, 'polymod', NOW(), 'Enlever l\'élément associé sélectionné', 'Remove selected associated element');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (518, 'polymod', NOW(), 'Choisissez les éléments \'%s\' à associer', 'Choose elements \'%s\' to associate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (519, 'polymod', NOW(), 'Choisissez l\'aide à afficher : ', 'Choose help to display: ');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (520, 'polymod', NOW(), 'Ordre aléatoire', 'Random order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (521, 'polymod', NOW(), 'Sur cette page, vous pouvez spécifier des paramètres pour l\'affichage de la rangée de contenu en cours d\'édition.', 'On this page you can specify settings for the display of the row of content being edited.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (522, 'polymod', NOW(), 'Le formulaire est incomplet ou possède des valeurs incorrectes ...', 'The form is incomplete or has incorrect values...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (523, 'polymod', NOW(), 'Cet onglet est désactivé car vous devez avoir sélectionné du texte pour l\'utiliser.', 'This tab is disabled because you have selected the text to use it.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (524, 'polymod', NOW(), 'Cet onglet est désactivé car vous ne devez pas avoir de texte sélectionné pour l\'utiliser.', 'This tab is disabled because you do not have text selected for use.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (525, 'polymod', NOW(), 'L\'élément \'%s\' que vous cherchez à éditer est vérouillé par %s le %s.', 'The \'%s\' item you want to edit is locked by %s on %s.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (526, 'polymod', NOW(), 'Vous n\'avez pas le droit d\'éditer l\'élément \'%s\'.', 'You do not have the right to edit the item \'%s\'.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (527, 'polymod', NOW(), 'Sur cette page, vous pouvez créer ou modifier les données de l\'élément %s', 'On this page, you can create or modify the data of element %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (528, 'polymod', NOW(), 'Erreur durant l\'enregistrement de l\'élément ...', 'Error during recording of the element ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (529, 'polymod', NOW(), 'Aucune catégorie disponible ...', 'No category available ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (530, 'polymod', NOW(), 'Aucun élément disponible ...', 'No element available ...');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (531, 'polymod', NOW(), 'Elément inexistant ...', 'Element non-existent ...');