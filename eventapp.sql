-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2019 at 02:55 PM
-- Server version: 5.7.21
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `colorschemes`
--

DROP TABLE IF EXISTS `colorschemes`;
CREATE TABLE IF NOT EXISTS `colorschemes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statusColor` varchar(255) NOT NULL,
  `appColor` varchar(255) NOT NULL,
  `btnColor` varchar(255) NOT NULL,
  `appLogo` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colorschemes`
--

INSERT INTO `colorschemes` (`id`, `statusColor`, `appColor`, `btnColor`, `appLogo`, `created_at`, `updated_at`) VALUES
(1, '#870082', '#C20303', '#7CF77C', '/images/profileImages/191d0721f18ed719e960649.png', '2019-02-13 07:15:37', '2019-02-14 04:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `followerId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `userId`, `followerId`, `created_at`, `updated_at`) VALUES
(3, 2, 5, '2019-01-23 06:42:22', '2019-01-23 06:42:22'),
(4, 2, 7, '2019-01-23 06:42:22', '2019-01-23 06:42:22'),
(5, 2, 14, '2019-01-23 06:42:22', '2019-01-23 06:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `inbox_view_user`
--

DROP TABLE IF EXISTS `inbox_view_user`;
CREATE TABLE IF NOT EXISTS `inbox_view_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL,
  `lastmessage` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inbox_view_user`
--

INSERT INTO `inbox_view_user` (`id`, `toUser`, `fromUser`, `lastmessage`, `created_at`, `updated_at`) VALUES
(6, 11, 5, '1st msg', '2019-02-01 13:03:02', '2019-02-01 13:03:02'),
(9, 5, 8, 'b msg', '2019-02-04 11:22:35', '2019-02-04 11:22:35'),
(27, 7, 9, 'b msg', '2019-02-14 11:23:35', '2019-02-14 11:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toUser` int(11) DEFAULT NULL,
  `fromUser` int(11) DEFAULT NULL,
  `messageText` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `messageStatus` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `toUser`, `fromUser`, `messageText`, `messageStatus`, `created_at`, `updated_at`) VALUES
(1, 5, 11, '1st msg', 1, '2019-02-01 08:02:37', '2019-02-01 08:02:37'),
(2, 5, 11, '1st msg', 1, '2019-02-01 08:02:48', '2019-02-01 08:02:48'),
(3, 5, 11, '1st msg', 1, '2019-02-01 08:02:48', '2019-02-01 08:02:48'),
(4, 11, 5, '1st msg', 1, '2019-02-01 08:03:00', '2019-02-01 08:03:00'),
(5, 11, 5, '1st msg', 1, '2019-02-01 08:03:01', '2019-02-01 08:03:01'),
(6, 11, 5, '1st msg', 1, '2019-02-01 08:03:02', '2019-02-01 08:03:02'),
(7, 5, 8, 'b msg', 1, '2019-02-04 00:30:13', '2019-02-04 00:30:13'),
(8, 5, 8, 'b msg', 1, '2019-02-04 01:02:22', '2019-02-04 01:02:22'),
(9, 5, 8, 'b msg', 0, '2019-02-04 06:22:35', '2019-02-04 06:22:35'),
(10, 7, 9, 'b msg', 0, '2019-02-04 06:22:50', '2019-02-04 06:22:50'),
(11, 7, 9, 'b msg', 0, '2019-02-04 06:23:02', '2019-02-04 06:23:02'),
(12, 7, 9, 'b msg', 0, '2019-02-04 06:26:35', '2019-02-04 06:26:35'),
(13, 7, 9, 'b msg', 0, '2019-02-04 06:28:04', '2019-02-04 06:28:04'),
(14, 7, 9, 'b msg', 0, '2019-02-04 06:28:19', '2019-02-04 06:28:19'),
(15, 7, 9, 'b msg', 0, '2019-02-04 09:00:17', '2019-02-04 09:00:17'),
(16, 7, 9, 'b msg', 0, '2019-02-14 06:19:32', '2019-02-14 06:19:32'),
(17, 7, 9, 'b msg', 0, '2019-02-14 06:19:43', '2019-02-14 06:19:43'),
(18, 7, 9, 'b msg', 0, '2019-02-14 06:19:55', '2019-02-14 06:19:55'),
(19, 7, 9, 'b msg', 0, '2019-02-14 06:20:12', '2019-02-14 06:20:12'),
(20, 7, 9, 'b msg', 0, '2019-02-14 06:20:46', '2019-02-14 06:20:46'),
(21, 7, 9, 'b msg', 0, '2019-02-14 06:21:03', '2019-02-14 06:21:03'),
(22, 7, 9, 'b msg', 0, '2019-02-14 06:21:44', '2019-02-14 06:21:44'),
(23, 7, 9, 'b msg', 0, '2019-02-14 06:22:06', '2019-02-14 06:22:06'),
(24, 7, 9, 'b msg', 0, '2019-02-14 06:22:28', '2019-02-14 06:22:28'),
(25, 7, 9, 'b msg', 0, '2019-02-14 06:23:23', '2019-02-14 06:23:23'),
(26, 7, 9, 'b msg', 0, '2019-02-14 06:23:30', '2019-02-14 06:23:30'),
(27, 7, 9, 'b msg', 0, '2019-02-14 06:23:35', '2019-02-14 06:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `postId` int(11) DEFAULT NULL,
  `notificationTitle` varchar(1000) DEFAULT NULL,
  `notificationData` varchar(1000) DEFAULT NULL,
  `notifiacationStatus` int(11) DEFAULT '0',
  `notificationType` int(11) NOT NULL,
  `imageUrl` varchar(1000) DEFAULT NULL,
  `actionedBy` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userId`, `postId`, `notificationTitle`, `notificationData`, `notifiacationStatus`, `notificationType`, `imageUrl`, `actionedBy`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'sheraz', 'commented on your post', 0, 3, '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, '2019-01-30 07:34:27', '2019-01-30 07:34:27'),
(2, 8, 1, 'test1', 'commented on your post', 0, 3, '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, '2019-01-30 07:39:55', '2019-01-30 07:39:55'),
(3, 8, 1, 'test1', 'Liked your post', 0, 2, '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, '2019-01-30 07:48:07', '2019-01-30 07:48:07'),
(4, 8, 1, 'test1', 'Liked your post', 0, 2, '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, '2019-01-30 07:49:33', '2019-01-30 07:49:33'),
(5, 8, 1, 'test1', 'Liked your post', 0, 2, '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, '2019-01-30 07:49:47', '2019-01-30 07:49:47'),
(7, 1, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-01-30 12:12:09', '2019-01-30 12:12:09'),
(8, 1, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-01-30 12:13:17', '2019-01-30 12:13:17'),
(9, 1, 31, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-01-30 12:13:44', '2019-01-30 12:13:44'),
(10, 8, 1, 'test1', 'commented on your post', 0, 3, '/images/profileImages/5bb6d514bb868ae929b1b34.png', 1, '2019-01-30 12:45:12', '2019-01-30 12:45:12'),
(11, 1, NULL, 'Like on your comment', 'test1 Liked your comment', 0, 4, NULL, NULL, '2019-01-31 07:16:15', '2019-01-31 07:16:15'),
(12, 1, NULL, 'Like on your comment', 'test1 Liked your comment', 0, 4, NULL, NULL, '2019-01-31 07:16:59', '2019-01-31 07:16:59'),
(13, 1, 1, 'Like on your comment', 'test1 Liked your comment', 0, 4, NULL, NULL, '2019-01-31 07:21:45', '2019-01-31 07:21:45'),
(14, 1, 41, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 10:33:09', '2019-02-01 10:33:09'),
(15, 1, 42, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 10:35:42', '2019-02-01 10:35:42'),
(16, 1, 43, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 10:35:51', '2019-02-01 10:35:51'),
(17, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 12:18:33', '2019-02-01 12:18:33'),
(18, 1, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 12:19:57', '2019-02-01 12:19:57'),
(19, 5, 22, 'test1', 'commented on your post', 0, 3, '/images/profileImages/5bb6d514bb868ae929b1b34.png', 1, '2019-02-01 12:42:47', '2019-02-01 12:42:47'),
(20, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:23:50', '2019-02-01 14:23:50'),
(21, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:24:51', '2019-02-01 14:24:51'),
(22, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:25:23', '2019-02-01 14:25:23'),
(23, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:25:35', '2019-02-01 14:25:35'),
(24, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:27:46', '2019-02-01 14:27:46'),
(25, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:27:56', '2019-02-01 14:27:56'),
(26, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:28:43', '2019-02-01 14:28:43'),
(27, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:30:25', '2019-02-01 14:30:25'),
(28, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-01 14:30:35', '2019-02-01 14:30:35'),
(29, 5, 22, 'test1', 'commented on your post', 0, 3, '/images/profileImages/5bb6d514bb868ae929b1b34.png', 1, '2019-02-01 15:07:42', '2019-02-01 15:07:42'),
(33, NULL, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 06:52:47', '2019-02-04 06:52:47'),
(34, NULL, 19, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 06:53:28', '2019-02-04 06:53:28'),
(35, NULL, 20, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:18:00', '2019-02-04 09:18:00'),
(36, NULL, 21, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:19:13', '2019-02-04 09:19:13'),
(37, NULL, 22, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:23:37', '2019-02-04 09:23:37'),
(38, NULL, 23, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:24:09', '2019-02-04 09:24:09'),
(39, NULL, 24, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:24:46', '2019-02-04 09:24:46'),
(40, NULL, 25, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:28:38', '2019-02-04 09:28:38'),
(41, NULL, 26, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:29:48', '2019-02-04 09:29:48'),
(42, NULL, 27, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:29:54', '2019-02-04 09:29:54'),
(43, NULL, 28, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:30:57', '2019-02-04 09:30:57'),
(44, NULL, 29, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:31:21', '2019-02-04 09:31:21'),
(45, NULL, 30, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:31:46', '2019-02-04 09:31:46'),
(46, NULL, 31, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:38:01', '2019-02-04 09:38:01'),
(47, NULL, 32, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:38:12', '2019-02-04 09:38:12'),
(48, NULL, 33, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:39:07', '2019-02-04 09:39:07'),
(49, NULL, 34, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:40:24', '2019-02-04 09:40:24'),
(50, NULL, 35, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:41:32', '2019-02-04 09:41:32'),
(51, NULL, 36, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:44:20', '2019-02-04 09:44:20'),
(52, NULL, 37, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:44:32', '2019-02-04 09:44:32'),
(53, NULL, 38, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:48:23', '2019-02-04 09:48:23'),
(54, NULL, 39, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:50:31', '2019-02-04 09:50:31'),
(55, NULL, 40, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 09:51:21', '2019-02-04 09:51:21'),
(56, NULL, 41, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 10:06:56', '2019-02-04 10:06:56'),
(57, NULL, 42, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 10:07:23', '2019-02-04 10:07:23'),
(60, 14, 34, 'Like on your comment', 'fhad Liked your comment', 0, 4, NULL, NULL, '2019-02-04 10:53:42', '2019-02-04 10:53:42'),
(61, 14, 34, 'Like on your comment', 'fhad Liked your comment', 0, 4, NULL, NULL, '2019-02-04 10:59:49', '2019-02-04 10:59:49'),
(62, 14, 34, 'Like on your comment', 'fhad Liked your comment', 0, 4, NULL, NULL, '2019-02-04 10:59:50', '2019-02-04 10:59:50'),
(63, 14, 34, 'Like on your comment', 'fhad Liked your comment', 0, 4, NULL, NULL, '2019-02-04 10:59:52', '2019-02-04 10:59:52'),
(64, 14, 34, 'Like on your comment', 'fhad Liked your comment', 0, 4, NULL, NULL, '2019-02-04 11:00:13', '2019-02-04 11:00:13'),
(65, NULL, 43, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:04:46', '2019-02-04 11:04:46'),
(66, NULL, 44, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:48:00', '2019-02-04 11:48:00'),
(67, NULL, 45, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:50:47', '2019-02-04 11:50:47'),
(68, NULL, 46, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:51:48', '2019-02-04 11:51:48'),
(69, NULL, 47, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:52:06', '2019-02-04 11:52:06'),
(70, NULL, 48, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:52:56', '2019-02-04 11:52:56'),
(71, NULL, 49, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:53:41', '2019-02-04 11:53:41'),
(72, NULL, 50, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:54:25', '2019-02-04 11:54:25'),
(73, NULL, 51, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:54:47', '2019-02-04 11:54:47'),
(74, NULL, 52, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 11:56:15', '2019-02-04 11:56:15'),
(75, NULL, 53, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:16:19', '2019-02-04 12:16:19'),
(76, NULL, 54, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:16:57', '2019-02-04 12:16:57'),
(77, NULL, 55, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:18:00', '2019-02-04 12:18:00'),
(78, NULL, 56, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:18:29', '2019-02-04 12:18:29'),
(79, NULL, 57, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:34:06', '2019-02-04 12:34:06'),
(80, NULL, 58, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:35:00', '2019-02-04 12:35:00'),
(81, NULL, 59, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:37:02', '2019-02-04 12:37:02'),
(82, NULL, 60, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:37:07', '2019-02-04 12:37:07'),
(83, NULL, 61, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:38:42', '2019-02-04 12:38:42'),
(84, NULL, 62, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:40:20', '2019-02-04 12:40:20'),
(85, NULL, 63, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:41:40', '2019-02-04 12:41:40'),
(86, NULL, 64, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:42:38', '2019-02-04 12:42:38'),
(87, NULL, 65, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:43:10', '2019-02-04 12:43:10'),
(88, NULL, 66, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:44:41', '2019-02-04 12:44:41'),
(89, NULL, 67, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:45:21', '2019-02-04 12:45:21'),
(90, NULL, 68, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:45:38', '2019-02-04 12:45:38'),
(91, NULL, 69, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:46:13', '2019-02-04 12:46:13'),
(92, NULL, 70, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:46:56', '2019-02-04 12:46:56'),
(93, NULL, 71, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 12:47:29', '2019-02-04 12:47:29'),
(94, NULL, 72, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:05:24', '2019-02-04 13:05:24'),
(95, NULL, 73, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:07:58', '2019-02-04 13:07:58'),
(96, NULL, 74, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:15:32', '2019-02-04 13:15:32'),
(97, NULL, 75, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:26:22', '2019-02-04 13:26:22'),
(98, NULL, 76, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:26:35', '2019-02-04 13:26:35'),
(99, NULL, 77, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:32:19', '2019-02-04 13:32:19'),
(100, NULL, 78, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:37:47', '2019-02-04 13:37:47'),
(101, NULL, 79, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:43:40', '2019-02-04 13:43:40'),
(102, NULL, 80, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:44:52', '2019-02-04 13:44:52'),
(103, NULL, 81, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:47:23', '2019-02-04 13:47:23'),
(104, NULL, 82, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:48:19', '2019-02-04 13:48:19'),
(105, NULL, 83, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:48:48', '2019-02-04 13:48:48'),
(106, NULL, 84, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:50:06', '2019-02-04 13:50:06'),
(107, NULL, 85, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:51:38', '2019-02-04 13:51:38'),
(108, NULL, 86, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:52:04', '2019-02-04 13:52:04'),
(109, NULL, 87, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:52:25', '2019-02-04 13:52:25'),
(110, NULL, 88, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:53:58', '2019-02-04 13:53:58'),
(111, NULL, 89, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:54:34', '2019-02-04 13:54:34'),
(112, NULL, 90, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 13:54:52', '2019-02-04 13:54:52'),
(113, NULL, 91, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:03:24', '2019-02-04 14:03:24'),
(114, NULL, 92, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:19:18', '2019-02-04 14:19:18'),
(115, NULL, 93, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:31:14', '2019-02-04 14:31:14'),
(116, NULL, 94, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:32:22', '2019-02-04 14:32:22'),
(117, NULL, 95, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:33:33', '2019-02-04 14:33:33'),
(118, NULL, 96, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:34:56', '2019-02-04 14:34:56'),
(119, NULL, 97, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:35:09', '2019-02-04 14:35:09'),
(120, NULL, 98, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:38:32', '2019-02-04 14:38:32'),
(121, NULL, 99, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:38:53', '2019-02-04 14:38:53'),
(122, NULL, 100, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:40:43', '2019-02-04 14:40:43'),
(123, NULL, 101, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:41:16', '2019-02-04 14:41:16'),
(124, NULL, 102, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:43:07', '2019-02-04 14:43:07'),
(125, NULL, 103, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, NULL, NULL, '2019-02-04 14:45:19', '2019-02-04 14:45:19'),
(127, 14, 14, 'test1', 'Liked your post', 0, 2, '/images/profileImages/5bb6d514bb868ae929b1b34.png', 1, '2019-02-14 11:30:52', '2019-02-14 11:30:52'),
(128, 14, 14, NULL, 'commented on your post', 0, 3, NULL, 9, '2019-02-14 11:45:44', '2019-02-14 11:45:44'),
(129, 14, 14, NULL, 'commented on your post', 0, 3, NULL, 9, '2019-02-14 11:47:19', '2019-02-14 11:47:19'),
(130, 14, 14, NULL, 'commented on your post', 0, 3, NULL, 9, '2019-02-14 11:47:23', '2019-02-14 11:47:23'),
(131, 14, 34, 'Like on your comment', 'test2 Liked your comment', 0, 4, NULL, NULL, '2019-02-14 11:54:37', '2019-02-14 11:54:37'),
(132, 14, 34, 'Like on your comment', 'test2 Liked your comment', 0, 4, NULL, NULL, '2019-02-14 11:55:35', '2019-02-14 11:55:35'),
(142, 5, 26, 'test2', 'Liked your post', 0, 2, NULL, 2, '2019-02-15 13:52:35', '2019-02-15 13:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postTitile` text,
  `postDescription` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `postLikesCount` int(11) NOT NULL DEFAULT '0',
  `postCommentsCount` int(11) NOT NULL DEFAULT '0',
  `postSharesCount` int(11) NOT NULL DEFAULT '0',
  `postMediaType` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `postTitile`, `postDescription`, `postLikesCount`, `postCommentsCount`, `postSharesCount`, `postMediaType`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 'text', 1, 44, 0, 'image', '2019-01-24 08:24:04', '2019-01-24 08:24:04'),
(14, 14, NULL, 'hi', 1, 18, 0, 'image', '2019-01-24 08:32:58', '2019-01-24 08:32:58'),
(22, 5, 'postTitile', 'One Image', 0, 5, 0, 'image', '2019-01-25 02:12:59', '2019-01-25 02:12:59'),
(23, 5, 'postTitile', 'Asdfasdf', 0, 0, 0, 'image', '2019-01-25 02:21:46', '2019-01-25 02:21:46'),
(24, 5, 'postTitile', 'Three Images', 0, 0, 0, 'image', '2019-01-25 02:22:47', '2019-01-25 02:22:47'),
(25, 5, 'postTitile', 'Three Images', 0, 0, 0, 'image', '2019-01-25 02:25:21', '2019-01-25 02:25:21'),
(26, 5, 'postTitile', 'One Image', 1, 0, 0, 'image', '2019-01-25 02:27:06', '2019-01-25 02:27:06'),
(30, 2, 'title if required', 'some description', 0, 0, 0, 'your choice', '2019-01-30 07:13:17', '2019-01-30 07:13:17'),
(31, 2, 'title if required', 'some description', 0, 0, 0, 'your choice', '2019-01-30 07:13:44', '2019-01-30 07:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `post_actions`
--

DROP TABLE IF EXISTS `post_actions`;
CREATE TABLE IF NOT EXISTS `post_actions` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `isLiked` int(11) DEFAULT NULL,
  `comment` int(11) DEFAULT NULL,
  `iscomment` int(11) DEFAULT '0',
  `shared` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_attachements`
--

DROP TABLE IF EXISTS `post_attachements`;
CREATE TABLE IF NOT EXISTS `post_attachements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) NOT NULL,
  `attachmentURL` varchar(255) NOT NULL,
  `videoURL` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_attachements`
--

INSERT INTO `post_attachements` (`id`, `postId`, `attachmentURL`, `videoURL`, `created_at`, `updated_at`) VALUES
(1, 34, '/images/postImages/1548328698-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
(2, 34, '/images/postImages/1548328700-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
(3, 34, '/images/postImages/1548328702-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
(4, 2, '/images/postImages/1548330882-.png', NULL, '2019-01-24 11:54:52', '2019-01-24 11:54:52'),
(5, 2, '/images/postImages/1548330885-.png', NULL, '2019-01-24 11:54:52', '2019-01-24 11:54:52'),
(6, 2, '/images/postImages/1548330891-.png', NULL, '2019-01-24 11:54:52', '2019-01-24 11:54:52'),
(7, 3, '/images/postImages/1548331319-.pn', NULL, '2019-01-24 12:02:31', '2019-01-24 12:02:31'),
(8, 4, '/images/postImages/1548331597-.png', NULL, '2019-01-24 12:06:41', '2019-01-24 12:06:41'),
(9, 5, '/images/postImages/1548332346-.png', NULL, '2019-01-24 12:19:10', '2019-01-24 12:19:10'),
(10, 6, '/images/postImages/1548332770-.png', NULL, '2019-01-24 12:26:15', '2019-01-24 12:26:15'),
(11, 6, '', NULL, '2019-01-24 12:26:15', '2019-01-24 12:26:15'),
(12, 7, '/images/postImages/1548332937-.png', NULL, '2019-01-24 12:29:00', '2019-01-24 12:29:00'),
(13, 7, '', NULL, '2019-01-24 12:29:00', '2019-01-24 12:29:00'),
(14, 8, '/images/postImages/1548332990-.png', NULL, '2019-01-24 12:29:59', '2019-01-24 12:29:59'),
(15, 8, '/images/postImages/1548332992-.png', NULL, '2019-01-24 12:29:59', '2019-01-24 12:29:59'),
(16, 8, '/images/postImages/1548332994-.png', NULL, '2019-01-24 12:29:59', '2019-01-24 12:29:59'),
(17, 8, '/images/postImages/1548332996-.png', NULL, '2019-01-24 12:29:59', '2019-01-24 12:29:59'),
(18, 8, '', NULL, '2019-01-24 12:29:59', '2019-01-24 12:29:59'),
(19, 9, '\0', NULL, '2019-01-24 12:55:55', '2019-01-24 12:55:55'),
(20, 10, '\0', NULL, '2019-01-24 13:02:11', '2019-01-24 13:02:11'),
(21, 11, '\0', NULL, '2019-01-24 13:20:01', '2019-01-24 13:20:01'),
(22, 12, '/images/postImages/1548336225-.png', NULL, '2019-01-24 13:24:04', '2019-01-24 13:24:04'),
(23, 12, '/images/postImages/1548336231-.png', NULL, '2019-01-24 13:24:04', '2019-01-24 13:24:04'),
(24, 12, '/images/postImages/1548336241-.png', NULL, '2019-01-24 13:24:04', '2019-01-24 13:24:04'),
(25, 13, '\0', NULL, '2019-01-24 13:24:12', '2019-01-24 13:24:12'),
(26, 14, '/images/postImages/1548336768-.png', NULL, '2019-01-24 13:32:58', '2019-01-24 13:32:58'),
(27, 14, '/images/postImages/1548336776-.png', NULL, '2019-01-24 13:32:58', '2019-01-24 13:32:58'),
(28, 15, '', NULL, '2019-01-24 13:34:39', '2019-01-24 13:34:39'),
(29, 15, '', NULL, '2019-01-24 13:34:39', '2019-01-24 13:34:39'),
(30, 16, '', NULL, '2019-01-24 13:37:42', '2019-01-24 13:37:42'),
(31, 16, '', NULL, '2019-01-24 13:37:42', '2019-01-24 13:37:42'),
(32, 17, '', NULL, '2019-01-24 14:08:11', '2019-01-24 14:08:11'),
(33, 17, '', NULL, '2019-01-24 14:08:11', '2019-01-24 14:08:11'),
(34, 18, '', NULL, '2019-01-25 06:50:27', '2019-01-25 06:50:27'),
(35, 18, '', NULL, '2019-01-25 06:50:27', '2019-01-25 06:50:27'),
(36, 19, '/images/postImages/1548399165-.png', NULL, '2019-01-25 06:52:52', '2019-01-25 06:52:52'),
(37, 19, '/images/postImages/1548399167-.png', NULL, '2019-01-25 06:52:52', '2019-01-25 06:52:52'),
(38, 19, '/images/postImages/1548399169-.png', NULL, '2019-01-25 06:52:52', '2019-01-25 06:52:52'),
(39, 19, '', NULL, '2019-01-25 06:52:52', '2019-01-25 06:52:52'),
(40, 20, '/images/postImages/1548399399-.png', NULL, '2019-01-25 06:56:49', '2019-01-25 06:56:49'),
(41, 20, '/images/postImages/1548399402-.png', NULL, '2019-01-25 06:56:49', '2019-01-25 06:56:49'),
(42, 20, '/images/postImages/1548399404-.png', NULL, '2019-01-25 06:56:49', '2019-01-25 06:56:49'),
(43, 20, '/images/postImages/1548399405-.png', NULL, '2019-01-25 06:56:49', '2019-01-25 06:56:49'),
(44, 20, '', NULL, '2019-01-25 06:56:49', '2019-01-25 06:56:49'),
(45, 21, '/images/postImages/1548400050-.png', NULL, '2019-01-25 07:07:36', '2019-01-25 07:07:36'),
(46, 21, '/images/postImages/1548400051-.png', NULL, '2019-01-25 07:07:36', '2019-01-25 07:07:36'),
(47, 21, '/images/postImages/1548400053-.png', NULL, '2019-01-25 07:07:36', '2019-01-25 07:07:36'),
(48, 22, '', NULL, '2019-01-25 07:12:59', '2019-01-25 07:12:59'),
(49, 23, '/images/postImages/1548400901-.png', NULL, '2019-01-25 07:21:46', '2019-01-25 07:21:46'),
(50, 23, '/images/postImages/1548400903-.png', NULL, '2019-01-25 07:21:46', '2019-01-25 07:21:46'),
(51, 24, '/images/postImages/1548400962-.png', NULL, '2019-01-25 07:22:47', '2019-01-25 07:22:47'),
(52, 24, '/images/postImages/1548400964-.png', NULL, '2019-01-25 07:22:47', '2019-01-25 07:22:47'),
(53, 25, '/images/postImages/1548401117-.png', NULL, '2019-01-25 07:25:21', '2019-01-25 07:25:21'),
(54, 25, '/images/postImages/1548401119-.png', NULL, '2019-01-25 07:25:21', '2019-01-25 07:25:21'),
(55, 26, '/images/postImages/1548401225-.png', NULL, '2019-01-25 07:27:06', '2019-01-25 07:27:06'),
(56, 27, '/images/postImages/1548401245-.png', NULL, '2019-01-25 07:27:31', '2019-01-25 07:27:31'),
(57, 27, '/images/postImages/1548401247-.png', NULL, '2019-01-25 07:27:31', '2019-01-25 07:27:31'),
(58, 27, '/images/postImages/1548401248-.png', NULL, '2019-01-25 07:27:31', '2019-01-25 07:27:31'),
(59, 27, '/images/postImages/1548401250-.png', NULL, '2019-01-25 07:27:31', '2019-01-25 07:27:31'),
(60, 28, '/images/postImages/1548401351-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20'),
(61, 28, '/images/postImages/1548401353-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20'),
(62, 28, '/images/postImages/1548401355-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20'),
(63, 28, '/images/postImages/1548401357-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20'),
(64, 28, '/images/postImages/1548401359-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20'),
(65, 29, 'comma seperated attachements URL ', NULL, '2019-01-30 12:12:09', '2019-01-30 12:12:09'),
(66, 30, 'comma seperated attachements URL ', NULL, '2019-01-30 12:13:17', '2019-01-30 12:13:17'),
(67, 31, 'comma seperated attachements URL ', NULL, '2019-01-30 12:13:44', '2019-01-30 12:13:44'),
(68, 41, 'comma seperated attachements URL ', NULL, '2019-02-01 10:33:09', '2019-02-01 10:33:09'),
(69, 42, 'comma seperated attachements URL ', NULL, '2019-02-01 10:35:42', '2019-02-01 10:35:42'),
(70, 43, 'comma seperated attachements URL ', NULL, '2019-02-01 10:35:51', '2019-02-01 10:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `commentlikesCount` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `userId`, `postId`, `comment`, `commentlikesCount`, `created_at`, `updated_at`) VALUES
(1, 14, 34, 'wewew', 1, '2019-01-30 07:27:28', '2019-01-30 07:27:28'),
(2, 1, 34, 'wewew', 0, '2019-01-30 07:27:38', '2019-01-30 07:27:38'),
(3, 1, 23, 'wewew', 0, '2019-01-30 07:27:41', '2019-01-30 07:27:41'),
(4, 1, 1, 'wewew', 0, '2019-01-30 07:28:35', '2019-01-30 07:28:35'),
(5, 1, 1, 'wewew', 0, '2019-01-30 07:29:11', '2019-01-30 07:29:11'),
(6, 1, 1, 'wewew', 0, '2019-01-30 07:29:30', '2019-01-30 07:29:30'),
(7, 1, 1, 'wewew', 0, '2019-01-30 07:29:46', '2019-01-30 07:29:46'),
(8, 1, 1, 'wewew', 0, '2019-01-30 07:29:53', '2019-01-30 07:29:53'),
(9, 1, 1, 'wewew', 0, '2019-01-30 07:30:27', '2019-01-30 07:30:27'),
(10, 1, 1, 'wewew', 0, '2019-01-30 07:31:16', '2019-01-30 07:31:16'),
(11, 1, 1, 'wewew', 0, '2019-01-30 07:34:10', '2019-01-30 07:34:10'),
(12, 1, 1, 'wewew', 1, '2019-01-30 07:34:27', '2019-01-30 07:34:27'),
(13, 1, 1, 'wewew', 0, '2019-01-30 07:38:11', '2019-01-30 07:38:11'),
(14, 1, 1, 'wewew', 0, '2019-01-30 07:38:18', '2019-01-30 07:38:18'),
(15, 1, 1, 'wewew', 0, '2019-01-30 07:38:50', '2019-01-30 07:38:50'),
(16, 1, 1, 'wewew', 0, '2019-01-30 07:39:55', '2019-01-30 07:39:55'),
(17, 1, 1, 'wewew', 0, '2019-01-30 12:45:12', '2019-01-30 12:45:12'),
(18, 1, 2, 'wewew', 0, '2019-02-01 12:39:35', '2019-02-01 12:39:35'),
(19, 1, 2, 'wewew', 0, '2019-02-01 12:39:51', '2019-02-01 12:39:51'),
(20, 1, 2, 'wewew', 0, '2019-02-01 12:40:07', '2019-02-01 12:40:07'),
(21, 1, 2, 'wewew', 0, '2019-02-01 12:40:21', '2019-02-01 12:40:21'),
(22, 1, 1, 'wewew', 0, '2019-02-01 12:40:45', '2019-02-01 12:40:45'),
(23, 1, 14, 'wewew', 0, '2019-02-01 12:41:11', '2019-02-01 12:41:11'),
(24, 1, 14, 'wewew', 0, '2019-02-01 12:41:27', '2019-02-01 12:41:27'),
(25, 14, 14, 'wewew', 0, '2019-02-01 12:41:53', '2019-02-01 12:41:53'),
(26, 1, 22, 'wewew', 0, '2019-02-01 12:42:19', '2019-02-01 12:42:19'),
(27, 1, 22, 'wewew', 0, '2019-02-01 12:42:25', '2019-02-01 12:42:25'),
(28, 1, 22, 'wewew', 0, '2019-02-01 12:42:33', '2019-02-01 12:42:33'),
(29, 1, 22, 'wewew', 0, '2019-02-01 12:42:47', '2019-02-01 12:42:47'),
(30, 1, 22, 'wewew', 0, '2019-02-01 15:07:41', '2019-02-01 15:07:41'),
(31, 1, 2, 'wewew', 0, '2019-02-04 10:16:50', '2019-02-04 10:16:50'),
(32, 1, 2, 'wewew', 0, '2019-02-04 10:16:57', '2019-02-04 10:16:57'),
(33, 1, 14, 'wewew', 0, '2019-02-04 10:18:51', '2019-02-04 10:18:51'),
(34, 1, 14, 'wewew', 0, '2019-02-04 10:32:22', '2019-02-04 10:32:22'),
(35, 1, 2, 'wewew', 0, '2019-02-14 11:43:44', '2019-02-14 11:43:44'),
(36, 1, 85, 'wewew', 0, '2019-02-14 11:43:50', '2019-02-14 11:43:50'),
(37, 2, 85, 'wewew', 0, '2019-02-14 11:43:53', '2019-02-14 11:43:53'),
(38, 36, 85, 'wewew', 0, '2019-02-14 11:43:58', '2019-02-14 11:43:58'),
(39, 36, 85, 'wewew', 0, '2019-02-14 11:45:23', '2019-02-14 11:45:23'),
(40, 9, 14, 'wewew', 0, '2019-02-14 11:45:43', '2019-02-14 11:45:43'),
(41, 9, 14, 'wewew', 0, '2019-02-14 11:47:00', '2019-02-14 11:47:00'),
(42, 9, 14, 'wewew', 0, '2019-02-14 11:47:17', '2019-02-14 11:47:17'),
(43, 9, 14, 'wewew', 0, '2019-02-14 11:47:21', '2019-02-14 11:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment_likes`
--

DROP TABLE IF EXISTS `post_comment_likes`;
CREATE TABLE IF NOT EXISTS `post_comment_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment_likes`
--

INSERT INTO `post_comment_likes` (`id`, `commentId`, `userId`, `created_at`, `updated_at`) VALUES
(22, 1, 1, '2019-01-24 05:02:12', '2019-01-24 05:02:12'),
(34, 12, 1, '2019-01-31 07:21:45', '2019-01-31 07:21:45'),
(36, NULL, 2, '2019-02-14 11:42:53', '2019-02-14 11:42:53'),
(40, 1, 2, '2019-02-14 11:55:35', '2019-02-14 11:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
CREATE TABLE IF NOT EXISTS `post_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `userId`, `postId`, `created_at`, `updated_at`) VALUES
(4, 5, 1, '2019-01-23 06:00:58', '2019-01-23 06:00:58'),
(7, 5, 1, '2019-01-24 05:01:58', '2019-01-24 05:01:58'),
(13, 8, 14, '2019-01-25 06:40:59', '2019-01-25 06:40:59'),
(14, 1, 34, '2019-01-25 12:13:03', '2019-01-25 12:13:03'),
(16, 1, 34, '2019-01-30 07:46:16', '2019-01-30 07:46:16'),
(17, 1, 12, '2019-02-14 11:29:22', '2019-02-14 11:29:22'),
(19, 1, 14, '2019-02-14 11:30:52', '2019-02-14 11:30:52'),
(26, 8, 77, '2019-02-15 07:22:31', '2019-02-15 07:22:31'),
(27, 2, 77, '2019-02-15 07:23:02', '2019-02-15 07:23:02'),
(31, 2, 26, '2019-02-15 13:52:35', '2019-02-15 13:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventDate` datetime DEFAULT NULL,
  `sessionName` varchar(1000) DEFAULT NULL,
  `sessionVenue` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timeFrom` time DEFAULT NULL,
  `timeTo` time DEFAULT NULL,
  `sessionDescription` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `eventDate`, `sessionName`, `sessionVenue`, `date`, `timeFrom`, `timeTo`, `sessionDescription`, `created_at`, `updated_at`) VALUES
(1, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'asdddd', '2019-01-22 05:34:30', '2019-02-01 07:17:02'),
(2, '2019-02-05 00:00:00', 'Stream6 - London Market\r\nClaims Technology', 'somewhere At Lahore', '2019-02-05', '02:00:00', '04:00:00', 'Making the claims process more client \r\nfriendly, slicker and transparent for \r\ncustomers', '2019-01-22 05:34:59', '2019-01-22 05:34:59'),
(7, '2019-02-05 00:00:00', 'sessionVenue', NULL, '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 05:53:00', '2019-02-01 05:53:00'),
(8, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 05:53:30', '2019-02-01 05:53:30'),
(9, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:23:50', '2019-02-01 09:23:50'),
(10, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:24:51', '2019-02-01 09:24:51'),
(11, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:25:23', '2019-02-01 09:25:23'),
(12, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:25:35', '2019-02-01 09:25:35'),
(13, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:27:46', '2019-02-01 09:27:46'),
(14, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:27:56', '2019-02-01 09:27:56'),
(15, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:28:43', '2019-02-01 09:28:43'),
(17, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-01 09:30:35', '2019-02-01 09:30:35'),
(18, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 01:52:47', '2019-02-04 01:52:47'),
(38, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 04:48:23', '2019-02-04 04:48:23'),
(39, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 04:50:31', '2019-02-04 04:50:31'),
(40, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 04:51:21', '2019-02-04 04:51:21'),
(41, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 05:06:56', '2019-02-04 05:06:56'),
(42, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 05:07:23', '2019-02-04 05:07:23'),
(43, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:04:46', '2019-02-04 06:04:46'),
(44, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:48:00', '2019-02-04 06:48:00'),
(45, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:50:47', '2019-02-04 06:50:47'),
(46, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:51:48', '2019-02-04 06:51:48'),
(47, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:52:06', '2019-02-04 06:52:06'),
(48, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:52:56', '2019-02-04 06:52:56'),
(49, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:53:41', '2019-02-04 06:53:41'),
(50, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:54:25', '2019-02-04 06:54:25'),
(51, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:54:47', '2019-02-04 06:54:47'),
(52, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 06:56:15', '2019-02-04 06:56:15'),
(53, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:16:19', '2019-02-04 07:16:19'),
(54, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:16:57', '2019-02-04 07:16:57'),
(55, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:18:00', '2019-02-04 07:18:00'),
(56, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:18:29', '2019-02-04 07:18:29'),
(57, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:34:06', '2019-02-04 07:34:06'),
(58, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:35:00', '2019-02-04 07:35:00'),
(59, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:37:02', '2019-02-04 07:37:02'),
(60, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:37:07', '2019-02-04 07:37:07'),
(61, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:38:42', '2019-02-04 07:38:42'),
(62, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:40:20', '2019-02-04 07:40:20'),
(63, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:41:40', '2019-02-04 07:41:40'),
(64, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:42:38', '2019-02-04 07:42:38'),
(65, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:43:10', '2019-02-04 07:43:10'),
(66, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:44:41', '2019-02-04 07:44:41'),
(67, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:45:21', '2019-02-04 07:45:21'),
(68, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:45:38', '2019-02-04 07:45:38'),
(69, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:46:13', '2019-02-04 07:46:13'),
(70, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:46:56', '2019-02-04 07:46:56'),
(71, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 07:47:29', '2019-02-04 07:47:29'),
(72, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:05:24', '2019-02-04 08:05:24'),
(73, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:07:58', '2019-02-04 08:07:58'),
(74, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:15:32', '2019-02-04 08:15:32'),
(75, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:26:22', '2019-02-04 08:26:22'),
(76, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:26:35', '2019-02-04 08:26:35'),
(77, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:32:19', '2019-02-04 08:32:19'),
(78, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:37:47', '2019-02-04 08:37:47'),
(79, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:43:40', '2019-02-04 08:43:40'),
(80, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:44:52', '2019-02-04 08:44:52'),
(81, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:47:23', '2019-02-04 08:47:23'),
(82, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:48:19', '2019-02-04 08:48:19'),
(83, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:48:48', '2019-02-04 08:48:48'),
(84, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:50:06', '2019-02-04 08:50:06'),
(85, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:51:38', '2019-02-04 08:51:38'),
(86, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:52:04', '2019-02-04 08:52:04'),
(87, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:52:24', '2019-02-04 08:52:24'),
(88, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:53:58', '2019-02-04 08:53:58'),
(89, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:54:34', '2019-02-04 08:54:34'),
(90, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 08:54:52', '2019-02-04 08:54:52'),
(91, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:03:24', '2019-02-04 09:03:24'),
(92, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:19:18', '2019-02-04 09:19:18'),
(93, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:31:14', '2019-02-04 09:31:14'),
(94, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:32:22', '2019-02-04 09:32:22'),
(95, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:33:33', '2019-02-04 09:33:33'),
(96, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:34:56', '2019-02-04 09:34:56'),
(97, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:35:09', '2019-02-04 09:35:09'),
(98, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:38:32', '2019-02-04 09:38:32'),
(99, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:38:53', '2019-02-04 09:38:53'),
(100, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:40:43', '2019-02-04 09:40:43'),
(101, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:41:16', '2019-02-04 09:41:16'),
(102, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:43:07', '2019-02-04 09:43:07'),
(103, '2019-02-05 00:00:00', 'sessionVenue', 'asd', '2019-02-01', '02:00:00', '04:00:00', 'video', '2019-02-04 09:45:19', '2019-02-04 09:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `session_speakers`
--

DROP TABLE IF EXISTS `session_speakers`;
CREATE TABLE IF NOT EXISTS `session_speakers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` int(11) NOT NULL,
  `speakerId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_speakers`
--

INSERT INTO `session_speakers` (`id`, `sessionId`, `speakerId`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2019-01-30 10:09:37', '2019-01-30 10:09:37'),
(2, 2, 1, '2019-01-30 10:09:37', '2019-01-30 10:09:37'),
(3, 2, 1, '2019-01-30 10:09:37', '2019-01-30 10:09:37'),
(4, 15, 1, '2019-02-01 14:28:43', '2019-02-01 14:28:43'),
(5, 15, 2, '2019-02-01 14:28:43', '2019-02-01 14:28:43'),
(6, 15, 3, '2019-02-01 14:28:43', '2019-02-01 14:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `session_sponsors`
--

DROP TABLE IF EXISTS `session_sponsors`;
CREATE TABLE IF NOT EXISTS `session_sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` int(11) NOT NULL,
  `sponsorId` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_sponsors`
--

INSERT INTO `session_sponsors` (`id`, `sessionId`, `sponsorId`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019-01-30 10:08:36', '2019-01-30 10:08:36'),
(2, 2, 2, '2019-01-30 10:08:36', '2019-01-30 10:08:36'),
(3, 13, 1, '2019-02-01 14:27:46', '2019-02-01 14:27:46'),
(4, 14, 1, '2019-02-01 14:27:56', '2019-02-01 14:27:56'),
(5, 14, 2, '2019-02-01 14:27:56', '2019-02-01 14:27:56'),
(6, 14, 3, '2019-02-01 14:27:56', '2019-02-01 14:27:56'),
(7, 15, 1, '2019-02-01 14:28:43', '2019-02-01 14:28:43'),
(8, 15, 2, '2019-02-01 14:28:43', '2019-02-01 14:28:43'),
(9, 15, 3, '2019-02-01 14:28:43', '2019-02-01 14:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `speakers`
--

DROP TABLE IF EXISTS `speakers`;
CREATE TABLE IF NOT EXISTS `speakers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speakerName` varchar(255) DEFAULT NULL,
  `speakerOccupation` varchar(255) DEFAULT NULL,
  `speakerCompanyName` varchar(255) DEFAULT NULL,
  `speakerDetails` longtext,
  `speakerAddedBy` int(11) DEFAULT NULL,
  `speakerProfileImage` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speakers`
--

INSERT INTO `speakers` (`id`, `speakerName`, `speakerOccupation`, `speakerCompanyName`, `speakerDetails`, `speakerAddedBy`, `speakerProfileImage`, `created_at`, `updated_at`) VALUES
(1, 'Shaun Linton', 'Claims & Client Services...', 'Amazon', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:00:31', '2019-01-22 05:00:31'),
(2, 'Shaun Linton', 'Claims & Client Services...', 'Amazon', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:09:48', '2019-01-22 05:09:48'),
(8, 'Shaun Linton', 'Claims & Client Services...', 'Amazon', 'some details about the speaker', NULL, NULL, '2019-02-01 02:38:18', '2019-02-01 02:38:18'),
(9, 'Shaun Linton', 'Claims & Client Services...', 'Amazon', 'some details about the speaker', NULL, NULL, '2019-02-01 02:38:50', '2019-02-01 02:38:50'),
(10, 'fdss', 'fdsaf', 'fdda', 'fdfdsas', NULL, NULL, '2019-02-01 02:39:10', '2019-02-01 02:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `speaker_documents`
--

DROP TABLE IF EXISTS `speaker_documents`;
CREATE TABLE IF NOT EXISTS `speaker_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speakerId` int(11) NOT NULL,
  `documentName` varchar(1000) DEFAULT NULL,
  `DocattachementURl` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speaker_documents`
--

INSERT INTO `speaker_documents` (`id`, `speakerId`, `documentName`, `DocattachementURl`, `created_at`, `updated_at`) VALUES
(1, 1, 'test1 ', '/images/sessionDocuments/a7f83e131cd045c6f6a5.pdf', '2019-01-22 10:57:41', '2019-01-22 10:57:41'),
(3, 2, 'test2', '/images/sessionDocuments/a7f83e131cd045c6f6a5.pdf', '2019-01-22 06:13:20', '2019-01-22 06:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
CREATE TABLE IF NOT EXISTS `sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addedBy` int(11) DEFAULT NULL,
  `sponsorName` varchar(1000) DEFAULT NULL,
  `sponsorImage` varchar(1000) DEFAULT NULL,
  `sponsorDescription` longtext,
  `sponsorTitle` varchar(1000) DEFAULT NULL,
  `sponsorshipLevel` varchar(1000) DEFAULT NULL,
  `sponsorwebLink` varchar(1000) DEFAULT NULL,
  `instaLink` varchar(1000) DEFAULT NULL,
  `fbLink` varchar(1000) DEFAULT NULL,
  `linkedInLink` varchar(1000) DEFAULT NULL,
  `twitterLink` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `addedBy`, `sponsorName`, `sponsorImage`, `sponsorDescription`, `sponsorTitle`, `sponsorshipLevel`, `sponsorwebLink`, `instaLink`, `fbLink`, `linkedInLink`, `twitterLink`, `created_at`, `updated_at`) VALUES
(1, 1, 'amazon', '/images/Sponsors/14bf0aeea0ead9c71ed33.png', 'fittness', 'if you have body you are an athelete', 'Bronze', 'www.amazon.com', NULL, NULL, NULL, NULL, '2019-01-22 01:52:04', '2019-01-22 01:52:04'),
(4, 1, 'amazon', '/images/Sponsors/14bf0aeea0ead9c71ed33.png', 'fittness', 'if you have body you are an athelete', 'Bronze', 'www.amazon.com', NULL, NULL, NULL, NULL, '2019-01-22 01:52:04', '2019-01-22 01:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `profileImage` varchar(1000) DEFAULT NULL,
  `deviceId` varchar(1000) DEFAULT NULL,
  `deviceType` varchar(1000) DEFAULT NULL,
  `socialType` varchar(1000) DEFAULT NULL,
  `token` varchar(1000) DEFAULT NULL,
  `account_status` int(11) DEFAULT '0',
  `role` int(11) DEFAULT NULL,
  `contact` longtext,
  `companyName` varchar(255) DEFAULT NULL,
  `jobTitle` varchar(255) DEFAULT NULL,
  `followersCount` int(11) DEFAULT '0',
  `followingCount` int(11) DEFAULT '0',
  `postCount` int(11) DEFAULT '0',
  `pinnedPostId` int(11) DEFAULT NULL,
  `isOnline` int(11) DEFAULT '0',
  `points` int(11) DEFAULT '0',
  `gender` varchar(255) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `profileImage`, `deviceId`, `deviceType`, `socialType`, `token`, `account_status`, `role`, `contact`, `companyName`, `jobTitle`, `followersCount`, `followingCount`, `postCount`, `pinnedPostId`, `isOnline`, `points`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'ahmad@gmail.com', '$2y$10$KFJEb0LNMOk9hkK9oOpuaugcINHOkKZWJ4Bzcc4MYcSYQXW5SoA4e', 'test1', '/images/profileImages/5bb6d514bb868ae929b1b34.png', 'fhfpLnNqtxc:APA91bFIMC2i7ECQMQm7QRAxxhIEBG-dVz5dADoSEugTuRlJ79JYxQ1z0I4anOGdxtRxHZAJHK6iJc3FmiJwGs5o6SBW6bWgmmqgY8DW7ArcPWkBF8oOmAwBlrungdvLismEoKj1YPge', '1', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvZG9Mb2dpbiIsImlhdCI6MTU1MDA2MDY4NSwiZXhwIjoxNTUwMDY0Mjg1LCJuYmYiOjE1NTAwNjA2ODUsImp0aSI6IjVlQno4b3pvVWo2d2xsRDYiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.-EK4GCKj2Q1lwErGniIwSmLYHGf6C5SX_K-Q9iDsWdM', 1, 1, NULL, NULL, NULL, 0, 1, 14, 2, 0, 0, '1', '2019-01-21 02:30:38', '2019-01-23 04:29:36'),
(2, 'ahmad1@gmail.com', '$2y$10$dVXjlI.OPdgQds/uVmZyl.6B09VpcZO.VAHLStAdwOgkxv6JhZZpO', 'test2', NULL, NULL, '1', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MFwvYWRtaW5Mb2dpbiIsImlhdCI6MTU0ODc1ODQ1NSwiZXhwIjoxNTQ4NzYyMDU1LCJuYmYiOjE1NDg3NTg0NTUsImp0aSI6IkowN2dvenh0SEZOSkVyTGMiLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.DbK601zEGNbBRT3arTmTxUnSP1miGgrucmFDhzXh2fo', 1, 1, NULL, NULL, NULL, 1, 0, 5, 14, 0, 0, '1', '2019-01-21 02:30:38', '2019-01-21 02:30:38'),
(5, 'ali@gmail.com', '$2y$10$oGwnJ1bjumEyNpNDyTqY8.OjpWyY0mEL7ZwU9irfnuN1u5f6vhj1W', 'fa', '/images/profileImages/5dc97952ca5b436da4d7bb0.png', 'cdln43rtJJ4:APA91bGbkAXzY6H18DcviKz4u0vKhyyP6rBZD_mp--plPsZjNKfN0dPNRcVpdT45h6_3gygaiXCS8RO-OcaTX9t0I9htq-eMLYsFqaOvUm1ZxLWVt_S3Q_Z64jm5ip83YL3wC868274z', '1', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMyMzQ5MCwiZXhwIjoxNTQ4MzI3MDkwLCJuYmYiOjE1NDgzMjM0OTAsImp0aSI6InhGdndvNEduNW5adFA1OUUiLCJzdWIiOjUsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.dH3YND7_CqjWQ3BwOhfZw0v2qHt0tNE77N4IeHWXNKc', 1, 2, 'fa', 'fa', 'fa', 0, 1, 11, NULL, 0, 21, '1', '2019-01-24 00:37:33', '2019-01-31 01:25:17'),
(7, 'user3@yahoo.com', '$2y$10$PGaOmD8.HwqzQq4WbPaJE.HC/.c6XOfqFD3JURegd7FigbyNQ5HmO', '12', '/images/profileImages/7fb3aa38d49dc94c1362327.png', 'd6BvWjL5kvE:APA91bHsK_EXkT5pPo_q3JOCX7TadrJHBCmcWKKKcgndUCxGwoQI_45wJJETJfJFXWSlVhSaG8reenASbd5ZlPRvuopDM6WbZL3EwVxgssR6_h5m7VfH_i5aGe7oR78Y2uEqTKS8bJ5g', '2', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMxNTY5NCwiZXhwIjoxNTQ4MzE5Mjk0LCJuYmYiOjE1NDgzMTU2OTQsImp0aSI6IkNWMVVUYWNLZnZ3bzl0b1AiLCJzdWIiOjcsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.QpEG-fezRQWKUsKY5BgqBiK98vIqUJBGwkQp3ic1JpQ', 0, 2, 'android dev', 'jobesk', '12', 0, 0, 0, 2, 0, 20, '1', '2019-01-24 02:40:24', '2019-01-31 00:57:41'),
(9, 'fahadtahir1928@gmail.com', '$2y$10$awETJTZVWBDY.q5JB9h6ueIWAlrJPw4C9pdXKuaVLF3ZzAM97cvOq', NULL, NULL, 'cdln43rtJJ4:APA91bGbkAXzY6H18DcviKz4u0vKhyyP6rBZD_mp--plPsZjNKfN0dPNRcVpdT45h6_3gygaiXCS8RO-OcaTX9t0I9htq-eMLYsFqaOvUm1ZxLWVt_S3Q_Z64jm5ip83YL3wC868274z\r\n\r\n', '1', NULL, '08de6853c17aa4e9b20d923fb403d6024e5da9919d7090063e', 0, 2, NULL, 'jobesk', 'android dev', 0, 0, 0, NULL, 0, 0, '1', '2019-01-30 08:45:58', '2019-01-30 08:45:58'),
(11, 'fahadtahir128@gmail.com', '$2y$10$mPx2SsZ1K6xI9NiHjqkB7evSaQ8.kfwfubJSNOQXAQ9MwfsEeZYRG', 'sssss', NULL, NULL, '1', NULL, 'fcb5f6b585e8c7f7f6657880891700b1f1edf8d3fd9fc521e5', 0, 1, 'ssssss', 'jobesksssssss', 'sss', 0, 0, 0, NULL, 0, 0, '1', '2019-01-30 08:56:04', '2019-01-31 02:11:46'),
(14, 'faha@gmail.com', '$2y$10$7pskJ3TChWxutesrZONv5uMNM9r8VTf74xXnz8UeokzzMELxms2SC', 'fhad', NULL, 'dyWnv69H23k:APA91bFKxUf_pYoBx4W-n1aLJ2iqrB-eSXHSsWcX8GnYZpXPIj5YwfPxka1WwnIK1TyLJaxmkTDf1JIb72iVx03eESlXMfgpEUbmBtZT7KxHHEnn4-wwetSdXk4CIUL5czl1u9Q1KQEt', '1', NULL, '69f693d832b6033bc33ff7d60824686fece057638a7971b786', 0, 2, NULL, NULL, NULL, 0, 0, 0, NULL, 0, 0, '1', '2019-02-01 10:22:27', '2019-02-01 10:22:27'),
(15, 'ahmadsipra@gmail.com', '$2y$10$KFJEb0LNMOk9hkK9oOpuaugcINHOkKZWJ4Bzcc4MYcSYQXW5SoA4e', 'Sipra', NULL, NULL, '1', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvZG9Mb2dpbiIsImlhdCI6MTU1MDE0MzAyNCwiZXhwIjoxNTUwMTQ2NjI0LCJuYmYiOjE1NTAxNDMwMjQsImp0aSI6ImlzN0Zhakl4Zm9YdUNJS2giLCJzdWIiOjE1LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.aXrp60--7kKIW1mrUZbLwsQk-plpXg_LvaoZXdVuXBU', 1, 1, NULL, NULL, NULL, 1, 0, 5, NULL, 0, 0, '1', '2019-01-21 02:30:38', '2019-01-21 02:30:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
