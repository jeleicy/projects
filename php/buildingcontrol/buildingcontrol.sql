-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2018 a las 23:00:05
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `buildingcontrol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activitiemployee`
--

CREATE TABLE `activitiemployee` (
  `id` int(11) NOT NULL,
  `idEmployee` int(11) DEFAULT NULL,
  `idActivitie` int(11) DEFAULT NULL,
  `idBuilding` int(11) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `apartment` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `ActivitiDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Observations` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`id`, `name`, `updated_at`, `created_at`, `idCondominium`) VALUES
(20, 'Painting', '2018-07-25', '2018-07-24', 15),
(21, 'Change Lights', '2018-07-25', '2018-07-24', 15),
(22, 'Clean the Floor', '2018-07-25', '2018-07-24', 15),
(23, 'Change Carpet', '2018-07-25', '2018-07-25', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `idCondominium` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `building`
--

INSERT INTO `building` (`id`, `idCondominium`, `name`, `updated_at`, `created_at`) VALUES
(2, 15, 'Building 1', '2018-07-25', '2018-07-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condominium`
--

CREATE TABLE `condominium` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `manager` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `condominium`
--

INSERT INTO `condominium` (`id`, `name`, `address`, `manager`, `logo`, `phone`, `updated_at`, `created_at`) VALUES
(0, 'SuperUser', 'SuperUser', 'SuperUser', NULL, '', '2018-07-25', '2018-07-25'),
(12, 'Poinciana of Aventura', 'Pinciana', 'Luis Marcano', '12.jpg', '775553336', '2018-07-24', '2018-07-24'),
(15, 'Aventura Yatch Club de Florida', '19501 E Country Club Dr', 'Walter Silva', '15.jpg', '7865698995', '2018-07-24', '2018-07-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `datehire` date DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `employee`
--

INSERT INTO `employee` (`id`, `name`, `datehire`, `phone`, `updated_at`, `created_at`, `idCondominium`) VALUES
(4, 'Walter Silva', '2012-06-15', '7865698995', '2018-07-25', '2018-07-25', 15),
(12, 'Gabriel Ramos', '2009-10-09', '7775555553', '2018-07-25', '2018-07-25', 15),
(14, 'Valeria Ramos', '2012-03-23', '7865698995', '2018-07-25', '2018-07-25', 12),
(15, 'Juan Ramos', '1978-10-10', '7865698996', '2018-07-25', '2018-07-25', 15),
(16, 'Jeleicy Figueroa', '1978-04-04', '7865698995', '2018-07-25', '2018-07-25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `idItem` int(11) DEFAULT NULL,
  `entryDate` date DEFAULT NULL,
  `entryQuantity` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `presentation` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemused`
--

CREATE TABLE `itemused` (
  `id` int(11) NOT NULL,
  `idItem` int(11) DEFAULT NULL,
  `idEmployee` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `idBuilding` int(11) NOT NULL,
  `date` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobposition`
--

CREATE TABLE `jobposition` (
  `id` int(11) NOT NULL,
  `idEmployee` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `jobposition`
--

INSERT INTO `jobposition` (`id`, `idEmployee`, `name`, `begindate`, `enddate`, `updated_at`, `created_at`) VALUES
(1, 4, 'Manager', '2012-06-15', '2012-06-15', '2018-07-25', '2018-07-25'),
(6, 12, 'CEO', '1980-10-09', '1980-10-09', '2018-07-25', '2018-07-25'),
(8, 14, 'President', '2012-03-23', '2012-03-23', '2018-07-25', '2018-07-25'),
(9, 15, 'Painting Jr', '1978-10-10', '1978-10-10', '2018-07-25', '2018-07-25'),
(10, 16, 'Software Developer', '1978-04-04', '1978-04-04', '2018-07-25', '2018-07-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `name`, `updated_at`, `created_at`, `idCondominium`) VALUES
(0, 'SuperUser', '2018-07-25', '2018-07-25', 0),
(1, 'Administrator', '2018-07-24', NULL, 15),
(2, 'Employee', '2018-07-24', NULL, 15),
(3, 'Human Resource', NULL, NULL, 15),
(6, 'Painting', '2018-07-25', '2018-07-24', 15),
(7, 'Cleaning', '2018-07-24', '2018-07-24', 15),
(8, 'Manager', '2018-07-24', '2018-07-24', 15),
(11, 'Watcherman', '2018-07-25', '2018-07-25', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `idRole` int(11) DEFAULT NULL,
  `idEmployee` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `idCondominium` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `idRole`, `idEmployee`, `updated_at`, `created_at`, `idCondominium`) VALUES
(2, 'jeleicy', 'efa9562b824820a468a6918b3476e8e5ccbe5d02', 0, 16, '2018-07-25', '2018-07-25', 0),
(3, 'juanrord', 'efa9562b824820a468a6918b3476e8e5ccbe5d02', 1, 15, '2018-07-25', '2018-07-25', 15),
(4, 'waltersilva', 'efa9562b824820a468a6918b3476e8e5ccbe5d02', 1, 4, '2018-07-25', '2018-07-25', 15);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activitiemployee`
--
ALTER TABLE `activitiemployee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEmployee` (`idEmployee`),
  ADD KEY `idBuilding` (`idBuilding`);

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `condominium`
--
ALTER TABLE `condominium`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idItem` (`idItem`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `itemused`
--
ALTER TABLE `itemused`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idItem` (`idItem`),
  ADD KEY `idEmployee` (`idEmployee`),
  ADD KEY `idBuilding` (`idBuilding`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `jobposition`
--
ALTER TABLE `jobposition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEmployee` (`idEmployee`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEmployee` (`idEmployee`),
  ADD KEY `idRole` (`idRole`),
  ADD KEY `idCondominium` (`idCondominium`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activitiemployee`
--
ALTER TABLE `activitiemployee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `condominium`
--
ALTER TABLE `condominium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `itemused`
--
ALTER TABLE `itemused`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jobposition`
--
ALTER TABLE `jobposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activitiemployee`
--
ALTER TABLE `activitiemployee`
  ADD CONSTRAINT `activitiemployee_ibfk_1` FOREIGN KEY (`idEmployee`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `activitiemployee_ibfk_2` FOREIGN KEY (`idBuilding`) REFERENCES `building` (`id`);

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`idItem`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `itemused`
--
ALTER TABLE `itemused`
  ADD CONSTRAINT `itemused_ibfk_1` FOREIGN KEY (`idItem`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `itemused_ibfk_2` FOREIGN KEY (`idEmployee`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `itemused_ibfk_3` FOREIGN KEY (`idBuilding`) REFERENCES `building` (`id`),
  ADD CONSTRAINT `itemused_ibfk_4` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `jobposition`
--
ALTER TABLE `jobposition`
  ADD CONSTRAINT `jobposition_ibfk_1` FOREIGN KEY (`idEmployee`) REFERENCES `employee` (`id`);

--
-- Filtros para la tabla `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idEmployee`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`idCondominium`) REFERENCES `condominium` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
