-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2026 at 03:25 AM
-- Server version: 8.4.7
-- PHP Version: 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photobox`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 'User Login', 'Logged into the system', '127.0.0.1', '2026-08-05 15:32:49', '2026-08-05 15:32:49'),
(2, 2, 'User Login', 'Logged into the system', '127.0.0.1', '2026-08-05 15:32:50', '2026-08-05 15:32:50'),
(3, 2, 'Template Updated', 'Updated overlay design: Frame Design 2', '127.0.0.1', '2026-08-05 16:19:35', '2026-08-05 16:19:35'),
(4, 2, 'POST dashboard/templates/2', 'Request payload: {\"name\":\"Frame Design 2\",\"layout_type\":\"strip\",\"description\":\"Cool aesthetic border\"}', '127.0.0.1', '2026-08-05 16:19:35', '2026-08-05 16:19:35'),
(5, 2, 'Template Updated', 'Updated overlay design: Frame Design 2', '127.0.0.1', '2026-08-05 16:19:35', '2026-08-05 16:19:35'),
(6, 2, 'POST dashboard/templates/2', 'Request payload: {\"name\":\"Frame Design 2\",\"layout_type\":\"strip\",\"description\":\"Cool aesthetic border\"}', '127.0.0.1', '2026-08-05 16:19:35', '2026-08-05 16:19:35'),
(7, 2, 'Template Updated', 'Updated overlay design: Frame Design 3', '127.0.0.1', '2026-08-05 16:19:42', '2026-08-05 16:19:42'),
(8, 2, 'POST dashboard/templates/3', 'Request payload: {\"name\":\"Frame Design 3\",\"layout_type\":\"strip\",\"description\":\"Retro memory vibe\"}', '127.0.0.1', '2026-08-05 16:19:42', '2026-08-05 16:19:42'),
(9, 2, 'User Login', 'Logged into the system', '127.0.0.1', '2026-08-05 20:20:37', '2026-08-05 20:20:37'),
(10, 2, 'POST login', 'Request payload: {\"email\":\"superadmin@photobox.com\"}', '127.0.0.1', '2026-08-05 20:20:37', '2026-08-05 20:20:37'),
(11, 2, 'Template Created', 'Uploaded new overlay design: Green for category ID: 3', '127.0.0.1', '2026-08-05 20:23:35', '2026-08-05 20:23:35'),
(12, 2, 'POST dashboard/templates', 'Request payload: {\"name\":\"Green\",\"category_id\":\"3\",\"description\":null,\"image_file\":{}}', '127.0.0.1', '2026-08-05 20:23:35', '2026-08-05 20:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `slug`, `name`, `created_at`, `updated_at`) VALUES
(1, 'strip', 'Vertical Strip (4 Slots)', '2026-08-05 16:22:41', '2026-08-05 16:22:41'),
(2, 'strip_3', '3-Photo Strip (3 Slots)', '2026-08-05 16:22:41', '2026-08-05 16:22:41'),
(3, 'grid', '2x2 Grid (4 Slots)', '2026-08-05 16:22:41', '2026-08-05 16:22:41'),
(4, 'grid_6', '3x2 Grid (6 Slots)', '2026-08-05 16:22:41', '2026-08-05 16:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `creations`
--

DROP TABLE IF EXISTS `creations`;
CREATE TABLE IF NOT EXISTS `creations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `frame_id` bigint UNSIGNED DEFAULT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creations_user_id_foreign` (`user_id`),
  KEY `creations_frame_id_foreign` (`frame_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frames`
--

DROP TABLE IF EXISTS `frames`;
CREATE TABLE IF NOT EXISTS `frames` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'strip',
  `bg_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `overlay_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slots` json DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frames_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frames`
--

INSERT INTO `frames` (`id`, `user_id`, `name`, `layout_type`, `bg_color`, `overlay_image`, `slots`, `is_public`, `created_at`, `updated_at`, `deleted_at`) VALUES
(31, NULL, 'Vertical Strip (4 Slots)', 'strip', '#ffe5ec', NULL, '[{\"x\": 40, \"y\": 50, \"width\": 320, \"height\": 240}, {\"x\": 40, \"y\": 330, \"width\": 320, \"height\": 240}, {\"x\": 40, \"y\": 610, \"width\": 320, \"height\": 240}, {\"x\": 40, \"y\": 890, \"width\": 320, \"height\": 240}]', 1, '2026-08-05 07:41:50', '2026-08-05 07:41:50', NULL),
(32, NULL, '2x2 Grid (4 Slots)', 'grid', '#e0f2fe', NULL, '[{\"x\": 50, \"y\": 50, \"width\": 420, \"height\": 315}, {\"x\": 530, \"y\": 50, \"width\": 420, \"height\": 315}, {\"x\": 50, \"y\": 415, \"width\": 420, \"height\": 315}, {\"x\": 530, \"y\": 415, \"width\": 420, \"height\": 315}]', 1, '2026-08-05 07:41:50', '2026-08-05 07:41:50', NULL),
(33, NULL, '3x2 Grid (6 Slots)', 'grid', '#fef3c7', NULL, '[{\"x\": 50, \"y\": 50, \"width\": 420, \"height\": 315}, {\"x\": 530, \"y\": 50, \"width\": 420, \"height\": 315}, {\"x\": 50, \"y\": 425, \"width\": 420, \"height\": 315}, {\"x\": 530, \"y\": 425, \"width\": 420, \"height\": 315}, {\"x\": 50, \"y\": 800, \"width\": 420, \"height\": 315}, {\"x\": 530, \"y\": 800, \"width\": 420, \"height\": 315}]', 1, '2026-08-05 07:41:50', '2026-08-05 07:41:50', NULL),
(34, NULL, '3-Photo Strip (3 Slots)', 'strip', '#f3e8ff', NULL, '[{\"x\": 40, \"y\": 80, \"width\": 320, \"height\": 250}, {\"x\": 40, \"y\": 390, \"width\": 320, \"height\": 250}, {\"x\": 40, \"y\": 700, \"width\": 320, \"height\": 250}]', 1, '2026-08-05 07:41:50', '2026-08-05 07:41:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_01_140729_create_frames_table', 2),
(5, '2026_08_01_140738_create_creations_table', 2),
(6, '2026_08_05_135911_add_role_to_users_table', 3),
(7, '2026_08_05_143423_create_settings_table', 4),
(8, '2026_08_05_191314_create_activity_logs_table', 5),
(9, '2026_08_06_053500_add_soft_deletes_to_tables', 6),
(10, '2026_08_05_224340_create_role_permissions_table', 7),
(11, '2026_08_05_224848_create_overlays_table', 8),
(12, '2026_08_05_225212_add_layout_type_to_overlays_table', 9),
(13, '2026_08_05_232216_create_categories_table', 10),
(14, '2026_08_05_232229_add_category_id_to_overlays_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `overlays`
--

DROP TABLE IF EXISTS `overlays`;
CREATE TABLE IF NOT EXISTS `overlays` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `overlays_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overlays`
--

INSERT INTO `overlays` (`id`, `name`, `image_path`, `category_id`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Frame Design 1', 'images/overlays/overlay_1.png', 1, 'Cute themed overlay', NULL, '2026-08-05 15:48:54', '2026-08-05 15:48:54'),
(2, 'Frame Design 2', 'images/overlays/overlay_2.png', 1, 'Cool aesthetic border', NULL, '2026-08-05 15:48:54', '2026-08-05 16:19:35'),
(3, 'Frame Design 3', 'images/overlays/overlay_3.png', 1, 'Retro memory vibe', NULL, '2026-08-05 15:48:54', '2026-08-05 16:19:42'),
(4, 'Green', 'storage/overlays/48ae4b61-3593-4a4f-a182-76e373ca3673.png', 3, NULL, NULL, '2026-08-05 20:23:35', '2026-08-05 20:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `permission`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'manage_settings', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(2, 'superadmin', 'manage_users', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(3, 'superadmin', 'manage_templates', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(4, 'superadmin', 'backup_database', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(5, 'superadmin', 'view_logs', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(6, 'superadmin', 'use_studio', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(7, 'superadmin', 'view_trash', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(8, 'admin', 'manage_settings', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(9, 'admin', 'manage_users', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(10, 'admin', 'manage_templates', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(11, 'admin', 'backup_database', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(12, 'admin', 'view_logs', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(13, 'admin', 'use_studio', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(14, 'admin', 'view_trash', '2026-08-05 15:43:46', '2026-08-05 15:43:46'),
(15, 'user', 'use_studio', '2026-08-05 15:43:46', '2026-08-05 15:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('f4bonnsz3bMoykXa4IZJI6RYgrynUTUUwKxpnh7T', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ3OWJFTVNzY1JrejA4UEdGVnp6NzRDOU1Lb1p6NnpKc3Q5WnNSbzA3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9zdHVkaW8/YWN0aW9uPWN1c3RvbSIsInJvdXRlIjoid29ya3NwYWNlIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9', 1785975079),
('XXjmyq0d7ruTk9gEXnUxEsGbtOJpPY3h1APmu6WA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLa0NJTGdscUZMS0lxRXB1aTVTOUR1c01PdFhHeWZSblVsUHE4ZUNJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1785973871),
('qBCpwsyCYpWTFd0R7lVNh6hASCYTchgpVQ3oUZE6', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ4SnBmaTg5UFl5cFhaclJoRE9PdHkxOEI5RHJYdlVtQXI1ODBsUDFaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9zdHVkaW8/YWN0aW9uPWNhcHR1cmUmbGF5b3V0PWdyaWQmb3ZlcmxheV9pZD00Iiwicm91dGUiOiJ3b3Jrc3BhY2UifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1785986636);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'web_name', 'Photobox Studio', '2026-08-05 07:41:50', '2026-08-05 07:41:50'),
(2, 'web_logo', 'storage/settings/logo.png', '2026-08-05 07:41:50', '2026-08-05 09:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `deleted_at`) VALUES
(1, 'Photobox Admin', 'admin@photobox.com', NULL, '$2y$12$fN7K/IZd8.xDUhkOgnJfAuNy2FHmTSuUjEpHDymloEu1MPeCTSy/q', NULL, '2026-08-01 07:10:58', '2026-08-05 07:41:50', 'admin', NULL),
(2, 'Photobox Superadmin', 'superadmin@photobox.com', NULL, '$2y$12$5aOXcaZ4kBbqtncEYiEFeuaM/77MvfqinVpxEDiA9ImM8jRNw.CNi', NULL, '2026-08-05 07:04:20', '2026-08-05 07:41:49', 'superadmin', NULL),
(3, 'Photobox User', 'user@photobox.com', NULL, '$2y$12$ilEkBHZ2fllQQOwTkB5one/94zBvbcjrJPOrdaTAiqDwWytBdKNmW', NULL, '2026-08-05 07:04:21', '2026-08-05 07:41:50', 'user', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
