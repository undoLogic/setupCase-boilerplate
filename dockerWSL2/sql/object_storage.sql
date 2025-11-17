CREATE DATABASE if not exists object_storage;
USE object_storage;
SET GLOBAL sql_mode = '';

CREATE TABLE `files` (
                         `id` int(11) NOT NULL,
                         `current` tinyint(1) NOT NULL,
                         `domain` varchar(200) NOT NULL,
                         `key_name` varchar(200) NOT NULL,
                         `filename` varchar(200) NOT NULL,
                         `mime` varchar(50) NOT NULL,
                         `data` longblob NOT NULL,
                         `verify` varchar(200) NOT NULL,
                         `created` datetime NOT NULL,
                         `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `files` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);
ALTER TABLE `files` ADD INDEX(`current`, `key_name`);
ALTER TABLE `files` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
