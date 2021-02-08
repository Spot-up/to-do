-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 08 2021 г., 11:50
-- Версия сервера: 5.7.31
-- Версия PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `todo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `name2`) VALUES
(0, 'Актуально', 'Актуальные'),
(1, 'Выполнено', 'Выполненные');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` mediumtext,
  `duedatetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `duedatetime`, `status`, `created_at`) VALUES
(18, 'Задача 3', 'Описание 3', '2021-02-05 02:30:00', 1, '2021-02-04 19:22:52'),
(19, 'Задача 4', 'Описание 4', '2021-02-08 11:55:00', 0, '2021-02-05 05:58:09'),
(20, 'Задача 2', '', '2021-02-08 01:55:00', 1, '2021-02-07 16:01:31'),
(21, 'Задача 6', 'Описание 6', '2021-02-10 11:00:00', 0, '2021-02-04 19:22:52'),
(22, 'Задача 1', '', '2021-02-05 06:55:00', 1, '2021-02-05 05:58:09'),
(23, 'Задача 5', 'Описание 5', '2021-02-09 11:55:00', 0, '2021-02-07 16:01:31');

-- --------------------------------------------------------

--
-- Структура таблицы `timezones`
--

DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tzident` varchar(100) NOT NULL,
  `tzabbr` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `timezones`
--

