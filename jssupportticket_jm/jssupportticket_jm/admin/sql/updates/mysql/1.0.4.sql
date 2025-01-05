UPDATE `#__js_ticket_config` SET `configvalue`='104' WHERE `configname`='version';

INSERT INTO `#__js_ticket_config` SET configfor='default', configname='ticketid_sequence', configvalue=1;

ALTER TABLE `#__js_ticket_tickets` ADD `attachmentdir` VARCHAR( 50 );
UPDATE `#__js_ticket_tickets` SET attachmentdir = CONCAT( 'ticket_', id );

