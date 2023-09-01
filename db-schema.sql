--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `department` bigint(20) unsigned NOT NULL,
  `account_status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_department_foreign` (`department`),
  KEY `users_created_by_foreign` (`created_by`),
  CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Table structure for table `departments`
--
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `created_by` bigint(20) unsigned NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `departments_name_unique` (`name`),
    KEY `departments_created_by_foreign` (`created_by`),
    CONSTRAINT `departments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `perm_permissions`
--
DROP TABLE IF EXISTS `perm_permissions`;
CREATE TABLE `perm_permissions` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `parent` varchar(255) NOT NULL,
    `child` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `guard_name` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `perm_permissions_name_guard_name_unique` (`name`, `guard_name`),
    KEY `perm_permissions_parent_index_key` (`parent`),
    KEY `perm_permissions_child_index_key` (`parent`)
) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `perm_roles`
--
DROP TABLE IF EXISTS `perm_roles`;
CREATE TABLE `perm_roles` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `guard_name` varchar(255) NOT NULL,
    `for_department` bigint(20) unsigned NOT NULL,
    `created_by` bigint(20) unsigned NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `perm_roles_name_guard_name_unique` (`name`, `guard_name`),
    KEY `perm_roles_for_department_foreign` (`for_department`),
    KEY `perm_roles_created_by_foreign` (`created_by`),
    CONSTRAINT `perm_roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
    CONSTRAINT `perm_roles_for_department_foreign` FOREIGN KEY (`for_department`) REFERENCES `departments` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `perm_role_has_permissions`
--
DROP TABLE IF EXISTS `perm_role_has_permissions`;
CREATE TABLE `perm_role_has_permissions` (
    `permission_id` bigint(20) unsigned NOT NULL,
    `role_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    KEY `perm_role_has_permissions_role_id_foreign` (`role_id`),
    CONSTRAINT `perm_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `perm_permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `perm_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `perm_roles` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `perm_model_has_permissions`
--
DROP TABLE IF EXISTS `perm_model_has_permissions`;
CREATE TABLE `perm_model_has_permissions` (
    `permission_id` bigint(20) unsigned NOT NULL,
    `model_type` varchar(255) NOT NULL,
    `model_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    KEY `model_has_permissions_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `perm_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `perm_permissions` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `perm_model_has_roles`
--
DROP TABLE IF EXISTS `perm_model_has_roles`;
CREATE TABLE `perm_model_has_roles` (
    `role_id` bigint(20) unsigned NOT NULL,
    `model_type` varchar(255) NOT NULL,
    `model_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    KEY `model_has_roles_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `perm_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `perm_roles` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `personal_access_tokens`
--
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) NOT NULL,
    `tokenable_id` bigint(20) unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `token` varchar(64) NOT NULL,
    `abilities` text DEFAULT NULL,
    `last_used_at` timestamp NULL DEFAULT NULL,
    `expires_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
    KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `sessions`
--
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint(20) unsigned DEFAULT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text DEFAULT NULL,
    `payload` longtext NOT NULL,
    `last_activity` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) NOT NULL,
    `batch` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 33 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Table structure for table `failed_jobs`
--
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `connection` text NOT NULL,
    `queue` text NOT NULL,
    `payload` longtext NOT NULL,
    `exception` longtext NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

------------------------------------------------------
------------------------------------------------------
------------------------------------------------------
-------------------Dumping Data-----------------------
------------------------------------------------------
------------------------------------------------------
------------------------------------------------------

--
-- Dumping data for table `users`
--
INSERT INTO `users` VALUES
(1,'Bantayehu Fikadu','bantayehuf@gmail.com','$2y$10$heS5MQeEeetgRmYG6Hq0iu76IvCz.Hb28VOTSGhe2q/ifyjsG4T2a',NULL,1,'active',NULL,NULL,1,'2023-09-01 11:00:21','2023-09-01 11:00:21');

--
-- Dumping data for table `departments`
--
INSERT INTO `departments` VALUES
(1,'Central Office',1,'2023-09-01 09:45:08','2023-09-01 09:45:08');

--
-- Dumping data for table `perm_permissions`
--

INSERT INTO `perm_permissions` VALUES
(1,'users','manage','manage_users','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(2,'roles','create','create_roles','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(3,'roles','update','update_roles','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(4,'roles','delete','delete_roles','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(5,'roles','view','view_roles','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(6,'departments','create','create_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(7,'departments','update','update_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(8,'departments','update_own','update_own_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(9,'departments','delete','delete_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(10,'departments','delete_own','delete_own_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(11,'departments','view','view_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08'),
(12,'departments','view_own','view_own_departments','web','2023-09-01 09:45:08','2023-09-01 09:45:08');


--
-- Dumping data for table `perm_roles`
--

INSERT INTO `perm_roles` VALUES
(1,'Super Admin','web',1,1,'2023-09-01 09:45:08','2023-09-01 09:45:08');

--
-- Dumping data for table `perm_model_has_roles`
--

/*!40000 ALTER TABLE `perm_model_has_roles` DISABLE KEYS */;
INSERT INTO `perm_model_has_roles` VALUES
(1,'App\\Models\\User',1);

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` VALUES
(25,'2014_10_12_000000_create_users_table',1),
(26,'2014_10_12_100000_create_password_reset_tokens_table',1),
(27,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),
(28,'2019_08_19_000000_create_failed_jobs_table',1),
(29,'2019_12_14_000001_create_personal_access_tokens_table',1),
(30,'2023_08_04_072140_create_sessions_table',1),
(31,'2023_08_19_153622_create_departments_table',1),
(32,'2023_08_25_131442_create_permission_tables',1);
