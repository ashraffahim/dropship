/*
SQLyog Community v12.2.5 (64 bit)
MySQL - 10.4.24-MariaDB : Database - grap_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`grap_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `grap_db`;

/*Table structure for table `buyer` */

DROP TABLE IF EXISTS `buyer`;

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_phone` int(11) DEFAULT NULL,
  `b_country` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_timestamp` int(11) NOT NULL,
  `b_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `buyer` */

insert  into `buyer`(`id`,`b_first_name`,`b_last_name`,`b_email`,`b_password`,`b_phone`,`b_country`,`b_timestamp`,`b_latimestamp`) values 
(1,'Ashraful','Islam','ashraf.fahim75@gmail.com','21232f297a57a5a743894a0e4a801fc3',NULL,'AE',1652729647,1652729647);

/*Table structure for table `draft_edited_product` */

DROP TABLE IF EXISTS `draft_edited_product`;

CREATE TABLE `draft_edited_product` (
  `id` int(11) NOT NULL,
  `dp_image` tinyint(3) DEFAULT NULL,
  `dp_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_price` decimal(10,2) NOT NULL,
  `dp_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_category_spec` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_category_spec`)),
  `dp_custom_field` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_custom_field`)),
  `dp_badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_badge`)),
  `dp_variation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_status` tinyint(1) NOT NULL,
  `dp_o_status` tinyint(1) DEFAULT NULL,
  `dp_sellerstamp` int(11) NOT NULL,
  `dp_operatorstamp` int(11) DEFAULT NULL,
  `dp_timestamp` int(11) NOT NULL,
  `dp_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Product Seller` (`dp_sellerstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `draft_edited_product` */

/*Table structure for table `draft_new_product` */

DROP TABLE IF EXISTS `draft_new_product`;

