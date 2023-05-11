-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2019 at 06:41 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dcloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE IF NOT EXISTS `directory` (
  `id` varchar(11) NOT NULL,
  `dir_id` varchar(11) NOT NULL,
  `dir_name` varchar(20) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'none' COMMENT 'root,none',
  `time` int(15) NOT NULL,
  PRIMARY KEY (`dir_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `dir_tree`
--

CREATE TABLE IF NOT EXISTS `dir_tree` (
  `dir_id` varchar(11) NOT NULL,
  `linked_dir_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `docfile`
--

CREATE TABLE IF NOT EXISTS `docfile` (
  `id` varchar(11) NOT NULL,
  `dir_id` varchar(11) NOT NULL,
  `doc_id` varchar(11) NOT NULL,
  `doc_path` varchar(50) NOT NULL,
  `doc_type` varchar(80) NOT NULL,
  `size` int(15) NOT NULL COMMENT 'size in byte 1000000000 = 1gb',
  `time` int(15) NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `docfile_share`
--

CREATE TABLE IF NOT EXISTS `docfile_share` (
  `id` varchar(11) NOT NULL,
  `share_id` varchar(11) NOT NULL,
  `doc_id` varchar(11) NOT NULL,
  `dir_id` varchar(11) NOT NULL,
  `share_type` varchar(10) NOT NULL COMMENT 'share to user, publicly',
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` varchar(11) NOT NULL,
  `group_id` varchar(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `decs` varchar(200) NOT NULL,
  `group_type` varchar(8) NOT NULL,
  `share_allow` varchar(8) NOT NULL,
  `grp_img` text NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'Live',
  `time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `group_admin`
--

CREATE TABLE IF NOT EXISTS `group_admin` (
  `group_id` varchar(11) NOT NULL,
  `admin_id` varchar(11) NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `group_member`
--

CREATE TABLE IF NOT EXISTS `group_member` (
  `group_id` varchar(11) NOT NULL,
  `member_id` varchar(11) NOT NULL,
  `join_type` varchar(15) NOT NULL COMMENT 'by admin,by invitation link',
  `add_by` varchar(11) NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `group_share`
--

CREATE TABLE IF NOT EXISTS `group_share` (
  `group_id` varchar(11) NOT NULL,
  `sender_id` varchar(11) NOT NULL,
  `share_id` varchar(11) NOT NULL,
  `message` text NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `login_user`
--

CREATE TABLE IF NOT EXISTS `login_user` (
  `id` varchar(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `user_status` varchar(8) NOT NULL DEFAULT 'Live' COMMENT 'Live / Block',
  `role` varchar(5) NOT NULL DEFAULT 'User',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `otps`
--

CREATE TABLE IF NOT EXISTS `otps` (
  `id` varchar(11) NOT NULL,
  `otp` int(8) NOT NULL,
  `type` varchar(8) NOT NULL COMMENT 'num,email or cp',
  `status` varchar(8) NOT NULL DEFAULT 'none' COMMENT 'none = not verified',
  `visited` varchar(4) NOT NULL DEFAULT 'no' COMMENT 'no = not visited',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sec_q`
--

CREATE TABLE IF NOT EXISTS `sec_q` (
  `id` varchar(11) NOT NULL,
  `quation` varchar(150) NOT NULL,
  `ans` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `share_privacy`
--

CREATE TABLE IF NOT EXISTS `share_privacy` (
  `id` varchar(11) NOT NULL,
  `share_id` varchar(11) NOT NULL,
  `share_title` varchar(50) NOT NULL,
  `share_type` varchar(15) NOT NULL,
  `privacy` varchar(15) NOT NULL DEFAULT 'none' COMMENT 'none,timeset,password',
  `starting_time` varchar(15) NOT NULL,
  `ending_time` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `time` int(15) NOT NULL,
  PRIMARY KEY (`share_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `share_to`
--

CREATE TABLE IF NOT EXISTS `share_to` (
  `id` varchar(11) NOT NULL,
  `share_id` varchar(11) NOT NULL,
  `share_user` varchar(11) NOT NULL,
  `share_grp` varchar(11) NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `user_reg`
--

CREATE TABLE IF NOT EXISTS `user_reg` (
  `id` varchar(11) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `phone_num` varchar(15) DEFAULT NULL,
  `Dob` varchar(10) NOT NULL,
  `profile_pic` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
