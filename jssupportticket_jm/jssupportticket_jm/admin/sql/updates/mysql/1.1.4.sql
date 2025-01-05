
ALTER TABLE `#__js_ticket_email` ADD `smtphosttype` INT DEFAULT NULL AFTER `smtpactive`;
ALTER TABLE `#__js_ticket_email` ADD `smtpemailauth` TINYINT DEFAULT NULL AFTER `status`; 

UPDATE `#__js_ticket_config` SET `configvalue`='114' WHERE `configname`='version';
