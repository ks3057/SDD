-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2019 at 11:19 PM
-- Server version: 5.5.60-MariaDB
-- PHP Version: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ks3057`
--

-- --------------------------------------------------------

--
-- Table structure for table `server_league`
--

CREATE TABLE `server_league` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_league`
--

INSERT INTO `server_league` (`id`, `name`) VALUES
(1, 'Football Champions League'),
(2, 'Cricket Premier League');

-- --------------------------------------------------------

--
-- Table structure for table `server_player`
--

CREATE TABLE `server_player` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `jerseynumber` varchar(45) NOT NULL,
  `team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_player`
--

INSERT INTO `server_player` (`id`, `firstname`, `lastname`, `dateofbirth`, `jerseynumber`, `team`) VALUES
(1, 'manish', 'pandey', '1989-09-10', '1', 1),
(2, 'david', 'warner', '1990-09-10', '2', 1),
(3, 'john', 'kowalski', '1990-02-01', '3', 1),
(4, 'david', 'wallace', '1991-03-01', '4', 1),
(5, 'jan', 'levinson', '1980-04-11', '5', 1),
(6, 'oliver', 'martinez', '1890-09-12', '6', 1),
(7, 'angela', 'marting', '1993-12-31', '7', 1),
(8, 'kevin', 'hart', '1992-11-05', '8', 1),
(9, 'robert', 'creed', '1989-04-11', '9', 1),
(10, 'toby', 'mcguire', '1989-05-29', '10', 1),
(11, 'ryan', 'howard', '1988-04-11', '1', 2),
(12, 'kelly', 'kapur', '1989-01-22', '2', 2),
(13, 'michael', 'scott', '1987-07-11', '3', 2),
(14, 'dwight', 'shrute', '1988-04-19', '4', 2),
(15, 'jim', 'halpert', '1991-12-11', '5', 2),
(16, 'pamela', 'beezly', '1992-03-05', '6', 2),
(17, 'andy', 'bernard', '1986-07-27', '7', 2),
(18, 'erin', 'shaw', '1989-04-16', '8', 2),
(19, 'phyllis', 'vance', '1983-01-01', '9', 2),
(20, 'stanley', 'manly', '1982-08-30', '10', 2),
(52, 'ronald', 'weasley', '1992-12-12', '1', 20),
(53, 'harry', 'potter', '0000-00-00', '2', 20),
(54, 'harry', 'potter', '1990-12-01', '2', 20),
(55, 'hermione', 'granger', '1990-12-02', '3', 20),
(56, 'draco', 'malfoy', '1990-01-01', '4', 20),
(57, 'lucius', 'malfoy', '1990-01-01', '5', 20),
(58, 'bellatrix', 'malfoy', '1990-01-01', '6', 20),
(59, 'narcissa', 'malfoy', '1990-01-01', '7', 20),
(60, 'severus', 'snape', '1990-01-01', '8', 20),
(61, 'ginny', 'weasley', '1990-01-02', '4', 21),
(62, 'bill', 'weasley', '1990-01-03', '5', 21),
(63, 'charlie', 'weasley', '1990-04-01', '6', 21),
(64, 'molly', 'weasley', '1990-06-01', '7', 21),
(65, 'fred', 'weasley', '1990-09-01', '8', 21),
(66, 'george', 'weasley', '1990-09-01', '8', 21),
(67, 'rose', 'weasley', '1990-09-01', '8', 21),
(68, 'you-know', 'who', '1880-01-01', '9', 20);

-- --------------------------------------------------------

--
-- Table structure for table `server_playerpos`
--

