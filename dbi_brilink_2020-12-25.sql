# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.14-MariaDB)
# Database: dbi_brilink
# Generation Time: 2020-12-25 04:39:43 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table md_bayar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_bayar`;

CREATE TABLE `md_bayar` (
  `id_bayar` int(10) NOT NULL AUTO_INCREMENT,
  `bayar` varchar(50) DEFAULT NULL,
  `operator` char(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `md_bayar` WRITE;
/*!40000 ALTER TABLE `md_bayar` DISABLE KEYS */;

INSERT INTO `md_bayar` (`id_bayar`, `bayar`, `operator`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'Debit',NULL,1,'2020-12-21 21:08:43',NULL),
	(2,'Kredit',NULL,1,'2020-12-21 21:08:53',NULL),
	(3,'Lain-lain',NULL,1,'2020-12-21 21:08:58',NULL),
	(4,'Admin','-',1,'2020-12-21 21:09:03','2020-12-21 21:15:53'),
	(5,'Piutang','+',1,'2020-12-21 21:09:41','2020-12-21 21:15:48');

/*!40000 ALTER TABLE `md_bayar` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table md_jenis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_jenis`;

CREATE TABLE `md_jenis` (
  `id_jenis` int(10) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) DEFAULT NULL,
  `saldo_awal` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `md_jenis` WRITE;
/*!40000 ALTER TABLE `md_jenis` DISABLE KEYS */;

INSERT INTO `md_jenis` (`id_jenis`, `jenis`, `saldo_awal`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'BRI',83600054,1,'2020-12-21 21:35:46','2020-12-21 23:12:02'),
	(2,'BNI',8000000,1,'2020-12-21 23:11:56',NULL),
	(3,'Permata',NULL,1,'2020-12-21 23:16:18',NULL),
	(4,'Pospay',NULL,1,'2020-12-21 23:16:51',NULL),
	(5,'Dana Tunai',NULL,1,'2020-12-21 23:16:56',NULL);

/*!40000 ALTER TABLE `md_jenis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table md_rekap
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_rekap`;

CREATE TABLE `md_rekap` (
  `id_rekap` int(10) NOT NULL AUTO_INCREMENT,
  `id_jenis` int(10) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `saldo` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `kredit` int(10) DEFAULT NULL,
  `tunai` int(10) DEFAULT NULL,
  `admin1` int(10) DEFAULT NULL,
  `admin2` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_rekap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `md_rekap` WRITE;
/*!40000 ALTER TABLE `md_rekap` DISABLE KEYS */;

INSERT INTO `md_rekap` (`id_rekap`, `id_jenis`, `tgl`, `saldo`, `debit`, `kredit`, `tunai`, `admin1`, `admin2`)
VALUES
	(16,1,'2020-12-01',54847054,29703000,950000,28768000,10000,5000),
	(17,2,'2020-12-01',7905000,100000,5000,100000,0,0),
	(18,3,'2020-12-01',0,0,0,0,0,0),
	(19,4,'2020-12-01',0,0,0,0,0,0),
	(20,5,'2020-12-01',0,0,0,0,0,0),
	(21,1,'2020-12-02',48359954,51355100,16100000,35312100,27000,30000),
	(22,2,'2020-12-02',7905000,100000,0,100000,0,0),
	(23,3,'2020-12-02',0,0,0,0,0,0),
	(24,4,'2020-12-02',0,0,0,0,0,0),
	(25,5,'2020-12-02',99274154,0,30000,0,0,0),
	(26,6,'2020-12-02',0,0,0,0,0,0),
	(27,6,'2020-12-01',0,0,0,0,0,0);

/*!40000 ALTER TABLE `md_rekap` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table md_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_setting`;

CREATE TABLE `md_setting` (
  `id_setting` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pimpinan` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `fav` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `md_setting` WRITE;
/*!40000 ALTER TABLE `md_setting` DISABLE KEYS */;

INSERT INTO `md_setting` (`id_setting`, `nama_pimpinan`, `alamat`, `perusahaan`, `email`, `no_telp`, `no_hp`, `logo`, `fav`)
VALUES
	(1,'Fulan','Kota Jambi, Jambi 36129','Brilink ANTIQ','antiq@gmail.com','0741 82920','09876','8fc1e0dfa1963d4e5fc5a8e2a65f8806.png',NULL);

/*!40000 ALTER TABLE `md_setting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table md_transaksi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_transaksi`;

CREATE TABLE `md_transaksi` (
  `id_transaksi` int(10) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `debit` int(10) DEFAULT 0,
  `kredit` int(10) DEFAULT 0,
  `admin1` int(10) DEFAULT 0,
  `admin2` int(10) DEFAULT 0,
  `piutang` int(20) DEFAULT 0,
  `id_jenis` int(10) DEFAULT NULL,
  `keterangan` varchar(300) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `delete` int(1) DEFAULT 0,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `md_transaksi` WRITE;
/*!40000 ALTER TABLE `md_transaksi` DISABLE KEYS */;

INSERT INTO `md_transaksi` (`id_transaksi`, `kode`, `tanggal`, `debit`, `kredit`, `admin1`, `admin2`, `piutang`, `id_jenis`, `keterangan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `delete`)
VALUES
	(5,'AN8400001','2020-12-01',3000,0,5000,0,0,1,'','2020-12-22 19:26:40',1,'2020-12-23 09:10:32',1,0),
	(6,'AN7600002','2020-12-01',3700000,0,0,0,0,1,'','2020-12-22 19:27:01',1,NULL,NULL,0),
	(7,'AN4100003','2020-12-01',1000000,0,5000,0,0,1,'','2020-12-22 19:27:17',1,NULL,NULL,0),
	(8,'AN1100004','2020-12-01',0,950000,0,5000,945000,1,'','2020-12-22 19:27:40',1,NULL,NULL,0),
	(9,'AN3200005','2020-12-01',25000000,0,0,0,0,1,'','2020-12-22 19:27:55',1,NULL,NULL,0),
	(10,'AN3600006','2020-12-23',NULL,10000,NULL,0,0,1,'','2020-12-23 08:02:42',1,NULL,NULL,0),
	(11,'AN3600007','2020-12-01',10000000,0,NULL,0,0,2,'','2020-12-23 08:02:42',1,NULL,NULL,0),
	(12,'AN3600007','2020-12-01',0,4000000,NULL,0,0,2,'','2020-12-23 08:02:42',1,NULL,NULL,0),
	(13,'AN8300008','2020-12-02',0,1000000,0,5000,995000,1,'','2020-12-24 08:52:40',1,NULL,NULL,0),
	(14,'AN1100009','2020-12-02',100,0,0,0,0,1,'','2020-12-24 08:53:39',1,'2020-12-24 08:53:58',1,0),
	(15,'AN6000010','2020-12-02',15002000,0,5000,0,0,1,'','2020-12-24 08:58:35',1,NULL,NULL,0),
	(16,'AN5600011','2020-12-02',3000,0,0,0,0,1,'','2020-12-24 09:18:44',1,NULL,NULL,0),
	(17,'AN1000012','2020-12-02',1000000,0,5000,0,0,1,'','2020-12-24 09:19:07',1,NULL,NULL,0),
	(18,'AN3500013','2020-12-02',4050000,0,7000,0,0,1,'','2020-12-24 09:27:34',1,NULL,NULL,0),
	(20,'AN9000015','2020-12-02',0,13000000,0,15000,12985000,1,'','2020-12-24 09:28:46',1,NULL,NULL,0),
	(21,'AN3500016','2020-12-02',3000,0,0,0,0,1,'','2020-12-24 09:29:24',1,NULL,NULL,0),
	(22,'AN8900017','2020-12-02',1300000,0,5000,0,0,1,'','2020-12-24 09:29:43',1,NULL,NULL,0),
	(23,'AN7500018','2020-12-02',3000,0,0,0,0,1,'','2020-12-24 09:30:12',1,NULL,NULL,0),
	(24,'AN1100019','2020-12-02',1200000,0,5000,0,0,1,'','2020-12-24 09:30:24',1,NULL,NULL,0),
	(25,'AN6200020','2020-12-02',3000,0,0,0,0,1,'','2020-12-24 09:30:34',1,NULL,NULL,0),
	(26,'AN8600021','2020-12-02',20000,0,0,0,0,1,'','2020-12-24 09:30:41',1,NULL,NULL,0),
	(27,'AN1500022','2020-12-02',0,2000000,0,5000,1995000,1,'','2020-12-24 09:30:59',1,NULL,NULL,0),
	(28,'AN3400023','2020-12-02',0,100000,0,5000,95000,1,'','2020-12-24 09:31:10',1,NULL,NULL,0),
	(29,'AN3000024','2020-12-02',3000,0,0,0,0,1,'','2020-12-24 09:35:38',1,NULL,NULL,0),
	(30,'AN3000024','2020-12-02',0,10000,0,0,0,5,'','2020-12-24 09:35:38',1,NULL,NULL,0),
	(31,'AN8400025','2020-12-02',0,20000,0,0,0,5,'','2020-12-25 11:06:25',1,NULL,NULL,0);

/*!40000 ALTER TABLE `md_transaksi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table md_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `md_user`;

CREATE TABLE `md_user` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  `password` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `md_user` WRITE;
/*!40000 ALTER TABLE `md_user` DISABLE KEYS */;

INSERT INTO `md_user` (`id_user`, `nama_lengkap`, `email`, `status`, `password`, `no_hp`, `foto`, `created_at`, `updated_at`)
VALUES
	(1,'Admin','admin@gmail.com',1,'21232f297a57a5a743894a0e4a801fc3','222','e284c124839d7b1881240390797f5378.jpg','2020-10-17 20:31:11','2020-11-14 11:30:41'),
	(17,'Beni','beni@gmail.com',0,'b94ce3c426a5ab6032624ab62a2b0b95','098762222222','6e9e715d2906089442224246a8b52089.jpg','2020-12-21 21:43:42','2020-12-21 21:43:54');

/*!40000 ALTER TABLE `md_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
