-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 سبتمبر 2020 الساعة 00:37
-- إصدار الخادم: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `syriashop`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `categorie_id` int(11) NOT NULL,
  `categorie_name` varchar(60) NOT NULL,
  `categorie_parent` varchar(255) NOT NULL DEFAULT 'main',
  `categorie_icon` varchar(255) NOT NULL,
  `alarms` text COMMENT 'الاشخاص الذين يريدن ارسال اشعارات'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_name`, `categorie_parent`, `categorie_icon`, `alarms`) VALUES
(28, 'سيارات', 'main', '5e3ba5c777160.png', ''),
(29, 'Nokia', '30', '5e3bac7bb5836.png', ''),
(30, 'موبايلات', 'main', '5e3bac167ef47.png', ''),
(31, 'kiaa', '28', '5e5034cbc14ea.jpg', ''),
(32, 'AUDI', '28', '5e5036782c913.jpg', ''),
(46, 'بصريات', 'main', '5e7e0346614d9.png', ''),
(47, 'العدسات اللاصقة', '46', '', ''),
(48, 'نظارات', '46', '', ''),
(49, 'اكسسوارات النظارات', '46', '', ''),
(50, 'اطارات النظارات', '46', '', ''),
(51, 'كمبيوتر والشبكات', 'main', '5e7e48db3799c.png', ''),
(52, 'اكسسوارات الكمبيوتر واللابتوب', '51', '', ''),
(53, 'حقائب لابتوب', '52', '', ''),
(54, 'الطفل', 'main', '5e9087965ae26.png', NULL),
(55, 'الكتب', 'main', '5e9087aa201ef.png', NULL),
(56, 'الأثاث', 'main', '5e9087bd4cc20.png', NULL),
(57, 'كتب الأطفال', '55', '', NULL),
(58, 'الأدب والخيال', '55', '', NULL),
(59, 'عربات الأطفال', '54', '', NULL),
(60, 'ملابس الأطفال', '54', '', NULL),
(61, 'أثاث المكاتب', '56', '', NULL),
(62, 'Samsung', '30', '', NULL),
(63, 'إيجار', 'main', '5ef9fc03e15a6.png', NULL),
(64, 'إيجار منازل', '63', '', NULL),
(65, 'Sony', '30', '', NULL),
(66, 'Huawei', '30', '', NULL),
(67, 'IPHONE', '30', '', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `categorie_alarms`
--

CREATE TABLE `categorie_alarms` (
  `alarm_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_description` text NOT NULL,
  `item_price` int(11) DEFAULT NULL,
  `item_add_date` varchar(100) NOT NULL,
  `item_end_date` varchar(100) NOT NULL,
  `item_media` text,
  `tags` varchar(255) NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `phoneuser` varchar(100) NOT NULL,
  `whatsapp` varchar(100) NOT NULL,
  `item_location` varchar(50) NOT NULL,
  `item_country` varchar(255) NOT NULL,
  `discount` tinyint(2) NOT NULL,
  `views` int(5) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `location_city`
--

CREATE TABLE `location_city` (
  `location_city_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `location_city`
--

INSERT INTO `location_city` (`location_city_id`, `location_name`, `location_country_id`) VALUES
(5, 'حماة', 10),
(6, 'حمص', 10),
(7, 'دمشق', 10),
(8, 'دبي', 15),
(11, 'الشارقة', 15),
(13, 'حلب', 10),
(14, 'الرقة', 10),
(20, 'ابو ظبي', 15),
(21, 'بيروت', 18),
(22, 'طرابلس', 18),
(23, 'صيدا', 18),
(24, 'بغداد', 17),
(25, 'القامشلي', 10);

-- --------------------------------------------------------

--
-- بنية الجدول `location_country`
--

CREATE TABLE `location_country` (
  `location_country_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_number` varchar(20) NOT NULL,
  `location_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `location_country`
--

INSERT INTO `location_country` (`location_country_id`, `location_name`, `location_number`, `location_icon`) VALUES
(10, 'سوريا', '+963', '5e1b213251c00.png'),
(15, 'الامارات', '+971', '5e14d94b3f968.png'),
(17, 'العراق', '+964', '5e6aade97cbaa.png'),
(18, 'لبنان', '+961', '5e6aae0e68613.png'),
(19, 'الأردن', '+962', '5edf96185dab8.png');

-- --------------------------------------------------------

--
-- بنية الجدول `reports`
--

CREATE TABLE `reports` (
  `report_id` tinyint(50) NOT NULL,
  `report_text` varchar(255) NOT NULL,
  `report_to` int(11) NOT NULL,
  `report_to_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `my_img` varchar(100) NOT NULL DEFAULT 'user.png',
  `favorite` varchar(535) NOT NULL COMMENT 'الاعلانات المحفوظة',
  `type_user` varchar(8) NOT NULL DEFAULT 'guest',
  `block` tinyint(2) NOT NULL DEFAULT '0',
  `date_of_registration` date NOT NULL,
  `user_type` varchar(25) NOT NULL DEFAULT 'email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `key_hash`, `username`, `email`, `password`, `my_img`, `favorite`, `type_user`, `block`, `date_of_registration`, `user_type`) VALUES
(1, 'users5d57e0e1215009.18057325', 'قصي الشرتح', 'aser.syria2019@gmail.com', '$2y$10$0dFFVQLpcw6RRV4KpGi5ved3lXdjyf17fcwBA2Mog4BW6LrDt2ty2', '1.jpg', '67,6', 'admin', 0, '2020-07-30', 'email'),
(9, 'users5e908c7094ac60.08625038', 'عبد السلام داحول', 'clash.clans1567@gmail.com', '$2y$10$srXNCYiFWPJNo3Z1NF.rV.aZgwyatOhqbHhAf.akfKzjXrx8/RbSG', 'user.png', '', 'admin', 0, '2020-07-30', 'email'),
(18, 'users5f5aeaad400385.20543402', 'asdsd', 'aser.syria2018@gmail.com', '$2y$10$lLyZE1r9OpY.qefzkqsQMODdv9jEpFXaXIQlIWrTckQ0ulYWl7mKK', 'user.png', '', 'guest', 1, '2020-09-11', 'email');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categorie_id`),
  ADD UNIQUE KEY `categorie_name` (`categorie_name`);

--
-- Indexes for table `categorie_alarms`
--
ALTER TABLE `categorie_alarms`
  ADD PRIMARY KEY (`alarm_id`),
  ADD KEY `alarms_cat` (`categorie_id`),
  ADD KEY `alarms_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `location_city`
--
ALTER TABLE `location_city`
  ADD PRIMARY KEY (`location_city_id`),
  ADD KEY `location_country_id` (`location_country_id`);

--
-- Indexes for table `location_country`
--
ALTER TABLE `location_country`
  ADD PRIMARY KEY (`location_country_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `report_to_items` (`report_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_hash` (`key_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `categorie_alarms`
--
ALTER TABLE `categorie_alarms`
  MODIFY `alarm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_city`
--
ALTER TABLE `location_city`
  MODIFY `location_city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `location_country`
--
ALTER TABLE `location_country`
  MODIFY `location_country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` tinyint(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `categorie_alarms`
--
ALTER TABLE `categorie_alarms`
  ADD CONSTRAINT `alarms_cat` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alarms_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `location_city`
--
ALTER TABLE `location_city`
  ADD CONSTRAINT `location_city_ibfk_1` FOREIGN KEY (`location_country_id`) REFERENCES `location_country` (`location_country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `report_to_items` FOREIGN KEY (`report_to`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
