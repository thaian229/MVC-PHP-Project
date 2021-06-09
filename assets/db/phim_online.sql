-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 06:45 AM
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
(1, 'Volvo P1800 Cyan Racing 424bhp/tonne Restomod vs original | Top Gear RETROspective', 'https://www.youtube.com/embed/gzg0kx_g-vo?version=3', 'https://i4.ytimg.com/vi/gzg0kx_g-vo/hqdefault.jpg', '2021-06-08 17:43:44', 0, 0, 0),
(2, 'M1 iMac Review - Better and Worse', 'https://www.youtube.com/embed/E59xZyDFiJ8', 'http://i3.ytimg.com/vi/E59xZyDFiJ8/maxresdefault.jpg', '2021-06-08 16:47:19', 8, 2, 0),
(3, 'Don\'t wait for the Switch Pro, Buy This Today!', 'https://www.youtube.com/embed/52vo1g4VBbc', 'http://i3.ytimg.com/vi/52vo1g4VBbc/maxresdefault.jpg', '2021-06-08 16:47:33', 1, 0, 0),
(4, 'Uncle Roger Review NICK DIGIOVANNI Ramen (Masterchef Finalist)', 'https://www.youtube.com/embed/myciX5_b1QY', 'http://i3.ytimg.com/vi/myciX5_b1QY/maxresdefault.jpg', '2021-06-08 16:47:41', 1, 0, 2),
(5, 'Resident Evil: Infinite Darkness | Official Trailer | Netflix', 'https://www.youtube.com/embed/P-js-Eww1OI', 'http://i3.ytimg.com/vi/P-js-Eww1OI/hqdefault.jpg', '2021-06-08 16:47:50', 0, 0, 0),
(6, 'The Big Problem with Manchester United\'s Stadium', 'https://www.youtube.com/embed/B87aESnOWKg', 'http://i3.ytimg.com/vi/B87aESnOWKg/hqdefault.jpg', '2021-06-08 16:48:01', 1, 0, 0),
(7, 'SOVIET REACTS TO SAMSUNG VIRTUAL ASSISTANT', 'https://www.youtube.com/embed/mC2lg-gCtUQ', 'uploads/thumbnails/TSVA1.jpg', '2021-06-08 16:48:15', 10, 0, 0),
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
(29, 'Building a Mazda RX8 in 10 Minutes!', 'https://www.youtube.com/embed/0tXISIUSo6k', 'https://i1.ytimg.com/vi/0tXISIUSo6k/hqdefault.jpg', '2021-06-08 16:50:59', 3, 0, 0),
(30, 'Drifting a Widebody 1000HP S14!', 'https://www.youtube.com/embed/2SNHFAJZpQo', 'https://i3.ytimg.com/vi/2SNHFAJZpQo/hqdefault.jpg', '2021-06-08 16:51:08', 1, 0, 0),
(31, 'The BEST First Cars To Own!', 'https://www.youtube.com/embed/FdgstiPTkgs', 'https://i3.ytimg.com/vi/FdgstiPTkgs/hqdefault.jpg', '2021-06-08 16:51:18', 1, 0, 0),
(32, 'Most Underrated Tire You Need To Know About!', 'https://www.youtube.com/embed/i1bBasZL6Og', 'https://i2.ytimg.com/vi/i1bBasZL6Og/hqdefault.jpg', '2021-06-08 16:51:30', 1, 0, 0),
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
(51, 'Best Music Mix ♫ No Copyright EDM ♫ Gaming Music Trap, House, Dubstep', 'https://www.youtube.com/embed/LaQj636PJh0', 'http://i3.ytimg.com/vi/LaQj636PJh0/maxresdefault.jpg', '2021-06-08 16:58:09', 1, 0, 0),
(52, 'Polestar 2 Review: Tesla Model 3 rival 0-60, range, charging, top speed, 1/4 mile | Top Gear', 'https://www.youtube.com/embed/gY9VVmbM2J8?version=3', 'https://i4.ytimg.com/vi/gY9VVmbM2J8/hqdefault.jpg', '2021-06-08 17:45:50', 0, 0, 0),
(53, 'Chris Harris Drives: Audi RS e-tron GT vs BMW M5 CS | Top Gear', 'https://www.youtube.com/embed/MFPpeXTEcDM?version=3', 'https://i2.ytimg.com/vi/MFPpeXTEcDM/hqdefault.jpg', '2021-06-08 17:48:18', 0, 0, 0),
(54, 'ULTIMATE £12m Aston Martin test! Victor, Vulcan, One-77, V8 Cygnet and Aston Motorbike | Top Gear', 'https://www.youtube.com/embed/gDGWj_TH3as?version=3', 'https://i4.ytimg.com/vi/gDGWj_TH3as/hqdefault.jpg', '2021-06-08 17:47:33', 0, 0, 0),
(55, 'Ferrari Monza vs McLaren Elva vs Aston Martin Speedster – £3.6m, 2,300bhp mega test | Top Gear', 'https://www.youtube.com/embed/AYRkMUDopcM?version=3', 'https://i2.ytimg.com/vi/AYRkMUDopcM/hqdefault.jpg', '2021-06-08 17:50:09', 1, 0, 0),
(56, 'UK\'S FASTEST CARS GO HEAD TO HEAD **DRAG RACING**', 'https://www.youtube.com/embed/Lmmjyb17diI?version=3', 'https://i1.ytimg.com/vi/Lmmjyb17diI/hqdefault.jpg', '2021-06-08 17:53:45', 1, 0, 0),
(57, 'Daoko「A(nima) HAPPY NEW TOUR 2021」@1/31 Shibuya Sakura Hall　Streaming on Saturday, March 13th, 2021！', 'https://www.youtube.com/embed/3XQZ3PGKVdQ?version=3', 'https://i4.ytimg.com/vi/3XQZ3PGKVdQ/hqdefault.jpg', '2021-06-08 17:54:58', 0, 0, 0),
(58, 'DAOKO 「アキレス腱」MUSIC VIDEO', 'https://www.youtube.com/embed/QHVTznQTceg?version=3', 'https://i2.ytimg.com/vi/QHVTznQTceg/hqdefault.jpg', '2021-06-08 17:55:33', 0, 0, 0),
(59, 'Continental Series - Confidence', 'https://www.youtube.com/embed/Nci2bxks25I?version=3', 'https://i3.ytimg.com/vi/Nci2bxks25I/hqdefault.jpg', '2021-06-08 17:58:59', 2, 0, 0),
(60, 'ASUS ZENFONE 8 REVIEW: THE PHONE YOU SHOULD\'VE BOUGHT!', 'https://www.youtube.com/embed/8rQ96VjmHpk?version=3', 'https://i1.ytimg.com/vi/8rQ96VjmHpk/hqdefault.jpg', '2021-06-09 04:44:21', 0, 0, 0),
(61, 'Sony\'s new WF-1000XM4 earbuds are really &#%!@ good! (review)', 'https://www.youtube.com/embed/4lv-cWgGMKE?version=3', 'https://i1.ytimg.com/vi/4lv-cWgGMKE/hqdefault.jpg', '2021-06-08 18:13:06', 0, 0, 0),
(62, 'iOS 15: Everything you need to know', 'https://www.youtube.com/embed/5iJ0t6JP2zY?version=3', 'https://i2.ytimg.com/vi/5iJ0t6JP2zY/hqdefault.jpg', '2021-06-08 18:13:39', 0, 0, 0),
(63, 'Echo Show 8 2021 review: An iterative upgrade that\'s still worth it', 'https://www.youtube.com/embed/C6gnWTwa46U?version=3', 'https://i4.ytimg.com/vi/C6gnWTwa46U/hqdefault.jpg', '2021-06-08 18:14:54', 0, 0, 0),
(64, 'WWDC21: Everything we expect from Apple', 'https://www.youtube.com/embed/tcOWCmsegCo?version=3', 'https://i1.ytimg.com/vi/tcOWCmsegCo/hqdefault.jpg', '2021-06-08 18:15:42', 1, 0, 0),
(65, '\'RED SKIES\' UPDATE / WAR THUNDER', 'https://www.youtube.com/embed/qODcVmrVdwc?version=3', 'https://i2.ytimg.com/vi/qODcVmrVdwc/hqdefault.jpg', '2021-06-08 18:17:14', 2, 0, 0),
(66, 'THE SHOOTING RANGE #253: Discarding Sabots / War Thunder', 'https://www.youtube.com/embed/1cmaBp6AAzc?version=3', 'https://i2.ytimg.com/vi/1cmaBp6AAzc/hqdefault.jpg', '2021-06-08 18:17:55', 0, 0, 0),
(67, 'WGB (和楽器バンド) / \"Starlight\" Music Video Behind the Scenes Digest', 'https://www.youtube.com/embed/sElRvOsObP0?version=3', 'https://i4.ytimg.com/vi/sElRvOsObP0/hqdefault.jpg', '2021-06-08 18:20:26', 0, 0, 0),
(68, 'Six Invitational 2021 – Aftermovie', 'https://www.youtube.com/embed/74rcYkfCsIw?version=3', 'https://i4.ytimg.com/vi/74rcYkfCsIw/hqdefault.jpg', '2021-06-09 04:43:59', 0, 0, 0),
(69, 'Rainbow Six Extraction: Sprawl Teaser | Ubisoft [NA]', 'https://www.youtube.com/embed/h3m3BmvFA3c?version=3', 'https://i1.ytimg.com/vi/h3m3BmvFA3c/hqdefault.jpg', '2021-06-08 18:23:22', 1, 0, 0),
(70, 'Hot Pot From Hell!! The Bizarre Diet of Vietnam\'s Black Thai People!! | TRIBAL VIETNAM EP4', 'https://www.youtube.com/embed/zjxFQI4kHkY?version=3', 'https://i3.ytimg.com/vi/zjxFQI4kHkY/hqdefault.jpg', '2021-06-08 18:25:57', 1, 0, 0),
(71, 'World’s Expensivest FRENCH TOAST!! It\'s Not What You Think!! | FANCIFIED Ep 3', 'https://www.youtube.com/embed/Yo8e55nXTWI?version=3', 'https://i2.ytimg.com/vi/Yo8e55nXTWI/hqdefault.jpg', '2021-06-08 18:26:35', 0, 0, 0),
(72, 'No Sudden Move\' (2021) | Official Trailer', 'https://www.youtube.com/embed/eJTtoobeOVI?version=3', 'https://i2.ytimg.com/vi/eJTtoobeOVI/hqdefault.jpg', '2021-06-08 18:28:50', 0, 0, 0),
(73, 'Bill Hader | Movie & TV Moments', 'https://www.youtube.com/embed/ISZiEQS6y24?version=3', 'https://i2.ytimg.com/vi/ISZiEQS6y24/hqdefault.jpg', '2021-06-08 18:29:23', 0, 0, 0),
(74, 'What to Watch This Summer for the Whole Family', 'https://www.youtube.com/embed/YTBVAP5nlVA?version=3', 'https://i2.ytimg.com/vi/YTBVAP5nlVA/hqdefault.jpg', '2021-06-08 18:30:08', 0, 0, 0),
(75, 'How Do The Japanese Feel About China? | ASIAN BOSS\r\n', 'https://www.youtube.com/embed/t_Gz0vNZftA', 'https://img.youtube.com/vi/t_Gz0vNZftA/hqdefault.jpg', '2021-06-08 18:34:56', 0, 0, 0),
(76, '🇺🇸 CULTURE SHOCK in America as an international student abroad. (cornell university) 🇵🇭\r\n', 'https://www.youtube.com/embed/xUnhES5GbrI', 'https://img.youtube.com/vi/xUnhES5GbrI/hqdefault.jpg', '2021-06-08 18:36:37', 1, 0, 0),
(77, 'Japan : Tradition & Culture\r\n', 'https://www.youtube.com/embed/-pgCPJSiKoo', 'https://img.youtube.com/vi/-pgCPJSiKoo/hqdefault.jpg', '2021-06-08 18:38:11', 4, 0, 0),
(78, 'The WRONG Way to Learn VIETNAMESE - Phúc Mập Vlog\r\n', 'https://www.youtube.com/embed/1e6cGdDmlSY', 'https://img.youtube.com/vi/1e6cGdDmlSY/hqdefault.jpg', '2021-06-08 18:41:25', 2, 0, 0),
(79, '★Herrscher of the Void\'s Outfit [Magic Girl ☆ Sirin] Showcase★\r\n', 'https://www.youtube.com/embed/E2RXYjBHac', 'https://img.youtube.com/vi/6E2RXYjBHac/hqdefault.jpg', '2021-06-08 18:45:02', 1, 0, 0),
(80, 'Version 1.6 Special Program｜Genshin Impact\r\n', 'https://www.youtube.com/embed/cE7RW9htzQU', 'https://img.youtube.com/vi/cE7RW9htzQU/hqdefault.jpg', '2021-06-08 18:47:14', 1, 0, 0),
(81, 'iCarly (2021) | OFFICIAL TRAILER', 'https://www.youtube.com/embed/aGAysU0KB74?version=3', 'https://i2.ytimg.com/vi/aGAysU0KB74/hqdefault.jpg', '2021-06-08 18:48:07', 1, 0, 0),
(82, '7 tools for building a business people trust | Marcos Aguiar', 'https://www.youtube.com/embed/lJUrQKY_A5g', 'https://img.youtube.com/vi/lJUrQKY_A5g/hqdefault.jpg', '2021-06-09 04:43:37', 1, 0, 0),
(83, 'The future diagnostic lab ... inside your body | Aaron Morris\r\n', 'https://www.youtube.com/embed/eJ_0x197H30', 'https://img.youtube.com/vi/eJ_0x197H30/hqdefault.jpg', '2021-06-08 18:52:34', 2, 0, 0),
(84, 'How Israel Reshaped Jewish Culture\r\n', 'https://www.youtube.com/embed/vpO_oQjLgEg', 'https://img.youtube.com/vi/vpO_oQjLgEg/hqdefault.jpg', '2021-06-08 18:53:53', 1, 0, 0),
(85, '10 Things You Don\'t Know: Russian Culture\r\n', 'https://www.youtube.com/embed/JegXdPUXGtY', 'https://img.youtube.com/vi/JegXdPUXGtY/hqdefault.jpg', '2021-06-08 18:55:53', 1, 0, 0),
(86, 'Take a Seat in the Harvard MBA Case Classroom', 'https://www.youtube.com/embed/p7iwXvBnbIE', 'https://img.youtube.com/vi/p7iwXvBnbIE/hqdefault.jpg', '2021-06-09 04:43:17', 1, 0, 0),
(87, '14 Reasons Why Asia is a Unique World', 'https://www.youtube.com/embed/q-9DzVfXQpA', 'https://img.youtube.com/vi/q-9DzVfXQpA/hqdefault.jpg', '2021-06-09 04:43:08', 1, 0, 0),
(88, '15 Things You Didn\'t Know About VIETNAM', 'https://www.youtube.com/embed/OKyd-E-uhk8', 'https://img.youtube.com/vi/OKyd-E-uhk8/hqdefault.jpg', '2021-06-09 04:41:41', 2, 0, 0),
(89, '魔女の宅急便 3曲 メドレー Kiki\'s Delivery Service [ピアノ]', 'https://www.youtube.com/embed/irl1-GOTL6M', 'https://img.youtube.com/vi/irl1-GOTL6M/hqdefault.jpg', '2021-06-09 04:41:52', 2, 0, 0);

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
(1, 8),
(2, 3),
(3, 3),
(4, 4),
(5, 5),
(6, 2),
(7, 1),
(9, 3),
(10, 3),
(11, 3),
(13, 3),
(14, 9),
(15, 4),
(16, 6),
(17, 9),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 8),
(30, 8),
(31, 8),
(32, 8),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 5),
(38, 5),
(39, 5),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 2),
(45, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 1),
(52, 8),
(53, 8),
(54, 8),
(55, 8),
(56, 8),
(57, 1),
(58, 1),
(59, 2),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 9),
(66, 9),
(67, 1),
(68, 5),
(68, 9),
(69, 9),
(70, 4),
(71, 4),
(72, 5),
(73, 5),
(74, 5),
(75, 7),
(76, 7),
(77, 7),
(78, 7),
(79, 9),
(80, 9),
(81, 5),
(82, 3),
(82, 6),
(83, 6),
(84, 7),
(85, 7),
(86, 6),
(87, 6),
(88, 6),
(88, 7),
(89, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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
