CREATE TABLE IF NOT EXISTS `config` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`opt_id`),
  UNIQUE KEY `opt_name` (`opt_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='config data';


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

CREATE TABLE IF NOT EXISTS `jars` (
  `jar_id` int(11) NOT NULL AUTO_INCREMENT,
  `jar_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`jar_id`),
  UNIQUE KEY `file` (`file`),
  UNIQUE KEY `jar_name` (`jar_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='jars data';

INSERT INTO `config` (opt_name, opt_value)
VALUES('mc_path', ruta al path!!!!);