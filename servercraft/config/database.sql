CREATE TABLE IF NOT EXISTS `config` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`opt_id`),
  UNIQUE KEY `opt_name` (`opt_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='config data';

CREATE TABLE IF NOT EXISTS `jars` (
  `jar_id` int(11) NOT NULL AUTO_INCREMENT,
  `jar_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`jar_id`),
  UNIQUE KEY `file` (`file`),
  UNIQUE KEY `jar_name` (`jar_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='jars data';

CREATE TABLE IF NOT EXISTS `servers` (
  `server_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `server_jar` int(11) NOT NULL,
  `server_xmx` int(11) NOT NULL,
  `server_xms` int(11) NOT NULL,
  `server_world` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`server_id`),
  FOREIGN KEY (`server_jar`) REFERENCES jars(`jar_id`),
  UNIQUE KEY `server_name` (`server_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='server data';


CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';