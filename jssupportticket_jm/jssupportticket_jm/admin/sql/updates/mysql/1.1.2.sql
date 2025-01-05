ALTER TABLE `#__js_ticket_priorities` ADD `overduetypeid` INT(11) DEFAULT NULL AFTER `priorityurgency`;
ALTER TABLE `#__js_ticket_priorities` ADD `overdueinterval` INT(11) DEFAULT NULL AFTER `overduetypeid`;

ALTER TABLE `#__js_ticket_tickets` ADD `ticketviaemail_id` INT(11) DEFAULT NULL AFTER `ticketviaemail`;

UPDATE `#__js_ticket_config` SET `configvalue`='112' WHERE `configname`='version';

UPDATE `#__js_ticket_priorities` set overduetypeid = (SELECT configvalue FROM `#__js_ticket_config` WHERE configname = 'ticket_overdue_type' );
UPDATE `#__js_ticket_priorities` set overdueinterval = (SELECT configvalue FROM `#__js_ticket_config` WHERE configname = 'ticket_overdue_indays' );