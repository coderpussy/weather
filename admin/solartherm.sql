-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 30. Sep 2024 um 21:05
-- Server-Version: 10.5.26-MariaDB-0+deb11u2
-- PHP-Version: 7.2.34-51+0~20240802.96+debian11~1.gbpe3aa6e

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `solartherm`
--
CREATE DATABASE IF NOT EXISTS `solartherm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `solartherm`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `outdoor_sensors`
--

DROP TABLE IF EXISTS `outdoor_sensors`;
CREATE TABLE IF NOT EXISTS `outdoor_sensors` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sensors_id` int(6) UNSIGNED NOT NULL,
  `temperature_out` varchar(30) DEFAULT NULL,
  `rainfall_hourly` varchar(30) DEFAULT NULL,
  `rainfall_last24` varchar(30) DEFAULT NULL,
  `wind_speed` varchar(30) DEFAULT NULL,
  `wind_direction` varchar(30) DEFAULT NULL,
  `uv_index` varchar(30) DEFAULT NULL,
  `lux` varchar(30) DEFAULT NULL,
  `temperature_esp_core` varchar(30) DEFAULT NULL,
  `boot_count` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sensors_id` (`sensors_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sensors`
--

DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `temperature` varchar(30) DEFAULT NULL,
  `pressure` varchar(30) DEFAULT NULL,
  `altitude` varchar(30) DEFAULT NULL,
  `humidity` varchar(30) DEFAULT NULL,
  `battery` varchar(30) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `TimeStamp` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `outdoor_sensors`
--
ALTER TABLE `outdoor_sensors`
  ADD CONSTRAINT `outdoor_sensors_ibfk_1` FOREIGN KEY (`sensors_id`) REFERENCES `sensors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
