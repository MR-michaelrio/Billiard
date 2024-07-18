-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2024 at 06:37 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billiard`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harga_rental`
--

CREATE TABLE `harga_rental` (
  `id` int NOT NULL,
  `harga` varchar(255) NOT NULL,
  `jenis` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `harga_rental`
--

INSERT INTO `harga_rental` (`id`, `harga`, `jenis`) VALUES
(1, '1000', 'menit'),
(2, '300000', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int NOT NULL,
  `id_player` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_rental` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_belanja` int DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `id_player`, `id_rental`, `id_belanja`, `updated_at`, `created_at`) VALUES
(62, 'M123', 'R7', NULL, '2024-07-11 10:53:00', '2024-07-11 10:53:00'),
(63, 'M123', 'R259853392', NULL, '2024-07-15 19:35:18', '2024-07-15 19:35:18'),
(64, 'M332', 'R643167579', NULL, '2024-07-15 19:37:51', '2024-07-15 19:37:51'),
(65, 'M123', 'R620364216', NULL, '2024-07-15 19:38:13', '2024-07-15 19:38:13'),
(66, 'M123', 'R491548331', NULL, '2024-07-15 19:58:37', '2024-07-15 19:58:37'),
(67, 'M123', 'R415097461', NULL, '2024-07-15 20:08:22', '2024-07-15 20:08:22'),
(68, 'M123', 'R39362236', NULL, '2024-07-15 20:11:14', '2024-07-15 20:11:14'),
(69, '440174712', 'R371228758', NULL, '2024-07-15 20:14:29', '2024-07-15 20:14:29'),
(70, 'M123', 'R499858784', NULL, '2024-07-15 20:14:39', '2024-07-15 20:14:39'),
(71, '464409766', 'R848120767', NULL, '2024-07-15 20:14:47', '2024-07-15 20:14:47'),
(72, 'M123', 'R392069752', NULL, '2024-07-15 20:20:13', '2024-07-15 20:20:13'),
(73, 'M123', 'R284139959', NULL, '2024-07-15 20:27:52', '2024-07-15 20:27:52'),
(74, 'M123', 'R548032569', NULL, '2024-07-15 20:32:14', '2024-07-15 20:32:14'),
(75, 'M123', 'R823475333', NULL, '2024-07-15 20:36:57', '2024-07-15 20:36:57'),
(76, 'M123', 'R326586257', NULL, '2024-07-15 20:39:00', '2024-07-15 20:39:00'),
(77, 'M123', 'R245480137', NULL, '2024-07-15 20:43:16', '2024-07-15 20:43:16'),
(78, 'M123', 'R490520468', NULL, '2024-07-15 20:44:00', '2024-07-15 20:44:00'),
(79, '956329731', 'R514626964', NULL, '2024-07-15 20:44:28', '2024-07-15 20:44:28'),
(80, 'M123', 'R553702769', NULL, '2024-07-15 20:44:50', '2024-07-15 20:44:50'),
(81, 'M123', 'R953784239', NULL, '2024-07-15 20:45:04', '2024-07-15 20:45:04'),
(82, 'M123', 'R862649873', NULL, '2024-07-16 16:54:58', '2024-07-16 16:54:58'),
(83, 'M123', 'R137245166', NULL, '2024-07-16 16:55:17', '2024-07-16 16:55:17'),
(84, '487758621', 'R10253254', NULL, '2024-07-16 17:11:11', '2024-07-16 17:11:11'),
(85, '605906201', 'R458961022', NULL, '2024-07-16 17:12:15', '2024-07-16 17:12:15'),
(86, 'M123', 'R459173412', NULL, '2024-07-16 17:44:20', '2024-07-16 17:44:20');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja_bl`
--

CREATE TABLE `meja_bl` (
  `id` int NOT NULL,
  `nomor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meja_bl`
--

INSERT INTO `meja_bl` (`id`, `nomor`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tanggal_lahir` date DEFAULT NULL,
  `mulai_member` date DEFAULT NULL,
  `akhir_member` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama`, `no_telp`, `alamat`, `tanggal_lahir`, `mulai_member`, `akhir_member`, `updated_at`, `created_at`) VALUES
('M99006467', 'test', '082114578009', 'wwwwww', '2024-07-20', '2024-07-19', '2024-10-19', '2024-07-18 17:26:04', '2024-07-18 17:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_07_10_074848_create_tables_table', 2),
(7, '2024_07_15_173307_create_orders_table', 3),
(8, '2024_07_15_173318_create_order_items_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `non_member`
--

CREATE TABLE `non_member` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `non_member`
--

INSERT INTO `non_member` (`id`, `nama`, `no_telp`, `updated_at`, `created_at`) VALUES
(440174712, 'test', '082114578009', '2024-07-15 19:07:46', '2024-07-15 19:07:46'),
(464409766, 'Rifky11', '082114578009', '2024-07-15 19:16:49', '2024-07-15 19:16:49'),
(487758621, 'test', '082114578009', '2024-07-16 17:08:37', '2024-07-16 17:08:37'),
(605906201, 'Rifky11', '082114578009', '2024-07-16 17:12:08', '2024-07-16 17:12:08'),
(956329731, 'test', '081213460111', '2024-07-15 20:43:48', '2024-07-15 20:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `id_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_table`, `status`, `created_at`, `updated_at`) VALUES
(10, '0', 'lunas', '2024-07-16 17:42:28', '2024-07-16 17:42:28'),
(11, '79', 'belum', '2024-07-16 17:42:47', '2024-07-16 17:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(11, 10, 'aqua', 1, '10000.00', '2024-07-16 17:42:28', '2024-07-16 17:42:28'),
(12, 11, 'Nasi Goreng', 1, '10000.00', '2024-07-16 17:42:47', '2024-07-16 17:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `qty`, `updated_at`, `created_at`) VALUES
('P1', 'aqua', '10000', 100, '2024-07-11 09:08:18', '0000-00-00 00:00:00'),
('P2', 'Nasi Goreng', '10000', 100, '2024-07-11 10:11:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `id` int NOT NULL,
  `id_player` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `lama_waktu` time DEFAULT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime DEFAULT NULL,
  `no_meja` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_invoice`
--

CREATE TABLE `rental_invoice` (
  `id_rental` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `lama_waktu` time DEFAULT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime DEFAULT NULL,
  `no_meja` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_invoice`
--

INSERT INTO `rental_invoice` (`id_rental`, `lama_waktu`, `waktu_mulai`, `waktu_akhir`, `no_meja`, `updated_at`, `created_at`) VALUES
('R10253254', '00:02:30', '2024-07-17 00:08:37', NULL, 1, '2024-07-16 17:11:11', '2024-07-16 17:11:11'),
('R137245166', '02:00:00', '2024-07-16 23:55:10', '2024-07-17 01:55:10', 1, '2024-07-16 16:55:17', '2024-07-16 16:55:17'),
('R245480137', '01:30:34', '2024-07-16 03:39:07', NULL, 1, '2024-07-15 20:43:16', '2024-07-15 20:43:16'),
('R284139959', NULL, '2024-07-16 03:20:19', NULL, 1, '2024-07-15 20:27:52', '2024-07-15 20:27:52'),
('R326586257', '01:26:18', '2024-07-16 03:37:04', NULL, 1, '2024-07-15 20:39:00', '2024-07-15 20:39:00'),
('R392069752', NULL, '2024-07-16 03:17:00', NULL, 1, '2024-07-15 20:20:13', '2024-07-15 20:20:13'),
('R458961022', '00:05:00', '2024-07-17 00:12:08', '2024-07-17 00:17:08', 1, '2024-07-16 17:12:15', '2024-07-16 17:12:15'),
('R459173412', '01:07:16', '2024-07-16 23:37:01', NULL, 2, '2024-07-16 17:44:20', '2024-07-16 17:44:20'),
('R490520468', '00:00:30', '2024-07-16 03:43:23', NULL, 1, '2024-07-15 20:43:59', '2024-07-15 20:43:59'),
('R514626964', '01:00:00', '2024-07-16 03:43:48', '2024-07-16 04:43:48', 3, '2024-07-15 20:44:28', '2024-07-15 20:44:28'),
('R548032569', NULL, '2024-07-16 03:27:59', NULL, 1, '2024-07-15 20:32:14', '2024-07-15 20:32:14'),
('R553702769', '00:01:12', '2024-07-16 03:43:35', NULL, 2, '2024-07-15 20:44:50', '2024-07-15 20:44:50'),
('R823475333', '01:24:15', '2024-07-16 03:32:22', NULL, 1, '2024-07-15 20:36:57', '2024-07-15 20:36:57'),
('R862649873', '00:00:02', '2024-07-16 23:54:52', NULL, 1, '2024-07-16 16:54:58', '2024-07-16 16:54:58'),
('R953784239', '00:00:03', '2024-07-16 03:44:58', NULL, 2, '2024-07-15 20:45:04', '2024-07-15 20:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('COfV74lUhaTW99xE4OHujdYTXb0afHsoBC76dAhF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiclRRbEtSWUY1Qnp2Z3VYeExxWDVJcDJ5WkdtUkxlVk9WY0VEcVRNYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ibCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721324352),
('WlMBuvkreHGSQxoVu5kWuE0MZ05qVNFvq75ch5pt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMW9KWVFWbGhYTTAzNUFRTGNQRXNrRW9OUHh0U0ZnZlp2UjZ5eDJYYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ibCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721320356);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `harga_rental`
--
ALTER TABLE `harga_rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meja_bl`
--
ALTER TABLE `meja_bl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_member`
--
ALTER TABLE `non_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_invoice`
--
ALTER TABLE `rental_invoice`
  ADD PRIMARY KEY (`id_rental`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harga_rental`
--
ALTER TABLE `harga_rental`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meja_bl`
--
ALTER TABLE `meja_bl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `non_member`
--
ALTER TABLE `non_member`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=956329732;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
