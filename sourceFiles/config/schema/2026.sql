CREATE TABLE `email_queues` (
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `user_id` INT NOT NULL,
                                `message_html` TEXT NOT NULL,
                                `message_text` TEXT NOT NULL,
                                `email_to` VARCHAR(50) NOT NULL,
                                `email_from` VARCHAR(50) NOT NULL,
                                `letter` VARCHAR(50) NOT NULL,
                                `lang` VARCHAR(25) NOT NULL,
                                `sent` TINYINT(1) NOT NULL DEFAULT 0,
                                `response` TEXT NULL,
                                `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `modified` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                                PRIMARY KEY (`id`),
                                KEY `idx_user_id` (`user_id`),
                                KEY `idx_sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
