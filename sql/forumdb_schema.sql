
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `date` datetime NOT NULL,
  `level` int(8) NOT NULL DEFAULT '1',
  `dp` varchar(500) NOT NULL COMMENT 'stores the file location of the users display pic',
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

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_date`, `user_level`, `user_dp`) VALUES
(1, 'admin', '22d7fe8c185003c98f97e5d6ced420c7', 'admin@example.com', CURDATE() , 1, ''),
(2, 'geek', 'c44a471bd78cc6c2fea32b9fe028d30a', 'geek@example.com', CURDATE(), 0, '');

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