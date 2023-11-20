-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-11-2023 a las 23:28:23
-- Versión del servidor: 5.7.39
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ClinicaMedica`
--
CREATE DATABASE IF NOT EXISTS `ClinicaMedica` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ClinicaMedica`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Consultas`
--

CREATE TABLE `Consultas` (
  `ConsultaID` int(11) NOT NULL,
  `PacienteID` int(11) DEFAULT NULL,
  `MedicoID` int(11) DEFAULT NULL,
  `FechaConsulta` date DEFAULT NULL,
  `Diagnostico` text,
  `Foto` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Consultas`
--

INSERT INTO `Consultas` (`ConsultaID`, `PacienteID`, `MedicoID`, `FechaConsulta`, `Diagnostico`, `Foto`) VALUES
(1, 1, 1, '2023-01-10', 'Presión arterial alta', 'chevrolet.jpg'),
(2, 2, 4, '2023-02-15', 'Papiloma Humano', 'audi.jpg'),
(3, 3, 3, '2023-03-20', 'Problemas cutáneos', 'bmw.jpg'),
(4, 4, 4, '2023-04-25', 'Chequeo ginecológico', 'kia.jpg'),
(5, 5, 5, '2023-05-30', 'Examen ocular', 'ford.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Medicamentos`
--

CREATE TABLE `Medicamentos` (
  `MedicamentoID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Medicamentos`
--

INSERT INTO `Medicamentos` (`MedicamentoID`, `Nombre`, `Tipo`) VALUES
(1, 'Paracetamol', 'Analgésico'),
(2, 'Amoxicilina', 'Antibiótico'),
(3, 'Loratadina', 'Antihistamínico'),
(4, 'Omeprazol', 'Antiácido'),
(5, 'Aspirina', 'Antiinflamatorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Medicos`
--

CREATE TABLE `Medicos` (
  `MedicoID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Especialidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Medicos`
--

INSERT INTO `Medicos` (`MedicoID`, `Nombre`, `Especialidad`) VALUES
(1, 'Dr. Garcia', 'Cardiología'),
(2, 'Dra. Ramirez', 'Pediatría'),
(3, 'Dr. Martinez', 'Dermatología'),
(4, 'Dra. Lopez', 'Ginecología'),
(5, 'Dr. Rodriguez', 'Oftalmología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pacientes`
--

CREATE TABLE `Pacientes` (
  `PacienteID` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Genero` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pacientes`
--

INSERT INTO `Pacientes` (`PacienteID`, `Nombre`, `Edad`, `Genero`) VALUES
(1, 'Juan Perez', 30, 'Masculino'),
(2, 'Maria Rodriguez', 25, 'Femenino'),
(3, 'Carlos Sanchez', 40, 'Masculino'),
(4, 'Ana Gomez', 35, 'Femenino'),
(5, 'Luis Torres', 28, 'Masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Recetas`
--

CREATE TABLE `Recetas` (
  `RecetaID` int(11) NOT NULL,
  `ConsultaID` int(11) DEFAULT NULL,
  `MedicamentoID` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Recetas`
--

INSERT INTO `Recetas` (`RecetaID`, `ConsultaID`, `MedicamentoID`, `Cantidad`) VALUES
(1, 1, 1, 2),
(2, 2, 2, 1),
(3, 3, 3, 3),
(4, 4, 4, 1),
(5, 5, 5, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Consultas`
--
ALTER TABLE `Consultas`
  ADD PRIMARY KEY (`ConsultaID`),
  ADD KEY `PacienteID` (`PacienteID`),
  ADD KEY `MedicoID` (`MedicoID`);

--
-- Indices de la tabla `Medicamentos`
--
ALTER TABLE `Medicamentos`
  ADD PRIMARY KEY (`MedicamentoID`);

--
-- Indices de la tabla `Medicos`
--
ALTER TABLE `Medicos`
  ADD PRIMARY KEY (`MedicoID`);

--
-- Indices de la tabla `Pacientes`
--
ALTER TABLE `Pacientes`
  ADD PRIMARY KEY (`PacienteID`);

--
-- Indices de la tabla `Recetas`
--
ALTER TABLE `Recetas`
  ADD PRIMARY KEY (`RecetaID`),
  ADD KEY `ConsultaID` (`ConsultaID`),
  ADD KEY `MedicamentoID` (`MedicamentoID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Consultas`
--
ALTER TABLE `Consultas`
  MODIFY `ConsultaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Medicamentos`
--
ALTER TABLE `Medicamentos`
  MODIFY `MedicamentoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Medicos`
--
ALTER TABLE `Medicos`
  MODIFY `MedicoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Pacientes`
--
ALTER TABLE `Pacientes`
  MODIFY `PacienteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Recetas`
--
ALTER TABLE `Recetas`
  MODIFY `RecetaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Consultas`
--
ALTER TABLE `Consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`PacienteID`) REFERENCES `Pacientes` (`PacienteID`),
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`MedicoID`) REFERENCES `Medicos` (`MedicoID`);

--
-- Filtros para la tabla `Recetas`
--
ALTER TABLE `Recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`ConsultaID`) REFERENCES `Consultas` (`ConsultaID`),
  ADD CONSTRAINT `recetas_ibfk_2` FOREIGN KEY (`MedicamentoID`) REFERENCES `Medicamentos` (`MedicamentoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
