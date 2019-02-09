-- phpMyAdmin SQL Dump
-- version home.pl
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 09 Lut 2019, 17:44
-- Wersja serwera: 5.7.22-22-log
-- Wersja PHP: 5.6.34

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `00167332_inz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `sender` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `version` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `attachments`
--

INSERT INTO `attachments` (`id`, `title`, `name`, `sender`, `version`, `status`) VALUES
(1, 'autobuy.txt', '08-02-2019-190826_autobuy.txt', '1', '2019-02-08 18:08:26', 1),
(2, 'PAS.pdf', '08-02-2019-193256_PAS.pdf', '1', '2019-02-08 18:32:56', 1),
(3, 'Graf-prosty-G-sklada-sie-z-niepustego-zbioru-', '09-02-2019-153635_Graf-prosty-G-sklada-sie-z-niepustego-zbioru-skonczonego-V.docx', '1', '2019-02-09 14:36:35', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `milestones`
--

CREATE TABLE IF NOT EXISTS `milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `projects_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_milestones_projects1_idx` (`projects_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `tasks_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`users_id`,`tasks_id`),
  KEY `fk_notes_users1_idx` (`users_id`),
  KEY `fk_notes_tasks1_idx` (`tasks_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=16 ;

--
-- Zrzut danych tabeli `notes`
--

INSERT INTO `notes` (`id`, `note`, `date`, `users_id`, `tasks_id`) VALUES
(1, 'Dłuższa notatka o pierwszym zadaniu', '2018-12-20 01:31:26', 1, 1),
(2, 'Testowy komentarz do zadania', '2018-12-20 02:34:18', 1, 2),
(3, 'Krótka notatka o pierwszym zadaniu', '2018-12-20 01:31:46', 1, 1),
(4, 'Testowy komentarz do zadania', '2018-12-20 02:35:25', 1, 2),
(5, 'Dodałem komentarz', '2018-12-20 02:35:40', 1, 2),
(10, 'Test', '2019-01-24 00:41:58', 3, 4),
(12, 'zrobilem pod 1', '2019-01-29 11:15:36', 1, 4),
(13, 'Wykonane.', '2019-01-29 18:59:30', 5, 6),
(14, 'Ukończyłem', '2019-01-31 01:31:29', 5, 7),
(15, 'Dodałem załącznik, oraz zapoznałem się. Odznaczam', '2019-02-07 18:58:35', 5, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  `status` set('0','1') CHARACTER SET latin2 DEFAULT NULL,
  `color` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`,`author_id`),
  KEY `fk_projects_users1_idx` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `start_date`, `end_date`, `author_id`, `status`, `color`) VALUES
(1, 'Test projekt 1', 'To jest projekt 1, który jest testem.', '2018-12-19 09:00:00', '2018-12-19 14:00:00', 1, '1', 'bg-danger'),
(2, 'Test projekt 2', 'To jest projekt, który jest drugim testem', '2018-12-19 15:00:00', '2018-12-19 16:00:00', 1, '1', 'bg-warning'),
(3, 'Test project 3', 'Treść 3.1', '2018-12-19 21:39:21', '2019-02-04 16:00:00', 1, '1', 'bg-info'),
(4, 'Testowy 4', 'Test', '2019-01-30 23:03:24', '2019-02-11 12:00:00', 1, '1', 'bg-success'),
(5, 'Testowy 5', '5', '2019-02-05 20:07:08', '2019-02-28 12:44:00', 1, '1', ''),
(6, 'Test zal', 'Test', '2019-02-07 17:52:41', '2019-02-15 14:22:00', 1, '1', 'bg-danger'),
(7, 'Test Grad 7', 'grad', '2019-02-07 18:55:01', '2019-02-07 22:00:00', 5, '0', 'bg-warning');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects_has_attachment`
--

CREATE TABLE IF NOT EXISTS `projects_has_attachment` (
  `projects_id` int(11) NOT NULL,
  `attachments_id` int(11) NOT NULL,
  PRIMARY KEY (`projects_id`,`attachments_id`),
  KEY `fk_tasks_has_documents_documents1_idx` (`attachments_id`),
  KEY `fk_tasks_has_documents_tasks1_idx` (`projects_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `projects_has_attachment`
--

