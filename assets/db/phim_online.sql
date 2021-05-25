-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2021 at 01:32 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phim_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `ava_url` varchar(256) DEFAULT NULL,
  `acc_type` int(11) NOT NULL DEFAULT 0,
  `tel_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `ava_url`, `acc_type`, `tel_no`, `email`) VALUES
(1, 'thaian', '22114455', 'uploads/avatars/ava_1.jpg', 0, NULL, NULL),
(2, 'mhoang99', '123456', NULL, 0, NULL, NULL),
(3, 'buituhoang', '123456', NULL, 0, NULL, NULL),
(4, 'admin1', 'admin1', 'https://fiverr-res.cloudinary.com/images/q_auto,f_auto/gigs/21760012/original/d4c0c142f91f012c9a8a9c9aeef3bac28036f15b/create-your-cartoon-style-flat-avatar-or-icon.jpg', 1, NULL, NULL),
(5, 'admin2', 'admin2', 'https://cdn3.iconfinder.com/data/icons/business-avatar-1/512/11_avatar-512.png', 1, NULL, NULL),
(6, 'an002', '22114455', 'uploads/avatars/ava_6.jpg', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'food'),
(5, 'movie'),
(1, 'music'),
(2, 'sport'),
(3, 'technology');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `contents` varchar(256) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `acc_id`, `video_id`, `contents`, `created_time`) VALUES
(1, 1, 2, 'Test comment 1', '2021-05-21 10:09:47'),
(2, 2, 2, 'Test comment 2', '2021-05-21 10:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `acc_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`acc_id`, `video_id`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `video_url` varchar(256) NOT NULL,
  `thumbnail_url` varchar(256) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `video_url`, `thumbnail_url`, `created_time`, `views`, `upvotes`, `downvotes`) VALUES
(2, 'M1 iMac Review - Better and Worse', 'https://www.youtube.com/watch?v=E59xZyDFiJ8', 'https://www.wyzowl.com/wp-content/uploads/2019/09/YouTube-thumbnail-size-guide-best-practices-top-examples.png', '2021-05-19 10:45:20', 0, 1, 0),
(3, 'Don\'t wait for the Switch Pro, Buy This Today!', 'https://www.youtube.com/watch?v=52vo1g4VBbc&ab_channel=LinusTechTipsLinusTechTipsVerified', 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/youtube-thumbnail-retrowave-design-template-facd275829297c4a471f2f1af6436508_screen.jpg?ts=1561496227', '2021-05-19 10:45:58', 0, 0, 0),
(4, 'Uncle Roger Review NICK DIGIOVANNI Ramen (Masterchef Finalist)', 'https://www.youtube.com/watch?v=myciX5_b1QY&ab_channel=mrnigelngmrnigelngVerified', 'https://s29843.pcdn.co/blog/wp-content/uploads/sites/2/2021/02/video-thumbnails-social.png', '2021-05-19 10:46:48', 0, 0, 2),
(5, 'Resident Evil: Infinite Darkness | Official Trailer | Netflix', 'https://www.youtube.com/watch?v=P-js-Eww1OI', 'http://i3.ytimg.com/vi/P-js-Eww1OI/hqdefault.jpg', '2021-05-21 12:16:14', 0, 0, 0),
(6, 'The Big Problem with Manchester United\'s Stadium', 'https://www.youtube.com/watch?v=B87aESnOWKg&ab_channel=TifoFootballTifoFootballVerified', 'http://i3.ytimg.com/vi/B87aESnOWKg/hqdefault.jpg', '2021-05-21 12:16:14', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `videos_categories`
--

CREATE TABLE `videos_categories` (
  `video_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `videos_categories`
--

INSERT INTO `videos_categories` (`video_id`, `cat_id`) VALUES
(2, 3),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `acc_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `vote_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`acc_id`, `video_id`, `vote_type`) VALUES
(1, 2, 1),
(2, 4, 0),
(3, 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_index` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_name_index` (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk1_acc_id` (`acc_id`),
  ADD KEY `fk2_video_id` (`video_id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`acc_id`,`video_id`),
  ADD KEY `fk2_fav_video_id` (`video_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos_categories`
--
ALTER TABLE `videos_categories`
  ADD PRIMARY KEY (`video_id`,`cat_id`),
  ADD KEY `fk2_vc_cat_id` (`cat_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`acc_id`,`video_id`),
  ADD KEY `fk2_vote_video_id` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk1_acc_id` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_video_id` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `fk1_fav_acc_id` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_fav_video_id` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `videos_categories`
--
ALTER TABLE `videos_categories`
  ADD CONSTRAINT `fk1_vc_video_id` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_vc_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk1_vote_acc_id` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_vote_video_id` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