INSERT INTO `timezones` (`id`, `tzident`, `tzabbr`) VALUES
(1, 'Pacific/Midway', '(GMT-11:00) Midway Island, Samoa'),
(2, 'America/Adak', '(GMT-10:00) Hawaii-Aleutian'),
(3, 'Etc/GMT+10', '(GMT-10:00) Hawaii'),
(4, 'Pacific/Marquesas', '(GMT-09:30) Marquesas Islands'),
(5, 'Pacific/Gambier', '(GMT-09:00) Gambier Islands'),
(6, 'America/Anchorage', '(GMT-09:00) Alaska'),
(7, 'America/Ensenada', '(GMT-08:00) Tijuana, Baja California'),
(8, 'Etc/GMT+8', '(GMT-08:00) Pitcairn Islands'),
(9, 'America/Los_Angeles', '(GMT-08:00) Pacific Time (US & Canada)'),
(10, 'America/Denver', '(GMT-07:00) Mountain Time (US & Canada)'),
(11, 'America/Chihuahua', '(GMT-07:00) Chihuahua, La Paz, Mazatlan'),
(12, 'America/Dawson_Creek', '(GMT-07:00) Arizona'),
(13, 'America/Belize', '(GMT-06:00) Saskatchewan, Central America'),
(14, 'America/Cancun', '(GMT-06:00) Guadalajara, Mexico City, Monterrey'),
(15, 'Chile/EasterIsland', '(GMT-06:00) Easter Island'),
(16, 'America/Chicago', '(GMT-06:00) Central Time (US & Canada)'),
(17, 'America/New_York', '(GMT-05:00) Eastern Time (US & Canada)'),
(18, 'America/Havana', '(GMT-05:00) Cuba'),
(19, 'America/Bogota', '(GMT-05:00) Bogota, Lima, Quito, Rio Branco'),
(20, 'America/Caracas', '(GMT-04:30) Caracas'),
(21, 'America/Santiago', '(GMT-04:00) Santiago'),
(22, 'America/La_Paz', '(GMT-04:00) La Paz'),
(23, 'Atlantic/Stanley', '(GMT-04:00) Faukland Islands'),
(24, 'America/Campo_Grande', '(GMT-04:00) Brazil'),
(25, 'America/Goose_Bay', '(GMT-04:00) Atlantic Time (Goose Bay)'),
(26, 'America/Glace_Bay', '(GMT-04:00) Atlantic Time (Canada)'),
(27, 'America/St_Johns', '(GMT-03:30) Newfoundland'),
(28, 'America/Araguaina', '(GMT-03:00) UTC-3'),
(29, 'America/Montevideo', '(GMT-03:00) Montevideo'),
(30, 'America/Miquelon', '(GMT-03:00) Miquelon, St. Pierre'),
(31, 'America/Godthab', '(GMT-03:00) Greenland'),
(32, 'America/Argentina/Buenos_Aires', '(GMT-03:00) Buenos Aires'),
(33, 'America/Sao_Paulo', '(GMT-03:00) Brasilia'),
(34, 'America/Noronha', '(GMT-02:00) Mid-Atlantic'),
(35, 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'),
(36, 'Atlantic/Azores', '(GMT-01:00) Azores'),
(37, 'Europe/Belfast', '(GMT) Greenwich Mean Time : Belfast'),
(38, 'Europe/Dublin', '(GMT) Greenwich Mean Time : Dublin'),
(39, 'Europe/Lisbon', '(GMT) Greenwich Mean Time : Lisbon'),
(40, 'Europe/London', '(GMT) Greenwich Mean Time : London'),
(41, 'Africa/Abidjan', '(GMT) Monrovia, Reykjavik'),
(42, 'Europe/Amsterdam', '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'),
(43, 'Europe/Belgrade', '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'),
(44, 'Europe/Brussels', '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'),
(45, 'Africa/Algiers', '(GMT+01:00) West Central Africa'),
(46, 'Africa/Windhoek', '(GMT+01:00) Windhoek'),
(47, 'Asia/Beirut', '(GMT+02:00) Beirut'),
(48, 'Africa/Cairo', '(GMT+02:00) Cairo'),
(49, 'Asia/Gaza', '(GMT+02:00) Gaza'),
(50, 'Africa/Blantyre', '(GMT+02:00) Harare, Pretoria'),
(51, 'Asia/Jerusalem', '(GMT+02:00) Jerusalem'),
(52, 'Europe/Minsk', '(GMT+02:00) Minsk'),
(53, 'Asia/Damascus', '(GMT+02:00) Syria'),
(54, 'Europe/Moscow', '(GMT+03:00) Moscow, St. Petersburg, Volgograd'),
(55, 'Africa/Addis_Ababa', '(GMT+03:00) Nairobi'),
(56, 'Asia/Tehran', '(GMT+03:30) Tehran'),
(57, 'Asia/Dubai', '(GMT+04:00) Abu Dhabi, Muscat'),
(58, 'Asia/Yerevan', '(GMT+04:00) Yerevan'),
(59, 'Asia/Kabul', '(GMT+04:30) Kabul'),
(60, 'Asia/Yekaterinburg', '(GMT+05:00) Ekaterinburg'),
(61, 'Asia/Tashkent', '(GMT+05:00) Tashkent'),
(62, 'Asia/Kolkata', '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'),
(63, 'Asia/Katmandu', '(GMT+05:45) Kathmandu'),
(64, 'Asia/Dhaka', '(GMT+06:00) Astana, Dhaka'),
(65, 'Asia/Novosibirsk', '(GMT+06:00) Novosibirsk'),
(66, 'Asia/Rangoon', '(GMT+06:30) Yangon (Rangoon)'),
(67, 'Asia/Bangkok', '(GMT+07:00) Bangkok, Hanoi, Jakarta'),
(68, 'Asia/Krasnoyarsk', '(GMT+07:00) Krasnoyarsk'),
(69, 'Asia/Hong_Kong', '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi'),
(70, 'Asia/Irkutsk', '(GMT+08:00) Irkutsk, Ulaan Bataar'),
(71, 'Australia/Perth', '(GMT+08:00) Perth'),
(72, 'Australia/Eucla', '(GMT+08:45) Eucla'),
(73, 'Asia/Tokyo', '(GMT+09:00) Osaka, Sapporo, Tokyo'),
(74, 'Asia/Seoul', '(GMT+09:00) Seoul'),
(75, 'Asia/Yakutsk', '(GMT+09:00) Yakutsk'),
(76, 'Australia/Adelaide', '(GMT+09:30) Adelaide'),
(77, 'Australia/Darwin', '(GMT+09:30) Darwin'),
(78, 'Australia/Brisbane', '(GMT+10:00) Brisbane'),
(79, 'Australia/Hobart', '(GMT+10:00) Hobart'),
(80, 'Asia/Vladivostok', '(GMT+10:00) Vladivostok'),
(81, 'Australia/Lord_Howe', '(GMT+10:30) Lord Howe Island'),
(82, 'Etc/GMT-11', '(GMT+11:00) Solomon Is., New Caledonia'),
(83, 'Asia/Magadan', '(GMT+11:00) Magadan'),
(84, 'Pacific/Norfolk', '(GMT+11:30) Norfolk Island'),
(85, 'Asia/Anadyr', '(GMT+12:00) Anadyr, Kamchatka'),
(86, 'Pacific/Auckland', '(GMT+12:00) Auckland, Wellington'),
(87, 'Etc/GMT-12', '(GMT+12:00) Fiji, Kamchatka, Marshall Is.'),
(88, 'Pacific/Chatham', '(GMT+12:45) Chatham Islands'),
(89, 'Pacific/Tongatapu', '(GMT+13:00) Nukualofa'),
(90, 'Pacific/Kiritimati', '(GMT+14:00) Kiritimati');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
