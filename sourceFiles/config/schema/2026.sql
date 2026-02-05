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





CREATE TABLE `audit_logs` (
                              `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    -- What was changed
                              `table_name` VARCHAR(100) NOT NULL,
                              `entity_id` BIGINT UNSIGNED DEFAULT NULL,
                              `action` ENUM('insert','update','delete') NOT NULL,

    -- Change details
                              `changed_fields` JSON DEFAULT NULL,
                              `original_fields` JSON DEFAULT NULL,

    -- Who / where
                              `user_id` BIGINT UNSIGNED DEFAULT NULL,
                              `ip_address` VARCHAR(45) DEFAULT NULL, -- IPv4 / IPv6

    -- Metadata
                              `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                              PRIMARY KEY (`id`),

    -- Performance / querying
                              KEY `idx_table_entity` (`table_name`, `entity_id`),
                              KEY `idx_user_id` (`user_id`),
                              KEY `idx_action` (`action`),
                              KEY `idx_created` (`created`)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `email_queue_attachments` (`id` INT NOT NULL AUTO_INCREMENT , `email_queue_id` INT NOT NULL , `attachment` TEXT NOT NULL , `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;





ALTER TABLE `email_queues` ADD `sent_date` DATETIME NOT NULL AFTER `sent`;

ALTER TABLE `email_queues` ADD `message_subject` VARCHAR(255) NOT NULL AFTER `user_id`;

ALTER TABLE `email_queues` DROP `letter`;


