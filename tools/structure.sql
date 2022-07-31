-- wikiuma.reviews definition

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idnc` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT 'Anon',
  `note` float NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `votes` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