CREATE TABLE `server_playerpos` (
  `player` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_playerpos`
--

INSERT INTO `server_playerpos` (`player`, `position`) VALUES
(1, 6),
(2, 6),
(3, 7),
(4, 7),
(5, 8),
(6, 8),
(7, 9),
(8, 9),
(9, 10),
(10, 10),
(11, 6),
(12, 6),
(13, 7),
(14, 7),
(15, 8),
(16, 8),
(17, 9),
(18, 9),
(19, 10),
(20, 10),
(52, 1),
(53, 2),
(54, 3),
(55, 4),
(56, 5),
(57, 1),
(58, 2),
(59, 3),
(60, 4),
(61, 5),
(62, 1),
(63, 2),
(64, 3),
(65, 4),
(66, 5),
(67, 1),
(68, 4);

-- --------------------------------------------------------

--
-- Table structure for table `server_position`
--

CREATE TABLE `server_position` (
  `name` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_position`
--

INSERT INTO `server_position` (`name`, `id`) VALUES
('Goal Keeper', 1),
('Defender', 2),
('Central Midfielder', 3),
('Winger', 4),
('Striker', 5),
('Left Handed Batsman', 6),
('Right Handed Batsman', 7),
('All Rounder', 8),
('Wicket Keeper', 9),
('Bowler', 10),
('left winger', 12),
('right winger', 13);

-- --------------------------------------------------------

--
-- Table structure for table `server_roles`
--

CREATE TABLE `server_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_roles`
--

INSERT INTO `server_roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'League Manager'),
(3, 'Team Manager'),
(4, 'Coach'),
(5, 'Parent');

-- --------------------------------------------------------

--
-- Table structure for table `server_schedule`
--

CREATE TABLE `server_schedule` (
  `id` int(11) NOT NULL,
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `hometeam` int(11) NOT NULL,
  `awayteam` int(11) NOT NULL,
  `homescore` int(11) NOT NULL DEFAULT '0',
  `awayscore` int(11) NOT NULL DEFAULT '0',
  `scheduled` datetime NOT NULL,
  `completed` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_schedule`
--

INSERT INTO `server_schedule` (`id`, `sport`, `league`, `season`, `hometeam`, `awayteam`, `homescore`, `awayscore`, `scheduled`, `completed`) VALUES
(1, 1, 2, 1, 1, 2, 4, 12, '2018-02-01 08:00:00', b'1'),
(2, 1, 2, 1, 2, 1, 11, 22, '2019-04-30 09:00:00', b'0'),
(3, 2, 1, 2, 20, 21, 12, 10, '2019-03-13 10:00:00', b'1'),
(7, 2, 1, 2, 21, 20, 12, 12, '2019-04-01 09:00:00', b'0'),
(8, 1, 2, 1, 1, 1, 12, 12, '2018-12-12 12:00:00', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `server_season`
--

CREATE TABLE `server_season` (
  `id` int(11) NOT NULL,
  `year` char(4) NOT NULL,
  `description` varchar(50) NOT NULL,
  `league` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_season`
--

INSERT INTO `server_season` (`id`, `year`, `description`, `league`) VALUES
(1, '2018', 'held in USA, east coast', 2),
(2, '2019', 'held in USA, west coast', 1),
(9, '2021', 'FL, USA', NULL),
(13, '2018', 'cricket, india', NULL),
(14, '1992', 'golden days', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `server_slseason`
--

CREATE TABLE `server_slseason` (
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_slseason`
--

INSERT INTO `server_slseason` (`sport`, `league`, `season`) VALUES
(1, 2, 1),
(1, 2, 14),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `server_sport`
--

CREATE TABLE `server_sport` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_sport`
--

INSERT INTO `server_sport` (`id`, `name`) VALUES
(1, 'cricket'),
(2, 'football'),
(24, 'rowing'),
(25, 'volleyball'),
(26, 'boxing'),
(29, 'swimming');

-- --------------------------------------------------------

--
-- Table structure for table `server_team`
--

CREATE TABLE `server_team` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mascot` varchar(50) DEFAULT NULL,
  `sport` int(11) NOT NULL,
  `league` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `homecolor` varchar(25) NOT NULL DEFAULT 'white',
  `awaycolor` varchar(25) NOT NULL,
  `maxplayers` varchar(45) NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_team`
--

INSERT INTO `server_team` (`id`, `name`, `mascot`, `sport`, `league`, `season`, `picture`, `homecolor`, `awaycolor`, `maxplayers`) VALUES
(1, 'Sunrisers', 'sun', 1, 2, 1, 'Sunrisers_Hyderabad.png', 'orange', 'black', '20'),
(2, 'Super Kings', 'lion', 1, 2, 1, 'csk.jpg', 'yellow', '', '20'),
(20, 'Wolves', 'wolf', 2, 1, 2, 'wolves.png', 'gray', 'white', '25'),
(21, 'Cheetahs', 'cheetah', 2, 1, 2, 'cheetah.jpg', 'yellow', 'gold', '25');

-- --------------------------------------------------------

--
-- Table structure for table `server_user`
--

CREATE TABLE `server_user` (
  `username` varchar(25) NOT NULL,
  `role` int(11) NOT NULL,
  `password` char(60) NOT NULL,
  `team` int(11) DEFAULT NULL,
  `league` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server_user`
--

INSERT INTO `server_user` (`username`, `role`, `password`, `team`, `league`) VALUES
('asiem09', 2, '$2y$10$/qOxfYwQRcyOhoH.UCPJme3kQlhQUaRW/Y1P6MiBP7zT2AhPPXSqu', NULL, 1),
('gargi14', 5, '$2y$10$reOm1zlNSmGcxi0LxTrEyOYqFCFT7fueW0bXbiKqZjo3f3cnud0Fm', 2, 2),
('jill0908', 1, '$2y$10$JYGwGNEHH.ueDPRhvzV3queCmd7PlrZmGHO/5qKqgUQ2ZfAyIkDMq', NULL, NULL),
('julia123', 1, '$2y$10$JJyb5XUVSdmTR9asT2hvDOOGYDBZCeZa5DVwLY3HV5AjlC9RuEHp6', NULL, NULL),
('kanewilliamson', 3, '$2y$10$oqZGgSTmz/a0IWSuXDkDweg9Ar2UjHlUhuov0SMD25BCdicK0YfiG', 1, 2),
('katebeck', 2, '$2y$10$lKLr.cSCR6PaUmXb8sFEiODjWxtaYyP8rtV6tuWM3Lppm7BiV3lRS', NULL, 2),
('kirtana', 5, '$2y$10$B.8BEqlkRQfClebt6CG54eMiBlhWoeKDj.48f0kzHKxxs13JV23SW', 1, 2),
('mordor1234', 1, '$2y$10$gXITxvO8rLdKcjaKx2ymP.Om6l/xv6PRjCDnVyIqwofUMQ5OF/rDG', NULL, NULL),
('natasha', 4, '$2y$10$mox/qpxdL.AYUW/KMVKr/eeSVgk/OCcn9HwBicvc4hYdPCLJRZ5um', 2, 2),
('noah2345', 1, '$2y$10$Sv5tc4YsKsJsqtq.StA.DOIalYpJzQX8ao2DvmpS/.atbW6oA9UEe', NULL, NULL),
('noahcentino', 3, '$2y$10$HRVV8lAP55imK1wYojDGFeMi34Had8MdODYVYFu.j8KqhxeQCT2NO', 21, 1),
('ritwick', 3, '$2y$10$id.JFioYFCBzMWu546y74OWnpUhcIP7Z7LmCe.6igmTSXYH2rzmDm', 2, 2),
('rohanrocks', 3, '$2y$10$7eVqM8FalpRFtFoFESXRfeMti5fYSeZGOKAAvO30K.D0yvcHHZMmC', 20, 1),
('tommoody', 4, '$2y$10$wtNB5XX9R45S8HWwEMoHeuA..OVijCgK75PHZH5X82gv4qDmNkT6e', 1, 2),
('turja119', 2, '$2y$10$s/vvMdXX9kmIPkiGRcx2q.iJLHkvc.zkogcbkcXwiM0Ev22.Qxkla', NULL, 2),
('WilliamG', 2, '$2y$10$rI/ChaWxe1nY7/nZfrPXdeReDVnLCbSPAlwm6ruxql.7alHwHBcTS', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `server_league`
--
ALTER TABLE `server_league`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_player`
--
ALTER TABLE `server_player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teamFK_idx` (`team`),
  ADD KEY `playPosFK_idx` (`id`);

--
-- Indexes for table `server_playerpos`
--
ALTER TABLE `server_playerpos`
  ADD PRIMARY KEY (`player`,`position`),
  ADD KEY `ppPlayerFK_idx` (`player`),
  ADD KEY `posFK_idx` (`position`);

--
-- Indexes for table `server_position`
--
ALTER TABLE `server_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_roles`
--
ALTER TABLE `server_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_schedule`
--
ALTER TABLE `server_schedule`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `sportleagueseasonFK_idx` (`sport`,`league`,`season`),
  ADD KEY `hometeamFK_idx` (`hometeam`),
  ADD KEY `awayteamFK_idx` (`awayteam`);

--
-- Indexes for table `server_season`
--
ALTER TABLE `server_season`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_slseason`
--
ALTER TABLE `server_slseason`
  ADD PRIMARY KEY (`sport`,`league`,`season`),
  ADD KEY `ssksseasonFK_idx` (`season`),
  ADD KEY `sslsleagueFK_idx` (`league`),
  ADD KEY `sslssportFK_idx` (`sport`);

--
-- Indexes for table `server_sport`
--
ALTER TABLE `server_sport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_team`
--
ALTER TABLE `server_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sls_idx` (`sport`,`league`,`season`),
  ADD KEY `sls_sport_idx` (`sport`),
  ADD KEY `sls_league_idx` (`league`),
  ADD KEY `sls_season_idx` (`season`);

--
-- Indexes for table `server_user`
--
ALTER TABLE `server_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `roleFK_idx` (`role`),
  ADD KEY `teamUserFK_idx` (`team`),
  ADD KEY `leagueUserFK_idx` (`league`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `server_league`
--
ALTER TABLE `server_league`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `server_player`
--
ALTER TABLE `server_player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `server_position`
--
ALTER TABLE `server_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `server_roles`
--
ALTER TABLE `server_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `server_schedule`
--
ALTER TABLE `server_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `server_season`
--
ALTER TABLE `server_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `server_sport`
--
ALTER TABLE `server_sport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `server_team`
--
ALTER TABLE `server_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `server_player`
--
ALTER TABLE `server_player`
  ADD CONSTRAINT `teamFK` FOREIGN KEY (`team`) REFERENCES `server_team` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `server_playerpos`
--
ALTER TABLE `server_playerpos`
  ADD CONSTRAINT `posPlayerFK` FOREIGN KEY (`player`) REFERENCES `server_player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posFK` FOREIGN KEY (`position`) REFERENCES `server_position` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `server_schedule`
--
ALTER TABLE `server_schedule`
  ADD CONSTRAINT `awayteamFK` FOREIGN KEY (`awayteam`) REFERENCES `server_team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hometeamFK` FOREIGN KEY (`hometeam`) REFERENCES `server_team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schslseasonFK` FOREIGN KEY (`sport`,`league`,`season`) REFERENCES `server_slseason` (`sport`, `league`, `season`) ON DELETE CASCADE;

--
-- Constraints for table `server_slseason`
--
ALTER TABLE `server_slseason`
  ADD CONSTRAINT `sslsseasonFK` FOREIGN KEY (`season`) REFERENCES `server_season` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sslsleaguetFK` FOREIGN KEY (`league`) REFERENCES `server_league` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sslssportFK` FOREIGN KEY (`sport`) REFERENCES `server_sport` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `server_team`
--
ALTER TABLE `server_team`
  ADD CONSTRAINT `slsFK` FOREIGN KEY (`sport`,`league`,`season`) REFERENCES `server_slseason` (`sport`, `league`, `season`) ON DELETE CASCADE;

--
-- Constraints for table `server_user`
--
ALTER TABLE `server_user`
  ADD CONSTRAINT `teamUserFK` FOREIGN KEY (`team`) REFERENCES `server_team` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `leagueUserFK` FOREIGN KEY (`league`) REFERENCES `server_league` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `roleFK` FOREIGN KEY (`role`) REFERENCES `server_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
