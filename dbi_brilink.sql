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
  `id_bayar` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `md_jenis` */

insert  into `md_jenis`(`id_jenis`,`jenis`,`id_bayar`,`status`,`created_at`,`updated_at`) values 
(1,'BRI','1,2,4,5',1,'2020-12-21 21:35:46','2020-12-21 23:12:02'),
(2,'BNI','1,2,4,5',1,'2020-12-21 23:11:56',NULL),
(3,'Permata','',1,'2020-12-21 23:16:18',NULL),
(4,'Pospay',NULL,1,'2020-12-21 23:16:51',NULL),
(5,'Dana Tunai',NULL,1,'2020-12-21 23:16:56',NULL);

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
  `nominal` int(20) DEFAULT NULL,
  `id_jenis` int(10) DEFAULT NULL,
  `keterangan` varchar(300) DEFAULT NULL,
  `piutang` int(20) DEFAULT NULL,
  `admin` int(20) DEFAULT NULL,
  `bayar` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `delete` int(1) DEFAULT 0,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `md_transaksi` */

insert  into `md_transaksi`(`id_transaksi`,`kode`,`tanggal`,`nominal`,`id_jenis`,`keterangan`,`piutang`,`admin`,`bayar`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete`) values 
(2,'AN6900013','2020-12-21',9000000,1,'tes22',900000,100000,'kredit','2020-12-21 22:50:12',NULL,'2020-12-22 00:15:13',1,0),
(3,'AN6900015','2020-12-21',20000,2,'tes22',900000,100000,'kredit','2020-12-21 22:50:12',NULL,'2020-12-22 00:15:13',1,0),
(4,'AN6900014','2020-12-21',8000,2,'tes223',900000,100000,'kredit','2020-12-21 22:50:12',NULL,'2020-12-22 00:15:13',1,0);

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
