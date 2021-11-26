-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 25, 2019 at 12:39 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `userId`, `followerId`, `created_at`, `updated_at`) VALUES
(3, 3, 2, '2019-01-23 06:42:22', '2019-01-23 06:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toUser` int(11) DEFAULT NULL,
  `fromUser` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `toUser`, `fromUser`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2019-01-24 02:42:50', '2019-01-24 02:42:50'),
(2, 1, 2, '2019-01-24 02:42:50', '2019-01-24 02:42:50');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userId`, `postId`, `notificationTitle`, `notificationData`, `notifiacationStatus`, `notificationType`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, '2019-01-23 11:56:15', '2019-01-23 11:56:15'),
(2, 2, NULL, 'Agenda Update', 'Announcements/notifications from the organisers, Please check the latest Agenda Update', 0, 1, '2019-01-23 11:57:15', '2019-01-23 11:57:15'),
(3, 1, NULL, 'comment on your post', 'testcommented on your post', 1, 2, '2019-01-23 12:23:59', '2019-01-23 12:23:59'),
(4, 1, NULL, 'comment on your post', 'testcommented on your post', 1, 2, '2019-01-23 12:24:05', '2019-01-23 12:24:05'),
(5, 1, NULL, 'comment on your post', 'test commented on your post', 1, 2, '2019-01-23 12:24:10', '2019-01-23 12:24:10'),
(6, 1, NULL, 'comment on your post', 'test commented on your post', 1, 2, '2019-01-23 12:30:19', '2019-01-23 12:30:19'),
(7, 1, 2, 'comment on your post', 'test commented on your post', 1, 2, '2019-01-23 12:31:29', '2019-01-23 12:31:29'),
(8, 1, 2, 'comment on your post', 'test Liked your post', 1, 2, '2019-01-23 12:35:34', '2019-01-23 12:35:34'),
(9, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-23 13:20:46', '2019-01-23 13:20:46'),
(10, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-23 13:23:48', '2019-01-23 13:23:48'),
(11, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:00:16', '2019-01-24 05:00:16'),
(12, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:00:42', '2019-01-24 05:00:42'),
(13, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:00:47', '2019-01-24 05:00:47'),
(14, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:01:03', '2019-01-24 05:01:03'),
(15, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:01:26', '2019-01-24 05:01:26'),
(16, 1, 2, 'Like on your post', 'test Liked your post', 1, 2, '2019-01-24 05:01:58', '2019-01-24 05:01:58'),
(17, 2, NULL, 'Like on your comment', 'test Liked your comment', 0, 2, '2019-01-24 05:02:12', '2019-01-24 05:02:12'),
(18, 5, 1, 'Like on your post', 'test Liked your post', 0, 2, '2019-01-25 06:39:34', '2019-01-25 06:39:34'),
(19, 5, 1, 'Like on your post', 'test Liked your post', 0, 2, '2019-01-25 06:40:59', '2019-01-25 06:40:59'),
(20, 8, 14, 'comment on your post', 'asd commented on your post', 0, 2, '2019-01-25 11:17:59', '2019-01-25 11:17:59'),
(21, 8, 14, 'comment on your post', 'asd commented on your post', 0, 2, '2019-01-25 11:19:36', '2019-01-25 11:19:36'),
(22, 8, 14, 'comment on your post', 'asd commented on your post', 0, 2, '2019-01-25 11:19:42', '2019-01-25 11:19:42'),
(23, 8, 12, 'Like on your post', 'test Liked your post', 0, 2, '2019-01-25 12:13:21', '2019-01-25 12:13:21'),
(24, 5, 28, 'comment on your post', 'ali commented on your post', 0, 2, '2019-01-25 12:29:20', '2019-01-25 12:29:20'),
(25, 5, 28, 'comment on your post', 'ali commented on your post', 0, 2, '2019-01-25 12:29:37', '2019-01-25 12:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postTitile` text,
  `postDescription` longtext,
  `postLikesCount` int(11) NOT NULL DEFAULT '0',
  `postCommentsCount` int(11) NOT NULL DEFAULT '0',
  `postSharesCount` int(11) NOT NULL DEFAULT '0',
  `postMediaType` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `postTitile`, `postDescription`, `postLikesCount`, `postCommentsCount`, `postSharesCount`, `postMediaType`, `created_at`, `updated_at`) VALUES
