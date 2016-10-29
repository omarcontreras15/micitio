-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2016 a las 22:02:10
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto3`
--
CREATE DATABASE IF NOT EXISTS `proyecto3` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `proyecto3`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico_idea`
--

CREATE TABLE `diagnostico_idea` (
  `Num_consecutivo` bigint(20) UNSIGNED NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Asesor` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Nombres` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `Apellidos` varchar(100) CHARACTER SET latin1 NOT NULL,
  `CC` int(11) DEFAULT NULL,
  `Posicion` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `Idea` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Motivacion` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Elecion` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Productos` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Personal_requerido` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Grupo_empresarial` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Equipo_caracteristicas` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Criterios_contratacion` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Mercado_objetivo` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Mercado_objetivo_ubica` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Competidores` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Factor_diferenciador` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Condiciones_venta` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Ubicacion_negocio` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Ubicacion_influencia` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Estrategia_precios` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Canales_distribucion` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Promocion_negocio` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Costo_operacion` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fuentes_financiacion` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Tiempo_retorno_inversion` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Como_estimo_precio` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Costo_producto` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Asuntos_finanza` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Desarrollo_producto` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Tecnologia_requerida` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Infraestructura_requerida` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Regulaciones_operacion` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Tipo_persona` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `Aspectos_mejorar` varchar(1000) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `nombre` varchar(59) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `nombre`, `email`, `password`) VALUES(2, 'omar', 'omar contreras', 'omararturo15@hotmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `diagnostico_idea`
--
ALTER TABLE `diagnostico_idea`
  ADD PRIMARY KEY (`Num_consecutivo`),
  ADD UNIQUE KEY `Num_consecutivo` (`Num_consecutivo`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `diagnostico_idea`
--
ALTER TABLE `diagnostico_idea`
  MODIFY `Num_consecutivo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