CREATE TABLE `draft_new_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dp_image` tinyint(3) DEFAULT NULL,
  `dp_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_price` decimal(10,2) NOT NULL,
  `dp_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_category_spec` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_category_spec`)),
  `dp_custom_field` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_custom_field`)),
  `dp_badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dp_badge`)),
  `dp_variation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_status` tinyint(1) NOT NULL,
  `dp_o_status` tinyint(1) DEFAULT NULL,
  `dp_sellerstamp` int(11) NOT NULL,
  `dp_operatorstamp` int(11) DEFAULT NULL,
  `dp_timestamp` int(11) NOT NULL,
  `dp_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Product Seller` (`dp_sellerstamp`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `draft_new_product` */

insert  into `draft_new_product`(`id`,`dp_image`,`dp_name`,`dp_category`,`dp_price`,`dp_description`,`dp_brand`,`dp_model`,`dp_category_spec`,`dp_custom_field`,`dp_badge`,`dp_variation`,`dp_status`,`dp_o_status`,`dp_sellerstamp`,`dp_operatorstamp`,`dp_timestamp`,`dp_latimestamp`) values 
(3,NULL,'Test 2','Test 2','123.00','Test 2','Test','Test',NULL,'{\"1\": \"2\"}',NULL,NULL,1,0,5,1,1652358513,1652358513);

/*Table structure for table `operator` */

DROP TABLE IF EXISTS `operator`;

CREATE TABLE `operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_first_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_last_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_username` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_password` text CHARACTER SET utf8mb4 NOT NULL,
  `o_email` varbinary(50) DEFAULT NULL,
  `o_position` int(11) NOT NULL DEFAULT 0,
  `o_permit` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `operator` */

insert  into `operator`(`id`,`o_first_name`,`o_last_name`,`o_username`,`o_password`,`o_email`,`o_position`,`o_permit`) values 
(1,'A','I','root','21232f297a57a5a743894a0e4a801fc3','ashraf.fahim75@gmail.com',0,1),
(2,'Ashraful','Islam','jk','5ad9bc9f6a29e906964dcb09e730364f','ashraf@yopmail.com',0,0);

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_currency` char(3) NOT NULL,
  `o_buyer` int(11) NOT NULL,
  `o_discount` decimal(4,2) DEFAULT NULL,
  `o_service_charge` decimal(5,2) DEFAULT NULL,
  `o_ship_cost` decimal(6,2) DEFAULT NULL,
  `o_ship_address_1` varchar(50) DEFAULT NULL,
  `o_ship_address_2` varchar(50) DEFAULT NULL,
  `o_ship_country` char(2) DEFAULT NULL,
  `o_ship_city` varchar(30) DEFAULT NULL,
  `o_ship_po_box` varchar(10) DEFAULT NULL,
  `o_ship_mobile` int(11) DEFAULT NULL,
  `o_ship_email` varchar(100) DEFAULT NULL,
  `o_status` tinyint(1) NOT NULL,
  `o_timestamp` int(11) NOT NULL,
  `o_latimestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `order` */

insert  into `order`(`id`,`o_currency`,`o_buyer`,`o_discount`,`o_service_charge`,`o_ship_cost`,`o_ship_address_1`,`o_ship_address_2`,`o_ship_country`,`o_ship_city`,`o_ship_po_box`,`o_ship_mobile`,`o_ship_email`,`o_status`,`o_timestamp`,`o_latimestamp`) values 
(1,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',1,1653330882,1656762306),
(2,'AED',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1656342622,1656342622),
(3,'BDT',1,'0.00','36.90','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1656344058,1656344058),
(4,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1656344228,1656762779),
(5,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',1,1657052013,1657052013),
(6,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657052357,1657052357),
(7,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657054296,1657054296),
(8,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657055926,1657055926),
(9,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',1,1657056143,1657056143),
(10,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657139607,1657139607),
(11,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657139853,1657139853),
(12,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657140186,1657140186),
(13,'BDT',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657140769,1657140769),
(14,'AED',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657455913,1657455913),
(15,'AED',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',1,1657456214,1657456214),
(16,'AED',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657457498,1657457498),
(17,'AED',1,'0.00','6.15','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf.fahim75@gmail.com',0,1657457852,1657457852),
(18,'AED',1,'0.00','22.50','0.00','308, Al Saud Building - A Block, Street: 6 - Al Mu','','AE','Sharjah','63891',525187677,'ashraf@yopmail.com',0,1657477185,1657477202),
(19,'AED',1,'0.00','25.00','0.00','','',NULL,'','',0,'',0,1657919040,1657919040);

/*Table structure for table `order_item` */

DROP TABLE IF EXISTS `order_item`;

CREATE TABLE `order_item` (
  `oi_invoice` int(11) NOT NULL,
  `oi_product` int(11) NOT NULL,
  `oi_qty` int(11) NOT NULL,
  `oi_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `order_item` */

insert  into `order_item`(`oi_invoice`,`oi_product`,`oi_qty`,`oi_price`) values 
(2,3,1,'123.00'),
(3,2,3,'123.00'),
(3,4,3,'123.00'),
(1,2,1,'123.00'),
(4,2,1,'123.00'),
(5,2,1,'123.00'),
(6,2,1,'123.00'),
(7,2,1,'123.00'),
(8,2,1,'123.00'),
(9,2,1,'123.00'),
(10,2,1,'123.00'),
(11,2,1,'123.00'),
(12,2,1,'123.00'),
(13,2,1,'123.00'),
(14,3,1,'123.00'),
(15,3,1,'123.00'),
(16,3,1,'123.00'),
(17,3,1,'123.00'),
(18,3,1,'450.00'),
(19,1,1,'500.00');

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_order` int(11) NOT NULL,
  `p_method` int(11) NOT NULL,
  `p_secret` varchar(100) DEFAULT NULL,
  `p_status` tinyint(1) DEFAULT NULL,
  `p_timestamp` int(11) NOT NULL,
  `p_latimestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `payment` */

insert  into `payment`(`id`,`p_order`,`p_method`,`p_secret`,`p_status`,`p_timestamp`,`p_latimestamp`) values 
(1,1,1,'pi_3LFJDAIoGl18YWC81ib1JjBS_secret_ym32CkDItLiqupJao1q0yoKgE',1,1656341771,1656341771),
(2,2,1,'pi_3LFJa0IoGl18YWC81ExOeb55_secret_LUXX21vRmQ6WfDC1P5ooIa2s2',0,1656342640,1656342640),
(3,3,1,'pi_3LFJxBIoGl18YWC81FB4qCAG_secret_spgTWqALwcENXS8RIIgqzp7S5',0,1656344218,1656344218),
(4,4,1,'pi_3LH4skIoGl18YWC80SRRvvcU_secret_U2XtglYtz9mcyGFPOZzcq2mfP',0,1656762792,1656762792),
(5,5,1,'pi_3LII7oIoGl18YWC8223CAb12_secret_ZlqYat5FTDe3geLNxgiIBtPXu',1,1657052028,1657052028),
(6,6,1,'pi_3LIIDNIoGl18YWC82kC9PRFa_secret_xCP1Bzlmytrr7DvkERGjIS37l',0,1657052373,1657052373),
(7,7,1,'pi_3LIIicIoGl18YWC80Qdal6Np_secret_3x81fyVj4bwo3NJ0DRCMrZDQV',0,1657054311,1657054311),
(8,8,1,'pi_3LIJ8vIoGl18YWC82urNqGS4_secret_3nZuSQyeoIjYjH8juCFIj5Cr1',0,1657055944,1657055944),
(9,9,1,'pi_3LIJCQIoGl18YWC829MTMMts_secret_ZaAvB0jEEmw5F3vHm80FazmDL',0,1657056157,1657056157),
(10,10,1,'pi_3LIeuhIoGl18YWC81WoEsPja_secret_v75f8VQ2DnaQbHnQEHyU44JFO',0,1657139629,1657139629),
(11,11,1,'pi_3LIeyZIoGl18YWC80Z4ap0d9_secret_waJAd2k4Xk8zCl7DCBPDrqlbu',1,1657139873,1657139873),
(12,12,1,'pi_3LIf3wIoGl18YWC80QRxnZFM_secret_y02Yr1eWMiN086a3Mmy7c4nL8',0,1657140200,1657140200),
(13,13,1,'pi_3LIfDLIoGl18YWC82fKDRilO_secret_gVBtPU3ki9EVgliThGmxXOExQ',1,1657140783,1657140783),
(14,14,1,'pi_3LJzCOIoGl18YWC828dkgWrM_secret_on9ztNtcVIawqTo68MTheCpMo',0,1657455964,1657455964),
(15,15,1,'pi_3LJzHAIoGl18YWC80nY3aeWR_secret_vJIvMN0VeoEtxNEMZhDLEKJ8V',0,1657456230,1657456230),
(16,16,1,'pi_3LJzbsIoGl18YWC80hv23KsO_secret_8BkkTszFBsP4VEIYwsvX1aDmy',0,1657457512,1657457512),
(17,17,1,'pi_3LJzhaIoGl18YWC80ILYG7ri_secret_p9RcfeeWIdp4JyI7nGLdUBl74',0,1657457867,1657457867),
(18,18,1,'pi_3LK4jsIoGl18YWC82FGQAZpv_secret_BnXFiMRCdjDXFrvEx1zxNxrSj',0,1657477230,1657477230);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_image` tinyint(3) DEFAULT NULL,
  `p_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_category_spec` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`p_category_spec`)),
  `p_custom_field` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`p_custom_field`)),
  `p_badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`p_badge`)),
  `p_variation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_status` tinyint(1) NOT NULL,
  `p_o_status` tinyint(1) NOT NULL,
  `p_sellerstamp` int(11) NOT NULL,
  `p_operatorstamp` int(11) DEFAULT NULL,
  `p_timestamp` int(11) NOT NULL,
  `p_latimestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Product Seller` (`p_sellerstamp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`p_image`,`p_name`,`p_category`,`p_price`,`p_description`,`p_brand`,`p_model`,`p_category_spec`,`p_custom_field`,`p_badge`,`p_variation`,`p_status`,`p_o_status`,`p_sellerstamp`,`p_operatorstamp`,`p_timestamp`,`p_latimestamp`) values 
(1,2,'The 100','Radioactive Planet','500.00','Test summary','Clarke','Lexa',NULL,'{\"ok\": \"ko\", \"Test\": \"200\"}',NULL,NULL,1,1,5,1,1652451061,1652451061),
(2,4,'House M.D','Difficult to deal with doctor','320.00','Test summary\r\nLine break','House','MD',NULL,'{\"ko\": \"Lorem ipsum delorem\", \"ok\": \"ko\", \"Test\": \"200\", \"Lorem ipsum delorem\": \"ok\"}',NULL,NULL,1,1,4,1,1652451858,1652451858),
(3,2,'Brooklyn 99','Andy\'s the best','450.00','Test summary','Amy','Gina',NULL,'{\"ok\": \"ko\", \"Test\": \"200\"}',NULL,NULL,1,1,5,1,1652452125,1652452125),
(4,2,'Dark','Eerie','400.00','Test summary','Time','Travel',NULL,'{\"ok\": \"ko\"}',NULL,NULL,1,1,4,1,1652452248,1652452248);

/*Table structure for table `seller` */

DROP TABLE IF EXISTS `seller`;

CREATE TABLE `seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_phone` int(11) DEFAULT NULL,
  `s_country` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_currency` char(3) DEFAULT NULL,
  `s_timestamp` int(11) NOT NULL,
  `s_latimestamp` int(11) DEFAULT NULL,
  `s_status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `seller` */

insert  into `seller`(`id`,`s_first_name`,`s_last_name`,`s_email`,`s_password`,`s_phone`,`s_country`,`s_currency`,`s_timestamp`,`s_latimestamp`,`s_status`) values 
(1,'Ashraful','Islam','ashraf.fahim75@gmail.com','21232f297a57a5a743894a0e4a801fc3',525187677,'AE','AED',1651944790,1651944790,1),
(2,'Ashraful','Islam','ashraf@yopmail.com','61475c493c89bdcf90488f8f6e63381c',NULL,'AE','AED',1652180775,1652180775,1),
(3,'Test','1','test1@yopmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'AE','AED',1652181080,1652181080,1),
(4,'Test','2','test2@yopmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'AE','BDT',1652181170,1652181170,1),
(5,'Test','3','test3@yopmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'AE','AED',1652181296,1652181296,1);

/*Table structure for table `sys_charge` */

DROP TABLE IF EXISTS `sys_charge`;

CREATE TABLE `sys_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `amount` decimal(10,5) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sys_charge` */

insert  into `sys_charge`(`id`,`name`,`amount`,`type`) values 
(1,'service','0.05000',1);

/*Table structure for table `sys_country` */

DROP TABLE IF EXISTS `sys_country`;

CREATE TABLE `sys_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` char(2) NOT NULL,
  `currency` char(3) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `phone` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `sys_country` */

insert  into `sys_country`(`id`,`name`,`code`,`currency`,`currency_symbol`,`phone`) values 
(1,'Bangladesh','BD','BDT','৳',880),
(2,'United Arab Emirates','AE','AED','إ.د',971);

/*Table structure for table `sys_nav` */

DROP TABLE IF EXISTS `sys_nav`;

CREATE TABLE `sys_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `icon` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `query_string` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL,
  `is` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `sys_nav` */

insert  into `sys_nav`(`id`,`title`,`icon`,`query_string`,`root`,`position`,`is`) values 
(1,'System',NULL,NULL,NULL,NULL,0),
(2,'Configuration','fa fa-sliders-h','',1,0,0),
(3,'Index','','configuration/index',2,0,0),
(4,'Operator','far fa-user','',1,0,10),
(5,'Manage','','user/add',8,0,1),
(6,'Users','','user/approve',8,0,10),
(7,'Privilege','','user/privilege',8,0,10),
(8,'Profile','','user/profile',8,0,10),
(9,'Home',NULL,NULL,NULL,0,0),
(10,'Home','fa fa-home','home/index',9,0,1),
(11,'Approve Product','fa fa-sliders-h','product/index',9,0,1),
(12,'Accounts',NULL,NULL,NULL,NULL,0),
(13,'Transactions','fa fa-money-bill','',12,0,0),
(14,'Index','','transaction/index',13,0,0);

/*Table structure for table `sys_payment_method` */

DROP TABLE IF EXISTS `sys_payment_method`;

CREATE TABLE `sys_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `key` varchar(100) DEFAULT NULL,
  `secret` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `sys_payment_method` */

insert  into `sys_payment_method`(`id`,`name`,`code`,`key`,`secret`) values 
(1,'Credit Card','stripe',NULL,NULL),
(2,'Debit Card','stripe',NULL,NULL),
(3,'bKash','bkash',NULL,NULL),
(4,'Bank','stripe',NULL,NULL);

/*Table structure for table `sys_privilege` */

DROP TABLE IF EXISTS `sys_privilege`;

CREATE TABLE `sys_privilege` (
  `uid` int(11) NOT NULL,
  `nav` int(11) NOT NULL,
  `permit` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_privilege` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
