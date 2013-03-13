-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-01-2013 a las 17:22:58
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `refreak`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_groups`
--

CREATE TABLE IF NOT EXISTS `rfk_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `rfk_groups`
--

INSERT INTO `rfk_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'manager', 'Managers'),
(3, 'developer', 'Developer'),
(4, 'guest', 'Guest');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_login_attempts`
--

CREATE TABLE IF NOT EXISTS `rfk_login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_projects`
--

CREATE TABLE IF NOT EXISTS `rfk_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rfk_projects`
--

INSERT INTO `rfk_projects` (`project_id`, `name`, `description`) VALUES
(1, 'Test', 'test description');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_project_status`
--

CREATE TABLE IF NOT EXISTS `rfk_project_status` (
  `project_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `status_date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`project_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rfk_project_status`
--

INSERT INTO `rfk_project_status` (`project_status_id`, `project_id`, `status_date`, `status_id`, `user_id`) VALUES
(1, 1, '2013-01-24', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_tasks`
--

CREATE TABLE IF NOT EXISTS `rfk_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `task_parent_id` int(11) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `context` varchar(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `deadline_date` date NOT NULL,
  `expected_duration` smallint(6) NOT NULL,
  `total_duration` smallint(6) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_task_comment`
--

CREATE TABLE IF NOT EXISTS `rfk_task_comment` (
  `task_comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment` text NOT NULL,
  `last_change_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`task_comment_id`),
  KEY `taskId` (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_task_status`
--

CREATE TABLE IF NOT EXISTS `rfk_task_status` (
  `task_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `status_date` datetime NOT NULL,
  `status` smallint(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`task_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_users`
--

CREATE TABLE IF NOT EXISTS `rfk_users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `title` VARCHAR( 30 ) NULL ,
  `country_id` INT NULL ,
  `author_id` INT NOT NULL 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `rfk_users` ADD `title` VARCHAR( 30 ) NULL ,
ADD `country_id` INT NULL ,
ADD `author_id` INT NOT NULL 

--
-- Volcado de datos para la tabla `rfk_users`
--

INSERT INTO `rfk_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1359044134, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '\0\0', 'manager', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'manager@admin.com', '', NULL, NULL, NULL, 1268889823, 1349861218, 1, 'Man', 'ager', 'ADMIN', '0'),
(3, '\0\0', 'developer', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'developer@admin.com', '', NULL, NULL, NULL, 1268889823, 1349861218, 1, 'Dev', 'eloper', 'ADMIN', '0'),
(4, '\0\0', 'guest', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'guest@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1349952296, 1, 'Gu', 'est', 'ADMIN', '0'),
(9, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'test test', '22ec042669afa1872ef9d81284fd92e046d5861d', NULL, 'test1@test.com', NULL, NULL, NULL, NULL, 1349948237, 1349948237, 1, 'test', 'test', 'ADMIN', NULL),
(10, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'test test1', '11d2fd772ff974c0fbc172b9070e24499105959b', NULL, 'test@test.com', NULL, NULL, NULL, NULL, 1349948244, 1349948244, 1, 'test', 'test', 'ADMIN', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_users_groups`
--

CREATE TABLE IF NOT EXISTS `rfk_users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `rfk_users_groups`
--

INSERT INTO `rfk_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(4, 3, 3),
(5, 4, 4),
(10, 9, 0),
(11, 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rfk_user_project`
--

CREATE TABLE IF NOT EXISTS `rfk_user_project` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `project_id` int(10) unsigned NOT NULL DEFAULT '0',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rfk_user_project`
--

INSERT INTO `rfk_user_project` (`user_id`, `project_id`, `position`) VALUES
(1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
