-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2019 a las 01:18:45
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apidb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `escudo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `club`
--

INSERT INTO `club` (`id`, `nombre`, `escudo`) VALUES
(1, 'Real Madridd', 'url-escudo-RM '),
(2, '\r\nFC Barcelonaa', 'url-escudo-FCB '),
(3, '\r\nAtletico de Madridd', 'url-escudo-ATM '),
(4, '\r\nValencia FC', 'url-escudo-VFC '),
(5, '\r\nSevilla FC', 'url-escudo-SFC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `idclub` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dorsal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `idclub`, `nombre`, `dorsal`) VALUES
(1, 1, 'Ariel Carvajal', 15),
(2, 1, 'Keylor Navas', 2),
(3, 1, 'Luca Modric', 10),
(4, 1, 'Marcelo Vieira', 7),
(5, 1, 'Rafael Varane', 4),
(6, 1, 'Sergio Ramos', 3),
(7, 2, 'Gerard Piqué', 6),
(8, 2, 'Ivan Raquitic', 13),
(9, 2, 'Lionel Messi', 10),
(10, 2, 'Luis Suarez', 9),
(11, 2, 'Sergio Busquets', 11),
(12, 2, 'Yordy Alba', 14),
(13, 3, 'Alvaro Morata', 20),
(14, 3, 'Diego Costa', 9),
(15, 3, 'Diego Godin', 5),
(16, 3, 'Fillippe Luis', 13),
(17, 3, 'Koke Resurreccion', 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B8EE38723A909126` (`nombre`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CF491B763A909126` (`nombre`),
  ADD KEY `IDX_CF491B766B21C9D2` (`idclub`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
