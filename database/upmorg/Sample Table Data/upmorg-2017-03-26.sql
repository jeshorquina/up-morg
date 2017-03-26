-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2017 at 08:50 AM
-- Server version: 5.7.17-0ubuntu0.16.10.1
-- PHP Version: 7.0.17-2+deb.sury.org~yakkety+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upmorg`
--

-- --------------------------------------------------------

--
-- Table structure for table `AvailabilityGroup`
--

CREATE TABLE `AvailabilityGroup` (
  `AvailabilityGroupID` int(10) UNSIGNED NOT NULL,
  `FrontmanID` int(10) UNSIGNED NOT NULL,
  `GroupName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AvailabilityGroupMember`
--

CREATE TABLE `AvailabilityGroupMember` (
  `AvailabilityGroupMemberID` int(10) UNSIGNED NOT NULL,
  `AvailabilityMemberID` int(10) UNSIGNED NOT NULL,
  `AvailabilityGroupID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AvailabilityMember`
--

CREATE TABLE `AvailabilityMember` (
  `AvailabilityMemberID` int(10) UNSIGNED NOT NULL,
  `BatchMemberID` int(10) UNSIGNED NOT NULL,
  `MondayVector` char(96) NOT NULL,
  `TuesdayVector` char(96) NOT NULL,
  `WednesdayVector` char(96) NOT NULL,
  `ThursdayVector` char(96) NOT NULL,
  `FridayVector` char(96) NOT NULL,
  `SaturdayVector` char(96) NOT NULL,
  `SundayVector` char(96) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Batch`
--

