-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2024 a las 05:28:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `fecha` date NOT NULL,
  `correlativo` int(11) NOT NULL,
  `num_autorizacion_fel` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `nit`, `nombre`, `direccion`, `fecha`, `correlativo`, `num_autorizacion_fel`, `subtotal`, `iva`, `total`) VALUES
(1, '1234567', 'luis', 'cuidad', '2024-10-07', 1, '1', 10.25, 1.23, 11.48),
(2, '45678', 'luis', 'cuidad', '2024-10-07', 2, '2', 5.00, 0.60, 5.60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_factura`
--

CREATE TABLE `productos_factura` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `producto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos_factura`
--

INSERT INTO `productos_factura` (`id`, `factura_id`, `producto`, `cantidad`, `precio_unitario`, `total`) VALUES
(1, 1, 'producto 1', 2, 2.50, 5.00),
(2, 1, 'producto 2', 3, 1.75, 5.25),
(3, 2, 'tortillas', 2, 1.00, 2.00),
(4, 2, 'otro', 2, 1.50, 3.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  ADD CONSTRAINT `productos_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
