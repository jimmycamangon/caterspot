-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 07:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcaterspot`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin_taxcollected_stats`
--

CREATE TABLE `tbladmin_taxcollected_stats` (
  `id` int(11) NOT NULL,
  `transactionNo` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `collectedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblclient_faqs`
--

CREATE TABLE `tblclient_faqs` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `faq_id` int(11) DEFAULT NULL,
  `cater_question` text DEFAULT NULL,
  `cater_answer` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblclient_faqs`
--

INSERT INTO `tblclient_faqs` (`id`, `client_id`, `faq_id`, `cater_question`, `cater_answer`, `createdAt`) VALUES
(10, 98429, 88679, '<p>What are your payment and cancellation policies?</p>', '<p style=\"text-align: left;\"><strong>Gcash</strong> (Screenshot of Receipt) and <strong>Walk-in</strong> (Invoice)</p>\n<p style=\"text-align: left;\"><em><strong>Cancellations</strong> are accepted within 2 days of the initial request; afterward, no cancellations are processed, and it takes 2-3 business days for cancellation updates.</em></p>', '2024-04-20 00:00:04'),
(11, 98429, 94179, '<p>How far in advance should I book catering for my event?</p>', '<p><em>It\'s best to book catering services as early as possible to ensure availability, especially for large events.The system requires 1 month advance booking, but ideally 2-3 months is recommended.</em></p>', '2024-04-20 00:07:59'),
(12, 98429, 63661, '<p>Can you accommodate last-minute changes or additions to the guest count?</p>', '<p>We understand that guest counts may change leading up to the event. While it\'s best to provide final guest numbers in advance, we will do our best to accommodate last-minute changes whenever possible.</p>', '2024-04-20 05:34:58'),
(13, 93970, 93683, '<p><strong>What is included in your catering packages?</strong></p>', '<p>Our catering packages typically include food, beverages, servingware, and sometimes additional services such as setup, cleanup, and equipment rental. We can tailor the package to suit your specific needs and budget.</p>', '2024-04-20 05:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `tblclient_gallery`
--

CREATE TABLE `tblclient_gallery` (
  `id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `uniq_id` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblclient_gallery`
--

INSERT INTO `tblclient_gallery` (`id`, `client_id`, `uniq_id`, `service`, `file_name`, `createdAt`) VALUES
(39, '98429', '43967', 'Birthday', '403613269_766520952155596_5134753667462140195_n.jpg', '2024-04-21 01:19:29'),
(40, '98429', '38234', 'Birthday', '419680446_800019542139070_6801359917141061773_n.jpg', '2024-04-21 01:19:29'),
(41, '98429', '58713', 'Birthday', '422585299_820572566750434_2222697526681411870_n.jpg', '2024-04-21 01:19:29'),
(42, '98429', '38280', 'Birthday', '422654759_820572350083789_6192728620996194384_n.jpg', '2024-04-21 01:19:29'),
(43, '98429', '31389', 'Birthday', '422706703_826428036164887_8732060406508703176_n.jpg', '2024-04-21 01:19:29'),
(44, '98429', '80271', 'Birthday', '423194715_826427976164893_3629022847641586669_n.jpg', '2024-04-21 01:19:29'),
(45, '98429', '24890', 'Birthday', '423236062_826428099498214_8839042282881121044_n.jpg', '2024-04-21 01:19:29'),
(46, '98429', '31426', 'Birthday', '423239614_826430922831265_6485571495022439912_n.jpg', '2024-04-21 01:19:29'),
(47, '98429', '69031', 'Birthday', '427689102_826429019498122_981317611564743985_n.jpg', '2024-04-21 01:19:29'),
(48, '98429', '54650', 'Christening', '432070471_839708858170138_4568621334112570975_n.jpg', '2024-04-21 01:19:45'),
(49, '98429', '39336', 'Christening', '432127326_839708771503480_6250694266237483367_n.jpg', '2024-04-21 01:19:45'),
(50, '98429', '88524', 'Christening', '432148234_839708518170172_3824236863392041932_n.jpg', '2024-04-21 01:19:45'),
(51, '93970', '58725', 'Wedding', '120089967_345404570149243_252400043009676053_n.jpg', '2024-04-21 04:20:15'),
(52, '93970', '54001', 'Wedding', '120134978_345405003482533_8901012720683269712_n.jpg', '2024-04-21 04:20:15'),
(53, '93970', '41506', 'Wedding', '120135045_345404716815895_4335502972499289604_n.jpg', '2024-04-21 04:20:15'),
(54, '93970', '28026', 'Wedding', '120175556_345404656815901_5076360168209215592_n.jpg', '2024-04-21 04:20:15'),
(55, '93970', '63022', 'Wedding', '120200246_345404920149208_5388428527705996482_n.jpg', '2024-04-21 04:20:15'),
(56, '78960', '63258', 'Birthday', '248350617_993995587813783_149449824498063868_n.jpg', '2024-04-21 04:26:30'),
(57, '78960', '74199', 'Birthday', '271210981_1332377183947555_1324289128860020857_n.jpg', '2024-04-21 04:26:30'),
(58, '78960', '69606', 'Birthday', '274947467_5310089832342761_5792133584081143592_n.jpg', '2024-04-21 04:26:30'),
(59, '78960', '68898', 'Birthday', '275003415_5310090112342733_7228417732185191441_n.jpg', '2024-04-21 04:26:30'),
(60, '78960', '52832', 'Birthday', '284543723_5134722959898434_2201477729260498292_n.jpg', '2024-04-21 04:26:30'),
(61, '78960', '63454', 'Birthday', '284793748_1375898386217098_7467882588958416882_n.jpg', '2024-04-21 04:26:30'),
(62, '78960', '48371', 'Birthday', '290908845_3467991136672701_5892120030592159704_n.jpg', '2024-04-21 04:26:30'),
(63, '78960', '68725', 'Birthday', '290913780_3467991003339381_5584267395913249314_n.jpg', '2024-04-21 04:26:30'),
(64, '78960', '93204', 'Birthday', '292020481_3467990666672748_8111000255231293585_n.jpg', '2024-04-21 04:26:30'),
(65, '78960', '98117', 'Birthday', '356254545_7230732940275906_2481588452682667191_n.jpg', '2024-04-21 04:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblclient_othermenus`
--

CREATE TABLE `tblclient_othermenus` (
  `id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `uniq_id` varchar(255) NOT NULL,
  `menu_id` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblclient_revenue_stats`
--

CREATE TABLE `tblclient_revenue_stats` (
  `id` int(11) NOT NULL,
  `transactionNo` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `revenue` decimal(10,2) NOT NULL,
  `collectedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblclient_settings`
--

CREATE TABLE `tblclient_settings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `cater_name` varchar(255) NOT NULL,
  `cater_description` varchar(255) NOT NULL,
  `bg_image` varchar(255) NOT NULL,
  `about_us` longtext NOT NULL,
  `cater_location` varchar(255) NOT NULL,
  `cater_email` varchar(255) NOT NULL,
  `cater_contactno` varchar(255) NOT NULL,
  `socmed_link` varchar(255) NOT NULL,
  `cater_gmaplink` varchar(255) NOT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblclient_settings`
--

INSERT INTO `tblclient_settings` (`id`, `client_id`, `cater_name`, `cater_description`, `bg_image`, `about_us`, `cater_location`, `cater_email`, `cater_contactno`, `socmed_link`, `cater_gmaplink`, `modifiedAt`) VALUES
(1, 78960, 'Kagahin Restaurant and Catering Services', 'Indulge in culinary excellence with GourmetEats. Reserve our gourmet offerings effortlessly via our user-friendly portal.', 'bg2.jpg', '', '', '', '', '', '', '2024-04-15 16:25:11'),
(2, 93970, 'Elisam Catering Services', 'Transform events with TasteBuds\' culinary delights. Our portal offers easy reservation customization for unforgettable experiences.', 'bg3.jpg', '', 'Forest Park sub. Pinagbayanan Pila Laguna', 'rinaocaya6@gmail.com', '09262597182', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3867.0440693880896!2d121.35376037667582!3d14.250651686195317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397e3163256df6b%3A0xab6145cd090d5fc5!2sForest%20Park%20Village!5e0!3m2!1sen!2sph!4v1713', '2024-04-15 16:25:11'),
(3, 98429, 'ANJ Catering Services', '<p style=\"text-align: left;\">Elevate events with Savor Cuisine\'s gourmet fare. Our portal simplifies reservations for seamless celebrations.</p>', 'hero-bg4.jpg', '<p>Welcome to ANJ Catering Service, where we bring flavors to life and make every event a memorable culinary experience.</p>\n<h4>Our Story</h4>\n<p>ANJ Catering Service was founded with a passion for exquisite cuisine and a dedication to impeccable service. Established by <strong id=\"docs-internal-guid-c4503c02-7fff-356e-415d-3715a5ea7ef1\">Mrs. Jovy Larrios</strong>, our journey began with a simple idea: to create extraordinary dining experiences that delight the senses.</p>\n<h4>Our Mission</h4>\n<p>At ANJ Catering Service, our mission is to exceed expectations with every dish we serve. We believe that food is more than sustenance; it\'s an art form. From intimate gatherings to grand celebrations, we bring creativity and passion to the table, ensuring each bite is a moment of culinary bliss.</p>\n<h4>What Sets Us Apart</h4>\n<ul>\n<li>\n<p><strong>Artistry in Every Dish</strong>: Our chefs are masters of their craft, infusing each creation with innovation and flavor.</p>\n</li>\n<li>\n<p><strong>Personalized Service</strong>: We understand that every event is unique. That\'s why we work closely with our clients to tailor menus that reflect their tastes and preferences.</p>\n</li>\n<li>\n<p><strong>Quality Ingredients</strong>: We source only the freshest, finest ingredients to craft dishes that are as delicious as they are beautiful.</p>\n</li>\n<li>\n<p><strong>Exceptional Attention to Detail</strong>: From the presentation of our dishes to the warmth of our service, we pay meticulous attention to every aspect of your event.</p>\n</li>\n</ul>', 'Purok 5 Balanga Pinagbayanan Pila Laguna', 'ArthuroLarrios@gmail.com', '09151581049', 'https://www.facebook.com/jovy.larrios.arthur?mibextid=ZbWKwL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7734.106138876408!2d121.35896083303221!3d14.250126640411358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397e18acc77f763%3A0xc746d0da44fd15fa!2sPinagbayanan%2C%20Pila%2C%20Laguna!5', '2024-04-15 16:25:11');

-- --------------------------------------------------------

--
-- Table structure for table `tblforgot_password_reset_tokens`
--

CREATE TABLE `tblforgot_password_reset_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblref_day`
--

CREATE TABLE `tblref_day` (
  `id` int(11) NOT NULL,
  `day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblref_day`
--

INSERT INTO `tblref_day` (`id`, `day`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31);

-- --------------------------------------------------------

--
-- Table structure for table `tblref_month`
--

CREATE TABLE `tblref_month` (
  `month_id` int(11) NOT NULL,
  `month` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblref_month`
--

INSERT INTO `tblref_month` (`month_id`, `month`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `username`, `password`, `createdAt`) VALUES
(1, 'admin', '$2y$10$UaCP/1g25kBP0ecEXmj9jujQYZAAt9.u6JLCkzNkngq.HPJdqiY.C', '2024-04-06 02:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clients`
--

CREATE TABLE `tbl_clients` (
  `client_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `client_image` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_clients`
--

INSERT INTO `tbl_clients` (`client_id`, `email`, `username`, `contact`, `address`, `password`, `client_image`, `createdAt`) VALUES
(78960, 'kagahin@gmail.com', 'Kagahin Restaurant and Catering Services', '094-555-1390', 'Luisina, Laguna', '$2y$10$DhdHxdkKBQ0TnT.qvWOUl.ieEd2HoWKmub1nD5UnOQi3jQI8Fowmy', 'kagahin_profile.jpg', '2024-04-06 02:40:22'),
(93970, 'elisam@gmail.com', 'Elisam Catering Services', '09175238715', 'Sta Cruz, Laguna', '$2y$10$WJatg9jbQ4XCHnleDQOv.ePhPjpxAhZNQQyZtjAkbc23pSNPUQy1K', 'elisam_profile.jpg', '2024-04-06 02:41:07'),
(98429, 'ANJ@gmail.com', 'Richard Ocaya', '09151581049', 'Sta Cruz, Laguna', '$2y$10$kSFPV6tJpne6FGjl.tgKnuBPHVeuoJkgwKJ4PTq/mOHimbVQHcU1q', 'ANJ_profile.jpg', '2024-04-06 02:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedbacks`
--

CREATE TABLE `tbl_feedbacks` (
  `id` int(11) NOT NULL,
  `customer_id` int(255) NOT NULL,
  `client_id` int(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rate` int(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `menu_image` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `transactionNo` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cater` varchar(255) NOT NULL,
  `package_id` int(11) NOT NULL,
  `selected_items` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total_price_with_tax` decimal(10,2) NOT NULL,
  `initial_payment` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `balance_paid` varchar(255) NOT NULL,
  `attendees` int(11) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_duration` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `is_read` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `From` varchar(255) DEFAULT NULL,
  `To` varchar(255) DEFAULT NULL,
  `payment_selection` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packages`
--

CREATE TABLE `tbl_packages` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_desc` text NOT NULL,
  `package_image` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userinformationorder`
--

CREATE TABLE `tbl_userinformationorder` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transactionNo` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `upload_image` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin_taxcollected_stats`
--
ALTER TABLE `tbladmin_taxcollected_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclient_faqs`
--
ALTER TABLE `tblclient_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclient_gallery`
--
ALTER TABLE `tblclient_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclient_othermenus`
--
ALTER TABLE `tblclient_othermenus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclient_revenue_stats`
--
ALTER TABLE `tblclient_revenue_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclient_settings`
--
ALTER TABLE `tblclient_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblforgot_password_reset_tokens`
--
ALTER TABLE `tblforgot_password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblref_day`
--
ALTER TABLE `tblref_day`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblref_month`
--
ALTER TABLE `tblref_month`
  ADD PRIMARY KEY (`month_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `tbl_userinformationorder`
--
ALTER TABLE `tbl_userinformationorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin_taxcollected_stats`
--
ALTER TABLE `tbladmin_taxcollected_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblclient_faqs`
--
ALTER TABLE `tblclient_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblclient_gallery`
--
ALTER TABLE `tblclient_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tblclient_othermenus`
--
ALTER TABLE `tblclient_othermenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tblclient_revenue_stats`
--
ALTER TABLE `tblclient_revenue_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblclient_settings`
--
ALTER TABLE `tblclient_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblforgot_password_reset_tokens`
--
ALTER TABLE `tblforgot_password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tblref_day`
--
ALTER TABLE `tblref_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tblref_month`
--
ALTER TABLE `tblref_month`
  MODIFY `month_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98430;

--
-- AUTO_INCREMENT for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98430;

--
-- AUTO_INCREMENT for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_userinformationorder`
--
ALTER TABLE `tbl_userinformationorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD CONSTRAINT `tbl_menus_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_clients` (`client_id`);

--
-- Constraints for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  ADD CONSTRAINT `tbl_packages_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_clients` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
