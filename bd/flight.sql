-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for flight
CREATE DATABASE IF NOT EXISTS `flight` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `flight`;

-- Dumping structure for table flight.ages
CREATE TABLE IF NOT EXISTS `ages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.ages: ~2 rows (approximately)
/*!40000 ALTER TABLE `ages` DISABLE KEYS */;
INSERT INTO `ages` (`id`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'ADULTO', '2023-11-18 12:51:44', '2023-11-18 12:51:44'),
	(2, 'MENORES', '2023-11-18 12:51:48', '2023-11-18 12:51:49'),
	(3, 'INFANTE', '2023-11-18 12:51:55', '2023-11-18 12:51:55');
/*!40000 ALTER TABLE `ages` ENABLE KEYS */;

-- Dumping structure for table flight.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.cities: ~2 rows (approximately)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'LA PAZ', '2023-11-18 12:50:57', '2023-11-18 12:50:58'),
	(2, 'SANTA CRUZ', '2023-11-18 12:51:12', '2023-11-18 12:51:13'),
	(3, 'COCHABAMBA', '2023-11-18 12:51:22', '2023-11-18 12:51:22');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Dumping structure for table flight.flights
CREATE TABLE IF NOT EXISTS `flights` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `origin_id` bigint(20) unsigned NOT NULL,
  `destiny_id` bigint(20) unsigned NOT NULL,
  `hour` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flights_origin_id_foreign` (`origin_id`),
  KEY `number` (`number`),
  KEY `flights_destiny_id_foreign` (`destiny_id`),
  CONSTRAINT `flights_destiny_id_foreign` FOREIGN KEY (`destiny_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `flights_origin_id_foreign` FOREIGN KEY (`origin_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.flights: ~1 rows (approximately)
/*!40000 ALTER TABLE `flights` DISABLE KEYS */;
INSERT INTO `flights` (`id`, `number`, `date`, `origin_id`, `destiny_id`, `hour`, `created_at`, `updated_at`) VALUES
	(1, '1', '2023-12-21', 2, 1, '21:17:00', '2023-12-21 22:16:13', '2023-12-21 22:16:13');
/*!40000 ALTER TABLE `flights` ENABLE KEYS */;

-- Dumping structure for table flight.passengers
CREATE TABLE IF NOT EXISTS `passengers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `names` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `names` (`names`),
  KEY `ci` (`ci`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.passengers: ~4 rows (approximately)
/*!40000 ALTER TABLE `passengers` DISABLE KEYS */;
INSERT INTO `passengers` (`id`, `names`, `ci`, `created_at`, `updated_at`) VALUES
	(1, 'Fernando Cruz Banegas', '8915347', '2023-11-19 17:59:43', '2023-11-19 17:59:44'),
	(2, 'Jose Saravia Mendoza', '7069355', '2023-11-19 18:00:09', '2023-11-19 18:00:10'),
	(3, 'Juan Cespedes Veisaga', '5689750', '2023-11-19 22:58:04', '2023-11-19 22:58:04'),
	(4, 'Roberto Mendoza Paz', '2013697', '2023-11-19 22:58:50', '2023-11-19 22:58:50'),
	(5, 'Manuel Cortez', '7456230', '2023-11-20 14:20:24', '2023-11-20 14:20:24');
/*!40000 ALTER TABLE `passengers` ENABLE KEYS */;

-- Dumping structure for table flight.places
CREATE TABLE IF NOT EXISTS `places` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `places_type_id_foreign` (`type_id`),
  CONSTRAINT `places_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.places: ~68 rows (approximately)
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` (`id`, `number`, `order`, `state`, `disabled`, `type_id`, `created_at`, `updated_at`) VALUES
	(2, '2A', 2, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(3, '3A', 3, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(4, '4A', 4, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(5, '5A', 5, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(6, '6A', 6, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(7, '7A', 7, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(8, '8A', 8, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(9, '9A', 9, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(10, '10A', 10, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(11, '11A', 11, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(12, '12A', 12, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(13, '13A', 13, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(14, '2B', 15, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(15, '3B', 16, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(16, '4B', 17, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(17, '5B', 18, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(18, '6B', 19, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(19, '7B', 20, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(20, '8B', 21, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(21, '9B', 22, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(22, '10B', 23, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(23, '11B', 24, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(24, '12B', 25, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(25, '13B', 26, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(26, '3C', 29, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(27, '4C', 30, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(28, '5C', 31, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(29, '6C', 32, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(30, '7C', 33, 0, 0, 1, '2023-11-17 17:49:27', '2023-11-17 17:49:27'),
	(31, '8C', 34, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(32, '9C', 35, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(33, '10C', 36, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(34, '11C', 37, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(35, '3D', 55, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(36, '4D', 56, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(37, '5D', 57, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(38, '6D', 58, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(39, '7D', 59, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(40, '8D', 60, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(41, '9D', 61, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(42, '10D', 62, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(43, '11D', 63, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(44, '1E', 66, 1, 1, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(45, '2E', 67, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(46, '3E', 68, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(47, '4E', 69, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(48, '5E', 70, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(49, '6E', 71, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(50, '7E', 72, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(51, '8E', 73, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(52, '9E', 74, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(53, '10E', 75, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(54, '11E', 76, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(55, '12E', 77, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(56, '13E', 78, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(57, '1F', 79, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(58, '2F', 80, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(59, '3F', 81, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(60, '4F', 82, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(61, '5F', 83, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(62, '6F', 84, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(63, '7F', 85, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(64, '8F', 86, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(65, '9F', 87, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(66, '10F', 88, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(67, '11F', 89, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(68, '12F', 90, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25'),
	(69, '13F', 91, 0, 0, 1, '2023-11-19 13:22:24', '2023-11-19 13:22:25');
/*!40000 ALTER TABLE `places` ENABLE KEYS */;

-- Dumping structure for table flight.services
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `door` int(10) unsigned NOT NULL,
  `seat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `place_id` bigint(20) unsigned NOT NULL,
  `age_id` bigint(20) unsigned NOT NULL,
  `passenger_id` bigint(20) unsigned NOT NULL,
  `flight_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_passenger_id_foreign` (`passenger_id`),
  KEY `services_age_id_foreign` (`age_id`),
  KEY `services_flight_id_foreign` (`flight_id`),
  KEY `services_place_id_foreign` (`place_id`),
  CONSTRAINT `services_age_id_foreign` FOREIGN KEY (`age_id`) REFERENCES `ages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `services_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `services_passenger_id_foreign` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `services_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.services: ~0 rows (approximately)
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `date`, `door`, `seat`, `weight`, `quantity`, `ticket`, `total`, `place_id`, `age_id`, `passenger_id`, `flight_id`, `created_at`, `updated_at`) VALUES
	(1, '2023-12-21', 1, '1E', 100, 1, '10', 100, 44, 1, 1, 1, '2023-12-21 22:16:46', '2023-12-21 22:16:46');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

-- Dumping structure for table flight.types
CREATE TABLE IF NOT EXISTS `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int(10) unsigned NOT NULL,
  `column` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.types: ~1 rows (approximately)
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` (`id`, `name`, `row`, `column`, `created_at`, `updated_at`) VALUES
	(1, 'MODELO 1', 7, 13, '2023-11-17 17:48:24', '2023-11-17 17:48:25');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;

-- Dumping structure for table flight.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users.city_id_foreign` (`city_id`),
  CONSTRAINT `users.city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table flight.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `type`, `city_id`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@gmail.com', NULL, '$2a$12$swjzMQOZzzHSbri.hH/Bhu7CmcoUsUWOC5y3qFZF2YpcqKU4EMuwK', NULL, 'admin', 1, '2023-11-16 15:34:40', '2023-11-16 15:34:40'),
	(2, 'mono', 'mono@outlook.com', NULL, '$2y$10$vhNVMz1fPB1dEdV5STN50uMWpNAuRGIOyGSvMHo6/Vt6vEFJSKjkC', NULL, 'user', 2, '2023-12-21 22:19:35', '2023-12-21 22:19:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
