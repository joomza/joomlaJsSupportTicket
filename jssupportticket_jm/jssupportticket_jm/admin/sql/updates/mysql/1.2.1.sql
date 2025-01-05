UPDATE `#__js_ticket_config` SET `configvalue`='121' WHERE `configname`='version';

INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('private_credentials_secretkey', 'privatecredentials', 'privatecredentials');
INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('tickets_sorting', '1', 'default');
INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('maximum_ticket_interval_time', '1', 'default');

