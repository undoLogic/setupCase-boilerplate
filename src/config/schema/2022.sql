CREATE TABLE IF NOT EXISTS `users` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(200) NOT NULL , `email` VARCHAR(100) NOT NULL , `password` VARCHAR(300) NOT NULL , `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS `user_types` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
INSERT INTO `user_types` (`id`, `name`) VALUES ('111', 'admin'), ('10', 'client'), ('20', 'staff');
ALTER TABLE `users` ADD `user_type_id` INT NOT NULL AFTER `id`;
UPDATE `users` SET `user_type_id` = '111' WHERE `users`.`id` = 1;
UPDATE `users` SET `user_type_id` = '111' WHERE `users`.`id` = 2;
