ALTER TABLE  `blocksRawDatas_deleted` ADD  `type` VARCHAR( 255 ) NOT NULL AFTER  `blockID` ;
ALTER TABLE  `blocksRawDatas_archived` ADD  `type` VARCHAR( 255 ) NOT NULL AFTER  `blockID` ;
ALTER TABLE  `blocksRawDatas_edition` ADD  `type` VARCHAR( 255 ) NOT NULL AFTER  `blockID` ;
ALTER TABLE  `blocksRawDatas_edited` ADD  `type` VARCHAR( 255 ) NOT NULL AFTER  `blockID` ;
ALTER TABLE  `blocksRawDatas_public` ADD  `type` VARCHAR( 255 ) NOT NULL AFTER  `blockID` ;

update blocksRawDatas_deleted set type='CMS_block_cms_forms' where value like '%"formID"%';
update blocksRawDatas_deleted set type='CMS_block_polymod' where type = '';
update blocksRawDatas_archived set type='CMS_block_cms_forms' where value like '%"formID"%';
update blocksRawDatas_archived set type='CMS_block_polymod' where type = '';
update blocksRawDatas_edition set type='CMS_block_cms_forms' where value like '%"formID"%';
update blocksRawDatas_edition set type='CMS_block_polymod' where type = '';
update blocksRawDatas_edited set type='CMS_block_cms_forms' where value like '%"formID"%';
update blocksRawDatas_edited set type='CMS_block_polymod' where type = '';
update blocksRawDatas_public set type='CMS_block_cms_forms' where value like '%"formID"%';
update blocksRawDatas_public set type='CMS_block_polymod' where type = '';
