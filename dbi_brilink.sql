/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.13-MariaDB : Database - dbi_brilink
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbi_brilink` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbi_brilink`;

/*Table structure for table `md_bayar` */

DROP TABLE IF EXISTS `md_bayar`;

CREATE TABLE `md_bayar` (
  `id_bayar` int(10) NOT NULL AUTO_INCREMENT,
  `bayar` varchar(50) DEFAULT NULL,
  `operator` char(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `md_bayar` */

insert  into `md_bayar`(`id_bayar`,`bayar`,`operator`,`status`,`created_at`,`updated_at`) values 
(1,'Debit',NULL,1,'2020-12-21 21:08:43',NULL),
(2,'Kredit',NULL,1,'2020-12-21 21:08:53',NULL),
(3,'Lain-lain',NULL,1,'2020-12-21 21:08:58',NULL),
(4,'Admin','-',1,'2020-12-21 21:09:03','2020-12-21 21:15:53'),
(5,'Piutang','+',1,'2020-12-21 21:09:41','2020-12-21 21:15:48');

/*Table structure for table `md_jenis` */

DROP TABLE IF EXISTS `md_jenis`;

CREATE TABLE `md_jenis` (
  `id_jenis` int(10) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) DEFAULT NULL,
  `saldo_awal` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `md_jenis` */

insert  into `md_jenis`(`id_jenis`,`jenis`,`saldo_awal`,`status`,`created_at`,`updated_at`) values 
(1,'BRI',83600054,1,'2020-12-21 21:35:46','2020-12-21 23:12:02'),
(2,'BNI',8000000,1,'2020-12-21 23:11:56',NULL),
(3,'Permata',NULL,1,'2020-12-21 23:16:18',NULL),
(4,'Pospay',500000,1,'2020-12-21 23:16:51',NULL),
(5,'Dana Tunai',NULL,1,'2020-12-21 23:16:56',NULL);

/*Table structure for table `md_rekap` */

DROP TABLE IF EXISTS `md_rekap`;

CREATE TABLE `md_rekap` (
  `id_rekap` int(10) NOT NULL AUTO_INCREMENT,
  `id_jenis` int(10) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `saldo_awal` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `kredit` int(10) DEFAULT NULL,
  `tunai` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_rekap`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `md_rekap` */

insert  into `md_rekap`(`id_rekap`,`id_jenis`,`tgl`,`saldo_awal`,`debit`,`kredit`,`tunai`) values 
(1,1,'2020-12-01',54857054,29703000,960000,0),
(2,2,'2020-12-01',-95000,100000,5000,0),
(3,3,'2020-12-01',0,0,0,0),
(4,4,'2020-12-01',0,0,0,0),
(5,5,'2020-12-01',0,0,0,0),
(6,1,'2020-12-25',83597054,3000,0,0),
(7,2,'2020-12-25',83597054,3000,0,0),
(8,3,'2020-12-25',83597054,3000,0,0),
(9,4,'2020-12-25',84097054,3000,0,0),
(10,5,'2020-12-25',84097054,3000,0,0),
(11,1,'2020-12-31',83597054,3000,0,NULL),
(12,2,'2020-12-31',-100000,100000,0,NULL),
(13,3,'2020-12-31',0,0,0,NULL),
(14,4,'2020-12-31',0,0,0,NULL),
(15,5,'2020-12-31',0,0,0,NULL);

/*Table structure for table `md_setting` */

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `md_setting` */

insert  into `md_setting`(`id_setting`,`nama_pimpinan`,`alamat`,`perusahaan`,`email`,`no_telp`,`no_hp`,`logo`,`fav`) values 
(1,'Fulan','Kota Jambi, Jambi 36129','Brilink ANTIQ','antiq@gmail.com','0741 82920','09876','8fc1e0dfa1963d4e5fc5a8e2a65f8806.png',NULL);

/*Table structure for table `md_transaksi` */

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `md_transaksi` */

insert  into `md_transaksi`(`id_transaksi`,`kode`,`tanggal`,`debit`,`kredit`,`admin1`,`admin2`,`piutang`,`id_jenis`,`keterangan`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete`) values 
(5,'AN8400001','2020-12-01',3000,0,5000,0,0,1,'','2020-12-22 19:26:40',1,'2020-12-23 09:10:32',1,0),
(6,'AN7600002','2020-12-01',3700000,0,0,0,0,1,'','2020-12-22 19:27:01',1,NULL,NULL,0),
(7,'AN4100003','2020-12-01',1000000,0,5000,0,0,1,'','2020-12-22 19:27:17',1,NULL,NULL,0),
(8,'AN1100004','2020-12-01',0,950000,0,5000,945000,1,'','2020-12-22 19:27:40',1,NULL,NULL,0),
(9,'AN3200005','2020-12-01',25000000,0,0,0,0,1,'','2020-12-22 19:27:55',1,NULL,NULL,0),
(10,'AN3600006','2020-12-23',NULL,10000,NULL,0,0,1,'','2020-12-23 08:02:42',1,NULL,NULL,0),
(11,'AN3600007','2020-12-01',100000,0,NULL,0,0,2,'','2020-12-23 08:02:42',1,NULL,NULL,0),
(12,'AN3600007','2020-12-01',0,5000,NULL,0,0,2,'','2020-12-23 08:02:42',1,NULL,NULL,0);

/*Table structure for table `md_user` */

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `md_user` */

insert  into `md_user`(`id_user`,`nama_lengkap`,`email`,`status`,`password`,`no_hp`,`foto`,`created_at`,`updated_at`) values 
(1,'Admin','admin@gmail.com',1,'21232f297a57a5a743894a0e4a801fc3','','e284c124839d7b1881240390797f5378.jpg','2020-10-17 20:31:11','2020-11-14 11:30:41'),
(17,'Beni','beni@gmail.com',0,'b94ce3c426a5ab6032624ab62a2b0b95','098762222222','6e9e715d2906089442224246a8b52089.jpg','2020-12-21 21:43:42','2020-12-21 21:43:54');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
