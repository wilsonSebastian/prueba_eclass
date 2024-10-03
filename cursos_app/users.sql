-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-10-2024 a las 23:12:33
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
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `status`, `created`, `modified`, `token`) VALUES
(11, 'Loreto', '$2y$10$fr/PyALylzwx44z/cKr0JukfhrJDjdtd7Ww5K5WzvHUpJu1T9gpCy', 'loreto@loreto.cl', 'user', 'active', '2024-10-02 02:42:33', '2024-10-02 02:42:33', '322e7723d7858364205be97ed7c6e16a41c9a83ca95d95d29c7de2acf79fbaf5'),
(12, 'admin', '$2y$10$U6o0dOC5wjWk8HzjKDNHZ.PFbP7GJHerKnTKQzVYEL0ORwZIEOBtq', 'wilarevalo4@gmail.com', 'admin', 'active', '2024-10-02 02:43:17', '2024-10-03 16:14:15', 'd3481f457494dec3018d188984159635c7f8864e759f3ef190d95cbe9d5e9066'),
(13, 'Alonso', '$2y$10$OpQzmawsXC574YgHibWaqOCeLlB2vlcOf7/eqmVRzwyCFKrH65E/W', 'alonso@alonso.cl', 'user', 'active', '2024-10-02 15:39:59', '2024-10-02 15:39:59', 'ea1c20d0a27f4115e27637bebf654e98cafe0c730eaaee251cf6e93d035ce66e'),
(14, 'Matías', '$2y$10$h5FHJkU9RlRw3iGduq0sqO/yVLAlywPe6L2msv3VL0jrxqHarGICq', 'mati@mati.cl', 'user', 'active', '2024-10-02 15:40:18', '2024-10-02 15:40:18', 'bb113bc3ca4b81686e7c73c388a649158ee47528852517701d2da7d19f2aa13d'),
(25, 'inactivo', '$2y$10$4vpKFy4yv/qgSZLpXt5ICugpqIc6mfqTqe0kLPf/.4ypG/RdZMCPu', 'inactivo@inactivo.cl', 'user', 'active', '2024-10-03 13:52:22', '2024-10-03 13:53:12', '7ec6ce11f6e41d8b64041181a1e4f81ab1535a79bf768848e8223e9c8619965d');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
