-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 25, 2026 at 06:31 PM
-- Server version: 5.7.40-log
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dev_e_reyog`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `ID` int(4) NOT NULL,
  `IDLEVEL` int(4) NOT NULL,
  `JABATAN` varchar(255) NOT NULL,
  `KET` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`ID`, `IDLEVEL`, `JABATAN`, `KET`) VALUES
(1, 1, 'Pengelola Sistem', 'Memiliki kontrol penuh atas sistem. Mengatur pengelolaan data pengguna, konfigurasi sistem, dan kebijakan umum dll\r\n'),
(2, 2, 'Tata Kelola Administrasi', 'Bertanggung jawab atas pengelolaan data, termasuk data Induk, Data Advis, master data dll.'),
(4, 3, 'Kepala Dinas', 'Memantau kinerja, kebijakan, Mengawasi proses sistem secara keseluruhan.'),
(6, 5, 'Pengguna App', 'User Pengguna App, Melakukan Pengajuan Advis dll\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `ID` int(11) NOT NULL,
  `LEVEL` varchar(155) DEFAULT NULL,
  `ICON` varchar(30) NOT NULL,
  `KATEGORI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`ID`, `LEVEL`, `ICON`, `KATEGORI`) VALUES
(1, 'Super Admin', 'bx bx-user-pin', '1'),
(2, 'Admin', 'bx bx-user-pin', '1'),
(3, 'Kepala', 'bx bx-user-pin', '1'),
(4, 'Staf', 'bx bx-user-pin', '1'),
(5, 'User', 'bx bx-user-pin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `ID` char(12) NOT NULL,
  `USER_ID` varchar(50) DEFAULT NULL,
  `AKSI` text,
  `MODUL` varchar(100) DEFAULT NULL,
  `IP_ADDRESS` varchar(45) DEFAULT NULL,
  `USER_AGENT` varchar(255) DEFAULT NULL,
  `WAKTU` datetime DEFAULT CURRENT_TIMESTAMP,
  `TIMEZONE` varchar(50) DEFAULT 'Unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_activity`
--
 

--
-- Table structure for table `tb_user_app`
--

CREATE TABLE `tb_user_app` (
  `IDUSERS` varchar(11) NOT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `BEARER` text,
  `OTP` varchar(6) DEFAULT NULL,
  `OTP_EXPIRED_AT` datetime DEFAULT NULL,
  `ENTRYBY` varchar(30) DEFAULT NULL,
  `ACCOUNT` char(10) NOT NULL DEFAULT 'OPENED' COMMENT 'opened, blocked',
  `LASTLOGIN` datetime DEFAULT NULL,
  `LAST_IP_ADDRESS` varchar(45) DEFAULT NULL,
  `FAILED_ATTEMPTS` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user_app`
--

INSERT INTO `tb_user_app` (`IDUSERS`, `USERNAME`, `PASSWORD`, `BEARER`, `OTP`, `OTP_EXPIRED_AT`, `ENTRYBY`, `ACCOUNT`, `LASTLOGIN`, `LAST_IP_ADDRESS`, `FAILED_ATTEMPTS`, `created_at`, `updated_at`) VALUES
('101', '123412341234', '8cb2237d0679ca88db6464eac60da96345513964', 'WjNLSlZOaGErM1l5MC93aFNIWHN1eWFaNmtxdFhQNlFmcVg1QitrYmEwcHdaN3hzb0F2ME9jamlQMlRYZkN0OEJBN1B3cWl1eXNqRzQxSHRqS3VaK0JxRHYxVnZzRmozaXFVT1JzTVRRbUVZakQ2VkhEYWVXbGJZVXduVHgwZzBxb2Y0Q2VYR1ZycEI2dHNBWnZiaGJkN2JtR1k4Q0RlcjlWVmVyVi84MjhXWXZvQVduMTFlZm80R2xadVZPQ0dFYW9oOFdzSDlXL0wxZXFXU0o1UWRvS203QzVnZlhNN3NtZDFBcS9lKy82Nk9Mcnh5Rm9WRFkwKy82UXhFMFUxaTo6zCRI6gdLOp3FlOxEa3s9rQ==', NULL, NULL, NULL, 'OPENED', NULL, NULL, 0, '2025-11-23 02:42:22', '2026-01-06 03:53:14');
-- --------------------------------------------------------

--
-- Table structure for table `user_pengguna`
--

CREATE TABLE `user_pengguna` (
  `IDPENGGUNA` char(36) NOT NULL,
  `IDJABATAN` int(11) NOT NULL DEFAULT '6',
  `STATUS` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `nik` text NOT NULL,
  `nip` bigint(20) NOT NULL DEFAULT '0',
  `NAMADEPAN` text NOT NULL,
  `kelamin` int(2) NOT NULL,
  `tmp_lahir` text NOT NULL,
  `tgl_lahir` char(50) NOT NULL,
  `alamat_ktp` text NOT NULL,
  `no_hp` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL,
  `pangkat` varchar(200) NOT NULL DEFAULT '-',
  `plt` varchar(200) NOT NULL DEFAULT '-',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_pengguna`
--

INSERT INTO `user_pengguna` (`IDPENGGUNA`, `IDJABATAN`, `STATUS`, `nik`, `nip`, `NAMADEPAN`, `kelamin`, `tmp_lahir`, `tgl_lahir`, `alamat_ktp`, `no_hp`, `email`, `password`, `foto`, `pangkat`, `plt`, `created_at`, `updated_at`) VALUES
('101', 6, 'aktif', '35021018089000035454', 0, 'Umang Prasetyo', 1, 'Ponorogo', '1990-12-08', 'JL Raya-ITS Kampus PENS Sukolilo', '081252215067', 'umang@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '8-239147504.png', '-', '-', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDLEVEL` (`IDLEVEL`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_user_app`
--
ALTER TABLE `tb_user_app`
  ADD PRIMARY KEY (`IDUSERS`);

--
-- Indexes for table `user_pengguna`
--
ALTER TABLE `user_pengguna`
  ADD PRIMARY KEY (`IDPENGGUNA`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`IDLEVEL`) REFERENCES `level` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
