-- GIRZOCK Technologies: complete installation file.
-- Import in phpMyAdmin or with: mysql -u root -p < database/girzock_technologies.sql
CREATE DATABASE IF NOT EXISTS `girzock_technologies` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `girzock_technologies`;

-- GIRZOCK Technologies: database schema (MariaDB 10.4+ / MySQL 5.7+).
-- The 20 core tables from the project brief, plus 8 supporting tables:
-- content_categories, enquiry_notes, enquiry_history, email_log, login_attempts,
-- submission_throttle, url_redirects, migrations.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  `slug` VARCHAR(80) NOT NULL,
  `description` VARCHAR(255) NULL,
  `is_system` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_roles_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admin_permissions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` INT UNSIGNED NOT NULL,
  `module` VARCHAR(60) NOT NULL,
  `can_view` TINYINT(1) NOT NULL DEFAULT 0,
  `can_create` TINYINT(1) NOT NULL DEFAULT 0,
  `can_edit` TINYINT(1) NOT NULL DEFAULT 0,
  `can_delete` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_permission_role_module` (`role_id`,`module`),
  CONSTRAINT `fk_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(60) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `full_name` VARCHAR(120) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `must_change_password` TINYINT(1) NOT NULL DEFAULT 1,
  `status` ENUM('active','disabled') NOT NULL DEFAULT 'active',
  `avatar` VARCHAR(255) NULL,
  `last_login_at` DATETIME NULL,
  `last_login_ip` VARCHAR(45) NULL,
  `password_changed_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_users_username` (`username`),
  UNIQUE KEY `uq_admin_users_email` (`email`),
  KEY `idx_admin_users_role` (`role_id`),
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `token_hash` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `used_at` DATETIME NULL,
  `request_ip` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_password_resets_token` (`token_hash`),
  KEY `idx_password_resets_user` (`user_id`),
  CONSTRAINT `fk_resets_user` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `identifier` VARCHAR(190) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `success` TINYINT(1) NOT NULL DEFAULT 0,
  `attempted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_login_attempts_identifier` (`identifier`,`attempted_at`),
  KEY `idx_login_attempts_ip` (`ip_address`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `submission_throttle` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `scope` VARCHAR(40) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_throttle_scope_ip` (`scope`,`ip_address`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contact_enquiries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reference_no` VARCHAR(30) NOT NULL,
  `full_name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `company` VARCHAR(160) NULL,
  `service_required` VARCHAR(160) NOT NULL,
  `message` TEXT NOT NULL,
  `source_page` VARCHAR(120) NULL,
  `status` ENUM('new','contacted','in_progress','follow_up','converted','closed') NOT NULL DEFAULT 'new',
  `assigned_to` INT UNSIGNED NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` DATETIME NULL,
  `content_hash` CHAR(64) NOT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `archived_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_enquiries_reference` (`reference_no`),
  KEY `idx_enquiries_status` (`status`),
  KEY `idx_enquiries_created` (`created_at`),
  KEY `idx_enquiries_email` (`email`),
  KEY `idx_enquiries_hash` (`content_hash`,`created_at`),
  KEY `idx_enquiries_unread` (`is_read`,`archived_at`),
  KEY `idx_enquiries_assigned` (`assigned_to`),
  CONSTRAINT `fk_enquiries_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enquiry_notes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `enquiry_id` INT UNSIGNED NOT NULL,
  `admin_id` INT UNSIGNED NULL,
  `note` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_notes_enquiry` (`enquiry_id`),
  CONSTRAINT `fk_notes_enquiry` FOREIGN KEY (`enquiry_id`) REFERENCES `contact_enquiries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notes_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enquiry_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `enquiry_id` INT UNSIGNED NOT NULL,
  `admin_id` INT UNSIGNED NULL,
  `action` VARCHAR(40) NOT NULL,
  `old_value` VARCHAR(190) NULL,
  `new_value` VARCHAR(190) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_history_enquiry` (`enquiry_id`),
  CONSTRAINT `fk_history_enquiry` FOREIGN KEY (`enquiry_id`) REFERENCES `contact_enquiries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_history_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `email_log` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(30) NOT NULL,
  `entity_id` INT UNSIGNED NOT NULL,
  `recipient_type` VARCHAR(20) NOT NULL,
  `recipient` VARCHAR(190) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `status` ENUM('pending','sent','failed','skipped') NOT NULL DEFAULT 'pending',
  `attempts` INT UNSIGNED NOT NULL DEFAULT 0,
  `error_message` VARCHAR(500) NULL,
  `sent_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email_once` (`entity_type`,`entity_id`,`recipient_type`),
  KEY `idx_email_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `services` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL,
  `legacy_anchor` VARCHAR(60) NULL,
  `short_description` VARCHAR(500) NULL,
  `description` MEDIUMTEXT NULL,
  `image` VARCHAR(255) NULL,
  `icon` VARCHAR(255) NULL,
  `page_layout` ENUM('card','feature','none') NOT NULL DEFAULT 'feature',
  `page_order` INT NOT NULL DEFAULT 0,
  `menu_title` VARCHAR(160) NULL,
  `menu_description` VARCHAR(255) NULL,
  `menu_image` VARCHAR(255) NULL,
  `menu_order` INT NOT NULL DEFAULT 0,
  `footer_title` VARCHAR(160) NULL,
  `footer_order` INT NOT NULL DEFAULT 0,
  `home_core_label` VARCHAR(40) NULL,
  `home_core_title` VARCHAR(160) NULL,
  `home_core_image` VARCHAR(255) NULL,
  `home_core_order` INT NOT NULL DEFAULT 0,
  `home_overview_title` VARCHAR(160) NULL,
  `home_overview_text` VARCHAR(500) NULL,
  `home_overview_image` VARCHAR(255) NULL,
  `home_overview_order` INT NOT NULL DEFAULT 0,
  `form_label` VARCHAR(160) NULL,
  `form_order` INT NOT NULL DEFAULT 0,
  `status` ENUM('active','disabled','archived') NOT NULL DEFAULT 'active',
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_services_slug` (`slug`),
  KEY `idx_services_status` (`status`,`deleted_at`),
  KEY `idx_services_anchor` (`legacy_anchor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `content_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('product','portfolio') NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_content_categories` (`type`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NULL,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL,
  `short_description` VARCHAR(500) NULL,
  `description` MEDIUMTEXT NULL,
  `features` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `external_url` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` ENUM('published','draft') NOT NULL DEFAULT 'draft',
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_products_slug` (`slug`),
  KEY `idx_products_status` (`status`,`deleted_at`),
  KEY `idx_products_category` (`category_id`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `content_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `case_studies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL,
  `card_label` VARCHAR(60) NULL,
  `card_title` VARCHAR(160) NULL,
  `summary` VARCHAR(500) NULL,
  `category_label` VARCHAR(80) NULL,
  `service_label` VARCHAR(120) NULL,
  `approach` VARCHAR(160) NULL,
  `status_label` VARCHAR(120) NULL,
  `overview` MEDIUMTEXT NULL,
  `challenge` MEDIUMTEXT NULL,
  `solution` MEDIUMTEXT NULL,
  `implementation` MEDIUMTEXT NULL,
  `results` MEDIUMTEXT NULL,
  `highlights` TEXT NULL,
  `quote` VARCHAR(500) NULL,
  `quote_author` VARCHAR(120) NULL,
  `image` VARCHAR(255) NULL,
  `gallery` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` ENUM('published','draft') NOT NULL DEFAULT 'draft',
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_case_studies_slug` (`slug`),
  KEY `idx_case_studies_status` (`status`,`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `portfolio_projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NULL,
  `case_study_id` INT UNSIGNED NULL,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL,
  `short_description` VARCHAR(500) NULL,
  `description` MEDIUMTEXT NULL,
  `client_name` VARCHAR(160) NULL,
  `client_details` VARCHAR(500) NULL,
  `technologies` VARCHAR(500) NULL,
  `live_url` VARCHAR(255) NULL,
  `image` VARCHAR(255) NULL,
  `image_alt` VARCHAR(255) NULL,
  `gallery` TEXT NULL,
  `card_label` VARCHAR(80) NULL,
  `placement` ENUM('gallery','featured','both') NOT NULL DEFAULT 'gallery',
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` ENUM('published','draft') NOT NULL DEFAULT 'draft',
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_portfolio_slug` (`slug`),
  KEY `idx_portfolio_status` (`status`,`deleted_at`),
  KEY `idx_portfolio_category` (`category_id`),
  KEY `idx_portfolio_case_study` (`case_study_id`),
  CONSTRAINT `fk_portfolio_category` FOREIGN KEY (`category_id`) REFERENCES `content_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_portfolio_case_study` FOREIGN KEY (`case_study_id`) REFERENCES `case_studies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL,
  `description` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_tags_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NULL,
  `author_id` INT UNSIGNED NULL,
  `author_name` VARCHAR(120) NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL,
  `excerpt` VARCHAR(500) NULL,
  `content` MEDIUMTEXT NOT NULL,
  `featured_image` VARCHAR(255) NULL,
  `reading_time` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `status` ENUM('draft','scheduled','published','unpublished') NOT NULL DEFAULT 'draft',
  `published_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_posts_slug` (`slug`),
  KEY `idx_blog_public` (`status`,`published_at`,`deleted_at`),
  KEY `idx_blog_category` (`category_id`),
  KEY `idx_blog_author` (`author_id`),
  FULLTEXT KEY `ft_blog_search` (`title`,`excerpt`,`content`),
  CONSTRAINT `fk_blog_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_blog_author` FOREIGN KEY (`author_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blog_post_tags` (
  `post_id` INT UNSIGNED NOT NULL,
  `tag_id` INT UNSIGNED NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `idx_post_tags_tag` (`tag_id`),
  CONSTRAINT `fk_post_tags_post` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_post_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `career_openings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL,
  `legacy_anchor` VARCHAR(60) NULL,
  `summary` VARCHAR(600) NULL,
  `description` MEDIUMTEXT NULL,
  `responsibilities` TEXT NULL,
  `qualifications` TEXT NULL,
  `experience_required` VARCHAR(120) NULL,
  `employment_type` ENUM('FULL_TIME','PART_TIME','CONTRACTOR','TEMPORARY','INTERN','OTHER') NOT NULL DEFAULT 'FULL_TIME',
  `location` VARCHAR(160) NULL,
  `applications_enabled` TINYINT(1) NOT NULL DEFAULT 1,
  `closes_at` DATE NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` ENUM('active','disabled','archived') NOT NULL DEFAULT 'active',
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_careers_slug` (`slug`),
  KEY `idx_careers_status` (`status`,`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_applications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reference_no` VARCHAR(30) NOT NULL,
  `career_id` INT UNSIGNED NULL,
  `position_title` VARCHAR(160) NOT NULL,
  `full_name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `experience` VARCHAR(120) NOT NULL,
  `resume_path` VARCHAR(255) NOT NULL,
  `resume_original_name` VARCHAR(255) NOT NULL,
  `resume_mime` VARCHAR(120) NOT NULL,
  `cover_letter` TEXT NULL,
  `status` ENUM('new','reviewing','shortlisted','interview','offered','hired','rejected') NOT NULL DEFAULT 'new',
  `internal_notes` TEXT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `content_hash` CHAR(64) NOT NULL,
  `ip_address` VARCHAR(45) NULL,
  `archived_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_applications_reference` (`reference_no`),
  KEY `idx_applications_status` (`status`),
  KEY `idx_applications_career` (`career_id`),
  KEY `idx_applications_hash` (`content_hash`),
  KEY `idx_applications_created` (`created_at`),
  CONSTRAINT `fk_applications_career` FOREIGN KEY (`career_id`) REFERENCES `career_openings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `media_library` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` VARCHAR(190) NOT NULL,
  `original_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(120) NOT NULL,
  `file_size` INT UNSIGNED NOT NULL DEFAULT 0,
  `width` INT UNSIGNED NULL,
  `height` INT UNSIGNED NULL,
  `alt_text` VARCHAR(255) NULL,
  `uploaded_by` INT UNSIGNED NULL,
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_media_path` (`file_path`),
  KEY `idx_media_created` (`created_at`),
  CONSTRAINT `fk_media_user` FOREIGN KEY (`uploaded_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `website_settings` (
  `setting_key` VARCHAR(80) NOT NULL,
  `setting_value` TEXT NULL,
  `setting_group` VARCHAR(40) NOT NULL DEFAULT 'general',
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`),
  KEY `idx_settings_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `social_links` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform` VARCHAR(40) NOT NULL,
  `label` VARCHAR(60) NOT NULL,
  `icon` VARCHAR(60) NOT NULL,
  `url` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_social_platform` (`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `seo_metadata` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(30) NOT NULL,
  `entity_key` VARCHAR(80) NOT NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` VARCHAR(500) NULL,
  `canonical_url` VARCHAR(255) NULL,
  `og_image` VARCHAR(255) NULL,
  `robots` VARCHAR(40) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_seo_entity` (`entity_type`,`entity_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `url_redirects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `old_path` VARCHAR(255) NOT NULL,
  `new_path` VARCHAR(255) NULL,
  `status_code` SMALLINT UNSIGNED NOT NULL DEFAULT 301,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_redirect_old` (`old_path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` INT UNSIGNED NULL,
  `module` VARCHAR(60) NOT NULL,
  `action` VARCHAR(40) NOT NULL,
  `entity_id` INT UNSIGNED NULL,
  `description` VARCHAR(255) NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_activity_created` (`created_at`),
  KEY `idx_activity_admin` (`admin_id`),
  CONSTRAINT `fk_activity_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Generated by database/tools/build_install_sql.php from the original website pages.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `admin_roles` (`id`,`name`,`slug`,`description`,`is_system`) VALUES
('1','Super Admin','super_admin','Complete access to every module.','1'),
('2','Content Editor','editor','Manages website content.','0'),
('3','Enquiry Manager','support','Handles contact enquiries.','0'),
('4','HR Manager','hr','Manages careers and job applications.','0');

INSERT INTO `admin_permissions` (`role_id`,`module`,`can_view`,`can_create`,`can_edit`,`can_delete`) VALUES
('2','services','1','1','1','1'),
('2','products','1','1','1','1'),
('2','portfolio','1','1','1','1'),
('2','case_studies','1','1','1','1'),
('2','blog','1','1','1','1'),
('2','media','1','1','1','1'),
('2','categories','1','1','1','1'),
('2','seo','1','1','1','1'),
('2','dashboard','1','0','0','0'),
('3','dashboard','1','0','0','0'),
('3','enquiries','1','0','1','0'),
('4','dashboard','1','0','0','0'),
('4','careers','1','1','1','1'),
('4','applications','1','0','1','1');

INSERT INTO `website_settings` (`setting_key`,`setting_value`,`setting_group`) VALUES
('company_name','GIRZOCK Technologies','general'),
('tagline','Technology. Growth. Elevate.','general'),
('logo_color','assets/logos/girzock-logo-color.png','branding'),
('logo_white','assets/logos/girzock-logo-white.png','branding'),
('logo_icon','assets/logos/girzock-icon.png','branding'),
('favicon','assets/logos/favicon.png','branding'),
('contact_email','girzock@gmail.com','contact'),
('notification_email','girzock@gmail.com','contact'),
('phone','+91 6379362330','contact'),
('business_address','Thisaiyanvilai, Tirunelveli,
Tamil Nadu, India','contact'),
('address_short','Thisaiyanvilai, Tirunelveli, Tamil Nadu','contact'),
('address_locality','Thisaiyanvilai','contact'),
('address_region','Tamil Nadu','contact'),
('address_country','IN','contact'),
('website_url','https://girzock.com','general'),
('footer_description','GIRZOCK Technologies is a software development company in Thisaiyanvilai, Tirunelveli, delivering websites, custom software and cloud solutions.','general'),
('default_meta_title','GIRZOCK Technologies | Software Development Company in Tirunelveli','seo'),
('default_meta_description','GIRZOCK Technologies provides website development, custom software, web applications, WordPress and AWS cloud solutions in Thisaiyanvilai, Tirunelveli.','seo'),
('default_og_image','assets/logos/girzock-horizontal-color.png','seo'),
('google_analytics_id','','seo'),
('gsc_verification','','seo'),
('smtp_host','','smtp'),
('smtp_port','','smtp'),
('smtp_user','','smtp'),
('smtp_password','','smtp'),
('smtp_crypto','','smtp'),
('smtp_from_email','','smtp'),
('smtp_from_name','GIRZOCK Technologies','smtp'),
('portfolio_intro','The gallery above uses sample concept artwork. Finished client work will be added here as projects are completed and approved for publication.','page_text'),
('case_studies_intro','The three studies below are sample concepts that show how GIRZOCK Technologies approaches a project. They are not client engagements and contain no client results. Verified client case studies will be published here with permission.','page_text');

INSERT INTO `social_links` (`platform`,`label`,`icon`,`url`,`sort_order`) VALUES
('linkedin','LinkedIn','fab fa-linkedin-in',NULL,'1'),
('facebook','Facebook','fab fa-facebook-f',NULL,'2'),
('instagram','Instagram','fab fa-instagram','https://www.instagram.com/girzocktechnologies/','3'),
('whatsapp','WhatsApp','fab fa-whatsapp','https://wa.me/916379362330','4');

INSERT INTO `seo_metadata` (`entity_type`,`entity_key`,`meta_title`,`meta_description`) VALUES
('page','home','GIRZOCK Technologies | Software Development Company in Tirunelveli','GIRZOCK Technologies provides website development, custom software, web applications, WordPress and AWS cloud solutions in Thisaiyanvilai, Tirunelveli.'),
('page','about','About GIRZOCK Technologies | IT Company in Thisaiyanvilai, Tirunelveli','Learn about GIRZOCK Technologies, a software development and IT services company in Thisaiyanvilai, Tirunelveli, Tamil Nadu. Our mission, vision, values and expertise.'),
('page','services','Web, Software & Cloud Services in Tirunelveli | GIRZOCK Technologies','Website design, custom software, web applications, e-commerce, WordPress, UI/UX, cloud computing, AWS and IT consulting services from GIRZOCK Technologies in Tirunelveli.'),
('page','products','Software Products & Digital Platforms | GIRZOCK Technologies','Business websites, online stores, management software, customer portals, booking systems and cloud care plans, tailored by GIRZOCK Technologies in Tirunelveli.'),
('page','portfolio','Portfolio: Websites, Web Apps & E-commerce | GIRZOCK Technologies','Explore the websites, web applications, e-commerce stores, WordPress sites and cloud projects that GIRZOCK Technologies builds in Tirunelveli, Tamil Nadu.'),
('page','case-studies','Case Studies: Our Approach to Projects | GIRZOCK Technologies','See how GIRZOCK Technologies approaches e-commerce, custom software and AWS cloud projects through sample concepts covering challenges, solutions and intended outcomes.'),
('page','blog','Technology Blog: Web, Software & Cloud | GIRZOCK Technologies','Practical articles on web development, custom software, cloud computing, UI/UX, WordPress and digital transformation from GIRZOCK Technologies.'),
('page','careers','IT Careers in Tirunelveli | Join GIRZOCK Technologies','Looking for software, web, design or cloud jobs in Thisaiyanvilai, Tirunelveli, Tamil Nadu? See the areas GIRZOCK Technologies hires in and how to apply.'),
('page','contact','Contact GIRZOCK Technologies | Thisaiyanvilai, Tirunelveli','Contact GIRZOCK Technologies in Thisaiyanvilai, Tirunelveli, Tamil Nadu about websites, custom software and cloud solutions. Email girzock@gmail.com or send an enquiry online.');

INSERT INTO `content_categories` (`id`,`type`,`name`,`slug`,`sort_order`) VALUES
('1','portfolio','Websites','websites','1'),
('2','portfolio','Web apps','web-apps','2'),
('3','portfolio','E-commerce','e-commerce','3'),
('4','product','Websites','websites','1'),
('5','product','E-commerce','e-commerce','2'),
('6','product','Software','software','3'),
('7','product','Web App','web-app','4'),
('8','product','Cloud','cloud','5');

INSERT INTO `services` (`title`,`slug`,`legacy_anchor`,`short_description`,`image`,`icon`,`page_layout`,`page_order`,`menu_title`,`menu_description`,`menu_image`,`menu_order`,`footer_title`,`footer_order`,`home_core_label`,`home_core_title`,`home_core_image`,`home_core_order`,`home_overview_title`,`home_overview_text`,`home_overview_image`,`home_overview_order`,`form_label`,`form_order`,`status`) VALUES
('Website Design & Development','website-development','web-design','Responsive, professional websites built around your brand, your customers and your goals.','assets/images/service/service6-1.png',NULL,'card','1','Website Development','Responsive, professional websites built around your brand and your customers.','assets/images/project/project3-1.png','1','Website Design & Development','1','Website','Website Design & Development','assets/images/service/core-1.png','1','Website Development','Responsive, professional websites built around your brand, your customers and your goals.','assets/images/service/service6-1.png','1','Website Development','1','active'),
('Custom Software Development','custom-software-development','custom-software','Software designed around your processes, from internal tools to complete business systems.','assets/images/service/service6-2.png',NULL,'card','2','Custom Software Development','Software designed around your processes, from internal tools to full systems.','assets/images/feature/software-5.png','2','Custom Software Development','2','Software','Custom Software Development','assets/images/service/core-2.png','2','Custom Software Development','Software designed around your processes, from internal tools to complete business systems.','assets/images/service/service6-2.png','2','Custom Software Development','2','active'),
('Web Application Development','web-application-development','web-apps','Web applications and portals built for your team and your customers.','assets/images/service/service6-3.png',NULL,'card','3','Web Application Development','Web applications and portals built for your team and your customers.','assets/images/project/pro8-14.png','4','Web Application Development','3','Web Apps','Web Application Development','assets/images/service/core-3.png','3','Web Application Development',NULL,'assets/images/service/service6-3.png','3','Web Application Development','3','active'),
('E-commerce Development','e-commerce-development','ecommerce','Online stores with product management, secure payments and a smooth checkout','assets/images/feature/software-3.png','assets/images/icon/phone.svg','card','4','E-commerce Development','Online stores with product management, secure payments and a smooth checkout.','assets/images/feature/software-3.png','8','E-commerce Development','4','Stores','E-commerce Development','assets/images/service/core-4.png','4',NULL,NULL,NULL,'0','E-commerce Development','7','active'),
('WordPress Development','wordpress-development','wordpress','Custom WordPress websites that your team can update easily, with themes and plugins set up to suit you.','assets/images/service/service-wordpress.png',NULL,'card','5','WordPress Development','WordPress websites that are straightforward for your team to manage.','assets/images/event/hero4.png','6','WordPress Development','5','WordPress','WordPress Development','assets/images/service/core-5.png','5',NULL,NULL,NULL,'0','WordPress Development','4','active'),
('UI/UX Design','ui-ux-design','ui-ux','Research-led interfaces and clear user journeys that make websites and software easy to use.','assets/images/feature/software-4.png','assets/images/feature/feature1.svg','feature','6','UI/UX Design','Clear user journeys and interfaces that make software easy to use.','assets/images/feature/software-4.png','5','UI/UX Design','6','UI/UX','UI/UX Design','assets/images/service/core-6.png','6',NULL,NULL,NULL,'0','UI/UX Design','5','active'),
('Cloud Computing','cloud-solutions','cloud','Planning, migration and management that move your applications and data to the cloud.','assets/images/project/pro8-10.png','assets/images/feature/feature2.svg','feature','7','Cloud Solutions','Cloud computing and AWS solutions that give your applications room to grow.','assets/images/project/pro8-10.png','3','Cloud Computing','7','Cloud','Cloud Computing','assets/images/service/core-7.png','7','Cloud Solutions','Cloud computing and AWS solutions that give your applications room to grow.','assets/images/icon/phone.svg','4','Cloud & AWS Solutions','6','active'),
('AWS Cloud Solutions','aws-cloud-solutions','aws','Architecture, deployment and ongoing support for applications running on Amazon Web Services.','assets/images/service/core-8.png','assets/images/feature/feature3.svg','feature','8',NULL,NULL,NULL,'0','AWS Cloud Solutions','8','AWS','AWS Cloud Solutions','assets/images/service/core-8.png','8',NULL,NULL,NULL,'0',NULL,'0','active'),
('IT Consulting','it-consulting','consulting','Practical advice on choosing technology, improving systems and planning digital transformation.','assets/images/service/service6-5.png','assets/images/feature/feature4.svg','feature','9','IT Consulting','Practical advice on choosing technology and improving your systems.','assets/images/event/faq3.png','7','IT Consulting','9','Consulting','IT Consulting','assets/images/service/core-9.png','9','IT Consulting','Practical advice on choosing technology, improving systems and planning digital transformation.','assets/images/service/service6-5.png','5','IT Consulting','8','active'),
('Digital Transformation','digital-transformation',NULL,'A step-by-step plan for adopting technology across your business.','assets/images/bg/bg2.png',NULL,'none','10','Digital Transformation','A step-by-step plan for adopting technology across your business.','assets/images/bg/bg2.png','9',NULL,'0',NULL,NULL,NULL,'0',NULL,NULL,NULL,'0',NULL,'0','active');

INSERT INTO `products` (`category_id`,`title`,`slug`,`short_description`,`image`,`sort_order`,`status`) VALUES
('4','Business Website Platform','business-website-platform','A professional website you can update yourself, with enquiry forms and search-ready pages.','assets/images/event/product-1.png','1','published'),
('5','Online Store Platform','online-store-platform','Product catalogue, cart, payments and order management for selling online.','assets/images/event/product-2.png','2','published'),
('6','Business Management Software','business-management-software','One place for customers, tasks, invoices and reports, shaped around your workflow.','assets/images/event/product-3.png','3','published'),
('7','Customer Portal','customer-portal','A secure login area where your customers can view services, documents and requests.','assets/images/event/product-4.png','4','published'),
('7','Booking & Enquiry System','booking-enquiry-system','Online bookings, enquiry tracking and notifications for service businesses.','assets/images/event/product-5.png','5','published'),
('8','Cloud Hosting & Care Plan','cloud-hosting-care-plan','Managed hosting on the cloud with updates, monitoring and backups.','assets/images/event/product-6.png','6','published');

INSERT INTO `case_studies` (`id`,`title`,`slug`,`card_label`,`card_title`,`summary`,`category_label`,`service_label`,`approach`,`status_label`,`challenge`,`solution`,`results`,`highlights`,`quote`,`quote_author`,`sort_order`,`status`) VALUES
('1','Taking a Local Retailer Online','taking-a-local-retailer-online','Sample concept','Taking a local retailer online','E-commerce development for a shop that sells only in person.','E-commerce','E-commerce Development','Plan, design, build, launch','Sample concept, not a client project','A retailer depends on walk-in customers and phone orders, with no way to sell to people outside the local area.','A responsive online store with a searchable catalogue, secure checkout and a simple order dashboard that staff can manage day to day.',NULL,'Product catalogue the team can update
Mobile-friendly browsing and checkout
Order tracking in one place
Search-ready product pages',NULL,NULL,'1','published'),
('2','Replacing Spreadsheets with Custom Software','replacing-spreadsheets-with-custom-software','Sample concept','Replacing spreadsheets with custom software','A central system for a service business that tracks work by hand.','Custom Software','Custom Software Development','Plan, design, build, launch','Sample concept, not a client project','A service business tracks jobs, customers and invoices across several spreadsheets. Information is duplicated, updates are easily missed, and it is hard to see the status of the work at a glance.','A custom web application that brings customers, jobs and invoices together, with role-based access so that each person sees what they need. We would map the current process first, and then build the system in stages so that the team can give feedback early.','One reliable source of information and less time spent on repeated data entry. On a real project, we would agree how to measure this with the client before work begins.',NULL,'Good software starts by understanding how the work gets done today, before deciding what should change.','GIRZOCK Technologies','2','published'),
('3','Moving a Business Application to AWS','moving-a-business-application-to-aws','Sample concept','Moving a business application to AWS','A cloud migration plan for an application that has outgrown its server.','Cloud Migration','AWS Cloud Solutions','Plan, design, build, launch','Sample concept, not a client project','A growing application runs on a single server. Traffic peaks slow it down, backups depend on manual steps, and any maintenance means downtime for users.','A staged move to AWS, starting with an assessment of the application and its data. The plan would cover managed databases, automated backups, monitoring and a tested rollback at each step.','A more resilient application that can scale with demand and is easier to maintain. On a real project, we would record baseline figures first so that any improvement can be measured honestly.',NULL,'A cloud migration succeeds when it is planned in small, reversible steps.','GIRZOCK Technologies','3','published');

INSERT INTO `portfolio_projects` (`category_id`,`case_study_id`,`title`,`slug`,`short_description`,`image`,`image_alt`,`card_label`,`placement`,`sort_order`,`status`) VALUES
('1',NULL,'Business website: sample concept','business-website-sample-concept','Business website sample concept artwork.','assets/images/project/pro8-7.png','Business website sample concept artwork',NULL,'gallery','1','published'),
('2',NULL,'Web application: sample concept','web-application-sample-concept','Web application sample concept artwork.','assets/images/project/pro8-8.png','Web application sample concept artwork',NULL,'gallery','2','published'),
('3',NULL,'Online store: sample concept','online-store-sample-concept','Online store sample concept artwork.','assets/images/project/pro8-9.png','Online store sample concept artwork',NULL,'gallery','3','published'),
('2',NULL,'Customer portal: sample concept','customer-portal-sample-concept','Customer portal sample concept artwork.','assets/images/project/pro8-10.png','Customer portal sample concept artwork',NULL,'gallery','4','published'),
('3',NULL,'Product catalogue: sample concept','product-catalogue-sample-concept','Product catalogue sample concept artwork.','assets/images/project/pro8-11.png','Product catalogue sample concept artwork',NULL,'gallery','5','published'),
('1',NULL,'WordPress website: sample concept','wordpress-website-sample-concept','WordPress website sample concept artwork.','assets/images/project/pro8-12.png','WordPress website sample concept artwork',NULL,'gallery','6','published'),
('1',NULL,'Landing page: sample concept','landing-page-sample-concept','Landing page sample concept artwork.','assets/images/project/pro8-13.png','Landing page sample concept artwork',NULL,'gallery','7','published'),
('3',NULL,'Storefront redesign: sample concept','storefront-redesign-sample-concept','Storefront redesign sample concept artwork.','assets/images/project/pro8-14.png','Storefront redesign sample concept artwork',NULL,'gallery','8','published'),
('2',NULL,'Admin dashboard: sample concept','admin-dashboard-sample-concept','Admin dashboard sample concept artwork.','assets/images/project/pro8-15.png','Admin dashboard sample concept artwork',NULL,'gallery','9','published'),
('3','1','Online Store for a Local Retailer','online-store-for-a-local-retailer','A concept for a responsive store with catalogue, checkout and order management.','assets/images/project/pro8-9.png','Online Store for a Local Retailer','Concept / E-commerce','featured','100','published'),
('2','2','Custom Business Management System','custom-business-management-system','A concept for one central system for customers, jobs and invoices.','assets/images/project/pro8-15.png','Custom Business Management System','Concept / Custom Software','featured','101','published'),
('2','3','Cloud Application Migration','cloud-application-migration','A concept for a staged migration with backups and monitoring.','assets/images/project/pro8-10.png','Cloud Application Migration','Concept / Cloud','featured','102','published'),
('1',NULL,'Corporate Website Development','corporate-website-development','A concept for a professional company website a team can manage.','assets/images/project/project3-1.png','Corporate Website Development','Concept / Web Design','featured','103','published');

INSERT INTO `blog_categories` (`id`,`name`,`slug`,`sort_order`) VALUES
('1','Web Development','web-development','1'),
('2','Custom Software','custom-software','2'),
('3','Cloud and AWS','cloud-and-aws','3'),
('4','UI/UX Design','ui-ux-design','4'),
('5','WordPress','wordpress','5'),
('6','Digital Transformation','digital-transformation','6');

INSERT INTO `blog_tags` (`id`,`name`,`slug`) VALUES
('1','Web','web'),
('2','Business','business'),
('3','Software','software'),
('4','Cloud','cloud'),
('5','AWS','aws'),
('6','Design','design'),
('7','WordPress','wordpress'),
('8','Technology','technology');

INSERT INTO `blog_posts` (`id`,`category_id`,`author_id`,`author_name`,`title`,`slug`,`excerpt`,`content`,`featured_image`,`reading_time`,`status`,`published_at`) VALUES
('1','1',NULL,'GIRZOCK Team','How to plan a business website that generates enquiries','how-to-plan-a-business-website-that-generates-enquiries','Decide what visitors should do, answer their questions and get the basics right on a phone.','<p class="paragraph">Start with the outcome, not the design. Decide what a visitor should do on your website, such as calling, booking or sending an enquiry, and make that action obvious on every page.</p>
<p>Next, write down the questions that your customers ask most often. Those answers usually become your most useful pages. Keep your services easy to find, show your location clearly, and make sure each page has one main purpose.</p>
<p>Finally, check the basics on a phone. Many visitors will see your website on a small screen first, so readable text, fast loading and a short contact form matter more than decorative features.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">A good business website makes the next step obvious for your visitor.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-1.png','1','published','2026-11-05 09:00:00'),
('2','2',NULL,'GIRZOCK Team','Custom software or off-the-shelf: how to choose','custom-software-or-off-the-shelf-how-to-choose','A simple way to compare cost, flexibility and long-term fit before you commit.','<p class="paragraph">Off-the-shelf software is usually quicker to start with and costs less up front. It is often the right choice when your process is standard, such as basic accounting or email.</p>
<p>Custom software makes sense when your process is what sets your business apart, or when you keep working around the limits of existing tools. It costs more to build, but it can fit your workflow exactly and connect with the systems you already use.</p>
<p>To compare them fairly, consider licence fees, the time your team loses to workarounds and how each option would cope as you grow. Many businesses end up with a mix: standard tools for common tasks, and custom software for what is unique to them.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">Buy for what is standard in your business, and build for what makes it different.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-3.png','1','published','2026-11-04 13:00:00'),
('3','3',NULL,'GIRZOCK Team','What to check before moving your business to the cloud','what-to-check-before-moving-your-business-to-the-cloud','The questions to answer first, from what to move to who manages it afterwards.','<p class="paragraph">Begin with an inventory. List your applications, your data and how they depend on each other. Not everything needs to move at once, and some systems may be better replaced than migrated.</p>
<p>Then look at security and responsibility. Cloud providers such as AWS secure the underlying infrastructure, but you remain responsible for access controls, configuration and your data. Decide who will manage these after the move.</p>
<p>Finally, plan for cost and recovery. Set budget alerts, test your backups, and move one lower-risk system first. What you learn from that first move will make the rest of the migration easier.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">Move in small, tested steps, and know who is responsible for what afterwards.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-5.png','1','published','2026-11-03 17:00:00'),
('4','4',NULL,'GIRZOCK Team','UI/UX basics every business owner should know','ui-ux-basics-every-business-owner-should-know','UI is how your product looks. UX is how it feels to use.','<p class="paragraph">UI is how your product looks. UX is how it feels to use. A polished design still fails if people cannot find what they came for, so it is worth paying attention to both.</p>
<p>Three habits help most. Use familiar patterns so that people do not have to learn your interface. Remove steps and form fields that you do not really need. And keep buttons, colours and wording consistent across every page.</p>
<p>You do not need a large research budget to improve. Watch a few people try to complete a real task on your website without helping them. The places where they hesitate will show you what to fix first.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">If people hesitate, the design has more work to do.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-6.png','1','published','2026-11-02 21:00:00'),
('5','5',NULL,'GIRZOCK Team','WordPress or a custom-built website: which suits you?','wordpress-or-a-custom-built-website-which-suits-you','WordPress is a strong choice for content-led websites, such as company sites and blogs, and it works for many online stores too.','<p class="paragraph">WordPress is a strong choice for content-led websites, such as company sites and blogs, and it works for many online stores too. Your team can update pages without a developer, and a large ecosystem of themes and plugins can shorten the build.</p>
<p>A custom-built website or web application suits projects with unusual features, complex logic or demanding performance needs. You get full control over how it works, although it usually takes longer to build.</p>
<p>Whichever you choose, plan for maintenance. WordPress core, themes and plugins need regular updates to stay secure, and custom code needs someone who understands it. Ask who will look after the website once it is live.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">Choose the option that fits what your website needs to do, and plan who will maintain it.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-10.png','1','published','2026-11-02 01:00:00'),
('6','6',NULL,'GIRZOCK Team','A practical first step towards digital transformation','a-practical-first-step-towards-digital-transformation','Digital transformation does not have to begin with a large programme.','<p class="paragraph">Digital transformation does not have to begin with a large programme. It means using technology to change how your business works, and the best starting point is usually one process that causes regular frustration.</p>
<p>Pick something specific, such as handling enquiries, tracking orders or preparing reports. Map how it works today, including the workarounds, and decide what a better result would look like before choosing a tool.</p>
<p>Then make one improvement, measure whether it helped, and involve the people who do the work every day. Small changes that your team actually adopts are worth more than an ambitious system that nobody uses.</p>
<blockquote>
<div class="quote-box">
<img src="assets/images/icon/comas2.svg" alt="">
<h4 class="title">Start with one real problem, and let results guide the next step.</h4>
<span class="sub-title">GIRZOCK Team</span>
</div>
</blockquote>','assets/images/blog/blog1-8.png','1','published','2026-11-01 05:00:00');

INSERT INTO `blog_post_tags` (`post_id`,`tag_id`,`sort_order`) VALUES
('1','1','0'),
('1','2','1'),
('2','3','0'),
('2','2','1'),
('3','4','0'),
('3','5','1'),
('4','6','0'),
('4','2','1'),
('5','7','0'),
('5','1','1'),
('6','2','0'),
('6','8','1');

INSERT INTO `career_openings` (`title`,`slug`,`legacy_anchor`,`summary`,`employment_type`,`location`,`applications_enabled`,`sort_order`,`status`) VALUES
('Web Developer','web-developer','web-developer','Build responsive websites and web applications using HTML, CSS, JavaScript and modern frameworks. You should care about clean code, performance and attention to detail.','FULL_TIME','Thisaiyanvilai, Tirunelveli','1','1','active'),
('Software Developer','software-developer','software-developer','Design and build custom business software, from database structure to user-facing features. You should enjoy understanding a business problem before writing code.','FULL_TIME','Thisaiyanvilai, Tirunelveli','1','2','active'),
('WordPress Developer','wordpress-developer','wordpress-developer','Create and customise WordPress themes and plugins, and keep client websites secure and up to date.','FULL_TIME','Thisaiyanvilai, Tirunelveli','1','3','active'),
('UI/UX Designer','ui-ux-designer','ui-ux-designer','Turn requirements into clear user journeys, wireframes and polished interface designs. Please share a portfolio with your application.','FULL_TIME','Thisaiyanvilai, Tirunelveli','1','4','active'),
('Cloud Engineer','cloud-engineer','cloud-engineer','Deploy, monitor and maintain applications on AWS and other cloud platforms, with a focus on reliability and security.','FULL_TIME','Thisaiyanvilai, Tirunelveli','1','5','active'),
('Internships and Freshers','internships','internships','Are you a student or a recent graduate? Tell us what you have built, what you are learning and the area you want to grow in.','INTERN','Thisaiyanvilai, Tirunelveli','1','6','active');

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS `migrations` (`version` BIGINT(20) NOT NULL) ENGINE=InnoDB;
INSERT INTO `migrations` (`version`) VALUES (1);
