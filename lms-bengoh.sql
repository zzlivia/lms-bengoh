-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 01:44 AM
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
-- Database: `lms-bengoh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` bigint(20) UNSIGNED NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `adminEmail` varchar(255) NOT NULL,
  `adminPass` varchar(255) NOT NULL,
  `adminRole` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminEmail`, `adminPass`, `adminRole`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'Administrator', 'admin@testing.com', '$2y$12$ieSTL9uIYsbITDqkPdq3kuTliGOQkoA4kqTO9SfEGqPIv1Hiyq/vO', 'admin', '2026-04-08 14:56:56', '2026-04-08 14:56:56', 'DK9KumEI9lJiQldUL8gNbaJb9grj1Su2sIfzvXbAMk13exHurX7JRqStMPMR');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT 0,
  `font_size` varchar(255) DEFAULT NULL,
  `export_format` varchar(255) DEFAULT NULL,
  `max_file_size` int(11) DEFAULT NULL,
  `video_resolution_limit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementID` bigint(20) UNSIGNED NOT NULL,
  `announcementTitle` varchar(255) NOT NULL,
  `announcementDetails` text NOT NULL,
  `adminID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_mcq_options`
--

CREATE TABLE `assessment_mcq_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assQsID` bigint(20) UNSIGNED NOT NULL,
  `optionText` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_mcq_options`
--

