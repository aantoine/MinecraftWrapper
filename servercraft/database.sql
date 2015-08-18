CREATE TABLE IF NOT EXISTS `mcdatabase`.`config` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`opt_id`),
  UNIQUE KEY `opt_name` (`opt_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';


