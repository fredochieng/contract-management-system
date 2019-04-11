-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2019 at 03:55 PM
-- Server version: 10.1.29-MariaDB
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
-- Database: `legal`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contract_id` bigint(20) NOT NULL,
  `contract_title` varchar(250) DEFAULT NULL,
  `party_name_id` bigint(20) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `description` text,
  `contract_type` int(11) DEFAULT NULL,
  `stage` int(11) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `last_draft_id` bigint(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_action_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`contract_id`, `contract_title`, `party_name_id`, `effective_date`, `expiry_date`, `description`, `contract_type`, `stage`, `status`, `last_draft_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `last_action_by`) VALUES
(1, 'Supply of PCs', 4, '2019-04-14', '2019-04-30', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 2, 4, 'ammended', 17, 2, 2, '2019-04-10 05:24:32', '2019-04-11 08:03:26', 2),
(2, 'Supply of monitors', 5, '2019-04-14', '2019-04-30', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 1, 6, 'approved', 11, 2, 2, '2019-04-10 05:25:40', '2019-04-11 08:03:23', 2),
(3, 'New Two', 4, '2019-04-07', '2019-04-30', 'sdvrgtrhtrhtrhtrh', 2, 4, 'ammended', 20, 2, 2, '2019-04-10 10:10:29', '2019-04-11 08:03:18', 2),
(4, 'Supply of Android Boxes', 1, '2019-04-14', '2019-04-30', 'Dummy text is also used to demonstrate the appearance of different typefaces and layouts, and in general the content of dummy text is nonsensical. Due to its widespread use as filler text for layouts,', 1, 3, 'submitted', 23, 2, 2, '2019-04-11 03:24:23', '2019-04-11 08:03:35', 2),
(5, 'Testing Notifications', 4, '2019-04-11', '2019-05-11', 'erererrerrr', NULL, 2, 'published', 25, 2, 2, '2019-04-11 06:06:48', '2019-04-11 09:11:39', 2),
(6, 'Testing Notifications Part 2', 5, '2019-04-16', '2019-04-30', 'gttt rttttt', NULL, 1, 'created', 26, 2, 2, '2019-04-11 06:27:41', '2019-04-11 09:27:41', 2),
(7, 'Testing Notifications Part 3', 1, '2019-04-11', '2019-04-30', 'jhhn', NULL, 1, 'created', 27, 2, 2, '2019-04-11 06:30:05', '2019-04-11 09:30:05', 2),
(8, 'Testing Notifications Part 4', 4, '2019-04-12', '2019-05-01', 'jijji', NULL, 1, 'created', 28, 2, 2, '2019-04-11 06:31:18', '2019-04-11 09:31:18', 2),
(9, 'Testing Notifications Part 5', 1, '2019-04-14', '2019-04-24', 'xcuh', NULL, 1, 'created', 29, 2, 2, '2019-04-11 06:37:48', '2019-04-11 09:37:48', 2),
(10, 'Testing Notifications Part 6', 4, '1970-01-01', '1970-01-01', 'frfrrrggg fdfdff', NULL, 1, 'created', 30, 2, 2, '2019-04-11 06:41:37', '2019-04-11 09:16:20', 2),
(11, 'Testing Notifications Part 7', 4, '2019-04-17', '2019-04-24', 'errr', NULL, 2, 'published', 46, 2, 2, '2019-04-11 06:46:08', '2019-04-11 11:31:51', 2),
(12, 'Testing Notifications Part 8', 4, '2019-04-14', '2019-04-26', 'dwef', NULL, 5, 'terminated', 56, 2, 2, '2019-04-11 06:47:33', '2019-04-11 12:10:34', 2),
(13, 'Testing Notifications Part 8', 4, '2019-04-21', '2019-04-22', 'rr4r4', 2, 6, 'approved', 55, 2, 2, '2019-04-11 06:53:00', '2019-04-11 12:05:58', 2),
(14, 'Testing Notifications Part 9', 4, '2019-04-15', '2019-04-25', 'efrferer', NULL, 4, 'ammended', 53, 2, 2, '2019-04-11 07:42:11', '2019-04-11 12:04:10', 2),
(15, 'Testing Notifications Part 9', 4, '2019-04-15', '2019-04-25', 'efrferer', NULL, 5, 'terminated', 52, 2, 2, '2019-04-11 07:42:32', '2019-04-11 11:44:12', 2),
(16, 'Testing Notifications Part 9', 4, '2019-04-15', '2019-04-25', 'efrferer', NULL, 4, 'ammended', 51, 2, 2, '2019-04-11 07:44:33', '2019-04-11 11:43:42', 2),
(17, 'Testing Notifications Part 10', 5, '2019-04-12', '2019-04-30', '3rgtggghyhyh', 2, 6, 'approved', 50, 2, 2, '2019-04-11 07:46:54', '2019-04-11 11:41:01', 2),
(18, 'Testing Notifications Part 11', 4, '2019-04-14', '2019-04-25', 'fvrgvgv', 1, 6, 'approved', 48, 2, 2, '2019-04-11 07:50:49', '2019-04-11 11:39:46', 2),
(19, 'Testing Notifications Part 13', 1, '2019-04-11', '2019-04-30', 'weftrtrhtt', NULL, 1, 'created', 57, 2, 2, '2019-04-11 09:16:51', '2019-04-11 12:16:51', 2),
(20, 'Testing Notifications Part 15', 4, '2019-04-15', '2019-04-17', 'ghhhhhhhh', NULL, 1, 'created', 58, 2, 2, '2019-04-11 10:08:18', '2019-04-11 13:08:18', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contract_drafts`
--

CREATE TABLE `contract_drafts` (
  `contract_draft_id` bigint(20) NOT NULL,
  `contract_id` bigint(20) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `draft_file` text,
  `status` varchar(250) DEFAULT NULL,
  `comments` longtext,
  `crf_file` text,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contract_drafts`
--

INSERT INTO `contract_drafts` (`contract_draft_id`, `contract_id`, `stage_id`, `draft_file`, `status`, `comments`, `crf_file`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'uploads/contract_documents/FqDiCqrZB2eRkdngEgqoEXuPsq3vWx.png', 'created', NULL, 'uploads/contract_documents/XSmN23Wbtck10j5KjLm0nzvQ3jqFB4.png', 2, 2, '2019-04-10 08:24:32', '2019-04-10 08:24:32'),
(2, 2, 1, 'uploads/contract_documents/R6ds6G8QoveJ7Sjq3tSYUAtWs4qIQ6.png', 'created', NULL, 'uploads/contract_documents/DgcZVrcM5Hd0UzzhU7rf9grpKvU1N6.png', 2, 2, '2019-04-10 08:25:41', '2019-04-10 08:25:41'),
(5, 2, 2, 'uploads/contract_documents/R6ds6G8QoveJ7Sjq3tSYUAtWs4qIQ6.png', 'published', NULL, 'uploads/contract_documents/DgcZVrcM5Hd0UzzhU7rf9grpKvU1N6.png', 2, 2, '2019-04-10 08:44:05', '2019-04-10 08:44:05'),
(10, 2, 3, 'uploads/contract_documents/R6ds6G8QoveJ7Sjq3tSYUAtWs4qIQ6.png', 'submitted', 'Approved by me for admin final legal admin approval', 'uploads/contract_documents/DgcZVrcM5Hd0UzzhU7rf9grpKvU1N6.png', 2, 2, '2019-04-10 09:25:47', '2019-04-10 09:25:47'),
(11, 2, 6, 'uploads/contract_documents/R6ds6G8QoveJ7Sjq3tSYUAtWs4qIQ6.png', 'approved', 'The contract is good and I approve it  for shelving by the legal team', 'uploads/contract_documents/DgcZVrcM5Hd0UzzhU7rf9grpKvU1N6.png', 2, 2, '2019-04-10 09:27:27', '2019-04-10 09:27:27'),
(12, 1, 2, 'uploads/contract_documents/FqDiCqrZB2eRkdngEgqoEXuPsq3vWx.png', 'published', NULL, 'uploads/contract_documents/XSmN23Wbtck10j5KjLm0nzvQ3jqFB4.png', 2, 2, '2019-04-10 09:50:11', '2019-04-10 09:50:11'),
(17, 1, 4, 'uploads/contract_documents/FqDiCqrZB2eRkdngEgqoEXuPsq3vWx.png', 'ammended', 'Ammende for further actions', 'uploads/contract_documents/XSmN23Wbtck10j5KjLm0nzvQ3jqFB4.png', 2, 2, '2019-04-10 11:07:08', '2019-04-10 11:07:08'),
(18, 3, 1, 'uploads/contract_documents/p8Vgu2IA5K0U7Qvnl00NZsynYAs9f8.png', 'created', NULL, 'uploads/contract_documents/PEAltHAMtQZOp32WEWP8GDeiUSyX9K.png', 2, 2, '2019-04-10 13:10:29', '2019-04-10 13:10:29'),
(19, 3, 2, 'uploads/contract_documents/p8Vgu2IA5K0U7Qvnl00NZsynYAs9f8.png', 'published', NULL, 'uploads/contract_documents/PEAltHAMtQZOp32WEWP8GDeiUSyX9K.png', 2, 2, '2019-04-10 13:10:47', '2019-04-10 13:10:47'),
(20, 3, 4, 'uploads/contract_documents/RtrvLCbduJ9UTSOExTueZaT65RE9J9.png', 'ammended', 'weftrh3t44545y', 'uploads/contract_documents/IkAKNfK5dUiTTePzFxwMnzbOlATPiM.png', 2, 2, '2019-04-10 13:11:50', '2019-04-10 13:11:50'),
(21, 4, 1, 'uploads/contract_documents/lsuSUCcsAAaextql5juTOh5n90N606.png', 'created', NULL, 'uploads/contract_documents/izQ7J0zQxX1Vvf8Y1Z3mkKisv9Y5rI.png', 2, 2, '2019-04-11 06:24:23', '2019-04-11 06:24:23'),
(22, 4, 2, 'uploads/contract_documents/lsuSUCcsAAaextql5juTOh5n90N606.png', 'published', NULL, 'uploads/contract_documents/izQ7J0zQxX1Vvf8Y1Z3mkKisv9Y5rI.png', 2, 2, '2019-04-11 06:28:58', '2019-04-11 06:28:58'),
(23, 4, 3, 'uploads/contract_documents/lsuSUCcsAAaextql5juTOh5n90N606.png', 'submitted', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'uploads/contract_documents/izQ7J0zQxX1Vvf8Y1Z3mkKisv9Y5rI.png', 2, 2, '2019-04-11 08:02:24', '2019-04-11 08:02:24'),
(24, 5, 1, 'uploads/contract_documents/1KK23Yz8HafmF5CNvOTrElsVsEW5vH.png', 'created', NULL, 'uploads/contract_documents/Sw0t6UTXmM0ywo8oWg3bawnVYaOZ4r.png', 2, 2, '2019-04-11 09:06:48', '2019-04-11 09:06:48'),
(25, 5, 2, 'uploads/contract_documents/1KK23Yz8HafmF5CNvOTrElsVsEW5vH.png', 'published', NULL, 'uploads/contract_documents/Sw0t6UTXmM0ywo8oWg3bawnVYaOZ4r.png', 2, 2, '2019-04-11 09:11:39', '2019-04-11 09:11:39'),
(26, 6, 1, 'uploads/contract_documents/s1OEnxXKzsE6Rmd2WDhnRCK3qiYvdO.png', 'created', NULL, 'uploads/contract_documents/RpTqq9Zu6kzW1mU0HmrRmghaLbFzqM.png', 2, 2, '2019-04-11 09:27:41', '2019-04-11 09:27:41'),
(27, 7, 1, 'uploads/contract_documents/mCLtmy14MctitE0sMp172KtTbe4Dsv.png', 'created', NULL, 'uploads/contract_documents/ob8e631s7yCq77yHf0ShvmjBrSEKXL.png', 2, 2, '2019-04-11 09:30:05', '2019-04-11 09:30:05'),
(28, 8, 1, 'uploads/contract_documents/aMnKGT71olgaZmrZgimjwsdgoRZvYu.png', 'created', NULL, 'uploads/contract_documents/WRSYZUBADTR8cEsQ1e9wV1l3Ylr05s.png', 2, 2, '2019-04-11 09:31:18', '2019-04-11 09:31:18'),
(29, 9, 1, 'uploads/contract_documents/1zNTaP9dbJmXh5sO3g2TK5fFdNrDdz.png', 'created', NULL, 'uploads/contract_documents/ZJIcx1ZVC9i4W6Cvpo6sSFK9hfStAS.png', 2, 2, '2019-04-11 09:37:48', '2019-04-11 09:37:48'),
(30, 10, 1, '', 'created', NULL, '', 2, 2, '2019-04-11 09:41:38', '2019-04-11 12:15:00'),
(31, 11, 1, 'uploads/contract_documents/6aHHNRAHFwozAFkjOJ4g23pSRatwWK.png', 'created', NULL, 'uploads/contract_documents/bjkTVj5sSGGGGJHxNv1q05V8Y4tm3l.png', 2, 2, '2019-04-11 09:46:08', '2019-04-11 09:46:08'),
(32, 12, 1, 'uploads/contract_documents/cIV6IcSKgzWvrS2kw4zSKzyHIorarN.png', 'created', NULL, 'uploads/contract_documents/SX4ZvsFdjsNGZTDq4F1OVasPV7GjZ1.png', 2, 2, '2019-04-11 09:47:33', '2019-04-11 09:47:33'),
(33, 13, 1, 'uploads/contract_documents/B0a5GUzhHvhypcdCiyLVz1UVKBTrdY.png', 'created', NULL, 'uploads/contract_documents/VmH6C5oyX315pByzXnTejeX7buj5NS.png', 2, 2, '2019-04-11 09:53:00', '2019-04-11 09:53:00'),
(34, 14, 1, 'uploads/contract_documents/qiuTNCvWFqDqLrvACHgJbU0UUgyNDe.png', 'created', NULL, 'uploads/contract_documents/Zd5qmRkU31dYPx1YcGtLSAWps80vFx.png', 2, 2, '2019-04-11 10:42:11', '2019-04-11 10:42:11'),
(35, 15, 1, 'uploads/contract_documents/DToMGiTeJN58Fb5qDPJoOooU0VyoJM.png', 'created', NULL, 'uploads/contract_documents/aql7y0HjMNUmtGdNChaVCEIGaGexjC.png', 2, 2, '2019-04-11 10:42:32', '2019-04-11 10:42:32'),
(36, 16, 1, 'uploads/contract_documents/FRtOqvmd59kWxgVjWKvChlYZLi10Re.png', 'created', NULL, 'uploads/contract_documents/uF1TFjGp9yXtNkdsGYJkOyYneJJTBs.png', 2, 2, '2019-04-11 10:44:34', '2019-04-11 10:44:34'),
(37, 17, 1, 'uploads/contract_documents/aL16tpyZZGGh9fpbMTShc96iilrleI.png', 'created', NULL, 'uploads/contract_documents/YprgHD8Ad1tyeHdOakgZgZ2CAcN0Ra.png', 2, 2, '2019-04-11 10:46:54', '2019-04-11 10:46:54'),
(38, 18, 1, 'uploads/contract_documents/HRmEITIyLUDopyD6hUjjxObpuGwb8r.png', 'created', NULL, 'uploads/contract_documents/vNJzXFk0S8efBSfqB3ffd22mlfSYNB.png', 2, 2, '2019-04-11 10:50:49', '2019-04-11 10:50:49'),
(39, 18, 2, 'uploads/contract_documents/HRmEITIyLUDopyD6hUjjxObpuGwb8r.png', 'published', NULL, 'uploads/contract_documents/vNJzXFk0S8efBSfqB3ffd22mlfSYNB.png', 2, 2, '2019-04-11 11:08:49', '2019-04-11 11:08:49'),
(40, 17, 2, 'uploads/contract_documents/aL16tpyZZGGh9fpbMTShc96iilrleI.png', 'published', NULL, 'uploads/contract_documents/YprgHD8Ad1tyeHdOakgZgZ2CAcN0Ra.png', 2, 2, '2019-04-11 11:09:51', '2019-04-11 11:09:51'),
(41, 16, 2, 'uploads/contract_documents/FRtOqvmd59kWxgVjWKvChlYZLi10Re.png', 'published', NULL, 'uploads/contract_documents/uF1TFjGp9yXtNkdsGYJkOyYneJJTBs.png', 2, 2, '2019-04-11 11:19:26', '2019-04-11 11:19:26'),
(42, 15, 2, 'uploads/contract_documents/DToMGiTeJN58Fb5qDPJoOooU0VyoJM.png', 'published', NULL, 'uploads/contract_documents/aql7y0HjMNUmtGdNChaVCEIGaGexjC.png', 2, 2, '2019-04-11 11:24:34', '2019-04-11 11:24:34'),
(43, 14, 2, 'uploads/contract_documents/qiuTNCvWFqDqLrvACHgJbU0UUgyNDe.png', 'published', NULL, 'uploads/contract_documents/Zd5qmRkU31dYPx1YcGtLSAWps80vFx.png', 2, 2, '2019-04-11 11:27:43', '2019-04-11 11:27:43'),
(44, 13, 2, 'uploads/contract_documents/B0a5GUzhHvhypcdCiyLVz1UVKBTrdY.png', 'published', NULL, 'uploads/contract_documents/VmH6C5oyX315pByzXnTejeX7buj5NS.png', 2, 2, '2019-04-11 11:28:37', '2019-04-11 11:28:37'),
(45, 12, 2, 'uploads/contract_documents/cIV6IcSKgzWvrS2kw4zSKzyHIorarN.png', 'published', NULL, 'uploads/contract_documents/SX4ZvsFdjsNGZTDq4F1OVasPV7GjZ1.png', 2, 2, '2019-04-11 11:31:09', '2019-04-11 11:31:09'),
(46, 11, 2, 'uploads/contract_documents/6aHHNRAHFwozAFkjOJ4g23pSRatwWK.png', 'published', NULL, 'uploads/contract_documents/bjkTVj5sSGGGGJHxNv1q05V8Y4tm3l.png', 2, 2, '2019-04-11 11:31:51', '2019-04-11 11:31:51'),
(47, 18, 3, 'uploads/contract_documents/HRmEITIyLUDopyD6hUjjxObpuGwb8r.png', 'submitted', 'the contract is good', 'uploads/contract_documents/vNJzXFk0S8efBSfqB3ffd22mlfSYNB.png', 2, 2, '2019-04-11 11:39:05', '2019-04-11 11:39:05'),
(48, 18, 6, 'uploads/contract_documents/HRmEITIyLUDopyD6hUjjxObpuGwb8r.png', 'approved', 'approved for shelving', 'uploads/contract_documents/vNJzXFk0S8efBSfqB3ffd22mlfSYNB.png', 2, 2, '2019-04-11 11:39:46', '2019-04-11 11:39:46'),
(49, 17, 3, 'uploads/contract_documents/aL16tpyZZGGh9fpbMTShc96iilrleI.png', 'submitted', 'rrrrt', 'uploads/contract_documents/YprgHD8Ad1tyeHdOakgZgZ2CAcN0Ra.png', 2, 2, '2019-04-11 11:40:52', '2019-04-11 11:40:52'),
(50, 17, 6, 'uploads/contract_documents/aL16tpyZZGGh9fpbMTShc96iilrleI.png', 'approved', '4tty', 'uploads/contract_documents/YprgHD8Ad1tyeHdOakgZgZ2CAcN0Ra.png', 2, 2, '2019-04-11 11:41:01', '2019-04-11 11:41:01'),
(51, 16, 4, 'uploads/contract_documents/mx7C6bwabXxFSxU4fdwNklrWhFDLVG.png', 'ammended', 'mj jjyh nymy', 'uploads/contract_documents/OoW0sJlGoYNp9IY0RyvljLz2ZBducf.png', 2, 2, '2019-04-11 11:43:42', '2019-04-11 11:43:42'),
(52, 15, 5, 'uploads/contract_documents/DToMGiTeJN58Fb5qDPJoOooU0VyoJM.png', 'terminated', 'loioio', 'uploads/contract_documents/aql7y0HjMNUmtGdNChaVCEIGaGexjC.png', 2, 2, '2019-04-11 11:44:12', '2019-04-11 11:44:12'),
(53, 14, 4, 'uploads/contract_documents/qiuTNCvWFqDqLrvACHgJbU0UUgyNDe.png', 'ammended', 'ammende by me', 'uploads/contract_documents/Zd5qmRkU31dYPx1YcGtLSAWps80vFx.png', 2, 2, '2019-04-11 12:04:10', '2019-04-11 12:04:10'),
(54, 13, 3, 'uploads/contract_documents/B0a5GUzhHvhypcdCiyLVz1UVKBTrdY.png', 'submitted', 'submitted by meeeeeeee', 'uploads/contract_documents/VmH6C5oyX315pByzXnTejeX7buj5NS.png', 2, 2, '2019-04-11 12:05:52', '2019-04-11 12:05:52'),
(55, 13, 6, 'uploads/contract_documents/B0a5GUzhHvhypcdCiyLVz1UVKBTrdY.png', 'approved', 'rfrfrfr', 'uploads/contract_documents/VmH6C5oyX315pByzXnTejeX7buj5NS.png', 2, 2, '2019-04-11 12:05:58', '2019-04-11 12:05:58'),
(56, 12, 5, 'uploads/contract_documents/cIV6IcSKgzWvrS2kw4zSKzyHIorarN.png', 'terminated', 'f fff', 'uploads/contract_documents/SX4ZvsFdjsNGZTDq4F1OVasPV7GjZ1.png', 2, 2, '2019-04-11 12:10:34', '2019-04-11 12:10:34'),
(57, 19, 1, 'uploads/contract_documents/S39DPxOcaIUochW7kd8Ge4dU7mgVyu.png', 'created', NULL, 'uploads/contract_documents/szT0TVYaODrzzXwvLwYF7PNgP3tchk.png', 2, 2, '2019-04-11 12:16:51', '2019-04-11 12:16:51'),
(58, 20, 1, 'uploads/contract_documents/4A3JNBmpOtMCcFuGOBzr9JLJvif2ao.txt', 'created', NULL, 'uploads/contract_documents/r9yXvoOPFP4rNDOCEdNNrSK5gDQDWc.docx', 2, 2, '2019-04-11 13:08:18', '2019-04-11 13:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `contract_types`
--

CREATE TABLE `contract_types` (
  `contract_type_id` int(255) NOT NULL,
  `contract_type_name` varchar(255) DEFAULT NULL,
  `contract_type_description` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contract_types`
--

INSERT INTO `contract_types` (`contract_type_id`, `contract_type_name`, `contract_type_description`) VALUES
(1, 'Standard', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(2, 'Non Standard', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Table structure for table `draft_stages`
--

CREATE TABLE `draft_stages` (
  `draft_stage_id` int(11) NOT NULL,
  `task_name` varchar(250) NOT NULL,
  `task` varchar(250) NOT NULL,
  `task_description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `draft_stages`
--

INSERT INTO `draft_stages` (`draft_stage_id`, `task_name`, `task`, `task_description`) VALUES
(1, 'Contract Created', 'Contract created ', NULL),
(2, 'Contract Published', 'Contract published for Legal Team to review', NULL),
(3, 'Contract Submitted', 'Contract submitted by Legal Team to Legal Admin', NULL),
(4, 'Contract Ammended', 'Contract ammended by Legal Team and back to the initiator', NULL),
(5, 'Contract Terminated', 'Contract terminated by Legal Team', NULL),
(6, 'Contract Approved', 'Contract approvedby Legal Admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `draft_status`
--

CREATE TABLE `draft_status` (
  `draft_status_id` int(11) NOT NULL,
  `draft_status_name` varchar(250) NOT NULL,
  `draft_status_color_code` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_02_06_140412_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 13),
(6, 'App\\User', 1),
(6, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `party_id` bigint(20) NOT NULL,
  `party_name` varchar(250) NOT NULL,
  `address` text,
  `telephone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`party_id`, `party_name`, `address`, `telephone`, `email`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Android Box Co.', '15425522', '0713295850', 'kevin.ochieng@ke.wananchi.com', 1, 2, '2019-02-08 08:29:07', '2019-04-02 08:26:39'),
(4, 'Safaricom', '15425522', '0713295853', 'mkinyanjui@camusat.com', 1, 1, '2019-02-14 03:32:48', '2019-02-14 03:32:48'),
(5, 'East Africa Cables', 'Umoja, Innercore', '071326955', 'mail@yahoo.com', 1, 1, '2019-04-01 10:36:07', '2019-04-01 10:36:07'),
(6, 'Amazon', '21215, 456', '0756525467', 'person@amazon.com', 2, 2, '2019-04-05 05:38:03', '2019-04-05 05:38:03'),
(7, 'gfgvyffv', '21215, 456', '087765656676', 'christin@gmail.com', 2, 2, '2019-04-06 05:00:44', '2019-04-06 05:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Contract Create', 'web', NULL, NULL),
(2, 'Contract Approve', 'web', NULL, NULL),
(3, 'Contract Ammend', 'web', NULL, NULL),
(4, 'Contract Edit', 'web', NULL, NULL),
(5, 'Contract Delete', 'web', NULL, NULL),
(6, 'Contract Terminate', 'web', NULL, NULL),
(7, 'Contract Publish', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Standard User', 'web', NULL, NULL),
(2, 'Legal Counsel', 'web', NULL, NULL),
(3, 'Legal Manager', 'web', NULL, NULL),
(4, 'Head of Legal', 'web', NULL, NULL),
(5, 'Legal Admin', 'web', NULL, NULL),
(6, 'Admin', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(4, 1),
(5, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kevin Ochieng', 'kevin.ochieng@ke.wananchi.com', NULL, '$2y$10$x/jL4GUmYQXhFlpz6Tcxh.SQEaYH2wHnv.qtMJ/COBIeN4Sn0xnaG', 'vIbjGTQumzjYhYrn9vpTDhzTcQrYxAl1CH1mo9G3dsO9ZDhxr8wLFNu7QY0x', '2019-02-06 11:07:24', '2019-02-06 11:07:24'),
(2, 'Fredrick Ochieng', 'fredrick.ochieng@ke.wananchi.com', NULL, '$2y$10$/9v77lJS/IqRwdvWbe5CROhfnSkfIsDg2twr8gG8I.bypyCq8A1v6', 'QA5XbHFwYAHYp2e94tmdhbGTv1BrOq7HvyanHniaQ9xfZfleNRHamgAoaVU4', '2019-04-02 03:59:27', '2019-04-02 03:59:27'),
(3, 'yuhhfg', 'fcfcf@me.com', NULL, '$2y$10$qastldARhGVdLzvkL4prj.XxStLdqGGgJtBLmNmkdYil2Ta3kb5je', NULL, '2019-04-08 16:56:29', '2019-04-08 16:56:29'),
(4, 'new user', 'new@me.com', NULL, '$2y$10$IPasZbjiwZo/aU4Lz/N7Z.kbEHli6huWP4KPwkjydB9CONQcJTJsy', NULL, '2019-04-09 09:51:43', '2019-04-09 09:51:43'),
(5, 'rftrty', 'new@mefff.com', NULL, '$2y$10$p8tQhV2lV7u.eh719ipE/e5pv6h0ioZHTk2sojk5SlUxutkw0Ja8e', NULL, '2019-04-09 10:46:19', '2019-04-09 10:46:19'),
(6, 'ewef5r5y', 'erftrg@meeeee.com', NULL, '$2y$10$ErMgxz.bPS2CjUBI89xiN.0NZSonWgSw5R8h7m8bSUQ9tJAsXNWMi', NULL, '2019-04-09 11:19:53', '2019-04-09 11:19:53'),
(7, 'xdfbfghgh', 'vvvvvvv@me.com', NULL, '$2y$10$wWtUhsdYSvmmE.BoaaCTaOIjym5vWD2b47pn2TnutKJW.4FyT3/2K', NULL, '2019-04-09 11:20:30', '2019-04-09 11:20:30'),
(8, 'Mark Oloo Jachode', 'jachode@mon.com', NULL, '$2y$10$cP.Kz.VfL.MK6mH3OEqjdujjeVBwzLFlISe7Cr/jt130pVUqfZrT2', NULL, '2019-04-09 15:08:54', '2019-04-09 15:08:54'),
(9, 'vincent oloo', 'oloov@me.com', NULL, '$2y$10$LMRS0skBLgF3wFaHMtWKh.Noy0jyhXxbbM6E2QU0V8O8B9KlflX9W', NULL, '2019-04-09 15:10:03', '2019-04-09 15:10:03'),
(10, 'betty kamau', 'betty@me.com', NULL, '$2y$10$MffMkAlC5vrBA5Qtsa8fb.Lde79ou9d/ifGIUcc3X8Ndq1DowYFly', NULL, '2019-04-09 15:39:13', '2019-04-09 15:39:13'),
(11, 'User Today', 'usertoday@zuku.com', NULL, '$2y$10$jWO4OiSjGcUxB1/XE8dPHuWymQT6hqDxse2BG1MtF2zStnFbkEJxS', NULL, '2019-04-10 09:21:32', '2019-04-10 09:21:32'),
(12, 'New Today', 'new@mmmmmm.com', NULL, '$2y$10$kFon/LUL/WMwyC0.8TEPi.LtGjsNotmaBFO582cUrx5c4xbE7zxkW', NULL, '2019-04-10 10:13:23', '2019-04-10 10:13:23'),
(13, 'Testing Roles', 'testing@zuku.com', NULL, '$2y$10$i5x9QGnekpZyHrW9jFxjyOFHOhVc4ycwBN4mIPVAsVhlYY4GXe48e', NULL, '2019-04-10 10:35:58', '2019-04-10 10:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `detailed_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `job_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_details`
--

INSERT INTO `users_details` (`detailed_id`, `user_id`, `organization_id`, `job_title`) VALUES
(2, 2, 1, 'Procurement Manager'),
(3, 9, 1, 'Data'),
(4, 10, 2, 'it tech'),
(5, 11, 2, 'My Job Title'),
(6, 12, 2, 'HR'),
(7, 13, 2, 'Testing Engineer');

-- --------------------------------------------------------

--
-- Table structure for table `users_organizations`
--

CREATE TABLE `users_organizations` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_organizations`
--

INSERT INTO `users_organizations` (`organization_id`, `organization_name`) VALUES
(1, 'ZUKU'),
(2, 'SIMBANET');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_id`);

--
-- Indexes for table `contract_drafts`
--
ALTER TABLE `contract_drafts`
  ADD PRIMARY KEY (`contract_draft_id`);

--
-- Indexes for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD PRIMARY KEY (`contract_type_id`);

--
-- Indexes for table `draft_stages`
--
ALTER TABLE `draft_stages`
  ADD PRIMARY KEY (`draft_stage_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`detailed_id`);

--
-- Indexes for table `users_organizations`
--
ALTER TABLE `users_organizations`
  ADD PRIMARY KEY (`organization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contract_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contract_drafts`
--
ALTER TABLE `contract_drafts`
  MODIFY `contract_draft_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `contract_types`
--
ALTER TABLE `contract_types`
  MODIFY `contract_type_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `draft_stages`
--
ALTER TABLE `draft_stages`
  MODIFY `draft_stage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `detailed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_organizations`
--
ALTER TABLE `users_organizations`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
