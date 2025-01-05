ALTER TABLE `#__js_ticket_tickets` ADD `hash` varchar(200) COLLATE 'utf8_general_ci' NULL AFTER `params`;

INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('read_utf_ticket_via_email', '1', 'ticketviaemail');

UPDATE `#__js_ticket_config` SET `configvalue`='110' WHERE `configname`='version';
