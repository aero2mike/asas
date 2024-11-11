ALTER TABLE `login`
ADD `master_acc_id` INT NOT NULL;

CREATE TABLE IF NOT EXISTS `vote_points` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `master_acc_id` int NOT NULL,
  `rank_id` int NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mac_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `x_master_accounts_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT '2022-09-20 04:36:29',
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `x_mp_donations_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `preference_id` varchar(100) NOT NULL,
  `master_id` int NOT NULL DEFAULT '0',
  `client_id` int NOT NULL DEFAULT '0',
  `items` longtext NOT NULL,
  `credits` int NOT NULL DEFAULT '0',
  `payment_status` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `mc_gross` float NOT NULL DEFAULT '0',
  `mc_fee` float NOT NULL DEFAULT '0',
  `mc_currency` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `x_paypal_donations_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int unsigned DEFAULT '0',
  `server_name` varchar(255) DEFAULT NULL,
  `credits` int DEFAULT '0',
  `bonus` int DEFAULT '0',
  `items` mediumtext,
  `payment_status` varchar(20) DEFAULT NULL,
  `pending_reason` varchar(20) DEFAULT NULL,
  `payment_date` varchar(40) DEFAULT NULL,
  `mc_gross` varchar(20) DEFAULT NULL,
  `mc_fee` varchar(20) DEFAULT NULL,
  `mc_currency` varchar(3) DEFAULT NULL,
  `txn_id` varchar(20) DEFAULT NULL,
  `txn_type` varchar(20) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `payer_email` varchar(60) DEFAULT NULL,
  `payer_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `txn_id` (`txn_id`),
  KEY `account_id` (`master_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='All PayPal transactions that go through the IPN handler.';

CREATE TABLE IF NOT EXISTS `x_transfer_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int unsigned NOT NULL,
  `transfer_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `account` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `char` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `amount` int unsigned NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `x_vote4points_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int DEFAULT NULL,
  `rank_id` int unsigned DEFAULT '0',
  `points` int unsigned DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `x_wiki_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `x_wiki_posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` longtext COLLATE utf8mb4_unicode_ci,
  `archive` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_x_wiki_posts_x_wiki_categories` (`category_id`),
  CONSTRAINT `FK_x_wiki_posts_x_wiki_categories` FOREIGN KEY (`category_id`) REFERENCES `x_wiki_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` text COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ES',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_general_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_general_ci,
  `donation_points` int NOT NULL DEFAULT '0',
  `vote_points` int NOT NULL DEFAULT '0',
  `role` enum('User','Admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'User',
  `status` int NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;