-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2022 at 04:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tapioca`
--

-- --------------------------------------------------------

--
-- Table structure for table `coleccion`
--

CREATE TABLE `coleccion` (
  `id_coleccion` int(255) NOT NULL,
  `anio` int(255) NOT NULL,
  `nombre_coleccion` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `estacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coleccion`
--

INSERT INTO `coleccion` (`id_coleccion`, `anio`, `nombre_coleccion`, `autor`, `estacion`) VALUES
(2, 2023, 'coleccion verano 2023 ', 'marcos fernandez', 'verano'),
(3, 2023, 'coleccion invierno alaska', 'carretin', 'invierno'),
(4, 2023, 'coleccion otonio ', 'carret', 'otonio');

-- --------------------------------------------------------

--
-- Table structure for table `ropa`
--

CREATE TABLE `ropa` (
  `id` int(255) NOT NULL,
  `precio` double DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` tinytext DEFAULT NULL,
  `img` tinytext DEFAULT NULL,
  `id_coleccion_fk` int(255) DEFAULT NULL,
  `id_tipo_fk` int(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ropa`
--

INSERT INTO `ropa` (`id`, `precio`, `nombre`, `descripcion`, `img`, `id_coleccion_fk`, `id_tipo_fk`, `slug`) VALUES
(29, 5000, 'Pantalón jogging gris', ' Jogging friza rústica con bolsillos laterales, cintura con ojalillos y cordón chato. De tejido suave, resistente y duradero. Prenda suelta, cómoda que permite a la piel respirar.', 'images/634819af4e587.jpg', 3, 6, 'Pantalón-jogging-gris'),
(30, 10500, ' buso gris suelto', 'buso gris de poliester fabricado en indonesia por chinoss', 'images/63486e4fc9f1c.jpg', 3, 1, 'buso-gris-suelto'),
(32, 12000, 'jean mujer', 'jean oscuro mujer ideal para salir a pasear al perro', 'images/634873cb48c3d.jpg', 4, 6, 'jean-mujer'),
(33, 14000, 'jean hombre', 'descripcion de este gran jean', 'images/6348740eb254b.jpg', 4, 6, 'jean-hombre'),
(34, 8000, 'sweater rojo', 'descripcion sweater rojo mujer para invierno', 'images/6348753a2c875.jpg', 3, 2, 'sweater-rojo'),
(36, 4500, 'calza gris', 'calza deportiva gris ', 'images/63487d76375cb.jpg', 2, 6, 'calza-gris'),
(37, 5000, 'jogging', 'Jogging friza rústica con bolsillos laterales, cintura con ojalillos y cordón chato. De tejido suave, resistente y duradero. Prenda suelta, cómoda que permite a la piel respirar.', 'images/63488a24c4352.jpg', 4, 6, 'jogging'),
(39, 15000, 'buso rojo', 'buso rojo con capucha', 'images/6348e34cbdc25.jpg', 3, 1, 'buso-rojo');

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`) VALUES
(1, 'busos'),
(2, 'sweaters'),
(5, 'remeras');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nombre`, `email`, `passwd`, `rol`) VALUES
(1, 'luciano', 'lulobareiss@gmail.com', '$2y$10$OItr2zoI7Ax/CqnKwWf18OoEa1ooANCC64p/w4V95VIaCXoQ9RMTe', 'admin'),
(3, 'marcos', 'marcos@gmail', '$2y$10$EMqwoTT0KMPIqYvqWByTw.rC8dHlRff2.lcHWJm4NwXyklSPsGS.u', 'admin'),
(12, 'agus', 'agus_kawa@hotmail.com', '$2y$10$AKvPQ/yveSLNlnS525R0J.r56rsIujFgS9apJ0uoPxgRhhOjfql8W', 'user'),
(13, 'gabito', 'gabo@hotmail.com', '$2y$10$PSSW1u7ub06qP.ZcKPZzgewowWCeoWKQGu/PpcKQSieOt6wRTLaiC', 'user'),
(15, 'nuevo', 'nuevo@gmail', '$2y$10$dwF2wMqAJMrZ5vYnHSp/5.6JXw9Smmg9EclSTfXt7FbQfYgq/ItvS', 'user'),
(17, 'nuevo 2', 'nuevo@gmail.com', '$2y$10$Jm6ca3NKPwvRbLo/pikM5.ECUh43TqlSL2Ldqw7BmoUtB32PR45MW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coleccion`
--
ALTER TABLE `coleccion`
  ADD PRIMARY KEY (`id_coleccion`);

--
-- Indexes for table `ropa`
--
ALTER TABLE `ropa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo_fk` (`id_tipo_fk`),
  ADD KEY `id_coleccion_fk` (`id_coleccion_fk`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coleccion`
--
ALTER TABLE `coleccion`
  MODIFY `id_coleccion` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ropa`
--
ALTER TABLE `ropa`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
