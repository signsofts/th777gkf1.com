-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 27, 2025 at 11:55 PM
-- Server version: 10.6.17-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signsoft_cw777th`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_admin`
--

CREATE TABLE `accounts_admin` (
  `ac_id` bigint(255) UNSIGNED NOT NULL,
  `ac_code` varchar(255) NOT NULL,
  `ac_email` varchar(255) NOT NULL,
  `ac_password` text NOT NULL,
  `ac_fname` varchar(100) NOT NULL,
  `ac_lname` varchar(100) NOT NULL,
  `ac_niname` varchar(100) NOT NULL,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ac_delete` tinyint(1) NOT NULL DEFAULT 0,
  `RoleID` int(11) NOT NULL COMMENT 'เก็บข้อมูลบทบาทของพนักงาน',
  `ac_referral` varchar(50) DEFAULT NULL COMMENT 'รหัสแนะนำ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_admin`
--

INSERT INTO `accounts_admin` (`ac_id`, `ac_code`, `ac_email`, `ac_password`, `ac_fname`, `ac_lname`, `ac_niname`, `datetime`, `created_at`, `updated_at`, `deleted_at`, `ac_delete`, `RoleID`, `ac_referral`) VALUES
(1, 'bmU-85368698', 'system@system.com', '$2y$10$ma0fgCcmUmN4sC0mw.yvVOAxU100bJlnsxyoenmsmniNHmbgh8j.C', 'system', 'system', 'system', NULL, '2024-06-18 20:21:27', '2024-07-02 15:06:43', NULL, 0, 4, NULL),
(2, 'bmU-85368699', 'sadmin@gmail.com', '$2y$10$4IWS/MKlpdiVP6rt01NNLuS6W6V/6YetpKxZTO3/Uj70iVDXus0Mm', 'Super Admin', 'Super Admin', 'Super Admin', NULL, '2024-06-03 07:08:37', '2025-02-26 04:39:51', NULL, 0, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banklists`
--

CREATE TABLE `banklists` (
  `blit_id` bigint(20) NOT NULL,
  `ac_code` varchar(255) NOT NULL COMMENT 'รหัสแอดมิน',
  `bank_id` bigint(20) NOT NULL COMMENT 'รหัสชื่อธนาคาร',
  `blit_number` varchar(50) NOT NULL COMMENT 'เลขบัญชี',
  `blit_name` varchar(100) NOT NULL COMMENT 'ชื่อบัญชี',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `blit_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 delete',
  `blit_image` varchar(100) DEFAULT NULL,
  `blit_remain` decimal(65,2) NOT NULL DEFAULT 0.00,
  `blit_delete_ad_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รายการบัญชี';

--
-- Dumping data for table `banklists`
--

INSERT INTO `banklists` (`blit_id`, `ac_code`, `bank_id`, `blit_number`, `blit_name`, `created_at`, `updated_at`, `blit_delete`, `blit_image`, `blit_remain`, `blit_delete_ad_code`) VALUES
(1, 'bmU-85368698', 25, '9999999999', 'System Bank', '2024-07-13 16:30:33', '2024-07-13 16:31:59', 0, NULL, '0.00', ''),
(2, 'bmU-85368699', 1, '123456789', 'TTTT', '2025-02-26 04:41:15', '2025-02-26 17:54:36', 0, '20250226/1740544875_7a5fdf2af22ca791c937.jpg', '3620000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` bigint(20) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bank_delete` tinyint(1) DEFAULT 0,
  `bank_nameEN` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รายชื่อธนาคารทั้งหมด';

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`, `bank_icon`, `created_at`, `update_at`, `bank_delete`, `bank_nameEN`) VALUES
(1, 'ธนาคารแห่งประเทศไทย', 'Seal_of_the_Bank_of_Thailand', '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'Bank of Thailand'),
(2, 'ธนาคารกรุงเทพ', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'BANGKOK BANK PUBLIC COMPANY LIMITED'),
(3, 'ธนาคารกสิกรไทย', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'KASIKORNBANK PUBLIC COMPANY LIMITED'),
(4, 'ธนาคารกรุงไทย', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'Krung Thai Bank Public Company Limited'),
(5, 'ธนาคารทหารไทยธนชาต', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'TMBThanachart Bank Public Company Limited'),
(6, 'ธนาคารไทยพาณิชย์', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'Siam Commercial Bank PCL.'),
(7, 'ธนาคารกรุงศรีอยุธยา', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'BANK OF AYUDHYA PUBLIC COMPANY LIMITED'),
(8, 'ธนาคารเกียรตินาคินภัทร', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'KIATNAKIN PHATRA BANK PUBLIC COMPANY LIMITED'),
(9, 'ธนาคารซีไอเอ็มบีไทย', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'CIMB THAI BANK PUBLIC COMPANY LIMITED'),
(10, 'ธนาคารทิสโก้', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'TISCO BANK PUBLIC COMPANY LIMITED'),
(11, 'ธนาคารยูโอบี', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'UNITED OVERSEAS BANK (THAI) PUBLIC COMPANY LIMITED (UOB)'),
(12, 'ธนาคารไทยเครดิต', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'THAI CREDIT BANK PUBLIC COMPANY LIMITED'),
(13, 'ธนาคารแลนด์ แอนด์ เฮ้าส์', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'LAND AND HOUSES BANK PUBLIC COMPANY LIMITED'),
(14, 'ธนาคารไอซีบีซี (ไทย)', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(15, 'ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'Small and Medium Enterprise Development Bank of Thailand'),
(16, 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร', NULL, '2024-06-09 07:00:44', '2024-06-26 22:50:48', 0, 'Bank for Agriculture and Agricultural Cooperatives (BAAC)'),
(17, 'ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(18, 'ธนาคารออมสิน', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(19, 'ธนาคารอาคารสงเคราะห์', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(20, 'ธนาคารอิสลามแห่งประเทศไทย', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(21, 'ธนาคารเมกะ สากลพาณิชย์', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(22, 'ธนาคารแห่งประเทศจีน (ไทย)', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(23, 'ธนาคารเอเอ็นแซด (ไทย)', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(24, 'ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)', NULL, '2024-06-09 07:00:44', '2024-06-09 07:00:44', 0, ''),
(25, 'System Bank', NULL, '2024-06-18 20:29:34', '2024-06-18 20:29:34', 0, 'System Bank');

-- --------------------------------------------------------

--
-- Table structure for table `bank_statements`
--

CREATE TABLE `bank_statements` (
  `bstate_id` bigint(20) NOT NULL,
  `bank_id` bigint(20) NOT NULL,
  `blit_id` bigint(20) NOT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `bstate_IN` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'สถานะเงินเข้า',
  `bstate_out` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'สถานะออก',
  `bstate_note` text DEFAULT NULL COMMENT 'หมายเหตุ',
  `bstate_remain` decimal(65,2) NOT NULL COMMENT 'คงเหลือ',
  `money_incoming` decimal(65,2) NOT NULL COMMENT 'เงินเข้า',
  `money_out` decimal(65,2) NOT NULL COMMENT 'เงินออก',
  `bstate_delete` tinyint(1) NOT NULL DEFAULT 0,
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` int(11) DEFAULT NULL,
  `ac_code` varchar(100) NOT NULL,
  `bstate_slip` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_statements`
--

INSERT INTO `bank_statements` (`bstate_id`, `bank_id`, `blit_id`, `userId`, `status_id`, `bstate_IN`, `bstate_out`, `bstate_note`, `bstate_remain`, `money_incoming`, `money_out`, `bstate_delete`, `datetime`, `created_at`, `updated_at`, `deleted_at`, `ac_code`, `bstate_slip`) VALUES
(1, 1, 2, 'U2c1dc9454ef393c22f69dab1f7a07f1a', 1, 1, 0, '', '900000.00', '900000.00', '0.00', 0, NULL, '2025-02-26 04:43:57', '2025-02-26 04:43:57', NULL, 'bmU-85368699', '20250226/1740545037_c2b1c1bd503054ca6491.png'),
(2, 1, 2, 'U608c60e554f54138f6023128067c63dd', 1, 1, 0, '', '980000.00', '80000.00', '0.00', 0, NULL, '2025-02-26 04:47:06', '2025-02-26 04:47:06', NULL, 'bmU-85368699', NULL),
(3, 1, 2, 'U608c60e554f54138f6023128067c63dd', 1, 1, 0, '', '1700000.00', '720000.00', '0.00', 0, NULL, '2025-02-26 04:47:37', '2025-02-26 04:47:37', NULL, 'bmU-85368699', NULL),
(4, 1, 2, 'U608c60e554f54138f6023128067c63dd', 1, 1, 0, '', '2420000.00', '720000.00', '0.00', 0, NULL, '2025-02-26 04:47:37', '2025-02-26 04:47:37', NULL, 'bmU-85368699', NULL),
(5, 1, 2, 'U2c1dc9454ef393c22f69dab1f7a07f1a', 1, 1, 0, '', '3220000.00', '800000.00', '0.00', 0, NULL, '2025-02-26 05:18:05', '2025-02-26 05:18:05', NULL, 'bmU-85368699', '20250226/1740547049_70f34337451c26b28da7.png'),
(6, 1, 2, 'U2d9211d3cf56c7ab2649e794eb5639f8', 1, 1, 0, '', '3320000.00', '100000.00', '0.00', 0, NULL, '2025-02-26 17:52:20', '2025-02-26 17:52:20', NULL, 'bmU-85368699', NULL),
(7, 1, 2, 'U608c60e554f54138f6023128067c63dd', 1, 1, 0, '', '3420000.00', '100000.00', '0.00', 0, NULL, '2025-02-26 17:52:48', '2025-02-26 17:52:48', NULL, 'bmU-85368699', NULL),
(8, 1, 2, 'Ub378216b0e6b9be8c431a2c36cdcbbe7', 1, 1, 0, '', '3620000.00', '200000.00', '0.00', 0, NULL, '2025-02-26 17:54:36', '2025-02-26 17:54:36', NULL, 'bmU-85368699', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` bigint(20) NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambling_histories`
--

CREATE TABLE `gambling_histories` (
  `gamb_ID` bigint(20) NOT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `glco_ID` bigint(20) DEFAULT NULL COMMENT 'รอบลง',
  `groupLive_ID` bigint(20) DEFAULT NULL,
  `msID` bigint(20) DEFAULT NULL COMMENT 'เกม',
  `groupId` varchar(255) DEFAULT NULL COMMENT 'กลุ่ม',
  `grId` bigint(20) DEFAULT NULL COMMENT 'เลือกลง',
  `glco_quantity` decimal(30,2) DEFAULT NULL COMMENT 'ลงเงิน',
  `glco_lose` tinyint(1) DEFAULT 0 COMMENT 'แพ้',
  `glco_win` tinyint(1) DEFAULT 0 COMMENT 'ชนะ',
  `glco_multiply` decimal(10,2) DEFAULT NULL COMMENT 'ต่อ 1:1 1:20',
  `glco_refund` decimal(65,2) DEFAULT NULL COMMENT 'กรณีชนะ คืนเงิน',
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `glco_delete` tinyint(1) DEFAULT 0,
  `glco_cancel` tinyint(1) DEFAULT 0,
  `timestamp` varchar(100) DEFAULT NULL,
  `gamb_text` text DEFAULT NULL,
  `isRedelivery` varchar(100) NOT NULL DEFAULT '0',
  `glco_success` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamemasters`
--

CREATE TABLE `gamemasters` (
  `msID` bigint(20) NOT NULL,
  `msNameT` varchar(50) DEFAULT NULL,
  `msNameE` varchar(50) DEFAULT NULL,
  `msDelete` tinyint(1) DEFAULT 0,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `HowToPlayTextTH` text DEFAULT '-',
  `HowToPlayTextEN` text DEFAULT '-',
  `msRulesForPlayTH` text NOT NULL DEFAULT '-',
  `msRulesForPlayEN` text NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamemasters`
--

INSERT INTO `gamemasters` (`msID`, `msNameT`, `msNameE`, `msDelete`, `datetime`, `created_at`, `updated_at`, `deleted_at`, `HowToPlayTextTH`, `HowToPlayTextEN`, `msRulesForPlayTH`, `msRulesForPlayEN`) VALUES
(1, 'เสือ - มังกร', 'Tiger - Dragon', 0, NULL, '2024-06-05 18:52:47', '2024-06-24 18:14:24', NULL, NULL, NULL, '-', '-'),
(2, 'บาคาร่า', 'Baccarat', 0, NULL, '2024-06-05 18:52:47', '2024-06-24 18:14:28', NULL, NULL, NULL, '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `gamerules`
--

CREATE TABLE `gamerules` (
  `grId` bigint(20) NOT NULL,
  `grName` varchar(100) DEFAULT NULL,
  `grKeyLine` varchar(10) DEFAULT NULL,
  `grMultiply` decimal(10,2) DEFAULT 1.00,
  `grDelete` tinyint(1) DEFAULT 0,
  `msID` bigint(20) DEFAULT NULL,
  `grNote` text DEFAULT NULL,
  `grNameEN` varchar(100) NOT NULL,
  `grTextTH` text NOT NULL,
  `grTextEN` text NOT NULL,
  `grTextRulesTH` text NOT NULL DEFAULT '-',
  `grTextRulesEN` text NOT NULL DEFAULT '-',
  `grUrlIcon` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamerules`
--

INSERT INTO `gamerules` (`grId`, `grName`, `grKeyLine`, `grMultiply`, `grDelete`, `msID`, `grNote`, `grNameEN`, `grTextTH`, `grTextEN`, `grTextRulesTH`, `grTextRulesEN`, `grUrlIcon`) VALUES
(1, 'เสือ', '1', '1.00', 0, 1, '', 'tiger', 'ชนะ ได้ 100', 'WIN receive 100', 'แทง เสือ 100 ได้ 100', 'Bet on Tiger 100, get 100.', 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111'),
(2, 'มังกร', '2', '1.00', 0, 1, '', 'dragon', 'ชนะ ได้ 100', 'WIN receive 100', 'แทง มังกร 100 ได้ 100', 'Bet on Dragon 100 and get 100.', 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'),
(3, 'คู่', '3', '20.00', 0, 1, '-', 'dual', 'ชนะ ได้ 2000', 'WIN receive 2000', 'แทง คู่ 100 ได้ 2000', 'Bet on pair 100, get 2000', 'https://img.icons8.com/emoji/48/green-circle-emoji.png'),
(4, 'เสมอ', '4', '20.00', 0, 1, '-', 'always', 'ชนะ ได้ 2000', 'WIN receive 2000', 'แทง เสมอ 100 ได้ 2000', 'Always bet 100, get 2,000', 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png'),
(5, 'ผู้เล่น', '1', '1.00', 0, 2, '-', 'PLAYER', 'ชนะ ได้ 100', 'WIN receive 100', '-แทง ผู้เล่น 100 ได้ 100', 'Bet on Player 100, get 100.', 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'),
(6, 'เจ้ามือ', '2', '1.00', 0, 2, '-', 'BANKER', 'ชนะ ได้ 100', 'WIN receive 100', '-แทง ผู้เล่น 100 ได้ 100', 'Bet on Banker 100, get 100.', 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111');

-- --------------------------------------------------------

--
-- Table structure for table `groupmemberlists`
--

CREATE TABLE `groupmemberlists` (
  `listId` bigint(20) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `groupId` varchar(255) NOT NULL,
  `listDelete` tinyint(1) NOT NULL DEFAULT 0,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รายชื่อลูกค้าที่อยู่ในกลุ่ม';

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupId` varchar(255) NOT NULL,
  `groupName` varchar(100) NOT NULL,
  `msID` bigint(20) DEFAULT NULL COMMENT 'master game',
  `datetime` timestamp NULL DEFAULT NULL,
  `groupDelete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pictureUrl` text DEFAULT NULL,
  `group_language` enum('th','en') DEFAULT 'th',
  `GRO_Total_Quantity` decimal(65,2) NOT NULL DEFAULT 0.00,
  `GRO_Total_Payment` decimal(65,2) NOT NULL DEFAULT 0.00,
  `GRO_Remaining_Balance` decimal(65,2) NOT NULL DEFAULT 0.00,
  `GRO_InviteLink` text DEFAULT NULL COMMENT 'ลิงค์เชิญ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_lives`
--

CREATE TABLE `group_lives` (
  `groupLive_ID` bigint(20) NOT NULL,
  `groupId` varchar(255) NOT NULL,
  `statusCloseLive` tinyint(1) NOT NULL DEFAULT 0,
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `glDelete` tinyint(1) NOT NULL DEFAULT 0,
  `openCardSum` int(11) NOT NULL,
  `msID` bigint(20) NOT NULL COMMENT 'เกม',
  `GLI_Total_Quantity` decimal(65,2) DEFAULT 0.00,
  `GLI_Total_Payment` decimal(65,2) DEFAULT 0.00,
  `GLI_Remaining_Balance` decimal(65,2) DEFAULT 0.00,
  `GLI_Confirm_Result` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_live_card_opens`
--

CREATE TABLE `group_live_card_opens` (
  `glco_ID` bigint(20) NOT NULL,
  `groupLive_ID` bigint(20) DEFAULT NULL COMMENT 'live ID',
  `glco_count` int(11) DEFAULT NULL COMMENT 'รอบเล่น เปิด',
  `grId` bigint(20) DEFAULT NULL COMMENT 'ผลแพ้ชนะ',
  `msID` bigint(20) DEFAULT NULL COMMENT 'game',
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` int(11) DEFAULT NULL,
  `groupId` varchar(255) DEFAULT NULL,
  `glcoDelete` tinyint(1) DEFAULT 0 COMMENT 'ลบเปิด',
  `glcoCancel` tinyint(1) DEFAULT 0 COMMENT 'ยกเลิกเปิด',
  `status_id` int(11) DEFAULT 5,
  `GL_Total_Quantity` decimal(65,2) DEFAULT 0.00,
  `GL_Total_Payment` decimal(65,2) DEFAULT 0.00,
  `GL_Remaining_Balance` decimal(65,2) DEFAULT 0.00,
  `GL_Confirm_Result` tinyint(1) NOT NULL DEFAULT 0,
  `GL_Confirm_User` varchar(255) DEFAULT NULL,
  `GL_Win_Total` int(11) DEFAULT 0 COMMENT 'คนที่ชนะ',
  `GL_Loss_Total` int(11) DEFAULT 0 COMMENT 'คนที่แพ้',
  `GL_Games_Played` int(11) DEFAULT 0 COMMENT 'ครั้งที่เล่นทั้งหมด',
  `GLCO_STEP` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `howtoplay_m`
--

CREATE TABLE `howtoplay_m` (
  `htp_id` int(11) NOT NULL,
  `msID` bigint(20) NOT NULL,
  `htp_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lnvitelink`
--

CREATE TABLE `lnvitelink` (
  `LL_ID` int(11) NOT NULL,
  `LL_CODE` varchar(20) NOT NULL,
  `ac_code` varchar(255) NOT NULL,
  `groupId` varchar(255) DEFAULT NULL,
  `LL_LINK` varchar(255) NOT NULL,
  `LL_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `LL_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LL_deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LL_START_DATE` date NOT NULL DEFAULT current_timestamp(),
  `LL_EXPIRE` date DEFAULT NULL,
  `LL_COUNT` int(11) NOT NULL DEFAULT 0,
  `LL_TYPE` enum('lnv','member') NOT NULL DEFAULT 'lnv',
  `userId` varchar(255) DEFAULT NULL,
  `LL_LIMIT` int(11) DEFAULT NULL,
  `LL_ACTION` tinyint(1) NOT NULL DEFAULT 0,
  `LL_DELETE` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `LogID` int(11) NOT NULL,
  `ac_id` int(11) DEFAULT NULL,
  `Action` varchar(50) DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logswebhook`
--

CREATE TABLE `logswebhook` (
  `lwb_id` bigint(20) NOT NULL,
  `lwb_destination` text NOT NULL,
  `lwb_events` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`lwb_events`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_admins`
--

CREATE TABLE `log_admins` (
  `log_id` bigint(20) NOT NULL,
  `ac_code` varchar(255) DEFAULT NULL COMMENT 'ผู้กระทำ',
  `status_id` int(11) DEFAULT NULL COMMENT 'กระทำ',
  `action_note` text DEFAULT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `userId` varchar(255) NOT NULL,
  `displayName` varchar(255) DEFAULT NULL,
  `userDelete` tinyint(1) NOT NULL DEFAULT 0,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pictureUrl` text DEFAULT NULL,
  `language` varchar(50) DEFAULT 'th',
  `statusMessage` varchar(255) DEFAULT NULL,
  `follow` tinyint(1) NOT NULL DEFAULT 1,
  `user_remain` decimal(65,2) NOT NULL DEFAULT 0.00 COMMENT 'คงเหลือ',
  `user_agent` varchar(100) DEFAULT NULL COMMENT 'ตัวแทน',
  `user_agent_date` timestamp NULL DEFAULT NULL,
  `user_TotalAmount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `user_TotalWithdrawal` decimal(65,2) NOT NULL DEFAULT 0.00,
  `user_bank` varchar(255) DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `user_bankNumber` varchar(50) DEFAULT NULL COMMENT 'เลขบัญชี',
  `user_bankFName` varchar(100) DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `user_fname` varchar(50) DEFAULT NULL,
  `user_lname` varchar(50) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `user_zipCode` varchar(30) DEFAULT NULL,
  `user_country` varchar(100) DEFAULT NULL,
  `user_currency` varchar(50) NOT NULL DEFAULT 'THB',
  `user_bankLName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_statements`
--

CREATE TABLE `member_statements` (
  `statement_ID` bigint(20) NOT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `statement_IN` tinyint(1) DEFAULT 0 COMMENT 'สถานะเงินเข้า',
  `statement_OUT` tinyint(1) DEFAULT 0 COMMENT 'สถานะเงินออก',
  `status_id` int(11) DEFAULT NULL,
  `statement_note` text DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `statement_remain` decimal(65,2) DEFAULT 0.00 COMMENT 'คงเหลือ',
  `money_incoming` decimal(65,2) DEFAULT 0.00,
  `money_out` decimal(65,2) DEFAULT 0.00,
  `ac_code` varchar(255) DEFAULT NULL,
  `statement_slip` varchar(100) DEFAULT NULL,
  `blit_id` bigint(20) DEFAULT NULL,
  `gamb_ID` bigint(20) DEFAULT NULL,
  `PAY_ID` bigint(20) DEFAULT NULL COMMENT 'FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PAY_ID` bigint(20) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `PAY_IN` tinyint(1) NOT NULL DEFAULT 0,
  `PAY_OUT` tinyint(1) NOT NULL DEFAULT 0,
  `status_id` int(11) NOT NULL,
  `PAY_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `PAY_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PAY_deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blit_id` bigint(20) DEFAULT NULL,
  `PAY_APPROVE` tinyint(1) DEFAULT NULL,
  `PAY_APPROVE_USER` varchar(255) DEFAULT NULL,
  `PAY_APPROVE_TIME` timestamp NULL DEFAULT NULL,
  `PAY_SLIP` varchar(255) DEFAULT NULL,
  `PAY_MONEY` decimal(65,2) NOT NULL DEFAULT 0.00,
  `PAY_DATE` date DEFAULT NULL COMMENT 'วันที่โอน',
  `PAY_TIME` time DEFAULT NULL COMMENT 'เวลาโอน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `PermissionID` int(11) NOT NULL,
  `PermissionName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`PermissionID`, `PermissionName`) VALUES
(1, 'Add'),
(2, 'Edit'),
(3, 'Delete'),
(4, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `rolepermissions`
--

CREATE TABLE `rolepermissions` (
  `RoleID` int(11) NOT NULL,
  `PermissionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolepermissions`
--

INSERT INTO `rolepermissions` (`RoleID`, `PermissionID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 2),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'Admin'),
(2, 'MANAGER'),
(3, 'STAFF'),
(4, 'Super Admin'),
(5, 'STAFF ROOM'),
(6, 'STAFF MEMBER'),
(7, 'STAFF BANK'),
(8, 'AGENT');

-- --------------------------------------------------------

--
-- Table structure for table `signinlogs`
--

CREATE TABLE `signinlogs` (
  `sig_id` bigint(255) UNSIGNED NOT NULL,
  `sig_type` varchar(255) DEFAULT NULL,
  `sig_text` text DEFAULT NULL,
  `sig_ip` text DEFAULT NULL,
  `sig_comment` text DEFAULT NULL,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  `status_note` text DEFAULT NULL,
  `status_type` enum('bank','user','admin','live') NOT NULL,
  `status_nameEN` varchar(100) DEFAULT NULL,
  `status_class` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usersigninlogs`
--

CREATE TABLE `usersigninlogs` (
  `USIG_ID` int(11) NOT NULL,
  `USIG_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `USIG_datetime` timestamp NULL DEFAULT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `USIG_TOKEN` text DEFAULT NULL,
  `USIG_TYPE` varchar(50) DEFAULT NULL,
  `USIG_IP` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_admin`
--
ALTER TABLE `accounts_admin`
  ADD PRIMARY KEY (`ac_id`),
  ADD UNIQUE KEY `ac_code` (`ac_code`),
  ADD UNIQUE KEY `ac_email` (`ac_email`),
  ADD KEY `roles999` (`RoleID`);

--
-- Indexes for table `banklists`
--
ALTER TABLE `banklists`
  ADD PRIMARY KEY (`blit_id`),
  ADD UNIQUE KEY `blit_number` (`blit_number`),
  ADD KEY `banklists1` (`bank_id`),
  ADD KEY `banklists2` (`ac_code`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bank_statements`
--
ALTER TABLE `bank_statements`
  ADD PRIMARY KEY (`bstate_id`),
  ADD KEY `bank_statements1` (`bank_id`),
  ADD KEY `bank_statements2` (`blit_id`),
  ADD KEY `bank_statements3` (`userId`),
  ADD KEY `bank_statements4` (`status_id`),
  ADD KEY `bank_statements5` (`ac_code`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `gambling_histories`
--
ALTER TABLE `gambling_histories`
  ADD PRIMARY KEY (`gamb_ID`),
  ADD KEY `gambli1` (`glco_ID`),
  ADD KEY `gambli2` (`grId`),
  ADD KEY `gambli3` (`groupId`),
  ADD KEY `gambli4` (`groupLive_ID`),
  ADD KEY `gambli5` (`msID`),
  ADD KEY `gambli6` (`userId`);

--
-- Indexes for table `gamemasters`
--
ALTER TABLE `gamemasters`
  ADD PRIMARY KEY (`msID`);

--
-- Indexes for table `gamerules`
--
ALTER TABLE `gamerules`
  ADD PRIMARY KEY (`grId`),
  ADD KEY `mg_gr_1` (`msID`);

--
-- Indexes for table `groupmemberlists`
--
ALTER TABLE `groupmemberlists`
  ADD PRIMARY KEY (`listId`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupId`),
  ADD UNIQUE KEY `groupId` (`groupId`),
  ADD KEY `msIDTo1` (`msID`);

--
-- Indexes for table `group_lives`
--
ALTER TABLE `group_lives`
  ADD PRIMARY KEY (`groupLive_ID`),
  ADD KEY `groupIDTOGL` (`groupId`),
  ADD KEY `msGame_Live` (`msID`);

--
-- Indexes for table `group_live_card_opens`
--
ALTER TABLE `group_live_card_opens`
  ADD PRIMARY KEY (`glco_ID`),
  ADD KEY `glco_1` (`grId`),
  ADD KEY `glco_2` (`groupId`),
  ADD KEY `glco_3` (`groupLive_ID`),
  ADD KEY `glco_4` (`msID`),
  ADD KEY `glco_5` (`status_id`);

--
-- Indexes for table `howtoplay_m`
--
ALTER TABLE `howtoplay_m`
  ADD PRIMARY KEY (`htp_id`);

--
-- Indexes for table `lnvitelink`
--
ALTER TABLE `lnvitelink`
  ADD PRIMARY KEY (`LL_ID`),
  ADD KEY `lnvitelink1` (`ac_code`),
  ADD KEY `lnvitelink2` (`groupId`),
  ADD KEY `lnvitelink3` (`userId`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `logswebhook`
--
ALTER TABLE `logswebhook`
  ADD PRIMARY KEY (`lwb_id`);

--
-- Indexes for table `log_admins`
--
ALTER TABLE `log_admins`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_admins` (`status_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD KEY `member_1` (`user_agent`);

--
-- Indexes for table `member_statements`
--
ALTER TABLE `member_statements`
  ADD PRIMARY KEY (`statement_ID`),
  ADD KEY `member_statements1` (`userId`),
  ADD KEY `member_statements2` (`status_id`),
  ADD KEY `member_statements3` (`blit_id`),
  ADD KEY `member_statements4` (`ac_code`),
  ADD KEY `member_statements5` (`PAY_ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PAY_ID`),
  ADD KEY `payments2` (`status_id`),
  ADD KEY `payments3` (`userId`),
  ADD KEY `payments1` (`blit_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`PermissionID`);

--
-- Indexes for table `rolepermissions`
--
ALTER TABLE `rolepermissions`
  ADD PRIMARY KEY (`RoleID`,`PermissionID`),
  ADD KEY `PermissionID` (`PermissionID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `signinlogs`
--
ALTER TABLE `signinlogs`
  ADD PRIMARY KEY (`sig_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `usersigninlogs`
--
ALTER TABLE `usersigninlogs`
  ADD PRIMARY KEY (`USIG_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_admin`
--
ALTER TABLE `accounts_admin`
  MODIFY `ac_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banklists`
--
ALTER TABLE `banklists`
  MODIFY `blit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bank_statements`
--
ALTER TABLE `bank_statements`
  MODIFY `bstate_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gambling_histories`
--
ALTER TABLE `gambling_histories`
  MODIFY `gamb_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamemasters`
--
ALTER TABLE `gamemasters`
  MODIFY `msID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gamerules`
--
ALTER TABLE `gamerules`
  MODIFY `grId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groupmemberlists`
--
ALTER TABLE `groupmemberlists`
  MODIFY `listId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_lives`
--
ALTER TABLE `group_lives`
  MODIFY `groupLive_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_live_card_opens`
--
ALTER TABLE `group_live_card_opens`
  MODIFY `glco_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `howtoplay_m`
--
ALTER TABLE `howtoplay_m`
  MODIFY `htp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lnvitelink`
--
ALTER TABLE `lnvitelink`
  MODIFY `LL_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logswebhook`
--
ALTER TABLE `logswebhook`
  MODIFY `lwb_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_admins`
--
ALTER TABLE `log_admins`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_statements`
--
ALTER TABLE `member_statements`
  MODIFY `statement_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PAY_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `signinlogs`
--
ALTER TABLE `signinlogs`
  MODIFY `sig_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usersigninlogs`
--
ALTER TABLE `usersigninlogs`
  MODIFY `USIG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts_admin`
--
ALTER TABLE `accounts_admin`
  ADD CONSTRAINT `roles999` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);

--
-- Constraints for table `banklists`
--
ALTER TABLE `banklists`
  ADD CONSTRAINT `banklists1` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`bank_id`),
  ADD CONSTRAINT `banklists2` FOREIGN KEY (`ac_code`) REFERENCES `accounts_admin` (`ac_code`);

--
-- Constraints for table `bank_statements`
--
ALTER TABLE `bank_statements`
  ADD CONSTRAINT `bank_statements1` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`bank_id`),
  ADD CONSTRAINT `bank_statements2` FOREIGN KEY (`blit_id`) REFERENCES `banklists` (`blit_id`),
  ADD CONSTRAINT `bank_statements3` FOREIGN KEY (`userId`) REFERENCES `members` (`userId`),
  ADD CONSTRAINT `bank_statements4` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `bank_statements5` FOREIGN KEY (`ac_code`) REFERENCES `accounts_admin` (`ac_code`);

--
-- Constraints for table `gambling_histories`
--
ALTER TABLE `gambling_histories`
  ADD CONSTRAINT `gambli1` FOREIGN KEY (`glco_ID`) REFERENCES `group_live_card_opens` (`glco_ID`),
  ADD CONSTRAINT `gambli2` FOREIGN KEY (`grId`) REFERENCES `gamerules` (`grId`),
  ADD CONSTRAINT `gambli3` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`),
  ADD CONSTRAINT `gambli4` FOREIGN KEY (`groupLive_ID`) REFERENCES `group_lives` (`groupLive_ID`),
  ADD CONSTRAINT `gambli5` FOREIGN KEY (`msID`) REFERENCES `gamemasters` (`msID`),
  ADD CONSTRAINT `gambli6` FOREIGN KEY (`userId`) REFERENCES `members` (`userId`);

--
-- Constraints for table `gamerules`
--
ALTER TABLE `gamerules`
  ADD CONSTRAINT `mg_gr_1` FOREIGN KEY (`msID`) REFERENCES `gamemasters` (`msID`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `msIDTo1` FOREIGN KEY (`msID`) REFERENCES `gamemasters` (`msID`);

--
-- Constraints for table `group_lives`
--
ALTER TABLE `group_lives`
  ADD CONSTRAINT `groupIDTOGL` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`),
  ADD CONSTRAINT `msGame_Live` FOREIGN KEY (`msID`) REFERENCES `gamemasters` (`msID`);

--
-- Constraints for table `group_live_card_opens`
--
ALTER TABLE `group_live_card_opens`
  ADD CONSTRAINT `glco_1` FOREIGN KEY (`grId`) REFERENCES `gamerules` (`grId`),
  ADD CONSTRAINT `glco_2` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`),
  ADD CONSTRAINT `glco_3` FOREIGN KEY (`groupLive_ID`) REFERENCES `group_lives` (`groupLive_ID`),
  ADD CONSTRAINT `glco_4` FOREIGN KEY (`msID`) REFERENCES `gamemasters` (`msID`),
  ADD CONSTRAINT `glco_5` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`);

--
-- Constraints for table `lnvitelink`
--
ALTER TABLE `lnvitelink`
  ADD CONSTRAINT `lnvitelink1` FOREIGN KEY (`ac_code`) REFERENCES `accounts_admin` (`ac_code`),
  ADD CONSTRAINT `lnvitelink2` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`),
  ADD CONSTRAINT `lnvitelink3` FOREIGN KEY (`userId`) REFERENCES `members` (`userId`);

--
-- Constraints for table `log_admins`
--
ALTER TABLE `log_admins`
  ADD CONSTRAINT `log_admins` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `member_1` FOREIGN KEY (`user_agent`) REFERENCES `accounts_admin` (`ac_code`);

--
-- Constraints for table `member_statements`
--
ALTER TABLE `member_statements`
  ADD CONSTRAINT `member_statements1` FOREIGN KEY (`userId`) REFERENCES `members` (`userId`),
  ADD CONSTRAINT `member_statements2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `member_statements3` FOREIGN KEY (`blit_id`) REFERENCES `banklists` (`blit_id`),
  ADD CONSTRAINT `member_statements4` FOREIGN KEY (`ac_code`) REFERENCES `accounts_admin` (`ac_code`),
  ADD CONSTRAINT `member_statements5` FOREIGN KEY (`PAY_ID`) REFERENCES `payments` (`PAY_ID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments1` FOREIGN KEY (`blit_id`) REFERENCES `banklists` (`blit_id`),
  ADD CONSTRAINT `payments2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `payments3` FOREIGN KEY (`userId`) REFERENCES `members` (`userId`);

--
-- Constraints for table `rolepermissions`
--
ALTER TABLE `rolepermissions`
  ADD CONSTRAINT `rolepermissions_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`),
  ADD CONSTRAINT `rolepermissions_ibfk_2` FOREIGN KEY (`PermissionID`) REFERENCES `permissions` (`PermissionID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
