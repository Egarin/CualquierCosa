-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-02-2026 a las 08:17:16
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `minimarket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE IF NOT EXISTS `carrito` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cart_item` (`usuario_id`,`session_id`,`producto_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `session_id`, `producto_id`, `cantidad`, `created_at`, `updated_at`) VALUES
(4, 1, NULL, 2, 4, '2026-02-13 10:15:32', '2026-02-13 10:27:31'),
(7, 2, NULL, 1, 1, '2026-02-13 11:15:59', '2026-02-13 11:15:59'),
(6, 2, NULL, 2, 1, '2026-02-13 10:43:56', '2026-02-13 10:43:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `icono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#0d6efd',
  `orden` int DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `descripcion`, `icono`, `color`, `orden`, `activo`, `created_at`) VALUES
(1, 'Almacén', 'almacen', NULL, 'bx bx-package', '#ff6b6b', 0, 1, '2026-02-13 02:43:41'),
(2, 'Lácteos', 'lacteos', NULL, 'bx bx-drink', '#4ecdc4', 0, 1, '2026-02-13 02:43:41'),
(3, 'Bebidas', 'bebidas', NULL, 'bx bx-glass', '#45b7d1', 0, 1, '2026-02-13 02:43:41'),
(4, 'Limpieza', 'limpieza', NULL, 'bx bx-brush', '#f9ca24', 0, 1, '2026-02-13 02:43:41'),
(5, 'Snacks', 'snacks', NULL, 'bx bx-cookie', '#6c5ce7', 0, 1, '2026-02-13 02:43:41'),
(6, 'Frutas y Verduras', 'frutas-verduras', NULL, 'bx bx-leaf', '#00b894', 0, 1, '2026-02-13 02:43:41'),
(7, 'Herramientas', '', 'todo tipo de herrramientas', '', '#3e68a8', 0, 1, '2026-02-13 05:30:00'),
(8, 'Plomeria', 'plomeria', 'ssdfsd', '', '#0d6efd', 1, 1, '2026-02-13 05:38:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

DROP TABLE IF EXISTS `detalle_pedidos`;
CREATE TABLE IF NOT EXISTS `detalle_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
CREATE TABLE IF NOT EXISTS `direcciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` text COLLATE utf8mb4_unicode_ci,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `es_principal` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `usuario_id`, `alias`, `direccion`, `referencia`, `latitud`, `longitud`, `es_principal`, `created_at`) VALUES
(1, 2, 'casa', 'calle 1 y calle2', 'plaza agricultor pyo', NULL, NULL, 0, '2026-02-13 10:39:11'),
(2, 2, 'trabajo', 'iturbe y manuel dominguez', '', NULL, NULL, 1, '2026-02-13 10:40:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_pedidos`
--

DROP TABLE IF EXISTS `historial_pedidos`;
CREATE TABLE IF NOT EXISTS `historial_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `estado_anterior` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_nuevo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `usuario_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `direccion_id` int DEFAULT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `costo_envio` decimal(10,2) DEFAULT '0.00',
  `descuento` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `tipo_envio` enum('delivery','pickup') COLLATE utf8mb4_unicode_ci DEFAULT 'delivery',
  `estado` enum('pendiente','confirmado','preparando','listo','en_camino','entregado','cancelado') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `metodo_pago` enum('efectivo','tarjeta','transferencia','yape','plin') COLLATE utf8mb4_unicode_ci DEFAULT 'efectivo',
  `notas` text COLLATE utf8mb4_unicode_ci,
  `fecha_entrega` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `usuario_id` (`usuario_id`),
  KEY `direccion_id` (`direccion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio` decimal(10,2) NOT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `stock_minimo` int DEFAULT '5',
  `unidad` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'unidad',
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `slug` (`slug`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `codigo`, `nombre`, `slug`, `descripcion`, `precio`, `precio_oferta`, `stock`, `stock_minimo`, `unidad`, `imagen`, `marca`, `peso`, `destacado`, `activo`, `created_at`, `updated_at`) VALUES
(1, 2, '12323', 'Prueba', 'prueba', 'asdsad', 10000.00, 8000.00, 10000, 5, 'gs', '1770959445_0fa620cd80fa44e93ed6.png', 'puma', 10.00, 0, 1, '2026-02-13 08:10:45', '2026-02-13 09:20:52'),
(2, 1, '445533', ' champion usado', 'champion-usado', 'pprueba', 10000.00, 9000.00, 100000, 5, 'unidad', '1770960875_6eeff7c0062c65f3fa27.png', 'china', 10.00, 0, 1, '2026-02-13 08:34:15', '2026-02-13 09:20:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('admin','cliente') COLLATE utf8mb4_unicode_ci DEFAULT 'cliente',
  `activo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `rol`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin@minimarket.com', '$2y$10$5MdmBXVZMgWYo.XOJ6rfwO.mEOKVcJg6/2JwzDf2y0SDpT82snIN6', NULL, 'admin', 1, '2026-02-13 02:43:40', '2026-02-13 04:39:30'),
(2, 'Edgar Insfrán', 'einsfran83@gmail.com', '$2y$10$5MdmBXVZMgWYo.XOJ6rfwO.mEOKVcJg6/2JwzDf2y0SDpT82snIN6', '0981486378', 'cliente', 1, '2026-02-13 07:35:50', '2026-02-13 07:35:50');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
