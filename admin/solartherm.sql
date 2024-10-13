SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `solartherm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `solartherm`;

DROP TABLE IF EXISTS `boot_log`;
CREATE TABLE IF NOT EXISTS `boot_log` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sensors_id` int(6) UNSIGNED NOT NULL,
  `boot_log` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sensors_id` (`sensors_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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


ALTER TABLE `boot_log`
  ADD CONSTRAINT `boot_log_ibfk_1` FOREIGN KEY (`sensors_id`) REFERENCES `sensors` (`id`);

ALTER TABLE `outdoor_sensors`
  ADD CONSTRAINT `outdoor_sensors_ibfk_1` FOREIGN KEY (`sensors_id`) REFERENCES `sensors` (`id`);
COMMIT;
