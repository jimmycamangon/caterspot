-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 12:43 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u682755333_ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actionlogs`
--

CREATE TABLE `tbl_actionlogs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `action_id` int(11) NOT NULL,
  `action_desc` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_actionlogs`
--

INSERT INTO `tbl_actionlogs` (`id`, `user_id`, `student_id`, `action_id`, `action_desc`, `created_at`) VALUES
(431, '1', '', 22, 'Department College of Computing Studies created', '2024-11-19 13:22:17'),
(432, '1', '', 1, 'Coordinator account created for CCSzyrel', '2024-11-19 13:23:19'),
(433, '1', '', 4, 'Program Bachelor of Science in Information Technology created', '2024-11-19 13:23:53'),
(434, '1', '', 7, 'Company Coca-Cola Beverages Philippines, Inc. – International created', '2024-11-19 13:26:55'),
(435, '1', '', 7, 'Company Agustinian School Of Cabuyao, Inc. created', '2024-11-21 13:41:08'),
(436, '1', '', 7, 'Company Cabuyao Social Welfare And Development created', '2024-11-21 13:41:47'),
(437, '1', '', 7, 'Company Eastwest Banking Corporation created', '2024-11-21 13:42:09'),
(438, '1', '', 7, 'Company Entrepreneur Rural Bank Inc. created', '2024-11-21 13:42:41'),
(439, '1', '', 7, 'Company B Fuller (Philippines, Inc. created', '2024-11-21 13:42:57'),
(440, '1', '', 7, 'Company Holy Redeemer School Of Cabuyao created', '2024-11-21 13:43:13'),
(441, '1', '', 7, 'Company Local Government Unit Of Cabuyao Through Peso/Ccldo/Dti created', '2024-11-21 13:43:30'),
(442, '1', '', 7, 'Company Panelo Accounting And Management Advisory Services created', '2024-11-21 13:43:52'),
(443, '1', '', 7, 'Company Sfy Integrated Inc. created', '2024-11-21 13:44:06'),
(444, '1', '', 7, 'Company Bureau Of Jail Management And Penology created', '2024-11-21 13:44:25'),
(445, '1', '', 7, 'Company Charus Credit Services Inc. created', '2024-11-21 13:45:02'),
(446, '1', '', 7, 'Company City Disaster Risk Reduction Management Office (Cdrrmo) created', '2024-11-21 13:45:18'),
(447, '1', '', 7, 'Company Corinthians Realty Services created', '2024-11-21 13:45:29'),
(448, '1', '', 7, 'Company Cyberage Construction Corporation created', '2024-11-21 13:45:42'),
(449, '1', '', 7, 'Company A&B Professional Pest Solutions, Corporation created', '2024-11-21 13:46:10'),
(450, '1', '', 7, 'Company Dimaano Accounting Firm created', '2024-11-21 13:46:27'),
(451, '1', '', 7, 'Company Aclan And Co.Cpas created', '2024-11-21 13:46:40'),
(452, '1', '', 7, 'Company Amcar Automotive Corporation created', '2024-11-21 13:46:53'),
(453, '1', '', 7, 'Company Apm Techica Ag created', '2024-11-21 13:47:09'),
(454, '1', '', 7, 'Company Aurotech Corporation created', '2024-11-21 13:47:22'),
(455, '1', '', 7, 'Company Balisong Channel created', '2024-11-21 13:47:43'),
(456, '1', '', 7, 'Company Bell Electronics Corporation created', '2024-11-21 13:48:05'),
(457, '1', '', 7, 'Company Cabuyao Water District created', '2024-11-21 13:54:05'),
(458, '1', '', 7, 'Company Canlubang Techno-Industrial Corporation created', '2024-11-21 13:54:22'),
(459, '1', '', 7, 'Company Cavtech Multi-Resources Technology Inc. created', '2024-11-21 13:57:22'),
(460, '1', '', 22, 'Department College of Education created', '2024-11-21 13:58:25'),
(461, '1', '', 4, 'Program Bachelor in Secondary Education created', '2024-11-21 14:01:43'),
(462, '1', '', 1, 'Coordinator account created for COEDclaren', '2024-11-21 14:02:22'),
(463, '1', '', 7, 'Company Charus Credit Services Inc. (Calamba Branch) created', '2024-11-21 14:07:01'),
(464, '1', '', 7, 'Company City Government Of Cabuyao created', '2024-11-21 14:07:19'),
(465, '1', '', 7, 'Company City Population Office created', '2024-11-21 14:07:44'),
(466, '1', '', 7, 'Company City Social Services created', '2024-11-21 14:08:01'),
(467, '1', '', 7, 'Company Concepcion-Carrier Airconditioning Company created', '2024-11-21 14:08:21'),
(468, '1', '', 7, 'Company Dangal Ng Pagbabago Rehabilitation Center created', '2024-11-21 14:08:44'),
(469, '1', '', 7, 'Company Deped School Division Of Cabuyao City created', '2024-11-21 14:09:01'),
(470, '1', '', 7, 'Company Deped Schools Of Sta. Rosa City created', '2024-11-21 14:09:13'),
(471, '1', '', 7, 'Company Dfph Design To Fit Philippines Garments Manufacturing created', '2024-11-21 14:09:27'),
(472, '1', '', 7, 'Company Dotsprerinch created', '2024-11-21 14:09:41'),
(473, '1', '', 7, 'Company Dynav Engineering Services created', '2024-11-21 14:14:31'),
(474, '1', '', 7, 'Company Engtek Precision Philippines, Inc. created', '2024-11-21 14:15:00'),
(475, '1', '', 7, 'Company T. De Vera Work Assistance And Management created', '2024-11-21 14:15:18'),
(476, '1', '', 7, 'Company Eyefhobe Rehabilitation Center created', '2024-11-21 14:15:30'),
(477, '1', '', 7, 'Company Fausto- Bayla Accounting And Auditing Services created', '2024-11-21 14:15:51'),
(478, '1', '', 7, 'Company Francisco-Mendoza Accounting Services created', '2024-11-21 14:16:02'),
(479, '1', '', 7, 'Company Gendiesel Philippines Inc. created', '2024-11-21 14:16:17'),
(480, '1', '', 7, 'Company Greenplus Corporation created', '2024-11-21 14:16:30'),
(481, '1', '', 7, 'Company Gtycoon Logistic Corporation created', '2024-11-21 14:16:43'),
(482, '1', '', 7, 'Company Hcs Insurance Services created', '2024-11-21 14:17:00'),
(483, '1', '', 7, 'Company Hydrocare System Technology Corporation created', '2024-11-21 14:17:12'),
(484, '1', '', 7, 'Company Institute For Foundational Learning, Inc. created', '2024-11-21 14:17:26'),
(485, '1', '', 7, 'Company Integrated Micro-Electronics, Inc. created', '2024-11-21 14:18:03'),
(486, '1', '', 7, 'Company Ionics Ems Inc. created', '2024-11-21 14:18:17'),
(487, '1', '', 7, 'Company Aclan Medical And Diagnostic Clinic Inc created', '2024-11-21 14:18:28'),
(488, '1', '', 7, 'Company Ja Balomit Accounting And Consultancy created', '2024-11-21 14:18:42'),
(489, '1', '', 7, 'Company Jacobo Z. Gonzales Memorial School Of Arts And Trades created', '2024-11-21 14:18:56'),
(490, '1', '', 7, 'Company Jlr Elevators & Escalators Corp. created', '2024-11-21 14:19:10'),
(491, '1', '', 7, 'Company Jnl Juneric Trading Inc. created', '2024-11-21 14:19:28'),
(492, '1', '', 7, 'Company Jobgrade Global Technologies, Inc. created', '2024-11-21 14:22:18'),
(493, '1', '', 7, 'Company Kabisig Workers Cooperative created', '2024-11-21 14:22:35'),
(494, '1', '', 7, 'Company Kamino Megumi Japanese created', '2024-11-21 14:22:48'),
(495, '1', '', 7, 'Company Kc (Knights Of Corps) Security Agency, Inc. created', '2024-11-21 14:23:53'),
(496, '1', '', 7, 'Company L.A. Buenaventura And Co., Cpas created', '2024-11-21 14:24:08'),
(497, '1', '', 7, 'Company Livelife Homecare Inc created', '2024-11-21 14:24:32'),
(498, '1', '', 7, 'Company Luzon Development Bank created', '2024-11-21 14:24:45'),
(499, '1', '', 7, 'Company Mgaylican Accounting Services created', '2024-11-21 14:25:16'),
(500, '1', '', 7, 'Company Mti Water Technologies Inc. created', '2024-11-21 14:25:28'),
(501, '1', '', 7, 'Company Multi-Mix International Manufacturing Corp. created', '2024-11-21 14:25:40'),
(502, '1', '', 7, 'Company Naivivs Contractor And Trading Corporation created', '2024-11-21 14:25:55'),
(503, '1', '', 7, 'Company Nep Logistic, Inc. created', '2024-11-21 14:26:08'),
(504, '1', '', 7, 'Company Netforce International created', '2024-11-21 14:26:25'),
(505, '1', '', 7, 'Company New Sinai School And Colleges Inc. created', '2024-11-21 14:26:37'),
(506, '1', '', 7, 'Company Nyk-Fil Maritime E-Training Inc. created', '2024-11-21 14:26:50'),
(507, '1', '', 7, 'Company One Green Arrow Manpower Corp. created', '2024-11-21 14:27:02'),
(508, '1', '', 7, 'Company Pag-Asa Youth Rehabilitation Center created', '2024-11-21 14:27:16'),
(509, '1', '', 7, 'Company Pioneer Adhesive Inc created', '2024-11-21 14:27:28'),
(510, '1', '', 7, 'Company Pixel8web Solution 7 Consultancy Inc. created', '2024-11-21 14:27:41'),
(511, '1', '', 7, 'Company Power Serve (Psi), Inc. created', '2024-11-21 14:27:52'),
(512, '1', '', 7, 'Company Prado And Sons Industries, Inc created', '2024-11-21 14:28:04'),
(513, '1', '', 7, 'Company R.A. Concepcion & Associates created', '2024-11-21 14:28:15'),
(514, '1', '', 7, 'Company Ral Accounting & Ta Consultancy Services created', '2024-11-21 14:28:31'),
(515, '1', '', 7, 'Company Ram Food Products Inc. created', '2024-11-21 14:28:44'),
(516, '1', '', 7, 'Company Ramon F. Garcia & Company created', '2024-11-21 14:28:57'),
(517, '1', '', 7, 'Company Rcd Realty Marketing Corp created', '2024-11-21 14:29:09'),
(518, '1', '', 7, 'Company Reign-Nan Sales Industry And General Contractor Inc. created', '2024-11-21 14:29:20'),
(519, '1', '', 7, 'Company Re-Lag Legacy Corporation created', '2024-11-21 14:29:43'),
(520, '1', '', 7, 'Company Remotask Inc created', '2024-11-21 14:29:55'),
(521, '1', '', 7, 'Company Retreat Paradise Rehabilitation Center created', '2024-11-21 14:30:07'),
(522, '1', '', 7, 'Company Rvfortuna Builders created', '2024-11-21 14:30:20'),
(523, '1', '', 7, 'Company Shin-Etsu Magnetics Philippines Inc. created', '2024-11-21 14:30:32'),
(524, '1', '', 7, 'Company Silgan White Cap South East Asia, Inc. created', '2024-11-21 14:30:44'),
(525, '1', '', 7, 'Company Sol Psychology Services created', '2024-11-21 14:30:55'),
(526, '1', '', 7, 'Company Spumoni Llc created', '2024-11-21 14:31:08'),
(527, '1', '', 7, 'Company Ssangyong Berjaya Motor Philippines created', '2024-11-21 14:31:18'),
(528, '1', '', 7, 'Company Sti College Calamba created', '2024-11-21 14:31:30'),
(529, '1', '', 7, 'Company Taascor Management And General Services Corp created', '2024-11-21 14:31:43'),
(530, '1', '', 7, 'Company Taihei Alltech Construction Philippines, Inc. created', '2024-11-21 14:32:00'),
(531, '1', '', 7, 'Company Ten Soon Machines Tools, Inc. created', '2024-11-21 14:32:15'),
(532, '1', '', 7, 'Company The Accounting Firm Of Olal’s Inc. created', '2024-11-21 14:32:29'),
(533, '1', '', 7, 'Company Themis Enterprise Inc. created', '2024-11-21 14:32:42'),
(534, '1', '', 7, 'Company Total Lubricants V Service Trading created', '2024-11-21 14:32:54'),
(535, '1', '', 7, 'Company Toyota Boshoku Phils. Corp. created', '2024-11-21 14:33:06'),
(536, '1', '', 7, 'Company Unihealth-Sta. Rosa Hospital & Medical Center created', '2024-11-21 14:33:57'),
(537, '1', '', 7, 'Company Vivo Talent Reserve Manpower Corp. created', '2024-11-21 14:34:08'),
(538, '1', '', 7, 'Company Vse Accounting Office created', '2024-11-21 14:34:22'),
(539, '1', '', 7, 'Company Vyq Shuttle Services created', '2024-11-21 14:34:33'),
(540, '1', '', 7, 'Company Wesselton Corporation created', '2024-11-21 14:34:45'),
(541, '1', '', 7, 'Company White Monkey Digital Lab Company created', '2024-11-21 14:34:58'),
(542, '1', '', 7, 'Company Yutaka Manufacturing Philippines Inc. created', '2024-11-21 14:35:16'),
(543, '1', '', 7, 'Company Don Bosco College Inc. created', '2024-11-21 14:35:27'),
(544, '1', '', 7, 'Company Westlake Medical Center created', '2024-11-21 14:35:39'),
(545, '1', '', 7, 'Company Mcpd Accountax And Business Consultation Services created', '2024-11-21 14:35:57'),
(546, '1', '', 7, 'Company Mobilecycle Technologies Inc. created', '2024-11-21 14:36:09'),
(547, '1', '', 22, 'Department College of Arts and Sciences created', '2024-11-21 14:37:15'),
(548, '1', '', 22, 'Department College of Engineering created', '2024-11-21 14:37:27'),
(549, '1', '', 22, 'Department College of Business, Accountancy, and Administration created', '2024-11-21 14:38:04'),
(550, '1', '', 22, 'Department College of Health and Science created', '2024-11-21 14:39:47'),
(551, '1', '', 4, 'Program Bachelor of Science in Computer Science created', '2024-11-21 14:40:20'),
(552, '1', '', 4, 'Program Bachelor of Science in Computer Engineering created', '2024-11-21 14:40:57'),
(553, '1', '', 4, 'Program Bachelor of Science in Electronics Engineering created', '2024-11-21 14:41:28'),
(554, '1', '', 4, 'Program Bachelor of Science in Industrial Engineering created', '2024-11-21 14:41:58'),
(555, '1', '', 4, 'Program Bachelor in Elementary Education created', '2024-11-21 14:42:21'),
(556, '1', '', 4, 'Program Bachelor of Science in Business Administration created', '2024-11-21 14:42:52'),
(557, '1', '', 4, 'Program Bachelor of Science in Nursing created', '2024-11-21 14:43:13'),
(558, '1', '', 4, 'Program Bachelor of Science in Accountancy created', '2024-11-21 14:43:43'),
(559, '1', '', 4, 'Program Bachelor of Science in Psychology(industrial) created', '2024-11-21 14:54:29'),
(560, '1', '', 4, 'Program Bachelor of Science in Psychology(educational) created', '2024-11-21 14:55:11'),
(561, '1', '', 4, 'Program Bachelor of Science in Psychology(clinical) created', '2024-11-21 14:55:30'),
(562, '1', '', 1, 'Coordinator account created for charry', '2024-11-21 15:00:58'),
(563, '1', '', 1, 'Coordinator account created for COEcharry', '2024-11-21 15:01:53'),
(564, '1', '', 1, 'Coordinator account created for CBAAzyrel', '2024-11-21 15:02:21'),
(565, '1', '', 1, 'Coordinator account created for CASclaren', '2024-11-21 15:03:04'),
(566, '1', '', 1, 'Coordinator account created for CHASclaren', '2024-11-21 16:30:02'),
(567, '1', '', 17, 'Information Update for Student Claren Atienza', '2024-11-21 16:48:18'),
(568, '1', '', 17, 'Information Update for Student Charisma Azores', '2024-11-21 17:11:41'),
(569, '1', '', 17, 'Information Update for Student Firstname1 Lastname1', '2024-11-21 17:12:59'),
(570, '1', '', 17, 'Information Update for Student Firstname7 Lastname7', '2024-11-21 17:17:33'),
(571, '1', '', 5, 'Department College of Health and Allied  Sciences updated', '2024-11-22 13:21:25'),
(572, '1', '', 6, 'Deleted program Bachelor of Science in Psychology(educational)', '2024-11-22 14:05:46'),
(573, '1', '', 6, 'Deleted program Bachelor of Science in Psychology(clinical)', '2024-11-22 14:05:56'),
(574, '1', '', 5, 'Program Bachelor of Science in Psychology(industrial, educational, clinical) updated', '2024-11-22 14:06:27'),
(575, '1', '', 20, 'Database backup created to file in date of: 2024-11-22_22-22-23', '2024-11-22 14:22:23'),
(582, '1', '', 24, 'Information Update for coordinator Clarens Atienza', '2024-11-23 06:02:41'),
(583, '1', '', 24, 'Information Update for coordinator Claren Atienza', '2024-11-23 06:03:02'),
(584, '1', '', 24, 'Information Update for coordinator Clarens Atienza', '2024-11-23 06:03:55'),
(585, '1', '', 24, 'Information Update for coordinator Claren Atienza', '2024-11-23 06:04:08'),
(586, '1', '', 24, 'Information Update for coordinator Juan Delacruz', '2024-11-23 06:13:40'),
(587, '1', '', 24, 'Information Update for coordinator Juan Delacruz', '2024-11-23 06:14:59'),
(588, '1', '', 24, 'Information Update for coordinator Juana  Delacruz', '2024-11-23 06:18:35'),
(589, '1', '', 24, 'Information Update for coordinator Juan Delacruz', '2024-11-23 06:22:07'),
(590, '1', '', 24, 'Information Update for coordinator Juan Delacruz', '2024-11-23 06:35:58'),
(591, '79581', '22101886', 18, 'Requirement PNC:AA-FO-20 Set Approved for Student Zyrel Trinidad', '2024-11-23 06:59:09'),
(592, '79581', '22101886', 18, 'Requirement PNC:AA-FO-21 Set Approved for Student Zyrel Trinidad', '2024-11-23 06:59:14'),
(593, '79581', '22101886', 18, 'Requirement PNC:AA-FO-22 Set Approved for Student Zyrel Trinidad', '2024-11-23 06:59:21'),
(594, '79581', '2101887', 19, 'Adjustment request for Student Zy Enriquez has been approved. Reason: forgot to time out', '2024-11-23 07:05:49'),
(595, '1', '2101887', 19, 'Adjustment request for Student Zy Enriquez has been approved. Reason: forgot to time out', '2024-11-23 07:06:12'),
(596, '79581', '2101887', 19, 'Adjustment request for Student Zy Enriquez has been approved. Reason: forgot to time out', '2024-11-23 07:07:44'),
(597, '1', '2101887', 19, 'Adjustment request for Student Zy Enriquez has been approved. Reason: forgot to time out', '2024-11-23 07:08:01'),
(598, '79581', '2101887', 18, 'Requirement PNC:AA-FO-20 Set Approved for Student Zy Enriquez', '2024-12-02 00:32:13'),
(599, '79581', '2101887', 18, 'Requirement PNC:AA-FO-21 Set Approved for Student Zy Enriquez', '2024-12-02 00:32:17'),
(600, '79581', '2101887', 18, 'Requirement PNC:AA-FO-22 Set Approved for Student Zy Enriquez', '2024-12-02 00:32:22'),
(601, '45726', '2101760', 18, 'Requirement PNC:AA-FO-25 Set Approved for Student Charisma Azores', '2024-12-03 04:29:09'),
(602, '79581', '7777777', 18, 'Requirement PNC:AA-FO-27 Set Approved for Student Darwin Turingan', '2024-12-05 14:27:08'),
(603, '79581', '2100870', 19, 'Adjustment request for Student Reymar Dugan has been approved. Reason: forgot to time out', '2024-12-06 14:03:18'),
(604, '1', '2100870', 19, 'Adjustment request for Student Reymar Dugan has been approved. Reason: forgot to time out', '2024-12-06 14:05:05'),
(605, '1', '', 1, 'Coordinator account created for Zytri', '2024-12-12 03:40:12'),
(606, '1', '', 23, 'Deleted DEPARTMENT College of Engineering', '2024-12-12 03:41:53'),
(607, '1', '', 22, 'Department College of Engineering created', '2024-12-12 03:42:37'),
(608, '1', '', 6, 'Deleted program Bachelor of Science in Nursing', '2024-12-12 03:43:55'),
(609, '1', '', 4, 'Program Bachelor of Nursing created', '2024-12-12 03:44:35'),
(610, '1', '', 7, 'Company Cyber cafe created', '2024-12-12 03:45:43'),
(611, '79581', '2100870', 19, 'Adjustment request for Student Reymar Dugan has been approved. Reason: i\'m sick', '2024-12-12 03:52:16'),
(612, '1', '2100870', 19, 'Adjustment request for Student Reymar Dugan has been approved. Reason: i\'m sick', '2024-12-12 03:53:50'),
(613, '1', '', 20, 'Database backup created to file in date of: 2024-12-12_11-54-58', '2024-12-12 03:54:58'),
(614, '1', '', 21, 'Database restored from file: backup_2024-12-12_11-54-58.sql', '2024-12-12 03:55:08'),
(615, '79581', '2100870', 18, 'Requirement PNC:AA-FO-21 Set Approved for Student Reymar Dugan', '2024-12-12 04:05:03'),
(616, '79581', '2100870', 19, 'Adjustment request for Student Reymar Dugan has been approved. Reason: we forgot', '2024-12-14 04:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adjustments`
--

