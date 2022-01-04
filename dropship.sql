/*
SQLyog Community v12.2.5 (64 bit)
MySQL - 5.7.21 : Database - dropship_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dropship_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `dropship_db`;

/*Table structure for table `buyer` */

DROP TABLE IF EXISTS `buyer`;

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_phone` int(11) DEFAULT NULL,
  `b_country` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_timestamp` int(11) NOT NULL,
  `b_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `buyer` */

/*Table structure for table `draft_product` */

DROP TABLE IF EXISTS `draft_product`;

CREATE TABLE `draft_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dp_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_handle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_price` decimal(10,2) NOT NULL,
  `dp_description` text COLLATE utf8mb4_unicode_ci,
  `dp_brand` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_category_spec` json DEFAULT NULL,
  `dp_custom_field` json DEFAULT NULL,
  `dp_badge` json DEFAULT NULL,
  `dp_variation` text COLLATE utf8mb4_unicode_ci,
  `dp_status` tinyint(1) NOT NULL,
  `dp_o_status` tinyint(1) DEFAULT NULL,
  `dp_sellerstamp` int(11) NOT NULL,
  `dp_operatorstamp` int(11) DEFAULT NULL,
  `dp_timestamp` int(11) NOT NULL,
  `dp_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Product Seller` (`dp_sellerstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `draft_product` */

/*Table structure for table `operator` */

DROP TABLE IF EXISTS `operator`;

CREATE TABLE `operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_first_name` varchar(20) NOT NULL,
  `o_last_name` varchar(20) NOT NULL,
  `o_username` varchar(20) NOT NULL,
  `o_password` varchar(50) NOT NULL,
  `o_email` varbinary(50) DEFAULT NULL,
  `o_position` int(11) NOT NULL DEFAULT '0',
  `o_permit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `operator` */

insert  into `operator`(`id`,`o_first_name`,`o_last_name`,`o_username`,`o_password`,`o_email`,`o_position`,`o_permit`) values 
(1,'System','Administrator','root','5ad9bc9f6a29e906964dcb09e730364f','ashraf.fahim75@gmail.com',0,1);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_handle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_description` text COLLATE utf8mb4_unicode_ci,
  `p_brand` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_category_spec` json DEFAULT NULL,
  `p_custom_field` json DEFAULT NULL,
  `p_badge` json DEFAULT NULL,
  `p_variation` text COLLATE utf8mb4_unicode_ci,
  `p_status` tinyint(1) NOT NULL,
  `p_o_status` tinyint(1) NOT NULL,
  `p_sellerstamp` int(11) NOT NULL,
  `p_operatorstamp` int(11) DEFAULT NULL,
  `p_timestamp` int(11) NOT NULL,
  `p_latimestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Product Seller` (`p_sellerstamp`),
  CONSTRAINT `Product Seller` FOREIGN KEY (`p_sellerstamp`) REFERENCES `seller` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product` */

/*Table structure for table `seller` */

DROP TABLE IF EXISTS `seller`;

CREATE TABLE `seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_phone` int(11) DEFAULT NULL,
  `s_country` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_timestamp` int(11) NOT NULL,
  `s_latimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `seller` */

/*Table structure for table `sys_nav` */

DROP TABLE IF EXISTS `sys_nav`;

CREATE TABLE `sys_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `icon` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `query_string` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL,
  `is` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sys_nav` */

insert  into `sys_nav`(`id`,`title`,`icon`,`query_string`,`root`,`position`,`is`) values 
(1,'System',NULL,NULL,NULL,NULL,0),
(2,'Configuration','fa fa-sliders-h','',1,0,0),
(3,'Index','','configuration/index',2,0,0),
(4,'Operator','far fa-user','',1,0,1),
(5,'Manage','','user/add',8,0,1),
(6,'Users','','user/approve',8,0,10),
(7,'Privilege','','user/privilege',8,0,10),
(8,'Profile','','user/profile',8,0,10),
(9,'Home',NULL,NULL,NULL,0,0),
(10,'Home','fa fa-home','home/index',15,0,1),
(11,'Approve Product','fa fa-sliders-h','product/approve',15,0,1);

/*Table structure for table `sys_privilege` */

DROP TABLE IF EXISTS `sys_privilege`;

CREATE TABLE `sys_privilege` (
  `uid` int(11) NOT NULL,
  `nav` int(11) NOT NULL,
  `permit` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `sys_privilege` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
