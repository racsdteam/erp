-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 30, 2024 at 08:48 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `procurement`
--

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int NOT NULL,
  `code` varchar(8) NOT NULL,
  `currency` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `currency`) VALUES
(1, 'RWF', 'RWANDA FRANCS'),
(2, 'USD', 'US DOLLAR');

-- --------------------------------------------------------

--
-- Table structure for table `documents_settings`
--

CREATE TABLE `documents_settings` (
  `id` bigint NOT NULL,
  `name` varchar(256) NOT NULL,
  `code` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `section_code` varchar(8) NOT NULL,
  `params` text NOT NULL,
  `user_id` bigint NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `documents_settings`
--

INSERT INTO `documents_settings` (`id`, `name`, `code`, `section_code`, `params`, `user_id`, `timestamp`) VALUES
(1, 'Trading License ', 'TRLC', 'CODOC', '{\"is_required\":\"1\",\"more_docs_status\":\"0\",\"min_docs\":\"1\",\"max_docs\":\"1\"}', 2, '2024-05-02 10:33:03'),
(2, 'Social Security certificate', 'SSCT', 'CODOC', '{\"is_required\":\"1\",\"more_docs_status\":\"0\",\"min_docs\":\"1\",\"max_docs\":\"1\"}', 2, '2024-05-02 10:35:41'),
(3, 'Tax Clearance Certificate', 'TCCT', 'CODOC', '{\"is_required\":\"1\",\"more_docs_status\":\"0\",\"min_docs\":\"1\",\"max_docs\":\"1\"}', 2, '2024-05-02 10:36:32'),
(4, 'CV', 'CV', 'STAF', '{\"is_required\":\"1\",\"more_docs_status\":\"0\",\"min_docs\":\"1\",\"max_docs\":\"1\"}', 2, '2024-05-03 11:56:14'),
(5, 'DEGREE', 'DEGR', 'STAF', '{\"is_required\":\"1\",\"more_docs_status\":\"0\",\"min_docs\":\"1\",\"max_docs\":\"1\"}', 2, '2024-05-03 11:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `envelope_setttings`
--

CREATE TABLE `envelope_setttings` (
  `id` int NOT NULL,
  `name` varchar(1000) NOT NULL,
  `code` varchar(8) NOT NULL,
  `procurement_categories_code` text NOT NULL,
  `procurement_methods_code` text NOT NULL,
  `user_id` bigint NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `envelope_setttings`
--

INSERT INTO `envelope_setttings` (`id`, `name`, `code`, `procurement_categories_code`, `procurement_methods_code`, `user_id`, `timestamp`) VALUES
(1, 'OPEN COMPETITIVE BIDDING', 'OPCOBD', '[\"ICB\",\"NCB\"]', '[\"GD\",\"WRK\",\"CVS\"]', 2, '2024-02-19 12:56:53'),
(2, 'TECHNICAL BID CONSULTANCY ', 'TBCON', '[\"ICB\",\"NCB\",\"RT\"]', '[\"CNS\"]', 2, '2024-02-19 13:32:07'),
(3, 'FINANCIAL BID CONSULTANCY', 'FBCON', '[\"ICB\",\"NCB\",\"RT\"]', '[\"CNS\"]', 2, '2024-02-19 13:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funding_sources`
--

CREATE TABLE `funding_sources` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funding_sources`
--

INSERT INTO `funding_sources` (`id`, `name`, `code`, `description`) VALUES
(1, 'Ordinary Budget', 'OB', '');

-- --------------------------------------------------------

--
-- Table structure for table `incoterms_settings`
--

CREATE TABLE `incoterms_settings` (
  `id` int NOT NULL,
  `name` varchar(1000) NOT NULL,
  `code` varchar(8) NOT NULL,
  `description` text NOT NULL,
  `user_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `incoterms_settings`
--

INSERT INTO `incoterms_settings` (`id`, `name`, `code`, `description`, `user_id`, `timestamp`) VALUES
(1, 'CIP', 'CIP', 'CIP', 2, '2024-03-27 13:24:28'),
(2, 'ex-work', 'EXWK', 'ex-work', 2, '2024-03-27 13:25:46'),
(3, 'DDP', 'DDP', 'DDP', 2, '2024-03-27 13:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `procument_items`
--

CREATE TABLE `procument_items` (
  `id` bigint NOT NULL,
  `name` varchar(1000) NOT NULL,
  `types` json NOT NULL,
  `description` text NOT NULL,
  `user_id` bigint NOT NULL,
  `active` tinyint NOT NULL,
  `timestamp` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `procurement_activities`
--

CREATE TABLE `procurement_activities` (
  `id` int NOT NULL,
  `planId` int NOT NULL,
  `end_user_org_unit` int NOT NULL,
  `description` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `procurement_category` varchar(11) NOT NULL,
  `procurement_method` varchar(11) NOT NULL,
  `estimate_cost` varchar(255) NOT NULL,
  `funding_source` varchar(255) NOT NULL,
  `status` enum('Tendering','Planning','Publishing','Pending Approval','Approved','Completed') NOT NULL DEFAULT 'Planning',
  `user` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_activities`
--

INSERT INTO `procurement_activities` (`id`, `planId`, `end_user_org_unit`, `description`, `code`, `procurement_category`, `procurement_method`, `estimate_cost`, `funding_source`, `status`, `user`, `created`, `updated`) VALUES
(1, 1, 37, 'Supply of marshalling wands, aerolaser handheld  bird scaring,Marshaling lighting gloves,  12 G Bird scaring cartridge, Wands batteries and  its charger and bird scaring laser batteris. ', 'GD-2023-001', 'GD', 'NCB', '123,444', 'OB', 'Approved', 1, '2023-05-29 12:25:52', '2023-06-08 14:06:35'),
(2, 1, 12, 'Airspace modernisation to integrate recreational flyers, drone, classification, new reference points and upper routes ', 'WRK-2023-001', 'WRK', 'ICB', '1,244,566', 'OB', 'Approved', 1, '2023-05-30 14:44:51', '2023-06-08 14:06:35'),
(4, 1, 37, 'Provision of External financial audit & compliance ', 'CNS-2023-001', 'CNS', 'ICB', '123,444', 'OB', 'Approved', 1, '2023-05-30 14:46:58', '2023-06-08 14:06:35'),
(5, 1, 15, 'Other service', 'CVS-2023-001', 'CVS', 'RFQ', '123,444', 'OB', 'Approved', 1, '2023-05-30 14:54:02', '2023-06-08 14:06:35'),
(6, 1, 21, 'Provision of airport consultancy services for design and Supervision', 'CNS-2023-002', 'CNS', 'ICB', '123,444', 'OB', 'Approved', 1, '2023-06-05 08:56:06', '2023-06-08 14:06:35'),
(7, 4, 37, 'jhbvihvih', 'GD-2024-001', 'WRK', 'NCB', '55,776', 'OB', 'Planning', 2, '2024-01-08 10:11:43', '2024-01-08 08:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_activity_dates`
--

CREATE TABLE `procurement_activity_dates` (
  `id` int NOT NULL,
  `activity` int NOT NULL,
  `date_type` varchar(11) NOT NULL,
  `planned_date` date NOT NULL,
  `actual_date` datetime DEFAULT NULL,
  `sequence` int NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_activity_dates`
--

INSERT INTO `procurement_activity_dates` (`id`, `activity`, `date_type`, `planned_date`, `actual_date`, `sequence`, `created`, `updated`, `user`) VALUES
(1, 1, 'RSTES', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(2, 1, 'PTDP', '2023-05-30', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(3, 1, 'PPD', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(4, 1, 'POBD', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(5, 1, 'PPND', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(6, 1, 'PCSD', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(8, 1, 'PCMSD', '2023-05-29', NULL, 1, '2023-05-29 12:25:52', '2023-06-05 06:56:55', 1),
(10, 1, 'RSF', '2023-05-30', NULL, 1, '2023-05-30 14:12:59', '2023-06-05 06:56:55', 1),
(11, 3, 'RSTES', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(12, 3, 'PTDP', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(13, 3, 'PPD', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(14, 3, 'POBD', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(15, 3, 'PPND', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(16, 3, 'PCSD', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(17, 3, 'RSF', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(18, 3, 'PCMSD', '2023-05-30', NULL, 1, '2023-05-30 14:45:58', '2023-05-30 12:45:58', 1),
(19, 4, 'RSTES', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(20, 4, 'PTDP', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(21, 4, 'PPD', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(22, 4, 'POBD', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(23, 4, 'PPND', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(24, 4, 'PCSD', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(25, 4, 'RSF', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(26, 4, 'PCMSD', '2023-05-30', NULL, 1, '2023-05-30 14:46:58', '2023-06-05 06:54:39', 1),
(27, 2, 'RSTES', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(28, 2, 'PTDP', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(29, 2, 'PPD', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(30, 2, 'POBD', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(31, 2, 'PPND', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(32, 2, 'PCSD', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(33, 2, 'RSF', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(34, 2, 'PCMSD', '2023-05-30', NULL, 1, '2023-05-30 14:48:35', '2023-06-05 06:56:29', 1),
(35, 5, 'RSTES', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(36, 5, 'PTDP', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(37, 5, 'PPD', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(38, 5, 'POBD', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(39, 5, 'PPND', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(40, 5, 'PCSD', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(41, 5, 'RSF', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(42, 5, 'PCMSD', '2023-05-30', NULL, 1, '2023-05-30 14:54:02', '2023-05-30 12:54:02', 1),
(43, 6, 'RSTES', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(44, 6, 'PTDP', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(45, 6, 'PPD', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(46, 6, 'POBD', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(47, 6, 'PPND', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(48, 6, 'PCSD', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(49, 6, 'RSF', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(50, 6, 'PCMSD', '2023-06-05', NULL, 1, '2023-06-05 08:56:06', '2023-06-05 06:56:06', 1),
(51, 7, 'RSTES', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(52, 7, 'PTDP', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(53, 7, 'PPD', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(54, 7, 'POBD', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(55, 7, 'PPND', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(56, 7, 'PCSD', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(57, 7, 'RSF', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2),
(58, 7, 'PCMSD', '2024-01-08', NULL, 1, '2024-01-08 10:11:43', '2024-01-08 08:11:43', 2);

-- --------------------------------------------------------

--
-- Table structure for table `procurement_activity_items`
--

CREATE TABLE `procurement_activity_items` (
  `id` int NOT NULL,
  `activity_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `quantity` decimal(9,2) NOT NULL,
  `unity` decimal(9,2) NOT NULL,
  `unit_price` decimal(9,2) NOT NULL,
  `total_price` decimal(9,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `procurement_categories`
--

CREATE TABLE `procurement_categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text NOT NULL,
  `display_order` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_categories`
--

INSERT INTO `procurement_categories` (`id`, `name`, `code`, `description`, `display_order`) VALUES
(1, 'Goods', 'GD', 'All items, supplies, materials, equipment and furniture, computer, IT and telecommunications equipment; software, office supplies; household appliances and furniture', 1),
(2, 'Works', 'WRK', 'Infrastructure projects to construct, improve, rehabilitate, demolish, repair, restore, or maintain buildings,roads and bridges', 2),
(3, 'Other Services', 'CVS', 'Intellectual and non-intellectual services not covered under goods and works', 4),
(4, 'Consultancy Services', 'CNS', 'test', 3);

-- --------------------------------------------------------

--
-- Table structure for table `procurement_date_types`
--

CREATE TABLE `procurement_date_types` (
  `id` int NOT NULL,
  `code` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `description` text,
  `active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_date_types`
--

INSERT INTO `procurement_date_types` (`id`, `code`, `name`, `report_name`, `description`, `active`) VALUES
(1, 'RSTES', 'Requisition and Submission of ToR/Technical specs ', 'Requisition and Submission of ToR/Technical specs from end user', '', 1),
(2, 'PTDP', 'Planned Tender Document Preparation Date', 'Planned Tender Document Preparation Date', '', 1),
(3, 'PPD', 'Planned Publication Date', 'Planned Publication Date', '', 1),
(4, 'POBD', 'Planned Opening Bid Date', 'Planned Opening Bid Date', '', 1),
(5, 'PPND', 'Planned Provisional Notification Date', 'Planned Provisional Notification Date', '', 1),
(6, 'PCSD', 'Planned Contract Signing Date', 'Planned Contract Signing Date', '', 1),
(7, 'RSF', 'Recruitement of the supervising Firm', 'Recruitement of the supervising Firm', '', 1),
(8, 'PCMSD', 'Planned Contract Management start Date', 'Planned Contract Management start Date', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `procurement_methods`
--

CREATE TABLE `procurement_methods` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_methods`
--

INSERT INTO `procurement_methods` (`id`, `name`, `code`, `description`) VALUES
(1, 'International competitive bidding', 'INCB', 'Procurement procedure where tendering is open to\r\nall local or international legal entities interested to submit a tender.'),
(2, 'National Competitive Bidding', 'NACB', 'procurement method which is open to participation on equal terms by all providers through advertisement of the procurement opportunity in the national widely read newspapers'),
(3, 'Restricted Tendering', 'RSDT', 'Tendering process by direct invitation to a shortlist of\r\npre-qualified, pre-registered or known suppliers,'),
(4, 'Request for Quotations', 'RFQU', 'Procurement method based on comparing price quotations obtained from\r\nseveral national suppliers, usually at least three to ensure competitive prices'),
(5, 'Community participation', 'COPA', 'This method is used for executing small labor intensive works where the objective is to:\r\nProvide employment and income directly to persons living in the project area.'),
(6, 'Direct Purchase', 'DIPU', 'Items whose value does not exceed 1,000,000 Rwf shall be procured through direct purchasing. For such goods, payments shall be done without going through tendering process and tender committee approvals'),
(7, 'Single Source', 'SNSR', 'Single source procurement from a supplier without competition'),
(8, 'Quality and Cost Based Selections', 'QCBS', 'QCBS uses a competitive process among shortlisted firms that takes into account the quality of\r\nthe proposals and the cost of the services in the selection of the successful firm.');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_plans`
--

CREATE TABLE `procurement_plans` (
  `id` int NOT NULL,
  `name` varchar(500) NOT NULL,
  `fiscal_year` varchar(255) NOT NULL,
  `status` enum('Pending Approval','Approved','Executing','Completed','Cancelled','Published','Planning') NOT NULL DEFAULT 'Planning',
  `user` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_plans`
--

INSERT INTO `procurement_plans` (`id`, `name`, `fiscal_year`, `status`, `user`, `created_at`, `updated_at`) VALUES
(1, 'RWANDA AIRPORTS COMPANY ANNUAL PROCUREMENT PLAN FOR FINANCIAL YEAR 2022-2023', '2022-2023', 'Approved', 1, '2023-05-18 12:51:32', '2023-06-08 14:06:35'),
(2, 'demo', '2022-2023', 'Planning', 62, '2023-06-08 14:51:10', '2023-06-08 14:51:10'),
(3, 'Procurement_Plan_FY_2022-2023', '2022-2023', 'Planning', 1, '2023-06-12 12:16:03', '2023-06-12 12:16:03'),
(4, 'test', '2023-2024', 'Planning', 2, '2024-01-08 10:07:21', '2024-01-08 10:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_plan_approvals`
--

CREATE TABLE `procurement_plan_approvals` (
  `id` int NOT NULL,
  `wfInstance` int NOT NULL,
  `wfStep` int NOT NULL,
  `request` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `assigned_to` int DEFAULT NULL COMMENT 'actual assignee',
  `on_behalf_of` int DEFAULT NULL,
  `assigned_from` int DEFAULT NULL,
  `action_required` enum('Approval','Review','FYI','Update','Stamping') DEFAULT NULL,
  `status` enum('pending','completed','acknowledged') NOT NULL DEFAULT 'pending',
  `outcome` enum('approved','rejected','reassigned','reviewed','change requested','resubmitted','verified','Certified','stamped','archived') DEFAULT NULL,
  `is_new` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_plan_approvals`
--

INSERT INTO `procurement_plan_approvals` (`id`, `wfInstance`, `wfStep`, `request`, `name`, `description`, `assigned_to`, `on_behalf_of`, `assigned_from`, `action_required`, `status`, `outcome`, `is_new`, `created_at`, `started_at`, `completed_at`) VALUES
(1, 32, 270, 1, 'Procurement Plan Approval', '', 1, NULL, NULL, 'Approval', 'completed', 'approved', 1, '2023-06-07 13:37:47', '2023-06-08 16:06:31', '2023-06-08 16:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_plan_approval_annotations`
--

CREATE TABLE `procurement_plan_approval_annotations` (
  `id` int NOT NULL,
  `doc` bigint NOT NULL,
  `type` varchar(256) NOT NULL,
  `annotation` longtext NOT NULL,
  `annotation_id` varchar(255) DEFAULT NULL,
  `author` int DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_plan_approval_annotations`
--

INSERT INTO `procurement_plan_approval_annotations` (`id`, `doc`, `type`, `annotation`, `annotation_id`, `author`, `timestamp`) VALUES
(2, 1, 'Signature', '<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<xfdf xmlns=\"http://ns.adobe.com/xfdf/\" xml:space=\"preserve\">\n<fields />\n<add />\n<modify><stamp page=\"0\" rect=\"128.41,144.6900000000001,263.20000000000005,202.36134328358185\" flags=\"print\" name=\"5c6aeb08-d936-d891-6517-94d5061e4263\" title=\"Norbert Niyonizera /Software Engineer\" subject=\"Stamp\" date=\"D:20230616095644+02\'00\'\" creationdate=\"D:20230608153152+02\'00\'\" icon=\"Draft\"><imagedata>data:image/png;base64,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</imagedata></stamp></modify>\n<delete />\n</xfdf>', '5c6aeb08-d936-d891-6517-94d5061e4263', 1, '2023-06-08 13:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_plan_approval_comments`
--

CREATE TABLE `procurement_plan_approval_comments` (
  `id` int NOT NULL,
  `wfInstance` int NOT NULL,
  `wfStep` int DEFAULT NULL,
  `request` int NOT NULL,
  `comment` text NOT NULL,
  `scope` enum('W','T') NOT NULL DEFAULT 'W',
  `user` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement_plan_approval_comments`
--

INSERT INTO `procurement_plan_approval_comments` (`id`, `wfInstance`, `wfStep`, `request`, `comment`, `scope`, `user`, `timestamp`) VALUES
(1, 32, NULL, 1, 'test', 'W', 1, '2023-06-07 13:37:47'),
(2, 32, 270, 1, 'ok', 'T', 1, '2023-06-08 13:37:06'),
(3, 32, 270, 1, 'ok', 'T', 1, '2023-06-08 13:41:33'),
(4, 32, 270, 1, 'ok', 'T', 1, '2023-06-08 13:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `section_settings`
--

CREATE TABLE `section_settings` (
  `id` int NOT NULL,
  `name` varchar(1000) NOT NULL,
  `code` varchar(8) NOT NULL,
  `envelope_code` text NOT NULL,
  `is_staffing` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_settings`
--

INSERT INTO `section_settings` (`id`, `name`, `code`, `envelope_code`, `is_staffing`, `user_id`, `timestamp`) VALUES
(1, 'COMPANY DOCUMENTS', 'CODOC', '[\"OPCOBD\",\"TBCON\"]', 0, 2, '2024-02-19 14:09:28'),
(2, 'TECHNICAL SECTION', 'TECSEC', '[\"OPCOBD\",\"TBCON\"]', 0, 2, '2024-03-20 10:46:14'),
(3, 'FINANCIAL SECTION', 'FINSEC', '[\"OPCOBD\",\"FBCON\"]', 0, 2, '2024-04-24 16:08:32'),
(4, 'STAFFS', 'STAF', '[\"TBCON\"]', 1, 2, '2024-05-03 08:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `tender_document_settings`
--

CREATE TABLE `tender_document_settings` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tender_item_types_settings`
--

CREATE TABLE `tender_item_types_settings` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `code` varchar(8) NOT NULL,
  `description` mediumtext NOT NULL,
  `user_id` bigint NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tender_item_types_settings`
--

INSERT INTO `tender_item_types_settings` (`id`, `name`, `code`, `description`, `user_id`, `timestamp`) VALUES
(1, 'Goods', 'GOD', 'Goods and materials', 2, '2024-03-27 13:08:47'),
(2, 'Sercice', 'SERVC', 'Service', 2, '2024-03-27 13:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `tender_notice_types`
--

CREATE TABLE `tender_notice_types` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tender_opening_stettings`
--

CREATE TABLE `tender_opening_stettings` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `validation` text NOT NULL,
  `user_id` int NOT NULL,
  `timestamp` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tender_settings`
--

CREATE TABLE `tender_settings` (
  `id` int NOT NULL,
  `tender` int NOT NULL,
  `access_after_deadline` tinyint NOT NULL,
  `submit_after_deadline` tinyint NOT NULL,
  `payment_mode` enum('offline','online') NOT NULL,
  `tender_currency` enum('RWF','USD') NOT NULL,
  `lock_box` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tender_stages`
--

CREATE TABLE `tender_stages` (
  `id` int NOT NULL,
  `Name` varchar(256) NOT NULL,
  `code` varchar(8) NOT NULL,
  `procurement_methods_code` tinytext NOT NULL,
  `procurement_categories_code` tinytext NOT NULL,
  `user_id` bigint NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender_stages`
--

INSERT INTO `tender_stages` (`id`, `Name`, `code`, `procurement_methods_code`, `procurement_categories_code`, `user_id`, `is_active`, `timestamp`) VALUES
(1, 'International and National bidding ', 'IANB', '[\"GD\",\"WRK\",\"CVS\",\"CNS\"]', '[\"ICB\",\"NCB\",\"QCBS\"]', 2, 1, '2024-02-09 10:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `tender_stage_sequence_settings`
--

CREATE TABLE `tender_stage_sequence_settings` (
  `id` int NOT NULL,
  `tender_stage_code` varchar(8) NOT NULL,
  `tender_stage_setting_code` varchar(8) NOT NULL,
  `sequence_number` int NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `user_id` bigint NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender_stage_sequence_settings`
--

INSERT INTO `tender_stage_sequence_settings` (`id`, `tender_stage_code`, `tender_stage_setting_code`, `sequence_number`, `is_active`, `user_id`, `timestamp`) VALUES
(1, 'IANB', 'PUBL', 1, 1, 2, '2024-02-13 14:28:54'),
(2, 'IANB', 'BID', 2, 1, 2, '2024-02-13 15:05:30'),
(5, 'IANB', 'OPNTC', 3, 1, 2, '2024-02-14 10:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `tender_stage_settings`
--

CREATE TABLE `tender_stage_settings` (
  `id` int NOT NULL,
  `name` varchar(1000) NOT NULL,
  `code` varchar(8) NOT NULL,
  `min_period` int NOT NULL,
  `max_period` int NOT NULL,
  `stage_outcome` varchar(1000) NOT NULL,
  `color_code` varchar(256) NOT NULL,
  `in_charge` enum('ITC','PROCUREMNET','BIDDER') NOT NULL,
  `params` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `user_id` bigint NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender_stage_settings`
--

INSERT INTO `tender_stage_settings` (`id`, `name`, `code`, `min_period`, `max_period`, `stage_outcome`, `color_code`, `in_charge`, `params`, `user_id`, `timestamp`) VALUES
(1, 'PUBLICATION', 'PUBL', 5, 21, 'PUBLICATION NOTICE', '#f1c232', 'PROCUREMNET', '{\"type\":\"OTHER\",\"bid_section\":\"N/A\"}', 2, '2024-03-12 12:33:19'),
(2, 'OPENING FOR NOT CONSULTANCY SERVICES', 'OPNTC', 1, 1, 'OPENING REPORT', '#00ff00', 'ITC', NULL, 2, '2024-03-12 08:47:35'),
(3, 'BIDDING ', 'BID', 21, 21, 'BID DOCUMENT', '#ff9900', 'BIDDER', NULL, 2, '2024-03-12 08:47:39'),
(4, 'TECHNICAL AND FINACIAL EVALUATION', 'EVA', 1, 14, 'EVALUATION REPORT', '#ff0000', 'ITC', '{\"type\":\"EVALUATION\",\"bid_section\":\"TECHNICAL & FINANCIAL\"}', 2, '2024-03-12 12:36:37'),
(5, 'NEGOTIATION', 'NGT', 1, 7, 'NEGOTIATION Report', '#3c78d8', 'ITC', NULL, 2, '2024-03-12 08:47:45'),
(6, 'BID AWARED NOTIFICATION', 'BANTF', 1, 5, 'NOTIFICATION LETTER', '#c27ba0', 'PROCUREMNET', '{\"type\":\"NOTICE\",\"bid_section\":\"N/A\"}', 2, '2024-03-12 12:41:34'),
(7, 'REQUEST FOR QUOTATION', 'RFQ', 1, 14, 'REQUEST FOR QUOTATION', '#93c47d', 'ITC', NULL, 2, '2024-03-12 08:47:51'),
(8, 'BID REJECTION NOTIFICATION', 'BRNTF', 1, 4, 'REJECTED NOTIFICATION', '#e06666', 'PROCUREMNET', '{\"type\":\"NOTICE\",\"bid_section\":\"N/A\",\"template\":\"uploads/procurement/templates/202403120103057574.docx\"}', 2, '2024-03-12 13:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `tender_statuses`
--

CREATE TABLE `tender_statuses` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tender_status_details`
--

CREATE TABLE `tender_status_details` (
  `id` int NOT NULL,
  `tender` int NOT NULL,
  `status` varchar(11) NOT NULL,
  ` status_update_date` datetime NOT NULL,
  `user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_settings`
--
ALTER TABLE `documents_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `envelope_setttings`
--
ALTER TABLE `envelope_setttings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `funding_sources`
--
ALTER TABLE `funding_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `incoterms_settings`
--
ALTER TABLE `incoterms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `procument_items`
--
ALTER TABLE `procument_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurement_activities`
--
ALTER TABLE `procurement_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `planId` (`planId`),
  ADD KEY `procurement_method` (`procurement_method`),
  ADD KEY `funding_sources` (`funding_source`),
  ADD KEY `procurement_category` (`procurement_category`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `procurement_activity_dates`
--
ALTER TABLE `procurement_activity_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package` (`activity`);

--
-- Indexes for table `procurement_activity_items`
--
ALTER TABLE `procurement_activity_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurement_categories`
--
ALTER TABLE `procurement_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `procurement_date_types`
--
ALTER TABLE `procurement_date_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurement_methods`
--
ALTER TABLE `procurement_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `procurement_plans`
--
ALTER TABLE `procurement_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `procurement_plan_approvals`
--
ALTER TABLE `procurement_plan_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wfInstance` (`wfInstance`),
  ADD KEY `leave_approval_task_instances_ibfk_1` (`wfStep`);

--
-- Indexes for table `procurement_plan_approval_annotations`
--
ALTER TABLE `procurement_plan_approval_annotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurement_plan_approval_comments`
--
ALTER TABLE `procurement_plan_approval_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wfInstance` (`wfInstance`);

--
-- Indexes for table `section_settings`
--
ALTER TABLE `section_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_document_settings`
--
ALTER TABLE `tender_document_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_item_types_settings`
--
ALTER TABLE `tender_item_types_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_notice_types`
--
ALTER TABLE `tender_notice_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_opening_stettings`
--
ALTER TABLE `tender_opening_stettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_settings`
--
ALTER TABLE `tender_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_stages`
--
ALTER TABLE `tender_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_stage_sequence_settings`
--
ALTER TABLE `tender_stage_sequence_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_stage_settings`
--
ALTER TABLE `tender_stage_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `color_code` (`color_code`);

--
-- Indexes for table `tender_statuses`
--
ALTER TABLE `tender_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_status_details`
--
ALTER TABLE `tender_status_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents_settings`
--
ALTER TABLE `documents_settings`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `envelope_setttings`
--
ALTER TABLE `envelope_setttings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funding_sources`
--
ALTER TABLE `funding_sources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `incoterms_settings`
--
ALTER TABLE `incoterms_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procument_items`
--
ALTER TABLE `procument_items`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procurement_activities`
--
ALTER TABLE `procurement_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `procurement_activity_dates`
--
ALTER TABLE `procurement_activity_dates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `procurement_activity_items`
--
ALTER TABLE `procurement_activity_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procurement_categories`
--
ALTER TABLE `procurement_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `procurement_date_types`
--
ALTER TABLE `procurement_date_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `procurement_methods`
--
ALTER TABLE `procurement_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `procurement_plans`
--
ALTER TABLE `procurement_plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `procurement_plan_approvals`
--
ALTER TABLE `procurement_plan_approvals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `procurement_plan_approval_annotations`
--
ALTER TABLE `procurement_plan_approval_annotations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `procurement_plan_approval_comments`
--
ALTER TABLE `procurement_plan_approval_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `section_settings`
--
ALTER TABLE `section_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tender_document_settings`
--
ALTER TABLE `tender_document_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tender_item_types_settings`
--
ALTER TABLE `tender_item_types_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tender_notice_types`
--
ALTER TABLE `tender_notice_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tender_opening_stettings`
--
ALTER TABLE `tender_opening_stettings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tender_settings`
--
ALTER TABLE `tender_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tender_stages`
--
ALTER TABLE `tender_stages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tender_stage_sequence_settings`
--
ALTER TABLE `tender_stage_sequence_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tender_stage_settings`
--
ALTER TABLE `tender_stage_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tender_statuses`
--
ALTER TABLE `tender_statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tender_status_details`
--
ALTER TABLE `tender_status_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