CREATE TABLE `tbl_adjustments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `records` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `reject_reason` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_adjustments`
--

INSERT INTO `tbl_adjustments` (`id`, `student_id`, `records`, `reason`, `reject_reason`, `status`, `createdAt`) VALUES
(19, '2101887', '2024-11-22', 'forgot to time out', '', 'Adjusted', '2024-11-23 07:06:12'),
(20, '2101887', '2024-11-22', 'forgot to time out', '', 'Adjusted', '2024-11-23 07:08:01'),
(21, '2100870', '2024-12-03', 'forgot to time out', '', 'Adjusted', '2024-12-06 14:05:05'),
(22, '2100870', '2024-12-07', 'i\'m sick', '', 'Adjusted', '2024-12-12 03:53:50'),
(23, '2100870', '2024-12-12', 'we forgot', '', 'Approved', '2024-12-14 04:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `token_expiry` datetime NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `username`, `password`, `email`, `reset_token`, `token_expiry`, `createdAt`) VALUES
(1, 'imspnc_linkages', '$2y$10$Q2Ok9bCwCckueLjF5AbhneyY82.42kdQxVV6aWt3vdCfRSZqpywOC', 'imspnc69@gmail.com', '', '0000-00-00 00:00:00', '2024-04-06 02:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `id` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactno` int(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`id`, `company_id`, `company_name`, `email`, `address`, `contactno`, `createdAt`) VALUES
(132, '92972', 'Coca-Cola Beverages Philippines, Inc. – International', 'cocacola@gmail.com', 'laguna', 923, '2024-11-19 13:26:55'),
(133, '83596', 'Agustinian School Of Cabuyao, Inc.', 'N/A@gmail.com', 'N/A', 99999, '2024-11-21 13:41:08'),
(134, '19669', 'Cabuyao Social Welfare And Development', 'N/A@gmail.com', 'N/A@gmail.com', 9999, '2024-11-21 13:41:47'),
(135, '54743', 'Eastwest Banking Corporation', 'N/A@gmail.com', 'N/A@gmail.com', 999, '2024-11-21 13:42:09'),
(136, '96042', 'Entrepreneur Rural Bank Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:42:41'),
(137, '40314', 'B Fuller (Philippines, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:42:57'),
(138, '19463', 'Holy Redeemer School Of Cabuyao', 'N/A@gmail.com', 'N/A@gmail.com', 9999, '2024-11-21 13:43:13'),
(139, '44577', 'Local Government Unit Of Cabuyao Through Peso/Ccldo/Dti', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:43:30'),
(140, '80778', 'Panelo Accounting And Management Advisory Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:43:52'),
(141, '69045', 'Sfy Integrated Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:44:06'),
(142, '40806', 'Bureau Of Jail Management And Penology', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:44:25'),
(143, '98727', 'Charus Credit Services Inc.', 'N/A@gmail.com', 'N/A@gmail.com', 9999, '2024-11-21 13:45:02'),
(144, '75634', 'City Disaster Risk Reduction Management Office (Cdrrmo)', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:45:18'),
(145, '28855', 'Corinthians Realty Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:45:29'),
(146, '89003', 'Cyberage Construction Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:45:42'),
(147, '97906', 'A&B Professional Pest Solutions, Corporation', 'N/A@gmail.com', 'N/A@gmail.com', 9999, '2024-11-21 13:46:10'),
(148, '26319', 'Dimaano Accounting Firm', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:46:27'),
(149, '90762', 'Aclan And Co.Cpas', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:46:40'),
(150, '97840', 'Amcar Automotive Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:46:53'),
(151, '48854', 'Apm Techica Ag', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:47:09'),
(152, '75621', 'Aurotech Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:47:22'),
(153, '36751', 'Balisong Channel', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:47:43'),
(154, '24618', 'Bell Electronics Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:48:05'),
(155, '45042', 'Cabuyao Water District', 'N/A@gmail.com', 'N/A@gmail.com', 9999, '2024-11-21 13:54:05'),
(156, '69956', 'Canlubang Techno-Industrial Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:54:22'),
(157, '55491', 'Cavtech Multi-Resources Technology Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 13:57:22'),
(158, '99927', 'Charus Credit Services Inc. (Calamba Branch)', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:07:01'),
(159, '59318', 'City Government Of Cabuyao', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:07:19'),
(160, '16888', 'City Population Office', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:07:44'),
(161, '20901', 'City Social Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:08:01'),
(162, '54661', 'Concepcion-Carrier Airconditioning Company', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:08:21'),
(163, '58332', 'Dangal Ng Pagbabago Rehabilitation Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:08:44'),
(164, '40434', 'Deped School Division Of Cabuyao City', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:09:01'),
(165, '95640', 'Deped Schools Of Sta. Rosa City', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:09:13'),
(166, '17302', 'Dfph Design To Fit Philippines Garments Manufacturing', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:09:27'),
(167, '38582', 'Dotsprerinch', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:09:41'),
(168, '58362', 'Dynav Engineering Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:14:31'),
(169, '20177', 'Engtek Precision Philippines, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:15:00'),
(170, '27583', 'T. De Vera Work Assistance And Management', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:15:18'),
(171, '21694', 'Eyefhobe Rehabilitation Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:15:30'),
(172, '85065', 'Fausto- Bayla Accounting And Auditing Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:15:51'),
(173, '83572', 'Francisco-Mendoza Accounting Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:16:02'),
(174, '13305', 'Gendiesel Philippines Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:16:17'),
(175, '90773', 'Greenplus Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:16:30'),
(176, '10781', 'Gtycoon Logistic Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:16:43'),
(177, '63358', 'Hcs Insurance Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:17:00'),
(178, '30635', 'Hydrocare System Technology Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:17:12'),
(179, '71400', 'Institute For Foundational Learning, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:17:26'),
(180, '44103', 'Integrated Micro-Electronics, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:18:03'),
(181, '92765', 'Ionics Ems Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:18:17'),
(182, '90670', 'Aclan Medical And Diagnostic Clinic Inc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:18:28'),
(183, '28606', 'Ja Balomit Accounting And Consultancy', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:18:42'),
(184, '42180', 'Jacobo Z. Gonzales Memorial School Of Arts And Trades', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:18:56'),
(185, '45043', 'Jlr Elevators & Escalators Corp.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:19:10'),
(186, '46581', 'Jnl Juneric Trading Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:19:28'),
(187, '78097', 'Jobgrade Global Technologies, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:22:18'),
(188, '55692', 'Kabisig Workers Cooperative', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:22:35'),
(189, '23823', 'Kamino Megumi Japanese', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:22:48'),
(190, '53456', 'Kc (Knights Of Corps) Security Agency, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:23:53'),
(191, '54473', 'L.A. Buenaventura And Co., Cpas', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:24:08'),
(192, '28967', 'Livelife Homecare Inc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:24:32'),
(193, '40997', 'Luzon Development Bank', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:24:45'),
(194, '10098', 'Mgaylican Accounting Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:25:16'),
(195, '13378', 'Mti Water Technologies Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:25:28'),
(196, '15356', 'Multi-Mix International Manufacturing Corp.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:25:40'),
(197, '16627', 'Naivivs Contractor And Trading Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:25:55'),
(198, '75419', 'Nep Logistic, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:26:08'),
(199, '95661', 'Netforce International', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:26:25'),
(200, '57995', 'New Sinai School And Colleges Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:26:37'),
(201, '44659', 'Nyk-Fil Maritime E-Training Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:26:50'),
(202, '35092', 'One Green Arrow Manpower Corp.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:27:02'),
(203, '99992', 'Pag-Asa Youth Rehabilitation Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:27:16'),
(204, '24840', 'Pioneer Adhesive Inc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:27:28'),
(205, '77534', 'Pixel8web Solution 7 Consultancy Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:27:41'),
(206, '55601', 'Power Serve (Psi), Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:27:52'),
(207, '17179', 'Prado And Sons Industries, Inc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:28:04'),
(208, '22084', 'R.A. Concepcion & Associates', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:28:15'),
(209, '65783', 'Ral Accounting & Ta Consultancy Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:28:31'),
(210, '76218', 'Ram Food Products Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:28:44'),
(211, '92794', 'Ramon F. Garcia & Company', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:28:57'),
(212, '48726', 'Rcd Realty Marketing Corp', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:29:09'),
(213, '59395', 'Reign-Nan Sales Industry And General Contractor Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:29:20'),
(214, '11333', 'Re-Lag Legacy Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:29:43'),
(215, '11568', 'Remotask Inc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:29:55'),
(216, '86668', 'Retreat Paradise Rehabilitation Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:30:07'),
(217, '27687', 'Rvfortuna Builders', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:30:20'),
(218, '64461', 'Shin-Etsu Magnetics Philippines Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:30:32'),
(219, '34180', 'Silgan White Cap South East Asia, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:30:44'),
(220, '20950', 'Sol Psychology Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:30:55'),
(221, '24003', 'Spumoni Llc', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:31:08'),
(222, '32074', 'Ssangyong Berjaya Motor Philippines', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:31:18'),
(223, '43019', 'Sti College Calamba', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:31:30'),
(224, '64502', 'Taascor Management And General Services Corp', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:31:43'),
(225, '65230', 'Taihei Alltech Construction Philippines, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:32:00'),
(226, '88410', 'Ten Soon Machines Tools, Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:32:15'),
(227, '99912', 'The Accounting Firm Of Olal’s Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:32:29'),
(228, '82758', 'Themis Enterprise Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:32:42'),
(229, '26669', 'Total Lubricants V Service Trading', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:32:54'),
(230, '72901', 'Toyota Boshoku Phils. Corp.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:33:06'),
(231, '88152', 'Unihealth-Sta. Rosa Hospital & Medical Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:33:57'),
(232, '23596', 'Vivo Talent Reserve Manpower Corp.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:34:08'),
(233, '57102', 'Vse Accounting Office', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:34:22'),
(234, '98540', 'Vyq Shuttle Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:34:33'),
(235, '48902', 'Wesselton Corporation', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:34:45'),
(236, '21650', 'White Monkey Digital Lab Company', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:34:58'),
(237, '85603', 'Yutaka Manufacturing Philippines Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:35:16'),
(238, '23713', 'Don Bosco College Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:35:27'),
(239, '37133', 'Westlake Medical Center', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:35:39'),
(240, '60220', 'Mcpd Accountax And Business Consultation Services', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:35:57'),
(241, '58210', 'Mobilecycle Technologies Inc.', 'N/A@gmail.com', 'N/A@gmail.com	', 9999, '2024-11-21 14:36:09'),
(242, '54776', 'Cyber cafe', 'cyber@gmail.com', 'cabuyao laguna', 94957234, '2024-12-12 03:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coordinators`
--

CREATE TABLE `tbl_coordinators` (
  `id` int(11) NOT NULL,
  `coordinator_id` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `token_expiry` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_coordinators`
--

INSERT INTO `tbl_coordinators` (`id`, `coordinator_id`, `username`, `password`, `firstname`, `lastname`, `email`, `contact`, `department_id`, `reset_token`, `token_expiry`, `status`, `createdAt`) VALUES
(31, '79581', 'CCSzyrel', '$2y$10$jVNQVfQ9PVDj6SsVfhLwbegl2sYWzUxnICRDSRn3df9T9tYvIVR4e', 'Zyrel', 'Trinidad', 'trinidadzyrel86@gmail.com', '', 11155, '', '0000-00-00 00:00:00', 'Active', '2024-11-19 13:23:19'),
(32, '34957', 'COEDclaren', '$2y$10$8sELz3rNL/eJGV6T2DvGdOF8LHqLt7Y/pRXHVi7mCe460C.USIZhq', 'Claren', 'Atienza', 'atienzaclaren26@gmail.com', '', 31541, '', '0000-00-00 00:00:00', 'Active', '2024-11-21 14:02:22'),
(33, '70525', 'charry', '$2y$10$komZYWJeD.6xjn8SeWvsnOFii2C/7m.eXaniZNx79oOtDEq3yed/q', 'Charisma', 'Azores', 'azorescharisma60@gmail.com', '', 81206, '', '0000-00-00 00:00:00', 'Active', '2024-11-21 15:00:58'),
(34, '45726', 'COEcharry', '$2y$10$6U4fRgLiXu1/eogi5iI8aeROeogvQLtJjRZ4DldD1MYLv0Ts3iwqG', 'Juana ', 'Delacruz', 'juanadelacruz@gmail.com', '', 23593, '', '0000-00-00 00:00:00', 'Active', '2024-11-21 15:01:53'),
(35, '89029', 'CBAAzyrel', '$2y$10$eNlhkc4U4s4fpt.b7tNFKujwlOarLd/fhgwYjRkpB8OqAPHbTNXpi', 'Zyrel', 'Trinidad', 'trinidadzyrel86@gmail.com', '', 59491, '', '0000-00-00 00:00:00', 'Active', '2024-11-21 15:02:21'),
(36, '35634', 'CASclaren', '$2y$10$6yFQAHKXcgEJR5VnbANZEuW/gkVbNjCHV27sdhtmvweWuIGlUuNU6', 'Juan', 'Delacruz', 'juandelacruz@gmail.com', '', 29493, '', '0000-00-00 00:00:00', 'Inactive', '2024-11-21 15:03:04'),
(37, '68162', 'CHASclaren', '$2y$10$EuLkJOj52nRxbZu6jyKZ/./xStcXtOB20ML9sOMwCeq6qm86RDvpO', 'Claren', 'Atienza', 'atienzaclaren5@gmail.com', '', 29493, '', '0000-00-00 00:00:00', 'Active', '2024-11-21 16:30:02'),
(38, '79762', 'Zytri', '$2y$10$g2Z93heigKguTGfcJt3aD.df3pRcWE9ckoKCkmR571D4qx..g1Rim', 'Zyeee', 'Trinii', 'zyy@gmail.com', '099952344', 11155, '', '0000-00-00 00:00:00', 'Active', '2024-12-12 03:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

CREATE TABLE `tbl_departments` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `department_code` varchar(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`id`, `department_id`, `department_name`, `department_code`, `createdAt`) VALUES
(11, 11155, 'College of Computing Studies', 'CCS', '2024-11-19 13:22:17'),
(12, 31541, 'College of Education', 'COED', '2024-11-21 13:58:25'),
(13, 81206, 'College of Arts and Sciences', 'CAS', '2024-11-21 14:37:15'),
(15, 59491, 'College of Business, Accountancy, and Administration', 'CBAA', '2024-11-21 14:38:04'),
(16, 29493, 'College of Health and Allied  Sciences', 'CHAS', '2024-11-21 14:39:47'),
(17, 31819, 'College of Engineering', 'COE', '2024-12-12 03:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_programs`
--

CREATE TABLE `tbl_programs` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `program_id` varchar(255) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `program_hour` int(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_programs`
--

INSERT INTO `tbl_programs` (`id`, `department_id`, `program_id`, `program_name`, `program_hour`, `createdAt`) VALUES
(40, 11155, '72936', 'Bachelor of Science in Information Technology', 500, '2024-11-19 13:23:53'),
(41, 31541, '68692', 'Bachelor in Secondary Education', 360, '2024-11-21 14:01:43'),
(42, 11155, '20382', 'Bachelor of Science in Computer Science', 300, '2024-11-21 14:40:20'),
(43, 23593, '57354', 'Bachelor of Science in Computer Engineering', 240, '2024-11-21 14:40:57'),
(44, 23593, '30502', 'Bachelor of Science in Electronics Engineering', 240, '2024-11-21 14:41:28'),
(45, 23593, '70291', 'Bachelor of Science in Industrial Engineering', 240, '2024-11-21 14:41:58'),
(46, 31541, '61619', 'Bachelor in Elementary Education', 360, '2024-11-21 14:42:21'),
(47, 59491, '98321', 'Bachelor of Science in Business Administration', 600, '2024-11-21 14:42:52'),
(49, 59491, '94189', 'Bachelor of Science in Accountancy', 400, '2024-11-21 14:43:43'),
(50, 81206, '17829', 'Bachelor of Science in Psychology(industrial, educational, clinical)', 450, '2024-11-21 14:54:29'),
(53, 29493, '56110', 'Bachelor of Nursing', 2703, '2024-12-12 03:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reference`
--

CREATE TABLE `tbl_reference` (
  `action_id` int(11) NOT NULL,
  `action_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reference`
--

INSERT INTO `tbl_reference` (`action_id`, `action_name`) VALUES
(1, 'Created a coordinator'),
(2, 'Updated a coordinator'),
(3, 'Deleted a coordinator'),
(4, 'Created a program'),
(5, 'Updated a program'),
(6, 'Deleted a program'),
(7, 'Created a company'),
(8, 'Updated a company'),
(9, 'Deleted a company'),
(10, 'Deleted a student'),
(11, 'Logged in'),
(12, 'Logged out'),
(13, 'Exported data'),
(14, 'Imported data'),
(15, 'Changed system settings'),
(16, 'Performed a security audit'),
(17, 'Set Status Student'),
(18, 'Set Requirement Status Intern'),
(19, 'Set Adjustment Status Intern'),
(20, 'Created a backup file'),
(21, 'Restored a backup file'),
(22, 'ACTION_CREATE_DEPARTMENT'),
(23, 'ACTION_DELETE_DEPARTMENT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `records` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `reject_reason` varchar(255) NOT NULL,
  `files` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_request`
--

INSERT INTO `tbl_request` (`id`, `student_id`, `records`, `reason`, `reject_reason`, `files`, `status`, `createdAt`) VALUES
(32, '2101887', '2024-11-29', 'no internet connection that time', '', '../../uploads/adjustments/ADDING DEPARTMENT FINAL.png', 'Approved', '2024-12-01 16:26:41'),
(33, '2100870', '2024-12-04', 'No data, and internet connection', '', '../../uploads/adjustments/462575793_1266194874621208_9067666659189414080_n.jpg', 'Approved', '2024-12-05 14:18:24'),
(34, '2100870', '2024-12-13', 'No internet connection', '', '../../uploads/adjustments/466538668_1583460855892403_3879620830712415607_n.jpg', 'Approved', '2024-12-14 04:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requirements`
--

CREATE TABLE `tbl_requirements` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `form_type` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `cancel_reason` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_requirements`
--

INSERT INTO `tbl_requirements` (`id`, `student_id`, `form_type`, `file_name`, `file_path`, `status`, `cancel_reason`, `uploaded_at`) VALUES
(42, '22101886', 'PNC:AA-FO-20', 'FullReport_Zyrel Trinidad.pdf', 'requirements/FullReport_Zyrel Trinidad.pdf', 'Approved', '', '2024-11-23 06:56:56'),
(43, '22101886', 'PNC:AA-FO-21', 'IEEE-Citation-Guidelines.pdf', 'requirements/IEEE-Citation-Guidelines.pdf', 'Approved', '', '2024-11-23 06:57:25'),
(44, '22101886', 'PNC:AA-FO-22', 'Commet-Sheet-for-Panel-Approval.pdf', 'requirements/Commet-Sheet-for-Panel-Approval.pdf', 'Approved', '', '2024-11-23 06:57:55'),
(45, '22101886', 'PNC:AA-FO-23', 'letter for ethics.pdf', 'requirements/letter for ethics.pdf', 'Pending', '', '2024-11-23 06:58:22'),
(46, '7777777', 'PNC:AA-FO-27', 'TRY-PDF.pdf', 'requirements/TRY-PDF.pdf', 'Approved', '', '2024-11-23 08:08:17'),
(47, '2101887', 'PNC:AA-FO-20', 'with sir ochie.pdf', 'requirements/with sir ochie.pdf', 'Approved', '', '2024-12-01 16:34:50'),
(48, '2101887', 'PNC:AA-FO-21', 'Questionnaires-for-IT-Experts_ITA4.pdf', 'requirements/Questionnaires-for-IT-Experts_ITA4.pdf', 'Approved', '', '2024-12-01 16:35:26'),
(49, '2101887', 'PNC:AA-FO-22', '467462638_1290868655259517_285742198786019023_n.jpg', 'requirements/467462638_1290868655259517_285742198786019023_n.jpg', 'Approved', '', '2024-12-01 16:35:55'),
(50, '2101887', 'PNC:AA-FO-30', 'ShortReport_Zyrel-Trinidad.pdf', 'requirements/ShortReport_Zyrel-Trinidad.pdf', 'Pending', '', '2024-12-01 16:38:52'),
(51, '2100870', 'PNC:AA-FO-20', 'Comment_Sheet_PROF.DARWIN.docx', 'requirements/Comment_Sheet_PROF.DARWIN.docx', 'Pending', '', '2024-12-02 12:01:42'),
(52, '2100870', 'PNC:AA-FO-31', 'Comment_Sheet_PROF.DARWIN.docx', 'requirements/Comment_Sheet_PROF.DARWIN.docx', 'Pending', '', '2024-12-02 12:29:14'),
(53, '2101760', 'PNC:AA-FO-22', 'PNC PRE-FO-104 Client Acceptance Form (For Client-Based Research).pdf', 'requirements/PNC PRE-FO-104 Client Acceptance Form (For Client-Based Research).pdf', 'Pending', '', '2024-12-03 04:26:05'),
(54, '2101760', 'PNC:AA-FO-25', 'CHAPTER 1.pdf', 'requirements/CHAPTER 1.pdf', 'Approved', '', '2024-12-03 04:26:25'),
(55, '2100870', 'PNC:AA-FO-21', 'ZYREL RESUME.pdf', 'requirements/ZYREL RESUME.pdf', 'Approved', '', '2024-12-05 14:13:35'),
(56, '2100870', 'PNC:AA-FO-22', '462647652_8340622169377188_930384405898402224_n.jpg', 'requirements/462647652_8340622169377188_930384405898402224_n.jpg', 'Pending', '', '2024-12-07 07:43:03'),
(57, '7777777', 'PNC:AA-FO-20', 'USERS-ACCEPTANCE FOR PRINT.pdf', 'requirements/USERS-ACCEPTANCE FOR PRINT.pdf', 'Pending', '', '2024-12-12 04:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timelogs`
--

CREATE TABLE `tbl_timelogs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `pin` char(4) NOT NULL,
  `type` enum('time_in','time_out') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `longitude` decimal(9,6) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `photo` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_timelogs`
--

INSERT INTO `tbl_timelogs` (`id`, `student_id`, `pin`, `type`, `timestamp`, `longitude`, `latitude`, `photo`) VALUES
(165, '22101886', '', 'time_in', '2024-11-19 21:29:41', 121.121839, 14.236223, ''),
(166, '22101886', '$2y$', 'time_out', '2024-11-19 21:53:42', 121.121838, 14.236208, 0x313733323032343339362d70686f746f2e706e67),
(167, '22101886', '', 'time_in', '2024-11-21 21:14:45', 121.143551, 14.274027, ''),
(168, '2101887', '$2y$', 'time_in', '2024-11-22 20:05:18', 121.132781, 14.260634, 0x313733323237373130392d70686f746f2e706e67),
(169, '1903227', '$2y$', 'time_in', '2024-11-23 09:36:45', 121.132803, 14.260646, 0x313733323332353739302d70686f746f2e706e67),
(170, '2101887', '', 'time_out', '2024-11-21 15:06:00', 121.143551, 14.274027, ''),
(171, '2101887', '', 'time_out', '2024-11-21 20:07:00', 121.143551, 14.274027, ''),
(172, '2101769', '', 'time_in', '2024-11-23 15:40:35', 121.133438, 14.259698, ''),
(173, '22101886', '', 'time_in', '2024-11-23 16:00:48', 121.125393, 14.270194, ''),
(181, '1234512', '', 'time_in', '2024-12-01 18:13:13', 121.125445, 14.301945, ''),
(182, '1234512', '', 'time_out', '2024-12-01 18:13:30', 121.125445, 14.301945, ''),
(183, '22101886', '', 'time_in', '2024-12-01 18:44:53', 121.121847, 14.236251, ''),
(184, '22101886', '', 'time_out', '2024-12-01 18:45:57', 121.121836, 14.236236, ''),
(185, '2101887', '', 'time_in', '2024-12-01 18:48:46', 121.121836, 14.236236, ''),
(186, '2101887', '', 'time_out', '2024-12-01 18:50:24', 121.121836, 14.236236, ''),
(189, '1751222', '$2y$', 'time_in', '2024-12-02 00:21:36', 121.121845, 14.236247, 0x313733333037303038312d70686f746f2e706e67),
(190, '2101887', '', 'time_in', '2024-11-29 07:00:00', 0.000000, 0.000000, ''),
(191, '2101887', '', 'time_out', '2024-11-29 17:00:00', 0.000000, 0.000000, ''),
(192, '2101887', '$2y$', 'time_in', '2024-12-02 09:52:04', 121.121857, 14.236182, 0x313733333130343330302d70686f746f2e706e67),
(193, '2101887', '', 'time_out', '2024-12-02 19:16:41', 121.143563, 14.274024, ''),
(194, '2101760', '$2y$', 'time_in', '2024-12-02 19:50:36', 121.143599, 14.274003, 0x313733333134303231392d70686f746f2e706e67),
(195, '2100870', '', 'time_in', '2024-12-03 13:36:00', 121.133975, 14.259377, ''),
(196, '2100870', '', 'time_in', '2024-12-04 07:00:00', 0.000000, 0.000000, ''),
(197, '2100870', '', 'time_out', '2024-12-04 16:00:00', 0.000000, 0.000000, ''),
(198, '2100870', '', 'time_out', '2024-12-03 17:00:00', 121.133975, 14.259377, ''),
(199, '2100870', '', 'time_in', '2024-12-07 15:12:35', 121.121844, 14.236224, ''),
(200, '2100870', '', 'time_in', '2024-12-10 18:47:31', 121.121858, 14.236182, ''),
(201, '7777777', '$2y$', 'time_in', '2024-12-12 11:49:16', 121.110528, 14.303232, 0x313733333937353335342d70686f746f2e706e67),
(202, '2100870', '', 'time_out', '2024-12-03 07:53:00', 121.133975, 14.259377, ''),
(203, '2100870', '', 'time_in', '2024-12-12 12:19:01', 121.121845, 14.236249, ''),
(204, '2100870', '', 'time_in', '2024-12-14 08:00:00', 0.000000, 0.000000, ''),
(205, '2100870', '', 'time_out', '2024-12-13 17:00:00', 0.000000, 0.000000, ''),
(206, '7777777', '$2y$', 'time_in', '2024-12-14 12:41:28', 121.121843, 14.236260, 0x313733343135313236392d70686f746f2e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `credential_id` text DEFAULT NULL,
  `attestation_object` text DEFAULT NULL,
  `client_data_json` text DEFAULT NULL,
  `pin` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `program_id` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `coordinator_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_pic` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `token_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `student_id`, `credential_id`, `attestation_object`, `client_data_json`, `pin`, `firstname`, `lastname`, `email`, `phone`, `address`, `program_id`, `company_id`, `coordinator_id`, `status`, `createdAt`, `profile_pic`, `reset_token`, `token_expiry`) VALUES
(200, '1903226', NULL, NULL, NULL, '$2y$10$6ijQ1WBzZzucHEPCTuedKuiUSW8e7D.DhhSml49V9RGwQfJ5QnTxe', 'Claren', 'Atienza', 'atienzaclaren26@gmail.com', '09933031521', 'blk 14 lot 71, Southville 1, Marinig, Cabuyao, Laguna', 68692, '92972', 34957, 'Active', '2024-11-21 14:04:03', '', '', '0000-00-00 00:00:00'),
(202, '2101760', NULL, NULL, NULL, '$2y$10$eoJIre6VbyxtWZo5HOgGHuZMk/C8YL1i24xx.Q.itigWJoxrxMaUG', 'Charisma', 'Azores', 'azorescharisma60@gmail.com', '09518955209', 'blk 20 lot 25, Katapatan Homes, Banay Banay, Cabuyao, Laguna', 57354, '83596', 45726, 'Active', '2024-11-21 17:11:41', '', '', '0000-00-00 00:00:00'),
(213, '1903227', NULL, NULL, NULL, '$2y$10$XKzB1fJGQwTiLSHrw46E5.llsPS1j8kUcbQRAtmV1kmveKtHVzVSG', 'Clrsey', 'Atienza', 'atienzaclaren0@gmail.com', '09279395528', 'blk 15 lot 72, Southville 1, Marinig, Cabuyao, Laguna', 84203, '19669', 68162, 'Active', '2024-11-21 16:34:04', '', '', '0000-00-00 00:00:00'),
(215, '2101889', NULL, NULL, NULL, '$2y$10$6gPobOb8S7puKI6aVjdrK.Y47pvkEyhsIFGwy6FIIsveWkOt0Lf8O', 'John', 'Aquino', 'john@gmail.com', '9385837313', 'cabuyao', 84203, '', 35634, 'Active', '2024-11-23 06:27:31', '', '', '0000-00-00 00:00:00'),
(216, '2101880', NULL, NULL, NULL, '$2y$10$sms0DUqLPh5nOroQ40gaF.hMleU2Dx5JFamQLelR9ZZnGyVGic8Ce', 'Reymar', 'Dugan', 'reymar@gmail.com', '9285837183', 'cabuyao', 84203, '', 35634, 'Active', '2024-11-23 06:27:31', '', '', '0000-00-00 00:00:00'),
(217, '2101881', NULL, NULL, NULL, '$2y$10$CxRzBCQQjjIjIxgAM1hB6ODMXi3epv7jovIGj60M0JGVMOYJjaJaC', 'Carl', 'Castillo', 'carl@gmail.com', '9827583917', 'cabuyao', 84203, '', 35634, 'Active', '2024-11-23 06:27:31', '', '', '0000-00-00 00:00:00'),
(218, '2101769', 'ATYcUR+5gbGJ//0TzPlW6TDaZ6E0ce2sAQsHikelEst9MvNDajup5GzvTBnqoQ67oOxZKaZnmquIDUF/3ZVr2LQ=', 'o2NmbXRxYW5kcm9pZC1zYWZldHluZXRnYXR0U3RtdKJjdmVyaTI0NDYzMDAxM2hyZXNwb25zZVkgAGV5SmhiR2NpT2lKU1V6STFOaUlzSW5nMVl5STZXeUpOU1VsR1RVUkRRMEpDYVdkQmQwbENRV2RKVWtGTlN5dDRVSEpKVkhadVVVTlllVXhaYlhWVlUxbFJkMFJSV1VwTGIxcEphSFpqVGtGUlJVeENVVUYzVDNwRlRFMUJhMGRCTVZWRlFtaE5RMVpXVFhoSWFrRmpRbWRPVmtKQmIxUkdWV1IyWWpKa2MxcFRRbFZqYmxaNlpFTkNWRnBZU2pKaFYwNXNZM3BGVFUxQmIwZEJNVlZGUVhoTlJGWXhTVEJOUWpSWVJGUkpNRTFVUlhkT2FrVXhUV3BuTVU0eGIxaEVWRWt4VFVSSmQwNUVSVEZOYW1jeFRteHZkMGhVUldKTlFtdEhRVEZWUlVGNFRWTlpXRkl3V2xoT01FeHRSblZhU0VwMllWZFJkVmt5T1hSTlNVbENTV3BCVGtKbmEzRm9hMmxIT1hjd1FrRlJSVVpCUVU5RFFWRTRRVTFKU1VKRFowdERRVkZGUVhCUVdITlhNbGRNU1c5aVlrRTBUbTF4VTFSNWVqaFRkWGxXWW01ak0wcDZRV0phTjJ0R04zRkxUa0ZzV2tOSlVYSnphUzlYWWxOWEswVTNVMnB3YkROVFlWVlNkU3RFTW1GM05GUlFSelZLZVZSa2IyWkhZamxLT1dzMlUzZFZORE4wVFZwQk1FOHJNRGxaUzJjNFRITlFUMFlyTm5RNFQycExka05xYzNWeUx5OXBTVFZDY0hwRU9XSlhhREo2TkZNMU1USlRSVGcyWnpkcFZubHRhMDQwVDB4UVF6RlZaR2t6VUhadWNVSkROVGx3YVZSUlZDdE5VekV3V0RGTmRUa3lZbmhUU2twWFJrNXRNREpZV21WcWJFUkpaazA0WkdRNGJuZzBZVnBGV1c5TU1ITlZNMnhKWkRjMWIyc3dNbVZQU0c4NE5uRlpVamxWTm1JeGJYbDFSRGxTVlZKMGRqTkNVbmx5ZVVFeFJFWnRja2RyYWtwT1ZWRmhVR1ZyYlV0cFYzcEVTa2xsZVV0S1psaHJVR3hQU0VVMldERkVXWGd4VlRoSVV5OUVTRUZYZFV0RmMzQm5XSGd2YVdoUGVHSmFPVFp0ZDBsRVFWRkJRbTgwU1VOVGVrTkRRV3RqZDBSbldVUldVakJRUVZGSUwwSkJVVVJCWjFkblRVSk5SMEV4VldSS1VWRk5UVUZ2UjBORGMwZEJVVlZHUW5kTlFrMUJkMGRCTVZWa1JYZEZRaTkzVVVOTlFVRjNTRkZaUkZaU01FOUNRbGxGUms5dlFuSk1RaTgzVkhKMWIwdDNWMkl2VGpkQlJ6SkJkbUZSUmsxQ09FZEJNVlZrU1hkUldVMUNZVUZHU25aSlJXSjNPWEZxWVRWTldYaFBhakJVVmxaNlNYWjNPRUpvVFVZMFIwTkRjMGRCVVZWR1FuZEZRa0pHU1hkVlJFRnVRbWRuY2tKblJVWkNVV04zUVZsWlltRklVakJqUkc5MlRESTRkV05IZEhCTWJXUjJZakpqZG1ONU9UTmphbEYyWkROSk1FMURWVWREUTNOSFFWRlZSa0o2UVVOb2FHeHZaRWhTZDA5cE9IWmhVelYzWVRKcmRWb3lPWFphZVRrelkycFJkVmt6U2pCTlFqQkhRVEZWWkVWUlVWZE5RbE5EUlcxR01HUkhWbnBrUXpWb1ltMVNlV0l5Ykd0TWJVNTJZbFJCVkVKblRsWklVMEZGUkVSQlMwMUJaMGRDYldWQ1JFRkZRMEZVUVRKQ1owNVdTRkk0UlV4NlFYUk5RM1ZuUzJGQmJtaHBWbTlrU0ZKM1QyazRkbGw1TlhkaE1tdDFXakk1ZGxwNU9UTmphbEYyVW1reFdGSnJjekZpYkVZeFkydFZkVmt6U25OTlNVbENRa0ZaUzB0M1dVSkNRVWhYWlZGSlJVRm5VMEk1VVZOQ09HZEVkMEZJV1VGVWJsZHFTakY1WVVWTlRUUlhNbnBWTTNvNVV6WjRNM2MwU1RSaWFsZHVRWE5tY0d0elYwdGhUMlE0UVVGQlIxUkJhemRwU1dkQlFVSkJUVUZTZWtKR1FXbENNa1l3TW1WRVdUZ3pjVzloYmpKTFZWVjFVV2MwVWpoaFJYRnBRVzVGZWxwVVlYQnpNaXNyVWxwRFFVbG9RVTFQZVdGaldtbzNLMk5DYW5OQk5VSjVXVVEwVFhJdlYxSk5UbEkyUzJaaFNVUmlUVUo2VVd0aE9VeEJTRmxCZWxCelVHRnZWbmhEVjFncmJGcDBWSHAxYlhsbVEweHdhRlozVG13ME1qSnhXRFZWZDFBMVRVUmlRVUZCUVVkVVFXczNhVmRSUVVGQ1FVMUJVbnBDUmtGcFFqZEljemQ0YzA5eWRWbEpVRlZSZEVGUGNIUXdLM29yT1VKWlFtTkRVVk4yV1ZaUmJsaDBhblF2V0dkSmFFRlFiMkV3TVVKRGRVNWtlVm96YXpsUVlqUmpSeTl3ZEV0SVJsSnVkSEUwWkM4eVVuaHllbkpGYUVseFRVRXdSME5UY1VkVFNXSXpSRkZGUWtOM1ZVRkJORWxDUVZGQmNIRXlaVGhJTmtkdlptTjZaRWRFU0daYWREVnZTbHBMZWtOa1ZFaERjMGhYTTFOU1dIRkdjVEpTT0VONFpGbFZNVEJsVXpOV05XYzFielpwTUdsQlVISkRabXRzWm5aaFExUnFSWFZpVFdJM1ptcFpMMlpuTkdVMGNFNXRPWGx0VlhNNVZVb3ljMkoxZHpKbE1XaERUWEprV1dJM01IbGhMMjlhY0RCdU5XcHdhMHhJWnpScmRpdFJja1J0UVM5T1kxcE5kRTk0TkdjMGNGZE1UbGxqY0hGcU1UVnhhRVF2Ym5KWlkxUjZOVnBPVGtONE16TkVNRXhXUjB3eGJGTlNjWGRUVkhGVmVrVktVM1ZyT1djdlZVMUhObGxXU1V0dlluSlVjWEJDYTFwSGRGRlRLMEZzYjJNNFlYSjBibWxVZVZSV2JYQTRXVlZZVWxCMlprbG5XRGREZVZsSk5EVmpkakU1V0dneWJ6RTBibEZ6UTNwWmFVNW5NR2xCY0RaTWRVTnhVVTEzUm1NNGFrTlRiVGNyUmxSdFJVdEViRVFyWTA1ME5FaDRZVEJXZVRSVk0yVlVLMUpEWmpCVVlucE1hbVZQZFRVaUxDSk5TVWxHUTNwRFEwRjJUMmRCZDBsQ1FXZEpVV1l2UVVaMFRuQXhkVWR3WVhob0wydE5TR05VZWxSQlRrSm5hM0ZvYTJsSE9YY3dRa0ZSYzBaQlJFSklUVkZ6ZDBOUldVUldVVkZIUlhkS1ZsVjZSV2xOUTBGSFFURlZSVU5vVFZwU01qbDJXako0YkVsR1VubGtXRTR3U1VaT2JHTnVXbkJaTWxaNlNVVjRUVkY2UlZWTlFrbEhRVEZWUlVGNFRVeFNNVkpVU1VaS2RtSXpVV2RWYWtWM1NHaGpUazFxVFhoTmFrVjZUVVJyZDAxRVFYZFhhR05PVFdwcmQwMXFTWGROVkZGM1RVUkJkMWRxUVRkTlVYTjNRMUZaUkZaUlVVZEZkMHBXVlhwRlpVMUNkMGRCTVZWRlEyaE5WbEl5T1haYU1uaHNTVVpTZVdSWVRqQkpSazVzWTI1YWNGa3lWbnBOVVhkM1EyZFpSRlpSVVVSRmQwNVlWV3BSZDJkblJXbE5RVEJIUTFOeFIxTkpZak5FVVVWQ1FWRlZRVUUwU1VKRWQwRjNaMmRGUzBGdlNVSkJVVU4yVkd4SEwzcHNRMnMyTkRRNWEyRlhMMFJEYjJseGIzQXdjRWwzZVdGT09FdFJSMkp6VmpJd2MzSXdZalF5T1VweVVrMVJURXBVTHpkelNWSk1jMWhrY2xaalFUVTNOelZXT1ZoUkwwWnNWbEJWYzNsR1VXRlhTRVY0WjJGUllXWXlVRnA0VGxacldXWlVPVk5VTlRkaE9WVmlWaXRPVkd4a1kyNXRlSFp2YjB4dGNHaDNMMVJHZG14dWNIRXljazB4Tlhsc1NHbHhPR3hIY1dkUmNGSTVMelpCVEhWdmJHMVhSRlpQVUVaRlowRnNWR1E1VVc5RlZ6bG5URTExUnpOc1R6TXhiSFJ6Wlc1YVYxUXhiRU5SVXpKU1VsWlRlRmhxTjJOU016SnNXR2RUUlhOck1WcDZOVGRsVW14blEyWjVaa0YyVlVwVmRFMTBPVGd5YzI5T1VqSmtlazlXVDB0cU9YcHNhV1ZHY21Ka1prSmFhSGhhU0ZGdU4wbEtkVWRqWTJScFNtNUxWRlJsWWtKcWVFMW9WV05WU0dzMk1ubHNUemRuWlV4MFlqTktUVlZpWW01MlUxbEVNbFZCWTJ4bmVuSjNiRUZuVFVKQlFVZHFaMlkwZDJkbWMzZEVaMWxFVmxJd1VFRlJTQzlDUVZGRVFXZEhSMDFDTUVkQk1WVmtTbEZSVjAxQ1VVZERRM05IUVZGVlJrSjNUVUpDWjJkeVFtZEZSa0pSWTBSQmFrRlRRbWRPVmtoU1RVSkJaamhGUTBSQlIwRlJTQzlCWjBWQlRVSXdSMEV4VldSRVoxRlhRa0pUWW5sQ1J6aFFZVzh5ZFZSSFRWUnZPVVV4Vm1ONVREaFFRVmxVUVdaQ1owNVdTRk5OUlVkRVFWZG5RbFJyY25semJXTlNiM0pUUTJWR1RERktiVXhQTDNkcFVrNTRVR3BCTUVKblozSkNaMFZHUWxGalFrRlJVVzlOUTFsM1NrRlpTVXQzV1VKQ1VWVklUVUZMUjBkSGFEQmtTRUUyVEhrNWNFeHVRbkpoVXpWdVlqSTVia3d6U1hoTWJVNTVaRVJCY2tKblRsWklVamhGU2tSQmFVMURRMmRJY1VGamFHaHdiMlJJVW5kUGFUaDJXWGsxZDJFeWEzVmFNamwyV25rNWVVd3pTWGhNYlU1NVlrUkJWRUpuVGxaSVUwRkZSRVJCUzAxQlowZENiV1ZDUkVGRlEwRlVRVTVDWjJ0eGFHdHBSemwzTUVKQlVYTkdRVUZQUTBGblJVRm9NbTVFT1ZkRU5YTnJlbFZNUVhodFNXUjBlRlphV2tZNEx6VjNkRFZwWmtsTlZVRlZVazVXZDFwalREbDFkVTkyY2s1VU56VndWbWg1TTFrMFpIRTVVSFJDUkhsSmJXZFVZMGxZY25Gd09FVk1iRkZJWWsxSFVqSnZia014ZVRWb1VtbHZVak5IUnpGS09IRkhRbVV6UWpGRVVYcHVNSEZ2TlVkcmNuZzBhV2xxTDJRMmRIbHZSM2htZW1SQmRuUlFVbEVyYXpaUVlWaGhPRXhYWkdocWNGTXZMMWRHWjA4MlRWaFBTMlUyY1ZScFkxWnRhalkwV0ZsM2FtOUVVVmxPZFZsSWRFTlhVRVp5VnpocGJVTmtNMUl4TlVnck0wdHNRMjVOTjBaMlVYbGtUbkl3TkV4UVZYUXZURmxOT0VkYVNFSktlVlZ4TVc5WWRrVTFVa3RYYTI5M01WQjBTSEIxYlRNNU9IVkhlVlo2Wml0MmRTc3dNV2t2YldSRVVYQnpZaTlKTDFCUlZqbENRVXBwYmpsRk1tTm1XVXhzUVhOT2JEbFdZVlZ2Vldsbk9YRjFiRk1yYW10dVpHaDBUMU5SWTFkMGR6WXlXVXgxUjI4dmVVazVZMFkwVlZrMGNUbHNWMmRPVHpkTU9VbFdWa2hSYnprMGIwTnlUREZuVWsxTFFVNTBSbXRoWTB4RVJVTjNRWFZHVTB0MmRXaGhOMFJoYmxrM2FGbzNXWEZHTmtoclRteEtlbFJCTmxrNVZWSk9jVGxOZUhGS2FFMWxWR1JyWldaNkszTXhRV1F2VVZrd1pUSk5TRWRuWWtVcmIwNWtOR0YzVkdSeVJYaFRNa0l5UlhBM2QyTlRhVEZ2UVRNMGNFbGhTbWRSZFZkMU9FWnliMk5EYzNwemNXTXJiMHBYVkhKM01sWlJaMlU1ZUdkVldsVk5Xa3hTVjJKR05Hb3pSa3RRYzFaV1oxWXJOMmM1TlZKT1JXcEhhRU14VFRoTVlYTTRkM2MxVkN0MVFsQk5USE5UVVdzeVFsSklZM2RtZVVSU01qQTVNa3BHYkdSSGRVRTRUVlZCY2tkT0wyNUlWRVJtVjJGWlRFbFFRMVZvZDBKb2NGbFBha3R1YVRSbFVFeHlZV1J4TjBGSE1sRnZSMVp6ZWxwM1owcGxjVXhZU2tKbUswazJibmw2Um1ReVl6VlBXRTFITmpWT1l6MGlMQ0pOU1VsR1dXcERRMEpGY1dkQmQwbENRV2RKVVdRM01FNWlUbk15SzFKeWNVbFJMMFU0Um1wVVJGUkJUa0puYTNGb2EybEhPWGN3UWtGUmMwWkJSRUpZVFZGemQwTlJXVVJXVVZGSFJYZEtRMUpVUlZwTlFtTkhRVEZWUlVOb1RWRlNNbmgyV1cxR2MxVXliRzVpYVVKMVpHa3hlbGxVUlZGTlFUUkhRVEZWUlVONFRVaFZiVGwyWkVOQ1JGRlVSV0pOUW10SFFURlZSVUY0VFZOU01uaDJXVzFHYzFVeWJHNWlhVUpUWWpJNU1FbEZUa0pOUWpSWVJGUkpkMDFFV1hoUFZFRjNUVVJCTUUxc2IxaEVWRWswVFVSRmVVOUVRWGROUkVFd1RXeHZkMUo2UlV4TlFXdEhRVEZWUlVKb1RVTldWazE0U1dwQlowSm5UbFpDUVc5VVIxVmtkbUl5WkhOYVUwSlZZMjVXZW1SRFFsUmFXRW95WVZkT2JHTjVRazFVUlUxNFJrUkJVMEpuVGxaQ1FVMVVRekJrVlZWNVFsTmlNamt3U1VaSmVFMUpTVU5KYWtGT1FtZHJjV2hyYVVjNWR6QkNRVkZGUmtGQlQwTkJaemhCVFVsSlEwTm5TME5CWjBWQmRHaEZRMmw0TjJwdldHVmlUemw1TDJ4RU5qTnNZV1JCVUV0SU9XZDJiRGxOWjJGRFkyWmlNbXBJTHpjMlRuVTRZV2syV0d3MlQwMVRMMnR5T1hKSU5YcHZVV1J6Wm01R2JEazNkblZtUzJvMlluZFRhVlkyYm5Gc1MzSXJRMDF1ZVRaVGVHNUhVR0l4Tld3ck9FRndaVFl5YVcwNVRWcGhVbmN4VGtWRVVHcFVja1ZVYnpobldXSkZkbk12UVcxUk16VXhhMHRUVldwQ05rY3dNR293ZFZsUFJGQXdaMjFJZFRneFNUaEZNME4zYm5GSmFYSjFObm94YTFveGNTdFFjMEZsZDI1cVNIaG5jMGhCTTNrMmJXSlhkMXBFY2xoWlptbFpZVkpSVFRselNHMXJiRU5wZEVRek9HMDFZV2RKTDNCaWIxQkhhVlZWS3paRVQyOW5ja1phV1VwemRVSTJha00xTVRGd2VuSndNVnByYWpWYVVHRkxORGxzT0V0RmFqaERPRkZOUVV4WVRETXlhRGROTVdKTGQxbFZTQ3RGTkVWNlRtdDBUV2MyVkU4NFZYQnRkazF5VlhCemVWVnhkRVZxTldOMVNFdGFVR1p0WjJoRFRqWktNME5wYjJvMlQwZGhTeTlIVURWQlptdzBMMWgwWTJRdmNESm9MM0p6TXpkRlQyVmFWbGgwVERCdE56bFpRakJsYzFkRGNuVlBRemRZUm5oWmNGWnhPVTl6Tm5CR1RFdGpkMXB3UkVsc1ZHbHllRnBWVkZGQmN6WnhlbXR0TURad09UaG5OMEpCWlN0a1JIRTJaSE52TkRrNWFWbElObFJMV0M4eFdUZEVlbXQyWjNSa2FYcHFhMWhRWkhORWRGRkRkamxWZHl0M2NEbFZOMFJpUjB0dloxQmxUV0V6VFdRcmNIWmxlamRYTXpWRmFVVjFZU3NyZEdkNUwwSkNha1pHUm5remJETlhSbkJQT1V0WFozbzNlbkJ0TjBGbFMwcDBPRlF4TVdSc1pVTm1aVmhyYTFWQlMwbEJaalZ4YjBsaVlYQnpXbGQzY0dKclRrWm9TR0Y0TW5oSlVFVkVaMlpuTVdGNlZsazRNRnBqUm5WamRFdzNWR3hNYmsxUkx6QnNWVlJpYVZOM01XNUlOamxOUnpaNlR6QmlPV1kyUWxGa1owRnRSREEyZVVzMU5tMUVZMWxDV2xWRFFYZEZRVUZoVDBOQlZHZDNaMmRGTUUxQk5FZEJNVlZrUkhkRlFpOTNVVVZCZDBsQ2FHcEJVRUpuVGxaSVVrMUNRV1k0UlVKVVFVUkJVVWd2VFVJd1IwRXhWV1JFWjFGWFFrSlVhM0o1YzIxalVtOXlVME5sUmt3eFNtMU1UeTkzYVZKT2VGQnFRV1pDWjA1V1NGTk5SVWRFUVZkblFsSm5aVEpaWVZKUk1saDViMnhSVERNd1JYcFVVMjh2TDNvNVUzcENaMEpuWjNKQ1owVkdRbEZqUWtGUlVsVk5Sa2wzU2xGWlNVdDNXVUpDVVZWSVRVRkhSMGRYYURCa1NFRTJUSGs1ZGxrelRuZE1ia0p5WVZNMWJtSXlPVzVNTW1SNlkycEZkMHRSV1VsTGQxbENRbEZWU0UxQlMwZElWMmd3WkVoQk5reDVPWGRoTW10MVdqSTVkbHA1T1c1ak0wbDRUREprZW1OcVJYVlpNMG93VFVSSlIwRXhWV1JJZDFGeVRVTnJkMG8yUVd4dlEwOUhTVmRvTUdSSVFUWk1lVGxxWTIxM2RXTkhkSEJNYldSMllqSmpkbG96VG5sTlV6bHVZek5KZUV4dFRubGlSRUUzUW1kT1ZraFRRVVZPUkVGNVRVRm5SMEp0WlVKRVFVVkRRVlJCU1VKbldtNW5VWGRDUVdkSmQwUlJXVXhMZDFsQ1FrRklWMlZSU1VaQmQwbDNSRkZaVEV0M1dVSkNRVWhYWlZGSlJrRjNUWGRFVVZsS1MyOWFTV2gyWTA1QlVVVk1RbEZCUkdkblJVSkJSRk5yU0hKRmIyODVRekJrYUdWdFRWaHZhRFprUmxOUWMycGlaRUphUW1sTVp6bE9Vak4wTlZBclZEUldlR1p4TjNaeFprMHZZalZCTTFKcE1XWjVTbTA1WW5ab1pFZGhTbEV6WWpKME5ubE5RVmxPTDI5c1ZXRjZjMkZNSzNsNVJXNDVWM0J5UzBGVFQzTm9TVUZ5UVc5NVdtd3JkRXBoYjNneE1UaG1aWE56YlZodU1XaEpWbmMwTVc5bFVXRXhkakYyWnpSR2RqYzBlbEJzTmk5QmFGTnlkemxWTlhCRFdrVjBORmRwTkhkVGRIbzJaRlJhTDBOTVFVNTRPRXhhYURGS04xRktWbW95Wm1oTmRHWlVTbkk1ZHpSNk16QmFNakE1Wms5Vk1HbFBUWGtyY1dSMVFtMXdkblpaZFZJM2FGcE1Oa1IxY0hONlptNTNNRk5yWm5Sb2N6RTRaRWM1V2t0aU5UbFZhSFp0WVZOSFdsSldZazVSY0hObk0wSmFiSFpwWkRCc1NVdFBNbVF4ZUc5NlkyeFBlbWRxV0ZCWmIzWktTa2wxYkhSNmEwMTFNelJ4VVdJNVUzb3ZlV2xzY21KRFoybzRQU0pkZlEuZXlKdWIyNWpaU0k2SWpNelpWUTJaRkV4ZFUxSWIyZHNSR2RrTlZGUFNEQnVRWEpEYTBGeVVETnhPR3h1YTNOWlRtUTRTRUU5SWl3aWRHbHRaWE4wWVcxd1RYTWlPakUzTXpJek5EYzBNall6TWpFc0ltRndhMUJoWTJ0aFoyVk9ZVzFsSWpvaVkyOXRMbWR2YjJkc1pTNWhibVJ5YjJsa0xtZHRjeUlzSW1Gd2EwUnBaMlZ6ZEZOb1lUSTFOaUk2SWxKcldVMHdUbUZTT0Vzdk9XVlBVMjFZT0RCRFdXSlZSRUpvZVZwMVFVSlZiV2R2ZEZGelZFczNWRlU5SWl3aVkzUnpVSEp2Wm1sc1pVMWhkR05vSWpwMGNuVmxMQ0poY0d0RFpYSjBhV1pwWTJGMFpVUnBaMlZ6ZEZOb1lUSTFOaUk2V3lJNFVERnpWekJGVUVwamMyeDNOMVY2VW5OcFdFdzJOSGNyVHpVd1JXUXJVa0pKUTNSaGVURm5NalJOUFNKZExDSmlZWE5wWTBsdWRHVm5jbWwwZVNJNmRISjFaU3dpWlhaaGJIVmhkR2x2YmxSNWNHVWlPaUpDUVZOSlF5eElRVkpFVjBGU1JWOUNRVU5MUlVRaUxDSmtaWEJ5WldOaGRHbHZia2x1Wm05eWJXRjBhVzl1SWpvaVZHaGxJR0Z3Y0NCcGN5QmhiR3h2ZDJ4cGMzUmxaQ0IwYnlCMWMyVWdkR2hsSUZOaFptVjBlVTVsZENCQmRIUmxjM1JoZEdsdmJpQkJVRWtnZFc1MGFXd2dkR2hsSUdaMWJHd2dkSFZ5Ym1SdmQyNDZJR2gwZEhCek9pOHZaeTVqYnk5d2JHRjVMM05oWm1WMGVXNWxkQzEwYVcxbGJHbHVaUzRpZlEuWVViMktyOFFTQWpKVEdRX3JHLXEwRC10MUFITG5Xd0hhSDc3ZWxuSEZhZ0VhRWNIUkhlSkRwZ1ZHXy1jeExXejZOTl85Y2l0UDZtWDhhSFRZSGJqSXRGWlpadTJUakljVFNXZHBTM0t6V1dhY3RtVkhNd0R4S0RhU2hlRDlSUVhwN3NqcGEwanIxbkE1SGtsdFlocDlwekREanJXb1ZMVEJveTY4TkFocHZPUXlqejhFV3RwUVVOem55enEwVGZEY3U4ckhaajMzRWtDU1hSVEtUcDVjREpVSThkTE5RdVIzTUNUcU9TdmdyaDQtbG51Wjk0ZFdLa0lOUzhPT1pkZGtFQVFNNHhoTm5fNGhpSmJaX1BaQXdCSDZxVVFXRHdxenpKMFFVWTYtQjJTS0NvUkZCeVlxN0hKU1hoUDZKSFBfVjMxcXQyZjZpc3RDX3lIekZfZl9BaGF1dGhEYXRhWMU0463jpzQcDvCgyzvBJ1xIylKNzp8LH3yUQ6dviJpjzkUAAAAAuT/ZYfLmRi+xIoIAIkfeeABBATYcUR+5gbGJ//0TzPlW6TDaZ6E0ce2sAQsHikelEst9MvNDajup5GzvTBnqoQ67oOxZKaZnmquIDUF/3ZVr2LSlAQIDJiABIVggzBwfH4Q2vRCn8PVVqjA0ZldSTae3yMQJLXjQsqzCQ30iWCAivjLdrdAUBZ1b2kgU+R5oQ6gpFqdKvXhXPOhNyzPCzw==', 'eyJ0eXBlIjoid2ViYXV0aG4uY3JlYXRlIiwiY2hhbGxlbmdlIjoiOGM0Y0tJQjhlOVN2dUc5cmlnRFFGaGd5cDFqclJzaFFPQTRpZTNvUF9ZcyIsIm9yaWdpbiI6Imh0dHBzOi8vaW1zLXBuYy5zaXRlIiwiY3Jvc3NPcmlnaW4iOmZhbHNlfQ==', '$2y$10$0mfJvZpGd9wS0Nn6RQHscOdhbkhw9fWIl2zese5lD8TrsqXLQTpwS', 'Bella ', 'Crisostomo', 'bella23@gmail.com', '0909949762', 'blk 14 lot 100, katapatan homes, banay banay, san isidro, cabuyao', 61619, '54743', 34957, 'Active', '2024-11-23 07:37:07', '', '', '0000-00-00 00:00:00'),
(219, '7777777', NULL, NULL, NULL, '$2y$10$AiqPxrOjTVALbh16.XdKJ.sdPuewJxPWzuw0CLLE6obpB0CEaS3Wm', 'Darwin', 'Turingan', 'darwin@gmail.com', '09099497796', 'blk 23 lot 11, katapatan homes , san isidro, cabuyao, laguna', 72936, '19463', 79581, 'Active', '2024-11-23 08:06:22', '', '', '0000-00-00 00:00:00'),
(220, '5789450', NULL, NULL, NULL, '$2y$10$1LEtH9Q/lPpuAmM8ZXFRGuQzIE9L5HbTLQZpoUmBNRYC0cjhQ69Qi', 'Test', 'Test', 'test@gmail.com', '2123132123', '8, Test, Test, Test', 17829, '88152', 70525, 'Active', '2024-12-01 07:28:57', '', '', '0000-00-00 00:00:00'),
(222, '2100870', 'AcWnQbWwYRGYL1g5M2H3WctbzLbUCvP0CBxAkWhHBzJUaSS5WGoJzpanFL9m9KJezzaGG6JZBYYtoWG4HgoZn/U=', 'o2NmbXRxYW5kcm9pZC1zYWZldHluZXRnYXR0U3RtdKJjdmVyaTI0NDUzNDAyOWhyZXNwb25zZVkgAGV5SmhiR2NpT2lKU1V6STFOaUlzSW5nMVl5STZXeUpOU1VsR1RVUkRRMEpDYVdkQmQwbENRV2RKVWtGTlN5dDRVSEpKVkhadVVVTlllVXhaYlhWVlUxbFJkMFJSV1VwTGIxcEphSFpqVGtGUlJVeENVVUYzVDNwRlRFMUJhMGRCTVZWRlFtaE5RMVpXVFhoSWFrRmpRbWRPVmtKQmIxUkdWV1IyWWpKa2MxcFRRbFZqYmxaNlpFTkNWRnBZU2pKaFYwNXNZM3BGVFUxQmIwZEJNVlZGUVhoTlJGWXhTVEJOUWpSWVJGUkpNRTFVUlhkT2FrVXhUV3BuTVU0eGIxaEVWRWt4VFVSSmQwNUVSVEZOYW1jeFRteHZkMGhVUldKTlFtdEhRVEZWUlVGNFRWTlpXRkl3V2xoT01FeHRSblZhU0VwMllWZFJkVmt5T1hSTlNVbENTV3BCVGtKbmEzRm9hMmxIT1hjd1FrRlJSVVpCUVU5RFFWRTRRVTFKU1VKRFowdERRVkZGUVhCUVdITlhNbGRNU1c5aVlrRTBUbTF4VTFSNWVqaFRkWGxXWW01ak0wcDZRV0phTjJ0R04zRkxUa0ZzV2tOSlVYSnphUzlYWWxOWEswVTNVMnB3YkROVFlWVlNkU3RFTW1GM05GUlFSelZLZVZSa2IyWkhZamxLT1dzMlUzZFZORE4wVFZwQk1FOHJNRGxaUzJjNFRITlFUMFlyTm5RNFQycExka05xYzNWeUx5OXBTVFZDY0hwRU9XSlhhREo2TkZNMU1USlRSVGcyWnpkcFZubHRhMDQwVDB4UVF6RlZaR2t6VUhadWNVSkROVGx3YVZSUlZDdE5VekV3V0RGTmRUa3lZbmhUU2twWFJrNXRNREpZV21WcWJFUkpaazA0WkdRNGJuZzBZVnBGV1c5TU1ITlZNMnhKWkRjMWIyc3dNbVZQU0c4NE5uRlpVamxWTm1JeGJYbDFSRGxTVlZKMGRqTkNVbmx5ZVVFeFJFWnRja2RyYWtwT1ZWRmhVR1ZyYlV0cFYzcEVTa2xsZVV0S1psaHJVR3hQU0VVMldERkVXWGd4VlRoSVV5OUVTRUZYZFV0RmMzQm5XSGd2YVdoUGVHSmFPVFp0ZDBsRVFWRkJRbTgwU1VOVGVrTkRRV3RqZDBSbldVUldVakJRUVZGSUwwSkJVVVJCWjFkblRVSk5SMEV4VldSS1VWRk5UVUZ2UjBORGMwZEJVVlZHUW5kTlFrMUJkMGRCTVZWa1JYZEZRaTkzVVVOTlFVRjNTRkZaUkZaU01FOUNRbGxGUms5dlFuSk1RaTgzVkhKMWIwdDNWMkl2VGpkQlJ6SkJkbUZSUmsxQ09FZEJNVlZrU1hkUldVMUNZVUZHU25aSlJXSjNPWEZxWVRWTldYaFBhakJVVmxaNlNYWjNPRUpvVFVZMFIwTkRjMGRCVVZWR1FuZEZRa0pHU1hkVlJFRnVRbWRuY2tKblJVWkNVV04zUVZsWlltRklVakJqUkc5MlRESTRkV05IZEhCTWJXUjJZakpqZG1ONU9UTmphbEYyWkROSk1FMURWVWREUTNOSFFWRlZSa0o2UVVOb2FHeHZaRWhTZDA5cE9IWmhVelYzWVRKcmRWb3lPWFphZVRrelkycFJkVmt6U2pCTlFqQkhRVEZWWkVWUlVWZE5RbE5EUlcxR01HUkhWbnBrUXpWb1ltMVNlV0l5Ykd0TWJVNTJZbFJCVkVKblRsWklVMEZGUkVSQlMwMUJaMGRDYldWQ1JFRkZRMEZVUVRKQ1owNVdTRkk0UlV4NlFYUk5RM1ZuUzJGQmJtaHBWbTlrU0ZKM1QyazRkbGw1TlhkaE1tdDFXakk1ZGxwNU9UTmphbEYyVW1reFdGSnJjekZpYkVZeFkydFZkVmt6U25OTlNVbENRa0ZaUzB0M1dVSkNRVWhYWlZGSlJVRm5VMEk1VVZOQ09HZEVkMEZJV1VGVWJsZHFTakY1WVVWTlRUUlhNbnBWTTNvNVV6WjRNM2MwU1RSaWFsZHVRWE5tY0d0elYwdGhUMlE0UVVGQlIxUkJhemRwU1dkQlFVSkJUVUZTZWtKR1FXbENNa1l3TW1WRVdUZ3pjVzloYmpKTFZWVjFVV2MwVWpoaFJYRnBRVzVGZWxwVVlYQnpNaXNyVWxwRFFVbG9RVTFQZVdGaldtbzNLMk5DYW5OQk5VSjVXVVEwVFhJdlYxSk5UbEkyUzJaaFNVUmlUVUo2VVd0aE9VeEJTRmxCZWxCelVHRnZWbmhEVjFncmJGcDBWSHAxYlhsbVEweHdhRlozVG13ME1qSnhXRFZWZDFBMVRVUmlRVUZCUVVkVVFXczNhVmRSUVVGQ1FVMUJVbnBDUmtGcFFqZEljemQ0YzA5eWRWbEpVRlZSZEVGUGNIUXdLM29yT1VKWlFtTkRVVk4yV1ZaUmJsaDBhblF2V0dkSmFFRlFiMkV3TVVKRGRVNWtlVm96YXpsUVlqUmpSeTl3ZEV0SVJsSnVkSEUwWkM4eVVuaHllbkpGYUVseFRVRXdSME5UY1VkVFNXSXpSRkZGUWtOM1ZVRkJORWxDUVZGQmNIRXlaVGhJTmtkdlptTjZaRWRFU0daYWREVnZTbHBMZWtOa1ZFaERjMGhYTTFOU1dIRkdjVEpTT0VONFpGbFZNVEJsVXpOV05XYzFielpwTUdsQlVISkRabXRzWm5aaFExUnFSWFZpVFdJM1ptcFpMMlpuTkdVMGNFNXRPWGx0VlhNNVZVb3ljMkoxZHpKbE1XaERUWEprV1dJM01IbGhMMjlhY0RCdU5XcHdhMHhJWnpScmRpdFJja1J0UVM5T1kxcE5kRTk0TkdjMGNGZE1UbGxqY0hGcU1UVnhhRVF2Ym5KWlkxUjZOVnBPVGtONE16TkVNRXhXUjB3eGJGTlNjWGRUVkhGVmVrVktVM1ZyT1djdlZVMUhObGxXU1V0dlluSlVjWEJDYTFwSGRGRlRLMEZzYjJNNFlYSjBibWxVZVZSV2JYQTRXVlZZVWxCMlprbG5XRGREZVZsSk5EVmpkakU1V0dneWJ6RTBibEZ6UTNwWmFVNW5NR2xCY0RaTWRVTnhVVTEzUm1NNGFrTlRiVGNyUmxSdFJVdEViRVFyWTA1ME5FaDRZVEJXZVRSVk0yVlVLMUpEWmpCVVlucE1hbVZQZFRVaUxDSk5TVWxHUTNwRFEwRjJUMmRCZDBsQ1FXZEpVV1l2UVVaMFRuQXhkVWR3WVhob0wydE5TR05VZWxSQlRrSm5hM0ZvYTJsSE9YY3dRa0ZSYzBaQlJFSklUVkZ6ZDBOUldVUldVVkZIUlhkS1ZsVjZSV2xOUTBGSFFURlZSVU5vVFZwU01qbDJXako0YkVsR1VubGtXRTR3U1VaT2JHTnVXbkJaTWxaNlNVVjRUVkY2UlZWTlFrbEhRVEZWUlVGNFRVeFNNVkpVU1VaS2RtSXpVV2RWYWtWM1NHaGpUazFxVFhoTmFrVjZUVVJyZDAxRVFYZFhhR05PVFdwcmQwMXFTWGROVkZGM1RVUkJkMWRxUVRkTlVYTjNRMUZaUkZaUlVVZEZkMHBXVlhwRlpVMUNkMGRCTVZWRlEyaE5WbEl5T1haYU1uaHNTVVpTZVdSWVRqQkpSazVzWTI1YWNGa3lWbnBOVVhkM1EyZFpSRlpSVVVSRmQwNVlWV3BSZDJkblJXbE5RVEJIUTFOeFIxTkpZak5FVVVWQ1FWRlZRVUUwU1VKRWQwRjNaMmRGUzBGdlNVSkJVVU4yVkd4SEwzcHNRMnMyTkRRNWEyRlhMMFJEYjJseGIzQXdjRWwzZVdGT09FdFJSMkp6VmpJd2MzSXdZalF5T1VweVVrMVJURXBVTHpkelNWSk1jMWhrY2xaalFUVTNOelZXT1ZoUkwwWnNWbEJWYzNsR1VXRlhTRVY0WjJGUllXWXlVRnA0VGxacldXWlVPVk5VTlRkaE9WVmlWaXRPVkd4a1kyNXRlSFp2YjB4dGNHaDNMMVJHZG14dWNIRXljazB4Tlhsc1NHbHhPR3hIY1dkUmNGSTVMelpCVEhWdmJHMVhSRlpQVUVaRlowRnNWR1E1VVc5RlZ6bG5URTExUnpOc1R6TXhiSFJ6Wlc1YVYxUXhiRU5SVXpKU1VsWlRlRmhxTjJOU016SnNXR2RUUlhOck1WcDZOVGRsVW14blEyWjVaa0YyVlVwVmRFMTBPVGd5YzI5T1VqSmtlazlXVDB0cU9YcHNhV1ZHY21Ka1prSmFhSGhhU0ZGdU4wbEtkVWRqWTJScFNtNUxWRlJsWWtKcWVFMW9WV05WU0dzMk1ubHNUemRuWlV4MFlqTktUVlZpWW01MlUxbEVNbFZCWTJ4bmVuSjNiRUZuVFVKQlFVZHFaMlkwZDJkbWMzZEVaMWxFVmxJd1VFRlJTQzlDUVZGRVFXZEhSMDFDTUVkQk1WVmtTbEZSVjAxQ1VVZERRM05IUVZGVlJrSjNUVUpDWjJkeVFtZEZSa0pSWTBSQmFrRlRRbWRPVmtoU1RVSkJaamhGUTBSQlIwRlJTQzlCWjBWQlRVSXdSMEV4VldSRVoxRlhRa0pUWW5sQ1J6aFFZVzh5ZFZSSFRWUnZPVVV4Vm1ONVREaFFRVmxVUVdaQ1owNVdTRk5OUlVkRVFWZG5RbFJyY25semJXTlNiM0pUUTJWR1RERktiVXhQTDNkcFVrNTRVR3BCTUVKblozSkNaMFZHUWxGalFrRlJVVzlOUTFsM1NrRlpTVXQzV1VKQ1VWVklUVUZMUjBkSGFEQmtTRUUyVEhrNWNFeHVRbkpoVXpWdVlqSTVia3d6U1hoTWJVNTVaRVJCY2tKblRsWklVamhGU2tSQmFVMURRMmRJY1VGamFHaHdiMlJJVW5kUGFUaDJXWGsxZDJFeWEzVmFNamwyV25rNWVVd3pTWGhNYlU1NVlrUkJWRUpuVGxaSVUwRkZSRVJCUzAxQlowZENiV1ZDUkVGRlEwRlVRVTVDWjJ0eGFHdHBSemwzTUVKQlVYTkdRVUZQUTBGblJVRm9NbTVFT1ZkRU5YTnJlbFZNUVhodFNXUjBlRlphV2tZNEx6VjNkRFZwWmtsTlZVRlZVazVXZDFwalREbDFkVTkyY2s1VU56VndWbWg1TTFrMFpIRTVVSFJDUkhsSmJXZFVZMGxZY25Gd09FVk1iRkZJWWsxSFVqSnZia014ZVRWb1VtbHZVak5IUnpGS09IRkhRbVV6UWpGRVVYcHVNSEZ2TlVkcmNuZzBhV2xxTDJRMmRIbHZSM2htZW1SQmRuUlFVbEVyYXpaUVlWaGhPRXhYWkdocWNGTXZMMWRHWjA4MlRWaFBTMlUyY1ZScFkxWnRhalkwV0ZsM2FtOUVVVmxPZFZsSWRFTlhVRVp5VnpocGJVTmtNMUl4TlVnck0wdHNRMjVOTjBaMlVYbGtUbkl3TkV4UVZYUXZURmxOT0VkYVNFSktlVlZ4TVc5WWRrVTFVa3RYYTI5M01WQjBTSEIxYlRNNU9IVkhlVlo2Wml0MmRTc3dNV2t2YldSRVVYQnpZaTlKTDFCUlZqbENRVXBwYmpsRk1tTm1XVXhzUVhOT2JEbFdZVlZ2Vldsbk9YRjFiRk1yYW10dVpHaDBUMU5SWTFkMGR6WXlXVXgxUjI4dmVVazVZMFkwVlZrMGNUbHNWMmRPVHpkTU9VbFdWa2hSYnprMGIwTnlUREZuVWsxTFFVNTBSbXRoWTB4RVJVTjNRWFZHVTB0MmRXaGhOMFJoYmxrM2FGbzNXWEZHTmtoclRteEtlbFJCTmxrNVZWSk9jVGxOZUhGS2FFMWxWR1JyWldaNkszTXhRV1F2VVZrd1pUSk5TRWRuWWtVcmIwNWtOR0YzVkdSeVJYaFRNa0l5UlhBM2QyTlRhVEZ2UVRNMGNFbGhTbWRSZFZkMU9FWnliMk5EYzNwemNXTXJiMHBYVkhKM01sWlJaMlU1ZUdkVldsVk5Xa3hTVjJKR05Hb3pSa3RRYzFaV1oxWXJOMmM1TlZKT1JXcEhhRU14VFRoTVlYTTRkM2MxVkN0MVFsQk5USE5UVVdzeVFsSklZM2RtZVVSU01qQTVNa3BHYkdSSGRVRTRUVlZCY2tkT0wyNUlWRVJtVjJGWlRFbFFRMVZvZDBKb2NGbFBha3R1YVRSbFVFeHlZV1J4TjBGSE1sRnZSMVp6ZWxwM1owcGxjVXhZU2tKbUswazJibmw2Um1ReVl6VlBXRTFITmpWT1l6MGlMQ0pOU1VsR1dXcERRMEpGY1dkQmQwbENRV2RKVVdRM01FNWlUbk15SzFKeWNVbFJMMFU0Um1wVVJGUkJUa0puYTNGb2EybEhPWGN3UWtGUmMwWkJSRUpZVFZGemQwTlJXVVJXVVZGSFJYZEtRMUpVUlZwTlFtTkhRVEZWUlVOb1RWRlNNbmgyV1cxR2MxVXliRzVpYVVKMVpHa3hlbGxVUlZGTlFUUkhRVEZWUlVONFRVaFZiVGwyWkVOQ1JGRlVSV0pOUW10SFFURlZSVUY0VFZOU01uaDJXVzFHYzFVeWJHNWlhVUpUWWpJNU1FbEZUa0pOUWpSWVJGUkpkMDFFV1hoUFZFRjNUVVJCTUUxc2IxaEVWRWswVFVSRmVVOUVRWGROUkVFd1RXeHZkMUo2UlV4TlFXdEhRVEZWUlVKb1RVTldWazE0U1dwQlowSm5UbFpDUVc5VVIxVmtkbUl5WkhOYVUwSlZZMjVXZW1SRFFsUmFXRW95WVZkT2JHTjVRazFVUlUxNFJrUkJVMEpuVGxaQ1FVMVVRekJrVlZWNVFsTmlNamt3U1VaSmVFMUpTVU5KYWtGT1FtZHJjV2hyYVVjNWR6QkNRVkZGUmtGQlQwTkJaemhCVFVsSlEwTm5TME5CWjBWQmRHaEZRMmw0TjJwdldHVmlUemw1TDJ4RU5qTnNZV1JCVUV0SU9XZDJiRGxOWjJGRFkyWmlNbXBJTHpjMlRuVTRZV2syV0d3MlQwMVRMMnR5T1hKSU5YcHZVV1J6Wm01R2JEazNkblZtUzJvMlluZFRhVlkyYm5Gc1MzSXJRMDF1ZVRaVGVHNUhVR0l4Tld3ck9FRndaVFl5YVcwNVRWcGhVbmN4VGtWRVVHcFVja1ZVYnpobldXSkZkbk12UVcxUk16VXhhMHRUVldwQ05rY3dNR293ZFZsUFJGQXdaMjFJZFRneFNUaEZNME4zYm5GSmFYSjFObm94YTFveGNTdFFjMEZsZDI1cVNIaG5jMGhCTTNrMmJXSlhkMXBFY2xoWlptbFpZVkpSVFRselNHMXJiRU5wZEVRek9HMDFZV2RKTDNCaWIxQkhhVlZWS3paRVQyOW5ja1phV1VwemRVSTJha00xTVRGd2VuSndNVnByYWpWYVVHRkxORGxzT0V0RmFqaERPRkZOUVV4WVRETXlhRGROTVdKTGQxbFZTQ3RGTkVWNlRtdDBUV2MyVkU4NFZYQnRkazF5VlhCemVWVnhkRVZxTldOMVNFdGFVR1p0WjJoRFRqWktNME5wYjJvMlQwZGhTeTlIVURWQlptdzBMMWgwWTJRdmNESm9MM0p6TXpkRlQyVmFWbGgwVERCdE56bFpRakJsYzFkRGNuVlBRemRZUm5oWmNGWnhPVTl6Tm5CR1RFdGpkMXB3UkVsc1ZHbHllRnBWVkZGQmN6WnhlbXR0TURad09UaG5OMEpCWlN0a1JIRTJaSE52TkRrNWFWbElObFJMV0M4eFdUZEVlbXQyWjNSa2FYcHFhMWhRWkhORWRGRkRkamxWZHl0M2NEbFZOMFJpUjB0dloxQmxUV0V6VFdRcmNIWmxlamRYTXpWRmFVVjFZU3NyZEdkNUwwSkNha1pHUm5remJETlhSbkJQT1V0WFozbzNlbkJ0TjBGbFMwcDBPRlF4TVdSc1pVTm1aVmhyYTFWQlMwbEJaalZ4YjBsaVlYQnpXbGQzY0dKclRrWm9TR0Y0TW5oSlVFVkVaMlpuTVdGNlZsazRNRnBqUm5WamRFdzNWR3hNYmsxUkx6QnNWVlJpYVZOM01XNUlOamxOUnpaNlR6QmlPV1kyUWxGa1owRnRSREEyZVVzMU5tMUVZMWxDV2xWRFFYZEZRVUZoVDBOQlZHZDNaMmRGTUUxQk5FZEJNVlZrUkhkRlFpOTNVVVZCZDBsQ2FHcEJVRUpuVGxaSVVrMUNRV1k0UlVKVVFVUkJVVWd2VFVJd1IwRXhWV1JFWjFGWFFrSlVhM0o1YzIxalVtOXlVME5sUmt3eFNtMU1UeTkzYVZKT2VGQnFRV1pDWjA1V1NGTk5SVWRFUVZkblFsSm5aVEpaWVZKUk1saDViMnhSVERNd1JYcFVVMjh2TDNvNVUzcENaMEpuWjNKQ1owVkdRbEZqUWtGUlVsVk5Sa2wzU2xGWlNVdDNXVUpDVVZWSVRVRkhSMGRYYURCa1NFRTJUSGs1ZGxrelRuZE1ia0p5WVZNMWJtSXlPVzVNTW1SNlkycEZkMHRSV1VsTGQxbENRbEZWU0UxQlMwZElWMmd3WkVoQk5reDVPWGRoTW10MVdqSTVkbHA1T1c1ak0wbDRUREprZW1OcVJYVlpNMG93VFVSSlIwRXhWV1JJZDFGeVRVTnJkMG8yUVd4dlEwOUhTVmRvTUdSSVFUWk1lVGxxWTIxM2RXTkhkSEJNYldSMllqSmpkbG96VG5sTlV6bHVZek5KZUV4dFRubGlSRUUzUW1kT1ZraFRRVVZPUkVGNVRVRm5SMEp0WlVKRVFVVkRRVlJCU1VKbldtNW5VWGRDUVdkSmQwUlJXVXhMZDFsQ1FrRklWMlZSU1VaQmQwbDNSRkZaVEV0M1dVSkNRVWhYWlZGSlJrRjNUWGRFVVZsS1MyOWFTV2gyWTA1QlVVVk1RbEZCUkdkblJVSkJSRk5yU0hKRmIyODVRekJrYUdWdFRWaHZhRFprUmxOUWMycGlaRUphUW1sTVp6bE9Vak4wTlZBclZEUldlR1p4TjNaeFprMHZZalZCTTFKcE1XWjVTbTA1WW5ab1pFZGhTbEV6WWpKME5ubE5RVmxPTDI5c1ZXRjZjMkZNSzNsNVJXNDVWM0J5UzBGVFQzTm9TVUZ5UVc5NVdtd3JkRXBoYjNneE1UaG1aWE56YlZodU1XaEpWbmMwTVc5bFVXRXhkakYyWnpSR2RqYzBlbEJzTmk5QmFGTnlkemxWTlhCRFdrVjBORmRwTkhkVGRIbzJaRlJhTDBOTVFVNTRPRXhhYURGS04xRktWbW95Wm1oTmRHWlVTbkk1ZHpSNk16QmFNakE1Wms5Vk1HbFBUWGtyY1dSMVFtMXdkblpaZFZJM2FGcE1Oa1IxY0hONlptNTNNRk5yWm5Sb2N6RTRaRWM1V2t0aU5UbFZhSFp0WVZOSFdsSldZazVSY0hObk0wSmFiSFpwWkRCc1NVdFBNbVF4ZUc5NlkyeFBlbWRxV0ZCWmIzWktTa2wxYkhSNmEwMTFNelJ4VVdJNVUzb3ZlV2xzY21KRFoybzRQU0pkZlEuZXlKdWIyNWpaU0k2SW1GR1RsTkxXSGxLVEdwamExbDZOM2RHV0c0eVpqRnlTbHA1Ym5CaldHMTRSMFZRYWxKS1JHOUhiVUU5SWl3aWRHbHRaWE4wWVcxd1RYTWlPakUzTXpNeE16azRPREEyTmpZc0ltRndhMUJoWTJ0aFoyVk9ZVzFsSWpvaVkyOXRMbWR2YjJkc1pTNWhibVJ5YjJsa0xtZHRjeUlzSW1Gd2EwUnBaMlZ6ZEZOb1lUSTFOaUk2SWxaclNHWm1WWEZCTnpZeFNGRlRlRU51VmpkTVNYQkhia3cwYTNKQlNucGxTMlIxWWtsbmRIa3JNMk05SWl3aVkzUnpVSEp2Wm1sc1pVMWhkR05vSWpwMGNuVmxMQ0poY0d0RFpYSjBhV1pwWTJGMFpVUnBaMlZ6ZEZOb1lUSTFOaUk2V3lJNFVERnpWekJGVUVwamMyeDNOMVY2VW5OcFdFdzJOSGNyVHpVd1JXUXJVa0pKUTNSaGVURm5NalJOUFNKZExDSmlZWE5wWTBsdWRHVm5jbWwwZVNJNmRISjFaU3dpWlhaaGJIVmhkR2x2YmxSNWNHVWlPaUpDUVZOSlF5eElRVkpFVjBGU1JWOUNRVU5MUlVRaUxDSmtaWEJ5WldOaGRHbHZia2x1Wm05eWJXRjBhVzl1SWpvaVZHaGxJR0Z3Y0NCcGN5QmhiR3h2ZDJ4cGMzUmxaQ0IwYnlCMWMyVWdkR2hsSUZOaFptVjBlVTVsZENCQmRIUmxjM1JoZEdsdmJpQkJVRWtnZFc1MGFXd2dkR2hsSUdaMWJHd2dkSFZ5Ym1SdmQyNDZJR2gwZEhCek9pOHZaeTVqYnk5d2JHRjVMM05oWm1WMGVXNWxkQzEwYVcxbGJHbHVaUzRpZlEuSjhpRXdCM3dJbmN3TEtaNGlTLTNUR2lXbjBJLWlmdTNGS3FZcFM3clRtRl9OMzJCTVNWTTgxSk9lejRRNWVQekRIS01HVDU3eUJOS1lfZUlUVkpodlBIa0c4N2puelJFa1U2dHhqMjJhZ2tEOUJnR2FWTkhIa2hzTUpVNmpJekxjRWl4N2lVSzhCdFBaQlBNaWF5QWpWLTczTmtjSlVwNGpqU2ZTdVR6cGxQWmhPeTdMMVREUUlyTzA0UVQtN3pfTFd6RVVVSl9nTUNWNlJvdFoyTy1RVnA0NEQtTlM4Zk1QeVRua0Ztbk9hUFFTZklWRXExOGVHMjZPcDN3N05iUmtsMkJlNS1JZnp4UTRuc3Ntc21uOUROZWhhNnVFcXZUekdwN2k4TjdRenViQU5KQk42TUxWalF3MllTT2ZSVXBsMEl6ZDlVdWxZTDEyd085ZWZCZmNnaGF1dGhEYXRhWMU0463jpzQcDvCgyzvBJ1xIylKNzp8LH3yUQ6dviJpjzkUAAAAAuT/ZYfLmRi+xIoIAIkfeeABBAcWnQbWwYRGYL1g5M2H3WctbzLbUCvP0CBxAkWhHBzJUaSS5WGoJzpanFL9m9KJezzaGG6JZBYYtoWG4HgoZn/WlAQIDJiABIVggVdy4vZQk4v5C8ZuwO1FFYXsAT4fYjQt+j+IKpQJuCXEiWCB4BjnA2WbiTUEsqivGVLkj185dapKvpD0YBhl5HcX+RQ==', 'eyJ0eXBlIjoid2ViYXV0aG4uY3JlYXRlIiwiY2hhbGxlbmdlIjoiUGt1aElkVjZjZmR5WWx4Q05qeV9PRzBwd1FsWUNjamZqUTBud3dMcm9IdyIsIm9yaWdpbiI6Imh0dHBzOi8vaW1zLXBuYy5zaXRlIiwiY3Jvc3NPcmlnaW4iOmZhbHNlfQ==', '$2y$10$8qyfqEJTW9A7.2lY8SzOQeiu4597ZISFRbdsA.B2W6HlDF9D.RQku', 'Reymar', 'Dugan', 'reymardugan@gmail.com', '09748295091', 'blk 112 lot 41, southville, marinig, cabuyao, city', 20382, '19669', 79581, 'Active', '2024-12-02 11:44:41', '', '', '0000-00-00 00:00:00'),
(223, '12345678', NULL, NULL, NULL, '$2y$10$EZ6v/c4kb.1pUmXlb2VlXeWN.R/E2v/60q4Knd0X5I793ZECAgHHW', 'Joseph', 'Quirino', 'joseph@gmail.com', '09099497792', 'block 123 lot 234, Mahogany Phase 1, Brgy. Pulo, Cabuyao city, Laguna', 20382, '40314', 79581, 'Active', '2024-12-07 07:35:18', '', '', '0000-00-00 00:00:00'),
(224, '1234511', NULL, NULL, NULL, '$2y$10$v/FBJdZsCIuolG/zujYiTOYGs4ajF47TI7wVA.LKL1CTaO.I9eVUa', 'ghjgh', 'sdfsdf', 'asdas@gmail.com', '09084934', 'asds, asdasd, aqweqwe, asdasd, asdasdsa', 72936, '44577', 79581, 'Active', '2024-12-14 04:55:47', '', '', '0000-00-00 00:00:00'),
(225, '12354631234141', NULL, NULL, NULL, '$2y$10$xM7Sh2LiS3YxL6nuYFoqYOzpqaloX6xIQ6uGZTvFNSrREEKUZsCRa', 'asdas', 'asdasdas', 'asdas@gmail.com', '12312', '123123, asdasd, asdsad, asdad, asdasdsa', 20382, '83596', 79581, 'Active', '2024-12-16 15:12:50', '', '', '0000-00-00 00:00:00'),
(226, '542341334', NULL, NULL, NULL, '$2y$10$EP4lECMSj2dxxBupcp7ZVuXBIuxLh5ivkDF55FFF.JfmChL2SC6gC', 'qweqwe', 'wqeqweqw', 'wqeq@gmail.com', '4356346341', 'qwe, qweqwe, asdasd, asdasd, qweqweqw', 72936, '95640', 79581, 'Active', '2024-12-16 15:21:36', '', '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_actionlogs`
--
ALTER TABLE `tbl_actionlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adjustments`
--
ALTER TABLE `tbl_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coordinators`
--
ALTER TABLE `tbl_coordinators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_programs`
--
ALTER TABLE `tbl_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reference`
--
ALTER TABLE `tbl_reference`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_requirements`
--
ALTER TABLE `tbl_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_timelogs`
--
ALTER TABLE `tbl_timelogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_actionlogs`
--
ALTER TABLE `tbl_actionlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=617;

--
-- AUTO_INCREMENT for table `tbl_adjustments`
--
ALTER TABLE `tbl_adjustments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `tbl_coordinators`
--
ALTER TABLE `tbl_coordinators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_programs`
--
ALTER TABLE `tbl_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_request`
--
ALTER TABLE `tbl_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_requirements`
--
ALTER TABLE `tbl_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_timelogs`
--
ALTER TABLE `tbl_timelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
