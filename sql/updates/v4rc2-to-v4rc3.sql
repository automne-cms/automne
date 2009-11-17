ALTER TABLE `sessions` DROP INDEX `id_ses`;
ALTER TABLE `sessions` ADD INDEX ( `phpid_ses` );
ALTER TABLE `sessions` ADD INDEX ( `user_ses` );
ALTER TABLE `sessions` ADD INDEX ( `cookie_expire_ses` );