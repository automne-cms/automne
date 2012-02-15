ALTER TABLE  `websites` ADD  `codename_web` VARCHAR( 255 ) NOT NULL AFTER  `id_web` ;
update websites set codename_web='root' where id_web = '1';
update websites set codename_web=label_web where id_web != '1';
