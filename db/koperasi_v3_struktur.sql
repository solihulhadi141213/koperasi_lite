-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2025 at 09:07 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='pengaturan pada saat pembayaran angsuran';

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Datara rincian transaksi sementara';

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