(12, 8, NULL, 'text', 0, 0, 0, 'image', '2019-01-24 08:24:04', '2019-01-24 08:24:04'),
(14, 8, NULL, 'hi', 0, 3, 0, 'image', '2019-01-24 08:32:58', '2019-01-24 08:32:58'),
(22, 5, 'postTitile', 'One Image', 0, 0, 0, 'image', '2019-01-25 02:12:59', '2019-01-25 02:12:59'),
(23, 5, 'postTitile', 'Asdfasdf', 0, 0, 0, 'image', '2019-01-25 02:21:46', '2019-01-25 02:21:46'),
(24, 5, 'postTitile', 'Three Images', 0, 0, 0, 'image', '2019-01-25 02:22:47', '2019-01-25 02:22:47'),
(25, 5, 'postTitile', 'Three Images', 0, 0, 0, 'image', '2019-01-25 02:25:21', '2019-01-25 02:25:21'),
(26, 5, 'postTitile', 'One Image', 0, 0, 0, 'image', '2019-01-25 02:27:06', '2019-01-25 02:27:06'),
(27, 5, 'postTitile', 'Four Images', 0, 0, 0, 'image', '2019-01-25 02:27:31', '2019-01-25 02:27:31'),
(28, 5, 'postTitile', 'Five Images', 0, 2, 0, 'image', '2019-01-25 02:29:20', '2019-01-25 02:29:20');

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_attachements`
--

INSERT INTO `post_attachements` (`id`, `postId`, `attachmentURL`, `videoURL`, `created_at`, `updated_at`) VALUES
(1, 1, '/images/postImages/1548328698-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
(2, 1, '/images/postImages/1548328700-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
(3, 1, '/images/postImages/1548328702-.png', NULL, '2019-01-24 11:18:26', '2019-01-24 11:18:26'),
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
(64, 28, '/images/postImages/1548401359-.png', NULL, '2019-01-25 07:29:20', '2019-01-25 07:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `commentlikesCount` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `userId`, `postId`, `comment`, `commentlikesCount`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'asd', 1, '2019-01-23 12:17:22', '2019-01-23 12:17:22'),
(2, 8, 14, 'comment', 0, '2019-01-25 11:17:59', '2019-01-25 11:17:59'),
(3, 8, 14, 'comment', 0, '2019-01-25 11:19:36', '2019-01-25 11:19:36'),
(4, 8, 14, 'commentbb', 0, '2019-01-25 11:19:42', '2019-01-25 11:19:42'),
(5, 5, 28, 'This is my comment', 0, '2019-01-25 12:29:20', '2019-01-25 12:29:20'),
(6, 5, 28, 'This is my second Comment', 0, '2019-01-25 12:29:37', '2019-01-25 12:29:37');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment_likes`
--

