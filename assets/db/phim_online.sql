-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2021 at 01:13 PM
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
  `fullname` varchar(100) DEFAULT NULL,
  `ava_url` varchar(256) DEFAULT NULL,
  `acc_type` int(11) NOT NULL DEFAULT 0,
  `tel_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `fullname`, `ava_url`, `acc_type`, `tel_no`, `email`) VALUES
(1, 'thaian229', '22114455', 'Nguyen Thai An', 'uploads/avatars/ava_1.jpg', 0, '0966711928', 'thaian229@gmail.com'),
(2, 'mhoang99', '123456', NULL, NULL, 0, NULL, NULL),
(3, 'buituhoang', '123456', NULL, NULL, 0, NULL, NULL),
(4, 'admin1', 'admin1', NULL, 'https://fiverr-res.cloudinary.com/images/q_auto,f_auto/gigs/21760012/original/d4c0c142f91f012c9a8a9c9aeef3bac28036f15b/create-your-cartoon-style-flat-avatar-or-icon.jpg', 1, NULL, NULL),
(5, 'admin2', 'admin2', NULL, 'https://cdn3.iconfinder.com/data/icons/business-avatar-1/512/11_avatar-512.png', 1, NULL, NULL),
(6, 'an002', '22114455', NULL, 'uploads/avatars/ava_6.jpg', 0, '', '');

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
(8, 'automobile'),
(7, 'culture'),
(6, 'education'),
(4, 'food'),
(9, 'game'),
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
(2, 'M1 iMac Review - Better and Worse', 'https://www.youtube.com/embed/E59xZyDFiJ8', 'http://i3.ytimg.com/vi/E59xZyDFiJ8/maxresdefault.jpg', '2021-05-19 10:45:20', 1, 1, 0),
(3, 'Don\'t wait for the Switch Pro, Buy This Today!', 'https://www.youtube.com/embed/52vo1g4VBbc', 'http://i3.ytimg.com/vi/52vo1g4VBbc/maxresdefault.jpg', '2021-05-19 10:45:58', 0, 0, 0),
(4, 'Uncle Roger Review NICK DIGIOVANNI Ramen (Masterchef Finalist)', 'https://www.youtube.com/embed/myciX5_b1QY', 'http://i3.ytimg.com/vi/myciX5_b1QY/maxresdefault.jpg', '2021-05-19 10:46:48', 0, 0, 2),
(5, 'Resident Evil: Infinite Darkness | Official Trailer | Netflix', 'https://www.youtube.com/embed/P-js-Eww1OI', 'http://i3.ytimg.com/vi/P-js-Eww1OI/hqdefault.jpg', '2021-05-21 12:16:14', 0, 0, 0),
(6, 'The Big Problem with Manchester United\'s Stadium', 'https://www.youtube.com/embed/B87aESnOWKg', 'http://i3.ytimg.com/vi/B87aESnOWKg/hqdefault.jpg', '2021-05-21 12:16:14', 0, 0, 0),
(7, 'SOVIET REACTS TO SAMSUNG VIRTUAL ASSISTANT', 'https://www.youtube.com/watch?v=mC2lg-gCtUQ', 'uploads/thumbnails/TSVA1.jpg', '2021-06-05 11:14:11', 1, 0, 0),
(9, 'Samsung virtual assistant sam VS lady dimitrescu', 'https://www.youtube.com/embed/RVfCMVd9GYY', 'http://i3.ytimg.com/vi/RVfCMVd9GYY/maxresdefault.jpg', '2021-06-05 11:15:57', 7, 0, 0),
(10, 'Neural Networks from Scratch - P.5 Hidden Layer Activation Functions', 'https://www.youtube.com/embed/gmjzbpSVY1A', 'http://i3.ytimg.com/vi/gmjzbpSVY1A/maxresdefault.jpg', '2021-06-05 15:18:06', 0, 0, 0),
(11, 'Running a YouTube Business is EASY, Right?... WRONG!', 'https://www.youtube.com/embed/gC6dQrScmHE', 'http://i3.ytimg.com/vi/gC6dQrScmHE/maxresdefault.jpg', '2021-06-06 07:45:46', 0, 0, 0),
(13, 'Unreal Engine 5 Valley Of The Ancient Demo 4K | RTX 3090 | Ryzen 9 5950X', 'https://www.youtube.com/embed/UwHjuad47TE', 'http://i3.ytimg.com/vi/UwHjuad47TE/maxresdefault.jpg', '2021-06-06 11:08:05', 0, 0, 0),
(14, 'Onmyoji: The World - Official Cinematic Announcement Trailer', 'https://www.youtube.com/embed/P01gmaAm5cU', 'http://i3.ytimg.com/vi/P01gmaAm5cU/maxresdefault.jpg', '2021-06-06 11:08:56', 0, 0, 0),
(15, 'Gordon Ramsay Makes Steak and Eggs in Texas | Scrambled', 'https://www.youtube.com/embed/W1hd6y2JwUw', 'http://i3.ytimg.com/vi/W1hd6y2JwUw/maxresdefault.jpg', '2021-06-06 11:09:36', 0, 0, 0),
(16, 'The Unspoken Reality Behind the Harvard Gates | Alex Chang | TEDxSHSID', 'https://www.youtube.com/embed/kJGupYFaCGs', 'http://i3.ytimg.com/vi/kJGupYFaCGs/maxresdefault.jpg', '2021-06-06 11:10:14', 0, 0, 0),
(17, 'POV: You main Tiandi', 'https://www.youtube.com/embed/j4p7P5WTnoY', 'http://i3.ytimg.com/vi/j4p7P5WTnoY/maxresdefault.jpg', '2021-06-06 11:10:50', 0, 0, 0);

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
(4, 4),
(7, 1),
(7, 2),
(7, 5),
(9, 1),
(9, 3),
(9, 5),
(10, 3),
(10, 5),
(11, 1),
(11, 5);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
