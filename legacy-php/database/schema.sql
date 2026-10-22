-- Schema Database Website Musholla Ar-rahman
-- Kompatibel dengan MySQL 8, MariaDB, dan phpMyAdmin Shared Hosting

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Tabel Users / Admin
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin', 'editor') NOT NULL DEFAULT 'editor',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel Settings (Konfigurasi Profil & Modul)
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `description` VARCHAR(255) NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Posts (Berita & Pengumuman)
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `category` ENUM('Berita', 'Pengumuman') NOT NULL DEFAULT 'Berita',
  `excerpt` TEXT NULL,
  `content` LONGTEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `author` VARCHAR(100) DEFAULT 'Pengurus DKM',
  `status` ENUM('Terbit', 'Draft') NOT NULL DEFAULT 'Terbit',
  `views` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_slug` (`slug`),
  INDEX `idx_category` (`category`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Events (Kegiatan)
CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `event_date` DATE NOT NULL,
  `start_time` VARCHAR(10) DEFAULT '18:00',
  `end_time` VARCHAR(10) DEFAULT 'Selesai',
  `location` VARCHAR(255) DEFAULT 'Musholla Ar-rahman',
  `category` VARCHAR(50) DEFAULT 'Rutin',
  `status` ENUM('Mendatang', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Mendatang',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_date` (`event_date`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel Galleries (Galeri Foto Dokumentasi)
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `category` VARCHAR(50) DEFAULT 'Kegiatan',
  `alt_text` VARCHAR(255) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel Financial Reports (Laporan Kas Keuangan)
CREATE TABLE IF NOT EXISTS `financial_reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `period_month` INT NOT NULL,
  `period_year` INT NOT NULL,
  `income` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `expense` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `balance` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `description` TEXT NULL,
  `status` ENUM('Terbit', 'Draft') NOT NULL DEFAULT 'Terbit',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_period` (`period_year`, `period_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Contact Messages (Pesan Jamaah / Kontak)
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `email` VARCHAR(100) NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
