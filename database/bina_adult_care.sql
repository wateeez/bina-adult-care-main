-- Bina Adult Care Database Schema
-- Created: November 1, 2025
-- Compatible with: MySQL 5.7+

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `role` varchar(50) NOT NULL DEFAULT 'admin',
    `permissions` json DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_admin_user_id_foreign` (`user_id`),
    CONSTRAINT `user_admin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `services`
--

CREATE TABLE `services` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `image_path` varchar(255) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `message` text NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `page` varchar(255) NOT NULL,
    `key` varchar(255) NOT NULL,
    `value` longtext DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `contents_page_index` (`page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint(20) UNSIGNED DEFAULT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text DEFAULT NULL,
    `payload` longtext NOT NULL,
    `last_activity` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`),
    CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Initial seed data for services
--

INSERT INTO `services` (`title`, `description`, `created_at`) VALUES
('Personal Care', 'Assistance with daily activities like bathing, dressing, and grooming', NOW()),
('Medication Management', 'Ensuring medications are taken as prescribed and on schedule', NOW()),
('Meal Preparation', 'Nutritious meal planning and preparation according to dietary needs', NOW()),
('Companionship', 'Social interaction, conversation, and recreational activities', NOW()),
('Light Housekeeping', 'Maintaining a clean and safe living environment', NOW());

-- --------------------------------------------------------
--
-- Initial seed data for contents (sample homepage content)
--

INSERT INTO `contents` (`page`, `key`, `value`, `created_at`) VALUES
('home', 'hero_title', 'Welcome to Bina Adult Care', NOW()),
('home', 'hero_description', 'Providing compassionate and professional care services for adults', NOW()),
('about', 'mission', 'Our mission is to enhance the quality of life for adults needing care while maintaining their dignity and independence', NOW()),
('about', 'vision', 'To be the leading provider of adult care services, known for excellence, compassion, and dedication', NOW());

-- --------------------------------------------------------
--
-- Create default admin user
--

INSERT INTO `users` (`name`, `email`, `password`, `created_at`) VALUES
('Admin', 'admin@binaadultcare.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN.jf.r.RAP6E2L1hQK2i', NOW()); -- Password: admin123

INSERT INTO `user_admin` (`user_id`, `role`, `created_at`) VALUES
(1, 'admin', NOW());

COMMIT;