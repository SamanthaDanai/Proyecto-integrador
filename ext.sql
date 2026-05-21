-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2026 a las 16:53:27
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ext`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `horario` varchar(50) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `cupo` int DEFAULT NULL,
  `requerimiento` text,
  `id_area` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `nombre`, `descripcion`, `horario`, `fecha_inicio`, `fecha_final`, `cupo`, `requerimiento`, `id_area`) VALUES
(1, 'Torneo de Fútbol', 'Competencia entre grupos del turno matutino', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Práctica de Basquetbol', 'Entrenamiento de fundamentos técnicos', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Acondicionamiento Físico', 'Sesión de ejercicios generales', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_extraesc`
--

CREATE TABLE `act_extraesc` (
  `id_act` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `act_extraesc`
--

INSERT INTO `act_extraesc` (`id_act`, `nombre`, `activo`) VALUES
(1, 'Escolta', 1),
(2, 'Banderolas', 1),
(3, 'Danza folclórica', 1),
(4, 'Bailes latinos', 1),
(5, 'Música rondalla', 1),
(6, 'Grupo alternativo', 1),
(7, 'Arcilla', 1),
(8, 'Lenguaje de señas', 1),
(9, 'Basquetbol', 1),
(10, 'Futbol', 1),
(11, 'Atletismo', 1),
(12, 'Volibol', 1),
(13, 'Beisbol', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `dimensiones` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `nombre`, `dimensiones`) VALUES
(1, 'Campo de futbol', '105m x 68m'),
(2, 'Canchas de basquetbol', '28m x 15m'),
(3, 'T\r\n echado', '20m x 30m');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` int NOT NULL,
  `nombre_carrera` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `nombre_carrera`, `activo`) VALUES
(1, 'Ingeniería en Sistemas Computacionales', 1),
(2, 'Ingeniería en Electromecánica', 1),
(3, 'Ingeniería Industrial', 1),
(4, 'Ingeniería en Gestión Empresarial', 1),
(5, 'Ingeniería Ambiental', 1),
(6, 'Contador Público', 1),
(7, 'Licenciatura en Turismo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `no_empleado` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apet` varchar(50) NOT NULL,
  `amat` varchar(50) NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `fotografia` text,
  `perfil` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`no_empleado`, `nombre`, `apet`, `amat`, `genero`, `fotografia`, `perfil`) VALUES
('EMP001', 'Laura', 'García', 'Mendoza', 'Femenino', 'laura_g.jpg', 'Especialista en Desarrollo Web y PHP'),
('EMP002', 'Carlos', 'Rodríguez', 'Pérez', 'Masculino', 'carlos_r.jpg', 'Ingeniero en Ciberseguridad y Redes'),
('EMP003', 'Ana', 'Martínez', 'Sánchez', 'Femenino', 'ana_m.jpg', 'Doctora en Inteligencia Artificial'),
('EMP004', 'Roberto', 'López', 'Gómez', 'Masculino', 'roberto_l.jpg', 'Experto en Bases de Datos Relacionales'),
('EMP005', 'Sofía', 'Hernández', 'Ruiz', 'Femenino', 'sofia_h.jpg', 'Desarrolladora Fullstack y Arquitecta de Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int NOT NULL,
  `tipo_evento` varchar(100) DEFAULT NULL,
  `docente` varchar(100) DEFAULT NULL,
  `asunto` varchar(200) DEFAULT NULL,
  `id_actividad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id_evento`, `tipo_evento`, `docente`, `asunto`, `id_actividad`) VALUES
