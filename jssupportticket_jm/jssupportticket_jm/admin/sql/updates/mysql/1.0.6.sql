INSERT INTO `#__js_ticket_config` (configname, configvalue, configfor) VALUES ('cplink_staff_report_staff', 1, 'cplink'), ('cplink_department_report_staff', 1, 'cplink');

UPDATE `#__js_ticket_config` t, (SELECT configvalue FROM `#__js_ticket_config` WHERE configname = 'version') t1 SET t.configvalue = t1.configvalue WHERE t.configname = 'last_version';

UPDATE `#__js_ticket_config` SET `configvalue`='106' WHERE `configname`='version';
