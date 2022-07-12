-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: mysql1004.mochahost.com:3306
-- Generation Time: Jul 09, 2022 at 08:50 AM
-- Server version: 10.3.31-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tohid75_grap_db`
--
CREATE DATABASE IF NOT EXISTS `grap_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `grap_db`;

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `b_first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_phone` int(11) DEFAULT NULL,
  `b_country` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_timestamp` int(11) NOT NULL,
  `b_latimestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`id`, `b_first_name`, `b_last_name`, `b_email`, `b_password`, `b_phone`, `b_country`, `b_timestamp`, `b_latimestamp`) VALUES
(1, 'Ashraful', 'Islam', 'ashraf.fahim75@gmail.com', '21232f297a57a5a743894a0e4a801fc3', NULL, 'AE', 1652729647, 1652729647);

-- --------------------------------------------------------

--
-- Table structure for table `draft_edited_product`
--

CREATE TABLE `draft_edited_product` (
  `id` int(11) NOT NULL,
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
  `dp_latimestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `draft_new_product`
--

CREATE TABLE `draft_new_product` (
  `id` int(11) NOT NULL,
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
  `dp_latimestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `draft_new_product`
--

INSERT INTO `draft_new_product` (`id`, `dp_name`, `dp_category`, `dp_price`, `dp_description`, `dp_brand`, `dp_model`, `dp_category_spec`, `dp_custom_field`, `dp_badge`, `dp_variation`, `dp_status`, `dp_o_status`, `dp_sellerstamp`, `dp_operatorstamp`, `dp_timestamp`, `dp_latimestamp`) VALUES
(3, 'Test 2', 'Test 2', 123.00, 'Test 2', 'Test', 'Test', NULL, '{\"1\": \"2\"}', NULL, NULL, 1, 0, 5, 1, 1652358513, 1652358513);

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id` int(11) NOT NULL,
  `o_first_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_last_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_username` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `o_password` text CHARACTER SET utf8mb4 NOT NULL,
  `o_email` varbinary(50) DEFAULT NULL,
  `o_position` int(11) NOT NULL DEFAULT 0,
  `o_permit` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id`, `o_first_name`, `o_last_name`, `o_username`, `o_password`, `o_email`, `o_position`, `o_permit`) VALUES
(1, 'A', 'I', 'root', '21232f297a57a5a743894a0e4a801fc3', 'ashraf.fahim75@gmail.com', 0, 1),
(2, 'Ashraful', 'Islam', 'jk', '5ad9bc9f6a29e906964dcb09e730364f', 'ashraf@yopmail.com', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
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
  `o_latimestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `o_currency`, `o_buyer`, `o_discount`, `o_service_charge`, `o_ship_cost`, `o_ship_address_1`, `o_ship_address_2`, `o_ship_country`, `o_ship_city`, `o_ship_po_box`, `o_ship_mobile`, `o_ship_email`, `o_status`, `o_timestamp`, `o_latimestamp`) VALUES
(1, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1653330882, 1656762306),
(2, 'AED', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1656342622, 1656342622),
(3, 'BDT', 1, 0.00, 36.90, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1656344058, 1656344058),
(4, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1656344228, 1656762779),
(5, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657052013, 1657052013),
(6, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657052357, 1657052357),
(7, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657054296, 1657054296),
(8, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657055926, 1657055926),
(9, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657056143, 1657056143),
(10, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657139607, 1657139607),
(11, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657139853, 1657139853),
(12, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657140186, 1657140186),
(13, 'BDT', 1, 0.00, 6.15, 0.00, '308, Al Saud Building - A Block, Street: 6 - Al Mu', '', 'AE', 'Sharjah', '63891', 525187677, 'ashraf.fahim75@gmail.com', 0, 1657140769, 1657140769);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `oi_invoice` int(11) NOT NULL,
  `oi_product` int(11) NOT NULL,
  `oi_qty` int(11) NOT NULL,
  `oi_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`oi_invoice`, `oi_product`, `oi_qty`, `oi_price`) VALUES
