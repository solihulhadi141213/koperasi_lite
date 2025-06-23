-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 23, 2025 at 10:13 PM
-- Server version: 9.1.0
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

DROP TABLE IF EXISTS `akses`;
CREATE TABLE IF NOT EXISTS `akses` (
  `id_akses` int NOT NULL AUTO_INCREMENT,
  `nama_akses` mediumtext NOT NULL,
  `kontak_akses` varchar(20) DEFAULT NULL,
  `email_akses` varchar(225) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` mediumtext NOT NULL,
  `image_akses` char(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `akses` varchar(20) NOT NULL,
  `datetime_daftar` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  PRIMARY KEY (`id_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `nama_akses`, `kontak_akses`, `email_akses`, `password`, `image_akses`, `akses`, `datetime_daftar`, `datetime_update`) VALUES
(1, 'Solihul Hadi', '6289601154723', 'dhiforester@gmail.com', 'f4a3229c9c5f1bdd9c6a6791080791b7', '9bf5b8e474a5927eb87d5084a85b5a.jpg', 'Admin', '2022-08-29 11:10:06', '2025-06-23 17:59:41'),
(4, 'Anita', '6289601154724', 'animaryani@gmail.com', '1ebc7a02439687420f4f18ebe6bd03ac', '1396353a04e0e796b253d64a58dbb4.png', 'Sekretaris', '2024-07-12 01:23:54', '2025-06-23 17:19:17'),
(5, 'solihul Hadi', '0218374847', 'solihulhadi141213@gmail.com', 'a2cc01a152da09c1ad15b345e430ed7d', '', 'Admin', '2025-02-22 17:32:35', '2025-02-22 17:32:35');

-- --------------------------------------------------------

--
-- Table structure for table `akses_login`
--

DROP TABLE IF EXISTS `akses_login`;
CREATE TABLE IF NOT EXISTS `akses_login` (
  `id_akses` int NOT NULL,
  `kategori` varchar(10) NOT NULL COMMENT 'Anggota/Pengurus',
  `token` varchar(32) NOT NULL,
  `date_creat` datetime NOT NULL,
  `date_expired` datetime NOT NULL,
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_login`
--

INSERT INTO `akses_login` (`id_akses`, `kategori`, `token`, `date_creat`, `date_expired`) VALUES
(5, 'Pengurus', '6be034775796342467670d3eaf8351f2', '2025-02-25 06:14:01', '2025-02-25 08:13:08'),
(24, 'Anggota', 'b9ce962c31280745ded0ee9230fd0131', '2025-06-13 21:02:38', '2025-06-13 22:02:38'),
(6, 'Pengurus', 'b75ddeece5abe9587a92af7fbf42b7fb', '2025-06-21 17:56:47', '2025-06-21 19:03:50'),
(1, 'Pengurus', '8bf7c558b861d1942a3b6a5b0d2a8046', '2025-06-24 04:20:49', '2025-06-24 06:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` int NOT NULL AUTO_INCREMENT,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date DEFAULT NULL COMMENT 'hanya untuk anggota yang sudah keluar',
  `nip` varchar(32) NOT NULL COMMENT 'nomor induk anggota',
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Aktif, Keluar',
  `alasan_keluar` text COMMENT 'Diisi Hanya Apabila Keluar',
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `tanggal_masuk`, `tanggal_keluar`, `nip`, `nama`, `email`, `kontak`, `status`, `alasan_keluar`) VALUES
(1, '2024-01-13', '2024-07-14', '2024/07/Contoh-01', 'Adam Saputra', 'adamsaputra@example.com', '890000001', 'Aktif', ''),
(2, '2024-01-14', '2024-07-14', '2024/07/Contoh-02', 'Budi Santoso', 'budi.santoso@example.com', '890000002', 'Aktif', ''),
(3, '2024-01-15', '2024-07-14', '2024/07/Contoh-111', 'Citra Dewi', 'citra.dewi@example.com', '890000003', 'Aktif', ''),
(4, '2024-01-16', '2024-06-14', '2024/07/Contoh-04', 'Dian Rahmawati', 'dian.rahmawati@example.com', '890000004', 'Keluar', 'Tidak betah'),
(5, '2024-01-17', '2024-07-14', '2024/07/Contoh-05', 'Eka Prasetyo', 'eka.prasetyo@example.com', '890000005', 'Aktif', ''),
(6, '2024-01-18', '2024-07-14', '2024/07/Contoh-06', 'Farah Amalia', 'farah.amalia@example.com', '890000006', 'Aktif', ''),
(7, '2024-01-19', '2024-07-14', '2024/07/Contoh-07', 'Guntur Wibowo', 'guntur.wibowo@example.com', '890000007', 'Aktif', ''),
(8, '2024-01-20', '2024-06-14', '2024/07/Contoh-08', 'Hendra Wijaya', 'hendra.wijaya@example.com', '890000008', 'Keluar', ''),
(9, '2024-01-21', '2024-07-14', '2024/07/Contoh-09', 'Indah Permatasari', 'indah.permatasari@example.com', '890000009', 'Aktif', ''),
(10, '2024-01-22', '2024-07-14', '2024/07/Contoh-10', 'Joko Susanto', 'joko.susanto@example.com', '890000010', 'Aktif', ''),
(11, '2024-01-23', '2024-07-14', '2024/07/Contoh-11', 'Karina Putri', 'karina.putri@example.com', '890000011', 'Aktif', ''),
(12, '2024-01-24', '2024-07-14', '2024/07/Contoh-12', 'Leo Pradipta', 'leo.pradipta@example.com', '890000012', 'Aktif', ''),
(13, '2024-01-25', '2024-07-14', '2024/07/Contoh-13', 'Maya Sari', 'maya.sari@example.com', '890000013', 'Aktif', ''),
(14, '2024-01-26', '2024-07-14', '2024/07/Contoh-14', 'Nanda Kusuma', 'nanda.kusuma@example.com', '890000014', 'Aktif', ''),
(15, '2024-01-27', '2024-07-14', '2024/07/Contoh-15', 'Oki Pratama', 'oki.pratama@example.com', '890000015', 'Aktif', ''),
(16, '2024-01-28', '2024-07-14', '2024/07/Contoh-16', 'Putri Ayu', 'putri.ayu@example.com', '890000016', 'Aktif', ''),
(17, '2024-01-29', '2024-06-14', '2024/07/Contoh-17', 'Rizki Setiawan', 'rizki.setiawan@example.com', '890000017', 'Keluar', 'Tidak betah'),
(18, '2024-01-30', '2024-07-14', '2024/07/Contoh-18', 'Sinta Maharani', 'sinta.maharani@example.com', '890000018', 'Aktif', ''),
(19, '2024-01-31', '2024-07-14', '2024/07/Contoh-19', 'Tio Nugroho', 'tio.nugroho@example.com', '890000019', 'Aktif', ''),
(22, '2024-09-21', '2024-09-21', '123122221', 'Aruna Parasilva', 'windy1234@gmail.com', '08961767868', 'Aktif', ''),
(23, '2025-02-01', '2025-02-22', '1111111111111', 'Tri Heru', 'triheruafsheen@gmail.com', '085217731586', 'Aktif', ''),
(24, '2025-01-01', '2025-02-23', '2222222222', 'Sugito', 'gito@gmail.com', '0852323242421', 'Aktif', ''),
(25, '2024-02-01', '2025-02-23', '2024/07/Contoh-20', 'Ulya Handayani', 'ulya.handayani@example.com', '890000020', 'Aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `id_captcha` char(36) NOT NULL,
  `unique_code` char(5) NOT NULL,
  `timestamp_creat` timestamp NOT NULL,
  `timestamp_expired` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`id_captcha`, `unique_code`, `timestamp_creat`, `timestamp_expired`) VALUES
