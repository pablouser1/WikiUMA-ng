-- wikiuma.reviews definition
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `target` varchar(36) NOT NULL,
  `username` varchar(16) DEFAULT NULL,
  `note` float NOT NULL,
  `message` text DEFAULT NULL,
  `votes` int(11) DEFAULT 0,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- wikiuma.tags definition
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(32) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `for` tinyint(1) NOT NULL,
  `icon` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_UN` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- wikiuma.users definition
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` binary(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- wikiuma.reports definition
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `uuid` uuid NOT NULL,
  `review_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `reason` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `reports_FK` (`review_id`),
  CONSTRAINT `reports_FK` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- wikiuma.reviews_tags definition
CREATE TABLE `reviews_tags` (
  `review_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  UNIQUE KEY `reviews_tags_UN` (`review_id`,`tag_id`),
  KEY `reviews_tags_FK_1` (`tag_id`),
  CONSTRAINT `reviews_tags_FK` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_tags_FK_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
