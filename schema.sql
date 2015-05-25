CREATE TABLE IF NOT EXISTS `keyvaluestore` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`),
  KEY `modified` (`modified`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Key/Value Store';
