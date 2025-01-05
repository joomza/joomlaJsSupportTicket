ALTER TABLE `#__js_ticket_departments` ADD COLUMN `isdefault` tinyint(1) not null default '0';
UPDATE `#__js_ticket_config` SET `configvalue`='102' WHERE `configname`='version';