(2, 3, 1, 123.00),
(3, 2, 3, 123.00),
(3, 4, 3, 123.00),
(1, 2, 1, 123.00),
(4, 2, 1, 123.00),
(5, 2, 1, 123.00),
(6, 2, 1, 123.00),
(7, 2, 1, 123.00),
(8, 2, 1, 123.00),
(9, 2, 1, 123.00),
(10, 2, 1, 123.00),
(11, 2, 1, 123.00),
(12, 2, 1, 123.00),
(13, 2, 1, 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `p_order` int(11) NOT NULL,
  `p_method` int(11) NOT NULL,
  `p_secret` varchar(100) DEFAULT NULL,
  `p_status` tinyint(1) DEFAULT NULL,
  `p_timestamp` int(11) NOT NULL,
  `p_latimestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `p_order`, `p_method`, `p_secret`, `p_status`, `p_timestamp`, `p_latimestamp`) VALUES
(1, 1, 1, 'pi_3LFJDAIoGl18YWC81ib1JjBS_secret_ym32CkDItLiqupJao1q0yoKgE', 0, 1656341771, 1656341771),
(2, 2, 1, 'pi_3LFJa0IoGl18YWC81ExOeb55_secret_LUXX21vRmQ6WfDC1P5ooIa2s2', 0, 1656342640, 1656342640),
(3, 3, 1, 'pi_3LFJxBIoGl18YWC81FB4qCAG_secret_spgTWqALwcENXS8RIIgqzp7S5', 0, 1656344218, 1656344218),
(4, 4, 1, 'pi_3LH4skIoGl18YWC80SRRvvcU_secret_U2XtglYtz9mcyGFPOZzcq2mfP', 0, 1656762792, 1656762792),
(5, 5, 1, 'pi_3LII7oIoGl18YWC8223CAb12_secret_ZlqYat5FTDe3geLNxgiIBtPXu', 0, 1657052028, 1657052028),
(6, 6, 1, 'pi_3LIIDNIoGl18YWC82kC9PRFa_secret_xCP1Bzlmytrr7DvkERGjIS37l', 0, 1657052373, 1657052373),
(7, 7, 1, 'pi_3LIIicIoGl18YWC80Qdal6Np_secret_3x81fyVj4bwo3NJ0DRCMrZDQV', 0, 1657054311, 1657054311),
(8, 8, 1, 'pi_3LIJ8vIoGl18YWC82urNqGS4_secret_3nZuSQyeoIjYjH8juCFIj5Cr1', 0, 1657055944, 1657055944),
(9, 9, 1, 'pi_3LIJCQIoGl18YWC829MTMMts_secret_ZaAvB0jEEmw5F3vHm80FazmDL', 0, 1657056157, 1657056157),
(10, 10, 1, 'pi_3LIeuhIoGl18YWC81WoEsPja_secret_v75f8VQ2DnaQbHnQEHyU44JFO', 0, 1657139629, 1657139629),
(11, 11, 1, 'pi_3LIeyZIoGl18YWC80Z4ap0d9_secret_waJAd2k4Xk8zCl7DCBPDrqlbu', 1, 1657139873, 1657139873),
(12, 12, 1, 'pi_3LIf3wIoGl18YWC80QRxnZFM_secret_y02Yr1eWMiN086a3Mmy7c4nL8', 0, 1657140200, 1657140200),
(13, 13, 1, 'pi_3LIfDLIoGl18YWC82fKDRilO_secret_gVBtPU3ki9EVgliThGmxXOExQ', 1, 1657140783, 1657140783);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
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
  `p_latimestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `p_name`, `p_category`, `p_price`, `p_description`, `p_brand`, `p_model`, `p_category_spec`, `p_custom_field`, `p_badge`, `p_variation`, `p_status`, `p_o_status`, `p_sellerstamp`, `p_operatorstamp`, `p_timestamp`, `p_latimestamp`) VALUES
(1, 'Test1', 'Test cat', 123.00, 'Test summary', 'brand', 'model', NULL, '{\"ok\": \"ko\", \"Test\": \"200\"}', NULL, NULL, 1, 0, 5, 1, 1652451061, 1652451061),
(2, 'Test1', 'Test cat', 123.00, 'Test summary\r\nLine break', 'brand', 'model', NULL, '{\"ko\": \"Lorem ipsum delorem\", \"ok\": \"ko\", \"Test\": \"200\", \"Lorem ipsum delorem\": \"ok\"}', NULL, NULL, 1, 0, 4, 1, 1652451858, 1652451858),
(3, 'Test1', 'Test cat', 123.00, 'Test summary', 'brand', 'model', NULL, '{\"ok\": \"ko\", \"Test\": \"200\"}', NULL, NULL, 1, 0, 5, 1, 1652452125, 1652452125),
(4, 'Test1', 'Test cat', 123.00, 'Test summary', 'brand', 'model', NULL, '{\"ok\": \"ko\"}', NULL, NULL, 1, 0, 4, 1, 1652452248, 1652452248);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `s_first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_phone` int(11) DEFAULT NULL,
  `s_country` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_currency` char(3) DEFAULT NULL,
  `s_timestamp` int(11) NOT NULL,
  `s_latimestamp` int(11) DEFAULT NULL,
  `s_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `s_first_name`, `s_last_name`, `s_email`, `s_password`, `s_phone`, `s_country`, `s_currency`, `s_timestamp`, `s_latimestamp`, `s_status`) VALUES
