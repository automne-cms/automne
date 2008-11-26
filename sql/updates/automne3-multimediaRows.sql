# $Id: automne3-multimediaRows.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Alter mod_standard_rows table to add new rows references
#  automne3-data.sql file since version : 1.40

#Add Google Map, Audio and Video rows

INSERT INTO mod_standard_rows ( id_row , label_row , definitionFile_row , modulesStack_row , groupsStack_row ) VALUES ('', '900 Google Map', 'r61_900_Google_Maps.xml', 'standard', '');
INSERT INTO mod_standard_rows ( id_row , label_row , definitionFile_row , modulesStack_row , groupsStack_row ) VALUES ('', '901 Lecteur MP3', 'r62_901_Lecteur_MP3.xml', 'standard', '');
INSERT INTO mod_standard_rows ( id_row , label_row , definitionFile_row , modulesStack_row , groupsStack_row ) VALUES ('', '902 Lecteur vidéo', 'r63_902_Lecteur_video.xml', 'standard', '');