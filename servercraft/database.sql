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
  `server_jar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `server_xmx` int(11) NOT NULL,
  `server_xms` int(11) NOT NULL,
  `server_world` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`server_id`),
  UNIQUE KEY `server_name` (`server_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='server data';

INSERT INTO `servers` (server_name, server_jar, server_xmx, server_xms, server_world)
VALUES('server1', 'minecraft_server.1.8.4.jar', 2048, 1024, 'vanilla');

INSERT INTO `servers` (server_name, server_jar, server_xmx, server_xms, server_world)
VALUES('testing', 'minecraft_server.1.8.4.jar', 2048, 1024, 'world');