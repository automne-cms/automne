# $Id: PermanentCookie-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of structure tables and sample datas were added in 
# automne3.sql files since version : 1.6
# automne3-data.sql files since version : 1.6
# automne3-scratch.sql files since version : 1.4

# [BUG][REFACTOR] Updating rows in clientspaces could have bad consequences
# in public pages content when regenerated. Solved. All clientspaces
# are stored in all locations (edited, deleted, archived, public, etc)

ALTER TABLE `sessions` ADD `remote_addr_ses` VARCHAR(32) NOT NULL ;
ALTER TABLE `sessions` ADD `http_user_agent_ses` VARCHAR(255) NOT NULL ;
ALTER TABLE `sessions` ADD `cookie_expire_ses` DATETIME NOT NULL ;