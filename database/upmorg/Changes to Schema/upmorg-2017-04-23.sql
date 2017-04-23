-- MySQL dump 10.13  Distrib 5.7.13, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: upmorg
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.2

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityGroup`
--

LOCK TABLES `AvailabilityGroup` WRITE;
/*!40000 ALTER TABLE `AvailabilityGroup` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityGroupMember`
--

LOCK TABLES `AvailabilityGroupMember` WRITE;
/*!40000 ALTER TABLE `AvailabilityGroupMember` DISABLE KEYS */;
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
  `MondayVector` char(96) NOT NULL,
  `TuesdayVector` char(96) NOT NULL,
  `WednesdayVector` char(96) NOT NULL,
  `ThursdayVector` char(96) NOT NULL,
  `FridayVector` char(96) NOT NULL,
  `SaturdayVector` char(96) NOT NULL,
  `SundayVector` char(96) NOT NULL,
  PRIMARY KEY (`AvailabilityMemberID`),
  KEY `FK_AvailabilityMember_BatchMemberID` (`BatchMemberID`),
  CONSTRAINT `FK_AvailabilityMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AvailabilityMember`
--

LOCK TABLES `AvailabilityMember` WRITE;
/*!40000 ALTER TABLE `AvailabilityMember` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Batch`
--

LOCK TABLES `Batch` WRITE;
/*!40000 ALTER TABLE `Batch` DISABLE KEYS */;
INSERT INTO `Batch` VALUES (1,'2017-2018'),(11,'2018-2019');
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BatchMember`
--

LOCK TABLES `BatchMember` WRITE;
/*!40000 ALTER TABLE `BatchMember` DISABLE KEYS */;
INSERT INTO `BatchMember` VALUES (34,1,2,2),(35,1,3,3),(36,1,4,4),(38,1,6,4),(39,1,7,4),(40,1,8,5),(41,1,9,4),(42,1,10,4),(43,1,11,0),(44,1,1,1),(45,1,12,0),(46,1,13,0),(48,1,5,4),(56,1,31,5),(57,1,14,5),(58,1,24,5),(59,11,1,1),(60,11,2,2),(61,11,3,3),(62,11,4,4),(63,11,5,4),(64,11,6,4),(65,11,7,4),(66,11,8,4),(67,11,9,4),(68,11,10,4);
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
  KEY `FK_CommiteeMember_CommiteeID` (`CommitteeID`),
  CONSTRAINT `FK_CommiteeMember_CommiteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `Committee` (`CommitteeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CommitteeMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommitteeMember`
--

LOCK TABLES `CommitteeMember` WRITE;
/*!40000 ALTER TABLE `CommitteeMember` DISABLE KEYS */;
INSERT INTO `CommitteeMember` VALUES (74,38,2,1),(76,39,3,1),(78,41,5,1),(79,42,6,1),(90,36,7,1),(105,57,1,1),(106,48,1,1),(110,58,1,1),(111,40,1,1),(114,56,7,1),(115,63,1,1),(116,64,2,1),(117,65,3,1),(118,66,4,1),(119,67,5,1),(120,68,6,1),(121,62,7,1);
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
  KEY `FK_CommiteePermission_CommiteeID` (`CommitteeID`),
  KEY `FK_CommitteePermission_MemberTypeID` (`MemberTypeID`),
  KEY `FK_CommitteePermission_BatchID_idx` (`BatchID`),
  CONSTRAINT `FK_CommiteePermission_CommiteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `CommitteePermission` (`CommitteePermissionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CommitteePermission_MemberTypeID` FOREIGN KEY (`MemberTypeID`) REFERENCES `MemberType` (`MemberTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommitteePermission`
--

LOCK TABLES `CommitteePermission` WRITE;
/*!40000 ALTER TABLE `CommitteePermission` DISABLE KEYS */;
INSERT INTO `CommitteePermission` VALUES (1,1,1,1),(2,1,1,2),(3,1,1,3),(4,1,1,4),(5,1,1,5),(6,1,1,6),(7,1,1,7),(8,1,2,1),(9,1,2,2),(10,1,2,3),(11,1,3,4),(12,1,3,5),(13,1,3,6),(14,11,1,1),(15,11,1,2),(16,11,1,3),(17,11,1,4),(18,11,1,5),(19,11,1,6),(20,11,1,7),(21,11,2,1),(22,11,2,2),(23,11,2,3),(24,11,3,4),(25,11,3,5),(26,11,3,6);
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
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsPublic` tinyint(1) NOT NULL,
  PRIMARY KEY (`EventID`),
  KEY `FK_Event_EventOwner` (`EventOwner`),
  CONSTRAINT `FK_Event_EventOwner` FOREIGN KEY (`EventOwner`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event`
--

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
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
  `BatchMemberID` int(10) unsigned NOT NULL,
  `Amount` float unsigned NOT NULL,
  `IsDebit` varchar(6) NOT NULL,
  `IsVerified` tinyint(1) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`LedgerInputID`),
  KEY `FK_LedgerInput_BatchMemberID` (`BatchMemberID`),
  CONSTRAINT `FK_LedgerInput_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LedgerInput`
--

LOCK TABLES `LedgerInput` WRITE;
/*!40000 ALTER TABLE `LedgerInput` DISABLE KEYS */;
INSERT INTO `LedgerInput` VALUES (4,36,100,'1',1,'Another One','2017-04-22 12:06:34'),(5,36,200,'1',1,'Another One','2017-04-22 12:07:01'),(6,36,200,'0',1,'Sampleee','2017-04-22 12:07:50'),(7,36,300,'0',1,'Credit?','2017-04-22 12:08:50'),(8,36,0.5,'1',1,'I Hate decimals','2017-04-22 12:09:07'),(9,36,200.5,'1',1,'No more negative','2017-04-22 12:11:52'),(10,36,99,'1',1,'A hundred!','2017-04-22 12:17:59'),(11,36,400,'1',1,'Should be 500!','2017-04-22 12:46:11'),(12,36,500,'0',1,'Should be none :(','2017-04-22 12:46:32'),(13,36,100,'1',1,'Yey another 100!','2017-04-22 12:55:18'),(14,56,400,'1',1,'I\'m a member only','2017-04-22 13:03:49'),(15,56,500,'0',1,'Clearing out the funds','2017-04-22 17:02:01'),(16,56,500,'0',1,'Clearing out the funds','2017-04-22 17:02:03'),(17,56,500,'0',1,'Clearing out the funds','2017-04-22 17:02:09'),(18,56,500,'0',1,'Clearing out the funds','2017-04-22 17:03:30'),(19,56,1500,'1',1,'Duplicates','2017-04-22 17:03:52'),(20,62,1000,'1',1,'Sample','2017-04-23 08:26:46'),(21,36,12500,'1',1,'Funds!!','2017-04-23 08:31:34'),(22,62,500,'0',1,'Spenditures','2017-04-23 09:00:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Member`
--

LOCK TABLES `Member` WRITE;
/*!40000 ALTER TABLE `Member` DISABLE KEYS */;
INSERT INTO `Member` VALUES (1,'First','','Frontman','firstfront@upmorg.com','123','$2y$10$JlxCMzROB/xMYXWxqP/gXuqPxwMn2K4QlwCZqL5U7J5nzg9j8Fnmm'),(2,'Second','','Frontman','secondfront@upmorg.com','123','$2y$10$2YGnSbnJ3QNo4wFeO0iQh.63DsFEOIw9DfhuFNsQJG3gnYGdi.bdq'),(3,'Third','','Frontman','thirdfront@upmorg.com','123','$2y$10$WZHeSHMiLGjgtjvyIVqp9eGdduMdut0ZMJIXxxVG583z/nOd7ITOe'),(4,'Finance','','Head','financehead@upmorg.com','123','$2y$10$0kFn6/4A8JSS17ahf.WtYuC5yIwAMngNqjHHpuI2Ej/21H3U7GgZ.'),(5,'Documentation','','Head','docuhead@upmorg.com','123','$2y$10$.4h9eyzH3vmyrA2QxMUs..BGIkxDmYac.nBtJO/uziu5gywTR/MzW'),(6,'Production','','Head','prodhead@upmorg.com','123','$2y$10$u9iRIFuAZFyYur8usmltbeefjFmyhmysu/sKVMLxC2ir2MyN5RtMy'),(7,'Logistics','','Head','loghead@upmorg.com','123','$2y$10$1ppKG/F6C15tSytbsEZri.qjjfFCv0DP7F.7Pb/aI0szJA4P79BwW'),(8,'Sponsorship','','Head','sponsorshiphead@upmorg.com','123','$2y$10$.s9huH61JocGgWr7Ced18u.Qoiwp6YFqZQaKqPso9VzsK/MSn3GPC'),(9,'Creatives','','Head','creativeshead@upmorg.com','123','$2y$10$x48okyu726XXt9pdNlcaIeAgeFJie6XJSJOxMWH.B1GyTksBzg9i2'),(10,'Information','Dissemination','Head','infodisshead@upmorg.com','123','$2y$10$7POBsIMbwDiZU4zqMMe17.9T3MKqMJlEuI4Fxpig6WGSfK6jeJ3Uu'),(11,'Monica','Geller','Bing','monicabing@upmorg.com','12345','$2y$10$EpugDdfroFvyxDT9KsJYC.vO8FlE4PkoSOTaTvc6xfBUeLbg8gb6.'),(12,'Ross','Eustace','Geller','rossgeller@upmorg.com','12345','$2y$10$0/XEB18J01/FhegqW..80ez8AevTMTw5nw6.mRy/u4sr5mPA4Rw0u'),(13,'Phoebe','','Buffay','phoebebuffay@upmorg.com','12345','$2y$10$BHrbNrFznBYLFE3yP4ZjaeX4Cp2N00BqFSRZKVExNe8eMbIbjEZtG'),(14,'Rachel','Karen','Green','rachelgreen@upmorg.com','12345','$2y$10$ktRiOcO.QnymRBjyYgmZzuk7jhP0JjWUWJXBqn7w32fVbI11GFRj.'),(15,'Joseph','Francis','Tribbiani Jr.','joeytribbiani@upmorg.com','12345','$2y$10$b5J3BzBdqNac6wggjn4IC.4uNcUinUI.m7K.dJZ1pU1.97ZPj9Sry'),(16,'Chandler','Muriel','Bing','chandlerbing@upmorg.com','12345','$2y$10$rjNbri/qYouI.BSXYfOKrOWEdugRehohU9YxJh.mZwEBwXh0Sc7CO'),(17,'Theodore','Evelyn','Mosby','tedmosby@upmorg.com','3456','$2y$10$gFfKpaQP446F9s31.3jSlOD0GCyNvFiFPa0UYJ.hslZWgJlFbbTYu'),(18,'Marshall','','Eriksen','marshalleriksen@upmorg.com','3456','$2y$10$r8hbm2O7RbNrF9eVcsfHSumiDUs/UlMIcO2L77AKWpp/F5aDSWXsO'),(19,'Lily','Aldrin','Eriksen','lilyeriksen@upmorg.com','3456','$2y$10$e4Jr.8IPbXkuF5QLAP2yJeJlo.en1Mn6WRpuG1PBiDPVCUfGOFZGu'),(20,'Robin','Charles','Scherbatsky Jr.','robinscherbatsky@upmorg.com','3456','$2y$10$cwUo9UGKNi3iVuGrV1QwauxvaQFBACuA8v55bSAx6Wbe9cv3eebPK'),(21,'Barnabus','','Stinson','barneystinson@upmorg.com','3456','$2y$10$vClzbWNYbN5zxGSKDKno5OYRgU1sqrz8r2FhoLAd9cSJZJtI51kaa'),(22,'Tracy','McConnell','Mosby','tracymosby@upmorg.com','3456','$2y$10$CxJmKM7QdTcoZM3D/KPOBOhTJWcrcIEW8SzQvI8AvZiT2zFjIj9Uu'),(23,'Jackie','Beulah','Burkhart','jackieburkhart@upmorg.com','70','$2y$10$K1Gtz8shlD9fIOep3C.Qq.CglLxZPqNR9Pi/uL6o7kXAFnfRm4USW'),(24,'Steven','','Hyde','stevenhyde@upmorg.com','70','$2y$10$GYjm2U2SsmD9mDh5G6DoKeg1eRlWBnaHRCcoKzxNbcZicJRZMM62G'),(25,'Donna','','Pinciotti','donnapinciotti@upmorg.com','70','$2y$10$2XgvSbD6V2lfAtr5LIKWeO5qIHCcTEHAUHdQb.QepIPRwALhfghYy'),(26,'Foreign','Exchange','Student','fez@upmorg.com','70','$2y$10$dzz5cRG0JMla8wLD/2eFo.ucpx1Z5PpS6N3RM8n5.KpZxqNcxSK8C'),(27,'Michael','Christopher','Kelso','michaelkelso@upmorg.com','70','$2y$10$tNSYPiPcpT.GWKUvNiKHYeVvwf9Wf1fGJu0YaPgvwUz7eQM3JxihK'),(28,'Eric','Albert','Forman','ericforman@upmorg.com','70',''),(29,'Ronald','Ulysses','Swanson','ronswanson@upmorg.com','999999','$2y$10$crm5QB29WMyAvshTm397A.cmEHxx0UJiqjIC026pvLsE52gesBcDq'),(30,'Leslie','Barbara','Knope','leslieknope@upmorg.com','999999','$2y$10$ipQOq8X6C0vUgOZEwOWlbe3Hau9.BrI9RPQKhQaHnxnVhIfHhSXJi'),(31,'Andrew','Maxwell','Dwyer','andydwyer@upmorg.com','999999','$2y$10$omWXtBk7vxDLnRyLAAOMH.nN7ltqLYn.PRwZHimkeGCLiYT7eEV8O'),(32,'April','Roberta','Ludgate-Dwyer','aprilludgate@upmorg.com','999999','$2y$10$ewEau0.NWnsKRBV3vJglQexvHj6k69gp3gOZx33czJqQr8uE6RSLi'),(33,'Thomas','Montgomery','Haverford','tomhaverford@upmorg.com','999999','$2y$10$KpQfjA0fk3gK3LAqPEuaOOPm6lh4SJimGkoAN7KJ6fzEvdxOPhieC'),(34,'Ann','Meredith','Perkins','annperkins@upmorg.com','999999','$2y$10$wkYZOXejexamRwa3Ujp51Ozd748qV/pn2J6aET0YZdc2XJRXmSDuG'),(36,'Jeshurun','Cedillo','Orquina','jeshorquina@yahoo.com','09123456789','$2y$10$AX7aca2lIVXx39Wi.vvqS.K/yMuZcznhn4N3eVJicX1p5SAwmkyfq');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StaticData`
--

LOCK TABLES `StaticData` WRITE;
/*!40000 ALTER TABLE `StaticData` DISABLE KEYS */;
INSERT INTO `StaticData` VALUES (1,'SystemAdminPassword','$2y$10$qT21DrQPiJ1Yc11nwRgZXe8YQCPZ.v6hOIkh15G/gL73W0uUHE/8m'),(2,'VerifiedBalance','499212.02'),(3,'CurrentBatch','11'),(4,'IsLedgerActivated','1'),(5,'IsLedgerOpen','1');
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
  `ParentTaskID` int(10) unsigned DEFAULT NULL,
  `TaskStatusID` int(10) unsigned NOT NULL,
  `EventID` int(10) unsigned DEFAULT NULL,
  `Reporter` int(10) unsigned NOT NULL,
  `Assignee` int(10) unsigned NOT NULL,
  `TaskTitle` varchar(255) NOT NULL,
  `TaskDescription` varchar(511) NOT NULL,
  `TaskDeadline` date NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TaskID`),
  KEY `FK_Task_Assignee` (`Assignee`),
  KEY `FK_Task_EventID` (`EventID`),
  KEY `FK_Task_ParentTaskID` (`ParentTaskID`),
  KEY `FK_Task_Reporter` (`Reporter`),
  KEY `FK_Task_TaskStatusID` (`TaskStatusID`),
  CONSTRAINT `FK_Task_Assignee` FOREIGN KEY (`Assignee`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_EventID` FOREIGN KEY (`EventID`) REFERENCES `Event` (`EventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_ParentTaskID` FOREIGN KEY (`ParentTaskID`) REFERENCES `Task` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_Reporter` FOREIGN KEY (`Reporter`) REFERENCES `BatchMember` (`BatchMemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Task_TaskStatusID` FOREIGN KEY (`TaskStatusID`) REFERENCES `TaskStatus` (`TaskStatusID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Task`
--

LOCK TABLES `Task` WRITE;
/*!40000 ALTER TABLE `Task` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskComment`
--

LOCK TABLES `TaskComment` WRITE;
/*!40000 ALTER TABLE `TaskComment` DISABLE KEYS */;
/*!40000 ALTER TABLE `TaskComment` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskStatus`
--

LOCK TABLES `TaskStatus` WRITE;
/*!40000 ALTER TABLE `TaskStatus` DISABLE KEYS */;
INSERT INTO `TaskStatus` VALUES (0,'In progress'),(1,'Completed'),(2,'Not Yet Started'),(3,'Needs Modification');
/*!40000 ALTER TABLE `TaskStatus` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TaskSubscriber`
--

LOCK TABLES `TaskSubscriber` WRITE;
/*!40000 ALTER TABLE `TaskSubscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `TaskSubscriber` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-23 17:04:42