INSERT INTO `projects_has_attachment` (`projects_id`, `attachments_id`) VALUES
(6, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Pracownik'),
(3, 'Team Leader');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `social_media`
--

CREATE TABLE IF NOT EXISTS `social_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_polish_ci,
  `post_date` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`users_id`),
  KEY `fk_social_media_users1_idx` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `social_media`
--

INSERT INTO `social_media` (`id`, `text`, `post_date`, `users_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac scelerisque neque. Ut nec vestibulum est, eu porttitor nisi. Nulla commodo efficitur arcu a convallis. Praesent sed vulputate ligula. Duis congue lobortis lectus at elementum. Sed sodales, dui eget placerat convallis, dolor est elementum sem, vitae dignissim libero metus at ex. Duis sem diam, tempor in tempor in, laoreet at purus. Donec non congue enim, eget ornare risus. Curabitur convallis felis in justo maximus, sed laoreet turpis accumsan.\r\n\r\n', '2018-12-19 02:44:20', 1),
(2, 'Donec congue lectus ut leo volutpat tincidunt. Maecenas cursus odio leo, at tincidunt justo porttitor et. Vivamus aliquet mi mauris, nec venenatis neque ultrices efficitur. Curabitur lacinia vehicula dapibus. Aliquam erat volutpat. Ut ipsum mi, feugiat et aliquam eu, imperdiet quis mauris. Proin at mi eget ipsum molestie porta. Proin vel mattis nulla. Proin a erat ac nunc gravida mollis.\r\n\r\n', '2018-12-19 02:44:20', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` set('0','1') CHARACTER SET latin2 NOT NULL,
  `priority` int(11) NOT NULL,
  `projects_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `color` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`,`projects_id`,`users_id`),
  KEY `fk_tasks_projects1_idx` (`projects_id`),
  KEY `fk_tasks_users1_idx` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=16 ;

--
-- Zrzut danych tabeli `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `start_date`, `end_date`, `status`, `priority`, `projects_id`, `users_id`, `color`) VALUES
(1, 'Test zadanie 1', 'To jest zadanie 1, które jest testem', '2018-12-19 14:00:00', '2018-12-19 14:00:00', '1', 1, 1, 1, '#0074D9'),
(2, 'Test zadanie 2.1', 'To jest zadanie 2, które jest xeronemx', '2018-12-20 09:00:00', '2019-01-24 14:00:00', '1', 1, 2, 1, '#7FDBFF'),
(3, 'Test zadanie 3', 'To jest 3 zadanie', '2018-12-20 12:00:00', '2018-12-20 14:00:00', '1', 1, 1, 1, '#39CCCC'),
(4, 'Test dodania użytkowników', 'Test', '2019-01-23 21:50:58', '2019-01-25 14:00:00', '1', 0, 3, 1, '#3D9970'),
(5, 'Test1', 'test', '2019-01-29 11:12:13', '2019-01-29 14:00:00', '1', 0, 1, 1, '#2ECC40'),
(6, 'Zadanie dla Dr Grada', 'Proszę przypiąć mnie do zadania', '2019-01-29 18:55:48', '2019-02-03 20:00:00', '1', 0, 1, 1, '#01FF70'),
(7, 'Test od Grada', 'Grad Test', '2019-01-31 01:30:49', '2019-01-31 12:00:00', '1', 0, 4, 5, '#FFDC00'),
(8, 'Test dla projektu 5', 'Treść', '2019-02-05 20:11:44', '2019-02-15 14:22:00', '1', 0, 5, 1, '#FF851B'),
(9, 'Test zal', 'Test', '2019-02-07 15:54:46', '2019-02-14 14:22:00', '1', 0, 5, 1, '#FF4136'),
(10, 'Test 7 zappoznaj się', 'test', '2019-02-07 18:57:59', '2019-02-14 12:44:00', '1', 0, 7, 5, '#F012BE'),
(12, 'tes', 'test', '2019-02-07 19:10:52', '2019-02-15 14:22:00', '1', 0, 1, 5, '#DDDDDD'),
(13, 'Test kalendarz', 'Test', '2019-02-08 17:07:40', '2019-02-09 12:00:00', '1', 0, 6, 1, '#0074D9'),
(14, 'Test kalendarz 2', 'Test', '2019-02-08 17:20:07', '2019-02-16 14:22:00', '1', 0, 6, 1, '#DDDDDD'),
(15, 'Test kal 3', 'test', '2019-02-08 17:23:58', '2019-02-09 14:22:00', '1', 0, 6, 1, '#3D9970');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks_has_attachment`
--

CREATE TABLE IF NOT EXISTS `tasks_has_attachment` (
  `tasks_id` int(11) NOT NULL,
  `attachments_id` int(11) NOT NULL,
  PRIMARY KEY (`tasks_id`,`attachments_id`),
  KEY `fk_tasks_has_documents_documents1_idx` (`attachments_id`),
  KEY `fk_tasks_has_documents_tasks1_idx` (`tasks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `tasks_has_attachment`
--

INSERT INTO `tasks_has_attachment` (`tasks_id`, `attachments_id`) VALUES
(15, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) CHARACTER SET latin2 NOT NULL,
  `name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `status` set('0','1') CHARACTER SET latin2 NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`roles_id`),
  KEY `fk_users_roles1_idx` (`roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `lastname`, `password`, `status`, `last_login`, `create_date`, `roles_id`) VALUES
