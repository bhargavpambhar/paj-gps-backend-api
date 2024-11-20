-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 20, 2024 at 10:54 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pajgps_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
CREATE TABLE IF NOT EXISTS `access` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `access_level` enum('viewer','tracker','manager','admin','super_admin','support') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'viewer',
  `granted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_user_id_foreign` (`user_id`),
  KEY `access_device_id_foreign` (`device_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `user_id`, `device_id`, `access_level`, `granted_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'admin', '2024-11-20 22:12:35', '2025-02-10 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(2, 1, 2, 'super_admin', '2024-11-20 22:12:35', '2025-01-07 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(3, 2, 1, 'tracker', '2024-11-20 22:12:35', '2024-12-30 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(4, 2, 2, 'tracker', '2024-11-20 22:12:35', '2024-12-21 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(5, 3, 1, 'viewer', '2024-11-20 22:12:35', '2025-02-13 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(6, 3, 2, 'viewer', '2024-11-20 22:12:35', '2025-01-26 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(7, 4, 1, 'manager', '2024-11-20 22:12:35', '2025-01-17 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(8, 4, 2, 'manager', '2024-11-20 22:12:35', '2025-01-18 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(9, 5, 1, 'viewer', '2024-11-20 22:12:35', '2025-01-16 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(10, 5, 2, 'viewer', '2024-11-20 22:12:35', '2025-01-27 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(11, 6, 1, 'viewer', '2024-11-20 22:12:35', '2025-01-20 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35'),
(12, 6, 2, 'tracker', '2024-11-20 22:12:35', '2024-12-31 16:42:35', '2024-11-20 16:42:35', '2024-11-20 16:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `device_unique_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'active',
  `battery_percentage` decimal(5,2) NOT NULL DEFAULT '100.00',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `location_history` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_device_unique_id_unique` (`device_unique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `model`, `device_unique_id`, `type`, `status`, `battery_percentage`, `latitude`, `longitude`, `last_updated_at`, `location_history`, `created_at`, `updated_at`) VALUES
(1, 'GPS Tracker for Cars', 'Car Finder 4G', 'car-gps-001', 'Car', 'active', '100.00', '12.9716000', '77.5946000', NULL, '\"[{\\\"latitude\\\":12.9716,\\\"longitude\\\":77.5946},{\\\"latitude\\\":12.97,\\\"longitude\\\":77.6}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44'),
(2, 'GPS Tracker for Kids', 'Kid Tracker 4G', 'kid-gps-001', 'Kid', 'active', '95.00', '18.5204000', '73.8567000', NULL, '\"[{\\\"latitude\\\":18.5204,\\\"longitude\\\":73.8567},{\\\"latitude\\\":18.52,\\\"longitude\\\":73.85}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44'),
(3, 'GPS Tracker for Motorcycle', 'Motorbike Finder 4G 2.0', 'bike-gps-001', 'Bike', 'inactive', '88.00', '22.5726000', '88.3639000', NULL, '\"[{\\\"latitude\\\":22.5726,\\\"longitude\\\":88.3639},{\\\"latitude\\\":22.57,\\\"longitude\\\":88.36}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44'),
(4, 'GPS Tracker for Truck', 'Truck Finder 4G 1.0', 'truck-gps-001', 'Truck', 'active', '100.00', '28.6139000', '77.2090000', NULL, '\"[{\\\"latitude\\\":28.6139,\\\"longitude\\\":77.209},{\\\"latitude\\\":28.615,\\\"longitude\\\":77.21}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44'),
(5, 'GPS Tracker for Dogs', 'Dog Tracker Easy Finder', 'dog-gps-001', 'Dog', 'active', '95.00', '34.0522000', '-118.2437000', NULL, '\"[{\\\"latitude\\\":34.0522,\\\"longitude\\\":-118.2437},{\\\"latitude\\\":34.05,\\\"longitude\\\":-118.24}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44'),
(6, 'GPS Tracker for Other Areas', 'Finder for Other Areas 4G', 'other-area-gps-001', 'Other', 'inactive', '80.00', '40.7128000', '-74.0060000', NULL, '\"[{\\\"latitude\\\":40.7128,\\\"longitude\\\":-74.006},{\\\"latitude\\\":40.71,\\\"longitude\\\":-74.005}]\"', '2024-11-20 15:02:44', '2024-11-20 15:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb3_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(26, '0001_01_01_000000_create_users_table', 2),
(27, '0001_01_01_000001_create_cache_table', 2),
(28, '0001_01_01_000002_create_jobs_table', 2),
(29, '2024_11_20_180613_create_personal_access_tokens_table', 2),
(23, '2024_11_20_182114_add_columns_to_users_table', 1),
(30, '2024_11_20_182348_create_devices_table', 2),
(31, '2024_11_20_182356_create_access_table', 2),
(32, '2024_11_20_194936_create_refresh_tokens_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb3_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Login Token', 'b429c8bb1eb9564290548d0001243befde11b15574e2f36668847b2ac9c265b5', '[\"*\"]', '2024-11-20 17:09:08', NULL, '2024-11-20 15:46:13', '2024-11-20 17:09:08'),
(2, 'App\\Models\\User', 1, 'Login Token', 'ff7b5381f33e125ffffe11cb77327e07e8d5b6662c9f9471627569f15d749266', '[\"*\"]', NULL, NULL, '2024-11-20 17:08:59', '2024-11-20 17:08:59'),
(3, 'App\\Models\\User', 1, 'Login Token', '666ae0882f9c38e1606db31d095717eaf308c7734c9b9f809306e88a9b6b5363', '[\"*\"]', NULL, NULL, '2024-11-20 17:11:08', '2024-11-20 17:11:08'),
(4, 'App\\Models\\User', 1, 'Login Token', 'a4edc00781fff9a80384ba0560547d273282e3f1f309d31032ce5e14bc3a3d28', '[\"*\"]', NULL, NULL, '2024-11-20 17:14:15', '2024-11-20 17:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
CREATE TABLE IF NOT EXISTS `refresh_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refresh_tokens_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `refresh_tokens`
--

INSERT INTO `refresh_tokens` (`id`, `user_id`, `refresh_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'eed126cb40bf1f999f43c11a9b9f05d4d45ca9d82681a161efdb709843399805', '2024-11-20 15:46:13', '2024-11-20 15:46:13'),
(2, 1, 'e8252851dd93d177e9dc9fae4c648ce78d69072f823d4fe3074a7a58b3a9676c', '2024-11-20 17:08:59', '2024-11-20 17:08:59'),
(3, 1, 'afb4ab771374c943a80148dc924e9baf91d651313221be02923221bcd9f347ba', '2024-11-20 17:11:08', '2024-11-20 17:11:08'),
(4, 1, 'd1eca519c183392b71c017dd49f46d117b482b7cf1a4394c98c2eb3b8e20b2a4', '2024-11-20 17:14:15', '2024-11-20 17:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb3_unicode_ci,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_picture` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `is_active`, `profile_picture`, `last_login_at`, `preferences`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'john@example.com', NULL, '$2y$12$Vqo3PC.pIh9irOR8s1haT.0MjelyHbGCtGYlModjHRUAJ8ZLgerDO', NULL, 'admin', 1, NULL, NULL, NULL, '2024-11-20 14:56:20', '2024-11-20 14:56:20'),
(2, 'Jane', 'Doe', 'jane@example.com', NULL, '$2y$12$ALmb1hJvacxg16MT1o3Eg.LOD0CKydlJ3jqVGDtJlW0.6Vf6ek9z.', NULL, 'viewer', 1, NULL, NULL, NULL, '2024-11-20 14:56:21', '2024-11-20 14:56:21'),
(3, 'Alice', 'Smith', 'alice@example.com', NULL, '$2y$12$p7hf7WiK52Vugc12WrRYBuMe./ByP2PDrSOiJnoFIk88tqBI8iffe', NULL, 'tracker', 1, NULL, NULL, NULL, '2024-11-20 14:56:21', '2024-11-20 14:56:21'),
(4, 'Bob', 'Brown', 'bob@example.com', NULL, '$2y$12$b3CPPCQlpiUrKIEUAi6mqeXKR767dTx9R5bp.MMkgAv8AdOLfkQwG', NULL, 'manager', 1, NULL, NULL, NULL, '2024-11-20 14:56:21', '2024-11-20 14:56:21'),
(5, 'Charlie', 'Davis', 'charlie@example.com', NULL, '$2y$12$GGOT.2w9naLC24/U4oz3/OJ7ScrxsoMzlHllKOoU/LtLVwkAWHIMW', NULL, 'super_admin', 1, NULL, NULL, NULL, '2024-11-20 14:56:21', '2024-11-20 14:56:21'),
(6, 'NEWDEV', 'TEST', 'devtest@example.com', NULL, '$2y$12$7nwWFPNCq15j2qhz/8q1tetalsZ0X9uyRCpfCN/HbRZHT68AWJAFi', NULL, 'viewer', 1, NULL, NULL, NULL, '2024-11-20 16:11:36', '2024-11-20 16:11:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
