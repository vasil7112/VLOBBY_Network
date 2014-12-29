-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 29 Δεκ 2014 στις 14:18:01
-- Έκδοση διακομιστή: 5.5.40-cll
-- Έκδοση PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση: `vlobbyne_vlobby`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Άδειασμα δεδομένων του πίνακα `badges`
--

INSERT INTO `badges` (`id`, `title`, `description`, `image`) VALUES
(1, 'Badge of Honor 1', 'Example Description', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgj2uSxWm_fvDv2CG68Pi98n5IRc1jhUkxN-Nei6JSNYYQ3OF6VMY_k75g_pR383uZI0ANHgpblQfljpvYvCYOEuYdoeSsnWWKSEYQ2p7UlrgqUIKJeX4HS4XA3NTGY/96fx96f'),
(2, 'Badge of Honor 2', 'Example Description', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/335590/2d824a2bf56f14da3013b6e9903148133ab425c2.png'),
(3, 'Badge of Honor 3', 'Example Description', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/55230/a7560f9ea9c2fe8e426e0c13ba0e36a54cb1a675.png'),
(4, 'Badge of Honor 4', 'Example Description', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/730/54e40b9e2288fbab8bd4c6537b0325d405c7e1b0.png'),
(5, 'Sweet Sweepstakes Brah', '5+ Created Sweepstakes!', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/730/54e40b9e2288fbab8bd4c6537b0325d405c7e1b0.png'),
(6, 'Santa Claus', 'Make more than 25 Sweepstakes!', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/items/730/54e40b9e2288fbab8bd4c6537b0325d405c7e1b0.png');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `badges_assigned`
--

CREATE TABLE IF NOT EXISTS `badges_assigned` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `steamID` bigint(1) unsigned NOT NULL,
  `badge_id` int(11) unsigned NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Άδειασμα δεδομένων του πίνακα `badges_assigned`
--

INSERT INTO `badges_assigned` (`id`, `steamID`, `badge_id`, `assigned_at`) VALUES
(2, 76561198029050621, 1, '2014-12-25 15:46:36'),
(4, 76561198029050621, 2, '2014-12-25 15:46:36'),
(8, 76561198029050621, 4, '2014-12-27 16:06:06'),
(9, 76561198029050621, 6, '2014-12-27 20:48:46');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `lotteries`
--

CREATE TABLE IF NOT EXISTS `lotteries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Άδειασμα δεδομένων του πίνακα `lotteries`
--

INSERT INTO `lotteries` (`id`, `status`, `type`) VALUES
(1, 1, 1),
(2, 0, 2),
(3, 0, 3),
(4, 0, 4),
(5, 0, 5),
(6, 1, 6),
(7, 1, 1),
(12, 1, 1),
(24, 0, 1),
(25, 0, 6);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `lotteries_entries`
--

CREATE TABLE IF NOT EXISTS `lotteries_entries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `steamID` bigint(1) unsigned NOT NULL,
  `lottery_id` int(11) unsigned NOT NULL,
  `winner` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=410 ;

--
-- Άδειασμα δεδομένων του πίνακα `lotteries_entries`
--

INSERT INTO `lotteries_entries` (`id`, `steamID`, `lottery_id`, `winner`) VALUES
(1, 76561198029050621, 1, 0),
(2, 76561198029050621, 1, 0),
(3, 76561198029050621, 7, 0),
(5, 76561198029050621, 7, 0),
(6, 76561198029050621, 7, 0),
(7, 76561198029050621, 7, 0),
(8, 76561198029050621, 7, 0),
(9, 76561198029050621, 7, 0),
(10, 76561198029050621, 7, 0),
(11, 76561198029050621, 7, 0),
(12, 76561198029050621, 7, 0),
(13, 76561198029050621, 7, 0),
(14, 76561198029050621, 7, 0),
(15, 76561198029050621, 7, 1),
(16, 76561198029050621, 7, 0),
(17, 76561198029050621, 7, 0),
(18, 76561198029050621, 7, 0),
(19, 76561198029050621, 7, 0),
(20, 76561198029050621, 7, 0),
(21, 76561198029050621, 7, 0),
(22, 76561198029050621, 7, 0),
(23, 76561198029050621, 7, 0),
(24, 76561198029050621, 7, 0),
(25, 76561198029050621, 7, 0),
(26, 76561198029050621, 7, 0),
(27, 76561198029050621, 7, 0),
(32, 76561198029050621, 7, 0),
(33, 76561198029050621, 12, 0),
(34, 76561198029050621, 12, 1),
(35, 76561198029050621, 12, 0),
(36, 76561198029050621, 12, 0),
(37, 76561198029050621, 12, 0),
(38, 76561198029050621, 12, 0),
(39, 76561198029050621, 12, 0),
(40, 76561198029050621, 12, 0),
(41, 76561198029050621, 12, 0),
(42, 76561198029050621, 12, 0),
(43, 76561198029050621, 12, 0),
(44, 76561198029050621, 12, 0),
(45, 76561198029050621, 12, 0),
(46, 76561198029050621, 12, 0),
(47, 76561198029050621, 12, 0),
(48, 76561198029050621, 12, 0),
(49, 76561198029050621, 12, 0),
(50, 76561198029050621, 12, 0),
(51, 76561198029050621, 12, 0),
(52, 76561198029050621, 12, 0),
(53, 76561198029050621, 12, 0),
(54, 76561198029050621, 12, 0),
(55, 76561198029050621, 12, 0),
(65, 76561198029050621, 12, 0),
(76, 76561198029050621, 12, 0),
(142, 76561198029050621, 6, 0),
(143, 76561198029050621, 6, 0),
(144, 76561198029050621, 6, 0),
(145, 76561198029050621, 6, 0),
(146, 76561198029050621, 6, 0),
(147, 76561198029050621, 6, 0),
(148, 76561198029050621, 6, 0),
(149, 76561198029050621, 6, 0),
(150, 76561198029050621, 6, 0),
(151, 76561198029050621, 6, 0),
(152, 76561198029050621, 6, 0),
(153, 76561198029050621, 6, 0),
(154, 76561198029050621, 6, 0),
(155, 76561198029050621, 6, 0),
(156, 76561198029050621, 6, 0),
(157, 76561198029050621, 6, 0),
(158, 76561198029050621, 6, 0),
(159, 76561198029050621, 6, 0),
(160, 76561198029050621, 6, 0),
(161, 76561198029050621, 6, 0),
(162, 76561198029050621, 6, 0),
(163, 76561198029050621, 6, 0),
(164, 76561198029050621, 6, 0),
(165, 76561198029050621, 6, 0),
(166, 76561198029050621, 6, 0),
(167, 76561198029050621, 6, 0),
(168, 76561198029050621, 6, 0),
(169, 76561198029050621, 6, 0),
(170, 76561198029050621, 6, 0),
(171, 76561198029050621, 6, 0),
(172, 76561198029050621, 6, 0),
(173, 76561198029050621, 6, 0),
(174, 76561198029050621, 6, 0),
(175, 76561198029050621, 6, 0),
(176, 76561198029050621, 6, 0),
(177, 76561198029050621, 6, 0),
(178, 76561198029050621, 6, 0),
(179, 76561198029050621, 6, 0),
(180, 76561198029050621, 6, 0),
(181, 76561198029050621, 6, 0),
(182, 76561198029050621, 6, 0),
(183, 76561198029050621, 6, 0),
(184, 76561198029050621, 6, 0),
(185, 76561198029050621, 6, 0),
(186, 76561198029050621, 6, 0),
(187, 76561198029050621, 6, 0),
(188, 76561198029050621, 6, 0),
(189, 76561198029050621, 6, 0),
(190, 76561198029050621, 6, 0),
(191, 76561198029050621, 6, 0),
(192, 76561198029050621, 6, 0),
(193, 76561198029050621, 6, 0),
(194, 76561198029050621, 6, 0),
(195, 76561198029050621, 6, 0),
(196, 76561198029050621, 6, 0),
(197, 76561198029050621, 6, 0),
(198, 76561198029050621, 6, 0),
(199, 76561198029050621, 6, 0),
(200, 76561198029050621, 6, 0),
(201, 76561198029050621, 6, 0),
(202, 76561198029050621, 6, 0),
(203, 76561198029050621, 6, 0),
(204, 76561198029050621, 6, 0),
(205, 76561198029050621, 6, 0),
(206, 76561198029050621, 6, 0),
(207, 76561198029050621, 6, 0),
(208, 76561198029050621, 6, 0),
(209, 76561198029050621, 6, 0),
(210, 76561198029050621, 6, 0),
(211, 76561198029050621, 6, 0),
(212, 76561198029050621, 6, 0),
(213, 76561198029050621, 6, 0),
(214, 76561198029050621, 6, 0),
(215, 76561198029050621, 6, 0),
(216, 76561198029050621, 6, 0),
(217, 76561198029050621, 6, 0),
(218, 76561198029050621, 6, 0),
(219, 76561198029050621, 6, 0),
(220, 76561198029050621, 6, 0),
(221, 76561198029050621, 6, 0),
(222, 76561198029050621, 6, 0),
(223, 76561198029050621, 6, 0),
(224, 76561198029050621, 6, 0),
(225, 76561198029050621, 6, 0),
(226, 76561198029050621, 6, 0),
(227, 76561198029050621, 6, 0),
(228, 76561198029050621, 6, 0),
(229, 76561198029050621, 6, 0),
(230, 76561198029050621, 6, 0),
(231, 76561198029050621, 6, 0),
(232, 76561198029050621, 6, 0),
(233, 76561198029050621, 6, 0),
(234, 76561198029050621, 6, 0),
(235, 76561198029050621, 6, 0),
(236, 76561198029050621, 6, 0),
(237, 76561198029050621, 6, 0),
(238, 76561198029050621, 6, 0),
(239, 76561198029050621, 6, 0),
(240, 76561198029050621, 6, 0),
(241, 76561198029050621, 6, 0),
(242, 76561198029050621, 6, 0),
(243, 76561198029050621, 6, 0),
(244, 76561198029050621, 6, 0),
(245, 76561198029050621, 6, 0),
(246, 76561198029050621, 6, 0),
(247, 76561198029050621, 6, 0),
(248, 76561198029050621, 6, 0),
(249, 76561198029050621, 6, 0),
(250, 76561198029050621, 6, 0),
(251, 76561198029050621, 6, 0),
(252, 76561198029050621, 6, 0),
(253, 76561198029050621, 6, 0),
(254, 76561198029050621, 6, 0),
(255, 76561198029050621, 6, 0),
(256, 76561198029050621, 6, 0),
(257, 76561198029050621, 6, 0),
(258, 76561198029050621, 6, 0),
(259, 76561198029050621, 6, 0),
(260, 76561198029050621, 6, 0),
(261, 76561198029050621, 6, 0),
(262, 76561198029050621, 6, 0),
(263, 76561198029050621, 6, 0),
(264, 76561198029050621, 6, 0),
(265, 76561198029050621, 6, 0),
(266, 76561198029050621, 6, 0),
(267, 76561198029050621, 6, 0),
(268, 76561198029050621, 6, 0),
(269, 76561198029050621, 6, 0),
(270, 76561198029050621, 6, 0),
(271, 76561198029050621, 6, 0),
(272, 76561198029050621, 6, 0),
(273, 76561198029050621, 6, 0),
(274, 76561198029050621, 6, 0),
(275, 76561198029050621, 6, 0),
(276, 76561198029050621, 6, 0),
(277, 76561198029050621, 6, 0),
(278, 76561198029050621, 6, 0),
(279, 76561198029050621, 6, 0),
(280, 76561198029050621, 6, 0),
(281, 76561198029050621, 6, 0),
(282, 76561198029050621, 6, 0),
(283, 76561198029050621, 6, 0),
(284, 76561198029050621, 6, 0),
(285, 76561198029050621, 6, 0),
(286, 76561198029050621, 6, 0),
(287, 76561198029050621, 6, 0),
(288, 76561198029050621, 6, 0),
(289, 76561198029050621, 6, 0),
(290, 76561198029050621, 6, 0),
(291, 76561198029050621, 6, 0),
(292, 76561198029050621, 6, 0),
(293, 76561198029050621, 6, 0),
(294, 76561198029050621, 6, 0),
(295, 76561198029050621, 6, 0),
(296, 76561198029050621, 6, 0),
(297, 76561198029050621, 6, 0),
(298, 76561198029050621, 6, 0),
(299, 76561198029050621, 6, 0),
(300, 76561198029050621, 6, 0),
(301, 76561198029050621, 6, 0),
(302, 76561198029050621, 6, 0),
(303, 76561198029050621, 6, 0),
(304, 76561198029050621, 6, 0),
(305, 76561198029050621, 6, 0),
(306, 76561198029050621, 6, 0),
(307, 76561198029050621, 6, 0),
(308, 76561198029050621, 6, 0),
(309, 76561198029050621, 6, 0),
(310, 76561198029050621, 6, 0),
(311, 76561198029050621, 6, 0),
(312, 76561198029050621, 6, 0),
(313, 76561198029050621, 6, 0),
(314, 76561198029050621, 6, 0),
(315, 76561198029050621, 6, 0),
(316, 76561198029050621, 6, 0),
(317, 76561198029050621, 6, 0),
(318, 76561198029050621, 6, 0),
(319, 76561198029050621, 6, 0),
(320, 76561198029050621, 6, 0),
(321, 76561198029050621, 6, 0),
(322, 76561198029050621, 6, 0),
(323, 76561198029050621, 6, 0),
(324, 76561198029050621, 6, 0),
(325, 76561198029050621, 6, 0),
(326, 76561198029050621, 6, 0),
(327, 76561198029050621, 6, 0),
(328, 76561198029050621, 6, 0),
(329, 76561198029050621, 6, 0),
(330, 76561198029050621, 6, 0),
(331, 76561198029050621, 6, 0),
(332, 76561198029050621, 6, 0),
(333, 76561198029050621, 6, 0),
(334, 76561198029050621, 6, 0),
(335, 76561198029050621, 6, 0),
(336, 76561198029050621, 6, 0),
(337, 76561198029050621, 6, 0),
(338, 76561198029050621, 6, 0),
(339, 76561198029050621, 6, 0),
(340, 76561198029050621, 6, 0),
(341, 76561198029050621, 6, 0),
(342, 76561198029050621, 6, 0),
(343, 76561198029050621, 6, 0),
(344, 76561198029050621, 6, 0),
(345, 76561198029050621, 6, 0),
(346, 76561198029050621, 6, 0),
(347, 76561198029050621, 6, 0),
(348, 76561198029050621, 6, 0),
(349, 76561198029050621, 6, 0),
(350, 76561198029050621, 6, 0),
(351, 76561198029050621, 6, 0),
(352, 76561198029050621, 6, 0),
(353, 76561198029050621, 6, 1),
(354, 76561198029050621, 6, 0),
(355, 76561198029050621, 6, 0),
(356, 76561198029050621, 6, 0),
(357, 76561198029050621, 6, 0),
(358, 76561198029050621, 6, 0),
(359, 76561198029050621, 6, 0),
(360, 76561198029050621, 6, 0),
(361, 76561198029050621, 6, 0),
(362, 76561198029050621, 6, 0),
(363, 76561198029050621, 6, 0),
(364, 76561198029050621, 6, 0),
(365, 76561198029050621, 6, 0),
(366, 76561198029050621, 6, 0),
(367, 76561198029050621, 6, 0),
(368, 76561198029050621, 6, 0),
(369, 76561198029050621, 6, 0),
(370, 76561198029050621, 6, 0),
(371, 76561198029050621, 6, 0),
(372, 76561198029050621, 6, 0),
(373, 76561198029050621, 6, 0),
(374, 76561198029050621, 6, 0),
(375, 76561198029050621, 6, 0),
(376, 76561198029050621, 6, 0),
(377, 76561198029050621, 6, 0),
(378, 76561198029050621, 6, 0),
(379, 76561198029050621, 6, 0),
(380, 76561198029050621, 6, 0),
(381, 76561198029050621, 6, 0),
(382, 76561198029050621, 6, 0),
(383, 76561198029050621, 6, 0),
(384, 76561198029050621, 6, 0),
(385, 76561198029050621, 6, 0),
(386, 76561198029050621, 6, 0),
(387, 76561198029050621, 6, 0),
(388, 76561198029050621, 6, 0),
(389, 76561198029050621, 6, 0),
(390, 76561198029050621, 6, 0),
(403, 76561198029050621, 6, 0),
(404, 76561198029050621, 24, 0),
(405, 76561198029050621, 25, 0),
(406, 76561198029050621, 25, 0),
(407, 76561198029050621, 25, 0),
(408, 76561198029050621, 25, 0),
(409, 76561198029050621, 25, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `steamID` bigint(1) NOT NULL,
  `notification` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `color` char(6) NOT NULL DEFAULT '762520',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Άδειασμα δεδομένων του πίνακα `notifications`
--

INSERT INTO `notifications` (`id`, `steamID`, `notification`, `time`, `status`, `color`) VALUES
(1, 76561198029050621, 'You have made a new sweepstake. <a href="http://PLAY.vlobbys.net:8082/sweepstake/0">Visit Sweepstake</a>', '2014-12-27 14:57:09', 1, '762520'),
(2, 76561198029050621, 'You have made a new sweepstake. <a href="http://PLAY.vlobbys.net:8082/sweepstake/2">Visit Sweepstake</a>', '2014-12-27 14:58:39', 1, '762520'),
(3, 76561198029050621, 'You have made a new sweepstake. <a href="http://PLAY.vlobbys.net:8082/sweepstake/3">Visit Sweepstake</a>', '2014-12-27 16:02:40', 1, '762520'),
(4, 76561198029050621, 'You have made a new sweepstake. <a href="http://PLAY.vlobbys.net:8082/sweepstake/4">Visit Sweepstake</a>', '2014-12-27 16:06:06', 1, '762520'),
(5, 76561198029050621, 'You have made a new sweepstake. <a href="http://PLAY.vlobbys.net:8082/sweepstake/7">Visit Sweepstake</a>', '2014-12-27 16:09:32', 1, '762520');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `market_hash_name` varchar(150) NOT NULL,
  `points` mediumint(1) unsigned NOT NULL,
  `AppID` int(5) NOT NULL,
  PRIMARY KEY (`market_hash_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `price`
--

INSERT INTO `price` (`market_hash_name`, `points`, `AppID`) VALUES
('AUG | Contractor (Minimal Wear)', 4, 730),
('AUG | Radiation Hazard (Field-Tested)', 8, 730),
('CZ75-Auto | Hexane (Factory New)', 14, 730),
('Dual Berettas | Briar (Factory New)', 5, 730),
('Dual Berettas | Briar (Minimal Wear)', 3, 730),
('Dual Berettas | Stained (Well-Worn)', 7, 730),
('eSports 2014 Summer Case', 9, 730),
('FAMAS | Hexane (Field-Tested)', 14, 730),
('G3SG1 | Contractor (Field-Tested)', 2, 730),
('Galil AR | Hunting Blind (Field-Tested)', 6, 730),
('Glock-18 | Reactor (Well-Worn)', 103, 730),
('Huntsman Weapon Case', 28, 730),
('M249 | Gator Mesh (Field-Tested)', 6, 730),
('MAC-10 | Commuter (Minimal Wear)', 7, 730),
('MAC-10 | Indigo (Battle-Scarred)', 2, 730),
('MAC-10 | Indigo (Well-Worn)', 2, 730),
('MP7 | Forest DDPAT (Field-Tested)', 2, 730),
('MP9 | Green Plaid (Field-Tested)', 2, 730),
('MP9 | Storm (Field-Tested)', 2, 730),
('Nova | Ghost Camo (Factory New)', 16, 730),
('Offer | Sticker | Windy Walking Club', 0, 730),
('Operation Breakout Weapon Case', 53, 730),
('P250 | Metallic DDPAT (Factory New)', 9, 730),
('P250 | Sand Dune (Field-Tested)', 3, 730),
('Sawed-Off | Sage Spray (Field-Tested)', 2, 730),
('Sawed-Off | Snake Camo (Field-Tested)', 6, 730),
('SCAR-20 | Storm (Field-Tested)', 2, 730),
('Silver Operation Breakout Coin', 0, 730),
('StatTrakâ„¢ MAC-10 | Ultraviolet (Battle-Scarred)', 8, 730),
('USP-S | Business Class (Minimal Wear)', 81, 730),
('StatTrak™ MAC-10 | Ultraviolet (Battle-Scarred)', 8, 730),
('Offer | Sticker | Shooting Star Return', 0, 730),
('SCAR-20 | Sand Mesh (Minimal Wear)', 3, 730);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `steamInfo`
--

CREATE TABLE IF NOT EXISTS `steamInfo` (
  `steamID` bigint(1) unsigned NOT NULL,
  `personaname` varchar(32) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`steamID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `steamInfo`
--

INSERT INTO `steamInfo` (`steamID`, `personaname`, `avatar`, `lastupdate`) VALUES
(76561198068859340, 'SUBSCRIBE: YouTube/Cashburnermc', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/80/80623751afc7f9e956405b2bc51ba287735cb8c9.jpg', '2014-12-28 17:37:06'),
(76561198029050621, 'Vasil7112', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a6/a6dd8fcd7c1c47a527017032f47397408528497d.jpg', '2014-12-27 14:49:50');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sweepstakes`
--

CREATE TABLE IF NOT EXISTS `sweepstakes` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `steamID` bigint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Άδειασμα δεδομένων του πίνακα `sweepstakes`
--

INSERT INTO `sweepstakes` (`id`, `steamID`, `status`, `end_date`, `title`, `description`) VALUES
(1, 76561198029050621, 1, '2014-12-27 21:11:56', 'Merry Christmas', ''),
(2, 76561198029050621, 1, '2014-12-27 21:13:26', 'Merry Christmas', ''),
(3, 76561198029050621, 1, '2014-12-27 22:17:26', 'Vlobbys', ''),
(4, 76561198029050621, 1, '2014-12-27 22:20:53', 'Example Sweepstake', ''),
(5, 76561198029050621, 1, '2014-12-27 22:22:13', 'Badge almost achieved', ''),
(6, 76561198029050621, 1, '2014-12-27 22:23:18', 'Badge almost achieved', ''),
(7, 76561198029050621, 1, '2014-12-27 22:24:19', 'Badge almost achieved', ''),
(8, 76561198029050621, 1, '2014-12-27 22:24:19', 'Badge almost achieved', ''),
(9, 76561198029050621, 1, '2014-12-27 16:52:03', 'TESTS', 'TEST'),
(10, 76561198029050621, 1, '2014-12-27 16:57:26', 'testsss', ''),
(11, 76561198029050621, 1, '2014-12-27 17:01:17', 'TESADASDASD', ''),
(12, 76561198029050621, 1, '2014-12-27 17:11:03', 'TESASDASD', ''),
(13, 76561198029050621, 1, '2014-12-27 19:29:53', 'Examosa', ''),
(14, 76561198029050621, 1, '2014-12-27 20:48:46', 'testsss', ''),
(15, 76561198029050621, 1, '2014-12-27 20:49:41', 'tessaasas', ''),
(16, 76561198029050621, 1, '2014-12-27 20:52:09', 'tsadassadasd', '');

--
-- Δείκτες `sweepstakes`
--
DROP TRIGGER IF EXISTS `badgeProgress`;
DELIMITER //
CREATE TRIGGER `badgeProgress` AFTER INSERT ON `sweepstakes`
 FOR EACH ROW BEGIN
SET @count = 0;
SET @STEAMID = 0;
UPDATE `user_stats` 
SET `sweepstakes_created` = (@count:=(`sweepstakes_created`+1))
WHERE `steamID` = (@STEAMID:=(NEW.`steamID`));

IF (@count = 5) THEN
	SET @BADGE = 5;
	INSERT INTO `badges_assigned` (steamID, badge_id)
    SELECT * FROM (SELECT @STEAMID, @BADGE) AS tmp
    WHERE NOT EXISTS (
       SELECT `steamID` FROM `badges_assigned` WHERE (`steamID` = @STEAMID AND `badge_id` = @BADGE)
    ) LIMIT 1;
ELSEIF (@count = 25) THEN
	SET @NEWBADGE = 6;
	SET @OLDBADGE = 5;
	UPDATE `badges_assigned` SET `badge_id` = @NEWBADGE WHERE (`steamID` = @STEAMID AND `badge_id` = @OLDBADGE);
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sweepstakes_entries`
--

CREATE TABLE IF NOT EXISTS `sweepstakes_entries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `steamID` bigint(1) unsigned NOT NULL,
  `sweepstakes_id` int(11) unsigned NOT NULL,
  `winner` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sweepstakes_items`
--

CREATE TABLE IF NOT EXISTS `sweepstakes_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `item_image` varchar(500) NOT NULL,
  `sweepstakes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Άδειασμα δεδομένων του πίνακα `sweepstakes_items`
--

INSERT INTO `sweepstakes_items` (`id`, `item_name`, `item_image`, `sweepstakes_id`) VALUES
(1, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 0),
(2, 'Operation Breakout Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKZHlhIgCQUvgKBKBoowq7CyJi7pZlV47jou0EeFrs4dGQYbEtOdsZSsTQRLbYMa0PH-14/96fx96f', 0),
(3, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 0),
(4, 'Operation Breakout Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKZHlhIgCQUvgKBKBoowq7CyJi7pZlV47jou0EeFrs4dGQYbEtOdsZSsTQRLbYMa0PH-14/96fx96f', 0),
(5, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 0),
(6, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 2),
(7, 'Operation Breakout Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKZHlhIgCQUvgKBKBoowq7CyJi7pZlV47jou0EeFrs4dGQYbEtOdsZSsTQRLbYMa0PH-14/96fx96f', 2),
(8, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 2),
(9, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 2),
(10, 'Operation Breakout Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKZHlhIgCQUvgKBKBoowq7CyJi7pZlV47jou0EeFrs4dGQYbEtOdsZSsTQRLbYMa0PH-14/96fx96f', 2),
(11, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 2),
(12, 'Huntsman Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKY3lkd1yRU6EHDvNj8gu_W3426580UIC3r-tUegvr5ovHO-IsN4sYTcjURLbYMeak1RF7/96fx96f', 3),
(13, 'Operation Breakout Weapon Case', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEgznuShMhvflDOGJG68Didsh4K9W1jtmhA9yIPqKZHlhIgCQUvgKBKBoowq7CyJi7pZlV47jou0EeFrs4dGQYbEtOdsZSsTQRLbYMa0PH-14/96fx96f', 4),
(14, 'AUG | Contractor (Minimal Wear)', 'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz56IeSKIzhYYgnBPqxXW_0uug2-CHdk6sY2UIG1o-pUfQzn4IDCN7d5Md5OGsfSUveBM1z970lq1KJDb8ve-qanAqw/96fx96f', 4),
(17, 'Pool', 'http://steamcommunity-a.akamaihd.net/economy/image/IzMF03bi9WpSBq-S-ekoE33L-iLqGFHVaU25ZzQNQcXdA3g5gMEPvUZZEaiHLrVJRsl8vGuCUY7Cjc9ehDNVzDMPe3GpjTJ5bPFgPZb2zwr35-uAHXPyNTLCenSNHwdtSeVdPG_Y-TXzsemURD3BQO59QwsAeKBV9WUbb8_YNkEjlNlc7We3hUB4DCkhf8RBdVLjnCNCYO1xmHRBcpoHzybzdZWIhAxjPU44CLy0Ur_BaoCglioiDEluAeBEM53TtSTf3X87Iw/96fx96f', 7);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `steamID` bigint(1) unsigned NOT NULL,
  `points` int(1) unsigned NOT NULL DEFAULT '0',
  `group` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`steamID`),
  UNIQUE KEY `steamID` (`steamID`),
  KEY `steamID_2` (`steamID`),
  KEY `steamID_3` (`steamID`),
  KEY `steamID_4` (`steamID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`steamID`, `points`, `group`) VALUES
(76561198029050621, 0, 255),
(76561198068859340, 0, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user_stats`
--

CREATE TABLE IF NOT EXISTS `user_stats` (
  `steamID` bigint(1) NOT NULL,
  `sweepstakes_created` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sweepstakes_entered` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sweepstakes_won` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`steamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `user_stats`
--

INSERT INTO `user_stats` (`steamID`, `sweepstakes_created`, `sweepstakes_entered`, `sweepstakes_won`) VALUES
(76561198029050621, 25, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