('MiKhFvv3sztsMjm9OySdpDVNXQHEPWuaXwqC', 'LM3L8', '2025-02-21 12:59:27', '2025-02-21 13:09:27'),
('wJxtT6mXTt4Xc9rAm8iQJzEGcpNzGkvVEfru', 'J7276', '2025-02-21 13:01:14', '2025-02-21 13:11:14'),
('NoAWxDL97kBeyDlZWS6tIBDgf1Tj1Vyatcpl', 'NN37S', '2025-02-21 13:03:15', '2025-02-21 13:13:15'),
('rwZX7jmDyt1aEYlNMl5Zj5xxQPFD9ap1fWzS', 'PGB83', '2025-02-21 13:03:23', '2025-02-21 13:13:23'),
('tcgZwOEOXcLzgerG7uipNg0cZ7nS9C42irjy', 'SBC5N', '2025-02-21 13:04:01', '2025-02-21 13:14:01'),
('mFnVK7CqpRoUYV9nWvFX2u4NHBWVJylZOWsm', 'KXTQA', '2025-02-21 13:04:20', '2025-02-21 13:14:20'),
('ofuNhBLY0tldSOS74ny5vl9zfDru3QX4h5af', '6GB5W', '2025-02-21 13:04:46', '2025-02-21 13:14:46'),
('ifQ5PBSlkxL3GcJhoXs5USENRl31OQpIN2O5', 'VW857', '2025-02-21 13:06:22', '2025-02-21 13:16:22'),
('9ZjCxrTISeOAEgwjbDICa8hox78BXZ9tuJ02', '5FRBZ', '2025-02-21 13:06:57', '2025-02-21 13:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
CREATE TABLE IF NOT EXISTS `help` (
  `id_help` int NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_update` datetime NOT NULL,
  `status` varchar(15) NOT NULL COMMENT 'Publish, Draft',
  PRIMARY KEY (`id_help`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id_help`, `author`, `judul`, `kategori`, `deskripsi`, `datetime_creat`, `datetime_update`, `status`) VALUES
(2, 'Solihul Hadi', 'Cara Mengirim Pengajuan Akses', 'Pengajuan Akses', '&lt;p&gt;Tahap awal yang harus dilakukan pertama kali untuk dapat menggunakan aplikasi adalah mengirimkan permohonan akses.&lt;/p&gt;', '2024-08-09 05:07:14', '2024-08-10 01:09:35', 'Publish'),
(3, 'Solihul Hadi', 'Melakukan Login', 'Akses', '&lt;p&gt;Untuk melakukan login, ikuti tahapan berikut ini&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;assets/img/Help/43ac4062b48a1b8e.png&quot; alt=&quot;&quot; width=&quot;389&quot; height=&quot;409&quot; /&gt;&lt;/p&gt;', '2024-08-09 05:16:33', '2024-08-10 01:09:28', 'Publish'),
(4, 'Solihul Hadi', 'Mengubah Password', 'Akses', '&lt;p&gt;Berikut ini adalah langkah-langkah untuk merubah password&lt;/p&gt;\n&lt;ol&gt;\n&lt;li&gt;Login pada akun anda seperti biasa&lt;/li&gt;\n&lt;li&gt;Pada bagian menu kanan atas (profil pengguna) pilih profil saya.&lt;/li&gt;\n&lt;li&gt;Pilih sub menu ubah password&lt;/li&gt;\n&lt;li&gt;Masukan password baru anda pada form yang disediakan&lt;/li&gt;\n&lt;li&gt;Simpan perubahan dan sistem akan menampilkan notifikasi berhasil.&lt;/li&gt;\n&lt;/ol&gt;', '2024-08-10 00:58:00', '2024-08-12 02:12:30', 'Publish'),
(6, 'Solihul Hadi', 'Tentang Koperasi', 'Materi Umum', '<p>Koperasi adalah badan usaha yang beranggotakan orang-orang atau badan hukum koperasi, yang kegiatannya didasarkan pada prinsip-prinsip koperasi dan asas kekeluargaan. Secara sederhana, koperasi adalah perkumpulan yang anggotanya bekerja sama untuk memenuhi kebutuhan ekonomi, sosial, dan budaya mereka melalui usaha yang dimiliki dan dikelola bersama.</p>\r\n<p><strong>1. Ciri-ciri Koperasi</strong></p>\r\n<ul>\r\n<li><strong>Bekerja Sama: </strong>Anggota koperasi bekerja sama untuk mencapai tujuan bersama.</li>\r\n<li><strong>Otonom:</strong> Koperasi memiliki kebebasan untuk menjalankan kegiatan usahanya.</li>\r\n<li><strong>Sukarela:</strong> Keanggotaan dalam koperasi bersifat sukarela.</li>\r\n<li><strong>Demokratis:</strong> Pengelolaan koperasi dilakukan secara demokratis.</li>\r\n<li><strong>Asas Kekeluargaan: </strong>Koperasi didasarkan pada asas kekeluargaan</li>\r\n</ul>\r\n<p><strong>2. Prinsip Koperasi</strong></p>\r\n<p>Prinsip-prinsip koperasi meliputi keanggotaan yang sukarela dan terbuka, pengelolaan secara demokratis, pembagian Sisa Hasil Usaha (SHU) secara adil, pemberian balas jasa terbatas terhadap modal, kemandirian, pendidikan perkoperasian, dan kerjasama antar koperasi.</p>\r\n<p><strong>3. Tujuan Koperasi</strong></p>\r\n<p>Tujuan koperasi secara umum adalah untuk meningkatkan kesejahteraan anggotanya dan masyarakat secara luas melalui kegiatan ekonomi yang berdasarkan prinsip-prinsip koperasi. Berikut ini adalah penjelasan beberapa tujuan koperasi:</p>\r\n<ul>\r\n<li>Meningkatkan kesejahteraan anggota.&nbsp;</li>\r\n<li>Meningkatkan Taraf hidup masyarakat</li>\r\n<li>Mengembangkan Kegiatan Ekonomi</li>\r\n<li>Mendorong Sikap Gotong Royong Dan Solidaritas</li>\r\n<li>Menghindari Eksploitasi Ekonomi</li>\r\n<li>Meningkatkan Pendidikan Ekonomi Anggota</li>\r\n</ul>', '2025-05-09 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `datetime_log` varchar(25) NOT NULL,
  `kategori_log` varchar(20) NOT NULL,
  `deskripsi_log` text NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_akses` (`id_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=629 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `id_akses`, `datetime_log`, `kategori_log`, `deskripsi_log`) VALUES
(1, 1, '2024-06-01 19:21:10', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(2, 1, '2024-06-13 21:20:42', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(3, 1, '2024-06-13 21:21:34', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(4, 1, '2024-06-13 21:46:55', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(5, 1, '2024-06-13 21:53:50', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(6, 1, '2024-06-13 22:28:35', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(7, 1, '2024-06-13 22:35:14', 'Akses', 'Edit Akses Berhasil'),
(8, 1, '2024-06-13 22:35:14', 'Akses', 'Edit Akses Berhasil'),
(9, 1, '2024-06-13 22:35:14', 'Akses', 'Edit Akses Berhasil'),
(10, 1, '2024-06-29 18:54:30', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(11, 1, '2024-06-30 16:50:42', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(12, 1, '2024-06-30 17:44:04', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(13, 1, '2024-07-01 01:31:38', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(14, 1, '2024-07-01 22:39:03', 'Login', 'dhiforester@gmail.com Berhasil Melakukan Login'),
(15, 1, '2024-07-02 02:08:01', 'Akses', 'Input Fitur Akses'),
(16, 1, '2024-07-02 02:12:15', 'Akses', 'Input Fitur Akses'),
(17, 1, '2024-07-02 02:13:50', 'Akses', 'Input Fitur Akses'),
(18, 1, '2024-07-02 02:14:53', 'Akses', 'Input Fitur Akses'),
(19, 1, '2024-07-02 02:15:52', 'Akses', 'Input Fitur Akses'),
(20, 1, '2024-07-02 02:17:24', 'Akses', 'Input Fitur Akses'),
(21, 1, '2024-07-02 02:22:29', 'Fitur Akses', 'Edit Fitur Akses'),
(22, 1, '2024-07-02 02:22:38', 'Fitur Akses', 'Edit Fitur Akses'),
(23, 1, '2024-07-02 02:55:36', 'Fitur Akses', 'Hapus Fitur Akses'),
(24, 1, '2024-07-02 02:56:05', 'Fitur Akses', 'Edit Fitur Akses'),
(25, 1, '2024-07-02 04:58:00', 'Entitas Akses', 'Input Entitas Akses'),
(26, 1, '2024-07-02 04:58:43', 'Entitas Akses', 'Input Entitas Akses'),
(27, 1, '2024-07-11 00:58:11', 'Entitas Akses', 'Edit Entitas Akses'),
(28, 1, '2024-07-11 01:00:03', 'Entitas Akses', 'Edit Entitas Akses'),
(29, 1, '2024-07-11 01:00:25', 'Entitas Akses', 'Input Entitas Akses'),
(30, 1, '2024-07-11 01:01:17', 'Entitas Akses', 'Edit Entitas Akses'),
(31, 1, '2024-07-11 01:01:48', 'Entitas Akses', 'Edit Entitas Akses'),
(32, 1, '2024-07-11 01:02:00', 'Entitas Akses', 'Edit Entitas Akses'),
(33, 1, '2024-07-11 01:02:21', 'Entitas Akses', 'Edit Entitas Akses'),
(34, 1, '2024-07-11 01:11:59', 'Entitas Akses', 'Hapus Entitas Akses'),
(35, 1, '2024-07-11 01:12:07', 'Entitas Akses', 'Hapus Entitas Akses'),
(36, 1, '2024-07-13 22:10:59', 'Angggota', 'Tambah Anggota baru'),
(37, 1, '2024-07-13 22:35:30', 'Angggota', 'Tambah Anggota baru'),
(38, 1, '2024-07-14 00:08:12', 'Angggota', 'Edit Anggota Berhasil'),
(39, 1, '2024-07-14 00:53:35', 'Angggota', 'Ubah Foto Anggota'),
(40, 1, '2024-07-14 01:01:58', 'Angggota', 'Ubah Foto Anggota'),
(41, 1, '2024-07-14 01:45:28', 'Angggota', 'Hapus Anggota'),
(42, 1, '2024-07-14 01:46:16', 'Angggota', 'Hapus Anggota'),
(43, 1, '2024-07-14 01:47:26', 'Angggota', 'Hapus Anggota'),
(44, 1, '2024-07-14 01:53:25', 'Angggota', 'Tambah Anggota baru'),
(45, 1, '2024-07-14 01:54:47', 'Angggota', 'Tambah Anggota baru'),
(46, 1, '2024-07-14 04:14:12', 'Angggota', 'Tambah Anggota baru'),
(47, 1, '2024-07-14 04:25:14', 'Angggota', 'Edit Anggota Berhasil'),
(48, 1, '2024-07-14 04:25:32', 'Angggota', 'Edit Anggota Berhasil'),
(49, 1, '2024-07-14 04:34:09', 'Angggota', 'Ubah Foto Anggota'),
(50, 1, '2024-07-15 23:06:10', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(51, 1, '2024-07-15 23:15:01', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(52, 1, '2024-07-15 23:29:44', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(53, 1, '2024-07-15 23:50:03', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(54, 1, '2024-07-15 23:50:11', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(55, 1, '2024-07-16 00:03:29', 'Jenis Simpanan', 'Hapus Jenis Simpanan'),
(56, 1, '2024-07-16 00:04:06', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(57, 1, '2024-07-16 00:04:28', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(58, 1, '2024-07-16 00:45:45', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(59, 1, '2024-07-16 03:01:59', 'Jenis Simpanan', 'Tambah Jenis Simpanan'),
(60, 1, '2024-07-16 03:06:58', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(61, 1, '2024-07-16 03:07:08', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(62, 1, '2024-07-16 03:34:19', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(63, 1, '2024-07-16 03:34:44', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(64, 1, '2024-07-16 04:18:02', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(65, 1, '2024-07-16 04:18:58', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(66, 1, '2024-07-16 04:19:02', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(67, 1, '2024-07-16 04:19:21', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(68, 1, '2024-07-16 05:28:15', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(69, 1, '2024-07-16 05:28:36', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(70, 1, '2024-07-18 15:05:22', 'Simpanan Wajib', 'Edit Simpanan Wajib'),
(71, 1, '2024-07-18 15:05:30', 'Simpanan Wajib', 'Edit Simpanan Wajib'),
(72, 1, '2024-07-18 17:15:09', 'Simpanan Wajib', 'Hapus Simpanan Wajib'),
(73, 1, '2024-07-19 01:22:40', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(74, 1, '2024-07-19 01:22:48', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(75, 1, '2024-07-19 01:23:50', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(76, 1, '2024-07-21 01:06:28', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(77, 1, '2024-07-21 01:10:51', 'Log Simpanan', 'Tambah Simpanan'),
(78, 1, '2024-07-21 01:11:42', 'Log Simpanan', 'Tambah Simpanan'),
(79, 1, '2024-07-21 01:30:27', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(80, 1, '2024-07-21 01:33:57', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(81, 1, '2024-07-21 01:34:41', 'Log Simpanan', 'Tambah Simpanan'),
(82, 1, '2024-07-21 01:46:40', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(83, 1, '2024-07-21 01:47:32', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(84, 1, '2024-07-21 02:38:25', 'Log Simpanan', 'Tambah Simpanan'),
(85, 1, '2024-07-21 02:39:10', 'Angggota', 'Edit Anggota Berhasil'),
(86, 1, '2024-07-21 19:08:07', 'Log Simpanan', 'Edit Simpanan'),
(87, 1, '2024-07-21 19:13:46', 'Log Simpanan', 'Edit Simpanan'),
(88, 1, '2024-07-21 19:14:14', 'Log Simpanan', 'Edit Simpanan'),
(89, 1, '2024-07-21 22:13:46', 'Angggota', 'Hapus Anggota'),
(90, 1, '2024-07-21 22:22:55', 'Log Simpanan', 'Hapus Simpanan'),
(91, 1, '2024-07-21 22:23:21', 'Log Simpanan', 'Hapus Simpanan'),
(92, 1, '2024-07-21 22:44:25', 'Log Simpanan', 'Tambah Simpanan'),
(93, 1, '2024-07-21 22:48:36', 'Log Simpanan', 'Tambah Simpanan'),
(94, 1, '2024-07-21 22:48:46', 'Log Simpanan', 'Tambah Simpanan'),
(95, 1, '2024-07-21 22:49:31', 'Log Simpanan', 'Tambah Simpanan'),
(96, 1, '2024-07-21 22:49:50', 'Log Simpanan', 'Tambah Simpanan'),
(97, 1, '2024-07-21 22:51:07', 'Log Simpanan', 'Tambah Simpanan'),
(98, 1, '2024-07-21 22:53:48', 'Log Simpanan', 'Tambah Simpanan'),
(99, 1, '2024-07-21 23:04:05', 'Log Simpanan', 'Tambah Simpanan'),
(100, 1, '2024-07-21 23:04:24', 'Log Simpanan', 'Edit Simpanan'),
(101, 1, '2024-07-21 23:05:23', 'Log Simpanan', 'Hapus Simpanan'),
(102, 1, '2024-07-21 23:06:10', 'Log Simpanan', 'Tambah Simpanan'),
(103, 1, '2024-07-21 23:06:19', 'Log Simpanan', 'Edit Simpanan'),
(104, 1, '2024-07-21 23:06:52', 'Log Simpanan', 'Hapus Simpanan'),
(105, 1, '2024-07-21 23:07:05', 'Log Simpanan', 'Tambah Simpanan'),
(106, 1, '2024-07-21 23:07:39', 'Log Simpanan', 'Edit Simpanan'),
(107, 1, '2024-07-21 23:16:24', 'Log Simpanan', 'Edit Simpanan'),
(108, 1, '2024-07-21 23:47:32', 'Log Simpanan', 'Tambah Simpanan'),
(109, 1, '2024-07-22 00:24:57', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(110, 1, '2024-07-22 00:26:45', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(111, 1, '2024-07-22 00:27:15', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(112, 1, '2024-07-22 00:28:39', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(113, 1, '2024-07-22 00:32:50', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(114, 1, '2024-07-22 00:33:10', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(115, 1, '2024-07-22 00:33:25', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(116, 1, '2024-07-22 00:33:52', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(117, 1, '2024-07-22 00:46:26', 'Simpanan Wajib', 'Hapus Simpanan Wajib'),
(118, 1, '2024-07-22 00:51:38', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(119, 1, '2024-07-22 00:53:56', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(120, 1, '2024-07-22 01:00:54', 'Simpanan Wajib', 'Edit Simpanan Wajib'),
(121, 1, '2024-07-22 01:01:15', 'Simpanan Wajib', 'Edit Simpanan Wajib'),
(122, 1, '2024-07-22 01:24:41', 'Log Simpanan', 'Tambah Simpanan'),
(123, 1, '2024-07-22 01:33:23', 'Log Simpanan', 'Edit Simpanan'),
(124, 1, '2024-07-23 03:37:02', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(125, 1, '2024-07-23 03:40:24', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(126, 1, '2024-07-23 03:59:25', 'Angggota', 'Tambah Anggota baru'),
(127, 1, '2024-07-23 05:02:56', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(128, 1, '2024-07-23 05:35:38', 'Pinjaman', 'Hapus Data Pinjaman'),
(129, 1, '2024-07-23 05:35:45', 'Pinjaman', 'Hapus Data Pinjaman'),
(130, 1, '2024-07-23 21:54:55', 'Pinjaman', 'Edit Pinjaman Berhasil    '),
(131, 1, '2024-07-23 21:55:22', 'Pinjaman', 'Edit Pinjaman Berhasil    '),
(132, 1, '2024-07-24 00:56:27', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(133, 1, '2024-07-24 01:00:22', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(134, 1, '2024-07-24 01:05:10', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(135, 1, '2024-07-24 02:30:08', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(136, 1, '2024-07-24 04:12:20', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(137, 1, '2024-07-24 04:29:25', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(138, 1, '2024-07-24 04:30:45', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(139, 1, '2024-07-24 04:30:50', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(140, 1, '2024-07-24 04:30:55', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(141, 1, '2024-07-24 04:31:30', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(142, 1, '2024-07-24 04:32:36', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(143, 1, '2024-07-25 02:12:58', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(144, 1, '2024-07-25 03:53:29', 'Angsuran', 'Hapus Angsuran Berhasil'),
(145, 1, '2024-07-25 03:53:33', 'Angsuran', 'Hapus Angsuran Berhasil'),
(146, 1, '2024-07-25 03:53:42', 'Angsuran', 'Hapus Angsuran Berhasil'),
(147, 1, '2024-07-26 00:28:41', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(148, 1, '2024-07-26 00:28:44', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(149, 1, '2024-07-26 00:28:58', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(150, 1, '2024-07-26 00:29:01', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(151, 1, '2024-07-26 00:29:05', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(152, 1, '2024-07-26 00:30:17', 'Angsuran', 'Hapus Angsuran Berhasil'),
(153, 1, '2024-07-26 00:30:20', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(154, 1, '2024-07-26 00:30:34', 'Angsuran', 'Hapus Angsuran Berhasil'),
(155, 1, '2024-07-26 00:30:38', 'Angsuran', 'Hapus Angsuran Berhasil'),
(156, 1, '2024-07-26 00:31:03', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(157, 1, '2024-07-26 00:31:08', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(158, 1, '2024-07-26 00:32:00', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(159, 1, '2024-07-26 00:32:03', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(160, 1, '2024-07-26 00:32:05', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(161, 1, '2024-07-26 00:32:08', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(162, 1, '2024-07-26 00:32:10', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(163, 1, '2024-07-26 00:32:13', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(164, 1, '2024-07-26 00:32:16', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(165, 1, '2024-07-26 00:32:20', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(166, 1, '2024-07-26 00:32:22', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(167, 1, '2024-07-26 00:32:25', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(168, 1, '2024-07-26 02:20:00', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(169, 1, '2024-07-26 02:22:26', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(170, 1, '2024-07-26 02:23:24', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(171, 1, '2024-07-26 02:23:59', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(172, 1, '2024-07-26 02:26:25', 'Angsuran', 'Hapus Angsuran Berhasil'),
(173, 1, '2024-07-26 02:26:29', 'Angsuran', 'Hapus Angsuran Berhasil'),
(174, 1, '2024-07-26 02:26:32', 'Angsuran', 'Hapus Angsuran Berhasil'),
(175, 1, '2024-07-26 02:26:42', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(176, 1, '2024-07-26 02:28:50', 'Angsuran', 'Hapus Angsuran Berhasil'),
(177, 1, '2024-07-26 02:29:37', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(178, 1, '2024-07-26 03:04:20', 'Angsuran', 'Hapus Angsuran Berhasil'),
(179, 1, '2024-07-26 03:05:17', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(180, 1, '2024-07-26 03:15:47', 'Pinjaman', 'Tambah Jurnal Pinjaman Berhasil'),
(181, 1, '2024-07-26 03:16:24', 'Pinjaman', 'Tambah Jurnal Pinjaman Berhasil'),
(182, 1, '2024-07-26 03:40:36', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(183, 1, '2024-07-26 03:40:45', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(184, 1, '2024-07-26 03:45:43', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(185, 1, '2024-07-26 03:45:57', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(186, 1, '2024-07-26 03:46:05', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(187, 1, '2024-07-26 04:16:20', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(188, 1, '2024-07-26 04:16:38', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(189, 1, '2024-07-26 05:25:18', 'Angsuran', 'Hapus Angsuran Berhasil'),
(190, 1, '2024-07-26 05:25:22', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(191, 1, '2024-07-26 23:06:24', 'Angsuran', 'Tambah Jurnal Angsuran Berhasil'),
(192, 1, '2024-07-26 23:53:16', 'Angsuran', 'Edit Jurnal Angsuran Berhasil'),
(193, 1, '2024-07-26 23:53:26', 'Angsuran', 'Edit Jurnal Angsuran Berhasil'),
(194, 1, '2024-07-26 23:53:33', 'Angsuran', 'Edit Jurnal Angsuran Berhasil'),
(195, 1, '2024-07-27 00:00:18', 'Angsuran', 'Edit Jurnal Angsuran Berhasil'),
(196, 1, '2024-07-27 00:00:22', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(197, 1, '2024-07-27 00:03:25', 'Angsuran', 'Hapus Angsuran Berhasil'),
(198, 1, '2024-07-27 01:32:00', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(199, 1, '2024-07-27 01:46:19', 'Akses', 'Input Fitur Akses'),
(200, 1, '2024-07-27 04:09:02', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(201, 1, '2024-07-27 04:09:33', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(202, 1, '2024-07-28 23:14:39', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(203, 1, '2024-07-29 00:06:15', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(204, 1, '2024-07-29 00:07:05', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(205, 1, '2024-07-29 01:17:12', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(206, 1, '2024-07-29 01:17:20', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(207, 1, '2024-07-29 01:17:30', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(208, 1, '2024-07-29 01:17:49', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(209, 1, '2024-07-29 01:18:06', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(210, 1, '2024-07-29 01:18:17', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(211, 1, '2024-07-29 01:58:03', 'Akun Perkiraan', 'Hapus Akun Perkiraan'),
(212, 1, '2024-07-29 01:58:19', 'Akun Perkiraan', 'Hapus Akun Perkiraan'),
(213, 1, '2024-07-29 01:58:26', 'Akun Perkiraan', 'Hapus Akun Perkiraan'),
(214, 1, '2024-07-29 03:43:18', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(215, 1, '2024-07-29 03:43:27', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(216, 1, '2024-07-29 03:43:50', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(217, 1, '2024-07-29 03:53:41', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(218, 1, '2024-07-29 03:55:21', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(219, 1, '2024-07-29 03:58:47', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(220, 1, '2024-08-10 19:25:54', 'Jenis Transaksi', 'Tambah Jenis Transaksi'),
(221, 1, '2024-08-10 19:34:47', 'Jenis Transaksi', 'Tambah Jenis Transaksi'),
(222, 1, '2024-08-10 19:35:31', 'Jenis Transaksi', 'Tambah Jenis Transaksi'),
(223, 1, '2024-08-10 20:21:35', 'Jenis Transaksi', 'Edit Jenis Transaksi'),
(224, 1, '2024-08-10 20:22:00', 'Jenis Transaksi', 'Edit Jenis Transaksi'),
(225, 1, '2024-08-10 20:29:31', 'Jenis Transaksi', 'Tambah Jenis Transaksi'),
(226, 1, '2024-08-10 20:29:36', 'Jenis Transaksi', 'Hapus Jenis Transaksi'),
(227, 1, '2024-08-11 02:28:52', 'Transaksi', 'Hapus Transaksi'),
(228, 1, '2024-08-11 04:47:51', 'Transaksi', 'Tambah Jurnal Transaksi'),
(229, 1, '2024-08-11 05:16:18', 'Transaksi', 'Update Jurnal Transaksi'),
(230, 1, '2024-08-11 05:16:25', 'Transaksi', 'Update Jurnal Transaksi'),
(231, 1, '2024-08-11 05:16:51', 'Transaksi', 'Update Jurnal Transaksi'),
(232, 1, '2024-08-11 05:33:58', 'Transaksi', 'Hapus Jurnal'),
(233, 1, '2024-08-12 01:52:59', 'Akses', 'Input Fitur Akses'),
(234, 1, '2024-08-12 01:53:08', 'Entitas Akses', 'Edit Entitas Akses'),
(235, 1, '2024-08-12 01:58:44', 'Akses', 'Input Fitur Akses'),
(236, 1, '2024-08-12 01:59:34', 'Akses', 'Input Fitur Akses'),
(237, 1, '2024-08-12 01:59:45', 'Entitas Akses', 'Edit Entitas Akses'),
(238, 1, '2024-08-12 02:10:26', 'Bantuan', 'Edit Konten Bantuan'),
(239, 1, '2024-08-12 02:12:30', 'Bantuan', 'Edit Konten Bantuan'),
(240, 1, '2024-08-12 02:24:22', 'Bantuan', 'Tambah Konten Bantuan'),
(241, 1, '2024-08-12 02:24:46', 'Bantuan', 'Edit Konten Bantuan'),
(242, 1, '2024-08-12 03:06:54', 'Akses', 'Input Fitur Akses'),
(243, 1, '2024-08-12 03:07:10', 'Entitas Akses', 'Edit Entitas Akses'),
(244, 1, '2024-08-12 03:18:10', 'Akses', 'Input Fitur Akses'),
(245, 1, '2024-08-12 03:18:22', 'Entitas Akses', 'Edit Entitas Akses'),
(246, 1, '2024-09-19 22:09:35', 'Log Simpanan', 'Edit Simpanan'),
(247, 1, '2024-09-19 22:09:45', 'Log Simpanan', 'Edit Simpanan'),
(248, 1, '2024-09-19 22:10:08', 'Log Simpanan', 'Edit Simpanan'),
(249, 1, '2024-09-19 22:10:13', 'Log Simpanan', 'Edit Simpanan'),
(250, 1, '2024-09-19 22:39:45', 'Simpanan', 'Tambah Jurnal Simpanan Berhasil'),
(251, 1, '2024-09-19 22:40:47', 'Simpanan', 'Tambah Jurnal Simpanan Berhasil'),
(252, 1, '2024-09-19 23:02:43', 'Simpanan', 'Edit Jurnal Simpanan Berhasil'),
(253, 1, '2024-09-19 23:03:09', 'Simpanan', 'Edit Jurnal Simpanan Berhasil'),
(254, 1, '2024-09-19 23:28:36', 'Simpanan', 'Hapus Jurnal Simpanan Berhhasil'),
(255, 1, '2024-09-19 23:29:09', 'Simpanan', 'Hapus Jurnal Simpanan Berhhasil'),
(256, 1, '2024-09-19 23:29:19', 'Simpanan', 'Edit Jurnal Simpanan Berhasil'),
(257, 1, '2024-09-20 01:46:24', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(258, 1, '2024-09-20 02:09:56', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(259, 1, '2024-09-20 02:18:54', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(260, 1, '2024-09-20 02:21:31', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(261, 1, '2024-09-20 02:22:36', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(262, 1, '2024-09-20 02:57:08', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(263, 1, '2024-09-20 04:47:38', 'Bagi Hasil', 'Edit Sesi Bagi Hasil Berhasil'),
(264, 1, '2024-09-20 04:48:12', 'Bagi Hasil', 'Edit Sesi Bagi Hasil Berhasil'),
(265, 1, '2024-09-20 04:48:18', 'Bagi Hasil', 'Edit Sesi Bagi Hasil Berhasil'),
(266, 1, '2024-09-20 04:48:33', 'Bagi Hasil', 'Edit Sesi Bagi Hasil Berhasil'),
(267, 1, '2024-09-20 05:07:57', 'Bagi Hasil', 'Hapus Bagi Hasil Berhasil'),
(268, 1, '2024-09-20 05:08:05', 'Bagi Hasil', 'Hapus Bagi Hasil Berhasil'),
(269, 1, '2024-09-20 05:09:28', 'Bagi Hasil', 'Tambah Sesi Bagi Hasil Berhasil'),
(270, 1, '2024-09-20 05:14:05', 'Angggota', 'Edit Anggota Berhasil'),
(271, 1, '2024-09-20 19:11:02', 'Bagi Hasil', 'Tambah Jurnal Bagi Hasil Berhasil'),
(272, 1, '2024-09-20 19:15:16', 'Akun Perkiraan', 'Hapus Akun Perkiraan'),
(273, 1, '2024-09-20 19:15:20', 'Akun Perkiraan', 'Hapus Akun Perkiraan'),
(274, 1, '2024-09-20 19:15:35', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(275, 1, '2024-09-20 19:15:45', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(276, 1, '2024-09-20 19:28:40', 'Bagi Hasil', 'Edit Jurnal Bagi Hasil Berhasil'),
(277, 1, '2024-09-20 19:28:57', 'Bagi Hasil', 'Tambah Jurnal Bagi Hasil Berhasil'),
(278, 1, '2024-09-20 19:31:57', 'Bagi Hasil', 'Hapus Jurnal Berhasil'),
(279, 1, '2024-09-20 19:32:05', 'Bagi Hasil', 'Hapus Jurnal Berhasil'),
(280, 1, '2024-09-20 19:34:36', 'Bagi Hasil', 'Edit Jurnal Bagi Hasil Berhasil'),
(281, 1, '2024-09-20 19:34:40', 'Bagi Hasil', 'Hapus Jurnal Berhasil'),
(282, 1, '2024-09-20 19:34:52', 'Bagi Hasil', 'Tambah Jurnal Bagi Hasil Berhasil'),
(283, 1, '2024-09-20 19:35:06', 'Bagi Hasil', 'Tambah Jurnal Bagi Hasil Berhasil'),
(284, 1, '2024-09-20 19:35:11', 'Bagi Hasil', 'Edit Jurnal Bagi Hasil Berhasil'),
(285, 1, '2024-09-20 19:35:16', 'Bagi Hasil', 'Edit Jurnal Bagi Hasil Berhasil'),
(286, 1, '2024-09-20 19:43:03', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(287, 1, '2024-09-20 19:43:24', 'Akun Perkiraan', 'Edit Akun Perkiraan'),
(288, 1, '2024-09-20 20:46:05', 'Jurnal', 'Tambah Jurnal Berhasil'),
(289, 1, '2024-09-20 20:51:03', 'Jurnal', 'Tambah Jurnal Berhasil'),
(290, 1, '2024-09-20 20:51:52', 'Jurnal', 'Tambah Jurnal Berhasil'),
(291, 1, '2024-09-20 20:57:04', 'Jurnal', 'Tambah Jurnal Berhasil'),
(292, 1, '2024-09-20 20:57:32', 'Jurnal', 'Tambah Jurnal Berhasil'),
(293, 1, '2024-09-20 21:03:27', 'Jurnal', 'Tambah Jurnal Berhasil'),
(294, 1, '2024-09-20 21:36:41', 'Jurnal', 'Edit Jurnal Berhasil'),
(295, 1, '2024-09-20 21:36:54', 'Jurnal', 'Edit Jurnal Berhasil'),
(296, 1, '2024-09-20 21:37:16', 'Jurnal', 'Edit Jurnal Berhasil'),
(297, 1, '2024-09-20 21:51:54', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(298, 1, '2024-09-20 21:52:09', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(299, 1, '2024-09-20 21:52:17', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(300, 1, '2024-09-20 21:52:21', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(301, 1, '2024-09-20 23:01:32', 'Auto Jurnal', 'Update Auto Jurnal'),
(302, 1, '2024-09-20 23:02:37', 'Auto Jurnal', 'Update Auto Jurnal'),
(303, 1, '2024-09-20 23:44:29', 'Jurnal', 'Tambah Jurnal Berhasil'),
(304, 1, '2024-09-20 23:45:33', 'Jurnal', 'Tambah Jurnal Berhasil'),
(305, 1, '2024-09-20 23:45:44', 'Jurnal', 'Hapus Jurnal Berhhasil'),
(306, 1, '2024-09-20 23:46:17', 'Jurnal', 'Tambah Jurnal Berhasil'),
(307, 1, '2024-09-20 23:46:41', 'Jurnal', 'Tambah Jurnal Berhasil'),
(308, 1, '2024-09-21 01:51:33', 'Log Simpanan', 'Tambah Simpanan'),
(309, 1, '2024-09-21 01:54:03', 'Log Simpanan', 'Edit Simpanan'),
(310, 1, '2024-09-21 01:54:28', 'Log Simpanan', 'Tambah Simpanan'),
(311, 1, '2024-09-21 02:25:45', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(312, 1, '2024-09-21 02:25:48', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(313, 1, '2024-09-21 02:25:51', 'Angsuran', 'Tambah Angsuran Berhasil    '),
(314, 1, '2024-09-21 02:59:41', 'Akses', 'Input Fitur Akses'),
(315, 1, '2024-09-21 03:05:59', 'Entitas Akses', 'Edit Entitas Akses'),
(316, 1, '2024-09-21 04:41:33', 'Akses', 'Input Fitur Akses'),
(317, 1, '2024-09-21 04:41:58', 'Entitas Akses', 'Edit Entitas Akses'),
(318, 1, '2024-09-21 04:55:29', 'Entitas Akses', 'Edit Entitas Akses'),
(319, 1, '2024-09-21 04:55:46', 'Entitas Akses', 'Edit Entitas Akses'),
(320, 1, '2024-09-21 04:57:22', 'Akses', 'Input Fitur Akses'),
(321, 1, '2024-09-21 04:57:42', 'Entitas Akses', 'Edit Entitas Akses'),
(322, 1, '2024-09-21 04:59:30', 'Akses', 'Input Fitur Akses'),
(323, 1, '2024-09-21 04:59:52', 'Entitas Akses', 'Edit Entitas Akses'),
(324, 1, '2024-09-21 05:03:01', 'Akses', 'Input Fitur Akses'),
(325, 1, '2024-09-21 05:05:17', 'Akses', 'Input Fitur Akses'),
(326, 1, '2024-09-21 05:05:42', 'Akses', 'Input Fitur Akses'),
(327, 1, '2024-09-21 05:08:54', 'Entitas Akses', 'Edit Entitas Akses'),
(328, 1, '2024-09-21 05:16:16', 'Akses', 'Input Fitur Akses'),
(329, 1, '2024-09-21 05:18:10', 'Entitas Akses', 'Edit Entitas Akses'),
(330, 1, '2024-09-21 05:24:37', 'Akses', 'Input Fitur Akses'),
(331, 1, '2024-09-21 05:25:00', 'Akses', 'Input Fitur Akses'),
(332, 1, '2024-09-21 05:25:17', 'Akses', 'Input Fitur Akses'),
(333, 1, '2024-09-21 05:32:31', 'Akses', 'Input Fitur Akses'),
(334, 1, '2024-09-21 05:33:41', 'Akses', 'Input Fitur Akses'),
(335, 1, '2024-09-21 05:34:05', 'Fitur Akses', 'Hapus Fitur Akses'),
(336, 1, '2024-09-21 05:34:16', 'Fitur Akses', 'Edit Fitur Akses'),
(337, 1, '2024-09-21 05:37:33', 'Entitas Akses', 'Edit Entitas Akses'),
(338, 1, '2024-09-21 05:38:34', 'Fitur Akses', 'Edit Fitur Akses'),
(339, 1, '2024-09-21 05:39:50', 'Fitur Akses', 'Edit Fitur Akses'),
(340, 1, '2024-09-21 05:39:58', 'Fitur Akses', 'Edit Fitur Akses'),
(341, 1, '2024-09-21 05:40:20', 'Fitur Akses', 'Edit Fitur Akses'),
(342, 1, '2024-09-21 05:43:20', 'Fitur Akses', 'Edit Fitur Akses'),
(343, 1, '2024-09-21 05:43:27', 'Fitur Akses', 'Edit Fitur Akses'),
(344, 1, '2024-09-21 05:43:36', 'Fitur Akses', 'Edit Fitur Akses'),
(345, 1, '2024-09-21 05:43:42', 'Fitur Akses', 'Edit Fitur Akses'),
(346, 1, '2024-09-21 05:44:23', 'Akses', 'Input Fitur Akses'),
(347, 1, '2024-09-21 05:44:42', 'Akses', 'Input Fitur Akses'),
(348, 1, '2024-09-21 05:49:01', 'Entitas Akses', 'Edit Entitas Akses'),
(349, 1, '2024-09-21 05:55:23', 'Setting', 'Setting Email'),
(350, 1, '2024-09-21 17:28:48', 'Angggota', 'Tambah Anggota baru'),
(351, 1, '2024-09-27 13:52:15', 'Auto Jurnal', 'Update Auto Jurnal'),
(352, 1, '2024-09-27 21:07:02', 'Akses', 'Input Fitur Akses'),
(353, 1, '2024-09-27 21:07:18', 'Entitas Akses', 'Edit Entitas Akses'),
(354, 1, '2024-09-27 23:50:16', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(355, 1, '2024-09-27 23:50:26', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(356, 1, '2024-09-27 23:50:38', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(357, 1, '2024-09-28 05:19:20', 'Auto Jurnal', 'Update Auto Jurnal'),
(358, 1, '2024-09-28 08:08:43', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(359, 1, '2024-10-09 18:51:33', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(360, 1, '2024-10-09 18:52:15', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(361, 1, '2024-10-09 18:53:20', 'Auto Jurnal', 'Update Auto Jurnal'),
(362, 1, '2024-10-09 18:53:43', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(363, 1, '2024-10-09 18:54:19', 'Pinjaman', 'Edit Jurnal Pinjaman Berhasil'),
(364, 1, '2024-10-09 18:56:01', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(365, 1, '2024-10-09 18:56:12', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(366, 1, '2024-10-09 18:56:25', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(367, 1, '2024-10-09 18:56:32', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(368, 1, '2024-10-09 18:56:39', 'Jenis Simpanan', 'Edit Jenis Simpanan'),
(369, 1, '2024-10-09 18:56:52', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(370, 1, '2024-10-09 18:58:31', 'Jurnal', 'Edit Jurnal Berhasil'),
(371, 1, '2024-10-09 18:58:46', 'Jurnal', 'Edit Jurnal Berhasil'),
(372, 1, '2024-10-09 19:15:03', 'Akses', 'Input Fitur Akses'),
(373, 1, '2024-10-09 19:15:15', 'Entitas Akses', 'Edit Entitas Akses'),
(374, 1, '2025-01-16 21:25:14', 'Angggota', 'Hapus Anggota'),
(375, 1, '2025-02-21 01:42:26', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(376, 1, '2025-02-21 01:43:08', 'Simpanan Wajib', 'Hapus Simpanan Wajib'),
(377, 1, '2025-02-21 01:43:49', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(378, 1, '2025-02-21 01:50:44', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(379, 1, '2025-02-21 01:51:28', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(380, 1, '2025-02-21 01:51:29', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(381, 1, '2025-02-21 01:54:40', 'Pinjaman', 'Tambah Pinjaman Berhasil    '),
(382, 1, '2025-02-21 20:29:40', 'Fitur Akses', 'Edit Fitur Akses'),
(383, 1, '2025-02-21 20:32:05', 'Fitur Akses', 'Edit Fitur Akses'),
(384, 1, '2025-02-21 21:03:11', 'Akses', 'Input Fitur Akses'),
(385, 1, '2025-02-21 22:12:41', 'Barang', 'Tambah kategori harga untuk Grosir'),
(386, 1, '2025-02-21 23:16:11', 'Barang', 'Tambah Kategori Harga'),
(387, 1, '2025-02-21 23:16:11', 'Barang', 'Tambah Kategori Harga'),
(388, 1, '2025-02-21 23:18:06', 'Barang', 'Tambah Kategori Harga'),
(389, 1, '2025-02-21 23:18:06', 'Barang', 'Tambah Kategori Harga'),
(390, 1, '2025-02-21 23:40:34', 'Barang', 'Tambah Kategori Harga'),
(391, 1, '2025-02-21 23:42:54', 'Barang', 'Edit Kategori Harga'),
(392, 1, '2025-02-21 23:45:39', 'Barang', 'Edit Kategori Harga'),
(393, 1, '2025-02-22 00:17:18', 'Barang', 'Hapus Kategori Harga'),
(394, 1, '2025-02-22 00:17:22', 'Barang', 'Hapus Kategori Harga'),
(395, 1, '2025-02-22 00:17:26', 'Barang', 'Hapus Kategori Harga'),
(396, 1, '2025-02-22 00:17:32', 'Barang', 'Hapus Kategori Harga'),
(397, 1, '2025-02-22 00:17:52', 'Barang', 'Edit Kategori Harga'),
(398, 1, '2025-02-22 00:37:13', 'Barang', 'Tambah Kategori Harga'),
(399, 1, '2025-02-22 00:37:22', 'Barang', 'Hapus Kategori Harga'),
(400, 1, '2025-02-22 01:12:31', 'Barang', 'Edit Kategori Harga'),
(401, 1, '2025-02-22 01:15:01', 'Barang', 'Edit Kategori Harga'),
(402, 1, '2025-02-22 01:35:28', 'Barang', 'Tambah Barang'),
(403, 1, '2025-02-22 01:42:40', 'Barang', 'Tambah Barang'),
(404, 1, '2025-02-22 05:11:33', 'Barang', 'Hapus Kategori Harga'),
(405, 1, '2025-02-22 05:11:36', 'Barang', 'Hapus Kategori Harga'),
(406, 1, '2025-02-22 05:11:40', 'Barang', 'Hapus Kategori Harga'),
(407, 1, '2025-02-22 05:12:07', 'Barang', 'Tambah Barang'),
(408, 1, '2025-02-22 05:12:12', 'Barang', 'Tambah Barang'),
(409, 1, '2025-02-22 05:13:27', 'Barang', 'Tambah Barang'),
(410, 1, '2025-02-22 05:16:57', 'Barang', 'Edit Barang'),
(411, 1, '2025-02-22 05:17:11', 'Barang', 'Tambah Kategori Harga'),
(412, 1, '2025-02-22 05:17:20', 'Barang', 'Tambah Kategori Harga'),
(413, 1, '2025-02-22 05:17:30', 'Barang', 'Tambah Kategori Harga'),
(414, 1, '2025-02-22 05:23:32', 'Barang', 'Edit Barang'),
(415, 1, '2025-02-22 05:24:11', 'Barang', 'Edit Barang'),
(416, 1, '2025-02-22 05:29:46', 'Barang', 'Tambah Barang'),
(417, 1, '2025-02-22 05:29:55', 'Barang', 'Edit Barang'),
(418, 1, '2025-02-22 17:43:20', 'Barang', 'Hapus Barang'),
(419, 1, '2025-02-22 17:43:25', 'Barang', 'Hapus Barang'),
(420, 1, '2025-02-22 17:43:29', 'Barang', 'Hapus Barang'),
(421, 1, '2025-02-22 18:20:04', 'Setting', 'Setting Email'),
(422, 1, '2025-02-22 19:03:27', 'Bantuan', 'Hapus Konten Bantuan'),
(423, 1, '2025-02-23 01:53:06', 'Barang', 'Tambah Satuan Multi'),
(424, 1, '2025-02-23 01:54:59', 'Barang', 'Tambah Satuan Multi'),
(425, 1, '2025-02-23 02:02:06', 'Barang', 'Tambah Satuan Multi'),
(426, 1, '2025-02-23 02:02:17', 'Barang', 'Tambah Satuan Multi'),
(427, 1, '2025-02-23 02:15:19', 'Barang', 'Edit Barang'),
(428, 1, '2025-02-23 03:03:01', 'Barang', 'Edit Satuan Multi'),
(429, 1, '2025-02-23 03:03:11', 'Barang', 'Edit Satuan Multi'),
(430, 1, '2025-02-23 03:03:22', 'Barang', 'Edit Satuan Multi'),
(431, 1, '2025-02-23 03:03:33', 'Barang', 'Edit Satuan Multi'),
(432, 1, '2025-02-23 03:13:32', 'Barang', 'Edit Satuan Multi'),
(433, 1, '2025-02-23 03:32:29', 'Barang', 'Hapus Satuan Multi'),
(434, 1, '2025-02-23 04:24:41', 'Akses', 'Input Fitur Akses'),
(435, 1, '2025-02-23 04:25:11', 'Entitas Akses', 'Edit Entitas Akses'),
(436, 1, '2025-02-23 05:28:08', 'Supplier', 'Input Supplier Baru'),
(437, 1, '2025-02-23 05:32:42', 'Supplier', 'Input Supplier Baru'),
(438, 1, '2025-02-23 05:53:55', '', ''),
(439, 1, '2025-02-23 05:54:01', '', ''),
(440, 1, '2025-02-23 05:54:12', '', ''),
(441, 1, '2025-02-23 05:54:41', '', ''),
(442, 1, '2025-02-23 06:16:16', '', ''),
(443, 1, '2025-02-23 06:16:21', '', ''),
(444, 5, '2025-02-23 19:40:17', 'Barang', 'Tambah Barang'),
(445, 1, '2025-02-23 19:42:32', 'Barang', 'Tambah Barang'),
(446, 1, '2025-02-23 19:45:14', 'Barang', 'Tambah Barang'),
(447, 1, '2025-02-23 19:45:53', 'Barang', 'Tambah Barang'),
(448, 1, '2025-02-23 19:46:28', 'Barang', 'Tambah Barang'),
(449, 1, '2025-02-23 19:47:17', 'Barang', 'Tambah Barang'),
(450, 1, '2025-02-23 19:47:49', 'Barang', 'Tambah Barang'),
(451, 1, '2025-02-23 21:53:51', 'Barang', 'Tambah Barang Batch & Expired'),
(452, 1, '2025-02-23 21:54:38', 'Barang', 'Edit Barang Batch & Expired'),
(453, 1, '2025-02-23 21:55:00', 'Barang', 'Hapus Barang Batch & Expired'),
(454, 1, '2025-02-23 23:22:05', 'Akses', 'Input Fitur Akses'),
(455, 1, '2025-02-23 23:22:16', 'Entitas Akses', 'Edit Entitas Akses'),
(456, 1, '2025-02-24 00:11:58', 'Barang', 'Tambah Sesi Stock Opename'),
(457, 1, '2025-02-24 00:15:22', 'Barang', 'Tambah Sesi Stock Opename'),
(458, 1, '2025-02-24 00:16:02', 'Barang', 'Tambah Sesi Stock Opename'),
(459, 1, '2025-02-24 00:16:34', 'Barang', 'Tambah Sesi Stock Opename'),
(460, 1, '2025-02-24 00:16:43', 'Barang', 'Tambah Sesi Stock Opename'),
(461, 1, '2025-02-24 00:17:04', 'Barang', 'Tambah Sesi Stock Opename'),
(462, 1, '2025-02-24 00:19:14', 'Barang', 'Tambah Sesi Stock Opename'),
(463, 1, '2025-02-24 00:20:08', 'Barang', 'Tambah Sesi Stock Opename'),
(464, 1, '2025-02-24 00:32:30', 'Barang', 'Edit Sesi Stock Opename'),
(465, 1, '2025-02-24 00:32:49', 'Barang', 'Edit Sesi Stock Opename'),
(466, 1, '2025-02-24 00:44:25', 'Barang', 'Hapus Sesi Stock Opename'),
(467, 1, '2025-02-24 00:45:13', 'Barang', 'Edit Sesi Stock Opename'),
(468, 1, '2025-02-24 00:45:16', 'Barang', 'Hapus Sesi Stock Opename'),
(469, 1, '2025-02-24 00:45:29', 'Barang', 'Tambah Sesi Stock Opename'),
(470, 1, '2025-02-24 02:54:38', 'Barang', 'Atur Stock Opename Barang'),
(471, 1, '2025-02-24 02:54:57', 'Barang', 'Atur Stock Opename Barang'),
(472, 1, '2025-02-24 02:55:03', 'Barang', 'Atur Stock Opename Barang'),
(473, 1, '2025-02-24 02:56:14', 'Barang', 'Atur Stock Opename Barang'),
(474, 1, '2025-02-24 02:58:15', 'Barang', 'Atur Stock Opename Barang'),
(475, 1, '2025-02-24 03:00:28', 'Barang', 'Atur Stock Opename Barang'),
(476, 1, '2025-02-24 13:36:17', 'Akses', 'Input Fitur Akses'),
(477, 1, '2025-02-24 13:42:18', 'Entitas Akses', 'Edit Entitas Akses'),
(478, 1, '2025-02-24 15:58:16', 'Akses', 'Input Fitur Akses'),
(479, 1, '2025-02-24 15:58:37', 'Entitas Akses', 'Edit Entitas Akses'),
(480, 1, '2025-02-25 04:33:28', 'Transaksi Penjualan', 'Hapus Rincian Bulk Penjualan'),
(481, 1, '2025-02-25 04:33:35', 'Transaksi Penjualan', 'Hapus Rincian Bulk Penjualan'),
(482, 1, '2025-02-25 04:34:52', 'Transaksi Penjualan', 'Hapus Rincian Bulk Penjualan'),
(483, 1, '2025-02-25 04:52:59', 'Transaksi Penjualan', 'Reset Transaksi Penjualan'),
(484, 1, '2025-02-25 05:35:51', 'Transaksi Penjualan', 'Reset Transaksi Penjualan'),
(485, 5, '2025-02-25 06:34:53', 'Transaksi Penjualan', 'Reset Transaksi Penjualan'),
(487, 1, '2025-02-26 01:12:42', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(488, 1, '2025-02-26 01:26:50', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(489, 1, '2025-02-26 01:29:24', 'Akses', 'Input Fitur Akses'),
(490, 1, '2025-02-26 01:29:52', 'Fitur Akses', 'Edit Fitur Akses'),
(491, 1, '2025-02-26 01:30:38', 'Entitas Akses', 'Edit Entitas Akses'),
(492, 1, '2025-02-26 01:39:53', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(493, 1, '2025-04-02 14:19:38', 'Akses', 'Input Fitur Akses'),
(494, 1, '2025-04-02 14:19:53', 'Entitas Akses', 'Edit Entitas Akses'),
(495, 1, '2025-04-02 14:22:35', 'Jenis Pinjaman', 'Tambah Jenis Pinjaman'),
(496, 1, '2025-04-02 16:19:27', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(497, 1, '2025-04-02 16:20:21', 'Akses', 'Input Fitur Akses'),
(498, 1, '2025-04-02 16:20:32', 'Entitas Akses', 'Edit Entitas Akses'),
(499, 1, '2025-04-02 16:21:42', 'Akses', 'Input Fitur Akses'),
(500, 1, '2025-04-02 16:22:10', 'Entitas Akses', 'Edit Entitas Akses'),
(501, 1, '2025-04-02 16:22:39', 'Transaksi Pembelian', 'Tambah Transaksi Pembelian'),
(502, 1, '2025-04-02 16:24:06', 'Fitur Akses', 'Edit Fitur Akses'),
(503, 1, '2025-04-02 16:24:17', 'Fitur Akses', 'Edit Fitur Akses'),
(504, 1, '2025-04-02 16:24:36', 'Fitur Akses', 'Edit Fitur Akses'),
(505, 1, '2025-04-02 16:24:43', 'Fitur Akses', 'Edit Fitur Akses'),
(506, 1, '2025-04-02 16:25:20', 'Akses', 'Input Fitur Akses'),
(507, 1, '2025-04-02 16:25:40', 'Entitas Akses', 'Edit Entitas Akses'),
(508, 1, '2025-04-02 16:26:20', 'Transaksi Pembelian', 'Tambah Transaksi Pembelian'),
(509, 1, '2025-04-02 16:26:28', 'Jurnal', 'Edit Jurnal'),
(510, 1, '2025-04-02 18:26:56', 'Akses', 'Input Fitur Akses'),
(511, 1, '2025-04-02 18:27:06', 'Entitas Akses', 'Edit Entitas Akses'),
(512, 1, '2025-04-02 18:36:56', 'Akses', 'Input Fitur Akses'),
(513, 1, '2025-04-02 18:37:10', 'Entitas Akses', 'Edit Entitas Akses'),
(514, 1, '2025-04-02 18:45:16', 'SHU', 'Tambah SHU'),
(515, 1, '2025-04-02 18:48:08', 'SHU', 'Tambah Rincian SHU manual'),
(516, 1, '2025-04-02 18:48:55', 'SHU', 'Edit SHU'),
(517, 1, '2025-04-02 18:48:59', 'SHU', 'Hapus SHU'),
(518, 1, '2025-04-02 18:49:03', 'SHU', 'Hapus SHU'),
(519, 1, '2025-04-02 18:49:07', 'SHU', 'Hapus SHU'),
(520, 1, '2025-04-02 18:56:54', 'SHU', 'Tambah SHU'),
(521, 1, '2025-04-03 00:24:51', 'SHU', 'Update Status SHU'),
(522, 1, '2025-04-03 00:28:33', 'Log Simpanan', 'Tambah Penarikan'),
(523, 1, '2025-04-03 00:29:28', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(524, 1, '2025-04-03 00:29:35', 'Simpanan Wajib', 'Tambah Simpanan Wajib'),
(525, 1, '2025-04-03 00:30:35', 'Log Simpanan', 'Tambah Penarikan'),
(526, 1, '2025-04-03 00:40:06', 'Akses', 'Input Fitur Akses'),
(527, 1, '2025-04-03 00:40:17', 'Entitas Akses', 'Edit Entitas Akses'),
(528, 1, '2025-04-03 01:09:29', 'Akses', 'Input Fitur Akses'),
(529, 1, '2025-04-03 01:10:27', 'Akses', 'Input Fitur Akses'),
(530, 1, '2025-04-03 01:10:40', 'Entitas Akses', 'Edit Entitas Akses'),
(531, 1, '2025-04-03 02:03:00', 'Akses', 'Input Fitur Akses'),
(532, 1, '2025-04-03 02:03:17', 'Fitur Akses', 'Hapus Fitur Akses'),
(533, 1, '2025-04-08 00:34:47', 'Akses', 'Input Fitur Akses'),
(534, 1, '2025-04-08 00:35:04', 'Entitas Akses', 'Edit Entitas Akses'),
(535, 1, '2025-04-13 21:08:22', 'Transaksi Penjualan', 'Tambah Jurnal Manual'),
(536, 1, '2025-04-13 21:09:18', 'Transaksi Penjualan', 'Tambah Jurnal Manual'),
(537, 1, '2025-04-13 21:09:44', 'Jurnal', 'Edit Jurnal'),
(538, 1, '2025-04-13 21:31:03', 'Transaksi Penjualan', 'Tambah Jurnal Manual'),
(539, 1, '2025-04-13 21:32:02', 'Jurnal', 'Edit Jurnal'),
(540, 1, '2025-04-13 21:32:22', 'Transaksi Penjualan', 'Tambah Jurnal Manual'),
(541, 1, '2025-04-13 21:36:04', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(542, 1, '2025-04-13 21:37:12', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(543, 1, '2025-04-13 21:56:58', 'Transaksi Penjualan', 'Hapus Transaksi Penjualan'),
(544, 1, '2025-04-20 23:41:12', 'Barang', 'Edit Barang'),
(545, 1, '2025-04-21 00:16:30', 'Akun Perkiraan', 'Tambah Akun Perkiraan'),
(549, 1, '2025-05-01 01:00:16', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(550, 1, '2025-05-01 01:00:57', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(551, 1, '2025-05-01 01:01:29', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(552, 1, '2025-05-01 01:06:38', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(553, 1, '2025-05-01 01:08:22', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(554, 1, '2025-05-01 04:14:58', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(555, 1, '2025-05-01 04:16:38', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(556, 1, '2025-05-04 21:03:27', 'Dokumentasi', 'Tambah Dokumentasi'),
(557, 1, '2025-05-04 21:08:24', 'Dokumentasi', 'Edit Dokumentasi'),
(558, 1, '2025-05-09 22:29:51', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(559, 1, '2025-05-09 22:30:26', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(560, 1, '2025-05-09 22:32:34', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(561, 1, '2025-05-09 22:41:18', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(562, 1, '2025-05-09 22:52:36', 'Dokumentasi', 'Edit Dokumentasi'),
(563, 1, '2025-05-09 23:04:31', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(564, 1, '2025-05-09 23:13:05', 'Transaksi Pembelian', 'Tambah Transaksi Pembelian'),
(565, 1, '2025-05-26 00:40:05', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(566, 1, '2025-05-26 00:40:16', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(567, 1, '2025-05-26 00:43:37', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(568, 1, '2025-05-26 00:44:14', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(569, 1, '2025-05-26 00:46:25', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(570, 1, '2025-05-26 00:46:26', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(571, 1, '2025-05-26 00:46:26', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(572, 1, '2025-05-26 00:46:31', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(573, 1, '2025-05-26 00:46:46', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(574, 1, '2025-05-26 00:47:08', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(575, 1, '2025-05-26 00:48:33', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(576, 1, '2025-05-26 00:51:36', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(577, 1, '2025-05-26 00:56:56', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(578, 1, '2025-05-26 01:05:22', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(579, 1, '2025-05-26 01:08:49', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(585, 1, '2025-05-27 00:54:42', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(586, 1, '2025-05-27 01:10:06', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(587, 1, '2025-05-27 01:10:28', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(588, 1, '2025-05-27 01:11:50', 'Transaksi Penjualan', 'Hapus Transaksi Penjualan'),
(589, 1, '2025-05-27 01:12:27', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(590, 1, '2025-05-27 01:12:46', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(591, 1, '2025-05-27 01:15:46', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(592, 1, '2025-05-27 03:39:00', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(593, 1, '2025-05-29 20:34:09', 'Transaksi Pembelian', 'Tambah Transaksi Pembelian'),
(594, 1, '2025-05-29 20:35:59', 'Transaksi Pembelian', 'Tambah Transaksi Pembelian'),
(595, 1, '2025-05-29 20:36:15', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(596, 1, '2025-05-29 20:45:11', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(597, 1, '2025-06-07 01:23:29', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(598, 1, '2025-06-07 01:33:37', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(599, 1, '2025-06-07 01:56:45', 'Transaksi Penjualan', 'Tambah Transaksi Penjualan'),
(600, 1, '2025-06-07 01:56:50', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(601, 1, '2025-06-07 01:58:05', 'Utang Piutang', 'Edit Pembayaran Utang Piutang'),
(602, 1, '2025-06-07 01:59:29', 'Transaksi Penjualan', 'Edit Transaksi Penjualan'),
(603, 1, '2025-06-07 02:42:47', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(604, 1, '2025-06-07 02:45:56', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(605, 1, '2025-06-07 02:46:21', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(606, 1, '2025-06-07 02:46:26', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(607, 1, '2025-06-07 02:48:07', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(608, 1, '2025-06-07 02:50:53', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(609, 1, '2025-06-07 02:51:35', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(610, 1, '2025-06-07 02:52:53', 'Utang Piutang', 'Hapus Pembayaran Utang Piutang'),
(611, 1, '2025-06-07 02:55:03', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(612, 1, '2025-06-07 02:55:12', 'Utang Piutang', 'Edit Pembayaran Utang Piutang'),
(613, 1, '2025-06-07 02:55:20', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(614, 1, '2025-06-07 02:56:07', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(615, 1, '2025-06-07 03:00:01', 'Utang Piutang', 'Pembayaran Utang Piutang'),
(616, 1, '2025-06-24 00:51:15', 'Log Simpanan', 'Tambah Penarikan'),
(617, 1, '2025-06-24 00:51:15', 'Log Simpanan', 'Tambah Penarikan'),
(618, 1, '2025-06-24 00:51:15', 'Log Simpanan', 'Tambah Penarikan'),
(619, 1, '2025-06-24 00:52:06', 'Log Simpanan', 'Tambah Penarikan'),
(620, 1, '2025-06-24 00:52:06', 'Log Simpanan', 'Tambah Penarikan'),
(621, 1, '2025-06-24 00:52:06', 'Log Simpanan', 'Tambah Penarikan'),
(622, 1, '2025-06-24 01:02:22', 'Log Simpanan', 'Tambah Simpanan'),
(623, 1, '2025-06-24 01:27:55', 'Log Simpanan', 'Tambah Simpanan'),
(624, 1, '2025-06-24 01:30:33', 'Log Simpanan', 'Tambah Simpanan'),
(625, 1, '2025-06-24 01:38:57', 'Log Simpanan', 'Tambah Simpanan'),
(626, 1, '2025-06-24 01:40:22', 'Log Simpanan', 'Tambah Simpanan'),
(627, 1, '2025-06-24 01:40:32', 'Log Simpanan', 'Tambah Simpanan'),
(628, 1, '2025-06-24 02:04:31', 'Jenis Pinjaman', 'Tambah Jenis Pinjaman');

-- --------------------------------------------------------

--
-- Table structure for table `lupa_password`
--

DROP TABLE IF EXISTS `lupa_password`;
CREATE TABLE IF NOT EXISTS `lupa_password` (
  `id_lupa_password` int NOT NULL AUTO_INCREMENT,
  `id_akses_anggota` int NOT NULL,
  `tanggal_dibuat` varchar(25) NOT NULL,
  `tanggal_expired` varchar(25) NOT NULL,
  `code_unik` text NOT NULL,
  PRIMARY KEY (`id_lupa_password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

DROP TABLE IF EXISTS `pinjaman`;
CREATE TABLE IF NOT EXISTS `pinjaman` (
  `id_pinjaman` int NOT NULL AUTO_INCREMENT,
  `id_pinjaman_jenis` int DEFAULT NULL,
  `uuid_pinjaman` char(36) NOT NULL,
  `id_anggota` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(32) NOT NULL,
  `tanggal` date NOT NULL COMMENT 'tanggal perriode mulainya pinjaman',
  `jatuh_tempo` smallint NOT NULL COMMENT 'tanggal jatuh tempo 1-31',
  `denda` int DEFAULT NULL COMMENT 'Rp denda keterlambatan',
  `sistem_denda` varchar(10) DEFAULT NULL COMMENT 'Harian, Bulanan',
  `jumlah_pinjaman` int NOT NULL,
  `persen_jasa` decimal(12,2) DEFAULT NULL COMMENT 'persen/bulan',
  `rp_jasa` int DEFAULT NULL COMMENT 'nominal jasa=pinjaman x bunga',
  `angsuran_pokok` int NOT NULL COMMENT 'angsuran tanpa bunga',
  `angsuran_total` int NOT NULL COMMENT 'angsuran plus bunga',
  `periode_angsuran` int NOT NULL COMMENT 'frekuensi angsuran',
  `status` varchar(10) NOT NULL COMMENT 'Berjalan, Lunas, Macet',
  PRIMARY KEY (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_pinjaman_jenis` (`id_pinjaman_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjaman`, `id_pinjaman_jenis`, `uuid_pinjaman`, `id_anggota`, `nama`, `nip`, `tanggal`, `jatuh_tempo`, `denda`, `sistem_denda`, `jumlah_pinjaman`, `persen_jasa`, `rp_jasa`, `angsuran_pokok`, `angsuran_total`, `periode_angsuran`, `status`) VALUES
(26, 1, '1UYjtSkUTWu1lBLEdM2w9fGVrgTkX1soIz7S', 1, 'Adam Saputra', '2024/07/Contoh-01', '2025-04-02', 1, 0, 'Harian', 10000000, 1.00, 100000, 1000000, 1100000, 10, 'Berjalan'),
(28, 2, 'YgAW3sAW3Hld7xg2oGFS8AvG3PsuauerIRwe', 1, 'Adam Saputra', '2024/07/Contoh-01', '2025-06-24', 1, 1000, 'Harian', 10000000, 0.42, 42000, 833333, 875333, 12, 'Berjalan'),
(29, 1, 'RPzUDfGIC879shqGT981BPhRIA4WqqGZxi0a', 2, 'Budi Santoso', '2024/07/Contoh-02', '2025-01-01', 1, 20000, 'Harian', 12000000, 0.83, 99600, 1000000, 1099600, 12, 'Berjalan');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_angsuran`
--

DROP TABLE IF EXISTS `pinjaman_angsuran`;
CREATE TABLE IF NOT EXISTS `pinjaman_angsuran` (
  `id_pinjaman_angsuran` int NOT NULL AUTO_INCREMENT,
  `uuid_angsuran` char(36) NOT NULL,
  `id_pinjaman` int NOT NULL,
  `id_anggota` int NOT NULL,
  `tanggal_angsuran` date NOT NULL,
  `tanggal_bayar` date NOT NULL COMMENT 'tanggal angsuran',
  `keterlambatan` int DEFAULT NULL COMMENT 'hari',
  `pokok` int DEFAULT NULL,
  `jasa` int DEFAULT NULL,
  `denda` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  PRIMARY KEY (`id_pinjaman_angsuran`),
  KEY `id_pinjaman` (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=644 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_angsuran`
--

INSERT INTO `pinjaman_angsuran` (`id_pinjaman_angsuran`, `uuid_angsuran`, `id_pinjaman`, `id_anggota`, `tanggal_angsuran`, `tanggal_bayar`, `keterlambatan`, `pokok`, `jasa`, `denda`, `jumlah`) VALUES
(630, 'VjhcEj0lx8g9JV4X3CRbfbAQRGbhWGvJUD5a', 26, 1, '2025-05-01', '2025-04-02', 0, 1000000, 100000, 0, 1100000),
(631, 'C34JffjFNbXrFOZioIXO4GA97aQUuINJHF09', 26, 1, '2025-06-01', '2025-04-02', 0, 1000000, 100000, 0, 1100000),
(633, 'khfYbUTgCXA7miVBirG9LlZG3aaUPE9JF7ed', 26, 1, '2025-07-01', '2025-04-13', 0, 1000000, 100000, 0, 1100000),
(634, 'up3JkY9GM35dojC3fvSIWWKGHWB0uh886O4j', 26, 1, '2025-05-02', '2025-05-04', 0, 1000000, 100000, 0, 1100000),
(635, 'x4VKfPzp7igALikAZPLJuNSw2XictRkqIvya', 26, 1, '2025-06-02', '2025-06-07', 0, 1000000, 100000, 0, 1100000),
(638, 'tq3pkNYyZ0CaVmj1Hlbzmp3J5BYXbCT451Mg', 28, 1, '2025-07-01', '2025-06-24', 0, 833333, 42000, 0, 875333),
(639, '3CAlakc9QpyUhZxAsOj8xmmwzwMxd0aVuyAS', 29, 2, '2025-02-01', '2025-06-24', 0, 1000000, 99600, 0, 1099600),
(640, 'wmyTe2aHl2fFlDCVy5WzHjyEvRBPOatUXdLG', 29, 2, '2025-03-01', '2025-06-24', 0, 1000000, 99600, 0, 1099600),
(641, 'X6fh6lfYqGf8bsFcYmDeMVYkG3YIdY8aheKD', 29, 2, '2025-04-01', '2025-06-24', 0, 1000000, 99600, 0, 1099600),
(642, 'hSESX2AI5g3GeDBi51RxmHx8VPHXIuoua80U', 29, 2, '2025-05-01', '2025-06-24', 0, 1000000, 99600, 0, 1099600),
(643, 'tSzJ0dQ34rhKyGrVh7dmGVFeLSWuqn3oi7Kh', 29, 2, '2025-06-01', '2025-06-24', 0, 1000000, 99600, 0, 1099600);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_jenis`
--

DROP TABLE IF EXISTS `pinjaman_jenis`;
CREATE TABLE IF NOT EXISTS `pinjaman_jenis` (
  `id_pinjaman_jenis` int NOT NULL AUTO_INCREMENT,
  `nama_pinjaman` varchar(50) NOT NULL,
  `periode_angsuran` int NOT NULL,
  `persen_jasa` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_pinjaman_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_jenis`
--

INSERT INTO `pinjaman_jenis` (`id_pinjaman_jenis`, `nama_pinjaman`, `periode_angsuran`, `persen_jasa`) VALUES
(1, 'Pinjaman Konsumtif', 12, 10.00),
(2, 'Pinjaman KTR', 12, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `setting_general`
--

DROP TABLE IF EXISTS `setting_general`;
CREATE TABLE IF NOT EXISTS `setting_general` (
  `id_setting_general` int NOT NULL AUTO_INCREMENT,
  `title_page` varchar(20) NOT NULL,
  `kata_kunci` text NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat_bisnis` text NOT NULL,
  `email_bisnis` text NOT NULL,
  `telepon_bisnis` varchar(15) NOT NULL,
  `favicon` text NOT NULL,
  `logo` text NOT NULL,
  `base_url` text NOT NULL,
  `author` varchar(100) NOT NULL,
  PRIMARY KEY (`id_setting_general`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_general`
--

INSERT INTO `setting_general` (`id_setting_general`, `title_page`, `kata_kunci`, `deskripsi`, `alamat_bisnis`, `email_bisnis`, `telepon_bisnis`, `favicon`, `logo`, `base_url`, `author`) VALUES
(1, 'Koperasi Sejahtera', 'Koperasi', 'Aplikasi POS Koperasi', 'PT.Gunze Indonesia, Ejip Industrial Park Plot 7 H-1 ,Cikarang Selatan,Bekasi 17550 Indonesia', 'dhiforester@gmail.com', '0232876240', '283a3fda7225285273601d32a6a1a1.png', '0e7432c17ed9874e0b1c2090dde1cc.png', 'http://localhost:81/koperasi_lite', 'Solihul Hadi');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

DROP TABLE IF EXISTS `simpanan`;
CREATE TABLE IF NOT EXISTS `simpanan` (
  `id_simpanan` int NOT NULL AUTO_INCREMENT,
  `uuid_simpanan` char(36) NOT NULL,
  `id_anggota` int NOT NULL,
  `id_akses` int NOT NULL,
  `id_simpanan_jenis` int DEFAULT NULL,
  `rutin` int DEFAULT NULL COMMENT 'true/false',
  `nip` varchar(32) NOT NULL COMMENT 'nip anggota',
  `nama` text NOT NULL COMMENT 'nama anggota',
  `tanggal` date NOT NULL COMMENT 'tanggal simpanan',
  `kategori` varchar(30) NOT NULL COMMENT 'Simpanan Pokok\r\nSimpanan Wajib\r\nSimpanan Sukarela\r\nPenarikan',
  `keterangan` text,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id_simpanan`),
  KEY `id_anggota` (`id_anggota`),
  KEY `simpanan_to_jenis` (`id_simpanan_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=477 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `uuid_simpanan`, `id_anggota`, `id_akses`, `id_simpanan_jenis`, `rutin`, `nip`, `nama`, `tanggal`, `kategori`, `keterangan`, `jumlah`) VALUES
(474, '4KhpCl3MjLKjsVf6HfioczeNR2HHMGLMaT9R', 1, 1, 1, NULL, '2024/07/Contoh-01', 'Adam Saputra', '2025-01-01', 'Simpanan Wajib', '', 300000),
(475, 'YmdZtmYAT9D14YsKuXh5cSvgPYai1eLnslxk', 2, 1, 1, NULL, '2024/07/Contoh-02', 'Budi Santoso', '2025-06-01', 'Simpanan Wajib', '', 300000),
(476, 'XxTPHzKEBaDP5fkAhDhREFWyotQQx3jFMSFD', 3, 1, 1, NULL, '2024/07/Contoh-111', 'Citra Dewi', '2025-06-01', 'Simpanan Wajib', '', 300000);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_jenis`
--

DROP TABLE IF EXISTS `simpanan_jenis`;
CREATE TABLE IF NOT EXISTS `simpanan_jenis` (
  `id_simpanan_jenis` int NOT NULL AUTO_INCREMENT,
  `nama_simpanan` varchar(30) NOT NULL,
  `keterangan` text,
  `rutin` tinyint(1) NOT NULL COMMENT 'True/False',
  `nominal` int DEFAULT NULL,
  PRIMARY KEY (`id_simpanan_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan_jenis`
--

INSERT INTO `simpanan_jenis` (`id_simpanan_jenis`, `nama_simpanan`, `keterangan`, `rutin`, `nominal`) VALUES
(1, 'Simpanan Wajib', '', 1, 300000),
(3, 'Simpanan Suka Rela', 'Simpanan anggota atas dasar suka rela', 0, 0),
(4, 'Simpanan Pokok', 'Simpanan yang wajib masuk pada saat pertama kali menjadi anggota', 1, 100000),
(7, 'Simpanan Penghasilan', 'Simpanan yang berasal dari jumlah penghasilan', 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinjaman_to_jenis` FOREIGN KEY (`id_pinjaman_jenis`) REFERENCES `pinjaman_jenis` (`id_pinjaman_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman_angsuran`
--
ALTER TABLE `pinjaman_angsuran`
  ADD CONSTRAINT `angsuran_to_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `angsuran_to_pinjaman` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `simpanan_to_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simpanan_to_jenis` FOREIGN KEY (`id_simpanan_jenis`) REFERENCES `simpanan_jenis` (`id_simpanan_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
