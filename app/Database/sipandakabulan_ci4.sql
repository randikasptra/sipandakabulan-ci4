-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 16 Jun 2025 pada 07.33
-- Versi server: 9.1.0
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipandakabulan_ci4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `tujuan_desa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `announcements`
--

INSERT INTO `announcements` (`id`, `judul`, `isi`, `tujuan_desa`, `created_at`, `updated_at`) VALUES
(12, 'Kepada Operator Desa Kab.Tasikmalaya', 'Ass.. diberitahukan kepada operator desa untuk segera memenuhi berkas dokumen yang belum lengkap karna akan segera submit ke pusat', NULL, '2025-06-16 14:31:35', '2025-06-16 14:31:35'),
(5, 'Non ut incididunt qu', 'Sunt blanditiis fugd', 'Desa Jayaputra', '2025-06-15 05:29:15', '2025-06-15 20:41:04'),
(6, 'Coba aja Ini mah', 'Awikaowkaokwoa', 'Desa Cigalontang', '2025-06-15 05:31:45', '2025-06-15 20:41:20'),
(8, 'Penting', 'KBBI online atau (kamus besar bahasa Indonesia) daring - yang diluncurkan pada tahun 2016 ini adalah situs yang sengaja dibangun untuk membantu mempermudah pengguna dalam mencari arti kata bahasa Indonesia, dari ribuan kata dijadikan satu dan terorganisir serta tersusun dengan rapi sehingga ketika pengguna mencari sebuah kata didalam situs ini akan lebih mudah. bisa menggunakan form pencarian dan kategori berdasarkan huruf/abjad.\r\n\r\n', NULL, '2025-06-15 19:52:51', '2025-06-15 20:40:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelembagaan`
--

DROP TABLE IF EXISTS `kelembagaan`;
CREATE TABLE IF NOT EXISTS `kelembagaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tahun` int NOT NULL,
  `peraturan_value` int NOT NULL DEFAULT '0',
  `peraturan_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anggaran_value` int NOT NULL DEFAULT '0',
  `anggaran_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forum_anak_value` int NOT NULL DEFAULT '0',
  `forum_anak_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_terpilah_value` int NOT NULL DEFAULT '0',
  `data_terpilah_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dunia_usaha_value` int NOT NULL DEFAULT '0',
  `dunia_usaha_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_nilai` int NOT NULL DEFAULT '0',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelembagaan_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelembagaan`
--

INSERT INTO `kelembagaan` (`id`, `user_id`, `tahun`, `peraturan_value`, `peraturan_file`, `anggaran_value`, `anggaran_file`, `forum_anak_value`, `forum_anak_file`, `data_terpilah_value`, `data_terpilah_file`, `dunia_usaha_value`, `dunia_usaha_file`, `total_nilai`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2025, 15, 'peraturan_1749962938_cute-boy-moslem-holding-lantern-book-cartoon-vector-icon-illustration-people-religion-isolated.zip', 20, 'anggaran_1749962938_cute-boy-moslem-holding-lantern-book-cartoon-vector-icon-illustration-people-religion-isolated.zip', 26, NULL, 15, 'data_terpilah_1749962938_cute-boy-moslem-holding-lantern-book-cartoon-vector-icon-illustration-people-religion-isolated.zip', 10, 'dunia_usaha_1749962938_cute-boy-moslem-holding-lantern-book-cartoon-vector-icon-illustration-people-religion-isolated.zip', 86, 'pending', '2025-06-15 04:48:58', '2025-06-15 04:48:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `klaster1`
--

DROP TABLE IF EXISTS `klaster1`;
CREATE TABLE IF NOT EXISTS `klaster1` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `AnakAktaKelahiran` int NOT NULL,
  `AnakAktaKelahiran_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anggaran` int NOT NULL,
  `anggaran_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `klasters`
--

DROP TABLE IF EXISTS `klasters`;
CREATE TABLE IF NOT EXISTS `klasters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_em` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nilai_maksimal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `progres` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `klasters`
--

