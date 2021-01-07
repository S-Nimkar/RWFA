-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 31, 2020 at 11:57 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `krqnscqx_RWFA`
--

-- --------------------------------------------------------

--
-- Table structure for table `Journal`
--

CREATE TABLE `Journal` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Topic` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Finished` tinyint(1) NOT NULL DEFAULT '0',
  `Goal` varchar(200) NOT NULL,
  `LastRecord` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ReflectiveWritingEntry`
--

CREATE TABLE `ReflectiveWritingEntry` (
  `ID` int(11) NOT NULL,
  `JournalID` int(11) NOT NULL,
  `FeedbackID` int(11) DEFAULT NULL,
  `Agenda` enum('Lecture','Seminar','Workshop','Independent Work','Tutorial','Assessment Draft','Other') NOT NULL,
  `Entry` text NOT NULL,
  `Record` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ReflectiveWritingEntry`
--

CREATE TABLE `RWEFeedback` (
  `ID` int(11) NOT NULL,
  `WordCount` int(11) NOT NULL,
  `Positive` text NOT NULL,
  `Negative` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `System`
--

CREATE TABLE `System` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `SysGroup` enum('User','Admin') NOT NULL DEFAULT 'User',
  `Username` varchar(30) NOT NULL,
  `Password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `ID` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `secondName` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Journal`
--
ALTER TABLE `Journal`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `ReflectiveWritingEntry`
--
ALTER TABLE `ReflectiveWritingEntry`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `JournalID` (`JournalID`) USING BTREE,
  ADD KEY `FeedbackID` (`FeedbackID`) USING BTREE;

--
-- Indexes for table `RWEFeedback`
--
ALTER TABLE `RWEFeedback`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `System`
--
ALTER TABLE `System`
  ADD PRIMARY KEY (`ID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Journal`
--
ALTER TABLE `Journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ReflectiveWritingEntry`
--
ALTER TABLE `ReflectiveWritingEntry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Journal`
--
ALTER TABLE `RWEFeedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `System`
--
ALTER TABLE `System`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Journal`
--
ALTER TABLE `Journal`
  ADD CONSTRAINT `UserJournalLink` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ReflectiveWritingEntry`
--
ALTER TABLE `ReflectiveWritingEntry`
  ADD CONSTRAINT `JournalRWELink` FOREIGN KEY (`JournalID`) REFERENCES `Journal` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
  ADD CONSTRAINT `FeedbackLink` FOREIGN KEY (`FeedbackID`) REFERENCES `RWEFeedback` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `System`
--
ALTER TABLE `System`
  ADD CONSTRAINT `SystemUserLink` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

