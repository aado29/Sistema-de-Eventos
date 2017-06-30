-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2017 a las 16:11:49
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eventos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `nombre_e` varchar(150) DEFAULT NULL,
  `desc_e` varchar(150) DEFAULT NULL,
  `estado_e` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `tipo_ev` varchar(150) DEFAULT NULL,
  `f_incio` date DEFAULT NULL,
  `f_fin` date DEFAULT NULL,
  `lugar_ev` varchar(150) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_voluntario` int(11) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `nombre_g` varchar(150) DEFAULT NULL,
  `tipo_g` varchar(150) DEFAULT NULL,
  `desc_g` varchar(150) DEFAULT NULL,
  `telefono_g` decimal(10,0) DEFAULT NULL,
  `direccion_g` varchar(150) DEFAULT NULL,
  `correo_g` varchar(150) DEFAULT NULL,
  `num_miemb` int(11) DEFAULT NULL,
  `estado_g` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) DEFAULT NULL,
  `fecha_r` int(11) DEFAULT NULL,
  `id_evento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula_u` int(11) DEFAULT NULL,
  `nombre_u` varchar(150) DEFAULT NULL,
  `contra_u` varchar(150) DEFAULT NULL,
  `telefono_u` decimal(10,0) DEFAULT NULL,
  `correo_u` varchar(150) DEFAULT NULL,
  `tipo_u` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `placa` varchar(150) DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL,
  `modelo` varchar(150) DEFAULT NULL,
  `color` varchar(150) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `num_carroceria` decimal(10,0) DEFAULT NULL,
  `num_motor` decimal(10,0) DEFAULT NULL,
  `num_chasis` decimal(10,0) DEFAULT NULL,
  `estado_vh` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios`
--

CREATE TABLE `voluntarios` (
  `id_voluntario` int(11) NOT NULL,
  `cedula_v` int(11) DEFAULT NULL,
  `nombre_v` varchar(150) DEFAULT NULL,
  `apellido_v` varchar(150) DEFAULT NULL,
  `direccion_v` varchar(150) DEFAULT NULL,
  `telefono_v` varchar(250) DEFAULT NULL,
  `correo_v` varchar(150) DEFAULT NULL,
  `talla_camisa` varchar(150) DEFAULT NULL,
  `talla_pantalon` varchar(150) DEFAULT NULL,
  `talla_zapatos` varchar(150) DEFAULT NULL,
  `cargo_v` varchar(150) DEFAULT NULL,
  `profesion_v` varchar(150) DEFAULT NULL,
  `especialidad_v` varchar(150) DEFAULT NULL,
  `ocupacion_V` varchar(150) DEFAULT NULL,
  `tipo_v` varchar(150) DEFAULT NULL,
  `estado_v` varchar(150) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `id_vehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- Indices de la tabla `voluntarios`
--
ALTER TABLE `voluntarios`
  ADD PRIMARY KEY (`id_voluntario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `voluntarios`
--
ALTER TABLE `voluntarios`
  MODIFY `id_voluntario` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
