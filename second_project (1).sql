-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2021 at 03:32 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `second_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` bigint(20) NOT NULL,
  `comment_text` text COLLATE utf8mb4_estonian_ci NOT NULL,
  `comment_user` int(11) NOT NULL,
  `comment_post` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `comment_parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_estonian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `comment_text`, `comment_user`, `comment_post`, `date_created`, `comment_parent`) VALUES
(64, 'Hello everyone!', 9, 20, '2021-06-06 13:10:09', NULL),
(65, 'Hello Trieu!', 9, 19, '2021-06-06 13:10:22', NULL),
(66, 'It\'s nice Luyen~~', 9, 18, '2021-06-06 13:10:35', NULL),
(67, 'haha ^^', 9, 17, '2021-06-06 13:10:46', NULL),
(68, 'I like it.', 6, 20, '2021-06-06 13:11:25', NULL),
(69, 'Luyen Ga ^^', 6, 18, '2021-06-06 13:11:36', NULL),
(70, 'Ok, I\'m fine!', 6, 19, '2021-06-06 13:11:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` bigint(20) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_body` text NOT NULL,
  `post_author` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL,
  `post_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `post_title`, `post_body`, `post_author`, `date_created`, `date_modified`, `post_img`) VALUES
(17, 'Have you tried to run a marathon with no practice?', 'I hope not. You might pull a muscle.\r\n\r\nYou need to start small in order to achieve something big like that.\r\n\r\nWhen it comes to learning English, what if I told you that you can understand big ideas with just a little bit of text?\r\n\r\nYou do not need to wait several years to deal with complex concepts.\r\n\r\nJust because you are learning a language does not mean you need to limit your thinking.\r\n\r\nStories are all about going beyond reality. It is no wonder that they let you understand big concepts with only a little bit of English reading practice.\r\n\r\nBut this works better when you’re reading better stories.\r\n\r\nI am talking about award-winning short stories, told using language easily understood by English beginner learners. These will not only improve your English reading comprehension but also open your mind to different worlds.', 6, '2021-06-06 13:02:36', '0000-00-00 00:00:00', 'images/Hinh3_60bc64fca711a.jpg'),
(18, '“The Bogey Beast”', 'A woman finds a pot of treasure on the road while she is returning from work. Delighted with her luck, she decides to keep it. As she is taking it home, it keeps changing. However, her enthusiasm refuses to fade away.\r\n\r\nWhat Is Great About It: The old lady in this story is one of the most cheerful characters anyone can encounter in English fiction. Her positive disposition (personality) tries to make every negative transformation seem like a gift, and she helps us look at luck as a matter of perspective rather than events.', 7, '2021-06-06 13:05:45', '0000-00-00 00:00:00', 'images/Image 1_60bc65b9ab2f5.png'),
(19, 'The Tortoise and the Hare 2', 'This classic fable tells the story of a very slow tortoise (another word for turtle) and a speedy hare (another word for rabbit). The tortoise challenges the hare to a race. The hare laughs at the idea that a tortoise could run faster than him, but when the two actually race, the results are surprising.\r\n\r\nWhat Is Great About It: Have you ever heard the English expression, “Slow and steady wins the race”? This story is the basis for that common phrase. This timeless short story teaches a lesson that we all know but can sometimes forget: Natural talent is no substitute for hard work, and overconfidence often leads to failure.\r\n\r\nThis short story is available on FluentU, so you can take advantages of all of FluentU’s great language-learning features while revisiting this childhood classic.', 8, '2021-06-06 13:07:04', '0000-00-00 00:00:00', 'images/Image5_60bc6608c57d5.jpg'),
(20, 'The Tale of Johnny Town-Mouse', 'Timmie Willie is a country mouse who is accidentally transported to a city in a vegetable basket. When he wakes up, he finds himself in a party and makes a friend. When he is unable to bear the city life, he returns to his home but invites his friend to the village. When his friend visits him, something similar happens.\r\n\r\nWhat Is Great About It: Humans have been living without cities or villages for most of history. That means that both village and city life are recent inventions. And just like every other invention, we need to decide their costs and benefits.\r\n\r\nThe story is precisely about this debate. It is divided into short paragraphs and has illustrations for each scene. This is best for beginners who want to start reading immediately.', 9, '2021-06-06 13:10:00', '0000-00-00 00:00:00', 'images/Image6_60bc66b89ca11.jpg'),
(21, 'dfdasf', 'adsfdasfdsaf', 10, '2021-06-06 15:17:43', '0000-00-00 00:00:00', 'images/Image4_60bc84a75d959.jpg'),
(22, 'NOW', 'NOW', 6, '2021-06-06 20:10:31', '0000-00-00 00:00:00', 'images/Image 2_60bcc9478c1f0.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_hash` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_role` int(11) NOT NULL DEFAULT 2,
  `user_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `user_name`, `user_email`, `user_hash`, `date_created`, `user_role`, `user_img`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$7307yoVY7Tv36nU20PO6WOX8jBFlxxieXDid41KreFh/CPw6mq1zO', '2021-05-13 15:21:19', 1, ''),
(2, 'sammy', 'spenceraustinmartin@gmail.com', '$2y$10$WvU2ZpRw4D89mI4T5gP94uWAlCtQAS4DEKaletM4EbSVXXIv62xLG', '2021-05-13 15:52:01', 2, ''),
(3, 'itecsam', 'itec@gmail.com', '$2y$10$SorJT/f0POgxherI65T.m.6LBMj8h79C4O6g3D9/aPRVDTei5d4Lq', '2021-05-13 15:56:31', 2, ''),
(4, 'sammy5', 'itec@gmail.com', '$2y$10$Nvne/vpMGf346RrfqrMU2uelb808MXU9Xd1brliUr0Vi0G2NGxE..', '2021-05-13 16:02:09', 2, ''),
(5, 'lanlan', 'lan@gmail.com', '$2y$10$5wboupRIFbCFzSQ6qrIGzeICVWgkJ7ZWMsbLRzvmoUsnDCw21rgXa', '2021-05-13 16:14:34', 2, ''),
(6, 'Quang', 'quangdo2000@gmail.com', '$2y$10$0NMdaZfvhVbRqhGeXERZqOaKUvqf/icpyFsiJ6klpq073Q7FlktYq', '2021-05-27 14:22:39', 1, ''),
(7, 'Luyen', 'luyenga@gmail.com', '$2y$10$sPoEByYV.vfuXV7Nnf7wzusW7xgBqEiGl83K./Qu56Xkeh996jYpG', '2021-05-28 15:02:23', 1, ''),
(8, 'Trieu', 'trieudo@gmail.com', '$2y$10$lVqHEEpD999dgrN3rurx9uYdJ18pyOOAmzKQomNQoftOVwbKyu.re', '2021-06-05 19:41:27', 2, ''),
(9, 'Khiem', 'luyenga@gmail.com', '$2y$10$nAq.Uwa.oAvt8LFu.9UzzugWHM9XuSa2mag54johH8EyCpaTIg68u', '2021-06-06 13:08:29', 2, ''),
(10, 'admin2', 'admin2@gmail.com', '$2y$10$xVNFy69iPVh32W2hdIkXweuiJZGUWY6FftQ/AW2Ub01tT3ncffwtu', '2021-06-06 13:13:36', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
