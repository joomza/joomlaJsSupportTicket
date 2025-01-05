UPDATE `#__js_ticket_config` SET `configvalue`='119' WHERE `configname`='version';
INSERT INTO `#__js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES 
('cplink_userdata_user', '1', 'cplink'),
('cplink_userdata_staff', '1', 'cplink'),
('erase_data_request_user', '1', 'email'),
('erase_data_request_admin', '1', 'email'),
('delete_user_data', '1', 'email');

CREATE TABLE IF NOT EXISTS `#__js_ticket_erasedatarequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__js_ticket_emailtemplates` (`id`, `templatefor`, `title`, `subject`, `body`, `created`, `status`) VALUES 
(NULL, 'delete-user-data', '', '{SITETITLE}: Delete User Data', '<p><span style="font-size: 12.16px;"><strong>{SITETITLE}: Data Delete request</strong></span></p><p>Your data delete request has been received.</p><p><span style="color: red;"> <strong>*DO NOT REPLY TO THIS E-MAIL*</strong> </span> <br /> This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>', '2017-04-03 11:09:00', '1'),
(NULL, 'delete-user-data-admin', '', '{;ITETITLE}: User erase data request', '<p><span style="font-size: 12.16px;"><strong>{SITETITLE}: User erase data request</strong></span></p> <p>{USERNAME} has been submitted a request for erasing data.</p> <p><span style="color: red;"> <strong>*DO NOT REPLY TO THIS E-MAIL*</strong> </span> <br /> This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>', '2017-04-03 11:09:00', '1'),
(NULL, 'user-data-deleted', '', '{SITETITLE}: Data deleted successfully', '<p>Your data has been deleted successfully</p> <p><span style="color: red;"> <strong>*DO NOT REPLY TO THIS E-MAIL*</strong> </span> <br /> This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>', '2017-04-03 11:09:00', '1');

