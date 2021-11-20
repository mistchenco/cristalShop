-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2021 a las 18:48:31
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cristalshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idCompra` bigint(20) NOT NULL,
  `compraFecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idUsuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idCompra`, `compraFecha`, `idUsuario`) VALUES
(1, '2021-11-17 00:47:08', 1),
(2, '2021-11-17 00:47:15', 1),
(3, '2021-11-17 00:47:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idCompraEstado` bigint(20) UNSIGNED NOT NULL,
  `idCompra` bigint(11) NOT NULL,
  `idCompraEstadoTipo` int(11) NOT NULL,
  `compraEstadoFechaInicial` timestamp NOT NULL DEFAULT current_timestamp(),
  `compraEstadoFechaFinal` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idCompraEstadoTipo` int(11) NOT NULL,
  `compraEstadoTipoDescripcion` varchar(50) NOT NULL,
  `compraEstadoTipoDetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idCompraEstadoTipo`, `compraEstadoTipoDescripcion`, `compraEstadoTipoDetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idCompraItem` bigint(20) UNSIGNED NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `compraItemCantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` int(11) NOT NULL,
  `menombre` varchar(50) DEFAULT NULL,
  `medescripcion` varchar(50) DEFAULT NULL,
  `idpadre` int(11) DEFAULT NULL,
  `medeshabilitado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'Administrador', '#', NULL, NULL),
(2, 'Deposito', '#', NULL, NULL),
(3, 'Cliente', '#', NULL, NULL),
(11, 'Administrar Productos', '../ejercicios/listarProductos.php', 2, NULL),
(15, 'prueba', 'testing', 2, NULL),
(16, 'agreagar menu', 'eeeeeeeee', 2, NULL),
(17, 'usuarios', '../ejercicios/listarUsuarios.php', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` int(11) NOT NULL,
  `idRol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idRol`) VALUES
(1, 1),
(2, 2),
(3, 3),
(11, 2),
(17, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` bigint(20) NOT NULL,
  `productoNombre` varchar(200) NOT NULL,
  `productoDetalle` varchar(512) NOT NULL,
  `productoStock` int(11) NOT NULL,
  `productoPrecio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `productoNombre`, `productoDetalle`, `productoStock`, `productoPrecio`) VALUES
(32, 'Piedrita', 'piedra chiquita', 3, 150),
(33, 'amatista', 'Piedara negra de color hermoso', 10, 100),
(34, 'procuto 1', 'eoiemjoim', 10, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` bigint(20) NOT NULL,
  `rolDescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rolDescripcion`) VALUES
(1, 'Admin'),
(2, 'Deposito'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `usNombre` varchar(50) NOT NULL,
  `usPass` varchar(250) NOT NULL,
  `usMail` varchar(50) NOT NULL,
  `usDesabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usNombre`, `usPass`, `usMail`, `usDesabilitado`) VALUES
(1, 'jota', 'd396d55189db35d2cddc82ba7742b129', 'jjulian.mora@est.fi.uncoma.edu.ar', NULL),
(3, 'Cliente', 'd396d55189db35d2cddc82ba7742b129', 'cliente@cliente.com.ar', NULL),
(5, 'Deposito', 'd396d55189db35d2cddc82ba7742b129', 'desposito@clistalshop.com.ar', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idUsuario` bigint(20) NOT NULL,
  `idRol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idUsuario`, `idRol`) VALUES
(1, 1),
(1, 2),
(3, 3),
(5, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idCompra`),
  ADD UNIQUE KEY `idcompra` (`idCompra`),
  ADD KEY `fkcompra_1` (`idUsuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idCompraEstado`),
  ADD UNIQUE KEY `idcompraestado` (`idCompraEstado`),
  ADD KEY `fkcompraestado_1` (`idCompra`),
  ADD KEY `fkcompraestado_2` (`idCompraEstadoTipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idCompraEstadoTipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idCompraItem`),
  ADD UNIQUE KEY `idCompraItem` (`idCompraItem`) USING BTREE,
  ADD KEY `fkcompraitem_2` (`idProducto`),
  ADD KEY `fkcompraitem_1` (`idCompra`) USING BTREE;

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idRol`),
  ADD KEY `idmenu` (`idmenu`) USING BTREE,
  ADD KEY `idRol` (`idRol`) USING BTREE;

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `idProducto` (`idProducto`) USING BTREE;

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `idRol` (`idRol`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `idusuario` (`idUsuario`) USING BTREE;

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idUsuario`,`idRol`),
  ADD KEY `idUsuario` (`idUsuario`) USING BTREE,
  ADD KEY `idRol` (`idRol`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idCompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idCompraEstado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idCompraItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idCompraEstadoTipo`) REFERENCES `compraestadotipo` (`idCompraEstadoTipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idProducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmovimiento_2` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `menurol_ibfk_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
