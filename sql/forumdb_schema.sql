-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2016 at 07:40 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forumdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `last_update`) VALUES
(1, 'SmartPhones', 'Discussions about different smartphone releases , different platforms and OS. Android , IOS, Blackberry...', '2016-03-08 10:57:44'),
(2, 'Internet of Things', 'This category deals with all the discussion related to IoT revolution and  upcoming IoT devices and tech.', '2016-03-08 10:57:44'),
(3, 'Tech Startups', 'Discussions about new tech startups!', '2016-03-08 10:57:44'),
(4, 'Wearables', 'This category deals with the all the wearables coming up by different tech- organisations. Eg. Android wear, Apple watch.', '2016-03-08 10:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `topic` int(8) NOT NULL,
  `user` int(8) NOT NULL,
  `upvotes` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'donotes the no. of upvotes on an answer',
  `downvotes` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'donotes the no. of downvotes on an answer',
  PRIMARY KEY (`id`),
  KEY `post_by` (`user`),
  KEY `post_topic` (`topic`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `replys`
--

DROP TABLE IF EXISTS `replys`;
CREATE TABLE IF NOT EXISTS `replys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `post` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post` (`post`),
  KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `date` datetime NOT NULL,
  `cat` int(8) NOT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_cat` (`cat`),
  KEY `topic_by` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(8) NOT NULL DEFAULT '0',
  `dp` text NOT NULL COMMENT 'stores the file location of the users display pic',
  `signup` timestamp NOT NULL COMMENT 'timestamp for user signup datetime',
  `last_signin` timestamp NULL DEFAULT NULL COMMENT 'timestamp to record user''s last login',
  `last_signout` timestamp NULL DEFAULT NULL COMMENT 'timestamp to record user''s last logout',
  `clef` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name_unique` (`name`),
  UNIQUE KEY `user_email` (`email`),
  UNIQUE KEY `user_email_2` (`email`),
  UNIQUE KEY `user_email_3` (`email`),
  KEY `user_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `email`, `level`, `dp`, `signup`, `last_signin`, `last_signout`, `clef`) VALUES
(1, 'superuser', '5f4dcc3b5aa765d61d8327deb882cf99', 'superuser@example.com', 1, 'res/default_dp.jpg', 'CURRENT_TIMESTAMP()', NULL, NULL, NULL),
(2, 'geek', '22d7fe8c185003c98f97e5d6ced420c7', 'geek@example.com', 0, 'res/default_dp.jpg', 'CURRENT_TIMESTAMP()', NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`topic`) REFERENCES `topics` (`id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
