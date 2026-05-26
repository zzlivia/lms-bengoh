-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: shinkansen.proxy.rlwy.net    Database: railway
-- ------------------------------------------------------
-- Server version	9.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `adminID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `adminName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminPass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminRole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`adminID`),
  UNIQUE KEY `admin_adminemail_unique` (`adminEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Administrator','admin@testing.com','$2y$12$h9FnZcqC.rMB8XlaySMdFOQ80C0sxa4fG.HoIfTc/JmL.fm9bHaaS','admin','2026-04-23 00:48:42','2026-04-23 00:48:42',NULL),(2,'AIN ALISYANIE BINTI ALI','ainalisyanie@gmail.com','$2y$12$cRifFb7sKPCcxfasr/Yc8.HqCK/uuXkBpit4MQibrwM6OAKcXg2Vq','admin','2026-04-28 06:00:49','2026-04-28 06:00:49','UC1bGXNAr0xPtb5EEdUunGk41LRKEQjWGPe8IlfOibjArtqwtu60rcBSoZZP'),(3,'Jay','jyuroyjoken@gmail.com','$2y$12$bmLTBOgF/egFSoM2OXgbdeTLrfgHo0EH598iiY9oxZKXTU5I7yZSG','admin','2026-04-28 07:10:19','2026-04-28 07:10:19',NULL),(4,'Taufeq Hidayat','taufeqhidayat27@gmail.com','$2y$12$bYp/W9ZCMpbHxzd27q9vKe8Gan9uwFCttryS9irv2TpJDdQZx0O9C','admin','2026-04-29 02:06:22','2026-04-29 02:06:22',NULL),(5,'Nurul Fatihah','nrlfthh019@gmail.com','$2y$12$eohijSKsFIou4bF6/J3kluyrXv7nUJirIf1jBYk0JCyqUBHKZWNdq','admin','2026-05-04 05:57:41','2026-05-04 05:57:41',NULL),(6,'Aniqa Unaisa','aniqaunaisa@gmail.com','$2y$12$T21bTrNkMEp3GUiywKfZ8eYJjQmkLvHlB1.3BaKiyCaDS3YLrzA0K','admin','2026-05-09 17:38:14','2026-05-09 17:38:14',NULL),(7,'Syazayani','syazayani.jeffry03@gmail.com','$2y$12$J.pLI61VKfOR5gKf/opmNe9qz0hy4polSD.L4cuIgJfbyXJG4.O3C','admin','2026-05-11 12:13:40','2026-05-11 12:13:40',NULL),(8,'Olivia Geema','geemaolivia2@gmail.com','$2y$12$6KIRmn2FHGSomTB3Ds83sOjBDOgq4glNEbINGos1BTPchmvxnrv7e','admin','2026-05-13 15:15:44','2026-05-13 15:15:44',NULL),(9,'Syafiq','syafiq@gmail.com','$2y$12$Zk8T66H/.m0DeEf4etUjSe18lXh1R9iNmoZ3H3x.OiKzHRcKCCER6','admin','2026-05-15 15:18:30','2026-05-15 15:18:30',NULL),(10,'mia','mia@gmail.com','$2y$12$Ya6hqUGS5wtwXN5BVlaIauGRt3SCkPp1y1ohM5NMuyaI/.cowNLI.','admin','2026-05-15 15:22:05','2026-05-15 15:22:05',NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `default_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT '0',
  `font_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `export_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_file_size` int DEFAULT NULL,
  `video_resolution_limit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_settings`
--

LOCK TABLES `admin_settings` WRITE;
/*!40000 ALTER TABLE `admin_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `announcementID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `announcementTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `announcementDetails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`announcementID`),
  KEY `announcements_adminid_foreign` (`adminID`),
  CONSTRAINT `announcements_adminid_foreign` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'MCQs for General Hiking Safety','The multiple-choice questions are out now',1,'2026-04-24 09:19:23','2026-05-26 02:02:55','Available');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assessment_mcq_options`
--

DROP TABLE IF EXISTS `assessment_mcq_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assessment_mcq_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assQsID` bigint unsigned NOT NULL,
  `optionText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assessment_mcq_options_assqsid_foreign` (`assQsID`),
  CONSTRAINT `assessment_mcq_options_assqsid_foreign` FOREIGN KEY (`assQsID`) REFERENCES `assessment_qs` (`assQsID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_mcq_options`
--

LOCK TABLES `assessment_mcq_options` WRITE;
/*!40000 ALTER TABLE `assessment_mcq_options` DISABLE KEYS */;
INSERT INTO `assessment_mcq_options` VALUES (1,1,'Social Media',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(2,1,'Weather conditions',1,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(3,1,'Music Playlist',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(4,1,'Camera Battery',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(5,2,'Drink water regularly',1,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(6,2,'Avoid drinking water',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(7,2,'Drink only at the end',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(8,2,'Skip meals',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(9,3,'Walk alone ahead',1,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(10,3,'Stay with the group',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(11,3,'Ignore others',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(12,3,'Take shortcuts',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(13,4,'Jump quickly',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(14,4,'Check water depth and current',1,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(15,4,'Run across',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(16,4,'Ignore conditions',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(17,5,'Continue hiking',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(18,5,'Ignore it',0,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(19,5,'Turn back or seek shelter',1,'2026-04-23 15:45:11','2026-04-23 15:45:11'),(20,5,'Run faster',0,'2026-04-23 15:45:11','2026-04-23 15:45:11');
/*!40000 ALTER TABLE `assessment_mcq_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assessment_qs`
--

DROP TABLE IF EXISTS `assessment_qs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assessment_qs` (
  `assQsID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `courseAssID` bigint unsigned NOT NULL,
  `courseAssQs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseAssType` enum('MCQ','SHORT_ANSWER','LONG_ANSWER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`assQsID`),
  KEY `assessment_qs_courseassid_foreign` (`courseAssID`),
  CONSTRAINT `assessment_qs_courseassid_foreign` FOREIGN KEY (`courseAssID`) REFERENCES `course_assessments` (`courseAssID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_qs`
--

LOCK TABLES `assessment_qs` WRITE;
/*!40000 ALTER TABLE `assessment_qs` DISABLE KEYS */;
INSERT INTO `assessment_qs` VALUES (1,1,'What should you check before starting a hike?','MCQ','2026-04-23 15:45:11','2026-04-23 15:45:11'),(2,1,'What is the best way to prevent dehydration?','MCQ','2026-04-23 15:45:11','2026-04-23 15:45:11'),(3,1,'What should you do when hiking in a group?','MCQ','2026-04-23 15:45:11','2026-04-23 15:45:11'),(4,1,'What is a safe practice before crossing a river?','MCQ','2026-04-23 15:45:11','2026-04-23 15:45:11'),(5,1,'What should you do if the weather suddenly worsens?','MCQ','2026-04-23 15:45:11','2026-04-23 15:45:11');
/*!40000 ALTER TABLE `assessment_qs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assessment_results`
--

DROP TABLE IF EXISTS `assessment_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assessment_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `moduleID` bigint unsigned NOT NULL,
  `courseID` bigint unsigned NOT NULL,
  `score` int NOT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assessment_results_userid_foreign` (`userID`),
  KEY `assessment_results_moduleid_foreign` (`moduleID`),
  CONSTRAINT `assessment_results_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE,
  CONSTRAINT `assessment_results_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_results`
--

LOCK TABLES `assessment_results` WRITE;
/*!40000 ALTER TABLE `assessment_results` DISABLE KEYS */;
INSERT INTO `assessment_results` VALUES (1,1,1,1,0,3,'mcq','fail','2026-04-23 10:06:23','2026-04-23 10:06:23'),(2,1,1,1,40,0,'final','fail','2026-05-17 15:28:03','2026-05-17 15:28:03'),(3,4,1,1,100,3,'mcq','pass','2026-05-02 07:09:40','2026-05-02 07:09:40'),(4,4,1,1,80,0,'final','pass','2026-05-02 09:09:29','2026-05-02 09:09:29'),(5,3,1,1,60,3,'mcq','fail',NULL,'2026-04-27 03:14:38'),(6,1,2,1,33,3,'mcq','fail','2026-05-16 01:23:03','2026-05-16 01:23:03'),(7,1,3,1,50,3,'mcq','fail','2026-04-27 16:48:26','2026-04-27 16:48:26'),(8,8,2,1,33,3,'mcq','fail','2026-04-28 07:21:44','2026-04-28 07:21:44'),(9,8,1,1,80,1,'mcq','pass','2026-04-28 07:20:38','2026-04-28 07:20:38'),(10,8,3,1,50,3,'mcq','fail','2026-04-28 07:23:40','2026-04-28 07:23:40'),(11,8,1,1,80,0,'final','pass','2026-04-28 07:25:42','2026-04-28 07:25:42'),(12,9,11,2,0,1,'mcq','fail','2026-04-30 07:57:39','2026-04-30 07:57:39'),(13,10,10,2,80,2,'mcq','pass','2026-04-30 11:00:02','2026-04-30 11:00:02'),(14,11,10,2,0,1,'mcq','fail','2026-04-30 10:59:55','2026-04-30 10:59:55'),(15,11,11,2,0,1,'mcq','fail','2026-04-30 11:01:08','2026-04-30 11:01:08'),(16,10,11,2,0,1,'mcq','fail','2026-04-30 11:02:26','2026-04-30 11:02:26'),(17,15,10,2,0,1,'mcq','fail','2026-05-01 11:33:52','2026-05-01 11:33:52'),(18,15,11,2,0,1,'mcq','fail','2026-05-01 11:37:57','2026-05-01 11:37:57'),(19,17,1,1,80,1,'mcq','pass','2026-05-01 11:51:13','2026-05-01 11:51:13'),(20,17,2,1,0,1,'mcq','fail','2026-05-01 11:51:49','2026-05-01 11:51:49'),(21,17,3,1,0,1,'mcq','fail','2026-05-01 11:52:30','2026-05-01 11:52:30'),(22,18,10,2,60,3,'mcq','fail','2026-05-01 12:05:06','2026-05-01 12:05:06'),(23,18,11,2,0,1,'mcq','fail','2026-05-01 12:06:30','2026-05-01 12:06:30'),(24,4,10,2,20,2,'mcq','fail','2026-05-21 02:08:23','2026-05-21 02:08:23'),(25,4,2,1,33,2,'mcq','fail','2026-05-26 01:23:58','2026-05-26 01:23:58'),(26,4,3,1,50,3,'mcq','fail','2026-05-26 01:57:57','2026-05-26 01:57:57'),(27,3,2,1,0,1,'mcq','fail','2026-05-04 06:53:43','2026-05-04 06:53:43'),(28,3,3,1,0,1,'mcq','fail','2026-05-04 06:54:28','2026-05-04 06:54:28'),(29,27,10,2,20,1,'mcq','fail','2026-05-07 03:48:47','2026-05-07 03:48:47'),(30,28,1,1,0,3,'mcq','fail','2026-05-17 14:31:51','2026-05-17 14:31:51'),(31,28,10,2,0,3,'mcq','fail','2026-05-16 10:54:37','2026-05-16 10:54:37'),(32,28,11,2,0,2,'mcq','fail','2026-05-17 15:01:05','2026-05-17 15:01:05'),(33,29,1,1,0,1,'mcq','fail','2026-05-11 04:19:16','2026-05-11 04:19:16'),(34,29,2,1,0,1,'mcq','fail','2026-05-11 04:20:08','2026-05-11 04:20:08'),(35,29,3,1,0,1,'mcq','fail','2026-05-11 04:20:34','2026-05-11 04:20:34'),(36,1,10,2,20,1,'mcq','fail','2026-05-16 02:05:13','2026-05-16 02:05:13'),(37,30,1,1,100,1,'mcq','pass','2026-05-17 14:58:50','2026-05-17 14:58:50'),(38,30,2,1,0,1,'mcq','fail','2026-05-17 14:59:12','2026-05-17 14:59:12'),(39,30,3,1,0,1,'mcq','fail','2026-05-17 14:59:45','2026-05-17 14:59:45'),(40,28,2,1,0,2,'mcq','fail','2026-05-17 15:16:41','2026-05-17 15:16:41'),(41,28,3,1,0,2,'mcq','fail','2026-05-17 15:17:25','2026-05-17 15:17:25'),(42,28,1,1,80,0,'final','pass','2026-05-17 16:30:26','2026-05-17 16:30:26');
/*!40000 ALTER TABLE `assessment_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_stories`
--

DROP TABLE IF EXISTS `community_stories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_stories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `community_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `community_story` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `community_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `adminID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_stories_adminid_foreign` (`adminID`),
  CONSTRAINT `community_stories_adminid_foreign` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_stories`
--

LOCK TABLES `community_stories` WRITE;
/*!40000 ALTER TABLE `community_stories` DISABLE KEYS */;
INSERT INTO `community_stories` VALUES (1,'Encik Ugah','Life After The Dam','For generations, Encik Ugah and his ancestors lived high in the clouds of the Bengoh Range, where the only sound was the rush of the waterfalls and the chirping of cicadas. When the Bengoh Dam was completed, the valleys he once walked turned into a vast, emerald-green lake.\r\n\r\n\"At first, it was quiet like too quiet,\" Ugah recalls while prepping his longboat at the jetty. \"We lost the paths we knew by heart, but we gained a horizon we never thought possible.\"\r\n\r\nToday, Ugah is no longer just a pepper farmer; he is a gateway to the \"Jurassic Park of Sarawak.\" As a community guide, he navigates his boat through the mist every morning, taking hikers and researchers to the majestic Susung Waterfall.\r\n\r\nLife after the dam has brought challenges, especially in preserving the old Bidayuh traditions in a modern resettlement home. However, the surge in eco-tourism has given the youth a reason to stay. Instead of moving to Kuching for factory work, young men are learning to be boatmen, and the women are revitalizing traditional beadwork to sell to visitors.','community_stories/ugah community.png',1,1,'2026-04-27 14:21:40','2026-04-29 07:20:26');
/*!40000 ALTER TABLE `community_stories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `courseID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `courseCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseAuthor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseDesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseCategory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseLevel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseDuration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT '1',
  `courseImg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  UNIQUE KEY `course_coursecode_unique` (`courseCode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'SF001','General Hiking Safety','Shym Travers','Stay Prepared • Stay Safe • Explore Smart','Safety','Beginner','2',1,'courses-assets/v0BSiuJVYmEjXqoup3XvERDzS2EHNdwvUfxv3MbU.png','2026-04-23 05:12:14','2026-04-23 05:50:08'),(2,'EX001','The Waterfall Circuit','Shym Travers','This course explores the unique waterfall systems within the Bengoh area, with a focus on understanding the curtain effect, a phenomenon where water flows smoothly over rock surfaces, creating a continuous sheet-like cascade. Learners will examine the physical processes behind waterfall formation, including hydrology, erosion, and geological structures.\r\n\r\nThrough guided lessons, the course also highlights the environmental significance of waterfalls, their role in shaping local ecosystems, and their importance in eco-tourism. By the end of the course, learners will gain a deeper appreciation of natural water systems and develop awareness of responsible interaction with waterfall environments.','Exploration','Beginner','2',1,'courses-assets/yZogjd9SROV99JjDBBZgEINcaVlLPfpUJryZmnQJ.png','2026-04-27 01:06:14','2026-04-27 01:06:14'),(6,'BO001','Biodiversity of the Bengoh Range','Public','This course introduces learners to the rich biodiversity of the Bengoh Range, focusing on the identification of flora and the awareness of wildlife in highland rainforest ecosystems. It covers key plant species such as ferns, orchids, and pitcher plants, as well as notable wildlife including birds, insects, and small forest animals.\r\n\r\nLearners will develop practical skills in observing and identifying species using visual characteristics and field techniques. The course also emphasizes ecological relationships, conservation challenges, and the importance of preserving biodiversity. It is designed to build both knowledge and environmental responsibility in exploring natural habitats.','Biodiversity','Intermediate','3',1,'courses-assets/uCwLva4Jki3pNFMpn83ITdHe84YZDRagmVmSItK2.png','2026-04-27 07:53:12','2026-04-27 07:53:12'),(7,'S001','Bengoh Engineering & Water Security','Public','This course provides an overview of engineering principles behind the Bengoh Dam and its critical role in water security. It examines why Bengoh was selected as a dam site, considering geographic, environmental, and strategic factors. Learners will explore the fundamentals of dam construction, including structure, materials, and safety considerations.\r\n\r\nThe course also highlights the dam’s functions in flood mitigation and water storage, explaining how it regulates water flow and supplies treated water to nearby regions such as Kuching. By the end of the course, learners will understand how engineering solutions support sustainable water management and community needs.','History','Advanced','2',1,'courses-assets/VgjRqBa35cXkV30PbLui7xDSruMfiLUle2iYN1vi.png','2026-04-27 07:54:08','2026-04-27 07:54:08');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courseAssAnswers`
--

DROP TABLE IF EXISTS `courseAssAnswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courseAssAnswers` (
  `answersAssID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attemptID` bigint unsigned NOT NULL,
  `assQsID` bigint unsigned NOT NULL,
  `selected_option_id` bigint unsigned DEFAULT NULL,
  `answer_text` text COLLATE utf8mb4_unicode_ci,
  `is_correct` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`answersAssID`),
  KEY `courseassanswers_attemptid_foreign` (`attemptID`),
  KEY `courseassanswers_assqsid_foreign` (`assQsID`),
  KEY `courseassanswers_selected_option_id_foreign` (`selected_option_id`),
  CONSTRAINT `courseassanswers_assqsid_foreign` FOREIGN KEY (`assQsID`) REFERENCES `assessment_qs` (`assQsID`) ON DELETE CASCADE,
  CONSTRAINT `courseassanswers_attemptid_foreign` FOREIGN KEY (`attemptID`) REFERENCES `courseAssAttempts` (`attemptID`) ON DELETE CASCADE,
  CONSTRAINT `courseassanswers_selected_option_id_foreign` FOREIGN KEY (`selected_option_id`) REFERENCES `assessment_mcq_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courseAssAnswers`
--

LOCK TABLES `courseAssAnswers` WRITE;
/*!40000 ALTER TABLE `courseAssAnswers` DISABLE KEYS */;
/*!40000 ALTER TABLE `courseAssAnswers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courseAssAttempts`
--

DROP TABLE IF EXISTS `courseAssAttempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courseAssAttempts` (
  `attemptID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `courseAssID` bigint unsigned NOT NULL,
  `score` int DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attemptID`),
  KEY `courseassattempts_userid_foreign` (`userID`),
  KEY `courseassattempts_courseassid_foreign` (`courseAssID`),
  CONSTRAINT `courseassattempts_courseassid_foreign` FOREIGN KEY (`courseAssID`) REFERENCES `course_assessments` (`courseAssID`) ON DELETE CASCADE,
  CONSTRAINT `courseassattempts_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courseAssAttempts`
--

LOCK TABLES `courseAssAttempts` WRITE;
/*!40000 ALTER TABLE `courseAssAttempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `courseAssAttempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_assessments`
--

DROP TABLE IF EXISTS `course_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_assessments` (
  `courseAssID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `courseID` bigint unsigned NOT NULL,
  `courseAssTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseAssDesc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`courseAssID`),
  KEY `course_assessments_courseid_foreign` (`courseID`),
  CONSTRAINT `course_assessments_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_assessments`
--

LOCK TABLES `course_assessments` WRITE;
/*!40000 ALTER TABLE `course_assessments` DISABLE KEYS */;
INSERT INTO `course_assessments` VALUES (1,1,'Final Assessment General Hiking Safety',NULL,'2026-04-23 15:42:11','2026-04-23 15:42:11');
/*!40000 ALTER TABLE `course_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coursefeedback`
--

DROP TABLE IF EXISTS `coursefeedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coursefeedback` (
  `feedbackID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `courseID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `clarity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `understanding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favorite_module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enjoyed` text COLLATE utf8mb4_unicode_ci,
  `suggestions` text COLLATE utf8mb4_unicode_ci,
  `userID` bigint unsigned DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `is_reviewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedbackID`),
  KEY `coursefeedback_courseid_foreign` (`courseID`),
  CONSTRAINT `coursefeedback_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coursefeedback`
--

LOCK TABLES `coursefeedback` WRITE;
/*!40000 ALTER TABLE `coursefeedback` DISABLE KEYS */;
INSERT INTO `coursefeedback` VALUES (1,1,'2026-04-23 15:18:56','2026-04-29 02:26:33','Good','Somewhat','3',NULL,NULL,1,5,1),(2,1,'2026-04-23 15:27:06','2026-04-29 02:26:33','Good','Somewhat','2',NULL,NULL,1,5,1),(3,1,'2026-04-23 15:34:58','2026-04-29 02:26:33','Excellent','Somewhat','2','Short lecture','none',1,4,1),(4,1,'2026-04-23 16:45:39','2026-04-29 02:26:33','Excellent','Yes','2','Short lecture','-',4,5,1),(5,2,'2026-04-30 11:02:12','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(6,2,'2026-04-30 11:02:12','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(7,2,'2026-04-30 11:02:12','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(8,2,'2026-04-30 11:02:12','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(9,2,'2026-04-30 11:02:13','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(10,2,'2026-04-30 11:02:13','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(11,2,'2026-04-30 11:02:13','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(12,2,'2026-04-30 11:02:14','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(13,2,'2026-04-30 11:02:14','2026-05-02 15:21:00','Excellent','Yes','10','fun','ok',11,5,1),(14,1,'2026-04-30 11:04:32','2026-05-02 15:21:00','Excellent','Yes',NULL,'The course itself',NULL,4,5,1),(15,2,'2026-04-30 11:05:45','2026-05-02 15:21:00','Good','Yes','10','I enjoyed this course the most because it helped me learn new knowledge in an easy and understandable way','It would be helpful to include more imagessuch as infographics to make the content more engaging and easier to understand.',10,4,1),(16,2,'2026-04-30 11:06:34','2026-05-02 15:21:00','Good','Yes','10','I enjoyed this course the most because it helped me learn new knowledge in an easy and understandable way.','It would be helpful to include more images, such as maps or infographics, to make the content more engaging and easier to understand.',10,4,1),(17,2,'2026-04-30 11:07:24','2026-05-02 15:21:00','Good','Yes','10','I enjoyed this course the most because it helped me learn new knowledge in an easy and understandable way.','It would be helpful to include more images, such as infographics, to make the content more engaging and easier to understand.',10,4,1),(18,2,'2026-05-01 11:41:15','2026-05-02 15:21:00','Average','Yes','10','Learn new knowledge regarding waterfalls at bengoh dam.','Provide question that has the same answer as in module.',15,3,1),(19,1,'2026-05-04 13:05:45','2026-05-04 13:08:00','Good','Yes','1',NULL,NULL,3,5,1),(20,7,'2026-05-09 17:33:58','2026-05-09 17:33:58','Excellent','Yes',NULL,'-','-',28,5,0),(21,2,'2026-05-09 18:05:10','2026-05-09 18:05:10','Excellent','Not really','10','-','-',28,5,0),(22,2,'2026-05-09 18:06:23','2026-05-09 18:06:23','Excellent','Yes','11','-','-',28,5,0),(23,1,'2026-05-11 04:21:06','2026-05-11 04:21:06','Excellent','Yes',NULL,NULL,NULL,29,5,0),(24,2,'2026-05-17 15:01:32','2026-05-17 15:01:32','Excellent','Yes','10','-','-',28,5,0),(25,1,'2026-05-17 15:09:07','2026-05-17 15:09:07','Good','Yes','2','-','-',28,5,0),(26,1,'2026-05-17 15:29:24','2026-05-17 15:29:24','Excellent','Yes','2','i able to learn more about hiking safety','nothing so far so good',28,5,0);
/*!40000 ALTER TABLE `coursefeedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrolmentcoursemodules`
--

DROP TABLE IF EXISTS `enrolmentcoursemodules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrolmentcoursemodules` (
  `enrollID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `courseID` bigint unsigned NOT NULL,
  `moduleID` bigint unsigned NOT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `inProgress` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`enrollID`),
  KEY `enrolmentcoursemodules_userid_foreign` (`userID`),
  KEY `enrolmentcoursemodules_moduleid_foreign` (`moduleID`),
  KEY `enrolmentcoursemodules_courseid_foreign` (`courseID`),
  CONSTRAINT `enrolmentcoursemodules_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE,
  CONSTRAINT `enrolmentcoursemodules_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`),
  CONSTRAINT `enrolmentcoursemodules_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrolmentcoursemodules`
--

LOCK TABLES `enrolmentcoursemodules` WRITE;
/*!40000 ALTER TABLE `enrolmentcoursemodules` DISABLE KEYS */;
INSERT INTO `enrolmentcoursemodules` VALUES (3,1,1,1,1,0,'2026-04-23 05:32:46','2026-04-23 05:32:46'),(4,1,1,2,1,0,'2026-04-23 05:32:46','2026-04-23 05:32:46'),(5,1,1,3,1,0,'2026-04-23 05:32:46','2026-04-23 05:32:46'),(6,3,1,1,1,0,'2026-04-23 12:21:58','2026-04-23 12:21:58'),(7,3,1,2,1,0,'2026-04-23 12:21:58','2026-04-23 12:21:58'),(8,3,1,3,1,0,'2026-04-23 12:21:58','2026-04-23 12:21:58'),(9,4,1,1,1,0,'2026-04-23 16:33:03','2026-04-23 16:33:03'),(10,4,1,2,1,0,'2026-04-23 16:33:03','2026-04-23 16:33:03'),(11,4,1,3,1,0,'2026-04-23 16:33:03','2026-04-23 16:33:03'),(17,3,2,10,0,1,'2026-04-27 03:15:54','2026-04-27 03:15:54'),(18,3,2,11,0,1,'2026-04-27 03:15:54','2026-04-27 03:15:54'),(19,8,2,10,0,1,'2026-04-28 07:12:25','2026-04-28 07:12:25'),(20,8,2,11,0,1,'2026-04-28 07:12:25','2026-04-28 07:12:25'),(21,8,1,1,1,0,'2026-04-28 07:14:30','2026-04-28 07:14:30'),(22,8,1,2,1,0,'2026-04-28 07:14:30','2026-04-28 07:14:30'),(23,8,1,3,1,0,'2026-04-28 07:14:30','2026-04-28 07:14:30'),(24,9,2,10,1,0,'2026-04-30 07:54:30','2026-04-30 07:54:30'),(25,9,2,11,1,0,'2026-04-30 07:54:30','2026-04-30 07:54:30'),(26,10,2,10,1,0,'2026-04-30 10:53:07','2026-04-30 10:53:07'),(27,10,2,11,1,0,'2026-04-30 10:53:07','2026-04-30 10:53:07'),(28,11,2,10,1,0,'2026-04-30 10:58:32','2026-04-30 10:58:32'),(29,11,2,11,1,0,'2026-04-30 10:58:32','2026-04-30 10:58:32'),(30,4,2,10,1,0,'2026-04-30 21:41:17','2026-04-30 21:41:17'),(31,4,2,11,0,1,'2026-04-30 21:41:17','2026-04-30 21:41:17'),(32,15,2,10,1,0,'2026-05-01 11:13:51','2026-05-01 11:13:51'),(33,15,2,11,1,0,'2026-05-01 11:13:51','2026-05-01 11:13:51'),(34,17,1,1,1,0,'2026-05-01 11:50:29','2026-05-01 11:50:29'),(35,17,1,2,1,0,'2026-05-01 11:50:29','2026-05-01 11:50:29'),(36,17,1,3,1,0,'2026-05-01 11:50:29','2026-05-01 11:50:29'),(37,18,2,10,1,0,'2026-05-01 12:03:04','2026-05-01 12:03:04'),(38,18,2,11,1,0,'2026-05-01 12:03:04','2026-05-01 12:03:04'),(39,26,1,1,0,1,'2026-05-04 13:11:05','2026-05-04 13:11:05'),(40,26,1,2,0,1,'2026-05-04 13:11:05','2026-05-04 13:11:05'),(41,26,1,3,0,1,'2026-05-04 13:11:05','2026-05-04 13:11:05'),(42,27,2,10,1,0,'2026-05-07 03:44:57','2026-05-07 03:44:57'),(43,27,2,11,1,0,'2026-05-07 03:44:57','2026-05-07 03:44:57'),(44,28,1,1,1,0,'2026-05-08 14:57:13','2026-05-08 14:57:13'),(45,28,1,2,1,0,'2026-05-08 14:57:13','2026-05-08 14:57:13'),(46,28,1,3,1,0,'2026-05-08 14:57:13','2026-05-08 14:57:13'),(47,28,2,10,1,0,'2026-05-08 16:32:10','2026-05-08 16:32:10'),(48,28,2,11,1,0,'2026-05-08 16:32:10','2026-05-08 16:32:10'),(49,29,1,1,1,0,'2026-05-11 04:18:42','2026-05-11 04:18:42'),(50,29,1,2,1,0,'2026-05-11 04:18:42','2026-05-11 04:18:42'),(51,29,1,3,1,0,'2026-05-11 04:18:42','2026-05-11 04:18:42'),(52,1,2,10,1,0,'2026-05-12 12:46:49','2026-05-12 12:46:49'),(53,1,2,11,0,1,'2026-05-12 12:46:49','2026-05-12 12:46:49'),(54,30,2,10,0,1,'2026-05-17 14:55:33','2026-05-17 14:55:33'),(55,30,2,11,0,1,'2026-05-17 14:55:33','2026-05-17 14:55:33'),(56,30,1,1,1,0,'2026-05-17 14:55:51','2026-05-17 14:55:51'),(57,30,1,2,1,0,'2026-05-17 14:55:51','2026-05-17 14:55:51'),(58,30,1,3,1,0,'2026-05-17 14:55:51','2026-05-17 14:55:51'),(59,31,1,1,0,1,'2026-05-17 16:33:12','2026-05-17 16:33:12'),(60,31,1,2,0,1,'2026-05-17 16:33:12','2026-05-17 16:33:12'),(61,31,1,3,0,1,'2026-05-17 16:33:12','2026-05-17 16:33:12'),(62,13,2,10,1,0,'2026-05-20 21:43:28','2026-05-20 21:43:28'),(63,13,2,11,0,1,'2026-05-20 21:43:28','2026-05-20 21:43:28'),(64,13,1,1,1,0,'2026-05-20 21:45:15','2026-05-20 21:45:15'),(65,13,1,2,0,1,'2026-05-20 21:45:15','2026-05-20 21:45:15'),(66,13,1,3,0,1,'2026-05-20 21:45:15','2026-05-20 21:45:15');
/*!40000 ALTER TABLE `enrolmentcoursemodules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaderboard`
--

DROP TABLE IF EXISTS `leaderboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaderboard` (
  `leaderboardID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `totalAchievements` int NOT NULL DEFAULT '0',
  `userRanking` int DEFAULT NULL,
  `userBadges` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`leaderboardID`),
  KEY `leaderboard_userid_foreign` (`userID`),
  CONSTRAINT `leaderboard_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaderboard`
--

LOCK TABLES `leaderboard` WRITE;
/*!40000 ALTER TABLE `leaderboard` DISABLE KEYS */;
/*!40000 ALTER TABLE `leaderboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `learningmaterials`
--

DROP TABLE IF EXISTS `learningmaterials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `learningmaterials` (
  `learningMaterialID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lectID` bigint unsigned NOT NULL,
  `learningMaterialTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `learningMaterialDesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `learningMaterialType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storagePath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`learningMaterialID`),
  KEY `learningmaterials_lectid_foreign` (`lectID`),
  CONSTRAINT `learningmaterials_lectid_foreign` FOREIGN KEY (`lectID`) REFERENCES `lecture` (`lectID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learningmaterials`
--

LOCK TABLES `learningmaterials` WRITE;
/*!40000 ALTER TABLE `learningmaterials` DISABLE KEYS */;
/*!40000 ALTER TABLE `learningmaterials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture`
--

DROP TABLE IF EXISTS `lecture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture` (
  `lectID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `moduleID` bigint unsigned NOT NULL,
  `lectName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lect_duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lectID`),
  KEY `lecture_moduleid_foreign` (`moduleID`),
  CONSTRAINT `lecture_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture`
--

LOCK TABLES `lecture` WRITE;
/*!40000 ALTER TABLE `lecture` DISABLE KEYS */;
INSERT INTO `lecture` VALUES (1,1,'Overview of Bengoh Dam','5','2026-04-23 05:27:27','2026-04-23 05:27:27'),(2,1,'Common Hiking Routes','4','2026-04-23 05:27:42','2026-04-23 05:27:42'),(3,2,'Essential Gear Checklist','3','2026-04-23 05:28:01','2026-04-23 05:28:01'),(4,3,'Trail Awareness','3','2026-04-23 05:28:19','2026-04-23 05:28:19'),(5,10,'Introduction to Bengoh Waterfalls','3','2026-04-27 02:14:27','2026-04-27 02:14:27'),(6,10,'Hydrology & Flow Dynamics','7','2026-04-27 02:15:11','2026-04-27 02:15:11'),(7,11,'Understanding the Curtain Effect','4','2026-04-27 02:15:32','2026-04-27 02:15:32'),(8,11,'Geological Formation of Waterfalls','5','2026-04-27 02:16:02','2026-04-27 02:16:02'),(9,11,'Environmental & Tourism Impact','5','2026-04-27 02:16:22','2026-04-27 02:16:22');
/*!40000 ALTER TABLE `lecture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_section_translations`
--

DROP TABLE IF EXISTS `lecture_section_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_section_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sectionID` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecture_section_translations_sectionid_locale_unique` (`sectionID`,`locale`),
  CONSTRAINT `lecture_section_translations_sectionid_foreign` FOREIGN KEY (`sectionID`) REFERENCES `lecture_sections` (`sectionID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_section_translations`
--

LOCK TABLES `lecture_section_translations` WRITE;
/*!40000 ALTER TABLE `lecture_section_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecture_section_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_sections`
--

DROP TABLE IF EXISTS `lecture_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_sections` (
  `sectionID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lectID` bigint unsigned NOT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_content` text COLLATE utf8mb4_unicode_ci,
  `section_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_order` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sectionID`),
  KEY `lecture_sections_lectid_foreign` (`lectID`),
  CONSTRAINT `lecture_sections_lectid_foreign` FOREIGN KEY (`lectID`) REFERENCES `lecture` (`lectID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_sections`
--

LOCK TABLES `lecture_sections` WRITE;
/*!40000 ALTER TABLE `lecture_sections` DISABLE KEYS */;
INSERT INTO `lecture_sections` VALUES (1,1,'Introduction','text','<p data-start=\"371\" data-end=\"567\">In this lesson, you will be introduced to Bengoh Dam as a hiking destination. The area is known for its beautiful rainforest, rivers, and waterfalls, but it also presents unique safety challenges.</p>\r\n<p data-start=\"569\" data-end=\"719\">By understanding the environment, hikers can better prepare for potential risks such as slippery trails, remote locations, and sudden weather changes.</p>',NULL,1,'2026-04-23 05:29:02','2026-04-23 05:29:02'),(2,1,'Safety Tips','text','<ul>\r\n<li data-section-id=\"13ov3dh\" data-start=\"789\" data-end=\"846\">Bengoh Dam is a remote area with limited phone signal</li>\r\n<li data-section-id=\"1u78pj2\" data-start=\"847\" data-end=\"898\">Terrain includes danger trails, rocks, and rivers</li>\r\n<li data-section-id=\"28vxt0\" data-start=\"899\" data-end=\"946\">Weather can change quickly, increasing risk</li>\r\n<li data-section-id=\"1t8mhyk\" data-start=\"947\" data-end=\"996\">Proper preparation is essential before hiking</li>\r\n</ul>',NULL,2,'2026-04-23 05:29:35','2026-04-23 05:29:35'),(3,2,'Tips for Choosing Routes','text','<ul>\r\n<li data-section-id=\"1119tmg\" data-start=\"1472\" data-end=\"1517\">Choose routes based on your fitness level</li>\r\n<li data-section-id=\"brkk0z\" data-start=\"1518\" data-end=\"1561\">Follow experienced guides when possible</li>\r\n<li data-section-id=\"1w0rzo6\" data-start=\"1562\" data-end=\"1589\">Avoid unknown shortcuts</li>\r\n<li data-section-id=\"x2kq3y\" data-start=\"1590\" data-end=\"1637\">Always inform someone about your route plan</li>\r\n</ul>',NULL,3,'2026-04-23 05:30:02','2026-04-23 05:30:02'),(4,3,'Essential Gear','text','<p>Proper gear is important for safety and comfort during hiking. Carrying the right items can help you handle emergencies effectively. Checklist:</p>\r\n<ul>\r\n<li data-section-id=\"clsn6i\" data-start=\"3055\" data-end=\"3067\">Backpack</li>\r\n<li data-section-id=\"14o3vwh\" data-start=\"3068\" data-end=\"3095\">Water and food supplies</li>\r\n<li data-section-id=\"16oxoq0\" data-start=\"3096\" data-end=\"3113\">First aid kit</li>\r\n<li data-section-id=\"1v0ya39\" data-start=\"3114\" data-end=\"3135\">Map or GPS device</li>\r\n<li data-section-id=\"3pdwxr\" data-start=\"3136\" data-end=\"3158\">Proper hiking shoes</li>\r\n<li data-section-id=\"115riv3\" data-start=\"3159\" data-end=\"3178\">Rain protection</li>\r\n</ul>',NULL,4,'2026-04-23 05:30:56','2026-04-23 05:30:56'),(5,4,'Understanding the Trail','text','<p>Trail awareness helps hikers recognize safe and unsafe paths. Not all trails are clearly marked, so paying attention to surroundings is essential. Tips:</p>\r\n<ul>\r\n<li data-section-id=\"1hs28hm\" data-start=\"4050\" data-end=\"4085\">Look for trail markers or signs</li>\r\n<li data-section-id=\"x918wm\" data-start=\"4086\" data-end=\"4115\">Stay on established paths</li>\r\n<li data-section-id=\"1vdqi7i\" data-start=\"4116\" data-end=\"4141\">Avoid unstable ground</li>\r\n<li data-section-id=\"ahy0c2\" data-start=\"4142\" data-end=\"4182\">Watch for steep or slippery sections</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>https://www.youtube.com/watch?v=pq2p3Yl1pVg</p>',NULL,5,'2026-04-23 05:32:30','2026-04-23 05:32:30'),(6,5,'Overview of Bengoh Waterfall Landscape','text','<p data-start=\"273\" data-end=\"532\">The Bengoh area, located in Sarawak, is known for its lush tropical rainforest and highland terrain, creating ideal conditions for waterfall formation. These waterfalls are formed by continuous rainfall, elevation differences, and natural rock formations.</p>\r\n<ul data-start=\"534\" data-end=\"698\">\r\n<li data-start=\"534\" data-end=\"576\" data-section-id=\"hv815n\">Found within dense jungle environments</li>\r\n<li data-start=\"577\" data-end=\"617\" data-section-id=\"qaf4yi\">Fed by rainfall and upstream streams</li>\r\n<li data-start=\"618\" data-end=\"698\" data-section-id=\"ruwxs0\">Often part of a larger waterfall circuit (multiple connected waterfalls)</li>\r\n</ul>',NULL,6,'2026-04-27 07:03:45','2026-04-27 07:03:45'),(7,5,'What is a Waterfall?','text','<p data-start=\"737\" data-end=\"835\">A waterfall is a place where water flows over a vertical drop or steep slope in a river or stream.</p>\r\n<p data-start=\"737\" data-end=\"835\">Key Features</p>\r\n<ul data-start=\"855\" data-end=\"988\">\r\n<li data-start=\"855\" data-end=\"898\" data-section-id=\"hrww40\">Source: Rainwater or upstream river</li>\r\n<li data-start=\"899\" data-end=\"939\" data-section-id=\"or5wz4\">Drop: Sudden change in elevation</li>\r\n<li data-start=\"940\" data-end=\"988\" data-section-id=\"1dxbypz\">Flow: Continuous movement due to gravity</li>\r\n</ul>\r\n<h3 data-start=\"990\" data-end=\"1014\" data-section-id=\"1u78ykf\">&nbsp;</h3>\r\n<p>Type of waterfalls</p>\r\n<ul data-start=\"1015\" data-end=\"1203\">\r\n<li data-start=\"1015\" data-end=\"1067\" data-section-id=\"1owuqbm\">Plunge: Water falls freely (no rock contact)</li>\r\n<li data-start=\"1068\" data-end=\"1116\" data-section-id=\"n9xfzu\">Cascade: Water flows over rocks in steps</li>\r\n<li data-start=\"1117\" data-end=\"1203\" data-section-id=\"1y7fkuh\">Curtain: Water forms a smooth sheet over rock surface</li>\r\n</ul>',NULL,7,'2026-04-27 07:04:58','2026-04-27 07:04:58'),(8,5,'Importance of Waterfalls','text','<h3 data-start=\"1247\" data-end=\"1278\" data-section-id=\"1vd4kbr\">Environmental Importance</h3>\r\n<ul data-start=\"1279\" data-end=\"1405\">\r\n<li data-start=\"1279\" data-end=\"1334\" data-section-id=\"1ke9zrp\">Support micro-ecosystems (moss, ferns, insects)</li>\r\n<li data-start=\"1335\" data-end=\"1374\" data-section-id=\"l7r3cl\">Maintain humidity and local climate</li>\r\n<li data-start=\"1375\" data-end=\"1405\" data-section-id=\"1unkrcu\">Contribute to river health</li>\r\n</ul>\r\n<h3 data-start=\"1407\" data-end=\"1442\" data-section-id=\"1gmrz2r\">Social &amp; Economic Importance</h3>\r\n<ul data-start=\"1443\" data-end=\"1542\">\r\n<li data-start=\"1443\" data-end=\"1469\" data-section-id=\"1b4c0cq\">Eco-tourism attraction</li>\r\n<li data-start=\"1470\" data-end=\"1508\" data-section-id=\"jqp3gc\">Recreational and educational value</li>\r\n<li data-start=\"1509\" data-end=\"1542\" data-section-id=\"psxbmf\">Cultural and natural heritage</li>\r\n</ul>',NULL,8,'2026-04-27 08:21:04','2026-04-27 08:21:04'),(9,6,'How Waterfalls Form','text','<p data-start=\"1581\" data-end=\"1676\">Waterfalls develop over long periods through natural geological and hydrological processes:</p>\r\n<ul data-start=\"1678\" data-end=\"1850\">\r\n<li data-start=\"1678\" data-end=\"1741\" data-section-id=\"1f04goo\">Erosion: Softer rock wears away faster than harder rock</li>\r\n<li data-start=\"1742\" data-end=\"1802\" data-section-id=\"ld8nh9\">Water Flow: Continuous movement shapes the landscape</li>\r\n<li data-start=\"1803\" data-end=\"1850\" data-section-id=\"1h5yifa\">Elevation: Highlands create steep drops</li>\r\n</ul>\r\n<p data-start=\"1852\" data-end=\"1924\">Over time, this creates the distinct waterfall structure seen in Bengoh.</p>',NULL,9,'2026-04-27 08:21:40','2026-04-27 08:21:40'),(10,6,'Waterfall Ecosystem','text','<p data-start=\"1962\" data-end=\"2037\">Waterfalls are not just physical features but they are&nbsp;living environments.</p>\r\n<h3 data-start=\"2039\" data-end=\"2059\" data-section-id=\"24jpq4\">Common Elements:</h3>\r\n<ul data-start=\"2060\" data-end=\"2165\">\r\n<li data-start=\"2060\" data-end=\"2092\" data-section-id=\"1zm3m8\">Plants: mosses, ferns, algae</li>\r\n<li data-start=\"2093\" data-end=\"2125\" data-section-id=\"faof2s\">Animals: insects, amphibians</li>\r\n<li data-start=\"2126\" data-end=\"2165\" data-section-id=\"y66kmz\">Water conditions: cool, oxygen-rich</li>\r\n</ul>\r\n<p data-start=\"2167\" data-end=\"2220\">These ecosystems are sensitive and must be protected.</p>',NULL,10,'2026-04-27 08:22:47','2026-04-27 08:22:47'),(11,6,'Safety & Environmental Awareness','text','<h3 data-start=\"2272\" data-end=\"2288\" data-section-id=\"11hvzni\">Safety Tips:</h3>\r\n<ul data-start=\"2289\" data-end=\"2375\">\r\n<li data-start=\"2289\" data-end=\"2322\" data-section-id=\"1y8a00j\">Be cautious on slippery rocks</li>\r\n<li data-start=\"2323\" data-end=\"2348\" data-section-id=\"ns39hw\">Avoid strong currents</li>\r\n<li data-start=\"2349\" data-end=\"2375\" data-section-id=\"1fpnlyf\">Stay within safe areas</li>\r\n</ul>\r\n<h3 data-start=\"2377\" data-end=\"2410\" data-section-id=\"12bmi6g\">Environmental Responsibility:</h3>\r\n<ul data-start=\"2411\" data-end=\"2484\">\r\n<li data-start=\"2411\" data-end=\"2428\" data-section-id=\"32jzvo\">Do not litter</li>\r\n<li data-start=\"2429\" data-end=\"2454\" data-section-id=\"15vz6sn\">Avoid damaging plants</li>\r\n<li data-start=\"2455\" data-end=\"2484\" data-section-id=\"1b5oaha\">Respect wildlife habitats</li>\r\n</ul>',NULL,11,'2026-04-27 08:28:32','2026-04-27 08:28:32'),(12,7,'Introduction to the Curtain Effect','text','<p data-start=\"187\" data-end=\"476\">The curtain effect refers to a type of waterfall where water flows in a smooth, continuous sheet over a rock surface, resembling a curtain. Unlike plunging waterfalls, the water does not break into separate streams but maintains a relatively even distribution across the rock face.</p>\r\n<p data-start=\"478\" data-end=\"597\">This effect is commonly observed in areas like Bengoh, where the terrain and rock formations support this type of flow.</p>',NULL,12,'2026-04-27 08:29:42','2026-04-27 08:29:42'),(13,7,'Key Characteristics of the Curtain Effect','text','<ul>\r\n<li data-section-id=\"15unpar\" data-start=\"657\" data-end=\"712\">Water spreads evenly across a wide rock surface</li>\r\n<li data-section-id=\"qtoqqp\" data-start=\"713\" data-end=\"762\">Flow appears thin, smooth, and continuous</li>\r\n<li data-section-id=\"hjh2o\" data-start=\"763\" data-end=\"813\">Minimal splashing compared to steep waterfalls</li>\r\n<li data-section-id=\"1pzk4d7\" data-start=\"814\" data-end=\"867\">Often forms a transparent or silky appearance</li>\r\n<li data-section-id=\"tsuxmp\" data-start=\"868\" data-end=\"937\">Can create mist at the base depending on height and flow rate</li>\r\n</ul>','lecture_sections/c1WnqcmAOAwSvuX3o9YlUnWWNoPjpwhEPmM9Q41S.jpg',13,'2026-04-27 08:31:23','2026-04-27 08:31:23'),(14,8,'Factors That Create the Curtain Effect','text','<h3 data-section-id=\"i0k63q\" data-start=\"995\" data-end=\"1022\">a. Rock Surface Shape</h3>\r\n<ul data-start=\"1023\" data-end=\"1161\">\r\n<li data-section-id=\"jskuug\" data-start=\"1023\" data-end=\"1092\">Smooth, gently sloping rock allows water to spread out evenly</li>\r\n<li data-section-id=\"pkxxfq\" data-start=\"1093\" data-end=\"1161\">Absence of sharp edges prevents water from breaking into streams</li>\r\n</ul>\r\n<h3 data-section-id=\"r1guhe\" data-start=\"1163\" data-end=\"1196\">b. Water Volume (Discharge)</h3>\r\n<ul data-start=\"1197\" data-end=\"1294\">\r\n<li data-section-id=\"b59wp0\" data-start=\"1197\" data-end=\"1223\">Moderate flow is ideal</li>\r\n<li data-section-id=\"rxxm0i\" data-start=\"1224\" data-end=\"1255\">Too little &rarr; broken streams</li>\r\n<li data-section-id=\"1f2ey7j\" data-start=\"1256\" data-end=\"1294\">Too much &rarr; turbulent, chaotic flow</li>\r\n</ul>\r\n<h3 data-section-id=\"1yafalk\" data-start=\"1296\" data-end=\"1319\">c. Slope Gradient</h3>\r\n<ul data-start=\"1320\" data-end=\"1426\">\r\n<li data-section-id=\"zanlpd\" data-start=\"1320\" data-end=\"1373\">Gentle to moderate slope supports sheet-like flow</li>\r\n<li data-section-id=\"jg7zci\" data-start=\"1374\" data-end=\"1426\">Steep slopes tend to produce plunging waterfalls</li>\r\n</ul>\r\n<h3 data-section-id=\"nu1odi\" data-start=\"1428\" data-end=\"1452\">d. Surface Texture</h3>\r\n<ul data-start=\"1453\" data-end=\"1557\">\r\n<li data-section-id=\"wh17tu\" data-start=\"1453\" data-end=\"1511\">Fine-grained rock (e.g., granite) enhances smooth flow</li>\r\n<li data-section-id=\"oxadyk\" data-start=\"1512\" data-end=\"1557\">Rough surfaces disrupt the curtain effect</li>\r\n</ul>',NULL,14,'2026-04-27 08:37:03','2026-04-27 08:37:03'),(15,9,'Environmental Importance','text','<ul>\r\n<li data-section-id=\"dqbfuk\" data-start=\"2396\" data-end=\"2448\">Provides habitat for moisture-loving species</li>\r\n<li data-section-id=\"vya6o0\" data-start=\"2449\" data-end=\"2502\">Helps regulate local temperature and humidity</li>\r\n<li data-section-id=\"3hfvka\" data-start=\"2503\" data-end=\"2555\">Contributes to erosion and landscape shaping</li>\r\n<li data-section-id=\"e98fsv\" data-start=\"2556\" data-end=\"2606\">Enhances natural beauty &rarr; supports eco-tourism</li>\r\n</ul>',NULL,15,'2026-04-27 08:37:33','2026-04-27 08:37:33');
/*!40000 ALTER TABLE `lecture_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lectureprogress`
--

DROP TABLE IF EXISTS `lectureprogress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lectureprogress` (
  `lectProgressID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `lectID` bigint unsigned NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lectProgressID`),
  UNIQUE KEY `lectureprogress_userid_lectid_unique` (`userID`,`lectID`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectureprogress`
--

LOCK TABLES `lectureprogress` WRITE;
/*!40000 ALTER TABLE `lectureprogress` DISABLE KEYS */;
INSERT INTO `lectureprogress` VALUES (1,1,4,'2026-04-27 15:30:04',NULL,NULL),(2,1,1,'2026-05-21 00:06:06',NULL,NULL),(3,1,2,'2026-05-16 01:15:28',NULL,NULL),(4,1,3,'2026-05-16 01:21:47',NULL,NULL),(5,4,2,'2026-05-02 13:16:18',NULL,NULL),(6,4,3,'2026-05-02 09:07:56',NULL,NULL),(7,4,4,'2026-05-26 01:24:03',NULL,NULL),(8,3,1,'2026-05-04 13:06:15',NULL,NULL),(9,3,4,'2026-05-04 06:53:57',NULL,NULL),(10,3,2,'2026-04-27 03:18:43',NULL,NULL),(11,3,3,'2026-05-04 06:53:00',NULL,NULL),(12,8,5,'2026-04-28 07:16:37',NULL,NULL),(13,8,2,'2026-04-28 07:18:35',NULL,NULL),(14,8,3,'2026-04-28 07:18:50',NULL,NULL),(15,8,1,'2026-04-28 07:19:32',NULL,NULL),(16,8,4,'2026-04-28 07:22:07',NULL,NULL),(17,9,5,'2026-04-30 07:55:08',NULL,NULL),(18,9,6,'2026-04-30 07:54:32',NULL,NULL),(19,9,7,'2026-04-30 07:59:58',NULL,NULL),(20,9,8,'2026-04-30 07:54:31',NULL,NULL),(21,9,9,'2026-04-30 07:54:31',NULL,NULL),(22,10,5,'2026-04-30 10:57:49',NULL,NULL),(23,10,7,'2026-04-30 11:01:35',NULL,NULL),(24,10,6,'2026-04-30 10:57:59',NULL,NULL),(25,10,8,'2026-04-30 11:01:37',NULL,NULL),(26,10,9,'2026-04-30 11:01:39',NULL,NULL),(27,11,5,'2026-04-30 10:58:38',NULL,NULL),(28,11,6,'2026-04-30 10:58:45',NULL,NULL),(29,11,9,'2026-04-30 11:00:14',NULL,NULL),(30,11,8,'2026-04-30 11:00:11',NULL,NULL),(31,11,7,'2026-04-30 11:00:09',NULL,NULL),(32,4,1,'2026-05-26 01:57:47',NULL,NULL),(33,4,5,'2026-05-23 15:55:23',NULL,NULL),(34,15,5,'2026-05-01 11:29:48',NULL,NULL),(35,15,6,'2026-05-01 11:30:13',NULL,NULL),(36,15,7,'2026-05-01 11:34:21',NULL,NULL),(37,15,9,'2026-05-01 11:34:41',NULL,NULL),(38,15,8,'2026-05-01 11:34:26',NULL,NULL),(39,17,1,'2026-05-01 11:50:32',NULL,NULL),(40,17,3,'2026-05-01 11:51:21',NULL,NULL),(41,17,2,'2026-05-01 11:50:34',NULL,NULL),(42,17,4,'2026-05-01 11:52:04',NULL,NULL),(43,18,5,'2026-05-01 12:03:12',NULL,NULL),(44,18,6,'2026-05-01 12:03:19',NULL,NULL),(45,18,9,'2026-05-01 12:05:51',NULL,NULL),(46,18,8,'2026-05-01 12:05:49',NULL,NULL),(47,18,7,'2026-05-01 12:05:46',NULL,NULL),(48,4,6,'2026-05-02 03:11:32',NULL,NULL),(49,4,7,'2026-05-21 02:09:23',NULL,NULL),(50,26,1,'2026-05-04 13:26:06',NULL,NULL),(51,27,5,'2026-05-07 03:56:47',NULL,NULL),(52,27,6,'2026-05-07 03:47:46',NULL,NULL),(53,27,9,'2026-05-07 03:45:02',NULL,NULL),(54,27,8,'2026-05-07 03:45:02',NULL,NULL),(55,27,7,'2026-05-07 03:48:57',NULL,NULL),(56,28,1,'2026-05-17 16:31:36',NULL,NULL),(57,28,3,'2026-05-17 15:16:18',NULL,NULL),(58,28,2,'2026-05-17 15:16:11',NULL,NULL),(59,28,4,'2026-05-17 15:16:54',NULL,NULL),(60,28,5,'2026-05-17 15:09:20',NULL,NULL),(61,28,6,'2026-05-17 15:06:47',NULL,NULL),(62,28,7,'2026-05-17 15:07:00',NULL,NULL),(63,28,8,'2026-05-17 15:07:56',NULL,NULL),(64,28,9,'2026-05-17 15:07:10',NULL,NULL),(65,29,1,'2026-05-11 04:18:48',NULL,NULL),(66,29,2,'2026-05-11 04:18:52',NULL,NULL),(67,29,4,'2026-05-11 04:20:24',NULL,NULL),(68,29,3,'2026-05-11 04:19:29',NULL,NULL),(69,1,5,'2026-05-17 15:47:54',NULL,NULL),(70,1,6,'2026-05-16 02:01:58',NULL,NULL),(71,30,5,'2026-05-20 17:46:25',NULL,NULL),(72,30,1,'2026-05-17 14:58:18',NULL,NULL),(73,30,2,'2026-05-17 14:58:20',NULL,NULL),(74,30,3,'2026-05-17 14:58:54',NULL,NULL),(75,30,4,'2026-05-17 14:59:21',NULL,NULL),(76,31,1,'2026-05-17 16:36:37',NULL,NULL),(77,13,5,'2026-05-20 21:43:43',NULL,NULL),(78,13,6,'2026-05-20 21:43:45',NULL,NULL),(79,13,1,'2026-05-20 21:56:02',NULL,NULL),(80,13,2,'2026-05-20 21:58:53',NULL,NULL);
/*!40000 ALTER TABLE `lectureprogress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcqs`
--

DROP TABLE IF EXISTS `mcqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mcqs` (
  `moduleQs_ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `moduleID` bigint unsigned NOT NULL,
  `group_id` bigint unsigned DEFAULT NULL,
  `source` enum('manual','ai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `moduleQs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` int DEFAULT NULL,
  PRIMARY KEY (`moduleQs_ID`),
  KEY `mcqs_moduleid_foreign` (`moduleID`),
  CONSTRAINT `mcqs_moduleid_foreign` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcqs`
--

LOCK TABLES `mcqs` WRITE;
/*!40000 ALTER TABLE `mcqs` DISABLE KEYS */;
INSERT INTO `mcqs` VALUES (1,1,NULL,'manual',1,'What is Bengoh Dam known for?','What is Bengoh Dam known for?','2026-04-23 05:51:09','2026-04-23 05:51:09','Beautiful rainforest, rivers, and waterfalls','Urban landscapes','Historical landmarks','Wildlife sanctuaries',1),(2,1,NULL,'manual',1,'What unique safety challenge is mentioned for hikers at Bengoh Dam?','What unique safety challenge is mentioned for hikers at Bengoh Dam?','2026-04-23 05:51:09','2026-04-23 05:51:09','Limited phone signal','High population density','Frequent tourist traffic','Open wildfires',1),(3,1,NULL,'manual',1,'Which of the following is a recommended safety tip for hiking?','Which of the following is a recommended safety tip for hiking?','2026-04-23 05:51:09','2026-04-23 05:51:09','Choose routes based on your fitness level','Hike alone for safety','Ignore weather forecasts','Always take shortcuts',1),(4,1,NULL,'manual',1,'What should hikers do regarding weather changes?','What should hikers do regarding weather changes?','2026-04-23 05:51:09','2026-04-23 05:51:09','Prepare for sudden changes','Ignore the weather','Only hike in perfect weather','Rely on other hikers\' experiences',1),(5,1,NULL,'manual',1,'What is a crucial step before starting a hike?','What is a crucial step before starting a hike?','2026-04-23 05:51:09','2026-04-23 05:51:09','Proper preparation','Pack unnecessary items','Leave without informing anyone','Choose the longest route',1),(6,2,NULL,'manual',1,'What is essential for safety and comfort during hiking?','What is essential for safety and comfort during hiking?','2026-04-24 09:17:10','2026-04-24 09:17:10','Proper gear','Heavy equipment','Casual clothing','Nothing special',0),(7,2,NULL,'manual',1,'Which of the following items is NOT listed in the hiking checklist?','Which of the following items is NOT listed in the hiking checklist?','2026-04-24 09:17:10','2026-04-24 09:17:10','Water and food supplies','First aid kit','Tent','Map or GPS device',2),(8,2,NULL,'manual',1,'What should you carry to handle emergencies effectively while hiking?','What should you carry to handle emergencies effectively while hiking?','2026-04-24 09:17:10','2026-04-24 09:17:10','First aid kit','Snacks only','Extra clothes','GPS only',0),(9,3,NULL,'manual',1,'What is the primary purpose of trail awareness for hikers?','What is the primary purpose of trail awareness for hikers?','2026-04-24 09:17:22','2026-04-24 09:17:22','To recognize safe and unsafe paths','To enjoy the scenery','To take photos','To meet other hikers',0),(10,3,NULL,'manual',1,'Which of the following is NOT a tip for safe hiking mentioned in the content?','Which of the following is NOT a tip for safe hiking mentioned in the content?','2026-04-24 09:17:22','2026-04-24 09:17:22','Look for trail markers or signs','Bring a map','Stay on established paths','Avoid unstable ground',1),(11,10,NULL,'manual',1,'What natural feature is the Bengoh area in Sarawak known for?','What natural feature is the Bengoh area in Sarawak known for?','2026-04-27 08:38:08','2026-04-27 08:38:08','Deserts','Waterfalls','Mountains','Lakes',1),(12,10,NULL,'manual',1,'Which of the following conditions contribute to waterfall formation in the Bengoh area?','Which of the following conditions contribute to waterfall formation in the Bengoh area?','2026-04-27 08:38:08','2026-04-27 08:38:08','Continuous rainfall','High temperatures','Low elevation','Dry climate',0),(13,10,NULL,'manual',1,'What is a key feature of waterfalls?','What is a key feature of waterfalls?','2026-04-27 08:38:08','2026-04-27 08:38:08','They are static bodies of water','They are formed only in urban areas','They involve a drop in elevation','They flow only during winter',2),(14,10,NULL,'manual',1,'What type of waterfall is characterized by water falling freely without contact with rocks?','What type of waterfall is characterized by water falling freely without contact with rocks?','2026-04-27 08:38:08','2026-04-27 08:38:08','Cascade','Plunge','Tiered','Segmented',1),(15,10,NULL,'manual',1,'What primarily feeds the waterfalls in the Bengoh area?','What primarily feeds the waterfalls in the Bengoh area?','2026-04-27 08:38:08','2026-04-27 08:38:08','Groundwater','Rainfall and upstream streams','Ocean tides','Glacial melt',1),(16,11,NULL,'manual',1,'What is the curtain effect in waterfalls?','What is the curtain effect in waterfalls?','2026-04-27 08:38:28','2026-04-27 08:38:28','Water flows in a smooth, continuous sheet over a rock surface','Water breaks into separate streams','Water falls vertically without any smooth flow','Water creates a misty effect without flowing',0),(17,11,NULL,'manual',1,'In which area is the curtain effect commonly observed?','In which area is the curtain effect commonly observed?','2026-04-27 08:38:28','2026-04-27 08:38:28','Bengoh','Niagara Falls','Victoria Falls','Angel Falls',0),(18,11,NULL,'manual',1,'What characteristic describes the flow of water in the curtain effect?','What characteristic describes the flow of water in the curtain effect?','2026-04-27 08:38:28','2026-04-27 08:38:28','It appears thin, smooth, and continuous','It is turbulent and chaotic','It forms large droplets','It is intermittent and sporadic',0),(19,11,NULL,'manual',1,'What happens to the splashing of water in the curtain effect compared to steep waterfalls?','What happens to the splashing of water in the curtain effect compared to steep waterfalls?','2026-04-27 08:38:28','2026-04-27 08:38:28','There is minimal splashing','There is excessive splashing','The splashing is more pronounced','The water splashes sporadically',0),(20,11,NULL,'manual',1,'What contributes to the formation of the curtain effect on a rock surface?','What contributes to the formation of the curtain effect on a rock surface?','2026-04-27 08:38:28','2026-04-27 08:38:28','Smooth, gently sloping rock','Sharp, jagged edges','A steep vertical drop','Rough, uneven surfaces',0),(21,10,NULL,'manual',1,'What natural feature is the Bengoh area in Sarawak known for?','What is the primary factor contributing to waterfall formation in the Bengoh area?','2026-05-21 02:22:32','2026-05-21 02:22:32','Continuous rainfall','High temperatures','Human intervention','Lack of vegetation',0),(22,10,NULL,'manual',1,'Which of the following conditions contribute to waterfall formation in the Bengoh area?','Which characteristic describes the flow of water in a waterfall?','2026-05-21 02:22:32','2026-05-21 02:22:32','Static and still','Random movement','Continuous movement due to gravity','Only occurs during rainfall',2),(23,10,NULL,'manual',1,'What is a key feature of waterfalls?','What type of waterfall allows water to fall freely without contact with rocks?','2026-05-21 02:22:32','2026-05-21 02:22:32','Plunge','Cascade','Tiered','Block',0),(24,10,NULL,'manual',1,'What type of waterfall is characterized by water falling freely without contact with rocks?','In what kind of environment are waterfalls in the Bengoh area typically found?','2026-05-21 02:22:32','2026-05-21 02:22:32','Urban areas','Deserts','Dense jungle environments','Flat plains',2),(25,10,NULL,'manual',1,'What primarily feeds the waterfalls in the Bengoh area?','What is a common feature of waterfalls according to the text?','2026-05-21 02:22:32','2026-05-21 02:22:32','They are usually man-made','They are always wide and shallow','They are often part of a larger waterfall circuit','They occur only in winter',2),(26,2,NULL,'manual',1,'What is essential for safety and comfort during hiking?','What is one of the essential items to carry during a hike for handling emergencies?','2026-05-26 01:28:21','2026-05-26 01:28:21','First aid kit','Sunscreen','Camera','Extra clothes',0),(27,2,NULL,'manual',1,'Which of the following items is NOT listed in the hiking checklist?','Which of the following is NOT listed as part of the hiking checklist?','2026-05-26 01:28:21','2026-05-26 01:28:21','Map or GPS device','Water and food supplies','Hiking poles','Proper hiking shoes',2);
/*!40000 ALTER TABLE `mcqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_19_015617_modify_users_table',1),(5,'2026_03_19_020315_create_admin_table',1),(6,'2026_03_19_020413_create_course_table',1),(7,'2026_03_19_020627_create_announcements_table',1),(8,'2026_03_19_021231_create_community_stories_table',1),(9,'2026_03_19_021358_create_modules_table',1),(10,'2026_03_19_021511_create_lecture_table',1),(11,'2026_03_19_021625_create_mcqs_table',1),(12,'2026_03_19_021716_create_module_ans_table',1),(13,'2026_03_19_021811_create_course_feedback_table',1),(14,'2026_03_19_021907_create_leaderboard_table',1),(15,'2026_03_19_021936_create_reports_table',1),(16,'2026_03_19_022020_create_user_progress_table',1),(17,'2026_03_19_022108_create_enrolment_course_modules_table',1),(18,'2026_03_19_023012_create_learning_materials_table',1),(19,'2026_03_19_023142_create_pdf_learning_table',1),(20,'2026_03_19_023528_create_assessment_results_table',1),(21,'2026_03_19_023611_create_lecture_sections_table',1),(22,'2026_03_19_023732_create_video_learning_table',1),(23,'2026_03_23_131158_add_feedback_fields_to_coursefeedback_table',1),(24,'2026_03_23_131346_drop_course_rating_from_coursefeedback',1),(25,'2026_03_23_153346_create_lecture_progress_table',1),(26,'2026_03_25_050312_add_reviewed_to_coursefeedback',1),(27,'2026_03_25_143234_create_course_assessments_table',1),(28,'2026_03_25_143349_create_assessment_qs_table',1),(29,'2026_03_25_143556_create_assessment_mcq_options_table',1),(30,'2026_03_26_141807_create_course_ass_attempts_table',1),(31,'2026_03_26_141830_create_course_ass_answers_table',1),(32,'2026_03_27_015425_add_phone_number_and_reset_fields_to_users_table',1),(33,'2026_03_27_082418_add_status_to_announcements_table',1),(34,'2026_03_29_125520_add_remember_token_to_admin_table',1),(35,'2026_03_29_131135_add_remember_token_to_admin_table_fix',1),(36,'2026_03_30_114203_add_mcq_enabled_to_module_table',1),(37,'2026_03_30_123558_add_is_active_to_module_table',1),(38,'2026_03_31_062055_add_course_and_type_to_assessment_results',1),(39,'2026_04_12_100246_update_mcqs_table',1),(40,'2026_04_12_161107_add_attempts_to_assessment_results_table',1),(41,'2026_04_13_061322_create_admin_settings_table',1),(42,'2026_04_18_170042_add_versioning_fields_to_mcqs_table',1),(43,'2026_04_19_062440_create_lecture_section_translations_table',1),(44,'2026_04_21_001714_add_reset_request_to_users_table',1),(45,'2026_04_21_025433_create_translations_table',1),(46,'2026_04_27_074229_update_course_fk_on_enrolmentcoursemodules',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `module` (
  `moduleID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `moduleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mcq_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`moduleID`),
  KEY `module_courseid_foreign` (`courseID`),
  CONSTRAINT `module_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'Introduction to Bengoh Dam',1,'2026-04-23 05:26:41','2026-04-23 05:26:41',1,1),(2,'Pre-Hike Preparation',1,'2026-04-23 05:26:52','2026-04-23 05:26:52',1,1),(3,'Navigation & Route Safety',1,'2026-04-23 05:27:02','2026-04-23 05:27:02',1,1),(10,'Exploring Waterfalls',2,'2026-04-27 01:30:56','2026-04-27 01:30:56',1,1),(11,'The Curtain Effects',2,'2026-04-27 02:13:06','2026-04-27 02:13:06',1,1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduleans`
--

DROP TABLE IF EXISTS `moduleans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `moduleans` (
  `ansID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `moduleQs_ID` bigint unsigned NOT NULL,
  `ansID_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ansCorrect` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ansID`),
  KEY `moduleans_moduleqs_id_foreign` (`moduleQs_ID`),
  CONSTRAINT `moduleans_moduleqs_id_foreign` FOREIGN KEY (`moduleQs_ID`) REFERENCES `mcqs` (`moduleQs_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduleans`
--

LOCK TABLES `moduleans` WRITE;
/*!40000 ALTER TABLE `moduleans` DISABLE KEYS */;
/*!40000 ALTER TABLE `moduleans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdflearning`
--

DROP TABLE IF EXISTS `pdflearning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdflearning` (
  `pdfLearningID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pdfLearningName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdfLearningPath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdfLearningDesc` text COLLATE utf8mb4_unicode_ci,
  `pdfLearningPages` int NOT NULL,
  `pdfLearningSizes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `learningMaterialID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pdfLearningID`),
  KEY `pdflearning_learningmaterialid_foreign` (`learningMaterialID`),
  CONSTRAINT `pdflearning_learningmaterialid_foreign` FOREIGN KEY (`learningMaterialID`) REFERENCES `learningmaterials` (`learningMaterialID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdflearning`
--

LOCK TABLES `pdflearning` WRITE;
/*!40000 ALTER TABLE `pdflearning` DISABLE KEYS */;
/*!40000 ALTER TABLE `pdflearning` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `reportID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `generatedBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportFilePath1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reportID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('98Uydw7E1C9HN6Vbh4HTRZX4cWcJWCareU3HiT9k',1,'175.136.2.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDI1UlRzNUJydFg5RkRETFU1eFZNbzlmeWZDcFFnYWJ6MVR2a3pBNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1779800900),('GwEtCvzpItlei1wMqDrDJEUZ7jZVnpFAPA2qqIMD',NULL,'203.82.75.133','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.7680.179 Spotify/1.2.88.483 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmFkVnJqWkxESHViRkxWTkx2b0o2SlphUlhWV05VS3pUZFh2dU1vRCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MToiaHR0cHM6Ly9iZW5nb2hhY2FkZW15LnVwLnJhaWx3YXkuYXBwL2FkbWluL3NldHRpbmdzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1779758958),('Jz9A1vfivLRI462QRtSgVGKev3Ex0F6MvAWZ5F5G',1,'175.136.2.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidWZuc2NxZHhlTFJEYUJsclpsVHNZbUpDSm1MSzltTkhMNXBNV2lheiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1779792966),('nVmqW3zkPRSD4fhadu4J3s7x4er5suL6undQMdWG',NULL,'175.136.2.252','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzNqTmNmc1JZZjAzN2UyRXE4a1Vlb3UzMTh6SWdtOFhZTDltaThCZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcCI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp4ZTlKOEJCRUs2N3lPVFNQIjt9fQ==',1779763905),('thkezydpL0Xlc6VHQnBXjX1ti4Xa34Bmm6wzZ4Xc',NULL,'34.224.178.127','Iframely/1.3.1 (+https://iframely.com/docs/about) Canva','YTozOntzOjY6Il90b2tlbiI7czo0MDoia1Fub1k5RWVSelUweGFvMktjdUl1Y0VZOGExSW4xWGhNN2VyUXpncSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcCI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp4ZTlKOEJCRUs2N3lPVFNQIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1779763911),('UEHvuR3ICzKWe1eJs6mIPhBiPDKA9ZPGoy70B82f',NULL,'175.140.38.73','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibmNBZHhyY3dUNVNnN3JPbzhUa3pwUWVuVGhMQ3VFQlVBQ0tYR0oxNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmVuZ29oYWNhZGVteS51cC5yYWlsd2F5LmFwcCI7czo1OiJyb3V0ZSI7czoyNzoiZ2VuZXJhdGVkOjp4ZTlKOEJCRUs2N3lPVFNQIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1779772112);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `translatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translatable_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translations_translatable_type_translatable_id_index` (`translatable_type`,`translatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userprogress`
--

DROP TABLE IF EXISTS `userprogress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userprogress` (
  `progressID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL,
  `courseID` bigint unsigned NOT NULL,
  `progressName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `progressStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completionProgress` int NOT NULL,
  `lastAccessed` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`progressID`),
  KEY `userprogress_userid_foreign` (`userID`),
  KEY `userprogress_courseid_foreign` (`courseID`),
  CONSTRAINT `userprogress_courseid_foreign` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  CONSTRAINT `userprogress_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprogress`
--

LOCK TABLES `userprogress` WRITE;
/*!40000 ALTER TABLE `userprogress` DISABLE KEYS */;
INSERT INTO `userprogress` VALUES (1,1,1,'SECTION_5','completed',10,'2026-04-27 16:44:27','2026-04-23 05:32:46','2026-04-27 16:44:27'),(2,1,1,'SECTION_1','completed',10,'2026-05-21 00:06:06','2026-04-23 06:38:01','2026-05-21 00:06:06'),(3,1,1,'SECTION_2','completed',10,'2026-05-16 01:15:25','2026-04-23 06:38:09','2026-05-16 01:15:25'),(4,1,1,'SECTION_3','completed',10,'2026-05-16 01:15:28','2026-04-23 06:38:34','2026-05-16 01:15:28'),(5,1,1,'SECTION_4','completed',10,'2026-05-16 01:21:47','2026-04-23 06:38:37','2026-05-16 01:21:47'),(6,1,1,'MCQ1','completed',0,'2026-04-23 10:06:23','2026-04-23 06:38:52','2026-04-23 10:06:23'),(7,3,1,'SECTION_1','completed',10,'2026-05-04 13:06:15','2026-04-23 12:21:58','2026-05-04 13:06:15'),(8,3,1,'SECTION_4','completed',10,'2026-05-04 06:53:00','2026-04-23 12:22:01','2026-05-04 06:53:00'),(9,3,1,'SECTION_5','completed',10,'2026-05-04 06:53:56','2026-04-23 12:22:01','2026-05-04 06:53:56'),(10,3,1,'SECTION_2','completed',10,'2026-04-27 03:19:14','2026-04-23 12:22:01','2026-04-27 03:19:14'),(11,3,1,'SECTION_3','completed',10,'2026-04-27 03:19:15','2026-04-23 12:22:01','2026-04-27 03:19:15'),(12,1,1,'FINAL_ASSESSMENT','completed',40,'2026-05-17 15:28:03','2026-04-23 15:49:39','2026-05-17 15:28:03'),(13,4,1,'SECTION_1','completed',10,'2026-05-26 01:57:47','2026-04-23 16:33:03','2026-05-26 01:57:47'),(14,4,1,'SECTION_2','completed',10,'2026-05-02 13:10:32','2026-04-23 16:33:05','2026-05-02 13:10:32'),(15,4,1,'SECTION_3','completed',10,'2026-05-02 13:16:17','2026-04-23 16:33:07','2026-05-02 13:16:17'),(16,4,1,'SECTION_4','completed',10,'2026-05-02 09:07:56','2026-04-23 16:33:08','2026-05-02 09:07:56'),(17,4,1,'SECTION_5','completed',10,'2026-05-26 01:24:03','2026-04-23 16:33:12','2026-05-26 01:24:03'),(18,4,1,'FINAL_ASSESSMENT','completed',80,'2026-05-02 09:09:29','2026-04-23 16:46:09','2026-05-02 09:09:29'),(19,8,2,'SECTION_6','completed',10,'2026-04-28 07:16:46','2026-04-28 07:12:26','2026-04-28 07:16:46'),(20,8,2,'SECTION_15','completed',10,'2026-04-28 07:14:16','2026-04-28 07:12:27','2026-04-28 07:14:16'),(21,8,2,'SECTION_8','completed',10,'2026-04-28 07:13:11','2026-04-28 07:12:27','2026-04-28 07:13:11'),(22,8,2,'SECTION_9','completed',10,'2026-04-28 07:16:48','2026-04-28 07:12:27','2026-04-28 07:16:48'),(23,8,2,'SECTION_12','completed',10,'2026-04-28 07:13:48','2026-04-28 07:12:27','2026-04-28 07:13:48'),(24,8,2,'SECTION_11','completed',10,'2026-04-28 07:17:01','2026-04-28 07:12:27','2026-04-28 07:17:01'),(25,8,2,'SECTION_14','completed',10,'2026-04-28 07:14:01','2026-04-28 07:12:28','2026-04-28 07:14:01'),(26,8,2,'SECTION_7','completed',10,'2026-04-28 07:13:05','2026-04-28 07:12:28','2026-04-28 07:13:05'),(27,8,2,'SECTION_13','completed',10,'2026-04-28 07:13:51','2026-04-28 07:12:28','2026-04-28 07:13:51'),(28,8,2,'SECTION_10','completed',10,'2026-04-28 07:16:53','2026-04-28 07:12:28','2026-04-28 07:16:53'),(29,8,1,'SECTION_1','completed',10,'2026-04-28 07:19:27','2026-04-28 07:14:30','2026-04-28 07:19:27'),(30,8,1,'SECTION_2','completed',10,'2026-04-28 07:19:32','2026-04-28 07:14:32','2026-04-28 07:19:32'),(31,8,1,'SECTION_5','completed',10,'2026-04-28 07:23:20','2026-04-28 07:14:32','2026-04-28 07:23:20'),(32,8,1,'SECTION_4','completed',10,'2026-04-28 07:21:58','2026-04-28 07:14:32','2026-04-28 07:21:58'),(33,8,1,'SECTION_3','completed',10,'2026-04-28 07:21:57','2026-04-28 07:14:32','2026-04-28 07:21:57'),(34,8,1,'FINAL_ASSESSMENT','completed',80,'2026-04-28 07:25:42','2026-04-28 07:25:42','2026-04-28 07:25:42'),(35,9,2,'SECTION_6','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:30','2026-04-30 07:54:31'),(36,9,2,'SECTION_11','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:31','2026-04-30 07:54:31'),(37,9,2,'SECTION_7','completed',10,'2026-04-30 07:54:41','2026-04-30 07:54:31','2026-04-30 07:54:41'),(38,9,2,'SECTION_8','completed',10,'2026-04-30 07:55:08','2026-04-30 07:54:31','2026-04-30 07:55:08'),(39,9,2,'SECTION_13','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:31','2026-04-30 07:54:31'),(40,9,2,'SECTION_14','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:31','2026-04-30 07:54:31'),(41,9,2,'SECTION_10','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:31','2026-04-30 07:54:31'),(42,9,2,'SECTION_15','completed',10,'2026-04-30 07:54:31','2026-04-30 07:54:31','2026-04-30 07:54:31'),(43,9,2,'SECTION_12','completed',10,'2026-04-30 07:59:58','2026-04-30 07:54:31','2026-04-30 07:59:58'),(44,9,2,'SECTION_9','completed',10,'2026-04-30 07:54:32','2026-04-30 07:54:32','2026-04-30 07:54:32'),(45,10,2,'SECTION_6','completed',10,'2026-04-30 10:55:16','2026-04-30 10:53:07','2026-04-30 10:55:16'),(46,10,2,'SECTION_7','completed',10,'2026-04-30 10:56:08','2026-04-30 10:53:09','2026-04-30 10:56:08'),(47,10,2,'SECTION_12','completed',10,'2026-04-30 11:01:33','2026-04-30 10:53:09','2026-04-30 11:01:33'),(48,10,2,'SECTION_11','completed',10,'2026-04-30 10:57:59','2026-04-30 10:53:10','2026-04-30 10:57:59'),(49,10,2,'SECTION_9','completed',10,'2026-04-30 10:57:56','2026-04-30 10:53:10','2026-04-30 10:57:56'),(50,10,2,'SECTION_10','completed',10,'2026-04-30 10:57:58','2026-04-30 10:53:10','2026-04-30 10:57:58'),(51,10,2,'SECTION_8','completed',10,'2026-04-30 10:57:49','2026-04-30 10:53:10','2026-04-30 10:57:49'),(52,10,2,'SECTION_14','completed',10,'2026-04-30 11:01:37','2026-04-30 10:53:10','2026-04-30 11:01:37'),(53,10,2,'SECTION_15','completed',10,'2026-04-30 11:01:39','2026-04-30 10:53:10','2026-04-30 11:01:39'),(54,10,2,'SECTION_13','completed',10,'2026-04-30 11:01:35','2026-04-30 10:53:10','2026-04-30 11:01:35'),(55,11,2,'SECTION_6','completed',10,'2026-04-30 10:58:33','2026-04-30 10:58:32','2026-04-30 10:58:33'),(56,11,2,'SECTION_11','completed',10,'2026-04-30 10:58:45','2026-04-30 10:58:34','2026-04-30 10:58:45'),(57,11,2,'SECTION_15','completed',10,'2026-04-30 11:00:14','2026-04-30 10:58:34','2026-04-30 11:00:14'),(58,11,2,'SECTION_9','completed',10,'2026-04-30 10:58:41','2026-04-30 10:58:34','2026-04-30 10:58:41'),(59,11,2,'SECTION_10','completed',10,'2026-04-30 10:58:43','2026-04-30 10:58:34','2026-04-30 10:58:43'),(60,11,2,'SECTION_8','completed',10,'2026-04-30 10:58:38','2026-04-30 10:58:34','2026-04-30 10:58:38'),(61,11,2,'SECTION_14','completed',10,'2026-04-30 11:00:11','2026-04-30 10:58:34','2026-04-30 11:00:11'),(62,11,2,'SECTION_7','completed',10,'2026-04-30 10:58:35','2026-04-30 10:58:34','2026-04-30 10:58:35'),(63,11,2,'SECTION_13','completed',10,'2026-04-30 11:00:09','2026-04-30 10:58:34','2026-04-30 11:00:09'),(64,11,2,'SECTION_12','completed',10,'2026-04-30 11:00:06','2026-04-30 10:58:34','2026-04-30 11:00:06'),(65,4,2,'SECTION_6','completed',10,'2026-05-23 15:55:23','2026-04-30 21:41:17','2026-05-23 15:55:23'),(66,15,2,'SECTION_6','completed',10,'2026-05-01 11:13:52','2026-05-01 11:13:51','2026-05-01 11:13:52'),(67,15,2,'SECTION_10','completed',10,'2026-05-01 11:30:10','2026-05-01 11:13:53','2026-05-01 11:30:10'),(68,15,2,'SECTION_9','completed',10,'2026-05-01 11:29:57','2026-05-01 11:13:53','2026-05-01 11:29:57'),(69,15,2,'SECTION_7','completed',10,'2026-05-01 11:29:40','2026-05-01 11:13:53','2026-05-01 11:29:40'),(70,15,2,'SECTION_8','completed',10,'2026-05-01 11:29:48','2026-05-01 11:13:53','2026-05-01 11:29:48'),(71,15,2,'SECTION_13','completed',10,'2026-05-01 11:34:21','2026-05-01 11:13:53','2026-05-01 11:34:21'),(72,15,2,'SECTION_15','completed',10,'2026-05-01 11:34:41','2026-05-01 11:13:53','2026-05-01 11:34:41'),(73,15,2,'SECTION_12','completed',10,'2026-05-01 11:34:10','2026-05-01 11:13:53','2026-05-01 11:34:10'),(74,15,2,'SECTION_11','completed',10,'2026-05-01 11:30:13','2026-05-01 11:13:53','2026-05-01 11:30:13'),(75,15,2,'SECTION_14','completed',10,'2026-05-01 11:34:26','2026-05-01 11:13:53','2026-05-01 11:34:26'),(76,17,1,'SECTION_1','completed',10,'2026-05-01 11:50:30','2026-05-01 11:50:29','2026-05-01 11:50:30'),(77,17,1,'SECTION_2','completed',10,'2026-05-01 11:50:32','2026-05-01 11:50:31','2026-05-01 11:50:32'),(78,17,1,'SECTION_4','completed',10,'2026-05-01 11:51:21','2026-05-01 11:50:31','2026-05-01 11:51:21'),(79,17,1,'SECTION_3','completed',10,'2026-05-01 11:50:34','2026-05-01 11:50:31','2026-05-01 11:50:34'),(80,17,1,'SECTION_5','completed',10,'2026-05-01 11:52:04','2026-05-01 11:50:31','2026-05-01 11:52:04'),(81,18,2,'SECTION_6','completed',10,'2026-05-01 12:03:05','2026-05-01 12:03:04','2026-05-01 12:03:05'),(82,18,2,'SECTION_10','completed',10,'2026-05-01 12:03:17','2026-05-01 12:03:05','2026-05-01 12:03:17'),(83,18,2,'SECTION_7','completed',10,'2026-05-01 12:03:09','2026-05-01 12:03:05','2026-05-01 12:03:09'),(84,18,2,'SECTION_11','completed',10,'2026-05-01 12:03:19','2026-05-01 12:03:05','2026-05-01 12:03:19'),(85,18,2,'SECTION_8','completed',10,'2026-05-01 12:03:12','2026-05-01 12:03:05','2026-05-01 12:03:12'),(86,18,2,'SECTION_15','completed',10,'2026-05-01 12:05:51','2026-05-01 12:03:05','2026-05-01 12:05:51'),(87,18,2,'SECTION_14','completed',10,'2026-05-01 12:05:49','2026-05-01 12:03:05','2026-05-01 12:05:49'),(88,18,2,'SECTION_13','completed',10,'2026-05-01 12:05:46','2026-05-01 12:03:05','2026-05-01 12:05:46'),(89,18,2,'SECTION_12','completed',10,'2026-05-01 12:05:44','2026-05-01 12:03:06','2026-05-01 12:05:44'),(90,18,2,'SECTION_9','completed',10,'2026-05-01 12:03:15','2026-05-01 12:03:06','2026-05-01 12:03:15'),(91,4,2,'SECTION_7','completed',10,'2026-05-23 15:55:20','2026-05-01 22:02:46','2026-05-23 15:55:20'),(92,4,2,'SECTION_8','completed',10,'2026-05-02 03:11:29','2026-05-02 03:11:29','2026-05-02 03:11:29'),(93,4,2,'SECTION_9','completed',10,'2026-05-02 03:11:31','2026-05-02 03:11:31','2026-05-02 03:11:31'),(94,4,2,'SECTION_12','completed',10,'2026-05-21 02:09:18','2026-05-02 03:11:49','2026-05-21 02:09:18'),(95,26,1,'SECTION_1','completed',10,'2026-05-04 13:26:06','2026-05-04 13:11:05','2026-05-04 13:26:06'),(96,27,2,'SECTION_6','completed',10,'2026-05-07 03:53:46','2026-05-07 03:44:57','2026-05-07 03:53:46'),(97,27,2,'SECTION_8','completed',10,'2026-05-07 03:47:37','2026-05-07 03:45:01','2026-05-07 03:47:37'),(98,27,2,'SECTION_7','completed',10,'2026-05-07 03:46:49','2026-05-07 03:45:02','2026-05-07 03:46:49'),(99,27,2,'SECTION_9','completed',10,'2026-05-07 03:47:39','2026-05-07 03:45:02','2026-05-07 03:47:39'),(100,27,2,'SECTION_15','completed',10,'2026-05-07 03:45:02','2026-05-07 03:45:02','2026-05-07 03:45:02'),(101,27,2,'SECTION_10','completed',10,'2026-05-07 03:47:43','2026-05-07 03:45:02','2026-05-07 03:47:43'),(102,27,2,'SECTION_14','completed',10,'2026-05-07 03:45:02','2026-05-07 03:45:02','2026-05-07 03:45:02'),(103,27,2,'SECTION_11','completed',10,'2026-05-07 03:47:46','2026-05-07 03:45:02','2026-05-07 03:47:46'),(104,27,2,'SECTION_13','completed',10,'2026-05-07 03:45:02','2026-05-07 03:45:02','2026-05-07 03:45:02'),(105,27,2,'SECTION_12','completed',10,'2026-05-07 03:48:57','2026-05-07 03:45:02','2026-05-07 03:48:57'),(106,28,1,'SECTION_1','completed',10,'2026-05-17 16:31:36','2026-05-08 14:57:13','2026-05-17 16:31:36'),(107,28,1,'SECTION_2','completed',10,'2026-05-17 15:16:08','2026-05-08 14:57:14','2026-05-17 15:16:08'),(108,28,1,'SECTION_4','completed',10,'2026-05-17 15:16:18','2026-05-08 14:57:15','2026-05-17 15:16:18'),(109,28,1,'SECTION_3','completed',10,'2026-05-17 15:16:11','2026-05-08 14:57:15','2026-05-17 15:16:11'),(110,28,1,'SECTION_5','completed',10,'2026-05-17 15:16:53','2026-05-08 14:57:15','2026-05-17 15:16:53'),(111,28,2,'SECTION_6','completed',10,'2026-05-17 15:06:35','2026-05-08 16:32:10','2026-05-17 15:06:35'),(112,28,2,'SECTION_7','completed',10,'2026-05-17 15:06:38','2026-05-08 16:32:13','2026-05-17 15:06:38'),(113,28,2,'SECTION_8','completed',10,'2026-05-17 15:06:40','2026-05-08 16:32:47','2026-05-17 15:06:40'),(114,28,2,'SECTION_9','completed',10,'2026-05-17 15:06:42','2026-05-08 16:32:50','2026-05-17 15:06:42'),(115,28,2,'SECTION_10','completed',10,'2026-05-17 15:06:44','2026-05-08 16:32:52','2026-05-17 15:06:44'),(116,28,2,'SECTION_11','completed',10,'2026-05-17 15:06:47','2026-05-08 16:32:54','2026-05-17 15:06:47'),(117,28,2,'SECTION_12','completed',10,'2026-05-17 15:06:58','2026-05-09 18:05:44','2026-05-17 15:06:58'),(118,28,2,'SECTION_13','completed',10,'2026-05-17 15:07:00','2026-05-09 18:05:47','2026-05-17 15:07:00'),(119,28,2,'SECTION_14','completed',10,'2026-05-17 15:07:56','2026-05-09 18:05:50','2026-05-17 15:07:56'),(120,28,2,'SECTION_15','completed',10,'2026-05-17 15:07:09','2026-05-09 18:05:52','2026-05-17 15:07:09'),(121,29,1,'SECTION_1','completed',10,'2026-05-11 04:18:43','2026-05-11 04:18:42','2026-05-11 04:18:43'),(122,29,1,'SECTION_3','completed',10,'2026-05-11 04:18:52','2026-05-11 04:18:44','2026-05-11 04:18:52'),(123,29,1,'SECTION_5','completed',10,'2026-05-11 04:20:24','2026-05-11 04:18:44','2026-05-11 04:20:24'),(124,29,1,'SECTION_2','completed',10,'2026-05-11 04:18:48','2026-05-11 04:18:44','2026-05-11 04:18:48'),(125,29,1,'SECTION_4','completed',10,'2026-05-11 04:19:29','2026-05-11 04:18:44','2026-05-11 04:19:29'),(126,1,2,'SECTION_6','completed',10,'2026-05-17 15:44:53','2026-05-12 12:46:49','2026-05-17 15:44:53'),(127,1,2,'SECTION_7','completed',10,'2026-05-16 01:31:55','2026-05-16 01:31:55','2026-05-16 01:31:55'),(128,1,2,'SECTION_8','completed',10,'2026-05-16 01:31:58','2026-05-16 01:31:58','2026-05-16 01:31:58'),(129,1,2,'SECTION_9','completed',10,'2026-05-16 01:32:00','2026-05-16 01:32:00','2026-05-16 01:32:00'),(130,1,2,'SECTION_10','completed',10,'2026-05-16 01:32:04','2026-05-16 01:32:04','2026-05-16 01:32:04'),(131,1,2,'SECTION_11','completed',10,'2026-05-16 02:01:58','2026-05-16 01:32:05','2026-05-16 02:01:58'),(132,30,2,'SECTION_6','completed',10,'2026-05-20 17:46:22','2026-05-17 14:55:33','2026-05-20 17:46:22'),(133,30,1,'SECTION_1','completed',10,'2026-05-17 14:58:16','2026-05-17 14:55:51','2026-05-17 14:58:16'),(134,30,1,'SECTION_2','completed',10,'2026-05-17 14:58:18','2026-05-17 14:55:52','2026-05-17 14:58:18'),(135,30,1,'SECTION_3','completed',10,'2026-05-17 14:58:20','2026-05-17 14:55:52','2026-05-17 14:58:20'),(136,30,1,'SECTION_4','completed',10,'2026-05-17 14:58:54','2026-05-17 14:55:52','2026-05-17 14:58:54'),(137,30,1,'SECTION_5','completed',10,'2026-05-17 14:59:21','2026-05-17 14:55:52','2026-05-17 14:59:21'),(138,28,1,'FINAL_ASSESSMENT','completed',80,'2026-05-17 16:30:26','2026-05-17 15:29:46','2026-05-17 16:30:26'),(139,31,1,'SECTION_1','completed',10,'2026-05-17 16:33:24','2026-05-17 16:33:12','2026-05-17 16:33:24'),(140,30,2,'SECTION_7','completed',10,'2026-05-20 17:46:23','2026-05-20 17:46:23','2026-05-20 17:46:23'),(141,30,2,'SECTION_8','completed',10,'2026-05-20 17:46:25','2026-05-20 17:46:25','2026-05-20 17:46:25'),(142,13,2,'SECTION_6','completed',10,'2026-05-20 21:43:33','2026-05-20 21:43:28','2026-05-20 21:43:33'),(143,13,2,'SECTION_7','completed',10,'2026-05-20 21:43:38','2026-05-20 21:43:38','2026-05-20 21:43:38'),(144,13,2,'SECTION_8','completed',10,'2026-05-20 21:43:43','2026-05-20 21:43:43','2026-05-20 21:43:43'),(145,13,2,'SECTION_9','completed',10,'2026-05-20 21:43:45','2026-05-20 21:43:45','2026-05-20 21:43:45'),(146,13,1,'SECTION_1','completed',10,'2026-05-20 21:56:02','2026-05-20 21:45:15','2026-05-20 21:56:02'),(147,13,1,'SECTION_2','completed',10,'2026-05-20 21:45:19','2026-05-20 21:45:19','2026-05-20 21:45:19'),(148,13,1,'SECTION_3','completed',10,'2026-05-20 21:58:53','2026-05-20 21:45:22','2026-05-20 21:58:53'),(149,4,2,'SECTION_13','completed',10,'2026-05-21 02:09:23','2026-05-21 02:09:23','2026-05-21 02:09:23');
/*!40000 ALTER TABLE `userprogress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `userPass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `authenticated` tinyint(1) NOT NULL DEFAULT '0',
  `reset_request` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `users_email_unique` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Olivia Geema','geemaolivia@gmail.com','0198355025',NULL,'$2y$12$otBjFyHfVQGMzmQ4kcVx1emfDkF77niNIUvLC2FDHGymhvWkG/s/C',1,NULL,'2026-04-23 00:46:28','2026-05-21 02:03:10',0,0),(2,'Berniedate Mercy','mercyberniedate@gmail.com','0137832077',NULL,'$2y$12$T0SVDF.GPjPX/KeaKmRCG./mxYtcE6g/pQjseYd1as/fU69PFQUFi',0,NULL,'2026-04-23 02:08:19','2026-04-23 02:08:25',0,0),(3,'Nurul Fatihah','nrlfthh18@gmail.com','0143049034',NULL,'$2y$12$ObgWwCtKoI2D2RYTnva01.qEl/bTE4nNUt68dN5HPcGJ7aXiZdhWK',0,NULL,'2026-04-23 12:21:08','2026-04-23 12:21:39',0,0),(4,'Elmer Dana Anak Bori','elmer9429@yahoo.com','01125003217',NULL,'$2y$12$5NO9L3AsTPGZsjV68u4EV.7LhRTfq.qOzPpoSkPX91fxfZEkHZ6Ym',0,NULL,'2026-04-23 16:32:47','2026-05-01 19:35:10',0,0),(5,'Chad Lesley','chadvillarinlesley@gmail.com','0163131484',NULL,'$2y$12$P74SWlsxfW.YlUYYS30muOxZ9SEKv2v7S6kVbb6s2VFJXKSdWATLO',0,NULL,'2026-04-28 05:18:36','2026-04-28 05:18:56',0,0),(6,'Arabella Shayna Anak Gabriel','arabella.gabriel2006@gmail.com','01111786606',NULL,'$2y$12$YKGngOlJFVoBVbb/jMTXwO8o/mnDjJnpZAg.PiIa/ce/ht8aFhOh2',0,'WPlbqZfTuQRbLg2NOprLxO2T0f1v68SinLAzeUQdmaBtvuVtLVHk75xkMcOJ','2026-04-28 05:53:19','2026-04-28 05:53:19',1,0),(7,'Belle','bellearen07@gmail.com','01131720773',NULL,'$2y$12$rVVEw70CIXynP4SKxfkXluxwgps9ZmtJ3LUoqNyaYTAFzN.JPHoFm',0,'8GL37cXTxBIj2Icc6gcbUkvny5ybhSinj18kZd5HlIM8WUwgLK2fHKeX6u7p','2026-04-28 06:18:00','2026-04-28 06:18:00',1,0),(8,'Jay','iminvisible5@gmail.com','0138697821',NULL,'$2y$12$segp0fes23x1cH6UOFFNBemXuVtzTEOcNRvdb/5kTXKsHrByzEBvm',0,NULL,'2026-04-28 07:08:23','2026-04-28 07:11:19',0,0),(9,'MOHD ZULFIKAR BIN IDERIS','mohdzulfikar65@gmail.com','0135607061',NULL,'$2y$12$.Nuad7FAI2CQrTwH5oBSQucMUtWfFWc.wWdkZlfPxHVIXIVPyx56q',0,NULL,'2026-04-30 07:52:13','2026-04-30 07:52:41',0,0),(10,'Veronica anak Guang','veronica_guang_bn22@iluv.ums.edu.my','0194804211',NULL,'$2y$12$avSocIlBFGwunnF174fi/Op5r8RoZDIPfshQM4LsiWEaNckDXsKVG',0,NULL,'2026-04-30 10:52:24','2026-04-30 10:52:36',0,0),(11,'Felicia','feliciaanakguang@gmail.com','0138209242',NULL,'$2y$12$fcWhSr2BEnSi3GzO6.G6ZOWqiblVY3VO5SMKJMzsawFWB5Jfba92y',0,NULL,'2026-04-30 10:57:48','2026-04-30 10:58:13',0,0),(12,'Jaes Anak Rames','odettiajaes@gmail.com','0138045248',NULL,'$2y$12$W1vPB2CJN9C7FsNDjRf.BOSmHQIYdyTvjZmiDnQR4Ksg3npS0TI.i',0,NULL,'2026-04-30 16:10:43','2026-05-02 22:36:48',0,0),(13,'Delin Philip','delinphilip2017@gmail.com','0198145248',NULL,'$2y$12$dOo3CHLBrFx6eKMK6GBAZuMdjlO709o8x93L.TtvvdzmAviCNmLLm',0,NULL,'2026-05-01 10:56:46','2026-05-02 22:39:39',0,0),(14,'Avie Anak Bori','avievie25@gmail.com','0168850151',NULL,'$2y$12$O08BW01kXxtoijqBO3lR6e7nY8g4TTSCD3VQM6RJ4nRZ10v5foY4q',0,NULL,'2026-05-01 11:00:56','2026-05-01 11:00:56',1,0),(15,'Nur Syaqira Binti Bolhassan','nursyaqirabolhassan@gmail.com','01131816977',NULL,'$2y$12$Ax2LFgmTME3KIkGW/fnWC.m5IjCtJ5qay3vHOBWTXtEQ29vfIAq/.',0,NULL,'2026-05-01 11:08:57','2026-05-01 11:09:15',0,0),(16,'Ezjannie Arsat Bin Abdullah','janniey0@gmail.com','01119104546',NULL,'$2y$12$eiKYSFOmwYDFcGHR0zHoWeRtawoVGKQxRBaka2n4PxquArZZYVxgG',0,NULL,'2026-05-01 11:14:57','2026-05-01 11:15:01',0,0),(17,'Elda Elliana','eldaelliana@gmail.com','0149074963',NULL,'$2y$12$98JngtToB3IV0h4b5nLfu.owkrMZiniS.jF9Cfl62Yt9jE9ny0YoC',0,NULL,'2026-05-01 11:48:22','2026-05-01 11:48:27',0,0),(18,'Aniq Bin Damiri','aniqdarwish2@gmail.com','0142056635',NULL,'$2y$12$do//Q8imr3Y/odK58FJqF.eoWbUpEaFCjIhQdyAPmzl99oCjgbONe',0,NULL,'2026-05-01 12:02:00','2026-05-01 12:02:05',0,0),(19,'Andrew sanggin ak nyalang','andrewsanggin9@gmail.com','01119273247',NULL,'$2y$12$wBkIrPh3hQLWveca6jHilOeBtT49Y5E1HSHstxuYV7DEuxL7mmE5K',0,NULL,'2026-05-01 12:09:18','2026-05-01 12:09:18',1,0),(20,'codylia blue charles','codyliacody24@gmail.com','0178059612',NULL,'$2y$12$3EN5m3OeInHtBn88XgJ4ceFSdgdOttYauGjCXgpo/HJjwIPCQn/BG',0,NULL,'2026-05-01 12:10:38','2026-05-01 12:10:38',1,0),(21,'PHILIP SENG ANAK UBAM','philipseng344@gmail.com','0135827915',NULL,'$2y$12$ODLGJwiwzaZbR8expv4C1uv.ur3wJ7AHO4cmMMqK5R.9HjUdvz2km',0,NULL,'2026-05-01 12:12:12','2026-05-01 12:12:12',1,0),(22,'jubin ak baling','jubin1811@gmail.com','0178059613',NULL,'$2y$12$uSmX3NepKvm9gFLCYa.zvuDcbK1dNPeOE7yKfrD9wd62Vv8ir1SX.',0,NULL,'2026-05-01 12:14:23','2026-05-01 12:14:23',1,0),(23,'BOBBYPIAN ANAK UNTANG','bobbypianwan97@icloud.com','0128765067',NULL,'$2y$12$pZLJBx1LbyijCc3FBzE4pevFM/NMmPgv7WDIiCt3FKdYa8TM8foLC',0,NULL,'2026-05-01 12:18:30','2026-05-01 12:18:30',1,0),(24,'Gordon Anak Henry','gordonseny337@gmail.com','01140055080',NULL,'$2y$12$CLtOWEN11fmM5RIl9PIGG.JzXnSywGVGZenOw2cryLLbS/ngu2MOO',0,NULL,'2026-05-01 12:37:17','2026-05-01 12:37:17',1,0),(25,'Hilda Jelembai','hildajelembai.hj@gmail.com','0168504083',NULL,'$2y$12$dxn.52mYUM3I1T4YOYUg0e05qjsSNll56fvFPiUsldq01nTpdoQRi',0,NULL,'2026-05-01 12:58:35','2026-05-01 12:58:43',0,0),(26,'Tehah','nrlfthh17@gmail.com','0146944863',NULL,'$2y$12$F.SwqQEXKWNFDOn8/Eq13ODNBLQ2yEnokUhY3bQkNCL/CR.2kaWqO',0,NULL,'2026-05-04 13:10:47','2026-05-04 13:10:57',0,0),(27,'Ivan','ivanisaac20@gmail.com','0165879724',NULL,'$2y$12$uSflJu3S2CgatTJVk3myUOK1WSWg3S6GespO80N90Qt9biB/.LRYa',0,NULL,'2026-05-05 15:54:15','2026-05-14 16:35:11',0,0),(28,'Unaisa Aniqa','nurunaisaaniqa@gmail.com','0134011604',NULL,'$2y$12$aBzkgRZSdrpKuNj71/vEXubiGmnbN8ztz7oyXSckpXsUSBeh.4P3K',0,NULL,'2026-05-08 14:50:29','2026-05-08 14:50:37',0,0),(29,'Nathalie Richard Rockie','n80rock3@gmail.com','1129999973',NULL,'$2y$12$6dkL6OzFD9/w8CkPFbSC5evD0VRcnXMVXMsOB27ObsdOzqMkEo.h2',0,NULL,'2026-05-11 04:16:51','2026-05-11 04:17:33',0,0),(30,'Syazayani','jsyazayani03@gmail.com','0143909613',NULL,'$2y$12$tTqzcPJ2yZmNCu0VrjsWVuuU/DpD1IXoB3tALHcALcOKRgvzz7nWe',0,NULL,'2026-05-12 13:00:29','2026-05-12 13:00:37',0,0),(31,'Mia','mia123@gmail.com','012567892',NULL,'$2y$12$ZjDmWa1ayyth/taYBLCMq.V6osRAYNYbvmg4DioY2aaV1ipvBw/zi',0,NULL,'2026-05-17 16:32:43','2026-05-17 16:32:57',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videolearning`
--

DROP TABLE IF EXISTS `videolearning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videolearning` (
  `videoLearningID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `learningMaterialID` bigint unsigned NOT NULL,
  `videoLearningName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `videoLearningPath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `videoLearningDesc` text COLLATE utf8mb4_unicode_ci,
  `videoLearningDuration` int NOT NULL,
  `videoLearningResolution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`videoLearningID`),
  KEY `videolearning_learningmaterialid_foreign` (`learningMaterialID`),
  CONSTRAINT `videolearning_learningmaterialid_foreign` FOREIGN KEY (`learningMaterialID`) REFERENCES `learningmaterials` (`learningMaterialID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videolearning`
--

LOCK TABLES `videolearning` WRITE;
/*!40000 ALTER TABLE `videolearning` DISABLE KEYS */;
/*!40000 ALTER TABLE `videolearning` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'railway'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-26 22:47:24
