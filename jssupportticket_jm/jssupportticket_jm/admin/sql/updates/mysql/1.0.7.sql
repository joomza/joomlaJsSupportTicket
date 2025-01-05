INSERT INTO `#__js_ticket_emailtemplates` VALUES
	(26,'mail-rpy-closed','',	'JS Tickets: Ticket has been closed',	'<p>Your ticket {TICKET_SUBJECT} has been closed.</p>\n<p>You can not reply to a closed ticket</p>\n<p>	<span style=\"color: red;\">	<strong>*DO NOT REPLY TO THIS E-MAIL*</strong>	</span>	<br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n','2017-04-03 11:09:00',1),
	(27,'mail-feedback','','JS Tickets: Give Us Your Feedback','<p>Dear {USER_NAME}, Your ticket {TICKET_SUBJECT} having tracking id {TRACKING_ID} has been closed on {CLOSE_DATE}.\n We would really appreciate if you took the time to tell us how well our staff member helped you in your problem..</p>\n<p>	{LINK}link text{/LINK}	</p>\n<p>	\n	<span style=\"color: red;\">	<strong>*DO NOT REPLY TO THIS E-MAIL*</strong>	</span>	<br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n','2017-04-03 11:09:00',1);


INSERT INTO `#__js_ticket_config` VALUES
	('visitor_message','Thank You for contacting us. A support ticket request has been created, A representative will be getting back to you shortly.<br/>\r\nSupport Team','default'),
	('ticket_overdue_type','1','default'),
	('reply_to_closed_ticket','1','default'),
	('feedback_email_delay_type','1','default'),
	('feedback_email_delay','3','default'),
	('ticket_feedback_user','1','default'),
	('cplink_feedback_staff','1','default'),
	('feedback_thanks_message','Thank you for providing your feedback. We appreciate the time you have taken and will actively use it to improve our services to you','default');


INSERT INTO `#__js_ticket_fieldsordering` (`id`, `field`, `fieldtitle`, `ordering`, `section`, `fieldfor`, `published`, `sys`, `cannotunpublish`, `required`, `isuserfield`, `depandant_field`, `showonlisting`, `search_user`, `userfieldparams`, `userfieldtype`, `size`, `maxlength`, `cols`, `rows`, `isvisitorpublished`, `search_visitor`, `cannotsearch`, `cannotshowonlisting`) VALUES 
	(NULL, 'rating', 'Rating', '1', '0', '2', '1', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL),
	(NULL, 'remarks', 'Remarks', '2', '10', '2', '1', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0');

ALTER TABLE `#__js_ticket_tickets`  ADD `feedbackemail` TINYINT NOT NULL  AFTER `attachmentdir`;

UPDATE `#__js_ticket_config` SET `configvalue`='107' WHERE `configname`='version';