(1, 'Deportivo', 'EMP001', 'Torneo Relámpago de Fútbol Interescolar', 1),
(2, 'Entrenamiento', 'EMP002', 'Prácticas de Tiro Libre y Técnica', 2),
(3, 'Clase Abierta', 'EMP005', 'Demostración de Acondicionamiento Físico', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imparte`
--

CREATE TABLE `imparte` (
  `id_actividad` int NOT NULL,
  `no_empleado` varchar(20) NOT NULL,
  `periodo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribe`
--

CREATE TABLE `inscribe` (
  `num_control` varchar(20) NOT NULL,
  `id_actividad` int NOT NULL,
  `periodo` varchar(20) DEFAULT NULL,
  `calificacion` decimal(4,2) DEFAULT NULL,
  `obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logistica`
--

CREATE TABLE `logistica` (
  `id_logistica` int NOT NULL,
  `coordinador` varchar(100) DEFAULT NULL,
  `lugar` varchar(150) DEFAULT NULL,
  `fecha_evento` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `id_evento` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_11_20_185052_add_timestamps_to_usuario_table', 1),
(6, '2026_04_11_063015_create_carreras_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participa`
--

CREATE TABLE `participa` (
  `num_control` varchar(20) NOT NULL,
  `id_evento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `participa`
--

INSERT INTO `participa` (`num_control`, `id_evento`) VALUES
('NC20240001', 1),
('NC20240003', 2),
('NC20240005', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id_rec` int NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `unidad_med` varchar(50) DEFAULT NULL,
  `cantidad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_rec`, `descripcion`, `unidad_med`, `cantidad`) VALUES
(1, 'Banderas oficiales', 'Pieza', 5),
(2, 'Portabanderas', 'Pieza', 4),
(3, 'Guantes ceremoniales', 'Par', 12),
(4, 'Uniformes de escolta', 'Juego', 15),
(5, 'Banderolas', 'Pieza', 20),
(6, 'Pinturas textiles', 'Caja', 6),
(7, 'Telas de colores', 'Metro', 40),
(8, 'Pinceles', 'Paquete', 10),
(9, 'Vestuario folclórico', 'Juego', 20),
(10, 'Zapatos de danza', 'Par', 15),
(11, 'Reproductor de música', 'Pieza', 2),
(12, 'Bocinas', 'Pieza', 4),
(13, 'Vestuario de baile', 'Juego', 18),
(14, 'Espejos de salón', 'Pieza', 5),
(15, 'Tapetes de danza', 'Pieza', 10),
(16, 'Iluminación para danza', 'Pieza', 3),
(17, 'Guitarras acústicas', 'Pieza', 8),
(18, 'Afinadores', 'Pieza', 6),
(19, 'Micrófonos', 'Pieza', 5),
(20, 'Atriles', 'Pieza', 8),
(21, 'Cuerdas para guitarra', 'Juego', 10),
(22, 'Batería', 'Pieza', 1),
(23, 'Amplificadores', 'Pieza', 3),
(24, 'Cables de audio', 'Pieza', 12),
(25, 'Pedales de efectos', 'Pieza', 4),
(26, 'Arcilla', 'Bolsa', 15),
(27, 'Rodillos', 'Pieza', 8),
(28, 'Espátulas', 'Pieza', 12),
(29, 'Horno cerámico', 'Pieza', 1),
(30, 'Moldes para arcilla', 'Juego', 10),
(31, 'Libros didácticos', 'Pieza', 15),
(32, 'Proyector', 'Pieza', 1),
(33, 'Pantalla', 'Pieza', 1),
(34, 'Cuadernos', 'Pieza', 20),
(35, 'Marcadores', 'Paquete', 8),
(36, 'Balones de básquetbol', 'Pieza', 10),
(37, 'Aros de básquet', 'Pieza', 4),
(38, 'Tableros', 'Pieza', 2),
(39, 'Uniformes deportivos', 'Juego', 15),
(40, 'Silbatos', 'Pieza', 6),
(41, 'Balones de fútbol', 'Pieza', 12),
(42, 'Porterías', 'Pieza', 2),
(43, 'Conos de entrenamiento', 'Pieza', 25),
(44, 'Cronómetros', 'Pieza', 5),
(45, 'Vallas de atletismo', 'Pieza', 10),
(46, 'Testigos de relevo', 'Pieza', 8),
(47, 'Pesas deportivas', 'Juego', 6),
(48, 'Balones de volibol', 'Pieza', 10),
(49, 'Redes', 'Pieza', 3),
(50, 'Postes', 'Pieza', 2),
(51, 'Bates', 'Pieza', 10),
(52, 'Guantes de béisbol', 'Pieza', 12),
(53, 'Pelotas de béisbol', 'Caja', 6),
(54, 'Cascos', 'Pieza', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacion`
--

CREATE TABLE `relacion` (
  `id_logistica` int NOT NULL,
  `id_rec` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo` int NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo`, `descripcion`, `activo`) VALUES
(1, 'Administrador', 1),
(2, 'Estudiante', 1),
(4, 'Docente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `num_control` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apat` varchar(50) NOT NULL,
  `amat` varchar(50) NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `turno` enum('Matutino','Vespertino') NOT NULL,
  `correo_inst` varchar(100) NOT NULL,
  `carrera` varchar(100) NOT NULL,
  `generacion` varchar(15) NOT NULL,
  `actividad_extraescolar` int DEFAULT NULL,
  `contrasena` varchar(200) NOT NULL,
  `id_tipo` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fotografia_perfil` varchar(255) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`num_control`, `nombre`, `apat`, `amat`, `genero`, `turno`, `correo_inst`, `carrera`, `generacion`, `actividad_extraescolar`, `contrasena`, `id_tipo`, `created_at`, `updated_at`, `fotografia_perfil`) VALUES
('22240029', 'Samantha Danai', 'Torres', 'Vázquez', 'Femenino', 'Matutino', 'l22240029@smartin.tecnm.mx', 'ISC', '2020-2024', 1, 'Torres16.', 1, '2026-04-11 14:08:30', '2026-04-11 14:14:28', 'perfil_22240029_1775895260.jpg'),
('NC20240001', 'Carlos', 'Hernandez', 'Lopez', 'Masculino', 'Matutino', 'c20240001@smartin.tecnm.mx', 'Ingeniería en Sistemas Computacionales', '2020-2024', 1, 'hash123', 2, NULL, NULL, NULL),
('NC20240002', 'Mariana', 'Gomez', 'Perez', 'Femenino', 'Vespertino', 'm20240002@smartin.tecnm.mx', 'Ingeniería Industrial', '2021-2025', 2, 'hash123', 2, NULL, NULL, NULL),
('NC20240003', 'Luis', 'Martinez', 'Ramirez', 'Masculino', 'Matutino', 'l20240003@smartin.tecnm.mx', 'Ingeniería en Electromecánica', '2020-2024', 3, 'hash123', 2, NULL, NULL, NULL),
('NC20240004', 'Andrea', 'Torres', 'Mora', 'Femenino', 'Vespertino', 'a20240004@smartin.tecnm.mx', 'Ingeniería Ambiental', '2021-2025', 4, 'hash123', 2, NULL, NULL, NULL),
('NC20240005', 'Jorge', 'Cruz', 'Santos', 'Masculino', 'Matutino', 'j20240005@smartin.tecnm.mx', 'Ingeniería en Gestión Empresarial', '2022-2026', 5, 'hash123', 2, NULL, NULL, NULL),
('NC20240006', 'Paola', 'Reyes', 'Ortiz', 'Femenino', 'Matutino', 'p20240006@smartin.tecnm.mx', 'Licenciatura en Turismo', '2020-2024', 6, 'hash123', 2, NULL, NULL, NULL),
('NC20240007', 'Miguel', 'Ramos', 'Flores', 'Masculino', 'Vespertino', 'm20240007@smartin.tecnm.mx', 'Contador Público', '2021-2025', 7, 'hash123', 2, NULL, NULL, NULL),
('NC20240008', 'Sofia', 'Luna', 'Vargas', 'Femenino', 'Matutino', 's20240008@smartin.tecnm.mx', 'Ingeniería en Sistemas Computacionales', '2022-2026', 8, 'hash123', 2, NULL, NULL, NULL),
('NC20240009', 'Daniel', 'Navarro', 'Castro', 'Masculino', 'Vespertino', 'd20240009@smartin.tecnm.mx', 'Ingeniería Industrial', '2020-2024', 9, 'hash123', 2, NULL, NULL, NULL),
('NC20240010', 'Fernanda', 'Rios', 'Ponce', 'Femenino', 'Matutino', 'f20240010@smartin.tecnm.mx', 'Ingeniería Ambiental', '2021-2025', 10, 'hash123', 2, NULL, NULL, NULL),
('NC20240011', 'Oscar', 'Delgado', 'Meza', 'Masculino', 'Matutino', 'o20240011@smartin.tecnm.mx', 'Ingeniería en Electromecánica', '2020-2024', 11, 'hash123', 2, NULL, NULL, NULL),
('NC20240012', 'Valeria', 'Morales', 'Suarez', 'Femenino', 'Vespertino', 'v20240012@smartin.tecnm.mx', 'Ingeniería en Gestión Empresarial', '2021-2025', 12, 'hash123', 2, NULL, NULL, NULL),
('NC20240013', 'Ricardo', 'Alvarez', 'Jimenez', 'Masculino', 'Matutino', 'r20240013@smartin.tecnm.mx', 'Ingeniería Industrial', '2022-2026', 13, 'hash123', 2, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `act_extraesc`
--
ALTER TABLE `act_extraesc`
  ADD PRIMARY KEY (`id_act`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`no_empleado`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `imparte`
--
ALTER TABLE `imparte`
  ADD PRIMARY KEY (`id_actividad`,`no_empleado`),
  ADD KEY `no_empleado` (`no_empleado`);

--
-- Indices de la tabla `inscribe`
--
ALTER TABLE `inscribe`
  ADD PRIMARY KEY (`num_control`,`id_actividad`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `logistica`
--
ALTER TABLE `logistica`
  ADD PRIMARY KEY (`id_logistica`),
  ADD UNIQUE KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participa`
--
ALTER TABLE `participa`
  ADD PRIMARY KEY (`num_control`,`id_evento`),
  ADD UNIQUE KEY `num_control` (`num_control`),
  ADD UNIQUE KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_rec`);

--
-- Indices de la tabla `relacion`
--
ALTER TABLE `relacion`
  ADD PRIMARY KEY (`id_logistica`,`id_rec`),
  ADD KEY `id_rec` (`id_rec`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`num_control`),
  ADD UNIQUE KEY `correo_inst` (`correo_inst`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `actividad_extraescolar` (`actividad_extraescolar`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `act_extraesc`
--
ALTER TABLE `act_extraesc`
  MODIFY `id_act` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id_carrera` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logistica`
--
ALTER TABLE `logistica`
  MODIFY `id_logistica` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_rec` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `imparte`
--
ALTER TABLE `imparte`
  ADD CONSTRAINT `imparte_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `imparte_ibfk_2` FOREIGN KEY (`no_empleado`) REFERENCES `docente` (`no_empleado`);

--
-- Filtros para la tabla `inscribe`
--
ALTER TABLE `inscribe`
  ADD CONSTRAINT `inscribe_ibfk_1` FOREIGN KEY (`num_control`) REFERENCES `usuario` (`num_control`),
  ADD CONSTRAINT `inscribe_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `logistica`
--
ALTER TABLE `logistica`
  ADD CONSTRAINT `logistica_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`);

--
-- Filtros para la tabla `participa`
--
ALTER TABLE `participa`
  ADD CONSTRAINT `participa_ibfk_1` FOREIGN KEY (`num_control`) REFERENCES `usuario` (`num_control`),
  ADD CONSTRAINT `participa_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`);

--
-- Filtros para la tabla `relacion`
--
ALTER TABLE `relacion`
  ADD CONSTRAINT `relacion_ibfk_1` FOREIGN KEY (`id_logistica`) REFERENCES `logistica` (`id_logistica`),
  ADD CONSTRAINT `relacion_ibfk_2` FOREIGN KEY (`id_rec`) REFERENCES `recurso` (`id_rec`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`actividad_extraescolar`) REFERENCES `act_extraesc` (`id_act`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
