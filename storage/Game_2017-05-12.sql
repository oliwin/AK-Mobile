# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: Game
# Generation Time: 2017-05-12 15:05:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table field_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `field_categories`;

CREATE TABLE `field_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `field_categories` WRITE;
/*!40000 ALTER TABLE `field_categories` DISABLE KEYS */;

INSERT INTO `field_categories` (`id`, `name`, `available`)
VALUES
	(1,'Transport',1),
	(2,'Fruits',1);

/*!40000 ALTER TABLE `field_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table field_relation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `field_relation`;

CREATE TABLE `field_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fields`;

CREATE TABLE `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `only_numbers` tinyint(1) NOT NULL DEFAULT '0',
  `available` int(10) unsigned NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `visibility` int(10) unsigned NOT NULL,
  `default` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `prototype_fields_prefix_unique` (`prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;

INSERT INTO `fields` (`id`, `name`, `prefix`, `only_numbers`, `available`, `updated_at`, `created_at`, `visibility`, `default`, `type`)
VALUES
	(99,'Speed','speed',1,1,'2017-05-12 15:01:10','2017-05-12 15:01:10',1,'100',2);

/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fields_prototype
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fields_prototype`;

CREATE TABLE `fields_prototype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned NOT NULL,
  `prototype_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fields_prototype_prototype_id_foreign` (`prototype_id`),
  KEY `fields_prototype_field_id_foreign` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fields_prototype` WRITE;
/*!40000 ALTER TABLE `fields_prototype` DISABLE KEYS */;

INSERT INTO `fields_prototype` (`id`, `field_id`, `prototype_id`)
VALUES
	(107,99,36);

/*!40000 ALTER TABLE `fields_prototype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2017_05_02_083649_create_objects_table',1),
	(4,'2017_05_02_083838_create_prototypes_table',1),
	(5,'2017_05_02_083906_create_fields_table',1),
	(6,'2017_05_03_104122_create_object_prototypes_table',2),
	(7,'2017_05_03_140000_create_prototype_field_table',3),
	(8,'2017_05_04_105456_create_field_categories_table',4);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table object_prototype_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `object_prototype_fields`;

CREATE TABLE `object_prototype_fields` (
  `prototype_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `object_prototype_fields` WRITE;
/*!40000 ALTER TABLE `object_prototype_fields` DISABLE KEYS */;

INSERT INTO `object_prototype_fields` (`prototype_id`, `object_id`, `field_id`, `value`)
VALUES
	(36,113,99,'150'),
	(36,114,99,'200');

/*!40000 ALTER TABLE `object_prototype_fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table objects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `objects`;

CREATE TABLE `objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` int(10) unsigned NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `visibility` int(11) NOT NULL DEFAULT '1',
  `category_id` int(11) DEFAULT NULL,
  `prototype_id` int(11) DEFAULT NULL,
  `prefix` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `objects` WRITE;
/*!40000 ALTER TABLE `objects` DISABLE KEYS */;

INSERT INTO `objects` (`id`, `name`, `available`, `updated_at`, `created_at`, `visibility`, `category_id`, `prototype_id`, `prefix`)
VALUES
	(113,'BMW',1,'2017-05-12 15:02:27','2017-05-12 15:02:27',1,1,36,'bmw'),
	(114,'BMW',0,'2017-05-12 15:04:47','2017-05-12 15:04:19',1,1,36,'bmw2');

/*!40000 ALTER TABLE `objects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table prototypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `prototypes`;

CREATE TABLE `prototypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` int(10) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `visibility` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prototypes_prefix_unique` (`prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `prototypes` WRITE;
/*!40000 ALTER TABLE `prototypes` DISABLE KEYS */;

INSERT INTO `prototypes` (`id`, `name`, `prefix`, `available`, `type`, `created_at`, `updated_at`, `visibility`)
VALUES
	(36,'Cars','cars',1,1,'2017-05-12 15:01:40','2017-05-12 15:01:40',1);

/*!40000 ALTER TABLE `prototypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Oleg','ponomarchukov@gmail.com','$2y$10$omX3vHgM4hGDsflIpysYGeu1wBJEQZQNwQg6xBCQKvOEvuCZ/cOZu','0OFF8qNqCaP9EwjEJ5rTpeNXkfm6MASVl2HsMoTbyAdcvxjMh2SElPIm0ZER','2017-05-02 12:09:28','2017-05-02 12:09:28');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
