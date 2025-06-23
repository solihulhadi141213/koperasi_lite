-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 07, 2025 at 03:11 PM
-- Server version: 9.1.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

DROP TABLE IF EXISTS `akses`;
CREATE TABLE IF NOT EXISTS `akses` (
  `id_akses` int NOT NULL AUTO_INCREMENT,
  `nama_akses` text NOT NULL,
  `kontak_akses` varchar(20) DEFAULT NULL,
  `email_akses` varchar(225) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` text NOT NULL,
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
(1, 'Solihul Hadi', '6289601154723', 'dhiforester@gmail.com', 'f4a3229c9c5f1bdd9c6a6791080791b7', '9bf5b8e474a5927eb87d5084a85b5a.jpg', 'Admin', '2022-08-29 11:10:06', '2025-02-21 17:33:58'),
(4, 'Anita', '6289601154724', 'animaryani@gmail.com', '1ebc7a02439687420f4f18ebe6bd03ac', '64ffa523717340c164e75f3f74302f.png', 'Sekretaris', '2024-07-12 01:23:54', '2025-02-26 01:00:22'),
(5, 'solihul Hadi', '0218374847', 'solihulhadi141213@gmail.com', 'a2cc01a152da09c1ad15b345e430ed7d', '', 'Admin', '2025-02-22 17:32:35', '2025-02-22 17:32:35'),
(6, 'Tri heru Purnomo', '085217731586', 'Triheruafsheen@gmail.com', '7541c1d97e0a4f594a493d6a197a059b', '', 'Admin', '2025-02-25 07:13:08', '2025-02-25 07:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `akses_entitas`
--

DROP TABLE IF EXISTS `akses_entitas`;
CREATE TABLE IF NOT EXISTS `akses_entitas` (
  `uuid_akses_entitas` varchar(32) NOT NULL,
  `akses` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`uuid_akses_entitas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_entitas`
--

INSERT INTO `akses_entitas` (`uuid_akses_entitas`, `akses`, `keterangan`) VALUES
('hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 'Admin', 'Pihak yang berwenang untuk mengelola fitur'),
('x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 'Sekretaris', 'Pihak yang bertugas input poendaftaran anggota baru');

-- --------------------------------------------------------

--
-- Table structure for table `akses_fitur`
--

DROP TABLE IF EXISTS `akses_fitur`;
CREATE TABLE IF NOT EXISTS `akses_fitur` (
  `id_akses_fitur` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(32) NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_akses_fitur`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_fitur`
--

INSERT INTO `akses_fitur` (`id_akses_fitur`, `kode`, `nama`, `kategori`, `keterangan`) VALUES
(31, '8KbdfArJ7UmoX916kO7', 'Entitas Akses', 'Akses', 'Halaman untuk mengelola entitas akses'),
(32, 'FGPgsQeVDKPGoQPNGJH', 'Akun Pengguna', 'Akses', 'Halaman untuk mengelola pengguna aplikasi'),
(34, 'rfLn8WEkAqzC1gu5z45', 'Email Gateway', 'Pengaturan', 'Halaman untuk mengatur setting email'),
(35, 'QcDypIyCg8tX76Zzs2I', 'Akses Token', 'Akses', 'Halaman untuk mengelola token akses oleh admin'),
(36, 'mU0dghJfZr6GFXAazZ8', 'Komponen Gaji', 'Penggajian', 'Halaman untuk mengelola komponen gaji'),
(37, 'RAkbS0nrHV10GVxnvXy', 'Peride Gaji', 'Penggajian', 'Kella data periode penggajian'),
(38, 'wY4kURZ8cjrjjtUiAhH', 'Potongan Gaji', 'Penggajian', 'Halaman untuk mengelola potongan gaji karyawan'),
(39, 'gd7YgKyL1WMQctJLgaq', 'API Key', 'Pengaturan', 'Halaman untuk mengelola API Key'),
(40, 'rA8MRFArw1qPeVySjAC', 'Fitur Aplikasi', 'Akses', 'Halaman untuk mengelola data fitur aplikasi'),
(41, 'hNtci80mXl9jwCj19pI', 'Halaman Entitas Akses', 'Akses', 'Halaman utama entitas akses'),
(42, 'oWpF1xPn8dLgRi8hRJx', 'Halaman Anggota', 'Anggota', 'Halaman utama anggota'),
(43, 'n77olEDwon5RO3RYQPD', 'Halaman Simpanan', 'Simpanan', 'Halaman utama simpanan'),
(44, 'JxjfFOxUHimcP0WXqy0', 'Halaman pinjaman', 'Pinjaman', 'Halaman utama pinjaman\r\n'),
(45, 'N6O5Qc64hOEhPQukZSh', 'Laba Rugi', 'Laporan', 'Halaman utama laporan'),
(46, 'X61viKZwNQuNrQ1Vrrg', 'Tagihan', 'Pinjaman', 'Halaman utama tagihan'),
(47, '5MH1cfu7LzOpalmhbT2', 'Kelola Data Bantuan', 'Bantuan', 'Halaman untuk mengelola data bantuan untuk pengguna aplikasi'),
(48, 'QbQ4qF57AzCEp5qG0KG', 'Form Tambah Bantuan', 'Bantuan', 'Halaman form untuk menambahkan konten bantuan'),
(49, 'GA4iqizxbIlTU5mMo0W', 'Halaman Edit Bantuan', 'Bantuan', 'Fitur/Halaman untuk form edit bantuan'),
(50, 'VTouzOD2eM57Onno1Ql', 'Jurnal', 'Keuangan', 'Halaman utama yang menampilkan semua data jurnal keuangan'),
(52, 'n6quFiiDojCgimfkCT7', 'Buku Besar', 'Laporan', 'Halaman laporan buku besar keuangan'),
(53, 'incMmh5yyCmCs4IwCYz', 'Neraca Saldo', 'Laporan', 'Halaman untuk menampilkan laporan neraca saldo berdasarkan periode'),
(54, 'TQ4YLRadAceDvjmoKIN', 'Anggota Keluar Masuk', 'Anggota', 'Halaman anggota keluar masuk'),
(55, 'HdQ2YaxtqY2JL5QnQdS', 'Rekap Anggota', 'Anggota', 'Halaman untuk menampilkan rekap anggota'),
(56, 'TruxAyhHOhvTrVYs6No', 'Jenis Simpanan', 'Simpanan', 'Halaman untuk kelola jenis simpanan'),
(57, 'dG22CVGrX1KNMQpn7Se', 'Simpanan Wajib', 'Simpanan', 'Menampilkan data simpanan wajib'),
(58, '0uITsO9Ci4O394dsIyu', 'Rekap Simpanan', 'Simpanan', 'Halaman rekap simpanan'),
(59, 'hAhdWGrGGtjeMqhAAtD', 'Rekap Pinjaman', 'Pinjaman', 'Halaman rekap pinjaman'),
(60, 'vC4W81sLCdsIGabUEMi', 'Jenis Transaksi', 'Transaksi', 'Halaman kelola jenis transaksi'),
(61, 'RZufXfHVLW9f0EsjYSB', 'Data Transaksi', 'Transaksi', 'Menampilkan Data Transaksi'),
(62, 'w8xdO79t7kdEeyBSxLJ', 'Rekap Transaksi', 'Transaksi', 'Rekap Transaksi'),
(63, 'ihTHNu1ROJ28tpP2LlH', 'Bagi Hasil', 'Keuangan', 'Halaman bagi hasil'),
(64, 'TiBoTS2YqPyx6IhtTKA', 'Akun Perkiraan', 'Keuangan', 'Halaman Akun Perkiraan'),
(65, 'qLECdqLVgBMjV0BXHUC', 'Pengaturan Umum', 'Pengaturan', 'Halaman Pengaturan Aplikasi'),
(66, 'eQhEWIf1fV6xwMNr8J9', 'Auto Jurnal', 'Pengaturan', 'Pengaturan Auto Jurnal'),
(67, 'bKPVUZqfF6PCQk3ydzY', 'Simpan Pinjam', 'Laporan', 'Halaman laporan rekapitulasi simpan pinjam'),
(68, 'PXbSX4aNtpkqrcEBmyG', 'Riwayat Anggota', 'Laporan', 'Halaman yang menampilkan data riwayat simpanan/pinjaman anggota'),
(69, 'sPkDxRYJPn1A8K24ki2', 'Barang', 'Barang', 'Halaman untuk mengelola data barang'),
(70, 'YyU3kA2xi9HqU1EMuTm', 'Batch dan Expired', 'Barang', 'Halaman untuk mengelola data batch barang dan expire date'),
(71, 'PLj70Mfj5dhUUvjZqnd', 'Stock Opename', 'Barang', 'Halaman yang berfungsi untuk mencatat kegiatan stock opname'),
(72, 'AQKs9kSv0Bph4ycGNUj', 'Penjualan', 'Penjualan', 'Halaman untuk mengelola data transaksi penjualan'),
(73, 'hE3ordTLe9KBwSRO3t5', 'Tambah Penjualan', 'Penjualan', 'Halaman mandiri untuk menambahkan data transaksi penjualan'),
(74, 'Ay1ssiaoRqiK70E9HM6', 'Detail Transaksi Penjualan', 'Penjualan', 'Halaman yang menampilkan data detail transaksi'),
(75, 'UQsVaygjqekgPYZWHpM', 'Jenis Pinjaman', 'Pinjaman', 'Mengelola jenis pinjaman'),
(76, 'LTBuBzSi7njYRiLe6la', 'Halaman Pembelian', 'Pembelian', 'Halaman untuk mencatat pembelian'),
(77, 'hBjWkLMFofA8QHRz8C7', 'Tambah Pembelian', 'Pembelian', 'Halaman untuk menambah transaksi pembelian'),
(78, 'va9SiDMNXdRPjqLeVcX', 'Detail Pembelian', 'Pembelian', 'Halaman untuk melihat detail pembelian'),
(79, 'ungKMcHQ0OvFgMhS1y8', 'Rekap Jual Beli', 'Transaksi', 'Halaman Untuk Menampilkan Rekap Jual Beli'),
(80, 'gw5VTLLVsrfg63nfEWX', 'Utang Piutang', 'Transaksi', 'Halaman untuk menampilkan utang-piutang transaksi'),
(81, 'WeXKEzh9uvvyJRCwJGX', 'Detail Anggota', 'Anggota', 'Halaman untuk melihat anggota'),
(82, 'xMAQQmh4DYnyd3JG26J', 'Hapus Konten Bantuan', 'Bantuan', 'Fitur hapus bantuan'),
(83, 'MqOJHVudKBTAhgjU0xl', 'Lihat Detail Bantuan', 'Bantuan', 'Halaman detail bantuan');

-- --------------------------------------------------------

--
-- Table structure for table `akses_ijin`
--

DROP TABLE IF EXISTS `akses_ijin`;
CREATE TABLE IF NOT EXISTS `akses_ijin` (
  `id_akses` int NOT NULL,
  `id_akses_fitur` int NOT NULL,
  `kode` varchar(32) NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  KEY `id_akses` (`id_akses`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_ijin`
--

INSERT INTO `akses_ijin` (`id_akses`, `id_akses_fitur`, `kode`, `nama`, `kategori`) VALUES
(4, 42, 'oWpF1xPn8dLgRi8hRJx', 'Halaman Anggota', 'Anggota'),
(4, 45, 'N6O5Qc64hOEhPQukZSh', 'Laba Rugi', 'Laporan'),
(4, 36, 'mU0dghJfZr6GFXAazZ8', 'Komponen Gaji', 'Penggajian'),
(4, 37, 'RAkbS0nrHV10GVxnvXy', 'Peride Gaji', 'Penggajian'),
(4, 38, 'wY4kURZ8cjrjjtUiAhH', 'Potongan Gaji', 'Penggajian'),
(4, 44, 'JxjfFOxUHimcP0WXqy0', 'Halaman pinjaman', 'Pinjaman'),
(4, 43, 'n77olEDwon5RO3RYQPD', 'Halaman Simpanan', 'Simpanan'),
(6, 35, 'QcDypIyCg8tX76Zzs2I', 'Akses Token', 'Akses'),
(6, 32, 'FGPgsQeVDKPGoQPNGJH', 'Akun Pengguna', 'Akses'),
(6, 31, '8KbdfArJ7UmoX916kO7', 'Entitas Akses', 'Akses'),
(6, 40, 'rA8MRFArw1qPeVySjAC', 'Fitur Aplikasi', 'Akses'),
(6, 41, 'hNtci80mXl9jwCj19pI', 'Halaman Entitas Akses', 'Akses'),
(6, 54, 'TQ4YLRadAceDvjmoKIN', 'Anggota Keluar Masuk', 'Anggota'),
(6, 42, 'oWpF1xPn8dLgRi8hRJx', 'Halaman Anggota', 'Anggota'),
(6, 55, 'HdQ2YaxtqY2JL5QnQdS', 'Rekap Anggota', 'Anggota'),
(6, 48, 'QbQ4qF57AzCEp5qG0KG', 'Form Tambah Bantuan', 'Bantuan'),
(6, 49, 'GA4iqizxbIlTU5mMo0W', 'Halaman Edit Bantuan', 'Bantuan'),
(6, 47, '5MH1cfu7LzOpalmhbT2', 'Kelola Data Bantuan', 'Bantuan'),
(6, 69, 'sPkDxRYJPn1A8K24ki2', 'Barang', 'Barang'),
(6, 70, 'YyU3kA2xi9HqU1EMuTm', 'Batch dan Expired', 'Barang'),
(6, 71, 'PLj70Mfj5dhUUvjZqnd', 'Stock Opename', 'Barang'),
(6, 64, 'TiBoTS2YqPyx6IhtTKA', 'Akun Perkiraan', 'Keuangan'),
(6, 63, 'ihTHNu1ROJ28tpP2LlH', 'Bagi Hasil', 'Keuangan'),
(6, 50, 'VTouzOD2eM57Onno1Ql', 'Jurnal', 'Keuangan'),
(6, 52, 'n6quFiiDojCgimfkCT7', 'Buku Besar', 'Laporan'),
(6, 45, 'N6O5Qc64hOEhPQukZSh', 'Laba Rugi', 'Laporan'),
(6, 53, 'incMmh5yyCmCs4IwCYz', 'Neraca Saldo', 'Laporan'),
(6, 68, 'PXbSX4aNtpkqrcEBmyG', 'Riwayat Anggota', 'Laporan'),
(6, 67, 'bKPVUZqfF6PCQk3ydzY', 'Simpan Pinjam', 'Laporan'),
(6, 39, 'gd7YgKyL1WMQctJLgaq', 'API Key', 'Pengaturan'),
(6, 66, 'eQhEWIf1fV6xwMNr8J9', 'Auto Jurnal', 'Pengaturan'),
(6, 34, 'rfLn8WEkAqzC1gu5z45', 'Email Gateway', 'Pengaturan'),
(6, 65, 'qLECdqLVgBMjV0BXHUC', 'Pengaturan Umum', 'Pengaturan'),
(6, 36, 'mU0dghJfZr6GFXAazZ8', 'Komponen Gaji', 'Penggajian'),
(6, 37, 'RAkbS0nrHV10GVxnvXy', 'Peride Gaji', 'Penggajian'),
(6, 38, 'wY4kURZ8cjrjjtUiAhH', 'Potongan Gaji', 'Penggajian'),
(6, 44, 'JxjfFOxUHimcP0WXqy0', 'Halaman pinjaman', 'Pinjaman'),
(6, 59, 'hAhdWGrGGtjeMqhAAtD', 'Rekap Pinjaman', 'Pinjaman'),
(6, 46, 'X61viKZwNQuNrQ1Vrrg', 'Tagihan', 'Pinjaman'),
(6, 43, 'n77olEDwon5RO3RYQPD', 'Halaman Simpanan', 'Simpanan'),
(6, 56, 'TruxAyhHOhvTrVYs6No', 'Jenis Simpanan', 'Simpanan'),
(6, 58, '0uITsO9Ci4O394dsIyu', 'Rekap Simpanan', 'Simpanan'),
(6, 57, 'dG22CVGrX1KNMQpn7Se', 'Simpanan Wajib', 'Simpanan'),
(6, 61, 'RZufXfHVLW9f0EsjYSB', 'Data Transaksi', 'Transaksi'),
(6, 74, 'Ay1ssiaoRqiK70E9HM6', 'Detail Transaksi Penjualan', 'Penjualan'),
(6, 60, 'vC4W81sLCdsIGabUEMi', 'Jenis Transaksi', 'Transaksi'),
(6, 72, 'AQKs9kSv0Bph4ycGNUj', 'Penjualan', 'Penjualan'),
(6, 62, 'w8xdO79t7kdEeyBSxLJ', 'Rekap Transaksi', 'Transaksi'),
(6, 73, 'hE3ordTLe9KBwSRO3t5', 'Tambah Penjualan', 'Penjualan'),
(5, 35, 'QcDypIyCg8tX76Zzs2I', 'Akses Token', 'Akses'),
(5, 32, 'FGPgsQeVDKPGoQPNGJH', 'Akun Pengguna', 'Akses'),
(5, 31, '8KbdfArJ7UmoX916kO7', 'Entitas Akses', 'Akses'),
(5, 40, 'rA8MRFArw1qPeVySjAC', 'Fitur Aplikasi', 'Akses'),
(5, 41, 'hNtci80mXl9jwCj19pI', 'Halaman Entitas Akses', 'Akses'),
(5, 54, 'TQ4YLRadAceDvjmoKIN', 'Anggota Keluar Masuk', 'Anggota'),
(5, 42, 'oWpF1xPn8dLgRi8hRJx', 'Halaman Anggota', 'Anggota'),
(5, 55, 'HdQ2YaxtqY2JL5QnQdS', 'Rekap Anggota', 'Anggota'),
(5, 48, 'QbQ4qF57AzCEp5qG0KG', 'Form Tambah Bantuan', 'Bantuan'),
(5, 49, 'GA4iqizxbIlTU5mMo0W', 'Halaman Edit Bantuan', 'Bantuan'),
(5, 47, '5MH1cfu7LzOpalmhbT2', 'Kelola Data Bantuan', 'Bantuan'),
(5, 69, 'sPkDxRYJPn1A8K24ki2', 'Barang', 'Barang'),
(5, 70, 'YyU3kA2xi9HqU1EMuTm', 'Batch dan Expired', 'Barang'),
(5, 71, 'PLj70Mfj5dhUUvjZqnd', 'Stock Opename', 'Barang'),
(5, 64, 'TiBoTS2YqPyx6IhtTKA', 'Akun Perkiraan', 'Keuangan'),
(5, 63, 'ihTHNu1ROJ28tpP2LlH', 'Bagi Hasil', 'Keuangan'),
(5, 50, 'VTouzOD2eM57Onno1Ql', 'Jurnal', 'Keuangan'),
(5, 52, 'n6quFiiDojCgimfkCT7', 'Buku Besar', 'Laporan'),
(5, 45, 'N6O5Qc64hOEhPQukZSh', 'Laba Rugi', 'Laporan'),
(5, 53, 'incMmh5yyCmCs4IwCYz', 'Neraca Saldo', 'Laporan'),
(5, 68, 'PXbSX4aNtpkqrcEBmyG', 'Riwayat Anggota', 'Laporan'),
(5, 67, 'bKPVUZqfF6PCQk3ydzY', 'Simpan Pinjam', 'Laporan'),
(5, 39, 'gd7YgKyL1WMQctJLgaq', 'API Key', 'Pengaturan'),
(5, 66, 'eQhEWIf1fV6xwMNr8J9', 'Auto Jurnal', 'Pengaturan'),
(5, 34, 'rfLn8WEkAqzC1gu5z45', 'Email Gateway', 'Pengaturan'),
(5, 65, 'qLECdqLVgBMjV0BXHUC', 'Pengaturan Umum', 'Pengaturan'),
(5, 36, 'mU0dghJfZr6GFXAazZ8', 'Komponen Gaji', 'Penggajian'),
(5, 37, 'RAkbS0nrHV10GVxnvXy', 'Peride Gaji', 'Penggajian'),
(5, 38, 'wY4kURZ8cjrjjtUiAhH', 'Potongan Gaji', 'Penggajian'),
(5, 44, 'JxjfFOxUHimcP0WXqy0', 'Halaman pinjaman', 'Pinjaman'),
(5, 59, 'hAhdWGrGGtjeMqhAAtD', 'Rekap Pinjaman', 'Pinjaman'),
(5, 46, 'X61viKZwNQuNrQ1Vrrg', 'Tagihan', 'Pinjaman'),
(5, 43, 'n77olEDwon5RO3RYQPD', 'Halaman Simpanan', 'Simpanan'),
(5, 56, 'TruxAyhHOhvTrVYs6No', 'Jenis Simpanan', 'Simpanan'),
(5, 58, '0uITsO9Ci4O394dsIyu', 'Rekap Simpanan', 'Simpanan'),
(5, 57, 'dG22CVGrX1KNMQpn7Se', 'Simpanan Wajib', 'Simpanan'),
(5, 61, 'RZufXfHVLW9f0EsjYSB', 'Data Transaksi', 'Transaksi'),
(5, 74, 'Ay1ssiaoRqiK70E9HM6', 'Detail Transaksi Penjualan', 'Penjualan'),
(5, 60, 'vC4W81sLCdsIGabUEMi', 'Jenis Transaksi', 'Transaksi'),
(5, 72, 'AQKs9kSv0Bph4ycGNUj', 'Penjualan', 'Penjualan'),
(5, 62, 'w8xdO79t7kdEeyBSxLJ', 'Rekap Transaksi', 'Transaksi'),
(5, 73, 'hE3ordTLe9KBwSRO3t5', 'Tambah Penjualan', 'Penjualan'),
(1, 35, 'QcDypIyCg8tX76Zzs2I', 'Akses Token', 'Akses'),
(1, 32, 'FGPgsQeVDKPGoQPNGJH', 'Akun Pengguna', 'Akses'),
(1, 31, '8KbdfArJ7UmoX916kO7', 'Entitas Akses', 'Akses'),
(1, 40, 'rA8MRFArw1qPeVySjAC', 'Fitur Aplikasi', 'Akses'),
(1, 41, 'hNtci80mXl9jwCj19pI', 'Halaman Entitas Akses', 'Akses'),
(1, 54, 'TQ4YLRadAceDvjmoKIN', 'Anggota Keluar Masuk', 'Anggota'),
(1, 81, 'WeXKEzh9uvvyJRCwJGX', 'Detail Anggota', 'Anggota'),
(1, 42, 'oWpF1xPn8dLgRi8hRJx', 'Halaman Anggota', 'Anggota'),
(1, 55, 'HdQ2YaxtqY2JL5QnQdS', 'Rekap Anggota', 'Anggota'),
(1, 48, 'QbQ4qF57AzCEp5qG0KG', 'Form Tambah Bantuan', 'Bantuan'),
(1, 49, 'GA4iqizxbIlTU5mMo0W', 'Halaman Edit Bantuan', 'Bantuan'),
(1, 82, 'xMAQQmh4DYnyd3JG26J', 'Hapus Konten Bantuan', 'Bantuan'),
(1, 47, '5MH1cfu7LzOpalmhbT2', 'Kelola Data Bantuan', 'Bantuan'),
(1, 83, 'MqOJHVudKBTAhgjU0xl', 'Lihat Detail Bantuan', 'Bantuan'),
(1, 69, 'sPkDxRYJPn1A8K24ki2', 'Barang', 'Barang'),
(1, 70, 'YyU3kA2xi9HqU1EMuTm', 'Batch dan Expired', 'Barang'),
(1, 71, 'PLj70Mfj5dhUUvjZqnd', 'Stock Opename', 'Barang'),
(1, 64, 'TiBoTS2YqPyx6IhtTKA', 'Akun Perkiraan', 'Keuangan'),
(1, 63, 'ihTHNu1ROJ28tpP2LlH', 'Bagi Hasil', 'Keuangan'),
(1, 50, 'VTouzOD2eM57Onno1Ql', 'Jurnal', 'Keuangan'),
(1, 52, 'n6quFiiDojCgimfkCT7', 'Buku Besar', 'Laporan'),
(1, 45, 'N6O5Qc64hOEhPQukZSh', 'Laba Rugi', 'Laporan'),
(1, 53, 'incMmh5yyCmCs4IwCYz', 'Neraca Saldo', 'Laporan'),
(1, 68, 'PXbSX4aNtpkqrcEBmyG', 'Riwayat Anggota', 'Laporan'),
(1, 67, 'bKPVUZqfF6PCQk3ydzY', 'Simpan Pinjam', 'Laporan'),
(1, 78, 'va9SiDMNXdRPjqLeVcX', 'Detail Pembelian', 'Pembelian'),
(1, 76, 'LTBuBzSi7njYRiLe6la', 'Halaman Pembelian', 'Pembelian'),
(1, 77, 'hBjWkLMFofA8QHRz8C7', 'Tambah Pembelian', 'Pembelian'),
(1, 39, 'gd7YgKyL1WMQctJLgaq', 'API Key', 'Pengaturan'),
(1, 66, 'eQhEWIf1fV6xwMNr8J9', 'Auto Jurnal', 'Pengaturan'),
(1, 34, 'rfLn8WEkAqzC1gu5z45', 'Email Gateway', 'Pengaturan'),
(1, 65, 'qLECdqLVgBMjV0BXHUC', 'Pengaturan Umum', 'Pengaturan'),
(1, 36, 'mU0dghJfZr6GFXAazZ8', 'Komponen Gaji', 'Penggajian'),
(1, 37, 'RAkbS0nrHV10GVxnvXy', 'Peride Gaji', 'Penggajian'),
(1, 38, 'wY4kURZ8cjrjjtUiAhH', 'Potongan Gaji', 'Penggajian'),
(1, 74, 'Ay1ssiaoRqiK70E9HM6', 'Detail Transaksi Penjualan', 'Penjualan'),
(1, 72, 'AQKs9kSv0Bph4ycGNUj', 'Penjualan', 'Penjualan'),
(1, 73, 'hE3ordTLe9KBwSRO3t5', 'Tambah Penjualan', 'Penjualan'),
(1, 44, 'JxjfFOxUHimcP0WXqy0', 'Halaman pinjaman', 'Pinjaman'),
(1, 75, 'UQsVaygjqekgPYZWHpM', 'Jenis Pinjaman', 'Pinjaman'),
(1, 59, 'hAhdWGrGGtjeMqhAAtD', 'Rekap Pinjaman', 'Pinjaman'),
(1, 46, 'X61viKZwNQuNrQ1Vrrg', 'Tagihan', 'Pinjaman'),
(1, 43, 'n77olEDwon5RO3RYQPD', 'Halaman Simpanan', 'Simpanan'),
(1, 56, 'TruxAyhHOhvTrVYs6No', 'Jenis Simpanan', 'Simpanan'),
(1, 58, '0uITsO9Ci4O394dsIyu', 'Rekap Simpanan', 'Simpanan'),
(1, 57, 'dG22CVGrX1KNMQpn7Se', 'Simpanan Wajib', 'Simpanan'),
(1, 61, 'RZufXfHVLW9f0EsjYSB', 'Data Transaksi', 'Transaksi'),
(1, 60, 'vC4W81sLCdsIGabUEMi', 'Jenis Transaksi', 'Transaksi'),
(1, 79, 'ungKMcHQ0OvFgMhS1y8', 'Rekap Jual Beli', 'Transaksi'),
(1, 62, 'w8xdO79t7kdEeyBSxLJ', 'Rekap Transaksi', 'Transaksi'),
(1, 80, 'gw5VTLLVsrfg63nfEWX', 'Utang Piutang', 'Transaksi');

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
(6, 'Pengurus', 'ea5e56384fde76e479d35ad725c068fd', '2025-02-26 00:53:56', '2025-02-26 02:21:57'),
(1, 'Pengurus', '0627592a52270e6d0683812f41c48795', '2025-04-03 00:15:45', '2025-04-03 06:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `akses_referensi`
--

DROP TABLE IF EXISTS `akses_referensi`;
CREATE TABLE IF NOT EXISTS `akses_referensi` (
  `id_akses_referensi` int NOT NULL AUTO_INCREMENT,
  `uuid_akses_entitas` varchar(32) NOT NULL,
  `id_akses_fitur` int NOT NULL,
  PRIMARY KEY (`id_akses_referensi`),
  KEY `uuid_akses_entitas` (`uuid_akses_entitas`),
  KEY `id_akses_fitur` (`id_akses_fitur`)
) ENGINE=InnoDB AUTO_INCREMENT=987 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_referensi`
--

INSERT INTO `akses_referensi` (`id_akses_referensi`, `uuid_akses_entitas`, `id_akses_fitur`) VALUES
(1, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 42),
(2, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 45),
(3, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 36),
(4, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 37),
(5, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 38),
(6, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 44),
(7, 'x5MHSyAQsnniwnwgYqho6hTwKRhxgOXU', 43),
(936, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 35),
(937, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 32),
(938, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 31),
(939, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 40),
(940, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 41),
(941, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 54),
(942, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 81),
(943, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 42),
(944, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 55),
(945, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 48),
(946, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 49),
(947, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 82),
(948, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 47),
(949, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 83),
(950, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 69),
(951, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 70),
(952, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 71),
(953, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 64),
(954, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 63),
(955, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 50),
(956, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 52),
(957, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 45),
(958, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 53),
(959, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 68),
(960, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 67),
(961, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 78),
(962, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 76),
(963, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 77),
(964, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 39),
(965, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 66),
(966, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 34),
(967, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 65),
(968, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 36),
(969, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 37),
(970, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 38),
(971, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 74),
(972, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 72),
(973, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 73),
(974, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 44),
(975, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 75),
(976, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 59),
(977, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 46),
(978, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 43),
(979, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 56),
(980, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 58),
(981, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 57),
(982, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 61),
(983, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 60),
(984, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 79),
(985, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 62),
(986, 'hkobwSGykIYhh3AZGNJqhzeohg7k9ORA', 80);

-- --------------------------------------------------------

--
-- Table structure for table `akses_validasi`
--

DROP TABLE IF EXISTS `akses_validasi`;
CREATE TABLE IF NOT EXISTS `akses_validasi` (
  `id_akses_validasi` int NOT NULL AUTO_INCREMENT,
  `id_akses_anggota` int NOT NULL,
  `token` text NOT NULL,
  `datetime` text NOT NULL,
  PRIMARY KEY (`id_akses_validasi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_validasi`
--

INSERT INTO `akses_validasi` (`id_akses_validasi`, `id_akses_anggota`, `token`, `datetime`) VALUES
(3, 2, '50e17bf06d0d8e5b856aa6ace83b0b', '2023-02-17 19:50:43');

-- --------------------------------------------------------

--
-- Table structure for table `akun_perkiraan`
--

DROP TABLE IF EXISTS `akun_perkiraan`;
CREATE TABLE IF NOT EXISTS `akun_perkiraan` (
  `id_perkiraan` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) DEFAULT NULL,
  `nama` text,
  `level` int NOT NULL,
  `saldo_normal` varchar(10) NOT NULL COMMENT 'Debet, Kredit',
  `kd1` varchar(25) DEFAULT NULL,
  `kd2` varchar(25) DEFAULT NULL,
  `kd3` varchar(25) DEFAULT NULL,
  `kd4` varchar(25) DEFAULT NULL,
  `kd5` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_perkiraan`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun_perkiraan`
--

INSERT INTO `akun_perkiraan` (`id_perkiraan`, `kode`, `nama`, `level`, `saldo_normal`, `kd1`, `kd2`, `kd3`, `kd4`, `kd5`) VALUES
(1, '1', 'Aset', 1, 'Debet', '1', NULL, NULL, NULL, NULL),
(2, '2', 'Kewajiban', 1, 'Kredit', '2', NULL, NULL, NULL, NULL),
(3, '3', 'Ekuitas', 1, 'Kredit', '3', NULL, NULL, NULL, NULL),
(4, '4', 'Pendapatan', 1, 'Kredit', '4', NULL, NULL, NULL, NULL),
(17, '5', 'Beban Usaha', 1, 'Debet', '5', NULL, NULL, NULL, NULL),
(18, '1.1', 'Aset Lancar', 2, 'Debet', '1', '1.1', NULL, NULL, NULL),
(23, '1.2', 'Aset Tetap', 2, 'Debet', '1', '1.2', NULL, NULL, NULL),
(25, '1.2.2', 'Gedung Dan Bangunan', 3, 'Debet', '1', '1.2', '1.2.2', NULL, NULL),
(27, '2.1', 'Kewajiban Jangka Pendek', 2, 'Kredit', '2', '2.1', NULL, NULL, NULL),
(28, '2.1.1', 'Hutang Usaha', 3, 'Kredit', '2', '2.1', '2.1.1', NULL, NULL),
(29, '2.1.2', 'Hutang Pajak', 3, 'Kredit', '2', '2.1', '2.1.2', NULL, NULL),
(30, '3.1', 'Ekuitas Awal', 2, 'Kredit', '3', '3.1', NULL, NULL, NULL),
(31, '3.2', 'Surplus Dan Defisit', 2, 'Kredit', '3', '3.2', NULL, NULL, NULL),
(36, '5.1', 'Beban Administrasi Dan Umum', 2, 'Debet', '5', '5.1', NULL, NULL, NULL),
(38, '5.3', 'Beban Operasional', 2, 'Debet', '5', '5.3', NULL, NULL, NULL),
(65, '1.2.4', 'Jalan Dan Jaringan', 3, 'Debet', '1', '1.2', '1.2.4', NULL, NULL),
(66, '1.2.4.1', 'Jaringan Listrik', 4, 'Debet', '1', '1.2', '1.2.4', '1.2.4.1', NULL),
(73, '1.3', 'Aset Lainnya', 2, 'Debet', '1', '1.3', NULL, NULL, NULL),
(77, '2.1.3', 'Hutang Lainnya', 3, 'Kredit', '2', '2.1', '2.1.3', NULL, NULL),
(78, '3.2.1', 'Surplus Dan Defisit Tahun Lalu', 3, 'Kredit', '3', '3.2', '3.2.1', NULL, NULL),
(79, '3.2.2', 'Surplus Dan Defisit Tahun Berjalan', 3, 'Kredit', '3', '3.2', '3.2.2', NULL, NULL),
(80, '5.1.1', 'Beban Gaji', 3, 'Debet', '5', '5.1', '5.1.1', NULL, NULL),
(81, '5.1.2', 'Beban Adm. Kendaraan', 3, 'Debet', '5', '5.1', '5.1.2', NULL, NULL),
(82, '5.1.3', 'Beban Asuransi', 3, 'Debet', '5', '5.1', '5.1.3', NULL, NULL),
(83, '5.1.4', 'Beban PBB', 3, 'Debet', '5', '5.1', '5.1.4', NULL, NULL),
(84, '5.1.5', 'Beban Restribusi', 3, 'Debet', '5', '5.1', '5.1.5', NULL, NULL),
(85, '5.1.6', 'Beban Diklat', 3, 'Debet', '5', '5.1', '5.1.6', NULL, NULL),
(86, '5.1.7', 'Perizinan', 3, 'Debet', '5', '5.1', '5.1.7', NULL, NULL),
(87, '5.1.8', 'Pajak Air', 3, 'Debet', '5', '5.1', '5.1.8', NULL, NULL),
(95, '5.3.1', 'Beban Pembelian Koran', 3, 'Debet', '5', '5.3', '5.3.1', NULL, NULL),
(96, '5.3.2', 'Beban Air Minum', 3, 'Debet', '5', '5.3', '5.3.2', NULL, NULL),
(98, '5.3.4', 'Beban Utilitas', 3, 'Debet', '5', '5.3', '5.3.4', NULL, NULL),
(100, '5.3.6', 'Beban Konsumsi', 3, 'Debet', '5', '5.3', '5.3.6', NULL, NULL),
(101, '5.3.7', 'Beban Pemeliharaan Kendaraan', 3, 'Debet', '5', '5.3', '5.3.7', NULL, NULL),
(102, '5.3.8', 'Beban Pemeliharaan Bangunan', 3, 'Debet', '5', '5.3', '5.3.8', NULL, NULL),
(105, '5.3.10', 'Beban Pemeliharaan Alat Kantor', 3, 'Debet', '5', '5.3', '5.3.10', NULL, NULL),
(110, '5.3.11', 'Beban Penyusutan Bangunan', 3, 'Debet', '5', '5.3', '5.3.11', NULL, NULL),
(111, '5.3.12', 'Beban Penyusutan Alat Belajar', 3, 'Debet', '5', '5.3', '5.3.12', NULL, NULL),
(112, '5.3.13', 'Penyusutan Kendaraan', 3, 'Debet', '5', '5.3', '5.3.13', NULL, NULL),
(113, '5.3.14', 'Beban Promosi', 3, 'Debet', '5', '5.3', '5.3.14', NULL, NULL),
(114, '5.3.15', 'Beban Listrik', 3, 'Debet', '5', '5.3', '5.3.15', NULL, NULL),
(119, '5.4', 'Beban Lainnya', 2, 'Debet', '5', '5.4', NULL, NULL, NULL),
(120, '1.1.1', 'kas', 3, 'Debet', '1', '1.1', '1.1.1', NULL, NULL),
(121, '1.1.1.1', 'Kas Kecil', 4, 'Debet', '1', '1.1', '1.1.1', '1.1.1.1', NULL),
(122, '1.1.1.2', 'Kas Bank', 4, 'Debet', '1', '1.1', '1.1.1', '1.1.1.2', NULL),
(123, '1.2.4.2', 'Lahan/Tanah', 4, 'Debet', '1', '1.2', '1.2.4', '1.2.4.2', NULL),
(125, '1.1.2', 'Persediaan Peralatan', 3, 'Debet', '1', '1.1', '1.1.2', NULL, NULL),
(130, '1.3.1', 'Aset Saham Di Perusahaan Lain', 3, 'Debet', '1', '1.3', '1.3.1', NULL, NULL),
(131, '1.3.2', 'Aset Sisa BHP', 3, 'Debet', '1', '1.3', '1.3.2', NULL, NULL),
(133, '2.2', 'Kewajiban Pembayaran Prive Investor', 2, 'Kredit', '2', '2.2', NULL, NULL, NULL),
(134, '1.3.3', 'Aset Lainnya', 3, 'Debet', '1', '1.3', '1.3.3', NULL, NULL),
(135, '1.1.1.3', 'Kas Berangkas', 4, 'Debet', '1', '1.1', '1.1.1', '1.1.1.3', NULL),
(136, '1.1.3', 'Piutang usaha', 3, 'Debet', '1', '1.1', '1.1.3', NULL, NULL),
(147, '5.3.14.1', 'Beban Promosi Iklan Digital', 4, 'Debet', '5', '5.3', '5.3.14', '5.3.14.1', NULL),
(148, '5.3.14.2', 'Beban Promosi Iklan Koran', 4, 'Debet', '5', '5.3', '5.3.14', '5.3.14.2', NULL),
(149, '1.1.1.2.1', 'Kas Bank BRI', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.2', '1.1.1.2.1'),
(151, '1.1.1.2.2', 'Kas Bank Central Asia', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.2', '1.1.1.2.2'),
(152, '1.1.1.2.3', 'Kas Bank Mandiri', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.2', '1.1.1.2.3'),
(154, '1.1.1.2.5', 'Kas Bank Jabar', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.2', '1.1.1.2.5'),
(155, '1.1.1.1.1', 'Kas Brangkas', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.1', '1.1.1.1.1'),
(159, '1.1.1.1.2', 'Kas Kecil Keuangan', 5, 'Debet', '1', '1.1', '1.1.1', '1.1.1.1', '1.1.1.1.2'),
(160, '4.1', 'Pendapatan Jasa', 2, 'Kredit', '4', '4.1', NULL, NULL, NULL),
(161, '4.2', 'Pendapatan Denda', 2, 'Kredit', '4', '4.2', NULL, NULL, NULL),
(162, '1.1.3.4', 'Pinjaman Anggota', 4, 'Debet', '1', '1.1', '1.1.3', '1.1.3.4', NULL),
(163, '2.3', 'Simpanan Anggota', 2, 'Kredit', '2', '2.3', NULL, NULL, NULL);

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
  `password` text COMMENT 'MD5 hanya untuk yang memiliki akses',
  `kontak` varchar(20) DEFAULT NULL,
  `lembaga` varchar(255) DEFAULT NULL,
  `ranking` int DEFAULT NULL,
  `foto` char(40) DEFAULT NULL,
  `akses_anggota` tinyint(1) NOT NULL COMMENT 'true/false',
  `status` varchar(10) NOT NULL COMMENT 'Aktif, Keluar',
  `alasan_keluar` text COMMENT 'Diisi Hanya Apabila Keluar',
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `tanggal_masuk`, `tanggal_keluar`, `nip`, `nama`, `email`, `password`, `kontak`, `lembaga`, `ranking`, `foto`, `akses_anggota`, `status`, `alasan_keluar`) VALUES
(1, '2024-01-13', '2024-07-14', '2024/07/Contoh-01', 'Adam Saputra', 'adamsaputra@example.com', 'adamsaputra', '890000001', 'GIS', 1, '7348a3c3e1db1cfe8b9867cf88e854.jpg', 1, 'Aktif', ''),
(2, '2024-01-14', '2024-07-14', '2024/07/Contoh-02', 'Budi Santoso', 'budi.santoso@example.com', 'anggota2', '890000002', 'GIS', 1, '', 1, 'Aktif', ''),
(3, '2024-01-15', '2024-07-14', '2024/07/Contoh-111', 'Citra Dewi', 'citra.dewi@example.com', 'anggota3', '890000003', 'GIS', 1, '', 1, 'Aktif', ''),
(4, '2024-01-16', '2024-06-14', '2024/07/Contoh-04', 'Dian Rahmawati', 'dian.rahmawati@example.com', 'anggota4', '890000004', 'GIS', 1, '', 1, 'Keluar', 'Tidak betah'),
(5, '2024-01-17', '2024-07-14', '2024/07/Contoh-05', 'Eka Prasetyo', 'eka.prasetyo@example.com', 'anggota5', '890000005', 'GIS', 1, '', 1, 'Aktif', ''),
(6, '2024-01-18', '2024-07-14', '2024/07/Contoh-06', 'Farah Amalia', 'farah.amalia@example.com', 'anggota6', '890000006', 'GIS', 2, '', 1, 'Aktif', ''),
(7, '2024-01-19', '2024-07-14', '2024/07/Contoh-07', 'Guntur Wibowo', 'guntur.wibowo@example.com', 'anggota7', '890000007', 'GIS', 2, '', 1, 'Aktif', ''),
(8, '2024-01-20', '2024-06-14', '2024/07/Contoh-08', 'Hendra Wijaya', 'hendra.wijaya@example.com', 'anggota8', '890000008', 'GIS', 2, '', 1, 'Keluar', ''),
(9, '2024-01-21', '2024-07-14', '2024/07/Contoh-09', 'Indah Permatasari', 'indah.permatasari@example.com', 'anggota9', '890000009', 'GIS', 2, '', 1, 'Aktif', ''),
(10, '2024-01-22', '2024-07-14', '2024/07/Contoh-10', 'Joko Susanto', 'joko.susanto@example.com', 'anggota10', '890000010', 'GIS', 2, '', 1, 'Aktif', ''),
(11, '2024-01-23', '2024-07-14', '2024/07/Contoh-11', 'Karina Putri', 'karina.putri@example.com', 'anggota11', '890000011', 'GIS', 1, '6e768c8545787762e097543ecd20c7.jpg', 1, 'Aktif', ''),
(12, '2024-01-24', '2024-07-14', '2024/07/Contoh-12', 'Leo Pradipta', 'leo.pradipta@example.com', 'anggota12', '890000012', 'GIS', 1, '', 1, 'Aktif', ''),
(13, '2024-01-25', '2024-07-14', '2024/07/Contoh-13', 'Maya Sari', 'maya.sari@example.com', 'anggota13', '890000013', 'GIS', 1, '', 1, 'Aktif', ''),
(14, '2024-01-26', '2024-07-14', '2024/07/Contoh-14', 'Nanda Kusuma', 'nanda.kusuma@example.com', 'anggota14', '890000014', 'GIS', 1, '', 1, 'Aktif', ''),
(15, '2024-01-27', '2024-07-14', '2024/07/Contoh-15', 'Oki Pratama', 'oki.pratama@example.com', 'anggota15', '890000015', 'GIS', 1, '', 1, 'Aktif', ''),
(16, '2024-01-28', '2024-07-14', '2024/07/Contoh-16', 'Putri Ayu', 'putri.ayu@example.com', 'anggota16', '890000016', 'GIS', 2, '', 1, 'Aktif', ''),
(17, '2024-01-29', '2024-06-14', '2024/07/Contoh-17', 'Rizki Setiawan', 'rizki.setiawan@example.com', 'anggota17', '890000017', 'GIS', 2, '', 1, 'Keluar', ''),
(18, '2024-01-30', '2024-07-14', '2024/07/Contoh-18', 'Sinta Maharani', 'sinta.maharani@example.com', 'anggota18', '890000018', 'GIS', 2, '', 1, 'Aktif', ''),
(19, '2024-01-31', '2024-07-14', '2024/07/Contoh-19', 'Tio Nugroho', 'tio.nugroho@example.com', 'anggota19', '890000019', 'GIS', 2, '', 1, 'Aktif', ''),
(22, '2024-09-21', '2024-09-21', '123122221', 'Aruna Parasilva', 'windy1234@gmail.com', 'windy1234', '08961767868', 'GIS', 1, 'c439400d30763463f3b9b2bcd0169c.png', 1, 'Aktif', ''),
(23, '2025-02-01', '2025-02-22', '1111111111111', 'Tri Heru', 'triheruafsheen@gmail.com', '12345678', '085217731586', 'GIS', 1, '', 1, 'Aktif', ''),
(24, '2025-01-01', '2025-02-23', '2222222222', 'Sugito', 'gito@gmail.com', '1234', '0852323242421', 'GIS', 1, '', 1, 'Aktif', ''),
(25, '2024-02-01', '2025-02-23', '2024/07/Contoh-20', 'Ulya Handayani', 'ulya.handayani@example.com', 'anggota20', '890000020', 'Lembaga B', 2, '', 1, 'Aktif', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auto_jurnal`
--

DROP TABLE IF EXISTS `auto_jurnal`;
CREATE TABLE IF NOT EXISTS `auto_jurnal` (
  `id_auto_jurnal` int NOT NULL AUTO_INCREMENT,
  `kategori_transaksi` text NOT NULL,
  `debet_id` int DEFAULT NULL,
  `debet_name` text,
  `kredit_id` int DEFAULT NULL,
  `kredit_name` text,
  PRIMARY KEY (`id_auto_jurnal`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_jurnal`
--

INSERT INTO `auto_jurnal` (`id_auto_jurnal`, `kategori_transaksi`, `debet_id`, `debet_name`, `kredit_id`, `kredit_name`) VALUES
(5, 'Simpanan', 135, 'Kas Berangkas', 163, 'Simpanan Anggota'),
(6, 'Penarikan', 163, 'Simpanan Anggota', 135, 'Kas Berangkas'),
(7, 'Pinjaman', 162, 'Pinjaman Anggota', 135, 'Kas Berangkas '),
(8, 'Angsuran', 155, 'Kas Brangkas', 162, 'Pinjaman Anggota ');

-- --------------------------------------------------------

--
-- Table structure for table `auto_jurnal_angsuran`
--

DROP TABLE IF EXISTS `auto_jurnal_angsuran`;
CREATE TABLE IF NOT EXISTS `auto_jurnal_angsuran` (
  `id_auto_jurnal_angsuran` int NOT NULL AUTO_INCREMENT,
  `komponen` varchar(20) NOT NULL COMMENT 'Jasa, Denda',
  `id_perkiraan` int DEFAULT NULL,
  `kode` varchar(25) DEFAULT NULL,
  `nama` text,
  PRIMARY KEY (`id_auto_jurnal_angsuran`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='pengaturan pada saat pembayaran angsuran';

--
-- Dumping data for table `auto_jurnal_angsuran`
--

INSERT INTO `auto_jurnal_angsuran` (`id_auto_jurnal_angsuran`, `komponen`, `id_perkiraan`, `kode`, `nama`) VALUES
(1, 'Jasa', 160, '4.1', 'Pendapatan Jasa '),
(2, 'Denda', 161, '4.2', 'Pendapatan Denda ');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori_barang` varchar(30) NOT NULL,
  `satuan_barang` varchar(20) NOT NULL,
  `konversi` decimal(10,2) NOT NULL,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `stok_barang` decimal(10,2) DEFAULT NULL,
  `stok_minimum` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `kode_barang` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `kategori_barang`, `satuan_barang`, `konversi`, `harga_beli`, `stok_barang`, `stok_minimum`) VALUES
(1, '9415007034414', 'Boneeto Stoberi 115ml', 'MNM', 'KTK', 1.00, 2600.00, 87.00, 0.00),
(2, '9415007014423', 'Boneeto Coklat 115ml', 'MNM', 'KTK', 1.00, 2600.00, 100.00, 0.00),
(3, '9415007009818', 'Anlene Gold Cokelat 250g', 'MNM', 'DUS', 1.00, 38000.00, 80.00, 0.00),
(4, '9311931201208', 'Max Tea Tarik', 'MNM', 'RCG', 1.00, 15250.00, 100.00, 0.00),
(5, '8999999710880', 'Pepsodent Herbal 75g', 'BC', 'PCS', 1.00, 6600.00, 100.00, 0.00),
(6, '8999999706081', 'Pepsodent White 75g', 'BC', 'PCS', 1.00, 3875.00, 100.00, 0.00),
(7, '8999999549480', 'Sunlight Lime Cream', 'BC', 'PCS', 1.00, 4500.00, 100.00, 0.00),
(8, '8999999538712', 'Rinso Cair 21ml', 'BC', 'RCG', 1.00, 2400.00, 100.00, 0.00),
(9, '8999999533496', 'Bango Soya Manis 20ml', 'BD', 'RCG', 1.00, 9600.00, 99.00, 0.00),
(10, '8999999533298', 'Dove Dandruff 20ml', 'BC', 'RCG', 1.00, 4500.00, 100.00, 0.00),
(11, '8999999533281', 'Dove Rambut Rontok 20ml', 'BC', 'RCG', 1.00, 4500.00, 100.00, 0.00),
(12, '8999999531485', 'Molto Luxury Rose 10ml', 'BC', 'KTG', 1.00, 4680.00, 100.00, 0.00),
(13, '8999999531478', 'Molto Edp Purple 10ml', 'BC', 'RCG', 1.00, 4680.00, 100.00, 0.00),
(14, '8999999530426', 'Rinso Cair Gentle Pouch 200ml', 'BD', 'PCH', 1.00, 3977.00, 100.00, 0.00),
(15, '8999999530341', 'Citra Rcg 9ml', 'KC', 'RCG', 1.00, 4500.00, 100.00, 0.00),
(16, '8999999530228', 'Lifebuoy Matcha 250ml', 'BC', 'REF', 1.00, 13150.00, 100.00, 0.00),
(17, '8999999529918', 'Clear Superfresh Apple 80ml', 'BC', 'BTL', 1.00, 9100.00, 100.00, 0.00),
(18, '8999999529833', 'Clear Ice Cool 10ml', 'BC', 'RCG', 1.00, 4650.00, 100.00, 0.00),
(19, '8999999529819', 'Clear Anti Ketombe 10ml', 'BC', 'RCG', 1.00, 4650.00, 100.00, 0.00),
(20, '8999999529703', 'Clear Cool Sport Menthol 80ml', 'BC', 'BTL', 1.00, 9700.00, 100.00, 0.00),
(21, '8999999529673', 'Clear Ice Cool Menthol 80ml', 'BC', 'BTL', 1.00, 9100.00, 100.00, 0.00),
(22, '8999999529550', 'Clear Complete Soft Care 80ml', 'BC', 'BTL', 1.00, 9100.00, 100.00, 0.00),
(23, '8999999529291', 'Molto Pure 10ml', 'BC', 'RCG', 1.00, 4680.00, 100.00, 0.00),
(24, '8999999528942', 'Citra Pearly white 120ml', 'KC', 'BTL', 1.00, 9750.00, 12.00, 0.00),
(25, '8999999528935', 'Citra Nat Glow 120ml', 'KC', 'BTL', 1.00, 9750.00, 54.00, 0.00),
(26, '8999999528881', 'Citra Nat Glow 230ml', 'KC', 'BTL', 1.00, 17150.00, 100.00, 0.00),
(27, '8999999528850', 'Citra Nat Glow 60ml', 'KC', 'BTL', 1.00, 5450.00, 90.00, 0.00),
(28, '8999999528843', 'Citra Pearly White 60ml', 'KC', 'BAG', 1.00, 5450.00, 100.00, 0.00),
(29, '8999999528805', 'Citra Pearly White Uv 230ml', 'KC', 'BTL', 1.00, 17150.00, 100.00, 0.00),
(30, '8999999526894', 'Rinso Molto Cair Royal Gold', 'BC', 'RCG', 1.00, 4830.00, 100.00, 0.00),
(31, '8999999526887', 'Rinso Royal Gold 770g', 'BC', 'PCS', 1.00, 17508.00, 100.00, 0.00),
(32, '8999999526863', 'Molto All In1 Pink 11ml', 'BC', 'RCG', 1.00, 4680.00, 100.00, 0.00),
(33, '8999999526856', 'Molto All In One Biru 11ml', 'BC', 'RCG', 1.00, 4680.00, 100.00, 0.00),
(34, '8999999524821', 'Sunlight Habbatus Pouch 100ml', 'BC', 'PCS', 1.00, 1488.00, 100.00, 0.00),
(35, '8999999524722', 'Sunlight Lime Pouch 435ml', 'BC', 'REF', 1.00, 9308333.00, 100.00, 0.00),
(36, '8999999520885', 'Wifol Karbol 500ml', 'BC', 'PCS', 1.00, 8600.00, 100.00, 0.00),
(37, '8999999520878', 'Wipol Karbol 240ml', 'BC', 'PCH', 1.00, 4249.00, 100.00, 0.00),
(38, '8999999518998', 'Rinso Molto Essence 770g', 'BC', 'BAG', 1.00, 18050.00, 100.00, 0.00),
(39, '8999999518516', 'Molto Detergen cair glowing Elegance 700ml', 'Lainnya', 'REF', 1.00, 14375.00, 100.00, 0.00),
(40, '8999999518417', 'Molto Detergent 40gr', 'Lainnya', 'SCH', 1.00, 908333.00, 100.00, 0.00),
(41, '8999999514617', 'Bango Pouch 400ml', 'MKN', 'PCH', 1.00, 15520.00, 120.00, 0.00),
(42, '8999999514518', 'Rinso Cair Essence Pouch', 'BC', 'PCH', 1.00, 4074.00, 100.00, 0.00),
(43, '8999999514495', 'Rinso Cair Rose Fresh Pouch', 'BC', 'PCH', 1.00, 4074.00, 100.00, 0.00),
(44, '8999999514006', 'Korek Gas', 'ALAT', 'PCS', 1.00, 2400.00, 95.00, 0.00),
(45, '8999999514006', 'Bango Manis 60ml', 'BD', 'pcs', 1.00, 2400.00, 78.00, 0.00),
(46, '8999999504014', 'Molto Higiene Perisai Aktif 12ml', 'Lainnya', 'SCH', 1.00, 426111.00, 100.00, 0.00),
(47, '8999999502409', 'Royco Fds Sapi 9g', 'BD', 'RCG', 1.00, 4479167.00, 100.00, 0.00),
(48, '8999999500672', 'Vixal Pemb Pors Biru 200ml', 'BC', 'BTL', 1.00, 4200.00, 100.00, 0.00),
(49, '8999999500641', 'Rinso Molto Pink 250g', 'BC', 'BKS', 1.00, 4200.00, 100.00, 0.00),
(50, '8999999407872', 'Wipol Classic Pine 450 ml', 'Lainnya', 'REF', 1.00, 11625.00, 100.00, 0.00),
(51, '8999999406936', 'Super Pell Pouch 380ml', 'BC', 'PCH', 1.00, 5529.00, 100.00, 0.00),
(52, '8999999406912', 'Super Pell Pouch Cherry Rose', 'BC', 'PCH', 1.00, 9744.00, 100.00, 0.00),
(53, '8999999401221', 'Rinso Anti Noda 430g', 'BC', 'PCS', 1.00, 9500.00, 95.00, 0.00),
(54, '8999999401023', 'Molto Pewangi Pink 900ml', 'BC', 'REF', 1.00, 10100.00, 100.00, 0.00),
(55, '8999999400958', 'Molto Pewangi Blue 900ml', 'BC', 'REF', 1.00, 10100.00, 100.00, 0.00),
(56, '8999999400903', 'Molto Pewangi Floral Bliss 450 ml', 'BC', 'REF', 1.00, 5208.00, 100.00, 0.00),
(57, '8999999390181', 'Sunlight Lime 400ml', 'BC', 'PCH', 1.00, 9000.00, 100.00, 0.00),
(58, '8999999195656', 'Sariwangi Kotak Tb 50', 'MNM', 'PAK', 1.00, 9249.00, 100.00, 0.00),
(59, '8999999195649', 'Sariwangi Kotak 1,85g', 'MNM', 'KTK', 1.00, 4800021.00, 100.00, 0.00),
(61, '8999999059781', 'Sunlight Lime Pouch 210ml', 'BC', 'REF', 1.00, 4300.00, 100.00, 0.00),
(62, '8999999059354', 'Lifebuoy Vita Protect', 'BC', 'BH', 1.00, 2700.00, 100.00, 0.00),
(63, '8999999059323', 'Lifebuoy Lemon Fresh', 'BC', 'BH', 1.00, 2700.00, 100.00, 0.00),
(64, '8999999059316', 'Lifebuoy Mild Care 80g', 'KC', 'BH', 1.00, 2700.00, 100.00, 0.00),
(73, '8999999052959', 'Pons White Beauty Foam 50g', 'BC', 'TUB', 1.00, 16300.00, 100.00, 0.00),
(74, '8999999050009', 'Sunlight Lime Pouch 95ml', 'BC', 'BKS', 1.00, 1600.00, 98.00, 0.00),
(75, '8999999049669', 'Rexona Motionsense', 'BC', 'BH', 1.00, 13550.00, 100.00, 0.00),
(76, '8999999049492', 'Rexona Powder Dry 45ml', 'KC', 'BTL', 1.00, 13550.00, 100.00, 0.00),
(77, '8999999049454', 'Rexona Free Spirit 50ml', 'BC', 'BH', 1.00, 13550.00, 99.00, 0.00),
(78, '8999999049409', 'Rexona Men Cool Ice 50ml', 'BC', 'BH', 1.00, 13550.00, 100.00, 0.00),
(79, '8999999049034', 'Sunlight Lime Pouch 45ml', 'BC', 'SCH', 1.00, 825.00, 100.00, 0.00),
(80, '8999999047245', 'Rinso Molto 44g', 'BC', 'RCG', 1.00, 4830.00, 100.00, 0.00),
(81, '8999999047221', 'Rinso Anti Noda 44g', 'BC', 'RCG', 1.00, 4830.00, 100.00, 0.00),
(82, '8999999036942', 'Lux Magical Spell 250ml', 'BC', 'REF', 1.00, 12114.00, 100.00, 0.00),
(83, '8999999036904', 'Lux Velvet Pouch 250ml', 'BC', 'PCS', 1.00, 12112.00, 100.00, 0.00),
(84, '8999999036898', 'Lux Soft Rose 250ml', 'BC', 'REF', 1.00, 12114.00, 100.00, 0.00),
(85, '8999999036843', 'Lux Aqua Delight 450ml', 'BC', 'PCH', 1.00, 20320.00, 100.00, 0.00),
(86, '8999999036829', 'Lux Soft Rose 450ml', 'BC', 'PCS', 1.00, 20320.00, 100.00, 0.00),
(87, '8999999036690', 'Lux Magical Spell 80g', 'KC', 'BH', 1.00, 2800.00, 100.00, 0.00),
(88, '8999999036676', 'Lux Aqua Delight 80g', 'KC', 'BH', 1.00, 2800.00, 100.00, 0.00),
(89, '8999999036638', 'Lux Velvet Jasmine 80g', 'KC', 'BH', 1.00, 2800.00, 100.00, 0.00),
(91, '8999999034153', 'Blue Band Serbaguna 200g', 'MKN', 'PCS', 1.00, 6733333.00, 109.00, 0.00),
(92, '8999999033200', 'Lifebuoy Anti - Dandruff 70ml', 'BC', 'BTL', 1.00, 6850.00, 100.00, 0.00),
(93, '8999999033163', 'Lifebuoy Strong & Shiny 70 ml', 'BC', 'BTL', 1.00, 6850.00, 100.00, 0.00),
(94, '8999999033125', 'Lifebuoy Anti Hair Fall 70ml', 'BC', 'BTL', 1.00, 6850.00, 100.00, 0.00),
(95, '8999999027605', 'Clear Complete Soft Care 10ml Unisex', 'Lainnya', 'pcs', 1.00, 783125.00, 100.00, 0.00),
(96, '8999999027278', 'Lifebuoy Lemon Fresh 250ml', 'BC', 'REF', 1.00, 13150.00, 100.00, 0.00),
(97, '8999999027261', 'Lifebuoy Lemon Fresh 450ml', 'BC', 'REF', 1.00, 21700.00, 100.00, 0.00),
(98, '8999999027049', 'Lifebuoy Hairfall Trmt 9ml', 'BC', 'RCG', 1.00, 2250.00, 96.00, 0.00),
(99, '6676', 'Pulsa Tree 5000', 'Pulsa', 'Rp', 1.00, 5000.00, 100.00, 0.00),
(100, '2345654631', 'Pulsa Telkomsel 5000', 'Pulsa', 'Rp', 1.00, 5000.00, 200.00, 0.00),
(101, '7765652326', 'Rinso Pewangi', 'Detergent', 'Pcs', 1.00, 2500.00, 100.00, 10.00),
(102, '2710797996', 'Rinso Pewangi', 'Detergent', 'Pcs', 1.00, 2500.00, 99.00, 10.00),
(103, '8783112781', 'Rinso Pewangi', 'Detergent', 'Pcs', 1.00, 2500.00, 101.00, 10.00),
(104, '117373807', 'Rinso Pewangi', 'Detergent', 'Pcs', 1.00, 2500.00, 99.00, 10.00),
(105, '4864063947', 'Kopi Gadjah', 'Kopi', 'Sachet', 1.00, 2000.00, 199.00, 10.00),
(106, '4303369817', 'Kopi Arabica', 'Kopi', 'PCS', 1.00, 1200.00, 79.00, 1.00),
(110, '00001111100000', 'Beras 10 Kg', 'sembako', 'Kg', 1.00, 110000.00, 85.00, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `barang_bacth`
--

DROP TABLE IF EXISTS `barang_bacth`;
CREATE TABLE IF NOT EXISTS `barang_bacth` (
  `id_barang_bacth` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `no_batch` varchar(20) NOT NULL,
  `expired_date` date NOT NULL,
  `qty_batch` decimal(10,2) NOT NULL,
  `reminder_date` date NOT NULL,
  `status` varchar(15) NOT NULL COMMENT 'Terdaftar, Terjual, None',
  PRIMARY KEY (`id_barang_bacth`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_bacth`
--

INSERT INTO `barang_bacth` (`id_barang_bacth`, `id_barang`, `no_batch`, `expired_date`, `qty_batch`, `reminder_date`, `status`) VALUES
(1, 96, '89999990272781', '2022-09-24', 10.00, '2022-09-18', 'Terjual'),
(2, 95, '89999990276051', '2022-09-10', 10.00, '2022-09-11', 'Terjual'),
(3, 91, '89999990341531', '2022-09-24', 15.00, '2022-09-18', 'Terjual'),
(4, 91, '89999990341532', '2022-09-24', 15.00, '2022-09-18', 'Terjual'),
(5, 91, '89999990341533', '2022-09-24', 15.00, '2022-09-18', 'Terjual'),
(6, 110, 'ad134123123', '2025-03-01', 12.00, '2025-02-28', 'Terdaftar'),
(7, 106, '3454352423424', '2025-03-08', 11.00, '2025-03-06', 'Terdaftar'),
(8, 98, '24234234', '2025-02-24', 1.00, '2025-02-23', 'Terdaftar'),
(13, 110, '45334123443', '2025-03-12', 1.00, '2025-03-11', 'Terdaftar'),
(14, 110, '45334123444', '2025-03-13', 1.00, '2025-03-12', 'Terdaftar'),
(15, 110, '45334123445', '2025-03-14', 1.00, '2025-03-13', 'Terdaftar'),
(16, 110, '45334123446', '2025-03-15', 1.00, '2025-03-14', 'Terdaftar'),
(17, 110, '45334123447', '2025-03-16', 1.00, '2025-03-15', 'Terdaftar'),
(18, 110, '45334123448', '2025-03-17', 1.00, '2025-03-16', 'Terdaftar'),
(19, 110, '45334123449', '2025-03-18', 1.00, '2025-03-17', 'Terdaftar'),
(20, 110, '45334123450', '2025-03-19', 1.00, '2025-03-18', 'Terdaftar'),
(21, 110, '45334123451', '2025-03-20', 1.00, '2025-03-19', 'Terdaftar'),
(22, 110, '45334123452', '2025-03-21', 1.00, '2025-03-20', 'Terdaftar'),
(23, 110, '45334123453', '2025-03-22', 1.00, '2025-03-21', 'Terdaftar'),
(24, 110, '45334123454', '2025-03-23', 1.00, '2025-03-22', 'Terdaftar');

-- --------------------------------------------------------

--
-- Table structure for table `barang_diskon`
--

DROP TABLE IF EXISTS `barang_diskon`;
CREATE TABLE IF NOT EXISTS `barang_diskon` (
  `id_barang_diskon` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `diskon` int NOT NULL COMMENT 'Persen',
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  PRIMARY KEY (`id_barang_diskon`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_harga`
--

DROP TABLE IF EXISTS `barang_harga`;
CREATE TABLE IF NOT EXISTS `barang_harga` (
  `id_barang_harga` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `id_barang_kategori_harga` int NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_barang_harga`),
  KEY `id_barang` (`id_barang`),
  KEY `id_barang_kategori_harga` (`id_barang_kategori_harga`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_harga`
--

INSERT INTO `barang_harga` (`id_barang_harga`, `id_barang`, `id_barang_kategori_harga`, `harga`) VALUES
(19, 106, 11, 1300.00),
(20, 106, 12, 1200.00),
(21, 106, 13, 1400.00),
(22, 110, 11, 120000.00),
(23, 110, 12, 120000.00),
(24, 110, 13, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `barang_kategori_harga`
--

DROP TABLE IF EXISTS `barang_kategori_harga`;
CREATE TABLE IF NOT EXISTS `barang_kategori_harga` (
  `id_barang_kategori_harga` int NOT NULL AUTO_INCREMENT,
  `kategori_harga` varchar(30) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_barang_kategori_harga`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_kategori_harga`
--

INSERT INTO `barang_kategori_harga` (`id_barang_kategori_harga`, `kategori_harga`, `keterangan`) VALUES
(11, 'Grosir', 'Harga Grosir'),
(12, 'Anggota', 'Harga Untuk Anggota'),
(13, 'Umum', 'Harga kepada pelanggan umum');

-- --------------------------------------------------------

--
-- Table structure for table `barang_satuan`
--

DROP TABLE IF EXISTS `barang_satuan`;
CREATE TABLE IF NOT EXISTS `barang_satuan` (
  `id_barang_satuan` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `satuan_multi` varchar(20) NOT NULL,
  `konversi_multi` int DEFAULT NULL,
  PRIMARY KEY (`id_barang_satuan`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_satuan`
--

INSERT INTO `barang_satuan` (`id_barang_satuan`, `id_barang`, `satuan_multi`, `konversi_multi`) VALUES
(1, 4, 'Krat', 10),
(2, 4, 'Dus', 100),
(3, 3, 'Dus', 100),
(5, 1, 'Strip', 4),
(6, 1, 'Dus', 400),
(7, 5, 'Strip', 4),
(8, 5, 'Box', 40),
(9, 6, 'Set', 4),
(11, 6, 'Boss', 10),
(12, 6, 'Kontener', 1000),
(19, 98, 'Dus', 10),
(20, 100, 'Bos', 10),
(21, 97, 'Dus', 10),
(22, 106, 'Box', 15),
(24, 105, 'Box', 10),
(25, 105, 'Renceng', 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id_help`, `author`, `judul`, `kategori`, `deskripsi`, `datetime_creat`, `datetime_update`, `status`) VALUES
(2, 'Solihul Hadi', 'Cara Mengirim Pengajuan Akses', 'Pengajuan Akses', '&lt;p&gt;Tahap awal yang harus dilakukan pertama kali untuk dapat menggunakan aplikasi adalah mengirimkan permohonan akses.&lt;/p&gt;', '2024-08-09 05:07:14', '2024-08-10 01:09:35', 'Publish'),
(3, 'Solihul Hadi', 'Melakukan Login', 'Akses', '&lt;p&gt;Untuk melakukan login, ikuti tahapan berikut ini&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;assets/img/Help/43ac4062b48a1b8e.png&quot; alt=&quot;&quot; width=&quot;389&quot; height=&quot;409&quot; /&gt;&lt;/p&gt;', '2024-08-09 05:16:33', '2024-08-10 01:09:28', 'Publish'),
(4, 'Solihul Hadi', 'Mengubah Password', 'Akses', '&lt;p&gt;Berikut ini adalah langkah-langkah untuk merubah password&lt;/p&gt;\n&lt;ol&gt;\n&lt;li&gt;Login pada akun anda seperti biasa&lt;/li&gt;\n&lt;li&gt;Pada bagian menu kanan atas (profil pengguna) pilih profil saya.&lt;/li&gt;\n&lt;li&gt;Pilih sub menu ubah password&lt;/li&gt;\n&lt;li&gt;Masukan password baru anda pada form yang disediakan&lt;/li&gt;\n&lt;li&gt;Simpan perubahan dan sistem akan menampilkan notifikasi berhasil.&lt;/li&gt;\n&lt;/ol&gt;', '2024-08-10 00:58:00', '2024-08-12 02:12:30', 'Publish');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

DROP TABLE IF EXISTS `jurnal`;
CREATE TABLE IF NOT EXISTS `jurnal` (
  `id_jurnal` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(30) DEFAULT NULL COMMENT 'Simpanan, Penarikan, Transaksi, Pinjaman, Angsuran, ',
  `uuid` char(36) NOT NULL,
  `id_transaksi` int DEFAULT NULL,
  `id_pinjaman` int DEFAULT NULL,
  `id_pinjaman_angsuran` int DEFAULT NULL,
  `id_simpanan` int DEFAULT NULL,
  `id_transaksi_jual_beli` char(36) DEFAULT NULL,
  `id_shu_session` int DEFAULT NULL,
  `tanggal` date NOT NULL COMMENT 'tanggal transaksi',
  `kode_perkiraan` varchar(20) NOT NULL,
  `nama_perkiraan` text NOT NULL,
  `d_k` varchar(5) NOT NULL COMMENT 'D/K',
  `nilai` int DEFAULT NULL,
  PRIMARY KEY (`id_jurnal`),
  KEY `id_pinjaman` (`id_pinjaman`),
  KEY `id_pinjaman_angsuran` (`id_pinjaman_angsuran`),
  KEY `id_transaksi_jual_beli` (`id_transaksi_jual_beli`),
  KEY `id_shu_session` (`id_shu_session`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_simpanan` (`id_simpanan`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`id_jurnal`, `kategori`, `uuid`, `id_transaksi`, `id_pinjaman`, `id_pinjaman_angsuran`, `id_simpanan`, `id_transaksi_jual_beli`, `id_shu_session`, `tanggal`, `kode_perkiraan`, `nama_perkiraan`, `d_k`, `nilai`) VALUES
(1, 'Pinjaman', '1UYjtSkUTWu1lBLEdM2w9fGVrgTkX1soIz7S', NULL, 26, NULL, NULL, NULL, NULL, '2025-04-02', '1.1.1.3', 'Kas Berangkas ', 'K', 10000000),
(2, 'Pinjaman', '1UYjtSkUTWu1lBLEdM2w9fGVrgTkX1soIz7S', NULL, 26, NULL, NULL, NULL, NULL, '2025-04-02', '1.1.3.4', 'Pinjaman Anggota', 'D', 10000000),
(3, 'Angsuran', 'C34JffjFNbXrFOZioIXO4GA97aQUuINJHF09', NULL, NULL, 631, NULL, NULL, NULL, '2025-04-02', '1.1.3.4', 'Pinjaman Anggota ', 'K', 1000000),
(4, 'Angsuran', 'C34JffjFNbXrFOZioIXO4GA97aQUuINJHF09', NULL, NULL, 631, NULL, NULL, NULL, '2025-04-02', '1.1.1.1.1', 'Kas Brangkas', 'D', 1100000),
(5, 'Angsuran', 'C34JffjFNbXrFOZioIXO4GA97aQUuINJHF09', NULL, NULL, 631, NULL, NULL, NULL, '2025-04-02', '4.1', 'Pendapatan Jasa ', 'K', 100000),
(6, 'Penjualan', '5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', NULL, NULL, NULL, NULL, '5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', NULL, '2025-04-02', '1.1.1.1.1', 'Kas Brangkas', 'D', 120000),
(7, 'Penjualan', '5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', NULL, NULL, NULL, NULL, '5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', NULL, '2025-04-02', '5.4', 'Beban Lainnya', 'K', 120000),
(8, 'Pembelian', 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, NULL, NULL, NULL, 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, '2025-04-02', '5.4', 'Beban Lainnya', 'D', 0),
(9, 'Pembelian', 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, NULL, NULL, NULL, 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, '2025-04-02', '1.1.1.3', 'Kas Berangkas', 'K', 2500),
(10, 'Pembelian', 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, NULL, NULL, NULL, 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, '2025-04-02', '2.1.1', 'Hutang Usaha', 'D', 2500),
(11, 'Pembelian', 'iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', NULL, NULL, NULL, NULL, 'iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', NULL, '2025-04-02', '5.4', 'Beban Lainnya', 'D', 110000),
(12, 'Pembelian', 'iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', NULL, NULL, NULL, NULL, 'iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', NULL, '2025-04-02', '1.1.1.3', 'Kas Berangkas', 'K', 110000),
(13, 'Transaksi', '67606352644125568139520743013373', 22, NULL, NULL, NULL, NULL, NULL, '2025-04-03', '5.1.4', 'Beban PBB', 'D', 100000),
(14, 'Transaksi', '67606352644125568139520743013373', 22, NULL, NULL, NULL, NULL, NULL, '2025-04-03', '1.1.1.2.3', 'Kas Bank Mandiri', 'K', 100000),
(15, 'Transaksi', '92085391979233568469181179157482', 23, NULL, NULL, NULL, NULL, NULL, '2025-04-03', '5.3.4', 'Beban Utilitas', 'D', 20000),
(16, 'Transaksi', '92085391979233568469181179157482', 23, NULL, NULL, NULL, NULL, NULL, '2025-04-03', '1.1.1.3', 'Kas Berangkas', 'K', 20000),
(17, 'SHU', 'H9bd9QAbzDbn7vsiYJICiZ9UD9PR1fZmKp9g', NULL, NULL, NULL, NULL, NULL, 6, '2025-04-03', '5.4', 'Beban Lainnya', 'D', 10500005),
(18, 'SHU', 'H9bd9QAbzDbn7vsiYJICiZ9UD9PR1fZmKp9g', NULL, NULL, NULL, NULL, NULL, 6, '2025-04-03', '2.2', 'Kewajiban Pembayaran Prive Investor', 'K', 10500005),
(19, 'SHU', 'H9bd9QAbzDbn7vsiYJICiZ9UD9PR1fZmKp9g', NULL, NULL, NULL, NULL, NULL, 6, '2025-04-03', '2.2', 'Kewajiban Pembayaran Prive Investor', 'D', 10500005),
(20, 'SHU', 'H9bd9QAbzDbn7vsiYJICiZ9UD9PR1fZmKp9g', NULL, NULL, NULL, NULL, NULL, 6, '2025-04-03', '5.4', 'Beban Lainnya', 'K', 10500005),
(21, 'Simpanan', 'TXrcG3WUbkSW5xVlWmr5FuarHaQ8qGFgqky1', NULL, NULL, NULL, 443, NULL, NULL, '2025-04-03', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(22, 'Simpanan', 'TXrcG3WUbkSW5xVlWmr5FuarHaQ8qGFgqky1', NULL, NULL, NULL, 443, NULL, NULL, '2025-04-03', '2.3', 'Simpanan Anggota', 'K', 100000),
(63, 'Simpanan', 'ZwqQ3NqbkQyvI2PJjy0Yq48RJG6TarnGv2Ct', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(64, 'Simpanan', 'ZwqQ3NqbkQyvI2PJjy0Yq48RJG6TarnGv2Ct', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(65, 'Simpanan', 'e2xWnXwmzSK1L2M2Bnr9f9o4DDlZs3iLsBO6', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(66, 'Simpanan', 'e2xWnXwmzSK1L2M2Bnr9f9o4DDlZs3iLsBO6', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(67, 'Simpanan', 'RAsFeQVUmIXfXx9x1GllyD1retvra3q6vvWd', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(68, 'Simpanan', 'RAsFeQVUmIXfXx9x1GllyD1retvra3q6vvWd', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(69, 'Simpanan', 'rYdJ5jH9khKp4ynnKNR0vP63Ne1gszuZP4mA', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(70, 'Simpanan', 'rYdJ5jH9khKp4ynnKNR0vP63Ne1gszuZP4mA', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(71, 'Simpanan', 'FpkYJPGo2dpNnVZVlXDDHPkbdEINTOegElZn', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(72, 'Simpanan', 'FpkYJPGo2dpNnVZVlXDDHPkbdEINTOegElZn', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(73, 'Simpanan', 'kfZa0P3G4YxuzQO2BJh5u55nTByUmDDd2xnf', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(74, 'Simpanan', 'kfZa0P3G4YxuzQO2BJh5u55nTByUmDDd2xnf', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(75, 'Simpanan', 'Hf09BsPhFlTdZPz2UQHNKJfLbScWbsUTD0Ud', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(76, 'Simpanan', 'Hf09BsPhFlTdZPz2UQHNKJfLbScWbsUTD0Ud', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(77, 'Simpanan', 'NzBzyrV2Wu1IZjUHrJ0IcnBKb03wFhkVn4v3', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(78, 'Simpanan', 'NzBzyrV2Wu1IZjUHrJ0IcnBKb03wFhkVn4v3', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(79, 'Simpanan', 'DxdFlO7Azm1iIAm7GSNgwJQ6iLdoqrLvuHuG', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(80, 'Simpanan', 'DxdFlO7Azm1iIAm7GSNgwJQ6iLdoqrLvuHuG', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(81, 'Simpanan', 'XGC0Ugs7VLBb66JB0NI9HOCGKMh8PV5CQMHj', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(82, 'Simpanan', 'XGC0Ugs7VLBb66JB0NI9HOCGKMh8PV5CQMHj', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(83, 'Simpanan', 'tPyKinoqvzrXAeRLeEzet8kBXAP9ecOhhuIS', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(84, 'Simpanan', 'tPyKinoqvzrXAeRLeEzet8kBXAP9ecOhhuIS', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(85, 'Simpanan', 'gVNTbUlFUCHcpjxZlOC232j4X7fiPZNeUXw6', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(86, 'Simpanan', 'gVNTbUlFUCHcpjxZlOC232j4X7fiPZNeUXw6', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(87, 'Simpanan', 'oA1LOTPWqACRPcV4HgFDG1ZjNygqfIhocsqB', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(88, 'Simpanan', 'oA1LOTPWqACRPcV4HgFDG1ZjNygqfIhocsqB', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(89, 'Simpanan', 'v2rYs1ic27mjlAoOnntLt9gf9RZkROG3tzHP', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(90, 'Simpanan', 'v2rYs1ic27mjlAoOnntLt9gf9RZkROG3tzHP', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(91, 'Simpanan', 'M6gIBKEgQJQvm8wqOE7vCkj5jJCKAk6XEv5B', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(92, 'Simpanan', 'M6gIBKEgQJQvm8wqOE7vCkj5jJCKAk6XEv5B', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(93, 'Simpanan', 'fu1cXGnCtRwmZpJmtrcGpgch2kI63cuTxVNv', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(94, 'Simpanan', 'fu1cXGnCtRwmZpJmtrcGpgch2kI63cuTxVNv', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(95, 'Simpanan', 'yGLDXB5U6P71yvXECdtZTaReOJt5RIPvkVfp', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(96, 'Simpanan', 'yGLDXB5U6P71yvXECdtZTaReOJt5RIPvkVfp', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(97, 'Simpanan', 'oFa4hKU7U5K711zikDjX5MadijSTb8s4bfOZ', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(98, 'Simpanan', 'oFa4hKU7U5K711zikDjX5MadijSTb8s4bfOZ', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(99, 'Simpanan', 'CCP6HLpE4IDSYMbvIVSfjvFjzrohgXoliio7', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(100, 'Simpanan', 'CCP6HLpE4IDSYMbvIVSfjvFjzrohgXoliio7', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(101, 'Simpanan', 'y7UTMc97WhSkFokdRg9CySTk5payzUEIEhaf', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '1.1.1.2.5', 'Kas Bank Jabar', 'D', 100000),
(102, 'Simpanan', 'y7UTMc97WhSkFokdRg9CySTk5payzUEIEhaf', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01', '2.3', 'Simpanan Anggota', 'K', 100000),
(103, 'Simpanan', 'U4KnPyBcMDcwmDml17nKTuJI1i7M8LClt8Um', NULL, NULL, NULL, 464, NULL, NULL, '2025-04-03', '2.3', 'Simpanan Anggota', 'D', 100000),
(104, 'Simpanan', 'U4KnPyBcMDcwmDml17nKTuJI1i7M8LClt8Um', NULL, NULL, NULL, 464, NULL, NULL, '2025-04-03', '1.1.1.3', 'Kas Berangkas', 'K', 100000);

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
) ENGINE=InnoDB AUTO_INCREMENT=533 DEFAULT CHARSET=latin1;

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
(486, 6, '2025-02-26 00:56:09', 'Transaksi Penjualan', 'Reset Transaksi Penjualan'),
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
(532, 1, '2025-04-03 02:03:17', 'Fitur Akses', 'Hapus Fitur Akses');

-- --------------------------------------------------------

--
-- Table structure for table `log_email`
--

DROP TABLE IF EXISTS `log_email`;
CREATE TABLE IF NOT EXISTS `log_email` (
  `id_log_email` int NOT NULL AUTO_INCREMENT,
  `nama` text,
  `email` text NOT NULL,
  `subjek` text NOT NULL,
  `pesan` text NOT NULL,
  `datetime` text NOT NULL,
  PRIMARY KEY (`id_log_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notifikasi` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `datetime_notifikasi` varchar(30) NOT NULL,
  `kategori_notifikasi` text NOT NULL,
  `notifikasi` text NOT NULL,
  `status_notifikasi` varchar(25) NOT NULL,
  PRIMARY KEY (`id_notifikasi`)
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
  `lembaga` varchar(255) NOT NULL,
  `ranking` int NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjaman`, `id_pinjaman_jenis`, `uuid_pinjaman`, `id_anggota`, `nama`, `nip`, `lembaga`, `ranking`, `tanggal`, `jatuh_tempo`, `denda`, `sistem_denda`, `jumlah_pinjaman`, `persen_jasa`, `rp_jasa`, `angsuran_pokok`, `angsuran_total`, `periode_angsuran`, `status`) VALUES
(26, 1, '1UYjtSkUTWu1lBLEdM2w9fGVrgTkX1soIz7S', 1, 'Adam Saputra', '2024/07/Contoh-01', 'GIS', 1, '2025-04-02', 1, 0, 'Harian', 10000000, 1.00, 100000, 1000000, 1100000, 10, 'Berjalan');

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
) ENGINE=InnoDB AUTO_INCREMENT=632 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman_angsuran`
--

INSERT INTO `pinjaman_angsuran` (`id_pinjaman_angsuran`, `uuid_angsuran`, `id_pinjaman`, `id_anggota`, `tanggal_angsuran`, `tanggal_bayar`, `keterlambatan`, `pokok`, `jasa`, `denda`, `jumlah`) VALUES
(630, 'VjhcEj0lx8g9JV4X3CRbfbAQRGbhWGvJUD5a', 26, 1, '2025-05-01', '2025-04-02', 0, 1000000, 100000, 0, 1100000),
(631, 'C34JffjFNbXrFOZioIXO4GA97aQUuINJHF09', 26, 1, '2025-06-01', '2025-04-02', 0, 1000000, 100000, 0, 1100000);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pinjaman_jenis`
--

INSERT INTO `pinjaman_jenis` (`id_pinjaman_jenis`, `nama_pinjaman`, `periode_angsuran`, `persen_jasa`) VALUES
(1, 'Pinjaman Konsumtif', 12, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `setting_autojurnal`
--

DROP TABLE IF EXISTS `setting_autojurnal`;
CREATE TABLE IF NOT EXISTS `setting_autojurnal` (
  `id_setting_autojurnal` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `trans_account1` int DEFAULT NULL,
  `cash_account1` int DEFAULT NULL,
  `debt_account1` int DEFAULT NULL,
  `receivables_account1` int DEFAULT NULL,
  `trans_account2` int DEFAULT NULL,
  `cash_account2` int DEFAULT NULL,
  `debt_account2` int DEFAULT NULL,
  `receivables_account2` int DEFAULT NULL,
  PRIMARY KEY (`id_setting_autojurnal`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_autojurnal`
--

INSERT INTO `setting_autojurnal` (`id_setting_autojurnal`, `id_akses`, `trans_account1`, `cash_account1`, `debt_account1`, `receivables_account1`, `trans_account2`, `cash_account2`, `debt_account2`, `receivables_account2`) VALUES
(3, 6, 125, 121, 28, 136, 125, 135, 77, 136),
(5, 1, 125, 155, 28, 136, 41, 135, 28, 136);

-- --------------------------------------------------------

--
-- Table structure for table `setting_autojurnal_jual_beli`
--

DROP TABLE IF EXISTS `setting_autojurnal_jual_beli`;
CREATE TABLE IF NOT EXISTS `setting_autojurnal_jual_beli` (
  `id_autojurnal_jual_beli` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(15) NOT NULL,
  `debet` int DEFAULT NULL,
  `kredit` int DEFAULT NULL,
  `utang_piutang` int DEFAULT NULL,
  PRIMARY KEY (`id_autojurnal_jual_beli`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting_autojurnal_jual_beli`
--

INSERT INTO `setting_autojurnal_jual_beli` (`id_autojurnal_jual_beli`, `kategori`, `debet`, `kredit`, `utang_piutang`) VALUES
(1, 'Penjualan', 155, 119, 77),
(2, 'Pembelian', 119, 135, 28);

-- --------------------------------------------------------

--
-- Table structure for table `setting_autojurnal_shu`
--

DROP TABLE IF EXISTS `setting_autojurnal_shu`;
CREATE TABLE IF NOT EXISTS `setting_autojurnal_shu` (
  `id_setting_autojurnal_shu` int NOT NULL AUTO_INCREMENT,
  `id_perkiraan_debet` int NOT NULL,
  `id_perkiraan_kredit` int NOT NULL,
  `komponen` varchar(15) NOT NULL,
  PRIMARY KEY (`id_setting_autojurnal_shu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting_autojurnal_shu`
--

INSERT INTO `setting_autojurnal_shu` (`id_setting_autojurnal_shu`, `id_perkiraan_debet`, `id_perkiraan_kredit`, `komponen`) VALUES
(1, 119, 133, 'Pembagian'),
(2, 133, 119, 'Pembayaran');

-- --------------------------------------------------------

--
-- Table structure for table `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
CREATE TABLE IF NOT EXISTS `setting_email_gateway` (
  `id_setting_email_gateway` int NOT NULL AUTO_INCREMENT,
  `email_gateway` text,
  `password_gateway` varchar(20) DEFAULT NULL,
  `url_provider` text,
  `port_gateway` varchar(10) DEFAULT NULL,
  `nama_pengirim` varchar(25) DEFAULT NULL,
  `url_service` text NOT NULL,
  `validasi_email` varchar(10) NOT NULL,
  `redirect_validasi` text NOT NULL,
  `pesan_validasi_email` text NOT NULL,
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_email_gateway`
--

INSERT INTO `setting_email_gateway` (`id_setting_email_gateway`, `email_gateway`, `password_gateway`, `url_provider`, `port_gateway`, `nama_pengirim`, `url_service`, `validasi_email`, `redirect_validasi`, `pesan_validasi_email`) VALUES
(1, 'dhiforester@rsuelsyifa.com', 'solihulhadi1412', 'mail.rsuelsyifa.com', '465', 'Admin Koperasi Sejahtera', 'https://mailer.rsuelsyifa.com/index.php', 'No', '', 'Berikut ini kami kirimkan URL untuk melakukan validasi pendaftaran anda');

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
(1, 'Koperasi Sejahtera', 'Koperasi', 'Aplikasi POS Koperasi', 'Jalan RE Martadinata No 108 Ancaran Kuningan', 'dhiforester@gmail.com', '0232876240', '06b6155b2f6f04e9a0deba6df45747.png', 'ca979b24e6662ba7cbd9e6b70a943a.png', 'http://localhost:81/koperasi_v3', 'Solihul Hadi');

-- --------------------------------------------------------

--
-- Table structure for table `shu_rincian`
--

DROP TABLE IF EXISTS `shu_rincian`;
CREATE TABLE IF NOT EXISTS `shu_rincian` (
  `id_shu_rincian` int NOT NULL AUTO_INCREMENT,
  `id_shu_session` int DEFAULT NULL,
  `id_anggota` int DEFAULT NULL,
  `nama_anggota` text,
  `nip` varchar(32) DEFAULT NULL,
  `simpanan` int DEFAULT NULL,
  `pinjaman` int DEFAULT NULL,
  `penjualan` int DEFAULT NULL,
  `jasa_simpanan` int DEFAULT NULL,
  `jasa_pinjaman` int DEFAULT NULL,
  `jasa_penjualan` int DEFAULT NULL,
  `shu` int DEFAULT NULL,
  PRIMARY KEY (`id_shu_rincian`),
  KEY `id_shu_session` (`id_shu_session`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_anggota_2` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=883 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shu_rincian`
--

INSERT INTO `shu_rincian` (`id_shu_rincian`, `id_shu_session`, `id_anggota`, `nama_anggota`, `nip`, `simpanan`, `pinjaman`, `penjualan`, `jasa_simpanan`, `jasa_pinjaman`, `jasa_penjualan`, `shu`) VALUES
(724, 3, 1, 'Adam Saputra', NULL, 4470000, 0, 0, 6026695, 0, 0, 6026695),
(725, 3, 2, 'Budi Santoso', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(726, 3, 3, 'Citra Dewi', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(727, 3, 5, 'Eka Prasetyo', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(728, 3, 6, 'Farah Amalia', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(729, 3, 7, 'Guntur Wibowo', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(730, 3, 9, 'Indah Permatasari', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(731, 3, 10, 'Joko Susanto', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(732, 3, 11, 'Karina Putri', NULL, 4550000, 0, 0, 6134556, 0, 0, 6134556),
(733, 3, 12, 'Leo Pradipta', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(734, 3, 13, 'Maya Sari', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(735, 3, 14, 'Nanda Kusuma', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(736, 3, 15, 'Oki Pratama', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(737, 3, 16, 'Putri Ayu', NULL, 4300000, 0, 0, 5797492, 0, 0, 5797492),
(738, 3, 18, 'Sinta Maharani', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(739, 3, 19, 'Tio Nugroho', NULL, 4400000, 0, 0, 5932318, 0, 0, 5932318),
(740, 3, 22, 'Aruna Parasilva', NULL, 1700000, 0, 0, 2292032, 0, 0, 2292032),
(741, 3, 23, 'Tri Heru', NULL, 700000, 0, 0, 943778, 0, 0, 943778),
(742, 3, 1, 'Adam Saputra', NULL, 4470000, 0, 0, 48019, 0, 0, 48019),
(743, 3, 2, 'Budi Santoso', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(744, 3, 3, 'Citra Dewi', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(745, 3, 5, 'Eka Prasetyo', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(746, 3, 6, 'Farah Amalia', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(747, 3, 7, 'Guntur Wibowo', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(748, 3, 9, 'Indah Permatasari', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(749, 3, 10, 'Joko Susanto', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(750, 3, 11, 'Karina Putri', NULL, 4550000, 0, 0, 48879, 0, 0, 48879),
(751, 3, 12, 'Leo Pradipta', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(752, 3, 13, 'Maya Sari', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(753, 3, 14, 'Nanda Kusuma', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(754, 3, 15, 'Oki Pratama', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(755, 3, 16, 'Putri Ayu', NULL, 4300000, 0, 0, 46193, 0, 0, 46193),
(756, 3, 18, 'Sinta Maharani', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(757, 3, 19, 'Tio Nugroho', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(758, 3, 22, 'Aruna Parasilva', NULL, 1700000, 0, 0, 18262, 0, 0, 18262),
(759, 3, 23, 'Tri Heru', NULL, 700000, 0, 0, 7520, 0, 0, 7520),
(760, 3, 24, 'Sugito', NULL, 300000, 0, 0, 3223, 0, 0, 3223),
(761, 3, 25, 'Ulya Handayani', NULL, 0, 0, 0, 0, 0, 0, 0),
(762, 3, 1, 'Adam Saputra', NULL, 4470000, 0, 0, 48019, 0, 0, 48019),
(763, 3, 2, 'Budi Santoso', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(764, 3, 3, 'Citra Dewi', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(765, 3, 5, 'Eka Prasetyo', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(766, 3, 6, 'Farah Amalia', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(767, 3, 7, 'Guntur Wibowo', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(768, 3, 9, 'Indah Permatasari', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(769, 3, 10, 'Joko Susanto', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(770, 3, 11, 'Karina Putri', NULL, 4550000, 0, 0, 48879, 0, 0, 48879),
(771, 3, 12, 'Leo Pradipta', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(772, 3, 13, 'Maya Sari', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(773, 3, 14, 'Nanda Kusuma', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(774, 3, 15, 'Oki Pratama', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(775, 3, 16, 'Putri Ayu', NULL, 4300000, 0, 0, 46193, 0, 0, 46193),
(776, 3, 18, 'Sinta Maharani', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(777, 3, 19, 'Tio Nugroho', NULL, 4400000, 0, 0, 47267, 0, 0, 47267),
(778, 3, 22, 'Aruna Parasilva', NULL, 1700000, 0, 0, 18262, 0, 0, 18262),
(779, 3, 23, 'Tri Heru', NULL, 700000, 0, 0, 7520, 0, 0, 7520),
(780, 3, 24, 'Sugito', NULL, 300000, 0, 0, 3223, 0, 0, 3223),
(781, 3, 25, 'Ulya Handayani', NULL, 0, 0, 0, 0, 0, 0, 0),
(782, 3, 1, 'Adam Saputra', NULL, 3780000, 390000, 0, 613836, 277186, 0, 891021),
(783, 3, 2, 'Budi Santoso', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(784, 3, 3, 'Citra Dewi', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(785, 3, 5, 'Eka Prasetyo', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(786, 3, 6, 'Farah Amalia', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(787, 3, 7, 'Guntur Wibowo', NULL, 3700000, 9600000, 0, 600844, 6823028, 0, 7423872),
(788, 3, 9, 'Indah Permatasari', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(789, 3, 10, 'Joko Susanto', NULL, 3700000, 3840000, 0, 600844, 2729211, 0, 3330056),
(790, 3, 11, 'Karina Putri', NULL, 3850000, 0, 0, 625203, 0, 0, 625203),
(791, 3, 12, 'Leo Pradipta', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(792, 3, 13, 'Maya Sari', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(793, 3, 14, 'Nanda Kusuma', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(794, 3, 15, 'Oki Pratama', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(795, 3, 16, 'Putri Ayu', NULL, 3600000, 0, 0, 584605, 0, 0, 584605),
(796, 3, 18, 'Sinta Maharani', NULL, 3700000, 240000, 0, 600844, 170576, 0, 771420),
(797, 3, 19, 'Tio Nugroho', NULL, 3700000, 0, 0, 600844, 0, 0, 600844),
(798, 3, 22, 'Aruna Parasilva', NULL, 1000000, 0, 0, 162390, 0, 0, 162390),
(799, 3, 23, 'Tri Heru', NULL, 0, 0, 0, 0, 0, 0, 0),
(800, 3, 24, 'Sugito', NULL, 0, 0, 0, 0, 0, 0, 0),
(801, 3, 25, 'Ulya Handayani', NULL, 0, 0, 0, 0, 0, 0, 0),
(802, 4, 1, 'Adam Saputra', NULL, 4470000, 0, 0, 6002, 0, 0, 6002),
(803, 4, 2, 'Budi Santoso', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(804, 4, 3, 'Citra Dewi', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(805, 4, 5, 'Eka Prasetyo', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(806, 4, 6, 'Farah Amalia', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(807, 4, 7, 'Guntur Wibowo', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(808, 4, 9, 'Indah Permatasari', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(809, 4, 10, 'Joko Susanto', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(810, 4, 11, 'Karina Putri', NULL, 4550000, 0, 0, 6110, 0, 0, 6110),
(811, 4, 12, 'Leo Pradipta', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(812, 4, 13, 'Maya Sari', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(813, 4, 14, 'Nanda Kusuma', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(814, 4, 15, 'Oki Pratama', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(815, 4, 16, 'Putri Ayu', NULL, 4300000, 0, 0, 5774, 0, 0, 5774),
(816, 4, 18, 'Sinta Maharani', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(817, 4, 19, 'Tio Nugroho', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(818, 4, 22, 'Aruna Parasilva', NULL, 1700000, 0, 0, 2283, 0, 0, 2283),
(819, 4, 23, 'Tri Heru', NULL, 700000, 0, 0, 940, 0, 0, 940),
(820, 4, 24, 'Sugito', NULL, 300000, 0, 0, 403, 0, 0, 403),
(821, 4, 25, 'Ulya Handayani', NULL, 0, 0, 0, 0, 0, 0, 0),
(822, 4, 1, 'Adam Saputra', NULL, 4470000, 0, 0, 6002, 0, 0, 6002),
(823, 4, 2, 'Budi Santoso', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(824, 4, 3, 'Citra Dewi', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(825, 4, 5, 'Eka Prasetyo', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(826, 4, 6, 'Farah Amalia', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(827, 4, 7, 'Guntur Wibowo', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(828, 4, 9, 'Indah Permatasari', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(829, 4, 10, 'Joko Susanto', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(830, 4, 11, 'Karina Putri', NULL, 4550000, 0, 0, 6110, 0, 0, 6110),
(831, 4, 12, 'Leo Pradipta', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(832, 4, 13, 'Maya Sari', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(833, 4, 14, 'Nanda Kusuma', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(834, 4, 15, 'Oki Pratama', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(835, 4, 16, 'Putri Ayu', NULL, 4300000, 0, 0, 5774, 0, 0, 5774),
(836, 4, 18, 'Sinta Maharani', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(837, 4, 19, 'Tio Nugroho', NULL, 4400000, 0, 0, 5908, 0, 0, 5908),
(838, 4, 22, 'Aruna Parasilva', NULL, 1700000, 0, 0, 2283, 0, 0, 2283),
(839, 4, 23, 'Tri Heru', NULL, 700000, 0, 0, 940, 0, 0, 940),
(840, 4, 24, 'Sugito', NULL, 300000, 0, 0, 403, 0, 0, 403),
(841, 4, 25, 'Ulya Handayani', NULL, 0, 0, 0, 0, 0, 0, 0),
(843, 5, 1, 'Adam Saputra', '2024/07/Contoh-01', 1100000, 10000000, 372600, 50, 2000, 1000, 3050),
(844, 5, 2, 'Budi Santoso', '2024/07/Contoh-02', 1100000, 0, 0, 50, 0, 0, 50),
(845, 5, 3, 'Citra Dewi', '2024/07/Contoh-111', 1100000, 0, 0, 50, 0, 0, 50),
(846, 5, 5, 'Eka Prasetyo', '2024/07/Contoh-05', 1100000, 0, 0, 50, 0, 0, 50),
(847, 5, 6, 'Farah Amalia', '2024/07/Contoh-06', 1100000, 0, 0, 50, 0, 0, 50),
(848, 5, 7, 'Guntur Wibowo', '2024/07/Contoh-07', 1100000, 0, 0, 50, 0, 0, 50),
(849, 5, 9, 'Indah Permatasari', '2024/07/Contoh-09', 1100000, 0, 0, 50, 0, 0, 50),
(850, 5, 10, 'Joko Susanto', '2024/07/Contoh-10', 1100000, 0, 0, 50, 0, 0, 50),
(851, 5, 11, 'Karina Putri', '2024/07/Contoh-11', 1100000, 0, 0, 50, 0, 0, 50),
(852, 5, 12, 'Leo Pradipta', '2024/07/Contoh-12', 1100000, 0, 0, 50, 0, 0, 50),
(853, 5, 13, 'Maya Sari', '2024/07/Contoh-13', 1100000, 0, 0, 50, 0, 0, 50),
(854, 5, 14, 'Nanda Kusuma', '2024/07/Contoh-14', 1100000, 0, 0, 50, 0, 0, 50),
(855, 5, 15, 'Oki Pratama', '2024/07/Contoh-15', 1100000, 0, 0, 50, 0, 0, 50),
(856, 5, 16, 'Putri Ayu', '2024/07/Contoh-16', 1100000, 0, 0, 50, 0, 0, 50),
(857, 5, 18, 'Sinta Maharani', '2024/07/Contoh-18', 1100000, 0, 0, 50, 0, 0, 50),
(858, 5, 19, 'Tio Nugroho', '2024/07/Contoh-19', 1100000, 0, 0, 50, 0, 0, 50),
(859, 5, 22, 'Aruna Parasilva', '123122221', 1100000, 0, 0, 50, 0, 0, 50),
(860, 5, 23, 'Tri Heru', '1111111111111', 1100000, 0, 0, 50, 0, 0, 50),
(861, 5, 24, 'Sugito', '2222222222', 1100000, 0, 0, 50, 0, 0, 50),
(862, 5, 25, 'Ulya Handayani', '2024/07/Contoh-20', 900000, 0, 0, 41, 0, 0, 41),
(863, 6, 1, 'Adam Saputra', '2024/07/Contoh-01', 2170000, 10000000, 372600, 166838, 4500000, 3000000, 7666838),
(864, 6, 2, 'Budi Santoso', '2024/07/Contoh-02', 2100000, 0, 0, 161456, 0, 0, 161456),
(865, 6, 3, 'Citra Dewi', '2024/07/Contoh-111', 2100000, 0, 0, 161456, 0, 0, 161456),
(866, 6, 5, 'Eka Prasetyo', '2024/07/Contoh-05', 2100000, 0, 0, 161456, 0, 0, 161456),
(867, 6, 6, 'Farah Amalia', '2024/07/Contoh-06', 2100000, 0, 0, 161456, 0, 0, 161456),
(868, 6, 7, 'Guntur Wibowo', '2024/07/Contoh-07', 2100000, 0, 0, 161456, 0, 0, 161456),
(869, 6, 9, 'Indah Permatasari', '2024/07/Contoh-09', 2100000, 0, 0, 161456, 0, 0, 161456),
(870, 6, 10, 'Joko Susanto', '2024/07/Contoh-10', 2100000, 0, 0, 161456, 0, 0, 161456),
(871, 6, 11, 'Karina Putri', '2024/07/Contoh-11', 2250000, 0, 0, 172988, 0, 0, 172988),
(872, 6, 12, 'Leo Pradipta', '2024/07/Contoh-12', 2100000, 0, 0, 161456, 0, 0, 161456),
(873, 6, 13, 'Maya Sari', '2024/07/Contoh-13', 2100000, 0, 0, 161456, 0, 0, 161456),
(874, 6, 14, 'Nanda Kusuma', '2024/07/Contoh-14', 2100000, 0, 0, 161456, 0, 0, 161456),
(875, 6, 15, 'Oki Pratama', '2024/07/Contoh-15', 2100000, 0, 0, 161456, 0, 0, 161456),
(876, 6, 16, 'Putri Ayu', '2024/07/Contoh-16', 2100000, 0, 0, 161456, 0, 0, 161456),
(877, 6, 18, 'Sinta Maharani', '2024/07/Contoh-18', 2100000, 0, 0, 161456, 0, 0, 161456),
(878, 6, 19, 'Tio Nugroho', '2024/07/Contoh-19', 2100000, 0, 0, 161456, 0, 0, 161456),
(879, 6, 22, 'Aruna Parasilva', '123122221', 2100000, 0, 0, 161456, 0, 0, 161456),
(880, 6, 23, 'Tri Heru', '1111111111111', 1100000, 0, 0, 84572, 0, 0, 84572),
(881, 6, 24, 'Sugito', '2222222222', 1100000, 0, 0, 84572, 0, 0, 84572),
(882, 6, 25, 'Ulya Handayani', '2024/07/Contoh-20', 900000, 0, 0, 69195, 0, 0, 69195);

-- --------------------------------------------------------

--
-- Table structure for table `shu_session`
--

DROP TABLE IF EXISTS `shu_session`;
CREATE TABLE IF NOT EXISTS `shu_session` (
  `id_shu_session` int NOT NULL AUTO_INCREMENT,
  `uuid_shu_session` char(36) NOT NULL,
  `periode_hitung1` varchar(30) NOT NULL,
  `periode_hitung2` varchar(30) NOT NULL,
  `total_penjualan` int DEFAULT NULL,
  `total_simpanan` int DEFAULT NULL,
  `total_pinjaman` int DEFAULT NULL,
  `persen_penjualan` decimal(10,2) DEFAULT NULL,
  `persen_simpanan` decimal(10,2) DEFAULT NULL,
  `persen_pinjaman` decimal(10,2) DEFAULT NULL,
  `shu` int DEFAULT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Pending, Realisasi',
  PRIMARY KEY (`id_shu_session`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shu_session`
--

INSERT INTO `shu_session` (`id_shu_session`, `uuid_shu_session`, `periode_hitung1`, `periode_hitung2`, `total_penjualan`, `total_simpanan`, `total_pinjaman`, `persen_penjualan`, `persen_simpanan`, `persen_pinjaman`, `shu`, `status`) VALUES
(6, 'H9bd9QAbzDbn7vsiYJICiZ9UD9PR1fZmKp9g', '2024-05-01', '2025-04-02', 372600, 39020000, 10000000, 20.00, 20.00, 30.00, 15000000, 'Realisasi');

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
  `lembaga` text NOT NULL COMMENT 'lembaga anggota',
  `ranking` int NOT NULL COMMENT 'ranking anggota',
  `tanggal` date NOT NULL COMMENT 'tanggal simpanan',
  `kategori` varchar(30) NOT NULL COMMENT 'Simpanan Pokok\r\nSimpanan Wajib\r\nSimpanan Sukarela\r\nPenarikan',
  `keterangan` text,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id_simpanan`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=465 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `uuid_simpanan`, `id_anggota`, `id_akses`, `id_simpanan_jenis`, `rutin`, `nip`, `nama`, `lembaga`, `ranking`, `tanggal`, `kategori`, `keterangan`, `jumlah`) VALUES
(3, 'scOFcDNHoYM0ZKW7njU63TIcIYRezvMyvSBk', 1, 1, 3, 0, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-07-01', 'Simpanan Suka rela', '', 250000),
(4, 'hCqh8Z2lrW5YW3Wn6q4Z3BJf72gwyg9KFcnf', 11, 1, 3, 0, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-07-01', 'Simpanan Suka rela', '', 150000),
(5, '4swlziAOE2cNnXAPYHxyEIkUaTkWoK9iu9Uk', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(6, 'ZIxwLBImDjPsEvc4aFPGQ4ioiHeBvVl1W73V', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(7, 'URN54IRL2qQS8j51WwlWm2yDpPCcz2St6xcF', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(8, 'Q5aRPZGUvxiVYFsQsGKhJC7M9CtNXSiFzRJI', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(9, 'zRn2SgKQNF1bSAkyGq6AavjeMxrmwRATQs7J', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(10, 'YARyANVJ5GzNKps62N8AEWOHlXMWeqAVN6Vs', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(11, 'hepRd0QLHqvEoNFRk3lanq2XZkwAvVZvqdDy', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(12, '9kLBbyZWIVgmASPRlUeNpPAkvw0NXNFCOBV1', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(13, '4uxspSpBsFRda5sa0nVhu8F2WidR24daqgFF', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(14, 'Av0I0p3emkS5G6X1EpfGx8xkshYkWHwRrMUV', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(15, 'Fsbh376rXT3pnJg1KIEbS13JBhhQTe3CijIu', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(16, 'Mz2ptwqcmf4ECqdztWGHt3N3WFijgq6NTc0E', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(17, 'l6WMPehE87AXVxGYlgNbRtgRlzo7QJYNrkUj', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-01-01', 'Simpanan Wajib', '', 200000),
(18, '4Ra0PToiOhiclcW3U0ANJcrGVwqKyZRK1TgC', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(19, 'GFhg1wUbPl2LSsPWHTsRLNvKgMvcZXRF9hJ6', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(20, 'TpOE5u3HQumwJ3lmlt5Sp20VXxcjrfd7FvM1', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-01-01', 'Simpanan Wajib', '', 200000),
(21, 'o1yCVHA1JNqJcGTweck7kEjwdZpNphcTGLR8', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(22, 'wfUTQ643ZC5Fl66VX1iDBJnl51Kz7XSyiMUq', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(23, '08JmoKSG959oQ5O1ihxLh8QzlCxbx1eGhgAd', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(24, '780b0q5JJcQLBODVG2fP5bqOSqCMudWsqD0R', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(25, 'BsLTx4FeLam1RVIRTFYNyKNjzc0JNu97ct1o', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(26, 'wknxuvcQNGVCAqOGvybWarjk5fVrkEiIOOEQ', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(27, 'LoLBNysMER0RtAcFmPoG4xQn5pJYL3enBaXD', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(28, 'mKlvjPFIYefmuC31X4Mumr3o23zrWkaWjp6q', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(29, 'EHKopzYRlX7VeXPOSt9Y0JquYsF2src8yFej', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(30, 'onu4SvFoxWR9Vl6WqWFYfTRZoJH9xi8rT6Bj', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(31, 'FbwiTQyTy8hoCyEQQKOL5OoIRt8UfugyPiVY', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(32, 'ncNo5OVsRiTg9SJ9i2rKJJnx6ZI2AkDXqMn7', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(33, '7eklnX8KrEDsBkskngpXjYdiNjBEBzIqtJU2', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-02-01', 'Simpanan Wajib', '', 200000),
(34, 'gdJjXYWrKbTqhw5DxsiSGQZi6arboCRBN22f', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(35, 'WwMm7fUcUyONxDghByyng4oFtrp7us0Red4b', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(36, '8enTxARpZV2o323beCxEz6Pbvtk3kQCvLk3o', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 200000),
(37, 'v30SUIK8KbXGfK6rgaVMZmHiTU2JPlkw8qWl', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(38, 'Xkwru6Rdum23VFy2Y5w0e3l568pvVdbTRf3J', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(39, 'GniC7tVh1nkqfKgk3749f4Df5XICpos1XMFL', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(40, 'Mzh5CBWTbqsLjLeazzfbcy8yDT67A4KnqH4M', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(41, 'H7fM5JFo69uWyOaD3dsS44VWqa2wLo64j3pS', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(42, 'HogSwlxpOhGRDpAJaVJBEKThIoIElM2KD0b7', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(43, '0cREm6HTXIqPidthtpuTPV737EP5h2zkcHsn', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(44, '0loVtJWziDlwD8C3t2BA4Wcv3NreY08BRjGL', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(45, 'N8FdF5ltfTzuV9ixyVigUZ3pwHoY8zBHD1Lg', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(46, 'VpMrX2YIW9Xml7AD4oOp7Qw6MhCmfoBV3VZc', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(47, 'Vf1Ar6hsKUJtgaVCyrgamV4F69eWMsMBVnHW', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(48, 'OPX1ldiOhc7rqfnwB64Xv2w0bE7kXJpOrdmI', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(49, '5Gw2GSkzRcT32s2ONZr9CGGuuAdpCSy4Vf4a', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-03-01', 'Simpanan Wajib', '', 200000),
(50, 'yDdSS3icmLARUPfNnJkS7dsiVuu03nR0RVM8', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(51, 'U6TzXD3Mn5DeSMkOs9X38fOXmwLeAZdxmolk', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(52, 'cuZsU9lYkgUXuzcjYFtjPEcfy6g2kSeixzuj', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-03-01', 'Simpanan Wajib', '', 200000),
(53, 'eE51t1oDkA8B8Ep1M8IY9mcKVGVbu6ZHAB0G', 1, 1, 5, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(54, 'vZs3T3DzhuMKNcgsoG7Z4BcwF5BxVAy2Nfo4', 2, 1, 5, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(55, 'BWybxQNHdJNcmrDyyKRyTjsDy19EF7TC2PLb', 3, 1, 5, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(56, 'AA5wQgz1TapS3QkmCd9q5TDGPH3mPkBBqI1y', 5, 1, 5, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(57, 'Bygbuqvy0ePRYWlXG0eMOmB5rXy54VyssNZF', 6, 1, 5, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(58, 'Yno0wUXwYvzzJd5UqLe9uwxlucTVVlvIbQTm', 7, 1, 5, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(59, 'OjXl4sBo4NVlr8b0rm7pXBcyUNfxcyafcRLn', 9, 1, 5, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(60, '1TuBV87E7h6rzPIvcHMHNkNVcg9qIQQPUBSA', 10, 1, 5, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(61, 'zGos4koPCGYVCBlAaoiHpaMZ4iXoXfplTZIP', 11, 1, 5, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(62, 'h7sRhwibmjFjCUBzGzMrRCcUa1umBJgk7beH', 12, 1, 5, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(63, 'cWt1JQ8RIykxo8sO3RBhTijnswJC6m9aWcau', 13, 1, 5, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(64, 'GYFXE95SkK2xs0eJmFidfVdrp76EBBhS6B16', 14, 1, 5, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(65, 'TNZ8tS9ccKnEsLa35YcR2Z84K5G7bFcuaQva', 15, 1, 5, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(66, 'JcyYUkCat4ZHqJCfMDRBlTlNdTyCeWlMGwiF', 16, 1, 5, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(67, 'ar4jpTr63cKBO3FafCMNqDnURivnKjBZJx9m', 18, 1, 5, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(68, 'acBOeReg1D9HZLwzBFX3ieY0IJBleRBaighc', 19, 1, 5, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-04-01', 'Simpanan Hari Raya', '', 1000000),
(69, 'yg3bMisPUkE5rHnN3HUYstlSDe7zAVNv6xqh', 1, 1, 6, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(70, 'IgDFSZpp9E3mhjVZBE83QcpgxYMDJmU5Xa4L', 2, 1, 6, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(71, 'axze8ePA2dLo7pDgppD11z2VIqrqysgQTnY5', 3, 1, 6, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(72, 'lEb3sG1xynt9VhDsotEkJvDplVBwGchkWuDP', 5, 1, 6, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(73, 'VTcvRYx5ybRa24GfeG3IlVWvQG7SxgWziMjX', 6, 1, 6, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(74, 'bMw2JhILUVPsfDz3NpGSDZEEe2IkTXOsDYrp', 7, 1, 6, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(75, '5X4uopDjHhQnGfmCSA1jSAT8oxXm1HPLnZoS', 9, 1, 6, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(76, 'ixYJzPrC3Y0F9RNfgEXtSQy5VBUvxnJaW8Sk', 10, 1, 6, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(77, 'cVmW3DdTombsIRC3EGcZ6ustbM1W2Tb1byNq', 11, 1, 6, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(78, 'H2JBvgxeFyLsHFRxZ6VLpX4m6A9OSog61L8B', 12, 1, 6, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(79, 'C9oLJzQLx8gmWAGxmHCcSsoxvb1kPcVTsQKe', 13, 1, 6, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(80, '581wdco8qSyj51csZpV10XL7Yi9m7wJPjVsH', 14, 1, 6, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(81, 'faMd6dmzMP0AWnt0YLoKTJF5VCwj4fjQLb3s', 15, 1, 6, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(83, 'Bg2bt3ff05bOiP7GxJS26w6APwNhdyBPWxP3', 18, 1, 6, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(84, 'QcL7v7vBqLzNwXKgTvHF7EJ9aVRQTMZcEAiT', 19, 1, 6, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-01-01', 'Simpanan Loyalitas', '', 100000),
(85, 'EBANrlxJYZwgFSMvYdvCvey7SGjecOGPKspx', 1, 1, 5, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(86, 'JuvaYjZxStYVPxvfXnI1hXTCHi8k2Uieuttw', 2, 1, 5, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(87, 'luxMQRNhmesQQXdEdzEeMGpgNSaTWhbCoS74', 3, 1, 5, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(88, 'ppCf1ecWBtMPPuSFncTX6Kfp8M7SteXbHNR1', 5, 1, 5, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(89, 'NMVas5us0xdo7AEaKhuJhsoeLu9uu2agKChy', 6, 1, 5, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(90, '5rOGCwx9J11mYjuNcfE7c8DrLJdGbOfpgVXA', 7, 1, 5, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(91, 'udpsHARqYuSjg5ZnPB3C132hPS44WKmpZ6wY', 9, 1, 5, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(92, 'jeDkD676fGs0wTM7Q4wQMEsXtOO8qafHXKUT', 10, 1, 5, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(93, 'rnJFwgrVFIyitqPzovIK4sNo12FM59LKpYoO', 11, 1, 5, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(94, 'ZRcY4Zux1igdPNn2XMIOYliADYRVhWBDnjkN', 12, 1, 5, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(95, '00rBgZcEyhxEiiDNRlTt1iHJIeaTvwyumltm', 13, 1, 5, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(96, 'QLHdTt4eto5biD0NwoDb4sMHW2nQe6zijezJ', 14, 1, 5, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(97, '3Cg7LvGc6gxeXg8nqKcTadnSB0mUh8R44wCV', 15, 1, 5, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(98, 'gBnACe5R9a7D4r5Xwy3ppX4dxE9nf3KObnFG', 16, 1, 5, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(99, '9YEWw53rM2gFK5mnAwW1ci9jIdY7LAaEcI5I', 18, 1, 5, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(100, 'AbMlSygoLSkbibeWnGR93voxf8BpqLAJYsXY', 19, 1, 5, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(101, 'oELKhCGfPMPs0k6oFyYfJbOagLGz57rhagLR', 17, 1, 5, 1, '2024/07/Contoh-17', 'Rizki Setiawan', 'GIS', 2, '2024-01-01', 'Simpanan Hari Raya', '', 1000000),
(102, 'EiixffHEeoHoHt165AowomvvcyXQQFYazitF', 17, 1, 1, 1, '2024/07/Contoh-17', 'Rizki Setiawan', 'GIS', 2, '2024-02-01', 'Simpanan Wajib', '', 250000),
(103, '3QVZkzrsBsZ1rj9LR8DnmHrUQC4uM8ml6IV9', 1, 1, 0, 0, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-07-21', 'Penarikan', 'test2', 150000),
(104, '5zNYoRdPdV7E2FZsBOs2kF8coJY5Oh3F7Rq8', 1, 1, 0, 0, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-09-21', 'Penarikan', 'Penarikan karena butuh uang berobat', 10000),
(105, '5kf2i0jqGPdNDJ0OoouVMJNjc2R4HbI8A355', 1, 1, 0, 0, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-09-16', 'Penarikan', 'Kebutuhan Rumah Tangga', 20000),
(106, 'MNg14HyYuMGeZjFYSTDCVYRDI7QYfIBxTFtm', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(107, 'joT6oZ5RTYZ09rhz3Yf3N53JmK5rxEe9gVYi', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(108, '3LE9o0Rj7CcFLUQm3fzB33alZnbtAEFzu4k4', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(109, 'CuMcy4g53cmYtV0NLo7dTUImmEKDoom9pTTH', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(110, 'qMn7kBPv56NfjlF0LbaFCPti9I9rsmZKcx4o', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(111, 'VvRuEdJUJkZ2f8i0j0F9hpNIbmKahzgSWiSO', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(112, 'A9r7k8jyMQSd83lR0RBF1mLIeul4VfvHojOz', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(113, 'FQcIGDC4JEAUlVez3389dgAlBZuqkAazTDSb', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(114, 'PpsmkPnqiIsFEJNGCwgLmbTYR2ZCLm2hSoIL', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(115, 'SqBpUsyv1YxTv7yFbSFbC5unuAeHtEho3XD5', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(116, 'aQiWaR8EZ6ZXQ3rxAP5XSLQQv6dPJoPQhxGJ', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(117, '4KGyMJQ4rAZrMolzBEQpPTHZTgyiYN3lAmeQ', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(118, 'wFDMxGcSfLZLDnQQZrjspNZDPcsM9s64r9XI', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(119, 'Osc44GLA8uW3jewh1CzK2yUdw5t73Tp2hqpG', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(120, '6cShW1zi2nDNAm2vxOEVTScet68OiFGzNQZC', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(121, 'LinCIvhEE9pkbf6PYY4oWC4x89jgUFAUBUlx', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-07-01', 'Simpanan Wajib', '', 200000),
(123, 'nBMD8y1dp1NpRN2Vug4sVB0uw2jSK3tELAPb', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-07-01', 'Simpanan Wajib', '', 200000),
(124, 'LPfG0syMUJ1crvCjw8UskRtf5rfogmSX7noM', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(125, '5jFzHHw2gxdmhMpdQSyJmqAeXmdNg9q7XVxR', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(126, 'E1CCPYBFrkEAw6rRcuFhX5f8x9tnCAWUYrCj', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(127, '4pCyWxZ6drKyHNdizZQflWciHpMSD9J4I5t4', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(128, 'QGyE6r8Sw5uWnkGCD5XRxyl5gdBkRqarZEe3', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(129, '9zIplxx2XWUXA8ML88bSGoM2koW9ZtoHGfsX', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(130, 'rhrz4v2fHXuL26PxBOu6bgOZwSXqon7nx6KU', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(131, 'e9zDeZKYJRFRZXqHLB8P0WUy6pKfSN5ahq56', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(132, 'Ysm65Dl6wY1CZ8a0BjWU7Sp3XqKDyPS1xzhm', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(133, 'xJNomZhqvsIp0vCTUjh28jSs0I3Y2sLkX8zw', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(134, 'US2oc2Pc8m45LYNRaGHqXdToQ51FAmy0LijT', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(135, '6zWr2FPldPcZz9ldcVag8GmkqTRpUBNMzz8A', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(136, '96GGDmbyiZFUySaSMlGdWX0MocDZdYpmQn76', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(137, 'YSuJK5ikFEv9eF4pmp9mvilKmPOuyLBqGQdd', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(138, 'luHpO8zHCMUJAgmz1o0DBevc6xbFDRX9CdAz', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(139, 'OXhDz4APVVn4ICoPFVQMncvuCdikFwVJ7s80', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-08-01', 'Simpanan Wajib', '', 200000),
(141, 'SBaWgVc1ppPxABkSk6qhCLdhldVJAA1orB2f', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-08-01', 'Simpanan Wajib', '', 200000),
(142, '0PqLoXo4ZDHGsgDttv56q31uRek9uepIxcdW', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(143, 'XpYg4hkxeP9kgswTKp8OaxfQ8OxT5KtmaXMY', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(144, 'iO50P0Z5pJ5wRtXiOiqz06LfNRgKHUKQXD7R', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(145, 'LYl39NfxRloEYWDqTh3qpYmTu2wAwcmdzhmA', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(146, 'DNqhs4IimkTsoMaOOvDV0mm9wa5MXi7eszJj', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(147, '8sI1PiWV0Gx9fJEhELGQVY6R6FQAPPjDEHeT', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(148, 'V3CPDOEmKEospOoi8FhQBnE2XY4zQiOk8lZQ', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(149, 'n0vAe4ledpeWmM1rn8ccT1UR3ypCygCWVP4t', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(150, '7ZQLVv6WE3UvDcsDnD7pn7GmUl4JDPCIUNai', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(151, 'bYrSQeUTn0fNPQU4rfaZeaS86Z4lgIyVlrun', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(152, 'Myd2oonhb7Ry4i0RzAPUT76viGTQ5vu3twns', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(153, 'C6PjiT1HhYuFSrksDv2k2tIbyR6CoV59qceQ', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(154, 'ESdxXmTwQbpZD7rTxjgPtntxMjBqFOmIz4m1', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(155, 'WQIbVS4RRe3pu305RzrsiwxtEFLQ7IzXxPPC', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(156, 'AdQpNu4oQ4lJEAOIhuWcHGYiVtXQVKlpSq9k', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(157, 'l7DlHBda85iil0WwrwH6ibVKQFrYIig1zu07', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-09-01', 'Simpanan Wajib', '', 200000),
(159, '4mSo95UUuwyDxeDWkBviIyOcxcWnxsSWE5pf', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-09-01', 'Simpanan Wajib', '', 200000),
(160, 'Mytr37RJt5KMh4vtLNLtd9ROKKy5AMLHcq9M', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(161, 'wqsvYgBA6eVghn78QS0H5kV7hZr4KlDpMiDX', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(162, 'szYK8obKacZfFdGAOXCGPbA0K0uhmc7zH078', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(163, '3yhEE2JWr9Vu8bFLjZWps8F50Eyzt25bJWpL', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(164, 'xCX77C0TZoW2UuP4Ps57jgSP3CFALJqKUlkV', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(165, 'Y0NwN5NTmhrMB7nUfhWZJHXUcjGXpj3KHcSB', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(166, '3eXTYTyA5mowg9BzXrzdW3GkZ0XH9SfzAart', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(167, 'ZiXsoqpdNNZjsxbmEalq9REwGMUS4qRYnxFM', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(168, '54A0HGYvqzGVBqfhS7LYi7lxywRnwdUoATl1', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(169, 'VmhcmwY1LjriQsInCgNMxkSwvQytjXFO42mY', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(170, '5y9OB5V1NRGEnZKE2Xw70mRTPvPz3DjfsoFs', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(171, 'YBON7iHnDzkn7PkVDv3GC61EyeW1bFDJd8RO', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(172, '73Q9IxBB0NMAJwLgdYPYctoQ9DAIYQEGSvE4', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(173, 'pwFnFktY0k72eDr94SnuwMroYpGTWgA0GrNI', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(174, 'wj80LLmCxmaUOUUkXi00oggdU1bBNMoQloSX', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(175, 'PaMENI8oA0VXg7qnlwfpTcyy5XmaXM1cYcVh', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-05-01', 'Simpanan Wajib', '', 200000),
(177, 'TMH7x3F1mTY5fMb2DcmeAHISlFPDWuKeonRc', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-05-01', 'Simpanan Wajib', '', 200000),
(178, 'Fx3zsV324h0WCJTvpdqNiKBGPB6brxDL9EG8', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(179, '5dpWdS2nRrgB7Sh85GLJXp5JHWQ8YndwDzMQ', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(180, 'AhMKl7j1i4HnGDNRW0LbBQ3SwtNP4Q70lVlR', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(181, 'T8G5S01VNKgzg8LP7BokpkscZ1LQihohqU8j', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(182, 'U7syxxFE7eTjyBv16l4dkjrwiIgslAtmA4Dv', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(183, 'Zbl2JGNI5eqv7w3cQcdnt4A2BCeAHD7qppyD', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(184, 'lp3WqWeAkt4xFiTCse7Sc16vA76fZQWkjce0', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(185, 'R9GR7XM6nmfjYvRLV6QnUIP4RjiTA4JD30gC', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(186, 'd8zb5lYA4Q3FMWRt7uqftblUaArUR2sE8L3A', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(187, 'M8DSDRz2uDNXbT8ZvVOr9JGrQ9e6Wn2tJPke', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(188, '4keSdz6L72NkXRSlMAL4VdSEgLjCa09GtXZx', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(189, 'OrXVDs0QqI1j3MjgFWGA9qT9NLvHttA5jYAX', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(190, 'FzAeUbhZR7Azw94x5y2LHWTcuVnnSzaBeynB', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(191, 'zQtc1XoQ4AVBKgRKDOdbpIY9tQYyl5JW1gJA', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(192, 'CZFqkIM4iuETNnAMa7B1DkSmxM5hxhiUeGs1', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(193, 'hpovzi08095s0imMvBMgnV9gkFoaCj4v3CiN', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-06-01', 'Simpanan Wajib', '', 200000),
(195, 'eYsbsKxJT8FdTX3XzmBO0RnphqmFgLViUvD9', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-06-01', 'Simpanan Wajib', '', 200000),
(197, 'UYK4R1s5vNPieN6pyuPdvuUHpw7MR1cQmJOo', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(198, '62bBDRNJMRH9RAnjzowxmRXxgAG8kRufkael', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(199, '669IoKZhxtclpsFVhr0JOLFqk3sfD3sePZju', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(200, 'hVZFBNZcGhp2USW2OlasoNpJ1Kzl06aObl7m', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(201, 'oTbWxpF5I62mDXZMZsmDGQgAqveSa1CHaIjH', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(202, 'sEiTtfSyFrU9oijgB0RO1Vdq7s7kGkSJk7rJ', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(203, 'siU3Ncyy879BXcRw2BKrrhiOO86Ttq2UOmGe', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(204, 'YabwgOicABhCDmzQyhZx4mSABJy0h7S4gy4U', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(205, 'Ljgmc2dyf5YI8uHAs9frmkq1zUTG8PB4prBd', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(206, 'vV0UMShCs9MYm5Qs3FsgxgmdRQFktF0Ld3Bg', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(207, 'PLbY4Shata51Yiu4eGXRaAskqdPdsl910Kg7', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(208, 'OYQRdsTGU742PsdlridKjhtwWy0KReqsXLgq', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(209, 'fWQurG8OTz0oI3zdYXIWmjOJB4Y0ZA9tbt4t', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(210, '8XnSRgxV7pS5W1EP8bEZcdlKmKaspIFvjRPK', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(211, 'sDBJs9Xcs4P1Vpy9go0yyt2VoqO4dOF2o0QQ', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(212, '8J19OUtxXmC2OoVV9PPtCcMUQhAPSMtBErnr', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(213, 'y1IKVjwNS0VI62gBfGbzOgq3PJ8lrkTQchJa', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(214, 'fllrvlioCmfpNKRCDNiApeS3QxWatIiXdDGw', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(215, '50bMTQiel8Og5HMUTyL7YDMVQ7CHG1TuQYrv', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(216, 'nLbVXSHDRaeJx2FijPEhW2UgIeXM22b3plEs', 10, 5, 4, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(217, 'RVD1GmsnQzp5Od6Nr6smWJUdlJFdv5RixCQg', 9, 5, 4, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(218, 'HVsGVlK0a3zEXSrOJU7oyHAk2LCyPI3BoYkT', 1, 5, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(219, '1tcA53u2LUBWI26WmzHRR94BGMxFi7Z0utqy', 2, 5, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(220, '9I4B2uOjkCvPSpuwfRi5KEBHp71yZPisxWha', 3, 5, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(221, 'C17hOqjY7P52H5P1Ebh27xxkm1jClEWkXi3y', 5, 5, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(222, 'ae33iermy1SWqG0hRs1X0FURZvXzaWBFopHO', 6, 5, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(223, 'aAbHosFkGD4TN0PltRQOxSD5xBLZXMOT8Zp0', 7, 5, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(224, '8TyBazTApARjXTIHigsz6tw3nurthrIedwCB', 9, 5, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(225, 'QvfT5HSyHs8YNs7gCCKAJrkUlPnkuFjrXfyT', 10, 5, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(226, 'UCVIuqMYRWJzvrC4LSFDoClPBTni2O68gNXg', 11, 5, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(227, 'cMiC9OWGLfCQfSXmRU5HSGdg6ekKPu6JCYo1', 12, 5, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(228, 'EYYw5pEp059XAQvom9fZDYJEjd0zPhwkmqT3', 13, 5, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(229, 'yKqopv9GjfBmzS1qXUFdn2OLsURP8kVDxFXr', 14, 5, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(230, 'cQZBvs9hRzr7YDe6IgQuyIL62moS1IFZHq2X', 15, 5, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(231, 'A2ajRHvdtI4erRHtq4Z9ITKTyP6LxVrkTv08', 16, 5, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(232, 'T4DowRCXupCaWCdVYoOCNsmCTk2LbISXbmpH', 18, 5, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(318, 't3WSemcNFfDxcGTZGVoiGmmVwliBzSgOT6tp', 22, 5, 4, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(319, 'vCE51AveoqIFehUGt9ojvFCjq9486K5WedIe', 1, 5, 4, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(320, 'zvYOu2xUq9wHqFTjZc4eLYMN1vafdrfJ3wf5', 2, 5, 4, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(321, 'cUs8sHTBi62DzOF2VQtRrfytRLvP3eXgEFEd', 3, 5, 4, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(322, 'ZRJsBeMILgdQiC9iRwI6wjIe10iA1UyOi6a0', 5, 5, 4, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(323, 'KL9BRt0ha2UigKfaiC4EysJpvSZ7ho749pC1', 6, 5, 4, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(324, 'nR2jQOlpWLZuv9Ue5cBq4HCkqoe5flyq1j3Y', 7, 5, 4, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(325, 'XEpkISz4ENW0cNsqbcM40SLIceAg3Q8lawHh', 11, 5, 4, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(326, 'ZVAbxWFbLQX0OO77RnxgkOJvR2DfojXJTn3D', 12, 5, 4, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(327, 'cmmDibwBJ8tcKPZQLBFiEoTrlOVHJOaUNrm1', 13, 5, 4, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(328, 'DUzsl5Li3ZV6Gmw34EcVZoSgsnheULr3fPSH', 14, 5, 4, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(329, 'n78K5ePacoMvZg8A9yjTUDoq5cillIzY36rG', 15, 5, 4, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(330, 'HfaEsYghuq2PqmSpsRxARr8Cl1qjBNTGBS6f', 16, 5, 4, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(331, 'VyWQhMSuhJyri5ZpWjEy2t9DvUoPlBLSazhv', 18, 5, 4, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(332, '4GA4egXUitZdT2pGPlNLbgiEse08f2dC5qvL', 19, 5, 4, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(333, 'n6xwpD3lRtBr0Z7mpBf1NLjVINj0IHzUb0Tb', 1, 5, 3, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(334, 'HKvgSyjH5qbpKOMGDIPJUgVntivctDbCGFNE', 2, 5, 3, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(335, 'tdtZZMG6Zhwp9nDCfsgwZEBadzJQjm2vCN2y', 3, 5, 3, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(336, 'ruHWKBiGbBSSbGlpNPITg9NlzlAVksBdPP8k', 5, 5, 3, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(337, 'f2A9YYwZpMMgJOmhOo2o0Fi7dVZydNmR2Dyq', 6, 5, 3, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(338, 'bB9bXxl1t39FvSbLsrEelWCyWo0ifrPhq3fn', 7, 5, 3, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(339, 'BogyYAut7jcKkxxrbEbSkSIyR9flGTPzWB5f', 9, 5, 3, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(340, 'tP0ijg59Ech8ryNTdYelSXettMgF6Z0elHwl', 10, 5, 3, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(341, 'rVZBbwLq8ZgGaRLbkaATZxPVK2DZEhJwTAS7', 11, 5, 3, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(342, 'WiPIGjioHLjGkQ9MmSB87XxopZIep90y89J2', 12, 5, 3, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(343, 'xJjQk5sBfBV1UVlo3wWhnLShaqCW3Wsr3Ivn', 13, 5, 3, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(344, 'vDDlxzE7YJtRqT764Pxrv32gwiITa7xaTtOb', 14, 5, 3, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(345, 'BIT9K5O6DSHcsJVU2ElR5mxwnuDrYV0TVE5P', 15, 5, 3, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(346, 'OPvflQZ1BM9N5iHHhfUCZ3gcsBFtdLKWteYf', 16, 5, 3, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(347, 'taBOZkEaIiS8GBI8I7YkGxjB4RgtVOhEMxs7', 18, 5, 3, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(348, 'fPP8tmgdyF6VbVnMKAlcdGZGW0QM8yBNFsSg', 19, 5, 3, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(349, 'QkofXdDyPx42EyvNZdGEYIG85VzxxUTwSrfb', 22, 5, 3, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(350, '3g8f0BJdL2YJpnnsEYa66Sufh0pBIghHuTTy', 22, 5, 3, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(351, 'P5VXnvrUbVXLhpUnmJq6ZK8q3DG2LQVhItiA', 1, 5, 3, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(352, 'uQ6n08eWTm7Q35vL4MXbrMdizdCGZYFWMfJU', 2, 5, 3, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(353, '3ujVyBIZruTFao5APXlQfXJXxnqRJjTSssOs', 3, 5, 3, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(354, 'mYY2KQdu8aDoQh8vjxGLVxYVgLi8hnUuBiI0', 5, 5, 3, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(355, 'qgQWMIzOQjnnSKNYyKzxPtjD7N8mPCprQUHU', 6, 5, 3, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(356, '9evro3GPRh09IdqFH0RmVvzBNnzq2GvH3BZf', 7, 5, 3, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(357, 'oMxDOdW7etHb8IfYyI3q1QCoDL7z3Vt482ER', 9, 5, 3, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(358, '1vh20CPPvimGyzHRhOCpTrDAOSa6GsLr9LzA', 10, 5, 3, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(359, 'LHEmkRX0rVA569TX44CLaurag9QyVeQC2CAi', 11, 5, 3, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(360, 'LWBnSeTlyU26fB99NassPNSnxrWb2a9sTSmB', 12, 5, 3, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(361, 'QtFBF4yk2yeHCi12OZUt57reEvnxR1rsBxir', 13, 5, 3, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(362, '5UL0GvVW4EikJ96Qur5THhc34H2c6MtyDFdj', 14, 5, 3, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(363, 'XD9yQYlpBfZyyCB7G4cjUkW8JRMS6s6jc9vu', 15, 5, 3, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(364, 'RrYL7U8sh28jwV7vMNlIrt8LN4f041O3EYHC', 16, 5, 3, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(365, 'qnlt90Agv5jp3iFn9X5l2zRnUDrRTt8xT8x2', 18, 5, 3, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(366, 'qY6cuzUjHgd4R9OHAyjwFEDeNflLXPU1r9IK', 19, 5, 3, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(367, '02Kf1KdDXvALM9mpxmZxnHL9IDbEJ8sOqc8K', 23, 5, 4, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(368, '67GpOghyJqqt2QjHCbn45dWfiB3SRB1eaU7q', 23, 5, 1, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(369, 'VBn9P1QItmrE7TEvdxJj73lVLRn9WhfIGz7Y', 23, 5, 1, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(370, 'FS7ezPv0HrR03d2xpKfY4axMDVzRTYmEQTM0', 23, 5, 3, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela', '', 100000),
(371, 'oGBfzvnpe6BV6LL2NXHjfbu5Fcrfky8oD0Pd', 23, 5, 3, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela', '', 100000),
(372, 'TnrlqDs9BPlZQh42CP5CRJkSk3HSWwww8zkD', 24, 5, 4, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-01-01', 'Simpanan Pokok', '', 100000),
(373, 'ed4vfY7usYAlOs3RGZMEyFnIn6q3yrcD9SBa', 24, 5, 3, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-01-01', 'Simpanan Suka rela(Tabungan)', '', 100000),
(374, 'cjrcMJXKH8lyK394fRHklISX6879lgqrl0Jp', 24, 5, 3, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-02-01', 'Simpanan Suka rela(Tabungan)', '', 100000),
(376, 'ELlAxIJUvUpzADLW33v4QbnPWuLvWSnkoFEl', 24, 5, 1, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-01-20', 'Simpanan Wajib', '', 200000),
(377, 'L8c2CAskNK12qWYzeIZAIrkGYsQBqO1ASgwS', 25, 5, 1, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-01-20', 'Simpanan Wajib', '', 200000),
(378, 'MsKMqD1yc7KKlVoJr8lnejUqvQU1l2zt8Pi1', 25, 5, 1, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-02-20', 'Simpanan Wajib', '', 200000),
(379, 'ASL0P5ke0nwaRltF60SGlYZaJkLnUb7UyCCU', 24, 5, 1, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-02-20', 'Simpanan Wajib', '', 200000),
(380, 'A3w1WFlD4SIeF1cpOOG58C634796nfKntmnq', 25, 5, 4, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-01-01', 'Simpanan Pokok', '', 100000),
(382, 'xB81Hb0JWKRHSAkQGxQjVJBzO9LG8L6XR29H', 1, 6, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(383, '6j8ia3Up0nwNaPt0P0DFcI5Iig6nBJg6HbVy', 2, 6, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(384, 'pbrxheXGDxPKg0z5NEvZvR1Nw2YEBIUizUeD', 3, 6, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(385, 'RUzq5tv10h6FT2xjcQoQUKqAEKWZSC8aK1IC', 5, 6, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(386, 'TKLK16Y4N9LfkytiVSMnfWjzA8n7dnw0C6FH', 6, 6, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(387, '3zlyLOV1zLhBuQPgY1h3vnocR4Ma4SzwRrYx', 7, 6, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(388, '7waH7gJrwRBTW2C8BynOH24bbwN8GvBVkRnO', 9, 6, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(389, 'umkgUEeK8oLXRPdH0HGcQ7AFUClMHYlm7fKR', 10, 6, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(390, '9huB8y10iem7l3ZfbvkorNFXbQT12SXvyZ28', 11, 6, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(391, '1mggGbfnMraFsuugIQtGrxGibtkGfABx2VbE', 12, 6, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(392, 'F3KHTmTaM74FRXIV9B7di5IwNptUZMBu3Sj9', 13, 6, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(393, 'v6QCSjJVMPWYJPxOUEVkoT4Akpq2YsXazWCM', 14, 6, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(394, '2NJCFYtUbMpjJf12rsViu8iczqJSq5p6NA40', 15, 6, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(395, 'L813g0bxRtdjquBtAan22EVbjJQfDopGI4pR', 16, 6, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(396, 'v4IPKRYC4o4AN3LGDgGo3RyN3jILsPKHzen9', 18, 6, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(397, 'jmW9cxpUBaGDvugTYmZNXoSRqFh1UMHzkxjA', 19, 6, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(398, 'q5Lm4JlbOMczc3z66E3cYMUnDRcCmzH8Une4', 22, 6, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(399, 'hsVIjCCJ2aVxHGJ91xnYQY3q3d3NQlO1QIVF', 23, 6, 1, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(400, 'MNPX9xcBZ7OfgHjBre3m1ff8WRptnIa8rPLN', 24, 6, 1, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-03-01', 'Simpanan Wajib', '', 200000),
(401, 'UkEwiR02EciPLOG1zHo9SLvMUZOK4EcWCcJH', 25, 6, 1, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-03-01', 'Simpanan Wajib', '', 200000),
(402, 'mYBRy38EGFK7ONOzroAmrDNUfyNSXXGP85mQ', 1, 6, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(403, 'MohmZAvNTpaXMFuAscBa6EX8GuLJ4cEW8euX', 2, 6, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(404, 'yVetz4ijbHu2zepd9kaqckWaHBoE2ngXIcY2', 3, 6, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(405, 's6tiLNcm1cli0Xy8rVbSmgO8mO4WaIBz24C2', 5, 6, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(406, '1eeqjEnExygZowqYCrtCDl5nL7pzQllSoCqG', 6, 6, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(407, '2AZn2A9XNVQIOSgidUjkZ3loeOmmbfds9YSl', 7, 6, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(408, 'hBAV4XTXCAP0eFxhHz92Z0hrESQ6cb06T4DN', 9, 6, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(409, 'evNDLWWPzT17xorXT5s2B7FRfVniMiLh5l4x', 10, 6, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(410, 'emo87GjzE4LeappEWVD41SSm9V8GnVZOAI37', 11, 6, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(411, 'TXZdkPkNTPVFL7hi81BRz7OclJxgpVN6up67', 12, 6, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(412, 'doXITOCwIkKq76EpNcFO2sUCtIOzEPZd2ZtW', 13, 6, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(413, 'XyYcochWGYJMcB73dgK7NVKobDGyNwsyltXY', 14, 6, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(414, 'eXTYEW8wrpIkMaGUz528L62xW54YjMGSd1hQ', 15, 6, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(415, 'Pp4G8msYUv9DPxz3bohpJEfeSTEZfdtdO64E', 16, 6, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(416, 'sCt7ZNzNeR4fENBi9VFd6Hf0XITwnahbZNsd', 18, 6, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(417, 'YpynzGmIb4Wt6QMAZvWSuIrOUWfQ3z4GZxuW', 19, 6, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(418, 'L3JhtWppKut2uIogQpy5URLy6JkO549BfXdB', 22, 6, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(419, 'cEoSBTkWI9AGzdx76yMMqlFuXSxw9oFAm2PD', 23, 6, 1, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(420, 'wcmtY7vUhBPHfm7o5Rpu1Wqs4OmvZczW8uql', 24, 6, 1, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-04-01', 'Simpanan Wajib', '', 200000),
(421, 'aT3ohon5sxyIaKRKKdmP4YKDK3az2ErutOjf', 25, 6, 1, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-04-01', 'Simpanan Wajib', '', 200000),
(422, 'WHNJYBIAviNYeZJ7zgNXuGRpFPkNaLoIC7rs', 1, 1, 1, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(423, 'bBY2f2xJk3y1DW6Chi6dqWTqfEdVf3sX7vNb', 2, 1, 1, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(424, 'TGumRlJ74Qkgz5AGWyv9Re6PhvqOxi3lZboM', 3, 1, 1, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(425, 'IDAkiuJVqwFUJvgmOeCQhNMJNfvQXspcH7iX', 5, 1, 1, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(426, '7NIAEC7G2BsjqcF6FU5wGPT9YiD6vujxCa9U', 6, 1, 1, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(427, '0JXEiEnoHLVoTWvUEaFErGehPtsWIhB7aSQO', 7, 1, 1, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(428, 'Yj9Q0J7EmVl1bm9RAQP83OWOLY4zvbInRyTd', 9, 1, 1, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(429, 'P9Yb7Vbyzs3hfos3Emdo53FqY6qQn0NV3LfV', 10, 1, 1, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000);
INSERT INTO `simpanan` (`id_simpanan`, `uuid_simpanan`, `id_anggota`, `id_akses`, `id_simpanan_jenis`, `rutin`, `nip`, `nama`, `lembaga`, `ranking`, `tanggal`, `kategori`, `keterangan`, `jumlah`) VALUES
(430, 'ifZFnmuFBhn2S7fM1oP0pIXCCEJ4BQUTkXXC', 11, 1, 1, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(431, 'TM1r7aHXdolNaAPcQ4a7KYBdvtyDTUUqjHIl', 12, 1, 1, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(432, 'sF9bNSYrCJ18TXZpxeC4HYc6rTwRpwv6F6FJ', 13, 1, 1, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(433, '2ZU5MXJaNa3SbNntmUOR21auitedWldrYsqN', 14, 1, 1, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(434, '0YrjFnlgQja8vmNSdxDJU79VKGbThpJkIzgV', 15, 1, 1, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(435, 'kzLJLG7kBmRfpeWiIhhwUh84cZYAx5gdSW5R', 16, 1, 1, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(436, 'mwWyMNNjW3EWy2Gjm7Y73ONOxkbXUDRRSdef', 18, 1, 1, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(437, '0cFg98o4SQc905GGZkZwOIefIGlVGkADJsYL', 19, 1, 1, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(438, 'qskO6s0YowkaCQFs6m6OxMGBooE9mK9nX617', 22, 1, 1, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(439, 'fI8klELjxZdm917eqE8looyMx3bpWWORDI3P', 23, 1, 1, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(440, 'hptdJwX24naCtPfw0lnvGv07fYCY0cxXusdV', 24, 1, 1, 1, '2222222222', 'Sugito', 'GIS', 1, '2025-05-01', 'Simpanan Wajib', '', 200000),
(441, 'cKYFY6aDD7bceeO44g3Au0jeuUkytvf6vMF1', 25, 1, 1, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2025-05-01', 'Simpanan Wajib', '', 200000),
(442, 'sDzjWr2w9gm9Mipq9Nc2pTLJFRBqASnPJP99', 1, 1, 3, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-04-03', 'Simpanan Suka rela(Tabungan)', '', 100000),
(443, 'TXrcG3WUbkSW5xVlWmr5FuarHaQ8qGFgqky1', 1, 1, 3, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-04-03', 'Simpanan Suka rela(Tabungan)', '', 100000),
(444, 'ZwqQ3NqbkQyvI2PJjy0Yq48RJG6TarnGv2Ct', 1, 1, 4, 1, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(445, 'e2xWnXwmzSK1L2M2Bnr9f9o4DDlZs3iLsBO6', 2, 1, 4, 1, '2024/07/Contoh-02', 'Budi Santoso', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(446, 'RAsFeQVUmIXfXx9x1GllyD1retvra3q6vvWd', 3, 1, 4, 1, '2024/07/Contoh-111', 'Citra Dewi', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(447, 'rYdJ5jH9khKp4ynnKNR0vP63Ne1gszuZP4mA', 5, 1, 4, 1, '2024/07/Contoh-05', 'Eka Prasetyo', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(448, 'FpkYJPGo2dpNnVZVlXDDHPkbdEINTOegElZn', 6, 1, 4, 1, '2024/07/Contoh-06', 'Farah Amalia', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(449, 'kfZa0P3G4YxuzQO2BJh5u55nTByUmDDd2xnf', 7, 1, 4, 1, '2024/07/Contoh-07', 'Guntur Wibowo', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(450, 'Hf09BsPhFlTdZPz2UQHNKJfLbScWbsUTD0Ud', 9, 1, 4, 1, '2024/07/Contoh-09', 'Indah Permatasari', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(451, 'NzBzyrV2Wu1IZjUHrJ0IcnBKb03wFhkVn4v3', 10, 1, 4, 1, '2024/07/Contoh-10', 'Joko Susanto', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(452, 'DxdFlO7Azm1iIAm7GSNgwJQ6iLdoqrLvuHuG', 11, 1, 4, 1, '2024/07/Contoh-11', 'Karina Putri', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(453, 'XGC0Ugs7VLBb66JB0NI9HOCGKMh8PV5CQMHj', 12, 1, 4, 1, '2024/07/Contoh-12', 'Leo Pradipta', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(454, 'tPyKinoqvzrXAeRLeEzet8kBXAP9ecOhhuIS', 13, 1, 4, 1, '2024/07/Contoh-13', 'Maya Sari', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(455, 'gVNTbUlFUCHcpjxZlOC232j4X7fiPZNeUXw6', 14, 1, 4, 1, '2024/07/Contoh-14', 'Nanda Kusuma', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(456, 'oA1LOTPWqACRPcV4HgFDG1ZjNygqfIhocsqB', 15, 1, 4, 1, '2024/07/Contoh-15', 'Oki Pratama', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(457, 'v2rYs1ic27mjlAoOnntLt9gf9RZkROG3tzHP', 16, 1, 4, 1, '2024/07/Contoh-16', 'Putri Ayu', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(458, 'M6gIBKEgQJQvm8wqOE7vCkj5jJCKAk6XEv5B', 18, 1, 4, 1, '2024/07/Contoh-18', 'Sinta Maharani', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(459, 'fu1cXGnCtRwmZpJmtrcGpgch2kI63cuTxVNv', 19, 1, 4, 1, '2024/07/Contoh-19', 'Tio Nugroho', 'GIS', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(460, 'yGLDXB5U6P71yvXECdtZTaReOJt5RIPvkVfp', 22, 1, 4, 1, '123122221', 'Aruna Parasilva', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(461, 'oFa4hKU7U5K711zikDjX5MadijSTb8s4bfOZ', 23, 1, 4, 1, '1111111111111', 'Tri Heru', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(462, 'CCP6HLpE4IDSYMbvIVSfjvFjzrohgXoliio7', 24, 1, 4, 1, '2222222222', 'Sugito', 'GIS', 1, '2024-10-01', 'Simpanan Pokok', '', 100000),
(463, 'y7UTMc97WhSkFokdRg9CySTk5payzUEIEhaf', 25, 1, 4, 1, '2024/07/Contoh-20', 'Ulya Handayani', 'Lembaga B', 2, '2024-10-01', 'Simpanan Pokok', '', 100000),
(464, 'U4KnPyBcMDcwmDml17nKTuJI1i7M8LClt8Um', 1, 1, 4, 0, '2024/07/Contoh-01', 'Adam Saputra', 'GIS', 1, '2025-04-03', 'Penarikan', '', 100000);

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
  `id_perkiraan_debet` int NOT NULL,
  `id_perkiraan_kredit` int NOT NULL,
  PRIMARY KEY (`id_simpanan_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan_jenis`
--

INSERT INTO `simpanan_jenis` (`id_simpanan_jenis`, `nama_simpanan`, `keterangan`, `rutin`, `nominal`, `id_perkiraan_debet`, `id_perkiraan_kredit`) VALUES
(1, 'Simpanan Wajib', '', 1, 300000, 154, 163),
(3, 'Simpanan Suka rela(Tabungan)', 'Simpanan anggota atas dasar suka rela', 0, 0, 154, 163),
(4, 'Simpanan Pokok', 'Simpanan yang wajib masuk pada saat pertama kali menjadi anggota', 1, 100000, 154, 163),
(7, 'Simpanan Penghasilan', 'Simpanan yang berasal dari jumlah penghasilan', 0, 0, 155, 160);

-- --------------------------------------------------------

--
-- Table structure for table `stok_opename`
--

DROP TABLE IF EXISTS `stok_opename`;
CREATE TABLE IF NOT EXISTS `stok_opename` (
  `id_stok_opename` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1: Selesai\r\n0: Dalam Pengerjaan',
  PRIMARY KEY (`id_stok_opename`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_opename`
--

INSERT INTO `stok_opename` (`id_stok_opename`, `tanggal`, `status`) VALUES
(1, '2025-02-01', 0),
(2, '2025-02-02', 1),
(3, '2025-02-03', 1),
(5, '2025-02-05', 0),
(6, '2025-02-06', 1),
(7, '2025-02-07', 0),
(9, '2025-02-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stok_opename_barang`
--

DROP TABLE IF EXISTS `stok_opename_barang`;
CREATE TABLE IF NOT EXISTS `stok_opename_barang` (
  `id_stok_opename_barang` int NOT NULL AUTO_INCREMENT,
  `id_stok_opename` int NOT NULL,
  `id_barang` int NOT NULL,
  `stok_awal` decimal(10,2) DEFAULT NULL,
  `stok_akhir` decimal(10,2) DEFAULT NULL,
  `stok_gap` decimal(10,2) DEFAULT NULL,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_stok_opename_barang`),
  KEY `to_so` (`id_stok_opename`),
  KEY `to_barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_opename_barang`
--

INSERT INTO `stok_opename_barang` (`id_stok_opename_barang`, `id_stok_opename`, `id_barang`, `stok_awal`, `stok_akhir`, `stok_gap`, `harga_beli`, `jumlah`) VALUES
(1, 9, 110, 100.00, 90.00, -10.00, 110000.00, -1100000.00),
(2, 9, 106, 100.00, 80.00, -20.00, 1200.00, -24000.00),
(3, 9, 104, 100.00, 100.00, 0.00, 2500.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` text NOT NULL,
  `alamat_supplier` text,
  `email_supplier` text,
  `kontak_supplier` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `email_supplier`, `kontak_supplier`) VALUES
(1, 'PT.Kimia Farma', 'Jalan anggrek 4 no 15', 'kimiafarma@gmail.com', '2176444553'),
(2, 'PT.Sanbe Farma', 'Jalan Raya Pasar Pagi No 14', 'sanbefarma@gmail.com', '2315634512'),
(5, 'PT. RAJAWALI NUSINDO', 'Jalan anggrek 4 no 15 - 02315634544', 'rajawalinusindo@gmail.com', '2315634544'),
(6, 'PT.Armala Putra', 'Jalan Anggrek 4 no 15', 'armalaputra@gmail.com', '23254647'),
(7, 'CV. SANITA KARUNIA MANDIRI', 'Jalan Raya Pasar Pagi No 14', 'mandirikaruniasanita@gmail.com', '2176444553'),
(8, 'PT. MTA ALKES INDO', 'Jalan Raya Pasar Pagi No 14', '123@GMAIL.COM', '2176444553'),
(9, 'PT.Indah Medis Jaya', 'Jalan Siliwangi no 15', 'indahmedis@gmail.com', '2328765585'),
(10, 'PT.Wings Food', 'Jalan Raya Pasar Pagi No 14', 'wingsfood@gmail.com', '227856'),
(13, 'PT.Indah Medis Jaya', 'Jalan Raya Pasar Pagi No 142', 'wingsfood22@gmail.com', '2278562'),
(14, 'PT.Indofood tbk', 'Jalamn', 'indofood@gmail.com', '345345667'),
(15, 'JVC Kuningan', 'Jalamn', 'jvc@gmail.com', '4235456'),
(16, 'PT.Medic Islam', 'Jalan Hayam Wuruk no 12 Jakarta timur', 'MedicIsalam@gmail.com', '22546467'),
(17, 'PTT.Indah Permai', 'Jalan Raya Pasar Pagi No 14', 'indahpermai@gmail.com', '123123'),
(18, 'PTT.Indah Permai2', 'Jalan Raya Pasar Pagi No 14', 'indahpermai2@gmail.com', '12121212');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `uuid_transaksi` char(32) NOT NULL,
  `id_transaksi_jenis` int DEFAULT NULL,
  `nama_transaksi` text NOT NULL COMMENT 'Nama transaksi dari jenis',
  `kategori` text NOT NULL COMMENT 'Kategori dari jenis',
  `tanggal` datetime NOT NULL COMMENT 'Tanggal beralngsungnnya transaksi',
  `jumlah` int DEFAULT NULL,
  `pembayaran` int DEFAULT NULL,
  `status` varchar(7) DEFAULT NULL COMMENT 'Lunas, Utang, Piutang',
  PRIMARY KEY (`id_transaksi`),
  KEY `id_transaksi_jenis` (`id_transaksi_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `uuid_transaksi`, `id_transaksi_jenis`, `nama_transaksi`, `kategori`, `tanggal`, `jumlah`, `pembayaran`, `status`) VALUES
(13, 'Vm9DsHeGiU9VjVX9gGn9TcdZ8Nb3NyO0', 3, 'ATK', 'Beban Perlengkapan', '2024-08-11 00:05:27', 35000, 35000, 'Lunas'),
(14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 2, 'Gaji Staf', 'Gaji', '2024-08-11 00:17:26', 11000000, 6000000, 'Lunas'),
(16, 'X1crhyZmG2RanlaiIwvuunn0rUmbBEQX', 1, 'Listrik dan Air', 'Biaya Operasional Kantor', '2024-08-11 02:08:12', 12000, 12000, 'Lunas'),
(17, 'PPjFbUTUEkyWeJV5IdFoWId4egCKUaJ9', 3, 'ATK', 'Beban Perlengkapan', '2024-08-11 05:35:56', 15000, 15000, 'Lunas'),
(18, 'U6D6GAHo5GiWv9MacJW2XkfypHkTWfjS', 2, 'Gaji Staf', 'Gaji', '2024-01-05 01:37:03', 6500000, 6500000, 'Lunas'),
(19, 'thGcnhcCxs1LHBiPwK3hGw6Ke4uiefNb', 3, 'ATK', 'Beban Perlengkapan', '2024-09-19 21:42:13', 100000, 100000, 'Lunas'),
(20, 'Gr8BmHaXT5wckhNtesyo0BMT2ox9q88y', 3, 'ATK', 'Beban Perlengkapan', '2025-02-22 01:48:27', 65000, 65000, 'Lunas'),
(22, '67606352644125568139520743013373', 5, 'Beban Pajak Penghasilan', 'Beban Pajak', '2025-04-03 00:19:51', 100000, 100000, 'Lunas'),
(23, '92085391979233568469181179157482', 3, 'Beban ATK', 'Beban Perlengkapan', '2025-04-03 00:22:39', 20000, 20000, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_bulk`
--

DROP TABLE IF EXISTS `transaksi_bulk`;
CREATE TABLE IF NOT EXISTS `transaksi_bulk` (
  `id_transaksi_bulk` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `kategori` varchar(15) NOT NULL COMMENT 'Penjualan, Pembelian, Retur Penjualan, Retur Pembelian',
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `ppn` decimal(10,2) DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_bulk`),
  KEY `id_akses` (`id_akses`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COMMENT='Datara rincian transaksi sementara';

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_jenis`
--

DROP TABLE IF EXISTS `transaksi_jenis`;
CREATE TABLE IF NOT EXISTS `transaksi_jenis` (
  `id_transaksi_jenis` int NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `kategori` text NOT NULL COMMENT 'Operasional, Gaji dll',
  `deskripsi` text,
  `id_akun_debet` int DEFAULT NULL COMMENT 'Akun perkiraan di lajur debet',
  `id_akun_kredit` int NOT NULL COMMENT 'Akun perkiraan di lajur kredit',
  PRIMARY KEY (`id_transaksi_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_jenis`
--

INSERT INTO `transaksi_jenis` (`id_transaksi_jenis`, `nama`, `kategori`, `deskripsi`, `id_akun_debet`, `id_akun_kredit`) VALUES
(1, 'Beban Listrik dan Air', 'Biaya Operasional Kantor', 'Pembayaran iuran listrik dan air kantor', 114, 155),
(2, 'Beban Gaji Staf', 'Beban Gaji', 'Pembayaran gaji staf bulanan', 80, 152),
(3, 'Beban ATK', 'Beban Perlengkapan', 'Pembelian ATK sepoerti pencil, pena, tinta dll', 98, 135),
(4, 'Beban Pajak PBB', 'Beban Pajak', 'Pajak bumi bangunan kantor koperasi', 83, 152),
(5, 'Beban Pajak Penghasilan', 'Beban Pajak', 'Pembayaran Pajak Penghasilan', 83, 152);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_jual_beli`
--

DROP TABLE IF EXISTS `transaksi_jual_beli`;
CREATE TABLE IF NOT EXISTS `transaksi_jual_beli` (
  `id_transaksi_jual_beli` char(36) NOT NULL,
  `id_anggota` int DEFAULT NULL,
  `id_supplier` int DEFAULT NULL,
  `kategori` varchar(15) NOT NULL COMMENT 'Penjualan, Pembelian, Retur Penjualan, Retur Pembelian',
  `tanggal` datetime NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `diskon` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `ppn` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `total` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `cash` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `kembalian` decimal(10,2) DEFAULT NULL COMMENT 'RP',
  `status` varchar(10) NOT NULL COMMENT 'Lunas, Kredit',
  PRIMARY KEY (`id_transaksi_jual_beli`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_supplier` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_jual_beli`
--

INSERT INTO `transaksi_jual_beli` (`id_transaksi_jual_beli`, `id_anggota`, `id_supplier`, `kategori`, `tanggal`, `subtotal`, `diskon`, `ppn`, `total`, `cash`, `kembalian`, `status`) VALUES
('5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', 19, NULL, 'Penjualan', '2025-04-02 16:19:00', 120000.00, 0.00, 0.00, 120000.00, 150000.00, 30000.00, 'Lunas'),
('cCuZBSPb97TGDVxl8I8RDbSRoKgQW0MxS8jh', 1, NULL, 'Penjualan', '2025-02-26 01:12:00', 121200.00, 0.00, 0.00, 121200.00, 150000.00, 28800.00, 'Lunas'),
('g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', NULL, NULL, 'Pembelian', '2025-04-02 16:22:00', 2500.00, 0.00, 0.00, 2500.00, 0.00, 0.00, 'Kredit'),
('HFY6ibbDqHJuTcEDL2i1yvLGjmgKIqFDLVV2', 25, NULL, 'Penjualan', '2025-04-02 15:32:00', 120000.00, 0.00, 0.00, 120000.00, 0.00, 0.00, 'Kredit'),
('InZRNjXySMQC6gVU0Ubhg2te44i4PwkeXk3r', 1, NULL, 'Penjualan', '2025-02-26 01:04:00', 252000.00, 600.00, 0.00, 251400.00, 260000.00, 8600.00, 'Lunas'),
('iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', NULL, NULL, 'Pembelian', '2025-04-02 16:26:00', 110000.00, 0.00, 0.00, 110000.00, 200000.00, 90000.00, 'Lunas'),
('nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', NULL, NULL, 'Penjualan', '2025-02-26 01:24:00', 240000.00, 0.00, 0.00, 240000.00, 250000.00, 10000.00, 'Lunas'),
('QykQPMxwqJHqFn3jMgstnd3FhPH36HfabjQj', NULL, NULL, 'Penjualan', '2025-02-26 01:39:00', 120000.00, 0.00, 0.00, 120000.00, 0.00, 0.00, 'Kredit');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_jual_beli_rincian`
--

DROP TABLE IF EXISTS `transaksi_jual_beli_rincian`;
CREATE TABLE IF NOT EXISTS `transaksi_jual_beli_rincian` (
  `id_transaksi_jual_beli_rincian` int NOT NULL AUTO_INCREMENT,
  `id_transaksi_jual_beli` char(36) NOT NULL,
  `id_barang` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `ppn` decimal(10,2) DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_jual_beli_rincian`),
  KEY `id_transaksi_jual_beli` (`id_transaksi_jual_beli`),
  KEY `id_barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_jual_beli_rincian`
--

INSERT INTO `transaksi_jual_beli_rincian` (`id_transaksi_jual_beli_rincian`, `id_transaksi_jual_beli`, `id_barang`, `nama_barang`, `satuan`, `qty`, `harga`, `ppn`, `diskon`, `subtotal`) VALUES
(1, 'InZRNjXySMQC6gVU0Ubhg2te44i4PwkeXk3r', 106, 'Kopi Arabica', 'PCS', 10.00, 1200.00, 0.00, 600.00, 11400.00),
(2, 'InZRNjXySMQC6gVU0Ubhg2te44i4PwkeXk3r', 110, 'Beras 10 Kg', 'Kg', 2.00, 120000.00, 0.00, 0.00, 240000.00),
(3, 'cCuZBSPb97TGDVxl8I8RDbSRoKgQW0MxS8jh', 106, 'Kopi Arabica', 'PCS', 1.00, 1200.00, 0.00, 0.00, 1200.00),
(4, 'cCuZBSPb97TGDVxl8I8RDbSRoKgQW0MxS8jh', 110, 'Beras 10 Kg', 'Kg', 1.00, 120000.00, 0.00, 0.00, 120000.00),
(5, 'nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', 105, 'Kopi Gadjah', 'Sachet', 1.00, 0.00, 0.00, 0.00, 0.00),
(6, 'nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', 98, 'Lifebuoy Hairfall Trmt 9ml', 'RCG', 1.00, 0.00, 0.00, 0.00, 0.00),
(7, 'nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', 102, 'Rinso Pewangi', 'Pcs', 1.00, 0.00, 0.00, 0.00, 0.00),
(8, 'nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', 104, 'Rinso Pewangi', 'Pcs', 1.00, 0.00, 0.00, 0.00, 0.00),
(9, 'nlGRhXP0BADC89e5EhTUaQhszX0UuaHHTRjP', 110, 'Beras 10 Kg', 'Kg', 2.00, 120000.00, 0.00, 0.00, 240000.00),
(10, 'QykQPMxwqJHqFn3jMgstnd3FhPH36HfabjQj', 110, 'Beras 10 Kg', 'Kg', 1.00, 120000.00, 0.00, 0.00, 120000.00),
(11, 'HFY6ibbDqHJuTcEDL2i1yvLGjmgKIqFDLVV2', 110, 'Beras 10 Kg', 'Kg', 1.00, 120000.00, 0.00, 0.00, 120000.00),
(12, '5hNgU66pOv6D3zEeeZD72QgE0PlYp7VzqHrn', 110, 'Beras 10 Kg', 'Kg', 1.00, 120000.00, 0.00, 0.00, 120000.00),
(13, 'g8UmVFGyESzGcVnGHD5VxpFCQbYMfncMJL81', 103, 'Rinso Pewangi', 'Pcs', 1.00, 2500.00, 0.00, 0.00, 2500.00),
(14, 'iww8VSRzyRde7DO4CZiCDhyoIdoKAIj3SrHf', 110, 'Beras 10 Kg', 'Kg', 1.00, 110000.00, 0.00, 0.00, 110000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembayaran`
--

DROP TABLE IF EXISTS `transaksi_pembayaran`;
CREATE TABLE IF NOT EXISTS `transaksi_pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int DEFAULT NULL,
  `id_akses` int DEFAULT NULL,
  `id_anggota` int DEFAULT NULL,
  `id_supplier` int DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `tanggal` varchar(30) NOT NULL,
  `metode` varchar(20) NOT NULL,
  `jumlah` int DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_pembayaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_ppn`
--

DROP TABLE IF EXISTS `transaksi_ppn`;
CREATE TABLE IF NOT EXISTS `transaksi_ppn` (
  `id_transaksi_ppn` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int DEFAULT NULL,
  `id_akses` int NOT NULL,
  `ppn_persen` int NOT NULL,
  `ppn_rp` int NOT NULL,
  PRIMARY KEY (`id_transaksi_ppn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_rincian`
--

DROP TABLE IF EXISTS `transaksi_rincian`;
CREATE TABLE IF NOT EXISTS `transaksi_rincian` (
  `id_transaksi_rincian` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int DEFAULT NULL,
  `uuid_transaksi` char(32) DEFAULT NULL,
  `rincian_transaksi` text,
  `harga` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `satuan` text,
  `jumlah` int DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_rincian`),
  KEY `id_transaksi` (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_rincian`
--

INSERT INTO `transaksi_rincian` (`id_transaksi_rincian`, `id_transaksi`, `uuid_transaksi`, `rincian_transaksi`, `harga`, `qty`, `satuan`, `jumlah`) VALUES
(9, 14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 'Syamsul', 1500000, 1, 'Bulan', 1500000),
(10, 14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 'Bayu Anugerah', 2000000, 1, 'Bulan', 2000000),
(11, 14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 'Solihul hadi', 2500000, 1, 'Bulan', 2500000),
(12, 14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 'Maya', 3000000, 1, 'Bulan', 3000000),
(13, 14, '4PuJ6Jot3QuaZjFbKptb3GhFk9PPNRWi', 'Dewi Widiastuti', 2000000, 1, 'Bulan', 2000000),
(14, 17, 'PPjFbUTUEkyWeJV5IdFoWId4egCKUaJ9', 'Pulpen', 2000, 5, 'PCS', 10000),
(15, 17, 'PPjFbUTUEkyWeJV5IdFoWId4egCKUaJ9', 'Penghapus', 500, 10, 'PCS', 5000),
(16, 13, 'Vm9DsHeGiU9VjVX9gGn9TcdZ8Nb3NyO0', 'Pena', 1500, 10, 'PCS', 15000),
(17, 13, 'Vm9DsHeGiU9VjVX9gGn9TcdZ8Nb3NyO0', 'Tinta', 20000, 1, 'PCS', 20000),
(18, 18, 'U6D6GAHo5GiWv9MacJW2XkfypHkTWfjS', 'Syamsul maarif', 1500000, 1, 'Bulan', 1500000),
(19, 18, 'U6D6GAHo5GiWv9MacJW2XkfypHkTWfjS', 'Bayu Anugerah', 2000000, 1, 'Bulan', 2000000),
(20, 18, 'U6D6GAHo5GiWv9MacJW2XkfypHkTWfjS', 'Nida Amalia', 3000000, 1, 'Bulan', 3000000),
(21, 20, 'Gr8BmHaXT5wckhNtesyo0BMT2ox9q88y', 'Pencsil', 2000, 10, 'PCS', 20000),
(22, 20, 'Gr8BmHaXT5wckhNtesyo0BMT2ox9q88y', 'Pena', 3000, 15, 'PCS', 45000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_setting`
--

DROP TABLE IF EXISTS `transaksi_setting`;
CREATE TABLE IF NOT EXISTS `transaksi_setting` (
  `id_transaksi_setting` int NOT NULL AUTO_INCREMENT,
  `id_akses` int NOT NULL,
  `ppn` varchar(20) NOT NULL,
  `ppn_set_persen` int DEFAULT NULL,
  PRIMARY KEY (`id_transaksi_setting`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_setting`
--

INSERT INTO `transaksi_setting` (`id_transaksi_setting`, `id_akses`, `ppn`, `ppn_set_persen`) VALUES
(1, 1, 'Yes', 10);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akses_ijin`
--
ALTER TABLE `akses_ijin`
  ADD CONSTRAINT `ijin_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ijin_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_login`
--
ALTER TABLE `akses_login`
  ADD CONSTRAINT `login_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akses_referensi`
--
ALTER TABLE `akses_referensi`
  ADD CONSTRAINT `referensi_to_entitas` FOREIGN KEY (`uuid_akses_entitas`) REFERENCES `akses_entitas` (`uuid_akses_entitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referensi_to_fitur` FOREIGN KEY (`id_akses_fitur`) REFERENCES `akses_fitur` (`id_akses_fitur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_bacth`
--
ALTER TABLE `barang_bacth`
  ADD CONSTRAINT `batch_to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_diskon`
--
ALTER TABLE `barang_diskon`
  ADD CONSTRAINT `diskon_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_harga`
--
ALTER TABLE `barang_harga`
  ADD CONSTRAINT `harga_to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `harga_to_kategori` FOREIGN KEY (`id_barang_kategori_harga`) REFERENCES `barang_kategori_harga` (`id_barang_kategori_harga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  ADD CONSTRAINT `satuan_to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_to_angsuran` FOREIGN KEY (`id_pinjaman_angsuran`) REFERENCES `pinjaman_angsuran` (`id_pinjaman_angsuran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_to_pinjaman` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_to_shu` FOREIGN KEY (`id_shu_session`) REFERENCES `jurnal` (`id_jurnal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_to_simpanan` FOREIGN KEY (`id_simpanan`) REFERENCES `simpanan` (`id_simpanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_to_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `stok_opename_barang`
--
ALTER TABLE `stok_opename_barang`
  ADD CONSTRAINT `to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_so` FOREIGN KEY (`id_stok_opename`) REFERENCES `stok_opename` (`id_stok_opename`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_bulk`
--
ALTER TABLE `transaksi_bulk`
  ADD CONSTRAINT `bulk_to_akses` FOREIGN KEY (`id_akses`) REFERENCES `akses` (`id_akses`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bulk_to_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_jual_beli`
--
ALTER TABLE `transaksi_jual_beli`
  ADD CONSTRAINT `transaksi_to_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_to_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
