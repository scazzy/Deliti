-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2014 at 08:38 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `db_vroom`
--
CREATE DATABASE IF NOT EXISTS `db_vroom` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_vroom`;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE IF NOT EXISTS `chat_message` (
  `msg_id` int(50) NOT NULL AUTO_INCREMENT,
  `participant_id` int(11) DEFAULT NULL,
  `room_key` varchar(15) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `timeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`),
  KEY `room_key` (`room_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) DEFAULT NULL,
  `country_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

-- --------------------------------------------------------

--
-- Table structure for table `invitees`
--

CREATE TABLE IF NOT EXISTS `invitees` (
  `invitee_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_email` varchar(50) DEFAULT NULL,
  `room_key` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`invitee_id`),
  KEY `room_key` (`room_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `live_attendees`
--

CREATE TABLE IF NOT EXISTS `live_attendees` (
  `participant_id` int(11) NOT NULL,
  `room_key` varchar(15) NOT NULL,
  KEY `room_key` (`room_key`),
  KEY `participant_id` (`participant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `participant_details`
--

CREATE TABLE IF NOT EXISTS `participant_details` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `prt_name` varchar(50) DEFAULT NULL,
  `prt_email` varchar(80) DEFAULT NULL,
  `room_key` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prt_gender` char(1) DEFAULT NULL,
  `prt_job` varchar(30) DEFAULT NULL,
  `prt_org` varchar(30) DEFAULT NULL,
  `prt_enter_dt` datetime DEFAULT NULL,
  `prt_leave_dt` datetime DEFAULT NULL,
  `prt_noteText` longtext,
  `prt_feedback` text,
  `prt_geo_location` varchar(25) DEFAULT NULL,
  `prt_IP` varchar(19) DEFAULT NULL,
  `prt_browser` varchar(50) DEFAULT NULL,
  `prt_OS` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`participant_id`),
  KEY `room_key` (`room_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `room_details`
--

CREATE TABLE IF NOT EXISTS `room_details` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_key` varchar(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(78) DEFAULT NULL,
  `agenda` varchar(255) DEFAULT NULL,
  `start_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_dt` datetime DEFAULT NULL,
  `chat_script_url` text,
  `drawpad_url` text,
  `video_recorded_url` text,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `room_key` (`room_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE IF NOT EXISTS `security_questions` (
  `secQ_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_question` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`secQ_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `set_name` varchar(50) NOT NULL,
  `set_value` int(50) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `sharedfiles`
--

CREATE TABLE IF NOT EXISTS `sharedfiles` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(150) NOT NULL,
  `file_size` float DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_url` varchar(150) NOT NULL,
  `roomkey` varchar(20) DEFAULT NULL,
  `participant_id` int(20) NOT NULL,
  `uploadedOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fileId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `usr_fname` varchar(30) NOT NULL,
  `usr_lname` varchar(30) NOT NULL,
  `usr_email` varchar(80) NOT NULL,
  `usr_pwd` varchar(80) NOT NULL,
  `usr_phone` varchar(15) DEFAULT NULL,
  `usr_gender` char(1) NOT NULL,
  `usr_country` int(11) DEFAULT NULL,
  `usr_job` varchar(30) DEFAULT NULL,
  `usr_org` varchar(30) DEFAULT NULL,
  `usr_secQuestion` int(11) NOT NULL,
  `usr_secQ_Answer` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `usr_email` (`usr_email`),
  UNIQUE KEY `usr_email_2` (`usr_email`),
  KEY `usr_country` (`usr_country`),
  KEY `usr_secQuestion` (`usr_secQuestion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `log_detail` varchar(100) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `IPaddr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