(1, 'pswakowski@gmail.com', 'Przemysław', 'Swakowski', 'cc03e747a6afbbcbf8be7668acfebee5', '1', '2019-02-09 15:14:00', '2018-12-19 00:18:35', 1),
(2, 'pracownik@utp.edu.pl', 'Robert', 'Nowak', '1493fb21b909b2fefb007df9d749f96f', '1', '2019-02-05 13:34:28', '2018-12-19 00:37:35', 2),
(3, 'kamcio@utp.edu.pl', 'Kamil', 'Szczech', '3737d855440f516bf77df1332d3f2e9d', '1', '2019-01-23 07:14:49', '2018-12-19 00:59:02', 3),
(4, 'admin@admin.com', 'Admin', 'Adminowy', '0192023a7bbd73250516f069df18b500', '1', '2019-01-23 08:15:11', '2018-12-19 21:15:29', 1),
(5, 'grad@utp.edu.pl', 'Piotr', 'Grad', 'e37b6e74a3bd476dfde7e0577b9e81d6', '1', '2019-02-09 17:08:00', '2018-12-20 09:24:38', 3),
(6, 'test@wp.pl', 'Test', 'Testowski', 'cc03e747a6afbbcbf8be7668acfebee5', '1', '2019-01-23 08:15:28', '2019-01-22 20:49:30', 2),
(8, 'testowy@test.pl', 'Robuś', 'Mateja', '0a14c0594177ba51965651df4035be6c', '1', '2019-02-09 17:15:34', '2019-02-09 14:29:48', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_has_tasks`
--

CREATE TABLE IF NOT EXISTS `users_has_tasks` (
  `users_id` int(11) NOT NULL,
  `tasks_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`tasks_id`),
  KEY `fk_users_has_tasks_tasks1_idx` (`tasks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `users_has_tasks`
--

INSERT INTO `users_has_tasks` (`users_id`, `tasks_id`, `status`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 4, 1),
(1, 6, 2),
(1, 9, 0),
(1, 13, 0),
(1, 14, 0),
(1, 15, 1),
(2, 1, 1),
(2, 2, 1),
(2, 7, 1),
(3, 4, 1),
(5, 2, 1),
(5, 5, 1),
(5, 6, 1),
(5, 7, 0),
(5, 12, 1);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `milestones`
--
ALTER TABLE `milestones`
  ADD CONSTRAINT `fk_milestones_projects1` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `fk_notes_tasks1` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notes_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_users1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `projects_has_attachment`
--
ALTER TABLE `projects_has_attachment`
  ADD CONSTRAINT `projects_has_attachment_ibfk_1` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_has_attachment_ibfk_2` FOREIGN KEY (`attachments_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `social_media`
--
ALTER TABLE `social_media`
  ADD CONSTRAINT `fk_social_media_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `tasks_has_attachment`
--
ALTER TABLE `tasks_has_attachment`
  ADD CONSTRAINT `tasks_has_attachment_ibfk_1` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tasks_has_attachment_ibfk_2` FOREIGN KEY (`attachments_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users_has_tasks`
--
ALTER TABLE `users_has_tasks`
  ADD CONSTRAINT `fk_users_has_tasks_tasks1` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_tasks_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