(1, 'Ashraful', 'Islam', 'ashraf.fahim75@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 525187677, 'AE', 'AED', 1651944790, 1651944790, 1),
(2, 'Ashraful', 'Islam', 'ashraf@yopmail.com', '61475c493c89bdcf90488f8f6e63381c', NULL, 'AE', 'AED', 1652180775, 1652180775, 1),
(3, 'Test', '1', 'test1@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'AE', 'AED', 1652181080, 1652181080, 1),
(4, 'Test', '2', 'test2@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'AE', 'BDT', 1652181170, 1652181170, 1),
(5, 'Test', '3', 'test3@yopmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'AE', 'AED', 1652181296, 1652181296, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_charge`
--

CREATE TABLE `sys_charge` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `amount` decimal(10,5) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sys_charge`
--

INSERT INTO `sys_charge` (`id`, `name`, `amount`, `type`) VALUES
(1, 'service', 0.05000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_country`
--

CREATE TABLE `sys_country` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` char(2) NOT NULL,
  `currency` char(3) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `phone` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sys_country`
--

INSERT INTO `sys_country` (`id`, `name`, `code`, `currency`, `currency_symbol`, `phone`) VALUES
(1, 'Bangladesh', 'BD', 'BDT', '৳', 880),
(2, 'United Arab Emirates', 'AE', 'AED', 'إ.د', 971);

-- --------------------------------------------------------

--
-- Table structure for table `sys_nav`
--

CREATE TABLE `sys_nav` (
  `id` int(11) NOT NULL,
  `title` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `icon` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `query_string` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `root` int(11) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL,
  `is` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sys_nav`
--

INSERT INTO `sys_nav` (`id`, `title`, `icon`, `query_string`, `root`, `position`, `is`) VALUES
(1, 'System', NULL, NULL, NULL, NULL, 0),
(2, 'Configuration', 'fa fa-sliders-h', '', 1, 0, 0),
(3, 'Index', '', 'configuration/index', 2, 0, 0),
(4, 'Operator', 'far fa-user', '', 1, 0, 10),
(5, 'Manage', '', 'user/add', 8, 0, 1),
(6, 'Users', '', 'user/approve', 8, 0, 10),
(7, 'Privilege', '', 'user/privilege', 8, 0, 10),
(8, 'Profile', '', 'user/profile', 8, 0, 10),
(9, 'Home', NULL, NULL, NULL, 0, 0),
(10, 'Home', 'fa fa-home', 'home/index', 9, 0, 1),
(11, 'Approve Product', 'fa fa-sliders-h', 'product/index', 9, 0, 1),
(12, 'Accounts', NULL, NULL, NULL, NULL, 0),
(13, 'Transactions', 'fa fa-money-bill', '', 12, 0, 0),
(14, 'Index', '', 'transaction/index', 13, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_payment_method`
--

CREATE TABLE `sys_payment_method` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `key` varchar(100) DEFAULT NULL,
  `secret` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sys_payment_method`
--

INSERT INTO `sys_payment_method` (`id`, `name`, `code`, `key`, `secret`) VALUES
(1, 'Credit Card', 'stripe', NULL, NULL),
(2, 'Debit Card', 'stripe', NULL, NULL),
(3, 'bKash', 'bkash', NULL, NULL),
(4, 'Bank', 'stripe', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_privilege`
--

CREATE TABLE `sys_privilege` (
  `uid` int(11) NOT NULL,
  `nav` int(11) NOT NULL,
  `permit` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `draft_edited_product`
--
ALTER TABLE `draft_edited_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Product Seller` (`dp_sellerstamp`);

--
-- Indexes for table `draft_new_product`
--
ALTER TABLE `draft_new_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Product Seller` (`dp_sellerstamp`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Product Seller` (`p_sellerstamp`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_charge`
--
ALTER TABLE `sys_charge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_country`
--
ALTER TABLE `sys_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_nav`
--
ALTER TABLE `sys_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_payment_method`
--
ALTER TABLE `sys_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `draft_new_product`
--
ALTER TABLE `draft_new_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sys_charge`
--
ALTER TABLE `sys_charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_country`
--
ALTER TABLE `sys_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sys_nav`
--
ALTER TABLE `sys_nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sys_payment_method`
--
ALTER TABLE `sys_payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
