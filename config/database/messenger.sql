SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                           `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           `pseudo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE `discussion` (
                         `id` int AUTO_INCREMENT NOT NULL,
                         `pseudo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                         `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `discussion_participants`;
CREATE TABLE `discussion_participants` (
    `discussion_id` int NOT NULL,
    `user_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`discussion_id`, `user_username`),
    FOREIGN KEY (discussion_id)
        REFERENCES discussion(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_username)
        REFERENCES users(username)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
                         `id` int AUTO_INCREMENT NOT NULL,
                         `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                         `sender_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                         `discussion_id`  int NOT NULL,
                             PRIMARY KEY (`id`),
                             FOREIGN KEY (sender_username)
                             REFERENCES users(username)
                             ON DELETE CASCADE,
                             FOREIGN KEY (discussion_id)
                             REFERENCES discussion(id)
                             ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;