SET SQL_MODE='ALLOW_INVALID_DATES';

ALTER TABLE `#__js_ticket_departments`  
	MODIFY COLUMN `departmentsignature` text DEFAULT NULL;

ALTER TABLE `#__js_ticket_emailtemplates`  
	MODIFY COLUMN `body` text DEFAULT NULL;

ALTER TABLE `#__js_ticket_fieldsordering`  
	MODIFY COLUMN `sys` tinyint(1) NOT NULL DEFAULT '0',
	MODIFY COLUMN `cannotunpublish` tinyint(1) NOT NULL DEFAULT '0',
	MODIFY COLUMN `isuserfield` TINYINT DEFAULT NULL,
	MODIFY COLUMN `depandant_field` VARCHAR( 250 ) DEFAULT NULL,
	MODIFY COLUMN `showonlisting` TINYINT DEFAULT NULL,
	MODIFY COLUMN `search_user` TINYINT DEFAULT NULL,
	MODIFY COLUMN `userfieldparams` LONGTEXT DEFAULT NULL,
	MODIFY COLUMN `userfieldtype` VARCHAR( 250 ) DEFAULT NULL,
	MODIFY COLUMN `size` VARCHAR( 200 ) DEFAULT NULL,
	MODIFY COLUMN `maxlength` VARCHAR( 200 ) DEFAULT NULL,
	MODIFY COLUMN `cols` VARCHAR( 200 ) DEFAULT NULL,
	MODIFY COLUMN `rows` VARCHAR( 200 ) DEFAULT NULL,
	MODIFY COLUMN `isvisitorpublished` TINYINT DEFAULT NULL,
	MODIFY COLUMN `search_visitor` TINYINT DEFAULT NULL,
	MODIFY COLUMN `cannotsearch` TINYINT DEFAULT NULL,
	MODIFY COLUMN `cannotshowonlisting` TINYINT DEFAULT NULL;

ALTER TABLE `#__js_ticket_replies`  
	MODIFY COLUMN `message` text DEFAULT NULL,
	MODIFY COLUMN `ticketviaemail` tinyint(1) NOT NULL DEFAULT '0';

ALTER TABLE `#__js_ticket_system_errors`  
	MODIFY COLUMN `error` text DEFAULT NULL;

ALTER TABLE `#__js_ticket_tickets`  
	MODIFY COLUMN `ticketid` varchar(25) DEFAULT NULL,
	MODIFY COLUMN `message` text DEFAULT NULL,
	MODIFY COLUMN `ticketviaemail` tinyint(1) NOT NULL DEFAULT '0',
	MODIFY COLUMN `feedbackemail` TINYINT DEFAULT NULL,
	MODIFY COLUMN `params` LONGTEXT  DEFAULT NULL,
	MODIFY COLUMN `hash` varchar(200) COLLATE 'utf8_general_ci'  DEFAULT NULL;

UPDATE `#__js_ticket_config` SET `configvalue`='125' WHERE `configname`='version';

