-- Jan 02, 2015
CREATE TABLE `phpfox_notification_live` (
  `notification_id` int(11) NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;