-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2022 at 02:27 AM
-- Server version: 10.3.31-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamrabb_hisabbondhu`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `contact_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_line_one` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_date` varchar(255) DEFAULT NULL,
  `created_time` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `updated_date` varchar(255) DEFAULT NULL,
  `updated_time` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `user_mobile`, `contact_type`, `name`, `mobile_no`, `email`, `address_line_one`, `city`, `country`, `created_date`, `created_time`, `created_by`, `updated_date`, `updated_time`, `updated_by`) VALUES
(32, '01785388919', 'Customer', 'Ariful vaiya ( Hisab Bondhu)', '01760580552', 'hisabbondhu@gmail.com', 'qwerty', 'Rajshahi', 'Bangladesh', '02-10-2021', '12:14:25am', 'Rabbil Hasan', '02-10-2021', '10:46:58am', 'Rabbil Hasan'),
(125, '01308804657', 'Customer', 'Anisul Haque', '01308804657', 'anisul@gmail.com', 'Badda', 'Dhaka', 'Bangladesh', '20-11-2021', '09:58:35pm', 'রহিম মিয়া', '12-01-2022', '09:41:16pm', 'Jerry Bean'),
(126, '01308804657', 'Supplier', 'Rezaul Karim', '01760580552', 'rezaul@gmail.com', 'Talaimari', 'Rajshahi', 'Afghanistan', '20-11-2021', '09:59:05pm', 'রহিম মিয়া', NULL, NULL, NULL),
(127, '01308804657', 'Customer', 'Atikuq islam', '01983743951', 'atikul@gmail.com', 'Zero point', 'Rangpur', 'Bangladesh', '20-11-2021', '09:59:41pm', 'রহিম মিয়া', NULL, NULL, NULL),
(128, '01681319233', 'Customer', 'mamun', '01777850938', 'mamun@gmail.com', 'rajshahi', 'rajshahi', 'Bangladesh', '20-11-2021', '10:27:15pm', 'muhaimin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_number`, `date`, `amount`, `comment`, `created_at`, `updated_at`) VALUES
(25, '01308804657', '2021-11-20', 25000, 'Rent', '2021-11-20 11:01:07', '2021-11-20 11:01:07'),
(26, '01308804657', '2021-11-19', 1200, 'Electricity Bill', '2021-11-20 11:01:27', '2021-11-20 11:01:27');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_partner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_partner_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_charge` double DEFAULT NULL,
  `delivery_charge` double DEFAULT NULL,
  `total_payable` double NOT NULL,
  `vat` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_id`, `user_number`, `contact_id`, `contact_name`, `contact_address`, `contact_number`, `delivery_status`, `invoice_date`, `invoice_desc`, `delivery_partner_name`, `delivery_partner_code`, `service_charge`, `delivery_charge`, `total_payable`, `vat`, `created_at`, `updated_at`) VALUES