INSERT INTO `klasters` (`id`, `slug`, `title`, `nilai_em`, `nilai_maksimal`, `progres`, `created_at`, `updated_at`) VALUES
(1, 'kelembagaan', 'Kelembagaan', 0.00, 100.00, 0.00, NULL, NULL),
(2, 'klaster1', 'Klaster I: Hak Sipil dan Kebebasan', 0.00, 100.00, 0.00, NULL, NULL),
(3, 'klaster2', 'Klaster II: Lingkungan Keluarga', 0.00, 100.00, 0.00, NULL, NULL),
(4, 'klaster3', 'Klaster III: Kesehatan Dasar dan Kesejahteraan', 0.00, 100.00, 0.00, NULL, NULL),
(5, 'klaster4', 'Klaster IV: Pendidikan, Waktu Luang, Budaya', 0.00, 100.00, 0.00, NULL, NULL),
(6, 'klaster5', 'Klaster V: Perlindungan Khusus', 0.00, 100.00, 0.00, NULL, NULL),
(7, 'penyelenggaraan-kla-di-kecamatan-desa', 'Penyelenggaraan KLA di Kecamatan/Desa', 0.00, 100.00, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-29-083446', 'App\\Database\\Migrations\\CreateUsers', 'default', 'App', 1749949445, 1),
(2, '2025-05-29-111128', 'App\\Database\\Migrations\\CreateKlasters', 'default', 'App', 1749949445, 1),
(3, '2025-06-15-010128', 'App\\Database\\Migrations\\CreateKelembagaan', 'default', 'App', 1749949445, 1),
(4, '2025-06-15-024138', 'App\\Database\\Migrations\\CreateAnnouncements', 'default', 'App', 1749955359, 2),
(5, '2025-06-15-232342', 'App\\Database\\Migrations\\CreateKlaster1', 'default', 'App', 1750029968, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('operator','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'operator',
  `desa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_input` enum('belum','sudah') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'belum',
  `status_approve` enum('pending','approved') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `desa`, `status_input`, `status_approve`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$MThsdn.Mltn0BS5ENfEO7uKKEcKRnsO/gH3Vi0UZrb5FdewkElElm', 'admin', NULL, 'belum', 'pending', '2025-06-15 01:04:15', '2025-06-15 01:04:15'),
(2, 'Sariwangi', 'sariwangi@example.com', '$2y$10$NXJgFDu41mA8hI1/jLtu4O.txgEn44JibPngktV.fuik4uW.uiIzC', 'operator', 'Desa Sariwangi', 'belum', 'pending', '2025-06-15 01:04:15', '2025-06-16 14:29:46'),
(3, 'Jayaputa', 'jayaputra2@example.com', '$2y$10$asvdUXpe7TIFtzclaXLwW.IXU1A50I3fTSob9Z5JWFq.Oar2apvFi', 'operator', 'Desa Jayaputra', 'belum', 'pending', '2025-06-15 01:04:15', '2025-06-15 01:04:15'),
(4, 'Cigalontang', 'cigalontang@gmail.com', '$2y$10$KE.ICL9/1H7ZLeGZDRDq6.AkGu1pVgCT7O3La6lQW8wbJmvKVcO8S', 'operator', 'Desa Cigalontang', 'belum', 'pending', '2025-06-15 03:20:53', '2025-06-15 03:20:53'),
(5, 'Jayaratu', 'jayaratu@gmail.com', '$2y$10$GQriZQugvNfI4zuZCH7n3.2GwXVTJDnbUg35lluTI1VLEccHCKiA2', 'operator', 'Desa Jayaratu', 'belum', 'pending', '2025-06-15 05:06:09', '2025-06-15 05:06:09'),
(8, 'Singaparna', 'singaparna@gmail.com', '$2y$10$Qn65hLNa92hk3qhe4SbjmuDbqxIf.J5Tv94ky2eAg.sswBsFuhGFi', 'operator', 'Desa Singaparna', 'belum', 'pending', '2025-06-15 15:11:01', '2025-06-15 15:11:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
