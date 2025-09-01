-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 01, 2025 at 03:49 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `nama_akses`, `kontak_akses`, `email_akses`, `password`, `image_akses`, `akses`, `datetime_daftar`, `datetime_update`) VALUES
(1, 'Solihul Hadi', '6289601154723', 'dhiforester@gmail.com', 'f4a3229c9c5f1bdd9c6a6791080791b7', '9bf5b8e474a5927eb87d5084a85b5a.jpg', 'Admin', '2022-08-29 11:10:06', '2025-06-23 17:59:41'),
(4, 'Anita', '6289601154724', 'animaryani@gmail.com', '1ebc7a02439687420f4f18ebe6bd03ac', '1396353a04e0e796b253d64a58dbb4.png', 'Sekretaris', '2024-07-12 01:23:54', '2025-06-23 17:19:17'),
(5, 'solihul Hadi', '0218374847', 'solihulhadi141213@gmail.com', 'a2cc01a152da09c1ad15b345e430ed7d', '', 'Admin', '2025-02-22 17:32:35', '2025-02-22 17:32:35'),
(8, 'Javier Rivaldy C.P', '085783325847', 'javierrivaldy12@gmail.com', 'ed3583432a0990acffde32d5ef3479eb', '', 'Sekretaris', '2025-07-30 18:17:05', '2025-08-25 00:59:00'),
(9, 'Dewi Widiastuti', '123123', 'dewiwidiastuti@gmail.com', '35bbd42323b0a6f4693aadf671260ef5', '', 'Bendahara', '2025-08-24 21:29:00', '2025-08-24 21:29:00'),
(10, 'Syamsul', '087484748', 'syamsul@gmail.com', '564d5ea829ce8977fb848c0a654c7888', '', 'Ketua', '2025-08-24 21:53:27', '2025-08-24 21:53:27');

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
(24, 'Anggota', 'b9ce962c31280745ded0ee9230fd0131', '2025-06-13 21:02:38', '2025-06-13 22:02:38'),
(6, 'Pengurus', 'b75ddeece5abe9587a92af7fbf42b7fb', '2025-06-21 17:56:47', '2025-06-21 19:03:50'),
(5, 'Pengurus', '2a3b9da101945363c37ccc0cc75562ae', '2025-08-13 17:42:51', '2025-08-13 21:00:10');

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
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Aktif, Keluar, Pending',
  `alasan_keluar` text COMMENT 'Diisi Hanya Apabila Keluar',
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `tanggal_masuk`, `tanggal_keluar`, `nip`, `nama`, `email`, `kontak`, `password`, `foto`, `status`, `alasan_keluar`) VALUES
(1, '2024-01-13', '2024-07-14', '2024/07/Contoh-01', 'Adam Saputra', 'adamsaputra@example.com', '890000001', '', NULL, 'Aktif', ''),
(2, '2024-01-14', '2024-07-14', '2024/07/Contoh-02', 'Budi Santoso', 'budi.santoso@example.com', '890000002', '', NULL, 'Aktif', ''),
(3, '2024-01-15', '2024-07-14', '2024/07/Contoh-111', 'Citra Dewi', 'citra.dewi@example.com', '890000003', '', NULL, 'Aktif', ''),
(4, '2024-01-16', '2024-06-14', '2024/07/Contoh-04', 'Dian Rahmawati', 'dian.rahmawati@example.com', '890000004', '', NULL, 'Keluar', 'Tidak betah'),
(5, '2024-01-17', '2024-07-14', '2024/07/Contoh-05', 'Eka Prasetyo', 'eka.prasetyo@example.com', '890000005', '', NULL, 'Aktif', ''),
(6, '2024-01-18', '2024-07-14', '2024/07/Contoh-06', 'Farah Amalia', 'farah.amalia@example.com', '890000006', '', NULL, 'Aktif', ''),
(7, '2024-01-19', '2024-07-14', '2024/07/Contoh-07', 'Guntur Wibowo', 'guntur.wibowo@example.com', '890000007', '', NULL, 'Aktif', ''),
(8, '2024-01-20', '2024-06-14', '2024/07/Contoh-08', 'Hendra Wijaya', 'hendra.wijaya@example.com', '890000008', '', NULL, 'Keluar', ''),
(9, '2024-01-21', '2024-07-14', '2024/07/Contoh-09', 'Indah Permatasari', 'indah.permatasari@example.com', '890000009', '', NULL, 'Aktif', ''),
(10, '2024-01-22', '2024-07-14', '2024/07/Contoh-10', 'Joko Susanto', 'joko.susanto@example.com', '890000010', '', NULL, 'Aktif', ''),
(11, '2024-01-23', '2024-07-14', '2024/07/Contoh-11', 'Karina Putri', 'karina.putri@example.com', '890000011', '', NULL, 'Aktif', ''),
(12, '2024-01-24', '2024-07-14', '2024/07/Contoh-12', 'Leo Pradipta', 'leo.pradipta@example.com', '890000012', '', NULL, 'Aktif', ''),
(13, '2024-01-25', '2024-07-14', '2024/07/Contoh-13', 'Maya Sari', 'maya.sari@example.com', '890000013', '', NULL, 'Aktif', ''),
(14, '2024-01-26', '2024-07-14', '2024/07/Contoh-14', 'Nanda Kusuma', 'nanda.kusuma@example.com', '890000014', '', NULL, 'Aktif', ''),
(15, '2024-01-27', '2024-07-14', '2024/07/Contoh-15', 'Oki Pratama', 'oki.pratama@example.com', '890000015', '', NULL, 'Aktif', ''),
(16, '2024-01-28', '2024-07-14', '2024/07/Contoh-16', 'Putri Ayu', 'putri.ayu@example.com', '890000016', '', NULL, 'Aktif', ''),
(17, '2024-01-29', '2024-06-14', '2024/07/Contoh-17', 'Rizki Setiawan', 'rizki.setiawan@example.com', '890000017', '', NULL, 'Keluar', 'Tidak betah'),
(18, '2024-01-30', '2024-07-14', '2024/07/Contoh-18', 'Sinta Maharani', 'sinta.maharani@example.com', '890000018', '', NULL, 'Aktif', ''),
(19, '2024-01-31', '2024-07-14', '2024/07/Contoh-19', 'Tio Nugroho', 'tio.nugroho@example.com', '890000019', '', NULL, 'Aktif', ''),
(22, '2024-09-21', '2024-09-21', '123122221', 'Aruna Parasilva', 'windy1234@gmail.com', '08961767868', '', NULL, 'Aktif', ''),
(23, '2025-02-01', '2025-02-22', '1111111111111', 'Tri Heru', 'triheruafsheen@gmail.com', '085217731586', '', NULL, 'Aktif', ''),
(24, '2025-01-01', '2025-02-23', '2222222222', 'Sugito', 'gito@gmail.com', '0852323242421', '', NULL, 'Aktif', ''),
(25, '2024-02-01', '2025-02-23', '2024/07/Contoh-20', 'Ulya Handayani', 'ulya.handayani@example.com', '890000020', '', NULL, 'Aktif', ''),
(27, '2025-08-07', '2025-08-07', '320993839384', 'Dewi Widiastuti', 'dewiwidiastuti@gmail.com', '0897869868', '35bbd42323b0a6f4693aadf671260ef5', NULL, 'Aktif', ''),
(32, '2025-06-01', '2025-08-07', '32080921048800053', 'Solihul Hadi', 'dhiforester@gmail.com', '089373847412', 'f4a3229c9c5f1bdd9c6a6791080791b7', '4d497672c9f7d1ca2e6f9edb18a2db.png', 'Aktif', ''),
(33, '2025-08-07', '2025-08-07', '32080921048800055', 'Dewi Widiastuti', 'dewiwidiastuti123@gmail.com', '08937384747', '507c20d8a5f0a5b220967d852b64e87d', NULL, 'Aktif', ''),
(35, '2025-08-24', '2025-08-24', '32080921048800055', 'Anggrita', 'solihulhadi1412@gmail.com', '0893738474143', '9255303f8208c9a43359a3b93b692b3d', NULL, 'Aktif', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `id_akses`, `datetime_log`, `kategori_log`, `deskripsi_log`) VALUES
(1, 1, '2025-09-01 20:46:31', 'Jenis Pinjaman', 'Tambah Jenis Pinjaman'),
(2, 1, '2025-09-01 20:51:45', 'Jenis Pinjaman', 'Edit Jenis Pinjaman');

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
  `id_anggota` int NOT NULL,
  `tanggal_pengajuan` datetime NOT NULL,
  `tanggal_pencairan` datetime DEFAULT NULL,
  `tanggal` date NOT NULL COMMENT 'tanggal perriode mulainya pinjaman',
  `jumlah_pinjaman` int NOT NULL,
  `rp_jasa` int DEFAULT NULL COMMENT 'nominal jasa=pinjaman x bunga',
  `rp_denda` int DEFAULT NULL COMMENT 'Dari angsuran/hari',
  `angsuran_pokok` int NOT NULL COMMENT 'angsuran tanpa bunga',
  `angsuran_total` int NOT NULL COMMENT 'angsuran plus bunga',
  `periode_angsuran` int NOT NULL COMMENT 'frekuensi angsuran',
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Pending, Ditolak, Berjalan, Lunas, Macet',
  PRIMARY KEY (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_pinjaman_jenis` (`id_pinjaman_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjaman`, `id_pinjaman_jenis`, `id_anggota`, `tanggal_pengajuan`, `tanggal_pencairan`, `tanggal`, `jumlah_pinjaman`, `rp_jasa`, `rp_denda`, `angsuran_pokok`, `angsuran_total`, `periode_angsuran`, `status`) VALUES
(35, 1, 32, '2025-08-29 02:06:31', '2025-08-29 02:06:31', '2025-08-29', 12000000, 240000, NULL, 1000000, 1240000, 12, 'Berjalan'),
(36, 3, 35, '2025-09-01 20:59:59', '2025-09-01 20:59:59', '2025-09-01', 24000000, 480000, 10000, 1000000, 1480000, 24, 'Berjalan');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman_angsuran`
--

DROP TABLE IF EXISTS `pinjaman_angsuran`;
CREATE TABLE IF NOT EXISTS `pinjaman_angsuran` (
  `id_pinjaman_angsuran` int NOT NULL AUTO_INCREMENT,
  `id_pinjaman` int NOT NULL,
  `id_anggota` int NOT NULL,
  `kode_pembayaran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_angsuran` date NOT NULL,
  `tanggal_bayar` date DEFAULT NULL COMMENT 'tanggal angsuran',
  `keterlambatan` int DEFAULT NULL COMMENT 'hari',
  `pokok` int DEFAULT NULL,
  `jasa` int DEFAULT NULL,
  `denda` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'None, Pending, Lunas',
  PRIMARY KEY (`id_pinjaman_angsuran`),
  KEY `id_pinjaman` (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_angsuran`
--

INSERT INTO `pinjaman_angsuran` (`id_pinjaman_angsuran`, `id_pinjaman`, `id_anggota`, `kode_pembayaran`, `metode_pembayaran`, `tanggal_angsuran`, `tanggal_bayar`, `keterlambatan`, `pokok`, `jasa`, `denda`, `jumlah`, `status`) VALUES
(1, 35, 32, NULL, NULL, '2025-07-29', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(2, 35, 32, NULL, NULL, '2025-08-29', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(3, 35, 32, NULL, NULL, '2025-09-29', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(4, 35, 32, NULL, NULL, '2025-12-29', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(5, 35, 32, NULL, NULL, '2026-01-29', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(6, 35, 32, NULL, NULL, '2026-03-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(7, 35, 32, NULL, NULL, '2026-04-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(8, 35, 32, NULL, NULL, '2026-05-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(9, 35, 32, NULL, NULL, '2026-06-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(10, 35, 32, NULL, NULL, '2026-07-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(11, 35, 32, NULL, NULL, '2026-08-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(12, 35, 32, NULL, NULL, '2026-09-01', '0000-00-00', 0, 1000000, 240000, 0, 1240000, 'None'),
(13, 36, 35, '638448496969', 'BRI-Virtual Account', '2025-06-02', '2025-09-01', 91, 1000000, 480000, 910000, 2390000, 'Lunas'),
(14, 36, 35, NULL, NULL, '2025-07-02', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(15, 36, 35, NULL, NULL, '2025-12-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(16, 36, 35, NULL, NULL, '2026-01-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(17, 36, 35, NULL, NULL, '2026-02-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(18, 36, 35, NULL, NULL, '2026-03-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(19, 36, 35, NULL, NULL, '2026-04-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(20, 36, 35, NULL, NULL, '2026-05-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(21, 36, 35, NULL, NULL, '2026-06-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(22, 36, 35, NULL, NULL, '2026-07-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(23, 36, 35, NULL, NULL, '2026-08-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(24, 36, 35, NULL, NULL, '2026-09-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(25, 36, 35, NULL, NULL, '2026-10-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(26, 36, 35, NULL, NULL, '2026-11-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(27, 36, 35, NULL, NULL, '2026-12-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(28, 36, 35, NULL, NULL, '2027-01-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(29, 36, 35, NULL, NULL, '2027-02-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(30, 36, 35, NULL, NULL, '2027-03-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(31, 36, 35, NULL, NULL, '2027-04-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(32, 36, 35, NULL, NULL, '2027-05-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(33, 36, 35, NULL, NULL, '2027-06-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(34, 36, 35, NULL, NULL, '2027-07-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(35, 36, 35, NULL, NULL, '2027-08-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None'),
(36, 36, 35, NULL, NULL, '2027-09-01', '0000-00-00', 0, 1000000, 480000, 0, 1480000, 'None');

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
  `persen_denda` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_pinjaman_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_jenis`
--

INSERT INTO `pinjaman_jenis` (`id_pinjaman_jenis`, `nama_pinjaman`, `periode_angsuran`, `persen_jasa`, `persen_denda`) VALUES
(1, 'Pinjaman Konsumtif', 12, 2.00, 0.00),
(2, 'Pinjaman Sosial', 12, 1.00, 1.00),
(3, 'Pinjaman Darurat', 24, 2.00, 1.00);

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
(1, 'KOKASERA', 'Koperasi', 'Aplikasi POS Koperasi', 'PT.WISKA Tanjunglaya, Cikancung, Kota Bandung, Jawa Barat 40396 Indonesia', 'dhiforester@gmail.com', '0227949534', '0b220009fe0804017d92affed115aa.png', 'a2ed89a7ededc78abae5fc426ab14a.png', 'http://localhost/koperasi_lite', 'Javier R.C.P');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

DROP TABLE IF EXISTS `simpanan`;
CREATE TABLE IF NOT EXISTS `simpanan` (
  `id_simpanan` int NOT NULL AUTO_INCREMENT,
  `uuid_simpanan` char(36) NOT NULL,
  `id_anggota` int NOT NULL,
  `id_simpanan_jenis` int DEFAULT NULL,
  `nip` varchar(32) NOT NULL COMMENT 'nip anggota',
  `nama` text NOT NULL COMMENT 'nama anggota',
  `tanggal_simpanan` date NOT NULL COMMENT 'tanggal simpanan',
  `tanggal_bayar` datetime NOT NULL,
  `kategori` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Simpanan Pokok\r\nSimpanan Wajib\r\nSimpanan Sukarela\r\nPenarikan',
  `jumlah` int NOT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL COMMENT 'Lunas, Pending',
  PRIMARY KEY (`id_simpanan`),
  KEY `id_anggota` (`id_anggota`),
  KEY `simpanan_to_jenis` (`id_simpanan_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_jenis`
--

DROP TABLE IF EXISTS `simpanan_jenis`;
CREATE TABLE IF NOT EXISTS `simpanan_jenis` (
  `id_simpanan_jenis` int NOT NULL AUTO_INCREMENT,
  `nama_simpanan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text,
  `kategori` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Wajib, Pokok, Sukarela',
  `nominal` int DEFAULT NULL,
  PRIMARY KEY (`id_simpanan_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan_jenis`
--

INSERT INTO `simpanan_jenis` (`id_simpanan_jenis`, `nama_simpanan`, `keterangan`, `kategori`, `nominal`) VALUES
(3, 'Simpanan Suka Rela', 'Simpanan anggota atas dasar suka rela', 'Simpanan Sukarela', 200000),
(4, 'Simpanan Pokok', 'Simpanan yang wajib masuk pada saat pertama kali menjadi anggota', 'Simpanan Pokok', 100000),
(7, 'Simpanan Penghasilan', 'Simpanan yang berasal dari jumlah penghasilan', 'Simpanan Sukarela', 0),
(9, 'SW', 'Simpanan yang wajib dibayarkan tiap bulan', 'Simpanan Wajib', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_penarikan`
--

DROP TABLE IF EXISTS `simpanan_penarikan`;
CREATE TABLE IF NOT EXISTS `simpanan_penarikan` (
  `id_simpanan_penarikan` int NOT NULL AUTO_INCREMENT,
  `id_simpanan_jenis` int NOT NULL,
  `id_anggota` int NOT NULL,
  `tanggal` date NOT NULL,
  `bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nominal` int NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Lunas, Pending',
  PRIMARY KEY (`id_simpanan_penarikan`),
  KEY `id_simpanan_jenis` (`id_simpanan_jenis`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Constraints for table `simpanan_penarikan`
--
ALTER TABLE `simpanan_penarikan`
  ADD CONSTRAINT `penarikan_simpanan_jenis` FOREIGN KEY (`id_simpanan_jenis`) REFERENCES `simpanan_jenis` (`id_simpanan_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penarikan_to_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
