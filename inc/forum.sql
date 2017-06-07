-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Jun 2017 um 11:15
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `forum`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beiträge`
--

CREATE TABLE `beiträge` (
  `PKID_beitrag` int(11) NOT NULL,
  `FK_user` int(11) NOT NULL,
  `FK_thread` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `likes` int(11) NOT NULL,
  `beitragsnr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menueverknuepfung`
--

CREATE TABLE `menueverknuepfung` (
  `FK_ueberpunkt` int(11) NOT NULL,
  `FK_unterpunkt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menüpunkte`
--

CREATE TABLE `menüpunkte` (
  `PKID_menu` int(11) NOT NULL,
  `typ` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `passwort`
--

CREATE TABLE `passwort` (
  `FK_user` int(11) NOT NULL,
  `passwort` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `FK_thread` int(11) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `thread`
--

CREATE TABLE `thread` (
  `PKID_thread` int(11) NOT NULL,
  `thema` varchar(200) NOT NULL,
  `FK_ersteller` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `PKID_user` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `vorname` varchar(25) NOT NULL,
  `nachname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `beiträge` int(11) NOT NULL,
  `berechtigung` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`PKID_user`, `username`, `vorname`, `nachname`, `email`, `banned`, `beiträge`, `berechtigung`) VALUES
(0, 'Rudi', 'Rino', 'Grupp', 'rino@grupp.cc', 0, 2, 'admin'),
(1, 'MagicM', 'Merlin', 'Baudert', 'abi2015@web.de', 0, 4, 'admin');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `beiträge`
--
ALTER TABLE `beiträge`
  ADD PRIMARY KEY (`PKID_beitrag`);

--
-- Indizes für die Tabelle `menüpunkte`
--
ALTER TABLE `menüpunkte`
  ADD PRIMARY KEY (`PKID_menu`);

--
-- Indizes für die Tabelle `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`PKID_thread`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`PKID_user`),
  ADD UNIQUE KEY `Username` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