INSERT INTO `assessment_mcq_options` (`id`, `assQsID`, `optionText`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 'Causing floods', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(2, 1, 'Producing electricity', 1, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(3, 1, 'Destroying ecosystems', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(4, 1, 'Reducing rainfall', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(5, 2, 'To make it look attractive', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(6, 2, 'To ensure safety, efficiency, and durability', 1, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(7, 2, 'To reduce water flow', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(8, 2, 'To increase pollution', 0, '2026-04-08 15:08:34', '2026-04-08 15:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_qs`
--

CREATE TABLE `assessment_qs` (
  `assQsID` bigint(20) UNSIGNED NOT NULL,
  `courseAssID` bigint(20) UNSIGNED NOT NULL,
  `courseAssQs` text NOT NULL,
  `courseAssType` enum('MCQ','SHORT_ANSWER','LONG_ANSWER') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_qs`
--

INSERT INTO `assessment_qs` (`assQsID`, `courseAssID`, `courseAssQs`, `courseAssType`, `created_at`, `updated_at`) VALUES
(1, 1, 'What is one benefit of dams?', 'MCQ', '2026-04-08 15:08:34', '2026-04-08 15:08:34'),
(2, 1, 'Why is choosing the right location important when building a dam?', 'MCQ', '2026-04-08 15:08:34', '2026-04-08 15:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_results`
--

CREATE TABLE `assessment_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `moduleID` bigint(20) UNSIGNED NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_results`
--

INSERT INTO `assessment_results` (`id`, `userID`, `moduleID`, `courseID`, `score`, `attempts`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 20, 3, 'mcq', 'fail', '2026-04-19 05:58:25', '2026-04-19 05:58:25'),
(2, 1, 1, 1, 80, 0, 'final', 'pass', '2026-04-12 08:43:02', '2026-04-12 08:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `community_stories`
--

CREATE TABLE `community_stories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `community_story` text NOT NULL,
  `community_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `adminID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `courseCode` varchar(255) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `courseAuthor` varchar(255) NOT NULL,
  `courseDesc` text NOT NULL,
  `courseCategory` varchar(255) NOT NULL,
  `courseLevel` varchar(255) NOT NULL,
  `courseDuration` varchar(255) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 1,
  `courseImg` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseCode`, `courseName`, `courseAuthor`, `courseDesc`, `courseCategory`, `courseLevel`, `courseDuration`, `isAvailable`, `courseImg`, `created_at`, `updated_at`) VALUES
(1, 'H001', 'Learn Local History', 'Local Community Org', 'Learn more on local history of the dam', 'History', 'Beginner', '1', 1, 'courses-assets/1775736395.png', '2026-04-08 14:57:58', '2026-04-09 04:06:35'),
(2, 'M001', 'Marketing a Local Homestay', 'Ali Kassim', 'testing', 'Marketing', 'Intermediate', '2', 1, 'courses-assets/1776039808.png', '2026-04-12 16:15:58', '2026-04-12 16:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `courseassanswers`
--

CREATE TABLE `courseassanswers` (
  `answersAssID` bigint(20) UNSIGNED NOT NULL,
  `attemptID` bigint(20) UNSIGNED NOT NULL,
  `assQsID` bigint(20) UNSIGNED NOT NULL,
  `selected_option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courseassattempts`
--

CREATE TABLE `courseassattempts` (
  `attemptID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `courseAssID` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coursefeedback`
--

CREATE TABLE `coursefeedback` (
  `feedbackID` bigint(20) UNSIGNED NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `clarity` varchar(255) DEFAULT NULL,
  `understanding` varchar(255) DEFAULT NULL,
  `favorite_module` varchar(255) DEFAULT NULL,
  `enjoyed` text DEFAULT NULL,
  `suggestions` text DEFAULT NULL,
  `userID` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coursefeedback`
--

INSERT INTO `coursefeedback` (`feedbackID`, `courseID`, `created_at`, `updated_at`, `clarity`, `understanding`, `favorite_module`, `enjoyed`, `suggestions`, `userID`, `rating`, `is_reviewed`) VALUES
(1, 1, '2026-04-08 17:06:04', '2026-04-08 17:07:53', 'Average', 'Not really', NULL, NULL, NULL, 1, 5, 1),
(2, 1, '2026-04-12 08:16:53', '2026-04-12 21:46:04', 'Average', 'Somewhat', NULL, NULL, NULL, 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_assessments`
--

CREATE TABLE `course_assessments` (
  `courseAssID` bigint(20) UNSIGNED NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `courseAssTitle` varchar(255) NOT NULL,
  `courseAssDesc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_assessments`
--

INSERT INTO `course_assessments` (`courseAssID`, `courseID`, `courseAssTitle`, `courseAssDesc`, `created_at`, `updated_at`) VALUES
(1, 1, 'Course Assessment', NULL, '2026-04-08 15:07:25', '2026-04-08 15:07:25'),
(2, 1, 'testing', NULL, '2026-04-08 17:09:03', '2026-04-08 17:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `enrolmentcoursemodules`
--

CREATE TABLE `enrolmentcoursemodules` (
  `enrollID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `moduleID` bigint(20) UNSIGNED NOT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT 0,
  `inProgress` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrolmentcoursemodules`
--

INSERT INTO `enrolmentcoursemodules` (`enrollID`, `userID`, `courseID`, `moduleID`, `isCompleted`, `inProgress`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 0, '2026-04-16 17:57:04', '2026-04-16 17:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `leaderboardID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `totalAchievements` int(11) NOT NULL DEFAULT 0,
  `userRanking` int(11) DEFAULT NULL,
  `userBadges` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learningmaterials`
--

CREATE TABLE `learningmaterials` (
  `learningMaterialID` bigint(20) UNSIGNED NOT NULL,
  `lectID` bigint(20) UNSIGNED NOT NULL,
  `learningMaterialTitle` varchar(255) NOT NULL,
  `learningMaterialDesc` text NOT NULL,
  `learningMaterialType` varchar(255) NOT NULL,
  `storagePath` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecture`
--

CREATE TABLE `lecture` (
  `lectID` bigint(20) UNSIGNED NOT NULL,
  `moduleID` bigint(20) UNSIGNED NOT NULL,
  `lectName` varchar(255) NOT NULL,
  `lect_duration` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`lectID`, `moduleID`, `lectName`, `lect_duration`, `created_at`, `updated_at`) VALUES
(1, 1, 'What is a Dam and Its Purpose', '10', '2026-04-08 14:58:34', '2026-04-08 14:58:34'),
(2, 1, 'Importance of Geographic', '10', '2026-04-08 14:58:53', '2026-04-08 14:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `lectureprogress`
--

CREATE TABLE `lectureprogress` (
  `lectProgressID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `lectID` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lectureprogress`
--

INSERT INTO `lectureprogress` (`lectProgressID`, `userID`, `lectID`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-04-18 19:45:53', NULL, NULL),
(2, 1, 1, '2026-04-19 06:27:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lecture_sections`
--

CREATE TABLE `lecture_sections` (
  `sectionID` bigint(20) UNSIGNED NOT NULL,
  `lectID` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_type` varchar(255) NOT NULL,
  `section_content` text DEFAULT NULL,
  `section_file` varchar(255) DEFAULT NULL,
  `section_order` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecture_sections`
--

INSERT INTO `lecture_sections` (`sectionID`, `lectID`, `section_title`, `section_type`, `section_content`, `section_file`, `section_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lesson Overview', 'text', 'Understand what a dam is and why it is built.', NULL, 1, '2026-04-08 15:00:21', '2026-04-08 15:00:21'),
(2, 1, 'Introduction', 'text', 'A dam is a structure that is built across a river or stream to control the flow of water. It allows us to store water and use it when needed instead of letting it flow away naturally.\r\n\r\nThink of a dam like a barrier that creates a large artificial lake, called a reservoir, behind it.', NULL, 2, '2026-04-08 15:01:52', '2026-04-08 15:01:52'),
(3, 1, 'Why do We Build the Dam?', 'text', 'Dams are built for several important reasons:\r\n\r\nWater Storage\r\nDams store water that can be used for:\r\nDrinking water supply\r\nIrrigation for farming\r\n\r\nThis is especially important in areas that do not get regular rainfall\'\r\n\r\n2. Flood Control\r\nDuring heavy rains, rivers can overflow and cause floods. A dam helps control this by storing excess water and releasing it slowly, reducing damage to nearby areas.\r\n\r\n3. Hydroelectric Power Generation\r\nDams can be used to produce electricity. Water stored at a height flows down through turbines, spinning them and generating power. This is called hydropower, and it is a renewable source of energy.\r\n\r\n4. Recreation and Tourism\r\nMany dams create lakes that are used for:\r\n- Boating\r\n- Fishing\r\n- Tourism activities', NULL, 3, '2026-04-08 15:03:51', '2026-04-08 15:03:51'),
(4, 2, 'Introduction', 'text', 'When building a dam, choosing the right location is one of the most important decisions engineers must make. A good location ensures the dam is safe, efficient, and long-lasting, while a poor location can lead to failure or unnecessary costs.', NULL, 4, '2026-04-08 15:04:38', '2026-04-08 15:04:38'),
(6, 2, 'Testing', 'video', 'Testing video', 'lecture_sections/1xe33LhIHFs5gW65SZmKcWXsRuMkqUlNSpxXwTKi.mp4', 5, '2026-04-12 06:22:08', '2026-04-12 06:22:08'),
(7, 2, 'testing pdf', 'pdf', 'testing', 'lecture_sections/mHCeZ1M5IgVeYyJ8KLO2cD7hlYyQ66MxJ8hP0r5L.pdf', 6, '2026-04-18 15:51:52', '2026-04-18 15:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `lecture_section_translations`
--

CREATE TABLE `lecture_section_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sectionID` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mcqs`
--

CREATE TABLE `mcqs` (
  `moduleQs_ID` bigint(20) UNSIGNED NOT NULL,
  `moduleID` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source` enum('manual','ai') NOT NULL DEFAULT 'manual',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `moduleQs` text NOT NULL,
  `question` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer1` varchar(255) DEFAULT NULL,
  `answer2` varchar(255) DEFAULT NULL,
  `answer3` varchar(255) DEFAULT NULL,
  `answer4` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcqs`
--

INSERT INTO `mcqs` (`moduleQs_ID`, `moduleID`, `group_id`, `source`, `is_active`, `moduleQs`, `question`, `created_at`, `updated_at`, `answer1`, `answer2`, `answer3`, `answer4`, `correct_answer`) VALUES
(1, 1, 1, 'manual', 1, 'What is a dam?', 'What is the primary purpose of building a dam?', '2026-04-08 15:07:02', '2026-04-14 17:22:36', 'To control the flow of water in a river or stream', 'To increase rainfall', 'To dry up rivers', 'To remove fish from the water', 0),
(2, 1, 2, 'manual', 1, 'Which of the following is NOT a purpose of a dam?', 'What is the large artificial lake created behind a dam called?', '2026-04-08 15:07:02', '2026-04-14 17:22:36', 'Reservoir', 'Pond', 'Aquifer', 'Lagoon', 0),
(3, 1, 3, 'manual', 1, 'Why is choosing the right location important when building a dam?', 'Which of the following is NOT a reason dams are built?', '2026-04-08 15:07:02', '2026-04-14 17:22:36', 'Water storage for drinking and irrigation', 'Flood control by storing excess water', 'Generating hydroelectric power', 'Increasing natural rainfall', 3),
(4, 1, 4, 'manual', 1, 'How do dams help in flood control?', 'How do dams help in flood control?', '2026-04-14 17:22:36', '2026-04-14 17:22:36', 'By storing excess water during heavy rains and releasing it slowly', 'By increasing the river\'s flow speed', 'By diverting all water away from the river', 'By draining the river completely', 0),
(5, 1, 5, 'manual', 1, 'Why is choosing the right location important when building a dam?', 'Why is choosing the right location important when building a dam?', '2026-04-14 17:22:36', '2026-04-14 17:22:36', 'To ensure the dam is safe, efficient, and long-lasting', 'To make the dam look attractive', 'To attract tourists only', 'Because location does not matter', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_19_015617_modify_users_table', 1),
(5, '2026_03_19_020315_create_admin_table', 1),
(6, '2026_03_19_020413_create_course_table', 1),
(7, '2026_03_19_020627_create_announcements_table', 1),
(8, '2026_03_19_021231_create_community_stories_table', 1),
(9, '2026_03_19_021358_create_modules_table', 1),
(10, '2026_03_19_021511_create_lecture_table', 1),
(11, '2026_03_19_021625_create_mcqs_table', 1),
(12, '2026_03_19_021716_create_module_ans_table', 1),
(13, '2026_03_19_021811_create_course_feedback_table', 1),
(14, '2026_03_19_021907_create_leaderboard_table', 1),
(15, '2026_03_19_021936_create_reports_table', 1),
(16, '2026_03_19_022020_create_user_progress_table', 1),
(17, '2026_03_19_022108_create_enrolment_course_modules_table', 1),
(18, '2026_03_19_023012_create_learning_materials_table', 1),
(19, '2026_03_19_023142_create_pdf_learning_table', 1),
(20, '2026_03_19_023528_create_assessment_results_table', 1),
(21, '2026_03_19_023611_create_lecture_sections_table', 1),
(22, '2026_03_19_023732_create_video_learning_table', 1),
(23, '2026_03_23_131158_add_feedback_fields_to_coursefeedback_table', 1),
(24, '2026_03_23_131346_drop_course_rating_from_coursefeedback', 1),
(25, '2026_03_23_153346_create_lecture_progress_table', 1),
(26, '2026_03_25_050312_add_reviewed_to_coursefeedback', 1),
(27, '2026_03_25_143234_create_course_assessments_table', 1),
(28, '2026_03_25_143349_create_assessment_qs_table', 1),
(29, '2026_03_25_143556_create_assessment_mcq_options_table', 1),
(30, '2026_03_26_141807_create_course_ass_attempts_table', 1),
(31, '2026_03_26_141830_create_course_ass_answers_table', 1),
(32, '2026_03_27_015425_add_phone_number_and_reset_fields_to_users_table', 1),
(33, '2026_03_27_082418_add_status_to_announcements_table', 1),
(34, '2026_03_29_125520_add_remember_token_to_admin_table', 1),
(35, '2026_03_29_131135_add_remember_token_to_admin_table_fix', 1),
(36, '2026_03_30_114203_add_mcq_enabled_to_module_table', 1),
(37, '2026_03_30_123558_add_is_active_to_module_table', 1),
(38, '2026_03_31_062055_add_course_and_type_to_assessment_results', 1),
(39, '2026_04_12_100246_update_mcqs_table', 2),
(40, '2026_04_12_161107_add_attempts_to_assessment_results_table', 3),
(41, '2026_04_13_061322_create_admin_settings_table', 4),
(42, '2026_04_18_170042_add_versioning_fields_to_mcqs_table', 5),
(43, '2026_04_19_062440_create_lecture_section_translations_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `moduleID` bigint(20) UNSIGNED NOT NULL,
  `moduleName` varchar(255) NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mcq_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`moduleID`, `moduleName`, `courseID`, `created_at`, `updated_at`, `mcq_enabled`, `is_active`) VALUES
(1, 'Introduction to the Dam', 1, '2026-04-08 14:58:10', '2026-04-08 14:58:10', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `moduleans`
--

CREATE TABLE `moduleans` (
  `ansID` bigint(20) UNSIGNED NOT NULL,
  `moduleQs_ID` bigint(20) UNSIGNED NOT NULL,
  `ansID_text` text NOT NULL,
  `ansCorrect` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moduleans`
--

INSERT INTO `moduleans` (`ansID`, `moduleQs_ID`, `ansID_text`, `ansCorrect`, `created_at`, `updated_at`) VALUES
(1, 1, 'A natural river', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(2, 1, 'A structure built to control water flow', 1, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(3, 1, 'A type of bridge', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(4, 1, 'A water pump', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(5, 2, 'Water storage', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(6, 2, 'Flood control', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(7, 2, 'Generating electricity', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(8, 2, 'Increasing earthquakes', 1, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(9, 3, 'To make it look attractive', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(10, 3, 'To ensure safety, efficiency, and durability', 1, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(11, 3, 'To reduce water flow', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02'),
(12, 3, 'To increase pollution', 0, '2026-04-08 15:07:02', '2026-04-08 15:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdflearning`
--

CREATE TABLE `pdflearning` (
  `pdfLearningID` bigint(20) UNSIGNED NOT NULL,
  `pdfLearningName` varchar(255) NOT NULL,
  `pdfLearningPath` varchar(255) NOT NULL,
  `pdfLearningDesc` text DEFAULT NULL,
  `pdfLearningPages` int(11) NOT NULL,
  `pdfLearningSizes` varchar(255) NOT NULL,
  `learningMaterialID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportID` bigint(20) UNSIGNED NOT NULL,
  `generatedBy` varchar(255) NOT NULL,
  `reportType` varchar(255) NOT NULL,
  `reportFilePath1` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NKlbXsRGBzWxsoXTj2kpxOUKYfgcC1lpGb2huNRu', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVHZHNEhTQ3l5ZTRQTE15enlCbHJWMEpsYVNjd0RVU0lialVEOHNxciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3Vyc2UtbW9kdWxlLW1hbmFnZW1lbnQiO3M6NToicm91dGUiO3M6MTk6ImFkbWluLmNvdXJzZS5tb2R1bGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=', 1776638221);

-- --------------------------------------------------------

--
-- Table structure for table `userprogress`
--

CREATE TABLE `userprogress` (
  `progressID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `courseID` bigint(20) UNSIGNED NOT NULL,
  `progressName` varchar(255) NOT NULL,
  `progressStatus` varchar(255) NOT NULL,
  `completionProgress` int(11) NOT NULL,
  `lastAccessed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userprogress`
--

INSERT INTO `userprogress` (`progressID`, `userID`, `courseID`, `progressName`, `progressStatus`, `completionProgress`, `lastAccessed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SECTION_2', 'completed', 10, '2026-04-18 18:14:17', '2026-04-08 17:05:18', '2026-04-18 18:14:17'),
(2, 1, 1, 'SECTION_3', 'completed', 10, '2026-04-18 15:52:47', '2026-04-08 17:05:19', '2026-04-18 15:52:47'),
(3, 1, 1, 'SECTION_4', 'completed', 10, '2026-04-18 19:35:51', '2026-04-08 17:05:21', '2026-04-18 19:35:51'),
(4, 1, 1, 'MCQ1', 'completed', 20, '2026-04-19 05:58:25', '2026-04-08 17:05:35', '2026-04-19 05:58:25'),
(5, 1, 1, 'SECTION_1', 'completed', 10, '2026-04-19 06:27:57', '2026-04-09 04:08:59', '2026-04-19 06:27:57'),
(6, 1, 1, 'SECTION_6', 'completed', 10, '2026-04-18 19:35:55', '2026-04-12 06:22:31', '2026-04-18 19:35:55'),
(7, 1, 1, 'FINAL_ASSESSMENT', 'completed', 80, '2026-04-12 08:43:02', '2026-04-12 08:17:00', '2026-04-12 08:43:02'),
(8, 1, 1, 'SECTION_7', 'completed', 10, '2026-04-18 19:36:09', '2026-04-18 15:52:48', '2026-04-18 19:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` bigint(20) UNSIGNED NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `userPass` varchar(255) NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `authenticated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `phone`, `email_verified_at`, `userPass`, `must_change_password`, `remember_token`, `created_at`, `updated_at`, `authenticated`) VALUES
(1, 'Olivia Geema', 'geemaolivia@gmail.com', '0136197399', NULL, '$2y$12$eO.Rqfmt/lajJg5ALesXZe8keCyK0qeMjGoPCRPASkM1xYpfSmZWa', 0, 'faNRx1SgUc1VPx5XbUPa8aEoiMm3OqDtUw2recCdqDbJ3cptd9p69fzCMRpG', '2026-04-08 15:09:40', '2026-04-15 05:05:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `videolearning`
--

CREATE TABLE `videolearning` (
  `videoLearningID` bigint(20) UNSIGNED NOT NULL,
  `learningMaterialID` bigint(20) UNSIGNED NOT NULL,
  `videoLearningName` varchar(255) NOT NULL,
  `videoLearningPath` varchar(255) NOT NULL,
  `videoLearningDesc` text DEFAULT NULL,
  `videoLearningDuration` int(11) NOT NULL,
  `videoLearningResolution` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `admin_adminemail_unique` (`adminEmail`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementID`),
  ADD KEY `announcements_adminid_foreign` (`adminID`);

--
-- Indexes for table `assessment_mcq_options`
--
ALTER TABLE `assessment_mcq_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_mcq_options_assqsid_foreign` (`assQsID`);

--
-- Indexes for table `assessment_qs`
--
ALTER TABLE `assessment_qs`
  ADD PRIMARY KEY (`assQsID`),
  ADD KEY `assessment_qs_courseassid_foreign` (`courseAssID`);

--
-- Indexes for table `assessment_results`
--
ALTER TABLE `assessment_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_results_userid_foreign` (`userID`),
  ADD KEY `assessment_results_moduleid_foreign` (`moduleID`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `community_stories`
--
ALTER TABLE `community_stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_stories_adminid_foreign` (`adminID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`),
  ADD UNIQUE KEY `course_coursecode_unique` (`courseCode`);

--
-- Indexes for table `courseassanswers`
--
ALTER TABLE `courseassanswers`
  ADD PRIMARY KEY (`answersAssID`),
  ADD KEY `courseassanswers_attemptid_foreign` (`attemptID`),
  ADD KEY `courseassanswers_assqsid_foreign` (`assQsID`),
  ADD KEY `courseassanswers_selected_option_id_foreign` (`selected_option_id`);

--
-- Indexes for table `courseassattempts`
--
ALTER TABLE `courseassattempts`
  ADD PRIMARY KEY (`attemptID`),
  ADD KEY `courseassattempts_userid_foreign` (`userID`),
  ADD KEY `courseassattempts_courseassid_foreign` (`courseAssID`);

--
-- Indexes for table `coursefeedback`
--
ALTER TABLE `coursefeedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `coursefeedback_courseid_foreign` (`courseID`);

--
-- Indexes for table `course_assessments`
--
ALTER TABLE `course_assessments`
  ADD PRIMARY KEY (`courseAssID`),
  ADD KEY `course_assessments_courseid_foreign` (`courseID`);

--
-- Indexes for table `enrolmentcoursemodules`
--
ALTER TABLE `enrolmentcoursemodules`
  ADD PRIMARY KEY (`enrollID`),
  ADD KEY `enrolmentcoursemodules_userid_foreign` (`userID`),
  ADD KEY `enrolmentcoursemodules_courseid_foreign` (`courseID`),
  ADD KEY `enrolmentcoursemodules_moduleid_foreign` (`moduleID`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`leaderboardID`),
  ADD KEY `leaderboard_userid_foreign` (`userID`);

--
-- Indexes for table `learningmaterials`
--
ALTER TABLE `learningmaterials`
  ADD PRIMARY KEY (`learningMaterialID`),
  ADD KEY `learningmaterials_lectid_foreign` (`lectID`);

--
-- Indexes for table `lecture`
--
ALTER TABLE `lecture`
  ADD PRIMARY KEY (`lectID`),
  ADD KEY `lecture_moduleid_foreign` (`moduleID`);

--
-- Indexes for table `lectureprogress`
--
ALTER TABLE `lectureprogress`
  ADD PRIMARY KEY (`lectProgressID`),
  ADD UNIQUE KEY `lectureprogress_userid_lectid_unique` (`userID`,`lectID`);

--
-- Indexes for table `lecture_sections`
--
ALTER TABLE `lecture_sections`
  ADD PRIMARY KEY (`sectionID`),
  ADD KEY `lecture_sections_lectid_foreign` (`lectID`);

--
-- Indexes for table `lecture_section_translations`
--
ALTER TABLE `lecture_section_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lecture_section_translations_sectionid_locale_unique` (`sectionID`,`locale`);

--
-- Indexes for table `mcqs`
--
ALTER TABLE `mcqs`
  ADD PRIMARY KEY (`moduleQs_ID`),
  ADD KEY `mcqs_moduleid_foreign` (`moduleID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`moduleID`),
  ADD KEY `module_courseid_foreign` (`courseID`);

--
-- Indexes for table `moduleans`
--
ALTER TABLE `moduleans`
  ADD PRIMARY KEY (`ansID`),
  ADD KEY `moduleans_moduleqs_id_foreign` (`moduleQs_ID`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pdflearning`
--
ALTER TABLE `pdflearning`
  ADD PRIMARY KEY (`pdfLearningID`),
  ADD KEY `pdflearning_learningmaterialid_foreign` (`learningMaterialID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `userprogress`
--
ALTER TABLE `userprogress`
  ADD PRIMARY KEY (`progressID`),
  ADD KEY `userprogress_userid_foreign` (`userID`),
  ADD KEY `userprogress_courseid_foreign` (`courseID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `users_email_unique` (`userEmail`);

--
-- Indexes for table `videolearning`
--
ALTER TABLE `videolearning`
  ADD PRIMARY KEY (`videoLearningID`),
  ADD KEY `videolearning_learningmaterialid_foreign` (`learningMaterialID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcementID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_mcq_options`
--
ALTER TABLE `assessment_mcq_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assessment_qs`
--
ALTER TABLE `assessment_qs`
  MODIFY `assQsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assessment_results`
--
ALTER TABLE `assessment_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `community_stories`
--
ALTER TABLE `community_stories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courseassanswers`
--
ALTER TABLE `courseassanswers`
  MODIFY `answersAssID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courseassattempts`
--
ALTER TABLE `courseassattempts`
  MODIFY `attemptID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coursefeedback`
--
ALTER TABLE `coursefeedback`
  MODIFY `feedbackID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_assessments`
--
ALTER TABLE `course_assessments`
  MODIFY `courseAssID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrolmentcoursemodules`
--
ALTER TABLE `enrolmentcoursemodules`
  MODIFY `enrollID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `leaderboardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learningmaterials`
--
ALTER TABLE `learningmaterials`
  MODIFY `learningMaterialID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecture`
--
ALTER TABLE `lecture`
  MODIFY `lectID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lectureprogress`
--
ALTER TABLE `lectureprogress`
  MODIFY `lectProgressID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lecture_sections`
--
ALTER TABLE `lecture_sections`
  MODIFY `sectionID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lecture_section_translations`
--
ALTER TABLE `lecture_section_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mcqs`
--
ALTER TABLE `mcqs`
  MODIFY `moduleQs_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `moduleID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `moduleans`
--
ALTER TABLE `moduleans`
  MODIFY `ansID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pdflearning`
--
ALTER TABLE `pdflearning`
  MODIFY `pdfLearningID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userprogress`
--
ALTER TABLE `userprogress`
  MODIFY `progressID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videolearning`
--
ALTER TABLE `videolearning`
  MODIFY `videoLearningID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_adminid_foreign` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_mcq_options`
--
ALTER TABLE `assessment_mcq_options`
  ADD CONSTRAINT `assessment_mcq_options_assqsid_foreign` FOREIGN KEY (`assQsID`) REFERENCES `assessment_qs` (`assQsID`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_qs`
--
ALTER TABLE `assessment_qs`
  ADD CONSTRAINT `assessment_qs_courseassid_foreign` FOREIGN KEY (`courseAssID`) REFERENCES `course_assessments` (`courseAssID`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_results`
--
ALTER TABLE `assessment_results`
  ADD CONSTRAINT `assessment_results_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_results_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `community_stories`
--
ALTER TABLE `community_stories`
  ADD CONSTRAINT `community_stories_adminid_foreign` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`) ON DELETE CASCADE;

--
-- Constraints for table `courseassanswers`
--
ALTER TABLE `courseassanswers`
  ADD CONSTRAINT `courseassanswers_assqsid_foreign` FOREIGN KEY (`assQsID`) REFERENCES `assessment_qs` (`assQsID`) ON DELETE CASCADE,
  ADD CONSTRAINT `courseassanswers_attemptid_foreign` FOREIGN KEY (`attemptID`) REFERENCES `courseassattempts` (`attemptID`) ON DELETE CASCADE,
  ADD CONSTRAINT `courseassanswers_selected_option_id_foreign` FOREIGN KEY (`selected_option_id`) REFERENCES `assessment_mcq_options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courseassattempts`
--
ALTER TABLE `courseassattempts`
  ADD CONSTRAINT `courseassattempts_courseassid_foreign` FOREIGN KEY (`courseAssID`) REFERENCES `course_assessments` (`courseAssID`) ON DELETE CASCADE,
  ADD CONSTRAINT `courseassattempts_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `coursefeedback`
--
ALTER TABLE `coursefeedback`
  ADD CONSTRAINT `coursefeedback_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE;

--
-- Constraints for table `course_assessments`
--
ALTER TABLE `course_assessments`
  ADD CONSTRAINT `course_assessments_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE;

--
-- Constraints for table `enrolmentcoursemodules`
--
ALTER TABLE `enrolmentcoursemodules`
  ADD CONSTRAINT `enrolmentcoursemodules_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  ADD CONSTRAINT `enrolmentcoursemodules_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`),
  ADD CONSTRAINT `enrolmentcoursemodules_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `learningmaterials`
--
ALTER TABLE `learningmaterials`
  ADD CONSTRAINT `learningmaterials_lectid_foreign` FOREIGN KEY (`lectID`) REFERENCES `lecture` (`lectID`) ON DELETE CASCADE;

--
-- Constraints for table `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE;

--
-- Constraints for table `lecture_sections`
--
ALTER TABLE `lecture_sections`
  ADD CONSTRAINT `lecture_sections_lectid_foreign` FOREIGN KEY (`lectID`) REFERENCES `lecture` (`lectID`) ON DELETE CASCADE;

--
-- Constraints for table `lecture_section_translations`
--
ALTER TABLE `lecture_section_translations`
  ADD CONSTRAINT `lecture_section_translations_sectionid_foreign` FOREIGN KEY (`sectionID`) REFERENCES `lecture_sections` (`sectionID`) ON DELETE CASCADE;

--
-- Constraints for table `mcqs`
--
ALTER TABLE `mcqs`
  ADD CONSTRAINT `mcqs_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE;

--
-- Constraints for table `moduleans`
--
ALTER TABLE `moduleans`
  ADD CONSTRAINT `moduleans_moduleqs_id_foreign` FOREIGN KEY (`moduleQs_ID`) REFERENCES `mcqs` (`moduleQs_ID`) ON DELETE CASCADE;

--
-- Constraints for table `pdflearning`
--
ALTER TABLE `pdflearning`
  ADD CONSTRAINT `pdflearning_learningmaterialid_foreign` FOREIGN KEY (`learningMaterialID`) REFERENCES `learningmaterials` (`learningMaterialID`);

--
-- Constraints for table `userprogress`
--
ALTER TABLE `userprogress`
  ADD CONSTRAINT `userprogress_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  ADD CONSTRAINT `userprogress_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `videolearning`
--
ALTER TABLE `videolearning`
  ADD CONSTRAINT `videolearning_learningmaterialid_foreign` FOREIGN KEY (`learningMaterialID`) REFERENCES `learningmaterials` (`learningMaterialID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
