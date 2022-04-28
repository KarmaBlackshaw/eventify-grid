-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 08:20 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_level_id` int(11) NOT NULL,
  `activation_code` varchar(10) NOT NULL,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `account_img_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `username`, `password`, `user_level_id`, `activation_code`, `activated`, `account_img_url`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'admin', '$2y$10$HlSo6.6oW6t1IgSoSCY8geqjjT5DN11434laKHbuKkGl11WjXm7xG', 6, '12345678', 1, '', '2018-10-22 06:13:35', '2018-11-02 14:22:07', 0),
(2, 'plant', '$2y$10$N7hHHk.8g7OYULavnx0S..LBaM70tpmXr/qTkZ33I9i9Pan7mMdg.', 2, '987987', 1, 'images/male.png', '2018-10-26 16:31:16', '2018-11-20 21:10:53', 0),
(6, '', '', 5, '3', 0, '', '2018-10-26 07:33:54', '2018-10-26 07:35:25', 0),
(7, 'uy', '$2y$10$tPfFRt7AT8GcY3d4c1.UfOTwMu2P9aUOJu0ODlOIG/chtrR64VjCC', 5, '123', 1, '', '2018-10-26 07:37:38', '2018-10-28 05:39:30', 0),
(8, '', '', 5, '91', 0, '', '2018-10-26 07:37:38', '0000-00-00 00:00:00', 0),
(61, '', '', 5, '99b18b06b2', 0, 'images/male.png', '2018-11-02 10:03:15', '0000-00-00 00:00:00', 0),
(62, '', '', 5, '3543a816a8', 0, 'images/male.png', '2018-11-02 10:04:30', '0000-00-00 00:00:00', 0),
(63, 'yel', '$2y$10$1hgg0IJUYYoLw8Lt..KVNe1RdzG8M/SX2W0DHIXD9YBYJ1tsJ1iP6', 5, '07c3179fe2', 0, 'images/female.png', '2018-11-02 10:06:52', '2018-11-02 10:22:29', 0),
(64, 'col', '$2y$10$xYuiFWbesgYe.WPv2siC4uRGARVWd.9a3ZU.DVftvuFrLKodVSTam', 5, 'eaf759db2d', 1, 'images/male.png', '2018-11-02 14:56:56', '2018-11-02 14:58:13', 0),
(65, '', '', 5, '3e13cc3056', 0, 'images/male.png', '2018-11-02 15:04:35', '0000-00-00 00:00:00', 0),
(66, 'kent', '$2y$10$lkeG6A1aPDayWaP1rzAn0uDiuFX4nd89TPyTDs5muVbdJwthGJbeO', 5, 'aee2e28f58', 1, 'images/male.png', '2018-11-03 13:37:18', '2018-11-28 01:05:04', 0),
(67, 'ting', '$2y$10$9yr5Bdf6qOUSYHVfLKhlP.PV32FSruRsglV7Iv7PhiGd3/Mu/bAVm', 5, 'ccc017fa3e', 1, 'images/male.png', '2018-11-03 13:55:31', '2018-11-03 13:56:45', 0),
(68, 'mis', '$2y$10$9n81GW9kId0TZPONhSbi/OD0myk8tnlK7EiSl76FnUjcT9KGI8P6S', 2, 'qwerty', 1, 'images/female.png', '2018-11-07 04:13:58', '2018-11-07 04:27:37', 0),
(69, '', '', 5, 'dd423e9bba', 0, 'images/female.png', '2018-11-07 09:17:58', '0000-00-00 00:00:00', 0),
(70, '', '', 5, '667A0C3D9B', 0, 'images/male.png', '2018-11-07 09:21:37', '0000-00-00 00:00:00', 0),
(71, NULL, NULL, 5, '97283B8B01', 0, 'images/male.png', '2018-11-23 15:22:40', '0000-00-00 00:00:00', 0),
(72, NULL, NULL, 6, '6FDE97962C', 0, 'images/male.png', '2018-11-23 16:13:59', '2018-11-27 21:16:22', 1),
(73, NULL, NULL, 2, '78F536CE52', 0, 'images/male.png', '2018-11-23 16:36:36', '2018-11-27 03:14:08', 1),
(74, NULL, NULL, 2, '2F18BC638C', 0, 'images/female.png', '2018-11-23 16:48:03', '0000-00-00 00:00:00', 0),
(75, NULL, NULL, 2, '7B6776E0F2', 0, 'images/male.png', '2018-11-23 17:04:19', '0000-00-00 00:00:00', 0),
(76, NULL, NULL, 2, '21BE4AD5DB', 0, 'images/male.png', '2018-11-24 02:48:03', '0000-00-00 00:00:00', 0),
(77, 'mar', '$2y$10$p.zPDNBg9rePMvk1yFClyOsP93XwNFm1TGRDKrT3m8r1vSaf8M5Dm', 5, '358CE2C844', 1, 'images/male.png', '2018-11-27 06:07:48', '2018-11-27 06:11:56', 0),
(78, 'carl', '$2y$10$F.eqVyqNbEyD.NwRHGOhWeQi7EKeyQG/I9LdLv712XOMuq7y4eYHq', 5, '897590CFF9', 1, 'images/male.png', '2018-11-27 07:33:28', '2018-11-27 07:36:20', 0),
(79, NULL, NULL, 6, 'EC29DF2F1F', 0, 'images/male.png', '2018-11-27 21:37:18', '2018-11-27 21:47:05', 1),
(80, 'ssc', '$2y$10$bAnwBaDouN6YzZeiQfmZt.XGBAyl8TK/mwb.4kSD4/kL9KChGhDDa', 2, 'B6CA949037', 1, 'images/male.png', '2018-11-27 21:48:54', '2018-11-27 21:50:31', 0),
(81, NULL, NULL, 5, '5385987C60', 0, 'images/female.png', '2018-11-28 01:58:05', '0000-00-00 00:00:00', 0),
(82, NULL, NULL, 5, '5C5BD502C0', 0, 'images/female.png', '2018-11-28 02:06:55', '0000-00-00 00:00:00', 0),
(83, NULL, NULL, 5, '533384752F', 0, 'images/female.png', '2018-11-28 03:39:59', '0000-00-00 00:00:00', 0),
(84, NULL, NULL, 5, 'B73CE40758', 0, 'images/male.png', '2018-11-28 03:41:38', '0000-00-00 00:00:00', 0),
(85, NULL, NULL, 5, '4AA833FFEB', 0, 'images/male.png', '2018-11-28 05:00:01', '0000-00-00 00:00:00', 0),
(86, NULL, NULL, 5, '86B35AE406', 0, 'images/female.png', '2018-11-28 05:03:29', '0000-00-00 00:00:00', 0),
(87, NULL, NULL, 5, '871CE0128D', 0, 'images/male.png', '2018-11-28 05:08:54', '0000-00-00 00:00:00', 0),
(88, NULL, NULL, 5, 'C8358A8441', 0, 'images/male.png', '2018-11-28 05:43:55', '0000-00-00 00:00:00', 0),
(89, 'mark', '$2y$10$eqeiUXCAFxT4v5IGF/nB4evSEi9QfBExcEOC8YmEJna8FpxT0mrUu', 6, '5EB8D6A37A', 1, 'images/male.png', '2018-11-29 02:18:40', '2018-11-29 02:21:18', 0),
(90, NULL, NULL, 5, '6EA74F6B6F', 0, 'images/male.png', '2018-11-29 05:58:25', '0000-00-00 00:00:00', 0),
(91, NULL, NULL, 5, '728E007486', 0, 'images/male.png', '2018-11-29 06:30:57', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `approval_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`approval_id`, `event_id`, `approver_id`, `status`, `created_at`, `updated_at`, `removed`) VALUES
(1, 0, 0, 0, '2018-11-13 13:00:22', '2018-11-25 08:09:34', 0),
(2, 0, 0, 0, '2018-11-13 15:18:44', '0000-00-00 00:00:00', 0),
(3, 0, 0, 0, '2018-11-13 15:43:51', '0000-00-00 00:00:00', 0),
(4, 0, 0, 0, '2018-11-24 11:14:06', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `approvers`
--

CREATE TABLE `approvers` (
  `approver_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `archives`
--

CREATE TABLE `archives` (
  `archive_id` int(11) NOT NULL,
  `archive_name` varchar(100) NOT NULL,
  `directory` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `morning_in` time NOT NULL,
  `morning_out` time NOT NULL,
  `afternoon_in` time NOT NULL,
  `afternoon_out` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trails`
--

CREATE TABLE `audit_trails` (
  `audit_id` int(11) NOT NULL,
  `action` int(50) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `old_value` varchar(50) NOT NULL,
  `account_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `user_contact` varchar(20) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `user_contact`, `emergency_contact`, `created_at`, `updated_at`, `removed`) VALUES
(1, '987987', '98798798', '2018-10-22 06:16:59', '2018-10-26 18:22:47', 0),
(2, '654654654', '65465456', '2018-10-26 17:01:07', '0000-00-00 00:00:00', 0),
(3, '09756603613', '0987654321', '2018-10-26 07:15:05', '0000-00-00 00:00:00', 0),
(4, '9080980', '9809809', '2018-10-26 07:42:10', '2018-10-28 05:39:30', 0),
(5, '09234554321', '09234587654', '2018-10-26 07:42:10', '0000-00-00 00:00:00', 0),
(6, '56465', '546546', '2018-11-02 05:56:18', '0000-00-00 00:00:00', 0),
(7, '987', '9879', '2018-11-02 08:37:29', '0000-00-00 00:00:00', 0),
(8, '7987', '97987', '2018-11-02 08:39:18', '0000-00-00 00:00:00', 0),
(9, '09264566783', '465465', '2018-11-02 09:20:17', '0000-00-00 00:00:00', 0),
(10, '09264566783', '65464654', '2018-11-02 09:21:16', '0000-00-00 00:00:00', 0),
(11, '09264566783', '654654', '2018-11-02 09:27:01', '0000-00-00 00:00:00', 0),
(12, '09264566783', '654654', '2018-11-02 09:27:15', '0000-00-00 00:00:00', 0),
(13, '09264566783', '', '2018-11-02 09:30:30', '0000-00-00 00:00:00', 0),
(14, '09264566783', '', '2018-11-02 09:38:43', '0000-00-00 00:00:00', 0),
(15, '09264566783', '', '2018-11-02 09:39:59', '0000-00-00 00:00:00', 0),
(16, '09264566783', '79', '2018-11-02 09:41:10', '0000-00-00 00:00:00', 0),
(17, '09264566783', '56465', '2018-11-02 09:42:09', '0000-00-00 00:00:00', 0),
(18, '09264566783', '56465', '2018-11-02 09:43:18', '0000-00-00 00:00:00', 0),
(19, '09264566783', '', '2018-11-02 09:44:33', '0000-00-00 00:00:00', 0),
(20, '09264566783', '', '2018-11-02 09:47:39', '0000-00-00 00:00:00', 0),
(21, '09264566783', '564654', '2018-11-02 09:49:23', '0000-00-00 00:00:00', 0),
(22, '09264566783', '', '2018-11-02 09:50:55', '0000-00-00 00:00:00', 0),
(23, '09264566783', '', '2018-11-02 09:52:43', '0000-00-00 00:00:00', 0),
(24, '123', '1123', '2018-11-02 10:03:15', '0000-00-00 00:00:00', 0),
(25, '798', '798', '2018-11-02 10:04:30', '0000-00-00 00:00:00', 0),
(26, '09264566783', '546', '2018-11-02 10:06:52', '2018-11-02 10:19:34', 0),
(27, '09264566783', '', '2018-11-02 14:56:56', '0000-00-00 00:00:00', 0),
(28, '09264566783', '9879', '2018-11-02 15:04:35', '0000-00-00 00:00:00', 0),
(29, '09675066571', '6464', '2018-11-03 13:37:18', '0000-00-00 00:00:00', 0),
(30, '09451450602', '65132132', '2018-11-03 13:55:31', '0000-00-00 00:00:00', 0),
(31, '09264566783', '6546465465', '2018-11-07 09:17:58', '0000-00-00 00:00:00', 0),
(32, '09264566783', '', '2018-11-07 09:21:37', '0000-00-00 00:00:00', 0),
(33, '09264566783', '', '2018-11-23 15:22:40', '0000-00-00 00:00:00', 0),
(34, '123', '123', '2018-11-23 16:13:59', '0000-00-00 00:00:00', 0),
(35, '123', '123', '2018-11-23 16:36:36', '0000-00-00 00:00:00', 0),
(36, '09264566783', '', '2018-11-23 16:48:03', '0000-00-00 00:00:00', 0),
(37, '09264566783', '654', '2018-11-23 17:04:19', '0000-00-00 00:00:00', 0),
(38, '09264566783', '', '2018-11-24 02:48:03', '0000-00-00 00:00:00', 0),
(39, '098765431', '09876534567', '2018-11-27 06:07:47', '0000-00-00 00:00:00', 0),
(40, '09264566783', '09264566783', '2018-11-27 07:33:28', '0000-00-00 00:00:00', 0),
(41, '09264566783', '09264566783', '2018-11-27 21:37:18', '0000-00-00 00:00:00', 0),
(42, '09264566783', '567890', '2018-11-27 21:48:54', '0000-00-00 00:00:00', 0),
(43, '09675066571', '09876542347', '2018-11-28 01:58:05', '0000-00-00 00:00:00', 0),
(44, '09675066571', '98765423457', '2018-11-28 02:06:55', '0000-00-00 00:00:00', 0),
(45, '09264566783', '', '2018-11-28 03:39:59', '0000-00-00 00:00:00', 0),
(46, '09264566783', '567', '2018-11-28 03:41:38', '0000-00-00 00:00:00', 0),
(47, '09264566783', '5678', '2018-11-28 05:00:01', '0000-00-00 00:00:00', 0),
(48, '09264566783', '76', '2018-11-28 05:03:29', '0000-00-00 00:00:00', 0),
(49, '09269187', '98798', '2018-11-28 05:08:53', '0000-00-00 00:00:00', 0),
(50, '09264566783', '5678', '2018-11-28 05:43:55', '0000-00-00 00:00:00', 0),
(51, '09757591802', '09757591802', '2018-11-29 02:18:40', '0000-00-00 00:00:00', 0),
(52, '09554210264', '09554210264', '2018-11-29 05:58:25', '0000-00-00 00:00:00', 0),
(53, '09554210264', '09554210264', '2018-11-29 06:30:57', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `organization` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course`, `organization`, `department_id`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'Bachelor of Science in Informations Technology', 'DIGITS', 1, '2018-10-22 05:30:07', '2018-11-28 05:09:51', 0),
(2, 'Bachelor of Secondary Education', 'Mapeh Circle', 2, '2018-10-26 03:47:38', '2018-10-26 06:49:47', 0),
(3, 'Bachelor of Elementary Education', 'Circle of Future Educators', 2, '2018-10-26 03:47:38', '2018-10-26 06:50:34', 0),
(4, 'Bachelor of Arts in Communication', '', 1, '2018-10-26 03:59:19', '0000-00-00 00:00:00', 0),
(5, 'Bachelor of Science in Mathematics', '', 1, '2018-10-26 03:59:19', '0000-00-00 00:00:00', 0),
(6, 'Bachelor of Arts in Political Science', '', 1, '2018-10-26 04:12:17', '0000-00-00 00:00:00', 0),
(7, 'Bachelor of Arts in English', '', 1, '2018-10-26 04:12:17', '2018-11-07 15:25:04', 1),
(8, 'Bachelor of Science in Social Work', '', 1, '2018-10-26 04:14:58', '0000-00-00 00:00:00', 0),
(9, 'Bachelor of Science in Biology', '', 1, '2018-10-26 04:14:58', '0000-00-00 00:00:00', 0),
(10, 'BLIS', '', 1, '2018-10-26 04:22:02', '2018-11-07 15:25:34', 1),
(11, 'Bachelor of Science in Home Arts Entrepreneurship', '', 3, '2018-10-26 04:22:02', '2018-11-19 10:59:07', 0),
(12, 'Bachelor of Science in Tourism Hotel & Restaurant', 'Tourism Circle', 3, '2018-10-26 04:22:17', '2018-10-26 04:35:21', 0),
(13, 'BSIT', 'DIGITS', 1, '2018-11-08 08:07:55', '2018-11-08 08:09:20', 1),
(14, 'BSIT', 'DIGITS', 1, '2018-11-08 08:08:24', '2018-11-08 08:09:22', 1),
(15, 'bsit', 'ASDF', 1, '2018-11-08 08:09:34', '2018-11-08 08:10:25', 1),
(16, 'ASDF', 'ASDF', 1, '2018-11-08 08:10:19', '2018-11-08 08:10:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'College of Arts and Sciences', '2018-10-22 05:27:55', '2018-11-08 09:01:18', 0),
(2, 'College Of Education', '2018-10-22 05:28:02', '2018-11-24 05:49:39', 0),
(3, 'College of Management and Entrepreneurship', '2018-10-22 05:28:15', '0000-00-00 00:00:00', 0),
(4, 'College of Maths', '2018-11-08 08:23:44', '2018-11-08 09:06:31', 1),
(5, 'asdfasdf', '2018-11-08 08:24:07', '2018-11-08 09:06:29', 1),
(6, 'asdf', '2018-11-08 08:24:11', '2018-11-08 09:06:27', 1),
(7, 'asd', '2018-11-08 08:24:30', '2018-11-08 09:06:25', 1),
(8, 'asdfasdfd', '2018-11-08 08:24:54', '2018-11-08 09:06:23', 1),
(9, 'asdfasdfddsadasdasd', '2018-11-08 08:24:58', '2018-11-08 09:06:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employees_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `name_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employees_id`, `employee_id`, `name_id`, `position_id`, `contact_id`, `account_id`, `gender`, `signature`, `created_at`, `updated_at`) VALUES
(1, 123456, 2, 11, 1, 2, 'M', '', '2018-10-26 16:59:27', '2018-11-20 22:41:28'),
(2, 150000, 42, 13, 25, 68, 'F', '', '2018-11-07 04:14:47', '2018-11-07 04:15:22'),
(3, 231, 46, 14, 34, 72, 'M', '', '2018-11-23 16:13:59', '0000-00-00 00:00:00'),
(4, 123, 47, 15, 35, 73, 'M', '', '2018-11-23 16:36:36', '0000-00-00 00:00:00'),
(5, 1500065, 48, 16, 36, 74, 'F', '', '2018-11-23 16:48:03', '0000-00-00 00:00:00'),
(6, 15045785, 49, 17, 37, 75, 'M', 'images/mis/signatures/2018_11_24_01_04_4eb54d3b30672f10e43f9875762524f2.png', '2018-11-23 17:04:19', '0000-00-00 00:00:00'),
(7, 1523456, 50, 18, 38, 76, 'M', '', '2018-11-24 02:48:03', '0000-00-00 00:00:00'),
(8, 13000133, 53, 14, 41, 79, 'M', '', '2018-11-27 21:37:19', '0000-00-00 00:00:00'),
(9, 15001234, 54, 19, 42, 80, 'M', '', '2018-11-27 21:48:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event` varchar(100) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `attendance` tinyint(4) NOT NULL DEFAULT '0',
  `recipient_department` varchar(50) NOT NULL,
  `recipient_year_level` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `proposal` longtext NOT NULL,
  `requesting_party` varchar(100) NOT NULL,
  `date_of_use` text NOT NULL,
  `inclusive_time` varchar(50) NOT NULL,
  `event_img` varchar(255) DEFAULT 'images/ssc/event_default.jpeg',
  `reservation_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event`, `event_type_id`, `attendance`, `recipient_department`, `recipient_year_level`, `status`, `proposal`, `requesting_party`, `date_of_use`, `inclusive_time`, `event_img`, `reservation_id`, `created_at`, `updated_at`, `removed`) VALUES
(2, 'Mothers Day', 0, 0, '1,2,3', '1,2,3,4', 'finished', '&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;ol&gt;&lt;li&gt;Activity Title&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; The activity will be called Acquaintance Party 2018&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;ol&gt;&lt;li&gt;Description&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; As part of the university&amp;rsquo;s social and cultural convention, the Leyte Normal University &amp;ndash; Supreme Student Council (LNU-SSC) will spearhead this year&amp;rsquo;s ACQUAINTANCE PARTY bearing the theme &amp;nbsp;&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; This activity is designed for the students &amp;ndash; especially the freshmen, and the faculty and staff of the university to get acquainted with each other. This also gives occasion to all Normalistas to enjoy their stay in the university. In all, the event aims to build peace, love, and unity by fostering friendship and solidarity with others through the organized activities.&amp;nbsp;&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;ol style=&quot;margin-bottom:0in;&quot;&gt;&lt;li&gt;Rationale&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; To mark the opening of the school year, an educational institution holds an acquaintance party. As the word implies, this is a gathering of students from all recognized and accredited student organizations so that they could get to know each other better. Or if not, they could at least party together.&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; The LNU Acquaintance Party is an annual celebration spearheaded by the LNU-SSC. This serves as the gateway of developing camaraderie among students, faculty, and staff; and this is usually celebrated at the start of the school year between July and August. However, with the change of the Academic Calendar it will be celebrated this September.&lt;/p&gt;&lt;p style=&quot;text-align: justify;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; The theme for this year&amp;rsquo;s acquaintance party is _______________________________________. Although we can&amp;rsquo;t experience the benefit of gaining friends today, but in the long run it will help us a lot. Meanwhile, this year&amp;rsquo;s theme of clothing is _________________________ which suggests stiffness, elegance and formality for acquainting friends.&lt;/p&gt;&lt;p&gt;Objectives&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; The LNU University wide Acquaintance Party has the following specific objectives, wherein the students are expected to:&lt;/p&gt;&lt;ol&gt;&lt;li&gt;Cope with the environment including their classmates, teachers;&lt;/li&gt;&lt;li&gt;Build lasting peace and unity by fostering friendship and solidarity among students, faculty and staff;&lt;/li&gt;&lt;li&gt;Strengthen the rapport within their organization and to other organizations.&lt;/li&gt;&lt;/ol&gt;', 'Karma Blackshaw', '\'11-13-2018\', \'11-14-2018\'', '08:30%08:30', 'images/ssc/event_default.jpeg', 2, '2018-11-13 15:18:44', '2018-11-27 21:14:16', 0),
(3, 'Halloween', 0, 0, '1,2,3', '1,2,3,4', 'pending', '&lt;p&gt;ohoyyy&lt;/p&gt;', 'Karma Blackshaw', '\'11-01-2018\', \'11-02-2018\', \'11-03-2018\', \'11-04-2018\', \'11-05-2018\', \'11-06-2018\', \'11-07-2018\', \'11-08-2018\', \'11-09-2018\', \'11-10-2018\', \'11-11-2018\', \'11-12-2018\', \'11-13-2018\', \'11-14-2018\', \'11-15-2018\', \'11-16-2018\', \'11-17-2018\', \'11-18-2018\', \'11-19-2018\', \'11-20-2018\', \'11-21-2018\', \'11-22-2018\', \'11-23-2018\', \'11-24-2018\', \'11-25-2018\', \'11-26-2018\', \'11-27-2018\', \'11-28-2018\', \'11-29-2018\', \'11-30-2018\'', '08:00%10:00', 'images/ssc/event_default.jpeg', 3, '2018-11-13 15:43:51', '2018-11-27 21:14:16', 0),
(4, 'Birthday', 0, 0, '1,2,3', '1,2', 'finished', '&lt;p&gt;asd&lt;/p&gt;', 'asdasdasd', '\'11-25-2018\'', '01:00%02:01', 'images/ssc/event_default.jpeg', 4, '2018-11-24 11:14:06', '2018-11-27 21:14:16', 0),
(5, 'Intramurals', 0, 0, '2', '1', 'pending', '&lt;p&gt;dads&lt;/p&gt;', '123', '11-28-2018, 11-29-2018', '01:00%01:00', 'images/ssc/event_default.jpeg', 6, '2018-11-27 02:57:21', '2018-11-29 00:30:50', 0),
(6, 'Foundation Week', 0, 0, '1', '1,3', 'pending', '&lt;p&gt;aksdkjahsd&lt;/p&gt;', 'Heyyy', '12-28-2018, 12-29-2018, 12-30-2018, 12-31-2018', '01:00%01:00', 'images/ssc/event_default.jpeg', 7, '2018-11-27 02:59:36', '2018-11-29 00:31:22', 0),
(7, 'Acquaintance', 0, 0, '2', '1', 'pending', '&lt;p&gt;ahgdjahsd hi&lt;/p&gt;', 'jhgdfjhsdfsd', '11-28-2018, 11-29-2018', '01:00%01:00', 'images/ssc/event_default.jpeg', 8, '2018-11-27 03:00:26', '2018-11-29 00:31:29', 0),
(8, 'JS', 0, 0, '2', '1', 'pending', '&lt;p&gt;hi&lt;/p&gt;', 'delms', '11-27-2018, 11-28-2018, 11-29-2018', '%', 'images/ssc/event_default.jpeg', 9, '2018-11-27 03:02:39', '2018-11-29 00:31:44', 0),
(9, 'General Assembly', 0, 0, '2', '1', 'pending', '&lt;p&gt;hello&lt;/p&gt;', 'hi', '11-28-2018, 11-29-2018', '01:00%01:01', 'images/ssc/event_default.jpeg', 10, '2018-11-27 03:05:16', '2018-11-29 00:32:23', 0),
(10, 'Lead Camp', 0, 0, '1', '1,2,3,4', 'pending', '&lt;p&gt;yow yow yow&lt;/p&gt;', 'Kent Gilbert', '11-28-2018, 11-29-2018', '01:00%01:01', 'images/ssc/event_default.jpeg', 11, '2018-11-27 03:12:24', '2018-11-29 00:32:30', 0),
(11, 'Foundation', 0, 0, '1,2,3', '1,2,3,4', 'pending', '&lt;p&gt;fhdjvbmv mnsbjhvh&lt;/p&gt;&lt;p&gt;n cmvjhs&lt;/p&gt;&lt;p&gt;nvsvhsvav&lt;/p&gt;&lt;p&gt;nxvbjhf&lt;/p&gt;', 'Julie Malate', '03-06-2019, 03-07-2019, 03-08-2019, 03-09-2019, 03-10-2019', '09:00%17:00', 'images/ssc/event_default.jpeg', 12, '2018-11-27 05:53:36', '2018-11-27 21:14:17', 0),
(12, 'Valentines', 1, 0, '2', '2,3', 'pending', '&lt;p&gt;asdf&lt;/p&gt;', 'ernie jeash', '11-28-2018, 11-29-2018', '01:00%01:00', 'images/ssc/event_default.jpeg', 13, '2018-11-27 15:50:28', '2018-11-29 00:36:12', 0),
(13, 'asdfsdfasdfasdfasdf', 1, 1, '2', '2', 'pending', '&lt;p&gt;werwer&lt;/p&gt;', '234', '11-29-2018, 11-30-2018', '00:31%00:32', 'images/ssc/event_default.jpeg', 14, '2018-11-27 21:29:15', '2018-11-27 21:29:20', 0),
(14, 'Birthday ni Ernie', 3, 1, '1,2,3', '4', 'pending', '&lt;table style=&quot;width: 100%;&quot;&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kjasdf&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kjhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jhk&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;jh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kjh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kh&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kj&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;hkj&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;,aslkfshdfsdh kjshdkfj&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;hkjh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kjh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kjh&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;kj&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;h&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;td style=&quot;width: 10.0000%;&quot;&gt;&lt;br&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;', 'Karma Blackshaw', '11-30-2018, 12-01-2018', '08:00%13:00', 'images/ssc/event_default.jpeg', 15, '2018-11-29 02:14:17', '2018-11-29 02:14:21', 0),
(15, 'Intramurals2019', 3, 1, '1,2', '1,2,3,4', 'pending', '&lt;p&gt;EVENT PROPOSAL&lt;/p&gt;', 'SSC', '01-04-2019, 01-05-2019, 01-06-2019, 01-07-2019, 01-08-2019, 01-09-2019, 01-10-2019, 01-11-2019, 01-12-2019, 01-13-2019, 01-14-2019, 01-15-2019, 01-16-2019, 01-17-2019, 01-18-2019, 01-19-2019, 01-20-2019, 01-21-2019, 01-22-2019, 01-23-2019, 01-24-2019, 01-25-2019, 01-26-2019, 01-27-2019, 01-28-2019, 01-29-2019, 01-30-2019, 01-31-2019', '12:21%00:12', 'images/ssc/event_default.jpeg', 16, '2018-11-29 05:54:24', '2018-11-29 05:54:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `event_type_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`event_type_id`, `type`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'Contest', '2018-11-27 15:17:04', '0000-00-00 00:00:00', 0),
(2, 'Seminars', '2018-11-27 15:17:04', '0000-00-00 00:00:00', 0),
(3, 'Program', '2018-11-27 15:18:32', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL,
  `facility` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'Audio Systems', '2018-11-03 06:07:19', '2018-11-04 17:08:28', 0),
(2, 'Video Systems', '2018-11-03 06:07:19', '2018-11-04 17:37:18', 0),
(3, 'Lighting System/Fan', '2018-11-03 06:07:19', '2018-11-04 17:37:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `facility_items`
--

CREATE TABLE `facility_items` (
  `facility_item_id` int(11) NOT NULL,
  `item` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facility_items`
--

INSERT INTO `facility_items` (`facility_item_id`, `item`, `quantity`, `facility_id`, `img_url`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'Amplifier', 10, 1, 'images/plant_and_facilities/2018_11_04_01_18_91094d6c0116176a1c0b1e47c94d62fc.jpeg', '2018-10-26 07:58:51', '2018-11-04 17:57:49', 0),
(2, 'Speaker', 10, 1, 'images/plant_and_facilities/2018_11_04_01_19_c31d8b5521db9c254a6b53b3650055e5.jpeg', '2018-10-26 07:58:51', '2018-11-04 17:58:18', 0),
(3, 'Microphone', 10, 1, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 07:58:51', '2018-11-03 06:23:25', 0),
(4, 'Video Showing', 10, 2, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 08:00:21', '2018-11-03 06:23:37', 0),
(5, 'Video Editing', 10, 2, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 08:00:21', '2018-11-03 06:23:43', 0),
(6, 'Video Coverage', 12, 2, 'images/plant_and_facilities/2018_11_04_11_07_52a675bb0f6f648b6bdedc261c8687ba.jpg', '2018-10-26 08:00:21', '2018-11-27 14:58:02', 0),
(7, 'Follow Spot', 10, 3, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 08:01:28', '2018-11-03 06:23:54', 0),
(8, 'House Lights', 10, 3, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 08:01:28', '2018-11-03 06:24:00', 0),
(9, 'Electric Fans', 10, 3, 'images/plant_and_facilities/facilities/audio_visual.jpeg', '2018-10-26 08:01:28', '2018-11-03 06:24:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `names`
--

CREATE TABLE `names` (
  `name_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `names`
--

INSERT INTO `names` (`name_id`, `fname`, `mname`, `lname`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'Karma', 'Morningstar', 'Blackshaw', '2018-10-22 03:44:03', '0000-00-00 00:00:00', 0),
(2, 'Nestor', 'Chiquillo', 'Sedanza', '2018-10-26 16:29:39', '0000-00-00 00:00:00', 0),
(4, 'Marielle Mae', 'Bormate', 'Valdez', '2018-10-26 07:06:13', '0000-00-00 00:00:00', 0),
(5, 'Angela Mae  ', 'Lazarra', 'Ting', '2018-10-26 07:06:13', '0000-00-00 00:00:00', 0),
(6, 'Julie-Ann ', 'Cuervo', 'Malate', '2018-10-26 07:06:13', '0000-00-00 00:00:00', 0),
(7, 'Rochelle', 'Bormate', 'Degollacion', '2018-10-26 07:07:14', '0000-00-00 00:00:00', 0),
(8, 'Dr. Rommel ', 'L', 'Verecio', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(9, 'Las Johansen', 'Balios', 'Caluza', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(10, 'Jeffrey', 'C', 'Cinco', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(11, 'Devine Grace', 'D', 'Funcion', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(12, 'Mark Lester ', 'P', 'Laurente', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(13, 'Lowell', 'A', 'Quisumbing', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(14, 'Dennis', 'A', 'Tibe', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(15, 'Micheline', 'A', 'Gotardo', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(16, 'Jenny', 'A', 'Cinco', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(17, 'Raphy', 'A', 'Dalan', '2018-10-26 09:41:06', '0000-00-00 00:00:00', 0),
(18, '9879', '8798', '987', '2018-11-02 08:37:29', '0000-00-00 00:00:00', 0),
(19, '9879', '879', '879', '2018-11-02 08:39:18', '0000-00-00 00:00:00', 0),
(20, 'Karma', 'Morningstar', 'Akabane', '2018-11-02 09:20:17', '0000-00-00 00:00:00', 0),
(21, 'Karma', 'Morninstar', 'Akabane', '2018-11-02 09:21:16', '0000-00-00 00:00:00', 0),
(22, 'Irene', 'Chiquillo', 'Sejah', '2018-11-02 09:27:01', '0000-00-00 00:00:00', 0),
(23, 'Irene', 'Chiquillo', 'Sejah', '2018-11-02 09:27:15', '0000-00-00 00:00:00', 0),
(24, 'Marielle Mae', 'Bormate', 'Valdez', '2018-11-02 09:30:30', '0000-00-00 00:00:00', 0),
(25, 'jkjhlkj', 'hlkj', 'hlkjhl', '2018-11-02 09:38:43', '0000-00-00 00:00:00', 0),
(26, '6546', '5465465', '4654', '2018-11-02 09:39:58', '0000-00-00 00:00:00', 0),
(27, '8798', '7987', '9879', '2018-11-02 09:41:10', '0000-00-00 00:00:00', 0),
(28, '98798', '79879879', '87987', '2018-11-02 09:42:09', '0000-00-00 00:00:00', 0),
(29, '98798', '79879879', '87987', '2018-11-02 09:43:18', '0000-00-00 00:00:00', 0),
(30, 'Murasakibara', 'Blackshaw', 'Atsushi', '2018-11-02 09:44:33', '0000-00-00 00:00:00', 0),
(31, 'oiuoiuy', 'oiuyoiu', 'yoiuyoiuy', '2018-11-02 09:47:39', '0000-00-00 00:00:00', 0),
(32, '645654', '65465', '46546', '2018-11-02 09:49:23', '0000-00-00 00:00:00', 0),
(33, '65', '98989+', '9', '2018-11-02 09:50:55', '0000-00-00 00:00:00', 0),
(34, 'uihi', 'ouyu', 'oiuyoiu', '2018-11-02 09:52:43', '0000-00-00 00:00:00', 0),
(35, '2312', '312', '31231', '2018-11-02 10:03:14', '0000-00-00 00:00:00', 0),
(36, '987', '9879', '8798', '2018-11-02 10:04:30', '0000-00-00 00:00:00', 0),
(37, 'Marielle Mae', 'Bormate', 'Valdez', '2018-11-02 10:06:52', '0000-00-00 00:00:00', 0),
(38, 'Colin', 'Ulol', 'Ripalda', '2018-11-02 14:56:56', '0000-00-00 00:00:00', 0),
(39, 'Chen', 'Woong', 'Cipriano', '2018-11-02 15:04:35', '0000-00-00 00:00:00', 0),
(40, 'Kent', 'Gilbert', 'Gapud', '2018-11-03 13:37:18', '0000-00-00 00:00:00', 0),
(41, 'Keith', 'Lapesora', 'Agravante', '2018-11-03 13:55:31', '0000-00-00 00:00:00', 0),
(42, 'Lalaine', 'Lacoste', 'Llose', '2018-11-07 03:52:37', '0000-00-00 00:00:00', 0),
(43, 'Roshielle', 'Chiquillo', 'Nepomuceno', '2018-11-07 09:17:58', '0000-00-00 00:00:00', 0),
(44, 'Ramil', 'Cielo', 'Roca', '2018-11-07 09:21:37', '0000-00-00 00:00:00', 0),
(45, 'Jean', 'Moreto', 'Chiquillo', '2018-11-23 15:22:40', '0000-00-00 00:00:00', 0),
(46, '123', '123', '123', '2018-11-23 16:13:59', '0000-00-00 00:00:00', 0),
(47, '123', '123', '123', '2018-11-23 16:36:36', '0000-00-00 00:00:00', 0),
(48, 'Marielle', 'Mae', 'Bormate', '2018-11-23 16:48:03', '0000-00-00 00:00:00', 0),
(49, 'Las', 'Johansen', 'Caluza', '2018-11-23 17:04:19', '0000-00-00 00:00:00', 0),
(50, 'Ramil', 'Cielo', 'Roca', '2018-11-24 02:48:03', '0000-00-00 00:00:00', 0),
(51, 'marielle', 'maraksot', 'mahusay', '2018-11-27 06:07:47', '0000-00-00 00:00:00', 0),
(52, 'Carl', 'Daniel', 'Manas', '2018-11-27 07:33:28', '0000-00-00 00:00:00', 0),
(53, 'Orlando', 'Pinoy', 'Vincolado', '2018-11-27 21:37:18', '0000-00-00 00:00:00', 0),
(54, 'Orlando', 'Pinoy', 'Vincolado', '2018-11-27 21:48:54', '0000-00-00 00:00:00', 0),
(55, 'Maryan', 'Bormate', 'Mendano', '2018-11-28 01:58:05', '0000-00-00 00:00:00', 0),
(56, 'Mickee', 'Goco', 'Engao', '2018-11-28 02:06:55', '0000-00-00 00:00:00', 0),
(57, 'Julia Ann', 'Mae', 'Malate', '2018-11-28 03:39:59', '0000-00-00 00:00:00', 0),
(58, 'y', 'yty', 'tyt', '2018-11-28 03:41:38', '0000-00-00 00:00:00', 0),
(59, 'uy', 'uy', 'uy', '2018-11-28 05:00:00', '0000-00-00 00:00:00', 0),
(60, 'ernie', 'kj78', 'jeash', '2018-11-28 05:03:28', '0000-00-00 00:00:00', 0),
(61, 'uy', 'uy', 'uy', '2018-11-28 05:08:53', '0000-00-00 00:00:00', 0),
(62, 'uy', 'uy', 'uy', '2018-11-28 05:43:55', '0000-00-00 00:00:00', 0),
(63, 'Mark Vincent', 'Daganio', 'Parinas', '2018-11-29 02:18:40', '0000-00-00 00:00:00', 0),
(64, 'Reneth', 'Villamor', 'Garado', '2018-11-29 05:58:24', '0000-00-00 00:00:00', 0),
(65, 'Reneth', 'Villamor', 'Garado', '2018-11-29 06:30:56', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notifications_id` int(11) NOT NULL,
  `notification_type` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `account_id` int(20) NOT NULL,
  `viewed` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'CAS Office', '2018-10-21 18:31:05', '2018-11-22 16:16:54', 0),
(2, 'Chief of Admin-Admin Division', '2018-10-21 18:31:21', '0000-00-00 00:00:00', 0),
(3, 'Chief of Admin-Finance Division', '2018-10-21 18:31:32', '0000-00-00 00:00:00', 0),
(4, 'CME Office', '2018-10-21 18:31:43', '0000-00-00 00:00:00', 0),
(5, 'COE Office', '2018-10-21 18:31:52', '0000-00-00 00:00:00', 0),
(6, 'OSA Office', '2018-10-21 18:32:05', '0000-00-00 00:00:00', 0),
(7, 'University President', '2018-10-21 18:32:15', '0000-00-00 00:00:00', 0),
(8, 'Vice President for Academic Affairs\r\n                                    ', '2018-10-21 18:32:32', '0000-00-00 00:00:00', 0),
(9, 'Vice President for Admin and Finance', '2018-10-21 18:32:58', '2018-11-22 16:26:12', 1),
(10, 'Vice President for Research and Extension', '2018-10-21 18:33:13', '0000-00-00 00:00:00', 0),
(11, 'Management Information System', '2018-11-07 02:25:53', '0000-00-00 00:00:00', 0),
(12, 'Physical Plant and Facilities and Head of Janitorial Servicess', '2018-11-07 02:37:04', '2018-11-24 02:50:19', 0),
(13, 'SSC Office', '2018-11-20 23:17:16', '0000-00-00 00:00:00', 0),
(14, 'asdf', '2018-11-22 16:44:00', '2018-11-22 16:53:32', 1),
(15, '546', '2018-11-22 16:44:19', '2018-11-22 16:53:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `user_level_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position`, `office_id`, `user_level_id`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'President', NULL, 6, '2018-10-22 03:21:29', '2018-11-07 03:10:54', 0),
(2, 'Vice-President', NULL, 6, '2018-10-22 03:21:37', '2018-11-07 03:11:17', 0),
(3, 'Secretary', NULL, 6, '2018-10-22 03:21:44', '2018-11-07 03:11:17', 0),
(4, 'Treasurer', NULL, 6, '2018-10-22 03:21:50', '2018-11-07 03:11:17', 0),
(5, 'Auditor 1', NULL, 6, '2018-10-22 03:22:03', '2018-11-07 03:11:17', 0),
(6, 'Auditor 2', NULL, 6, '2018-10-22 03:22:13', '2018-11-07 03:11:17', 0),
(7, 'Public Information Officer', NULL, 6, '2018-10-22 03:22:22', '2018-11-07 03:11:17', 0),
(8, '4th Year Representative', NULL, 6, '2018-10-22 03:34:08', '2018-11-07 03:11:17', 0),
(9, '3rd Year Representatives', NULL, 6, '2018-10-22 03:34:18', '2018-11-07 03:11:17', 0),
(10, '2nd Year Representative', NULL, 6, '2018-10-22 03:34:26', '2018-11-07 03:11:17', 0),
(11, 'Director', 12, 2, '2018-10-26 15:33:53', '2018-11-07 03:23:02', 0),
(12, 'Dean', NULL, 2, '2018-10-27 06:38:42', '2018-11-07 03:23:08', 0),
(13, 'Director', 11, 2, '2018-11-07 03:23:45', '2018-11-07 03:24:43', 0),
(15, 'Wohoy', 1, 2, '2018-11-21 16:53:46', '0000-00-00 00:00:00', 0),
(16, 'asdf', 1, 2, '2018-11-21 16:54:51', '0000-00-00 00:00:00', 0),
(17, 'Teacher III', 1, 2, '2018-11-23 17:03:20', '0000-00-00 00:00:00', 0),
(18, 'Teacher I', 1, 2, '2018-11-24 02:47:43', '0000-00-00 00:00:00', 0),
(19, 'SSC Adviser', 13, 2, '2018-11-27 21:46:46', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `repercussions`
--

CREATE TABLE `repercussions` (
  `repercussion_id` int(11) NOT NULL,
  `repercussion` varchar(50) NOT NULL,
  `students_id` int(11) NOT NULL,
  `date_start` varchar(50) NOT NULL,
  `date_end` varchar(50) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `facility_item_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `facility_item_id`, `venue_id`, `created_at`, `updated_at`, `removed`) VALUES
(1, 0, 1, '2018-11-13 13:00:22', '0000-00-00 00:00:00', 0),
(2, 2, 1, '2018-11-13 15:18:44', '0000-00-00 00:00:00', 0),
(3, 1, 1, '2018-11-13 15:43:51', '0000-00-00 00:00:00', 0),
(4, 1, 15, '2018-11-24 11:14:06', '0000-00-00 00:00:00', 0),
(5, 2, 15, '2018-11-27 02:54:20', '0000-00-00 00:00:00', 0),
(6, 2, 9, '2018-11-27 02:57:21', '0000-00-00 00:00:00', 0),
(7, 2, 13, '2018-11-27 02:59:36', '0000-00-00 00:00:00', 0),
(8, 3, 14, '2018-11-27 03:00:26', '0000-00-00 00:00:00', 0),
(9, 1, 16, '2018-11-27 03:02:39', '0000-00-00 00:00:00', 0),
(10, 2, 14, '2018-11-27 03:05:16', '0000-00-00 00:00:00', 0),
(11, 1, 12, '2018-11-27 03:12:24', '0000-00-00 00:00:00', 0),
(12, 3, 1, '2018-11-27 05:53:36', '0000-00-00 00:00:00', 0),
(13, 1, 13, '2018-11-27 15:50:28', '0000-00-00 00:00:00', 0),
(14, 2, 13, '2018-11-27 21:29:15', '0000-00-00 00:00:00', 0),
(15, 1, 16, '2018-11-29 02:14:17', '0000-00-00 00:00:00', 0),
(16, 3, 15, '2018-11-29 05:54:24', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section`, `year_level`, `course_id`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'F4-4', 4, 1, '2018-10-22 05:31:54', '2018-11-08 09:01:09', 0),
(2, 'F4-3', 4, 1, '2018-11-08 06:05:03', '0000-00-00 00:00:00', 0),
(3, 'F1-1', 1, 1, '2018-11-08 06:06:33', '0000-00-00 00:00:00', 0),
(4, 'F2-4', 2, 1, '2018-11-08 06:07:04', '0000-00-00 00:00:00', 0),
(5, 'F2-5', 2, 1, '2018-11-08 06:07:15', '0000-00-00 00:00:00', 0),
(6, 'F3-4', 3, 1, '2018-11-08 06:07:43', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ssc`
--

CREATE TABLE `ssc` (
  `ssc_id` int(11) NOT NULL,
  `students_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ssc`
--

INSERT INTO `ssc` (`ssc_id`, `students_id`, `position_id`, `created_at`, `updated_at`, `removed`) VALUES
(1, 1, 1, '2018-10-22 04:50:32', '2018-10-22 05:12:46', 0),
(2, 27, 2, '2018-11-27 23:50:08', '2018-11-28 01:02:40', 1),
(3, 27, 2, '2018-11-28 01:03:21', '2018-11-28 01:03:36', 1),
(4, 27, 6, '2018-11-28 01:03:51', '2018-11-28 01:05:04', 1),
(5, 42, 2, '2018-11-29 02:21:18', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `students_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`students_id`, `student_id`, `name_id`, `section_id`, `contact_id`, `account_id`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1500037, 1, 1, 1, 1, 'M', '2018-10-22 06:19:55', '2018-11-01 18:22:32'),
(2, 1500033, 3, 1, 2, 6, 'F', '2018-10-26 07:19:22', '2018-11-01 18:22:27'),
(4, 1500023, 5, 1, 3, 8, 'F', '2018-10-26 07:40:50', '2018-11-01 18:22:34'),
(5, 98798, 18, 1, 7, 44, 'M', '2018-11-02 08:37:29', '0000-00-00 00:00:00'),
(22, 123, 35, 1, 24, 61, 'M', '2018-11-02 10:03:15', '0000-00-00 00:00:00'),
(23, 9879654, 36, 1, 25, 62, 'M', '2018-11-02 10:04:30', '0000-00-00 00:00:00'),
(24, 1502971, 37, 1, 26, 63, 'F', '2018-11-02 10:06:52', '0000-00-00 00:00:00'),
(25, 1500069, 38, 1, 27, 64, 'M', '2018-11-02 14:56:56', '0000-00-00 00:00:00'),
(26, 1500012, 39, 1, 28, 65, 'M', '2018-11-02 15:04:35', '0000-00-00 00:00:00'),
(27, 1500014, 40, 1, 29, 66, 'M', '2018-11-03 13:37:18', '0000-00-00 00:00:00'),
(28, 1500011, 41, 1, 30, 67, 'M', '2018-11-03 13:55:31', '0000-00-00 00:00:00'),
(29, 15000145, 43, 1, 31, 69, 'F', '2018-11-07 09:17:58', '0000-00-00 00:00:00'),
(30, 1500088, 44, 1, 32, 70, 'M', '2018-11-07 09:21:37', '0000-00-00 00:00:00'),
(31, 15005454, 45, 1, 33, 71, 'M', '2018-11-23 15:22:40', '0000-00-00 00:00:00'),
(32, 1500103, 51, 2, 39, 77, 'M', '2018-11-27 06:07:48', '0000-00-00 00:00:00'),
(33, 15123456, 52, 1, 40, 78, 'M', '2018-11-27 07:33:28', '0000-00-00 00:00:00'),
(34, 1500234, 55, 6, 43, 81, 'F', '2018-11-28 01:58:05', '0000-00-00 00:00:00'),
(35, 1500089, 56, 6, 44, 82, 'F', '2018-11-28 02:06:55', '0000-00-00 00:00:00'),
(36, 15099999, 57, 1, 45, 83, 'F', '2018-11-28 03:39:59', '0000-00-00 00:00:00'),
(37, 1234567890, 58, 1, 46, 84, 'M', '2018-11-28 03:41:38', '0000-00-00 00:00:00'),
(38, 98765434, 59, 1, 47, 85, 'M', '2018-11-28 05:00:01', '0000-00-00 00:00:00'),
(39, 76545, 60, 1, 48, 86, '', '2018-11-28 05:03:29', '0000-00-00 00:00:00'),
(40, 765, 61, 1, 49, 87, 'M', '2018-11-28 05:08:54', '0000-00-00 00:00:00'),
(41, 345678, 62, 1, 50, 88, 'M', '2018-11-28 05:43:55', '0000-00-00 00:00:00'),
(42, 1500026, 63, 1, 51, 89, 'M', '2018-11-29 02:18:40', '0000-00-00 00:00:00'),
(43, 1500001, 64, 3, 52, 90, 'M', '2018-11-29 05:58:25', '0000-00-00 00:00:00'),
(44, 1235678, 65, 3, 53, 91, 'M', '2018-11-29 06:30:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `try`
--

CREATE TABLE `try` (
  `hey` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `try`
--

INSERT INTO `try` (`hey`) VALUES
('[\"2018-11-07\", \"2018-11-08\", \"2018-11-09\", \"2018-11-10\", \"2018-11-11\", \"2018-11-12\", \"2018-11-13\", \"2018-11-14\", \"2018-11-15\", \"2018-11-16\", \"2018-11-17\", \"2018-11-18\", \"2018-11-19\", \"2018-11-20\", \"2018-11-21\", \"2018-11-22\", \"2018-11-23\", \"2018-11-24\", \"2018-11-25\", \"2018-11-26\", \"2018-11-27\"]');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `user_level_id` int(11) NOT NULL,
  `user_level` varchar(59) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`user_level_id`, `user_level`, `created_at`, `updated_at`, `removed`) VALUES
(2, 'Academic Administration', '2018-10-21 18:03:36', '2018-11-07 02:38:14', 0),
(5, 'Student', '2018-10-21 18:08:06', '0000-00-00 00:00:00', 0),
(6, 'Supreme Student Council', '2018-10-21 18:08:19', '2018-10-27 08:32:37', 0),
(7, 'Building Coordinator', '2018-10-26 13:54:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` varchar(10) NOT NULL,
  `image_url` varchar(255) NOT NULL DEFAULT 'images/venues/white.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `removed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue`, `employees_id`, `capacity`, `price`, `image_url`, `created_at`, `updated_at`, `removed`) VALUES
(1, 'HRDC GYM2', 1, 10000, '5000', 'images/venues/2018_11_04_12_07_4f1539a3b00abc42062f0fef72e470f0.jpeg', '2018-10-26 08:07:54', '2018-11-29 05:51:40', 1),
(2, 'HRDC AV Studio', 1, 300, '5000', 'images/venues/2018_10_31_02_43_a283c13b467b939097cb6fa67b0073e7.jpg', '2018-10-26 08:07:54', '2018-10-31 06:43:15', 0),
(3, 'Student Center 2nd Floor', 1, 500, '5000', 'images/venues/2018_11_01_04_52_8c1e4df7733ad14dba5ae63d3cc3591a.jpeg', '2018-10-26 08:07:54', '2018-11-01 08:52:05', 0),
(4, 'ORC Quadrangle', 1, 500, '500', 'images/venues/bldg.jpeg', '2018-10-26 08:07:54', '2018-10-31 10:11:51', 0),
(5, 'HRDC Alba Hall', 1, 5000, '5000', 'images/venues/2018_11_01_07_14_52386bc5b6d1441d130c8d81ed13f5f4.jpeg', '2018-10-27 02:32:26', '2018-11-01 11:14:10', 0),
(6, 'CTE Training Hall 1', 1, 50, '5000', 'images/venues/2018_11_03_09_57_5c553d6db0bacca52d068b79284b54ff.jpg', '2018-10-27 02:32:26', '2018-11-03 13:57:41', 0),
(7, 'CTE Training Hall 2', 1, 50, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-29 12:28:23', 0),
(8, 'Admin Ball Room, 2nd Floor', 1, 50, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-29 12:28:23', 0),
(9, 'Admin Multi-Purpose Hall', 1, 50, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-29 12:28:23', 0),
(10, 'Humanities Bldg. AV Theater', 1, 25, '5000', 'images/venues/2018_11_03_01_10_1f51d23950a2db88311c93da7b486ecd.jpeg', '2018-10-27 02:32:26', '2018-11-03 05:10:04', 0),
(11, 'Classroom', 1, 25, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-31 16:23:02', 0),
(12, 'Laboratory Room', 1, 30, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-29 12:28:23', 0),
(13, 'ORC Stage ', 1, 500, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-31 07:26:25', 1),
(14, 'Library Mini-Auditorium', 1, 100, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-29 12:28:23', 0),
(15, 'Library Extension', 1, 50, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-31 07:22:13', 1),
(16, 'Library Grounds', 1, 150, '5000', 'images/venues/bldg.jpeg', '2018-10-27 02:32:26', '2018-10-31 16:23:51', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`approval_id`);

--
-- Indexes for table `approvers`
--
ALTER TABLE `approvers`
  ADD PRIMARY KEY (`approver_id`);

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `audit_trails`
--
ALTER TABLE `audit_trails`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employees_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `facility_items`
--
ALTER TABLE `facility_items`
  ADD PRIMARY KEY (`facility_item_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `names`
--
ALTER TABLE `names`
  ADD PRIMARY KEY (`name_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notifications_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `repercussions`
--
ALTER TABLE `repercussions`
  ADD PRIMARY KEY (`repercussion_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `ssc`
--
ALTER TABLE `ssc`
  ADD PRIMARY KEY (`ssc_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`students_id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`user_level_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `approvers`
--
ALTER TABLE `approvers`
  MODIFY `approver_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_trails`
--
ALTER TABLE `audit_trails`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employees_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `event_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `facility_items`
--
ALTER TABLE `facility_items`
  MODIFY `facility_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `names`
--
ALTER TABLE `names`
  MODIFY `name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notifications_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `repercussions`
--
ALTER TABLE `repercussions`
  MODIFY `repercussion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ssc`
--
ALTER TABLE `ssc`
  MODIFY `ssc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `students_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `user_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
