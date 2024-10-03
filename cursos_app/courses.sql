-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-10-2024 a las 23:14:55
-- Versión del servidor: 8.3.0
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eclass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(191) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `token`, `name`, `description`, `start_date`, `end_date`, `created`, `modified`) VALUES
(5, '7f334e25-deca-4459-a3db-d3ebe19d1ec6', 'programación 4', 'programación 4', '2025-10-02', '2027-10-02', '2024-10-02 02:57:07', '2024-10-02 13:46:25'),
(6, 'c26ad922-29c5-4a29-94f7-8aca42990aea', 'programación 1', 'introducción a la programación', '2024-10-02', '2024-12-02', '2024-10-02 13:47:23', '2024-10-02 13:47:23'),
(7, '9544652f-771c-4fc7-ade2-451af0256570', 'programación 2', 'programación un poco más avanzada', '2025-10-02', '2026-10-02', '2024-10-02 13:47:49', '2024-10-02 15:13:15'),
(8, '2bc1593f-71fe-4797-8938-12e4346c9b01', 'programación 3', 'programación un poco más avanzada que programación 2', '2029-10-02', '2027-10-02', '2024-10-02 13:48:11', '2024-10-03 00:23:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