INSERT INTO `post_comment_likes` (`id`, `commentId`, `userId`, `created_at`, `updated_at`) VALUES
(22, 1, 1, '2019-01-24 05:02:12', '2019-01-24 05:02:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `userId`, `postId`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '2019-01-22 07:29:56', '2019-01-22 07:29:56'),
(4, 5, 3, '2019-01-23 06:00:58', '2019-01-23 06:00:58'),
(7, 5, 2, '2019-01-24 05:01:58', '2019-01-24 05:01:58'),
(13, 8, 1, '2019-01-25 06:40:59', '2019-01-25 06:40:59'),
(14, 1, 2, '2019-01-25 12:13:03', '2019-01-25 12:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `sessionsdocuments`
--

DROP TABLE IF EXISTS `sessionsdocuments`;
CREATE TABLE IF NOT EXISTS `sessionsdocuments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` int(11) NOT NULL,
  `DocattachementURl` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessionsdocuments`
--

INSERT INTO `sessionsdocuments` (`id`, `sessionId`, `DocattachementURl`, `created_at`, `updated_at`) VALUES
(1, 2, 'link', '2019-01-22 10:57:41', '2019-01-22 10:57:41'),
(2, 3, NULL, '2019-01-22 06:13:05', '2019-01-22 06:13:05'),
(3, 3, '/images/sessionDocuments/a7f83e131cd045c6f6a5.pdf', '2019-01-22 06:13:20', '2019-01-22 06:13:20');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speakers`
--

INSERT INTO `speakers` (`id`, `speakerName`, `speakerOccupation`, `speakerCompanyName`, `speakerDetails`, `speakerAddedBy`, `speakerProfileImage`, `created_at`, `updated_at`) VALUES
(1, 'first Speaker', 'Speaker', 'self Company', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:00:31', '2019-01-22 05:00:31'),
(2, 'first Speaker', 'Speaker', 'self Company', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:09:48', '2019-01-22 05:09:48'),
(3, 'first Speaker', 'Speaker', 'self Company', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:09:48', '2019-01-22 05:09:48'),
(4, 'first Speaker', 'Speaker', 'self Company', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:09:50', '2019-01-22 05:09:50'),
(5, 'first Speaker', 'Speaker', 'self Company', 'some details about the speaker', 2, '/images/speakerImages/1db7b59b32276776b3adb.png', '2019-01-22 05:09:52', '2019-01-22 05:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `speaker_sessions`
--

DROP TABLE IF EXISTS `speaker_sessions`;
CREATE TABLE IF NOT EXISTS `speaker_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speakerId` int(11) NOT NULL,
  `sessionName` varchar(1000) NOT NULL,
  `sessionVenue` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `timeFrom` time DEFAULT NULL,
  `timeTo` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speaker_sessions`
--

INSERT INTO `speaker_sessions` (`id`, `speakerId`, `sessionName`, `sessionVenue`, `date`, `timeFrom`, `timeTo`, `created_at`, `updated_at`) VALUES
(1, 1, 'First Session', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:34:30', '2019-01-22 05:37:56'),
(2, 1, 'First Session2', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:34:59', '2019-01-22 05:34:59'),
(3, 1, 'First Session', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:35:05', '2019-01-22 05:35:05'),
(4, 2, 'First Session', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:35:06', '2019-01-22 05:35:06'),
(5, 3, 'First Session', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:35:14', '2019-01-22 05:35:14'),
(6, 3, 'First Session', 'somewhere At Lahore', '2019-01-22', '02:00:00', '04:00:00', '2019-01-22 05:35:15', '2019-01-22 05:35:15');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `addedBy`, `sponsorName`, `sponsorImage`, `sponsorDescription`, `sponsorTitle`, `sponsorshipLevel`, `sponsorwebLink`, `created_at`, `updated_at`) VALUES
(1, 1, 'bNike', '/images/Sponsors/14bf0aeea0ead9c71ed33.png', 'fittness', 'if you have body you are an athelete', 'strign or value based', 'www.nike.com', '2019-01-22 01:52:04', '2019-01-22 01:52:04'),
(2, 1, 'Nike', '/images/Sponsors/14bf0aeea0ead9c71ed33.png', 'fittness', 'if you have body you are an athelete', 'strign or value based', 'www.nike.com', '2019-01-22 01:52:04', '2019-01-22 01:52:04'),
(3, 1, 'aaNike1', '/images/Sponsors/39bf67fb83bb67852d3e1.png', 'fittness', 'if you have body you are an athelete1', 'strign or value based1', 'www.nike.com1', '2019-01-22 01:52:04', '2019-01-22 01:58:44');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `profileImage`, `deviceId`, `deviceType`, `socialType`, `token`, `account_status`, `role`, `contact`, `companyName`, `jobTitle`, `followersCount`, `followingCount`, `postCount`, `pinnedPostId`, `isOnline`, `created_at`, `updated_at`) VALUES
(1, 'ahmad@gmail.com', '$2y$10$dVXjlI.OPdgQds/uVmZyl.6B09VpcZO.VAHLStAdwOgkxv6JhZZpO', 'test', NULL, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MFwvZG9Mb2dpbiIsImlhdCI6MTU0ODMwNzgzMiwiZXhwIjoxNTQ4MzExNDMyLCJuYmYiOjE1NDgzMDc4MzIsImp0aSI6IjNuU3Q2aFB2eklENjJHY1kiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.NnkBYzQoLSJr3wMze-KAzxR-C_bgzxuw3tp1NUUgg84', 1, 2, NULL, NULL, NULL, 0, 1, 8, 2, 0, '2019-01-21 02:30:38', '2019-01-23 04:29:36'),
(2, 'ahmad1@gmail.com', '$2y$10$dVXjlI.OPdgQds/uVmZyl.6B09VpcZO.VAHLStAdwOgkxv6JhZZpO', 'test', NULL, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MFwvZG9Mb2dpbiIsImlhdCI6MTU0ODIyODE1MywiZXhwIjoxNTQ4MjMxNzUzLCJuYmYiOjE1NDgyMjgxNTMsImp0aSI6IlFhQXhnYjR1YkdkN0xZR2kiLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.Y-b9zfOoKdeSjdjnM4idVVdgCq2HVYqVPWkVmTGuXFE', 1, 1, NULL, NULL, NULL, 1, 0, 5, NULL, 0, '2019-01-21 02:30:38', '2019-01-21 02:30:38'),
(3, 'user1@yahoo.com', '$2y$10$gT4BU0bTRozFeINYxrs2KeGef8zRcgZyjMfhW8bhS/LQ16qEkrtu.', 'sheraz', NULL, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMwOTA1NCwiZXhwIjoxNTQ4MzEyNjU0LCJuYmYiOjE1NDgzMDkwNTQsImp0aSI6IkJpazFaMkRMQkFsSE5hS2QiLCJzdWIiOjMsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.KGgNABPA_3enk9nnSATHpiVxVk0dFHtRLdz0vopPw7A', 0, 2, NULL, NULL, NULL, 0, 0, 0, NULL, 0, '2019-01-24 00:15:40', '2019-01-24 00:54:26'),
(4, 'shahbaz@yahoo.com', '$2y$10$1uIWrFYUWiTaS3RBm9zKVu5.tqqMt0NGeQapE.qLnoP/bbhvBwPQ2', 'sheraz', NULL, NULL, NULL, NULL, 'bc6c2d69ee1d24259059c01cd5d093f9d792e65ee3b4e6c94b', 0, 2, NULL, NULL, NULL, 0, 0, 0, NULL, 0, '2019-01-24 00:16:04', '2019-01-24 00:16:04'),
(5, 'ali@gmail.com', '$2y$10$oGwnJ1bjumEyNpNDyTqY8.OjpWyY0mEL7ZwU9irfnuN1u5f6vhj1W', 'ali', '/images/profileImages/5bb6d514bb868ae929b1b34.png', NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMyMzQ5MCwiZXhwIjoxNTQ4MzI3MDkwLCJuYmYiOjE1NDgzMjM0OTAsImp0aSI6InhGdndvNEduNW5adFA1OUUiLCJzdWIiOjUsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.dH3YND7_CqjWQ3BwOhfZw0v2qHt0tNE77N4IeHWXNKc', 0, 2, '&:!!:?!:@&£836(3883', 'jsbs', 'jshvsjs', 0, 0, 7, NULL, 0, '2019-01-24 00:37:33', '2019-01-24 02:46:11'),
(6, 'user2@yahoo.com', '$2y$10$Lo/6frlqgQWUQHGDOTXP1.T5vIrabRf9UvVma8vguQ/F6nn4HckpS', 'oahvvsbs', '/images/profileImages/63643e9637f90b446af8ddc.png', NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMxNTQ4MCwiZXhwIjoxNTQ4MzE5MDgwLCJuYmYiOjE1NDgzMTU0ODAsImp0aSI6Im50dmtDU25wOHRRNXNYYjAiLCJzdWIiOjYsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ._iynI0lAmFw7sdDIXmDj5jv-L7hGRwnPa9TQoz5mnq0', 0, 2, 'habvs', 'babvz', 'babvz', 0, 0, 0, NULL, 0, '2019-01-24 02:30:10', '2019-01-24 02:31:33'),
(7, 'user3@yahoo.com', '$2y$10$PGaOmD8.HwqzQq4WbPaJE.HC/.c6XOfqFD3JURegd7FigbyNQ5HmO', 'user3', '/images/profileImages/7fb3aa38d49dc94c1362327.png', NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9lY2ZkNTUxMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMxNTY5NCwiZXhwIjoxNTQ4MzE5Mjk0LCJuYmYiOjE1NDgzMTU2OTQsImp0aSI6IkNWMVVUYWNLZnZ3bzl0b1AiLCJzdWIiOjcsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.QpEG-fezRQWKUsKY5BgqBiK98vIqUJBGwkQp3ic1JpQ', 0, 2, 'android dev', 'jobesk', 'android dev', 0, 0, 0, 2, 0, '2019-01-24 02:40:24', '2019-01-24 02:57:20'),
(8, 'user4@yahoo.com', '$2y$10$KFJEb0LNMOk9hkK9oOpuaugcINHOkKZWJ4Bzcc4MYcSYQXW5SoA4e', 'asd', NULL, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC85ZjNjM2IyNy5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0ODMzODk0NCwiZXhwIjoxNTQ4MzQyNTQ0LCJuYmYiOjE1NDgzMzg5NDQsImp0aSI6InRQSlpBU3QwbkpSOTREUnciLCJzdWIiOjgsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.pHci-Bthv1EjUdI6wAcdfHY8tcp6dPKD7uKu0RJTP00', 0, 2, NULL, NULL, NULL, 0, 0, 3, NULL, 0, '2019-01-24 05:21:31', '2019-01-24 05:21:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
