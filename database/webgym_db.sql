-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-08-2023 a las 23:37:29
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `webgym_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id`, `cliente_id`, `sucursal_id`, `tipo`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(3, 3, 2, 'INGRESO', '2022-11-22', '2022-11-22 19:31:26', '2022-11-22 19:31:26'),
(4, 3, 2, 'SALIDA', '2022-11-22', '2022-11-22 19:31:45', '2022-11-22 19:31:45'),
(5, 3, 2, 'INGRESO', '2022-11-25', '2022-11-25 14:35:24', '2022-11-25 14:35:24'),
(6, 3, 2, 'SALIDA', '2022-11-25', '2022-11-25 14:35:34', '2022-11-25 14:35:34'),
(7, 2, 3, 'INGRESO', '2022-12-06', '2022-12-06 19:01:54', '2022-12-06 19:01:54'),
(8, 1, 2, 'INGRESO', '2023-01-31', '2023-01-31 16:28:39', '2023-01-31 16:28:39'),
(9, 1, 2, 'SALIDA', '2023-01-31', '2023-01-31 16:29:22', '2023-01-31 16:29:22'),
(10, 3, 2, 'INGRESO', '2023-02-17', '2023-02-18 01:57:47', '2023-02-18 01:57:47'),
(11, 3, 2, 'SALIDA', '2023-02-17', '2023-02-18 01:58:01', '2023-02-18 01:58:01'),
(13, 1, 3, 'INGRESO', '2023-03-09', '2023-03-09 12:58:00', '2023-03-09 12:58:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'CATEGORIA 1'),
(4, 'CATEGORIA 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int NOT NULL,
  `genero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `declaracion_jurada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `fecha_nacimiento`, `edad`, `genero`, `dir`, `fono`, `fono2`, `correo`, `foto`, `declaracion_jurada`, `sucursal_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'HECTOR', 'CARVAJAL', 'RAMIRES', '3223', 'LP', '1998-12-12', 23, 'MASCULINO', 'LOS OLIVOS', '77777', '666666', 'HECTOR@GMAIL.COM', '1668809453_.jpg', '1675179900_1.pdf', 2, '2022-11-18', '2022-11-18 22:10:20', '2023-01-31 15:45:00'),
(2, 'CARLOS', 'LIMA', 'LIMA', '43343', 'LP', '2000-01-01', 22, 'MASCULINO', 'LOS OLIVOS', '3223', '2223', '', 'default.png', NULL, 3, '2022-11-22', '2022-11-22 14:52:45', '2022-11-22 14:52:45'),
(3, 'CARLOS', 'MAMANI', '', '43344', 'LP', '2002-03-03', 20, 'MASCULINO', 'LOS OLIVOS', '222222', '3333333', '', 'default.png', NULL, 2, '2022-11-22', '2022-11-22 15:39:58', '2022-12-06 19:20:25'),
(4, 'MARIA', 'CASTRO', 'CASTRO', '2342', 'LP', '2002-01-01', 20, 'FEMENINO', 'LOS OLIVOS', '', '', '', 'default.png', NULL, 3, '2022-12-06', '2022-12-06 18:45:40', '2022-12-06 18:46:05'),
(5, 'FREDDY', 'LOZANO', 'QUISPE', '5445', 'TJ', '2000-04-03', 22, 'HOMBRE', '', '', '', '', '1675180347_5.jpg', '1675180347_5.pdf', 3, '2023-01-31', '2023-01-31 15:52:27', '2023-01-31 15:52:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `inscripcion_id` bigint UNSIGNED NOT NULL,
  `qr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_cobro` date NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`id`, `cliente_id`, `sucursal_id`, `inscripcion_id`, `qr`, `fecha_cobro`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 5, '', '2022-11-23', '2022-11-23', '2022-11-23 14:09:33', '2022-11-23 14:09:33'),
(3, 1, 2, 1, 'c31676684893.png', '2022-11-23', '2022-11-23', '2022-11-23 14:10:23', '2023-02-18 01:48:13'),
(4, 2, 3, 6, '', '2022-12-06', '2022-12-06', '2022-12-06 19:12:03', '2022-12-06 19:12:03'),
(5, 3, 2, 3, 'v51676684974.png', '2023-02-17', '2023-02-17', '2023-02-18 01:49:34', '2023-02-18 01:49:34'),
(8, 1, 2, 7, 'v81678369204.png', '2023-03-09', '2023-03-09', '2023-03-09 13:40:04', '2023-03-09 13:40:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actividad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracions`
--

INSERT INTO `configuracions` (`id`, `nombre_sistema`, `alias`, `razon_social`, `nit`, `ciudad`, `dir`, `fono`, `web`, `actividad`, `correo`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'SISTEMA DE ADMINISTRACIÓN DE GIMNASIO CON RFID', 'WEBGYM', 'EMPRESA DE PRUEBA GIMNASIO', '1212121', 'LA PAZ', 'LOS OLIVOS', '222222', '', 'ACTIVIDAD', '', '1668795859_logo.png', NULL, '2022-11-18 18:24:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(24,2) NOT NULL,
  `subtotal` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 25.00, 75.00, '2022-12-01 00:28:26', '2022-12-01 00:28:26'),
(2, 1, 2, 4, 35.00, 140.00, '2022-12-01 00:28:26', '2022-12-01 00:28:26'),
(3, 2, 1, 4, 25.00, 100.00, '2022-12-06 15:21:52', '2022-12-06 15:21:52'),
(4, 3, 3, 2, 40.00, 80.00, '2022-12-06 19:37:09', '2022-12-06 19:37:09'),
(5, 4, 3, 2, 40.00, 80.00, '2023-02-18 01:50:14', '2023-02-18 01:50:14'),
(7, 6, 1, 1, 25.00, 25.00, '2023-03-09 13:40:44', '2023-03-09 13:40:44'),
(8, 6, 2, 1, 35.00, 35.00, '2023-03-09 13:41:19', '2023-03-09 13:41:19'),
(9, 7, 1, 4, 25.00, 100.00, '2023-08-09 22:44:31', '2023-08-09 22:52:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono_referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salario` decimal(24,2) DEFAULT NULL,
  `horario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `fono`, `fono_referencia`, `correo`, `fecha_inicio`, `cargo`, `salario`, `horario`, `foto`, `sucursal_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'MATEO', 'RAMIRES', '', '32234', 'LP', 'LOS OLIVOS', '222222', '777777', 'MATEO@GMAIL.COM', '2022-11-01', 'LIMPIEZA', 6000.00, '', 'default.png', 2, '2022-11-21', '2022-11-21 14:57:51', '2022-12-01 19:27:06'),
(2, 'ALEX', 'GONZALES', '', '3333', 'LP', '', '', '', NULL, '2022-12-01', 'CAJERO', NULL, '', 'default.png', 3, '2022-12-01', '2022-12-01 19:26:52', '2022-12-01 19:27:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_fisicas`
--

CREATE TABLE `evaluacion_fisicas` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `talla` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_sangre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persona_referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `peso_inicial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patologias` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `obs_postura` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `recomendaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evaluacion_fisicas`
--

INSERT INTO `evaluacion_fisicas` (`id`, `cliente_id`, `sucursal_id`, `talla`, `tipo_sangre`, `persona_referencia`, `fecha`, `peso_inicial`, `patologias`, `obs_postura`, `recomendaciones`, `created_at`, `updated_at`) VALUES
(2, 2, 3, '1.8', '', '', '2022-12-06', '80', 'PRUEBA EDICION PATOLOGIAS', 'PRUEBA OBS. POSTURA', 'RECOMENDACIONES', '2022-12-06 19:17:45', '2022-12-06 19:25:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imcs`
--

CREATE TABLE `imcs` (
  `id` bigint UNSIGNED NOT NULL,
  `evaluacion_id` bigint UNSIGNED NOT NULL,
  `peso1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imc1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imc2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imc3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imc4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glicemia1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glicemia2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glicemia3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glicemia4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lpm1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lpm2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lpm3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lpm4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oxigeno1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oxigeno2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oxigeno3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oxigeno4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imcs`
--

INSERT INTO `imcs` (`id`, `evaluacion_id`, `peso1`, `peso2`, `peso3`, `peso4`, `imc1`, `imc2`, `imc3`, `imc4`, `glicemia1`, `glicemia2`, `glicemia3`, `glicemia4`, `rpm1`, `rpm2`, `rpm3`, `rpm4`, `lpm1`, `lpm2`, `lpm3`, `lpm4`, `oxigeno1`, `oxigeno2`, `oxigeno3`, `oxigeno4`, `created_at`, `updated_at`) VALUES
(2, 2, '80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-06 19:17:45', '2022-12-06 19:25:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_productos`
--

CREATE TABLE `ingreso_productos` (
  `id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingreso_productos`
--

INSERT INTO `ingreso_productos` (`id`, `sucursal_id`, `producto_id`, `cantidad`, `fecha_ingreso`, `fecha_vencimiento`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 20, '2022-11-25', '2024-11-25', '2022-11-25', '2022-11-25 16:31:52', '2023-08-09 23:32:23'),
(3, 2, 1, 100, '2022-11-25', NULL, '2022-11-25', '2022-11-25 18:18:27', '2022-11-25 18:18:27'),
(4, 2, 1, 20, '2022-11-25', NULL, '2022-11-25', '2022-11-25 18:32:23', '2022-11-25 18:32:23'),
(5, 3, 3, 20, '2022-12-06', NULL, '2022-12-06', '2022-12-06 19:37:05', '2022-12-06 19:37:05'),
(6, 2, 1, 50, '2023-08-09', '2025-08-09', '2023-08-09', '2023-08-09 23:35:09', '2023-08-09 23:35:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcions`
--

CREATE TABLE `inscripcions` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `disciplina` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `fecha_pivote` date DEFAULT NULL,
  `conteo` int NOT NULL,
  `restante` int NOT NULL,
  `pausa` int NOT NULL,
  `fecha_pausa` date DEFAULT NULL,
  `fecha_fin` date NOT NULL,
  `codigo_rfid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VIGENTE',
  `estado_cobro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `justificacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripcions`
--

INSERT INTO `inscripcions` (`id`, `cliente_id`, `plan_id`, `disciplina`, `sucursal_id`, `fecha_inscripcion`, `fecha_pivote`, `conteo`, `restante`, `pausa`, `fecha_pausa`, `fecha_fin`, `codigo_rfid`, `estado`, `estado_cobro`, `justificacion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'PESAS', 2, '2022-01-01', '2022-01-01', 30, 0, 0, NULL, '2022-01-31', '1111', 'CONCLUIDO', 'COMPLETO', NULL, '2022-11-22', '2022-11-22 15:28:16', '2023-02-17 16:12:27'),
(3, 3, 1, 'PESAS', 2, '2022-11-22', '2022-11-22', 30, 0, 0, NULL, '2022-12-22', '1212', 'CONCLUIDO', 'COMPLETO', NULL, '2022-11-22', '2022-11-22 15:40:15', '2023-02-18 01:49:34'),
(5, 1, 1, 'PESAS', 2, '2022-11-23', '2022-11-23', 30, 0, 0, NULL, '2022-12-23', '3333', 'CONCLUIDO', 'COMPLETO', NULL, '2022-11-23', '2022-11-23 14:06:31', '2023-02-17 16:12:27'),
(6, 2, 3, 'PESAS', 3, '2022-12-01', '2022-12-01', 30, 0, 0, NULL, '2022-12-31', '5555', 'CONCLUIDO', 'COMPLETO', NULL, '2022-12-06', '2022-12-06 19:01:00', '2023-02-17 16:12:27'),
(7, 1, 4, 'PESAS', 2, '2023-01-31', '2023-03-09', 30, 0, 0, '2023-02-17', '2023-03-22', '555', 'CONCLUIDO', 'COMPLETO', 'JUSTIFICACION DE PAUSA', '2023-01-31', '2023-01-31 15:08:39', '2023-08-09 22:28:10'),
(8, 3, 2, 'AEROBICOS', 2, '2023-02-17', '2023-02-17', 25, 0, 0, NULL, '2023-03-14', '777', 'CONCLUIDO', 'PENDIENTE', NULL, '2023-02-17', '2023-02-18 01:57:38', '2023-08-09 22:28:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento_maquinas`
--

CREATE TABLE `mantenimiento_maquinas` (
  `id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `maquina_id` bigint UNSIGNED NOT NULL,
  `fecha_mantenimiento` date DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_proximo` date DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mantenimiento_maquinas`
--

INSERT INTO `mantenimiento_maquinas` (`id`, `sucursal_id`, `maquina_id`, `fecha_mantenimiento`, `descripcion`, `fecha_proximo`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2022-11-23', 'DESCRIPCION DEL MANTENIMIENTO ED', '2023-01-23', '2022-11-22', '2022-11-22 14:02:27', '2022-11-22 14:04:50'),
(2, 3, 2, '2022-11-22', 'DESCRIPCION DE PRUEBA DE MANTENIMIENTO REALIZADO A LA MAQUINA DOS', NULL, '2022-11-22', '2022-11-22 14:05:08', '2022-11-22 14:05:08'),
(4, 3, 4, '2022-12-06', 'PRUEBA MANTENIMIENTO USUARIO ENTRENADOR', '2022-02-01', '2022-12-06', '2022-12-06 18:57:00', '2022-12-06 18:57:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

CREATE TABLE `maquinas` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` bigint UNSIGNED NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_incorporacion` date DEFAULT NULL,
  `cantidad` int DEFAULT '0',
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `maquinas`
--

INSERT INTO `maquinas` (`id`, `codigo`, `nombre`, `categoria_id`, `descripcion`, `sucursal_id`, `fecha_incorporacion`, `cantidad`, `foto`, `estado`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, '1', 'MAQUINA 1', 1, 'DESCRIPCION DE LA MAQUINA 1', 2, '2022-11-01', 1, '1669045475_.jpg', 'ACTIVO', '2022-11-21', '2022-11-21 15:43:14', '2023-03-09 13:06:19'),
(2, '2', 'MAQUINA 2', 1, 'DESCRIPCION MAQUINA 2', 3, '2022-11-01', 2, '1669045598_.jpg', 'ACTIVO', '2022-11-21', '2022-11-21 15:46:38', '2023-03-09 13:06:21'),
(3, '3', 'MAQUINA 3', 4, '', 2, NULL, NULL, 'default.png', 'ACTIVO', '2022-12-02', '2022-12-02 13:55:14', '2023-03-09 13:06:23'),
(4, '4', 'MAQUINA PRUEBA SUC. 2', 4, '', 3, '2022-12-06', 1, 'default.png', 'INACTIVO', '2022-12-06', '2022-12-06 18:48:51', '2023-03-09 13:06:25'),
(5, '5', 'MAQUINA 5', 1, '', 3, NULL, NULL, 'default.png', 'INACTIVO', '2023-02-17', '2023-02-17 14:52:42', '2023-03-09 13:06:26'),
(6, '6', 'MAQUINA 6', 1, 'DESC', 2, NULL, NULL, 'default.png', 'ACTIVO', '2023-03-09', '2023-03-09 13:06:43', '2023-03-09 13:06:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000001_create_sucursals_table', 1),
(2, '2014_10_12_000002_create_users_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_10_13_132625_create_configuracions_table', 1),
(5, '2022_11_18_144204_create_plans_table', 1),
(6, '2022_11_18_144548_create_clientes_table', 1),
(7, '2022_11_18_144833_create_empleados_table', 1),
(8, '2022_11_18_145102_create_categorias_table', 1),
(9, '2022_11_18_145103_create_maquinas_table', 1),
(10, '2022_11_18_145359_create_mantenimiento_maquinas_table', 1),
(11, '2022_11_18_145527_create_inscripcions_table', 1),
(12, '2022_11_18_145718_create_accesos_table', 1),
(13, '2022_11_18_145834_create_cobros_table', 1),
(14, '2022_11_18_145937_create_evaluacion_fisicas_table', 1),
(15, '2022_11_18_150435_create_pliegues_table', 1),
(16, '2022_11_18_150444_create_perimetrias_table', 1),
(17, '2022_11_18_150459_create_imcs_table', 1),
(18, '2022_11_18_151115_create_productos_table', 1),
(19, '2022_11_18_151528_create_ingreso_productos_table', 1),
(20, '2022_11_18_151616_create_ventas_table', 1),
(21, '2022_11_18_151800_create_detalle_ventas_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perimetrias`
--

CREATE TABLE `perimetrias` (
  `id` bigint UNSIGNED NOT NULL,
  `evaluacion_id` bigint UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `hombros1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hombros2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hombros3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hombros4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pecho1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pecho2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pecho3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pecho4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_relajado1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_relajado2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_relajado3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_relajado4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_contraido1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_contraido2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_contraido3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biceps_contraido4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antebrazo1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antebrazo2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antebrazo3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antebrazo4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muneca1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muneca2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muneca3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muneca4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cintura1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cintura2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cintura3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cintura4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdomen1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdomen2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdomen3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdomen4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cadera1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cadera2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cadera3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cadera4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rodilla1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rodilla2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rodilla3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rodilla4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobillo1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobillo2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobillo3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tobillo4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perimetrias`
--

INSERT INTO `perimetrias` (`id`, `evaluacion_id`, `fecha`, `hombros1`, `hombros2`, `hombros3`, `hombros4`, `pecho1`, `pecho2`, `pecho3`, `pecho4`, `biceps_relajado1`, `biceps_relajado2`, `biceps_relajado3`, `biceps_relajado4`, `biceps_contraido1`, `biceps_contraido2`, `biceps_contraido3`, `biceps_contraido4`, `antebrazo1`, `antebrazo2`, `antebrazo3`, `antebrazo4`, `muneca1`, `muneca2`, `muneca3`, `muneca4`, `cintura1`, `cintura2`, `cintura3`, `cintura4`, `abdomen1`, `abdomen2`, `abdomen3`, `abdomen4`, `cadera1`, `cadera2`, `cadera3`, `cadera4`, `muslo1`, `muslo2`, `muslo3`, `muslo4`, `rodilla1`, `rodilla2`, `rodilla3`, `rodilla4`, `pantorilla1`, `pantorilla2`, `pantorilla3`, `pantorilla4`, `tobillo1`, `tobillo2`, `tobillo3`, `tobillo4`, `resultado1`, `resultado2`, `resultado3`, `resultado4`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-06 19:17:45', '2022-12-06 19:25:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `duracion` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `todos` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plans`
--

INSERT INTO `plans` (`id`, `sucursal_id`, `nombre`, `costo`, `duracion`, `descripcion`, `todos`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 2, 'PLAN 1', 120.00, 30, 'DESCRIPCION DE PRUEBA', 'NO', '2022-11-18', '2022-11-18 21:48:12', '2022-11-18 21:48:21'),
(2, 2, 'PLAN 2', 90.00, 25, '', 'NO', '2022-11-23', '2022-11-23 14:19:18', '2022-11-23 14:19:18'),
(3, 3, 'PLAN 1 SUC. 2', 190.00, 30, '', 'NO', '2022-12-06', '2022-12-06 19:00:50', '2022-12-06 19:00:50'),
(4, 2, 'PLAN PRUEBA TODOS', 120.00, 30, '', 'SI', '2023-01-31', '2023-01-31 15:07:12', '2023-01-31 15:07:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pliegues`
--

CREATE TABLE `pliegues` (
  `id` bigint UNSIGNED NOT NULL,
  `evaluacion_id` bigint UNSIGNED NOT NULL,
  `fecha` date DEFAULT NULL,
  `bicipital1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bicipital2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bicipital3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bicipital4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tricipital1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tricipital2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tricipital3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tricipital4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subescapular1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subescapular2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subescapular3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subescapular4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `axilar1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `axilar2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `axilar3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `axilar4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pectoral1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pectoral2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pectoral3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pectoral4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdominal1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdominal2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdominal3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdominal4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supraliaco1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supraliaco2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supraliaco3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supraliaco4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muslo4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pantorilla4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pliegues`
--

INSERT INTO `pliegues` (`id`, `evaluacion_id`, `fecha`, `bicipital1`, `bicipital2`, `bicipital3`, `bicipital4`, `tricipital1`, `tricipital2`, `tricipital3`, `tricipital4`, `subescapular1`, `subescapular2`, `subescapular3`, `subescapular4`, `axilar1`, `axilar2`, `axilar3`, `axilar4`, `pectoral1`, `pectoral2`, `pectoral3`, `pectoral4`, `abdominal1`, `abdominal2`, `abdominal3`, `abdominal4`, `supraliaco1`, `supraliaco2`, `supraliaco3`, `supraliaco4`, `muslo1`, `muslo2`, `muslo3`, `muslo4`, `pantorilla1`, `pantorilla2`, `pantorilla3`, `pantorilla4`, `resultado1`, `resultado2`, `resultado3`, `resultado4`, `created_at`, `updated_at`) VALUES
(2, 2, '2022-12-06', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-06 19:17:45', '2022-12-06 19:25:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria_id` bigint UNSIGNED NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `precio` decimal(24,2) NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_actual` int NOT NULL,
  `ingresos` int NOT NULL,
  `salidas` int NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria_id`, `descripcion`, `precio`, `sucursal_id`, `foto`, `stock_actual`, `ingresos`, `salidas`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'PRODUCTO 1', 1, 'DESCRIPCION DEL NUEVO PRODUCTO', 25.00, 2, '1669388507_PRODUCTO_1.jpg', 158, 170, 12, '2022-11-25', '2022-11-25 15:01:03', '2023-08-09 23:35:09'),
(2, 'PRODUCTO 2', 4, 'DESC PROD. 2', 35.00, 2, '1669388523_PRODUCTO_2.jpg', 15, 20, 5, '2022-11-25', '2022-11-25 15:02:03', '2023-08-09 23:32:23'),
(3, 'PRODUCTO 3', 4, '', 40.00, 3, 'default.png', 16, 20, 4, '2022-12-06', '2022-12-06 14:35:47', '2023-02-18 01:50:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursals`
--

CREATE TABLE `sucursals` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursals`
--

INSERT INTO `sucursals` (`id`, `nombre`, `dir`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, '*', NULL, '2022-11-18', NULL, NULL),
(2, 'SUCURSAL 1', '', '2022-11-18', '2022-11-18 19:16:10', '2022-11-18 19:19:50'),
(3, 'SUCURSAL 2', 'LOS OLIVOS', '2022-11-18', '2022-11-18 19:16:22', '2022-11-18 19:16:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `codigo`, `password`, `correo`, `tipo`, `foto`, `sucursal_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$cDSOdzTsMDQAfqcb6.WFtu40s.wmQ4Jl8poIwW69MSZnnedD3prKu', NULL, 'GERENTE', 'default.png', 1, '2022-11-18', NULL, NULL),
(2, 'JUAN PERES', 'JPERES', '$2y$10$yXDHTmz.YBHOjq9SOdGSDOzl2GF1ftrVpKGd55OjJL79wnK/AWRnG', 'JUAN@GMAIL.COM', 'ENCARGADO DE RECEPCIÓN', 'default.png', 2, '2022-11-18', '2022-11-18 20:08:13', '2022-12-06 18:33:16'),
(3, 'MARIA PRADO', 'MPRADO', '$2y$10$lOi3dUZ57z.JtvrAH41LTuVcEwzMiU938tCr80mLcjTWtPgtisv2q', '', 'ENCARGADO DE RECEPCIÓN', 'default.png', 3, '2022-11-18', '2022-11-18 20:15:29', '2022-12-06 18:30:28'),
(5, 'MARCELO PAREDES', 'MPAREDES', '$2y$10$HjU5ATNZsOF.uCBqOoFiCu.s46KrCeCHz96LHs38PvckXFdstsyay', '', 'GERENTE', 'default.png', 1, '2022-11-18', '2022-11-18 20:24:52', '2022-11-18 20:29:07'),
(6, 'EDUARDO ARANCIBIA', 'EARANCIBIA', '$2y$10$vWaCmBw1.pAu7pHqiNgGd.bLABVLRuPVVDOrJtTZfln.BllPvdukm', '', 'ENCARGADO DE RECEPCIÓN', 'default.png', 2, '2022-11-30', '2022-12-01 00:57:38', '2022-12-01 00:57:38'),
(7, 'ALEX CONTRERAS', 'ACONTRERAS', '$2y$10$2wQa.HmoZN6bFD7ziQ10YOVydos.Vh22f2Lt3.9U8gDcCn3CJpGJW', '', 'ENTRENADOR', 'default.png', 2, '2022-12-06', '2022-12-06 18:34:09', '2022-12-06 18:34:09'),
(8, 'ESTHER MOLINA', 'EMOLINA', '$2y$10$91n6gvHoFy3llKPUx9WUCO/ZYof5cXYijt7Yqk3GdtEtjoTSBjF3a', '', 'ENTRENADOR', 'default.png', 3, '2022-12-06', '2022-12-06 18:49:21', '2022-12-06 18:49:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `qr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `sucursal_id`, `cliente_id`, `total`, `qr`, `fecha`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 215.00, 'v11676684602.png', '2022-11-30', '2022-11-30', '2022-12-01 00:28:25', '2023-02-18 01:43:22'),
(2, 2, 3, 100.00, '', '2022-12-06', '2022-12-06', '2022-12-06 15:21:52', '2022-12-06 15:21:52'),
(3, 3, 2, 80.00, '', '2022-12-06', '2022-12-06', '2022-12-06 19:37:09', '2022-12-06 19:37:09'),
(4, 3, 4, 80.00, 'v41676685014.png', '2023-02-17', '2023-02-17', '2023-02-18 01:50:14', '2023-02-18 01:50:14'),
(6, 2, 1, 60.00, 'v61678369279.png', '2023-03-09', '2023-03-09', '2023-03-09 13:40:44', '2023-03-09 13:41:19'),
(7, 2, 1, 100.00, 'v71691621568.png', '2023-08-09', '2023-08-09', '2023-08-09 22:44:31', '2023-08-09 22:52:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  ADD KEY `detalle_ventas_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleados_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `evaluacion_fisicas`
--
ALTER TABLE `evaluacion_fisicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imcs`
--
ALTER TABLE `imcs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imcs_evaluacion_id_foreign` (`evaluacion_id`);

--
-- Indices de la tabla `ingreso_productos`
--
ALTER TABLE `ingreso_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingreso_productos_sucursal_id_foreign` (`sucursal_id`),
  ADD KEY `ingreso_productos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inscripcions_codigo_rfid_unique` (`codigo_rfid`),
  ADD KEY `inscripcions_cliente_id_foreign` (`cliente_id`),
  ADD KEY `inscripcions_plan_id_foreign` (`plan_id`),
  ADD KEY `inscripcions_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `mantenimiento_maquinas`
--
ALTER TABLE `mantenimiento_maquinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mantenimiento_maquinas_maquina_id_foreign` (`maquina_id`);

--
-- Indices de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maquinas_categoria_id_foreign` (`categoria_id`),
  ADD KEY `maquinas_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perimetrias`
--
ALTER TABLE `perimetrias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perimetrias_evaluacion_id_foreign` (`evaluacion_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plans_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `pliegues`
--
ALTER TABLE `pliegues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pliegues_evaluacion_id_foreign` (`evaluacion_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_codigo_unique` (`codigo`),
  ADD KEY `users_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_sucursal_id_foreign` (`sucursal_id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evaluacion_fisicas`
--
ALTER TABLE `evaluacion_fisicas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `imcs`
--
ALTER TABLE `imcs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingreso_productos`
--
ALTER TABLE `ingreso_productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mantenimiento_maquinas`
--
ALTER TABLE `mantenimiento_maquinas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `perimetrias`
--
ALTER TABLE `perimetrias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pliegues`
--
ALTER TABLE `pliegues`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `imcs`
--
ALTER TABLE `imcs`
  ADD CONSTRAINT `imcs_evaluacion_id_foreign` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluacion_fisicas` (`id`);

--
-- Filtros para la tabla `ingreso_productos`
--
ALTER TABLE `ingreso_productos`
  ADD CONSTRAINT `ingreso_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `ingreso_productos_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  ADD CONSTRAINT `inscripcions_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `inscripcions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  ADD CONSTRAINT `inscripcions_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `mantenimiento_maquinas`
--
ALTER TABLE `mantenimiento_maquinas`
  ADD CONSTRAINT `mantenimiento_maquinas_maquina_id_foreign` FOREIGN KEY (`maquina_id`) REFERENCES `maquinas` (`id`);

--
-- Filtros para la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD CONSTRAINT `maquinas_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `maquinas_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `perimetrias`
--
ALTER TABLE `perimetrias`
  ADD CONSTRAINT `perimetrias_evaluacion_id_foreign` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluacion_fisicas` (`id`);

--
-- Filtros para la tabla `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `pliegues`
--
ALTER TABLE `pliegues`
  ADD CONSTRAINT `pliegues_evaluacion_id_foreign` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluacion_fisicas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
