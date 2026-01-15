
CREATE TABLE `email_queues` (`id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `message_html` TEXT NOT NULL , `message_text` TEXT NOT NULL , `email_to` VARCHAR(50) NOT NULL , `email_from` VARCHAR(50) NOT NULL , `letter` VARCHAR(50) NOT NULL , `lang` VARCHAR(25) NOT NULL , `sent` TINYINT(1) NOT NULL , `response` TEXT NOT NULL ,
