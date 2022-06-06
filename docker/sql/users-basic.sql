CREATE TABLE `LIVE_database`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `user_type_id` INT NOT NULL , `name` VARCHAR(99) NOT NULL , `email` VARCHAR(99) NOT NULL , `password` VARCHAR(1000) NOT NULL , `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `user_types` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
INSERT INTO `user_types` (`id`, `name`) VALUES ('111', 'Admin'), ('30', 'Manager'), ('10', 'Staff');

UPDATE `users` SET `user_type_id` = '111' WHERE `users`.`id` = 1;
UPDATE `users` SET `user_type_id` = '111' WHERE `users`.`id` = 2;

ALTER TABLE `users` ADD `reset_token` VARCHAR(1000) NOT NULL AFTER `password`;