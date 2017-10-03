-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Okt 2017 um 18:32
-- Server-Version: 10.1.26-MariaDB
-- PHP-Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `icecool_main`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einkaufszettel`
--

CREATE TABLE `einkaufszettel` (
  `id` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `menge` float NOT NULL,
  `einheit` varchar(3) NOT NULL,
  `erledigt` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `einkaufszettel`
--

INSERT INTO `einkaufszettel` (`id`, `name`, `menge`, `einheit`, `erledigt`, `timestamp`) VALUES
(1, 'Käse', 200, 'g', 0, '2017-09-30 16:35:57');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `einkaufszettel`
--
ALTER TABLE `einkaufszettel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `einkaufszettel`
--
ALTER TABLE `einkaufszettel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
