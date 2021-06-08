-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 06:58 PM
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
(8, 'user', '$2y$10$JYXZVz7B3XRLeD7OXgp3U.5fJkvd/21Ar4oo2gwJF/v3nqMDESYVS', 'I Am The User', 'https://www.xeus.com/wp-content/uploads/2014/09/One_User_Orange.png', 0, '0123456789', 'user@gmail.com'),
(9, 'admin', '$2y$10$w1Ks7N3YX96/1eQLcLCjPeUGiHvDw365M3.w/FIxPn1vKq/dasGQ2', 'I Am The Admin', 'uploads/avatars/ava9.jpg', 1, '0123456789', 'admin@yahoo.com');

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
(2, 2, 2, 'Test comment 2', '2021-05-21 10:09:47'),
(3, 9, 13, 'Very good job', '2021-06-08 14:24:41'),
(4, 9, 2, 'Perfect SOC', '2021-06-08 14:36:13');

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
(1, 3),
(8, 2),
(8, 9),
(9, 13);

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
(2, 'M1 iMac Review - Better and Worse', 'https://www.youtube.com/embed/E59xZyDFiJ8', 'http://i3.ytimg.com/vi/E59xZyDFiJ8/maxresdefault.jpg', '2021-06-08 16:47:19', 8, 2, 0),
(3, 'Don\'t wait for the Switch Pro, Buy This Today!', 'https://www.youtube.com/embed/52vo1g4VBbc', 'http://i3.ytimg.com/vi/52vo1g4VBbc/maxresdefault.jpg', '2021-06-08 16:47:33', 1, 0, 0),
(4, 'Uncle Roger Review NICK DIGIOVANNI Ramen (Masterchef Finalist)', 'https://www.youtube.com/embed/myciX5_b1QY', 'http://i3.ytimg.com/vi/myciX5_b1QY/maxresdefault.jpg', '2021-06-08 16:47:41', 1, 0, 2),
(5, 'Resident Evil: Infinite Darkness | Official Trailer | Netflix', 'https://www.youtube.com/embed/P-js-Eww1OI', 'http://i3.ytimg.com/vi/P-js-Eww1OI/hqdefault.jpg', '2021-06-08 16:47:50', 0, 0, 0),
(6, 'The Big Problem with Manchester United\'s Stadium', 'https://www.youtube.com/embed/B87aESnOWKg', 'http://i3.ytimg.com/vi/B87aESnOWKg/hqdefault.jpg', '2021-06-08 16:48:01', 1, 0, 0),
(7, 'SOVIET REACTS TO SAMSUNG VIRTUAL ASSISTANT', 'https://www.youtube.com/embed/mC2lg-gCtUQ', 'uploads/thumbnails/TSVA1.jpg', '2021-06-08 16:48:15', 9, 0, 0),
(9, 'Samsung virtual assistant sam VS lady dimitrescu', 'https://www.youtube.com/embed/RVfCMVd9GYY', 'http://i3.ytimg.com/vi/RVfCMVd9GYY/maxresdefault.jpg', '2021-06-08 16:48:29', 9, 0, 0),
(10, 'Neural Networks from Scratch - P.5 Hidden Layer Activation Functions', 'https://www.youtube.com/embed/gmjzbpSVY1A', 'http://i3.ytimg.com/vi/gmjzbpSVY1A/maxresdefault.jpg', '2021-06-08 16:48:38', 0, 0, 0),
(11, 'Running a YouTube Business is EASY, Right?... WRONG!', 'https://www.youtube.com/embed/gC6dQrScmHE', 'http://i3.ytimg.com/vi/gC6dQrScmHE/maxresdefault.jpg', '2021-06-08 16:48:58', 0, 0, 0),
(13, 'Unreal Engine 5 Valley Of The Ancient Demo 4K | RTX 3090 | Ryzen 9 5950X', 'https://www.youtube.com/embed/UwHjuad47TE', 'http://i3.ytimg.com/vi/UwHjuad47TE/maxresdefault.jpg', '2021-06-08 16:49:20', 3, 1, 0),
(14, 'Onmyoji: The World - Official Cinematic Announcement Trailer', 'https://www.youtube.com/embed/P01gmaAm5cU', 'http://i3.ytimg.com/vi/P01gmaAm5cU/maxresdefault.jpg', '2021-06-08 16:49:32', 1, 0, 0),
(15, 'Gordon Ramsay Makes Steak and Eggs in Texas | Scrambled', 'https://www.youtube.com/embed/W1hd6y2JwUw', 'http://i3.ytimg.com/vi/W1hd6y2JwUw/maxresdefault.jpg', '2021-06-08 16:49:44', 0, 0, 0),
(16, 'The Unspoken Reality Behind the Harvard Gates | Alex Chang | TEDxSHSID', 'https://www.youtube.com/embed/kJGupYFaCGs', 'http://i3.ytimg.com/vi/kJGupYFaCGs/maxresdefault.jpg', '2021-06-08 16:49:56', 0, 0, 0),
(17, 'POV: You main Tiandi', 'https://www.youtube.com/embed/j4p7P5WTnoY', 'http://i3.ytimg.com/vi/j4p7P5WTnoY/maxresdefault.jpg', '2021-06-08 16:50:06', 0, 0, 0),
(25, 'Norah Jones Best Songs Collection 2021', 'https://www.youtube.com/embed/U7sUjd2SAh0', 'https://i2.ytimg.com/vi/U7sUjd2SAh0/hqdefault.jpg', '2021-06-08 16:50:18', 1, 0, 0),
(26, 'WEDNESDAY MORNING JAZZ: Positive Sweet Morning Music & Relax Good Mood Jazz & Bossa Nova', 'https://www.youtube.com/embed/lnKSTNf_mQA', 'https://i1.ytimg.com/vi/lnKSTNf_mQA/hqdefault.jpg', '2021-06-08 16:50:28', 0, 0, 0),
(27, 'Night Chill: Lofi Hip Hop Mix / Jazzhop - Stress Relief, Relaxing Music', 'https://www.youtube.com/embed/KNA9hFcYqrA', 'https://i4.ytimg.com/vi/KNA9hFcYqrA/hqdefault.jpg', '2021-06-08 16:50:38', 1, 0, 0),
(28, 'Study Coffee: Elegant June Jazz - Exquisite Mood Jazz Music for Study', 'https://www.youtube.com/embed/9YR2X_cbUB4', 'https://i2.ytimg.com/vi/9YR2X_cbUB4/hqdefault.jpg', '2021-06-08 16:50:47', 1, 0, 0),
(29, 'Building a Mazda RX8 in 10 Minutes!', 'https://www.youtube.com/embed/0tXISIUSo6k', 'https://i1.ytimg.com/vi/0tXISIUSo6k/hqdefault.jpg', '2021-06-08 16:50:59', 2, 0, 0),
(30, 'Drifting a Widebody 1000HP S14!', 'https://www.youtube.com/embed/2SNHFAJZpQo', 'https://i3.ytimg.com/vi/2SNHFAJZpQo/hqdefault.jpg', '2021-06-08 16:51:08', 0, 0, 0),
(31, 'The BEST First Cars To Own!', 'https://www.youtube.com/embed/FdgstiPTkgs', 'https://i3.ytimg.com/vi/FdgstiPTkgs/hqdefault.jpg', '2021-06-08 16:51:18', 0, 0, 0),
(32, 'Most Underrated Tire You Need To Know About!', 'https://www.youtube.com/embed/i1bBasZL6Og', 'https://i2.ytimg.com/vi/i1bBasZL6Og/hqdefault.jpg', '2021-06-08 16:51:30', 0, 0, 0),
(33, 'I Made Giant 30-Pound Oreos, Tasty', 'https://www.youtube.com/embed/2pyIk71sUTc', 'https://i3.ytimg.com/vi/2pyIk71sUTc/hqdefault.jpg', '2021-06-08 16:51:44', 0, 0, 0),
(34, 'Rice In Mumbai, Tokyo, and Mexico City', 'https://www.youtube.com/embed/A_J6IIsyhSg', 'https://i2.ytimg.com/vi/A_J6IIsyhSg/hqdefault.jpg', '2021-06-08 16:51:52', 0, 0, 0),
(35, 'French Onion Burgers With Truffle Mayo', 'https://www.youtube.com/embed/E4hXc5oISQ0', 'https://i2.ytimg.com/vi/E4hXc5oISQ0/hqdefault.jpg', '2021-06-08 16:52:03', 0, 0, 0),
(36, 'I Recreated The Viral Boba Pancakes From Taiwan', 'https://www.youtube.com/embed/YQ4CsuGmgGg', 'https://i2.ytimg.com/vi/YQ4CsuGmgGg/hqdefault.jpg', '2021-06-08 16:52:12', 0, 0, 0),
(37, 'Doctor Strange 2: In The Multiverse of Madness', 'https://www.youtube.com/embed/us2OykHa5lU', 'https://i2.ytimg.com/vi/us2OykHa5lU/hqdefault.jpg', '2021-06-08 16:52:22', 0, 0, 0),
(38, 'Black Panther 2: Wakanda Forever', 'https://www.youtube.com/embed/XAFmu0cLz9Y', 'https://i1.ytimg.com/vi/XAFmu0cLz9Y/hqdefault.jpg', '2021-06-08 16:52:29', 0, 0, 0),
(39, 'Justice League 2: The Snyder-Verse', 'https://www.youtube.com/embed/aPL31Hcau3M', 'https://i2.ytimg.com/vi/aPL31Hcau3M/hqdefault.jpg', '2021-06-08 16:52:39', 0, 0, 0),
(40, 'The Truth About Vaccines', 'https://www.youtube.com/embed/bVi-GlOY9iM', 'https://i3.ytimg.com/vi/bVi-GlOY9iM/hqdefault.jpg', '2021-06-08 16:52:53', 0, 0, 0),
(41, 'How Alcohol Changes Your Body', 'https://www.youtube.com/embed/KWQpV9_kUUM', 'https://i4.ytimg.com/vi/KWQpV9_kUUM/hqdefault.jpg', '2021-06-08 16:53:06', 0, 0, 0),
(42, 'What Happens When You Quit Marijuana?', 'https://www.youtube.com/embed/7u_cm5b1s7Y', 'https://i4.ytimg.com/vi/7u_cm5b1s7Y/hqdefault.jpg', '2021-06-08 16:53:14', 0, 0, 0),
(43, 'Is cracking your knuckles bad for you?', 'https://www.youtube.com/embed/6rntjQib3SA', 'https://i3.ytimg.com/vi/6rntjQib3SA/hqdefault.jpg', '2021-06-08 16:53:24', 0, 0, 0),
(44, 'The Top 10 Incredible Players Who Are Cursed to Never Win', 'https://www.youtube.com/embed/bi9bBNYSLzQ', 'https://i3.ytimg.com/vi/bi9bBNYSLzQ/hqdefault.jpg', '2021-06-08 16:53:39', 0, 0, 0),
(45, 'What Is The PERFECT Crosshair?', 'https://www.youtube.com/embed/mzlZyVx9yC4', 'https://i2.ytimg.com/vi/mzlZyVx9yC4/hqdefault.jpg', '2021-06-08 16:53:54', 0, 0, 0),
(46, 'Icebox: How Valorant\'s Worst Map Became Its Most Important', 'https://www.youtube.com/embed/z7_PgY-PNwM', 'https://i3.ytimg.com/vi/z7_PgY-PNwM/hqdefault.jpg', '2021-06-08 16:41:50', 0, 0, 0),
(47, '10 NEW BROKEN Korean Builds YOU SHOULD ABUSE In Patch 11.12 - League of Legends', 'https://www.youtube.com/embed/Rm_obB2NdYo', 'https://i3.ytimg.com/vi/Rm_obB2NdYo/hqdefault.jpg', '2021-06-08 16:54:37', 0, 0, 0),
(48, 'Must See Sports Moments of May 2021', 'https://www.youtube.com/embed/uNfP7Mn5VzM', 'https://i2.ytimg.com/vi/uNfP7Mn5VzM/hqdefault.jpg', '2021-06-08 16:54:23', 1, 0, 0),
(49, 'Top 10 Buzzer Beaters from ACC College Basketball', 'https://www.youtube.com/embed/Vuflv0p9HOg', 'https://i3.ytimg.com/vi/Vuflv0p9HOg/hqdefault.jpg', '2021-06-08 16:54:15', 0, 0, 0),
(50, 'Best Kickoff Return Touchdowns from ACC College Football', 'https://www.youtube.com/embed/9brVmGuDVC0', 'https://i2.ytimg.com/vi/9brVmGuDVC0/hqdefault.jpg', '2021-06-08 16:54:06', 1, 0, 0),
(51, 'Best Music Mix ♫ No Copyright EDM ♫ Gaming Music Trap, House, Dubstep', 'https://www.youtube.com/embed/LaQj636PJh0', 'http://i3.ytimg.com/vi/LaQj636PJh0/maxresdefault.jpg', '2021-06-08 16:58:09', 0, 0, 0);

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
(3, 6),
(4, 4),
(4, 7),
(5, 5),
(5, 9),
(6, 2),
(7, 1),
(7, 3),
(7, 7),
(9, 3),
(9, 7),
(9, 9),
(10, 3),
(10, 6),
(11, 3),
(11, 6),
(13, 3),
(13, 9),
(14, 9),
(15, 4),
(15, 7),
(16, 6),
(17, 9),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 3),
(29, 8),
(30, 3),
(30, 8),
(31, 3),
(31, 8),
(32, 3),
(32, 6),
(32, 8),
(33, 4),
(33, 7),
(34, 4),
(34, 7),
(35, 4),
(35, 7),
(36, 4),
(36, 7),
(37, 5),
(38, 5),
(39, 5),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 2),
(44, 9),
(45, 2),
(45, 9),
(47, 2),
(47, 9),
(48, 2),
(49, 2),
(50, 2),
(51, 1),
(51, 9);

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
(3, 4, 0),
(9, 2, 1),
(9, 13, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
