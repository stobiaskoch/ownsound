-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. Okt 2013 um 09:07
-- Server Version: 5.5.31
-- PHP-Version: 5.4.4-14+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `musikdatenbank`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `imgdata` longblob NOT NULL,
  `imgdata_small` longblob NOT NULL,
  `imgtype` varchar(100) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `discogsid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=638 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scanner_log`
--

CREATE TABLE IF NOT EXISTS `scanner_log` (
  `id` int(11) NOT NULL,
  `starttime` datetime NOT NULL,
  `artist` varchar(500) NOT NULL DEFAULT '0',
  `album` varchar(500) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '0',
  `error` varchar(500) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `title`
--

CREATE TABLE IF NOT EXISTS `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `artist` varchar(100) DEFAULT NULL,
  `album` varchar(100) DEFAULT NULL,
  `duration` varchar(100) NOT NULL,
  `path` varchar(700) NOT NULL,
  `linktobandpic` varchar(700) NOT NULL,
  `bandurl` varchar(700) NOT NULL,
  `imgdata` longblob NOT NULL,
  `imgtype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `path` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10454 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `fullname` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `group` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