(12, '01308804657', '01681319233', '30', 'Delivery Partner', 'American Samoa', '01308804657', 'Picked For Delivery', '18,Oct 2021', 'inv descreption', ' Partner', '30', 0, 0, 180, 0, '2021-10-30 10:03:59', '2021-10-30 10:03:59'),
(28, 'INV15FF9', '01681319234', '30', 'Delivery Partner', 'rajshahi University,Rajshahi,American Samoa', '01308804657', 'Delivered', '30,Oct 2021', 'short desc', 'null', 'null', 0, 0, 85, 0, '2021-10-30 14:41:42', '2021-10-30 14:41:42'),
(29, 'INV15FF9', '01681319235', '30', 'Delivery Partner', 'rajshahi University,Rajshahi,American Samoa', '01308804658', 'New order', '30,Oct 2021', 'short desc', 'null', 'null', 0, 0, 85, 0, '2021-10-30 14:41:42', '2021-10-30 14:41:42'),
(30, 'INV15FF9', '01308804656', '30', 'Delivery Partner', 'rajshahi University,Rajshahi,American Samoa', '01308804657', 'Goods ready', '30,Oct 2021', 'short desc', 'null', 'null', 0, 0, 85, 0, '2021-10-30 14:41:42', '2021-10-30 14:41:42'),
(44, 'INV3Q1B1', '01308804657', '129', 'Ariful Islam', '9 K.M Das Lane, Tikatuly,Dhaka,Bangladesh', '01711058949', 'Goods Ready', '20,Nov 2021', 'Priority customer', 'Atikuq islam', '127', 5, 100, 71644, 15, '2021-11-20 11:04:11', '2021-11-20 11:04:11'),
(45, 'INVHH2BD', '01308804657', '125', 'Anisul Haque', 'Badda,Dhaka,Bangladesh', '01308804657', 'Picked For Deliery', '11,Jan 2022', 'inv descruption', 'null', 'null', 5, 10, 60, 5, '2022-01-11 10:01:50', '2022-01-11 10:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentAmount` double NOT NULL,
  `paymentDesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_payments`
--

INSERT INTO `invoice_payments` (`id`, `invoice_id`, `paymentDate`, `paymentAmount`, `paymentDesc`, `created_at`, `updated_at`) VALUES
(14, '123456', '20,Oct 2021', 50, 'desc 1', '2021-10-30 10:03:59', '2021-10-30 10:03:59'),
(15, '123456', '20,Oct 2021', 50, 'desc 2', '2021-10-30 10:03:59', '2021-10-30 10:03:59'),
(33, 'INV15FF9', '30,Oct 2021', 50, 'fifg', '2021-10-30 14:41:42', '2021-10-30 14:41:42'),
(46, 'INVHH2BD', '20,Nov 2021', 20, 'drsct', '2022-01-11 10:01:50', '2022-01-11 10:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productQuantity` double NOT NULL,
  `sellPrice` double NOT NULL,
  `totalSellprice` double NOT NULL,
  `discount` double DEFAULT NULL,
  `buyPrice` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discountType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discountPercent` double DEFAULT NULL,
  `discountFlat` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_products`
--

INSERT INTO `invoice_products` (`id`, `invoice_id`, `productCode`, `productName`, `productQuantity`, `sellPrice`, `totalSellprice`, `discount`, `buyPrice`, `description`, `discountType`, `discountPercent`, `discountFlat`, `created_at`, `updated_at`) VALUES
(17, '123456', '26', 'Inn stock', 1, 100, 85, 15, 50, 'Flat', 'Percent', 15, 0, '2021-10-30 10:03:59', '2021-10-30 10:03:59'),
(18, '123456', '27', 'out of stock', 1, 100, 95, 5, 50, 'percent check product', 'Percent', 5, 0, '2021-10-30 10:03:59', '2021-10-30 10:03:59'),
(42, 'INV15FF9', '26', 'Inn stock', 1, 100, 85, 15, 50, 'Flat', 'Percent', 15, 0, '2021-10-30 14:41:42', '2021-10-30 14:41:42'),
(59, 'INV3Q1B1', '33', 'Samsung TV', 1, 60000, 57000, 3000, 49000, '14 inch samsung tv', 'Percent', 5, 0, '2021-11-20 11:04:11', '2021-11-20 11:04:11'),
(60, 'INV3Q1B1', '34', 'Vagetable pil', 50, 50, 2250, 250, 25, 'nice vagetabpe oil', 'Flat', 0, 5, '2021-11-20 11:04:11', '2021-11-20 11:04:11'),
(61, 'INVHH2BD', '34', 'Vagetable pil', 1, 50, 45, 5, 25, 'nice vagetabpe oil', 'Flat', 0, 5, '2022-01-11 10:01:50', '2022-01-11 10:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `otp_table`
--

CREATE TABLE `otp_table` (
  `id` int(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_timestamp` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `created_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `otp_table`
--

INSERT INTO `otp_table` (`id`, `mobile`, `otp`, `created_timestamp`, `created_date`, `created_time`) VALUES
(25, '01777850938', '4639', '1637426985', '20-11-2021', '10:49:45pm'),
(26, '01777850938', '4802', '1637427146', '20-11-2021', '10:52:26pm'),
(27, '01681319233', '7051', '1637427183', '20-11-2021', '10:53:03pm'),
(28, '01681319233', '5294', '1637427214', '20-11-2021', '10:53:34pm'),
(29, '01681319233', '7162', '1637427243', '20-11-2021', '10:54:03pm'),
(30, '01760580552', '4361', '1641187752', '03-01-2022', '11:29:12am'),
(31, '01760580552', '6452', '1641187754', '03-01-2022', '11:29:14am'),
(32, '01760580552', '4740', '1641188209', '03-01-2022', '11:36:49am'),
(33, '01760580552', '2437', '1641188212', '03-01-2022', '11:36:52am'),
(34, '01760580552', '2631', '1641188331', '03-01-2022', '11:38:51am'),
(35, '01760580552', '7355', '1641188456', '03-01-2022', '11:40:56am'),
(36, '01760580552', '5060', '1641188461', '03-01-2022', '11:41:01am'),
(37, '01760580552', '6557', '1641188841', '03-01-2022', '11:47:21am'),
(38, '01760580552', '6832', '1641190306', '03-01-2022', '12:11:46pm'),
(39, '687618761877', '7261', '1641215916', '03-01-2022', '07:18:36pm'),
(40, '687618761877', '6597', '1641215918', '03-01-2022', '07:18:38pm');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `p_code` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_unit` varchar(255) NOT NULL,
  `p_type` varchar(255) DEFAULT NULL,
  `p_desc` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) NOT NULL,
  `purchase_price` varchar(255) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_percentage` varchar(255) DEFAULT NULL,
  `discount_flat` varchar(255) DEFAULT NULL,
  `discount_price` varchar(255) DEFAULT NULL,
  `profit` varchar(255) DEFAULT NULL,
  `stock` varchar(255) NOT NULL,
  `created_date` varchar(255) DEFAULT NULL,
  `created_time` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_date` varchar(255) DEFAULT NULL,
  `updated_time` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_mobile`, `p_code`, `p_name`, `p_unit`, `p_type`, `p_desc`, `sell_price`, `purchase_price`, `discount_type`, `discount_percentage`, `discount_flat`, `discount_price`, `profit`, `stock`, `created_date`, `created_time`, `created_by`, `updated_date`, `updated_time`, `updated_by`) VALUES
(15, '01760580552', 'P260615', 'Sobuj Test', 'Meter', 'Material', 'This is a test product', '500', '600', 'Percent', '10', '0', '450', '-150', 'YES', '27-08-2021', '10:48:26pm', 'jerrybean', '18-09-2021', '10:46:51am', 'jerrybean'),
(17, '01760580552', 'P922992', 'flat product', 'Pcs', 'Plastic', 'flat test', '1000', '800', 'Flat', '0', '100', '900', '100', 'NO', '27-08-2021', '11:21:02pm', 'jerrybean', '27-08-2021', '11:35:11pm', 'jerrybean'),
(21, '01760580552', 'P864111', 'test product', 'Km', 'Material', 'test', '500', '300', 'Percent', '15', '0', '425', '125', 'YES', '26-09-2021', '03:56:28pm', 'jerrybean', NULL, NULL, NULL),
(28, '01785388919', 'P343157', 'Test Product', 'unit Wood', 'Wood', 'product Desc', '1000', '500', 'Percent', '5', '0', '950', '450', 'NO', '02-10-2021', '12:26:53am', 'Rabbil Hasan', NULL, NULL, NULL),
(33, '01308804657', 'P236304', 'Samsung TV', 'unit 2', 'Plastic', '14 inch samsung tv', '1200', '1000', 'Percent', '2', '0', '1176', '176', 'NO', '20-11-2021', '10:00:17pm', 'রহিম মিয়া', '20-11-2021', '11:03:12pm', 'Jerry Bean'),
(34, '01308804657', 'P837940', 'Vagetable pil', 'unit Wood', 'Wood', 'nice vagetabpe oil', '50', '25', 'Flat', '0', '5', '45', '20', 'YES', '20-11-2021', '10:00:40pm', 'রহিম মিয়া', '11-01-2022', '10:01:23pm', 'Jerry Bean'),
(35, '01308804657', 'P471278', 'Baby Cloth', 'unit 1', 'Plastic', 'Jama', '600', '400', 'Percent', '10', '0', '540', '140', 'YES', '24-11-2021', '11:02:17am', 'Jerry Bean', '24-11-2021', '11:07:06am', 'Jerry Bean');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_unit`
--

CREATE TABLE `product_type_unit` (
  `id` int(255) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_type_unit`
--

INSERT INTO `product_type_unit` (`id`, `type`, `unit`) VALUES
(1, 'Plastic', 'unit 1'),
(2, 'Plastic', 'unit 2'),
(3, 'Wood', 'unit Wood'),
(4, 'Wood', 'unit Wood');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_purchase` double NOT NULL,
  `purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_pay` double NOT NULL,
  `pay_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due` double NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_number`, `total_purchase`, `purchase_date`, `total_pay`, `pay_date`, `due`, `comment`, `supplier_id`, `created_at`, `updated_at`) VALUES
(3, '01308804657', 432, '2020-11-11', 4324, '11-11-2020', -3892, 'comment', '40', '2021-11-12 03:09:48', '2021-11-17 07:23:37'),
(4, '435', 400, '2020-11-11', 4324, '11-11-2020', 35, 'comment', '123', '2021-11-14 11:44:41', '2021-11-14 11:44:41'),
(5, '435', 400, '2020-11-11', 4324, '11-11-2020', 35, 'comment', '123', '2021-11-15 12:53:36', '2021-11-15 12:53:36'),
(6, '500', 400, '2020-11-11', 4324, '11-11-2020', 30, 'comment', '123', '2021-11-15 13:04:56', '2021-11-15 13:04:56'),
(7, '500', 400, '2020-11-11', 4324, '11-11-2020', 0, 'comment', '123', '2021-11-15 13:29:27', '2021-11-15 13:29:27'),
(11, '500', 1000, '2020-11-11', 1000, '2020-11-11', 0, 'comment', '123', '2021-11-17 08:27:28', '2021-11-17 08:30:19'),
(12, '500', 10000, '1970-01-01', 10000, '1970-01-01', 0, 'comment', '123', '2021-11-17 08:38:22', '2021-11-17 08:38:22'),
(13, '01308804657', 100, '2021-01-11', 50, '1970-01-01', 50, 'date check', '36', '2021-11-17 08:42:54', '2021-11-17 08:42:54'),
(14, '01308804657', 100, '2021-01-11', 50, '1970-01-01', 50, 'gccycc', '36', '2021-11-17 08:45:47', '2021-11-17 08:47:00'),
(15, '500', 10000, '1970-01-01', 10000, '1970-01-01', 0, 'comment', '123', '2021-11-17 08:59:03', '2021-11-17 08:59:03'),
(16, '500', 10000, '2020-12-25', 10000, '2020-12-28', 0, 'comment', '123', '2021-11-17 09:00:34', '2021-11-17 09:00:34'),
(17, '01308804657', 50, '2021-11-01', 5, '2021-11-15', 45, 'hvhv', '36', '2021-11-17 09:04:22', '2021-11-17 09:04:22'),
(18, '01308804657', 1000, '2021-11-15', 1000, '2021-11-21', 0, 'pyrchase desc', '126', '2021-11-20 10:18:40', '2021-11-20 10:19:49'),
(20, '01308804657', 20000, '2021-11-20', 10000, '2021-11-20', 10000, NULL, '126', '2021-11-20 10:57:59', '2021-11-20 10:57:59'),
(21, '01308804657', 15000, '2021-11-20', 1000, '2021-11-20', 14000, NULL, '126', '2021-11-20 10:59:43', '2021-11-20 10:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ssl_wireless_sms_api_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssl_wireless_sms_sid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssl_wireless_sms_domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `ssl_wireless_sms_api_token`, `ssl_wireless_sms_sid`, `ssl_wireless_sms_domain`) VALUES
(1, 'bc62a8ce-2379-4972-a983-e22cf48c5eea', 'STEPUPNON', 'https://smsplus.sslwireless.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `id` int(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `created_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`id`, `mobile`, `user_full_name`, `business_name`, `password`, `created_date`, `created_time`) VALUES
(1, '01308804657', 'Jerry Bean', 'Technology biri', '123456', '30-09-2021', '08:54:29pm'),
(2, '01785388919', 'Rabbil Hasan', 'Rabbil Coaching Centre', 'change_2', '02-10-2021', '12:08:30am'),
(5, '01760580552', 'jeery', 'shop', '123456', '03-01-2022', '12:12:19pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_table`
--
ALTER TABLE `otp_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type_unit`
--
ALTER TABLE `product_type_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `otp_table`
--
ALTER TABLE `otp_table`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_type_unit`
--
ALTER TABLE `product_type_unit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
