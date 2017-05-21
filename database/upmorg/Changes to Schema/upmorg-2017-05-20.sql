-- MySQL dump 10.13  Distrib 5.7.13, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: upmorg
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AvailabilityGroup`
--

DROP TABLE IF EXISTS `AvailabilityGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AvailabilityGroup` (
  `AvailabilityGroupID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FrontmanID` int(10) unsigned NOT NULL,
  `GroupName` varchar(50) NOT NULL,
  PRIMARY KEY (`AvailabilityGroupID`),
  KEY `FK_AvailabilityGroup_FrontmanID` (`FrontmanID`),
  CONSTRAINT `FK_AvailabilityGroup_FrontmanID` FOREIGN KEY (`FrontmanID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityGroup`
--

LOCK TABLES `AvailabilityGroup` WRITE;
/*!40000 ALTER TABLE `AvailabilityGroup` DISABLE KEYS */;
INSERT INTO `AvailabilityGroup` VALUES (20,91,'Sample'),(21,94,'Helloo');
/*!40000 ALTER TABLE `AvailabilityGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AvailabilityGroupMember`
--

DROP TABLE IF EXISTS `AvailabilityGroupMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AvailabilityGroupMember` (
  `AvailabilityGroupMemberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AvailabilityMemberID` int(10) unsigned NOT NULL,
  `AvailabilityGroupID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`AvailabilityGroupMemberID`),
  KEY `FK_AvailabilityGroupMember_AvailabilityGroupID` (`AvailabilityGroupID`),
  KEY `FK_AvailabilityGroupMember_AvailabilityMemberID` (`AvailabilityMemberID`),
  CONSTRAINT `FK_AvailabilityGroupMember_AvailabilityGroupID` FOREIGN KEY (`AvailabilityGroupID`) REFERENCES `AvailabilityGroup` (`AvailabilityGroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AvailabilityGroupMember_AvailabilityMemberID` FOREIGN KEY (`AvailabilityMemberID`) REFERENCES `AvailabilityMember` (`AvailabilityMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityGroupMember`
--

LOCK TABLES `AvailabilityGroupMember` WRITE;
/*!40000 ALTER TABLE `AvailabilityGroupMember` DISABLE KEYS */;
INSERT INTO `AvailabilityGroupMember` VALUES (19,27,20),(20,28,20),(21,24,20);
/*!40000 ALTER TABLE `AvailabilityGroupMember` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AvailabilityMember`
--

DROP TABLE IF EXISTS `AvailabilityMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AvailabilityMember` (
  `AvailabilityMemberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BatchMemberID` int(10) unsigned NOT NULL,
  `MondayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `TuesdayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `WednesdayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `ThursdayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `FridayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `SaturdayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  `SundayVector` char(48) NOT NULL DEFAULT '000000000000000000000000000000000000000000000000',
  PRIMARY KEY (`AvailabilityMemberID`),
  KEY `FK_AvailabilityMember_BatchMemberID` (`BatchMemberID`),
  CONSTRAINT `FK_AvailabilityMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityMember`
--

LOCK TABLES `AvailabilityMember` WRITE;
/*!40000 ALTER TABLE `AvailabilityMember` DISABLE KEYS */;
INSERT INTO `AvailabilityMember` VALUES (24,91,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(27,94,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(28,95,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(29,96,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(30,97,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(36,103,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(37,104,'000000000000000000111111000000111100000000000000','000000000000000001110000000000001100000000000000','000000000000000001111111111111111100000000000000','000000000000000000000011110000000000000000000000','000000000000000000000000000111111100000000000000','000000000000000001111111111111111100000000000000','000000000000000001111111111111111100000000000000'),(38,105,'000000000000000000000000000011111111111111111111','000000000000000001111110000011111111111111110000','000000000000000000001111111111111110000011111111','000000000000000011111111111111111000000011111111','000000000000000000000001111111111001110000111111','000000000000000011111000000000000000011111111111','000000000000000001111111111111111111111111110000'),(39,106,'000000000011111111111111000000000111111111111111','000000000000000000000000000000001111111111111111','000000000000000000001111111111111110000011111111','000000000000011111111111111111111100000011111111','000000000000000000000000000000000011111111111111','111111111111111111111111111111111111111111111111','000000000000000000000000001111111111000011111111'),(41,108,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(42,109,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000'),(43,110,'000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000','000000000000000000000000000000000000000000000000');
/*!40000 ALTER TABLE `AvailabilityMember` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Batch`
--

DROP TABLE IF EXISTS `Batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Batch` (
  `BatchID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AcadYear` char(9) NOT NULL,
  PRIMARY KEY (`BatchID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Batch`
--

LOCK TABLES `Batch` WRITE;
/*!40000 ALTER TABLE `Batch` DISABLE KEYS */;
INSERT INTO `Batch` VALUES (2,'2017-2018'),(3,'2018-2019'),(5,'2019-2020');
/*!40000 ALTER TABLE `Batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BatchMember`
--

DROP TABLE IF EXISTS `BatchMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BatchMember` (
  `BatchMemberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BatchID` int(10) unsigned NOT NULL,
  `MemberID` int(10) unsigned NOT NULL,
  `MemberTypeID` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`BatchMemberID`),
  KEY `FK_BatchMember_BatchID` (`BatchID`),
  KEY `FK_BatchMember_MemberID` (`MemberID`),
  KEY `FK_BatchMember_MemberTypeID` (`MemberTypeID`),
  CONSTRAINT `FK_BatchMember_BatchID` FOREIGN KEY (`BatchID`) REFERENCES `Batch` (`BatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_BatchMember_MemberID` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_BatchMember_MemberTypeID` FOREIGN KEY (`MemberTypeID`) REFERENCES `MemberType` (`MemberTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BatchMember`
--

LOCK TABLES `BatchMember` WRITE;
/*!40000 ALTER TABLE `BatchMember` DISABLE KEYS */;
INSERT INTO `BatchMember` VALUES (91,2,1,1),(94,2,2,2),(95,2,3,3),(96,2,4,4),(97,2,5,5),(103,2,11,5),(104,2,38,5),(105,2,40,4),(106,2,39,5),(108,3,1,1),(109,3,4,4),(110,3,11,0);
/*!40000 ALTER TABLE `BatchMember` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Committee`
--

DROP TABLE IF EXISTS `Committee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Committee` (
  `CommitteeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CommitteeName` varchar(50) NOT NULL,
  PRIMARY KEY (`CommitteeID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Committee`
--

LOCK TABLES `Committee` WRITE;
/*!40000 ALTER TABLE `Committee` DISABLE KEYS */;
INSERT INTO `Committee` VALUES (1,'Documentation'),(2,'Production'),(3,'Logistics'),(4,'Sponsorships'),(5,'Creatives'),(6,'Information Dissemination'),(7,'Finance');
/*!40000 ALTER TABLE `Committee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CommitteeMember`
--

DROP TABLE IF EXISTS `CommitteeMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommitteeMember` (
  `CommitteeMemberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BatchMemberID` int(10) unsigned NOT NULL,
  `CommitteeID` int(10) unsigned NOT NULL,
  `IsApproved` tinyint(1) NOT NULL,
  PRIMARY KEY (`CommitteeMemberID`),
  UNIQUE KEY `BatchMemberID` (`BatchMemberID`),
  KEY `FK_CommitteeMember_CommiteeID` (`CommitteeID`),
  CONSTRAINT `FK_CommitteeMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CommitteeMember_CommiteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `Committee` (`CommitteeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommitteeMember`
--

LOCK TABLES `CommitteeMember` WRITE;
/*!40000 ALTER TABLE `CommitteeMember` DISABLE KEYS */;
INSERT INTO `CommitteeMember` VALUES (144,96,7,1),(145,97,1,1),(146,103,7,1),(147,104,2,1),(148,106,2,1),(149,105,2,1),(150,109,7,1),(151,110,7,0);
/*!40000 ALTER TABLE `CommitteeMember` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CommitteePermission`
--

DROP TABLE IF EXISTS `CommitteePermission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommitteePermission` (
  `CommitteePermissionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BatchID` int(10) unsigned NOT NULL,
  `MemberTypeID` int(10) unsigned NOT NULL,
  `CommitteeID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`CommitteePermissionID`),
  KEY `FK_CommitteePermission_MemberTypeID` (`MemberTypeID`),
  KEY `FK_CommitteePermission_CommiteeID` (`CommitteeID`),
  KEY `FK_CommitteePermission_BatchID` (`BatchID`),
  CONSTRAINT `FK_CommitteePermission_BatchID` FOREIGN KEY (`BatchID`) REFERENCES `Batch` (`BatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CommitteePermission_CommitteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `Committee` (`CommitteeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CommitteePermission_MemberTypeID` FOREIGN KEY (`MemberTypeID`) REFERENCES `MemberType` (`MemberTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommitteePermission`
--

LOCK TABLES `CommitteePermission` WRITE;
/*!40000 ALTER TABLE `CommitteePermission` DISABLE KEYS */;
INSERT INTO `CommitteePermission` VALUES (66,2,1,1),(67,2,1,2),(68,2,1,3),(69,2,1,4),(70,2,1,5),(71,2,1,6),(72,2,1,7),(73,2,2,1),(74,2,2,2),(75,2,2,3),(76,2,3,4),(77,2,3,5),(78,2,3,6),(79,3,1,1),(80,3,1,2),(81,3,1,3),(82,3,1,4),(83,3,1,5),(84,3,1,6),(85,3,1,7),(86,3,2,1),(87,3,2,2),(88,3,2,3),(89,3,3,4),(90,3,3,5),(91,3,3,6),(105,5,1,1),(106,5,1,2),(107,5,1,3),(108,5,1,4),(109,5,1,5),(110,5,1,6),(111,5,1,7),(112,5,2,1),(113,5,2,2),(114,5,2,3),(115,5,3,4),(116,5,3,5),(117,5,3,6);
/*!40000 ALTER TABLE `CommitteePermission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `EventID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EventOwner` int(10) unsigned NOT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` varchar(511) NOT NULL,
  `EventStartDate` date NOT NULL,
  `EventEndDate` date DEFAULT NULL,
  `EventStartTime` time DEFAULT NULL,
  `EventEndTime` time DEFAULT NULL,
  `EventImage` varchar(255) DEFAULT NULL,
  `IsPublic` tinyint(1) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`EventID`),
  KEY `FK_Event_EventOwner` (`EventOwner`),
  CONSTRAINT `FK_Event_EventOwner` FOREIGN KEY (`EventOwner`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event`
--

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
INSERT INTO `Event` VALUES (11,91,'Sample Event','The party of the century!!','2017-08-01','2017-08-03','18:00:00','03:00:00',NULL,1,'2017-05-20 05:18:52'),(12,105,'June 2018 MOrg Event','Details to follow.','2018-06-16','2018-06-17','19:00:00','02:00:00',NULL,1,'2017-05-20 09:49:13');
/*!40000 ALTER TABLE `Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LedgerInput`
--

DROP TABLE IF EXISTS `LedgerInput`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LedgerInput` (
  `LedgerInputID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BatchMemberID` int(10) unsigned DEFAULT NULL,
  `Amount` float unsigned NOT NULL,
  `IsDebit` varchar(6) NOT NULL,
  `IsVerified` tinyint(1) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`LedgerInputID`),
  KEY `FK_LedgerInput_BatchMemberID` (`BatchMemberID`),
  CONSTRAINT `FK_LedgerInput_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LedgerInput`
--

LOCK TABLES `LedgerInput` WRITE;
/*!40000 ALTER TABLE `LedgerInput` DISABLE KEYS */;
INSERT INTO `LedgerInput` VALUES (4,96,1000,'1',1,'No','2017-05-20 08:00:50'),(5,103,100,'0',1,'Yes man','2017-05-20 08:01:33'),(6,96,100,'0',1,'Unrecorded credit!!','2017-05-20 10:14:50');
/*!40000 ALTER TABLE `LedgerInput` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Member`
--

DROP TABLE IF EXISTS `Member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Member` (
  `MemberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `PhoneNumber` varchar(50) DEFAULT NULL,
  `Password` varchar(60) NOT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Member`
--

LOCK TABLES `Member` WRITE;
/*!40000 ALTER TABLE `Member` DISABLE KEYS */;
INSERT INTO `Member` VALUES (1,'Jami','','Mendoza','firstfront@upmorg.com','123','$2y$10$JlxCMzROB/xMYXWxqP/gXuqPxwMn2K4QlwCZqL5U7J5nzg9j8Fnmm'),(2,'Jam Benneth','','Wong','secondfront@upmorg.com','123','$2y$10$2YGnSbnJ3QNo4wFeO0iQh.63DsFEOIw9DfhuFNsQJG3gnYGdi.bdq'),(3,'Paolo Mikhail','Pascua','Buted','thirdfront@upmorg.com','123','$2y$10$WZHeSHMiLGjgtjvyIVqp9eGdduMdut0ZMJIXxxVG583z/nOd7ITOe'),(4,'Finance','','Head','financehead@upmorg.com','123','$2y$10$0kFn6/4A8JSS17ahf.WtYuC5yIwAMngNqjHHpuI2Ej/21H3U7GgZ.'),(5,'Documentation','','Head','docuhead@upmorg.com','123','$2y$10$.4h9eyzH3vmyrA2QxMUs..BGIkxDmYac.nBtJO/uziu5gywTR/MzW'),(6,'Production','','Head','prodhead@upmorg.com','123','$2y$10$u9iRIFuAZFyYur8usmltbeefjFmyhmysu/sKVMLxC2ir2MyN5RtMy'),(7,'Logistics','','Head','loghead@upmorg.com','123','$2y$10$1ppKG/F6C15tSytbsEZri.qjjfFCv0DP7F.7Pb/aI0szJA4P79BwW'),(8,'Sponsorship','','Head','sponsorshiphead@upmorg.com','123','$2y$10$.s9huH61JocGgWr7Ced18u.Qoiwp6YFqZQaKqPso9VzsK/MSn3GPC'),(9,'Creatives','','Head','creativeshead@upmorg.com','123','$2y$10$x48okyu726XXt9pdNlcaIeAgeFJie6XJSJOxMWH.B1GyTksBzg9i2'),(10,'Information','Dissemination','Head','infodisshead@upmorg.com','123','$2y$10$7POBsIMbwDiZU4zqMMe17.9T3MKqMJlEuI4Fxpig6WGSfK6jeJ3Uu'),(11,'Monica','Geller','Bing','monicabing@upmorg.com','12345','$2y$10$EpugDdfroFvyxDT9KsJYC.vO8FlE4PkoSOTaTvc6xfBUeLbg8gb6.'),(12,'Ross','Eustace','Geller','rossgeller@upmorg.com','12345','$2y$10$0/XEB18J01/FhegqW..80ez8AevTMTw5nw6.mRy/u4sr5mPA4Rw0u'),(13,'Phoebe','','Buffay','phoebebuffay@upmorg.com','12345','$2y$10$BHrbNrFznBYLFE3yP4ZjaeX4Cp2N00BqFSRZKVExNe8eMbIbjEZtG'),(14,'Rachel','Karen','Green','rachelgreen@upmorg.com','12345','$2y$10$ktRiOcO.QnymRBjyYgmZzuk7jhP0JjWUWJXBqn7w32fVbI11GFRj.'),(15,'Joseph','Francis','Tribbiani Jr.','joeytribbiani@upmorg.com','12345','$2y$10$b5J3BzBdqNac6wggjn4IC.4uNcUinUI.m7K.dJZ1pU1.97ZPj9Sry'),(16,'Chandler','Muriel','Bing','chandlerbing@upmorg.com','12345','$2y$10$rjNbri/qYouI.BSXYfOKrOWEdugRehohU9YxJh.mZwEBwXh0Sc7CO'),(17,'Theodore','Evelyn','Mosby','tedmosby@upmorg.com','3456','$2y$10$gFfKpaQP446F9s31.3jSlOD0GCyNvFiFPa0UYJ.hslZWgJlFbbTYu'),(18,'Marshall','','Eriksen','marshalleriksen@upmorg.com','3456','$2y$10$r8hbm2O7RbNrF9eVcsfHSumiDUs/UlMIcO2L77AKWpp/F5aDSWXsO'),(19,'Lily','Aldrin','Eriksen','lilyeriksen@upmorg.com','3456','$2y$10$e4Jr.8IPbXkuF5QLAP2yJeJlo.en1Mn6WRpuG1PBiDPVCUfGOFZGu'),(20,'Robin','Charles','Scherbatsky Jr.','robinscherbatsky@upmorg.com','3456','$2y$10$cwUo9UGKNi3iVuGrV1QwauxvaQFBACuA8v55bSAx6Wbe9cv3eebPK'),(21,'Barnabus','','Stinson','barneystinson@upmorg.com','3456','$2y$10$vClzbWNYbN5zxGSKDKno5OYRgU1sqrz8r2FhoLAd9cSJZJtI51kaa'),(22,'Tracy','McConnell','Mosby','tracymosby@upmorg.com','3456','$2y$10$CxJmKM7QdTcoZM3D/KPOBOhTJWcrcIEW8SzQvI8AvZiT2zFjIj9Uu'),(23,'Jackie','Beulah','Burkhart','jackieburkhart@upmorg.com','70','$2y$10$K1Gtz8shlD9fIOep3C.Qq.CglLxZPqNR9Pi/uL6o7kXAFnfRm4USW'),(24,'Steven','','Hyde','stevenhyde@upmorg.com','70','$2y$10$GYjm2U2SsmD9mDh5G6DoKeg1eRlWBnaHRCcoKzxNbcZicJRZMM62G'),(25,'Donna','','Pinciotti','donnapinciotti@upmorg.com','70','$2y$10$2XgvSbD6V2lfAtr5LIKWeO5qIHCcTEHAUHdQb.QepIPRwALhfghYy'),(26,'Foreign','Exchange','Student','fez@upmorg.com','70','$2y$10$dzz5cRG0JMla8wLD/2eFo.ucpx1Z5PpS6N3RM8n5.KpZxqNcxSK8C'),(27,'Michael','Christopher','Kelso','michaelkelso@upmorg.com','70','$2y$10$tNSYPiPcpT.GWKUvNiKHYeVvwf9Wf1fGJu0YaPgvwUz7eQM3JxihK'),(28,'Eric','Albert','Forman','ericforman@upmorg.com','70',''),(29,'Ronald','Ulysses','Swanson','ronswanson@upmorg.com','999999','$2y$10$crm5QB29WMyAvshTm397A.cmEHxx0UJiqjIC026pvLsE52gesBcDq'),(30,'Leslie','Barbara','Knope','leslieknope@upmorg.com','999999','$2y$10$ipQOq8X6C0vUgOZEwOWlbe3Hau9.BrI9RPQKhQaHnxnVhIfHhSXJi'),(31,'Andrew','Maxwell','Dwyer','andydwyer@upmorg.com','999999','$2y$10$omWXtBk7vxDLnRyLAAOMH.nN7ltqLYn.PRwZHimkeGCLiYT7eEV8O'),(32,'April','Roberta','Ludgate-Dwyer','aprilludgate@upmorg.com','999999','$2y$10$ewEau0.NWnsKRBV3vJglQexvHj6k69gp3gOZx33czJqQr8uE6RSLi'),(33,'Thomas','Montgomery','Haverford','tomhaverford@upmorg.com','999999','$2y$10$KpQfjA0fk3gK3LAqPEuaOOPm6lh4SJimGkoAN7KJ6fzEvdxOPhieC'),(34,'Ann','Meredith','Perkins','annperkins@upmorg.com','999999','$2y$10$wkYZOXejexamRwa3Ujp51Ozd748qV/pn2J6aET0YZdc2XJRXmSDuG'),(36,'Jeshurun','Cedillo','Orquina','jeshorquina@yahoo.com','09123456789','$2y$10$AX7aca2lIVXx39Wi.vvqS.K/yMuZcznhn4N3eVJicX1p5SAwmkyfq'),(37,'Stephen Johann ','','Manuel','stephen@upmorg.com','911','$2y$10$lW26Q7jxxohKfTcjsWpx0ORkhb6P70hOQGFRc.7/71aEGXDgOLpDu'),(38,'Hayley','Nichole','Williams','hayleywilliams@paramore.com','0000000017','$2y$10$rr8U0gipdExyMi85PZyn4.UIb0rkf7bGqDd10zFJ7mweV8/X4jIn6'),(39,'Taylor','Benjamin','York','tayloryork@paramore.com','00000019','$2y$10$UhT3yC4Li7XAwuqn7.xsKOASBk0T08ZTn/cMVh7yxUDBTWh.7g5e2'),(40,'Zachary','Wayne','Farro','zacfarro@paramore.com','00000018','$2y$10$ft1GfqVxExr7mRN47tfDdOTz29OQlfqcZv/tdGp.BV0vpV3r.pxDO');
/*!40000 ALTER TABLE `Member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MemberType`
--

DROP TABLE IF EXISTS `MemberType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MemberType` (
  `MemberTypeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MemberType` varchar(50) NOT NULL,
  PRIMARY KEY (`MemberTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MemberType`
--

LOCK TABLES `MemberType` WRITE;
/*!40000 ALTER TABLE `MemberType` DISABLE KEYS */;
INSERT INTO `MemberType` VALUES (0,'Unassigned'),(1,'First Frontman'),(2,'Second Frontman'),(3,'Third Frontman'),(4,'Committee Head'),(5,'Committee Member');
/*!40000 ALTER TABLE `MemberType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StaticData`
--

DROP TABLE IF EXISTS `StaticData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StaticData` (
  `StaticDataID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Value` varchar(255) NOT NULL,
  PRIMARY KEY (`StaticDataID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticData`
--

LOCK TABLES `StaticData` WRITE;
/*!40000 ALTER TABLE `StaticData` DISABLE KEYS */;
INSERT INTO `StaticData` VALUES (1,'SystemAdminPassword','$2y$10$qT21DrQPiJ1Yc11nwRgZXe8YQCPZ.v6hOIkh15G/gL73W0uUHE/8m'),(2,'VerifiedBalance','0'),(3,'CurrentBatch','3'),(4,'IsLedgerActivated','0'),(5,'IsLedgerOpen','1'),(6,'AcadYearStartMonth','08'),(7,'AcadYearEndMonth','06');
/*!40000 ALTER TABLE `StaticData` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Task`
--

DROP TABLE IF EXISTS `Task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Task` (
  `TaskID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TaskStatusID` int(10) unsigned NOT NULL,
  `Reporter` int(10) unsigned NOT NULL,
  `Assignee` int(10) unsigned NOT NULL,
  `TaskTitle` varchar(255) NOT NULL,
  `TaskDescription` varchar(511) NOT NULL,
  `TaskDeadline` date NOT NULL,
  `Timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TaskID`),
  KEY `FK_Task_Assignee` (`Assignee`),
  KEY `FK_Task_Reporter` (`Reporter`),
  KEY `FK_Task_TaskStatusID` (`TaskStatusID`),
  CONSTRAINT `FK_Task_Assignee` FOREIGN KEY (`Assignee`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_Reporter` FOREIGN KEY (`Reporter`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_TaskStatusID` FOREIGN KEY (`TaskStatusID`) REFERENCES `TaskStatus` (`TaskStatusID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Task`
--

LOCK TABLES `Task` WRITE;
/*!40000 ALTER TABLE `Task` DISABLE KEYS */;
INSERT INTO `Task` VALUES (42,6,105,104,'Program Flow','Come up with a program flow for our next event. Include at least 3 15-min performances from guest bands. ','2018-05-31','2017-05-20 17:47:26');
/*!40000 ALTER TABLE `Task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskComment`
--

DROP TABLE IF EXISTS `TaskComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskComment` (
  `TaskCommentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TaskID` int(10) unsigned NOT NULL,
  `TaskSubscriberID` int(10) unsigned NOT NULL,
  `Comment` varchar(511) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TaskCommentID`),
  KEY `FK_TaskComment_TaskID` (`TaskID`),
  KEY `FK_TaskComment_TaskSubscriberID` (`TaskSubscriberID`),
  CONSTRAINT `FK_TaskComment_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_TaskComment_TaskSubscriberID` FOREIGN KEY (`TaskSubscriberID`) REFERENCES `TaskSubscriber` (`TaskSubscriberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskComment`
--

LOCK TABLES `TaskComment` WRITE;
/*!40000 ALTER TABLE `TaskComment` DISABLE KEYS */;
INSERT INTO `TaskComment` VALUES (23,42,115,'I\'m starting on the task.','2017-05-20 09:52:16'),(24,42,117,'Where is the program flow?','2017-05-20 10:00:24');
/*!40000 ALTER TABLE `TaskComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskEvent`
--

DROP TABLE IF EXISTS `TaskEvent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskEvent` (
  `TaskEventID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EventID` int(10) unsigned NOT NULL,
  `TaskID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TaskEventID`),
  KEY `FK_TaskEvent_EventID_idx` (`EventID`),
  KEY `FK_TaskEvent_TaskID_idx` (`TaskID`),
  CONSTRAINT `FK_TaskEvent_EventID` FOREIGN KEY (`EventID`) REFERENCES `Event` (`EventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_TaskEvent_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskEvent`
--

LOCK TABLES `TaskEvent` WRITE;
/*!40000 ALTER TABLE `TaskEvent` DISABLE KEYS */;
INSERT INTO `TaskEvent` VALUES (10,12,42);
/*!40000 ALTER TABLE `TaskEvent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskStatus`
--

DROP TABLE IF EXISTS `TaskStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskStatus` (
  `TaskStatusID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`TaskStatusID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskStatus`
--

LOCK TABLES `TaskStatus` WRITE;
/*!40000 ALTER TABLE `TaskStatus` DISABLE KEYS */;
INSERT INTO `TaskStatus` VALUES (1,'To Do'),(2,'In Progress'),(3,'For Review'),(4,'Needs Changes'),(5,'Accepted'),(6,'Done');
/*!40000 ALTER TABLE `TaskStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskSubmission`
--

DROP TABLE IF EXISTS `TaskSubmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskSubmission` (
  `TaskSubmissionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TaskID` int(10) unsigned NOT NULL,
  `Description` varchar(511) NOT NULL,
  `FilePath` varchar(255) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TaskSubmissionID`),
  KEY `FK_TaskSubmission_TasKID_idx` (`TaskID`),
  CONSTRAINT `FK_TaskSubmission_TasKID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskSubmission`
--

LOCK TABLES `TaskSubmission` WRITE;
/*!40000 ALTER TABLE `TaskSubmission` DISABLE KEYS */;
INSERT INTO `TaskSubmission` VALUES (22,42,'Done with the task.',NULL,'2017-05-20 09:52:50');
/*!40000 ALTER TABLE `TaskSubmission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskSubscriber`
--

DROP TABLE IF EXISTS `TaskSubscriber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskSubscriber` (
  `TaskSubscriberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TaskID` int(10) unsigned NOT NULL,
  `BatchMemberID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TaskSubscriberID`),
  KEY `FK_TaskSubscriber_BatchMemberID` (`BatchMemberID`),
  KEY `FK_TaskSubscriber_TaskID` (`TaskID`),
  CONSTRAINT `FK_TaskSubscriber_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_TaskSubscriber_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskSubscriber`
--

LOCK TABLES `TaskSubscriber` WRITE;
/*!40000 ALTER TABLE `TaskSubscriber` DISABLE KEYS */;
INSERT INTO `TaskSubscriber` VALUES (115,42,104),(116,42,105),(117,42,91);
/*!40000 ALTER TABLE `TaskSubscriber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TaskTree`
--

DROP TABLE IF EXISTS `TaskTree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TaskTree` (
  `TaskTreeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ChildTaskID` int(10) unsigned NOT NULL,
  `ParentTaskID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`TaskTreeID`),
  KEY `FK_TaskTree_ChildTaskID_idx` (`ChildTaskID`),
  KEY `FK_TaskTree_ParentTaskID_idx` (`ParentTaskID`),
  CONSTRAINT `FK_TaskTree_ChildTaskID` FOREIGN KEY (`ChildTaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_TaskTree_ParentTaskID` FOREIGN KEY (`ParentTaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskTree`
--

LOCK TABLES `TaskTree` WRITE;
/*!40000 ALTER TABLE `TaskTree` DISABLE KEYS */;
/*!40000 ALTER TABLE `TaskTree` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-21 14:17:07
