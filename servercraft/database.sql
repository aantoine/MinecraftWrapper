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














INSERT INTO `jars` (jar_name, file)
VALUES('Minecraft 1.8.4', 'minecraft_server.1.8.4.jar');

INSERT INTO `jars` (jar_name, file)
VALUES('Minecraft X', 'Minecraft.jar');

INSERT INTO `servers` (server_name, server_jar, server_xmx, server_xms, server_world)
VALUES('server1', 1, 2048, 1024, 'vanilla');

INSERT INTO `servers` (server_name, server_jar, server_xmx, server_xms, server_world)
VALUES('testing', 1, 2048, 1024, 'world');

SELECT jar_name AS jar, server_xms AS xms, server_xmx AS xmx,
server_world AS world FROM servers WHERE server_name = 'server1';

SELECT jars.jar_name AS jar, servers.server_xms AS xms, servers.server_xmx AS xmx,
servers.server_world AS world
FROM servers
INNER JOIN jars
ON jars.jar_id=servers.server_jar
WHERE server_name = 'server1';
