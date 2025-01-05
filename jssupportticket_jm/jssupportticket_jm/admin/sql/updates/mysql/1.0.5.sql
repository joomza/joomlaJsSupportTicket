INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('ticket_progress_admin', '1', 'email'),('ticket_progress_staff', '1', 'email'),('ticket_progress_user', '1', 'email'),('print_ticket_user', '1', 'ticket');
ALTER TABLE `#__js_ticket_departments` ADD COLUMN `sendemail` tinyint(1) DEFAULT NULL;
ALTER TABLE `#__js_ticket_fieldsordering` 
ADD `isuserfield` TINYINT AFTER `required` ,
ADD `depandant_field` VARCHAR( 250 ) AFTER `isuserfield` ,
ADD `showonlisting` TINYINT AFTER `depandant_field` ,
ADD `search_user` TINYINT AFTER `showonlisting` ,
ADD `userfieldparams` LONGTEXT AFTER `search_user`,
ADD `userfieldtype` VARCHAR( 250 ) AFTER `isuserfield`,
ADD `size` VARCHAR( 200 ) AFTER `required`,
ADD `maxlength` VARCHAR( 200 ) AFTER `size`,
ADD `cols` VARCHAR( 200 ) AFTER `maxlength` ,
ADD `rows` VARCHAR( 200 ) AFTER `cols`,
ADD `isvisitorpublished` TINYINT AFTER `search_user`,
ADD `search_visitor` TINYINT AFTER `isvisitorpublished`,
ADD `cannotsearch` TINYINT AFTER `search_user`,
ADD `cannotshowonlisting` TINYINT NULL AFTER `showonlisting` ;

UPDATE `#__js_ticket_fieldsordering` SET isvisitorpublished = published;
UPDATE `#__js_ticket_fieldsordering` SET field = 'email' WHERE id = 1 AND field = 'emailaddress';

INSERT INTO `#__js_ticket_fieldsordering` (`field`, `fieldtitle`, `ordering`, `section`, `fieldfor`, `published`, `sys`, `cannotunpublish`, `required`, `isuserfield`, `depandant_field`, `showonlisting`, `search_user`, `userfieldparams`, `userfieldtype`, `size`, `maxlength`, `cols`, `rows`, `isvisitorpublished`, `search_visitor`, `cannotsearch`, `cannotshowonlisting`) VALUES ('phoneext', 'Phone Ext', 15, '10', 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, NULL, 1, 1);

ALTER TABLE `#__js_ticket_tickets` ADD `params` LONGTEXT NULL AFTER `attachmentdir`;

CREATE TABLE `#__js_ticket_userfields_bak` LIKE `#__js_ticket_userfields`;
INSERT `#__js_ticket_userfields_bak` SELECT * FROM `#__js_ticket_userfields`;

CREATE TABLE `#__js_ticket_userfield_data_bak` LIKE `#__js_ticket_userfield_data`;
INSERT `#__js_ticket_userfield_data_bak` SELECT * FROM `#__js_ticket_userfield_data`;

CREATE TABLE `#__js_ticket_userfieldvalues_bak` LIKE `#__js_ticket_userfieldvalues`;
INSERT `#__js_ticket_userfieldvalues_bak` SELECT * FROM `#__js_ticket_userfieldvalues`;

INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('last_step_updater','1150','default');
INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('last_version','','default');
UPDATE `#__js_ticket_config` t, (SELECT configvalue FROM `#__js_ticket_config` WHERE configname = 'version') t1 SET t.configvalue = t1.configvalue WHERE t.configname = 'last_version';


UPDATE `#__js_ticket_config` SET `configvalue`='105' WHERE `configname`='version';
