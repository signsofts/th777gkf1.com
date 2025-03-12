-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2025 at 08:25 AM
-- Server version: 8.0.36-28
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `th777gkf1-dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_admin`
--

CREATE TABLE `accounts_admin` (
  `ac_id` bigint UNSIGNED NOT NULL,
  `ac_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_fname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_niname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ac_delete` tinyint(1) NOT NULL DEFAULT '0',
  `RoleID` int NOT NULL COMMENT 'เก็บข้อมูลบทบาทของพนักงาน',
  `ac_referral` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'รหัสแนะนำ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_admin`
--

INSERT INTO `accounts_admin` (`ac_id`, `ac_code`, `ac_email`, `ac_password`, `ac_fname`, `ac_lname`, `ac_niname`, `datetime`, `created_at`, `updated_at`, `deleted_at`, `ac_delete`, `RoleID`, `ac_referral`) VALUES
(1, 'bmU-85368698', 'system@system.com', '$2y$10$ma0fgCcmUmN4sC0mw.yvVOAxU100bJlnsxyoenmsmniNHmbgh8j.C', 'system', 'system', 'system', NULL, '2024-06-18 20:21:27', '2024-07-02 15:06:43', NULL, 0, 4, NULL),
(2, 'bmU-85368699', 'sadmin@gmail.com', '$2y$10$4IWS/MKlpdiVP6rt01NNLuS6W6V/6YetpKxZTO3/Uj70iVDXus0Mm', 'Super Admin', 'Super Admin', 'Super Admin', NULL, '2024-06-03 07:08:37', '2025-01-22 17:01:15', NULL, 0, 4, NULL),
(3, 'EMo46126149', 'Mung95.Lampang@Emai.com', '$2y$10$xkdH7zmbqEBMw6K3sNaYW.f/HGqtDDYDi7DZM1F.IVMF23YKFctuO', 'thai777GCW', 'thai777GCW', 'TH777', NULL, '2025-02-08 20:01:47', '2025-02-08 20:01:47', NULL, 0, 7, 'rf-EMo46126149');

-- --------------------------------------------------------

--
-- Table structure for table `banklists`
--

CREATE TABLE `banklists` (
  `blit_id` bigint NOT NULL,
  `ac_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสแอดมิน',
  `bank_id` bigint NOT NULL COMMENT 'รหัสชื่อธนาคาร',
  `blit_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เลขบัญชี',
  `blit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อบัญชี',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `blit_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 delete',
  `blit_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blit_remain` decimal(65,2) NOT NULL DEFAULT '0.00',
  `blit_delete_ad_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banklists`
--

INSERT INTO `banklists` (`blit_id`, `ac_code`, `bank_id`, `blit_number`, `blit_name`, `created_at`, `updated_at`, `blit_delete`, `blit_image`, `blit_remain`, `blit_delete_ad_code`) VALUES
(1, 'bmU-85368698', 25, '9999999999', 'System Bank', '2024-07-13 16:30:33', '2024-07-13 16:31:59', 0, NULL, 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` bigint NOT NULL,
  `bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `bank_delete` tinyint(1) DEFAULT '0',
  `bank_nameEN` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `bstate_id` bigint NOT NULL,
  `bank_id` bigint NOT NULL,
  `blit_id` bigint NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_id` int DEFAULT NULL,
  `bstate_IN` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'สถานะเงินเข้า',
  `bstate_out` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'สถานะออก',
  `bstate_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'หมายเหตุ',
  `bstate_remain` decimal(65,2) NOT NULL COMMENT 'คงเหลือ',
  `money_incoming` decimal(65,2) NOT NULL COMMENT 'เงินเข้า',
  `money_out` decimal(65,2) NOT NULL COMMENT 'เงินออก',
  `bstate_delete` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` int DEFAULT NULL,
  `ac_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bstate_slip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` bigint UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambling_histories`
--

CREATE TABLE `gambling_histories` (
  `gamb_ID` bigint NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `glco_ID` bigint DEFAULT NULL COMMENT 'รอบลง',
  `groupLive_ID` bigint DEFAULT NULL,
  `msID` bigint DEFAULT NULL COMMENT 'เกม',
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'กลุ่ม',
  `grId` bigint DEFAULT NULL COMMENT 'เลือกลง',
  `glco_quantity` decimal(30,2) DEFAULT NULL COMMENT 'ลงเงิน',
  `glco_lose` tinyint(1) DEFAULT '0' COMMENT 'แพ้',
  `glco_win` tinyint(1) DEFAULT '0' COMMENT 'ชนะ',
  `glco_multiply` decimal(10,2) DEFAULT NULL COMMENT 'ต่อ 1:1 1:20',
  `glco_refund` decimal(65,2) DEFAULT NULL COMMENT 'กรณีชนะ คืนเงิน',
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `glco_delete` tinyint(1) DEFAULT '0',
  `glco_cancel` tinyint(1) DEFAULT '0',
  `timestamp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gamb_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `isRedelivery` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `glco_success` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamemasters`
--

CREATE TABLE `gamemasters` (
  `msID` bigint NOT NULL,
  `msNameT` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `msNameE` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `msDelete` tinyint(1) DEFAULT '0',
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `HowToPlayTextTH` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `HowToPlayTextEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `msRulesForPlayTH` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `msRulesForPlayEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
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
  `grId` bigint NOT NULL,
  `grName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grKeyLine` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grMultiply` decimal(10,2) DEFAULT '1.00',
  `grDelete` tinyint(1) DEFAULT '0',
  `msID` bigint DEFAULT NULL,
  `grNote` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grNameEN` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grTextTH` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grTextEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grTextRulesTH` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grTextRulesEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grUrlIcon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamerules`
--

INSERT INTO `gamerules` (`grId`, `grName`, `grKeyLine`, `grMultiply`, `grDelete`, `msID`, `grNote`, `grNameEN`, `grTextTH`, `grTextEN`, `grTextRulesTH`, `grTextRulesEN`, `grUrlIcon`) VALUES
(1, 'เสือ', '1', 1.00, 0, 1, '', 'tiger', 'ชนะ ได้ 100', 'WIN receive 100', 'แทง เสือ 100 ได้ 100', 'Bet on Tiger 100, get 100.', 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111'),
(2, 'มังกร', '2', 1.00, 0, 1, '', 'dragon', 'ชนะ ได้ 100', 'WIN receive 100', 'แทง มังกร 100 ได้ 100', 'Bet on Dragon 100 and get 100.', 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'),
(3, 'คู่', '3', 20.00, 0, 1, '-', 'dual', 'ชนะ ได้ 2000', 'WIN receive 2000', 'แทง คู่ 100 ได้ 2000', 'Bet on pair 100, get 2000', 'https://img.icons8.com/emoji/48/green-circle-emoji.png'),
(4, 'เสมอ', '4', 20.00, 0, 1, '-', 'always', 'ชนะ ได้ 2000', 'WIN receive 2000', 'แทง เสมอ 100 ได้ 2000', 'Always bet 100, get 2,000', 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png'),
(5, 'ผู้เล่น', '1', 1.00, 0, 2, '-', 'PLAYER', 'ชนะ ได้ 100', 'WIN receive 100', '-แทง ผู้เล่น 100 ได้ 100', 'Bet on Player 100, get 100.', 'https://img.icons8.com/?size=100&id=SCY7gqvxY0DC&format=png&color=000000'),
(6, 'เจ้ามือ', '2', 1.00, 0, 2, '-', 'BANKER', 'ชนะ ได้ 100', 'WIN receive 100', '-แทง ผู้เล่น 100 ได้ 100', 'Bet on Banker 100, get 100.', 'https://img.icons8.com/?size=100&id=amr4dGCohyBU&format=png&color=111111'),
(7, 'เสมอ', '3', 20.00, 0, 2, '-', 'always', 'ชนะ ได้ 2000', 'WIN receive 2000', '-แทง ผู้เล่น 100 ได้ 2000', 'Bet on Banker 100, get 2000.', 'https://img.icons8.com/ios-filled/50/F4F206/filled-circle.png');

-- --------------------------------------------------------

--
-- Table structure for table `groupmemberlists`
--

CREATE TABLE `groupmemberlists` (
  `listId` bigint NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `listDelete` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `groupName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `msID` bigint DEFAULT NULL COMMENT 'master game',
  `datetime` timestamp NULL DEFAULT NULL,
  `groupDelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pictureUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `group_language` enum('th','en') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'th',
  `GRO_Total_Quantity` decimal(65,2) NOT NULL DEFAULT '0.00',
  `GRO_Total_Payment` decimal(65,2) NOT NULL DEFAULT '0.00',
  `GRO_Remaining_Balance` decimal(65,2) NOT NULL DEFAULT '0.00',
  `GRO_InviteLink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'ลิงค์เชิญ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_lives`
--

CREATE TABLE `group_lives` (
  `groupLive_ID` bigint NOT NULL,
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `statusCloseLive` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `glDelete` tinyint(1) NOT NULL DEFAULT '0',
  `openCardSum` int NOT NULL,
  `msID` bigint NOT NULL COMMENT 'เกม',
  `GLI_Total_Quantity` decimal(65,2) DEFAULT '0.00',
  `GLI_Total_Payment` decimal(65,2) DEFAULT '0.00',
  `GLI_Remaining_Balance` decimal(65,2) DEFAULT '0.00',
  `GLI_Confirm_Result` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_live_card_opens`
--

CREATE TABLE `group_live_card_opens` (
  `glco_ID` bigint NOT NULL,
  `groupLive_ID` bigint DEFAULT NULL COMMENT 'live ID',
  `glco_count` int DEFAULT NULL COMMENT 'รอบเล่น เปิด',
  `grId` bigint DEFAULT NULL COMMENT 'ผลแพ้ชนะ',
  `msID` bigint DEFAULT NULL COMMENT 'game',
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` int DEFAULT NULL,
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `glcoDelete` tinyint(1) DEFAULT '0' COMMENT 'ลบเปิด',
  `glcoCancel` tinyint(1) DEFAULT '0' COMMENT 'ยกเลิกเปิด',
  `status_id` int DEFAULT '5',
  `GL_Total_Quantity` decimal(65,2) DEFAULT '0.00',
  `GL_Total_Payment` decimal(65,2) DEFAULT '0.00',
  `GL_Remaining_Balance` decimal(65,2) DEFAULT '0.00',
  `GL_Confirm_Result` tinyint(1) NOT NULL DEFAULT '0',
  `GL_Confirm_User` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `GL_Win_Total` int DEFAULT '0' COMMENT 'คนที่ชนะ',
  `GL_Loss_Total` int DEFAULT '0' COMMENT 'คนที่แพ้',
  `GL_Games_Played` int DEFAULT '0' COMMENT 'ครั้งที่เล่นทั้งหมด',
  `GLCO_STEP` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `howtoplay_m`
--

CREATE TABLE `howtoplay_m` (
  `htp_id` int NOT NULL,
  `msID` bigint NOT NULL,
  `htp_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lnvitelink`
--

CREATE TABLE `lnvitelink` (
  `LL_ID` int NOT NULL,
  `LL_CODE` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ac_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `groupId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LL_LINK` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `LL_created_at` timestamp NOT NULL,
  `LL_updated_at` timestamp NOT NULL,
  `LL_deleted_at` timestamp NOT NULL,
  `LL_START_DATE` date NOT NULL,
  `LL_EXPIRE` date DEFAULT NULL,
  `LL_COUNT` int NOT NULL DEFAULT '0',
  `LL_TYPE` enum('lnv','member') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'lnv',
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LL_LIMIT` int DEFAULT NULL,
  `LL_ACTION` tinyint(1) NOT NULL DEFAULT '0',
  `LL_DELETE` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `LogID` int NOT NULL,
  `ac_id` int DEFAULT NULL,
  `Action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logswebhook`
--

CREATE TABLE `logswebhook` (
  `lwb_id` bigint NOT NULL,
  `lwb_destination` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lwb_events` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_admins`
--

CREATE TABLE `log_admins` (
  `log_id` bigint NOT NULL,
  `ac_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ผู้กระทำ',
  `status_id` int DEFAULT NULL COMMENT 'กระทำ',
  `action_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `user_id` int NOT NULL,
  `user_register_status` tinyint(1) DEFAULT NULL COMMENT 'สถานะลงทะเบียน',
  `user_line_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ID LINE',
  `displayName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userDelete` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `pictureUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'th',
  `statusMessage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `follow` tinyint(1) NOT NULL DEFAULT '1',
  `user_remain` decimal(65,2) NOT NULL DEFAULT '0.00' COMMENT 'คงเหลือ',
  `user_agent` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ตัวแทน',
  `user_agent_date` timestamp NULL DEFAULT NULL,
  `user_TotalAmount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `user_TotalWithdrawal` decimal(65,2) NOT NULL DEFAULT '0.00',
  `user_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `user_bankNumber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เลขบัญชี',
  `user_bankFName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `user_fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อ',
  `user_lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'สกุล',
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'email',
  `user_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์',
  `user_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'ที่อ่ยู่',
  `user_zipCode` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_currency` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'THB' COMMENT 'สกุลเงิน',
  `user_bankLName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `user_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_statements`
--

CREATE TABLE `member_statements` (
  `statement_ID` bigint NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `statement_IN` tinyint(1) DEFAULT '0' COMMENT 'สถานะเงินเข้า',
  `statement_OUT` tinyint(1) DEFAULT '0' COMMENT 'สถานะเงินออก',
  `status_id` int DEFAULT NULL,
  `statement_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `statement_remain` decimal(65,2) DEFAULT '0.00' COMMENT 'คงเหลือ',
  `money_incoming` decimal(65,2) DEFAULT '0.00',
  `money_out` decimal(65,2) DEFAULT '0.00',
  `ac_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `statement_slip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blit_id` bigint DEFAULT NULL,
  `gamb_ID` bigint DEFAULT NULL,
  `PAY_ID` bigint DEFAULT NULL COMMENT 'FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PAY_ID` bigint NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PAY_IN` tinyint(1) NOT NULL DEFAULT '0',
  `PAY_OUT` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` int NOT NULL,
  `PAY_created_at` timestamp NOT NULL,
  `PAY_updated_at` timestamp NOT NULL,
  `PAY_deleted_at` timestamp NOT NULL,
  `blit_id` bigint DEFAULT NULL,
  `PAY_APPROVE` tinyint(1) DEFAULT NULL,
  `PAY_APPROVE_USER` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PAY_APPROVE_TIME` timestamp NULL DEFAULT NULL,
  `PAY_SLIP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PAY_MONEY` decimal(65,2) NOT NULL DEFAULT '0.00',
  `PAY_DATE` date DEFAULT NULL COMMENT 'วันที่โอน',
  `PAY_TIME` time DEFAULT NULL COMMENT 'เวลาโอน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `PermissionID` int NOT NULL,
  `PermissionName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
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
  `RoleID` int NOT NULL,
  `PermissionID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolepermissions`
--

INSERT INTO `rolepermissions` (`RoleID`, `PermissionID`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int NOT NULL,
  `RoleName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
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
  `sig_id` bigint UNSIGNED NOT NULL,
  `sig_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sig_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sig_ip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sig_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int NOT NULL,
  `status_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status_type` enum('bank','user','admin','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_nameEN` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`, `status_note`, `status_type`, `status_nameEN`, `status_class`) VALUES
(1, 'เงินเข้า', NULL, 'bank', 'Incoming money', 'text-success'),
(2, 'เงินออก', NULL, 'bank', 'Money out', 'text-danger'),
(3, 'เงินเข้า', NULL, 'user', 'Incoming money', 'text-success'),
(4, 'เงินออก', NULL, 'user', 'Money out', 'text-danger'),
(5, 'รอเปิด', NULL, 'live', 'รอเปิด', 'text-info'),
(6, 'ปิด Live', NULL, 'live', 'ปิด Live', 'text-danger'),
(7, 'กำลังเล่น', NULL, 'live', 'กำลังเล่น', 'text-primary'),
(8, 'เปิดแล้ว', NULL, 'live', 'เปิดแล้ว', 'text-success'),
(9, 'ลงเดิมพัน', 'ลงเดิมพัน', 'live', 'ลงเดิมพัน', 'text-danger'),
(10, 'ชนะเดิมพัน', 'ชนะเดิมพัน', 'live', 'ชนะเดิมพัน', 'text-success');

-- --------------------------------------------------------

--
-- Table structure for table `usersigninlogs`
--

CREATE TABLE `usersigninlogs` (
  `USIG_ID` int NOT NULL,
  `USIG_created_at` timestamp NOT NULL,
  `USIG_datetime` timestamp NULL DEFAULT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `USIG_TOKEN` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `USIG_TYPE` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `USIG_IP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD KEY `member_1` (`user_agent`),
  ADD KEY `userId_2` (`userId`) USING BTREE;

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
  MODIFY `ac_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `banklists`
--
ALTER TABLE `banklists`
  MODIFY `blit_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `bank_statements`
--
ALTER TABLE `bank_statements`
  MODIFY `bstate_id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambling_histories`
--
ALTER TABLE `gambling_histories`
  MODIFY `gamb_ID` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamemasters`
--
ALTER TABLE `gamemasters`
  MODIFY `msID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gamerules`
--
ALTER TABLE `gamerules`
  MODIFY `grId` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `groupmemberlists`
--
ALTER TABLE `groupmemberlists`
  MODIFY `listId` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_lives`
--
ALTER TABLE `group_lives`
  MODIFY `groupLive_ID` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_live_card_opens`
--
ALTER TABLE `group_live_card_opens`
  MODIFY `glco_ID` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `howtoplay_m`
--
ALTER TABLE `howtoplay_m`
  MODIFY `htp_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lnvitelink`
--
ALTER TABLE `lnvitelink`
  MODIFY `LL_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logswebhook`
--
ALTER TABLE `logswebhook`
  MODIFY `lwb_id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_admins`
--
ALTER TABLE `log_admins`
  MODIFY `log_id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_statements`
--
ALTER TABLE `member_statements`
  MODIFY `statement_ID` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PAY_ID` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `signinlogs`
--
ALTER TABLE `signinlogs`
  MODIFY `sig_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usersigninlogs`
--
ALTER TABLE `usersigninlogs`
  MODIFY `USIG_ID` int NOT NULL AUTO_INCREMENT;

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