CREATE TABLE `Batch` (
  `BatchID` int(10) UNSIGNED NOT NULL,
  `AcadYear` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Batch`
--

INSERT INTO `Batch` (`BatchID`, `AcadYear`) VALUES
(1, '2016-2017'),
(5, '2014-2015'),
(6, '2017-2018');

-- --------------------------------------------------------

--
-- Table structure for table `BatchMember`
--

CREATE TABLE `BatchMember` (
  `BatchMemberID` int(10) UNSIGNED NOT NULL,
  `BatchID` int(10) UNSIGNED NOT NULL,
  `MemberID` int(10) UNSIGNED NOT NULL,
  `MemberTypeID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BatchMember`
--

INSERT INTO `BatchMember` (`BatchMemberID`, `BatchID`, `MemberID`, `MemberTypeID`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 3),
(4, 1, 4, 4),
(5, 1, 5, 4),
(6, 1, 6, 4),
(7, 1, 7, 4),
(8, 1, 8, 4),
(9, 1, 9, 4),
(10, 1, 10, 4),
(11, 1, 11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Committee`
--

CREATE TABLE `Committee` (
  `CommitteeID` int(10) UNSIGNED NOT NULL,
  `CommitteeHeadID` int(10) UNSIGNED NOT NULL,
  `CommitteeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Committee`
--

INSERT INTO `Committee` (`CommitteeID`, `CommitteeHeadID`, `CommitteeName`) VALUES
(1, 4, 'Documentation'),
(2, 5, 'Production'),
(3, 6, 'Logistics'),
(4, 7, 'Sponsorships'),
(5, 8, 'Creatives'),
(6, 9, 'Information Dissemination'),
(7, 10, 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `CommitteeMember`
--

CREATE TABLE `CommitteeMember` (
  `CommitteeMemberID` int(10) UNSIGNED NOT NULL,
  `BatchMemberID` int(10) UNSIGNED NOT NULL,
  `CommitteeID` int(10) UNSIGNED NOT NULL,
  `IsApproved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CommitteePermission`
--

CREATE TABLE `CommitteePermission` (
  `CommitteePermissionID` int(10) UNSIGNED NOT NULL,
  `CommitteeID` int(10) UNSIGNED NOT NULL,
  `MemberTypeID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `EventID` int(10) UNSIGNED NOT NULL,
  `EventOwner` int(10) UNSIGNED NOT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` varchar(511) NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IsPublic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LedgerInput`
--

CREATE TABLE `LedgerInput` (
  `LedgerInputID` int(10) UNSIGNED NOT NULL,
  `BatchMemberID` int(10) UNSIGNED NOT NULL,
  `InputType` int(10) UNSIGNED NOT NULL,
  `Amount` int(10) UNSIGNED NOT NULL,
  `IsVerified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Member`
--

CREATE TABLE `Member` (
  `MemberID` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `PhoneNumber` varchar(50) DEFAULT NULL,
  `Password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Member`
--

INSERT INTO `Member` (`MemberID`, `FirstName`, `MiddleName`, `LastName`, `EmailAddress`, `PhoneNumber`, `Password`) VALUES
(1, 'First', '', 'Frontman', 'firstfront@upmorg.com', '123', '$2y$10$JlxCMzROB/xMYXWxqP/gXuqPxwMn2K4QlwCZqL5U7J5nzg9j8Fnmm'),
(2, 'Second', '', 'Frontman', 'secondfront@upmorg.com', '123', '$2y$10$2YGnSbnJ3QNo4wFeO0iQh.63DsFEOIw9DfhuFNsQJG3gnYGdi.bdq'),
(3, 'Third', '', 'Frontman', 'thirdfront@upmorg.com', '123', '$2y$10$WZHeSHMiLGjgtjvyIVqp9eGdduMdut0ZMJIXxxVG583z/nOd7ITOe'),
(4, 'Finance', '', 'Head', 'financehead@upmorg.com', '123', '$2y$10$0kFn6/4A8JSS17ahf.WtYuC5yIwAMngNqjHHpuI2Ej/21H3U7GgZ.'),
(5, 'Documentation', '', 'Head', 'docuhead@upmorg.com', '123', '$2y$10$.4h9eyzH3vmyrA2QxMUs..BGIkxDmYac.nBtJO/uziu5gywTR/MzW'),
(6, 'Production', '', 'Head', 'prodhead@upmorg.com', '123', '$2y$10$u9iRIFuAZFyYur8usmltbeefjFmyhmysu/sKVMLxC2ir2MyN5RtMy'),
(7, 'Logistics', '', 'Head', 'loghead@upmorg.com', '123', '$2y$10$1ppKG/F6C15tSytbsEZri.qjjfFCv0DP7F.7Pb/aI0szJA4P79BwW'),
(8, 'Sponsorship', '', 'Head', 'sponsorshiphead@upmorg.com', '123', '$2y$10$.s9huH61JocGgWr7Ced18u.Qoiwp6YFqZQaKqPso9VzsK/MSn3GPC'),
(9, 'Creatives', '', 'Head', 'creativeshead@upmorg.com', '123', '$2y$10$x48okyu726XXt9pdNlcaIeAgeFJie6XJSJOxMWH.B1GyTksBzg9i2'),
(10, 'Information', 'Dissemination', 'Head', 'infodisshead@upmorg.com', '123', '$2y$10$7POBsIMbwDiZU4zqMMe17.9T3MKqMJlEuI4Fxpig6WGSfK6jeJ3Uu'),
(11, 'Monica', 'Geller', 'Bing', 'monicabing@upmorg.com', '12345', '$2y$10$EpugDdfroFvyxDT9KsJYC.vO8FlE4PkoSOTaTvc6xfBUeLbg8gb6.'),
(12, 'Ross', 'Eustace', 'Geller', 'rossgeller@upmorg.com', '12345', '$2y$10$0/XEB18J01/FhegqW..80ez8AevTMTw5nw6.mRy/u4sr5mPA4Rw0u'),
(13, 'Phoebe', '', 'Buffay', 'phoebebuffay@upmorg.com', '12345', '$2y$10$BHrbNrFznBYLFE3yP4ZjaeX4Cp2N00BqFSRZKVExNe8eMbIbjEZtG'),
(14, 'Rachel', 'Karen', 'Green', 'rachelgreen@upmorg.com', '12345', '$2y$10$ktRiOcO.QnymRBjyYgmZzuk7jhP0JjWUWJXBqn7w32fVbI11GFRj.'),
(15, 'Joseph', 'Francis', 'Tribbiani Jr.', 'joeytribbiani@upmorg.com', '12345', '$2y$10$b5J3BzBdqNac6wggjn4IC.4uNcUinUI.m7K.dJZ1pU1.97ZPj9Sry'),
(16, 'Chandler', 'Muriel', 'Bing', 'chandlerbing@upmorg.com', '12345', '$2y$10$rjNbri/qYouI.BSXYfOKrOWEdugRehohU9YxJh.mZwEBwXh0Sc7CO'),
(17, 'Theodore', 'Evelyn', 'Mosby', 'tedmosby@upmorg.com', '3456', '$2y$10$gFfKpaQP446F9s31.3jSlOD0GCyNvFiFPa0UYJ.hslZWgJlFbbTYu'),
(18, 'Marshall', '', 'Eriksen', 'marshalleriksen@upmorg.com', '3456', '$2y$10$r8hbm2O7RbNrF9eVcsfHSumiDUs/UlMIcO2L77AKWpp/F5aDSWXsO'),
(19, 'Lily', 'Aldrin', 'Eriksen', 'lilyeriksen@upmorg.com', '3456', '$2y$10$e4Jr.8IPbXkuF5QLAP2yJeJlo.en1Mn6WRpuG1PBiDPVCUfGOFZGu'),
(20, 'Robin', 'Charles', 'Scherbatsky Jr.', 'robinscherbatsky@upmorg.com', '3456', '$2y$10$cwUo9UGKNi3iVuGrV1QwauxvaQFBACuA8v55bSAx6Wbe9cv3eebPK'),
(21, 'Barnabus', '', 'Stinson', 'barneystinson@upmorg.com', '3456', '$2y$10$vClzbWNYbN5zxGSKDKno5OYRgU1sqrz8r2FhoLAd9cSJZJtI51kaa'),
(22, 'Tracy', 'McConnell', 'Mosby', 'tracymosby@upmorg.com', '3456', '$2y$10$CxJmKM7QdTcoZM3D/KPOBOhTJWcrcIEW8SzQvI8AvZiT2zFjIj9Uu'),
(23, 'Jackie', 'Beulah', 'Burkhart', 'jackieburkhart@upmorg.com', '70', '$2y$10$K1Gtz8shlD9fIOep3C.Qq.CglLxZPqNR9Pi/uL6o7kXAFnfRm4USW'),
(24, 'Steven', '', 'Hyde', 'stevenhyde@upmorg.com', '70', '$2y$10$GYjm2U2SsmD9mDh5G6DoKeg1eRlWBnaHRCcoKzxNbcZicJRZMM62G'),
(25, 'Donna', '', 'Pinciotti', 'donnapinciotti@upmorg.com', '70', '$2y$10$2XgvSbD6V2lfAtr5LIKWeO5qIHCcTEHAUHdQb.QepIPRwALhfghYy'),
(26, 'Foreign', 'Exchange', 'Student', 'fez@upmorg.com', '70', '$2y$10$dzz5cRG0JMla8wLD/2eFo.ucpx1Z5PpS6N3RM8n5.KpZxqNcxSK8C'),
(27, 'Michael', 'Christopher', 'Kelso', 'michaelkelso@upmorg.com', '70', '$2y$10$tNSYPiPcpT.GWKUvNiKHYeVvwf9Wf1fGJu0YaPgvwUz7eQM3JxihK'),
(28, 'Eric', 'Albert', 'Forman', 'ericforman@upmorg.com', '70', ''),
(29, 'Ronald', 'Ulysses', 'Swanson', 'ronswanson@upmorg.com', '999999', '$2y$10$crm5QB29WMyAvshTm397A.cmEHxx0UJiqjIC026pvLsE52gesBcDq'),
(30, 'Leslie', 'Barbara', 'Knope', 'leslieknope@upmorg.com', '999999', '$2y$10$ipQOq8X6C0vUgOZEwOWlbe3Hau9.BrI9RPQKhQaHnxnVhIfHhSXJi'),
(31, 'Andrew', 'Maxwell', 'Dwyer', 'andydwyer@upmorg.com', '999999', '$2y$10$omWXtBk7vxDLnRyLAAOMH.nN7ltqLYn.PRwZHimkeGCLiYT7eEV8O'),
(32, 'April', 'Roberta', 'Ludgate-Dwyer', 'aprilludgate@upmorg.com', '999999', '$2y$10$ewEau0.NWnsKRBV3vJglQexvHj6k69gp3gOZx33czJqQr8uE6RSLi'),
(33, 'Thomas', 'Montgomery', 'Haverford', 'tomhaverford@upmorg.com', '999999', '$2y$10$KpQfjA0fk3gK3LAqPEuaOOPm6lh4SJimGkoAN7KJ6fzEvdxOPhieC'),
(34, 'Ann', 'Meredith', 'Perkins', 'annperkins@upmorg.com', '999999', '$2y$10$wkYZOXejexamRwa3Ujp51Ozd748qV/pn2J6aET0YZdc2XJRXmSDuG'),
(35, 'Joseph Niel', 'Inson', 'Tuazon', 'josephnieltuazon@yahoo.com', '09054925822', '$2y$10$Li44TfwvU6VWkPTYInUdmO3VfXLGaLeO17/uhiwgjQ.4DjEr7XFvC');

-- --------------------------------------------------------

--
-- Table structure for table `MemberType`
--

CREATE TABLE `MemberType` (
  `MemberTypeID` int(10) UNSIGNED NOT NULL,
  `MemberType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MemberType`
--

INSERT INTO `MemberType` (`MemberTypeID`, `MemberType`) VALUES
(1, 'First Frontman'),
(2, 'Second Frontman'),
(3, 'Third Frontman'),
(4, 'Committee Head'),
(5, 'Committee Member');

-- --------------------------------------------------------

--
-- Table structure for table `StaticData`
--

CREATE TABLE `StaticData` (
  `StaticDataID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `StaticData`
--

INSERT INTO `StaticData` (`StaticDataID`, `Name`, `Value`) VALUES
(1, 'SystemAdminPassword', '$2y$10$L7TrflsFUNUhgXiQdjP/W.KvQ3PT806FPl/cwWJje8o2xQ2KEBqOK');

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
  `TaskID` int(10) UNSIGNED NOT NULL,
  `ParentTaskID` int(10) UNSIGNED DEFAULT NULL,
  `TaskStatusID` int(10) UNSIGNED NOT NULL,
  `EventID` int(10) UNSIGNED DEFAULT NULL,
  `Reporter` int(10) UNSIGNED NOT NULL,
  `Assignee` int(10) UNSIGNED NOT NULL,
  `TaskTitle` varchar(255) NOT NULL,
  `TaskDescription` varchar(511) NOT NULL,
  `TaskDeadline` date NOT NULL,
  `Timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TaskComment`
--

CREATE TABLE `TaskComment` (
  `TaskCommentID` int(10) UNSIGNED NOT NULL,
  `TaskID` int(10) UNSIGNED NOT NULL,
  `TaskSubscriberID` int(10) UNSIGNED NOT NULL,
  `Comment` varchar(511) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TaskStatus`
--

CREATE TABLE `TaskStatus` (
  `TaskStatusID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TaskSubscriber`
--

CREATE TABLE `TaskSubscriber` (
  `TaskSubscriberID` int(10) UNSIGNED NOT NULL,
  `TaskID` int(10) UNSIGNED NOT NULL,
  `BatchMemberID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AvailabilityGroup`
--
ALTER TABLE `AvailabilityGroup`
  ADD PRIMARY KEY (`AvailabilityGroupID`),
  ADD KEY `FK_AvailabilityGroup_FrontmanID` (`FrontmanID`);

--
-- Indexes for table `AvailabilityGroupMember`
--
ALTER TABLE `AvailabilityGroupMember`
  ADD PRIMARY KEY (`AvailabilityGroupMemberID`),
  ADD KEY `FK_AvailabilityGroupMember_AvailabilityMemberID` (`AvailabilityMemberID`),
  ADD KEY `FK_AvailabilityGroupMember_AvailabilityGroupID` (`AvailabilityGroupID`);

--
-- Indexes for table `AvailabilityMember`
--
ALTER TABLE `AvailabilityMember`
  ADD PRIMARY KEY (`AvailabilityMemberID`),
  ADD KEY `FK_AvailabilityMember_BatchMemberID` (`BatchMemberID`);

--
-- Indexes for table `Batch`
--
ALTER TABLE `Batch`
  ADD PRIMARY KEY (`BatchID`);

--
-- Indexes for table `BatchMember`
--
ALTER TABLE `BatchMember`
  ADD PRIMARY KEY (`BatchMemberID`),
  ADD KEY `FK_BatchMember_BatchID` (`BatchID`),
  ADD KEY `FK_BatchMember_MemberID` (`MemberID`),
  ADD KEY `FK_BatchMember_MemberTypeID` (`MemberTypeID`);

--
-- Indexes for table `Committee`
--
ALTER TABLE `Committee`
  ADD PRIMARY KEY (`CommitteeID`),
  ADD KEY `FK_Committee_CommitteeHeadID` (`CommitteeHeadID`);

--
-- Indexes for table `CommitteeMember`
--
ALTER TABLE `CommitteeMember`
  ADD PRIMARY KEY (`CommitteeMemberID`),
  ADD UNIQUE KEY `BatchMemberID` (`BatchMemberID`),
  ADD KEY `FK_CommitteeMember_CommitteeID` (`CommitteeID`);

--
-- Indexes for table `CommitteePermission`
--
ALTER TABLE `CommitteePermission`
  ADD PRIMARY KEY (`CommitteePermissionID`),
  ADD KEY `FK_CommitteePermission_CommitteeID` (`CommitteeID`),
  ADD KEY `FK_CommitteePermission_MemberTypeID` (`MemberTypeID`);

--
-- Indexes for table `Event`
--
ALTER TABLE `Event`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `FK_Event_EventOwner` (`EventOwner`);

--
-- Indexes for table `LedgerInput`
--
ALTER TABLE `LedgerInput`
  ADD PRIMARY KEY (`LedgerInputID`),
  ADD KEY `FK_LedgerInput_BatchMemberID` (`BatchMemberID`);

--
-- Indexes for table `Member`
--
ALTER TABLE `Member`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `MemberType`
--
ALTER TABLE `MemberType`
  ADD PRIMARY KEY (`MemberTypeID`);

--
-- Indexes for table `StaticData`
--
ALTER TABLE `StaticData`
  ADD PRIMARY KEY (`StaticDataID`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`TaskID`),
  ADD KEY `FK_Task_ParentTaskID` (`ParentTaskID`),
  ADD KEY `FK_Task_TaskStatusID` (`TaskStatusID`),
  ADD KEY `FK_Task_EventID` (`EventID`),
  ADD KEY `FK_Task_Reporter` (`Reporter`),
  ADD KEY `FK_Task_Assignee` (`Assignee`);

--
-- Indexes for table `TaskComment`
--
ALTER TABLE `TaskComment`
  ADD PRIMARY KEY (`TaskCommentID`),
  ADD KEY `FK_TaskComment_TaskID` (`TaskID`),
  ADD KEY `FK_TaskComment_TaskSubscriberID` (`TaskSubscriberID`);

--
-- Indexes for table `TaskStatus`
--
ALTER TABLE `TaskStatus`
  ADD PRIMARY KEY (`TaskStatusID`);

--
-- Indexes for table `TaskSubscriber`
--
ALTER TABLE `TaskSubscriber`
  ADD PRIMARY KEY (`TaskSubscriberID`),
  ADD KEY `FK_TaskSubscriber_TaskID` (`TaskID`),
  ADD KEY `FK_TaskSubscriber_BatchMemberID` (`BatchMemberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AvailabilityGroup`
--
ALTER TABLE `AvailabilityGroup`
  MODIFY `AvailabilityGroupID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `AvailabilityGroupMember`
--
ALTER TABLE `AvailabilityGroupMember`
  MODIFY `AvailabilityGroupMemberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `AvailabilityMember`
--
ALTER TABLE `AvailabilityMember`
  MODIFY `AvailabilityMemberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Batch`
--
ALTER TABLE `Batch`
  MODIFY `BatchID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `BatchMember`
--
ALTER TABLE `BatchMember`
  MODIFY `BatchMemberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `CommitteeMember`
--
ALTER TABLE `CommitteeMember`
  MODIFY `CommitteeMemberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LedgerInput`
--
ALTER TABLE `LedgerInput`
  MODIFY `LedgerInputID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Member`
--
ALTER TABLE `Member`
  MODIFY `MemberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `MemberType`
--
ALTER TABLE `MemberType`
  MODIFY `MemberTypeID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `StaticData`
--
ALTER TABLE `StaticData`
  MODIFY `StaticDataID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Task`
--
ALTER TABLE `Task`
  MODIFY `TaskID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TaskComment`
--
ALTER TABLE `TaskComment`
  MODIFY `TaskCommentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TaskStatus`
--
ALTER TABLE `TaskStatus`
  MODIFY `TaskStatusID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TaskSubscriber`
--
ALTER TABLE `TaskSubscriber`
  MODIFY `TaskSubscriberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `AvailabilityGroup`
--
ALTER TABLE `AvailabilityGroup`
  ADD CONSTRAINT `FK_AvailabilityGroup_FrontmanID` FOREIGN KEY (`FrontmanID`) REFERENCES `BatchMember` (`BatchMemberID`);

--
-- Constraints for table `AvailabilityGroupMember`
--
ALTER TABLE `AvailabilityGroupMember`
  ADD CONSTRAINT `FK_AvailabilityGroupMember_AvailabilityGroupID` FOREIGN KEY (`AvailabilityGroupID`) REFERENCES `AvailabilityGroup` (`AvailabilityGroupID`),
  ADD CONSTRAINT `FK_AvailabilityGroupMember_AvailabilityMemberID` FOREIGN KEY (`AvailabilityMemberID`) REFERENCES `AvailabilityMember` (`AvailabilityMemberID`);

--
-- Constraints for table `AvailabilityMember`
--
ALTER TABLE `AvailabilityMember`
  ADD CONSTRAINT `FK_AvailabilityMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`);

--
-- Constraints for table `BatchMember`
--
ALTER TABLE `BatchMember`
  ADD CONSTRAINT `FK_BatchMember_BatchID` FOREIGN KEY (`BatchID`) REFERENCES `Batch` (`BatchID`),
  ADD CONSTRAINT `FK_BatchMember_MemberID` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`),
  ADD CONSTRAINT `FK_BatchMember_MemberTypeID` FOREIGN KEY (`MemberTypeID`) REFERENCES `MemberType` (`MemberTypeID`);

--
-- Constraints for table `Committee`
--
ALTER TABLE `Committee`
  ADD CONSTRAINT `FK_Committee_CommitteeHeadID` FOREIGN KEY (`CommitteeHeadID`) REFERENCES `BatchMember` (`BatchMemberID`);

--
-- Constraints for table `CommitteeMember`
--
ALTER TABLE `CommitteeMember`
  ADD CONSTRAINT `FK_CommitteeMember_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`),
  ADD CONSTRAINT `FK_CommitteeMember_CommitteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `Committee` (`CommitteeID`);

--
-- Constraints for table `CommitteePermission`
--
ALTER TABLE `CommitteePermission`
  ADD CONSTRAINT `FK_CommitteePermission_CommitteeID` FOREIGN KEY (`CommitteeID`) REFERENCES `Committee` (`CommitteeID`),
  ADD CONSTRAINT `FK_CommitteePermission_MemberTypeID` FOREIGN KEY (`MemberTypeID`) REFERENCES `MemberType` (`MemberTypeID`);

--
-- Constraints for table `Event`
--
ALTER TABLE `Event`
  ADD CONSTRAINT `FK_Event_EventOwner` FOREIGN KEY (`EventOwner`) REFERENCES `BatchMember` (`BatchMemberID`);

--
-- Constraints for table `LedgerInput`
--
ALTER TABLE `LedgerInput`
  ADD CONSTRAINT `FK_LedgerInput_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`);

--
-- Constraints for table `Task`
--
ALTER TABLE `Task`
  ADD CONSTRAINT `FK_Task_Assignee` FOREIGN KEY (`Assignee`) REFERENCES `BatchMember` (`BatchMemberID`),
  ADD CONSTRAINT `FK_Task_EventID` FOREIGN KEY (`EventID`) REFERENCES `Event` (`EventID`),
  ADD CONSTRAINT `FK_Task_ParentTaskID` FOREIGN KEY (`ParentTaskID`) REFERENCES `Task` (`TaskID`),
  ADD CONSTRAINT `FK_Task_Reporter` FOREIGN KEY (`Reporter`) REFERENCES `BatchMember` (`BatchMemberID`),
  ADD CONSTRAINT `FK_Task_TaskStatusID` FOREIGN KEY (`TaskStatusID`) REFERENCES `TaskStatus` (`TaskStatusID`);

--
-- Constraints for table `TaskComment`
--
ALTER TABLE `TaskComment`
  ADD CONSTRAINT `FK_TaskComment_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`),
  ADD CONSTRAINT `FK_TaskComment_TaskSubscriberID` FOREIGN KEY (`TaskSubscriberID`) REFERENCES `TaskSubscriber` (`TaskSubscriberID`);

--
-- Constraints for table `TaskSubscriber`
--
ALTER TABLE `TaskSubscriber`
  ADD CONSTRAINT `FK_TaskSubscriber_BatchMemberID` FOREIGN KEY (`BatchMemberID`) REFERENCES `BatchMember` (`BatchMemberID`),
  ADD CONSTRAINT `FK_TaskSubscriber_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `Task` (`TaskID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
