-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2023 a las 06:30:04
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `petrolsur`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `yacimientos`
--

CREATE TABLE `yacimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yac_artiv` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `yacimientos`
--

INSERT INTO `yacimientos` (`id`, `area_id`, `nombre`, `yac_artiv`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cutral Co Norte', 'CNCN', '2023-03-22 09:27:30', '2023-03-22 09:27:30'),
(2, 1, 'CUTRAL CO ESTE', 'CNES', '2023-03-22 09:27:30', '2023-03-22 09:27:30'),
(3, 1, 'EL MOLINO', 'EMOL', '2023-03-22 09:27:30', '2023-03-22 09:27:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `yacimientos`
--
ALTER TABLE `yacimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `yacimientos_nombre_unique` (`nombre`),
  ADD UNIQUE KEY `yacimientos_yac_artiv_unique` (`yac_artiv`),
  ADD KEY `yacimientos_area_id_foreign` (`area_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `yacimientos`
--
ALTER TABLE `yacimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `yacimientos`
--
ALTER TABLE `yacimientos`
  ADD CONSTRAINT `yacimientos_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
